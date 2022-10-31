<?php

namespace Modules\User\Services;


use App\Models\ErrorGenerator;
use Illuminate\Support\Carbon;
use Modules\SMS\Entities\Sms;
use Modules\User\Entities\PhoneVerification;
use Modules\User\Entities\User;
use Modules\User\Http\Requests\RegisterRequest;

class UserServices
{
    public function register(RegisterRequest $request, User $user)
    {
        $user->status   = User::STATUSES['در انتظار تایید مدیریت'];
        $user->package  = User::PACKAGES['برنزی'];
        $user->type     = User::TYPES['مشتری'];
        $user->role     = $request->role;
        $user->first_name   = $request->first_name;
        $user->last_name    = $request->last_name;
        $user->username     = $request->username;
        $user->phone_number = $request->phone_number;
        $user->email        = $request->email;
        $user->state        = $request->state;
        $user->city         = $request->city;
        $user->address      = $request->address;
        $user->legal_info_melli_code = $request->legal_info_melli_code;
        $user->legal_info_economical_code = $request->legal_info_economical_code;
        $user->legal_info_registration_number = $request->legal_info_registration_number;
        $user->legal_info_company_name = $request->legal_info_company_name;
        $user->legal_info_state = $request->legal_info_state;
        $user->legal_info_city = $request->legal_info_city;
        $user->legal_info_address = $request->legal_info_address;
        $user->legal_info_phone_number = $request->legal_info_phone_number;
        $user->legal_info_postal_code = $request->legal_info_postal_code;
        $user->refund_info_bank_name = $request->refund_info_bank_name;
        $user->refund_info_account_holder_name = $request->refund_info_account_holder_name;
        $user->refund_info_cart_number = $request->refund_info_cart_number;
        $user->refund_info_account_number = $request->refund_info_account_number;
        $user->refund_info_sheba_number = $request->refund_info_sheba_number;
        $user->password = bcrypt($request->password);
        $user->guild_identifier = $request->guild_identifier;
        $user->store_name = $request->store_name;
        $user->save();
        return $user;
    }

    public function sendVerificationCode($phoneNumber)
    {
        PhoneVerification::query()
            ->where('phone_number', $phoneNumber)
            ->update([
                'expired_at' => Carbon::now()
            ]);

        $randomCode = rand(100000,999999);
        PhoneVerification::query()
            ->create([
                'phone_number' => $phoneNumber,
                'code' => $randomCode,
            ]);

        Sms::sendVerificationSMS($phoneNumber, $randomCode);
    }

    public function verifyUser($phoneNumber, $code)
    {

        $phoneVerification = PhoneVerification::query()
            ->where('phone_number', $phoneNumber)
            ->where('code', $code)
            ->where('expired_at', null)
            ->first();

        if($phoneVerification)
        {
            $phoneVerification->expired_at = Carbon::now();
            $phoneVerification->save();
            return;
        }

        return ErrorGenerator::error("اطلاعات معتبر نیست!");
    }
}
