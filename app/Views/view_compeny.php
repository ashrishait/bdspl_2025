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
         <?php 
         include('include/header.php');
         if($Roll_id=='0')
         {  } 
         else{
            ?>
            <script type="text/javascript">
               alert("Page Not Access"); 
               window.location.href="<?php echo base_url("/index.php/"); ?>"
            </script>
            <?php 
         }
         ?>
         <div class="container-fluid">
            <div>
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
                                  elseif(session("data_delete")==2)   
                                  {  
                                      echo "<div class='alert alert-danger' role='alert'> Compeny This Used. </div>";
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
                              ?>    
                        </div>
                        <div class="col-lg-12">
                           <div class="col-md-12 col-sm-12 List p-3">
                                <div class="row">
                                    <div class="col-6">
                                       <h2>View  Company</h2>
                                    </div>
                                    <div class="col-6">
                                       <button class="btn btn-success btn-sm float-end" data-bs-toggle="modal" data-bs-target="#bd-example-modal-lg-Add"><i class="fa fa-edit"></i> Add New Company</button>
                                    </div>
                                </div>
                           </div>
                           <div class="card">
                              <div class="card-body p-1">
                                 <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                       <thead>
                                          <tr>
                                             <th><b>S.No</b></th>
                                             <th><b>Name</b></th>
                                             <th><b>Email</b></th>
                                             <th><b>Contact</b></th>
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
                                             <td><?php echo $row['name']; ?></td>
                                             <td><?php echo $row['email']; ?></td>
                                             <td><?php echo $row['contact_no']; ?></td>
                                             <td>
                                                <span style="color:blue" class="span" data-bs-toggle="modal" data-bs-target="#bd-example-modal-lg-edit<?php echo $row['id']; ?>"><span class="mdi mdi-pen"></span></span>
                                                <span style="color:red" class="span" data-bs-toggle="modal" data-bs-target="#bd-example-modal-lg-del-<?php echo $row['id']; ?>"><span class="mdi mdi-trash-can-outline"></span></span>
                                                <a style="color:green" class="span" href="view-reward-company-wise/<?php echo $row['id']; ?>"><span class="mdi mdi-seal-variant"></span></a>
                                             </td>
                                          </tr>
                                          <!-- ========================Model For edit Start================================ -->
                                          <div class="modal fade bs-example-modal-lg" id="bd-example-modal-lg-edit<?php echo $row['id']; ?>" tabindex="<?php echo $row['id']; ?>" role="dialog" aria-labelledby="bd-example-modal-lg-edit<?php echo $row['id']; ?>" aria-hidden="true">
                                             <div class="modal-dialog modal-lg modal-dialog-centered">
                                                <div class="modal-content">
                                                   <div class="modal-header bg-primary">
                                                      <h4 class="modal-title text-white" id="myLargeModalLabel">Edit Company Details</h4>
                                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                   </div>
                                                   <div class="modal-body">
                                                      <form method="post" action="<?php echo site_url('/update_compeny'); ?>" enctype="multipart/form-data">
                                                            <input  type="hidden" name="id" value="<?php echo $row['id']; ?>" >
                                                            <div class="row">
                                                               <div class="col-sm-6">
                                                                  <div class="form-group">
                                                                     <label>Name</label>
                                                                     <input class="form-control" type="text" name="name" value="<?php echo $row['name']; ?>" style="padding: 0.475rem 1.375rem">
                                                                  </div>
                                                               </div>
                                                               <div class="col-sm-6">
                                                                  <div class="form-group">
                                                                     <label>Email</label>
                                                                     <input class="form-control" type="text" name="email" value="<?php echo $row['email']; ?>" style="padding: 0.475rem 1.375rem">
                                                                  </div>
                                                               </div>
                                                               <div class="col-sm-6">
                                                                  <div class="form-group">
                                                                     <label>Contact</label>
                                                                     <input class="form-control" type="text" name="contact_no" value="<?php echo $row['contact_no']; ?>" style="padding: 0.475rem 1.375rem">
                                                                  </div>
                                                               </div>
                                                            </div>
                                                            <button type="submit" class="btn btn-primary btn-lg" >Submit</button>
                                                            <button type="button" class="btn btn-secondary btn-lg" data-bs-dismiss="modal">Close</button>
                                                      </form>
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
                                                      <h4 class="modal-title text-white" id="myLargeModalLabel">Delete Company</h4>
                                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                   </div>
                                                   <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-sm-12 col-md-12">
                                                               <form method="post" action="<?php echo site_url('/del_compeny'); ?>">
                                                                  <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                                                  <h4 class="mb-4">Are You Sure To Delete This Record!</h4>
                                                                  <button type="submit" class="btn btn-danger btn-lg">Delete</button>
                                                                  <button type="button" class="btn btn-secondary btn-lg" data-bs-dismiss="modal">Close</button>
                                                               </form>
                                                            </div>
                                                         </div>
                                                         <!-- =========================== -->
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
                     <h4 class="modal-title text-white" id="myLargeModalLabel">Add Compeny Details</h4>
                     <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                     <form method="post" action="<?php echo site_url('/add_compeny'); ?>" enctype="multipart/form-data">
                        <div class="container">
                           <div class="row">
                              <div class="col-sm-6">
                                 <div class="form-group">
                                    <label>   Name</label>
                                    <input class="form-control" type="text" name="namee"  style="padding: 0.475rem 1.375rem">
                                 </div>
                              </div>
                              <div class="col-sm-6">
                                 <div class="form-group">
                                    <label>    Email</label>
                                    <input class="form-control" type="text" name="email"  style="padding: 0.475rem 1.375rem">
                                 </div>
                              </div>
                              <div class="col-sm-6">
                                 <div class="form-group">
                                    <label>    Contact No </label>
                                    <input class="form-control" type="text" name="contact_no"  style="padding: 0.475rem 1.375rem">
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="modal-footer">
                           <button type="submit" class="btn btn-success btn-lg">Submit</button>
                     </form>
                     <button type="button" class="btn btn-secondary btn-lg" data-bs-dismiss="modal">Close</button>
                     </div>
                  </div>
               </div>
            </div>
            <!-- ========================Model For Add End================================ -->
            <!-- partial -->
         </div>
         <!-- page-body-wrapper ends -->
         <?php include('include/footer.php')?>
      </div>
      <!-- container-scroller -->
      <?php include('include/script.php'); ?>
   </body>
</html>