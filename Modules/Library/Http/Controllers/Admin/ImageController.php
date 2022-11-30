<?php

namespace Modules\Library\Http\Controllers\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Modules\Library\Entities\Builder\ImageBuilder;
use Modules\Library\Entities\Image;

class ImageController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'offset' => ['required'],
            'order_by' => ['nullable'],
            'order_type' => ['nullable'],
        ]);
        $builder = (new ImageBuilder())
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
        Image::query()
            ->findOrFail($id)
            ->delete();

        return response()->json(null, 204);
    }

    public function update(Request $request, $id)
    {
        $image = Image::query()
            ->findOrFail($id);
        $image->title    = $request->title;
        $image->alt      = $request->alt;
        $image->save();
        return response()->json(null, 204);
    }

    public function store(Request $request)
    {
        $image = $request->file('image');
        Validator::make(['image' => $image], [
            'image' => ['required', 'mimes:webm,jpg,jpeg,bmp,png'],
        ])->validate();
        $fileName = time() . ' ' . $image->getClientOriginalName();
        Storage::disk('local')->putFileAs(
            'public/images',
            $image,
            $fileName
        );
        $imageModel = Image::query()
            ->create([
                'path' => $fileName,
                'title' => $request->title,
                'alt' => $request->alt,
            ]);
        return response()->json($imageModel);
    }
}
