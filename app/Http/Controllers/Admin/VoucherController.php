<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use App\Models\Game;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class VoucherController extends Controller
{
    public function index()
    {
        $games = Game::where('status', true)->get();
        return view('admin.vouchers.index', compact('games'));
    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $query = Voucher::with('game');

            // Filter by game_id
            if ($request->has('game_id') && $request->game_id != '') {
                $query->where('game_id', $request->game_id);
            }

            // Filter by date range
            if ($request->has('start_date') && $request->start_date != '') {
                $query->whereDate('start_date', '>=', $request->start_date);
            }

            if ($request->has('end_date') && $request->end_date != '') {
                $query->whereDate('end_date', '<=', $request->end_date);
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('game_name', function ($row) {
                    return '<div class="d-flex align-items-center">
                        <div class="avtar avtar-s bg-light-primary flex-shrink-0">
                            <i class="ti ti-device-gamepad"></i>
                        </div>
                        <div class="ms-2">
                            <h6 class="mb-0">' . $row->game->name . '</h6>
                        </div>
                    </div>';
                })
                ->addColumn('type_badge', function ($row) {
                    $badges = [
                        'membership_only' => 'bg-light-primary',
                        'reguler_only' => 'bg-light-success',
                        'all' => 'bg-light-info'
                    ];
                    $badge = $badges[$row->type] ?? 'bg-light-secondary';
                    $label = str_replace('_', ' ', ucwords($row->type));
                    return '<span class="badge ' . $badge . '">' . $label . '</span>';
                })
                ->addColumn('date_range', function ($row) {
                    return '<small class="text-muted">' .
                           $row->start_date->format('d M Y') . ' - ' .
                           $row->end_date->format('d M Y') . '</small>';
                })
                ->addColumn('status', function ($row) {
                    $checked = $row->status ? 'checked' : '';
                    return '<div class="form-check form-switch">
                        <input class="form-check-input status-toggle" type="checkbox"
                        data-id="' . $row->id . '" ' . $checked . '>
                    </div>';
                })
                ->addColumn('action', function ($row) {
                    return '<div class="btn-group" role="group">
                        <button type="button" class="btn btn-sm btn-primary edit-btn" data-id="' . $row->id . '">
                            <i class="ti ti-edit"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-danger delete-btn" data-id="' . $row->id . '">
                            <i class="ti ti-trash"></i>
                        </button>
                    </div>';
                })
                ->rawColumns(['game_name', 'type_badge', 'date_range', 'status', 'action'])
                ->make(true);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'game_id' => 'required|exists:games,id',
            'promo_code' => 'required|string|unique:vouchers,promo_code',
            'type' => 'required|in:membership_only,reguler_only,all',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'external_link' => 'nullable|url',
            'status' => 'boolean',
        ]);

        try {
            Voucher::create($request->all());
            return response()->json([
                'success' => true,
                'message' => 'Voucher created successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create voucher: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $voucher = Voucher::with('game')->findOrFail($id);
            return response()->json([
                'success' => true,
                'data' => $voucher
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Voucher not found'
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'game_id' => 'required|exists:games,id',
            'promo_code' => 'required|string|unique:vouchers,promo_code,' . $id,
            'type' => 'required|in:membership_only,reguler_only,all',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'external_link' => 'nullable|url',
            'status' => 'boolean',
        ]);

        try {
            $voucher = Voucher::findOrFail($id);
            $voucher->update($request->all());
            return response()->json([
                'success' => true,
                'message' => 'Voucher updated successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update voucher: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $voucher = Voucher::findOrFail($id);
            $voucher->delete();
            return response()->json([
                'success' => true,
                'message' => 'Voucher deleted successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete voucher: ' . $e->getMessage()
            ], 500);
        }
    }

    public function toggleStatus(Request $request, $id)
    {
        try {
            $voucher = Voucher::findOrFail($id);
            $voucher->update(['status' => !$voucher->status]);
            return response()->json([
                'success' => true,
                'message' => 'Status updated successfully!',
                'status' => $voucher->status
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update status'
            ], 500);
        }
    }
}
