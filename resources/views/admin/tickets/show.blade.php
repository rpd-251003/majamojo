@extends('admin.layouts.app')

@section('title', 'Ticket #' . $ticket->ticket_number)

@section('content')
<div class="pc-container">
    <div class="pc-content">
        <!-- Page Header -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.tickets.index') }}">Tickets</a></li>
                            <li class="breadcrumb-item" aria-current="page">{{ $ticket->ticket_number }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Ticket Info & Management Sidebar -->
            <div class="col-lg-4">
                <!-- Ticket Information -->
                <div class="card">
                    <div class="card-header">
                        <h5>Ticket Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="text-muted mb-1">Ticket Number</label>
                            <h6>{{ $ticket->ticket_number }}</h6>
                        </div>

                        <div class="mb-3">
                            <label class="text-muted mb-1">Subject</label>
                            <h6>{{ $ticket->subject }}</h6>
                        </div>

                        <div class="mb-3">
                            <label class="text-muted mb-1">Description</label>
                            <p class="mb-0">{{ $ticket->description }}</p>
                        </div>

                        <div class="mb-3">
                            <label class="text-muted mb-1">Created</label>
                            <p class="mb-0">{{ $ticket->created_at->format('M d, Y h:i A') }}</p>
                            <small class="text-muted">{{ $ticket->created_at->diffForHumans() }}</small>
                        </div>
                    </div>
                </div>

                <!-- User Information -->
                <div class="card">
                    <div class="card-header">
                        <h5>User Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="flex-shrink-0">
                                <div class="avtar avtar-lg bg-light-primary">
                                    <i class="ti ti-user" style="font-size: 24px;"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-0">{{ $ticket->user->name }}</h6>
                                <small class="text-muted">{{ $ticket->user->email }}</small>
                            </div>
                        </div>
                        <div class="mb-2">
                            <label class="text-muted mb-1">User Type</label>
                            <div>{!! $ticket->user_type_badge !!}</div>
                        </div>
                    </div>
                </div>

                <!-- Status Management -->
                <div class="card">
                    <div class="card-header">
                        <h5>Status Management</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.tickets.update-status', $ticket->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="mb-3">
                                <label class="form-label">Current Status</label>
                                <div>{!! $ticket->status_badge !!}</div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Update Status</label>
                                <select name="status" class="form-select" required>
                                    <option value="open" {{ $ticket->status == 'open' ? 'selected' : '' }}>Open</option>
                                    <option value="in_progress" {{ $ticket->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                    <option value="resolved" {{ $ticket->status == 'resolved' ? 'selected' : '' }}>Resolved</option>
                                    <option value="closed" {{ $ticket->status == 'closed' ? 'selected' : '' }}>Closed</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="ti ti-refresh me-2"></i>Update Status
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Priority Management -->
                <div class="card">
                    <div class="card-header">
                        <h5>Priority Management</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.tickets.update-priority', $ticket->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="mb-3">
                                <label class="form-label">Current Priority</label>
                                <div>{!! $ticket->priority_badge !!}</div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Update Priority</label>
                                <select name="priority" class="form-select" required>
                                    <option value="low" {{ $ticket->priority == 'low' ? 'selected' : '' }}>Low</option>
                                    <option value="medium" {{ $ticket->priority == 'medium' ? 'selected' : '' }}>Medium</option>
                                    <option value="high" {{ $ticket->priority == 'high' ? 'selected' : '' }}>High</option>
                                    <option value="urgent" {{ $ticket->priority == 'urgent' ? 'selected' : '' }}>Urgent</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-warning w-100">
                                <i class="ti ti-flag me-2"></i>Update Priority
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Assign Admin -->
                <div class="card">
                    <div class="card-header">
                        <h5>Assign Admin</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.tickets.assign', $ticket->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="mb-3">
                                <label class="form-label">Current Assignment</label>
                                @if($ticket->assignedAdmin)
                                    <div class="d-flex align-items-center">
                                        <div class="avtar avtar-s bg-light-success me-2">
                                            <i class="ti ti-user-check"></i>
                                        </div>
                                        <span>{{ $ticket->assignedAdmin->name }}</span>
                                    </div>
                                @else
                                    <p class="text-muted mb-0">Unassigned</p>
                                @endif
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Assign To</label>
                                <select name="assigned_to" class="form-select" required>
                                    <option value="">Select Admin</option>
                                    @foreach($admins as $admin)
                                        <option value="{{ $admin->id }}" {{ $ticket->assigned_to == $admin->id ? 'selected' : '' }}>
                                            {{ $admin->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-success w-100">
                                <i class="ti ti-user-check me-2"></i>Assign Admin
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Chat Area -->
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <i class="ti ti-messages me-2" style="font-size: 24px;"></i>
                                <div>
                                    <h5 class="text-white mb-0">Conversation</h5>
                                    <small class="text-white-50">Real-time support chat</small>
                                </div>
                            </div>
                            <div>
                                {!! $ticket->user_type_badge !!}
                            </div>
                        </div>
                    </div>
                    <div class="card-body" style="height: 600px; overflow-y: auto;" id="chatMessages">
                        @foreach($ticket->messages as $message)
                            <div class="message-item mb-4 {{ $message->is_admin ? 'admin-message' : 'user-message' }}" data-message-id="{{ $message->id }}">
                                <div class="d-flex align-items-end {{ $message->is_admin ? 'flex-row-reverse' : '' }}">
                                    <div class="flex-shrink-0 mb-1">
                                        <div class="avtar avtar-s {{ $message->is_admin ? 'bg-gradient-success' : 'bg-gradient-primary' }}" style="box-shadow: 0 4px 8px rgba(0,0,0,0.15);">
                                            <i class="ti {{ $message->is_admin ? 'ti-headset' : 'ti-user' }} text-white"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 {{ $message->is_admin ? 'me-2' : 'ms-2' }}" style="max-width: 75%;">
                                        <div class="chat-bubble {{ $message->is_admin ? 'admin-bubble' : 'user-bubble' }}">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <div class="d-flex align-items-center">
                                                    <strong class="me-2" style="font-size: 14px;">{{ $message->user->name }}</strong>
                                                    @if($message->is_admin)
                                                        <span class="badge bg-white text-success px-2 py-1" style="font-size: 9px; font-weight: 600;">
                                                            <i class="ti ti-check-circle" style="font-size: 10px;"></i> You
                                                        </span>
                                                    @else
                                                        <span class="badge {{ $message->user->role == 'membership' ? 'bg-warning' : 'bg-info' }} text-white px-2 py-1" style="font-size: 9px; font-weight: 600;">
                                                            <i class="ti ti-user" style="font-size: 10px;"></i> {{ ucfirst($message->user->role) }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <p class="mb-2" style="line-height: 1.6; font-size: 14px;">{{ $message->message }}</p>
                                            <small class="opacity-75 d-block text-end" style="font-size: 11px;">
                                                <i class="ti ti-clock" style="font-size: 11px;"></i>
                                                {{ $message->created_at->format('h:i A') }}
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @if($ticket->status !== 'closed')
                        <div class="card-footer">
                            <form id="messageForm" onsubmit="sendMessage(event)">
                                @csrf
                                <div class="input-group">
                                    <input type="text"
                                           class="form-control"
                                           id="messageInput"
                                           placeholder="Type your message here..."
                                           required>
                                    <button class="btn btn-primary" type="submit">
                                        <i class="ti ti-send"></i> Send
                                    </button>
                                </div>
                            </form>
                        </div>
                    @else
                        <div class="card-footer bg-light">
                            <p class="mb-0 text-center text-muted">
                                <i class="ti ti-lock me-2"></i>This ticket is closed. No new messages can be sent.
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Pusher JS -->
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>

<script>
    /* ===============================
     * Utilities
     * =============================== */
    function escapeHtml(text) {
        return text
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;");
    }

    function scrollToBottom() {
        const el = document.getElementById('chatMessages');
        el.scrollTop = el.scrollHeight;
    }

    /* ===============================
     * Pusher Init
     * =============================== */
    const pusher = new Pusher('{{ config('broadcasting.connections.pusher.key') }}', {
        cluster: '{{ config('broadcasting.connections.pusher.options.cluster') }}',
        authEndpoint: '/broadcasting/auth',
        auth: {
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        }
    });

    const channel = pusher.subscribe('private-ticket.{{ $ticket->id }}');

    channel.bind('message.new', (data) => {
        console.log('[PUSHER] New message:', data);
        appendMessage(data);
    });

    /* ===============================
     * Render Message
     * =============================== */
    function appendMessage(data) {
        const isAdmin = data.is_admin;
        const time = new Date(data.created_at);
        const timeStr = time.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' });

        const html = `
            <div class="message-item mb-4 ${isAdmin ? 'admin-message' : 'user-message'}"
                 data-message-id="${data.id}">
                <div class="d-flex align-items-end ${isAdmin ? 'flex-row-reverse' : ''}">
                    <div class="flex-shrink-0 mb-1">
                        <div class="avtar avtar-s ${isAdmin ? 'bg-gradient-success' : 'bg-gradient-primary'}" style="box-shadow: 0 4px 8px rgba(0,0,0,0.15);">
                            <i class="ti ${isAdmin ? 'ti-headset' : 'ti-user'} text-white"></i>
                        </div>
                    </div>

                    <div class="flex-grow-1 ${isAdmin ? 'me-2' : 'ms-2'}" style="max-width:75%;">
                        <div class="chat-bubble ${isAdmin ? 'admin-bubble' : 'user-bubble'}">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div class="d-flex align-items-center">
                                    <strong class="me-2" style="font-size: 14px;">${data.user_name}</strong>
                                    ${isAdmin
                                        ? '<span class="badge bg-white text-success px-2 py-1" style="font-size:9px; font-weight:600;"><i class="ti ti-check-circle" style="font-size:10px;"></i> You</span>'
                                        : '<span class="badge bg-info text-white px-2 py-1" style="font-size:9px; font-weight:600;"><i class="ti ti-user" style="font-size:10px;"></i> User</span>'}
                                </div>
                            </div>
                            <p class="mb-2" style="line-height: 1.6; font-size: 14px;">${escapeHtml(data.message)}</p>
                            <small class="opacity-75 d-block text-end" style="font-size: 11px;">
                                <i class="ti ti-clock" style="font-size: 11px;"></i>
                                ${timeStr}
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        `;

        document
            .getElementById('chatMessages')
            .insertAdjacentHTML('beforeend', html);

        scrollToBottom();
    }

    /* ===============================
     * Send Message
     * =============================== */
    function sendMessage(e) {
        e.preventDefault();

        const input = document.getElementById('messageInput');
        const message = input.value.trim();

        if (!message) return;

        input.disabled = true;

        fetch('{{ route('admin.tickets.message', $ticket->id) }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ message })
        })
        .then(res => res.json())
        .then(res => {
            if (res.success) {
                input.value = '';
            }
        })
        .catch(err => {
            console.error('[SEND MESSAGE ERROR]', err);
            alert('Failed to send message. Please try again.');
        })
        .finally(() => {
            input.disabled = false;
            input.focus();
        });
    }

    /* ===============================
     * Initial Scroll
     * =============================== */
    document.addEventListener('DOMContentLoaded', scrollToBottom);
</script>

<style>
    /* Chat Bubble Styles */
    .chat-bubble {
        padding: 16px 18px;
        border-radius: 18px;
        position: relative;
        word-wrap: break-word;
        transition: all 0.2s ease;
    }

    .admin-bubble {
        background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
        color: white;
        border-bottom-right-radius: 4px;
        box-shadow: 0 4px 12px rgba(72, 187, 120, 0.3);
    }

    .user-bubble {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-bottom-left-radius: 4px;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
    }

    .chat-bubble:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
    }

    /* Avatar Gradient */
    .bg-gradient-success {
        background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
    }

    .bg-gradient-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    /* Message Animation */
    .message-item {
        animation: fadeInUp 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(15px) scale(0.95);
        }
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    /* Scrollbar styling */
    #chatMessages::-webkit-scrollbar {
        width: 6px;
    }

    #chatMessages::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    #chatMessages::-webkit-scrollbar-thumb {
        background: #999;
        border-radius: 10px;
    }

    #chatMessages::-webkit-scrollbar-thumb:hover {
        background: #666;
    }
</style>
