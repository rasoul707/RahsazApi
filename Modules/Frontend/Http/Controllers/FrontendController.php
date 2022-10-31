<?php

namespace Modules\Frontend\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Blog\Entities\BlogPost;
use Modules\Blog\Entities\Builder\BlogPostBuilder;
use Modules\Category\Entities\CategoryItem;
use Modules\Category\Entities\CategoryItemProduct;
use Modules\MegaMenu\Entities\MapMegaMenu;
use Modules\MegaMenu\Entities\MegaMenu;
use Modules\Product\Entities\Builder\ProductBuilder;
use Modules\Product\Entities\Product;
use Modules\WebsiteSetting\Entities\CompanyInfoSetting;
use Illuminate\Support\Facades\Log;

class FrontendController extends Controller
{
    /**
     * @OA\GET (
     *     path="/frontend/homepage/",
     *     tags={"Frontend"},
     *     summary="Frontend",
     *     description="",
     *     @OA\Response(response=200, description="Successful", @OA\JsonContent()),
     *     @OA\Response(response=204, description="Successful"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Not Found"),
     *     @OA\Response(response=401, description="Unauthenticated", @OA\JsonContent()),
     * )
     */
    public function homepage()
    {
        $aparatLinks = Product::query()
            ->where('aparat_link', '!=', null)
            ->withAvg('ratings', 'rate')
            ->with([
                'otherNames',
                'coverImage',
            ])
            ->orderByDesc('id')
            ->take(10)
            ->get()->each->append([
                'categories'
            ]);

        $builder = (new BlogPostBuilder())
            ->with(['writer', 'tags'])
            ->status(BlogPost::STATUS['published'])
            ->offset(0)
            ->pageCount(10);

        return response()
            ->json([
                'aparat_links' => $aparatLinks,
                'blog_posts' => $builder->getWithPageCount(),
            ]);
    }

    /**
     * @OA\GET (
     *     path="/frontend/about-us/",
     *     tags={"Frontend"},
     *     summary="Frontend",
     *     description="",
     *     @OA\Response(response=200, description="Successful", @OA\JsonContent()),
     *     @OA\Response(response=204, description="Successful"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Not Found"),
     *     @OA\Response(response=401, description="Unauthenticated", @OA\JsonContent()),
     * )
     */
    public function aboutUs()
    {
        return response()
           ->json(CompanyInfoSetting::query()->get());
    }


    /**
     * @OA\GET (
     *     path="/frontend/mega-menu/",
     *     tags={"Frontend"},
     *     summary="Frontend",
     *     description="",
     *     @OA\Response(response=200, description="Successful", @OA\JsonContent()),
     *     @OA\Response(response=204, description="Successful"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Not Found"),
     *     @OA\Response(response=401, description="Unauthenticated", @OA\JsonContent()),
     * )
     */
    public function megaMenu()
    {
        $megaMenus = MegaMenu::query()
            ->select(['id', 'parent_id', 'name','icon'])
            ->where('parent_id', null)
            // ->with(['ch' => function($query){
            //     $query->where('location', 'West');
            // }, 'provinces.cities.municipalities' => function ($query){
            //     $query->where('population', '>', 9000);
            // }])->find($country_id);
            ->with(['children'])
            ->orderBy('order')
            ->get();

        // foreach($megaMenus as $megaMenu){
        //     $children = MegaMenu::query()
        //     ->select(['id', 'parent_id', 'name'])
        //     ->where('parent_id',$megaMenu->id )
        //     // ->with(['ch' => function($query){
        //     //     $query->where('location', 'West');
        //     // }, 'provinces.cities.municipalities' => function ($query){
        //     //     $query->where('population', '>', 9000);
        //     // }])->find($country_id);
        //     // ->with(['children'])
        //     ->get();

        //     error_log(print_r($children,true));
        //     $megaMenu->children2 = $children;

        // }

        return response()
            ->json($megaMenus);
    }


    /**
     * @OA\GET (
     *     path="/frontend/map-mega-menu/",
     *     tags={"Frontend"},
     *     summary="Frontend",
     *     description="",
     *     @OA\Response(response=200, description="Successful", @OA\JsonContent()),
     *     @OA\Response(response=204, description="Successful"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Not Found"),
     *     @OA\Response(response=401, description="Unauthenticated", @OA\JsonContent()),
     * )
     */
    public function mapMegaMenu()
    {
        $mapMegaMenus = MapMegaMenu::query()
            ->select(['id', 'parent_id', 'name','icon'])
            ->where('parent_id', null)
            ->with(['children'])
            ->orderBy('order')
            ->get();

        // foreach($mapMegaMenus as $mapMegaMenu){
        //     foreach($mapMegaMenu->children as $child){

        //     $children = MapMegaMenu::query()
        //     ->select(['id', 'parent_id', 'name'])
        //     ->where('parent_id',$child->id )
        //     // ->with(['ch' => function($query){
        //     //     $query->where('location', 'West');
        //     // }, 'provinces.cities.municipalities' => function ($query){
        //     //     $query->where('population', '>', 9000);
        //     // }])->find($country_id);
        //     // ->with(['children'])
        //     ->get();

        //     error_log(print_r($children,true));
        //     $child->children2 = $children;
        //     }
        // }

        return response()
            ->json($mapMegaMenus);
    }


    /**
     * @OA\GET (
     *     path="/frontend/map/",
     *     tags={"Frontend"},
     *     summary="Frontend",
     *     description="",
     *     @OA\Parameter(
     *         name="mega_menu_id",
     *         in="query",
     *         example="1",
     *         description="mega_menu_id",
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
    public function map(Request $request)
    {
        $mapMegaMenu = MapMegaMenu::query()
            ->where('id', $request->mega_menu_id)
            ->firstOrFail();
        $name = $mapMegaMenu->name;
            
        $level2Ids = CategoryItem::query()
            ->with(['products', 'image'])
            ->whereIn('category_id', [12,8])
            ->where('name', 'like', '%'. $name . '%')
            ->get()->pluck('id');
            
        // error_log(print_r($level2Ids,true));
        // $level3Ids = CategoryItem::query()
        // ->with(['products', 'image'])
        // ->whereIn('category_id', [12])
        // ->where('name', 'like', '%'. $name . '%')
        // ->get()->pluck('id');

        if (empty($level2Ids)) {
            return response()
                ->json([
                    'total_count' => 0,
                    'map' => null,
                    'items' => []
                ]);
        }
        // $levelIds = $level2Ids;
        // if(empty($level2Ids))
        // {
        //     $levelIds = $level3Ids;
        // }


        $map = CategoryItem::query()
            ->with(['image'])
            ->whereIn('parent_category_item_id', $level2Ids)
            ->first();

        if (empty($map)) {
            return response()
                ->json([
                    'total_count' => 0,
                    'map' => null,
                    'items' => []
                ]);
        }


        $cip = CategoryItemProduct::query()
            ->whereIn('category_item_id', [$map->id])
            ->get();
        if (empty($cip) or count($cip)==0) {
            return response()
                ->json([
                    'total_count' => 0,
                    'map' => null,
                    'items' => []
                ]);
        }

        foreach ($cip as $c) {
            $product = Product::query()
            ->where('id', $c->product_id)
            ->with(['coverImage'])
            ->first();
            $product['map_info'] = $c;
            // error_log(print_r($product,true));
            if ($product) {
                $products[] = $product;
            }
        }

        
        return response()
                ->json([
                    'total_count' => count($products),
                    'map' => $map,
                    'items' => $products
                ]);
    }
}
