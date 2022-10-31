<?php

namespace App\Channels;

use Illuminate\Notifications\Notification;
use Modules\SMS\Entities\SmsLog;

class FarazSMSChannel
{
    public function send($notifiable, Notification $notification) {

        if (method_exists($notifiable, 'routeNotificationForFarazSMS')) {
            $phoneNumber = $notifiable->routeNotificationForFarazSMS($notifiable);
        } else {
            $phoneNumber = $notifiable->getKey();
        }

        $data = method_exists($notification, 'toFarazSMS') ? $notification->toFarazSMS($notifiable) : $notification->toArray($notifiable);

        if (empty($data) || empty($phoneNumber)) {
            return;
        }


        return true;
    }
}
