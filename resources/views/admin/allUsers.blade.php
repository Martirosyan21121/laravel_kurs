<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Users Page</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
        .table td:nth-child(2),
        .table td:nth-child(3) {
            word-wrap: break-word;
            max-width: 200px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2 style="margin-top: 10px; text-align: center">All Users</h2>
    <header>
        <a class="btn btn-danger" style="color: white;" href="/userPage">Back</a>
    </header>
    <br>

    @if (session('success'))
        <div class="alert alert-success" id="successMessage" style="width: 300px;">
            {{ session('success') }}
        </div>
    @endif
    <table class="table table-striped table-dark">
        <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Name</th>
            <th scope="col">Email</th>
            <th scope="col">Created at</th>
            <th scope="col">Updated at</th>
            <th scope="col">Updated</th>
            <th scope="col">Delete</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($users as $user)
            <tr>
                <th scope="row">{{$user->id}}</th>
                <td>{{$user->name}}</td>
                <td>{{$user->email}}</td>
                <td>{{$user->created_at}}</td>
                <td>{{$user->updated_at}}</td>
                <td><a class="btn btn-primary" href="/update/user/byAdmin/{{$user->id}}">Update</a></td>
                <td><a class="btn btn-danger" href="/deactivate/user/byAdmin/{{$user->id}}">Deactivate</a></td>
            </tr>
        @endforeach
        </tbody>
    </table>
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




