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

use App\Models\CompenyModel;


$BillTypeModelObj = new BillTypeModel();
$state = new StateModel();
$city = new CityModel();
$UnitModelObj = new UnitModel();
$RollModelObj = new RollModel();
$EmployeeModelObj = new EmployeeModel();
$PartyUserModelObj = new PartyUserModel();
$BillRegisterModelObj = new BillRegisterModel();
$DepartmentModelObj = new DepartmentModel();



$CompenyModelModelObj = new CompenyModel();
$companies = $CompenyModelModelObj->findAll();
$employees = $EmployeeModelObj->findAll();
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
            <?php include('include/header.php');
            if($Roll_id=='0'){} 
            else{
                ?>
                <script type="text/javascript">
                    alert("Page Not Access"); 
                    window.location.href="<?php echo base_url("/index.php/"); ?>"
                </script>
                <?php 
            }
            ?>
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


                             if(session()->has("invaildDate"))
                               {   
                                if(session("invaildDate")==1)   
                                {  
                                        echo "<div class='alert alert-danger' role='alert'> In Month 10 Days After Change Paid Amount !  . </div>";
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
                                       <h2>Total Reward (In Rs.) : <?php 
                                            if(isset($allrwrdprice)){
                                                foreach ($allrwrdprice as $rowp){ 
                                                    echo $rowp['ttlreward']*$rewardconversionpointd;
                                                }
                                            }
                                            ?>
                                        </h2>
                                    </div>
                                    <div class="col-md-4">
                                       <form method="post" action="<?php echo base_url('/index.php/update-conversionprice');?>">
                                           <div class="row">
                                               <div class="col-md-8">
                                                   <input type="text" name="poninttobesave" id="searchInput" placeholder="Enter Reward Price Conversion" class="form-control" value="<?php echo $rewardconversionpointd;?>"/>
                                               </div>
                                               <div class="col-md-4">
                                                   <input type="submit" name="addpointconversion" class="btn btn-success btn-lg"/>
                                               </div>
                                           </div>
                                            
                                        </form>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <button type="button" class="btn btn-warning me-2 float-end btn-lg" data-bs-toggle="modal" data-bs-target="#assignModal"> Change Status Of Reward </button>
                                        <button type="button" class="btn btn-success me-2 float-end btn-lg" onclick="exportTableToExcel('myTable', 'table_export')">Export to Excel</button>
                                    </div>    
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body cardbody p-1"> 
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover" id="myTable">
                                            <thead>
                                                <tr>
                                                    <th>Transaction type (Within Bank (WIB)/NEFT (NFT)/ RTGS (RTG)/IMPS (IFC))</th>
                                                    <th><b>Amount (₹)(Should not be more than 15 digit including decimals and paise)</b></th>
                                                    <th><b>Debit Account no Should be exactly 12 digit</b></th>
                                                    <th><b>IFSC (Always 11 character alphanumeric and 5th character always 0 (zero)) (For ICICI bank accounts keep it blank)</b></th>
                                                    <th><b>Beneficiary Account No (Max length for other bank 34 character alphanumeric and for ICICI Bank 12 digit number )</b></th>
                                                    <th><b>Beneficiary Name (Max length 32 Character) (No Special Character is allowed but Space is allowed)</b></th>
                                                    <th><b>Remarks for Client (should not be more than 21 characters)</b></th>
                                                    <th><b>"Remarks for Beneficiary(should not be more than 30 characters)"</b></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr> 
                                            <?php 
                                            if(isset($dax)){
                                                foreach ($dax as $row){
                                                    ?>
                                                    <tr>
                                                        <td>NFT</td>
                                                        <td><?php echo $row['emprewardpoint']*$rewardconversionpointd;?></td>
                                                        <td>381805000130</td>
                                                        <td><?php echo $row['Ifsc_Code']; ?></td>
                                                        <td><?php echo $row['Acnt_No'];?></td>
                                                        <td><?php echo $row['Acnt_Holder_Name']; ?></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr> 
                                                    <?php } 
                                                } 
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div></div>
                                </div>
                            </div>
                          <div class="modal fade" id="assignModal" tabindex="-1" aria-labelledby="assignModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h1 class="modal-title fs-5 text-white" id="exampleModalLabel">Complete Rewards</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="<?php echo base_url('/index.php/update-state-of-reward'); ?>" class="py-3">
                   <!-- Company Dropdown -->
<div class="mb-3">
    <label for="compeny_id" class="form-label">Select Company</label>
    <select name="compeny_id" id="compeny_id" class="form-select" required>
        <option value="">-- Select Company --</option>
        <?php foreach ($companies as $company): ?>
            <option value="<?php echo $company['id']; ?>">
                <?php echo $company['name']; ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>

<!-- Employee Dropdown -->
<div class="mb-3">
    <label for="emp_id" class="form-label">Select Employee</label>
    <select name="emp_id" id="emp_id" class="form-select" required>
        <option value="">-- Select Employee --</option>
    </select>
</div>

                    <input type="submit" name="submit" class="btn btn-warning btn-lg" value="Complete Reward">
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
        <script type="text/javascript" src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
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


<script>  
         $(document).ready(function () {
         $('#compeny_id').change(function(){ 
            var compeny_id = $('#compeny_id').val();  
            var action = 'get_empolyee';   
            if(compeny_id != '')
            {   
                $.ajax({     
                    url:"<?php echo base_url('/index.php/getCompenyEmpolyee')?>",
                    method:"GET",
                    data:{compeny_id:compeny_id, action:action},  
                    dataType:"JSON",
                    success:function(data)  
                    {        
                        var html = '<option value="">Select </option>'+'<option value="All">All </option>';
                        
                        for(var count = 0; count < data.length; count++)
                        {
                            html += '<option value="'+data[count].id+'">'+data[count].first_name+ ' '+data[count].last_name+'</option>';
                        }
         
                        $('#emp_id').html(html);
                    }
                });
            }
            else   
            {
                $('#emp_id').val('');
            }
         
         });  
         
         
            });
      </script>
    </body>
</html>