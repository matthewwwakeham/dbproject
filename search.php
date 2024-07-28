<?php
// Include the config file
include('config.php');

// Connect to the database
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check the connection
if ($conn->connect_error) {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Connection failed: ' . $conn->connect_error]);
    exit;
}

// Get the search query from the URL
$query = isset($_GET['query']) ? $conn->real_escape_string($_GET['query']) : '';

// Define the SQL query
$sql = "SELECT * FROM MajorArcana 
        WHERE CardName LIKE '%$query%' 
           OR CardNumber LIKE '%$query%' 
           OR CardImage LIKE '%$query%' 
           OR Description LIKE '%$query%' 
           OR Keywords LIKE '%$query%' 
           OR ReversedMean LIKE '%$query%' 
           OR Symbolism LIKE '%$query%' 
           OR CardDescription LIKE '%$query%'";

// Execute the query
$result = $conn->query($sql);

// Check for errors
if ($conn->error) {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Query failed: ' . $conn->error]);
    exit;
}

// Prepare the results
header('Content-Type: text/html');
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Output data from each row
        echo "Card Name: " . htmlspecialchars($row["CardName"]) . "<br>";
        echo "Card Number: " . htmlspecialchars($row["CardNumber"]) . "<br>";
        echo "Card Image: <img src='" . htmlspecialchars($row["CardImage"]) . "' alt='" . htmlspecialchars($row["CardName"]) . "'><br>";
        echo "Description: " . htmlspecialchars($row["Description"]) . "<br>";
        echo "Keywords: " . htmlspecialchars($row["Keywords"]) . "<br>";
        echo "Reversed Mean: " . htmlspecialchars($row["ReversedMean"]) . "<br>";
        echo "Symbolism: " . htmlspecialchars($row["Symbolism"]) . "<br>";
        echo "Card Description: " . htmlspecialchars($row["CardDescription"]) . "<br><br>";
    }
} else {
    echo "No results found.";
}

// Close the connection
$conn->close();
?>