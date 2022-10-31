<?php

namespace Modules\InternalMessage\Entities\Builder;

use App\Models\BaseBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\InternalMessage\Entities\InternalMessage;
use Modules\User\Entities\Address;
use Modules\User\Entities\User;

class InternalMessageBuilder extends BaseBuilder
{

    public function __construct()
    {
        $this->_model = InternalMessage::query();
    }

    public function toUserId($userId)
    {
        if(!empty($userId))
        {
            $this->_model->where('to_user_id', $userId);
        }
        return $this;
    }

}
