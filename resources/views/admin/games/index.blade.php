@extends('admin.layouts.app')

@section('title', 'Games Management')

@section('content')
<!-- [ breadcrumb ] start -->
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item" aria-current="page">Games Management</li>
                </ul>
            </div>
            <div class="col-md-12">
                <div class="page-header-title">
                    <h2 class="mb-0">Games Management</h2>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- [ breadcrumb ] end -->

<!-- [ Main Content ] start -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5>Games List</h5>
                <button type="button" class="btn btn-primary" id="createBtn">
                    <i class="ti ti-plus"></i> Add New Game
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="gamesTable" class="table table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Logo</th>
                                <th>Name</th>
                                <th>Status</th>
                                <th>Created At</th>
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
<div class="modal fade" id="gameModal" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="gameForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">
                        <i class="ti ti-plus"></i> Add New Game
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="gameId">

                    <div class="mb-3">
                        <label class="form-label">Game Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter game name" required>
                        <div class="invalid-feedback">Please enter a game name.</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Game Logo/Icon</label>
                        <input type="file" class="form-control" id="logo" name="logo" accept="image/jpeg,image/jpg,image/png,image/gif,image/svg+xml">
                        <small class="text-muted">Upload logo (JPEG, JPG, PNG, GIF, SVG | Max: 2MB)</small>
                        <div id="logoPreview" class="mt-2" style="display: none;">
                            <img id="logoPreviewImg" src="" alt="Logo Preview" class="img-thumbnail" style="max-width: 150px; max-height: 150px; object-fit: contain;">
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="status" name="status" checked>
                            <label class="form-check-label" for="status">
                                Active Status
                            </label>
                        </div>
                        <small class="text-muted">Enable this to make the game visible</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="ti ti-x"></i> Cancel
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="ti ti-check"></i> Save Game
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
    const table = $('#gamesTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("admin.games.data") }}',
        columns: [
            {
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false,
                className: 'text-center'
            },
            {
                data: 'logo_display',
                name: 'logo_display',
                orderable: false,
                searchable: false,
                className: 'text-center'
            },
            {
                data: 'name',
                name: 'name'
            },
            {
                data: 'status',
                name: 'status',
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
        order: [[3, 'desc']],
        language: {
            processing: '<i class="ti ti-loader"></i> Loading...',
            emptyTable: 'No games found',
            zeroRecords: 'No matching games found'
        }
    });

    // Logo Preview
    $('#logo').change(function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#logoPreviewImg').attr('src', e.target.result);
                $('#logoPreview').show();
            }
            reader.readAsDataURL(file);
        } else {
            $('#logoPreview').hide();
        }
    });

    // Create Button
    $('#createBtn').click(function() {
        $('#gameForm')[0].reset();
        $('#gameForm').removeClass('was-validated');
        $('#gameId').val('');
        $('#logoPreview').hide();
        $('#modalTitle').html('<i class="ti ti-plus"></i> Add New Game');
        $('#gameModal').modal('show');
    });

    // Edit Button
    $(document).on('click', '.edit-btn', function() {
        const id = $(this).data('id');

        $.get(`{{ url('admin/games') }}/${id}`, function(response) {
            if (response.success) {
                $('#gameId').val(response.data.id);
                $('#name').val(response.data.name);
                $('#status').prop('checked', response.data.status);

                // Show existing logo if available
                if (response.data.logo) {
                    $('#logoPreviewImg').attr('src', '{{ asset("storage") }}/' + response.data.logo);
                    $('#logoPreview').show();
                } else {
                    $('#logoPreview').hide();
                }

                $('#modalTitle').html('<i class="ti ti-edit"></i> Edit Game');
                $('#gameModal').modal('show');
            }
        }).fail(function() {
            Swal.fire('Error!', 'Failed to load game data', 'error');
        });
    });

    // Submit Form
    $('#gameForm').submit(function(e) {
        e.preventDefault();

        // Form validation
        if (!this.checkValidity()) {
            e.stopPropagation();
            $(this).addClass('was-validated');
            return;
        }

        const id = $('#gameId').val();
        const url = id ? `{{ url('admin/games') }}/${id}` : '{{ route("admin.games.store") }}';
        const method = id ? 'PUT' : 'POST';

        // Prepare FormData for file upload
        const formData = new FormData();
        formData.append('name', $('#name').val());
        formData.append('status', $('#status').is(':checked') ? 1 : 0);

        // Add logo file if selected
        const logoFile = $('#logo')[0].files[0];
        if (logoFile) {
            formData.append('logo', logoFile);
        }

        // For PUT method, add _method field
        if (method === 'PUT') {
            formData.append('_method', 'PUT');
        }

        // Disable submit button
        const submitBtn = $(this).find('button[type="submit"]');
        submitBtn.prop('disabled', true).html('<i class="ti ti-loader"></i> Saving...');

        $.ajax({
            url: url,
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    $('#gameModal').modal('hide');
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
                Swal.fire('Error!', errorMessage, 'error');
            },
            complete: function() {
                submitBtn.prop('disabled', false).html('<i class="ti ti-check"></i> Save Game');
            }
        });
    });

    // Delete Button
    $(document).on('click', '.delete-btn', function() {
        const id = $(this).data('id');

        Swal.fire({
            title: 'Are you sure?',
            text: "This will permanently delete the game and all related data!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#6b7280',
            confirmButtonText: '<i class="ti ti-trash"></i> Yes, delete it!',
            cancelButtonText: '<i class="ti ti-x"></i> Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `{{ url('admin/games') }}/${id}`,
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
                        Swal.fire('Error!', 'Failed to delete game', 'error');
                    }
                });
            }
        });
    });

    // Toggle Status
    $(document).on('change', '.status-toggle', function() {
        const id = $(this).data('id');
        const checkbox = $(this);

        $.post(`{{ url('admin/games') }}/${id}/toggle-status`, function(response) {
            if (response.success) {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                });

                Toast.fire({
                    icon: 'success',
                    title: response.message
                });
            }
        }).fail(function() {
            checkbox.prop('checked', !checkbox.is(':checked'));
            Swal.fire('Error!', 'Failed to update status', 'error');
        });
    });
});
</script>
@endpush
