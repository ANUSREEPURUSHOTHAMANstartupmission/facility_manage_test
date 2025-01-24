<?php

namespace App\Tables\Admin;

use App\Models\Holiday;
use App\Tables\CRUDTable;
use Okipa\LaravelTable\Table;

class HolidayTable extends CRUDTable
{
    public function __construct()
    {
        $this->model = Holiday::class;
        $this->routes = [
            'index'   => ['name' => 'admin.holidays.index'],
            'create'  => ['name' => 'admin.holidays.create'],
            'edit'    => ['name' => 'admin.holidays.edit'],
            'destroy' => ['name' => 'admin.holidays.destroy'],
            // 'show' => ['name' => 'admin.holidays.show']
        ];
        $this->confirm = "Are you sure you want to delete the holidays ?";
    }

    protected function columns(Table $table): void
    {
        $table->column('date')->title('Date')->sortable()->searchable();
        $table->column('name')->title('Name')->sortable()->searchable();
    }

}
