<?php

namespace Modules\Form\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Form\Events\FormSubmittedEvent;

class Form extends Model
{
    protected $table = 'forms';
    protected $guarded = [];

    const FORM_TYPES = [
        'تماس با ما',
        'درخواست همکاری و نمایندگی',
        'انتقادات، پیشنهادات و شکایات',
    ];

    protected static function booted()
    {
        static::created(function (Form $form){
            //FormSubmittedEvent::dispatch($form);
        });
    }
}
