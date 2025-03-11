<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChecklistController extends Controller
{
    public function index(Request $request)
    {
        // Get all checklists belonging to the authenticated user
        $checklists = $request->user()->checklists;

        return response()->json([
            'status' => true,
            'data' => $checklists
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $checklist = $request->user()->checklists()->create([
            'name' => $request->name,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Checklist created successfully',
            'data' => $checklist
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id)
    {
        $checklist = $request->user()->checklists()->findOrFail($id);

        return response()->json([
            'status' => true,
            'data' => $checklist
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        $checklist = $request->user()->checklists()->findOrFail($id);

        $checklist->delete();

        return response()->json([
            'status' => true,
            'message' => 'Checklist deleted successfully'
        ]);
    }
}
