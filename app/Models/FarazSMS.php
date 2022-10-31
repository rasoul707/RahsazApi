<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use IPPanel\Client;
use Modules\SMS\Entities\Sms;

class FarazSMS extends Model
{
    public static function send($receiverPhones, $message)
    {
        $client = new Client(env('SMS_TOKEN'));
        $bulkID = $client->send(
            "+983000505",          // originator
            $receiverPhones,    // recipients
            $message // message
        );
        return $bulkID;
    }

    public static function sendGroup($receiverPhones, $message)
    {
        $client = new Client(env('SMS_TOKEN'));
        $bulkID = $client->send(
            "+983000505",          // originator
            $receiverPhones,    // recipients
            $message // message
        );
        return $bulkID;
    }
}
