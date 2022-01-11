<?php

namespace App\Services;

use App\Notifications\NotificationNewRecord;
use App\Presenters\Record\RecordPresenter;
use Illuminate\Support\Facades\Notification;

class TelegramService
{
  public function sendNotificationNewRecord($user, $record){
      $data = [
          'name' => $user->name,
          'phone' => $user->phone,
          'time' => (new RecordPresenter($record))->time(),
          'date' => (new RecordPresenter($record))->startDate(),
      ];
      Notification::route('telegram', config('config_telegram.TELEGRAM_ADMIN_ID'))
          ->notify(new NotificationNewRecord($data));
  }
}