<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StepFieldValue extends Model
{
    use HasFactory;

    protected $fillable = [
        'value', 'step_field_id', 'participation_id'
    ];

    protected $table = 'step_field_values';
}
