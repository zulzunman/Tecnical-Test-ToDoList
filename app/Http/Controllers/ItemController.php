<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Get all Checklist Items by checklist id
     */
    public function index(Request $request, $checklistId)
    {
        $checklist = $request->user()->checklists()->findOrFail($checklistId);

        $items = $checklist->items;

        return response()->json([
            'status' => true,
            'data' => $items
        ]);
    }

    /**
     * Create new checklist item in checklist
     */
    public function store(Request $request, $checklistId)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'detail' => 'required|string',
        ]);

        $checklist = $request->user()->checklists()->findOrFail($checklistId);

        $item = $checklist->items()->create([
            'name' => $request->name,
            'detail' => $request->detail,
            'status' => false
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Checklist item created successfully',
            'data' => $item
        ], 201);
    }

    /**
     * Get checklist item in checklist by checklist id
     */
    public function show(Request $request, $checklistId, $itemId)
    {
        $checklist = $request->user()->checklists()->findOrFail($checklistId);

        $item = $checklist->items()->findOrFail($itemId);

        return response()->json([
            'status' => true,
            'data' => $item
        ]);
    }

    /**
     * Update status checklist item by checklist item id
     */
    public function updateStatus(Request $request, $checklistId, $itemId)
    {
        $request->validate([
            'status' => 'required|boolean',
        ]);

        $checklist = $request->user()->checklists()->findOrFail($checklistId);
        dd($checklist);

        $item = $checklist->items()->findOrFail($itemId);

        $item->update([
            'status' => $request->status,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Checklist item status updated successfully',
            'data' => $item
        ]);
    }

    /**
     * Delete item by checklist item id
     */
    public function destroy(Request $request, $checklistId, $itemId)
    {
        $checklist = $request->user()->checklists()->findOrFail($checklistId);

        $item = $checklist->items()->findOrFail($itemId);

        $item->delete();

        return response()->json([
            'status' => true,
            'message' => 'Checklist item deleted successfully'
        ]);
    }

    /**
     * Rename item by checklist item id
     */
    public function rename(Request $request, $checklistId, $itemId)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'detail' => 'sometimes|string'
        ]);

        $checklist = $request->user()->checklists()->findOrFail($checklistId);

        $item = $checklist->items()->findOrFail($itemId);

        $updateData = ['name' => $request->name];

        if ($request->has('detail')) {
            $updateData['detail'] = $request->detail;
        }

        $item->update($updateData);

        return response()->json([
            'status' => true,
            'message' => 'Checklist item renamed successfully',
            'data' => $item
        ]);
    }
}
