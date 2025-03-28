<!-- brand-logo -->
	<div class="left-side-bar">
		<div class="" style="background: #007bb5; color:#fff; padding:18px 10px;">
			<a href="#">  
				<!-- <img src="<?php echo base_url('public/vendors/images/deskapp-logo.png');?>" alt=""> -->
				<h3 style="color:#fff; font-weight: 500;">JVSM2r Portal</h3>
			</a>
		</div>
		<div class="menu-block customscroll">    
			<?php if($Role=='Admin'){ ?> 
			<div class="sidebar-menu">
				<ul id="accordion-menu"> 
					
						<li>
						<a href="<?php echo base_url('/admin-dashboard');?>" class="dropdown-toggle no-arrow">
							<span class="fa fa-home"></span><span class="mtext">Dashboard</span>
						</a>
					</li>
  					<li>  
						<a href="<?php echo base_url('/project_details');?>" class="dropdown-toggle no-arrow"> 
							<span class="fa fa-file-powerpoint-o"></span><span class="mtext">Project</span>
						</a>
					</li> 
					<li class="dropdown">
						<a href="javascript:;" class="dropdown-toggle">
							<span class="fa fa-map-marker"></span><span class="mtext">Location</span>
						</a>                  
						<ul class="submenu">
							<li><a href="<?php echo base_url('/project-location');?>">Add Location</a></li>
							<li><a href="<?php echo base_url('/main-dashboard');?>">Choose Location</a></li>   
						</ul>     
					</li>
						<li>
						<a href="<?php echo base_url('/get-lead-location');?>" class="dropdown-toggle no-arrow">
							<span class="fa fa-map-marker"></span><span class="mtext">Allot Location to Lead</span>
						</a>
					</li>
					<li>
						<a href="<?php echo base_url('/get-child-pending');?>" class="dropdown-toggle no-arrow">
							<span class="fa fa-rupee"></span><span class="mtext">Payment Status</span>
						</a>
					</li>
					<!-- ======================= -->
					<!-- ================ -->
						<li class="dropdown">
						<a href="javascript:;" class="dropdown-toggle">
							<span class="fa fa-users"></span><span class="mtext">Employee</span>
						</a>                  
						<ul class="submenu">
							<li><a href="<?php echo base_url('/emp_details');?>">Employee Section</a></li>
							<li><a href="<?php echo base_url('/lead-section');?>">Lead</a></li>             
							<li><a href="<?php echo base_url('/consultant-section');?>">Consultant</a></li>   
						</ul>     
					</li>
					<!-- ================ -->

					<!-- ============= -->  
					<!-- <li> 												
						<a href="<?php echo base_url('/consultant-section');?>" class="dropdown-toggle no-arrow"> 
							<span class="fa fa-users"></span><span class="mtext">Consultant/span>
						</a>
					</li>  -->


						<li class="dropdown">
						<a href="javascript:;" class="dropdown-toggle">
							<span class="fa fa-users"></span><span class="mtext">C&Y WD</span>
						</a>                  
						<ul class="submenu">
							<li><a href="<?php echo base_url('/child_details');?>">C&Y WD Section</a></li>
							<li><a href="<?php echo base_url('/print_selected_child_details');?>">Print Selected Column</a></li>    
						</ul>     
					</li>

					<li>  
						<a href="<?php echo base_url('/doc-approval');?>" class="dropdown-toggle no-arrow"> 
							<span class="fa fa-hand-o-right"></span><span class="mtext">Doc Approval</span>
						</a>
					</li>
					<!-- ================ --> 
						<li> 												
						<a href="<?php echo base_url('/daily-monthly-plan-details');?>" class="dropdown-toggle no-arrow"> 
							<span class="fa fa-file-archive-o"></span><span class="mtext">Daily Plan</span>
						</a>
					</li>
					<!-- ================ --> 
					<li class="dropdown"> 
						<a href="javascript:;" class="dropdown-toggle">
							<span class="fa fa-list"></span><span class="mtext">EE Activities</span>
						</a>                  
						<ul class="submenu">
						
							<li><a href="<?php echo base_url('/ee-request-details');?>">EE Activitie Request</a></li> 
							<li><a href="<?php echo base_url('/ee-reporting-other-details');?>">EE Activitie Reports</a></li>
						       
						</ul>     
					</li> 
					<li> 												
						<a href="<?php echo base_url('/extra-expense-details');?>" class="dropdown-toggle no-arrow"> 
							<span class="fa fa-rupee"></span><span class="mtext">Other Expense</span>
						</a>
					</li>
						<li class="dropdown">
						<a href="javascript:;" class="dropdown-toggle">
							<span class="fa fa-file-text-o"></span><span class="mtext">EIEI Reports</span>
						</a>                  
						<ul class="submenu">
							
					<li> 												
						<a href="<?php echo base_url('/baseline-survey-details');?>" class="dropdown-toggle no-arrow"> 
							<span class="fa fa-file-text-o"></span><span class="mtext">Base line survey</span>
						</a> 
					</li>
					
					<li> 												
						<a href="<?php echo base_url('/mis-report-details');?>" class="dropdown-toggle no-arrow"> 
							<span class="fa fa-file-text-o"></span><span class="mtext">MIS Report</span>
						</a> 
					</li>
   
						</ul>    
					</li>
						<li class="dropdown">
						<a href="javascript:;" class="dropdown-toggle">
							<span class="fa fa-file-text-o"></span><span class="mtext">Reports</span>
						</a>                  
						<ul class="submenu">
							<li><a href="<?php echo base_url('/view-progress-details');?>">Progress Reports</a></li>
							<li><a href="<?php echo base_url('/view-daily-monthly-reports');?>">Daily Reports</a></li>
							<li><a href="<?php echo base_url('/view-consultant-reports');?>">Counsultant Reports</a></li> 
							<li><a href="<?php echo base_url('/get-student-report');?>">C&YwD Reports</a></li> 
							<li><a href="<?php echo base_url('/get-all-project-budget-details');?>">Finance Reports</a></li>    
						</ul>    
					</li>
						<li> 												
						<a href="<?php echo base_url('/payment-voucher-details');?>" class="dropdown-toggle no-arrow"> 
							<span class="fa fa-rupee"></span><span class="mtext">Consultant monthly Claim</span>
						</a>                
					</li> 
					<!-- ================ -->
					<li> 												
						<a href="<?php echo base_url('/perti-attendance');?>" class="dropdown-toggle no-arrow"> 
							<span class="fa fa-calendar"></span><span class="mtext">CBR Consultant Attendance</span>
						</a>
					</li>
					<!-- ================ -->   
					<li class="dropdown">
						<a href="javascript:;" class="dropdown-toggle">
							<span class="fa fa-gears"></span><span class="mtext">Setting</span>
						</a>                  
						<ul class="submenu">
							<li><a href="<?php echo base_url('/state');?>">State</a></li> 
							<li><a href="<?php echo base_url('/city');?>">City</a></li>  
							<li><a href="<?php echo base_url('/class');?>">Class</a></li>
							<li><a href="<?php echo base_url('/department');?>">Department</a></li>
							<li><a href="<?php echo base_url('/designation');?>">Designation</a></li>
							<li><a href="<?php echo base_url('/financial');?>">Financial Status</a></li>
							<li><a href="<?php echo base_url('/disability');?>">Disability Type</a></li>
							<li><a href="<?php echo base_url('/budget-head');?>">Budget Head</a></li>
							<li><a href="<?php echo base_url('/budget-sub-head');?>">Budget Sub Head</a></li>
							<li><a href="<?php echo base_url('/intervention');?>">Intervention</a></li>
							<li><a href="<?php echo base_url('/activity');?>">Activity</a></li> 
							<li><a href="<?php echo base_url('/ee-budget-head');?>">EE Activity Head/Budget</a></li>
						    <li><a href="<?php echo base_url('/other-expense-head');?>">Other Expense Head/Budget</a></li>
						</ul>   
					</li>  
						<li> 												
						<a href="<?php echo base_url('/pay-employee-salary');?>" class="dropdown-toggle no-arrow"> 
							<span class="fa fa-rupee"></span><span class="mtext">Manage Salary</span>
						</a>                
					</li> 
					<li> 												
						<a href="<?php echo base_url('/all-forms-formate-download');?>" class="dropdown-toggle no-arrow"> 
							<span class="fa fa-cloud-download"></span><span class="mtext">Download Forms</span>
						</a> 
					</li> 
					<li>  
						<a href="<?php echo base_url('/logout');?>" class="dropdown-toggle no-arrow"> 
							<span class="fa fa-sign-out"></span><span class="mtext">Logout</span>
						</a>
					</li> 
				</ul>
			</div>

		<?php  } ?>
		<!-- End Of Admin Navigation -->
			<?php if($Role=='Consultant'){ ?> 
				<div class="sidebar-menu">
				<ul id="accordion-menu">
				
						<li>
						<a href="<?php echo base_url('/employee-dashboard');?>" class="dropdown-toggle no-arrow">
							<span class="fa fa-home"></span><span class="mtext">Dashboard</span>
						</a>
					</li>
				
					<!-- ============= -->    
					<li class="dropdown">
						<a href="javascript:;" class="dropdown-toggle">
							<span class="fa fa-users"></span><span class="mtext">C&Y WD</span>
						</a>                  
						<ul class="submenu">
							<li><a href="<?php echo base_url('/child_details');?>">C&Y WD Section</a></li>
							<li><a href="<?php echo base_url('/print_selected_child_details');?>">Print Selected Column</a></li>    
						</ul>     
					</li>
					<li> 												
						<a href="<?php echo base_url('/daily-monthly-plan-details');?>" class="dropdown-toggle no-arrow"> 
							<span class="fa fa-file-archive-o"></span><span class="mtext">My Plan</span>
						</a>
					</li>
 
					<li> 												
						<a href="<?php echo base_url('/view-daily-monthly-reports');?>" class="dropdown-toggle no-arrow"> 
							<span class="fa fa-file-archive-o"></span><span class="mtext">My Reports</span>
						</a>
					</li>

					<li class="dropdown"> 
						<a href="javascript:;" class="dropdown-toggle">
							<span class="fa fa-list"></span><span class="mtext">EE Activities</span>
						</a>                  
						<ul class="submenu">
						<li><a href="<?php echo base_url('/ee-request-details');?>">EE Activitie Request</a></li> 
				<li><a href="<?php echo base_url('/ee-reporting-other-details');?>">EE Activitie Reports</a></li>
						</ul>    
					</li>  
					<li> 												
						<a href="<?php echo base_url('/extra-expense-details');?>" class="dropdown-toggle no-arrow"> 
							<span class="fa fa-rupee"></span><span class="mtext">Other Expense</span>
						</a>
					</li>
						<!-- <li class="dropdown">
						<a href="javascript:;" class="dropdown-toggle">
							<span class="fa fa-file-text-o"></span><span class="mtext">Reports</span>
						</a>                  
						<ul class="submenu">
							<li><a href="<?php echo base_url('/view-progress-details');?>">Progress Reports</a></li>
						<li><a href="<?php echo base_url('/view-daily-monthly-reports');?>">Daily Reports</a></li>
						<li><a href="<?php echo base_url('/view-consultant-reports');?>">Counsultant Reports</a></li> 
						<li><a href="<?php echo base_url('/get-student-report');?>">C&YwD Reports</a></li> 
						<li><a href="<?php echo base_url('/get-finance-report');?>">Finance Reports</a></li>     
						</ul>    
					</li>  -->
						<li> 												
						<a href="<?php echo base_url('/payment-voucher-details');?>" class="dropdown-toggle no-arrow"> 
							<span class="fa fa-rupee"></span><span class="mtext">Consultant monthly Claim</span>
						</a>                
					</li>
					<li> 												
						<a href="<?php echo base_url('/perti-attendance');?>" class="dropdown-toggle no-arrow"> 
							<span class="fa fa-calendar"></span><span class="mtext">My Attendance</span>
						</a>
					</li> 
					<li> 												
						<a href="<?php echo base_url('/all-forms-formate-download');?>" class="dropdown-toggle no-arrow"> 
							<span class="fa fa-cloud-download"></span><span class="mtext">Download Forms</span>
						</a> 
					</li>
					<!-- ================ --> 
						 <li> 												
						<a href="<?php echo base_url('/view-progress-details');?>" class="dropdown-toggle no-arrow"> 
							<span class="fa fa-file-text-o"></span><span class="mtext">View Progress Reports</span>
						</a> 
					</li> 
						  
					<li>
						<a href="<?php echo base_url('/logout');?>" class="dropdown-toggle no-arrow">
							<span class="fa fa-sign-out"></span><span class="mtext">Logout</span>
						</a>
					</li>
				</ul>
			</div>
			<?php } ?>	
			<!-- End Of Consultant Navigation -->
			<?php if($Role=='Lead'){ ?>
				<div class="sidebar-menu">
				<ul id="accordion-menu">
					
						<li>
						<a href="<?php echo base_url('/lead-dashboard');?>" class="dropdown-toggle no-arrow">
							<span class="fa fa-home"></span><span class="mtext">Dashboard</span>
						</a>
					</li>
  				  
					
					<!-- ============= -->
						<li>  
						<a href="<?php echo base_url('/project_details');?>" class="dropdown-toggle no-arrow"> 
							<span class="fa fa-file-powerpoint-o"></span><span class="mtext">Project</span>
						</a>
					</li>

						<li>  
						<a href="<?php echo base_url('/main-dashboard');?>" class="dropdown-toggle no-arrow"> 
							<span class="fa fa-map-marker"></span><span class="mtext">Choose Location</span>
						</a>
					</li>

						<!-- ================ -->
					 <li> 												
						<a href="<?php echo base_url('/consultant-section');?>" class="dropdown-toggle no-arrow"> 
							<span class="fa fa-users"></span><span class="mtext">Consultant</span>
						</a>
					</li>    
					<!-- ================ -->     
						<li class="dropdown">
						<a href="javascript:;" class="dropdown-toggle">
							<span class="fa fa-users"></span><span class="mtext">C&Y WD</span>
						</a>                  
						<ul class="submenu">
							<li><a href="<?php echo base_url('/child_details');?>">C&Y WD Section</a></li>
							<li><a href="<?php echo base_url('/print_selected_child_details');?>">Print Selected Column</a></li>    
						</ul>     
					</li>
						<li>  
						<a href="<?php echo base_url('/doc-approval');?>" class="dropdown-toggle no-arrow"> 
							<span class="fa fa-hand-o-right"></span><span class="mtext">Doc Approval</span>
						</a>
					</li>
					<li> 												
						<a href="<?php echo base_url('/daily-monthly-plan-details');?>" class="dropdown-toggle no-arrow"> 
							<span class="fa fa-file-archive-o"></span><span class="mtext">Daily Plan</span>
						</a>
					</li>
					<li class="dropdown">
						<a href="javascript:;" class="dropdown-toggle">
							<span class="fa fa-list"></span><span class="mtext">EE Activities</span>
						</a>                  
						<ul class="submenu">
						
							<li><a href="<?php echo base_url('/ee-request-details');?>">EE Activitie Request</a></li>  
						   <li><a href="<?php echo base_url('/ee-reporting-other-details');?>">EE Activitie Reports</a></li>
						</ul>    
					</li>
					<li> 												
						<a href="<?php echo base_url('/extra-expense-details');?>" class="dropdown-toggle no-arrow"> 
							<span class="fa fa-rupee"></span><span class="mtext">Other Expense</span>
						</a>
					</li> 
						<li class="dropdown">
						<a href="javascript:;" class="dropdown-toggle">
							<span class="fa fa-file-text-o"></span><span class="mtext">Reports</span>
						</a>                  
						<ul class="submenu">
							<li><a href="<?php echo base_url('/view-progress-details');?>">Progress Reports</a></li>
						<li><a href="<?php echo base_url('/view-daily-monthly-reports');?>">Daily Reports</a></li>
						<li><a href="<?php echo base_url('/get-student-report');?>">C&YwD Reports</a></li>
						<li><a href="<?php echo base_url('/get-finance-report');?>">Finance Reports</a></li>      
						</ul>    
					</li> 
						<li> 												
						<a href="<?php echo base_url('/payment-voucher-details');?>" class="dropdown-toggle no-arrow"> 
							<span class="fa fa-rupee"></span><span class="mtext">Consultant monthly Claim</span>
						</a>                
					</li>
					<li class="dropdown">
						<a href="javascript:;" class="dropdown-toggle">
							<span class="fa fa-calendar"></span><span class="mtext">Attendance</span>
						</a>                  
						<ul class="submenu">
							<li><a href="<?php echo base_url('/perti-attendance');?>">My Attendance</a></li>
							<li><a href="<?php echo base_url('/employees-attendancex');?>">CBR Consultant Attendance</a></li>  
						       
						</ul>      
					</li>
						 <li class="dropdown">
						<a href="javascript:;" class="dropdown-toggle">
							<span class="fa fa-gears"></span><span class="mtext">Setting</span>
						</a>                  
						<ul class="submenu">
								<li><a href="<?php echo base_url('/ee-budget-head');?>">EE Activity Head/Budget</a></li>
						    <li><a href="<?php echo base_url('/other-expense-head');?>">Other Expense Head/Budget</a></li>            
						</ul>   
					</li> 
					<!--	<li> 												-->
					<!--	<a href="<?php echo base_url('/pay-employee-salary');?>" class="dropdown-toggle no-arrow"> -->
					<!--		<span class="fa fa-rupee"></span><span class="mtext">Manage Salary</span>-->
					<!--	</a>                -->
					<!--</li>-->
					<li> 												
						<a href="<?php echo base_url('/all-forms-formate-download');?>" class="dropdown-toggle no-arrow"> 
							<span class="fa fa-cloud-download"></span><span class="mtext">Download Forms</span>
						</a> 
					</li>
					<!-- ================ -->   
					<li>
						<a href="<?php echo base_url('/logout');?>" class="dropdown-toggle no-arrow">
							<span class="fa fa-sign-out"></span><span class="mtext">Logout</span>
						</a>
					</li>
				</ul>
			</div>
			<?php } ?>	
			<!-- End Of Lead Navigation -->
					<?php if($Role=='HOD'){ ?>  
				<div class="sidebar-menu">
				<ul id="accordion-menu">
					
						<li>
						<a href="<?php echo base_url('/admin-dashboard');?>" class="dropdown-toggle no-arrow">
							<span class="fa fa-home"></span><span class="mtext">Dashboard</span>
						</a>
					</li>
					<li>  
						<a href="<?php echo base_url('/project_details');?>" class="dropdown-toggle no-arrow"> 
							<span class="fa fa-file-powerpoint-o"></span><span class="mtext">Project</span>
						</a>
					</li>
					<li>
						<a href="<?php echo base_url('/main-dashboard');?>" class="dropdown-toggle no-arrow">
							<span class="fa fa-map-marker"></span><span class="mtext">Choose Location</span>
						</a>
					</li>
						<li>
						<a href="<?php echo base_url('/get-lead-location');?>" class="dropdown-toggle no-arrow">
							<span class="fa fa-map-marker"></span><span class="mtext">Allot Location to Lead</span>
						</a>
					</li>
					<li>
						<a href="<?php echo base_url('/get-child-pending');?>" class="dropdown-toggle no-arrow">
							<span class="fa fa-rupee"></span><span class="mtext">Payment Status</span>
						</a>
					</li>

						<!-- ================ -->
						<li class="dropdown">
						<a href="javascript:;" class="dropdown-toggle">
							<span class="fa fa-users"></span><span class="mtext">Employee</span>
						</a>                  
						<ul class="submenu">
							<!-- <li><a href="<?php echo base_url('/emp_details');?>">Employee Section</a></li> -->
							<li><a href="<?php echo base_url('/lead-section');?>">Lead</a></li>
							<li><a href="<?php echo base_url('/consultant-section');?>">Consultant</a></li>    
						</ul>     
					</li>
					<!-- ================ --> 
					<!-- ============= -->    
						<li class="dropdown">
						<a href="javascript:;" class="dropdown-toggle">
							<span class="fa fa-users"></span><span class="mtext">C&Y WD</span>
						</a>                  
						<ul class="submenu">
							<li><a href="<?php echo base_url('/child_details');?>">C&Y WD Section</a></li>
							<li><a href="<?php echo base_url('/print_selected_child_details');?>">Print Selected Column</a></li>    
						</ul>     
					</li>
						<li>  
						<a href="<?php echo base_url('/doc-approval');?>" class="dropdown-toggle no-arrow"> 
							<span class="fa fa-hand-o-right"></span><span class="mtext">Doc Approval</span>
						</a>
					</li>
					<li> 												
						<a href="<?php echo base_url('/daily-monthly-plan-details');?>" class="dropdown-toggle no-arrow"> 
							<span class="fa fa-file-archive-o"></span><span class="mtext">Daily Plan</span>
						</a>
					</li>
					<li class="dropdown">
						<a href="javascript:;" class="dropdown-toggle">
							<span class="fa fa-list"></span><span class="mtext">EE Activities</span>
						</a>                  
						<ul class="submenu">
							
							<li><a href="<?php echo base_url('/ee-request-details');?>">EE Activitie Request</a></li>  
						    <li><a href="<?php echo base_url('/ee-reporting-other-details');?>">EE Activitie Reports</a></li>
						</ul>    
					</li>
					<li> 												
						<a href="<?php echo base_url('/extra-expense-details');?>" class="dropdown-toggle no-arrow"> 
							<span class="fa fa-rupee"></span><span class="mtext">Other Expense</span>
						</a>
					</li> 
						<li class="dropdown">
						<a href="javascript:;" class="dropdown-toggle">
							<span class="fa fa-file-text-o"></span><span class="mtext">Reports</span>
						</a>                  
						<ul class="submenu">
							<li><a href="<?php echo base_url('/view-progress-details');?>">Progress Reports</a></li>
						<li><a href="<?php echo base_url('/view-daily-monthly-reports');?>">Daily Reports</a></li>
						<li><a href="<?php echo base_url('/get-student-report');?>">C&YwD Reports</a></li>
						<li><a href="<?php echo base_url('/get-finance-report');?>">Finance Reports</a></li>      
						</ul>    
					</li> 
						<li> 												
						<a href="<?php echo base_url('/payment-voucher-details');?>" class="dropdown-toggle no-arrow"> 
							<span class="fa fa-rupee"></span><span class="mtext">Consultant monthly Claim</span>
						</a>                
					</li>
					<li class="dropdown">
						<a href="javascript:;" class="dropdown-toggle">
							<span class="fa fa-calendar"></span><span class="mtext">Attendance</span>
						</a>                  
						<ul class="submenu">
							<li><a href="<?php echo base_url('/perti-attendance');?>">My Attendance</a></li>
							<li><a href="<?php echo base_url('/all-emp-attendance');?>">CBR Consultant Attendance</a></li>  
						       
						</ul>      
					</li>
						<li class="dropdown">
						<a href="javascript:;" class="dropdown-toggle">
							<span class="fa fa-gears"></span><span class="mtext">Setting</span>
						</a>                  
						<ul class="submenu">
							<li><a href="<?php echo base_url('/activity');?>">Activity</a></li>
							<li><a href="<?php echo base_url('/ee-budget-head');?>">EE Activity Head/Budget</a></li>              
						</ul>   
					</li>
						<li> 												
						<a href="<?php echo base_url('/pay-employee-salary');?>" class="dropdown-toggle no-arrow"> 
							<span class="fa fa-rupee"></span><span class="mtext">Manage Salary</span>
						</a>                
					</li>
					<li> 												
						<a href="<?php echo base_url('/all-forms-formate-download');?>" class="dropdown-toggle no-arrow"> 
							<span class="fa fa-cloud-download"></span><span class="mtext">Download Forms</span>
						</a> 
					</li>
					<!-- ================ -->    
					<li>
						<a href="<?php echo base_url('/logout');?>" class="dropdown-toggle no-arrow">
							<span class="fa fa-sign-out"></span><span class="mtext">Logout</span>
						</a>
					</li>
				</ul>
			</div>
			<?php } ?>	
			<!-- HOD Navigation End -->
					<?php if($Role=='Finance'){ ?>
				<div class="sidebar-menu">
				<ul id="accordion-menu">
					
						<li>
						<a href="<?php echo base_url('/admin-dashboard');?>" class="dropdown-toggle no-arrow">
							<span class="fa fa-home"></span><span class="mtext">Dashboard</span>
						</a>
					</li>
  				  
						<li>
						<a href="<?php echo base_url('/main-dashboard');?>" class="dropdown-toggle no-arrow">
							<span class="fa fa-map-marker"></span><span class="mtext">Choose Location</span>
						</a>
					</li>
					<li>
						<a href="<?php echo base_url('/get-child-pending');?>" class="dropdown-toggle no-arrow">
							<span class="fa fa-rupee"></span><span class="mtext">Payment Status</span>
						</a>
					</li>
					<!-- ============= -->    
						<li class="dropdown">
						<a href="javascript:;" class="dropdown-toggle">
							<span class="fa fa-users"></span><span class="mtext">C&Y WD</span>
						</a>                  
						<ul class="submenu">
							<li><a href="<?php echo base_url('/child_details');?>">C&Y WD Section</a></li>
							<li><a href="<?php echo base_url('/print_selected_child_details');?>">Print Selected Column</a></li>    
						</ul>     
					</li>
						<li>  
						<a href="<?php echo base_url('/doc-approval');?>" class="dropdown-toggle no-arrow"> 
							<span class="fa fa-hand-o-right"></span><span class="mtext">Approved Doc</span>
						</a>
					</li>
					<li> 												
						<a href="<?php echo base_url('/daily-monthly-plan-details');?>" class="dropdown-toggle no-arrow"> 
							<span class="fa fa-file-archive-o"></span><span class="mtext">Daily Plan</span>
						</a>
					</li> 
					<li class="dropdown">
						<a href="javascript:;" class="dropdown-toggle">
							<span class="fa fa-list"></span><span class="mtext">EE Activities</span>
						</a>                  
						<ul class="submenu">
							
							<li><a href="<?php echo base_url('/ee-request-details');?>">EE Activitie Request</a></li>  
						    <li><a href="<?php echo base_url('/ee-reporting-other-details');?>">EE Activitie Reports</a></li>
						</ul>    
					</li>
					<li> 												
						<a href="<?php echo base_url('/extra-expense-details');?>" class="dropdown-toggle no-arrow"> 
							<span class="fa fa-rupee"></span><span class="mtext">Other Expense</span>
						</a>
					</li> 
						<li class="dropdown">
						<a href="javascript:;" class="dropdown-toggle">
							<span class="fa fa-file-text-o"></span><span class="mtext">Reports</span>
						</a>                  
						<ul class="submenu">
							<li><a href="<?php echo base_url('/view-progress-details');?>">Progress Reports</a></li>
						<li><a href="<?php echo base_url('/view-daily-monthly-reports');?>">Daily Reports</a></li>
						<li><a href="<?php echo base_url('/get-student-report');?>">C&YwD Reports</a></li> 
						<li><a href="<?php echo base_url('/get-finance-report');?>">Finance Reports</a></li>     
						</ul>    
					</li> 
						<li class="dropdown">
						<a href="javascript:;" class="dropdown-toggle">
							<span class="fa fa-calendar"></span><span class="mtext">Attendance</span>
						</a>                  
						<ul class="submenu">
							<li><a href="<?php echo base_url('/perti-attendance');?>">My Attendance</a></li>
							<li><a href="<?php echo base_url('/all-emp-attendance-hrmfnc');?>">CBR Consultant Attendance</a></li>  
						       
						</ul>      
					</li>
						<li> 												
						<a href="<?php echo base_url('/payment-voucher-details');?>" class="dropdown-toggle no-arrow"> 
							<span class="fa fa-rupee"></span><span class="mtext">Consultant monthly Claim</span>
						</a>                
					</li>
					<li> 												
						<a href="<?php echo base_url('/pay-employee-salary');?>" class="dropdown-toggle no-arrow"> 
							<span class="fa fa-rupee"></span><span class="mtext">Manage Salary</span>
						</a>                
					</li>  
					<li> 												
						<a href="<?php echo base_url('/all-forms-formate-download');?>" class="dropdown-toggle no-arrow"> 
							<span class="fa fa-cloud-download"></span><span class="mtext">Download Forms</span>
						</a> 
					</li>  
					<!-- ================ -->   
					<li>
						<a href="<?php echo base_url('/logout');?>" class="dropdown-toggle no-arrow">
							<span class="fa fa-sign-out"></span><span class="mtext">Logout</span>
						</a>
					</li>
				</ul>          
			</div>
			<?php } ?>	
			<!-- Finance Navigation End -->
					<?php if($Role=='HRMS'){ ?>
			<div class="sidebar-menu">
				<ul id="accordion-menu">
					
						<li>
						<a href="<?php echo base_url('/hrms-dashboard');?>" class="dropdown-toggle no-arrow">
							<span class="fa fa-map-marker"></span><span class="mtext">Dashboard</span>
						</a>
					</li>
						<li>
						<a href="<?php echo base_url('/main-dashboard');?>" class="dropdown-toggle no-arrow">
							<span class="fa fa-home"></span><span class="mtext">Choose Location</span>
						</a>
					</li>
  					<!-- <li>  
						<a href="<?php echo base_url('/project_details');?>" class="dropdown-toggle no-arrow"> 
							<span class="fa fa-file-powerpoint-o"></span><span class="mtext">Project</span>
						</a>
					</li>  -->
						<!-- ================ -->
						<li class="dropdown">
						<a href="javascript:;" class="dropdown-toggle">
							<span class="fa fa-users"></span><span class="mtext">Employee</span>
						</a>                  
						<ul class="submenu">
							<li><a href="<?php echo base_url('/emp_details');?>">Employee Section</a></li>
							<li><a href="<?php echo base_url('/consultant-section');?>">Consultant</a></li>    
						</ul>     
					</li>
						<li class="dropdown">
						<a href="javascript:;" class="dropdown-toggle">
							<span class="fa fa-file-text-o"></span><span class="mtext">Reports</span>
						</a>                  
						<ul class="submenu">
							<li><a href="<?php echo base_url('/view-progress-details');?>">Progress Reports</a></li>
						<li><a href="<?php echo base_url('/view-daily-monthly-reports');?>">Daily Reports</a></li>
						<li><a href="<?php echo base_url('/get-student-report');?>">C&YwD Reports</a></li>
						<li><a href="<?php echo base_url('/get-finance-report');?>">Finance Reports</a></li>      
						</ul>    
					</li> 
					<!-- ================ -->
					<li class="dropdown">
						<a href="javascript:;" class="dropdown-toggle">
							<span class="fa fa-calendar"></span><span class="mtext">Attendance</span>
						</a>                  
						<ul class="submenu">
							<li><a href="<?php echo base_url('/perti-attendance');?>">My Attendance</a></li>
							<li><a href="<?php echo base_url('/all-emp-attendance-hrmfnc');?>">CBR Consultant Attendance</a></li>  
						       
						</ul>      
					</li>
					<!-- ============= -->  
					<!-- 	<li> 												
						<a href="<?php echo base_url('/salary-index');?>" class="dropdown-toggle no-arrow"> 
							<span class="fa fa-rupee"></span><span class="mtext">Manage Salary</span>
						</a>                
					</li> -->
						 <li> 												
						<a href="<?php echo base_url('/all-forms-formate-download');?>" class="dropdown-toggle no-arrow"> 
							<span class="fa fa-cloud-download"></span><span class="mtext">Download Forms</span>
						</a> 
					</li>
					<li>  
						<a href="<?php echo base_url('/logout');?>" class="dropdown-toggle no-arrow"> 
							<span class="fa fa-sign-out"></span><span class="mtext">Logout</span>
						</a>
					</li> 
				</ul>
			</div>

		<?php  } ?>
			<!-- HRMS Navigation End -->
			<?php if($Role=='EI'){ ?>
			<div class="sidebar-menu">
				<ul id="accordion-menu">
					
						<li>
						<a href="<?php echo base_url('/ei-dashboard');?>" class="dropdown-toggle no-arrow">
							<span class="fa fa-map-marker"></span><span class="mtext">Dashboard</span>
						</a>
					</li>
						
  				
					<li> 												
						<a href="<?php echo base_url('/baseline-survey-details');?>" class="dropdown-toggle no-arrow"> 
							<span class="fa fa-file-text-o"></span><span class="mtext">Base line survey</span>
						</a> 
					</li>
					
					<li> 												
						<a href="<?php echo base_url('/mis-report-details');?>" class="dropdown-toggle no-arrow"> 
							<span class="fa fa-file-text-o"></span><span class="mtext">MIS Report</span>
						</a> 
					</li>

					<li>  
						<a href="<?php echo base_url('/logout');?>" class="dropdown-toggle no-arrow"> 
							<span class="fa fa-sign-out"></span><span class="mtext">Logout</span>
						</a>
					</li> 
				</ul>
			</div>

		<?php  } ?>
		
		
		
		
		
			<!-- HRMS Navigation End -->
			<?php if($Role=='EIView'){ ?>
			<div class="sidebar-menu">
				<ul id="accordion-menu">
					
						<li>
						<a href="<?php echo base_url('/ei-dashboard');?>" class="dropdown-toggle no-arrow">
							<span class="fa fa-map-marker"></span><span class="mtext">Dashboard</span>
						</a>
					</li>
						
  				
					<li> 												
						<a href="<?php echo base_url('/baseline-survey-details');?>" class="dropdown-toggle no-arrow"> 
							<span class="fa fa-file-text-o"></span><span class="mtext">Base line survey</span>
						</a> 
					</li>
					
					<li> 												
						<a href="<?php echo base_url('/mis-report-details');?>" class="dropdown-toggle no-arrow"> 
							<span class="fa fa-file-text-o"></span><span class="mtext">MIS Report</span>
						</a> 
					</li>

					<li>  
						<a href="<?php echo base_url('/logout');?>" class="dropdown-toggle no-arrow"> 
							<span class="fa fa-sign-out"></span><span class="mtext">Logout</span>
						</a>
					</li> 
				</ul>
			</div>

		<?php  } ?>
			<!-- EI Navigation End -->
		</div>
	</div>
