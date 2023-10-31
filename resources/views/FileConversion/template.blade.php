
<!DOCTYPE html>
<html>
<head>
  <style>
    table {
      width: 100%;
      border-collapse: collapse;
    }

   .main-table th, .main-table td {
      border: 1px solid #000;
      padding: 8px;
      text-align: left;
    }

    .main-table th {
      background-color: #f2f2f2;
    }

   
  </style>
</head>
<body>
<div>
        <!-- <p style="border:2px solid #000080;border-radius:50%;"></p> -->
        <hr style="height: 6px;background-color: #000080;border: none; border-radius:50%;" />
        
        <p></p>
        <table style="margin-top:10px;">
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
  <table class="main-table">
    
    <tbody>
      @foreach($data as $row)
            
            <tr>
                @foreach($row as $cell)
                    <td>{{ $cell }}</td>
                @endforeach
            </tr>
        @endforeach
      
    </tbody>
  </table>
</body>
</html>
