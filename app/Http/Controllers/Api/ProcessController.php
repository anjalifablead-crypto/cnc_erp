<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Process;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProcessController extends Controller
{
    // Show all processes
    public function index()
    {
        $processes = Process::where('is_deleted', 0)->orderBy('id', 'desc')->get();
        return response()->json(['status' => true, 'data' => $processes]);
    }

    // Insert new process
    public function store(Request $request)
    {
        $request->validate([
            'process_name' => 'required|string|max:255',
        ]);

        $process = Process::create([
            'process_name' => $request->process_name,
            'created_by'   => Auth::id(),
        ]);

        return response()->json(['status' => true, 'message' => 'Process created successfully', 'data' => $process]);
    }

    // Update process
    public function update(Request $request, $id)
    {
        $request->validate([
            'process_name' => 'required|string|max:255',
        ]);

        $process = Process::find($id);

        if (!$process || $process->is_deleted) {
            return response()->json(['status' => false, 'message' => 'Process not found'], 404);
        }

        $process->update(['process_name' => $request->process_name]);

        return response()->json(['status' => true, 'message' => 'Process updated successfully', 'data' => $process]);
    }

    // Soft delete
    public function destroy($id)
    {
        $process = Process::find($id);

        if (!$process || $process->is_deleted) {
            return response()->json(['status' => false, 'message' => 'Process not found'], 404);
        }

        $process->update(['is_deleted' => 1]);

        return response()->json(['status' => true, 'message' => 'Process deleted successfully']);
    }
    public function show($id)
    {
        $process = Process::find($id);

        if (!$process || $process->is_deleted) {
            return response()->json(['status' => false, 'error' => 'Process not found'], 404);
        }

        return response()->json(['status' => true, 'data' => $process]);
    }
}
