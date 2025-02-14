<?php
session_start();

// Check if request is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['dish_id'], $_POST['dish_name'], $_POST['price'])) {
        $dish_id = $_POST['dish_id'];
        $dish_name = $_POST['dish_name'];
        $price = $_POST['price'];

        // Create cart item
        $item = [
            "dish_id" => $dish_id,
            "dish_name" => $dish_name,
            "price" => $price,
            "quantity" => 1
        ];

        // If cart doesn't exist, create it
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        // Check if item is already in cart, update quantity
        $found = false;
        foreach ($_SESSION['cart'] as &$cartItem) {
            if ($cartItem['dish_id'] == $dish_id) {
                $cartItem['quantity'] += 1;
                $found = true;
                break;
            }
        }

        // If item is new, add it
        if (!$found) {
            $_SESSION['cart'][] = $item;
        }

        // Redirect back to menu
        header("Location: menu.php");
        exit();
    } else {
        die("❌ Error: Missing required fields.");
    }
} else {
    die("❌ Error: Invalid request.");
}
?>
