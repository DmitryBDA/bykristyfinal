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

class SendNotificationMySelfRecord extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:notificationMySelfRecord';

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
        $records = Record::whereDate('start', Carbon::today()->addDay(1))
            ->where('status', 4)
            ->orderBy('start', 'asc')
            ->get();

        foreach ($records as $record) {
          $telegramService->sendNotificationMySelfRecord($record);
        }
    }
}
