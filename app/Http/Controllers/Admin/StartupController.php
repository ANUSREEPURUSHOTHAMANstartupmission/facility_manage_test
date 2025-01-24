<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\CRUDController;
use App\Models\Role;
use App\Models\Startup;
use App\Models\User;
use App\Notifications\WelcomeNotification;
use App\Tables\Admin\StartupTable;
use Grosv\LaravelPasswordlessLogin\LoginUrl;
use Illuminate\Http\Request;

class StartupController extends CRUDController
{
    public function __construct()
    {
        $this->middleware('role'); 
        $this->model = Startup::class;
        $this->heading = "Startups";
        $this->table = StartupTable::class;
        $this->view = 'admin.startups';
    }


    public function create(){
        return view('admin.startups.create');
    }

    public function edit(Startup $startup){
        $image = $startup->logo;
        $startup->logo = "data:image/png;base64,".base64_encode(file_get_contents(storage_path('app/logos/'.$image)));

        return view('admin.startups.edit', compact('startup'));
    }

    public function validateStore($request)
    {
        $this->validateItem($request, [
            'name' => 'required',
            'website' => 'required',
            'dipp' => 'required',
            'state' => 'required',
            'founder' => 'required',
            'email' => "required|email|unique:users,email",
            "phone" => "required",
            'logo' => 'required'

        ]);
    }

    public function storeData($request, $item)
    {
        $image = $request->logo;

        list($type, $image) = explode(';', $image);
        list(, $image)      = explode(',', $image);
        $image = base64_decode($image);

        $image_name= time().'.png';
        $path = storage_path('app/logos/'.$image_name);
        file_put_contents($path, $image);

        return [
            "name" => $request->input('name'),
            "website" => $request->input('website'),
            "dipp" => $request->input('dipp'),
            "state" => $request->input('state'),
            "uid" => $request->input('uid'),
            "logo" => $image_name
        ];
    }

    public function storeAdvanced($item, $request)
    {
        $user = new User();
        $user->name = $request->input('founder');
        $user->email = $request->input('email');
        $user->phone = $request->input('phone');
        $user->status = 'active';

        $role = Role::where('name','startup')->first();

        $user->role_id = $role->id;

        $user->entity_type = Startup::class;
        $user->entity_id = $item->id;

        $user->save();

        if($request->input('notify') == 'notify')
        {    
            $generator = new LoginUrl($user);
            $generator->setRedirectUrl('/home'); // Override the default url to redirect to after login
            $url = $generator->generate();

            $user->notify(new WelcomeNotification($url));
        }
    }

    public function validateUpdate($request, $item)
    {
        $this->validateItem($request, [
            'name' => 'required',
            'website' => 'required',
            'dipp' => 'required',
            'state' => 'required',
            'logo' => 'required'
        ]);
    }

    public function updateData($request, $item)
    {
        $image = $request->logo;

        list($type, $image) = explode(';', $image);
        list(, $image)      = explode(',', $image);
        $image = base64_decode($image);

        $image_name= time().'.png';
        $path = storage_path('app/logos/'.$image_name);
        file_put_contents($path, $image);

        if($item->logo){
            unlink(storage_path('app/logos/'.$item->logo));
        }

        return [
            "name" => $request->input('name'),
            "website" => $request->input('website'),
            "dipp" => $request->input('dipp'),
            "state" => $request->input('state'),
            "uid" => $request->input('uid'),
            "logo" => $image_name
        ];
    }

}
