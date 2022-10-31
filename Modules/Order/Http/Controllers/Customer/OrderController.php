<?php

namespace Modules\Order\Http\Controllers\Customer;

use App\Models\TimeHelper;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Coupon\Entities\Coupon;
use Modules\Order\Entities\Builder\OrderBuilder;
use Modules\Order\Entities\Order;
use Modules\Order\Entities\OrderProduct;
use Modules\Order\Http\Requests\OrderIndexRequest;
use Modules\User\Entities\Address;

class OrderController extends Controller
{

    /**
     * @OA\GET(
     *     path="/customer/orders/{id}",
     *     tags={"Customer/Orders"},
     *     summary="show order",
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
                'products',
                'bijakImage',
                'bankReceiptImage',
                'coupon'
            ])
            ->where('user_id', auth()->user()->id)
            ->where('id', $id)
            ->firstOrFail()
            ->append([
                'number_of_products',
                'total_amount',
                'total_amount_without_tax',
            ]);



        return response()
            ->json($order);
    }


    /**
     * @OA\POST(
     *     path="/customer/orders/apply-coupon/{id}",
     *     tags={"Customer/Orders"},
     *     summary="apply coupon",
     *     description="",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="id",
     *         required=true,
     *         explode=true
     *     ),
     *     @OA\Parameter(
     *         name="code",
     *         in="query",
     *         description="code",
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

    public function applyCoupon(Request $request, $id)
    {
        $request->validate([
            'code' => ['required'],
        ]);

        $order = Order::query()
            ->where('user_id', auth()->user()->id)
            ->where('id', $id)
            ->firstOrFail();

        $coupon = Coupon::query()
            ->where('code', $request->code)
            ->firstOrFail();

        if(!$coupon->isAcceptable())
        {
            $error = \Illuminate\Validation\ValidationException::withMessages([
                'error' => ['کد وارد شده قابل استفاده نمیباشد.'],
            ]);
            throw $error;
        }

        $order->coupon_id = $coupon->id;
        $order->save();

        return response()
            ->json(null, 204);
    }

    /**
     * @OA\POST(
     *     path="/customer/orders/set-address/{id}",
     *     tags={"Customer/Orders"},
     *     summary="set address",
     *     description="",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="order id",
     *         required=true,
     *         explode=true
     *     ),
     *     @OA\Parameter(
     *         name="address_id",
     *         in="query",
     *         description="address_id",
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

    public function setAddress(Request $request, $id)
    {
        $request->validate([
            'address_id' => ['required'],
        ]);

        $order = Order::query()
            ->where('user_id', auth()->user()->id)
            ->where('id', $id)
            ->firstOrFail();

        $address = Address::query()
            ->findOrFail($request->address_id);

        $order->address_id = $address->id;
        $order->save();

        return response()->json(null,204);
    }

    /**
     * @OA\POST(
     *     path="/customer/orders/set-delivery-type/{id}",
     *     tags={"Customer/Orders"},
     *     summary="set delivery type",
     *     description="",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="order id",
     *         required=true,
     *         explode=true
     *     ),
     *     @OA\Parameter(
     *         name="delivery_type",
     *         in="query",
     *         description="تحویل درب انبار شرکت | اتوبوس - پس کرایه | باربری - پس کرایه",
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

    public function setDeliveryType(Request $request, $id)
    {
        $request->validate([
            'delivery_type' => ['required' , 'in:'.implode(',', array_keys(Order::DELIVERY_TYPES))],
        ]);

        $order = Order::query()
            ->where('user_id', auth()->user()->id)
            ->where('id', $id)
            ->firstOrFail();

        $order->delivery_type = $request->delivery_type;
        $order->save();

        return response()->json(null,204);
    }


    /**
     * @OA\POST(
     *     path="/customer/orders/set-payment-type/{id}",
     *     tags={"Customer/Orders"},
     *     summary="set payment type",
     *     description="",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="order id",
     *         required=true,
     *         explode=true
     *     ),
     *     @OA\Parameter(
     *         name="payment_type",
     *         in="query",
     *         description="فیش بانکی | درگاه آنلاین",
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

    public function setPaymentType(Request $request, $id)
    {
        $request->validate([
            'payment_type' => ['required', 'in:'. implode(',', array_keys(Order::PAYMENT_TYPES))],
        ]);

        $order = Order::query()
            ->where('user_id', auth()->user()->id)
            ->where('id', $id)
            ->firstOrFail();

        $order->payment_type = $request->payment_type;
        $order->save();

        return response()->json(null,204);
    }


    /**
     * @OA\POST(
     *     path="/customer/orders/set-bank-payment-details/{id}",
     *     tags={"Customer/Orders"},
     *     summary="set payment type",
     *     description="",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="order id",
     *         required=true,
     *         explode=true
     *     ),
     *     @OA\Parameter(
     *         name="document_created_at",
     *         example="1400-05-10",
     *         in="query",
     *         description="document_created_at",
     *         required=true,
     *         explode=true
     *     ),
     *     @OA\Parameter(
     *         name="bank_receipt_number",
     *         example="123456",
     *         in="query",
     *         description="bank_receipt_number",
     *         required=true,
     *         explode=true
     *     ),
     *     @OA\Parameter(
     *         name="last_four_digit_of_card",
     *         example="5678",
     *         in="query",
     *         description="last_four_digit_of_card",
     *         required=true,
     *         explode=true
     *     ),
     *     @OA\Parameter(
     *         name="issue_tracking_number",
     *         example="181818",
     *         in="query",
     *         description="issue_tracking_number",
     *         required=true,
     *         explode=true
     *     ),
     *     @OA\Parameter(
     *         name="bank_name",
     *         example="ملی",
     *         in="query",
     *         description="bank_name",
     *         required=true,
     *         explode=true
     *     ),
     *     @OA\Parameter(
     *         name="bank_receipt_image_id",
     *         example="1",
     *         in="query",
     *         description="bank_receipt_image_id",
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

    public function setBankPaymentDetails(Request $request, $id)
    {
        $request->validate([
            'document_created_at' => ['required'],
            'bank_receipt_number' => ['required'],
            'last_four_digit_of_card' => ['required'],
            'issue_tracking_number' => ['required'],
            'bank_name' => ['required'],
            'bank_receipt_image_id' => ['nullable'],
        ]);

        $order = Order::query()
            ->where('user_id', auth()->user()->id)
            ->where('id', $id)
            ->firstOrFail();

        $order->document_created_at = TimeHelper::jalali2georgian($request->document_created_at);
        $order->bank_receipt_number = $request->bank_receipt_number;
        $order->last_four_digit_of_card = $request->last_four_digit_of_card;
        $order->issue_tracking_number = $request->issue_tracking_number;
        $order->bank_name = $request->bank_name;
        $order->bank_receipt_image_id = $request->bank_receipt_image_id;
        $order->paid_at = Carbon::now();
        $order->overall_status = Order::OVERALL_STATUSES['در حال پردازش'];
        $order->save();

        return response()->json(null,204);
    }


    /**
     * @OA\GET(
     *     path="/customer/orders/index",
     *     tags={"Customer/Orders"},
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
                'user',
                'products'
            ])
            ->userId(Auth::user()->id)
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
     * @OA\GET(
     *     path="/customer/orders/statics",
     *     tags={"Customer/Orders/Show"},
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
        ],200);
    }




    /**
     * @OA\GET(
     *     path="/customer/orders/show-products/{id}",
     *     tags={"Customer/Orders/Show"},
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
        $order = Order::query()
            ->where('user_id', Auth::user()->id)
            ->findOrFail($id);
        $orderProducts = OrderProduct::query()
            ->with(['product'])
            ->where('order_id', $order->id)
            ->get()->each->append(['total_amount']);
        return response()->json($orderProducts,200);
    }


}
