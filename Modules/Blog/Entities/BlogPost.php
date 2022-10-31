<?php

namespace Modules\Blog\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Library\Entities\Image;
use Modules\User\Entities\User;

class BlogPost extends Model
{
    use SoftDeletes;
    protected $table = 'blog_posts';
    protected $guarded = [];
    protected $with = ['image'];


    const STATUS = [
        'scheduled' => 'scheduled',
        'published' => 'published',
        'draft' => 'draft',
    ];

    public function writer()
    {
        return $this->belongsTo(User::class, 'written_by_user_id');
    }

    public function tags()
    {
        return $this->morphMany(Tag::class,'taggable');
    }


    public function image()
    {
        return $this->belongsTo(Image::class);
    }
}
