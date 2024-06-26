<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add task Page</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h2  style="margin-top: 10px; text-align: center">Add task</h2>
    <form method="POST" action="/addTaskData">
        @csrf
        <div class="form-group">
            <label for="title">Title:</label>
            <input type="text" class="form-control" id="title" name="title">
        </div>
        @if ($errors->has('title'))
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->get('title') as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="form-group">
            <label for="text">Description:</label>
            <textarea type="text" class="form-control" id="text" name="description"></textarea>
        </div>
        @if ($errors->has('description'))
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->get('description') as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <button type="submit" class="btn btn-primary">Add task</button>
        <a class="btn btn-danger" style="color: white; margin-left: 20px" href="/userPage">Back</a>
    </form>
</div>
</body>
</html>


