<!DOCTYPE html>
<html>
<head>
    <title>Welcome Email</title>
</head>

<body>
<h2>Welcome to the site Mr. {{$user['name']}}</h2>
<br/>
Your registered email-id is {{$user['email']}}. <br>

{{$msg}}
</body>

</html>