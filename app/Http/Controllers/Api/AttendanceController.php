<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Manufacturing;
use App\Models\Operator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    // Show all attendance records

    public function index()
    {
        $attendance = Attendance::where('is_deleted', 0)->orderBy('id', 'desc')->get();

        return response()->json([
            'status' => true,
            'data' => $attendance
        ]);
    }

    //Store a new attendance record

    public function store(Request $request)
    {
        $request->validate([
            'mf_id' => 'required|integer|exists:manufacturing,id',
            'date_from' => 'required|date',
            'date_to' => 'required|date',
            'operator_id' => 'required|integer|exists:operator,id',
            'man_hour' => 'nullable|numeric',
            'utilised_hour' => 'nullable|numeric',
            'idle_hour' => 'nullable|numeric',
            'operator_eff' => 'nullable|numeric',
            'machine_eff' => 'nullable|numeric',
        ]);

        $manufacturing = Manufacturing::where('id', $request->mf_id)
            ->where('is_deleted', 0)
            ->first();

        if (!$manufacturing) {
            return response()->json([
                'status' => false,
                'message' => 'Manufacturing record not found or deleted.',
            ], 404);
        }

        // Check if operator exists and is not deleted
        $operator = Operator::where('id', $request->operator_id)
            ->where('is_deleted', 0)
            ->first();

        if (!$operator) {
            return response()->json([
                'status' => false,
                'message' => 'Operator record not found or deleted.',
            ], 404);
        }

        //  Create attendance record using mf_no from manufacturing
        $attendance = Attendance::create([
            'mf_id' => $manufacturing->id,
            'date_from' => $request->date_from,
            'date_to' => $request->date_to,
            'operator_id' => $operator->id,
            'man_hour' => $request->man_hour ?? 0.00,
            'utilised_hour' => $request->utilised_hour ?? 0.00,
            'idle_hour' => $request->idle_hour ?? 0.00,
            'operator_eff' => $request->operator_eff ?? 0.00,
            'machine_eff' => $request->machine_eff ?? 0.00,
            'created_by' => Auth::id(),
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Attendance record created successfully',
            'data' => $attendance,
        ]);
    }

    //Show a specific record
    public function show($id)
    {
        $attendance = Attendance::where('id', $id)->where('is_deleted', 0)->first();

        if (!$attendance) {
            return response()->json(['status' => false, 'message' => 'Record not found'], 404);
        }

        return response()->json(['status' => true, 'data' => $attendance]);
    }

    //Update a specific record when you want to update record use mf_id for update mf_no
    public function update(Request $request, $id)
    {
        $attendance = Attendance::where('id', $id)->where('is_deleted', 0)->first();

        if (!$attendance) {
            return response()->json(['status' => false, 'message' => 'Record not found'], 404);
        }

        // Validate input (fields optional, only if present)
        $validated = $request->validate([
            'mf_id'            => 'integer|exists:manufacturing,id',
            'date_from'        => 'date',
            'date_to'          => 'date',
            'operator_id'      => 'integer|exists:operator,id',
            'man_hour'         => 'nullable|numeric|min:0',
            'utilised_hour'    => 'nullable|numeric|min:0',
            'idle_hour'        => 'nullable|numeric|min:0',
            'operator_eff'     => 'nullable|numeric|min:0',
            'machine_eff'      => 'nullable|numeric|min:0',
        ]);

        //  Check manufacturing if updated
        if ($request->has('mf_id')) {
            $manufacturing = Manufacturing::where('id', $request->mf_id)
                ->where('is_deleted', 0)
                ->first();

            if (!$manufacturing) {
                return response()->json([
                    'status' => false,
                    'message' => 'Manufacturing record not found or deleted.',
                ], 404);
            }

            // Update mf_no if manufacturing_id changes
            $validated['mf_id'] = $manufacturing->id;
        }

        // 🔍 Check operator if updated
        if ($request->has('operator_id')) {
            $operator = Operator::where('id', $request->operator_id)
                ->where('is_deleted', 0)
                ->first();

            if (!$operator) {
                return response()->json([
                    'status' => false,
                    'message' => 'Operator record not found or deleted.',
                ], 404);
            }
        }

        $attendance->update($validated);

        return response()->json([
            'status'  => true,
            'message' => 'Attendance updated successfully',
            'data'    => $attendance
        ]);
    }

    public function destroy($id)
    {
        $attendance = Attendance::find($id);

        if (!$attendance) {
            return response()->json(['status' => false, 'message' => 'Record not found'], 404);
        }

        $attendance->update(['is_deleted' => 1]);

        return response()->json(['status' => true, 'message' => 'Attendance deleted successfully']);
    }
}
