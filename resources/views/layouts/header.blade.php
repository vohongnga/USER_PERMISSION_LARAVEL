<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laravel</title>
    <link href="/resources/assets/style.css" rel="stylesheet">
    <link href="{{ asset('admin/css/style.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/solid.css">
    <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
<script>
$('select').selectpicker();
</script>
</head>
<body>
    <div class ="header p-2" style="display:flex; justify-content:space-between;">
        <h5>Laravel</h5>
        <form method = "post" action = "{{route('logout')}}" style="display: inline">
            @csrf
            <button class = "btn btn-outline-primary" >LOGOUT</button>
        </form>
    </div>
    @if (session()->has('msgF'))
    <div class="alert alert-warning">
        {{ session()->get('msgF') }}
    </div>
@endif
@if (session()->has('msgS'))
    <div class="alert alert-success">
        {{ session()->get('msgS') }}
    </div>
@endif
@php
    $uri = Request::fullUrl();
    $sideBar  = array(
        'home' =>'Dashboard',
        'users' => 'Users',
        'roles' => 'Roles',
        'permissions' => 'Permissions',

    );

@endphp
    <div>
        <div class="row">
            <div class ="col-md-3 col-lg-3 p-3">
                <ul style="list-style-type: none; margin: 0" class="p-2 mx-auto">
                    @foreach($sideBar as $route=>$text)
                    @php
                        $check = strpos($uri,$route);
                        if($check !=false)
                        $active = 'style="color:red"';
                        else
                        $active = "";
                    @endphp
                    <li><a href="{{route($route.'.index')}}"><span {!!$active!!}>{{$text}}</span></a></li>
                    @endforeach
                </ul>
            </div>
