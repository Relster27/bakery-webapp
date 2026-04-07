<?php

namespace App\Services;

use App\Models\Bakery;
use App\Models\DiscountRule;
use App\Models\Product;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class PricingService
{
    public function decorateProducts(Bakery $bakery, Collection $products, ?Carbon $moment = null): Collection
    {
        $rules = $this->activeRules($bakery);

        return $products->map(function (Product $product) use ($rules, $moment) {
            $pricing = $this->quoteAgainstRules($product, $rules, $moment);

            foreach ($pricing as $key => $value) {
                $product->setAttribute($key, $value);
            }

            return $product;
        });
    }

    public function priceForProduct(Bakery $bakery, Product $product, ?Carbon $moment = null): array
    {
        return $this->quoteAgainstRules($product, $this->activeRules($bakery), $moment);
    }

    protected function activeRules(Bakery $bakery): Collection
    {
        if ($bakery->relationLoaded('discountRules')) {
            return $bakery->discountRules
                ->where('is_active', true)
                ->sortByDesc('discount_percent')
                ->values();
        }

        return $bakery->discountRules()
            ->where('is_active', true)
            ->orderByDesc('discount_percent')
            ->get();
    }

    protected function quoteAgainstRules(Product $product, Collection $rules, ?Carbon $moment = null): array
    {
        $moment ??= now();
        $originalPrice = round((float) $product->price, 2);
        $rule = $rules
            ->first(fn (DiscountRule $discountRule) => $discountRule->appliesTo($product) && $this->isActiveAt($discountRule, $moment));

        if (! $rule) {
            return [
                'original_price' => $originalPrice,
                'effective_price' => $originalPrice,
                'discount_amount' => 0,
                'discount_percent' => 0,
                'discount_name' => null,
                'has_active_discount' => false,
            ];
        }

        $discountAmount = round($originalPrice * ((float) $rule->discount_percent / 100), 2);
        $effectivePrice = max(0, round($originalPrice - $discountAmount, 2));

        return [
            'original_price' => $originalPrice,
            'effective_price' => $effectivePrice,
            'discount_amount' => $discountAmount,
            'discount_percent' => (float) $rule->discount_percent,
            'discount_name' => $rule->name,
            'has_active_discount' => true,
        ];
    }

    protected function isActiveAt(DiscountRule $rule, Carbon $moment): bool
    {
        $currentTime = $moment->format('H:i:s');
        $startTime = $rule->start_time;
        $endTime = $rule->end_time;

        if ($startTime <= $endTime) {
            return $currentTime >= $startTime && $currentTime <= $endTime;
        }

        return $currentTime >= $startTime || $currentTime <= $endTime;
    }
}
