<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CleanSessions extends Command
{
    protected $signature = 'session:clean';
    protected $description = 'Clean up expired sessions';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        DB::table('sessions')->truncate();
    }
}
