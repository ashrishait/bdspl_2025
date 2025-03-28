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
                        <div class="row">
                            <div class="col-md-12 col-sm-12"> 
                                <?php
                                if(session()->has("Mapping_RecivedBill"))
                                {   
                                    if(session("Mapping_RecivedBill")==1)   
                                    {  
                                        echo "<div class='alert alert-success' role='alert'>Recived Bill Successfully. </div>";
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
                                if(session()->has("Master_Action_SMS"))
                                {   
                                    if(session("Master_Action_SMS")==1)   
                                    {  
                                        echo "<div class='alert alert-success' role='alert'>Successfully  . </div>";
                                    }
                                    else{
                                        echo "<div class='alert alert-danger' role='alert'>Not Successfully ! </div>";   
                                    }
                                }
                                ?>    
                            </div>
                        </div>    
                        <div class="col-lg-12 grid-margin">
                            <div class="col-md-12 col-sm-12 List p-3">
                                <div class="row">
                                    <div class="col-6">
                                       <h2>Bill Received</h2>
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
                                        <tbody>
                                            <?php 
                                            $stage_id=5;
                                            $result = $session->get();
                                            $etm = $result['ddn'];  
                                            $i=0+$etm;
                                            if(isset($dax)){
                                                foreach ($dax as $row){
                                                    $i = $i+1;
                                                    $Departmentrow= $DepartmentModelObj->where('compeny_id', $compeny_id)->where('id',$row['Department_Id'])->first();
                                                    ?>
                                                    <tr>
                                                        <th>#</th>
                                                        <td><?php echo $i; ?></td>
                                                        <th><b>Bill Date_Time</b></th>
                                                        <td><?php echo   date('d-m-Y H:i:s', strtotime($row['DateTime']))?></td>
                                                    </tr>
                                                    <tr>
                                                        <th><b>Bill Pic </b></th>
                                                        <td>
                                                            <?php 
                                                            if(!empty($row['Bill_Pic'])){ ?>
                                                            <a href="<?php echo base_url('public/vendors/PicUpload/'.$row['Bill_Pic']);?>" target="_blank">link</a>
                                                            <?php } ?>
                                                        </td>
                                                        <th><b>Bill Id </b></th>
                                                        <td><?php echo $row['uid']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th><b>Vendor Name </b></th>
                                                        <td><?php 
                                                            $Vendorrow= $PartyUserModelObj->where('id',$row['Vendor_Id'])->first();
                                                            if(isset($Vendorrow) && $Vendorrow!='')
                                                            {
                                                                echo $Vendorrow['Name']; 
                                                            }
                                                            ?>
                                                        </td>
                                                        <th><b>Bill No  </b></th>
                                                        <td><?php echo $row['Bill_No']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th><b>Bill Amount</b></th>
                                                        <td><?php echo $row['Bill_Amount']; ?></td>
                                                        <th><b>Bill Date</b></th>
                                                        <td><?php echo   date('d-m-Y', strtotime($row['Bill_DateTime']))?></td>
                                                    </tr>
                                                    <tr>
                                                        <th><b>Unit Name  </b></th>
                                                        <td><?php 
                                                            $Unitrow= $UnitModelObj->where('id',$row['Unit_Id'])->first();
                                                            if(isset($Unitrow) && $Unitrow!='')
                                                            {
                                                                echo $Unitrow['name']; 
                                                            }
                                                            ?> 
                                                        </td>
                                                        <th><b>Gate Entry No </b></th>
                                                        <td><?php echo $row['Gate_Entry_No']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th><b>Gate Entry Date</b></th>
                                                        <td>
                                                            <?php echo   date('d-m-Y', strtotime($row['Gate_Entry_Date']))?>
                                                        </td>
                                                        <th><b>Bill Type</b></th>
                                                        <td><?php 
                                                            $BillTyperow= $BillTypeModelObj->where('id',$row['Bill_Type'])->first();
                                                            if(isset($BillTyperow) && $BillTyperow!='')
                                                            {
                                                                echo $BillTyperow['name']; 
                                                            }
                                                            ?> 
                                                         </td>
                                                    </tr>
                                                    <tr>
                                                        <th><b>Mapping Employee Name</b></th>
                                                         <td><?php 
                                                            $MappingEmprow= $EmployeeModelObj->where('id',$row['Department_Emp_Id'])->first();
                                                            if(isset($MappingEmprow) && $MappingEmprow!='')
                                                            {
                                                                echo $MappingEmprow['first_name']; 
                                                                echo " ".$MappingEmprow['last_name'];
                                                            }
                                                            ?> 
                                                        </td>
                                                        <th><b>Add By</b></th>
                                                        <td><?php echo $row['first_name']; ?> <?php echo $row['last_name']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th><b>Acceptation Comments</b></th>
                                                        <td><?php echo $row['Recived_Comment']; ?></td>
                                                        <th><b>Acceptation DateTime</b></th>
                                                        <td><?php echo $row['Recived_DateTime']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <?php
                                                        $MasterActionmadelObj = new MasterActionModel();
                                                        $rowMasterAction2= $MasterActionmadelObj->where('compeny_id', $compeny_id)->where('stage_id',$stage_id)->where('no_of_action',$row['Recived_Master_Action'])->first();
                                                        if(isset($rowMasterAction2) && $rowMasterAction2!='') {
                                                            $rowMasterActionUpload= $MasterActionUploadModelObj->where('compeny_id', $compeny_id)->where('bill_id',$row['id'])->where('master_action_id',$rowMasterAction2['id'])->first();
                                                        }
                                                        ?>
                                                        <th><b>Current Master Action</b></th>
                                                        <td><?php if(isset($rowMasterAction2) && $rowMasterAction2!='') { echo $rowMasterAction2['action_name']; } ?></td>
                                                        <th><b>Current Master Action Image</b></th>
                                                        <td><a href="<?php if(isset($rowMasterActionUpload) && $rowMasterActionUpload!='') { if(!empty($rowMasterActionUpload['image_upload'])){ echo base_url('public/vendors/PicUploadMasterAction/'.$rowMasterActionUpload['image_upload']); }else{ }} ?>" target="_blank">link</a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th><b>Current Master Action Remark</b></th>
                                                        <td><?php if(isset($rowMasterActionUpload) && $rowMasterActionUpload!='') {echo $rowMasterActionUpload['remark']; }?></td>
                                                        <th><b>Action </b></th>
                                                        <td>
                                                            <?php 
                                                            $Roll_id = $session->get("Roll_id");
                                                            $emp_id = $session->get("emp_id"); 
                                                            $compeny_id = $session->get("compeny_id"); 
                                                            $rollpage = $employeeModel->pagelinkaccordingtoroll($emp_id);
                                                            $menu = $rollpage->get()->getResult();
                                                            if($Roll_id==2)
                                                            {
                                                                if(isset($menu)){  
                                                                    foreach ($menu as $menun){ 
                                                                        if($menun->Page_Id==7){
                                                                            if($row['Recived_Status']==1)
                                                                            {
                                                                                ?>
                                                                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#bd-example-modal-lg-Status-<?php echo $row['id']; ?>">Pending</button>
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
                                                                                        <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#bd-example-modal-lg-mappBill-<?php echo $row['id']; ?>">Accepted </button>
                                                                                        <?php
                                                                                    }
                                                                                    else
                                                                                    {
                                                                                        ?>
                                                                                        <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#bd-example-modal-lg-MasterAction-<?php echo $row['id']; ?>"><i class="fa fa-eye"></i>Master Action </button>
                                                                                        <?php
                                                                                    }
                                                                                }
                                                                                else{
                                                                                    ?>
                                                                                    <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#bd-example-modal-lg-mappBill-<?php echo $row['id']; ?>">Accepted </button>
                                                                                   <?php
                                                                                }
                                                                            }
                                                                            elseif($row['Recived_Status']==3)
                                                                            {
                                                                            ?>
                                                                                <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#bd-example-modal-lg-Status-<?php echo $row['id']; ?>">Reject</button>
                                                                                <?php
                                                                            }
                                                                            elseif($row['Recived_Status']==4)
                                                                            {
                                                                                ?>
                                                                                
                                                                                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#bd-example-modal-lg-mappBillView-<?php echo $row['id']; ?>">View</button>
                                                                                <?php
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                            ?>
                                                            <?php 
                                                            if($Roll_id==1)
                                                            {
                                                                if($row['Recived_Status']==1)
                                                                {
                                                                    ?>
                                                                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#bd-example-modal-lg-Status-<?php echo $row['id']; ?>">Pending</button>
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
                                                                            <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#bd-example-modal-lg-mappBill-<?php echo $row['id']; ?>">Accepted </button>
                                                                            <?php
                                                                        }
                                                                        else
                                                                        {
                                                                            ?>
                                                                            <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#bd-example-modal-lg-MasterAction-<?php echo $row['id']; ?>"><i class="fa fa-eye"></i>Master Action </button>
                                                                            <?php
                                                                        }
                                                                    }
                                                                    else{
                                                                        ?>
                                                                        <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#bd-example-modal-lg-mappBill-<?php echo $row['id']; ?>">Accepted </button>
                                                                       <?php
                                                                    }
                                                                }
                                                                elseif($row['Recived_Status']==3)
                                                                {
                                                                ?>
                                                                    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#bd-example-modal-lg-Status-<?php echo $row['id']; ?>">Reject</button>
                                                                    <?php
                                                                }
                                                                elseif($row['Recived_Status']==4)
                                                                {
                                                                    ?>
                                                                    
                                                                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#bd-example-modal-lg-mappBillView-<?php echo $row['id']; ?>">View</button>
                                                                    <?php
                                                                }
                                                                ?>
                                                                <a href="<?php echo base_url();?>/index.php/bill_edit/<?php echo $row['id']; ?>"><span class="mdi mdi-pen"></span></a>
                                                                <?php
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
                                                                                <input type="hidden" name="action" value="single">
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
                                                                    <h4 class="modal-title text-white" id="myLargeModalLabel">Received</h4>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="">
                                                                        <div class="row">   
                                                                            <form method="post" action="<?php echo site_url('/CheckUp_RecivedBill'); ?>" enctype="multipart/form-data">
                                                                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                                                                <input type="hidden" name="action" value="single">
                                                                                <div class="col-sm-12 col-md-6">
                                                                                    <div class="form-group">
                                                                                        <label> TargetTime Recived Bill</label>
    <input type="text" name="Recived_TragetTime_Hours" class="form-control" style="padding: 0.875rem 1.375rem" 
value="<?php echo isset($Departmentrow['BillRecived_Time_Hours']) ? $Departmentrow['BillRecived_Time_Hours'] : ''; ?>" readonly >

                                                                                    </div> 
                                                                                </div>
                                                                                <div class="col-sm-12 col-md-6">
                                                                                    <div class="form-group">
                                                                                        <label> Actual Date & Time</label>
                                                                                        <input type="text" name="" class="form-control "style="padding: 0.875rem 1.375rem" value="<?php echo $row['DateTime']; ?>" readonly > 
                                                                                    </div> 
                                                                                </div>
                                                                                <?php
if (isset($Departmentrow['BillRecived_Time_Hours'])) {
    $time = $Departmentrow['BillRecived_Time_Hours'];
    [$hours, $minutes] = explode(':', $time);
    $minitus = (int)$hours * 60 + (int)$minutes;
    $cur_time = $row['DateTime'];
    $duration = '+' . $minitus . ' minutes';
    $addedDateTime = date('Y-m-d H:i:s', strtotime($duration, strtotime($cur_time)));
    $cur_Datetime = date('Y-m-d H:i:s');
} else {
    // Handle the case where $Departmentrow['BillRecived_Time_Hours'] is null
    $addedDateTime = ''; // or set to some default value
    $cur_Datetime = date('Y-m-d H:i:s');
}
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
                                                                    <h4 class="modal-title text-white" id="myLargeModalLabel">Are You Sure To Clear Bill Form Status Change </h4>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="">
                                                                        <div class="row">   
                                                                            <form method="post" action="<?php echo site_url('/RecivedBill_StatusChange'); ?>">
                                                                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                                                                <input type="hidden" name="action" value="single">
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
        <?php include('include/script.php'); ?>
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