<?php
// Include the database connection file
include('db.php');

// SQL query to get all hospital information
$query = "SELECT * FROM hospitals"; // Query to fetch all rows from the 'hospitals' table
$result = pg_query($conn, $query); // Execute the query

// Check if query execution was successful
if (!$result) {
    die("Query failed: " . pg_last_error());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospitals List</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .update-btn, .delete-btn {
            background-color: #4CAF50;
            color: white;
            padding: 5px 10px;
            border: none;
            cursor: pointer;
            text-decoration: none;
            margin: 5px;
        }
        .update-btn:hover, .delete-btn:hover {
            background-color: #45a049;
        }
        .delete-btn {
            background-color: #f44336;
        }
    </style>
</head>
<body>

<h1>Hospitals Information</h1>

<table>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Address</th>
        <th>City</th>
        <th>State</th>
        <th>Phone Number</th>
        <th>Email</th>
        <th>Specialties</th>
        <th>Rating</th>
        <th>Website Link</th>
        <th>Action</th>
    </tr>
    
    <?php
    // Fetch each row from the database and display it in the table
    while ($row = pg_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['id']) . "</td>";
        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['address']) . "</td>";
        echo "<td>" . htmlspecialchars($row['city']) . "</td>";
        echo "<td>" . htmlspecialchars($row['state']) . "</td>";
        echo "<td>" . htmlspecialchars($row['phone_number']) . "</td>";
        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
        echo "<td>" . htmlspecialchars($row['specialties']) . "</td>";
        echo "<td>" . htmlspecialchars($row['rating']) . "</td>";
        echo "<td>" . htmlspecialchars($row['website_link']) . "</td>";
        // Update button
        echo "<td><a href='update_hospital.php?id=" . $row['id'] . "' class='update-btn'>Update</a>";
        // Delete button
        echo "<a href='delete_hospital.php?id=" . $row['id'] . "' class='delete-btn' onclick='return confirm(\"Are you sure you want to delete this hospital?\");'>Delete</a></td>";
        echo "</tr>";
    }
    ?>
</table>

</body>
</html>

<?php
// Close the database connection after use
pg_close($conn);
?>

