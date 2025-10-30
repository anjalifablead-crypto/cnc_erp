<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Process extends Model
{
    use HasFactory;
    protected $table='process';

        protected $fillable = [
        'process_name', 
        'created_by', 
        'is_deleted',
    ];
}
