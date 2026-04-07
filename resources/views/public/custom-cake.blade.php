@extends('layouts.app')

@section('content')
    <section class="hero">
        <div class="hero-grid">
            <div>
                <span class="eyebrow">Custom Cake</span>
                <h1>Design a Cake for {{ $bakery->shop_name }}</h1>
                <p class="muted">Follow the guided steps below instead of explaining the whole request over the phone.</p>
            </div>

            <div class="hero-aside">
                <span class="eyebrow">How It Works</span>
                <p>Fill your event details, choose the flavor structure, then add any writing or decoration notes.</p>
                <p class="muted">The bakery will review the request and use it for production planning.</p>
            </div>
        </div>
    </section>

    <section class="card stack">
        <div class="actions">
            <a class="button-inline button-secondary" href="{{ route('menu.show', $bakery->public_slug) }}">Back to Public Menu</a>
        </div>

        <form action="{{ route('menu.custom-cake.store', $bakery->public_slug) }}" method="POST" class="stack">
            @csrf

            <div class="step-card stack">
                <div>
                    <h3>Step 1. Contact & Pickup</h3>
                    <p class="inline-note">Tell the bakery who you are and when the cake is needed.</p>
                </div>

                <div class="form-grid">
                    <div>
                        <label for="customer_name">Name</label>
                        <input id="customer_name" name="customer_name" type="text" value="{{ old('customer_name') }}" required>
                    </div>

                    <div>
                        <label for="customer_email">Email</label>
                        <input id="customer_email" name="customer_email" type="email" value="{{ old('customer_email') }}">
                    </div>

                    <div>
                        <label for="customer_phone">Phone</label>
                        <input id="customer_phone" name="customer_phone" type="text" value="{{ old('customer_phone') }}" required>
                    </div>

                    <div>
                        <label for="pickup_date">Pickup Date</label>
                        <input id="pickup_date" name="pickup_date" type="date" value="{{ old('pickup_date') }}" required>
                    </div>

                    <div>
                        <label for="occasion">Occasion</label>
                        <input id="occasion" name="occasion" type="text" value="{{ old('occasion') }}" placeholder="Birthday, anniversary, office event">
                    </div>
                </div>
            </div>

            <div class="step-card stack">
                <div>
                    <h3>Step 2. Size & Portions</h3>
                    <p class="inline-note">Pick a size tier that roughly matches the number of servings you need.</p>
                </div>

                <div class="form-grid">
                    <div>
                        <label for="servings">Approximate Servings</label>
                        <input id="servings" name="servings" type="number" min="6" max="200" value="{{ old('servings', 12) }}" required>
                    </div>

                    <div>
                        <label for="size">Cake Size</label>
                        <select id="size" name="size" required>
                            <option value="6-inch" @selected(old('size') === '6-inch')>6-inch</option>
                            <option value="8-inch" @selected(old('size', '8-inch') === '8-inch')>8-inch</option>
                            <option value="10-inch" @selected(old('size') === '10-inch')>10-inch</option>
                            <option value="two-tier" @selected(old('size') === 'two-tier')>Two-tier</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="step-card stack">
                <div>
                    <h3>Step 3. Build the Flavor</h3>
                    <p class="inline-note">Choose the sponge, filling, and frosting combination.</p>
                </div>

                <div class="form-grid">
                    <div>
                        <label for="sponge">Sponge / Base</label>
                        <select id="sponge" name="sponge" required>
                            <option value="Vanilla" @selected(old('sponge', 'Vanilla') === 'Vanilla')>Vanilla</option>
                            <option value="Chocolate" @selected(old('sponge') === 'Chocolate')>Chocolate</option>
                            <option value="Red Velvet" @selected(old('sponge') === 'Red Velvet')>Red Velvet</option>
                            <option value="Pandan" @selected(old('sponge') === 'Pandan')>Pandan</option>
                        </select>
                    </div>

                    <div>
                        <label for="filling">Filling</label>
                        <select id="filling" name="filling" required>
                            <option value="Fresh Cream" @selected(old('filling', 'Fresh Cream') === 'Fresh Cream')>Fresh Cream</option>
                            <option value="Chocolate Ganache" @selected(old('filling') === 'Chocolate Ganache')>Chocolate Ganache</option>
                            <option value="Strawberry Jam" @selected(old('filling') === 'Strawberry Jam')>Strawberry Jam</option>
                            <option value="Cream Cheese" @selected(old('filling') === 'Cream Cheese')>Cream Cheese</option>
                        </select>
                    </div>

                    <div>
                        <label for="frosting">Frosting</label>
                        <select id="frosting" name="frosting" required>
                            <option value="Buttercream" @selected(old('frosting', 'Buttercream') === 'Buttercream')>Buttercream</option>
                            <option value="Whipped Cream" @selected(old('frosting') === 'Whipped Cream')>Whipped Cream</option>
                            <option value="Ganache Finish" @selected(old('frosting') === 'Ganache Finish')>Ganache Finish</option>
                            <option value="Cream Cheese Frosting" @selected(old('frosting') === 'Cream Cheese Frosting')>Cream Cheese Frosting</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="step-card stack">
                <div>
                    <h3>Step 4. Decoration & Message</h3>
                    <p class="inline-note">Give the bakery the visual direction and any writing that needs to appear on the cake.</p>
                </div>

                <div class="form-grid">
                    <div>
                        <label for="decoration">Decoration Style</label>
                        <select id="decoration" name="decoration" required>
                            <option value="Minimal clean finish" @selected(old('decoration', 'Minimal clean finish') === 'Minimal clean finish')>Minimal clean finish</option>
                            <option value="Floral decoration" @selected(old('decoration') === 'Floral decoration')>Floral decoration</option>
                            <option value="Sprinkle party style" @selected(old('decoration') === 'Sprinkle party style')>Sprinkle party style</option>
                            <option value="Character / themed topper" @selected(old('decoration') === 'Character / themed topper')>Character / themed topper</option>
                        </select>
                    </div>

                    <div>
                        <label for="inscription">Cake Message</label>
                        <input id="inscription" name="inscription" type="text" value="{{ old('inscription') }}" placeholder="Happy Birthday Mira">
                    </div>
                </div>

                <div>
                    <label for="notes">Extra Notes</label>
                    <textarea id="notes" name="notes" placeholder="Color palette, no nuts, reference idea, delivery note, etc.">{{ old('notes') }}</textarea>
                </div>
            </div>

            <button class="button" type="submit">Send Custom Cake Request</button>
        </form>
    </section>
@endsection
