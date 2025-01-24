<?php

namespace App\Tables\Admin;

use App\Models\Location;
use App\Tables\CRUDTable;
use Okipa\LaravelTable\Table;

class LocationTable extends CRUDTable
{
    public function __construct()
    {
        $this->model = Location::class;
        $this->routes = [
            'index'   => ['name' => 'admin.locations.index'],
            'create'  => ['name' => 'admin.locations.create'],
            'edit'    => ['name' => 'admin.locations.edit'],
            'destroy' => ['name' => 'admin.locations.destroy'],
            'show' => ['name' => 'admin.locations.show']
        ];
        $this->confirm = "Are you sure you want to delete the locations ?";
    }

    protected function columns(Table $table): void
    {
        $table->column('name')->title('Name')->sortable()->searchable();
        $table->column('district')->title('District')->sortable()->searchable();
    }

}
