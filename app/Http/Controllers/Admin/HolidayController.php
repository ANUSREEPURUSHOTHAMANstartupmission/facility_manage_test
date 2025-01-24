<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\CRUDController;
use App\Models\Holiday;
use App\Models\User;
use App\Tables\Admin\HolidayTable;
use Illuminate\Http\Request;

class HolidayController extends CRUDController
{
    public function __construct()
    {
        $this->middleware('role'); 
        $this->model = Holiday::class;
        $this->heading = "Holidays";
        $this->table = HolidayTable::class;
        $this->view = 'admin.holidays';
    }


    public function create(){
        return view('admin.holidays.create');
    }

    public function edit(Holiday $holiday){        
        return view('admin.holidays.edit', compact('holiday'));
    }

    public function validateStore($request)
    {
        $this->validateItem($request, [
            'name' => 'required',
            'date' => 'required',
        ]);
    }

    public function storeData($request, $item)
    {
        return [
            "name" => $request->input('name'),
            "date" => $request->input('date'),
        ];
    }

    public function validateUpdate($request, $item)
    {
        $this->validateItem($request, [
            'name' => 'required',
            'date' => 'required',
        ]);
    }

    public function updateData($request, $item)
    {
        return [
            "name" => $request->input('name'),
            "date" => $request->input('date'),
        ];
    }

}
