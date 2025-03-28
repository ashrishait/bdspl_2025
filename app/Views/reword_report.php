<?php 
   use App\Models\StateModel; 
   use App\Models\CityModel;
   use App\Models\PartyUserModel;
   use App\Models\EmployeeModel;
   use App\Models\BillRegisterModel;
   $EmployeeModelObj = new EmployeeModel();
   $BillRegisterModelObj = new BillRegisterModel();
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
         .filterserach{
       padding: 0.995rem 1.375rem !important;
       background: white !important;
       outline: 0 !important;
       width: 100% !important;
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
                                 echo "<div class='alert alert-success' role='alert'> Form Updation Successful.But GST_No Not Update , GST_No Already Exits </div>";
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
                       </div>
                      <div class="col-md-12 col-sm-12 List p-3">
                      <form method="get" action="<?php echo site_url('/reword_report'); ?>" enctype="multipart/form-data">
                                         <div class="row">

                                             <div class="col-md-2" >
                                            <input type="date" name="start_Date" class="form-control"  style="padding: 0.375rem 1.375rem" >
                                        </div>
                                        <div class="col-md-2" >
                                            <input type="date" name="end_Date" class="form-control"  style="padding: 0.375rem 1.375rem">
                                        </div>

                                        <div  class="col-md-3">
                                      <select name="compeny_id" id="compeny_id" class="form-control filterserach" required> 
                                            <option value="">Select Compeny </option>
                                             
                                            <?php
                                            if(isset($dax1)){
                                                foreach ($dax1 as $row1){ 
                                                    $selected = ($row1['id'] == @$_GET['compeny_id']) ? 'selected' : '';
                                                    ?>
                                                    <option value="<?php echo $row1['id']; ?>" <?php echo $selected; ?>><?php echo $row1['name']; ?></option>
                                                <?php 
                                                }
                                            } ?> 
                                        </select>
                                         </div>

                                          <div  class="col-md-3">
                                      <select name="emp_id" id="emp_id" class="form-control filterserach"style="width: 100% !important;" required> 
                                            <option value="">Select Empolyee </option>
                                             
                                             
                                        </select>
                                         </div>

                                         <div  class="col-md-2">
                                         <select name="Status" class="form-control filterserach"style="width: 100% !important;" onchange="submit()"> 
                                            <option value="">Select Status </option>

                                             <option value="All">All </option>
                                                <option value="1">Pending </option>
                                                <option value="2">Unpaid </option>
                                                <option value="3">Reject </option>
                                        </select>  
                                         </div>
                                            </div>
                                     </form>
                      </div>
                      <?php 
                     if(isset($_GET['Status']))
                     {
                      ?>
                     <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="col-md-12 col-sm-12 List p-3">
                                <div class="row">
                                    <div  class="col-md-4">
                                       <h2>View Reword</h2>
                                    </div>
                                     <div  class="col-md-4">
                                    
                                   </div>

                                    <div  class="col-md-4">
                                       <!-- &nbsp; <button type="button" class="btn btn-danger float-end" onclick="exportTableToExcel('myTable', 'table_export')">Export to Excel</button>  -->
                                       <a href="<?php echo base_url('/index.php/export_reword_report'); ?>"  class="btn btn-danger float-end" >Excel Export</a>
                                       
                                    </div>
                                </div>
                            </div>
                           <div class="card-body cardbody p-1">
                              
                              <div class="table-responsive">
                                 <table class="table table-bordered table-hover" id="myTable">
                                    <thead>
                                       <tr>
                                          <th><b>S.No</b></th>
                                          <th><b>UID  </b></th>
                                      
                                          <th><b>  Empolyee Name </b></th>
                                          <th><b>Reward Point</b></th>
                                          <th><b>Reward Point Type</b></th>
                                          <th><b>Bill Date</b></th>
                                          <th><b>Reward Date</b></th>
                                          <th><b>Status</b></th>
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
                                          <td><?php echo $row['uid']; ?></td>
                                       
                                     
                                           <td>
                                             <?php 
                                             $MappingEmprow= $EmployeeModelObj->where('id',$row['emp_id'])->first();
                                             if(isset($MappingEmprow) && $MappingEmprow!='')
                                             {
                                               echo $MappingEmprow['first_name']; 
                                               echo " ".$MappingEmprow['last_name'];
                                             }
                                             ?> 
                                         </td>
                                          <td><?php echo $row['reward_point']; ?></td>
                                          <td><?php echo $row['reward_point_type']; ?></td>
                                          <td><?php echo $row['Bill_DateTime']; ?></td>
                                          <td><?php echo $row['rec_time_stamp']; ?></td>
                                          <td><?php 
                                          
                                           if($row['status']=='1' && $row['paid_status']=='1'){
                                            echo 'Pending';
                                          }
                                           elseif($row['status']=='2' && $row['paid_status']=='1'){
                                            echo 'Unpaid';
                                          }
                                          elseif($row['status']=='3' && $row['paid_status']=='1'){
                                            echo 'Reject';
                                          }
                                          elseif($row['status']=='2' && $row['paid_status']=='2'){
                                            echo 'Paid';
                                          }
                                          else
                                          {

                                          }


                                           ?></td>
                                       </tr>
                                                        
                                       <?php 
                                       } 
                                       } 
                                       ?>
                                    </tbody>
                                 </table>
                           <h3>   <b> Total Reword Point : <?= $TotalRewardPointSum; ?></b> </h3>
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
                     <?php

                 }


                     ?>
                  </div>
               </div>
            </div>
         </div>
         <?php include('include/footer.php')?>
      </div>
      <?php include('include/script.php'); ?>
         
      <script>  
         $(document).ready(function () {
         $('#compeny_id').change(function(){ 
            var compeny_id = $('#compeny_id').val();  
            var action = 'get_empolyee';   
            if(compeny_id != '')
            {   
                $.ajax({     
                    url:"<?php echo base_url('/index.php/getCompenyEmpolyee')?>",
                    method:"GET",
                    data:{compeny_id:compeny_id, action:action},  
                    dataType:"JSON",
                    success:function(data)  
                    {        
                        var html = '<option value="">Select </option>'+'<option value="All">All </option>';
                        
                        for(var count = 0; count < data.length; count++)
                        {
                            html += '<option value="'+data[count].id+'">'+data[count].first_name+ ' '+data[count].last_name+'</option>';
                        }
         
                        $('#emp_id').html(html);
                    }
                });
            }
            else   
            {
                $('#emp_id').val('');
            }
         
         });  
         
         
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