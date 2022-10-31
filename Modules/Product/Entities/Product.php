<?php
namespace Modules\Product\Entities;

use App\Http\Resources\SubCategoryWithParentLabelSearchResource;
use App\Models\TimeHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Modules\Blog\Entities\Tag;
use Modules\Category\Entities\CategoryItem;
use Modules\Comment\Entities\Comment;
use Modules\Library\Entities\Image;
use Modules\User\Entities\User;
use Modules\WebsiteSetting\Entities\Setting;

class Product extends Model
{
    use SoftDeletes;
    protected $table = 'products';
    protected $guarded = [];
    protected $with = ['coverImage'];
    protected $appends = ['purchase_price', 'user_type'];

    public function getCategoriesAttribute()
    {
        $ids = ProductCategory::query()
            ->where('product_id', $this->id)
            ->get()
            ->pluck('category_level_4_id');
        $result = CategoryItem::query()
            ->with(['parent'])
            ->whereIn('id', $ids);
        $items = SubCategoryWithParentLabelSearchResource::collection($result->get());

        return $items;
    }

    public function otherNames()
    {
        return $this->hasMany(ProductOtherName::class);
    }

    public function tags()
    {
        return $this->morphMany(Tag::class, 'taggable');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable')
            ->where('parent_comment_id', '=', null)
            ->where('type', 'comment');
    }

    public function qas()
    {
        return $this->morphMany(Comment::class, 'commentable')
            ->where('parent_comment_id', '=', null)
            ->where('type', 'question_and_answer');
    }

    public function coverImage()
    {
        return $this->hasOne(ProductImage::class)
            ->where('image_type', ProductImage::IMAGE_TYPE['cover'])->with(['image']);
    }

    public function galleryImages()
    {
        return $this->hasMany(ProductImage::class)
            ->where('image_type', ProductImage::IMAGE_TYPE['gallery'])->with(['image']);
    }

    public function videos()
    {
        return $this->hasMany(ProductVideo::class)->with(['video']);
    }

    public function similarProducts()
    {
        return $this->hasMany(SimilarProduct::class, 'target_product_id', 'id')->with(['product']);
    }

    public function productAttributes()
    {
        return $this->hasMany(ProductAttributes::class, 'product_id', 'id');
    }

    public function cats()
    {
        return $this->hasMany(ProductCategory::class, 'product_id', 'id');
    }

    /* methods */
    public function setOtherNames($otherNames)
    {
        ProductOtherName::query()
            ->where('product_id', $this->id)
            ->delete();
        if (!empty($otherNames)) {
            foreach ($otherNames as $otherName) {
                ProductOtherName::query()
                    ->create([
                        'product_id' => $this->id,
                        'name' => $otherName,
                    ]);
            }
        }
    }

    public function setTags($tags)
    {
        Tag::query()
            ->where('taggable_id', $this->id)
            ->where('taggable_type', self::class)
            ->delete();
        if (!empty($tags)) {
            foreach ($tags as $tag) {
                Tag::query()
                    ->create([
                        'taggable_id' => $this->id,
                        'taggable_type' => self::class,
                        'title' => $tag,
                    ]);
            }
        }
    }

    public function setCoverImage($imageId, $imageTitle)
    {
        ProductImage::query()
            ->where('product_id', $this->id)
            ->where('image_type', ProductImage::IMAGE_TYPE['cover'])
            ->delete();
        if (!empty($imageId)) {
            ProductImage::query()
                ->create([
                    'product_id' => $this->id,
                    'image_id' => $imageId,
                    'image_type' => ProductImage::IMAGE_TYPE['cover'],
                ]);
            if (!empty($imageTitle)) {
                Image::where('id', $imageId)
                    ->update([
                        'alt' => $imageTitle,
                    ]);
            }
        }
    }

    public function setGalleryImages($imageIds)
    {
        ProductImage::query()
            ->where('product_id', $this->id)
            ->where('image_type', ProductImage::IMAGE_TYPE['gallery'])
            ->delete();
        if (!empty($imageIds)) {
            foreach ($imageIds as $imageId) {
                ProductImage::query()
                    ->create([
                        'product_id' => $this->id,
                        'image_id' => $imageId,
                        'image_type' => ProductImage::IMAGE_TYPE['gallery'],
                    ]);
            }
        }
    }

    public function setVideos($videoIds)
    {
        ProductVideo::query()
            ->where('product_id', $this->id)
            ->delete();
        if (!empty($videoIds)) {
            foreach ($videoIds as $videoId) {
                ProductVideo::query()
                    ->create([
                        'product_id' => $this->id,
                        'video_id' => $videoId,
                    ]);
            }
        }
    }

    public function setSimilarProducts($productIds)
    {
        SimilarProduct::query()
            ->where('target_product_id', $this->id)
            ->delete();
        if (!empty($productIds)) {
            foreach ($productIds as $productId) {
                SimilarProduct::query()
                    ->create([
                        'target_product_id' => $this->id,
                        'similar_product_id' => $productId,
                    ]);
            }
        }
    }

    public function setProductAttributes($attributes)
    {
        ProductAttributes::query()
            ->where('product_id', $this->id)
            ->delete();
        if (!empty($attributes)) {
            foreach ($attributes as $attribute) {
                ProductAttributes::query()
                    ->create([
                        'product_id' => $this->id,
                        'attribute_key' => $attribute['attribute_key'],
                        'attribute_value' => $attribute['attribute_value'],
                    ]);
            }
        }
    }

    public function setProductCategories($subCategoryIds)
    {
        ProductCategory::query()
            ->where('product_id', $this->id)
            ->delete();
        if (!empty($subCategoryIds)) {
            foreach ($subCategoryIds as $subCategoryId) {
                $subCategoryModel = CategoryItem::query()
                    ->where('id', $subCategoryId)
                    ->first();
                if ($subCategoryModel) {
                    $level3_id = @$subCategoryModel->parent->id;
                    $level2_id = @$subCategoryModel->parent->parent->id;
                    $level1_id = @$subCategoryModel->parent->parent->parent->id;
                    if (!empty($level1_id) && !empty($level2_id) && !empty($level3_id)) {
                        ProductCategory::query()
                            ->create([
                                'product_id' => $this->id,
                                'category_level_1_id' => $level1_id,
                                'category_level_2_id' => $level2_id,
                                'category_level_3_id' => $level3_id,
                                'category_level_4_id' => $subCategoryId,
                            ]);
                    }
                }
            }
        }
    }

    public static function formatCurency($price)
    {
        $lastDigit = substr($price, -3);
        $last = 0;
        if ($lastDigit < 500 && $lastDigit > 0) {
            $last = ($price - $lastDigit) + 500;
        } elseif ($lastDigit == 500) {
            $last = $price;
        } elseif ($lastDigit > 500 && $lastDigit < 1000) {
            $last = ($price - $lastDigit) + 1000;
        }

        return $last;
    }

    public static function updateOrCreateProduct(Product $product, $request)
    {
        // die(print_r($request->all()));
        $data = Setting::get();
        // $tax = $data[0]->taxation_percentage;
        // $charge = $data[0]->charges_percentage;
        $product->name = $request->name;
        $product->note_before_buy = $request->note_before_buy;
        $product->description = $request->description;

        if ($request->price_depends_on_currency == 1) {
            if (!empty($request->currency_id) && !empty($request->currency_price)) {
                // $currency = Currency::query()->findOrFail($request->currency_id);
                $product->price_in_toman_for_gold_group = round($request->price_in_toman_for_gold_group);
                $product->price_in_toman_for_silver_group = round($request->price_in_toman_for_silver_group);
                $product->price_in_toman_for_bronze_group = round($request->price_in_toman_for_bronze_group);
                $product->special_sale_price = round($request->special_sale_price);
            }
        } else {
            $product->price_in_toman_for_gold_group = $request->price_in_toman_for_gold_group;
            $product->price_in_toman_for_silver_group = $request->price_in_toman_for_silver_group;
            $product->price_in_toman_for_bronze_group = $request->price_in_toman_for_bronze_group;
            $product->special_sale_price = $request->special_sale_price;
        }

        // $product->price_in_toman_for_gold_group = $request->price_in_toman_for_gold_group;
        // $product->price_in_toman_for_silver_group = $request->price_in_toman_for_silver_group;
        // $product->price_in_toman_for_bronze_group = $request->price_in_toman_for_bronze_group;
        $product->special_price_started_at = $request->special_price_started_at ? TimeHelper::jalali2georgian($request->special_price_started_at) : null;
        $product->special_price_expired_at = $request->special_price_expired_at ? TimeHelper::jalali2georgian($request->special_price_expired_at) : null;
        $product->price_depends_on_currency = $request->price_depends_on_currency;
        $product->currency_id = $request->currency_id;
        $product->currency_price = $request->currency_price;
        $product->weight = $request->weight;
        $product->length = $request->length;
        $product->width = $request->width;
        $product->height = $request->height;
        $product->identifier = $request->identifier;
        $product->management_enable = $request->management_enable;
        $product->supply_count_in_store = $request->supply_count_in_store ?? 0;
        $product->max_buy_limit = $request->max_buy_limit;
        $product->low_supply_alert = $request->low_supply_alert;
        $product->only_sell_individually = $request->only_sell_individually;
        $product->shelf_code = $request->shelf_code;
        $product->supplier_price = $request->supplier_price;
        $product->manufacturing_country = $request->manufacturing_country;
        $product->aparat_link = $request->aparat_link;
        $product->save();

        // relations
        $product->setOtherNames($request->other_names);
        $product->setTags($request->tags);
        $product->setCoverImage($request->cover_image_id, $request->cover_image_title);
        $product->setGalleryImages($request->gallery_image_ids);
        $product->setVideos($request->video_ids);
        $product->setSimilarProducts($request->similar_product_ids);
        $product->setProductAttributes($request->product_attributes);
        $product->setProductCategories($request->sub_category_ids);
    }

    public function calculatePurchasePrice()
    {
        if (!Auth::guard('api')->check()) {
            return $this->price_in_toman_for_bronze_group;
        } elseif (Auth::guard('api')->check() &&
            Auth::guard('api')->user()->type == User::TYPES['مشتری'] &&
            Auth::guard('api')->user()->package == User::PACKAGES['برنزی']) {
            return $this->price_in_toman_for_bronze_group;
        } elseif (Auth::guard('api')->check() &&
            Auth::guard('api')->user()->type == User::TYPES['مشتری'] &&
            Auth::guard('api')->user()->package == User::PACKAGES['نقره ای']) {
            return $this->price_in_toman_for_silver_group;
        } elseif (Auth::guard('api')->check() &&
            Auth::guard('api')->user()->type == User::TYPES['مشتری'] &&
            Auth::guard('api')->user()->package == User::PACKAGES['طلایی']) {
            return $this->price_in_toman_for_gold_group;
        }

        return $this->price_in_toman_for_bronze_group;
    }

    public function getPurchasePriceAttribute()
    {
        return $this->calculatePurchasePrice();
    }

    public function getUserTypeAttribute()
    {
        return  $this->userType();
    }

    public function userType()
    {
        if (Auth::guard('api')->user()) {
            return   Auth::guard('api')->user()->package;
        } else {
            return   null;
        }
    }

    public function ratings()
    {
        return $this->hasMany(ProductRating::class);
    }
}
