<?php
// update_hospital.php

// Include database connection
include 'db.php';

// Initialize variables
$hospitalName = $_GET['hospital'] ?? ''; // Get the hospital name from the URL parameter
$errorMessage = '';
$successMessage = '';

// If the hospital name is empty, redirect back to login page or any other page
if (empty($hospitalName)) {
    header('Location: login.php');
    exit;
}

// Fetch hospital data from the database
$query = "SELECT * FROM hospitals WHERE name = $1";
$result = pg_query_params($conn, $query, array($hospitalName));

if ($result && pg_num_rows($result) > 0) {
    $hospitalData = pg_fetch_assoc($result);
} else {
    $errorMessage = '❌ Hospital not found in the database.';
}

// Handle form submission to update hospital data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $address = $_POST['address'] ?? '';
    $city = $_POST['city'] ?? '';
    $state = $_POST['state'] ?? '';
    $phone_number = $_POST['phone_number'] ?? '';
    $email = $_POST['email'] ?? '';
    $specialties = $_POST['specialties'] ?? '';
    $rating = $_POST['rating'] ?? '';
    $website_link = $_POST['website_link'] ?? '';

    // Validate input
    if (empty($name) || empty($address) || empty($city) || empty($state) || empty($phone_number) || empty($email)) {
        $errorMessage = '⚠️ All fields are required!';
    } else {
        // Update hospital details in the database
        $updateQuery = "
            UPDATE hospitals SET 
                name = $1, 
                address = $2, 
                city = $3, 
                state = $4, 
                phone_number = $5, 
                email = $6, 
                specialties = $7, 
                rating = $8, 
                website_link = $9
            WHERE name = $10
        ";

        $result = pg_query_params($conn, $updateQuery, array($name, $address, $city, $state, $phone_number, $email, $specialties, $rating, $website_link, $hospitalName));

        if ($result) {
            $successMessage = '✅ Hospital details updated successfully!';
            echo "<script>
                setTimeout(function() {
                    window.location.href = 'admin.php';
                }, 1500);
            </script>";
        } else {
            $errorMessage = '❌ Failed to update hospital details. Please try again.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Hospital Details</title>
    <!-- Link to Google Fonts and Bootstrap CSS -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            color: #333;
            background-color: #f5f5f5;
            padding: 20px;
        }

        .update-container {
            max-width: 800px;
            margin: 50px auto;
            background-color: rgba(255, 255, 255, 0.9);
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .update-container h2 {
            font-size: 32px;
            font-weight: 600;
            text-align: center;
            color: #0072ff;
            margin-bottom: 20px;
        }

        .form-control {
            border-radius: 8px;
            padding: 12px;
            font-size: 16px;
            margin-bottom: 20px;
            transition: all 0.3s;
        }

        .form-control:focus {
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
            color:white;
        }

        .error-message {
            color: #e74c3c;
            font-size: 14px;
            margin-top: 15px;
            text-align: center;
        }

        .success-message {
            color: #28a745;
            font-size: 14px;
            margin-top: 15px;
            text-align: center;
        }
    </style>
</head>
<body>

    <div class="update-container">
        <h2>Update Hospital Details</h2>

        <?php if (isset($errorMessage) && $errorMessage): ?>
            <div class="error-message"><?= $errorMessage ?></div>
        <?php endif; ?>

        <?php if (isset($successMessage) && $successMessage): ?>
            <div class="success-message"><?= $successMessage ?></div>
        <?php endif; ?>

        <form method="POST">
            <input type="text" name="name" class="form-control" placeholder="Hospital Name" value="<?= htmlspecialchars($hospitalData['name']) ?>" required>
            <input type="text" name="address" class="form-control" placeholder="Address" value="<?= htmlspecialchars($hospitalData['address']) ?>" required>
            <input type="text" name="city" class="form-control" placeholder="City" value="<?= htmlspecialchars($hospitalData['city']) ?>" required>
            <input type="text" name="state" class="form-control" placeholder="State" value="<?= htmlspecialchars($hospitalData['state']) ?>" required>
            <input type="text" name="phone_number" class="form-control" placeholder="Phone Number" value="<?= htmlspecialchars($hospitalData['phone_number']) ?>" required>
            <input type="email" name="email" class="form-control" placeholder="Email" value="<?= htmlspecialchars($hospitalData['email']) ?>" required>
            <input type="text" name="specialties" class="form-control" placeholder="Specialties" value="<?= htmlspecialchars($hospitalData['specialties']) ?>">
            <input type="text" name="rating" class="form-control" placeholder="Rating" value="<?= htmlspecialchars($hospitalData['rating']) ?>">
            <input type="url" name="website_link" class="form-control" placeholder="Website URL" value="<?= htmlspecialchars($hospitalData['website_link']) ?>">

            <button type="submit">Update Hospital</button>
        </form>
    </div>

</body>
</html>

