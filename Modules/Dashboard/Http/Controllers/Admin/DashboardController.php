<?php

namespace Modules\Dashboard\Http\Controllers\Admin;

use App\Models\SearchLog;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Product\Entities\Product;
use Modules\User\Entities\Address;
use Modules\User\Entities\User;
use Modules\User\Entities\UserAgentLog;
use Stevebauman\Location\Location;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $onlineUserCounts = User::query()
            ->online()
            ->count();

        $onlineAnonymousCounts = UserAgentLog::query()
            ->online()
            ->count();

        $onlineUserTodayCounts = User::query()
            ->onlineToday()
            ->count();

        $onlineAnonymousTodayCounts = UserAgentLog::query()
            ->onlineToday()
            ->count();

        $onlineUserYesterdayCounts = User::query()
            ->onlineYesterday()
            ->count();

        $onlineAnonymousYesterdayCounts = UserAgentLog::query()
            ->onlineYesterday()
            ->count();

        $onlineUserThisMonthCounts = User::query()
            ->onlineThisMonth()
            ->count();

        $onlineAnonymousThisMonthCounts = UserAgentLog::query()
            ->onlineThisMonth()
            ->count();

        $totalViews = UserAgentLog::query()
            ->distinct('ip')
            ->count('name');

        $userAgentLogs = UserAgentLog::query()
            ->lastTen()
            ->get();

        $mostVisitedProducts = Product::query()
            ->withAvg('ratings', 'rate')
            ->with([
                'otherNames',
                'coverImage',
            ])
            ->orderByDesc('view')
            ->take(10)
            ->get()->each->append([
                'categories'
            ]);

        $searchLogs = SearchLog::query()
            ->orderByDesc('count')
            ->take(10)
            ->get();

        return response()
            ->json([
                'online_user_counts' => $onlineUserCounts + $onlineAnonymousCounts,
                'online_user_today_counts' => $onlineUserTodayCounts + $onlineAnonymousTodayCounts,
                'online_user_yesterday_counts' => $onlineUserYesterdayCounts + $onlineAnonymousYesterdayCounts,
                'online_user_this_month_counts' => $onlineUserThisMonthCounts + $onlineAnonymousThisMonthCounts,
                'total_views' => $totalViews,
                'user_agent_logs' => $userAgentLogs,
                'most_visited_products' => $mostVisitedProducts,
                'most_search' => $searchLogs
        ]);

    }
}
