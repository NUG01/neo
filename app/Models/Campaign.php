<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Campaign extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'title', 'end_date', 'id'
    ];

    protected $casts = [
        "end_date" => "date",
    ];

    protected $table = 'campaigns';

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }

    public function steps()
    {
        return $this->hasMany(Step::class);
    }

    public function participations()
    {
        return $this->hasMany(Participation::class);
    }
}
