<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cardNumber = $_POST['card_number'] ?? '';
    $cardName = $_POST['card_name'] ?? '';
    $expiryDate = $_POST['expiry_date'] ?? '';
    $securityCode = $_POST['security_code'] ?? '';

    // Dummy validation example
    if (empty($cardNumber) || empty($cardName) || empty($expiryDate) || empty($securityCode)) {
        echo "<p style='color:red;'>All fields are required.</p>";
    } else {
        // In real-world, process the payment here.
        echo "<p style='color:green;'>Payment processed successfully (simulation).</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f4;
        }

        h1 {
            font-size: 36px;
            color: #333;
            margin-top: 0;
        }

        form {
            max-width: 400px;
            width: 100%;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: white;
        }

        input[type="text"], input[type="password"], input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        label {
            font-weight: bold;
        }

        p {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <h1>Payment Confirmation</h1>
    <form method="post">
        <label for="card_number">Card Number</label>
        <input type="text" id="card_number" name="card_number" placeholder="Enter your card number" required>

        <label for="card_name">Name on Card</label>
        <input type="text" id="card_name" name="card_name" placeholder="Enter name on card" required>

        <label for="expiry_date">Expiry Date</label>
        <input type="text" id="expiry_date" name="expiry_date" placeholder="MM/YYYY" required>

        <label for="security_code">Security Code</label>
        <input type="password" id="security_code" name="security_code" placeholder="CVV" required>

        <input type="submit" value="Pay Now">
    </form>
</body>
</html>
