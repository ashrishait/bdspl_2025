<?php 
   use App\Models\StateModel; 
   use App\Models\CityModel;
   use App\Models\PartyUserModel;
   $state = new StateModel();
   $city = new CityModel();
   
   ?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <?php include('include/head.php'); ?>
      <style>
         #suggestionsList {
             list-style: none;
             padding: 0;
             margin: 0;
             position:absolute;
             z-index:1;
         }
 
         #suggestionsList li {
             background-color: #065ca3;
             color:#fff;
             /*width:200px;*/
             padding: 8px;
             margin: 5px;
             border-radius: 5px;
             cursor: pointer;
         }
 
         #suggestionsList li a {
             padding: 10px 100px;
             margin: 5px;
             text-decoration: none;
             color: #fff;
             font-weight:bold;
         }
 
         #suggestionsList li:hover {
             background-color: #ccc;
         }
         #suggestionsList li a:hover {
             color: #000;
         }
     </style>
   </head>
   <body>
      <div class="container-scroller">
         <?php include('include/header.php'); ?>
         <div class="container-fluid page-body-wrapper">
            <div class="main-panel">
               <div class="content-wrapper">
                  
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
                           if(session()->has("emp_up"))
                           {   
                              if(session("emp_up")==1)   
                              {  
                                 echo "<div class='alert alert-success' role='alert'> Form Updation Successful. GSTIN, Phone No, Email can Not be updated </div>";
                              }
                              elseif(session("emp_up")==2)   
                              {  
                                 echo "<div class='alert alert-success' role='alert'> Form Updation Successful.</div>";
                              }
                              else{
                                 echo "<div class='alert alert-danger' role='alert'> Problem in Updation! </div>";
                              }
                           }
                           if(session()->has("pass_ok"))
                           {   
                              if(session("pass_ok")==1)   
                              {  
                                 echo "<div class='alert alert-success' role='alert'> Password Changed </div>";
                              }
                              elseif(session("pass_ok")==2)   
                              {  
                                 echo "<div class='alert alert-success' role='alert'> Form Updation Successful.</div>";
                              }
                              else{
                                 echo "<div class='alert alert-danger' role='alert'> Problem in Updation! </div>";
                              }
                           }
                           ?>    
                     </div>
                     <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="col-md-12 col-sm-12 List p-3">
                                <div class="row">
                                    <div  class="col-md-4">
                                       <h2>View Vendor</h2>
                                    </div>
                                    <div  class="col-md-4">
                                       <form method="post" action="<?php echo base_url('/index.php/barcodeuid');?>">
                                          <input type="text" name="entervendorname" id="searchInput" placeholder="Enter Vendor Name" class="form-control"/>
                                          <ul id="suggestionsList"></ul>
                                       </form>
                                    </div>
                                    <div  class="col-md-4">
                                       <!-- &nbsp; <button type="button" class="btn btn-danger float-end" onclick="exportTableToExcel('myTable', 'table_export')">Export to Excel</button>  -->
                                       <a href="<?php echo base_url('/index.php/export_party_user'); ?>"  class="btn btn-danger float-end" >Excel Export</a>
                                       <a id="rowAdder" type="button" class="btn btn-success float-end" href="<?php echo base_url();?>/index.php/add_party_user">
                                            <span class="bi bi-plus-square-dotted">
                                            </span> Add Vendor
                                        </a>
                                    </div>
                                </div>
                            </div>
                           <div class="card-body cardbody p-1">
                              
                              <div class="table-responsive">
                                 <table class="table table-bordered table-hover" id="myTable">
                                    <thead>
                                       <tr>
                                          <th><b>S.No</b></th>
                                          <th><b>GST No</b></th>
                                          <th><b>Name</b></th>
                                          <th><b>Mobile_No</b></th>
                                          <th><b>Email_Id</b></th>
                                          <th><b>Action</b></th>
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
                                          <td><?php echo $row['GST_No']; ?></td>
                                          <td><?php echo $row['Name']; ?></td>
                                          <td><?php echo $row['Mobile_No']; ?></td>
                                          <td><?php echo $row['Email_Id']; ?></td>
                                          <td>
                                            <?php
                                                if($Roll_id==0)
                                                {
                                                    ?>
                                                    <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#bd-example-modal-lg-del-<?php echo $row['id']; ?>" title="Delete Vendor"><span class="mdi mdi-trash-can-outline"></span></button>
                                                    <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#bd-example-modal-lg-edit<?php echo $row['id']; ?>" title="Edit Vendor"><span class="mdi mdi-pen"></span></button>
                                                    <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#passwordchange<?php echo $row['id']; ?>"><span class="mdi mdi-lock-check"></span></button>
                                                    <?php
                                                    $todaydate=Date('Y-m-d');
                                                    if($row['Active']==1){
                                                        if($row['Expiry_Date'] < $todaydate){ ?>
                                                            <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#activatevendor<?php echo $row['id']; ?>" title="Activate Vendor"><span class="mdi mdi-power-cycle"></span></button>
                                                        <?php }
                                                        else{ ?>
                                                            <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#deactivatevendor<?php echo $row['id']; ?>" title="Deactivate Vendor"><span class="mdi mdi-power-standby"></span></button>
                                                        <?php }
                                                    }
                                                    else{ ?>
                                                        <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#activatevendor<?php echo $row['id']; ?>" title="Activate Vendor"><span class="mdi mdi-power-cycle"></span></button>
                                                    <?php } ?>
                                                    <?php
                                                }
                                                else
                                                {
                                                    ?>
                                                    <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#bd-example-modal-lg-View<?php echo $row['id']; ?>"><i class="fa fa-edit"></i>View</button>
                                                    <?php
                                                }
                                                ?>
                                          </td>
                                       </tr>
                                       <!-- ========================Model For View Start================================ -->
                                       <div class="modal fade bs-example-modal-lg" id="bd-example-modal-lg-View<?php echo $row['id']; ?>" tabindex="<?php echo $row['id']; ?>" role="dialog" aria-labelledby="bd-example-modal-lg-edit<?php echo $row['id']; ?>" aria-hidden="true">
                                          <div class="modal-dialog modal-lg modal-dialog-centered">
                                             <div class="modal-content">
                                                <div class="modal-header bg-info">
                                                   <h4 class="modal-title text-white" id="myLargeModalLabel">View Details</h4>
                                                   <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                   <form method="post" action="" enctype="multipart/form-data">
                                                      <div class="container">
                                                         <input  type="hidden" name="id" value="<?php echo $row['id']; ?>" >
                                                         <div class="row">
                                                            <div class="col-sm-6">
                                                               <div class="form-group">
                                                                  <label> GST No</label>
                                                                  <input class="form-control" type="text" name="GST_No" value="<?php echo $row['GST_No']; ?>" style="padding: 0.475rem 1.375rem" required>
                                                               </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                               <div class="form-group">
                                                                  <label> Name</label>
                                                                  <input class="form-control" type="text" name="Name" value="<?php echo $row['Name']; ?>" style="padding: 0.475rem 1.375rem">
                                                               </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                               <div class="form-group">
                                                                  <label> Mobile_No</label>
                                                                  <input class="form-control" type="text" name="Mobile_No" value="<?php echo $row['Mobile_No']; ?>" style="padding: 0.475rem 1.375rem" readonly>
                                                               </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                               <div class="form-group">
                                                                  <label> Email_Id</label>
                                                                  <input class="form-control" type="text" name="Email_Id" value="<?php echo $row['Email_Id']; ?>" style="padding: 0.475rem 1.375rem" readonly>
                                                               </div>
                                                            </div>
                                                         </div>
                                                         <div class="row">
                                                            <div class="col-sm-12 col-md-12">
                                                               <div class="form-group">
                                                                  <label>Current Address <span style="color:red;">*</span></label>
                                                                  <textarea name="Address" class="form-control" style="height:100px!important;" id="ca" required><?php echo $row['current_address']; ?></textarea>
                                                               </div>
                                                            </div>
                                                         </div>
                                                         <div class="row">
                                                            <div class="col-sm-12 col-md-4">
                                                               <div class="form-group">
                                                                  <label>State <span style="color:red;">*</span></label>
                                                                  <select name="C_State" class="form-control" id="cs" required>
                                                                     <option value="">-Select State-</option>
                                                                     <?php foreach ($dax6 as $roxi){ ?>
                                                                     <option value="<?php echo $roxi['id']; ?>" <?php if($row['current_state']==$roxi['id']) {echo 'selected="selected"';} ?>><?php echo ucwords($roxi['state_name']); ?></option>
                                                                     <?php } ?>    
                                                                  </select>
                                                               </div>
                                                            </div>
                                                            <div class="col-sm-12 col-md-4">
                                                               <div class="form-group">
                                                                  <label>City <span style="color:red;">*</span></label>
                                                                  <select name="C_City" class="form-control" id="cc" required>
                                                                     <option value="">-Select City-</option>
                                                                     <?php foreach ($dax1 as $roni){ ?>
                                                                     <option value="<?php echo $roni['id']; ?>" <?php if($row['current_city']==$roni['id']) {echo 'selected="selected"';} ?>><?php echo ucwords($roni['city_name']); ?></option>
                                                                     <?php } ?>    
                                                                  </select>
                                                               </div>
                                                            </div>
                                                            <div class="col-sm-12 col-md-4">
                                                               <div class="form-group">
                                                                  <label>Pin Code <span style="color:red;">*</span></label>
                                                                  <input class="form-control"  type="number" name="C_Pincode" value="<?php echo $row['current_pincode']; ?>" id="cp" required>
                                                               </div>
                                                            </div>
                                                         </div>
                                                         <div class="row">
                                                            <div class="col-sm-12 col-md-12">
                                                               <div class="form-group">
                                                                  <label><input type="checkbox" name="same" id="good" onclick="hello();" /> Permanent Address ( If Same as Current Address Then Tick the Checkbox. ) <span style="color:red;">*</span></label>
                                                                  <textarea name="PAddress" class="form-control" style="height:100px!important;" id="pa" required><?php echo $row['permanent_address']; ?></textarea>
                                                               </div>
                                                            </div>
                                                         </div>
                                                         <div class="row">
                                                            <div class="col-sm-12 col-md-4">
                                                               <div class="form-group">
                                                                  <label>State <span style="color:red;">*</span></label>
                                                                  <select name="PState" class="form-control" id="ps" required>
                                                                     <option value="">-Select State-</option>
                                                                     <?php foreach ($dax6 as $roxi){ ?>
                                                                     <option value="<?php echo $roxi['id']; ?>" <?php if($row['permanent_state']==$roxi['id']) {echo 'selected="selected"';} ?>><?php echo ucwords($roxi['state_name']); ?></option>
                                                                     <?php } ?>   
                                                                  </select>
                                                               </div>
                                                            </div>
                                                            <div class="col-sm-12 col-md-4">
                                                               <div class="form-group">
                                                                  <label>City <span style="color:red;">*</span></label>
                                                                  <select name="PCity" class="form-control" id="pc" required>
                                                                     <option value="">-Select City-</option>
                                                                     <?php foreach ($dax1 as $roni){ ?>
                                                                     <option value="<?php echo $roni['id']; ?>" <?php if($row['permanent_city']==$roni['id']) {echo 'selected="selected"';} ?>><?php echo ucwords($roni['city_name']); ?></option>
                                                                     <?php } ?>         
                                                                  </select>
                                                               </div>
                                                            </div>
                                                            <div class="col-sm-12 col-md-4">
                                                               <div class="form-group">
                                                                  <label>Pin Code <span style="color:red;">*</span></label>
                                                                  <input class="form-control" type="number" name="PPincode" value="<?php echo $row['permanent_pincode']; ?>" id="pp" required>
                                                               </div>
                                                            </div>
                                                         </div>
                                                      </div>
                                                </div>
                                                <div class="modal-footer">
                                                </form>
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                       <!-- ========================Model For edit Start================================ -->
                                       <div class="modal fade bs-example-modal-lg" id="bd-example-modal-lg-edit<?php echo $row['id']; ?>" tabindex="<?php echo $row['id']; ?>" role="dialog" aria-labelledby="bd-example-modal-lg-edit<?php echo $row['id']; ?>" aria-hidden="true">
                                          <div class="modal-dialog modal-lg modal-dialog-centered">
                                             <div class="modal-content">
                                                <div class="modal-header bg-primary">
                                                   <h4 class="modal-title text-white" id="myLargeModalLabel">Edit Details</h4>
                                                   <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                   <form method="post" action="<?php echo site_url('/update_party_user'); ?>" enctype="multipart/form-data">
                                                      <div class="container">
                                                         <input  type="hidden" name="id" value="<?php echo $row['id']; ?>" >
                                                         <div class="row">
                                                            <div class="col-sm-6">
                                                               <div class="form-group">
                                                                  <label> GST No</label>
                                                                  <input class="form-control" type="text" name="GST_No" value="<?php echo $row['GST_No']; ?>" style="padding: 0.475rem 1.375rem" required readonly>
                                                               </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                               <div class="form-group">
                                                                  <label> Name</label>
                                                                  <input class="form-control" type="text" name="Name" value="<?php echo $row['Name']; ?>" style="padding: 0.475rem 1.375rem">
                                                               </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                               <div class="form-group">
                                                                  <label> Mobile_No</label>
                                                                  <input class="form-control" type="text" name="Mobile_No" value="<?php echo $row['Mobile_No']; ?>" style="padding: 0.475rem 1.375rem" readonly>
                                                               </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                               <div class="form-group">
                                                                  <label> Email_Id</label>
                                                                  <input class="form-control" type="text" name="Email_Id" value="<?php echo $row['Email_Id']; ?>" style="padding: 0.475rem 1.375rem" readonly>
                                                               </div>
                                                            </div>
                                                         </div>
                                                         <div class="row">
                                                            <div class="col-sm-12 col-md-12">
                                                               <div class="form-group">
                                                                  <label>Current Address <span style="color:red;">*</span></label>
                                                                  <textarea name="Address" class="form-control" style="height:100px!important;" id="ca" required><?php echo $row['current_address']; ?></textarea>
                                                               </div>
                                                            </div>
                                                         </div>
                                                         <div class="row">
                                                            <div class="col-sm-12 col-md-4">
                                                               <div class="form-group">
                                                                  <label>State <span style="color:red;">*</span></label>
                                                                  <select name="C_State" class="form-control" id="cs" required>
                                                                     <option value="">-Select State-</option>
                                                                     <?php foreach ($dax6 as $roxi){ ?>
                                                                     <option value="<?php echo $roxi['id']; ?>" <?php if($row['current_state']==$roxi['id']) {echo 'selected="selected"';} ?>><?php echo ucwords($roxi['state_name']); ?></option>
                                                                     <?php } ?>    
                                                                  </select>
                                                               </div>
                                                            </div>
                                                            <div class="col-sm-12 col-md-4">
                                                               <div class="form-group">
                                                                  <label>City <span style="color:red;">*</span></label>
                                                                  <select name="C_City" class="form-control" id="cc" required>
                                                                     <option value="">-Select City-</option>
                                                                     <?php foreach ($dax1 as $roni){ ?>
                                                                     <option value="<?php echo $roni['id']; ?>" <?php if($row['current_city']==$roni['id']) {echo 'selected="selected"';} ?>><?php echo ucwords($roni['city_name']); ?></option>
                                                                     <?php } ?>    
                                                                  </select>
                                                               </div>
                                                            </div>
                                                            <div class="col-sm-12 col-md-4">
                                                               <div class="form-group">
                                                                  <label>Pin Code <span style="color:red;">*</span></label>
                                                                  <input class="form-control"  type="number" name="C_Pincode" value="<?php echo $row['current_pincode']; ?>" id="cp" required>
                                                               </div>
                                                            </div>
                                                         </div>
                                                         <div class="row">
                                                            <div class="col-sm-12 col-md-12">
                                                               <div class="form-group">
                                                                  <label><input type="checkbox" name="same" id="good" onclick="hello();" /> Permanent Address ( If Same as Current Address Then Tick the Checkbox. ) <span style="color:red;">*</span></label>
                                                                  <textarea name="PAddress" class="form-control" style="height:100px!important;" id="pa" required><?php echo $row['permanent_address']; ?></textarea>
                                                               </div>
                                                            </div>
                                                         </div>
                                                         <div class="row">
                                                            <div class="col-sm-12 col-md-4">
                                                               <div class="form-group">
                                                                  <label>State <span style="color:red;">*</span></label>
                                                                  <select name="PState" class="form-control" id="ps" required>
                                                                     <option value="">-Select State-</option>
                                                                     <?php foreach ($dax6 as $roxi){ ?>
                                                                     <option value="<?php echo $roxi['id']; ?>" <?php if($row['permanent_state']==$roxi['id']) {echo 'selected="selected"';} ?>><?php echo ucwords($roxi['state_name']); ?></option>
                                                                     <?php } ?>   
                                                                  </select>
                                                               </div>
                                                            </div>
                                                            <div class="col-sm-12 col-md-4">
                                                               <div class="form-group">
                                                                  <label>City <span style="color:red;">*</span></label>
                                                                  <select name="PCity" class="form-control" id="pc" required>
                                                                     <option value="">-Select City-</option>
                                                                     <?php foreach ($dax1 as $roni){ ?>
                                                                     <option value="<?php echo $roni['id']; ?>" <?php if($row['permanent_city']==$roni['id']) {echo 'selected="selected"';} ?>><?php echo ucwords($roni['city_name']); ?></option>
                                                                     <?php } ?>         
                                                                  </select>
                                                               </div>
                                                            </div>
                                                            <div class="col-sm-12 col-md-4">
                                                               <div class="form-group">
                                                                  <label>Pin Code <span style="color:red;">*</span></label>
                                                                  <input class="form-control" type="number" name="PPincode" value="<?php echo $row['permanent_pincode']; ?>" id="pp" required>
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
                                                <div class="modal-header bg-warning">
                                                   <h4 class="modal-title" id="myLargeModalLabel">Delete</h4>
                                                   <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                   <div class="container">
                                                      <!-- ================================== --> 
                                                      <div class="row">
                                                         <div class="col-sm-12 col-md-12">
                                                            <form method="post" action="<?php echo site_url('/del_party_user'); ?>">
                                                               <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                                               Are You Sure To Delete This Record!<br>
                                                               <button type="submit" class="btn btn-warning">Delete</button>
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
                                       
                                       <div class="modal activatevendor" id="activatevendor<?php echo $row['id']; ?>" tabindex="<?php echo $row['id']; ?>" role="dialog" aria-labelledby="activatevendor<?php echo $row['id']; ?>" aria-hidden="true">
                                          <div class="modal-dialog modal-sm modal-dialog-centered">
                                             <div class="modal-content">
                                                <div class="modal-header bg-success">
                                                   <h4 class="modal-title" id="myLargeModalLabel">Activate</h4>
                                                   <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                   <div>
                                                      <!-- ================================== --> 
                                                      <div class="row">
                                                         <div class="col-sm-12 col-md-12">
                                                            <form method="post" action="<?php echo site_url('/activate-vendor-by-admin'); ?>">
                                                                Are You Sure To Activate This Record!<br>
                                                               <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                                               <input type="date" name="expirydate" class="form-control">
                                                               
                                                               <button type="submit" class="btn btn-success">Activate</button>
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
                                       <div class="modal deactivatevendor" id="deactivatevendor<?php echo $row['id']; ?>" tabindex="<?php echo $row['id']; ?>" role="dialog" aria-labelledby="deactivatevendor<?php echo $row['id']; ?>" aria-hidden="true">
                                          <div class="modal-dialog modal-sm modal-dialog-centered">
                                             <div class="modal-content">
                                                <div class="modal-header bg-grey">
                                                   <h4 class="modal-title" id="myLargeModalLabel">Dectivate</h4>
                                                   <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                   <div>
                                                      <!-- ================================== --> 
                                                      <div class="row">
                                                         <div class="col-sm-12 col-md-12">
                                                            <form method="post" action="<?php echo site_url('/deactivate-vendor-by-admin'); ?>">
                                                               <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                                               
                                                               Are You Sure To Deactivate This Record!<br>
                                                               <button type="submit" class="btn btn-grey">Deactivate</button>
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
                                       <div class="modal passwordchange" id="passwordchange<?php echo $row['id']; ?>" tabindex="<?php echo $row['id']; ?>" role="dialog" aria-labelledby="passwordchange<?php echo $row['id']; ?>" aria-hidden="true">
                                          <div class="modal-dialog modal-sm modal-dialog-centered">
                                             <div class="modal-content">
                                                <div class="modal-header bg-danger">
                                                   <h4 class="modal-title text-white" id="myLargeModalLabel">Reset Password</h4>
                                                   <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                   <div class="row">
                                                      <!-- ================================== --> 
                                                      <div>
                                                         <div class="col-sm-12 col-md-12">
                                                            <form method="post" action="<?php echo site_url('/vendor-password-change-by-admin'); ?>">
                                                                Are You Sure you want to change the password!<br>
                                                               <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                                               <input type="Password" name="vpassword" class="form-control">
                                                               
                                                               <button type="submit" class="btn btn-danger mt-3">Change Password</button>
                                                               <button type="button" class="btn btn-secondary mt-3" data-bs-dismiss="modal">Close</button>
                                                            </form>
                                                         </div>
                                                      </div>
                                                      <!-- =========================== -->
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>             							    
                                       <?php 
                                       } 
                                       } 
                                       ?>
                                    </tbody>
                                 </table>
                              </div>
                              <div>
                                 <hr>
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
         </div>
         <?php include('include/footer.php')?>
      </div>
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
                     url:"<?php echo base_url('/index.php/getsamecityx')?>",  
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
                    url:"<?php echo base_url('/index.php/getcityx')?>",
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
                    url:"<?php echo base_url('/index.php/getcityx')?>",
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
      <script>
         $(document).ready(function () {
             // Event listener for input changes
             $('#searchInput').on('input', function () {
                 var query = $(this).val();
                 //var companyid = $('#companyid').val();
                 //alert(companyid);
                 // AJAX request to get suggestions
                 $.ajax({
                     url: '<?php echo base_url('/index.php/vedorsuggestion'); ?>',
                     method: 'GET',
                     data: { query: query},
                     dataType: 'json',
                     success: function (data) {
                         displaySuggestions(data);
                     }
                 });
             });
 
             // Function to display suggestions
             function displaySuggestions(suggestions) {
                 var suggestionsList = $('#suggestionsList');
                 suggestionsList.empty();
 
                 $.each(suggestions, function (index, item) {
                     var listItem = $('<li><a href="<?php echo base_url('/index.php/view_party_user'); ?>?GST_No=' + item.GST_No + '">' + item.Name + '</a></li>');
                     suggestionsList.append(listItem);
                 });
             }
         });
      </script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>

        <script>

            function exportTableToExcel(tableId, filename = 'export') {

                var tableSelect = document.getElementById(tableId);

        

                // Create a new worksheet

                var ws = XLSX.utils.aoa_to_sheet([[]]);

        

                // Add data from the table, excluding the second row

                for (var i = 0; i < tableSelect.rows.length; i++) {

                    if (i !== 1) {

                        var rowData = [];

                        for (var j = 0; j < tableSelect.rows[i].cells.length; j++) {

                            rowData.push(tableSelect.rows[i].cells[j].innerText);

                        }

                        XLSX.utils.sheet_add_aoa(ws, [rowData], { origin: -1, skipHeader: true });

                    }

                }

        

                // Create a workbook and add the worksheet

                var wb = XLSX.utils.book_new();

                XLSX.utils.book_append_sheet(wb, ws, 'Sheet1');

        

                // Save the workbook as an Excel file

                XLSX.writeFile(wb, filename + '.xlsx');

            }

        </script>
   </body>
</html>