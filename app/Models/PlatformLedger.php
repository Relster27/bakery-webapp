<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlatformLedger extends Model
{
    protected $table = 'platform_ledger';

    protected $fillable = [
        'order_id',
        'bakery_id',
        'gross_amount',
        'platform_cut',
        'bakery_settlement',
        'source',
    ];

    protected function casts(): array
    {
        return [
            'gross_amount'       => 'decimal:2',
            'platform_cut'       => 'decimal:2',
            'bakery_settlement'  => 'decimal:2',
        ];
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function bakery(): BelongsTo
    {
        return $this->belongsTo(Bakery::class);
    }
}
