<?php

namespace App\Controllers;
use App\Models\UserModel;
use App\Models\EmployeeModel;
use App\Models\StateModel;
use App\Models\RollModel;
use App\Models\CityModel;
use App\Models\ClassModel;
use App\Models\BillRegisterModel;
use App\Models\PartyUserModel;
use App\Models\UnitModel;
use App\Models\DepartmentModel;
use App\Models\BillTypeModel;
use App\Models\MasterActionModel;
use App\Models\MasterActionUploadModel;
use App\Models\CompenyModel;
use App\Models\RewardPointModel;
use CodeIgniter\Controller;
use App\Models\PageaccessionModel;

class BillRegisterController extends BaseController
{
    private $db;
    public function __construct()
    {
        $this->db = db_connect(); // Loading database
    }

    public function getDepartmentUser()
    {
        if ($this->request->getVar("action")) {
            $action = $this->request->getVar("action");
            if ($action == "get_User") {
                $Model = new EmployeeModel();
                $Userdata = $Model
                    ->where(
                        "department",
                        $this->request->getVar("department_id")
                    )
                    ->findAll();
                $Model2 = new DepartmentModel();
                $departmentdata = $Model2
                    ->where("id", $this->request->getVar("department_id"))
                    ->findAll();
                echo json_encode($Userdata);
            }
        }
    }

    public function index()
    {
        $session = \Config\Services::session();
        $result = $session->get();
        $compeny_id = $session->get("compeny_id");
        $model = new StateModel();
        $data["dax"] = $model->findAll();
        $model9 = new DepartmentModel();
        $data["dax9"] = $model9->where("compeny_id", $compeny_id)->findAll();
        $model3 = new EmployeeModel();
        // $model14 = new PartyUserModel();
        // $data["dax14"] = $model14->findAll();
        $builderrecommended = $this->db->table("asitek_company_vendor");
        $builderrecommended->select('asitek_company_vendor.Vendor_Id, asitek_party_user.id, asitek_party_user.GST_No, asitek_party_user.Name');
        $builderrecommended->join('asitek_party_user', 'asitek_party_user.id = asitek_company_vendor.Vendor_Id');
        $builderrecommended->where('asitek_company_vendor.Company_Id', $compeny_id);
        $builderrecommended->groupBy('asitek_company_vendor.Vendor_Id');
        $data_recommended = $builderrecommended->get()->getResult();
        $data['dax14'] =$data_recommended;
        $model15 = new UnitModel();
        $data["dax15"] = $model15->where("compeny_id", $compeny_id)->findAll();
        return view("add_bill_register", $data);
    }

    public function view_bill_register()
    {
        $session = \Config\Services::session();
        $result = $session->get();
        $etm = $result["ddn"];
        $Roll_id = $session->get("Roll_id");
        $emp_id = $session->get("emp_id");
        $compeny_id = $session->get("compeny_id");
        if ($Roll_id == 1) {
            $data["dax"] = $this->db
                ->query(
                    "select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id  where asitek_bill_register.compeny_id='$compeny_id'  ORDER BY asitek_bill_register.id desc limit 20 offset " .
                        $etm
                )
                ->getResultArray();
        } else {
            $data["dax"] = $this->db
                ->query(
                    "select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id  where Add_By='$emp_id' and  asitek_bill_register.compeny_id='$compeny_id' ORDER BY asitek_bill_register.id desc limit 20 offset " .
                        $etm
                )
                ->getResultArray();
        }
        $model6 = new StateModel();
        $data["dax6"] = $model6->findAll();
        $model1 = new CityModel();
        $data["dax1"] = $model1->findAll();
        $model9 = new DepartmentModel();
        $data["dax9"] = $model9->where("compeny_id", $compeny_id)->findAll();
        $model3 = new EmployeeModel();
        $model14 = new PartyUserModel();
        $data["dax14"] = $model14->where("compeny_id", 0)->findAll();
        $model15 = new UnitModel();
        $data["dax15"] = $model15->where("compeny_id", $compeny_id)->findAll();
        $model16 = new DepartmentModel();
        $data["dax16"] = $model16->where("compeny_id", $compeny_id)->findAll();
        return view("view_bill_register", $data);
    }

    public function add_bill_vendor()
    {
        $session = \Config\Services::session();
        $result = $session->get();
        $emp_id = $session->get("emp_id");
        $model = new StateModel();
        $data["dax"] = $model->findAll();

        $model3 = new EmployeeModel();
        $model14 = new PartyUserModel();
        $data["dax14"] = $model14->findAll();

        $companymodel = new CompenyModel();
        $builderrecommended = $this->db->table("asitek_vendor_company");
        $builderrecommended->select('asitek_vendor_company.Company_Id, asitek_compeny.id, asitek_compeny.name');
        $builderrecommended->join('asitek_compeny', 'asitek_compeny.id = asitek_vendor_company.Company_Id');
        $builderrecommended->where('asitek_vendor_company.Vendor_Id', $emp_id);
        $builderrecommended->groupBy('asitek_compeny.id');
        $data_recommended = $builderrecommended->get()->getResult();

        $data["company"] = $data_recommended;
        return view("add-bill-vendor", $data);
    }

    public function vendor_store_bill_register()
    {
        $session = \Config\Services::session();
        $result = $session->get();
        $BillRegister = new BillRegisterModel();
        $validation = \Config\Services::validation();
        $file = $this->request->getFile("E_Image");
        if ($file != "") {
            $validation->setRules([
                "E_Image" =>
                    "uploaded[E_Image]|ext_in[E_Image,jpg,JPG,png,PNG,jpeg,JPEG,pdf]",
            ]);
            if (!$validation->withRequest($this->request)->run()) {
                $data["error"] = $validation->getErrors();
                $this->index();
                return redirect("add-bill-vendor");
            } else {
                $imageName = $file->getRandomName();
                $file->move("public/vendors/PicUpload", $imageName);
            }
        } else {
            $imageName = "";
        }

        $uid = $this->db
            ->table("asitek_bill_register")
            ->where("compeny_id", $this->request->getVar("company_id"))
            ->countAllResults();
        $uidno = $uid + 1;

        $Gate_Entry_Date = date(
            "Y-m-d",
            strtotime($this->request->getVar("Gate_Entry_Date"))
        );
        $DateTime = date("Y-m-d H:i:s");
        $billduplicacy = $BillRegister->where("Vendor_Id", $this->request->getVar("vendor_id"))->where("Bill_No", $this->request->getVar("Bill_No"))->findAll();
        if(!empty($billduplicacy)){
            $session->setFlashdata(
                "success",
                " <div class='alert alert-danger' role='alert'> Bill No already added </div>"
            );
            return redirect("add-bill-vendor");
        }
        else{
            $data = [
                "uid" => $uidno,
                "compeny_id" => $this->request->getVar("company_id"),
                "Add_By" => $this->request->getVar("Add_By"),
                "Bill_No" => $this->request->getVar("Bill_No"),
                "Gate_Entry_No" => $this->request->getVar("Gate_Entry_No"),
                "Unit_Id" => $this->request->getVar("Unit_Id"),
                "Vendor_Id" => $this->request->getVar("vendor_id"),
                "Bill_DateTime" => $this->request->getVar("Bill_DateTime"),
                "Gate_Entry_Date" => $this->request->getVar("Gate_Entry_Date"),
                "Bill_Amount" => $this->request->getVar("Bill_Amount"),
                "Remark" => $this->request->getVar("Remark"),
                "Bill_Pic" => $imageName,
                "DateTime" => $DateTime,
                "Department_Id" => $this->request->getVar("Department_Id"),
                "Add_By_Vendor" => 1,
            ];
            $BillRegisterinsert = $BillRegister->insert($data);
            $lastId = $BillRegister->getInsertID();
            $string2 = "REG";
            $Bill_No = $lastId;
            if ($BillRegisterinsert) {
                $session = \Config\Services::session();
                $session->setFlashdata(
                    "success",
                    "<div class='alert alert-success' role='alert'> Form Submition Successful. Bill Id : $uidno </div>"
                );
                return redirect("add-bill-vendor");
            } else {
                $session->setFlashdata(
                    "success",
                    " <div class='alert alert-danger' role='alert'> Problem in Submition! </div>"
                );
                return redirect("add-bill-vendor");
            }
        }
    }

    public function view_vendor_bill()
    {
        $session = \Config\Services::session();
        $result = $session->get();
        $etm = $result["ddn"];
        $Roll_id = $session->get("Roll_id");
        $emp_id = $session->get("emp_id");
        $compeny_id = $session->get("compeny_id");
        $data["dax"] = $this->db
            ->query(
                "select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id  where asitek_bill_register.Vendor_Id='$emp_id' ORDER BY asitek_bill_register.id desc limit 20 offset " .
                    $etm
            )
            ->getResultArray();

        $model6 = new StateModel();
        $data["dax6"] = $model6->findAll();
        $model1 = new CityModel();
        $data["dax1"] = $model1->findAll();
        $model9 = new DepartmentModel();
        $data["dax9"] = $model9->where("compeny_id", $compeny_id)->findAll();
        $model3 = new EmployeeModel();
        $model14 = new PartyUserModel();
        $data["dax14"] = $model14->where("compeny_id", 0)->findAll();
        $model15 = new UnitModel();
        $data["dax15"] = $model15->where("compeny_id", $compeny_id)->findAll();
        $model16 = new DepartmentModel();
        $data["dax16"] = $model16->where("compeny_id", $compeny_id)->findAll();
        return view("view-vendor-bill", $data);
    }

    public function addvendorbill()
    {
        $session = \Config\Services::session();
        $result = $session->get();
        $compeny_id = $session->get("compeny_id");
        $model = new StateModel();
        $data["dax"] = $model->findAll();
        $model9 = new DepartmentModel();
        $data["dax9"] = $model9->where("compeny_id", $compeny_id)->findAll();
        $model3 = new EmployeeModel();
        $model14 = new PartyUserModel();
        $data["dax14"] = $model14->where("compeny_id", 0)->findAll();
        $model15 = new UnitModel();
        $comapnymodel = new CompenyModel();
        $data["company"] = $comapnymodel->findAll();
        $data["dax15"] = $model15->where("compeny_id", $compeny_id)->findAll();
        return view("add_bill_register", $data);
    }

    public function store_bill_register()
    {
        $session = \Config\Services::session();
        $result = $session->get();
        $email = \Config\Services::email();
        $validation = \Config\Services::validation();
        $BillRegister = new BillRegisterModel();
        $vendormodel = new PartyUserModel();
        $companymodel = new CompenyModel();
        $file = $this->request->getFile("E_Image");
        if ($file != "") {
            $validation->setRules([
                "E_Image" =>
                    "uploaded[E_Image]|ext_in[E_Image,jpg,JPG,png,PNG,jpeg,JPEG,pdf]",
            ]);
            if (!$validation->withRequest($this->request)->run()) {
                $data["error"] = $validation->getErrors();
                $this->index();
                return view("add_bill_register");
            } else {
                $imageName = $file->getRandomName();
                $file->move("public/vendors/PicUpload", $imageName);
            }
        } else {
            $imageName = "";
        }

        $uid = $this->db
            ->table("asitek_bill_register")
            ->where("compeny_id", $this->request->getVar("compeny_id"))
            ->countAllResults();
        $uidno = $uid + 1;

        $vdr = $vendormodel
            ->where("id", $this->request->getVar("Vendor_Id"))
            ->first();

        $cpn = $companymodel
            ->where("id", $this->request->getVar("compeny_id"))
            ->first();

        $Gate_Entry_Date = date(
            "Y-m-d",
            strtotime($this->request->getVar("Gate_Entry_Date"))
        );
        $DateTime = date("Y-m-d H:i:s");

        $billduplicacy = $BillRegister->where("Vendor_Id", $this->request->getVar("Vendor_Id"))->where("Bill_No", $this->request->getVar("Bill_No"))->findAll();
        if(!empty($billduplicacy)){
            $session->setFlashdata(
                "success",
                " <div class='alert alert-danger' role='alert'> Bill No already added </div>"
            );
            return redirect("add_bill_register");
        }
        else{
            $data = [
                "uid" => $uidno,
                "compeny_id" => $this->request->getVar("compeny_id"),
                "Add_By" => $this->request->getVar("Add_By"),
                "Bill_No" => $this->request->getVar("Bill_No"),
                "Gate_Entry_No" => $this->request->getVar("Gate_Entry_No"),
                "Unit_Id" => $this->request->getVar("Unit_Id"),
                "Vendor_Id" => $this->request->getVar("Vendor_Id"),
                "Bill_DateTime" => $this->request->getVar("Bill_DateTime"),
                "Gate_Entry_Date" => $this->request->getVar("Gate_Entry_Date"),
                "Bill_Amount" => $this->request->getVar("Bill_Amount"),
                "Remark" => $this->request->getVar("Remark"),
                "Bill_Pic" => $imageName,
                "DateTime" => $DateTime,
                "Department_Id" => $this->request->getVar("Department_Id"),
            ];
        
            $BillRegisterinsert = $BillRegister->insert($data);
            $lastId = $BillRegister->getInsertID();
            $string2 = "REG";
            $Bill_No = $lastId;
            if ($BillRegisterinsert) {
                $session = \Config\Services::session();
                $session->setFlashdata(
                    "success",
                    "<div class='alert alert-success' role='alert'> Form Submition Successful. Bill Id : $uidno </div>"
                );

                $wpmsg =
                    "Hi " .
                    $vdr["Name"] .
                    ", Just a quick heads up - your recent invoice has been successfully added to Company records. Thanks for your prompt submission! Best regards, " .
                    $cpn["name"];
                // $url = "https://chatway.in/api/send-msg?username=ashrishaWCH&number=+91".$vdr['Mobile_No']."&message=".$wpmsg."&token=Y21iQk9IeExwbjluMGE2SUxhM2taQT09";
                // $url = preg_replace("/ /", "%20", $url);
                // $response = file_get_contents($url);

                // $email->setFrom("singhshaan085@gmail.com", "Bill Management");
                // $email->setTo($vdr["Email_Id"]);
                // $email->setSubject("Bill Add in Company | Bill Management");
                // $email->setmailType("html");
                // $email->setMessage($wpmsg); //your message here
                // $email->send();
                // ****Start RewardPoint**
                if ($BillRegisterinsert > 0) {
                    $Add_RewardPoint = 30;
                } else {
                    $Add_RewardPoint = 0;
                }
                $Remark = $this->request->getVar("Remark");
                if ($Remark != "") {
                    $Remark_RewardPoint = 20;
                } else {
                    $Remark_RewardPoint = 0;
                }
                $E_Image = $this->request->getFile("E_Image");
                if ($E_Image != "") {
                    $FileAttch_RewardPoint = 30;
                } else {
                    $FileAttch_RewardPoint = 0;
                }

                 $month = date('m', strtotime($DateTime));
                    $month2 = date('m', strtotime($this->request->getVar("Bill_DateTime")));
                    if($month<=$month2)
                    {
                    $reward_point =
                    $Add_RewardPoint + $Remark_RewardPoint + $FileAttch_RewardPoint;
                    }
                    else
                    {
                    $reward_point =0;
                    }

                
                $reward_point_type = "Bill Add";
                $session_compeny_id = $session->get("compeny_id");
                $DateTimenew = date("Y-m-d H:i:s");
                $dataRewardPoint = [
                    "bill_id" => $lastId,
                    "compeny_id" => $session_compeny_id,
                    "emp_id" => $this->request->getVar("Add_By"),
                    "reward_point" => $reward_point,
                    "reward_point_type" => $reward_point_type,
                    "rec_time_stamp" => $DateTimenew,
                ];
                $RewardPointobj = new RewardPointModel();
                $RewardPoint = $RewardPointobj->insert($dataRewardPoint);

                // ****End RewardPoint**
                return redirect("add_bill_register");
            } else {
                $session->setFlashdata(
                    "success",
                    " <div class='alert alert-danger' role='alert'> Problem in Submition! </div>"
                );
                return redirect("add_bill_register");
            }
        }
    }

    public function update_bill_register()
    {
        $file = $this->request->getFile("E_Image");
        if ($file->isValid() && !$file->hasMoved() && $file != "") {
            $imageName = $file->getRandomName();
            $file->move("public/vendors/PicUpload", $imageName); //PicUpload -->where image will stored
        } else {
            $imageName = $this->request->getVar("db_image");
        }

        $Bill_DateTime = $this->request->getVar("Bill_DateTime");
        if ($Bill_DateTime != "") {
            $Bill_DateTime = $this->request->getVar("Bill_DateTime");
            $Bill_DateTime = date("Y-m-d H:i:s", strtotime($Bill_DateTime));
        } else {
            $Bill_DateTime = $this->request->getVar("Bill_DateTimehidden");
            $Bill_DateTime = date("Y-m-d H:i:s", strtotime($Bill_DateTime));
        }
        $data = [
            "Bill_No" => $this->request->getVar("Bill_No"),
            "Gate_Entry_No" => $this->request->getVar("Gate_Entry_No"),
            "Unit_Id" => $this->request->getVar("Unit_Id"),
            "Vendor_Id" => $this->request->getVar("Vendor_Id"),
            "Bill_DateTime" => $Bill_DateTime,
            "Bill_Amount" => $this->request->getVar("Bill_Amount"),
            "Remark" => $this->request->getVar("Remark"),
            "Bill_Pic" => $imageName,
            "Department_Id" => $this->request->getVar("Department_Id"),
            "Bill_Acceptation_Status" => "1",
            "Bill_Acceptation_DateTime" => "",
        ];
        $emp = new BillRegisterModel();
        if (
            $emp
                ->where("id", $this->request->getVar("id"))
                ->set($data)
                ->update()
        ) {
            $session = \Config\Services::session();
            $session->setFlashdata("emp_up", 1);
            return redirect("view_bill_register");
        }
    }

    public function bill_register_delete()
    {
        $session = \Config\Services::session();
        $model = new BillRegisterModel();
        $model->where("id", $this->request->getVar("id"))->delete();

        $RewardPointobj = new RewardPointModel();
        $RewardPointobj
            ->where("bill_id", $this->request->getVar("id"))
            ->delete();

        $session->setFlashdata("emp_delete", 1);
        return redirect("view_bill_register");
    }

    //************** Bill End***************
    //**************Mapping Bill Start***************
    public function all_bill_mapping_list()
    {
        $session = \Config\Services::session();
        $result = $session->get();
        $etm = $result["ddn"];
        $Roll_id = $session->get("Roll_id");
        $emp_id = $session->get("emp_id");
        $compeny_id = $session->get("compeny_id");
        
        if (isset($_GET["Unit_Id"])) {
            $Unit_Id = $_GET["Unit_Id"];
        } else {
            $Unit_Id = "";
        }
        if (isset($_GET["Vendor_Id"])) {
            $Vendor_Id = $_GET["Vendor_Id"];
        } else {
            $Vendor_Id = "";
        }

        if (isset($_GET["assignedto"])) {
            $assignedto = $_GET["assignedto"];
        } else {
            $assignedto = "";
        }
        
        if (isset($_GET["Satus"])) {
            $Satus = $_GET["Satus"];
        } else {
            $Satus = "";
        }
        
        
        if(!empty($Unit_Id) && empty($Vendor_Id) && empty($assignedto) && !empty($Satus)){
            if ($Roll_id == 1) {
                if ($Satus == "All") {
                    $data["dax"] = $this->db->query("select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id where asitek_bill_register.compeny_id='$compeny_id' and asitek_bill_register.Unit_Id='$Unit_Id'  ORDER BY asitek_bill_register.id desc ")->getResultArray();
                } else {
                    $data["dax"] = $this->db->query("select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id where asitek_bill_register.compeny_id='$compeny_id' and asitek_bill_register.Unit_Id='$Unit_Id' and asitek_bill_register.Bill_Acceptation_Status='$Satus'  ORDER BY asitek_bill_register.id desc")->getResultArray();
                }
            } else {
                if ($Satus == "All") {
                    $data["dax"] = $this->db->query("select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id where asitek_bill_register.compeny_id='$compeny_id' and asitek_bill_register.Unit_Id='$Unit_Id' ORDER BY asitek_bill_register.id desc ")->getResultArray();
                } else {
                    $data["dax"] = $this->db->query("select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id where asitek_bill_register.compeny_id='$compeny_id' and asitek_bill_register.Unit_Id='$Unit_Id' and asitek_bill_register.Bill_Acceptation_Status='$Satus' AND Add_By='$emp_id' ORDER BY asitek_bill_register.id desc")->getResultArray();
                }
            }
        }
        
        if(empty($Unit_Id) && !empty($Vendor_Id) && empty($assignedto) && !empty($Satus)){
            if ($Roll_id == 1) {
                if ($Satus == "All") {
                    $data["dax"] = $this->db->query("select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id where asitek_bill_register.compeny_id='$compeny_id' and asitek_bill_register.Vendor_Id='$Vendor_Id'  ORDER BY asitek_bill_register.id desc ")->getResultArray();
                } else {
                    $data["dax"] = $this->db->query("select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id where asitek_bill_register.compeny_id='$compeny_id' and asitek_bill_register.Vendor_Id='$Vendor_Id' and asitek_bill_register.Bill_Acceptation_Status='$Satus'  ORDER BY asitek_bill_register.id desc")->getResultArray();
                }
            } else {
                if ($Satus == "All") {
                    $data["dax"] = $this->db->query("select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id where asitek_bill_register.compeny_id='$compeny_id' and asitek_bill_register.Vendor_Id='$Vendor_Id' ORDER BY asitek_bill_register.id desc ")->getResultArray();
                } else {
                    $data["dax"] = $this->db->query("select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id where asitek_bill_register.compeny_id='$compeny_id' and asitek_bill_register.Vendor_Id='$Vendor_Id' and asitek_bill_register.Bill_Acceptation_Status='$Satus' AND Add_By='$emp_id' ORDER BY asitek_bill_register.id desc")->getResultArray();
                }
            }
        }
        
        if(empty($Unit_Id) && empty($Vendor_Id) && !empty($assignedto) && !empty($Satus)){
            if ($Roll_id == 1) {
                if ($Satus == "All") {
                    $data["dax"] = $this->db->query("select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id where asitek_bill_register.compeny_id='$compeny_id' and asitek_bill_register.Department_Emp_Id='$assignedto'  ORDER BY asitek_bill_register.id desc ")->getResultArray();
                } else {
                    $data["dax"] = $this->db->query("select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id where asitek_bill_register.compeny_id='$compeny_id' and asitek_bill_register.Bill_Acceptation_Status='$Satus'  ORDER BY asitek_bill_register.id desc")->getResultArray();
                }
            } else {
                if ($Satus == "All") {
                    $data["dax"] = $this->db->query("select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id where asitek_bill_register.compeny_id='$compeny_id' and asitek_bill_register.Department_Emp_Id='$assignedto' ORDER BY asitek_bill_register.id desc ")->getResultArray();
                } else {
                    $data["dax"] = $this->db->query("select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id where asitek_bill_register.compeny_id='$compeny_id' and  asitek_bill_register.Bill_Acceptation_Status='$Satus' ORDER BY asitek_bill_register.id desc")->getResultArray();
                }
            }
        }
        
        if(empty($Unit_Id) && empty($Vendor_Id) && empty($assignedto) && !empty($Satus)){
            if ($Roll_id == 1) {
                if ($Satus == "All") {
                    $data["dax"] = $this->db->query("select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id  where asitek_bill_register.compeny_id='$compeny_id'   ORDER BY asitek_bill_register.id desc ")->getResultArray();
                } else {
                    $data["dax"] = $this->db->query("select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id where asitek_bill_register.compeny_id='$compeny_id' and asitek_bill_register.Bill_Acceptation_Status='$Satus'  ORDER BY asitek_bill_register.id desc")->getResultArray();
                }
            } else {
                if ($Satus == "All") {
                    $data["dax"] = $this->db->query("select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id  where asitek_bill_register.compeny_id='$compeny_id' AND Add_By='$emp_id' ORDER BY asitek_bill_register.id desc ")->getResultArray();
                } else {
                    $data["dax"] = $this->db->query("select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id where asitek_bill_register.compeny_id='$compeny_id' and asitek_bill_register.Bill_Acceptation_Status='$Satus' ORDER BY asitek_bill_register.id desc")->getResultArray();
                }
            }
        }
        
        if(empty($Unit_Id) && empty($Vendor_Id) && empty($assignedto) && empty($Satus)){
            if ($Roll_id == 1) {
                $data["dax"] = $this->db->query("select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id  where asitek_bill_register.compeny_id='$compeny_id'   ORDER BY asitek_bill_register.id desc ")->getResultArray();
            } else {
                $data["dax"] = $this->db->query("select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id  where asitek_bill_register.compeny_id='$compeny_id' ORDER BY asitek_bill_register.id desc ")->getResultArray();
                
            }
        }
        
        // Only Status  Filter wise End Code
        $model6 = new StateModel();
        $data["dax6"] = $model6->findAll();
        $model1 = new CityModel();
        $data["dax1"] = $model1->findAll();
        $model9 = new DepartmentModel();
        $data["dax9"] = $model9->where("compeny_id", $compeny_id)->findAll();
        $model3 = new EmployeeModel();
        $builderrecommended = $this->db->table("asitek_company_vendor");
        $builderrecommended->select('asitek_company_vendor.Vendor_Id, asitek_party_user.id, asitek_party_user.GST_No, asitek_party_user.Name');
        $builderrecommended->join('asitek_party_user', 'asitek_party_user.id = asitek_company_vendor.Vendor_Id');
        $builderrecommended->where('asitek_company_vendor.Company_Id', $compeny_id);
        $builderrecommended->groupBy('asitek_company_vendor.Vendor_Id');
        $data_recommended = $builderrecommended->get()->getResult();
        $data['dax14'] =$data_recommended;
        $model15 = new UnitModel();
        $data["dax15"] = $model15->where("compeny_id", $compeny_id)->findAll();
        $model16 = new DepartmentModel();
        $data["dax16"] = $model16->where("compeny_id", $compeny_id)->findAll();
        $model17 = new BillTypeModel();
        $data["dax17"] = $model17->where("compeny_id", $compeny_id)->findAll();
        return view("all_bill_mapping_list", $data);
    }

    //************** Bill End***************
    //**************Mapping Bill Start***************
    public function all_vendor_bill_company_wise($companyid)
    {
        $session = \Config\Services::session();
        $result = $session->get();
        $etm = $result["ddn"];
        $Roll_id = $session->get("Roll_id");
        $emp_id = $session->get("emp_id");

        $model = new CompenyModel();
        $data["companyname"] = $model->getcompanyname($companyid);
        $data["companyid"] = $companyid;

        $data["dax"] = $this->db
            ->query(
                "SELECT asitek_bill_register.*, asitek_employee.emp_u_id, asitek_employee.first_name, asitek_employee.last_name FROM asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id WHERE asitek_bill_register.Vendor_Id='$emp_id' AND asitek_bill_register.compeny_id='$companyid' ORDER BY asitek_bill_register.id DESC"
            )
            ->getResultArray();
        //print_r($data);
        return view("all-vendor-bill-compnay-wise", $data);
    }


    public function all_vendor_bill_rejected($companyid)
    {
        $session = \Config\Services::session();
        $result = $session->get();
        $etm = $result["ddn"];
        $Roll_id = $session->get("Roll_id");
        $emp_id = $session->get("emp_id");

        $model = new CompenyModel();
        $data["companyname"] = $model->getcompanyname($companyid);
        $data["companyid"] = $companyid;

        $data["dax"] = $this->db
            ->query(
                "SELECT asitek_bill_register.*, asitek_employee.emp_u_id, asitek_employee.first_name, asitek_employee.last_name FROM asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id WHERE asitek_bill_register.Vendor_Id='$emp_id' AND asitek_bill_register.compeny_id='$companyid' AND (asitek_bill_register.Bill_Acceptation_Status='3' ) ORDER BY asitek_bill_register.id DESC"
            )
            ->getResultArray();
        //print_r($data);
        return view("all-vendor-bill-compnay-wise", $data);
    }


    public function all_bill_mapping_vendor_list()
    {
        $session = \Config\Services::session();
        $result = $session->get();
        $etm = $result["ddn"];
        $Roll_id = $session->get("Roll_id");
        $emp_id = $session->get("emp_id");
        $compeny_id = $session->get("compeny_id");

        $data["dax"] = $this->db
            ->query(
                "SELECT asitek_bill_register.*, asitek_employee.emp_u_id, asitek_employee.first_name, asitek_employee.last_name, asitek_compeny.name as companyname FROM asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id JOIN asitek_compeny on asitek_bill_register.compeny_id = asitek_compeny.id JOIN asitek_vendor_company ON asitek_compeny.id=asitek_vendor_company.Company_Id WHERE asitek_bill_register.Vendor_Id='$emp_id' ORDER BY asitek_bill_register.id DESC"
            )
            ->getResultArray();
        //print_r($data);
        return view("all-bill-mapping-vendor-list", $data);
    }

    public function update_bill_vendor_comment()
    {
        $validation = \Config\Services::validation();
        $file = $this->request->getFile("E_Image");
        if ($file != "") {
            $validation->setRules([
                "E_Image" =>
                    "uploaded[E_Image]|ext_in[E_Image,jpg,JPG,png,PNG,jpeg,JPEG,pdf]",
            ]); 
            if (!$validation->withRequest($this->request)->run()) {
                $data["error"] = $validation->getErrors();
                $this->index();
                return view("all-bill-mapping-vendor-list");
            } else {
                $imageName = $file->getRandomName();
                $file->move("public/vendors/PicUpload", $imageName);
            }
        } else {
            $imageName = "";
        }

        $data = [
            "Vendor_Comment" => $this->request->getVar("yourcomment"),
            "Vendor_Upload_Image" => $imageName,
        ];
        $emp = new BillRegisterModel();
        if (
            $emp
                ->where("id", $this->request->getVar("id"))
                ->set($data)
                ->update()
        ) {
            $session = \Config\Services::session();
            $session->setFlashdata("emp_up", 1);
            return redirect("all-bill-mapping-vendor-list");
        }
    }

    public function pending_bill_mapping()
    {
        $session = \Config\Services::session();
        $result = $session->get();
        $etm = $result["ddn"];
        $Roll_id = $session->get("Roll_id");
        $emp_id = $session->get("emp_id");

        $data["dax"] = $this->db
            ->query(
                "select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id  where Bill_Acceptation_Status='1'  ORDER BY asitek_bill_register.id desc limit 2000 offset " .
                    $etm
            )
            ->getResultArray();

        $model6 = new StateModel();
        $data["dax6"] = $model6->findAll();
        $model1 = new CityModel();
        $data["dax1"] = $model1->findAll();
        $model9 = new DepartmentModel();
        $data["dax9"] = $model9->findAll();
        $model3 = new EmployeeModel();
        $model14 = new PartyUserModel();
        $data["dax14"] = $model14->findAll();

        $model15 = new UnitModel();
        $data["dax15"] = $model15->findAll();
        $model16 = new DepartmentModel();
        $data["dax16"] = $model16->findAll();
        return view("pending_bill_mapping", $data);
    }

    public function Bill_Acceptation_StatusChange()
    {
        $session = \Config\Services::session();
        $result = $session->get();
        $model = new BillRegisterModel();
        $Bill_Acceptation_Status = $this->request->getVar(
            "Bill_Acceptation_Status"
        );
        $Bill_Acceptation_Status_Comments = $this->request->getVar(
            "Bill_Acceptation_Status_Comments"
        );
        $id = $this->request->getVar("id");
        $action = $this->request->getVar("action");
        //$model->where('id', $id)->set('Department_Id',$Department_Id)->update();
        date_default_timezone_set("Asia/Kolkata");
        echo $Bill_Acceptation_DateTime = date("Y-m-d H:i:s");
        $data = [
            "Bill_Acceptation_Status" => $Bill_Acceptation_Status,
            "Bill_Acceptation_DateTime" => $Bill_Acceptation_DateTime,
            "Bill_Acceptation_Status_Comments" => $Bill_Acceptation_Status_Comments,
        ];
        if (
            $model
                ->where("id", $id)
                ->set($data)
                ->update()
        ) {
            // ****Start RewardPoint**
            $Add_RewardPoint = 20;
            $Remark = $this->request->getVar(
                "Bill_Acceptation_Status_Comments"
            );
            if ($Remark != "") {
                $Remark_RewardPoint = 20;
            } else {
                $Remark_RewardPoint = 0;
            }

               $BillRegObjNew = new BillRegisterModel();
                  $id3 = $this->request->getVar("id");
               $BillRegrow= $BillRegObjNew->where('id', $id3)->first();
               $Bill_DateTime2=$BillRegrow['Bill_DateTime'];
               $currentmonth=date("Y-m-d H:i:s");

               $month = date('m', strtotime($currentmonth));
                $month2 = date('m', strtotime($Bill_DateTime2));
                if($month<=$month2)
                {
                $reward_point =$Add_RewardPoint + $Remark_RewardPoint;
                }
                else
                {
                $reward_point =0;
                }

            $reward_point = $Add_RewardPoint + $Remark_RewardPoint;
            $reward_point_type = "Accept For Bill Assigment";
            $session_compeny_id = $session->get("compeny_id");
            $session_emp_id = $session->get("emp_id");
            $DateTimenew = date("Y-m-d H:i:s");
            $dataRewardPoint = [
                "bill_id" => $id,
                "compeny_id" => $session_compeny_id,
                "emp_id" => $session_emp_id,
                "reward_point" => $reward_point,
                "reward_point_type" => $reward_point_type,
                "rec_time_stamp" => $DateTimenew,
            ];
            $RewardPointobj = new RewardPointModel();
            if ($Bill_Acceptation_Status == 2) {
                $RewardPoint = $RewardPointobj->insert($dataRewardPoint);
            }
            // ****End RewardPoint**
            if ($action == "all") {
                $session->setFlashdata("Bill_Acceptation_Status", 1);
                return redirect("all_bill_mapping_list");
            } elseif ($action == "single") {
                $session->setFlashdata("Bill_Acceptation_Status", 1);
                // return redirect('sigle-bill-mapping-list/5');
                //  return view('sigle-bill-mapping-list');
                // return redirect(base_url()."/sigle-bill-mapping-list/".$id);
                //  return redirect(base_url().'/sigle-bill-mapping-list/2');
                // return redirect('http://bill_Management/sigle-bill-mapping-list/'.$id);
                ?>
                <script type="text/javascript"> 
                    window.location.href="<?php echo base_url(
                        "/index.php/sigle_bill_list/" . $id
                    ); ?>"
                </script>
                <?php
            }
        }
    }

    public function accepted_bill_mapping()
    {
        $session = \Config\Services::session();
        $result = $session->get();
        $etm = $result["ddn"];
        $Roll_id = $session->get("Roll_id");
        $emp_id = $session->get("emp_id");

        $data["dax"] = $this->db
            ->query(
                "select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id  where Bill_Acceptation_Status='2'  ORDER BY asitek_bill_register.id desc limit 2000 offset " .
                    $etm
            )
            ->getResultArray();

        $model6 = new StateModel();
        $data["dax6"] = $model6->findAll();
        $model1 = new CityModel();
        $data["dax1"] = $model1->findAll();
        $model9 = new DepartmentModel();
        $data["dax9"] = $model9->findAll();
        $model3 = new EmployeeModel();
        $model14 = new PartyUserModel();
        $data["dax14"] = $model14->findAll();

        $model15 = new UnitModel();
        $data["dax15"] = $model15->findAll();
        $model16 = new DepartmentModel();
        $data["dax16"] = $model16->findAll();
        $model17 = new BillTypeModel();
        $data["dax17"] = $model17->findAll();
        return view("accepted_bill_mapping", $data);
    }

    public function ajax()
    {
        $session = \Config\Services::session();
        $result = $session->get();
        $compeny_id = $session->get("compeny_id");

        $DepartmentModelObj = new DepartmentModel();
        $EmployeeModelObj = new EmployeeModel();
        $BillRegisterModelObj = new BillRegisterModel();
        $model17 = new BillTypeModel();
        $model18 = new UnitModel();
        $Department_Id = $this->request->getVar("Department_Id");
        $split3 = explode(",", $Department_Id);
        for ($i3 = 0; $i3 < sizeof($split3); $i3++) {
            $idd = $split3[$i3];
            if ($i3 == 0) {
                $Department_Idnew = $split3[$i3];
                $Departmentrow = $DepartmentModelObj
                    ->where("compeny_id", $compeny_id)
                    ->where("id", $idd)
                    ->first();
            } else {
                $Bill_Idnew = $split3[$i3];
                $billrow = $BillRegisterModelObj
                    ->where("compeny_id", $compeny_id)
                    ->where("id", $idd)
                    ->first();
            }
        }
        ?>
        <form method="post" action="<?php echo site_url(
            "/Department_Mapping_BillReg"
        ); ?>">
            <input type="hidden" name="Bill_Idnew" value="<?php echo $Bill_Idnew; ?>">
            <input type="hidden" name="Department_Id" value="<?php echo $Department_Idnew; ?>">
            <input type="hidden" name="Bill_Type" value="<?php echo $Departmentrow[
                "bill_type_id"
            ]; ?>">
           <input type="hidden" name="action" value="all">

            <div class="row">
                <div class="col-sm-12 col-md-6">
                    <div class="form-group">
                        <label>Employee Name(Clear Bill Form Manager)</label>
                            <select name="Department_Emp_Id" class="form-control"  style="padding: 0.875rem 1.375rem" required> 
                                <option value="">-Select -</option> 
                            <?php
                            $Id2 = $Departmentrow["id"];
                            $builderrecommended = $this->db->table("asitek_employee as employee");
                            $builderrecommended->select('employee.*');
                            $builderrecommended->join('asitek_emp_page_access as pageac', 'pageac.Emp_Id = employee.id', 'left');
                            $builderrecommended->where('employee.compeny_id', $compeny_id);
                            $builderrecommended->where('employee.department', $Id2);
                            $builderrecommended->where('pageac.Page_Id', 5);
                            
                            $rowEMP = $builderrecommended->get()->getResult();
                            if (isset($rowEMP) && $rowEMP != "") {
                                foreach ($rowEMP as $rowe) { ?>
                                    <option value="<?php echo $rowe->id; ?>" ><?php echo ucwords($rowe->first_name); ?></option>
                                    <?php }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="form-group">
                        <label>Unit </label>
                        <select name="Unit_Id" class="form-control "style="padding: 0.875rem 1.375rem" id="" required> 
                            <option value="" >select</option>
                            <?php
                            $dax18 = $model18
                                ->where("compeny_id", $compeny_id)
                                ->findAll();
                            if (isset($dax18) && $dax18 != "") {
                                foreach ($dax18 as $row18) { ?>
                                        <option value="<?php echo $row18[
                                            "id"
                                        ]; ?>" <?php if (
    $billrow["Unit_Id"] == $row18["id"]
) {
    echo "selected";
} ?>><?php echo ucwords($row18["name"]); ?></option>
                                        <?php }
                            }
                            ?> 
                        </select>
                    </div> 
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="form-group">
                        <label> Actual Date & Time</label>
                        <input type="text" name="" class="form-control "style="padding: 0.875rem 1.375rem" value="<?php echo $billrow[
                            "DateTime"
                        ]; ?>" readonly > 
                    </div> 
                </div>             
                <div class="col-sm-12 col-md-6">
                    <div class="form-group">
                        <label> TargetTimeToMaping Bill</label>
                        <input type="text" name="TargetMapping_Time_Hours" class="form-control "style="padding: 0.875rem 1.375rem" value="<?php echo $Departmentrow[
                            "Mapping_Time_Hours"
                        ]; ?>" readonly  > 
                    </div> 
                </div>
                <?php
                $time = $Departmentrow["Mapping_Time_Hours"];
                [$hours, $minutes] = explode(":", $time);
                $minitus = (int) $hours * 60 + (int) $minutes;
                $cur_time = $billrow["DateTime"];
                $duration = "+" . $minitus . " minutes";
                $addedDateTime = date(
                    "Y-m-d H:i:s",
                    strtotime($duration, strtotime($cur_time))
                );
                $cur_Datetime = date("Y-m-d H:i:s");
                ?>
                <div class="col-sm-12 col-md-6">
                    <div class="form-group">
                        <label>Delay Or  On-Time</label>
                        <select name="Mapping_Delay_On_Time" class="form-control "style="padding: 0.875rem 1.375rem" > 
                            <?php if ($addedDateTime >= $cur_Datetime) { ?>
                                <option value="On-Time" selected>On-Time</option> 
                                <?php } else { ?>
                                <option value="Delay" selected>Delay</option> 
                                <?php } ?>
                        </select>
                    </div> 
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="form-group">
                        <label>Remark</label>
                        <textarea name="Mapping_Remark" class="form-control"></textarea>
                    </div> 
                </div>
                <div class="col-sm-12 col-md-12">
                    <button type="submit" class="btn btn-warning btn-lg">Mapping</button>
                    <button type="button" class="btn btn-secondary btn-lg" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
        <?php return view("ajax");
    }

    public function ajax_single_mapping()
    {
        $session = \Config\Services::session();
        $result = $session->get();
        $compeny_id = $session->get("compeny_id");
        $DepartmentModelObj = new DepartmentModel();
        $EmployeeModelObj = new EmployeeModel();
        $BillRegisterModelObj = new BillRegisterModel();
        $model17 = new BillTypeModel();
        $model18 = new UnitModel();
        $Department_Id = $this->request->getVar("Department_Id");
        $split3 = explode(",", $Department_Id);
        for ($i3 = 0; $i3 < sizeof($split3); $i3++) {
            $idd = $split3[$i3];
            if ($i3 == 0) {
                $Department_Idnew = $split3[$i3];
                $Departmentrow = $DepartmentModelObj
                    ->where("compeny_id", $compeny_id)
                    ->where("id", $idd)
                    ->first();
            } else {
                $Bill_Idnew = $split3[$i3];
                $billrow = $BillRegisterModelObj
                    ->where("compeny_id", $compeny_id)
                    ->where("id", $idd)
                    ->first();
            }
        }
        ?>
        <form method="post" action="<?php echo site_url(
            "/Department_Mapping_BillReg"
        ); ?>">
            <input type="hidden" name="Bill_Idnew" value="<?php echo $Bill_Idnew; ?>">
            <input type="hidden" name="Department_Id" value="<?php echo $Department_Idnew; ?>">
            <input type="hidden" name="Bill_Type" value="<?php echo $Departmentrow[
                "bill_type_id"
            ]; ?>">
            <input type="hidden" name="action" value="single">
            <div class="row">
                <div class="col-sm-12 col-md-6">
                    <div class="form-group">
                        <label>Employee Name(Clear Bill Form Manager)</label>
                        <select name="Department_Emp_Id" class="form-control"  style="padding: 0.875rem 1.375rem" required> 
                            <option value="">-Select -</option> 
                            <?php
                            $Id2 = $Departmentrow["id"];
                            $builderrecommended = $this->db->table("asitek_employee as employee");
                            $builderrecommended->select('employee.*');
                            $builderrecommended->join('asitek_emp_page_access as pageac', 'pageac.Emp_Id = employee.id', 'left');
                            $builderrecommended->where('employee.compeny_id', $compeny_id);
                            $builderrecommended->where('employee.department', $Id2);
                            $builderrecommended->where('pageac.Page_Id', 5);
                            $rowEMP = $builderrecommended->get()->getResult();
                            if (isset($rowEMP) && $rowEMP != "") {
                                foreach ($rowEMP as $rowe) { ?>
                                    <?php print_r($rowEMP);?>
                                    <option value="<?php echo $rowe->id; ?>"><?php echo ucwords($rowe->first_name); ?></option>
                                <?php }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="form-group">
                        <label>Unit </label>
                        <select name="Unit_Id" class="form-control "style="padding: 0.875rem 1.375rem" id="" required> 
                            <option value="" >select</option>
                            <?php
                            $dax18 = $model18
                                ->where("compeny_id", $compeny_id)
                                ->findAll();
                            if (isset($dax18) && $dax18 != "") {
                                foreach ($dax18 as $row18) { ?>
                                        <option value="<?php echo $row18[
                                            "id"
                                        ]; ?>" <?php if (
    $billrow["Unit_Id"] == $row18["id"]
) {
    echo "selected";
} ?>><?php echo ucwords($row18["name"]); ?></option>
                                        <?php }
                            }
                            ?> 
                        </select>
                    </div> 
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="form-group">
                        <label> Actual Date & Time</label>
                        <input type="text" name="" class="form-control "style="padding: 0.875rem 1.375rem" value="<?php echo $billrow[
                            "DateTime"
                        ]; ?>" readonly > 
                    </div> 
                </div>             
                <div class="col-sm-12 col-md-6">
                    <div class="form-group">
                        <label> TargetTimeToMaping Bill</label>
                        <input type="text" name="TargetMapping_Time_Hours" class="form-control "style="padding: 0.875rem 1.375rem" value="<?php echo $Departmentrow[
                            "Mapping_Time_Hours"
                        ]; ?>" readonly  > 
                    </div> 
                </div>
                <?php
                $time = $Departmentrow["Mapping_Time_Hours"];
                [$hours, $minutes] = explode(":", $time);
                $minitus = (int) $hours * 60 + (int) $minutes;
                $cur_time = $billrow["DateTime"];
                $duration = "+" . $minitus . " minutes";
                $addedDateTime = date(
                    "Y-m-d H:i:s",
                    strtotime($duration, strtotime($cur_time))
                );
                $cur_Datetime = date("Y-m-d H:i:s");
                ?>
                <div class="col-sm-12 col-md-6">
                    <div class="form-group">
                        <label>Delay Or  On-Time</label>
                        <select name="Mapping_Delay_On_Time" class="form-control "style="padding: 0.875rem 1.375rem" > 
                            <?php if ($addedDateTime >= $cur_Datetime) { ?>
                                <option value="On-Time" selected>On-Time</option> 
                                <?php } else { ?>
                                <option value="Delay" selected>Delay</option> 
                                <?php } ?>
                        </select>
                    </div> 
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="form-group">
                        <label>Remark</label>
                        <textarea name="Mapping_Remark" class="form-control"></textarea>
                    </div> 
                </div>
                <div class="col-sm-12 col-md-12">
                    <button type="submit" class="btn btn-warning">Mapping</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
        <?php return view("ajax_single_mapping");
    }

    public function Department_Mapping_BillReg()
    {
        $session = \Config\Services::session();
        $result = $session->get();
        $email = \Config\Services::email();
        $model = new BillRegisterModel();
        $vendormodel = new PartyUserModel();
        $companymodel = new CompenyModel();
        $empmodel = new EmployeeModel();
        $depmodel = new DepartmentModel();
        $id = $this->request->getVar("Bill_Idnew");
        $action = $this->request->getVar("action");
        $data = [
            "Unit_Id" => $this->request->getVar("Unit_Id"),
            "Department_Id" => $this->request->getVar("Department_Id"),
            "Department_Emp_Id" => $this->request->getVar("Department_Emp_Id"),
            "Bill_Acceptation_Status" => 4,
            "Bill_Type" => $this->request->getVar("Bill_Type"),
            "TargetMapping_Time_Hours" => $this->request->getVar(
                "TargetMapping_Time_Hours"
            ),
            "Mapping_Delay_On_Time" => $this->request->getVar(
                "Mapping_Delay_On_Time"
            ),
            "Mapping_Remark" => $this->request->getVar("Mapping_Remark"),
        ];

        $billid = $this->db
            ->query(
                "SELECT id, compeny_id, Vendor_Id from asitek_bill_register WHERE id = '$id'"
            )
            ->getResult(); // Adjust the column name based on your database structure
        $billidvalue = $billid[0]->id;
        $vendorvalue = $billid[0]->Vendor_Id;
        $compnyvalue = $billid[0]->compeny_id;

        $vdr = $vendormodel->where("id", $vendorvalue)->first();
        $cpn = $companymodel->where("id", $compnyvalue)->first();
        $emp = $empmodel
            ->where("id", $this->request->getVar("Department_Emp_Id"))
            ->first();
        $dep = $depmodel
            ->where("id", $this->request->getVar("Department_Id"))
            ->first();

        if (
            $model
                ->where("id", $id)
                ->set($data)
                ->update()
        ) {
            // ****Start RewardPoint**
            $Add_RewardPoint = 20;
            $Remark = $this->request->getVar("Mapping_Remark");
            if ($Remark != "") {
                $Remark_RewardPoint = 20;
            } else {
                $Remark_RewardPoint = 0;
            }
           $BillRegObjNew = new BillRegisterModel();
                  $id3 = $this->request->getVar("Bill_Idnew");
               $BillRegrow= $BillRegObjNew->where('id', $id3)->first();
               $Bill_DateTime2=$BillRegrow['Bill_DateTime'];
               $currentmonth=date("Y-m-d H:i:s");

               $month = date('m', strtotime($currentmonth));
                $month2 = date('m', strtotime($Bill_DateTime2));
                if($month<=$month2)
                {
                $reward_point =
                 $reward_point = $Add_RewardPoint + $Remark_RewardPoint;
                }
                else
                {
                $reward_point =0;
                }
          
            $reward_point_type = "send this bill for verification";
            $session_compeny_id = $session->get("compeny_id");
            $session_emp_id = $session->get("emp_id");
            $DateTimenew = date("Y-m-d H:i:s");
            $dataRewardPoint = [
                "bill_id" => $id,
                "compeny_id" => $session_compeny_id,
                "emp_id" => $session_emp_id,
                "reward_point" => $reward_point,
                "reward_point_type" => $reward_point_type,
                "rec_time_stamp" => $DateTimenew,
            ];
            $RewardPointobj = new RewardPointModel();
            $RewardPoint = $RewardPointobj->insert($dataRewardPoint);

            // ****End RewardPoint**

            if ($action == "all") {
                $session->setFlashdata("Mapping_Department", 1);
                $wpmsg =
                    "Hello " .
                    $vdr["Name"] .
                    ", Just a quick update: going forward, please ensure that all your bills are mapped to, " .
                    $emp["first_name"] .
                    " in the " .
                    $dep["name"] .
                    " Best regards, " .
                    $cpn["name"];
                // $url = "https://chatway.in/api/send-msg?username=ashrishaWCH&number=+91".$vdr['Mobile_No']."&message=".$wpmsg."&token=Y21iQk9IeExwbjluMGE2SUxhM2taQT09";
                // $url = preg_replace("/ /", "%20", $url);
                // $response = file_get_contents($url);

                // $email->setFrom("singhshaan085@gmail.com", "Bill Management");
                // $email->setTo($vdr["Email_Id"]);
                // $email->setSubject("Bill Add in Company | Bill Management");
                // $email->setmailType("html");
                // $email->setMessage($wpmsg); //your message here
                // $email->send();
                return redirect("all_bill_mapping_list");
            } elseif ($action == "single") {

                $session->setFlashdata("Mapping_Department", 1);
                $wpmsg =
                    "Hello " .
                    $vdr["Name"] .
                    ", Just a quick update: going forward, please ensure that all your bills are mapped to, " .
                    $emp["first_name"] .
                    " in the " .
                    $dep["name"] .
                    " Best regards, " .
                    $cpn["name"];
                // $url = "https://chatway.in/api/send-msg?username=ashrishaWCH&number=+91".$vdr['Mobile_No']."&message=".$wpmsg."&token=Y21iQk9IeExwbjluMGE2SUxhM2taQT09";
                // $url = preg_replace("/ /", "%20", $url);
                // $response = file_get_contents($url);

                // $email->setFrom("singhshaan085@gmail.com", "Bill Management");
                // $email->setTo($vdr["Email_Id"]);
                // $email->setSubject("Bill Add in Company | Bill Management");
                // $email->setmailType("html");
                // $email->setMessage($wpmsg); //your message here
                // $email->send();

                //return redirect('all_bill_mapping_list');
                ?>
                <script type="text/javascript"> 
                    window.location.href="<?php echo base_url(
                        "/index.php/sigle_bill_list/" . $id
                    ); ?>"
                </script>
                <?php
            }
        }
    }

    public function done_bill_mapping()
    {
        $session = \Config\Services::session();
        $result = $session->get();
        $etm = $result["ddn"];
        $Roll_id = $session->get("Roll_id");
        $emp_id = $session->get("emp_id");

        $data["dax"] = $this->db
            ->query(
                "select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id  where Bill_Acceptation_Status='4'  ORDER BY asitek_bill_register.id desc limit 2000 offset " .
                    $etm
            )
            ->getResultArray();

        $model6 = new StateModel();
        $data["dax6"] = $model6->findAll();
        $model1 = new CityModel();
        $data["dax1"] = $model1->findAll();
        $model9 = new DepartmentModel();
        $data["dax9"] = $model9->findAll();
        $model3 = new EmployeeModel();
        $model14 = new PartyUserModel();
        $data["dax14"] = $model14->findAll();

        $model15 = new UnitModel();
        $data["dax15"] = $model15->findAll();
        $model16 = new DepartmentModel();
        $data["dax16"] = $model16->findAll();
        $model17 = new BillTypeModel();
        $data["dax17"] = $model17->findAll();
        return view("done_bill_mapping", $data);
    }
    public function reject_bill_mapping()
    {
        $session = \Config\Services::session();
        $result = $session->get();
        $etm = $result["ddn"];
        $Roll_id = $session->get("Roll_id");
        $emp_id = $session->get("emp_id");

        $data["dax"] = $this->db
            ->query(
                "select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id  where Bill_Acceptation_Status='3'  ORDER BY asitek_bill_register.id desc limit 20 offset " .
                    $etm
            )
            ->getResultArray();

        $model6 = new StateModel();
        $data["dax6"] = $model6->findAll();
        $model1 = new CityModel();
        $data["dax1"] = $model1->findAll();
        $model9 = new DepartmentModel();
        $data["dax9"] = $model9->findAll();
        $model3 = new EmployeeModel();
        $model14 = new PartyUserModel();
        $data["dax14"] = $model14->findAll();

        $model15 = new UnitModel();
        $data["dax15"] = $model15->findAll();
        $model16 = new DepartmentModel();
        $data["dax16"] = $model16->findAll();
        return view("reject_bill_mapping", $data);
    }
    //**************Mapping Bill End***************

    //**************Clear_Bill_Form Bill Start***************

    public function all_Clear_Bill_Form_list()
    {
        $session = \Config\Services::session();
        $result = $session->get();
        $etm = $result["ddn"];
        $Roll_id = $session->get("Roll_id");
        $emp_id = $session->get("emp_id");
        $compeny_id = $session->get("compeny_id");
        
        if (isset($_GET["Unit_Id"])) {
            $Unit_Id = $_GET["Unit_Id"];
        } else {
            $Unit_Id = "";
        }
        if (isset($_GET["Vendor_Id"])) {
            $Vendor_Id = $_GET["Vendor_Id"];
        } else {
            $Vendor_Id = "";
        }

        if (isset($_GET["assignedto"])) {
            $assignedto = $_GET["assignedto"];
        } else {
            $assignedto = "";
        }
        
        if (isset($_GET["Satus"])) {
            $Satus = $_GET["Satus"];
        } else {
            $Satus = "";
        }
        
        // Admin Role
        if ($Roll_id == 1) {
            if(!empty($Unit_Id) && empty($Vendor_Id) && empty($assignedto) && !empty($Satus)){
                if ($Satus == "All") {
                $data["dax"] = $this->db->query("select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id where asitek_bill_register.compeny_id='$compeny_id' and Bill_Acceptation_Status='4' and  asitek_bill_register.Unit_Id='$Unit_Id'  ORDER BY asitek_bill_register.id desc ")->getResultArray();
                } else {
                    $data["dax"] = $this->db->query("select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id where asitek_bill_register.compeny_id='$compeny_id' and  Bill_Acceptation_Status='4' and Clear_Bill_Form_Status='$Satus' and asitek_bill_register.Unit_Id='$Unit_Id'  ORDER BY asitek_bill_register.id desc")->getResultArray();
                }
            }
            
            
            if(empty($Unit_Id) && !empty($Vendor_Id) && empty($assignedto) && !empty($Satus)){
                if ($Satus == "All") {
                    $data["dax"] = $this->db->query("select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id where asitek_bill_register.compeny_id='$compeny_id' and Bill_Acceptation_Status='4'  and asitek_bill_register.Vendor_Id='$Vendor_Id'  ORDER BY asitek_bill_register.id desc ")->getResultArray();
                } else {
                    $data["dax"] = $this->db->query("select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id where asitek_bill_register.compeny_id='$compeny_id' and Bill_Acceptation_Status='4' and Clear_Bill_Form_Status='$Satus' and asitek_bill_register.Vendor_Id='$Vendor_Id' ORDER BY asitek_bill_register.id desc")->getResultArray();
                }
            }
            
            if(empty($Unit_Id) && empty($Vendor_Id) && !empty($assignedto) && !empty($Satus)){
                if ($Satus == "All") {
                    $data["dax"] = $this->db->query("select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id where asitek_bill_register.compeny_id='$compeny_id' and Bill_Acceptation_Status='4' and asitek_bill_register.Department_Emp_Id='$assignedto' ORDER BY asitek_bill_register.id desc ")->getResultArray();
                } else {
                    $data["dax"] = $this->db->query("select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id where asitek_bill_register.compeny_id='$compeny_id' and Bill_Acceptation_Status='4' and Clear_Bill_Form_Status='$Satus'  and asitek_bill_register.Department_Emp_Id='$assignedto'  ORDER BY asitek_bill_register.id desc")->getResultArray();
                }
            }

            if(empty($Unit_Id) && empty($Vendor_Id) && empty($assignedto) && !empty($Satus)){
                if ($Satus == "All") {
                    $data["dax"] = $this->db->query("select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id where asitek_bill_register.compeny_id='$compeny_id' and  Bill_Acceptation_Status='4'   ORDER BY asitek_bill_register.id desc ")->getResultArray();
                } else {
                    $data["dax"] = $this->db->query("select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id where asitek_bill_register.compeny_id='$compeny_id' and  Bill_Acceptation_Status='4' and Clear_Bill_Form_Status='$Satus'  ORDER BY asitek_bill_register.id desc")->getResultArray();
                }
            }
            if(empty($Unit_Id) && empty($Vendor_Id) && empty($assignedto) && empty($Satus)){
                $data["dax"] = $this->db->query("select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id where asitek_bill_register.compeny_id='$compeny_id' and  Bill_Acceptation_Status='4'   ORDER BY asitek_bill_register.id desc ")->getResultArray();
            }
        }
        //Admin Role End
        //Other Roll Strat
        else {
            if(!empty($Unit_Id) && empty($Vendor_Id) && empty($assignedto) && !empty($Satus)){
                if ($Satus == "All") {
                    $data["dax"] = $this->db->query("select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id where asitek_bill_register.compeny_id='$compeny_id' and  Bill_Acceptation_Status='4' and  asitek_bill_register.Unit_Id='$Unit_Id'  and Department_Emp_Id='$emp_id' ORDER BY asitek_bill_register.id desc ")->getResultArray();
                } else {
                    $data["dax"] = $this->db->query("select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id where asitek_bill_register.compeny_id='$compeny_id' and  Bill_Acceptation_Status='4' and Clear_Bill_Form_Status='$Satus' and asitek_bill_register.Unit_Id='$Unit_Id' and Department_Emp_Id='$emp_id' ORDER BY asitek_bill_register.id desc")->getResultArray();
                }
            }
            if(empty($Unit_Id) && !empty($Vendor_Id) && empty($assignedto) && !empty($Satus)){
                if ($Satus == "All") {
                    $data["dax"] = $this->db->query("select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id where asitek_bill_register.compeny_id='$compeny_id' and  Bill_Acceptation_Status='4'  and asitek_bill_register.Vendor_Id='$Vendor_Id' and Department_Emp_Id='$emp_id' ORDER BY asitek_bill_register.id desc ")->getResultArray();
                } else {
                    $data["dax"] = $this->db->query("select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id where asitek_bill_register.compeny_id='$compeny_id' and  Bill_Acceptation_Status='4' and Clear_Bill_Form_Status='$Satus' and asitek_bill_register.Vendor_Id='$Vendor_Id' and Department_Emp_Id='$emp_id' ORDER BY asitek_bill_register.id desc")->getResultArray();
                }
            }
            if(empty($Unit_Id) && empty($Vendor_Id) && !empty($assignedto) && !empty($Satus)){
                if ($Satus == "All") {
                    $data["dax"] = $this->db->query("select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id where asitek_bill_register.compeny_id='$compeny_id' and  Bill_Acceptation_Status='4' and Department_Emp_Id='$emp_id' ORDER BY asitek_bill_register.id desc ")->getResultArray();
                } else {
                    $data["dax"] = $this->db->query("select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id where asitek_bill_register.compeny_id='$compeny_id' and Bill_Acceptation_Status='4' and Clear_Bill_Form_Status='$Satus' and Department_Emp_Id='$emp_id'  ORDER BY asitek_bill_register.id desc")->getResultArray();
                }
            }
            if(empty($Unit_Id) && empty($Vendor_Id) && empty($assignedto) && !empty($Satus)){
                if ($Satus == "All") {
                    $data["dax"] = $this->db->query("select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id where asitek_bill_register.compeny_id='$compeny_id' and  Bill_Acceptation_Status='4' and Department_Emp_Id='$emp_id'  ORDER BY asitek_bill_register.id desc ")->getResultArray();
                } else {
                    $data["dax"] = $this->db->query("select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id where asitek_bill_register.compeny_id='$compeny_id' and  Bill_Acceptation_Status='4' and Clear_Bill_Form_Status='$Satus' and Department_Emp_Id='$emp_id' ORDER BY asitek_bill_register.id desc")->getResultArray();
                }
            }
            if(empty($Unit_Id) && empty($Vendor_Id) && empty($assignedto) && empty($Satus)){
                $data["dax"] = $this->db->query("select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id where asitek_bill_register.compeny_id='$compeny_id' and  Bill_Acceptation_Status='4' and Department_Emp_Id='$emp_id' ORDER BY asitek_bill_register.id desc ")->getResultArray();
            }
        }
        $model6 = new StateModel();
        $data["dax6"] = $model6->findAll();
        $model1 = new CityModel();
        $data["dax1"] = $model1->findAll();
        $model9 = new DepartmentModel();
        $data["dax9"] = $model9->where("compeny_id", $compeny_id)->findAll();
        $model3 = new EmployeeModel();
        $builderrecommended = $this->db->table("asitek_company_vendor");
        $builderrecommended->select('asitek_company_vendor.Vendor_Id, asitek_party_user.id, asitek_party_user.GST_No, asitek_party_user.Name');
        $builderrecommended->join('asitek_party_user', 'asitek_party_user.id = asitek_company_vendor.Vendor_Id');
        $builderrecommended->where('asitek_company_vendor.Company_Id', $compeny_id);
        $builderrecommended->groupBy('asitek_company_vendor.Vendor_Id');
        $data_recommended = $builderrecommended->get()->getResult();
        $data['dax14'] =$data_recommended;
        $model15 = new UnitModel();
        $data["dax15"] = $model15->where("compeny_id", $compeny_id)->findAll();
        $model16 = new DepartmentModel();
        $data["dax16"] = $model16->where("compeny_id", $compeny_id)->findAll();
        return view("all_Clear_Bill_Form_list", $data);
    }

    public function all_Clear_Bill_Form_vendor_list()
    {
        $session = \Config\Services::session();
        $result = $session->get();
        $etm = $result["ddn"];
        $Roll_id = $session->get("Roll_id");
        $emp_id = $session->get("emp_id");
        $compeny_id = $session->get("compeny_id");

        $data["dax"] = $this->db
            ->query(
                "select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name, asitek_compeny.name as companyname from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id JOIN asitek_compeny on asitek_bill_register.compeny_id = asitek_compeny.id where asitek_bill_register.Vendor_Id='$emp_id' and Bill_Acceptation_Status='4' ORDER BY asitek_bill_register.id desc"
            )
            ->getResultArray();

        return view("all_Clear_Bill_Form_vendor_list", $data);
    }

    public function pending_Clear_Bill_Form()
    {
        $session = \Config\Services::session();
        $result = $session->get();
        $etm = $result["ddn"];
        $Roll_id = $session->get("Roll_id");
        $emp_id = $session->get("emp_id");

        $data["dax"] = $this->db
            ->query(
                "select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id  where Bill_Acceptation_Status='4'  and Clear_Bill_Form_Status='1' ORDER BY asitek_bill_register.id desc limit 2000 offset " .
                    $etm
            )
            ->getResultArray();

        $model6 = new StateModel();
        $data["dax6"] = $model6->findAll();
        $model1 = new CityModel();
        $data["dax1"] = $model1->findAll();
        $model9 = new DepartmentModel();
        $data["dax9"] = $model9->findAll();
        $model3 = new EmployeeModel();
        $model14 = new PartyUserModel();
        $data["dax14"] = $model14->findAll();

        $model15 = new UnitModel();
        $data["dax15"] = $model15->findAll();
        $model16 = new DepartmentModel();
        $data["dax16"] = $model16->findAll();
        return view("pending_Clear_Bill_Form", $data);
    }

    public function Clear_Bill_Form_StatusChange()
    {
        $session = \Config\Services::session();
        $result = $session->get();
        $model = new BillRegisterModel();
        $id = $this->request->getVar("id");
        $action = $this->request->getVar("action");
        date_default_timezone_set("Asia/Kolkata");
        $Clear_Bill_Form_DateTime = date("Y-m-d H:i:s");
        $data = [
            "Clear_Bill_Form_Status" => $this->request->getVar(
                "Clear_Bill_Form_Status"
            ),
            "Clear_Bill_Form_DateTime" => $Clear_Bill_Form_DateTime,
            "Clear_Bill_Form_Status_Comments" => $this->request->getVar(
                "Clear_Bill_Form_Status_Comments"
            ),
        ];

        if (
            $model
                ->where("id", $id)
                ->set($data)
                ->update()
        ) {
            // ****Start RewardPoint**
            $Add_RewardPoint = 10;
            $Remark = $this->request->getVar("Clear_Bill_Form_Status_Comments");
            if ($Remark != "") {
                $Remark_RewardPoint = 10;
            } else {
                $Remark_RewardPoint = 0;
            }
             $BillRegObjNew = new BillRegisterModel();
               $BillRegrow= $BillRegObjNew->where('id', $id)->first();
               $Bill_DateTime2=$BillRegrow['Bill_DateTime'];
               $currentmonth=date("Y-m-d H:i:s");
               
               $month = date('m', strtotime($currentmonth));
                $month2 = date('m', strtotime($Bill_DateTime2));
                if($month<=$month2)
                {
                $reward_point =
                   $reward_point = $Add_RewardPoint + $Remark_RewardPoint;
                }
                else
                {
                $reward_point =0;
                }

         
            $reward_point_type = "Accept For Bill Verfiy";
            $session_compeny_id = $session->get("compeny_id");
            $session_emp_id = $session->get("emp_id");
            $DateTimenew = date("Y-m-d H:i:s");
            $dataRewardPoint = [
                "bill_id" => $id,
                "compeny_id" => $session_compeny_id,
                "emp_id" => $session_emp_id,
                "reward_point" => $reward_point,
                "reward_point_type" => $reward_point_type,
                "rec_time_stamp" => $DateTimenew,
            ];
            $RewardPointobj = new RewardPointModel();
            $Clear_Bill_Form_Status = $this->request->getVar(
                "Clear_Bill_Form_Status"
            );
            if ($Clear_Bill_Form_Status == 2) {
                $RewardPoint = $RewardPointobj->insert($dataRewardPoint);
            }
            // ****End RewardPoint**

            if ($action == "all") {
                $session->setFlashdata("pending_Clear_Bill_Form", 1);
                return redirect("all_Clear_Bill_Form_list");
            } elseif ($action == "single") {
                $session->setFlashdata("pending_Clear_Bill_Form", 1); ?>
                <script type="text/javascript"> 
                    alert('Successfully Change Status');
                    window.location.href="<?php echo base_url(
                        "/index.php/sigle_bill_list/" . $id
                    ); ?>"
                </script>
                <?php
            }
        }
    }

    public function accepted_Clear_Bill_Form()
    {
        $session = \Config\Services::session();
        $result = $session->get();
        $etm = $result["ddn"];
        $Roll_id = $session->get("Roll_id");
        $emp_id = $session->get("emp_id");

        $data["dax"] = $this->db
            ->query(
                "select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id  where Bill_Acceptation_Status='4' and Clear_Bill_Form_Status='2'  ORDER BY asitek_bill_register.id desc limit 2000 offset " .
                    $etm
            )
            ->getResultArray();

        $model6 = new StateModel();
        $data["dax6"] = $model6->findAll();
        $model1 = new CityModel();
        $data["dax1"] = $model1->findAll();
        $model9 = new DepartmentModel();
        $data["dax9"] = $model9->findAll();
        $model3 = new EmployeeModel();
        $model14 = new PartyUserModel();
        $data["dax14"] = $model14->findAll();

        $model15 = new UnitModel();
        $data["dax15"] = $model15->findAll();
        $model16 = new DepartmentModel();
        $data["dax16"] = $model16->findAll();
        $model17 = new BillTypeModel();
        $data["dax17"] = $model17->findAll();
        return view("accepted_Clear_Bill_Form", $data);
    }

    public function MasterAction_send()
    {
        $session = \Config\Services::session();
        $result = $session->get();
        $compeny_id = $session->get("compeny_id");
        $model = new BillRegisterModel();
        $MasterActionmadelObj = new MasterActionModel();
        $MasterActionUploadModelObj = new MasterActionUploadModel();
        $id = $this->request->getVar("id");
        $stage_id = $this->request->getVar("stage_id");
        $Master_ActionId = $this->request->getVar("Master_ActionId");
        $remark = $this->request->getVar("remark");
        $action = $this->request->getVar("action");
        $validation = \Config\Services::validation();
        $file = $this->request->getFile("E_Image");
        if ($file != "") {
            $validation->setRules([
                "E_Image" =>
                    "uploaded[E_Image]|ext_in[E_Image,jpg,JPG,png,PNG,jpeg,JPEG,pdf]",
            ]);
            if (!$validation->withRequest($this->request)->run()) {
                $data["error"] = $validation->getErrors();
                $this->index();
                if ($stage_id == 3) {
                    if ($action == "all") {
                        return view("all_Clear_Bill_Form_list");
                    } elseif ($action == "single") { ?>
                        <script type="text/javascript"> 
                            // alert('Successfully Change Status');
                            window.location.href="<?php echo base_url(
                                "/index.php/sigle_bill_list/" . $id
                            ); ?>"
                        </script>
                        <?php }
                } elseif ($stage_id == 4) {
                    if ($action == "all") {
                        return view("all_erpStystem_list");
                    } elseif ($action == "single") { ?>
                        <script type="text/javascript"> 
                            // alert('Successfully Change Status');
                            window.location.href="<?php echo base_url(
                                "/index.php/sigle_bill_list/" . $id
                            ); ?>"
                        </script>
                        <?php }
                } elseif ($stage_id == 5) {
                    if ($action == "all") {
                        return view("all_recived_bill_list");
                    } elseif ($action == "single") { ?>
                        <script type="text/javascript"> 
                            // alert('Successfully Change Status');
                            window.location.href="<?php echo base_url(
                                "/index.php/sigle_bill_list/" . $id
                            ); ?>"
                        </script>
                        <?php }
                }
            } else {
                $imageName = $file->getRandomName();
                $file->move("public/vendors/PicUploadMasterAction", $imageName);
            }
        } else {
            $imageName = "";
        }
        $rowMasterAction1 = $MasterActionmadelObj
            ->where("stage_id", $stage_id)
            ->where("id", $Master_ActionId)
            ->first();
        echo $imageName;
        $data2 = [
            "compeny_id" => $compeny_id,
            "bill_id" => $id,
            "master_action_id" => $Master_ActionId,
            "image_upload" => $imageName,
            "remark" => $remark,
        ];
        $insert = $MasterActionUploadModelObj->insert($data2);

        if ($insert) {
            if ($stage_id == 3) {
                $model
                    ->where("id", $id)
                    ->set(
                        "ClearFormBill_Master_Action",
                        $rowMasterAction1["no_of_action"]
                    )
                    ->update();
                // ****Start RewardPoint**
                $MasterActionmadelObj = new MasterActionModel();
                $rowMasterAction1 = $MasterActionmadelObj
                    ->where("compeny_id", $compeny_id)
                    ->where("stage_id", $stage_id)
                    ->orderBy("id", "desc")
                    ->first();
                if (isset($rowMasterAction1) && $rowMasterAction1 != "") {
                    if ($rowMasterAction1["id"] == $Master_ActionId) {
                        $Add_RewardPoint = 10;
                        $Remark = $this->request->getVar("remark");
                        if ($Remark != "") {
                            $Remark_RewardPoint = 10;
                        } else {
                            $Remark_RewardPoint = 0;
                        }
                        $E_Image = $this->request->getFile("E_Image");
                        if ($E_Image != "") {
                            $FileAttch_RewardPoint = 10;
                        } else {
                            $FileAttch_RewardPoint = 0;
                        }
                       
                          $BillRegObjNew = new BillRegisterModel();
                          $id3 = $this->request->getVar("id");
                           $BillRegrow= $BillRegObjNew->where('id', $id3)->first();
                           $Bill_DateTime2=$BillRegrow['Bill_DateTime'];
                           $currentmonth=date("Y-m-d H:i:s");
                           
                           $month = date('m', strtotime($currentmonth));
                            $month2 = date('m', strtotime($Bill_DateTime2));
                            if($month<=$month2)
                            {
                            $reward_point =
                               $reward_point =  $Add_RewardPoint + $Remark_RewardPoint +$FileAttch_RewardPoint;
                            }
                            else
                            {
                            $reward_point =0;
                            }


                        $reward_point_type = "Master Action Bill Verfiy";
                        $session_compeny_id = $session->get("compeny_id");
                        $session_emp_id = $session->get("emp_id");
                        $DateTimenew = date("Y-m-d H:i:s");
                        $dataRewardPoint = [
                            "bill_id" => $id,
                            "compeny_id" => $session_compeny_id,
                            "emp_id" => $session_emp_id,
                            "reward_point" => $reward_point,
                            "reward_point_type" => $reward_point_type,
                            "rec_time_stamp" => $DateTimenew,
                        ];
                        $RewardPointobj = new RewardPointModel();
                        $RewardPoint = $RewardPointobj->insert(
                            $dataRewardPoint
                        );
                    } else {
                    }
                }

                // ****End  RewardPoint**

                if ($action == "all") {
                    $session->setFlashdata("Master_Action_SMS", 1);
                    return redirect("all_Clear_Bill_Form_list");
                } elseif ($action == "single") { ?>
                    <script type="text/javascript"> 
                        alert('Successfully ');
                        window.location.href="<?php echo base_url(
                            "/index.php/sigle_bill_list/" . $id
                        ); ?>"
                    </script>
                    <?php }
            } elseif ($stage_id == 4) {
                $model
                    ->where("id", $id)
                    ->set(
                        "ERP_Master_Action",
                        $rowMasterAction1["no_of_action"]
                    )
                    ->update();

                // ****Start RewardPoint**

                $MasterActionmadelObj = new MasterActionModel();
                $rowMasterAction1 = $MasterActionmadelObj
                    ->where("compeny_id", $compeny_id)
                    ->where("stage_id", $stage_id)
                    ->orderBy("id", "desc")
                    ->first();
                if (isset($rowMasterAction1) && $rowMasterAction1 != "") {
                    if ($rowMasterAction1["id"] == $Master_ActionId) {
                        $Add_RewardPoint = 10;
                        $Remark = $this->request->getVar("remark");
                        if ($Remark != "") {
                            $Remark_RewardPoint = 10;
                        } else {
                            $Remark_RewardPoint = 0;
                        }
                        $E_Image = $this->request->getFile("E_Image");
                        if ($E_Image != "") {
                            $FileAttch_RewardPoint = 10;
                        } else {
                            $FileAttch_RewardPoint = 0;
                        }
                       

                           $BillRegObjNew = new BillRegisterModel();
                          $id3 = $this->request->getVar("id");
                           $BillRegrow= $BillRegObjNew->where('id', $id3)->first();
                           $Bill_DateTime2=$BillRegrow['Bill_DateTime'];
                           $currentmonth=date("Y-m-d H:i:s");
                           
                           $month = date('m', strtotime($currentmonth));
                            $month2 = date('m', strtotime($Bill_DateTime2));
                            if($month<=$month2)
                            {
                            $reward_point =
                               $reward_point =  $Add_RewardPoint + $Remark_RewardPoint +$FileAttch_RewardPoint;
                            }
                            else
                            {
                            $reward_point =0;
                            }

                        $reward_point_type = "Master Action Bill Entity";
                        $session_compeny_id = $session->get("compeny_id");
                        $session_emp_id = $session->get("emp_id");
                        $DateTimenew = date("Y-m-d H:i:s");
                        $dataRewardPoint = [
                            "bill_id" => $id,
                            "compeny_id" => $session_compeny_id,
                            "emp_id" => $session_emp_id,
                            "reward_point" => $reward_point,
                            "reward_point_type" => $reward_point_type,
                            "rec_time_stamp" => $DateTimenew,
                        ];
                        $RewardPointobj = new RewardPointModel();
                        $RewardPoint = $RewardPointobj->insert(
                            $dataRewardPoint
                        );
                    } else {
                    }
                }

                // ****End  RewardPoint**

                if ($action == "all") {
                    $session->setFlashdata("Master_Action_SMS", 1);
                    return redirect("all_erpStystem_list");
                } elseif ($action == "single") { ?>
                    <script type="text/javascript"> 
                        alert('Successfully ');
                        window.location.href="<?php echo base_url(
                            "/index.php/sigle_bill_list/" . $id
                        ); ?>"
                    </script>
                    <?php }
            } elseif ($stage_id == 5) {
                $model
                    ->where("id", $id)
                    ->set(
                        "Recived_Master_Action",
                        $rowMasterAction1["no_of_action"]
                    )
                    ->update();

                // ****Start RewardPoint**
                $MasterActionmadelObj = new MasterActionModel();
                $rowMasterAction1 = $MasterActionmadelObj
                    ->where("compeny_id", $compeny_id)
                    ->where("stage_id", $stage_id)
                    ->orderBy("id", "desc")
                    ->first();
                if (isset($rowMasterAction1) && $rowMasterAction1 != "") {
                    if ($rowMasterAction1["id"] == $Master_ActionId) {
                        $Add_RewardPoint = 10;
                        $Remark = $this->request->getVar("remark");
                        if ($Remark != "") {
                            $Remark_RewardPoint = 10;
                        } else {
                            $Remark_RewardPoint = 0;
                        }
                        $E_Image = $this->request->getFile("E_Image");
                        if ($E_Image != "") {
                            $FileAttch_RewardPoint = 10;
                        } else {
                            $FileAttch_RewardPoint = 0;
                        }

                         $BillRegObjNew = new BillRegisterModel();
                          $id3 = $this->request->getVar("id");
                           $BillRegrow= $BillRegObjNew->where('id', $id3)->first();
                           $Bill_DateTime2=$BillRegrow['Bill_DateTime'];
                           $currentmonth=date("Y-m-d H:i:s");
                           
                           $month = date('m', strtotime($currentmonth));
                            $month2 = date('m', strtotime($Bill_DateTime2));
                            if($month<=$month2)
                            {
                            $reward_point =
                               $reward_point =  $Add_RewardPoint + $Remark_RewardPoint +$FileAttch_RewardPoint;
                            }
                            else
                            {
                            $reward_point =0;
                            }

                        $reward_point_type = "Master Action Bill Recived A/C";
                        $session_compeny_id = $session->get("compeny_id");
                        $session_emp_id = $session->get("emp_id");
                        $DateTimenew = date("Y-m-d H:i:s");
                        $dataRewardPoint = [
                            "bill_id" => $id,
                            "compeny_id" => $session_compeny_id,
                            "emp_id" => $session_emp_id,
                            "reward_point" => $reward_point,
                            "reward_point_type" => $reward_point_type,
                            "rec_time_stamp" => $DateTimenew,
                        ];
                        $RewardPointobj = new RewardPointModel();
                        $RewardPoint = $RewardPointobj->insert(
                            $dataRewardPoint
                        );
                    } else {
                    }
                }

                // ****End  RewardPoint**
                if ($action == "all") {
                    $session->setFlashdata("Master_Action_SMS", 1);
                    return redirect("all_recived_bill_list");
                } elseif ($action == "single") { ?>
                    <script type="text/javascript"> 
                        alert('Successfully ');
                        window.location.href="<?php echo base_url(
                            "/index.php/sigle_bill_list/" . $id
                        ); ?>"
                    </script>
                    <?php }
            }
        }
    }

    public function CheckUp_Clear_Bill_Form()
    {
        $session = \Config\Services::session();
        $result = $session->get();
        $email = \Config\Services::email();
        $model = new BillRegisterModel();
        $vendormodel = new PartyUserModel();
        $companymodel = new CompenyModel();
        $id = $this->request->getVar("id");
        $action = $this->request->getVar("action");
        $validation = \Config\Services::validation();
        $file = $this->request->getFile("E_Image");
        if ($file != "") {
            $validation->setRules([
                "E_Image" =>
                    "uploaded[E_Image]|ext_in[E_Image,jpg,JPG,png,PNG,jpeg,JPEG,pdf]",
            ]);
            if (!$validation->withRequest($this->request)->run()) {
                $data["error"] = $validation->getErrors();
                $this->index();
                return view("add_bill_register");
            } else {
                $imageName = $file->getRandomName();
                $file->move("public/vendors/PicUpload", $imageName);
            }
        } else {
            $imageName = "";
        }
        $data = [
            "Mapping_ERP_EmpId" => $this->request->getVar("Mapping_ERP_EmpId"),
            "Clear_Bill_Form_Status" => 4,
            "TargetClearBillForm_Time_Hours" => $this->request->getVar(
                "TargetClearBillForm_Time_Hours"
            ),

            "ClearBillForm_Delay_On_Time" => $this->request->getVar(
                "ClearBillForm_Delay_On_Time"
            ),
            "Clear_Bill_Form_AnyImage" => $imageName,
            "ClearBillForm_Remark" => $this->request->getVar(
                "ClearBillForm_Remark"
            ),
        ];

        $billid = $this->db
            ->query(
                "SELECT compeny_id, Vendor_Id from asitek_bill_register WHERE id = '$id'"
            )
            ->getResult(); // Adjust the column name based on your database structure
        $vendorvalue = $billid[0]->Vendor_Id;
        $compnyvalue = $billid[0]->compeny_id;

        $vdr = $vendormodel->where("id", $vendorvalue)->first();
        $cpn = $companymodel->where("id", $compnyvalue)->first();

        if (
            $model
                ->where("id", $id)
                ->set($data)
                ->update()
        ) {
            // ****Start RewardPoint**
            $Add_RewardPoint = 10;
            $Remark = $this->request->getVar("ClearBillForm_Remark");
            if ($Remark != "") {
                $Remark_RewardPoint = 10;
            } else {
                $Remark_RewardPoint = 0;
            }
            $E_Image = $this->request->getFile("E_Image");
            if ($E_Image != "") {
                $FileAttch_RewardPoint = 10;
            } else {
                $FileAttch_RewardPoint = 0;
            }
              $BillRegObjNew = new BillRegisterModel();
                          $id3 = $this->request->getVar("id");
                           $BillRegrow= $BillRegObjNew->where('id', $id3)->first();
                           $Bill_DateTime2=$BillRegrow['Bill_DateTime'];
                           $currentmonth=date("Y-m-d H:i:s");
                           
                           $month = date('m', strtotime($currentmonth));
                            $month2 = date('m', strtotime($Bill_DateTime2));
                            if($month<=$month2)
                            {
                             $reward_point =  $Add_RewardPoint + $Remark_RewardPoint + $FileAttch_RewardPoint;
                            }
                            else
                            {
                            $reward_point =0;
                            }

           
            $reward_point_type = "send this bill for entry process (forward)";
            $session_compeny_id = $session->get("compeny_id");
            $session_emp_id = $session->get("emp_id");
            $DateTimenew = date("Y-m-d H:i:s");
            $dataRewardPoint = [
                "bill_id" => $id,
                "compeny_id" => $session_compeny_id,
                "emp_id" => $session_emp_id,
                "reward_point" => $reward_point,
                "reward_point_type" => $reward_point_type,
                "rec_time_stamp" => $DateTimenew,
            ];
            $RewardPointobj = new RewardPointModel();
            $RewardPoint = $RewardPointobj->insert($dataRewardPoint);
            // ****End RewardPoint**
            if ($action == "all") {
                $wpmsg =
                    "Dear " .
                    $vdr["Name"] .
                    ", We're delighted to inform you that your bill has been verified by the relevant department and has been forwarded to our ERP system for entry. Thank you for your prompt submission and cooperation! Best regards, " .
                    $cpn["name"];
                // $url = "https://chatway.in/api/send-msg?username=ashrishaWCH&number=+91".$vdr['Mobile_No']."&message=".$wpmsg."&token=Y21iQk9IeExwbjluMGE2SUxhM2taQT09";
                // $url = preg_replace("/ /", "%20", $url);
                // $response = file_get_contents($url);

                // $email->setFrom("singhshaan085@gmail.com", "Bill Management");
                // $email->setTo($vdr["Email_Id"]);
                // $email->setSubject("Bill Add in Company | Bill Management");
                // $email->setmailType("html");
                // $email->setMessage($wpmsg); //your message here
                // $email->send();

                $session->setFlashdata("Mapping_Department", 1);
                return redirect("all_Clear_Bill_Form_list");
            } elseif ($action == "single") {

                $wpmsg =
                    "Dear " .
                    $vdr["Name"] .
                    ", We're delighted to inform you that your bill has been verified by the relevant department and has been forwarded to our ERP system for entry. Thank you for your prompt submission and cooperation! Best regards, " .
                    $cpn["name"];
                // $url = "https://chatway.in/api/send-msg?username=ashrishaWCH&number=+91".$vdr['Mobile_No']."&message=".$wpmsg."&token=Y21iQk9IeExwbjluMGE2SUxhM2taQT09";
                // $url = preg_replace("/ /", "%20", $url);
                // $response = file_get_contents($url);

                // $email->setFrom("singhshaan085@gmail.com", "Bill Management");
                // $email->setTo($vdr["Email_Id"]);
                // $email->setSubject("Bill Add in Company | Bill Management");
                // $email->setmailType("html");
                // $email->setMessage($wpmsg); //your message here
                // $email->send();
                ?>
                <script type="text/javascript"> 
                    alert('Successfully ');
                    window.location.href="<?php echo base_url(
                        "/index.php/sigle_bill_list/" . $id
                    ); ?>"
                </script>
                <?php
            }
        }
    }

    public function done_Clear_Bill_Form()
    {
        $session = \Config\Services::session();
        $result = $session->get();
        $etm = $result["ddn"];
        $Roll_id = $session->get("Roll_id");
        $emp_id = $session->get("emp_id");

        $data["dax"] = $this->db
            ->query(
                "select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id  where Bill_Acceptation_Status='4' and Clear_Bill_Form_Status='4'  ORDER BY asitek_bill_register.id desc limit 2000 offset " .
                    $etm
            )
            ->getResultArray();

        $model6 = new StateModel();
        $data["dax6"] = $model6->findAll();
        $model1 = new CityModel();
        $data["dax1"] = $model1->findAll();
        $model9 = new DepartmentModel();
        $data["dax9"] = $model9->findAll();
        $model3 = new EmployeeModel();
        $model14 = new PartyUserModel();
        $data["dax14"] = $model14->findAll();

        $model15 = new UnitModel();
        $data["dax15"] = $model15->findAll();
        $model16 = new DepartmentModel();
        $data["dax16"] = $model16->findAll();
        $model17 = new BillTypeModel();
        $data["dax17"] = $model17->findAll();
        return view("done_Clear_Bill_Form", $data);
    }

    public function reject_Clear_Bill_Form()
    {
        $session = \Config\Services::session();
        $result = $session->get();
        $etm = $result["ddn"];
        $Roll_id = $session->get("Roll_id");
        $emp_id = $session->get("emp_id");

        $data["dax"] = $this->db
            ->query(
                "select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id  where Bill_Acceptation_Status='4' and Clear_Bill_Form_Status='3'   ORDER BY asitek_bill_register.id desc limit 200 offset " .
                    $etm
            )
            ->getResultArray();

        $model6 = new StateModel();
        $data["dax6"] = $model6->findAll();
        $model1 = new CityModel();
        $data["dax1"] = $model1->findAll();
        $model9 = new DepartmentModel();
        $data["dax9"] = $model9->findAll();
        $model3 = new EmployeeModel();
        $model14 = new PartyUserModel();
        $data["dax14"] = $model14->findAll();

        $model15 = new UnitModel();
        $data["dax15"] = $model15->findAll();
        $model16 = new DepartmentModel();
        $data["dax16"] = $model16->findAll();
        return view("reject_Clear_Bill_Form", $data);
    }

    //**************Clear_Bill_Form Bill End***************
    //************** ERP Manage Bill Start***************
    public function all_erpStystem_list()
    {
        $session = \Config\Services::session();
        $result = $session->get();
        $etm = $result["ddn"];
        $Roll_id = $session->get("Roll_id");
        $emp_id = $session->get("emp_id");
        $compeny_id = $session->get("compeny_id");
        if (isset($_GET["Unit_Id"])) {
            $Unit_Id = $_GET["Unit_Id"];
        } else {
            $Unit_Id = "";
        }
        if (isset($_GET["Vendor_Id"])) {
            $Vendor_Id = $_GET["Vendor_Id"];
        } else {
            $Vendor_Id = "";
        }

        if (isset($_GET["assignedto"])) {
            $assignedto = $_GET["assignedto"];
        } else {
            $assignedto = "";
        }
        
        if (isset($_GET["Satus"])) {
            $Satus = $_GET["Satus"];
        } else {
            $Satus = "";
        }
        // Admin Roll
        if ($Roll_id == 1) {
            if(!empty($Unit_Id) && empty($Vendor_Id) && empty($assignedto) && !empty($Satus)){
                if ($Satus == "All") {
                    $data["dax"] = $this->db->query("select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id where asitek_bill_register.compeny_id='$compeny_id' and    Bill_Acceptation_Status='4' and Clear_Bill_Form_Status='4'  and  asitek_bill_register.Unit_Id='$Unit_Id'  ORDER BY asitek_bill_register.id desc ")->getResultArray();
                } else {
                    $data["dax"] = $this->db->query("select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id where asitek_bill_register.compeny_id='$compeny_id' and Bill_Acceptation_Status='4' and Clear_Bill_Form_Status='4' and ERP_Status='$Satus' and asitek_bill_register.Unit_Id='$Unit_Id'  ORDER BY asitek_bill_register.id desc")->getResultArray();
                }
            }
       
            if(empty($Unit_Id) && !empty($Vendor_Id) && empty($assignedto) && !empty($Satus)){
                if ($Satus == "All") {
                    $data["dax"] = $this->db->query("select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id where asitek_bill_register.compeny_id='$compeny_id' and Bill_Acceptation_Status='4' and Clear_Bill_Form_Status='4'   and asitek_bill_register.Vendor_Id='$Vendor_Id'  ORDER BY asitek_bill_register.id desc ")->getResultArray();
                } else {
                    $data["dax"] = $this->db->query("select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id where asitek_bill_register.compeny_id='$compeny_id' and Bill_Acceptation_Status='4' and Clear_Bill_Form_Status='4' and ERP_Status='$Satus' and asitek_bill_register.Vendor_Id='$Vendor_Id' ORDER BY asitek_bill_register.id desc")->getResultArray();
                }
            }
            if(empty($Unit_Id) && empty($Vendor_Id) && !empty($assignedto) && !empty($Satus)){
                if ($Satus == "All") {
                    $data["dax"] = $this->db->query("select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id where asitek_bill_register.compeny_id='$compeny_id' and Bill_Acceptation_Status='4' and Clear_Bill_Form_Status='4' and asitek_bill_register.Mapping_ERP_EmpId='$assignedto'  ORDER BY asitek_bill_register.id desc ")->getResultArray();
                } else {
                    $data["dax"] = $this->db->query("select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id where asitek_bill_register.compeny_id='$compeny_id' and Bill_Acceptation_Status='4' and Clear_Bill_Form_Status='4' and ERP_Status='$Satus' and asitek_bill_register.Mapping_ERP_EmpId='$assignedto'  ORDER BY asitek_bill_register.id desc")->getResultArray();
                }
            }
            if(empty($Unit_Id) && empty($Vendor_Id) && empty($assignedto) && !empty($Satus)){
                if ($Satus == "All") {
                    $data["dax"] = $this->db->query("select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id where asitek_bill_register.compeny_id='$compeny_id' and Bill_Acceptation_Status='4' and Clear_Bill_Form_Status='4'  ORDER BY asitek_bill_register.id desc ")->getResultArray();
                } else {
                    $data["dax"] = $this->db->query("select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id where asitek_bill_register.compeny_id='$compeny_id' and Bill_Acceptation_Status='4' and Clear_Bill_Form_Status='4' and ERP_Status='$Satus' ORDER BY asitek_bill_register.id desc")->getResultArray();
                }
            }
            if(empty($Unit_Id) && empty($Vendor_Id) && empty($assignedto) && empty($Satus)){
                $data["dax"] = $this->db->query("select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id where asitek_bill_register.compeny_id='$compeny_id' and Bill_Acceptation_Status='4' and Clear_Bill_Form_Status='4'  ORDER BY asitek_bill_register.id desc ")->getResultArray();
            }
        }
        else {
            if(!empty($Unit_Id) && empty($Vendor_Id) && empty($assignedto) && !empty($Satus)){if ($Satus == "All") {
                $data["dax"] = $this->db->query("select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id where asitek_bill_register.compeny_id='$compeny_id' and Bill_Acceptation_Status='4' and Clear_Bill_Form_Status='4'  and  asitek_bill_register.Unit_Id='$Unit_Id' and Mapping_ERP_EmpId='$emp_id' ORDER BY asitek_bill_register.id desc ")->getResultArray();
                } else {
                    $data["dax"] = $this->db->query("select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id where asitek_bill_register.compeny_id='$compeny_id' and Bill_Acceptation_Status='4' and Clear_Bill_Form_Status='4' and ERP_Status='$Satus' and asitek_bill_register.Unit_Id='$Unit_Id' and Mapping_ERP_EmpId='$emp_id' ORDER BY asitek_bill_register.id desc")->getResultArray();
                }
            }
            if(empty($Unit_Id) && !empty($Vendor_Id) && empty($assignedto) && !empty($Satus)){
                if ($Satus == "All") {
                    $data["dax"] = $this->db->query("select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id where asitek_bill_register.compeny_id='$compeny_id' and Bill_Acceptation_Status='4' and Clear_Bill_Form_Status='4'   and asitek_bill_register.Vendor_Id='$Vendor_Id' and Mapping_ERP_EmpId='$emp_id'  ORDER BY asitek_bill_register.id desc ")->getResultArray();
                } else {
                    $data["dax"] = $this->db->query("select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id where asitek_bill_register.compeny_id='$compeny_id' and Bill_Acceptation_Status='4' and Clear_Bill_Form_Status='4' and ERP_Status='$Satus' and asitek_bill_register.Vendor_Id='$Vendor_Id' and Mapping_ERP_EmpId='$emp_id' ORDER BY asitek_bill_register.id desc")->getResultArray();
                }
            }
            if(empty($Unit_Id) && empty($Vendor_Id) && !empty($assignedto) && !empty($Satus)){
                if ($Satus == "All") {
                    $data["dax"] = $this->db->query("select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id where asitek_bill_register.compeny_id='$compeny_id' and Bill_Acceptation_Status='4' and Clear_Bill_Form_Status='4'  and and Mapping_ERP_EmpId='$emp_id'  ORDER BY asitek_bill_register.id desc ")->getResultArray();
                } else {
                    $data["dax"] = $this->db->query("select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id where asitek_bill_register.compeny_id='$compeny_id' and Bill_Acceptation_Status='4' and Clear_Bill_Form_Status='4' and ERP_Status='$Satus' and Mapping_ERP_EmpId='$emp_id' ORDER BY asitek_bill_register.id desc")->getResultArray();
                }
            }
            if(empty($Unit_Id) && empty($Vendor_Id) && empty($assignedto) && !empty($Satus)){
                if ($Satus == "All") {
                    $data["dax"] = $this->db->query("select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id where asitek_bill_register.compeny_id='$compeny_id' and Bill_Acceptation_Status='4' and Clear_Bill_Form_Status='4' and Mapping_ERP_EmpId='$emp_id'  ORDER BY asitek_bill_register.id desc ")->getResultArray();
                } else {
                    $data["dax"] = $this->db->query("select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id where asitek_bill_register.compeny_id='$compeny_id' and Bill_Acceptation_Status='4' and Clear_Bill_Form_Status='4' and ERP_Status='$Satus' and Mapping_ERP_EmpId='$emp_id' ORDER BY asitek_bill_register.id desc")->getResultArray();
                }
            }
            if(empty($Unit_Id) && empty($Vendor_Id) && empty($assignedto) && empty($Satus)){
                $data["dax"] = $this->db->query("select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id where asitek_bill_register.compeny_id='$compeny_id' and Bill_Acceptation_Status='4' and Clear_Bill_Form_Status='4' and Mapping_ERP_EmpId='$emp_id'  ORDER BY asitek_bill_register.id desc ")->getResultArray();
            }
        }
        $model6 = new StateModel();
        $data["dax6"] = $model6->findAll();
        $model1 = new CityModel();
        $data["dax1"] = $model1->findAll();
        $model9 = new DepartmentModel();
        $data["dax9"] = $model9->where("compeny_id", $compeny_id)->findAll();
        $model3 = new EmployeeModel();
        $builderrecommended = $this->db->table("asitek_company_vendor");
        $builderrecommended->select('asitek_company_vendor.Vendor_Id, asitek_party_user.id, asitek_party_user.GST_No, asitek_party_user.Name');
        $builderrecommended->join('asitek_party_user', 'asitek_party_user.id = asitek_company_vendor.Vendor_Id');
        $builderrecommended->where('asitek_company_vendor.Company_Id', $compeny_id);
        $builderrecommended->groupBy('asitek_company_vendor.Vendor_Id');
        $data_recommended = $builderrecommended->get()->getResult();
        $data['dax14'] =$data_recommended;
        $model15 = new UnitModel();
        $data["dax15"] = $model15->where("compeny_id", $compeny_id)->findAll();
        $model16 = new DepartmentModel();
        $data["dax16"] = $model16->where("compeny_id", $compeny_id)->findAll();
        return view("all_erpStystem_list", $data);
    }

    public function all_erpStystem_vendor_list()
    {
        $session = \Config\Services::session();
        $result = $session->get();
        $etm = $result["ddn"];
        $Roll_id = $session->get("Roll_id");
        $emp_id = $session->get("emp_id");
        $compeny_id = $session->get("compeny_id");

        $data["dax"] = $this->db
            ->query(
                "select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name, asitek_compeny.name as companyname from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id JOIN asitek_compeny on asitek_bill_register.compeny_id = asitek_compeny.id where asitek_bill_register.Vendor_Id='$emp_id' and Bill_Acceptation_Status='4' and Clear_Bill_Form_Status='4'  ORDER BY asitek_bill_register.id desc "
            )
            ->getResultArray();

        return view("all-erpSystem-vendor-list", $data);
    }

    public function ERP_System_Pending()
    {
        $session = \Config\Services::session();
        $result = $session->get();
        $etm = $result["ddn"];
        $Roll_id = $session->get("Roll_id");
        $emp_id = $session->get("emp_id");

        $data["dax"] = $this->db
            ->query(
                "select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id  where Bill_Acceptation_Status='4'  and Clear_Bill_Form_Status='4' and ERP_Status='1' ORDER BY asitek_bill_register.id desc limit 2000 offset " .
                    $etm
            )
            ->getResultArray();

        $model6 = new StateModel();
        $data["dax6"] = $model6->findAll();
        $model1 = new CityModel();
        $data["dax1"] = $model1->findAll();
        $model9 = new DepartmentModel();
        $data["dax9"] = $model9->findAll();
        $model3 = new EmployeeModel();
        $model14 = new PartyUserModel();
        $data["dax14"] = $model14->findAll();

        $model15 = new UnitModel();
        $data["dax15"] = $model15->findAll();
        $model16 = new DepartmentModel();
        $data["dax16"] = $model16->findAll();
        return view("ERP_System_Pending", $data);
    }

    public function ERP_StatusChange()
    {
        $session = \Config\Services::session();
        $result = $session->get();
        $model = new BillRegisterModel();
        $id = $this->request->getVar("id");
        $action = $this->request->getVar("action");
        date_default_timezone_set("Asia/Kolkata");
        $ERP_DateTime = date("Y-m-d H:i:s");
        $data = [
            "ERP_Status" => $this->request->getVar("ERP_Status"),
            "ERP_Comment" => $this->request->getVar("ERP_Comment"),
            "ERP_DateTime" => $ERP_DateTime,
        ];

        if (
            $model
                ->where("id", $id)
                ->set($data)
                ->update()
        ) {
            // ****Start RewardPoint**
            $Add_RewardPoint = 10;
            $Remark = $this->request->getVar("ERP_Comment");
            if ($Remark != "") {
                $Remark_RewardPoint = 10;
            } else {
                $Remark_RewardPoint = 0;
            }
                        $BillRegObjNew = new BillRegisterModel();
                          $id3 = $this->request->getVar("id");
                           $BillRegrow= $BillRegObjNew->where('id', $id3)->first();
                           $Bill_DateTime2=$BillRegrow['Bill_DateTime'];
                           $currentmonth=date("Y-m-d H:i:s");
                           
                           $month = date('m', strtotime($currentmonth));
                            $month2 = date('m', strtotime($Bill_DateTime2));
                            if($month<=$month2)
                            {
                              $reward_point = $Add_RewardPoint + $Remark_RewardPoint;
                            }
                            else
                            {
                            $reward_point =0;
                            }

          
            $reward_point_type = "Accept For Bill Entry";
            $session_compeny_id = $session->get("compeny_id");
            $session_emp_id = $session->get("emp_id");
            $DateTimenew = date("Y-m-d H:i:s");
            $dataRewardPoint = [
                "bill_id" => $id,
                "compeny_id" => $session_compeny_id,
                "emp_id" => $session_emp_id,
                "reward_point" => $reward_point,
                "reward_point_type" => $reward_point_type,
                "rec_time_stamp" => $DateTimenew,
            ];
            $RewardPointobj = new RewardPointModel();
            $ERP_Status = $this->request->getVar("ERP_Status");
            if ($ERP_Status == 2) {
                $RewardPoint = $RewardPointobj->insert($dataRewardPoint);
            }
            // ****End RewardPoint**

            if ($action == "all") {
                $session->setFlashdata("Bill_Acceptation_Status", 1);
                return redirect("all_erpStystem_list");
            } elseif ($action == "single") { ?>
                <script type="text/javascript"> 
                    alert('Successfully Change Status  ');
                    window.location.href="<?php echo base_url(
                        "/index.php/sigle_bill_list/" . $id
                    ); ?>"
                </script>
                <?php }
        }
    }

    public function accepted_bill_ERPSytem()
    {
        $session = \Config\Services::session();
        $result = $session->get();
        $etm = $result["ddn"];
        $Roll_id = $session->get("Roll_id");
        $emp_id = $session->get("emp_id");

        $data["dax"] = $this->db
            ->query(
                "select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id  where Bill_Acceptation_Status='4' and Clear_Bill_Form_Status='4' and ERP_Status='2' ORDER BY asitek_bill_register.id desc limit 2000 offset " .
                    $etm
            )
            ->getResultArray();

        $model6 = new StateModel();
        $data["dax6"] = $model6->findAll();
        $model1 = new CityModel();
        $data["dax1"] = $model1->findAll();
        $model9 = new DepartmentModel();
        $data["dax9"] = $model9->findAll();
        $model3 = new EmployeeModel();
        $model14 = new PartyUserModel();
        $data["dax14"] = $model14->findAll();

        $model15 = new UnitModel();
        $data["dax15"] = $model15->findAll();
        $model16 = new DepartmentModel();
        $data["dax16"] = $model16->findAll();
        $model17 = new BillTypeModel();
        $data["dax17"] = $model17->findAll();
        return view("accepted_bill_ERPSytem", $data);
    }

    public function CheckUp_bill_ERPSytem()
    {
        $session = \Config\Services::session();
        $email = \Config\Services::email();
        $model = new BillRegisterModel();
        $vendormodel = new PartyUserModel();
        $companymodel = new CompenyModel();
        $id = $this->request->getVar("id");
        $action = $this->request->getVar("action");
        $validation = \Config\Services::validation();
        $file = $this->request->getFile("E_Image");
        if ($file != "") {
            $validation->setRules([
                "E_Image" =>
                    "uploaded[E_Image]|ext_in[E_Image,jpg,JPG,png,PNG,jpeg,JPEG,pdf]",
            ]);
            if (!$validation->withRequest($this->request)->run()) {
                $data["error"] = $validation->getErrors();
                $this->index();
                return view("add_bill_register");
            } else {
                $imageName = $file->getRandomName();
                $file->move("public/vendors/PicUpload", $imageName);
            }
        } else {
            $imageName = "";
        }
        $data = [
            "Mapping_Acount_EmpId" => $this->request->getVar(
                "Mapping_Acount_EmpId"
            ),
            "ERP_Status" => 4,
            "Target_ERP_Time_Hours" => $this->request->getVar(
                "Target_ERP_Time_Hours"
            ),
            "ERP_Delay_On_Time" => $this->request->getVar("ERP_Delay_On_Time"),
            "ERP_Delay_On_Time" => $this->request->getVar("ERP_Delay_On_Time"),
            "ERP_AnyImage" => $imageName,
            "ERP_Remark" => $this->request->getVar("ERP_Remark"),
        ];

        $billid = $this->db
            ->query(
                "SELECT compeny_id, Vendor_Id from asitek_bill_register WHERE id = '$id'"
            )
            ->getResult(); // Adjust the column name based on your database structure
        $vendorvalue = $billid[0]->Vendor_Id;
        $compnyvalue = $billid[0]->compeny_id;

        $vdr = $vendormodel->where("id", $vendorvalue)->first();
        $cpn = $companymodel->where("id", $compnyvalue)->first();

        if (
            $model
                ->where("id", $id)
                ->set($data)
                ->update()
        ) {
            // ****Start RewardPoint**
            $Add_RewardPoint = 10;
            $Remark = $this->request->getVar("ERP_Remark");
            if ($Remark != "") {
                $Remark_RewardPoint = 10;
            } else {
                $Remark_RewardPoint = 0;
            }
            $E_Image = $this->request->getFile("E_Image");
            if ($E_Image != "") {
                $FileAttch_RewardPoint = 10;
            } else {
                $FileAttch_RewardPoint = 0;
            }

            $BillRegObjNew = new BillRegisterModel();
                          $id3 = $this->request->getVar("id");
                           $BillRegrow= $BillRegObjNew->where('id', $id3)->first();
                           $Bill_DateTime2=$BillRegrow['Bill_DateTime'];
                           $currentmonth=date("Y-m-d H:i:s");
                           
                           $month = date('m', strtotime($currentmonth));
                            $month2 = date('m', strtotime($Bill_DateTime2));
                            if($month<=$month2)
                            {
                              $reward_point =  $Add_RewardPoint + $Remark_RewardPoint + $FileAttch_RewardPoint;
                            }
                            else
                            {
                            $reward_point =0;
                            }

          
            $reward_point_type = "send this bill Bill Recived A/C (forward)";
            $session_compeny_id = $session->get("compeny_id");
            $session_emp_id = $session->get("emp_id");
            $DateTimenew = date("Y-m-d H:i:s");
            $dataRewardPoint = [
                "bill_id" => $id,
                "compeny_id" => $session_compeny_id,
                "emp_id" => $session_emp_id,
                "reward_point" => $reward_point,
                "reward_point_type" => $reward_point_type,
                "rec_time_stamp" => $DateTimenew,
            ];
            $RewardPointobj = new RewardPointModel();
            $RewardPoint = $RewardPointobj->insert($dataRewardPoint);
            // ****End RewardPoint**

            if ($action == "all") {
                $wpmsg =
                    "Dear " .
                    $vdr["Name"] .
                    ", We would like to inform you that your recent bill has been successfully processed through our ERP system. Thank you for your prompt submission! Best regards, " .
                    $cpn["name"];
                // $url = "https://chatway.in/api/send-msg?username=ashrishaWCH&number=+91".$vdr['Mobile_No']."&message=".$wpmsg."&token=Y21iQk9IeExwbjluMGE2SUxhM2taQT09";
                // $url = preg_replace("/ /", "%20", $url);
                // $response = file_get_contents($url);

                // $email->setFrom("singhshaan085@gmail.com", "Bill Management");
                // $email->setTo($vdr["Email_Id"]);
                // $email->setSubject("Bill Add in Company | Bill Management");
                // $email->setmailType("html");
                // $email->setMessage($wpmsg); //your message here
                // $email->send();

                $session->setFlashdata("Mapping_erpStystem", 1);
                return redirect("all_erpStystem_list");
            } elseif ($action == "single") {

                $wpmsg =
                    "Dear " .
                    $vdr["Name"] .
                    ", We would like to inform you that your recent bill has been successfully processed through our ERP system. Thank you for your prompt submission! Best regards, " .
                    $cpn["name"];
                // $url = "https://chatway.in/api/send-msg?username=ashrishaWCH&number=+91".$vdr['Mobile_No']."&message=".$wpmsg."&token=Y21iQk9IeExwbjluMGE2SUxhM2taQT09";
                // $url = preg_replace("/ /", "%20", $url);
                // $response = file_get_contents($url);

                // $email->setFrom("singhshaan085@gmail.com", "Bill Management");
                // $email->setTo($vdr["Email_Id"]);
                // $email->setSubject("Bill Add in Company | Bill Management");
                // $email->setmailType("html");
                // $email->setMessage($wpmsg); //your message here
                // $email->send();
                ?>
                <script type="text/javascript"> 
                    alert('Successfully ');
                    window.location.href="<?php echo base_url(
                        "/index.php/sigle_bill_list/" . $id
                    ); ?>"
                </script>
                <?php
            }
        }
    }

    public function ERP_System_Done()
    {
        $session = \Config\Services::session();
        $result = $session->get();
        $etm = $result["ddn"];
        $Roll_id = $session->get("Roll_id");
        $emp_id = $session->get("emp_id");

        $data["dax"] = $this->db
            ->query(
                "select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id  where Bill_Acceptation_Status='4' and Clear_Bill_Form_Status='4' and ERP_Status='4' ORDER BY asitek_bill_register.id desc limit 2000 offset " .
                    $etm
            )
            ->getResultArray();

        $model6 = new StateModel();
        $data["dax6"] = $model6->findAll();
        $model1 = new CityModel();
        $data["dax1"] = $model1->findAll();
        $model9 = new DepartmentModel();
        $data["dax9"] = $model9->findAll();
        $model3 = new EmployeeModel();
        $model14 = new PartyUserModel();
        $data["dax14"] = $model14->findAll();

        $model15 = new UnitModel();
        $data["dax15"] = $model15->findAll();
        $model16 = new DepartmentModel();
        $data["dax16"] = $model16->findAll();
        $model17 = new BillTypeModel();
        $data["dax17"] = $model17->findAll();

        return view("ERP_System_Done", $data);
    }

    public function ERP_System_Reject()
    {
        $session = \Config\Services::session();
        $result = $session->get();
        $etm = $result["ddn"];
        $Roll_id = $session->get("Roll_id");
        $emp_id = $session->get("emp_id");

        $data["dax"] = $this->db
            ->query(
                "select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id  where Bill_Acceptation_Status='4' and Clear_Bill_Form_Status='4' and ERP_Status='3'   ORDER BY asitek_bill_register.id desc limit 20 offset " .
                    $etm
            )
            ->getResultArray();

        $model6 = new StateModel();
        $data["dax6"] = $model6->findAll();
        $model1 = new CityModel();
        $data["dax1"] = $model1->findAll();
        $model9 = new DepartmentModel();
        $data["dax9"] = $model9->findAll();
        $model3 = new EmployeeModel();
        $model14 = new PartyUserModel();
        $data["dax14"] = $model14->findAll();

        $model15 = new UnitModel();
        $data["dax15"] = $model15->findAll();
        $model16 = new DepartmentModel();
        $data["dax16"] = $model16->findAll();
        return view("ERP_System_Reject", $data);
    }

    //************** ERP Manage Bill End***************

    //************** Recived Bill Start***************

    public function pending_recived_bill()
    {
        $session = \Config\Services::session();
        $result = $session->get();
        $etm = $result["ddn"];
        $Roll_id = $session->get("Roll_id");
        $emp_id = $session->get("emp_id");

        $data["dax"] = $this->db
            ->query(
                "select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id  where Bill_Acceptation_Status='4'  and Clear_Bill_Form_Status='4' and ERP_Status='4' and  Recived_Status='1' ORDER BY asitek_bill_register.id desc limit 2000 offset " .
                    $etm
            )
            ->getResultArray();

        $model6 = new StateModel();
        $data["dax6"] = $model6->findAll();
        $model1 = new CityModel();
        $data["dax1"] = $model1->findAll();
        $model9 = new DepartmentModel();
        $data["dax9"] = $model9->findAll();
        $model3 = new EmployeeModel();
        $model14 = new PartyUserModel();
        $data["dax14"] = $model14->findAll();

        $model15 = new UnitModel();
        $data["dax15"] = $model15->findAll();
        $model16 = new DepartmentModel();
        $data["dax16"] = $model16->findAll();
        return view("pending_recived_bill", $data);
    }

    public function RecivedBill_StatusChange()
    {
        $session = \Config\Services::session();
        $result = $session->get();
        $model = new BillRegisterModel();
        $id = $this->request->getVar("id");
        $action = $this->request->getVar("action");
        date_default_timezone_set("Asia/Kolkata");
        $Recived_DateTime = date("Y-m-d H:i:s");
        $data = [
            "Recived_Status" => $this->request->getVar("Recived_Status"),
            "Recived_Comment" => $this->request->getVar("Recived_Comment"),
            "Recived_DateTime" => $Recived_DateTime,
        ];

        if (
            $model
                ->where("id", $id)
                ->set($data)
                ->update()
        ) {
            // ****Start RewardPoint**
            $Add_RewardPoint = 10;
            $Remark = $this->request->getVar("Recived_Comment");
            if ($Remark != "") {
                $Remark_RewardPoint = 10;
            } else {
                $Remark_RewardPoint = 0;
            }

             $BillRegObjNew = new BillRegisterModel();
                          $id3 = $this->request->getVar("id");
                           $BillRegrow= $BillRegObjNew->where('id', $id3)->first();
                           $Bill_DateTime2=$BillRegrow['Bill_DateTime'];
                           $currentmonth=date("Y-m-d H:i:s");
                           
                           $month = date('m', strtotime($currentmonth));
                            $month2 = date('m', strtotime($Bill_DateTime2));
                            if($month<=$month2)
                            {
                              $reward_point = $Add_RewardPoint + $Remark_RewardPoint;
                            }
                            else
                            {
                            $reward_point =0;
                            }
            
            $reward_point_type = "Accept For Bill Recived A/C";
            $session_compeny_id = $session->get("compeny_id");
            $session_emp_id = $session->get("emp_id");
            $DateTimenew = date("Y-m-d H:i:s");
            $dataRewardPoint = [
                "bill_id" => $id,
                "compeny_id" => $session_compeny_id,
                "emp_id" => $session_emp_id,
                "reward_point" => $reward_point,
                "reward_point_type" => $reward_point_type,
                "rec_time_stamp" => $DateTimenew,
            ];
            $RewardPointobj = new RewardPointModel();
            $Recived_Status = $this->request->getVar("Recived_Status");
            if ($Recived_Status == 2) {
                $RewardPoint = $RewardPointobj->insert($dataRewardPoint);
            }

            // ****End RewardPoint**

            if ($action == "all") {
                $session->setFlashdata("pending_Clear_Bill_Form", 1);
                return redirect("all_recived_bill_list");
            } elseif ($action == "single") { ?>
                <script type="text/javascript"> 
                    alert('Successfully ');
                    window.location.href="<?php echo base_url(
                        "/index.php/sigle_bill_list/" . $id
                    ); ?>"
                </script>
                <?php }
        }
    }

    public function accepted_recived_bill()
    {
        $session = \Config\Services::session();
        $result = $session->get();
        $etm = $result["ddn"];
        $Roll_id = $session->get("Roll_id");
        $emp_id = $session->get("emp_id");

        $data["dax"] = $this->db
            ->query(
                "select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id  where Bill_Acceptation_Status='4' and Clear_Bill_Form_Status='4' and ERP_Status='4' and  Recived_Status='2' ORDER BY asitek_bill_register.id desc limit 2000 offset " .
                    $etm
            )
            ->getResultArray();
        $model6 = new StateModel();
        $data["dax6"] = $model6->findAll();
        $model1 = new CityModel();
        $data["dax1"] = $model1->findAll();
        $model9 = new DepartmentModel();
        $data["dax9"] = $model9->findAll();
        $model3 = new EmployeeModel();
        $model14 = new PartyUserModel();
        $data["dax14"] = $model14->findAll();
        $model15 = new UnitModel();
        $data["dax15"] = $model15->findAll();
        $model16 = new DepartmentModel();
        $data["dax16"] = $model16->findAll();
        $model17 = new BillTypeModel();
        $data["dax17"] = $model17->findAll();
        return view("accepted_recived_bill", $data);
    }

    public function CheckUp_RecivedBill()
    {
        $session = \Config\Services::session();
        $email = \Config\Services::email();
        $vendormodel = new PartyUserModel();
        $companymodel = new CompenyModel();
        $model = new BillRegisterModel();
        $id = $this->request->getVar("id");
        $action = $this->request->getVar("action");
        $validation = \Config\Services::validation();
        $file = $this->request->getFile("E_Image");
        if ($file != "") {
            $validation->setRules([
                "E_Image" =>
                    "uploaded[E_Image]|ext_in[E_Image,jpg,JPG,png,PNG,jpeg,JPEG,pdf]",
            ]);
            if (!$validation->withRequest($this->request)->run()) {
                $data["error"] = $validation->getErrors();
                $this->index();
                return view("add_bill_register");
            } else {
                $imageName = $file->getRandomName();
                $file->move("public/vendors/PicUpload", $imageName);
            }
        } else {
            $imageName = "";
        }

        $data = [
            "Recived_Status" => 4,
            "Recived_TragetTime_Hours" => $this->request->getVar(
                "Recived_TragetTime_Hours"
            ),
            "Recived_Delay_On_Time" => $this->request->getVar(
                "Recived_Delay_On_Time"
            ),
            "Recived_AnyImage" => $imageName,
            "Recived_Remark" => $this->request->getVar("Recived_Remark"),
        ];

        $billid = $this->db
            ->query(
                "SELECT compeny_id, Vendor_Id from asitek_bill_register WHERE id = '$id'"
            )
            ->getResult(); // Adjust the column name based on your database structure
        $vendorvalue = $billid[0]->Vendor_Id;
        $compnyvalue = $billid[0]->compeny_id;

        $vdr = $vendormodel->where("id", $vendorvalue)->first();
        $cpn = $companymodel->where("id", $compnyvalue)->first();

        if (
            $model
                ->where("id", $id)
                ->set($data)
                ->update()
        ) {
            // ****Start RewardPoint**
            $Add_RewardPoint = 10;
            $Remark = $this->request->getVar("Recived_Remark");
            if ($Remark != "") {
                $Remark_RewardPoint = 10;
            } else {
                $Remark_RewardPoint = 0;
            }
            $E_Image = $this->request->getFile("E_Image");
            if ($E_Image != "") {
                $FileAttch_RewardPoint = 10;
            } else {
                $FileAttch_RewardPoint = 0;
            }

             $BillRegObjNew = new BillRegisterModel();
                          $id3 = $this->request->getVar("id");
                           $BillRegrow= $BillRegObjNew->where('id', $id3)->first();
                           $Bill_DateTime2=$BillRegrow['Bill_DateTime'];
                           $currentmonth=date("Y-m-d H:i:s");
                           
                           $month = date('m', strtotime($currentmonth));
                            $month2 = date('m', strtotime($Bill_DateTime2));
                            if($month<=$month2)
                            {
                              $reward_point = $Add_RewardPoint + $Remark_RewardPoint + $FileAttch_RewardPoint;
                            }
                            else
                            {
                            $reward_point =0;
                            }

            
            $reward_point_type = "Bill Recived A/C Completed";
            $session_compeny_id = $session->get("compeny_id");
            $session_emp_id = $session->get("emp_id");
            $DateTimenew = date("Y-m-d H:i:s");
            $dataRewardPoint = [
                "bill_id" => $id,
                "compeny_id" => $session_compeny_id,
                "emp_id" => $session_emp_id,
                "reward_point" => $reward_point,
                "reward_point_type" => $reward_point_type,
                "rec_time_stamp" => $DateTimenew,
            ];
            $RewardPointobj = new RewardPointModel();
            $RewardPoint = $RewardPointobj->insert($dataRewardPoint);
            $RewardPointobj
                ->where("bill_id", $id)
                ->set("status", 2)
                ->update();

            // ****End RewardPoint**
            if ($action == "all") {
                $wpmsg =
                    "Dear " .
                    $vdr["Name"] .
                    ", We wanted to inform you that your bill has been successfully received by our accounting department. Thank you for your prompt submission! Best regards, " .
                    $cpn["name"];
                // $url = "https://chatway.in/api/send-msg?username=ashrishaWCH&number=+91".$vdr['Mobile_No']."&message=".$wpmsg."&token=Y21iQk9IeExwbjluMGE2SUxhM2taQT09";
                // $url = preg_replace("/ /", "%20", $url);
                // $response = file_get_contents($url);

                // $email->setFrom("singhshaan085@gmail.com", "Bill Management");
                // $email->setTo($vdr["Email_Id"]);
                // $email->setSubject("Bill Add in Company | Bill Management");
                // $email->setmailType("html");
                // $email->setMessage($wpmsg); //your message here
                // $email->send();
                $session->setFlashdata("Mapping_RecivedBill", 1);
                return redirect("all_recived_bill_list");
            } elseif ($action == "single") {

                $wpmsg =
                    "Dear " .
                    $vdr["Name"] .
                    ", We wanted to inform you that your bill has been successfully received by our accounting department. Thank you for your prompt submission! Best regards, " .
                    $cpn["name"];
                // $url = "https://chatway.in/api/send-msg?username=ashrishaWCH&number=+91".$vdr['Mobile_No']."&message=".$wpmsg."&token=Y21iQk9IeExwbjluMGE2SUxhM2taQT09";
                // $url = preg_replace("/ /", "%20", $url);
                // $response = file_get_contents($url);

                // $email->setFrom("singhshaan085@gmail.com", "Bill Management");
                // $email->setTo($vdr["Email_Id"]);
                // $email->setSubject("Bill Add in Company | Bill Management");
                // $email->setmailType("html");
                // $email->setMessage($wpmsg); //your message here
                // $email->send();
                ?>
                <script type="text/javascript"> 
                    alert('Successfully ');
                    window.location.href="<?php echo base_url(
                        "/index.php/sigle_bill_list/" . $id
                    ); ?>"
                </script>
                <?php
            }
        }
    }

    public function all_recived_bill_list()
    {
        $session = \Config\Services::session();
        $result = $session->get();
        $etm = $result["ddn"];
        $Roll_id = $session->get("Roll_id");
        $emp_id = $session->get("emp_id");
        $compeny_id = $session->get("compeny_id");
        if (isset($_GET["Unit_Id"])) {
            $Unit_Id = $_GET["Unit_Id"];
        } else {
            $Unit_Id = "";
        }
        if (isset($_GET["Vendor_Id"])) {
            $Vendor_Id = $_GET["Vendor_Id"];
        } else {
            $Vendor_Id = "";
        }

        if (isset($_GET["assignedto"])) {
            $assignedto = $_GET["assignedto"];
        } else {
            $assignedto = "";
        }
        
        if (isset($_GET["Satus"])) {
            $Satus = $_GET["Satus"];
        } else {
            $Satus = "";
        }
        //Admin Roll Start
        if ($Roll_id == 1) {
            if(!empty($Unit_Id) && empty($Vendor_Id) && empty($assignedto) && !empty($Satus)){
                if ($Satus == "All") {
                    $data["dax"] = $this->db->query("select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id where asitek_bill_register.compeny_id='$compeny_id' and  Bill_Acceptation_Status='4' and Clear_Bill_Form_Status='4' and ERP_Status='4'  and  asitek_bill_register.Unit_Id='$Unit_Id'  ORDER BY asitek_bill_register.id desc ")->getResultArray();
                } else {
                    $data["dax"] = $this->db->query("select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id where asitek_bill_register.compeny_id='$compeny_id' and Bill_Acceptation_Status='4' and Clear_Bill_Form_Status='4' and ERP_Status='4' and  Recived_Status='$Satus' and asitek_bill_register.Unit_Id='$Unit_Id'  ORDER BY asitek_bill_register.id desc")->getResultArray();
                }
            }
            if(empty($Unit_Id) && !empty($Vendor_Id) && empty($assignedto) && !empty($Satus)){
                if ($Satus == "All") {
                    $data["dax"] = $this->db->query("select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id where asitek_bill_register.compeny_id='$compeny_id' and Bill_Acceptation_Status='4' and Clear_Bill_Form_Status='4' and ERP_Status='4'  and asitek_bill_register.Vendor_Id='$Vendor_Id'  ORDER BY asitek_bill_register.id desc ")->getResultArray();
                } else {
                    $data["dax"] = $this->db->query("select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id where asitek_bill_register.compeny_id='$compeny_id' and Bill_Acceptation_Status='4' and Clear_Bill_Form_Status='4' and ERP_Status='4' and  Recived_Status='$Satus' and asitek_bill_register.Vendor_Id='$Vendor_Id' ORDER BY asitek_bill_register.id desc")->getResultArray();
                }
            }
            if(empty($Unit_Id) && empty($Vendor_Id) && !empty($assignedto) && !empty($Satus)){
                if ($Satus == "All") {
                    $data["dax"] = $this->db->query("select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id where asitek_bill_register.compeny_id='$compeny_id' and Bill_Acceptation_Status='4' and Clear_Bill_Form_Status='4' and ERP_Status='4' and asitek_bill_register.Mapping_Acount_EmpId='$assignedto'  ORDER BY asitek_bill_register.id desc ")->getResultArray();
                } else {
                    $data["dax"] = $this->db->query("select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id where asitek_bill_register.compeny_id='$compeny_id' and Bill_Acceptation_Status='4' and Clear_Bill_Form_Status='4' and ERP_Status='4' and  Recived_Status='$Satus' and asitek_bill_register.Mapping_Acount_EmpId='$assignedto' ORDER BY asitek_bill_register.id desc")->getResultArray();
                }
            }
            if(empty($Unit_Id) && empty($Vendor_Id) && empty($assignedto) && !empty($Satus)){
                if ($Satus == "All") {
                    $data["dax"] = $this->db->query("select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id where asitek_bill_register.compeny_id='$compeny_id' and Bill_Acceptation_Status='4' and Clear_Bill_Form_Status='4' and ERP_Status='4' ORDER BY asitek_bill_register.id desc " )->getResultArray();
                } else {
                    $data["dax"] = $this->db->query("select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id where asitek_bill_register.compeny_id='$compeny_id' and Bill_Acceptation_Status='4' and Clear_Bill_Form_Status='4' and ERP_Status='4' and  Recived_Status='$Satus' ORDER BY asitek_bill_register.id desc")->getResultArray();
                }
            }
            if(empty($Unit_Id) && empty($Vendor_Id) && empty($assignedto) && empty($Satus)){
                $data["dax"] = $this->db->query("select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id where asitek_bill_register.compeny_id='$compeny_id' and Bill_Acceptation_Status='4' and Clear_Bill_Form_Status='4' and ERP_Status='4' ORDER BY asitek_bill_register.id desc " )->getResultArray();
            }
            // Only Status  Filter wise End Code
        }
        //Admin Roll End
        //Other Roll Start
        else {
            if(!empty($Unit_Id) && empty($Vendor_Id) && empty($assignedto) && !empty($Satus)){
                if ($Satus == "All") {
                    $data["dax"] = $this->db->query("select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id where asitek_bill_register.compeny_id='$compeny_id' and Bill_Acceptation_Status='4' and Clear_Bill_Form_Status='4' and ERP_Status='4'  and  asitek_bill_register.Unit_Id='$Unit_Id'  and Mapping_Acount_EmpId='$emp_id' ORDER BY asitek_bill_register.id desc ")->getResultArray();
                } else {
                    $data["dax"] = $this->db->query("select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id where asitek_bill_register.compeny_id='$compeny_id' and Bill_Acceptation_Status='4' and Clear_Bill_Form_Status='4' and ERP_Status='4' and  Recived_Status='$Satus' and asitek_bill_register.Unit_Id='$Unit_Id'  and Mapping_Acount_EmpId='$emp_id' ORDER BY asitek_bill_register.id desc")->getResultArray();
                }
            }
            if(empty($Unit_Id) && !empty($Vendor_Id) && empty($assignedto) && !empty($Satus)){
                if ($Satus == "All") {
                    $data["dax"] = $this->db->query("select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id where asitek_bill_register.compeny_id='$compeny_id' and Bill_Acceptation_Status='4' and Clear_Bill_Form_Status='4' and ERP_Status='4'  and asitek_bill_register.Vendor_Id='$Vendor_Id' and Mapping_Acount_EmpId='$emp_id'  ORDER BY asitek_bill_register.id desc ")->getResultArray();
                } else {
                    $data["dax"] = $this->db->query("select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id where asitek_bill_register.compeny_id='$compeny_id' and Bill_Acceptation_Status='4' and Clear_Bill_Form_Status='4' and ERP_Status='4' and  Recived_Status='$Satus' and asitek_bill_register.Vendor_Id='$Vendor_Id' and Mapping_Acount_EmpId='$emp_id' ORDER BY asitek_bill_register.id desc")->getResultArray();
                }
            }
            if(empty($Unit_Id) && empty($Vendor_Id) && !empty($assignedto) && !empty($Satus)){
                if ($Satus == "All") {
                $data["dax"] = $this->db->query("select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id where asitek_bill_register.compeny_id='$compeny_id' and Bill_Acceptation_Status='4' and Clear_Bill_Form_Status='4' and ERP_Status='4' and Mapping_Acount_EmpId='$emp_id'  ORDER BY asitek_bill_register.id desc ")->getResultArray();
                } else {
                    $data["dax"] = $this->db->query("select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id where asitek_bill_register.compeny_id='$compeny_id' and Bill_Acceptation_Status='4' and Clear_Bill_Form_Status='4' and ERP_Status='4' and  Recived_Status='$Satus' and Mapping_Acount_EmpId='$emp_id'  ORDER BY asitek_bill_register.id desc")->getResultArray();
                }
            }
            if(empty($Unit_Id) && empty($Vendor_Id) && empty($assignedto) && !empty($Satus)){
                if ($Satus == "All") {
                    $data["dax"] = $this->db->query("select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id where asitek_bill_register.compeny_id='$compeny_id' and Bill_Acceptation_Status='4' and Clear_Bill_Form_Status='4' and ERP_Status='4' and Mapping_Acount_EmpId='$emp_id' ORDER BY asitek_bill_register.id desc ")->getResultArray();
                } else {
                    $data["dax"] = $this->db->query("select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id where asitek_bill_register.compeny_id='$compeny_id' and Bill_Acceptation_Status='4' and Clear_Bill_Form_Status='4' and ERP_Status='4' and  Recived_Status='$Satus' and Mapping_Acount_EmpId='$emp_id' ORDER BY asitek_bill_register.id desc")->getResultArray();
                }
            }
            if(empty($Unit_Id) && empty($Vendor_Id) && empty($assignedto) && empty($Satus)){
                $data["dax"] = $this->db->query("select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id where asitek_bill_register.compeny_id='$compeny_id' and Bill_Acceptation_Status='4' and Clear_Bill_Form_Status='4' and ERP_Status='4' and Mapping_Acount_EmpId='$emp_id' ORDER BY asitek_bill_register.id desc ")->getResultArray();
                
            }
            // Only Status  Filter wise End Code
        }
        // Other Roll End
        $model6 = new StateModel();
        $data["dax6"] = $model6->findAll();
        $model1 = new CityModel();
        $data["dax1"] = $model1->findAll();
        $model9 = new DepartmentModel();
        $data["dax9"] = $model9->where("compeny_id", $compeny_id)->findAll();
        $model3 = new EmployeeModel();
        $builderrecommended = $this->db->table("asitek_company_vendor");
        $builderrecommended->select('asitek_company_vendor.Vendor_Id, asitek_party_user.id, asitek_party_user.GST_No, asitek_party_user.Name');
        $builderrecommended->join('asitek_party_user', 'asitek_party_user.id = asitek_company_vendor.Vendor_Id');
        $builderrecommended->where('asitek_company_vendor.Company_Id', $compeny_id);
        $builderrecommended->groupBy('asitek_company_vendor.Vendor_Id');
        $data_recommended = $builderrecommended->get()->getResult();
        $data['dax14'] =$data_recommended;
        $model15 = new UnitModel();
        $data["dax15"] = $model15->where("compeny_id", $compeny_id)->findAll();
        $model16 = new DepartmentModel();
        $data["dax16"] = $model16->where("compeny_id", $compeny_id)->findAll();
        return view("all_recived_bill_list", $data);
    }
    //************** Recived Bill End***************

    public function all_recived_bill_vendor_list()
    {
        $session = \Config\Services::session();
        $result = $session->get();
        $etm = $result["ddn"];
        $Roll_id = $session->get("Roll_id");
        $emp_id = $session->get("emp_id");
        $compeny_id = $session->get("compeny_id");
        $data["dax"] = $this->db
            ->query(
                "select asitek_bill_register.*, asitek_employee.emp_u_id, asitek_employee.first_name, asitek_employee.last_name, asitek_compeny.name as companyname from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id JOIN asitek_compeny on asitek_bill_register.compeny_id = asitek_compeny.id where asitek_bill_register.Vendor_Id='$emp_id' and  Bill_Acceptation_Status='4' and Clear_Bill_Form_Status='4' and ERP_Status='4' ORDER BY asitek_bill_register.id desc "
            )
            ->getResultArray();
        return view("all-recived-bill-vendor-list", $data);
    }
    //************** Recived Bill End***************

    //************** Complete View Bill list Start **************
    public function view_complete_bill_list()
    {
        $session = \Config\Services::session();
        $result = $session->get();
        $etm = $result["ddn"];
        $Roll_id = $session->get("Roll_id");
        $emp_id = $session->get("emp_id");
        $compeny_id = $session->get("compeny_id");
        if (isset($_GET["Unit_Id"])) {
            $Unit_Id = $_GET["Unit_Id"];
        } else {
            $Unit_Id = "";
        }
        if (isset($_GET["Vendor_Id"])) {
            $Vendor_Id = $_GET["Vendor_Id"];
        } else {
            $Vendor_Id = "";
        }

        if (isset($_GET["assignedto"])) {
            $assignedto = $_GET["assignedto"];
        } else {
            $assignedto = "";
        }
        
        if (isset($_GET["Satus"])) {
            $Satus = $_GET["Satus"];
        } else {
            $Satus = "";
        }
        //Admin Roll Start

        if ($Roll_id == 1) {
            if(!empty($Unit_Id) && empty($Vendor_Id) && empty($assignedto) && !empty($Satus)){
                if ($Satus == "All") {
                    $data["dax"] = $this->db->query("select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id where asitek_bill_register.compeny_id='$compeny_id' and Bill_Acceptation_Status='4' and Clear_Bill_Form_Status='4' and ERP_Status='4'  and  asitek_bill_register.Unit_Id='$Unit_Id'  ORDER BY asitek_bill_register.id desc ")->getResultArray();
                } else {
                    $data["dax"] = $this->db->query("select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id where asitek_bill_register.compeny_id='$compeny_id' and Bill_Acceptation_Status='4' and Clear_Bill_Form_Status='4' and ERP_Status='4' and  Recived_Status='$Satus' and asitek_bill_register.Unit_Id='$Unit_Id'  ORDER BY asitek_bill_register.id desc")->getResultArray();
                }
            }

            if(empty($Unit_Id) && !empty($Vendor_Id) && empty($assignedto) && !empty($Satus)){
                if ($Satus == "All") {
                    $data["dax"] = $this->db->query("select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id where asitek_bill_register.compeny_id='$compeny_id' and Bill_Acceptation_Status='4' and Clear_Bill_Form_Status='4' and ERP_Status='4'  and asitek_bill_register.Vendor_Id='$Vendor_Id'  ORDER BY asitek_bill_register.id desc ")->getResultArray();
                } else {
                    $data["dax"] = $this->db->query("select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id where asitek_bill_register.compeny_id='$compeny_id' and Bill_Acceptation_Status='4' and Clear_Bill_Form_Status='4' and ERP_Status='4' and  Recived_Status='$Satus' and asitek_bill_register.Vendor_Id='$Vendor_Id' ORDER BY asitek_bill_register.id desc" )->getResultArray();
                }
            }
            // Vendor Filter wise End Code

            if(empty($Unit_Id) && empty($Vendor_Id) && !empty($assignedto) && !empty($Satus)){
                if ($Satus == "All") {
                    $data["dax"] = $this->db->query("select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id where asitek_bill_register.compeny_id='$compeny_id' and Bill_Acceptation_Status='4' and Clear_Bill_Form_Status='4' and ERP_Status='4' and asitek_bill_register.Gate_Entry_No='$Gate_Entry_No'  ORDER BY asitek_bill_register.id desc ")->getResultArray();
                } else {
                    $data["dax"] = $this->db->query("select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id where asitek_bill_register.compeny_id='$compeny_id' and Bill_Acceptation_Status='4' and Clear_Bill_Form_Status='4' and ERP_Status='4' and  Recived_Status='$Satus'  and asitek_bill_register.Gate_Entry_No='$Gate_Entry_No'  ORDER BY asitek_bill_register.id desc")->getResultArray();
                }
            }

            if(empty($Unit_Id) && empty($Vendor_Id) && empty($assignedto) && !empty($Satus)){
                if ($Satus == "All") {
                    $data["dax"] = $this->db->query("select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id where asitek_bill_register.compeny_id='$compeny_id' and Bill_Acceptation_Status='4' and Clear_Bill_Form_Status='4' and ERP_Status='4' ORDER BY asitek_bill_register.id desc ")->getResultArray();
                } else {
                    $data["dax"] = $this->db->query("select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id where asitek_bill_register.compeny_id='$compeny_id' and Bill_Acceptation_Status='4' and Clear_Bill_Form_Status='4' and ERP_Status='4' and  Recived_Status='$Satus' ORDER BY asitek_bill_register.id desc")->getResultArray();
                }
            }
            if(empty($Unit_Id) && empty($Vendor_Id) && empty($assignedto) && empty($Satus)){
                $data["dax"] = $this->db->query("select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id where asitek_bill_register.compeny_id='$compeny_id' and Bill_Acceptation_Status='4' and Clear_Bill_Form_Status='4' and ERP_Status='4' ORDER BY asitek_bill_register.id desc ")->getResultArray();
            }
            // Only Status  Filter wise End Code
        }
        //Admin Roll End
        //Other Roll Start
        else {
            if(!empty($Unit_Id) && empty($Vendor_Id) && empty($assignedto) && !empty($Satus)){
                if ($Satus == "All") {
                    $data["dax"] = $this->db->query("select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id where asitek_bill_register.compeny_id='$compeny_id' and Bill_Acceptation_Status='4' and Clear_Bill_Form_Status='4' and ERP_Status='4'  and  asitek_bill_register.Unit_Id='$Unit_Id'  and Mapping_Acount_EmpId='$emp_id' ORDER BY asitek_bill_register.id desc ")->getResultArray();
                } else {
                    $data["dax"] = $this->db->query("select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id where asitek_bill_register.compeny_id='$compeny_id' and Bill_Acceptation_Status='4' and Clear_Bill_Form_Status='4' and ERP_Status='4' and  Recived_Status='$Satus' and asitek_bill_register.Unit_Id='$Unit_Id'  and Mapping_Acount_EmpId='$emp_id' ORDER BY asitek_bill_register.id desc")->getResultArray();
                }
            }

            if(empty($Unit_Id) && !empty($Vendor_Id) && empty($assignedto) && !empty($Satus)){
                if ($Satus == "All") {
                    $data["dax"] = $this->db->query("select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id where asitek_bill_register.compeny_id='$compeny_id' and Bill_Acceptation_Status='4' and Clear_Bill_Form_Status='4' and ERP_Status='4'  and asitek_bill_register.Vendor_Id='$Vendor_Id' and Mapping_Acount_EmpId='$emp_id'  ORDER BY asitek_bill_register.id desc ")->getResultArray();
                } else {
                    $data["dax"] = $this->db->query("select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id where asitek_bill_register.compeny_id='$compeny_id' and Bill_Acceptation_Status='4' and Clear_Bill_Form_Status='4' and ERP_Status='4' and  Recived_Status='$Satus' and asitek_bill_register.Vendor_Id='$Vendor_Id' and Mapping_Acount_EmpId='$emp_id' ORDER BY asitek_bill_register.id desc")->getResultArray();
                }
            }
            if(empty($Unit_Id) && empty($Vendor_Id) && !empty($assignedto) && !empty($Satus)){
                if ($Satus == "All") {
                    $data["dax"] = $this->db->query("select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id where asitek_bill_register.compeny_id='$compeny_id' and Bill_Acceptation_Status='4' and Clear_Bill_Form_Status='4' and ERP_Status='4' and Mapping_Acount_EmpId='$emp_id'  ORDER BY asitek_bill_register.id desc ")->getResultArray();
                } else {
                    $data["dax"] = $this->db->query("select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id where asitek_bill_register.compeny_id='$compeny_id' and Bill_Acceptation_Status='4' and Clear_Bill_Form_Status='4' and ERP_Status='4' and  Recived_Status='$Satus' and Mapping_Acount_EmpId='$emp_id'  ORDER BY asitek_bill_register.id desc")->getResultArray();
                }
            }

            if(empty($Unit_Id) && empty($Vendor_Id) && empty($assignedto) && !empty($Satus)){
                if ($Satus == "All") {
                    $data["dax"] = $this->db->query("select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id where asitek_bill_register.compeny_id='$compeny_id' and Bill_Acceptation_Status='4' and Clear_Bill_Form_Status='4' and ERP_Status='4' and Mapping_Acount_EmpId='$emp_id' ORDER BY asitek_bill_register.id desc ")->getResultArray();
                } else {
                    $data["dax"] = $this->db->query("select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id where asitek_bill_register.compeny_id='$compeny_id' and Bill_Acceptation_Status='4' and Clear_Bill_Form_Status='4' and ERP_Status='4' and  Recived_Status='$Satus' and Mapping_Acount_EmpId='$emp_id' ORDER BY asitek_bill_register.id desc")->getResultArray();
                }
            }
            if(empty($Unit_Id) && empty($Vendor_Id) && empty($assignedto) && empty($Satus)){
                $data["dax"] = $this->db->query("select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id where asitek_bill_register.compeny_id='$compeny_id' and Bill_Acceptation_Status='4' and Clear_Bill_Form_Status='4' and ERP_Status='4' and Mapping_Acount_EmpId='$emp_id' ORDER BY asitek_bill_register.id desc ")->getResultArray();
            }

            // Only Status  Filter wise End Code
        }
        // Other Roll End

        $model6 = new StateModel();
        $data["dax6"] = $model6->findAll();
        $model1 = new CityModel();
        $data["dax1"] = $model1->findAll();

        $model9 = new DepartmentModel();
        $data["dax9"] = $model9->where("compeny_id", $compeny_id)->findAll();

        $model3 = new EmployeeModel();
        $builderrecommended = $this->db->table("asitek_company_vendor");
        $builderrecommended->select('asitek_company_vendor.Vendor_Id, asitek_party_user.id, asitek_party_user.GST_No, asitek_party_user.Name');
        $builderrecommended->join('asitek_party_user', 'asitek_party_user.id = asitek_company_vendor.Vendor_Id');
        $builderrecommended->where('asitek_company_vendor.Company_Id', $compeny_id);
        $builderrecommended->groupBy('asitek_company_vendor.Vendor_Id');
        $data_recommended = $builderrecommended->get()->getResult();
        $data['dax14'] =$data_recommended;

        $model15 = new UnitModel();
        $data["dax15"] = $model15->where("compeny_id", $compeny_id)->findAll();

        $model16 = new DepartmentModel();
        $data["dax16"] = $model16->where("compeny_id", $compeny_id)->findAll();

        return view("view_complete_bill_list", $data);
    }
    //***********Complete View bill List End ****************

    //**SINGLE BILL MAPPING DETAILS**//
    //**************Mapping Bill Start***************
    public function sigle_bill_list($billid)
    {
        //$billid=$_GET['id'];
        $session = \Config\Services::session();
        $result = $session->get();
        $etm = $result["ddn"];
        $Roll_id = $session->get("Roll_id");
        $emp_id = $session->get("emp_id");
        $compeny_id = $session->get("compeny_id");
        $BillRegisterModelObj = new BillRegisterModel();
        $employeeModel = new PageaccessionModel();
        $model6 = new StateModel();
        $data["dax6"] = $model6->findAll();
        $model1 = new CityModel();
        $data["dax1"] = $model1->findAll();
        $model9 = new DepartmentModel();
        $data["dax9"] = $model9->where("compeny_id", $compeny_id)->findAll();
        $model3 = new EmployeeModel();
        $model14 = new PartyUserModel();
        $data["dax14"] = $model14->findAll();
        $model15 = new UnitModel();
        $data["dax15"] = $model15->where("compeny_id", $compeny_id)->findAll();
        $model16 = new DepartmentModel();
        $data["dax16"] = $model16->where("compeny_id", $compeny_id)->findAll();
        $model17 = new BillTypeModel();
        $data["dax17"] = $model17->where("compeny_id", $compeny_id)->findAll();
        $rollpage = $employeeModel->pagelinkaccordingtoroll($emp_id);
        $menu = $rollpage->get()->getResult();
        //Admin Roll
        if ($Roll_id == 1) {
            // sigle_bill_mapping_list Start
            $BillRegisterrow = $BillRegisterModelObj
                ->where("compeny_id", $compeny_id)
                ->where("id", $billid)
                ->where("Bill_Acceptation_Status!=", 4)
                ->first();
            if (isset($BillRegisterrow) && $BillRegisterrow != "") {
                $data["dax"] = $this->db
                    ->query(
                        "select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id where asitek_bill_register.compeny_id='$compeny_id' and asitek_bill_register.id='$billid'"
                    )
                    ->getResultArray();
                return view("sigle_bill_mapping_list", $data);
            }
            // sigle_bill_mapping_list End
            // single_Clear_Bill_Form_list Start
            $BillRegisterrow = $BillRegisterModelObj
                ->where("compeny_id", $compeny_id)
                ->where("id", $billid)
                ->where("Bill_Acceptation_Status", 4)
                ->where("Clear_Bill_Form_Status!=", 4)
                ->first();
            if (isset($BillRegisterrow) && $BillRegisterrow != "") {
                $data["dax"] = $this->db
                    ->query(
                        "select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id where asitek_bill_register.compeny_id='$compeny_id' and asitek_bill_register.id='$billid' and Bill_Acceptation_Status='4' "
                    )
                    ->getResultArray();
                return view("single_Clear_Bill_Form_list", $data);
            }
            // single_Clear_Bill_Form_list End
            // single_erpStystem_list Start
            $BillRegisterrow = $BillRegisterModelObj
                ->where("compeny_id", $compeny_id)
                ->where("id", $billid)
                ->where("Bill_Acceptation_Status", 4)
                ->where("Clear_Bill_Form_Status", 4)
                ->where("ERP_Status!=", 4)
                ->first();
            if (isset($BillRegisterrow) && $BillRegisterrow != "") {
                $data["dax"] = $this->db
                    ->query(
                        "select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id where asitek_bill_register.compeny_id='$compeny_id' and asitek_bill_register.id='$billid' and Bill_Acceptation_Status='4' and Clear_Bill_Form_Status='4'"
                    )
                    ->getResultArray();
                return view("single_erpStystem_list", $data);
            }
            // single_erpStystem_list End
            // single_recived_bill_list Start
            $BillRegisterrow = $BillRegisterModelObj
                ->where("compeny_id", $compeny_id)
                ->where("id", $billid)
                ->where("Bill_Acceptation_Status", 4)
                ->where("Clear_Bill_Form_Status", 4)
                ->where("ERP_Status", 4)
                ->where("Recived_Status!=", 4)
                ->first();
            if (isset($BillRegisterrow) && $BillRegisterrow != "") {
                $data["dax"] = $this->db
                    ->query(
                        "select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id where asitek_bill_register.compeny_id='$compeny_id' and asitek_bill_register.id='$billid' and Bill_Acceptation_Status='4' and Clear_Bill_Form_Status='4' and ERP_Status='4' "
                    )
                    ->getResultArray();
                return view("single_recived_bill_list", $data);
            }
            // single_view_complete_bill_list Start
            $BillRegisterrow = $BillRegisterModelObj
                ->where("compeny_id", $compeny_id)
                ->where("id", $billid)
                ->where("Bill_Acceptation_Status", 4)
                ->where("Clear_Bill_Form_Status", 4)
                ->where("ERP_Status", 4)
                ->where("Recived_Status", 4)
                ->first();
            if (isset($BillRegisterrow) && $BillRegisterrow != "") {
                $data["dax"] = $this->db
                    ->query(
                        "select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id where asitek_bill_register.compeny_id='$compeny_id' and asitek_bill_register.id='$billid' and Bill_Acceptation_Status='4' and Clear_Bill_Form_Status='4' and ERP_Status='4' and Recived_Status='4' "
                    )
                    ->getResultArray();
                return view("single_view_complete_bill_list", $data);
            }
            // single_view_complete_bill_list End
            // No Bill Id Start
            $BillRegisterrow = $BillRegisterModelObj
                ->where("compeny_id", $compeny_id)
                ->where("id!=", $billid)
                ->first();
            if (isset($BillRegisterrow) && $BillRegisterrow != "") {
                return redirect("main-dashboard");
            }
            //  No Bill Id Start  End
        }
        // Admin Role End
        //Bill Mapper Roll Start
        elseif ($Roll_id == 2) {
            if(isset($menu)){  
                foreach ($menu as $menun){ 
                    if($menun->Page_Id==4){
                        $BillRegisterrow = $BillRegisterModelObj->where("compeny_id", $compeny_id)->where("id", $billid)->first();
                        if (isset($BillRegisterrow) && $BillRegisterrow != "") {
                            $data["dax"] = $this->db->query("select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id where asitek_bill_register.compeny_id='$compeny_id' and asitek_bill_register.id='$billid'"
                                )->getResultArray();
                            return view("sigle_bill_mapping_list", $data);
                        } else {
                            $session->setFlashdata("success", "<div class='alert alert-danger' role='alert'> You are not authorize to process this bill (Either it is not assigned to you) </div>");
                            return redirect("main-dashboard");
                        }
                    }
                    if($menun->Page_Id==5){
                        $BillRegisterrow = $BillRegisterModelObj->where("compeny_id", $compeny_id)->where("id", $billid)->where("Bill_Acceptation_Status", 4)->where("Department_Emp_Id", $emp_id)->first();
                        if (isset($BillRegisterrow) && $BillRegisterrow != "") {
                            $data["dax"] = $this->db
                                ->query(
                                    "select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id where asitek_bill_register.compeny_id='$compeny_id' and asitek_bill_register.id='$billid' and Bill_Acceptation_Status='4' and Department_Emp_Id='$emp_id' "
                                )
                                ->getResultArray();
                            return view("single_Clear_Bill_Form_list", $data);
                        } else {
                            $session->setFlashdata("success", "<div class='alert alert-danger' role='alert'> You are not authorize to process this bill (Either it is not assigned to you) </div>");
                            return redirect("main-dashboard");
                        }
                    }
                    if($menun->Page_Id==6){
                        $BillRegisterrow = $BillRegisterModelObj->where("compeny_id", $compeny_id)->where("id", $billid)->where("Bill_Acceptation_Status", 4)->where("Clear_Bill_Form_Status", 4)->where("Mapping_ERP_EmpId", $emp_id)->first();
                        if (isset($BillRegisterrow) && $BillRegisterrow != "") {
                            $data["dax"] = $this->db
                                ->query(
                                    "select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id where asitek_bill_register.compeny_id='$compeny_id' and asitek_bill_register.id='$billid' and Bill_Acceptation_Status='4' and Clear_Bill_Form_Status='4' and Mapping_ERP_EmpId='$emp_id'"
                                )
                                ->getResultArray();
                            return view("single_erpStystem_list", $data);
                        } else {
                            $session->setFlashdata("success", "<div class='alert alert-danger' role='alert'> You are not authorize to process this bill (Either it is not assigned to you) </div>");
                            return redirect("main-dashboard");
                        }
                    }
                    if($menun->Page_Id==6){
                        $BillRegisterrow = $BillRegisterModelObj->where("compeny_id", $compeny_id)->where("id", $billid)->where("Bill_Acceptation_Status", 4)->where("Clear_Bill_Form_Status", 4)->where("ERP_Status", 4)->where("Mapping_Acount_EmpId", $emp_id)->first();
                        if (isset($BillRegisterrow) && $BillRegisterrow != "") {
                            $data["dax"] = $this->db
                                ->query(
                                    "select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id where asitek_bill_register.compeny_id='$compeny_id' and asitek_bill_register.id='$billid' and Bill_Acceptation_Status='4' and Clear_Bill_Form_Status='4' and ERP_Status='4' and Mapping_Acount_EmpId='$emp_id' "
                                )
                                ->getResultArray();
                            return view("single_recived_bill_list", $data);
                        } else {
                            $session->setFlashdata("success", "<div class='alert alert-danger' role='alert'> You are not authorize to process this bill (Either it is not assigned to you) </div>");
                            return redirect("main-dashboard");
                        }
                    }
                }
            }
        }
        

        else {
            return redirect("main-dashboard");
        }
    }

    //Scan Qr
    public function scanqr()
    {
        return view("scanqr");
    }

    public function onmodalpopup()
    {
        $session = \Config\Services::session();
        $model = new BillRegisterModel();
        $uid = $this->request->getVar("billid");
        $companyid = $this->request->getVar("companyid");
        $billid = $this->db
            ->query(
                "SELECT id from asitek_bill_register WHERE compeny_id='$companyid' AND uid = '$uid' AND Bill_Acceptation_Status=1"
            )
            ->getResult(); // Adjust the column name based on your database structure

        if (isset($billid) && !empty($billid)) {
            $billidvalue = $billid[0]->id;
            $Bill_Acceptation_Status = $this->request->getVar(
                "Bill_Acceptation_Status"
            );
            $Bill_Acceptation_Status_Comments = $this->request->getVar(
                "Bill_Acceptation_Status_Comments"
            );
            $id = $billidvalue;

            date_default_timezone_set("Asia/Kolkata");
            $Bill_Acceptation_DateTime = date("Y-m-d H:i:s");

            $data = [
                "Bill_Acceptation_Status" => $Bill_Acceptation_Status,
                "Bill_Acceptation_DateTime" => $Bill_Acceptation_DateTime,
                "Bill_Acceptation_Status_Comments" => $Bill_Acceptation_Status_Comments,
            ];

            $Add_RewardPoint = 20;
            $Remark = $this->request->getVar(
                "Bill_Acceptation_Status_Comments"
            );
            if ($Remark != "") {
                $Remark_RewardPoint = 20;
            } else {
                $Remark_RewardPoint = 0;
            }
            $reward_point = $Add_RewardPoint + $Remark_RewardPoint;
            $reward_point_type = "Accept For Bill Assigment";
            $session_compeny_id = $session->get("compeny_id");
            $session_emp_id = $session->get("emp_id");
            $DateTimenew = date("Y-m-d H:i:s");
            $dataRewardPoint = [
                "bill_id" => $id,
                "compeny_id" => $session_compeny_id,
                "emp_id" => $session_emp_id,
                "reward_point" => $reward_point,
                "reward_point_type" => $reward_point_type,
                "rec_time_stamp" => $DateTimenew,
            ];
            $RewardPointobj = new RewardPointModel();
            if ($Bill_Acceptation_Status == 2) {
                $RewardPoint = $RewardPointobj->insert($dataRewardPoint);
            }

            if (
                $model
                    ->where("id", $id)
                    ->set($data)
                    ->update()
            ) {
                $data = [
                    "status" => "success",
                    "message" => "Bill Accepted successfully!",
                ];

                return $this->response->setJSON($data);
            }
        } else {
            $data = [
                "status" => "success",
                "message" => "Bill already accepted!",
            ];
            return $this->response->setJSON($data);
        }
    }

    public function ajaxshowform()
    {
        $session = \Config\Services::session();
        $result = $session->get();
        $DepartmentModelObj = new DepartmentModel();
        $EmployeeModelObj = new EmployeeModel();
        $BillRegisterModelObj = new BillRegisterModel();
        $model17 = new BillTypeModel();
        $model18 = new UnitModel();
        $companyid = $this->request->getVar("companyid");
        $billid = $this->request->getVar("billid");
        $selectbill = $this->request->getVar("selectbill");
        $depart = $this->request->getVar("depart");

        $billmainid = $this->db
            ->query(
                "SELECT id from asitek_bill_register WHERE compeny_id='$companyid' AND uid = '$billid'"
            )
            ->getResult();
        $billidvalue = $billmainid[0]->id;
        $Departmentrow = $DepartmentModelObj
            ->where("compeny_id", $companyid)
            ->where("id", $depart)
            ->first();
        $billrow = $BillRegisterModelObj
            ->where("compeny_id", $companyid)
            ->where("id", $billidvalue)
            ->first();
        ?>
        <input type="hidden" name="Bill_Type" value="<?php echo $Departmentrow[
            "bill_type_id"
        ]; ?>">
        <div class="row">
            <div class="col-sm-12 col-md-6">
                <div class="form-group">
                    <label>Employee Name</label>
                    <select name="Department_Emp_Id" id="employeeid" class="form-control"  style="padding: 0.875rem 1.375rem" required> 
                        <option value="">-Select -</option> 
                        <?php
                        $Id2 = $Departmentrow["id"];
                        $builderrecommended = $this->db->table("asitek_employee as employee");
                        $builderrecommended->select('employee.*');
                        $builderrecommended->join('asitek_emp_page_access as pageac', 'pageac.Emp_Id = employee.id', 'left');
                        $builderrecommended->where('employee.compeny_id', $companyid);
                        $builderrecommended->where('employee.department', $Id2);
                        $builderrecommended->where('pageac.Page_Id', 5);
                        
                        $rowEMP = $builderrecommended->get()->getResult();
                        if (isset($rowEMP) && $rowEMP != "") {
                            foreach ($rowEMP as $rowe) { ?>
                                <?php print_r($rowEMP);?>
                                <option value="<?php echo $rowe->id; ?>" ><?php echo ucwords($rowe->first_name); ?></option>
                                <?php }
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-sm-12 col-md-6">
                <div class="form-group">
                    <label>Unit </label>
                    <select name="Unit_Id" id="unitid" class="form-control "style="padding: 0.875rem 1.375rem" id="" required> 
                        <option value="" >select</option>
                        <?php
                        $dax18 = $model18
                            ->where("compeny_id", $companyid)
                            ->findAll();
                        if (isset($dax18) && $dax18 != "") {
                            foreach ($dax18 as $row18) { ?>
                                    <option value="<?php echo $row18[
                                        "id"
                                    ]; ?>" <?php if (
    $billrow["Unit_Id"] == $row18["id"]
) {
    echo "selected";
} ?>><?php echo ucwords($row18["name"]); ?></option>
                                    <?php }
                        }
                        ?> 
                    </select>
                </div> 
            </div>
            <div class="col-sm-12 col-md-6">
                <div class="form-group">
                    <label> Actual Date & Time</label>
                    <input type="text" name="" id="actualtime" class="form-control "style="padding: 0.875rem 1.375rem" value="<?php echo $billrow[
                        "DateTime"
                    ]; ?>" readonly > 
                </div> 
            </div>             
            <div class="col-sm-12 col-md-6">
                <div class="form-group">
                    <label> TargetTimeToMaping Bill</label>
                    <input type="text" name="TargetMapping_Time_Hours" id="targetmappingtimehours" class="form-control "style="padding: 0.875rem 1.375rem" value="<?php echo $Departmentrow[
                        "Mapping_Time_Hours"
                    ]; ?>" readonly  > 
                </div> 
            </div>
            <?php
            $time = $Departmentrow["Mapping_Time_Hours"];
            [$hours, $minutes] = explode(":", $time);
            $minitus = (int) $hours * 60 + (int) $minutes;
            $cur_time = $billrow["DateTime"];
            $duration = "+" . $minitus . " minutes";
            $addedDateTime = date(
                "Y-m-d H:i:s",
                strtotime($duration, strtotime($cur_time))
            );
            $cur_Datetime = date("Y-m-d H:i:s");
            ?>
            <div class="col-sm-12 col-md-6">
                <div class="form-group">
                    <label>Delay Or  On-Time</label>
                    <select name="Mapping_Delay_On_Time" id="mappingdelaytime" class="form-control "style="padding: 0.875rem 1.375rem" > 
                        <?php if ($addedDateTime >= $cur_Datetime) { ?>
                            <option value="On-Time" selected>On-Time</option> 
                            <?php } else { ?>
                            <option value="Delay" selected>Delay</option> 
                            <?php } ?>
                    </select>
                </div> 
            </div>
            <div class="col-sm-12 col-md-6">
                <div class="form-group">
                    <label>Remark</label>
                    <textarea name="Mapping_Remark" id="mappingremark" class="form-control"></textarea>
                </div> 
            </div>
        </div>
        <?php
    }

    public function submitformasteraction()
    {
        $session = \Config\Services::session();
        $email = \Config\Services::email();
        $model = new BillRegisterModel();
        $vendormodel = new PartyUserModel();
        $companymodel = new CompenyModel();
        $empmodel = new EmployeeModel();
        $depmodel = new DepartmentModel();
        $companyid = $this->request->getVar("companyid");
        $uid = $this->request->getVar("billid");
        $selectbill = $this->request->getVar("selectbill");
        $depart = $this->request->getVar("depart");
        $employeeid = $this->request->getVar("employeeid");
        $unitid = $this->request->getVar("unitid");
        $actualtime = $this->request->getVar("actualtime");
        $targetmappingtimehours = $this->request->getVar(
            "targetmappingtimehours"
        );
        $mappingdelaytime = $this->request->getVar("mappingdelaytime");
        $mappingremark = $this->request->getVar("mappingremark");

        $billid = $this->db
            ->query(
                "SELECT id,Department_Id,Department_Emp_Id, Vendor_Id from asitek_bill_register WHERE compeny_id='$companyid' AND uid = '$uid' AND (Bill_Acceptation_Status = '2' OR Bill_Acceptation_Status = '4')"
            )
            ->getResult(); // Adjust the column name based on your database structure

        if (isset($billid) && !empty($billid)) {
            $billidvalue = $billid[0]->id;
            $vendorvalue = $billid[0]->Vendor_Id;
            if ($billid[0]->Department_Id != null) {
                $depid = $billid[0]->Department_Id;
            } else {
                $depid = "";
            }
            if ($billid[0]->Department_Emp_Id != null) {
                $depempid = $billid[0]->Department_Emp_Id;
            } else {
                $depempid = "";
            }

            $vdr = $vendormodel->where("id", $vendorvalue)->first();
            $cpn = $companymodel->where("id", $companyid)->first();
            $emp = $empmodel->where("id", $employeeid)->first();
            $dep = $depmodel->where("id", $depart)->first();

            if (empty($depid) && empty($depempid)) {
                $Bill_Acceptation_Status = $this->request->getVar(
                    "Bill_Acceptation_Status"
                );
                $Bill_Acceptation_Status_Comments = $this->request->getVar(
                    "Bill_Acceptation_Status_Comments"
                );
                $id = $billidvalue;

                date_default_timezone_set("Asia/Kolkata");
                $Bill_Acceptation_DateTime = date("Y-m-d H:i:s");

                $data = [
                    "Unit_Id" => $unitid,
                    "Department_Id" => $depart,
                    "Department_Emp_Id" => $employeeid,
                    "Bill_Acceptation_Status" => 4,
                    "Bill_Type" => $selectbill,
                    "TargetMapping_Time_Hours" => $targetmappingtimehours,
                    "Mapping_Delay_On_Time" => $mappingdelaytime,
                    "Mapping_Remark" => $mappingremark,
                ];

                if (
                    $model
                        ->where("id", $id)
                        ->set($data)
                        ->update()
                ) {
                    // ****Start RewardPoint**
                    $Add_RewardPoint = 20;

                    if ($mappingremark != "") {
                        $Remark_RewardPoint = 20;
                    } else {
                        $Remark_RewardPoint = 0;
                    }

                     $BillRegObjNew = new BillRegisterModel();
                          //$id3 = $this->request->getVar("billid");
                           $BillRegrow= $BillRegObjNew->where('id', $id)->first();
                           $Bill_DateTime2=$BillRegrow['Bill_DateTime'];
                           $currentmonth=date("Y-m-d H:i:s");
                           
                           $month = date('m', strtotime($currentmonth));
                            $month2 = date('m', strtotime($Bill_DateTime2));
                            if($month<=$month2)
                            {
                                  $reward_point = $Add_RewardPoint + $Remark_RewardPoint;
                            }
                            else
                            {
                            $reward_point =0;
                            }

                    $reward_point_type = "send this bill for verification";
                    $session_compeny_id = $session->get("compeny_id");
                    $session_emp_id = $session->get("emp_id");
                    $DateTimenew = date("Y-m-d H:i:s");
                    $dataRewardPoint = [
                        "bill_id" => $id,
                        "compeny_id" => $session_compeny_id,
                        "emp_id" => $session_emp_id,
                        "reward_point" => $reward_point,
                        "reward_point_type" => $reward_point_type,
                        "rec_time_stamp" => $DateTimenew,
                    ];
                    $RewardPointobj = new RewardPointModel();
                    $RewardPoint = $RewardPointobj->insert($dataRewardPoint);

                    $wpmsg =
                        "Hello " .
                        $vdr["Name"] .
                        ", Just a quick update: going forward, please ensure that all your bills are mapped to, " .
                        $emp["first_name"] .
                        " in the " .
                        $dep["name"] .
                        " Best regards, " .
                        $cpn["name"];
                    // $url = "https://chatway.in/api/send-msg?username=ashrishaWCH&number=+91".$vdr['Mobile_No']."&message=".$wpmsg."&token=Y21iQk9IeExwbjluMGE2SUxhM2taQT09";
                    // $url = preg_replace("/ /", "%20", $url);
                    // $response = file_get_contents($url);

                    // $email->setFrom(
                    //     "singhshaan085@gmail.com",
                    //     "Bill Management"
                    // );
                    // $email->setTo($vdr["Email_Id"]);
                    // $email->setSubject("Bill Add in Company | Bill Management");
                    // $email->setmailType("html");
                    // $email->setMessage($wpmsg); //your message here
                    // $email->send();

                    $data = [
                        "status" => "success",
                        "message" => "Bill Send for Verification successfully!",
                    ];

                    return $this->response->setJSON($data);
                }
            } else {
                $data = [
                    "status" => "success",
                    "message" => "Already Assigned!",
                ];

                return $this->response->setJSON($data);
            }
        } else {
            $data = [
                "status" => "success",
                "message" => "Bill is not accepted. Please Accept the bill!",
            ];

            return $this->response->setJSON($data);
        }
    }

    public function submitbillforverification()
    {
        $session = \Config\Services::session();
        $model = new BillRegisterModel();
        $uid = $this->request->getVar("billid");
        $companyid = $this->request->getVar("companyid");
        $billid = $this->db
            ->query(
                "SELECT id from asitek_bill_register WHERE compeny_id='$companyid' AND uid = '$uid' AND Clear_Bill_Form_Status=1"
            )
            ->getResult(); // Adjust the column name based on your database structure

        if (isset($billid) && !empty($billid)) {
            $billidvalue = $billid[0]->id;
            $Clear_Bill_Form_Status = $this->request->getVar(
                "Clear_Bill_Form_Status"
            );
            $Clear_Bill_Form_Status_Comments = $this->request->getVar(
                "Clear_Bill_Form_Status_Comments"
            );
            $id = $billidvalue;

            date_default_timezone_set("Asia/Kolkata");
            $Clear_Bill_Form_DateTime = date("Y-m-d H:i:s");
            $data = [
                "Clear_Bill_Form_Status" => $Clear_Bill_Form_Status,
                "Clear_Bill_Form_DateTime" => $Clear_Bill_Form_DateTime,
                "Clear_Bill_Form_Status_Comments" => $Clear_Bill_Form_Status_Comments,
            ];

            if (
                $model
                    ->where("id", $id)
                    ->set($data)
                    ->update()
            ) {
                $Add_RewardPoint = 10;
                if ($Clear_Bill_Form_Status_Comments != "") {
                    $Remark_RewardPoint = 10;
                } else {
                    $Remark_RewardPoint = 0;
                }
                   $BillRegObjNew = new BillRegisterModel();
                         // $id3 = $this->request->getVar("billid");
                           $BillRegrow= $BillRegObjNew->where('id', $id)->first();
                           $Bill_DateTime2=$BillRegrow['Bill_DateTime'];
                           $currentmonth=date("Y-m-d H:i:s");
                           
                           $month = date('m', strtotime($currentmonth));
                            $month2 = date('m', strtotime($Bill_DateTime2));
                            if($month<=$month2)
                            {
                                     $reward_point = $Add_RewardPoint + $Remark_RewardPoint;
                            }
                            else
                            {
                            $reward_point =0;
                            }

             
                $reward_point_type = "Accept For Bill Verfiy";
                $session_compeny_id = $session->get("compeny_id");
                $session_emp_id = $session->get("emp_id");
                $DateTimenew = date("Y-m-d H:i:s");
                $dataRewardPoint = [
                    "bill_id" => $id,
                    "compeny_id" => $session_compeny_id,
                    "emp_id" => $session_emp_id,
                    "reward_point" => $reward_point,
                    "reward_point_type" => $reward_point_type,
                    "rec_time_stamp" => $DateTimenew,
                ];
                $RewardPointobj = new RewardPointModel();
                $Clear_Bill_Form_Status = $this->request->getVar(
                    "Clear_Bill_Form_Status"
                );
                if ($Clear_Bill_Form_Status == 2) {
                    $RewardPoint = $RewardPointobj->insert($dataRewardPoint);
                }

                $data = [
                    "status" => "success",
                    "message" => "Bill Accepted successfully!",
                ];

                return $this->response->setJSON($data);
            }
        } else {
            $data = [
                "status" => "success",
                "message" => "Bill already accepted!",
            ];
            return $this->response->setJSON($data);
        }
    }

    public function submitBillForMasterVerification()
    {
        $session = \Config\Services::session();
        $result = $session->get();
        $model = new BillRegisterModel();
        $MasterActionmadelObj = new MasterActionModel();
        $MasterActionUploadModelObj = new MasterActionUploadModel();
        $request = $this->request;
        // Validate incoming data if needed
        // Retrieve form data
        $companyid = $request->getPost("companyid");
        $uid = $request->getPost("billid");
        $masteractionid = $request->getPost("masteractionid");
        $remark = $request->getPost("remark");
        $stage_id = $request->getPost("stage_id");
        $E_Image = $request->getFile("E_Image");

        $billid = $this->db
            ->query(
                "SELECT id from asitek_bill_register WHERE compeny_id='$companyid' AND uid = '$uid' AND ( Clear_Bill_Form_Status=2 OR ERP_Status=2 OR Recived_Status=2)"
            )
            ->getResult();
        if (isset($billid) && !empty($billid)) {
            $billidvalue = $billid[0]->id;
            if (!empty($E_Image)) {
                // Handle file upload
                if ($E_Image->isValid() && !$E_Image->hasMoved()) {
                    $newName = $E_Image->getRandomName();
                    $E_Image->move(
                        "public/vendors/PicUploadMasterAction",
                        $newName
                    );
                } else {
                    $data = [
                        "status" => "error",
                        "message" => "Image is not uploaded",
                    ];

                    return $this->response->setJSON($data);
                }
            } else {
                $newName = "";
            }

            $rowMasterAction1 = $MasterActionmadelObj
                ->where("stage_id", $stage_id)
                ->where("id", $masteractionid)
                ->first();
            $data2 = [
                "compeny_id" => $companyid,
                "bill_id" => $billidvalue,
                "master_action_id" => $masteractionid,
                "image_upload" => $newName,
                "remark" => $remark,
            ];
            $insert = $MasterActionUploadModelObj->insert($data2);

            if ($insert) {
                if ($stage_id == 3) {
                    $model
                        ->where("id", $billidvalue)
                        ->set(
                            "ClearFormBill_Master_Action",
                            $rowMasterAction1["no_of_action"]
                        )
                        ->update();

                    $MasterActionmadelObj = new MasterActionModel();
                    $rowMasterAction1 = $MasterActionmadelObj
                        ->where("compeny_id", $companyid)
                        ->where("stage_id", $stage_id)
                        ->orderBy("id", "desc")
                        ->first();
                    if (isset($rowMasterAction1) && $rowMasterAction1 != "") {
                        if ($rowMasterAction1["id"] == $masteractionid) {
                            $Add_RewardPoint = 10;
                            $Remark = $this->request->getVar("remark");
                            if ($Remark != "") {
                                $Remark_RewardPoint = 10;
                            } else {
                                $Remark_RewardPoint = 0;
                            }
                            $E_Image = $this->request->getFile("E_Image");
                            if ($E_Image != "") {
                                $FileAttch_RewardPoint = 10;
                            } else {
                                $FileAttch_RewardPoint = 0;
                            }
                            

                                $BillRegObjNew = new BillRegisterModel();
                         // $id3 = $this->request->getVar("billid");
                           $BillRegrow= $BillRegObjNew->where('id', $billidvalue)->first();
                           $Bill_DateTime2=$BillRegrow['Bill_DateTime'];
                           $currentmonth=date("Y-m-d H:i:s");
                           
                           $month = date('m', strtotime($currentmonth));
                            $month2 = date('m', strtotime($Bill_DateTime2));
                            if($month<=$month2)
                            {
                                    $reward_point =
                                $Add_RewardPoint +
                                $Remark_RewardPoint +
                                $FileAttch_RewardPoint;
                            }
                            else
                            {
                            $reward_point =0;
                            }

                            $reward_point_type = "Master Action Bill Entity";
                            $session_compeny_id = $session->get("compeny_id");
                            $session_emp_id = $session->get("emp_id");
                            $DateTimenew = date("Y-m-d H:i:s");
                            $dataRewardPoint = [
                                "bill_id" => $billidvalue,
                                "compeny_id" => $session_compeny_id,
                                "emp_id" => $session_emp_id,
                                "reward_point" => $reward_point,
                                "reward_point_type" => $reward_point_type,
                                "rec_time_stamp" => $DateTimenew,
                            ];
                            $RewardPointobj = new RewardPointModel();
                            $RewardPoint = $RewardPointobj->insert(
                                $dataRewardPoint
                            );
                        } else {
                        }
                    }

                    $data = [
                        "status" => "success",
                        "message" => "Master Action Added",
                    ];

                    return $this->response->setJSON($data);
                } elseif ($stage_id == 4) {
                    $model
                        ->where("id", $billidvalue)
                        ->set(
                            "ERP_Master_Action",
                            $rowMasterAction1["no_of_action"]
                        )
                        ->update();

                    $MasterActionmadelObj = new MasterActionModel();
                    $rowMasterAction1 = $MasterActionmadelObj
                        ->where("compeny_id", $companyid)
                        ->where("stage_id", $stage_id)
                        ->orderBy("id", "desc")
                        ->first();
                    if (isset($rowMasterAction1) && $rowMasterAction1 != "") {
                        if ($rowMasterAction1["id"] == $masteractionid) {
                            $Add_RewardPoint = 10;
                            $Remark = $this->request->getVar("remark");
                            if ($Remark != "") {
                                $Remark_RewardPoint = 10;
                            } else {
                                $Remark_RewardPoint = 0;
                            }
                            $E_Image = $this->request->getFile("E_Image");
                            if ($E_Image != "") {
                                $FileAttch_RewardPoint = 10;
                            } else {
                                $FileAttch_RewardPoint = 0;
                            }
                           


                                   $BillRegObjNew = new BillRegisterModel();
                         // $id3 = $this->request->getVar("billid");
                           $BillRegrow= $BillRegObjNew->where('id', $billidvalue)->first();
                           $Bill_DateTime2=$BillRegrow['Bill_DateTime'];
                           $currentmonth=date("Y-m-d H:i:s");
                           
                           $month = date('m', strtotime($currentmonth));
                            $month2 = date('m', strtotime($Bill_DateTime2));
                            if($month<=$month2)
                            {
                                   $reward_point =
                                $Add_RewardPoint +
                                $Remark_RewardPoint +
                                $FileAttch_RewardPoint;
                            }
                            else
                            {
                            $reward_point =0;
                            }
                            

                            $reward_point_type = "Master Action Bill Entity";
                            $session_compeny_id = $session->get("compeny_id");
                            $session_emp_id = $session->get("emp_id");
                            $DateTimenew = date("Y-m-d H:i:s");
                            $dataRewardPoint = [
                                "bill_id" => $billidvalue,
                                "compeny_id" => $session_compeny_id,
                                "emp_id" => $session_emp_id,
                                "reward_point" => $reward_point,
                                "reward_point_type" => $reward_point_type,
                                "rec_time_stamp" => $DateTimenew,
                            ];
                            $RewardPointobj = new RewardPointModel();
                            $RewardPoint = $RewardPointobj->insert(
                                $dataRewardPoint
                            );
                        } else {
                        }
                    }

                    $data = [
                        "status" => "success",
                        "message" => "Master Action Added",
                    ];

                    return $this->response->setJSON($data);
                } elseif ($stage_id == 5) {
                    $model
                        ->where("id", $billidvalue)
                        ->set(
                            "Recived_Master_Action",
                            $rowMasterAction1["no_of_action"]
                        )
                        ->update();

                    $MasterActionmadelObj = new MasterActionModel();
                    $rowMasterAction1 = $MasterActionmadelObj
                        ->where("compeny_id", $companyid)
                        ->where("stage_id", $stage_id)
                        ->orderBy("id", "desc")
                        ->first();
                    if (isset($rowMasterAction1) && $rowMasterAction1 != "") {
                        if ($rowMasterAction1["id"] == $masteractionid) {
                            $Add_RewardPoint = 10;
                            $Remark = $this->request->getVar("remark");
                            if ($Remark != "") {
                                $Remark_RewardPoint = 10;
                            } else {
                                $Remark_RewardPoint = 0;
                            }
                            $E_Image = $this->request->getFile("E_Image");
                            if ($E_Image != "") {
                                $FileAttch_RewardPoint = 10;
                            } else {
                                $FileAttch_RewardPoint = 0;
                            }


                                   $BillRegObjNew = new BillRegisterModel();
                         // $id3 = $this->request->getVar("billid");
                           $BillRegrow= $BillRegObjNew->where('id', $billidvalue)->first();
                           $Bill_DateTime2=$BillRegrow['Bill_DateTime'];
                           $currentmonth=date("Y-m-d H:i:s");
                           
                           $month = date('m', strtotime($currentmonth));
                            $month2 = date('m', strtotime($Bill_DateTime2));
                            if($month<=$month2)
                            {
                                     $reward_point =
                                $Add_RewardPoint +
                                $Remark_RewardPoint +
                                $FileAttch_RewardPoint;
                            }
                            else
                            {
                            $reward_point =0;
                            }

                          
                            $reward_point_type = "Master Action Bill Entity";
                            $session_compeny_id = $session->get("compeny_id");
                            $session_emp_id = $session->get("emp_id");
                            $DateTimenew = date("Y-m-d H:i:s");
                            $dataRewardPoint = [
                                "bill_id" => $billidvalue,
                                "compeny_id" => $session_compeny_id,
                                "emp_id" => $session_emp_id,
                                "reward_point" => $reward_point,
                                "reward_point_type" => $reward_point_type,
                                "rec_time_stamp" => $DateTimenew,
                            ];
                            $RewardPointobj = new RewardPointModel();
                            $RewardPoint = $RewardPointobj->insert(
                                $dataRewardPoint
                            );
                        } else {
                        }
                    }

                    $data = [
                        "status" => "success",
                        "message" => "Master Action Added",
                    ];

                    return $this->response->setJSON($data);
                }
            }
        } else {
            $data = [
                "status" => "success",
                "message" =>
                    "Either bill is not accepted or it is sent to bill entry",
            ];

            return $this->response->setJSON($data);
        }
    }

    public function sendBilltoentry()
    {
        $session = \Config\Services::session();
        $email = \Config\Services::email();
        $result = $session->get();
        $model = new BillRegisterModel();
        $vendormodel = new PartyUserModel();
        $companymodel = new CompenyModel();
        $MasterActionmadelObj = new MasterActionModel();
        $MasterActionUploadModelObj = new MasterActionUploadModel();
        $request = $this->request;
        // Validate incoming data if needed
        // Retrieve form data
        $companyid = $request->getPost("companyid");
        $uid = $request->getPost("billid");
        $mappingerpid = $request->getPost("mappingerpid");
        $targetclearbillformtimrhours = $request->getPost(
            "targetclearbillformtimrhours"
        );
        $actualdatetime = $request->getPost("actualdatetime");
        $clearbillformdelayontime = $request->getPost(
            "clearbillformdelayontime"
        );
        $clearbillremark = $request->getPost("clearbillremark");
        $E_Image = $request->getFile("E_Image");
        $billid = $this->db
            ->query(
                "SELECT id, Vendor_Id from asitek_bill_register WHERE compeny_id='$companyid' AND uid = '$uid' AND Clear_Bill_Form_Status = '2'"
            )
            ->getResult();
        if (isset($billid) && !empty($billid)) {
            $billidvalue = $billid[0]->id;
            $vendorvalue = $billid[0]->Vendor_Id;

            $vdr = $vendormodel->where("id", $companyid)->first();
            $cpn = $companymodel->where("id", $vendorvalue)->first();

            if (!empty($E_Image)) {
                // Handle file upload
                if ($E_Image->isValid() && !$E_Image->hasMoved()) {
                    $newName = $E_Image->getRandomName();
                    $E_Image->move(
                        "public/vendors/PicUploadMasterAction",
                        $newName
                    );
                } else {
                    $data = [
                        "status" => "error",
                        "message" => "Image is not uploaded",
                    ];

                    return $this->response->setJSON($data);
                }
            } else {
                $newName = "";
            }

            $data = [
                "Mapping_ERP_EmpId" => $mappingerpid,
                "Clear_Bill_Form_Status" => 4,
                "TargetClearBillForm_Time_Hours" => $targetclearbillformtimrhours,
                "ClearBillForm_Delay_On_Time" => $clearbillformdelayontime,
                "Clear_Bill_Form_AnyImage" => $newName,
                "ClearBillForm_Remark" => $clearbillremark,
            ];

            if (
                $model
                    ->where("id", $billidvalue)
                    ->set($data)
                    ->update()
            ) {
                // ****Start RewardPoint**
                $Add_RewardPoint = 10;

                if ($clearbillremark != "") {
                    $Remark_RewardPoint = 10;
                } else {
                    $Remark_RewardPoint = 0;
                }

                if ($newName != "") {
                    $FileAttch_RewardPoint = 10;
                } else {
                    $FileAttch_RewardPoint = 0;
                }

                        $BillRegObjNew = new BillRegisterModel();
                         // $id3 = $this->request->getVar("billid");
                           $BillRegrow= $BillRegObjNew->where('id', $billidvalue)->first();
                           $Bill_DateTime2=$BillRegrow['Bill_DateTime'];
                           $currentmonth=date("Y-m-d H:i:s");
                           
                           $month = date('m', strtotime($currentmonth));
                            $month2 = date('m', strtotime($Bill_DateTime2));
                            if($month<=$month2)
                            {
                                     $reward_point =
                    $Add_RewardPoint +
                    $Remark_RewardPoint +
                    $FileAttch_RewardPoint;
                            }
                            else
                            {
                            $reward_point =0;
                            }
                            

               
                $reward_point_type =
                    "send this bill for entry process (forward)";
                $session_compeny_id = $session->get("compeny_id");
                $session_emp_id = $session->get("emp_id");
                $DateTimenew = date("Y-m-d H:i:s");
                $dataRewardPoint = [
                    "bill_id" => $billidvalue,
                    "compeny_id" => $session_compeny_id,
                    "emp_id" => $session_emp_id,
                    "reward_point" => $reward_point,
                    "reward_point_type" => $reward_point_type,
                    "rec_time_stamp" => $DateTimenew,
                ];
                $RewardPointobj = new RewardPointModel();
                $RewardPoint = $RewardPointobj->insert($dataRewardPoint);
                // ****End RewardPoint**

                $wpmsg =
                    "Dear " .
                    $vdr["Name"] .
                    ", We're delighted to inform you that your bill has been verified by the relevant department and has been forwarded to our ERP system for entry.. Thank you for your prompt submission  and cooperation! Best regards, " .
                    $cpn["name"];
                // $url = "https://chatway.in/api/send-msg?username=ashrishaWCH&number=+91".$vdr['Mobile_No']."&message=".$wpmsg."&token=Y21iQk9IeExwbjluMGE2SUxhM2taQT09";
                // $url = preg_replace("/ /", "%20", $url);
                // $response = file_get_contents($url);

                // $email->setFrom("singhshaan085@gmail.com", "Bill Management");
                // $email->setTo($vdr["Email_Id"]);
                // $email->setSubject("Bill Add in Company | Bill Management");
                // $email->setmailType("html");
                // $email->setMessage($wpmsg); //your message here
                // $email->send();

                $data = [
                    "status" => "success",
                    "message" => "Bill send to entry",
                ];

                return $this->response->setJSON($data);
            }
        }
        $data = [
            "status" => "success",
            "message" => "Bill already Send",
        ];

        return $this->response->setJSON($data);
    }

    public function erpacceptbill()
    {
        $session = \Config\Services::session();
        $model = new BillRegisterModel();
        $uid = $this->request->getVar("billid");
        $companyid = $this->request->getVar("companyid");
        $billid = $this->db
            ->query(
                "SELECT id from asitek_bill_register WHERE compeny_id='$companyid' AND uid = '$uid' AND ERP_Status = '1'"
            )
            ->getResult(); // Adjust the column name based on your database structure

        if (isset($billid) && !empty($billid)) {
            $billidvalue = $billid[0]->id;
            $erpstatus = $this->request->getVar("erpstatus");
            $erpcomment = $this->request->getVar("erpcomment");
            $id = $billidvalue;

            date_default_timezone_set("Asia/Kolkata");
            $erpdateTime = date("Y-m-d H:i:s");
            $data = [
                "ERP_Status" => $erpstatus,
                "ERP_Comment" => $erpdateTime,
                "ERP_DateTime" => $erpcomment,
            ];

            if (
                $model
                    ->where("id", $id)
                    ->set($data)
                    ->update()
            ) {
                // ****Start RewardPoint**
                $Add_RewardPoint = 10;
                if ($erpcomment != "") {
                    $Remark_RewardPoint = 10;
                } else {
                    $Remark_RewardPoint = 0;
                }

                 $BillRegObjNew = new BillRegisterModel();
                         // $id3 = $this->request->getVar("billid");
                           $BillRegrow= $BillRegObjNew->where('id', $billidvalue)->first();
                           $Bill_DateTime2=$BillRegrow['Bill_DateTime'];
                           $currentmonth=date("Y-m-d H:i:s");
                           
                           $month = date('m', strtotime($currentmonth));
                            $month2 = date('m', strtotime($Bill_DateTime2));
                            if($month<=$month2)
                            {
                                 $reward_point = $Add_RewardPoint + $Remark_RewardPoint;
                            }
                            else
                            {
                            $reward_point =0;
                            }

               
                $reward_point_type = "Accept For Bill Entry";
                $session_compeny_id = $session->get("compeny_id");
                $session_emp_id = $session->get("emp_id");
                $DateTimenew = date("Y-m-d H:i:s");
                $dataRewardPoint = [
                    "bill_id" => $billidvalue,
                    "compeny_id" => $session_compeny_id,
                    "emp_id" => $session_emp_id,
                    "reward_point" => $reward_point,
                    "reward_point_type" => $reward_point_type,
                    "rec_time_stamp" => $DateTimenew,
                ];
                $RewardPointobj = new RewardPointModel();

                if ($erpstatus == 2) {
                    $RewardPoint = $RewardPointobj->insert($dataRewardPoint);
                }
                // ****End RewardPoint**

                $data = [
                    "status" => "success",
                    "message" => "Bill Accepted successfully!",
                ];

                return $this->response->setJSON($data);
            }
        } else {
            $data = [
                "status" => "success",
                "message" => "Bill Already Accepted",
            ];

            return $this->response->setJSON($data);
        }
    }

    public function sendToBillReceiving()
    {
        $session = \Config\Services::session();
        $email = \Config\Services::email();
        $result = $session->get();
        $model = new BillRegisterModel();
        $vendormodel = new PartyUserModel();
        $companymodel = new CompenyModel();
        $MasterActionmadelObj = new MasterActionModel();
        $MasterActionUploadModelObj = new MasterActionUploadModel();
        $request = $this->request;
        // Validate incoming data if needed
        // Retrieve form data
        $companyid = $request->getPost("companyid");
        $uid = $request->getPost("billid");
        $mappingacountempid = $request->getPost("mappingacountempid");
        $targeterptimehours = $request->getPost("targeterptimehours");
        $actualdatetime = $request->getPost("actualdatetime");
        $erpdelayontime = $request->getPost("erpdelayontime");
        $erpremark = $request->getPost("erpremark");
        $E_Image = $request->getFile("E_Image");
        $billid = $this->db
            ->query(
                "SELECT id, Vendor_Id from asitek_bill_register WHERE compeny_id='$companyid' AND uid = '$uid' AND ERP_Status = '2'"
            )
            ->getResult();
        if (isset($billid) && !empty($billid)) {
            $billidvalue = $billid[0]->id;
            $vendorvalue = $billid[0]->Vendor_Id;

            $vdr = $vendormodel->where("id", $vendorvalue)->first();
            $cpn = $companymodel->where("id", $companyid)->first();

            if (!empty($E_Image)) {
                // Handle file upload
                if ($E_Image->isValid() && !$E_Image->hasMoved()) {
                    $newName = $E_Image->getRandomName();
                    $E_Image->move(
                        "public/vendors/PicUploadMasterAction",
                        $newName
                    );
                } else {
                    $data = [
                        "status" => "error",
                        "message" => "Image is not uploaded",
                    ];

                    return $this->response->setJSON($data);
                }
            } else {
                $newName = "";
            }

            $data = [
                "Mapping_Acount_EmpId" => $mappingacountempid,
                "ERP_Status" => 4,
                "Target_ERP_Time_Hours" => $targeterptimehours,
                "ERP_Delay_On_Time" => $erpdelayontime,
                "ERP_AnyImage" => $newName,
                "ERP_Remark" => $erpremark,
            ];

            if (
                $model
                    ->where("id", $billidvalue)
                    ->set($data)
                    ->update()
            ) {
                // ****Start RewardPoint**
                $Add_RewardPoint = 10;
                if ($erpremark != "") {
                    $Remark_RewardPoint = 10;
                } else {
                    $Remark_RewardPoint = 0;
                }
                if ($newName != "") {
                    $FileAttch_RewardPoint = 10;
                } else {
                    $FileAttch_RewardPoint = 0;
                }

                $BillRegObjNew = new BillRegisterModel();
                         // $id3 = $this->request->getVar("billid");
                           $BillRegrow= $BillRegObjNew->where('id', $billidvalue)->first();
                           $Bill_DateTime2=$BillRegrow['Bill_DateTime'];
                           $currentmonth=date("Y-m-d H:i:s");
                           
                           $month = date('m', strtotime($currentmonth));
                            $month2 = date('m', strtotime($Bill_DateTime2));
                            if($month<=$month2)
                            {
                             $reward_point = $Add_RewardPoint +$Remark_RewardPoint + $FileAttch_RewardPoint;
                            }
                            else
                            {
                            $reward_point =0;
                            }
                            

         
                $reward_point_type =
                    "send this bill Bill Recived A/C (forward)";
                $session_compeny_id = $session->get("compeny_id");
                $session_emp_id = $session->get("emp_id");
                $DateTimenew = date("Y-m-d H:i:s");
                $dataRewardPoint = [
                    "bill_id" => $billidvalue,
                    "compeny_id" => $session_compeny_id,
                    "emp_id" => $session_emp_id,
                    "reward_point" => $reward_point,
                    "reward_point_type" => $reward_point_type,
                    "rec_time_stamp" => $DateTimenew,
                ];
                $RewardPointobj = new RewardPointModel();
                $RewardPoint = $RewardPointobj->insert($dataRewardPoint);
                // ****End RewardPoint**
                $wpmsg =
                    "Dear " .
                    $vdr["Name"] .
                    " We would like to inform you that your recent bill has been successfully processed through our ERP system. Thank you for your prompt submission! Best regards, " .
                    $cpn["name"];
                // $url = "https://chatway.in/api/send-msg?username=ashrishaWCH&number=+91".$vdr['Mobile_No']."&message=".$wpmsg."&token=Y21iQk9IeExwbjluMGE2SUxhM2taQT09";
                // $url = preg_replace("/ /", "%20", $url);
                // $response = file_get_contents($url);

                // $email->setFrom("singhshaan085@gmail.com", "Bill Management");
                // $email->setTo($vdr["Email_Id"]);
                // $email->setSubject("Bill Add in Company | Bill Management");
                // $email->setmailType("html");
                // $email->setMessage($wpmsg); //your message here
                // $email->send();

                $data = [
                    "status" => "success",
                    "message" => "Bill send to Receiving",
                ];

                return $this->response->setJSON($data);
            }
        } else {
            $data = [
                "status" => "success",
                "message" =>
                    "Either bill is not accepted or it is sent to bill receiving",
            ];

            return $this->response->setJSON($data);
        }
    }

    public function billreceivedaccept()
    {
        $session = \Config\Services::session();
        $model = new BillRegisterModel();
        $uid = $this->request->getVar("billid");
        $companyid = $this->request->getVar("companyid");
        $billid = $this->db
            ->query(
                "SELECT id from asitek_bill_register WHERE compeny_id='$companyid' AND uid = '$uid' AND Recived_Status = '1'"
            )
            ->getResult(); // Adjust the column name based on your database structure

        if (isset($billid) && !empty($billid)) {
            $billidvalue = $billid[0]->id;
            $receivedstatus = $this->request->getVar("receivedstatus");
            $receivedcomment = $this->request->getVar("receivedcomment");
            $id = $billidvalue;

            date_default_timezone_set("Asia/Kolkata");
            $erpdateTime = date("Y-m-d H:i:s");
            $data = [
                "Recived_Status" => $receivedstatus,
                "Recived_Comment" => $receivedcomment,
                "Recived_DateTime" => $erpdateTime,
            ];

            if (
                $model
                    ->where("id", $id)
                    ->set($data)
                    ->update()
            ) {
                // ****Start RewardPoint**
                $Add_RewardPoint = 10;
                if ($receivedcomment != "") {
                    $Remark_RewardPoint = 10;
                } else {
                    $Remark_RewardPoint = 0;
                }

                       $BillRegObjNew = new BillRegisterModel();
                         // $id3 = $this->request->getVar("billid");
                           $BillRegrow= $BillRegObjNew->where('id', $id)->first();
                           $Bill_DateTime2=$BillRegrow['Bill_DateTime'];
                           $currentmonth=date("Y-m-d H:i:s");
                           
                           $month = date('m', strtotime($currentmonth));
                            $month2 = date('m', strtotime($Bill_DateTime2));
                            if($month<=$month2)
                            {
                                  $reward_point = $Add_RewardPoint + $Remark_RewardPoint;
                            }
                            else
                            {
                            $reward_point =0;
                            }

           
                $reward_point_type = "Accept For Bill Recived A/C";
                $session_compeny_id = $session->get("compeny_id");
                $session_emp_id = $session->get("emp_id");
                $DateTimenew = date("Y-m-d H:i:s");
                $dataRewardPoint = [
                    "bill_id" => $id,
                    "compeny_id" => $session_compeny_id,
                    "emp_id" => $session_emp_id,
                    "reward_point" => $reward_point,
                    "reward_point_type" => $reward_point_type,
                    "rec_time_stamp" => $DateTimenew,
                ];
                $RewardPointobj = new RewardPointModel();
                if ($receivedstatus == 2) {
                    $RewardPoint = $RewardPointobj->insert($dataRewardPoint);
                }

                $data = [
                    "status" => "success",
                    "message" => "Bill Accepted successfully!",
                ];

                return $this->response->setJSON($data);
            }
        } else {
            $data = [
                "status" => "success",
                "message" => "Bill already accepted!",
            ];
            return $this->response->setJSON($data);
        }
    }
    
    
    
    public function completefromBillReceiving()
    {
        $session = \Config\Services::session();
        $email = \Config\Services::email();
        $result = $session->get();
        $model = new BillRegisterModel();
        $vendormodel = new PartyUserModel();
        $companymodel = new CompenyModel();
        $MasterActionmadelObj = new MasterActionModel();
        $MasterActionUploadModelObj = new MasterActionUploadModel();
        $request = $this->request;
        // Validate incoming data if needed
        // Retrieve form data
        $companyid = $request->getPost("companyid");
        $uid = $request->getPost("billid");
        $Recived_TragetTime_Hours = $request->getPost("Recived_TragetTime_Hours");
        $completeactualdattime = $request->getPost("completeactualdattime");
        $Recived_Delay_On_Time = $request->getPost("Recived_Delay_On_Time");
        $remark = $request->getPost("remark");
        $E_Image = $request->getFile("E_Image");
        $billid = $this->db->query("SELECT id, Vendor_Id from asitek_bill_register WHERE compeny_id='$companyid' AND uid = '$uid' AND Recived_Status = '2'")->getResult();
        if (isset($billid) && !empty($billid)) {
            $billidvalue = $billid[0]->id;
            $vendorvalue = $billid[0]->Vendor_Id;

            $vdr = $vendormodel->where("id", $vendorvalue)->first();
            $cpn = $companymodel->where("id", $companyid)->first();

            if (!empty($E_Image)) {
                // Handle file upload
                if ($E_Image->isValid() && !$E_Image->hasMoved()) {
                    $newName = $E_Image->getRandomName();
                    $E_Image->move(
                        "public/vendors/PicUploadMasterAction",
                        $newName
                    );
                } else {
                    $data = [
                        "status" => "error",
                        "message" => "Image is not uploaded",
                    ];

                    return $this->response->setJSON($data);
                }
            } else {
                $newName = "";
            }

            $data = [
                "Recived_Status" => 4,
                "Recived_TragetTime_Hours" => $Recived_TragetTime_Hours,
                "Recived_Delay_On_Time" => $Recived_Delay_On_Time,
                "Recived_AnyImage" => $newName,
                "Recived_Remark" => $remark,
            ];

            if (
                $model
                    ->where("id", $billidvalue)
                    ->set($data)
                    ->update()
            ) {
                // ****Start RewardPoint**
                $Add_RewardPoint = 10;
                if ($remark != "") {
                    $Remark_RewardPoint = 10;
                } else {
                    $Remark_RewardPoint = 0;
                }
                if ($newName != "") {
                    $FileAttch_RewardPoint = 10;
                } else {
                    $FileAttch_RewardPoint = 0;
                }

                $BillRegObjNew = new BillRegisterModel();
                // $id3 = $this->request->getVar("billid");
                $BillRegrow= $BillRegObjNew->where('id', $billidvalue)->first();
                $Bill_DateTime2=$BillRegrow['Bill_DateTime'];
                $currentmonth=date("Y-m-d H:i:s");
                $month = date('m', strtotime($currentmonth));
                $month2 = date('m', strtotime($Bill_DateTime2));
                if($month<=$month2)
                {
                    $reward_point = $Add_RewardPoint +$Remark_RewardPoint + $FileAttch_RewardPoint;
                }
                else
                {
                    $reward_point =0;
                }
                $reward_point_type ="send this bill Bill Recived A/C (forward)";
                $session_compeny_id = $session->get("compeny_id");
                $session_emp_id = $session->get("emp_id");
                $DateTimenew = date("Y-m-d H:i:s");
                $dataRewardPoint = [
                    "bill_id" => $billidvalue,
                    "compeny_id" => $session_compeny_id,
                    "emp_id" => $session_emp_id,
                    "reward_point" => $reward_point,
                    "reward_point_type" => $reward_point_type,
                    "rec_time_stamp" => $DateTimenew,
                ];
                $RewardPointobj = new RewardPointModel();
                $RewardPoint = $RewardPointobj->insert($dataRewardPoint);
                // ****End RewardPoint**
                $wpmsg =
                    "Dear " .
                    $vdr["Name"] .
                    " We wanted to inform you that your bill has been successfully received by our accounting department. Thank you for your prompt submission! Best regards, " .
                    $cpn["name"];
                // $url = "https://chatway.in/api/send-msg?username=ashrishaWCH&number=+91".$vdr['Mobile_No']."&message=".$wpmsg."&token=Y21iQk9IeExwbjluMGE2SUxhM2taQT09";
                // $url = preg_replace("/ /", "%20", $url);
                // $response = file_get_contents($url);

                // $email->setFrom("singhshaan085@gmail.com", "Bill Management");
                // $email->setTo($vdr["Email_Id"]);
                // $email->setSubject("Bill Add in Company | Bill Management");
                // $email->setmailType("html");
                // $email->setMessage($wpmsg); //your message here
                // $email->send();

                $data = [
                    "status" => "success",
                    "message" => "Bill send to Receiving",
                ];

                return $this->response->setJSON($data);
            }
        } else {
            $data = [
                "status" => "success",
                "message" =>
                    "Bill already completed",
            ];

            return $this->response->setJSON($data);
        }
    }
    
    
    

    public function page404()
    {
        $session = \Config\Services::session();
        $companyid = $session->get("compeny_id");
        $data["companyid"] = $companyid;
        return view("404", $data);
    }

    //**************Mapping Bill Start***************
    public function complete_detail_of_sigle_bill($billid)
    {
        $session = \Config\Services::session();
        $result = $session->get();
        $etm = $result["ddn"];
        $Roll_id = $session->get("Roll_id");
        $emp_id = $session->get("emp_id");
        $compeny_id = $session->get("compeny_id");
        
        $data["dax"] = $this->db->query("select * from asitek_bill_register WHERE compeny_id='$compeny_id' and id='$billid'")->getResultArray();
        return view("completedetailofbill", $data);
    }
    
    public function vendor_bill_received()
    {
        $data = [
            "vendor_status" => 0,
        ];
        $emp = new BillRegisterModel();
        if ($emp->where("id", $this->request->getVar("id"))->set($data)->update()) {
            $session = \Config\Services::session();
            $session->setFlashdata("emp_up", 1);
            return redirect("all-bill-mapping-vendor-list");
        }
    }

    public function all_bill_vendor_completed_list()
    {
        $session = \Config\Services::session();
        $result = $session->get();
        $etm = $result["ddn"];
        $Roll_id = $session->get("Roll_id");
        $emp_id = $session->get("emp_id");
        $compeny_id = $session->get("compeny_id");

        $data["dax"] = $this->db
            ->query(
                "SELECT asitek_bill_register.*, asitek_employee.emp_u_id, asitek_employee.first_name, asitek_employee.last_name, asitek_compeny.name as companyname FROM asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id JOIN asitek_compeny on asitek_bill_register.compeny_id = asitek_compeny.id WHERE asitek_bill_register.Vendor_Id='$emp_id' AND asitek_bill_register.Bill_Acceptation_Status='4' AND asitek_bill_register.Clear_Bill_Form_Status='4' AND asitek_bill_register.ERP_Status='4' AND asitek_bill_register.vendor_status='0' ORDER BY asitek_bill_register.id DESC"
            )
            ->getResultArray();
        //print_r($data);
        return view("all-bill-vendor-completed-list", $data);
    }

    public function all_vendor_rejected_list()
    {
        $session = \Config\Services::session();
        $result = $session->get();
        $etm = $result["ddn"];
        $Roll_id = $session->get("Roll_id");
        $emp_id = $session->get("emp_id");
        $compeny_id = $session->get("compeny_id");

        $data["dax"] = $this->db
            ->query(
                "SELECT asitek_bill_register.*, asitek_employee.emp_u_id, asitek_employee.first_name, asitek_employee.last_name, asitek_compeny.name as companyname FROM asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id JOIN asitek_compeny on asitek_bill_register.compeny_id = asitek_compeny.id WHERE asitek_bill_register.Vendor_Id='$emp_id' AND (asitek_bill_register.Bill_Acceptation_Status='3' OR asitek_bill_register.Clear_Bill_Form_Status='3' AND asitek_bill_register.ERP_Status='3') ORDER BY asitek_bill_register.id DESC"
            )
            ->getResultArray();
        //print_r($data);
        return view("all-vendor-rejected-list", $data);
    }
}
