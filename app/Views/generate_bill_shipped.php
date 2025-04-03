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
                        
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-md-12 col-sm-12"> 
                     <?php
                     if(session()->has("ok"))
                     {   
                        if(session("ok")==1)   
                        {  
                           echo "<div class='alert alert-success' role='alert'> Form Submition Successful. </div>";
                        }
                        else{
                           echo "<div class='alert alert-danger' role='alert'> Problem in Submition! </div>";
                        }
                     } 
                     ?>   
                     </div>
                  </div>
                  <div class="col-lg-12">
                     <div class="col-md-12 col-sm-12 List p-3">
                        <div class="row">
                           <div class="col-md-4">
                              <h2>Generate Bill Shipped Report </h2>
                           </div>
                           <div class="col-md-6">
                              <form method="get" action="<?php echo site_url('/generate_bill_shipped'); ?>" enctype="multipart/form-data">
                                 <div class="row">
                                    <div class="col-md-4" >
                                       <select  name="year" class="form-control" required style="padding: 0.375rem 1.375rem">
                                          <option value="">Year</option>
                                          <option value="2023">2023-24</option>
                                          <option value="2024">2024-25</option>
                                          <option value="2025">2025-26</option>
                                       </select>
                                    </div>
                                    <div class="col-md-4" >
                                       <button type="submit" class="btn btn-warning" style="padding: 0.375rem 1.375rem"> Search   </button>
                                    </div>
                                 </div>
                              </form>
                           </div>
                           <div class="col-md-2">
                              
                           </div>
                        </div>
                     </div>
                     <div class="card">
                        <div class="card-body cardbody p-1">
                           <div class="row">
                              <div class="col-md-12">
                                 <form method="post" action="<?php echo site_url('/generate_bill_shipped_save'); ?>" enctype="multipart/form-data">
                                    <input type="hidden" value="<?php echo $compeny_id;?>" name="compeny_id">
                                    <div class="table-responsive">
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
                                          <tbody>
                                          <?php
                                          // Array of months
                                          $months = array('April', 'May', 'June', 'July','August', 'September', 'October', 'November', 'December',  'January', 'February', 'March');
                                          // Loop through the months array
                                          for ($i = 0; $i < count($months); $i++) {
                                             if($months[$i]=="April")
                                             {
                                                $monthsNumber=4; 
                                                if (isset($_GET["year"])) {
                                                   $year = $_GET["year"];
                                                } 
                                                else {
                                                   $year = "";
                                                } 
                                             }
                                             elseif($months[$i]=="May")
                                             {
                                                $monthsNumber=5; 
                                                if (isset($_GET["year"])) {
                                                   $year = $_GET["year"];
                                                } 
                                                else {
                                                   $year = "";
                                                } 
                                             }
                                             elseif($months[$i]=="June")
                                             {
                                                $monthsNumber=6; 
                                                if (isset($_GET["year"])) {
                                                   $year = $_GET["year"];
                                                } 
                                                else {
                                                   $year = "";
                                                } 
                                             }
                                             elseif($months[$i]=="July")
                                             {
                                                $monthsNumber=7;
                                                if (isset($_GET["year"])) {
                                                   $year = $_GET["year"];
                                                } 
                                                else {
                                                   $year = "";
                                                }  
                                             }
                                             elseif($months[$i]=="August")
                                             {
                                                $monthsNumber=8; 
                                                if (isset($_GET["year"])) {
                                                   $year = $_GET["year"];
                                                } 
                                                else {
                                                   $year = "";
                                                } 
                                             }
                                             elseif($months[$i]=="September")
                                             {
                                                $monthsNumber=9; 
                                                if (isset($_GET["year"])) {
                                                   $year = $_GET["year"];
                                                } 
                                                else {
                                                   $year = "";
                                                } 
                                             }
                                             elseif($months[$i]=="October")
                                             {
                                                $monthsNumber=10; 
                                                if (isset($_GET["year"])) {
                                                   $year = $_GET["year"];
                                                } 
                                                else {
                                                   $year = "";
                                                } 
                                             }
                                             elseif($months[$i]=="November")
                                             {
                                                $monthsNumber=11; 
                                                if (isset($_GET["year"])) {
                                                   $year = $_GET["year"];
                                                } 
                                                else {
                                                   $year = "";
                                                } 
                                             }
                                             elseif($months[$i]=="December")
                                             {
                                                $monthsNumber=12; 
                                                if (isset($_GET["year"])) {
                                                   $year = $_GET["year"];
                                                } 
                                                else {
                                                   $year = "";
                                                } 
                                             }
                                             elseif($months[$i]=="January")
                                             {
                                                $monthsNumber=1; 
                                                if (isset($_GET["year"])) {
                                                   $year = $_GET["year"]+1;
                                                } 
                                                else {
                                                   $year = "";
                                                } 
                                             }
                                             elseif($months[$i]=="February")
                                             {
                                                $monthsNumber=2;
                                                if (isset($_GET["year"])) {
                                                   $year = $_GET["year"]+1;
                                                } 
                                                else {
                                                   $year = "";
                                                }  
                                             }
                                             elseif($months[$i]=="March")
                                             {
                                                $monthsNumber=3; 
                                                if (isset($_GET["year"])) {
                                                   $year = $_GET["year"]+1;
                                                } 
                                                else {
                                                   $year = "";
                                                } 
                                             }
                                             $row3 = $BillRegisterModelObj->select('SUM(Bill_Amount) as Bill_Amount3')
                                             ->where('compeny_id', $compeny_id)
                                             ->where('YEAR(Bill_DateTime)', $year)
                                             ->where('MONTH(Bill_DateTime)', $monthsNumber)
                                             ->get()
                                             ->getRow();
                                             $BillPassAmount = $row3 ? $row3->Bill_Amount3 : 0;
                                             ?>
                                             <tr>
                                                <th>
                                                   <input type='checkbox' name='update[]' value='<?php echo $months[$i];?>' checked>
                                                   <input type="text" name="year<?php echo $months[$i]; ?>" value="<?php echo $year;?>" style="display: none;" required>
                                                   <input type="hidden" name="MonthName_<?php echo $months[$i]; ?>" value="<?php echo $months[$i]; ?>"  id='MonthName_<?php echo $months[$i]; ?>'>
                                                   <?php echo $year;?>, 
                                                   <?php  echo $months[$i] ; ?>
                                                </th>
                                                <td>
                                                <?php 
                                                $row= $BillShippedModelobg->where('compeny_id',$compeny_id)->where('year',$year)->where('Month',$months[$i])->first();
                                                if(isset($row) && $row!='')
                                                {
                                                   $TotalAmount=$row['TotalAmount']; 
                                                   $BalanceAmount =$row['BalanceAmount'];
                                                   $BalanceToShipAmount =$row['BalanceToShipAmount'];
                                                }
                                                else
                                                {
                                                   $TotalAmount=0;
                                                   $BalanceAmount=0; 
                                                   $BalanceToShipAmount=0;   
                                                }
                                                ?>
                                                <input type="text" name="TotalAmount<?php echo $months[$i]; ?>" placeholder="" class="multiplier<?php echo $months[$i]; ?> form-control" value="<?php echo  $TotalAmount; ?>"   id='TotalAmount<?php echo $months[$i]; ?>' >
                                                </td>
                                                <td>
                                                <?php 
                                                if($BillPassAmount!='')
                                                {
                                                   $BillPassAmount=$BillPassAmount; 
                                                }
                                                else
                                                {
                                                   $BillPassAmount=0;  
                                                }
                                                ?>
                                                <input type="text" name="BillPassAmount<?php echo $months[$i]; ?>" placeholder="" class="form-control" value="<?php echo $BillPassAmount; ?>"  readonly id="BillPassAmount<?php echo $months[$i]; ?>">
                                                </td>
                                                <td>
                                                   <input type="text" name="BalanceAmount<?php echo $months[$i]; ?>"  class=" form-control"   id="results2<?php echo $months[$i]; ?>" readonly  value="<?php echo  $BalanceAmount; ?>">
                                                </td>
                                                <td>
                                                   <input type="text" name="BalanceToShipAmount<?php echo $months[$i]; ?>"  class=" form-control"  value="<?php echo  $BalanceToShipAmount; ?>">
                                                </td>
                                             </tr>
                                             <?php
                                             }
                                             ?>
                                          </tbody>
                                       </table>
                                    </div>
                                    <button type="submit" class="btn btn-warning" style="padding: 0.375rem 1.375rem"> submit   </button>
                                 </form>   
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
      <?php include('include/script.php'); ?>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
      <?php 
         $months = array( 'April', 'May', 'June', 'July','August', 'September', 'October', 'November', 'December',  'January', 'February', 'March');
         for ($i = 0; $i < count($months); $i++) {
         ?>
         <script>
            $('.multiplier<?php echo $months[$i];?>').on('keyup', function(){
               var TotalAmount = $('#TotalAmount<?php echo $months[$i];?>').val();
               var BillPassAmount = $('#BillPassAmount<?php echo  $months[$i];?>').val();
               var Balance =TotalAmount-BillPassAmount;
               $('#results2<?php echo $months[$i];?>').val(Balance);
            });
         </script>
         <?php
         }
      ?>
   </body>
</html>