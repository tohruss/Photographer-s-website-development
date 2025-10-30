<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Promocode extends Model
{
    protected $table = 'promocodes';
    public $timestamps = false;

    protected $fillable = [
        'name',
        'discount',
        'is_active',
        'image',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'discount' => 'decimal:2',
    ];

    public function usedBy()
    {
        return $this->belongsToMany(BookingRequest::class, 'user_id');
    }

    public function bookingRequests()
    {
        return $this->hasMany(BookingRequest::class);
    }

    public function isActive(): bool
    {
        return $this->is_active;
    }
}
