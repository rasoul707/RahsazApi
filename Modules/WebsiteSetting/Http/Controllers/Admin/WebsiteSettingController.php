<?php

namespace Modules\WebsiteSetting\Http\Controllers\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\WebsiteSetting\Entities\Banner;
use Modules\WebsiteSetting\Entities\HomepageGroup;
use Modules\WebsiteSetting\Entities\HomepageGroupProduct;
use Modules\WebsiteSetting\Entities\Slider;

class WebsiteSettingController extends Controller
{

    /**
     * @OA\POST(
     *     path="/admin/website-setting/setup",
     *     tags={"Admin/Website-Setting"},
     *      summary="مدیریت وبسابت",
     *      description="",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/WebsiteSettingSetupBody")
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

    public function setup(Request $request)
    {
        // Sliders setup
        Slider::query()->delete();
        $sliders = $request->sliders;
        foreach ($sliders ?? [] as $slider)
        {
            Slider::query()
                ->create([
                    'image_id' => $slider['image_id'],
                    'order' => $slider['order'],
                    'href' => $slider['href'],
                ]);
        }

        // Homepage group setup
        HomepageGroup::query()->delete();
        HomepageGroupProduct::query()->delete();
        $homepageGroups = $request->homepage_groups;
        foreach ($homepageGroups ?? [] as $homepageGroup)
        {
            $homepageGroupModel = HomepageGroup::query()
                ->create([
                    'title' => $homepageGroup['title'],
                    'status' => $homepageGroup['status'],
                ]);

            $homepageGroupProductIds = $homepageGroup['product_ids'];
            foreach ($homepageGroupProductIds ?? [] as $homepageGroupProductId)
            {
                HomepageGroupProduct::query()
                    ->create([
                        'homepage_group_id' => $homepageGroupModel->id,
                        'product_id' => $homepageGroupProductId
                    ]);
            }
        }

        // Banners Setup
        Banner::query()->delete();
        $banners = $request->banners;
        foreach ($banners ?? [] as $banner)
        {
            Banner::query()
                ->create([
                    'image_id' => $banner['image_id'],
                    'location' => $banner['location'],
                    'href' => $banner['href'],
                    'description' => $banner['description'],
                    'type' => $banner['type'],
                    'status' => $banner['status'],
                    'expired_at' => $banner['expired_at'],
                ]);
        }

        return response()
            ->json(null,204);
    }

    /**
     * @OA\POST(
     *     path="/admin/website-setting/sliders/setup",
     *     tags={"Admin/Website-Setting"},
     *      summary="مدیریت وبسابت",
     *      description="",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/WebsiteSettingSetupBody")
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

    public function slidersSetup(Request $request)
    {
        // Sliders setup
        Slider::query()->delete();
        $sliders = $request->sliders;
        foreach ($sliders ?? [] as $slider)
        {
            Slider::query()
                ->create([
                    'image_id' => $slider['image_id'],
                    'order' => $slider['order'],
                    'href' => $slider['href'],
                ]);
        }

        return response()
            ->json(null,204);
    }

    /**
     * @OA\POST(
     *     path="/admin/website-setting/homepage-groups/setup",
     *     tags={"Admin/Website-Setting"},
     *      summary="مدیریت وبسابت",
     *      description="",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/WebsiteSettingSetupBody")
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

    public function homepageGroupsSetup(Request $request)
    {
        // Homepage group setup
        HomepageGroup::query()->delete();
        HomepageGroupProduct::query()->delete();
        $homepageGroups = $request->homepage_groups;
        foreach ($homepageGroups ?? [] as $homepageGroup)
        {
            $homepageGroupModel = HomepageGroup::query()
                ->create([
                    'title' => $homepageGroup['title'],
                    'status' => $homepageGroup['status'],
                ]);

            $homepageGroupProductIds = $homepageGroup['product_ids'];
            foreach ($homepageGroupProductIds ?? [] as $homepageGroupProductId)
            {
                HomepageGroupProduct::query()
                    ->create([
                        'homepage_group_id' => $homepageGroupModel->id,
                        'product_id' => $homepageGroupProductId
                    ]);
            }
        }

        return response()
            ->json(null,204);
    }



    public function homepageGroupsIndex()
    {
        $homepageGroups = HomepageGroup::query()
            ->with(['products'])
            ->get();
        return response([
            'homepage_groups' => $homepageGroups,
        ]);
    }
}
