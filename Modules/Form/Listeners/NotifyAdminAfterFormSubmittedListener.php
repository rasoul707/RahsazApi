<?php

namespace Modules\Form\Listeners;

use App\Mail\FormSubmitted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use Modules\Form\Entities\Form;
use Modules\Form\Events\FormSubmittedEvent;

class NotifyAdminAfterFormSubmittedListener implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(FormSubmittedEvent $event)
    {
        Mail::to([env("ADMIN_EMAIL", "erfaansabouri@gmail.com")])
            ->queue(new FormSubmitted($event->form));
    }
}
