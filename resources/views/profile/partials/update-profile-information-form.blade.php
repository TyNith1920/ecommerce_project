<section class="profile-section-box">
    <h3 class="card-section-title">Profile Information</h3>
    <p class="text-sm opacity-80 mb-3">
        Update your account's profile information and email address.
    </p>

    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div class="profile-form-group">
            <label for="name">Name</label>
            <input id="name" name="name" value="{{ old('name', $user->name) }}" required>
        </div>

        <div class="profile-form-group">
            <label for="email">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" required>
        </div>

        <div class="profile-form-group">
            <label for="phone">Phone</label>
            <input id="phone" name="phone" value="{{ old('phone', $user->phone) }}">
        </div>

        <div class="profile-form-group">
            <label for="payway_account">PayWay / ABA Account</label>
            <input id="payway_account" name="payway_account"
                placeholder="e.g. 012345678"
                value="{{ old('payway_account', $user->payway_account) }}">
        </div>

        <div class="profile-form-group" style="flex-direction:row;align-items:center;gap:8px;">
            <input id="enable_qr" type="checkbox" name="enable_qr" value="1"
                {{ old('enable_qr', $user->enable_qr) ? 'checked' : '' }}>
            <label for="enable_qr" style="margin-bottom:0;">Enable QR payment for this account</label>
        </div>

        <div class="profile-form-group">
            <label for="profile_photo">Profile Photo</label>
            <input id="profile_photo" type="file" name="profile_photo" accept="image/*"
                onchange="previewImage(event)">
        </div>

        <div class="profile-photo-box">
            <img id="preview-photo"
                src="{{ $user->profile_photo ? asset('storage/'.$user->profile_photo) : asset('default-avatar.png') }}">
            <div class="profile-photo-info">
                <div>{{ $user->email }}</div>
                <div>{{ $user->phone }}</div>
            </div>
        </div>

        <button class="profile-main-btn" style="margin-top:14px;">Save</button>
    </form>
</section>

<script>
    function previewImage(event) {
        const file = event.target.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = function(e) {
            const img = document.getElementById('preview-photo');
            if (img) img.src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
</script>