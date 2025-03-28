<?php

namespace App\Controllers;  
use CodeIgniter\Controller;  
                                                              
class PaginationController extends BaseController      
{
    private $db;
    public function __construct()
    {
      $this->db = db_connect(); // Loading database
    } 
    //=======================Daily Report Start===================
    public function pdx()
    { 
        $session = \Config\Services::session();
        $result = $session->get();    
        $pdn = $result['pdn']+50;
        
        $session->set(["pdn" =>$pdn]);
        return redirect('view-daily-monthly-reports'); 
    }
    public function pdxm()
    {                        
        $session = \Config\Services::session();
        $result = $session->get();    
        $pdn = $result['pdn']-50; 
        
        $session->set(["pdn" =>$pdn]);
        return redirect('view-daily-monthly-reports'); 
    }
    //=======================Daily Report End===================

    //=======================Style Creater Details start================= 
    public function cdx()
    { 
        $session = \Config\Services::session();
        $result = $session->get();    
        $cdn = $result['cdn']+20;
        
        $session->set(["cdn" =>$cdn]);
        return redirect('view_create_style'); 
    }
    public function cdxm()
    {                        
        $session = \Config\Services::session();
        $result = $session->get();    
        $cdn = $result['cdn']-20; 
        
        $session->set(["cdn" =>$cdn]);
        return redirect('view_create_style'); 
    }
    //=======================Style Creater Details End================= 

    //=======================Employee/UER Details start================= 
    public function edx()
    { 
        $session = \Config\Services::session();
        $result = $session->get();    
        $edn = $result['edn']+10;
        
        $session->set(["edn" =>$edn]);
        return redirect('user_details'); 
    }
    

    public function edxm()
    {                        
        $session = \Config\Services::session();
        $result = $session->get();    
        $edn = $result['edn']-10; 
        
        $session->set(["edn" =>$edn]);
        return redirect('user_details'); 
    }
    //=======================Employee Details End================= 
    //=======================view_bill_register Details start================= 
    public function ddx()
    { 
        $session = \Config\Services::session();
        $result = $session->get();    
        $ddn = $result['ddn']+20;
        
        $session->set(["ddn" =>$ddn]);
        return redirect('view_bill_register'); 
    }
    public function ddxm()
    {                        
        $session = \Config\Services::session();
        $result = $session->get();    
        $ddn = $result['ddn']-20; 
        
        $session->set(["ddn" =>$ddn]);
        return redirect('view_bill_register'); 
    }
    //=======================view_bill_register Details End================= 
    //=======================view_pending_bill_registers tart================= 
    public function pdvx()
    { 
        $session = \Config\Services::session();
        $result = $session->get();    
        $pdv = $result['pdv']+10;
        
        $session->set(["pdv" =>$pdv]);
        return redirect('view_pending_bill_register'); 
    }
    public function pdvxm()
    {                        
        $session = \Config\Services::session();
        $result = $session->get();    
        $pdv = $result['pdv']-10; 
        
        $session->set(["pdv" =>$pdv]);
        return redirect('view_pending_bill_register'); 
    }
    //=======================view_bill_register End=================
    //=======================All_Upload_Uid Details start================= 
    public function bbsx()
    { 
        $session = \Config\Services::session();
        $result = $session->get();    
        $bbs = $result['bbs']+10;
        $session->set(["bbs" =>$bbs]);
        return redirect('All_Upload_Uid'); 
    }
    public function bbsxm()
    {                        
        $session = \Config\Services::session();
        $result = $session->get();    
        $bbs = $result['bbs']-10; 
        $session->set(["bbs" =>$bbs]);
        return redirect('All_Upload_Uid'); 
    }
    //=======================All_Upload_Uid Details End================= 
    //=======================Mis Details start================= 
    public function mbsx()
    { 
        $session = \Config\Services::session();
        $result = $session->get();    
        $mbs = $result['mbs']+50;
        $session->set(["mbs" =>$mbs]);
        return redirect('mis-report-details'); 
    }
    public function mbsxm()
    {                        
        $session = \Config\Services::session();
        $result = $session->get();    
        $mbs = $result['mbs']-50; 
        $session->set(["mbs" =>$mbs]);
        return redirect('mis-report-details'); 
    }
    //=======================Mis Details End================= 
    //=======================DocApproval Details start================= 
    public function dad()
    { 
        $session = \Config\Services::session();
        $result = $session->get();    
        $dxd = $result['dxd']+50;
        $session->set(["dxd" =>$dxd]);
        return redirect('doc-approval'); 
    }
    public function dadm()
    {                        
        $session = \Config\Services::session();
        $result = $session->get();    
        $dxd = $result['dxd']-50; 
        $session->set(["dxd" =>$dxd]);
        return redirect('doc-approval'); 
    }
    //=======================DocApproval Details End================= 
    //=======================pageination _mapping start================= 
    public function next_mapping()
    { 
        if (isset($_GET["Satus"])) {
            $Satus = $_GET["Satus"];
            $session = \Config\Services::session();
            $result = $session->get();    
            $pagelist_mapping = $result['pagelist_mapping']+50;
            $session->set(["pagelist_mapping" =>$pagelist_mapping]);
            return redirect()->to('all_bill_mapping_list?Satus='.$Satus); 
        } else {
            $Satus = "";
            $session = \Config\Services::session();
            $result = $session->get();    
            $pagelist_mapping = $result['pagelist_mapping']+50;
            $session->set(["pagelist_mapping" =>$pagelist_mapping]);
            return redirect('all_bill_mapping_list'); 
        }
        
    }

    public function previous_mapping()
    {        
        if (isset($_GET["Satus"])) {
            $Satus = $_GET["Satus"];
            $session = \Config\Services::session();
            $result = $session->get();    
            $pagelist_mapping = $result['pagelist_mapping']-50; 
            $session->set(["pagelist_mapping" =>$pagelist_mapping]);
            return redirect()->to('all_bill_mapping_list?Satus='.$Satus); 
        } else {
            $Satus = "";
            $session = \Config\Services::session();
            $result = $session->get();    
            $pagelist_mapping = $result['pagelist_mapping']-50; 
            $session->set(["pagelist_mapping" =>$pagelist_mapping]);
            return redirect('all_bill_mapping_list'); 
        }                
        
    }
    //=======================pageination_mapping End================= 
    //=======================Clear Bill pagination start================= 
    public function next_clearbill()
    { 
        if (isset($_GET["Satus"])) {
            $Satus = $_GET["Satus"];
            $session = \Config\Services::session();
            $result = $session->get();    
            $pagelist_clearbill = $result['pagelist_clearbill']+50;
            $session->set(["pagelist_clearbill" =>$pagelist_clearbill]);
            return redirect('all_Clear_Bill_Form_list?Satus='.$Satus); 
        } else {
            $Satus = "";
            $session = \Config\Services::session();
            $result = $session->get();    
            $pagelist_clearbill = $result['pagelist_clearbill']+50;
            $session->set(["pagelist_clearbill" =>$pagelist_clearbill]);
            return redirect()->to('all_bill_mapping_list?Satus='.$Satus); 
        }                
        
    }

    public function previous_clearbill()
    {      
        if (isset($_GET["Satus"])) {
            $Satus = $_GET["Satus"];
            $session = \Config\Services::session();
            $result = $session->get();    
            $pagelist_clearbill = $result['pagelist_clearbill']-50; 
            $session->set(["pagelist_clearbill" =>$pagelist_clearbill]);
            return redirect('all_Clear_Bill_Form_list?Satus='.$Satus); 
        } else {
            $Satus = "";
            $session = \Config\Services::session();
            $result = $session->get();    
            $pagelist_clearbill = $result['pagelist_clearbill']-50; 
            $session->set(["pagelist_clearbill" =>$pagelist_clearbill]);
            return redirect('all_Clear_Bill_Form_list'); 
        }                   

    }

    //=======================Clear Bill pagination  End================= 
    //=======================ErpStystem pagination start================= 
    public function next_erpStystem()
    { 
        $session = \Config\Services::session();
        $result = $session->get();    
        $pagelist_erpStystem = $result['pagelist_erpStystem']+25;
        $session->set(["pagelist_erpStystem" =>$pagelist_erpStystem]);
        return redirect('all_erpStystem_list'); 
    }
    public function previous_erpStystem()
    {                        
        $session = \Config\Services::session();
        $result = $session->get();    
        $pagelist_erpStystem = $result['pagelist_erpStystem']-25; 
        $session->set(["pagelist_erpStystem" =>$pagelist_erpStystem]);
        return redirect('all_erpStystem_list'); 
    }
    //=======================ErpStystem  pagination  End================= 
    //======================= pagination start================= 
    public function next_recived_bil()
    { 
        $session = \Config\Services::session();
        $result = $session->get();    
        $pagelist_recived_bil = $result['pagelist_recived_bil']+25;
        $session->set(["pagelist_recived_bil" =>$pagelist_recived_bil]);
        return redirect('all_recived_bill_list'); 
    }
    public function previous_recived_bil()
    {                        
        $session = \Config\Services::session();
        $result = $session->get();    
        $pagelist_recived_bil = $result['pagelist_recived_bil']-25; 
        $session->set(["pagelist_recived_bil" =>$pagelist_recived_bil]);
        return redirect('all_recived_bill_list'); 
    }
    //=======================  pagination  End================= 
    //=======================vendor pagination start================= 
    public function next_vendor()
    { 
        $session = \Config\Services::session();
        $result = $session->get();    
        $pagelist_vendor = $result['pagelist_vendor']+25;
        $session->set(["pagelist_vendor" =>$pagelist_vendor]);
        return redirect('view_party_user'); 
    }
    public function previous_vendor()
    {                        
        $session = \Config\Services::session();
        $result = $session->get();    
        $pagelist_vendor = $result['pagelist_vendor']-25; 
        $session->set(["pagelist_vendor" =>$pagelist_vendor]);
        return redirect('view_party_user'); 
    }
    //=======================vendor pagination  End================= 
}