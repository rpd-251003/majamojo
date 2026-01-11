<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Game;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class GameController extends Controller
{
    public function index()
    {
        return view('admin.games.index');
    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $query = Game::query();

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('logo_display', function ($row) {
                    if ($row->logo) {
                        return '<img src="' . asset('storage/' . $row->logo) . '" alt="' . $row->name . '" style="width: 50px; height: 50px; object-fit: contain;">';
                    }
                    return '<div class="avtar avtar-s bg-light-primary"><i class="ti ti-device-gamepad"></i></div>';
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
                            <i class="bi bi-pencil"></i> Edit
                        </button>
                        <button type="button" class="btn btn-sm btn-danger delete-btn" data-id="' . $row->id . '">
                            <i class="bi bi-trash"></i> Delete
                        </button>
                    </div>';
                })
                ->rawColumns(['logo_display', 'status', 'action'])
                ->make(true);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,jpg,png,gif,svg|max:2048',
            'status' => 'boolean',
        ]);

        try {
            $data = [
                'name' => $request->name,
                'status' => $request->status ?? true,
            ];

            if ($request->hasFile('logo')) {
                $data['logo'] = $request->file('logo')->store('games', 'public');
            }

            Game::create($data);

            return response()->json([
                'success' => true,
                'message' => 'Game created successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create game: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $game = Game::findOrFail($id);
            return response()->json([
                'success' => true,
                'data' => $game
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Game not found'
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,jpg,png,gif,svg|max:2048',
            'status' => 'boolean',
        ]);

        try {
            $game = Game::findOrFail($id);

            $data = [
                'name' => $request->name,
                'status' => $request->status ?? true,
            ];

            if ($request->hasFile('logo')) {
                // Delete old logo if exists
                if ($game->logo) {
                    \Storage::disk('public')->delete($game->logo);
                }
                $data['logo'] = $request->file('logo')->store('games', 'public');
            }

            $game->update($data);

            return response()->json([
                'success' => true,
                'message' => 'Game updated successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update game: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $game = Game::findOrFail($id);

            // Delete logo if exists
            if ($game->logo) {
                \Storage::disk('public')->delete($game->logo);
            }

            $game->delete();

            return response()->json([
                'success' => true,
                'message' => 'Game deleted successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete game: ' . $e->getMessage()
            ], 500);
        }
    }

    public function toggleStatus(Request $request, $id)
    {
        try {
            $game = Game::findOrFail($id);
            $game->update(['status' => !$game->status]);

            return response()->json([
                'success' => true,
                'message' => 'Status updated successfully!',
                'status' => $game->status
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update status'
            ], 500);
        }
    }
}
