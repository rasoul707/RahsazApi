<?php

namespace Modules\InternalMessage\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\User\Entities\User;

class InternalMessage extends Model
{
   protected $table = 'internal_messages';
   protected $guarded = [];

   public function send($fromId, $toId, $text)
   {
       InternalMessage::query()
           ->create([
               'from_user_id' => $fromId,
               'to_user_id' => $toId,
               'text' => $text,
           ]);
   }

   /* relations */
    public function fromUser()
    {
        return $this->hasOne(User::class, 'id', 'from_user_id')->select('id', 'first_name', 'last_name');
    }
}
