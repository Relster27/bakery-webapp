<?php

namespace App\Http\Controllers;

use App\Models\DiscountRule;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DiscountRuleController extends Controller
{
    public function index(): View
    {
        $bakery = $this->currentBakery();

        return view('discounts.index', [
            'rules' => $bakery->discountRules()
                ->latest()
                ->get(),
            'categories' => $bakery->products()
                ->select('category')
                ->distinct()
                ->orderBy('category')
                ->pluck('category'),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'scope' => ['required', 'in:all,category'],
            'category' => ['nullable', 'string', 'max:100'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['required', 'date_format:H:i'],
            'discount_percent' => ['required', 'numeric', 'min:1', 'max:90'],
        ]);

        if ($validated['scope'] === 'category' && empty($validated['category'])) {
            return back()
                ->withErrors(['category' => 'Choose a category when the discount scope is set to category.'])
                ->withInput();
        }

        $this->currentBakery()->discountRules()->create([
            ...$validated,
            'category' => $validated['scope'] === 'category' ? $validated['category'] : null,
            'is_active' => true,
        ]);

        return redirect()
            ->route('discounts.index')
            ->with('success', 'Discount rule created.');
    }

    public function update(Request $request, DiscountRule $discountRule): RedirectResponse
    {
        abort_unless($discountRule->bakery_id === $this->currentBakery()->id, 404);

        $validated = $request->validate([
            'is_active' => ['required', 'boolean'],
        ]);

        $discountRule->update($validated);

        return redirect()
            ->route('discounts.index')
            ->with('success', 'Discount rule updated.');
    }
}
