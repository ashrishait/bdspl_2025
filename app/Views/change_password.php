<?php
   use App\Models\StateModel; 
   use App\Models\CityModel;
   
   use App\Models\UserModel;  
   use App\Models\EmployeeModel;
   use App\Models\CreateStylemodel;
   use App\Models\PartyUserModel;
   use App\Models\RollModel;
   $state = new StateModel();
   $city = new CityModel();
   $modelUser = new UserModel();
   $modelEmployee = new EmployeeModel();
   $PartyUserModelObj = new PartyUserModel();
   $RollModelObj = new RollModel();
    ?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <?php include('include/head.php'); ?>
      <style>
         .bootstrap-select .btn{
         padding-top:12px;
         padding-bottom:12px;
         border:1px solid #00000045 !important;
         }
      </style>
   </head>
   <body>
      <div class="container-scroller">
         <?php include('include/header.php'); ?>
         <!-- partial -->
         <div class="container-fluid">
            <div>
               <div class="content-wrapper">
                  <div class="row">
                     <div class="col-lg-12 mb-lg-0">
                        <div class="card congratulation-bg py-0" style="background:none;">
                           <div class="card-body py-0">
                              <div>
                                 <div class="row">
                                    <div class="col-6">
                                       <h2 class="mb-3 font-weight-bold"></h2>
                                    </div>
                                    <div class="col-6">
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div>
                     <div class="row">
                        <div class="col-md-12 col-sm-12">
                           <?php
                              if(session()->has("pass_up"))
                                  {   
                                   if(session("pass_up")==1)      
                                      {  
                              echo "<div class='alert alert-success' role='alert'> Password Updation Successful. </div>";
                                        }else{
                              echo "<div class='alert alert-danger' role='alert'> Problem in Updation! </div>";
                                          }
                              } 
                              ?>
                        </div>
                        <div class="col-6 mx-auto">
                            <div class="col-md-12 col-sm-12 List p-3">
                                <div class="row">
                                    <div class="col-6">
                                       <h2>Change Password</h2>
                                    </div>
                                </div>
                           </div>
                           <div class="card">
                              <div class="card-body">
                                  <div>
                                     <form method="post" action="<?php echo site_url('/change_pass'); ?>" enctype="multipart/form-data">
                                        <input type="hidden" name="id" id="emp_id" value="<?php echo $emp_id; ?>">
                                        <div class="container">
                                           <!-- ================================== -->
                                           <div class="row" style="margin-bottom:20px;">
                                              <div class="col-sm-12 col-md-12">
                                                 <div class="row">
                                                    <div class="col-sm-12 col-md-12">
                                                       <div class="form-group">
                                                          <label>Old Password <span style="color:red;">*</span></label><span id="hint"></span>
                                                          <input  class="form-control" type="password" id="oldpassword" name="old_pass" required onkeyup="checkold(this.value);" >
                                                       </div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-12">
                                                       <div class="form-group">
                                                          <label>New Password <span style="color:red;">*</span></label>
                                                          <input class="form-control" id="NewPassword" type="password" name="new_pass" required onkeyup="checknew(this.value);" disabled>
                                                       </div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-12">
                                                       <div class="form-group">
                                                          <label>Confirm Password <span style="color:red;">*</span></label><span id="msg"></span>
                                                          <input class="form-control" type="password" name="c_pass" id="ConfirmPassword" required onkeyup="checkcpass(this.value);" disabled>
                                                       </div>
                                                    </div>
                                                 </div>
                                              </div>
                                           </div>
                                           <div class="row">
                                              <div class="col-sm-12 col-md-6">
                                                 <button type="submit" class="btn btn-primary btn-lg" disabled id="up">Submit</button>   
                                              </div>
                                           </div>
                                           <!-- =========================== -->
                                        </div>
                                     </form>
                                  </div>     
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <!-- partial -->
               </div>
            </div>
            <!-- main-panel ends -->
         </div>
         <!-- page-body-wrapper ends -->
      </div>
      <!-- container-scroller -->
      </div>
      <?php include('include/footer.php')?>
      </div>    
      <?php include('include/script.php'); ?>
      <script>
         function checkold(str) {  
          if(str != '')   
                 {   
                      var emp_id = document.getElementById("emp_id").value;  
                     $.ajax({       
                         url:"<?php echo base_url('/index.php/check_old_pass')?>",  
                         method:"GET",
                         data:{oldpass:str, emp_id:emp_id},  
                         dataType:"JSON",
                         success:function(data)   
                         {     
                              if(data==1){ 
                 document.getElementById("hint").style.color="green";
                 document.getElementById("hint").innerHTML = "Congratulation: Old Password match."
                 document.getElementById("NewPassword").disabled = false; 
                 document.getElementById("ConfirmPassword").disabled = false;    
                 }else{
                 document.getElementById("hint").style.color="red";
                 document.getElementById("hint").innerHTML = "Failed: Old Password does not match!!"
                 document.getElementById("NewPassword").disabled = true; 
                 document.getElementById("ConfirmPassword").disabled = true;        
                 }
                         }
                     });
                 }
                 else   
                 {
                   document.getElementById("hint").innerHTML = "";  
                 }
         
         
         
         
         
         
         
         
         
         }
         
      </script>
      <script>  
         function checknew(str) {
         var acc = document.getElementById("NewPassword").value;
         var acd = document.getElementById("ConfirmPassword").value;
         if(acd!="")  
           if(acd==str){
         document.getElementById("msg").style.color="green";
         document.getElementById("msg").innerHTML = "Succesful: Password Confirmation." 
         document.getElementById("up").disabled = false;   
           }else{
          document.getElementById("msg").style.color="red";
         document.getElementById("msg").innerHTML = "Failed: Password Confirmation!!" 
         document.getElementById("up").disabled = true;          
           }  
         }
         
      </script>
      <script>  
         function checkcpass(str) {
         var acd = document.getElementById("NewPassword").value;
           if(acd==str){
         document.getElementById("msg").style.color="green";
         document.getElementById("msg").innerHTML = "Succesful: Password Confirmation." 
         document.getElementById("up").disabled = false; 
           }else{
          document.getElementById("msg").style.color="red";
         document.getElementById("msg").innerHTML = "Failed: Password Confirmation!!"
         document.getElementById("up").disabled = true;         
           }  
         }
      </script>
</html>