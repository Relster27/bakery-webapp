<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'bakery_id',
        'name',
        'email',
        'phone',
    ];

    public function bakery(): BelongsTo
    {
        return $this->belongsTo(Bakery::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
