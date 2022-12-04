<?php

namespace Modules\Category\Http\Controllers\Admin;

use App\Http\Resources\CategoryItemIndexResource;
use App\Http\Resources\CategoryItemLabelSearchResource;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Category\Entities\Builder\CategoryBuilder;
use Modules\Category\Entities\Builder\CategoryItemBuilder;
use Modules\Category\Entities\Category;
use Modules\Category\Entities\CategoryItem;
use Modules\Category\Entities\CategoryItemProduct;
use Modules\MegaMenu\Entities\MapMegaMenu;
use Modules\MegaMenu\Entities\MegaMenu;
use Modules\Product\Entities\Product;
use Modules\Product\Entities\ProductCategory;

class CategoryController extends Controller
{
    /**
     * @OA\GET(
     *     path="/admin/categories/fathers-index",
     *     tags={"Admin/Categories"},
     *      summary="مدیریت دسته بندی ها",
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
    public function fathersIndex()
    {
        $categories = (new CategoryBuilder())
            ->type(Category::TYPES['father'])
            ->with([
                'children',
            ])
            ->get()->each->append(['brother']);
        return response()
            ->json($categories);
    }
    /**
     * @OA\GET(
     *     path="/admin/categories/child/{id}/items",
     *     tags={"Admin/Categories"},
     *      summary="مدیریت دسته بندی ها",
     *      description="",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="id",
     *         required=true,
     *         explode=true
     *     ),
     *     @OA\Parameter(
     *         name="offset",
     *         in="query",
     *         description="offset",
     *         required=true,
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
    public function childItems(Request $request, $id)
    {
        $category = Category::query()
            ->where('type', Category::TYPES['child'])
            ->findOrFail($id);
        $categoryItems = (new CategoryItemBuilder())
            ->with(['parent', 'image'])
            ->categoryId($category->id)
            ->search($request->search, ['name'])
            ->order('order', 'asc')
            ->offset($request->offset ?? 0)
            ->pageCount($request->page_size);
        return response()
            ->json([
                'page_count' => $request->page_size,
                'total_count' => $categoryItems->count(),
                'items' => CategoryItemIndexResource::collection($categoryItems->getWithPageCount())
                //'items' => $categoryItems->getWithPageCount()
            ]);
    }
    /**
     * @OA\GET(
     *     path="/admin/categories/{id}/children-names",
     *     tags={"Admin/Categories"},
     *      summary="مدیریت دسته بندی ها",
     *      description="",
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
    public function childrenNames($id)
    {
        $children = Category::query()
            ->where('parent_category_id', $id)
            ->where('type', Category::TYPES['child'])
            ->get(['id', 'name']);
        return response()
            ->json($children);
    }
    /**
     * @OA\PUT(
     *     path="/admin/categories/rename-children",
     *     tags={"Admin/Categories"},
     *      summary="مدیریت دسته بندی ها",
     *      description="",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/RenameChildren")
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
    public function renameChildren(Request $request)
    {
        foreach ($request->children ?? [] as $child) {
            Category::query()
                ->findOrFail($child['id'])
                ->update([
                    'name' => $child['name']
                ]);
        }
        return response()
            ->json(null, 204);
    }
    /**
     * @OA\POST(
     *     path="/admin/categories/store-item",
     *     tags={"Admin/Categories"},
     *      summary="مدیریت دسته بندی ها",
     *      description="",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreItem")
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
    public function storeItem(Request $request)
    {
        $order = 1;
        $lastCategoryItem = CategoryItem::query()
            ->where('category_id', $request->category_id)
            ->orderBy('order', 'desc')
            ->first();
        if ($lastCategoryItem) {
            $order = $lastCategoryItem->order + 1;
        }
        $categoryItem = CategoryItem::query()
            ->create([
                'parent_category_item_id' => $request->parent_category_item_id,
                'category_id' => $request->category_id,
                'name' => $request->name,
                'description' => $request->description,
                'icon' => $request->icon,
                'order' => $order
            ]);
        MegaMenu::make();
        MapMegaMenu::make();
        return response()
            ->json(null, 204);
    }
    /**
     * @OA\PUT(
     *     path="/admin/categories/update-item/{id}",
     *     tags={"Admin/Categories"},
     *      summary="مدیریت دسته بندی ها",
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
     *         @OA\JsonContent(ref="#/components/schemas/StoreItem")
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
    public function updateItem(Request $request, $id)
    {
        $categoryItem = CategoryItem::query()
            ->where('id', $id)
            ->firstOrFail();
        $categoryItem->name = $request->name;
        $categoryItem->description = $request->description;
        $categoryItem->icon_image_id = $request->icon_image_id;
        $categoryItem->order = $request->order;
        $categoryItem->icon = $request->icon;
        $categoryItem->parent_category_item_id = $request->parent_category_item_id;
        $categoryItem->save();
        return response()
            ->json(null, 204);
    }


    public function updateOrders(Request $request)
    {
        foreach ($request->items as $order_item) {
            $id = $order_item['id'];
            $order = $order_item['order'];
            $categoryItem = CategoryItem::query()->find($id);
            $categoryItem->order = $order;
            $categoryItem->save();
        }
        return response()->json(null, 204);
    }

    public function updateMenu()
    {
        MegaMenu::make();
        MapMegaMenu::make();
        return response()
            ->json(null, 204);
    }


    /**
     * @OA\GET(
     *     path="/admin/categories/show-item/{id}",
     *     tags={"Admin/Categories"},
     *      summary="مدیریت دسته بندی ها",
     *      description="",
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
    public function showItem($id)
    {
        $categoryItem = CategoryItem::query()
            ->with(['category', 'parent'])
            ->where('id', $id)
            ->firstOrFail();
        return response()
            ->json($categoryItem, 200);
    }
    /**
     * @OA\DELETE(
     *     path="/admin/categories/destroy-item/{id}",
     *     tags={"Admin/Categories"},
     *      summary="مدیریت دسته بندی ها",
     *      description="",
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
    public function destroyItem($id)
    {
        $ids = explode(",", $id);
        CategoryItem::query()->whereIn('parent_category_item_id', $ids)->delete();
        CategoryItem::query()->findMany($ids)->each->delete();

        ProductCategory::query()
            ->whereIn('category_level_1_id', $ids)
            ->orWhereIn('category_level_2_id', $ids)
            ->orWhereIn('category_level_3_id', $ids)
            ->orWhereIn('category_level_4_id', $ids)
            ->delete();


        MegaMenu::make();
        MapMegaMenu::make();
        return response()->json(null, 204);
    }
    /**
     * @OA\PUT(
     *     path="/admin/categories/reorder-items",
     *     tags={"Admin/Categories"},
     *      summary="مدیریت دسته بندی ها",
     *      description="",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/ReorderItems")
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
    public function reorderItems(Request $request)
    {
        foreach ($request->items ?? [] as $item) {
            CategoryItem::query()
                ->findOrFail($item['id'])
                ->update([
                    'order' => $item['order']
                ]);
        }
        return response()
            ->json(null, 204);
    }
    /**
     * @OA\GET(
     *     path="/admin/categories/item/{id}/products",
     *     tags={"Admin/Categories"},
     *      summary="مدیریت دسته بندی ها",
     *      description="",
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
    public function itemProducts($id)
    {
        $categoryItem = CategoryItem::query()
            ->where('id', $id)
            ->with(['products', 'image'])
            ->get();
        return response()
            ->json($categoryItem);
    }
    /**
     * @OA\POST(
     *     path="/admin/categories/item/{id}/store-product",
     *     tags={"Admin/Categories"},
     *      summary="مدیریت دسته بندی ها",
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
     *         @OA\JsonContent(ref="#/components/schemas/StoreItemProduct")
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
    public function storeItemProduct(Request $request, $id)
    {
        $request->validate([
            'product_id' => ['required'],
            'product_number_in_map' => ['required'],
        ]);
        CategoryItem::query()
            ->findOrFail($id);
        CategoryItemProduct::query()
            ->create([
                'category_item_id' => $id,
                'product_id' => $request->product_id,
                'product_number_in_map' => $request->product_number_in_map,
            ]);
        return response()
            ->json(null, 204);
    }
    /**
     * @OA\POST(
     *     path="/admin/categories/item/{id}/store-image",
     *     tags={"Admin/Categories"},
     *      summary="مدیریت دسته بندی ها",
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
     *         @OA\JsonContent(ref="#/components/schemas/StoreItemImage")
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
    public function storeItemImage(Request $request, $id)
    {
        $request->validate([
            'image_id' => ['required'],
        ]);
        $categoryItem = CategoryItem::query()
            ->findOrFail($id);
        $categoryItem->image_id = $request->image_id;
        $categoryItem->save();
        return response()
            ->json(null, 204);
    }
    /**
     * @OA\POST(
     *     path="/admin/categories/item/{id}/destroy-product",
     *     tags={"Admin/Categories"},
     *      summary="مدیریت دسته بندی ها",
     *      description="",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="id",
     *         required=true,
     *         explode=true
     *     ),
     *     @OA\Parameter(
     *         name="product_id",
     *         in="query",
     *         description="product_id",
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
    public function destroyItemProduct(Request $request, $id)
    {
        CategoryItemProduct::query()
            ->where('category_item_id', $id)
            ->where('product_id', $request->product_id)
            ->delete();
        return response()
            ->json(null, 204);
    }
    /**
     * @OA\GET(
     *     path="/admin/categories/{id}/label-search",
     *     tags={"Admin/Categories"},
     *      summary="مدیریت دسته بندی ها",
     *      description="",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="id",
     *         required=true,
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
    public function labelSearch(Request $request, $id)
    {
        $request->validate([
            'search' => ['nullable'],
        ]);
        $category = Category::query()
            ->where('type', Category::TYPES['child'])
            ->findOrFail($id);
        $fakeId = $id;
        if ($id == 12) {
            $fakeId = array(8, 12);
        }
        $categoryItems = (new CategoryItemBuilder())
            ->with(['parent'])
            ->categoryId($fakeId)
            ->search($request->search, ['name'])
            ->getAll();
        return response()
            ->json(CategoryItemLabelSearchResource::collection($categoryItems));
    }
}
