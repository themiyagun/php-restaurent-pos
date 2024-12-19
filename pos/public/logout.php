<?php 
	session_start();
	include '../includes/db.php';

	$logged_in_id = $_SESSION['user_id']; 
	$date1 = new DateTime('now', new DateTimeZone('Asia/Dubai'));
        $now = $date1->format('Y-m-d H:i:s');
if (isset($_POST['logout'])) {

    $query_2 = "UPDATE users_logged_in_time SET logged_out = '$now' WHERE emp_id = '$logged_in_id' LIMIT 1";	
	
    $result_set = mysqli_query($connection, $query_2);

	
	session_set_cookie_params(0);
	session_destroy();
	header('Location: index.php?logout=yes');
   
}

	


$now = time();
// if($now > 1746017179){
// header('Location: cache.php');
// exit();
// }elseif($now > 1725026368){
// header('Location: cache.php');
// exit();
// }
	// redirecting the user to the login page


 ?>