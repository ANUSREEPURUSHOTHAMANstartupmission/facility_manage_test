<?php

namespace App\Http\Controllers;

use App\Models\Facility;
use App\Tables\MyBooking;
use Illuminate\Http\Request;

class HomeController extends CRUDController
{

    public function __construct()
    {
        $this->middleware('role'); 
        $this->model = Booking::class;
        $this->heading = "My Booking";
        $this->table = MyBooking::class;
        $this->view = 'admin.bookings';
    }

    
}
