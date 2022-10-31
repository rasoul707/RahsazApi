<?php

namespace Modules\User\Entities\Builder;

use App\Models\BaseBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\User\Entities\Address;
use Modules\User\Entities\User;

class AddressBuilder extends BaseBuilder
{

    public function __construct()
    {
        $this->_model = Address::query();
    }

    public function userId($userId)
    {
        if(!empty($userId))
        {
            $this->_model->where('user_id', $userId);
        }
        return $this;
    }

}
