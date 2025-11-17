<section class="profile-section-box">
    <h3 class="card-section-title">Delete Account</h3>
    <p class="text-sm opacity-80 mb-3">
        Once your account is deleted, all of its resources and data will be permanently deleted.
        Please enter your password to confirm.
    </p>

    @if ($errors->userDeletion->has('password'))
    <p style="color:#ffb4b4;font-size:12px;margin-bottom:6px;">
        {{ $errors->userDeletion->first('password') }}
    </p>
    @endif

    <form method="POST" action="{{ route('profile.destroy') }}">
        @csrf
        @method('delete')

        <div class="profile-form-group">
            <label for="delete_password">Password</label>
            <input id="delete_password" type="password" name="password"
                placeholder="Enter your password to confirm" required>
        </div>

        <button class="profile-main-btn danger-btn"
            style="margin-top:10px;"
            onclick="return confirm('Are you sure you want to permanently delete your account?');">
            Delete Account
        </button>
    </form>
</section>