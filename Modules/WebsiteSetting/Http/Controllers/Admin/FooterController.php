<?php

namespace Modules\WebsiteSetting\Http\Controllers\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\WebsiteSetting\Entities\FooterMenu;
use Modules\WebsiteSetting\Entities\FooterMenuItems;
use Illuminate\Support\Facades\Log;

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
        $requests = $request->all();
        foreach ($requests ?? [] as $key => $value) {
            FooterMenu::query()
                ->updateOrCreate([
                    'key' => $key,
                ], [
                    'value' => $value,
                ]);
        }
        return response()
            ->json(null, 204);
    }


    public function destroy($id)
    {
        $res = FooterMenu::destroy($id);
        if ($res) {
            return response()->json([
                'status' => 1,
                'msg' => 'success'
            ]);
        } else {
            return response()->json([
                'status' => 0,
                'msg' => 'fail'
            ]);
        }
    }

    public function destroyItem($id)
    {
        $res = FooterMenuItems::destroy($id);
        if ($res) {
            return response()->json([
                'status' => 1,
                'msg' => 'success'
            ]);
        } else {
            return response()->json([
                'status' => 0,
                'msg' => 'fail'
            ]);
        }
    }
}
