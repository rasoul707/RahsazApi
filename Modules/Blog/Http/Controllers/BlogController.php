<?php

namespace Modules\Blog\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Blog\Entities\BlogPost;
use Modules\Blog\Entities\Builder\BlogPostBuilder;

class BlogController extends Controller
{

    /**
     * @OA\GET(
     *     path="/blog/index",
     *     tags={"Blog"},
     *     summary="Blog",
     *     description="",
     *     @OA\Parameter(
     *         name="offset",
     *         in="query",
     *         description="offset",
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
        ]);

        $builder = (new BlogPostBuilder())
            ->with(['writer', 'tags'])
            ->status(BlogPost::STATUS['published'])
            ->search($request->search, ['title', 'description'])
            ->offset($request->offset)
            ->pageCount(25);

        return response()
            ->json([
                'page_count' => 25,
                'total_count' => $builder->count(),
                'items' => $builder->getWithPageCount(),
            ]);
    }

    /**
     * @OA\GET(
     *     path="/blog/show/{id}",
     *     tags={"Blog"},
     *     summary="Blog",
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
        $blogPost = BlogPost::query()
            ->with(['writer', 'tags'])
            ->findOrFail($id);
        return response()
            ->json($blogPost);
    }
}
