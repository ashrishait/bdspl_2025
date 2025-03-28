<!DOCTYPE html>
<html lang="en">
<head>
    <!-- ========== Meta Tags ========== -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Suppplier Relationship Management - Login">

    <!-- ========== Page Title ========== -->
    <title>Suppplier Relationship Management - Registration</title>

    <!-- ========== Favicon Icon ========== -->
    <link rel="shortcut icon" href="assets/img/favicon.png" type="image/x-icon">

    <!-- ========== Start Stylesheet ========== -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body{background-color: #F50057}.card{width: 100%;padding: 30px}.form{padding: 20px}.form-control{height: 50px;background-color: #eee}.form-control:focus{color: #495057;background-color: #fff;border-color: #f50057;outline: 0;box-shadow: none;background-color: #eee}.inputbox{margin-bottom: 15px}.register{width: 200px;height: 51px;background-color: #f50057;border-color: #f50057}.register:hover{width: 200px;height: 51px;background-color: #f50057;border-color: #f50057}.login{color: #f50057;text-decoration: none}.login:hover{color: #f50057;text-decoration: none}.form-check-input:checked{background-color: #f50057;border-color: #f50057}
        .image{
            margin-top: 0px;
            box-shadow: 5px 5px 5px 5px gray;
            width: 60px;;
            padding: 0px;
            font-weight: 400;
            padding-bottom: 0px;
            height: 40px;
            user-select: none;
            text-decoration:line-through;
            font-style: italic;
            font-size: x-large;
            border: red 2px solid;
            margin-left: 5px;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="bg-theme">
    <div class="container d-flex justify-content-center align-items-center">
        <div class="card">
            <div class="row">
                <div class="col-md-7">
                    <a href="https://bdslp.com/"><img src="https://bdslp.com/assets/img/logo.png" alt="Logo"></a>
                    <div class="form p-0">
                        <h2>Registration</h2>
                        <?php
                            if(session()->has("emp_ok"))
                            {   
                                if(session("emp_ok")==1)   
                                {  
                                    echo "<div class='alert alert-success' role='alert'>Successfully  Registration</div>";
                                }
                                elseif(session("emp_ok")==2)   
                                {  
                                    echo "<div class='alert alert-danger' role='alert'>Please verify your phone and email</div>";
                                }
                                
                            } 

                            if(session()->has("Captcha_Code_Check"))
                            {   
                               
                                if(session("emp_ok")==2)   
                                {  
                                    echo "<div class='alert alert-danger' role='alert'> Captcha Code Invalid </div>";
                                }
                               
                            } 
                            if(session()->has("GSTNoalreadyexist"))
                            {   
                                if(session("emp_ok")==3)   
                                {  
                                    echo "<div class='alert alert-danger' role='alert'> GST Already Registered </div>";
                                }
                            } 
                        ?>
                        <form method="post" action="<?php echo site_url('/save-vendor'); ?>">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="inputbox mt-3"> <span>GSTIN No</span> <input class="form-control" type="text" name="GST_No" placeholder=" GST No" id="GST_No" onchange = "getVendorDetails();" required value="<?= set_value('GST_No'); ?>">
                                        <span style="color:red;"><?php if(isset($error['GST_No'])){ echo $error['GST_No'];   }?></span>
                                    </div>
                                    <div class="col-sm-12" id="VendorDetails"></div>
                                    <div class="inputbox mt-3"> <span>Name</span> <input type="text" name="Name" placeholder=" Name" class="form-control" required> </div>
                                    <div class="inputbox mt-3"> <span>Phone(Whatsapp No)</span> <input type="text" name="Mobile_No" id="Mobile_No" placeholder="    WhatsApp No" class="form-control" required value="<?= set_value('Mobile_No'); ?>" pattern="[0-9]{10}" maxlength="10">

                                        <span style="color:red;"><?php if(isset($error['Mobile_No'])){ echo $error['Mobile_No'];   }?>
                                    </div>
                                    <button type="button" id="sendOTP" class="btn btn-primary mt-3">Send OTP</button>
                                    <div id="otpInput" style="display: none;">
                                        <div class="inputbox mt-3">
                                            <span>OTP</span>
                                            <input type="text" id="otp" class="form-control" placeholder="Enter OTP">
                                        </div>
                                        <button type="button" id="verifyOTP" class="btn btn-success mt-3">Verify OTP</button>
                                    </div>
                                    <div id="verificationMessage" style="display: none;color:green;font-weight: bold;" class="verification-message">
                                        Verified
                                    </div>
                                    <div class="inputbox mt-3"> <span>Email</span> 
                                        <input type="text" name="Email_Id" id="Email_Id" placeholder="Email" name="" class="form-control" required value="<?= set_value('Email_Id'); ?>"> 
                                        <span style="color:red;"><?php if(isset($error['Email_Id'])){ echo $error['Email_Id'];   }?>
                                    </div> 
                                    <button type="button" id="sendEmailOTP" class="btn btn-primary mt-3">Send OTP</button>
                                    <div id="emailOTPInput" style="display: none;">
                                        <div class="inputbox mt-3">
                                            <span>OTP</span>
                                            <input type="text" id="emailOTP" class="form-control" placeholder="Enter OTP">
                                        </div>
                                        <button type="button" id="verifyEmailOTP" class="btn btn-success mt-3">Verify OTP</button>
                                    </div>
                                    <div id="verificationMessageEmail" style="display: none;color:green;font-weight: bold;" class="verification-message">
                                        Verified
                                    </div>
                                    <div class="inputbox mt-3"> <span>Password</span> <input class="form-control" type="password" name="E_Password" required> </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="inputbox mt-3"> <span>Address</span> <input type="text" name="Address" class="form-control" id="ca" placeholder="Address" required> </div>
                                    <div class="inputbox mt-3"> <span>State</span> <select name="C_State" class="form-control" id="cs" style="padding: 0.875rem 1.375rem" required>
                                        <option value="">-Select State-</option>
                                        <?php
                                        if(isset($dax)){
                                            foreach ($dax as $row){ ?>
                                                <option value="<?php echo $row['id']; ?>"<?php if(isset($_POST['C_State']) && $_POST['C_State']==$row['id']) echo 'selected="selected"'; ?>><?php echo ucwords($row['state_name']); ?></option>
                                                <?php 
                                            }
                                        } 
                                        ?> 
                                        </select> 
                                    </div>
                                    <div class="inputbox mt-3"> <span>City</span> <select name="C_City" class="form-control" id="cc" style="padding: 0.875rem 1.375rem" required>
                                            <option value="">-Select City-</option>
                                        </select> 
                                    </div>
                                    <div class="inputbox mt-3"> <span>Pincode</span> <input type="number" name="C_Pincode" value="" id="cp" class="form-control" placeholder="Pincode" required> </div>
                                </div>   
                                <div class="col-md-12" style="display: none;" id="CaptchaDetails">
                                 <div class="row">
                                   <div class="col-md-6">
                                     <span>Enter Captcha Code</span> <input type="number" name="Enter_Captcha_Code" value="" id="Enter_Captcha_Code" class="form-control" placeholder="Enter Captcha Code" required maxlength="6"> 
                                   </div> 
                                   <div class="col-md-6">
                                    <span>Captcha Code</span>
                                    <br>
                                     <div id="randomNumber" class="form-control image" style="width:50%;float: left;"></div>
                                     <span id="generateNumber" style="cursor: pointer;padding: 5px;font-weight: bold;font-size: 18px;">Refresh</span>
                                    </div> 
                                  </div> 
                                </div> 
                                <br>  
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <div class="text-right"> 
                                        <!--*************-->
                                        <div id="VerifiedAfter" style="display: none;">
                                         <button type="submit" class="btn btn-success register btn-block">Register</button> 
                                       </div>
                                       </form> 
                                       <div id="VerifiedBefore">
                                         <span onclick="showMessage()" class="btn btn-success register btn-block">Register</span>
                                       </div>
                                       <div id="CaptchaButton" style="display: none;">
                                         <span onclick="CaptchashowMessage()" class="btn btn-success register btn-block">Register</span>
                                       </div>
                                       <!--*************-->

                                    </div>  
                                </div> 
                                
                                <div class="form-check mt-2"> 
                                    <a href="https://bdslp.com/" class="login">Go to Home</a> <a href="<?php echo site_url('/vendor_login'); ?>" >Login</a>
                                </div>
                            </div>    
                        </form>    
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="text-center mt-5"> <img src="https://i.imgur.com/98GXnDD.png" width="400"> </div>
                </div>
            </div>
        </div>
    </div>
  <!-- Start Login 
    ============================================= -->
    <!-- jQuery Frameworks
    ============================================= -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#Enter_Captcha_Code').change(function() {
                var Enter_Captcha_Code = $('#Enter_Captcha_Code').val(); // Get OTP
               
                $.ajax({
                    url: "<?php echo site_url('/verify_Captcha_Code')?>",
                    method: 'POST',
                    data: {Enter_Captcha_Code: Enter_Captcha_Code}, // Include mobile number in the data
                    dataType: 'json', // Ensure that the response is parsed as JSON
                    success: function(response) {
                        // Check the status key in the response object
                        if (response.status === 'success') {
                             $('#VerifiedAfter').show();
                              $('#CaptchaButton').hide();
                            alert('captcha code verified successfully!');
  
                        } else {
                               $('#VerifiedAfter').hide();
                              $('#CaptchaButton').show();
                            alert('Invalid captcha code!');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        alert('Error . Please try again later.');
                    }
                });
             });
        });
    </script>
   <script>
        $(document).ready(function() {
            $('#generateNumber').click(function() {
                $.ajax({
                    url: "<?php echo site_url('/number_random')?>", // PHP script to generate random number
                    type: 'GET',
                    success: function(response) {
                        $('#randomNumber').text(  response);
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            });
               $.ajax({
                    url: "<?php echo site_url('/number_random')?>", // PHP script to generate random number
                    type: 'GET',
                    success: function(response) {
                        $('#randomNumber').text(  response);
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
        });
    </script>

    <script>
    function showMessage() {
        alert("Your Mobile No Is Not Verified ! ");
        
    }
    function CaptchashowMessage() {
        alert("Captcha Code is not empty !");
        
    }
    </script>
    <script>  
        $(document).ready(function () {
            $('#cs').change(function(){ 
                var state_id = $('#cs').val();  
                var action = 'get_city';   
                if(state_id != '')
                {   
                    $.ajax({     
                        url:"<?php echo base_url('/index.php/getcityforvendorregistration')?>",
                        method:"GET",
                        data:{state_id:state_id, action:action},  
                        dataType:"JSON",
                        success:function(data)  
                        {        
                            var html = '<option value="">Select City</option>';
             
                            for(var count = 0; count < data.length; count++)
                            {
                                html += '<option value="'+data[count].id+'">'+data[count].city_name+'</option>';
                            }
             
                            $('#cc').html(html);
                        }
                    });
                }
                else   
                {
                    $('#cc').val('');
                }
            });  
        });
    </script>
    <script type="text/javascript">
         function getVendorDetails()
         {
             var depart = $('#GST_No').val(); 
             var top = depart;
             //   alert(depart);
             //   alert(top);
             ajaxRequest = new XMLHttpRequest();
             ajaxRequest.onreadystatechange = function()
             {
                 if(ajaxRequest.readyState == 4)
                 {
                     var ajaxDisplay = document.getElementById('VendorDetails');
                     ajaxDisplay.innerHTML = ajaxRequest.responseText;    
                 }
             }
             ajaxRequest.open("GET", "<?php echo base_url('/index.php/get-vendor-detail-from-ajax')?>?GST_No=" +top, true);
             ajaxRequest.send(); 
         }
    </script>
    <script type="text/javascript">
        $('#sendOTP').click(function() {
            var whatsapp = $('#Mobile_No').val(); // Get WhatsApp number
            // Validate mobile number length
            if (whatsapp.length !== 10) {
                alert('Mobile number must be 10 digits long.');
                return; // Stop further execution
            }

            // AJAX call to send OTP
            // AJAX call to send OTP
            if (whatsapp !== '') {
                $.ajax({
                    url: "<?php echo site_url('/send_otp')?>", // Use site_url helper to generate URL
                    method: 'POST',
                    data: {whatsapp: whatsapp},
                    dataType: 'json', // Ensure that the response is parsed as JSON
                    success: function(response) {
                        // Check the status key in the response object
                        if (response.status === 'success') {
                            // Show OTP input field
                            // $('#otpInput').show();
                            // Show OTP input field and Verify button
                            $('#otpInput').show();
                            $('#verifyOTP').show();
                            // Hide Send OTP button
                            $('#sendOTP').hide();
                        } 
                        else {
                            alert('This Mobile Number Exits !');
                        }
                    }
                });
            }else {
                alert('Please Enter Mobile Number');
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#verifyOTP').click(function() {
                var otp = $('#otp').val(); // Get OTP
                var whatsapp = $('input[name="Mobile_No"]').val(); // Get WhatsApp number
                
                // AJAX call to verify OTP
                $.ajax({
                    url: "<?php echo site_url('/verify_otp')?>",
                    method: 'POST',
                    data: {otp: otp, whatsapp: whatsapp}, // Include mobile number in the data
                    dataType: 'json', // Ensure that the response is parsed as JSON
                    success: function(response) {
                        // Check the status key in the response object
                        if (response.status === 'success') {
                            alert('OTP verified successfully!');
                            $('#CaptchaDetails').show();
                            $('#otpInput').hide();
                            $('#verifyOTP').hide();
                            $('#sendOTP').hide();
                           
                              $('#CaptchaButton').show();
                             $('#VerifiedBefore').hide();  

                            // Show success message
                            $('#verificationMessage').text('Verified').addClass('verification-message').show();
                        } else {
                            alert('Invalid OTP!');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        alert('Error verifying OTP. Please try again later.');
                    }
                });
            });
        });
    </script>
    <script type="text/javascript">
         $('#sendEmailOTP').click(function() {
            var email = $('#Email_Id').val(); // Get Email
            var mobileNo = $('#Mobile_No').val(); // Get Mobile Number
            
            // AJAX call to send Email OTP
            $.ajax({
                url: "<?php echo site_url('/send_email_otp')?>",
                method: 'POST',
                data: {email: email, whatsapp: mobileNo}, // Include mobile number in data
                dataType: 'json', // Ensure that the response is parsed as JSON
                success: function(response) {
                    // Handle success response as needed
                    if (response.success) {
                        alert('Email OTP sent successfully!');
                        $('#emailOTPInput').show(); // Show the Email OTP input and Verify Email OTP button
                    } else {
                        alert('Error sending Email OTP.');
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    alert('Error sending Email OTP. Please try again later.');
                }
            });
         });
         $('#verifyEmailOTP').click(function() {
            var emailOTP = $('#emailOTP').val(); // Get Email OTP
            var email = $('#Email_Id').val(); // Get Email
            var mobileNo = $('#Mobile_No').val(); // Get Mobile Number
            // AJAX call to verify OTP
            $.ajax({
                url: "<?php echo site_url('/verify_email_otp')?>", // Use the correct URL for the verifyEmailOTP controller function
                method: 'POST',
                data: {email_otp: emailOTP, whatsapp: mobileNo},
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        alert('Email OTP verified successfully!');
                        $('#emailOTPInput').hide(); // Hide Email OTP input and Verify Email OTP button
                        $('#verificationMessageEmail').text('Verified').addClass('verification-message').show();
                        $('#sendEmailOTP').hide(); // Show the Send Email OTP button
                    } else {
                        alert('Invalid Email OTP!');
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    alert('Error verifying Email OTP. Please try again later.');
                }
            });
        });
    </script>
</body>
</html>
