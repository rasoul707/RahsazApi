<?php

namespace Modules\Coupon\Entities\Builder;

use App\Models\BaseBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Coupon\Entities\Coupon;
use Modules\User\Entities\User;

class CouponBuilder extends BaseBuilder
{

    public function __construct()
    {
        $this->_model = Coupon::query();
    }

    public function activationType($activationType)
    {
        if(!empty($activationType))
        {
            if($activationType == 'active')
            {
                $this->_model->active();
            }

            if($activationType == 'inactive')
            {
                $this->_model->inactive();
            }
        }

        return $this;
    }

    public function customerPov($userId)
    {
        // 1. does not have any couponable
        $this->_model->orwhere(function ($q){
            $q->whereDoesntHave('allowedUsers');
            $q->whereDoesntHave('allowedUserPackages');
        });
        // 2. has couponable on user id
        $this->_model->orwhereHas('allowedUsers', function($query) use($userId){
            $query->where('couponable_id', $userId);
        });
        // 3. has couponable on user package id
        $this->_model->orwhereHas('allowedUserPackages', function($query) use($userId){
            $query->where('couponable_id', User::query()->findOrFail($userId)->package_id);
        });
        return $this;
    }
}
