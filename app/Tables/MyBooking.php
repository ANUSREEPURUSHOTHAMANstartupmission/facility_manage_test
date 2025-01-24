<?php

namespace App\Tables;

use App\Models\Booking;
use Illuminate\Database\Eloquent\Builder;
use Okipa\LaravelTable\Abstracts\AbstractTable;
use Okipa\LaravelTable\Table;

class MyBooking extends CRUDTable
{
    public function __construct()
    {
        $this->model = Booking::class;
        $this->routes = [
            'index'   => ['name' => 'home'],
            // 'create'  => ['name' => 'admin.bookings.create'],
            // 'edit'    => ['name' => 'admin.bookings.edit'],
            // 'destroy' => ['name' => 'admin.bookings.destroy'],
            'show' => ['name' => 'booking.view']
        ];
        $this->confirm = "Are you sure you want to delete the bookings ?";
    }

    public function tableAdv($table){
        return $table->query(function (Builder $query){

            $query->select('bookings.*');
            $query->addSelect('locations.name as location_name');
            $query->join('locations', 'locations.id', '=', 'bookings.location_id');
            $query->where('user_id',auth()->user()->id);
            
            if(request()->input('sort_by') == null) $query->orderBy('created_at', 'desc');
            
        });
    }

    protected function columns(Table $table): void
    {
        $table->column('location_name')->title('Location')->sortable()->searchable('locations', ['name']);
        $table->column('start')->title('Start Date')->sortable()->searchable();
        $table->column('end')->title('End Date')->sortable()->searchable();
        $table->column('status')->title('Status')->html(function(Booking $booking){
            
            $class = $booking->status=="pending"? 'bg-red':'';
            $class .= $booking->status=="requested"? 'bg-azure':'';
            $class .= $booking->status=="approved"? 'bg-orange':'';
            $class .= $booking->status=="confirmed"? 'bg-green':'';

            return '<span class="badge '.$class.'">'.$booking->status.'</span>';

        })->sortable()->searchable();
    }
}
