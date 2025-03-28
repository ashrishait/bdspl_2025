<?php 
   use App\Models\UnitModel; 
   
   
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
                        <div class="py-0" style="background:none;">
                          <div class="container-fluid">
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
                  <div class="container-fluid">
                     <div class="row">
                        <div class="col-md-12 col-sm-12"> 
                           <?php
                              if(session()->has("data_delete"))
                              {   
                                  if(session("data_delete")==1)   
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
                              
                              if(session()->has("data_up"))
                              {       
                                  if(session("data_up")==1)   
                                  {  
                              echo "<div class='alert alert-success' role='alert'> Form Updation Successful. </div>";
                                  }
                                  else  
                                  {  
                              echo "<div class='alert alert-danger' role='alert'> Form Not Updation Successful.</div>";
                                  }
                              }
                              
                              if(session()->has("no_of_action"))
                              {       
                                  if(session("no_of_action")==1)   
                                  {  
                                      echo "<div class='alert alert-danger' role='alert'> This Stage Allready Exits No Of Action </div>";
                                  }
                                
                              }
                              ?>    
                        </div>
                        <div class="col-lg-12">
                            <div class="col-md-12 col-sm-12 List p-3">
                                <div class="row">
                                    <div class="col-6">
                                       <h2>View Action</h2>
                                    </div>
                                    <div class="col-6">
                                        <button class="btn btn-success btn-sm float-end" data-bs-toggle="modal" data-bs-target="#bd-example-modal-lg-Add"><i class="fa fa-edit"></i> New Add</button>
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
                                             <th><b> Stage</b></th>
                                             <th><b>No of Action </b></th>
                                             <th><b>Action Name</b></th>
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
                                             <td><?php echo $i; ?></td>
                                             <td>Stage <?php echo $row['stage_id']; ?></td>
                                             <td> <?php echo $row['no_of_action']; ?></td>
                                             <td><?php echo $row['action_name']; ?></td>
                                             <td>
                                                <span class="span text-primary" data-bs-toggle="modal" data-bs-target="#bd-example-modal-lg-edit<?php echo $row['id']; ?>"><span class="mdi mdi-pen"></span></span>
                                                <span class="span text-danger" data-bs-toggle="modal" data-bs-target="#bd-example-modal-lg-del-<?php echo $row['id']; ?>"><span class="mdi mdi-trash-can-outline"></span></span>
                                             </td>
                                          </tr>
                                          <!-- ========================Model For edit Start================================ -->
                                          <div class="modal fade bs-example-modal-lg" id="bd-example-modal-lg-edit<?php echo $row['id']; ?>" tabindex="<?php echo $row['id']; ?>" role="dialog" aria-labelledby="bd-example-modal-lg-edit<?php echo $row['id']; ?>" aria-hidden="true">
                                             <div class="modal-dialog modal-lg modal-dialog-centered">
                                                <div class="modal-content">
                                                   <div class="modal-header bg-primary">
                                                      <h4 class="modal-title text-white" id="myLargeModalLabel">Edit Details</h4>
                                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                   </div>
                                                   <div class="modal-body">
                                                      <form method="post" action="<?php echo site_url('/update_master_action'); ?>" enctype="multipart/form-data">
                                                         <div class="container">
                                                            <input  type="hidden" name="id" value="<?php echo $row['id']; ?>" >
                                                            <div class="row">
                                                               <div class="col-sm-12 col-md-6">
                                                                  <div class="form-group">
                                                                     <label>Stage <span style="color:red;">*</span></label>
                                                                     <select name="stage_id" class="form-control" style="padding: 0.875rem 1.375rem" required >
                                                                        <option value="">-Select -</option>
                                                                        <option value="1" <?php if($row['stage_id']=='1') {echo 'selected="selected"';} ?>>Stage 1</option>
                                                                        <option value="2" <?php if($row['stage_id']=='2') {echo 'selected="selected"';} ?>>Stage 2</option>
                                                                        <option value="3" <?php if($row['stage_id']=='3') {echo 'selected="selected"';} ?>>Stage 3</option>
                                                                        <option value="4"<?php if($row['stage_id']=='4') {echo 'selected="selected"';} ?>>Stage 4</option>
                                                                        <option value="5"<?php if($row['stage_id']=='5') {echo 'selected="selected"';} ?>>Stage 5</option>
                                                                     </select>
                                                                  </div>
                                                               </div>
                                                               <div class="col-sm-6">
                                                                  <div class="form-group">
                                                                     <label>  Action Name</label>
                                                                     <input class="form-control" type="text" name="action_name"  style="padding: 0.875rem 1.375rem" value="<?php echo $row['action_name']; ?>">
                                                                  </div>
                                                               </div>
                                                               <div class="col-sm-6">
                                                                  <div class="form-group">
                                                                     <label>No Of  Action </label>
                                                                     <input class="form-control" type="number" name="no_of_action"  style="padding: 0.475rem 1.375rem" value="<?php echo $row['no_of_action']; ?>">
                                                                  </div>
                                                               </div>
                                                            </div>
                                                         </div>
                                                   </div>
                                                   <div class="modal-footer">
                                                   <button type="submit" class="btn btn-primary" >submit</button>
                                                   </form>
                                                   <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                          <!-- ========================Model For edit End================================ -->                                                              
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
                                                               <form method="post" action="<?php echo site_url('/del_master_action'); ?>">
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
         <!-- ========================Model For Add Start================================ -->
         <div class="modal fade bs-example-modal-lg" id="bd-example-modal-lg-Add" tabindex="" role="dialog" aria-labelledby="bd-example-modal-lg-Add" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
               <div class="modal-content">
                  <div class="modal-header bg-success">
                     <h4 class="modal-title text-white" id="myLargeModalLabel">Add Details</h4>
                     <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                     <form method="post" action="<?php echo site_url('/add_master_action'); ?>" enctype="multipart/form-data">
                        <input  type="hidden" name="compeny_id" value="<?php echo $compeny_id; ?>" >
                        <div class="container">
                           <div class="row">
                              <div class="col-sm-12 col-md-6">
                                 <div class="form-group">
                                    <label>Stage <span style="color:red;">*</span></label>
                                    <select name="stage_id" class="form-control" style="padding: 0.875rem 1.375rem" required >
                                       <option value="">-Select -</option>
                                       <option value="1">Stage 1</option>
                                       <option value="2">Stage 2</option>
                                       <option value="3">Stage 3</option>
                                       <option value="4">Stage 4</option>
                                       <option value="5">Stage 5</option>
                                    </select>
                                 </div>
                              </div>
                              <div class="col-sm-6">
                                 <div class="form-group">
                                    <label>  Action Name</label>
                                    <input class="form-control" type="text" name="action_name"  style="padding: 0.475rem 1.375rem">
                                 </div>
                              </div>
                              <div class="col-sm-6">
                                 <div class="form-group">
                                    <label>No Of  Action </label>
                                    <input class="form-control" type="number" name="no_of_action"  style="padding: 0.475rem 1.375rem">
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="modal-footer">
                           <button type="submit" class="btn btn-success" >submit</button>
                     </form>
                     <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                     </div>
                  </div>
               </div>
            </div>
            <!-- ========================Model For Add End================================ -->
            <?php include('include/footer.php')?>
            <!-- partial -->
         </div>
         <!-- page-body-wrapper ends -->
      </div>
      <!-- container-scroller -->
      <?php include('include/script.php'); ?>
   </body>
</html>