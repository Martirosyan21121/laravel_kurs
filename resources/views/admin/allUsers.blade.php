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

        .header {
             display: flex;
             align-items: center;
         }
        .header a, .header input {
            margin-right: 20px;
        }
        .header a:last-of-type {
            margin-left: 0;
        }
        .header input {
            margin-right: 0;
        }
    </style>
</head>
<body>

<div class="container">
    <h2 style="margin-top: 10px; text-align: center">All Users</h2>
    <header class="header">
        <a class="btn btn-danger" style="color: white;" href="/adminPage">Back</a>
        <a class="btn btn-warning" style="color: white; margin-left: 20px" href="/allUsers/deactivateUsers">Deactivate Users</a>
        <input class="form-control" type="text" onkeyup="searchUser()" placeholder="Search email..." id="searchUser" style="margin-left: 20px">
    </header>
    <br>

    @if (session('success'))
        <div class="alert alert-success" id="successMessage" style="width: 500px">
            {{ session('success') }}
        </div>
    @endif
    <table id="userTable" class="table table-striped table-dark">
        <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Name</th>
            <th scope="col">Email</th>
            <th scope="col">Created at</th>
            <th scope="col">Updated at</th>
            <th scope="col">Updated</th>
            <th scope="col">Add Task</th>
            <th scope="col">Deactivate</th>
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
                <td><a class="btn btn-info" href="/addTask/user/byAdmin/{{$user->id}}">Add Task</a></td>
                <td><a class="btn btn-warning" href="/deactivate/user/byAdmin/{{$user->id}}">Deactivate</a></td>
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

    function searchUser() {
        let input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("searchUser");
        filter = input.value.toUpperCase();
        table = document.getElementById("userTable");
        tr = table.getElementsByTagName("tr");
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[1];
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }
</script>
</body>
</html>




