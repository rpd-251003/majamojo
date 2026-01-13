@extends('admin.layouts.app')

@section('title', 'Ticket Management')

@section('content')
        <!-- Page Header -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item" aria-current="page">Ticket Management</li>
                        </ul>
                    </div>
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">Support Tickets</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row">
            <div class="col-md-6 col-xl-3">
                <div class="card bg-primary-dark dashnum-card text-white overflow-hidden">
                    <span class="round small"></span>
                    <span class="round big"></span>
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <div class="avtar avtar-lg">
                                    <i class="ti ti-ticket text-white" style="font-size: 30px;"></i>
                                </div>
                            </div>
                            <div class="col-auto">
                                <span class="badge bg-light-primary border border-light-primary text-white">Total</span>
                            </div>
                        </div>
                        <span class="text-white d-block f-34 f-w-500 my-2">{{ $stats['total'] }}</span>
                        <p class="mb-0 opacity-75">Total Tickets</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="card bg-warning dashnum-card text-white overflow-hidden">
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
                                <span class="badge bg-light-warning border border-light-warning text-white">Premium</span>
                            </div>
                        </div>
                        <span class="text-white d-block f-34 f-w-500 my-2">{{ $stats['premium'] }}</span>
                        <p class="mb-0 opacity-75">Premium Users</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="card bg-secondary-dark dashnum-card text-white overflow-hidden">
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
                                <span class="badge bg-light-secondary border border-light-secondary text-white">Regular</span>
                            </div>
                        </div>
                        <span class="text-white d-block f-34 f-w-500 my-2">{{ $stats['regular'] }}</span>
                        <p class="mb-0 opacity-75">Regular Users</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="card bg-success dashnum-card text-white overflow-hidden">
                    <span class="round small"></span>
                    <span class="round big"></span>
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <div class="avtar avtar-lg">
                                    <i class="ti ti-clock text-white" style="font-size: 30px;"></i>
                                </div>
                            </div>
                            <div class="col-auto">
                                <span class="badge bg-light-success border border-light-success text-white">Active</span>
                            </div>
                        </div>
                        <span class="text-white d-block f-34 f-w-500 my-2">{{ $stats['open'] + $stats['in_progress'] }}</span>
                        <p class="mb-0 opacity-75">Active Tickets</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters Card -->
        <div class="card">
            <div class="card-header">
                <h5>Filters</h5>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('admin.tickets.index') }}">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select" onchange="this.form.submit()">
                                <option value="">All Status</option>
                                <option value="open" {{ request('status') == 'open' ? 'selected' : '' }}>Open</option>
                                <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>Resolved</option>
                                <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Closed</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Priority</label>
                            <select name="priority" class="form-select" onchange="this.form.submit()">
                                <option value="">All Priority</option>
                                <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>Low</option>
                                <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>Medium</option>
                                <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>High</option>
                                <option value="urgent" {{ request('priority') == 'urgent' ? 'selected' : '' }}>Urgent</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">User Type</label>
                            <select name="user_type" class="form-select" onchange="this.form.submit()">
                                <option value="">All Users</option>
                                <option value="membership" {{ request('user_type') == 'membership' ? 'selected' : '' }}>Premium Users</option>
                                <option value="reguler" {{ request('user_type') == 'reguler' ? 'selected' : '' }}>Regular Users</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Search</label>
                            <div class="input-group">
                                <input type="text" name="search" class="form-control" placeholder="Ticket # or Subject" value="{{ request('search') }}">
                                <button class="btn btn-primary" type="submit">
                                    <i class="ti ti-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    @if(request()->hasAny(['status', 'priority', 'user_type', 'search']))
                        <div class="mt-3">
                            <a href="{{ route('admin.tickets.index') }}" class="btn btn-sm btn-light-secondary">
                                <i class="ti ti-x me-1"></i>Clear Filters
                            </a>
                        </div>
                    @endif
                </form>
            </div>
        </div>

        <!-- Tickets Table -->
        <div class="card">
            <div class="card-header">
                <h5>All Tickets</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Ticket #</th>
                                <th>User</th>
                                <th>User Type</th>
                                <th>Subject</th>
                                <th>Status</th>
                                <th>Priority</th>
                                <th>Assigned To</th>
                                <th>Last Activity</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tickets as $ticket)
                                <tr>
                                    <td>
                                        <strong class="text-primary">{{ $ticket->ticket_number }}</strong>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <div class="avtar avtar-s bg-light-primary">
                                                    <i class="ti ti-user"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 ms-2">
                                                <h6 class="mb-0">{{ $ticket->user->name }}</h6>
                                                <small class="text-muted">{{ $ticket->user->email }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        {!! $ticket->user_type_badge !!}
                                    </td>
                                    <td>
                                        <h6 class="mb-0">{{ Str::limit($ticket->subject, 40) }}</h6>
                                        @if($ticket->latestMessage)
                                            <small class="text-muted">{{ Str::limit($ticket->latestMessage->message, 50) }}</small>
                                        @endif
                                    </td>
                                    <td>{!! $ticket->status_badge !!}</td>
                                    <td>{!! $ticket->priority_badge !!}</td>
                                    <td>
                                        @if($ticket->assignedAdmin)
                                            <div class="d-flex align-items-center">
                                                <div class="avtar avtar-xs bg-light-success me-2">
                                                    <i class="ti ti-user-check"></i>
                                                </div>
                                                <span>{{ $ticket->assignedAdmin->name }}</span>
                                            </div>
                                        @else
                                            <span class="text-muted">Unassigned</span>
                                        @endif
                                    </td>
                                    <td>
                                        <small>{{ $ticket->updated_at->format('M d, Y') }}</small><br>
                                        <small class="text-muted">{{ $ticket->updated_at->diffForHumans() }}</small>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.tickets.show', $ticket->id) }}" class="btn btn-sm btn-light-primary">
                                            <i class="ti ti-eye me-1"></i>View
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center py-5">
                                        <div class="text-center">
                                            <i class="ti ti-ticket" style="font-size: 48px; opacity: 0.3;"></i>
                                            <p class="mt-2 text-muted">No tickets found</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($tickets->hasPages())
                <div class="card-footer">
                    {{ $tickets->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
