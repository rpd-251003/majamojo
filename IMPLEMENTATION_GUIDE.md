# 🎮 Majamojo Game Membership System - Implementation Guide

## 📋 Status Implementasi

### ✅ SUDAH SELESAI

#### 1. Database & Migrations
- ✅ Migration `add_role_to_users_table` - menambah kolom role (admin, membership, reguler)
- ✅ Migration `create_games_table` - tabel games dengan kolom id, name, status
- ✅ Migration `create_vouchers_table` - tabel vouchers dengan foreign key ke games
- ✅ Migration `create_events_table` - tabel events dengan foreign key ke games
- ✅ Migration `create_super_deals_table` - tabel super_deals dengan foreign key ke games
- ✅ Database sudah di-migrate dan seeded

#### 2. Models dengan Relationships & Scopes
- ✅ `Game` model dengan relationships: vouchers(), events(), superDeals()
- ✅ `Voucher` model dengan scopes: active(), forRole()
- ✅ `Event` model dengan scope: active()
- ✅ `SuperDeal` model dengan scope: active()

#### 3. Authentication & Authorization
- ✅ Laravel Breeze ter-install
- ✅ RoleMiddleware untuk role-based access
- ✅ Middleware registered di bootstrap/app.php
- ✅ 3 User sample:
  - `admin@majamojo.com` / `password` (Admin)
  - `membership@majamojo.com` / `password` (Membership)
  - `reguler@majamojo.com` / `password` (Reguler)

#### 4. Controllers
- ✅ `Admin/GameController` - Full CRUD dengan AJAX & DataTables
- ✅ `Admin/VoucherController` - Created (perlu diisi)
- ✅ `Admin/EventController` - Created (perlu diisi)
- ✅ `Admin/SuperDealController` - Created (perlu diisi)
- ✅ `Admin/DashboardController` - Created (perlu diisi)
- ✅ `User/DashboardController` - Created (perlu diisi)

#### 5. Routes
- ✅ Routes untuk Admin (games, vouchers, events, super-deals)
- ✅ Routes untuk User (dashboard, vouchers, events, super-deals)
- ✅ Middleware protection untuk semua routes

#### 6. Dependencies
- ✅ yajra/laravel-datatables-oracle installed

---

## 🔄 YANG PERLU DILENGKAPI

### 1. Lengkapi Controllers

#### A. VoucherController
File: `app/Http/Controllers/Admin/VoucherController.php`

```php
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use App\Models\Game;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class VoucherController extends Controller
{
    public function index()
    {
        $games = Game::where('status', true)->get();
        return view('admin.vouchers.index', compact('games'));
    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $query = Voucher::with('game');

            // Filter by game_id
            if ($request->has('game_id') && $request->game_id != '') {
                $query->where('game_id', $request->game_id);
            }

            // Filter by date range
            if ($request->has('start_date') && $request->start_date != '') {
                $query->whereDate('start_date', '>=', $request->start_date);
            }

            if ($request->has('end_date') && $request->end_date != '') {
                $query->whereDate('end_date', '<=', $request->end_date);
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('game_name', function ($row) {
                    return $row->game->name;
                })
                ->addColumn('type_badge', function ($row) {
                    $badges = [
                        'membership_only' => 'bg-primary',
                        'reguler_only' => 'bg-success',
                        'all' => 'bg-info'
                    ];
                    $badge = $badges[$row->type] ?? 'bg-secondary';
                    return '<span class="badge ' . $badge . '">' . ucfirst(str_replace('_', ' ', $row->type)) . '</span>';
                })
                ->addColumn('status', function ($row) {
                    $checked = $row->status ? 'checked' : '';
                    return '<div class="form-check form-switch">
                        <input class="form-check-input status-toggle" type="checkbox"
                        data-id="' . $row->id . '" ' . $checked . '>
                    </div>';
                })
                ->addColumn('action', function ($row) {
                    return '<div class="btn-group" role="group">
                        <button type="button" class="btn btn-sm btn-primary edit-btn" data-id="' . $row->id . '">
                            <i class="bi bi-pencil"></i> Edit
                        </button>
                        <button type="button" class="btn btn-sm btn-danger delete-btn" data-id="' . $row->id . '">
                            <i class="bi bi-trash"></i> Delete
                        </button>
                    </div>';
                })
                ->rawColumns(['type_badge', 'status', 'action'])
                ->make(true);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'game_id' => 'required|exists:games,id',
            'promo_code' => 'required|string|unique:vouchers,promo_code',
            'type' => 'required|in:membership_only,reguler_only,all',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'external_link' => 'nullable|url',
            'status' => 'boolean',
        ]);

        try {
            Voucher::create($request->all());
            return response()->json([
                'success' => true,
                'message' => 'Voucher created successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create voucher: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $voucher = Voucher::with('game')->findOrFail($id);
            return response()->json([
                'success' => true,
                'data' => $voucher
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Voucher not found'
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'game_id' => 'required|exists:games,id',
            'promo_code' => 'required|string|unique:vouchers,promo_code,' . $id,
            'type' => 'required|in:membership_only,reguler_only,all',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'external_link' => 'nullable|url',
            'status' => 'boolean',
        ]);

        try {
            $voucher = Voucher::findOrFail($id);
            $voucher->update($request->all());
            return response()->json([
                'success' => true,
                'message' => 'Voucher updated successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update voucher: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $voucher = Voucher::findOrFail($id);
            $voucher->delete();
            return response()->json([
                'success' => true,
                'message' => 'Voucher deleted successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete voucher: ' . $e->getMessage()
            ], 500);
        }
    }

    public function toggleStatus(Request $request, $id)
    {
        try {
            $voucher = Voucher::findOrFail($id);
            $voucher->update(['status' => !$voucher->status]);
            return response()->json([
                'success' => true,
                'message' => 'Status updated successfully!',
                'status' => $voucher->status
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update status'
            ], 500);
        }
    }
}
```

#### B. EventController & SuperDealController
Gunakan pola yang sama seperti VoucherController, dengan menyesuaikan field validation.

#### C. DashboardController (Admin)
File: `app/Http/Controllers/Admin/DashboardController.php`

```php
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\Voucher;
use App\Models\Event;
use App\Models\SuperDeal;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_games' => Game::count(),
            'total_vouchers' => Voucher::count(),
            'total_events' => Event::count(),
            'total_deals' => SuperDeal::count(),
            'active_vouchers' => Voucher::active()->count(),
            'active_events' => Event::active()->count(),
            'active_deals' => SuperDeal::active()->count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
```

#### D. DashboardController (User)
File: `app/Http/Controllers/User/DashboardController.php`

```php
<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use App\Models\Event;
use App\Models\SuperDeal;

class DashboardController extends Controller
{
    public function index()
    {
        $userRole = auth()->user()->role;

        $vouchers = Voucher::with('game')
            ->active()
            ->forRole($userRole)
            ->latest()
            ->take(5)
            ->get();

        $events = Event::with('game')
            ->active()
            ->latest()
            ->take(5)
            ->get();

        $deals = SuperDeal::with('game')
            ->active()
            ->latest()
            ->take(5)
            ->get();

        return view('user.dashboard', compact('vouchers', 'events', 'deals'));
    }

    public function vouchers()
    {
        return view('user.vouchers');
    }

    public function events()
    {
        return view('user.events');
    }

    public function superDeals()
    {
        return view('user.super-deals');
    }
}
```

---

### 2. Buat Views (Blade Templates)

#### Struktur Folder Views
```
resources/views/
├── admin/
│   ├── layouts/
│   │   └── app.blade.php
│   ├── dashboard.blade.php
│   ├── games/
│   │   └── index.blade.php
│   ├── vouchers/
│   │   └── index.blade.php
│   ├── events/
│   │   └── index.blade.php
│   └── super-deals/
│       └── index.blade.php
└── user/
    ├── layouts/
    │   └── app.blade.php
    ├── dashboard.blade.php
    ├── vouchers.blade.php
    ├── events.blade.php
    └── super-deals.blade.php
```

#### Contoh: Admin Layout
File: `resources/views/admin/layouts/app.blade.php`

```blade
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }} - Admin</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    @stack('styles')
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('admin.dashboard') }}">
                <i class="bi bi-controller"></i> Majamojo Admin
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.games.index') }}">Games</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.vouchers.index') }}">Vouchers</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.events.index') }}">Events</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.super-deals.index') }}">Super Deals</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            {{ auth()->user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container-fluid mt-4">
        @yield('content')
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Setup AJAX CSRF Token
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>

    @stack('scripts')
</body>
</html>
```

#### Contoh: Games Index View
File: `resources/views/admin/games/index.blade.php`

```blade
@extends('admin.layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Games Management</h5>
                <button type="button" class="btn btn-primary" id="createBtn">
                    <i class="bi bi-plus-circle"></i> Add New Game
                </button>
            </div>
            <div class="card-body">
                <table id="gamesTable" class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Create/Edit -->
<div class="modal fade" id="gameModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="gameForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Add New Game</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="gameId">
                    <div class="mb-3">
                        <label for="name" class="form-label">Game Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="status" name="status" checked>
                            <label class="form-check-label" for="status">Active</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
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
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'name', name: 'name' },
            { data: 'status', name: 'status', orderable: false },
            { data: 'created_at', name: 'created_at' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ]
    });

    // Create Button
    $('#createBtn').click(function() {
        $('#gameForm')[0].reset();
        $('#gameId').val('');
        $('#modalTitle').text('Add New Game');
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
                $('#modalTitle').text('Edit Game');
                $('#gameModal').modal('show');
            }
        });
    });

    // Submit Form
    $('#gameForm').submit(function(e) {
        e.preventDefault();
        const id = $('#gameId').val();
        const url = id ? `{{ url('admin/games') }}/${id}` : '{{ route("admin.games.store") }}';
        const method = id ? 'PUT' : 'POST';

        $.ajax({
            url: url,
            method: method,
            data: {
                name: $('#name').val(),
                status: $('#status').is(':checked') ? 1 : 0
            },
            success: function(response) {
                if (response.success) {
                    $('#gameModal').modal('hide');
                    table.ajax.reload();
                    Swal.fire('Success!', response.message, 'success');
                }
            },
            error: function(xhr) {
                Swal.fire('Error!', xhr.responseJSON?.message || 'Something went wrong', 'error');
            }
        });
    });

    // Delete Button
    $(document).on('click', '.delete-btn', function() {
        const id = $(this).data('id');
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `{{ url('admin/games') }}/${id}`,
                    method: 'DELETE',
                    success: function(response) {
                        if (response.success) {
                            table.ajax.reload();
                            Swal.fire('Deleted!', response.message, 'success');
                        }
                    }
                });
            }
        });
    });

    // Toggle Status
    $(document).on('change', '.status-toggle', function() {
        const id = $(this).data('id');
        $.post(`{{ url('admin/games') }}/${id}/toggle-status`, function(response) {
            if (response.success) {
                Swal.fire({
                    icon: 'success',
                    title: response.message,
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });
            }
        });
    });
});
</script>
@endpush
```

---

### 3. Testing

#### Login Credentials
```
Admin:
Email: admin@majamojo.com
Password: password

Membership:
Email: membership@majamojo.com
Password: password

Reguler:
Email: reguler@majamojo.com
Password: password
```

#### Testing Steps
1. Start server: `php artisan serve`
2. Login sebagai admin
3. Test CRUD operations di Games
4. Test filtering di Vouchers, Events, Super Deals
5. Logout dan login sebagai membership/reguler
6. Verify data filtering berdasarkan role

---

### 4. Fitur Tambahan yang Bisa Ditambahkan

#### Upload Images
Untuk Events dan Super Deals yang memiliki `banner_image`:

1. Install intervention/image:
```bash
composer require intervention/image
```

2. Tambahkan method upload di controller:
```php
use Intervention\Image\Facades\Image;

private function uploadImage($file)
{
    $filename = time() . '_' . $file->getClientOriginalName();
    $path = public_path('uploads/banners');

    if (!file_exists($path)) {
        mkdir($path, 0777, true);
    }

    Image::make($file)->resize(800, 400)->save($path . '/' . $filename);

    return 'uploads/banners/' . $filename;
}
```

#### Export ke Excel/PDF
Install package:
```bash
composer require maatwebsite/excel
composer require barryvdh/laravel-dompdf
```

---

## 🚀 Quick Start

1. Copy semua controller code di atas
2. Buat views sesuai struktur folder
3. Run `php artisan serve`
4. Access `http://127.0.0.1:8000`
5. Login dengan credentials di atas

---

## 📝 Notes

- Semua routes sudah protected dengan middleware `auth` dan `role`
- DataTables sudah server-side processing
- AJAX operations tanpa page reload
- Bootstrap 5 + Bootstrap Icons
- SweetAlert2 untuk notifikasi yang cantik

---

## 🛠 Troubleshooting

### Error: Class 'DataTables' not found
```bash
composer require yajra/laravel-datatables-oracle
```

### Error: 403 Forbidden
- Pastikan user sudah login
- Check role user di database
- Verify middleware di routes

### DataTables tidak muncul
- Check console browser untuk error JavaScript
- Pastikan CDN links loaded
- Verify route `getData()` returns JSON

---

## 📞 Support

Jika ada pertanyaan atau issues, silakan buat dokumentasi atau catatan untuk tim development.

Happy Coding! 🎮✨
