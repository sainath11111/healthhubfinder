<?php
// login.php

// Initialize variables
$hospital = $_GET['hospital'] ?? '';  // Get the hospital name if it's passed
$errorMessage = '';

// Include database connection
include 'db.php'; // Make sure you have a file that establishes the database connection

// Check for valid user login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $role = $_POST['role'] ?? '';
    $hospitalName = $_POST['hospitalName'] ?? '';

    // Check if username is correct
    if ($username === 'healthhub') {
        if ($role === 'superadmin') {
            // Validate password for superadmin role
            if ($password === 'healthhub') {
                // Redirect to manage_hos.php for superadmin role
                header('Location: manage_hos.php');
                exit;
            } else {
                $errorMessage = '❌ Incorrect password. Please try again.';
            }
        } else if ($role === 'admin') {
            // Admin role - Validate the hospital name and password
            if (empty($hospitalName)) {
                $errorMessage = '⚠️ Please enter the hospital name for admin.';
            } else {
                // Query the database to check if the hospital name and password match
                $query = "SELECT * FROM hospitals WHERE name = $1";
                $result = pg_query_params($conn, $query, array($hospitalName));
                
                if ($result && pg_num_rows($result) > 0) {
                    $hospitalData = pg_fetch_assoc($result);
                    
                    // Check if the password matches
                    if ($password === $hospitalData['password']) {
                        // If password is correct, display hospital details
                        $hospitalDetails = $hospitalData; // Store hospital data
                    } else {
                        $errorMessage = '❌ Incorrect password for this hospital. Please try again.';
                    }
                } else {
                    $errorMessage = '❌ Hospital name not found in the database.';
                }
            }
        } else {
            $errorMessage = '⚠️ Please select a valid role.';
        }
    } else {
        $errorMessage = '❌ Incorrect username or password. Please try again.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <!-- Link to Google Fonts and Bootstrap CSS -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('image/bg2.webp'); /* Replace with your image URL */
            background-size: cover;
            background-position: center;
            font-family: 'Poppins', sans-serif;
            color: #333;
        }

        .login-container {
            max-width: 450px;
            margin: 100px auto;
            background-color: rgba(255, 255, 255, 0.9);
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            animation: fadeIn 0.5s ease-out;
        }

        .login-container h2 {
            font-size: 32px;
            font-weight: 600;
            text-align: center;
            color: #0072ff;
            margin-bottom: 20px;
        }

        .form-control, .form-select {
            border-radius: 8px;
            padding: 12px;
            font-size: 16px;
            margin-bottom: 20px;
            transition: all 0.3s;
        }

        .form-control:focus, .form-select:focus {
            border-color: #0072ff;
            box-shadow: 0 0 10px rgba(0, 114, 255, 0.5);
        }

        button {
            background-color: #0072ff;
            color: white;
            border: none;
            padding: 12px;
            width: 100%;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s;
        }

        button:hover {
            background-color: #005bb5;
        }

        .error-message {
            color: #e74c3c;
            font-size: 14px;
            margin-top: 15px;
            text-align: center;
        }

        .hospital-details {
            margin-top: 40px;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .hospital-details h2 {
            color: #0072ff;
            font-size: 24px;
            text-align: center;
        }

        .hospital-details p {
            font-size: 16px;
        }

        .hospital-details a {
            color: #0072ff;
            text-decoration: none;
        }

        .hospital-details a:hover {
            text-decoration: underline;
        }

        .update-btn {
            position: absolute;
            bottom: 20px;
            right: 20px;
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }

        .update-btn:hover {
            background-color: #218838;
        }

        @keyframes fadeIn {
            0% { opacity: 0; transform: translateY(20px); }
            100% { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

    <div class="login-container">
        <h2>🔐 Login</h2>
        <form id="loginForm" method="POST">
            <input type="text" id="username" name="username" class="form-control" placeholder="Username" required><br>
            <input type="password" id="password" name="password" class="form-control" placeholder="Password" required><br>
            <select id="role" name="role" class="form-select" required>
                <option value="" disabled selected>Select Role</option>
                <option value="admin">Admin 🏥</option>
                <option value="superadmin">Super Admin 👑</option>
            </select><br>

            <!-- Hospital name input field initially hidden -->
            <input type="text" id="hospitalName" name="hospitalName" class="form-control hospital-name" placeholder="Enter Hospital Name" style="display: none;"><br>

            <button type="submit">Login</button>
            <a href="healthhub.php" class="btn btn-secondary btn-block" style="margin-top: 10px;">🔙 Back</a>
            <?php if (isset($errorMessage) && $errorMessage): ?>
                <div class="error-message"><?= $errorMessage ?></div>
            <?php endif; ?>
        </form>
    </div>

    <?php if (isset($hospitalDetails)): ?>
        <div class="hospital-details">
            <h2>Hospital Information</h2>
            <p><strong>Name:</strong> <?= htmlspecialchars($hospitalDetails['name']) ?></p>
            <p><strong>Address:</strong> <?= htmlspecialchars($hospitalDetails['address']) ?></p>
            <p><strong>City:</strong> <?= htmlspecialchars($hospitalDetails['city']) ?></p>
            <p><strong>State:</strong> <?= htmlspecialchars($hospitalDetails['state']) ?></p>
            <p><strong>Phone Number:</strong> <?= htmlspecialchars($hospitalDetails['phone_number']) ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($hospitalDetails['email']) ?></p>
            <p><strong>Specialties:</strong> <?= htmlspecialchars($hospitalDetails['specialties']) ?></p>
            <p><strong>Rating:</strong> <?= htmlspecialchars($hospitalDetails['rating']) ?></p>
            <p><strong>Website:</strong> <a href="<?= htmlspecialchars($hospitalDetails['website_link']) ?>" target="_blank"><?= htmlspecialchars($hospitalDetails['website_link']) ?></a></p>

            <!-- Update Button (Link to update_hospital.php) -->
            <a href="update.php?hospital=<?= urlencode($hospitalDetails['name']) ?>" class="update-btn">Update</a>
        </div>
    <?php endif; ?>

    <script>
        // Show or hide the hospital name input field based on role selection
        document.getElementById('role').addEventListener('change', function() {
            var role = this.value;
            var hospitalNameField = document.getElementById('hospitalName');
            
            if (role === 'admin') {
                hospitalNameField.style.display = 'block'; // Show hospital name field if 'admin' selected
            } else {
                hospitalNameField.style.display = 'none'; // Hide hospital name field for other roles
            }
        });
    </script>

</body>
</html>

