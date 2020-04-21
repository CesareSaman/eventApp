<?php

namespace App\Console\Commands;

use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Console\Command;

class deletePastEvents extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pastEvents:Delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete events which their end date is about one month ago';

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
     * @return mixed
     */
    public function handle()
    {
        Event::whereDate('event_end_date','<=',Carbon::now()->subMonth(1))
            ->delete();
    }
}
