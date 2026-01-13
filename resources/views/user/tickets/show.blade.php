@extends('user.layouts.app')

@section('title', 'Ticket #' . $ticket->ticket_number)

@section('content')
        <!-- Page Header -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('user.tickets.index') }}">Support Tickets</a></li>
                            <li class="breadcrumb-item" aria-current="page">{{ $ticket->ticket_number }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Ticket Info Sidebar -->
            <div class="col-lg-4">
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
                            <label class="text-muted mb-1">Status</label>
                            <div>{!! $ticket->status_badge !!}</div>
                        </div>

                        <div class="mb-3">
                            <label class="text-muted mb-1">Priority</label>
                            <div>{!! $ticket->priority_badge !!}</div>
                        </div>

                        @if($ticket->assignedAdmin)
                            <div class="mb-3">
                                <label class="text-muted mb-1">Assigned To</label>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="avtar avtar-s bg-light-primary">
                                            <i class="ti ti-user-check"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-2">
                                        <h6 class="mb-0">{{ $ticket->assignedAdmin->name }}</h6>
                                        <small class="text-muted">Support Team</small>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="mb-3">
                            <label class="text-muted mb-1">Created</label>
                            <p class="mb-0">{{ $ticket->created_at->format('M d, Y h:i A') }}</p>
                            <small class="text-muted">{{ $ticket->created_at->diffForHumans() }}</small>
                        </div>

                        @if($ticket->status !== 'closed' && $ticket->status !== 'resolved')
                            <form action="{{ route('user.tickets.close', $ticket->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to close this ticket?')">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-danger w-100">
                                    <i class="ti ti-lock me-2"></i>Close Ticket
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Chat Area -->
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <div class="d-flex align-items-center">
                            <i class="ti ti-messages me-2" style="font-size: 24px;"></i>
                            <div>
                                <h5 class="text-white mb-0">Conversation</h5>
                                <small class="text-white-50">Real-time support chat</small>
                            </div>
                        </div>
                    </div>
                    <div class="card-body" style="height: 500px; overflow-y: auto;" id="chatMessages">
                        @foreach($ticket->messages as $message)
                            <div class="message-item mb-4 {{ $message->is_admin ? 'admin-message' : 'user-message' }}" data-message-id="{{ $message->id }}">
                                <div class="d-flex align-items-end {{ $message->is_admin ? '' : 'flex-row-reverse' }}">
                                    <div class="flex-shrink-0 mb-1">
                                        <div class="avtar avtar-s {{ $message->is_admin ? 'bg-gradient-primary' : 'bg-gradient-success' }}" style="box-shadow: 0 4px 8px rgba(0,0,0,0.15);">
                                            <i class="ti {{ $message->is_admin ? 'ti-headset' : 'ti-user' }} text-white"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 {{ $message->is_admin ? 'ms-2' : 'me-2' }}" style="max-width: 75%;">
                                        <div class="chat-bubble {{ $message->is_admin ? 'admin-bubble' : 'user-bubble' }}">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <div class="d-flex align-items-center">
                                                    <strong class="me-2" style="font-size: 14px;">{{ $message->user->name }}</strong>
                                                    @if($message->is_admin)
                                                        <span class="badge bg-white text-primary px-2 py-1" style="font-size: 9px; font-weight: 600;">
                                                            <i class="ti ti-shield-check" style="font-size: 10px;"></i> Support
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

<!-- Pusher JS -->
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<script>
    // Initialize Pusher
    const pusher = new Pusher('{{ config('broadcasting.connections.pusher.key') }}', {
    cluster: '{{ config('broadcasting.connections.pusher.options.cluster') }}',
    authEndpoint: '/broadcasting/auth',
    auth: {
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    }
});


    // Subscribe to ticket channel
    const channel = pusher.subscribe('private-ticket.{{ $ticket->id }}');

    // Listen for new messages
    channel.bind('message.new', function(data) {
        console.log('New message received:', data);
        appendMessage(data);
    });

    // Scroll to bottom function
    function scrollToBottom() {
        const chatMessages = document.getElementById('chatMessages');
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    // Append new message to chat
    function appendMessage(data) {
        const isAdmin = data.is_admin;
        const time = new Date(data.created_at);
        const timeStr = time.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' });

        const messageHtml = `
            <div class="message-item mb-4 ${isAdmin ? 'admin-message' : 'user-message'}" data-message-id="${data.id}">
                <div class="d-flex align-items-end ${isAdmin ? '' : 'flex-row-reverse'}">
                    <div class="flex-shrink-0 mb-1">
                        <div class="avtar avtar-s ${isAdmin ? 'bg-gradient-primary' : 'bg-gradient-success'}" style="box-shadow: 0 4px 8px rgba(0,0,0,0.15);">
                            <i class="ti ${isAdmin ? 'ti-headset' : 'ti-user'} text-white"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ${isAdmin ? 'ms-2' : 'me-2'}" style="max-width: 75%;">
                        <div class="chat-bubble ${isAdmin ? 'admin-bubble' : 'user-bubble'}">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div class="d-flex align-items-center">
                                    <strong class="me-2" style="font-size: 14px;">${data.user_name}</strong>
                                    ${isAdmin ? '<span class="badge bg-white text-primary px-2 py-1" style="font-size: 9px; font-weight: 600;"><i class="ti ti-shield-check" style="font-size: 10px;"></i> Support</span>' : ''}
                                </div>
                            </div>
                            <p class="mb-2" style="line-height: 1.6; font-size: 14px;">${data.message}</p>
                            <small class="opacity-75 d-block text-end" style="font-size: 11px;">
                                <i class="ti ti-clock" style="font-size: 11px;"></i>
                                ${timeStr}
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        `;

        document.getElementById('chatMessages').insertAdjacentHTML('beforeend', messageHtml);
        scrollToBottom();

        // Show notification
        if (isAdmin && document.hidden) {
            new Notification('New message from support', {
                body: data.message,
                icon: '/logo.png'
            });
        }
    }

    // Send message function
    function sendMessage(e) {
        e.preventDefault();

        const messageInput = document.getElementById('messageInput');
        const message = messageInput.value.trim();

        if (!message) return;

        // Show sending indicator
        messageInput.disabled = true;

        fetch('{{ route('user.tickets.message', $ticket->id) }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ message: message })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                messageInput.value = '';
                // Message will be added via Pusher broadcast
            } else {
                alert('Failed to send message: ' + (data.error || 'Unknown error'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to send message. Please try again.');
        })
        .finally(() => {
            messageInput.disabled = false;
            messageInput.focus();
        });
    }

    // Request notification permission
    if ('Notification' in window && Notification.permission === 'default') {
        Notification.requestPermission();
    }

    // Scroll to bottom on page load
    scrollToBottom();
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
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-bottom-left-radius: 4px;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
    }

    .user-bubble {
        background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
        color: white;
        border-bottom-right-radius: 4px;
        box-shadow: 0 4px 12px rgba(72, 187, 120, 0.3);
    }

    .chat-bubble:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
    }

    /* Avatar Gradient */
    .bg-gradient-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .bg-gradient-success {
        background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
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

    #chatMessages::-webkit-scrollbar {
        width: 8px;
    }

    #chatMessages::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    #chatMessages::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 10px;
    }

    #chatMessages::-webkit-scrollbar-thumb:hover {
        background: #555;
    }
</style>
@endsection
