<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Petugas - Sistem Parkir Pintar</title>
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

        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            font-size: 14px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
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
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .form-checkin {
            display: flex;
            gap: 10px;
        }

        .form-checkin input {
            flex: 1;
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 5px;
            font-size: 14px;
        }

        .form-checkin input:focus {
            outline: none;
            border-color: #667eea;
        }

        .btn {
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
        }

        .btn-success {
            background: #28a745;
            color: white;
        }

        .btn-success:hover {
            background: #218838;
        }

        .btn-danger {
            background: #dc3545;
            color: white;
        }

        .btn-danger:hover {
            background: #c82333;
        }

        .btn-sm {
            padding: 8px 12px;
            font-size: 12px;
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

        .badge-info {
            background: #d1ecf1;
            color: #0c5460;
        }

        .badge-warning {
            background: #fff3cd;
            color: #856404;
        }

        .empty-state {
            text-align: center;
            padding: 40px;
            color: #999;
        }

        .empty-state p {
            font-size: 14px;
        }

        .grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        @media (max-width: 768px) {
            .grid-2 {
                grid-template-columns: 1fr;
            }

            .navbar {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }

            .navbar-info {
                flex-direction: column;
                gap: 10px;
            }

            .form-checkin {
                flex-direction: column;
            }

            table {
                font-size: 12px;
            }

            table th, table td {
                padding: 8px;
            }
        }

        .time-info {
            font-size: 12px;
            color: #666;
        }

        .fee-highlight {
            font-size: 18px;
            font-weight: 700;
            color: #667eea;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <h1>🅿️ Dashboard Petugas Parkir</h1>
        <div class="navbar-info">
            <span>👤 {{ auth()->user()->name }}</span>
            <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                @csrf
                <button type="submit" class="btn-logout">Logout</button>
            </form>
        </div>
    </div>

    <div class="container">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
        @endif

        {{-- CHECK-IN SECTION --}}
        <div class="section">
            <div class="section-title">📥 Check-In Kendaraan</div>
            <form method="POST" action="/petugas/checkin" class="form-checkin">
                @csrf
                <input 
                    type="text" 
                    name="card_id" 
                    placeholder="Scan kartu RFID kendaraan..." 
                    required 
                    autofocus
                >
                <button type="submit" class="btn btn-primary">Check-In</button>
            </form>
            @error('card_id')
                <small style="color: #dc3545; display: block; margin-top: 5px;">{{ $message }}</small>
            @enderror
        </div>

        {{-- SEDANG PARKIR SECTION --}}
        <div class="section">
            <div class="section-title">🚗 Kendaraan Sedang Parkir</div>
            @if($checkin->isEmpty())
                <div class="empty-state">
                    <p>Tidak ada kendaraan yang sedang parkir</p>
                </div>
            @else
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kartu ID</th>
                            <th>Waktu Masuk</th>
                            <th>Durasi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($checkin as $index => $p)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td><strong>{{ $p->card_id }}</strong></td>
                            <td>
                                <div>{{ $p->checkin_time->format('H:i') }}</div>
                                <div class="time-info">{{ $p->checkin_time->format('d M Y') }}</div>
                            </td>
                            <td>
                                @php
                                    $minutes = $p->checkin_time->diffInMinutes(now());
                                    $hours = floor($minutes / 60);
                                    $mins = $minutes % 60;
                                @endphp
                                {{ $hours }}h {{ $mins }}m
                            </td>
                            <td>
                                <form method="POST" action="/petugas/checkout" style="display: inline;">
                                    @csrf
                                    <input type="hidden" name="card_id" value="{{ $p->card_id }}">
                                    <button type="submit" class="btn btn-success btn-sm">Checkout</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

        {{-- CHECKOUT SECTION --}}
        <div class="section">
            <div class="section-title">🧾 Menunggu Pembayaran & Keluar</div>
            @if($checkout->isEmpty())
                <div class="empty-state">
                    <p>Tidak ada transaksi yang menunggu pembayaran</p>
                </div>
            @else
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kartu ID</th>
                            <th>Durasi</th>
                            <th>Total Biaya</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($checkout as $index => $p)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td><strong>{{ $p->card_id }}</strong></td>
                            <td>{{ $p->duration }} jam</td>
                            <td>
                                <div class="fee-highlight">Rp {{ number_format($p->fee, 0, ',', '.') }}</div>
                                <div class="time-info">Rp {{ number_format($p->fee / $p->duration, 0, ',', '.') }}/jam</div>
                            </td>
                            <td>
                                <form method="POST" action="/petugas/selesai/{{ $p->id }}" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm">Palang Terbuka</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

        {{-- RIWAYAT SECTION --}}
        <div class="section">
            <div class="section-title">📋 Riwayat Transaksi (15 Terakhir)</div>
            @if($riwayat->isEmpty())
                <div class="empty-state">
                    <p>Belum ada riwayat transaksi</p>
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
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($riwayat as $index => $p)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td><strong>{{ $p->card_id }}</strong></td>
                            <td>
                                <div>{{ $p->checkin_time->format('H:i') }}</div>
                                <div class="time-info">{{ $p->checkin_time->format('d M') }}</div>
                            </td>
                            <td>
                                <div>{{ $p->checkout_time->format('H:i') }}</div>
                                <div class="time-info">{{ $p->checkout_time->format('d M') }}</div>
                            </td>
                            <td>{{ $p->duration }} jam</td>
                            <td>
                                <strong>Rp {{ number_format($p->fee, 0, ',', '.') }}</strong>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</body>
</html>