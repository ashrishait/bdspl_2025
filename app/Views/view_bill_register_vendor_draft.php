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
                                ?>    
                            </div>
                        </div>   
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="col-md-12 col-sm-12 List p-3">
                                    <div class="row">
                                        <div class="col-md-4">
                                           <h2>Vendor Draft Bill List</h2>
                                        </div>
                                       <!--  <div class="col-md-4">
                                            <form method="post" action="echo base_url('/index.php/barcodeuid');?>">
            			                        <input type="hidden" name="companyid" id="companyid" class="form-control" value="<?php echo $compeny_id;?>" />
            			                        <input type="text" name="enteruid" id="searchInput" placeholder="Scan Barcode Or Enter Bill UID" class="form-control"/>
                                                <ul id="suggestionsList"></ul>
            			                    </form>
                                        </div> -->
                                        <div class="col-md-8">
                                            <button type="button" class="btn btn-success ms-2 float-end btn-lg" onclick="exportTableToExcel('myTable', 'table_export')">Export to Excel</button>
                                            <?php
                                            if($Roll_id==1||$Roll_id==5)
                                            {
                                                ?>
                                                <!-- <a class="btn btn-primary btn-lg" href=" echo base_url();?>/index.php/add_bill_register" style="float:right;">
                                                    <span class="bi bi-plus-square-dotted"></span> Add Bill
                                                </a> -->
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body p-1"> 
                                        <div class="table-responsive tableFixHead">
                                            <table class="table table-bordered table-hover" id="myTable">
                                                <thead>
                                                    <tr>
                                                        <th class="bg-white">#</th>
                                                        <th class="bg-white"><b>Bill Date Time</b></th>
                                                        <th class="bg-white"><b>Bill Pic</b></th>
                                                        <th class="bg-white"><b>Bill Id</b></th>
                                                        <th class="bg-white"><b>Vendor Name</b></th>
                                                        <th class="bg-white"><b>Bill No</b></th>
                                                        <th class="bg-white"><b>Bill Amount</b></th>
                    								    <th class="bg-white"><b>Bill Date</b></th>
                                                        <th class="bg-white"><b>Unit Name</b></th>
                    									<th class="bg-white"><b>Gate Entry No</b></th>
                                                        <th class="bg-white"><b>Gate Entry Date</b></th>
                                                        <th class="bg-white"><b>Remark</b></th>
                                                        <th class="bg-white"><b>Add By</b></th>
                                                        <th class="bg-white"><b>Action</b></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                    		                        <?php 
                    		                        $result = $session->get();
                                                    if(isset($users)){
                        								foreach ($users as $index => $row){
                        									// $i = $i+1;
                        									?>
                                                            <tr>
                    										    <td><?= $startSerial++ ?></td>
                                                                <td><?php echo   date('d-m-Y H:i:s', strtotime($row['DateTime']))?></td>
                                                                <td>
                                                                    <?php 
                                                                    if(!empty($row['Bill_Pic'])){ ?>
                                                                    <a href="<?php echo base_url('public/vendors/PicUploadDraft/'.$row['Bill_Pic']);?>" target="_blank">link</a>
                                                                    <?php } ?>
                                                                </td>
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
                                                                <td><?php echo $row['Remark']; ?></td>
                                                                <td><?php 
                                                                if($row['Add_By_Vendor']==1){
                                                                    echo "Vendor Self";
                                                                }
                                                                else{
                                                                    if($emp_id==$row['Add_By'])
                                                                    {
                                                                        echo "Self Add";
                                                                    }
                                                                    else
                                                                    {
                                                                        echo $row['first_name']; ?> <?php echo $row['last_name']; 
                                                                    }
                                                                }
                                                                ?></td>
                                                                <td>
                                                                    <?php 
                                                                    if($Roll_id=='1'){ ?>
                                                                    <span class="span text-primary" data-bs-toggle="modal" data-bs-target="#bd-example-modal-lg-Edit<?php echo $row['id']; ?>" title="Edit Bill"><span class="mdi mdi-pen"></span></span>
                                                                    <?php } ?>
                                                                    <?php 
                                                                        if($row['Bill_Acceptation_Status']==1||$row['Bill_Acceptation_Status']==3)
                                                                        {
                                                                            ?>
                                                                            
                                                                            <!-- <span class="span text-danger" data-bs-toggle="modal" data-bs-target="#bd-example-modal-lg-del-<?php echo $row['id']; ?>" title="Delete Bill"><span class="mdi mdi-trash-can-outline"></span></span> -->
                                                                            <a href="<?php echo base_url();?>/index.php/qr-codes/<?php echo $row['id']; ?>" target="_blank" class="text-dark" title="Generate QR Code"><span class="mdi mdi-qrcode-scan"></span></a>
                                                                            <?php
                                                                        }
                                                                        elseif($row['Recived_Status']==4)
                                                                        {
                                                                            ?>
                                                                                <span class="span text-secondary" title="Done"><span class="mdi mdi-check-all"></span></span>
                                                                            <?php
                                                                        }
                                                                        else
                                                                        {
                                                                            ?>
                                                                            <span class="span text-warning" title="Underprocess"><span class="mdi mdi-axis-z-rotate-clockwise"></span></span>
                                                                            <a href="<?php echo base_url();?>/index.php/qr-codes/<?php echo $row['id']; ?>" target="_blank" class="text-success" title="Generate QR Code"> <span class="mdi mdi-qrcode-scan"></a>
                                                                            <?php
                                                                        }
                                                                    ?>
                                                                    <a href="<?php echo base_url();?>/index.php/complete-detail-of-sigle-bill/<?php echo $row['id']; ?>"><span class="mdi mdi-eye-circle"></span></a>
                                                                </td>
                                                            </tr> 
                                                            <div class="modal fade bs-example-modal-lg" id="bd-example-modal-lg-del-<?php echo $row['id']; ?>" tabindex="<?php echo $row['id']; ?>" role="dialog"  aria-hidden="true">
                                                            	<div class="modal-dialog modal-sm modal-dialog-centered">
                                                            		<div class="modal-content">
                                                            			<div class="modal-header bg-danger">
                                                            				<h4 class="modal-title text-white" id="myLargeModalLabel">Are You Sure To Delete This Record!</h4>
                                                            				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            			</div>
                                                            			<div class="modal-body">
                                                            				<div class="">
                                                                				<div class="row">	
                                                                					<div class="col-sm-12 col-md-12">
                                                                    					<form method="post" action="<?php echo site_url('/del_bill_register'); ?>">
                                                                    						<input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                                                    						
                                                                    						<button type="submit" class="btn btn-danger">Delete</button>
                                                                    						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                    					</form>
                                                                					</div>
                                                                				</div>
                                                                			</div>
                                                            			</div>
                                                            		</div>
                                                            	</div>
                                                            </div>
                    
                                                                               
                                                            <div class="modal fade bs-example-modal-lg" id="bd-example-modal-lg-Edit<?php echo $row['id']; ?>" tabindex="<?php echo $row['id']; ?>" role="dialog" aria-labelledby="bd-example-modal-lg-Edit<?php echo $row['id']; ?>" aria-hidden="true">
                                                        		<div class="modal-dialog modal-lg modal-dialog-centered">
                                                        			<div class="modal-content">
                                                        				<div class="modal-header bg-success">
                                                        					<h4 class="modal-title text-white" id="myLargeModalLabel">Edit Details</h4>
                                                        					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        				</div>
                                                        				<div class="modal-body">
                                                                        	<form method="post" action="<?php echo site_url('/update_bill_register'); ?>" enctype="multipart/form-data"> 
                                                                            	<div class="">
                                                                                	<input  type="hidden" name="id" value="<?php echo $row['id']; ?>" >
                                                                                    <div class="row">
                                                                                        <div class="col-sm-12 col-md-6">
                                                                                            <div class="form-group">
                                                                                                <label for="billpic" >Vendor User<span style="color:red;">*</span></label>
                                                                                                <select name="Vendor_Id" class="form-control" style="padding: 0.875rem 1.375rem"> 
                                                                                                    <option value="">Select Vendor User</option>
                                                                                                    <?php
                                                                                                        if(isset($dax14)){
                                                                                                        foreach ($dax14 as $row14){ ?>
                                                                                                            <option value="<?php echo $row14->id; ?>" <?php if($row['Vendor_Id']==$row14->id) {echo 'selected="selected"';} ?>><?php echo ucwords($row14->Name); ?></option>
                                                                                                    <?php }} ?> 
                                                                                                </select>
                                                                                            </div> 
                                                                                        </div>  
                                                                                        <div class="col-sm-12 col-md-6">
                                                                                            <div class="form-group">
                                                                                                <label for="billpic" >Bill No<span style="color:red;">*</span></label>
                                                                                                <input class="form-control" type="text" name="Bill_No" placeholder=" Bill No" style="padding: 0.875rem 1.375rem" value="<?php echo $row['Bill_No']; ?>">
                                                                                            </div> 
                                                                                        </div>
                                                                                        <div class="col-sm-12 col-md-6">
                                                                                            <div class="form-group">
                                                                                                <label for="billpic" >Bill Date Time<span style="color:red;">*</span></label>
                                                                                                <?php 
                                                                                                $Bill_DateTime=date('Y-m-d', strtotime($row['Bill_DateTime']));
                                                                                                ?>
                                                                                                <input type="hidden" value="<?php echo  $Bill_DateTime; ?>" name='Bill_DateTimehidden'>
                                                                                                <input class="form-control" type="date" name="Bill_DateTime" placeholder="" style="padding: 0.375rem 1.375rem" value="<?php echo  $Bill_DateTime; ?>" >
                                                                                            </div> 
                                                                                        </div>
                                                                                        <div class="col-sm-12 col-md-6">
                                                                                            <div class="form-group">
                                                                                                <label for="billpic" >Bill Total Amount<span style="color:red;">*</span></label>
                                                                                                <input class="form-control" type="text" name="Bill_Amount" placeholder="Bill Amount" value="<?php echo $row['Bill_Amount']; ?>"  oninput="this.value = this.value.replace(/[^0-9.]/g, '')" required>
                                                                                            </div> 
                                                                                        </div>  
                                                                                        <div class="col-sm-12 col-md-6" >
                                                                                            <div class="form-group">
                                                                                                <label for="billpic" >Unit <span style="color:red;">*</span></label>
                                                                                                <select name="Unit_Id" class="form-control" id="Unit_Id<?php echo $row['id']; ?>" style="padding: 0.875rem 1.375rem" required>
                                                                                                    <option value="">-Select -</option>  
                                                                                                    <?php
                                                                                                    if(isset($dax15)){
                                                                                                        foreach ($dax15 as $row15){ ?>
                                                                                                            <option value="<?php echo $row15['id']; ?>" <?php if($row['Unit_Id']==$row15['id']) {echo 'selected="selected"';} ?>><?php echo ucwords($row15['name']); ?></option>
                                                                                                            <?php 
                                                                                                        }
                                                                                                    } ?>        
                                                                                                </select>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-sm-12 col-md-6">
                                                                                            <div class="form-group">
                                                                                                <label for="billpic" >Gate Entry No<span style="color:red;">*</span></label>
                                                                                                <input class="form-control" type="text" name="Gate_Entry_No" placeholder="Gate Entry No" value="<?php echo $row['Gate_Entry_No'];?>">
                                                                                            </div> 
                                                                                        </div>
                                                                                        <div class="col-sm-12 col-md-6">
                                                                                            <div class="form-group">
                                                                                                <label for="billpic" >Gate Entry Date</label>
                                                                                                <input class="form-control" type="date" name="Gate_Entry_Date" placeholder="" style="padding: 0.375rem 1.375rem" value="<?php echo $row['Gate_Entry_Date']; ?>">
                                                                                            </div> 
                                                                                        </div>
                                                                                        <div class="col-sm-12 col-md-6">
                                                                                            <div class="form-group"> 
                                                                                                <label for="billpic" >Remark</label>
                                                                                                <input class="form-control" type="text" name="Remark" placeholder="Remark if Any" value="<?php echo $row['Remark']; ?>">
                                                                                            </div> 
                                                                                        </div>
                                                                                        <div class="col-sm-6">
                                                                                            <div class="form-group">
                                                                                                <label>Bill Pic<span style="color:red;">*</span></label><br/>
                                                                                                <input type="hidden" name="db_image" value="<?php echo $row['Bill_Pic']; ?>">           
                                                                                                <img src="<?php echo base_url('public/vendors/PicUpload/'.$row['Bill_Pic']);?>" style="height:120px; width:auto;" id="output<?php echo $row['id']; ?>">
                                                                                                <input type="file" class="form-control" name="E_Image" onchange="loadFile(<?php echo $row['id']; ?>)">
                                                                                            </div> 
                                                                                        </div>  
                                                                                        <div class="col-sm-12 col-md-6" style="display: none;">
                                                                                            <div class="form-group">
                                                                                                <select name="Department_Id" class="form-control" style="padding: 0.875rem 1.375rem"  id="department<?php echo $row['id']; ?>" > 
                                                                                                    <option value="">-Select Department-</option>
                                                                                                    <?php
                                                                                                    if(isset($dax9)){
                                                                                                        foreach ($dax9 as $row9){ ?>
                                                                                                            <option value="<?php echo $row9['id']; ?>"  <?php if($row['Department_Id']==$row9['id']) {echo 'selected';} ?>><?php echo ucwords($row9['name']); ?></option>
                                                                                                            <?php 
                                                                                                        }
                                                                                                    } ?>    
                                                                                                </select>
                                                                                            </div> 
                                                                                        </div>  
                                                                                    </div>
                                                                                    <div class="row">
                                                                                		<div class="col-sm-12 col-md-6">
                                                                                			<button type="submit" class="btn btn-primary">Update</button>   
                                                                                			<button type="reset" class="btn btn-secondary">Reset</button>
                                                                                		</div>
                                                                                	</div>
                                                                                </div>    
                                                                            </form>
                                                                        </div>
                                                                	</div>
                                                                </div>
                                                            </div>
                                                            <?php 
                                                        } 
                                                    }?>
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
        <script>
            function exportTableToExcel(tableId, filename = 'export') {
                var tableSelect = document.getElementById(tableId);
                // Create an HTML string
                var tableHTML = '<table xmlns="http://www.w3.org/1999/xhtml">';
                // Iterate through the rows and exclude the second row
                for (var i = 0; i < tableSelect.rows.length; i++) {
                    if (i !== 1) { // Exclude the second row (index 1)
                        tableHTML += '<tr>';
                        for (var j = 0; j < tableSelect.rows[i].cells.length; j++) {
                            var cellContent = tableSelect.rows[i].cells[j].innerText;
                            // Apply mso-number-format style for long numbers
                            if (!isNaN(cellContent) && cellContent.length > 10) {
                                tableHTML += '<td style="mso-number-format:\\@">' + cellContent + '</td>';
                            } else {
                                tableHTML += '<td>' + cellContent + '</td>';
                            }
                        }
                        tableHTML += '</tr>';
                    }
                }
                tableHTML += '</table>';
                // Convert the table HTML string to URI
                var encodedUri = 'data:application/vnd.ms-excel;charset=utf-8,' + encodeURIComponent(tableHTML);
                // Specify file name
                filename = filename ? filename + '.xls' : 'export.xls';
                // Create a download link element
                var downloadLink = document.createElement('a');
                downloadLink.href = encodedUri;
                downloadLink.download = filename;
                // Triggering the function
                document.body.appendChild(downloadLink);
                downloadLink.click();
                document.body.removeChild(downloadLink);
            }
        </script>
    </body>
</html>