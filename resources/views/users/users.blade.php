@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Usuários do Sistema</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-wrench"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="#">Config option 1</a>
                            </li>
                            <li><a href="#">Config option 2</a>
                            </li>
                        </ul>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">

                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Nome</th>
                            <th>E-mail</th>
                            <th>Grupos</th>
                            <th>Ações</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td> {{ $user->id  }}</td>
                            <td> {{ $user->name }} </td>
                            <td> {{ $user->email }}  </td>

                            <td>
                                <ul>
                                @forelse($user->roles as $role)
                                    <li>{{ $role->name }}</li>
                                @empty
                                    <li>Sem Grupos</li>
                                @endforelse
                                </ul>

                            </td>
                            <td>
                                XXXXX
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>



<a href=" {{ route('users.newGet')  }}" >new</a>






<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Lista de Usuários
                    <div style="float: right;">
                    {{
                        link_to_route(
                            'users.listGet',
                            $title = 'Novo Usuário',
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
                            <th>E-mail</th>
                            <th>Grupos</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <ul>
                                        @forelse ($user->roles as $role)
                                            <li>{{ $role->name }} </li>
                                        @empty
                                            <li><span>Sem Grupos</span></li>
                                        @endforelse
                                    </ul>
                                </td>
                                <td>
                                    {{
                                        link_to_route(
                                            'users.editGet',
                                            $title = 'Editar',
                                            $parameters = array($user->id),
                                            $attributes = array('class' => 'teste')
                                        )
                                    }}

                                    {{
                                        link_to_route(
                                            'acl.userGet',
                                            $title = 'Permissao',
                                            $parameters = array($user->id),
                                            $attributes = array('class' => 'teste')
                                        )
                                    }}
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="2"> <span>Sem Usuários</span> </td></tr>
                        @endforelse
                    </tbody>
                </table>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection