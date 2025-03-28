<?php
    namespace App\Controllers;
 
    use App\Controllers\BaseController;
    use SimpleSoftwareIO\QrCode\Generator;
    use App\Models\BillRegisterModel;
    
    class QrCodeGeneratorController extends BaseController
    {
        private $db; 
        public function __construct()
        {
            $this->db = db_connect(); // Loading database
        }

        public function index($uid)
        {
            $qrcode = new Generator;
            $qrCodes = [];
            $qrCodes['simple'] = $qrcode->size(400)->generate('http://192.168.1.250:8080/bill_management/index.php/sigle_bill_list/'.$uid);
            return view('qr-codes', $qrCodes);
        }
        
        
        public function barcode($uid)
        {
            $data['uid'] = $uid;
            $barcodeOptions = ['uid' => $uid];
            $rendererOptions = ['imageType' => 'png'];
    
            $data['barcode'] = Barcode::factory('code128', 'image', $barcodeOptions, $rendererOptions)->render();
    
            // Output barcode
            header('Content-Type: image/png');
            return view('barcode', $data);
        }
        
        public function getSuggestions()
        {
            $query      = $this->request->getVar('query'); // Get the entered text from the input field
            $companyid  = $this->request->getVar('companyid');
            $data = $this->db->query("SELECT * from asitek_bill_register WHERE compeny_id='$companyid' AND uid LIKE '%$query' ORDER BY id DESC LIMIT 20")->getResult();  // Adjust the column name based on your database structure
            return $this->response->setJSON($data);
        }
        
        
        public function uidbarcode()
        {
            $uid = $this->request->getVar('enteruid');
            $companyid  = $this->request->getVar('companyid');
            $data['billid'] = $this->db->query("SELECT id from asitek_bill_register WHERE compeny_id='$companyid' AND uid = '$uid'")->getResult();  // Adjust the column name based on your database structure
            return view('readbarcode', $data);
        }
    }