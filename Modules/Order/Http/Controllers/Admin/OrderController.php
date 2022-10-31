<?php

namespace Modules\Order\Http\Controllers\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Order\Entities\Builder\OrderBuilder;
use Modules\Order\Entities\Order;
use Modules\Order\Entities\OrderLog;
use Modules\Order\Entities\OrderProduct;
use Modules\Order\Http\Requests\OrderIndexRequest;
use Modules\Order\Http\Requests\UpdateOrCreateOrderRequest;
use Modules\Order\Services\OrderServices;
use Modules\SMS\Entities\SmsLog;
use Modules\User\Entities\Address;

class OrderController extends Controller
{
    /**
     * @OA\Post(
     *     path="/admin/orders/create",
     *     tags={"Admin/Orders/Create"},
     *     summary="مدیریت سفارش ها",
     *     description="",
     *     @OA\Parameter(
     *         name="user_id",
     *         in="query",
     *         description="shayan listesh toolanie azam begir",
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
    public function create(UpdateOrCreateOrderRequest $request)
    {
        $order = new Order();
        (new OrderServices())
            ->updateOrCreate($request, $order);

        return response()->json(null, 204);
    }

    /**
     * @OA\GET(
     *     path="/admin/orders/index",
     *     tags={"Admin/Orders"},
     *     summary="مدیریت سفارش ها",
     *     description="",
     *     @OA\Parameter(
     *         name="offset",
     *         in="query",
     *         description="offset",
     *         required=true,
     *         explode=true
     *     ),
     *     @OA\Parameter(
     *         name="overall_status",
     *         in="query",
     *         description="overall_status",
     *         required=false,
     *         explode=true
     *     ),
     *     @OA\Parameter(
     *         name="process_status",
     *         in="query",
     *         description="process_status",
     *         required=false,
     *         explode=true
     *     ),
     *     @OA\Parameter(
     *         name="custom_sort",
     *         in="query",
     *         description="custom_sort",
     *         required=false,
     *         explode=true
     *     ),
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="search",
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

    public function index(OrderIndexRequest $request)
    {
        $builder = (new OrderBuilder())
            ->with([
                'user'
            ])
            ->search($request->search, ['id', 'overall_status' ,'issue_tracking_number'])
            ->overallStatus($request->overall_status)
            ->processStatus($request->process_status)
            ->order($request->order_by, $request->order_type)
            ->customSort($request->custom_sort)
            ->offset($request->offset)
            ->pageCount(25);

        return response()->json([
            'page_count' => 25,
            'total_count' => $builder->count(),
            'items' => $builder->getWithPageCount()->each->append(['total_amount']),
        ]);
    }

    /**
     * @OA\DELETE(
     *     path="/admin/orders/destroy/{id}",
     *     tags={"Admin/Orders/Destroy"},
     *     summary="مدیریت سفارش ها",
     *     description="",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="id",
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

    public function destroy($id)
    {
        $order = Order::query()
            ->findOrFail($id);

        $order->overall_status = Order::OVERALL_STATUSES['حذف شده'];
        $order->save();

        return response()->json(null, 204);
    }

    /**
     * @OA\GET(
     *     path="/admin/orders/statics",
     *     tags={"Admin/Orders/Show"},
     *     summary="مدیریت سفارش ها",
     *     description="",
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

    public function statics()
    {
        return response()->json([
            'overall_statuses'  => array_keys(Order::OVERALL_STATUSES),
            'process_statues'   => array_keys(Order::PROCESS_STATUSES),
            'payment_types'     => array_keys(Order::PAYMENT_TYPES),
            'delivery_types'    => array_keys(Order::DELIVERY_TYPES),
        ], 200);
    }



    /**
     * @OA\GET(
     *     path="/admin/orders/show/{id}",
     *     tags={"Admin/Orders/Show"},
     *     summary="مدیریت سفارش ها",
     *     description="",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="id",
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

    public function show($id)
    {
        $order = Order::query()
            ->with([
                'user',
                'address',
                'bijakImage',
                'bankReceiptImage'
            ])
            ->findOrFail($id)
            ->append([
                'number_of_products',
                'total_amount',
                'total_amount_without_tax',
            ]);

        return response()->json($order, 200);
    }

    /**
     * @OA\GET(
     *     path="/admin/orders/show-products/{id}",
     *     tags={"Admin/Orders/Show"},
     *     summary="مدیریت سفارش ها",
     *     description="",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="id",
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

    public function showProducts($id)
    {
        $order = Order::query()->findOrFail($id);
        $orderProducts = OrderProduct::query()
            ->with(['product'])
            ->where('order_id', $order->id)
            ->get()->each->append(['total_amount']);
        return response()->json($orderProducts, 200);
    }



    /**
     * @OA\GET(
     *     path="/admin/orders/show-logs/{id}",
     *     tags={"Admin/Orders/Show"},
     *     summary="مدیریت سفارش ها",
     *     description="",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="id",
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

    public function showLogs($id)
    {
        $order = Order::query()->findOrFail($id);
        $logs = OrderLog::query()
            ->where('order_id', $order->id)
            ->take(5)->get();
        return response()->json($logs, 200);
    }


    /**
     * @OA\GET(
     *     path="/admin/orders/show-sms-logs/{id}",
     *     tags={"Admin/Orders/Show"},
     *     summary="مدیریت سفارش ها",
     *     description="",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="id",
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

    public function showSmsLogs($id)
    {
        $order = Order::query()->findOrFail($id);
        $logs = SmsLog::query()
            ->where('to_user_id', $order->user_id)
            ->take(5)->get();
        return response()->json($logs, 200);
    }


    /**
     * @OA\Post(
     *     path="/admin/orders/update/{id}",
     *     tags={"Admin/Orders/Update"},
     *     summary="مدیریت سفارش ها",
     *     description="",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="id",
     *         required=true,
     *         explode=true
     *     ),
     *     @OA\Parameter(
     *         name="user_id",
     *         in="query",
     *         description="shayan listesh toolanie azam begir",
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
    public function update(UpdateOrCreateOrderRequest $request, $id)
    {
        // return response()->json('kkkk', 204);
        

        $order = Order::findOrFail($id);

        (new OrderServices())
            ->updateOrCreate($request, $order);

        return response()->json(null, 204);
    }


    /**
     * @OA\Post(
     *     path="/admin/orders/update-bijak/{id}",
     *     tags={"Admin/Orders/Update"},
     *     summary="مدیریت سفارش ها",
     *     description="",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="id",
     *         required=true,
     *         explode=true
     *     ),
     *     @OA\Parameter(
     *         name="bijak_image_id",
     *         in="query",
     *         description="bijak_image_id",
     *         required=true,
     *         explode=true
     *     ),
     *     @OA\Parameter(
     *         name="bijak_note",
     *         in="query",
     *         description="bijak_note",
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
    public function updateBijak(Request $request, $id)
    {
        $request->validate([
            'bijak_image_id' => ['required'],
            'bijak_note' => ['required'],
        ]);

        $order = Order::query()->findOrFail($id);
        $order->bijak_image_id = $request->bijak_image_id;
        $order->bijak_note = $request->bijak_note;
        $order->save();

        return response()->json(null, 204);
    }


    /**
     * @OA\Post(
     *     path="/admin/orders/update-product-status/{id}",
     *     tags={"Admin/Orders/Update"},
     *     summary="مدیریت سفارش ها",
     *     description="",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="id of order product",
     *         required=true,
     *         explode=true
     *     ),
     *     @OA\Parameter(
     *         name="status",
     *         in="query",
     *         description="status",
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
    public function updateProductStatus(Request $request, $id)
    {
        $request->validate([
            'status' => ['required', 'in:'.implode(',', array_keys(OrderProduct::STATUSES))],
        ]);

        $orderProduct = OrderProduct::query()->findOrFail($id);
        $orderProduct->status = $request->status;
        $orderProduct->save();

        return response()->json(null, 204);
    }
}
