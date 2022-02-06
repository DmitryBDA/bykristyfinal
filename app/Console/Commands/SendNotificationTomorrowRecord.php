<?php

namespace App\Console\Commands;

use App\Models\Event;
use App\Models\Record;
use App\Models\User;
use App\Models\UserEvent;
use App\Notifications\TelegramSendReminder;
use App\Services\TelegramService;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Notification;
use Jenssegers\Date\Date;

class SendNotificationTomorrowRecord extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:notificationTomorrowRecord';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(TelegramService $telegramService)
    {
        $records = Record::whereDate('start', Carbon::today()->addDay(1))->whereIn('status', [2, 3])->get();

        foreach ($records as $record) {
            $user = User::find($record->user_id);
            if ($user) {
              $telegramService->sendNotificationTomorrowRecord($user, $record);
            }
        }
    }
}
