<!DOCTYPE html>
<html>
    <head>
        <title>{{ $exception->getMessage() }}</title>

        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">



        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                color: #B0BEC5;
                display: table;
                font-weight: 100;
                font-family: 'Lato';
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 72px;
                margin-bottom: 40px;
            }
            .btn
            {
                text-decoration: none;
                font-size: 20px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <div class="title">
                Olá... <br />
                A página que você solicitou não existe!<br />
                {{ $exception->getMessage() }}
                </div>
                {{ link_to_route('home', $title = 'Voltar', $parameters = array(), $attributes = array('class' => 'btn')) }}
            </div>
        </div>
    </body>
</html>
