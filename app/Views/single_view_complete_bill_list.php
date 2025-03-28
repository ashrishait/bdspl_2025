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
                  <div class="col-lg-12 grid-margin">
                      <div class="col-md-12 col-sm-12 List p-3">
                            <div class="row">
                                <div class="col-6">
                                   <h2>Completed Bill</h2>
                                </div>
                                <div class="col-6">
                                    <form method="post" action="<?php echo base_url('/index.php/barcodeuid');?>" class="float-end">
                                        <input type="hidden" name="companyid" id="companyid" class="form-control" value="<?php echo $compeny_id;?>" />
                                        <input type="text" name="enteruid" id="searchInput" placeholder="Scan Barcode Or Enter Bill UID" class="form-control"/>
                                        <!-- Suggestions dropdown -->
                                        <ul id="suggestionsList"></ul>
                                    </form>
                                </div>
                            </div>
                        </div>
                     <div class="card">
                        <div class="card-body cardbody p-1">
                           <div class="table-responsive">
                              <table class="table table-bordered table-hover">
                                 <thead>
                                    <tr>
                                       <th>#</th>
                                       <th><b>Bill Date Time</b></th>
                                       <th><b>Bill Pic </b></th>
                                       <th><b>Bill Id </b></th>
                                       <th><b>Vendor Name </b></th>
                                       <th><b>Bill No  </b></th>
                                       <th><b>Bill Amount</b></th>
                                       <th><b>Bill Date</b></th>
                                       <th><b>Unit Name  </b></th>
                                       <th><b>Gate Entry No </b></th>
                                       <th><b>Gate Entry Date</b></th>
                                       <th><b>Bill Type</b></th>
                                       <th><b>Department</b></th>
                                       <th><b>Mapping Employee Name</b></th>
                                       <th><b>Mapping Acceptation Comments</b></th>
                                       <th><b>Mapping Acceptation DateTime</b></th>
                                       <th><b>Mapping TargetTime</b></th>
                                       <th><b>Mapping Delay Or On-Time</b></th>
                                       <th><b>Mapping Remark</b></th>
                                       <th><b>Clear Bill Form Acceptation Comments</b></th>
                                       <th><b>Clear Bill Form Acceptation DateTime</b></th>
                                       <th><b>Clear Bill Form Target Time</b></th>
                                       <th><b>Clear Bill Form Delay Or On-Time</b></th>
                                       <th><b>Clear Bill Form Image</b></th>
                                       <th><b>Clear Bill Form Remark</b></th>
                                       <th><b>Clear Bill Form Master Action</b></th>
                                       <th><b>Clear Bill Form Master Action Image</b></th>
                                       <th><b>Clear Bill Form Master Action Remark</b></th>
                                       <th><b>ERP Employee</b></th>
                                       <th><b>ERP Acceptation Comments</b></th>
                                       <th><b>ERP Acceptation DateTime</b></th>
                                       <th><b>ERP TargetTime</b></th>
                                       <th><b>ERP Delay Or On-Time</b></th>
                                       <th><b>ERP Image</b></th>
                                       <th><b>ERP Remark</b></th>
                                       <th><b>ERP Master Action</b></th>
                                       <th><b> ERP Master Action Image</b></th>
                                       <th><b>ERP Master Action Remark</b></th>
                                       <th><b>Acount Employee</b></th>
                                       <th><b>Recived Acceptation Comments</b></th>
                                       <th><b>Recived Acceptation DateTime</b></th>
                                       <th><b>Recived TargetTime</b></th>
                                       <th><b>Recived Delay Or On-Time</b></th>
                                       <th><b>Recived Image</b></th>
                                       <th><b>Recived Remark</b></th>
                                       <th><b>Recived Master Action</b></th>
                                       <th><b> Recived Master Action Image</b></th>
                                       <th><b>Recived Master Action Remark</b></th>
                                       <th><b> Action </b></th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <?php 
                                       $result = $session->get();
                                       $etm = $result['ddn'];  
                                       $i=0+$etm;
                                       if(isset($dax)){
                                          foreach ($dax as $row){
                                             $i = $i+1;
                                             $Departmentrow= $DepartmentModelObj->where('id',$row['Department_Id'])->first();
                                             ?>
                                             <tr>
                                                <td><?php echo $i; ?></td>
                                                <td><?php echo   date('d-m-Y H:i:s', strtotime($row['DateTime']))?></td>
                                                <td>
                                                   <?php 
                                                   if(!empty($row['Bill_Pic'])){ ?>
                                                   <a href="<?php echo base_url('public/vendors/PicUpload/'.$row['Bill_Pic']);?>" target="_blank">link</a>
                                                   <?php } ?>
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
                                                <td><?php echo   date('d-m-Y', strtotime($row['Bill_DateTime']))?>
                                                </td>
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
                                                   <?php echo   date('d-m-Y', strtotime($row['Gate_Entry_Date']))?>
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
                                                <td><a href="<?php if(isset($rowMasterActionUpload) && $rowMasterActionUpload!='') { if($rowMasterActionUpload['image_upload']){ echo base_url('public/vendors/PicUploadMasterAction/'.$rowMasterActionUpload['image_upload']); }}?>" target="_blank">link</a> 
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
                                                <td><a href="<?php if(isset($rowMasterActionUpload) && $rowMasterActionUpload!='') { echo base_url('public/vendors/PicUploadMasterAction/'.$rowMasterActionUpload['image_upload']); }?>" target="_blank">link</a>
                                                </td>
                                                <td><?php if(isset($rowMasterActionUpload) && $rowMasterActionUpload!='') {echo $rowMasterActionUpload['remark']; }?></td>
                                                <td>
                                                   <?php 
                                                   if($Roll_id==1)
                                                   {
                                                      ?>
                                                      <a href="<?php echo base_url();?>/index.php/bill_edit/<?php echo $row['id']; ?>"><span class="mdi mdi-pen"></span></a>
                                                      <?php
                                                   }
                                                   ?>
                                                   <a href="<?php echo base_url();?>/index.php/complete-detail-of-sigle-bill/<?php echo $row['id']; ?>"><span class="mdi mdi-eye-circle"></span></a></td>
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
                              <!--  <?php if($session->get("ddn")>=20){ ?><a href="<?php echo base_url('/index.php/ddxm');?>" class="btn btn-sm btn-primary"> << previous</a>-----<?php } ?>
                                 <a href="<?php echo base_url('/index.php/ddx');?>" class="btn btn-sm btn-primary">next >></a>-->
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <?php include('include/footer.php')?>
      </div>
      <script>
         $(document).ready(function () {
             // Event listener for input changes
             $('#searchInput').on('input', function () {
                 var query = $(this).val();
                 var companyid = $('#companyid').val();
                 //alert(companyid);
                 // AJAX request to get suggestions
                 $.ajax({
                     url: '<?php echo base_url('/index.php/uidsuggestion'); ?>',
                     method: 'GET',
                     data: { query: query, companyid:companyid },
                     dataType: 'json',
                     success: function (data) {
                         displaySuggestions(data);
                     }
                 });
             });
         
             // Function to display suggestions
             function displaySuggestions(suggestions) {
                 var suggestionsList = $('#suggestionsList');
                 suggestionsList.empty();
         
                 $.each(suggestions, function (index, item) {
                     var listItem = $('<li><a href="<?php echo base_url('/index.php/sigle_bill_list'); ?>/' + item.id + '">' + item.uid + '</a></li>');
                     suggestionsList.append(listItem);
                 });
             }
         });
      </script>
   </body>
</html>