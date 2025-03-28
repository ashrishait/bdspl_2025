<?php 

use App\Models\EmployeeModel;
use App\Models\PartyUserModel;
;


$EmployeeModelObj = new EmployeeModel();
$PartyUserModelObj = new PartyUserModel();

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include('include/head.php'); ?>
    </head>
    <body>
        <div class="container-scroller">
            <?php include('include/header.php');
            if($Roll_id=='0')
            {} 
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
                        <div class="col-lg-12 grid-margin">
                            <div class="col-md-12 col-sm-12 List p-3">
                                <div class="row">
                                    <div class="col-md-12">
                                       <h2>Recent Vendor Login List</h2>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body cardbody p-1"> 
                                    <div class="table-responsive">
                                        <table  id="example44" class="table table-striped table-bordered table-hover" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th><b>Sr No</b></th>
                                                    <th><b>GST No</b></th>
                                                    <th><b>Name</b></th>
                                                    <th><b>Login Time</b></th>
                                                    <th><b>Logout Time</b></th>
                                                 
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if(isset($users)){
                                                $i=0;
                                                $head=10;
                                                foreach ($users as $index => $row){
                                                    $i = $i+1;
                                                    $Vendorrow= $PartyUserModelObj->where('id',$row['User_Id'])->first();
                                                    ?>
                                                    <tr>
                                                        <td><?= $startSerial++ ?></td>
                                                    
                                                        <td><?php 
                                                        if(isset($Vendorrow) && $Vendorrow!='')
                                                        {
                                                            echo $Vendorrow['GST_No'];   
                                                        }
                                                        ?>
                                                            
                                                        </td>
                                                        <td><?php 
                                                        if(isset($Vendorrow) && $Vendorrow!='')
                                                        {
                                                            echo $Vendorrow['Name']; 
                                                        }
                                                        ?></td>
                                                        <td><?php echo $row['Login_Time'] ?></td>
                                                        <td><?php echo $row['Logout_Time'] ?></td>
                                                    </tr>
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
                    </div>
                </div>
            </div>  
            <?php include('include/footer.php')?>
        </div>
        <?php include('include/script.php'); ?>
        <script type="text/javascript" src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
        
    </body>
</html>