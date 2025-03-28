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
         .tableFixHead          { overflow: auto; height: 600px; }
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
                      <div class="row">
                          <div class="col-md-6 col-sm-12 List p-3" style="">
                                <h2>View Complete Bill List</h2>
                          </div>
                          <div class="col-md-6 col-sm-12 List p-3" style="">
                                <button type="button" class="btn btn-success float-end btn-lg" onclick="exportTableToExcel('myTable', 'table_export')">Export to Excel</button>
                          </div>
                      </div>
                     <div class="card">
                        <div class="card-body cardbody p-1">
                           <div class="table-responsive tableFixHead">
                              <table class="table table-bordered table-hover" id="myTable">
                                 <thead>
                                    <tr>
                                       <th class="bg-white">#</th>
                                       <th class="bg-white"><b>Upload Date</b></th>
                                       <th class="bg-white"><b>Invoice</b></th>
                                       <th class="bg-white"><b>Bill Id </b></th>
                                       <th class="bg-white"><b>Vendor</b></th>
                                       <th class="bg-white"><b>Bill No</b></th>
                                       <th class="bg-white"><b>Amount</b></th>
                                       <th class="bg-white"><b>Bill Date</b></th>
                                       <th class="bg-white"><b>Unit</b></th>
                                       <th class="bg-white"><b>Gate No </b></th>
                                       <th class="bg-white"><b>Gate Entry Date</b></th>
                                       <th class="bg-white"><b>Type</b></th>
                                       <th class="bg-white"><b>Department</b></th>
                                       <th class="bg-white"><b>Assign To</b></th>
                                       <th class="bg-white"><b>Comment</b></th>
                                       <th class="bg-white"><b>Assignment Accepted Date </b></th>
                                       <th class="bg-white"><b>Assignment Target Time</b></th>
                                       <th class="bg-white"><b>Assignment Delay/On-Time</b></th>
                                       <th class="bg-white"><b>Assignment Remark</b></th>
                                       <th class="bg-white"><b>Verification Comment</b></th>
                                       <th class="bg-white"><b>Verification Accepted</b></th>
                                       <th class="bg-white"><b>Verification Target Time</b></th>
                                       <th class="bg-white"><b>Verification Delay/On-Time</b></th>
                                       <th class="bg-white"><b>Verification Image</b></th>
                                       <th class="bg-white"><b>Verification Remark</b></th>
                                       <th class="bg-white"><b>Verification Master</b></th>
                                       <th class="bg-white"><b>Verification Master Image</b></th>
                                       <th class="bg-white"><b>Verification Master Remark</b></th>
                                       <th class="bg-white"><b>Bill Entry Employee</b></th>
                                       <th class="bg-white"><b>Bill Entry Comment</b></th>
                                       <th class="bg-white"><b>Bill Entry Date</b></th>
                                       <th class="bg-white"><b>Bill Entry Target Time</b></th>
                                       <th class="bg-white"><b>Bill Entry Delay/On-Time</b></th>
                                       <th class="bg-white"><b>Bill Entry Image</b></th>
                                       <th class="bg-white"><b>Bill Entry Remark</b></th>
                                       <th class="bg-white"><b>Bill Entry Master</b></th>
                                       <th class="bg-white"><b>Bill Entry Master Image</b></th>
                                       <th class="bg-white"><b>Bill Entry Remark</b></th>
                                       <th class="bg-white"><b>Receiver Employee</b></th>
                                       <th class="bg-white"><b>Reciver Comments</b></th>
                                       <th class="bg-white"><b>Reciver Accepted Date</b></th>
                                       <th class="bg-white"><b>Reciver Target Time</b></th>
                                       <th class="bg-white"><b>Reciver Delay/On-Time</b></th>
                                       <th class="bg-white"><b>Reciver Image</b></th>
                                       <th class="bg-white"><b>Reciver Remark</b></th>
                                       <th class="bg-white"><b>Reciver Master</b></th>
                                       <th class="bg-white"><b>Reciver Master Image</b></th>
                                       <th class="bg-white"><b>Reciver Master Remark</b></th>
                                       <th class="bg-white"><b>Vendor Comment</b></th>
                                       <th class="bg-white"><b>Vendor Upload</b></th>
                                       <th class="bg-white"><b>Status </b></th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <?php 
                                       $result = $session->get();
                                       if(isset($users)){
                                          foreach ($users as $index => $row){
                                             $Departmentrow= $DepartmentModelObj->where('id',$row['Department_Id'])->first();
                                             ?>
                                             <tr>
                                                <td><?= $startSerial++ ?></td>
                                                <td><?php echo date('d/m/Y H:i:s', strtotime($row['DateTime']))?></td>
                                                <td>
                                                   <?php 
                                                   if(!empty($row['Bill_Pic'])){ ?>
                                                   <a href="<?php echo base_url('public/vendors/PicUpload/'.$row['Bill_Pic']);?>" target="_blank">link</a>
                                                   <?php }?>
                                                </td>
                                                <td><?php echo $row['uid']; ?></td>
                                                <td><?php 
                                                   $Vendorrow= $PartyUserModelObj->where('id',$row['Vendor_Id'])->first();
                                                   if(isset($Vendorrow) && $Vendorrow!='')
                                                   {
                                                    echo $Vendorrow['Name']; 
                                                   }
                                                   ?></td>
                                                <td><?php echo $row['Bill_No']; ?></td>
                                                <td><?php echo $row['Bill_Amount']; ?></td>
                                                <td><?php echo   date('d/m/Y', strtotime($row['Bill_DateTime']))?></td>
                                                <td><?php 
                                                   $Unitrow= $UnitModelObj->where('id',$row['Unit_Id'])->first();
                                                   if(isset($Unitrow) && $Unitrow!='')
                                                   {
                                                    echo $Unitrow['name']; 
                                                   }
                                                   ?> 
                                                </td>
                                                <td><?php echo $row['Gate_Entry_No']; ?></td>
                                                <td>
                                                   <?php echo   date('d/m/Y', strtotime($row['Gate_Entry_Date']))?>
                                                </td>
                                                <td><?php 
                                                   $BillTyperow= $BillTypeModelObj->where('id',$row['Bill_Type'])->first();
                                                   if(isset($BillTyperow) && $BillTyperow!='')
                                                   {
                                                    echo $BillTyperow['name']; 
                                                   }
                                                   ?> 
                                                </td>
                                                <td><?php 
                                                   $Departmentrow2= $DepartmentModelObj->where('id',$row['Department_Id'])->first();
                                                   if(isset($Departmentrow2) && $Departmentrow2!='')
                                                   {
                                                    echo $Departmentrow2['name']; 
                                                   }
                                                   ?> </td>
                                                <td><?php 
                                                   $MappingEmprow= $EmployeeModelObj->where('id',$row['Department_Emp_Id'])->first();
                                                   if(isset($MappingEmprow) && $MappingEmprow!='')
                                                   {
                                                    echo $MappingEmprow['first_name']; 
                                                    echo " ".$MappingEmprow['last_name'];
                                                   }
                                                   ?> 
                                                </td>
                                                <td><?php echo $row['Bill_Acceptation_Status_Comments']; ?></td>
                                                <td><?php echo $row['Bill_Acceptation_DateTime']; ?></td>
                                                <td><?php echo $row['TargetMapping_Time_Hours']; ?></td>
                                                <td><?php echo $row['Mapping_Delay_On_Time']; ?></td>
                                                <td><?php echo $row['Mapping_Remark']; ?></td>
                                                <td><?php echo $row['Clear_Bill_Form_Status_Comments']; ?></td>
                                                <td><?php echo $row['Clear_Bill_Form_DateTime']; ?></td>
                                                <td><?php echo $row['TargetClearBillForm_Time_Hours']; ?></td>
                                                <td><?php echo $row['ClearBillForm_Delay_On_Time']; ?></td>
                                                <td>
                                                   <?php 
                                                   if(!empty($row['Clear_Bill_Form_AnyImage'])){ ?>
                                                   <a href="<?php echo base_url('public/vendors/PicUpload/'.$row['Clear_Bill_Form_AnyImage']);?>" target="_blank">link</a>
                                                   <?php } ?>
                                                </td>
                                                <td><?php echo $row['ClearBillForm_Remark']; ?></td>
                                                <?php
                                                   $MasterActionmadelObj = new MasterActionModel();
                                                   $rowMasterAction2= $MasterActionmadelObj->where('stage_id',3)->where('no_of_action',$row['ClearFormBill_Master_Action'])->first();
                                                   if(isset($rowMasterAction2) && $rowMasterAction2!='')
                                                   {
                                                     $rowMasterActionUpload= $MasterActionUploadModelObj->where('bill_id',$row['id'])->where('master_action_id',$rowMasterAction2['id'])->first();
                                                   }
                                                   
                                                   
                                                   
                                                   ?>
                                                <td><?php  if(isset($rowMasterAction2) && $rowMasterAction2!='') { echo $rowMasterAction2['action_name']; } ?></td>
                                                <td><a href="<?php if(isset($rowMasterActionUpload) && $rowMasterActionUpload!='') { if(!empty($rowMasterActionUpload['image_upload'])){ echo base_url('public/vendors/PicUploadMasterAction/'.$rowMasterActionUpload['image_upload']); }else{ }} ?>" target="_blank">link</a>
                                                </td>
                                                <td><?php if(isset($rowMasterActionUpload) && $rowMasterActionUpload!='') {  echo $rowMasterActionUpload['remark'];} ?></td>
                                                <td>
                                                   <?php 
                                                      $ERPEmprow= $EmployeeModelObj->where('id',$row['Mapping_ERP_EmpId'])->first();
                                                      if(isset($ERPEmprow) && $ERPEmprow!='')
                                                      {
                                                          echo $ERPEmprow['first_name']; 
                                                           echo " ".$ERPEmprow['last_name'];
                                                      }
                                                      ?>
                                                </td>
                                                <td><?php echo $row['ERP_Comment']; ?></td>
                                                <td><?php echo $row['ERP_DateTime']; ?></td>
                                                <td><?php echo $row['Target_ERP_Time_Hours']; ?></td>
                                                <td><?php echo $row['ERP_Delay_On_Time']; ?></td>
                                                <td>
                                                   <?php 
                                                   if(!empty($row['ERP_AnyImage'])){ ?>
                                                   <a href="<?php echo base_url('public/vendors/PicUpload/'.$row['ERP_AnyImage']);?>" target="_blank">link</a>
                                                   <?php } ?>
                                                </td>
                                                <td><?php echo $row['ERP_Remark']; ?></td>
                                                <?php
                                                   $MasterActionmadelObj = new MasterActionModel();
                                                   $rowMasterAction2= $MasterActionmadelObj->where('stage_id',4)->where('no_of_action',$row['ERP_Master_Action'])->first();
                                                   if(isset($rowMasterAction2) && $rowMasterAction2!='')
                                                   {
                                                   $rowMasterActionUpload= $MasterActionUploadModelObj->where('bill_id',$row['id'])->where('master_action_id',$rowMasterAction2['id'])->first();
                                                   }
                                                   
                                                   ?>
                                                <td><?php if(isset($rowMasterAction2) && $rowMasterAction2!='') { echo $rowMasterAction2['action_name']; }?></td>
                                                <td><a href="<?php if(isset($rowMasterActionUpload) && $rowMasterActionUpload!='') { if(!empty($rowMasterActionUpload['image_upload'])){ echo base_url('public/vendors/PicUploadMasterAction/'.$rowMasterActionUpload['image_upload']); }else{ }} ?>" target="_blank">link</a>
                                                </td>
                                                <td><?php  if(isset($rowMasterActionUpload) && $rowMasterActionUpload!='') { echo $rowMasterActionUpload['remark']; } ?></td>
                                                <td>
                                                   <?php 
                                                      $AcountEmprow= $EmployeeModelObj->where('id',$row['Mapping_Acount_EmpId'])->first();
                                                      if(isset($AcountEmprow) && $AcountEmprow!='')
                                                      {
                                                          echo $AcountEmprow['first_name']; 
                                                           echo " ".$AcountEmprow['last_name'];
                                                      }
                                                      ?>
                                                </td>
                                                <td><?php echo $row['Recived_Comment']; ?></td>
                                                <td><?php echo $row['Recived_DateTime']; ?></td>
                                                <td><?php echo $row['Recived_TragetTime_Hours']; ?></td>
                                                <td><?php echo $row['Recived_Delay_On_Time']; ?></td>
                                                <td>
                                                   <?php 
                                                   if(!empty($row['Recived_AnyImage'])){ ?>
                                                   <a href="<?php echo base_url('public/vendors/PicUpload/'.$row['Recived_AnyImage']);?>" target="_blank">link</a>
                                                   <?php } ?>
                                                </td>
                                                <td><?php echo $row['Recived_Remark']; ?></td>
                                                
                                                <?php
                                                   $MasterActionmadelObj = new MasterActionModel();
                                                   $rowMasterAction2= $MasterActionmadelObj->where('stage_id',5)->where('no_of_action',$row['Recived_Master_Action'])->first();
                                                   if(isset($rowMasterAction2) && $rowMasterAction2!='') {
                                                   $rowMasterActionUpload= $MasterActionUploadModelObj->where('bill_id',$row['id'])->where('master_action_id',$rowMasterAction2['id'])->first();
                                                   }
                                                   
                                                   ?>
                                                <td><?php if(isset($rowMasterAction2) && $rowMasterAction2!='') { echo $rowMasterAction2['action_name']; } ?></td>
                                                <td><a href="<?php if(isset($rowMasterActionUpload) && $rowMasterActionUpload!='') { if(!empty($rowMasterActionUpload['image_upload'])){ echo base_url('public/vendors/PicUploadMasterAction/'.$rowMasterActionUpload['image_upload']); }else{ }} ?>" target="_blank">link</a>
                                                </td>
                                                <td><?php if(isset($rowMasterActionUpload) && $rowMasterActionUpload!='') {echo $rowMasterActionUpload['remark']; }?></td>
                                                <td><?php echo $row['Vendor_Comment']; ?></td>
                                                <td>
                                                   <?php 
                                                   if(!empty($row['Vendor_Upload_Image'])){ ?>
                                                   <a href="<?php echo base_url('public/vendors/PicUpload/'.$row['Vendor_Upload_Image']);?>" target="_blank">link</a>
                                                   <?php } ?>
                                                </td>
                                                <td>
                                                   <?php 
                                                      if($row['Recived_Status']==1)
                                                              {
                                                              
                                                              ?>
                                                   <span class="span" data-toggle="modal" data-target="#bd-example-modal-lg-Status-<?php echo $row['id']; ?>"  style="color:blue"><i class="fa fa-eye"></i>Pending</span>
                                                   <?php
                                                      }
                                                      elseif($row['Recived_Status']==2)
                                                      {
                                                      
                                                      ?>
                                                   <span  class="span" data-toggle="modal" data-target="#bd-example-modal-lg-mappBill-<?php echo $row['id']; ?>" style="color:#d7c706"><i class="fa fa-eye"></i>Accepted </span>
                                                   <?php
                                                      }
                                                       elseif($row['Recived_Status']==3)
                                                      {
                                                          ?>
                                                   <span class="span" data-toggle="modal" data-target="#bd-example-modal-lg-Status-<?php echo $row['id']; ?>"  style="color:red"><i class="fa fa-eye"></i>Reject</span>
                                                   <?php
                                                      }
                                                      elseif($row['Recived_Status']==4)
                                                      {
                                                      
                                                      ?>
                                                   <span class="span" data-toggle="modal" data-target="#bd-example-modal-lg-mappBillView-<?php echo $row['id']; ?>" style="color:green"><i class="fa fa-eye"></i>Done</span>
                                                   <br>
                                                   <?php
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
                    
                        var rowData = [];
                        for (var j = 0; j < tableSelect.rows[i].cells.length; j++) {
                            rowData.push(tableSelect.rows[i].cells[j].innerText);
                        }
                        XLSX.utils.sheet_add_aoa(ws, [rowData], { origin: -1, skipHeader: true });
                    
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