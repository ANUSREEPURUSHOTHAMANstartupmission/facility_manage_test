<?php

namespace App\Console\Commands;

use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class TodaysBooking extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'booking:today';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get todays bookings';

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
        $bookings = Booking::whereDate('start', Carbon::today())->where(function($q){
            $q->where('status', 'confirmed')->orWhere('status', 'approved');
        })->orderBy('start')->get()->groupBy(function($booking){
            return $booking->location->district;
        });

        $text = "*Todays Bookings*\n\n";

        if($bookings->count() == 0){
            $text .= "No bookings";
        }

        foreach($bookings as $location => $location_booking)
        {
            $text .= "*" . $location . "*\n---------------------------------------------\n";

            foreach($location_booking as $booking)
            {
                $start = Carbon::parse($booking->start);
                $end = Carbon::parse($booking->end);
                $text .= $start->format('d M, H:i A') ." - ". ($start->isSameDay($end) ? $end->format('H:i A') : $end->format('d M, H:i A'));
                
                $text .= "\n*".$booking->user->name."* - ".$booking->user->organisation. "\n";

                $items = $booking->facilities->pluck('name')->toArray();

                $text .= implode(", ", $items) . "\n";

                $text .= "Purpose: *". $booking->purpose . "*\n";

                $text .= "Status: *". $booking->status . "*";
                $text .= "\n\n";
            }
        }

        Http::get('https://api.telegram.org/bot'.config('telegram.token').'/sendMessage',[
            'chat_id' => config('telegram.chat'),
            'text' => $text,
            'parse_mode' => 'markdown'
        ]);
        
    }
}
