<?php
// Include the connection file
include "../connection.php";

session_start();

// Check if connection is successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if 'order_reference_number is set in the request
if (isset($_GET['order_reference'])) {
    // Get the order_reference and sanitize it
    $orderReference = intval($_GET['order_reference']);
    
    // Prepare the SQL statement
    $sql = "SELECT orderStatus FROM orders WHERE orderStatus = $orderReference;";
    
    // Initialize prepared statement
    $stmt = $conn->prepare($sql);
    
    // Check if statement preparation is successful
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }

    // Bind the parameter
    $stmt->bind_param("i", $cartId);
    
    // Execute the statement
    if ($stmt->execute()) {
        $message = "Record deleted successfully";
    } else {
        $message = "Error deleting record: " . $stmt->error;
    }
    
    // Close the statement
    $stmt->close();
} else {
    $message = "No cart ID provided";
}

// Close the connection
$conn->close();

// Redirect back to the cart page with a status message
header("Location: ../user/cart.php?status=" . urlencode($message));
exit();
?>
