<?php
// start session
session_start();

// database connection 
include('db_connect.php');

try {
    // connection to the database
    $pdo = new PDO($dsn, $username, $password);

    // PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // determine if the user is logged in or a guest
    if (isset($_SESSION['user_id'])) {
        // if logged in, use the user_id from the session
        $user_id = $_SESSION['user_id'];
    } else {
        // if not logged in, generate a unique guest ID 
        $user_id = session_id(); // use session ID as the guest ID
    }

    // check if  form is submitted via POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['dish_id']) && isset($_POST['quantity'])) {
            // get form data
            $dish_id = $_POST['dish_id'];
            $quantity = $_POST['quantity'];

            // prepare SQL statement to insert order into database
            $stmt = $pdo->prepare("INSERT INTO orders (user_id, dish_id, quantity) VALUES (:user_id, :dish_id, :quantity)");
            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':dish_id', $dish_id);
            $stmt->bindParam(':quantity', $quantity);

            // execute query
            $stmt->execute();

            // provide success message or redirect user
            echo "Order placed successfully!";
        } else {
            echo "Please select a dish and specify the quantity.";
        }
    }
} catch (PDOException $e) {
    // handle connection or query errors
    echo "Error: " . $e->getMessage();
}
?>

<!-- form to place the order -->
<form action="placeOrder.php" method="POST">
    <label for="dish_id">Dish:</label>
    <select name="dish_id" required>
        <?php
        // fetch available dishes from the database
        try {
            $stmt = $pdo->prepare("SELECT dish_id, dish_name FROM Dishes");
            $stmt->execute();
            $dishes = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($dishes as $dish) {
                echo "<option value='" . $dish['dish_id'] . "'>" . $dish['dish_name'] . "</option>";
            }
        } catch (PDOException $e) {
            echo "Error fetching dishes: " . $e->getMessage();
        }
        ?>
    </select>

    <label for="quantity">Quantity:</label>
    <input type="number" name="quantity" min="1" required>

    <button type="submit">Place Order</button>
</form>


