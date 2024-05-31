<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h1>Your Profile</h1>
    @if (session('success'))
        <div class="alert alert-success" id="successMessage" style="width: 300px;">
            {{ session('success') }}
        </div>
    @endif
    <div>
        <p><strong>Name:</strong> {{ $user->name }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>
    </div>

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
