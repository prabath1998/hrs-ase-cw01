<?php

use Illuminate\Support\Facades\Schedule;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

// Schedule::command('app:cancel-unconfirmed-reservations')
//     ->dailyAt('19:00');

// Schedule::command('app:process-no-shows')
//     ->dailyAt('19:00');

Schedule::command('app:cancel-unconfirmed-reservations')
    ->everyMinute();

Schedule::command('app:process-no-shows')
    ->everyMinute();
