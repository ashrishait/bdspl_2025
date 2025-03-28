<!DOCTYPE html>
<html lang="en">


    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>404 Error Page</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <?php include('include/head.php'); ?>
        <style>
            #suggestionsList {
                list-style: none;
                padding: 0;
                margin: 0;
                position:absolute;
                z-index:1;
            }
    
            #suggestionsList li {
                background-color: #065ca3;
                color:#fff;
                /*width:200px;*/
                padding: 8px;
                margin: 5px;
                border-radius: 5px;
                cursor: pointer;
            }
    
            #suggestionsList li a {
                padding: 10px 100px;
                margin: 5px;
                text-decoration: none;
                color: #fff;
                font-weight:bold;
            }
    
            #suggestionsList li:hover {
                background-color: #ccc;
            }
            #suggestionsList li a:hover {
                color: #000;
            }
        </style>
    </head>


    <body>
        <div class="container-scroller">
            <?php include('include/header.php'); ?>
            <div class="container-fluid">
                <div>
                    <div class="content-wrapper">
                        <div class="d-flex align-items-center justify-content-center mt-5 pt-5">
                            <div class="text-center">
                                <h1 class="display-1 fw-bold">404</h1>
                                <p class="fs-3"> <span class="text-danger">Opps!</span> Page not found.</p>
                                <p class="lead">
                                    The page you’re looking for doesn’t exist.
                                </p>
                                <div class="col-12">
                                    <form method="post" action="<?php echo base_url('barcodeuid');?>" class="mb-3">
                                        <input type="hidden" name="companyid" id="companyid" class="form-control" value="<?php echo $companyid;?>" />
                                        <input type="text" name="enteruid" id="searchInput" placeholder="Scan Barcode Or Enter Bill UID" class="form-control"/>
                                        <!-- Suggestions dropdown -->
                                        <ul id="suggestionsList"></ul>
                                    </form>
                                </div>    
                                <a href="<?php echo base_url('/index.php/main-dashboard');?>" class="btn btn-primary">Go Home</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>    
        <?php include('include/footer.php')?>
        <?php include('include/script.php'); ?>
        <script>
            $(document).ready(function () {
                // Event listener for input changes
                $('#searchInput').on('input', function () {
                    var query = $(this).val();
                    var companyid = $('#companyid').val();
                    //alert(companyid);
                    // AJAX request to get suggestions
                    $.ajax({
                        url: '<?php echo base_url('uidsuggestion'); ?>',
                        method: 'GET',
                        data: { query: query, companyid:companyid },
                        dataType: 'json',
                        success: function (data) {
                            displaySuggestions(data);
                        }
                    });
                });
    
                // Function to display suggestions
                function displaySuggestions(suggestions) {
                    var suggestionsList = $('#suggestionsList');
                    suggestionsList.empty();
    
                    $.each(suggestions, function (index, item) {
                        var listItem = $('<li><a href="<?php echo base_url('sigle_bill_list'); ?>/' + item.id + '">' + item.uid + '</a></li>');
                        suggestionsList.append(listItem);
                    });
                }
            });
        </script>
    </body>
</html>