<?php

namespace Modules\SMS\Entities;

use App\Models\FarazSMS;
use App\Notifications\FarazSMSNotification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Notification;
use Modules\User\Entities\User;
use Modules\User\Entities\UserPackage;

class Sms extends Model
{
    protected $table = 'smses';
    protected $guarded = [];

    public function groupSms($allowedUserIds, $disallowedUserIds, $allowedUserPackageIds, $text)
    {
        $sms = Sms::create(['text' => $text , 'type' => 'group']);
        $targetUsers = User::query();
        if(!empty($allowedUserIds))
        {
            $targetUsers->whereIn('id', $allowedUserIds);
        }
        if(!empty($disallowedUserIds))
        {
            $targetUsers->whereNotIn('id', $disallowedUserIds);
        }
        if(!empty($allowedUserPackageIds))
        {
            $targetUsers->whereIn('package_id', $allowedUserPackageIds);
        }
        $targetUsers = $targetUsers->get();

        Notification::send($targetUsers, new FarazSMSNotification($sms));

        foreach ($allowedUserIds ?? [] as $allowedUserId)
        {
            GroupSmsLog::query()
                ->create([
                    'sms_id' => $sms->id,
                    'target_type' => User::class,
                    'target_id' => $allowedUserId,
                    'is_allowed' => true,
                ]);
        }

        foreach ($disallowedUserIds ?? [] as $disallowedUserId)
        {
            GroupSmsLog::query()
                ->create([
                    'sms_id' => $sms->id,
                    'target_type' => User::class,
                    'target_id' => $disallowedUserId,
                    'is_allowed' => false,
                ]);
        }

        foreach ($allowedUserPackageIds ?? [] as $allowedUserPackageId)
        {
            GroupSmsLog::query()
                ->create([
                    'sms_id' => $sms->id,
                    'target_type' => UserPackage::class,
                    'target_id' => $allowedUserPackageId,
                    'is_allowed' => true,
                ]);
        }

    }
    public function groupSmsAllowedUserPackage()
    {
        $allowedUserPackageIds = GroupSmsLog::query()
            ->where('sms_id', $this->id)
            ->where('target_type', UserPackage::class)
            ->where('is_allowed', 1)
            ->get()
            ->pluck('target_id');

        return UserPackage::query()
            ->whereIn('id', $allowedUserPackageIds)
            ->get(['id', 'title']);
    }

    public function groupSmsDisAllowedUsers()
    {
        $allowedUserIds = GroupSmsLog::query()
            ->where('sms_id', $this->id)
            ->where('target_type', User::class)
            ->where('is_allowed', 0)
            ->get()
            ->pluck('target_id');

        return User::query()
            ->whereIn('id', $allowedUserIds)
            ->get(['id', 'first_name', 'last_name']);
    }

    public function groupSmsAllowedUsers()
    {
        $allowedUserIds = GroupSmsLog::query()
            ->where('sms_id', $this->id)
            ->where('target_type', User::class)
            ->where('is_allowed', 1)
            ->get()
            ->pluck('target_id');

        return User::query()
            ->whereIn('id', $allowedUserIds)
            ->get(['id', 'first_name', 'last_name']);
    }

    public function scopeGroup($query)
    {
        return $query->where('type', 'group');
    }


    public static function sendVerificationSMS($phoneNumber, $code)
    {
        Http::get('http://ippanel.com:8080/?apikey=CTORNhL_LPwplY7nAcAOC4zK0O2q2TSRzhnUW3EYRq0=&pid=6bjy4zr8hm&fnum=3000505&tnum='.$phoneNumber.'&p1=code&v1='.$code);
        $smsText = "VERIFICATION CODE:". $code;
        $sms = Sms::create(['text' => $smsText, 'type' => 'single']);
        $bulkId = FarazSMS::send([$phoneNumber],$smsText);
        SmsLog::query()
            ->create([
                'sms_id' => $sms->id,
                'bulk_id' => $bulkId,
                'from_number' => '+983000505',
                'to_number' => $phoneNumber,
                'to_user_id' => null,
                'text' => $sms->text,
            ]);
    }
}
