<!DOCTYPE html>
<html lang="en">
<head>
    <title>{{$title}}</title>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{asset('public/css/main.css')}}">

</head>
<body>
    <div class="container app">
        <div class="row app-one">
            @include('user.sidebar')
            @yield('content')
        </div>
    </div>   
</body>   
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="{{asset('public/js/bootstrap.min.js')}}"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
<script src="{{asset('public/js/custom.js')}}"></script>

</html>