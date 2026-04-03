<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ParkirTransaksi;
use App\Services\MqttService;
use Carbon\Carbon;

class PetugasController extends Controller
{
    /**
     * JSON endpoint untuk polling real-time
     */
    public function data()
    {
        return response()->json([
            'checkin'  => ParkirTransaksi::where('status', 'IN')->orderBy('checkin_time', 'desc')->get(),
            'checkout' => ParkirTransaksi::where('status', 'OUT')->orderBy('checkout_time', 'desc')->get(),
            'riwayat'  => ParkirTransaksi::where('status', 'DONE')->latest()->limit(15)->get(),
        ]);
    }

    /**
     */
    public function index()
    {
        return view('petugas.index', [
            'checkin'  => ParkirTransaksi::where('status', 'IN')->orderBy('checkin_time', 'desc')->get(),
            'checkout' => ParkirTransaksi::where('status', 'OUT')->orderBy('checkout_time', 'desc')->get(),
            'riwayat'  => ParkirTransaksi::where('status', 'DONE')->latest()->limit(15)->get(),
        ]);
    }

    /**
     * CHECK-IN: Kendaraan masuk parkir
     * - Validasi RFID dari kartu
     * - Cek apakah sudah ada yang check-in dengan RFID yang sama
     */
    public function checkin(Request $request)
    {
        $validated = $request->validate([
            'rfid' => 'required|string|min:3',
        ], [
            'rfid.required' => 'Silakan scan kartu RFID',
            'rfid.min' => 'RFID tidak valid',
        ]);

        // Cegah double check-in dengan RFID yang sama
        $exists = ParkirTransaksi::where('card_id', $validated['rfid'])
            ->whereIn('status', ['IN', 'OUT'])
            ->first();

        if ($exists) {
            return back()->with('error', 'RFID sudah check-in. Lakukan checkout terlebih dahulu.');
        }

        ParkirTransaksi::create([
            'card_id'      => $validated['rfid'],
            'checkin_time' => now(),
            'status'       => 'IN',
        ]);

        return back()->with('success', '✅ Check-in berhasil! Selamat datang.');
    }

    /**
     * CHECK-OUT: Kendaraan akan keluar parkir
     * - Validasi RFID dari kartu
     * - Hitung durasi parkir (dibulatkan ke atas per jam)
     * - Hitung tarif berdasarkan config
     * - Update status menjadi OUT (menunggu pembayaran)
     */
    public function checkout(Request $request)
    {
        $validated = $request->validate([
            'card_id' => 'required|string|min:3',
        ], [
            'card_id.required' => 'Silakan scan kartu RFID',
        ]);

        // Cari transaksi yang sedang parkir dengan card_id (status IN)
        $transaksi = ParkirTransaksi::where('card_id', $validated['card_id'])
            ->where('status', 'IN')
            ->first();

        if (!$transaksi) {
            return back()->with('error', '❌ RFID tidak ditemukan atau belum check-in.');
        }

        // Hitung durasi parkir (dibulatkan ke atas)
        $checkoutTime = now();
        $durationMinutes = Carbon::parse($transaksi->checkin_time)->diffInMinutes($checkoutTime);
        $durationHours = ceil($durationMinutes / 60);

        // Jika kurang dari 1 jam, charge 1 jam
        $durationHours = max($durationHours, 1);

        // Ambil tarif dari config
        $tarifPerJam = config('parking.tarif_per_jam', 2000);
        $totalFee = $durationHours * $tarifPerJam;

        // Update transaksi
        $transaksi->update([
            'checkout_time' => $checkoutTime,
            'duration'      => $durationHours,
            'fee'           => $totalFee,
            'status'        => 'OUT', // Menunggu pembayaran & pembukaan palang
        ]);

        return back()->with('success', '✅ Checkout berhasil. Total biaya: Rp ' . number_format($totalFee));
    }

    /**
     * SELESAI: Kendaraan keluar (palang sudah dibuka)
     * - Status berubah dari OUT menjadi DONE
     * - Data transaksi pindah ke riwayat
     */
    public function selesai($id)
    {
        $transaksi = ParkirTransaksi::where('id', $id)
            ->where('status', 'OUT')
            ->first();

        if (!$transaksi) {
            return back()->with('error', '❌ Transaksi tidak ditemukan atau tidak valid.');
        }

        $transaksi->update([
            'status' => 'DONE'
        ]);

        // Gunakan client_id unik agar tidak bentrok dengan mqtt:listen
        try {
            $mqtt = new MqttService('laravel-web-' . uniqid());
            $mqtt->connect();
            $mqtt->publish(MqttService::getExitServoTopic(), 'OPEN');
            $mqtt->publish(MqttService::getLcdTopic(), 'Terima Kasih|Selamat Jalan');
            $mqtt->disconnect();
        } catch (\Exception $e) {
            \Log::warning('MQTT publish gagal saat buka palang: ' . $e->getMessage());
        }

        return back()->with('success', '✅ Kendaraan keluar. Palang sudah dibuka!');
    }
}