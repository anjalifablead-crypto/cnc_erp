<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Process;
use App\Models\ProcessCycle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProcessCycleController extends Controller
{
    // Show all active cycles
    public function index()
    {
        $cycles = ProcessCycle::with('process')->where('is_deleted', 0)->orderBy('id', 'desc')->get();
        return response()->json(['status' => true, 'data' => $cycles]);
    }

    // Show single cycle
    public function show($id)
    {
        $cycle = ProcessCycle::with('process')->find($id);

        if (!$cycle || $cycle->is_deleted) {
            return response()->json(['status' => false, 'message' => 'Cycle not found'], 404);
        }

        return response()->json(['status' => true, 'data' => $cycle]);
    }

    // Insert new cycle
    public function store(Request $request)
    {
        $request->validate([
            'process_id'  => 'required|integer|exists:process,id',
            'cycle_secs'  => 'required|min:0',
            'cycle_mins'  => 'required|min:0',
        ]);

        $process = Process::where('id', $request->process_id)
            ->where('is_deleted', 0)
            ->first();

        if (!$process) {
            return response()->json([
                'status' => false,
                'message' => 'Process not found or deleted.',
            ], 404);
        }

        $cycle = ProcessCycle::create([
            'process_id'  => $request->process_id,
            'cycle_secs'  => $request->cycle_secs,
            'cycle_mins'  => $request->cycle_mins,
            'created_by'  => Auth::id(),
        ]);

        return response()->json(['status' => true, 'message' => 'Process cycle created successfully', 'data' => $cycle]);
    }

    // Update cycle
    public function update(Request $request, $id)
    {
        $request->validate([
            'process_id'  => 'sometimes|integer|exists:process,id',
            'cycle_secs'  => 'required|min:0',
            'cycle_mins'  => 'required|min:0',
        ]);

        $cycle = ProcessCycle::find($id);

        if (!$cycle || $cycle->is_deleted) {
            return response()->json(['status' => false, 'message' => 'Cycle not found'], 404);
        }

        if ($request->has('process_id')) {
            $process = Process::where('id', $request->process_id)
                ->where('is_deleted', 0)
                ->first();

            if (!$process) {
                return response()->json([
                    'status' => false,
                    'message' => 'Process not found or deleted.',
                ], 404);
            }
        }

        $cycle->update($request->only(['process_id', 'cycle_secs', 'cycle_mins']));

        return response()->json([
            'status' => true,
            'message' => 'Process cycle updated successfully',
            'data' => $cycle
        ]);
    }

    // Soft delete
    public function destroy($id)
    {
        $cycle = ProcessCycle::find($id);

        if (!$cycle || $cycle->is_deleted) {
            return response()->json(['status' => false, 'message' => 'Cycle not found'], 404);
        }

        $cycle->update(['is_deleted' => 1]);

        return response()->json(['status' => true, 'message' => 'Process cycle deleted successfully']);
    }
}
