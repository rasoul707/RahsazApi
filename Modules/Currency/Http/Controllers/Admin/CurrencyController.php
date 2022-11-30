<?php

namespace Modules\Currency\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Currency\Entities\CurrencyBuilder;
use Modules\Currency\Http\Requests\StoreCurrencyRequest;
use Modules\Currency\Http\Requests\UpdateCurrencyRequest;
use Modules\Product\Entities\Currency;

class CurrencyController extends Controller
{
    /**
     * @OA\GET(
     *     path="/admin/currencies",
     *     tags={"Admin/Currency"},
     *     summary="مدیریت ارز ها",
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
    public function index(Request $request)
    {
        $builder = (new CurrencyBuilder())
            ->order($request->order_by, $request->order_type)

            ->pageCount($request->page_size);

        return response()->json([
            'page_count' => $request->page_size,
            'total_count' => $builder->count(),
            'items' => $builder->getWithPageCount(),
        ]);
    }

    /**
     * @OA\POST(
     *     path="/admin/currencies/store",
     *     tags={"Admin/Currency"},
     *     summary="مدیریت ارز ها",
     *     description="",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreCurrencyBody")
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
    public function store(StoreCurrencyRequest $request)
    {
        $currency = new Currency();

        Currency::updateOrCreateCurrency($currency, $request);

        return response()->json(null, 204);
    }

    /**
     * @OA\GET(
     *     path="/admin/currencies/show/{id}",
     *     tags={"Admin/Currency"},
     *     summary="مدیریت ارز ها",
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
        $currency = Currency::query()->findOrFail($id);

        return response()->json($currency);
    }

    /**
     * @OA\PUT(
     *     path="/admin/currencies/update/{id}",
     *     tags={"Admin/Currency"},
     *     summary="مدیریت ارز ها",
     *     description="",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="id",
     *         required=true,
     *         explode=true
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreCurrencyBody")
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
    public function update(UpdateCurrencyRequest $request, $id)
    {
        $currency = Currency::findOrFail($id);
        Currency::updateOrCreateCurrency($currency, $request);
        Currency::updateProductsAfterCurrencyUpdated($currency);

        return response()->json(null, 204);
    }

    /**
     * @OA\DELETE (
     *     path="/admin/currencies/destroy/{id}",
     *     tags={"Admin/Currency"},
     *     summary="مدیریت ارز ها",
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
        $currency = Currency::query()->findOrFail($id);
        $currency->delete();
        Currency::updateProductsAfterCurrencyDeleted($currency);

        return response()->json(null, 204);
    }
}
