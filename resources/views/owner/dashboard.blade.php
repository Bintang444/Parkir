<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Owner - Sistem Parkir Pintar</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f7fa;
            color: #333;
        }

        .navbar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .navbar h1 {
            font-size: 24px;
        }

        .navbar-info {
            display: flex;
            gap: 20px;
            align-items: center;
        }

        .navbar-info span {
            font-size: 14px;
        }

        .btn-logout {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 1px solid white;
            padding: 8px 16px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            transition: background 0.3s;
        }

        .btn-logout:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 30px 20px;
        }

        .section {
            background: white;
            border-radius: 8px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .section-title {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 20px;
            color: #333;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(102, 126, 234, 0.2);
        }

        .stat-card.alt1 {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }

        .stat-card.alt2 {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }

        .stat-card.alt3 {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        }

        .stat-label {
            font-size: 14px;
            opacity: 0.9;
            margin-bottom: 10px;
        }

        .stat-value {
            font-size: 32px;
            font-weight: 700;
        }

        .stat-subtext {
            font-size: 12px;
            opacity: 0.8;
            margin-top: 10px;
        }

        .filter-group {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .filter-group input,
        .filter-group select {
            padding: 10px 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }

        .btn {
            padding: 10px 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table th {
            background: #f8f9fa;
            padding: 12px;
            text-align: left;
            font-weight: 600;
            border-bottom: 2px solid #dee2e6;
            color: #495057;
        }

        table td {
            padding: 12px;
            border-bottom: 1px solid #dee2e6;
        }

        table tr:hover {
            background: #f8f9fa;
        }

        .badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-done {
            background: #d4edda;
            color: #155724;
        }

        .empty-state {
            text-align: center;
            padding: 40px;
            color: #999;
        }

        .empty-state p {
            font-size: 14px;
        }

        .chart-placeholder {
            background: #f8f9fa;
            border: 2px dashed #ddd;
            border-radius: 5px;
            padding: 40px;
            text-align: center;
            color: #999;
            margin-top: 20px;
        }

        @media (max-width: 768px) {
            .navbar {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }

            .navbar-info {
                flex-direction: column;
                gap: 10px;
            }

            .stat-value {
                font-size: 24px;
            }

            .filter-group {
                flex-direction: column;
            }

            .filter-group input,
            .filter-group select {
                width: 100%;
            }

            table {
                font-size: 12px;
            }

            table th, table td {
                padding: 8px;
            }
        }
    </style>
</head>
<body>
    <div class="navbar">
        <h1>🅿️ Dashboard Owner - Laporan Parkir</h1>
        <div class="navbar-info">
            <span>👤 {{ auth()->user()->name }}</span>
            <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                @csrf
                <button type="submit" class="btn-logout">Logout</button>
            </form>
        </div>
    </div>

    <div class="container">
        {{-- STATISTIK UTAMA --}}
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-label">Kendaraan Sedang Parkir</div>
                <div class="stat-value">{{ $sedangParkir }}</div>
                <div class="stat-subtext">Mencari tempat atau sedang parkir</div>
            </div>

            <div class="stat-card alt1">
                <div class="stat-label">Total Transaksi Hari Ini</div>
                <div class="stat-value">{{ $totalTransaksiHariIni }}</div>
                <div class="stat-subtext">Kendaraan yang selesai parkir</div>
            </div>

            <div class="stat-card alt2">
                <div class="stat-label">Pendapatan Hari Ini</div>
                <div class="stat-value">Rp {{ number_format($pendapatanHariIni, 0, ',', '.') }}</div>
                <div class="stat-subtext">Total biaya parkir</div>
            </div>

            <div class="stat-card alt3">
                <div class="stat-label">Rata-rata Durasi</div>
                <div class="stat-value">{{ $rataRataDurasi }}h</div>
                <div class="stat-subtext">Durasi parkir rata-rata</div>
            </div>
        </div>

        {{-- LAPORAN DETAIL --}}
        <div class="section">
            <div class="section-title">📊 Laporan Transaksi Harian</div>

            <div class="filter-group">
                <input type="date" id="filterDate" value="{{ date('Y-m-d') }}">
                <button type="button" onclick="filterByDate()" class="btn">Filter</button>
                <button type="button" onclick="resetFilter()" class="btn" style="background: #6c757d;">Reset</button>
            </div>

            @if($transaksiHariIni->isEmpty())
                <div class="empty-state">
                    <p>Belum ada transaksi untuk tanggal ini</p>
                </div>
            @else
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kartu ID</th>
                            <th>Check-In</th>
                            <th>Check-Out</th>
                            <th>Durasi</th>
                            <th>Biaya</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transaksiHariIni as $index => $t)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td><strong>{{ $t->card_id }}</strong></td>
                            <td>
                                <div>{{ $t->checkin_time->format('H:i') }}</div>
                                <div style="font-size: 11px; color: #999;">{{ $t->checkin_time->format('d M Y') }}</div>
                            </td>
                            <td>
                                @if($t->checkout_time)
                                    <div>{{ $t->checkout_time->format('H:i') }}</div>
                                    <div style="font-size: 11px; color: #999;">{{ $t->checkout_time->format('d M Y') }}</div>
                                @else
                                    <span style="color: #999;">-</span>
                                @endif
                            </td>
                            <td>
                                @if($t->duration)
                                    {{ $t->duration }} jam
                                @else
                                    <span style="color: #999;">-</span>
                                @endif
                            </td>
                            <td>
                                @if($t->fee)
                                    <strong>Rp {{ number_format($t->fee, 0, ',', '.') }}</strong>
                                @else
                                    <span style="color: #999;">-</span>
                                @endif
                            </td>
                            <td>
                                @if($t->status === 'IN')
                                    <span class="badge" style="background: #cce5ff; color: #004085;">Sedang Parkir</span>
                                @elseif($t->status === 'OUT')
                                    <span class="badge" style="background: #fff3cd; color: #856404;">Menunggu Bayar</span>
                                @else
                                    <span class="badge badge-done">Selesai</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

        {{-- RINGKASAN KEUANGAN --}}
        <div class="section">
            <div class="section-title">💰 Ringkasan Keuangan</div>

            <table style="max-width: 500px;">
                <tr>
                    <td style="border: none; padding: 15px 0; font-weight: 600;">Total Transaksi Selesai</td>
                    <td style="border: none; padding: 15px 0; text-align: right; font-weight: 600; color: #667eea;">{{ $totalTransaksiSelesai }}</td>
                </tr>
                <tr>
                    <td style="border: none; padding: 15px 0;">Total Pendapatan</td>
                    <td style="border: none; padding: 15px 0; text-align: right; font-size: 18px; font-weight: 700; color: #28a745;">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td style="border: none; padding: 15px 0;">Rata-rata Pendapatan/Jam</td>
                    <td style="border: none; padding: 15px 0; text-align: right;">Rp {{ number_format($rataRataPendapatan, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td style="border: none; padding: 15px 0;">Total Jam Parkir</td>
                    <td style="border: none; padding: 15px 0; text-align: right;">{{ $totalJamParkir }} jam</td>
                </tr>
            </table>
        </div>

        {{-- STATISTIK LAINNYA --}}
        <div class="section">
            <div class="section-title">📈 Statistik Tambahan</div>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
                <div>
                    <h4 style="color: #667eea; margin-bottom: 10px;">Transaksi Bulanan</h4>
                    <div class="chart-placeholder">
                        <p>📊 Chart data bulanan akan ditampilkan di sini</p>
                    </div>
                </div>
                <div>
                    <h4 style="color: #667eea; margin-bottom: 10px;">Pendapatan Bulanan</h4>
                    <div class="chart-placeholder">
                        <p>💹 Chart pendapatan bulanan akan ditampilkan di sini</p>
                    </div>
                </div>
                <div>
                    <h4 style="color: #667eea; margin-bottom: 10px;">Distribusi Waktu Parkir</h4>
                    <div class="chart-placeholder">
                        <p>⏱️ Chart distribusi durasi parkir akan ditampilkan di sini</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function filterByDate() {
            const date = document.getElementById('filterDate').value;
            if (date) {
                window.location.href = `/owner/?date=${date}`;
            }
        }

        function resetFilter() {
            window.location.href = `/owner/`;
        }
    </script>
</body>
</html>