<?php

namespace App\Tables\Admin;

use App\Models\Location;
use App\Models\User;
use App\Tables\CRUDTable;
use Illuminate\Database\Eloquent\Builder;
use Okipa\LaravelTable\Abstracts\AbstractTable;
use Okipa\LaravelTable\Table;

class LocationUsers extends CRUDTable
{
    public $location;

    public function __construct(Location $location)
    {
        $this->location = $location;
        $this->model = User::class;
        $this->routes = [
            'index'   => ['name' => 'admin.locations.index'],
            'create' => ['name' => 'admin.locations.assign', 'params' => ['location' => $location->id]],
            'destroy' => ['name' => 'admin.locations.detach', 'params' => ['location' => $location->id]]
        ];
        $this->confirm = "Are you sure you want to detach this startup ?";
    }

    public function tableAdv($table)
    {
        return $table->query(function (Builder $query){
            $query->whereHas('locations', function($q){
                $q->where('id', $this->location->id);
            });
        });
    }
    
    protected function columns(Table $table): void
    {
        $table->column('name')->title('Name')->sortable()->searchable();
        $table->column('email')->title('Email')->sortable()->searchable();
        $table->column('phone')->title('Phone')->sortable()->searchable();
    }
}
