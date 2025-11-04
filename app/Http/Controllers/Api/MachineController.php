<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Machine;
use Illuminate\Support\Facades\Auth;

class MachineController extends Controller
{
    // Create Machine
    public function store(Request $request)
    {
        $request->validate([
            'machine_number' => 'required|string|max:255|unique:machine,machine_number',
        ]);

        $machine = Machine::create([
            'machine_number' => $request->machine_number,
            'created_by'     => Auth::id(),
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Machine created successfully',
            'data' => $machine
        ], 201);
    }

    //  List all machines
    public function index()
    {
        $machines = Machine::where('is_deleted', 0)->orderBy('id', 'desc')->get();

        return response()->json([
            'status' => true,
            'data' => $machines
        ]);
    }

    // Show single machine
    public function show($id)
    {
        $machine = Machine::find($id);

        if (!$machine || $machine->is_deleted) {
            return response()->json(['status' => false, 'error' => 'Machine not found'], 404);
        }

        return response()->json(['status' => true, 'data' => $machine]);
    }

    // Update machine
    public function update(Request $request, $id)
    {
        $machine = Machine::find($id);

        if (!$machine || $machine->is_deleted) {
            return response()->json(['status' => false, 'error' => 'Machine not found'], 404);
        } 

        $request->validate([
            'machine_number' => 'required|string|max:255|unique:machine,machine_number',
        ]);

        $machine->update([
            'machine_number' => $request->machine_number,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Machine updated successfully',
            'data' => $machine
        ]);
    }

    // Soft delete machine
    public function destroy($id)
    {
        $machine = Machine::find($id);

        if (!$machine || $machine->is_deleted) {
            return response()->json(['status' => false, 'error' => 'Machine not found'], 404);
        }

        $machine->update(['is_deleted' => 1]);

        return response()->json([
            'status' => true,
            'message' => 'Machine deleted successfully'
        ]);
    }
}
