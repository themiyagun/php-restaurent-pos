<?php 

function Login($role_id){
    

    if ($role_id == 1) {
        
        header('Location:../public/dashboard/dashboard.php');
    }

  
}

?>