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
                            <div class="col-md-12 col-sm-12">
                                <?php if (session()->has("success")): ?>
                                    <div class="alert alert-success"><?= session("success") ?></div>
                                <?php endif; ?>
                            </div>
                            <div class="col-lg-12">
                                <!-- Search Form -->
                                <div class="col-md-12 col-sm-12 List p-3">
                                    <div class="row">
                                        <div class="col-md-4 p-2">
                                            <h3 style="font-weight: 600;">Ordered Product List</h3>
                                        </div>
                                        <div class="col-md-8">
                                            <form id="searchForm" method="GET" onsubmit="applyFilter(event)">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <input type="date" name="date_from" id="date_from" class="form-control" required value="<?= $date_from ?? ''; ?>">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <input type="date" name="date_to" id="date_to" class="form-control" required value="<?= $date_to ?? ''; ?>">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <select name="vendor_id" id="select-country" class="form-control" required>
                                                            <option value="">Select Vendor</option>
                                                            <?php if (!empty($dax14)): ?>
                                                                <?php foreach ($dax14 as $row14): ?>
                                                                    <option value="<?= $row14['id']; ?>" <?= isset($vendor_id) && $vendor_id == $row14['id'] ? 'selected' : ''; ?>>
                                                                        <?= ucwords($row14['Name']); ?> (<?= ucwords($row14['GST_No']); ?>)
                                                                    </option>
                                                                <?php endforeach; ?>
                                                            <?php else: ?>
                                                                <option value="">No Vendor Found</option>
                                                            <?php endif; ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <button type="submit" class="btn btn-warning">Search</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Orders Table -->
                                <div class="card mt-4">
                                    <div class="card-body p-1">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th><b>Order ID</b></th>
                                                        <th><b>Product ID</b></th>
                                                        <th><b>Quotation ID</b></th>
                                                        <th><b>Sub Quotation ID</b></th>
                                                        <th><b>Order Quantity</b></th>
                                                        <th><b>Price</b></th>
                                                        <th><b>Total Price</b></th>
                                                        <th><b>Order Date</b></th>
                                                        <th><b>Delivery Date</b></th>
                                                        <th><b>Action</b></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php if (!empty($users)): ?>
                                                        <?php foreach ($users as $row): ?>
                                                            <tr>
                                                                <td><?= $row['order_id'] ?></td>
                                                                <td><?= $row['product_id'] ?></td> <!-- Updated field -->
                                                                <td><?= $row['quotation_id'] ?></td>
                                                                <td><?= $row['sub_quotation_id'] ?></td>
                                                                <td><?= $row['order_quantity'] ?></td>
                                                                <td><?= $row['product_price'] ?></td>
                                                                <td><?= $row['total_price'] ?></td>
                                                                <td><?= $row['order_date'] ?></td>
                                                                <td><?= $row['delivery_date'] ?? 'N/A' ?></td>
                                                                <td>
                                                                    <a class="btn btn-info btn-sm" 
                                                                       href="<?= base_url('/checkStatus/' . $row['order_id'] . '/' . $row['quotation_id'] . '/' . $row['sub_quotation_id'] . '/' . $compeny_id . '/' . $row['product_id']); ?>" 
                                                                       title="Check Status">
                                                                        <span class="mdi mdi-eye-check"></span>
                                                                    </a>

                                                                    <a class="btn btn-warning btn-sm" href="<?= base_url('/editVendorOrder/' . $row['id']); ?>" title="Edit Order"><span class="mdi mdi-pencil"></span></a>
                                                                </td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    <?php else: ?>
                                                        <tr>
                                                            <td colspan="10" class="text-center">No Orders Found.</td>
                                                        </tr>
                                                    <?php endif; ?>
                                                </tbody>
                                            </table>
                                            <div class="pagination justify-content-center mt-3">
                                                <?= $pager->links() ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php include('include/footer.php'); ?>
            </div>
        </div>
    </div>
    <?php include('include/script.php'); ?>

    <script>
        function applyFilter(event) {
            event.preventDefault(); // Prevent default form submission

            // Get form values
            const dateFrom = document.getElementById('date_from').value;
            const dateTo = document.getElementById('date_to').value;
            const vendorId = document.getElementById('select-country').value;

            // Validate fields
            if (!dateFrom) {
                alert("Please select the 'Date From' field.");
                return;
            }
            if (!dateTo) {
                alert("Please select the 'Date To' field.");
                return;
            }
            if (!vendorId) {
                alert("Please select a Vendor.");
                return;
            }

            // Construct query string
            let queryString = '?';
            queryString += 'date_from=' + encodeURIComponent(dateFrom) + '&';
            queryString += 'date_to=' + encodeURIComponent(dateTo) + '&';
            queryString += 'vendor_id=' + encodeURIComponent(vendorId) + '&';
            queryString += 'compeny_id=' + encodeURIComponent('<?= $compeny_id; ?>'); // Add company_id to query string

            // Redirect to the page with filters applied
            window.location.href = '<?= site_url("/Ordered_Quotation_Product_list"); ?>' + queryString;
        }
    </script>
</body>
</html>
