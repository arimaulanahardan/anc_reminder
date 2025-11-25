<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WhatsAppConnection extends Model
{
    protected $table = 'whatsapp_connections';

    protected $fillable = [
        'is_connected',
        'qr_code',
        'connected_at',
        'disconnected_at',
    ];

    protected $casts = [
        'is_connected' => 'boolean',
        'connected_at' => 'datetime',
        'disconnected_at' => 'datetime',
    ];
}
