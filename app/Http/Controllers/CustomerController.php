<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CustomerController extends Controller
{
    public function index(): View
    {
        $customers = $this->currentBakery()->customers()
            ->latest()
            ->get();

        return view('customers.index', [
            'customers' => $customers,
        ]);
    }

    public function create(): View
    {
        return view('customers.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
        ]);

        $this->currentBakery()->customers()->create($validated);

        return redirect()
            ->route('customers.index')
            ->with('success', 'Customer created.');
    }

    public function edit(Customer $customer): View
    {
        abort_unless($customer->bakery_id === $this->currentBakery()->id, 404);

        return view('customers.edit', [
            'customer' => $customer,
        ]);
    }

    public function update(Request $request, Customer $customer): RedirectResponse
    {
        abort_unless($customer->bakery_id === $this->currentBakery()->id, 404);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
        ]);

        $customer->update($validated);

        return redirect()
            ->route('customers.index')
            ->with('success', 'Customer updated.');
    }
}
