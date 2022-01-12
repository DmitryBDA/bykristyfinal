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
    public function sendNotificationNewRecord($user, $record)
    {
        $data = [
            'name' => $user->name,
            'phone' => $user->phone,
            'time' => (new RecordPresenter($record))->time(),
            'date' => (new RecordPresenter($record))->startDate(),
        ];
        Notification::route('telegram', config('config_telegram.TELEGRAM_ADMIN_ID'))
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
        Notification::route('telegram', config('config_telegram.TELEGRAM_ADMIN_ID'))
            ->notify(new NotificationTomorrowRecord($data));
    }

    public function sendNotificationNeedRecord($user)
    {
        $data = [
            'name' => $user->name,
            'phone' => $user->phone,
        ];
        Notification::route('telegram', config('config_telegram.TELEGRAM_ADMIN_ID'))
            ->notify(new NotificationNeedRecord($data));
    }

    public function sendNotificationMySelfRecord($record)
    {
        $data = [
            'title' => $record->title,
            'time' => (new RecordPresenter($record))->time(),
        ];
        Notification::route('telegram', config('config_telegram.TELEGRAM_ADMIN_ID'))
            ->notify(new NotificationMySelfRecord($data));
    }
}
