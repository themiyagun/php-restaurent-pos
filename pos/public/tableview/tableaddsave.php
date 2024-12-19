<?php
session_start();
// include '../../includes/header.php';
include '../../includes/db.php';


$user_id = $_SESSION['user_id'];



if (isset($_POST['tablename'])) {
    // require 'db_connection.php'; // Ensure the DB connection is included
    
    $tablename = filter_var($_POST['tablename'], FILTER_SANITIZE_STRING);
    $user_id = $_SESSION['user_id']; // Example: Retrieve user ID from session

    $response = []; // Create a response array

    // Use prepared statements to prevent SQL injection
    $stmt = $connection->prepare("INSERT INTO `tables`(`table_no`, `status`, `last_order_amount`, `added_by`) VALUES (?, '1', '0', ?)");
    $stmt->bind_param("si", $tablename, $user_id);

    if ($stmt->execute()) {
        $response['success'] = true;
        $response['message'] = "Table Added successfully!";
    } else {
        error_log("Database Error: " . $stmt->error); // Log error for debugging
        $response['success'] = false;
        $response['message'] = "There was an error processing your request.";
    }


    $stmt->close();


    header('Content-Type: application/json');
    echo json_encode($response);
   
}

?>
