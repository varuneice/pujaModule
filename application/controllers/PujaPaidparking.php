<?php

require_once CONTROLLERS_PATH . 'App.php';

class PujaPaidparking extends App {

    var $option_arr = null;
    var $layout = 'admin';

    function beforeFilter() {

        GzObject::loadFiles('Model', 'Option');
        $OptionModel = new OptionModel();
        $this->option_arr = $OptionModel->getAllPairValues();
        $this->tpl['option_arr'] = $OptionModel->getAllPairs();
        $this->tpl['option_arr_values'] = $this->option_arr;

        $this->tpl['js_format'] = Util::getJsDateFormta($this->tpl['option_arr_values']['date_format']);
        $this->tpl['iso_format'] = Util::getISODateFormta($this->tpl['option_arr_values']['date_format']);

        date_default_timezone_set($this->tpl['option_arr_values']['timezone'] ?: 'UTC');
        
         $this->css[] = array('file' => 'admin/gzstyling/bootstrap.min.css', 'path' => CSS_PATH);
         $this->css[] = array('file' => 'admin/gzstyling/font-awesome.min.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'admin/gzstyling/ionicons.min.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'admin/gzstyling/gzstyle.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'admin/gzstyling/daterangepicker/daterangepicker-bs3.css', 'path' => CSS_PATH);
         $this->css[] = array('file' => 'ui-custom.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'admin/admin.css', 'path' => CSS_PATH);
        
        $this->js[] = array('file' => 'jquery/jquery-1.9.1.min.js', 'path' => LIBS_PATH);
        $this->js[] = array('file' => 'gzadmin/bootstrap.min.js', 'path' => JS_PATH);
       // For search dropdown search box 
       $this->css[] = array('file' => 'gzadmin/plugins/bootstrap-select/dist/css/bootstrap-select.min.css', 'path' => JS_PATH);
       $this->js[] = array('file' => 'gzadmin/plugins/bootstrap-select/dist/js/bootstrap-select.min.js', 'path' => JS_PATH);


        $this->js[] = array('file' => 'jquery/jquery-validation-1.13.0/dist/jquery.validate.js', 'path' => LIBS_PATH);
        $this->js[] = array('file' => 'jquery/ui/jquery-ui.min.js', 'path' => LIBS_PATH);

        $this->js[] = array('file' => 'admin.js?v=' . time(), 'path' => JS_PATH);

        $this->js[] = array('file' => '', 'path' => 'https://js.stripe.com/v3/', 'remote' => 1);

        $this->js[] = array('file' => 'Gzpaidparking.js?v=' . time(), 'path' => JS_PATH);
        //$this->js[] = array('file' => 'multiselect-dropdown.js', 'path' => JS_PATH);
        $this->js[] = array('file' => 'loadingoverlay.js?v=' . time(), 'path' => JS_PATH);
        
        
    }



      function PujaPaidparking() {
    // action method — __construct() handles data loading
  }

  function __construct()
    {
        $this->layout = 'login';
        GzObject::loadFiles('Model', array('paidparking', 'ConfirmCode', 'Member', 'idnumbers', 'itemspujasponsor', 'User', 'Donation'));
        $paidparkingModel = new paidparkingModel();
        $DonationModel = new DonationModel();
        $ConfirmCodeModel = new ConfirmCodeModel();
        $MemberModel = new MemberModel();
        $idnumbersModel = new idnumbersModel();
        $itemspujasponsorModel = new itemspujasponsorModel();
        $UserModel = new UserModel();
        
        
         if (!$this->isLoged() && ($_REQUEST['action'] ?? '') != 'login') {

            if (($_REQUEST['action'] ?? '') != 'edit' && ($_REQUEST['action'] ?? '') != 'PujaPaidparking') {
                $_SESSION['err'] = 2;
                Util::redirect(INSTALL_URL . "onlinepujapayments/onlinepujapayments");
            }
        }
        
        
        
        
        
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            unset($_SESSION['puja_benefactor_processed']);
        }

        if (!empty($_POST['create_parkingregistration'])) {
            // if (($_POST['PaymentOption'] ?? '') == null) {
            //     $_POST['status'] = 'pending';
            //      date_default_timezone_set("America/Chicago");
            //     $today = date("Y/m/d");
            //     $_POST['pay_date'] = $today;
            //     $id = $paidparkingModel->save(array_merge($_POST));
            //     if (!empty($id)) {
            //         echo "<div style='text-align: -webkit-center;' class = 'pay'>
            //         <table border='4'  width='585px' style='margin-left:4em;'>
            //         <tr>
            //         <td colspan='2'> <img src='../thankyouscreen.jpg' alt='' height='167px' style='margin-left:12em;'><h1 style='text-align:center;font-family:fangsong; font-size:30px;'><b>Houston Durga Bari Society</b></h1> </td>
            //         <tr><td colspan='2'><span style='font-size: 18px;font-family: serif;'>Your Parking spot request have been submitted.
            //         Registration Team will validate your application and send a confirmation for payment.</span></td></tr>
            //         <tr><td style='width:50%;'>Member Id</td> <td style='width:50%;'>" . ($_POST['Member_id'] ?? '') . "</td> </tr>
            //         <tr><td style='width:50%;'>Member Name</td> <td style='width:50%;'>" . ($_POST['First_name'] ?? '') . ' ' . ($_POST['Last_name'] ?? '') . "</td> </tr>
            //         <tr><td>Puja Type</td> <td>" . ($_POST['puja_type'] ?? '') . "</td> </tr>
            //         <tr><td>Parking Spot</td> <td>" . ($_POST['parkingfield'] ?? '') . "</td> </tr>
            //         <tr><td>Amount Payable</td> <td><span style='color:red;'>$</span>" . ($_POST['amount'] ?? '') . "</td> </tr>
            //         <tr><td>Status</td> <td>Pending</td>  </tr>
            //         <tr><td colspan='2'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>   </tr>
            //         </tr>";
            //         echo "</table>";
            //         echo "<a  href='" . INSTALL_URL . "PujaPaidparking/PujaPaidparking'>Go to home</a>";
            //         echo "</div>";

            //         $Emailcc = 'pujaassocpayment@durgabari.org';
            //         $subjetc = 'Paid Parking Request';
            //         $message = '<p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</p>
            //         <div class="email-token-class" style="text-align: justify;">
            //         <div class="email-token-class" style="text-align: center;">
            //         <div class="email-token-class" style="text-align: center;">
            //         <table style="height: 77px; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;" width="606">
            //         <tbody>
            //         <tr>
            //         <td style="text-align: center; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;"><img src="' . INSTALL_URL . 'application/web/upload/image/create.png" alt="" width="396" height="66" /></td>
            //         </tr>
            //         </tbody>
            //         </table>
            //         </div>
            //         <div class="email-token-class" style="text-align: center;">
            //         <table style="height: 22px; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;" width="604">
            //         <tbody>
            //         <tr>
            //         <td style="text-align: center; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;"><strong>Paid Parking Details</strong></td>
            //         </tr>
            //         </tbody>
            //         </table>
            //         </div>
            //         <div class="email-token-class" style="text-align: center;">
            //         <table style="height: 190px; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;" width="604">
            //         <tbody>
            //         <tr>
            //         <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Member Id&nbsp;&nbsp;</td>
            //         <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">' . ($_POST['Member_id'] ?? '') . '</td>
            //         </tr>
            //         <tr>
            //         <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Member Name&nbsp;&nbsp;</td>
            //         <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . ($_POST['First_name'] ?? '') . " " . ($_POST['Last_name'] ?? '') . '</td>
            //         </tr>
            //         <tr>
            //         <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Puja Type &nbsp;</td>
            //         <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . ($_POST['puja_type'] ?? '') . '</td>
            //         </tr>
            //         <tr>
            //         <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Parking Spot &nbsp;</td>
            //         <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . ($_POST['parkingfield'] ?? '') . '</td>
            //         </tr>
            //         <tr>
            //         <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Amount Payable&nbsp;&nbsp;</td>
            //         <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;"><span style="color:red;">$</span>' . ($_POST['amount'] ?? '') . '</td>
            //         </tr>
            //         </tbody>
            //         </table>
            //         </div>
            //         </div>
            //         </div>';
            //         $email = $_POST['email'] ?? '';
            //         if ($email != null) {
            //             $this->sendEmailticket($message, $subjetc, $email, $Emailcc);
            //         }
            //         $mobileno = $_POST['alternatenumber'] ?? '';
            //         if ($mobileno != null) {
            //             $msg = 'Your Parking request have been submitted  Member Id: ' . ($_POST['Member_id'] ?? '') . ', Member Name: ' . ($_POST['First_name'] ?? '') . " " . ($_POST['Last_name'] ?? '') . ', Puja Type: ' . ($_POST['puja_type'] ?? '') . ', Parking Spot: $' . ($_POST['parkingfield'] ?? '') . ' , Amount Payable: $' . ($_POST['amount'] ?? '');
            //              $this->SendSMS($mobileno, $msg);
            //         }
            //     }
            //     exit();

            // } 
            
             if (isset($_SESSION['puja_benefactor_processed']) && $_SESSION['puja_benefactor_processed'] === true) {
                unset($_SESSION['puja_benefactor_processed']);
                Util::redirect(INSTALL_URL . "PujaPaidparking/PujaPaidparking");
                exit();
            }
            
             if (($_POST['PaymentOption'] ?? '') == null) {
                $_POST['status'] = 'pending';
                date_default_timezone_set("America/Chicago");
                $today = date("Y/m/d");
                $_POST['pay_date'] = $today;
                unset($_POST['update_on']); // let DB use CURRENT_TIMESTAMP default
                $id = $paidparkingModel->save(array_merge($_POST));
                if (!empty($id)) {
                    echo "<div style='text-align: -webkit-center;' class = 'pay'>
                    <table border='4'  width='585px' style='margin-left:4em;'>
                    <tr>
                    <td colspan='2'> <img src='../thankyouscreen.jpg' alt='' height='167px' style='margin-left:12em;'><h1 style='text-align:center;font-family:fangsong; font-size:30px;'><b>Houston Durga Bari Society</b></h1> </td>
                    <tr><td colspan='2'><span style='font-size: 18px;font-family: serif;'>Your Puja Benefactor request has been submitted. Your application has been added to a queue. Registration Team will validate your application and send a confirmation for payment subject to parking spot availability as per a priority order.</span></td></tr>
                    <tr><td style='width:50%;'>Member Id</td> <td style='width:50%;'>" . ($_POST['Member_id'] ?? '') . "</td> </tr>
                    <tr><td style='width:50%;'>Member Name</td> <td style='width:50%;'>" . ($_POST['First_name'] ?? '') . ' ' . ($_POST['Last_name'] ?? '') . "</td> </tr>
                    
                    <tr><td>Amount Payable</td> <td><span style='color:red;'>$</span>" . ($_POST['amount'] ?? '') . "</td> </tr>
                    <tr><td>Status</td> <td>Pending</td>  </tr>
                    <tr><td colspan='2'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>   </tr>
                    </tr>";
                    echo "</table>";
                    echo "<a  href='" . INSTALL_URL . "PujaPaidparking/PujaPaidparking'>Go to home</a>";
                    echo "</div>";

                    $Emailcc = 'pujaassocpayment@durgabari.org';
                    $subjetc = 'Puja Benefactor Request';
                    $message = '<p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</p>
                    <div class="email-token-class" style="text-align: justify;">
                    <div class="email-token-class" style="text-align: center;">
                    <div class="email-token-class" style="text-align: center;">
                    <table style="height: 77px; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;" width="606">
                    <tbody>
                    <tr>
                    <td style="text-align: center; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;"><img src="' . INSTALL_URL . 'application/web/upload/image/create.png" alt="" width="396" height="66" /></td>
                    </tr>
                    </tbody>
                    </table>
                    </div>
                    <div class="email-token-class" style="text-align: center;">
                    <table style="height: 22px; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;" width="604">
                    <tbody>
                    <tr>
                    <td style="text-align: center; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;"><strong>Paid Parking Details</strong></td>
                    </tr>
                    </tbody>
                    </table>
                    </div>
                    <div class="email-token-class" style="text-align: center;">
                    <table style="height: 190px; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;" width="604">
                    <tbody>
                    <tr>
                    <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Member Id&nbsp;&nbsp;</td>
                    <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">' . ($_POST['Member_id'] ?? '') . '</td>
                    </tr>
                    <tr>
                    <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Member Name&nbsp;&nbsp;</td>
                    <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . ($_POST['First_name'] ?? '') . " " . ($_POST['Last_name'] ?? '') . '</td>
                    </tr>
                    <tr>
                    <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Puja Type &nbsp;</td>
                    <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . ($_POST['puja_type'] ?? '') . '</td>
                    </tr>
                    
                    <tr>
                    <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Amount Payable&nbsp;&nbsp;</td>
                    <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;"><span style="color:red;">$</span>' . ($_POST['amount'] ?? '') . '</td>
                    </tr>
                    </tbody>
                    </table>
                    </div>
                    </div>
                    </div>';
                    $email = $_POST['email'] ?? '';
                    if ($email != null) {
                        $this->sendEmailticket($message, $subjetc, $email, $Emailcc);
                    }
                    $mobileno = $_POST['alternatenumber'] ?? '';
                    if ($mobileno != null) {
                        // $msg = 'Your Parking request have been submitted  Member Id: ' . ($_POST['Member_id'] ?? '') . ', Member Name: ' . ($_POST['First_name'] ?? '') . " " . ($_POST['Last_name'] ?? '') . ', Puja Type: ' . ($_POST['puja_type'] ?? '') . ', Parking Spot: $' . ($_POST['parkingfield'] ?? '') . ' , Amount Payable: $' . ($_POST['amount'] ?? '');
                        $msg = 'Your Parking request have been submitted  Member Id: ' . ($_POST['Member_id'] ?? '') . 
       ', Member Name: ' . ($_POST['First_name'] ?? '') . " " . ($_POST['Last_name'] ?? '') . 
       ', Puja Type: ' . ($_POST['puja_type'] ?? '') . 
       ', Amount Payable: $' . ($_POST['amount'] ?? '');

                        
                        $this->SendSMS($mobileno, $msg);
                    }
                } 
                $_SESSION['puja_benefactor_processed'] = true;
                exit();

            } 
            
            
            
            else {

                // if (!empty($_POST['create_donation'])) {

                $data = array();
                date_default_timezone_set("America/Chicago");
                date_default_timezone_set("America/Chicago");
                $today = date("Y/m/d");
                $_POST['pay_date'] = $today;
                $_POST['paytype'] = 'donation';
                $_POST['pay_type'] = 'Donation';
                $_POST['pay_for'] = 'DONATION / Unrestricted';
                $_POST['paymentfor'] = 'Puja Benefactor';

                // for generate oid 
                $maxoid = $idnumbersModel->getMaxoid() + 1;
                $update_oid = $idnumbersModel->Updateoid($maxoid);
                $_POST['oid'] = $maxoid;
                // end generate oid for 
                $datamember = $MemberModel->rentalmemberduplicate();
                if ($datamember == null) {
                    // for generate memberid for gd
                    $maxid = $idnumbersModel->getMaxmid() + 1;
                    $update_mid = $idnumbersModel->Updatemid($maxid);
                    $_POST['Member_id'] = $maxid;
                    // end generate memberid for gd 
                }
                if ($datamember != null) {
                    $_POST['Member_id'] = $datamember;
                }
                $registermember = $_POST['MemberName'] ?? '';
                $regmember = $_POST['regmember'] ?? '';
                if ($regmember == "nonmember") {
                    $nonmember = $_POST['namenonmember'] ?? '';
                    $_POST['MemberName'] = $nonmember;
                } else {

                    $_POST['MemberName'] = $registermember;
                    // $memberid = $_POST['demmember'] ?? ''; 
                    // $_POST['Member_id'] = $memberid;
                }

                if ($this->isAdmin() || $this->isEditor()) {
                    $id = $this->getUserId();
                    $admin = $UserModel->get($id);
                    $rolename = $admin['first'] . ' ' . $admin['last'];
                    $_POST['admin_id'] = $admin['id'];
                    $_POST['admin_name'] = $rolename;

                }

                $id = $paidparkingModel->save(array_merge($_POST));
                if (!empty($id)) {
                    // for email ui 
                    $memberid = $_POST['Member_id'] ?? '';
                    $mebername = ($_POST['First_name'] ?? '') . ' ' . ($_POST['Last_name'] ?? '');
                    $oid = $_POST['oid'] ?? '';
                    $amount = $_POST['amount'] ?? '';
                    $parkingspot = $_POST['parkingfield'] ?? '';
                    $paymethod = $_POST['PaymentOption'] ?? '';
                    if ($paymethod == "others") {
                        $payui = 'Zelle';
                    } else if ($paymethod == "check") {
                        $payui = 'Check';
                    } else if ($paymethod == "cash") {
                        $payui = 'Cash';
                    } else if ($paymethod == "directdeposit") {
                        $payui = 'Online Deposit';
                    } else if ($paymethod == "sumup") {
                        $payui = 'SumUp';
                    } else if ($paymethod == "zelleProxy") {
                        $payui = 'Zelle Proxy';
                    } else if ($paymethod == "stripe") {
                        $payui = 'Credit Card';
                    }
                    $datefor = $_POST['pay_date'] ?? '';
                    $timestamp = !empty($datefor) ? strtotime($datefor) : false;
                    $payfinaldate = $timestamp ? date("m/d/Y", $timestamp) : '';
                    $subjetc = 'HDBS Paid Parking Payment Confirmation';
                    $Emailcc = 'pujaassocpayment@durgabari.org';
                    $message = '<p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</p>
                    <div class="email-token-class" style="text-align: justify;">
                    <div class="email-token-class" style="text-align: center;">
                    <div class="email-token-class" style="text-align: center;">
                    <table style="height: 77px; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;" width="606">
                    <tbody>
                    <tr>
                    <td style="text-align: center; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;"><img src="' . INSTALL_URL . 'application/web/upload/image/create.png" alt="" width="396" height="66" /></td>
                    </tr>
                    </tbody>
                    </table>
                    </div>
                    <div class="email-token-class" style="text-align: center;">
                    <table style="height: 22px; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;" width="604">
                    <tbody>
                    <tr>
                    <td style="text-align: center; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;"><strong>Paid Parking Registration Confirmation</strong></td>
                    </tr>
                    </tbody>
                    </table>
                    </div>
                    <div class="email-token-class" style="text-align: center;">
                    <table style="height: 190px; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;" width="604">
                    <tbody>
                    <tr>
                    <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Order Id&nbsp;&nbsp;</td>
                    <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $oid . '</td>
                    </tr>
                    <tr>
                    <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Member Id&nbsp;&nbsp;</td>
                    <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $memberid . '</td>
                    </tr>
                    <tr>
                    <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Member Name&nbsp;&nbsp;</td>
                    <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">' . $mebername . '</td>
                    </tr>
                    <tr>
                    <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Parking Spot&nbsp;&nbsp;</td>
                    <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $parkingspot . '</td>
                    </tr>
                    <tr>
                    <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Amount&nbsp;&nbsp;</td>
                    <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;"><span style="color:red;">$</span>' . $amount . '</td>
                    </tr>
                    <tr>
                    <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Payment Method&nbsp;&nbsp;</td>
                    <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $payui . '</td>
                    </tr>
                    <tr>
                    <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Pay Date&nbsp;&nbsp;</td>
                    <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $payfinaldate . '</td>
                    </tr>
                   </tbody>
                    </table>
                    </div>
                    </div>
                    </div>';

                    //commom msg after payment.
                    $textmsg = 'Houston Durga Bari: Paid Parking Confirmation are Member Id: ' . $memberid . ', Order Id: ' . $oid . ', Member Name: ' . $mebername . ', Parking Spot: ' . $parkingspot . ',  Amount: $' . $amount . ' , Payment Method: ' . $payui . ' , Pay Date: ' . $payfinaldate;

                    if (($_POST['PaymentOption'] ?? '') == 'others') {

                        $opts = array();
                        $oid = $_POST['oid'] ?? '';
                        $cmCode = $_POST['code'] ?? '';
                        $isAvailable = $ConfirmCodeModel->ConfirmCheckCode($cmCode);
                        if(!$isAvailable)
                        {
                          Util::redirect(INSTALL_URL . "onlinepujapayments/onlinepujapayments");
                          exit();
                        }
                        $arr = $ConfirmCodeModel->UpdateCode($cmCode);
                        $_POST['transaction_id'] = $cmCode;
                        $opts['Confirmation'] = $_POST['confirm_code'] ?? '';
                        $arr = $ConfirmCodeModel->getAll($opts);
                        if ($oid != null) {
                            //if (!empty($arr[0])) {
                            $opts = array();
                            $opts['id'] = $id;
                            $opts['payment_status'] = 'confirmed';
                            $_POST['status'] = 'confirmed';
                            $data = $_POST;
                            $datamemberarr = array();
                            $datamemberarr = array_merge($opts, $_POST);
                            $paidparkingModel->update(array_merge($opts, $_POST));

                            $value = array();
                            $value['oid'] = $datamemberarr['oid'];
                            $value['Member_id'] = $datamemberarr['Member_id'];
                            $value['MemberName'] = $datamemberarr['First_name'] . ' ' . $datamemberarr['Last_name'];
                            $value['PaymentOption'] = $datamemberarr['PaymentOption'];
                            $value['payment_status'] = 'succeeded';
                            $value['payment_timestamp'] = $datamemberarr['payment_timestamp'] ?? '';
                            $value['Amount'] = $datamemberarr['amount'];
                            $value['stripe_return'] = $datamemberarr['stripe_return'] ?? '';
                            $value['transaction_id'] = $datamemberarr['transaction_id'];
                            $value['paid_amount'] = $datamemberarr['paid_amount'] ?? '';
                            $value['update_on'] = $datamemberarr['UpdateOn'];
                            $value['stripe_product'] = $datamemberarr['stripe_product'] ?? '';
                            $value['pay_date'] = $datamemberarr['pay_date'];
                            $value['pay_type'] = 'Donation';
                            $value['pay_for'] = 'DONATION / Unrestricted';
                            $value['paymentfor'] = 'Puja Benefactor';
                            $value['Tele1'] = $datamemberarr['phone'];
                            $value['email'] = $datamemberarr['email'];
                            $value['spousename'] = $datamemberarr['Sp_fname'] . ' ' . $datamemberarr['Sp_lname'];
                            $value['Address'] = $datamemberarr['streetname'];
                            $value['Street'] = $datamemberarr['street'];
                            $value['City'] = $datamemberarr['city'];
                            $value['State'] = $datamemberarr['state'];
                            $value['Zip_Code'] = $datamemberarr['zip'];
                            $value['admin_id'] = $datamemberarr['admin_id'];
                            $value['admin_name'] = $datamemberarr['admin_name'];
                            $DonationModel->SaveDataInDonation($value);

                            $email = $_POST['email'] ?? '';
                            if ($email != null) {
                                $this->sendEmailticket($message, $subjetc, $email, $Emailcc);
                            }
                            $mobileno = $_POST['alternatenumber'] ?? '';
                            if ($mobileno != null) {
                                $this->SendSMS($mobileno, $textmsg );
                            }
                            $memberid = $_POST['Member_id'] ?? '';
                            $mebername = ($_POST['First_name'] ?? '') . ' ' . ($_POST['Last_name'] ?? '');
                            $oid = $_POST['oid'] ?? '';
                            $amount = $_POST['amount'] ?? '';
                            $parkingspot = $_POST['parkingfield'] ?? '';
                            $datefor = $_POST['pay_date'] ?? '';
                            $pujatype = $_POST['puja_type'] ?? '';
                            $timestamp = !empty($datefor) ? strtotime($datefor) : false;
                            $payfinaldate = $timestamp ? date("m/d/Y", $timestamp) : '';

                            echo "<div style='text-align: -webkit-center;' class = 'pay'>
                                <table border='4' width='585px'>
                                <tr>
                                <td colspan='2'> <img src='../thankyouscreen.jpg' alt='' height='167px' style='margin-left:12em;'><h1 style='text-align:center;font-family:fangsong; font-size:30px;'><b>Houston Durga Bari Society</b></h1> </td> </tr>
                                 <tr><td style='width:50%;'>Order Id</td> <td style='width:50%;'>" . $oid . "</td> </tr>
                                 <tr><td>Member Id</td> <td>" . $memberid . "</td> </tr>
                                 <tr><td>Member Name</td> <td>" . $mebername . "</td> </tr>
                                 <tr><td>Puja Type</td> <td>" . $pujatype . "</td> </tr> 
                                 <tr><td>Parking Spot</td> <td>" . $parkingspot . "</td></tr>
                                 <tr><td>Amount</td> <td><span style='color:red;'>$</span>" . $amount . "</td> </tr>
                                 <tr><td>Payment Method</td> <td>Zelle</td>  </tr>
                                 <tr><td>Payment Status</td> <td>Confirmed</td>  </tr>
                                 <tr><td>Pay Date</td> <td>" . $payfinaldate . "</td>  </tr>
                                 <tr><td colspan='2' style='font-weight: bold;color:red;'>An email with your payment information has been sent to your registered email address. Please check your spam folder if you cannot find the email in your inbox</td></tr>
                                 <tr><td colspan='2'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>   </tr>
                                 </tr>";
                            echo "</table>";
                            if ($this->isAdmin() || $this->isEditor()) {
                                echo " <a href='" . INSTALL_URL . "parkingadmin/index'>Go to home</a>";
                                // echo " <a href='http://localhost:8082/14june/Ticketadmin/index'>Go to home</a>";
                            }
                            echo "</div>";
                            //$this->tpl['arr'] = $DonationModel->get($id);
                             $_SESSION['puja_benefactor_processed'] = true;
                            exit();
                        }
                    } // check
                    elseif (($_POST['PaymentOption'] ?? '') == 'check') {
                        $_POST['amount'] = $_POST['checkAmount'] ?? '';
                        $_POST['bank'] = $_POST['checkbankname'] ?? '';
                        $_POST['chkdate'] = $_POST['CheckDate'] ?? '';
                        $_POST['payment_status'] = 'confirmed';
                        $_POST['status'] = 'confirmed';
                        $_POST['DepositAccount'] = $_POST['CheckDepositAccount'] ?? '';
                        $_POST['id'] = $id;
                        $data = $_POST;
                        $datamemberarr = array();
                        $datamemberarr = array_merge($_POST);
                        $paidparkingModel->update(array_merge($_POST));

                        $value = array();
                        $value['oid'] = $datamemberarr['oid'];
                        $value['Member_id'] = $datamemberarr['Member_id'];
                        $value['MemberName'] = $datamemberarr['First_name'] . ' ' . $datamemberarr['Last_name'];
                        $value['PaymentOption'] = $datamemberarr['PaymentOption'];
                        $value['payment_status'] = 'succeeded';
                        $value['payment_timestamp'] = $datamemberarr['payment_timestamp'] ?? '';
                        $value['Amount'] = $datamemberarr['amount'];
                        $value['stripe_return'] = $datamemberarr['stripe_return'] ?? '';
                        $value['transaction_id'] = $datamemberarr['transaction_id'];
                        $value['paid_amount'] = $datamemberarr['paid_amount'] ?? '';
                        $value['update_on'] = $datamemberarr['UpdateOn'];
                        $value['stripe_product'] = $datamemberarr['stripe_product'] ?? '';
                        $value['pay_date'] = $datamemberarr['pay_date'];
                        $value['pay_type'] = 'Donation';
                        $value['pay_for'] = 'DONATION / Unrestricted';
                        $value['paymentfor'] = 'Puja Benefactor';
                        $value['Tele1'] = $datamemberarr['phone'];
                        $value['email'] = $datamemberarr['email'];
                        $value['spousename'] = $datamemberarr['Sp_fname'] . ' ' . $datamemberarr['Sp_lname'];
                        $value['Address'] = $datamemberarr['streetname'];
                        $value['Street'] = $datamemberarr['street'];
                        $value['City'] = $datamemberarr['city'];
                        $value['State'] = $datamemberarr['state'];
                        $value['Zip_Code'] = $datamemberarr['zip'];
                        $value['admin_id'] = $datamemberarr['admin_id'];
                        $value['admin_name'] = $datamemberarr['admin_name'];
                        $value['DepositAccount'] = $datamemberarr['DepositAccount'];
                        $DonationModel->SaveDataInDonation($value);
                        $email = $_POST['email'] ?? '';
                        if ($email != null) {
                            $this->sendEmailticket($message, $subjetc, $email, $Emailcc);
                        }
                        $mobileno = $_POST['alternatenumber'] ?? '';
                        if ($mobileno != null) {
                            $this->SendSMS($mobileno, $textmsg );
                        }

                        $memberid = $_POST['Member_id'] ?? '';
                        $mebername = ($_POST['First_name'] ?? '') . ' ' . ($_POST['Last_name'] ?? '');
                        $oid = $_POST['oid'] ?? '';
                        $amount = $_POST['amount'] ?? '';
                        $parkingspot = $_POST['parkingfield'] ?? '';
                        $datefor = $_POST['pay_date'] ?? '';
                        $pujatype = $_POST['puja_type'] ?? '';
                        $timestamp = !empty($datefor) ? strtotime($datefor) : false;
                        $payfinaldate = $timestamp ? date("m/d/Y", $timestamp) : '';

                        echo "<div style='text-align: -webkit-center;' class = 'pay'>
                    <table border='4' width='585px'>
                    <tr>
                    <td colspan='2'> <img src='../thankyouscreen.jpg' alt='' height='167px' style='margin-left:12em;'><h1 style='text-align:center;font-family:fangsong; font-size:30px;'><b>Houston Durga Bari Society</b></h1> </td> </tr>
                     <tr><td style='width:50%;'>Order Id</td> <td style='width:50%;'>" . $oid . "</td> </tr>
                     <tr><td>Member Id</td> <td>" . $memberid . "</td> </tr>
                     <tr><td>Member Name</td> <td>" . $mebername . "</td> </tr>
                     <tr><td>Puja Type</td> <td>" . $pujatype . "</td> </tr> 
                     <tr><td>Parking Spot</td> <td>" . $parkingspot . "</td></tr>
                     <tr><td>Amount</td> <td><span style='color:red;'>$</span>" . $amount . "</td> </tr>
                     <tr><td>Payment Method</td> <td>check</td>  </tr>
                     <tr><td>Payment Status</td> <td>Confirmed</td>  </tr>
                     <tr><td>Pay Date</td> <td>" . $payfinaldate . "</td>  </tr>
                     <tr><td colspan='2' style='font-weight: bold;color:red;'>An email with your payment information has been sent to your registered email address. Please check your spam folder if you cannot find the email in your inbox</td></tr>
                     <tr><td colspan='2'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>   </tr>
                     </tr>";
                        echo "</table>";
                        if ($this->isAdmin() || $this->isEditor()) {
                            echo " <a href='" . INSTALL_URL . "parkingadmin/index'>Go to home</a>";
                            // echo " <a href='http://localhost:8082/14june/Ticketadmin/index'>Go to home</a>";
                        }
                        echo "</div>";
                         $_SESSION['puja_benefactor_processed'] = true;

                        exit();
                    }
                    // cash
                    elseif (($_POST['PaymentOption'] ?? '') == 'cash') {
                        $_POST['amount'] = $_POST['cashAmount'] ?? '';
                        $_POST['pay_date'] = $_POST['cashDate'] ?? '';
                        $_POST['payment_status'] = 'confirmed';
                        $_POST['status'] = 'confirmed';
                        $_POST['DepositAccount'] = $_POST['CashDepositAccount'] ?? '';
                        $_POST['id'] = $id;
                        $data = $_POST;
                        $datamemberarr = array();
                        $datamemberarr = array_merge($_POST);
                        $paidparkingModel->update(array_merge($_POST));

                        $value = array();
                        $value['oid'] = $datamemberarr['oid'];
                        $value['Member_id'] = $datamemberarr['Member_id'];
                        $value['MemberName'] = $datamemberarr['First_name'] . ' ' . $datamemberarr['Last_name'];
                        $value['PaymentOption'] = $datamemberarr['PaymentOption'];
                        $value['payment_status'] = 'succeeded';
                        $value['payment_timestamp'] = $datamemberarr['payment_timestamp'] ?? '';
                        $value['Amount'] = $datamemberarr['amount'];
                        $value['stripe_return'] = $datamemberarr['stripe_return'] ?? '';
                        $value['transaction_id'] = $datamemberarr['transaction_id'];
                        $value['paid_amount'] = $datamemberarr['paid_amount'] ?? '';
                        $value['update_on'] = $datamemberarr['UpdateOn'];
                        $value['stripe_product'] = $datamemberarr['stripe_product'] ?? '';
                        $value['pay_date'] = $datamemberarr['pay_date'];
                        $value['pay_type'] = 'Donation';
                        $value['pay_for'] = 'DONATION / Unrestricted';
                        $value['paymentfor'] = 'Puja Benefactor';
                        $value['Tele1'] = $datamemberarr['phone'];
                        $value['email'] = $datamemberarr['email'];
                        $value['spousename'] = $datamemberarr['Sp_fname'] . ' ' . $datamemberarr['Sp_lname'];
                        $value['Address'] = $datamemberarr['streetname'];
                        $value['Street'] = $datamemberarr['street'];
                        $value['City'] = $datamemberarr['city'];
                        $value['State'] = $datamemberarr['state'];
                        $value['Zip_Code'] = $datamemberarr['zip'];
                        $value['admin_id'] = $datamemberarr['admin_id'];
                        $value['admin_name'] = $datamemberarr['admin_name'];
                        $value['DepositAccount'] = $datamemberarr['DepositAccount'];
                        $DonationModel->SaveDataInDonation($value);
                        $email = $_POST['email'] ?? '';
                        if ($email != null) {
                            $this->sendEmailticket($message, $subjetc, $email, $Emailcc);
                        }
                        $mobileno = $_POST['alternatenumber'] ?? '';
                        if ($mobileno != null) {
                            $this->SendSMS($mobileno, $textmsg );
                        }

                        $memberid = $_POST['Member_id'] ?? '';
                        $mebername = ($_POST['First_name'] ?? '') . ' ' . ($_POST['Last_name'] ?? '');
                        $oid = $_POST['oid'] ?? '';
                        $amount = $_POST['amount'] ?? '';
                        $parkingspot = $_POST['parkingfield'] ?? '';
                        $datefor = $_POST['pay_date'] ?? '';
                        $pujatype = $_POST['puja_type'] ?? '';
                        $timestamp = !empty($datefor) ? strtotime($datefor) : false;
                        $payfinaldate = $timestamp ? date("m/d/Y", $timestamp) : '';

                        echo "<div style='text-align: -webkit-center;' class = 'pay'>
                    <table border='4' width='585px'>
                    <tr>
                    <td colspan='2'> <img src='../thankyouscreen.jpg' alt='' height='167px' style='margin-left:12em;'><h1 style='text-align:center;font-family:fangsong; font-size:30px;'><b>Houston Durga Bari Society</b></h1> </td> </tr>
                     <tr><td style='width:50%;'>Order Id</td> <td style='width:50%;'>" . $oid . "</td> </tr>
                     <tr><td>Member Id</td> <td>" . $memberid . "</td> </tr>
                     <tr><td>Member Name</td> <td>" . $mebername . "</td> </tr>
                     <tr><td>Puja Type</td> <td>" . $pujatype . "</td> </tr> 
                     <tr><td>Parking Spot</td> <td>" . $parkingspot . "</td></tr>
                     <tr><td>Amount</td> <td><span style='color:red;'>$</span>" . $amount . "</td> </tr>
                     <tr><td>Payment Method</td> <td>Cash</td>  </tr>
                     <tr><td>Payment Status</td> <td>Confirmed</td>  </tr>
                     <tr><td>Pay Date</td> <td>" . $payfinaldate . "</td>  </tr>
                     <tr><td colspan='2' style='font-weight: bold;color:red;'>An email with your payment information has been sent to your registered email address. Please check your spam folder if you cannot find the email in your inbox</td></tr>
                     <tr><td colspan='2'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>   </tr>
                     </tr>";
                        echo "</table>";
                        if ($this->isAdmin() || $this->isEditor()) {
                            echo " <a href='" . INSTALL_URL . "parkingadmin/index'>Go to home</a>";
                            // echo " <a href='http://localhost:8082/14june/Ticketadmin/index'>Go to home</a>";
                        }
                        echo "</div>";
                         $_SESSION['puja_benefactor_processed'] = true;

                        exit();
                    }

                    // directdeposite
                    elseif (($_POST['PaymentOption'] ?? '') == 'directdeposit') {
                        $_POST['bank'] = $_POST['directbank'] ?? '';
                        $_POST['transaction_id'] = $_POST['transactioncode'] ?? '';
                        $_POST['amount'] = $_POST['directdepositeamount'] ?? '';
                        $_POST['pay_date'] = $_POST['transactiondate'] ?? '';
                        $_POST['payment_status'] = 'confirmed';
                        $_POST['status'] = 'confirmed';
                        $_POST['DepositAccount'] = $_POST['DirectPayDepositAccount'] ?? '';
                        $_POST['id'] = $id;
                        $data = $_POST;
                        $datamemberarr = array();
                        $datamemberarr = array_merge($_POST);
                        $paidparkingModel->update(array_merge($_POST));

                        $value = array();
                        $value['oid'] = $datamemberarr['oid'];
                        $value['Member_id'] = $datamemberarr['Member_id'];
                        $value['MemberName'] = $datamemberarr['First_name'] . ' ' . $datamemberarr['Last_name'];
                        $value['PaymentOption'] = $datamemberarr['PaymentOption'];
                        $value['payment_status'] = 'succeeded';
                        $value['payment_timestamp'] = $datamemberarr['payment_timestamp'] ?? '';
                        $value['Amount'] = $datamemberarr['amount'];
                        $value['stripe_return'] = $datamemberarr['stripe_return'] ?? '';
                        $value['transaction_id'] = $datamemberarr['transaction_id'];
                        $value['paid_amount'] = $datamemberarr['paid_amount'] ?? '';
                        $value['update_on'] = $datamemberarr['UpdateOn'];
                        $value['stripe_product'] = $datamemberarr['stripe_product'] ?? '';
                        $value['pay_date'] = $datamemberarr['pay_date'];
                        $value['pay_type'] = 'Donation';
                        $value['pay_for'] = 'DONATION / Unrestricted';
                        $value['paymentfor'] = 'Puja Benefactor';
                        $value['Tele1'] = $datamemberarr['phone'];
                        $value['email'] = $datamemberarr['email'];
                        $value['spousename'] = $datamemberarr['Sp_fname'] . ' ' . $datamemberarr['Sp_lname'];
                        $value['Address'] = $datamemberarr['streetname'];
                        $value['Street'] = $datamemberarr['street'];
                        $value['City'] = $datamemberarr['city'];
                        $value['State'] = $datamemberarr['state'];
                        $value['Zip_Code'] = $datamemberarr['zip'];
                        $value['admin_id'] = $datamemberarr['admin_id'];
                        $value['admin_name'] = $datamemberarr['admin_name'];
                        $value['DepositAccount'] = $datamemberarr['DepositAccount'];
                        $DonationModel->SaveDataInDonation($value);
                        $email = $_POST['email'] ?? '';
                        if ($email != null) {
                            $this->sendEmailticket($message, $subjetc, $email, $Emailcc);
                        }
                        $mobileno = $_POST['alternatenumber'] ?? '';
                        if ($mobileno != null) {
                            $this->SendSMS($mobileno, $textmsg );
                        }

                        $memberid = $_POST['Member_id'] ?? '';
                        $mebername = ($_POST['First_name'] ?? '') . ' ' . ($_POST['Last_name'] ?? '');
                        $oid = $_POST['oid'] ?? '';
                        $amount = $_POST['amount'] ?? '';
                        $parkingspot = $_POST['parkingfield'] ?? '';
                        $datefor = $_POST['pay_date'] ?? '';
                        $pujatype = $_POST['puja_type'] ?? '';
                        $timestamp = !empty($datefor) ? strtotime($datefor) : false;
                        $payfinaldate = $timestamp ? date("m/d/Y", $timestamp) : '';

                        echo "<div style='text-align: -webkit-center;' class = 'pay'>
                    <table border='4' width='585px'>
                    <tr>
                    <td colspan='2'> <img src='../thankyouscreen.jpg' alt='' height='167px' style='margin-left:12em;'><h1 style='text-align:center;font-family:fangsong; font-size:30px;'><b>Houston Durga Bari Society</b></h1> </td> </tr>
                     <tr><td style='width:50%;'>Order Id</td> <td style='width:50%;'>" . $oid . "</td> </tr>
                     <tr><td>Member Id</td> <td>" . $memberid . "</td> </tr>
                     <tr><td>Member Name</td> <td>" . $mebername . "</td> </tr>
                     <tr><td>Puja Type</td> <td>" . $pujatype . "</td> </tr> 
                     <tr><td>Parking Spot</td> <td>" . $parkingspot . "</td></tr>
                     <tr><td>Amount</td> <td><span style='color:red;'>$</span>" . $amount . "</td> </tr>
                     <tr><td>Payment Method</td> <td>directdeposit</td>  </tr>
                     <tr><td>Payment Status</td> <td>Confirmed</td>  </tr>
                     <tr><td>Pay Date</td> <td>" . $payfinaldate . "</td>  </tr>
                     <tr><td colspan='2' style='font-weight: bold;color:red;'>An email with your payment information has been sent to your registered email address. Please check your spam folder if you cannot find the email in your inbox</td></tr>
                     <tr><td colspan='2'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>   </tr>
                     </tr>";
                        echo "</table>";
                        if ($this->isAdmin() || $this->isEditor()) {
                            echo " <a href='" . INSTALL_URL . "parkingadmin/index'>Go to home</a>";
                            // echo " <a href='http://localhost:8082/14june/Ticketadmin/index'>Go to home</a>";
                        }
                        echo "</div>";
                         $_SESSION['puja_benefactor_processed'] = true;

                        exit();
                    }
                    // sumup
                    elseif (($_POST['PaymentOption'] ?? '') == 'sumup') {
                        $_POST['amount'] = $_POST['sumupamount'] ?? '';
                        $_POST['transaction_id'] = $_POST['sumupid'] ?? '';
                        $_POST['pay_date'] = $_POST['sumupdate'] ?? '';
                        $_POST['payment_status'] = 'confirmed';
                        $_POST['status'] = 'confirmed';
                        $_POST['DepositAccount'] = $_POST['SumUpDepositAccount'] ?? '';
                        $_POST['id'] = $id;
                        $data = $_POST;
                        $datamemberarr = array();
                        $datamemberarr = array_merge($_POST);
                        $paidparkingModel->update(array_merge($_POST));

                        $value = array();
                        $value['oid'] = $datamemberarr['oid'];
                        $value['Member_id'] = $datamemberarr['Member_id'];
                        $value['MemberName'] = $datamemberarr['First_name'] . ' ' . $datamemberarr['Last_name'];
                        $value['PaymentOption'] = $datamemberarr['PaymentOption'];
                        $value['payment_status'] = 'succeeded';
                        $value['payment_timestamp'] = $datamemberarr['payment_timestamp'] ?? '';
                        $value['Amount'] = $datamemberarr['amount'];
                        $value['stripe_return'] = $datamemberarr['stripe_return'] ?? '';
                        $value['transaction_id'] = $datamemberarr['transaction_id'];
                        $value['paid_amount'] = $datamemberarr['paid_amount'] ?? '';
                        $value['update_on'] = $datamemberarr['UpdateOn'];
                        $value['stripe_product'] = $datamemberarr['stripe_product'] ?? '';
                        $value['pay_date'] = $datamemberarr['pay_date'];
                        $value['pay_type'] = 'Donation';
                        $value['pay_for'] = 'DONATION / Unrestricted';
                        $value['paymentfor'] = 'Puja Benefactor';
                        $value['Tele1'] = $datamemberarr['phone'];
                        $value['email'] = $datamemberarr['email'];
                        $value['spousename'] = $datamemberarr['Sp_fname'] . ' ' . $datamemberarr['Sp_lname'];
                        $value['Address'] = $datamemberarr['streetname'];
                        $value['Street'] = $datamemberarr['street'];
                        $value['City'] = $datamemberarr['city'];
                        $value['State'] = $datamemberarr['state'];
                        $value['Zip_Code'] = $datamemberarr['zip'];
                        $value['admin_id'] = $datamemberarr['admin_id'];
                        $value['admin_name'] = $datamemberarr['admin_name'];
                        $value['DepositAccount'] = $datamemberarr['DepositAccount'];
                        $DonationModel->SaveDataInDonation($value);
                        $email = $_POST['email'] ?? '';
                        if ($email != null) {
                            $this->sendEmailticket($message, $subjetc, $email, $Emailcc);
                        }
                        $mobileno = $_POST['alternatenumber'] ?? '';
                        if ($mobileno != null) {
                            $this->SendSMS($mobileno, $textmsg );
                        }

                        $memberid = $_POST['Member_id'] ?? '';
                        $mebername = ($_POST['First_name'] ?? '') . ' ' . ($_POST['Last_name'] ?? '');
                        $oid = $_POST['oid'] ?? '';
                        $amount = $_POST['amount'] ?? '';
                        $parkingspot = $_POST['parkingfield'] ?? '';
                        $datefor = $_POST['pay_date'] ?? '';
                        $pujatype = $_POST['puja_type'] ?? '';
                        $timestamp = !empty($datefor) ? strtotime($datefor) : false;
                        $payfinaldate = $timestamp ? date("m/d/Y", $timestamp) : '';

                        echo "<div style='text-align: -webkit-center;' class = 'pay'>
                    <table border='4' width='585px'>
                    <tr>
                    <td colspan='2'> <img src='../thankyouscreen.jpg' alt='' height='167px' style='margin-left:12em;'><h1 style='text-align:center;font-family:fangsong; font-size:30px;'><b>Houston Durga Bari Society</b></h1> </td> </tr>
                     <tr><td style='width:50%;'>Order Id</td> <td style='width:50%;'>" . $oid . "</td> </tr>
                     <tr><td>Member Id</td> <td>" . $memberid . "</td> </tr>
                     <tr><td>Member Name</td> <td>" . $mebername . "</td> </tr>
                     <tr><td>Puja Type</td> <td>" . $pujatype . "</td> </tr> 
                     <tr><td>Parking Spot</td> <td>" . $parkingspot . "</td></tr>
                     <tr><td>Amount</td> <td><span style='color:red;'>$</span>" . $amount . "</td> </tr>
                     <tr><td>Payment Method</td> <td>sumup</td>  </tr>
                     <tr><td>Payment Status</td> <td>Confirmed</td>  </tr>
                     <tr><td>Pay Date</td> <td>" . $payfinaldate . "</td>  </tr>
                     <tr><td colspan='2' style='font-weight: bold;color:red;'>An email with your payment information has been sent to your registered email address. Please check your spam folder if you cannot find the email in your inbox</td></tr>
                     <tr><td colspan='2'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>   </tr>
                     </tr>";
                        echo "</table>";
                        if ($this->isAdmin() || $this->isEditor()) {
                            echo " <a href='" . INSTALL_URL . "parkingadmin/index'>Go to home</a>";
                            // echo " <a href='http://localhost:8082/14june/Ticketadmin/index'>Go to home</a>";
                        }
                        echo "</div>";
                         $_SESSION['puja_benefactor_processed'] = true;

                        exit();
                    } elseif (($_POST['PaymentOption'] ?? '') == 'zelleProxy') {
                        $_POST['amount'] = $_POST['proxyamount'] ?? '';
                        $_POST['transaction_id'] = $_POST['zelleProxyTid'] ?? '';
                        $_POST['pay_date'] = $_POST['proxydate'] ?? '';
                        $_POST['payment_status'] = 'confirmed';
                        $_POST['status'] = 'confirmed';
                        $_POST['DepositAccount'] = $_POST['zelleProxyDepositAccount'] ?? '';
                        $_POST['id'] = $id;
                        $data = $_POST;
                        $datamemberarr = array();
                        $datamemberarr = array_merge($_POST);
                        $paidparkingModel->update(array_merge($_POST));

                        $value = array();
                        $value['oid'] = $datamemberarr['oid'];
                        $value['Member_id'] = $datamemberarr['Member_id'];
                        $value['MemberName'] = $datamemberarr['First_name'] . ' ' . $datamemberarr['Last_name'];
                        $value['PaymentOption'] = $datamemberarr['PaymentOption'];
                        $value['payment_status'] = 'succeeded';
                        $value['payment_timestamp'] = $datamemberarr['payment_timestamp'] ?? '';
                        $value['Amount'] = $datamemberarr['amount'];
                        $value['stripe_return'] = $datamemberarr['stripe_return'] ?? '';
                        $value['transaction_id'] = $datamemberarr['transaction_id'];
                        $value['paid_amount'] = $datamemberarr['paid_amount'] ?? '';
                        $value['update_on'] = $datamemberarr['UpdateOn'];
                        $value['stripe_product'] = $datamemberarr['stripe_product'] ?? '';
                        $value['pay_date'] = $datamemberarr['pay_date'];
                        $value['pay_type'] = 'Donation';
                        $value['pay_for'] = 'DONATION / Unrestricted';
                        $value['paymentfor'] = 'Puja Benefactor';
                        $value['Tele1'] = $datamemberarr['phone'];
                        $value['email'] = $datamemberarr['email'];
                        $value['spousename'] = $datamemberarr['Sp_fname'] . ' ' . $datamemberarr['Sp_lname'];
                        $value['Address'] = $datamemberarr['streetname'];
                        $value['Street'] = $datamemberarr['street'];
                        $value['City'] = $datamemberarr['city'];
                        $value['State'] = $datamemberarr['state'];
                        $value['Zip_Code'] = $datamemberarr['zip'];
                        $value['admin_id'] = $datamemberarr['admin_id'];
                        $value['admin_name'] = $datamemberarr['admin_name'];
                        $value['DepositAccount'] = $datamemberarr['DepositAccount'];
                        $DonationModel->SaveDataInDonation($value);
                        $email = $_POST['email'] ?? '';
                        if ($email != null) {
                            $this->sendEmailticket($message, $subjetc, $email, $Emailcc);
                        }
                        $mobileno = $_POST['alternatenumber'] ?? '';
                        if ($mobileno != null) {
                            $this->SendSMS($mobileno, $textmsg);
                        }

                        $memberid = $_POST['Member_id'] ?? '';
                        $mebername = ($_POST['First_name'] ?? '') . ' ' . ($_POST['Last_name'] ?? '');
                        $oid = $_POST['oid'] ?? '';
                        $amount = $_POST['amount'] ?? '';
                        $parkingspot = $_POST['parkingfield'] ?? '';
                        $datefor = $_POST['pay_date'] ?? '';
                        $pujatype = $_POST['puja_type'] ?? '';
                        $timestamp = !empty($datefor) ? strtotime($datefor) : false;
                        $payfinaldate = $timestamp ? date("m/d/Y", $timestamp) : '';

                        echo "<div style='text-align: -webkit-center;' class = 'pay'>
                    <table border='4' width='585px'>
                    <tr>
                    <td colspan='2'> <img src='../thankyouscreen.jpg' alt='' height='167px' style='margin-left:12em;'><h1 style='text-align:center;font-family:fangsong; font-size:30px;'><b>Houston Durga Bari Society</b></h1> </td> </tr>
                     <tr><td style='width:50%;'>Order Id</td> <td style='width:50%;'>" . $oid . "</td> </tr>
                     <tr><td>Member Id</td> <td>" . $memberid . "</td> </tr>
                     <tr><td>Member Name</td> <td>" . $mebername . "</td> </tr>
                     <tr><td>Puja Type</td> <td>" . $pujatype . "</td> </tr> 
                     <tr><td>Parking Spot</td> <td>" . $parkingspot . "</td></tr>
                     <tr><td>Amount</td> <td><span style='color:red;'>$</span>" . $amount . "</td> </tr>
                     <tr><td>Payment Method</td> <td>zelleProxy</td>  </tr>
                     <tr><td>Payment Status</td> <td>Confirmed</td>  </tr>
                     <tr><td>Pay Date</td> <td>" . $payfinaldate . "</td>  </tr>
                     <tr><td colspan='2' style='font-weight: bold;color:red;'>An email with your payment information has been sent to your registered email address. Please check your spam folder if you cannot find the email in your inbox</td></tr>
                     <tr><td colspan='2'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>   </tr>
                     </tr>";
                        echo "</table>";
                        if ($this->isAdmin() || $this->isEditor()) {
                            echo " <a href='" . INSTALL_URL . "parkingadmin/index'>Go to home</a>";
                        }
                        echo "</div>";
                        $_SESSION['puja_benefactor_processed'] = true;

                        exit();
                    } elseif (($_POST['PaymentOption'] ?? '') == 'stripe') {

                        $amount = $_POST['amount'] ?? '';

                        $total = $amount;

                        require APP_PATH . '/helpers/stripe/lib/Stripe.php';

                        $error = '';
                        $success = '';

                        Stripe::setApiKey1($this->tpl["option_arr_values"]["stripe_api_key"] ?? '');

                        try {
                            if (!isset($_POST['stripeToken'])) {
                                throw new Exception("The Stripe Token was not generated correctly");
                            }
                            $oid = $_POST['oid'] ?? '';
                            $amount = round($amount * 100);

                            $payment = Stripe_Charge::create(
                                array(
                                    "amount" => $amount,
                                    //"currency" => $this->tpl["option_arr_values"]["currency"],
                                    "currency" => "USD",
                                    "card" => $_POST['stripeToken'] ?? '',
                                    "description" => "Pay For:" . ($_POST['pay_type'] ?? '') . ', ' . "Email:" . ($_POST['email'] ?? '') . ', ' . "Full Name:" . ($_POST['MemberName'] ?? ''),
                                    "metadata" => ["orderid" => $oid]
                                )
                            );

                            $this->tpl['payment']['balance_transaction'] = $payment->balance_transaction;
                            $this->tpl['payment']['amount'] = $payment->amount;
                            $this->tpl['payment']['status'] = $payment->status;
                            $this->tpl['payment']['currency'] = $payment->currency;

                            if ($payment->status == 'succeeded') {

                                $opts = array();
                                //$donationpayid = $_POST['id'] ?? '';
                                //$_POST['id'] =  $donationid;
                                // $id = $data['id'];
                                $opts['id'] = $id;
                                $opts['stripe_return'] = $payment->status;
                                $opts['transaction_id'] = $payment->id;
                                $opts['paid_amount'] = $payment->amount;
                                $opts['stripe_product'] = $payment->description;
                                //$opts['payment_status'] = 'confirmed';
                                $opts['payment_status'] = 'confirmed';
                                $_POST['status'] = 'confirmed';
                                $_POST['id'] = $id;
                                $opts['payment_timestamp'] = time();
                                $data = $_POST;
                                $datamemberarr = array();
                                $datamemberarr = array_merge($opts, $_POST);
                                $paidparkingModel->update(array_merge($opts, $_POST));
                                $value = array();
                                $value['oid'] = $datamemberarr['oid'];
                                $value['Member_id'] = $datamemberarr['Member_id'];
                                $value['MemberName'] = $datamemberarr['First_name'] . ' ' . $datamemberarr['Last_name'];
                                $value['PaymentOption'] = $datamemberarr['PaymentOption'];
                                $value['payment_status'] = 'succeeded';
                                $value['payment_timestamp'] = $datamemberarr['payment_timestamp'] ?? '';
                                $value['Amount'] = $datamemberarr['amount'];
                                $value['stripe_return'] = $datamemberarr['stripe_return'] ?? '';
                                $value['transaction_id'] = $datamemberarr['transaction_id'];
                                $value['paid_amount'] = $datamemberarr['paid_amount'] ?? '';
                                $value['update_on'] = $datamemberarr['UpdateOn'];
                                $value['stripe_product'] = $datamemberarr['stripe_product'] ?? '';
                                $value['pay_date'] = $datamemberarr['pay_date'];
                                $value['pay_type'] = 'Donation';
                                $value['pay_for'] = 'DONATION / Unrestricted';
                                $value['paymentfor'] = 'Puja Benefactor';
                                $value['Tele1'] = $datamemberarr['phone'];
                                $value['email'] = $datamemberarr['email'];
                                $value['spousename'] = $datamemberarr['Sp_fname'] . ' ' . $datamemberarr['Sp_lname'];
                                $value['Address'] = $datamemberarr['streetname'];
                                $value['Street'] = $datamemberarr['street'];
                                $value['City'] = $datamemberarr['city'];
                                $value['State'] = $datamemberarr['state'];
                                $value['Zip_Code'] = $datamemberarr['zip'];
                                $value['admin_id'] = $datamemberarr['admin_id'];
                                $value['admin_name'] = $datamemberarr['admin_name'];
                                $DonationModel->SaveDataInDonation($value);
                                $email = $_POST['email'] ?? '';
                                if ($email != null) {
                                    $this->sendEmailticket($message, $subjetc, $email, $Emailcc);
                                }
                                $mobileno = $_POST['alternatenumber'] ?? '';
                                if ($mobileno != null) {
                                    $this->SendSMS($mobileno, $textmsg);
                                }
                                $memberid = $_POST['Member_id'] ?? '';
                                $mebername = ($_POST['First_name'] ?? '') . ' ' . ($_POST['Last_name'] ?? '');
                                $oid = $_POST['oid'] ?? '';
                                $amount = $_POST['amount'] ?? '';
                                $parkingspot = $_POST['parkingfield'] ?? '';
                                $datefor = $_POST['pay_date'] ?? '';
                                $pujatype = $_POST['puja_type'] ?? '';
                                $timestamp = !empty($datefor) ? strtotime($datefor) : false;
                                $payfinaldate = $timestamp ? date("m/d/Y", $timestamp) : '';

                                echo "<div style='text-align: -webkit-center;' class = 'pay'>
                    <table border='4' width='585px'>
                    <tr>
                    <td colspan='2'> <img src='../thankyouscreen.jpg' alt='' height='167px' style='margin-left:12em;'><h1 style='text-align:center;font-family:fangsong; font-size:30px;'><b>Houston Durga Bari Society</b></h1> </td> </tr>
                     <tr><td style='width:50%;'>Order Id</td> <td style='width:50%;'>" . $oid . "</td> </tr>
                     <tr><td>Member Id</td> <td>" . $memberid . "</td> </tr>
                     <tr><td>Member Name</td> <td>" . $mebername . "</td> </tr>
                     <tr><td>Puja Type</td> <td>" . $pujatype . "</td> </tr> 
                     <tr><td>Parking Spot</td> <td>" . $parkingspot . "</td></tr>
                     <tr><td>Amount</td> <td><span style='color:red;'>$</span>" . $amount . "</td> </tr>
                     <tr><td>Payment Method</td> <td>Stripe</td>  </tr>
                     <tr><td>Payment Status</td> <td>Confirmed</td>  </tr>
                     <tr><td>Pay Date</td> <td>" . $payfinaldate . "</td>  </tr>
                     <tr><td colspan='2' style='font-weight: bold;color:red;'>An email with your payment information has been sent to your registered email address. Please check your spam folder if you cannot find the email in your inbox</td></tr>
                     <tr><td colspan='2'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>   </tr>
                     </tr>";
                                echo "</table>";
                                if ($this->isAdmin() || $this->isEditor()) {
                                    echo " <a href='" . INSTALL_URL . "parkingadmin/index'>Go to home</a>";
                                    // echo " <a href='http://localhost:8082/14june/Ticketadmin/index'>Go to home</a>";
                                }
                                echo "</div>";
                                 $_SESSION['puja_benefactor_processed'] = true;

                                exit();
                            } else {

                                $opts = array();
                                $opts['id'] = $id;
                                $opts['stripe_return'] = $payment->status;
                                $opts['transaction_id'] = $payment->id;
                                $opts['paid_amount'] = $payment->amount;
                                $opts['stripe_product'] = $payment->description;

                                $DonationModel->update($opts);

                                $_SESSION['status'] = '<strong>' . __('declined_card') . '</strong>';
                            }
                        } catch (Exception $ex) {
                            $_SESSION['status'] = $ex->getMessage();
                        }

                        //$this->tpl['arr'] = $DonationModel->get($id);
                        $this->tpl['arr']['amount'] = $total;
                      exit();  
                    } else {
                        $_SESSION['status'] = 16;
                    }
                } else {
                    $_SESSION['status'] = 17;
                }
               
            }
            exit();
        }
    }
}
