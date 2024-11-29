<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    // 'cancelled', 
    // 'pending', 
    // 'reservation_fee_paid',
    // 'down_payment_paid',
    // 'fully_paid',
    // 'complete'

    CONST STATUS_CANCELLED = 'cancelled';
    CONST STATUS_PENDING = 'pending';
    CONST STATUS_RESERVATION_FEE_PAID = 'reservation_fee_paid';
    CONST STATUS_DOWN_PAYMENT_PAID = 'down_payment_paid';
    CONST STATUS_FULLY_PAID = 'fully_paid';
    CONST STATUS_COMPLETE = 'complete';
    CONST STATUS_RESERVATION_FEE_PENDING = 'reservation_fee_pending';
    CONST STATUS_DOWN_PAYMENT_PENDING = 'down_payment_pending';
    CONST STATUS_FULLY_PAID_PENDING = 'fully_paid_pending';

    protected $fillable = [
        'user_id',
        'name',
        'contact_number',
        'venue',
        'rate_id',
        'event_date',
        'event_type',
        'total_amount',
        'payment_type',
        'status',
        'reservation_fee',
        'payment_method',
        'message',
        'payment_id'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function add_ons(): HasMany
    {
        return $this->hasMany(OrderAddOn::class) ->withTrashed();
    }

    public function order_items(): HasMany
    {
        return $this->hasMany(OrderItem::class) ->withTrashed();
    }

    public function rate(): BelongsTo
    {
        return $this->belongsTo(Rate::class) ->withTrashed();
    }

    public function calculateRemainingBalance()
    {
        // Start with the total amount
        $remaining = $this->total_amount;

        // Subtract reservation fee if applicable
        if ($this->status === self::STATUS_RESERVATION_FEE_PAID) {
            // $remaining - = $this->reservation_fee;
        }

        // Subtract down payment if applicable (50% of total)
        if ($this->status === self::STATUS_DOWN_PAYMENT_PAID) {
            $remaining -= ($this->total_amount * 0.5);
        }

        // If fully paid, remaining balance should be 0
        if ($this->status === self::STATUS_FULLY_PAID) {
            $remaining = 0;
        }

        return $remaining;
    }

}
