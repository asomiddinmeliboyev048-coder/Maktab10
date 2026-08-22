<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Ro‘yxatdan o‘tish</title>

    <!-- Bootstrap 5 -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <!-- Bootstrap Icons -->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            font-family: "Inter", "Segoe UI", Arial, sans-serif;
            background:
                radial-gradient(circle at top left, rgba(99, 102, 241, 0.35), transparent 35%),
                radial-gradient(circle at bottom right, rgba(139, 92, 246, 0.3), transparent 35%),
                linear-gradient(135deg, #0f172a 0%, #1e1b4b 50%, #312e81 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px 15px;
            position: relative;
            overflow-x: hidden;
        }

        /* Background circles */
        body::before,
        body::after {
            content: "";
            position: fixed;
            border-radius: 50%;
            filter: blur(2px);
            z-index: 0;
        }

        body::before {
            width: 300px;
            height: 300px;
            background: rgba(99, 102, 241, 0.15);
            top: -100px;
            left: -100px;
        }

        body::after {
            width: 350px;
            height: 350px;
            background: rgba(168, 85, 247, 0.12);
            bottom: -150px;
            right: -100px;
        }

        .register-wrapper {
            width: 100%;
            max-width: 1050px;
            position: relative;
            z-index: 2;
        }

        .register-card {
            background: rgba(255, 255, 255, 0.96);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-radius: 28px;
            overflow: hidden;
            box-shadow:
                0 30px 80px rgba(0, 0, 0, 0.35),
                0 10px 30px rgba(0, 0, 0, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        /* LEFT SIDE */
        .register-info {
            min-height: 650px;
            padding: 55px 45px;
            color: white;
            position: relative;
            overflow: hidden;
            background:
                linear-gradient(
                    145deg,
                    rgba(79, 70, 229, 0.98),
                    rgba(124, 58, 237, 0.95)
                );
        }

        .register-info::before {
            content: "";
            position: absolute;
            width: 260px;
            height: 260px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.08);
            top: -100px;
            right: -90px;
        }

        .register-info::after {
            content: "";
            position: absolute;
            width: 220px;
            height: 220px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.06);
            bottom: -100px;
            left: -80px;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 13px;
            position: relative;
            z-index: 2;
            margin-bottom: 70px;
        }

        .brand-icon {
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 15px;
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.25);
            font-size: 23px;
        }

        .brand-name {
            font-size: 22px;
            font-weight: 800;
            letter-spacing: -0.5px;
        }

        .info-content {
            position: relative;
            z-index: 2;
        }

        .info-content h1 {
            font-size: 42px;
            line-height: 1.15;
            font-weight: 800;
            letter-spacing: -1.5px;
            margin-bottom: 22px;
        }

        .info-content > p {
            font-size: 16px;
            line-height: 1.8;
            color: rgba(255, 255, 255, 0.82);
            margin-bottom: 35px;
            max-width: 430px;
        }

        .feature {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
        }

        .feature-icon {
            width: 42px;
            height: 42px;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.15);
        }

        .feature span {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.9);
        }

        /* RIGHT SIDE */
        .register-form-area {
            padding: 55px 50px;
            background: #ffffff;
        }

        .form-header {
            margin-bottom: 35px;
        }

        .form-header h2 {
            font-size: 30px;
            font-weight: 800;
            color: #111827;
            letter-spacing: -0.8px;
            margin-bottom: 8px;
        }

        .form-header p {
            color: #6b7280;
            font-size: 14px;
            margin: 0;
        }

        .form-group {
            margin-bottom: 22px;
        }

        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 700;
            color: #374151;
            margin-bottom: 9px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            font-size: 18px;
            z-index: 2;
            pointer-events: none;
        }

        .form-control {
            height: 54px;
            border-radius: 13px;
            border: 1.5px solid #e5e7eb;
            padding: 0 16px 0 48px;
            font-size: 14px;
            color: #111827;
            background: #f9fafb;
            transition: all 0.25s ease;
            box-shadow: none !important;
        }

        .form-control:focus {
            border-color: #6366f1;
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1) !important;
        }

        .form-control::placeholder {
            color: #9ca3af;
        }

        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            border: none;
            background: transparent;
            color: #9ca3af;
            cursor: pointer;
            font-size: 18px;
            padding: 4px;
            z-index: 3;
        }

        .password-toggle:hover {
            color: #6366f1;
        }

        .password-input {
            padding-right: 48px;
        }

        .invalid-feedback {
            display: block;
            font-size: 12px;
            margin-top: 7px;
        }

        .is-invalid {
            border-color: #ef4444 !important;
        }

        .register-button {
            width: 100%;
            height: 54px;
            border: none;
            border-radius: 13px;
            background: linear-gradient(
                135deg,
                #4f46e5,
                #7c3aed
            );
            color: #ffffff;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 10px 25px rgba(99, 102, 241, 0.25);
            margin-top: 5px;
        }

        .register-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 30px rgba(99, 102, 241, 0.35);
        }

        .register-button:active {
            transform: translateY(0);
        }

        .login-text {
            text-align: center;
            margin-top: 25px;
            font-size: 14px;
            color: #6b7280;
        }

        .login-text a {
            color: #4f46e5;
            text-decoration: none;
            font-weight: 700;
        }

        .login-text a:hover {
            text-decoration: underline;
        }

        .terms {
            margin-top: 20px;
            text-align: center;
            font-size: 11px;
            line-height: 1.6;
            color: #9ca3af;
        }

        .terms a {
            color: #6b7280;
            text-decoration: none;
        }

        /* Responsive */
        @media (max-width: 991px) {
            .register-info {
                min-height: auto;
                padding: 40px;
            }

            .brand {
                margin-bottom: 40px;
            }

            .info-content h1 {
                font-size: 35px;
            }

            .register-form-area {
                padding: 45px 40px;
            }
        }

        @media (max-width: 767px) {
            body {
                padding: 15px;
            }

            .register-card {
                border-radius: 20px;
            }

            .register-info {
                padding: 35px 25px;
            }

            .brand {
                margin-bottom: 35px;
            }

            .info-content h1 {
                font-size: 31px;
            }

            .info-content > p {
                font-size: 14px;
            }

            .feature {
                margin-bottom: 15px;
            }

            .register-form-area {
                padding: 35px 25px;
            }

            .form-header h2 {
                font-size: 26px;
            }
        }

        @media (max-width: 400px) {
            .register-info {
                padding: 28px 20px;
            }

            .register-form-area {
                padding: 30px 20px;
            }

            .info-content h1 {
                font-size: 27px;
            }
        }
    </style>
</head>

<body>

<div class="register-wrapper">

    <div class="register-card">

        <div class="row g-0">

            <!-- LEFT -->
            <div class="col-lg-6">

                <div class="register-info">

                    <div class="brand">
                        <div class="brand-icon">
                            <i class="bi bi-person-plus-fill"></i>
                        </div>

                        <div class="brand-name">
                            MyApp
                        </div>
                    </div>

                    <div class="info-content">

                        <h1>
                            Biz bilan<br>
                            yangi imkoniyatlarni<br>
                            boshlang.
                        </h1>

                        <p>
                            Hisob yaratish orqali platformamizning barcha
                            imkoniyatlaridan foydalaning va o‘z profilingizni
                            boshqaring.
                        </p>

                        <div class="feature">
                            <div class="feature-icon">
                                <i class="bi bi-shield-check"></i>
                            </div>

                            <span>
                                Ma'lumotlaringiz xavfsiz himoyalanadi
                            </span>
                        </div>

                        <div class="feature">
                            <div class="feature-icon">
                                <i class="bi bi-lightning-charge-fill"></i>
                            </div>

                            <span>
                                Tez va qulay foydalanish imkoniyati
                            </span>
                        </div>

                        <div class="feature">
                            <div class="feature-icon">
                                <i class="bi bi-people-fill"></i>
                            </div>

                            <span>
                                Zamonaviy va qulay platforma
                            </span>
                        </div>

                    </div>

                </div>

            </div>


            <!-- RIGHT -->
            <div class="col-lg-6">

                <div class="register-form-area">

                    <div class="form-header">

                        <h2>
                            Hisob yaratish
                        </h2>

                        <p>
                            Quyidagi ma'lumotlarni to‘ldirib ro‘yxatdan o‘ting.
                        </p>

                    </div>


                    <form method="POST" action="{{ route('register') }}">

                        @csrf


                        <!-- NAME -->
                        <div class="form-group">

                            <label for="name" class="form-label">
                                Ism
                            </label>

                            <div class="input-wrapper">

                                <i class="bi bi-person input-icon"></i>

                                <input
                                    id="name"
                                    type="text"
                                    class="form-control @error('name') is-invalid @enderror"
                                    name="name"
                                    value="{{ old('name') }}"
                                    placeholder="Ismingizni kiriting"
                                    required
                                    autocomplete="name"
                                    autofocus
                                >

                            </div>

                            @error('name')

                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>

                            @enderror

                        </div>


                        <!-- EMAIL -->
                        <div class="form-group">

                            <label for="email" class="form-label">
                                E-Mail manzil
                            </label>

                            <div class="input-wrapper">

                                <i class="bi bi-envelope input-icon"></i>

                                <input
                                    id="email"
                                    type="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    name="email"
                                    value="{{ old('email') }}"
                                    placeholder="example@gmail.com"
                                    required
                                    autocomplete="email"
                                >

                            </div>

                            @error('email')

                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>

                            @enderror

                        </div>


                        <!-- PASSWORD -->
                        <div class="form-group">

                            <label for="password" class="form-label">
                                Parol
                            </label>

                            <div class="input-wrapper">

                                <i class="bi bi-lock input-icon"></i>

                                <input
                                    id="password"
                                    type="password"
                                    class="form-control password-input @error('password') is-invalid @enderror"
                                    name="password"
                                    placeholder="Parolingizni kiriting"
                                    required
                                    autocomplete="new-password"
                                >

                                <button
                                    type="button"
                                    class="password-toggle"
                                    onclick="togglePassword('password', this)"
                                >
                                    <i class="bi bi-eye"></i>
                                </button>

                            </div>

                            @error('password')

                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>

                            @enderror

                        </div>


                        <!-- PASSWORD CONFIRM -->
                        <div class="form-group">

                            <label for="password-confirm" class="form-label">
                                Parolni tasdiqlang
                            </label>

                            <div class="input-wrapper">

                                <i class="bi bi-shield-lock input-icon"></i>

                                <input
                                    id="password-confirm"
                                    type="password"
                                    class="form-control password-input"
                                    name="password_confirmation"
                                    placeholder="Parolni qayta kiriting"
                                    required
                                    autocomplete="new-password"
                                >

                                <button
                                    type="button"
                                    class="password-toggle"
                                    onclick="togglePassword('password-confirm', this)"
                                >
                                    <i class="bi bi-eye"></i>
                                </button>

                            </div>

                        </div>


                        <!-- BUTTON -->
                        <button
                            type="submit"
                            class="register-button"
                        >
                            <i class="bi bi-person-plus me-2"></i>
                            Ro‘yxatdan o‘tish
                        </button>


                        <!-- LOGIN -->
                        <div class="login-text">

                            Hisobingiz allaqachon bormi?

                            <a href="{{ route('login') }}">
                                Kirish
                            </a>

                        </div>


                        <!-- TERMS -->
                        <div class="terms">

                            Ro‘yxatdan o‘tish orqali siz
                            <a href="#">
                                foydalanish shartlari
                            </a>
                            va
                            <a href="#">
                                maxfiylik siyosatiga
                            </a>
                            rozilik bildirasiz.

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>


<!-- Password Toggle -->
<script>

    function togglePassword(inputId, button) {

        const input = document.getElementById(inputId);
        const icon = button.querySelector("i");

        if (input.type === "password") {

            input.type = "text";

            icon.classList.remove("bi-eye");
            icon.classList.add("bi-eye-slash");

        } else {

            input.type = "password";

            icon.classList.remove("bi-eye-slash");
            icon.classList.add("bi-eye");

        }

    }

</script>

</body>
</html>