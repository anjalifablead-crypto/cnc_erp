<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

     protected $table = 'attendance';

    protected $fillable = [
        'mf_no',
        'date_from',
        'date_to',
        'operator_id',
        'man_hour',
        'utilised_hour',
        'idle_hour',
        'operator_eff',
        'machine_eff',
        'created_by',
        'is_deleted',
    ];

    /**
     * Relationships
     */
    public function manufacturing()
    {
        return $this->belongsTo(Manufacturing::class, 'mf_no');
    }

    public function operator()
    {
        return $this->belongsTo(Operator::class, 'operator_id');
    }
}
