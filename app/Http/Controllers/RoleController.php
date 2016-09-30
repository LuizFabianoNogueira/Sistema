<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use Validator;
use Redirect;


class RoleController extends Controller
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
     * GRUPOS            *
     * ******************/

    /**
     * view com lista dos grupos
     * @return [type] [description]
     */
    public function listGet()
    {
        return view('roles.roles', ['roles' => Role::All()]);
    }

    /**
     * view para novo grupo
     * @param  [int] $id
     * @return [view]
     */
    public function newGet()
    {
        return view('roles.role');
    }

    /**
     * view para editar grupo
     * @param  [int] $id
     * @return [view]
     */
    public function editGet($id)
    {
        return view('roles.role', ['role' => Role::find($id)]);
    }

    /**
     * recebe post de grupo novo/edição
     * @param  Request $request | role
     * @return [view]
     */
    public function newPost(Request $request)
    {
        $validator = $this->validatorRole($request->all());
        if ($validator->fails())
        {
            return Redirect::route('roles.roleGetForm')->withErrors($validator, 'role');
        }
        else
        {
            $role = new Role();
            $id = $request->input('id');
            if($id)
            {
                $role = Role::find($id);
            }
            $role->name = $request->input('name');
            $role->save();
            return Redirect::route('roles.listGet');
        }
    }

    protected function validatorRole(array $data)
    {
        $messages = array(
            'required' => 'The :attribute name is required.',
        );
        return Validator::make($data, [
            'name' => 'required|max:255',
        ], $messages);
    }
}
