<!DOCTYPE html>
<html>
<head>
    <title>Seat Selection</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <h1>Flight Booking</h1>

    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#seatSelectionModal">
        Book a Seat
    </button>

    <!-- Seat Selection Modal -->
    <div class="modal fade" id="seatSelectionModal" tabindex="-1" role="dialog" aria-labelledby="seatSelectionModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="seatSelectionModalLabel">Seat Selection</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="process.php" method="post">
                        <label for="class">Select Class:</label>
                        <select name="class" id="class" class="form-control">
                            <option value="economy">Economy</option>
                            <option value="premium_economy">Premium Economy</option>
                            <option value="business">Business</option>
                            <option value="first_class">First Class</option>
                        </select>

                        <label for="seat">Select Seat:</label>
                        <select name="seat" id="seat" class="form-control">
                            <!-- Seats will be added dynamically based on the selected class -->
                        </select>

                        <button type="submit" class="btn btn-primary">Book Seat</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.min.js"></script>
    <script>
        const seatOptions = {
            economy: ["A1", "A2", "A3", "B1", "B2", "B3"], // Add more economy seats as needed
            premium_economy: ["C1", "C2", "C3", "D1", "D2", "D3"], // Add more premium economy seats as needed
            business: ["E1", "E2", "F1", "F2"], // Add more business class seats as needed
            first_class: ["G1", "G2", "H1", "H2"], // Add more first-class seats as needed
        };

        const classSelect = document.getElementById('class');
        const seatSelect = document.getElementById('seat');

        classSelect.addEventListener('change', function () {
            const selectedClass = classSelect.value;
            const seats = seatOptions[selectedClass] || [];

            while (seatSelect.options.length > 0) {
                seatSelect.options.remove(0);
            }

            for (const seat of seats) {
                const option = new Option(seat, seat);
                seatSelect.options.add(option);
            }
        });

        // Initialize seat options based on the initially selected class
        classSelect.dispatchEvent(new Event('change'));
    </script>
</body>
</html>
