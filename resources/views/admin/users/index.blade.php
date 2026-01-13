@extends('admin.layouts.app')

@section('title', 'Users Management')

@section('content')
<!-- [ breadcrumb ] start -->
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item" aria-current="page">Users Management</li>
                </ul>
            </div>
            <div class="col-md-12">
                <div class="page-header-title">
                    <h2 class="mb-0">Users Management</h2>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- [ breadcrumb ] end -->

<!-- [ Statistics Cards ] start -->
<div class="row">
    <div class="col-md-6 col-xl-3">
        <div class="card bg-danger-dark dashnum-card text-white overflow-hidden">
            <span class="round small"></span>
            <span class="round big"></span>
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <div class="avtar avtar-lg">
                            <i class="ti ti-shield-check text-white" style="font-size: 30px;"></i>
                        </div>
                    </div>
                    <div class="col-auto">
                        <span class="badge bg-light-danger border border-light-danger text-white">Admin</span>
                    </div>
                </div>
                <span class="text-white d-block f-34 f-w-500 my-2" id="adminCount">0</span>
                <p class="mb-0 opacity-75">Admin Users</p>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card bg-primary-dark dashnum-card text-white overflow-hidden">
            <span class="round small"></span>
            <span class="round big"></span>
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <div class="avtar avtar-lg">
                            <i class="ti ti-crown text-white" style="font-size: 30px;"></i>
                        </div>
                    </div>
                    <div class="col-auto">
                        <span class="badge bg-light-primary border border-light-primary text-white">Premium</span>
                    </div>
                </div>
                <span class="text-white d-block f-34 f-w-500 my-2" id="membershipCount">0</span>
                <p class="mb-0 opacity-75">Membership Users</p>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card bg-success-dark dashnum-card text-white overflow-hidden">
            <span class="round small"></span>
            <span class="round big"></span>
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <div class="avtar avtar-lg">
                            <i class="ti ti-user text-white" style="font-size: 30px;"></i>
                        </div>
                    </div>
                    <div class="col-auto">
                        <span class="badge bg-light-success border border-light-success text-white">Regular</span>
                    </div>
                </div>
                <span class="text-white d-block f-34 f-w-500 my-2" id="regulerCount">0</span>
                <p class="mb-0 opacity-75">Regular Users</p>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card bg-warning-dark dashnum-card text-white overflow-hidden">
            <span class="round small"></span>
            <span class="round big"></span>
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <div class="avtar avtar-lg">
                            <i class="ti ti-users text-white" style="font-size: 30px;"></i>
                        </div>
                    </div>
                    <div class="col-auto">
                        <span class="badge bg-light-warning border border-light-warning text-white">Total</span>
                    </div>
                </div>
                <span class="text-white d-block f-34 f-w-500 my-2" id="totalCount">0</span>
                <p class="mb-0 opacity-75">Total Users</p>
            </div>
        </div>
    </div>
</div>
<!-- [ Statistics Cards ] end -->

<!-- [ Filter Section ] start -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5><i class="ti ti-filter"></i> Filter by Role</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <select class="form-select" id="filterRole">
                            <option value="">All Roles</option>
                            <option value="admin">Admin</option>
                            <option value="membership">Membership</option>
                            <option value="reguler">Reguler</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- [ Filter Section ] end -->

<!-- [ Main Content ] start -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5>Users List</h5>
                <button type="button" class="btn btn-primary" id="createBtn">
                    <i class="ti ti-plus"></i> Add New User
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="usersTable" class="table table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Joined</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- [ Main Content ] end -->

<!-- Modal for Create/Edit -->
<div class="modal fade" id="userModal" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="userForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">
                        <i class="ti ti-plus"></i> Add New User
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="userId">

                    <div class="mb-3">
                        <label class="form-label">Full Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter full name" required>
                        <div class="invalid-feedback">Please enter a name.</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email Address <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter email address" required>
                        <div class="invalid-feedback">Please enter a valid email.</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Role <span class="text-danger">*</span></label>
                        <select class="form-select" id="role" name="role" required>
                            <option value="">Select Role</option>
                            <option value="admin">Admin</option>
                            <option value="membership">Membership</option>
                            <option value="reguler">Reguler</option>
                        </select>
                        <div class="invalid-feedback">Please select a role.</div>
                    </div>

                    <div class="mb-3" id="passwordField">
                        <label class="form-label">Password <span class="text-danger" id="passwordRequired">*</span></label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter password">
                            <button class="btn btn-outline-secondary" type="button" id="togglePasswordModal">
                                <i class="ti ti-eye" id="eyeIconModal"></i>
                            </button>
                        </div>
                        <small class="text-muted" id="passwordHelp">Minimum 8 characters</small>
                        <div class="invalid-feedback">Please enter a password.</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="ti ti-x"></i> Cancel
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="ti ti-check"></i> Save User
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal for Reset Password -->
<div class="modal fade" id="resetPasswordModal" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="resetPasswordForm">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="ti ti-key"></i> Reset Password
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="resetUserId">

                    <div class="alert alert-info">
                        <i class="ti ti-info-circle me-2"></i>
                        Resetting password for: <strong id="resetUserName"></strong>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">New Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" id="new_password" name="password" placeholder="Enter new password" required>
                        <small class="text-muted">Minimum 8 characters</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Confirm Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm new password" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="ti ti-x"></i> Cancel
                    </button>
                    <button type="submit" class="btn btn-warning">
                        <i class="ti ti-key"></i> Reset Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Initialize DataTable
    const table = $('#usersTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ route("admin.users.data") }}',
            data: function(d) {
                d.role = $('#filterRole').val();
            }
        },
        columns: [
            {
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false,
                className: 'text-center'
            },
            {
                data: 'name',
                name: 'name'
            },
            {
                data: 'email',
                name: 'email'
            },
            {
                data: 'role_badge',
                name: 'role',
                orderable: false
            },
            {
                data: 'status',
                name: 'email_verified_at',
                orderable: false,
                className: 'text-center'
            },
            {
                data: 'created_at',
                name: 'created_at'
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false,
                className: 'text-end'
            }
        ],
        order: [[5, 'desc']],
        language: {
            processing: '<i class="ti ti-loader"></i> Loading...',
            emptyTable: 'No users found',
            zeroRecords: 'No matching users found'
        },
        drawCallback: function() {
            updateStatistics();
        }
    });

    // Update statistics function
    function updateStatistics() {
        $.get('{{ route('admin.users.data') }}?length=1000', function(response) {
            const data = response.data;
            const admin = data.filter(u => u.role === 'admin').length;
            const membership = data.filter(u => u.role === 'membership').length;
            const reguler = data.filter(u => u.role === 'reguler').length;

            $('#adminCount').text(admin);
            $('#membershipCount').text(membership);
            $('#regulerCount').text(reguler);
            $('#totalCount').text(data.length);
        });
    }

    // Initial load
    updateStatistics();

    // Filter change event
    $('#filterRole').change(function() {
        table.ajax.reload();
    });

    // Create Button
    $('#createBtn').click(function() {
        $('#userForm')[0].reset();
        $('#userForm').removeClass('was-validated');
        $('#userId').val('');
        $('#modalTitle').html('<i class="ti ti-plus"></i> Add New User');
        $('#password').prop('required', true);
        $('#passwordRequired').show();
        $('#passwordHelp').text('Minimum 8 characters');
        $('#userModal').modal('show');
    });

    // Edit Button
    $(document).on('click', '.edit-btn', function() {
        const id = $(this).data('id');

        $.get(`{{ url('admin/users') }}/${id}`, function(response) {
            if (response.success) {
                $('#userId').val(response.data.id);
                $('#name').val(response.data.name);
                $('#email').val(response.data.email);
                $('#role').val(response.data.role);
                $('#password').val('').prop('required', false);
                $('#passwordRequired').hide();
                $('#passwordHelp').text('Leave blank to keep current password');
                $('#modalTitle').html('<i class="ti ti-edit"></i> Edit User');
                $('#userModal').modal('show');
            }
        }).fail(function() {
            Swal.fire('Error!', 'Failed to load user data', 'error');
        });
    });

    // Submit Form
    $('#userForm').submit(function(e) {
        e.preventDefault();

        // Form validation
        if (!this.checkValidity()) {
            e.stopPropagation();
            $(this).addClass('was-validated');
            return;
        }

        const id = $('#userId').val();
        const url = id ? `{{ url('admin/users') }}/${id}` : '{{ route("admin.users.store") }}';
        const method = id ? 'PUT' : 'POST';

        // Prepare data
        const formData = {
            name: $('#name').val(),
            email: $('#email').val(),
            role: $('#role').val()
        };

        // Add password if provided
        if ($('#password').val()) {
            formData.password = $('#password').val();
        }

        // Disable submit button
        const submitBtn = $(this).find('button[type="submit"]');
        submitBtn.prop('disabled', true).html('<i class="ti ti-loader"></i> Saving...');

        $.ajax({
            url: url,
            method: method,
            data: formData,
            success: function(response) {
                if (response.success) {
                    $('#userModal').modal('hide');
                    table.ajax.reload(null, false);

                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: response.message,
                        timer: 2000,
                        showConfirmButton: false
                    });
                }
            },
            error: function(xhr) {
                let errorMessage = 'Something went wrong';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    const errors = xhr.responseJSON.errors;
                    errorMessage = Object.values(errors).flat().join('<br>');
                }
                Swal.fire('Error!', errorMessage, 'error');
            },
            complete: function() {
                submitBtn.prop('disabled', false).html('<i class="ti ti-check"></i> Save User');
            }
        });
    });

    // Delete Button
    $(document).on('click', '.delete-btn', function() {
        const id = $(this).data('id');

        Swal.fire({
            title: 'Are you sure?',
            text: "This will permanently delete the user!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#6b7280',
            confirmButtonText: '<i class="ti ti-trash"></i> Yes, delete it!',
            cancelButtonText: '<i class="ti ti-x"></i> Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `{{ url('admin/users') }}/${id}`,
                    method: 'DELETE',
                    success: function(response) {
                        if (response.success) {
                            table.ajax.reload(null, false);

                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: response.message,
                                timer: 2000,
                                showConfirmButton: false
                            });
                        }
                    },
                    error: function(xhr) {
                        let errorMessage = 'Failed to delete user';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                        Swal.fire('Error!', errorMessage, 'error');
                    }
                });
            }
        });
    });

    // Toggle password visibility in modal
    $('#togglePasswordModal').click(function() {
        const password = $('#password');
        const eyeIcon = $('#eyeIconModal');

        if (password.attr('type') === 'password') {
            password.attr('type', 'text');
            eyeIcon.removeClass('ti-eye').addClass('ti-eye-off');
        } else {
            password.attr('type', 'password');
            eyeIcon.removeClass('ti-eye-off').addClass('ti-eye');
        }
    });
});
</script>
@endpush
