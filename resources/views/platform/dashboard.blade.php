@extends('layouts.app', ['title' => 'Platform Admin Dashboard - Return-Oriented Pastries'])

@section('content')
<div class="hero">
    <div class="hero-grid">
        <div>
            <div class="eyebrow">Platform Admin Panel</div>
            <h1>Global Platform Dashboard</h1>
            <p class="muted">Monitor overall transaction flows, calculate platform fees (3% commission split), and manage bakery partners.</p>
        </div>
        <div class="hero-aside">
            <div class="eyebrow">Platform Rule</div>
            <strong>3% Split Commission</strong>
            <p>Every transaction processed on the platform routes 3% of gross value as platform profit and settles 97% to the respective bakery.</p>
        </div>
    </div>
</div>

<div class="grid grid-4" style="margin-bottom: 1.5rem;">
    <div class="stat">
        <small>Total Gross Sales (100%)</small>
        <strong>Rp {{ number_format($stats['total_gross'], 2, ',', '.') }}</strong>
        <p class="inline-note" style="margin-top: 0.25rem;">Total money paid by customers</p>
    </div>
    <div class="stat" style="border-left: 4px solid var(--accent);">
        <small>Platform Profit (3%)</small>
        <strong style="color: var(--accent);">Rp {{ number_format($stats['total_platform_cut'], 2, ',', '.') }}</strong>
        <p class="inline-note" style="margin-top: 0.25rem;">Our total platform revenue</p>
    </div>
    <div class="stat">
        <small>Bakery Settlements (97%)</small>
        <strong>Rp {{ number_format($stats['total_bakery_settlement'], 2, ',', '.') }}</strong>
        <p class="inline-note" style="margin-top: 0.25rem;">Routed net to partners</p>
    </div>
    <div class="stat">
        <small>Bakery Partners & Tx</small>
        <strong>{{ $stats['total_bakeries'] }} / {{ $stats['total_transactions'] }}</strong>
        <p class="inline-note" style="margin-top: 0.25rem;">Active shops / Total orders split</p>
    </div>
</div>

<div class="grid grid-2" style="margin-bottom: 1.5rem; align-items: start;">
    <div class="card">
        <div class="landing-card-head">
            <h2>Bakery Partners</h2>
            <p class="muted">Registered bakery tenants with their split-payment statistics and payout accounts.</p>
        </div>
        
        <table>
            <thead>
                <tr>
                    <th>Shop / Owner</th>
                    <th>Gross Sales</th>
                    <th>Platform (3%)</th>
                    <th>Settled (97%)</th>
                    <th>Payout Bank Details</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bakeries as $bakery)
                    <tr>
                        <td>
                            <strong>{{ $bakery->shop_name }}</strong><br>
                            <span class="muted" style="font-size: 0.8rem;">Owner: {{ $bakery->owner?->name ?? 'Unknown' }} ({{ $bakery->owner?->email }})</span>
                        </td>
                        <td>Rp {{ number_format($bakery->gross_total, 0, ',', '.') }}</td>
                        <td style="color: var(--accent); font-weight: bold;">Rp {{ number_format($bakery->cut_total, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($bakery->settlement_total, 0, ',', '.') }}</td>
                        <td>
                            @if($bakery->bank_name)
                                <span style="font-size: 0.85rem;">
                                    <strong>{{ $bakery->bank_name }}</strong><br>
                                    Acc: {{ $bakery->bank_account_number }}<br>
                                    Name: {{ $bakery->bank_account_name }}
                                </span>
                            @else
                                <span class="muted" style="font-size: 0.85rem; font-style: italic;">No bank account set</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align: center;" class="muted">No bakery tenants registered yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="card">
        <div class="landing-card-head">
            <h2>Recent Split Transactions</h2>
            <p class="muted">Real-time split routing operations logged in the platform ledger.</p>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Tx ID / Time</th>
                    <th>Bakery</th>
                    <th>Order No</th>
                    <th>Gross</th>
                    <th>Split (3% / 97%)</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentTransactions as $tx)
                    <tr>
                        <td>
                            <strong>TX-{{ str_pad($tx->id, 5, '0', STR_PAD_LEFT) }}</strong><br>
                            <span class="muted" style="font-size: 0.8rem;">{{ $tx->created_at->format('M d, Y H:i') }}</span>
                        </td>
                        <td>{{ $tx->bakery?->shop_name ?? 'Deleted' }}</td>
                        <td><code>{{ $tx->order?->order_number ?? 'N/A' }}</code></td>
                        <td>Rp {{ number_format($tx->gross_amount, 0, ',', '.') }}</td>
                        <td>
                            <span style="color: var(--accent); font-weight: bold;">Rp {{ number_format($tx->platform_cut, 0, ',', '.') }}</span>
                            <span class="muted" style="font-size: 0.85rem;">(3%)</span><br>
                            <span style="color: var(--forest); font-weight: bold;">Rp {{ number_format($tx->bakery_settlement, 0, ',', '.') }}</span>
                            <span class="muted" style="font-size: 0.85rem;">(97%)</span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align: center;" class="muted">No split transactions recorded yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
