<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Menu;
use Illuminate\Support\Facades\Input;
use Validator;
use Redirect;
use Illuminate\Support\Facades\DB;

class MenuController extends Controller
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

    public function listGruposGet()
    {
        $grupos = Menu::select('grupo', 'active')
            ->distinct()
            ->get();

        return view('menus.list_grupos', ['grupos' => $grupos]);
    }

    private function getChild($parent_id)
    {
        $retorno = array();
        $menus = Menu::select('id', 'name', 'route', 'order', 'grupo', 'active')
            ->where('parent_id', $parent_id)
            ->orderBy('order', 'ASC')
            ->get()
            ->toArray();
        foreach ($menus as $menu)
        {
            $menu['childs'] = $this->getChild($menu['id']);
            $retorno[] = $menu;
        }
        return $retorno;
    }

    public function listMenuGrupoGet($grupo)
    {
        $retorno = array();
        $menus = Menu::select('id', 'name', 'route', 'order', 'grupo', 'active')
            ->where('parent_id', '<=', 0)
            ->orwhere('parent_id', null)
            ->where('grupo', $grupo)
            ->orderBy('order', 'ASC')
            ->get();

        foreach ($menus as $menu)
        {
            $m = $menu->toArray();
            $m['childs'] = $this->getChild($menu->id);
            $retorno[] = $m;
        }

        return view('menus.list_grupo', ['menus' => $retorno, 'grupo' => $grupo]);
    }

    public function newGet()
    {
        $menus = Menu::where('active', 1)->get();
        return view('menus.new', ['menus' => $menus]);
    }

    public function newPost()
    {
        $grupo = Input::get('grupo');
        $inputs = Input::all();
        $validator = $this->validator($inputs);
        if ($validator->fails())
        {
            return Redirect::route('menus.newGet')->withErrors($validator, 'menu');
        }
        else
        {
            $menu = new Menu();
            $menu->fill($inputs);
            $menu->save();

            return Redirect::route('menus.listMenuGrupoGet', [$grupo]);
        }
    }

    private function saveChildren($itens, $parent_id, $dadosDB)
    {
        $order = 1;
        foreach ($itens as $iten)
        {
            $id = (int)$iten['id'];

            $menu = Menu::find($id);
            $menu->parent_id = $parent_id;
            $menu->order = $order;
            $save = $menu->save();

            if(isset($iten['children']) && is_array($iten['children']) && count($iten['children']))
            {
                $this->saveChildren($iten['children'], $id, $dadosDB);
            }

            $order++;
        }
    }

    public function updatePost()
    {
        $dados = Input::get('dados');
        if(is_array($dados) && count($dados) > 0)
        {
            $result_grupo = Menu::select('grupo')->where('id', $dados[0]['id'])->first();
            $grupo = $result_grupo->grupo;
            if(!empty($grupo))
            {
                $ResultDadosDB = Menu::where('grupo', $grupo)->get()->toArray();
                $dadosDB = array();
                foreach ($ResultDadosDB as $ResultDadosDBitem)
                {
                    $dadosDB[$ResultDadosDBitem['id']] = $ResultDadosDBitem;
                }

                $order = 1;
                foreach ($dados as $dadoItem)
                {
                    $id = (int)$dadoItem['id'];

                    $menu = Menu::find($id);
                    $menu->parent_id = null;
                    $menu->order = $order;
                    $menu->save();

                    if(isset($dadoItem['children']) && is_array($dadoItem['children']) && count($dadoItem['children']))
                    {
                        $this->saveChildren($dadoItem['children'], $dadoItem['id'], $dadosDB);
                    }
                    $order++;
                }
            }
        }

        return json_encode(['result' => 'Menu Atualizado!']);
    }


    protected function validator(array $data)
    {
        $messages = array(
            'required' => 'The :attribute name is required.',
        );
        return Validator::make($data, [
            'name' => 'required|max:255',
            'route' => 'required|max:255',
            'grupo' => 'required|max:255',
        ], $messages);
    }
}
