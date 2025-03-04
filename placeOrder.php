<?php
require_once('db_connect.php');
session_start();

// Fetch dishes grouped by meal type
$query = "SELECT dish_name, description, price, meal_type FROM Dishes ORDER BY FIELD(meal_type, 'Appetizer', 'Entree', 'Dessert')";
$statement = $db->prepare($query);
$statement->execute();
$dishes = $statement->fetchAll(PDO::FETCH_ASSOC);

// Group dishes by category
$categories = ['Appetizer' => [], 'Entree' => [], 'Dessert' => []];
foreach ($dishes as $dish) {
    $categories[$dish['meal_type']][] = $dish;
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
<body>
    <header>
        <h1>Place Your Order</h1>
    </header>
    <main>
        <?php foreach ($categories as $category => $dishes): ?>
            <h2><?php echo htmlspecialchars($category); ?></h2>
            <ul>
                <?php foreach ($dishes as $dish): ?>
                    <li>
                        <h3><?php echo htmlspecialchars($dish['dish_name']); ?></h3>
                        <p><?php echo htmlspecialchars($dish['description']); ?></p>
                        <p><strong>Price:</strong> $<?php echo number_format($dish['price'], 2); ?></p>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endforeach; ?>
    </main>
</body>
</html>
