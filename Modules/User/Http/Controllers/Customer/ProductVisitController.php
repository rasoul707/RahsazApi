<?php

namespace Modules\User\Http\Controllers\Customer;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\User\Entities\Builder\UserProductVisitBuilder;

class ProductVisitController extends Controller
{
    /**
     * @OA\GET (
     *     path="/customer/product-visits/index",
     *     tags={"Customer/ProductVisits"},
     *     summary="مشتری - محصولات بازدید شده",
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
        $builder = (new UserProductVisitBuilder())
            ->with(['product'])
            ->order('id', 'desc')
            ->userId(auth()->user()->id)
            ->offset(0)
            ->pageCount(10);

        return response()->json($builder->getWithPageCount());
    }
}
