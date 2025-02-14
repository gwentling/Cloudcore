<?php
session_start();
require_once 'db_connect.php'; 

$error = ""; // Initialize error message variable

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (!empty($email) && !empty($password)) {
        try {
            // Fix: Search by email instead of username
            $query = "SELECT user_id, username, email, password, role FROM Users WHERE email = :email";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            
            // Debugging: Print user details if found
            if ($stmt->rowCount() > 0) {
                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                // Debugging: Check if user data is retrieved (Remove after testing)
                echo "<pre>";
                print_r($user);
                echo "</pre>";
                // exit(); // Uncomment this line to stop execution for debugging

                // Verify the hashed password
                if (password_verify($password, $user['password'])) {
                    // Store user info in session
                    $_SESSION['user_id'] = $user['user_id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['role'] = $user['role'];

                    // Redirect customers to menu.php where they can add items to cart
                    if ($user['role'] === 'Customer') {
                        header("Location: menu.php"); 
                        exit();
                    }
                    // Redirect admins to dashboard
                    elseif ($user['role'] === 'Admin') {
                        header("Location: dashboard.php"); 
                        exit();
                    }
                } else {
                    $error = "❌ Incorrect password. Please try again.";
                }
            } else {
                $error = "❌ No account found with that email.";
            }
        } catch (PDOException $e) {
            $error = "❌ Database error: " . $e->getMessage();
        }
    } else {
        $error = "❌ Please fill in all fields.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login - Korealicious</title>
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
        <a class="navbar-brand" href="index.html">Korealicious</a>
    </div>
</nav>

<!-- Login Form Section -->
<section class="container mt-5">
    <h2 class="text-center">Login to Your Account</h2>
    <form action="login.php" method="POST" class="w-50 mx-auto p-4 border rounded bg-light">
        <?php if (!empty($error)) { echo "<p class='text-danger text-center'>$error</p>"; } ?>
        <div class="mb-3">
            <label for="email" class="form-label">Email:</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password:</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-dark w-100">Login</button>
        <p class="mt-3 text-center">Don't have an account? <a href="createAccount.php">Sign up</a></p>
    </form>
</section>

<!-- Footer -->
<footer class="text-center bg-dark text-white py-4">
    <p class="fs-3 mb-0">Central PA's Korean Restaurant</p>
</footer>

<script src="script.js"></script>
</body>
</html>
