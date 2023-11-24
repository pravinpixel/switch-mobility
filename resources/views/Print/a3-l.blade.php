@foreach ($imagePaths as $imagePath)
<!DOCTYPE html>
<html>

<head>
    <style>
        /* CSS for the rectangle box */
        .rectangle-box {
            width: 94%;
            /* Set the width to 100% */
            height: 60px;
            border: 2px solid #000;
            margin: 0;
            /* Remove margin */
            padding: 0;
            /* Remove padding */
        }



        <?php
        if (count($projectApprovers) <= 8) { ?>.rectangle-box1 {

            width: 94%;
            height: 80px;
            border: 2px solid #000;
            padding: 0;

        }

        <?php } else { ?>.rectangle-box1 {

            width: 94%;
            height: 80px;
            border: 2px solid #000;
            padding: 0;

        }

        <?php } ?>.col-l12 {
            width: 100%;
            display: flex;
            flex-direction: row;
        }

        .col-l3 {
            width: 24%;
            display: inline-block;
            text-align: center;
        }

        .col-l2 {
            max-width: 10.15%;
            display: inline-block;
            text-align: center;
            border: 1px solid black;
        }

        .col-l2 img {
            margin-top: 2px;
            max-height: 40px;
            width: auto;
            object-fit: contain;
        }

        .col-l1 {
            max-width: 10.15%;
            display: inline-block;
            text-align: center;
            border: 1px solid black;
        }

        .col-l1 img {
            margin-top: 2px;
            max-height: 40px;
            width: auto;
            object-fit: contain;
        }


        <?php
        if (count($projectApprovers) <= 8) { ?>.image-container {
            width: 100%;
            /* Ensure the container takes the full width */
            text-align: center;
            /* Center-align the content */
        }

        .image-container img {
            max-width: 100%;
            /* Ensure the image doesn't exceed the container width */
            max-height: 700px;
            /* Set the maximum height */
            display: inline-block;
            /* Ensures image behaves as inline-block */
            vertical-align: middle;
            /* Aligns the image vertically */
        }


        <?php } else { ?>

        /* Adjust the image size for A3 portrait */
        .image-container img {
            width: auto;
            /* Set the width to 100% to fit A3 width */

            height: 750px!important;
            /* Let the height adjust proportionally */
        }

        <?php } ?>

        /* Set the paper size to A3 landscape */
        @page {
            size: A3 landscape;
        }

        /* CSS for custom dimensions */
        body {
            width: 420mm;
            /* Width for A3 landscape */
            height: 297mm;
            /* Height for A3 landscape */
        }
    </style>
</head>

<body>
    <div class="top-bar rectangle-box">
        <img src="{{ public_path('pdf-images/logo.png') }}" alt="Left Image" style="width: 150px; height: 50px; display: inline-block; margin-top: 15px; margin-right: 15px;">
        <h1 style="margin: 0 auto; display: inline-block">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Online Approval Management</h1>
    </div>
    <div class="col-l12" style="margin-top: 10px!important">
        <div class="col-l3">
            <b>Ticket Number</b><br>{{$projectData['ticketNo']}}
        </div>
        <div class="col-l3">
            <b> Project Code</b><br>{{$projectData['projectCode']}}
        </div>
        <div class="col-l3">
            <b> Project Name</b><br>{{$projectData['projectName']}}
        </div>
        <div class="col-l3">
            <b> Upload Date</b><br>{{$projectData['date']}}
        </div>
    </div>
    <div class="col-l12" style="margin-top: 5px;">
        <div class="col-l3">
            <b> Document Type</b><br>{{$projectData['docName']}}
        </div>
        <div class="col-l3">
            <b> Workflow Name And Code</b><br>{{$projectData['workflowData']}}
        </div>
        <div class="col-l3">
            <b> Department</b><br>{{$projectData['department']}}
        </div>
        <div class="col-l3">
            <b> Initiator</b><br>{{$projectData['initiater']}}
        </div>
    </div>
    <div class="image-container" align="center">
        <img src="{{ $imagePath }}" alt="Image" />
    </div>
    <div class="rectangle-box1">
        @for($i=0;$i<count($projectApprovers);$i++) @if($i==0 ||$i<12) <div class="col-l2" style="margin-top: 20px!important;font-size: 8px;">
            <?php
            $signImage = public_path($projectApprovers[$i]['signImageWithPath']);
            ?>
            <img src="{{$signImage}}">
            <br />
            <b>{{$projectApprovers[$i]['designation']}}</b>
            <br />
            <b>Name:</b> {{$projectApprovers[$i]['appproverName']}}
            <br />
            <b>Level: </b>{{$projectApprovers[$i]['level']}}
            <b>Date:</b>{{$projectApprovers[$i]['updatedate']}}
    </div>

    @endif


    @endfor
    </div>
</body>

</html>
@endforeach