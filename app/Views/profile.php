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
                                $Emprow= $modelEmployee->where('id',$emp_id)->first();
                              ?>
                        </div>
                        <div class="">
                            <div class="col-md-12 col-sm-12 List p-3">
                                <div class="row">
                                    <div class="col-6">
                                       <h2>Profile</h2>
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
                                                    <!-- <div class="col-sm-12 col-md-12">
                                                      <center>
                                                       <img src="<?php echo base_url('public/vendors/PicUpload/'.$Emprow['emp_image']);?>" style="height:100px; width:auto;" id="output" style="border-radius:50 %;">
                                                       <br>
                                                      </center>
                                                    </div> -->
                                                    <div class="col-sm-6 col-md-6">
                                                       <div class="form-group">
                                                          <label>First Name <span style="color:red;"></span></label><span id="hint"></span>
                                                          <input  class="form-control" type="text" id="oldpassword" name="old_pass"  value="<?php echo $Emprow['first_name'];?>" readonly>
                                                       </div>
                                                    </div>
                                                     <div class="col-sm-6 col-md-6">
                                                       <div class="form-group">
                                                          <label>Last Name <span style="color:red;"></span></label><span id="hint"></span>
                                                          <input  class="form-control" type="text" id="oldpassword" name="old_pass"  value="<?php echo $Emprow['last_name'];?>" readonly>
                                                       </div>
                                                    </div>
                                                   <div class="col-sm-6 col-md-6">
                                                       <div class="form-group">
                                                          <label>email   <span style="color:red;"></span></label><span id="hint"></span>
                                                          <input  class="form-control" type="text" id="oldpassword" name="old_pass"  value="<?php echo $Emprow['email'];?>" readonly>
                                                       </div>
                                                    </div>  
                                                    <div class="col-sm-6 col-md-6">
                                                       <div class="form-group">
                                                          <label>    mobile  <span style="color:red;"></span></label><span id="hint"></span>
                                                          <input  class="form-control" type="text" id="oldpassword" name="old_pass"  value="<?php echo $Emprow['mobile'];?>" readonly>
                                                       </div>
                                                    </div>   
                                                    <div class="col-sm-6 col-md-6">
                                                       <div class="form-group">
                                                          <label>Gender  <span style="color:red;"></span></label><span id="hint"></span>
                                                          <input  class="form-control" type="text" id="oldpassword" name="old_pass"  value="<?php echo $Emprow['gender'];?>" readonly>
                                                       </div>
                                                    </div>
                                                 </div>
                                              </div>
                                           </div>
                                           <div class="row">
                                              <div class="col-sm-12 col-md-6">
                                             <!--    <button type="submit" class="btn btn-primary btn-lg" disabled id="up">Submit</button>   -->
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
      
</html>