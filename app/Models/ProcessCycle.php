<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcessCycle extends Model
{
    use HasFactory;

    protected $table = 'process_cycle';

    protected $fillable = [
        'process_id',
        'cycle_secs',
        'cycle_mins',
        'created_by',
        'is_deleted',
    ];

     public function process()
    {
        return $this->belongsTo(Process::class, 'process_id');
    }
}
