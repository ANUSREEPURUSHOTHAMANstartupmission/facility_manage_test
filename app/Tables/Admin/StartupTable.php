<?php

namespace App\Tables\Admin;

use App\Models\Startup;
use App\Tables\CRUDTable;
use Okipa\LaravelTable\Table;

class StartupTable extends CRUDTable
{
    public function __construct()
    {
        $this->model = Startup::class;
        $this->routes = [
            'index'   => ['name' => 'admin.startups.index'],
            'create'  => ['name' => 'admin.startups.create'],
            'edit'    => ['name' => 'admin.startups.edit'],
            'destroy' => ['name' => 'admin.startups.destroy'],
        ];
        $this->confirm = "Are you sure you want to delete the startups ?";
    }

    protected function columns(Table $table): void
    {
        $table->column('name')->title('Name')->sortable()->searchable();
        $table->column('website')->title('Website')->sortable()->searchable();
        $table->column('state')->title('State')->sortable()->searchable();
    }

}
