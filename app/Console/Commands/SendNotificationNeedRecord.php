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

class SendNotificationNeedRecord extends Command
{
    protected $telegramService;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:notificationNeedRecord';

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
        $this->telegramService = new TelegramService();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $records = Record::whereDate('start', Carbon::today()->addDay(-21))->get();

        foreach ($records as $record) {
            $user = User::find($record->user_id);

            if ($user) {

                $nextEvent = Record::whereDate('start', '>=', Carbon::today())->where('user_id', $user->id)->get();

                if ($nextEvent->isEmpty()) {

                    $this->telegramService->sendNotificationNeedRecord($user);
                }
            }
        }
    }
}
