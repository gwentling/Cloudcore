<?php
session_start();
require 'db_connect.php';  
if (!isset($conn)) {
    die("Database connection not established.");
}

// Fetch dishes along with category name from the Categories table
$sql = "SELECT d.dish_name, d.price, d.description, c.category_name 
        FROM dishes d
        JOIN categories c ON d.category_id = c.category_id
        ORDER BY c.category_name";  
$stmt = $conn->prepare($sql);
$stmt->execute();
$dishes = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Organize dishes by category name
$categories = [];
foreach ($dishes as $dish) {
    $categories[$dish['category_name']][] = $dish;
}

// Sort categories to move 'Desserts' to the end
uksort($categories, function ($a, $b) {
    if ($a === 'Desserts') return 1;
    if ($b === 'Desserts') return -1;
    return strcmp($a, $b); 
});


// Initialize cart if not set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Handle "Add to Cart" form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['dish_name'], $_POST['price'])) {
    $dish_name = $_POST['dish_name'];
    $price = floatval($_POST['price']);
    $found = false;

    // Loop through the cart to see if the dish already exists
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['dish_name'] === $dish_name) {
            // If dish is found, increment the quantity
            $item['quantity'] += 1;
            $found = true;
            break;
        }
    }

    // If dish is not found, add it with quantity 1
    if (!$found) {
        $_SESSION['cart'][] = [
            'dish_name' => $dish_name,
            'price' => $price,
            'quantity' => 1 
        ];
    }

    header("Location: checkout.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Place Order</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body class="place-order-page">
    <div class="container">
        <h1 class="text-center">Menu</h1>
        
        <?php foreach ($categories as $category_name => $dishes): ?>
            <div class="place-order-category">
                <h2><?php echo htmlspecialchars($category_name); ?></h2>  
                <div class="place-order-divider"></div>
                <ul class="place-order-list">
                    <?php foreach ($dishes as $dish): ?>
                        <li class="place-order-item">
                            <div class="dish-title-price">
                                <h3><?php echo htmlspecialchars($dish['dish_name']); ?></h3>
                                <p class="price">$<?php echo number_format($dish['price'], 2); ?></p>
                            </div>
                            <div class="desc-button-container">
                                <p class="description"><?php echo htmlspecialchars($dish['description']); ?></p>
                                <form action="" method="POST">
                                    <input type="hidden" name="dish_name" value="<?php echo htmlspecialchars($dish['dish_name']); ?>">
                                    <input type="hidden" name="price" value="<?php echo htmlspecialchars($dish['price']); ?>">
                                    <button type="submit" class="add-to-cart-btn">Add to Cart</button>
                                </form>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
