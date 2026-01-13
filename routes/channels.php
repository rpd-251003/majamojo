<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\Ticket;

Broadcast::channel('ticket.{ticketId}', function ($user, $ticketId) {
    $ticket = Ticket::find($ticketId);

    // Allow if user owns the ticket or is admin
    return $ticket && ($ticket->user_id === $user->id || $user->role === 'admin');
});
