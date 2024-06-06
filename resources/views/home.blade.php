<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="{{asset('images/logo.jpg')}}" type="image/gif" sizes="any">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <title>Home page</title>
</head>
<body>
<h1 style="margin-top: 10px; text-align: center">Home Page</h1>
@if (session('successLogout'))
    <div class="alert alert-info" id="logoutMessage" style="width: 300px; margin-left: 30px">
        {{ session('successLogout') }}
    </div>
@endif
<header style="margin-left: 30px">
    <a href="/register" class="btn btn-success">Register Page</a>
    <a href="/login" class="btn btn-success" style="margin-left: 20px" >Login Page</a>
</header>

<script>
    setTimeout(function () {
        let message = document.getElementById('logoutMessage');
        if (message) {
            message.style.display = 'none'
        }
    }, 3000);
</script>
</body>
</html>
