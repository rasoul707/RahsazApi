<?php

namespace Modules\SMS\Http\Controllers\Admin;

use App\Models\FarazSMS;
use App\Notifications\FarazSMSNotification;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Notification;
use Modules\SMS\Entities\Sms;
use Modules\SMS\Entities\SmsLog;
use Modules\SMS\Http\Requests\SendGroupSmsRequest;
use Modules\SMS\Http\Requests\SendSingleSmsRequest;
use Modules\User\Entities\User;

class SMSController extends Controller
{
    /**
     * @OA\POST(
     *     path="/admin/sms/send-single-sms",
     *     tags={"Admin/SMS"},
     *     summary="SMS",
     *     description="Age id user ro dashti ba user id befrest, age nadashti phone_number ro befrest.",
     *     @OA\Parameter(
     *         name="user_id",
     *         in="query",
     *         example="1",
     *         description="user_id",
     *         required=false,
     *         explode=true
     *     ),
     *     @OA\Parameter(
     *         name="phone_number",
     *         in="query",
     *         example="09372033455",
     *         description="phone_number",
     *         required=false,
     *         explode=true
     *     ),
     *     @OA\Parameter(
     *         name="text",
     *         in="query",
     *         example="test text",
     *         description="text",
     *         required=true,
     *         explode=true
     *     ),
     *     @OA\Response(response=200, description="Successful", @OA\JsonContent()),
     *     @OA\Response(response=204, description="Successful"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Not Found"),
     *     @OA\Response(response=401, description="Unauthenticated", @OA\JsonContent()),
     * )
     */
    public function sendSingleSms(SendSingleSmsRequest $request)
    {
        if(!empty($request->user_id))
        {
            $users = User::query()
                ->whereIn('id', [$request->user_id])
                ->get();
            if(!empty($users))
            {
                Notification::send($users, new FarazSMSNotification(Sms::create(['text' => $request->text , 'type' => 'single'])));
            }
        }

        elseif(!empty($request->phone_number))
        {
            $sms = Sms::create(['text' => $request->text , 'type' => 'single']);
            $bulkId = FarazSMS::send([$request->phone_number],$sms->text);
            SmsLog::query()
                ->create([
                    'sms_id' => $sms->id,
                    'bulk_id' => $bulkId,
                    'from_number' => '+983000505',
                    'to_number' => $request->phone_number,
                    'to_user_id' => null,
                    'text' => $sms->text,
                ]);
        }

        return response()
            ->json(null, 204);
    }

    /**
     * @OA\POST(
     *     path="/admin/sms/send-group-sms",
     *     tags={"Admin/SMS"},
     *     summary="SMS",
     *     description="",
     *    *     @OA\Parameter(
     *         name="allowed_user_ids[]",
     *         example="1",
     *         in="query",
     *          @OA\Schema(
     *              type="array",
     *              @OA\Items(
     *                  type="string",
     *                  example="1"
     *              ),
     *          ),
     *         description="allowed_user_ids",
     *         required=false,
     *         explode=true
     *     ),
     *     @OA\Parameter(
     *         name="disallowed_user_ids[]",
     *         example="1",
     *         in="query",
     *          @OA\Schema(
     *              type="array",
     *              @OA\Items(
     *                  type="string",
     *                  example="1"
     *              ),
     *          ),
     *         description="disallowed_user_ids",
     *         required=false,
     *         explode=true
     *     ),
     *     @OA\Parameter(
     *         name="allowed_package_ids[]",
     *         example="1",
     *         in="query",
     *          @OA\Schema(
     *              type="array",
     *              @OA\Items(
     *                  type="string",
     *                  example="1"
     *              ),
     *          ),
     *         description="allowed_package_ids",
     *         required=false,
     *         explode=true
     *     ),
     *     @OA\Parameter(
     *         name="text",
     *         example="text",
     *         in="query",
     *         description="text",
     *         required=true,
     *         explode=true
     *     ),
     *     @OA\Response(response=200, description="Successful", @OA\JsonContent()),
     *     @OA\Response(response=204, description="Successful"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Not Found"),
     *     @OA\Response(response=401, description="Unauthenticated", @OA\JsonContent()),
     * )
     */
    public function sendGroupSms(SendGroupSmsRequest $request)
    {
        (new Sms())->groupSms($request->allowed_user_ids, $request->disallowed_user_ids, $request->allowed_package_ids, $request->text);

        return response()
            ->json(null, 204);
    }

    /**
     * @OA\GET(
     *     path="/admin/sms/latest-group-sms",
     *     tags={"Admin/SMS"},
     *     summary="SMS",
     *     description="",
     *     @OA\Response(response=200, description="Successful", @OA\JsonContent()),
     *     @OA\Response(response=204, description="Successful"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Not Found"),
     *     @OA\Response(response=401, description="Unauthenticated", @OA\JsonContent()),
     * )
     */
    public function latestGroupSms()
    {
        $lastFiveGroupSms = Sms::query()
            ->group()
            ->latest()
            ->take(5)
            ->get();

        foreach ($lastFiveGroupSms as $item)
        {
            $item['allowed_users'] = $item->groupSmsAllowedUsers();
            $item['disallowed_users'] = $item->groupSmsDisAllowedUsers();
            $item['allowed_packages'] = $item->groupSmsAllowedUserPackage();
        }



        return response()
            ->json($lastFiveGroupSms);
    }

}
