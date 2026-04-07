<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'bakery_id',
        'customer_id',
        'order_number',
        'order_type',
        'order_status',
        'total_amount',
        'discount_total',
        'platform_fee',
        'notes',
        'pickup_time',
        'expires_at',
        'fulfilled_at',
        'stock_restored_at',
        'ordered_at',
    ];

    protected function casts(): array
    {
        return [
            'total_amount' => 'decimal:2',
            'discount_total' => 'decimal:2',
            'platform_fee' => 'decimal:2',
            'pickup_time' => 'datetime',
            'expires_at' => 'datetime',
            'fulfilled_at' => 'datetime',
            'stock_restored_at' => 'datetime',
            'ordered_at' => 'datetime',
        ];
    }

    public function bakery(): BelongsTo
    {
        return $this->belongsTo(Bakery::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function isPreorder(): bool
    {
        return $this->order_type === 'preorder';
    }

    public function grossBeforeDiscount(): float
    {
        return (float) $this->total_amount + (float) $this->discount_total;
    }

    public function netAfterFees(): float
    {
        return (float) $this->total_amount - (float) $this->platform_fee;
    }
}
