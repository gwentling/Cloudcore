<?php
session_start(); // Start session to track the order

// Connect to database
$pdo = new PDO("mysql:host=localhost;dbname=restaurant", "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Fetch menu items categorized
$query = "SELECT * FROM Dishes ORDER BY 
          FIELD(meal_type, 'Appetizer', 'Entree', 'Dessert'), dish_name";
$stmt = $pdo->prepare($query);
$stmt->execute();
$menuItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Handle Add to Order
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['dish_id'])) {
    $dish_id = $_POST['dish_id'];
    $dish_name = $_POST['dish_name'];
    $price = $_POST['price'];
    
    if (!isset($_SESSION['order'])) {
        $_SESSION['order'] = [];
    }
    
    // Add dish to session order
    if (isset($_SESSION['order'][$dish_id])) {
        $_SESSION['order'][$dish_id]['quantity'] += 1;
    } else {
        $_SESSION['order'][$dish_id] = ['name' => $dish_name, 'price' => $price, 'quantity' => 1];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Place Order</title>
</head>
<body>
    <h1>Menu</h1>
    <a href="viewCart.php">View Cart (<?php echo isset($_SESSION['order']) ? count($_SESSION['order']) : 0; ?>)</a>
    <hr>
    <?php
    $currentCategory = '';
    foreach ($menuItems as $item):
        if ($item['meal_type'] !== $currentCategory) {
            $currentCategory = $item['meal_type'];
            echo "<h2>{$currentCategory}s</h2>";
        }
    ?>
        <p><strong><?php echo $item['dish_name']; ?></strong> - $<?php echo number_format($item['price'], 2); ?></p>
        <form method="post">
            <input type="hidden" name="dish_id" value="<?php echo $item['dish_id']; ?>">
            <input type="hidden" name="dish_name" value="<?php echo $item['dish_name']; ?>">
            <input type="hidden" name="price" value="<?php echo $item['price']; ?>">
            <button type="submit">Add to Order</button>
        </form>
    <?php endforeach; ?>
</body>
</html>


