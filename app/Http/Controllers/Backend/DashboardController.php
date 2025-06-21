<?php

declare(strict_types=1);

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use App\Models\TravelCompany;
use App\Models\User;
use App\Services\Charts\UserChartService;
use App\Services\LanguageService;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DashboardController extends Controller
{
    public function __construct(
        private readonly UserChartService $userChartService,
        private readonly LanguageService $languageService
    ) {
    }


    public function index()
    {
        $this->checkAuthorization(auth()->user(), []);

        $totalBills = DB::table('bills')->count();
        $totalPaid = DB::table('bills')->where('payment_status', 'paid')->sum('amount_paid');
        $totalUnpaid = DB::table('bills')->where('payment_status', 'unpaid')->sum('grand_total');
        $averageDiscount = DB::table('bills')->avg('discount_amount_applied');

        $monthlyBilling = DB::table('bills')
            ->selectRaw('DATE_FORMAT(bill_date, "%b") as month, SUM(grand_total) as total')
            ->groupBy('month')
            ->orderByRaw('STR_TO_DATE(month, "%b")')
            ->get();

        return view('backend.pages.dashboard.index', [
            'total_users' => number_format(User::count()),
            'total_hotels' => number_format(Hotel::count()),
            'total_travel_companies' => number_format(TravelCompany::count()),
            'languages' => [
                'total' => number_format(count($this->languageService->getLanguages())),
                'active' => number_format(count($this->languageService->getActiveLanguages())),
            ],
            'user_growth_data' => $this->userChartService->getUserGrowthData(
                request()->get('chart_filter_period', 'last_12_months')
            )->getData(true),
            'user_history_data' => $this->userChartService->getUserHistoryData(),

            'billing_months' => $monthlyBilling->pluck('month'),
            'billing_totals' => $monthlyBilling->pluck('total'),
            'total_bills' => number_format($totalBills),
            'total_paid' => number_format($totalPaid, 2),
            'total_unpaid' => number_format($totalUnpaid, 2),
            'average_discount' => number_format((float) ($averageDiscount ?? 0), 2),
        ]);
    }

}
