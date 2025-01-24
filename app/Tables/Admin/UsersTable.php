<?php

namespace App\Tables\Admin;

use App\Models\User;
use App\Tables\CRUDTable;
use Illuminate\Database\Eloquent\Builder;
use Okipa\LaravelTable\Abstracts\AbstractTable;
use Okipa\LaravelTable\Table;

class UsersTable extends CRUDTable
{

    public function __construct()
    {
        $this->model = User::class;
        $this->routes = [
            'index'   => ['name' => 'admin.users.index'],
            'create'  => ['name' => 'admin.users.create'],
            'edit'    => ['name' => 'admin.users.edit'],
            'destroy' => ['name' => 'admin.users.destroy'],
        ];
        $this->confirm = "Are you sure you want to delete the user ?";
    }

    public function tableAdv($table)
    {
        return $table->query(function (Builder $query){
            $query->select('users.*');
            $query->addSelect('roles.name as role');
            $query->addSelect('users.name as user_name');
            $query->join('roles', 'roles.id', '=', 'users.role_id');
        });
    }

    /**
     * Configure the table columns.
     *
     * @param \Okipa\LaravelTable\Table $table
     *
     * @throws \ErrorException
     */
    protected function columns(Table $table): void
    {
        $table->column('user_name')->title('Name')->sortable()->searchable('users',['name']);
        $table->column('email')->title('Email')->sortable()->searchable();
        $table->column('phone')->title('Phone')->sortable()->searchable();
        $table->column('role')->title('Role')->sortable()->searchable('roles', ['name']);
        $table->column('status')->title('Status')->sortable()->searchable();
        $table->column()->title('Resend')
            ->link(function(User $user){
                return route('admin.users.resend', $user);
            })->button(['btn', 'btn-sm', 'btn-info'])->appendsHtml(config('laravel-table.icon.send'), true);
    }

    /**
     * Configure the table result lines.
     *
     * @param \Okipa\LaravelTable\Table $table
     */
    protected function resultLines(Table $table): void
    {
        //
    }
}
