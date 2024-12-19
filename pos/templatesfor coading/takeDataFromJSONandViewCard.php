<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dynamic Cards with JSON</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>
<body>
<div class="container mt-4">
    <div class="row">
        <!-- Category Buttons -->
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

    <!-- Hidden JSON Storage -->
    <div id="jsonData" style="display: none;"></div>

    <!-- Card Template -->
    <div id="cardTemplate" class="col-md-4 mb-4" style="display: none;">
        <div class="card h-100">
            <div class="card-body">
                <h5 class="card-title" data-bind="name">Product Name</h5>
                <p class="card-text" data-bind="price">Price: $0.00</p>
                <p class="card-text" data-bind="category">Category: None</p>
            </div>
        </div>
    </div>

    <!-- Dynamic Cards Container -->
    <div id="cardsContainer" class="row mt-4">
        <!-- Dynamic cards will be displayed here -->
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
                    if (data) {
                        $("#jsonData").text(JSON.stringify(data));
                        populateCards();
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

    function populateCards() {
        const jsonData = JSON.parse($("#jsonData").text());
        const container = $("#cardsContainer");
        const template = $("#cardTemplate");

        container.empty(); // Clear any existing cards

        jsonData.forEach(item => {
            const card = template.clone(); // Clone the hidden template
            card.removeAttr("id").css("display", "block"); // Remove ID and make visible
            card.find("[data-bind='name']").text(item.name);
            card.find("[data-bind='price']").text(`Price: $${item.price}`);
            card.find("[data-bind='category']").text(`Category: ${item.item_category}`);
            container.append(card); // Add the populated card to the container
        });
    }
</script>
</body>
</html>


<!-- backend eka SERER SIDE -->


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

<!-- ///////////////////////// -->


<!-- //////////////////////////////View Card eka click karama wena page ekakta id eka yawana wididha//////////////////////////////////////////// -->


To send the item ID to another page after clicking a card, you can make use of JavaScript to handle the click event,
 retrieve the item ID, and then redirect the user to the other page, passing the item ID as a URL parameter. Here's how you can achieve this:


Steps to Achieve This:
Modify the card structure to include the item ID: You'll need to pass the item ID into the card dynamically so that it's available when the card is clicked.

Add a click event handler to redirect to another page: You can then capture the click event and redirect the user, appending the item ID to the URL.

<!-- /////// -->
Updated Code
<!-- /////////// -->
1. Modify the Card Template to Include the Item ID
Add a data-id attribute to each card to store the item_id that you'll send to the next page when the card is clicked.

html
Copy code
<!-- Card Template -->
<div id="cardTemplate" class="col-md-4 mb-4" style="display: none;">
    <div class="card h-100" data-id="">
        <div class="card-body">
            <h5 class="card-title" data-bind="name">Product Name</h5>
            <p class="card-text" data-bind="price">Price: $0.00</p>
            <p class="card-text" data-bind="category">Category: None</p>
        </div>
    </div>
</div>

Here, the data-id attribute is where you'll store the item_id.  


2. Update the JavaScript to Capture Click Events and Redirect
When the card is clicked, the item ID is captured, and the user is redirected to another page (e.g., item-details.php), passing the item_id as a URL parameter.

javascript
Copy code


// Function to handle the card click event
function handleCardClick(event) {
    const itemId = $(event.currentTarget).data('id'); // Get the item ID from the data-id attribute
    if (itemId) {
        window.location.href = `item-details.php?id=${itemId}`; // Redirect to another page with the item_id as a URL parameter
    } else {
        alert("Item ID not found.");
    }
}

// Function to populate the cards with the data
function populateCards() {
    const jsonData = JSON.parse($("#jsonData").text());
    const container = $("#cardsContainer");
    const template = $("#cardTemplate");

    container.empty(); // Clear any existing cards

    jsonData.forEach(item => {
        const card = template.clone(); // Clone the hidden template
        card.removeAttr("id").css("display", "block"); // Remove ID and make visible

        // Populate the card content
        card.find("[data-bind='name']").text(item.name);
        card.find("[data-bind='price']").text(`Price: $${item.price}`);
        card.find("[data-bind='category']").text(`Category: ${item.item_category}`);

        // Set the item ID in the data-id attribute of the card
        card.data('id', item.id); 

        // Attach the click event handler to the card
        card.on('click', handleCardClick);

        container.append(card); // Add the populated card to the container
    });
}


3. Modify the HTML Template and Cards for the Click Event
The cards will now dynamically receive a data-id attribute based on the item ID. When the card is clicked, 
the handleCardClick function will be triggered, and the user will be redirected to another page (e.g., item-details.php) with the item_id in the URL.

<!-- Dynamic Cards Container -->
<div id="cardsContainer" class="row mt-4">
    <!-- Dynamic cards will be displayed here -->
</div>

<script>
    function getCategorydata(category) {
        if (category) {
            $.ajax({
                url: "path_to_your_php_script.php",
                type: "POST",
                data: { category_name: category },
                success: function(data) {
                    if (data) {
                        $("#jsonData").text(JSON.stringify(data)); // Store JSON data
                        populateCards(); // Populate the cards
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

    function populateCards() {
        const jsonData = JSON.parse($("#jsonData").text());
        const container = $("#cardsContainer");
        const template = $("#cardTemplate");

        container.empty(); // Clear any existing cards

        jsonData.forEach(item => {
            const card = template.clone(); // Clone the hidden template
            card.removeAttr("id").css("display", "block"); // Remove ID and make visible

            // Populate the card content
            card.find("[data-bind='name']").text(item.name);
            card.find("[data-bind='price']").text(`Price: $${item.price}`);
            card.find("[data-bind='category']").text(`Category: ${item.item_category}`);

            // Set the item ID in the data-id attribute of the card
            card.data('id', item.id); 

            // Attach the click event handler to the card
            card.on('click', handleCardClick);

            container.append(card); // Add the populated card to the container
        });
    }

    // Handle card click and redirect to the item details page
    function handleCardClick(event) {
        const itemId = $(event.currentTarget).data('id'); // Get the item ID from the data-id attribute
        if (itemId) {
            window.location.href = `item-details.php?id=${itemId}`; // Redirect to another page with the item_id as a URL parameter
        } else {
            alert("Item ID not found.");
        }
    }
</script>


4. On the Item Details Page (item-details.php)
On the item-details.php page, you can capture the item ID from the URL and retrieve the corresponding details from the database or display it.

<?php
// item-details.php
if (isset($_GET['id'])) {
    $itemId = $_GET['id'];
    // Now you can query your database for the item using the $itemId
    echo "Item ID: " . htmlspecialchars($itemId); // Example display
} else {
    echo "Item ID not provided.";
}
?>


Key Points:

Storing Item ID: The data-id attribute is used to store the item_id for each card.

Redirect on Click: When a card is clicked, the handleCardClick function captures the item ID and redirects the user to item-details.php,
 appending the item_id as a URL parameter.
Retrieving Item ID: On the item-details.php page, the item_id is accessed from the URL using $_GET['id'].
This approach allows you to dynamically handle item clicks and navigate to a detailed page with the item's ID.

<!-- ///////////////////////////////// -->