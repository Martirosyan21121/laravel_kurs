<!DOCTYPE html>
<html>
<head>
    <title>Error</title>
</head>
<body>
<h1>An error occurred!</h1>
<p>
    @if (isset($errorMsg))
        {{ $errorMsg }}
    @else
        Something went wrong. Please try again later.
    @endif
</p>
</body>
</html>

