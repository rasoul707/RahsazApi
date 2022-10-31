<?php

namespace Modules\User\Entities\Builder;

use App\Models\BaseBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\User\Entities\Address;
use Modules\User\Entities\User;
use Modules\User\Entities\UserPackage;

class UserPackageBuilder extends BaseBuilder
{

    public function __construct()
    {
        $this->_model = UserPackage::query();
    }


}
