<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SuperDeal;
use App\Models\Game;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;

class SuperDealController extends Controller
{
    public function index()
    {
        $games = Game::where('status', true)->orderBy('name')->get();
        return view('admin.super-deals.index', compact('games'));
    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $query = SuperDeal::with('game');

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
                ->addColumn('game', function ($row) {
                    return '<div class="d-flex align-items-center">
                                <div class="avtar avtar-s bg-light-primary flex-shrink-0">
                                    <i class="ti ti-device-gamepad"></i>
                                </div>
                                <div class="ms-2">
                                    <h6 class="mb-0">' . $row->game->name . '</h6>
                                </div>
                            </div>';
                })
                ->addColumn('banner', function ($row) {
                    if ($row->banner_image) {
                        return '<img src="' . asset('storage/' . $row->banner_image) . '" alt="Banner" class="img-thumbnail" style="max-height: 50px;">';
                    }
                    return '<span class="badge bg-light-secondary">No Banner</span>';
                })
                ->addColumn('price_formatted', function ($row) {
                    return '<strong class="text-primary">Rp ' . number_format($row->price, 0, ',', '.') . '</strong>';
                })
                ->addColumn('status', function ($row) {
                    $checked = $row->status ? 'checked' : '';
                    return '<div class="form-check form-switch">
                                <input class="form-check-input status-toggle" type="checkbox" data-id="' . $row->id . '" ' . $checked . '>
                            </div>';
                })
                ->addColumn('action', function ($row) {
                    return '<div class="btn-group" role="group">
                                <button type="button" class="btn btn-sm btn-outline-primary edit-btn" data-id="' . $row->id . '">
                                    <i class="ti ti-edit"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-danger delete-btn" data-id="' . $row->id . '">
                                    <i class="ti ti-trash"></i>
                                </button>
                            </div>';
                })
                ->rawColumns(['game', 'banner', 'price_formatted', 'status', 'action'])
                ->make(true);
        }
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'game_id' => 'required|exists:games,id',
            'game_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'banner_image' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'external_link' => 'nullable|url',
            'status' => 'boolean',
        ]);

        // Handle banner image upload
        if ($request->hasFile('banner_image')) {
            $validated['banner_image'] = $request->file('banner_image')->store('super-deals', 'public');
        }

        SuperDeal::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Super Deal created successfully!'
        ]);
    }

    public function show($id)
    {
        $superDeal = SuperDeal::with('game')->findOrFail($id);

        // Add banner image URL
        if ($superDeal->banner_image) {
            $superDeal->banner_image_url = asset('storage/' . $superDeal->banner_image);
        }

        return response()->json([
            'success' => true,
            'data' => $superDeal
        ]);
    }

    public function update(Request $request, $id)
    {
        $superDeal = SuperDeal::findOrFail($id);

        $validated = $request->validate([
            'game_id' => 'required|exists:games,id',
            'game_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'banner_image' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'external_link' => 'nullable|url',
            'status' => 'boolean',
        ]);

        // Handle banner image upload
        if ($request->hasFile('banner_image')) {
            // Delete old banner
            if ($superDeal->banner_image) {
                Storage::disk('public')->delete($superDeal->banner_image);
            }
            $validated['banner_image'] = $request->file('banner_image')->store('super-deals', 'public');
        }

        $superDeal->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Super Deal updated successfully!'
        ]);
    }

    public function destroy($id)
    {
        $superDeal = SuperDeal::findOrFail($id);

        // Delete banner image if exists
        if ($superDeal->banner_image) {
            Storage::disk('public')->delete($superDeal->banner_image);
        }

        $superDeal->delete();

        return response()->json([
            'success' => true,
            'message' => 'Super Deal deleted successfully!'
        ]);
    }

    public function toggleStatus(Request $request, $id)
    {
        $superDeal = SuperDeal::findOrFail($id);
        $superDeal->update([
            'status' => !$superDeal->status
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Super Deal status updated successfully!'
        ]);
    }
}
