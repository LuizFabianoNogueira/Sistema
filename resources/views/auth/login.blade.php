<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title> {{ trans('login.Login')  }}</title>

    <link href=" {{ asset('css/bootstrap.min.css') }} " rel="stylesheet">
    <link href=" {{ asset('font-awesome/css/font-awesome.css') }} " rel="stylesheet">

    <link href=" {{ asset('css/plugins/toastr/toastr.min.css') }} " rel="stylesheet">

    <link href=" {{ asset('css/animate.css') }} " rel="stylesheet">
    <link href=" {{ asset('css/style.css') }} " rel="stylesheet">

</head>

<body class="no-skin-config">

<div class="wrapper wrapper-content animated fadeInRight" style="padding-top: 10%;">

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>
                            {{ trans('login.Login') }}
                        </h5>

                        <div class="ibox-content">

                        {{ Form::open(array('route' => 'auth.loginPost', 'method' => 'post', 'class' => 'form-horizontal')) }}

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email" class="col-md-4 control-label"> {{ trans('login.Endereço de e-mail') }} </label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}">

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="password" class="col-md-4 control-label"> {{ trans('login.Senha') }} </label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" name="password">

                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="remember"> {{ trans('login.Lembrar') }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-btn fa-sign-in"></i> {{ trans('login.Enviar')  }}
                                    </button>

                                    <a class="btn btn-link" href="{{ url('/password/reset') }}">{{ trans('login.Não Lembro minha senha!')  }}</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>