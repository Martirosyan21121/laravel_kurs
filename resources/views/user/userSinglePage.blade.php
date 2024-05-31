<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile page</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h1 style="margin-top: 10px; text-align: center">Your profile</h1>
    @if (session('success'))
        <div class="alert alert-success" id="successMessage" style="width: 300px;">
            {{ session('success') }}
        </div>
    @endif

    @if (session('successLogin'))
        <div class="alert alert-success" id="successMessage" style="width: 300px;">
            {{ session('successLogin') }}
        </div>
    @endif
    <div>
        <p><strong>Name:</strong> {{ $user->name }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>
    </div>

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-warning">Logout</button>
    </form>

</div>
<script>
    setTimeout(function () {
        let message = document.getElementById('successMessage');
        if (message) {
            message.style.display = 'none'
        }
    }, 3000);
</script>
</body>
</html>

