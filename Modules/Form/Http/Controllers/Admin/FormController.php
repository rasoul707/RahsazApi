<?php

namespace Modules\Form\Http\Controllers\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Form\Entities\Builder\FormBuilder;
use Modules\Form\Entities\Form;

class FormController extends Controller
{
    /**
     * @OA\GET(
     *     path="/admin/forms/index",
     *     tags={"Admin/Forms"},
     *     summary="فرم ها تماس با ما و ...",
     *     description="",
     *     @OA\Parameter(
     *         name="offset",
     *         in="query",
     *         example="0",
     *         description="offset",
     *         required=false,
     *         explode=true
     *     ),
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         example="",
     *         description="search",
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
    public function index(Request $request)
    {
        $builder = (new FormBuilder())
            ->order($request->order_by ?? 'created_at', $request->order_type ?? 'desc')
            ->offset($request->offset ?? 0)
            ->pageCount($request->page_size)
            ->search($request->search, ['form_type', 'request_type', 'section_type', 'full_name', 'phone_number', 'email', 'description']);

        return response()
            ->json([
                'page_count' => $request->page_size,
                'total_count' => $builder->count(),
                'items' => $builder->getWithPageCount(),
            ]);
    }

    /**
     * @OA\GET(
     *     path="/admin/forms/show/{id}",
     *     tags={"Admin/Forms"},
     *     summary="فرم ها تماس با ما و ...",
     *     description="",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         example="1",
     *         description="id",
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
    public function show($id)
    {
        $form = Form::query()->findOrFail($id);

        return response()
            ->json($form);
    }

    /**
     * @OA\DELETE(
     *     path="/admin/forms/destroy/{id}",
     *     tags={"Admin/Forms"},
     *     summary="فرم ها تماس با ما و ...",
     *     description="",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         example="1",
     *         description="id",
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
    public function destroy($id)
    {
        Form::query()->findMany(explode(",", $id))->delete();
        return response()->json(null, 204);
    }
}
