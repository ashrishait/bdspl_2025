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
                                if(session()->has("Mapping_erpStystem"))
                                {   
                                    if(session("Mapping_erpStystem")==1)   
                                    {  
                                            echo "<div class='alert alert-success' role='alert'>Bill Send to A/c </div>";
                                    }
                                    elseif(session("Mapping_erpStystem")==2)   
                                    {  
                                            echo "<div class='alert alert-danger' role='alert'>Bill Already Sent to A/c</div>";
                                    }
                                    else{
                                        echo "<div class='alert alert-danger' role='alert'>Not Mapping!! </div>";   
                                    }
                                }
                                if(session()->has("Bill_Acceptation_Status"))
                                    {   
                                        if(session("Bill_Acceptation_Status")==1)   
                                        {  
                                            echo "<div class='alert alert-success' role='alert'>Successfully Change Status  . </div>";
                                        }
                                        elseif(session("Bill_Acceptation_Status")==2)   
                                        {  
                                            echo "<div class='alert alert-danger' role='alert'>Bill Already Accepted</div>";
                                        }
                                        else{
                                            echo "<div class='alert alert-danger' role='alert'>Not Successfully Change Status  . ! </div>";   
                                        }
                                    }
                                    if(session()->has("Master_Action_SMS"))
                                    {   
                                        if(session("Master_Action_SMS")==1)   
                                        {  
                                            echo "<div class='alert alert-success' role='alert'>Successfully  added the master Action. </div>";
                                        }
                                        elseif(session("Master_Action_SMS")==2){
                                            echo "<div class='alert alert-danger' role='alert'>Master Action already uploaded</div>";   
                                        }
                                        else{
                                            echo "<div class='alert alert-danger' role='alert'>Not Successfully ! </div>";   
                                        }
                                    }
                                ?>    
                            </div>
                        </div>   
                        <div class="col-md-12 col-sm-12 List p-3">
                            <div class="row">
                                <div class="col-md-10">
                                    <form method="get" action="<?php echo site_url('/all_erpStystem_list'); ?>" enctype="multipart/form-data"> 
                                        <div class="row">
                                            <div class="col-md-3 col-sm-3">
                                                <select name="Vendor_Id" class="form-control filterserach" id="select-country" data-live-search="true" style="width: 100%;" onchange="submit()"> 
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
                                                <select name="Unit_Id" class="form-control filterserach" id="Unit_Id" onchange="submit()" style="padding: 0.9rem 1.375rem; outline: 0px solid #f1f6f8;">
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
                                                <select name="Satus" class="form-control filterserach" required onchange="submit()" style="padding: 0.9rem 1.375rem; outline: 0px solid #f1f6f8;"> 
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
                                       <h2>Debit Note</h2>
                                    </div>
                                    <div class="col-md-2">
                                       
                                    </div>
                                    <div class="col-md-5">
                                        <?php
                                        if($ViewOnly==1)
                                        { }
                                        else{
                                            ?>
                                            <button type="button" class="btn btn-success btn-lg float-end me-2" data-bs-toggle="modal" data-bs-target="#sendtobillreceiving">
                                                Update Status
                                            </button>
                                            <?php 
                                        }
                                        ?>    
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
                                                    <th class="bg-white"><b>Send To </b></th>
                                                    <th class="bg-white"><b>Image </b></th>
                                                    <th class="bg-white"><b>Amount </b></th>
                                                    <th class="bg-white"><b>To Account</b></th>
                                                    <th class="bg-white"><b>Manager Image </b></th>
                                                    <th class="bg-white"><b>Manager Remark </b></th>
                                                    <th class="bg-white"><b>Account Image </b></th>
                                                    <th class="bg-white"><b>Amount</b></th>
                                                    <th class="bg-white"><b>Vendor Image </b></th>
                                                    <th class="bg-white"><b>Vendor Remark </b></th>
                                                    <th class="bg-white"><b>Action </b></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                $stage_id=4;
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
                                                            <td><?php echo date('d-m-Y', strtotime($row['Bill_DateTime']))?></td>
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
                                                            $MappingEmprow= $EmployeeModelObj->where('id',$row['Send_Note_By'])->first();
                                                            if(isset($MappingEmprow) && $MappingEmprow!='')
                                                            {
                                                              echo $MappingEmprow['first_name']; 
                                                              echo " ".$MappingEmprow['last_name'];
                                                            }
                                                            ?></td>
                                                            
                                                            <td><?php 
                                                            $MappingEmprow= $EmployeeModelObj->where('id',$row['Send_Note_To'])->first();
                                                            if(isset($MappingEmprow) && $MappingEmprow!='')
                                                            {
                                                              echo $MappingEmprow['first_name']; 
                                                              echo " ".$MappingEmprow['last_name'];
                                                            }
                                                            ?></td>
                                                            <td>
                                                                <?php 
                                                                if(!empty($row['Send_Note_Image'])){ ?>
                                                                <a href="<?php echo base_url('public/vendors/PicUpload/'.$row['Send_Note_Image']);?>" target="_blank"><?php if(!empty($row['Send_Note_Image'])) { ?>link<?php } ?></a>
                                                                <?php } ?>
                                                            </td>
                                                            <td><?php echo $row['Send_Note_Remark']; ?></td>
                                                            <td><?php 
                                                            $MappingEmprow= $EmployeeModelObj->where('id',$row['Send_Note_To_Account_By'])->first();
                                                            if(isset($MappingEmprow) && $MappingEmprow!='')
                                                            {
                                                              echo $MappingEmprow['first_name']; 
                                                              echo " ".$MappingEmprow['last_name'];
                                                            }
                                                            ?></td>
                                                            <td>
                                                                <?php 
                                                                if(!empty($row['Send_Account_Note_Image'])){ ?>
                                                                <a href="<?php echo base_url('public/vendors/PicUpload/'.$row['Send_Account_Note_Image']);?>" target="_blank"><?php if(!empty($row['Send_Account_Note_Image'])) { ?>link<?php } ?></a>
                                                                <?php } ?>
                                                            </td>
                                                            <td><?php echo $row['Send_Note_Account_Remark']; ?></td>
                                                            <td>
                                                                <?php 
                                                                if(!empty($row['Send_Vendor_Note_Image'])){ ?>
                                                                <a href="<?php echo base_url('public/vendors/PicUpload/'.$row['Send_Vendor_Note_Image']);?>" target="_blank"><?php if(!empty($row['Send_Vendor_Note_Image'])) { ?>link<?php } ?></a>
                                                                <?php } ?>
                                                            </td>
                                                            <td><?php echo $row['Send_Note_Vendor_Remark']; ?></td>

                                                            <td><?php echo $row['Vendor_Debit_Note_Remark']; ?></td>
                                                            <td>
                                                                <?php 
                                                                if(!empty($row['Vendor_Debit_Note_Update'])){ ?>
                                                                <a href="<?php echo base_url('public/vendors/PicUpload/'.$row['Vendor_Debit_Note_Update']);?>" target="_blank"><?php if(!empty($row['Vendor_Debit_Note_Update'])) { ?>link<?php } ?></a>
                                                                <?php } ?>
                                                            </td>
                                                            <td>
                                                                <?php
                                                                if($row['Send_Note_Account_Status']==1 && $row['Send_Note_Vendor_Status'] != 1){ ?>
                                                                    <span class="span text-warning" data-bs-toggle="modal" data-bs-target="#bd-example-modal-lg-mappBill-<?php echo $row['id']; ?>" title="Accepted"><span class="mdi mdi-account-check-outline"></span></span>
                                                                <?php }
                                                                elseif($row['Send_Note_Vendor_Status']==1){

                                                                }
                                                                else{ ?>
                                                                    
                                                                <?php }
                                                                ?>
                                                                <a href="<?php echo base_url();?>/index.php/complete-detail-of-sigle-bill/<?php echo $row['id']; ?>"><span class="mdi mdi-eye-circle"></span></a>
                                                            </td>
                                                        </tr> 
                                                        <div class="modal fade bs-example-modal-lg" id="bd-example-modal-lg-mappBill-<?php echo $row['id']; ?>" tabindex="<?php echo $row['id']; ?>" role="dialog" aria-labelledby="bd-example-modal-lg-del-<?php echo $row['id']; ?>" aria-hidden="true">
                                                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                                                <div class="modal-content">
                                                                    <div class="modal-header bg-warning">
                                                                        <h4 class="modal-title text-white" id="myLargeModalLabel">Send to Account</h4>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="">
                                                                            <div class="row">   
                                                                                <form method="post" action="<?php echo site_url('/send-debit-note-to-vendor'); ?>" enctype="multipart/form-data">
                                                                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                                                                    <input type="hidden" name="action" value="all">
                                                                                    
                                                                                    <div class="col-sm-12 col-md-6">
                                                                                        <div class="form-group">
                                                                                            <label for="billpic" >Upload Image<span style="color:red;"></span></label>
                                                                                            <input class="form-control" type="file" name="E_Image"  id="billpic">
                                                                                        </div> 
                                                                                    </div>  
                                                                                    <div class="col-sm-12 col-md-6">
                                                                                        <div class="form-group">
                                                                                            <label>Amount</label>
                                                                                            <textarea name="ERP_Remark" class="form-control "><?php echo $row['ERP_Remark']; ?></textarea>
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
                        <div class="modal fade" id="sendtobillreceiving" tabindex="-1" role="dialog" aria-labelledby="sendtobillreceiving" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header bg-success">
                                        <h4 class="modal-title text-white" id="myLargeModalLabel">Send to account department</h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="">
                                            <form method="post" action="" enctype="multipart/form-data">  
                                                <div class="row"> 
                                                    <input type="hidden" name="bilcompanyid" id="bilcompanyid" class="form-control" value="<?php echo $compeny_id;?>">
                                                    <div class="col-sm-12 col-md-6" >
                                                        <div class="form-group">
                                                            <label>Bill Id</label>
                                                            <input type="text" name="bilid" id="bilid" class="form-control" placeholder="Bill Id">
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
                                                            <label>Amount</label>
                                                            <textarea name="ERP_Remark" id="erpremark" class="form-control "></textarea>
                                                        </div> 
                                                    </div>
                                                    <div class="col-sm-12 col-md-12">
                                                        <button type="button" class="btn btn-success btn-lg" id="sendtobillreceivingayaccount">Submit</button>
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
                $('#sendtobillreceivingayaccount').click(function () {
                    var companyid            = $('#bilcompanyid').val();
                    var billid               = $('#bilid').val();
                    var erpremark            = $('#erpremark').val();
                    var E_Image              = $('#E_Imageerp')[0].files[0];; // Get the selected file
            
                    var formData = new FormData();
                    formData.append('companyid', companyid);
                    formData.append('billid', billid);
                    formData.append('erpremark', erpremark);
                    formData.append('E_Image', E_Image);
            
                    $.ajax({
                        url: '<?php echo base_url('/index.php/debit-note-to-vendor') ?>',
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