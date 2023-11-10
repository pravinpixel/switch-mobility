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

        .rectangle-box1 {
            width: 94%;
            height: 210px;
            border: 2px solid #000;
            padding: 0;
        }

        .col-l12 {
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
            width: 16.2%;
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
            width: 16.2%;
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

        /* Adjust the image size for A3 portrait */
        .image-container img {
            width: auto;
            /* Set the width to 100% to fit A3 width */
            height: 630px;
            /* Let the height adjust proportionally */
        }

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
        <h1 style="margin: 0 auto; display: inline-block">Online Approval Management</h1>
    </div>
    <div class="col-l12" style="margin-top: 15px;">
        <div class="col-l3">
            Ticket Number<br>Abcd@123
        </div>
        <div class="col-l3">
            Project Code<br>S123
        </div>
        <div class="col-l3">
            Project Name<br>sample
        </div>
        <div class="col-l3">
            Upload Date<br>01-08-2023
        </div>
    </div>
    <div class="col-l12" style="margin-top: 15px;">
        <div class="col-l3">
            Document Type<br>rr
        </div>
        <div class="col-l3">
            Workflow Name And Code<br>HDMI PORT(SWF2023HDM0001)
        </div>
        <div class="col-l3">
            Department<br>Marketing & Proposals Department
        </div>
        <div class="col-l3">
            Initiator<br>Ramya A
        </div>
    </div>
    <div class="image-container" align="left">
        <img src="{{ $imagePath }}" alt="Image" />
    </div>
    <div class="rectangle-box1">
        <div class="col-l12" style="margin-top: 23px!important;">
            <div class="col-l2" style="margin-left: 5px!important;">
                <img src="{{ public_path('sign/1.png') }}">
                <br />
                <b>Manager</b>
                <br />
                <b>Name:</b> Raja
                <br />
                <b>Level: </b>1 <b>Date:</b>10-10-2022
            </div>
            <div class="col-l2">
                <img src="{{ public_path('sign/2.png') }}">
                <br>
                <b>Staff</b>
                <br />
                <b>Name:</b> Ravi
                <br />
                <b>Level: </b>2 <b>Date:</b>11-10-2022
            </div>
            <div class="col-l2">
                <img src="{{ public_path('sign/3.jpeg') }}">
                <br>
                <b>Staff</b>
                <br />
                <b>Name:</b> Mohan
                <br />
                <b>Level: </b>3 <b>Date:</b>12-10-2022
            </div>
            <div class="col-l2">
                <img src="{{ public_path('sign/4.png') }}">
                <br>
                <b>Staff</b>
                <br />
                <b>Name:</b> Selavam
                <br />
                <b>Level: </b>4 <b>Date:</b>13-10-2022
            </div>
            <div class="col-l2">
                <img src="{{ public_path('sign/5.png') }}">
                <br>
                <b>Supervisor</b>
                <br />
                <b>Name:</b> Muthu
                <br />
                <b>Level: </b>5 <b>Date:</b>14-10-2022
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
        <div class="col-l12" style="margin-top: 2px!important;">
            <div class="col-l1" style="margin-left: 5px!important;">
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
                <img src="{{ public_path('sign/10.png') }}">
                <br>
                <b>Staff</b>
                <br />
                <b>Name:</b> Vijay
                <br />
                <b>Level: </b>10 <b>Date:</b>19-10-2022
            </div>
            <div class="col-l2">
                <img src="{{ public_path('sign/11.jpeg') }}">
                <br>
                <b>Clerk</b>
                <br />
                <b>Name:</b> Akash
                <br />
                <b>Level: </b>11 <b>Date:</b>20-10-2022
            </div>
        </div>
    </div>
</body>

</html>
@endforeach