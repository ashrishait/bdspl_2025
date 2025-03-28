<?php

namespace App\Controllers;

use App\Models\CompenyModel;
use App\Models\EmployeeModel;
use App\Models\PointconversionModel;

use CodeIgniter\Controller;

class CompenyController extends BaseController
{
    private $db;
    public function __construct()
    {
        $this->db = db_connect(); // Loading database
    }

    public function add_compeny()
    {
        $validation = \Config\Services::validation();

        $model = new CompenyModel();

        $data = [
            "name" => $this->request->getVar("namee"),
            "email" => $this->request->getVar("email"),
            "contact_no" => $this->request->getVar("contact_no"),
        ];

        $insert = $model->insert($data);

        if ($insert) {
            $session = \Config\Services::session();
            $session->setFlashdata("emp_ok", 1);
            return redirect("view_compeny");
        }
    }

    public function view_compeny()
    {
        $session = \Config\Services::session();
        $result = $session->get();

        $etm = $result["edn"];

        $data["dax"] = $this->db
            ->query("select  * from asitek_compeny  ORDER BY id ASC ")
            ->getResultArray();

        return view("view_compeny", $data);
    }

    public function update_compeny()
    {
        $model = new CompenyModel();
        $data = [
            "name" => $this->request->getVar("name"),
            "email" => $this->request->getVar("email"),
            "contact_no" => $this->request->getVar("contact_no"),
        ];
        if (
            $model
                ->where("id", $this->request->getVar("id"))
                ->set($data)
                ->update()
        ) {
            $session = \Config\Services::session();
            $session->setFlashdata("data_up", 1);
            return redirect("view_compeny");
        }
    }

    public function del_compeny()
    {
        $session = \Config\Services::session();
        $model = new CompenyModel();
        $EmployeeModelObj = new EmployeeModel();

        $checkCompenyIdrow = $EmployeeModelObj
            ->where("compeny_id", $this->request->getVar("id"))
            ->first();
        if (isset($checkCompenyIdrow) && $checkCompenyIdrow != "") {
            $session->setFlashdata("data_delete", 2);
            return redirect("view_compeny");
        } else {
            $model->where("id", $this->request->getVar("id"))->delete();
            $session->setFlashdata("data_delete", 1);
            return redirect("view_compeny");
        }
    }
    
    public function allcompanyemployeereward()
    {
        $session = \Config\Services::session();
        $model = new CompenyModel();
        $EmployeeModelObj = new EmployeeModel();
        $todaydate = DATE('Y-m-d');
        $previousemonth=date('Y-m-d', strtotime(date('Y-m')." -1 month"));
        $previousemonth = date('m', strtotime($previousemonth));

        $thisdateseven = date('Y-m-10');
        $currentmonth = date('m', strtotime($thisdateseven));

        $query = $this->db->query("SELECT
            MAX(asitek_reward_point.id) as id,  -- or use another aggregate function like MIN
            asitek_reward_point.emp_id,
            asitek_employee.Ifsc_Code,
            asitek_employee.Acnt_No,
            asitek_employee.Acnt_Holder_Name,
            -- Add other columns from asitek_reward_point and asitek_employee as needed
            SUM(asitek_reward_point.reward_point) as emprewardpoint
        FROM
            asitek_reward_point
        LEFT JOIN
            asitek_employee ON asitek_reward_point.emp_id = asitek_employee.id
        LEFT JOIN
            asitek_bill_register ON asitek_reward_point.bill_id = asitek_bill_register.id    
        WHERE
            asitek_reward_point.paid_status = 1
            AND asitek_reward_point.status = 2
            AND MONTH(asitek_bill_register.Bill_DateTime) = '$previousemonth'
            AND Date(asitek_reward_point.rec_time_stamp)<= '$thisdateseven'
        GROUP BY
            asitek_reward_point.emp_id
            -- Add other columns from asitek_employee as needed
        ");

        if (!$query) {
            die($this->db->error()['message']);
        } else {
            $data["dax"] = $query->getResultArray();
        }
        
        $rewardconversionpointd = $this->db->query("SELECT Conversion_Point from asitek_reward_conversion WHERE Id=1")->getFirstRow();
        if(!empty($rewardconversionpointd)){
            $data['rewardconversionpointd'] = $rewardconversionpointd->Conversion_Point;
        }
        else{
            $data['rewardconversionpointd'] = 0;
        }
        
        $data["allrwrdprice"] = $this->db->query("SELECT SUM(asitek_reward_point.reward_point) as ttlreward FROM asitek_reward_point LEFT JOIN asitek_bill_register ON asitek_reward_point.bill_id = asitek_bill_register.id  WHERE  asitek_reward_point.status = 2 AND asitek_reward_point.paid_status = 1 AND MONTH(asitek_bill_register.Bill_DateTime)='$previousemonth' AND Date(asitek_reward_point.rec_time_stamp)<= '$thisdateseven'")->getResultArray();

        
        return view("allemployeeunpaidrewardlist", $data);
    }
    
    public function update_convrsionpoint()
    {
        $model = new PointconversionModel();
        $data = [
            "Conversion_Point" => $this->request->getVar("poninttobesave"),
        ];
        if ($model->where("id", 1)->set($data)->update()) 
        {
            $session = \Config\Services::session();
            $session->setFlashdata("data_up", 1);
            return redirect("allcompanyemployeereward");
        }
    }
    
    public function viewrewardcompanywise($compayid)
    {
        $session = \Config\Services::session();
        $model = new CompenyModel();
        $EmployeeModelObj = new EmployeeModel();
        $todaydate = DATE('Y-m-d');

        $query = $this->db->query("SELECT
            MAX(asitek_reward_point.id) as id,
            asitek_reward_point.emp_id,
            asitek_employee.first_name,
            asitek_employee.last_name,
            asitek_employee.mobile,
            asitek_employee.email,
            -- Add other columns from asitek_employee as needed
            SUM(asitek_reward_point.reward_point) as emprewardpoint
        FROM
            asitek_reward_point
        LEFT JOIN
            asitek_employee ON asitek_reward_point.emp_id = asitek_employee.id
        WHERE
            asitek_reward_point.compeny_id = '$compayid'  -- Assuming a typo fix from 'compeny_id' to 'company_id'
        GROUP BY
            asitek_reward_point.emp_id
            -- Add other columns from asitek_employee as needed
        ");
        if (!$query) {
            die($this->db->error()['message']);
        } else {
            $data["dax"] = $query->getResultArray();
        }

        
        $rewardconversionpointd = $this->db->query("SELECT Conversion_Point from asitek_reward_conversion WHERE Id=1")->getFirstRow();
        $data['rewardconversionpointd'] = $rewardconversionpointd->Conversion_Point;

        $data["allrwrdprice"] = $this->db->query("SELECT SUM(reward_point) as ttlreward FROM asitek_reward_point WHERE compeny_id = '$compayid'")->getResultArray();
        
        return view("viewrewardcompanywise", $data);
    }
    
}
