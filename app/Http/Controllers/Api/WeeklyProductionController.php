<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\WeeklyProduction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WeeklyProductionController extends Controller
{
    // List all weekly production records (not deleted)
    public function index()
    {
        $data = WeeklyProduction::with(['operator', 'machine', 'process'])
            ->where('is_deleted', 0)
            ->get();

        return response()->json(['status' => true, 'data' => $data]);
    }

    //  Insert new record
    public function store(Request $request)
    {
        $request->validate([
            'operator_id' => 'required|integer',
            'week'        => 'required|string|max:255',
            'machine_id'  => 'required|integer',
            'process_id'  => 'required|integer',
            'qty'         => 'required|integer',
            'mnts_taken'  => 'required|numeric',
        ]);

        $data = WeeklyProduction::create([
            'operator_id' => $request->operator_id,
            'week'        => $request->week,
            'machine_id'  => $request->machine_id,
            'process_id'  => $request->process_id,
            'qty'         => $request->qty,
            'mnts_taken'  => $request->mnts_taken,
            'cnc_a'       => $request->cnc_a,
            'cnc_b'       => $request->cnc_b,
            'cnc_c'       => $request->cnc_c,
            'cnc_d'       => $request->cnc_d,
            'cnc_e'       => $request->cnc_e,
            'cnc_f'       => $request->cnc_f,
            'cnc_g'       => $request->cnc_g,
            'cnc_h'       => $request->cnc_h,
            'cnc_i'       => $request->cnc_i,
            'cnc_k'       => $request->cnc_k,
            'idle_time'   => $request->idle_time,
            'total'       => $request->total,
            'created_by'  => Auth::id(),
        ]);

        return response()->json(['status' => true, 'message' => 'Record added successfully', 'data' => $data]);
    }

    //  Show single record
    public function show($id)
    {
        $data = WeeklyProduction::with(['operator', 'machine', 'process'])
            ->where('id', $id)
            ->where('is_deleted', 0)
            ->first();

        if (!$data) {
            return response()->json(['status' => false, 'message' => 'Record not found'], 404);
        }

        return response()->json(['status' => true, 'data' => $data]);
    }

    //  Update record
    public function update(Request $request, $id)
    {
        $data = WeeklyProduction::find($id);

        if (!$data || $data->is_deleted) {
            return response()->json(['status' => false, 'message' => 'Record not found'], 404);
        }

        $data->update($request->only([
            'operator_id', 'week', 'machine_id', 'process_id',
            'qty', 'mnts_taken', 'cnc_a', 'cnc_b', 'cnc_c', 'cnc_d', 'cnc_e', 'cnc_f',
            'cnc_g', 'cnc_h', 'cnc_i', 'cnc_k', 'idle_time', 'total'
        ]));

        return response()->json(['status' => true, 'message' => 'Record updated successfully', 'data' => $data]);
    }

    //  Soft delete record
    public function destroy($id)
    {
        $data = WeeklyProduction::find($id);

        if (!$data || $data->is_deleted) {
            return response()->json(['status' => false, 'message' => 'Record not found or already deleted'], 404);
        }

        $data->update(['is_deleted' => 1]);
        return response()->json(['status' => true, 'message' => 'Record deleted successfully']);
    }
}
