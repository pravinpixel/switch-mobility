@foreach ($imagePaths as $imagePath)
<!DOCTYPE html>
<html>

<head>
    <style>
        /* Set the paper size to A4 portrait */
        @page {
            size: A4 landscape;
        }

        body {
            width: 290mm;
            /* Width for A4 portrait */
            height: 340mm !important;
            /* Height for A4 portrait */
            margin: -30px 0 0 -35px;
            /* Remove default margin */
            padding: 0;

            /* margin-left: -35px; */
            /* Remove default padding */
        }

        /* CSS for the rectangle box */
        .rectangle-box {
            width: 100%;
            height: 50px;
            border: 2px solid #000;
            margin-top: 10px !important;

            padding: 0;
        }

        <?php
        if (count($projectApprovers) <= 8) { ?>.rectangle-box1 {
            width: 100%;
            height: 80px !important;
            border: 2px solid #000;
            padding: 0;
            margin-bottom: -120px !important;
            margin-top: -5px !important;
            /* margin-left: -40px !important; */
        }

        <?php } else { ?>.rectangle-box1 {
            width: 98%;
            height: 180px !important;
            border: 2px solid #000;
            padding: 0;
            margin-bottom: -120px !important;
            margin-top: -5px !important;

        }

        <?php } ?>.col-l12 {
            width: 100%;
            display: flex;
            flex-direction: row;
        }

        .col-l3 {
            width: 21.4%;
            display: inline-block;
            text-align: center;
            font-size: 8px;
            height: auto;
        }

        .col-l2,
        .col-l1 {
            max-width: 10.15%;
            display: inline-block;
            text-align: center;
            border: 1px solid black;
            font-size: 7px;
        }

        .col-l2 img,
        .col-l1 img {
            margin-top: 2px;
            /* max-height: 40px;
            max-width: 80px; */
            width: 50px;
            height: 30px;
            object-fit: contain;
        }




        <?php
        if (count($projectApprovers) <= 8) { ?>

        /* Adjust the image size for A4 portrait */
        .image-container img {
            width: auto;
            max-height: 580px;
            /* Use max-height instead of height for responsiveness */
            display: block;
            /* Ensures the image behaves as a block element */
            margin: 0 auto;
            /* Centers the image horizontally */
        }


        <?php } else { ?>.image-container img {
            width: auto;
            max-height: 470px;
            /* Use max-height instead of height for responsiveness */
            display: block;
            /* Ensures the image behaves as a block element */
            margin: 0 auto;
            /* Centers the image horizontally */
        }

        <?php } ?>
    </style>
</head>

<body>
    <div class="top-bar rectangle-box">
        <img src="{{ public_path('pdf-images/logo.png') }}" alt="Left Image" style="width: 100px; height: 40px; display: inline-block; margin-top: 15px; ">
        <h1 style="margin: 0 auto; display: inline-block">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Online Approval Management</h1>
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
    <!-- ... Other col-l12 elements ... -->
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