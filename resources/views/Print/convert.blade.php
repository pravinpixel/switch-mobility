<!DOCTYPE html>
<html>
<head>
    <title>Converted HTML</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.3.2/html2canvas.min.js"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js" integrity="sha512-qZvrmS2ekKPF2mSznTQsxqPgnpkI4DNTlrdUmTzrDgektczlKNRRhy5X5AAOnx5S09ydFYWWNSfcEqDTTHgtNA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

</head>
<body>
    {!! $html !!}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>


    <script>
   function processTable(table) {
      var rows = Array.from(table.find("tr")); // Convert the jQuery collection to an array
      rows.reverse(); // Reverse the order of the array

      for (var i = 0; i < rows.length; i++) {
        var element = rows[i];

        if ($(element).html().trim() === "") {
          $(element).hide();
        } else {
          break; // Exit the loop once a non-empty row is encountered
        }
      }

      for (let index = 0; index = -2 ; index++) {
        let remove = true;
        table.find("tr td:last-child").each(function() {
          if ($(this).html().trim() !== "") {
            remove = false;
          }
        });
        if (remove == true) {
          table.find("tr td:last-child").remove();
        } else {
          break;
        }
      }
    }

    // Call the function for each table
    $("table").each(function() {
        console.log("hello");
      processTable($(this));
      console.log("completed");
    });


    </script>
    
    <script>
        // Function to convert HTML to PDF
        function Convert_HTML_To_PDF() {
            console.log("pdf Will Process");
            window.jsPDF = window.jspdf.jsPDF;

    var doc = new jsPDF();
      
    // Source HTMLElement or a string containing HTML.
    var elementHTML = document.querySelector("body");

    doc.html(elementHTML, {
        callback: function(doc) {
            // Save the PDF
            doc.save('sample-document.pdf');
        },
        x: 5,
        y: 5,
        width: 170, //target width in the PDF document
        windowWidth: 650 //window width in CSS pixels
    });
        }

        // Call the Convert_HTML_To_PDF function after window load
        window.onload = function() {
          Convert_HTML_To_PDF();
        };
      </script>
</body>
</html>
