<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'ticket_number',
        'subject',
        'description',
        'status',
        'priority',
        'due_date',
        'assigned_to',
        'closed_at'
    ];

    protected $casts = [
        'closed_at' => 'datetime',
        'due_date' => 'datetime'
    ];

    public function getIsOverdueAttribute()
    {
        return $this->due_date
            && $this->due_date->isPast()
            && !in_array($this->status, ['resolved', 'closed']);
    }

    public function getOverdueDaysAttribute()
    {
        if (!$this->is_overdue) {
            return 0;
        }

        return (int) $this->due_date->diffInDays(now());
    }

    public function getOverdueHoursAttribute()
    {
        if (!$this->is_overdue) {
            return 0;
        }

        return (int) $this->due_date->diffInHours(now());
    }

    public function getDueDateBadgeAttribute()
    {
        if (!$this->due_date) {
            return '<span class="badge bg-light text-muted">No Due Date</span>';
        }

        $formatted = $this->due_date->format('M d, Y H:i');

        if ($this->is_overdue) {
            $hours = $this->overdue_hours;
            if ($hours < 24) {
                $label = $hours . ' hour' . ($hours > 1 ? 's' : '');
            } else {
                $days = $this->overdue_days;
                $label = $days . ' day' . ($days > 1 ? 's' : '');
            }
            return '<span class="badge bg-danger"><i class="ti ti-alert-triangle me-1"></i>Overdue ' . $label . '</span>';
        }

        $hoursLeft = (int) now()->diffInHours($this->due_date, false);

        if ($hoursLeft <= 3) {
            return '<span class="badge bg-danger text-white"><i class="ti ti-urgent me-1"></i>Due very soon</span>';
        }

        if ($hoursLeft <= 24) {
            return '<span class="badge bg-warning"><i class="ti ti-clock me-1"></i>Due in ' . $hoursLeft . 'h</span>';
        }

        $daysLeft = (int) now()->diffInDays($this->due_date, false);

        if ($daysLeft <= 3) {
            return '<span class="badge bg-warning"><i class="ti ti-clock me-1"></i>Due in ' . $daysLeft . ' day' . ($daysLeft > 1 ? 's' : '') . '</span>';
        }

        return '<span class="badge bg-info"><i class="ti ti-calendar me-1"></i>' . $formatted . '</span>';
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($ticket) {
            if (!$ticket->ticket_number) {
                $ticket->ticket_number = 'TKT-' . strtoupper(uniqid());
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function assignedAdmin()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function messages()
    {
        return $this->hasMany(TicketMessage::class)->orderBy('created_at', 'asc');
    }

    public function latestMessage()
    {
        return $this->hasOne(TicketMessage::class)->latestOfMany();
    }

    public function scopeOpen($query)
    {
        return $query->where('status', 'open');
    }

    public function scopeInProgress($query)
    {
        return $query->where('status', 'in_progress');
    }

    public function scopeClosed($query)
    {
        return $query->whereIn('status', ['resolved', 'closed']);
    }

    public function scopeByUserType($query, $type)
    {
        return $query->whereHas('user', function ($q) use ($type) {
            $q->where('role', $type);
        });
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'open' => '<span class="badge bg-primary">Open</span>',
            'in_progress' => '<span class="badge bg-warning">In Progress</span>',
            'resolved' => '<span class="badge bg-success">Resolved</span>',
            'closed' => '<span class="badge bg-secondary">Closed</span>',
        ];

        return $badges[$this->status] ?? '<span class="badge bg-light">Unknown</span>';
    }

    public function getPriorityBadgeAttribute()
    {
        $badges = [
            'low' => '<span class="badge bg-info">Low</span>',
            'medium' => '<span class="badge bg-primary">Medium</span>',
            'high' => '<span class="badge bg-warning">High</span>',
            'urgent' => '<span class="badge bg-danger">Urgent</span>',
        ];

        return $badges[$this->priority] ?? '<span class="badge bg-light">Unknown</span>';
    }

    public function getUserTypeBadgeAttribute()
    {
        $role = $this->user->role ?? 'reguler';

        $badges = [
            'admin' => '<span class="badge bg-danger"><i class="ti ti-shield-check me-1"></i>Admin</span>',
            'membership' => '<span class="badge bg-warning"><i class="ti ti-crown me-1"></i>Premium</span>',
            'reguler' => '<span class="badge bg-secondary"><i class="ti ti-user me-1"></i>Regular</span>',
        ];

        return $badges[$role] ?? '<span class="badge bg-light">Unknown</span>';
    }
}
