<?php
ini_set('display_errors', 1);  // Show errors
error_reporting(E_ALL); 
include 'db.php'; // Include the database connection file
$message = '';

// Process the form when submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $password = $_POST['password'];  // No hashing here
    $is_verified = isset($_POST['is_verified']) ? 1 : 0;  // Checkbox value

    // Validate the phone number to be exactly 10 digits
    if (strlen($phone_number) != 10 || !ctype_digit($phone_number)) {
        $message = "❌ Please enter a valid 10-digit phone number!";
    } else {
        // Prepare the SQL query to insert the data into the "User" table
        $query = "INSERT INTO \"User\" (name, email, phone_number, password, is_verified) VALUES ($1, $2, $3, $4, $5)";
        $result = pg_query_params($conn, $query, array($name, $email, $phone_number, $password, $is_verified));

        if ($result) {
            $message = "✅ User registered successfully!";
            
            // Redirect to the 'find_hos.php' page after successful submission
            header("Location: find_hos.php");
            exit();
        } else {
            $message = "❌ Error: " . pg_last_error($conn);
        }

        pg_close($conn); // Close the connection
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visiter 🏥</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('image/bg2.webp'); /* Replace with your image URL */
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
            max-width: 800px;
             margin-left: 300px; /* Center align */
    margin-right: auto;
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
        .btn-login {
            margin-top: 20px;
            background-color: #28a745;
            border-color: #28a745;
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 8px;
            display: block;
            text-align: center;
        }
        .btn-login:hover {
            background-color: #218838;
            border-color: #1e7e34;
            transform: scale(1.05);
        }
    </style>
</head>
<body>

    <div class="container mt-5">
        <div class="form-container">
            <h1>🌟 Welcome to HealthHubFinder</h1>

            <!-- Display message if any -->
            <?php if (!empty($message)): ?>
                <div class="alert alert-info">
                    <span class="emoji">💬</span><?php echo $message; ?>
                </div>
            <?php endif; ?>

            <!-- Registration Form -->
            <form method="POST">
                <div class="form-group">
                    <label for="name">📝 Name:</label>
                    <input type="text" id="name" name="name" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="email">📧 Email:</label>
                    <input type="email" id="email" name="email" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="phone_number">📱 Phone Number:</label>
                    <input type="text" id="phone_number" name="phone_number" class="form-control" 
                           pattern="\d{10}" title="Phone number must be 10 digits" required>
                </div>

                <div class="form-group">
                    <label for="password">🔒 Password:</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="is_verified">✔️ Verified:</label>
                    <input type="checkbox" id="is_verified" name="is_verified">
                </div>

                <!-- Find Button (Submit button that triggers form submission) -->
                <button type="submit" class="btn-login">Find 🔑</button>
            </form>

            <!-- Link to login page -->
            <a href="login.php" class="btn-login">Already have an account? Login here! 🔑</a>

        </div>
    </div>

</body>
</html>

