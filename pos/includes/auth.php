<?php 

session_start(); 
require_once('./db.php');
require_once('./functions.php'); 
require_once('./login_functions.php'); 

// check for form submission
$now = time();



if(isset($_POST['username'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];
   


    $errors = array();

    // check if the username and password has been entered
    if (!isset($_POST['username']) || strlen(trim($_POST['username'])) < 1) {
        $errors[] = 'Username is Missing / Invalid';
    }

    if (!isset($_POST['password']) || strlen(trim($_POST['password'])) < 1) {
        $errors[] = 'Password is Missing / Invalid';
    }

    // check if there are any errors in the form
    if (empty($errors)) {
        // save username and password into variables
        $username     = mysqli_real_escape_string($connection, $_POST['username']);
        $password     = mysqli_real_escape_string($connection, $_POST['password']);
        // $hashed_password = sha1($password);

    
        // prepare database query
        $query = "SELECT * FROM users WHERE user_name = '$username' AND password = '$password' LIMIT 1";          
        $result_set = mysqli_query($connection, $query);
       
        verify_query($result_set);


        if (mysqli_num_rows($result_set) == 1) {
            // valid user found
            $user = mysqli_fetch_assoc($result_set);
            
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['role_id'] = $user['user_role'];
            $_SESSION['username'] = $user['user_name'];           
            $_SESSION['first_name'] = $user['f_name'];
            $_SESSION['timestamp'] = time();  
            // $_SESSION['role'] = $user['role'];
            $userid = $_SESSION['user_id'] ;
            // updating last login
            $query = "UPDATE users SET last_login = NOW() WHERE user_id = '$userid'LIMIT 1";
            echo $query ;
            // exit()
            $result_set = mysqli_query($connection, $query);

    
            // insert last logged in time
            $query1 = "INSERT INTO users_logged_in_time(emp_id, user_name, logged_time, logged_out) 
                        VALUES ('{$_SESSION['user_id']}', '$username', CURRENT_TIMESTAMP, 0)";
            $query_run = mysqli_query($connection, $query1);

            $query = "SELECT * FROM users_logged_in_time ORDER BY logged_in_id DESC LIMIT 1";
            $run = mysqli_query($connection, $query);
            foreach($run as $r){
                $logged_in_id = $r['logged_in_id'];

                $_SESSION['logged_in_id'] = $r['logged_in_id'];
            }
            

            verify_query($result_set);

            if($query_run){
                if(isset($_REQUEST["remember"]) && $_REQUEST["remember"]==1){
                    setcookie("loggin time", $username . "," . time() * 3600);//expire after 1hour 
                }
            }

            // redirect to users.php
            login($_SESSION['role_id']);
        } else {
            // user name and password invalid
            $errors = 'Invalid Username / Password';
            header("Location:./navbar.php?error='$errors'");
        }
    }

    print_r($errors);
}
?>

