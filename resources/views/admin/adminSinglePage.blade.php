<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Profile page</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h1 style="margin-top: 10px; text-align: center">Admin profile</h1>

    @if (session('successLogin'))
        <div class="alert alert-success" id="successMessage" style="width: 400px;">
            {{ session('successLogin') }}
        </div>
    @endif
    <header>
        <a href="/allUsers" class="btn btn-success">All Users</a>
        <a href="/addUserData" class="btn btn-success">Add User</a>
    </header>
    <br>
    <div>
        <p><strong>Name:</strong> {{ $admin->name }}</p>
        <p><strong>Email:</strong> {{ $admin->email }}</p>
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


