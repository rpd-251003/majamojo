@extends('admin.layouts.app')

@section('title', 'Super Deals Management')

@section('content')
<!-- [ breadcrumb ] start -->
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item" aria-current="page">Super Deals Management</li>
                </ul>
            </div>
            <div class="col-md-12">
                <div class="page-header-title">
                    <h2 class="mb-0">Super Deals Management</h2>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- [ breadcrumb ] end -->

<!-- [ Filter Section ] start -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5><i class="ti ti-filter"></i> Filters</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <label class="form-label">Filter by Game</label>
                        <select class="form-select" id="filterGame">
                            <option value="">All Games</option>
                            @foreach($games as $game)
                                <option value="{{ $game->id }}">{{ $game->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Start Date</label>
                        <input type="date" class="form-control" id="filterStartDate">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">End Date</label>
                        <input type="date" class="form-control" id="filterEndDate">
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
                <h5>Super Deals List</h5>
                <button type="button" class="btn btn-primary" id="createBtn">
                    <i class="ti ti-plus"></i> Add New Deal
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="superDealsTable" class="table table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Game</th>
                                <th>Game Name</th>
                                <th>Banner</th>
                                <th>Price</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Status</th>
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
<div class="modal fade" id="superDealModal" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form id="superDealForm" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">
                        <i class="ti ti-plus"></i> Add New Super Deal
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="superDealId">

                    <div class="mb-3">
                        <label class="form-label">Game <span class="text-danger">*</span></label>
                        <select class="form-select" id="game_id" name="game_id" required>
                            <option value="">Select Game</option>
                            @foreach($games as $game)
                                <option value="{{ $game->id }}">{{ $game->name }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">Please select a game.</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Game Name (Display) <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="game_name" name="game_name" placeholder="e.g., Mobile Legends 100 Diamonds" required>
                        <small class="text-muted">Display name for the deal (e.g., package name)</small>
                        <div class="invalid-feedback">Please enter a game name.</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3" placeholder="Enter deal description"></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Price (Rp) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" class="form-control" id="price" name="price" placeholder="0" min="0" step="1" required>
                        </div>
                        <small class="text-muted">Enter price in Rupiah</small>
                        <div class="invalid-feedback">Please enter a valid price.</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Banner Image</label>
                        <input type="file" class="form-control" id="banner_image" name="banner_image" accept="image/*">
                        <small class="text-muted">Recommended size: 1200x400px. Max 2MB.</small>
                        <div id="currentBanner" class="mt-2"></div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Start Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="start_date" name="start_date" required>
                                <div class="invalid-feedback">Please select a start date.</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">End Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="end_date" name="end_date" required>
                                <div class="invalid-feedback">Please select an end date.</div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">External Link</label>
                        <input type="url" class="form-control" id="external_link" name="external_link" placeholder="https://example.com">
                        <small class="text-muted">Optional link to deal purchase page</small>
                    </div>

                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="status" name="status" checked>
                            <label class="form-check-label" for="status">
                                Active Status
                            </label>
                        </div>
                        <small class="text-muted">Enable this to make the deal visible</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="ti ti-x"></i> Cancel
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="ti ti-check"></i> Save Deal
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
    const table = $('#superDealsTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ route("admin.super-deals.data") }}',
            data: function(d) {
                d.game_id = $('#filterGame').val();
                d.start_date = $('#filterStartDate').val();
                d.end_date = $('#filterEndDate').val();
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
                data: 'game',
                name: 'game.name',
                orderable: false
            },
            {
                data: 'game_name',
                name: 'game_name'
            },
            {
                data: 'banner',
                name: 'banner',
                orderable: false,
                searchable: false,
                className: 'text-center'
            },
            {
                data: 'price_formatted',
                name: 'price'
            },
            {
                data: 'start_date',
                name: 'start_date'
            },
            {
                data: 'end_date',
                name: 'end_date'
            },
            {
                data: 'status',
                name: 'status',
                orderable: false,
                className: 'text-center'
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
            emptyTable: 'No deals found',
            zeroRecords: 'No matching deals found'
        }
    });

    // Filter change events
    $('#filterGame, #filterStartDate, #filterEndDate').change(function() {
        table.ajax.reload();
    });

    // Create Button
    $('#createBtn').click(function() {
        $('#superDealForm')[0].reset();
        $('#superDealForm').removeClass('was-validated');
        $('#superDealId').val('');
        $('#currentBanner').html('');
        $('#modalTitle').html('<i class="ti ti-plus"></i> Add New Super Deal');
        $('#superDealModal').modal('show');
    });

    // Edit Button
    $(document).on('click', '.edit-btn', function() {
        const id = $(this).data('id');

        $.get(`{{ url('admin/super-deals') }}/${id}`, function(response) {
            if (response.success) {
                const data = response.data;
                $('#superDealId').val(data.id);
                $('#game_id').val(data.game_id);
                $('#game_name').val(data.game_name);
                $('#description').val(data.description);
                $('#price').val(data.price);
                $('#start_date').val(data.start_date);
                $('#end_date').val(data.end_date);
                $('#external_link').val(data.external_link);
                $('#status').prop('checked', data.status);

                // Show current banner
                if (data.banner_image) {
                    $('#currentBanner').html(`
                        <div class="alert alert-info">
                            <strong>Current Banner:</strong><br>
                            <img src="${data.banner_image_url}" alt="Banner" class="img-thumbnail mt-2" style="max-height: 100px;">
                        </div>
                    `);
                } else {
                    $('#currentBanner').html('');
                }

                $('#modalTitle').html('<i class="ti ti-edit"></i> Edit Super Deal');
                $('#superDealModal').modal('show');
            }
        }).fail(function() {
            Swal.fire('Error!', 'Failed to load deal data', 'error');
        });
    });

    // Submit Form
    $('#superDealForm').submit(function(e) {
        e.preventDefault();

        // Form validation
        if (!this.checkValidity()) {
            e.stopPropagation();
            $(this).addClass('was-validated');
            return;
        }

        const id = $('#superDealId').val();
        const url = id ? `{{ url('admin/super-deals') }}/${id}` : '{{ route("admin.super-deals.store") }}';

        // Prepare FormData for file upload
        const formData = new FormData();
        formData.append('game_id', $('#game_id').val());
        formData.append('game_name', $('#game_name').val());
        formData.append('description', $('#description').val() || '');
        formData.append('price', $('#price').val());
        formData.append('start_date', $('#start_date').val());
        formData.append('end_date', $('#end_date').val());
        formData.append('external_link', $('#external_link').val() || '');
        formData.append('status', $('#status').is(':checked') ? 1 : 0);

        // Add banner image if selected
        const bannerFile = $('#banner_image')[0].files[0];
        if (bannerFile) {
            formData.append('banner_image', bannerFile);
        }

        if (id) {
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
                    $('#superDealModal').modal('hide');
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
                submitBtn.prop('disabled', false).html('<i class="ti ti-check"></i> Save Deal');
            }
        });
    });

    // Delete Button
    $(document).on('click', '.delete-btn', function() {
        const id = $(this).data('id');

        Swal.fire({
            title: 'Are you sure?',
            text: "This will permanently delete the super deal!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#6b7280',
            confirmButtonText: '<i class="ti ti-trash"></i> Yes, delete it!',
            cancelButtonText: '<i class="ti ti-x"></i> Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `{{ url('admin/super-deals') }}/${id}`,
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
                        Swal.fire('Error!', 'Failed to delete deal', 'error');
                    }
                });
            }
        });
    });

    // Toggle Status
    $(document).on('change', '.status-toggle', function() {
        const id = $(this).data('id');
        const checkbox = $(this);

        $.post(`{{ url('admin/super-deals') }}/${id}/toggle-status`, function(response) {
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

    // Price formatting on input
    $('#price').on('input', function() {
        let value = $(this).val();
        // Remove non-numeric characters except decimal point
        value = value.replace(/[^0-9]/g, '');
        $(this).val(value);
    });
});
</script>
@endpush
