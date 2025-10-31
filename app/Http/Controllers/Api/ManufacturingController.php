<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Manufacturing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManufacturingController extends Controller
{
    // Show all manufacturing records (not deleted)
    public function index()
    {
        $data = Manufacturing::where('is_deleted', 0)->orderBy('id', 'desc')->get();
        return response()->json(['status' => true, 'data' => $data]);
    }

    // Insert new manufacturing record
    public function store(Request $request)
    {
        $request->validate([
            'mf_no'     => 'required|string|max:255',
            'date_from' => 'required|date',
            'date_to'   => 'required|date|after_or_equal:date_from',
        ]);

        $data = Manufacturing::create([
            'mf_no'     => $request->mf_no,
            'date_from' => $request->date_from,
            'date_to'   => $request->date_to,
            'created_by' => Auth::id(),
        ]);

        return response()->json(['status' => true, 'message' => 'Manufacturing record created successfully', 'data' => $data]);
    }

    // Show single record by ID
    public function show($id)
    {
        $data = Manufacturing::where('id', $id)->where('is_deleted', 0)->first();

        if (!$data) {
            return response()->json(['status' => false, 'message' => 'Record not found'], 404);
        }

        return response()->json(['status' => true, 'data' => $data]);
    }

    // Update existing record
    public function update(Request $request, $id)
    {
        $data = Manufacturing::find($id);

        if (!$data || $data->is_deleted) {
            return response()->json(['status' => false, 'message' => 'Record not found'], 404);
        }

        $request->validate([
            'mf_no'     => 'sometimes|required|string|max:255',
            'date_from' => 'sometimes|required|date',
            'date_to'   => 'sometimes|required|date|after_or_equal:date_from',
        ]);

        $data->update($request->only(['mf_no', 'date_from', 'date_to']));
        return response()->json(['status' => true, 'message' => 'Record updated successfully', 'data' => $data]);
    }

    // Soft delete
    public function destroy($id)
    {
        $data = Manufacturing::find($id);

        if (!$data || $data->is_deleted) {
            return response()->json(['status' => false, 'message' => 'Record not found or already deleted'], 404);
        }

        $data->update(['is_deleted' => 1]);
        return response()->json(['status' => true, 'message' => 'Record deleted successfully']);
    }
}
