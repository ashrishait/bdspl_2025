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
                                 <h2 class="mb-3 font-weight-bold"> Commission (Reward Point) Dashboard</h2>
                                 <h3 class="mt-3 mb-3 font-weight-bold">Welcome !
                                    <?php echo ucwords($name);?> ( <?php echo ucwords($Role);?>)
                                 </h3>
                                   <?php
                                    if(session()->has("ok"))
                                    {   
                                        if(session("ok")==1)   
                                        {  
                                            echo "<div class='alert alert-success' role='alert'> Form Submition Successful. </div>";
                                        }
                                        else{
                                            echo "<div class='alert alert-danger' role='alert'> Problem in Submition! </div>";
                                        }
                                    } 
                                     if(session()->has("exit_ok"))
                                    {   
                                        if(session("exit_ok")==1)   
                                        {  
                                            echo "<div class='alert alert-danger' role='alert'> already  Request. </div>";
                                        }
                                        else{
                                            echo "<div class='alert alert-danger' role='alert'> Problem in Submition! </div>";
                                        }
                                    } 
                                    ?>
                              </div>
                           </div>
                        </div>
                     </div>
                     <?php
                     if($Roll_id==0||$Roll_id==1||$Roll_id==2||$Roll_id==3||$Roll_id==4||$Roll_id==5||$Roll_id==6||$Roll_id==7)
                     {

                     ?>
                     <div class="row d-flex justify-content-center">

                        <div class="col-lg-3">
                            <div class="card-box bg-success">
                                <div class="inner">
                                    <h3> Total Paid Reward : <?php if(!empty($Paid_reward_pointSum)){ echo $Paid_reward_pointSum; }else{ echo '0';} ?> </h3>
                                    <p> Reward Paid   </p>
                                </div>
                                <div class="icon">
                                    <i class="mdi mdi-office-building-marker-outline"></i>
                                </div>
                                <a href="" class="card-box-footer py-2">View More <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div>


                        <div class="col-lg-3">
                            <div class="card-box bg-blue">
                                <div class="inner">
                                    <h3>Unpaid Reward : <?= $Unpaid_reward_pointSum; ?></h3>
                                    <p> Bill Received </p>
                                </div>
                                <div class="icon">
                                    <i class="mdi mdi-office-building-marker-outline"></i>
                                </div>
                                <a href="" class="card-box-footer py-2">View More <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <div class="card-box bg-danger">
                                <div class="inner">
                                    <h3> Pending Reward : <?= $Pending_reward_pointSum; ?> </h3>
                                    <p> Bill Not Received </p>
                                </div>
                                <div class="icon">
                                    <i class="mdi mdi-office-building-marker-outline"></i>
                                </div>
                                <a href="" class="card-box-footer py-2">View More <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="card-box bg-danger">
                                <div class="inner">
                                    <h3> Reject Reward : <?= $Reject_reward_pointSum; ?> </h3>
                                    <p> Bill  Received </p>
                                </div>
                                <div class="icon">
                                    <i class="mdi mdi-office-building-marker-outline"></i>
                                </div>
                                <a href="" class="card-box-footer py-2">View More <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                      
                        <!--<div class="col-lg-3">-->
                        <!--    <div class="card-box bg-danger">-->
                        <!--        <div class="inner">-->
                        <!--            <h3> Reward Point : <?= $Pending_reward_pointSum; ?> </h3>-->
                        <!--            <p>   Completed Commission </p>-->
                        <!--        </div>-->
                        <!--        <div class="icon">-->
                        <!--            <i class="mdi mdi-office-building-marker-outline"></i>-->
                        <!--        </div>-->
                        <!--        <a href="" class="card-box-footer py-2">View More <i class="fa fa-arrow-circle-right"></i></a>-->
                        <!--    </div>-->
                        <!--</div>-->

                        <!--<div class="col-lg-3">-->
                        <!--    <div class="card-box bg-danger">-->
                        <!--        <div class="inner">-->
                        <!--            <h3> Reward Point : <?= $Pending_request_reward_point_Sum; ?> </h3>-->
                        <!--            <p>   Request Reward Point </p>-->
                        <!--        </div>-->
                        <!--        <div class="icon">-->
                        <!--            <i class="mdi mdi-office-building-marker-outline"></i>-->
                        <!--        </div>-->
                        <!--        <a href="" class="card-box-footer py-2">View More <i class="fa fa-arrow-circle-right"></i></a>-->
                        <!--    </div>-->
                        <!--</div>-->
                        

                        <div class="col-md-12" style="display:none">
                        <div class="col-md-12 col-sm-12 List p-3">
                            <div class="row">
                                <div class="col-6">
                                   <h2>Add Request Reward Point</h2>
                                </div>
                                <div class="col-6">
                                    <a id="rowAdder" type="button" class="btn btn-success float-end" href="<?php echo base_url();?>/index.php/View_Request_Reward_Point_history">
                                        <span class="bi bi-plus-square-dotted">
                                        </span> View Request
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                           <div class="card-body cardbody">
                              <form method="post" action="<?php echo site_url('/set_RequestRewardPoint'); ?>" enctype="multipart/form-data">
                                 <input  type="hidden" name="compeny_id" value="<?php echo $compeny_id;?>" >
                                 <input  type="hidden" name="emp_id" value="<?php echo $emp_id;?>" >
                                 <input  type="hidden" name="request_reward_point" value="<?= $Unpaid_reward_pointSum; ?>" >
                                 <div class="row">
                                   
                                    <div class="col-sm-12 col-md-4">
                                       <div class="form-group">
                                          <label for="billpic" > Request Reward Point <span style="color:red;">*</span></label>
                                          <input class="form-control" type="text" name="" placeholder=" " style="padding: 0.875rem 1.375rem" readonly value="<?= $Unpaid_reward_pointSum; ?>">
                                       </div>
                                    </div>
                                    
                                   
                                   
                                 
                                 </div>
                                 <?php if($Unpaid_reward_pointSum>0){?>
                                 <div class="row">
                                    <div class="col-12">
                                       <button type="submit" class="btn btn-primary btn-lg">Submit</button>   
                                       <button type="reset" class="btn btn-secondary btn-lg">Reset</button>
                                    </div>
                                 </div>
                                     <?php }?>
                              </form>
                           </div>
                        </div>
                     </div>
                     </div>
                     <?php
                     }
                    ?>
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