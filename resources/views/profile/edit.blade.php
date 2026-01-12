@extends('user.layouts.app')

@section('title', 'Profile Settings')

@section('content')
<!-- [ breadcrumb ] start -->
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item" aria-current="page">Profile Settings</li>
                </ul>
            </div>
            <div class="col-md-12">
                <div class="page-header-title">
                    <h2 class="mb-0">Profile Settings</h2>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- [ breadcrumb ] end -->

<div class="row">
    <!-- Update Profile Information -->
    <div class="col-12 col-lg-6">
        <div class="card">
            <div class="card-header">
                <h5>Profile Information</h5>
                <p class="text-muted small mb-0">Update your account's profile information and email address.</p>
            </div>
            <div class="card-body">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>
    </div>

    <!-- Update Password -->
    <div class="col-12 col-lg-6">
        <div class="card">
            <div class="card-header">
                <h5>Update Password</h5>
                <p class="text-muted small mb-0">Ensure your account is using a long, random password to stay secure.</p>
            </div>
            <div class="card-body">
                @include('profile.partials.update-password-form')
            </div>
        </div>
    </div>

    <!-- Delete Account -->
    <div class="col-12">
        <div class="card border-danger">
            <div class="card-header bg-light-danger">
                <h5 class="text-danger">Delete Account</h5>
                <p class="text-muted small mb-0">Once your account is deleted, all of its resources and data will be permanently deleted.</p>
            </div>
            <div class="card-body">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
/* Profile Page Styles */
.profile-form-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.profile-form-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
}

.form-control:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}

/* Gaming Theme Overrides for Profile */
body.gaming-theme .card {
    background: var(--glass-bg);
    border: 1px solid var(--glass-border);
}

body.gaming-theme .form-control {
    background: rgba(0, 212, 255, 0.05);
    border-color: var(--glass-border);
    color: #f0f0f0;
}

body.gaming-theme .form-control:focus {
    background: rgba(0, 212, 255, 0.1);
    border-color: var(--gaming-primary);
    box-shadow: 0 0 0 0.2rem rgba(0, 212, 255, 0.25);
    color: #f0f0f0;
}

body.gaming-theme .form-label {
    color: #d0d0d0;
}

body.gaming-theme .modal-content {
    background: var(--glass-bg);
    border: 1px solid var(--glass-border);
}

body.gaming-theme .modal-header {
    border-bottom-color: var(--glass-border);
}

body.gaming-theme .modal-footer {
    border-top-color: var(--glass-border);
}
</style>
@endpush
