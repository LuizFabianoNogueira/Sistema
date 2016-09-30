@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading"> Grupos de Menus </div>

                    <div class="panel-body">
                        <ul>
                        @foreach($grupos as $grupo)
                        <li>
                            <a href=" {{ route('menus.listMenuGrupoGet', [$grupo->grupo]) }}"> {{ $grupo->grupo }}</a>
                             - @if($grupo->active == 1)
                                   Ativo
                               @else
                                    Inativo
                               @endif
                        </li>
                        @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
