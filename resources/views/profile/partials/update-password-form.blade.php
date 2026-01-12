<form method="post" action="{{ route('password.update') }}">
    @csrf
    @method('put')

    <div class="mb-3">
        <label for="update_password_current_password" class="form-label">Current Password</label>
        <input type="password"
               class="form-control @error('current_password', 'updatePassword') is-invalid @enderror"
               id="update_password_current_password"
               name="current_password"
               autocomplete="current-password">
        @error('current_password', 'updatePassword')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="update_password_password" class="form-label">New Password</label>
        <input type="password"
               class="form-control @error('password', 'updatePassword') is-invalid @enderror"
               id="update_password_password"
               name="password"
               autocomplete="new-password">
        @error('password', 'updatePassword')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="update_password_password_confirmation" class="form-label">Confirm Password</label>
        <input type="password"
               class="form-control @error('password_confirmation', 'updatePassword') is-invalid @enderror"
               id="update_password_password_confirmation"
               name="password_confirmation"
               autocomplete="new-password">
        @error('password_confirmation', 'updatePassword')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="d-flex align-items-center gap-3">
        <button type="submit" class="btn btn-primary">
            <i class="ti ti-lock me-2"></i>Update Password
        </button>

        @if (session('status') === 'password-updated')
            <p class="text-success mb-0" id="passwordSavedMsg">
                <i class="ti ti-check"></i> Password updated successfully!
            </p>
            <script>
                setTimeout(function() {
                    const msg = document.getElementById('passwordSavedMsg');
                    if (msg) {
                        msg.style.transition = 'opacity 0.5s';
                        msg.style.opacity = '0';
                        setTimeout(function() { msg.remove(); }, 500);
                    }
                }, 2000);
            </script>
        @endif
    </div>
</form>
