@foreach ($imagePaths as $imagePath)
<!DOCTYPE html>
<html>

<head>
    <style>
        /* Set the paper size to A4 landscape */
        @page {
            size: A4 landscape;
        }

        body {
            width: 297mm;
            /* Width for A4 landscape */
            height: 210mm;
            /* Height for A4 landscape */
            margin: 0;
            /* Remove default margin */
            padding: 0;
            /* Remove default padding */
        }

        /* CSS for the rectangle box */
        .rectangle-box {
            width: 91%;
            height: 53px;
            border: 2px solid #000;
            margin-top: -40px !important;
            padding: 0;
        }

        .rectangle-box1 {
            width: 91%;
            height: 208px !important;
            border: 2px solid #000;
            padding: 0;
            margin-bottom: -60px !important;
            margin-top: 10px !important;
        }

        .col-l12 {
            width: 100%;
            display: flex;
            flex-direction: row;
        }

        .col-l3 {
            width: 21.4%;
            display: inline-block;
            text-align: center;

            height: auto;
        }

        .col-l2,
        .col-l1 {
            /* width: 8.8%; */
            width: 160px;
            height: 100px;
            display: inline-block;
            text-align: center;

            font-size: 14px;
        }

        .col-l2 img,
        .col-l1 img {
            margin-top: 6px;
            /* max-height: 40px;
            max-width: 80px; */
            width: 80px;
            height: 40px;
            object-fit: contain;
        }

        /* Adjust the image size for A4 landscape */
        .image-container img {
            width: 500px;
            height: 430px !important;
            margin-top: -10px !important;

        }

        .square-box {
            width: 160px;
            height: 102px;

            /* You can change the background color */
            margin-top: 27px;
            display: inline-block;
            border: 1px solid black;

        }

        .square-box1 {
            width: 160px;
            height: 102px;

            border: 1px solid black;
            /* You can change the background color */
            margin-top: -8px !important;

            display: inline-block;
        }

        .signDiv {
            font-size: 10px;
        }
    </style>
</head>

<body>
    <div class="top-bar rectangle-box">
        <img src="{{ public_path('pdf-images/logo.png') }}" alt="Left Image" style="width: 150px; height: 50px; display: inline-block; margin-top: 15px; ">
        <h1 style="margin: 0 auto; display: inline-block">Online Approval Management</h1>
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
    <div class="rectangle-box1" style=" margin-right:-55px!important;">
        @for($i = 0;$i<count($projectApprovers);$i++) @if($i==0 || $i<7) <div class="square-box">
            <div class="col-l2 signDiv ">
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
    </div>
    @if($i>6)
    <div class="square-box1">
        <div class="col-l2 signDiv ">
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
    </div>
    @endif
    @endif
    @endfor

    </div>
</body>

</html>
@endforeach