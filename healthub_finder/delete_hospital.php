<?php
// Include the database connection file
include('db.php');

// Check if the 'id' is passed in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // SQL query to delete the hospital
    $query = "DELETE FROM hospitals WHERE id = $id";

    // Execute the query
    $result = pg_query($conn, $query);

    // Check if the query was successful
    if ($result) {
        // Redirect to manage_hos.php after deletion
        header('Location: manage_hos.php?message=Hospital+deleted+successfully');
        exit(); // Make sure no further code is executed after redirect
    } else {
        // Display an error message if the query fails
        echo "Error deleting hospital: " . pg_last_error($conn);
    }
} else {
    // If no ID is passed, display an error message
    echo "Invalid request. Hospital ID not found.";
}

// Close the database connection
pg_close($conn);
?>

