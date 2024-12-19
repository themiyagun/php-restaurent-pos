<?php

include '../../includes/header.php';
include '../../includes/navbar.php';
include '../../includes/db.php';


?>


<h5>table</h5>
<div class="row flex-row-reverse mb-4">
    <div class=" col-md-2">
    <a class="btn btn-success" href="./tableadd.php">
        ADD New Table
    </a>
    </div>

  
</div>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">

                    <?php 
                    $sql = "SELECT * FROM tables WHERE status = '1' ";
                    $query_run = mysqli_query($connection,$sql);
                    foreach($query_run as $data){
                        $name = $data['table_no'];
                        $last_order_amount = $data['last_order_amount'];
                        $encoded_name = urlencode($name); 
                        
                    ?>
                        <div class="col-md-3 mt-3">
                            <a href="../table_add_order/table_add_order_save.php?table=<?php echo $encoded_name; ?>">
                            <div class="card justify-content-center align-items-center" style="height: 18rem;">
                                <h2>Table <?php echo $name ?></h2>
                                <h5>Rs <?php echo $last_order_amount ?></h5>
                            </div>
                            </a>
                        </div>

                        <?php 
                        }

                        ?>
                        
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>



<?php include '../../includes/footer.php'; ?>