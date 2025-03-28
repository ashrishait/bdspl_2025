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
                                    <div class="col-md-6">
                                       <h2>Bill Verification List</h2>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <button type="button" class="btn btn-success float-end btn-lg" onclick="exportTableToExcel('myTable', 'table_export')">Export to Excel</button>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body cardbody p-1">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover" id="myTable">
                                            <thead>
                                                <tr>
                                                    <th class="bg-warning">#</th>
                                                    <th class="bg-warning"><b>Bill Pic</b></th>
                                                    <th class="bg-warning"><b>Bill Id </b></th>
                                                    <th class="bg-warning"><b>Vendor</b></th>
                                                    <th class="bg-warning"><b>Bill No</b></th>
                                                    <th class="bg-warning"><b>Bill Amount</b></th>
                                                    <th class="bg-warning"><b>Bill Date</b></th>
                                                    <th class="bg-warning"><b>Unit</b></th>
                                                    <th class="bg-warning"><b>Gate Entry No </b></th>
                                                    <th class="bg-warning"><b>Gate Entry Date</b></th>
                                                    <th class="bg-warning"><b>Assign By</b></th>
                                                    <th class="bg-warning"><b>Assign To</b></th>
                                                    <th class="bg-warning"><b>Assign Comment</b></th>
                                                    <th><b>Accept Date</b></th>
                                                    <th><b>Accept Comment</b></th>
                                                    <th><b>Master Action Comment</b></th>
                                                    <th><b>Master Action File</b></th>
                                                    <th><b>Send to next Comment</b></th>
                                                    <th><b>Send to next File</b></th>
                                                    <th><b>Vendor Comment</b></th>
                                                    <th><b>Vendor File</b></th>
                                                    <th><b>Action </b></th>
                                                </tr>
                                                <form method="get" action="<?php echo site_url('/all_Clear_Bill_Form_list'); ?>" enctype="multipart/form-data"> 
                                                    <tr>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th>
                                                            <select name="Vendor_Id" class="form-control" id="select-country" data-live-search="true" style="width:130px;" onchange="submit()"> 
                                                                <option value="">Select Vendor User</option>
                                                                <?php
                                                                    if(isset($dax14)){
                                                                    foreach ($dax14 as $row14){ ?>
                                                                        <option value="<?php echo $row14->id; ?>"><?php echo ucwords($row14->Name); ?></option>
                                                                <?php }} ?> 
                                                            </select>
                                                        </th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th>
                                                            <select name="Unit_Id" class="form-control" id="Unit_Id" style="width:130px" onchange="submit()">
                                                                <option value="">- Select Unit -</option>   
                                                                <?php
                                                                if(isset($dax15)){
                                                                    foreach ($dax15 as $row15){ ?>
                                                                        <option value="<?php echo $row15['id']; ?>"><?php echo ucwords($row15['name']); ?></option>
                                                                        <?php 
                                                                    }
                                                                } ?>        
                                                            </select>
                                                        </th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th>
                                                            <?php if($Roll_id==1){ ?>
                                                                <select name="assignedto" class="form-control" id="assignedto" style="width:130px" onchange="submit()">
                                                                    <option value="">- Select Assigned To -</option>
                                                                    <?php
                                                                    $rowe = $EmployeeModelObj->where('compeny_id', $compeny_id)->findAll();
                                                                    if(isset($rowe) && $rowe!='')
                                                                    {
                                                                        foreach ($rowe as $rowe)
                                                                        {   
                                                                            ?>
                                                                            <option value="<?php echo $rowe['id']; ?>"><?php echo ucwords($rowe['first_name']); ?></option>
                                                                            <?php
                                                                        }
                                                                    }
                                                                    ?>
                                                                </select>
                                                            <?php } ?>
                                                        </th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th>
                                                            <select name="Satus" class="form-control " style="width:130px"required onchange="submit()"> 
                                                                <option value="All" style="background:#065ca3;color:white;"> All </option>
                                                                <option value="1" style="background:#004784;color:white;"> Pending </option>
                                                                <option value="2"style="background:#dfbc11;color:white;"> Accepted </option>
                                                                <option value="3" style="background:#9b0606;color:white;"> Reject </option>
                                                                <option value="4" style="background:#1b7e09;color:white;"> Done </option>
                                                            </select>
                                                        </th>
                                                    </tr>
                                                </form>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                $stage_id=3;
                                                $result = $session->get();
                                                $etm = $result['ddn'];  
                                                $i=0+$etm;
                                                if(isset($dax)){
                                                    foreach ($dax as $row){
                                                        $i = $i+1;
                                                        $Departmentrow= $DepartmentModelObj->where('compeny_id', $compeny_id)->where('id',$row['Department_Id'])->first();
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $i; ?></td>
                                                            <td>
                                                            <?php 
                                                            if(!empty($row['Bill_Pic'])){ ?>
                                                                <a href="<?php echo base_url('public/vendors/PicUpload/'.$row['Bill_Pic']);?>" target="_blank">link</a>
                                                                <?php 
                                                            } ?>
                                                            </td>
                                                            <td><?php echo $row['uid']; ?></td>
                                                            <td><?php 
                                                                $Vendorrow= $PartyUserModelObj->where('id',$row['Vendor_Id'])->first();
                                                                if(isset($Vendorrow) && $Vendorrow!='')
                                                                {
                                                                    echo $Vendorrow['Name']; 
                                                                }
                                                                ?>
                                                            </td>
                                                            <td><?php echo $row['Bill_No']; ?></td>
                                                            <td><?php echo $row['Bill_Amount']; ?></td>
                                                            <td><?php echo   date('d-m-Y', strtotime($row['Bill_DateTime']))?></td>
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
                                                            <td> 
                                                            </td>
                                                            <td><?php 
                                                                $MappingEmprow= $EmployeeModelObj->where('id',$row['Department_Emp_Id'])->first();
                                                                if(isset($MappingEmprow) && $MappingEmprow!='')
                                                                {
                                                                    echo $MappingEmprow['first_name']; 
                                                                    echo " ".$MappingEmprow['last_name'];
                                                                }
                                                                ?> 
                                                            </td>
                                                            <td><?php echo $row['Mapping_Remark']; ?></td>
                                                            
                                                            <td><?php echo $row['Clear_Bill_Form_DateTime']; ?></td>
                                                            <td><?php echo $row['Clear_Bill_Form_Status_Comments']; ?></td>
                                                            <?php
                                                            $MasterActionmadelObj = new MasterActionModel();
                                                            $rowMasterAction2= $MasterActionmadelObj->where('compeny_id', $compeny_id)->where('stage_id',$stage_id)->where('no_of_action',$row['ClearFormBill_Master_Action'])->first();
                                                            if(isset($rowMasterAction2) && $rowMasterAction2!='')
                                                            {
                                                                $rowMasterActionUpload= $MasterActionUploadModelObj->where('compeny_id', $compeny_id)->where('bill_id',$row['id'])->where('master_action_id',$rowMasterAction2['id'])->first();
                                                            }
                                                            ?>
                                                            <td><?php if(isset($rowMasterActionUpload) && $rowMasterActionUpload!='') {  echo $rowMasterActionUpload['remark'];} ?></td>
                                                            <td><?php if(isset($rowMasterActionUpload) && $rowMasterActionUpload!='') { if(!empty($rowMasterActionUpload['image_upload'])){ ?><a href="<?php echo base_url('public/vendors/PicUploadMasterAction/'.$rowMasterActionUpload['image_upload']);?>" target="_blank">link</a><?php }else{ }} ?>
                                                            </td>
                                                            <td><?php echo $row['ClearBillForm_Remark']; ?></td>
                                                            <td>
                                                                <?php 
                                                                if(!empty($row['Clear_Bill_Form_AnyImage'])){ ?>
                                                                <a href="<?php echo base_url('public/vendors/PicUpload/'.$row['Clear_Bill_Form_AnyImage']);?>" target="_blank"><?php if(!empty($row['Clear_Bill_Form_AnyImage'])) { ?>link<?php } ?></a>
                                                                <?php } ?>
                                                            </td>
                                                            <td><?php echo $row['Vendor_Comment']; ?></td>
                                                            <td>
                                                            <?php 
                                                            if(!empty($row['Vendor_Upload_Image'])){ ?>
                                                                <a href="<?php echo base_url('public/vendors/PicUpload/'.$row['Vendor_Upload_Image']);?>" target="_blank"><?php if(!empty($row['Vendor_Upload_Image'])) { ?>link<?php } ?></a>
                                                            <?php } ?>
                                                            </td>
                                                            <td>
                                                            <?php 
                                                            if($row['Clear_Bill_Form_Status']==1)
                                                            {
                                                                ?>
                                                                   <span class="span text-primary" data-bs-toggle="modal" data-bs-target="#bd-example-modal-lg-Status-<?php echo $row['id']; ?>" title="Pending"><span class="mdi mdi-receipt-clock-outline"></span></span>
                                                                <?php
                                                            }
                                                            elseif($row['Clear_Bill_Form_Status']==2)
                                                            {
                                                                $MasterActionmadelObj = new MasterActionModel();
                                                                $rowMasterAction1= $MasterActionmadelObj->where('compeny_id', $compeny_id)->where('stage_id',$stage_id)->orderBy('id','desc')->first();
                                                                if(isset($rowMasterAction1) && $rowMasterAction1!='')
                                                                {
                                                                    if($rowMasterAction1['no_of_action']==$row['ClearFormBill_Master_Action'])
                                                                    {
                                                                        ?>
                                                                        <span class="span text-warning" data-bs-toggle="modal" data-bs-target="#bd-example-modal-lg-mappBill-<?php echo $row['id']; ?>" title="Accepted"><span class="mdi mdi-account-check-outline"></span></span>
                                                                        <?php
                                                                    }
                                                                    else
                                                                    {
                                                                        ?>
                                                                        <span class="span text-info" data-bs-toggle="modal" data-bs-target="#bd-example-modal-lg-MasterAction-<?php echo $row['id']; ?>" title="Action"><span class="mdi mdi-gesture-tap-button"></span></span>
                                                                        <?php
                                                                    }
                                                                }
                                                                else
                                                                {
                                                                    ?>
                                                                        <span class="span" style="color:#d7c706" data-bs-toggle="modal" data-bs-target="#bd-example-modal-lg-mappBill-<?php echo $row['id']; ?>" title="Accepted"><span class="mdi mdi-account-check-outline"></span></span>
                                                                    <?php
                                                                }
                                                            }
                                                            elseif($row['Clear_Bill_Form_Status']==3)
                                                            {
                                                                ?>
                                                                    <span class="span" style="color:red" data-bs-toggle="modal" data-bs-target="#bd-example-modal-lg-Status-<?php echo $row['id']; ?>" title="Rejected"><span class="mdi mdi-close-box-multiple"></span></span>
                                                                <?php
                                                            }
                                                            elseif($row['Clear_Bill_Form_Status']==4)
                                                            {
                                                                ?>
                                                                <span class="span text-success" data-bs-toggle="modal" data-bs-target="#bd-example-modal-lg-mappBillView-<?php echo $row['id']; ?>" title="Done"><span class="mdi mdi-check-all"></span></span>
                                                                <?php
                                                            }
                                                            ?>
                                                            <a href="<?php echo base_url();?>/index.php/complete-detail-of-sigle-bill/<?php echo $row['id']; ?>"><span class="mdi mdi-eye-circle"></span></a>
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
                                        <!-- <?php if($session->get("ddn")>=20){ ?><a href="<?php echo base_url('/index.php/ddxm');?>" class="btn btn-sm btn-primary"> << previous</a>-----<?php } ?>
                                        <a href="<?php echo base_url('/index.php/ddx');?>" class="btn btn-sm btn-primary">next >></a>-->
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