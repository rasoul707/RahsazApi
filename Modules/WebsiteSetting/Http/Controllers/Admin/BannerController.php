<?php

namespace Modules\WebsiteSetting\Http\Controllers\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\WebsiteSetting\Entities\Banner;
use Modules\WebsiteSetting\Entities\CompanyInfoSetting;

class BannerController extends Controller
{
    /**
     * @OA\GET(
     *     path="/admin/website-setting/banners/index",
     *     tags={"Admin/Website-Setting/Banners"},
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
        $items = Banner::query()->get();
        $newItems = [];
        foreach ($items as $item)
        {
            $newItems[$item['key']] = $item['value'];
        }
        return response()
            ->json($newItems);
    }

    /**
     * @OA\POST(
     *     path="/admin/website-setting/banners/store",
     *     tags={"Admin/Website-Setting/Banners"},
     *      summary="مدیریت وبسابت",
     *      description="",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/SampleKeyValueBody")
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
        $requests = $request->all();
        foreach ($requests ?? [] as $key => $value)
        {
            Banner::query()
                ->updateOrCreate([
                    'key' => $key,
                ],[
                    'value' => $value,
                ]);
        }

        return response()
            ->json(null,204);
    }
}
