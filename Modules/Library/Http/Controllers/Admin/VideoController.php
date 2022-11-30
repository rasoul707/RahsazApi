<?php

namespace Modules\Library\Http\Controllers\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Modules\Library\Entities\Builder\ImageBuilder;
use Modules\Library\Entities\Builder\VideoBuilder;
use Modules\Library\Entities\Image;
use Modules\Library\Entities\Video;

class VideoController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'offset' => ['required'],
            'order_by' => ['nullable'],
            'order_type' => ['nullable'],
        ]);
        $builder = (new VideoBuilder())
            ->offset($request->offset)
            ->pageCount($request->page_size)
            ->order($request->order_by ?? 'id', $request->order_type ?? 'desc');

        return response()
            ->json([
                'page_count' => $request->page_size,
                'total_count' => $builder->count(),
                'items' => $builder->getWithPageCount(),
            ]);
    }

    public function destroy($id)
    {
        Video::query()
            ->findOrFail($id)
            ->delete();

        return response()->json(null, 204);
    }

    public function update(Request $request, $id)
    {
        $video = Video::query()
            ->findOrFail($id);
        $video->title    = $request->title;
        $video->alt      = $request->alt;
        $video->save();
        return response()->json(null, 204);
    }

    public function store(Request $request)
    {
        $video = $request->file('video');
        Validator::make(['video' => $video], [
            'video' => ['required'],
        ])->validate();
        $fileName = time() . ' ' . $video->getClientOriginalName();
        Storage::disk('local')->putFileAs(
            'public/videos',
            $video,
            $fileName
        );
        $videoModel = Video::query()
            ->create([
                'path' => $fileName,
                'title' => $request->title,
                'alt' => $request->alt,
            ]);
        return response()->json($videoModel);
    }
}
