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
                            if(session()->has("emp_delete"))
                            {   
                                if(session("emp_delete")==1)   
                                {  
                                        echo "<div class='alert alert-success' role='alert'>Record Deleted Successfully. </div>";
                                }
                                else{
                                    echo "<div class='alert alert-danger' role='alert'>For Deleting any Employee, Kindely deactive their Login Account First!! </div>";   
                                }
                            }
                            if(session()->has("emp_up"))
                            {   
                                if(session("emp_up")==1)   
                                {  
                                        echo "<div class='alert alert-success' role='alert'> Form Updation Successful. </div>";
                                }
                                elseif(session("emp_up")==3)   
                                {  
                                        echo "<div class='alert alert-danger' role='alert'> Already Asing UID. </div>";
                                }
                                elseif(session("emp_up")==4)   
                                {  
                                        echo "<div class='alert alert-danger' role='alert'> Not Match  UID and Bill No. </div>";
                                }
                                elseif(session("emp_up")==5)   
                                {  
                                        echo "<div class='alert alert-danger' role='alert'>Sr No already updated in thi bill</div>";
                                }
                                else{
                                    echo "<div class='alert alert-danger' role='alert'> Problem in Updation! </div>";
                                }
                                
                            }
                            if(session()->has("Bill_Acceptation_Status"))
                               {   
                                if(session("Bill_Acceptation_Status")==1)   
                                {  
                                        echo "<div class='alert alert-success' role='alert'>Successfully Change Status  . </div>";
                                }
                                else{
                                    echo "<div class='alert alert-danger' role='alert'>Not Successfully Department Mapping Bill ! </div>";   
                                }
                            }
                            if(session()->has("Mapping_Department"))
                               {   
                                if(session("Mapping_Department")==1)   
                                {  
                                        echo "<div class='alert alert-success' role='alert'> Successfully Department Mapping Bill !  . </div>";
                                }
                                else{
                                    echo "<div class='alert alert-danger' role='alert'>Not Successfully Department Mapping Bill ! </div>";   
                                }
                            }
                            ?>    
                            </div>
                        </div>    
                        <div class="col-lg-12 grid-margin">
                            <div class="col-md-12 col-sm-12 List p-3">
                                <div class="row">
                                    <div class="col-md-4">
                                       <h2>Bill Assignment List</h2>
                                    </div>
                                    <div  class="col-md-4">
                                        <form method="post" action="<?php echo base_url('/index.php/barcodeuid');?>">
        			                        <input type="hidden" name="companyid" id="companyid" class="form-control" value="<?php echo $compeny_id;?>" />
        			                        <input type="text" name="enteruid" id="searchInput" placeholder="Scan Barcode Or Enter Bill UID" class="form-control"/>
        			                        <!-- Suggestions dropdown -->
                                            <ul id="suggestionsList"></ul>
        			                    </form>
                                    </div>
                                    <div class="col-md-4">
                                        <button type="button" class="btn btn-success float-end btn-lg" onclick="exportTableToExcel('myTable', 'table_export')">Export to Excel</button>
                                        <button type="button" class="btn btn-warning float-end me-2 btn-lg" data-bs-toggle="modal" data-bs-target="#assignModal">
                                            Assign Bill
                                        </button>
                                        
                                        <button type="button" class="btn btn-success float-end me-2 btn-lg" data-bs-toggle="modal" data-bs-target="#billacceptModal">
                                            Accept Bill
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body cardbody p-1"> 
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover" id="myTable">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th><b>Upload Date</b></th>
                                                    <th><b>Invoice</b></th>
                                                    <th><b>Bill Id </b></th>
                                                    <th><b>Vendor</b></th>
                                                    <th><b>Bill No</b></th>
                                                    <th><b>Amount</b></th>
                                                    <th><b>Bill Date</b></th>
                                                    <th><b>Unit </b></th>
                                                    <th><b>Gate No </b></th>
                                                    <th><b>Gate Entry Date</b></th>
                                                    <th><b>Type</b></th>
                                                    <th><b>Assign To</b></th>
                                                    <th><b>Add By</b></th>
                                                    <th><b>Comment</b></th> 
                                                    <th><b>Accepted On</b></th>
                                                    <th><b>Vendor Comment</b></th>
                                                    <th><b>Vendor Upload</b></th>
                                                    <th><b>Vendor Status</b></th>
                                                    <th><b>Action</b></th>
                                                </tr>
                                                <form method="get" action="<?php echo site_url('/all_bill_mapping_list'); ?>" enctype="multipart/form-data"> 
                                                    <tr>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th>
                                                            <select name="Vendor_Id" class="form-control "data-live-search="true" style="width:130px;" onchange="submit()"> 
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
                                                                <option value="">- Select Unit -</option>   <?php
                                                                if(isset($dax15)){
                                                                foreach ($dax15 as $row15){ ?>
                                                                    <option value="<?php echo $row15['id']; ?>"><?php echo ucwords($row15['name']); ?></option>
                                                                <?php }} ?>        
                                                            </select>
                                                        </th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th>
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
                                                        </th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th><b>
                                                            <select name="Satus" class="form-control " style="width:130px"required onchange="submit()"> 
                                                                <option value="All" style="background:#065ca3;color:white;"> All </option>
                                                                <option value="1" style="background:#004784;color:white;"> Pending </option>
                                                                <option value="2"style="background:#dfbc11;color:white;"> Accepted </option>
                                                                <option value="3" style="background:#9b0606;color:white;"> Reject </option>
                                                                <option value="4" style="background:#1b7e09;color:white;"> Done </option>
                                                            </select>
                    
                                                        </b></th>
                                                    </tr>
                                                </form>
                                            </thead>
                                            <tbody>
                                            <?php 
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
                                                        <td><?php echo date('d/m/Y H:i:s', strtotime($row['DateTime']))?></td>
                                                        <td>
                                                            <?php 
                                                            if(!empty($row['Bill_Pic'])){ ?>
                                                                <a href="<?php echo base_url('public/vendors/PicUpload/'.$row['Bill_Pic']);?>" target="_blank">link</a></td>
                                                            <?php } ?>    
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
                                                            $MappingEmprow= $EmployeeModelObj->where('id',$row['Department_Emp_Id'])->first();
                                                            if(isset($MappingEmprow) && $MappingEmprow!='')
                                                            {
                                                              echo $MappingEmprow['first_name']; 
                                                              echo " ".$MappingEmprow['last_name'];
                                                            }
                                                            ?> 
                                                        </td>
                                                        <td><?php if($row['Add_By_Vendor']==1){ echo "Add By Vendor"; } else{echo $row['first_name']; ?> <?php echo $row['last_name'];} ?></td>
                                                        <td><?php 
                                                            if($row['Bill_Acceptation_Status']==1)
                                                            {
                                                                echo $row['Remark']; 
                                                            }
                                                            else{
                                                                echo $row['Bill_Acceptation_Status_Comments']; 
                                                            }
                                                            ?>
                                                        </td>
                                                        <td><?php echo $row['Bill_Acceptation_DateTime']; ?></td>
                                                        <td><?php echo $row['Vendor_Comment']; ?></td>
                                                        <td>
                                                            <?php 
                                                            if(!empty($row['Vendor_Upload_Image'])){ ?>
                                                                <a href="<?php echo base_url('public/vendors/PicUpload/'.$row['Vendor_Upload_Image']);?>" target="_blank"><?php if(!empty($row['Vendor_Upload_Image'])) { ?>link<?php } ?></a>
                                                                <?php 
                                                            } ?>
                                                        </td>
                                                        <td>
                                                            <?php 
                                                            if($row['vendor_status']==1){?>
                                                                Payment Not Received
                                                                <?php
                                                            }
                                                            else{ ?>
                                                                Payment Received
                                                                <?php
                                                            } ?>
                                                        </td>
                                                        <td>
                                                        <?php 
                                                        if($row['Bill_Acceptation_Status']==1)
                                                        {
                                                            ?>
                                                            <span class="span text-primary" data-bs-toggle="modal" data-bs-target="#bd-example-modal-lg-BillStatus-<?php echo $row['id']; ?>" title="Pending"><span class="mdi mdi-receipt-clock-outline"></span></span>
                                                            <?php
                                                        }
                                                        elseif($row['Bill_Acceptation_Status']==2)
                                                        {
                                                        ?>
                                                            <span class="span text-warning" data-bs-toggle="modal" data-bs-target="#bd-example-modal-lg-mappBill-<?php echo $row['id']; ?>" title="Accepted"><span class="mdi mdi-account-check-outline"></span></span>
                                                        <?php
                                                        }
                                                        elseif($row['Bill_Acceptation_Status']==3)
                                                        {
                                                            ?>
                                                            <span class="span text-danger" data-bs-toggle="modal" data-bs-target="#bd-example-modal-lg-BillStatus-<?php echo $row['id']; ?>" title="Rejected"><span class="mdi mdi-close-box-multiple"></span></span>
                                                            <?php
                                                        }
                                                        elseif($row['Bill_Acceptation_Status']==4)
                                                        {
                                                        ?>  
                                                            <span class="span text-success" data-bs-toggle="modal" data-bs-target="#bd-example-modal-lg-mappBillView-<?php echo $row['id']; ?>" title="Done"><span class="mdi mdi-check-all"></span></span>
                                                            
                                                        <?php
                                                        }
                                                        ?>
                                                        <a href="<?php echo base_url();?>/index.php/complete-detail-of-sigle-bill/<?php echo $row['id']; ?>"><span class="mdi mdi-eye-circle"></span></a>
                                                        </td>
                                                    </tr> 
                                                    <div class="modal fade bs-example-modal-lg" id="bd-example-modal-lg-BillStatus-<?php echo $row['id']; ?>" tabindex="<?php echo $row['id']; ?>" role="dialog" aria-labelledby="bd-example-modal-lg-del-<?php echo $row['id']; ?>" aria-hidden="true">
                                                        <div class="modal-dialog modal-md modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header bg-primary">
                                                                    <h4 class="modal-title text-white" id="myLargeModalLabel">Are you sure you want to accept bill ??</h4>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="">
                                                                        <div class="row">   
                                                                            <form method="post" action="<?php echo site_url('/Bill_Acceptation_StatusChange'); ?>">
                                                                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                                                                <input type="hidden" name="action" value="all">
                                                                                <div class="col-sm-12 col-md-12" >
                                                                                    <div class="form-group">
                                                                                        <select name="Bill_Acceptation_Status" class="form-control" style="padding: 0.875rem 1.375rem" required> 
                                                                                            <option value="1"<?php if($row['Bill_Acceptation_Status']==1) {echo 'selected="selected"';} ?>>Pending</option>
                                                                                            <option value="2" <?php if($row['Bill_Acceptation_Status']==2) {echo 'selected="selected"';} ?>>Accepted</option>
                                                                                            <option value="3" <?php if($row['Bill_Acceptation_Status']==3) {echo 'selected="selected"';} ?>>Reject</option>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-12 col-md-12" >
                                                                                    <div class="form-group">
                                                                                        <input type="text" name="Bill_Acceptation_Status_Comments" class="form-control" style="padding: 0.875rem 1.375rem" value="<?php echo $row['Bill_Acceptation_Status_Comments'];?>"> 
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-12 col-md-12">
                                                                                    <button type="submit" class="btn btn-primary btn-lg">Submit</button>
                                                                                    <button type="button" class="btn btn-secondary btn-lg" data-dismiss="modal">Close</button>
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
                                                                    <h4 class="modal-title text-white" id="myLargeModalLabel">Are you sure you want to send this bill for verification??!</h4>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="">
                                                                        <div class="row">   
                                                                            <div class="col-sm-12 col-md-6" >
                                                                                <div class="form-group">
                                                                                    <label for="billpic" >Bill Type <span style="color:red;">*</span></label>
                                                                                    <select name="" class="form-control" id="Bill_Type<?php echo $row['id']; ?>" style="padding: 0.875rem 1.375rem" required>
                                                                                        <option value="">-Select -</option>  
                                                                                        <?php
                                                                                        if(isset($dax17)){
                                                                                        foreach ($dax17 as $row17){ ?>
                                                                                        <option value="<?php echo $row17['id']; ?>" <?php if($row['Bill_Type']==$row17['id']) {echo 'selected="selected"';} ?>><?php echo ucwords($row17['name']); ?></option>
                                                                                        <?php }} ?>        
                                                                                     </select>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-12 col-md-6">
                                                                                <div class="form-group">
                                                                                    <label>Department </label>
                                                                                    <select name="" class="form-control "style="padding: 0.875rem 1.375rem" id="Department_Id<?php echo $row['id']; ?>" onchange = "getCityname<?php echo $row['id']; ?>();" required > 
                                                                                        <option value="">Select</option>
                                                                                        <?php
                                                                                            $rowDepartment = $DepartmentModelObj->where('bill_type_id',$row['Bill_Type'])->findAll();
                                                                                            if(isset($rowDepartment) && $rowDepartment!='')
                                                                                            {
                                                                                                foreach ($rowDepartment as $rowDepartment16)
                                                                                                { 
                                                                                                    ?>
                                                                                                    <option value="<?php echo $rowDepartment16['id']; ?>,<?php echo $row['id']; ?>"><?php echo ucwords($rowDepartment16['name']); ?></option>
                                                                                                    <?php 
                                                                                                }
                                                                                            } 
                                                                                        ?> 
                                                                                    </select>
                                                                                </div> 
                                                                            </div>
                                                                            <div class="col-sm-12" id="CityId<?php echo $row['id']; ?>"></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>                                            
                                                    <?php 
                                                    if($row['Department_Id']!='')
                                                    {
                                                    ?>
                                                    <div class="modal fade bs-example-modal-lg" id="bd-example-modal-lg-mappBillView-<?php echo $row['id']; ?>" tabindex="<?php echo $row['id']; ?>" role="dialog" aria-labelledby="bd-example-modal-lg-del-<?php echo $row['id']; ?>" aria-hidden="true">
                                                        <div class="modal-dialog modal-lg modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header bg-success">
                                                                    <h4 class="modal-title text-white" id="myLargeModalLabel">Bill Assignment Details</h4>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="">
                                                                        <div class="row">   
                                                                            <form method="post" action="<?php echo site_url('/Department_Mapping_BillReg'); ?>">
                                                                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                                                                <div class="col-sm-12 col-md-6">
                                                                                    <div class="form-group">
                                                                                        <label> Target Time To Maping Bill</label>
                                                                                        <input type="text" name="TargetMapping_Time_Hours" class="form-control "style="padding: 0.875rem 1.375rem" value="<?php echo $row['TargetMapping_Time_Hours']; ?>" readonly > 
                                                                                    </div> 
                                                                                </div>
                                                                                <div class="col-sm-12 col-md-6">
                                                                                    <div class="form-group">
                                                                                        <label>Bill Type </label>
                                                                                        <select name="Bill_Type" class="form-control "style="padding: 0.875rem 1.375rem" id="" > 
                                                                                            <option value="" >Select</option>
                                                                                            <?php
                                                                                            if(isset($dax17)){
                                                                                                foreach ($dax17 as $row17){
                                                                                       if($row['Bill_Type']==$row17['id'])
                                                                                           { 
                                                                                                ?>
                                                                                                <option value="<?php echo $row17['id']; ?>" <?php if($row['Bill_Type']==$row17['id']) {echo 'selected="selected"';} ?>><?php echo ucwords($row17['name']); ?></option>
                                                                                                <?php 
                                                                                                }
                                                                                            }
                                                                                            } ?> 
                                                                                        </select>
                                                                                    </div> 
                                                                                </div>
                                                                                <div class="col-sm-12 col-md-6">
                                                                                    <div class="form-group">
                                                                                        <label>Department </label>
                                                                                        <select name="Department_Id" class="form-control "style="padding: 0.875rem 1.375rem" id="ps<?php echo $row['id']; ?>" > 
                                                                                        <?php
                                                                                        if(isset($dax16)){
                                                                                            foreach ($dax16 as $row16){ 
                                                                                                if($row['Department_Id']==$row16['id'])
                                                                                                {
                                                                                                    ?>
                                                                                                    <option value="<?php echo $row16['id']; ?>" <?php if($row['Department_Id']==$row16['id']) {echo 'selected="selected"';} ?>><?php echo ucwords($row16['name']); ?></option>
                                                                                                    <?php 
                                                                                                }
                                                                                            }
                                                                                        } ?> 
                                                                                        </select>
                                                                                    </div> 
                                                                                </div>
                                                                                <div class="col-sm-12 col-md-6">
                                                                                    <div class="form-group">
                                                                                        <label>Employee Name</label>
                                                                                        <select name="Department_Emp_Id" class="form-control"  style="padding: 0.875rem 1.375rem" required> 
                                                                                            <option value="">-Select -</option> 
                                                                                            <?php
                                                                                            $Department_Id=$row['Department_Id'];
                                                                                            $rowEMP = $EmployeeModelObj->where('compeny_id', $compeny_id)->where('department',$Department_Id)->findAll();
                                                                                            if(isset($rowEMP) && $rowEMP!='')
                                                                                            {
                                                                                                foreach ($rowEMP as $rowEMP)
                                                                                                { 
                                                                                                    if($row['Department_Emp_Id']==$rowEMP['id']) {
                                                                                                    ?>
                                                                                                    <option value="<?php echo $rowEMP['id']; ?>" <?php if($row['Department_Emp_Id']==$rowEMP['id']) {echo 'selected="selected"';} ?>><?php echo ucwords($rowEMP['first_name']); ?></option>
                                                                                                        <?php
                                                                                                    }
                                                                                                }
                                                                                            }
                                                                                            ?>
                                                                                        </select>
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
                                                                                        <input type="text" name="Mapping_Delay_On_Time" class="form-control "style="padding: 0.875rem 1.375rem" value="<?php echo $row['Mapping_Delay_On_Time']; ?>" readonly > 
                                                                                    </div> 
                                                                                </div>
                                                                                <div class="col-sm-12 col-md-6">
                                                                                    <div class="form-group">
                                                                                        <label>Remark</label>
                                                                                        <textarea name="Mapping_Remark" class="form-control "> 
                                                                                            <?php echo $row['Mapping_Remark']; ?>
                                                                                        </textarea>
                                                                                    </div> 
                                                                                </div>
                                                                               
                                                                                <div class="col-sm-12 col-md-12">
                                                                                    <!--<button type="submit" class="btn btn-success">Mapping</button>-->
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
                                                    }?>
                                                <?php } 
                                                } 
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div></div>
                                </div>
                            </div>
                        </div>    
                        <div class="modal fade" id="billacceptModal" tabindex="-1" aria-labelledby="billacceptModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header bg-success">
                                        <h1 class="modal-title fs-5 text-white" id="exampleModalLabel">Accept Bill</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="post" action="" id="myForm">
                                            <input type="hidden" name="companyid" id="companyid" class="form-control" value="<?php echo $compeny_id;?>">
                                            <div class="col-sm-12 col-md-12" >
                                                <div class="form-group">
                                                    <input type="text" name="billid" id="billid" class="form-control" placeholder="Bill Id">
                                                </div>
                                            </div>    
                                            <div class="col-sm-12 col-md-12" >
                                                <div class="form-group">
                                                    <select name="Bill_Acceptation_Status" id="Bill_Acceptation_Status" class="form-control" style="padding: 0.875rem 1.375rem" required> 
                                                        <option value="1">Pending</option>
                                                        <option value="2">Accepted</option>
                                                        <option value="3">Reject</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-12" >
                                                <div class="form-group">
                                                    <input type="text" name="Bill_Acceptation_Status_Comments" id="Bill_Acceptation_Status_Comments" class="form-control" style="padding: 0.875rem 1.375rem"> 
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-12">
                                                <button type="button" id="submitbillforacceptance" class="btn btn-success btn-lg">Submit</button>
                                                <button type="button" class="btn btn-secondary btn-lg" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="assignModal" tabindex="-1" aria-labelledby="assignModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header bg-warning">
                                        <h1 class="modal-title fs-5 text-white" id="exampleModalLabel">Accept Bill</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="post" action="" id="myForm">
                                            <div class="row">   
                                                <input type="hidden" name="companyid" id="companyid" class="form-control" value="<?php echo $compeny_id;?>">
                                                <div class="col-sm-12 col-md-4" >
                                                    <div class="form-group">
                                                        <label for="billpic" >Bill Id <span style="color:red;">*</span></label>
                                                        <input type="text" name="billidvalue" id="billidvalue" class="form-control" placeholder="Bill Id">
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-4" >
                                                    <div class="form-group">
                                                        <label for="billpic" >Bill Type <span style="color:red;">*</span></label>
                                                        <select name="" class="form-control" id="selectbill" style="padding: 0.875rem 1.375rem" required>
                                                            <option value="">-Select -</option>  
                                                            <?php
                                                            if(isset($dax17)){
                                                                foreach ($dax17 as $row17){ ?>
                                                                    <option value="<?php echo $row17['id']; ?>"><?php echo ucwords($row17['name']); ?></option>
                                                                    <?php }
                                                                } 
                                                            ?>        
                                                         </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-4">
                                                    <div class="form-group">
                                                        <label>Department </label>
                                                        <select name="" class="form-control" style="padding: 0.875rem 1.375rem" id="Department_Id" onchange = "getassignemp();" required > 
                                                            <option value="">Select</option>
                                                            <?php
                                                                if(!empty($row['Bill_Type'])){
                                                                    $rowd = $DepartmentModelObj->where('bill_type_id',$row['Bill_Type'])->findAll();
                                                                    if(isset($rowd) && $rowd!='')
                                                                    {
                                                                        foreach ($rowd as $rowdep)
                                                                        { 
                                                                            ?>
                                                                            <option value="<?php echo $rowdep['id']; ?>"><?php echo ucwords($rowdep['name']); ?></option>
                                                                            <?php 
                                                                        }
                                                                    } 
                                                                }
                                                            ?> 
                                                        </select>
                                                    </div> 
                                                </div>
                                                <div id="depId"></div>
                                                <div class="col-sm-12 col-md-12">
                                                    <button type="button" class="btn btn-warning btn-lg" id="submitformasteraction">Mapping</button>
                                                    <button type="button" class="btn btn-secondary btn-lg" data-bs-dismiss="modal">Close</button>
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
            <?php include('include/footer.php')?>
        </div>
        <?php include('include/script.php'); ?>
        <script type="text/javascript" src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
        <?php
        $rowBillRegister = $BillRegisterModelObj->where('compeny_id', $compeny_id)->where('Active',1)->findAll();
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
                        $('#Bill_Type<?php echo $rowBillRegister['id']; ?>').change(function(){ 
                            var state_id = $('#Bill_Type<?php echo $rowBillRegister['id']; ?>').val();  
                            var action = 'get_Department2';   
                            if(state_id != '')
                            {   
                                $.ajax({     
                                    url:"<?php echo base_url('/index.php/getDepartment2')?>",
                                    method:"GET",
                                    data:{state_id:state_id, action:action},  
                                    dataType:"JSON",
                                    success:function(data)  
                                    {        
                                        var html = '<option value="">Select </option>';
                    
                                        for(var count = 0; count < data.length; count++)
                                        {
                                            html += '<option value="'+data[count].id+','+<?php echo $rowBillRegister['id']; ?>+'">'+data[count].name+'</option>';
                                        }
                    
                                        $('#Department_Id<?php echo $rowBillRegister['id']; ?>').html(html);
                                    }
                                });
                            }
                            else   
                            {
                                $('#Department_Id<?php echo $rowBillRegister['id']; ?>').val('');
                            }
                        });
                    });
                </script>
                <script type="text/javascript">
                    function getCityname<?php echo $rowBillRegister['id']; ?>()
                    {
                        var depart = $('#Department_Id<?php echo $rowBillRegister['id']; ?>').val(); 
                        var top = depart;
                        //   alert(depart);
                        //   alert(top);
                        ajaxRequest = new XMLHttpRequest();
                        ajaxRequest.onreadystatechange = function()
                        {
                            if(ajaxRequest.readyState == 4)
                            {
                                var ajaxDisplay = document.getElementById('CityId<?php echo $rowBillRegister['id']; ?>');
                                ajaxDisplay.innerHTML = ajaxRequest.responseText;    
                            }
                        }
                        ajaxRequest.open("GET", "<?php echo base_url('/index.php/ajax')?>?Department_Id=" +top, true);
                        ajaxRequest.send(); 
                    }
                </script>
                <?php
            }
        }
        ?>
        <script>
            $(document).ready(function () {
                $('#submitbillforacceptance').click(function () {
                    var companyid = $('#companyid').val();
                    var billid = $('#billid').val();
                    var Bill_Acceptation_Status = $('#Bill_Acceptation_Status').val();
                    var Bill_Acceptation_Status_Comments = $('#Bill_Acceptation_Status_Comments').val();
    
                    $.ajax({
                        url: '<?php echo base_url('/index.php/updatemodalpopup') ?>',
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            companyid: companyid,
                            billid: billid,
                            Bill_Acceptation_Status: Bill_Acceptation_Status,
                            Bill_Acceptation_Status_Comments: Bill_Acceptation_Status_Comments
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
                $('#selectbill').change(function(){ 
                    var state_id = $('#selectbill').val();  
                    var action = 'get_Department2';   
                    if(state_id != '')
                    {   
                        $.ajax({     
                            url:"<?php echo base_url('/index.php/getDepartment2')?>",
                            method:"GET",
                            data:{state_id:state_id, action:action},  
                            dataType:"JSON",
                            success:function(data)  
                            {        
                                var html = '<option value="">Select </option>';
            
                                for(var count = 0; count < data.length; count++)
                                {
                                    html += '<option value="'+data[count].id+'">'+data[count].name+'</option>';
                                }
            
                                $('#Department_Id').html(html);
                            }
                        });
                    }
                    else   
                    {
                        $('#Department_Id').val('');
                    }
                });
            });
        </script>
        <script type="text/javascript">
            function getassignemp() {
                var companyid   = $('#companyid').val();
                var billid      = $('#billidvalue').val();
                var selectbill  = $('#selectbill').val();
                var depart      = $('#Department_Id').val();
                
                
                ajaxRequest = new XMLHttpRequest();
                
                ajaxRequest.onreadystatechange = function() {
                    if (ajaxRequest.readyState == 4) {
                        var ajaxDisplay = document.getElementById('depId');
                        ajaxDisplay.innerHTML = ajaxRequest.responseText;
                    }
                }
                
                ajaxRequest.open("GET", "<?php echo base_url('/index.php/ajaxshowform')?>?companyid=" + companyid +"&billid="+billid+"&selectbill="+selectbill+"&depart="+depart);
                ajaxRequest.send();
            }
        </script>
        <script>
            $(document).ready(function () {
                $('#submitformasteraction').click(function () {
                    
                    var companyid                   = $('#companyid').val();
                    var billid                      = $('#billidvalue').val();
                    var selectbill                  = $('#selectbill').val();
                    var depart                      = $('#Department_Id').val();
                    var employeeid                  = $('#employeeid').val();
                    var unitid                      = $('#unitid').val();
                    var actualtime                  = $('#actualtime').val();
                    var targetmappingtimehours      = $('#targetmappingtimehours').val();
                    var mappingdelaytime            = $('#mappingdelaytime').val();
                    var mappingremark               = $('#mappingremark').val();
                    if(employeeid!=''){
                        $.ajax({
                            url: '<?php echo base_url('/index.php/submitformasteraction') ?>',
                            type: 'POST',
                            dataType: 'json',
                            data: {
                                companyid               : companyid,
                                billid                  : billid,
                                selectbill              : selectbill,
                                depart                  : depart,
                                employeeid              : employeeid,
                                unitid                  : unitid,
                                actualtime              : actualtime,
                                targetmappingtimehours  : targetmappingtimehours,
                                mappingdelaytime        : mappingdelaytime,
                                mappingremark           : mappingremark,
                            },
                            success: function (response) {
                                console.log(response);
                                alert(response.message);
                            },
                            error: function (xhr, status, error) {
                                console.error(xhr.responseText);
                            }
                        });
                    }
                    else{
                        alert('Please Select Employee');
                    }
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