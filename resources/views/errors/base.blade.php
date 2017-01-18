<!DOCTYPE html>
<html>
    <head>
        <title>@yield('title')</title>

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
                font-weight: 700;
                font-family: 'Lato', sans-serif;
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
            .error-link,
            .error-link:visited,
            .error-link:active,
            .error-link:focus {
            color: #1c80b1;
            display: inline-block;
            font-size: 30px;
            font-weight: 700;
            margin-top: -20px;
            text-decoration: none;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <div class="title">@yield('title')</div>
                  @if (URL::previous())
                  <a href="{{ URL::previous() }}" class="error-link">Back</a>
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  @endif
                  <a href="/" class="error-link">Home</a>
            </div>
        </div>
    </body>
</html>
