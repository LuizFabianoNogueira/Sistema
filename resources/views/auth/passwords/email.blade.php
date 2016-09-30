<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title> {{ trans('Solicitar redefinição de senha')  }} </title>

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
                        <h5>{{ trans("passwords.titulo") }} </h5>
                    </div>
                    <div class="ibox-content">

                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif

                        {{
                            Form::open(
                                [
                                    'route' => 'password.email',
                                    'method' => 'post',
                                    'class' => 'form-horizontal'
                                ]
                            )
                        }}

                            <p>{{ trans("passwords.descricao")  }}</p>
                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label class="col-lg-3 control-label">
                                    {{ trans("passwords.email")  }}
                                </label>

                                <div class="col-lg-9">
                                    <input name="email" placeholder="Email" class="form-control">
                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-9    ">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-btn fa-envelope"></i> Solicitar
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

</div>
</body>
</html>

