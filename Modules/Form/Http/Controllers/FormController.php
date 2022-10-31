<?php

namespace Modules\Form\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Form\Entities\Form;
use Modules\Form\Http\Requests\StoreFormRequest;

class FormController extends Controller
{
    /**
     * @OA\POST(
     *     path="/forms/store",
     *     tags={"Forms"},
     *     summary="فرم ها تماس با ما و ...",
     *     description="",
     *     @OA\Parameter(
     *         name="user_id",
     *         in="query",
     *         example="1",
     *         description="user_id",
     *         required=false,
     *         explode=true
     *     ),
     *     @OA\Parameter(
     *         name="form_type",
     *         in="query",
     *         example="تماس با ما",
     *         description="تماس با ما | درخواست همکاری و نمایندگی | انتقادات، پیشنهادات و شکایات",
     *         required=false,
     *         explode=true
     *     ),
     *     @OA\Parameter(
     *         name="request_type",
     *         in="query",
     *         example="شکایت",
     *         description="شکایت",
     *         required=false,
     *         explode=true
     *     ),
     *     @OA\Parameter(
     *         name="section_type",
     *         in="query",
     *         example="واحد انبار",
     *         description="واحد انبار",
     *         required=false,
     *         explode=true
     *     ),
     *     @OA\Parameter(
     *         name="full_name",
     *         in="query",
     *         example="علی علوی",
     *         description="نام کامل",
     *         required=false,
     *         explode=true
     *     ),
     *     @OA\Parameter(
     *         name="phone_number",
     *         in="query",
     *         example="09129991222",
     *         description="phone_number",
     *         required=false,
     *         explode=true
     *     ),
     *     @OA\Parameter(
     *         name="email",
     *         in="query",
     *         example="test@mail.com",
     *         description="email",
     *         required=false,
     *         explode=true
     *     ),
     *     @OA\Parameter(
     *         name="description",
     *         in="query",
     *         example="description",
     *         description="description",
     *         required=false,
     *         explode=true
     *     ),
     *     @OA\Response(response=200, description="Successful", @OA\JsonContent()),
     *     @OA\Response(response=204, description="Successful"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Not Found"),
     *     @OA\Response(response=401, description="Unauthenticated", @OA\JsonContent()),
     * )
     */
    public function store(StoreFormRequest $request)
    {
        Form::query()->create($request->validated());
        return response()->json(null, 204);
    }
}
