<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Operator;
use Illuminate\Support\Facades\Auth;

class OperatorController extends Controller
{
    // Create Operator
    public function store(Request $request)
    {
        $request->validate([
            'operator_name' => 'required|string|max:255|unique:operator,operator_name',
        ]);

        $operator = Operator::create([
            'operator_name' => $request->operator_name,
            'created_by'    => Auth::id(),
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Operator created successfully',
            'data' => $operator
        ], 201);
    }

    // Get all operators
    public function index()
    {
        $operators = Operator::where('is_deleted', 0)->orderBy('id', 'desc')->get();

        return response()->json([
            'status' => true,
            'data' => $operators
        ]);
    }

    // Get single operator
    public function show($id)
    {
        $operator = Operator::find($id);

        if (!$operator || $operator->is_deleted) {
            return response()->json(['status' => false, 'error' => 'Operator not found'], 404);
        }

        return response()->json(['status' => true, 'data' => $operator]);
    }

    // Update operator
    public function update(Request $request, $id)
    {
        $operator = Operator::find($id);

        if (!$operator || $operator->is_deleted) {
            return response()->json(['status' => false, 'error' => 'Operator not found'], 404);
        }

        $request->validate([
            'operator_name' => 'required|string|max:255|unique:operator,operator_name',
        ]);

        $operator->update([
            'operator_name' => $request->operator_name,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Operator updated successfully',
            'data' => $operator
        ]);
    }

    //  Delete operator (soft delete)
    public function destroy($id)
    {
        $operator = Operator::find($id);

        if (!$operator || $operator->is_deleted) {
            return response()->json(['status' => false, 'error' => 'Operator not found'], 404);
        }

        $operator->update(['is_deleted' => 1]);

        return response()->json(['status' => true, 'message' => 'Operator deleted successfully']);
    }
}
