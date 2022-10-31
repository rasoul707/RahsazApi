<?php

namespace Modules\WebsiteSetting\Http\Controllers\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\WebsiteSetting\Entities\Slider;

class SliderController extends Controller
{
    /**
     * @OA\GET(
     *     path="/admin/website-setting/sliders/index",
     *     tags={"Admin/Website-Setting/Sliders"},
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
        $items = Slider::query()
            ->get();

        return response()
            ->json($items);
    }


    /**
     * @OA\GET(
     *     path="/admin/website-setting/sliders/show/{id}",
     *     tags={"Admin/Website-Setting/Sliders"},
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
        $item = Slider::query()
            ->findOrFail($id);

        return response()
            ->json($item);
    }


    /**
     * @OA\DELETE (
     *     path="/admin/website-setting/sliders/destroy/{id}",
     *     tags={"Admin/Website-Setting/Sliders"},
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
    public function destroy($id)
    {
        $item = Slider::query()
            ->findOrFail($id)->delete();

        return response()
            ->json(null, 204);
    }

    /**
     * @OA\POST  (
     *     path="/admin/website-setting/sliders/store",
     *     tags={"Admin/Website-Setting/Sliders"},
     *      summary="مدیریت وبسابت",
     *      description="",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreSliderBody")
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
    public function store(Request $request)
    {
        $request->validate([
            'image_id' => ['required'],
            'order' => ['nullable'],
            'href' => ['nullable'],
        ]);
        Slider::query()
            ->create([
                'image_id' => $request->image_id,
                'order' => $request->order ?? 1,
                'href' => $request->href
            ]);

        return response()
            ->json(null, 204);
    }

    /**
     * @OA\PUT  (
     *     path="/admin/website-setting/sliders/update/{id}",
     *     tags={"Admin/Website-Setting/Sliders"},
     *      summary="مدیریت وبسابت",
     *      description="",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="id",
     *         required=true,
     *         explode=true
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreSliderBody")
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
    public function update(Request $request, $id)
    {
        $request->validate([
            'image_id' => ['required'],
            'order' => ['nullable'],
            'href' => ['nullable'],
        ]);
        Slider::query()
            ->findOrFail($id)
            ->update([
                'image_id' => $request->image_id,
                'order' => $request->order ?? 1,
                'href' => $request->href
            ]);

        return response()
            ->json(null, 204);
    }
}
