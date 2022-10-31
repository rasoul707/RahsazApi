<?php

namespace Modules\Coupon\Entities;

use App\Models\TimeHelper;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Category\Entities\CategoryItem;
use Modules\Product\Entities\Product;
use Modules\User\Entities\User;
use Modules\User\Entities\UserPackage;

class Coupon extends Model
{
    use SoftDeletes;
    protected $table = 'coupons';
    protected $guarded = [];

    const TYPES = [
        'ثابت روی سبد خرید' => 'ثابت روی سبد خرید',
        'درصد روی سبد خرید' => 'درصد روی سبد خرید',
        'درصد روی محصول' => 'درصد روی محصول',
        'ثابت روی محصول' => 'ثابت روی محصول',
    ];

    const AMOUNT_TYPE = [
        'درصد' => 'درصد',
        'ثابت' => 'ثابت',
    ];

    /* Relations */

    public function allowedUsers()
    {
        return $this->morphedByMany(User::class, 'couponable');
    }

    public function allowedCategories()
    {
        return $this->morphedByMany(CategoryItem::class, 'couponable');
    }

    public function allowedProducts()
    {
        return $this->morphedByMany(Product::class, 'couponable');
    }


    public function allowedUserPackages()
    {
        return $this->morphedByMany(UserPackage::class, 'couponable');
    }

    /* SCOPES */

    public function scopeActive($query)
    {
        return $query->where('expired_at', null)
            ->orWhere('expired_at' , '>', Carbon::now());
    }

    public function scopeInactive($query)
    {
        return $query->where('expired_at', '!=' , null)
            ->where('expired_at' , '<', Carbon::now());
    }

    /* methods */

    public static function updateOrCreateCoupon(Coupon $coupon, $request)
    {
        $coupon->code = $request->code;
        $coupon->description = $request->description;
        $coupon->type = $request->type;
        $coupon->amount_type = $request->amount_type;
        $coupon->amount = $request->amount;
        $coupon->expired_at = $request->expired_at ? TimeHelper::jalali2georgian($request->expired_at) : null;
        $coupon->limit_count = $request->limit_count;
        $coupon->max_amount = $request->max_amount;
        $coupon->min_amount = $request->min_amount;
        $coupon->save();


        Couponable::query()->where('coupon_id', $coupon->id)->delete();
        // add allowed products
        if(!empty($request->allowed_product_ids))
        {
            $allowedProductIds = $request->allowed_product_ids;
            foreach ($allowedProductIds as $allowedProductId)
            {
                if(Product::query()->findOrFail($allowedProductId))
                {
                    Couponable::query()
                        ->firstOrCreate([
                            'coupon_id' => $coupon->id,
                            'couponable_id' => $allowedProductId,
                            'couponable_type' => Product::class,
                            'status' => 'allowed',
                        ]);
                }
            }
        }

        // add allowed categories
        if(!empty($request->allowed_category_ids))
        {
            $allowedCategoryIds = $request->allowed_category_ids;
            foreach ($allowedCategoryIds as $allowedCategoryId)
            {
                if(CategoryItem::query()->findOrFail($allowedCategoryId))
                {
                    Couponable::query()
                        ->firstOrCreate([
                            'coupon_id' => $coupon->id,
                            'couponable_id' => $allowedCategoryId,
                            'couponable_type' => CategoryItem::class,
                            'status' => 'allowed',
                        ]);
                }
            }
        }

        // add allowed users
        if(!empty($request->allowed_user_ids))
        {
            $allowedUserIds = $request->allowed_user_ids;
            foreach ($allowedUserIds as $allowedUserId)
            {
                if(User::query()->findOrFail($allowedUserId))
                {
                    Couponable::query()
                        ->firstOrCreate([
                            'coupon_id' => $coupon->id,
                            'couponable_id' => $allowedUserId,
                            'couponable_type' => User::class,
                            'status' => 'allowed',
                        ]);
                }
            }
        }

        // add allowed packages
        if(!empty($request->allowed_package_ids))
        {
            $allowedPackageIds = $request->allowed_package_ids;
            foreach ($allowedPackageIds as $allowedPackageId)
            {
                if(UserPackage::query()->findOrFail($allowedPackageId))
                {
                    Couponable::query()
                        ->firstOrCreate([
                            'coupon_id' => $coupon->id,
                            'couponable_id' => $allowedPackageId,
                            'couponable_type' => UserPackage::class,
                            'status' => 'allowed',
                        ]);
                }

            }
        }
    }

    public function isAcceptable()
    {
        return true;
    }
}
