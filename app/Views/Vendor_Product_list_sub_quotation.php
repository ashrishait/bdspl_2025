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
   <style>
      .modal-dialog {
          z-index: 1050; /* Bootstrap default z-index for modals */
      }
      .modal-backdrop {
          z-index: 1040; /* Ensure the backdrop is behind the modal */
      }
   </style>
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
    <!-- Display success message -->
    <?php if (session()->has("success")): ?>
        <div class="alert alert-success">
            <?php echo session("success"); ?>
        </div>
    <?php endif; ?>

    <!-- Display error message -->
    <?php if (session()->has("error")): ?>
        <div class="alert alert-danger">
            <?php echo session("error"); ?>
        </div>
    <?php endif; ?>
</div>

                      <div class="col-lg-12">
                        <!-- Search Form for Sub Quotation -->
                        <div class="col-md-12 col-sm-12 List p-3">
                           <div class="row">
                              <div class="col-md-4 p-2">
                                 <h3 style="font-weight: 600;">Sub Quotation List</h3>
                              </div>
                              <div class="col-md-8">
                                 <form id="searchForm" onsubmit="applyFilter(event)">
                                    <div class="row">
                                       <div class="col-md-3">
                                          <input type="date" name="date_from" id="date_from" class="form-control" required value="<?= esc($date_from ?? ''); ?>">
                                       </div>
                                       <div class="col-md-3">
                                          <input type="date" name="date_to" id="date_to" class="form-control" required value="<?= esc($date_to ?? ''); ?>">
                                       </div>
                                       <div class="col-md-3">
                                          <select name="vendor_id" id="select-vendor" class="form-control">
                                             <option value="">Select Vendor</option>
                                             <?php if (!empty($vendors)): ?>
                                                <?php foreach ($vendors as $vendor): ?>
                                                   <option value="<?= esc($vendor['id']); ?>"><?= esc(ucwords($vendor['Name'])); ?> (<?= esc(ucwords($vendor['GST_No'])); ?>)</option>
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
                     </div>
                     
                     <div class="card">
                        <div class="card-body p-1">
                           <div class="table-responsive">
                              <!-- Main Table -->
                              <table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>Sr. No.</th>
            <th>Quotation Id</th> <!-- Main Quotation Id -->
            <th>Sub Quotation Id</th> <!-- Sub Quotation Id -->
            <th>Title</th>
            <th>Vendor Name</th>
            <th>Revise Quotation Message</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php if (isset($records) && !empty($records)) : ?>
            <?php foreach ($records as $index => $subQuotation) : ?>
                <tr>
                    <td><?= $startSerial++ ?></td>
                    <td><?= esc($subQuotation['Quote_Id']); ?></td> <!-- Main Quotation Id -->
                    <td><?= esc($subQuotation['id']); ?></td> <!-- Sub Quotation Id -->
                    <td><?= esc($subQuotation['title']); ?></td>
                    <td><?= esc($subQuotation['vendor_name']); ?></td>
                    <td><?= esc($subQuotation['Revise_Quotation_Message']); ?></td>
                    <td><?= esc($subQuotation['status']); ?>


                    <td>
                       
<!-- Revert icon button -->
<button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#reviseModal-<?= $subQuotation['id']; ?>" title="Revise Quotation">
    <span class="mdi mdi-undo"></span>
</button>

 
                                               <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modal-details-<?= $subQuotation['Quote_Id'] . '-' . $subQuotation['id']; ?>" title="View Product Details">
    <span class="mdi mdi-eye-circle"></span>
</button>


                                                <a href="<?= site_url('/viewVendorProducts/' . $subQuotation['id'] . '/' . $subQuotation['Quote_Id']); ?>" class="btn btn-success btn-sm" title="Place Order">
   <span class="mdi mdi-cart-outline"></span>
</a>

                                                <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modal-delete-<?= $subQuotation['id']; ?>" title="Delete Item">
                                                   <span class="mdi mdi-trash-can-outline"></span>
                                                </button>
                                             </td>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="7">No data found.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

                           </div>
                           <div class="mt-3">
                              <?= $pager->links(); ?>
                           </div>
                        </div>
                     </div>
               <!-- Ensure this block is inside your main HTML content -->
                     <?php if (isset($records) && !empty($records)) : ?>
                         <?php foreach ($records as $subQuotation) : ?>
                             <!-- Product Details Modal -->
                            <!-- Product Details Modal -->

                <div class="modal fade" id="modal-details-<?= $subQuotation['Quote_Id'] . '-' . $subQuotation['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="modal-details-<?= $quotation['id'] . '-' . $subQuotation['id']; ?>" aria-hidden="true">
                         <div class="modal-dialog modal-lg modal-dialog-centered">
                             <div class="modal-content">
                                 <div class="modal-header bg-primary">
                                     <h4 class="modal-title text-white">Product Details</h4>
                                     <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                 </div>
                                 <div class="modal-body">
                                     <div id="product-details-content-<?= $subQuotation['id']; ?>" class="table-responsive">
                                         <!-- Product details will be injected here via AJAX -->
                                     </div>
                                 </div>
                                 <div class="modal-footer">
                                     <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                 </div>
                             </div>
                         </div>
                     </div>


<!-- Modal for revising the quotation message -->
<div class="modal fade" id="reviseModal-<?= $subQuotation['id']; ?>" tabindex="-1" aria-labelledby="reviseModalLabel-<?= $subQuotation['id']; ?>" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reviseModalLabel-<?= $subQuotation['id']; ?>">Revise Quotation Message</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="reviseForm-<?= $subQuotation['id']; ?>">
                    <div class="mb-3">
                        <label for="ReviseQuotationMessage-<?= $subQuotation['id']; ?>" class="form-label">Message</label>
                        <textarea class="form-control" id="ReviseQuotationMessage-<?= $subQuotation['id']; ?>" rows="3" name="Revise_Quotation_Message"><?= isset($subQuotation['Revise_Quotation_Message']) ? esc($subQuotation['Revise_Quotation_Message']) : ''; ?></textarea>
                    </div>
                    <input type="hidden" name="id" value="<?= $subQuotation['id']; ?>">
                    <input type="hidden" name="vendors_id" value="<?= $subQuotation['vendor_id']; ?>">
                    <button type="button" class="btn btn-primary" onclick="submitRevision(<?= $subQuotation['id']; ?>)">Save changes</button>
                </form>
            </div>
        </div>
    </div>
</div>


                             <!-- Delete Confirmation Modal -->
                              <div class="modal fade" id="modal-delete-<?= $subQuotation['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="modal-delete-<?= $subQuotation['id']; ?>" aria-hidden="true">
            <div class="modal-dialog modal-md modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h4 class="modal-title text-white">Are you sure you want to delete this quotation?</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="delete-form-<?= $subQuotation['id']; ?>" method="post" action="<?= site_url('/deleteQuotation'); ?>">
                            <input type="hidden" name="id" value="<?= $subQuotation['id']; ?>">
                            <div class="form-group">
                                <input type="text" name="Recived_Comment" class="form-control" placeholder="Please Enter Some Reason (Optional)">
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-danger">Delete</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
                         <?php endforeach; ?>
                     <?php endif; ?>


                  </div>
               </div>
            </div>
            <?php include('include/footer.php'); ?>
         </div>
      </div>
   </div>
   <?php include('include/script.php'); ?>




<script>
function submitRevision(subQuoteId) {
    const form = document.getElementById(`reviseForm-${subQuoteId}`);
    const formData = new FormData(form);

    // Get the vendor ID from the hidden input field
    const vendorId = form.querySelector('[name="vendors_id"]').value;
    formData.append('vendor_id', vendorId);  // Append the vendor_id to the form data

    // Perform the fetch request to update the revision message
    fetch('<?= site_url('/updateRevisionMessage'); ?>', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message); // Show the success message
            // location.reload();   // Optionally reload the page
        } else {
            alert('Error updating revision message: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while updating the message.');
    });
}
</script>






<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
    const baseUrl = 'https://api.bdslp.com/media/vendor_products_image/'; // Base URL for images

    document.querySelectorAll('[data-bs-target^="#modal-details-"]').forEach(button => {
        button.addEventListener('click', function() {
            const modalId = this.getAttribute('data-bs-target').replace('#modal-details-', '');
            const [quoteId, subQuoteId] = modalId.split('-');

            const contentDiv = document.getElementById(`product-details-content-${subQuoteId}`);
            contentDiv.innerHTML = '<p>Loading...</p>';

            fetch(`<?= site_url('/fetchVendorProducts/'); ?>${quoteId}/${subQuoteId}`)
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    if (data.success) {
                        let html = '<table class="table table-bordered table-hover"><thead><tr><th>Sr. No.</th><th>Product Name</th><th>Price</th><th>Description</th><th>Image</th></tr></thead><tbody>';
                        data.products.forEach((product, index) => {
                            html += `<tr>
                                <td>${index + 1}</td>
                                <td>${product.product_name}</td>
                                <td>${product.price}</td>
                                <td>${product.description}</td>
                                <td><img src="${baseUrl}${product.image}" alt="Product Image" width="50"></td>
                            </tr>`;
                        });
                        html += '</tbody></table>';
                        contentDiv.innerHTML = html;
                    } else {
                        contentDiv.innerHTML = `<p>${data.message}</p>`;
                    }
                })
                .catch(error => {
                    contentDiv.innerHTML = '<p>Error loading product details</p>';
                    console.error('Error:', error);
                });
        });
    });
});

</script>



<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('[data-bs-target^="#modal-delete-"]').forEach(button => {
        button.addEventListener('click', function() {
            const modalId = this.getAttribute('data-bs-target').replace('#', '');
            const quotationId = modalId.split('-').pop();

            // Set up the form action
            const form = document.getElementById(`delete-form-${quotationId}`);
            form.action = `<?= site_url('/deleteQuotation'); ?>`;
        });
    });
});
</script>


</body>
</html>
