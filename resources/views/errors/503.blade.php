<!DOCTYPE html>
<html>
    <head>
        <title>Error.</title>

        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                color: #000;
                display: table;
                font-weight: 600;
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
                font-size: 50px;
                margin-bottom: 40px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <div><img src="{{asset('images/Alert-icon.png')}}" width="100" height="100"></div>
                <div class="title">An error has occured! Please contact your system administrator.</div>
                <a href="{{URL::to('/')}}">Go back to system</a>
            </div>
        </div>
    </body>
</html>
