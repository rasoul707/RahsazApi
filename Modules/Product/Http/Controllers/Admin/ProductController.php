<?php

namespace Modules\Product\Http\Controllers\Admin;

use App\Http\Resources\CategoryItemLabelSearchResource;
use App\Http\Resources\ProductFullDataLabelSearchResource;
use App\Http\Resources\ProductLabelSearchResource;
use App\Http\Resources\SubCategoryWithParentLabelSearchResource;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Category\Entities\CategoryItem;
use Modules\Product\Entities\Builder\ProductBuilder;
use Modules\Product\Entities\Product;
use Modules\Product\Http\Requests\StoreProductRequest;

class ProductController extends Controller
{
    public function store(StoreProductRequest $request)
    {
        DB::transaction(function () use ($request) {
            $product = new Product();
            Product::updateOrCreateProduct($product, $request);
        });
        return response()
            ->json(null, 204);
    }

    public function update(StoreProductRequest $request, $id)
    {
        DB::transaction(function () use ($request, $id) {
            $product = Product::findOrFail($id);
            Product::updateOrCreateProduct($product, $request);
        });
        return response()
            ->json(null, 204);
    }

    public function index(Request $request)
    {
        $request->validate([
            'offset' => ['required'],
            'page_size' => ['required'],
        ]);
        $builder = (new ProductBuilder())
            ->with([
                'otherNames',
                'tags',
            ])
            ->search($request->search, ['name'])
            ->order($request->order_by ?? 'id', $request->order_type ?? 'desc')
            ->offset($request->offset)
            ->pageCount($request->page_size);
        return response()
            ->json([
                'page_count' => $request->page_size,
                'total_count' => $builder->count(),
                'items' => $builder->getWithPageCount()->each->append('categories'),
            ]);
    }

    public function show($id)
    {
        $product = Product::query()
            ->with([
                'otherNames',
                'tags',
                'coverImage',
                'galleryImages',
                'videos',
                'similarProducts',
                'productAttributes',
            ]);
        return response()
            ->json($product->findOrFail($id)->append([
                'categories',
            ]));
    }

    public function destroy($id)
    {
        Product::query()->findMany(explode(",", $id))->delete();
        return response()->json(null, 204);
    }

    public function labelSearch(Request $request)
    {
        $request->validate([
            'search' => ['required'],
        ]);
        $builder = (new ProductBuilder())
            ->search($request->search, ['name'])
            ->order($request->order_by ?? 'id', $request->order_type ?? 'desc')
            ->offset($request->offset)
            ->pageCount(25)
            ->getWithPageCount();
        if ($request->full_data) {
            return response()
                ->json(ProductFullDataLabelSearchResource::collection($builder));
        }

        return response()
            ->json(ProductLabelSearchResource::collection($builder));
    }

    public function showCategories(Request $request)
    {
        if ($request->id == 'null') {
            $request->id = null;
        }

        $result = CategoryItemLabelSearchResource::collection(CategoryItem::query()
            ->whereIn('category_id', [1, 2, 3, 4, 5])
            ->where('parent_category_item_id', $request->id)
            ->get());
        return response()
            ->json($result);
    }

    public function subCategoryLabelSearch(Request $request)
    {
        $result = CategoryItem::query()
            ->with(['parent'])
            ->whereIn('category_id', [5])
            ->where('parent_category_item_id', '!=', null);
        if (!empty($request->search)) {
            $result->where('name', 'like', '%' . $request->search . '%');
        }

        $items = SubCategoryWithParentLabelSearchResource::collection($result->get());
        return response()
            ->json($items);
    }
}
