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
                                            <?php if (session()->has("success")): ?>   
                                                <div class="alert alert-success">
                                                    <?= session("success") ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 col-sm-12 List p-3">
                                    <div class="row">
                                        <div class="col-md-4 p-2">
                                            <h3 style="font-weight: 600;">Deliver Product Details </h3>
                                            <h5>Order ID: <?= $order['id'] ?></h5> 
                                            <h5>Quotation ID: <?= $quotation_id ?></h5>
                                            <h5>Sub Quotation ID: <?= $sub_quotation_id ?></h5>
                                        </div>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-body p-1">
                                        <div class="table-responsive">
<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>Order ID</th>
            <th>Quotation ID</th>
            <th>Sub Quotation ID</th>
            <th>Product ID</th>
            <th>Product Name</th>
            <th>Delivered Quantity</th>
            <th>Delivered Date</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($orderProducts)) : ?>
            <?php foreach ($orderProducts as $product) : ?>
                <tr>
                    <td><?= esc($order_id); ?></td>
                    <td><?= esc($quotation_id); ?></td>
                    <td><?= esc($sub_quotation_id); ?></td>
                    <td><?= esc($product['Product_Id']); ?></td>
                    <td><?= esc($product['Product_Name']); ?></td>
                    <td><?= esc($product['Delivered_Quantity']); ?></td>
                    <td><?= esc($product['Delivered_Date']); ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else : ?>
            <tr>
                <td colspan="7">No products found for this order.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

                                        </div>

                                        <!-- Pagination Links -->
                                        <div>
                                            <br>
                                            <span style="font-weight: bold; color: blue;">Pagination</span>
                                            <?php if ($pager): ?>
                                                <?= $pager->links() ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- content-wrapper ends -->
                    <?php include('include/footer.php'); ?>
                    <!-- main-panel ends -->
                </div>
                <!-- page-body-wrapper ends -->
            </div>
            <!-- container-scroller -->
            <?php include('include/script.php'); ?>
        </div>
    </body>
</html>
