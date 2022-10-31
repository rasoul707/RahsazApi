<?php

namespace Modules\Category\Entities\Builder;

use App\Models\BaseBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Category\Entities\Category;

class CategoryBuilder extends BaseBuilder
{

    public function __construct()
    {
        $this->_model = Category::query();
    }

    public function type($type)
    {
        if(!empty($type))
            $this->_model->where('type', $type);
        return $this;
    }
}
