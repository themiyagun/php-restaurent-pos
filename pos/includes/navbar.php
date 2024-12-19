<style>
    /* navbar styles */


    /* Login Model Styles ////////// */
    .divider:after,
    .divider:before {
        content: "";
        flex: 1;
        height: 1px;
        background: #eee;
    }

    .h-custom {
        height: calc(100% - 73px);
    }

    @media (max-width: 450px) {
        .h-custom {
            height: 100%;
        }
    }


    .loginHeader {
        font-size: 20px;
        font-weight: 700;
        letter-spacing: 1px;
    }

    .loginSec {
        height: 60vh;
    }

    .socialMdLgnSec {
        gap: 5px;
    }

    .socialMdBtn {
        display: flex;
        padding: 5px 10px;
        font-size: smaller;
        gap: 3px;
        cursor: pointer;
        border: 1px solid black;
        border-radius: 5px;

    }


    /* ///// */
</style>

<?php

if (isset($_GET['error'])) {

    include './header.php';
    include './footer.php';

    $errors = $_GET['error'];

    echo "<script>
            $(window).on('load', function(){ 
              $('#exampleModal').modal('show');
            });
  
    </script>";
}

session_start();

$login = '';
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $login = 1;
}

?>


<!-- ///////////////////////////////////////////////////////////////////////////////////// -->

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <section class="loginSec">
                <div class="container-fluid h-custom">
                    <div class="row d-flex justify-content-center align-items-center h-100">
                        <div class="col-md-9 col-lg-6 col-xl-5 d-none d-lg-block" id="loginSideImgSec">
                            <img src="../../assets/images/login-model.jpg" class="img-fluid" alt="Sample image">
                        </div>
                        <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
                            <br>
                            <div class="loginHeader">
                                Login
                            </div>
                            <br>
                            <form action="/pos/includes/auth.php" method="POST">


                                <!-- Email input -->
                                <div data-mdb-input-init class="form-outline mb-2">
                                    <input type="text" id="form3Example3" name="username" class="form-control form-control-sm" placeholder="Enter User Name" />
                                    <label class="form-label" for="form3Example3" style="font-size: 13px;">User Name</label>
                                </div>

                                <!-- Password input -->
                                <div data-mdb-input-init class="form-outline">
                                    <input type="password" id="form3Example4" name="password" class="form-control form-control-sm" placeholder="Enter password" />
                                    <label class="form-label" for="form3Example4" style="font-size: 13px;">Password</label>
                                </div>

                                <div class="d-flex justify-content-between align-items-center">
                                    <!-- Checkbox -->
                                    <div class="form-check mb-0">
                                        <input class="form-check-input me-2" type="checkbox" value="" id="form2Example3" />
                                        <label class="form-check-label" for="form2Example3" style="font-size: 13px;">
                                            Remember me
                                        </label>
                                    </div>
                                    <a href="#!" class="text-body" style="font-size: 13px;">Forgot password?</a>
                                </div>

                                <div class="text-center text-lg-start mt-4 pt-2">
                                    <button type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-sm"
                                        style="padding-left: 2.5rem; padding-right: 2.5rem;">Login</button>                                  
                                </div>

                                <?php if (isset($errors) && !empty($errors)) {
                                    echo '<p class="error text-center">Invalid Username OR Password</p>';
                                } ?>

                            </form>
                        </div>
                    </div>
                </div>

            </section>
        </div>

    </div>
</div>

<!-- model end -->


<!-- new navbar -->

<nav class="navbar navbar-expand-lg bg-dark" data-bs-theme="dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#"> ALSAKB ERP</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Link</a>
        </li>
        <!-- <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Dropdown
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#">Action</a></li>
            <li><a class="dropdown-item" href="#">Another action</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">Something else here</a></li>
          </ul>
        </li> -->
      
      </ul>
      <div class="d-flex" role="search">
      <?php
            if ($login != 1) {
            ?>
                <!-- login -->
                <div type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    <div>Login</div>
                   
                </div>

            <?php } else {
            ?>
                <!-- login -->
                <form action="../logout.php" method="POST">
                    <button class="btn btn-info" name='logout'>
                        <div>Logout</div>
                     
                    </button>
                </form>


            <?php
            }

            ?>
      
      </div>
    </div>
  </div>
</nav>