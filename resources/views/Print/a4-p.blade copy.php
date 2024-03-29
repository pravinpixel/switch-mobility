@foreach ($imagePaths as $imagePath)
<!DOCTYPE html>
<html>

<head>
    <style>
        /* Set the paper size to A4 portrait */
        @page {
            size: A4 portrait;
        }

        body {
            width: 210mm;
            /* Width for A4 portrait */
            height: 297mm;
            /* Height for A4 portrait */
            margin: 0;
            /* Remove default margin */
            padding: 0;
            /* Remove default padding */
        }

        /* CSS for the rectangle box */
        .rectangle-box {
            width: 98%;
            height: 60px;
            border: 2px solid #000;
            margin-top: -40px !important;
            margin-left: -40px!important;
            padding: 0;
        }

        .rectangle-box1 {
            width: 98%;
            height: 180px!important;
            border: 2px solid #000;
            padding: 0;
            margin-bottom: -120px !important;
            margin-top:-5px !important;
            margin-left: -40px!important;
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
            font-size: 10px;
            height: auto;
        }

        .col-l2,
        .col-l1 {
            width: 11.9%;
            display: inline-block;
            text-align: center;
            border: 1px solid black;
            font-size: 10px;
        }

        .col-l2 img,
        .col-l1 img {
            margin-top: 2px;
            /* max-height: 40px;
            max-width: 80px; */
            width: 50px;
            height:  30px;
            object-fit: contain;
        }

        /* Adjust the image size for A4 portrait */
        .image-container img {
            width: 760px;
            height: 760px !important;
           
            margin-left: -40px!important;
        }
    </style>
</head>

<body>
    <div class="top-bar rectangle-box">
        <img src="{{ public_path('pdf-images/logo.png') }}" alt="Left Image" style="width: 150px; height: 50px; display: inline-block; margin-top: 15px; ">
        <h1 style="margin: 0 auto; display: inline-block">Online Approval Management</h1>
    </div>
    <div class="col-l12" style="margin-top: 10px!important">
        <div class="col-l3">
            <b>Ticket Number</b>
            <br>Abcd@123
        </div>
        <div class="col-l3">
            <b>Project Code</b><br>S123
        </div>
        <div class="col-l3">
        <b> Project Name</b><br>sample
        </div>
        <div class="col-l3">
        <b>Upload Date</b><br>01-08-2023
        </div>
    </div>
    <div class="col-l12" style="margin-top: 5px;">
        <div class="col-l3">
        <b>  Document Type</b><br>rr
        </div>
        <div class="col-l3">
        <b> Workflow Name And Code</b><br>HDMI PORT(SWF2023HDM0001)
        </div>
        <div class="col-l3">
        <b>  Department</b><br>Marketing & Proposals Department
        </div>
        <div class="col-l3">
        <b> Initiator</b><br>Ramya A
        </div>
    </div>
    <!-- ... Other col-l12 elements ... -->
    <div class="image-container" align="left">
        <img src="{{ $imagePath }}" alt="Image" />
    </div>
    <div class="rectangle-box1">
        <div class="col-l12" style="margin-top: 20px!important;margin-left: 5px!important;font-size: 8px;"  >
        @for($i=0;$i<8;$i++)
            <div class="col-l2" >
                <img src="{{ public_path('sign/1.png') }}">
                <br />
                <b>Manager</b>
                <br />
                <b>Name:</b> Raja
                <br />
                <b>Level: </b>1 <b>Date:</b>10-10-2022
            </div>
          @endfor
          
          
        </div>
        <div class="col-l12" style="margin-top: 5px!important;margin-left: 5px!important; font-size: 8px;" >
            <div class="col-l2" style="">
                <img src="{{ public_path('sign/7.jpeg') }}">

                <br>
                <b>Staff</b>
                <br />
                <b>Name:</b> Swetha
                <br />
                <b>Level: </b>7 <b>Date:</b>16-10-2022
            </div>
            <div class="col-l2">
                <img src="{{ public_path('sign/8.jpeg') }}">
                <br>
                <b>Staff</b>
                <br />
                <b>Name:</b> Sadham
                <br />
                <b>Level: </b>8 <b>Date:</b>17-10-2022
            </div>
            <div class="col-l2">
                <img src="{{ public_path('sign/9.jpeg') }}">
                <br>
                <b>Accountant</b>
                <br />
                <b>Name:</b> Suman
                <br />
                <b>Level: </b>9 <b>Date:</b>18-10-2022
            </div>
            <div class="col-l2">
                <img src="{{ public_path('sign/6.png') }}">
                <br>
                <b>Cashier</b>
                <br />
                <b>Name:</b> Rubi
                <br />
                <b>Level: </b>6 <b>Date:</b>15-10-2022
            </div>
        </div>
    </div>
</body>

</html>
@endforeach
