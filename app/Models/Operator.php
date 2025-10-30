<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Operator extends Model
{
    use HasFactory;

    protected $table='operator';

        protected $fillable = [
        'operator_name', 
        'created_by', 
        'is_deleted',
    ];

    //     protected $hidden = [
    //     'created_at', 'updated_at',
    // ];
}
