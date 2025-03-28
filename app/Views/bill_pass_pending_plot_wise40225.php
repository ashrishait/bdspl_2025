<?php 
   use App\Models\StateModel; 
   use App\Models\CityModel;
   use App\Models\UnitModel;
   use App\Models\RollModel;
   use App\Models\EmployeeModel;
   use App\Models\PartyUserModel;
   use App\Models\BillRegisterModel;
   use App\Models\DepartmentModel;
   use App\Models\BillTypeModel;
   use App\Models\MasterActionModel;
   use App\Models\MasterActionUploadModel;
   use App\Models\BillShippedModel;
   helper('Number_helper'); 
   
   $MasterActionUploadModelObj = new MasterActionUploadModel();
   $BillTypeModelObj = new BillTypeModel();
   $state = new StateModel();
   $city = new CityModel();
   $UnitModelObj = new UnitModel();
   $RollModelObj = new RollModel();
   $EmployeeModelObj = new EmployeeModel();
   $PartyUserModelObj = new PartyUserModel();
   $BillRegisterModelObj = new BillRegisterModel();
   $DepartmentModelObj = new DepartmentModel();
   $MasterActionModelObj = new MasterActionModel();
   $BillShippedModelobg = new BillShippedModel();
   if (isset($_GET["start_date"])) {
      $start_date = $_GET["start_date"];
   } 
   else {
      $start_date = "";
   } 
   if (isset($_GET["end_date"])) {
      $end_date = $_GET["end_date"];
   } 
   else {
      $end_date = "";
   }
   if (isset($_GET["Employee"])) {
      $Employee = $_GET["Employee"];
   } 
   else {
      $Employee = "";
   } 
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
                     <div class="col-6 mb-2">
                        <h3 class=" font-weight-bold"><span  style="cursor: pointer;" onclick="history.back()">&larr; Go Back</span></h3>
                     </div>
                     <div class="col-6">
                        <!--  <a class="btn btn-primary btn-sm" href="<?php echo base_url();?>/add_bill_register" style="float:right;">
                           <span class="bi bi-plus-square-dotted">
                           </span> Add Bill
                           </a>-->
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-md-12 col-sm-12"> 
                        <?php
                           if(session()->has("Mapping_RecivedBill"))
                           {   
                               if(session("Mapping_RecivedBill")==1)   
                               {  
                                       echo "<div class='alert alert-success' role='alert'>Mapping Successfully. </div>";
                               }
                               else{
                                   echo "<div class='alert alert-danger' role='alert'>Not Successfully Department Mapping Bill ! </div>";   
                               }
                           }
                           
                           
                             if(session()->has("Bill_Acceptation_Status"))
                              {   
                               if(session("Bill_Acceptation_Status")==1)   
                               {  
                                       echo "<div class='alert alert-success' role='alert'>Successfully Change Status  . </div>";
                               }
                               else{
                                   echo "<div class='alert alert-danger' role='alert'>Not Change Status ! </div>";   
                               }
                           }
                           
                           ?>    
                     </div>
                  </div>
                  <div class="col-lg-12">
                     <div class="col-md-12 col-sm-12 List p-3">
                        <div class="row">
                           <div class="col-md-4">
                              <h2>Bill Pass Plot Wise Report </h2>
                           </div>
                           <div class="col-md-6">
                              <form method="get" action="<?php echo site_url('/bill_pass_pending_plot_wise'); ?>" enctype="multipart/form-data">
                                 <div class="row">
                                    <div class="col-md-4" >
                                       <input type="date" name="start_date" class="form-control" required style="padding: 0.375rem 1.375rem" value="2024-04-01">
                                    </div>
                                    <div class="col-md-4" >
                                       <input type="date" name="end_date" class="form-control" required style="padding: 0.375rem 1.375rem">
                                    </div>
                                    <div class="col-md-4" >
                                       <button type="submit" class="btn btn-warning" style="padding: 0.675rem 1.375rem"> Search   </button>
                                    </div>
                                 </div>
                              </form>
                           </div>
                           <div class="col-md-2">
                              <button onclick="printDiv('contentToPrint')" class="btn btn-success float-end" style="padding: 0.675rem 1.375rem">Print</button>
                           </div>
                        </div>
                     </div>
                     <div class="card" id="contentToPrint">
                        <?php if (isset($_GET["start_date"])) {?>
                        <div class="card-body cardbody p-1">
                           <div class="">
                              <div class="row">
                                 <div class="col-md-12"> 
                                    <center> <span style="font-size: 18px;font-weight: bold;color:red">    <?php echo  date("d-m-Y", strtotime($start_date));?>  To  <?php echo  date("d-m-Y", strtotime($end_date));?> </span></center>
                                 </div>
                                 <div class="col-md-6" >
                                    <table class="table table-striped table-bordered table-hover" style="width:100%">
                                       <thead>
                                          <tr>
                                             <td colspan="3"><center><b>Pending Bill </b></center></td>
                                          </tr>
                                          <tr>
                                             <th><b>Plot</b></th>
                                             <th><b>Total Bill </b></th>
                                             <th><b>Total Bill Amount</b></th>
                                          </tr>
                                       </thead>
                                       <tbody>

                                          <?php //
                                          $result = $session->get();
                                          //  $etm = $result['ddn'];  
                                          $i=0;
                                          $pending_total_amount=0;
                                          $pending_total_bill=0;                                      
                                          if (isset($_GET["start_date"])) {
                                             $start_date = $_GET["start_date"];
                                          } 
                                          else {
                                             $start_date = "";
                                          }
                                          if (isset($_GET["end_date"])) {
                                             $end_date = $_GET["end_date"];
                                          } 
                                          else {
                                             $end_date = "";
                                          }
                                          if(isset($dax)){
                                             foreach ($dax as $row){
                                                $i = $i+1;
                                                ?>
                                                <tr>
                                                   <?php 
                                                      $bill_i=0; 
                                                       
                                                      $billrow= $BillRegisterModelObj->where('compeny_id', $compeny_id)->where('Unit_Id',$row['id'])->where('Recived_Status', 1) ->where("STR_TO_DATE(Bill_DateTime, '%Y-%m-%d') BETWEEN '$start_date' AND '$end_date'")->findAll();
                                                      if(isset($billrow) && $billrow!='')
                                                      {

                                                         $pending_amount=0;
                                                       foreach ($billrow as $billrow2){
                                                       $bill_i = $bill_i+1;
                                                       $pending_amount = $pending_amount+$billrow2['Bill_Amount'];

                                                       }
                                                      // echo $bill_i;
                                                      }
                                                      
                                                   
                                                   if($bill_i!=0)
                                                       {
                                                       ?>

                                                       <td><?php echo $row['description']; ?></td>
                                                       <td><?php echo $bill_i; ?></td>
                                                        <td><?php echo moneyFormatIndia($pending_amount); ?></td>

                                                         <?php
                                                      }
                                                      ?>
                                                </tr>
                                                <?php 
                                                } 
                                             } 
                                             ?>
                                          <tr>
                                             <td></td>
                                             <td></td>
                                             <td> <?php 
                                              if($Total_Bill_Amount_Pending>0)
                                              {
                                             echo moneyFormatIndia($Total_Bill_Amount_Pending);
                                               }
                                              ?></td>
                                          </tr>
                                       </tbody>
                                    </table>
                                 </div>
                                 <div class="col-md-6">
                                    <table class="table table-striped table-bordered table-hover" style="width:100%">
                                       <thead>
                                          <tr>
                                             <td colspan="3"><center><b>Total Bill </b></center></td>
                                          </tr>
                                          <tr>
                                             <th><b>Total Bill</b></th>
                                             <td><?= $Total_Bill_count_Pending+$Total_Bill_count_Done+$Total_Bill_count_Accepted+$Total_Bill_count_Reject; ?></td>
                                          </tr>
                                       </thead>
                                       <tbody>
                                        <tr>
                                            <th><b>Total Bill Amount</b></th>
                                            <td><?= moneyFormatIndia($Total_Bill_Amount_Pending+$Total_Bill_Amount_Done+$Total_Bill_Amount_Accepted+$Total_Bill_Amount_Reject); ?></td>
                                        </tr> 
                                        <tr>
                                           <th><b>Total Bill Pass</b></th>
                                           <td><?= $Total_Bill_count_Done; ?></td>
                                       </tr>
                                       <tr>
                                           <th><b>Bill Pass Amount</b></th>
                                           <td><?= moneyFormatIndia($Total_Bill_Amount_Done); ?></td>
                                       </tr>
                                       <tr>
                                          <th><b>Pending Total Bill </b></th>
                                          <td><?php echo $Total_Bill_count_Pending?></td>
                                       </tr>
                                       <tr>
                                          <th><b>Pending Total Bill Amount </b></th>
                                          <td><?php echo moneyFormatIndia($Total_Bill_Amount_Pending);?></td>
                                       </tr>
                                      <?php 
                                        if($Total_Bill_count_Accepted>0)
                                           {
                                           ?>
                                         <tr>
                                            <th><b> Accepted Total Bill </b></th>
                                            <td><?php echo $Total_Bill_count_Accepted?></td>
                                         </tr>
                                         <tr>
                                            <th><b>Accepted Total Bill Amount </b></th>
                                            <td><?php echo moneyFormatIndia($Total_Bill_Amount_Accepted);?></td>
                                         </tr>
                                          <?php

                                           }
                                           ?>
                                      
                                       <?php 
                                           if($Total_Bill_count_Accepted>0)
                                           {
                                           ?>
                                         <tr>
                                            <th><b> Rejected Total Bill </b></th>
                                            <td><?php echo $Total_Bill_count_Reject?></td>
                                         </tr>
                                         <tr>
                                            <th><b>Rejected Total Bill Amount </b></th>
                                            <td><?php echo moneyFormatIndia($Total_Bill_Amount_Reject);?></td>
                                         </tr>
                                          <?php

                                           }
                                          ?>
                                       
                                    </tbody>
                                 </table>
                              </div>
                           </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-6" >
                                    <table class="table table-striped table-bordered table-hover" style="width:100%">
                                       <thead>
                                          
                                          <tr>
                                             <th><b>Bill Type</b></th>
                                             <th><b>Total Bill </b></th>
                                             <th><b>Total Bill Amount</b></th>
                                          </tr>
                                       </thead>
                                       <tbody>

                                          <?php 
                                          $i2=0;
                                          $All_BillType_total_amount=0;
                                          $BillType_total_bill=0;                                      
                                        
                                          if(isset($dax2)){
                                             foreach ($dax2 as $row2){
                                                $i2 = $i2+1;
                                                ?>
                                                <tr>
                                                   <?php 
                                                        $BillType_bill_i=0;
                                                       
                                                      $BillTyperow= $BillRegisterModelObj->where('compeny_id', $compeny_id)->where('Bill_Type',$row2['id']) ->where("STR_TO_DATE(Bill_DateTime, '%Y-%m-%d') BETWEEN '$start_date' AND '$end_date'")->findAll();
                                                      if(isset($BillTyperow) && $BillTyperow!='')
                                                      {
                                                         $BillType_total_amount=0;
                                                       foreach ($BillTyperow as $BillTyperow2){

                                                       $BillType_bill_i = $BillType_bill_i+1;

                                                       $BillType_total_amount = $BillType_total_amount+$BillTyperow2['Bill_Amount'];

                                                       }
                                                       //echo $BillType_bill_i;
                                                      }
                                                       
                                                


                                                     if($BillType_bill_i!=0)
                                                       {
                                                       ?>

                                                       <td><?php echo $row2['name']; ?></td>
                                                       <td><?php echo $BillType_bill_i; ?></td>
                                                        <td><?php echo moneyFormatIndia($BillType_total_amount); ?></td>

                                                         <?php
                                                      }
                                                      ?>
                                                </tr>
                                                <?php 
                                                $All_BillType_total_amount=$All_BillType_total_amount+$BillType_total_amount;
                                                } 
                                             } 
                                             ?>
                                          <tr>
                                             <td></td>
                                             <td></td>
                                             <td><?php if($All_BillType_total_amount>0){echo moneyFormatIndia($All_BillType_total_amount);} ?> </td>
                                          </tr>
                                       </tbody>
                                    </table>
                                 </div>
                           <div class="col-md-6">
                              
                              <form method="get" action="<?php echo site_url('/bill_pass_pending_plot_wise'); ?>" enctype="multipart/form-data">
                                 <table  id="example22" class="table table-striped table-bordered table-hover" style="width:100%">
                                    <thead>
                                       <tr>
                                          <th><b>Month</b></th>
                                          <th><b>-------</b></th>
                                          <th><b>Total Bill Amount</b></th>
                                          <th><b></b></th>
                                          <th><b>Balance To Ship</b></th>
                                       </tr>
                                    </thead>
                                    <?php

                                     $year1 = date("Y", strtotime($_GET["start_date"]));
                                      $CheckedBillShippedrow= $BillShippedModelobg->where('compeny_id',$compeny_id)->where('Month','April')->where('Year',$year1)->first();
                                      if(isset($CheckedBillShippedrow) && $CheckedBillShippedrow!='') {
                                    ?>
                                    <tbody>
                                       <?php
                                          $AllTotalAmount=0;
                                          $TotalBillPassAmount=0;
                                          $TotalBalanceAmount=0;
                                          $BalanceToShipAmount=0;

                                          // Array of months
                                          $months = array(
                                             'April', 'May', 'June', 'July','August', 'September', 'October', 'November', 'December',  'January', 'February', 'March'
                                          );

                                          // Loop through the months array
                                          for ($i = 0; $i < count($months); $i++) {
                                             if($months[$i]=="April")
                                             {
                                                $monthsNumber=4; 
                                                if (isset($_GET["start_date"])) {
                                                   $start_date = $_GET["start_date"];
                                                   $year = date("Y", strtotime($start_date));
                                                } 
                                                else {  
                                                   $year = "1170";
                                                } 
                                             }
                                             elseif($months[$i]=="May")
                                             {
                                                $monthsNumber=5; 
                                                if (isset($_GET["start_date"])) {
                                                   $start_date = $_GET["start_date"];
                                                   $year = date("Y", strtotime($start_date));
                                                } 
                                                else {  
                                                   $year = "1170";
                                                }
                                             }
                                             elseif($months[$i]=="June")
                                             {
                                                $monthsNumber=6; 
                                                if (isset($_GET["start_date"])) {
                                                   $start_date = $_GET["start_date"];
                                                   $year = date("Y", strtotime($start_date));
                                                } 
                                                else {  
                                                   $year = "1170";
                                                } 
                                             }
                                             elseif($months[$i]=="July")
                                             {
                                                $monthsNumber=7;
                                                if (isset($_GET["start_date"])) {
                                                   $start_date = $_GET["start_date"];
                                                   $year = date("Y", strtotime($start_date));
                                                } 
                                                else {  
                                                   $year = "1170";
                                                } 
                                             }
                                             elseif($months[$i]=="August")
                                             {
                                                $monthsNumber=8; 
                                                if (isset($_GET["start_date"])) {
                                                   $start_date = $_GET["start_date"];
                                                   $year = date("Y", strtotime($start_date));
                                                } 
                                                else {  
                                                   $year = "1170";
                                                } 
                                             }
                                             elseif($months[$i]=="September")
                                             {
                                                $monthsNumber=9; 
                                                if (isset($_GET["start_date"])) {
                                                   $start_date = $_GET["start_date"];
                                                   $year = date("Y", strtotime($start_date));
                                                } 
                                                else {  
                                                   $year = "1170";
                                                } 
                                             }
                                             elseif($months[$i]=="October")
                                             {
                                                $monthsNumber=10; 
                                                if (isset($_GET["start_date"])) {
                                                   $start_date = $_GET["start_date"];
                                                   $year = date("Y", strtotime($start_date));
                                                } 
                                                else {  
                                                   $year = "1170";
                                                } 
                                             }
                                             elseif($months[$i]=="November")
                                             {
                                                $monthsNumber=11; 
                                                if (isset($_GET["start_date"])) {
                                                   $start_date = $_GET["start_date"];
                                                   $year = date("Y", strtotime($start_date));
                                                } 
                                                else {  
                                                   $year = "1170";
                                                } 
                                             }
                                             elseif($months[$i]=="December")
                                             {
                                                $monthsNumber=12; 
                                                if (isset($_GET["start_date"])) {
                                                   $start_date = $_GET["start_date"];
                                                   $year = date("Y", strtotime($start_date));
                                                } 
                                                else {  
                                                   $year = "1170";
                                                } 
                                             }
                                             elseif($months[$i]=="January")
                                             {
                                                $monthsNumber=1; 
                                                if (isset($_GET["start_date"])) {
                                                   $start_date = $_GET["start_date"];
                                                   $year = date("Y", strtotime($start_date));
                                                   $year=$year+1;
                                                } 
                                                else {  
                                                   $year = "1170";
                                                }
                                             }
                                             elseif($months[$i]=="February")
                                             {
                                                $monthsNumber=2;
                                                if (isset($_GET["start_date"])) {
                                                   $start_date = $_GET["start_date"];
                                                   $year = date("Y", strtotime($start_date));
                                                   $year=$year+1;
                                                } 
                                                else {  
                                                   $year = "1170";
                                                }
                                             }
                                             elseif($months[$i]=="March")
                                             {
                                                $monthsNumber=3; 
                                                if (isset($_GET["start_date"])) {
                                                   $start_date = $_GET["start_date"];
                                                   $year = date("Y", strtotime($start_date));
                                                   $year=$year+1;
                                                } 
                                                else {  
                                                   $year = "1170";
                                                }
                                             }
                                             $MonthName= $months[$i];
                                             $BillShippedrow= $BillShippedModelobg->where('compeny_id',$compeny_id)->where('Month',$MonthName)->where('Year',$year)->first();
                                             if(isset($BillShippedrow) && $BillShippedrow!='') {
                                                ?>
                                             <tr>
                                                <th>
                                                   <?php  echo $BillShippedrow['Year'] ; ?> , 
                                                   <?php  echo $BillShippedrow['Month'] ; ?>
                                                </th>
                                                <td>
                                                   <?php echo moneyFormatIndia($BillShippedrow['TotalAmount']) ; ?>
                                                </td>
                                                <td>
                                                   <?php  echo moneyFormatIndia($BillShippedrow['BillPassAmount']) ; ?>
                                                </td>
                                                <td>
                                                   <?php echo moneyFormatIndia($BillShippedrow['BalanceAmount']) ; ?>
                                                </td>
                                                <td>
                                                   <?php echo moneyFormatIndia($BillShippedrow['BalanceToShipAmount']) ; ?>
                                                </td>
                                             </tr>
                                             <?php
                                             $AllTotalAmount=$AllTotalAmount+$BillShippedrow['TotalAmount'] ;
                                             $TotalBillPassAmount=$TotalBillPassAmount+$BillShippedrow['BillPassAmount'] ;
                                             $TotalBalanceAmount=$TotalBalanceAmount+$BillShippedrow['BalanceAmount'];
                                             $BalanceToShipAmount=$BalanceToShipAmount+$BillShippedrow['BalanceToShipAmount'];
                                             }
                                          }
                                          ?>
                                          <tr>
                                             <th>G. Total</th>
                                             <td>Rs. <?php echo moneyFormatIndia($AllTotalAmount);?></td>
                                             <td>Rs. <?php echo moneyFormatIndia($TotalBillPassAmount);?></td>
                                             <td>Rs. <?php echo moneyFormatIndia($TotalBalanceAmount);?></td>
                                             <td>Rs. <?php echo moneyFormatIndia($BalanceToShipAmount);?></td>
                                          </tr>
                                          <tr>
                                             <th>Rs.  <?php echo moneyFormatIndia($AllTotalAmount);?></th>
                                             <td>Bill Expense</td>
                                             <td><?php
                                                if ($AllTotalAmount != 0) {
                                                   // Calculate the percentage
                                                   $percentage = ($TotalBillPassAmount / $AllTotalAmount) * 100;
                                                   echo round($percentage,2);
                                                }
                                               ?> %
                                             </td>
                                             <td></td>
                                             <td></td>
                                          </tr>

                                          <tr>
                                              <td></td>
                                             <td></td>
                                             <td></td>
                                             <td></td>
                                             <td></td>
                                          </tr>
                                       </tbody>
                                    <?php } ?>
                                    </table>
                                 </form>   
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <?php }?>
               </div>
            </div>
         </div>
         <?php include('include/footer.php')?>
      </div>

      
      <?php include('include/script.php'); ?>
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