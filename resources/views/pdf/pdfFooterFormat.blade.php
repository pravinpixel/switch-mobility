<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>


<body style="background-color: #CCFFFF">
    <div class="top-bar" style="border: 2px solid black;background-color: white;padding: 10px 0 0 10px;">
        <img src="{{$imagePath}}" alt="Left Image" style="width: 150px;display:inline-block;">
        <h1 style="margin: 0 auto;display:inline-block">Online Approval Management</h1>
    </div>
    <br>
    <div class="container" style=" width:98%;background-color: white;border-top: 5px solid darkblue;border-radius: 5px;margin:auto">
        <br>
        <table>
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>Sign Image</th>
                    <th>Name</th>
                    <th>Date</th>                    
                </tr>
            </thead>
            <tbody>
                @foreach($entities as $entity)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td><img src="" alt="Left Image" style="width: 50px;display:inline-block;"></td>
                    <td>{{$entity['employeeName']}}</td>
                    <td>{{$entity['date']}}</td>
                </tr>
              @endforeach
            </tbody>
        </table>

</body>

</html>