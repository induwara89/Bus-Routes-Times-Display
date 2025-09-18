<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bus";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$start = $_GET['start'];
$destination = $_GET['destination'];

$sql = "SELECT bus_number, bus_time 
        FROM routes0 
        WHERE start_location = ? AND destination = ?";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("SQL error: " . $conn->error);
}

$stmt->bind_param("ss", $start, $destination);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "<h2>Details:</h2>";
    echo "<ul class='bus-list'>";
    while ($row = $result->fetch_assoc()) {
        echo "<li>Bus Number: <strong>" . htmlspecialchars($row['bus_number']) . "</strong> | Time: <strong>" . htmlspecialchars($row['bus_time']) . "</strong></li>";
    }
    echo "</ul>";
} else {
    echo "No buses found for this route.";
}

$stmt->close();
$conn->close();
?>