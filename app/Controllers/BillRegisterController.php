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
use App\Models\DepartmentnameModel;
use CodeIgniter\Controller;
use App\Models\PageaccessionModel;
use App\Models\BillShippedModel;
use App\Models\LiveBillRegisterModel;
use App\Models\BillRegisterModelDraft;
use CodeIgniter\Pager\Pager;

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
        $builderrecommended->orderBy('asitek_party_user.Name', 'ASC');
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
        $BillRegister = new BillRegisterModel();
        $Roll_id = $session->get("Roll_id");
        $emp_id = $session->get("emp_id");
        $compeny_id = $session->get("compeny_id");
        $page = $this->request->getVar('page') ?? 1;
        $perPage = 100;
        $startSerial = ($page - 1) * $perPage + 1;
        //    *************** Start Date Code 
        if ($session->has('Sesssion_start_Date')) {
            if(!empty($result['Sesssion_start_Date'])) {
                $Sesssion_start_Date_New = $result['Sesssion_start_Date']; 
            } else {
                $Sesssion_start_Date_New = '2019-05-06';    
            }
        }
        else {
            $Sesssion_start_Date_New = '2019-05-06';    
        }
        if ($session->has('Sesssion_end_Date')) {
            if(!empty($result['Sesssion_end_Date'])) {
                $Sesssion_end_Date_New = $result['Sesssion_end_Date']; 
            } else {
                $Sesssion_end_Date_New = '9019-05-06';    
            }
        }
        else {
            $Sesssion_end_Date_New = '9019-05-06';    
        }
        $date_format = '%Y-%m-%d';  

        //     ***************End  Date Code
        if ($Roll_id == 1) {
            $users = $BillRegister ->select("asitek_bill_register.*, asitek_employee.emp_u_id, asitek_employee.first_name, asitek_employee.last_name")->join('asitek_employee', 'asitek_bill_register.Add_By = asitek_employee.id', 'left')->where('asitek_bill_register.compeny_id', $compeny_id)->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$Sesssion_start_Date_New', '$date_format') AND STR_TO_DATE('$Sesssion_end_Date_New', '$date_format')")->orderBy('asitek_bill_register.id', 'desc')->paginate($perPage);

        } else {
            $users = $BillRegister ->select("asitek_bill_register.*, asitek_employee.emp_u_id, asitek_employee.first_name, asitek_employee.last_name")->join('asitek_employee', 'asitek_bill_register.Add_By = asitek_employee.id', 'left')->where('asitek_bill_register.compeny_id', $compeny_id)->where('asitek_bill_register.Add_By', $emp_id)->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$Sesssion_start_Date_New', '$date_format') AND STR_TO_DATE('$Sesssion_end_Date_New', '$date_format')")->orderBy('asitek_bill_register.id', 'desc')->paginate($perPage);
        }
        
        $model3 = new EmployeeModel();
        $builderrecommended = $this->db->table("asitek_company_vendor");
        $builderrecommended->select('asitek_company_vendor.Vendor_Id, asitek_party_user.id, asitek_party_user.GST_No, asitek_party_user.Name');
        $builderrecommended->join('asitek_party_user', 'asitek_party_user.id = asitek_company_vendor.Vendor_Id');
        $builderrecommended->where('asitek_company_vendor.Company_Id', $compeny_id);
        $builderrecommended->groupBy('asitek_company_vendor.Vendor_Id');
        $builderrecommended->orderBy('asitek_party_user.Name', 'ASC');
        $data_recommended = $builderrecommended->get()->getResult();
        
        $model15 = new UnitModel();
        $dax15= $model15->where("compeny_id", $compeny_id)->findAll();
        $model16 = new DepartmentModel();
        $dax16 = $model16->where("compeny_id", $compeny_id)->findAll();
        $data = [
            'users' => $users,
            'pager' => $BillRegister->pager,
            'startSerial' => $startSerial,
            'nextPage' => $page + 1,
            'previousPage' => ($page > 1) ? $page - 1 : null,
            'dax14' => $data_recommended,
            'dax15' => $dax15,
            'dax16' => $dax16,
        ];  
        return view("view_bill_register", $data);
    }

    public function view_bill_register_vendor_draft()
    {
        $session = \Config\Services::session();
        $result = $session->get();
        $BillRegister = new BillRegisterModelDraft();
        $Roll_id = $session->get("Roll_id");
        $emp_id = $session->get("emp_id");
        $compeny_id = $session->get("compeny_id");
        $page = $this->request->getVar('page') ?? 1;
        $perPage = 100;
        $startSerial = ($page - 1) * $perPage + 1;
        //    *************** Start Date Code 
        if ($session->has('Sesssion_start_Date')) {
            if(!empty($result['Sesssion_start_Date'])) {
                $Sesssion_start_Date_New = $result['Sesssion_start_Date']; 
            } else {
                $Sesssion_start_Date_New = '2019-05-06';    
            }
        }
        else {
            $Sesssion_start_Date_New = '2019-05-06';    
        }
        if ($session->has('Sesssion_end_Date')) {
            if(!empty($result['Sesssion_end_Date'])) {
                $Sesssion_end_Date_New = $result['Sesssion_end_Date']; 
            } else {
                $Sesssion_end_Date_New = '9019-05-06';    
            }
        }
        else {
            $Sesssion_end_Date_New = '9019-05-06';    
        }
        $date_format = '%Y-%m-%d';  

        //     ***************End  Date Code
        if ($Roll_id == 1) {
            $users = $BillRegister ->select("asitek_bill_register_draft.*, asitek_employee.emp_u_id, asitek_employee.first_name, asitek_employee.last_name")->join('asitek_employee', 'asitek_bill_register_draft.Add_By = asitek_employee.id', 'left')->where('asitek_bill_register_draft.compeny_id', $compeny_id)->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$Sesssion_start_Date_New', '$date_format') AND STR_TO_DATE('$Sesssion_end_Date_New', '$date_format')")->orderBy('asitek_bill_register_draft.id', 'desc')->paginate($perPage);

        } else {
            $users = $BillRegister ->select("asitek_bill_register_draft.*, asitek_employee.emp_u_id, asitek_employee.first_name, asitek_employee.last_name")->join('asitek_employee', 'asitek_bill_register_draft.Add_By = asitek_employee.id', 'left')->where('asitek_bill_register_draft.compeny_id', $compeny_id)->where('asitek_bill_register_draft.Add_By', $emp_id)->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$Sesssion_start_Date_New', '$date_format') AND STR_TO_DATE('$Sesssion_end_Date_New', '$date_format')")->orderBy('asitek_bill_register_draft.id', 'desc')->paginate($perPage);
        }
        
        $model3 = new EmployeeModel();
        $builderrecommended = $this->db->table("asitek_company_vendor");
        $builderrecommended->select('asitek_company_vendor.Vendor_Id, asitek_party_user.id, asitek_party_user.GST_No, asitek_party_user.Name');
        $builderrecommended->join('asitek_party_user', 'asitek_party_user.id = asitek_company_vendor.Vendor_Id');
        $builderrecommended->where('asitek_company_vendor.Company_Id', $compeny_id);
        $builderrecommended->groupBy('asitek_company_vendor.Vendor_Id');
        $builderrecommended->orderBy('asitek_party_user.Name', 'ASC');
        $data_recommended = $builderrecommended->get()->getResult();
        
        $model15 = new UnitModel();
        $dax15= $model15->where("compeny_id", $compeny_id)->findAll();
        $model16 = new DepartmentModel();
        $dax16 = $model16->where("compeny_id", $compeny_id)->findAll();
        $data = [
            'users' => $users,
            'pager' => $BillRegister->pager,
            'startSerial' => $startSerial,
            'nextPage' => $page + 1,
            'previousPage' => ($page > 1) ? $page - 1 : null,
            'dax14' => $data_recommended,
            'dax15' => $dax15,
            'dax16' => $dax16,
        ];  
        return view("view_bill_register_vendor_draft", $data);
    }

    public function add_bill_vendor()
    {
        $session = \Config\Services::session();
        $result = $session->get();
        $emp_id = $session->get("emp_id");
        $BillRegister = new BillRegisterModelDraft();

        $page = $this->request->getVar('page') ?? 1;
        $perPage = 50;
        $startSerial = ($page - 1) * $perPage + 1;

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
        
        $userbill = $BillRegister->select("asitek_bill_register_draft.*, asitek_employee.emp_u_id, asitek_employee.first_name, asitek_employee.last_name,asitek_compeny.name as companyname")->join('asitek_employee', 'asitek_bill_register_draft.Add_By = asitek_employee.id', 'left')->join('asitek_compeny', 'asitek_bill_register_draft.compeny_id = asitek_compeny.id')->join('asitek_vendor_company', 'asitek_compeny.id = asitek_vendor_company.Company_Id')->where('asitek_bill_register_draft.Vendor_Id', $emp_id)->where('asitek_vendor_company.Vendor_Id', $emp_id)->orderBy('asitek_bill_register_draft.Bill_DateTime', 'desc')->paginate($perPage);

        $data = [
            'company' => $data_recommended,
            'billdrftlist' => $userbill,
            'pager' => $BillRegister->pager,
            'startSerial' => $startSerial,
            'nextPage' => $page + 1,
            'previousPage' => ($page > 1) ? $page - 1 : null,
        ];

        return view("add-bill-vendor", $data);
    }

    // public function vendor_store_bill_register()
    // {
    //     $session = \Config\Services::session();
    //     $result = $session->get();
    //     $BillRegister = new BillRegisterModel();
    //     $validation = \Config\Services::validation();
    //     $file = $this->request->getFile("E_Image");
    //     if ($file != "") {
    //         $validation->setRules([
    //             "E_Image" =>
    //                 "uploaded[E_Image]|ext_in[E_Image,jpg,JPG,png,PNG,jpeg,JPEG,pdf]",
    //         ]);
    //         if (!$validation->withRequest($this->request)->run()) {
    //             $data["error"] = $validation->getErrors();
    //             $this->index();
    //             return redirect("add-bill-vendor");
    //         } else {
    //             $imageName = $file->getRandomName();
    //             $file->move("public/vendors/PicUpload", $imageName);
    //         }
    //     } else {
    //         $imageName = "";
    //     }

    //     $uid = $this->db
    //         ->table("asitek_bill_register")
    //         ->where("compeny_id", $this->request->getVar("company_id"))
    //         ->countAllResults();
    //     $uidno = $uid + 1;

    //     $Gate_Entry_Date = date(
    //         "Y-m-d",
    //         strtotime($this->request->getVar("Gate_Entry_Date"))
    //     );
    //     $DateTime = date("Y-m-d H:i:s");
    //     $billduplicacy = $BillRegister->where("Vendor_Id", $this->request->getVar("vendor_id"))->where("Bill_No", $this->request->getVar("Bill_No"))->findAll();
    //     if(!empty($billduplicacy)){
    //         $session->setFlashdata(
    //             "success",
    //             " <div class='text-red-800' role='alert'> Bill No already added </div>"
    //         );
    //         return redirect("add-bill-vendor");
    //     }
    //     else{
    //         $data = [
    //             "uid" => $uidno,
    //             "compeny_id" => $this->request->getVar("company_id"),
    //             "Add_By" => $this->request->getVar("Add_By"),
    //             "Bill_No" => $this->request->getVar("Bill_No"),
    //             "Gate_Entry_No" => $this->request->getVar("Gate_Entry_No"),
    //             "Unit_Id" => $this->request->getVar("Unit_Id"),
    //             "Vendor_Id" => $this->request->getVar("vendor_id"),
    //             "Bill_DateTime" => $this->request->getVar("Bill_DateTime"),
    //             "Gate_Entry_Date" => $this->request->getVar("Gate_Entry_Date"),
    //             "Bill_Amount" => $this->request->getVar("Bill_Amount"),
    //             "Remark" => $this->request->getVar("Remark"),
    //             "Bill_Pic" => $imageName,
    //             "DateTime" => $DateTime,
    //             "Department_Id" => $this->request->getVar("Department_Id"),
    //             "Add_By_Vendor" => 1,
    //         ];
    //         $BillRegisterinsert = $BillRegister->insert($data);
    //         $lastId = $BillRegister->getInsertID();
    //         $string2 = "REG";
    //         $Bill_No = $lastId;
    //         if ($BillRegisterinsert) {
    //             $session = \Config\Services::session();
    //             $session->setFlashdata(
    //                 "success",
    //                 "<div class='text-green-800' > Form Submition Successful. Bill Id : $uidno </div>"
    //             );
    //             return redirect("add-bill-vendor");
    //         } else {
    //             $session->setFlashdata(
    //                 "success",
    //                 " <div class='text-red-800' role='alert'> Problem in Submition! </div>"
    //             );
    //             return redirect("add-bill-vendor");
    //         }
    //     }
    // }

    public function vendor_store_bill_register()
    {
        $session = \Config\Services::session();
        $result = $session->get();
        $BillRegister = new BillRegisterModelDraft();
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
                $file->move("public/vendors/PicUploadDraft", $imageName);
            }
        } else {
            $imageName = "";
        }

        $uid = $this->db
            ->table("asitek_bill_register_draft")
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
                " <div class='text-red-800' role='alert'> Bill No already added </div>"
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
                    "<div class='text-green-800' > Form Submition Successful. Bill Id : $uidno </div>"
                );
                return redirect("add-bill-vendor");
            } else {
                $session->setFlashdata(
                    "success",
                    " <div class='text-red-800' role='alert'> Problem in Submition! </div>"
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
        $db2 = \Config\Database::connect('second'); // second DB
        $BillRegister = new BillRegisterModel();
        $vendormodel = new PartyUserModel();
        $companymodel = new CompenyModel();
        $file = $this->request->getFile("E_Image");
        if ($file != "") {
            $validation->setRules([
                "E_Image" => "uploaded[E_Image]|ext_in[E_Image,jpg,JPG,png,PNG,jpeg,JPEG,pdf]",
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

        $uid = $this->db->table("asitek_bill_register")->where("compeny_id", $this->request->getVar("compeny_id"))->countAllResults();

        $uidno = $uid + 1;
        

        $vdr = $vendormodel->where("id", $this->request->getVar("Vendor_Id"))->first();

        $cpn = $companymodel->where("id", $this->request->getVar("compeny_id"))->first();

        $Gate_Entry_Date = date("Y-m-d", strtotime($this->request->getVar("Gate_Entry_Date")));
        $DateTime = date("Y-m-d H:i:s");

        $billduplicacy = $BillRegister->where("Vendor_Id", $this->request->getVar("Vendor_Id"))->where("Bill_No", $this->request->getVar("Bill_No"))->findAll();
        if(!empty($billduplicacy)){
            $session->setFlashdata("success", "<div class='alert alert-danger' role='alert'> Bill No already added </div>");
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
                $session->setFlashdata("success","<div class='alert alert-success' role='alert'> Form Submition Successful. Bill Id : $uidno </div>");

                $wpmsg = "Hi " .$vdr["Name"] .", Just a quick heads up - your recent invoice has been successfully added to Company records. Thanks for your prompt submission! Best regards, " .$cpn["name"];
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
                    $reward_point = $Add_RewardPoint + $Remark_RewardPoint + $FileAttch_RewardPoint;
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
                }
                else
                {
                    $currentDay = date('d');
                    if ($currentDay <= 10) {
                        $reward_point = $Add_RewardPoint + $Remark_RewardPoint + $FileAttch_RewardPoint;
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
                    }
                    else{
                        $reward_point = 0;
                    }
                }

                // ****End RewardPoint**
                return redirect("add_bill_register");
            } else {
                $session->setFlashdata("success"," <div class='alert alert-danger' role='alert'> Problem in Submition! </div>");
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
            "Gate_Entry_Date" => $this->request->getVar("Gate_Entry_Date"),
            "Bill_Amount" => $this->request->getVar("Bill_Amount"),
            "Remark" => $this->request->getVar("Remark"),
            "Bill_Pic" => $imageName,
        ];
        $emp = new BillRegisterModel();
        if (
            $emp
                ->where("id", $this->request->getVar("id"))
                ->set($data)
                ->update()
        ) {
            $Bill_Url=$this->request->getVar("Bill_Url");
            if($Bill_Url=='All')
            {
                $session = \Config\Services::session();
                $session->setFlashdata("emp_up", 1);
                return redirect("view_bill_register");
            }
            else
            {     
                $session = \Config\Services::session();  
                $session->setFlashdata("emp_up", 1);
                $id=$this->request->getVar("id")
                ?>
                <script type="text/javascript"> 
                    window.location.href="<?php echo base_url("/index.php/sigle_bill_list/" . $id); ?>"
                </script>
                <?php
            }
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
        $model = new BillRegisterModel();
        $page = $this->request->getVar('page') ?? 1;
        $perPage = 25;
        $startSerial = ($page - 1) * $perPage + 1;
        $Roll_id = $session->get("Roll_id");
        $emp_id = $session->get("emp_id");
        $compeny_id = $session->get("compeny_id");
        
        // Retrieve filter parameters
        $Unit_Id = $this->request->getVar('Unit_Id');
        $Vendor_Id = $this->request->getVar('Vendor_Id');
        $assignedto = $this->request->getVar('assignedto');
        $Satus = $this->request->getVar('Satus');

        $session->set(["Unit_Id" => $Unit_Id,"Vendor_Id" => $Vendor_Id,"assignedto" => $assignedto,"Satus" => $Satus]);
        
        // Default start and end date values
        $defaultStartDate = '2019-05-06';
        $defaultEndDate = '9019-05-06';
        
        // Retrieve session start and end date values
        $Sesssion_start_Date_New = !empty($session->get('Sesssion_start_Date')) ? $session->get('Sesssion_start_Date') : $defaultStartDate;
        $Sesssion_end_Date_New = !empty($session->get('Sesssion_end_Date')) ? $session->get('Sesssion_end_Date') : $defaultEndDate;
        
        // Date format for SQL query
        $date_format = '%Y-%m-%d';
        if ($Roll_id == 1||$Roll_id == 2) {
            // Build the query
            $query = $model->select("asitek_bill_register.*, asitek_employee.emp_u_id, asitek_employee.first_name, asitek_employee.last_name")
                           ->join('asitek_employee', 'asitek_bill_register.Add_By = asitek_employee.id', 'left')
                           ->where('asitek_bill_register.compeny_id', $compeny_id)
                           ->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$Sesssion_start_Date_New', '$date_format') AND STR_TO_DATE('$Sesssion_end_Date_New', '$date_format')");
        
            // Add filters if they are not empty
            if (!empty($Unit_Id)) {
                $query->where('asitek_bill_register.Unit_Id', $Unit_Id);
            }
        
            if (!empty($Vendor_Id)) {
                $query->where('asitek_bill_register.Vendor_Id', $Vendor_Id);
            }
        
            if (!empty($assignedto)) {
                $query->where('asitek_bill_register.Department_Emp_Id', $assignedto);
            }
        
            if (!empty($Satus) && $Satus !== 'All') {
                $query->where('asitek_bill_register.Bill_Acceptation_Status', $Satus);
            }
        
            // Execute the query with pagination
            $users = $query->orderBy('asitek_bill_register.id', 'desc')->paginate($perPage);
            
            $model9 = new DepartmentModel();
            $dax9= $model9->where("compeny_id", $compeny_id)->findAll();
            $model3 = new EmployeeModel();
            $builderrecommended = $this->db->table("asitek_company_vendor");
            $builderrecommended->select('asitek_company_vendor.Vendor_Id, asitek_party_user.id, asitek_party_user.GST_No, asitek_party_user.Name');
            $builderrecommended->join('asitek_party_user', 'asitek_party_user.id = asitek_company_vendor.Vendor_Id');
            $builderrecommended->where('asitek_company_vendor.Company_Id', $compeny_id);
            $builderrecommended->groupBy('asitek_company_vendor.Vendor_Id');
            $builderrecommended->orderBy('asitek_party_user.Name', 'ASC');
            $data_recommended = $builderrecommended->get()->getResult();
            //$data['dax14'] =$data_recommended;
            $model15 = new UnitModel();
            $dax15 = $model15->where("compeny_id", $compeny_id)->findAll();
            $model16 = new DepartmentModel();
            $dax16 = $model16->where("compeny_id", $compeny_id)->findAll();
            $model17 = new BillTypeModel();
            $dax17 = $model17->where("compeny_id", $compeny_id)->findAll();
            $data = [
                'users' => $users,
                'pager' => $model->pager,
                'startSerial' => $startSerial,
                'nextPage' => $page + 1,
                'previousPage' => ($page > 1) ? $page - 1 : null,
                'dax9' => $dax9,
                'dax14' => $data_recommended,
                'dax15' => $dax15,
                'dax16' => $dax16,
                'dax17' => $dax17,
            ];
        
            return view("all_bill_mapping_list", $data);
        }
        else{
            // Build the query
            $query = $model->select("asitek_bill_register.*, asitek_employee.emp_u_id, asitek_employee.first_name, asitek_employee.last_name")
                           ->join('asitek_employee', 'asitek_bill_register.Add_By = asitek_employee.id', 'left')
                           ->where('asitek_bill_register.compeny_id', $compeny_id)
                           ->where('asitek_bill_register.Add_By', $emp_id)
                           ->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$Sesssion_start_Date_New', '$date_format') AND STR_TO_DATE('$Sesssion_end_Date_New', '$date_format')");
        
            // Add filters if they are not empty
            if (!empty($Unit_Id)) {
                $query->where('asitek_bill_register.Unit_Id', $Unit_Id);
            }
        
            if (!empty($Vendor_Id)) {
                $query->where('asitek_bill_register.Vendor_Id', $Vendor_Id);
            }
        
            if (!empty($assignedto)) {
                $query->where('asitek_bill_register.Department_Emp_Id', $assignedto);
            }
        
            if (!empty($Satus) && $Satus !== 'All') {
                $query->where('asitek_bill_register.Bill_Acceptation_Status', $Satus);
            }
        
            // Execute the query with pagination
            $users = $query->orderBy('asitek_bill_register.id', 'desc')->paginate($perPage);
            
            $model9 = new DepartmentModel();
            $dax9= $model9->where("compeny_id", $compeny_id)->findAll();
            $model3 = new EmployeeModel();
            $builderrecommended = $this->db->table("asitek_company_vendor");
            $builderrecommended->select('asitek_company_vendor.Vendor_Id, asitek_party_user.id, asitek_party_user.GST_No, asitek_party_user.Name');
            $builderrecommended->join('asitek_party_user', 'asitek_party_user.id = asitek_company_vendor.Vendor_Id');
            $builderrecommended->where('asitek_company_vendor.Company_Id', $compeny_id);
            $builderrecommended->groupBy('asitek_company_vendor.Vendor_Id');
            $builderrecommended->orderBy('asitek_party_user.Name', 'ASC');
            $data_recommended = $builderrecommended->get()->getResult();
            //$data['dax14'] =$data_recommended;
            $model15 = new UnitModel();
            $dax15 = $model15->where("compeny_id", $compeny_id)->findAll();
            $model16 = new DepartmentModel();
            $dax16 = $model16->where("compeny_id", $compeny_id)->findAll();
            $model17 = new BillTypeModel();
            $dax17 = $model17->where("compeny_id", $compeny_id)->findAll();
            $data = [
                'users' => $users,
                'pager' => $model->pager,
                'startSerial' => $startSerial,
                'nextPage' => $page + 1,
                'previousPage' => ($page > 1) ? $page - 1 : null,
                'dax9' => $dax9,
                'dax14' => $data_recommended,
                'dax15' => $dax15,
                'dax16' => $dax16,
                'dax17' => $dax17,
            ];
        
            return view("all_bill_mapping_list", $data);
        }
    }


    public function export_all_bill_mapping_list(){
        $session = \Config\Services::session();
        $result = $session->get(); 
        $Roll_id = $session->get("Roll_id");
        $emp_id = $session->get("emp_id");
        $compeny_id = $session->get("compeny_id");   
        $model = new BillRegisterModel();
        $UnitModelObj = new UnitModel();
        $RollModelObj = new RollModel();
        $EmployeeModelObj = new EmployeeModel();
        $PartyUserModelObj = new PartyUserModel();
        $DepartmentModelObj = new DepartmentModel();
        if ($session->has('Unit_Id')) {
             $Unit_Id = $result['Unit_Id']; 
        } else {
               $Unit_Id = ""; 
        }
        if ($session->has('Vendor_Id')) {
            echo  $Vendor_Id = $result['Vendor_Id']; 
        } else {
            echo     $Vendor_Id = ""; 
        }
        if ($session->has('assignedto')) {
             $assignedto = $result['assignedto'];
        } else {
            $assignedto = ""; 
        }
        if ($session->has('Satus')) {
            $Satus = $result['Satus']; 
        } else {
            $Satus = ""; 
        }
        // Default start and end date values
        $defaultStartDate = '2019-05-06';
        $defaultEndDate = '9019-05-06';
        
        // Retrieve session start and end date values
        $Sesssion_start_Date_New = !empty($session->get('Sesssion_start_Date')) ? $session->get('Sesssion_start_Date') : $defaultStartDate;
        $Sesssion_end_Date_New = !empty($session->get('Sesssion_end_Date')) ? $session->get('Sesssion_end_Date') : $defaultEndDate;
        // Date format for SQL query
        $date_format = '%Y-%m-%d';      

        // Excel file name for download 
        $fileName = "all_bill_mapping_list" . date('Y-m-d') . ".xls";     
        // Column names 
        $fields = array('Bill Pic', 'Bill Id', 'Vendor', 'Bill No', 'Bill Amount', 'Bill Date', 'Unit Name', 'Gate Entry No', 'Gate Entry Date', 'Add By' , 'Accepted On', 'Accepted Comment', 'Assign To','Assign Comment','Action'); 
        // Display column names as first row 
        $excelData = implode("\t", array_values($fields)) . "\n"; 
        // Fetch records from database
        if ($Roll_id == 1||$Roll_id == 2) {
            $query = $model->select("asitek_bill_register.*, asitek_employee.emp_u_id, asitek_employee.first_name, asitek_employee.last_name")
                           ->join('asitek_employee', 'asitek_bill_register.Add_By = asitek_employee.id', 'left')->where('asitek_bill_register.compeny_id', $compeny_id)->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$Sesssion_start_Date_New', '$date_format') AND STR_TO_DATE('$Sesssion_end_Date_New', '$date_format')");
        
            // Add filters if they are not empty
            if (!empty($Unit_Id)) {
                $query->where('asitek_bill_register.Unit_Id', $Unit_Id);
            }
        
            if (!empty($Vendor_Id)) {
                $query->where('asitek_bill_register.Vendor_Id', $Vendor_Id);
            }
        
            if (!empty($assignedto)) {
                $query->where('asitek_bill_register.Department_Emp_Id', $assignedto);
            }
        
            if (!empty($Satus) && $Satus !== 'All') {
                $query->where('asitek_bill_register.Bill_Acceptation_Status', $Satus);
            }
        
            // Execute the query with pagination
            $data = $query->orderBy('asitek_bill_register.id', 'desc')->findAll();


        } 
        // Other Role
        else {
            $query = $model->select("asitek_bill_register.*, asitek_employee.emp_u_id, asitek_employee.first_name, asitek_employee.last_name")
                           ->join('asitek_employee', 'asitek_bill_register.Add_By = asitek_employee.id', 'left')
                           ->where('asitek_bill_register.compeny_id', $compeny_id)
                           ->where('asitek_bill_register.Add_By', $emp_id)
                           ->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$Sesssion_start_Date_New', '$date_format') AND STR_TO_DATE('$Sesssion_end_Date_New', '$date_format')");
        
            // Add filters if they are not empty
            if (!empty($Unit_Id)) {
                $query->where('asitek_bill_register.Unit_Id', $Unit_Id);
            }
        
            if (!empty($Vendor_Id)) {
                $query->where('asitek_bill_register.Vendor_Id', $Vendor_Id);
            }
        
            if (!empty($assignedto)) {
                $query->where('asitek_bill_register.Department_Emp_Id', $assignedto);
            }
        
            if (!empty($Satus) && $Satus !== 'All') {
                $query->where('asitek_bill_register.Bill_Acceptation_Status', $Satus);
            }
        
            // Execute the query with pagination
            $data = $query->orderBy('asitek_bill_register.id', 'desc')->findAll();
        }   
        // $data = $model->orderBy('id', 'desc'->findAll(); 
        if(isset($data)){ 
            // Output each row of the data 
            foreach($data as $row)
            { 
                //*************
                if(isset($row['Bill_Pic']))
                {
                    $Bill_Pic =base_url('public/vendors/PicUpload/'.$row['Bill_Pic']);
                }
                else{ $Bill_Pic = '';}
                if(isset($row['uid'])){$uid = $row['uid'];}else{ $uid = 'NA';}
                $Vendorrow= $PartyUserModelObj->where('id',$row['Vendor_Id'])->first();
                if(isset($Vendorrow) && $Vendorrow!='')
                {
                    $VendorName= $Vendorrow['Name']; 
                }
                else
                {
                    $VendorName=''; 
                }
                if(isset($row['Bill_No'])){$Bill_No = $row['Bill_No'];}else{ $Bill_No = 'NA';}
                if(isset($row['Bill_Amount'])){$Bill_Amount = $row['Bill_Amount'];}else{ $Bill_Amount = 'NA';}
                if(isset($row['Bill_DateTime'])){$Bill_DateTime = date('d/m/Y', strtotime($row['Bill_DateTime']));}else{ $Bill_DateTime = 'NA';}
                $Unitrow= $UnitModelObj->where('id',$row['Unit_Id'])->first();
                if(isset($Unitrow) && $Unitrow!='')
                {
                    $UnitName =$Unitrow['name']; 
                }
                else{
                    $UnitName='';
                }
                if(isset($row['Gate_Entry_No'])){$Gate_Entry_No = $row['Gate_Entry_No'];}else{ $Gate_Entry_No = 'NA';}
                if(isset($row['Gate_Entry_Date'])){$Gate_Entry_Date = date('d/m/Y', strtotime($row['Gate_Entry_Date']));}else{ $Gate_Entry_Date = 'NA';}
                if(isset($row['Add_By_Vendor'])){
                    if($row['Add_By_Vendor']==1)
                    { 
                        $Add_By= "Add By Vendor";
                    }
                    else{
                        $Add_By= $row['first_name'].' '. $row['last_name'];
                    }
                }else{
                    $Add_By='';
                }
                if(isset($row['Bill_Acceptation_DateTime'])){$Bill_Acceptation_DateTime = $row['Bill_Acceptation_DateTime'];}else{ $Bill_Acceptation_DateTime = 'NA';}
                if(isset($row['Bill_Acceptation_Status_Comments'])){$Bill_Acceptation_Status_Comments = $row['Bill_Acceptation_Status_Comments'];}else{ $Bill_Acceptation_Status_Comments = 'NA';}
                $MappingEmprow= $EmployeeModelObj->where('id',$row['Department_Emp_Id'])->first();
                if(isset($MappingEmprow) && $MappingEmprow!='')
                {
                    $Department_Emp_Id= $MappingEmprow['first_name'].' '.$MappingEmprow['last_name'];
                }
                else{
                    $Department_Emp_Id=''; 
                }
                if(isset($row['Mapping_Remark'])){$Mapping_Remark = $row['Mapping_Remark'];}else{ $Mapping_Remark = 'NA';}
                if($row['Bill_Acceptation_Status']==1)
                {
                    $Status='Pending';
                }
                elseif($row['Bill_Acceptation_Status']==2)
                {
                    $Status='Accepted';
                }
                elseif($row['Bill_Acceptation_Status']==3)
                {
                    $Status='Reject';
                }
                elseif($row['Bill_Acceptation_Status']==4)
                {
                    $Status='Done';
                }
                //*************
                $lineData = array( 'link', $uid, $VendorName, $Bill_No,$Bill_Amount,$Bill_DateTime,$UnitName,$Gate_Entry_No,$Gate_Entry_Date,$Add_By,$Bill_Acceptation_DateTime,$Bill_Acceptation_Status_Comments,$Department_Emp_Id,$Mapping_Remark,$Status);
                // array_walk(str_replace('"', '""',(preg_replace("/\r?\n/", "\\n",(preg_replace("/\t/", "\\t", $lineData))))); 
                $excelData .= implode("\t", array_values($lineData)) . "\n";   
            } 
        }
        else{ 
            $session->setFlashdata('excel',1);
        } 
        // Headers for download 
        header("Content-Type: application/vnd.ms-excel"); 
        header("Content-Disposition: attachment; filename=\"$fileName\""); 
        echo $excelData; 
        exit;
    }

    //************** Bill End***************
    //**************Mapping Bill Start***************
    public function all_vendor_bill_company_wise($companyid)
    {
        $session = \Config\Services::session();
        $result = $session->get();
        $BillRegister = new BillRegisterModel();
        $page = $this->request->getVar('page') ?? 1;
        $perPage = 100;
        $startSerial = ($page - 1) * $perPage + 1;
        $Roll_id = $session->get("Roll_id");
        $emp_id = $session->get("emp_id");

        $model = new CompenyModel();
        $data["companyname"] = $model->getcompanyname($companyid);
        $data["companyid"] = $companyid;

        //    *************** Start Date Code 
        if ($session->has('Sesssion_start_Date')) {
            if(!empty($result['Sesssion_start_Date'])) {
                $start_Date = $result['Sesssion_start_Date']; 
            } else {
                $start_Date = '2019-05-06';    
            }
        }
        else {
            $start_Date = '2019-05-06';    
        }
        if ($session->has('Sesssion_end_Date')) {
            if(!empty($result['Sesssion_end_Date'])) {
                $end_Date = $result['Sesssion_end_Date']; 
            } else {
                $end_Date = '9019-05-06';    
            }
        }
        else {
            $end_Date = '9019-05-06';    
        }
        $date_format = '%Y-%m-%d';  
        //     ***************End  Date 

        $billcompany = $BillRegister ->select("asitek_bill_register.*, asitek_employee.emp_u_id, asitek_employee.first_name, asitek_employee.last_name")->join('asitek_employee', 'asitek_bill_register.Add_By = asitek_employee.id', 'left')->where('asitek_bill_register.Vendor_Id', $emp_id)->where('asitek_bill_register.compeny_id', $companyid)->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$start_Date', '$date_format') AND STR_TO_DATE('$end_Date', '$date_format')")->orderBy('asitek_bill_register.Bill_DateTime', 'desc')->paginate($perPage);

        $data = [
            'users' => $billcompany,
            'companyname'=>$model->getcompanyname($companyid),
            'companyid'=>$companyid,
            'pager' => $BillRegister->pager,
            'startSerial' => $startSerial,
            'nextPage' => $page + 1,
            'previousPage' => ($page > 1) ? $page - 1 : null,
        ];

        // $data["dax"] = $this->db
        //     ->query(
        //         "SELECT asitek_bill_register.*, asitek_employee.emp_u_id, asitek_employee.first_name, asitek_employee.last_name FROM asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id WHERE asitek_bill_register.Vendor_Id='$emp_id' AND asitek_bill_register.compeny_id='$companyid' ORDER BY asitek_bill_register.Bill_DateTime DESC"
        //     )
        //     ->getResultArray();
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
        $BillRegister = new BillRegisterModel();
        $page = $this->request->getVar('page') ?? 1;
        $perPage = 50;
        $startSerial = ($page - 1) * $perPage + 1;
        $Roll_id = $session->get("Roll_id");
        $emp_id = $session->get("emp_id");
        $compeny_id = $session->get("compeny_id");
        
           //    *************** Start Date Code 
        if ($session->has('Sesssion_start_Date')) {
            if(!empty($result['Sesssion_start_Date'])) {
                $start_Date = $result['Sesssion_start_Date']; 
            } else {
                $start_Date = '2019-05-06';    
            }
        }
        else {
            $start_Date = '2019-05-06';    
        }
        if ($session->has('Sesssion_end_Date')) {
            if(!empty($result['Sesssion_end_Date'])) {
                $end_Date = $result['Sesssion_end_Date']; 
            } else {
                $end_Date = '9019-05-06';    
            }
        }
        else {
            $end_Date = '9019-05-06';    
        }
        $date_format = '%Y-%m-%d';  
        //     ***************End  Date Code 

        $users = $BillRegister ->select("asitek_bill_register.*, asitek_employee.emp_u_id, asitek_employee.first_name, asitek_employee.last_name,asitek_compeny.name as companyname")->join('asitek_employee', 'asitek_bill_register.Add_By = asitek_employee.id', 'left')->join('asitek_compeny', 'asitek_bill_register.compeny_id = asitek_compeny.id')->join('asitek_vendor_company', 'asitek_compeny.id = asitek_vendor_company.Company_Id')->where('asitek_bill_register.Vendor_Id', $emp_id)->where('asitek_vendor_company.Vendor_Id', $emp_id)->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$start_Date', '$date_format') AND STR_TO_DATE('$end_Date', '$date_format')")->orderBy('asitek_bill_register.Bill_DateTime', 'desc')->paginate($perPage);

        $data = [
            'users' => $users,
            'pager' => $BillRegister->pager,
            'startSerial' => $startSerial,
            'nextPage' => $page + 1,
            'previousPage' => ($page > 1) ? $page - 1 : null,
        ];
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

    // public function Bill_Acceptation_StatusChange()
    // {
    //     $session = \Config\Services::session();
    //     $result = $session->get();
    //     $model = new BillRegisterModel();
    //     $Bill_Acceptation_Status = $this->request->getVar("Bill_Acceptation_Status");
    //     $Bill_Acceptation_Status_Comments = $this->request->getVar("Bill_Acceptation_Status_Comments");
    //     $id = $this->request->getVar("id");
    //     $action = $this->request->getVar("action");
    //     //$model->where('id', $id)->set('Department_Id',$Department_Id)->update();
    //     date_default_timezone_set("Asia/Kolkata");
    //     $Bill_Acceptation_DateTime = date("Y-m-d H:i:s");
    //     if($Bill_Acceptation_Status==2||$Bill_Acceptation_Status==3)
    //     {
    //         $Bill_Acceptation_Status_By_MasterId = $result["emp_id"];
    //     }
    //     else
    //     {
    //         $Bill_Acceptation_Status_By_MasterId = '';
    //     }
    //     $data = [
    //         "Bill_Acceptation_Status_By_MasterId" => $Bill_Acceptation_Status_By_MasterId,
    //         "Bill_Acceptation_Status" => $Bill_Acceptation_Status,
    //         "Bill_Acceptation_DateTime" => $Bill_Acceptation_DateTime,
    //         "Bill_Acceptation_Status_Comments" => $Bill_Acceptation_Status_Comments,
    //     ];
    //     $billid = $this->db->query("SELECT uid from asitek_bill_register WHERE id='$id' AND Bill_Acceptation_Status=1")->getResult(); // Adjust the column name based on your database structure

    //     if (isset($billid) && !empty($billid)) {
    //         if ($model->where("id", $id)->set($data)->update()) {
    //             // ****Start RewardPoint**
    //             $Add_RewardPoint = 20;
    //             $Remark = $this->request->getVar("Bill_Acceptation_Status_Comments");
    //             if ($Remark != "") {
    //                 $Remark_RewardPoint = 20;
    //             } else {
    //                 $Remark_RewardPoint = 0;
    //             }
    //             $BillRegObjNew = new BillRegisterModel();
    //             $id3 = $this->request->getVar("id");
    //             $BillRegrow= $BillRegObjNew->where('id', $id3)->first();
    //             $Bill_DateTime2=$BillRegrow['Bill_DateTime'];
    //             $currentmonth=date("Y-m-d H:i:s");
    //             $month = date('m', strtotime($currentmonth));
    //             $month2 = date('m', strtotime($Bill_DateTime2));
    //             if($month<=$month2)
    //             {
    //                 $reward_point =$Add_RewardPoint + $Remark_RewardPoint;
    //                 $reward_point_type = "Accept For Bill Assigment";
    //                 $session_compeny_id = $session->get("compeny_id");
    //                 $session_emp_id = $session->get("emp_id");
    //                 $DateTimenew = date("Y-m-d H:i:s");
    //                 $dataRewardPoint = [
    //                     "bill_id" => $id,
    //                     "compeny_id" => $session_compeny_id,
    //                     "emp_id" => $session_emp_id,
    //                     "reward_point" => $reward_point,
    //                     "reward_point_type" => $reward_point_type,
    //                     "rec_time_stamp" => $DateTimenew,
    //                 ];
    //                 $RewardPointobj = new RewardPointModel();
    //                 if ($Bill_Acceptation_Status == 2) {
    //                     $RewardPoint = $RewardPointobj->insert($dataRewardPoint);
    //                 }
    //             }
    //             else
    //             {
    //                 $currentDay = date('d');
    //                 if ($currentDay <= 10) {  
    //                     $reward_point =$Add_RewardPoint + $Remark_RewardPoint; 
    //                     $reward_point_type = "Accept For Bill Assigment";
    //                     $session_compeny_id = $session->get("compeny_id");
    //                     $session_emp_id = $session->get("emp_id");
    //                     $DateTimenew = date("Y-m-d H:i:s");
    //                     $dataRewardPoint = [
    //                         "bill_id" => $id,
    //                         "compeny_id" => $session_compeny_id,
    //                         "emp_id" => $session_emp_id,
    //                         "reward_point" => $reward_point,
    //                         "reward_point_type" => $reward_point_type,
    //                         "rec_time_stamp" => $DateTimenew,
    //                     ];
    //                     $RewardPointobj = new RewardPointModel();
    //                     if ($Bill_Acceptation_Status == 2) {
    //                         $RewardPoint = $RewardPointobj->insert($dataRewardPoint);
    //                     }
    //                 }
    //                 else{
    //                     $reward_point =0; 
    //                 }
    //             }

    //             $reward_point = $Add_RewardPoint + $Remark_RewardPoint;
    //             $reward_point_type = "Accept For Bill Assigment";
    //             $session_compeny_id = $session->get("compeny_id");
    //             $session_emp_id = $session->get("emp_id");
    //             $DateTimenew = date("Y-m-d H:i:s");
    //             $dataRewardPoint = [
    //                 "bill_id" => $id,
    //                 "compeny_id" => $session_compeny_id,
    //                 "emp_id" => $session_emp_id,
    //                 "reward_point" => $reward_point,
    //                 "reward_point_type" => $reward_point_type,
    //                 "rec_time_stamp" => $DateTimenew,
    //             ];
    //             $RewardPointobj = new RewardPointModel();
    //             if ($Bill_Acceptation_Status == 2) {
    //                 $RewardPoint = $RewardPointobj->insert($dataRewardPoint);
    //             }
    //             // ****End RewardPoint**
    //             if ($action == "all") {
    //                 $session->setFlashdata("Bill_Acceptation_Status", 1);
    //                 return redirect("all_bill_mapping_list");
    //             } elseif ($action == "single") {
    //                 $session->setFlashdata("Bill_Acceptation_Status", 1);
    //                 
    //                 <script type="text/javascript"> 
    //                     window.location.href="<?php echo base_url("/index.php/sigle_bill_list/" . $id); "
    //                 </script>
    //                 <?php
    //             }
    //         }
    //     }
    //     else{
    //         $session->setFlashdata("Bill_Acceptation_Status", 2);
    //         return redirect("all_bill_mapping_list");
    //     }
    // }


    public function Bill_Acceptation_StatusChange()
    {
        $session = \Config\Services::session();
        $result = $session->get();
        $model = new BillRegisterModel();
        $Bill_Acceptation_Status = $this->request->getVar("Bill_Acceptation_Status");
        $Bill_Acceptation_Status_Comments = $this->request->getVar("Bill_Acceptation_Status_Comments");
        $id = $this->request->getVar("id");
        $action = $this->request->getVar("action");
        //$model->where('id', $id)->set('Department_Id',$Department_Id)->update();
        date_default_timezone_set("Asia/Kolkata");
        $Bill_Acceptation_DateTime = date("Y-m-d H:i:s");
        if($Bill_Acceptation_Status==2||$Bill_Acceptation_Status==3)
        {
            $Bill_Acceptation_Status_By_MasterId = $result["emp_id"];
        }
        else
        {
            $Bill_Acceptation_Status_By_MasterId = '';
        }
        $data = [
            "Bill_Acceptation_Status_By_MasterId" => $Bill_Acceptation_Status_By_MasterId,
            "Bill_Acceptation_Status" => $Bill_Acceptation_Status,
            "Bill_Acceptation_DateTime" => $Bill_Acceptation_DateTime,
            "Bill_Acceptation_Status_Comments" => $Bill_Acceptation_Status_Comments,
        ];
        $billid = $this->db->query("SELECT uid from asitek_bill_register WHERE id='$id' AND Bill_Acceptation_Status=1")->getResult(); // Adjust the column name based on your database structure

        if (isset($billid) && !empty($billid)) {
            if ($model->where("id", $id)->set($data)->update()) {
                // ****Start RewardPoint**
                $Add_RewardPoint = 20;
                $Remark = $this->request->getVar("Bill_Acceptation_Status_Comments");
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
                    $currentDay = date('d');
                    if ($currentDay <= 10) {  
                        $reward_point =$Add_RewardPoint + $Remark_RewardPoint; 
                    }
                    else{
                        $reward_point =$Add_RewardPoint + $Remark_RewardPoint; 
                    }
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
        else{
            $session->setFlashdata("Bill_Acceptation_Status", 2);
            return redirect("all_bill_mapping_list");
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
        $DepartmentnameModelObj = new DepartmentnameModel(); 
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

        $Depart_name = $Departmentrow["name"];
        $Depart_compeny_id =$Departmentrow["compeny_id"];

        $Departmentrow1 = $DepartmentnameModelObj
            ->where("Company_Id", $Depart_compeny_id)
            ->where("Department_Name", $Depart_name)
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
                        <label>Employee Name</label>
                            <select name="Department_Emp_Id" class="form-control"  style="padding: 0.875rem 1.375rem" required> 
                                <option value="">-Select -</option> 
                            <?php
                            $Id2 = $Departmentrow1["Id"];
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
        $DepartmentModelObj1 = new DepartmentnameModel();
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
                
                $Depart_name = $Departmentrow["name"];
                $Depart_compeny_id =$Departmentrow["compeny_id"];
                $Departmentrow1 = $DepartmentModelObj1
                ->where("Company_Id", $Depart_compeny_id)
                ->where("Department_Name", $Depart_name)
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
                            //$Id2 = $Departmentrow["id"];
                            $Id2 = $Departmentrow1["Id"];
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
        $Mapping_By_MasterId = $result["emp_id"];
        $data = [
            "Mapping_By_MasterId" => $Mapping_By_MasterId,
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

        $billid = $this->db->query("SELECT id, compeny_id, Vendor_Id from asitek_bill_register WHERE id = '$id'")->getResult(); // Adjust the column name based on your database structure
        $billidvalue = $billid[0]->id;
        $vendorvalue = $billid[0]->Vendor_Id;
        $compnyvalue = $billid[0]->compeny_id;

        $vdr = $vendormodel->where("id", $vendorvalue)->first();
        $cpn = $companymodel->where("id", $compnyvalue)->first();
        $emp = $empmodel->where("id", $this->request->getVar("Department_Emp_Id"))->first();
        $dep = $depmodel->where("id", $this->request->getVar("Department_Id"))->first();

        $billid = $this->db->query("SELECT uid from asitek_bill_register WHERE id='$id' AND Bill_Acceptation_Status=2")->getResult(); // Adjust the column name based on your database structure
        if (isset($billid) && !empty($billid)) {
            if ($model->where("id", $id)->set($data)->update()) {
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
                    $reward_point = $Add_RewardPoint + $Remark_RewardPoint;
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
                }
                else
                {
                    $currentDay = date('d');
                    if ($currentDay <= 10) {  
                        $reward_point = $Add_RewardPoint + $Remark_RewardPoint;
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
                    }
                    else{
                        $reward_point = 0;
                    }
                }
              
                

                // ****End RewardPoint**

                if ($action == "all") {
                    $session->setFlashdata("Mapping_Department", 1);
                    $wpmsg ="Hello " .$vdr["Name"] .", Just a quick update: going forward, please ensure that all your bills are mapped to, " .$emp["first_name"] .
                        " in the " .$dep["name"] ." Best regards, " .$cpn["name"];
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
                    $wpmsg ="Hello " .$vdr["Name"] .", Just a quick update: going forward, please ensure that all your bills are mapped to, " .$emp["first_name"] .
                        " in the " .$dep["name"] ." Best regards, " .$cpn["name"];
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
        else{
            $session->setFlashdata("Mapping_Department", 3);
            return redirect("all_bill_mapping_list");
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
        $BillRegister = new BillRegisterModel();
        $page = $this->request->getVar('page') ?? 1;
        $perPage = 25;
        $startSerial = ($page - 1) * $perPage + 1;
        $Roll_id = $session->get("Roll_id");
        $emp_id = $session->get("emp_id");
        $compeny_id = $session->get("compeny_id");
        
        // Get filter parameters
        $Unit_Id = $this->request->getVar('Unit_Id') ?? "";
        $Vendor_Id = $this->request->getVar('Vendor_Id') ?? "";
        $assignedto = $this->request->getVar('assignedto') ?? "";
        $SendBy = $this->request->getVar('SendBy') ?? "";
        $Satus = $this->request->getVar('Satus') ?? "";
        $session->set(["Unit_Id" => $Unit_Id,"Vendor_Id" => $Vendor_Id,"assignedto" => $assignedto,"SendBy" => $SendBy,"Satus" => $Satus]);
        // Get session dates
        $Sesssion_start_Date_New = !empty($result['Sesssion_start_Date']) ? $result['Sesssion_start_Date'] : '2019-05-06';
        $Sesssion_end_Date_New = !empty($result['Sesssion_end_Date']) ? $result['Sesssion_end_Date'] : '9019-05-06';
        $date_format = '%Y-%m-%d';
    
        // Query conditions
        $conditions = [
            'asitek_bill_register.compeny_id' => $compeny_id,
            'asitek_bill_register.Bill_Acceptation_Status' => 4,
            "STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$Sesssion_start_Date_New', '$date_format') AND STR_TO_DATE('$Sesssion_end_Date_New', '$date_format')" => null
        ];
    
        if (!empty($Unit_Id)) {
            $conditions['asitek_bill_register.Unit_Id'] = $Unit_Id;
        }
        if (!empty($Vendor_Id)) {
            $conditions['asitek_bill_register.Vendor_Id'] = $Vendor_Id;
        }
        if (!empty($assignedto)) {
            $conditions['asitek_bill_register.Department_Emp_Id'] = $assignedto;
        }
        if (!empty($SendBy)) {
            $conditions['asitek_bill_register.Mapping_By_MasterId'] = $SendBy;
        }
        if (!empty($Satus)) {
            if ($Satus != "All") {
                $conditions['asitek_bill_register.Clear_Bill_Form_Status'] = $Satus;
            }
        }
    
        // Admin Role
        if ($Roll_id == 1||$Roll_id == 2) {
            $users = $BillRegister->select("asitek_bill_register.*, asitek_employee.emp_u_id, asitek_employee.first_name, asitek_employee.last_name")
                ->join('asitek_employee', 'asitek_bill_register.Add_By = asitek_employee.id', 'left')
                ->where($conditions)
                ->orderBy('asitek_bill_register.id', 'desc')
                ->paginate($perPage);
        } else {
            // Other Roles
            $conditions['asitek_bill_register.Department_Emp_Id'] = $emp_id;
            $users = $BillRegister->select("asitek_bill_register.*, asitek_employee.emp_u_id, asitek_employee.first_name, asitek_employee.last_name")
                ->join('asitek_employee', 'asitek_bill_register.Add_By = asitek_employee.id', 'left')
                ->where($conditions)
                ->orderBy('asitek_bill_register.id', 'desc')
                ->paginate($perPage);
        }
    
        $model9 = new DepartmentModel();
        $dax9 = $model9->where("compeny_id", $compeny_id)->findAll();
        $model3 = new EmployeeModel();
        $builderrecommended = $this->db->table("asitek_company_vendor");
        $builderrecommended->select('asitek_company_vendor.Vendor_Id, asitek_party_user.id, asitek_party_user.GST_No, asitek_party_user.Name');
        $builderrecommended->join('asitek_party_user', 'asitek_party_user.id = asitek_company_vendor.Vendor_Id');
        $builderrecommended->where('asitek_company_vendor.Company_Id', $compeny_id);
        $builderrecommended->groupBy('asitek_company_vendor.Vendor_Id');
        $builderrecommended->orderBy('asitek_party_user.Name', 'ASC');
        $data_recommended = $builderrecommended->get()->getResult();
        $model15 = new UnitModel();
        $dax15 = $model15->where("compeny_id", $compeny_id)->findAll();
        $model16 = new DepartmentModel();
        $dax16 = $model16->where("compeny_id", $compeny_id)->findAll();
    
        $data = [
            'users' => $users,
            'pager' => $BillRegister->pager,
            'startSerial' => $startSerial,
            'nextPage' => $page + 1,
            'previousPage' => ($page > 1) ? $page - 1 : null,
            'dax9' => $dax9,
            'dax14' => $data_recommended,
            'dax15' => $dax15,
            'dax16' => $dax16,
        ];
        return view("all_Clear_Bill_Form_list", $data);
    }

    function export_all_Clear_Bill_Form_list(){
        $session = \Config\Services::session();
        $result = $session->get(); 
        $Roll_id = $session->get("Roll_id");
        $emp_id = $session->get("emp_id");
        $compeny_id = $session->get("compeny_id");   
        $model = new BillRegisterModel();
        $UnitModelObj = new UnitModel();
        $RollModelObj = new RollModel();
        $EmployeeModelObj = new EmployeeModel();
        $PartyUserModelObj = new PartyUserModel();
        $DepartmentModelObj = new DepartmentModel();
        $MasterActionmadelObj = new MasterActionModel();
        $MasterActionUploadModelObj = new MasterActionUploadModel();
        if ($session->has('Unit_Id')) {
            $Unit_Id = $result['Unit_Id']; 
        } else {
            $Unit_Id = ""; 
        }
        if ($session->has('Vendor_Id')) {
            echo  $Vendor_Id = $result['Vendor_Id']; 
        } else {
            echo $Vendor_Id = ""; 
        }
        if ($session->has('assignedto')) {
            $assignedto = $result['assignedto'];
        } else {
            $assignedto = ""; 
        }
        if ($session->has('SendBy')) {
            $SendBy = $result['SendBy']; 
        } else {
            $SendBy = ""; 
        }
        if ($session->has('Satus')) {
            $Satus = $result['Satus']; 
        } else {
            $Satus = ""; 
        }
        // Default start and end date values
        $defaultStartDate = '2019-05-06';
        $defaultEndDate = '9019-05-06';
        
        // Retrieve session start and end date values
        $Sesssion_start_Date_New = !empty($session->get('Sesssion_start_Date')) ? $session->get('Sesssion_start_Date') : $defaultStartDate;
        $Sesssion_end_Date_New = !empty($session->get('Sesssion_end_Date')) ? $session->get('Sesssion_end_Date') : $defaultEndDate;
        // Date format for SQL query
        $date_format = '%Y-%m-%d';
       // Query conditions
        $conditions = [
            'asitek_bill_register.compeny_id' => $compeny_id,
            'asitek_bill_register.Bill_Acceptation_Status' => 4,
            "STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$Sesssion_start_Date_New', '$date_format') AND STR_TO_DATE('$Sesssion_end_Date_New', '$date_format')" => null
        ];
    
        if (!empty($Unit_Id)) {
            $conditions['asitek_bill_register.Unit_Id'] = $Unit_Id;
        }
        if (!empty($Vendor_Id)) {
            $conditions['asitek_bill_register.Vendor_Id'] = $Vendor_Id;
        }
        if (!empty($assignedto)) {
            $conditions['asitek_bill_register.Department_Emp_Id'] = $assignedto;
        }
        if (!empty($SendBy)) {
            $conditions['asitek_bill_register.Mapping_By_MasterId'] = $SendBy;
        }
        if (!empty($Satus)) {
            if ($Satus != "All") {
                $conditions['asitek_bill_register.Clear_Bill_Form_Status'] = $Satus;
            }
        }

        // Excel file name for download 
        $fileName = "all_Clear_Bill_Form_list" . date('Y-m-d') . ".xls";     
        // Column names 
        $fields = array('Bill Pic', 'Bill Id', 'Vendor', 'Bill No', 'Bill Amount', 'Bill Date', 'Unit Name', 'Gate Entry No', 'Gate Entry Date', 'Assign To' ,  'Assign Comment', 'Accept Date','Accept Comment','Master Action Comment','Master Action File','Send to next Comment','Send to next File','Vendor Comment','Vendor File','Action'); 
        // Display column names as first row 
        $excelData = implode("\t", array_values($fields)) . "\n"; 
        // Fetch records from database
        if ($Roll_id == 1||$Roll_id == 2) {
            
             $data = $model->select("asitek_bill_register.*, asitek_employee.emp_u_id, asitek_employee.first_name, asitek_employee.last_name")
                ->join('asitek_employee', 'asitek_bill_register.Add_By = asitek_employee.id', 'left')
                ->where($conditions)
                ->orderBy('asitek_bill_register.id', 'desc')
                ->findAll();
        } else {
            $conditions['asitek_bill_register.Department_Emp_Id'] = $emp_id;
            $data = $model->select("asitek_bill_register.*, asitek_employee.emp_u_id, asitek_employee.first_name, asitek_employee.last_name")
                ->join('asitek_employee', 'asitek_bill_register.Add_By = asitek_employee.id', 'left')
                ->where($conditions)
                ->orderBy('asitek_bill_register.id', 'desc')
                ->findAll();
        }   
        // $data = $model->orderBy('id', 'desc'->findAll(); 
        $stage_id=3;
        if(isset($data)){ 
            // Output each row of the data 
            foreach($data as $row)
            { 
                //*************
                if(isset($row['Bill_Pic'])){$Bill_Pic =base_url('public/vendors/PicUpload/'.$row['Bill_Pic']);}
                else{ $Bill_Pic = '';}
                if(isset($row['uid'])){$uid = $row['uid'];}else{ $uid = 'NA';}
                $Vendorrow= $PartyUserModelObj->where('id',$row['Vendor_Id'])->first();
                if(isset($Vendorrow) && $Vendorrow!='')
                {
                    $VendorName= $Vendorrow['Name']; 
                }
                else
                {
                    $VendorName=''; 
                }
                if(isset($row['Bill_No'])){$Bill_No = $row['Bill_No'];}else{ $Bill_No = 'NA';}
                if(isset($row['Bill_Amount'])){$Bill_Amount = $row['Bill_Amount'];}else{ $Bill_Amount = 'NA';}
                if(isset($row['Bill_DateTime'])){$Bill_DateTime = date('d/m/Y', strtotime($row['Bill_DateTime']));}else{ $Bill_DateTime = 'NA';}
                $Unitrow= $UnitModelObj->where('id',$row['Unit_Id'])->first();
                if(isset($Unitrow) && $Unitrow!='')
                {
                    $UnitName =$Unitrow['name']; 
                }
                else{
                    $UnitName='';
                }
                if(isset($row['Gate_Entry_No'])){$Gate_Entry_No = $row['Gate_Entry_No'];}else{ $Gate_Entry_No = 'NA';}
                if(isset($row['Gate_Entry_Date'])){$Gate_Entry_Date = date('d/m/Y', strtotime($row['Gate_Entry_Date']));}else{ $Gate_Entry_Date = 'NA';}
                $MappingEmprow= $EmployeeModelObj->where('id',$row['Department_Emp_Id'])->first();
                if(isset($MappingEmprow) && $MappingEmprow!='')
                {
                    $Department_Emp_Id= $MappingEmprow['first_name'].' '.$MappingEmprow['last_name'];
                }
                else{
                    $Department_Emp_Id=''; 
                }
                if(isset($row['Mapping_Remark'])){$Mapping_Remark = $row['Mapping_Remark'];}else{ $Mapping_Remark = 'NA';}
                if(isset($row['Clear_Bill_Form_DateTime'])){$Clear_Bill_Form_DateTime = $row['Clear_Bill_Form_DateTime'];}else{ $Clear_Bill_Form_DateTime = 'NA';}
                if(isset($row['Clear_Bill_Form_Status_Comments'])){$Clear_Bill_Form_Status_Comments = $row['Clear_Bill_Form_Status_Comments'];}else{ $Clear_Bill_Form_Status_Comments = 'NA';}
                $rowMasterAction2= $MasterActionmadelObj->where('compeny_id', $compeny_id)->where('stage_id',$stage_id)->where('no_of_action',$row['ClearFormBill_Master_Action'])->first();
                if(isset($rowMasterAction2) && $rowMasterAction2!='')
                {
                    $rowMasterActionUpload= $MasterActionUploadModelObj->where('compeny_id', $compeny_id)->where('bill_id',$row['id'])->where('master_action_id',$rowMasterAction2['id'])->first(); 
                    if(isset($rowMasterActionUpload) && $rowMasterActionUpload!='')
                    {  
                        $MasterActionComment= $rowMasterActionUpload['remark'];
                    }
                    else{
                        $MasterActionComment='';
                    } 
                    if(isset($rowMasterActionUpload) && $rowMasterActionUpload!='') { 
                        if(!empty($rowMasterActionUpload['image_upload'])){
                            $image_upload=base_url('public/vendors/PicUploadMasterAction/'.$rowMasterActionUpload['image_upload']);
                        }
                        else{
                            $image_upload='No Image';
                        }
                    }
                }
                else{ 
                    $MasterActionComment='';
                    $image_upload='No Image';
                }
                if(isset($row['ClearBillForm_Remark'])){$ClearBillForm_Remark = $row['ClearBillForm_Remark'];}else{ $ClearBillForm_Remark = 'NA';}
                if(!empty($row['Clear_Bill_Form_AnyImage'])){
                    $Clear_Bill_Form_AnyImage=base_url('public/vendors/PicUpload/'.$row['Clear_Bill_Form_AnyImage']);
                }
                else{
                    $Clear_Bill_Form_AnyImage='No Image';
                } 
                if(isset($row['Vendor_Comment'])){$Vendor_Comment = $row['Vendor_Comment'];}else{ $Vendor_Comment = 'NA';}
                if(!empty($row['Vendor_Upload_Image'])){ 
                    $Vendor_Upload_Image= base_url('public/vendors/PicUpload/'.$row['Vendor_Upload_Image']);
                }
                else{
                    $Vendor_Upload_Image= 'No Image';
                }
                if($row['Clear_Bill_Form_Status']==1)
                {
                    $Status='Pending';
                }
                elseif($row['Clear_Bill_Form_Status']==2)
                {
                    $Status='Accepted';
                }
                elseif($row['Clear_Bill_Form_Status']==3)
                {
                    $Status='Reject';
                }
                elseif($row['Clear_Bill_Form_Status']==4)
                {
                    $Status='Done';
                }
                //*************
                $lineData = array( 'link', $uid, $VendorName, $Bill_No,$Bill_Amount,$Bill_DateTime,$UnitName,$Gate_Entry_No,$Gate_Entry_Date,  $Department_Emp_Id,$Mapping_Remark,$Clear_Bill_Form_DateTime,$Clear_Bill_Form_Status_Comments, $MasterActionComment,$image_upload,$ClearBillForm_Remark,$Clear_Bill_Form_AnyImage,$Vendor_Comment,$Vendor_Upload_Image,$Status);
                // array_walk(str_replace('"', '""',(preg_replace("/\r?\n/", "\\n",(preg_replace("/\t/", "\\t", $lineData))))); 
                $excelData .= implode("\t", array_values($lineData)) . "\n";   
            } 
        }
        else{ 
            $session->setFlashdata('excel',1);
        } 
        // Headers for download 
        header("Content-Type: application/vnd.ms-excel"); 
        header("Content-Disposition: attachment; filename=\"$fileName\""); 
        echo $excelData; 
        exit;
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
        $status=$this->request->getVar("Clear_Bill_Form_Status");
        if($status==2||$status==3)
        {
            $MasterId_By_emp_id = $result["emp_id"];
        }
        else
        {
            $MasterId_By_emp_id ="";
        }
        $data = [
            "MasterId_By_Clear_Bill_Form" => $MasterId_By_emp_id,
            "Clear_Bill_Form_Status" => $this->request->getVar(
                "Clear_Bill_Form_Status"
            ),
            "Clear_Bill_Form_DateTime" => $Clear_Bill_Form_DateTime,
            "Clear_Bill_Form_Status_Comments" => $this->request->getVar(
                "Clear_Bill_Form_Status_Comments"
            ),
        ];
        $billid = $this->db->query("SELECT uid from asitek_bill_register WHERE id='$id' AND Clear_Bill_Form_Status=1")->getResult(); // Adjust the column name based on your database structure

        if (isset($billid) && !empty($billid)) {
            if ($model->where("id", $id)->set($data)->update()) {
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
                    $reward_point = $Add_RewardPoint + $Remark_RewardPoint;
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
                }
                else
                {
                    $currentDay = date('d');
                    if ($currentDay <= 10) {  
                        $reward_point = $Add_RewardPoint + $Remark_RewardPoint;
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
                    }
                    else{
                        $reward_point = 0;
                    }
                }

             
                
                // ****End RewardPoint**

                if ($action == "all") {
                    $session->setFlashdata("Bill_Acceptation_Status", 1);
                    return redirect("all_Clear_Bill_Form_list");
                } elseif ($action == "single") {
                    $session->setFlashdata("Bill_Acceptation_Status", 1); ?>
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
        else{
            $session->setFlashdata("Bill_Acceptation_Status", 2);
            return redirect("all_Clear_Bill_Form_list");
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
        $uploaded_by = $result["emp_id"];
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
        if($stage_id==3){
            $billid = $this->db->query("SELECT id from asitek_bill_register WHERE id = '$id' AND Clear_Bill_Form_Status=2")->getResult();
        }
        elseif($stage_id==4){
            $billid = $this->db->query("SELECT id from asitek_bill_register WHERE id = '$id' AND Clear_Bill_Form_Status=4 AND ERP_Status=2")->getResult();
        }
        elseif($stage_id==5){
            $billid = $this->db->query("SELECT id from asitek_bill_register WHERE id = '$id' AND Clear_Bill_Form_Status=4 AND ERP_Status=4 AND Recived_Status=2")->getResult();
        }
        if (isset($billid) && !empty($billid)) {
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
            $rowMasterAction1 = $MasterActionmadelObj->where("stage_id", $stage_id)->where("id", $Master_ActionId)->first();
            
            $data2 = [
                "uploaded_by" => $uploaded_by,
                "compeny_id" => $compeny_id,
                "bill_id" => $id,
                "master_action_id" => $Master_ActionId,
                "image_upload" => $imageName,
                "remark" => $remark,
            ];
            $MasterActionUploadrow333= $MasterActionUploadModelObj->where('bill_id',$id)->where('master_action_id',$Master_ActionId)->first();
            if(isset($MasterActionUploadrow333) && $MasterActionUploadrow333!='')
            {
                $session->setFlashdata("Master_Action_SMS", 2);
                if ($stage_id == 3) {
                    return redirect("all_Clear_Bill_Form_list");
                }
                elseif($stage_id == 4){
                    return redirect("all_erpStystem_list");
                }
                elseif($stage_id == 5){
                    return redirect("all_recived_bill_list");
                }
            }
            else{
                $insert = $MasterActionUploadModelObj->insert($data2);

                if ($insert) {
                    if ($stage_id == 3) {
                        $model->where("id", $id)->set("ClearFormBill_Master_Action",$rowMasterAction1["no_of_action"])->update();
                        // ****Start RewardPoint**
                        $MasterActionmadelObj = new MasterActionModel();
                        $rowMasterAction1 = $MasterActionmadelObj->where("compeny_id", $compeny_id)->where("stage_id", $stage_id)->orderBy("id", "desc")->first();
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
                                    $reward_point =  $Add_RewardPoint + $Remark_RewardPoint +$FileAttch_RewardPoint;
                                    $reward_point_type = "Master Action Bill Verify";
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
                                }
                                else
                                {
                                    $currentDay = date('d');
                                    if ($currentDay <= 10) {  
                                        $reward_point =  $Add_RewardPoint + $Remark_RewardPoint +$FileAttch_RewardPoint;
                                        $reward_point_type = "Master Action Bill Verify";
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
                                    }
                                    else{
                                        $reward_point =  0;
                                    }
                                }
                            } 
                            else { }
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
                        $model->where("id", $id)->set("ERP_Master_Action",$rowMasterAction1["no_of_action"])->update();
                        // ****Start RewardPoint**

                        $MasterActionmadelObj = new MasterActionModel();
                        $rowMasterAction1 = $MasterActionmadelObj->where("compeny_id", $compeny_id)->where("stage_id", $stage_id)->orderBy("id", "desc")->first();
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
                                    $reward_point =  $Add_RewardPoint + $Remark_RewardPoint +$FileAttch_RewardPoint;
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
                                }
                                else
                                {
                                    $currentDay = date('d');
                                    if ($currentDay <= 10) {  
                                        $reward_point =  $Add_RewardPoint + $Remark_RewardPoint +$FileAttch_RewardPoint;
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
                                    }
                                    else{
                                        $reward_point =  0;
                                    }
                                }

                                
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
                        $model->where("id", $id)->set("Recived_Master_Action",$rowMasterAction1["no_of_action"])->update();

                        // ****Start RewardPoint**
                        $MasterActionmadelObj = new MasterActionModel();
                        $rowMasterAction1 = $MasterActionmadelObj->where("compeny_id", $compeny_id)->where("stage_id", $stage_id)->orderBy("id", "desc")->first();
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
                                    $reward_point =  $Add_RewardPoint + $Remark_RewardPoint +$FileAttch_RewardPoint;
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
                                }
                                else
                                {
                                    $currentDay = date('d');
                                    if ($currentDay <= 10) {   
                                        $reward_point =  $Add_RewardPoint + $Remark_RewardPoint +$FileAttch_RewardPoint;
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
                                    }
                                    else{
                                        $reward_point =  0;
                                    }
                                }

                                
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
        }
        else{
            $session->setFlashdata("Bill_Acceptation_Status", 2);
            if ($stage_id == 3) {
                return redirect("all_Clear_Bill_Form_list");
            }
            elseif($stage_id == 4){
                return redirect("all_erpStystem_list");
            }
            elseif($stage_id == 5){
                return redirect("all_recived_bill_list");
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
        $Mapping_ERP_EmpId_By_MasterId = $result["emp_id"];
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
            "Mapping_ERP_EmpId_By_MasterId" => $Mapping_ERP_EmpId_By_MasterId,
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

        $billid = $this->db->query("SELECT compeny_id, Vendor_Id from asitek_bill_register WHERE id = '$id'")->getResult(); // Adjust the column name based on your database structure
        $vendorvalue = $billid[0]->Vendor_Id;
        $compnyvalue = $billid[0]->compeny_id;

        $vdr = $vendormodel->where("id", $vendorvalue)->first();
        $cpn = $companymodel->where("id", $compnyvalue)->first();

        $billmasterid = $this->db->query("SELECT uid from asitek_bill_register WHERE id='$id' AND Clear_Bill_Form_Status=2")->getResult(); // Adjust the column name based on your database structure

        if (isset($billmasterid) && !empty($billmasterid)) {
            if ($model->where("id", $id)->set($data)->update()) {
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
                    $reward_point_type = "Send this bill for entry process (forward)";
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
                }
                else
                {
                    $currentDay = date('d');
                    if ($currentDay <= 10) {   
                        $reward_point =  $Add_RewardPoint + $Remark_RewardPoint + $FileAttch_RewardPoint;
                        $reward_point_type = "Send this bill for entry process (forward)";
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
                    }
                    else{
                        $reward_point =  0;
                    }
                }

               
                
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

                    $session->setFlashdata("Sendtoentry", 1);
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
        else{
            $session->setFlashdata("Sendtoentry", 2);
            return redirect("all_Clear_Bill_Form_list");
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
        $BillRegister = new BillRegisterModel();
        $page = $this->request->getVar('page') ?? 1;
        $perPage = 50;
        $startSerial = ($page - 1) * $perPage + 1;
        $Roll_id = $session->get("Roll_id");
        $emp_id = $session->get("emp_id");
        $company_id = $session->get("compeny_id");
    
        $Unit_Id = $this->request->getVar('Unit_Id') ?? "";
        $Vendor_Id = $this->request->getVar('Vendor_Id') ?? "";
        $assignedto = $this->request->getVar('assignedto') ?? "";
        $SendBy = $this->request->getVar('SendBy') ?? "";
        $Status = $this->request->getVar('Satus') ?? "";
         $session->set(["Unit_Id" => $Unit_Id,"Vendor_Id" => $Vendor_Id,"assignedto" => $assignedto,"SendBy" => $SendBy,"Status" => $Status]);
        // Date handling
        $session_start_date = $session->get('Sesssion_start_Date') ?? '2019-05-06';
        $session_end_date = $session->get('Sesssion_end_Date') ?? '9019-05-06';
        $date_format = '%Y-%m-%d';
    
        // Setting default values for session dates if not set
        $session_start_date_new = !empty($result['Session_start_Date']) ? $result['Session_start_Date'] : $session_start_date;
        $session_end_date_new = !empty($result['Session_end_Date']) ? $result['Session_end_Date'] : $session_end_date;
    
        // Admin Roll
        if ($Roll_id == 1||$Roll_id == 2) {
            $users = $BillRegister->select("asitek_bill_register.*, asitek_employee.emp_u_id, asitek_employee.first_name, asitek_employee.last_name")
                ->join('asitek_employee', 'asitek_bill_register.Add_By = asitek_employee.id', 'left')
                ->where('asitek_bill_register.compeny_id', $company_id)
                ->where('asitek_bill_register.Bill_Acceptation_Status', 4)
                ->where('asitek_bill_register.Clear_Bill_Form_Status', 4);
    
            if (!empty($Unit_Id)) {
                $users->where('asitek_bill_register.Unit_Id', $Unit_Id);
            }
    
            if (!empty($Vendor_Id)) {
                $users->where('asitek_bill_register.Vendor_Id', $Vendor_Id);
            }
    
            if (!empty($assignedto)) {
                $users->where('asitek_bill_register.Department_Emp_Id', $assignedto);
            }
    
            if (!empty($SendBy)) {
                $users->where('asitek_bill_register.Mapping_ERP_EmpId_By_MasterId', $SendBy);
            }
    
            if (!empty($Status) && $Status !== "All") {
                $users->where('asitek_bill_register.ERP_Status', $Status);
            }
    
            $users->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$session_start_date_new', '$date_format') AND STR_TO_DATE('$session_end_date_new', '$date_format')")
                ->orderBy('asitek_bill_register.id', 'desc');
    
            $users = $users->paginate($perPage);
        } else {
            // Non-admin case
            $users = $BillRegister->select("asitek_bill_register.*, asitek_employee.emp_u_id, asitek_employee.first_name, asitek_employee.last_name")
                ->join('asitek_employee', 'asitek_bill_register.Add_By = asitek_employee.id', 'left')
                ->where('asitek_bill_register.compeny_id', $company_id)
                ->where('asitek_bill_register.Bill_Acceptation_Status', 4)
                ->where('asitek_bill_register.Clear_Bill_Form_Status', 4)
                ->where('asitek_bill_register.Mapping_ERP_EmpId', $emp_id);
    
            if (!empty($Unit_Id)) {
                $users->where('asitek_bill_register.Unit_Id', $Unit_Id);
            }
    
            if (!empty($Vendor_Id)) {
                $users->where('asitek_bill_register.Vendor_Id', $Vendor_Id);
            }
    
            if (!empty($assignedto)) {
                $users->where('asitek_bill_register.Mapping_ERP_EmpId', $assignedto);
            }
    
            if (!empty($SendBy)) {
                $users->where('asitek_bill_register.Mapping_ERP_EmpId_By_MasterId', $SendBy);
            }
    
            if (!empty($Status) && $Status !== "All") {
                $users->where('asitek_bill_register.ERP_Status', $Status);
            }
    
            $users->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$session_start_date_new', '$date_format') AND STR_TO_DATE('$session_end_date_new', '$date_format')")
                ->orderBy('asitek_bill_register.id', 'desc');
    
            $users = $users->paginate($perPage);
        }
    
        $departmentModel = new DepartmentModel();
        $dax9 = $departmentModel->where("compeny_id", $company_id)->findAll();
    
        $employeeModel = new EmployeeModel();
        $builderrecommended = $this->db->table("asitek_company_vendor");
        $builderrecommended->select('asitek_company_vendor.Vendor_Id, asitek_party_user.id, asitek_party_user.GST_No, asitek_party_user.Name');
        $builderrecommended->join('asitek_party_user', 'asitek_party_user.id = asitek_company_vendor.Vendor_Id');
        $builderrecommended->where('asitek_company_vendor.Company_Id', $company_id);
        $builderrecommended->groupBy('asitek_company_vendor.Vendor_Id');
        $builderrecommended->orderBy('asitek_party_user.Name', 'ASC');
        $data_recommended = $builderrecommended->get()->getResult();
    
        $unitModel = new UnitModel();
        $dax15 = $unitModel->where("compeny_id", $company_id)->findAll();
    
        $departmentModel = new DepartmentModel();
        $dax16 = $departmentModel->where("compeny_id", $company_id)->findAll();
    
        $data = [
            'users' => $users,
            'pager' => $BillRegister->pager,
            'startSerial' => $startSerial,
            'nextPage' => $page + 1,
            'previousPage' => ($page > 1) ? $page - 1 : null,
            'dax9' => $dax9,
            'dax14' => $data_recommended,
            'dax15' => $dax15,
            'dax16' => $dax16,
        ];
    
        return view("all_erpStystem_list", $data);
    }

    public function export_all_erpStystem_list(){
        $session = \Config\Services::session();
        $result = $session->get(); 
        $Roll_id = $session->get("Roll_id");
        $emp_id = $session->get("emp_id");
        $compeny_id = $session->get("compeny_id");   
        $model = new BillRegisterModel();
        $UnitModelObj = new UnitModel();
        $RollModelObj = new RollModel();
        $EmployeeModelObj = new EmployeeModel();
        $PartyUserModelObj = new PartyUserModel();
        $DepartmentModelObj = new DepartmentModel();
        $MasterActionmadelObj = new MasterActionModel();
        $MasterActionUploadModelObj = new MasterActionUploadModel();

        if ($session->has('Unit_Id')) {
            $Unit_Id = $result['Unit_Id']; 
        } else {
            $Unit_Id = ""; 
        }
        if ($session->has('Vendor_Id')) {
            $Vendor_Id = $result['Vendor_Id']; 
        } else {
            $Vendor_Id = ""; 
        }
        if ($session->has('assignedto')) {
            $assignedto = $result['assignedto'];
        } else {
            $assignedto = ""; 
        }
        if ($session->has('SendBy')) {
            $SendBy = $result['SendBy']; 
        } else {
            $SendBy = ""; 
        }
        if ($session->has('Status')) {
            $Status = $result['Status']; 
        } else {
            $Status = ""; 
        }


        // Default start and end date values
        $defaultStartDate = '2019-05-06';
        $defaultEndDate = '9019-05-06';
        
        // Retrieve session start and end date values
        $Sesssion_start_Date_New = !empty($session->get('Sesssion_start_Date')) ? $session->get('Sesssion_start_Date') : $defaultStartDate;
        $Sesssion_end_Date_New = !empty($session->get('Sesssion_end_Date')) ? $session->get('Sesssion_end_Date') : $defaultEndDate;
        // Date format for SQL query
        $date_format = '%Y-%m-%d';

        // Excel file name for download 
        $fileName = "all_erpStystem_list" . date('Y-m-d') . ".xls";     
        // Column names 
        $fields = array('Bill Pic', 'Bill Id', 'Vendor', 'Bill No', 'Bill Amount', 'Bill Date', 'Unit Name', 'Gate Entry No', 'Gate Entry Date', 'Send By' ,  'Sender Comment', 'Sender File','Accept Date','Accept Comment','Master Action Comment','Master Action File','Send to next Comment','Send to next File','Vendor Comment','Vendor File','Action'); 
        // Display column names as first row 
        $excelData = implode("\t", array_values($fields)) . "\n"; 
        // Fetch records from database
        if ($Roll_id == 1||$Roll_id == 2) {
            $users = $model ->select("asitek_bill_register.*, asitek_employee.emp_u_id, asitek_employee.first_name, asitek_employee.last_name")->join('asitek_employee', 'asitek_bill_register.Add_By = asitek_employee.id', 'left')->where('asitek_bill_register.compeny_id', $compeny_id)->where('asitek_bill_register.Bill_Acceptation_Status',4)->where('asitek_bill_register.Clear_Bill_Form_Status',4)->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$Sesssion_start_Date_New', '$date_format') AND STR_TO_DATE('$Sesssion_end_Date_New', '$date_format')");
  
            if (!empty($Unit_Id)) {
                $users->where('asitek_bill_register.Unit_Id', $Unit_Id);
            }

            if (!empty($Vendor_Id)) {
                $users->where('asitek_bill_register.Vendor_Id', $Vendor_Id);
            }

            if (!empty($assignedto)) {
                $users->where('asitek_bill_register.Department_Emp_Id', $assignedto);
            }

            if (!empty($SendBy)) {
                $users->where('asitek_bill_register.Mapping_ERP_EmpId_By_MasterId', $SendBy);
            }

            if (!empty($Status) && $Status !== "All") {
                $users->where('asitek_bill_register.ERP_Status', $Status);
            }
            $data = $users->orderBy('asitek_bill_register.id', 'desc')->findAll();
        } else {
            $users = $model ->select("asitek_bill_register.*, asitek_employee.emp_u_id, asitek_employee.first_name, asitek_employee.last_name")->join('asitek_employee', 'asitek_bill_register.Add_By = asitek_employee.id', 'left')->where('asitek_bill_register.compeny_id', $compeny_id)->where('asitek_bill_register.Bill_Acceptation_Status',4)->where('asitek_bill_register.Clear_Bill_Form_Status',4)->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$Sesssion_start_Date_New', '$date_format') AND STR_TO_DATE('$Sesssion_end_Date_New', '$date_format')")->where('asitek_bill_register.Department_Emp_Id', $emp_id);
  
            if (!empty($Unit_Id)) {
                $users->where('asitek_bill_register.Unit_Id', $Unit_Id);
            }

            if (!empty($Vendor_Id)) {
                $users->where('asitek_bill_register.Vendor_Id', $Vendor_Id);
            }

            if (!empty($assignedto)) {
                $users->where('asitek_bill_register.Department_Emp_Id', $assignedto);
            }

            if (!empty($SendBy)) {
                $users->where('asitek_bill_register.Mapping_ERP_EmpId_By_MasterId', $SendBy);
            }

            if (!empty($Status) && $Status !== "All") {
                $users->where('asitek_bill_register.ERP_Status', $Status);
            }
            $data = $users->orderBy('asitek_bill_register.id', 'desc')->findAll();
        }   
        // $data = $model->orderBy('id', 'desc'->findAll(); 
        $stage_id=4;
        if(isset($data)){ 
            // Output each row of the data 
            foreach($data as $row)
            { 
                //*************
                if(isset($row['Bill_Pic'])){$Bill_Pic =base_url('public/vendors/PicUpload/'.$row['Bill_Pic']);}
                else{ $Bill_Pic = '';}
                if(isset($row['uid'])){ $uid = $row['uid'];}else{ $uid = 'NA';}
                $Vendorrow= $PartyUserModelObj->where('id',$row['Vendor_Id'])->first();
                if(isset($Vendorrow) && $Vendorrow!='')
                {
                    $VendorName= $Vendorrow['Name']; 
                }
                else
                {
                    $VendorName=''; 
                }
                if(isset($row['Bill_No'])){$Bill_No = $row['Bill_No'];}else{ $Bill_No = 'NA';}
                if(isset($row['Bill_Amount'])){$Bill_Amount = $row['Bill_Amount'];}else{ $Bill_Amount = 'NA';}
                if(isset($row['Bill_DateTime'])){$Bill_DateTime = date('d/m/Y', strtotime($row['Bill_DateTime']));}else{ $Bill_DateTime = 'NA';}
                $Unitrow= $UnitModelObj->where('id',$row['Unit_Id'])->first();
                if(isset($Unitrow) && $Unitrow!='')
                {
                    $UnitName =$Unitrow['name']; 
                }
                else{
                    $UnitName='';
                }
                if(isset($row['Gate_Entry_No'])){$Gate_Entry_No = $row['Gate_Entry_No'];}else{ $Gate_Entry_No = 'NA';}
                if(isset($row['Gate_Entry_Date'])){$Gate_Entry_Date = date('d/m/Y', strtotime($row['Gate_Entry_Date']));}else{ $Gate_Entry_Date = 'NA';}
                $MappingEmprow= $EmployeeModelObj->where('id',$row['Department_Emp_Id'])->first();
                if(isset($MappingEmprow) && $MappingEmprow!='')
                {
                    $Department_Emp_Id= $MappingEmprow['first_name'].' '.$MappingEmprow['last_name'];
                }
                else{
                    $Department_Emp_Id=''; 
                }
                if(isset($row['ClearBillForm_Remark'])){$ClearBillForm_Remark = $row['ClearBillForm_Remark'];}else{ $ClearBillForm_Remark = 'NA';}
                if(!empty($row['Clear_Bill_Form_AnyImage'])){ 
                    $Clear_Bill_Form_AnyImage= base_url('public/vendors/PicUpload/'.$row['Clear_Bill_Form_AnyImage']);
                }
                else{
                    $Clear_Bill_Form_AnyImage='No Image';
                } 
                if(isset($row['ERP_DateTime'])){$ERP_DateTime = $row['ERP_DateTime'];}else{ $ERP_DateTime = 'NA';}
                if(isset($row['ERP_Comment'])){$ERP_Comment = $row['ERP_Comment'];}else{ $ERP_Comment = 'NA';}
                $rowMasterAction2= $MasterActionmadelObj->where('compeny_id', $compeny_id)->where('stage_id',$stage_id)->where('no_of_action',$row['ClearFormBill_Master_Action'])->first();
                if(isset($rowMasterAction2) && $rowMasterAction2!='')
                {
                    $rowMasterActionUpload= $MasterActionUploadModelObj->where('compeny_id', $compeny_id)->where('bill_id',$row['id'])->where('master_action_id',$rowMasterAction2['id'])->first(); 
                    if(isset($rowMasterActionUpload) && $rowMasterActionUpload!='')
                    {  
                        $MasterActionComment= $rowMasterActionUpload['remark'];
                    }
                    else{
                        $MasterActionComment='';
                    } 
                    if(isset($rowMasterActionUpload) && $rowMasterActionUpload!='') { 
                        if(!empty($rowMasterActionUpload['image_upload'])){
                            $image_upload=base_url('public/vendors/PicUploadMasterAction/'.$rowMasterActionUpload['image_upload']);
                        }
                        else{
                            $image_upload='No Image';
                        }
                    }
                }
                else{ 
                    $MasterActionComment='';
                    $image_upload='No Image';
                }
                if(isset($row['ERP_Remark'])){$ERP_Remark = $row['ERP_Remark'];}else{ $ERP_Remark = 'NA';}
                if(!empty($row['ERP_AnyImage'])){
                    $ERP_AnyImage=base_url('public/vendors/PicUpload/'.$row['ERP_AnyImage']);
                }
                else{
                    $ERP_AnyImage='No Image';
                } 
                if(isset($row['Vendor_Comment'])){$Vendor_Comment = $row['Vendor_Comment'];}else{ $Vendor_Comment = 'NA';}
                if(!empty($row['Vendor_Upload_Image'])){ 
                    $Vendor_Upload_Image= base_url('public/vendors/PicUpload/'.$row['Vendor_Upload_Image']);
                }
                else{
                    $Vendor_Upload_Image= 'No Image';
                }
                if($row['ERP_Status']==1)
                {
                    $Status='Pending';
                }
                elseif($row['ERP_Status']==2)
                {
                    $Status='Accepted';
                }
                elseif($row['ERP_Status']==3)
                {
                    $Status='Reject';
                }
                elseif($row['ERP_Status']==4)
                {
                    $Status='Done';
                }
                //*************
                $lineData = array( 'link', $uid, $VendorName, $Bill_No,$Bill_Amount,$Bill_DateTime,$UnitName,$Gate_Entry_No,$Gate_Entry_Date,  $Department_Emp_Id,$ClearBillForm_Remark,$Clear_Bill_Form_AnyImage,$ERP_DateTime,$ERP_Comment,$MasterActionComment,$image_upload,$ERP_Remark,$ERP_AnyImage,$Vendor_Comment,$Vendor_Upload_Image,$Status);
                // array_walk(str_replace('"', '""',(preg_replace("/\r?\n/", "\\n",(preg_replace("/\t/", "\\t", $lineData))))); 
                $excelData .= implode("\t", array_values($lineData)) . "\n";   
            } 
        }
        else{ 
            $session->setFlashdata('excel',1);
        } 
        // Headers for download 
        header("Content-Type: application/vnd.ms-excel"); 
        header("Content-Disposition: attachment; filename=\"$fileName\""); 
        echo $excelData; 
        exit;
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
        $ERP_Status=$this->request->getVar("ERP_Status");
        if($ERP_Status==2||$ERP_Status==3)
        {
            echo $ERP_Status_Change_By_MasterId = $result["emp_id"];
        }
        else
        {
            echo  $ERP_Status_Change_By_MasterId = '';
        }
        $data = [
            "ERP_Status_Change_By_MasterId" => $ERP_Status_Change_By_MasterId,
            "ERP_Status" => $this->request->getVar("ERP_Status"),
            "ERP_Comment" => $this->request->getVar("ERP_Comment"),
            "ERP_DateTime" => $ERP_DateTime,
        ];

        $billid = $this->db->query("SELECT uid from asitek_bill_register WHERE id='$id' AND ERP_Status=1")->getResult(); // Adjust the column name based on your database structure

        if (isset($billid) && !empty($billid)) {
            if ($model->where("id", $id)->set($data)->update()) {
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
                }
                else
                {
                    $currentDay = date('d');
                    if ($currentDay <= 10) {   
                        $reward_point = $Add_RewardPoint + $Remark_RewardPoint;
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
                    }
                    else{
                        $reward_point = 0;
                    }
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
        else{
            $session->setFlashdata("Bill_Acceptation_Status", 2);
            return redirect("all_erpStystem_list");
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
        $result = $session->get();
         $Mapping_Acount_By_MasterId = $result["emp_id"];
        $model = new BillRegisterModel();
        $vendormodel = new PartyUserModel();
        $companymodel = new CompenyModel();
        $id = $this->request->getVar("id");
        $action = $this->request->getVar("action");
        $validation = \Config\Services::validation();
        $Mapping_Acount_By_MasterId = $result["emp_id"];
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
            "Mapping_Account_By_MasterId" => $Mapping_Acount_By_MasterId,
            "ERP_Status" => 4,
            "Target_ERP_Time_Hours" => $this->request->getVar(
                "Target_ERP_Time_Hours"
            ),
            "ERP_Delay_On_Time" => $this->request->getVar("ERP_Delay_On_Time"),
            "ERP_Delay_On_Time" => $this->request->getVar("ERP_Delay_On_Time"),
            "ERP_AnyImage" => $imageName,
            "ERP_Remark" => $this->request->getVar("ERP_Remark"),
        ];

        $billid = $this->db->query("SELECT compeny_id, Vendor_Id from asitek_bill_register WHERE id = '$id'")->getResult(); // Adjust the column name based on your database structure
        $vendorvalue = $billid[0]->Vendor_Id;
        $compnyvalue = $billid[0]->compeny_id;

        $vdr = $vendormodel->where("id", $vendorvalue)->first();
        $cpn = $companymodel->where("id", $compnyvalue)->first();
        $billid = $this->db->query("SELECT uid from asitek_bill_register WHERE id='$id' AND ERP_Status=2")->getResult(); // Adjust the column name based on your database structure

        if (isset($billid) && !empty($billid)) {
            if ($model->where("id", $id)->set($data)->update()) {
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
                }
                else
                {
                    $currentDay = date('d');
                    if ($currentDay <= 10) { 
                        $reward_point =  $Add_RewardPoint + $Remark_RewardPoint + $FileAttch_RewardPoint;  
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
                    }
                    else{
                        $reward_point =  0;  
                    }
                }

              
                
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
        else{
            $session->setFlashdata("Mapping_erpStystem", 2);
            return redirect("all_erpStystem_list");
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
        $Recived_Status=$this->request->getVar("Recived_Status");
        if($Recived_Status==2||$Recived_Status==4)
        {
            echo $Recived_Status_Change_By_MasterId = $result["emp_id"];
        }
        else
        {
            echo  $Recived_Status_Change_By_MasterId = '';
        }
        $data = [
            "Recived_Status_Change_By_MasterId" => $Recived_Status_Change_By_MasterId,
            "Recived_Status" => $this->request->getVar("Recived_Status"),
            "Recived_Comment" => $this->request->getVar("Recived_Comment"),
            "Recived_DateTime" => $Recived_DateTime,
        ];

        $billid = $this->db->query("SELECT uid from asitek_bill_register WHERE id='$id' AND Recived_Status=1")->getResult(); // Adjust the column name based on your database structure

        if (isset($billid) && !empty($billid)) {
            if ($model->where("id", $id)->set($data)->update()) {
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
                }
                else
                {
                    $currentDay = date('d');
                    if ($currentDay <= 10) { 
                        $reward_point = $Add_RewardPoint + $Remark_RewardPoint;
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
                    }
                    else{
                        $reward_point = 0;
                    }
                }
                
                

                // ****End RewardPoint**

                if ($action == "all") {
                    $session->setFlashdata("Bill_Acceptation_Status", 1);
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
        else{
            $session->setFlashdata("Bill_Acceptation_Status", 2);
            return redirect("all_recived_bill_list");
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

    // public function CheckUp_RecivedBill()
    // {
    //     $session = \Config\Services::session();
    //     $email = \Config\Services::email();
    //     $result = $session->get();
    //     $vendormodel = new PartyUserModel();
    //     $companymodel = new CompenyModel();
    //     $model = new BillRegisterModel();
    //     $id = $this->request->getVar("id");
    //     $action = $this->request->getVar("action");
    //     $validation = \Config\Services::validation();
    //     $Recived_Completed_By_MasterId = $result["emp_id"];
    //     $file = $this->request->getFile("E_Image");
    //     if ($file != "") {
    //         $validation->setRules([
    //             "E_Image" =>
    //                 "uploaded[E_Image]|ext_in[E_Image,jpg,JPG,png,PNG,jpeg,JPEG,pdf]",
    //         ]);
    //         if (!$validation->withRequest($this->request)->run()) {
    //             $data["error"] = $validation->getErrors();
    //             $this->index();
    //             return view("add_bill_register");
    //         } else {
    //             $imageName = $file->getRandomName();
    //             $file->move("public/vendors/PicUpload", $imageName);
    //         }
    //     } else {
    //         $imageName = "";
    //     }

    //     $data = [
    //         "Recived_Status" => 4,
    //         "Recived_TragetTime_Hours" => $this->request->getVar(
    //             "Recived_TragetTime_Hours"
    //         ),
    //         "Recived_Delay_On_Time" => $this->request->getVar(
    //             "Recived_Delay_On_Time"
    //         ),
    //         "Recived_AnyImage" => $imageName,
    //         "Recived_Remark" => $this->request->getVar("Recived_Remark"),
    //         "Recived_Completed_By_MasterId" => $Recived_Completed_By_MasterId,
    //     ];

    //     $billid = $this->db->query("SELECT compeny_id, Vendor_Id from asitek_bill_register WHERE id = '$id'")->getResult(); // Adjust the column name based on your database structure
    //     $vendorvalue = $billid[0]->Vendor_Id;
    //     $compnyvalue = $billid[0]->compeny_id;

    //     $vdr = $vendormodel->where("id", $vendorvalue)->first();
    //     $cpn = $companymodel->where("id", $compnyvalue)->first();
    //     $billid = $this->db->query("SELECT uid from asitek_bill_register WHERE id='$id' AND Recived_Status=2")->getResult(); // Adjust the column name based on your database structure

    //     if (isset($billid) && !empty($billid)) {
    //         if ($model->where("id", $id)->set($data)->update()) {
    //             // ****Start RewardPoint**
    //             $Add_RewardPoint = 10;
    //             $Remark = $this->request->getVar("Recived_Remark");
    //             if ($Remark != "") {
    //                 $Remark_RewardPoint = 10;
    //             } else {
    //                 $Remark_RewardPoint = 0;
    //             }
    //             $E_Image = $this->request->getFile("E_Image");
    //             if ($E_Image != "") {
    //                 $FileAttch_RewardPoint = 10;
    //             } else {
    //                 $FileAttch_RewardPoint = 0;
    //             }

    //             $BillRegObjNew = new BillRegisterModel();
    //             $id3 = $this->request->getVar("id");
    //             $BillRegrow= $BillRegObjNew->where('id', $id3)->first();
    //             $Bill_DateTime2=$BillRegrow['Bill_DateTime'];
    //             $currentmonth=date("Y-m-d H:i:s");
    //             $month = date('m', strtotime($currentmonth));
    //             $month2 = date('m', strtotime($Bill_DateTime2));
    //             if($month<=$month2)
    //             {
    //                 $reward_point = $Add_RewardPoint + $Remark_RewardPoint + $FileAttch_RewardPoint;
    //                 $reward_point_type = "Bill Received A/c Completed";
    //                 $session_compeny_id = $session->get("compeny_id");
    //                 $session_emp_id = $session->get("emp_id");
    //                 $DateTimenew = date("Y-m-d H:i:s");
    //                 $dataRewardPoint = [
    //                     "bill_id" => $id,
    //                     "compeny_id" => $session_compeny_id,
    //                     "emp_id" => $session_emp_id,
    //                     "reward_point" => $reward_point,
    //                     "reward_point_type" => $reward_point_type,
    //                     "rec_time_stamp" => $DateTimenew,
    //                 ];
    //                 $RewardPointobj = new RewardPointModel();
    //                 $RewardPoint = $RewardPointobj->insert($dataRewardPoint);
    //             }
    //             else
    //             {
    //                 $currentDay = date('d');
    //                 if ($currentDay <= 10) {
    //                     $reward_point = $Add_RewardPoint + $Remark_RewardPoint + $FileAttch_RewardPoint;
    //                     $reward_point_type = "Bill Received A/c Completed";
    //                     $session_compeny_id = $session->get("compeny_id");
    //                     $session_emp_id = $session->get("emp_id");
    //                     $DateTimenew = date("Y-m-d H:i:s");
    //                     $dataRewardPoint = [
    //                         "bill_id" => $id,
    //                         "compeny_id" => $session_compeny_id,
    //                         "emp_id" => $session_emp_id,
    //                         "reward_point" => $reward_point,
    //                         "reward_point_type" => $reward_point_type,
    //                         "rec_time_stamp" => $DateTimenew,
    //                     ];
    //                     $RewardPointobj = new RewardPointModel();
    //                     $RewardPoint = $RewardPointobj->insert($dataRewardPoint);
    //                 }
    //                 else{
    //                     $reward_point = 0;
    //                 }
    //             }

                
                
    //             if($month<=$month2)
    //             {
    //                 $RewardPointobj->where("bill_id", $id)->set("status", 2)->update(); 
    //             }
    //             else
    //             {                         
    //                 $currentDay = date('d');
    //                 if ($currentDay <= 10) {
    //                     $RewardPointobj->where("bill_id", $id)->set("status", 2)->update();
    //                 }
    //                 else{
    //                     $RewardPointobj->where("bill_id", $id)->set("status", 3)->update();
    //                 }
    //             }

    //             // ****End RewardPoint**
    //             if ($action == "all") {
    //                 $wpmsg =
    //                     "Dear " .
    //                     $vdr["Name"] .
    //                     ", We wanted to inform you that your bill has been successfully received by our accounting department. Thank you for your prompt submission! Best regards, " .
    //                     $cpn["name"];
    //                 // $url = "https://chatway.in/api/send-msg?username=ashrishaWCH&number=+91".$vdr['Mobile_No']."&message=".$wpmsg."&token=Y21iQk9IeExwbjluMGE2SUxhM2taQT09";
    //                 // $url = preg_replace("/ /", "%20", $url);
    //                 // $response = file_get_contents($url);

    //                 // $email->setFrom("singhshaan085@gmail.com", "Bill Management");
    //                 // $email->setTo($vdr["Email_Id"]);
    //                 // $email->setSubject("Bill Add in Company | Bill Management");
    //                 // $email->setmailType("html");
    //                 // $email->setMessage($wpmsg); //your message here
    //                 // $email->send();
    //                 $session->setFlashdata("Mapping_RecivedBill", 1);
    //                 return redirect("all_recived_bill_list");
    //             } elseif ($action == "single") {

    //                 $wpmsg =
    //                     "Dear " .
    //                     $vdr["Name"] .
    //                     ", We wanted to inform you that your bill has been successfully received by our accounting department. Thank you for your prompt submission! Best regards, " .
    //                     $cpn["name"];
    //                 // $url = "https://chatway.in/api/send-msg?username=ashrishaWCH&number=+91".$vdr['Mobile_No']."&message=".$wpmsg."&token=Y21iQk9IeExwbjluMGE2SUxhM2taQT09";
    //                 // $url = preg_replace("/ /", "%20", $url);
    //                 // $response = file_get_contents($url);

    //                 // $email->setFrom("singhshaan085@gmail.com", "Bill Management");
    //                 // $email->setTo($vdr["Email_Id"]);
    //                 // $email->setSubject("Bill Add in Company | Bill Management");
    //                 // $email->setmailType("html");
    //                 // $email->setMessage($wpmsg); //your message here
    //                 // $email->send();
    //                 
    //                 <script type="text/javascript"> 
    //                     alert('Successfully ');
    //                     window.location.href="<?php echo base_url(
    //                         "/index.php/sigle_bill_list/" . $id
    //                     ); "
    //                 </script>
    //                 <?php
    //             }
    //         }
    //     }
    //     else{
    //         $session->setFlashdata("Mapping_RecivedBill", 2);
    //         return redirect("all_recived_bill_list");
    //     }    
    // }




public function CheckUp_RecivedBill()
{
    $session = \Config\Services::session();
    $email = \Config\Services::email();

    $result = $session->get();
    $vendormodel = new PartyUserModel();
    $companymodel = new CompenyModel();
    $model = new BillRegisterModel();

    $id = $this->request->getVar("id");
    $action = $this->request->getVar("action");
    $Recived_Completed_By_MasterId = $result["emp_id"];

    $file = $this->request->getFile("E_Image");
    $imageName = "";
    if ($file && $file->isValid()) {
        $validation = \Config\Services::validation();
        $validation->setRules([
            "E_Image" => "uploaded[E_Image]|ext_in[E_Image,jpg,JPG,png,PNG,jpeg,JPEG,pdf]"
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            $data["error"] = $validation->getErrors();
            $this->index();
            return view("add_bill_register");
        }

        $imageName = $file->getRandomName();
        $file->move("public/vendors/PicUpload", $imageName);
    }

    // Update Bill Data
    $data = [
        "Recived_Status" => 4,
        "Recived_TragetTime_Hours" => $this->request->getVar("Recived_TragetTime_Hours"),
        "Recived_Delay_On_Time" => $this->request->getVar("Recived_Delay_On_Time"),
        "Recived_AnyImage" => $imageName,
        "Recived_Remark" => $this->request->getVar("Recived_Remark"),
        "Recived_Completed_By_MasterId" => $Recived_Completed_By_MasterId,
    ];

    // Retrieve bill data
    $bill = $model->find($id);
    if (!$bill) {
        $session->setFlashdata("Mapping_RecivedBill", 2);
        return redirect("all_recived_bill_list");
    }

    // Update the bill and calculate rewards
    if ($model->update($id, $data)) {
        $Bill_DateTime2 = $bill['Bill_DateTime'];
        $Received_DateTime = date("Y-m-d H:i:s");

        // // Convert to DateTime objects
        // $billDate = new DateTime($Bill_DateTime2);
        // $receivedDate = new DateTime($Received_DateTime);

        // // Calculate cutoff date
        // $cutoffDate = clone $billDate;
        // $cutoffDate->modify('first day of next month')->modify('+10 days');

        // Convert to DateTime objects
        $billDate = new \DateTime($Bill_DateTime2);
        $receivedDate = new \DateTime($Received_DateTime);

        // Calculate cutoff date
        $cutoffDate = clone $billDate;
        $cutoffDate->modify('first day of next month')->modify('+10 days');

        // Reward point calculation
        $Add_RewardPoint = 10;
        $Remark = $this->request->getVar("Recived_Remark");
        $Remark_RewardPoint = $Remark ? 10 : 0;
        $FileAttch_RewardPoint = $imageName ? 10 : 0;
        $reward_point = $Add_RewardPoint + $Remark_RewardPoint + $FileAttch_RewardPoint;

        // Prepare reward data
        $reward_point_type = "Bill Received A/c Completed";
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
        $RewardPointobj->insert($dataRewardPoint);

        // Update status based on cutoff date
        $status = ($receivedDate <= $cutoffDate) ? 2 : 3;
        $RewardPointobj->where("bill_id", $id)->set("status", $status)->update();

        // Send notifications based on action
        if ($action === "all") {
            $session->setFlashdata("Mapping_RecivedBill", 1);
            return redirect("all_recived_bill_list");
        } elseif ($action === "single") {
            echo "<script>alert('Successfully'); window.location.href='" . base_url("/index.php/sigle_bill_list/$id") . "';</script>";
        }
    } else {
        $session->setFlashdata("Mapping_RecivedBill", 2);
        return redirect("all_recived_bill_list");
    }
}


    public function all_recived_bill_list()
    {
        $session = \Config\Services::session();
        $result = $session->get();
        $BillRegister = new BillRegisterModel();
        $page = $this->request->getVar('page') ?? 1;
        $perPage = 25;
        $startSerial = ($page - 1) * $perPage + 1;
        $Roll_id = $session->get("Roll_id");
        $emp_id = $session->get("emp_id");
        $compeny_id = $session->get("compeny_id");
        $Unit_Id = $this->request->getVar('Unit_Id') ?? "";
        $Vendor_Id = $this->request->getVar('Vendor_Id') ?? "";
        $assignedto = $this->request->getVar('assignedto') ?? "";
        $SendBy = $this->request->getVar('SendBy') ?? "";
        $Satus = $this->request->getVar('Satus') ?? "";
        $session->set(["Unit_Id" => $Unit_Id,"Vendor_Id" => $Vendor_Id,"assignedto" => $assignedto,"Satus" => $Satus]);
        // Default date values
        $defaultStartDate = '2019-05-06';
        $defaultEndDate = '9019-05-06';
        $date_format = '%Y-%m-%d';
    
        // Get session dates or use defaults
        $Sesssion_start_Date_New = !empty($result['Sesssion_start_Date']) ? $result['Sesssion_start_Date'] : $defaultStartDate;
        $Sesssion_end_Date_New = !empty($result['Sesssion_end_Date']) ? $result['Sesssion_end_Date'] : $defaultEndDate;
    
        // Construct the query conditions based on role and filters
        if ($Roll_id == 1||$Roll_id == 2) {
            // Admin role
            $usersQuery = $BillRegister->select("asitek_bill_register.*, asitek_employee.emp_u_id, asitek_employee.first_name, asitek_employee.last_name")
                ->join('asitek_employee', 'asitek_bill_register.Add_By = asitek_employee.id', 'left')
                ->where('asitek_bill_register.compeny_id', $compeny_id)
                ->where('asitek_bill_register.Bill_Acceptation_Status', 4)
                ->where('asitek_bill_register.Clear_Bill_Form_Status', 4)
                ->where('asitek_bill_register.ERP_Status', 4)
                ->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$Sesssion_start_Date_New', '$date_format') AND STR_TO_DATE('$Sesssion_end_Date_New', '$date_format')")
                ->orderBy('asitek_bill_register.id', 'desc');
        } else {
            // Employee role
            $usersQuery = $BillRegister->select("asitek_bill_register.*, asitek_employee.emp_u_id, asitek_employee.first_name, asitek_employee.last_name")
                ->join('asitek_employee', 'asitek_bill_register.Add_By = asitek_employee.id', 'left')
                ->where('asitek_bill_register.compeny_id', $compeny_id)
                ->where('asitek_bill_register.Bill_Acceptation_Status', 4)
                ->where('asitek_bill_register.Clear_Bill_Form_Status', 4)
                ->where('asitek_bill_register.ERP_Status', 4)
                ->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$Sesssion_start_Date_New', '$date_format') AND STR_TO_DATE('$Sesssion_end_Date_New', '$date_format')")
                ->where('asitek_bill_register.Mapping_Acount_EmpId', $emp_id)
                ->orderBy('asitek_bill_register.id', 'desc');
        }
    
        if (!empty($Unit_Id)) {
            $usersQuery->where('asitek_bill_register.Unit_Id', $Unit_Id);
        }
    
        if (!empty($Vendor_Id)) {
            $usersQuery->where('asitek_bill_register.Vendor_Id', $Vendor_Id);
        }
    
        if (!empty($assignedto)) {
            $usersQuery->where('asitek_bill_register.Mapping_ERP_EmpId', $assignedto);
        }
    
        if (!empty($SendBy)) {
            $usersQuery->where('asitek_bill_register.Mapping_Account_By_MasterId', $SendBy);
        }
    
        if (!empty($Satus)) {
            if ($Satus != "All") {
                $usersQuery->where('asitek_bill_register.Recived_Status', $Satus);
            }
        }
    
        // Execute the query with pagination
        $users = $usersQuery->paginate($perPage);
    
        // Fetch additional data
        $dax9 = [];
        $data_recommended = [];
        $dax15 = [];
        $dax16 = [];
    
        // Fetch department data
        $model9 = new DepartmentModel();
        if ($model9) {
            $dax9 = $model9->where("compeny_id", $compeny_id)->findAll();
        }
    
        // Fetch vendors
        if ($Roll_id == 1) {
            $data_recommended = $this->getVendors($compeny_id);
        }
    
        // Fetch unit data
        $model15 = new UnitModel();
        if ($model15) {
            $dax15 = $model15->where("compeny_id", $compeny_id)->findAll();
        }
    
        // Fetch department data again
        $model16 = new DepartmentModel();
        if ($model16) {
            $dax16 = $model16->where("compeny_id", $compeny_id)->findAll();
        }
    
        $data = [
            'users' => $users,
            'pager' => $BillRegister->pager,
            'startSerial' => $startSerial,
            'nextPage' => $page + 1,
            'previousPage' => ($page > 1) ? $page - 1 : null,
            'dax9' => $dax9,
            'dax14' => $data_recommended,
            'dax15' => $dax15,
            'dax16' => $dax16,
        ];
        return view("all_recived_bill_list", $data);
    }
    
    // Function to fetch vendors (used only by admins)
    private function getVendors($compeny_id)
    {
        $builderrecommended = $this->db->table("asitek_company_vendor");
        $builderrecommended->select('asitek_company_vendor.Vendor_Id, asitek_party_user.id, asitek_party_user.GST_No, asitek_party_user.Name');
        $builderrecommended->join('asitek_party_user', 'asitek_party_user.id = asitek_company_vendor.Vendor_Id');
        $builderrecommended->where('asitek_company_vendor.Company_Id', $compeny_id);
        $builderrecommended->groupBy('asitek_company_vendor.Vendor_Id');
        $builderrecommended->orderBy('asitek_party_user.Name', 'ASC');
        return $builderrecommended->get()->getResult();
    }
    //************** Recived Bill End***************


    public function export_all_recived_bill_list(){
        $session = \Config\Services::session();
        $result = $session->get(); 
        $Roll_id = $session->get("Roll_id");
        $emp_id = $session->get("emp_id");
        $compeny_id = $session->get("compeny_id");   
        $model = new BillRegisterModel();
        $UnitModelObj = new UnitModel();
        $RollModelObj = new RollModel();
        $EmployeeModelObj = new EmployeeModel();
        $PartyUserModelObj = new PartyUserModel();
        $DepartmentModelObj = new DepartmentModel();
        $MasterActionmadelObj = new MasterActionModel();
        $MasterActionUploadModelObj = new MasterActionUploadModel();

        if ($session->has('Unit_Id')) {
            $Unit_Id = $result['Unit_Id']; 
        } else {
           $Unit_Id = ""; 
        }
        if ($session->has('Vendor_Id')) {
            echo  $Vendor_Id = $result['Vendor_Id']; 
        } else {
            echo $Vendor_Id = ""; 
        }
        if ($session->has('assignedto')) {
            $assignedto = $result['assignedto'];
        } else {
            $assignedto = ""; 
        }
        if ($session->has('SendBy')) {
            $SendBy = $result['SendBy']; 
        } else {
            $SendBy = ""; 
        }
        if ($session->has('Satus')) {
            $Satus = $result['Satus']; 
        } else {
           $Satus = ""; 
        }

         // Default start and end date values
        $defaultStartDate = '2019-05-06';
        $defaultEndDate = '9019-05-06';
        
        // Retrieve session start and end date values
        $Sesssion_start_Date_New = !empty($session->get('Sesssion_start_Date')) ? $session->get('Sesssion_start_Date') : $defaultStartDate;
        $Sesssion_end_Date_New = !empty($session->get('Sesssion_end_Date')) ? $session->get('Sesssion_end_Date') : $defaultEndDate;
        // Date format for SQL query
        $date_format = '%Y-%m-%d';

        // Excel file name for download 
        $fileName = "all_recived_bill_list" . date('Y-m-d') . ".xls";     
        // Column names 
        $fields = array('Bill Pic', 'Bill Id', 'Vendor', 'Bill No', 'Bill Amount', 'Bill Date', 'Unit Name', 'Gate Entry No', 'Gate Entry Date', 'Send By' ,  'Sender Comment', 'Sender File','Accept Date','Accept Comment','Master Action Comment','Master Action File','Completed Comment','Completed File','Vendor Comment','Vendor File','Action'); 
        // Display column names as first row 
        $excelData = implode("\t", array_values($fields)) . "\n"; 
        // Fetch records from database
        if ($Roll_id == 1||$Roll_id == 2) {
           $usersQuery = $model->select("asitek_bill_register.*, asitek_employee.emp_u_id, asitek_employee.first_name, asitek_employee.last_name")
                ->join('asitek_employee', 'asitek_bill_register.Add_By = asitek_employee.id', 'left')
                ->where('asitek_bill_register.compeny_id', $compeny_id)
                ->where('asitek_bill_register.Bill_Acceptation_Status', 4)
                ->where('asitek_bill_register.Clear_Bill_Form_Status', 4)
                ->where('asitek_bill_register.ERP_Status', 4)
                ->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$Sesssion_start_Date_New', '$date_format') AND STR_TO_DATE('$Sesssion_end_Date_New', '$date_format')")
                ->orderBy('asitek_bill_register.id', 'desc');
        } else {
            // Employee role
            $usersQuery = $BillRegister->select("asitek_bill_register.*, asitek_employee.emp_u_id, asitek_employee.first_name, asitek_employee.last_name")
                ->join('asitek_employee', 'asitek_bill_register.Add_By = asitek_employee.id', 'left')
                ->where('asitek_bill_register.compeny_id', $compeny_id)
                ->where('asitek_bill_register.Bill_Acceptation_Status', 4)
                ->where('asitek_bill_register.Clear_Bill_Form_Status', 4)
                ->where('asitek_bill_register.ERP_Status', 4)
                ->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$Sesssion_start_Date_New', '$date_format') AND STR_TO_DATE('$Sesssion_end_Date_New', '$date_format')")
                ->where('asitek_bill_register.Mapping_Acount_EmpId', $emp_id)
                ->orderBy('asitek_bill_register.id', 'desc');
        }   
       
        if (!empty($Unit_Id)) {
            $usersQuery->where('asitek_bill_register.Unit_Id', $Unit_Id);
        }
    
        if (!empty($Vendor_Id)) {
            $usersQuery->where('asitek_bill_register.Vendor_Id', $Vendor_Id);
        }
    
        if (!empty($assignedto)) {
            $usersQuery->where('asitek_bill_register.Mapping_ERP_EmpId', $assignedto);
        }
    
        if (!empty($SendBy)) {
            $usersQuery->where('asitek_bill_register.Mapping_Account_By_MasterId', $SendBy);
        }
    
        if (!empty($Satus)) {
            if ($Satus != "All") {
                $usersQuery->where('asitek_bill_register.Recived_Status', $Satus);
            }
        }
    
     
        $data = $usersQuery->findAll();
        $stage_id=5;
        if(isset($data)){ 
            // Output each row of the data 
            foreach($data as $row)
            { 
                //*************
                if(isset($row['Bill_Pic'])){$Bill_Pic =base_url('public/vendors/PicUpload/'.$row['Bill_Pic']);}
                else{ $Bill_Pic = '';}
                if(isset($row['uid'])){$uid = $row['uid'];}else{ $uid = 'NA';}
                $Vendorrow= $PartyUserModelObj->where('id',$row['Vendor_Id'])->first();
                if(isset($Vendorrow) && $Vendorrow!='')
                {
                    $VendorName= $Vendorrow['Name']; 
                }
                else
                {
                    $VendorName=''; 
                }
                if(isset($row['Bill_No'])){$Bill_No = $row['Bill_No'];}else{ $Bill_No = 'NA';}
                if(isset($row['Bill_Amount'])){$Bill_Amount = $row['Bill_Amount'];}else{ $Bill_Amount = 'NA';}
                if(isset($row['Bill_DateTime'])){$Bill_DateTime = date('d/m/Y', strtotime($row['Bill_DateTime']));}else{ $Bill_DateTime = 'NA';}
                $Unitrow= $UnitModelObj->where('id',$row['Unit_Id'])->first();
                if(isset($Unitrow) && $Unitrow!='')
                {
                    $UnitName =$Unitrow['name']; 
                }
                else{
                    $UnitName='';
                }
                if(isset($row['Gate_Entry_No'])){$Gate_Entry_No = $row['Gate_Entry_No'];}else{ $Gate_Entry_No = 'NA';}
                if(isset($row['Gate_Entry_Date'])){$Gate_Entry_Date = date('d/m/Y', strtotime($row['Gate_Entry_Date']));}else{ $Gate_Entry_Date = 'NA';}
                $MappingEmprow= $EmployeeModelObj->where('id',$row['Mapping_ERP_EmpId'])->first();
                if(isset($MappingEmprow) && $MappingEmprow!='')
                {
                    $Department_Emp_Id= $MappingEmprow['first_name'].' '.$MappingEmprow['last_name'];
                }
                else{
                    $Department_Emp_Id=''; 
                }
                if(isset($row['ERP_Remark'])){$ERP_Remark = $row['ERP_Remark'];}else{ $ERP_Remark = 'NA';}
                if(!empty($row['ERP_AnyImage'])){ 
                    $ERP_AnyImage= base_url('public/vendors/PicUpload/'.$row['ERP_AnyImage']);
                }
                else{
                    $ERP_AnyImage='No Image';
                } 
                if(isset($row['Recived_DateTime'])){$Recived_DateTime = $row['Recived_DateTime'];}else{ $Recived_DateTime = 'NA';}
                if(isset($row['Recived_Comment'])){$Recived_Comment = $row['Recived_Comment'];}else{ $Recived_Comment = 'NA';}
                $rowMasterAction2= $MasterActionmadelObj->where('compeny_id', $compeny_id)->where('stage_id',$stage_id)->where('no_of_action',$row['ClearFormBill_Master_Action'])->first();
                if(isset($rowMasterAction2) && $rowMasterAction2!='')
                {
                    $rowMasterActionUpload= $MasterActionUploadModelObj->where('compeny_id', $compeny_id)->where('bill_id',$row['id'])->where('master_action_id',$rowMasterAction2['id'])->first(); 
                    if(isset($rowMasterActionUpload) && $rowMasterActionUpload!='')
                    {  
                        $MasterActionComment= $rowMasterActionUpload['remark'];
                    }
                    else{
                        $MasterActionComment='';
                    } 
                    if(isset($rowMasterActionUpload) && $rowMasterActionUpload!='') { 
                        if(!empty($rowMasterActionUpload['image_upload'])){
                            $image_upload=base_url('public/vendors/PicUploadMasterAction/'.$rowMasterActionUpload['image_upload']);
                        }
                        else{
                            $image_upload='No Image';
                        }
                    }
                    else{
                        $image_upload='No Image';
                    }
                }
                else{ 
                    $MasterActionComment='';
                    $image_upload='No Image';
                }
                if(isset($row['Recived_Remark'])){$Recived_Remark = $row['Recived_Remark'];}else{ $Recived_Remark = 'NA';}
                if(!empty($row['Recived_AnyImage'])){
                    $Recived_AnyImage=base_url('public/vendors/PicUpload/'.$row['Recived_AnyImage']);
                }
                else{
                    $Recived_AnyImage='No Image';
                } 
                if(isset($row['Vendor_Comment'])){$Vendor_Comment = $row['Vendor_Comment'];}else{ $Vendor_Comment = 'NA';}
                if(!empty($row['Vendor_Upload_Image'])){ 
                    $Vendor_Upload_Image= base_url('public/vendors/PicUpload/'.$row['Vendor_Upload_Image']);
                }
                else{
                    $Vendor_Upload_Image= 'No Image';
                }
                if($row['ERP_Status']==1)
                {
                    $Status='Pending';
                }
                elseif($row['ERP_Status']==2)
                {
                    $Status='Accepted';
                }
                elseif($row['ERP_Status']==3)
                {
                    $Status='Reject';
                }
                elseif($row['ERP_Status']==4)
                {
                    $Status='Done';
                }
                //*************
                $lineData = array( 'link', $uid, $VendorName, $Bill_No,$Bill_Amount,$Bill_DateTime,$UnitName,$Gate_Entry_No,$Gate_Entry_Date,  $Department_Emp_Id,$ERP_Remark,$ERP_AnyImage,$Recived_DateTime,$Recived_Comment,$MasterActionComment,$image_upload,$Recived_Remark,$Recived_AnyImage,$Vendor_Comment,$Vendor_Upload_Image,$Status);
                // array_walk(str_replace('"', '""',(preg_replace("/\r?\n/", "\\n",(preg_replace("/\t/", "\\t", $lineData))))); 
                $excelData .= implode("\t", array_values($lineData)) . "\n";   
            } 
        }
        else{ 
            $session->setFlashdata('excel',1);
        } 
        // Headers for download 
        header("Content-Type: application/vnd.ms-excel"); 
        header("Content-Disposition: attachment; filename=\"$fileName\""); 
        echo $excelData; 
        exit;
    }

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
        $BillRegister = new BillRegisterModel();
        $page = $this->request->getVar('page') ?? 1;
        $perPage = 25;
        $startSerial = ($page - 1) * $perPage + 1;
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
                    $users = $BillRegister ->select("asitek_bill_register.*, asitek_employee.emp_u_id, asitek_employee.first_name, asitek_employee.last_name")->join('asitek_employee', 'asitek_bill_register.Add_By = asitek_employee.id', 'left')->where('asitek_bill_register.compeny_id', $compeny_id)->where('asitek_bill_register.Bill_Acceptation_Status',4)->where('asitek_bill_register.Clear_Bill_Form_Status',4)->where('asitek_bill_register.ERP_Status',4)->where('asitek_bill_register.Unit_Id', $Unit_Id)->orderBy('asitek_bill_register.id', 'desc')->paginate($perPage);
                } else {
                    $users = $BillRegister ->select("asitek_bill_register.*, asitek_employee.emp_u_id, asitek_employee.first_name, asitek_employee.last_name")->join('asitek_employee', 'asitek_bill_register.Add_By = asitek_employee.id', 'left')->where('asitek_bill_register.compeny_id', $compeny_id)->where('asitek_bill_register.Bill_Acceptation_Status',4)->where('asitek_bill_register.Clear_Bill_Form_Status',4)->where('asitek_bill_register.ERP_Status',4)->where('asitek_bill_register.Recived_Status', $Satus)->where('asitek_bill_register.Unit_Id', $Unit_Id)->orderBy('asitek_bill_register.id', 'desc')->paginate($perPage);
                }
            }

            if(empty($Unit_Id) && !empty($Vendor_Id) && empty($assignedto) && !empty($Satus)){
                if ($Satus == "All") {
                    $users = $BillRegister ->select("asitek_bill_register.*, asitek_employee.emp_u_id, asitek_employee.first_name, asitek_employee.last_name")->join('asitek_employee', 'asitek_bill_register.Add_By = asitek_employee.id', 'left')->where('asitek_bill_register.compeny_id', $compeny_id)->where('asitek_bill_register.Bill_Acceptation_Status',4)->where('asitek_bill_register.Clear_Bill_Form_Status',4)->where('asitek_bill_register.ERP_Status',4)->where('asitek_bill_register.Vendor_Id', $Vendor_Id)->orderBy('asitek_bill_register.id', 'desc')->paginate($perPage);
                } else {
                    $users = $BillRegister ->select("asitek_bill_register.*, asitek_employee.emp_u_id, asitek_employee.first_name, asitek_employee.last_name")->join('asitek_employee', 'asitek_bill_register.Add_By = asitek_employee.id', 'left')->where('asitek_bill_register.compeny_id', $compeny_id)->where('asitek_bill_register.Bill_Acceptation_Status',4)->where('asitek_bill_register.Clear_Bill_Form_Status',4)->where('asitek_bill_register.ERP_Status',4)->where('asitek_bill_register.Recived_Status', $Satus)->where('asitek_bill_register.Vendor_Id', $Vendor_Id)->orderBy('asitek_bill_register.id', 'desc')->paginate($perPage);
                }
            }
            // Vendor Filter wise End Code

            if(empty($Unit_Id) && empty($Vendor_Id) && !empty($assignedto) && !empty($Satus)){
                if ($Satus == "All") {
                    $users = $BillRegister ->select("asitek_bill_register.*, asitek_employee.emp_u_id, asitek_employee.first_name, asitek_employee.last_name")->join('asitek_employee', 'asitek_bill_register.Add_By = asitek_employee.id', 'left')->where('asitek_bill_register.compeny_id', $compeny_id)->where('asitek_bill_register.Bill_Acceptation_Status',4)->where('asitek_bill_register.Clear_Bill_Form_Status',4)->where('asitek_bill_register.ERP_Status',4)->orderBy('asitek_bill_register.id', 'desc')->paginate($perPage);
                } else {
                    $users = $BillRegister ->select("asitek_bill_register.*, asitek_employee.emp_u_id, asitek_employee.first_name, asitek_employee.last_name")->join('asitek_employee', 'asitek_bill_register.Add_By = asitek_employee.id', 'left')->where('asitek_bill_register.compeny_id', $compeny_id)->where('asitek_bill_register.Bill_Acceptation_Status',4)->where('asitek_bill_register.Clear_Bill_Form_Status',4)->where('asitek_bill_register.ERP_Status',4)->where('asitek_bill_register.Recived_Status', $Satus)->orderBy('asitek_bill_register.id', 'desc')->paginate($perPage);
                }
            }

            if(empty($Unit_Id) && empty($Vendor_Id) && empty($assignedto) && !empty($Satus)){
                if ($Satus == "All") {
                    $users = $BillRegister ->select("asitek_bill_register.*, asitek_employee.emp_u_id, asitek_employee.first_name, asitek_employee.last_name")->join('asitek_employee', 'asitek_bill_register.Add_By = asitek_employee.id', 'left')->where('asitek_bill_register.compeny_id', $compeny_id)->where('asitek_bill_register.Bill_Acceptation_Status',4)->where('asitek_bill_register.Clear_Bill_Form_Status',4)->where('asitek_bill_register.ERP_Status',4)->orderBy('asitek_bill_register.id', 'desc')->paginate($perPage);
                } else {
                    $users = $BillRegister ->select("asitek_bill_register.*, asitek_employee.emp_u_id, asitek_employee.first_name, asitek_employee.last_name")->join('asitek_employee', 'asitek_bill_register.Add_By = asitek_employee.id', 'left')->where('asitek_bill_register.compeny_id', $compeny_id)->where('asitek_bill_register.Bill_Acceptation_Status',4)->where('asitek_bill_register.Clear_Bill_Form_Status',4)->where('asitek_bill_register.ERP_Status',4)->where('asitek_bill_register.Recived_Status', $Satus)->orderBy('asitek_bill_register.id', 'desc')->paginate($perPage);
                }
            }
            if(empty($Unit_Id) && empty($Vendor_Id) && empty($assignedto) && empty($Satus)){
                $users = $BillRegister ->select("asitek_bill_register.*, asitek_employee.emp_u_id, asitek_employee.first_name, asitek_employee.last_name")->join('asitek_employee', 'asitek_bill_register.Add_By = asitek_employee.id', 'left')->where('asitek_bill_register.compeny_id', $compeny_id)->where('asitek_bill_register.Bill_Acceptation_Status',4)->where('asitek_bill_register.Clear_Bill_Form_Status',4)->where('asitek_bill_register.ERP_Status',4)->orderBy('asitek_bill_register.id', 'desc')->paginate($perPage);
            }
            // Only Status  Filter wise End Code
        }
        //Admin Roll End
        //Other Roll Start
        else {
            if(!empty($Unit_Id) && empty($Vendor_Id) && empty($assignedto) && !empty($Satus)){
                if ($Satus == "All") {
                    $users = $BillRegister ->select("asitek_bill_register.*, asitek_employee.emp_u_id, asitek_employee.first_name, asitek_employee.last_name")->join('asitek_employee', 'asitek_bill_register.Add_By = asitek_employee.id', 'left')->where('asitek_bill_register.compeny_id', $compeny_id)->where('asitek_bill_register.Bill_Acceptation_Status',4)->where('asitek_bill_register.Clear_Bill_Form_Status',4)->where('asitek_bill_register.ERP_Status',4)->where('asitek_bill_register.Unit_Id', $Unit_Id)->where('asitek_bill_register.Mapping_Acount_EmpId', $emp_id)->orderBy('asitek_bill_register.id', 'desc')->paginate($perPage);
                } else {
                    $users = $BillRegister ->select("asitek_bill_register.*, asitek_employee.emp_u_id, asitek_employee.first_name, asitek_employee.last_name")->join('asitek_employee', 'asitek_bill_register.Add_By = asitek_employee.id', 'left')->where('asitek_bill_register.compeny_id', $compeny_id)->where('asitek_bill_register.Bill_Acceptation_Status',4)->where('asitek_bill_register.Clear_Bill_Form_Status',4)->where('asitek_bill_register.ERP_Status',4)->where('asitek_bill_register.Unit_Id', $Unit_Id)->where('asitek_bill_register.Recived_Status', $Satus)->where('asitek_bill_register.Mapping_Acount_EmpId', $emp_id)->orderBy('asitek_bill_register.id', 'desc')->paginate($perPage);
                }
            }

            if(empty($Unit_Id) && !empty($Vendor_Id) && empty($assignedto) && !empty($Satus)){
                if ($Satus == "All") {
                    $users = $BillRegister ->select("asitek_bill_register.*, asitek_employee.emp_u_id, asitek_employee.first_name, asitek_employee.last_name")->join('asitek_employee', 'asitek_bill_register.Add_By = asitek_employee.id', 'left')->where('asitek_bill_register.compeny_id', $compeny_id)->where('asitek_bill_register.Bill_Acceptation_Status',4)->where('asitek_bill_register.Clear_Bill_Form_Status',4)->where('asitek_bill_register.ERP_Status',4)->where('asitek_bill_register.Vendor_Id', $Vendor_Id)->where('asitek_bill_register.Mapping_Acount_EmpId', $emp_id)->orderBy('asitek_bill_register.id', 'desc')->paginate($perPage);
                } else {
                    $users = $BillRegister ->select("asitek_bill_register.*, asitek_employee.emp_u_id, asitek_employee.first_name, asitek_employee.last_name")->join('asitek_employee', 'asitek_bill_register.Add_By = asitek_employee.id', 'left')->where('asitek_bill_register.compeny_id', $compeny_id)->where('asitek_bill_register.Bill_Acceptation_Status',4)->where('asitek_bill_register.Clear_Bill_Form_Status',4)->where('asitek_bill_register.ERP_Status',4)->where('asitek_bill_register.Recived_Status', $Satus)->where('asitek_bill_register.Vendor_Id', $Vendor_Id)->where('asitek_bill_register.Mapping_Acount_EmpId', $emp_id)->orderBy('asitek_bill_register.id', 'desc')->paginate($perPage);
                }
            }
            if(empty($Unit_Id) && empty($Vendor_Id) && !empty($assignedto) && !empty($Satus)){
                if ($Satus == "All") {
                    $users = $BillRegister ->select("asitek_bill_register.*, asitek_employee.emp_u_id, asitek_employee.first_name, asitek_employee.last_name")->join('asitek_employee', 'asitek_bill_register.Add_By = asitek_employee.id', 'left')->where('asitek_bill_register.compeny_id', $compeny_id)->where('asitek_bill_register.Bill_Acceptation_Status',4)->where('asitek_bill_register.Clear_Bill_Form_Status',4)->where('asitek_bill_register.ERP_Status',4)->where('asitek_bill_register.Mapping_Acount_EmpId', $emp_id)->orderBy('asitek_bill_register.id', 'desc')->paginate($perPage);
                } else {
                    $users = $BillRegister ->select("asitek_bill_register.*, asitek_employee.emp_u_id, asitek_employee.first_name, asitek_employee.last_name")->join('asitek_employee', 'asitek_bill_register.Add_By = asitek_employee.id', 'left')->where('asitek_bill_register.compeny_id', $compeny_id)->where('asitek_bill_register.Bill_Acceptation_Status',4)->where('asitek_bill_register.Clear_Bill_Form_Status',4)->where('asitek_bill_register.ERP_Status',4)->where('asitek_bill_register.Recived_Status', $Satus)->where('asitek_bill_register.Mapping_Acount_EmpId', $emp_id)->orderBy('asitek_bill_register.id', 'desc')->paginate($perPage);
                }
            }

            if(empty($Unit_Id) && empty($Vendor_Id) && empty($assignedto) && !empty($Satus)){
                if ($Satus == "All") {
                    $users = $BillRegister ->select("asitek_bill_register.*, asitek_employee.emp_u_id, asitek_employee.first_name, asitek_employee.last_name")->join('asitek_employee', 'asitek_bill_register.Add_By = asitek_employee.id', 'left')->where('asitek_bill_register.compeny_id', $compeny_id)->where('asitek_bill_register.Bill_Acceptation_Status',4)->where('asitek_bill_register.Clear_Bill_Form_Status',4)->where('asitek_bill_register.ERP_Status',4)->where('asitek_bill_register.Mapping_Acount_EmpId', $emp_id)->orderBy('asitek_bill_register.id', 'desc')->paginate($perPage);
                } else {
                    $users = $BillRegister ->select("asitek_bill_register.*, asitek_employee.emp_u_id, asitek_employee.first_name, asitek_employee.last_name")->join('asitek_employee', 'asitek_bill_register.Add_By = asitek_employee.id', 'left')->where('asitek_bill_register.compeny_id', $compeny_id)->where('asitek_bill_register.Bill_Acceptation_Status',4)->where('asitek_bill_register.Clear_Bill_Form_Status',4)->where('asitek_bill_register.ERP_Status',4)->where('asitek_bill_register.Recived_Status', $Satus)->where('asitek_bill_register.Mapping_Acount_EmpId', $emp_id)->orderBy('asitek_bill_register.id', 'desc')->paginate($perPage);
                }
            }
            if(empty($Unit_Id) && empty($Vendor_Id) && empty($assignedto) && empty($Satus)){
                $users = $BillRegister ->select("asitek_bill_register.*, asitek_employee.emp_u_id, asitek_employee.first_name, asitek_employee.last_name")->join('asitek_employee', 'asitek_bill_register.Add_By = asitek_employee.id', 'left')->where('asitek_bill_register.compeny_id', $compeny_id)->where('asitek_bill_register.Bill_Acceptation_Status',4)->where('asitek_bill_register.Clear_Bill_Form_Status',4)->where('asitek_bill_register.ERP_Status',4)->where('asitek_bill_register.Mapping_Acount_EmpId', $emp_id)->orderBy('asitek_bill_register.id', 'desc')->paginate($perPage);
            }

            // Only Status  Filter wise End Code
        }
        // Other Roll End

        $model9 = new DepartmentModel();
        $dax9 = $model9->where("compeny_id", $compeny_id)->findAll();
        $model3 = new EmployeeModel();
        $builderrecommended = $this->db->table("asitek_company_vendor");
        $builderrecommended->select('asitek_company_vendor.Vendor_Id, asitek_party_user.id, asitek_party_user.GST_No, asitek_party_user.Name');
        $builderrecommended->join('asitek_party_user', 'asitek_party_user.id = asitek_company_vendor.Vendor_Id');
        $builderrecommended->where('asitek_company_vendor.Company_Id', $compeny_id);
        $builderrecommended->groupBy('asitek_company_vendor.Vendor_Id');
        $builderrecommended->orderBy('asitek_party_user.Name', 'ASC');
        $data_recommended = $builderrecommended->get()->getResult();
        $model15 = new UnitModel();
        $dax15= $model15->where("compeny_id", $compeny_id)->findAll();
        $model16 = new DepartmentModel();
        $dax16 = $model16->where("compeny_id", $compeny_id)->findAll();
        $data = [
            'users' => $users,
            'pager' => $BillRegister->pager,
            'startSerial' => $startSerial,
            'nextPage' => $page + 1,
            'previousPage' => ($page > 1) ? $page - 1 : null,
            'dax9' => $dax9,
            'dax14' => $data_recommended,
            'dax15' => $dax15,
            'dax16' => $dax16,
        ];
        return view("view_complete_bill_list", $data);
    }
    //***********Complete View bill List End ****************


    // Bill Edit Start
    public function bill_edit($billid)
    {
        $session = \Config\Services::session();
        $result = $session->get();
        $compeny_id = $session->get("compeny_id");
        $model9 = new DepartmentModel();
        $data["dax9"] = $model9->where("compeny_id", $compeny_id)->findAll();
        $builderrecommended = $this->db->table("asitek_company_vendor");
        $builderrecommended->select('asitek_company_vendor.Vendor_Id, asitek_party_user.id, asitek_party_user.GST_No, asitek_party_user.Name');
        $builderrecommended->join('asitek_party_user', 'asitek_party_user.id = asitek_company_vendor.Vendor_Id');
        $builderrecommended->where('asitek_company_vendor.Company_Id', $compeny_id);
        $builderrecommended->groupBy('asitek_company_vendor.Vendor_Id');
        $builderrecommended->orderBy('asitek_party_user.Name', 'ASC');
        $data_recommended = $builderrecommended->get()->getResult();
        $data['dax14'] =$data_recommended;
        $model15 = new UnitModel();
        $data["dax15"] = $model15->where("compeny_id", $compeny_id)->findAll();
        $BillRegisterModelObj = new BillRegisterModel();
        $data["dax"] = $BillRegisterModelObj->where("id", $billid)->findAll();
        return view("bill_edit", $data);
    }
    // Bill Edit End    

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
            $BillRegisterrow = $BillRegisterModelObj->where("compeny_id", $compeny_id)->where("id", $billid)->first();
            if (isset($BillRegisterrow) && $BillRegisterrow != "") {
                if($BillRegisterrow['Bill_Acceptation_Status']==1 || $BillRegisterrow['Bill_Acceptation_Status']==2){
                    $data["dax"] = $this->db->query("select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id where asitek_bill_register.compeny_id='$compeny_id' and asitek_bill_register.id='$billid'"
                        )->getResultArray();
                    return view("sigle_bill_mapping_list", $data);
                }
                elseif($BillRegisterrow['Bill_Acceptation_Status']==4 && $BillRegisterrow['Clear_Bill_Form_Status']==1 || $BillRegisterrow['Clear_Bill_Form_Status']==2){
                    $data["dax"] = $this->db->query("select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id where asitek_bill_register.compeny_id='$compeny_id' and asitek_bill_register.id='$billid' and Bill_Acceptation_Status='4'")->getResultArray();
                    return view("single_Clear_Bill_Form_list", $data);
                }
                elseif($BillRegisterrow['Bill_Acceptation_Status']==4 && $BillRegisterrow['Clear_Bill_Form_Status']==4 AND $BillRegisterrow['ERP_Status']==1 || $BillRegisterrow['ERP_Status']==2){
                    $data["dax"] = $this->db->query("select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id where asitek_bill_register.compeny_id='$compeny_id' and asitek_bill_register.id='$billid' and Bill_Acceptation_Status='4' and Clear_Bill_Form_Status='4'")->getResultArray();
                    return view("single_erpStystem_list", $data);
                }
                elseif ($BillRegisterrow['Bill_Acceptation_Status']==4 && $BillRegisterrow['Clear_Bill_Form_Status']==4 AND $BillRegisterrow['ERP_Status']==4 AND $BillRegisterrow['Recived_Status']==1 || $BillRegisterrow['Recived_Status']==2) {
                    $data["dax"] = $this->db->query("select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id where asitek_bill_register.compeny_id='$compeny_id' and asitek_bill_register.id='$billid' and Bill_Acceptation_Status='4' and Clear_Bill_Form_Status='4' and ERP_Status='4'")->getResultArray();
                    return view("single_recived_bill_list", $data);
                }

            } else {
                $session->setFlashdata("success", "<div class='alert alert-danger' role='alert'> You are not authorize to process this bill (Either it is not assigned to you) </div>");
                return redirect("main-dashboard");
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
        $result = $session->get();
        $model = new BillRegisterModel();
        $uid = $this->request->getVar("billid");
        $companyid = $this->request->getVar("companyid");
        $Bill_Acceptation_Status_By_MasterId = $result["emp_id"];
        $billid = $this->db->query("SELECT id from asitek_bill_register WHERE compeny_id='$companyid' AND uid = '$uid' AND Bill_Acceptation_Status=1")->getResult(); // Adjust the column name based on your database structure

        if (isset($billid) && !empty($billid)) {
            $billidvalue = $billid[0]->id;
            $Bill_Acceptation_Status = $this->request->getVar("Bill_Acceptation_Status");
            $Bill_Acceptation_Status_Comments = $this->request->getVar("Bill_Acceptation_Status_Comments");
            $id = $billidvalue;
            date_default_timezone_set("Asia/Kolkata");
            $Bill_Acceptation_DateTime = date("Y-m-d H:i:s");

            $data = [
                "Bill_Acceptation_Status_By_MasterId" => $Bill_Acceptation_Status_By_MasterId,
                "Bill_Acceptation_Status" => $Bill_Acceptation_Status,
                "Bill_Acceptation_DateTime" => $Bill_Acceptation_DateTime,
                "Bill_Acceptation_Status_Comments" => $Bill_Acceptation_Status_Comments,
            ];

            $Add_RewardPoint = 20;
            $Remark = $this->request->getVar("Bill_Acceptation_Status_Comments");
            if ($Remark != "") {
                $Remark_RewardPoint = 20;
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
                $reward_point = $Add_RewardPoint + $Remark_RewardPoint;
                $rewardstatus = 1;
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
                    "status" => $rewardstatus,
                    "rec_time_stamp" => $DateTimenew,
                ];
                $RewardPointobj = new RewardPointModel();
                if ($Bill_Acceptation_Status == 2) {
                    $RewardPoint = $RewardPointobj->insert($dataRewardPoint);
                }
            }
            else
            {                         
                $currentDay = date('d');
                if ($currentDay <= 10) { 
                    $reward_point = $Add_RewardPoint + $Remark_RewardPoint;
                    $rewardstatus = 1;
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
                        "status" => $rewardstatus,
                        "rec_time_stamp" => $DateTimenew,
                    ];
                    $RewardPointobj = new RewardPointModel();
                    if ($Bill_Acceptation_Status == 2) {
                        $RewardPoint = $RewardPointobj->insert($dataRewardPoint);
                    }
                }
                else{
                    $reward_point = $Add_RewardPoint + $Remark_RewardPoint;
                    $rewardstatus = 3;
                }
            }
            

            if ($model->where("id", $id)->set($data)->update()) {
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
        $DepartmentModelObj1 = new DepartmentnameModel();
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

        // $DepartmentModelObj = new DepartmentModel();
        $Departmentrow = $DepartmentModelObj
            ->where("compeny_id", $companyid)
            ->where("id", $depart)
            ->first();






        // print_r($Departmentrow);
            // print_r($Departmentrow1["name"]);
            // print_r($Departmentrow1["bill_type_id"]);
        $billrow = $BillRegisterModelObj
            ->where("compeny_id", $companyid)
            ->where("id", $billidvalue)
            ->first();


        $Depart_name = $Departmentrow["name"];
        $Depart_compeny_id =$Departmentrow["compeny_id"];

        $Departmentrow1 = $DepartmentModelObj1
            ->where("Company_Id", $Depart_compeny_id)
            ->where("Department_Name", $Depart_name)
            ->first();

            // print_r($Departmentrow1);
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
                        $Id2 = $Departmentrow1["Id"];
                        $builderrecommended = $this->db->table("asitek_employee as employee");
                        $builderrecommended->select('employee.*');
                        $builderrecommended->join('asitek_emp_page_access as pageac', 'pageac.Emp_Id = employee.id', 'left');
                        $builderrecommended->where('employee.compeny_id', $companyid);
                        $builderrecommended->where('employee.department', $Id2);
                        $builderrecommended->where('pageac.Page_Id', 5);
                        
                        $rowEMP = $builderrecommended->get()->getResult();

                         // print_r($rowEMP);
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
        $result = $session->get();
        $Mapping_By_MasterId = $result["emp_id"];
        $email = \Config\Services::email();
        $db2 = \Config\Database::connect('second'); // second DB
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
                "SELECT id, uid, Department_Id, Department_Emp_Id, Vendor_Id, Add_By, Bill_No, Gate_Entry_No, Unit_Id, Bill_DateTime, Gate_Entry_Date, Bill_Amount, Remark, Bill_Pic from asitek_bill_register WHERE compeny_id='$companyid' AND uid = '$uid' AND (Bill_Acceptation_Status = '2' OR Bill_Acceptation_Status = '4')"
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
                    "Mapping_By_MasterId" => $Mapping_By_MasterId,
                    "Unit_Id" => $unitid,
                    "Department_Id" => $depart,
                    "Department_Emp_Id" => $employeeid,
                    "Bill_Acceptation_Status" => 4,
                    "Bill_Type" => $selectbill,
                    "TargetMapping_Time_Hours" => $targetmappingtimehours,
                    "Mapping_Delay_On_Time" => $mappingdelaytime,
                    "Mapping_Remark" => $mappingremark,
                ];

                if ($model->where("id", $id)->set($data)->update()) {
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
                    }
                    else
                    {
                        $currentDay = date('d');
                        if ($currentDay <= 10) {   
                            $reward_point = $Add_RewardPoint + $Remark_RewardPoint;
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
                        }
                        else{
                            $reward_point = 0;
                        }
                    }

                    

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

                    if($selectbill==12||$selectbill==35){
                        $todatdatetime = date('Y-m-d H:i:s');
                        $yestwocompny = $this->db->table("asitek_bill_sample_done")->where("Bill_Management_Company_Id", $companyid)->get()->getRow(); // gets the first row as an object

                        if(!empty($yestwocompny)){
                            $samplingdata = [
                                "uid" => $uid,
                                "compeny_id" => $companyid,
                                "Add_By" => $billid[0]->Add_By,
                                "Bill_No" => $billid[0]->Bill_No,
                                "Gate_Entry_No" => $billid[0]->Gate_Entry_No,
                                "Unit" => $billid[0]->Unit_Id,
                                "Party_Name" => $billid[0]->Vendor_Id,
                                "Bill_Date" => $billid[0]->Bill_DateTime,
                                "Gate_Entry_Date" => $billid[0]->Gate_Entry_Date,
                                "Bill_Amount" => $billid[0]->Bill_Amount,
                                "Remark" => $billid[0]->Remark,
                                "Bill_Pic" => $billid[0]->Bill_Pic,
                                "DateTime" => $billid[0]->id,
                                "Department_Id" => $billid[0]->Department_Id,
                            ];
                            $builder = $db2->table('asitek_bill_register');
                            $builder->insert($samplingdata);
                        }
                    }

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
        $result = $session->get();
        $MasterId_By_emp_id = $result["emp_id"];
        $model = new BillRegisterModel();
        $uid = $this->request->getVar("billid");
        $companyid = $this->request->getVar("companyid");
        $billid = $this->db
            ->query(
                "SELECT id from asitek_bill_register WHERE compeny_id='$companyid' AND uid = '$uid' AND Bill_Acceptation_Status=4 AND Clear_Bill_Form_Status=1"
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
                "MasterId_By_Clear_Bill_Form" => $MasterId_By_emp_id,
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
                }
                else
                {
                    $currentDay = date('d');
                    if ($currentDay <= 10) {   
                        $reward_point = $Add_RewardPoint + $Remark_RewardPoint;
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
                    }
                    else{
                        $reward_point = 0;
                    }
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
                "message" => "Bill is not assigned or Bill already accepted!",
            ];
            return $this->response->setJSON($data);
        }
    }

    public function submitBillForMasterVerification()
    {
        $session = \Config\Services::session();
        $result = $session->get();
        $uploaded_by = $result["emp_id"];
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

        if($stage_id==3){
            $billid = $this->db->query("SELECT id from asitek_bill_register WHERE compeny_id='$companyid' AND uid = '$uid' AND Clear_Bill_Form_Status=2")->getResult();
        }
        elseif($stage_id==4){
            $billid = $this->db->query("SELECT id from asitek_bill_register WHERE compeny_id='$companyid' AND uid = '$uid' AND Clear_Bill_Form_Status=4 AND ERP_Status=2")->getResult();
        }
        elseif($stage_id==5){
            $billid = $this->db->query("SELECT id from asitek_bill_register WHERE compeny_id='$companyid' AND uid = '$uid' AND Clear_Bill_Form_Status=4 AND ERP_Status=4 AND Recived_Status=2")->getResult();
        }

        if (isset($billid) && !empty($billid)) {
            $billidvalue = $billid[0]->id;
            if (!empty($E_Image)) {
                // Handle file upload
                if ($E_Image->isValid() && !$E_Image->hasMoved()) {
                    $newName = $E_Image->getRandomName();
                    $E_Image->move("public/vendors/PicUploadMasterAction", $newName);
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

            $rowMasterAction1 = $MasterActionmadelObj->where("stage_id", $stage_id)->where("id", $masteractionid)->first();
            $data2 = [
                "uploaded_by" => $uploaded_by,
                "compeny_id" => $companyid,
                "bill_id" => $billidvalue,
                "master_action_id" => $masteractionid,
                "image_upload" => $newName,
                "remark" => $remark,
            ];

            $MasterActionUploadrow333= $MasterActionUploadModelObj->where('bill_id',$billidvalue)->where('master_action_id',$masteractionid)->first();
            if(isset($MasterActionUploadrow333) && $MasterActionUploadrow333!='')
            {
                $data = [
                    "status" => "success",
                    "message" => "Either bill is already uploaded Matser",
                ];
                return $this->response->setJSON($data);
            }
            else{
                $insert = $MasterActionUploadModelObj->insert($data2);
                if ($insert) {
                    if ($stage_id == 3) {
                        $model->where("id", $billidvalue)->set("ClearFormBill_Master_Action", $rowMasterAction1["no_of_action"])->update();
                        $MasterActionmadelObj = new MasterActionModel();
                        $rowMasterAction1 = $MasterActionmadelObj->where("compeny_id", $companyid)->where("stage_id", $stage_id)->orderBy("id", "desc")->first();
                        if (isset($rowMasterAction1) && $rowMasterAction1 != "") {
                            if ($rowMasterAction1["id"] == $masteractionid) {
                                $Add_RewardPoint = 10;
                                $Remark = $this->request->getVar("remark");
                                if ($Remark != "") {
                                    $Remark_RewardPoint = 10;
                                } else {
                                    $Remark_RewardPoint = 10;
                                }
                                $E_Image = $this->request->getFile("E_Image");
                                if ($E_Image != "") {
                                    $FileAttch_RewardPoint = 10;
                                } else {
                                    $FileAttch_RewardPoint = 10;
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
                                    $reward_point = $Add_RewardPoint + $Remark_RewardPoint + $FileAttch_RewardPoint;
                                }
                                else
                                {
                                    $reward_point = $Add_RewardPoint + $Remark_RewardPoint + $FileAttch_RewardPoint;
                                }

                                $reward_point_type = "Master Action Bill Verify";
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
                            } 
                            else {}
                        }

                        $data = [
                            "status" => "success",
                            "message" => "Master Action Added",
                        ];
                        return $this->response->setJSON($data);
                    } 
                    elseif ($stage_id == 4) {
                        $model->where("id", $billidvalue)->set("ERP_Master_Action", $rowMasterAction1["no_of_action"])->update();
                        $MasterActionmadelObj = new MasterActionModel();
                        $rowMasterAction1 = $MasterActionmadelObj->where("compeny_id", $companyid)->where("stage_id", $stage_id)->orderBy("id", "desc")->first();
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
                                    $reward_point = $Add_RewardPoint + $Remark_RewardPoint + $FileAttch_RewardPoint;
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
                                    $RewardPoint = $RewardPointobj->insert($dataRewardPoint);
                                }
                                else
                                {
                                    $currentDay = date('d');
                                    if ($currentDay <= 10) {   
                                        $reward_point =$Add_RewardPoint + $Remark_RewardPoint + $FileAttch_RewardPoint;
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
                                        $RewardPoint = $RewardPointobj->insert($dataRewardPoint);
                                    }
                                    else{
                                        $reward_point = 0;
                                    }
                                }
                                
                            } 
                            else {}
                        }

                        $data = [
                            "status" => "success",
                            "message" => "Master Action Added",
                        ];

                        return $this->response->setJSON($data);
                    } 
                    elseif ($stage_id == 5) {
                        $model->where("id", $billidvalue)->set("Recived_Master_Action", $rowMasterAction1["no_of_action"])->update();
                        $MasterActionmadelObj = new MasterActionModel();
                        $rowMasterAction1 = $MasterActionmadelObj->where("compeny_id", $companyid)->where("stage_id", $stage_id)->orderBy("id", "desc")->first();
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
                                    $reward_point = $Add_RewardPoint + $Remark_RewardPoint + $FileAttch_RewardPoint;
                                    $reward_point_type = "Master Action Bill Received A/c";
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
                                }
                                else
                                {
                                    $currentDay = date('d');
                                    if ($currentDay <= 10) {   
                                        $reward_point = $Add_RewardPoint + $Remark_RewardPoint + $FileAttch_RewardPoint;
                                        $reward_point_type = "Master Action Bill Received A/c";
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
                                    }
                                    else{
                                        $reward_point = 0;
                                    }
                                }

                              
                                
                            } 
                            else {}
                        }

                        $data = [
                            "status" => "success",
                            "message" => "Master Action Added",
                        ];
                        return $this->response->setJSON($data);
                    }
                }
            } 
        }
        else {
            $data = [
                "status" => "success",
                "message" =>"Either bill is not accepted or it is sent to bill entry",
            ];
            return $this->response->setJSON($data);
        }
    }

    public function sendBilltoentry()
    {
        $session = \Config\Services::session();
        $email = \Config\Services::email();
        $result = $session->get();
        $Mapping_ERP_EmpId_By_MasterId = $result["emp_id"];
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
        $targetclearbillformtimrhours = $request->getPost("targetclearbillformtimrhours");
        $actualdatetime = $request->getPost("actualdatetime");
        $clearbillformdelayontime = $request->getPost("clearbillformdelayontime");
        $clearbillremark = $request->getPost("clearbillremark");
        $E_Image = $request->getFile("E_Image");
        $billid = $this->db->query("SELECT id, Vendor_Id from asitek_bill_register WHERE compeny_id='$companyid' AND uid = '$uid' AND Clear_Bill_Form_Status = '2' AND ClearFormBill_Master_Action!=''")->getResult();
        if (isset($billid) && !empty($billid)) {
            $billidvalue = $billid[0]->id;
            $vendorvalue = $billid[0]->Vendor_Id;

            $vdr = $vendormodel->where("id", $companyid)->first();
            $cpn = $companymodel->where("id", $vendorvalue)->first();

            if (!empty($E_Image)) {
                // Handle file upload
                if ($E_Image->isValid() && !$E_Image->hasMoved()) {
                    $newName = $E_Image->getRandomName();
                    $E_Image->move("public/vendors/PicUpload", $newName);
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
                "Mapping_ERP_EmpId_By_MasterId" => $Mapping_ERP_EmpId_By_MasterId,
                "Mapping_ERP_EmpId" => $mappingerpid,
                "Clear_Bill_Form_Status" => 4,
                "TargetClearBillForm_Time_Hours" => $targetclearbillformtimrhours,
                "ClearBillForm_Delay_On_Time" => $clearbillformdelayontime,
                "Clear_Bill_Form_AnyImage" => $newName,
                "ClearBillForm_Remark" => $clearbillremark,
            ];

            if (
                $model->where("id", $billidvalue)->set($data)->update()) {
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
                    $reward_point = $Add_RewardPoint + $Remark_RewardPoint + $FileAttch_RewardPoint;
                }
                else
                {
                    $reward_point = $Add_RewardPoint + $Remark_RewardPoint + $FileAttch_RewardPoint;
                }
                            

               
                $reward_point_type ="Send this bill for entry process (forward)";
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

                $wpmsg ="Dear " . $vdr["Name"] .", We're delighted to inform you that your bill has been verified by the relevant department and has been forwarded to our ERP system for entry.. Thank you for your prompt submission  and cooperation! Best regards, " . $cpn["name"];
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
        $result = $session->get();
        $ERP_Status_Change_By_MasterId = $result["emp_id"];
        $model = new BillRegisterModel();
        $uid = $this->request->getVar("billid");
        $companyid = $this->request->getVar("companyid");
        $billid = $this->db
            ->query(
                "SELECT id from asitek_bill_register WHERE compeny_id='$companyid' AND uid = '$uid' AND Clear_Bill_Form_Status = '4' AND ERP_Status = '1'"
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
                "ERP_Status_Change_By_MasterId" => $ERP_Status_Change_By_MasterId,
                "ERP_Status" => $erpstatus,
                "ERP_Comment" => $erpcomment,
                "ERP_DateTime" => $erpdateTime,
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
                    $reward_point = $Add_RewardPoint + $Remark_RewardPoint;
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
                "message" => "Bill is assigned for Entry Or Bill Already Accepted",
            ];

            return $this->response->setJSON($data);
        }
    }

    public function sendToBillReceiving()
    {
        $session = \Config\Services::session();
        $email = \Config\Services::email();
        $result = $session->get();
        $Mapping_Acount_By_MasterId = $result["emp_id"];
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
        $billid = $this->db->query("SELECT id, Vendor_Id from asitek_bill_register WHERE compeny_id='$companyid' AND uid = '$uid' AND ERP_Status = '2' and ERP_Master_Action!=''")->getResult();
        if (isset($billid) && !empty($billid)) {
            $billidvalue = $billid[0]->id;
            $vendorvalue = $billid[0]->Vendor_Id;

            $vdr = $vendormodel->where("id", $vendorvalue)->first();
            $cpn = $companymodel->where("id", $companyid)->first();

            if (!empty($E_Image)) {
                // Handle file upload
                if ($E_Image->isValid() && !$E_Image->hasMoved()) {
                    $newName = $E_Image->getRandomName();
                    $E_Image->move("public/vendors/PicUpload", $newName);
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
                "Mapping_Account_By_MasterId" => $Mapping_Acount_By_MasterId,
                "ERP_Status" => 4,
                "Target_ERP_Time_Hours" => $targeterptimehours,
                "ERP_Delay_On_Time" => $erpdelayontime,
                "ERP_AnyImage" => $newName,
                "ERP_Remark" => $erpremark,
            ];

            if ($model->where("id", $billidvalue)->set($data)->update()) {
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
                    $reward_point = $Add_RewardPoint +$Remark_RewardPoint + $FileAttch_RewardPoint;
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
                $wpmsg = "Dear " . $vdr["Name"] ." We would like to inform you that your recent bill has been successfully processed through our ERP system. Thank you for your prompt submission! Best regards, " . $cpn["name"];
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
                "message" => "Either bill is not accepted or it is sent to bill receiving",
            ];

            return $this->response->setJSON($data);
        }
    }

    public function billreceivedaccept()
    {
        $session = \Config\Services::session();
        $result = $session->get();
        $Recived_Status_Change_By_MasterId = $result["emp_id"];
        $model = new BillRegisterModel();
        $uid = $this->request->getVar("billid");
        $companyid = $this->request->getVar("companyid");
        $billid = $this->db
            ->query(
                "SELECT id from asitek_bill_register WHERE compeny_id='$companyid' AND uid = '$uid' AND ERP_Status = '4' AND Recived_Status = '1'"
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
                "Recived_Status_Change_By_MasterId" => $Recived_Status_Change_By_MasterId,
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
                    $reward_point = $Add_RewardPoint + $Remark_RewardPoint;
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
                "message" => "Bill is not assigned for receiving Or Bill already accepted!",
            ];
            return $this->response->setJSON($data);
        }
    }
    
    
    
    // public function completefromBillReceiving()
    // {
    //     $session = \Config\Services::session();
    //     $email = \Config\Services::email();
    //     $result = $session->get();
    //     $Recived_Completed_By_MasterId = $result["emp_id"];
    //     $model = new BillRegisterModel();
    //     $vendormodel = new PartyUserModel();
    //     $companymodel = new CompenyModel();
    //     $MasterActionmadelObj = new MasterActionModel();
    //     $MasterActionUploadModelObj = new MasterActionUploadModel();
    //     $request = $this->request;
    //     // Validate incoming data if needed
    //     // Retrieve form data
    //     $companyid = $request->getPost("companyid");
    //     $uid = $request->getPost("billid");
    //     $Recived_TragetTime_Hours = $request->getPost("Recived_TragetTime_Hours");
    //     $completeactualdattime = $request->getPost("completeactualdattime");
    //     $Recived_Delay_On_Time = $request->getPost("Recived_Delay_On_Time");
    //     $remark = $request->getPost("remark");
    //     $E_Image = $request->getFile("E_Image");
    //     $billid = $this->db->query("SELECT id, Vendor_Id from asitek_bill_register WHERE compeny_id='$companyid' AND uid = '$uid' AND Recived_Status = '2' AND Recived_Master_Action!=''")->getResult();
    //     if (isset($billid) && !empty($billid)) {
    //         $billidvalue = $billid[0]->id;
    //         $vendorvalue = $billid[0]->Vendor_Id;

    //         $vdr = $vendormodel->where("id", $vendorvalue)->first();
    //         $cpn = $companymodel->where("id", $companyid)->first();

    //         if (!empty($E_Image)) {
    //             // Handle file upload
    //             if ($E_Image->isValid() && !$E_Image->hasMoved()) {
    //                 $newName = $E_Image->getRandomName();
    //                 $E_Image->move("public/vendors/PicUploadMasterAction", $newName);
    //             } else {
    //                 $data = [
    //                     "status" => "error",
    //                     "message" => "Image is not uploaded",
    //                 ];

    //                 return $this->response->setJSON($data);
    //             }
    //         } else {
    //             $newName = "";
    //         }

    //         $data = [
    //             "Recived_Status" => 4,
    //             "Recived_TragetTime_Hours" => $Recived_TragetTime_Hours,
    //             "Recived_Delay_On_Time" => $Recived_Delay_On_Time,
    //             "Recived_AnyImage" => $newName,
    //             "Recived_Remark" => $remark,
    //             "Recived_Completed_By_MasterId" => $Recived_Completed_By_MasterId,
    //         ];

    //         if ($model->where("id", $billidvalue)->set($data)->update()) {
    //             // ****Start RewardPoint**
    //             $Add_RewardPoint = 10;
    //             if ($remark != "") {
    //                 $Remark_RewardPoint = 10;
    //             } else {
    //                 $Remark_RewardPoint = 0;
    //             }
    //             if ($newName != "") {
    //                 $FileAttch_RewardPoint = 10;
    //             } else {
    //                 $FileAttch_RewardPoint = 0;
    //             }

    //             $BillRegObjNew = new BillRegisterModel();
    //             // $id3 = $this->request->getVar("billid");
    //             $BillRegrow= $BillRegObjNew->where('id', $billidvalue)->first();
    //             $Bill_DateTime2=$BillRegrow['Bill_DateTime'];
    //             $currentmonth=date("Y-m-d H:i:s");
    //             $month = date('m', strtotime($currentmonth));
    //             $month2 = date('m', strtotime($Bill_DateTime2));
    //             if($month<=$month2)
    //             {
    //                 $reward_point = $Add_RewardPoint +$Remark_RewardPoint + $FileAttch_RewardPoint;
    //             }
    //             else
    //             {
    //                 $reward_point = $Add_RewardPoint +$Remark_RewardPoint + $FileAttch_RewardPoint;
    //             }
    //             $reward_point_type ="Bill Received A/c Completed";
    //             $session_compeny_id = $session->get("compeny_id");
    //             $session_emp_id = $session->get("emp_id");
    //             $DateTimenew = date("Y-m-d H:i:s");
    //             $dataRewardPoint = [
    //                 "bill_id" => $billidvalue,
    //                 "compeny_id" => $session_compeny_id,
    //                 "emp_id" => $session_emp_id,
    //                 "reward_point" => $reward_point,
    //                 "reward_point_type" => $reward_point_type,
    //                 "rec_time_stamp" => $DateTimenew,
    //             ];
    //             $RewardPointobj = new RewardPointModel();
    //             $RewardPoint = $RewardPointobj->insert($dataRewardPoint);

    //             if($month<=$month2)
    //             {
    //                 $RewardPointobj->where("bill_id", $billidvalue)->set("status", 2)->update(); 
    //             }
    //             else
    //             {                         
    //                 $currentDay = date('d');
    //                 if ($currentDay <= 10) {
    //                     $RewardPointobj->where("bill_id", $billidvalue)->set("status", 2)->update();
    //                 }
    //                 else{
    //                     $RewardPointobj->where("bill_id", $billidvalue)->set("status", 3)->update();
    //                 }
    //             }

    //             // ****End RewardPoint**
    //             $wpmsg ="Dear " . $vdr["Name"] . " We wanted to inform you that your bill has been successfully received by our accounting department. Thank you for your prompt submission! Best regards, " . $cpn["name"];
    //             // $url = "https://chatway.in/api/send-msg?username=ashrishaWCH&number=+91".$vdr['Mobile_No']."&message=".$wpmsg."&token=Y21iQk9IeExwbjluMGE2SUxhM2taQT09";
    //             // $url = preg_replace("/ /", "%20", $url);
    //             // $response = file_get_contents($url);

    //             // $email->setFrom("singhshaan085@gmail.com", "Bill Management");
    //             // $email->setTo($vdr["Email_Id"]);
    //             // $email->setSubject("Bill Add in Company | Bill Management");
    //             // $email->setmailType("html");
    //             // $email->setMessage($wpmsg); //your message here
    //             // $email->send();

    //             $data = [
    //                 "status" => "success",
    //                 "message" => "Bill Send to Receiving",
    //             ];

    //             return $this->response->setJSON($data);
    //         }
    //     } else {
    //         $data = [
    //             "status" => "success",
    //             "message" =>"Bill already completed",
    //         ];

    //         return $this->response->setJSON($data);
    //     }
    // }
    

    
    public function completefromBillReceiving()
{
    $session = \Config\Services::session();
    $email = \Config\Services::email();
    $result = $session->get();
    $Recived_Completed_By_MasterId = $result["emp_id"];
    $model = new BillRegisterModel();
    $vendormodel = new PartyUserModel();
    $companymodel = new CompenyModel();
    $RewardPointobj = new RewardPointModel();
    $request = $this->request;
    
    $companyid = $request->getPost("companyid");
    $uid = $request->getPost("billid");
    $Recived_TragetTime_Hours = $request->getPost("Recived_TragetTime_Hours");
    $Recived_Delay_On_Time = $request->getPost("Recived_Delay_On_Time");
    $remark = $request->getPost("remark");
    $E_Image = $request->getFile("E_Image");
    
    $bill = $this->db->query("SELECT id, Vendor_Id, Bill_DateTime FROM asitek_bill_register WHERE compeny_id='$companyid' AND uid='$uid' AND Recived_Status='2' AND Recived_Master_Action!=''")->getRow();
    
    if (!empty($bill)) {
        $billidvalue = $bill->id;
        $vendorvalue = $bill->Vendor_Id;
        $Bill_DateTime2 = $bill->Bill_DateTime;
        $Received_DateTime = date("Y-m-d H:i:s");

        $billDate = new \DateTime($Bill_DateTime2);
        $receivedDate = new \DateTime($Received_DateTime);
        $cutoffDate = clone $billDate;
        $cutoffDate->modify('first day of next month')->modify('+10 days');

        if (!empty($E_Image) && $E_Image->isValid() && !$E_Image->hasMoved()) {
            $imageName = $E_Image->getRandomName();
            $E_Image->move("public/vendors/PicUploadMasterAction", $imageName);
        } else {
            $imageName = "";
        }

        $data = [
            "Recived_Status" => 4,
            "Recived_TragetTime_Hours" => $Recived_TragetTime_Hours,
            "Recived_Delay_On_Time" => $Recived_Delay_On_Time,
            "Recived_AnyImage" => $imageName,
            "Recived_Remark" => $remark,
            "Recived_Completed_By_MasterId" => $Recived_Completed_By_MasterId,
        ];

        if ($model->update($billidvalue, $data)) {
            $Add_RewardPoint = 10;
            $Remark_RewardPoint = !empty($remark) ? 10 : 0;
            $FileAttch_RewardPoint = !empty($imageName) ? 10 : 0;
            $reward_point = $Add_RewardPoint + $Remark_RewardPoint + $FileAttch_RewardPoint;
            
            $reward_point_type = "Bill Received A/c Completed";
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
            
            $RewardPointobj->insert($dataRewardPoint);
            $status = ($receivedDate <= $cutoffDate) ? 2 : 3;
            $RewardPointobj->where("bill_id", $billidvalue)->set("status", $status)->update();
            
            $data = ["status" => "success", "message" => "Bill Send to Receiving"];
        } else {
            $data = ["status" => "error", "message" => "Failed to update bill status"];
        }
    } else {
        $data = ["status" => "error", "message" => "Bill already completed or not found"];
    }
    return $this->response->setJSON($data);
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
        $BillRegister = new BillRegisterModel();
        $page = $this->request->getVar('page') ?? 1;
        $perPage = 25;
        $startSerial = ($page - 1) * $perPage + 1;
        $Roll_id = $session->get("Roll_id");
        $emp_id = $session->get("emp_id");
        $compeny_id = $session->get("compeny_id");

          //    *************** Start Date Code 
        if ($session->has('Sesssion_start_Date')) {
            if(!empty($result['Sesssion_start_Date'])) {
                $start_Date = $result['Sesssion_start_Date']; 
            } else {
                $start_Date = '2019-05-06';    
            }
        }
        else {
            $start_Date = '2019-05-06';    
        }
        if ($session->has('Sesssion_end_Date')) {
            if(!empty($result['Sesssion_end_Date'])) {
                $end_Date = $result['Sesssion_end_Date']; 
            } else {
                $end_Date = '9019-05-06';    
            }
        }
        else {
            $end_Date = '9019-05-06';    
        }
        $date_format = '%Y-%m-%d';  
        //     ***************End  Date Code

        $data["dax"] = $this->db->query("SELECT asitek_bill_register.*, asitek_employee.emp_u_id, asitek_employee.first_name, asitek_employee.last_name, asitek_compeny.name as companyname FROM asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id JOIN asitek_compeny on asitek_bill_register.compeny_id = asitek_compeny.id WHERE asitek_bill_register.Vendor_Id='$emp_id' AND asitek_bill_register.Bill_Acceptation_Status='4' AND asitek_bill_register.Clear_Bill_Form_Status='4' AND asitek_bill_register.ERP_Status='4' AND asitek_bill_register.Recived_Status='4' AND STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$start_Date', '$date_format') AND STR_TO_DATE('$end_Date', '$date_format') ORDER BY asitek_bill_register.id DESC")->getResultArray();

        // $users = $BillRegister ->select("asitek_bill_register.*, asitek_employee.emp_u_id, asitek_employee.first_name, asitek_employee.last_name, .name as companyname")->join('asitek_employee', 'asitek_bill_register.Add_By = asitek_employee.id', 'left')->join('asitek_compeny', 'asitek_bill_register.compeny_id = asitek_compeny.id')->where('asitek_bill_register.Vendor_Id', $emp_id)->where('asitek_bill_register.Bill_Acceptation_Status', 4)->where('asitek_bill_register.Clear_Bill_Form_Status', 4)->where('asitek_bill_register.ERP_Status', 4)->where('asitek_bill_register.Recived_Status', 4)->orderBy('asitek_bill_register.id', 'desc')->paginate($perPage);

        // $data = [
        //     'users' => $users,
        //     'pager' => $BillRegister->pager,
        //     'startSerial' => $startSerial,
        //     'nextPage' => $page + 1,
        //     'previousPage' => ($page > 1) ? $page - 1 : null,
        // ];
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
          //    *************** Start Date Code 
        if ($session->has('Sesssion_start_Date')) {
            if(!empty($result['Sesssion_start_Date'])) {
                $start_Date = $result['Sesssion_start_Date']; 
            } else {
                $start_Date = '2019-05-06';    
            }
        }
        else {
            $start_Date = '2019-05-06';    
        }
        if ($session->has('Sesssion_end_Date')) {
            if(!empty($result['Sesssion_end_Date'])) {
                $end_Date = $result['Sesssion_end_Date']; 
            } else {
                $end_Date = '9019-05-06';    
            }
        }
        else {
            $end_Date = '9019-05-06';    
        }
        $date_format = '%Y-%m-%d';  
        //     ***************End  Date Code

        $data["dax"] = $this->db
            ->query(
                "SELECT asitek_bill_register.*, asitek_employee.emp_u_id, asitek_employee.first_name, asitek_employee.last_name, asitek_compeny.name as companyname FROM asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id JOIN asitek_compeny on asitek_bill_register.compeny_id = asitek_compeny.id WHERE asitek_bill_register.Vendor_Id='$emp_id' AND (asitek_bill_register.Bill_Acceptation_Status='3' OR asitek_bill_register.Clear_Bill_Form_Status='3' AND asitek_bill_register.ERP_Status='3') AND STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$start_Date', '$date_format') AND STR_TO_DATE('$end_Date', '$date_format') ORDER BY asitek_bill_register.id DESC"
            )
            ->getResultArray();
        //print_r($data);
        return view("all-vendor-rejected-list", $data);
    }




    //**************Mapping Bill Start***************
    public function view_bill_assignment_list()
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
            if ($Satus == "All") {
                $data["dax"] = $this->db->query("select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id where asitek_bill_register.compeny_id='$compeny_id' and asitek_bill_register.Unit_Id='$Unit_Id'  ORDER BY asitek_bill_register.id desc ")->getResultArray();
            } else {
                $data["dax"] = $this->db->query("select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id where asitek_bill_register.compeny_id='$compeny_id' and asitek_bill_register.Unit_Id='$Unit_Id' and asitek_bill_register.Bill_Acceptation_Status='$Satus' ORDER BY asitek_bill_register.id desc")->getResultArray();
            }
        }
        
        if(empty($Unit_Id) && !empty($Vendor_Id) && empty($assignedto) && !empty($Satus)){
            if ($Satus == "All") {
                $data["dax"] = $this->db->query("select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id where asitek_bill_register.compeny_id='$compeny_id' and asitek_bill_register.Vendor_Id='$Vendor_Id'  ORDER BY asitek_bill_register.id desc ")->getResultArray();
            } else {
                $data["dax"] = $this->db->query("select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id where asitek_bill_register.compeny_id='$compeny_id' and asitek_bill_register.Vendor_Id='$Vendor_Id' and asitek_bill_register.Bill_Acceptation_Status='$Satus'  ORDER BY asitek_bill_register.id desc")->getResultArray();
            }
        }
        
        if(empty($Unit_Id) && empty($Vendor_Id) && !empty($assignedto) && !empty($Satus)){
           
            if ($Satus == "All") {
                $data["dax"] = $this->db->query("select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id where asitek_bill_register.compeny_id='$compeny_id' and asitek_bill_register.Department_Emp_Id='$assignedto'  ORDER BY asitek_bill_register.id desc ")->getResultArray();
            } else {
                $data["dax"] = $this->db->query("select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id where asitek_bill_register.compeny_id='$compeny_id' and asitek_bill_register.Bill_Acceptation_Status='$Satus'  ORDER BY asitek_bill_register.id desc")->getResultArray();
            }
            
        }
        
        if(empty($Unit_Id) && empty($Vendor_Id) && empty($assignedto) && !empty($Satus)){
            
            if ($Satus == "All") {
                $data["dax"] = $this->db->query("select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id  where asitek_bill_register.compeny_id='$compeny_id'   ORDER BY asitek_bill_register.id desc ")->getResultArray();
            } else {
                $data["dax"] = $this->db->query("select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id where asitek_bill_register.compeny_id='$compeny_id' and asitek_bill_register.Bill_Acceptation_Status='$Satus'  ORDER BY asitek_bill_register.id desc")->getResultArray();
            }
        }
        
        if(empty($Unit_Id) && empty($Vendor_Id) && empty($assignedto) && empty($Satus)){
            $data["dax"] = $this->db->query("select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id  where asitek_bill_register.compeny_id='$compeny_id' ORDER BY asitek_bill_register.id desc ")->getResultArray();
            
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
        $builderrecommended->orderBy('asitek_party_user.Name', 'ASC');
        $data_recommended = $builderrecommended->get()->getResult();
        $data['dax14'] =$data_recommended;
        $model15 = new UnitModel();
        $data["dax15"] = $model15->where("compeny_id", $compeny_id)->findAll();
        $model16 = new DepartmentModel();
        $data["dax16"] = $model16->where("compeny_id", $compeny_id)->findAll();
        $model17 = new BillTypeModel();
        $data["dax17"] = $model17->where("compeny_id", $compeny_id)->findAll();
        return view("view-bill-assignment-list", $data);
    }


    public function view_bill_verify_list()
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
        $builderrecommended->orderBy('asitek_party_user.Name', 'ASC');
        $data_recommended = $builderrecommended->get()->getResult();
        $data['dax14'] =$data_recommended;
        $model15 = new UnitModel();
        $data["dax15"] = $model15->where("compeny_id", $compeny_id)->findAll();
        $model16 = new DepartmentModel();
        $data["dax16"] = $model16->where("compeny_id", $compeny_id)->findAll();
        return view("view-bill-verify-list", $data);
    }


    public function view_bill_entry_list()
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
        $builderrecommended->orderBy('asitek_party_user.Name', 'ASC');
        $data_recommended = $builderrecommended->get()->getResult();
        $data['dax14'] =$data_recommended;
        $model15 = new UnitModel();
        $data["dax15"] = $model15->where("compeny_id", $compeny_id)->findAll();
        $model16 = new DepartmentModel();
        $data["dax16"] = $model16->where("compeny_id", $compeny_id)->findAll();
        return view("view-bill-entry-list", $data);
    }

    public function view_bill_received_list()
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
        $builderrecommended->orderBy('asitek_party_user.Name', 'ASC');
        $data_recommended = $builderrecommended->get()->getResult();
        $data['dax14'] =$data_recommended;
        $model15 = new UnitModel();
        $data["dax15"] = $model15->where("compeny_id", $compeny_id)->findAll();
        $model16 = new DepartmentModel();
        $data["dax16"] = $model16->where("compeny_id", $compeny_id)->findAll();
        return view("view-bill-received-list", $data);
    }

    //************** complete_bill_report Start **************

    public function complete_bill_report()
    {
        $session = \Config\Services::session();
        $result = $session->get();
        $BillRegister = new BillRegisterModel();
        $page = $this->request->getVar('page') ?? 1;
        $perPage = 100;
        $startSerial = ($page - 1) * $perPage + 1;
        $Roll_id = $session->get("Roll_id");
        $emp_id = $session->get("emp_id");
        $compeny_id = $session->get("compeny_id");
        if (isset($_GET["Vendor_Id"])) {
            $Vendor_Id = $_GET["Vendor_Id"];
        } else {
            $Vendor_Id = "";
        }
        if (isset($_GET["start_Date"]) && isset($_GET["end_Date"])) {
            $start_date=$_GET["start_Date"];
            $end_date=$_GET["end_Date"];
            $date_format = '%Y-%m-%d'; 
            if(!empty($Vendor_Id)){
                $users = $BillRegister ->select("asitek_bill_register.*, asitek_employee.emp_u_id, asitek_employee.first_name, asitek_employee.last_name")->join('asitek_employee', 'asitek_bill_register.Add_By = asitek_employee.id', 'left')->where('asitek_bill_register.compeny_id', $compeny_id)->where('asitek_bill_register.Vendor_Id', $Vendor_Id)->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$start_date', '$date_format') AND STR_TO_DATE('$end_date', '$date_format')")->orderBy('asitek_bill_register.Bill_DateTime', 'desc')->paginate($perPage);
            }
            else
            {
                $users = $BillRegister ->select("asitek_bill_register.*, asitek_employee.emp_u_id, asitek_employee.first_name, asitek_employee.last_name")->join('asitek_employee', 'asitek_bill_register.Add_By = asitek_employee.id', 'left')->where('asitek_bill_register.compeny_id', $compeny_id)->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$start_date', '$date_format') AND STR_TO_DATE('$end_date', '$date_format')")->orderBy('asitek_bill_register.Bill_DateTime', 'desc')->paginate($perPage);
            }   
        } 

        else{
            $users = $BillRegister ->select("asitek_bill_register.*, asitek_employee.emp_u_id, asitek_employee.first_name, asitek_employee.last_name")->join('asitek_employee', 'asitek_bill_register.Add_By = asitek_employee.id', 'left')->where('asitek_bill_register.compeny_id', $compeny_id)->orderBy('asitek_bill_register.Bill_DateTime', 'desc')->paginate($perPage);
        }

        $builderrecommended = $this->db->table("asitek_company_vendor");
        $builderrecommended->select('asitek_company_vendor.Vendor_Id, asitek_party_user.id, asitek_party_user.GST_No, asitek_party_user.Name');
        $builderrecommended->join('asitek_party_user', 'asitek_party_user.id = asitek_company_vendor.Vendor_Id');
        $builderrecommended->where('asitek_company_vendor.Company_Id', $compeny_id);
        $builderrecommended->groupBy('asitek_company_vendor.Vendor_Id');
        $builderrecommended->orderBy('asitek_party_user.Name', 'ASC');
        $data_recommended = $builderrecommended->get()->getResult();
        $data = [
            'users' => $users,
            'pager' => $BillRegister->pager,
            'startSerial' => $startSerial,
            'nextPage' => $page + 1,
            'previousPage' => ($page > 1) ? $page - 1 : null,
            'dax14' => $data_recommended,  
        ];
        return view("complete_bill_report", $data);
    }

    //***********complete_bill_report  End ****************

    public function complete_bill_report_export()
    {
        $session = \Config\Services::session();
        $result = $session->get();
        $etm = $result["ddn"];
        $Roll_id = $session->get("Roll_id");
        $emp_id = $session->get("emp_id");
        $compeny_id = $session->get("compeny_id");
        if (isset($_GET["Vendor_Id"])) {
            $Vendor_Id = $_GET["Vendor_Id"];
        } else {
            $Vendor_Id = "";
        }
        $start_date = $this->request->getVar('start_Date');
        $end_date =  $this->request->getVar('end_Date'); 
        $Vendor_Id =  $this->request->getVar('Vendor_Id'); 
        $date_format = '%Y-%m-%d'; 
        if(!empty($Vendor_Id)){
            $data["dax"] = $this->db->query("select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id where asitek_bill_register.compeny_id='$compeny_id'   and asitek_bill_register.Vendor_Id='$Vendor_Id' AND STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$start_date', '$date_format') AND STR_TO_DATE('$end_date', '$date_format')  ORDER BY asitek_bill_register.Bill_DateTime desc ")->getResultArray();
        }
        else
        {
            $data["dax"] = $this->db->query("select asitek_bill_register.*,asitek_employee.emp_u_id,asitek_employee.first_name,asitek_employee.last_name from asitek_bill_register LEFT JOIN asitek_employee on asitek_bill_register.Add_By = asitek_employee.id  where asitek_bill_register.compeny_id='$compeny_id' AND STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$start_date', '$date_format') AND STR_TO_DATE('$end_date', '$date_format')  ORDER BY asitek_bill_register.Bill_DateTime desc ")->getResultArray(); 
        }   
        $builderrecommended = $this->db->table("asitek_company_vendor");
        $builderrecommended->select('asitek_company_vendor.Vendor_Id, asitek_party_user.id, asitek_party_user.GST_No, asitek_party_user.Name');
        $builderrecommended->join('asitek_party_user', 'asitek_party_user.id = asitek_company_vendor.Vendor_Id');
        $builderrecommended->where('asitek_company_vendor.Company_Id', $compeny_id);
        $builderrecommended->groupBy('asitek_company_vendor.Vendor_Id');
        $builderrecommended->orderBy('asitek_party_user.Name', 'ASC');
        $data_recommended = $builderrecommended->get()->getResult();
        $data['dax14'] =$data_recommended;
        return view("complete_bill_report_export", $data);
    }

    public function bill_pass_pending_plot_wise()
    {
        $session = \Config\Services::session();
        $result = $session->get();
        $BillRegisterModel = new BillRegisterModel();     
        $etm = $result["ddn"];
        $Roll_id = $session->get("Roll_id");
        $emp_id = $session->get("emp_id");
        $compeny_id = $session->get("compeny_id");
        if (isset($_GET["start_date"])) {
            $start_date = $_GET["start_date"];
        } 
        else {
            $start_date = "1790-04-17";
        }
        if (isset($_GET["end_date"])) {
            $end_date = $_GET["end_date"];
        } 
        else {
            $end_date = "1790-05-17";
        }  
        $date_format = '%Y-%m-%d'; 
        $EmployeeModel = new EmployeeModel();
        $data["daxEmp"] = $EmployeeModel->where("compeny_id", $compeny_id)->findAll();
        $data['dax'] = $this->db->query("select  * from asitek_unit where compeny_id='$compeny_id' ORDER BY id ASC ")->getResultArray();

         $data['dax2'] = $this->db->query("select  * from asitek_bill_type where compeny_id='$compeny_id' ORDER BY id ASC ")->getResultArray();
        //*Start Total Bill Count*****
        $data['Total_Bill_count_Pending'] = $this->db->table('asitek_bill_register')->where('compeny_id', $compeny_id)->where('Recived_Status', 1)->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$start_date', '$date_format') AND STR_TO_DATE('$end_date', '$date_format')")->countAllResults();
        $data['Total_Bill_count_Accepted'] = $this->db->table('asitek_bill_register')->where('compeny_id', $compeny_id)->where('Recived_Status', 2)->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$start_date', '$date_format') AND STR_TO_DATE('$end_date', '$date_format')")->countAllResults();
        $data['Total_Bill_count_Reject'] = $this->db->table('asitek_bill_register')->where('compeny_id', $compeny_id)->where('Recived_Status', 3)->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$start_date', '$date_format') AND STR_TO_DATE('$end_date', '$date_format')")->countAllResults();
        $data['Total_Bill_count_Done'] = $this->db->table('asitek_bill_register')->where('compeny_id', $compeny_id)->where('Recived_Status', 4)->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$start_date', '$date_format') AND STR_TO_DATE('$end_date', '$date_format')")->countAllResults();
        $query1 = $this->db->table('asitek_bill_register')->select('SUM(Bill_Amount) as Bill_Amount1')->where('compeny_id', $compeny_id)->where('Recived_Status', 1)->where("STR_TO_DATE(Bill_DateTime, '%Y-%m-%d') BETWEEN '$start_date' AND '$end_date'")->get();
        $row1 = $query1->getRow();
        $data['Total_Bill_Amount_Pending'] = $row1 ? $row1->Bill_Amount1 : 0;
        $query2 = $this->db->table('asitek_bill_register')->select('SUM(Bill_Amount) as Bill_Amount2')->where('compeny_id', $compeny_id)->where('Recived_Status', 2)->where("STR_TO_DATE(Bill_DateTime, '%Y-%m-%d') BETWEEN '$start_date' AND '$end_date'")->get();
        $row2 = $query2->getRow();
        $data['Total_Bill_Amount_Accepted'] = $row2 ? $row2->Bill_Amount2 : 0;
        $query3 = $this->db->table('asitek_bill_register')->select('SUM(Bill_Amount) as Bill_Amount3')->where('compeny_id', $compeny_id)->where('Recived_Status', 3)->where("STR_TO_DATE(Bill_DateTime, '%Y-%m-%d') BETWEEN '$start_date' AND '$end_date'")->get();
        $row3 = $query3->getRow();
        $data['Total_Bill_Amount_Reject'] = $row3 ? $row3->Bill_Amount3 : 0;
        $query4 = $this->db->table('asitek_bill_register')->select('SUM(Bill_Amount) as Bill_Amount4')->where('compeny_id', $compeny_id)->where('Recived_Status', 4)->where("STR_TO_DATE(Bill_DateTime, '%Y-%m-%d') BETWEEN '$start_date' AND '$end_date'")->get();
        $row4 = $query4->getRow();
        $data['Total_Bill_Amount_Done'] = $row4 ? $row4->Bill_Amount4 : 0;
        return view("bill_pass_pending_plot_wise",$data);
    }



    //Monthly Bill Pass Pending Plot wise deatils 
    public function generate_bill_shipped()
    {
        return view("generate_bill_shipped");  
    }

    public function generate_bill_shipped_save()

    {

         $session = \Config\Services::session();

        $result = $session->get();

        $BillShippedModelobg = new BillShippedModel();

        

        $compeny_id = $this->request->getVar('compeny_id');

       

        $updateVar = $this->request->getVar('update');

        if(isset($updateVar)){

            foreach($updateVar as $updateid){

                $MonthName= $this->request->getVar('MonthName_'.$updateid);

                $TotalAmount = $this->request->getVar('TotalAmount'.$updateid);

                $BillPassAmount = $this->request->getVar('BillPassAmount'.$updateid);

                $year = $this->request->getVar('year'.$updateid);

                $BalanceAmount = $TotalAmount-$BillPassAmount;

                $BalanceToShipAmount = $this->request->getVar('BalanceToShipAmount'.$updateid);



                $data = [     

                    'compeny_id'=>$compeny_id,           

                    'Year'=>$year,          

                    'Month'=>$MonthName,

                    'TotalAmount'=>$TotalAmount,

                    'BillPassAmount '=>$BillPassAmount,          

                    'BalanceAmount'=>$BalanceAmount,          

                    'BalanceToShipAmount'=>$BalanceToShipAmount

                ];



                 $BillShippedModelobg->where('compeny_id',$compeny_id)->where('Year',$year)->where('Month',$MonthName)->delete();



                $insert = $BillShippedModelobg->insert($data);

            }   

        }



          $session->setFlashdata("ok", 1);

        return redirect("generate_bill_shipped");  

    }

    public function test()
    {
        $session = \Config\Services::session();
        $result = $session->get();
         $model = new BillRegisterModel();   
      $RewardPointobj = new RewardPointModel();
      
       $date_format = '%Y-%m-%d'; 
       if(isset($_GET["start_Date"]))
          {
              $start_date=$_GET["start_Date"];
        $end_date=$_GET["end_Date"];
       
       $currentmonth = date('m', strtotime($start_date));
        //  $BillRegister = $model->where('Recived_Status',4)->where("MONTH(Bill_DateTime)=", $currentmonth)->findAll();
          $BillRegister = $model->where('Recived_Status',4)->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$start_date', '$date_format') AND STR_TO_DATE('$end_date', '$date_format')")->findAll();
         if(isset($BillRegister)){
             foreach ($BillRegister as $BillRegisterrow){
              $id=$BillRegisterrow['id'];
                $RewardPointobj->where("bill_id", $id)->where("paid_status", 1)->where("MONTH(rec_time_stamp)=", $currentmonth)->set("status", 2)->update();

               $RewardPointobj->where("bill_id", $id)->where("paid_status", 1)->where("MONTH(rec_time_stamp)!=", $currentmonth)->set("status", 3)->update();

              }
              echo "yes";
          }
      }
                return view("test");
    }


    public function bill_draft_delete()
    {
        $session = \Config\Services::session();

        $BillRegister = new BillRegisterModelDraft();
        $BillRegister->where("id", $this->request->getVar("id"))->delete();

        $session->setFlashdata("delete", 1);
        return redirect("add-bill-vendor");
    }


    public function edit_bill_vendor($id)
    {
        $session = \Config\Services::session();
        $emp_id = $session->get("emp_id");

        $BillRegister = new BillRegisterModelDraft();
        $bill = $BillRegister->where('id', $id)->first();

        if (!$bill) {
            return redirect()->to('/add-bill-vendor')->with('error', 'Bill not found.');
        }

        // Load company dropdown
        $companymodel = new CompenyModel();
        $builderrecommended = $this->db->table("asitek_vendor_company");
        $builderrecommended->select('asitek_vendor_company.Company_Id, asitek_compeny.id, asitek_compeny.name');
        $builderrecommended->join('asitek_compeny', 'asitek_compeny.id = asitek_vendor_company.Company_Id');
        $builderrecommended->where('asitek_vendor_company.Vendor_Id', $emp_id);
        $builderrecommended->groupBy('asitek_compeny.id');
        $data_recommended = $builderrecommended->get()->getResult();

        $unitModel = new UnitModel();
        $departmentModel = new DepartmentModel();

        $dax15 = $unitModel->where("compeny_id", $bill['compeny_id'])->findAll();
        $dax9 = $departmentModel->where("compeny_id", $bill['compeny_id'])->findAll();

        $data = [
            'bill' => $bill,
            'company' => $data_recommended,
            'dax15' => $dax15,
            'dax9' => $dax9,
            'emp_id' => $emp_id,
            'today' => date('Y-m-d'),
        ];

        return view('edit-bill-vendor', $data);
    }

    public function update_bill_vendor($id)
    {
        helper(['form', 'url']);
        $BillRegister = new BillRegisterModelDraft();
        $session = \Config\Services::session();
        $emp_id = $session->get("emp_id");

        $data = [
            'Bill_No' => $this->request->getPost('Bill_No'),
            'Bill_DateTime' => $this->request->getPost('Bill_DateTime'),
            'Bill_Amount' => $this->request->getPost('Bill_Amount'),
            'compeny_id' => $this->request->getPost('company_id'),
            'Unit_Id' => $this->request->getPost('Unit_Id'),
            'Gate_Entry_No' => $this->request->getPost('Gate_Entry_No'),
            'Gate_Entry_Date' => $this->request->getPost('Gate_Entry_Date'),
            'Remark' => $this->request->getPost('Remark'),
            'Department_Id' => $this->request->getPost('Department_Id'),
            'Vendor_Id' => $emp_id,
            'Add_By' => $emp_id,
        ];

        // Handle optional file update
        $file = $this->request->getFile('E_Image');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move('public/vendors/PicUploadDraft/', $newName);
            $data['Bill_Pic'] = $newName;
        }

        $BillRegister->update($id, $data);

        return redirect()->to('/add-bill-vendor')->with('success', 'Bill updated successfully.');
    }



    //DEBIT NOTE
    public function debitnote()
    {
        $session = \Config\Services::session();
        $result = $session->get();
        $BillRegister = new BillRegisterModel();
        $page = $this->request->getVar('page') ?? 1;
        $perPage = 50;
        $startSerial = ($page - 1) * $perPage + 1;
        $Roll_id = $session->get("Roll_id");
        $emp_id = $session->get("emp_id");
        $company_id = $session->get("compeny_id");
    
        $Unit_Id = $this->request->getVar('Unit_Id') ?? "";
        $Vendor_Id = $this->request->getVar('Vendor_Id') ?? "";
        $assignedto = $this->request->getVar('assignedto') ?? "";
        $SendBy = $this->request->getVar('SendBy') ?? "";
        $Status = $this->request->getVar('Satus') ?? "";
        $session->set(["Unit_Id" => $Unit_Id,"Vendor_Id" => $Vendor_Id,"assignedto" => $assignedto,"SendBy" => $SendBy,"Status" => $Status]);
        // Date handling
        $session_start_date = $session->get('Sesssion_start_Date') ?? '2019-05-06';
        $session_end_date = $session->get('Sesssion_end_Date') ?? '9019-05-06';
        $date_format = '%Y-%m-%d';
    
        // Setting default values for session dates if not set
        $session_start_date_new = !empty($result['Session_start_Date']) ? $result['Session_start_Date'] : $session_start_date;
        $session_end_date_new = !empty($result['Session_end_Date']) ? $result['Session_end_Date'] : $session_end_date;
    
        // Admin Roll
        if ($Roll_id == 1||$Roll_id == 2) {
            $users = $BillRegister->select("asitek_bill_register.*, asitek_employee.emp_u_id, asitek_employee.first_name, asitek_employee.last_name")
                ->join('asitek_employee', 'asitek_bill_register.Add_By = asitek_employee.id', 'left')
                ->where('asitek_bill_register.compeny_id', $company_id);
    
            if (!empty($Unit_Id)) {
                $users->where('asitek_bill_register.Unit_Id', $Unit_Id);
            }
    
            if (!empty($Vendor_Id)) {
                $users->where('asitek_bill_register.Vendor_Id', $Vendor_Id);
            }
    
            if (!empty($assignedto)) {
                $users->where('asitek_bill_register.Department_Emp_Id', $assignedto);
            }
    
            if (!empty($SendBy)) {
                $users->where('asitek_bill_register.Mapping_ERP_EmpId_By_MasterId', $SendBy);
            }
    
            if (!empty($Status) && $Status !== "All") {
                $users->where('asitek_bill_register.ERP_Status', $Status);
            }
    
            $users->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$session_start_date_new', '$date_format') AND STR_TO_DATE('$session_end_date_new', '$date_format')")
                ->orderBy('asitek_bill_register.id', 'desc');
    
            $users = $users->paginate($perPage);
        } else {
            // Non-admin case
            $users = $BillRegister->select("asitek_bill_register.*, asitek_employee.emp_u_id, asitek_employee.first_name, asitek_employee.last_name")
                ->join('asitek_employee', 'asitek_bill_register.Add_By = asitek_employee.id', 'left')
                ->where('asitek_bill_register.compeny_id', $company_id)->where('asitek_bill_register.Mapping_ERP_EmpId', $emp_id);
    
            if (!empty($Unit_Id)) {
                $users->where('asitek_bill_register.Unit_Id', $Unit_Id);
            }
    
            if (!empty($Vendor_Id)) {
                $users->where('asitek_bill_register.Vendor_Id', $Vendor_Id);
            }
    
            if (!empty($assignedto)) {
                $users->where('asitek_bill_register.Mapping_ERP_EmpId', $assignedto);
            }
    
            if (!empty($SendBy)) {
                $users->where('asitek_bill_register.Mapping_ERP_EmpId_By_MasterId', $SendBy);
            }
    
            if (!empty($Status) && $Status !== "All") {
                $users->where('asitek_bill_register.ERP_Status', $Status);
            }
    
            $users->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$session_start_date_new', '$date_format') AND STR_TO_DATE('$session_end_date_new', '$date_format')")
                ->orderBy('asitek_bill_register.id', 'desc');
    
            $users = $users->paginate($perPage);
        }
    
        $departmentModel = new DepartmentModel();
        $dax9 = $departmentModel->where("compeny_id", $company_id)->findAll();
    
        $employeeModel = new EmployeeModel();
        $builderrecommended = $this->db->table("asitek_company_vendor");
        $builderrecommended->select('asitek_company_vendor.Vendor_Id, asitek_party_user.id, asitek_party_user.GST_No, asitek_party_user.Name');
        $builderrecommended->join('asitek_party_user', 'asitek_party_user.id = asitek_company_vendor.Vendor_Id');
        $builderrecommended->where('asitek_company_vendor.Company_Id', $company_id);
        $builderrecommended->groupBy('asitek_company_vendor.Vendor_Id');
        $builderrecommended->orderBy('asitek_party_user.Name', 'ASC');
        $data_recommended = $builderrecommended->get()->getResult();
    
        $unitModel = new UnitModel();
        $dax15 = $unitModel->where("compeny_id", $company_id)->findAll();
    
        $departmentModel = new DepartmentModel();
        $dax16 = $departmentModel->where("compeny_id", $company_id)->findAll();
    
        $data = [
            'users' => $users,
            'pager' => $BillRegister->pager,
            'startSerial' => $startSerial,
            'nextPage' => $page + 1,
            'previousPage' => ($page > 1) ? $page - 1 : null,
            'dax9' => $dax9,
            'dax14' => $data_recommended,
            'dax15' => $dax15,
            'dax16' => $dax16,
        ];
    
        return view("debit-note", $data);
    }


    public function debitnotetomanager()
    {
        $session = \Config\Services::session();
        $email = \Config\Services::email();
        $result = $session->get();
        $model = new BillRegisterModel();
        $vendormodel = new PartyUserModel();
        $companymodel = new CompenyModel();
        $id = $this->request->getVar("id");
        $action = $this->request->getVar("action");
        $validation = \Config\Services::validation();
        $Mapping_Acount_By_MasterId = $result["emp_id"];
        $file = $this->request->getFile("E_Image");
        if ($file != "") {
            $validation->setRules([
                "E_Image" =>"uploaded[E_Image]|ext_in[E_Image,jpg,JPG,png,PNG,jpeg,JPEG,pdf]",
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
            "Send_Note_To" => $this->request->getVar("Mapping_Acount_EmpId"),
            "Send_Note_By" => $Mapping_Acount_By_MasterId,
            "Send_Note_Image" => $imageName,
            "Send_Note_Remark" => $this->request->getVar("ERP_Remark"),
            "Send_Note_Status" => 1,
        ];

        $billid = $this->db->query("SELECT uid from asitek_bill_register WHERE id='$id'")->getResult(); // Adjust the column name based on your database structure

        if (isset($billid) && !empty($data)) {

            $model->where('id', $id)->set($data)->update();
            return redirect("debit-note");
        }
        else{
            $session->setFlashdata("sendtoaccount", 2);
            return redirect("debit-note");
        }    
    }


    public function debitnotesendtomanager()
    {
        $session = \Config\Services::session();
        $email = \Config\Services::email();
        $result = $session->get();
        $Mapping_Acount_By_MasterId = $result["emp_id"];
        $model = new BillRegisterModel();
        $vendormodel = new PartyUserModel();
        $companymodel = new CompenyModel();
        $MasterActionmadelObj = new MasterActionModel();
        $MasterActionUploadModelObj = new MasterActionUploadModel();
        $request = $this->request;
        $companyid = $request->getPost("companyid");
        $uid = $request->getPost("billid");
        $mappingacountempid = $request->getPost("mappingacountempid");
        $erpremark = $request->getPost("erpremark");
        $E_Image = $request->getFile("E_Image");
        $billid = $this->db->query("SELECT id from asitek_bill_register WHERE compeny_id='$companyid' AND uid = '$uid'")->getResult();
        if (isset($billid) && !empty($billid)) {
            $billidvalue = $billid[0]->id;
            if (!empty($E_Image)) {
                // Handle file upload
                if ($E_Image->isValid() && !$E_Image->hasMoved()) {
                    $newName = $E_Image->getRandomName();
                    $E_Image->move("public/vendors/PicUpload", $newName);
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
                "Send_Note_To" => $mappingacountempid,
                "Send_Note_By" => $Mapping_Acount_By_MasterId,
                "Send_Note_Image" => $newName,
                "Send_Note_Remark" => $erpremark,
                "Send_Note_Status" => 1,
            ];

            if ($model->where("id", $billidvalue)->where("compeny_id", $companyid)->set($data)->update()) {
                
                $data = [
                    "status" => "success",
                    "message" => "Debit note added and send to account",
                ];

                return $this->response->setJSON($data);
            }
        } else {
            $data = [
                "status" => "success",
                "message" => "Either bill is not accepted or it is sent to bill receiving",
            ];

            return $this->response->setJSON($data);
        }
    }

    //DEBIT NOTE MANAGER
    public function debitnoteaccount()
    {
        $session = \Config\Services::session();
        $result = $session->get();
        $BillRegister = new BillRegisterModel();
        $page = $this->request->getVar('page') ?? 1;
        $perPage = 50;
        $startSerial = ($page - 1) * $perPage + 1;
        $Roll_id = $session->get("Roll_id");
        $emp_id = $session->get("emp_id");
        $company_id = $session->get("compeny_id");
    
        $Unit_Id = $this->request->getVar('Unit_Id') ?? "";
        $Vendor_Id = $this->request->getVar('Vendor_Id') ?? "";
        $assignedto = $this->request->getVar('assignedto') ?? "";
        $SendBy = $this->request->getVar('SendBy') ?? "";
        $Status = $this->request->getVar('Satus') ?? "";
         $session->set(["Unit_Id" => $Unit_Id,"Vendor_Id" => $Vendor_Id,"assignedto" => $assignedto,"SendBy" => $SendBy,"Status" => $Status]);
        // Date handling
        $session_start_date = $session->get('Sesssion_start_Date') ?? '2019-05-06';
        $session_end_date = $session->get('Sesssion_end_Date') ?? '9019-05-06';
        $date_format = '%Y-%m-%d';
    
        // Setting default values for session dates if not set
        $session_start_date_new = !empty($result['Session_start_Date']) ? $result['Session_start_Date'] : $session_start_date;
        $session_end_date_new = !empty($result['Session_end_Date']) ? $result['Session_end_Date'] : $session_end_date;
    
        // Admin Roll
        if ($Roll_id == 1) {
            $users = $BillRegister->select("asitek_bill_register.*, asitek_employee.emp_u_id, asitek_employee.first_name, asitek_employee.last_name")
                ->join('asitek_employee', 'asitek_bill_register.Add_By = asitek_employee.id', 'left')
                ->where('asitek_bill_register.compeny_id', $company_id)
                ->where('asitek_bill_register.Send_Note_Status', 1);
    
            if (!empty($Unit_Id)) {
                $users->where('asitek_bill_register.Unit_Id', $Unit_Id);
            }
    
            if (!empty($Vendor_Id)) {
                $users->where('asitek_bill_register.Vendor_Id', $Vendor_Id);
            }
    
            if (!empty($assignedto)) {
                $users->where('asitek_bill_register.Department_Emp_Id', $assignedto);
            }
    
            if (!empty($SendBy)) {
                $users->where('asitek_bill_register.Mapping_ERP_EmpId_By_MasterId', $SendBy);
            }
    
            if (!empty($Status) && $Status !== "All") {
                $users->where('asitek_bill_register.ERP_Status', $Status);
            }
    
            $users->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$session_start_date_new', '$date_format') AND STR_TO_DATE('$session_end_date_new', '$date_format')")
                ->orderBy('asitek_bill_register.id', 'desc');
    
            $users = $users->paginate($perPage);
        } else {
            // Non-admin case
            $users = $BillRegister->select("asitek_bill_register.*, asitek_employee.emp_u_id, asitek_employee.first_name, asitek_employee.last_name")
                ->join('asitek_employee', 'asitek_bill_register.Add_By = asitek_employee.id', 'left')
                ->where('asitek_bill_register.compeny_id', $company_id)
                ->where('asitek_bill_register.Send_Note_To', $emp_id)
                ->where('asitek_bill_register.Send_Note_Status', 1);
    
            if (!empty($Unit_Id)) {
                $users->where('asitek_bill_register.Unit_Id', $Unit_Id);
            }
    
            if (!empty($Vendor_Id)) {
                $users->where('asitek_bill_register.Vendor_Id', $Vendor_Id);
            }
    
            if (!empty($assignedto)) {
                $users->where('asitek_bill_register.Mapping_ERP_EmpId', $assignedto);
            }
    
            if (!empty($SendBy)) {
                $users->where('asitek_bill_register.Mapping_ERP_EmpId_By_MasterId', $SendBy);
            }
    
            if (!empty($Status) && $Status !== "All") {
                $users->where('asitek_bill_register.ERP_Status', $Status);
            }
    
            $users->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$session_start_date_new', '$date_format') AND STR_TO_DATE('$session_end_date_new', '$date_format')")
                ->orderBy('asitek_bill_register.id', 'desc');
    
            $users = $users->paginate($perPage);
        }
    
        $departmentModel = new DepartmentModel();
        $dax9 = $departmentModel->where("compeny_id", $company_id)->findAll();
    
        $employeeModel = new EmployeeModel();
        $builderrecommended = $this->db->table("asitek_company_vendor");
        $builderrecommended->select('asitek_company_vendor.Vendor_Id, asitek_party_user.id, asitek_party_user.GST_No, asitek_party_user.Name');
        $builderrecommended->join('asitek_party_user', 'asitek_party_user.id = asitek_company_vendor.Vendor_Id');
        $builderrecommended->where('asitek_company_vendor.Company_Id', $company_id);
        $builderrecommended->groupBy('asitek_company_vendor.Vendor_Id');
        $builderrecommended->orderBy('asitek_party_user.Name', 'ASC');
        $data_recommended = $builderrecommended->get()->getResult();
    
        $unitModel = new UnitModel();
        $dax15 = $unitModel->where("compeny_id", $company_id)->findAll();
    
        $departmentModel = new DepartmentModel();
        $dax16 = $departmentModel->where("compeny_id", $company_id)->findAll();
    
        $data = [
            'users' => $users,
            'pager' => $BillRegister->pager,
            'startSerial' => $startSerial,
            'nextPage' => $page + 1,
            'previousPage' => ($page > 1) ? $page - 1 : null,
            'dax9' => $dax9,
            'dax14' => $data_recommended,
            'dax15' => $dax15,
            'dax16' => $dax16,
        ];
    
        return view("debit-note-account", $data);
    }


    public function debitnotetoaccount()
    {
        $session = \Config\Services::session();
        $email = \Config\Services::email();
        $result = $session->get();
        $model = new BillRegisterModel();
        $vendormodel = new PartyUserModel();
        $companymodel = new CompenyModel();
        $Mapping_Acount_EmpId = $this->request->getVar("Mapping_Acount_EmpId");
        $id = $this->request->getVar("id");
        $action = $this->request->getVar("action");
        $validation = \Config\Services::validation();
        $Mapping_Acount_By_MasterId = $result["emp_id"];
        $file = $this->request->getFile("E_Image");
        if ($file != "") {
            $validation->setRules([
                "E_Image" =>"uploaded[E_Image]|ext_in[E_Image,jpg,JPG,png,PNG,jpeg,JPEG,pdf]",
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
            "Send_Note_To_Account_By" => $Mapping_Acount_EmpId,
            "Send_Account_Note_Image" => $imageName,
            "Send_Note_Account_Remark" => $this->request->getVar("ERP_Remark"),
            "Send_Note_Account_Status" => 1,
        ];

        $billid = $this->db->query("SELECT uid from asitek_bill_register WHERE id='$id'")->getResult(); // Adjust the column name based on your database structure

        if (isset($billid) && !empty($data)) {

            $model->where('id', $id)->set($data)->update();
            return redirect("debit-note-account");
        }
        else{
            $session->setFlashdata("sendtoaccount", 2);
            return redirect("debit-note-account");
        }    
    }


    public function debitnotesendtoaccount()
    {
        $session = \Config\Services::session();
        $email = \Config\Services::email();
        $result = $session->get();
        $Mapping_Acount_By_MasterId = $result["emp_id"];
        $model = new BillRegisterModel();
        $vendormodel = new PartyUserModel();
        $companymodel = new CompenyModel();
        $MasterActionmadelObj = new MasterActionModel();
        $MasterActionUploadModelObj = new MasterActionUploadModel();
        $request = $this->request;
        $companyid = $request->getPost("companyid");
        $Mapping_Acount_EmpId = $request->getPost("Mapping_Acount_EmpId");
        $uid = $request->getPost("billid");
        $erpremark = $request->getPost("erpremark");
        $E_Image = $request->getFile("E_Image");
        $billid = $this->db->query("SELECT id from asitek_bill_register WHERE compeny_id='$companyid' AND uid = '$uid'")->getResult();
        if (isset($billid) && !empty($billid)) {
            $billidvalue = $billid[0]->id;
            if (!empty($E_Image)) {
                // Handle file upload
                if ($E_Image->isValid() && !$E_Image->hasMoved()) {
                    $newName = $E_Image->getRandomName();
                    $E_Image->move("public/vendors/PicUpload", $newName);
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
                "Send_Note_To_Account_By" => $Mapping_Acount_EmpId,
                "Send_Account_Note_Image" => $newName,
                "Send_Note_Account_Remark" => $erpremark,
                "Send_Note_Account_Status" => 1,
            ];

            if ($model->where("id", $billidvalue)->where("compeny_id", $companyid)->set($data)->update()) {
                
                $data = [
                    "status" => "success",
                    "message" => "Debit note added and send to account",
                ];

                return $this->response->setJSON($data);
            }
        } else {
            $data = [
                "status" => "success",
                "message" => "Either bill is not accepted or it is sent to bill receiving",
            ];

            return $this->response->setJSON($data);
        }
    }


    //DEBIT NOTE ACCOUNT
    public function debitnotevendor()
    {
        $session = \Config\Services::session();
        $result = $session->get();
        $BillRegister = new BillRegisterModel();
        $page = $this->request->getVar('page') ?? 1;
        $perPage = 50;
        $startSerial = ($page - 1) * $perPage + 1;
        $Roll_id = $session->get("Roll_id");
        $emp_id = $session->get("emp_id");
        $company_id = $session->get("compeny_id");
    
        $Unit_Id = $this->request->getVar('Unit_Id') ?? "";
        $Vendor_Id = $this->request->getVar('Vendor_Id') ?? "";
        $assignedto = $this->request->getVar('assignedto') ?? "";
        $SendBy = $this->request->getVar('SendBy') ?? "";
        $Status = $this->request->getVar('Satus') ?? "";
         $session->set(["Unit_Id" => $Unit_Id,"Vendor_Id" => $Vendor_Id,"assignedto" => $assignedto,"SendBy" => $SendBy,"Status" => $Status]);
        // Date handling
        $session_start_date = $session->get('Sesssion_start_Date') ?? '2019-05-06';
        $session_end_date = $session->get('Sesssion_end_Date') ?? '9019-05-06';
        $date_format = '%Y-%m-%d';
    
        // Setting default values for session dates if not set
        $session_start_date_new = !empty($result['Session_start_Date']) ? $result['Session_start_Date'] : $session_start_date;
        $session_end_date_new = !empty($result['Session_end_Date']) ? $result['Session_end_Date'] : $session_end_date;
    
        // Admin Roll
        if ($Roll_id == 1) {
            $users = $BillRegister->select("asitek_bill_register.*, asitek_employee.emp_u_id, asitek_employee.first_name, asitek_employee.last_name")
                ->join('asitek_employee', 'asitek_bill_register.Add_By = asitek_employee.id', 'left')
                ->where('asitek_bill_register.compeny_id', $company_id)
                ->where('asitek_bill_register.Send_Note_Status', 1);
    
            if (!empty($Unit_Id)) {
                $users->where('asitek_bill_register.Unit_Id', $Unit_Id);
            }
    
            if (!empty($Vendor_Id)) {
                $users->where('asitek_bill_register.Vendor_Id', $Vendor_Id);
            }
    
            if (!empty($assignedto)) {
                $users->where('asitek_bill_register.Department_Emp_Id', $assignedto);
            }
    
            if (!empty($SendBy)) {
                $users->where('asitek_bill_register.Mapping_ERP_EmpId_By_MasterId', $SendBy);
            }
    
            if (!empty($Status) && $Status !== "All") {
                $users->where('asitek_bill_register.ERP_Status', $Status);
            }
    
            $users->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$session_start_date_new', '$date_format') AND STR_TO_DATE('$session_end_date_new', '$date_format')")
                ->orderBy('asitek_bill_register.id', 'desc');
    
            $users = $users->paginate($perPage);
        } else {
            // Non-admin case
            $users = $BillRegister->select("asitek_bill_register.*, asitek_employee.emp_u_id, asitek_employee.first_name, asitek_employee.last_name")
                ->join('asitek_employee', 'asitek_bill_register.Add_By = asitek_employee.id', 'left')
                ->where('asitek_bill_register.compeny_id', $company_id)
                ->where('asitek_bill_register.Send_Note_To_Account_By', $emp_id)
                ->where('asitek_bill_register.Send_Note_Status', 1)
                ->where('asitek_bill_register.Send_Note_Account_Status', 1);
    
            if (!empty($Unit_Id)) {
                $users->where('asitek_bill_register.Unit_Id', $Unit_Id);
            }
    
            if (!empty($Vendor_Id)) {
                $users->where('asitek_bill_register.Vendor_Id', $Vendor_Id);
            }
    
            if (!empty($assignedto)) {
                $users->where('asitek_bill_register.Mapping_ERP_EmpId', $assignedto);
            }
    
            if (!empty($SendBy)) {
                $users->where('asitek_bill_register.Mapping_ERP_EmpId_By_MasterId', $SendBy);
            }
    
            if (!empty($Status) && $Status !== "All") {
                $users->where('asitek_bill_register.ERP_Status', $Status);
            }
    
            $users->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$session_start_date_new', '$date_format') AND STR_TO_DATE('$session_end_date_new', '$date_format')")
                ->orderBy('asitek_bill_register.id', 'desc');
    
            $users = $users->paginate($perPage);
        }
    
        $departmentModel = new DepartmentModel();
        $dax9 = $departmentModel->where("compeny_id", $company_id)->findAll();
    
        $employeeModel = new EmployeeModel();
        $builderrecommended = $this->db->table("asitek_company_vendor");
        $builderrecommended->select('asitek_company_vendor.Vendor_Id, asitek_party_user.id, asitek_party_user.GST_No, asitek_party_user.Name');
        $builderrecommended->join('asitek_party_user', 'asitek_party_user.id = asitek_company_vendor.Vendor_Id');
        $builderrecommended->where('asitek_company_vendor.Company_Id', $company_id);
        $builderrecommended->groupBy('asitek_company_vendor.Vendor_Id');
        $builderrecommended->orderBy('asitek_party_user.Name', 'ASC');
        $data_recommended = $builderrecommended->get()->getResult();
    
        $unitModel = new UnitModel();
        $dax15 = $unitModel->where("compeny_id", $company_id)->findAll();
    
        $departmentModel = new DepartmentModel();
        $dax16 = $departmentModel->where("compeny_id", $company_id)->findAll();
    
        $data = [
            'users' => $users,
            'pager' => $BillRegister->pager,
            'startSerial' => $startSerial,
            'nextPage' => $page + 1,
            'previousPage' => ($page > 1) ? $page - 1 : null,
            'dax9' => $dax9,
            'dax14' => $data_recommended,
            'dax15' => $dax15,
            'dax16' => $dax16,
        ];
    
        return view("debit-note-to-vendor", $data);
    }


    public function debitnotetovendor()
    {
        $session = \Config\Services::session();
        $email = \Config\Services::email();
        $result = $session->get();
        $model = new BillRegisterModel();
        $vendormodel = new PartyUserModel();
        $companymodel = new CompenyModel();
        $id = $this->request->getVar("id");
        $action = $this->request->getVar("action");
        $validation = \Config\Services::validation();
        $Mapping_Acount_By_MasterId = $result["emp_id"];
        $file = $this->request->getFile("E_Image");
        if ($file != "") {
            $validation->setRules([
                "E_Image" =>"uploaded[E_Image]|ext_in[E_Image,jpg,JPG,png,PNG,jpeg,JPEG,pdf]",
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
            "Send_Vendor_Note_Image" => $imageName,
            "Send_Note_Vendor_Remark" => $this->request->getVar("ERP_Remark"),
            "Send_Note_Vendor_Status" => 1,
        ];

        $billid = $this->db->query("SELECT uid from asitek_bill_register WHERE id='$id'")->getResult(); // Adjust the column name based on your database structure

        if (isset($billid) && !empty($data)) {

            $model->where('id', $id)->set($data)->update();
            return redirect("debit-note-vendor");
        }
        else{
            $session->setFlashdata("sendtoaccount", 2);
            return redirect("debit-note-vendor");
        }    
    }


    public function debitnotesendtovendor()
    {
        $session = \Config\Services::session();
        $email = \Config\Services::email();
        $result = $session->get();
        $Mapping_Acount_By_MasterId = $result["emp_id"];
        $model = new BillRegisterModel();
        $vendormodel = new PartyUserModel();
        $companymodel = new CompenyModel();
        $MasterActionmadelObj = new MasterActionModel();
        $MasterActionUploadModelObj = new MasterActionUploadModel();
        $request = $this->request;
        $companyid = $request->getPost("companyid");
        $uid = $request->getPost("billid");
        $erpremark = $request->getPost("erpremark");
        $E_Image = $request->getFile("E_Image");
        $billid = $this->db->query("SELECT id from asitek_bill_register WHERE compeny_id='$companyid' AND uid = '$uid'")->getResult();
        if (isset($billid) && !empty($billid)) {
            $billidvalue = $billid[0]->id;
            if (!empty($E_Image)) {
                // Handle file upload
                if ($E_Image->isValid() && !$E_Image->hasMoved()) {
                    $newName = $E_Image->getRandomName();
                    $E_Image->move("public/vendors/PicUpload", $newName);
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
                "Send_Vendor_Note_Image" => $newName,
                "Send_Note_Vendor_Remark" => $erpremark,
                "Send_Note_Vendor_Status" => 1,
            ];

            if ($model->where("id", $billidvalue)->where("compeny_id", $companyid)->set($data)->update()) {
                
                $data = [
                    "status" => "success",
                    "message" => "Debit note added and send to account",
                ];

                return $this->response->setJSON($data);
            }
        } else {
            $data = [
                "status" => "success",
                "message" => "Either bill is not accepted or it is sent to bill receiving",
            ];

            return $this->response->setJSON($data);
        }
    }


    public function update_bill_debit_note_by_vendor()
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
            "Vendor_Debit_Note_Remark" => $this->request->getVar("yourcomment"),
            "Vendor_Debit_Note_Update" => $imageName,
        ];
        $emp = new BillRegisterModel();
        if (
            $emp
                ->where("id", $this->request->getVar("id"))
                ->set($data)
                ->update()
        ) {
            $session = \Config\Services::session();
            $session->setFlashdata("debitnoteupdate", 1);
            return redirect("vendor-dashboard");
        }
    }

    public function export_debit_note_list(){
        $session = \Config\Services::session();
        $result = $session->get(); 
        $Roll_id = $session->get("Roll_id");
        $emp_id = $session->get("emp_id");
        $compeny_id = $session->get("compeny_id");   
        $model = new BillRegisterModel();
        $UnitModelObj = new UnitModel();
        $RollModelObj = new RollModel();
        $EmployeeModelObj = new EmployeeModel();
        $PartyUserModelObj = new PartyUserModel();
        $DepartmentModelObj = new DepartmentModel();
        $MasterActionmadelObj = new MasterActionModel();
        $MasterActionUploadModelObj = new MasterActionUploadModel();

        if ($session->has('Unit_Id')) {
            $Unit_Id = $result['Unit_Id']; 
        } else {
            $Unit_Id = ""; 
        }
        if ($session->has('Vendor_Id')) {
            $Vendor_Id = $result['Vendor_Id']; 
        } else {
            $Vendor_Id = ""; 
        }
        if ($session->has('assignedto')) {
            $assignedto = $result['assignedto'];
        } else {
            $assignedto = ""; 
        }
        if ($session->has('SendBy')) {
            $SendBy = $result['SendBy']; 
        } else {
            $SendBy = ""; 
        }
        if ($session->has('Status')) {
            $Status = $result['Status']; 
        } else {
            $Status = ""; 
        }


        // Default start and end date values
        $defaultStartDate = '2019-05-06';
        $defaultEndDate = '9019-05-06';
        
        // Retrieve session start and end date values
        $Sesssion_start_Date_New = !empty($session->get('Sesssion_start_Date')) ? $session->get('Sesssion_start_Date') : $defaultStartDate;
        $Sesssion_end_Date_New = !empty($session->get('Sesssion_end_Date')) ? $session->get('Sesssion_end_Date') : $defaultEndDate;
        // Date format for SQL query
        $date_format = '%Y-%m-%d';

        // Excel file name for download 
        $fileName = "debit_note_list" . date('Y-m-d') . ".xls";     
        // Column names 
        $fields = array('Bill Pic', 'Bill Id', 'Vendor', 'Bill No', 'Bill Amount', 'Bill Date', 'Unit Name', 'Gate Entry No', 'Gate Entry Date', 'Send By' ,  'Send To', 'Bill Note Image','Amount'); 
        // Display column names as first row 
        $excelData = implode("\t", array_values($fields)) . "\n"; 
        // Fetch records from database
        if ($Roll_id == 1) {
            $users = $model ->select("asitek_bill_register.*, asitek_employee.emp_u_id, asitek_employee.first_name, asitek_employee.last_name")->join('asitek_employee', 'asitek_bill_register.Add_By = asitek_employee.id', 'left')->where('asitek_bill_register.compeny_id', $compeny_id)->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$Sesssion_start_Date_New', '$date_format') AND STR_TO_DATE('$Sesssion_end_Date_New', '$date_format')");
  
            if (!empty($Unit_Id)) {
                $users->where('asitek_bill_register.Unit_Id', $Unit_Id);
            }

            if (!empty($Vendor_Id)) {
                $users->where('asitek_bill_register.Vendor_Id', $Vendor_Id);
            }

            if (!empty($assignedto)) {
                $users->where('asitek_bill_register.Department_Emp_Id', $assignedto);
            }

            if (!empty($SendBy)) {
                $users->where('asitek_bill_register.Mapping_ERP_EmpId_By_MasterId', $SendBy);
            }

            if (!empty($Status) && $Status !== "All") {
                $users->where('asitek_bill_register.ERP_Status', $Status);
            }
            $data = $users->orderBy('asitek_bill_register.id', 'desc')->findAll();
        } else {
            $users = $model ->select("asitek_bill_register.*, asitek_employee.emp_u_id, asitek_employee.first_name, asitek_employee.last_name")->join('asitek_employee', 'asitek_bill_register.Add_By = asitek_employee.id', 'left')->where('asitek_bill_register.compeny_id', $compeny_id)->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$Sesssion_start_Date_New', '$date_format') AND STR_TO_DATE('$Sesssion_end_Date_New', '$date_format')")->where('asitek_bill_register.Department_Emp_Id', $emp_id);
  
            if (!empty($Unit_Id)) {
                $users->where('asitek_bill_register.Unit_Id', $Unit_Id);
            }

            if (!empty($Vendor_Id)) {
                $users->where('asitek_bill_register.Vendor_Id', $Vendor_Id);
            }

            if (!empty($assignedto)) {
                $users->where('asitek_bill_register.Department_Emp_Id', $assignedto);
            }

            if (!empty($SendBy)) {
                $users->where('asitek_bill_register.Mapping_ERP_EmpId_By_MasterId', $SendBy);
            }

            if (!empty($Status) && $Status !== "All") {
                $users->where('asitek_bill_register.ERP_Status', $Status);
            }
            $data = $users->orderBy('asitek_bill_register.id', 'desc')->findAll();
        }   
        // $data = $model->orderBy('id', 'desc'->findAll(); 
        $stage_id=4;
        if(isset($data)){ 
            // Output each row of the data 
            foreach($data as $row)
            { 
                /*Uid*/
                if(isset($row['uid'])){ 
                    $uid = $row['uid'];}else{ $uid = 'NA';
                }
                /*Vendor Details*/
                $Vendorrow= $PartyUserModelObj->where('id',$row['Vendor_Id'])->first();
                if(isset($Vendorrow) && $Vendorrow!='')
                {
                    $VendorName= $Vendorrow['Name']; 
                }
                else
                {
                    $VendorName=''; 
                }
                /*Bill No*/
                if(isset($row['Bill_No'])){
                    $Bill_No = $row['Bill_No'];}else{ $Bill_No = 'NA';
                }
                /*Bill Amount*/
                if(isset($row['Bill_Amount'])){
                    $Bill_Amount = $row['Bill_Amount'];}else{ $Bill_Amount = 'NA';
                }
                /*Bill Date Time*/
                if(isset($row['Bill_DateTime'])){
                    $Bill_DateTime = date('d/m/Y', strtotime($row['Bill_DateTime']));}else{ $Bill_DateTime = 'NA';
                }
                /*Unit Name*/
                $Unitrow= $UnitModelObj->where('id',$row['Unit_Id'])->first();
                if(isset($Unitrow) && $Unitrow!='')
                {
                    $UnitName =$Unitrow['name']; 
                }
                else{
                    $UnitName='';
                }
                /*Gate Entry Number*/
                if(isset($row['Gate_Entry_No'])){
                    $Gate_Entry_No = $row['Gate_Entry_No'];}else{ $Gate_Entry_No = 'NA';
                }
                /*Gate Entry Date*/
                if(isset($row['Gate_Entry_Date'])){
                    $Gate_Entry_Date = date('d/m/Y', strtotime($row['Gate_Entry_Date']));}else{ $Gate_Entry_Date = 'NA';
                }
                /*Send By Emloyee Name*/
                $MappingEmprow= $EmployeeModelObj->where('id',$row['Send_Note_By'])->first();
                if(isset($MappingEmprow) && $MappingEmprow!='')
                {
                    $sendbyemp= $MappingEmprow['first_name'].' '.$MappingEmprow['last_name'];
                }
                else{
                    $sendbyemp=''; 
                }

                /*Send to Emloyee Name*/
                $emprow= $EmployeeModelObj->where('id',$row['Send_Note_To'])->first();
                if(isset($emprow) && $emprow!='')
                {
                    $sendtoemp= $emprow['first_name'].' '.$emprow['last_name'];
                }
                else{
                    $sendtoemp=''; 
                }
                /*REmark*/
                if(isset($row['Send_Note_Remark'])){
                    $sendnoteremark = $row['Send_Note_Remark'];}else{ $sendnoteremark = 'NA';
                }
                
                
                //*************
                $lineData = array( 'link', $uid, $VendorName, $Bill_No, $Bill_Amount, $Bill_DateTime, $UnitName, $Gate_Entry_No, $Gate_Entry_Date, $sendbyemp, $sendtoemp, 'link', $sendnoteremark);
                // array_walk(str_replace('"', '""',(preg_replace("/\r?\n/", "\\n",(preg_replace("/\t/", "\\t", $lineData))))); 
                $excelData .= implode("\t", array_values($lineData)) . "\n";   
            } 
        }
        else{ 
            $session->setFlashdata('excel',1);
        } 
        // Headers for download 
        header("Content-Type: application/vnd.ms-excel"); 
        header("Content-Disposition: attachment; filename=\"$fileName\""); 
        echo $excelData; 
        exit;
    }



    public function export_debit_note_manager_list(){
        $session = \Config\Services::session();
        $result = $session->get(); 
        $Roll_id = $session->get("Roll_id");
        $emp_id = $session->get("emp_id");
        $compeny_id = $session->get("compeny_id");   
        $model = new BillRegisterModel();
        $UnitModelObj = new UnitModel();
        $RollModelObj = new RollModel();
        $EmployeeModelObj = new EmployeeModel();
        $PartyUserModelObj = new PartyUserModel();
        $DepartmentModelObj = new DepartmentModel();
        $MasterActionmadelObj = new MasterActionModel();
        $MasterActionUploadModelObj = new MasterActionUploadModel();

        if ($session->has('Unit_Id')) {
            $Unit_Id = $result['Unit_Id']; 
        } else {
            $Unit_Id = ""; 
        }
        if ($session->has('Vendor_Id')) {
            $Vendor_Id = $result['Vendor_Id']; 
        } else {
            $Vendor_Id = ""; 
        }
        if ($session->has('assignedto')) {
            $assignedto = $result['assignedto'];
        } else {
            $assignedto = ""; 
        }
        if ($session->has('SendBy')) {
            $SendBy = $result['SendBy']; 
        } else {
            $SendBy = ""; 
        }
        if ($session->has('Status')) {
            $Status = $result['Status']; 
        } else {
            $Status = ""; 
        }


        // Default start and end date values
        $defaultStartDate = '2019-05-06';
        $defaultEndDate = '9019-05-06';
        
        // Retrieve session start and end date values
        $Sesssion_start_Date_New = !empty($session->get('Sesssion_start_Date')) ? $session->get('Sesssion_start_Date') : $defaultStartDate;
        $Sesssion_end_Date_New = !empty($session->get('Sesssion_end_Date')) ? $session->get('Sesssion_end_Date') : $defaultEndDate;
        // Date format for SQL query
        $date_format = '%Y-%m-%d';

        // Excel file name for download 
        $fileName = "manager_debit_note_list" . date('Y-m-d') . ".xls";     
        // Column names 
        $fields = array('Bill Pic', 'Bill Id', 'Vendor', 'Bill No', 'Bill Amount', 'Bill Date', 'Unit Name', 'Gate Entry No', 'Gate Entry Date', 'Send By' ,  'Send To', 'Bill Note Image' ,'Amount' ,'Account Name', 'Manager Upload', 'Manager Amount'); 
        // Display column names as first row 
        $excelData = implode("\t", array_values($fields)) . "\n"; 
        // Fetch records from database
        if ($Roll_id == 1) {
            $users = $model ->select("asitek_bill_register.*, asitek_employee.emp_u_id, asitek_employee.first_name, asitek_employee.last_name")->join('asitek_employee', 'asitek_bill_register.Add_By = asitek_employee.id', 'left')->where('asitek_bill_register.compeny_id', $compeny_id)->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$Sesssion_start_Date_New', '$date_format') AND STR_TO_DATE('$Sesssion_end_Date_New', '$date_format')");
  
            if (!empty($Unit_Id)) {
                $users->where('asitek_bill_register.Unit_Id', $Unit_Id);
            }

            if (!empty($Vendor_Id)) {
                $users->where('asitek_bill_register.Vendor_Id', $Vendor_Id);
            }

            if (!empty($assignedto)) {
                $users->where('asitek_bill_register.Department_Emp_Id', $assignedto);
            }

            if (!empty($SendBy)) {
                $users->where('asitek_bill_register.Mapping_ERP_EmpId_By_MasterId', $SendBy);
            }

            if (!empty($Status) && $Status !== "All") {
                $users->where('asitek_bill_register.ERP_Status', $Status);
            }
            $data = $users->orderBy('asitek_bill_register.id', 'desc')->findAll();
        } else {
            $users = $model ->select("asitek_bill_register.*, asitek_employee.emp_u_id, asitek_employee.first_name, asitek_employee.last_name")->join('asitek_employee', 'asitek_bill_register.Add_By = asitek_employee.id', 'left')->where('asitek_bill_register.compeny_id', $compeny_id)->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$Sesssion_start_Date_New', '$date_format') AND STR_TO_DATE('$Sesssion_end_Date_New', '$date_format')")->where('asitek_bill_register.Department_Emp_Id', $emp_id);
  
            if (!empty($Unit_Id)) {
                $users->where('asitek_bill_register.Unit_Id', $Unit_Id);
            }

            if (!empty($Vendor_Id)) {
                $users->where('asitek_bill_register.Vendor_Id', $Vendor_Id);
            }

            if (!empty($assignedto)) {
                $users->where('asitek_bill_register.Department_Emp_Id', $assignedto);
            }

            if (!empty($SendBy)) {
                $users->where('asitek_bill_register.Mapping_ERP_EmpId_By_MasterId', $SendBy);
            }

            if (!empty($Status) && $Status !== "All") {
                $users->where('asitek_bill_register.ERP_Status', $Status);
            }
            $data = $users->orderBy('asitek_bill_register.id', 'desc')->findAll();
        }   
        // $data = $model->orderBy('id', 'desc'->findAll(); 
        $stage_id=4;
        if(isset($data)){ 
            // Output each row of the data 
            foreach($data as $row)
            { 
                /*Uid*/
                if(isset($row['uid'])){ 
                    $uid = $row['uid'];}else{ $uid = 'NA';
                }
                /*Vendor Details*/
                $Vendorrow= $PartyUserModelObj->where('id',$row['Vendor_Id'])->first();
                if(isset($Vendorrow) && $Vendorrow!='')
                {
                    $VendorName= $Vendorrow['Name']; 
                }
                else
                {
                    $VendorName=''; 
                }
                /*Bill No*/
                if(isset($row['Bill_No'])){
                    $Bill_No = $row['Bill_No'];}else{ $Bill_No = 'NA';
                }
                /*Bill Amount*/
                if(isset($row['Bill_Amount'])){
                    $Bill_Amount = $row['Bill_Amount'];}else{ $Bill_Amount = 'NA';
                }
                /*Bill Date Time*/
                if(isset($row['Bill_DateTime'])){
                    $Bill_DateTime = date('d/m/Y', strtotime($row['Bill_DateTime']));}else{ $Bill_DateTime = 'NA';
                }
                /*Unit Name*/
                $Unitrow= $UnitModelObj->where('id',$row['Unit_Id'])->first();
                if(isset($Unitrow) && $Unitrow!='')
                {
                    $UnitName =$Unitrow['name']; 
                }
                else{
                    $UnitName='';
                }
                /*Gate Entry Number*/
                if(isset($row['Gate_Entry_No'])){
                    $Gate_Entry_No = $row['Gate_Entry_No'];}else{ $Gate_Entry_No = 'NA';
                }
                /*Gate Entry Date*/
                if(isset($row['Gate_Entry_Date'])){
                    $Gate_Entry_Date = date('d/m/Y', strtotime($row['Gate_Entry_Date']));}else{ $Gate_Entry_Date = 'NA';
                }
                /*Send By Emloyee Name*/
                $MappingEmprow= $EmployeeModelObj->where('id',$row['Send_Note_By'])->first();
                if(isset($MappingEmprow) && $MappingEmprow!='')
                {
                    $sendbyemp= $MappingEmprow['first_name'].' '.$MappingEmprow['last_name'];
                }
                else{
                    $sendbyemp=''; 
                }

                /*Send to Emloyee Name*/
                $emprow= $EmployeeModelObj->where('id',$row['Send_Note_To'])->first();
                if(isset($emprow) && $emprow!='')
                {
                    $sendtoemp= $emprow['first_name'].' '.$emprow['last_name'];
                }
                else{
                    $sendtoemp=''; 
                }
                /*Debit Amount*/
                if(isset($row['Send_Note_Remark'])){
                    $sendnoteremark = $row['Send_Note_Remark'];
                }
                else{ 
                    $sendnoteremark = 'NA';
                }
                /*Manage Name*/
                $managername= $EmployeeModelObj->where('id',$row['Send_Note_To_Account_By'])->first();
                if(isset($managername) && $managername!='')
                {
                    $managerrowname= $managername['first_name'].' '.$managername['last_name'];
                }
                else{
                    $managerrowname=''; 
                }

                /*Debit Amount*/
                if(isset($row['Send_Note_Account_Remark'])){
                    $managerupdatedamount = $row['Send_Note_Account_Remark'];
                }
                else{ 
                    $managerupdatedamount = 'NA';
                }
                
                $lineData = array( 'link', $uid, $VendorName, $Bill_No, $Bill_Amount, $Bill_DateTime, $UnitName, $Gate_Entry_No, $Gate_Entry_Date, $sendbyemp, $sendtoemp, 'link', $sendnoteremark, $managerrowname, 'link', $managerupdatedamount);
                // array_walk(str_replace('"', '""',(preg_replace("/\r?\n/", "\\n",(preg_replace("/\t/", "\\t", $lineData))))); 
                $excelData .= implode("\t", array_values($lineData)) . "\n";   
            } 
        }
        else{ 
            $session->setFlashdata('excel',1);
        } 
        // Headers for download 
        header("Content-Type: application/vnd.ms-excel"); 
        header("Content-Disposition: attachment; filename=\"$fileName\""); 
        echo $excelData; 
        exit;
    }

    public function export_debit_note_account_list(){
        $session = \Config\Services::session();
        $result = $session->get(); 
        $Roll_id = $session->get("Roll_id");
        $emp_id = $session->get("emp_id");
        $compeny_id = $session->get("compeny_id");   
        $model = new BillRegisterModel();
        $UnitModelObj = new UnitModel();
        $RollModelObj = new RollModel();
        $EmployeeModelObj = new EmployeeModel();
        $PartyUserModelObj = new PartyUserModel();
        $DepartmentModelObj = new DepartmentModel();
        $MasterActionmadelObj = new MasterActionModel();
        $MasterActionUploadModelObj = new MasterActionUploadModel();

        if ($session->has('Unit_Id')) {
            $Unit_Id = $result['Unit_Id']; 
        } else {
            $Unit_Id = ""; 
        }
        if ($session->has('Vendor_Id')) {
            $Vendor_Id = $result['Vendor_Id']; 
        } else {
            $Vendor_Id = ""; 
        }
        if ($session->has('assignedto')) {
            $assignedto = $result['assignedto'];
        } else {
            $assignedto = ""; 
        }
        if ($session->has('SendBy')) {
            $SendBy = $result['SendBy']; 
        } else {
            $SendBy = ""; 
        }
        if ($session->has('Status')) {
            $Status = $result['Status']; 
        } else {
            $Status = ""; 
        }


        // Default start and end date values
        $defaultStartDate = '2019-05-06';
        $defaultEndDate = '9019-05-06';
        
        // Retrieve session start and end date values
        $Sesssion_start_Date_New = !empty($session->get('Sesssion_start_Date')) ? $session->get('Sesssion_start_Date') : $defaultStartDate;
        $Sesssion_end_Date_New = !empty($session->get('Sesssion_end_Date')) ? $session->get('Sesssion_end_Date') : $defaultEndDate;
        // Date format for SQL query
        $date_format = '%Y-%m-%d';

        // Excel file name for download 
        $fileName = "manager_debit_note_list" . date('Y-m-d') . ".xls";     
        // Column names 
        $fields = array('Bill Pic', 'Bill Id', 'Vendor', 'Bill No', 'Bill Amount', 'Bill Date', 'Unit Name', 'Gate Entry No', 'Gate Entry Date', 'Send By' ,  'Send To', 'Bill Note Image' ,'Amount' ,'Account Name', 'Manager Upload', 'Manager Amount', 'Account Upload', 'Account Amount', 'Vendor Upload', 'Vendor Remark'); 
        // Display column names as first row 
        $excelData = implode("\t", array_values($fields)) . "\n"; 
        // Fetch records from database
        if ($Roll_id == 1) {
            $users = $model ->select("asitek_bill_register.*, asitek_employee.emp_u_id, asitek_employee.first_name, asitek_employee.last_name")->join('asitek_employee', 'asitek_bill_register.Add_By = asitek_employee.id', 'left')->where('asitek_bill_register.compeny_id', $compeny_id)->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$Sesssion_start_Date_New', '$date_format') AND STR_TO_DATE('$Sesssion_end_Date_New', '$date_format')");
  
            if (!empty($Unit_Id)) {
                $users->where('asitek_bill_register.Unit_Id', $Unit_Id);
            }

            if (!empty($Vendor_Id)) {
                $users->where('asitek_bill_register.Vendor_Id', $Vendor_Id);
            }

            if (!empty($assignedto)) {
                $users->where('asitek_bill_register.Department_Emp_Id', $assignedto);
            }

            if (!empty($SendBy)) {
                $users->where('asitek_bill_register.Mapping_ERP_EmpId_By_MasterId', $SendBy);
            }

            if (!empty($Status) && $Status !== "All") {
                $users->where('asitek_bill_register.ERP_Status', $Status);
            }
            $data = $users->orderBy('asitek_bill_register.id', 'desc')->findAll();
        } else {
            $users = $model ->select("asitek_bill_register.*, asitek_employee.emp_u_id, asitek_employee.first_name, asitek_employee.last_name")->join('asitek_employee', 'asitek_bill_register.Add_By = asitek_employee.id', 'left')->where('asitek_bill_register.compeny_id', $compeny_id)->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$Sesssion_start_Date_New', '$date_format') AND STR_TO_DATE('$Sesssion_end_Date_New', '$date_format')")->where('asitek_bill_register.Department_Emp_Id', $emp_id);
  
            if (!empty($Unit_Id)) {
                $users->where('asitek_bill_register.Unit_Id', $Unit_Id);
            }

            if (!empty($Vendor_Id)) {
                $users->where('asitek_bill_register.Vendor_Id', $Vendor_Id);
            }

            if (!empty($assignedto)) {
                $users->where('asitek_bill_register.Department_Emp_Id', $assignedto);
            }

            if (!empty($SendBy)) {
                $users->where('asitek_bill_register.Mapping_ERP_EmpId_By_MasterId', $SendBy);
            }

            if (!empty($Status) && $Status !== "All") {
                $users->where('asitek_bill_register.ERP_Status', $Status);
            }
            $data = $users->orderBy('asitek_bill_register.id', 'desc')->findAll();
        }   
        // $data = $model->orderBy('id', 'desc'->findAll(); 
        $stage_id=4;
        if(isset($data)){ 
            // Output each row of the data 
            foreach($data as $row)
            { 
                /*Uid*/
                if(isset($row['uid'])){ 
                    $uid = $row['uid'];}else{ $uid = 'NA';
                }
                /*Vendor Details*/
                $Vendorrow= $PartyUserModelObj->where('id',$row['Vendor_Id'])->first();
                if(isset($Vendorrow) && $Vendorrow!='')
                {
                    $VendorName= $Vendorrow['Name']; 
                }
                else
                {
                    $VendorName=''; 
                }
                /*Bill No*/
                if(isset($row['Bill_No'])){
                    $Bill_No = $row['Bill_No'];}else{ $Bill_No = 'NA';
                }
                /*Bill Amount*/
                if(isset($row['Bill_Amount'])){
                    $Bill_Amount = $row['Bill_Amount'];}else{ $Bill_Amount = 'NA';
                }
                /*Bill Date Time*/
                if(isset($row['Bill_DateTime'])){
                    $Bill_DateTime = date('d/m/Y', strtotime($row['Bill_DateTime']));}else{ $Bill_DateTime = 'NA';
                }
                /*Unit Name*/
                $Unitrow= $UnitModelObj->where('id',$row['Unit_Id'])->first();
                if(isset($Unitrow) && $Unitrow!='')
                {
                    $UnitName =$Unitrow['name']; 
                }
                else{
                    $UnitName='';
                }
                /*Gate Entry Number*/
                if(isset($row['Gate_Entry_No'])){
                    $Gate_Entry_No = $row['Gate_Entry_No'];}else{ $Gate_Entry_No = 'NA';
                }
                /*Gate Entry Date*/
                if(isset($row['Gate_Entry_Date'])){
                    $Gate_Entry_Date = date('d/m/Y', strtotime($row['Gate_Entry_Date']));}else{ $Gate_Entry_Date = 'NA';
                }
                /*Send By Emloyee Name*/
                $MappingEmprow= $EmployeeModelObj->where('id',$row['Send_Note_By'])->first();
                if(isset($MappingEmprow) && $MappingEmprow!='')
                {
                    $sendbyemp= $MappingEmprow['first_name'].' '.$MappingEmprow['last_name'];
                }
                else{
                    $sendbyemp=''; 
                }

                /*Send to Emloyee Name*/
                $emprow= $EmployeeModelObj->where('id',$row['Send_Note_To'])->first();
                if(isset($emprow) && $emprow!='')
                {
                    $sendtoemp= $emprow['first_name'].' '.$emprow['last_name'];
                }
                else{
                    $sendtoemp=''; 
                }
                /*Debit Amount*/
                if(isset($row['Send_Note_Remark'])){
                    $sendnoteremark = $row['Send_Note_Remark'];
                }
                else{ 
                    $sendnoteremark = 'NA';
                }
                /*Manage Name*/
                $managername= $EmployeeModelObj->where('id',$row['Send_Note_To_Account_By'])->first();
                if(isset($managername) && $managername!='')
                {
                    $managerrowname= $managername['first_name'].' '.$managername['last_name'];
                }
                else{
                    $managerrowname=''; 
                }

                /*Debit Amount*/
                if(isset($row['Send_Note_Account_Remark'])){
                    $managerupdatedamount = $row['Send_Note_Account_Remark'];
                }
                else{ 
                    $managerupdatedamount = 'NA';
                }

                /*Account Amount*/
                if(isset($row['Send_Note_Vendor_Remark'])){
                    $accountupdatedamount = $row['Send_Note_Vendor_Remark'];
                }
                else{ 
                    $accountupdatedamount = 'NA';
                }

                /*Vendor Remark*/
                if(isset($row['Vendor_Debit_Note_Remark'])){
                    $vendorupdatedremark = $row['Vendor_Debit_Note_Remark'];
                }
                else{ 
                    $vendorupdatedremark = 'NA';
                }
                
                $lineData = array( 'link', $uid, $VendorName, $Bill_No, $Bill_Amount, $Bill_DateTime, $UnitName, $Gate_Entry_No, $Gate_Entry_Date, $sendbyemp, $sendtoemp, 'link', $sendnoteremark, $managerrowname, 'link', $managerupdatedamount, 'link', $accountupdatedamount, 'link', $vendorupdatedremark);
                // array_walk(str_replace('"', '""',(preg_replace("/\r?\n/", "\\n",(preg_replace("/\t/", "\\t", $lineData))))); 
                $excelData .= implode("\t", array_values($lineData)) . "\n";   
            } 
        }
        else{ 
            $session->setFlashdata('excel',1);
        } 
        // Headers for download 
        header("Content-Type: application/vnd.ms-excel"); 
        header("Content-Disposition: attachment; filename=\"$fileName\""); 
        echo $excelData; 
        exit;
    }
}
