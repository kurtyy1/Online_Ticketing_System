<?php

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You Page</title>
    <style>
        body {
            background-image: url(''); /* Replace with the actual image file path */
            background-size: cover;
            background-position: center;
            text-align: center;
            color: #fff;
            font-family: Arial, sans-serif;
            padding: 50px;
            margin: 0;
        }

        .message {
            font-size: 24px;
            margin-bottom: 20px;
            color: #000;
            opacity: 0;
            animation: fadeIn 2s ease-in-out forwards;
        }

        @keyframes fadeIn {
            0% {
                opacity: 0;
                transform: translateY(50px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        .container {
            max-width: 600px;
            margin: auto;
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
            margin-top: 80px; /* Adjust as needed based on your navbar height */
        }
    </style>
</head>
<body>
    <div class="message">
        <h2>Payment successful!</h2>
    </div>
    <div class="message">
        <h2>Thank you for using our system!</h2>
    </div>
</body>
</html>
