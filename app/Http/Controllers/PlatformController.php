<?php

namespace App\Http\Controllers;

use App\Models\Bakery;
use App\Models\PlatformLedger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PlatformController extends Controller
{
    public function dashboard(): View
    {
        abort_unless(auth()->user()->is_platform_admin, 403, 'Unauthorized access to Platform Admin Dashboard.');

        // Total stats
        $stats = [
            'total_gross' => PlatformLedger::sum('gross_amount'),
            'total_platform_cut' => PlatformLedger::sum('platform_cut'),
            'total_bakery_settlement' => PlatformLedger::sum('bakery_settlement'),
            'total_bakeries' => Bakery::count(),
            'total_transactions' => PlatformLedger::count(),
        ];

        // Bakery performance and bank accounts
        $bakeries = Bakery::with('owner')
            ->select('bakeries.*', 
                DB::raw('(SELECT COALESCE(SUM(gross_amount), 0) FROM platform_ledger WHERE platform_ledger.bakery_id = bakeries.id) as gross_total'),
                DB::raw('(SELECT COALESCE(SUM(platform_cut), 0) FROM platform_ledger WHERE platform_ledger.bakery_id = bakeries.id) as cut_total'),
                DB::raw('(SELECT COALESCE(SUM(bakery_settlement), 0) FROM platform_ledger WHERE platform_ledger.bakery_id = bakeries.id) as settlement_total')
            )
            ->get();

        // Recent platform transactions
        $recentTransactions = PlatformLedger::with(['order', 'bakery'])
            ->latest()
            ->take(15)
            ->get();

        return view('platform.dashboard', [
            'stats' => $stats,
            'bakeries' => $bakeries,
            'recentTransactions' => $recentTransactions,
        ]);
    }
}
