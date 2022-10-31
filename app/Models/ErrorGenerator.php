<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use IPPanel\Client;
use Modules\SMS\Entities\Sms;

class ErrorGenerator
{
    public static function error($message)
    {
        return response()->json([
            'message' => $message,
            'errors' => [
                'error' => $message,
            ]
        ], 422);
    }

}
