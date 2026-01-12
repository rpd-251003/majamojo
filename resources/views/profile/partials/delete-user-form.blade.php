<p class="text-muted mb-3">
    Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.
</p>

<button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmUserDeletionModal">
    <i class="ti ti-trash me-2"></i>Delete Account
</button>

<!-- Delete Account Confirmation Modal -->
<div class="modal fade" id="confirmUserDeletionModal" tabindex="-1" aria-labelledby="confirmUserDeletionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title text-white" id="confirmUserDeletionModalLabel">
                    <i class="ti ti-alert-triangle me-2"></i>Delete Account
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="{{ route('profile.destroy') }}">
                @csrf
                @method('delete')

                <div class="modal-body">
                    <div class="alert alert-danger">
                        <i class="ti ti-alert-circle me-2"></i>
                        <strong>Are you sure you want to delete your account?</strong>
                    </div>

                    <p class="text-muted mb-3">
                        Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.
                    </p>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password"
                               class="form-control @error('password', 'userDeletion') is-invalid @enderror"
                               id="password"
                               name="password"
                               placeholder="Enter your password"
                               required>
                        @error('password', 'userDeletion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="ti ti-x me-2"></i>Cancel
                    </button>
                    <button type="submit" class="btn btn-danger">
                        <i class="ti ti-trash me-2"></i>Delete Account
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@if ($errors->userDeletion->isNotEmpty())
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = new bootstrap.Modal(document.getElementById('confirmUserDeletionModal'));
            modal.show();
        });
    </script>
@endif
