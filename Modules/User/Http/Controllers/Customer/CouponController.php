<?php

namespace Modules\User\Http\Controllers\Customer;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Coupon\Entities\Builder\CouponBuilder;

class CouponController extends Controller
{
    /**
     * @OA\GET (
     *     path="/customer/coupons/index",
     *     tags={"Customer/Coupons"},
     *     summary="مدیریت تخفیف ها",
     *     description="",
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
    public function index()
    {
        $builder = (new CouponBuilder())
            ->activationType('active')
            ->customerPov(auth()->user()->id)
            ->order('id', 'desc');

        return response()
            ->json($builder->getAll());
    }
}
