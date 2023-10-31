<!DOCTYPE html>
<html>
<head>
    <title>Your PDF Title</title>
    <style>
        @page {
            margin: 50px 30px; /* Set your margin values */
           
        }
        
        .header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 50px; /* Set the height to match the top margin */
            /* text-align: center;
            background-color: #f0f0f0; */
        }

        /* Footer */
        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            height: 50px; /* Set the height to match the bottom margin */
            /* text-align: center;
            background-color: #f0f0f0; */
        }

        /* Page Content */
        .content {
            margin-top: 100px; /* Adjust the margin-top to avoid overlapping with the header */
            margin-bottom: 100px; /* Adjust the margin-bottom to avoid overlapping with the footer */
        }
        table {
            width:100%;
            text-align:center;
        }

        .content-table {
            
            width: 100%;
            border-collapse: collapse;
        }

        .content-table, .content-table th, .content-table td {
            border: 1px solid black;
        }

        .content-table th, .content-table td {
            padding: 8px;
            text-align: left;
        }

        
    </style>
</head>
<body>
    <div class="header" style="border: 2px solid #000;">
        <img src="{{ public_path('logo-pdf.png') }}" width="50" height="50" />

        <h1 style="display:inline-block; margin:0px">Online Approval Management</h1>
        <!-- <p>{{ $headerContent }}</p> -->
        
    </div>
 
    <div class="footer" style="border: 2px solid #000; padding:15px; padding-bottom:50px;">
        <img src="{{ public_path('logo-pdf.png') }}" width="100" height="100" />

        <img src="{{ public_path('logo-pdf.png') }}" width="100" height="100" />

        <img src="{{ public_path('logo-pdf.png') }}" width="100" height="100" />
    </div>
    

    <div class="content">
    <div>
        <p style="border:5px solid #000080;border-radius:50%;"></p>
        <table>
            <tr>
                <th>Ticket Number</th>
                <th> Project Code</th>
                <th> Project Name</th>
                <th> Uploaded Date</th>
            </tr>
            <tr>
                <td>Dal20230810131638</td>
                <td>Sit incidunt occaec</td>
                <td>Dalton Dodson</td>
                <td>10-08-2023</td>
            </tr>
            <br>
            <tr>
                <th>Document Type</th>
                <th>Workflow Name And Code</th>
                <th>Department</th>
                <th>Initiator</th>
            </tr>
            <tr>
                <td>Customer Invoice</td>
                <td>SPList<br>wrkflwList(SWF2023SPL005)</td>
                <td>Chemistory</td>
                <td>Dhinesh A</td>
            </tr>
        </table>

        

    </div>
        <div style="border:2px solid #000;margin-top:20px;">
        <table class="content-table">
        @foreach($content as $row)
            <tr>
                @foreach($row as $cell)
                    <td>{{ $cell }}</td>
                @endforeach
            </tr>
        @endforeach
    </table>
        </div>
    </div>
   
</body>
</html>
