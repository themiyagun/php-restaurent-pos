<?php

include '../../includes/header.php';
include '../../includes/navbar.php';
include '../../includes/footer.php';
include '../../includes/db.php';

$table_name = $_GET['table'];
echo $table_name;

$cat1 = "bath";
$cat2 = "bima";
$cat3 = "jathi 3";

?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-9">
            <div class="row mb-4">
                <div class="col-md-3">

                    <div class="card" onclick="getCategorydata('<?php echo $cat1; ?>')">
                        <div class="card-body">
                            <?php echo $cat1 ?>
                        </div>
                    </div>

                </div>
                <div class="col-md-3">
                   
                        <div class="card" onclick="getCategorydata('<?php echo $cat2; ?>')">
                            <div class="card-body">
                                <?php echo $cat2 ?>
                            </div>
                        </div>
                  
                </div>
                <div class="col-md-3">
                    <a href="">
                        <div class="card">
                            <div class="card-body">
                                <?php echo $cat3 ?>
                            </div>
                        </div>
                    </a>
                </div>

            </div>

            <div class="row" style="height: calc(100vh - 175px);">
                <div class="col-md-12">
                    <div class="card h-100">
                        <div class="card-body bg-secondary-subtle">
                            Jati tika

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

                            <!-- //// -->
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-md-3" style="height: calc(100vh - 100px);">
            <div class="card h-100">
                <div class="card-body">
                    Ladu PAtha
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function getCategorydata(category) {

        if (category) {
            // Make the AJAX call
            $.ajax({
                url: "table_get_category_data.php",
                type: "POST",
                data: {
                    category_name: category
                },
                success: function(data) {
                    if (data) {
                        console.log(data);
                        $("#jsonData").text(JSON.stringify(data));
                        populateCards();
                        // toast();
                    } else {
                        $("#error").html("Failed: " + data.message);
                        // toastError();
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error:", error);
                    console.error("Response:", xhr.responseText);
                    $("#error").html("Failed to fetch data. Details: " + xhr.responseText);
                    // toastError();
                }
            });
        } else {
            $("#error").html("Please provide a valid Category name.");
            // toastError();
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
            card.find("[data-bind='name']").text(item.item_name);
            card.find("[data-bind='price']").text(`Price: $${item.item_selling_price}`);
            card.find("[data-bind='category']").text(`Category: ${item.item_category}`);
            container.append(card); // Add the populated card to the container
        });
    }
</script>