<?php

namespace Modules\User\Http\Controllers\Customer;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Comment\Entities\Builder\CommentBuilder;
use Modules\Comment\Entities\Comment;
use Modules\Product\Entities\Product;

class CommentController extends Controller
{
    /**
     * @OA\GET (
     *     path="/customer/comments/index",
     *     tags={"Customer/Comments"},
     *     summary="مشتری - مدیریت نظرات",
     *     description="",
     *     @OA\Response(response=200, description="Successful", @OA\JsonContent()),
     *     @OA\Response(response=204, description="Successful"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Not Found"),
     *     @OA\Response(response=401, description="Unauthenticated", @OA\JsonContent()),
     *     security={
     *         {
     *             "bearerAuth": {}
     *         }
     *     },
     * )
     */
    public function index()
    {
        $builder = (new CommentBuilder())
            ->with(['commentable', 'children'])
            ->order('id', 'desc')
            ->userId(auth()->user()->id)
            ->types([Comment::TYPE['comment'], Comment::TYPE['question_and_answer']])
            ->commentableType(Product::class);

        return response()
            ->json($builder->getAll());
    }
}
