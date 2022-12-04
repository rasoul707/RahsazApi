<?php

namespace Modules\Blog\Http\Controllers\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Blog\Entities\BlogPost;
use Modules\Blog\Entities\Builder\BlogPostBuilder;
use Modules\Blog\Entities\Tag;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'status' => ['required'],
            'offset' => ['required'],
        ]);

        $builder = (new BlogPostBuilder())
            ->with(['writer', 'tags'])
            ->status($request->status)
            ->search($request->search, ['title', 'description'])
            ->offset($request->offset)
            ->pageCount($request->page_size);

        return response()
            ->json([
                'page_count' => $request->page_size,
                'total_count' => $builder->count(),
                'items' => $builder->getWithPageCount(),
            ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'written_by_user_id' => ['required'],
            'title' => ['required'],
            'description' => ['required'],
            'image_id' => ['nullable'],
            'has_educational_video' => ['required'],
            'tags' => ['nullable', 'array'],
            'status' => ['required'],
        ]);

        $blogPost = BlogPost::query()
            ->create([
                'written_by_user_id' => $request->written_by_user_id,
                'title' => $request->title,
                'description' => $request->description,
                'image_id' => $request->image_id,
                'has_educational_video' => $request->has_educational_video,
                'status' => $request->status,
                'video_link' => $request->video_link,
            ]);

        foreach ($request->tags ?? [] as $tag) {
            Tag::query()
                ->create([
                    'taggable_id' => $blogPost->id,
                    'taggable_type' => BlogPost::class,
                    'title' => $tag,
                ]);
        }

        return response()
            ->json(null, 204);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'written_by_user_id' => ['required'],
            'title' => ['required'],
            'description' => ['required'],
            'image_id' => ['nullable'],
            'has_educational_video' => ['required'],
            'tags' => ['array'],
            'status' => ['required'],
        ]);

        $blogPost = BlogPost::query()->findOrFail($id);

        $blogPost->update([
            'written_by_user_id' => $request->written_by_user_id,
            'title' => $request->title,
            'description' => $request->description,
            'image_id' => $request->image_id,
            'has_educational_video' => $request->has_educational_video,
            'status' => $request->status,
            'video_link' => $request->video_link,
        ]);

        Tag::query()
            ->where('taggable_id', $blogPost->id)
            ->where('taggable_type', BlogPost::class)
            ->delete();

        foreach ($request->tags as $tag) {
            Tag::query()
                ->create([
                    'taggable_id' => $blogPost->id,
                    'taggable_type' => BlogPost::class,
                    'title' => $tag,
                ]);
        }

        return response()
            ->json(null, 204);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate(['status' => ['required']]);
        BlogPost::query()
            ->findOrFail($id)
            ->update(['status' => $request->status]);

        return response()
            ->json(null, 204);
    }

    public function show($id)
    {
        return response()
            ->json(BlogPost::query()
                ->with(['writer', 'tags'])
                ->findOrFail($id));
    }

    public function destroy($id)
    {
        BlogPost::query()->findMany(explode(",", $id))->each->delete();
        return response()->json(null, 204);
    }
}
