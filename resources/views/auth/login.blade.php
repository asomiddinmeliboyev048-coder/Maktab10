<!DOCTYPE html>
<html lang="uz">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Smart School | Tizimga kirish</title>

    <!-- Bootstrap CSS -->
    <link
        href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}"
        rel="stylesheet"
    >

    <!-- Bootstrap Icons -->
    <link
        href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}"
        rel="stylesheet"
    >

    <!-- NiceAdmin CSS -->
    <link
        href="{{ asset('assets/css/style.css') }}"
        rel="stylesheet"
    >

</head>

<body>

<main>

    <div class="container">

        <section
            class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4"
        >

            <div class="container">

                <div class="row justify-content-center">

                    <div
                        class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center"
                    >

                        <!-- Logo -->

                        <div class="d-flex justify-content-center py-4">

                            <a
                                href="{{ route('login') }}"
                                class="logo d-flex align-items-center w-auto"
                            >

                                <img
                                    src="{{ asset('assets/img/logo.png') }}"
                                    alt="Smart School"
                                >

                                <span class="d-none d-lg-block">
                                    Smart School
                                </span>

                            </a>

                        </div>


                        <!-- Login Card -->

                        <div class="card mb-3">

                            <div class="card-body">

                                <div class="pt-4 pb-2">

                                    <h5 class="card-title text-center pb-0 fs-4">
                                        Tizimga kirish
                                    </h5>

                                    <p class="text-center small">
                                        Email va parolingizni kiriting
                                    </p>

                                </div>


                                {{-- Success message --}}

                                @if(session('success'))

                                    <div class="alert alert-success">

                                        <i class="bi bi-check-circle me-1"></i>

                                        {{ session('success') }}

                                    </div>

                                @endif


                                {{-- Errors --}}

                                @if($errors->any())

                                    <div class="alert alert-danger">

                                        <ul class="mb-0">

                                            @foreach($errors->all() as $error)

                                                <li>
                                                    {{ $error }}
                                                </li>

                                            @endforeach

                                        </ul>

                                    </div>

                                @endif


                                <!-- Login Form -->

                                <form
                                    method="POST"
                                    action="{{ route('login.submit') }}"
                                    class="row g-3 needs-validation"
                                >

                                    @csrf


                                    <!-- Email -->

                                    <div class="col-12">

                                        <label
                                            for="email"
                                            class="form-label"
                                        >
                                            Email
                                        </label>

                                        <div class="input-group">

                                            <span class="input-group-text">
                                                <i class="bi bi-envelope"></i>
                                            </span>

                                            <input
                                                type="email"
                                                name="email"
                                                id="email"
                                                class="form-control"
                                                value="{{ old('email') }}"
                                                required
                                                autofocus
                                            >

                                        </div>

                                    </div>


                                    <!-- Password -->

                                    <div class="col-12">

                                        <label
                                            for="password"
                                            class="form-label"
                                        >
                                            Parol
                                        </label>

                                        <div class="input-group">

                                            <span class="input-group-text">
                                                <i class="bi bi-lock"></i>
                                            </span>

                                            <input
                                                type="password"
                                                name="password"
                                                id="password"
                                                class="form-control"
                                                required
                                            >

                                        </div>

                                    </div>


                                    <!-- Remember -->

                                    <div class="col-12">

                                        <div class="form-check">

                                            <input
                                                class="form-check-input"
                                                type="checkbox"
                                                name="remember"
                                                value="1"
                                                id="remember"
                                            >

                                            <label
                                                class="form-check-label"
                                                for="remember"
                                            >
                                                Meni eslab qolish
                                            </label>

                                        </div>

                                    </div>


                                    <!-- Login button -->

                                    <div class="col-12">

                                        <button
                                            type="submit"
                                            class="btn btn-primary w-100"
                                        >

                                            <i class="bi bi-box-arrow-in-right me-1"></i>

                                            Kirish

                                        </button>

                                    </div>

                                </form>

                            </div>

                        </div>


                        <div class="credits text-center">

                            Smart School Management System

                        </div>

                    </div>

                </div>

            </div>

        </section>

    </div>

</main>


<!-- Bootstrap JS -->

<script
    src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"
></script>

</body>

</html>
