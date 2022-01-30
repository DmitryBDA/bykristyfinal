<?php

namespace App\Providers;

use App\Services\TelegramService;
use Illuminate\Support\ServiceProvider;


class TelegramServiceProvider extends ServiceProvider
{

    public function boot()
    {

    }

    public function register()
    {
      $this->app->bind(TelegramService::class, function ($app) {
        $obTelegramService = new TelegramService();
        $obTelegramService->setTelegramAdminId(config('config_telegram.TELEGRAM_ADMIN_ID'));
        return $obTelegramService;
      });
    }
}
