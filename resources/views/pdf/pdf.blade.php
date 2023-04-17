<html lang="en" style="height: 100%;">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>




</style>

<body style="height: 100%;margin:0">
    <div class="header" style="position: fixed;width: 100%;">
        <div class="top-bar" style="border: 2px solid black;background-color: white;padding: 10px 0 0 10px;">
            <img src="{{$logo}}" alt="Left Image" style="width: 150px;display:inline-block;">
            <h1 style="margin: 0 auto;display:inline-block">Online Approval Management</h1>
        </div>
        <br>
        <div class="container" style="height:10%; width:98%;background-color: white;border-top: 5px solid darkblue;border-radius: 5px;margin:auto">

            <br>

            <div class="top-row" style="height:5%">
                <div class="element" style="width: 18%;margin: 0 20px;text-align: center;display:inline-block">
                    <p style="font-size:10px"><b>Ticket Number</b></p>
                    <p style="font-size:10px">{{$ticketNo}}</p>
                </div>
                <div class="element" style="width: 18%;margin: 0 20px;text-align: center;display:inline-block">
                    <p style="font-size:10px"><b>Project Code</b></p>
                    <p style="font-size:10px">{{$projectCode}}</p>
                </div>
                <div class="element" style="width: 18%;margin: 0 20px;text-align: center;display:inline-block">
                    <p style="font-size:10px"><b>Project Name</b></p>
                    <p style="font-size:10px">{{$projectName}}</p>
                </div>
                <div class="element" style="width: 18%;margin: 0 20px;text-align: center;display:inline-block">
                    <p style="font-size:10px"><b>Uploaded Date</b></p>
                    <p style="font-size:10px">{{$date}}3</p>
                </div>
            </div>
            <div class="bottom-row" style="height:5%;margin-top:5%;">
                <div class="element" style="width: 18%;margin: 0 20px;text-align: center;display:inline-block">
                    <p style="font-size:10px"><b>Document Type</b></p>
                    <p style="font-size:10px">{{$docName}}</p>
                </div>
                <div class="element" style="width: 18%;margin: 0 20px;text-align: center;display:inline-block">
                    <p style="font-size:10px"><b>Workflow Name And Code</b></p>
                    <p style="font-size:10px">{{$workflowName}}({{$workflowCode}})</p>
                </div>
                <div class="element" style="width: 18%;margin: 0 20px;text-align: center;display:inline-block">
                    <p style="font-size:10px"><b>Department</b></p>
                    <p style="font-size:10px">{{$department}}</p>
                </div>
                <div class="element" style="width: 18%;margin: 0 20px;text-align: center;display:inline-block">
                    <p style="font-size:10px"><b>Initiater</b></p>
                    <p style="font-size:10px">{{$initiater}}</p>
                </div>
            </div>
        </div>
    </div>


    <img src="{{$imagePath}}" style="  width: 100%; height: 65%; margin-top: 200px; border:2px solid black;">



    <div class="footer" style="position: fixed;bottom: 0px;width: 100%;height:15%;border-style: solid;border-color: black;">
        @for($i=0;$i<count($projectApprovers);$i++)
        <?php
            if ($i >= 7) {
                $marginStyle = '-15px';
            } else {
                $marginStyle = '20px';
            }
            ?>
        <div class="row" style="display:inline-block;margin-top:<?php echo $marginStyle; ?>;border:1px solid black;height:45%;width:13%">
           
            <div style="border-bottom:2px;height:50%;">
                <p style="font-size:8px">
                    <img src="{{$projectApprovers[$i]['signImageWithPath']}}" width="80" height="20">
                    <br>
                    <b>{{$projectApprovers[$i]['designation']}}</b>
                    <br>

                    <b>Name:</b>{{$projectApprovers[$i]['appproverName']}}
                    <br>
                    <b>Level:</b>{{$projectApprovers[$i]['level']}}

                    <b> Date:</b>{{$projectApprovers[$i]['updatedate']}}</p>
            </div>
    </div>
    @endfor
    </div>
</body>

</html>