<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->


    <title>{{ config('app.name', 'Stock') }}</title>
    <link rel="stylesheet" href="{{ asset('fonts/icomoon/style.css') }}">



    <!-- Bootstrap CSS -->
    <link rel="stylesheet"   href="{{ asset('css/bootstrap.min.css') }}">

    <!-- Style -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

  <style>



	</style>

</head>
<body>
<div class="cover-spin"></div>

        @yield('content')


    <!-- Scripts -->

</body>
</html>
