@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Lista de Grupos
                    <div style="float: right;">
                    {{
                        link_to_route(
                            'roles.newGet',
                            $title = 'Novo Grupo',
                            $parameters = array(),
                            $attributes = array()
                        )
                    }}
                    </div>
                </div>

                <div class="panel-body">
                    <table style="width: 90%;">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Ações</th>
                            </tr>
                            <tbody>
                                @forelse ($roles as $role)
                                <tr>
                                    <td>{{ $role->id }}</td>
                                    <td>{{ $role->name }}</td>
                                    <td>
                                        {{
                                            link_to_route(
                                                'roles.editGet',
                                                $title = 'Editar',
                                                $parameters = array($role->id),
                                                $attributes = array()
                                            )
                                         }}

                                         {{
                                            link_to_route(
                                                'acl.roleGet',
                                                $title = 'Permissões',
                                                $parameters = array($role->id),
                                                $attributes = array()
                                            )
                                         }}
                                     </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3">
                                        <span>Sem grupos para listar</span>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </thead>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection