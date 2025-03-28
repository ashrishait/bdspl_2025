<?php 
use App\Models\StateModel; 
use App\Models\CityModel;
use App\Models\UnitModel;
use App\Models\RollModel;
use App\Models\EmployeeModel;
use App\Models\PartyUserModel;
use App\Models\BillRegisterModel;
use App\Models\DepartmentModel;
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
<?php include('include/header.php'); ?>
<div class="container-fluid page-body-wrapper">
<div class="main-panel">
    <div class="content-wrapper">
    <div class="row">
    <div class="col-lg-12 mb-lg-0">
        <div class="card congratulation-bg py-0" style="background:none;">
            <div class="card-body py-0">
                <div class="container">
                    <div class="row">
                        <div class="col-6">
                           
                         <h2 class="mb-3 font-weight-bold">Accepted Bill Mapping List</h2>
                        </div>
                        <div class="col-6">
                                        

                    

                    </div>
                </div>
          </div>       
      </div>
     </div>
   </div>
  </div>
    <div class="container">
        <div class="row">
                <div class="col-md-12 col-sm-12"> 
                <?php
               

                  if(session()->has("Mapping_Department"))
                   {   
                    if(session("Mapping_Department")==1)   
                    {  
                            echo "<div class='alert alert-success' role='alert'>Successfully Change Status  . </div>";
                    }
                    else{
                        echo "<div class='alert alert-danger' role='alert'>Not Successfully Department Mapping Bill ! </div>";   
                    }
                }

                ?>    
            </div>
        </div>  
        


             <div class="col-lg-12 grid-margin stretch-card">
                 <div class="container">
                  <div class="card">
                     <div class="card-body">
                       <div class="table-responsive pt-3">
                         <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                   
                                    <th>Bill No</th>
                                    <th>Add By</th>
                                    <th>Gate Entry No</th>
                                    <th>Department Name</th>
                                    <th>Vendor Name</th>
                              
                                    <th>Bill Amount</th>
                                    <th>Remark</th>
                                    <th>Bill Date_Time</th>
                                    <th>Gate_Entry  Date</th>
                                    <th>Bill Pic</th>
                                  <th>Acceptation Status</th>
                                  <th>Acceptation DateTime</th>
                                    <th>_______Action_____</th>
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
                                    ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $row['Bill_No']; ?></td>
                                     
                                        <td><?php echo $row['first_name']; ?> <?php echo $row['last_name']; ?></td>
                                        <td><?php echo $row['Gate_Entry_No']; ?></td>
                                        <td><?php 

                                         $Departmentrow= $DepartmentModelObj->where('id',$row['Department_Id'])->first();
                                        if(isset($Departmentrow) && $Departmentrow!='')
                                         {
                                         echo $Departmentrow['name'];
                                         }
                                         ?></td>

                                          <td><?php 
                                         $Vendorrow= $PartyUserModelObj->where('id',$row['Vendor_Id'])->first();
                                        if(isset($Vendorrow) && $Vendorrow!='')
                                         {
                        ; 
                                echo $Vendorrow['Name']; 
                                         }
                                         ?></td>

                                    
                                        <td><?php echo $row['Bill_Amount']; ?></td>
                                        
                                     
                                        
                                        <td><?php echo $row['Remark']; ?></td>
                                              <td><?php echo $row['Bill_DateTime']; ?></td>
                                        <td><?php echo $row['Gate_Entry_Date']; ?></td>
                                         <td><a href="<?php echo base_url('public/vendors/PicUpload/'.$row['Bill_Pic']);?>" target="_blank">link</a></td>
                                        
                                        <td><?php 
                                        if($row['Bill_Acceptation_Status']==1)
                                                {
                                                echo "Pending";
                                                }
                                                elseif($row['Bill_Acceptation_Status']==2)
                                                {
                                                echo "Accepted";
                                                }
                                                 elseif($row['Bill_Acceptation_Status']==3)
                                                {
                                                echo "Reject";
                                                }
                                                elseif($row['Bill_Acceptation_StatusChange']==4)
                                                {
                                                echo "Done";
                                                }
                                         ?></td>
                                          <td><?php echo $row['Bill_Acceptation_DateTime']; ?></td>
                                          <td>
                                       
                                          
                                           <!--  <a class="btn btn-success btn-sm" href="<?php echo 'view_bill_register_print/'.$row['id']; ?>" target="_blank">View</a>-->
                                        
                                             

                                               <div class="dropdown">
                                                  <button class="dropbtn">Action</button>
                                                  <div class="dropdown-content">
                                                 
                                                  
                                                         <!--<a href="#"><span  data-toggle="modal" data-target="#bd-example-modal-lg-BillStatus-<?php echo $row['id']; ?>"><i class="fa fa-eye"></i>Status</span></a>-->


                                                         <a href="#"><span  data-toggle="modal" data-target="#bd-example-modal-lg-mappBill-<?php echo $row['id']; ?>"><i class="fa fa-eye"></i>Mapping</span></a>
                                                    
                                                  </div>
                                                </div>
                                      </td>
                                        
                                </tr> 
                                                            
    

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
                      
                                <form method="post" action="<?php echo site_url('/Department_Mapping_BillReg'); ?>">
                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">


                                      <div class="col-sm-12 col-md-6">
                                    <div class="form-group">
                                      <label> TargetTimeToMaping Bill</label>
                                     <input type="text" name="TargetMapping_Time_Hours" class="form-control "style="padding: 0.875rem 1.375rem" value="<?php echo $Departmentrow['Mapping_Time_Hours']; ?>" readonly > 
                                          
                                          

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
                                                
                                                    ?>
                                                    <option value="<?php echo $row17['id']; ?>" <?php if($row['Bill_Type']==$row17['id']) {echo 'selected="selected"';} ?>><?php echo ucwords($row17['name']); ?></option>
                                            <?php }} ?> 
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
                                            <?php }}} ?> 
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
                                                              $Unit_Id=$row['Unit_Id'];                                                
                                                            $rowEMP = $EmployeeModelObj->where('department',$Department_Id)->findAll();
                                                                   if(isset($rowEMP) && $rowEMP!='')
                                                                        {
                                                                       foreach ($rowEMP as $rowEMP)
                                                                        { 

                                                                            ?>
                                                                <option value="<?php echo $rowEMP['id']; ?>" <?php if($row['Department_Emp_Id']==$rowEMP['id']) {echo 'selected="selected"';} ?>><?php echo ucwords($rowEMP['first_name']); ?></option>
                                                                            <?php
                                                                        }
                                                                        }
                                                                            ?>

                                                                </select>
                                                             
                                                            </div>
                                                        </div>

                                     <div class="col-sm-12 col-md-6">
                                    <div class="form-group">
                                      <label> Actual Date & Time</label>
                                     <input type="text" name="" class="form-control "style="padding: 0.875rem 1.375rem" value="<?php echo $row['Bill_DateTime']; ?>" readonly > 
                                          
                                          

                                    </div> 
                                   </div>
                                   <?php
                                $time = $Departmentrow['Mapping_Time_Hours'];
                                [$hours, $minutes] = explode(':', $time);

                               $minitus=(int)$hours * 60 + (int)$minutes;

                                $cur_time=$row['Bill_DateTime'];
                                $duration='+'.$minitus.' minutes';
                                $addedDateTime=date('Y-m-d H:i:s', strtotime($duration, strtotime($cur_time)));
                                 $cur_Datetime=date('Y-m-d H:i:s');
                               ?>
                                    <div class="col-sm-12 col-md-6">
                                    <div class="form-group">
                                      <label>Delay Or  On-Time</label>
                                      <select name="Mapping_Delay_On_Time" class="form-control "style="padding: 0.875rem 1.375rem" > 
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
                                      <label>Remark</label>
                                      <textarea name="Mapping_Remark" class="form-control "> 
                                          <?php echo $row['Mapping_Remark']; ?>
                                        </textarea>

                                    </div> 
                                   </div>
                                   
                                     <div class="col-sm-12 col-md-12">
                                    <button type="submit" class="btn btn-success">Mapping</button>
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
            <div>
            <br>
        <!--    <?php if($session->get("ddn")>=20){ ?><a href="<?php echo base_url('/index.php/ddxm');?>" class="btn btn-sm btn-primary"> << previous</a>-----<?php } ?>
            <a href="<?php echo base_url('/index.php/ddx');?>" class="btn btn-sm btn-primary">next >></a>-->
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
  
  </body>
</html>