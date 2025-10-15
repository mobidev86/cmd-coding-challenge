<?php

namespace App\Models;

use App\Enums\QuoteStatus;
use App\Enums\ServiceType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'service_type',
        'booking_datetime',
        'duration',
        'additional_notes',
        'status',
        'estimated_price',
        'final_price',
        'rejection_reason',
    ];

    protected $casts = [
        'service_type' => ServiceType::class,
        'status' => QuoteStatus::class,
        'booking_datetime' => 'datetime',
        // 'duration' => 'decimal:2',
        'duration' => 'float',
        'estimated_price' => 'decimal:2',
        'final_price' => 'decimal:2',
    ];

    protected static function booted(): void
    {
        static::creating(function (Quote $quote) {
            if (!$quote->estimated_price) {
                $quote->estimated_price = $quote->calculateEstimatedPrice();
            }
        });
    }

    public function calculateEstimatedPrice(): float
    {
        $hourlyRate = $this->service_type->getHourlyRate();
        return $hourlyRate * $this->duration;
    }

    public function getPriceToDisplay(): float
    {
        return $this->final_price ?? $this->estimated_price;
    }
}
