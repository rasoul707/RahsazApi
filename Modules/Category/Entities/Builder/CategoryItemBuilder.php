<?php

namespace Modules\Category\Entities\Builder;

use App\Models\BaseBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Category\Entities\CategoryItem;

class CategoryItemBuilder extends BaseBuilder
{

    public function __construct()
    {
        $this->_model = CategoryItem::query();
    }

    public function categoryId($id)
    {
        if(!empty($id))
        {
            if(is_array($id))
            {
                $this->_model->whereIn('category_id',$id);
            }else {
                
                $this->_model->where('category_id',$id);
            }
        }
        return $this;
    }
}
