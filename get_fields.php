<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<head>
	<style>
  .modal-content {
            border-radius: 10px;
        }

        .modal-header {
            background-color: #007bff;
            color: #fff;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }

        .modal-title {
            font-size: 24px;
        }

        .modal-body {
            padding: 20px;
        }

        .form-control {
            margin-bottom: 10px;
        }

        .seat-selection-box {
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 15px;
            background-color: #f9f9f9;
        }

        /* Additional styles for positioning the modal */
        .modal-side {
            position: fixed;
            top: 50%;
            left: 75%; /* Adjust the left position as needed */
            transform: translate(-50%, -50%);
        }
	</style>
</head>
<?php for($i = 0; $i < $_GET['count']; $i++ ): ?>
<hr>
<div class="row">
	<div class="col-md-6">
		<label class="control-label">Name</label>
		<input type="text" name="name[]" class="form-control">
	</div>
	<div class="col-md-6">
		<label class="control-label">Contact Number</label>
		<input type="text" name="contact[]" class="form-control">
	</div>
</div>

<div class="row">
<div class="form-group col-md-12">
	<label class="control-label">Address</label>
	<textarea name="address[]" id="" cols="30" rows="2" class="form-control"></textarea>
</div>
</div>

<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#seatSelectionModal">
            Book a Seat
        </button>
    </div>

    <!-- Seat Selection Modal -->
    <div class="modal fade" id="seatSelectionModal" tabindex="-1" role="dialog" aria-labelledby="seatSelectionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="seatSelectionModalLabel">Seat Selection</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="seat-selection-box">
                        <form action="" method="post">
                            <div class="form-group">
                                <label for="class">Select Class:</label>
                                <select name="class" id="class" class="form-control">
                                    <option value="economy">Economy</option>
                                    <option value="premium_economy">Premium Economy</option>
                                    <option value="business">Business</option>
                                    <option value="first_class">First Class</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="seat">Select Seat:</label>
                                <select name="seat" id="seat" class="form-control">
                                    <!-- Seats will be added dynamically based on the selected class -->
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Book Seat</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div> 

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.min.js"></script>
    
    <script>
    function updateSeatDisplay() {
      const selectedClass = document.getElementById("seatClass").value;
      const seatMap = document.getElementById("seatMap");
      
      // Remove all existing seats
      seatMap.innerHTML = "";

      // Add seats based on the selected class
      const seatCount = (selectedClass === "economy") ? 30 :
                        (selectedClass === "premiumEconomy") ? 20 :
                        (selectedClass === "firstClass") ? 10 : 0;

      for (let i = 1; i <= seatCount; i++) {
        const seat = document.createElement("div");
        seat.classList.add("seat", selectedClass);
        seat.textContent = i;
        seatMap.appendChild(seat);
      }
    }

    // Initial seat display
    updateSeatDisplay();
  </script>

<?php endfor; ?>

