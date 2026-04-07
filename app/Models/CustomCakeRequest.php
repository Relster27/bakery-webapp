<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CustomCakeRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'bakery_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'pickup_date',
        'servings',
        'size',
        'sponge',
        'filling',
        'frosting',
        'decoration',
        'occasion',
        'inscription',
        'notes',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'pickup_date' => 'date',
            'servings' => 'integer',
        ];
    }

    public function bakery(): BelongsTo
    {
        return $this->belongsTo(Bakery::class);
    }
}
