<!DOCTYPE html>
<html lang="en">
   <head>
      <?php include('include/head.php'); ?>
      <style>
         .bootstrap-select .btn{
         padding-top:12px;
         padding-bottom:12px;
         border:1px solid #00000045 !important;
         }
      </style>
   </head>
   <body>
      <div class="container-scroller">
         <?php include('include/header.php'); ?>
         <!-- partial -->
         <div class="container-fluid page-body-wrapper" style="min-height: calc(100vh - 300px);">
            <div class="main-panel" style="min-height: auto;">
               <div class="content-wrapper">
                  <div class="row">
                     <div class="col-6">
                        <h3 class="font-weight-bold"><span  style="cursor: pointer;" onclick="history.back()">&larr; Go Back</span></h3>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-md-12 col-sm-12">
                        <?php
                           if(session()->has("success"))
                           {   
                                echo session("success");
                           } 
                           ?>
                     </div>
                     <div class="col-md-12 grid-margin">
                        <div class="col-md-12 col-sm-12 List p-3" style="">
                            <h2> Assign To Employee </h2>
                        </div>
                         
                        <div class="card">
                           <div class="col-5 mx-auto card-body cardbody">
                              <form method="post" action="<?php echo base_url('/index.php/addpage-employee'); ?>" enctype="multipart/form-data">
                                 <input  type="hidden" name="compeny_id" value="<?php echo $compeny_id;?>" >
                                 <input  type="hidden" name="Add_By" value="<?php echo $emp_id;?>" >
                                 <div class="row">
                                    <div class="col-sm-12 col-md-12">
                                       <div class="form-group">
                                          <label for="billpic" >Select Employee<span style="color:red;">*</span></label>
                                          <select name="empid" class="form-control" id="select-country" style="padding: 0.875rem 1.375rem">
                                             <option value="">Select Employee</option>
                                             <?php
                                                if(isset($emp)){
                                                    foreach ($emp as $empn){
                                                    ?>
                                                        <option value="<?php echo $empn['id']; ?>"><?php echo ucwords($empn['first_name'].' '.$empn['last_name']); ?></option>
                                                        <?php 
                                                    }
                                                } 
                                             ?> 
                                          </select>
                                       </div>
                                    </div>
                                    <div class="col-sm-12 col-md-12">
                                        <?php
                                        if(isset($page)){
                                            foreach ($page as $pages){ ?>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="pageid[]" id="flexCheckDefault" value="<?php echo $pages['Id']; ?>">
                                                    <label class="form-check-label" for="flexCheckDefault">
                                                        <?php echo $pages['Page_Name']; ?>
                                                    </label>
                                                </div>
                                                <?php 
                                            }
                                        }
                                        ?>
                                    </div>    
                                 </div>
                                 <div class="row">
                                    <div class="col-12">
                                       <button type="submit" class="btn btn-primary">Submit</button>   
                                       <button type="reset" class="btn btn-secondary">Reset</button>
                                    </div>
                                 </div>
                              </form>
                           </div>
                        </div>
                     </div>
                  </div>
                  <!-- partial -->
               </div>
            </div>
            <!-- main-panel ends -->
         </div>
         <!-- page-body-wrapper ends -->
      </div>
      <!-- container-scroller -->
      </div>
      <?php include('include/footer.php')?>
      </div>    
      <?php include('include/script.php'); ?>
      <!-- app/Views/your_view_file.php -->
      <script>
        $(document).ready(function () {
            // Add change event listener to the select box
            $('#select-country').change(function () {
                var employeeId = $(this).val(); // Get the selected employee ID
                
                // Make an AJAX request to get the selected employee's page data
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url('/index.php/get_employee_pages'); ?>', // Replace with your actual route
                    data: {employee_id: employeeId},
                    success: function (data) {
                        // Update the checkboxes based on the retrieved data
                        updateCheckboxes(data);
                    }
                });
            });
    
            // Helper function to update checkboxes based on data
            function updateCheckboxes(data) {
                // Uncheck all checkboxes
                $('input[name="pageid[]"]').prop('checked', false);
    
                // Check the checkboxes based on the retrieved data
                $.each(data, function (index, value) {
                    $('input[name="pageid[]"][value="' + value + '"]').prop('checked', true);
                });
            }
        });
      </script>
    
    <!-- Rest of your view code... -->

   </body>
</html>