<?php

namespace Modules\InternalMessage\Http\Controllers\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\InternalMessage\Entities\InternalMessage;

class InternalMessageController extends Controller
{
    public function send(Request $request)
    {
        $request->validate([
            'user_ids' => ['required', 'array'],
            'text' => ['required'],
        ]);

        foreach ($request->user_ids as $userId)
        {
            (new InternalMessage())
                ->send(auth()->user()->id ?? null, $userId, $request->text);
        }

        return response()
            ->json(null,204);

    }
}
