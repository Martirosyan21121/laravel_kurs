<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
        .table td:nth-child(2),
        .table td:nth-child(3){
            word-wrap: break-word;
            max-width: 200px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2  style="margin-top: 10px; text-align: center">All Tasks</h2>
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
            <th scope="col">Title</th>
            <th scope="col">Description</th>
            <th scope="col">Status</th>
            <th scope="col">Created at</th>
            <th scope="col">Updated at</th>
            <th scope="col">Updated</th>
            <th scope="col">Delete</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($tasks as $task)
            <tr>
                <th scope="row">{{$task->id}}</th>
                <td>{{$task->title}}</td>
                <td>{{$task->description}}</td>
                <td><select class="form-select">
                        <option>Not Started</option>
                        <option>In Progress</option>
                        <option>In Test</option>
                        <option>Done</option>
                    </select></td>
                <td>{{$task->created_at}}</td>
                <td>{{$task->updated_at}}</td>
                <td><a class="btn btn-primary">Update</a></td>
                <td><a class="btn btn-danger" href="/task/delete/{{$task->id}}">Delete</a></td>
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



