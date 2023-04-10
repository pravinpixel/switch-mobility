<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Email</title>
</head>
@php
$url = route('tempOpen', ['id' =>$projectId]);
@endphp

<body>
    <div>Hello <b> {{$empName}}</b>,

        <br> Greetings from <b>Switch Mobility</b>,

        <p>This email is to notify you that a new action <b>{{$status}}</b> has been taken by the approver <b>{{$approverData}}</b> at Level <b>{{$level}}</b> in the project <b>{{$projectName}}</b> - <b>{{$projectCode}}</b>. Please do login with your credentials in our portal <b><a href="{{ $url }}">Click Link</a></b> to review the remarks and further actions
        </p>

        <br>
        Regards,
        <br>
        Team <b>Switch Mobility</b>
    </div>

</body>

</html>