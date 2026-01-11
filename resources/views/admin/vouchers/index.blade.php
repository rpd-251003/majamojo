@extends('admin.layouts.app')

@section('title', 'Vouchers Management')

@section('content')
<!-- [ breadcrumb ] start -->
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item" aria-current="page">Vouchers Management</li>
                </ul>
            </div>
            <div class="col-md-12">
                <div class="page-header-title">
                    <h2 class="mb-0">Vouchers Management</h2>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- [ breadcrumb ] end -->

<!-- [ Main Content ] start -->
<div class="row">
    <!-- Filter Card -->
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
                    <div class="col-md-3">
                        <label class="form-label">Start Date</label>
                        <input type="date" class="form-control" id="filterStartDate">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">End Date</label>
                        <input type="date" class="form-control" id="filterEndDate">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">&nbsp;</label>
                        <button type="button" class="btn btn-secondary w-100" id="resetFilter">
                            <i class="ti ti-x"></i> Reset
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5>Vouchers List</h5>
                <button type="button" class="btn btn-primary" id="createBtn">
                    <i class="ti ti-plus"></i> Add New Voucher
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="vouchersTable" class="table table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Game</th>
                                <th>Promo Code</th>
                                <th>Type</th>
                                <th>Date Range</th>
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
<div class="modal fade" id="voucherModal" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form id="voucherForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">
                        <i class="ti ti-plus"></i> Add New Voucher
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="voucherId">

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Game <span class="text-danger">*</span></label>
                            <select class="form-select" id="game_id" name="game_id" required>
                                <option value="">Choose Game</option>
                                @foreach($games as $game)
                                    <option value="{{ $game->id }}">{{ $game->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Promo Code <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="promo_code" name="promo_code" placeholder="e.g., MLBB2024" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Type <span class="text-danger">*</span></label>
                            <select class="form-select" id="type" name="type" required>
                                <option value="">Choose Type</option>
                                <option value="membership_only">Membership Only</option>
                                <option value="reguler_only">Reguler Only</option>
                                <option value="all">All Users</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">External Link</label>
                            <input type="url" class="form-control" id="external_link" name="external_link" placeholder="https://example.com">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Start Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="start_date" name="start_date" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">End Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="end_date" name="end_date" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3" placeholder="Enter voucher description"></textarea>
                    </div>

                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="status" name="status" checked>
                            <label class="form-check-label" for="status">
                                Active Status
                            </label>
                        </div>
                        <small class="text-muted">Enable this to make the voucher visible</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="ti ti-x"></i> Cancel
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="ti ti-check"></i> Save Voucher
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
    const table = $('#vouchersTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ route("admin.vouchers.data") }}',
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
                data: 'game_name',
                name: 'game.name'
            },
            {
                data: 'promo_code',
                name: 'promo_code'
            },
            {
                data: 'type_badge',
                name: 'type',
                orderable: false
            },
            {
                data: 'date_range',
                name: 'start_date',
                orderable: false
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
        order: [[2, 'asc']],
        language: {
            processing: '<i class="ti ti-loader"></i> Loading...',
            emptyTable: 'No vouchers found',
            zeroRecords: 'No matching vouchers found'
        }
    });

    // Filter change event
    $('#filterGame, #filterStartDate, #filterEndDate').change(function() {
        table.ajax.reload();
    });

    // Reset filter
    $('#resetFilter').click(function() {
        $('#filterGame').val('');
        $('#filterStartDate').val('');
        $('#filterEndDate').val('');
        table.ajax.reload();
    });

    // Create Button
    $('#createBtn').click(function() {
        $('#voucherForm')[0].reset();
        $('#voucherForm').removeClass('was-validated');
        $('#voucherId').val('');
        $('#modalTitle').html('<i class="ti ti-plus"></i> Add New Voucher');
        $('#voucherModal').modal('show');
    });

    // Edit Button
    $(document).on('click', '.edit-btn', function() {
        const id = $(this).data('id');

        $.get(`{{ url('admin/vouchers') }}/${id}`, function(response) {
            if (response.success) {
                $('#voucherId').val(response.data.id);
                $('#game_id').val(response.data.game_id);
                $('#promo_code').val(response.data.promo_code);
                $('#type').val(response.data.type);
                $('#description').val(response.data.description);
                $('#start_date').val(response.data.start_date);
                $('#end_date').val(response.data.end_date);
                $('#external_link').val(response.data.external_link);
                $('#status').prop('checked', response.data.status);
                $('#modalTitle').html('<i class="ti ti-edit"></i> Edit Voucher');
                $('#voucherModal').modal('show');
            }
        }).fail(function() {
            Swal.fire('Error!', 'Failed to load voucher data', 'error');
        });
    });

    // Submit Form
    $('#voucherForm').submit(function(e) {
        e.preventDefault();

        if (!this.checkValidity()) {
            e.stopPropagation();
            $(this).addClass('was-validated');
            return;
        }

        const id = $('#voucherId').val();
        const url = id ? `{{ url('admin/vouchers') }}/${id}` : '{{ route("admin.vouchers.store") }}';
        const method = id ? 'PUT' : 'POST';

        const submitBtn = $(this).find('button[type="submit"]');
        submitBtn.prop('disabled', true).html('<i class="ti ti-loader"></i> Saving...');

        $.ajax({
            url: url,
            method: method,
            data: {
                game_id: $('#game_id').val(),
                promo_code: $('#promo_code').val(),
                type: $('#type').val(),
                description: $('#description').val(),
                start_date: $('#start_date').val(),
                end_date: $('#end_date').val(),
                external_link: $('#external_link').val(),
                status: $('#status').is(':checked') ? 1 : 0
            },
            success: function(response) {
                if (response.success) {
                    $('#voucherModal').modal('hide');
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
                submitBtn.prop('disabled', false).html('<i class="ti ti-check"></i> Save Voucher');
            }
        });
    });

    // Delete Button
    $(document).on('click', '.delete-btn', function() {
        const id = $(this).data('id');

        Swal.fire({
            title: 'Are you sure?',
            text: "This will permanently delete the voucher!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#6b7280',
            confirmButtonText: '<i class="ti ti-trash"></i> Yes, delete it!',
            cancelButtonText: '<i class="ti ti-x"></i> Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `{{ url('admin/vouchers') }}/${id}`,
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
                        Swal.fire('Error!', 'Failed to delete voucher', 'error');
                    }
                });
            }
        });
    });

    // Toggle Status
    $(document).on('change', '.status-toggle', function() {
        const id = $(this).data('id');
        const checkbox = $(this);

        $.post(`{{ url('admin/vouchers') }}/${id}/toggle-status`, function(response) {
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
