<?php 
   use App\Models\EmployeeModel; 
   
   $EmployeeModelObj = new EmployeeModel();
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
                  <div class="container-fluid">
                     <div class="row">
                        <div class="col-md-12 col-sm-12"> 
                           <?php
                             
                              if(session()->has("data_delete"))
                              {   
                                  if(session("data_delete")==1)   
                                  {  
                              echo "<div class='alert alert-success' role='alert'> Delete Successful. </div>";
                                  }
                                  else{
                                      echo "<div class='alert alert-danger' role='alert'> Problem in Submition! </div>";
                                  }
                                  
                              }
                              

                              if(session()->has("status"))
                              {   
                                  if(session("status")==1)   
                                  {  
                              echo "<div class='alert alert-success' role='alert'> Status Change Successful. </div>";
                                  }
                                  else{
                                      echo "<div class='alert alert-danger' role='alert'> Problem in Submition! </div>";
                                  }
                                  
                              }
                                                      
                              ?>    
                        </div>
                        <div class="col-lg-12">
                            <div class="col-md-12 col-sm-12 List p-3">
                                <div class="row">
                                    <div class="col-6">
                                       <h2>View Request Reward Point history</h2>
                                    </div>
                                    <div class="col-6">
                                       
                                    </div>
                                </div>
                            </div>
                           <div class="card">
                              <div class="card-body">
                                 <div class="table-responsive pt-3">
                                    <table class="table table-bordered table-hover">
                                       <thead>
                                          <tr>
                                             <th><b>S.No</b></th>
                                             <th><b> Emp Name</b></th>
                                             <th><b>Request Reward Point</b></th>
                                              <th><b>Comment</b></th>
                                             <th><b>Action</b></th>
                                          </tr>
                                       </thead>
                                       <tbody>
                                          <?php  
                                             $i=0;
                                             if(isset($dax)){
                                             foreach ($dax as $row){
                                             $i = $i+1;?>
                                          <tr>
                                             <td><?php echo $row['id']; ?></td>
                                            <td><?php 
                                                $Emprow= $EmployeeModelObj->where('id',$row['emp_id'])->first();
                                                if(isset($Emprow) && $Emprow!='')
                                                {
                                                    echo $Emprow['first_name']; 
                                                    echo $Emprow['last_name']; 
                                                }
                                                ?> 
                                            </td>
                                             <td><?php echo $row['request_reward_point']; ?></td>
                                              <td><?php echo $row['Comment']; ?></td>
                                             <td>
                                              <?php
                                              if($row['status']==1)
                                                                {
                                                                    ?>
                                                                    <span class="span text-danger" data-bs-toggle="modal" data-bs-target="#bd-example-modal-lg-del-<?php echo $row['id']; ?>"><span class="mdi mdi-trash-can-outline"></span></span>

                                                                      <span class="span text-primary" data-bs-toggle="modal" data-bs-target="#bd-example-modal-lg-Status-<?php echo $row['id']; ?>" title="Pending"><span class="mdi mdi-receipt-clock-outline"></span></span>

                                                                    
                                                                    <?php
                                                                }
                                                                 elseif($row['status']==2)
                                                                {
                                                                    ?>
                                                                    
                                                                    
                                                                    <span class="span text-success" data-bs-toggle="modal" data-bs-target=""><span class="mdi mdi-check-all"></span></span>
                                                                    <?php
                                                                }
                                                      ?>
                                                
                                             </td>
                                          </tr>
                                            
                                           <div class="modal fade bs-example-modal-lg" id="bd-example-modal-lg-Status-<?php echo $row['id']; ?>" tabindex="<?php echo $row['id']; ?>" role="dialog" aria-labelledby="bd-example-modal-lg-del-<?php echo $row['id']; ?>" aria-hidden="true">
                                                        <div class="modal-dialog modal-md modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header bg-primary">
                                                                    <h4 class="modal-title text-white" id="myLargeModalLabel">Are you sure you want to accept this  </h4>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="">
                                                                        <div class="row">   
                                                                            <form method="post" action="<?php echo site_url('/Request_Reward_Point_history_StatusChange'); ?>">
                                                                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

                                                                                <input type="hidden" name="emp_id" value="<?php echo $emp_id; ?>">
                                                                               
                                                                                <div class="col-sm-12 col-md-12" >
                                                                                    <div class="form-group">
                                                                                        <select name="status" class="form-control" style="padding: 0.875rem 1.375rem"> 
                                                                                            <option value="1"<?php if($row['status']==1) {echo 'selected="selected"';} ?>>Pending</option>
                                                                                            <option value="2" <?php if($row['status']==2) {echo 'selected="selected"';} ?>>Done</option>
                                                                                            <option value="3" <?php if($row['status']==3) {echo 'selected="selected"';} ?>>Reject</option>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-12 col-md-12" >
                                                                                    <div class="form-group">
                                                                                        <input type="text" name="comment" class="form-control" style="padding: 0.875rem 1.375rem" value="<?php echo $row['Comment'];?>"> 
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

                                          <!-- ========================Model For Deleted================================ -->
                                          <div class="modal fade bs-example-modal-lg" id="bd-example-modal-lg-del-<?php echo $row['id']; ?>" tabindex="<?php echo $row['id']; ?>" role="dialog" aria-labelledby="bd-example-modal-lg-del-<?php echo $row['id']; ?>" aria-hidden="true">
                                             <div class="modal-dialog modal-sm modal-dialog-centered">
                                                <div class="modal-content">
                                                   <div class="modal-header bg-danger">
                                                      <h4 class="modal-title text-white" id="myLargeModalLabel">Delete</h4>
                                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                   </div>
                                                   <div class="modal-body">
                                                      <div class="container">
                                                         <!-- ================================== --> 
                                                         <div class="row">
                                                            <div class="col-sm-12 col-md-12">
                                                               <form method="post" action="<?php echo site_url('/del_Request_Reward_Point_history'); ?>">
                                                                  <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                                                  Are You Sure To Delete This Record!<br><br>
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
                                          <?php 
                                             } 
                                             } 
                                             ?>
                                       </tbody>
                                    </table>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>

        
            <?php include('include/footer.php')?>
            <!-- partial -->
         </div>
         <!-- page-body-wrapper ends -->
      </div>
      <!-- container-scroller -->
      <?php include('include/script.php'); ?>
   </body>
</html>