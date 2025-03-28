<?php 
   use App\Models\StateModel; 
   use App\Models\CityModel;
   use App\Models\DepartmentModel; 
   use App\Models\EmployeeModel;
   use App\Models\CompenyModel;
   use App\Models\PartyUserModel;
   $state = new StateModel();
   $city = new CityModel();
   $DepartmentModelObj = new DepartmentModel();
   $EmployeeModelObj = new EmployeeModel();
   $CompenyModelObj = new CompenyModel();
   $PartyUserModel = new PartyUserModel();
   ?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <?php include('include/head.php'); ?>
   </head>
<body>
    <div class="container-scroller">
        <?php include('include/header.php'); ?>
        <div class="container-fluid page-body-wrapper">
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-12">


                                <div class="card">
                                    <div class="card-body p-1">

                               <div class="col-md-12 col-sm-12">
                                 <?php
                                    if(session()->has("success"))
                                    {   
                                         echo session("success");
                                    } 
                                    ?>
                              </div>
                           </div>
                        </div>


                               <div class="col-md-12 col-sm-12 List p-3">
                                 <div class="row">
                                    <div class="col-md-4 p-2">
                                       <!-- <h3 style="font-weight: 600;">Vendor Products List</h3> -->
                                       <h3 style="font-weight: 600;">Order Status</h3>
                                    </div>
                                 </div>
                               </div>

                                <div class="card">
                                    <div class="card-body p-1">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th><b>ID</b></th>
                                                        <th><b>Ordered Quantity</b></th>
                                                        <th><b>Delivered Quantity</b></th>
                                                        <th><b>Delivery Date</b></th>
                                                        <th><b>Remaining Quantity</b></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php if (!empty($deliveryRecords)): ?>
                                                    <?php foreach ($deliveryRecords as $record): ?>
                                                        <tr>
                                                            <td><?= $record['id'] ?></td>
                                                            <td><?= $totalOrderedQuantity ?></td>
                                                            <td><?= $record['quantity'] ?></td>
                                                            <td><?= $record['delivered_date'] ?></td>
                                                            <td><?= $totalOrderedQuantity - $record['quantity'] ?></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                <?php else: ?>
                                                    <tr>
                                                        <td colspan="5">No delivery records found.</td>
                                                    </tr>
                                                <?php endif; ?>
                                                </tbody>
                                            </table>
                                        </div>

                                        <!-- Pagination Links -->
                                        <?php if ($pager): ?>
                                            <div class="pagination-links">
                                                <?= $pager->links('deliveryRecordsGroup', 'default_full') ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>




                           </div>
                        </div>
                     </div>
                  </div>
  <!-- content-wrapper ends -->
                    <?php include('include/footer.php') ?>
                <!-- main-panel ends -->
            </div>
            <!-- page-body-wrapper ends -->
        </div>
        <!-- container-scroller -->
        <?php include('include/script.php'); ?>
    </div>





    </body>
</html>
