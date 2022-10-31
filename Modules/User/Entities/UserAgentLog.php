<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Carbon;

class UserAgentLog extends Model
{
    protected $table = 'user_agent_logs';
    protected $guarded = [];
    protected $with = ['user'];
    protected $casts = [
        'location' => 'json',
    ];

    /* Relations */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /* Scopes */
    public function scopeLastTen($query)
    {
        $query->orderBy('id', 'desc')->take(10);
    }

    public function scopeOnline($query)
    {
        return $query->where('updated_at', '>', Carbon::now()->subMinutes(5));
    }

    public function scopeOnlineToday($query)
    {
        return $query->where('updated_at', '>', Carbon::now()->startOfDay());
    }

    public function scopeOnlineYesterday($query)
    {
        return $query->whereBetween('updated_at', [Carbon::now()->subDay()->startOfDay(), Carbon::now()->subDay()->endOfDay()]);
    }

    public function scopeOnlineThisMonth($query)
    {
        return $query->where('updated_at', '>', Carbon::now()->subMonth());
    }
}
