<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    /** @use HasFactory<\Database\Factories\DeviceFactory> */
    use HasFactory;

    protected $fillable = [
        'name','type','provider','status','phone','instance_id',
        'credentials','meta','connected_at','last_seen_at','last_error','created_by',
    ];

    protected $casts = [
        'credentials' => 'array',
        'meta' => 'array',
        'connected_at' => 'datetime',
        'last_seen_at' => 'datetime',
    ];

    public function scopeActive($q){ return $q->where('status','connected'); }
}
