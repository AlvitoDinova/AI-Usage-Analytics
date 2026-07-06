<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $table = 'activity_logs';
    public $timestamps = false;

    protected $fillable = [
        'aktivitas',
        'user',
        'role',
        'ip_address',
    ];

    protected static function booted(): void
    {
        static::creating(function ($log) {
            // Automatically capture current user info if authenticated
            if (auth()->check()) {
                $user = auth()->user();
                $log->user = $log->user ?? $user->name;
                $log->role = $log->role ?? $user->role;
            } else {
                $log->user = $log->user ?? 'Guest';
                $log->role = $log->role ?? 'guest';
            }
            // Capture IP Address
            $log->ip_address = $log->ip_address ?? request()->ip();
        });
    }
}
