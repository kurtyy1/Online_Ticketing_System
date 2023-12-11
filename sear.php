<!DOCTYPE html>
<html>
<head>
    <title>Seat Selection</title>
    <!-- Add CSS for modal styling (you can link to an external stylesheet) -->
    <style>
        /* Add your modal CSS here */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.4);
        }
        .modal-content {
            background-color: #fff;
            margin: 15% auto;
            padding: 20px;
            width: 70%;
        }
        /* You can add more CSS for styling seat selection within the modal */
    </style>
</head>
<body>

<?php
if(isset($_POST['class'])){
    // Check which class the user selected
    $selectedClass = $_POST['class'];

    // Display the modal if a class is selected
    echo '<div id="myModal" class="modal">
            <div class="modal-content">
                <h2>Seat Selection for ' . $selectedClass . '</h2>
                <!-- Add seat selection options here -->
                <!-- Example: -->
                <p>Select your seat:</p>
                <select>
                    <option>Seat 1</option>
                    <option>Seat 2</option>
                    <option>Seat 3</option>
                    <!-- Add more seat options as needed -->
                </select>
                <br>
                <button onclick="closeModal()">Close</button>
            </div>
        </div>';
}
?>

<form method="post">
    <h1>Choose your class:</h1>
    <label><input type="radio" name="class" value="Economy">Economy</label>
    <label><input type="radio" name="class" value="Premium Economy">Premium Economy</label>
    <label><input type="radio" name="class" value="Business">Business</label>
    <label><input type="radio" name="class" value="First Class">First Class</label>
    <br>
    <input type="submit" value="Select Class">
</form>

<script>
    // JavaScript to control the modal
    function closeModal() {
        var modal = document.getElementById("myModal");
        modal.style.display = "none";
    }
</script>

</body>
</html>
