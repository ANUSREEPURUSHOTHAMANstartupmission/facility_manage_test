<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $guard = null)
    {

        if (Auth::guard($guard)->check()) {

            if($this->_check_role($request)){
                return $next($request);
            }

        }
        else{
            session()->put('url.intended', url()->current());
            return redirect('/login');
        }

        return redirect('nopermission');
    }

    private function _check_role($request){

        $abilities = [
            'index' => 'view',
            'edit' => 'edit',
            'show' => 'view',
            'update' => 'edit',
            'create' => 'add',
            'store' => 'add',
            'destroy' => 'delete'
        ];
    
        $action = $request->route()->getActionName();
    
        $action_split = explode('@', $action);
    
        $namespace_split = explode('\\', $action_split[0]);
    
        $action_name = end($action_split);
    
        $action_name = array_key_exists($action_name, $abilities) ? $abilities[$action_name] : $action_name;
    
        $controller_name = strtolower(str_replace("Controller","",end($namespace_split)));
        $namespace = count($namespace_split)-2 >= 0 ? strtolower($namespace_split[count($namespace_split)-2]) : '';
    
        
        $permission_name = $namespace && $namespace!="controllers" ? $namespace.":".$controller_name.":".$action_name : $controller_name.":".$action_name;

        // dd(Auth::user()->role);
        $permissions = array_column(Auth::user()->role->permissions->toArray(),"name");

        if(in_array($permission_name,$permissions)){
            return true;
        }
        else{
            return false;
        }
        
    }
}