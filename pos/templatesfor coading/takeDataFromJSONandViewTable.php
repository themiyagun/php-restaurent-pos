<!-- ================METHOD 1 ==========-->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category Table</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>
<body>
<div class="container mt-4">
    <div class="row">
        <div class="col-md-4">
            <div class="card" onclick="getCategorydata('bath')">
                <div class="card-body">Bath</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card" onclick="getCategorydata('jathi 2')">
                <div class="card-body">Jathi 2</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card" onclick="getCategorydata('jathi 3')">
                <div class="card-body">Jathi 3</div>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <table id="productTable" class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Category</th>
                </tr>
            </thead>
            <tbody>
                <!-- Data will be populated here -->
            </tbody>
        </table>
    </div>
</div>

<script>
    function getCategorydata(category) {
        if (category) {
            $.ajax({
                url: "path_to_your_php_script.php",
                type: "POST",
                data: { category_name: category },
                success: function(data) {
                    if (data && Array.isArray(data)) {
                        populateTable(data);
                    } else if (data.error) {
                        alert(data.error); // Display the error message
                    } else {
                        alert("No data available.");
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error:", error);
                    alert("Failed to fetch data. Please try again.");
                }
            });
        } else {
            alert("Category is required.");
        }
    }

    function populateTable(data) {
        const tableBody = $("#productTable tbody");
        tableBody.empty(); // Clear existing rows

        data.forEach(item => {
            const row = `
                <tr>
                    <td>${item.id}</td>
                    <td>${item.name}</td>
                    <td>${item.price}</td>
                    <td>${item.category}</td>
                </tr>
            `;
            tableBody.append(row);
        });
    }
</script>
</body>
</html>


<!-- /////////////////////////////// -->

<!-- method 2 -->

2. Use a Frontend Library (DataTables)

Instead of building the table manually, you can use a JavaScript library like DataTables to handle the rendering.

Steps:
1.Include DataTables in Your Project: Add the required CSS and JS files:

html
Copy code

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>


2.Modify the AJAX Response: Return JSON data from the server (no HTML table).

<?php
session_start();
require_once '../../includes/db.php';

if (isset($_POST['category_name'])) {
    $category_name = filter_var($_POST['category_name'], FILTER_SANITIZE_STRING);

    $stmt = $connection->prepare("SELECT * FROM products WHERE item_category = ?");
    $stmt->bind_param("s", $category_name);
    $stmt->execute();
    $result = $stmt->get_result();

    $response = [];
    while ($row = $result->fetch_assoc()) {
        $response[] = $row;
    }
    echo json_encode($response);
    $stmt->close();
}
?>


3.Initialize DataTables: Use DataTables to fetch and display the data.

function getCategorydata(category) {
    if (category) {
        $.ajax({
            url: "path_to_your_php_script.php",
            type: "POST",
            data: { category_name: category },
            success: function(data) {
                if (data) {
                    // Initialize DataTables
                    const jsonData = JSON.parse(data);
                    $("#productTable").DataTable({
                        destroy: true, // Clear previous instance
                        data: jsonData,
                        columns: [
                            { data: 'id', title: 'ID' },
                            { data: 'name', title: 'Name' },
                            { data: 'price', title: 'Price' },
                            { data: 'item_category', title: 'Category' }
                        ]
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error("Error:", error);
                alert("Failed to fetch data. Please try again.");
            }
        });
    } else {
        alert("Category is required.");
    }
}


4.HTML Structure: Add an empty table for DataTables to populate:

html

<table id="productTable" class="display" style="width:100%">
    <!-- DataTables will populate this -->
</table>


<!-- ///////////////////////end -->