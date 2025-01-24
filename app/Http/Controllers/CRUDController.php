<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class CRUDController extends Controller
{
  public $model, $table, $heading;

  public function index()
  {
    $table = (new $this->table())->setup();

    $heading = $this->heading;
    $subheading = "Overview";

    return view('components.table-page', compact('table', 'heading', 'subheading'));
  }

  public function store(Request $request){
    $this->validateStore($request);        

    $new_item = new $this->model();

    $this->saveItem($new_item, $this->storeData($request, $new_item));

    $this->storeAdvanced($new_item, $request);

    flash("Success|".$this->heading." added successfully", "success");

    return redirect()->back();
  }

  public function storeAdvanced($item, $request){
    return;
  }

  public function update($id, Request $request){

    $item = $this->model::findOrFail($id);

    $this->validateUpdate($request, $item);        

    $this->saveItem($item, $this->updateData($request, $item));

    $this->updateAdvanced($item, $request);

    flash("Success|".$this->heading." updated successfully", "success");

    return redirect()->back();
  }

  public function updateAdvanced($item, $request){
    return;
  }

  public function destroy($id){
    $item = $this->model::findOrFail($id);
    $item->delete();

    flash("Success|".$this->heading." deleted successfully", "success");

    return redirect()->back();
  }

  public function saveItem($item, $data){
    foreach($data as $key => $value){
        $item[$key] = $value;
    }
    if(count($data)){
      $item->save();
    }
  }

  public function validateItem($request, $rules){
    $request->validate($rules);
  }

  public function storeData($request, $item){
    return [];
  }

  public function updateData($request, $item){
    return [];
  }

  public function validateStore($request){
    //validate store function
  }
  
  public function validateUpdate($request, $item){
    //validate update function
  }

}
