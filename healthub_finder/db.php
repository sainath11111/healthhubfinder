<?php
// db.php
$conn = pg_connect("host=localhost dbname=HealthHubFinder user=postgres port=5432");
if (!$conn) {
    die("Connection failed: " . pg_last_error());
}
?>

