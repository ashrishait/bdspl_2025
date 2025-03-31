<?php 
   use App\Models\StateModel; 
   use App\Models\CityModel;
   use App\Models\DepartmentModel; 
   use App\Models\EmployeeModel;
   use App\Models\CompenyModel;
   use App\Models\PartyUserModel;
   $state = new StateModel();
   $city = new CityModel();
   $DepartmentModelObj = new DepartmentModel();
   $EmployeeModelObj = new EmployeeModel();
   $CompenyModelObj = new CompenyModel();
   $PartyUserModel = new PartyUserModel();
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
                              if(session()->has("active_deactive"))
                              {   
                                 if(session("active_deactive")==1)   
                                 {  
                                    echo "<div class='alert alert-danger' role='alert'> Comment Successfully Submitted. </div>";
                                 }
                                 else{
                                    echo "<div class='alert alert-danger' role='alert'> Problem in operation! </div>";
                                 }
                              }
                           ?> 
                           <?php
                              if(session()->has("pass_up"))
                              {   
                                 if(session("pass_up")==1)      
                                 {  
                                    echo "<div class='alert alert-success' role='alert'> Password Updation Successful. </div>";
                                 }
                                 else{
                                    echo "<div class='alert alert-danger' role='alert'> Problem in Updation! </div>";
                                 }
                              } 
                           ?> 
                        </div>

                        <div class="col-lg-12">
                            <div class="col-md-12 col-sm-12 List p-3">
                                <div class="row">
                                    <div class="col-6">
                                       <h3 style="font-weight: 600;">Help Support Details</h3>
                                    </div>
                                    <div class="col-6">
                                      
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
                                             <!-- <th><b>Compeny Name</b></th> -->
                                             <!-- <th><b>Vendor Name</b></th> -->
                                             <th><b>Vendor Message</b></th>
                                             <th><b>Company Reply</b></th>
                                             <!-- <th><b>Status</b></th> -->
                                             <th><b>Reply</b></th>
                                          </tr>
                                       </thead>
                                       <tbody>
                                          <?php  
                                          $result = $session->get();
                                          if(isset($users)){
                                             foreach ($users as $index => $row){
                                             ?>
                                             <tr>

                                                <td><?= $startSerial++ ?></td>
                                                <td><?php echo $row['Id']; ?></td>
                                               
                                               

                                               

                                                <td><?php echo $row['Vendor_Message']; ?></td>
                                                <td><?php echo $row['Company_Reply']; ?></td>
                                                

                                                <td>
                                                 <?php if($row['Status'] == 'open') { ?>
                                                     <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#bd-example-modal-lg-Status-<?php echo $row['Id']; ?>" title="Lock Account">
                                                         <span title="Status"><span class="mdi mdi-receipt-clock-outline"></span></span>
                                                     </button>

                                                    
                                                 <?php } else { ?>
                                                     <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#bd-example-modal-lg-Status-<?php echo $row['Id']; ?>" title="Lock Account">
                                                         <span title="Status"><span class="mdi mdi-receipt-clock-outline"></span></span>
                                                     </button>

                                                 <?php } ?>


                                                  
                                                  
                                                </td>
                                             </tr>
                                           

                                              <div class="modal fade bs-example-modal-lg" id="bd-example-modal-lg-Status-<?php echo $row['Id']; ?>" tabindex="<?php echo $row['id']; ?>" role="dialog" aria-labelledby="bd-example-modal-lg-del-<?php echo $row['id']; ?>" aria-hidden="true">
                                                        <div class="modal-dialog modal-md modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header bg-primary">
                                                                    <h4 class="modal-title text-white" id="myLargeModalLabel">Are you sure you want reply on this message</h4>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="">
                                                                        <div class="row">   
                                                <form method="post" action="<?php echo site_url('/Comment_Support_Help'); ?>">
                                                           <input type="hidden" name="id" value="<?php echo $row['Id']; ?>">
                                                        <input type="hidden" name="action" value="all">
                                                        <div class="col-sm-12 col-md-12" >
                                                         <div class="form-group">
                                                            <input type="text" name="Recived_Comment" class="form-control" style="padding: 0.875rem 1.375rem" value="<?php echo $row['Recived_Comment'];?>"> 
                                                              </div>
                                                             </div>
                                                        
                                                             <div class="col-sm-12 col-md-12">
                                                              <button type="submit" class="btn btn-primary">Submit</button>
                                                               <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
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
                                       <span style="font-weight: bold;color: blue;">  Main Pagination</span>
                                       <?php if ($pager) :?>
                                          <?= $pager->links() ?>
                                       <?php endif ?>
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
  
   </body>
</html>