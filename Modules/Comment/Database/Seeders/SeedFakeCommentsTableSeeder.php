<?php

namespace Modules\Comment\Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Blog\Entities\BlogPost;
use Modules\Comment\Entities\Comment;
use Modules\Product\Entities\Product;
use Modules\User\Entities\User;
use Faker\Factory as Faker;


class SeedFakeCommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        for($i = 0; $i < 10; $i++)
        {
            $randomCommentable = $this->getRandomCommentable();
            Comment::query()
                ->create([
                    'parent_comment_id' => null,
                    'user_id' => User::query()->inRandomOrder()->first()->id,
                    'commentable_id' => $randomCommentable['id'],
                    'commentable_type' => $randomCommentable['type'],
                    'content' => Faker::create('fa_IR')->realText,
                    'status' => Comment::STATUS['waiting_for_response'],
                    'type' => Comment::TYPE['comment'],
                ]);

            Comment::query()
                ->create([
                    'parent_comment_id' => null,
                    'user_id' => User::query()->inRandomOrder()->first()->id,
                    'commentable_id' => $randomCommentable['id'],
                    'commentable_type' => $randomCommentable['type'],
                    'content' => Faker::create('fa_IR')->realText,
                    'status' => Comment::STATUS['waiting_for_response'],
                    'type' => Comment::TYPE['question_and_answer'],
                ]);
        }
    }

    private function getRandomCommentable()
    {
        if(rand() % 2 == 0)
        {
            $model = Product::query()->inRandomOrder()->first();
            return [
                'id' => $model->id,
                'type' => Product::class,
            ];
        }
        $model = BlogPost::query()->inRandomOrder()->first();
        return [
            'id' => $model->id,
            'type' => BlogPost::class,
        ];
    }
}
