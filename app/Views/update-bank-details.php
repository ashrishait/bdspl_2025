<?php 

use App\Models\EmployeeModel;
$EmployeeModelObj = new EmployeeModel();

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include('include/head.php'); ?>
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
        						    <?php
        					        if(session()->has("emp_ok"))
        						    {   
                                        if(session("emp_ok")==1)   
                                        {  
             			                    echo "<div class='alert alert-success' role='alert'> Form Submition Successful. </div>";
                                        }
                                        else{
                                            echo "<div class='alert alert-danger' role='alert'> Problem in Submition! </div>";
                                        }
                                    } 
        					        ?>
                                </div>
                                <div class="col-md-12">
                                    <div class="col-md-12 col-sm-12 List p-3">
                                        <div class="row">
                                            <div class="col-6">
                                               <h2>Update Bank Details</h2>
                                            </div>
                                            <div class="col-6">
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <?php
                                        foreach ($dax as $row){
                                        ?>
                                        <div class="card-body">
                                            <form method="post" action="<?php echo site_url('/update-details'); ?>" enctype="multipart/form-data"> 
                                                <input class="form-control" type="hidden" name="empid" value="<?php echo $row['id'];?>">
                    				            <div>
                    				                <div class="row">
                                    					<div class="col-sm-12 col-md-3">
                                						    <div class="form-group">  
                                							    <label>Bank Name <span style="color:red;">*</span></label>
                                							    <input class="form-control" type="text" name="Bank_Name" value="<?php echo $row['bank_name'];?>">
                                							</div> 
                                						</div>	
                                						<div class="col-sm-12 col-md-3">
                                						    <div class="form-group">
                                							    <label>Branch Name</label>
                                								<input class="form-control" type="text" name="Branch_Name" value="<?php echo $row['Bank_Branch'];?>">
                                							</div>
                                						</div>
                                						<div class="col-sm-12 col-md-3">
                                						    <div class="form-group">  
                                							    <label>A/c No <span style="color:red;">*</span></label>
                                								<input class="form-control" type="text" name="accountno" value="<?php echo $row['Acnt_No'];?>">
                                							</div> 
                                						</div>
                                						<div class="col-sm-12 col-md-3">
                                						    <div class="form-group">  
                                							    <label>Ifsc Code <span style="color:red;">*</span></label>
                                								<input class="form-control" type="text" name="ifsc" value="<?php echo $row['Ifsc_Code'];?>">
                                							</div> 
                                						</div>
                                						<div class="col-sm-12 col-md-3">
                                						    <div class="form-group">  
                                							    <label>A/c Holder Name <span style="color:red;">*</span></label>
                                								<input class="form-control" type="text" name="accountholdername" value="<?php echo $row['Acnt_Holder_Name'];?>">
                                							</div> 
                                						</div>
                                					</div>
                                					<div class="row">
                                						<div class="col-sm-12 col-md-6">
                                                			<button type="submit" class="btn btn-primary btn-lg">Submit</button>   
                                                			<button type="reset" class="btn btn-secondary btn-lg">Reset</button>
                                						</div>
                                					</div>
                                                </div>
                                            </form>
			                            </div>
			                            <?php } ?>
                                    </div>
                                </div>
                            </div>    
                        </div>
			        </div>
		        </div>
	        </div>
	        <?php include('include/footer.php')?>
        </div>
		<!-- container-scroller -->
        <?php include('include/script.php'); ?>
    </body>
</html>