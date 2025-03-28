<?php
   use App\Models\StateModel; 
   use App\Models\CityModel;
   use App\Models\UserModel;  
   use App\Models\EmployeeModel;
   use App\Models\PartyUserModel;
   use App\Models\RollModel;
   use App\Models\RewardPointModel;
   $state = new StateModel();
   $city = new CityModel();
   $modelUser = new UserModel();
   $modelEmployee = new EmployeeModel();
   $PartyUserModelObj = new PartyUserModel();
   $RollModelObj = new RollModel();
   $today = date('Y-m-d');
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
                  <div class="row mb-4">
                            <div class="col-4">
                                <h3 class=" font-weight-bold"><span  style="cursor: pointer;" onclick="history.back()">&larr; Go Back</span></h3>
                            </div>
                            <div class="col-4">
                                
                            </div>
                            <div class="col-4"></div>
                        </div>
                  <div class="row">
                     <div class="col-md-12 col-sm-12">
                        <?php
                           if(session()->has("success"))
                           {   
                           
                             echo session("success");
                           
                           } 
                           ?>
                     </div>
                     <div class="col-md-12">
                        <div class="col-md-12 col-sm-12 List p-3">
                            <div class="row">
                                <div class="col-6">
                                   <h2>Edits Bill</h2>
                                </div>
                                <div class="col-6">
                                 
                                </div>
                            </div>
                        </div>
                        <div class="card">
                           <div class="card-body cardbody">
                              <form method="post" action="<?php echo site_url('/update_bill_register'); ?>" enctype="multipart/form-data">
                                 <input  type="hidden" name="Bill_Url" value="Singal" >
                                   <?php 
                                    if(isset($dax)){
                                    foreach ($dax as $row){
                                      ?>    
                                      <input  type="hidden" name="id" value="<?php echo $row['id']; ?>" >   
                                 <div class="row">
                                    <div class="col-sm-12 col-md-4">
                                       <div class="form-group">
                                          <label for="billpic" >Vendor<span style="color:red;">*</span></label>
                                          <select name="Vendor_Id" class="form-control" id="select-country" style="padding: 0.875rem 1.375rem" >
                                             <option value="">Select Vendor</option>
                                             <?php
                                             if(!empty($dax14)){
                                                foreach ($dax14 as $row14){ ?>
                                                   <option value="<?php echo $row14->id; ?>" <?php if($row['Vendor_Id']==$row14->id) {echo 'selected="selected"';} ?>><?php echo ucwords($row14->Name); ?>(<?php echo ucwords($row14->GST_No); ?>)</option>
                                                   <?php 
                                                }
                                             }
                                             else{ ?>
                                                <option value="">Please assign vendor to your company </option>
                                             <?php } ?> 
                                          </select>
                                       </div>
                                    </div>
                                    <div class="col-sm-12 col-md-4">
                                       <div class="form-group">
                                          <label for="billpic" >Bill No<span style="color:red;">*</span></label>
                                          <input class="form-control" type="text" name="Bill_No" placeholder=" Bill No" style="padding: 0.875rem 1.375rem" value="<?php echo $row['Bill_No'];?>">
                                       </div>
                                    </div>
                                    <div class="col-sm-12 col-md-4">
                                       <div class="form-group">
                                          <label for="billpic" >Bill Date<span style="color:red;">*</span></label>
                                           <?php 
                                            $Bill_DateTime=date('Y-m-d', strtotime($row['Bill_DateTime']));
                                           ?>
                                          <input class="form-control" type="date" name="Bill_DateTime" placeholder="" id="Bill_DateTime" style="padding: 0.375rem 1.375rem"  value="<?php echo $Bill_DateTime;?>">
                                       </div>
                                    </div>
                                    <div class="col-sm-12 col-md-4">
                                       <div class="form-group">
                                          <label for="billpic" >Bill Total Amt<span style="color:red;">*</span></label>
                                          <input class="form-control" type="text" name="Bill_Amount" placeholder="Bill Total Amt" oninput="this.value = this.value.replace(/[^0-9.]/g, '')" value="<?php echo $row['Bill_Amount'];?>">
                                       </div>
                                    </div>
                                    <div class="col-sm-12 col-md-4" >
                                       <div class="form-group">
                                          <label for="billpic" >Unit<span style="color:red;">*</span></label>
                                          <select name="Unit_Id" class="form-control" id="Unit_Id" style="padding: 0.875rem 1.375rem" required>
                                             <option value="">-Select -</option>
                                             <?php
                                                if(isset($dax15)){
                                                foreach ($dax15 as $row15){ ?>
                                             <option value="<?php echo $row15['id']; ?>"  <?php if($row['Unit_Id']==$row15['id']) {echo 'selected="selected"';} ?>><?php echo ucwords($row15['name']); ?></option>
                                             <?php }} ?>        
                                          </select>
                                       </div>
                                    </div>
                                    <div class="col-sm-12 col-md-4">
                                       <div class="form-group">
                                          <label for="billpic" >Gate Entry No<span style="color:red;">*</span></label>
                                          <input class="form-control" type="text" name="Gate_Entry_No" placeholder="Gate Entry No" value="<?php echo $row['Gate_Entry_No'];?>">
                                       </div>
                                    </div>
                                    <div class="col-sm-12 col-md-4">
                                       <div class="form-group">
                                          <label for="billpic" >Gate Entry Date<span style="color:red;"></span></label>
                                           <?php 
                                            $Gate_Entry_Date=date('Y-m-d', strtotime($row['Gate_Entry_Date']));
                                           ?>
                                          <input class="form-control" type="date" name="Gate_Entry_Date" placeholder="" style="padding: 0.375rem 1.375rem" max="<?php echo $today;?>" value="<?php echo $Gate_Entry_Date;?>">
                                       </div>
                                    </div>
                                    <div class="col-sm-12 col-md-4">
                                       <div class="form-group"> 
                                          <label for="billpic" >Remark<span style="color:red;"></span></label>
                                          <input class="form-control" type="text" name="Remark" placeholder="Remark if Any" value="<?php echo $row['Remark'];?>">
                                       </div>
                                    </div>
                                    <div class="col-sm-12 col-md-4">
                                       <div class="form-group">
                                          <label for="billpic" >Bill Pic<span style="color:red;">*</span></label>
                                         <input type="hidden" name="db_image" value="<?php echo $row['Bill_Pic']; ?>">           
                                        <img src="<?php echo base_url('public/vendors/PicUpload/'.$row['Bill_Pic']);?>" style="height:120px; width:auto;" id="output<?php echo $row['id']; ?>">
                                        <input type="file" class="form-control" name="E_Image" onchange="loadFile(<?php echo $row['id']; ?>)">
                                       </div>
                                    </div>
                                    <!--Display None Code Start-->
                                    <div class="col-sm-12 col-md-3" style="display: none;">
                                       <div class="form-group">
                                          <select name="Department_Id" class="form-control" style="padding: 0.875rem 1.375rem"  id="department" >
                                             <option value="">-Select Department-</option>
                                             <?php
                                                if(isset($dax9)){
                                                    foreach ($dax9 as $row){ ?>
                                             <option value="<?php echo $row['id']; ?>" ><?php echo ucwords($row['name']); ?></option>
                                             <?php }} ?>    
                                          </select>
                                       </div>
                                    </div>
                                    <!--Display None Code End-->
                                 </div>
                                  <?php 
                                  }
                               }
                                      ?> 
                                 <div class="row">
                                    <div class="col-12">
                                       <button type="submit" class="btn btn-primary btn-lg">Submit</button>   
                                       <button type="reset" class="btn btn-secondary btn-lg">Reset</button>
                                    </div>
                                 </div>
                              </form>
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
         $(document).ready(function () {
         
         $('#department').change(function(){ 
            var state_id = $('#department').val();  
            var action = 'get_unit';   
            if(state_id != '')
            {   
                $.ajax({     
                    url:"<?php echo base_url('/index.php/getUnit')?>",
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
         
                        $('#Unit_Id').html(html);
                    }
                });
            }
            else   
            {
                $('#Unit_Id').val('');
            }
         
         });
         
         
            });
      </script>
      <script>
      // Get the input element
      var dateInput = document.getElementById('Bill_DateTime');

      // Get today's date
      var today = new Date();

      // Set the fixed date you want to block dates before
      var fixedDate = new Date('2024-04-01');

      // Set the minimum date allowed (fixed date)
      dateInput.min = fixedDate.toISOString().split('T')[0];

      // Update the input value to the fixed date if today is before the fixed date
      if (today < fixedDate) {
          dateInput.value = fixedDate.toISOString().split('T')[0];
      }

      // Add an event listener to update the input value if the user tries to select a date before the fixed date
      dateInput.addEventListener('input', function() {
          var selectedDate = new Date(this.value);
          if (selectedDate < fixedDate) {
              this.value = fixedDate.toISOString().split('T')[0];
          }
      });
      </script>

   </body>
</html>
   </body>
</html>