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
         .content {
             padding: 20px;
         }

         .fixed-button {
             position: fixed;
             bottom: 20px;
             right: 20px;
             padding: 10px 20px;
             background-color: #007bff;
             color: white;
             border: none;
             border-radius: 5px;
             cursor: pointer;
             box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
             display: none; /* Initially hidden */
         }

         .fixed-button:hover {
             background-color: #0056b3;
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
                            <h2>Add Vendor to your Company </h2>
                        </div>
                         
                        <div class="card">
                           <div class="card-body">
                              <div class="content">
                                 <form method="post" action="<?php echo base_url('/index.php/add-vendor-to-company'); ?>" enctype="multipart/form-data">
                                    <button type="submit" class="btn btn-primary fixed-button" id="scrollButton">Submit</button>   
                                    <div class="row">
                                       <div class="col-12 p-0">
                                          <button type="submit" class="btn btn-primary">Submit</button>   
                                          <button type="reset" class="btn btn-secondary">Reset</button>
                                       </div>
                                    </div>
                                    <input  type="hidden" name="compeny_id" id="compeny_id" value="<?php echo $compeny_id;?>" >
                                    <input  type="hidden" name="Add_By" value="<?php echo $emp_id;?>" >
                                    <div class="row">
                                       <?php
                                          if(isset($vendor)){
                                             foreach ($vendor as $row){ ?>
                                                <div class="col-sm-2 col-md-2 shadow mb-4">
                                                   <div class="form-check">
                                                      <input class="form-check-input ms-0" type="checkbox" name="vendorid[]" id="flexCheckDefault<?php echo $row['id']; ?>" value="<?php echo $row['id']; ?>">
                                                      <label class="form-check-label" for="flexCheckDefault<?php echo $row['id']; ?>">
                                                         <?php echo $row['Name']; ?> (<?php echo $row['GST_No']; ?>)
                                                      </label>
                                                   </div>
                                                </div>   
                                                <?php 
                                             }
                                          }
                                       ?>
                                    </div>    
                                    
                                    <div class="row">
                                       <div class="col-12 p-0">
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
          // Function to fetch data and update checkboxes
          function fetchDataAndUpdateCheckboxes() {
              var compeny_id = $('#compeny_id').val(); // Get the value of the input box
              // Make an AJAX request to get the selected company's vendor data
              $.ajax({
                  type: 'POST',
                  url: '<?php echo base_url('/index.php/get-company-vendor'); ?>', // Replace with your actual route
                  data: {compeny_id: compeny_id},
                  success: function (data) {
                     // Update the checkboxes based on the retrieved data
                     updateCheckboxes(data);
                  }
              });
          }

          // Call the function when the document is ready (on load)
          fetchDataAndUpdateCheckboxes();
          
          // Helper function to update checkboxes based on data
          function updateCheckboxes(data) {
            // Uncheck all checkboxes
            $('input[name="vendorid[]"]').prop('checked', false);
            // Check the checkboxes based on the retrieved data
            $.each(data, function (index, value) {
               $('input[name="vendorid[]"][value="' + value + '"]').prop('checked', true);
            });
          }
          console.log()
       });
      </script>
      <script>
         document.addEventListener("scroll", function() {
            var scrollButton = document.getElementById("scrollButton");
            if (window.scrollY > 500) {
               scrollButton.style.display = "block";
            } else {
               scrollButton.style.display = "none";
            }
         });
      </script>
    <!-- Rest of your view code... -->

   </body>
</html>