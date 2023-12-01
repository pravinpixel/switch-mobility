<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Email</title>
    
</head>
@php
$url = url('AssignedProject', ['id' =>$projectId]);
@endphp
<body>
    <div>Hello <b> {{$empName}}</b>,

        <br> Greetings from <b>Switch Mobility</b>,

        <p>This email is to notify you that you have been assigned as an User.
            Please do login with your credentials For  <b>User Name: </b> {{$projectId}} And <b> Password :</b> {{$projectName}} .

        <br>
        Regards,
        <br>
        Team <b>Switch Mobility</b>
    </div>

</body>

</html>