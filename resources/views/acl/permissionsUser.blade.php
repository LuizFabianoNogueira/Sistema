@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">

			{{ Form::open(array('route' => 'acl.userPost', 'method' => 'post')) }}
            {{ Form::hidden('user_id', $user->id) }}

                @if (isset($user) && $user)
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Permissões de Usuários
                    </div>
                    <div class="panel-body">

                        <table style="width: 95%;">
                            <thead>
                                <tr>
                                    <th> Route </th>
                                    <th> Action </th>
                                    <th> Controller </th>
                                    <th style="text-align: center;">
                                        {{ $user->name }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody>

                                @forelse ($actions as $action)
                                    <tr style="border-bottom: dashed 1px #CCC;">
                                        <td> {{ $action->name }} </td>
                                        <td> {{ $action->action }} </td>
                                        <td> {{ $action->controller }} </td>
                                        <td style="text-align: center;">
                                        <fieldset>
                                            <legend>
                                                <input {{ (isset($permissions[$action->id]) ? 'checked="checked"':'') }} type="checkbox" name="userSet[{{ $action->id }}]"> Usar
                                                
                                            </legend>

                                                <input {{ (!isset($permissions[$action->id]) ? 'checked="checked"':'') }} type="radio" group="{{ $action->id }}" name="user[{{ $user->id  }}][{{ $action->id }}]" value="0"> Negado

                                                <input {{ (isset($permissions[$action->id]) ? 'checked="checked"':'') }} type="radio" group="{{ $action->id }}" name="user[{{ $user->id  }}][{{ $action->id }}]" value="1"> Permitido
                                        </fieldset>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td> sem acções para listar </td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table>

                    </div>
                </div>
                @endif

            {{ Form::submit("Save", array('class' => 'btn btn-primary')) }}

            {{ Form::close() }}
        </div>
    </div>
</div>

@endsection

