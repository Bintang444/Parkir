<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — ParkSmart</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,300&family=Playfair+Display:wght@400;500&display=swap" rel="stylesheet">
    <style>
        :root {
            --navy:        #0d1b2e;
            --navy-mid:    #122540;
            --navy-light:  #1a3355;
            --navy-border: #1e3d63;
            --teal:        #4fb8c0;
            --teal-dim:    #3a9aa3;
            --rose:        #e8a0b0;
            --rose-dim:    #c8788e;
            --text-primary:   #e8edf2;
            --text-secondary: #8fa8be;
            --text-muted:     #5c7a96;
            --danger:  #f07070;
            --card-bg: #122540;
            --card-border: rgba(79, 184, 192, 0.14);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--navy);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            /* subtle ambient glow */
            background-image:
                radial-gradient(ellipse 70% 55% at 15% 10%, rgba(79, 184, 192, 0.08) 0%, transparent 65%),
                radial-gradient(ellipse 55% 45% at 85% 90%, rgba(232, 160, 176, 0.07) 0%, transparent 60%);
        }

        /* ── decorative dots grid ── */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image: radial-gradient(circle, rgba(79,184,192,0.07) 1px, transparent 1px);
            background-size: 36px 36px;
            pointer-events: none;
        }

        .card {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 20px;
            width: 100%;
            max-width: 420px;
            padding: 44px 40px 40px;
            position: relative;
            box-shadow: 0 32px 80px rgba(0,0,0,0.35), 0 0 0 1px rgba(79,184,192,0.06);
            animation: fadeUp 0.45s cubic-bezier(.22,.68,0,1.2) both;
        }
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px) scale(0.98); }
            to   { opacity: 1; transform: none; }
        }

        /* top accent line */
        .card::before {
            content: '';
            position: absolute;
            top: 0; left: 40px; right: 40px;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--teal), var(--rose-dim), transparent);
            border-radius: 0 0 4px 4px;
        }

        /* ── header ── */
        .header {
            text-align: center;
            margin-bottom: 34px;
        }

        .logo-wrap {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 58px;
            height: 58px;
            border-radius: 16px;
            background: linear-gradient(135deg, var(--teal), var(--rose-dim));
            font-size: 26px;
            margin-bottom: 18px;
            box-shadow: 0 8px 24px rgba(79,184,192,0.25);
        }

        .brand-name {
            font-family: 'Playfair Display', serif;
            font-size: 26px;
            font-weight: 500;
            color: var(--text-primary);
            letter-spacing: 0.01em;
            margin-bottom: 6px;
        }

        .brand-desc {
            font-size: 13px;
            color: var(--text-muted);
            font-weight: 300;
            letter-spacing: 0.04em;
        }

        /* ── divider ── */
        .divider {
            height: 1px;
            background: linear-gradient(to right, transparent, var(--navy-border), transparent);
            margin-bottom: 28px;
        }

        /* ── alert ── */
        .alert {
            padding: 11px 15px;
            margin-bottom: 22px;
            border-radius: 10px;
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 8px;
            animation: slideDown 0.25s ease;
        }
        @keyframes slideDown { from { opacity:0; transform:translateY(-4px); } to { opacity:1; } }

        .alert-error {
            background: rgba(240, 112, 112, 0.1);
            color: var(--danger);
            border: 1px solid rgba(240, 112, 112, 0.25);
        }

        /* ── form ── */
        .form-group {
            margin-bottom: 18px;
        }

        .form-label {
            display: block;
            font-size: 12.5px;
            font-weight: 600;
            color: var(--text-secondary);
            letter-spacing: 0.07em;
            text-transform: uppercase;
            margin-bottom: 8px;
        }

        .input-wrap {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 14px;
            pointer-events: none;
            transition: color 0.2s;
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
            outline: none;
            transition: all 0.2s;
        }
        .form-input::placeholder { color: var(--text-muted); }
        .form-input:focus {
            border-color: var(--teal);
            box-shadow: 0 0 0 3px rgba(79, 184, 192, 0.1);
        }
        .form-input:focus + .input-icon,
        .input-wrap:focus-within .input-icon { color: var(--teal); }

        .field-error {
            font-size: 12px;
            color: var(--danger);
            margin-top: 6px;
            display: block;
        }

        /* ── submit ── */
        .btn-login {
            width: 100%;
            padding: 13px;
            margin-top: 8px;
            background: linear-gradient(135deg, var(--teal) 0%, var(--teal-dim) 100%);
            color: #0d1b2e;
            border: none;
            border-radius: 11px;
            font-family: 'DM Sans', sans-serif;
            font-size: 14.5px;
            font-weight: 700;
            letter-spacing: 0.04em;
            cursor: pointer;
            transition: all 0.2s;
        }
        .btn-login:hover {
            opacity: 0.88;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(79, 184, 192, 0.3);
        }
        .btn-login:active { transform: translateY(0); }

        /* ── footer note ── */
        .footer-note {
            text-align: center;
            margin-top: 26px;
            font-size: 11.5px;
            color: var(--text-muted);
            letter-spacing: 0.03em;
        }

        .footer-note span {
            display: inline-block;
            width: 4px; height: 4px;
            background: var(--rose-dim);
            border-radius: 50%;
            vertical-align: middle;
            margin: 0 6px;
            opacity: 0.6;
        }

        @media (max-width: 480px) {
            .card { padding: 36px 24px 32px; }
        }
    </style>
</head>
<body>

    <div class="card">
        <div class="header">
            <div class="logo-wrap">🅿</div>
            <div class="brand-name">ParkSmart</div>
            <div class="brand-desc">Sistem Manajemen Parkir Terpadu</div>
        </div>

        <div class="divider"></div>

        @if(session('error'))
        <div class="alert alert-error">⚠ {{ session('error') }}</div>
        @endif

        <form method="POST" action="{{ route('login.process') }}">
            @csrf

            <div class="form-group">
                <label class="form-label" for="email">Email</label>
                <div class="input-wrap">
                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="form-input"
                        placeholder="nama@email.com"
                        required autofocus
                        value="{{ old('email') }}"
                    >
                    <span class="input-icon">✉</span>
                </div>
                @error('email')
                <small class="field-error">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="password">Password</label>
                <div class="input-wrap">
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="form-input"
                        placeholder="••••••••"
                        required
                    >
                    <span class="input-icon">◈</span>
                </div>
                @error('password')
                <small class="field-error">{{ $message }}</small>
                @enderror
            </div>

            <button type="submit" class="btn-login">Masuk</button>
        </form>

        <div class="footer-note">
            ParkSmart <span></span> v1.0 <span></span> Sistem Parkir Pintar
        </div>
    </div>

</body>
</html>