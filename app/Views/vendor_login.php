<!DOCTYPE html>
<html lang="en">
<head>
    <!-- ========== Meta Tags ========== -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Bill Management - Login">

    <!-- ========== Page Title ========== -->
    <title>Supplier Relationship Management - Login</title>

    <!-- ========== Favicon Icon ========== -->
    <link rel="shortcut icon" href="assets/img/favicon.png" type="image/x-icon">

    <!-- ========== Start Stylesheet ========== -->
    <link href="https://bdslp.com/assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://bdslp.com/assets/css/font-awesome.min.css" rel="stylesheet" />
    <link href="https://bdslp.com/assets/css/flaticon-set.css" rel="stylesheet" />
    <link href="https://bdslp.com/assets/css/magnific-popup.css" rel="stylesheet" />
    <link href="https://bdslp.com/assets/css/owl.carousel.min.css" rel="stylesheet" />
    <link href="https://bdslp.com/assets/css/owl.theme.default.min.css" rel="stylesheet" />
    <link href="https://bdslp.com/assets/css/animate.css" rel="stylesheet" />
    <link href="https://bdslp.com/assets/css/bootsnav.css" rel="stylesheet" />
    <link href="https://bdslp.com/style.css" rel="stylesheet">
    <link href="https://bdslp.com/assets/css/responsive.css" rel="stylesheet" />
    <!-- ========== End Stylesheet ========== -->

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="assets/js/html5/html5shiv.min.js"></script>
      <script src="assets/js/html5/respond.min.js"></script>
    <![endif]-->

    <!-- ========== Google Fonts ========== -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,500,600,700,800" rel="stylesheet">
</head>
<body class="bg-theme">
    <!-- Start Login 
    ============================================= -->
    <div class="login-area">
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <div class="login-box">
                        <div class="login">
                            <div class="content">
                                <a href="https://bdslp.com/"><img src="https://bdslp.com/assets/img/logo.png" alt="Logo"></a>
            			        <h4 class="welcome text-primary">Welcome</h4>
                				<?php
                                if(session()->has("auth_ok")) 
                                {   
                                    if(session("auth_ok")==1)   
                                    {  
                                        echo "<div class='alert alert-success' role='alert'> Login Authentication Successful. </div>";
                                    }
                                    else{
                                        echo "<div class='alert alert-danger' role='alert'> Invalid GST No or Password! </div>";
                                    }
                                } 
                                ?>
                                <form method="post" action="<?php echo site_url('/vendor_authenticate'); ?>">
                    				<div class="col-lg-12 col-md-12">
                                        <div class="row">
                                            <div class="form-group">
                					            <input type="text" name="GST_No" placeholder="GSTIN No" class="form-control">
                					        </div>
                                        </div>
                                    </div>   
                                    <div class="col-lg-12 col-md-12">
                                        <div class="row">
                                            <div class="form-group">
                					            <input type="password" placeholder="**********" name="password" class="form-control">
                					        </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12">
                                        <div class="row">         
                				            <button type="submit" class="btn btn-primary btn1 mb-5">Login</button>
                				        </div>
                				    </div> 
                			    </form>	
                			    <div class="sign-up">
                                    <p>
                                        Don't have an account? <a href="<?php echo site_url('/vendor-registration'); ?>">Sign up now</a>
                                    </p>
                                    <p>Go to <a href="https://bdslp.com/" class="login">Home</a> </label> </p>
                                </div>
            			    </div>
                		</div>
                	</div>
                </div>
    		</div>
        </div>
    </div>    
    
    <!-- jQuery Frameworks
    ============================================= -->
    <script src="https://bdslp.com/assets/js/jquery-1.12.4.min.js"></script>
    <script src="https://bdslp.com/assets/js/bootstrap.min.js"></script>
    <script src="https://bdslp.com/assets/js/equal-height.min.js"></script>
    <script src="https://bdslp.com/assets/js/jquery.appear.js"></script>
    <script src="https://bdslp.com/assets/js/jquery.easing.min.js"></script>
    <script src="https://bdslp.com/assets/js/jquery.magnific-popup.min.js"></script>
    <script src="https://bdslp.com/assets/js/modernizr.custom.13711.js"></script>
    <script src="https://bdslp.com/assets/js/owl.carousel.min.js"></script>
    <script src="https://bdslp.com/assets/js/wow.min.js"></script>
    <script src="https://bdslp.com/assets/js/count-to.js"></script>
    <script src="https://bdslp.com/assets/js/bootsnav.js"></script>
    <script src="https://bdslp.com/assets/js/main.js"></script>
</body>
</html>
