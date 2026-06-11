@extends('layouts.app')

@section('content')
<style>
    .pay-shell {
        max-width: 640px;
        margin: 3rem auto;
    }

    .pay-step-label {
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 0.16em;
        text-transform: uppercase;
        color: #897667;
        margin-bottom: 0.6rem;
    }

    .method-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 0.75rem;
        margin-top: 0.5rem;
    }

    .method-card {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 1.2rem 0.75rem;
        border-radius: 20px;
        border: 2px solid rgba(176, 146, 121, 0.18);
        background: linear-gradient(180deg, rgba(255,255,255,0.98), rgba(249,243,236,0.94));
        cursor: pointer;
        transition: all 0.2s ease;
        text-align: center;
        font-weight: 600;
        font-size: 0.9rem;
        color: var(--text);
    }

    .method-card:hover {
        border-color: var(--accent-deep);
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(183, 103, 58, 0.12);
    }

    .method-card.active {
        border-color: var(--accent-deep);
        background: linear-gradient(180deg, rgba(255, 247, 240, 0.98), rgba(255, 238, 220, 0.94));
        box-shadow: 0 0 0 4px rgba(183, 103, 58, 0.1);
    }

    .method-card .method-icon {
        font-size: 2rem;
        line-height: 1;
    }

    .ewallet-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 0.75rem;
        margin-top: 0.75rem;
    }

    .ewallet-card {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 1rem 1.1rem;
        border-radius: 18px;
        border: 2px solid rgba(176, 146, 121, 0.18);
        background: linear-gradient(180deg, rgba(255,255,255,0.98), rgba(249,243,236,0.94));
        cursor: pointer;
        transition: all 0.2s ease;
        font-weight: 600;
        font-size: 0.95rem;
    }

    .ewallet-card:hover {
        border-color: var(--accent-deep);
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(183, 103, 58, 0.1);
    }

    .ewallet-card.active {
        border-color: var(--accent-deep);
        background: linear-gradient(180deg, rgba(255, 247, 240, 0.98), rgba(255, 238, 220, 0.94));
        box-shadow: 0 0 0 4px rgba(183, 103, 58, 0.1);
    }

    .ewallet-logo {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        font-weight: 900;
        flex-shrink: 0;
    }

    .info-box {
        padding: 1.5rem;
        border-radius: 20px;
        background: linear-gradient(180deg, rgba(255, 250, 243, 0.98), rgba(249, 240, 228, 0.95));
        border: 1px solid rgba(183, 103, 58, 0.18);
        text-align: center;
    }

    .info-box .account-number {
        font-family: 'Courier New', monospace;
        font-size: 2rem;
        font-weight: 800;
        letter-spacing: 3px;
        color: var(--text);
        margin: 0.75rem 0;
    }

    .info-box .amount-label {
        font-size: 0.78rem;
        font-weight: 700;
        letter-spacing: 0.14em;
        text-transform: uppercase;
        color: #897667;
        margin-bottom: 0.25rem;
    }

    .info-box .amount {
        font-size: 1.9rem;
        font-weight: 800;
        color: var(--accent-deep);
    }

    .panel-section {
        display: none;
    }

    .panel-section.visible {
        display: block;
    }

    .simulate-btn {
        width: 100%;
        padding: 1.1rem;
        font-size: 1.1rem;
        font-weight: 700;
        border: none;
        border-radius: 20px;
        background: linear-gradient(135deg, #2563eb, #1d4ed8);
        color: #fff;
        cursor: pointer;
        box-shadow: 0 12px 28px rgba(37, 99, 235, 0.32);
        transition: all 0.2s ease;
        letter-spacing: 0.04em;
    }

    .simulate-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 18px 36px rgba(37, 99, 235, 0.4);
    }

    .order-summary-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem 1.2rem;
        border-radius: 18px;
        background: linear-gradient(180deg, rgba(255,255,255,0.96), rgba(249,243,236,0.92));
        border: 1px solid rgba(176, 146, 121, 0.16);
    }
</style>

<section class="pay-shell">
    {{-- Order summary bar --}}
    <div class="card" style="margin-bottom: 1.25rem;">
        <div class="order-summary-bar">
            <div>
                <strong>{{ $order->order_number }}</strong>
                <p class="muted" style="margin: 0.1rem 0 0; font-size: 0.88rem;">
                    @if($order->order_type === 'custom_cake')
                        Custom Cake — Pickup {{ $order->pickup_time?->format('d M Y') }}
                    @else
                        Pre-order — Pickup {{ $order->pickup_time?->format('d M Y, H:i') }}
                    @endif
                </p>
            </div>
            <div style="text-align: right;">
                <div class="pay-step-label">Total</div>
                <strong style="font-size: 1.15rem; color: var(--accent-deep);">
                    Rp {{ number_format((float) $order->total_amount, 0, ',', '.') }}
                </strong>
            </div>
        </div>
    </div>

    {{-- Main payment card --}}
    <div class="card stack">

        {{-- STEP 1: Choose method --}}
        <div>
            <div class="pay-step-label">Step 1 — Choose Payment Method</div>
            <div class="method-grid">
                <button type="button" class="method-card active" id="btn-va" onclick="selectMethod('va')">
                    <span class="method-icon">🏧</span>
                    <span>Virtual Account</span>
                </button>
                <button type="button" class="method-card" id="btn-bank" onclick="selectMethod('bank')">
                    <span class="method-icon">🏦</span>
                    <span>Bank Transfer</span>
                </button>
                <button type="button" class="method-card" id="btn-ewallet" onclick="selectMethod('ewallet')">
                    <span class="method-icon">📱</span>
                    <span>E-Wallet</span>
                </button>
            </div>
        </div>

        {{-- STEP 2: Payment instructions (switches based on method) --}}

        {{-- VA Panel --}}
        <div class="panel-section visible" id="panel-va">
            <div class="pay-step-label">Step 2 — Transfer to This Virtual Account</div>
            <div class="info-box">
                <div style="font-size: 0.8rem; font-weight: 700; letter-spacing: 0.12em; text-transform: uppercase; color: #897667; margin-bottom: 0.4rem;">
                    Bank Mandiri Virtual Account
                </div>
                <div class="account-number">{{ $virtualAccount }}</div>
                <div class="amount-label">Amount to Pay</div>
                <div class="amount">Rp {{ number_format((float) $order->total_amount, 0, ',', '.') }}</div>
                <p class="muted" style="margin-top: 0.75rem; font-size: 0.84rem;">Transfer the exact amount using ATM, mobile banking, or internet banking.</p>
            </div>
        </div>

        {{-- Bank Transfer Panel --}}
        <div class="panel-section" id="panel-bank">
            <div class="pay-step-label">Step 2 — Transfer to Bakery Bank Account</div>
            @if ($bankName && $bankAccountNumber)
                <div class="info-box">
                    <div style="font-size: 0.8rem; font-weight: 700; letter-spacing: 0.12em; text-transform: uppercase; color: #897667; margin-bottom: 0.4rem;">
                        Bank {{ strtoupper($bankName) }}
                    </div>
                    <div class="account-number">{{ $bankAccountNumber }}</div>
                    <div style="font-weight: 600; color: var(--text); margin-bottom: 1rem;">a/n {{ $bankAccountName }}</div>
                    <div class="amount-label">Amount to Pay</div>
                    <div class="amount">Rp {{ number_format((float) $order->total_amount, 0, ',', '.') }}</div>
                    <p class="muted" style="margin-top: 0.75rem; font-size: 0.84rem;">Transfer the exact amount and keep your transfer receipt as proof of payment.</p>
                </div>
            @else
                <div class="info-box" style="border-color: rgba(183, 103, 58, 0.3);">
                    <span style="font-size: 2rem;">⚠️</span>
                    <p style="margin-top: 0.5rem; font-weight: 600;">Bank transfer details are not yet available.</p>
                    <p class="muted" style="font-size: 0.88rem;">Please contact the bakery directly or choose another payment method.</p>
                </div>
            @endif
        </div>

        {{-- E-Wallet Panel --}}
        <div class="panel-section" id="panel-ewallet">
            {{-- Sub-step 2a: Choose e-wallet brand --}}
            <div id="ewallet-step-brand">
                <div class="pay-step-label">Step 2 — Choose Your E-Wallet</div>
                <div class="ewallet-grid">
                    <button type="button" class="ewallet-card" onclick="selectEwallet('GoPay', '#00AA5B')">
                        <div class="ewallet-logo" style="background: #00AA5B; color: #fff;">G</div>
                        <span>GoPay</span>
                    </button>
                    <button type="button" class="ewallet-card" onclick="selectEwallet('OVO', '#4C3494')">
                        <div class="ewallet-logo" style="background: #4C3494; color: #fff;">O</div>
                        <span>OVO</span>
                    </button>
                    <button type="button" class="ewallet-card" onclick="selectEwallet('DANA', '#118EEA')">
                        <div class="ewallet-logo" style="background: #118EEA; color: #fff;">D</div>
                        <span>DANA</span>
                    </button>
                    <button type="button" class="ewallet-card" onclick="selectEwallet('ShopeePay', '#EE4D2D')">
                        <div class="ewallet-logo" style="background: #EE4D2D; color: #fff;">S</div>
                        <span>ShopeePay</span>
                    </button>
                </div>
            </div>

            {{-- Sub-step 2b: Enter customer's e-wallet number --}}
            <div id="ewallet-step-number" style="display: none;">
                <div class="pay-step-label">Step 3 — Enter Your <span id="ewallet-name-label"></span> Number</div>
                <div class="info-box" style="text-align: left; padding: 1.25rem;">
                    <label for="ewallet_phone" style="font-weight: 600; display: block; margin-bottom: 0.5rem;">
                        Your <span id="ewallet-name-label-2"></span> Phone Number
                    </label>
                    <input id="ewallet_phone" type="tel" placeholder="e.g. 0812-3456-7890"
                           style="width: 100%; font-size: 1rem; padding: 0.75rem 1rem; border-radius: 12px; border: 1.5px solid rgba(176,146,121,0.3); background: var(--paper); margin-bottom: 0.75rem;">
                    <p class="muted" style="font-size: 0.84rem; margin: 0;">
                        This is the phone number linked to your <span id="ewallet-name-label-3"></span> account. It will be used as reference for your payment.
                    </p>
                </div>
                <div style="margin-top: 0.75rem;">
                    <div class="amount-label">Amount to Pay</div>
                    <div style="font-size: 1.5rem; font-weight: 800; color: var(--accent-deep);">
                        Rp {{ number_format((float) $order->total_amount, 0, ',', '.') }}
                    </div>
                </div>
                <button type="button" onclick="goBackToEwallets()" style="margin-top: 0.75rem; background: none; border: none; cursor: pointer; color: var(--accent-deep); font-weight: 600; font-size: 0.9rem; padding: 0;">
                    ← Choose a different e-wallet
                </button>
            </div>
        </div>

        {{-- STEP 3: Simulate Pay button --}}
        <form action="{{ route('menu.payment.process', ['bakery' => $bakery->public_slug, 'order' => $order->order_number]) }}" method="POST" id="pay-form">
            @csrf
            <input type="hidden" name="payment_method" id="payment_method_input" value="virtual_account">
            <input type="hidden" name="ewallet_type" id="ewallet_type_input" value="">
            <input type="hidden" name="ewallet_phone" id="ewallet_phone_input" value="">

            <button type="submit" class="simulate-btn" onclick="collectEwalletData()">
                ✅ SIMULASI BAYAR
            </button>
            <p class="muted" style="margin-top: 0.75rem; font-size: 0.82rem; text-align: center;">
                Clicking this button simulates a successful payment and sends your order to the bakery.
            </p>
        </form>
    </div>
</section>

<script>
    let currentMethod = 'va';
    let selectedEwallet = '';

    function selectMethod(method) {
        currentMethod = method;

        // Update method button styles
        ['va', 'bank', 'ewallet'].forEach(m => {
            document.getElementById('btn-' + m).classList.remove('active');
            document.getElementById('panel-' + m).classList.remove('visible');
        });
        document.getElementById('btn-' + method).classList.add('active');
        document.getElementById('panel-' + method).classList.add('visible');

        // Update hidden input
        const methodMap = { va: 'virtual_account', bank: 'bank_transfer', ewallet: 'ewallet' };
        document.getElementById('payment_method_input').value = methodMap[method];
    }

    function selectEwallet(name, color) {
        selectedEwallet = name;
        document.getElementById('ewallet_type_input').value = name;

        // Update ewallet card styles
        document.querySelectorAll('.ewallet-card').forEach(c => c.classList.remove('active'));
        event.currentTarget.classList.add('active');

        // Update labels
        ['ewallet-name-label', 'ewallet-name-label-2', 'ewallet-name-label-3'].forEach(id => {
            document.getElementById(id).textContent = name;
        });

        // Show number input step
        document.getElementById('ewallet-step-brand').style.display = 'none';
        document.getElementById('ewallet-step-number').style.display = 'block';
    }

    function goBackToEwallets() {
        document.getElementById('ewallet-step-brand').style.display = 'block';
        document.getElementById('ewallet-step-number').style.display = 'none';
        selectedEwallet = '';
    }

    function collectEwalletData() {
        if (currentMethod === 'ewallet') {
            const phone = document.getElementById('ewallet_phone').value;
            document.getElementById('ewallet_phone_input').value = phone;
        }
    }
</script>
@endsection
