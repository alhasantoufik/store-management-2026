<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    @include('backend.partials.style')

    <style>
        body {
            background: #eef2f7;
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
        }

        .login-wrapper {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 15px; /* Mobile-e pashe ektu jaiga thakbe */
        }

        .login-card {
            width: 100%;
            max-width: 450px; /* Desktop-e width control korbe */
            background: white;
            border-radius: 12px;
            padding: 40px 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        }

        .login-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: #1d3557;
            margin-bottom: 25px;
            text-align: center;
        }

        label {
            font-weight: 600;
            color: #4a5568;
            margin-bottom: 8px;
            display: block;
        }

        .form-control {
            border-radius: 8px;
            padding: 12px 15px;
            border: 1px solid #d4d8e0;
            font-size: 16px; /* Mobile-e auto-zoom bondho korbe */
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #1d72b8;
            box-shadow: 0 0 0 3px rgba(29, 114, 184, 0.15);
        }

        .btn-primary {
            padding: 12px;
            font-size: 1rem;
            font-weight: 600;
            border-radius: 8px;
            background-color: #1d72b8;
            border: none;
            width: 100%;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #125a94;
        }

        /* Responsive Fixes for Mobile */
        @media (max-width: 576px) {
            .login-wrapper {
                padding: 10px;
            }
            .login-card {
                padding: 30px 20px; /* Mobile-e card-er vitorer padding komano hoyeche */
                border-radius: 10px;
            }
            .login-title {
                font-size: 1.5rem;
            }
        }
    </style>
</head>

@php
    $systemSetting = App\Models\SystemSetting::first();
@endphp

<body>
    <div class="login-wrapper">
        <div class="login-card">

            <h1 class="login-title">{{ $systemSetting->title ?? 'Login' }}</h1>

            @auth
                <div class="text-center mb-4">
                    <h3>You are already logged in</h3>
                    <p>Click below to access your dashboard.</p>
                </div>

                <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">
                    Go to Dashboard
                </a>
            @else

                <form action="{{ route('login') }}" method="POST">
                    @csrf

                    @if (session('status'))
                        <div class="alert alert-info mb-3" style="color: #055160; background: #cff4fc; padding: 10px; border-radius: 5px;">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control w-100" placeholder="Enter your email" required value="{{ old('email') }}">
                        @error('email')
                            <span style="color: red; font-size: 13px;">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label>Password</label>
                        <div style="display: flex;">
                            <input type="password" name="password" id="password" class="form-control" style="flex: 1; border-radius: 8px 0 0 8px;" placeholder="Enter password" required>
                            <button type="button" onclick="togglePassword()" style="border: 1px solid #d4d8e0; border-left: none; background: #f8f9fa; padding: 0 15px; border-radius: 0 8px 8px 0;">
                                👁️
                            </button>
                        </div>
                        @error('password')
                            <span style="color: red; font-size: 13px;">{{ $message }}</span>
                        @enderror
                    </div>

                    <div style="margin-top: 25px;">
                        <button type="submit" class="btn btn-primary">Log In</button>
                    </div>

                </form>
            @endauth

        </div>
    </div>

    @include('backend.partials.script')

    <script>
        // Password Show/Hide logic
        function togglePassword() {
            var x = document.getElementById("password");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
    </script>
</body>
</html>