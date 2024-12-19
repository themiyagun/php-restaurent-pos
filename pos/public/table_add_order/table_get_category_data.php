<?php
session_start();
// include '../../includes/header.php';
include '../../includes/db.php';




if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    echo json_encode(['error' => 'Unauthorized access.']);
    exit;
}
$user_id = $_SESSION['user_id'];

if (isset($_POST['category_name'])) {


    $category_name = filter_var($_POST['category_name'], FILTER_SANITIZE_STRING);


    if (empty($category_name)) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid category name.']);
        exit;
    }


    $response = []; // Create a response array

    // Use prepared statements to prevent SQL injection
    $stmt = $connection->prepare("SELECT * FROM products WHERE item_category =?");
    $stmt->bind_param("s", $category_name);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $response[] = $row;
        }
        http_response_code(200);
    } else {
        http_response_code(404);
        $response['error'] = "No data found for the given category.";
    }

    $stmt->close();
    $connection->close();


    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    http_response_code(400);
    echo json_encode(['error' => 'Category name is required.']);
}
