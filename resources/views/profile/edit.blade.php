<!DOCTYPE html>
<html lang="en">

<head>
    @include('home.css')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LFCShop | Profile</title>

    <style>
        body {
            font-family: "Poppins", "Battambang", sans-serif;
            background: linear-gradient(180deg, #0F6B63, #4FA7A5, #70B2B2, #A2D3D6);
            background-attachment: fixed;
            margin: 0;
            padding: 0;
        }

        .profile-wrapper {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .profile-container {
            max-width: 1100px;
            margin: 120px auto 60px auto;
            padding: 30px;
            border-radius: 18px;
            background: rgba(255, 255, 255, 0.09);
            backdrop-filter: blur(16px);
            box-shadow: 0 18px 45px rgba(0, 0, 0, 0.35);
            color: #fff;
        }

        .profile-title {
            font-size: 28px;
            font-weight: 700;
            text-align: center;
            margin-bottom: 6px;
        }

        .profile-subtitle {
            text-align: center;
            opacity: .85;
            margin-bottom: 26px;
        }

        .profile-grid {
            display: grid;
            grid-template-columns: 2fr 1.2fr;
            gap: 26px;
        }

        @media (max-width: 900px) {
            .profile-container {
                margin-top: 90px;
                padding: 18px;
            }

            .profile-grid {
                grid-template-columns: 1fr;
            }
        }

        /* card wrapper for each section */
        .profile-section-box {
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 20px;
            padding: 22px 26px;
            backdrop-filter: blur(6px);
        }

        .card-section-title {
            font-size: 20px;
            font-weight: 700;
            color: #fff;
            margin-bottom: 8px;
        }

        .profile-form-group {
            margin-bottom: 12px;
            display: flex;
            flex-direction: column;
        }

        .profile-form-group label {
            font-size: 14px;
            color: #fff;
            margin-bottom: 4px;
        }

        .profile-form-group input,
        .profile-form-group textarea {
            width: 100%;
            padding: 9px 11px;
            font-size: 14px;
            border-radius: 10px;
            border: none;
            outline: none;
            color: #0F6B63;
        }

        .profile-main-btn {
            background: linear-gradient(45deg, #2563eb, #3b82f6);
            padding: 10px 26px;
            border-radius: 999px;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            box-shadow: 0 10px 24px rgba(0, 0, 0, 0.3);
            transition: 0.18s ease;
        }

        .profile-main-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 14px 30px rgba(0, 0, 0, 0.35);
        }

        .profile-main-btn:active {
            transform: translateY(1px) scale(.98);
            box-shadow: 0 7px 18px rgba(0, 0, 0, 0.28);
        }

        .danger-btn {
            background: linear-gradient(45deg, #dc2626, #ef4444);
        }

        .profile-photo-box {
            background: rgba(255, 255, 255, 0.04);
            padding: 16px;
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.12);
            display: flex;
            align-items: center;
            gap: 18px;
            margin-top: 10px;
        }

        .profile-photo-box img {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid rgba(255, 255, 255, 0.4);
            box-shadow: 0 10px 22px rgba(0, 0, 0, 0.4);
        }

        .profile-photo-info {
            color: #fff;
            font-size: 14px;
            opacity: 0.9;
        }

        .profile-section {
            margin-top: 18px;
        }
    </style>
</head>

<body>
    <div class="profile-wrapper">
        <div class="hero_area">
            @include('home.header')
        </div>

        <div class="profile-container">
            <div class="profile-title">Profile</div>
            <p class="profile-subtitle">Update your profile, password, and account settings.</p>

            <div class="profile-grid">
                {{-- LEFT COLUMN: profile info --}}
                <div>
                    @include('profile.partials.update-profile-information-form')
                </div>

                {{-- RIGHT COLUMN: password + delete --}}
                <div>
                    <div class="profile-section">
                        @include('profile.partials.update-password-form')
                    </div>

                    <div class="profile-section" style="margin-top:22px;">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>

        @include('home.footer')
    </div>
</body>

</html>