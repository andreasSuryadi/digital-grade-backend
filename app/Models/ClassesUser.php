<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ClassesUser extends Pivot
{
    use HasFactory;

    protected $fillable = [
        'classes_id',
        'user_id',
    ];
}
