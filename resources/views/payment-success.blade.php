<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Success</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}"> <!-- Add your CSS file here -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa; /* Light gray background */
            color: #343a40; /* Dark text color */
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh; /* Full viewport height */
        }

        .container {
            background-color: #ffffff; /* White background for the container */
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1); /* Soft shadow */
            text-align: center;
            max-width: 400px; /* Maximum width for the container */
            width: 100%; /* Full width */
        }

        .alert {
            background-color: #d4edda; /* Light green background */
            border-color: #c3e6cb; /* Border color */
            color: #155724; /* Dark green text color */
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px; /* Space below alert */
        }

        h1 {
            margin: 0 0 10px; /* Spacing for the heading */
            font-size: 24px; /* Font size for the heading */
        }

        p {
            margin: 0; /* Remove margin for the paragraph */
            font-size: 16px; /* Font size for the paragraph */
        }

        .btn {
            display: inline-block; /* Inline-block for the button */
            padding: 10px 20px; /* Padding for the button */
            font-size: 16px; /* Font size for the button */
            color: #fff; /* White text */
            background-color: #007bff; /* Bootstrap primary color */
            border: none; /* No border */
            border-radius: 5px; /* Rounded corners */
            text-decoration: none; /* Remove underline */
            transition: background-color 0.3s ease; /* Transition for hover effect */
        }

        .btn:hover {
            background-color: #0056b3; /* Darker shade on hover */
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="alert alert-success">
            <h1>Payment Successful!</h1>
            <p>Your payment has been processed successfully. Thank you for your purchase!</p>
        </div>
        <a href="{{ url('/home') }}" class="btn">Back to Home</a>
    </div>
</body>
</html>
