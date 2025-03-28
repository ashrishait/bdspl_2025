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
                                            <?php if(session()->has("success")): ?>   
                                                <div class="alert alert-success"><?= session("success") ?></div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 col-sm-12 List p-3">
                                    <div class="row">
                                        <div class="col-md-4 p-2">
                                            <h3 style="font-weight: 600;">Products for Quotation ID: <?= $quotation_id ?></h3>
                                        </div>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-body p-1">
                                        <form method="post" action="<?= site_url('/submitVendorOrder'); ?>" enctype="multipart/form-data">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th><b>Product Name</b></th>
                                                            <th><b>Price</b></th>
                                                            <th><b>Description</b></th>
                                                            <th><b>Image</b></th>
                                                            <th><b>Quantity</b></th>
                                                            <th><b>Delivery Date</b></th>
                                                            <th><b>Total Price</b></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($products as $index => $product): ?>
                                                        <tr>
                                                            <input type="hidden" name="product_ids[]" value="<?= $product['id'] ?>"> <!-- Product ID -->

                                                            <input type="hidden" name="quotation_id" value="<?= $quotation_id ?>">

                                                            <input type="hidden" name="vendor_id" value="<?= $product['vendor_id'] ?>">

                                                           <input type="hidden" name="sub_quotation_id" value="<?= $sub_quotation_id ?>">

                                                            <td><?= $product['product_name'] ?></td>
                                                            <td><?= number_format($product['quoted_price'], 2) ?></td> <!-- Use quoted_price -->
                                                            <td><?= $product['description'] ?></td>
                                                            <td>
                                                                <img src="http://api.bdslp.com/media/vendor_products_image/<?= $product['image'] ?>" alt="Product Image" width="100">
                                                            </td>
                                                            <td>
                                                                <input type="number" name="quantities[]" class="form-control quantity" data-price="<?= $product['quoted_price'] ?>" value="0"> <!-- Use quoted_price for data-price -->
                                                            </td>
                                                            <!-- Other form fields here -->
                                                            <td>
                                                                <input type="date" name="delivery_dates[]" class="form-control delivery-date" required>
                                                            </td>
                                                            <td>
                                                                <input type="text" name="total_prices[]" class="form-control total-price" value="0.00" readonly>
                                                            </td>
                                                        </tr>
                                                        <?php endforeach; ?>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="6" style="text-align: right;"><strong>Grand Total:</strong></td>
                                                            <td><input type="text" id="grand-total" class="form-control" readonly></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="7" style="text-align: right;">
                                                                <button type="submit" class="btn btn-success">Submit Order</button>
                                                                <a href="<?= site_url('/Vendor_Product_list') ?>" class="btn btn-secondary">Cancel</a>
                                                            </td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </form>
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

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const quantityInputs = document.querySelectorAll('.quantity');
        const totalPriceInputs = document.querySelectorAll('.total-price');
        const grandTotalInput = document.getElementById('grand-total');

        function calculateTotalPrice() {
            let grandTotal = 0;
            quantityInputs.forEach((input, index) => {
                const price = parseFloat(input.getAttribute('data-price'));
                const quantity = parseInt(input.value) || 0; // Handle NaN by defaulting to 0
                const total = price * quantity;
                totalPriceInputs[index].value = total.toFixed(2);
                grandTotal += total;
            });
            grandTotalInput.value = grandTotal.toFixed(2);
        }

        quantityInputs.forEach(input => {
            input.addEventListener('input', calculateTotalPrice);
        });

        calculateTotalPrice(); // Initial calculation
    });
    </script>



    <script>
    function validateForm() {
        const deliveryDates = document.querySelectorAll('input[name="delivery_dates[]"]');
        let valid = true;

        deliveryDates.forEach(function (dateInput) {
            if (!dateInput.value) {
                dateInput.classList.add('is-invalid'); // Optional: Add visual feedback for the user
                valid = false;
            } else {
                dateInput.classList.remove('is-invalid'); // Remove error state if filled
            }
        });

        if (!valid) {
            alert('Please fill in all required delivery dates.');
        }

        return valid;
    }
</script>

<style>
    .is-invalid {
        border: 2px solid red; /* Highlight the invalid field */
    }
</style>

</body>
</html>
