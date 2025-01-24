<?php

namespace App\Http\Controllers\Admin;

use App\Exports\BookingExport;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function __construct()
    {
        $this->middleware('role'); 
    }
    
    public function export(Request $request){

        $start = $request->start ?? Carbon::now()->subMonth()->toDateString();
        $end = $request->end ?? Carbon::now()->toDateString();

        return Excel::download(new BookingExport($start, $end), 'booking.xlsx');

    }
}
