<?php
   // error_reporting(0); 
   $session = session();
   $emp_id = $session->get("emp_id");
   $name = $session->get("name");
   $email = $session->get("email");
   $contact = $session->get("contact");
   $Role = $session->get("Role");  
   $Roll_id = $session->get("Roll_id");        
   $super = $session->get("super"); 
   $project_id = $session->get("project_id");
   $last_id = $session->get("last_id");
   $login_time = $session->get("login_time");            
   $teamleader = $session->get("teamleader"); 
   $name = $session->get("name");
   $location_tracker = $session->get("location_tracker");    
   $compeny_id = $session->get("compeny_id"); 
   $result = $session->get();  
   if($session->has('Sesssion_start_Date')) {
      $Sesssion_start_Date = $result['Sesssion_start_Date']; 
   } else {
      $Sesssion_start_Date = ""; 
   }
   if($session->has('Sesssion_end_Date')) {
      $Sesssion_end_Date = $result['Sesssion_end_Date']; 
   } else {
      $Sesssion_end_Date = ""; 
   }   
?>
<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Bill Management</title>
<!-- base:css -->
<link rel="stylesheet" href="<?php echo base_url('public/css/style.css');?>">
<link rel="stylesheet" href="<?php echo base_url('public/css/styles.css');?>">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/7.4.47/css/materialdesignicons.min.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<style>
   .List {
   background: #004784;
   
   color:white;
   font-weight: bold;   
   }
   
   .nav-links {
   color: white;
   /* padding: 17px 32px; */
   /* line-height: 1;*/
   font-weight: 600;
/*   text-align: center;*/
   text-decoration: none;
   }
   .submenu2 {
   /*   top: 36px !important;*/
   background: #fff;
   }
   .span {
   font-weight: bold;
   cursor: pointer;
   }
   .select2-container .select2-selection--single{
      height: 45px!important;
   }
   .select2-container--default .select2-selection--single .select2-selection__rendered{
      line-height: 40px!important;
   }
   .select2-container--default .select2-selection--single .select2-selection__arrow{
      height: 43px!important;
   }
   .horizontal-menu .bottom-navbar .page-navigation > .nav-item .submenu ul li a{
/*      text-align: center;*/
   }
   @media (min-width: 780px){
      .horizontal-menu .bottom-navbar .page-navigation > .nav-item:not(.mega-menu) .submenu{
         top: 36px;
      }
   }
</style>
<style>
   .dropbtn {
   /*background-color: #04AA6D;
   color: white;
   padding: 16px;
   font-size: 16px;*/
   border: none;
   }
   .dropdown {
   display: inline-block;
   }
   .dropdown-content {
   display: none;
   background-color: #f1f1f1;
   min-width: 160px;
   box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
   z-index: 1;
   }
   .dropdown-content a {
   color: black;
   padding: 12px 16px;
   text-decoration: none;
   display: block;
   }
   .dropdown-content a:hover {background-color: #ddd;}
   .dropdown:hover .dropdown-content {display: block;}
   /*.dropdown:hover .dropbtn {background-color: #3e8e41;*/}

   .filterserach{
       padding: 0.995rem 1.375rem !important;
       background: white !important;
       outline: 0 !important;
       width: 100% !important;
   }
</style>