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
$active = $session->get("active");   
$gstin = $session->get("gstin"); 
$expirydate = $session->get("expirydate"); 
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
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<title>Supplier Relationship Management</title>
<meta name="author" content="Ashrisha IT Solutions">
<meta name="description" content="">
<meta name="keywords" content="">

<link href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" rel="stylesheet">
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://afeld.github.io/emoji-css/emoji.css" rel="stylesheet"> <!--Totally optional :) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.bundle.min.js" integrity="sha256-xKeoJ50pzbUGkpQxDYHD7o7hxe0LaOGeguUidbq6vis=" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://unpkg.com/@themesberg/flowbite@1.2.0/dist/flowbite.min.css" />
<style>
    body{
        background : rgb(31 41 55);
    }
</style>