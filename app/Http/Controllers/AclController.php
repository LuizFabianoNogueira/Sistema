<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Action;
use App\Models\Role;
use App\Models\User;
use App\Models\Permission;
use Validator;
use Redirect;
use Gate;
use Illuminate\Hashing\BcryptHasher;
use Illuminate\Support\Facades\Auth;

class AclController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /********************
    * PERMISSÕES        *
    * ******************/

     /**
     * Lista as permissoes do grupo
     * @return [view]
     */
    public function roleGet($id)
    {
        $dados = array();
        if($id)
        {
            $ObjRole = Role::where('active', TRUE)->where('id', $id)->first();
            if($ObjRole) 
            {
                $ObjPermission = Permission::where('role_id', $ObjRole->id)->where('permission', TRUE)->get();
                $dados['role'] = $ObjRole; 
            }
        }

        $permissions = array();
        if($ObjRole)
        {
            if($ObjPermission)
            {
                foreach ($ObjPermission as $ObjPermissionItem)
                {
                    $permissions[$ObjPermissionItem->action_id] = $ObjPermissionItem->action_id;
                }
                $dados['permissions'] = $permissions;
            }
            
            $ObjActions = Action::where('active', TRUE)->get();
            if($ObjActions){ $dados['actions'] = $ObjActions; }
        }

        return view('acl.permissionsRole', $dados);
    }

    /**
     * Lista as permissoes do grupo
     * @return [view]
     */
    public function userGet($id)
    {
        $dados = array();
        if($id)
        {
            $ObjUser = User::where('active', TRUE)->where('id', $id)->first();
            if($ObjUser)
            {
                $ObjPermission = Permission::where('user_id', $ObjUser->id)->where('permission', TRUE)->get();
                if($ObjUser){ $dados['user'] = $ObjUser; }
            }
        }

        $permissions = array();
        if($ObjUser)
        {
            if($ObjPermission)
            {
                foreach ($ObjPermission as $ObjPermissionItem)
                {
                    $permissions[$ObjPermissionItem->action_id] = $ObjPermissionItem->action_id;
                }
                $dados['permissions'] = $permissions;
            }
            $ObjActions = Action::where('active', TRUE)->get();
            if($ObjActions){ $dados['actions'] = $ObjActions; }
        }

        return view('acl.permissionsUser', $dados);
    }

    public function rolePost(Request $request)
    {
        $roles = $request->input('role');
        if($roles)
        {
            foreach ($roles as $role_id => $actions)
            {
                foreach ($actions as $action_id => $a)
                {
                    $permission = Permission::where('role_id', $role_id)->where('action_id', $action_id)->get();
                    if(isset($permission->id) && $permission->id > 0)
                    {
                        $permission->permission = $a;
                        $permission->save();
                    }
                    else
                    {
                        $permission = new Permission;
                        $permission->role_id = $role_id;
                        $permission->action_id = $action_id;
                        $permission->permission = $a;
                        $permission->save();
                    }
                }
            }
        }

        return Redirect::route('roles.listGet');

    }

    public function userPost(Request $request)
    {
        $user_id = $request->input('user_id');
        if(isset($user_id) && $user_id > 0)
        {
            $usersSet = $request->input('userSet');
            $users = $request->input('user');

            $this->dellAllPermissionsUser($user_id);
            foreach ($usersSet as $action_id => $a)
            {
                $permission = new Permission;
                $permission->user_id = $user_id;
                $permission->action_id = $action_id;
                $permission->permission = ($a ? TRUE:FALSE);
                $permission->save();
            }
        }
        return Redirect::route('users.listGet');
    }

    protected function dellAllPermissionsUser($id)
    {
        $ObjPermission = Permission::where('user_id', $id)->get();
        if($ObjPermission)
        {
            foreach ($ObjPermission as $ObjPermissionItem)
            {
                $ObjPermissionDelete = Permission::find($ObjPermissionItem->id);
                $ObjPermissionDelete->delete();
            }
        }
    }

    /**
     * aplica as permissoes ao sistema
     * @return [type] [description]
     */
    public function police()
    {
        if (Auth::check())
        {
            $ObjUser = User::where('id', Auth::id())->first();
            if($ObjUser && $ObjUser->active)
            {
                $TypePolice = env('APP_POLICE');
                if($TypePolice == "SESSION")
                {
                    foreach ($ObjUser->roles as $role)
                    {
                        if(isset($role->id) && $role->id > 0)
                        {
                            $roles[$role->id] = $role->id;
                        }
                    }

                    if(is_array($roles) && count($roles)>0)
                    {
                        $ObjPermissionRole = Permission::
                        select('action_id', 'permission')
                        ->distinct()
                        ->whereIn('role_id', $roles)
                        ->where('permission', 1)
                        ->orderBy('action_id', 'ASC')
                        ->get()
                        ;
                    }

                    $PoliceSession = array();

                    if($ObjPermissionRole)
                    {
                        foreach ($ObjPermissionRole as $ObjPermissionRoleItem)
                        {
                            if($ObjPermissionRoleItem->action)
                            {
                                $permission = $ObjPermissionRoleItem->permission;
                                $RouteName = $ObjPermissionRoleItem->action->name;
                                $PoliceSession['P'][$this->hashPolice($RouteName)] = $permission;
                            }
                        }
                    }

                    $ObjPermission = Permission::
                        select('action_id', 'permission')
                        ->distinct()
                        ->where('user_id', Auth::id())
                        ->orderBy('action_id', 'ASC')
                        ->get()
                        ;
                    
                    if($ObjPermission)
                    {
                        foreach ($ObjPermission as $ObjPermissionItem)
                        {
                           if($ObjPermissionItem->action)
                           {
                                $permission = $ObjPermissionItem->permission;
                                $RouteName = $ObjPermissionItem->action->name;
                                $PoliceSession['P'][$this->hashPolice($RouteName)] = $permission;
                            }
                        }
                    }

                    if(isset($PoliceSession) && is_array($PoliceSession) && count($PoliceSession)>0)
                    {
                        session($PoliceSession);
                    }
                }
                return redirect()->route('home');
            }
            else
            {
                abort(403, 'Usuário Inativo!');
            }
        }
    }


    /*****************************
    * metodos internos da classe *
    * ***************************/

    protected function hashPolice($string)
    {
        #este metodo deve ser clonado em Filters
        $custo = '08';
        $salt = 'Cf1f11ePArKlBJomM0F6aL';
        return crypt($string, '$2a$' . $custo . '$' . $salt . '$');
    }



    protected function validatorUser(array $data)
    {
        $messages = array(
            'required' => 'The :attribute is required.',
        );
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'email|required|unique:users',
            'password'  =>  'required|min:6|confirmed',
            'password_confirmation'  =>  'required|min:6',
            'role_id' => 'required'
        ], $messages);
    }


}
