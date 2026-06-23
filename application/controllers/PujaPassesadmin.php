<?php

require_once CONTROLLERS_PATH . 'App.php';
class PujaPassesadmin extends App
{

    var $option_arr = null;
    var $layout = 'admin';

    function beforeFilter()
    {

        GzObject::loadFiles('Model', 'Option');
        $OptionModel = new OptionModel();
        $this->option_arr = $OptionModel->getAllPairValues();
        $this->tpl['option_arr'] = $OptionModel->getAllPairs();
        $this->tpl['option_arr_values'] = $this->option_arr;

        $this->tpl['js_format'] = Util::getJsDateFormta($this->tpl['option_arr_values']['date_format']);
        $this->tpl['iso_format'] = Util::getISODateFormta($this->tpl['option_arr_values']['date_format']);

        date_default_timezone_set($this->tpl['option_arr_values']['timezone'] ?: 'UTC');

        if (!$this->isLoged() && ($_REQUEST['action'] ?? '') != 'login') {

            // if (($_REQUEST['action'] ?? '') != 'edit') {
            //     $_SESSION['err'] = 2;
            //     Util::redirect(INSTALL_URL . "Admin/login");
            // }
            if (($_REQUEST['action'] ?? '') != 'payment') {
                $_SESSION['err'] = 2;
                Util::redirect(INSTALL_URL . "Admin/login");
            }
        }
        $this->css[] = array('file' => 'front/style.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'admin/gzstyling/bootstrap.min.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'admin/gzstyling/font-awesome.min.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'admin/gzstyling/ionicons.min.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'admin/gzstyling/gzstyle.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'admin/gzstyling/daterangepicker/daterangepicker-bs3.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'ui-custom.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'admin/admin.css', 'path' => CSS_PATH);

        $this->js[] = array('file' => 'jquery/jquery-1.9.1.min.js', 'path' => LIBS_PATH);
        $this->js[] = array('file' => 'gzadmin/bootstrap.min.js', 'path' => JS_PATH);

        $this->js[] = array('file' => 'gzadmin/plugins/datatables/jquery.dataTables.js', 'path' => JS_PATH);
        $this->js[] = array('file' => 'gzadmin/plugins/datatables/dataTables.bootstrap.js', 'path' => JS_PATH);
        $this->js[] = array('file' => 'gzadmin/gzadmin/app.js', 'path' => JS_PATH);
        $this->js[] = array('file' => 'jquery-ui.min.js', 'path' => LIBS_PATH . 'jquery/ui/');
        $this->js[] = array('file' => 'ajax-upload/das.js', 'path' => JS_PATH);
        $this->js[] = array('file' => 'ajax-upload/jquery.form.js', 'path' => JS_PATH);

        $this->js[] = array('file' => 'jquery/ui/jquery-ui.min.js', 'path' => LIBS_PATH);
        //for stripe payment
        if (($_REQUEST['action'] ?? '') == 'payment') {
            $this->js[] = array('file' => '', 'path' => 'https://js.stripe.com/v3/', 'remote' => 1);
        }
        $this->js[] = array('file' => 'gzadmin/plugins/daterangepicker/daterangepicker.js', 'path' => JS_PATH);
        $this->js[] = array('file' => 'admin.js?v=' . time(), 'path' => JS_PATH);
        $this->js[] = array('file' => 'loadingoverlay.js?v=' . time(), 'path' => JS_PATH);
        $this->js[] = array('file' => 'GzPujaPasses.js?v=' . time(), 'path' => JS_PATH);

    }

     function viewdocument() {
        $this->setIsAjax(true);
        GzObject::loadFiles('Model', array('pujapasses'));
        $pujapassesModel = new pujapassesModel();
              if (!empty($_GET['id'])) 
               {
                  $document = $pujapassesModel->documentdata($_GET['id'] ?? '');
                  $imagename = $document['studentavatar'];
                  $path = INSTALL_URL . UPLOAD_PATH . 'avatar/thumb/' .$imagename;   
              echo "<script type='text/javascript'>window.open('$path','_self');</script>";
              }
              Util::redirect(INSTALL_URL . "PujaPassesadmin/index/");
        }

  function index()
    {
        GzObject::loadFiles('Model', array('pujapasses', 'pujapassesprice'));
        $pujapassesModel = new pujapassesModel();
        $pujapassespriceModel = new pujapassespriceModel();
        
        $opts = array();
        $arr = $pujapassesModel->getAlldata($opts);
        $this->tpl['arr'] = $arr; 

        $pujapassespriceregarr = $pujapassespriceModel->getAllpujapassesprice($opts);
        $this->tpl['pujapassespriceregarr'] = $pujapassespriceregarr;
    }
    
// function for update status registration from admin end
    function edit()
    {
        GzObject::loadFiles('Model', array('pujapasses' , 'Donation'));
        $pujapassesModel = new pujapassesModel();
        $DonationModel = new DonationModel();
        if (!empty($_POST['edit_pujapassesdata'])) {

            $data = array();

            $id = $_POST['id'] ?? '';
            $status = $_POST['status'] ?? '';
            $membertype = $_POST['puja_category'] ?? '';
             //condition for check box update case
            if (($_POST['member_veggie'] ?? '') == "" || ($_POST['member_veggie'] ?? '') == null) {
                $_POST['member_veggie'] = '0';
            }
            if (($_POST['senior'] ?? '') == "" || ($_POST['senior'] ?? '') == null) {
                $_POST['senior'] = '0';
            }
            if (($_POST['spouse_veggie'] ?? '') == "" || ($_POST['spouse_veggie'] ?? '') == null) {
                $_POST['spouse_veggie'] = '0';
            }
            if (($_POST['parent1_veggie'] ?? '') == "" || ($_POST['parent1_veggie'] ?? '') == null) {
                $_POST['parent1_veggie'] = '0';
            }
            if (($_POST['parent2_veggie'] ?? '') == "" || ($_POST['parent2_veggie'] ?? '') == null) {
                $_POST['parent2_veggie'] = '0';
            }
            if ($status == 'Active') {
                $url = INSTALL_URL . "PujaPassesadmin/payment/$id";
                //$url = "http://localhost:8082/HDBS_Payment/Parking&Badges/PujaPassesadmin/payment/$id";
                
                $fullname = $_POST['membername'] ?? '';
                $pujatype = $_POST['puja_type'] ?? '';
                $memberid = $_POST['Member_id'] ?? '';
                $amount = $_POST['totalamount'] ?? '';
                $Emailcc = 'pujaassocpayment@durgabari.org';
                $subjetc = 'HDBS Paid Passes Payment';
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
                <td style="text-align: center; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;"><strong>Paid Passes Registration</strong></td>
                </tr>
                </tbody>
                </table>
                </div>
                <div class="email-token-class" style="text-align: center;">
                <table style="height: 190px; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;" width="604">
                <tbody>
                <tr>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Member Name&nbsp;&nbsp;</td>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">' . $fullname . '</td>
                </tr>
                <tr>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Puja Type&nbsp;&nbsp;</td>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $pujatype . '</td>
                </tr>
                <tr>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Payable Amount&nbsp;&nbsp;</td>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;"><span style="color:red;">$</span>' . $amount . '</td>
                </tr>
                <tr>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Payment Url&nbsp;&nbsp;</td>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $url . '</td>
                </tr>
                <tr>
                <td colspan =2 style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: center;">Please make your payment to complete your Paid Passes &nbsp;&nbsp;</td>
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
                $mobileno= $_POST['alternatenumber'] ?? '';
                if ($mobileno != null) {
                    $msg = 'Houston Durga Bari: ' .$fullname. ' your Paid Passes Request for '.$pujatype. '  .Houston Durga Bari has been approved. Please check your email and complete final payment. ';

                    $this->SendSMS($mobileno, $msg);
                }

            }
            // if ($status == 'cancelled') {
            //     $cancelremarks = $_POST['remarks'] ?? '';
            //     $membername = ($_POST['First_name'] ?? '') .' ' . ($_POST['Last_name'] ?? '');
            //     $name = 'Dear'. ', '.$membername;
            //     $Emailcc = 'pujaassocpayment@durgabari.org';
            //     $subjetc = 'HDBS Parking Payment';
            //     $message ='<p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</p>
            //     <div class="email-token-class" style="text-align: justify;">
            //     <div class="email-token-class" style="text-align: center;">
            //     <table style="height: 77px; margin-left: auto; border-collapse: collapse; margin-right: auto;" width="606">
            //     <tbody>
            //     <tr>
            //     <td style="text-align: center;  margin-left: auto; border-collapse: collapse; margin-right: auto;"><img src="' . INSTALL_URL . 'application/web/upload/image/create.png" alt="" width="396" height="66" /></td>
            //     </tr>
            //     </tbody>
            //     </table>
            //     </div>
            //     <p style= "font-weight: bold;"> '.$name.'</p>
            //     <p> '.$cancelremarks.'</p>
            //     <p>Regards, <br>Houston Durga Bari Society</p>
            //      ';
            //   $email = $_POST['email'] ?? '';
            //      if ($email != null) {
            //       $this->sendEmailticket($message, $subjetc, $email, $Emailcc);
            //     }
            //     $mobileno= $_POST['alternatenumber'] ?? '';
            //     if ($mobileno != null) {
            //         $msg = 'Houston Durga Bari: ' .$fullname. ' your Paid Passes Request for '.$pujatype. '  Houston Durga Bari has been Cancelled the request. ';
            //         $this->SendSMS($mobileno, $msg);
            //     }

            // }
            
            if ($status == 'cancelled') {
                $fullname = $_POST['membername'] ?? '';
                $pujatype = $_POST['puja_type'] ?? '';
                $memberid = $_POST['Member_id'] ?? '';
                $email = $_POST['email'] ?? '';
                $mobileno = $_POST['alternatenumber'] ?? '';
                $cancelremarks = $_POST['remarks'] ?? '' ;
                $Emailcc = 'pujaassocpayment@durgabari.org';
                $subject = 'HDBS Paid Passes Cancellation Notice';

                $message = '
<p>&nbsp;</p>
<div style="text-align: center;">

   
    <table style="border: 1px solid black; margin: 0 auto; border-collapse: collapse;" width="606">
        <tr>
            <td style="text-align: center; border: 1px solid black;">
                <img src="' . INSTALL_URL . 'application/web/upload/image/create.png" 
                     alt="HDBS Logo" width="396" height="66" />
            </td>
        </tr>
    </table>

    
    <table style="border: 1px solid black; margin: 10px auto; border-collapse: collapse;" width="604">
        <tr>
            <td style="text-align: center; border: 1px solid black;">
                <strong>Paid Passes Cancellation</strong>
            </td>
        </tr>
    </table>

   
    <table style="border: 1px solid black; margin: 0 auto; border-collapse: collapse;" width="604">
        <tr>
            <td style="border: 1px solid black; text-align: left; width: 50%;">Member Name</td>
            <td style="border: 1px solid black; text-align: left; width: 50%;">' . $fullname . '</td>
        </tr>
        
        <tr>
            <td style="border: 1px solid black; text-align: left;">Remarks</td>
            <td style="border: 1px solid black; text-align: left;">' . $cancelremarks . '</td>
        </tr>
        <tr>
            <td colspan="2" style="border: 1px solid black; text-align: center;">
                Your Paid Passes request has been <strong style="color: red;">cancelled</strong>.<br />
                If you have any questions, please contact the HDBS Office.
            </td>
            
            
            
        </tr>
    </table>

</div>
';


                if ($email != null) {
                    
                    $this->sendEmailticket($message, $subject, $email, $Emailcc);
                }

                if ($mobileno != null) {
                    $sms = 'Houston Durga Bari: ' . $fullname . ', your Paid Passes request for ' . $pujatype . ' has been cancelled. If you have questions, please contact the office.';
                    $this->SendSMS($mobileno, $sms);
                }


            }

            $pujapassesModel->update($_POST);
            
            
            $editPujaId = $_POST['id'] ?? '';

            $pujaOid = $pujapassesModel->getOID($editPujaId);
            $paymentStatus = $_POST['status'] ?? '';

             if($paymentStatus == "cancelled")
            {
                $Isfrom = "Puja Passes";
                $DonationModel->editPaymentStatus($pujaOid , $paymentStatus , $Isfrom);
            }

            if (!empty($id)) {
                $_SESSION['status'] = 20;
            } else {
                $_SESSION['status'] = 21;
            }

            if (!$this->isAdmin()) {
                Util::redirect(INSTALL_URL . "Admin/dashboard");
            } else {
                Util::redirect(INSTALL_URL . "PujaPassesadmin/index");
            }
        }
        $id = $_GET['id'] ?? '';
        $pujadataarr = $pujapassesModel->get($id);
        $this->tpl['pujadataarr'] = $pujadataarr;


    }

    // end

// function for make final payment from user end Passes
function payment(){
    GzObject::loadFiles('Model', array('pujapasses' ,'ConfirmCode', 'Member', 'Donation', 'idnumbers'));
    $pujapassesModel = new pujapassesModel();
    $ConfirmCodeModel = new ConfirmCodeModel();
    $MemberModel = new MemberModel();
    $DonationModel = new DonationModel();
    $idnumbersModel = new idnumbersModel();

    if (!empty($_POST['passes_payment'])) {
        $data = array();
        date_default_timezone_set("America/Chicago");
        $today = date("Y/m/d");
        $_POST['pay_date'] = $today;
        $_POST['pay_type'] = 'Puja Passes';
        $_POST['pay_for'] = 'Passes' . '/' . ($_POST['puja_type'] ?? '');

        // for generate oid 
        $maxoid = $idnumbersModel->getMaxoid() + 1;
        $update_oid = $idnumbersModel->Updateoid($maxoid);
        $_POST['oid'] = $maxoid;
        // end generate oid for     `

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
        if (($_POST['PaymentOption'] ?? '') == 'others') {

            $opts = array();
            $cmCode = $_POST['code'] ?? '';
            $opts['Confirmation'] = $_POST['confirm_code'] ?? '';
            $isAvailable = $ConfirmCodeModel->ConfirmCheckCode($cmCode);
            if(!$isAvailable)
            {
                Util::redirect(INSTALL_URL . "onlinepujapayments/onlinepujapayments");
                exit();

            }
            $arr = $ConfirmCodeModel->UpdateCode($cmCode);
            $_POST['transaction_id'] = $cmCode;
            $arr = $ConfirmCodeModel->getAll($opts);
            $oid = $_POST['oid'] ?? '';
            if ($oid != null) {
                $opts = array();
                $opts['payment_status'] = 'confirmed';
                $_POST['status'] = 'confirmed';
                $data = $_POST;
                $datamemberarr = array();
                $datamemberarr = array_merge($opts, $_POST);
                $pujapassesModel->update(array_merge($opts, $_POST));
                $value = array();
               $value['oid'] = $oid;
                        $value['Member_id'] = $datamemberarr['Member_id'];
                        $value['MemberName'] = $datamemberarr['membername'];
                        $value['PaymentOption'] = $datamemberarr['PaymentOption'];
                        $value['payment_status'] = 'succeeded';
                        $value['payment_timestamp'] = $datamemberarr['payment_timestamp'] ?? '';
                        $value['stripe_return'] = $datamemberarr['stripe_return'] ?? '';
                        $value['transaction_id'] = $datamemberarr['transaction_id'];
                        $value['paid_amount'] = $datamemberarr['paid_amount'] ?? '';
                        $value['update_on'] = $datamemberarr['UpdateOn'];
                        $value['stripe_product'] = $datamemberarr['stripe_product'] ?? '';
                        $value['pay_date'] = $datamemberarr['pay_date'];
                        $value['pay_type'] = $datamemberarr['pay_type'];
                        $value['pay_for'] = $datamemberarr['pay_for'];
                        $value['Tele1'] = $datamemberarr['phone'];
                        $value['email'] = $datamemberarr['email']; 
                        $value['spousename'] = $datamemberarr['spousename'];
                        $value['Address'] = $datamemberarr['streetname'];
                        $value['Street'] = $datamemberarr['street'];
                        $value['City'] = $datamemberarr['city'];
                        $value['State'] = $datamemberarr['state'];
                        $value['Zip_Code'] = $datamemberarr['zip'];
                       // $extradonationamount = $datamemberarr['donation'];
                        //$totalamountwithdonation = $datamemberarr['totalamount'];
                        //$SecondAmount = $totalamountwithdonation - $extradonationamount;
                        $value['Amount'] = $datamemberarr['totalamount'];

                    $DonationModel->SaveDataInDonation($value);
                  

                        if($datamember == null) {
                            $value = array();
                            // $value['id'] = $_POST['id'] ?? '';
                            $value['Payment_For'] = $_POST['Payment_For'] ?? '';
                            $value['MemberName'] = $_POST['membername'] ?? '';
                            $value['Amount'] = $_POST['totalamount'] ?? '';
                            $value['PaymentOption'] = $_POST['PaymentOption'] ?? '';
                            $value['payment_status'] = 'confirmed';
                            $value['payment_timestamp'] = $opts['payment_timestamp'] ?? '';
                            $value['stripe_return'] = $opts['stripe_return'] ?? '';
                            $value['transaction_id'] = $opts['transaction_id'];
                            $value['paid_amount'] = $opts['paid_amount'] ?? '';
                            $value['stripe_product'] = $opts['stripe_product'] ?? '';
                            $value['update_on'] = $_POST['update_on'] ?? '';
                            $value['Member_id'] = $_POST['Member_id'] ?? '';
                            $value['pay_date'] = $_POST['pay_date'] ?? '';
                            $value['cc_name'] = $_POST['cc_name'] ?? '';
                            $value['remarks'] = $_POST['remarks'] ?? '';
                            $value['oid'] = $_POST['oid'] ?? '';
                            $value['pay_type'] = $_POST['pay_type'] ?? '';
                            $value['pay_for'] = $_POST['pay_for'] ?? '';
                            $value['Address'] = $_POST['streetname'] ?? '';
                            $value['Street'] = $_POST['street'] ?? '';
                            $value['Address'] = $_POST['streetname'] ?? '';
                            $value['Address3'] = $_POST['unit'] ?? '';
                            $value['Zip_Code'] = $_POST['zip'] ?? '';
                            $value['Phone_Number'] = $_POST['alternatenumber'] ?? '';
                            $value['email'] = $_POST['email'] ?? '';
                            $value['City'] = $_POST['city'] ?? '';
                            $value['State'] = $datamemberarr['state'];
                            $value['Tele1'] = $_POST['phone'] ?? '';
                            $value['spousename'] = $_POST['spousename'] ?? '';
                            $value['Address3'] = $_POST['Address3'] ?? '';
                            //$value['Parent1'] = $_POST['Parent1'] ?? '';
                            //$value['Parent2'] = $_POST['Parent2'] ?? '';
                            $value['Child1'] = $_POST['Child1'] ?? '';
                            $value['Child2'] = $_POST['Child2'] ?? '';
                            $value['Child3'] = $_POST['Child3'] ?? '';
                            $value['Age1'] = $_POST['Age1'] ?? '';
                            $value['Age2'] = $_POST['Age2'] ?? '';
                            $value['Age3'] = $_POST['Age3'] ?? '';
                            $MemberModel->SaveDataInmember($value);
                        }
                        $orderid = $_POST['oid'] ?? '';
                        $Member_id = $_POST['Member_id'] ?? '';
                        $MemberName = $_POST['membername'] ?? '';
                        $registrationfor = $_POST['puja_type'] ?? '';
                        $totalamount = $_POST['totalamount'] ?? '';
                        $payui = 'Zelle';
                        $paymentdate = strtotime($_POST['pay_date'] ?? '');
                        $paydateemail = date("m/d/Y", $paymentdate);
                        
                       $subjetc = 'HDBS Paid Passes Payment Confirmation';
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
                        <td style="text-align: center; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;"><strong>Paid Passes Registration Confirmation</strong></td>
                        </tr>
                        </tbody>
                        </table>
                        </div>
                        <div class="email-token-class" style="text-align: center;">
                        <table style="height: 190px; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;" width="604">
                        <tbody>
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Order Id&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $orderid . '</td>
                        </tr>
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Member Id&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $Member_id . '</td>
                        </tr>
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Member Name&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">' . $MemberName . '</td>
                        </tr>
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Puja Type&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $registrationfor . '</td>
                        </tr>
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Amount&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;"><span style="color:red;">$</span>' . $totalamount . '</td>
                        </tr>
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Payment Method&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $payui . '</td>
                        </tr>
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Pay Date&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $paydateemail . '</td>
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
                        $mobileno = $data['tele1'];
                        if ($data['tele1'] != null) {
                           $msg = 'Houston Durga Bari: Paid Passes Confirmation are Member Id: ' . $Member_id . ', Order Id: ' . $orderid . ', Member Name: ' . $MemberName . ', Puja Type: ' . $registrationfor . ',  Amount: $' . $totalamount . ' , Payment Method: ' . $payui.' , Pay Date: ' . $paydateemail;
                           $this->SendSMS($mobileno, $msg);
                        }                
                
                //exit();
            }
        } elseif (($_POST['PaymentOption'] ?? '') == 'stripe') {

            //$amount = $_POST['Amount'] ?? '';
            $amount = $_POST['totalamount'] ?? '';


            $total = $amount;

            require APP_PATH . '/helpers/stripe/lib/Stripe.php';

            $error = '';
            $success = '';

            Stripe::setApiKey($this->tpl["option_arr_values"]["stripe_api_key"]);

            try {
                if (!isset($_POST['stripeToken'])) {
                    throw new Exception("The Stripe Token was not generated correctly");
                }

                $oid = $_POST['oid'] ?? '';
                $amount = round($amount * 100);

                $payment = Stripe_Charge::create(
                    array(
                        "amount" => $amount,
                        "currency" => $this->tpl["option_arr_values"]["currency"],
                        "card" => $_POST['stripeToken'] ?? '',
                        "description" => "Pay For:Puja Passes/" . ($_POST['pay_for'] ?? '') . ', ' . "Email:" . ($_POST['email'] ?? '') . ', ' . "Full Name:" . ($_POST['First_name'] ?? '') . ' ' . ($_POST['Last_name'] ?? ''),
                        "metadata" => ["orderid" => $oid]
                    )
                );

                $this->tpl['payment']['balance_transaction'] = $payment->balance_transaction;
                $this->tpl['payment']['amount'] = $payment->amount;
                $this->tpl['payment']['status'] = $payment->status;
                $this->tpl['payment']['currency'] = $payment->currency;

                if ($payment->status == 'succeeded') {

                    $opts = array();
                    $opts['id'] = $id;
                    $opts['stripe_return'] = $payment->status;
                    $opts['transaction_id'] = $payment->id;
                    $opts['paid_amount'] = $payment->amount;
                    $opts['stripe_product'] = $payment->description;
                    $opts['payment_status'] = 'confirmed';
                    $opts['payment_timestamp'] = time();
                    $_POST['status'] = 'confirmed';
                    $data = $_POST;
                    $datamemberarr = array();
                    $datamemberarr = array_merge($opts, $_POST);
                    $pujapassesModel->update(array_merge($opts, $_POST));
                    
                    $value = array();
                   $value['oid'] = $oid;
                        $value['Member_id'] = $datamemberarr['Member_id'];
                        $value['MemberName'] = $datamemberarr['membername'];
                        $value['PaymentOption'] = $datamemberarr['PaymentOption'];
                        $value['payment_status'] = 'succeeded';
                        $value['payment_timestamp'] = $datamemberarr['payment_timestamp'] ?? '';
                        $value['stripe_return'] = $datamemberarr['stripe_return'] ?? '';
                        $value['transaction_id'] = $datamemberarr['transaction_id'];
                        $value['paid_amount'] = $datamemberarr['paid_amount'] ?? '';
                        $value['update_on'] = $datamemberarr['UpdateOn'];
                        $value['stripe_product'] = $datamemberarr['stripe_product'] ?? '';
                        $value['pay_date'] = $datamemberarr['pay_date'];
                        $value['pay_type'] = $datamemberarr['pay_type'];
                        $value['pay_for'] = $datamemberarr['pay_for'];
                        $value['Tele1'] = $datamemberarr['phone'];
                        $value['email'] = $datamemberarr['email']; 
                        $value['spousename'] = $datamemberarr['spousename'];
                        $value['Address'] = $datamemberarr['streetname'];
                        $value['Street'] = $datamemberarr['street'];
                        $value['City'] = $datamemberarr['city'];
                        $value['State'] = $datamemberarr['state'];
                        $value['Zip_Code'] = $datamemberarr['zip'];
                       // $extradonationamount = $datamemberarr['donation'];
                        //$totalamountwithdonation = $datamemberarr['totalamount'];
                        //$SecondAmount = $totalamountwithdonation - $extradonationamount;
                        $value['Amount'] = $datamemberarr['totalamount'];

                    $DonationModel->SaveDataInDonation($value);
                  

                        if($datamember == null) {
                            $value = array();
                            // $value['id'] = $_POST['id'] ?? '';
                            $value['Payment_For'] = $_POST['Payment_For'] ?? '';
                            $value['MemberName'] = $_POST['membername'] ?? '';
                            $value['Amount'] = $_POST['totalamount'] ?? '';
                            $value['PaymentOption'] = $_POST['PaymentOption'] ?? '';
                            $value['payment_status'] = 'confirmed';
                            $value['payment_timestamp'] = $opts['payment_timestamp'] ?? '';
                            $value['stripe_return'] = $opts['stripe_return'] ?? '';
                            $value['transaction_id'] = $opts['transaction_id'];
                            $value['paid_amount'] = $opts['paid_amount'] ?? '';
                            $value['stripe_product'] = $opts['stripe_product'] ?? '';
                            $value['update_on'] = $_POST['update_on'] ?? '';
                            $value['Member_id'] = $_POST['Member_id'] ?? '';
                            $value['pay_date'] = $_POST['pay_date'] ?? '';
                            $value['cc_name'] = $_POST['cc_name'] ?? '';
                            $value['remarks'] = $_POST['remarks'] ?? '';
                            $value['oid'] = $_POST['oid'] ?? '';
                            $value['pay_type'] = $_POST['pay_type'] ?? '';
                            $value['pay_for'] = $_POST['pay_for'] ?? '';
                            $value['Address'] = $_POST['streetname'] ?? '';
                            $value['Street'] = $_POST['street'] ?? '';
                            $value['Address'] = $_POST['streetname'] ?? '';
                            $value['Address3'] = $_POST['unit'] ?? '';
                            $value['Zip_Code'] = $_POST['zip'] ?? '';
                            $value['Phone_Number'] = $_POST['alternatenumber'] ?? '';
                            $value['email'] = $_POST['email'] ?? '';
                            $value['City'] = $_POST['city'] ?? '';
                            $value['State'] = $datamemberarr['state'];
                            $value['Tele1'] = $_POST['phone'] ?? '';
                            $value['spousename'] = $_POST['spousename'] ?? '';
                            $value['Address3'] = $_POST['Address3'] ?? '';
                            //$value['Parent1'] = $_POST['Parent1'] ?? '';
                            //$value['Parent2'] = $_POST['Parent2'] ?? '';
                            $value['Child1'] = $_POST['Child1'] ?? '';
                            $value['Child2'] = $_POST['Child2'] ?? '';
                            $value['Child3'] = $_POST['Child3'] ?? '';
                            $value['Age1'] = $_POST['Age1'] ?? '';
                            $value['Age2'] = $_POST['Age2'] ?? '';
                            $value['Age3'] = $_POST['Age3'] ?? '';
                            $MemberModel->SaveDataInmember($value);
                        }
                   
                         $orderid = $_POST['oid'] ?? '';
                        $Member_id = $_POST['Member_id'] ?? '';
                        $MemberName = $_POST['membername'] ?? '';
                        $registrationfor = $_POST['puja_type'] ?? '';
                        $totalamount = $_POST['totalamount'] ?? '';
                        $payui = 'Credit Card';
                        $paymentdate = strtotime($_POST['pay_date'] ?? '');
                        $paydateemail = date("m/d/Y", $paymentdate);
                        
                       $subjetc = 'HDBS Paid Passes Payment Confirmation';
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
                        <td style="text-align: center; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;"><strong>Paid Passes Registration Confirmation</strong></td>
                        </tr>
                        </tbody>
                        </table>
                        </div>
                        <div class="email-token-class" style="text-align: center;">
                        <table style="height: 190px; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;" width="604">
                        <tbody>
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Order Id&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $orderid . '</td>
                        </tr>
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Member Id&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $Member_id . '</td>
                        </tr>
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Member Name&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">' . $MemberName . '</td>
                        </tr>
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Puja Type&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $registrationfor . '</td>
                        </tr>
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Amount&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;"><span style="color:red;">$</span>' . $totalamount . '</td>
                        </tr>
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Payment Method&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $payui . '</td>
                        </tr>
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Pay Date&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $paydateemail . '</td>
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
                        $mobileno = $data['tele1'];
                        if ($data['tele1'] != null) {
                           $msg = 'Houston Durga Bari: Paid Passes Confirmation are Member Id: ' . $Member_id . ', Order Id: ' . $orderid . ', Member Name: ' . $MemberName . ', Puja Type: ' . $registrationfor . ',  Amount: $' . $amount . ' , Payment Method: ' . $payui.' , Pay Date: ' . $paydateemail;
                           $this->SendSMS($mobileno, $msg);
                        }
                    $this->tpl['arr'] = $pujapassesModel->get($id);
                } else {

                    $opts = array();
                    $opts['id'] = $id;
                    $opts['stripe_return'] = $payment->status;
                    $opts['transaction_id'] = $payment->id;
                    $opts['paid_amount'] = $payment->amount;
                    $opts['stripe_product'] = $payment->description;

                    $pujapassesModel->update($opts);

                    $_SESSION['status'] = '<strong>' . __('declined_card') . '</strong>';
                }
            } catch (Exception $ex) {
                $_SESSION['status'] = $ex->getMessage();
            }

        } else {
            $_SESSION['status'] = 16;

        }


    }
    else {
        $_SESSION['status'] = 17;
    }

    $id = $_GET['id'] ?? '';
    if ($id != null || $id = "") {
        $passesarr = $pujapassesModel->get($id);
        $this->tpl['passesarr'] = $passesarr;
    }

}

  


        // Function for PujaPasses price create 
    function pujapassespricecreate()
    {
        GzObject::loadFiles('Model', array('pujapassesprice'));
        $pujapassespriceModel = new pujapassespriceModel();

        if (!empty($_POST['pujapassespricecreate'])) {

            // $data = array();

            $id = $pujapassespriceModel->save(array_merge($_POST));

            if (!empty($id)) {
                $_SESSION['status'] = 16;
            } else {
                $_SESSION['status'] = 17;
            }
            Util::redirect(INSTALL_URL . "PujaPassesadmin/index");
        }
    }

    // end

    // Function for PujaPasses price edit 
    function pujapassespriceedit()
    {
        GzObject::loadFiles('Model', array('pujapassesprice'));
        $pujapassespriceModel = new pujapassespriceModel();
        if (!empty($_POST['pujapassespriceedit'])) {

            $data = array();
            $id = $pujapassespriceModel->update(array_merge($_POST));

            if (!empty($id)) {
                $_SESSION['status'] = 20;
            } else {
                $_SESSION['status'] = 21;
            }

            if (!$this->isAdmin()) {
                Util::redirect(INSTALL_URL . "Admin/dashboard");
            } else {
                Util::redirect(INSTALL_URL . "PujaPassesadmin/index");
            }
        }
        $id = $_GET['id'] ?? '';
        $pujapassespricearr = $pujapassespriceModel->get($id);
        $this->tpl['pujapassespricearr'] = $pujapassespricearr;

    }
    // end


 public function export()
    {
        GzObject::loadFiles('Model', array('pujapasses'));
        $pujapassesModel = new pujapassesModel();

        $opts = array();
        $data = $pujapassesModel->getAlldata($opts);

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=Puja_Passes.csv');

        $output = fopen('php://output', 'w');

        if (!empty($data)) {
            $columns = array_keys($data[0]); 
            fputcsv($output, $columns, ',', '"', '\\');
        }

        foreach ($data as $row) {
            fputcsv($output, $row, ',', '"', '\\');
        }

        fclose($output);
        exit;
    }

   function delete()
    {
        $this->isAjax = true;
        $id = ($_REQUEST['id'] ?? '');
        $cat = ($_REQUEST['cat'] ?? '');

        GzObject::loadFiles('Model', array('pujapasses', 'pujapassesprice'));
        $pujapassesModel = new pujapassesModel();
        $pujapassespriceModel = new pujapassespriceModel();

        if($cat == 1){
            $pujapassesModel->deleteFrom($pujapassesModel->getTable())
             ->where('id', $id)->execute();
        }elseif($cat == 3){
            $pujapassespriceModel->deleteFrom($pujapassespriceModel->getTable())
             ->where('id', $id)->execute();
        }
        $opts = array();
        Util::redirect(INSTALL_URL . "PujaPassesadmin/index");

    }
    
    function getPassReport(){
       GzObject::loadFiles('Model', array('createPassReport'));
       $createPassReportModel = new createPassReportModel();
        $opts = array();
        $data = $createPassReportModel->getAll($opts);
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=Pass_Data_export.csv');
        $output = fopen('php://output', 'w');
        if (!empty($data)) {
            $columns = array_keys($data[0]); 
            fputcsv($output, $columns, ',', '"', '\\');
        }
        foreach ($data as $row) {
            fputcsv($output, $row, ',', '"', '\\');
        }
        fclose($output);
        exit;
    }

}

?>
