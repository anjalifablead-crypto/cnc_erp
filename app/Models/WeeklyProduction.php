<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeeklyProduction extends Model
{
    use HasFactory;
       protected $table = 'weekly_production';

    protected $fillable = [
        'operator_id',
        'week',
        'machine_id',
        'process_id',
        'qty',
        'mnts_taken',
        'cnc_a', 'cnc_b', 'cnc_c', 'cnc_d',
        'cnc_e', 'cnc_f', 'cnc_g', 'cnc_h',
        'cnc_i', 'cnc_k',
        'idle_time',
        'total',
        'created_by',
        'is_deleted',
    ];

 
    //Relationships
    
    public function operator()
    {
        return $this->belongsTo(Operator::class, 'operator_id');
    }

    public function machine()
    {
        return $this->belongsTo(Machine::class, 'machine_id');
    }

    public function process()
    {
        return $this->belongsTo(Process::class, 'process_id');
    }
}
