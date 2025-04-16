<!DOCTYPE html>
<html lang="en">
   <head>
      <?php include('include/head.php'); ?>
      <style>
            .card-box {
                position: relative;
                color: #fff;
                padding: 20px 10px 40px;
                margin: 20px 0px;
            }
            .card-box:hover {
                text-decoration: none;
                color: #f1f1f1;
            }
            .card-box:hover .icon i {
                font-size: 100px;
                transition: 1s;
                -webkit-transition: 1s;
            }
            .card-box .inner {
                padding: 5px 10px 0 10px;
            }
            .card-box h3 {
                font-size: 27px;
                font-weight: bold;
                margin: 0 0 8px 0;
                white-space: nowrap;
                padding: 0;
                text-align: left;
            }
            .card-box p {
                font-size: 15px;
            }
            .card-box .icon {
                position: absolute;
                top: auto;
                bottom: 5px;
                right: 5px;
                z-index: 0;
                font-size: 72px;
                color: rgba(0, 0, 0, 0.15);
            }
            .card-box .card-box-footer {
                position: absolute;
                left: 0px;
                bottom: 0px;
                text-align: center;
                padding: 3px 0;
                color: rgba(255, 255, 255, 0.8);
                background: rgba(0, 0, 0, 0.1);
                width: 100%;
                text-decoration: none;
            }
            .card-box:hover .card-box-footer {
                background: rgba(0, 0, 0, 0.3);
            }
            .bg-blue {
                background-color: #00c0ef !important;
            }
            .bg-green {
                background-color: #00a65a !important;
            }
            .bg-orange {
                background-color: #f39c12 !important;
            }
            .bg-red {
                background-color: #d9534f !important;
            }

      </style>
   </head>
   <body>
      <div class="container-scroller">
         <?php include('include/header.php'); ?>
         <div class="container-fluid">
            <div class="bg-light">
               <div class="container-fluid">
                  <div class="content-wrapper pt-0">
                     <div class="row">
                        <div class="col-lg-12 mb-lg-0 pt-0">
                           <div class="card congratulation-bg text-center py-0" style="background:none;">
                              <div class="card-body">
                                 <h2 class="mb-3 font-weight-bold">Dashboard</h2>
                                 <h3 class="mt-3 mb-3 font-weight-bold">Welcome !
                                    <?php echo ucwords($name);?> ( <?php echo ucwords($Role);?>)
                                 </h3>
                              </div>
                           </div>
                        </div>
                     </div>
                     <?php
                           if(session()->has("success"))
                           {   
                              echo session("success");
                           } 
                     ?>
                     <?php
                     if($Roll_id==0)
                     {
                     ?>
                     <div class="row d-flex justify-content-center">
                        <div class="col-lg-3">

                            <div class="card-box bg-blue">

                                <div class="inner">

                                    <h3> <?= $Company_Add_Request; ?> </h3>

                                    <p> Company Add Request </p>

                                </div>

                                <div class="icon">

                                    <i class="mdi mdi-office-building-marker-outline"></i>

                                </div>

                                <a href="<?php echo base_url('/index.php/view_compeny_add_request');?>" class="card-box-footer py-2">View More <i class="fa fa-arrow-circle-right"></i></a>

                            </div>

                        </div>
                        <div class="col-lg-3">
                            <div class="card-box bg-blue">
                                <div class="inner">
                                    <h3> <?= $compenycount; ?> </h3>
                                    <p> Company </p>
                                </div>
                                <div class="icon">
                                    <i class="mdi mdi-office-building-marker-outline"></i>
                                </div>
                                <a href="<?php echo base_url('/index.php/view_compeny');?>" class="card-box-footer py-2">View More <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="card-box bg-red">
                                <div class="inner">
                                    <h3> <?= $admin_usercount; ?> </h3>
                                    <p> Admin </p>
                                </div>
                                <div class="icon">
                                    <i class="mdi mdi-account-reactivate"></i>
                                </div>
                                <a href="<?php echo base_url('/index.php/user_details');?>" class="card-box-footer py-2">View More <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="card-box bg-green">
                                <div class="inner">
                                    <h3> <?= $VendorUsercount; ?> </h3>
                                    <p> Vendor </p>
                                </div>
                                <div class="icon">
                                    <i class="mdi mdi-account-box-multiple-outline"></i>
                                </div>
                                <a href="<?php echo base_url('/index.php/view_party_user');?>" class="card-box-footer py-2">View More <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="card-box bg-orange">
                                <div class="inner">
                                    <h3> Login </h3>
                                    <p>  Activity </p>
                                </div>
                                <div class="icon">
                                    <i class="mdi mdi-account-box-multiple-outline"></i>
                                </div>
                                <a href="<?php echo base_url('/index.php/view-recent-login');?>" class="card-box-footer py-2">View More <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="card-box bg-orange">
                                <div class="inner">
                                    <h3> Vendor Login </h3>
                                    <p>  Activity </p>
                                </div>
                                <div class="icon">
                                    <i class="mdi mdi-account-box-multiple-outline"></i>
                                </div>
                                <a href="<?php echo base_url('/index.php/view-recent-vendor-login');?>" class="card-box-footer py-2">View More <i class="fa     fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                     </div>
                     <?php
                     }
                     elseif($Roll_id==1)
                     {
                        ?>
                     <div class="row d-flex justify-content-center">
                        <div class="col-md-12 col-sm-12 List p-3">
                            <div class="col-6 mx-auto">
                                <form method="post" action="<?php echo site_url('/set_startDate_endDate'); ?>" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-md-5" >
                                            <input type="date" name="Sesssion_start_Date" class="form-control"  style="padding: 0.375rem 1.375rem" value="<?php echo $Sesssion_start_Date; ?>">
                                        </div>
                                        <div class="col-md-5" >
                                            <input type="date" name="Sesssion_end_Date" class="form-control"  style="padding: 0.375rem 1.375rem"  value="<?php echo $Sesssion_end_Date; ?>">
                                        </div>
                                        <div class="col-md-2" >
                                            <button type="submit" class="btn btn-success" style="padding: 0.675rem 1.375rem" name="btnsubmit" value="submit"> Submit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>    
                        </div>
                        <div class="col"> 
                            <div class="col-12">

                                <div class="card-box bg-blue">

                                   <div class="inner">

                                        <h3> <?= $Help_Support; ?> </h3>

                                        <p> Help And Support </p>

                                    </div>

                                    <div class="icon">

                                        <i class="mdi mdi-office-building-marker-outline"></i>

                                    </div>

                                    <a href="<?php echo base_url('/index.php/Help_Support_list');?>" class="card-box-footer py-2">View More <i class="fa fa-arrow-circle-right"></i></a>

                                </div>

                            </div>
                            <div class="col-12">
                                <div class="card-box bg-dark">
                                    <div class="inner">
                                        <h3> <?= $vendor_draft_bill_count; ?>  </h3>
                                        <p> Vendor Draft Bill </p>
                                    </div>
                                    <div class="icon">
                                        <i class="mdi mdi-office-building-marker-outline"></i>
                                    </div>
                                    <a href="<?php echo base_url('/index.php/view_bill_register_vendor_draft');?>" class="card-box-footer py-2">View More <i class="fa fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="card-box bg-dark">
                                    <div class="inner">
                                        <h3> <?= $BillMappingPendingcount; ?> (<span class="mdi mdi-currency-rupee"></span> <?php echo number_format((float)$BillMappingPendinSum['Bill_Amount'], 2, '.', ''); ?>) </h3>
                                        <p> Pending Bill Assigment </p>
                                    </div>
                                    <div class="icon">
                                        <i class="mdi mdi-office-building-marker-outline"></i>
                                    </div>
                                    <a href="<?php echo base_url('/index.php/all_bill_mapping_list?Satus=1');?>" class="card-box-footer py-2">View More <i class="fa fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="card-box bg-success">
                                    <div class="inner">
                                        <h3> <?= $BillMappingAcceptedcount; ?> (<span class="mdi mdi-currency-rupee"></span> <?php echo number_format((float)$BillMappingAcceptedSum['Bill_Amount'], 2, '.', ''); ?>)</h3>
                                        <p> Accepted Bill Assignment </p>
                                    </div>
                                    <div class="icon">
                                        <i class="mdi mdi-office-building-marker-outline"></i>
                                    </div>
                                    <a href="<?php echo base_url('/index.php/all_bill_mapping_list?Satus=2');?>" class="card-box-footer py-2">View More <i class="fa fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="card-box bg-danger">
                                    <div class="inner">
                                        <h3> <?= $BillMappingRejectcount; ?> (<span class="mdi mdi-currency-rupee"></span> <?php echo number_format((float)$BillMappingRejectedSum['Bill_Amount'], 2, '.', ''); ?>)</h3>
                                        <p> Rejected Bill Assignment </p>
                                    </div>
                                    <div class="icon">
                                        <i class="mdi mdi-office-building-marker-outline"></i>
                                    </div>
                                    <a href="<?php echo base_url('/index.php/all_bill_mapping_list?Satus=3');?>" class="card-box-footer py-2">View More <i class="fa fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="card-box bg-primary">
                                    <div class="inner">
                                        <h3> <?= $BillMappingDonecount; ?> (<span class="mdi mdi-currency-rupee"></span> <?php echo number_format((float)$BillMappingDoneSum['Bill_Amount'], 2, '.', ''); ?>)</h3>
                                        <p> Completed Bill Assignment </p>
                                    </div>
                                    <div class="icon">
                                        <i class="mdi mdi-office-building-marker-outline"></i>
                                    </div>
                                    <a href="<?php echo base_url('/index.php/all_bill_mapping_list?Satus=4');?>" class="card-box-footer py-2">View More <i class="fa fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-12">

                                <div class="card-box bg-blue">

                                    <div class="inner">

                                        <h3> <?= $Vendor_Quotation_Product; ?> </h3>

                                        <p> Product Quotation </p>

                                    </div>

                                    <div class="icon">

                                        <i class="mdi mdi-office-building-marker-outline"></i>

                                    </div>

                                    <a href="<?php echo base_url('/index.php/Vendor_Product_list');?>" class="card-box-footer py-2">View More <i class="fa fa-arrow-circle-right"></i></a>

                                </div>

                            </div>
                        </div>   
                        <div class="col">
                            <div class="col-12">
                                <div class="card-box bg-dark">
                                    <div class="inner">
                                        <h3> <?= $ClearBillFormPendingcount; ?> (<span class="mdi mdi-currency-rupee"></span> <?php echo number_format((float)$ClearBillFormPendingSum['Bill_Amount'], 2, '.', ''); ?>)</h3>
                                        <p> Pending Bill Verification </p>
                                    </div>
                                    <div class="icon">
                                        <i class="mdi mdi-office-building-marker-outline"></i>
                                    </div>
                                    <a href="<?php echo base_url('/index.php/all_Clear_Bill_Form_list?Satus=1');?>" class="card-box-footer py-2">View More <i class="fa fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="card-box bg-success">
                                    <div class="inner">
                                        <h3> <?= $ClearBillFormAcceptedcount; ?> (<span class="mdi mdi-currency-rupee"></span> <?php echo number_format((float)$ClearBillFormAcceptedSum['Bill_Amount'], 2, '.', ''); ?>)</h3>
                                        <p> Accepted Bill Verification </p>
                                    </div>
                                    <div class="icon">
                                        <i class="mdi mdi-office-building-marker-outline"></i>
                                    </div>
                                    <a href="<?php echo base_url('/index.php/all_Clear_Bill_Form_list?Satus=2');?>" class="card-box-footer py-2">View More <i class="fa fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="card-box bg-danger">
                                    <div class="inner">
                                        <h3> <?= $ClearBillFormRejectcount; ?> (<span class="mdi mdi-currency-rupee"></span> <?php echo number_format((float)$ClearBillFormRejectSum['Bill_Amount'], 2, '.', ''); ?>)</h3>
                                        <p> Rejected Bill Verification </p>
                                    </div>
                                    <div class="icon">
                                        <i class="mdi mdi-office-building-marker-outline"></i>
                                    </div>
                                    <a href="<?php echo base_url('/index.php/all_Clear_Bill_Form_list?Satus=3');?>" class="card-box-footer py-2">View More <i class="fa fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="card-box bg-primary">
                                    <div class="inner">
                                        <h3> <?= $ClearBillFormDonecount; ?> (<span class="mdi mdi-currency-rupee"></span> <?php echo number_format((float)$ClearBillFormDoneSum['Bill_Amount'], 2, '.', ''); ?>)</h3>
                                        <p> Completed Bill Verification </p>
                                    </div>
                                    <div class="icon">
                                        <i class="mdi mdi-office-building-marker-outline"></i>
                                    </div>
                                    <a href="<?php echo base_url('/index.php/all_Clear_Bill_Form_list?Satus=4');?>" class="card-box-footer py-2">View More <i class="fa fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-12">

                                <div class="card-box bg-blue">

                                    <div class="inner">

                                        <h3> <?= $Vendor_Orderder_Product; ?> </h3>

                                        <p> Ordered Quotation Product </p>

                                    </div>

                                    <div class="icon">

                                        <i class="mdi mdi-office-building-marker-outline"></i>

                                    </div>

                                    <a href="<?php echo base_url('/index.php/Ordered_Quotation_Product_list');?>" class="card-box-footer py-2">View More <i class="fa fa-arrow-circle-right"></i></a>

                                </div>

                            </div>
                        </div>
                        <div class="col">
                            <div class="col-12">
                                <div class="card-box bg-dark">
                                    <div class="inner">
                                        <h3> <?= $ERPSystemBillPendingcount; ?> (<span class="mdi mdi-currency-rupee"></span> <?php echo number_format((float)$ERPSystemBillPendingSum['Bill_Amount'], 2, '.', ''); ?>)</h3>
                                        <p> Pending Bill Entry  </p>
                                    </div>
                                    <div class="icon">
                                        <i class="mdi mdi-office-building-marker-outline"></i>
                                    </div>
                                    <a href="<?php echo base_url('/index.php/all_erpStystem_list?Satus=1');?>" class="card-box-footer py-2">View More <i class="fa fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="card-box bg-success">
                                    <div class="inner">
                                        <h3> <?= $ERPSystemBillFormAcceptedcount; ?> (<span class="mdi mdi-currency-rupee"></span> <?php echo number_format((float)$ERPSystemBillFormAcceptedSum['Bill_Amount'], 2, '.', ''); ?>)</h3>
                                        <p> Accepted Bill Entry </p>
                                    </div>
                                    <div class="icon">
                                        <i class="mdi mdi-office-building-marker-outline"></i>
                                    </div>
                                    <a href="<?php echo base_url('/index.php/all_erpStystem_list?Satus=2');?>" class="card-box-footer py-2">View More <i class="fa fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="card-box bg-danger">
                                    <div class="inner">
                                        <h3> <?= $ERPSystemBillRejectcount; ?> (<span class="mdi mdi-currency-rupee"></span> <?php echo number_format((float)$ERPSystemBillRejectSum['Bill_Amount'], 2, '.', ''); ?>)</h3>
                                        <p> Rejected Bill Entry  </p>
                                    </div>
                                    <div class="icon">
                                        <i class="mdi mdi-office-building-marker-outline"></i>
                                    </div>
                                    <a href="<?php echo base_url('/index.php/all_erpStystem_list?Satus=3');?>" class="card-box-footer py-2">View More <i class="fa fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="card-box bg-primary">
                                    <div class="inner">
                                        <h3> <?= $ERPSystemBillDonecount; ?> (<span class="mdi mdi-currency-rupee"></span> <?php echo number_format((float)$ERPSystemBillDoneSum['Bill_Amount'], 2, '.', ''); ?>)</h3>
                                        <p> Completed Bill Entry </p>
                                    </div>
                                    <div class="icon">
                                        <i class="mdi mdi-office-building-marker-outline"></i>
                                    </div>
                                    <a href="<?php echo base_url('/index.php/all_erpStystem_list?Satus=4');?>" class="card-box-footer py-2">View More <i class="fa fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="col-12">
                                <div class="card-box bg-dark">
                                    <div class="inner">
                                        <h3> <?= $RecivedBillPendingcount; ?>  (<span class="mdi mdi-currency-rupee"></span> <?php echo number_format((float)$RecivedBillPendingSum['Bill_Amount'], 2, '.', ''); ?>)</h3>
                                        <p> Pending Bill Receive </p>
                                    </div>
                                    <div class="icon">
                                        <i class="mdi mdi-office-building-marker-outline"></i>
                                    </div>
                                    <a href="<?php echo base_url('/index.php/all_recived_bill_list?Satus=1');?>" class="card-box-footer py-2">View More <i class="fa fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="card-box bg-success">
                                    <div class="inner">
                                        <h3> <?= $RecivedBillAcceptedcount; ?>  (<span class="mdi mdi-currency-rupee"></span> <?php echo number_format((float)$RecivedBillAcceptedSum['Bill_Amount'], 2, '.', ''); ?>)</h3>
                                        <p> Accepted Bill Receive </p>
                                    </div>
                                    <div class="icon">
                                        <i class="mdi mdi-office-building-marker-outline"></i>
                                    </div>
                                    <a href="<?php echo base_url('/index.php/all_recived_bill_list?Satus=2');?>" class="card-box-footer py-2">View More <i class="fa fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="card-box bg-danger">
                                    <div class="inner">
                                        <h3> <?= $RecivedBillRejectcount; ?>  (<span class="mdi mdi-currency-rupee"></span> <?php echo number_format((float)$RecivedBillRejectSum['Bill_Amount'], 2, '.', ''); ?>)</h3>
                                        <p> Rejected Bill Receive </p>
                                    </div>
                                    <div class="icon">
                                        <i class="mdi mdi-office-building-marker-outline"></i>
                                    </div>
                                    <a href="<?php echo base_url('/index.php/all_recived_bill_list?Satus=3');?>" class="card-box-footer py-2">View More <i class="fa fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="card-box bg-primary">
                                    <div class="inner">
                                        <h3> <?= $RecivedBillDonecount; ?>  (<span class="mdi mdi-currency-rupee"></span> <?php echo number_format((float)$RecivedBillDoneSum['Bill_Amount'], 2, '.', ''); ?>)</h3>
                                        <p> Completed Bill Receive </p>
                                    </div>
                                    <div class="icon">
                                        <i class="mdi mdi-office-building-marker-outline"></i>
                                    </div>
                                    <a href="<?php echo base_url('/index.php/all_recived_bill_list?Satus=4');?>" class="card-box-footer py-2">View More <i class="fa fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="col-12">
                                <div class="card-box bg-blue">
                                    <div class="inner">
                                        <h3> <?= $usercount; ?> </h3>
                                        <p> User </p>
                                    </div>
                                    <div class="icon">
                                        <i class="mdi mdi-office-building-marker-outline"></i>
                                    </div>
                                    <a href="<?php echo base_url('/index.php/user_details');?>" class="card-box-footer py-2">View More <i class="fa fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="card-box bg-red">
                                    <div class="inner">
                                        <h3> <?= $VendorUsercount; ?> - (<?= $AddVendorInUsercount; ?>) </h3>
                                        <p> Vendor </p>
                                    </div>
                                    <div class="icon">
                                        <i class="mdi mdi-office-building-marker-outline"></i>
                                    </div>
                                    <a href="<?php echo base_url('/index.php/add-vendor-in-organization');?>" class="card-box-footer py-2">View More <i class="fa fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="card-box bg-green">
                                    <div class="inner">
                                        <h3> <?= $allBillcount; ?> (<span class="mdi mdi-currency-rupee"></span> <?php echo number_format((float)$allBillSum['Bill_Amount'], 2, '.', ''); ?>)</h3>
                                        <p> All Bill </p>
                                    </div>
                                    <div class="icon">
                                        <i class="mdi mdi-office-building-marker-outline"></i>
                                    </div>
                                    <a href="<?php echo base_url('/index.php/view_bill_register');?>" class="card-box-footer py-2">View More <i class="fa fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div> 
                    <div class="row d-flex justify-content-center">   
                     <?php
                     }
                     elseif($Roll_id==2)
                     {   ?>

                        <div class="row">
                            <div class="col-md-12 col-sm-12 List p-3">
                                <div class="col-6 mx-auto">
                                    <form method="post" action="<?php echo site_url('/set_startDate_endDate'); ?>" enctype="multipart/form-data">
                                        <div class="row">
                                            <div class="col-md-5" >
                                                <input type="date" name="Sesssion_start_Date" class="form-control"  style="padding: 0.375rem 1.375rem" value="<?php echo $Sesssion_start_Date; ?>">
                                            </div>
                                            <div class="col-md-5" >
                                                <input type="date" name="Sesssion_end_Date" class="form-control"  style="padding: 0.375rem 1.375rem"  value="<?php echo $Sesssion_end_Date; ?>">
                                            </div>
                                            <div class="col-md-2" >
                                                <button type="submit" class="btn btn-success" style="padding: 0.675rem 1.375rem" name="btnsubmit" value="submit"> Submit </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>    
                            </div>
                        </div>
                        <?php    
                        $Roll_id = $session->get("Roll_id");
                        $emp_id = $session->get("emp_id"); 
                        $compeny_id = $session->get("compeny_id"); 
                        
                        $rollpage = $employeeModel->pagelinkaccordingtoroll($emp_id);
                        $menu = $rollpage->get()->getResult();
                        if(isset($menu)){  
                            foreach ($menu as $menun){ 
                                if($menun->Page_Id==4){ ?>
                                    <div class="row"> 
                                        <div class="col-md-3">
                                            <div class="card-box bg-dark">
                                                <div class="inner">
                                                    <h3> <?= $BillMappingPendingcount; ?> (<span class="mdi mdi-currency-rupee"></span> <?php echo number_format((float)$BillMappingPendinSum['Bill_Amount'], 2, '.', ''); ?>) </h3>
                                                    <p> Pending Bill Assigment </p>
                                                </div>
                                                <div class="icon">
                                                    <i class="mdi mdi-office-building-marker-outline"></i>
                                                </div>
                                                <a href="<?php echo base_url('/index.php/all_bill_mapping_list?Satus=1');?>" class="card-box-footer py-2">View More <i class="fa fa-arrow-circle-right"></i></a>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="card-box bg-success">
                                                <div class="inner">
                                                    <h3> <?= $BillMappingAcceptedcount; ?> (<span class="mdi mdi-currency-rupee"></span> <?php echo number_format((float)$BillMappingAcceptedSum['Bill_Amount'], 2, '.', ''); ?> )</h3>
                                                    <p> Accepted Bill Assignment </p>
                                                </div>
                                                <div class="icon">
                                                    <i class="mdi mdi-office-building-marker-outline"></i>
                                                </div>
                                                <a href="<?php echo base_url('/index.php/all_bill_mapping_list?Satus=2');?>" class="card-box-footer py-2">View More <i class="fa fa-arrow-circle-right"></i></a>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="card-box bg-danger">
                                                <div class="inner">
                                                    <h3> <?= $BillMappingRejectcount; ?> (<span class="mdi mdi-currency-rupee"></span> <?php echo number_format((float)$BillMappingRejectedSum['Bill_Amount'], 2, '.', ''); ?>)</h3>
                                                    <p> Rejected Bill Assignment </p>
                                                </div>
                                                <div class="icon">
                                                    <i class="mdi mdi-office-building-marker-outline"></i>
                                                </div>
                                                <a href="<?php echo base_url('/index.php/all_bill_mapping_list?Satus=3');?>" class="card-box-footer py-2">View More <i class="fa fa-arrow-circle-right"></i></a>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="card-box bg-primary">
                                                <div class="inner">
                                                    <h3> <?= $BillMappingDonecount; ?> (<span class="mdi mdi-currency-rupee"></span> <?php echo number_format((float)$BillMappingDoneSum['Bill_Amount'], 2, '.', ''); ?>)</h3>
                                                    <p> Completed Bill Assignment </p>
                                                </div>
                                                <div class="icon">
                                                    <i class="mdi mdi-office-building-marker-outline"></i>
                                                </div>
                                                <a href="<?php echo base_url('/index.php/all_bill_mapping_list?Satus=4');?>" class="card-box-footer py-2">View More <i class="fa fa-arrow-circle-right"></i></a>
                                            </div>
                                        </div>
                                    </div>  
                                <?php }
                                if($menun->Page_Id==5){ ?>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="card-box bg-dark">
                                                <div class="inner">
                                                    <h3> <?= $ClearBillFormPendingcount; ?> (<span class="mdi mdi-currency-rupee"></span> <?php echo number_format((float)$ClearBillFormPendingSum['Bill_Amount'], 2, '.', ''); ?>)</h3>
                                                    <p> Pending Bill Verification </p>
                                                </div>
                                                <div class="icon">
                                                    <i class="mdi mdi-office-building-marker-outline"></i>
                                                </div>
                                                <a href="<?php echo base_url('/index.php/all_Clear_Bill_Form_list?Satus=1');?>" class="card-box-footer py-2">View More <i class="fa fa-arrow-circle-right"></i></a>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="card-box bg-success">
                                                <div class="inner">
                                                    <h3> <?= $ClearBillFormAcceptedcount; ?> (<span class="mdi mdi-currency-rupee"></span> <?php echo number_format((float)$ClearBillFormAcceptedSum['Bill_Amount'], 2, '.', ''); ?>)</h3>
                                                    <p> Accepted Bill Verification </p>
                                                </div>
                                                <div class="icon">
                                                    <i class="mdi mdi-office-building-marker-outline"></i>
                                                </div>
                                                <a href="<?php echo base_url('/index.php/all_Clear_Bill_Form_list?Satus=2');?>" class="card-box-footer py-2">View More <i class="fa fa-arrow-circle-right"></i></a>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="card-box bg-danger">
                                                <div class="inner">
                                                    <h3> <?= $ClearBillFormRejectcount; ?> (<span class="mdi mdi-currency-rupee"></span> <?php echo number_format((float)$ClearBillFormRejectSum['Bill_Amount'], 2, '.', ''); ?>)</h3>
                                                    <p> Rejected Bill Verification </p>
                                                </div>
                                                <div class="icon">
                                                    <i class="mdi mdi-office-building-marker-outline"></i>
                                                </div>
                                                <a href="<?php echo base_url('/index.php/all_Clear_Bill_Form_list?Satus=3');?>" class="card-box-footer py-2">View More <i class="fa fa-arrow-circle-right"></i></a>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="card-box bg-primary">
                                                <div class="inner">
                                                    <h3> <?= $ClearBillFormDonecount; ?> (<span class="mdi mdi-currency-rupee"></span> <?php echo number_format((float)$ClearBillFormDoneSum['Bill_Amount'], 2, '.', ''); ?>)</h3>
                                                    <p> Completed Bill Verification </p>
                                                </div>
                                                <div class="icon">
                                                    <i class="mdi mdi-office-building-marker-outline"></i>
                                                </div>
                                                <a href="<?php echo base_url('/index.php/all_Clear_Bill_Form_list?Satus=4');?>" class="card-box-footer py-2">View More <i class="fa fa-arrow-circle-right"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                <?php }  
                                if($menun->Page_Id==6){ ?>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="card-box bg-dark">
                                                <div class="inner">
                                                    <h3> <?= $ERPSystemBillPendingcount; ?> (<span class="mdi mdi-currency-rupee"></span> <?php echo number_format((float)$ERPSystemBillPendingSum['Bill_Amount'], 2, '.', ''); ?>)</h3>
                                                    <p> Pending Bill Entry  </p>
                                                </div>
                                                <div class="icon">
                                                    <i class="mdi mdi-office-building-marker-outline"></i>
                                                </div>
                                                <a href="<?php echo base_url('/index.php/all_erpStystem_list?Satus=1');?>" class="card-box-footer py-2">View More <i class="fa fa-arrow-circle-right"></i></a>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="card-box bg-success">
                                                <div class="inner">
                                                    <h3> <?= $ERPSystemBillFormAcceptedcount; ?> (<span class="mdi mdi-currency-rupee"></span> <?php echo number_format((float)$ERPSystemBillFormAcceptedSum['Bill_Amount'], 2, '.', ''); ?>)</h3>
                                                    <p> Accepted Bill Entry </p>
                                                </div>
                                                <div class="icon">
                                                    <i class="mdi mdi-office-building-marker-outline"></i>
                                                </div>
                                                <a href="<?php echo base_url('/index.php/all_erpStystem_list?Satus=2');?>" class="card-box-footer py-2">View More <i class="fa fa-arrow-circle-right"></i></a>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="card-box bg-danger">
                                                <div class="inner">
                                                    <h3> <?= $ERPSystemBillRejectcount; ?> (<span class="mdi mdi-currency-rupee"></span> <?php echo number_format((float)$ERPSystemBillRejectSum['Bill_Amount'], 2, '.', ''); ?>)</h3>
                                                    <p> Rejected Bill Entry  </p>
                                                </div>
                                                <div class="icon">
                                                    <i class="mdi mdi-office-building-marker-outline"></i>
                                                </div>
                                                <a href="<?php echo base_url('/index.php/all_erpStystem_list?Satus=3');?>" class="card-box-footer py-2">View More <i class="fa fa-arrow-circle-right"></i></a>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="card-box bg-primary">
                                                <div class="inner">
                                                    <h3> <?= $ERPSystemBillDonecount; ?> (<span class="mdi mdi-currency-rupee"></span> <?php echo number_format((float)$ERPSystemBillDoneSum['Bill_Amount'], 2, '.', ''); ?>)</h3>
                                                    <p> Completed Bill Entry </p>
                                                </div>
                                                <div class="icon">
                                                    <i class="mdi mdi-office-building-marker-outline"></i>
                                                </div>
                                                <a href="<?php echo base_url('/index.php/all_erpStystem_list?Satus=4');?>" class="card-box-footer py-2">View More <i class="fa fa-arrow-circle-right"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                <?php }   
                                if($menun->Page_Id==7){ ?>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="card-box bg-dark">
                                                <div class="inner">
                                                    <h3> <?= $RecivedBillPendingcount; ?>  (<span class="mdi mdi-currency-rupee"></span> <?php echo number_format((float)$RecivedBillPendingSum['Bill_Amount'], 2, '.', ''); ?>)</h3>
                                                    <p> Pending Bill Receive </p>
                                                </div>
                                                <div class="icon">
                                                    <i class="mdi mdi-office-building-marker-outline"></i>
                                                </div>
                                                <a href="<?php echo base_url('/index.php/all_recived_bill_list?Satus=1');?>" class="card-box-footer py-2">View More <i class="fa fa-arrow-circle-right"></i></a>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="card-box bg-success">
                                                <div class="inner">
                                                    <h3> <?= $RecivedBillAcceptedcount; ?>  (<span class="mdi mdi-currency-rupee"></span> <?php echo number_format((float)$RecivedBillAcceptedSum['Bill_Amount'], 2, '.', ''); ?>)</h3>
                                                    <p> Accepted Bill Receive </p>
                                                </div>
                                                <div class="icon">
                                                    <i class="mdi mdi-office-building-marker-outline"></i>
                                                </div>
                                                <a href="<?php echo base_url('/index.php/all_recived_bill_list?Satus=2');?>" class="card-box-footer py-2">View More <i class="fa fa-arrow-circle-right"></i></a>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="card-box bg-danger">
                                                <div class="inner">
                                                    <h3> <?= $RecivedBillRejectcount; ?>  (<span class="mdi mdi-currency-rupee"></span> <?php echo number_format((float)$RecivedBillRejectSum['Bill_Amount'], 2, '.', ''); ?>)</h3>
                                                    <p> Rejected Bill Receive </p>
                                                </div>
                                                <div class="icon">
                                                    <i class="mdi mdi-office-building-marker-outline"></i>
                                                </div>
                                                <a href="<?php echo base_url('/index.php/all_recived_bill_list?Satus=3');?>" class="card-box-footer py-2">View More <i class="fa fa-arrow-circle-right"></i></a>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="card-box bg-primary">
                                                <div class="inner">
                                                    <h3> <?= $RecivedBillDonecount; ?>  (<span class="mdi mdi-currency-rupee"></span> <?php echo number_format((float)$RecivedBillDoneSum['Bill_Amount'], 2, '.', ''); ?>)</h3>
                                                    <p> Completed Bill Receive </p>
                                                </div>
                                                <div class="icon">
                                                    <i class="mdi mdi-office-building-marker-outline"></i>
                                                </div>
                                                <a href="<?php echo base_url('/index.php/all_recived_bill_list?Satus=4');?>" class="card-box-footer py-2">View More <i class="fa fa-arrow-circle-right"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                <?php }  
                                if($menun->Page_Id==2){ ?>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="card-box bg-blue">
                                                <div class="inner">
                                                    <h3>  </h3>
                                                    <p> Add Bill</p>
                                                </div>
                                                <div class="icon">
                                                    <i class="mdi mdi-office-building-marker-outline"></i>
                                                </div>
                                                <a href="<?php echo base_url('/index.php/add_bill_register');?>" class="card-box-footer py-2">Add Bill <i class="fa fa-arrow-circle-right"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                <?php } 
                                if($menun->Page_Id==3){ ?>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="card-box bg-blue">
                                                <div class="inner">
                                                    <h3>  </h3>
                                                    <p> View Bill </p>
                                                </div>
                                                <div class="icon">
                                                    <i class="mdi mdi-office-building-marker-outline"></i>
                                                </div>
                                                <a href="<?php echo base_url('/index.php/view_bill_register');?>" class="card-box-footer py-2">View Bill <i class="fa fa-arrow-circle-right"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                <?php } 
                            }
                        }
                     }
                     ?>
                    </div> 
                  </div>
               </div>
            </div>
            <!-- main-panel ends -->
         </div>
         <?php include('include/footer.php')?>
         <!-- page-body-wrapper ends -->
      </div>
      <!-- container-scroller -->
      <?php include('include/script.php'); ?>
   </body>
</html>