@extends('layouts.app')

@section('content')
    <section class="grid grid-2">
        <div class="card stack">
            <div>
                <span class="eyebrow" style="color: var(--text);">Flash Sale Rules</span>
                <h1>Automate Time-Based Discounts</h1>
                <p class="muted">Create discount windows for all products or a specific category. The lowest live price is applied automatically during order placement.</p>
            </div>

            <form action="{{ route('discounts.store') }}" method="POST" class="stack">
                @csrf

                <div class="form-grid">
                    <div>
                        <label for="name">Rule Name</label>
                        <input id="name" name="name" type="text" value="{{ old('name') }}" required>
                    </div>

                    <div>
                        <label for="scope">Scope</label>
                        <select id="scope" name="scope" required>
                            <option value="all" @selected(old('scope', 'all') === 'all')>All products</option>
                            <option value="category" @selected(old('scope') === 'category')>Specific category</option>
                        </select>
                    </div>

                    <div>
                        <label for="category">Category</label>
                        <select id="category" name="category">
                            <option value="">Only needed for category scope</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category }}" @selected(old('category') === $category)>{{ $category }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-grid">
                    <div>
                        <label for="start_time">Starts At</label>
                        <input id="start_time" name="start_time" type="time" value="{{ old('start_time', '18:00') }}" required>
                    </div>

                    <div>
                        <label for="end_time">Ends At</label>
                        <input id="end_time" name="end_time" type="time" value="{{ old('end_time', '21:00') }}" required>
                    </div>

                    <div>
                        <label for="discount_percent">Discount Percent</label>
                        <input id="discount_percent" name="discount_percent" type="number" min="1" max="90" step="0.5" value="{{ old('discount_percent', 20) }}" required>
                    </div>
                </div>

                <button class="button" type="submit">Create Discount Rule</button>
            </form>
        </div>

        <div class="card stack">
            <div>
                <h2>Current Rules</h2>
                <p class="muted">Activate the rules you want live. Create a new rule if you need a new schedule or discount shape.</p>
            </div>

            @if ($rules->isEmpty())
                <p class="muted">No discount rules yet. Create your first flash sale window from the form on the left.</p>
            @else
                <div class="report-list">
                    @foreach ($rules as $rule)
                        <article class="report-row-wide">
                            <div class="product-main">
                                <strong>{{ $rule->name }}</strong>
                                <p class="product-copy">{{ $rule->scope === 'all' ? 'All products' : 'Category: '.$rule->category }}</p>
                            </div>

                            <div class="product-meta">
                                <span class="product-label">Window</span>
                                <span class="product-value">{{ substr($rule->start_time, 0, 5) }} - {{ substr($rule->end_time, 0, 5) }}</span>
                            </div>

                            <div class="product-meta">
                                <span class="product-label">Discount</span>
                                <span class="product-value">{{ rtrim(rtrim(number_format((float) $rule->discount_percent, 2, '.', ''), '0'), '.') }}%</span>
                            </div>

                            <div class="product-meta">
                                <span class="product-label">Status</span>
                                <span class="badge {{ $rule->is_active ? '' : 'badge-muted' }}">{{ $rule->is_active ? 'ACTIVE' : 'PAUSED' }}</span>
                            </div>

                            <div class="row-actions">
                                <form action="{{ route('discounts.update', $rule) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="is_active" value="{{ $rule->is_active ? 0 : 1 }}">
                                    <button class="button-inline {{ $rule->is_active ? 'button-secondary' : '' }}" type="submit">
                                        {{ $rule->is_active ? 'Pause Rule' : 'Activate Rule' }}
                                    </button>
                                </form>
                            </div>
                        </article>
                    @endforeach
                </div>
            @endif
        </div>
    </section>
@endsection
