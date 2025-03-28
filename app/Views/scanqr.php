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
                            <div class="col-lg-12 mb-lg-0">
                                <div class="card congratulation-bg py-0" style="background:none;">
                                    <div class="card-body py-0">
                                        <div class="container">
                                            <div class="row">
                                                <div class="col-12 text-center pb-5">
                                                    <h2 class="mb-3 font-weight-bold">Scan QR</h2>
                                                </div>
                                            </div>
                                        </div>       
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="container">
                            <div class="col-8 mx-auto">
                                <main id="main">
                                    <section id="about" class="about">
                                        <div class="container" style="padding-top: 0vh;">
                                            <video id="preview"></video>
                                        </div>
                                    </section><!-- End About Us Section -->
                                </main><!-- End #main -->
                            </div>    
                        </div>
                    </div>
                </div>
            </div>  
            <?php include('include/footer.php')?>
        </div>
        <?php include('include/script.php'); ?>
        <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js" type="text/javascript"></script>
        <script type="text/javascript">
            var scanner = new Instascan.Scanner({ video: document.getElementById('preview'), scanPeriod: 5, mirror: false });
            scanner.addListener('scan',function(content){
                window.location.href=content;
            });
            Instascan.Camera.getCameras().then(function (cameras) {
                if (cameras.length > 0) {
                    scanner.start(cameras[cameras.length-1]);
                } else {
                    console.error('No cameras found.');
                }
            }).catch(function (e) {
                console.error(e);
            });
        </script>
    </body>
</html>