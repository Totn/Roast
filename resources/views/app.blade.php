<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css">

    <link rel="icon" type="image/x-icon" href="/favicon.ico">

    <title>Roast</title>


    <script type="text/javascript">
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
<body>
    <div id="app">
        <route-view></route-view>
    </div>

    <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
</body>
</html>