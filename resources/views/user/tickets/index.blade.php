@extends('user.layouts.app')

@section('title', 'My Support Tickets')

@section('content')
        <!-- Page Header -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item" aria-current="page">Support Tickets</li>
                        </ul>
                    </div>
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">My Support Tickets</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tickets List -->
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5>All Tickets</h5>
                        <a href="{{ route('user.tickets.create') }}" class="btn btn-primary">
                            <i class="ti ti-plus me-2"></i>Create New Ticket
                        </a>
                    </div>
                    <div class="card-body">
                        @if($tickets->isEmpty())
                            <div class="text-center py-5">
                                <i class="ti ti-ticket-off" style="font-size: 64px; color: #ccc;"></i>
                                <h4 class="mt-3">No Tickets Yet</h4>
                                <p class="text-muted">You haven't created any support tickets.</p>
                                <a href="{{ route('user.tickets.create') }}" class="btn btn-primary mt-3">
                                    Create Your First Ticket
                                </a>
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Ticket #</th>
                                            <th>Subject</th>
                                            <th>Status</th>
                                            <th>Priority</th>
                                            <th>Last Updated</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($tickets as $ticket)
                                            <tr>
                                                <td><strong>{{ $ticket->ticket_number }}</strong></td>
                                                <td>
                                                    <a href="{{ route('user.tickets.show', $ticket->id) }}" class="text-decoration-none">
                                                        {{ Str::limit($ticket->subject, 50) }}
                                                    </a>
                                                    @if($ticket->latestMessage)
                                                        <br>
                                                        <small class="text-muted">
                                                            <i class="ti ti-message"></i>
                                                            {{ Str::limit($ticket->latestMessage->message, 60) }}
                                                        </small>
                                                    @endif
                                                </td>
                                                <td>{!! $ticket->status_badge !!}</td>
                                                <td>{!! $ticket->priority_badge !!}</td>
                                                <td>{{ $ticket->updated_at->diffForHumans() }}</td>
                                                <td>
                                                    <a href="{{ route('user.tickets.show', $ticket->id) }}" class="btn btn-sm btn-light-primary">
                                                        <i class="ti ti-eye"></i> View
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            <div class="d-flex justify-content-center mt-3">
                                {{ $tickets->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
@endsection
