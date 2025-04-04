<?php

use App\Console\Commands\CollectUserPaths;
use Illuminate\Support\Facades\Schedule;

Schedule::command(CollectUserPaths::class)
    ->everyTenMinutes()
    ->withoutOverlapping();

