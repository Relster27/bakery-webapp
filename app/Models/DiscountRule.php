<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DiscountRule extends Model
{
    use HasFactory;

    protected $fillable = [
        'bakery_id',
        'name',
        'scope',
        'category',
        'start_time',
        'end_time',
        'discount_percent',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'discount_percent' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    public function bakery(): BelongsTo
    {
        return $this->belongsTo(Bakery::class);
    }

    public function appliesTo(Product $product): bool
    {
        if ($this->scope === 'all') {
            return true;
        }

        return $this->category !== null && $this->category === $product->category;
    }
}
