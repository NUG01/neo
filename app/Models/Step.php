<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Step extends Model
{

    protected $fillable = [
        'title', 'campaign_id', 'order_num', 'fileName'
    ];

    protected $table = 'steps';

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

    public function fields()
    {
        return $this->hasMany(StepField::class);
    }
}
