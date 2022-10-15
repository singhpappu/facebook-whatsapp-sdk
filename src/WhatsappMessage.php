<?php

namespace LaravelNotification\Whatsapp;

use Illuminate\Notifications\Notification;
use LaravelNotification\Whatsapp\Traits\SharedObjects;

class WhatsappMessage
{
   use SharedObjects;

   protected $body;

   public function __construct()
   { 
      $this->payload['messaging_product'] = 'whatsapp';
   }

   public function body($body = null)
   {
      $this->body = $body;

      return $this;
   }

}
