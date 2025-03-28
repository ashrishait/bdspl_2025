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


                             if(session()->has("invaildDate"))
                               {   
                                if(session("invaildDate")==1)   
                                {  
                                        echo "<div class='alert alert-danger' role='alert'> 9 date after change status !  . </div>";
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
                                       <h2>Total Reward Amount : <?php 
                                            if(isset($allrwrdprice)){
                                                foreach ($allrwrdprice as $rowp){ 
                                                    echo $rowp['ttlreward']*$rewardconversionpointd;
                                                }
                                            }
                                            ?>
                                        </h2>
                                    </div>
                                    <div class="col-md-4">
                               <!--        <form method="post" action="<?php echo base_url('update-conversionprice');?>">-->
                               <!--            <div class="row">-->
                               <!--                <div class="col-md-8">-->
                               <!--                    <input type="text" name="poninttobesave" id="searchInput" placeholder="Enter Reward Price Conversion" class="form-control" value="<?php echo $rewardconversionpointd;?>"/>-->
                               <!--                </div>-->
                               <!--                <div class="col-md-4">-->
                               <!--                    <input type="submit" name="addpointconversion" class="btn btn-success btn-lg"/>-->
                               <!--                </div>-->
                               <!--            </div>-->
        			                        
        			                    <!--</form>-->
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
                                                    <th><b>Employee Name</b></th>
                                                    <th><b>Contact</b></th>
                                                    <th><b>Email</b></th>
                                                    <th><b>Reward Point</b></th>
                                                    <th><b>Conversion Point</b></th>
                                                    <th><b>Reward in Rs.</b></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr> 
                                            <?php 
                                            if(isset($dax)){
                                                foreach ($dax as $row){
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $row['first_name']; ?> <?php echo $row['last_name']; ?></td>
                                                        <td><?php echo $row['mobile'];?></td>
                                                        <td><?php echo $row['email'];?></td>
                                                        <td><?php echo $row['emprewardpoint'];?></td>
                                                        <td><?php echo $rewardconversionpointd;?></td>
                                                        <td>Rs. <?php echo $row['emprewardpoint']*$rewardconversionpointd;?></td>
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
                                            <form method="post" action="<?php echo base_url('/index.php/update-state-of-reward');?>" class="py-3">
                                                <h3 class="mb-2">Are You sure you want to complete this Reward</h3>
                                                <input type="submit" name="submit" class="btn btn-warning btn-lg">
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
                            tableHTML += tableSelect.rows[i].outerHTML;
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