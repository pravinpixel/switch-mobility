<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>


<body style="">
    <div class="top-bar" style="border: 2px solid black;background-color: white;padding: 10px 0 0 10px;">
        <img src="{{$imagePath}}" alt="Left Image" style="width: 150px;display:inline-block;">
        <h1 style="margin: 0 auto;display:inline-block">Online Approval Management</h1>
    </div>
    <br>
    <div class="container" style="height:48%; width:98%;background-color: white;border-top: 5px solid darkblue;border-radius: 5px;margin:auto">
        <br>
        <br>
        <div class="top-row" style="height:20%">
            <div class="element" style="width: 18%;;margin: 0 20px;text-align: center;display:inline-block">
                <p style="font-size:10px"><b>Ticket Number</b></p>
                <p style="font-size:10px">{{$ticketNo}}</p>
            </div>
            <div class="element" style="width: 18%;;margin: 0 20px;text-align: center;display:inline-block">
                <p style="font-size:10px"><b>Project Code</b></p>
                <p style="font-size:10px">{{$projectCode}}</p>
            </div>
            <div class="element" style="width: 18%;;margin: 0 20px;text-align: center;display:inline-block">
                <p style="font-size:10px"><b>Project Name</b></p>
                <p style="font-size:10px">{{$projectName}}</p>
            </div>
            <div class="element" style="width: 18%;;margin: 0 20px;text-align: center;display:inline-block">
                <p style="font-size:10px"><b>Uploaded Date</b></p>
                <p style="font-size:10px">{{$date}}3</p>
            </div>
        </div>
        <div class="bottom-row" style="display: flex;justify-content: center;">
            <div class="element" style="width: 18%;;margin: 0 20px;text-align: center;display:inline-block">
                <p style="font-size:10px"><b>Document Type</b></p>
                <p style="font-size:10px">{{$docName}}</p>
            </div>
            <div class="element" style="width: 18%;;margin: 0 20px;text-align: center;display:inline-block">
                <p style="font-size:10px"><b>Workflow Name And Code</b></p>
                <p style="font-size:10px">{{$workflowName}}({{$workflowCode}})</p>
            </div>
            <div class="element" style="width: 18%;;margin: 0 20px;text-align: center;display:inline-block">
                <p style="font-size:10px"><b>Department</b></p>
                <p style="font-size:10px">{{$department}}</p>
            </div>
            <div class="element" style="width: 18%;;margin: 0 20px;text-align: center;display:inline-block">
                <p style="font-size:10px"><b>Initiater</b></p>
                <p style="font-size:10px">{{$initiater}}</p>
            </div>
        </div>
    </div>

</body>

</html>