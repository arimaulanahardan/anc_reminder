<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = [
        'name',
        'phone_number',
        'notes',
    ];

    public function reminders()
    {
        return $this->hasMany(Reminder::class);
    }
}
