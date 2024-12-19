<?php
include '../../includes/header.php';
include '../../includes/footer.php';



echo "<script>
$(window).on('load', function(){ 
  $('#exampleModal').modal('show');
});

</script>";
?>


<!-- Modal -->
<div class="modal fade" id="exampleModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">ADD Tables</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="goback()"></button>
            </div>
            <form id="submitAddTable">
                <div class="modal-body">


                    <div class="mb-3">
                        <label for="" class="form-label">Table Number/Name</label>
                        <input type="text" class="form-control" name='name' id="name" aria-describedby="namelable">
                        <div id="namelable" class="form-text">Enter Your Table Name.</div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Add New Table</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="goback()">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>



<div class="toast-container position-fixed top-0 end-0 p-3">
    <div id="myToast" class="toast text-bg-success" role="alert" aria-live="assertive" aria-atomic="true">

        <div class="toast-body">
            <div id="result2"></div>
        </div>
    </div>
</div>
<div class="toast-container position-fixed top-0 end-0 p-3">
    <div id="myToastError" class="toast text-bg-danger" role="alert" aria-live="assertive" aria-atomic="true">

        <div class="toast-body">
            <div id="error"></div>
        </div>
    </div>
</div>

<script>
    // //////////
    function goback() {
        window.location.href = "./tableview.php";
    }




    // /////////Add Data To DB
    let submitAddTable = document.getElementById('submitAddTable');
    let tablename = document.getElementById('name');

    submitAddTable.addEventListener('submit', function(e) {
        e.preventDefault();
        insert_table(tablename.value);
        document.getElementById('name').value = '';
    });

    function insert_table(tablename) {
        if (tablename) {
            // Make the AJAX call
            $.ajax({
                url: "tableaddsave.php",
                type: "POST",
                data: {
                    tablename: tablename
                },
                success: function(data) {
                    if (data.success) {
                        $("#result2").html(data.message);
                        // modelClose();
                        toast();
                    } else {
                        $("#error").html("Failed: " + data.message);
                        toastError();
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error:", error);
                    console.error("Response:", xhr.responseText);
                    $("#error").html("Failed to fetch data. Details: " + xhr.responseText);
                    toastError();
                }
            });
        } else {
            $("#error").html("Please provide a valid table name.");
            toastError();
        }
    }
    // //////////
</script>

<script>
    function modelClose() {
        $('#exampleModal').modal('hide');
    };
</script>

<script>
    function toast() {
        var toastElement = document.getElementById('myToast');
        var toast = new bootstrap.Toast(toastElement);
        toast.show();
    };

    function toastError() {
        var toastElement = document.getElementById('myToastError');
        var toast = new bootstrap.Toast(toastElement);
        toast.show();
    };
</script>


<!-- <script>
    // JavaScript to clear input fields after form submission
    document.getElementById('submitAddTable').addEventListener('submit', function(event) {   
        document.getElementById('name').value = '';

        // Optionally show a success message
        alert('Table added successfully!');
    });
</script> -->