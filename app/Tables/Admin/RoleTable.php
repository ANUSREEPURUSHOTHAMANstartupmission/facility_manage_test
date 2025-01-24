<?php

namespace App\Tables\Admin;

use App\Http\Controllers\CRUDController;
use App\Models\Role;
use App\Tables\CRUDTable;
use Okipa\LaravelTable\Table;

class RoleTable extends CRUDTable
{
    public function __construct()
    {
        $this->model = Role::class;
        $this->routes = [
            'index'   => ['name' => 'admin.roles.index'],
            'create'  => ['name' => 'admin.roles.create'],
            'edit'    => ['name' => 'admin.roles.edit'],
            'destroy' => ['name' => 'admin.roles.destroy'],
        ];
        $this->confirm = "Are you sure you want to delete the role ?";
    }

    protected function columns(Table $table): void
    {
        $table->column('name')->title('Name')->sortable()->searchable();
        $table->column('description')->title('Description')->sortable()->searchable();
        $table->column('type')->title('Type')->sortable()->searchable();
    }

}
