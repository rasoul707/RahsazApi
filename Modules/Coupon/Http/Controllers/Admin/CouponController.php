<?php

namespace Modules\Coupon\Http\Controllers\Admin;

use App\Models\TimeHelper;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Modules\Category\Entities\CategoryItem;
use Modules\Coupon\Entities\Builder\CouponBuilder;
use Modules\Coupon\Entities\Coupon;
use Modules\Coupon\Entities\Couponable;
use Modules\Coupon\Http\Requests\StoreCouponRequest;
use Modules\Product\Entities\Product;
use Modules\User\Entities\User;
use Modules\User\Entities\UserPackage;

class CouponController extends Controller
{

    /**
     * @OA\POST(
     *     path="/admin/coupons/store",
     *     tags={"Admin/Coupons"},
     *     summary="مدیریت تخفیف ها",
     *     description="",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreCouponRequestBody")
     *     ),
     *     @OA\Response(response=200, description="Successful", @OA\JsonContent()),
     *     @OA\Response(response=204, description="Successful"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Not Found"),
     *     @OA\Response(response=401, description="Unauthenticated", @OA\JsonContent()),
     *     security={
     *         {
     *             "bearerAuth": {}
     *         }
     *     },
     * )
     */
    public function store(StoreCouponRequest $request)
    {
        DB::transaction(function () use($request){
            $coupon = new Coupon();
            Coupon::updateOrCreateCoupon($coupon, $request);
        });



        return response()
            ->json(null, 204);
    }

    /**
     * @OA\DELETE (
     *     path="/admin/coupons/destroy/{id}",
     *     tags={"Admin/Coupons"},
     *     summary="مدیریت تخفیف ها",
     *     description="",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         example="1",
     *         description="id",
     *         required=true,
     *         explode=true
     *     ),
     *     @OA\Response(response=200, description="Successful", @OA\JsonContent()),
     *     @OA\Response(response=204, description="Successful"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Not Found"),
     *     @OA\Response(response=401, description="Unauthenticated", @OA\JsonContent()),
     *     security={
     *         {
     *             "bearerAuth": {}
     *         }
     *     },
     * )
     */
    public function destroy($id)
    {
        Coupon::query()
            ->findOrFail($id)->delete();

        return response()
            ->json(null,204);
    }


    /**
     * @OA\PUT(
     *     path="/admin/coupons/update/{id}",
     *     tags={"Admin/Coupons"},
     *     summary="مدیریت تخفیف ها",
     *     description="",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         example="1",
     *         description="id",
     *         required=true,
     *         explode=true
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreCouponRequestBody")
     *     ),
     *     @OA\Response(response=200, description="Successful", @OA\JsonContent()),
     *     @OA\Response(response=204, description="Successful"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Not Found"),
     *     @OA\Response(response=401, description="Unauthenticated", @OA\JsonContent()),
     *     security={
     *         {
     *             "bearerAuth": {}
     *         }
     *     },
     * )
     */

    public function update(Request $request, $id)
    {
        DB::transaction(function () use($request, $id){
            $coupon = Coupon::findOrFail($id);
            Coupon::updateOrCreateCoupon($coupon, $request);
        });
        return response()->json(null, 204);
    }

    /**
     * @OA\GET (
     *     path="/admin/coupons/index",
     *     tags={"Admin/Coupons"},
     *     summary="مدیریت تخفیف ها",
     *     description="",
     *     @OA\Parameter(
     *         name="offset",
     *         in="query",
     *         example="0",
     *         description="offset",
     *         required=true,
     *         explode=true
     *     ),
     *     @OA\Parameter(
     *         name="activation_type",
     *         in="query",
     *         example="active or inactive",
     *         description="activation_type",
     *         required=true,
     *         explode=true
     *     ),
     *     @OA\Response(response=200, description="Successful", @OA\JsonContent()),
     *     @OA\Response(response=204, description="Successful"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Not Found"),
     *     @OA\Response(response=401, description="Unauthenticated", @OA\JsonContent()),
     *     security={
     *         {
     *             "bearerAuth": {}
     *         }
     *     },
     * )
     */

    public function index(Request $request)
    {
        $request->validate([
            'offset' => ['required'],
            'activation_type' => ['required', 'in:active,inactive'],
        ]);

        $builder = (new CouponBuilder())
            ->activationType($request->activation_type)
            ->search($request->search, ['code'])
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
     * @OA\GET (
     *     path="/admin/coupons/show/{id}",
     *     tags={"Admin/Coupons"},
     *     summary="مدیریت تخفیف ها",
     *     description="",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         example="1",
     *         description="id",
     *         required=true,
     *         explode=true
     *     ),
     *     @OA\Response(response=200, description="Successful", @OA\JsonContent()),
     *     @OA\Response(response=204, description="Successful"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Not Found"),
     *     @OA\Response(response=401, description="Unauthenticated", @OA\JsonContent()),
     *     security={
     *         {
     *             "bearerAuth": {}
     *         }
     *     },
     * )
     */

    public function show($id)
    {
        $coupon = Coupon::query()
            ->with([
                'allowedProducts',
                'allowedCategories',
                'allowedUsers',
                'allowedUserPackages',
            ])
            ->findOrFail($id);

        return response()
            ->json($coupon);

    }
}
