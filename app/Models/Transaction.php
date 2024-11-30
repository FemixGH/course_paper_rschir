<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'amount',
        'description',
        'user_id',
    ];

    // Связь с моделью User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}