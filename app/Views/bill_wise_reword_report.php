<?php 
   use App\Models\StateModel; 
   use App\Models\CityModel;
   use App\Models\PartyUserModel;
   use App\Models\EmployeeModel;
   use App\Models\BillRegisterModel;
   use App\Models\CompenyModel;
   use App\Models\RewardPointModel;   
   $EmployeeModelObj = new EmployeeModel();
   $BillRegisterModelObj = new BillRegisterModel();
   $state = new StateModel();
   $city = new CityModel();  
   $CompenyModelObj = new CompenyModel();  
   $RewardPointModelObj = new RewardPointModel();        

    if (isset($_GET["compeny_id"])) {
        $Searchcompeny_id = $_GET["compeny_id"];
   } else {
        $Searchcompeny_id = "";
   }
   if (isset($_GET["start_Date"])) {
        $start_Date = $_GET["start_Date"];
   } else {
        $start_Date = "";
   }
   if (isset($_GET["end_Date"])) {
        $end_Date = $_GET["end_Date"];
   } else {
        $end_Date = "";
   }

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
                  
                
                      <div class="col-md-12 col-sm-12 List p-3">
                      <form method="get" action="<?php echo site_url('/bill_wise_reword_report'); ?>" enctype="multipart/form-data">
                                         <div class="row">

                                             <div class="col-md-2" >
                                            <input type="date" name="start_Date" class="form-control"  style="padding: 0.375rem 1.375rem" >
                                        </div>
                                        <div class="col-md-2" >
                                            <input type="date" name="end_Date" class="form-control"  style="padding: 0.375rem 1.375rem">
                                        </div>

                                        <div  class="col-md-3">
                                      <select name="compeny_id" id="compeny_id" class="form-control filterserach" required onchange="submit()"> 
                                            <option value="">Select Compeny </option>
                                              <option value="All">All </option>
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

                                        <!--  <div  class="col-md-3">
                                      <select name="emp_id" id="emp_id" class="form-control filterserach"style="width: 100% !important;" required> 
                                            <option value="">Select Empolyee </option>
                                             
                                             
                                        </select>
                                         </div>

                                         <div  class="col-md-2">
                                         <select name="Status" class="form-control filterserach"style="width: 100% !important;" onchange="submit()"> 
                                            <option value="">Select Status </option>

                                             <option value="All">All </option>
                                             <option value="NotDone">Not Done </option>
                                                <option value="4">Done </option>
                                               
                                        </select>  
                                         </div>-->
                                            </div>
                                     </form>
                      </div>
                      <?php 
                     if(isset($_GET['start_Date']))
                     {
                      ?>
                     <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="col-md-12 col-sm-12 List p-3">
                                <div class="row">
                                    <div  class="col-md-4">
                                       <h2>View Bill Wise Reword</h2>
                                    </div>
                                     <div  class="col-md-4">
                                    
                                   </div>

                                    <div  class="col-md-4">
                                  &nbsp; 
                                       <form method="post" action="<?php echo site_url('/bill_wise_reword_report_export'); ?>" enctype="multipart/form-data">
                                            <span style="display: none;">
                                                <input type="date" value="<?php echo $start_Date;  ?>" name="start_Date" required >
                                                <input type="date" value="<?php echo $end_Date; ?>" name="end_Date"  >
                                                <input type="text" value="<?php echo $Searchcompeny_id; ?>" name="Searchcompeny_id"  >
                                            </span>
                                            <!--<button type="button" class="btn btn-success float-end btn-lg" onclick="exportTableToExcel('myTable', 'table_export')">Export to Excel</button>-->
                                            <button type="submit" class="btn btn-danger float-end btn-lg" >Export to Excel</button>
                                        </form>

                                          &nbsp; 
                                    <!--   <a href="<?php echo base_url('/index.php/export_reword_report'); ?>"  class="btn btn-danger float-end" >Excel Export</a>-->
                                      <button onclick="printDiv('contentToPrint')" class="btn btn-success float-end" style="padding: 0.675rem 1.375rem">Print</button> 
                                    </div>
                                </div>
                            </div>
                           <div class="card-body cardbody p-1">
                              
                              <div class="table-responsive" id="contentToPrint">
                                 <table class="table table-bordered table-hover" id="myTable" border="2">
                                    <thead>
                                       <tr >
                                          <th><b>S.No</b></th>
                                        
                                      
                                           <th class="bg-warning"><b>Bill Id </b></th>
                                             <th><b>UID  </b></th>
                                             <th><b>Compeny Name  </b></th>
                                           <!-- <th class="bg-warning"><b>Bill No</b></th>
                                           <th class="bg-warning"><b>Amount</b></th>
                                           <th class="bg-warning"><b>Bill Date</b></th>-->
                                          <th><b>Status</b></th>
                                           <th><b>Total Reword</b></th>
                                            <th><b>Reword Details</b></th>
                                       </tr>
                                     
                                        
                                    </thead>
                                    <tbody>
                                       <?php 
                                      
                                 
                                       if(isset($users)){
                                       foreach ($users as $index => $row){
                                       ?>
                                       <tr>
                                          <td><?= $startSerial++ ?></td>
                                          <td><?php echo $row['id']; ?></td>
                                          <td><?php echo $row['uid']; ?></td>
                                           <td><?php 
                                                            $compenyrow= $CompenyModelObj->where('id',$row['compeny_id'])->first();
                                                            if(isset($compenyrow) && $compenyrow!='')
                                                            {
                                                                echo $compenyrow['name']; 
                                                            }
                                                            ?>
                                                        </td>

                                        <!--  <td><?php echo $row['Bill_No']; ?></td>
                                           <td>Rs.  <?php echo $row['Bill_Amount']; ?></td>
                                           <td><?php echo   date('d-m-Y', strtotime($row['Bill_DateTime']))?></td>-->
                                          <td><?php 
                                          
                                           if($row['Recived_Status']=='1'){
                                            echo 'Pending';
                                          }
                                           elseif($row['Recived_Status']=='2'){
                                            echo 'Accepected';
                                          }
                                          elseif($row['Recived_Status']=='3'){
                                            echo 'Reject';
                                          }
                                          elseif($row['Recived_Status']=='4'){
                                            echo 'Done';
                                          }
                                          else
                                          {

                                          }


                                           ?>
                                        </td>
                                        <td><b> <?php 

                                            $resultl2 = $RewardPointModelObj->select('sum(reward_point) as reward_point2')->where('bill_id', $row['id'])->first();
                                               echo $resultl2['reward_point2'];

                                          ?></b></td>
                                       <td>

                                      <table >
                                       <?php  if($startSerial==2){?>
                                       <thead>
                                       <tr>
                                    
                                      
                                          <th><b> Empolyee Name </b></th>
                                          <th><b>Reward Point</b></th>
                                          <th><b>Reward Point Type</b></th>
                                          <th><b>Bill Date</b></th>
                                          <th><b>Reward Date</b></th>
                                          <th><b>Status</b></th>
                                       </tr>
                                     
                                        
                                    </thead>
                                 <?php }?>
                                    <tbody>
                                       <?php 
                                        $TotalReword=0;
                                    $dax1 = $RewardPointModelObj->where('bill_id',$row['id'])->findAll();
                                       if(isset($dax1)){
                                       foreach ($dax1 as $index => $row2){
                                       ?>
                                       <tr>
                                           <td>
                                             <?php 
                                             $MappingEmprow= $EmployeeModelObj->where('id',$row2['emp_id'])->first();
                                             if(isset($MappingEmprow) && $MappingEmprow!='')
                                             {
                                               echo $MappingEmprow['first_name']; 
                                               echo " ".$MappingEmprow['last_name'];
                                             }
                                             ?> 
                                         </td>
                                          <td><?php echo $row2['reward_point']; ?></td>
                                          <td><?php echo $row2['reward_point_type']; ?></td>
                                          <td><?php echo $row['Bill_DateTime']; ?></td>
                                          <td><?php echo $row2['rec_time_stamp']; ?></td>
                                          <td><?php 
                                          
                                           if($row2['status']=='1' && $row2['paid_status']=='1'){
                                            echo 'Pending';
                                          }
                                           elseif($row2['status']=='2' && $row2['paid_status']=='1'){
                                            echo 'Unpaid';
                                          }
                                          elseif($row2['status']=='3' && $row2['paid_status']=='1'){
                                            echo 'Reject';
                                          }
                                          elseif($row2['status']=='2' && $row2['paid_status']=='2'){
                                            echo 'Paid';
                                          }
                                          else
                                          {

                                          }


                                           ?></td>
                                       </tr>
                                                    
                                       <?php 
                                        $TotalReword=$TotalReword+$row2['reward_point'];
                                       } 
                                       } 
                                       ?>
                                         
                                    </tbody>
                                 </table>
                             
                                           </td>
                                       </tr>
                                      				    
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

        <script>
         function printDiv(divId) {
            var content = document.getElementById(divId).innerHTML;
            var originalContent = document.body.innerHTML;
            document.body.innerHTML = content;
            window.print();
            document.body.innerHTML = originalContent; // Restore the original content
         }
      </script>
   </body>
</html>