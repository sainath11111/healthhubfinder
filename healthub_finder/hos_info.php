<?php
// Include the database connection
include 'db.php';

$hospital = [];
$message = '';

// Check if 'id' is provided in the URL and is valid
if (isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['id'] > 0) {
    // Get the hospital ID from the URL
    $hospital_id = $_GET['id'];

    // SQL query to fetch the full details of the hospital by ID
    $query_hospital = "SELECT name, specialties, rating, phone_number, address, website_link FROM hospitals WHERE id = $1";
    $result_hospital = pg_query_params($conn, $query_hospital, array($hospital_id));

    // Check if the query was successful and we got a result
    if ($result_hospital) {
        $hospital = pg_fetch_assoc($result_hospital);

        // If no hospital was found for this ID, set the message
        if (!$hospital) {
            $message = "Hospital not found with ID: " . htmlspecialchars($hospital_id);
        }
    } else {
        // If the query failed, show the error message
        $message = "Query failed. Error: " . pg_last_error($conn);
    }
} else {
    // If 'id' is not provided or is invalid, show the message
    $message = 'Invalid or missing hospital ID.';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital Information</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
           background-image: url('image/bg2.webp'); /* Replace with your image URL */
            background-size: cover;
            background-position: center;
            color: #333;
            font-family: 'Roboto', sans-serif;
        }

       .hospital-info-container {
    background-color: rgba(255, 255, 255, 0.8); /* Semi-transparent white background */
    padding: 40px;
    border-radius: 15px;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    margin: 0; /* Remove any margin for full screen */
    width: 80vw; /* Full width of the viewport */
    height: 80vh; /* Full height of the viewport */
    display: flex;
    flex-direction: column;
    justify-content: center; /* Center content vertically */
    align-items: center; /* Center content horizontally */
}


        h1 {
            color: #3498db;
            font-size: 36px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .hospital-info-container p {
            font-size: 18px;
            color: #333;
            margin-bottom: 10px;
        }

        .hospital-info-container .btn {
            border-radius: 10px;
            padding: 12px 20px;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .hospital-info-container .btn-primary {
            background-color: #3498db;
            color: white;
            border: none;
        }

        .hospital-info-container .btn-primary:hover {
            background-color: #2980b9;
            transform: translateY(-3px);
        }

        .hospital-info-container .btn-secondary {
            background-color: #f39c12;
            color: white;
            border: none;
        }

        .hospital-info-container .btn-secondary:hover {
            background-color: #e67e22;
            transform: translateY(-3px);
        }

        .hospital-info-container a {
            text-decoration: none;
            color: inherit;
        }

        .hospital-info-container .phone-icon,
        .hospital-info-container .website-icon {
            font-size: 20px;
            margin-right: 10px;
        }

        .hospital-info-container .phone-icon:hover,
        .hospital-info-container .website-icon:hover {
            color: #3498db;
            cursor: pointer;
        }

        .emoji {
            font-size: 30px;
            margin-right: 10px;
        }

        .alert-warning {
            background-color: #fff3cd;
            border-color: #ffeeba;
            color: #856404;
        }
    </style>
</head>
<body>

    <div class="container mt-5">
        <div class="hospital-info-container">
            <?php if (!empty($hospital)): ?>
                <div class="d-flex align-items-center mb-3">
                    <span class="emoji">🏥</span>
                    <h1><?php echo htmlspecialchars($hospital['name']); ?></h1>
                </div>
                <p><strong>Specialties:</strong> <?php echo htmlspecialchars($hospital['specialties']); ?></p>
                <p><strong>Rating:</strong> <?php echo htmlspecialchars($hospital['rating']); ?> / 5 <span class="emoji">⭐</span></p>
                <p><strong>Phone Number:</strong> 
                    <span class="phone-icon">📞</span><?php echo htmlspecialchars($hospital['phone_number']); ?>
                </p>
                <p><strong>Address:</strong> <?php echo htmlspecialchars($hospital['address']); ?></p>
                
                <?php if (!empty($hospital['website_link'])): ?>
                    <p><strong>Website:</strong> <a href="<?php echo htmlspecialchars($hospital['website_link']); ?>" target="_blank" class="website-icon">🌐 <?php echo htmlspecialchars($hospital['website_link']); ?></a></p>
                <?php endif; ?>

                <div class="d-flex justify-content-between mt-4">
                    <a href="find_hos.php" class="btn btn-primary">Back to Search</a>
                    <a href="review.php?id=<?php echo htmlspecialchars($hospital_id); ?>" class="btn btn-secondary">Write Your Review</a>
                </div>
            <?php else: ?>
                <div class="alert alert-warning">
                    <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

</body>
</html>

