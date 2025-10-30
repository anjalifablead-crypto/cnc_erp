<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manufacturing extends Model
{
    use HasFactory;

    protected $table = 'manufacturing';

    protected $fillable = [
        'mf_no',
        'date_from',
        'date_to',
        'created_by',
        'is_deleted',
    ];
}
