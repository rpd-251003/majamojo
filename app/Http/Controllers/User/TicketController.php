<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\TicketMessage;
use App\Events\NewTicketMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TicketController extends Controller
{
    public function index()
    {
        $tickets = Ticket::where('user_id', Auth::id())
            ->with(['latestMessage', 'assignedAdmin'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('user.tickets.index', compact('tickets'));
    }

    public function create()
    {
        return view('user.tickets.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|in:low,medium,high,urgent'
        ]);

        $ticket = Ticket::create([
            'user_id' => Auth::id(),
            'subject' => $request->subject,
            'description' => $request->description,
            'priority' => $request->priority,
            'status' => 'open'
        ]);

        // Create first message with description
        TicketMessage::create([
            'ticket_id' => $ticket->id,
            'user_id' => Auth::id(),
            'message' => $request->description,
            'is_admin' => false
        ]);

        return redirect()->route('user.tickets.show', $ticket->id)
            ->with('success', 'Ticket created successfully! Ticket Number: ' . $ticket->ticket_number);
    }

    public function show($id)
    {
        $ticket = Ticket::where('id', $id)
            ->where('user_id', Auth::id())
            ->with(['messages.user', 'assignedAdmin'])
            ->firstOrFail();

        return view('user.tickets.show', compact('ticket'));
    }

    public function sendMessage(Request $request, $id)
    {
        try {
            $request->validate([
                'message' => 'required|string',
                'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048'
            ]);

            $ticket = Ticket::where('id', $id)
                ->where('user_id', Auth::id())
                ->firstOrFail();

            $attachmentPath = null;
            if ($request->hasFile('attachment')) {
                $attachmentPath = $request->file('attachment')->store('ticket-attachments', 'public');
            }

            $message = TicketMessage::create([
                'ticket_id' => $ticket->id,
                'user_id' => Auth::id(),
                'message' => $request->message,
                'attachment' => $attachmentPath,
                'is_admin' => false
            ]);

            // Broadcast the message
            broadcast(new NewTicketMessage($message->load('user')))->toOthers();

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => $message->load('user')
                ]);
            }

            return back()->with('success', 'Message sent successfully!');
        } catch (\Exception $e) {
            \Log::error('Send message error: ' . $e->getMessage());

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'error' => $e->getMessage()
                ], 500);
            }

            return back()->with('error', 'Failed to send message: ' . $e->getMessage());
        }
    }

    public function close($id)
    {
        $ticket = Ticket::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $ticket->update([
            'status' => 'closed',
            'closed_at' => now()
        ]);

        return back()->with('success', 'Ticket closed successfully!');
    }
}
