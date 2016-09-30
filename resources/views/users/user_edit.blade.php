@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Editando Usuário [id={{ $user->id }}]
                    <div style="float: right;">
                        {{
                            link_to_route(
                                'users.listGet',
                                $title = 'Listar Usuários',
                                $parameters = array(),
                                $attributes = array()
                            )
                        }}
                    </div>
                </div>

                <div class="panel-body">

				{{
                    Form::open(
                        array(
                            'route' => 'users.editPost',
                            'method' => 'post'
                        )
                    )
                }}

                {{
                    Form::hidden(
                        'id',
                        $user->id
                    )
                }}

                <div class="form-group">
                    <fieldset>
                        <legend>Grupos</legend>

                        <table style="width:90%;">
                                <tr>
                                    {{--*/ $td = 0 /*--}}
                                    @foreach ($roles as $role)
                                    <td>
                                        {{
                                            Form::checkbox(
                                                'role['.$role->id.']',
                                                '',
                                                (isset($user_roles[$role->id]) ? array('checked' => 'checked') : array() )
                                            )
                                        }}

                                        {{ $role->name }}
                                    </td>

                                        {{--*/ $td++ /*--}}
                                        @if ($td == 4)
                                            </tr>
                                            <tr>
                                            {{--*/ $td = 0 /*--}}
                                        @endif

                                    @endforeach
                                </tr>
                        </table>
                    </fieldset>
                </div>

                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    {{
                        Form::label(
                            'name',
                            'Nome do Usuário',
                            array(
                                'class' => 'col-md-4 control-label',
                                'for'=>'name'
                            )
                        )
                    }}
                    <div class="col-md-6">
                        {{
                            Form::text(
                                'name',
                                $user->name
                            )
                        }}
                        @if ($errors->user->first('name'))
                            <span class="help-block">
                                <strong>{{ $errors->user->first('name') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
					{{
                        Form::label(
                            'email',
                            'E-mail',
                            array(
                                'class' => 'col-md-4 control-label',
                                'for'=>'email'
                            )
                        )
                    }}
                    <div class="col-md-6">
    					{{
                            Form::text(
                                'email',
                                $user->email
                            )
                        }}
                        @if ($errors->user->first('email'))
                            <span class="help-block">
                                <strong>{{ $errors->user->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                
                <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                <br />
                        {{ Form::submit("Salvar", array('class' => 'btn btn-primary')) }}
                    </div>
                </div>
                
                {{ Form::close() }}

                </div>
            </div>
        </div>
    </div>
</div>

@endsection

