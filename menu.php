<?php
session_start();
require_once 'db_connect.php';

// Ensure only logged-in customers can access
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Customer') {
    header("Location: login.php");
    exit();
}

// Fetch menu items grouped by meal type
try {
    $query = "SELECT dish_id, dish_name, description, price, meal_type FROM Dishes ORDER BY meal_type";
    $stmt = $db->prepare($query);
    $stmt->execute();
    $menuItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("❌ Error fetching menu: " . $e->getMessage());
}

// Organize items by category
$organizedMenu = [
    "Appetizer" => [],
    "Entree" => [],
    "Dessert" => []
];

foreach ($menuItems as $item) {
    $organizedMenu[$item['meal_type']][] = $item;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Menu - Korealicious</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<!-- Navbar (Fixed at top) -->
<nav class="navbar navbar-expand-lg bg-dark navbar-dark fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="menu.php">Korealicious</a>
        <a href="cart.php" class="btn btn-warning">View Cart (<?php echo isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0; ?>)</a>
        <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>
</nav>

<!-- Menu Items -->
<div class="container mt-5 pt-5"> <!-- Added pt-5 to prevent navbar overlap -->
    <h2 class="text-center">Browse Our Menu</h2>

    <?php foreach ($organizedMenu as $mealType => $items): ?>
        <h3 class="mt-4"><?php echo htmlspecialchars($mealType); ?></h3>
        <div class="row">
            <?php foreach ($items as $item): ?>
                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($item['dish_name']); ?></h5>
                            <p class="card-text"><?php echo htmlspecialchars($item['description']); ?></p>
                            <p class="card-text"><strong>$<?php echo number_format($item['price'], 2); ?></strong></p>
                            <form action="add_to_cart.php" method="POST">
                                <input type="hidden" name="dish_id" value="<?php echo $item['dish_id']; ?>">
                                <input type="hidden" name="dish_name" value="<?php echo $item['dish_name']; ?>">
                                <input type="hidden" name="price" value="<?php echo $item['price']; ?>">
                                <button type="submit" class="btn btn-success">Add to Cart</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endforeach; ?>
</div>

</body>
</html>
