<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Page</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h2  style="margin-top: 10px; text-align: center">Update Your Data</h2>

    <form method="POST" action="/updateData">
        @csrf
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name" name="name" value="{{$user->name}}" required>
        </div>
        @if ($errors->has('name'))
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->get('name') as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" value="{{$user->email}}" id="email" name="email" required>
        </div>
        @if ($errors->has('email'))
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->get('email') as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <button type="submit" class="btn btn-primary">Update</button>
        <a class="btn btn-danger" style="color: white; margin-left: 20px" href="/userPage">Back</a>
    </form>
</div>
</body>
</html>



