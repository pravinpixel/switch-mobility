<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Email</title>

</head>
@php
$url = url('/');
@endphp

<body>
    <div>Hello <b> {{$empName}}</b>,

        <br> Greetings from <b>Switch Mobility</b>,

        This email is to notify you that the password is updated to your login for you to access the portal. Please log in with your credentials in our portal <a href="{{ $url }}">Click Link</a> with this password further

        The Updated Password is: {{$projectName}}


        <br>
        Regards,
        <br>
        Team <b>Switch Mobility</b>
    </div>

</body>

</html>