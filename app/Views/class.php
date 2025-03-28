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
                     <div class="col-lg-12 mb-lg-0">
                        <div class="card congratulation-bg py-0" style="background:none;">
                           <div class="card-body py-0">
                              <div class="container">
                                 <div class="row">
                                    <div class="col-6">
                                       <h2 class="mb-3 font-weight-bold">Manage Qualification</h2>
                                    </div>
                                    <div class="col-6">
                                       <?php
                                          if($Roll_id==1||$Roll_id==5)
                                            {
                                              ?>
                                       <?php
                                          }
                                          ?>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="container">
                        <div class="col-md-12 col-sm-12"> 
                           <?php
                              if(session()->has("class_ok"))
                                  {   
                                   if(session("class_ok")==1)   
                                      {  
                              echo "<div class='alert alert-success' role='alert'> Class name added Successful. </div>";
                                        }else{
                              echo "<div class='alert alert-danger' role='alert'> Problem in Submition! </div>";
                                           }
                                        }
                                   if(session()->has("class_up"))
                                  {   
                                   if(session("class_up")==1)   
                                      {  
                              echo "<div class='alert alert-success' role='alert'> Class name updated Successful. </div>";
                                        }else{
                              echo "<div class='alert alert-danger' role='alert'> Problem in updation! </div>";
                                           }
                                        } 
                              
                              ?> 
                        </div>
                     </div>
                     <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                           <div class="card-body">
                              <div class="container">
                                 <div class="row">
                                    <div class="col-sm-12 col-md-4">
                                       <form method="post" action="<?php echo site_url('/set-class'); ?>">
                                          <input type="hidden" name="country" value="1">
                                          <div class="form-group">
                                             <label>Class Name<span style="color:red;">*</span></label>
                                             <input class="form-control" type="text" name="class_name" value="<?= set_value('class_name'); ?>">
                                             <span style="color:red;"><?php if(isset($error['class_name'])){ echo $error['class_name']; } ?></span>
                                          </div>
                                          <div class="form-group">
                                             <label>Class Abbreviation<span style="color:red;">*</span></label>
                                             <input class="form-control" type="text" name="class_abbrevation" value="<?= set_value('class_abbrevation'); ?>">
                                             <span style="color:red;"><?php if(isset($error['class_abbrevation'])){ echo $error['class_abbrevation']; } ?></span>
                                          </div>
                                          <div class="col-sm-12 col-md-12">
                                             <button type="submit" class="btn btn-primary">Submit</button>   
                                          </div>
                                       </form>
                                    </div>
                                    <div class="col-sm-12 col-md-8">
                                       <table class="table table-striped hover data-table-export">
                                          <thead>
                                             <tr>
                                                <th>S.No</th>
                                                <th>Class Name</th>
                                                <th>Class Abbreviation</th>
                                                <th>Action</th>
                                             </tr>
                                          </thead>
                                          <tbody>
                                             <?php if(isset($dax)) { $i = 0;
                                                foreach($dax as $row) {
                                                
                                                    ?>
                                             <tr>
                                                <td>
                                                   <?php echo ++$i; ?>
                                                </td>
                                                <td><?php echo ucwords($row['class_name'])?>
                                                </td>
                                                <td><?php echo ucwords($row['class_abbrevation'])?></td>
                                                <td>
                                                   <span style="color:blue" class="span"  type="submit"  data-bs-toggle="modal" data-bs-target="#bd-example-modal-lg-edit-<?php echo $row['id']; ?>" style="border-radius: 0px!important; padding:4px!important; font-size:11px;"><i class="fa fa-pencil"></i>Edit</span>
                                                   <br>
                                                   <span style="color:red" class="span" data-bs-toggle="modal" data-bs-target="#bd-example-modal-lg-del-<?php echo $row['id']; ?>" style="border-radius: 0px!important; padding:4px!important;font-size:11px;"><i class="fa fa-trash"></i>Delete</span>
                                                </td>
                                             </tr>
                                             <!-- ========================================Delete Model Start================================== --> 
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
                                                                  <form method="post" action="<?php echo site_url('/del-class'); ?>">
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
                                             <!-- ======================================Delete Model End================================== -->
                                             <!-- ========================================Edit Model Start================================== --> 
                                             <div class="modal fade bs-example-modal-lg" id="bd-example-modal-lg-edit-<?php echo $row['id']; ?>" tabindex="<?php echo $row['id']; ?>" role="dialog" aria-labelledby="bd-example-modal-lg-edit-<?php echo $row['id']; ?>" aria-hidden="true">
                                                <div class="modal-dialog modal-sm modal-dialog-centered">
                                                   <div class="modal-content">
                                                      <div class="modal-header">
                                                         <h4 class="modal-title" id="myLargeModalLabel">Edit Class</h4>
                                                         <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                      </div>
                                                      <div class="modal-body">
                                                         <div class="container">
                                                            <div class="row">
                                                               <form method="post" action="<?php echo site_url('/update-class'); ?>">
                                                                  <input type="hidden" name="id" value="<?= $row['id']; ?>">
                                                                  <div class="form-group">
                                                                     <label>Class Name<span style="color:red;">*</span></label>
                                                                     <input class="form-control" type="text" required name="class_name" value="<?php echo ucwords($row['class_name'])?>">
                                                                  </div>
                                                                  <div class="form-group">
                                                                     <label>Class Abbreviation<span style="color:red;">*</span></label>
                                                                     <input class="form-control" type="text" name="class_abbrevation" value="<?php echo ucwords($row['class_abbrevation'])?>">
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
                                             <!-- ======================================Edit Model End================================== -->
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
         var loadFile2 = function(str) {
           var reader = new FileReader();
           reader.onload = function(){
             var output2 = document.getElementById('output2'+str);
             output2.src = reader.result;
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
   </body>
</html>