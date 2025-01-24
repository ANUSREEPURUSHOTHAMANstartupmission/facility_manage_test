<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Facility;
use App\Models\Image;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function __construct()
    {
        $this->middleware('role'); 
    }

    public function store(Facility $facility, Request $request){
        $image = $request->input('image');

        list($type, $image) = explode(';', $image);
        list(, $image)      = explode(',', $image);
        $image = base64_decode($image);

        $image_name= time().'.png';
        $path = storage_path('app/images/'.$image_name);
        file_put_contents($path, $image);

        $item = new Image();
        $item->image = $image_name;
        $item->facility_id = $facility->id;
        $item->save();

        flash("Success|Image added successfully", "success");
        return redirect()->back();

    }

    public function destroy($id){
        $item = Image::findOrFail($id);
        $item->delete();
    
        flash("Success|Image deleted successfully", "success");
    
        return redirect()->back();
    }

}
