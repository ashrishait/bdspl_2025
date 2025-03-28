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
                                               <h2>Add User</h2>
                                            </div>
                                            <div class="col-6">
                                                <a id="rowAdder" type="button" class="btn btn-success float-end" href="<?php echo base_url();?>/index.php/user_details">
                                                    <span class="bi bi-plus-square-dotted">
                                                    </span> View User
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-body">
                                            <form method="post" action="<?php echo site_url('/set-employee'); ?>" enctype="multipart/form-data"> 
                    				            <div>
                    				                <div class="row">
                                    					<div class="col-sm-12 col-md-3">
                                    					    <div class="col-sm-12 col-md-12">
                                    						    <div class="form-group">
                                    						        <label>Photo</label>
                                    					            <!--<img src="<?php echo base_url('public/vendors/images/avtar.jpg');?>" style="height:120px; width:auto;" id="output">-->
                                    		                        <input type="file" class="form-control" accept="image/png, image/jpg, image/jpeg"  name="E_Image" id="E_Image"  onchange="loadFile(event)" >
                                    		                        <span style="color:red;"><?php if(isset($error['E_Image'])){ 
                                    						            echo $error['E_Image']; 
                                    				                }?>
                                                					</span>
                                                                </div>    
                                    						</div>
                                    					</div>	
                                                        <div class="col-sm-12 col-md-3">
                                						    <div class="form-group">  
                                							    <label>First Name <span style="color:red;">*</span></label>
                                							    <input class="form-control" type="text" name="F_Name" value="<?= set_value('F_Name'); ?>">
                                							    <span style="color:red;"><?php if(isset($error['F_Name'])){ echo $error['F_Name']; } ?></span>
                                							</div> 
                                						</div>	
                                						<div class="col-sm-12 col-md-3">
                                						    <div class="form-group">
                                							    <label>Last Name</label>
                                								<input class="form-control" type="text" name="L_Name" value="<?= set_value('L_Name'); ?>">
                                								<span style="color:red;"><?php if(isset($error['L_Name'])){ echo $error['L_Name']; } ?></span>
                                							</div>
                                						</div>
                                						<div class="col-sm-12 col-md-3">
                                						    <div class="form-group">
                                							    <label>Gender <span style="color:red;">*</span></label>
                                								<select name="Gender" class="form-control" style="padding: 0.875rem 1.375rem"> 
                                									<option value="">-Select-</option>
                                									<option value="Male" <?php if(isset($_POST['Gender']) && $_POST['Gender']=='Male') echo 'selected="selected"'; ?>>Male</option>
                                									<option value="Female" <?php if(isset($_POST['Gender']) && $_POST['Gender']=='Female') echo 'selected="selected"'; ?>>Female</option>
                                									<option value="Any Other" <?php if(isset($_POST['Gender']) && $_POST['Gender']=='Any Other') echo 'selected="selected"'; ?>>Any Other</option>   
                                								</select>
                                								<span style="color:red;"><?php if(isset($error['Gender'])){ echo $error['Gender']; } ?></span>
                                							</div>
                                						</div>
                                					</div>
                                					<div class="row">
                                					    <div class="col-sm-12 col-md-3">
                                						    <div class="form-group">  
                                							    <label>Email <span style="color:red;">*</span></label>
                                								<input class="form-control" type="email" name="Email_id" value="<?= set_value('Email_id'); ?>">
                                								<span style="color:red;"><?php if(isset($error['Email_id'])){ echo $error['Email_id']; } ?></span>
                                							</div> 
                                						</div>	
                                						<div class="col-sm-12 col-md-3">
                                						    <div class="form-group">
                                							    <label>Mobile No <span style="color:red;">*</span></label>
                                								<input class="form-control" type="number" name="Mobile" value="<?= set_value('Mobile'); ?>" >
                                								<span style="color:red;"><?php if(isset($error['Mobile'])){ echo $error['Mobile']; } ?></span>
                                							</div>
                                						</div>
                                						<div class="col-sm-12 col-md-3">
                                						    <div class="form-group">
                                							    <label>Password <span style="color:red;">*</span></label>
                                								<input class="form-control" type="password" name="E_Password" value="">
                                								<span style="color:red;"><?php if(isset($error['E_Password'])){ echo $error['E_Password']; } ?></span>
                                							</div> 
                                						</div>	
                            							
                                                        <div class="col-sm-12 col-md-3">
                                						    <div class="form-group">
                                							    <label>Role <span style="color:red;">*</span></label>   
                                								<select name="role" class="form-control" style="padding: 0.875rem 1.375rem" required> 
                                									<?php
                                                                    if($Roll_id=='0')
                                                                    {
                                                                        ?>
                                                                       <option value="1">Admin</option>
                                                                       <?php
                                                                    }
                                                                    else
                                                                    {

                                                                    
                                									if(isset($dax8)){
                                										foreach ($dax8 as $row){ ?>
                                									  	    <option value="<?php echo $row['Roll_Id']; ?>" <?php if(isset($_POST['Roll_Id']) && $_POST['Roll_Id']==$row['Roll_Id']) echo 'selected="selected"'; ?>><?php echo ucwords($row['Name']); ?></option>
                                									<?php }} } ?>   
                                								</select>
                                                                <span style="color:red;"><?php if(isset($error['role'])){ echo $error['role']; } ?></span>
                                							</div>
                                						</div> 
                                					</div>
                                                    
                                					<div class="row">
                                					    <?php 
                                                        if($Roll_id=='0')
                                                        {
                                                            ?>
                                                            <input  type="hidden" name="unit_id" value="0" >
                                                            <input  type="hidden" name="department" value="0" >
                                                            <?php
                                                        }
                                                        else
                                                        {
                                                            ?>
                                                            <div class="col-sm-12 col-md-3">
                                                                <div class="form-group">
                                                                    <label>Unit  <span style="color:red;">*</span></label>
                                                                   <select name="unit_id" class="form-control" id="Unit_Id____" style="padding: 0.875rem 1.375rem" required>
                                                                        <option value="">-Select -</option>  
                                                                         <?php
                                                                        if(isset($dax15)){
                                                                        foreach ($dax15 as $row15){ ?>
                                                                        <option value="<?php echo $row15['id']; ?>" ><?php echo ucwords($row15['name']); ?></option>
                                                                        <?php }} ?>        
                                                                     </select>
                                                                  
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12 col-md-3">
                                                                <div class="form-group">
                                                                    <label>Department <span style="color:red;">*</span></label>
                                                                        <select name="department" class="form-control" style="padding: 0.875rem 1.375rem" required id="Department_Id____" > 
                                                                        <option value="">-Select Department-</option>
                                                                           <?php
                                                                            if(isset($dax9)){
                                                                            foreach ($dax9 as $row9){ ?>
                                                                            <option value="<?php echo $row9['Id']; ?>" ><?php echo ucwords($row9['Department_Name']); ?></option>
                                                                            <?php }} ?>
                                                                    </select>
                                                               
                                                                </div> 
                                                            </div> 
                                                            <?php
                                                        }
                                                        ?>
                            						     
                                                        <?php
                                                        if($Roll_id==0)
                                                        {
                                                            ?>
                                                            <div class="col-sm-12 col-md-3">
                                                                <div class="form-group">
                                                                    <label>Company <span style="color:red;">*</span></label>   
                                                                    <select name="compeny_id" class="form-control" style="padding: 0.875rem 1.375rem" > 
                                                                        <option value="">-Select Compeny-</option>
                                                                        <?php
                                                                        if(isset($dax14)){
                                                                            foreach ($dax14 as $row14){ 
                                                                                //$Employeerow= $EmployeeModelObj->where('compeny_id',$row14['id'])->first();
                                                                                if(isset($row14) && $row14!='')
                                                                                { ?>
                                                                                    <option value="<?php echo $row14['id']; ?>" ><?php echo ucwords($row14['name']); ?></option>
                                                                                <?php }
                                                                                else{
                                                                                }
                                                                            } 
                                                                        }
                                                                        ?>   
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <?php
                                                        }
                                                        else
                                                        {
                                                            ?>
                                                            <input  type="hidden" name="compeny_id"  value="<?php echo $compeny_id;  ?>">
                                                            <?php
                                                        }
                                                        ?>
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
<script>

$(function() {
$("#E_Image").change(function () {
	    if(fileExtValidate(this)) {
	    	 if(fileSizeValidate(this)) {
	    	 	showImg(this);
	    	 }	 
	    }    
    });

// File extension validation, Add more extension you want to allow
var validExt = ".png, .gif, .jpeg, .jpg";
function fileExtValidate(fdata) {
 var filePath = fdata.value;
 var getFileExt = filePath.substring(filePath.lastIndexOf('.') + 1).toLowerCase();
 var pos = validExt.indexOf(getFileExt);
 if(pos < 0) {
 	alert("This file is not allowed, please upload valid file.");
 	return false;
  } else {
  	return true;
  }
}

// file size validation
// size in kb
var maxSize = '1024';
function fileSizeValidate(fdata) {
	 if (fdata.files && fdata.files[0]) {
                var fsize = fdata.files[0].size/1024;
                if(fsize > maxSize) {
                	 alert('Maximum file size exceed the limit, Minimum 1 MB');
                	 return false;
                } else {
                	return true;
                }
     }
 }

 // display img preview before upload.
function showImg(fdata) {
        if (fdata.files && fdata.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#output').attr('src', e.target.result);
            }

            reader.readAsDataURL(fdata.files[0]);
        }
    }

	
});
</script>

<script>
	function generateid(str){

		if(str!=""){  
		const d = new Date();
		var year = d.getFullYear();  
		var inc = document.getElementById('emp_jio_id').value;
		var stx = (str.split("=")[0]); 
		var st = (str.split("=")[1]);
		document.getElementById('location_id').value= stx;
		document.getElementById('Emp_id_no').value='JVS/E/'+st+'/'+inc+'/'+year;
	}else{
		document.getElementById('Emp_id_no').value= "";
	}
	} 
</script>




<script>
	function hello(){
	if(document.getElementById('good').checked == true){
	document.getElementById('pa').value = document.getElementById('ca').value;
	document.getElementById('ps').value = document.getElementById('cs').value;
	document.getElementById('pc').value = document.getElementById('cc').value;
	document.getElementById('pp').value = document.getElementById('cp').value;

        var city_id = $('#cc').val();  
        var action = 'get_city';   
        if(city_id != '')   
        {   
            $.ajax({       
                url:"<?php echo base_url('/index.php/getsamecityx')?>",  
                method:"GET",
                data:{city_id:city_id, action:action},  
                dataType:"JSON",
                success:function(data)   
                {        

                    for(var count = 0; count < data.length; count++)
                    {
                        html = '<option value="'+data[count].id+'">'+data[count].city_name+'</option>';
                    }

                    $('#pc').html(html);
                }
            });
        }
        else   
        {
            $('#pc').val('');
        }



	}else{
	document.getElementById('pa').value = "";
	document.getElementById('ps').value = "";
	document.getElementById('pc').value = "";
	document.getElementById('pp').value = "";
	}
}

</script>	
   <script>  
     $(document).ready(function () {

   $('#department').change(function(){ 
        var state_id = $('#department').val();  
        var action = 'get_unit';   
        if(state_id != '')
        {   
            $.ajax({     
                url:"<?php echo base_url('/index.php/getUnit')?>",
                method:"GET",
                data:{state_id:state_id, action:action},  
                dataType:"JSON",
                success:function(data)  
                {        
                    var html = '<option value="">Select Unit</option>';

                    for(var count = 0; count < data.length; count++)
                    {
                        html += '<option value="'+data[count].id+'">'+data[count].name+'</option>';
                    }

                    $('#Unit_Id').html(html);
                }
            });
        }
        else   
        {
            $('#Unit_Id').val('');
        }

    });

    $('#cs').change(function(){ 
        var state_id = $('#cs').val();  
        var action = 'get_city';   
        if(state_id != '')
        {   
            $.ajax({     
                url:"<?php echo base_url('/index.php/getcityx')?>",
                method:"GET",
                data:{state_id:state_id, action:action},  
                dataType:"JSON",
                success:function(data)  
                {        
                    var html = '<option value="">Select City</option>';

                    for(var count = 0; count < data.length; count++)
                    {
                        html += '<option value="'+data[count].id+'">'+data[count].city_name+'</option>';
                    }

                    $('#cc').html(html);
                }
            });
        }
        else   
        {
            $('#cc').val('');
        }

    });  

        $('#ps').change(function(){ 
        var state_id = $('#ps').val();  
        var action = 'get_city';   
        if(state_id != '')
        {   
            $.ajax({     
                url:"<?php echo base_url('/index.php/getcityx')?>",
                method:"GET",
                data:{state_id:state_id, action:action},  
                dataType:"JSON",
                success:function(data)  
                {        
                    var html = '<option value="">Select City</option>';

                    for(var count = 0; count < data.length; count++)
                    {
                        html += '<option value="'+data[count].id+'">'+data[count].city_name+'</option>';
                    }

                    $('#pc').html(html);
                }
            });
        }
        else   
        {
            $('#pc').val('');
        }

    });

        });
    </script>
<script>  
     $(document).ready(function () {

   $('#Unit_Id').change(function(){ 
        var state_id = $('#Unit_Id').val();  
        var action = 'get_Department2';   
        if(state_id != '')
        {   
            $.ajax({     
                url:"<?php echo base_url('/index.php/getDepartment2')?>",
                method:"GET",
                data:{state_id:state_id, action:action},  
                dataType:"JSON",
                success:function(data)  
                {        
                    var html = '<option value="">Select </option>';

                    for(var count = 0; count < data.length; count++)
                    {
                        html += '<option value="'+data[count].id+'">'+data[count].name+'</option>';
                    }

                    $('#Department_Id').html(html);
                }
            });
        }
        else   
        {
            $('#Department_Id').val('');
        }

    });


        });
    </script>
  </body>
</html>