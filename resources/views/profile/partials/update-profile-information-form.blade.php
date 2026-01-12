<form id="send-verification" method="post" action="{{ route('verification.send') }}">
    @csrf
</form>

<form method="post" action="{{ route('profile.update') }}">
    @csrf
    @method('patch')

    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text"
               class="form-control @error('name') is-invalid @enderror"
               id="name"
               name="name"
               value="{{ old('name', $user->name) }}"
               required
               autofocus>
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email"
               class="form-control @error('email') is-invalid @enderror"
               id="email"
               name="email"
               value="{{ old('email', $user->email) }}"
               required>
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror

        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
            <div class="alert alert-warning mt-2">
                <p class="mb-2">Your email address is unverified.</p>
                <button form="send-verification" class="btn btn-sm btn-warning">
                    Click here to re-send the verification email.
                </button>

                @if (session('status') === 'verification-link-sent')
                    <p class="mt-2 text-success mb-0">
                        <i class="ti ti-check"></i> A new verification link has been sent to your email address.
                    </p>
                @endif
            </div>
        @endif
    </div>

    <div class="d-flex align-items-center gap-3">
        <button type="submit" class="btn btn-primary">
            <i class="ti ti-device-floppy me-2"></i>Save Changes
        </button>

        @if (session('status') === 'profile-updated')
            <p class="text-success mb-0" id="profileSavedMsg">
                <i class="ti ti-check"></i> Saved successfully!
            </p>
            <script>
                setTimeout(function() {
                    const msg = document.getElementById('profileSavedMsg');
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
