<?php
// Include the database connection file
include('db.php');

// Check if the hospital ID is passed
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the current hospital details
    $query = "SELECT * FROM hospitals WHERE id = $id";
    $result = pg_query($conn, $query);

    if (!$result) {
        die("Query failed: " . pg_last_error());
    }

    $hospital = pg_fetch_assoc($result);
}

// Check if the form is submitted to update the data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the updated data from the form
    $name = $_POST['name'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $phone_number = $_POST['phone_number'];
    $email = $_POST['email'];
    $specialties = $_POST['specialties'];
    $rating = $_POST['rating'];
    $website_link = $_POST['website_link'];
    $password = $_POST['password'];  // New password field

    // If a password is provided, update it as-is (without hashing)
    if (!empty($password)) {
        // Use the provided password directly (no hashing)
        $update_query = "UPDATE hospitals 
                         SET name = '$name', address = '$address', city = '$city', state = '$state', 
                             phone_number = '$phone_number', email = '$email', specialties = '$specialties', 
                             rating = $rating, website_link = '$website_link', password = '$password'
                         WHERE id = $id";
    } else {
        // If no password is provided, update the other fields without modifying the password
        $update_query = "UPDATE hospitals 
                         SET name = '$name', address = '$address', city = '$city', state = '$state', 
                             phone_number = '$phone_number', email = '$email', specialties = '$specialties', 
                             rating = $rating, website_link = '$website_link'
                         WHERE id = $id";
    }

    $update_result = pg_query($conn, $update_query);

    if ($update_result) {
        // Display success message and provide link to go back to manage_hos.php
        echo "<div class='success-message'><h3>Hospital details updated successfully!</h3>";
        echo "<p><a href='manage_hos.php'>Click here to go back to manage hospitals</a></p></div>";
    } else {
        echo "<div class='error-message'><h3>Error updating hospital: " . pg_last_error($conn) . "</h3></div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Hospital Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: 0 auto;
            padding: 30px;
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            margin-top: 50px;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin-bottom: 8px;
            font-weight: bold;
        }
        input[type="text"], input[type="email"], input[type="url"], input[type="number"], input[type="password"] {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        .success-message, .error-message {
            text-align: center;
            padding: 20px;
            margin: 20px 0;
        }
        .success-message h3 {
            color: #4CAF50;
        }
        .error-message h3 {
            color: #f44336;
        }
        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            font-size: 16px;
        }
        .back-link a {
            color: #4CAF50;
            text-decoration: none;
        }
        .back-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Update Hospital Details</h1>

    <?php if (isset($hospital)) { ?>
        <form action="update_hospital.php?id=<?php echo $id; ?>" method="POST">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($hospital['name']); ?>" required>

            <label for="address">Address:</label>
            <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($hospital['address']); ?>" required>

            <label for="city">City:</label>
            <input type="text" id="city" name="city" value="<?php echo htmlspecialchars($hospital['city']); ?>" required>

            <label for="state">State:</label>
            <input type="text" id="state" name="state" value="<?php echo htmlspecialchars($hospital['state']); ?>" required>

            <label for="phone_number">Phone Number:</label>
            <input type="text" id="phone_number" name="phone_number" value="<?php echo htmlspecialchars($hospital['phone_number']); ?>" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($hospital['email']); ?>" required>

            <label for="specialties">Specialties:</label>
            <input type="text" id="specialties" name="specialties" value="<?php echo htmlspecialchars($hospital['specialties']); ?>" required>

            <label for="rating">Rating:</label>
            <input type="number" id="rating" name="rating" value="<?php echo htmlspecialchars($hospital['rating']); ?>" min="1" max="5" required>

            <label for="website_link">Website Link:</label>
            <input type="url" id="website_link" name="website_link" value="<?php echo htmlspecialchars($hospital['website_link']); ?>" required>

            <label for="password">New Password:</label>
            <input type="password" id="password" name="password" placeholder="Enter new password">

            <input type="submit" value="Update Hospital">
        </form>
    <?php } else { ?>
        <p>Hospital not found.</p>
    <?php } ?>

</div>

</body>
</html>

<?php
// Close the database connection after use
pg_close($conn);
?>

