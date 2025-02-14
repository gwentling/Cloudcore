<?php
session_start();
require_once 'db_connect.php'; // Ensure the database connection is included

$error = ""; // Initialize error message variable
$success = ""; // Initialize success message variable

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);
    $role = 'Customer'; // Default role for new users

    if (!empty($username) && !empty($email) && !empty($phone) && !empty($first_name) && !empty($last_name) && !empty($password) && !empty($confirm_password)) {
        if ($password !== $confirm_password) {
            $error = "❌ Passwords do not match!";
        } else {
            try {
                // Check if username or email already exists
                $checkQuery = "SELECT username, email FROM Users WHERE username = :username OR email = :email";
                $checkStmt = $db->prepare($checkQuery);
                $checkStmt->bindParam(':username', $username);
                $checkStmt->bindParam(':email', $email);
                $checkStmt->execute();

                if ($checkStmt->rowCount() > 0) {
                    $error = "❌ Username or Email already exists!";
                } else {
                    // Hash the password securely
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                    // Insert user into database
                    $query = "INSERT INTO Users (username, email, phone, first_name, last_name, password, role) 
                              VALUES (:username, :email, :phone, :first_name, :last_name, :password, :role)";
                    $stmt = $db->prepare($query);
                    $stmt->bindParam(':username', $username);
                    $stmt->bindParam(':email', $email);
                    $stmt->bindParam(':phone', $phone);
                    $stmt->bindParam(':first_name', $first_name);
                    $stmt->bindParam(':last_name', $last_name);
                    $stmt->bindParam(':password', $hashed_password);
                    $stmt->bindParam(':role', $role);
                    $stmt->execute();

                    $success = "✅ Account created successfully! <a href='login.php'>Login here</a>";
                }
            } catch (PDOException $e) {
                $error = "❌ Database error: " . $e->getMessage();
            }
        }
    } else {
        $error = "❌ Please fill in all fields.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Account - Korealicious</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Alumni+Sans">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg fixed-top opacity-hover-off" id="myNavbar">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.html">Korealicious</a>
    </div>
</nav>

<!-- Registration Form -->
<section class="container mt-5">
    <h2 class="text-center">Create an Account</h2>
    <form action="createAccount.php" method="POST" class="w-50 mx-auto p-4 border rounded bg-light">
        <?php if (!empty($error)) { echo "<p class='text-danger text-center'>$error</p>"; } ?>
        <?php if (!empty($success)) { echo "<p class='text-success text-center'>$success</p>"; } ?>

        <div class="mb-3">
            <label for="username" class="form-label">Username:</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email:</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">Phone:</label>
            <input type="text" class="form-control" id="phone" name="phone" required>
        </div>
        <div class="mb-3">
            <label for="first_name" class="form-label">First Name:</label>
            <input type="text" class="form-control" id="first_name" name="first_name" required>
        </div>
        <div class="mb-3">
            <label for="last_name" class="form-label">Last Name:</label>
            <input type="text" class="form-control" id="last_name" name="last_name" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password:</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="mb-3">
            <label for="confirm_password" class="form-label">Confirm Password:</label>
            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
        </div>
        <button type="submit" class="btn btn-dark w-100">Register</button>
        <p class="mt-3 text-center">Already have an account? <a href="login.php">Login here</a></p>
    </form>
</section>

<!-- Footer -->
<footer class="text-center bg-dark text-white py-4">
    <p class="fs-3 mb-0">Central PA's Korean Restaurant</p>
</footer>

<script src="script.js"></script>
</body>
</html>
