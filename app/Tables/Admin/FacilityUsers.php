<?php

namespace App\Tables\Admin;

use App\Models\Facility;
use App\Models\User;
use App\Tables\CRUDTable;
use Illuminate\Database\Eloquent\Builder;
use Okipa\LaravelTable\Abstracts\AbstractTable;
use Okipa\LaravelTable\Table;

class FacilityUsers extends CRUDTable
{
    public $facility;

    public function __construct(Facility $facility)
    {
        $this->facility = $facility;
        $this->model = User::class;
        $this->routes = [
            'index'   => ['name' => 'admin.facilities.index'],
            'create' => ['name' => 'admin.facilities.assign', 'params' => ['facility' => $facility->id]],
            'destroy' => ['name' => 'admin.facilities.detach', 'params' => ['facility' => $facility->id]]
        ];
        $this->confirm = "Are you sure you want to detach this startup ?";
    }

    public function tableAdv($table)
    {
        return $table->query(function (Builder $query){
            $query->whereHas('facilities', function($q){
                $q->where('id', $this->facility->id);
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
