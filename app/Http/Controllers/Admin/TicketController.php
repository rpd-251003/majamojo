<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\TicketMessage;
use App\Models\User;
use App\Events\NewTicketMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    public function index(Request $request)
    {
        $query = Ticket::with(['user', 'latestMessage', 'assignedAdmin']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by priority
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        // Filter by user type (role)
        if ($request->filled('user_type')) {
            $query->byUserType($request->user_type);
        }

        // Search
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('ticket_number', 'like', '%' . $request->search . '%')
                  ->orWhere('subject', 'like', '%' . $request->search . '%')
                  ->orWhereHas('user', function($uq) use ($request) {
                      $uq->where('name', 'like', '%' . $request->search . '%');
                  });
            });
        }

        $tickets = $query->orderBy('created_at', 'desc')->paginate(15);

        $stats = [
            'total' => Ticket::count(),
            'open' => Ticket::where('status', 'open')->count(),
            'in_progress' => Ticket::where('status', 'in_progress')->count(),
            'resolved' => Ticket::where('status', 'resolved')->count(),
            'closed' => Ticket::where('status', 'closed')->count(),
            'premium' => Ticket::byUserType('membership')->count(),
            'regular' => Ticket::byUserType('reguler')->count(),
        ];

        $admins = User::where('role', 'admin')->get();

        return view('admin.tickets.index', compact('tickets', 'stats', 'admins'));
    }

    public function show($id)
    {
        $ticket = Ticket::with(['user', 'messages.user', 'assignedAdmin'])->findOrFail($id);
        $admins = User::where('role', 'admin')->get();

        return view('admin.tickets.show', compact('ticket', 'admins'));
    }

    public function sendMessage(Request $request, $id)
    {
        try {
            $request->validate([
                'message' => 'required|string'
            ]);

            $ticket = Ticket::findOrFail($id);

            $message = TicketMessage::create([
                'ticket_id' => $ticket->id,
                'user_id' => Auth::id(),
                'message' => $request->message,
                'is_admin' => true
            ]);

            // Update ticket status to in_progress if it was open
            if ($ticket->status === 'open') {
                $ticket->update(['status' => 'in_progress']);
            }

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
            \Log::error('Admin send message error: ' . $e->getMessage());

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'error' => $e->getMessage()
                ], 500);
            }

            return back()->with('error', 'Failed to send message: ' . $e->getMessage());
        }
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:open,in_progress,resolved,closed'
        ]);

        $ticket = Ticket::findOrFail($id);
        $ticket->update([
            'status' => $request->status,
            'closed_at' => in_array($request->status, ['resolved', 'closed']) ? now() : null
        ]);

        return back()->with('success', 'Ticket status updated successfully!');
    }

    public function assignAdmin(Request $request, $id)
    {
        $request->validate([
            'assigned_to' => 'required|exists:users,id'
        ]);

        $ticket = Ticket::findOrFail($id);
        $ticket->update(['assigned_to' => $request->assigned_to]);

        return back()->with('success', 'Admin assigned successfully!');
    }

    public function updatePriority(Request $request, $id)
    {
        $request->validate([
            'priority' => 'required|in:low,medium,high,urgent'
        ]);

        $ticket = Ticket::findOrFail($id);
        $ticket->update(['priority' => $request->priority]);

        return back()->with('success', 'Priority updated successfully!');
    }
}
