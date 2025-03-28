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
                        <div class="col-lg-12 grid-margin">
                            <div class="col-md-12 col-sm-12 List p-3">
                                <div class="row">
                                    <div class="col-6">
                                       <h2>Detail Of Bill</h2>
                                    </div>
                                    <div class="col-6">
                                        <button onclick="printDiv('contentToPrint')" class="btn btn-success float-end">Print</button>
                                    </div>
                                </div>
                            </div>
                            <div class="card" id="contentToPrint">
                                <div class="card-body cardbody p-1">
                                    <div class="table-responsive">
                                        <?php 
                                        $i=0;
                                        if(isset($dax)){
                                            foreach ($dax as $row){
                                            ?>
                                            <table class="table table-bordered table-hover">
                                                <tbody>
                                                    <tr>
                                                        <th>Bill Uid</th>
                                                        <td><?php echo $row['uid']?></td>
                                                        <th>Add By</th>
                                                        <td><?php 
                                                          $MappingEmprow= $EmployeeModelObj->where('id',$row['Add_By'])->first();
                                                          if(isset($MappingEmprow) && $MappingEmprow!='')
                                                          {
                                                           echo $MappingEmprow['first_name']; 
                                                           echo " ".$MappingEmprow['last_name'];
                                                          }
                                                          ?>
                                                        </td>
                                                    </tr>
                                                
                                                    <tr>
                                                        <th>Uid Create Date</th>
                                                        <td><?php echo $row['DateTime']?></td>
                                                        <th>Vendor Name</th>
                                                        <td><?php 
                                                        $Vendorrow= $PartyUserModelObj->where('id',$row['Vendor_Id'])->first();
                                                        if(isset($Vendorrow) && $Vendorrow!='')
                                                        {
                                                           echo $Vendorrow['Name']; 
                                                        }
                                                        ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th><b>Invoice No</th>
                                                        <td><?php echo $row['Bill_No']; ?></td>
                                                        <th>Invoice Link</th>
                                                        <td>
                                                            <?php if(!empty($row['Bill_Pic'])){ ?>
                                                            <a href="<?php echo base_url('public/vendors/PicUpload/'.$row['Bill_Pic']);?>" target="_blank">link</a>
                                                            <?php } ?>
                                                        </td>    
                                                    </tr>
                                                    <tr>
                                                        <th><b>Invoice Date</th>
                                                        <td><?php echo date('d-m-Y', strtotime($row['Bill_DateTime']))?></td>
                                                        <th>Remark</th>
                                                        <td><?php echo $row['Remark']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th><b>Invoice Amount</th>
                                                        <td colspan="6"><?php echo $row['Bill_Amount']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th colspan="6"><h3 class="text-center p-3 text-danger"><strong>Bill Assign</strong></h3></th>
                                                    </tr>    
                                                    <tr>
                                                        <th>Name</th>
                                                        <td><?php 
                                                          $MappingEmprow= $EmployeeModelObj->where('id',$row['Department_Emp_Id'])->first();
                                                          if(isset($MappingEmprow) && $MappingEmprow!='')
                                                          {
                                                           echo $MappingEmprow['first_name']; 
                                                           echo " ".$MappingEmprow['last_name'];
                                                          }
                                                          ?>
                                                        </td>
                                                        <th><b>Accept Date</th>
                                                        <td><?php echo $row['Bill_Acceptation_DateTime']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th><b>Remark</b></th>
                                                        <td colspan="3"><?php echo $row['Bill_Acceptation_Status_Comments']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th><b>Forward Remark</b></th>
                                                        <td colspan="3"><?php echo $row['Mapping_Remark'];?></td>
                                                    </tr>
                                                    <tr>
                                                        <th colspan="6"><h3 class="text-center p-3 text-danger"><strong>Bill Verify</strong></h3> </th>
                                                    </tr>    
                                                    <tr>
                                                        <th><b>Name</b></th>
                                                        <td><?php 
                                                          $MappingEmprow= $EmployeeModelObj->where('id',$row['Department_Emp_Id'])->first();
                                                          if(isset($MappingEmprow) && $MappingEmprow!='')
                                                          {
                                                           echo $MappingEmprow['first_name']; 
                                                           echo " ".$MappingEmprow['last_name'];
                                                          }
                                                          ?></td>
                                                        <th><b>Accept Date</b></th>
                                                        <td><?php echo $row['Clear_Bill_Form_DateTime'];?></td>
                                                    </tr>
                                                    <tr>
                                                        <th><b>Remark</b></th>
                                                        <td colspan="5"><?php echo $row['Clear_Bill_Form_Status_Comments'];?></td>
                                                    </tr>
                                                    <?php
                                                    $MasterActionmadelObj = new MasterActionModel();
                                                    $rowMasterAction2= $MasterActionmadelObj->where('stage_id',3)->where('no_of_action',$row['ClearFormBill_Master_Action'])->where('compeny_id',$row['compeny_id'])->first();
                                                    if(isset($rowMasterAction2) && $rowMasterAction2!='')
                                                    {
                                                        $rowMasterActionUpload= $MasterActionUploadModelObj->where('bill_id',$row['id'])->where('master_action_id',$rowMasterAction2['id'])->where('master_action_id',$rowMasterAction2['id'])->first();
                                                        if(isset($rowMasterActionUpload) && $rowMasterActionUpload!='')
                                                        { ?>
                                                            <tr>
                                                                <th><b>Verify Date</b></th>
                                                                <td><?php echo $rowMasterActionUpload['rec_time_stamp'];?></td>
                                                                <th><b>Report Link</b></th>
                                                                <td>
                                                                    <?php 
                                                                    if(!empty($rowMasterActionUpload['image_upload'])){ ?>
                                                                    <a href="<?php echo base_url('public/vendors/PicUploadMasterAction/'.$rowMasterActionUpload['image_upload']); ?>" target="_blank">link</a>
                                                                    <?php } ?>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th><b>Remark</b></th>
                                                                <td colspan="5"><?php echo $rowMasterActionUpload['remark'];?></td>
                                                            </tr>
                                                        <?php }
                                                        
                                                    }
                                                    ?>
                                                    
                                                    <tr>
                                                        <th><b>Remark</b></th>
                                                        <td><?php echo $row['ClearBillForm_Remark'];?></td>
                                                        <th><b>Sent Image</b></th>
                                                            <td><?php 
                                                                if(!empty($row['Clear_Bill_Form_AnyImage'])){ ?>
                                                                <a href="<?php echo base_url('public/vendors/PicUpload/'.$row['Clear_Bill_Form_AnyImage']);?>" target="_blank"><?php if(!empty($row['Clear_Bill_Form_AnyImage'])) { ?>link<?php } ?></a>
                                                                <?php } ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th colspan="6"><h3 class="text-center p-3 text-danger"><strong>EDP System</strong></h3></th>
                                                    </tr>    
                                                    <tr>
                                                        <th><b>Name</b></th>
                                                        <td><?php 
                                                         $ERPEmprow= $EmployeeModelObj->where('id',$row['Mapping_ERP_EmpId'])->first();
                                                         if(isset($ERPEmprow) && $ERPEmprow!='')
                                                         {
                                                             echo $ERPEmprow['first_name']; 
                                                              echo " ".$ERPEmprow['last_name'];
                                                         }
                                                         ?></td>
                                                        <th><b>Accept Date</b></th>
                                                        <td><?php echo $row['ERP_DateTime'];?></td>
                                                    </tr>
                                                    <tr>
                                                        <th><b>Remark</b></th>
                                                        <td colspan="3"><?php echo $row['ERP_Comment'];?></td>
                                                    </tr>
                                                    <?php
                                                    $MasterActionmadelObj = new MasterActionModel();
                                                    $rowMasterAction3= $MasterActionmadelObj->where('stage_id',4)->where('no_of_action',$row['ERP_Master_Action'])->where('compeny_id',$row['compeny_id'])->first();
                                                    if(isset($rowMasterAction3) && $rowMasterAction3!='')
                                                    {
                                                        $rowMasterActionUpload1= $MasterActionUploadModelObj->where('bill_id',$row['id'])->where('master_action_id',$rowMasterAction3['id'])->first();
                                                        if(isset($rowMasterActionUpload1) && $rowMasterActionUpload1!='')
                                                        { ?>
                                                        <tr>
                                                            <th><b>Entry Date</b></th>
                                                            <td><?php echo $rowMasterActionUpload1['rec_time_stamp']; ?></td>
                                                            <th><b>Report Link</b></th>
                                                            <td>    
                                                                <?php 
                                                                if(!empty($rowMasterActionUpload1['image_upload'])){ ?>
                                                                <a href="<?php echo base_url('public/vendors/PicUploadMasterAction/'.$rowMasterActionUpload1['image_upload']); ?>" target="_blank">link</a>
                                                                <?php } ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th><b>Remark</b></th>
                                                            <td colspan="3"><?php echo $rowMasterActionUpload1['remark'];?></td>
                                                        </tr>
                                                        <?php }
                                                    }
                                                    ?>
                                                    <tr>
                                                        <th><b>Sent Remark</b></th>
                                                        <td><?php echo $row['ERP_Remark']; ?></td>
                                                        <th><b>Sent Image</b></th>
                                                        <td><?php 
                                                            if(!empty($row['ERP_AnyImage'])){ ?>
                                                            <a href="<?php echo base_url('public/vendors/PicUpload/'.$row['ERP_AnyImage']);?>" target="_blank"><?php if(!empty($row['ERP_AnyImage'])) { ?>link<?php } ?></a>
                                                            <?php } ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th colspan="6"><h3 class="text-center p-3 text-danger"><strong>Account</strong></h3> </th>
                                                    </tr>      
                                                    <tr>
                                                        <th><b>Name</b></th>
                                                        <td><?php 
                                                         $ERPEmprow= $EmployeeModelObj->where('id',$row['Mapping_Acount_EmpId'])->first();
                                                         if(isset($ERPEmprow) && $ERPEmprow!='')
                                                         {
                                                             echo $ERPEmprow['first_name']; 
                                                              echo " ".$ERPEmprow['last_name'];
                                                         }
                                                         ?></td>
                                                        <th><b>Accept Date</b></th>
                                                        <td><?php echo $row['Recived_DateTime'];?></td>
                                                    </tr>
                                                    <tr>
                                                        <th><b>Remark</b></th>
                                                        <td colspan="3"><?php echo $row['Recived_Comment'];?></td>
                                                    </tr>
                                                    <?php
                                                    $MasterActionmadelObj = new MasterActionModel();
                                                    $rowMasterAction4= $MasterActionmadelObj->where('stage_id',5)->where('no_of_action',$row['Recived_Master_Action'])->where('compeny_id',$row['compeny_id'])->first();
                                                    if(isset($rowMasterAction4) && $rowMasterAction4!='')
                                                    {
                                                        $rowMasterActionUpload2= $MasterActionUploadModelObj->where('bill_id',$row['id'])->where('master_action_id',$rowMasterAction4['id'])->first();
                                                        if(isset($rowMasterActionUpload2) && $rowMasterActionUpload2!='')
                                                        { ?>
                                                        <tr>
                                                            <th><b>Received Date</b></th>
                                                            <td><?php echo $rowMasterActionUpload2['rec_time_stamp'];?></td>
                                                            <th><b>Report Link</b></th>
                                                            <td>
                                                                <?php 
                                                                if(!empty($rowMasterActionUpload2['image_upload'])){ ?>
                                                                <a href="<?php echo base_url('public/vendors/PicUploadMasterAction/'.$rowMasterActionUpload2['image_upload']); ?>" target="_blank">link</a>
                                                                <?php } ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th><b>Remark</b></th>
                                                            <td colspan="3"><?php echo $rowMasterActionUpload2['remark'];?></td>
                                                        </tr>
                                                        <?php } 
                                                    }?>
                                                    <tr>
                                                        <th><b>Sent Remark</b></th>
                                                        <td><?php echo $row['Recived_Remark']; ?></td>
                                                        <th><b>Sent Image</b></th>
                                                        <td><?php 
                                                            if(!empty($row['Recived_AnyImage'])){ ?>
                                                            <a href="<?php echo base_url('public/vendors/PicUpload/'.$row['Recived_AnyImage']);?>" target="_blank"><?php if(!empty($row['Recived_AnyImage'])) { ?>link<?php } ?></a>
                                                            <?php } ?></td>
                                                    </tr>
                                                    <?php 
                                                } 
                                            } 
                                            ?>
                                            </tbody>
                                        </table>
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