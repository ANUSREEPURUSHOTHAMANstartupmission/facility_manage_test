<?php

namespace App\Console\Commands;

use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ReleasePending extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pending:release';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Release Pending Bookings';

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
    public function handle()
    {
        $pending = Booking::where('status','pending')->where('created_at', '<', Carbon::now()->subHour()->toDateTimeString())->get();
        $this->info($pending);
        foreach($pending as $item){
            $item->delete();
            // $item->status = 'cancelled';
            // $item->save();
        }
    }
}
