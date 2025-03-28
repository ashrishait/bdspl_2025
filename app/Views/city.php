<?php 
   use App\Models\StateModel; 
   use App\Models\CityModel;
   use App\Models\PartyUserModel;
   use App\Models\RollModel;
   $state = new StateModel();
   $city = new CityModel();
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
         <div class="container-fluid page-body-wrapper">
            <div class="main-panel">
               <div class="content-wrapper">
                  <div class="row">
                     <div class="container">
                        <div class="col-md-12 col-sm-12"> 
                           <?php
                              if(session()->has("city_ok"))
                              {   
                                 if(session("city_ok")==1)   
                                 {  
                                    echo "<div class='alert alert-success' role='alert'> City name added Successful. </div>";
                                 }
                                 else{
                                    echo "<div class='alert alert-danger' role='alert'> Problem in Submition! </div>";
                                 }
                              }
                              if(session()->has("city_up"))
                              {   
                                 if(session("city_up")==1)   
                                 {  
                                    echo "<div class='alert alert-success' role='alert'> City details updated Successful. </div>";
                                 }else{
                                    echo "<div class='alert alert-danger' role='alert'> Problem in updation! </div>";
                                 }
                              } 
                           ?> 
                        </div>
                     </div>
                     <div class="col-lg-12">
                        <div class="col-md-12 col-sm-12 List p-3">
                            <div class="row">
                                <div class="col-6">
                                   <h2>City</h2>
                                </div>
                                <div class="col-6">
                                    <a id="rowAdder" type="button" class="btn btn-success float-end" href="<?php echo base_url();?>/index.php/state">
                                       <span class="bi bi-plus-square-dotted"></span> State
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                           <div class="card-body">
                              <div>
                                 <div class="row">
                                    <div class="col-sm-12 col-md-4">
                                       <form method="post" action="<?php echo site_url('/set-city'); ?>">
                                          <div class="form-group">
                                             <label>State Name<span style="color:red;">*</span></label>
                                             <select class="form-control" name="state_id" id="cs" style="padding: 0.875rem 1.375rem">
                                                <option value="">-Select State-</option>
                                                <?php if(isset($dax)){ foreach ($dax as $rox) { ?>
                                                <option value="<?php echo $rox['id']; ?>" ><?php echo ucwords($rox['state_name']); ?></option>
                                                <?php }} ?> 
                                             </select>
                                             <span style="color:red;"><?php if(isset($error['state_id'])){ echo $error['state_id']; } ?></span>
                                          </div>
                                          <div class="form-group">
                                             <label>City Name<span style="color:red;">*</span></label>
                                             <input class="form-control" type="text" name="city_name" value="<?= set_value('city_name'); ?>">
                                             <span style="color:red;"><?php if(isset($error['city_name'])){ echo $error['city_name']; } ?></span>
                                          </div>
                                          <div class="col-sm-12 col-md-12">
                                             <button type="submit" class="btn btn-primary">Submit</button>   
                                          </div>
                                       </form>
                                    </div>
                                    <div class="col-sm-12 col-md-8">
                                       <table class="table table-striped hover border data-table-export">
                                          <thead>
                                             <tr >
                                                <th><b>Id</b></th>
                                                <th><b>State Name</b></th>
                                                <th><b>City</b></th>
                                                <th><b>Action</b></th>
                                             </tr>
                                          </thead>
                                          <tbody id="cc">
                                             <?php if(isset($dax1)) { $i = 0;
                                                foreach($dax1 as $row) {
                                                   $i=$i+1;
                                                ?>
                                                <tr>
                                                   <td>
                                                      <?php echo $i; ?>
                                                   </td>
                                                   <td><?php echo ucwords($row['state_name']); ?></td>
                                                   <td><?php echo ucwords($row['city_name']); ?></td>
                                                   <td>
                                                      <span style="color:blue" class="span" type="submit"  data-bs-toggle="modal" data-bs-target="#bd-example-modal-lg-edit-<?php echo $row['id']; ?>" title="Edit"><span class="mdi mdi-pen"></span></span>
                                                      <span style="color:red" class="span" data-bs-toggle="modal" data-bs-target="#bd-example-modal-lg-del-<?php echo $row['id']; ?>" title="Delete"><span class="mdi mdi-trash-can-outline"></span></span>
                                                   </td>
                                                </tr>
                                                <!-- =============================Delete Model Start ======================= --> 
                                                <div class="modal fade bs-example-modal-lg" id="bd-example-modal-lg-del-<?php echo $row['id']; ?>" tabindex="<?php echo $row['id']; ?>" role="dialog" aria-labelledby="bd-example-modal-lg-del-<?php echo $row['id']; ?>" aria-hidden="true">
                                                   <div class="modal-dialog modal-sm modal-dialog-centered">
                                                      <div class="modal-content">
                                                         <div class="modal-header">
                                                            <h4 class="modal-title" id="myLargeModalLabel">Delete</h4>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                         </div>
                                                         <div class="modal-body">
                                                            <div class="container">
                                                               <div class="row">
                                                                  <div class="col-sm-12 col-md-12">
                                                                     <form method="post" action="<?php echo site_url('/del-city'); ?>">
                                                                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                                                        Are You Sure To Delete This Record!<br>
                                                                        <button type="submit" class="btn btn-danger">Delete</button>
                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                     </form>
                                                                  </div>
                                                               </div>
                                                            </div>
                                                         </div>
                                                      </div>
                                                   </div>
                                                </div>
                                                <!-- ============================Delete Model End========================= -->
                                                <!-- ============================Edit Model Start========================= --> 
                                                <div class="modal fade bs-example-modal-lg" id="bd-example-modal-lg-edit-<?php echo $row['id']; ?>" tabindex="<?php echo $row['id']; ?>" role="dialog" aria-labelledby="bd-example-modal-lg-edit-<?php echo $row['id']; ?>" aria-hidden="true">
                                                   <div class="modal-dialog modal-sm modal-dialog-centered">
                                                      <div class="modal-content">
                                                         <div class="modal-header">
                                                            <h4 class="modal-title" id="myLargeModalLabel">Edit City</h4>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                         </div>
                                                         <div class="modal-body">
                                                            <div class="container">
                                                               <div class="row">
                                                                  <form method="post" action="<?php echo site_url('/update-city'); ?>">
                                                                     <input type="hidden" name="id" value="<?= $row['id']; ?>">
                                                                     <div class="form-group">
                                                                        <label>State Name<span style="color:red;">*</span></label> 
                                                                        <select class="form-control" name="state_id">
                                                                           <option value="">-Select State-</option>
                                                                           <?php if(isset($dax)){ foreach ($dax as $rox) { ?>
                                                                           <option value="<?php echo $rox['id']; ?>" <?php if($rox['id']==$row['state_id']){ echo 'selected="selected"';} ?>><?php echo ucwords($rox['state_name']); ?></option>
                                                                           <?php } } ?>    
                                                                        </select>
                                                                     </div>
                                                                     <div class="form-group">
                                                                        <label>State Abbreviation<span style="color:red;">*</span></label>
                                                                        <input class="form-control" type="text" required name="city_name" value="<?php echo ucwords($row['city_name'])?>">
                                                                     </div>
                                                                     <div class="col-sm-12 col-md-12">
                                                                        <button type="submit" class="btn btn-primary">Submit</button>   
                                                                     </div>
                                                                  </form>
                                                               </div>
                                                            </div>
                                                         </div>
                                                      </div>
                                                   </div>
                                                </div>
                                                <!-- ===========================Edit Model End======================== -->
                                             <?php } } ?>
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
         </div>
         <?php include('include/footer.php')?>
      </div>
      <?php include('include/script.php'); ?>
      <script>  
         $(document).ready(function () {
            $('#cs').change(function(){ 
               var state_id = $('#cs').val();  
               var action = 'get_city';   
               if(state_id != '')
               {   
                  $.ajax({     
                     url:"<?php echo base_url('/index.php/getstatewisecity')?>",
                     method:"GET",
                     data:{state_id:state_id, action:action},  
                     dataType:"JSON",
                     success:function(data)  
                     {        
                        var html = '';
         
                        for(var count = 0; count < data.length; count++)
                        {
                           html += '<tr><td>'+data[count].id+'</td><td>'+data[count].state_name+'</td><td>'+data[count].city_name+'</td><td><span style="color:blue" class="span" type="submit"  data-bs-toggle="modal" data-bs-target="#bd-example-modal-lg-edit-'+data[count].id+'" title="Edit"><span class="mdi mdi-pen"></span></span><span style="color:red" class="span" data-bs-toggle="modal" data-bs-target="#bd-example-modal-lg-del-'+data[count].id+'" title="Delete"><span class="mdi mdi-trash-can-outline"></span></span></td></tr>';
                           //html += '<option value="'+data[count].id+'">'+data[count].city_name+'</option>';
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
   </body>
</html>