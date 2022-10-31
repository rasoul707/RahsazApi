<?php

namespace Modules\Report\Http\Controllers\Admin;

use App\Exports\CustomersExport;
use App\Models\TimeHelper;
use Carbon\Carbon;
use Hekmatinasser\Verta\Traits\Date;
use Hekmatinasser\Verta\Verta;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Order\Entities\Builder\OrderBuilder;
use Modules\Order\Entities\Order;
use Modules\Product\Entities\Builder\ProductBuilder;
use Modules\Product\Entities\Product;
use Modules\User\Entities\Builder\UserBuilder;
use Modules\User\Entities\User;

class ReportController extends Controller
{
    /**
     * @OA\GET(
     *     path="/admin/reports/orders",
     *     tags={"Admin/Reports"},
     *      summary="مدیریت گزارش ها",
     *      description="",
     *     @OA\Parameter(
     *         name="start_date",
     *         in="query",
     *         description="start_date",
     *         required=false,
     *         explode=true
     *     ),
     *     @OA\Parameter(
     *         name="end_date",
     *         in="query",
     *         description="end_date",
     *         required=false,
     *         explode=true
     *     ),
     *     @OA\Response(response=200, description="Successful", @OA\JsonContent()),
     *     @OA\Response(response=204, description="Successful"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Not Found"),
     *     @OA\Response(response=401, description="Unauthenticated", @OA\JsonContent()),
     *    security={
     *         {
     *             "bearerAuth": {}
     *         }
     *     },
     * )
     */
    public function orders(Request $request)
    {
        $request->validate([
            'start_date' => ['nullable'],
            'end_date' => ['nullable'],
        ]);

        $startDate = $request->start_date ? TimeHelper::jalali2georgian($request->start_date) : Carbon::now()->subMonth();
        $endDate = $request->start_date ? TimeHelper::jalali2georgian($request->end_date) : Carbon::now()->endOfMonth();

        $ranges = Carbon::parse(Carbon::parse($startDate))->daysUntil(Carbon::parse($endDate));
        $chart = [];
        foreach ($ranges as $date)
        {
            $orderCounts = (new OrderBuilder())
                ->paidAtBetween(Carbon::parse($date)->startOfDay(),Carbon::parse($date)->endOfDay())
                ->count();

            $vertaDate = verta($date);
            $chart[] = [
                'full_date' => $vertaDate->formatDatetime(),
                'day' => $vertaDate->formatWord('d'),
                'month' => $vertaDate->formatWord('F'),
                'year' => $vertaDate->formatWord('Y'),
                'count' => $orderCounts,
            ];
        }

        return response()
            ->json($chart);
    }

    /**
     * @OA\GET(
     *     path="/admin/reports/customers",
     *     tags={"Admin/Reports"},
     *      summary="مدیریت گزارش ها",
     *      description="",
     *     @OA\Parameter(
     *         name="offset",
     *         in="query",
     *         description="offset",
     *         required=false,
     *         explode=true
     *     ),
     *     @OA\Parameter(
     *         name="start_date",
     *         in="query",
     *         description="start_date",
     *         required=false,
     *         explode=true
     *     ),
     *     @OA\Parameter(
     *         name="end_date",
     *         in="query",
     *         description="end_date",
     *         required=false,
     *         explode=true
     *     ),
     *     @OA\Response(response=200, description="Successful", @OA\JsonContent()),
     *     @OA\Response(response=204, description="Successful"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Not Found"),
     *     @OA\Response(response=401, description="Unauthenticated", @OA\JsonContent()),
     *    security={
     *         {
     *             "bearerAuth": {}
     *         }
     *     },
     * )
     */
    public function customers(Request $request)
    {
        $request->validate([
            'start_date' => ['nullable'],
            'end_date' => ['nullable'],
            'offset' => ['required'],
        ]);

        $startDate = $request->start_date ? TimeHelper::jalali2georgian($request->start_date) : Carbon::now()->startOfYear();
        $endDate = $request->end_date ? TimeHelper::jalali2georgian($request->end_date) : Carbon::now()->endOfYear();

        $ranges = Carbon::parse(Carbon::parse($startDate))->monthsUntil(Carbon::parse($endDate));
        $chart = [];
        foreach ($ranges as $date)
        {
            $allCustomerCounts = (new UserBuilder())
                ->type(User::TYPES['مشتری'])
                ->registerBeforeDate(Carbon::parse($date)->endOfMonth())
                ->count();

            $newCustomerCounts = (new UserBuilder())
                ->type(User::TYPES['مشتری'])
                ->registerBetween(Carbon::parse($date)->startOfMonth(),Carbon::parse($date)->endOfMonth())
                ->count();

            $goldCustomerCounts = (new UserBuilder())
                ->type(User::TYPES['مشتری'])
                ->package(User::PACKAGES['طلایی'])
                ->registerBetween(Carbon::parse($date)->startOfMonth(),Carbon::parse($date)->endOfMonth())
                ->count();

            $silverCustomerCounts = (new UserBuilder())
                ->type(User::TYPES['مشتری'])
                ->package(User::PACKAGES['نقره ای'])
                ->registerBetween(Carbon::parse($date)->startOfMonth(),Carbon::parse($date)->endOfMonth())
                ->count();

            $bronzeCustomerCounts = (new UserBuilder())
                ->type(User::TYPES['مشتری'])
                ->package(User::PACKAGES['برنزی'])
                ->registerBetween(Carbon::parse($date)->startOfMonth(),Carbon::parse($date)->endOfMonth())
                ->count();

            $vertaDate = verta($date);
            $chart[] = [
                'full_date' => Carbon::parse($date),
                'month' => $vertaDate->formatWord('F'),
                'year' => $vertaDate->formatWord('Y'),
                'all_customer_counts' => $allCustomerCounts,
                'new_customer_counts' => $newCustomerCounts,
                'gold_customer_counts' => $goldCustomerCounts,
                'silver_customer_counts' => $silverCustomerCounts,
                'bronze_customer_counts' => $bronzeCustomerCounts,
                'most_sale_city' => (new Order())->mostSaleCityOfMonth($date),
            ];
        }

        $chartCollection = collect($chart);
        return response()
            ->json([
                'page_count' => 25,
                'total_count' => $chartCollection->count(),
                'items' => $chartCollection->skip(25 * $request->offset)->take(25)->values()
            ]);
    }

    /**
     * @OA\GET(
     *     path="/admin/reports/store-room",
     *     tags={"Admin/Reports"},
     *      summary="مدیریت گزارش ها",
     *      description="",
     *     @OA\Parameter(
     *         name="offset",
     *         in="query",
     *         description="offset",
     *         required=true,
     *         explode=true
     *     ),
     *     @OA\Parameter(
     *         name="start_date",
     *         in="query",
     *         description="false",
     *         required=false,
     *         explode=true
     *     ),
     *     @OA\Parameter(
     *         name="end_date",
     *         in="query",
     *         description="end_date",
     *         required=false,
     *         explode=true
     *     ),
     *     @OA\Response(response=200, description="Successful", @OA\JsonContent()),
     *     @OA\Response(response=204, description="Successful"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Not Found"),
     *     @OA\Response(response=401, description="Unauthenticated", @OA\JsonContent()),
     *    security={
     *         {
     *             "bearerAuth": {}
     *         }
     *     },
     * )
     */
    public function storeRoom(Request $request)
    {
        $request->validate([
            'offset' => ['required'],
            'start_date' => ['nullable'],
            'end_date' => ['nullable'],
        ]);

        $startDate = $request->start_date ? TimeHelper::jalali2georgian($request->start_date) : Carbon::now()->startOfYear();
        $endDate = $request->end_date ? TimeHelper::jalali2georgian($request->end_date) : Carbon::now()->endOfYear();

        $builder = (new ProductBuilder())
            ->with([
                'otherNames',
                'tags'
            ])
            ->search($request->search, ['name'])
            ->order($request->order_by ?? 'id', $request->order_type ?? 'desc')
            ->offset($request->offset)
            ->pageCount(25);

        return response()
            ->json([
                'page_count' => 25,
                'total_count' => $builder->count(),
                'items' => $builder->getWithPageCount(),
            ]);
    }

    /**
     * @OA\POST(
     *     path="/admin/reports/store-room/update-property/{id}",
     *     tags={"Admin/Reports"},
     *      summary="مدیریت گزارش ها",
     *      description="",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="id",
     *         required=true,
     *         explode=true
     *     ),
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         description="name",
     *         required=true,
     *         explode=true
     *     ),
     *     @OA\Parameter(
     *         name="supply_count_in_store",
     *         in="query",
     *         description="supply_count_in_store",
     *         required=true,
     *         explode=true
     *     ),
     *     @OA\Response(response=200, description="Successful", @OA\JsonContent()),
     *     @OA\Response(response=204, description="Successful"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Not Found"),
     *     @OA\Response(response=401, description="Unauthenticated", @OA\JsonContent()),
     *    security={
     *         {
     *             "bearerAuth": {}
     *         }
     *     },
     * )
     */
    public function storeRoomUpdateProperty(Request $request, $id)
    {
        $request->validate([
            'name' => ['required'],
            'supply_count_in_store' => ['required'],
        ]);

       Product::query()
           ->findOrFail($id)
           ->update([
               'name' => $request->name,
               'supply_count_in_store' => $request->supply_count_in_store,
           ]);

        return response()
            ->json(null,204);
    }

    /**
     * @OA\GET(
     *     path="/admin/reports/customers/export",
     *     tags={"Admin/Reports"},
     *      summary="مدیریت گزارش ها",
     *      description="",
     *     @OA\Response(response=200, description="Successful", @OA\JsonContent()),
     *     @OA\Response(response=204, description="Successful"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Not Found"),
     *     @OA\Response(response=401, description="Unauthenticated", @OA\JsonContent()),
     *    security={
     *         {
     *             "bearerAuth": {}
     *         }
     *     },
     * )
     */
    public function customersExport()
    {
        return Excel::download(new CustomersExport(), 'customers.xlsx');
    }
}
