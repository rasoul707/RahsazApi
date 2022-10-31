<?php

namespace Modules\WebsiteSetting\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\WebsiteSetting\Entities\Banner;
use Modules\WebsiteSetting\Entities\HomepageGroup;
use Modules\WebsiteSetting\Entities\SignupFormSetting;
use Modules\WebsiteSetting\Entities\Slider;

class WebsiteSettingController extends Controller
{
    /**
     * @OA\GET(
     *     path="/website-setting/index",
     *     tags={"Website-Setting"},
     *      summary="https://www.figma.com/file/aF7WOO69kvBDrsd7uGQ0fm/Untitled?node-id=7%3A253",
     *      description="https://www.figma.com/file/aF7WOO69kvBDrsd7uGQ0fm/Untitled?node-id=7%3A253",
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
        $sliders = Slider::query()->get();
        $homepageGroups = HomepageGroup::query()
            ->with(['products'])
            ->get();
        $banners = Banner::query()->get();

        return response([
            'sliders' => $sliders,
            'homepage_groups' => $homepageGroups,
            'banners' => $banners,
        ]);
    }


    /**
     * @OA\GET(
     *     path="/general-setting/signup-forms/index",
     *     tags={"General-Setting"},
     *      summary="تنظیمات فرم های ثبت نامی",
     *      description="",
     *     @OA\Response(response=200, description="Successful", @OA\JsonContent()),
     *     @OA\Response(response=204, description="Successful"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Not Found"),
     *     @OA\Response(response=401, description="Unauthenticated", @OA\JsonContent()),
     * )
     */
    public function signupFormsIndex(Request $request)
    {
        $items = SignupFormSetting::query()
            ->get();
        $newItems = [];
        foreach ($items as $item)
        {
            $newItems[$item['field_key']] = $item['field_value'];
        }
        return response()
            ->json($newItems);

    }
}
