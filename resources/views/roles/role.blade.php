@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    @if(isset($role->id))
                    Editando Grupo [id={{ $role->id }}]
                    @else
                    Novo Grupo
                    @endif
                    <div style="float: right;">
                        {{
                            link_to_route(
                                'roles.listGet',
                                $title = 'Listar Grupos',
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
                            'route' => 'roles.newPost',
                            'method' => 'post'
                        )
                    )
                }}

                @if(isset($role->id))
                {{
                    Form::hidden(
                        'id',
                        $role->id
                    )
                }}
                @endif

                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
					{{
                        Form::label(
                            'name',
                            'Nome do Grupo',
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
                            (isset($role->name) ? $role->name:'')
                        )
                    }}
                        @if ($errors->role->first('name'))
                            <span class="help-block">
                                <strong>{{ $errors->role->first('name') }}</strong>
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

