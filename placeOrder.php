<?php
require_once('db_connect.php');
session_start();

$query = "SELECT dish_name, description, price, meal_type FROM Dishes ORDER BY FIELD(meal_type, 'Appetizer', 'Entree', 'Dessert')";
$statement = $db->prepare($query);
$statement->execute();
$dishes = $statement->fetchAll(PDO::FETCH_ASSOC);

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

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Alumni+Sans">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>

<body style="background-image: url('images/KoreanDishesBackground2.jpg'); background-size: cover; background-position: center; background-attachment: fixed;">
    
    <nav class="navbar navbar-expand-lg fixed-top opacity-hover-off" id="myNavbar">
      <div class="container-fluid">
          <ul class="navbar-nav">
            <li class="nav-item"><a class="nav-link" href="index.html" style="font-size: 2rem;">HOME</a></li>
            <li class="nav-item"><a class="nav-link" href="index.html#menu" style="font-size: 2rem;">MENU</a></li>
            <li class="nav-item"><a class="nav-link" href="index.html#about" style="font-size: 2rem;">ABOUT</a></li>
            <li class="nav-item"><a class="nav-link" href="index.html#contact" style="font-size: 2rem;">CONTACT</a></li>
          </ul>
      </div>
    </nav>

    <header>
        <section class="profile-container">
        <h1></h1>
    </header>

    <main class="pt-1">
        <?php foreach ($categories as $category => $dishes): ?>
            <section class="place-order-category">
                <h2><?php echo htmlspecialchars($category); ?></h2>
                <div class="place-order-divider"></div>
                
                <div class="place-order-items-container">
                    <ul class="place-order-list">
                        <?php foreach ($dishes as $dish): ?>
                            <li class="place-order-item">
                                <div class="item-info">
                                    <!-- Dish Name & Price on One Line -->
                                    <div class="dish-title-price">
                                        <h3><?php echo htmlspecialchars($dish['dish_name']); ?></h3>
                                        <p class="price">$<?php echo number_format($dish['price'], 2); ?></p>
                                    </div>
                                    
                                    <!-- Description & Add to Cart Button on the Same Line -->
                                    <div class="desc-button-container">
                                        <p class="description"><?php echo htmlspecialchars($dish['description']); ?></p>
                                        <form action="orderCart.php" method="POST">
                                            <input type="hidden" name="dish_name" value="<?php echo htmlspecialchars($dish['dish_name']); ?>">
                                            <input type="hidden" name="price" value="<?php echo htmlspecialchars($dish['price']); ?>">
                                            <button type="submit" class="add-to-cart-btn">Add to Cart</button>
                                        </form>
                                    </div>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </section>
        <?php endforeach; ?>
    </main>
</body>
