<!DOCTYPE html>
<html lang="en">
<head>
    <?php include('include/head.php'); ?>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container .select2-selection--multiple {
            height: auto !important;
            min-height: 38px;
        }
        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #007bff;
            border-color: #006fe6;
            color: white;
            padding: 3px 10px;
            font-size: 14px;
        }
        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
            color: white;
            margin-right: 5px;
        }
        .added-companies {
            margin-top: 20px;
        }
        .added-companies label {
            display: block;
        }
        .alert {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container-scroller">
        <?php include('include/header.php'); ?>
        <div class="container-fluid page-body-wrapper" style="min-height: calc(100vh - 300px);">
            <div class="main-panel" style="min-height: auto;">
                <div class="content-wrapper">
                    <div class="row">
                        <div class="col-6">
                            <h3 class="font-weight-bold">
                                <span style="cursor: pointer;" onclick="history.back()">&larr; Go Back</span>
                            </h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <?php
                            if (session()->has("success")) {   
                                echo session("success");
                            } 
                            ?>
                        </div>



<div class="col-md-12 grid-margin">
    <div class="col-md-12 col-sm-12 List p-3">
        <h2>Add Vendor to your Company</h2>
    </div>
    <div class="card">
        <div class="card-body p-5">
            <form method="post" action="<?php echo base_url('/index.php/add-company-to-vendor'); ?>" enctype="multipart/form-data">
                <input type="hidden" name="Add_By" value="<?php echo $emp_id; ?>" >
                
                <div class="col-sm-12 col-md-12">
                    <div class="row">
                        <!-- Vendor Selection -->
                        <div class="form-group">
                            <label for="vendorid">Select Vendor<span style="color:red;">*</span></label>
                            <select name="vendorid" class="form-control" id="select-emp" style="padding: 0.875rem 1.375rem">
                                <option value="">Search Vendor</option>
                                <?php
                                if (isset($vendor)) {
                                    foreach ($vendor as $vndr) {
                                        ?>
                                        <option value="<?php echo $vndr['id']; ?>"><?php echo ucwords($vndr['Name']); ?></option>
                                        <?php 
                                    }
                                } 
                                ?> 
                            </select>
                        </div>
                    </div>   
                </div>

                <!-- Company Select2 -->
                <div class="col-md-12" id="company-select-container" style="display: none;">
                    <div class="form-group">
                        <label for="company_search">Search and Add Company</label>
                        <select name="companyid[]" class="form-control" id="company_search" multiple="multiple">
                            <!-- Options will be loaded dynamically -->
                        </select>
                    </div>

                    <!-- Listed Companies (Editable) -->
                    <div class="added-companies">
                        <label>Added Companies:</label>
                        <div id="added-companies-container">
                            <!-- Added companies will be displayed here -->
                        </div>
                    </div>
                    
                    <!-- Message for No Companies -->
                    <div id="no-companies-message" style="display: none;" class="alert alert-info">
                        No companies found
                    </div>

                    <!-- Update Button (hidden initially) -->
                    <button type="button" id="update-button" class="btn btn-danger" style="display: none;" onclick="updateCompanies()">Update</button>
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
                </div>
            </div>
        </div>
    </div>
    <?php include('include/footer.php')?>
    <?php include('include/script.php'); ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>


<script>
    $(document).ready(function () {
        // Initialize Select2 for Vendor and Company inputs
        $('#select-emp').select2({
            placeholder: "Search Vendor",
            allowClear: true,
            width: '100%',
            language: {
                noResults: function() {
                    return "No vendors found";
                }
            }
        });

        $('#company_search').select2({
            placeholder: "Search and select companies",
            allowClear: true,
            width: '100%',
            language: {
                noResults: function() {
                    return "No companies found";
                }
            }
        });

        // Show companies on vendor selection
        $('#select-emp').change(function () {
            var vendorId = $(this).val();
            if (vendorId) {
                $('#company-select-container').show();

                // Fetch vendor's companies via AJAX
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url('/index.php/fetch-vendor-companies'); ?>',
                    data: {vendorId: vendorId},
                    success: function (response) {
                        $('#company_search').empty();
                        $('#no-companies-message').hide();

                        if (response.error) {
                            alert(response.error);
                            return;
                        }

                        // Add not added companies
                        if (response.not_added_companies.length > 0) {
                            $.each(response.not_added_companies, function (index, company) {
                                var newOption = new Option(company.name, company.id, false, false);
                                $('#company_search').append(newOption);
                            });
                        } else {
                            $('#no-companies-message').show();
                        }

                        $('#company_search').trigger('change');
                        $('#added-companies-container').empty();

                        // Display added companies with editable checkboxes
                        if (response.added_companies.length > 0) {
                            $.each(response.added_companies, function (index, company) {
                                $('#added-companies-container').append(
                                    '<div class="form-check">' +
                                    '<input class="form-check-input" type="checkbox" value="' + company.Company_Id + '" checked>' +
                                    '<label class="form-check-label">' + company.Company_Name + '</label>' +
                                    '</div>'
                                );
                            });
                        } else {
                            $('#added-companies-container').append(
                                '<div class="alert alert-info">No companies added</div>'
                            );
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Error fetching vendor companies:", status, error);
                        alert("Error fetching company data. Try again.");
                    }
                });
            } else {
                $('#company-select-container').hide();
            }
        });

        // Detect checkbox changes to show the update button
        $(document).on('change', '.form-check-input', function() {
            var checked = $('.form-check-input:checked').length;
            if (checked < $('.form-check-input').length) {
                $('#update-button').show(); // Show the update button
            } else {
                $('#update-button').hide(); // Hide the update button
            }
        });
    });

    // Function to update (remove) unchecked companies
    // function updateCompanies() {
    //     var uncheckedCompanies = [];
    //     $('.form-check-input:not(:checked)').each(function() {
    //         uncheckedCompanies.push($(this).val());
    //     });

    //     if (uncheckedCompanies.length > 0) {
    //         $.ajax({
    //             type: 'POST',
    //             url: '<?php echo base_url('/index.php/update-vendor-companies'); ?>',
    //             data: {companyIds: uncheckedCompanies},
    //             success: function (response) {
    //                 if (response.success) {
    //                     alert('Companies updated successfully');
    //                     // Optionally refresh the company list or redirect
    //                     location.reload();
    //                 } else {
    //                     alert(response.error || 'Update failed.');
    //                 }
    //             },
    //             error: function(xhr, status, error) {
    //                 console.error("Error updating companies:", status, error);
    //                 alert("There was an error updating the companies. Please try again.");
    //             }
    //         });
    //     }
    // }



    function updateCompanies() {
    var uncheckedCompanies = [];
    var vendorId = $('#select-emp').val();  // Get vendorId from the dropdown

    // Collect unchecked companies
    $('.form-check-input:not(:checked)').each(function() {
        uncheckedCompanies.push($(this).val());
    });

    // Check if any companies are unchecked
    if (uncheckedCompanies.length === 0) {
        alert('No companies to update');
        return;
    }

    console.log(uncheckedCompanies); // For debugging purposes

    // Proceed with AJAX request if there are unchecked companies
    $.ajax({
        type: 'POST',
        url: '<?php echo base_url('/index.php/update-vendor-companies'); ?>',
        data: {
            vendorId: vendorId, // Send vendorId to backend
            companyIds: uncheckedCompanies // Send unchecked company IDs
        },
        success: function (response) {
            if (response.success) {
                alert('Companies updated successfully');
                location.reload(); // Optionally refresh the page
            } else {
                alert(response.error || 'Update failed.');
            }
        },
        error: function(xhr, status, error) {
            console.error("Error updating companies:", status, error);
            alert("There was an error updating the companies. Please try again.");
        }
    });
}

</script>
</body>
</html>
