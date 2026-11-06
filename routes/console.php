<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('scrape:tender-lpse')->everySixHours();
Schedule::command('scrape:lelang-sirup')->everySixHours();
Schedule::command('app:auto-respon')->everySecond();
Schedule::command('app:notifikasi-tender')->everyTwoSeconds();