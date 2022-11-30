<?php

namespace Modules\Comment\Http\Controllers\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Comment\Entities\Builder\CommentBuilder;
use Modules\Comment\Entities\Comment;

class CommentController extends Controller
{

    /**
     * @OA\GET(
     *     path="/admin/comments/index",
     *     tags={"Admin/Comments"},
     *     summary="Admin - Comments",
     *     description="",
     *     @OA\Parameter(
     *         name="offset",
     *         in="query",
     *         description="offset",
     *         required=true,
     *         explode=true
     *     ),
     *     @OA\Parameter(
     *         name="type",
     *         in="query",
     *         description="type",
     *         required=true,
     *         explode=true
     *     ),
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
    public function index(Request $request)
    {
        $request->validate([
            'offset' => ['required'],
            'type' => ['required']
        ]);

        $builder = (new CommentBuilder())
            ->with([
                'user',
                'commentable',
            ])
            ->type($request->type)
            ->search($request->search, ['content'])
            ->offset($request->offset)
            ->pageCount($request->page_size);

        return response()
            ->json([
                'page_count' => $request->page_size,
                'total_count' => $builder->count(),
                'items' => $builder->getWithPageCount(),
            ]);
    }


    /**
     * @OA\GET(
     *     path="/admin/comments/show/{id}",
     *     tags={"Admin/Comments"},
     *     summary="Admin - Comments",
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
     *     security={
     *         {
     *             "bearerAuth": {}
     *         }
     *     },
     * )
     */

    public function show($id)
    {
        $comment = Comment::query()
            ->with([
                'user',
                'children',
            ])
            ->findOrFail($id);


        return response()
            ->json($comment);
    }


    /**
     * @OA\DELETE(
     *     path="/admin/comments/destroy/{id}",
     *     tags={"Admin/Comments"},
     *     summary="Admin - Comments",
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
     *     security={
     *         {
     *             "bearerAuth": {}
     *         }
     *     },
     * )
     */

    public function destroy($id)
    {
        $comment = Comment::query()
            ->findOrFail($id);

        $comment->children()->delete();
        $comment->delete();

        return response()
            ->json(null, 204);
    }


    /**
     * @OA\PUT(
     *     path="/admin/comments/toggle-active/{id}",
     *     tags={"Admin/Comments"},
     *     summary="Admin - Comments",
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
     *     security={
     *         {
     *             "bearerAuth": {}
     *         }
     *     },
     * )
     */

    public function toggleActive($id)
    {
        $comment = Comment::query()
            ->findOrFail($id);

        $comment->toggleActive();

        return response()
            ->json(null, 204);
    }


    /**
     * @OA\POST(
     *     path="/admin/comments/response/{id}",
     *     tags={"Admin/Comments"},
     *     summary="Admin - Comments",
     *     description="",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="id",
     *         required=true,
     *         explode=true
     *     ),
     *     @OA\Parameter(
     *         name="response",
     *         in="query",
     *         description="response",
     *         required=true,
     *         explode=true
     *     ),
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

    public function response(Request $request, $id)
    {
        $request->validate([
            'response' => ['required'],
        ]);

        $comment = Comment::query()
            ->findOrFail($id);

        $comment->response($request->response);

        return response()
            ->json(null, 204);
    }
}
