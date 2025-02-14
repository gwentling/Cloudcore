<?php
session_start();

// Ensure the user has items in the cart before checkout
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    header("Location: menu.php");
    exit();
}

// Tax and fees settings
$tax_rate = 0.08; // 8% sales tax
$delivery_fee = 5.00; // Flat delivery fee
$subtotal = 0;
foreach ($_SESSION['cart'] as $item) {
    $subtotal += $item['price'] * $item['quantity'];
}
$tax = $subtotal * $tax_rate;
$total = $subtotal + $tax + $delivery_fee;

// Handle payment form submission
$success = "";
$error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $card_number = trim($_POST['card_number']);
    $card_name = trim($_POST['card_name']);
    $expiry_date = trim($_POST['expiry_date']);
    $cvv = trim($_POST['cvv']);

    if (!empty($card_number) && !empty($card_name) && !empty($expiry_date) && !empty($cvv)) {
        // Simulate payment processing (You can integrate Stripe/PayPal later)
        $success = "✅ Payment successful! Your order has been placed.";
        unset($_SESSION['cart']); // Clear cart after successful payment
    } else {
        $error = "❌ Please fill in all payment details.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Checkout - Korealicious</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg bg-dark navbar-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="menu.php">Korealicious</a>
        <a href="cart.php" class="btn btn-warning">Cart</a>
        <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>
</nav>

<!-- Checkout Section -->
<div class="container mt-5">
    <h2 class="text-center">Checkout</h2>

    <?php if (!empty($success)): ?>
        <p class="text-success text-center"><?php echo $success; ?></p>
    <?php else: ?>

        <h4>Order Summary</h4>
        <table class="table">
            <thead>
                <tr>
                    <th>Dish</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($_SESSION['cart'] as $item): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['dish_name']); ?></td>
                        <td>$<?php echo number_format($item['price'], 2); ?></td>
                        <td><?php echo $item['quantity']; ?></td>
                        <td>$<?php echo number_format($item['price'] * $item['quantity'], 2); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h3 class="text-end">Subtotal: $<?php echo number_format($subtotal, 2); ?></h3>
        <h4 class="text-end">Tax (8%): $<?php echo number_format($tax, 2); ?></h4>
        <h4 class="text-end">Delivery Fee: $<?php echo number_format($delivery_fee, 2); ?></h4>
        <h3 class="text-end fw-bold">Total: $<?php echo number_format($total, 2); ?></h3>

        <!-- Payment Form -->
        <h4 class="mt-4">Enter Payment Information</h4>
        <?php if (!empty($error)) { echo "<p class='text-danger'>$error</p>"; } ?>
        <form action="checkout.php" method="POST" class="w-50 mx-auto p-4 border rounded bg-light">
            <div class="mb-3">
                <label for="card_name" class="form-label">Cardholder Name:</label>
                <input type="text" class="form-control" id="card_name" name="card_name" required>
            </div>
            <div class="mb-3">
                <label for="card_number" class="form-label">Card Number:</label>
                <input type="text" class="form-control" id="card_number" name="card_number" required>
            </div>
            <div class="mb-3">
                <label for="expiry_date" class="form-label">Expiry Date (MM/YY):</label>
                <input type="text" class="form-control" id="expiry_date" name="expiry_date" required>
            </div>
            <div class="mb-3">
                <label for="cvv" class="form-label">CVV:</label>
                <input type="text" class="form-control" id="cvv" name="cvv" required>
            </div>
            <button type="submit" class="btn btn-success w-100">Complete Payment</button>
        </form>

    <?php endif; ?>
</div>

</body>
</html>
