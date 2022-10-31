<?php

namespace App\Notifications;

use App\Models\FarazSMS;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Modules\SMS\Entities\Sms;
use Modules\SMS\Entities\SmsLog;

class FarazSMSNotification extends Notification implements ShouldQueue
{
    use Queueable;
    public $sms;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Sms $sms)
    {
        $this->sms = $sms;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['farazsms'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toFarazSMS($notifiable)
    {

        $bulkId = FarazSMS::send([$notifiable->phone_number],$this->sms->text);
        SmsLog::query()
            ->create([
                'sms_id' => $this->sms->id,
                'bulk_id' => $bulkId,
                'from_number' => '+983000505',
                'to_number' => $notifiable->phone_number,
                'to_user_id' => @$notifiable->id,
                'text' => $this->sms->text,
            ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'phone_number' => $notifiable->phone_number
        ];
    }
}
