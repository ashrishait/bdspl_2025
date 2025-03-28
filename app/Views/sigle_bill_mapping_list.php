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
                        <div class="row mb-4">
                            <div class="col-4">
                                <h3 class=" font-weight-bold"><span  style="cursor: pointer;" onclick="history.back()">&larr; Go Back</span></h3>
                            </div>
                            <div class="col-4">
                                
                            </div>
                            <div class="col-4"></div>
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
                    <div class="col-lg-12 grid-margin">
                        <div class="col-md-12 col-sm-12 List p-3">
                            <div class="row">
                                <div class="col-6">
                                   <h2>Bill Assignment</h2>
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
                                <div class="table-responsive pt-3">
                                    <table class="table table-bordered table-hover">
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
                                                    <th>#</th>
                                                    <td><?php echo $i; ?></td>
                                                    <th><b>Bill Date Time</b></th>
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
                                                    ?></td>
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
                                                    <th><b>Assign To</b></th>
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
                                                </tr>
                                                <tr>
                                                    <th><b>Acceptation Comments</b></th> 
                                                    <td><?php echo $row['Bill_Acceptation_Status_Comments']; ?></td>
                                                    <th><b>Acceptation DateTime</b></th>
                                                    <td><?php echo $row['Bill_Acceptation_DateTime']; ?></td>
                                                </tr> 
                                                <tr>
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
                                                                if($menun->Page_Id==4){
                                                                    if($row['Bill_Acceptation_Status']==1)
                                                                    {
                                                                        ?>
                                                                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#bd-example-modal-lg-BillStatus-<?php echo $row['id']; ?>">Pending</button>
                                                                        <?php
                                                                    }
                                                                    elseif($row['Bill_Acceptation_Status']==2)
                                                                    {
                                                                    ?>
                                                                        <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#bd-example-modal-lg-mappBill-<?php echo $row['id']; ?>">Accepted</button>
                                                                    <?php
                                                                    }
                                                                    elseif($row['Bill_Acceptation_Status']==3)
                                                                    {
                                                                        ?>
                                                                        <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#bd-example-modal-lg-BillStatus-<?php echo $row['id']; ?>">Rejected</button>
                                                                        <?php
                                                                    }
                                                                    elseif($row['Bill_Acceptation_Status']==4)
                                                                    {
                                                                    ?>  
                                                                        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#bd-example-modal-lg-mappBillView-<?php echo $row['id']; ?>">Mapping View</button>
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
                                                        if($row['Bill_Acceptation_Status']==1)
                                                        {
                                                            ?>
                                                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#bd-example-modal-lg-BillStatus-<?php echo $row['id']; ?>">Pending</button>
                                                            <?php
                                                        }
                                                        elseif($row['Bill_Acceptation_Status']==2)
                                                        {
                                                        ?>
                                                            <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#bd-example-modal-lg-mappBill-<?php echo $row['id']; ?>">Accepted</button>
                                                        <?php
                                                        }
                                                        elseif($row['Bill_Acceptation_Status']==3)
                                                        {
                                                            ?>
                                                            <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#bd-example-modal-lg-BillStatus-<?php echo $row['id']; ?>">Rejected</button>
                                                            <?php
                                                        }
                                                        elseif($row['Bill_Acceptation_Status']==4)
                                                        {
                                                        ?>  
                                                            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#bd-example-modal-lg-mappBillView-<?php echo $row['id']; ?>">Mapping View</button>
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
                                                <div class="modal fade bs-example-modal-lg" id="bd-example-modal-lg-BillStatus-<?php echo $row['id']; ?>" tabindex="<?php echo $row['id']; ?>" role="dialog" aria-labelledby="bd-example-modal-lg-del-<?php echo $row['id']; ?>" aria-hidden="true">
                                                    <div class="modal-dialog modal-md modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header bg-primary">
                                                                <h4 class="modal-title text-white" id="myLargeModalLabel">Are you sure you want to accept this bill </h4>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="">
                                                                    <div class="row">   
                                                                        <form method="post" action="<?php echo site_url('/Bill_Acceptation_StatusChange'); ?>">
                                                                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                                                            <input type="hidden" name="action" value="single">
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
                                                <div class="modal fade bs-example-modal-lg" id="bd-example-modal-lg-mappBill-<?php echo $row['id']; ?>" tabindex="<?php echo $row['id']; ?>" role="dialog" aria-labelledby="bd-example-modal-lg-del-<?php echo $row['id']; ?>" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header bg-warning">
                                                                <h4 class="modal-title text-white" id="myLargeModalLabel">Send to Bill Verification</h4>
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
                                                                <h4 class="modal-title text-white" id="myLargeModalLabel">Mapping View!</h4>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="">
                                                                    <div class="row">   
                                                                        <form method="post" action="<?php echo site_url('/Department_Mapping_BillReg'); ?>">
                                                                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                                                            <div class="col-sm-12 col-md-6">
                                                                                <div class="form-group">
                                                                                    <label> TargetTimeToMaping Bill</label>
                                                                                    <input type="text" name="TargetMapping_Time_Hours" class="form-control "style="padding: 0.875rem 1.375rem" value="<?php echo $row['TargetMapping_Time_Hours']; ?>" readonly > 
                                                                                </div> 
                                                                            </div>
                                                                            <div class="col-sm-12 col-md-6">
                                                                                <div class="form-group">
                                                                                    <label>Bill Type </label>
                                                                                    <select name="Bill_Type" class="form-control "style="padding: 0.875rem 1.375rem" id="" > 
                                                                                        <option value="" >select</option>
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
                                                                                    <select name="Department_Emp_Id" class="form-control"  style="padding: 0.875rem 1.375rem"> 
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
                                                                                    <input type="text" name="Mapping_Delay_On_Time" class="form-control "style="padding: 0.875rem 1.375rem" value="  <?php echo $row['Mapping_Delay_On_Time']; ?>" readonly > 
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
                </div>
            </div>
        </div>  
        <?php include('include/footer.php')?>
    </div>
    <?php include('include/script.php'); ?>
    <script async src='https://www.googletagmanager.com/gtag/js?id=G-P7JSYB1CSP'></script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
        <?php
      
           
         if(isset($dax)){
            foreach ($dax as $rowBillRegister)
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
                        ajaxRequest.open("GET", "<?php echo base_url('/index.php/ajax_single_mapping')?>?Department_Id=" +top, true);
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