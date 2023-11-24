@foreach ($imagePaths as $imagePath)
<!DOCTYPE html>
<html>

<head>
    <style>
        /* Set the paper size to A3 portrait */
        @page {
            size: A3 portrait;
        }

        body {
            width: 420mm;
            /* Width for A3 portrait */
            height: 297mm;
            /* Height for A3 portrait */
            margin: 0;
            /* Remove default margin */
            padding: 0;
            /* Remove default padding */
        }

        /* CSS for the rectangle box */
        .rectangle-box {
            width: 67%;
            height: 60px;
            border: 2px solid #000;
            margin: 0;
            padding: 0;
        }


        <?php
        if (count($projectApprovers) <= 8) { ?>.rectangle-box1 {
            width: 67%;
            height: 100px !important;
            border: 2px solid #000;
            padding: 0;
        }

        <?php } else { ?>.rectangle-box1 {
            width: 67%;
            height: 180px !important;
            border: 2px solid #000;
            padding: 0;
        }

        <?php } ?>.col-l12 {
            width: 100%;
            display: flex;
            flex-direction: row;
        }

        .col-l3 {
            width: 13.4%;
            display: inline-block;
            text-align: center;

            height: auto;
        }

        .col-l2,
        .col-l1 {
            width: 16%;
            display: inline-block;
            text-align: center;
            border: 1px solid black;
        }

        .col-l2 img,
        .col-l1 img {
            margin-top: 2px;
            max-height: 40px;
            max-width: 40px;
            object-fit: contain;
        }


        <?php
        if (count($projectApprovers) <= 8) { ?>

        /* Adjust the image size for A4 portrait */
        .image-container img {
            width: auto;
            max-height: 1210px !important;
            margin-left: 100px !important;
        }

        <?php } else { ?>

        /* Adjust the image size for A4 portrait */
        .image-container img {
            width: auto;
            max-height: 1110px !important;
            margin-left: 100px !important;
        }

        <?php } ?>
    </style>
</head>

<body>
    <div class="top-bar rectangle-box">
        <img src="{{ public_path('pdf-images/logo.png') }}" alt="Left Image" style="width: 150px; height: 50px; display: inline-block; margin-top: 15px; ">
        <h1 style="margin: 0 auto; display: inline-block">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Online Approval Management  </h1>
    </div>
    <div class="col-l12" style="margin-top: 5px!important;">
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
    <div class="col-l12" style="margin-top: 3px;">
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
    <!-- ... Other col-l12 elements ... -->
    <div class="image-container" align="left">
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