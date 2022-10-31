<?php

namespace Modules\Product\Http\Controllers;

use App\Http\Resources\CategoryItemLabelSearchResource;
use App\Http\Resources\CategoryItemLabelSearchResourceForCustomer;
use App\Models\ProductAlert;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Category\Entities\CategoryItem;
use Modules\Comment\Entities\Comment;
use Modules\Product\Entities\Builder\ProductBuilder;
use Modules\Product\Entities\Product;
use Modules\User\Entities\UserProductVisit;
use Modules\User\Http\Controllers\Customer\ProductVisitController;

class ProductController extends Controller
{
    /**
     * @OA\GET(
     *     path="/products/index",
     *     tags={"Products"},
     *      summary="مدیریت محصولات",
     *      description="",
     *     @OA\Parameter(
     *         name="offset",
     *         in="query",
     *         description="offset",
     *         required=true,
     *         explode=true
     *     ),
     *     @OA\Parameter(
     *         name="category_level_1_id",
     *         in="query",
     *         description="category_level_1_id",
     *         required=false,
     *         explode=true
     *     ),
     *     @OA\Parameter(
     *         name="category_level_2_id",
     *         in="query",
     *         description="category_level_2_id",
     *         required=false,
     *         explode=true
     *     ),
     *     @OA\Parameter(
     *         name="category_level_3_id",
     *         in="query",
     *         description="category_level_3_id",
     *         required=false,
     *         explode=true
     *     ),
     *     @OA\Parameter(
     *         name="category_level_4_id",
     *         in="query",
     *         description="category_level_4_id",
     *         required=false,
     *         explode=true
     *     ),
     *     @OA\Parameter(
     *         name="mega_menu_id",
     *         in="query",
     *         description="mega_menu_id",
     *         required=false,
     *         explode=true
     *     ),
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="search",
     *         required=false,
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

    public function index(Request $request)
    {
        $request->validate([
            'offset' => ['required'],
        ]);

        $builder = (new ProductBuilder())
            ->withAvg('ratings', 'rate')
            ->with([
                'otherNames',
                'tags'
            ])
            ->filterByCategoryLevel(1, $request->category_level_1_id)
            ->filterByCategoryLevel(2, $request->category_level_2_id)
            ->filterByCategoryLevel(3, $request->category_level_3_id)
            ->filterByCategoryLevel(4, $request->category_level_4_id)
            ->filterByMegaMenuId($request->mega_menu_id)
            ->customSearch($request->search, ['products.name'])
            ->order($request->order_by ?? 'products.id', $request->order_type ?? 'desc')
            ->offset($request->offset)
            ->pageCount(24);

        return response()
            ->json([
                'page_count' => 24,
                'total_count' => $builder->count(),
                'items' => $builder->getWithPageCount()->each->append('categories'),
            ]);
    }
    /**
     * @OA\GET(
     *     path="/products/categories",
     *     tags={"Products"},
     *      summary="مدیریت محصولات",
     *      description="",
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="parent_category_item_id",
     *         required=false,
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
    public function showCategories(Request $request)
    {
        if ($request->id == 'null') {
            $request->id = null;
        }
        $result = CategoryItemLabelSearchResourceForCustomer::collection(CategoryItem::query()
            ->whereIn('category_id', [1,2,3,4,5])
            ->where('parent_category_item_id', $request->id)
            ->get());
        return response()
            ->json($result);
    }

    /**
     * @OA\GET(
     *     path="/products/show/{id}",
     *     tags={"Products"},
     *      summary="https://www.figma.com/file/aF7WOO69kvBDrsd7uGQ0fm/Untitled?node-id=7%3A3513",
     *      description="https://www.figma.com/file/aF7WOO69kvBDrsd7uGQ0fm/Untitled?node-id=7%3A3513",
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
        $product = Product::query()
            ->withAvg('ratings', 'rate')
            ->with([
                'otherNames',
                'tags',
                'coverImage',
                'galleryImages',
                'similarProducts',
                'productAttributes',
                'comments.children',
                'qas.children'
            ])->findOrFail($id)->append([
                'categories'
            ]);

        $product->view = $product->view + 1;
        $product->save();

        if (Auth::guard('api')->check()) {
            $userId = Auth::guard('api')->user()->id;
            UserProductVisit::query()
                ->create([
                    'user_id' => $userId,
                    'product_id' => $product->id,
                ]);
        }

        $product['purchase_price'] = $product->calculatePurchasePrice();
        $product['user_type'] =$product->calculatePurchasePrice();
        // dd(json_encode($product));

        return response()
            ->json($product);
    }

    /**
     * @OA\POST(
     *     path="/products/send-review/{id}",
     *     tags={"Products"},
     *      summary="https://www.figma.com/file/aF7WOO69kvBDrsd7uGQ0fm/Untitled?node-id=7%3A3513",
     *      description="https://www.figma.com/file/aF7WOO69kvBDrsd7uGQ0fm/Untitled?node-id=7%3A3513",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="id",
     *         required=true,
     *         explode=true
     *     ),
     *     @OA\Parameter(
     *         name="parent_comment_id",
     *         in="query",
     *         description="parent_comment_id",
     *         required=false,
     *         explode=true
     *     ),
     *     @OA\Parameter(
     *         name="comment_content",
     *         in="query",
     *         description="comment_content",
     *         required=true,
     *         explode=true
     *     ),
     *     @OA\Parameter(
     *         name="type",
     *         in="query",
     *         description="comment or question_and_answer",
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
    public function sendReview(Request $request, $id)
    {
        $request->validate([
            'parent_comment_id' => ['nullable'],
            'comment_content' => ['required'],
            'type' => ['required'],
        ]);

        Comment::query()
            ->create([
                'user_id' => Auth::guard('api')->user()->id,
                'parent_comment_id' => $request->parent_comment_id ?? null,
                'content' => $request->comment_content,
                'commentable_id' => $id,
                'commentable_type' => Product::class,
                'status' => Comment::STATUS['waiting_for_response'],
                'type' => $request->type
            ]);

        return response()
            ->json(null, 204);
    }



    /**
     * @OA\POST(
     *     path="/products/alert/{id}",
     *     tags={"Products"},
     *      summary="",
     *      description="",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="product id",
     *         required=true,
     *         explode=true
     *     ),
     *     @OA\Parameter(
     *         name="via_phone",
     *         in="query",
     *         description="",
     *         required=true,
     *         explode=true
     *     ),
     *     @OA\Parameter(
     *         name="via_email",
     *         in="query",
     *         description="",
     *         required=true,
     *         explode=true
     *     ),
     *     @OA\Parameter(
     *         name="via_notification",
     *         in="query",
     *         description="",
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
    public function alert(Request $request, $id)
    {
        $exists = ProductAlert::query()
            ->where('user_id', \auth()->user()->id)
            ->where('product_id', $id)
            ->first();

        if ($exists) {
            $exists->via_phone = $request->via_phone ?? 0;
            $exists->via_email = $request->via_email ?? 0;
            $exists->via_notification = $request->via_notification ?? 0;
            $exists->save();
        } else {
            ProductAlert::query()
                ->create([
                    'user_id' => \auth()->user()->id,
                    'product_id' => $id,
                    'via_phone' => $request->via_phone ?? 0,
                    'via_email' => $request->via_email ?? 0,
                    'via_notification' => $request->via_notification ?? 0,
                ]);
        }

        return response()
            ->json(null, 204);
    }
}
