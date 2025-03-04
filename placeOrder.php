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
        <div style="display: flex; justify-content: space-between; align-items: center;">
    </header>

<main>
          <div class="menu-list">
                    <h2>Appetizers</h2>
                    <!-- search bar -->
                    <form method="get" action="index.php">
                              <input type="text" name="filter" value="<?php echo htmlspecialchars($menuFilter); ?>" placeholder="">
                              <button type="submit">Search</button>
                    </form>
