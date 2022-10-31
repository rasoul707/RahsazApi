<?php

namespace Modules\WebsiteSetting\Http\Controllers\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Product\Entities\Product;
use Modules\WebsiteSetting\Entities\HomepageGroup;
use Modules\WebsiteSetting\Entities\HomepageGroupProduct;

class HomepageGroupController extends Controller
{

    /**
     * @OA\GET(
     *     path="/admin/website-setting/homepage-groups/index",
     *     tags={"Admin/Website-Setting/Homepage-Groups"},
     *      summary="مدیریت وبسابت",
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
    public function index()
    {
        $items = HomepageGroup::query()->get();
        return response()
            ->json($items);
    }

    /**
     * @OA\GET(
     *     path="/admin/website-setting/homepage-groups/show/{id}",
     *     tags={"Admin/Website-Setting/Homepage-Groups"},
     *      summary="مدیریت وبسابت",
     *      description="",
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
        $item = HomepageGroup::query()
            ->with([
                'products'
            ])
            ->findOrFail($id);
        return response()
            ->json($item);
    }


    /**
     * @OA\PUT(
     *     path="/admin/website-setting/homepage-groups/update-title/{id}",
     *     tags={"Admin/Website-Setting/Homepage-Groups"},
     *      summary="مدیریت وبسابت",
     *      description="",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="id",
     *         required=true,
     *         explode=true
     *     ),
     *     @OA\Parameter(
     *         name="title",
     *         in="query",
     *         description="title",
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
    public function updateTitle(Request $request, $id)
    {
        $item = HomepageGroup::query()->findOrFail($id);
        $item->title = $request->title;
        $item->save();
        return response()
            ->json(null, 204);
    }

    /**
     * @OA\PUT(
     *     path="/admin/website-setting/homepage-groups/update-status/{id}",
     *     tags={"Admin/Website-Setting/Homepage-Groups"},
     *      summary="مدیریت وبسابت",
     *      description="",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="id",
     *         required=true,
     *         explode=true
     *     ),
     *     @OA\Parameter(
     *         name="status",
     *         in="query",
     *         description="status -> enable or disable",
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
    public function updateStatus(Request $request, $id)
    {
        $item = HomepageGroup::query()->findOrFail($id);
        $item->status = $request->status;
        $item->save();
        return response()
            ->json(null, 204);
    }


    /**
     * @OA\PUT(
     *     path="/admin/website-setting/homepage-groups/add-product/{id}",
     *     tags={"Admin/Website-Setting/Homepage-Groups"},
     *      summary="مدیریت وبسابت",
     *      description="",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="id",
     *         required=true,
     *         explode=true
     *     ),
     *     @OA\Parameter(
     *         name="product_id",
     *         in="query",
     *         description="product_id",
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
    public function addProduct(Request $request, $id)
    {
        HomepageGroup::query()->findOrFail($id);
        Product::query()->findOrFail($request->product_id);
        HomepageGroupProduct::query()
            ->firstOrCreate([
                'homepage_group_id' => $id,
                'product_id' => $request->product_id,
            ],[
                'homepage_group_id' => $id,
                'product_id' => $request->product_id,
            ]);
        return response()
            ->json(null, 204);
    }


    /**
     * @OA\PUT(
     *     path="/admin/website-setting/homepage-groups/delete-product/{id}",
     *     tags={"Admin/Website-Setting/Homepage-Groups"},
     *      summary="مدیریت وبسابت",
     *      description="",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="id",
     *         required=true,
     *         explode=true
     *     ),
     *     @OA\Parameter(
     *         name="product_id",
     *         in="query",
     *         description="product_id",
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
    public function deleteProduct(Request $request, $id)
    {
        HomepageGroup::query()->findOrFail($id);
        Product::query()->findOrFail($request->product_id);
        HomepageGroupProduct::query()
            ->where([
                'homepage_group_id' => $id,
                'product_id' => $request->product_id,
            ])->firstOrFail()->delete();
        return response()
            ->json(null, 204);
    }

    /**
     * @OA\PUT(
     *     path="/admin/website-setting/homepage-groups/reset/{id}",
     *     tags={"Admin/Website-Setting/Homepage-Groups"},
     *      summary="مدیریت وبسابت",
     *      description="",
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
    public function reset($id)
    {
        HomepageGroup::query()->findOrFail($id);
        HomepageGroupProduct::query()
            ->where([
                'homepage_group_id' => $id,
            ])->delete();
        return response()
            ->json(null, 204);
    }
}
