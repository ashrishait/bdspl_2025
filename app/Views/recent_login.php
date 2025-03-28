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
                                       <h2>Recent Login List</h2>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body cardbody p-1"> 
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover" id="myTable">
                                            <thead>
                                                <tr>
                                                    <th><b>S.No</b></th>
                                                    <th><b>Company ID</b></th>
                                                    <th><b>User ID</b></th>
                                                    <th><b>Login Time</b></th>
                                                    <th><b>Logout Time</b></th>
                                                    <th><b>Employee Role</b></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php  if(isset($logins)){
                                                    foreach ($logins as $login){ ?>
                                                    <tr>
                                                        <td><?= $startSerial++ ?></td>
                                                        <td><?= $login['name'] ?></td>
                                                        <td><?= $login['first_name'] ?></td>
                                                        <td><?= $login['Login_Time'] ?></td>
                                                        <td><?= $login['Logout_Time'] ?></td>
                                                        <td><?php if($login['Emp_Role']==0){ 
                                                                echo "Superadmin";
                                                            }
                                                            elseif($login['Emp_Role']==1){
                                                                echo "Admin";
                                                            }
                                                            else{
                                                                echo "Employee";
                                                            }
                                                            ?>
                                                        </td>
                                                    </tr>
                                                <?php }} ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div>
                                        <hr>
                                        <span style="font-weight: bold;color: blue;">  Main Pagination</span>
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