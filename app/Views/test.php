<?php 
 
   if (isset($_GET["Vendor_Id"])) {
        $Vendor_Id = $_GET["Vendor_Id"];
   } else {
        $Vendor_Id = "";
   }
   if (isset($_GET["start_Date"])) {
        $start_Date = $_GET["start_Date"];
   } else {
        $start_Date = "";
   }
   if (isset($_GET["end_Date"])) {
        $end_Date = $_GET["end_Date"];
   } else {
        $end_Date = "";
   }
   ?>
<!DOCTYPE html>
<html lang="en">
   <head>
      
   </head>
   <body>
      
                  <div class="col-lg-12">
                      <div class="col-md-12 col-sm-12 List p-3">
                                <div class="row">
                                    <div class="col-md-4">
                                       <h2> </h2>
                                    </div>
                                    <div class="col-md-6">
                                      <form method="get" action="<?php echo site_url('/test'); ?>" enctype="multipart/form-data">
                                       <div class="row">
                                           <div class="col-md-3" >
                                          <input type="date" name="start_Date" class="form-control" required style="padding: 0.375rem 1.375rem">
                                       </div>
                                       <div class="col-md-3" >

                                           <input type="date" name="end_Date" class="form-control" required style="padding: 0.375rem 1.375rem">
                                        </div>
                                       
                                       <div class="col-md-3" >
                                         <button type="submit" class="btn btn-warning" style="padding: 0.675rem 1.375rem"> Search   </button>
                                          </div>
                                           </div>
                                        </form>
                                    </div>
                                  
        
   </body>
</html>