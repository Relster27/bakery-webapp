@extends('layouts.app')

@section('content')
    <section class="card stack">
        <div>
            <span class="eyebrow" style="color: var(--text);">New Sale</span>
            <h1>Create Order</h1>
            <p class="muted">Use this single form for both counter sales and pre-orders. Put quantities only on the products being ordered.</p>
        </div>

        <form id="order_form" action="{{ route('orders.store') }}" method="POST" class="stack" novalidate>
            @csrf

            <div class="form-grid">
                <div>
                    <label for="order_type">Order Type <span class="required-star">*</span></label>
                    <select id="order_type" name="order_type" required>
                        <option value="counter" @selected(old('order_type') === 'counter')>Counter Sale</option>
                        <option value="preorder" @selected(old('order_type', 'preorder') === 'preorder')>Pre-order</option>
                    </select>
                </div>

                <div>
                    <label for="customer_id">Existing Customer</label>
                    <select id="customer_id" name="customer_id">
                        <option value="">Choose later or leave empty</option>
                        @foreach ($customers as $customer)
                            <option value="{{ $customer->id }}" @selected((string) old('customer_id') === (string) $customer->id)>{{ $customer->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="pickup_time">
                        Pickup Time
                        <span id="pickup_time_star" class="required-star">*</span>
                    </label>
                    <input id="pickup_time" name="pickup_time" type="datetime-local" value="{{ old('pickup_time') }}">
                    <p class="helper-text">Required for pre-orders. Counter sales can leave this empty.</p>
                </div>
            </div>

            <div class="form-grid">
                <div>
                    <label for="customer_name">
                        New Customer Name
                        <span id="customer_name_star" class="required-star">*</span>
                    </label>
                    <input id="customer_name" name="customer_name" type="text" value="{{ old('customer_name') }}">
                    <p class="helper-text">Required only if this is a pre-order and you did not choose an existing customer.</p>
                </div>

                <div>
                    <label for="customer_email">New Customer Email</label>
                    <input id="customer_email" name="customer_email" type="email" value="{{ old('customer_email') }}">
                </div>

                <div>
                    <label for="customer_phone">
                        New Customer Phone
                        <span id="customer_phone_star" class="required-star">*</span>
                    </label>
                    <input id="customer_phone" name="customer_phone" type="text" value="{{ old('customer_phone') }}">
                    <p class="helper-text">Required only if this is a pre-order and you did not choose an existing customer.</p>
                </div>
            </div>

            <div>
                <label for="notes">Notes</label>
                <textarea id="notes" name="notes">{{ old('notes') }}</textarea>
            </div>

            <div id="products_selector_card" class="card subcard">
                <h2>Select Products <span class="required-star">*</span></h2>
                <p class="helper-text">Set the quantity for at least one product. Leave the others at zero.</p>
                <p id="products_error" class="helper-text error-text hidden">Choose at least one product quantity greater than zero.</p>

                <div class="selector-list">
                    @foreach ($products as $product)
                        <article class="selector-row">
                            <div class="product-main">
                                <strong>{{ $product->name }}</strong>
                                <p class="product-copy">{{ $product->description ?: $product->category }}</p>
                            </div>

                            <div class="product-meta">
                                <span class="product-label">Price</span>
                                @if ($product->has_active_discount ?? false)
                                    <div class="price-stack">
                                        <span class="price-current">Rp {{ number_format((float) $product->effective_price, 0, ',', '.') }}</span>
                                        <span class="price-old">Rp {{ number_format((float) $product->original_price, 0, ',', '.') }}</span>
                                        <span class="discount-note">{{ rtrim(rtrim(number_format((float) $product->discount_percent, 2, '.', ''), '0'), '.') }}% off</span>
                                    </div>
                                @else
                                    <span class="product-value">Rp {{ number_format((float) $product->price, 0, ',', '.') }}</span>
                                @endif
                            </div>

                            <div class="product-meta">
                                <span class="product-label">Stock</span>
                                <span class="product-value">{{ $product->inventory?->quantity_on_hand ?? 0 }}</span>
                            </div>

                            <div class="selector-quantity">
                                <label for="quantity_{{ $product->id }}">Order Quantity</label>
                                <input
                                    id="quantity_{{ $product->id }}"
                                    name="quantities[{{ $product->id }}]"
                                    type="number"
                                    min="0"
                                    max="{{ $product->inventory?->quantity_on_hand ?? 0 }}"
                                    value="{{ old('quantities.'.$product->id, 0) }}"
                                >
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>

            <div class="actions">
                <button class="button-inline" type="submit">Create Order</button>
                <a class="button-inline button-secondary" href="{{ route('orders.index') }}">Back</a>
            </div>
        </form>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('order_form');
            const orderType = document.getElementById('order_type');
            const customerId = document.getElementById('customer_id');
            const pickupTime = document.getElementById('pickup_time');
            const customerName = document.getElementById('customer_name');
            const customerPhone = document.getElementById('customer_phone');
            const pickupStar = document.getElementById('pickup_time_star');
            const customerNameStar = document.getElementById('customer_name_star');
            const customerPhoneStar = document.getElementById('customer_phone_star');
            const productsCard = document.getElementById('products_selector_card');
            const productsError = document.getElementById('products_error');
            const quantityInputs = Array.from(document.querySelectorAll('input[name^="quantities["]'));

            function syncRequiredState() {
                const isPreorder = orderType.value === 'preorder';
                const hasExistingCustomer = customerId.value !== '';
                const needsManualCustomer = isPreorder && ! hasExistingCustomer;

                pickupTime.required = isPreorder;
                customerName.required = needsManualCustomer;
                customerPhone.required = needsManualCustomer;

                pickupStar.classList.toggle('hidden', ! isPreorder);
                customerNameStar.classList.toggle('hidden', ! needsManualCustomer);
                customerPhoneStar.classList.toggle('hidden', ! needsManualCustomer);
            }

            function markInvalid(field) {
                field.classList.add('field-invalid');
            }

            function clearInvalid(field) {
                field.classList.remove('field-invalid');
            }

            function quantitySelected() {
                return quantityInputs.some(function (input) {
                    return Number(input.value || 0) > 0;
                });
            }

            function validateForm() {
                syncRequiredState();

                let firstInvalid = null;
                const checks = [
                    orderType,
                    pickupTime,
                    customerName,
                    customerPhone,
                ];

                checks.forEach(function (field) {
                    clearInvalid(field);
                });

                productsCard.classList.remove('subcard-invalid');
                productsError.classList.add('hidden');

                checks.forEach(function (field) {
                    if (field.required && ! field.value.trim()) {
                        markInvalid(field);

                        if (! firstInvalid) {
                            firstInvalid = field;
                        }
                    }
                });

                if (! quantitySelected()) {
                    productsCard.classList.add('subcard-invalid');
                    productsError.classList.remove('hidden');

                    if (! firstInvalid && quantityInputs.length > 0) {
                        firstInvalid = quantityInputs[0];
                    }
                }

                return firstInvalid;
            }

            form.addEventListener('submit', function (event) {
                const firstInvalid = validateForm();

                if (firstInvalid) {
                    event.preventDefault();
                    firstInvalid.focus();
                }
            });

            orderType.addEventListener('change', syncRequiredState);
            customerId.addEventListener('change', syncRequiredState);

            [pickupTime, customerName, customerPhone].forEach(function (field) {
                field.addEventListener('input', function () {
                    if (field.value.trim()) {
                        clearInvalid(field);
                    }
                });
            });

            quantityInputs.forEach(function (input) {
                input.addEventListener('input', function () {
                    if (quantitySelected()) {
                        productsCard.classList.remove('subcard-invalid');
                        productsError.classList.add('hidden');
                    }
                });
            });

            syncRequiredState();
        });
    </script>
@endsection
