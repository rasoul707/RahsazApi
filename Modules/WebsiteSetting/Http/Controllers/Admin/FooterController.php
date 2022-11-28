<?php

namespace Modules\WebsiteSetting\Http\Controllers\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\WebsiteSetting\Entities\FooterMenu;
use Modules\WebsiteSetting\Entities\FooterMenuItems;

class FooterController extends Controller
{


    public function index()
    {
        $footerMenu = FooterMenu::query()
            ->with(['items'])
            ->orderBy('priority')
            ->get();
        return response()->json($footerMenu);
    }


    public function store(Request $request)
    {
        // $requests = $request->all();
        // foreach ($requests ?? [] as $key => $value)
        // {
        //     Banner::query()
        //         ->updateOrCreate([
        //             'key' => $key,
        //         ],[
        //             'value' => $value,
        //         ]);
        // }

        return response()
            ->json(null, 204);
    }
}
