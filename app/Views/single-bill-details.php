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
                            <div class="col-4">
                                <h3 class=" font-weight-bold"><span  style="cursor: pointer;" onclick="history.back()">&larr; Go Back</span></h3>
                            </div>
                            <div class="col-4">
                                <form method="post" action="<?php echo base_url('/index.php/barcodeuid');?>">
			                        <input type="hidden" name="companyid" id="companyid" class="form-control" value="<?php echo $compeny_id;?>" />
			                        <input type="text" name="enteruid" id="searchInput" placeholder="Scan Barcode Or Enter Bill UID" class="form-control"/>
			                        <!-- Suggestions dropdown -->
                                    <ul id="suggestionsList"></ul>
			                    </form>
                            </div>
                            <div class="col-4">
                            </div>
                        </div>
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
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body cardbody" style=""> 
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 List" style=""> 
                                        <h2> Bill Mapping List</h2>
                                    </div>
                                </div>
                                <div class="table-responsive pt-3">
                                    <table class="table table-bordered table-hover">
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
                                                    <th>Sl No</th>
                                                    <td><?php echo $i; ?></td>
                                                    <th><b>Bill Date Time</b></th>
                                                    <td><?php echo   date('d-m-Y H:i:s', strtotime($row['DateTime']))?></td>
                                                    <th><b>Bill Pic </b></th>
                                                    <td><a href="<?php echo base_url('public/vendors/PicUpload/'.$row['Bill_Pic']);?>" target="_blank">link</a></td>
                                                </tr>
                                                <tr>
                                                    <th><b>Bill Id </b></th>
                                                    <td><?php echo $row['uid']; ?></td>
                                                    <th><b>Vendor Name </b></th>
                                                    <td><?php 
                                                    $Vendorrow= $PartyUserModelObj->where('id',$row['Vendor_Id'])->first();
                                                    if(isset($Vendorrow) && $Vendorrow!='')
                                                    {
                                                        echo $Vendorrow['Name']; 
                                                    }
                                                    ?></td>
                                                    <th><b>Bill No  </b></th>
                                                    <td><?php echo $row['Bill_No']; ?></td>
                                                </tr>
                                                <tr>
                                                    <th><b>Bill Amount</b></th>
                                                    <td><?php echo $row['Bill_Amount']; ?></td>
                                                    <th><b>Bill Date</b></th>
                                                    <td><?php echo   date('d-m-Y', strtotime($row['Bill_DateTime']))?></td>
                                                    <th><b>Unit Name  </b></th>
                                                    <td><?php 
                                                        $Unitrow= $UnitModelObj->where('id',$row['Unit_Id'])->first();
                                                        if(isset($Unitrow) && $Unitrow!='')
                                                        {
                                                            echo $Unitrow['name']; 
                                                        }
                                                        ?> 
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th><b>Gate Entry No </b></th>
                                                    <td><?php echo $row['Gate_Entry_No']; ?></td>
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
                                                    <td><?php if($row['Add_By_Vendor']==1){ echo "Add By Vendor"; } else{echo $row['first_name']; ?> <?php echo $row['last_name'];} ?></td>
                                                    <th><b>Acceptation Comments</b></th> 
                                                    <td><?php echo $row['Bill_Acceptation_Status_Comments']; ?></td>
                                                </tr>   
                                                <tr>
                                                    <th><b>Acceptation DateTime</b></th>
                                                    <td><?php echo $row['Bill_Acceptation_DateTime']; ?></td>
                                                    <th><b>Action</b></th>
                                                    <td>
                                                    <?php 
                                                    if($row['Bill_Acceptation_Status']==1)
                                                    {
                                                        ?>
                                                        <span class="span"  style="color:blue"  data-toggle="modal" data-target="#bd-example-modal-lg-BillStatus-<?php echo $row['id']; ?>"><i class="fa fa-eye"></i>Pending</span>
                                                        <?php
                                                    }
                                                    elseif($row['Bill_Acceptation_Status']==2)
                                                    {
                                                    ?>
                                                        <span class="span" style="color:#d7c706" data-toggle="modal" data-target="#bd-example-modal-lg-mappBill-<?php echo $row['id']; ?>"><i class="fa fa-eye"></i>Accepted</span>
                                                    <?php
                                                    }
                                                    elseif($row['Bill_Acceptation_Status']==3)
                                                    {
                                                        ?>
                                                        <span class="span" style="color:red" data-toggle="modal" data-target="#<?php echo $row['id']; ?>"><i class="fa fa-eye"></i>Rejected</span>
                                                        <?php
                                                    }
                                                    elseif($row['Bill_Acceptation_Status']==4)
                                                    {
                                                    ?>  
                                                        <?php 
                                                        if($row['Clear_Bill_Form_Status']==1)
                                                        {
                                                            ?>
                                                               <span class="span"  style="color:blue" data-toggle="modal" data-target="#bd-example-modal-lg-verifyStatus-<?php echo $row['id']; ?>"><i class="fa fa-eye"></i>Pending</span>
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
                                                                    <span class="span" style="color:#d7c706" data-toggle="modal" data-target="#bd-example-modal-lg-mappBill-<?php echo $row['id']; ?>"><i class="fa fa-eye"></i>Accepted </span>
                                                                    <?php
                                                                }
                                                                else
                                                                {
                                                                    ?>
                                                                    <span class="span"   style="color:#d7c706" data-toggle="modal" data-target="#bd-example-modal-lg-MasterAction-<?php echo $row['id']; ?>"><i class="fa fa-eye"></i>Master Action </span>
                                                                    <?php
                                                                }
                                                            }
                                                            else
                                                            {
                                                                ?>
                                                                    <span class="span" style="color:#d7c706" data-toggle="modal" data-target="#bd-example-modal-lg-mappBill-<?php echo $row['id']; ?>"><i class="fa fa-eye"></i>Accepted </span>
                                                                <?php
                                                            }
                                                        }
                                                        elseif($row['Clear_Bill_Form_Status']==3)
                                                        {
                                                            ?>
                                                                <span class="span"  style="color:red" data-toggle="modal" data-target="#<?php echo $row['id']; ?>"><i class="fa fa-eye"></i>Reject</span>
                                                            <?php
                                                        }
                                                        elseif($row['Clear_Bill_Form_Status']==4)
                                                        {
                                                            ?>
                                                            <?php 
                                                            if($row['ERP_Status']==1)
                                                            {
                                                                ?>
                                                                <span class="span" data-toggle="modal" data-target="#bd-example-modal-lg-erpStatus-<?php echo $row['id']; ?>"  style="color:blue"><i class="fa fa-eye"></i>Pending</span>
                                                                <?php
                                                            }
                                                            elseif($row['ERP_Status']==2)
                                                            {
                                                                $MasterActionmadelObj = new MasterActionModel();
                                                                $rowMasterAction1= $MasterActionmadelObj->where('compeny_id', $compeny_id)->where('stage_id',$stage_id)->orderBy('id','desc')->first();
                                                                if(isset($rowMasterAction1) && $rowMasterAction1!='')
                                                                {
                                                                    if($rowMasterAction1['no_of_action']==$row['ERP_Master_Action'])
                                                                    {
                                                                        ?>
                                                                        <span class="span" data-toggle="modal" data-target="#bd-example-modal-lg-erpmappBill-<?php echo $row['id']; ?>" style="color:#d7c706"><i class="fa fa-eye"></i>Accepted </span>
                                                                        <?php
                                                                    }
                                                                    else
                                                                    {
                                                                        ?>
                                                                        <span class="span" style="color:#d7c706" data-toggle="modal" data-target="#erpbd-example-modal-lg-MasterAction-<?php echo $row['id']; ?>"><i class="fa fa-eye"></i>Master Action </span>
                                                                        <?php 
                                                                    }
                                                                }
                                                                else{
                                                                    ?>
                                                                    <span  class="span" data-toggle="modal" data-target="#bd-example-modal-lg-erpmappBill-<?php echo $row['id']; ?>" style="color:#d7c706"><i class="fa fa-eye"></i>Accepted </span>
                                                                   <?php
                                                                }
                                                            }
                                                            elseif($row['ERP_Status']==3)
                                                            {
                                                                ?>
                                                                <span class="span" data-toggle="modal" data-target="#<?php echo $row['id']; ?>"  style="color:red"><i class="fa fa-eye"></i>Reject</span>
                                                                <?php
                                                            }
                                                            elseif($row['ERP_Status']==4)
                                                            {
                                                                ?>
                                                                <?php 
                                                                if($row['Recived_Status']==1)
                                                                {
                                                                    ?>
                                                                    <span class="span" data-toggle="modal" data-target="#bd-example-modal-lg-receivedStatus-<?php echo $row['id']; ?>"  style="color:blue"><i class="fa fa-eye"></i>Pending</span>
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
                                                                            <span class="span" data-toggle="modal" data-target="#bd-example-modal-lg-receivedmappBill-<?php echo $row['id']; ?>" style="color:#d7c706"><i class="fa fa-eye"></i>Accepted </span>
                                                                            <?php
                                                                        }
                                                                        else
                                                                        {
                                                                            ?>
                                                                            <span class="span" style="color:#d7c706" data-toggle="modal" data-target="#bd-example-modal-lg-receivedMasterAction-<?php echo $row['id']; ?>"><i class="fa fa-eye"></i>Master Action </span>
                                                                            <?php
                                                                        }
                                                                    }
                                                                    else{
                                                                        ?>
                                                                        <span  class="span" data-toggle="modal" data-target="#bd-example-modal-lg-receivedmappBill-<?php echo $row['id']; ?>" style="color:#d7c706"><i class="fa fa-eye"></i>Accepted </span>
                                                                       <?php
                                                                    }
                                                                }
                                                                elseif($row['Recived_Status']==3)
                                                                {
                                                                    ?>
                                                                        <span class="span" data-toggle="modal" data-target="#<?php echo $row['id']; ?>"  style="color:red"><i class="fa fa-eye"></i>Reject</span>
                                                                        <?php
                                                                    }
                                                                    elseif($row['Recived_Status']==4)
                                                                    {
                                                                        ?>
                                                                        <span class="span" data-toggle="modal" data-target="#bd-example-modal-lg-mappBillView-<?php echo $row['id']; ?>" style="color:green"><i class="fa fa-eye"></i>Done</span>
                                                                        <br>
                                                                        <span class="span" data-toggle="modal" data-target="#bd-example-modal-lg-mappBillView-<?php echo $row['id']; ?>" style="color:blue"><i class="fa fa-eye"></i>View</span>
                                                                        <?php
                                                                    }
                                                                ?>
                                                                <?php
                                                            }
                                                            ?>
                                                            <?php
                                                        }
                                                        ?>
                                                    <?php
                                                    }
                                                    ?>
                                                    </td>
                                                </tr> 
                                                <div class="modal fade bs-example-modal-lg" id="bd-example-modal-lg-BillStatus-<?php echo $row['id']; ?>" tabindex="<?php echo $row['id']; ?>" role="dialog" aria-labelledby="bd-example-modal-lg-del-<?php echo $row['id']; ?>" aria-hidden="true">
                                                    <div class="modal-dialog modal-md modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header bg-success">
                                                                <h4 class="modal-title text-white" id="myLargeModalLabel">Are You Sure To Accept Status  Bill This </h4>
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="">
                                                                    <div class="row">   
                                                                        <form method="post" action="<?php echo site_url('/Bill_Acceptation_StatusChange'); ?>">
                                                                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                                                            <input type="hidden" name="action" value="all">
                                                                            <div class="col-sm-12 col-md-12" >
                                                                                <div class="form-group">
                                                                                    <select name="Bill_Acceptation_Status" class="form-control" style="padding: 0.875rem 1.375rem"> 
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
                                                                                <button type="submit" class="btn btn-success">Submit</button>
                                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
                                                            <div class="modal-header bg-success">
                                                                <h4 class="modal-title text-white" id="myLargeModalLabel">Are You Sure To Mapping Bill This Department!</h4>
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
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
                                                <div class="modal fade bs-example-modal-lg" id="bd-example-modal-lg-verifyStatus-<?php echo $row['id']; ?>" tabindex="<?php echo $row['id']; ?>" role="dialog" aria-labelledby="bd-example-modal-lg-del-<?php echo $row['id']; ?>" aria-hidden="true">
                                                            <div class="modal-dialog modal-md modal-dialog-centered">
                                                                <div class="modal-content">
                                                                    <div class="modal-header bg-success">
                                                                        <h4 class="modal-title text-white" id="myLargeModalLabel">Are You Sure To Clear Bill Form Status Change </h4>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="">
                                                                            <div class="row">   
                                                                                <form method="post" action="<?php echo site_url('/Clear_Bill_Form_StatusChange'); ?>">
                                                                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                                                                    <input type="hidden" name="action" value="1">
                                                                                    <div class="col-sm-12 col-md-12" >
                                                                                        <div class="form-group">
                                                                                            <select name="Clear_Bill_Form_Status" class="form-control" style="padding: 0.875rem 1.375rem"> 
                                                                                                <option value="1"<?php if($row['Clear_Bill_Form_Status']==1) {echo 'selected="selected"';} ?>>Pending</option>
                                                                                                <option value="2" <?php if($row['Clear_Bill_Form_Status']==2) {echo 'selected="selected"';} ?>>Accepted</option>
                                                                                                <option value="3" <?php if($row['Clear_Bill_Form_Status']==3) {echo 'selected="selected"';} ?>>Reject</option>
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-sm-12 col-md-12" >
                                                                                        <div class="form-group">
                                                                                            <input type="text" name="Clear_Bill_Form_Status_Comments" class="form-control" style="padding: 0.875rem 1.375rem" value="<?php echo $row['Clear_Bill_Form_Status_Comments'];?>"> 
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-sm-12 col-md-12">
                                                                                        <button type="submit" class="btn btn-success">Submit</button>
                                                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
                                                                <h4 class="modal-title text-white" id="myLargeModalLabel">Clear Bill Form View!</h4>
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="">
                                                                    <div class="row">   
                                                                        <form method="post" action="<?php echo site_url('/Department_Mapping_BillReg'); ?>">
                                                                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                                                            <div class="col-sm-12 col-md-6">
                                                                                <div class="form-group">
                                                                                    <label>ERP Employee </label>
                                                                                    <select name="Mapping_ERP_EmpId" class="form-control"  style="padding: 0.875rem 1.375rem" required> 
                                                                                        <option value="">-Select -</option> 
                                                                                        <?php
                                                                                        $rowEMP = $EmployeeModelObj->where('compeny_id', $compeny_id)->where('role',5)->findAll();
                                                                                        if(isset($rowEMP) && $rowEMP!='')
                                                                                        {
                                                                                            foreach ($rowEMP as $rowEMP1)
                                                                                            { 
                                                                                                ?>
                                                                                                <option value="<?php echo $rowEMP1['id']; ?>"<?php if($row['Mapping_ERP_EmpId']==$rowEMP1['id']) {echo 'selected="selected"';} ?> ><?php echo ucwords($rowEMP1['first_name']); ?></option>
                                                                                                <?php
                                                                                            }
                                                                                        }
                                                                                        ?>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-12 col-md-6">
                                                                                <div class="form-group">
                                                                                    <label> TargetTimeToMaping Bill</label>
                                                                                    <input type="text" name="TargetMapping_Time_Hours" class="form-control "style="padding: 0.875rem 1.375rem" value="<?php echo $row['TargetClearBillForm_Time_Hours']; ?>" readonly > 
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
                                                                                    <input type="text" name="Mapping_Delay_On_Time" class="form-control "style="padding: 0.875rem 1.375rem" value="  <?php echo $row['ClearBillForm_Delay_On_Time']; ?>" readonly > 
                                                                                </div> 
                                                                            </div>
                                                                            <div class="col-sm-12 col-md-6">
                                                                                <div class="form-group">
                                                                                    <label> Upload Any Image Link</label>
                                                                                    <br>
                                                                                    <a href="<?php echo base_url('public/vendors/PicUpload/'.$row['Clear_Bill_Form_AnyImage']);?>" target="_blank">link</a> 
                                                                                </div> 
                                                                            </div>
                                                                            <div class="col-sm-12 col-md-6">
                                                                                <div class="form-group">
                                                                                    <label>Remark</label>
                                                                                    <textarea name="Mapping_Remark" class="form-control "><?php echo $row['ClearBillForm_Remark']; ?></textarea>
                                                                                </div> 
                                                                            </div>
                                                                            <div class="col-sm-12 col-md-12">
                                                                                <!--<button type="submit" class="btn btn-success">Mapping</button>-->
                                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>        
                                                <div class="modal fade bs-example-modal-lg" id="bd-example-modal-lg-MasterAction-<?php echo $row['id']; ?>" tabindex="<?php echo $row['id']; ?>" role="dialog" aria-labelledby="bd-example-modal-lg-del-<?php echo $row['id']; ?>" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header bg-success">
                                                                <h4 class="modal-title text-white" id="myLargeModalLabel">Are You Sure To Master Action !</h4>
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="">
                                                                    <div class="row">   
                                                                        <form method="post" action="<?php echo site_url('/MasterAction_send'); ?>" enctype="multipart/form-data">
                                                                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                                                            <input type="hidden" name="stage_id" value="<?php echo $stage_id; ?>">
                                                                            <div class="col-sm-12 col-md-6">
                                                                                <div class="form-group">
                                                                                    <label>Master Action</label>
                                                                                    <select name="Master_ActionId" class="form-control "style="padding: 0.875rem 1.375rem" >
                                                                                        <?php
                                                                                        if($row['ClearFormBill_Master_Action']=='')
                                                                                        {
                                                                                            $no_of_action=0;
                                                                                        }
                                                                                        else
                                                                                        {
                                                                                            $no_of_action=$row['ClearFormBill_Master_Action']+0;
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
                                                                            <div class="col-sm-12 col-md-12">
                                                                                <div class="form-group">
                                                                                    <label for="billpic" >Remark<span style="color:red;"></span></label>
                                                                                    <input class="form-control" type="text" name="remark"  >
                                                                                </div> 
                                                                            </div> 
                                                                            <div class="col-sm-12 col-md-12">
                                                                                <button type="submit" class="btn btn-success">Submit</button>
                                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal fade bs-example-modal-lg" id="bd-example-modal-lg-erpStatus-<?php echo $row['id']; ?>" tabindex="<?php echo $row['id']; ?>" role="dialog" aria-labelledby="bd-example-modal-lg-del-<?php echo $row['id']; ?>" aria-hidden="true">
                                                    <div class="modal-dialog modal-md modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header bg-success">
                                                                <h4 class="modal-title text-white" id="myLargeModalLabel">Are You Sure To Clear Bill Form Status Change </h4>
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="">
                                                                    <div class="row">   
                                                                        <form method="post" action="<?php echo site_url('/ERP_StatusChange'); ?>">
                                                                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                                                            <input type="hidden" name="action" value="1">
                                                                            <div class="col-sm-12 col-md-12" >
                                                                                <div class="form-group">
                                                                                    <select name="ERP_Status" class="form-control" style="padding: 0.875rem 1.375rem"> 
                                                                                        <option value="1"<?php if($row['ERP_Status']==1) {echo 'selected="selected"';} ?>>Pending</option>
                                                                                        <option value="2" <?php if($row['ERP_Status']==2) {echo 'selected="selected"';} ?>>Accepted</option>
                                                                                        <option value="3" <?php if($row['ERP_Status']==3) {echo 'selected="selected"';} ?>>Reject</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-12 col-md-12" >
                                                                                <div class="form-group">
                                                                                    <input type="text" name="ERP_Comment" class="form-control" style="padding: 0.875rem 1.375rem" value="<?php echo $row['ERP_Comment'];?>"> 
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-12 col-md-12">
                                                                                <button type="submit" class="btn btn-success">Submit</button>
                                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal fade bs-example-modal-lg" id="bd-example-modal-lg-erpmappBill-<?php echo $row['id']; ?>" tabindex="<?php echo $row['id']; ?>" role="dialog" aria-labelledby="bd-example-modal-lg-del-<?php echo $row['id']; ?>" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header bg-success">
                                                                <h4 class="modal-title text-white" id="myLargeModalLabel">Are You Sure To ERP Up!</h4>
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="">
                                                                    <div class="row">   
                                                                        <form method="post" action="<?php echo site_url('/CheckUp_bill_ERPSytem'); ?>" enctype="multipart/form-data">
                                                                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                                                            <div class="col-sm-12 col-md-6">
                                                                                <div class="form-group">
                                                                                    <label>Acount Employee </label>
                                                                                    <select name="Mapping_Acount_EmpId" class="form-control"  style="padding: 0.875rem 1.375rem" required> 
                                                                                        <option value="">-Select -</option> 
                                                                                        <?php
                                                                                        $rowEMP = $EmployeeModelObj->where('compeny_id', $compeny_id)->where('role',6)->findAll();
                                                                                        if(isset($rowEMP) && $rowEMP!='')
                                                                                        {
                                                                                            foreach ($rowEMP as $rowEMP1)
                                                                                            { 
                                                                                                ?>
                                                                                                <option value="<?php echo $rowEMP1['id']; ?>"<?php if($row['Mapping_Acount_EmpId']==$rowEMP1['id']) {echo 'selected="selected"';} ?> ><?php echo ucwords($rowEMP1['first_name']); ?></option>
                                                                                                    <?php
                                                                                            }
                                                                                        }
                                                                                        ?>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-12 col-md-6">
                                                                                <div class="form-group">
                                                                                    <label> TargetTimeTo ERP_Time_Hours Bill</label>
                                                                                    <input type="text" name="Target_ERP_Time_Hours" class="form-control "style="padding: 0.875rem 1.375rem" value="<?php echo $Departmentrow['ERP_Time_Hours']; ?>" readonly > 
                                                                                </div> 
                                                                            </div>
                                                                            <div class="col-sm-12 col-md-6">
                                                                                <div class="form-group">
                                                                                    <label> Actual Date & Time</label>
                                                                                    <input type="text" name="" class="form-control "style="padding: 0.875rem 1.375rem" value="<?php echo $row['DateTime']; ?>" readonly > 
                                                                                </div> 
                                                                            </div>
                                                                            <?php
                                                                            $time = $Departmentrow['ERP_Time_Hours'];
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
                                                                                    <select name="ERP_Delay_On_Time" class="form-control "style="padding: 0.875rem 1.375rem" > 
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
                                                                                    <textarea name="ERP_Remark" class="form-control "><?php echo $row['ERP_Remark']; ?></textarea>
                                                                                </div> 
                                                                            </div>
                                                                            <div class="col-sm-12 col-md-12">
                                                                                <button type="submit" class="btn btn-success">Submit</button>
                                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal fade bs-example-modal-lg" id="bd-example-modal-lg-erpMasterAction-<?php echo $row['id']; ?>" tabindex="<?php echo $row['id']; ?>" role="dialog" aria-labelledby="bd-example-modal-lg-del-<?php echo $row['id']; ?>" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header bg-success">
                                                                <h4 class="modal-title text-white" id="myLargeModalLabel">Are You Sure To Master Action !</h4>
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="">
                                                                    <div class="row">   
                                                                        <form method="post" action="<?php echo site_url('/MasterAction_send'); ?>" enctype="multipart/form-data">
                                                                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                                                            <input type="hidden" name="stage_id" value="<?php echo $stage_id; ?>">
                                                                            <div class="col-sm-12 col-md-6">
                                                                                <div class="form-group">
                                                                                    <label>Master Action</label>
                                                                                    <select name="Master_ActionId" class="form-control "style="padding: 0.875rem 1.375rem" >
                                                                                        <?php
                                                                                        if($row['ERP_Master_Action']=='')
                                                                                        {
                                                                                            $no_of_action=0;
                                                                                        }
                                                                                        else
                                                                                        {
                                                                                            $no_of_action=$row['ERP_Master_Action']+0;
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
                                                                                <button type="submit" class="btn btn-success">Submit</button>
                                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal fade bs-example-modal-lg" id="bd-example-modal-lg-receivedStatus-<?php echo $row['id']; ?>" tabindex="<?php echo $row['id']; ?>" role="dialog" aria-labelledby="bd-example-modal-lg-del-<?php echo $row['id']; ?>" aria-hidden="true">
                                                    <div class="modal-dialog modal-md modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header bg-success">
                                                                <h4 class="modal-title text-white" id="myLargeModalLabel">Are You Sure To Clear Bill Form Status Change </h4>
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="">
                                                                    <div class="row">   
                                                                        <form method="post" action="<?php echo site_url('/RecivedBill_StatusChange'); ?>">
                                                                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                                                            <input type="hidden" name="action" value="1">
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
                                                                                <button type="submit" class="btn btn-success">Submit</button>
                                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal fade bs-example-modal-lg" id="bd-example-modal-lg-receivedmappBill-<?php echo $row['id']; ?>" tabindex="<?php echo $row['id']; ?>" role="dialog" aria-labelledby="bd-example-modal-lg-del-<?php echo $row['id']; ?>" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header bg-success">
                                                                <h4 class="modal-title text-white" id="myLargeModalLabel">Are You Sure To Recived 
                                                                Bill Check Up!</h4>
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="">
                                                                    <div class="row">   
                                                                        <form method="post" action="<?php echo site_url('/CheckUp_RecivedBill'); ?>" enctype="multipart/form-data">
                                                                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                                                            <div class="col-sm-12 col-md-6">
                                                                                <div class="form-group">
                                                                                    <label> TargetTime Recived Bill</label>
                                                                                    <input type="text" name="Recived_TragetTime_Hours" class="form-control "style="padding: 0.875rem 1.375rem" value="<?php echo $Departmentrow['BillRecived_Time_Hours']; ?>" readonly > 
                                                                                </div> 
                                                                            </div>
                                                                            <div class="col-sm-12 col-md-6">
                                                                                <div class="form-group">
                                                                                    <label> Actual Date & Time</label>
                                                                                    <input type="text" name="" class="form-control "style="padding: 0.875rem 1.375rem" value="<?php echo $row['DateTime']; ?>" readonly > 
                                                                                </div> 
                                                                            </div>
                                                                            <?php
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
                                                                                <button type="submit" class="btn btn-success">Submit</button>
                                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div> 
                                                <div class="modal fade bs-example-modal-lg" id="bd-example-modal-lg-receivedMasterAction-<?php echo $row['id']; ?>" tabindex="<?php echo $row['id']; ?>" role="dialog" aria-labelledby="bd-example-modal-lg-del-<?php echo $row['id']; ?>" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header bg-success">
                                                                <h4 class="modal-title text-white" id="myLargeModalLabel">Are You Sure To Master Action !</h4>
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="">
                                                                    <div class="row">   
                                                                        <form method="post" action="<?php echo site_url('/MasterAction_send'); ?>" enctype="multipart/form-data">
                                                                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                                                            <input type="hidden" name="stage_id" value="<?php echo $stage_id; ?>">
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
                                                                                <button type="submit" class="btn btn-success">Submit</button>
                                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
                                <div></div>
                            </div>
                        </div>
                    </div>    
                </div>
            </div>
        </div>  
        <?php include('include/footer.php')?>
    </div>
    <?php include('include/script.php'); ?>
    <script async src='https://www.googletagmanager.com/gtag/js?id=G-P7JSYB1CSP'></script>
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