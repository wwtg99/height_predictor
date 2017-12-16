<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="/assets/height_predictor/images/favicon.ico" />

    <title>{{ config('app.name') }}</title>

    <!-- Fonts -->
    {{--<link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">--}}

    <!-- Styles -->
    @section('css')
        {{--<link rel="stylesheet" href="/css/app.css">--}}
    @show

</head>
<body>
<div id="app">
    <predictor-home></predictor-home>
</div>
<!-- Javascript -->
@section('js')
    <script src="/assets/height_predictor/js/app.js"></script>
@show
</body>
</html>
