<?php

namespace Modules\Comment\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Blog\Entities\BlogPost;
use Modules\User\Entities\User;

class Comment extends Model
{
    use SoftDeletes;

    protected $table = 'comments';
    protected $guarded = [];
    protected $with = ['user'];

    const TYPE = [
        'question_and_answer' => 'question_and_answer',
        'comment' => 'comment',
    ];

    const STATUS = [
        'waiting_for_response' => 'waiting_for_response',
        'responded' => 'responded',
        'inactive' => 'inactive',
    ];

    public function user()
    {
        return $this->belongsTo(User::class)->select('id', 'first_name', 'last_name');
    }

    public function commentable()
    {
        return $this->morphTo();
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_comment_id');
    }

    /* methods */

    public function toggleActive()
    {
        if($this->status != self::STATUS['inactive'])
        {
            $this->children()
                ->update([
                    'status' => self::STATUS['inactive'],
                ]);
            $this->update([
                'status' => self::STATUS['inactive'],
            ]);
            return;
        }
        $this->children()
            ->update([
                'status' => self::STATUS['waiting_for_response'],
            ]);
        $this->update([
            'status' => self::STATUS['waiting_for_response'],
        ]);
    }

    public function response($response)
    {
        Comment::query()
            ->create([
                'parent_comment_id' => $this->id,
                'user_id' => auth()->user()->id ?? 1,
                'commentable_id' => $this->commentable_id,
                'commentable_type' => $this->commentable_type,
                'content' => $response,
                'status' => self::STATUS['waiting_for_response'],
                'type' => $this->type,
            ]);
        $this->status = self::STATUS['responded'];
        $this->save();
    }
}
