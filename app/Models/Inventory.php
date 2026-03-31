<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Inventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'bakery_id',
        'product_id',
        'quantity_on_hand',
        'reorder_level',
    ];

    public function bakery(): BelongsTo
    {
        return $this->belongsTo(Bakery::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
