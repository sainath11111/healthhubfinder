<?php
// Enable error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Include the database connection (replace 'db.php' with your actual DB connection file)
include 'db.php';

// Initialize a message variable
$message = '';

// Check if the form is submitted using POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Get form data (sanitize if necessary)
    $rating = $_POST['rating'];
    $comments = $_POST['comments'];

    // Ensure rating is within the valid range
    if ($rating < 1 || $rating > 5) {
        $message = "Error: Rating must be between 1 and 5.";
    } elseif (empty($comments)) {
        $message = "Error: Comments cannot be empty.";
    } else {
        // Prepare the SQL query with placeholders
        $query = "INSERT INTO review (rating, comments) VALUES ($1, $2)";

        // Execute the query with parameters
        $result = pg_query_params($conn, $query, array($rating, $comments));

        // Check if the query was successful
        if ($result) {
            $message = "Review submitted successfully!";
            // Redirect to hos_info.php after successful submission
            header('Location:find_hos.php');
            exit(); // Make sure to exit after header redirection
        } else {
            // If there was an error, show the error message
            $message = "Error: " . pg_last_error($conn);
        }

        // Close the database connection
        pg_close($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Your Review - HealthHubFinder</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom Styles -->
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-image: url('image/bg.jpeg'); /* Replace with your image URL */
            background-size: cover;
            background-position: center;
            color: #333;
        }

        .navbar {
            background-color: #007bff;
        }

        .navbar-brand {
            font-weight: bold;
            font-style: italic;
            color: white !important;
        }

        .review-form-section {
            background-color: #fff;
            padding: 50px 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 123, 255, 0.2);
            margin-top: 30px;
        }

        .review-form-section h2 {
            font-size: 2rem;
            margin-bottom: 20px;
        }

        .review-form-section label {
            font-size: 1.1rem;
            font-weight: bold;
        }

        .review-form-section input,
        .review-form-section textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .review-form-section textarea {
            height: 150px;
        }

        .review-form-section button {
            background-color: #007bff;
            color: white;
            font-size: 1.1rem;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .review-form-section button:hover {
            background-color: #0056b3;
        }

        .footer {
            background-color: #343a40;
            color: #fff;
            padding: 20px 0;
            text-align: center;
            margin-top: 30px;
        }

        /* Star Rating CSS */
        .stars {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        .stars input[type="radio"] {
            display: none;
        }

        .stars label {
            font-size: 30px;
            color: #ccc;
            cursor: pointer;
            transition: color 0.2s ease-in-out;
        }

        .stars label:hover,
        .stars input[type="radio"]:checked ~ label {
            color: gold;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <a class="navbar-brand" href="#">HealthHubFinder</a>
    </nav>

    <!-- Review Form Section -->
    <div class="container review-form-section">
        <h2>Add Your Review</h2>

        <!-- Display Success or Error Message -->
        <?php
        if (!empty($message)) {
            echo "<div class='alert alert-info'>$message</div>";
        }
        ?>

        <form action="" method="POST">
            <!-- Rating - Five Stars -->
            <div class="form-group">
                <label for="rating">Rating (1-5)</label>
                <div class="stars">
                    <input type="radio" id="star5" name="rating" value="5">
                    <label for="star5">★</label>
                    <input type="radio" id="star4" name="rating" value="4">
                    <label for="star4">★</label>
                    <input type="radio" id="star3" name="rating" value="3">
                    <label for="star3">★</label>
                    <input type="radio" id="star2" name="rating" value="2">
                    <label for="star2">★</label>
                    <input type="radio" id="star1" name="rating" value="1">
                    <label for="star1">★</label>
                </div>
            </div>

            <!-- Comments -->
            <div class="form-group">
                <label for="comments">Comments</label>
                <textarea class="form-control" id="comments" name="comments" required></textarea>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary">Submit Review</button>
        </form>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <p>&copy; HealthHubFinder. All Rights Reserved.</p>
    </footer>

    <!-- Bootstrap JS & Dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>

