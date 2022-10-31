<?php

namespace Modules\User\Http\Controllers;

use App\Models\ErrorGenerator;
use App\Models\FarazSMS;
use App\Models\RSS;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Modules\InternalMessage\Entities\InternalMessage;
use Modules\SMS\Entities\Sms;
use Modules\SMS\Entities\SmsLog;
use Modules\User\Entities\PhoneVerification;
use Modules\User\Entities\User;
use Modules\User\Http\Requests\RegisterRequest;
use Modules\User\Http\Requests\SendVerificationCodeRequest;
use Modules\User\Http\Requests\VerifyPhoneRequest;
use Modules\User\Services\UserServices;
use Psy\Util\Str;

class AuthController extends Controller
{
    /**
     * @OA\Post(
     *      path="/auth/logout",
     *      tags={"Auth"},
     *      summary="logout",
     *      description="",
     *     @OA\Response(response=200, description="Successful", @OA\JsonContent()),
     *     @OA\Response(response=204, description="Successful"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Not Found"),
     *     @OA\Response(response=401, description="Unauthenticated", @OA\JsonContent()),
     * )
     */

    public function logout()
    {
        if (Auth::check()) {
            auth()->user()->tokens()->delete();
        }
        return response()->json(null, 204);
    }
    /**
     * @OA\POST(
     *     path="/login-via-email",
     *     tags={"Auth"},
     *     summary="Auth",
     *     description="",
     *     @OA\Parameter(
     *         name="email",
     *         in="query",
     *         description="email",
     *         required=true,
     *         explode=true
     *     ),
     *     @OA\Parameter(
     *         name="password",
     *         in="query",
     *         description="password",
     *         required=true,
     *         explode=true
     *     ),
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
    public function loginViaEmail(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (!Auth::attempt([
            'email' => request('email'),
            'password' => request('password'),
        ])) {
            return response()->json([
                'message' => 'ایمیل یا گذر واژه نادرست است.',
                'errors' => [
                    'error' => 'ایمیل یا گذر واژه نادرست است.',
                ]
            ], 422);
        }

        return $this->getAuthResponse(\auth()->user());
    }

    /**
     * @OA\POST(
     *     path="/login-via-phone",
     *     tags={"Auth"},
     *     summary="Auth",
     *     description="",
     *     @OA\Parameter(
     *         name="phone_number",
     *         in="query",
     *         description="phone_number",
     *         required=true,
     *         explode=true
     *     ),
     *     @OA\Parameter(
     *         name="password",
     *         in="query",
     *         description="password",
     *         required=true,
     *         explode=true
     *     ),
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
    public function loginViaPhone(Request $request)
    {
        $user = User::query()
            ->where('phone_number', $request->phone_number)
            ->firstOrFail();

        $isPasswordCorrect = Hash::check($request->password, $user->password);

        if (!$isPasswordCorrect) {
            return response()->json([
                'message' => 'گذر واژه اشتباه است',
                'errors' => [
                    'error' => 'گذر واژه اشتباه است',
                ]
            ], 422);
        }

        return $this->getAuthResponse($user);
    }

    /**
     * @OA\POST(
     *     path="/login/otp/send-otp-code",
     *     tags={"Auth/OTP"},
     *     summary="Auth - LOGIN WITH OTP ( ONE TIME PASSWORD ) - STEP 1 ( SEND SMS )",
     *     description="",
     *     @OA\Parameter(
     *         name="phone_number",
     *         in="query",
     *         description="phone_number",
     *         required=true,
     *         explode=true
     *     ),
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
    public function sendOTPCode(Request $request)
    {
        User::query()
            ->where('phone_number', $request->phone_number)
            ->firstOrFail();

        PhoneVerification::query()
            ->where('phone_number', $request->phone_number)
            ->update([
                'expired_at' => Carbon::now()
            ]);

        $code = rand(100000, 999999);

        PhoneVerification::query()
            ->create([
                'phone_number' => $request->phone_number,
                'code' => $code,
            ]);

        Sms::sendVerificationSMS($request->phone_number, $code);

        return response()
            ->json(null, 204);
    }

    /**
     * @OA\POST(
     *     path="/login-via-otp",
     *     tags={"Auth/OTP"},
     *     summary="Auth - LOGIN WITH OTP ( ONE TIME PASSWORD ) - STEP 2 ( LOGIN )",
     *     description="",
     *     @OA\Parameter(
     *         name="phone_number",
     *         in="query",
     *         description="phone_number",
     *         required=true,
     *         explode=true
     *     ),
     *     @OA\Parameter(
     *         name="code",
     *         in="query",
     *         description="code",
     *         required=true,
     *         explode=true
     *     ),
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
    public function loginViaOTP(Request $request)
    {
        $phoneVerification = PhoneVerification::query()
            ->where('phone_number', $request->phone_number)
            ->where('code', $request->code)
            ->where('expired_at', null)
            ->first();

        if ($phoneVerification) {
            $phoneVerification->expired_at = Carbon::now();
            $phoneVerification->save();
            $user = User::query()
                ->where('phone_number', $request->phone_number)
                ->firstOrFail();
            return $this->getAuthResponse($user);
        }

        return ErrorGenerator::error("اطلاعات معتبر نیست!");
    }


    /*Forgot password*/


    /**
     * @OA\POST(
     *     path="/forgot-password/send-new-password",
     *     tags={"Auth/Forgot-Password"},
     *     summary="Auth - Forgot password - SMS New password to client",
     *     description="",
     *     @OA\Parameter(
     *         name="phone_number",
     *         in="query",
     *         description="phone_number",
     *         required=true,
     *         explode=true
     *     ),
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
    public function forgotPasswordSendNewPassword(Request $request)
    {
        $user = User::query()
            ->where('phone_number', $request->phone_number)
            ->firstOrFail();

        $randomPassword = \Illuminate\Support\Str::random(8);
        $user->password = bcrypt($randomPassword);
        $user->save();

        Sms::sendVerificationSMS($request->phone_number, $randomPassword);

        return response()
            ->json(null, 204);
    }

    private function getAuthResponse($user)
    {
        $token = $user->createToken('rahsaz')->accessToken;
        $unreadMessages = InternalMessage::query()
            ->where('to_user_id', $user->id)
            ->where('seen_at', null)
            ->count();
        return response()->json([
            'token' => $token,
            'user' => $user,
            'unread_message_count' => $unreadMessages,
            'user_permissions' => $user->permissions()->get()
        ], 200);
    }

    /* Registration */






    /**
     * @OA\POST(
     *     path="/register",
     *     tags={"Auth"},
     *     summary="Auth - STEP 1 OF REGISTER",
     *     description="type : مشتری / roles : مشتری & همکار & شرکت",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/RegisterBody")
     *     ),
     *     @OA\Response(response=200, description="Successful", @OA\JsonContent()),
     *     @OA\Response(response=204, description="Successful"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Not Found"),
     *     @OA\Response(response=401, description="Unauthenticated", @OA\JsonContent()),
     * )
     */

    public function register(RegisterRequest $request)
    {
        $user = (new UserServices())
            ->register($request, (new User()));

        return $this->getAuthResponse($user);
    }

    /**
     * @OA\POST(
     *     path="/register/send-verification-code",
     *     tags={"Auth"},
     *     summary="Auth - STEP 2 OF REGISTER",
     *     @OA\Parameter(
     *         name="phone_number",
     *         in="query",
     *         description="phone_number",
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
    public function sendVerificationCode(SendVerificationCodeRequest $request)
    {
        (new UserServices())
            ->sendVerificationCode($request->phone_number);

        return response()
            ->json(null, 204);
    }

    /**
     * @OA\POST(
     *     path="/register/verify-phone",
     *     tags={"Auth"},
     *     summary="Auth - STEP 3 OF REGISTER",
     *     @OA\Parameter(
     *         name="phone_number",
     *         in="query",
     *         description="phone_number",
     *         required=true,
     *         explode=true
     *     ),
     *     @OA\Parameter(
     *         name="code",
     *         in="query",
     *         description="code",
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
    public function verifyPhone(VerifyPhoneRequest $request)
    {
        return (new UserServices())
            ->verifyUser($request->phone_number, $request->code);
    }

    /**
     * @OA\POST(
     *     path="/rss",
     *     tags={"RSS"},
     *     summary="RSS",
     *     description="",
     *     @OA\Parameter(
     *         name="email",
     *         in="query",
     *         description="email",
     *         required=true,
     *         explode=true
     *     ),
     *      @OA\Response(response=200, description="Successful", @OA\JsonContent()),
     *     @OA\Response(response=204, description="Successful"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Not Found"),
     *     @OA\Response(response=401, description="Unauthenticated", @OA\JsonContent()),
     * )
     */
    public function rss(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email']
        ]);

        $exists = RSS::query()->where('email', $request->email)->first();

        if (!$exists) {
            RSS::query()
                ->create([
                    'email' => $request->email,
                ]);
        }

        return response()
            ->json(null, 204);
    }
}
