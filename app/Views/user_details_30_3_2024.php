<?php 
   use App\Models\StateModel; 
   use App\Models\CityModel;
   use App\Models\DepartmentModel; 
   use App\Models\EmployeeModel;
   use App\Models\CompenyModel;
   $state = new StateModel();
   $city = new CityModel();
   $DepartmentModelObj = new DepartmentModel();
   $EmployeeModelObj = new EmployeeModel();
   $CompenyModelObj = new CompenyModel();
   ?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <?php include('include/head.php'); ?>
   </head>
   <body>
      <div class="container-scroller">
         <?php include('include/header.php'); ?>
         <div class="container-fluid page-body-wrapper">
            <div class="main-panel">
               <div class="content-wrapper">
                  <div class="row">
                     <div class="col-lg-12 mb-lg-0">
                        <div class="card congratulation-bg py-0" style="background:none;">
                           <div class="card-body py-0">
                              <div class="container">
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
                  <div class="container-fluid">
                     <div class="row">
                        <div class="col-md-12 col-sm-12"> 
                           <?php
                              if(session()->has("emp_delete"))
                              {   
                                  if(session("emp_delete")==1)   
                                  {  
                              echo "<div class='alert alert-success' role='alert'>Record Deleted Successfully. </div>";
                                  }
                                  else{
                                      echo "<div class='alert alert-danger' role='alert'>For Deleting any Employee, Kindely deactive their Login Account First!! </div>";   
                                  }
                              }
                              if(session()->has("emp_ok"))
                              {   
                                  if(session("emp_ok")==1)   
                                  {  
                              echo "<div class='alert alert-success' role='alert'> Form Submition Successful. </div>";
                                  }
                                  else{
                                      echo "<div class='alert alert-danger' role='alert'> Problem in Submition! </div>";
                                  }
                                  if(session("emp_ok")==0)   
                                  {  
                              echo "<div class='alert alert-danger' role='alert'> Invalid File Formate! </div>";
                                  }
                              } 
                              if(session()->has("emp_up"))
                              {   
                                  if(session("emp_up")==1)   
                                  {  
                              echo "<div class='alert alert-success' role='alert'> Form Updation Successful. </div>";
                                  }
                                  else{
                                      echo "<div class='alert alert-danger' role='alert'> Problem in Updation! </div>";
                                  }
                              } 
                              if(session()->has("allot_stu_ok"))
                              {   
                                      if(session("allot_stu_ok")==1)   
                                      {  
                                  echo "<div class='alert alert-success' role='alert'> Student allotment Successful. </div>";
                                      }
                                      else{
                                          echo "<div class='alert alert-danger' role='alert'> Problem in allotment! </div>";
                                      }
                                  } 
                               if(session()->has("lock_emp"))
                              {   
                                      if(session("lock_emp")==1)   
                                      {  
                                  echo "<div class='alert alert-success' role='alert'> Consultant account has been locked Successful. </div>";
                                      }
                                      else{
                                          echo "<div class='alert alert-danger' role='alert'> Problem in operation! </div>";
                                      }
                                  }
                                  if(session()->has("unlock_emp"))
                              {   
                                      if(session("unlock_emp")==1)   
                                      {  
                                  echo "<div class='alert alert-success' role='alert'> Consultant account has been Unlocked Successful. </div>";
                                      }
                                      else{
                                          echo "<div class='alert alert-danger' role='alert'> Problem in operation! </div>";
                                      }
                                  }
                                  if(session()->has("uprollm"))
                              {   
                                      if(session("uprollm")==1)   
                                      {  
                                  echo "<div class='alert alert-success' role='alert'> Operation Successful. </div>";
                                      }
                                      else{
                                          echo "<div class='alert alert-danger' role='alert'> Problem in Operation! </div>";
                                      }
                                  }
                                  if(session()->has("csv_up")) 
                              {   
                                      if(session("csv_up")==1)   
                                      {  
                                  echo "<div class='alert alert-success' role='alert'> CSV File Uploaded Successfully. </div>";
                                      }
                                      else{
                                          echo "<div class='alert alert-danger' role='alert'> Problem in Submission/Kindely Upload CSV Format!! </div>";
                                      }
                                  }
                              ?> 
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
                        <div class="col-lg-12">
                            <div class="col-md-12 col-sm-12 List p-3">
                                <div class="row">
                                    <div class="col-6">
                                       <h2>View User</h2>
                                    </div>
                                    <div class="col-6">
                                        <a id="rowAdder" type="button" class="btn btn-success float-end" href="<?php echo base_url();?>/index.php/add-user">
                                            <span class="bi bi-plus-square-dotted">
                                            </span> Add User
                                       </a>
                                    </div>
                                </div>
                            </div>
                           <div class="card">
                              <div class="card-body p-1">
                                 <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                       <thead>
                                          <tr>
                                             <th><b>#</b></th>
                                             <th><b>Id. No</b></th>
                                             <th><b>Compeny Name</b></th>
                                             <th><b>Name</b></th>
                                             <th><b>Phone</b></th>
                                             <th><b>Email</b></th>
                                             <th><b>Role</b></th>
                                             <th><b>Action</b></th>
                                          </tr>
                                       </thead>
                                       <tbody>
                                          <?php  
                                             $result = $session->get();
                                                  $etm = $result['edn'];  
                                             $i=0+$etm;
                                             if(isset($dax)){
                                             foreach ($dax as $row){
                                             $i = $i+1;
                                             $row
                                             ?>
                                          <tr>
                                             <td><?php echo $i; ?></td>
                                             <td><?php echo $row['id']; ?></td>
                                             <td><?php 
                                                $Compenyrow= $CompenyModelObj->where('id',$row['compeny_id'])->first();
                                                if(isset($Compenyrow) && $Compenyrow!='')
                                                {
                                                 echo $Compenyrow['name']; 
                                                }
                                                ?> 
                                             </td>
                                             <td><?php echo ucwords($row['first_name']).' '.ucwords($row['last_name']); ?></td>
                                             <td>+91-<?php echo $row['mobile']; ?></td>
                                             <td><?php echo $row['email']; ?></td>
                                             <td><span style="font-size:16px!important;"><b><i><?php echo ucwords($row['Name']); ?></i></b></span></td>
                                             <td><?php if($row['active']==1){ ?>
                                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#bd-example-modal-lg-lock-<?php echo $row['id']; ?>" title="Lock Account"><span class="mdi mdi-lock-check-outline"></span></button>
                                                <?php } 
                                                   else { ?>
                                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#bd-example-modal-lg-unlock-<?php echo $row['id']; ?>" title="Unlock Account"><span class="mdi mdi-lock-open"></span></button>
                                                <?php } ?>
                                                <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#bd-example-modal-lg-<?php echo $row['id']; ?>" title="View"><span class="mdi mdi-eye-check-outline"></span></button>
                                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#bd-example-modal-lg-edit-<?php echo $row['id']; ?>" title="Edit"><span class="mdi mdi-pen"></span></button>
                                                <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#bd-example-modal-lg-del-<?php echo $row['id']; ?>" title="Delete"><span class="mdi mdi-trash-can-outline"></span></button>
                                                <button class="btn btn-dark btn-sm" data-bs-toggle="modal" data-bs-target="#bd-example-modal-lg-role-<?php echo $row['id']; ?>" title="Manage Role"><span class="mdi mdi-account-details-outline"></span></button>
                                                <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#bd-example-modal-lg-changepassword-<?php echo $row['id']; ?>" title="Change Password"><span class="mdi mdi-lock-reset"></span></button>
                                                <?php 
                                               if($row['role']==8)
                                               {
                                               
                                               }
                                               else
                                               {
                                               ?>
                                                <button class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#bd-example-modal-lg-DirectLogin-<?php echo $row['id']; ?>" title="Direct Login"><span class="mdi mdi-login-variant"></span></button>
                                                <?php
                                                }
                                                ?>
                                             </td>
                                          </tr>
                                          <div class="modal fade bs-example-modal-lg" id="bd-example-modal-lg-DirectLogin-<?php echo $row['id']; ?>" tabindex="<?php echo $row['id']; ?>" role="dialog" aria-labelledby="bd-example-modal-lg-DirectLogin-<?php echo $row['id']; ?>" aria-hidden="true">
                                             <div class="modal-dialog modal-sm modal-dialog-centered">
                                                <div class="modal-content">
                                                   <div class="modal-header">
                                                      <h4 class="modal-title" id="myLargeModalLabel">Login this User</h4>
                                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                   </div>
                                                   <div class="modal-body">
                                                      <div class="container">
                                                         <!-- ================================== --> 
                                                         <div class="row">
                                                            <div class="col-sm-12 col-md-12">
                                                               <form method="post" action="<?php echo site_url('/DirectUserLogin'); ?>">
                                                                  <input type="hidden" name="email" value="<?php echo $row['email']; ?>">
                                                                  <input type="hidden" name="bylogin_email" value="<?php echo $email; ?>">
                                                                  <button type="submit" class="btn btn-primary">Login</button>
                                                                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                               </form>
                                                            </div>
                                                         </div>
                                                         <!-- =========================== -->
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                          <div class="modal fade bs-example-modal-lg" id="bd-example-modal-lg-changepassword-<?php echo $row['id']; ?>" tabindex="<?php echo $row['id']; ?>" role="dialog" aria-labelledby="bd-example-modal-lg-changepassword-<?php echo $row['id']; ?>" aria-hidden="true">
                                             <div class="modal-dialog modal-sm modal-dialog-centered">
                                                <div class="modal-content">
                                                   <div class="modal-header">
                                                      <h4 class="modal-title" id="myLargeModalLabel">Manage Change Password</h4>
                                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                   </div>
                                                   <div class="modal-body">
                                                      <div class="container">
                                                         <!-- ================================== --> 
                                                         <div class="row">
                                                            <div class="col-sm-12 col-md-12">
                                                               <form method="post" action="<?php echo site_url('/Userupdate_pass'); ?>">
                                                                  <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                                                  <div class="col-sm-12 col-md-12">
                                                                     <div class="form-group">
                                                                        <label>Change Password <span style="color:red;">*</span></label>
                                                                        <input type="text" name="new_pass" class="form-control"  required> 
                                                                     </div>
                                                                  </div>
                                                                  <button type="submit" class="btn btn-primary">Change Password</button>
                                                                  <button type="button" class="btn btn-secondary" data- bs-dismiss="modal">Close</button>
                                                               </form>
                                                            </div>
                                                         </div>
                                                         <!-- =========================== -->
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                          <div class="modal fade bs-example-modal-lg" id="bd-example-modal-lg-role-<?php echo $row['id']; ?>" tabindex="<?php echo $row['id']; ?>" role="dialog" aria-labelledby="bd-example-modal-lg-role-<?php echo $row['id']; ?>" aria-hidden="true">
                                             <div class="modal-dialog modal-sm modal-dialog-centered">
                                                <div class="modal-content">
                                                   <div class="modal-header">
                                                      <h4 class="modal-title" id="myLargeModalLabel">Manage Role</h4>
                                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                   </div>
                                                   <div class="modal-body">
                                                      <div class="container">
                                                         <!-- ================================== --> 
                                                         <div class="row">
                                                            <div class="col-sm-12 col-md-12">
                                                               <form method="post" action="<?php echo site_url('/role-emp-mng'); ?>">
                                                                  <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                                                  <div class="col-sm-12 col-md-12">
                                                                     <div class="form-group">
                                                                        <label>Role <span style="color:red;">*</span></label>
                                                                        <select name="up_role" class="form-control"  required onchange="submit()">
                                                                           <option value="">-Select State-</option>
                                                                           <?php foreach ($dax10 as $roxi10){ ?>
                                                                           <option value="<?php echo $roxi10['Roll_Id']; ?>" <?php if($row['role']==$roxi10['Roll_Id']) {echo 'selected="selected"';} ?>><?php echo ucwords($roxi10['Name']); ?></option>
                                                                           <?php } ?>    
                                                                        </select>
                                                                     </div>
                                                                  </div>
                                                                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                               </form>
                                                            </div>
                                                         </div>
                                                         <!-- =========================== -->
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                          <!-- ==========================Model For Details Roll manage=============================== -->
                                          <!-- ========================Model For Account Ristrict Start================================= -->
                                          <div class="modal fade bs-example-modal-lg" id="bd-example-modal-lg-lock-<?php echo $row['id']; ?>" tabindex="<?php echo $row['id']; ?>" role="dialog" aria-labelledby="bd-example-modal-lg-lock-<?php echo $row['id']; ?>" aria-hidden="true">
                                             <div class="modal-dialog modal-sm modal-dialog-centered">
                                                <div class="modal-content">
                                                   <div class="modal-header">
                                                      <h4 class="modal-title" id="myLargeModalLabel">Lock Account</h4>
                                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                   </div>
                                                   <div class="modal-body">
                                                      <div class="container">
                                                         <!-- ================================== -->    
                                                         <div class="row">
                                                            <div class="col-sm-12 col-md-12">
                                                               <form method="post" action="<?php echo site_url('/lock-emp'); ?>">
                                                                  <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                                                  Are You Sure To Lock <?php echo ucwords($row['first_name'].' '.$row['last_name']); ?> Account !<br>
                                                                  <button type="submit" class="btn btn-danger">Yes</button>
                                                                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                               </form>
                                                            </div>
                                                         </div>
                                                         <!-- =========================== -->
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                          <!-- **************************** -->
                                          <div class="modal fade bs-example-modal-lg" id="bd-example-modal-lg-unlock-<?php echo $row['id']; ?>" tabindex="<?php echo $row['id']; ?>" role="dialog" aria-labelledby="bd-example-modal-lg-unlock-<?php echo $row['id']; ?>" aria-hidden="true">
                                             <div class="modal-dialog modal-sm modal-dialog-centered">
                                                <div class="modal-content">
                                                   <div class="modal-header">
                                                      <h4 class="modal-title" id="myLargeModalLabel">Unlock Account</h4>
                                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                   </div>
                                                   <div class="modal-body">
                                                      <div class="container">
                                                         <!-- ================================== -->    
                                                         <div class="row">
                                                            <div class="col-sm-12 col-md-12">
                                                               <form method="post" action="<?php echo site_url('/unlock-emp'); ?>">
                                                                  <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                                                  Are You Sure To unlock <?php echo ucwords($row['first_name'].' '.$row['last_name']); ?> Account !<br>
                                                                  <button type="submit" class="btn btn-danger">Yes</button>
                                                                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                               </form>
                                                            </div>
                                                         </div>
                                                         <!-- =========================== -->
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                          <!-- ==========================Model For Account Ristrict End=============================== -->
                                          <!-- ========================Model For Deleted================================ -->
                                          <div class="modal fade bs-example-modal-lg" id="bd-example-modal-lg-del-<?php echo $row['id']; ?>" tabindex="<?php echo $row['id']; ?>" role="dialog" aria-labelledby="bd-example-modal-lg-del-<?php echo $row['id']; ?>" aria-hidden="true">
                                             <div class="modal-dialog modal-sm modal-dialog-centered">
                                                <div class="modal-content">
                                                   <div class="modal-header">
                                                      <h4 class="modal-title" id="myLargeModalLabel">Delete</h4>
                                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                   </div>
                                                   <div class="modal-body">
                                                      <div class="container">
                                                         <!-- ================================== --> 
                                                         <div class="row">
                                                            <div class="col-sm-12 col-md-12">
                                                               <form method="post" action="<?php echo site_url('/del-emp'); ?>">
                                                                  <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                                                  Are You Sure To Delete This Record!<br>
                                                                  <button type="submit" class="btn btn-danger">Delete</button>
                                                                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                               </form>
                                                            </div>
                                                         </div>
                                                         <!-- =========================== -->
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                          <!-- ==========================Model For Deleted End=============================== -->
                                          <!-- ========================Model For Details View Start================================= -->
                                          <div class="modal fade bs-example-modal-lg" id="bd-example-modal-lg-<?php echo $row['id']; ?>" tabindex="<?php echo $row['id']; ?>" role="dialog" aria-labelledby="bd-example-modal-lg-<?php echo $row['id']; ?>" aria-hidden="true">
                                             <div class="modal-dialog modal-lg modal-dialog-centered">
                                                <div class="modal-content">
                                                   <div class="modal-header">
                                                      <h4 class="modal-title" id="myLargeModalLabel">Employee Details</h4>
                                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                   </div>
                                                   <div class="modal-body">
                                                      <div class="container">
                                                         <!-- ================================== -->
                                                         <div class="row">
                                                            <div class="col-sm-12 col-md-6">
                                                               <div class="col-sm-12 col-md-12">
                                                                  <div class="form-group"> 
                                                                     <?php if($row['emp_image']!=""){ ?>
                                                                     <img src="<?php echo base_url('public/vendors/PicUpload/'.$row['emp_image']);?>" style="height:150px; width:auto;" id="output">
                                                                     <?php } else { ?>
                                                                     <img src="<?php echo base_url('public/vendors/PicUpload/noimg.jpg');?>" style="height:150px; width:auto;" id="output">  
                                                                     <?php }  ?>
                                                                     <br>
                                                                     <b style="color:#0099ff;"><?php echo ucwords($row['emp_u_id']); ?></b>
                                                                  </div>
                                                               </div>
                                                            </div>
                                                            <div class="col-sm-12 col-md-6">
                                                               <div class="row">
                                                                  <div class="col-sm-12 col-md-12">
                                                                     <b style="color:#0099ff;">Personal Info</b><br>
                                                                     <b>Name :</b> <?php echo ucwords($row['first_name']).' '.ucwords($row['last_name']); ?><br>
                                                                    
                                                                     <b>Gender :</b> <?php echo ucwords($row['gender']); ?><br>
                                                                     
                                                                  </div>
                                                               </div>
                                                            </div>
                                                         </div>
                                                         <div class="row" style="margin-top:30px;">
                                                            <div class="col-sm-12 col-md-6">
                                                               <b style="color:#0099ff;">Contact Info</b><br>
                                                               <b>Email :</b> <?php echo ($row['email']); ?><br>
                                                               <b>Mobile No. :</b> +91 <?php echo ($row['mobile']); ?>
                                                               <div style="margin-top:30px;">
                                                                  <b style="color:#0099ff;">Official Info</b><br>
                                                                  <b>Role :</b> <?php echo ucwords($row['Name']); ?><br>
                                                                  <b>Department :</b> 
                                                                  <?php
                                                                     $rowDepartment = $DepartmentModelObj->where('id',$row['department'])->findAll();
                                                                     if(isset($rowDepartment) && $rowDepartment!='')
                                                                     {
                                                                         foreach ($rowDepartment as $rowDepartment2)
                                                                         { 
                                                                     
                                                                     echo $rowDepartment2['name']; 
                                                                        
                                                                     
                                                                         }
                                                                     }
                                                                     ?> 
                                                               </div>
                                                            </div>
                                                        </div>
                                                         <!-- =========================== -->
                                                      </div>
                                                   </div>
                                                   <div class="modal-footer">
                                                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                          <!-- ==========================Model For Details View End=============================== -->
                                          <!-- ========================Model For Edit Details Start================================= -->
                                          <div class="modal fade bs-example-modal-lg" id="bd-example-modal-lg-edit-<?php echo $row['id']; ?>" tabindex="<?php echo $row['id']; ?>" role="dialog" aria-labelledby="bd-example-modal-lg-edit-<?php echo $row['id']; ?>" aria-hidden="true">
                                             <div class="modal-dialog modal-lg modal-dialog-centered" style="max-width:1160px;">
                                                <div class="modal-content">
                                                   <div class="modal-header">
                                                      <h4 class="modal-title" id="myLargeModalLabel">Edit Employee Details</h4>
                                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                   </div>
                                                   <div class="modal-body">
                                                      <form method="post" action="<?php echo site_url('/update-employee'); ?>" enctype="multipart/form-data">
                                                         <div class="container">
                                                            <!-- ================================== -->
                                                            <div class="row" style="margin-bottom:20px;">
                                                               <div>
                                                                  <div class="row">
                                                                     <div class="col-sm-12 col-md-3">
                                                                        <div class="form-group">
                                                                           <label>ID No.</label>
                                                                           <input class="form-control" id="Emp_id_no_<?php echo $row['id']; ?>" value="<?php echo $row['emp_u_id']; ?>" type="text" name="Emp_id_no" readonly>
                                                                           <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                                                           <!--<input class="form-control" id="emp_jio_id_<?php echo $row['id']; ?>" value="<?php echo $row['emp_jio_id']; ?>" type="hidden" name="emp_jio_id">-->
                                                                        </div>
                                                                     </div>
                                                                     <div class="col-sm-12 col-md-3">
                                                                        <div class="form-group">
                                                                           <label>First Name <span style="color:red;">*</span></label>
                                                                           <input  class="form-control" type="text" name="F_Name" value="<?php echo $row['first_name']; ?>" required>
                                                                        </div>
                                                                     </div>
                                                                     <div class="col-sm-12 col-md-3">
                                                                        <div class="form-group">
                                                                           <label>Last Name <span style="color:red;">*</span></label>
                                                                           <input class="form-control" type="text" name="L_Name" value="<?php echo $row['last_name']; ?>" required>
                                                                        </div>
                                                                     </div>
                                                                     <div class="col-sm-12 col-md-3">
                                                                        <div class="col-sm-12 col-md-12">
                                                                            <div class="form-group">
                                                                                <input type="hidden" name="db_image" value="<?php echo $row['emp_image']; ?>">			
                                                                                <img src="<?php echo base_url('public/vendors/PicUpload/'.$row['emp_image']);?>" style="height:120px; width:auto;" id="output<?php echo $row['id']; ?>">
                                                                                <input type="file" class="form-control-file form-control height-auto" name="E_Image" style="width:120px;" onchange="loadFile(<?php echo $row['id']; ?>)">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                  </div>
                                                               </div>
                                                            </div>
                                                            <div class="row">
                                                               <div class="col-sm-12 col-md-3">
                                                                  <div class="form-group">
                                                                     <label>Gender <span style="color:red;">*</span></label>
                                                                     <select name="Gender" class="form-control" required>
                                                                        <option value="">-Select-</option>
                                                                        <option value="Male" <?php if($row['gender']=='Male') {echo 'selected="selected"';} ?>>Male</option>
                                                                        <option value="Female" <?php if($row['gender']=='Female') {echo 'selected="selected"';} ?>>Female</option>
                                                                        <option value="Any Other" <?php if($row['gender']=='Any Other') {echo 'selected="selected"';} ?>>Any Other
                                                                        </option>
                                                                     </select>
                                                                  </div>
                                                               </div>
                                                               <div class="col-sm-12 col-md-3">
                                                                  <div class="form-group">  
                                                                     <label>Email <span style="color:red;">*</span></label>
                                                                     <input class="form-control" type="email" name="Email_id" value="<?php echo $row['email']; ?>" required readonly>
                                                                  </div>
                                                               </div>
                                                               <div class="col-sm-12 col-md-3">
                                                                  <div class="form-group">
                                                                     <label>Mobile No <span style="color:red;">*</span></label>
                                                                     <input class="form-control" type="number" name="Mobile" value="<?php echo $row['mobile']; ?>" required readonly>
                                                                  </div>
                                                               </div>
                                                               <div class="col-sm-12 col-md-3">
                                                                    <div class="form-group">
                                                                  	    <label>Role <span style="color:red;">*</span></label>
                                                                  		<select name="role" class="form-control"  required style="padding: 0.875rem 1.375rem"> 
                                                                            <?php 
                                                                            if(isset($dax10)){
                                                                                foreach ($dax10 as $roxi10){ ?>
                                                                  			  	<option value="<?php echo $roxi10['Roll_Id']; ?>" <?php if($row['role']==$roxi10['Roll_Id']) {echo 'selected';} ?>><?php echo ucwords($roxi10['Name']); ?></option>
                                                                  			    <?php }
                                                                  			} ?>    
                                                                        </select>
                                                                    </div>  
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="row">
                                                                <?php 
                                                                if($Roll_id=='0')
                                                                {
                                                                    ?>
                                                                    <input type="hidden" name="unit_id" value="<?php echo $row['unit_id'];?>" >
                                                                    <input type="hidden" name="department" value="<?php echo $row['department'];?>"  >
                                                                    <?php
                                                                }
                                                                else
                                                                {
                                                                  	?>
                                                                    <div class="col-sm-12 col-md-3">
                                                                        <div class="form-group">
                                                                            <label>Unit <span style="color:red;">*</span></label>
                                                                            <select name="unit_id" class="form-control" id="Unit_Id___"  style="padding: 0.875rem 1.375rem"  >
                                                                                <option value="">-Select -</option>
                                                                                <?php foreach ($dax11 as $ron11){ ?>
                                                                                <option value="<?php echo $ron11['id']; ?>" <?php if($row['unit_id']==$ron11['id']) {echo 'selected="selected"';} ?>><?php echo ucwords($ron11['name']); ?></option>
                                                                                <?php } ?>    
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-12 col-md-3">
                                                                        <div class="form-group">
                                                                            <label>Department <span style="color:red;">*</span></label>
                                                                            <select name="department" class="form-control" style="padding: 0.875rem 1.375rem" required id="department____">
                                                                                <option value="">-Select Department-</option>
                                                                                <?php
                                                                                if(isset($dax9)){
                                                                                   foreach ($dax9 as $row9){ ?>
                                                                                    <option value="<?php echo $row9['id']; ?>"  <?php if($row['department']==$row9['id']) {echo 'selected';} ?>><?php echo ucwords($row9['name']); ?></option>
                                                                                    <?php }} ?>    
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <?php
                                                                }            
                                                                ?>
                                                            </div>
                                                            <div class="row">
                                                               <div class="col-sm-12 col-md-6">
                                                                  <button type="submit" class="btn btn-primary">Submit</button>   
                                                               </div>
                                                            </div>
                                                            <!-- =========================== -->
                                                         </div>
                                                      </form>
                                                   </div>
                                                   <div class="modal-footer">
                                                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                          <!-- ==========================Model For Edit Details End=============================== -->
                                          <?php } } ?>
                                       </tbody>
                                    </table>
                                 </div>
                                 <div>
                                    <br>
                                    <?php if($session->get("edn")>=10){ ?>
                                    <a href="<?php echo base_url('/index.php/edxm');?>" class="btn btn-lg btn-primary"> << previous</a>-----<?php } ?><a href="<?php echo base_url('/index.php/edx');?>" class="btn btn-sm btn-primary">next >></a>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <!-- content-wrapper ends -->
               <!-- partial:partials/_footer.html -->
               <?php include('include/footer.php')?>
               <!-- partial -->
            </div>
            <!-- main-panel ends -->
         </div>
         <!-- page-body-wrapper ends -->
      </div>
      <!-- container-scroller -->
      <?php include('include/script.php'); ?>
      <script>
         function allotstudent(str){
         
         var stx = (str.split("=")[0]);
         var st = (str.split("=")[1]);
         
         
         
                    $.ajax({       
                        url:"<?php echo base_url('/index.php/get-stu-for-allot')?>",  
                        method:"GET",
                        data:{location_id:stx},   
                        // dataType:"JSON",
                        success:function(data)   
                        {      
                        	document.getElementById('allot').innerHTML = data;
                        	document.getElementById('emp_idxmx').value = st; 
                       }
                    });
                }
               	
         
         
      </script>	
      <script>
         $('document').ready(function(){
         	$('.data-table').DataTable({
         		scrollCollapse: true,
         		autoWidth: false,
         		responsive: true,
         		columnDefs: [{
         			targets: "datatable-nosort",
         			orderable: false,
         		}],
         		"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
         		"language": {
         			"info": "_START_-_END_ of _TOTAL_ entries",
         			searchPlaceholder: "Search"
         		},
         	});
         	$('.data-table-export').DataTable({
         		scrollCollapse: true,
         		autoWidth: false,
         		responsive: true,
         		columnDefs: [{
         			targets: "datatable-nosort",
         			orderable: false,
         		}],
         		"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
         		"language": {
         			"info": "_START_-_END_ of _TOTAL_ entries",
         			searchPlaceholder: "Search"
         		},
         		dom: 'Bfrtip',
         		buttons: [
         		'copy', 'csv', 'pdf', 'print'
         		]
         	});
         	var table = $('.select-row').DataTable();
         	$('.select-row tbody').on('click', 'tr', function () {
         		if ($(this).hasClass('selected')) {
         			$(this).removeClass('selected');
         		}
         		else {
         			table.$('tr.selected').removeClass('selected');
         			$(this).addClass('selected');
         		}
         	});
         	var multipletable = $('.multiple-select-row').DataTable();
         	$('.multiple-select-row tbody').on('click', 'tr', function () {
         		$(this).toggleClass('selected');
         	});
         });
      </script>
      <script>
         function generateid(str){  
         	const d = new Date();
         	var year = d.getFullYear();   
             
         	var stx = (str.split("=")[0]);
         	var st = (str.split("=")[1]);
         	var stm = (str.split("=")[2]);
         	// alert(stx+'-- '+st+'-- '+stm); 
         	var inc = document.getElementById('emp_jio_id_'+stm).value; 
         	document.getElementById('location_id_'+stm).value= stx;
         	document.getElementById('Emp_id_no_'+stm).value='JVS/E/'+st+'/'+inc+'/'+year;  
          
         
         } 
      </script>                                         
      <script>
         var loadFile = function(str) {
           var reader = new FileReader();
           reader.onload = function(){
             var output = document.getElementById('output'+str);
             output.src = reader.result;
           };
           reader.readAsDataURL(event.target.files[0]);
         };
      </script>
      <script>
         function hello(){
         if(document.getElementById('good').checked == true){
         document.getElementById('pa').value = document.getElementById('ca').value;
         document.getElementById('ps').value = document.getElementById('cs').value;
         document.getElementById('pc').value = document.getElementById('cc').value;
         document.getElementById('pp').value = document.getElementById('cp').value;
         
                var city_id = $('#cc').val();  
                var action = 'get_city';   
                if(city_id != '')   
                {   
                    $.ajax({       
                        url:"<?php echo base_url('getsamecityx')?>",  
                        method:"GET",
                        data:{city_id:city_id, action:action},  
                        dataType:"JSON",
                        success:function(data)   
                        {        
         
                            for(var count = 0; count < data.length; count++)
                            {
                                html = '<option value="'+data[count].id+'">'+data[count].city_name+'</option>';
                            }
         
                            $('#pc').html(html);
                        }
                    });
                }
                else   
                {
                    $('#pc').val('');
                }
         
         
         
         }else{
         document.getElementById('pa').value = "";
         document.getElementById('ps').value = "";
         document.getElementById('pc').value = "";
         document.getElementById('pp').value = "";
         }
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
                    url:"<?php echo base_url('getcityx')?>",
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
         
            $('#ps').change(function(){ 
            var state_id = $('#ps').val();  
            var action = 'get_city';   
            if(state_id != '')
            {   
                $.ajax({     
                    url:"<?php echo base_url('getcityx')?>",
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
         
                        $('#pc').html(html);
                    }
                });
            }
            else   
            {
                $('#pc').val('');
            }
         
         });
         
            });
      </script>
      <?php
         $rowemp = $EmployeeModelObj->where('actives',1)->findAll();
                if(isset($rowemp) && $rowemp!='')
                     {
                    foreach ($rowemp as $rowemp)
                     { 
                         ?>
      <script>  
         $(document).ready(function () {
         
         $('#department<?php echo $rowemp['id']; ?>').change(function(){ 
            var state_id = $('#department<?php echo $rowemp['id']; ?>').val();  
            var action = 'get_unit';   
            if(state_id != '')
            {   
                $.ajax({     
                    url:"<?php echo base_url('getUnit')?>",
                    method:"GET",
                    data:{state_id:state_id, action:action},  
                    dataType:"JSON",
                    success:function(data)  
                    {        
                        var html = '<option value="">Select Unit</option>';
         
                        for(var count = 0; count < data.length; count++)
                        {
                            html += '<option value="'+data[count].id+'">'+data[count].name+'</option>';
                        }
         
                        $('#Unit_Id<?php echo $rowemp['id']; ?>').html(html);
                    }
                });
            }
            else   
            {
                $('#Unit_Id<?php echo $rowemp['id']; ?>').val('');
            }
         
         });
         
         
         
            });
      </script>
      <?php
         }
         }
         
         ?>
   </body>
</html>