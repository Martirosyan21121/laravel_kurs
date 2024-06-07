<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 50px;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: lawngreen;
            text-align: center;
            margin-bottom: 20px;
        }
        p {
            font-size: 18px;
            color: #333;
        }
    </style>
</head>

<body>
<div class="container">
 <h1 style="color: lawngreen; text-align: center">Thanks for register</h1>
    <p>Your name: {{$name}}</p>
    <p>Your email: {{$email}}</p>
    <p>Data and time of register: {{$createdAt}}</p>

</div>
</body>
</html>
