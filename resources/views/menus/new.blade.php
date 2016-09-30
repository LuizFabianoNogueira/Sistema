@extends('layouts.app')

@section('content')

            {{
                Form::open(
                    array(
                        'route' => 'menus.newPost',
                        'method' => 'post'
                    )
                )
            }}

            <p>Geração de novo menu</p>

            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                <select name="parent_id">
                    <option value="0">Selecione</option>
                    @foreach($menus as $menu)
                        <option value="{{ $menu->id  }}">
                            {{ $menu->grupo }} | {{ $menu->name }} | {{ $menu->route }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                {{
                    Form::label(
                        'name',
                        'Nome (exibução)',
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
                            (isset($menu->name) ? $menu->name:'')
                        )
                    }}
                    @if ($errors->menu->first('name'))
                        <span class="help-block">
                            <strong>{{ $errors->menu->first('name') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('route') ? ' has-error' : '' }}">
                {{
                    Form::label(
                        'route',
                        'Rota',
                        array(
                            'class' => 'col-md-4 control-label',
                            'for'=>'route'
                        )
                    )
                }}
                <div class="col-md-6">
                    {{
                        Form::text(
                            'route',
                            (isset($menu->route) ? $menu->route:'')
                        )
                    }}
                    @if ($errors->menu->first('route'))
                        <span class="help-block">
                        <strong>{{ $errors->menu->first('route') }}</strong>
                    </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('grupo') ? ' has-error' : '' }}">
                {{
                    Form::label(
                        'grupo',
                        'Grupo',
                        array(
                            'class' => 'col-md-4 control-label',
                            'for'=>'grupo'
                        )
                    )
                }}
                <div class="col-md-6">
                    {{
                        Form::text(
                            'grupo',
                            (isset($menu->grupo) ? $menu->grupo:'')
                        )
                    }}
                    @if ($errors->menu->first('grupo'))
                        <span class="help-block">
                        <strong>{{ $errors->menu->first('grupo') }}</strong>
                    </span>
                    @endif
                </div>
            </div>

            <div>
                {{ Form::submit("Salvar", array('class' => 'btn btn-primary')) }}
            </div>

        {{ Form::close() }}

@endsection
