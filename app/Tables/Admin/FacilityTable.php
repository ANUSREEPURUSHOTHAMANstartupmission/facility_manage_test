<?php

namespace App\Tables\Admin;

use App\Models\Facility;
use App\Tables\CRUDTable;
use Illuminate\Database\Eloquent\Builder;
use Okipa\LaravelTable\Table;

class FacilityTable extends CRUDTable
{
    public function __construct()
    {
        $this->model = Facility::class;
        $this->routes = [
            'index'   => ['name' => 'admin.facilities.index'],
            'create'  => ['name' => 'admin.facilities.create'],
            'edit'    => ['name' => 'admin.facilities.edit'],
            'destroy' => ['name' => 'admin.facilities.destroy'],
            'show' => ['name' => 'admin.facilities.show']
        ];
        $this->confirm = "Are you sure you want to delete the facilities ?";
    }

    public function tableAdv($table){
        return $table->query(function (Builder $query){

            $query->select('facilities.*');
            $query->addSelect('locations.name as location_name');
            $query->join('locations', 'locations.id', '=', 'facilities.location_id');
            $query->whereIn('facilities.location_id',auth()->user()->locations->pluck('id')->toArray());
            
        });
    }

    protected function columns(Table $table): void
    {
        $table->column('name')->title('Name')->sortable()->searchable();
        $table->column('location_name')->title('Location')->sortable()->searchable('locations', ['name']);
        $table->column('type')->title('Type');
        $table->column('qty')->title('Quantity');
    }

}
