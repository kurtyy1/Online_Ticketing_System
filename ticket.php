<?php
// Start the session
session_start();
include('admin/db_connect.php');
// Rest of your code...

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Flight Details and Payment</title>

  <style>
    /* Add your CSS styles for formatting */
    body {
      font-family: Arial, sans-serif;
      margin: 20px;
    }


   @media print {
  #outprint_modal {
    max-width: 600px;
  
  }
}

    .text-center {
        margin-left: 1rem;
      }

    .form-group {
      margin-bottom: 20px;
    }

    .payment-icons img {
      max-width: 50px;
      margin-right: 10px;
    }

    .hidden {
      display: none;
    }

    .content-below-navbar {
      margin-top: 80px;
      /* Adjust as needed based on your navbar height */
    }

  </style>
  <script>
    function togglePaymentInput(paymentOption) {
      var creditCardInput = document.getElementById('credit-card');
      var gcashInput = document.getElementById('gcash');

      if (paymentOption === 'credit-card') {
        creditCardInput.classList.remove('hidden');
        gcashInput.classList.add('hidden');
      } else if (paymentOption === 'gcash') {
        gcashInput.classList.remove('hidden');
        creditCardInput.classList.add('hidden');
      }
    }
    
  </script>
</head>

<body>

  <nav class="navbar navbar-expand-lg navbar-light fixed-top py-3" id="mainNav">
    <div class="container">
      <a class="navbar-brand js-scroll-trigger" href="./"><?php echo $_SESSION['setting_name'] ?></a>
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto my-2 my-lg-0">
          <li class="nav-item"><a class="nav-link js-scroll-trigger" href="index.php?page=home">Home</a></li>
          <li class="nav-item"><a class="nav-link js-scroll-trigger" href="index.php?page=flights"></span>Flight List</a></li>
          <li class="nav-item"><a class="nav-link js-scroll-trigger" href="index.php?page=about">About</a></li>
          <?php
          // Check if the user is logged in
                if (isset($_SESSION['user_id'])) {
                    echo '<li class="nav-item"><a class="nav-link js-scroll-trigger" href="logout.php">Logout</a></li>';
                }
                ?>
                <li class="nav-item"><a class="nav-link js-scroll-trigger" href="logout.php">Logout</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="container">
    <div id="outprint_modal">
    <div class="content-below-navbar">
      <h3>Flight Details</h3>


      <?php
      include('header.php');

           
// Retrieve user details from the URL
$userName = isset($_GET['name']) ? htmlspecialchars($_GET['name']) : "";
$userAddress = isset($_GET['address']) ? htmlspecialchars($_GET['address']) : "";
$userContact = isset($_GET['contact']) ? htmlspecialchars($_GET['contact']) : "";

// Display user and flight information
echo "<div class='print-container'>";

echo "<p>Personal Information:</p>";

echo "<p>Name: $userName</p>";
echo "<p>Address: $userAddress</p>";
echo "<p>Contact: $userContact</p>";
// Assuming $conn is your database connection object
if (isset($_GET['id']) && $_GET['id'] > 0) {
  $id = $_GET['id'];
  $queryString = "SELECT fl.departure_datetime, al.airport, al.location, al.id FROM flight_list as fl LEFT JOIN airport_list as al ON fl.departure_airport_id = al.id WHERE fl.id = $id";
  $queryString2 = "SELECT fl.arrival_datetime, al.airport, al.location, al.id FROM flight_list as fl LEFT JOIN airport_list as al ON fl.arrival_airport_id = al.id WHERE fl.id = $id";

  $airportResult = $conn->query($queryString);
  $airportResult2 = $conn->query($queryString2);
echo "<p>Flight Information:</p>";
// if ($returnDate) {
//   echo "<p>Roundtrip - From $from to $to - Departure: $departureDate, Return: $returnDate</p>";
// } else {
//   echo "<p>One-way - From $from to $to - Departure: $departureDate</p>";
// }

      $airport_arr = [];
      echo "Departure: ";
      echo "<br />";
      while ($row = $airportResult->fetch_assoc()) {
          $airport_arr[] = [
              'id' => $row['id'],
              'airport' => $row['airport'],
              'time' => $row['departure_datetime'],
              'location' => $row['location'],
          ];
          


          // Display airport information
          echo '<tr class="text-center">';
          echo '<td>' . ucwords($row['airport']) .', '.($row['location']) .', '.($row['departure_datetime']) .  '</td>';
          echo '</tr>';
      }

      $airportResult->free();
      $airport_arr2 = [];

      echo "<br />";
      echo "Arrival: ";
      echo "<br />";

      while ($row = $airportResult2->fetch_assoc()) {
          $airport_arr[] = [
              'id' => $row['id'],
              'airport' => $row['airport'],
              'time' => $row['arrival_datetime'],
              'location' => $row['location'],
          ];
          


          // Display airport information
          echo '<tr class="text-center">';
          echo '<td>' . ucwords($row['airport']) .', '.($row['location']) .', '.($row['arrival_datetime']) .  '</td>';

          echo '</tr>';
      }

      $airportResult2->free();
  } else {
          echo "Error: " . $conn->error;
      }

      // function getairportInfo($airport_arr, $departure_report_id) {
      //     foreach ($airport_arr as $airport) {
      //         if ($airport['id'] == $departure_report_id) {
      //             return $airport['airport'] . ' ' . $airport['location'];
      //         }
      //     }
      //     return "N/A";
      // }

  echo "</div>";
    
      ?>
        </div>
        </div>



      

      <h3>Payment</h3>
      <form action="lastpage.php" method="post">
        <div class="form-group payment-icons">
          <img src="assets/img/credit_card_icon.jpg" alt="Credit Card Icon" onclick="togglePaymentInput('credit-card')">
          <label for="credit-card">Credit Card:</label>
          <input type="text" id="credit-card" name="credit-card" placeholder="Enter credit card number" class="hidden">
        </div>

        <div class="form-group payment-icons">
          <img src="assets/img/gcash_icon.png" alt="GCash Icon" onclick="togglePaymentInput('gcash')">
          <label for="gcash">GCash:</label>
          <input type="text" id="gcash" name="gcash" placeholder="Enter GCash number" class="hidden">
        </div>

        <input type="submit" value="Submit Payment">
    </div>
    </form>
  </div>

  <div class="row justify-content-end border-top pt-2">
        <div class="col-auto me-1">
            <button class="btn btn-sm btn-success rounded-0" id='print_data' type="button"><i class="fa fa-print"></i> Print</button>
        </div>
        <div class="col-auto">
            <a class="btn btn-sm btn-primary rounded-0" href="index.php?page=flights"><i class="fa fa-angle-left"></i> Back</a>
        </div>
    </div>
      </div>
</body>

<script>
$(function(){
    $('#print_data').click(function(){
        var _p = $('#outprint_modal').clone()
        var _h = $('head').clone()
        var _header = $('#noscript2').html()
        var el = $('<div>')
        el.append(_h)
        el.append(_header)
        el.append(_p)
        
        var nw = window.open("","_blank","width=1000,height=900,top=50,left=250")
                    nw.document.write(el.html())
                    nw.document.close()
                    setTimeout(() => {
                    nw.print()
                        setTimeout(() => {
                            nw.close()
                        }, 200);
                    }, 500);
    })
})
</script>

</html>