<?php

namespace Modules\User\Http\Controllers\Customer;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\InternalMessage\Entities\Builder\InternalMessageBuilder;
use Modules\InternalMessage\Entities\InternalMessage;

class InternalMessageController extends Controller
{
    /**
     * @OA\GET (
     *     path="/customer/internal-messages/index",
     *     tags={"Customer/InternalMessages"},
     *     summary="مشتری - مدیریت پیغام ها",
     *     description="",
     *     @OA\Response(response=200, description="Successful", @OA\JsonContent()),
     *     @OA\Response(response=204, description="Successful"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Not Found"),
     *     @OA\Response(response=401, description="Unauthenticated", @OA\JsonContent()),
     *     security={
     *         {
     *             "bearerAuth": {}
     *         }
     *     },
     * )
     */
    public function index()
    {
        $builder = (new InternalMessageBuilder())
            ->with(['fromUser'])
            ->order('id', 'desc')
            ->toUserId(auth()->user()->id);

        InternalMessage::query()
            ->where('to_user_id', auth()->user()->id)
            ->update([
                'seen_at' => Carbon::now(),
            ]);

        return response()
            ->json($builder->getAll());
    }
}
