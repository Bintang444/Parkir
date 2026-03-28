<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Petugas — Sistem Parkir</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,300&family=Playfair+Display:wght@400;500&display=swap" rel="stylesheet">
    <style>
        :root {
            --navy: #0d1b2e;
            --navy-mid: #122540;
            --navy-light: #1a3355;
            --navy-border: #1e3d63;
            --navy-hover: #1f3f66;
            --teal: #4fb8c0;
            --teal-dim: #3a9aa3;
            --rose: #e8a0b0;
            --rose-dim: #c8788e;
            --cream: #f0ece4;
            --text-primary: #e8edf2;
            --text-secondary: #8fa8be;
            --text-muted: #5c7a96;
            --success: #5ec48a;
            --danger: #f07070;
            --warning: #f0b96a;
            --card-bg: #122540;
            --card-border: rgba(79, 184, 192, 0.12);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--navy);
            color: var(--text-primary);
            min-height: 100vh;
            background-image:
                radial-gradient(ellipse 80% 60% at 10% 0%, rgba(79, 184, 192, 0.06) 0%, transparent 60%),
                radial-gradient(ellipse 60% 40% at 90% 100%, rgba(232, 160, 176, 0.05) 0%, transparent 60%);
        }

        /* ── NAVBAR ── */
        .navbar {
            background: rgba(18, 37, 64, 0.95);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid var(--navy-border);
            padding: 0 40px;
            height: 68px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .brand-icon {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, var(--teal), var(--rose-dim));
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 17px;
            flex-shrink: 0;
        }

        .brand-text {
            display: flex;
            flex-direction: column;
            line-height: 1;
        }

        .brand-title {
            font-family: 'Playfair Display', serif;
            font-size: 17px;
            font-weight: 500;
            color: var(--text-primary);
            letter-spacing: 0.01em;
        }

        .brand-sub {
            font-size: 11px;
            color: var(--text-muted);
            letter-spacing: 0.08em;
            text-transform: uppercase;
            margin-top: 2px;
        }

        .navbar-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .user-pill {
            display: flex;
            align-items: center;
            gap: 9px;
            background: var(--navy-light);
            border: 1px solid var(--navy-border);
            border-radius: 24px;
            padding: 6px 14px 6px 8px;
        }

        .user-avatar {
            width: 26px;
            height: 26px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--rose), var(--teal));
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
        }

        .user-name {
            font-size: 13px;
            font-weight: 500;
            color: var(--text-primary);
        }

        .btn-logout {
            background: transparent;
            color: var(--text-muted);
            border: 1px solid var(--navy-border);
            padding: 7px 16px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 13px;
            font-family: 'DM Sans', sans-serif;
            font-weight: 500;
            transition: all 0.2s;
            letter-spacing: 0.02em;
        }
        .btn-logout:hover { border-color: var(--teal); color: var(--teal); }

        /* ── LAYOUT ── */
        .container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 36px 32px;
        }

        /* ── ALERTS ── */
        .alert {
            padding: 13px 18px;
            margin-bottom: 24px;
            border-radius: 10px;
            font-size: 13.5px;
            display: flex;
            align-items: center;
            gap: 10px;
            animation: slideDown 0.3s ease;
        }
        @keyframes slideDown { from { opacity: 0; transform: translateY(-6px); } to { opacity: 1; transform: none; } }

        .alert-success {
            background: rgba(94, 196, 138, 0.1);
            color: var(--success);
            border: 1px solid rgba(94, 196, 138, 0.25);
        }
        .alert-error {
            background: rgba(240, 112, 112, 0.1);
            color: var(--danger);
            border: 1px solid rgba(240, 112, 112, 0.25);
        }

        /* ── CARDS ── */
        .card {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 16px;
            padding: 28px 28px 24px;
            margin-bottom: 24px;
            transition: border-color 0.2s;
        }
        .card:hover { border-color: rgba(79, 184, 192, 0.22); }

        .card-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 22px;
        }

        .card-icon {
            width: 34px;
            height: 34px;
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            flex-shrink: 0;
        }
        .icon-teal { background: rgba(79, 184, 192, 0.15); }
        .icon-rose { background: rgba(232, 160, 176, 0.15); }
        .icon-blue { background: rgba(100, 149, 220, 0.15); }
        .icon-muted { background: rgba(143, 168, 190, 0.1); }

        .card-title {
            font-size: 15px;
            font-weight: 600;
            color: var(--text-primary);
            letter-spacing: 0.01em;
        }

        .card-subtitle {
            font-size: 11.5px;
            color: var(--text-muted);
            margin-top: 1px;
        }

        /* ── FORM CHECKIN ── */
        .checkin-form {
            display: flex;
            gap: 10px;
            align-items: stretch;
        }

        .input-wrapper {
            flex: 1;
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 15px;
            pointer-events: none;
        }

        .form-input {
            width: 100%;
            padding: 12px 14px 12px 40px;
            background: var(--navy);
            border: 1.5px solid var(--navy-border);
            border-radius: 10px;
            color: var(--text-primary);
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
            transition: all 0.2s;
            outline: none;
        }
        .form-input::placeholder { color: var(--text-muted); }
        .form-input:focus {
            border-color: var(--teal);
            box-shadow: 0 0 0 3px rgba(79, 184, 192, 0.1);
        }

        /* ── BUTTONS ── */
        .btn {
            padding: 11px 20px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-size: 13.5px;
            font-weight: 600;
            font-family: 'DM Sans', sans-serif;
            transition: all 0.2s;
            letter-spacing: 0.02em;
            white-space: nowrap;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--teal), #3a9aa3);
            color: #0d1b2e;
        }
        .btn-primary:hover { opacity: 0.88; transform: translateY(-1px); box-shadow: 0 4px 14px rgba(79, 184, 192, 0.3); }

        .btn-success {
            background: rgba(94, 196, 138, 0.15);
            color: var(--success);
            border: 1px solid rgba(94, 196, 138, 0.3);
        }
        .btn-success:hover { background: rgba(94, 196, 138, 0.25); }

        .btn-danger {
            background: rgba(240, 112, 112, 0.12);
            color: var(--danger);
            border: 1px solid rgba(240, 112, 112, 0.3);
        }
        .btn-danger:hover { background: rgba(240, 112, 112, 0.22); }

        .btn-sm {
            padding: 7px 13px;
            font-size: 12.5px;
            border-radius: 8px;
        }

        /* ── TABLE ── */
        .table-wrap { overflow-x: auto; }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead tr {
            border-bottom: 1px solid var(--navy-border);
        }

        th {
            padding: 10px 14px;
            text-align: left;
            font-size: 11.5px;
            font-weight: 600;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.07em;
        }

        td {
            padding: 13px 14px;
            font-size: 13.5px;
            border-bottom: 1px solid rgba(30, 61, 99, 0.5);
            vertical-align: middle;
        }

        tbody tr { transition: background 0.15s; }
        tbody tr:last-child td { border-bottom: none; }
        tbody tr:hover td { background: rgba(79, 184, 192, 0.04); }

        .cell-id {
            font-family: 'DM Mono', 'Courier New', monospace;
            font-size: 13px;
            font-weight: 600;
            color: var(--teal);
            letter-spacing: 0.04em;
        }

        .cell-time-main { font-size: 14px; font-weight: 500; }
        .cell-time-sub { font-size: 11.5px; color: var(--text-muted); margin-top: 2px; }

        .duration-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: rgba(79, 184, 192, 0.1);
            color: var(--teal);
            border-radius: 6px;
            padding: 3px 10px;
            font-size: 12.5px;
            font-weight: 600;
        }

        .fee-main {
            font-size: 15px;
            font-weight: 700;
            color: var(--rose);
        }
        .fee-sub {
            font-size: 11px;
            color: var(--text-muted);
            margin-top: 2px;
        }

        /* ── EMPTY STATE ── */
        .empty-state {
            text-align: center;
            padding: 40px 20px;
        }
        .empty-icon {
            font-size: 32px;
            margin-bottom: 10px;
            opacity: 0.35;
        }
        .empty-state p {
            font-size: 13.5px;
            color: var(--text-muted);
            font-style: italic;
        }

        /* ── DIVIDER ── */
        .section-divider {
            height: 1px;
            background: linear-gradient(to right, transparent, var(--navy-border), transparent);
            margin: 4px 0 20px;
        }

        /* ── RESPONSIVE ── */
        @media (max-width: 768px) {
            .navbar { padding: 0 20px; }
            .container { padding: 24px 16px; }
            .card { padding: 20px 16px; }
            .checkin-form { flex-direction: column; }
            th, td { padding: 10px; }
            .brand-sub { display: none; }
        }
    </style>
</head>
<body>

    <!-- NAVBAR -->
    <nav class="navbar">
        <div class="navbar-brand">
            <div class="brand-icon">🅿</div>
            <div class="brand-text">
                <span class="brand-title">ParkSmart</span>
                <span class="brand-sub">Dashboard Petugas</span>
            </div>
        </div>
        <div class="navbar-right">
            <div class="user-pill">
                <div class="user-avatar">✦</div>
                <span class="user-name">{{ auth()->user()->name }}</span>
            </div>
            <form action="{{ route('logout') }}" method="POST" style="margin:0">
                @csrf
                <button type="submit" class="btn-logout">Keluar</button>
            </form>
        </div>
    </nav>

    <div class="container">

        <!-- ALERTS -->
        @if(session('success'))
        <div class="alert alert-success">✦ {{ session('success') }}</div>
        @endif
        @if(session('error'))
        <div class="alert alert-error">⚠ {{ session('error') }}</div>
        @endif

        <!-- CHECK-IN -->
        <div class="card">
            <div class="card-header">
                <div class="card-icon icon-teal">⬇</div>
                <div>
                    <div class="card-title">Check-In Kendaraan</div>
                    <div class="card-subtitle">Scan atau masukkan ID kartu RFID</div>
                </div>
            </div>
            <div class="section-divider"></div>
            <form method="POST" action="/petugas/checkin" class="checkin-form">
                @csrf
                <div class="input-wrapper">
                    <span class="input-icon">⬡</span>
                    <input
                        type="text"
                        name="card_id"
                        class="form-input"
                        placeholder="Scan kartu RFID kendaraan..."
                        required autofocus
                    >
                </div>
                <button type="submit" class="btn btn-primary">Check-In</button>
            </form>
            @error('card_id')
            <small style="color:var(--danger); display:block; margin-top:8px; font-size:12.5px;">{{ $message }}</small>
            @enderror
        </div>

        <!-- SEDANG PARKIR -->
        <div class="card">
            <div class="card-header">
                <div class="card-icon icon-blue">◈</div>
                <div>
                    <div class="card-title">Kendaraan Sedang Parkir</div>
                    <div class="card-subtitle">Aktif saat ini di area parkir</div>
                </div>
            </div>
            <div class="section-divider"></div>
            @if($checkin->isEmpty())
            <div class="empty-state">
                <div class="empty-icon">◌</div>
                <p>Tidak ada kendaraan yang sedang parkir</p>
            </div>
            @else
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Kartu ID</th>
                            <th>Waktu Masuk</th>
                            <th>Durasi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($checkin as $index => $p)
                        <tr>
                            <td style="color:var(--text-muted); font-size:12.5px;">{{ $index + 1 }}</td>
                            <td><span class="cell-id">{{ $p->card_id }}</span></td>
                            <td>
                                <div class="cell-time-main">{{ $p->checkin_time->format('H:i') }}</div>
                                <div class="cell-time-sub">{{ $p->checkin_time->format('d M Y') }}</div>
                            </td>
                            <td>
                                @php
                                    $minutes = $p->checkin_time->diffInMinutes(now());
                                    $hours = floor($minutes / 60);
                                    $mins = $minutes % 60;
                                @endphp
                                <span class="duration-badge">⏱ {{ $hours }}j {{ $mins }}m</span>
                            </td>
                            <td>
                                <form method="POST" action="/petugas/checkout" style="display:inline">
                                    @csrf
                                    <input type="hidden" name="card_id" value="{{ $p->card_id }}">
                                    <button type="submit" class="btn btn-success btn-sm">Checkout</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>

        <!-- MENUNGGU PEMBAYARAN -->
        <div class="card">
            <div class="card-header">
                <div class="card-icon icon-rose">◇</div>
                <div>
                    <div class="card-title">Menunggu Pembayaran &amp; Keluar</div>
                    <div class="card-subtitle">Transaksi siap diselesaikan</div>
                </div>
            </div>
            <div class="section-divider"></div>
            @if($checkout->isEmpty())
            <div class="empty-state">
                <div class="empty-icon">◌</div>
                <p>Tidak ada transaksi yang menunggu pembayaran</p>
            </div>
            @else
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Kartu ID</th>
                            <th>Durasi</th>
                            <th>Total Biaya</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($checkout as $index => $p)
                        <tr>
                            <td style="color:var(--text-muted); font-size:12.5px;">{{ $index + 1 }}</td>
                            <td><span class="cell-id">{{ $p->card_id }}</span></td>
                            <td><span class="duration-badge">⏱ {{ $p->duration }} jam</span></td>
                            <td>
                                <div class="fee-main">Rp {{ number_format($p->fee, 0, ',', '.') }}</div>
                                <div class="fee-sub">Rp {{ number_format($p->fee / $p->duration, 0, ',', '.') }} / jam</div>
                            </td>
                            <td>
                                <form method="POST" action="/petugas/selesai/{{ $p->id }}" style="display:inline">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm">Buka Palang</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>

        <!-- RIWAYAT -->
        <div class="card">
            <div class="card-header">
                <div class="card-icon icon-muted">≡</div>
                <div>
                    <div class="card-title">Riwayat Transaksi</div>
                    <div class="card-subtitle">15 transaksi terakhir</div>
                </div>
            </div>
            <div class="section-divider"></div>
            @if($riwayat->isEmpty())
            <div class="empty-state">
                <div class="empty-icon">◌</div>
                <p>Belum ada riwayat transaksi</p>
            </div>
            @else
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
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
                            <td style="color:var(--text-muted); font-size:12.5px;">{{ $index + 1 }}</td>
                            <td><span class="cell-id">{{ $p->card_id }}</span></td>
                            <td>
                                <div class="cell-time-main">{{ $p->checkin_time->format('H:i') }}</div>
                                <div class="cell-time-sub">{{ $p->checkin_time->format('d M') }}</div>
                            </td>
                            <td>
                                <div class="cell-time-main">{{ $p->checkout_time->format('H:i') }}</div>
                                <div class="cell-time-sub">{{ $p->checkout_time->format('d M') }}</div>
                            </td>
                            <td><span class="duration-badge">{{ $p->duration }}j</span></td>
                            <td><strong style="color:var(--text-primary);">Rp {{ number_format($p->fee, 0, ',', '.') }}</strong></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>

    </div>
</body>
</html>