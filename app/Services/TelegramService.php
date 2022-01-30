<?php

namespace App\Services;

use App\Notifications\NotificationMySelfRecord;
use App\Notifications\NotificationNeedRecord;
use App\Notifications\NotificationNewRecord;
use App\Notifications\NotificationTomorrowRecord;
use App\Presenters\Record\RecordPresenter;
use Illuminate\Support\Facades\Notification;

class TelegramService
{
    private $telegramAdminId;

    public function setTelegramAdminId($telegramId){
      $this->telegramAdminId = $telegramId;
    }
    public function sendNotificationNewRecord($user, $record)
    {
        $data = [
            'name' => $user->name,
            'phone' => $user->phone,
            'time' => (new RecordPresenter($record))->time(),
            'date' => (new RecordPresenter($record))->startDate(),
        ];
        Notification::route('telegram', $this->telegramAdminId)
            ->notify(new NotificationNewRecord($data));
    }

    public function sendNotificationTomorrowRecord($user, $record)
    {
        $data = [
            'name' => $user->name,
            'phone' => $user->phone,
            'time' => (new RecordPresenter($record))->time(),
            'date' => (new RecordPresenter($record))->startDate(),
        ];
        Notification::route('telegram', $this->telegramAdminId)
            ->notify(new NotificationTomorrowRecord($data));
    }

    public function sendNotificationNeedRecord($user)
    {
        $data = [
            'name' => $user->name,
            'phone' => $user->phone,
        ];
        Notification::route('telegram', $this->telegramAdminId)
            ->notify(new NotificationNeedRecord($data));
    }

    public function sendNotificationMySelfRecord($record)
    {
        $data = [
            'title' => $record->title,
            'time' => (new RecordPresenter($record))->time(),
        ];
        Notification::route('telegram', $this->telegramAdminId)
            ->notify(new NotificationMySelfRecord($data));
    }
}
