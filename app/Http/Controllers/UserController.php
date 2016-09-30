<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\RoleUser;
use Validator;
use Redirect;

class UserController extends Controller
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

    /**
     * view com lista de usuários
     * @return [view]
     */
    public function listGet()
    {
        return view('users.users', ['users' => User::where('active', 1)->get()]);
    }

    /**
     * view com formulario para edição de dados do usuario
     * @param  [id] $id
     * @return [view]
     */
    public function editGet($id)
    {
        $ObjRoles = Role::where('active', 1)->get();
        if($ObjRoles)
        {
            $dados['roles'] = $ObjRoles;
        }
        if($id)
        {
            $user = User::find($id);
            $user_roles = array();
            foreach ($user->roles as $role)
            {
                $user_roles[$role->id] = 1;
            }
            $dados['user'] = $user;
            $dados['user_roles'] = $user_roles;
        }
        return view('users.user_edit', $dados);
    }

    /**
     * edita dados do usuário
     * @param  Request $request
     * @return [validation][redirect view]
     */
    public function editPost(Request $request)
    {
        $messages = array(
            'required' => 'The :attribute name is required.',
        );

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'email|required',
        ], $messages);

        if ($validator->fails())
        {
            return Redirect::route('users.userGetFormEdit', array($request->id))->withErrors($validator)->withInput();
        }
        else
        {
            #elimi os vinculos para refazer
            $user = User::find($request->input('id'));
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            if($user->save())
            {
                $roles = $request->input('role');
                foreach ($roles as $role_id => $r)
                {
                    $ObjRoleUser = RoleUser::where('role_id', $role_id)
                        ->where('user_id', $user->id)
                        ->first();
                    if($ObjRoleUser)
                    {
                        $ObjRoleUser->delete();
                    }
                }

                foreach ($roles as $role_id => $r)
                {
                    $user_role = new RoleUser;
                    $user_role->user_id = $user->id;
                    $user_role->role_id = $role_id;
                    $user_role->save();
                }
            }

            return Redirect::route('users.listGet');
        }
    }
}
