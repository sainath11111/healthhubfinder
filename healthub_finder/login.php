<?php
// Include the database connection
include 'db.php';

// Initialize a message variable
$message = '';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect form data
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate required fields
    if (empty($email) || empty($password)) {
        $message = "❌ Both email and password are required!";
    } else {
        // Check if connection is valid
        if (!$conn) {
            $message = "🚫 Database connection failed!";
        } else {
            // Query to fetch user data based on email
            $query = "SELECT * FROM \"User\" WHERE email = $1";
            $result = pg_query_params($conn, $query, array($email));

            // Check if a user with the provided email exists
            if ($result && pg_num_rows($result) > 0) {
                $user = pg_fetch_assoc($result);

                // Compare the password directly without hashing (plain text comparison)
                if ($password == $user['password']) {
                    // Successful login, redirect to find_hos.php
                    header('Location: find_hos.php');
                    exit(); // Ensure the script stops executing after redirect
                } else {
                    $message = "❌ Incorrect password!";
                }
            } else {
                $message = "❌ No user found with that email!";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login 🏥</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('image/bg.jpeg'); /* Replace with your image URL */
            background-size: cover;
            background-position: center;
            color: #333;
        }
        .form-container {
            background-color: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
            margin-top: 30px;
        }
        .form-container h1 {
            text-align: center;
            margin-bottom: 40px;
            font-size: 2.5rem;
            color: #007bff;
        }
        .form-group label {
            font-weight: bold;
        }
        .form-group input {
            border-radius: 8px;
            padding: 12px;
            border: 1px solid #ccc;
            margin-top: 5px;
            width: 100%;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            box-shadow: 0 4px 8px rgba(0, 123, 255, 0.3);
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
            transform: scale(1.05);
        }
        .alert-info {
            margin-top: 20px;
            font-size: 1.2rem;
        }
        .emoji {
            font-size: 2rem;
            margin-right: 10px;
        }
    </style>
</head>
<body>

    <div class="container mt-5">
        <div class="form-container">
            <h1>🔑 Login to HealthHubFinder</h1>

            <!-- Display a message if the operation was successful or failed -->
            <?php if (!empty($message)): ?>
                <div class="alert alert-info">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>

            <!-- Form to login -->
            <form method="POST">
                <div class="form-group">
                    <label for="email">📧 Email:</label>
                    <input type="email" id="email" name="email" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="password">🔒 Password:</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary btn-block">🚀 Login</button>
                
            </form>

        </div>
    </div>

</body>
</html>

