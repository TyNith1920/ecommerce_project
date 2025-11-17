<!DOCTYPE html>
<html lang="en">
<head>
    @include('home.css')
    <style>
        .login-card {
            max-width: 500px;
            margin: 60px auto;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            padding: 30px;
        }
        .login-card h2 {
            text-align: center;
            color: #6C63FF;
            margin-bottom: 25px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            font-weight: bold;
            display: block;
            margin-bottom: 6px;
        }
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }
        .btn-login {
            background-color: #6C63FF;
            color: white;
            padding: 12px;
            width: 100%;
            border: none;
            border-radius: 6px;
            font-weight: bold;
            cursor: pointer;
        }
        .btn-login:hover {
            background-color: #574fd2;
        }
        .extra-links {
            text-align: center;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <div class="hero_area">
        @include('home.header')

        <div class="login-card">
            <h2>🔐 Login to LFCSHOP</h2>

            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                                  :value="old('email')" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="form-group">
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password"
                                  required autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class="form-group">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox"
                               class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                               name="remember">
                        <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                    </label>
                </div>

                <button type="submit" class="btn-login">LOG IN</button>

                <div class="extra-links">
                    @if (\Illuminate\Support\Facades\Route::has('password.request'))
                        <small><a href="{{ route('password.request') }}">Forgot your password?</a></small><br>
                    @endif

                    @if (\Illuminate\Support\Facades\Route::has('register'))
                        <small>Don't have an account? <a href="{{ route('register') }}">Register here</a></small>
                    @endif
                </div>
            </form>
        </div>
    </div>
</body>
</html>