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
   if (isset($_GET["Vendor_Id"])) {
        $Vendor_Id = $_GET["Vendor_Id"];
   } else {
        $Vendor_Id = "";
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
         .bootstrap-select .btn{
         padding-top:12px;
         padding-bottom:12px;
         border:1px solid #00000045 !important;
         }
         .tableFixHead          { overflow: auto; height: 800px; }
            .tableFixHead thead th { position: sticky; top: 0; z-index: 1; }
            
            /* Just common table stuff. Really. */
            table  { border-collapse: collapse; width: 100%; }
            th, td { padding: 8px 16px; }
            th     { background:#eee; }
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
                                   <h2>Complete Bill Report </h2>
                                </div>
                                <div class="col-md-6">
                                    <form method="get" action="<?php echo site_url('/complete_bill_report'); ?>" enctype="multipart/form-data">
                                        <div class="row">
                                            <div class="col-md-3" >
                                                <input type="date" name="start_Date" class="form-control" required style="padding: 0.375rem 1.375rem" value="2024-04-01">
                                            </div>
                                            <div class="col-md-3" >
                                                <input type="date" name="end_Date" class="form-control" required style="padding: 0.375rem 1.375rem">
                                            </div>
                                            <div class="col-md-3" >
                                                <select name="Vendor_Id" class="form-control" id="select-country" style="padding: 0.875rem 1.375rem;width:100%">
                                                    <option value="">Select Vendor</option>
                                                    <?php
                                                    if(!empty($dax14)){
                                                        foreach ($dax14 as $row14){ ?>
                                                           <option value="<?php echo $row14->id; ?>"><?php echo ucwords($row14->Name); ?>(<?php echo ucwords($row14->GST_No); ?>)</option>
                                                           <?php 
                                                        }
                                                    }
                                                    else{ ?>
                                                        <option value="">Please assign vendor to your company </option>
                                                    <?php } ?> 
                                                </select>
                                            </div>
                                            <div class="col-md-3" >
                                                <button type="submit" class="btn btn-warning" style="padding: 0.675rem 1.375rem"> Search   </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-md-2">
                                    <form method="post" action="<?php echo site_url('/complete_bill_report_export'); ?>" enctype="multipart/form-data">
                                        <span style="display: none;">
                                            <input type="date" value="<?php echo $start_Date;  ?>" name="start_Date">
                                            <input type="date" value="<?php echo $end_Date; ?>" name="end_Date">
                                            <input type="text" value="<?php echo $Vendor_Id; ?>" name="Vendor_Id">
                                        </span>
                                        <!--<button type="button" class="btn btn-success float-end btn-lg" onclick="exportTableToExcel('myTable', 'table_export')">Export to Excel</button>-->
                                        <button type="submit" class="btn btn-success float-end btn-lg" >Export to Excel</button>
                                    </form>
                                  
                                </div>
                            </div>
                        </div>
                            <div class="card">
                                <div class="card-body cardbody p-1">
                                    <div class="table-responsive tableFixHead">
                                        <table class="table table-bordered table-hover p-0" id="myTable" style="border: 1px solid black;">
                                            <thead>
                                                 <tr>
                                                    <td class="p-0 bg-white">#</td>
                                                    <td class="p-0 bg-white"></td>
                                                    <td class="p-0 bg-white"></td>
                                                    <td class="p-0 bg-white"></td>
                                                    <td class="p-0 bg-white"></td>
                                                    <td class="p-0 bg-white"></td>
                                                    <td class="p-0 bg-white"></td>
                                                    <td class="p-0 bg-white"></td>
                                                    <td class="p-0 bg-white"></td>
                                                    <td class="p-0 bg-white"></td>
                                                    <td class="p-0 bg-white"></td>
                                                    <td class="p-0 bg-white"></td>
                                                    <td style="border: none;" class="p-0 bg-white"> <center><b>Assignment</b> </center></td>
                                                    <td class="p-0 bg-white" style="border: none;"> </td>
                                                    <td class="p-0 bg-white" style="border: none;"></td>
                                                    <td class="p-0 bg-white" style="border: none;"></td>
                                                    <td class="p-0 bg-white" style="border-right: none;"><center><b>Bill.Verify</b> </center></td>
                                                    <td class="p-0 bg-white" style="border: none;"></td>
                                                    <td class="p-0 bg-white" style="border: none;"></td>
                                                    <td class="p-0 bg-white"  style="border-right: none;"><center><b>Bill.Entry</b> </center></td>
                                                    <td class="p-0 bg-white" style="border: none;"></td>
                                                    <td class="p-0 bg-white" style="border: none;"></td>
                                                    <td class="p-0 bg-white"  style="border-right: none;"><center><b>Bill.Received </b> </center></td>
                                                    <td class="p-0 bg-white" style="border: none;"></td>
                                                    <td class="p-0 bg-white" style="border: none;"></td>
                                                </tr>
                                                <tr style="border-bottom:1px solid black;"></tr>
                                                <tr>

                                                    <th class="p-0 bg-white">#</th>

                                                    <th class="p-0 bg-white"><b>Add By Name & Id </b> </th>

                                                    <th class="p-0 bg-white"><b>Bill.Pic</b></th>

                                                    <th class="p-0 bg-white"><b>Unit</b></th>

                                                    <th class="p-0 bg-white"><b>U.Id</b></th>

                                                    <th class="p-0 bg-white"><b>Vendor</b></th>

                                                    <th class="p-0 bg-white"><b>Bill No</b></th>

                                                    <th class="p-0 bg-white"><b>BillDate</b></th>

                                                    <th class="p-0 bg-white"><b>Gate Entry No</b></th>

                                                    <th class="p-0 bg-white"><b>Gate Entry Date</b></th>

                                                    <th class="p-0 bg-white"><b>Bill Type</b></th>
                                                    
                                                    <th class="p-0 bg-white"><b>Amount</b></th>

                                                    <th class="p-0 bg-white"><b>Accept Date</b> </th>

                                                    <th class="p-0 bg-white"><b>Accept By Name & Ids</b></th>

                                                    <th class="p-0 bg-white"><b>Assign By Name & Ids </b></th>

                                                    <th class="p-0 bg-white"><b>Assign To Name & Ids</b></th>

                                                    <th class="p-0 bg-white"><b>Accept Date</b></th>

                                                    <th class="p-0 bg-white"><b> Master Action Name & Ids</b></th>

                                                    <th class="p-0 bg-white"><b>Send  By Name & Ids</b></th>

                                                    <th class="p-0 bg-white"><b>Accept Date </b></th>

                                                    <th class="p-0 bg-white"><b> Master Action Name & Ids </b></th>

                                                    <th class="p-0 bg-white"><b>Send Id By Name & Ids </b></th>

                                                    <th class="p-0 bg-white"><b>Accept Date </b></th>

                                                    <th class="p-0 bg-white"><b> Master Action Name & Ids </b></th>

                                                    <th class="p-0 bg-white"><b>Compelet By Name & Ids </b></th>
                                                </tr>
                                                <tr style="border-bottom:1px solid black;"></tr>

                                            </thead>
                                            <tbody>
                                                <?php 
                                                $result = $session->get();
                                                if(isset($users)){
                                                    foreach ($users as $index => $row){
                                                        $Departmentrow= $DepartmentModelObj->where('id',$row['Department_Id'])->first();
                                                        ?>
                                                        <tr>
                                                            <td class="p-0 bg-white"><?= $startSerial++ ?></td>
                                                            <td class="p-0 bg-white">
                                                                <?php 
                                                                if($row['Add_By_Vendor']==1)
                                                                {
                                                                    echo "Add By Vendor";
                                                                }
                                                                else{
                                                                    $MappingEmprow= $EmployeeModelObj->where('id',$row['Add_By'])->first();
                                                                    if(isset($MappingEmprow) && $MappingEmprow!='')
                                                                    {
                                                                        echo $MappingEmprow['first_name']; 
                                                                        echo " ".$MappingEmprow['last_name'];
                                                                        //echo "<br><br><span style='background:yellow'> ".$MappingEmprow['email']."</span>";
                                                                    }
                                                                }
                                                                ?> 
                                                            </td>
                                                            <td class="p-0 bg-white">
                                                                <?php 
                                                                if(!empty($row['Bill_Pic'])){ ?>
                                                                    <a href="<?php echo base_url('public/vendors/PicUpload/'.$row['Bill_Pic']);?>" target="_blank">link</a>
                                                                <?php }?>
                                                            </td>
                                                            <td class="p-0 bg-white">
                                                                <?php 
                                                                $Unitrow= $UnitModelObj->where('id',$row['Unit_Id'])->first();
                                                                if(isset($Unitrow) && $Unitrow!='')
                                                                {
                                                                    echo $Unitrow['description']; 
                                                                }
                                                                ?> 
                                                            </td>
                                                            <td class="p-0 bg-white"><?php echo $row['uid']; ?></td>
                                                            <td class="p-0 bg-white"><?php 
                                                                $Vendorrow= $PartyUserModelObj->where('id',$row['Vendor_Id'])->first();
                                                                if(isset($Vendorrow) && $Vendorrow!='')
                                                                {
                                                                    echo $Vendorrow['Name']; 
                                                                }
                                                                ?>
                                                            </td>
                                                            <td class="p-0 bg-white"><?php echo $row['Bill_No']; ?></td>
                                                            <td class="p-0 bg-white"><?php echo   date('d-m-Y', strtotime($row['Bill_DateTime']))?></td>
                                                            <td class="p-0 bg-white"><?php echo $row['Gate_Entry_No'];?></td>
                                                            <td class="p-0 bg-white"><?php echo date('d-m-Y', strtotime($row['Gate_Entry_Date']))?></td>
                                                            <td class="p-0 bg-white"><?php 
                                                            $billtyperow= $BillTypeModelObj->where('id',$row['Bill_Type'])->first();
                                                            if(isset($billtyperow) && $billtyperow!='')
                                                            {
                                                                echo $billtyperow['name']; 
                                                            }
                                                            ?></td>
                                                            <td class="p-0 bg-white"><?php echo $row['Bill_Amount']; ?></td>
                                                            <td class="p-0 bg-white"><?php echo $row['Bill_Acceptation_DateTime']; ?></td>
                                                            <td class="p-0 bg-white">
                                                                <?php 
                                                                $MappingEmprow= $EmployeeModelObj->where('id',$row['Bill_Acceptation_Status_By_MasterId'])->first();
                                                                if(isset($MappingEmprow) && $MappingEmprow!='')
                                                                {
                                                                    echo $MappingEmprow['first_name']; 
                                                                    echo " ".$MappingEmprow['last_name'];
                                                                    //echo "<br><br><span style='background:yellow'> ".$MappingEmprow['email']."</span>";
                                                                }
                                                                ?> 
                                                            </td>
                                                            <td class="p-0 bg-white">
                                                                <?php 
                                                                $MappingEmprow= $EmployeeModelObj->where('id',$row['Mapping_By_MasterId'])->first();
                                                                if(isset($MappingEmprow) && $MappingEmprow!='')
                                                                {
                                                                    echo $MappingEmprow['first_name']; 
                                                                    echo " ".$MappingEmprow['last_name'];
                                                                    //echo "<br><br><span style='background:yellow'> ".$MappingEmprow['email']."</span>";
                                                                }
                                                                ?>     
                                                            </td>
                                                            <td class="p-0 bg-white">
                                                                <?php 
                                                                $MappingEmprow= $EmployeeModelObj->where('id',$row['Department_Emp_Id'])->first();
                                                                if(isset($MappingEmprow) && $MappingEmprow!='')
                                                                {
                                                                    echo $MappingEmprow['first_name']; 
                                                                    echo " ".$MappingEmprow['last_name'];
                                                                    //echo "<br><br><span style='background:yellow'> ".$MappingEmprow['email']."</span>";
                                                                }
                                                                ?> 
                                                            </td>
                                                            <td class="p-0 bg-white"><?php echo $row['Clear_Bill_Form_DateTime']; ?></td>
                                                            <td class="p-0 bg-white">
                                                                <?php 
                                                                $MappingEmprow= $EmployeeModelObj->where('id',$row['MasterId_By_Clear_Bill_Form'])->first();
                                                                if(isset($MappingEmprow) && $MappingEmprow!='')
                                                                {
                                                                    echo $MappingEmprow['first_name']; 
                                                                    echo " ".$MappingEmprow['last_name'];
                                                                    //echo "<br><br><span style='background:yellow'> ".$MappingEmprow['email']."</span>";
                                                                }
                                                                ?> 
                                                            </td>  
                                                            <td class="p-0 bg-white">
                                                                <?php 
                                                                $MappingEmprow= $EmployeeModelObj->where('id',$row['Mapping_ERP_EmpId_By_MasterId'])->first();
                                                                if(isset($MappingEmprow) && $MappingEmprow!='')
                                                                {
                                                                    echo $MappingEmprow['first_name']; 
                                                                    echo " ".$MappingEmprow['last_name'];
                                                                    //echo "<br><br><span style='background:yellow'> ".$MappingEmprow['email']."</span>";
                                                                }
                                                                ?> 
                                                            </td>  
                                                            <!--   <td>
                                                                <?php 
                                                                $MappingEmprow= $EmployeeModelObj->where('id',$row['Mapping_ERP_EmpId'])->first();
                                                                if(isset($MappingEmprow) && $MappingEmprow!='')
                                                                {
                                                                    echo $MappingEmprow['first_name']; 
                                                                    echo " ".$MappingEmprow['last_name'];
                                                                    //echo "<br><br><span style='background:yellow'> ".$MappingEmprow['email']."</span>";
                                                                }
                                                                ?> 
                                                            </td> -->
                                                            <td class="p-0 bg-white"><?php echo $row['ERP_DateTime']; ?></td> 
                                                            <td class="p-0 bg-white">
                                                                <?php 
                                                                $MappingEmprow= $EmployeeModelObj->where('id',$row['ERP_Status_Change_By_MasterId'])->first();
                                                                if(isset($MappingEmprow) && $MappingEmprow!='')
                                                                {
                                                                    echo $MappingEmprow['first_name']; 
                                                                    echo " ".$MappingEmprow['last_name'];
                                                                    //echo "<br><br><span style='background:yellow'> ".$MappingEmprow['email']."</span>";
                                                                }
                                                                ?> 
                                                            </td> 
                                                            <td class="p-0 bg-white">
                                                                <?php 
                                                                $row['Mapping_Account_By_MasterId'];
                                                                $MappingEmprow= $EmployeeModelObj->where('id', $row['Mapping_Account_By_MasterId'])->first();
                                                                if(isset($MappingEmprow) && $MappingEmprow!='')
                                                                {
                                                                    echo $MappingEmprow['first_name']; 
                                                                    echo " ".$MappingEmprow['last_name'];
                                                                    //echo "<br><br><span style='background:yellow'> ".$MappingEmprow['email']."</span>";
                                                                }
                                                                ?> 
                                                            </td> 
                                                            <td class="p-0 bg-white"><?php echo $row['Recived_DateTime']; ?></td> 
                                                            <td class="p-0 bg-white">
                                                                <?php 
                                                                $MappingEmprow= $EmployeeModelObj->where('id',$row['Recived_Status_Change_By_MasterId'])->first();
                                                                if(isset($MappingEmprow) && $MappingEmprow!='')
                                                                {
                                                                    echo $MappingEmprow['first_name']; 
                                                                    echo " ".$MappingEmprow['last_name'];
                                                                    //echo "<br><br><span style='background:yellow'> ".$MappingEmprow['email']."</span>";
                                                                }
                                                                ?> 
                                                            </td> 
                                                            <td class="p-0 bg-white">
                                                                <?php 
                                                                $MappingEmprow= $EmployeeModelObj->where('id',$row['Recived_Completed_By_MasterId'])->first();
                                                                if(isset($MappingEmprow) && $MappingEmprow!='')
                                                                {
                                                                    echo $MappingEmprow['first_name']; 
                                                                    echo " ".$MappingEmprow['last_name'];
                                                                    //echo "<br><br><span style='background:yellow'> ".$MappingEmprow['email']."</span>";
                                                                }
                                                                ?> 
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
                                <br>
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
         <?php include('include/footer.php')?>
      </div>
      <?php include('include/script.php'); ?>
      <?php
      $rowBillRegister = $BillRegisterModelObj->where('Active',1)->findAll();
      if(isset($rowBillRegister) && $rowBillRegister!='')
      {
        foreach ($rowBillRegister as $rowBillRegister)
        { 
        ?>
            <script>      
            $(document).ready(function () {
                $('#ps<?php echo $rowBillRegister['id']; ?>').change(function(){ 
                    var department_id = $('#ps<?php echo $rowBillRegister['id']; ?>').val();  
                    var action = 'get_User';   
                    if(department_id != '')
                    {   
                        $.ajax({     
                            url:"<?php echo base_url('/index.php/getDepartmentUser')?>",
                            method:"GET",
                            data:{department_id:department_id, action:action},  
                            dataType:"JSON",
                            success:function(data)  
                            {        
                                var html = '<option value="">Select User</option>';
                 
                                for(var count = 0; count < data.length; count++)
                                {
                                    html += '<option value="'+data[count].id+'">'+data[count].first_name+'</option>';
                                }
                 
                                $('#pc<?php echo $rowBillRegister['id']; ?>').html(html);
                            }
                        });
                    }
                    else   
                    {
                        $('#pc<?php echo $rowBillRegister['id']; ?>').val('');
                    }
                });
            });
            </script>
            <script>  
            $(document).ready(function () {
                $('#department<?php echo $rowBillRegister['id']; ?>').change(function(){ 
                    var state_id = $('#department<?php echo $rowBillRegister['id']; ?>').val();  
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
                 
                                $('#Unit_Id<?php echo $rowBillRegister['id']; ?>').html(html);
                            }
                        });
                    }
                    else   
                    {
                        $('#Unit_Id<?php echo $rowBillRegister['id']; ?>').val('');
                    }
                });
            });
            </script>
            <?php
        }
      }
      ?>
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