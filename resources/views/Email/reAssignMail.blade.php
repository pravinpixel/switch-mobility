<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Email</title>
    
</head>
@php
$url = url('login');
@endphp
<body>
    <div>Hello <b> {{$empName}}</b>,

        <br> Greetings from <b>Switch Mobility</b>,

        This email is to notify you that we have been assigned to the <b> {{$projectName}} </b>-<b> {{$projectCode}}</b> . Please do login with your credentials in our portal <a href="{{ $url }}">Click Link</a> to kick start your activities


        <br>
        Regards,
        <br>
        Team <b>Switch Mobility</b>
    </div>

</body>

</html>