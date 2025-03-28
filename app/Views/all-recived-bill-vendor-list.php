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
            .bootstrap-select .btn{
                padding-top:12px;
                padding-bottom:12px;
                border:1px solid #00000045 !important;
            }
        </style>
    </head>
    <body>
        <div class="container-scroller">
            <?php include('include/vendor-header.php'); ?>
            <div class="container-fluid page-body-wrapper">
                <div class="main-panel">
                    <div class="content-wrapper">
                        <div class="row">
                            <div class="col-6">
                                <h3 class=" font-weight-bold"><span  style="cursor: pointer;" onclick="history.back()">&larr; Go Back</span></h3>
                            </div>
                            <div class="col-6"></div>
                        </div>
                        <div class="col-lg-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body cardbody">
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 List" style=""> 
                                            <h2>Recived Bill List</h2>
                                        </div>
                                    </div>
                                    <div class="table-responsive pt-3">
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th><b>Bill Date Time</b></th>
                                                    <th><b>Bill Pic </b></th>
                                                    <th><b>Bill Id </b></th>
                                                    <th><b>Company</b></th>
                                                    <th><b>Bill No  </b></th>
                                                    <th><b>Bill Amount</b></th>
                                                    <th><b>Bill Date</b></th>
                                                    <th><b>Gate Entry No </b></th>
                                                    <th><b>Gate Entry Date</b></th>
                                                    <th><b>Bill Type</b></th>
                                                    <th><b>Mapping Employee Name</b></th>
                                                    <th><b>Add By</b></th>
                                                    <th><b>Comments</b></th>
                                                    <th><b>Received DateTime</b></th>
                                                    <th><b>Status</b></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php 
                                            $stage_id=5;
                                            $result = $session->get();
                                            $etm = $result['ddn'];  
                                            $i=0+$etm;
                                            if(isset($dax)){
                                                foreach ($dax as $row){
                                                    $i = $i+1;
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $i; ?></td>
                                                        <td><?php echo   date('d-m-Y H:i:s', strtotime($row['DateTime']))?></td>
                                                        <td><a href="<?php echo base_url('public/vendors/PicUpload/'.$row['Bill_Pic']);?>" target="_blank">link</a></td>
                                                        <td><?php echo $row['id']; ?></td>
                                                        <td><?php echo $row['companyname'];?></td>
                                                        <td><?php echo $row['Bill_No']; ?></td>
                                                        <td><?php echo $row['Bill_Amount']; ?></td>
                                                        <td><?php echo   date('d-m-Y', strtotime($row['Bill_DateTime']))?></td>
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
                                                             $MappingEmprow= $EmployeeModelObj->where('id',$row['Department_Emp_Id'])->first();
                                                            if(isset($MappingEmprow) && $MappingEmprow!='')
                                                             {
                                                              echo $MappingEmprow['first_name']; 
                                                              echo " ".$MappingEmprow['last_name'];
                                                             }
                                                             ?> 
                                                        </td>
                                                        <td><?php echo $row['first_name']; ?> <?php echo $row['last_name']; ?></td>
                                                        <td><?php echo $row['Recived_Comment']; ?></td>
                                                        <td><?php echo $row['Recived_DateTime']; ?></td>
                                                        <td><?php if($row['Recived_Status']=='1'){ echo "Pending"; }elseif($row['Recived_Status']=='2'){ echo "Accepted"; }elseif($row['Recived_Status']=='3'){ echo "Rejected"; }else{ echo "Done"; } ?></td>
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
    </body>
</html>