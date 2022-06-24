<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!-- BOOTSTRAP CSS -->
    <link href="{{asset('assets/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" />

    <!-- STYLE CSS -->
    <link href="{{asset('assets/css/style.css')}}" rel="stylesheet" />

    <!--tinymce -->
    <script src="{{ asset('tinymce/tinymce.min.js') }}"></script>

</head>

<body>
    @yield('header')
    <x-flash-messages />
    @yield('content')
    @yield('header')

    @yield('javascript')


</body>

</html>