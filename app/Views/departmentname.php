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
                                 echo "<div class='alert alert-success' role='alert'>Record Deleted Successfully. </div>";
                              }
                              else{
                                 echo "<div class='alert alert-danger' role='alert'>Data Not Deleted </div>";   
                              }
                           }
                           if(session()->has("emp_ok"))
                           {   
                              if(session("emp_ok")==1)   
                              {  
                                 echo "<div class='alert alert-success' role='alert'> Department Added. </div>";
                              }
                              else{
                                 echo "<div class='alert alert-danger' role='alert'> Problem in Submition! </div>";
                              }
                           }
                           if(session()->has("data_up"))
                           {       
                              if(session("data_up")==1)   
                              {  
                                 echo "<div class='alert alert-success' role='alert'> Department Updated. </div>";
                              }
                              else  
                              {  
                                 echo "<div class='alert alert-danger' role='alert'> Department Not Updated.</div>";
                              }
                           }
                           ?>    
                        </div>
                        <div class="col-lg-12">
                            <div class="col-md-12 col-sm-12 List p-3">
                                <div class="row">
                                    <div class="col-6">
                                       <h2>Department Name</h2>
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
                                             <th><b>DepartmentName</b></th>
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
                                             <td><?php echo $row['Department_Name']; ?></td>
                                             <td>
                                                <span class="span text-primary" data-bs-toggle="modal" data-bs-target="#bd-example-modal-lg-edit<?php echo $row['Id']; ?>"><span class="mdi mdi-pen"></span></span>
                                                <span class="span text-danger" data-bs-toggle="modal" data-bs-target="#bd-example-modal-lg-del-<?php echo $row['Id']; ?>"><span class="mdi mdi-trash-can-outline"></span></span>
                                             </td>
                                          </tr>
                                          <!-- ========================Model For edit Start================================ -->
                                          <div class="modal fade bs-example-modal-lg" id="bd-example-modal-lg-edit<?php echo $row['Id']; ?>" tabindex="<?php echo $row['Id']; ?>" role="dialog" aria-labelledby="bd-example-modal-lg-edit<?php echo $row['Id']; ?>" aria-hidden="true">
                                             <div class="modal-dialog modal-lg modal-dialog-centered">
                                                <div class="modal-content">
                                                   <div class="modal-header bg-primary">
                                                      <h4 class="modal-title text-white" id="myLargeModalLabel">Edit Details</h4>
                                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                   </div>
                                                   <div class="modal-body">
                                                      <form method="post" action="<?php echo site_url('/update-department-name'); ?>" enctype="multipart/form-data">
                                                         <div class="container">
                                                            <input  type="hidden" name="id" value="<?php echo $row['Id']; ?>" >
                                                            <div class="row">
                                                               <div class="col-sm-12">
                                                                  <div class="form-group">
                                                                     <label>Name</label>
                                                                     <input class="form-control" type="text" name="name" value="<?php echo $row['Department_Name']; ?>">
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
                                          <div class="modal fade bs-example-modal-lg" id="bd-example-modal-lg-del-<?php echo $row['Id']; ?>" tabindex="<?php echo $row['Id']; ?>" role="dialog" aria-labelledby="bd-example-modal-lg-del-<?php echo $row['Id']; ?>" aria-hidden="true">
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
                                                               <form method="post" action="<?php echo site_url('/del-department-name'); ?>">
                                                                  <input type="hidden" name="id" value="<?php echo $row['Id']; ?>">
                                                                  Are You Sure To Delete This Record!<br><br/>
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
                     <form method="post" action="<?php echo site_url('/add-department-name'); ?>" enctype="multipart/form-data">
                        <input type="hidden" name="compeny_id" value="<?php echo $compeny_id ?>">
                        <div class="container">
                           <div class="row">
                              <div class="col-sm-12">
                                 <div class="form-group">
                                    <label>Department Name</label>
                                    <input class="form-control" type="text" name="depname">
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="modal-footer">
                           <button type="submit" class="btn btn-success">Submit</button>
                           <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>   
                     </form>
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