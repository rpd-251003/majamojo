@extends('user.layouts.app')

@section('title', 'Create Support Ticket')

@section('content')
        <!-- Page Header -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('user.tickets.index') }}">Support Tickets</a></li>
                            <li class="breadcrumb-item" aria-current="page">Create Ticket</li>
                        </ul>
                    </div>
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">Create New Support Ticket</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Create Ticket Form -->
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h5>Ticket Details</h5>
                        <p class="text-muted mb-0">Please provide details about your issue or question</p>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('user.tickets.store') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label" for="subject">Subject <span class="text-danger">*</span></label>
                                <input type="text"
                                       class="form-control @error('subject') is-invalid @enderror"
                                       id="subject"
                                       name="subject"
                                       value="{{ old('subject') }}"
                                       placeholder="Brief description of your issue"
                                       required>
                                @error('subject')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">This will be the title of your ticket</small>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="priority">Priority <span class="text-danger">*</span></label>
                                <select class="form-select @error('priority') is-invalid @enderror" id="priority" name="priority" required>
                                    <option value="">Select Priority</option>
                                    <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Low - General inquiry</option>
                                    <option value="medium" {{ old('priority') == 'medium' ? 'selected' : '' }}>Medium - Issue affecting functionality</option>
                                    <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>High - Significant issue</option>
                                    <option value="urgent" {{ old('priority') == 'urgent' ? 'selected' : '' }}>Urgent - Critical issue</option>
                                </select>
                                @error('priority')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="description">Description <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('description') is-invalid @enderror"
                                          id="description"
                                          name="description"
                                          rows="6"
                                          placeholder="Please provide detailed information about your issue..."
                                          required>{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">This will be the first message in your ticket conversation</small>
                            </div>

                            <div class="alert alert-info">
                                <i class="ti ti-info-circle me-2"></i>
                                <strong>Note:</strong> Our support team will respond to your ticket as soon as possible. You'll be able to chat with them in real-time once your ticket is created.
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('user.tickets.index') }}" class="btn btn-light">
                                    <i class="ti ti-arrow-left me-2"></i>Cancel
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="ti ti-send me-2"></i>Create Ticket
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
@endsection
