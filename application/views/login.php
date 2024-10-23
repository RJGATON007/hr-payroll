<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon.ico">
    <title>Login</title>
    <!-- Bootstrap Core CSS -->
    <link href="<?php echo base_url(); ?>assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet">
    <!-- You can change the theme colors from here -->
    <link href="<?php echo base_url(); ?>assets/css/colors/blue.css" id="theme" rel="stylesheet">
</head>

<body>
    <style>
        #wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-image: url(<?php echo base_url(); ?>assets/images/background/bg.jpg);
            background-size: cover;
        }

        .login-box {
            width: 100%;
            max-width: 400px; /* Keep this for responsiveness */
            max-height: 500px; /* Adjust the height as needed */
            height: auto; /* Allow auto height */
            padding: 30px; /* Increased padding for better spacing */
            background-color: #fff;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            display: flex;
            flex-direction: column; /* Stack children vertically */
            justify-content: center; /* Center the content */
        }

        .form-check {
            margin-top: 10px;
        }
    </style>

    <section id="wrapper" class="login-register">
        <div class="login-box card">
            <div class="card-body loginpage">
                <?php if (!empty($this->session->flashdata('feedback'))) { ?>
                <div class="message">
                    <strong>Danger! </strong><?php echo $this->session->flashdata('feedback') ?>
                </div>
                <?php } ?>

                <form class="form-horizontal form-material" method="post" id="loginform" action="login/Login_Auth">
                    <h2 class="box-title m-b-20">Welcome!</h2>
                    <h6 class="box-title m-b-20">Enter Username and Password</h6>
                    <div class="form-group m-t-40">
                        <div class="col-xs-12">
                            <input class="form-control" name="email" value="<?php if (isset($_COOKIE['email'])) { echo $_COOKIE['email']; } ?>" type="text" required placeholder="Username">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <input class="form-control" name="password" value="<?php if (isset($_COOKIE['password'])) { echo $_COOKIE['password']; } ?>" type="password" required placeholder="Password">
                        </div>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" name="remember" class="form-check-input" id="remember-me">
                        <label class="form-check-label" for="remember-me">Remember me?</label>
                    </div>
                    <div class="form-group text-center m-t-20">
                        <div class="col-xs-12">
                            <button class="btn btn-info btn-lg btn-login btn-block text-uppercase waves-effect waves-light" type="submit">Log In</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="<?php echo base_url(); ?>assets/plugins/jquery/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/bootstrap/js/popper.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/jquery.slimscroll.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/waves.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/sidebarmenu.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/custom.min.js"></script>
</body>

</html>
