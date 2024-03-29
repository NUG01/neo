<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StepField extends Model
{
    protected $fillable = [
        'step_id', 'input'
    ];

    protected $table = 'step_fields';

    protected $availableInputs = [
        'salutation',
        'firstname',
        'lastname',
        'email',
        'date_of_birth',
        'phone',
        'street',
        'postal_code',
        'city',
        'country',
    ];

    public function step()
    {
        return $this->belongsTo(Step::class);
    }
}
