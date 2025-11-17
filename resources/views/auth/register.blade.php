<!DOCTYPE html>
<html lang="en">
<head>
    @include('home.css')
    <style>
        .register-card {
            max-width: 500px;
            margin: 60px auto;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            padding: 30px;
        }
        .register-card h2 {
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
        input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }
        .btn-register {
            background-color: #6C63FF;
            color: white;
            padding: 12px;
            width: 100%;
            border: none;
            border-radius: 6px;
            font-weight: bold;
            cursor: pointer;
        }
        .btn-register:hover {
            background-color: #574fd2;
        }
        .login-link {
            text-align: center;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <div class="hero_area">
        @include('home.header')

        <div class="register-card">
            <div class="text-center mb-4">
                <img src="/images/iconuser.png" alt="User Icon" width="40" style="border-radius: 50%;">
            </div>

            <h2>Create Your Account</h2>
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="form-group">
                    <label for="name">👤 Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" required>
                </div>

                <div class="form-group">
                    <label for="email">📧 Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required>
                </div>

                <div class="form-group">
                    <label for="phone">📱 Phone</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" required>
                </div>

                <div class="form-group">
                    <label for="address">🏠 Address</label>
                    <input type="text" name="address" value="{{ old('address') }}" required>
                </div>

                <div class="form-group">
                    <label for="password">🔒 Password</label>
                    <input type="password" name="password" required>
                </div>

                <div class="form-group">
                    <label for="password_confirmation">🔒 Confirm Password</label>
                    <input type="password" name="password_confirmation" required>
                </div>

                <button type="submit" class="btn-register">REGISTER</button>

                <div class="login-link">
                    <small>Already registered? <a href="{{ route('login') }}">Login here</a></small>
                </div>
            </form>
        </div>
    </div>
</body>
</html>