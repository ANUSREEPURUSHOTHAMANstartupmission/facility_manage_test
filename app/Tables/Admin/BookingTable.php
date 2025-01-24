<?php

namespace App\Tables\Admin;

use App\Models\Booking;
use App\Tables\CRUDTable;
use Illuminate\Database\Eloquent\Builder;
use Okipa\LaravelTable\Abstracts\AbstractTable;
use Okipa\LaravelTable\Table;

class BookingTable extends CRUDTable
{
    public function __construct()
    {
        $this->model = Booking::class;
        $this->routes = [
            'index'   => ['name' => 'admin.bookings.index'],
            'create'  => ['name' => 'admin.bookings.create'],
            // 'edit'    => ['name' => 'admin.bookings.edit'],
            // 'destroy' => ['name' => 'admin.bookings.destroy'],
            'show' => ['name' => 'admin.bookings.show']
        ];
        $this->confirm = "Are you sure you want to delete the bookings ?";
    }

    public function tableAdv($table){
        return $table->query(function (Builder $query){

            $query->select('bookings.*');
            $query->addSelect('locations.name as location_name');
            $query->addSelect('users.name as user_name');
            $query->addSelect('users.email as user_email');
            $query->addSelect('users.organisation as user_org');
            
            $query->leftJoin('locations', 'locations.id', '=', 'bookings.location_id');
            $query->leftJoin('users', 'users.id', '=', 'bookings.user_id');

            $query->whereIn('bookings.location_id',auth()->user()->locations->pluck('id')->toArray());

            if(request()->input('sort_by') == null) $query->orderBy('created_at', 'desc');

        });
    }

    protected function columns(Table $table): void
    {
        $table->column('location_name')->title('Location')->sortable()->searchable('locations', ['name']);
        $table->column('user_name')->title('Booked By')->sortable()->searchable('users', ['name']);
        $table->column('user_email')->title('Email')->sortable()->searchable('users', ['email']);
        $table->column('user_org')->title('Organisation')->sortable()->searchable('users', ['organisation']);
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
