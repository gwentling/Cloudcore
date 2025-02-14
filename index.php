<?php
session_start();
require_once 'db_connect.php'; // Include the database connection file

// Fetch menu items grouped by meal type from the database
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
    <title>Korealicious</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Alumni+Sans">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg fixed-top opacity-hover-off" id="myNavbar">
    <div class="container-fluid">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="#" style="font-size: 2rem;">HOME</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#menu" style="font-size: 2rem;">MENU</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#about" style="font-size: 2rem;">ABOUT</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#contact" style="font-size: 2rem;">CONTACT</a>
            </li>
        </ul>
        <a href="login.php" class="btn btn-primary btn-lg ms-auto">Login</a>
    </div>
</nav>

<!-- Header with image -->
<header class="bg-img d-flex flex-column justify-content-between" id="home">
    <div></div>
    <div class="d-flex flex-column text-center">
        <span class="display-1">KOREALICIOUS<br>IT'S NOT JUST DELICIOUS, IT'S KOREALICIOUS!</span>
        <p><a href="#menu" class="btn btn-lg btn-dark hover-btn fs-2">View Menu</a></p>
    </div>
    <div class="d-flex justify-content-start">
        <span class="bg-dark text-white p-3 h2">Open Thursday-Sunday 11am-10pm</span>
    </div>
</header>

<!-- Menu Container -->
<div class="container-fluid bg-black text-white py-5 display-4" id="menu">
    <div class="container">

        <h1 class="text-center display-2 mb-5">MENU</h1>

        <div class="text-center border border-dark">
            <div class="d-flex">
                <a href="javascript:void(0)" onclick="openMenu(event, 'Appetizers');" class="col-4 tablink p-3 hover-red" id="mainLink">Appetizers</a>
                <a href="javascript:void(0)" onclick="openMenu(event, 'Entrees');" class="col-4 tablink p-3 hover-red">Entrees</a>
                <a href="javascript:void(0)" onclick="openMenu(event, 'Desserts');" class="col-4 tablink p-3 hover-red">Desserts</a>
            </div>
        </div>

        <!-- Appetizers -->
        <div id="Appetizers" class="container-fluid menu p-4 bg-white">
            <?php foreach ($organizedMenu['Appetizer'] as $item): ?>
                <div class="d-flex align-items-center mb-4">
                    <img src="images/appetizers/<?php echo htmlspecialchars($item['dish_name']); ?>.jpg" alt="<?php echo htmlspecialchars($item['dish_name']); ?>" class="img-fluid rounded" style="width: 124px; height: 124px; margin-right: 15px;">
                    <div>
                        <div class="d-flex justify-content-between align-items-baseline">
                            <h1 class="mb-0 display-3"><b><?php echo htmlspecialchars($item['dish_name']); ?></b></h1>
                            <span class="badge bg-dark text-white">$<?php echo number_format($item['price'], 2); ?></span>
                        </div>
                        <p class="text-muted"><?php echo htmlspecialchars($item['description']); ?></p>
                    </div>
                </div>
                <hr class="text-muted">
            <?php endforeach; ?>
        </div>

        <!-- Entrees -->
        <div id="Entrees" class="container-fluid menu p-4 bg-white">
            <?php foreach ($organizedMenu['Entree'] as $item): ?>
                <div class="d-flex align-items-center mb-4">
                    <img src="images/entrees/<?php echo htmlspecialchars($item['dish_name']); ?>.jpg" alt="<?php echo htmlspecialchars($item['dish_name']); ?>" class="img-fluid rounded" style="width: 124px; height: 124px; margin-right: 15px;">
                    <div>
                        <div class="d-flex justify-content-between align-items-baseline">
                            <h1 class="mb-0 display-3"><b><?php echo htmlspecialchars($item['dish_name']); ?></b></h1>
                            <span class="badge bg-dark text-white">$<?php echo number_format($item['price'], 2); ?></span>
                        </div>
                        <p class="text-muted"><?php echo htmlspecialchars($item['description']); ?></p>
                    </div>
                </div>
                <hr class="text-muted">
            <?php endforeach; ?>
        </div>

        <!-- Desserts -->
        <div id="Desserts" class="container-fluid menu p-4 bg-white">
            <?php foreach ($organizedMenu['Dessert'] as $item): ?>
                <div class="d-flex align-items-center mb-4">
                    <img src="images/desserts/<?php echo htmlspecialchars($item['dish_name']); ?>.jpg" alt="<?php echo htmlspecialchars($item['dish_name']); ?>" class="img-fluid rounded" style="width: 124px; height: 124px; margin-right: 15px;">
                    <div>
                        <div class="d-flex justify-content-between align-items-baseline">
                            <h1 class="mb-0 display-3"><b><?php echo htmlspecialchars($item['dish_name']); ?></b></h1>
                            <span class="badge bg-dark text-white">$<?php echo number_format($item['price'], 2); ?></span>
                        </div>
                        <p class="text-muted"><?php echo htmlspecialchars($item['description']); ?></p>
                    </div>
                </div>
                <hr class="text-muted">
            <?php endforeach; ?>
        </div>
    </div>
</div>

<!-- About -->
<div class="container-fluid py-5 text-white" style="background-color: lightsteelblue;" id="about">
    <div class="container">
        <h1 class="text-center display-2 mb-3">ABOUT</h1>
        <h1 class="display-4"><b>Hours</b></h1>
        <div class="row fs-2">
            <div class="col-6">
                <p>Thursday-Sunday 11am-10pm</p>
                <p>Monday-Wednesday CLOSED</p>
            </div>
        </div>
        </br>
        </br>
        </br>
        <h1 class="display-4"><b>OUR STORY BEGINS IN SEOUL,</br>ANCIENT CAPITAL OF THE KOREAN CHOSUN DYNASTY.</b></h1>
        <p class="fs-2">Family owned and cherished through the years, Korealicious has been voted Central Pa's Best Restaurant by Taste Magazine year after year.  A love story between a girl from a traditional Korean family in Seoul with a Royal heritage that goes back centuries, and an ordinary traveling American boy from Central Pennsylvania is what brought us the famous Werner family.  Our goal was to bring the magic of authentic Korean cuisine to PA.  Balancing the authenticity, employing centuries old flavors, catered to the Central PA savory flavor pallet, Korealicious has proudly served thousands of satisfied customers year after year to bring an exotic, fun atmosphere to the state's capital.  We love our loyal patrons.  If we've never met, come on in . . . we love to grow our family.</p>
    </div>
</div>




<!-- Contact -->
<div class="container-fluid bg-secondary text-white py-5 fs-2" id="contact">
  <div class="container">
    <h1 class="text-center display-2 mb-5">CONTACT</h1>
    <p>Korealicious</p>
    <p>Flagship Location</p>
    <p>829 State St, Lemoyne, PA 17043, USA</p>
    <p>717-317-9015</p>  
  </div>
</div>




<!-- Footer -->
<footer class="text-center bg-dark text-white py-4">
  <p class="fs-3 mb-0 ">
    Central PA's Korean Restaurant
  </p>
</footer>

<script src="script.js"></script>
</body>
</html>


