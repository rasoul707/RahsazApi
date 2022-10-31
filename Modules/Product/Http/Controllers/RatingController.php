<?php

namespace Modules\Product\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Product\Entities\ProductRating;
use Modules\Product\Http\Requests\StoreRatingProductRequest;

class RatingController extends Controller
{
    /**
     * @OA\POST(
     *     path="/products/rating",
     *     tags={"Products"},
     *      summary="",
     *      description="",
     *     @OA\Parameter(
     *         name="product_id",
     *         in="query",
     *         description="product id",
     *         required=true,
     *         explode=true
     *     ),
     *     @OA\Parameter(
     *         name="rate",
     *         in="query",
     *         description="rate : between 1 to 5",
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
    public function store(StoreRatingProductRequest $request)
    {
        ProductRating::query()
            ->create([
                'user_id' => Auth::user()->id,
                'product_id' => $request->product_id,
                'rate' => $request->rate,
            ]);

        return response()
            ->json(null,204);
    }
}
