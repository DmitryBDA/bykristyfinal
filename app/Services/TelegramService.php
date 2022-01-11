<?php

namespace App\Services;

use App\Notifications\NotificationNewRecord;
use Illuminate\Support\Facades\Notification;

class TelegramService
{
  public function sendNotificationNewRecord($data){
      Notification::route('telegram', config('config_telegram.TELEGRAM_ADMIN_ID'))
          ->notify(new NotificationNewRecord($data));
  }
}
