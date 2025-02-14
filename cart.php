<?php
session_start();

// Tax and fees settings
$tax_rate = 0.08; // 8% sales tax
$delivery_fee = 5.00; // Flat delivery fee
$discount = 0; // Default no discount
$promo_code = "";

// Apply Promo Code
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['promo_code'])) {
    $promo_code = trim($_POST['promo_code']);

    // Sample promo codes (you can expand this list)
    $valid_promo_codes = [
        "SAVE10" => 10, // 10% off
        "FREESHIP" => $delivery_fee // Free shipping
    ];

    if (array_key_exists($promo_code, $valid_promo_codes)) {
        $discount = $valid_promo_codes[$promo_code];
    } else {
        $error = "❌ Invalid promo code.";
    }
}

// Calculate cart totals
$subtotal = 0;
if (!empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $subtotal += $item['price'] * $item['quantity'];
    }
}

$tax = $subtotal * $tax_rate;
$total = $subtotal + $tax + $delivery_fee - $discount;

// Ensure total doesn't go negative
if ($total < 0) {
    $total = 0;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Shopping Cart - Korealicious</title>
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
        <a href="cart.php" class="btn btn-warning">Cart (<?php echo isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0; ?>)</a>
        <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>
</nav>

<!-- Shopping Cart -->
<div class="container mt-5">
    <h2 class="text-center">Your Shopping Cart</h2>

    <?php if (!empty($_SESSION['cart'])): ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Dish</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($_SESSION['cart'] as $index => $item): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['dish_name']); ?></td>
                        <td>$<?php echo number_format($item['price'], 2); ?></td>
                        <td><?php echo $item['quantity']; ?></td>
                        <td>$<?php echo number_format($item['price'] * $item['quantity'], 2); ?></td>
                        <td>
                            <a href="remove_from_cart.php?index=<?php echo $index; ?>" class="btn btn-danger">Remove</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h3 class="text-end">Subtotal: $<?php echo number_format($subtotal, 2); ?></h3>
        <h4 class="text-end">Tax (8%): $<?php echo number_format($tax, 2); ?></h4>
        <h4 class="text-end">Delivery Fee: $<?php echo number_format($delivery_fee, 2); ?></h4>

        <?php if ($discount > 0): ?>
            <h4 class="text-end text-success">Promo Discount: -$<?php echo number_format($discount, 2); ?></h4>
        <?php endif; ?>

        <h3 class="text-end fw-bold">Total: $<?php echo number_format($total, 2); ?></h3>

        <!-- Promo Code Form -->
        <form action="cart.php" method="POST" class="d-flex justify-content-end mt-3">
            <input type="text" name="promo_code" class="form-control w-25 me-2" placeholder="Enter promo code">
            <button type="submit" class="btn btn-primary">Apply</button>
        </form>
        <?php if (!empty($error)) { echo "<p class='text-danger text-end'>$error</p>"; } ?>

        <div class="text-end mt-3">
            <a href="checkout.php" class="btn btn-success">Proceed to Checkout</a>
        </div>

    <?php else: ?>
        <p class="text-center">Your cart is empty.</p>
    <?php endif; ?>
</div>

</body>
</html>
