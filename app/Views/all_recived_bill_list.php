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
                            <div class="col-md-12 col-sm-12"> 
                                <?php
                                if(session()->has("Mapping_RecivedBill"))
                                {   
                                    if(session("Mapping_RecivedBill")==1)   
                                    {  
                                        echo "<div class='alert alert-success' role='alert'>Recived Bill Successfully. </div>";
                                    }
                                    elseif(session("Mapping_RecivedBill")==2)   
                                    {  
                                        echo "<div class='alert alert-success' role='alert'>Bill already received</div>";
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
                                        echo "<div class='alert alert-danger' role='alert'>Bill already accepted</div>";   
                                    }
                                }
                                if(session()->has("Master_Action_SMS"))
                                {   
                                    if(session("Master_Action_SMS")==1)   
                                    {  
                                        echo "<div class='alert alert-success' role='alert'>Successfully Added Master Action. </div>";
                                    }
                                    if(session("Master_Action_SMS")==2)   
                                    {  
                                        echo "<div class='alert alert-danger' role='alert'>Master Action Already Added</div>";
                                    }
                                    else{
                                        echo "<div class='alert alert-danger' role='alert'>Master Action Not Added</div>";   
                                    }
                                }
                                ?>    
                            </div>
                        </div>    
                        <div class="col-md-12 col-sm-12 List p-3">
                            <div class="row">
                                <div class="col-md-10">
                                    <form method="get" action="<?php echo site_url('/all_recived_bill_list'); ?>" enctype="multipart/form-data"> 
                                        <div class="row">
                                            <div class="col-md-3 col-sm-3">
                                                <select name="Vendor_Id" class="form-control" id="select-country" data-live-search="true" style="padding: 0.9rem 1.375rem; outline: 0px solid #f1f6f8;" onchange="submit()"> 
                                                    <option value="">Select Vendor User</option>
                                                    <?php
                                                    if(isset($dax14)){
                                                        foreach ($dax14 as $row14){ 
                                                            $selected = ($row14->id == @$_GET['Vendor_Id']) ? 'selected' : '';
                                                            ?>
                                                            <option value="<?php echo $row14->id; ?>" <?php echo $selected; ?>><?php echo ucwords($row14->Name); ?></option>
                                                        <?php 
                                                        }
                                                    } ?> 
                                                </select>  
                                            </div>  
                                            <div class="col-md-3 col-sm-3">
                                                <select name="Unit_Id" class="form-control" id="Unit_Id" style="padding: 0.9rem 1.375rem; outline: 0px solid #f1f6f8;" onchange="submit()">
                                                    <option value="">- Select Unit -</option>   
                                                    <?php
                                                    if(isset($dax15)){
                                                        foreach ($dax15 as $row15){ 
                                                            $selected = ($row15['id'] == @$_GET['Unit_Id']) ? 'selected' : '';
                                                            ?>
                                                            <option value="<?php echo $row15['id']; ?>" <?php echo $selected; ?>><?php echo ucwords($row15['name']); ?></option>
                                                            <?php 
                                                        }
                                                    } ?>        
                                                </select>
                                            </div>
                                            <div class="col-md-3 col-sm-3">
                                                <select name="assignedto" class="form-control filterserach" id="assignedto" onchange="submit()" style="padding: 0.9rem 1.375rem; outline: 0px solid #f1f6f8;">
                                                    <option value="">- Select Send By -</option>
                                                    <?php
                                                    $rowe = $EmployeeModelObj->where('compeny_id', $compeny_id)->orderBy('first_name', 'ASC')->findAll();
                                                    if(isset($rowe) && $rowe!='')
                                                    {
                                                        foreach ($rowe as $rowe)
                                                        {   
                                                            $selected = ($rowe['id'] == @$_GET['assignedto']) ? 'selected' : '';
                                                            ?>
                                                            <option value="<?php echo $rowe['id']; ?>" <?php echo $selected; ?>><?php echo ucwords($rowe['first_name']); ?> <?php echo ucwords($rowe['last_name']); ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-md-3 col-sm-3">
                                                <select name="Satus" class="form-control" style="padding: 0.9rem 1.375rem; outline: 0px solid #f1f6f8;" required onchange="submit()"> 
                                                    <option value="">- Select Status -</option>
                                                    <option value="All" style="background:#065ca3;color:white;" <?php echo @$_GET['Satus'] === 'All' ? 'selected' : ''; ?>> All </option>
                                                    <option value="1" style="background:#004784;color:white;" <?php echo @$_GET['Satus'] === '1' ? 'selected' : ''; ?>> Pending </option>
                                                    <option value="2" style="background:#dfbc11;color:white;" <?php echo @$_GET['Satus'] === '2' ? 'selected' : ''; ?>> Accepted </option>
                                                    <option value="3" style="background:#9b0606;color:white;" <?php echo @$_GET['Satus'] === '3' ? 'selected' : ''; ?>> Reject </option>
                                                    <option value="4" style="background:#1b7e09;color:white;" <?php echo @$_GET['Satus'] === '4' ? 'selected' : ''; ?>> Done </option>
                                                </select>
                                            </div>
                                        </div>    
                                    </form>
                                </div>    
                                <div class="col-md-2">
                                    <form method="post" action="<?php echo base_url('/index.php/barcodeuid');?>">
                                        <input type="hidden" name="companyid" id="companyid" class="form-control" value="<?php echo $compeny_id;?>" />
                                        <input type="text" name="enteruid" id="searchInput" placeholder="Scan Barcode Or Enter Bill UID" class="form-control"  style="padding: 0.78rem 1.375rem; outline: 0px solid #f1f6f8;"/>
                                        <!-- Suggestions dropdown -->
                                        <ul id="suggestionsList"></ul>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <br> 
                        <div class="col-lg-12 grid-margin">
                            <div class="col-md-12 col-sm-12 List p-3">
                                <div class="row">
                                    <div class="col-md-5">
                                       <h2>Bill Received at Account</h2>
                                    </div>
                                    <div class="col-md-2">
                                     
                                    </div>
                                    <div class="col-md-5">
                                        <!-- <button type="button" class="btn btn-success float-end btn-lg" onclick="exportTableToExcel('myTable', 'table_export')">Export to Excel</button> -->
                                        <a href="<?php echo base_url('/index.php/export_all_recived_bill_list'); ?>"  class="btn btn-danger float-end btn-lg">Excel Export</a>
                                        <?php
                                        if($ViewOnly==1)
                                        { }
                                        else{
                                            ?>
                                            <button type="button" class="btn btn-success float-end btn-lg me-2" data-bs-toggle="modal" data-bs-target="#completebill">
                                                Complete Bill
                                            </button>
                                            <button type="button" class="btn btn-warning float-end btn-lg me-2" data-bs-toggle="modal" data-bs-target="#masteractionModal">
                                                Master Action
                                            </button>
                                            <button type="button" class="btn btn-primary float-end btn-lg me-2" data-bs-toggle="modal" data-bs-target="#billacceptModal">
                                                Accept Bill
                                            </button>
                                        <?php } ?>    
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body cardbody p-1">
                                    <div class="table-responsive tableFixHead">
                                        <table class="table table-bordered table-hover" id="myTable">
                                            <thead>
                                                <tr>
                                                    <th class="bg-warning">#</th>
                                                    <th class="bg-warning"><b>Bill Pic</b></th>
                                                    <th class="bg-warning"><b>Bill Id </b></th>
                                                    <th class="bg-warning"><b>Type </b></th>
                                                    <th class="bg-warning"><b>Vendor</b></th>
                                                    <th class="bg-warning"><b>Bill No</b></th>
                                                    <th class="bg-warning"><b>Amount</b></th>
                                                    <th class="bg-warning"><b>Bill Date</b></th>
                                                    <th class="bg-warning"><b>Unit</b></th>
                                                    <th class="bg-warning"><b>Gate No </b></th>
                                                    <th class="bg-warning"><b>Gate Entry Date</b></th>
                                                    <th class="bg-warning"><b>Send By</b></th>
                                                    <th class="bg-warning"><b>Sender comment</b></th>
                                                    <th class="bg-warning"><b>Sender file</b></th>
                                                    <th class="bg-white"><b>Accept Date</b></th>
                                                    <th class="bg-white"><b>Accept Comment</b></th>
                                                    <th class="bg-white"><b>Master Action Comment</b></th>
                                                    <th class="bg-white"><b>Master Action File</b></th>
                                                    <th class="bg-white"><b>Completed Comment</b></th>
                                                    <th class="bg-white"><b>Completed File</b></th>
                                                    <th class="bg-white"><b>Vendor Comment</b></th>
                                                    <th class="bg-white"><b>Vendor File</b></th>
                                                    <th class="bg-white"><b>Action</b></th>
                                                </tr>
                                                
                                            </thead>
                                            <tbody>
                                            <?php 
                                            $stage_id=5;
                                            $result = $session->get();
                                            if(isset($users)){
                                                foreach ($users as $index => $row){
                                                    $Departmentrow= $DepartmentModelObj->where('compeny_id', $compeny_id)->where('id',$row['Department_Id'])->first();
                                                    ?>
                                                    <tr>
                                                        <td><?= $startSerial++ ?></td>
                                                        <td>
                                                            <?php 
                                                            if(!empty($row['Bill_Pic'])){ ?>
                                                            <a href="<?php echo base_url('public/vendors/PicUpload/'.$row['Bill_Pic']);?>" target="_blank">link</a>
                                                            <?php } ?>
                                                        </td>
                                                        <td><?php echo $row['uid']; ?></td>
                                                        <td>
                                                            <?php 
                                                            $billtyperow= $BillTypeModelObj->where('id',$row['Bill_Type'])->first();
                                                            if(isset($billtyperow) && $billtyperow!='')
                                                            {
                                                                echo $billtyperow['name']; 
                                                            }
                                                            ?> 
                                                        </td>
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
                                                        <td><?php 
                                                            $erpEmprow= $EmployeeModelObj->where('id',$row['Mapping_ERP_EmpId'])->first();
                                                            if(isset($erpEmprow) && $erpEmprow!='')
                                                            {
                                                                echo $erpEmprow['first_name']; 
                                                                echo " ".$erpEmprow['last_name'];
                                                            }
                                                            ?>  
                                                        </td>
                                                        <td><?php echo $row['ERP_Remark']; ?></td>
                                                        <td>
                                                            <?php 
                                                            if(!empty($row['ERP_AnyImage'])){ ?>
                                                            <a href="<?php echo base_url('public/vendors/PicUpload/'.$row['ERP_AnyImage']);?>" target="_blank"><?php if(!empty($row['ERP_AnyImage'])) { ?>link<?php } ?></a>
                                                            <?php } ?>
                                                        </td>
                                                        <td><?php echo $row['Recived_DateTime']; ?></td>
                                                        <td><?php echo $row['Recived_Comment']; ?></td>
                                                        <?php
                                                        $MasterActionmadelObj = new MasterActionModel();
                                                        $rowMasterAction2= $MasterActionmadelObj->where('compeny_id', $compeny_id)->where('stage_id',$stage_id)->where('no_of_action',$row['Recived_Master_Action'])->first();
                                                        if(isset($rowMasterAction2) && $rowMasterAction2!='') {
                                                            $rowMasterActionUpload= $MasterActionUploadModelObj->where('compeny_id', $compeny_id)->where('bill_id',$row['id'])->where('master_action_id',$rowMasterAction2['id'])->first();
                                                            ?>
                                                            <td><?php if(isset($rowMasterActionUpload) && $rowMasterActionUpload!='') {echo $rowMasterActionUpload['remark']; }?></td>
                                                            <td>
                                                                <?php 
                                                                if(isset($rowMasterActionUpload) && $rowMasterActionUpload!='') { 
                                                                    if(!empty($rowMasterActionUpload['image_upload'])){ ?>
                                                                        <a href="<?php echo base_url('public/vendors/PicUploadMasterAction/'.$rowMasterActionUpload['image_upload']);?>" target="_blank">link</a>
                                                                        <?php 
                                                                    }
                                                                    else{ }
                                                                } ?>
                                                            </td>
                                                        <?php }
                                                        else{ ?>
                                                            <td></td>
                                                            <td></td>
                                                        <?php }
                                                        ?>
                                                        
                                                        
                                                        <td><?php echo $row['Recived_Remark']; ?></td>
                                                        <td>
                                                            <?php 
                                                            if(!empty($row['Recived_AnyImage'])){ ?>
                                                            <a href="<?php echo base_url('public/vendors/PicUpload/'.$row['Recived_AnyImage']);?>" target="_blank"><?php if(!empty($row['Recived_AnyImage'])) { ?>link<?php } ?></a>
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
                                                            if($ViewOnly==1)
                                                            {
                                                                if($row['Recived_Status']==1)
                                                                {
                                                                    ?>
                                                                    <span class="span text-primary"  title="Pending"><span class="mdi mdi-receipt-clock-outline"></span></span>
                                                                    <?php
                                                                }
                                                                elseif($row['Recived_Status']==2)
                                                                {
                                                                    $MasterActionmadelObj = new MasterActionModel();
                                                                    $rowMasterAction1= $MasterActionmadelObj->where('compeny_id', $compeny_id)->where('stage_id',$stage_id)->orderBy('id','desc')->first();
                                                                    if(isset($rowMasterAction1) && $rowMasterAction1!='')
                                                                    {
                                                                        if($rowMasterAction1['no_of_action']==$row['Recived_Master_Action'])
                                                                        {
                                                                            ?>
                                                                            <span class="span text-warning"  title="Accepted"><span class="mdi mdi-account-check-outline"></span></span>
                                                                            <?php
                                                                        }
                                                                        else
                                                                        {
                                                                            ?>
                                                                            <span class="span text-info"  title="Action"><span class="mdi mdi-gesture-tap-button"></span></span>
                                                                            <?php
                                                                        }
                                                                    }
                                                                    else{
                                                                        ?>
                                                                        <span  class="span text-warning"  title="Accepted"><span class="mdi mdi-account-check-outline"></span></span>
                                                                       <?php
                                                                    }
                                                                }
                                                                elseif($row['Recived_Status']==3)
                                                                {
                                                                    ?>
                                                                    <span class="span text-danger"  title="Rejected"><span class="mdi mdi-close-box-multiple"></span></span>
                                                                    <?php
                                                                }
                                                                elseif($row['Recived_Status']==4)
                                                                {
                                                                    ?>
                                                                    <span class="span text-success" ><span class="mdi mdi-check-all"></span></span>
                                                                    <?php
                                                                }
                                                            }
                                                            else {
                                                                if($row['Recived_Status']==1)
                                                                {
                                                                    ?>
                                                                    <span class="span text-primary" data-bs-toggle="modal" data-bs-target="#bd-example-modal-lg-Status-<?php echo $row['id']; ?>" title="Pending"><span class="mdi mdi-receipt-clock-outline"></span></span>
                                                                    <?php
                                                                }
                                                                elseif($row['Recived_Status']==2)
                                                                {
                                                                    $MasterActionmadelObj = new MasterActionModel();
                                                                    $rowMasterAction1= $MasterActionmadelObj->where('compeny_id', $compeny_id)->where('stage_id',$stage_id)->orderBy('id','desc')->first();
                                                                    if(isset($rowMasterAction1) && $rowMasterAction1!='')
                                                                    {
                                                                        if($rowMasterAction1['no_of_action']==$row['Recived_Master_Action'])
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
                                                                    else{
                                                                        ?>
                                                                        <span  class="span text-warning" data-bs-toggle="modal" data-bs-target="#bd-example-modal-lg-mappBill-<?php echo $row['id']; ?>" title="Accepted"><span class="mdi mdi-account-check-outline"></span></span>
                                                                       <?php
                                                                    }
                                                                }
                                                                elseif($row['Recived_Status']==3)
                                                                {
                                                                    ?>
                                                                    <span class="span text-danger" data-bs-toggle="modal" data-bs-target="#bd-example-modal-lg-Status-<?php echo $row['id']; ?>" title="Rejected"><span class="mdi mdi-close-box-multiple"></span></span>
                                                                    <?php
                                                                }
                                                                elseif($row['Recived_Status']==4)
                                                                {
                                                                    ?>
                                                                    <span class="span text-success" data-bs-toggle="modal" data-bs-target="#bd-example-modal-lg-mappBillView-<?php echo $row['id']; ?>"><span class="mdi mdi-check-all"></span></span>
                                                                    <?php
                                                                }
                                                            }
                                                            ?>
                                                            <a href="<?php echo base_url();?>/index.php/complete-detail-of-sigle-bill/<?php echo $row['id']; ?>"><span class="mdi mdi-eye-circle"></span></a>
                                                        </td>
                                                    </tr> 
                                                    <div class="modal fade bs-example-modal-lg" id="bd-example-modal-lg-MasterAction-<?php echo $row['id']; ?>" tabindex="<?php echo $row['id']; ?>" role="dialog" aria-labelledby="bd-example-modal-lg-del-<?php echo $row['id']; ?>" aria-hidden="true">
                                                        <div class="modal-dialog modal-lg modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header bg-info">
                                                                    <h4 class="modal-title text-white" id="myLargeModalLabel">Action !</h4>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="">
                                                                        <div class="row">   
                                                                            <form method="post" action="<?php echo site_url('/MasterAction_send'); ?>" enctype="multipart/form-data">
                                                                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                                                                <input type="hidden" name="stage_id" value="<?php echo $stage_id; ?>">
                                                                                <input type="hidden" name="action" value="all">
                                                                                <div class="col-sm-12 col-md-6">
                                                                                    <div class="form-group">
                                                                                        <label>Master Action</label>
                                                                                        <select name="Master_ActionId" class="form-control "style="padding: 0.875rem 1.375rem" >
                                                                                            <?php
                                                                                            if($row['Recived_Master_Action']=='')
                                                                                            {
                                                                                                $no_of_action=0;
                                                                                            }
                                                                                            else
                                                                                            {
                                                                                                $no_of_action=$row['Recived_Master_Action']+0;
                                                                                            }
                                                                                            $MasterActionmadelObj = new MasterActionModel();                           
                                                                                            $rowMasterAction = $MasterActionmadelObj->where('compeny_id', $compeny_id)->where('stage_id',$stage_id)->where('no_of_action>',$no_of_action)->findAll();
                                                                                            if(isset($rowMasterAction) && $rowMasterAction!='')
                                                                                            {
                                                                                                foreach ($rowMasterAction as $rowMasterAction)
                                                                                                { 
                                                                                                    ?>
                                                                                                    <option value="<?php echo $rowMasterAction['id']; ?>" ><?php echo ucwords($rowMasterAction['action_name']); ?></option>
                                                                                                    <?php
                                                                                                }
                                                                                            }
                                                                                            ?>
                                                                                        </select>
                                                                                    </div> 
                                                                                </div>
                                                                                <div class="col-sm-12 col-md-6">
                                                                                    <div class="form-group">
                                                                                        <label for="billpic" >Upload AnyImage<span style="color:red;"></span></label>
                                                                                        <input class="form-control" type="file" name="E_Image"  >
                                                                                    </div> 
                                                                                </div>  
                                                                                <div class="col-sm-12 col-md-6">
                                                                                    <div class="form-group">
                                                                                        <label for="billpic" >Remark<span style="color:red;"></span></label>
                                                                                        <input class="form-control" type="text" name="remark"  >
                                                                                    </div> 
                                                                                </div> 
                                                                                <div class="col-sm-12 col-md-12">
                                                                                    <button type="submit" class="btn btn-info">Submit</button>
                                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal fade bs-example-modal-lg" id="bd-example-modal-lg-mappBillView-<?php echo $row['id']; ?>" tabindex="<?php echo $row['id']; ?>" role="dialog" aria-labelledby="bd-example-modal-lg-del-<?php echo $row['id']; ?>" aria-hidden="true">
                                                        <div class="modal-dialog modal-lg modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header bg-success">
                                                                    <h4 class="modal-title text-white" id="myLargeModalLabel">View!</h4>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="">
                                                                        <div class="row">   
                                                                            <form method="post" action="<?php echo site_url('/CheckUp_RecivedBill'); ?>" enctype="multipart/form-data">
                                                                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                                                                <div class="col-sm-12 col-md-6">
                                                                                    <div class="form-group">
                                                                                        <label> TargetTime Recived Bill</label>
                                                                                        <input type="text" name="Recived_TragetTime_Hours" class="form-control "style="padding: 0.875rem 1.375rem" value="<?php echo $row['Recived_TragetTime_Hours']; ?>" readonly > 
                                                                                    </div> 
                                                                                </div>
                                                                                <div class="col-sm-12 col-md-6">
                                                                                    <div class="form-group">
                                                                                        <label> Actual Date & Time</label>
                                                                                        <input type="text" name="" class="form-control "style="padding: 0.875rem 1.375rem" value="<?php echo $row['DateTime']; ?>" readonly > 
                                                                                    </div> 
                                                                                </div>
                                                                                <div class="col-sm-12 col-md-6">
                                                                                    <div class="form-group">
                                                                                        <label>Delay Or  On-Time</label>
                                                                                        <input type="text" name="" class="form-control "style="padding: 0.875rem 1.375rem" value="<?php echo $row['Recived_Delay_On_Time']; ?>" readonly > 
                                                                                    </div> 
                                                                                </div>
                                                                                <div class="col-sm-12 col-md-6">
                                                                                    <div class="form-group">
                                                                                        <label> Upload Any Image Link</label>
                                                                                        <br>
                                                                                        <?php 
                                                                                        if(!empty($row['Recived_AnyImage'])){ ?>
                                                                                        <a href="<?php echo base_url('public/vendors/PicUpload/'.$row['Recived_AnyImage']);?>" target="_blank">link</a> 
                                                                                        <?php } ?>
                                                                                    </div> 
                                                                                </div>
                                                                                <div class="col-sm-12 col-md-6">
                                                                                    <div class="form-group">
                                                                                        <label>Remark</label>
                                                                                        <textarea name="Recived_Remark" class="form-control "><?php echo $row['Recived_Remark']; ?></textarea>
                                                                                    </div> 
                                                                                </div>
                                                                                <div class="col-sm-12 col-md-12">
                                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>                                   
                                                    <div class="modal fade bs-example-modal-lg" id="bd-example-modal-lg-mappBill-<?php echo $row['id']; ?>" tabindex="<?php echo $row['id']; ?>" role="dialog" aria-labelledby="bd-example-modal-lg-del-<?php echo $row['id']; ?>" aria-hidden="true">
                                                        <div class="modal-dialog modal-lg modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header bg-warning">
                                                                    <h4 class="modal-title text-white" id="myLargeModalLabel">Completed</h4>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="">
                                                                        <div class="row">   
                                                                            <form method="post" action="<?php echo site_url('/CheckUp_RecivedBill'); ?>" enctype="multipart/form-data">
                                                                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                                                                <input type="hidden" name="action" value="all">
                                                                                <div class="col-sm-12 col-md-6">
                                                                                    <div class="form-group">
                                                                                        <label> TargetTime Recived Bill</label>
                                                                                        <input type="text" name="Recived_TragetTime_Hours" class="form-control "style="padding: 0.875rem 1.375rem" value="<?php if(!empty($Departmentrow)){ echo $Departmentrow['BillRecived_Time_Hours'];} ?>" readonly > 
                                                                                    </div> 
                                                                                </div>
                                                                                <div class="col-sm-12 col-md-6">
                                                                                    <div class="form-group">
                                                                                        <label> Actual Date & Time</label>
                                                                                        <input type="text" name="" class="form-control "style="padding: 0.875rem 1.375rem" value="<?php echo $row['DateTime']; ?>" readonly > 
                                                                                    </div> 
                                                                                </div>
                                                                                <?php
                                                                                if(!empty($Departmentrow)){
                                                                                    $time = $Departmentrow['BillRecived_Time_Hours'];
                                                                                    [$hours, $minutes] = explode(':', $time);
                                                                                    $minitus=(int)$hours * 60 + (int)$minutes;
                                                                                    $cur_time=$row['DateTime'];
                                                                                    $duration='+'.$minitus.' minutes';
                                                                                    $addedDateTime=date('Y-m-d H:i:s', strtotime($duration, strtotime($cur_time)));
                                                                                    $cur_Datetime=date('Y-m-d H:i:s');
                                                                                    ?>
                                                                                    <div class="col-sm-12 col-md-6">
                                                                                        <div class="form-group">
                                                                                            <label>Delay Or  On-Time</label>
                                                                                            <select name="Recived_Delay_On_Time" class="form-control "style="padding: 0.875rem 1.375rem" > 
                                                                                            <?php
                                                                                            if($addedDateTime>=$cur_Datetime)
                                                                                            {
                                                                                                ?>
                                                                                                <option value="On-Time" selected>On-Time</option> 
                                                                                                <?php
                                                                                            }
                                                                                            else
                                                                                            {
                                                                                                ?>
                                                                                                <option value="Delay" selected>Delay</option> 
                                                                                                <?php
                                                                                            }
                                                                                            ?>
                                                                                            </select>
                                                                                        </div> 
                                                                                    </div>
                                                                                    <?php 
                                                                                } ?>
                                                                                <div class="col-sm-12 col-md-6">
                                                                                    <div class="form-group">
                                                                                        <label for="billpic" >Upload AnyImage<span style="color:red;"></span></label>
                                                                                        <input class="form-control" type="file" name="E_Image"  id="billpic">
                                                                                    </div> 
                                                                                </div>  
                                                                                <div class="col-sm-12 col-md-6">
                                                                                    <div class="form-group">
                                                                                        <label>Remark</label>
                                                                                        <textarea name="Recived_Remark" class="form-control "><?php echo $row['Recived_Remark']; ?></textarea>
                                                                                    </div> 
                                                                                </div>
                                                                                <div class="col-sm-12 col-md-12">
                                                                                    <button type="submit" class="btn btn-warning">Submit</button>
                                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>                                                        
                                                    <div class="modal fade bs-example-modal-lg" id="bd-example-modal-lg-Status-<?php echo $row['id']; ?>" tabindex="<?php echo $row['id']; ?>" role="dialog" aria-labelledby="bd-example-modal-lg-del-<?php echo $row['id']; ?>" aria-hidden="true">
                                                        <div class="modal-dialog modal-md modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header bg-primary">
                                                                    <h4 class="modal-title text-white" id="myLargeModalLabel">Are you sure you want to accept this bill </h4>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="">
                                                                        <div class="row">   
                                                                            <form method="post" action="<?php echo site_url('/RecivedBill_StatusChange'); ?>">
                                                                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                                                                <input type="hidden" name="action" value="all">
                                                                                <div class="col-sm-12 col-md-12" >
                                                                                    <div class="form-group">
                                                                                        <select name="Recived_Status" class="form-control" style="padding: 0.875rem 1.375rem"> 
                                                                                            <option value="1"<?php if($row['Recived_Status']==1) {echo 'selected="selected"';} ?>>Pending</option>
                                                                                            <option value="2" <?php if($row['Recived_Status']==2) {echo 'selected="selected"';} ?>>Accepted</option>
                                                                                            <option value="3" <?php if($row['Recived_Status']==3) {echo 'selected="selected"';} ?>>Reject</option>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-12 col-md-12" >
                                                                                    <div class="form-group">
                                                                                        <input type="text" name="Recived_Comment" class="form-control" style="padding: 0.875rem 1.375rem" value="<?php echo $row['Recived_Comment'];?>"> 
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-12 col-md-12">
                                                                                    <button type="submit" class="btn btn-primary">Submit</button>
                                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
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
                        <div class="modal fade" id="billacceptModal" tabindex="-1" role="dialog" aria-labelledby="billacceptModal" aria-hidden="true">
                            <div class="modal-dialog modal-md modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary">
                                        <h4 class="modal-title text-white" id="myLargeModalLabel">Are you sure you want to accept this bill</h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="">
                                            <div class="row">   
                                                <form method="post" action="">
                                                    <input type="hidden" name="companyid" id="companyid" class="form-control" value="<?php echo $compeny_id;?>">
                                                    <div class="col-sm-12 col-md-12" >
                                                        <div class="form-group">
                                                            <input type="text" name="billid" id="billid" class="form-control" placeholder="Bill Id">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-12" >
                                                        <div class="form-group">
                                                            <select name="Recived_Status" id="receivedstatus" class="form-control" style="padding: 0.875rem 1.375rem"> 
                                                                <option value="1">Pending</option>
                                                                <option value="2">Accepted</option>
                                                                <option value="3">Reject</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-12" >
                                                        <div class="form-group">
                                                            <input type="text" name="Recived_Comment" id="receivedcomment" class="form-control" style="padding: 0.875rem 1.375rem"> 
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-12">
                                                        <button type="button" class="btn btn-primary" id="billreceivedacceptance">Submit</button>
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="masteractionModal" tabindex="-1" role="dialog" aria-labelledby="masteractionModal" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header bg-warning">
                                        <h4 class="modal-title text-white" id="myLargeModalLabel">Action !</h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="">
                                            <form method="post" action="" enctype="multipart/form-data">  
                                                <div class="row"> 
                                                    <input type="hidden" name="stage_id" id="stage_id" value="5">
                                                    <input type="hidden" name="companyid" id="companyid" class="form-control" value="<?php echo $compeny_id;?>">
                                                    <div class="col-sm-12 col-md-6" >
                                                        <div class="form-group">
                                                            <label>Bill Id</label>
                                                            <input type="text" name="billedid" id="billedid" class="form-control" placeholder="Bill Id">
                                                        </div>
                                                    </div> 
                                                    <div class="col-sm-12 col-md-6">
                                                        <div class="form-group">
                                                            <label>Master Action</label>
                                                            <select name="Master_ActionId" id="masteractionid" class="form-control "style="padding: 0.875rem 1.375rem" >
                                                                <?php
                                                                
                                                                $MasterActionmadelObj = new MasterActionModel();                           
                                                                $rowMasterAction = $MasterActionmadelObj->where('compeny_id', $compeny_id)->where('stage_id',$stage_id)->findAll();
                                                                if(isset($rowMasterAction) && $rowMasterAction!='')
                                                                {
                                                                    foreach ($rowMasterAction as $rowMasterAction)
                                                                    { 
                                                                        ?>
                                                                        <option value="<?php echo $rowMasterAction['id']; ?>" ><?php echo ucwords($rowMasterAction['action_name']); ?></option>
                                                                        <?php
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                        </div> 
                                                    </div>
                                                    <div class="col-sm-12 col-md-6">
                                                        <div class="form-group">
                                                            <label for="billpic" >Upload AnyImage<span style="color:red;"></span></label>
                                                            <input class="form-control" type="file" name="E_Image" id="E_Image" >
                                                        </div> 
                                                    </div>  
                                                    <div class="col-sm-12 col-md-6">
                                                        <div class="form-group">
                                                            <label for="billpic" >Remark<span style="color:red;"></span></label>
                                                            <input class="form-control" type="text" name="remark" id="remark">
                                                        </div> 
                                                    </div> 
                                                    <div class="col-sm-12 col-md-12">
                                                        <button type="button" class="btn btn-warning" id="billreceivingmaster">Submit</button>
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="completebill" tabindex="-1" role="dialog" aria-labelledby="completebill" aria-hidden="true">
                            <div class="modal-dialog modal-md modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary">
                                        <h4 class="modal-title text-white" id="myLargeModalLabel">Are you sure you want to accept this bill</h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="">
                                            <div class="row">   
                                                <form method="post" action="" enctype="multipart/form-data">
                                                    <input type="hidden" name="companyid" id="companyid" class="form-control" value="<?php echo $compeny_id;?>">
                                                    <div class="row"> 
                                                        <div class="col-sm-12 col-md-6">
                                                            <div class="form-group">
                                                                <label> Bill Id</label>
                                                                <input type="text" id="billaccptid" name="billaccptid" class="form-control "style="padding: 0.875rem 1.375rem"> 
                                                            </div> 
                                                        </div>
                                                        <div class="col-sm-12 col-md-6">
                                                            <div class="form-group">
                                                                <label> TargetTime Recived Bill</label>
                                                                <input type="text" id="Recived_TragetTime_Hours" name="Recived_TragetTime_Hours" class="form-control "style="padding: 0.875rem 1.375rem" readonly > 
                                                            </div> 
                                                        </div>
                                                        <div class="col-sm-12 col-md-6">
                                                            <div class="form-group">
                                                                <label> Actual Date & Time</label>
                                                                <input type="text" name="" id="completeactualdattime" class="form-control "style="padding: 0.875rem 1.375rem" readonly > 
                                                            </div> 
                                                        </div>
                                                        
                                                        <div class="col-sm-12 col-md-6">
                                                            <div class="form-group">
                                                                <label>Delay Or  On-Time</label>
                                                                <select name="Recived_Delay_On_Time" id="Recived_Delay_On_Time" class="form-control "style="padding: 0.875rem 1.375rem" > 
                                                                    <option value="On-Time" selected>On-Time</option> 
                                                                    <option value="Delay" selected>Delay</option> 
                                                                </select>
                                                            </div> 
                                                        </div>
                                                            
                                                        <div class="col-sm-12 col-md-6">
                                                            <div class="form-group">
                                                                <label for="billpic" >Upload AnyImage<span style="color:red;"></span></label>
                                                                <input class="form-control" type="file" name="E_Image" id="E_Imageerp">
                                                            </div> 
                                                        </div>  
                                                        <div class="col-sm-12 col-md-6">
                                                            <div class="form-group">
                                                                <label>Remark</label>
                                                                <textarea name="Recived_Remark" id="Recived_Remark" class="form-control "></textarea>
                                                            </div> 
                                                        </div>
                                                        <div class="col-sm-12 col-md-12">
                                                            <button type="button" class="btn btn-warning" id="completebillaction">Submit</button>
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>    
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
        <script>
            $(document).ready(function () {
                $('#billreceivedacceptance').click(function () {
                    var companyid           = $('#companyid').val();
                    var billid              = $('#billid').val();
                    var receivedstatus      = $('#receivedstatus').val();
                    var receivedcomment     = $('#receivedcomment').val();
    
                    $.ajax({
                        url: '<?php echo base_url('/index.php/billreceivedaccept') ?>',
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            companyid       : companyid,
                            billid          : billid,
                            receivedstatus  : receivedstatus,
                            receivedcomment : receivedcomment
                        },
                        success: function (response) {
                            console.log(response);
                            alert(response.message);
                        },
                        error: function (xhr, status, error) {
                            console.error(xhr.responseText);
                        }
                    });
                });
            });
        </script>
        <script>
            $(document).ready(function () {
                $('#billreceivingmaster').click(function () {
                    var companyid       = $('#companyid').val();
                    var billid          = $('#billedid').val();
                    var masteractionid  = $('#masteractionid').val();
                    var remark          = $('#remark').val();
                    var stage_id        = $('#stage_id').val();
                    var E_Image         = $('#E_Image')[0].files[0]; // Get the selected file
            
                    var formData = new FormData();
                    formData.append('companyid', companyid);
                    formData.append('billid', billid);
                    formData.append('masteractionid', masteractionid);
                    formData.append('remark', remark);
                    formData.append('stage_id', stage_id);
                    formData.append('E_Image', E_Image);
            
                    $.ajax({
                        url: '<?php echo base_url('/index.php/submitbillformasterverification') ?>',
                        type: 'POST',
                        dataType: 'json',
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function (response) {
                            console.log(response);
                            alert(response.message);
                        },
                        error: function (xhr, status, error) {
                            console.error(xhr.responseText);
                        }
                    });
                });
            });
        </script>
        <script>
            $(document).ready(function () {
                $('#completebillaction').click(function () {
                    var companyid                   = $('#companyid').val();
                    var billid                      = $('#billaccptid').val();
                    var Recived_TragetTime_Hours    = $('#Recived_TragetTime_Hours').val();
                    var completeactualdattime       = $('#completeactualdattime').val();
                    var Recived_Delay_On_Time       = $('#Recived_Delay_On_Time').val();
                    var remark                      = $('#Recived_Remark').val();
                    var E_Image                     = $('#E_Imageerp')[0].files[0]; // Get the selected file
            
                    var formData = new FormData();
                    formData.append('companyid', companyid);
                    formData.append('billid', billid);
                    formData.append('Recived_TragetTime_Hours', Recived_TragetTime_Hours);
                    formData.append('completeactualdattime', completeactualdattime);
                    formData.append('Recived_Delay_On_Time', Recived_Delay_On_Time);
                    formData.append('remark', remark);
                    formData.append('E_Image', E_Image);
            
                    $.ajax({
                        url: '<?php echo base_url('/index.php/completefromBillReceiving') ?>',
                        type: 'POST',
                        dataType: 'json',
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function (response) {
                            console.log(response);
                            alert(response.message);
                        },
                        error: function (xhr, status, error) {
                            console.error(xhr.responseText);
                        }
                    });
                });
            });
        </script>
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
        <!-- JavaScript function for export -->
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