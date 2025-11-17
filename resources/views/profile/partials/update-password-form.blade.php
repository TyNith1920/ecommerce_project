<section class="profile-section-box">
    <h3 class="card-section-title">Update Password</h3>
    <p class="text-sm opacity-80 mb-3">
        Ensure your account is using a long, random password to stay secure.
    </p>

    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        @method('put')

        <div class="profile-form-group">
            <label for="current_password">Current Password</label>
            <input id="current_password" type="password" name="current_password" autocomplete="current-password">
            @if ($errors->updatePassword->has('current_password'))
            <span style="color:#ffb4b4;font-size:12px;">
                {{ $errors->updatePassword->first('current_password') }}
            </span>
            @endif
        </div>

        <div class="profile-form-group">
            <label for="password">New Password</label>
            <input id="password" type="password" name="password" autocomplete="new-password">
            @if ($errors->updatePassword->has('password'))
            <span style="color:#ffb4b4;font-size:12px;">
                {{ $errors->updatePassword->first('password') }}
            </span>
            @endif
        </div>

        <div class="profile-form-group">
            <label for="password_confirmation">Confirm Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" autocomplete="new-password">
            @if ($errors->updatePassword->has('password_confirmation'))
            <span style="color:#ffb4b4;font-size:12px;">
                {{ $errors->updatePassword->first('password_confirmation') }}
            </span>
            @endif
        </div>

        <div style="text-align:right;margin-top:6px;">
            <button class="profile-main-btn">Save</button>
        </div>
    </form>
</section>