<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\CRUDController;
use App\Models\Permission;
use App\Models\Role;
use App\Tables\Admin\RoleTable;
use Illuminate\Http\Request;

class RoleController extends CRUDController
{
    public function __construct()
    {
        $this->middleware('role'); 
        $this->model = Role::class;
        $this->heading = "Roles";
        $this->table = RoleTable::class;
        $this->view = 'admin.roles';
    }

    public function create(){
        $perms = Permission::orderBy('name')->get();
        return view('admin.roles.create', compact('perms'));
    }

    public function edit(Role $role){
        $perms = Permission::orderBy('name')->get();
        $current = array_column($role->permissions->toArray(),"id");
        return view('admin.roles.edit', compact('perms', 'role', 'current'));
    }

    public function validateStore($request)
    {
        $this->validateItem($request, [
            'name' => 'required|unique:roles,name|max:50|min:4',
            'description' => 'required|max:50',
        ]);
    }

    public function storeData($request, $item)
    {
        return [
            "name" => $request->input('name'),
            "description" => $request->input('description'),
            "type" => $request->input('type'),
        ];
    }

    public function storeAdvanced($item, $request)
    {
        $item->permissions()->sync($request->permissions);
    }

    public function validateUpdate($request, $item)
    {
        $this->validateItem($request, [
            'name' => 'required|max:50|min:4|unique:roles,name,'.$item->id,
            'description' => 'required|max:50',
        ]);
    }

    public function updateData($request, $item)
    {
        return [
            "name" => $request->input('name'),
            "description" => $request->input('description'),
            "type" => $request->input('type'),
        ];
    }

    public function updateAdvanced($item, $request)
    {
        $item->permissions()->sync($request->permissions);
    }
}
