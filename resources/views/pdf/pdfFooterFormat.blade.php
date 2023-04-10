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
        <table style=" border: 1px solid;width: 100%;border-collapse: collapse;">
            <thead>
                <tr>
                    <th style=" border: 1px solid;">S.No</th>
                    <th style=" border: 1px solid;">Level</th>
                    <th style=" border: 1px solid;">Sign Image</th>
                    <th style=" border: 1px solid;">Name</th>
                    <th style=" border: 1px solid;">Date</th>                    
                </tr>
            </thead>
            <tbody>
                @foreach($entities as $entity)
                <tr>
                    <td style=" border: 1px solid;text-align:center">{{$loop->iteration}}</td>
                    <td style=" border: 1px solid;text-align:center">{{$entity['level']}}</td>
                    @if($entity['signImagePath'])
                    <td style=" border: 1px solid;text-align:center"><img src="{{$entity['signImagePath']}}" style="width: 50px;display:inline-block;"></td>
                    @else
                    <td style=" border: 1px solid;text-align:center"><img src="" style="width: 50px;display:inline-block;"></td>
                    @endif
                    <td style=" border: 1px solid;text-align:center">{{$entity['employeeName']}}</td>
                    <td style=" border: 1px solid;text-align:center">{{$entity['date']}}</td>
                </tr>
              @endforeach
            </tbody>
        </table>

</body>

</html>