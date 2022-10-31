<?php

namespace Modules\Comment\Entities\Builder;

use App\Models\BaseBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Comment\Entities\Comment;

class CommentBuilder extends BaseBuilder
{

    public function __construct()
    {
        $this->_model = Comment::query();
    }
    public function userId($userId)
    {
        if(!empty($userId))
        {
            $this->_model->where('user_id', $userId);
        }
        return $this;
    }


    public function type($type)
    {
        if(!empty($type))
        {
            $this->_model->where('type', $type);
        }
        return $this;
    }

    public function types($types)
    {
        if(!empty($types))
        {
            $this->_model->whereIn('type', $types);
        }
        return $this;
    }

    public function commentableType($commentableType)
    {
        if(!empty($commentableType))
        {
            $this->_model->where('commentable_type', $commentableType);
        }
        return $this;
    }
}
