<?php

namespace Modules\Blog\Entities\Builder;

use App\Models\BaseBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Blog\Entities\BlogPost;

class BlogPostBuilder extends BaseBuilder
{
    public function __construct()
    {
        $this->_model = BlogPost::query();
    }

    public function status($status)
    {
        if(!empty($status))
        {
            $this->_model->where('status', $status);
        }
        return $this;
    }
}
