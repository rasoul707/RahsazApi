<?php

namespace Modules\FrontPage\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\FrontPage\Entities\Builder\PageBuilder;
use Modules\FrontPage\Entities\Page;
use Illuminate\Support\Facades\DB;
use Modules\FrontPage\Http\Requests\StorePageRequest;

class FrontPageController extends Controller
{
    public function index(Request $request)
    {
        $builder = (new PageBuilder())
        
        ->search($request->search, ['id', 'name'])
        ->overallStatus($request->overall_status)
        ->processStatus($request->process_status)
        ->order($request->order_by, $request->order_type)
        ->customSort($request->custom_sort)
        ->offset($request->offset)
        ->pageCount(25);

        return response()->json([
        'page_count' => 25,
        'total_count' => $builder->count(),
        'items' => $builder->getWithPageCount(),
    ]);
    }

    public function show($id)
    {
        $user = Page::query()
            ->findOrFail($id);

        return response()
            ->json($user);
    }
    public function destroy($id)
    {
        $user = Page::query()
            ->findOrFail($id)
            ->delete();

        return response()
            ->json(null, 204);
    }
    public function update(Request $request, $id)
    {
        DB::transaction(function () use ($request, $id) {
            $page = Page::findOrFail($id);
            Page::updateOrCreatePage($page, $request);
            $page->save();
        });

        return response()
            ->json(null, 204);
    }
    public function store(StorePageRequest $request)
    {
        DB::transaction(function () use ($request) {
            $page = new Page();
            Page::updateOrCreatePage($page, $request);
            $page->save();
        });
        return response()
            ->json(null, 204);
    }
}
