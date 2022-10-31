<?php

namespace Modules\WebsiteSetting\Http\Controllers\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Product\Entities\Currency;
use Modules\WebsiteSetting\Entities\CompanyInfoSetting;
use Modules\WebsiteSetting\Entities\Setting;
use Modules\WebsiteSetting\Entities\SignupFormSetting;
use Modules\WebsiteSetting\Http\Requests\TaxAndRoundingStoreRequest;
use Modules\WebsiteSetting\Http\Requests\UpdateCurrencyRequest;

class GeneralSettingController extends Controller
{
    /**
     * @OA\GET(
     *     path="/admin/general-setting/currencies/index",
     *     tags={"Admin/General-Setting"},
     *      summary="تنظیمات ارز ها و مالیات ها",
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

    public function currenciesIndex()
    {
        $setting = Currency::query()->get();
        return response()
            ->json($setting);
    }

    /**
     * @OA\PUT(
     *     path="/admin/general-setting/currencies/setup/{id}",
     *     tags={"Admin/General-Setting"},
     *      summary="تنظیمات ارز ها و مالیات ها",
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
     *         @OA\JsonContent(ref="#/components/schemas/UpdateCurrencyRequestBody")
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
    public function currenciesSetup(UpdateCurrencyRequest $request, $id)
    {
        $currency = Currency::query()->findOrFail($id);
        $currency->golden_package_price = $request->golden_package_price;
        $currency->silver_package_price = $request->silver_package_price;
        $currency->bronze_package_price = $request->bronze_package_price;
        $currency->save();

        return response()
            ->json(null, 204);
    }


    /**
     * @OA\POST(
     *     path="/admin/general-setting/tax-and-rounding/setup",
     *     tags={"Admin/General-Setting"},
     *      summary="تنظیمات ارز ها و مالیات ها",
     *      description="",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/TaxAndRoundingRequestBody")
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
    public function taxAndRoundingSetup(TaxAndRoundingStoreRequest $request)
    {
        Setting::query()->truncate();
        Setting::query()->create($request->all());
        return response()
            ->json(null, 204);
    }

    /**
     * @OA\GET(
     *     path="/admin/general-setting/tax-and-rounding/index",
     *     tags={"Admin/General-Setting"},
     *      summary="تنظیمات ارز ها و مالیات ها",
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

    public function taxAndRoundingIndex()
    {
        $setting = Setting::query()->first();
        return response()
            ->json($setting);
    }


    /**
     * @OA\POST(
     *     path="/admin/general-setting/signup-forms/setup",
     *     tags={"Admin/General-Setting"},
     *      summary="تنظیمات فرم های ثبت نامی",
     *      description="",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/SignupFormsSetupBody")
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
    public function signupFormsSetup(Request $request)
    {
        $requests = $request->all();
        SignupFormSetting::query()
            ->update([
                'field_value' => 'disable',
                'status' => 'disable',
            ]);
        foreach ($requests ?? [] as $key => $value)
        {
            $model = SignupFormSetting::query()
                ->where('field_key', $key)
                ->first();
            if($model)
            {
                $model->field_value = 'enable';
                $model->status = 'enable';
                $model->save();
            }
            else
            {
                SignupFormSetting::query()
                    ->create([
                        'field_key' => $key,
                        'field_value' => 'enable',
                        'status' => 'enable',
                    ]);
            }
        }


        return response()
            ->json(null,204);

    }


    /**
     * @OA\GET(
     *     path="/admin/general-setting/signup-forms/index",
     *     tags={"Admin/General-Setting"},
     *      summary="تنظیمات فرم های ثبت نامی",
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


    /**
     * @OA\POST(
     *     path="/admin/general-setting/company-info/setup",
     *     tags={"Admin/General-Setting"},
     *      summary="اطلاعات ضرروی کمپانی",
     *      description="",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/CompanyInfoSetupBody")
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
    public function companyInfoSetup(Request $request)
    {

        $requests = $request->all();
        foreach ($requests ?? [] as $key => $value)
        {
            CompanyInfoSetting::query()
                ->updateOrCreate([
                    'field_key' => $key,
                ],[
                    'field_value' => $value ?? "-",
                    'status' => 'enable',
                ]);
        }

        return response()
            ->json(null,204);
    }

    /**
     * @OA\GET(
     *     path="/admin/general-setting/company-info/index",
     *     tags={"Admin/General-Setting"},
     *      summary="اطلاعات ضرروی کمپانی",
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

    public function companyInfoIndex(Request $request)
    {
        $items = CompanyInfoSetting::query()->get();
        $newItems = [];
        foreach ($items as $item)
        {
            $newItems[$item['field_key']] = $item['field_value'];
        }
        return response()
            ->json($newItems);
    }
}
