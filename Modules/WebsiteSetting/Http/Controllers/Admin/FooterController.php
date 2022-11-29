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
            // ->with(['items'])
            ->orderBy('priority')
            ->get();
        return response()->json($footerMenu);
    }

    public function show($id)
    {
        $footerMenu = FooterMenu::query()
            ->where('id', '=', $id)
            ->with(['items'])
            ->orderBy('priority')
            ->get();
        if (count($footerMenu)) return response()->json($footerMenu[0]);
        return response()->json(['message' => "The menu not found"], '404');
    }


    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required'],
        ]);
        $priority = FooterMenu::query()
            ->orderBy('priority', 'desc')
            ->limit(1)
            ->select(['priority'])
            ->get();
        $lastPriority = count($priority) ? $priority[0]['priority'] : 0;
        $lastPriority++;
        $inserted = FooterMenu::query()
            ->create([
                'title' => $request->title,
                'priority' => $lastPriority
            ]);
        return response()->json($inserted);
    }


    public function storeItem(Request $request)
    {
        $request->validate([
            'title' => ['required'],
            'menu_id' => ['required'],
        ]);
        $footerMain = FooterMenu::query()
            ->where('id', '=', $request->menu_id)
            ->exists();
        if (!$footerMain) return response()->json(['message' => "The menu not found"], '404');
        $priority = FooterMenuItems::query()
            ->where('menu_id', '=', $request->menu_id)
            ->orderBy('priority', 'desc')
            ->limit(1)
            ->select(['priority'])
            ->get();
        $lastPriority = count($priority) ? $priority[0]['priority'] : 0;
        $lastPriority++;
        $inserted = FooterMenuItems::query()
            ->create([
                'title' => $request->title,
                'priority' => $lastPriority,
                'menu_id' => $request->menu_id
            ]);
        return response()->json($inserted);
    }


    public function destroy($id)
    {
        $res = FooterMenu::destroy($id);
        if ($res) {
            $res = FooterMenuItems::where('menu_id', '=', $id)->delete();
            if ($res) {
                return response()->json([
                    'status' => 1,
                    'msg' => 'success'
                ]);
            }
        }
        return response()->json([
            'status' => 0,
            'msg' => 'fail'
        ]);
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


    public function update(Request $request)
    {

        return response()->json([]);
    }
}
