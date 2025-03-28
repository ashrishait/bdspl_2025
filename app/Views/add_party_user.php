<!DOCTYPE html>
<html lang="en">
   <head>
      <?php include('include/head.php'); ?>
      <script type="text/javascript">
         function getVendorDetails()
         {
             var depart = $('#GST_No').val(); 
             var top = depart;
             //   alert(depart);
             //   alert(top);
             ajaxRequest = new XMLHttpRequest();
             ajaxRequest.onreadystatechange = function()
             {
                 if(ajaxRequest.readyState == 4)
                 {
                     var ajaxDisplay = document.getElementById('VendorDetails');
                     ajaxDisplay.innerHTML = ajaxRequest.responseText;    
                 }
             }
             ajaxRequest.open("GET", "<?php echo base_url('/index.php/VendorDetails_ajax')?>?GST_No=" +top, true);
             ajaxRequest.send(); 
         }
      </script>
   </head>
   <body>
      <div class="container-scroller">
         <?php include('include/header.php'); ?>
         <!-- partial -->
         <div class="container-fluid page-body-wrapper">
            <div class="main-panel">
               <div class="content-wrapper">
                  <div class="row">
                     <div class="col-md-12 col-sm-12">
                        <?php
                           if(session()->has("emp_ok"))
                           {   
                              if(session("emp_ok")==1)   
                              {  
                                    echo "<div class='alert alert-success' role='alert'> Your Registration is successful. Please Login!!</div>";
                              }
                              elseif(session("emp_ok")==2)   
                              {  
                                  echo "<div class='alert alert-danger' role='alert'> GSTIN exist. Please login. </div>";
                              }
                              else{
                                  echo "<div class='alert alert-danger' role='alert'> Problem in Submition! </div>";
                              }
                           } 
                           ?>
                     </div>
                     <div class="col-md-12">
                        <div class="col-md-12 col-sm-12 List p-3">
                            <div class="row">
                                <div class="col-6">
                                   <h2>Add Vendor</h2>
                                </div>
                                <div class="col-6">
                                    <a id="rowAdder" type="button" class="btn btn-success float-end" href="<?php echo base_url();?>/index.php/view_party_user">
                                        <span class="bi bi-plus-square-dotted">
                                        </span> View Vendor
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card" >
                           <div class="card-body cardbody" style="">
                              <form method="post" action="<?php echo site_url('/set_party_user'); ?>" enctype="multipart/form-data">
                                 <input  type="hidden" name="compeny_id" value="<?php echo $compeny_id; ?>" >
                                 <input  type="hidden" name="Add_By" value="<?php echo $emp_id;?>" >
                                 <div class="row">
                                    <div class="col-sm-12 col-md-3">
                                       <div class="form-group">
                                          <label>GST No <span style="color:red;">*</span></label>
                                          <input class="form-control" type="text" name="GST_No" placeholder=" GST No" required  id="GST_No" onchange = "getVendorDetails();" required value="<?= set_value('GST_No'); ?>">
                                          <span style="color:red;"><?php if(isset($error['GST_No'])){ echo $error['GST_No'];   }?></span>
                                       </div>
                                       <div class="col-sm-12" id="VendorDetails"></div>
                                    </div>
                                    
                                    <div class="col-sm-12 col-md-3">
                                       <div class="form-group">
                                          <label>Name <span style="color:red;">*</span></label>
                                          <input class="form-control" type="text" name="Name" placeholder=" Name" value="<?= set_value('Name'); ?>">
                                       </div>
                                    </div>
                                    <div class="col-sm-12 col-md-3">
                                       <div class="form-group">
                                          <label>Mobile No<span style="color:red;">*</span></label>
                                          <input class="form-control" type="text" name="Mobile_No" placeholder="Mobile No" value="<?= set_value('Mobile_No'); ?>" maxlength="10">
                                          <span style="color:red;"><?php if(isset($error['Mobile_No'])){ echo $error['Mobile_No'];   }?>
                                       </div>
                                    </div>
                                    <div class="col-sm-12 col-md-3">
                                       <div class="form-group">
                                          <label>Email Id <span style="color:red;">*</span></label>
                                          <input class="form-control date-picker" type="text" name="Email_Id" placeholder="Email Id"  value="<?= set_value('Email_Id'); ?>">
                                          <span style="color:red;"><?php if(isset($error['Email_Id'])){ echo $error['Email_Id'];   }?>>
                                       </div>
                                    </div>
                                    <div class="col-sm-12 col-md-3">
                                       <div class="form-group">
                                          <label>Current Address <span style="color:red;">*</span></label>
                                          <textarea name="Address" class="form-control" style="height:100px!important;" id="ca"><?= set_value('Address'); ?></textarea>
                                          <span style="color:red;"><?php if(isset($error['Address'])){ echo $error['Address']; } ?></span>
                                       </div>
                                    </div>
                                    <div class="col-sm-12 col-md-3">
                                       <div class="form-group">
                                          <label>State <span style="color:red;">*</span></label>
                                          <select name="C_State" class="form-control" id="cs" style="padding: 0.875rem 1.375rem">
                                             <option value="">-Select State-</option>
                                             <?php
                                             if(isset($dax)){
                                                foreach ($dax as $row){ ?>
                                                   <option value="<?php echo $row['id']; ?>"<?php if(isset($_POST['C_State']) && $_POST['C_State']==$row['id']) echo 'selected="selected"'; ?>><?php echo ucwords($row['state_name']); ?></option>
                                                   <?php    
                                                }
                                             } 
                                             ?> 
                                          </select>
                                          <span style="color:red;"><?php if(isset($error['C_State'])){ echo $error['C_State']; } ?></span>
                                       </div>
                                    </div>
                                    <div class="col-sm-12 col-md-3">
                                       <div class="form-group">
                                          <label>City <span style="color:red;">*</span></label>
                                          <select name="C_City" class="form-control" id="cc" style="padding: 0.875rem 1.375rem">
                                             <option value="">-Select City-</option>
                                          </select>
                                          <span style="color:red;"><?php if(isset($error['C_City'])){ echo $error['C_City']; } ?></span>
                                       </div>
                                    </div>
                                    <div class="col-sm-12 col-md-3">
                                       <div class="form-group">
                                          <label>Pin Code <span style="color:red;">*</span></label>
                                          <input class="form-control"  type="number" name="C_Pincode" value="" id="cp" value="<?= set_value('C_Pincode'); ?>" >
                                          <span style="color:red;"><?php if(isset($error['C_Pincode'])){ echo $error['C_Pincode']; } ?></span>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="col-sm-12 col-md-3">
                                       <div class="form-group">
                                          <label><input type="checkbox" name="same" id="good" onclick="hello();" /> Permanent Address <span style="color:red;">*</span></label>
                                          <textarea placeholder="Permanent Address ( If Same as Current Address Then Tick the Checkbox. )" name="PAddress" class="form-control" style="height:100px!important;" id="pa"><?= set_value('PAddress'); ?></textarea>
                                          <span style="color:red;"><?php if(isset($error['PAddress'])){ echo $error['PAddress']; } ?></span>
                                       </div>
                                    </div>
                                    <div class="col-sm-12 col-md-3">
                                       <div class="form-group">
                                          <label>State <span style="color:red;">*</span></label>
                                          <select name="PState" class="form-control" id="ps" style="padding: 0.875rem 1.375rem">
                                             <option value="">-Select State-</option>
                                             <?php
                                                if(isset($dax)){
                                                    foreach ($dax as $row){ ?>
                                             <option value="<?php echo $row['id']; ?>" <?php if(isset($_POST['PState']) && $_POST['PState']==$row['id']) echo 'selected="selected"'; ?>><?php echo ucwords($row['state_name']); ?></option>
                                             <?php }} ?>   
                                          </select>
                                          <span style="color:red;"><?php if(isset($error['PState'])){ echo $error['PState']; } ?></span>
                                       </div>
                                    </div>
                                    <div class="col-sm-12 col-md-3">
                                       <div class="form-group">
                                          <label>City <span style="color:red;">*</span></label>
                                          <select name="PCity" class="form-control" id="pc" style="padding: 0.875rem 1.375rem">
                                             <option value="">-Select City-</option>
                                          </select>
                                          <span style="color:red;"><?php if(isset($error['PCity'])){ echo $error['PCity']; } ?></span>
                                       </div>
                                    </div>
                                    <div class="col-sm-12 col-md-3">
                                       <div class="form-group">
                                          <label>Pin Code <span style="color:red;">*</span></label>
                                          <input class="form-control" type="number" name="PPincode" value="" id="pp" value="<?= set_value('PPincode'); ?>">
                                          <span style="color:red;"><?php if(isset($error['PPincode'])){ echo $error['PPincode']; } ?></span>
                                       </div>
                                    </div>
                                    <div class="col-sm-12 col-md-3">
                                       <div class="form-group">
                                          <label>Password <span style="color:red;" required>*</span></label>
                                          <input class="form-control" type="password" name="E_Password" value="">
                                       </div>
                                    </div>
                                 </div>
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
               </div>
               <!-- partial -->
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
         $("#cs").select2({
             placeholder: "Select State",
             allowClear: true
         });
      </script>
      <script>
         $("#cc").select2({
             placeholder: "Select City",
             allowClear: true
         });
      </script>

      <script>
         $(function() {
         $("#E_Image").change(function () {
                 if(fileExtValidate(this)) {
                      if(fileSizeValidate(this)) {
                         showImg(this);
                      }   
                 }    
             });
         
         // File extension validation, Add more extension you want to allow
         var validExt = ".png, .gif, .jpeg, .jpg";
         function fileExtValidate(fdata) {
          var filePath = fdata.value;
          var getFileExt = filePath.substring(filePath.lastIndexOf('.') + 1).toLowerCase();
          var pos = validExt.indexOf(getFileExt);
          if(pos < 0) {
             alert("This file is not allowed, please upload valid file.");
             return false;
           } else {
             return true;
           }
         }
         
         // file size validation
         // size in kb
         var maxSize = '1024';
         function fileSizeValidate(fdata) {
              if (fdata.files && fdata.files[0]) {
                         var fsize = fdata.files[0].size/1024;
                         if(fsize > maxSize) {
                              alert('Maximum file size exceed the limit, Minimum 1 MB');
                              return false;
                         } else {
                             return true;
                         }
              }
          }
         
          // display img preview before upload.
         function showImg(fdata) {
                 if (fdata.files && fdata.files[0]) {
                     var reader = new FileReader();
         
                     reader.onload = function (e) {
                         $('#output').attr('src', e.target.result);
                     }
         
                     reader.readAsDataURL(fdata.files[0]);
                 }
             }
         
             
         });
      </script>
      <script>
         function generateid(str){
         
             if(str!=""){  
             const d = new Date();
             var year = d.getFullYear();  
             var inc = document.getElementById('emp_jio_id').value;
             var stx = (str.split("=")[0]); 
             var st = (str.split("=")[1]);
             document.getElementById('location_id').value= stx;
             document.getElementById('Emp_id_no').value='JVS/E/'+st+'/'+inc+'/'+year;
         }else{
             document.getElementById('Emp_id_no').value= "";
         }
         } 
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
    </body>  
</html>