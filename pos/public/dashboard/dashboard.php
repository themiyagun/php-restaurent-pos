<?php
include '../../includes/header.php';
include '../../includes/navbar.php';
?>

<div class="container-fluid text-light">


    <h5 class="">dashboard</h5>
    <h5 class="">Hi <?php echo $_SESSION['username'] ?></h5>

    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-1">
                    <a href="../tableview/tableview.php">
                    <div class="card">
                        <div class="card-body">
                           Table View
                        </div>
                    </div>
                    </a>
                </div>
                <div class="col-md-2"></div>
                <div class="col-md-2"></div>
                <div class="col-md-2"></div>
            </div>

        </div>
    </div>

</div>

<?php include '../../includes/footer.php'; ?>