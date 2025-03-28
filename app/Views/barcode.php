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
            <div class="container-fluid page-body-wrapper">
                <div class="main-panel">
                    <div class="content-wrapper">
                        <div class="row">
                            <div class="col-4 mx-auto">
                                <button class="btn btn-default" onClick="printdiv('printable_div_id');">PRINT</button><br/><br/>
                                <div id='printable_div_id'>
                                    <img src="<?php echo $barcode; ?>">
                                </div>    
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php include('include/footer.php')?>
        </div>    
        <?php include('include/script.php'); ?>
        <script>
        function printdiv(elem) {
            var header_str = '<html><head><title>' + document.title  + '</title></head><body>';
            var footer_str = '</body></html>';
            var new_str = document.getElementById(elem).innerHTML;
            var old_str = document.body.innerHTML;
            document.body.innerHTML = header_str + new_str + footer_str;
            window.print();
            document.body.innerHTML = old_str;
            return false;
        }
        </script>
    </body>
</html>