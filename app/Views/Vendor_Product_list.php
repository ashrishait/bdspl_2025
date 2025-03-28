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
                        <!-- Search Form -->
                        <div class="col-md-12 col-sm-12 List p-3">
                           <div class="row">
                              <div class="col-md-4 p-2">
                                 <h3 style="font-weight: 600;">Vendor Quotation List</h3>
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
                                          <select name="vendor_id" id="select-country" class="form-control">
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
                                       <th>Quotation Id</th>
                                       <th>Title</th>
                                       <th>Vendor Name</th>
                                       <th>Action</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <?php if (isset($users) && !empty($users)) : ?>
                                       <?php foreach ($users as $index => $quotation) : ?>
                                          <tr>
                                             <td><?= $startSerial++ ?></td>
                                             <td><?= esc($quotation['id']); ?></td>
                                             <td><?= esc($quotation['title']); ?></td>
                                             <td><?= esc($quotation['vendor_name']); ?></td>
                                             <td>
                                               <a href="<?= site_url('/viewVendorSubQuotation/' . $quotation['id']); ?>" class="btn btn-success btn-sm" title="View Sub Quotation Details">
                                                   <span class="mdi mdi-eye-circle"></span>
                                                </a>
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

               


                  </div>
               </div>
            </div>
            <?php include('include/footer.php'); ?>
         </div>
      </div>
   </div>
   <?php include('include/script.php'); ?>





</body>
</html>
