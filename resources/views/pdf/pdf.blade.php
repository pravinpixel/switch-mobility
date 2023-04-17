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
        <div style="height:8%;padding: 5px;margin-top: 7px;">

            <div class="container" style="height:80%; width:98%;background-color: white;border-top: 5px solid darkblue;border-radius: 9px;margin:auto">



                <div class="top-row" style="height:4%">
                    <div class="element" style="width: 18%;margin: 0 20px;text-align: center;display:inline-block">
                        <p style="font-size:10px"><b>Ticket Number</b><br>{{$ticketNo}}</p>
                    </div>
                    <div class="element" style="width: 18%;margin: 0 20px;text-align: center;display:inline-block">
                        <p style="font-size:10px"><b>Project Code</b><br>{{$projectCode}}</p>
                    </div>
                    <div class="element" style="width: 18%;margin: 0 20px;text-align: center;display:inline-block">
                        <p style="font-size:10px"><b>Project Name</b><br>{{$projectName}}</p>
                    </div>
                    <div class="element" style="width: 18%;margin: 0 20px;text-align: center;display:inline-block">
                        <p style="font-size:10px"><b>Uploaded Date</b><br>{{$date}}</p>
                    </div>
                </div>
                <div class="bottom-row" style="height:4%;margin-top:4%;">
                    <div class="element" style="width: 18%;margin: 0 20px;text-align: center;display:inline-block">
                        <p style="font-size:10px"><b>Document Type</b><br>{{$docName}}</p>
                    </div>
                    <div class="element" style="width: 18%;margin: 0 20px;text-align: center;display:inline-block">
                        <p style="font-size:10px"><b>Workflow Name And Code</b><br>{{$workflowName}}({{$workflowCode}})</p>
                    </div>
                    <div class="element" style="width: 18%;margin: 0 20px;text-align: center;display:inline-block">
                        <p style="font-size:10px"><b>Department</b><br>{{$department}}</p>
                    </div>
                    <div class="element" style="width: 18%;margin: 0 20px;text-align: center;display:inline-block">
                        <p style="font-size:10px"><b>Initiater</b><br>{{$initiater}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <img src="{{$imagePath}}" style="width: 100%; height: 65%; margin-top: 170px; border:2px solid black;">



    <div class="footer" style="position: fixed;bottom: 0px;width: 100%;height:17.5%;border-style: solid;border-color: black;">
        @for($i=0;$i<count($projectApprovers);$i++) <?php
                                                    if ($i >= 6) {
                                                        $marginStyle = '0px';
                                                    } else {
                                                        $marginStyle = '25px';
                                                    }
                                                    if ($i== 6||$i==0) {
                                                        $marginleftStyle = '6px';
                                                    } else {
                                                        $marginleftStyle = '0px';
                                                    }
                                                    ?> 
    <div class="row" style="margin-bottom:0px;display:inline-block;margin-left:<?php echo $marginleftStyle; ?>;margin-top:<?php echo $marginStyle; ?>;border:1px solid black;height:44%;width:15%">

            <div style="border-bottom:2px;height:50%;">
                <p style="font-size:8px">
                    <img src="{{$projectApprovers[$i]['signImageWithPath']}}" width="80" height="30" style="margin:auto;margin-left:5px">
                    <br>
                    <b>{{$projectApprovers[$i]['designation']}}</b>
                    <br>

                    <b>Name:</b>{{$projectApprovers[$i]['appproverName']}}
                    <br>
                    <b>Level:</b>{{$projectApprovers[$i]['level']}}

                    <b> Date:</b>{{$projectApprovers[$i]['updatedate']}}
                </p>
            </div>
    </div>
    @endfor
    </div>
</body>

</html>