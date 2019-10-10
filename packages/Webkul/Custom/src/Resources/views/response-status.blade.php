<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500" rel="stylesheet" type="text/css">
    </head>

    <body style="font-family: montserrat, sans-serif;">
        <div class="static-container one-column">
            @if ($data)
                <h1>Response submission successful.</h1>
            @else
                <h1>Response submission failed.</h1>
            @endif
        </div>

        <div class="redirect-box">
            <a href="{{ route('shop.home.index') }}">Click here to go back...</a>
        </div>
    </body>
</html>