<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;


class Participation extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id',
        'campaign_id',
        'step',
        'data',
        'completed'
    ];

    protected $casts = [
        'data' => 'array',
    ];

    protected $table = 'participations';

    public static function findBySession($sessionId = null)
    {
        $sessionId = $sessionId ?: Session::getId();
        return static::where('session_id', $sessionId)->where('completed', false)->first();
    }
}
