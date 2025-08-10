<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('files:clean')->hourly();
