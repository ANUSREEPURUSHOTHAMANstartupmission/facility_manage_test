<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Route;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $abilities = [
            'index' => 'view',
            'edit' => 'edit',
            'show' => 'view',
            'update' => 'edit',
            'create' => 'add',
            'store' => 'add',
            'destroy' => 'delete'
        ];

        $route_list = Route::getRoutes();

        $permissions = [];
        $permission_split = [];

        foreach($route_list as $key => $route){

            $action = $route->getActionName();

            if($action != "Closure"){

                $middleware = $route->controllerMiddleware();

                if(in_array('role',$middleware)){

                    $action_split = explode('@', $action);

                    $namespace_split = explode('\\', $action_split[0]);

                    $action_name = end($action_split);

                    $action_name = array_key_exists($action_name, $abilities) ? $abilities[$action_name] : $action_name;

                    $controller_name = strtolower(str_replace("Controller","",end($namespace_split)));
                    $namespace = count($namespace_split)-2 >= 0 ? strtolower($namespace_split[count($namespace_split)-2]) : '';

                    $permission_name = $namespace && $namespace!="controllers" ? $namespace.":".$controller_name.":".$action_name : $controller_name.":".$action_name;

                    $this->command->info($permission_name);

                    $permission = Permission::firstOrCreate(
                        ["name" => $permission_name], ["type" => $namespace]
                    );

                    $permissions[] = $permission->id;
                    $permission_split[$namespace][] = $permission->id;

                }

            }
            
        }

        // $this->command->info(var_dump($permissions));
        // $this->command->info(var_dump($permission_split));

        $super = Role::firstOrCreate(
            ["name" => "super"]
        );

        $super->permissions()->syncWithoutDetaching($permissions);

        foreach(array_keys($permission_split) as $item){
            if($item != "controllers"){
                $role = Role::firstOrCreate(
                    ["name" => $item], ["type"=> $item]
                );

                $role->permissions()->syncWithoutDetaching($permission_split[$item]);
                $role->permissions()->syncWithoutDetaching($permission_split['controllers']);
            }
        }

    }
}
