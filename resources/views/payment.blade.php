<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #306EE8;
            text-align: center;
            margin-bottom: 20px;
        }
        .button-wrapper {
            text-align: center;
        }
        #pay-button {
            background-color: #306EE8;
            color: #fff;
            border: none;
            padding: 15px 30px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        #pay-button:hover {
            background-color: #245bb0;
        }
        .alert {
            display: none;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
            color: #fff;
        }
        .alert.success {
            background-color: #4caf50;
        }
        .alert.pending {
            background-color: #ff9800;
        }
        .alert.error {
            background-color: #f44336;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Complete Your Payment</h1>
        <div class="button-wrapper">
            <button id="pay-button">Pay Now</button>
        </div>
        <div id="payment-alert" class="alert"></div>
    </div>

    <script>
        document.getElementById('pay-button').addEventListener('click', function () {
    snap.pay('{{ $snapToken }}', {
        onSuccess: function (result) {
            showAlert('Payment Success', 'success');
            window.location.href = "/payment-success/{{ $order->order_id }}"; // Redirect with orderId
        },
        onPending: function (result) {
            showAlert('Payment Pending', 'pending');
            window.location.href = "/payment-pending"; // Redirect to pending page
        },
        onError: function (result) {
            showAlert('Payment Error', 'error');
            window.location.href = "/payment-failed"; // Redirect to failed page
        },
    });
});


        function showAlert(message, type) {
            var alert = document.getElementById('payment-alert');
            alert.className = 'alert ' + type;
            alert.textContent = message;
            alert.style.display = 'block';
        }
    </script>
</body>
</html>
