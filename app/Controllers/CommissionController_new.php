<?php

namespace App\Controllers;

use App\Models\UnitModel;
use App\Models\RewardPointRequestHistoryModel;
use App\Models\RewardPointModel;
use App\Models\CompenyModel;
use App\Models\EmployeeModel;
use App\Models\BillRegisterModel;
use CodeIgniter\Controller;

class CommissionController extends BaseController
{
    private $db;
    public function __construct()
    {
        $this->db = db_connect(); // Loading database
    }

    public function commission_dashboard()
    {
        $session = \Config\Services::session();
        $result = $session->get();

        $compeny_id = $result["compeny_id"];
        $emp_id = $session->get("emp_id");
        $rewardpointobj = new RewardPointModel();
        $RewardPointRequestHistoryobj = new RewardPointRequestHistoryModel();

        //$data['allBillcount'] = $this->db->table('asitek_bill_register')->where('compeny_id', $compeny_id)->countAllResults();

        $resultlp = $rewardpointobj
            ->select("sum(reward_point) as Pending_reward_pointSum")
            ->where("emp_id ", $emp_id)
            ->where("status ", 1)
            ->first();
        if (!empty($resultlp)) {
            $data["Pending_reward_pointSum"] =
                $resultlp["Pending_reward_pointSum"];
        } else {
            $data["Pending_reward_pointSum"] = 0;
        }

        $resultlreject = $rewardpointobj->select("sum(reward_point) as Reject_reward_pointSum")->where("emp_id ", $emp_id)->where("status ", 3)->where("paid_status ", 1)->first();

        if (!empty($resultlreject)) {
            $data["Reject_reward_pointSum"] =
            $resultlreject["Reject_reward_pointSum"];
        } else {
            $data["Reject_reward_pointSum"] = 0;
        }

        $resultlup = $rewardpointobj
            ->select("sum(reward_point) as Unpaid_reward_pointSum")
            ->where("emp_id ", $emp_id)
            ->where("status ", 2)
            ->where("paid_status ", 1)
            ->first();
        if (!empty($resultlup)) {
            $data["Unpaid_reward_pointSum"] =
                $resultlup["Unpaid_reward_pointSum"];
        } else {
            $data["Unpaid_reward_pointSum"] = 0;
        }

        $resultlpr = $rewardpointobj
            ->select("sum(reward_point) as Paid_reward_pointSum")
            ->where("emp_id ", $emp_id)
            ->where("status ", 2)
            ->where("paid_status ", 2)
            ->where("emp_id ", $emp_id)
            ->first();

        if (!empty($resultlpr)) {
            $data["Paid_reward_pointSum"] = $resultlpr["Paid_reward_pointSum"];
        } else {
            $data["Paid_reward_pointSum"] = 0;
        }

        $resultlprr = $RewardPointRequestHistoryobj
            ->select(
                "sum(request_reward_point) as Pending_request_reward_point_Sum"
            )
            ->where("emp_id ", $emp_id)
            ->where("status ", 1)
            ->first();
        if (!empty($resultlprr)) {
            $data["Pending_request_reward_point_Sum"] =
                $resultlprr["Pending_request_reward_point_Sum"];
        } else {
            $data["Pending_request_reward_point_Sum"] = 0;
        }

        return view("commission_dashboard", $data);
    }

    public function set_RequestRewardPoint()
    {
        $validation = \Config\Services::validation();

        $model = new RewardPointRequestHistoryModel();
        $DateTime = date("Y-m-d H:i:s");
        $compeny_id = $this->request->getVar("compeny_id");
        $emp_id = $this->request->getVar("emp_id");

        $row = $model
            ->where("emp_id", $emp_id)
            ->where("status", 1)
            ->first();
        if (isset($row) && $row != "") {
            $session = \Config\Services::session();
            $session->setFlashdata("exit_ok", 1);
            return redirect("commission_dashboard");
        } else {
            $data = [
                "compeny_id" => $compeny_id,
                "emp_id" => $emp_id,
                "request_reward_point" => $this->request->getVar(
                    "request_reward_point"
                ),
                "rec_time_stamp" => $DateTime,
            ];

            $insert = $model->insert($data);
            if ($insert) {
                $session = \Config\Services::session();
                $session->setFlashdata("ok", 1);
                return redirect("commission_dashboard");
            }
        }
    }

    public function View_Request_Reward_Point_history()
    {
        $session = \Config\Services::session();
        $result = $session->get();

        $etm = $result["edn"];
        $compeny_id = $result["compeny_id"];

        $data["dax"] = $this->db
            ->query(
                "select  * from asitek_reward_point_request_history  where compeny_id='$compeny_id' ORDER BY id ASC "
            )
            ->getResultArray();
        return view("View_Request_Reward_Point_history", $data);
    }

    public function del_Request_Reward_Point_history()
    {
        $session = \Config\Services::session();
        $model = new RewardPointRequestHistoryModel();
        $model->where("id", $this->request->getVar("id"))->delete();
        $session->setFlashdata("data_delete", 1);
        return redirect("View_Request_Reward_Point_history");
    }

    public function Request_Reward_Point_history_StatusChange()
    {
        $session = \Config\Services::session();
        $result = $session->get();
        $model = new RewardPointRequestHistoryModel();
        $rewardpointobj = new RewardPointModel();
        $id = $this->request->getVar("id");

        date_default_timezone_set("Asia/Kolkata");
        $Recived_DateTime = date("Y-m-d H:i:s");
        $status = $this->request->getVar("status");
        $emp_id = $this->request->getVar("emp_id");
        $data = [
            "status" => $this->request->getVar("status"),
            "comment " => $this->request->getVar("comment "),
        ];

        if (
            $model
                ->where("id", $id)
                ->set($data)
                ->update()
        ) {
            if ($status == 2) {
                $rewardpointobj
                    ->where("emp_id", $emp_id)
                    ->set("paid_status", 2)
                    ->update();
            }
            $session->setFlashdata("status", 1);
            return redirect("View_Request_Reward_Point_history");
        }
    }
    
    public function update_state_of_reward()
    {
        $company_id = $this->request->getPost('compeny_id');
        $emp_id = $this->request->getPost('emp_id');


        $today_date = Date('Y-m-d');

       $previousemonth = date('Y-m-d', strtotime('last day of previous month'));

        //$nine= date('Y-m-d', strtotime('+8 day', strtotime($today_date)));

        $data = [
            "paid_status" => 2
        ];
        $rewardpointobj = new RewardPointModel();

        $BillRegisterModelobj = new BillRegisterModel();
        $currentDay = date('d');
        if($currentDay>=11)
        {
            // $BillRegister=$BillRegisterModelobj->where("MONTH(Bill_DateTime)=", $previousemonth)->findAll();
            $BillRegister = $BillRegisterModelobj
        ->where("MONTH(Bill_DateTime) <", date('m', strtotime($previousemonth)))  // Previous month's month (numeric)
        ->where("YEAR(Bill_DateTime) =", date('Y', strtotime($previousemonth)))  // Previous month's year
        ->where("Add_By", $emp_id)   // Add_By is the employee ID
        ->where("compeny_id", $company_id)  // Filter by company ID
        ->findAll();   // Fetch the results



            
            if(isset($BillRegister)){
                foreach ($BillRegister as $BillRegisterrow){
                    $id=$BillRegisterrow['id'];
                    $rewardpointobj->where("bill_id", $id)->where("status", 2)->set($data)->update();
                }
            } 
            $session = \Config\Services::session();
            $session->setFlashdata("emp_up", 1);
            return redirect("allcompanyemployeereward");
        }
        else
        {
            $session = \Config\Services::session();
            $session->setFlashdata("invaildDate", 1);
            return redirect("allcompanyemployeereward");   
        }
    }

    public function reword_report()
    {
        $session = \Config\Services::session();
        $result = $session->get();
        $RewardPointModel = new RewardPointModel();
        $CompenyModel = new CompenyModel();
        $page = $this->request->getVar('page') ?? 1;
        $perPage = 50;
        $startSerial = ($page - 1) * $perPage + 1;
        $Roll_id = $session->get("Roll_id");
        //  $emp_id = $session->get("emp_id");
        // $company_id = $session->get("compeny_id");
        $start_Date = isset($_GET["start_Date"]) ? $_GET["start_Date"] : "1770-01-1";
        $end_Date = isset($_GET["end_Date"]) ? $_GET["end_Date"] : "9770-01-1";
        $compeny_id = isset($_GET["compeny_id"]) ? $_GET["compeny_id"] : "";
        $emp_id = isset($_GET["emp_id"]) ? $_GET["emp_id"] : "";
        $Status = isset($_GET["Status"]) ? $_GET["Status"] : "";
        $date_format = '%Y-%m-%d'; 
        $session->set(["SuperAdmin_start_Date" => $start_Date,"SuperAdmin_end_Date" => $end_Date,"SuperAdmin_compeny_id" => $compeny_id,"SuperAdmin_emp_id" => $emp_id,"SuperAdmin_Status" => $Status]);
        if($Status=='All' && $emp_id=='All'){
            $users = $RewardPointModel ->select("asitek_reward_point.*, asitek_bill_register.id, asitek_bill_register.uid, asitek_bill_register.Bill_DateTime")->join('asitek_bill_register', 'asitek_reward_point.bill_id = asitek_bill_register.id', 'left')->where('asitek_reward_point.compeny_id', $compeny_id)->where("STR_TO_DATE(asitek_bill_register.Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$start_Date', '$date_format') AND STR_TO_DATE('$end_Date', '$date_format')")->orderBy('asitek_bill_register.id', 'desc')->paginate($perPage);
            $resultl   = $RewardPointModel ->select('sum(reward_point) as reward_point2')->join('asitek_bill_register', 'asitek_reward_point.bill_id = asitek_bill_register.id', 'left')->where('asitek_reward_point.compeny_id', $compeny_id)->where("STR_TO_DATE(asitek_bill_register.Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$start_Date', '$date_format') AND STR_TO_DATE('$end_Date', '$date_format')")->first();
            $TotalRewardPointSum = $resultl['reward_point2'];
        }
        if($Status!='All' && $emp_id!='All'){
            $users = $RewardPointModel ->select("asitek_reward_point.*, asitek_bill_register.id, asitek_bill_register.uid, asitek_bill_register.Bill_DateTime")->join('asitek_bill_register', 'asitek_reward_point.bill_id = asitek_bill_register.id', 'left')->where('asitek_reward_point.compeny_id', $compeny_id)->where('asitek_reward_point.emp_id', $emp_id)->where('asitek_reward_point.status', $Status)->where("STR_TO_DATE(asitek_bill_register.Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$start_Date', '$date_format') AND STR_TO_DATE('$end_Date', '$date_format')")->orderBy('asitek_bill_register.id', 'desc')->paginate($perPage);
            $resultl   = $RewardPointModel ->select('sum(reward_point) as reward_point2')->join('asitek_bill_register', 'asitek_reward_point.bill_id = asitek_bill_register.id', 'left')->where('asitek_reward_point.compeny_id', $compeny_id)->where('asitek_reward_point.emp_id', $emp_id)->where('asitek_reward_point.status', $Status)->where("STR_TO_DATE(asitek_bill_register.Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$start_Date', '$date_format') AND STR_TO_DATE('$end_Date', '$date_format')")->first();
            $TotalRewardPointSum = $resultl['reward_point2'];
        }
        if($Status!='All' && $emp_id=='All'){
            $users = $RewardPointModel ->select("asitek_reward_point.*, asitek_bill_register.id, asitek_bill_register.uid, asitek_bill_register.Bill_DateTime")->join('asitek_bill_register', 'asitek_reward_point.bill_id = asitek_bill_register.id', 'left')->where('asitek_reward_point.compeny_id', $compeny_id)->where('asitek_reward_point.status', $Status)->where("STR_TO_DATE(asitek_bill_register.Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$start_Date', '$date_format') AND STR_TO_DATE('$end_Date', '$date_format')")->orderBy('asitek_bill_register.id', 'desc')->paginate($perPage);
            $resultl   = $RewardPointModel ->select('sum(reward_point) as reward_point2')->join('asitek_bill_register', 'asitek_reward_point.bill_id = asitek_bill_register.id', 'left')->where('asitek_reward_point.compeny_id', $compeny_id)->where('asitek_reward_point.status', $Status)->where("STR_TO_DATE(asitek_bill_register.Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$start_Date', '$date_format') AND STR_TO_DATE('$end_Date', '$date_format')")->first();
            $TotalRewardPointSum = $resultl['reward_point2'];
        }
        if($Status=='All' && $emp_id!='All'){
            $users = $RewardPointModel ->select("asitek_reward_point.*, asitek_bill_register.id, asitek_bill_register.uid, asitek_bill_register.Bill_DateTime")->join('asitek_bill_register', 'asitek_reward_point.bill_id = asitek_bill_register.id', 'left')->where('asitek_reward_point.compeny_id', $compeny_id)->where('asitek_reward_point.emp_id', $emp_id)->where("STR_TO_DATE(asitek_bill_register.Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$start_Date', '$date_format') AND STR_TO_DATE('$end_Date', '$date_format')")->orderBy('asitek_bill_register.id', 'desc')->paginate($perPage);
            $resultl   = $RewardPointModel ->select('sum(reward_point) as reward_point2')->join('asitek_bill_register', 'asitek_reward_point.bill_id = asitek_bill_register.id', 'left')->where('asitek_reward_point.compeny_id', $compeny_id)->where('asitek_reward_point.emp_id', $emp_id)->where("STR_TO_DATE(asitek_bill_register.Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$start_Date', '$date_format') AND STR_TO_DATE('$end_Date', '$date_format')")->first();
            $TotalRewardPointSum = $resultl['reward_point2'];
        }
        $dax1 = $CompenyModel->findAll();
        $data = [
            'users' => $users,
            'pager' => $RewardPointModel->pager,
            'startSerial' => $startSerial,
            'nextPage' => $page + 1,
            'previousPage' => ($page > 1) ? $page - 1 : null,
            'dax1' => $dax1,
            'TotalRewardPointSum' => $TotalRewardPointSum,
        ];
        return view("reword_report", $data);
    }

    public function export_reword_report(){
        $session = \Config\Services::session();
        $result = $session->get();
        $RewardPointModel = new RewardPointModel();
        $CompenyModel = new CompenyModel();
        $EmployeeModelObj = new EmployeeModel();
        $Roll_id = $session->get("Roll_id");
        //$emp_id = $session->get("emp_id");
        //$company_id = $session->get("compeny_id");
        // Excel file name for download 
        $fileName = "RewordPoint" . date('Y-m-d') . ".xls";     
        // Column names 
        $fields = array('UID', ' Empolyee Name', 'Reward Point', 'Reward Point Type','Bill Date','Reward Date','Status'); 
        // Display column names as first row 
        $excelData = implode("\t", array_values($fields)) . "\n"; 
        // Fetch records from database
        $date_format = '%Y-%m-%d'; 
        $start_Date = $session->has('SuperAdmin_start_Date') ? $session->get('SuperAdmin_start_Date') : '1770-01-1';
        $end_Date = $session->has('SuperAdmin_end_Date') ? $session->get('SuperAdmin_end_Date') : '9770-01-1';
        $compeny_id = $session->has('SuperAdmin_compeny_id') ? $session->get('SuperAdmin_compeny_id') : '';
        $emp_id = $session->has('SuperAdmin_emp_id') ? $session->get('SuperAdmin_emp_id') : '';
        $Status = $session->has('SuperAdmin_Status') ? $session->get('SuperAdmin_Status') : '';
        if($Status=='All' && $emp_id=='All'){
            $data = $RewardPointModel ->select("asitek_reward_point.*, asitek_bill_register.id, asitek_bill_register.uid, asitek_bill_register.Bill_DateTime")->join('asitek_bill_register', 'asitek_reward_point.bill_id = asitek_bill_register.id', 'left')->where('asitek_reward_point.compeny_id', $compeny_id)->where("STR_TO_DATE(asitek_bill_register.Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$start_Date', '$date_format') AND STR_TO_DATE('$end_Date', '$date_format')")->orderBy('asitek_bill_register.Bill_DateTime', 'desc')->findAll();
        }
        if($Status!='All' && $emp_id!='All'){
            $data = $RewardPointModel ->select("asitek_reward_point.*, asitek_bill_register.id, asitek_bill_register.uid, asitek_bill_register.Bill_DateTime")->join('asitek_bill_register', 'asitek_reward_point.bill_id = asitek_bill_register.id', 'left')->where('asitek_reward_point.compeny_id', $compeny_id)->where('asitek_reward_point.emp_id', $emp_id)->where('asitek_reward_point.status', $Status)->where("STR_TO_DATE(asitek_bill_register.Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$start_Date', '$date_format') AND STR_TO_DATE('$end_Date', '$date_format')")->orderBy('asitek_bill_register.Bill_DateTime', 'desc')->findAll();
        }
        if($Status!='All' && $emp_id=='All'){
            $data = $RewardPointModel ->select("asitek_reward_point.*, asitek_bill_register.id, asitek_bill_register.uid, asitek_bill_register.Bill_DateTime")->join('asitek_bill_register', 'asitek_reward_point.bill_id = asitek_bill_register.id', 'left')->where('asitek_reward_point.compeny_id', $compeny_id)->where('asitek_reward_point.emp_id', $emp_id)->where("STR_TO_DATE(asitek_bill_register.Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$start_Date', '$date_format') AND STR_TO_DATE('$end_Date', '$date_format')")->orderBy('asitek_bill_register.Bill_DateTime', 'desc')->findAll();
        }
        if($Status=='All' && $emp_id!='All'){
            $data = $RewardPointModel ->select("asitek_reward_point.*, asitek_bill_register.id, asitek_bill_register.uid, asitek_bill_register.Bill_DateTime")->join('asitek_bill_register', 'asitek_reward_point.bill_id = asitek_bill_register.id', 'left')->where('asitek_reward_point.compeny_id', $compeny_id)->where('asitek_reward_point.emp_id', $emp_id)->where("STR_TO_DATE(asitek_bill_register.Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$start_Date', '$date_format') AND STR_TO_DATE('$end_Date', '$date_format')")->orderBy('asitek_bill_register.Bill_DateTime', 'desc')->findAll();
        }
        $Totalreward_point=0;
        if(isset($data)){ 
            // Output each row of the data 
            foreach($data as $row)
            { 
                if(isset($row['uid'])){$uid = $row['uid'];} else{ $uid = 'NA';}
                $MappingEmprow= $EmployeeModelObj->where('id',$row['emp_id'])->first();
                if(isset($MappingEmprow) && $MappingEmprow!='')
                {
                    $Emp_Id= $MappingEmprow['first_name'].' '.$MappingEmprow['last_name'];
                }
                else{
                    $Emp_Id=''; 
                }
                if(isset($row['reward_point'])){$reward_point = $row['reward_point'];} else{ $reward_point = 'NA';}
                if(isset($row['reward_point_type'])){$reward_point_type = $row['reward_point_type'];}else{ $reward_point_type = 'NA';}
                if(isset($row['Bill_DateTime'])){$Bill_DateTime = $row['Bill_DateTime'];}else{ $Bill_DateTime = 'NA';}
                if(isset($row['rec_time_stamp'])){$rec_time_stamp = $row['rec_time_stamp'];}else{ $rec_time_stamp = 'NA';}
                if($row['status']=='1' && $row['paid_status']=='1'){
                    $status='Pending';
                }
                elseif($row['status']=='2' && $row['paid_status']=='1'){
                    $status='Unpaid';
                }
                elseif($row['status']=='3' && $row['paid_status']=='1'){
                    $status='Reject';
                }
                elseif($row['status']=='2' && $row['paid_status']=='2'){
                    $status='Paid';
                }
                else
                {
                    $status='';
                }
                $Totalreward_point= $Totalreward_point+$reward_point;
                $lineData = array($uid, $Emp_Id, $reward_point, $reward_point_type,$Bill_DateTime,$rec_time_stamp,$status);
                // array_walk(str_replace('"', '""',(preg_replace("/\r?\n/", "\\n",(preg_replace("/\t/", "\\t", $lineData))))); 
                $excelData .= implode("\t", array_values($lineData)) . "\n";   
            } 
            $lineDataextrarow = array('','Total',$Totalreward_point,'','','');
            $excelData .= implode("\t", array_values($lineDataextrarow)) . "\n";
        }
        else{ 
            $session->setFlashdata('excel',1);
        } 
        // Headers for download 
        header("Content-Type: application/vnd.ms-excel"); 
        header("Content-Disposition: attachment; filename=\"$fileName\""); 
        echo $excelData; 
        exit;
        return redirect('app-list');
    }

    public function bill_wise_reword_report()
    {
        $session = \Config\Services::session();
        $result = $session->get();
        $RewardPointModel = new RewardPointModel();
        $CompenyModel = new CompenyModel();
            $BillRegisterModelObj = new BillRegisterModel();
        $page = $this->request->getVar('page') ?? 1;
        $perPage = 25;
        $startSerial = ($page - 1) * $perPage + 1;
        $Roll_id = $session->get("Roll_id");
    
         $start_Date = isset($_GET["start_Date"]) ? $_GET["start_Date"] : "1770-01-1";
         $end_Date = isset($_GET["end_Date"]) ? $_GET["end_Date"] : "9770-01-1";
         $compeny_id = isset($_GET["compeny_id"]) ? $_GET["compeny_id"] : "";
        // $emp_id = isset($_GET["emp_id"]) ? $_GET["emp_id"] : "";
         //$Status = isset($_GET["Status"]) ? $_GET["Status"] : "";

         
         
         $date_format = '%Y-%m-%d'; 
        //$session->set(["SuperAdmin_start_Date" => $start_Date,"SuperAdmin_end_Date" => $end_Date,"SuperAdmin_compeny_id" => $compeny_id,"SuperAdmin_emp_id" => $emp_id,"SuperAdmin_Status" => $Status]);


              if( $compeny_id=='All'){
                $users = $BillRegisterModelObj->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$start_Date', '$date_format') AND STR_TO_DATE('$end_Date', '$date_format')")->orderBy('Bill_DateTime', 'desc')->paginate($perPage);

                    }
                    else{
                $users = $BillRegisterModelObj->where('compeny_id', $compeny_id)->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$start_Date', '$date_format') AND STR_TO_DATE('$end_Date', '$date_format')")->orderBy('Bill_DateTime', 'desc')->paginate($perPage);

                    }
              
             
              

           $dax1 = $CompenyModel->findAll();
          $data = [
            'users' => $users,
            'pager' => $BillRegisterModelObj->pager,
            'startSerial' => $startSerial,
            'nextPage' => $page + 1,
            'previousPage' => ($page > 1) ? $page - 1 : null,
             'dax1' => $dax1,
             
           
        ];
         
         return view("bill_wise_reword_report", $data);

    }

    public function bill_wise_reword_report_export()
    {
        $session = \Config\Services::session();
        $result = $session->get();
        $RewardPointModel = new RewardPointModel();
        $CompenyModel = new CompenyModel();
            $BillRegisterModelObj = new BillRegisterModel();
        $page = $this->request->getVar('page') ?? 1;
        $perPage = 2500000000000000;
        $startSerial = ($page - 1) * $perPage + 1;
        $Roll_id = $session->get("Roll_id");
    
     
       
        $start_Date = $this->request->getVar('start_Date');
        $end_Date =  $this->request->getVar('end_Date'); 
        $compeny_id =  $this->request->getVar('Searchcompeny_id'); 

  
         $date_format = '%Y-%m-%d'; 
              if( $compeny_id=='All'){
                 $data['dax'] =$BillRegisterModelObj->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$start_Date', '$date_format') AND STR_TO_DATE('$end_Date', '$date_format')")->orderBy('Bill_DateTime', 'desc')->findAll();

                    }
                    else{
                $data['dax'] = $BillRegisterModelObj->where('compeny_id', $compeny_id)->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$start_Date', '$date_format') AND STR_TO_DATE('$end_Date', '$date_format')")->orderBy('Bill_DateTime', 'desc')->findAll();

                    }
    

         
         return view("bill_wise_reword_report_export", $data);

    }
}
