<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\CRUDController;
use App\Models\Facility;
use App\Models\Rate;
use Illuminate\Http\Request;

class RateController extends CRUDController
{
    public function __construct()
    {
        $this->middleware('role'); 
        $this->model = Rate::class;
    }

    public function create(Facility $facility){
        return view('admin.rates.create', compact('facility'));
    }

    public function validateStore($request)
    {
        $this->validateItem($request, [
            'name' => 'required',
            'rate' => 'required',
            'hours' => 'required',
            'facility_id' => 'required|exists:facilities,id',
        ]);
    }

    public function storeData($request, $item)
    {
        return [
            "name" => $request->input('name'),
            "rate" => $request->input('rate'),
            "hours" => $request->input('hours'),
            "facility_id" => $request->input('facility_id'),
        ];
    }

    public function edit(Facility $facility, Rate $rate){
        return view('admin.rates.edit', compact('facility', 'rate'));
    }

    public function validateUpdate($request, $item)
    {
        $this->validateItem($request, [
            'name' => 'required',
            'rate' => 'required',
            'hours' => 'required',
        ]);
    }

    public function updateData($request, $item)
    {
        return [
            "name" => $request->input('name'),
            "rate" => $request->input('rate'),
            "hours" => $request->input('hours'),
        ];
    }
    
}
