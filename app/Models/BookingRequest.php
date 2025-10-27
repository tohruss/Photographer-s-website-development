<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookingRequest extends Model
{
    protected $table = 'booking_requests';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'promocode_id',
        'service_id',
        'date',
        'sale_price'
    ];

    protected $casts = [
        'date' => 'datetime',
        'sale_price' => 'integer',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function promocode()
    {
        return $this->belongsTo(Promocode::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function calculateFinalPrice(): int
    {
        $basePrice = $this->service->price;
        $discount = 0;

        if ($this->promocode && $this->promocode->isActive()) {
            $discount = $this->promocode->discount;
        }

        $finalPrice = $basePrice - $discount;

        return max(0, (int) $finalPrice);
    }

    public function updateSalePrice()
    {
        $this->sale_price = $this->calculateFinalPrice();
    }
}
