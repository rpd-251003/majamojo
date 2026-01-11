# 🎨 Berry Template Integration Guide

## ✅ SUDAH DIINTEGRASIKAN

### 1. Layout Admin dengan Berry Template
**File:** `resources/views/admin/layouts/app.blade.php`

✅ **Fitur yang sudah terintegrasi:**
- Sidebar navigation dengan Berry style
- Header topbar dengan user dropdown
- Pre-loader animation
- Responsive mobile menu
- Berry CSS & JS files dari `public/berry-template/dist/`
- DataTables & SweetAlert2 tetap digunakan
- CSRF token setup
- AJAX error handling

✅ **Icons yang digunakan:**
- Tabler Icons (ti ti-*) - dari Berry template
- Contoh: `<i class="ti ti-dashboard"></i>`

### 2. Dashboard Admin
**File:** `resources/views/admin/dashboard.blade.php`

✅ **Komponen Berry yang digunakan:**
- Breadcrumb navigation
- `dashnum-card` - Statistics cards dengan gradient background
- `avtar` - Avatar/icon containers
- Progress bars
- `table-card` - Cards untuk recent data tables
- Badge components dengan `bg-light-*` classes

### 3. Games Management
**File:** `resources/views/admin/games/index.blade.php`

✅ **Komponen Berry yang digunakan:**
- Page header dengan breadcrumb
- Card dengan header & body
- Modal dengan Berry styling
- Table responsive
- Form controls dengan Berry style
- Buttons dengan Tabler icons

---

## 📁 Struktur Asset Berry Template

```
public/berry-template/dist/
├── assets/
│   ├── css/
│   │   ├── style.css           ← Main Berry CSS
│   │   └── style-preset.css    ← Theme presets
│   ├── fonts/
│   │   ├── tabler-icons.min.css  ← Icons (ti ti-*)
│   │   ├── feather.css
│   │   ├── fontawesome.css
│   │   ├── material.css
│   │   └── phosphor/
│   ├── images/
│   │   ├── logo-dark.svg       ← Logo default
│   │   └── favicon.svg
│   └── js/
│       ├── plugins/
│       │   ├── bootstrap.min.js
│       │   ├── popper.min.js
│       │   └── simplebar.min.js
│       ├── pcoded.js           ← Berry core JS
│       └── fonts/custom-font.js
```

---

## 🎨 Berry Components Reference

### 1. Cards

#### Statistics Card (Dashnum Card)
```blade
<div class="card bg-primary-dark dashnum-card text-white overflow-hidden">
    <span class="round small"></span>
    <span class="round big"></span>
    <div class="card-body">
        <div class="row">
            <div class="col">
                <div class="avtar avtar-lg">
                    <i class="ti ti-device-gamepad"></i>
                </div>
            </div>
            <div class="col-auto">
                <h5 class="text-white mb-1">100</h5>
                <span class="text-white text-opacity-75">Total Games</span>
            </div>
        </div>
        <div class="bg-body progress mt-3" style="height: 8px">
            <div class="progress-bar bg-white" style="width: 75%"></div>
        </div>
    </div>
</div>
```

**Available colors:**
- `bg-primary-dark`
- `bg-success-dark`
- `bg-warning-dark`
- `bg-danger-dark`
- `bg-info-dark`

#### Standard Card
```blade
<div class="card">
    <div class="card-header">
        <h5>Card Title</h5>
    </div>
    <div class="card-body">
        <!-- Content -->
    </div>
</div>
```

#### Table Card
```blade
<div class="card table-card">
    <div class="card-header d-flex align-items-center justify-content-between py-3">
        <h5>Table Title</h5>
        <a href="#" class="btn btn-sm btn-link-primary">View All</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <!-- Table content -->
            </table>
        </div>
    </div>
</div>
```

### 2. Badges

```blade
<!-- Status badges -->
<span class="badge bg-light-success">Active</span>
<span class="badge bg-light-danger">Inactive</span>
<span class="badge bg-light-primary">Membership</span>
<span class="badge bg-light-warning">Pending</span>
<span class="badge bg-light-info">All</span>
<span class="badge bg-light-secondary">Draft</span>
```

### 3. Avatars

```blade
<!-- Large avatar with icon -->
<div class="avtar avtar-lg">
    <i class="ti ti-device-gamepad"></i>
</div>

<!-- Small avatar with background -->
<div class="avtar avtar-s bg-light-primary">
    <i class="ti ti-device-gamepad"></i>
</div>

<!-- Available background colors -->
bg-light-primary
bg-light-success
bg-light-warning
bg-light-danger
bg-light-info
bg-light-secondary
```

### 4. Buttons

```blade
<!-- Primary button -->
<button class="btn btn-primary">
    <i class="ti ti-plus"></i> Add New
</button>

<!-- Button variants -->
<button class="btn btn-success">Success</button>
<button class="btn btn-warning">Warning</button>
<button class="btn btn-danger">Danger</button>
<button class="btn btn-info">Info</button>

<!-- Outline buttons -->
<button class="btn btn-outline-primary">Outline Primary</button>
<button class="btn btn-outline-secondary">Outline Secondary</button>

<!-- Link style buttons -->
<button class="btn btn-link-primary">Link Primary</button>
<button class="btn btn-link-success">Link Success</button>

<!-- Button sizes -->
<button class="btn btn-sm btn-primary">Small</button>
<button class="btn btn-lg btn-primary">Large</button>
```

### 5. Page Header & Breadcrumb

```blade
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item" aria-current="page">Current Page</li>
                </ul>
            </div>
            <div class="col-md-12">
                <div class="page-header-title">
                    <h2 class="mb-0">Page Title</h2>
                </div>
            </div>
        </div>
    </div>
</div>
```

### 6. Forms

```blade
<!-- Form Group -->
<div class="mb-3">
    <label class="form-label">Label <span class="text-danger">*</span></label>
    <input type="text" class="form-control" placeholder="Enter text">
    <small class="text-muted">Helper text</small>
</div>

<!-- Switch -->
<div class="form-check form-switch">
    <input class="form-check-input" type="checkbox" id="switch1">
    <label class="form-check-label" for="switch1">
        Enable Feature
    </label>
</div>

<!-- Select -->
<div class="mb-3">
    <label class="form-label">Select Option</label>
    <select class="form-select">
        <option value="">Choose...</option>
        <option value="1">Option 1</option>
        <option value="2">Option 2</option>
    </select>
</div>
```

### 7. Modals

```blade
<div class="modal fade" id="exampleModal" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modal Title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <!-- Modal content -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    Close
                </button>
                <button type="button" class="btn btn-primary">
                    Save changes
                </button>
            </div>
        </div>
    </div>
</div>
```

---

## 🎨 Tabler Icons Reference

**Commonly used icons:**

| Icon | Class | Usage |
|------|-------|-------|
| Dashboard | `ti ti-dashboard` | Dashboard menu |
| Games | `ti ti-device-gamepad` | Games |
| Voucher | `ti ti-ticket` | Vouchers |
| Event | `ti ti-calendar-event` | Events |
| Gift | `ti ti-gift` | Super Deals |
| User | `ti ti-user` | User profile |
| Settings | `ti ti-settings` | Settings |
| Logout | `ti ti-logout` | Logout |
| Plus | `ti ti-plus` | Add/Create |
| Edit | `ti ti-edit` / `ti ti-pencil` | Edit |
| Delete | `ti ti-trash` | Delete |
| Check | `ti ti-check` | Success/Confirm |
| X | `ti ti-x` | Close/Cancel |
| Menu | `ti ti-menu-2` | Menu toggle |
| Bolt | `ti ti-bolt` | Quick actions |
| Loader | `ti ti-loader` | Loading |

**Full icon list:** https://tabler-icons.io/

---

## 📝 Template untuk View Baru

### Create New View dengan Berry Template

```blade
@extends('admin.layouts.app')

@section('title', 'Page Title')

@section('content')
<!-- [ breadcrumb ] start -->
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item" aria-current="page">Page Name</li>
                </ul>
            </div>
            <div class="col-md-12">
                <div class="page-header-title">
                    <h2 class="mb-0">Page Title</h2>
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
            <div class="card-header">
                <h5>Card Title</h5>
            </div>
            <div class="card-body">
                <!-- Your content here -->
            </div>
        </div>
    </div>
</div>
<!-- [ Main Content ] end -->
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Your JavaScript here
});
</script>
@endpush
```

---

## 🚀 Quick Start untuk Development

### 1. Buat View Baru untuk Vouchers

**File:** `resources/views/admin/vouchers/index.blade.php`

```bash
# Buat folder
mkdir -p resources/views/admin/vouchers

# Copy template dari games
cp resources/views/admin/games/index.blade.php resources/views/admin/vouchers/index.blade.php
```

Kemudian sesuaikan:
- Ganti semua 'games' menjadi 'vouchers'
- Ganti icon `ti ti-device-gamepad` menjadi `ti ti-ticket`
- Tambahkan kolom sesuai kebutuhan (game_id, promo_code, type, etc.)
- Tambahkan filter untuk game & date range

### 2. Gunakan Berry Components

**Contoh: Tambahkan filter dropdown**

```blade
<div class="card">
    <div class="card-body">
        <div class="row mb-3">
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
```

---

## 💡 Tips & Best Practices

### 1. Menggunakan Asset Helper
```blade
<!-- BENAR -->
<link rel="stylesheet" href="{{ asset('berry-template/dist/assets/css/style.css') }}">

<!-- SALAH -->
<link rel="stylesheet" href="/berry-template/dist/assets/css/style.css">
```

### 2. Icons Consistency
Gunakan Tabler Icons (ti ti-*) untuk konsistensi dengan Berry template.

### 3. Color Scheme
Berry template menggunakan:
- Primary: Blue
- Success: Green
- Warning: Orange/Yellow
- Danger: Red
- Info: Cyan
- Secondary: Gray

### 4. Spacing
Berry menggunakan Bootstrap 5 spacing utilities:
- `mb-3` - margin bottom 1rem
- `mt-4` - margin top 1.5rem
- `p-3` - padding 1rem
- `gap-2` - gap 0.5rem

---

## 🔧 Troubleshooting

### Issue: Icons tidak muncul
**Solution:** Pastikan Tabler Icons CSS sudah di-load:
```blade
<link rel="stylesheet" href="{{ asset('berry-template/dist/assets/fonts/tabler-icons.min.css') }}" />
```

### Issue: Sidebar tidak berfungsi
**Solution:** Pastikan Berry JS sudah di-load:
```blade
<script src="{{ asset('berry-template/dist/assets/js/pcoded.js') }}"></script>
```

### Issue: Modal backdrop tidak hilang
**Solution:** Gunakan `data-bs-backdrop="static"` pada modal:
```blade
<div class="modal fade" id="myModal" tabindex="-1" data-bs-backdrop="static">
```

---

## 📚 Resources

- **Berry Template Docs:** Check `public/berry-template/dist/` untuk examples
- **Tabler Icons:** https://tabler-icons.io/
- **Bootstrap 5 Docs:** https://getbootstrap.com/docs/5.3/

---

**Last Updated:** 2026-01-11
**Berry Template Version:** Latest
**Bootstrap Version:** 5.x
