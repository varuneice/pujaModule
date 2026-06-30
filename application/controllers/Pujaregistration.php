<?php

require_once CONTROLLERS_PATH . 'App.php';
class Pujaregistration extends App
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
            if (($_REQUEST['action'] ?? '') != 'payment' &&  ($_REQUEST['action'] ?? '') != 'sankalpapayment') {
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
        //$this->js[] = array('file' => 'ajax-upload/das.js', 'path' => JS_PATH);
        //$this->js[] = array('file' => 'ajax-upload/jquery.form.js', 'path' => JS_PATH);

        $this->js[] = array('file' => 'jquery/ui/jquery-ui.min.js', 'path' => LIBS_PATH);
        //for stripe payment
        if (($_REQUEST['action'] ?? '') == 'payment' || ($_REQUEST['action'] ?? '') == 'sankalpapayment') {
            $this->js[] = array('file' => '', 'path' => 'https://js.stripe.com/v3/', 'remote' => 1);
        }
        $this->js[] = array('file' => 'gzadmin/plugins/daterangepicker/daterangepicker.js', 'path' => JS_PATH);
        $this->js[] = array('file' => 'admin.js?v=' . time(), 'path' => JS_PATH);
        $this->js[] = array('file' => 'loadingoverlay.js?v=' . time(), 'path' => JS_PATH);
        $this->js[] = array('file' => 'GzPujaregistration.js?v=' . time(), 'path' => JS_PATH);

    }

    private function logPujaRegError($message) {
        $logFile = __DIR__ . '/../../pujaregistrationlog.log';
        file_put_contents($logFile, '[' . date('Y-m-d H:i:s') . '] [Pujaregistration] ' . $message . PHP_EOL, FILE_APPEND);
    }

    private function isFamilyPujaRegistration($pujaregistrationModel, $registrationId)
    {
        $registrationId = (int) $registrationId;
        if ($registrationId <= 0) {
            return false;
        }

        $registration = $pujaregistrationModel->get($registrationId);
        return strtolower(trim($registration['member_status'] ?? '')) === 'family';
    }

    private function adjustAdditionalAdultCount($pujaregistrationModel, $registrationId, $delta)
    {
        $registrationId = (int) $registrationId;
        $delta = (int) $delta;
        if ($registrationId <= 0 || $delta === 0) {
            return;
        }

        $registration = $pujaregistrationModel->get($registrationId);
        if (empty($registration)) {
            return;
        }

        $current = (int) preg_replace('/[^0-9-]/', '', (string) ($registration['extraparentregistration'] ?? '0'));
        $newCount = max(0, $current + $delta);
        $sql = 'UPDATE ' . $pujaregistrationModel->getTable() . ' SET extraparentregistration = "' . $newCount . '" WHERE id = ' . $registrationId;
        $pujaregistrationModel->execute($sql);
    }


    // function for update status registration from admin end
    function edit()
    {
        GzObject::loadFiles('Model', array('pujaregistration' , 'Donation' , 'paidparking', 'pujaregistrationExtraMember'));
        $pujaregistrationModel = new pujaregistrationModel();
        try { $pujaregistrationModel->syncSchemaWithTableColumns(); } catch (Throwable $e) { $this->logPujaRegError('syncSchemaWithTableColumns ERROR | ' . $e->getMessage()); }
         $DonationModel = new DonationModel();
         $paidparkingModel = new paidparkingModel();
         $pujaregistrationExtraMemberModel = new pujaregistrationExtraMemberModel();

        if (!empty($_POST['delete_pujaregistration_extra_member'])) {
            $registrationId = (int) ($_POST['registration_id'] ?? 0);
            $orderId = (int) ($_POST['order_id'] ?? 0);
            $extraMemberId = (int) ($_POST['delete_pujaregistration_extra_member'] ?? 0);

            if (($this->isAdmin() || $this->isEditor()) && $registrationId > 0 && $orderId > 0 && $extraMemberId > 0 && $this->isFamilyPujaRegistration($pujaregistrationModel, $registrationId)) {
                try {
                    $extraMember = $pujaregistrationExtraMemberModel->getById($extraMemberId);
                    if (!empty($extraMember) && (int) ($extraMember['oid'] ?? 0) === $orderId) {
                        $pujaregistrationExtraMemberModel->deleteFrom($pujaregistrationExtraMemberModel->getTable())->where('id', $extraMemberId)->execute();
                        $this->adjustAdditionalAdultCount($pujaregistrationModel, $registrationId, -1);
                    }
                } catch (Throwable $e) { $this->logPujaRegError('extra member delete ERROR | ' . $e->getMessage()); }
            }

            Util::redirect(INSTALL_URL . "Pujaregistration/edit/" . $registrationId);
        }

        if (!empty($_POST['add_pujaregistration_extra_member'])) {
            $registrationId = (int) ($_POST['registration_id'] ?? 0);
            $orderId = (int) ($_POST['order_id'] ?? 0);
            $firstName = trim($_POST['first_name'] ?? '');
            $lastName = trim($_POST['last_name'] ?? '');

            if (($this->isAdmin() || $this->isEditor()) && $registrationId > 0 && $orderId > 0 && $firstName !== '' && $lastName !== '' && $this->isFamilyPujaRegistration($pujaregistrationModel, $registrationId)) {
                $extraMember = array(
                    'registration_id' => $registrationId,
                    'oid' => $orderId,
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                    'member_type' => 'Adult',
                    'is_veggie' => !empty($_POST['is_veggie']) ? 1 : 0,
                    'created_at' => date('Y-m-d H:i:s')
                );
                try {
                    $pujaregistrationExtraMemberModel->save($extraMember);
                    $this->adjustAdditionalAdultCount($pujaregistrationModel, $registrationId, 1);
                } catch (Throwable $e) { $this->logPujaRegError('extra member save ERROR | ' . $e->getMessage()); }
            }

            Util::redirect(INSTALL_URL . "Pujaregistration/edit/" . $registrationId);
        }

        if (!empty($_POST['update_pujaregistration_extra_member'])) {
            $registrationId = (int) ($_POST['registration_id'] ?? 0);
            $orderId = (int) ($_POST['order_id'] ?? 0);
            $extraMemberId = (int) ($_POST['extra_member_id'] ?? 0);
            $firstName = trim($_POST['first_name'] ?? '');
            $lastName = trim($_POST['last_name'] ?? '');

            if (($this->isAdmin() || $this->isEditor()) && $registrationId > 0 && $orderId > 0 && $extraMemberId > 0 && $firstName !== '' && $lastName !== '' && $this->isFamilyPujaRegistration($pujaregistrationModel, $registrationId)) {
                $extraMember = array(
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                    'member_type' => 'Adult',
                    'is_veggie' => !empty($_POST['is_veggie']) ? 1 : 0
                );
                try { $pujaregistrationExtraMemberModel->updateMember($extraMemberId, $orderId, $extraMember); } catch (Throwable $e) { $this->logPujaRegError('extra member update ERROR | ' . $e->getMessage()); }
            }

            Util::redirect(INSTALL_URL . "Pujaregistration/edit/" . $registrationId);
        }

        if (!empty($_POST['edit_pujaregistrationdata'])) {

            $data = array();

            $id = $_POST['id'] ?? '';
            $status = $_POST['status'] ?? '';
            $membertype = $_POST['regmember'] ?? '';
            
            //condition for check box update case
            if(($_POST['member_veggie'] ?? '') == "" || ($_POST['member_veggie'] ?? '') == null){
                $_POST['member_veggie'] = '0';
            }
            if(($_POST['senior'] ?? '') == "" || ($_POST['senior'] ?? '') == null){
                $_POST['senior'] = '0';
            }
            if(($_POST['spouse_veggie'] ?? '') == "" || ($_POST['spouse_veggie'] ?? '') == null){
                $_POST['spouse_veggie'] = '0';
            }
            if(($_POST['parent1_veggie'] ?? '') == "" || ($_POST['parent1_veggie'] ?? '') == null){
                $_POST['parent1_veggie'] = '0';
            }
            if(($_POST['parent2_veggie'] ?? '') == "" || ($_POST['parent2_veggie'] ?? '') == null){
                $_POST['parent2_veggie'] = '0';
            }
            if(($_POST['adult1_veggie'] ?? '') == "" || ($_POST['adult1_veggie'] ?? '') == null){
                $_POST['adult1_veggie'] = '0';
            }
            if(($_POST['adult2_veggie'] ?? '') == "" || ($_POST['adult2_veggie'] ?? '') == null){
                $_POST['adult2_veggie'] = '0';
            }
            if(($_POST['adult3_veggie'] ?? '') == "" || ($_POST['adult3_veggie'] ?? '') == null){
                $_POST['adult3_veggie'] = '0';
            }

            $adultRows = $this->extractAdultMemberRowsFromPost($_POST);
            $adultCount = isset($_POST['adult_member_count']) && is_numeric($_POST['adult_member_count']) ? (int) $_POST['adult_member_count'] : count($adultRows);
            $adultCount = max(0, min($adultCount, count($adultRows), 3));
            if (!empty($_POST['co_register_adult_members']) && $adultCount > 0) {
                $this->storeAdultMembersInRegistrationPost($_POST, $adultRows, $adultCount, $_POST['extraadultregistration'] ?? '');
            } else {
                $this->clearAdultMemberStorageFields($_POST);
            }
            
            
            if ($status == 'Active') {
                $url = INSTALL_URL . "Pujaregistration/payment/$id";
               // $url = "http://localhost:8082/HDBS_Payment/Parking&Badges/Pujaregistration/payment/$id";
                
                $fullname = $_POST['membername'] ?? '';
                $registrationfor = $_POST['puja_type'] ?? '';
                $magazine = $_POST['magazine'] ?? '';
                $totalamount = $_POST['totalamount'] ?? '';
                
                $Emailcc = 'pujaregpayment@durgabari.org';
                $subjetc = 'HDBS Registration Payment';
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
                <td style="text-align: center; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;"><strong>Puja Registration</strong></td>
                </tr>
                </tbody>
                </table>
                </div>
                <div class="email-token-class" style="text-align: center;">
                <table style="height: 190px; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;" width="604">
                <tbody>
                <tr>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Full Name&nbsp;&nbsp;</td>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">' . $fullname . '</td>
                </tr>
                <tr>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Registration For&nbsp;&nbsp;</td>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $registrationfor . '</td>
                </tr>
                <tr>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Total Amount&nbsp;&nbsp;</td>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;"><span style="color:red;">$</span>' . $totalamount . '</td>
                </tr>
                <tr>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Payment Url&nbsp;&nbsp;</td>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $url . '</td>
                </tr>
                <tr>
                <td colspan =2 style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: center;">Please make your payment to complete your registration &nbsp;&nbsp;</td>
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
                    $msg = 'Houston Durga Bari: ' .$fullname. ' your Puja Registration Request for '.$registrationfor. ' at Houston Durga Bari has been approved. Please check your email and complete final payment for Puja Registration. ';
                    $this->SendSMS($mobileno, $msg);
                }
            }
            
             if ($status == 'newdocument') {
                
                $registrationfor = $_POST['puja_type'] ?? '';
                $remarks = $_POST['remarks'] ?? '';
                $membername = $_POST['membername'] ?? '';
                $name = 'Dear' . ', ' . $membername;
                $urlForDocument = INSTALL_URL . "PujaOnlinePayments/userNewDocumentUpload/$id";
                $usermessage = "Please upload your document on link given below " ;
                 $Emailcc = 'pujaregpayment@durgabari.org';
                $subjetc = 'HDBS Registration Document Upload';
                $message = '<p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</p>
                <div class="email-token-class" style="text-align: justify;">
                <div class="email-token-class" style="text-align: center;">
                <table style="height: 77px; margin-left: auto; border-collapse: collapse; margin-right: auto;" width="606">
                <tbody>
                <tr>
                <td style="text-align: center;  margin-left: auto; border-collapse: collapse; margin-right: auto;"><img src="' . INSTALL_URL . 'application/web/upload/image/create.png" alt="" width="396" height="66" /></td>
                </tr>
                </tbody>
                </table>
                </div>
                <p style= "font-weight: bold;"> ' . $name . '</p>
                <p> ' . $remarks . '</p>
                  <p> ' . $usermessage . '</p>
                 <p> ' . $urlForDocument . '</p>
                <p>Regards, <br>Houston Durga Bari Society</p>';
                
                
                

                $email = $_POST['email'] ?? '';
                // $email = "varunkumar953685@gmail.com";
                if ($email != null) {
                    $this->sendEmailticket($message, $subjetc, $email, $Emailcc);
                }
                $mobileno = $_POST['alternatenumber'] ?? '';
                if ($mobileno != null) {
                    $msg = 'Houston Durga Bari: ' . $name . ' your Puja Registration Request for ' . $registrationfor . ' at Houston Durga Bari has been Cancelled.';
                    $this->SendSMS($mobileno, $msg);
                }
            }
            if ($status == 'cancelled') {
                
                $registrationfor = $_POST['puja_type'] ?? '';
                $cancelremarks = $_POST['remarks'] ?? '';
                $membername = $_POST['membername'] ?? '';
                $name = 'Dear'. ', '.$membername;
               
                 $Emailcc = 'pujaregpayment@durgabari.org';
                $subjetc = 'HDBS Registration cancelled';
                $message ='<p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</p>
                <div class="email-token-class" style="text-align: justify;">
                <div class="email-token-class" style="text-align: center;">
                <table style="height: 77px; margin-left: auto; border-collapse: collapse; margin-right: auto;" width="606">
                <tbody>
                <tr>
                <td style="text-align: center;  margin-left: auto; border-collapse: collapse; margin-right: auto;"><img src="' . INSTALL_URL . 'application/web/upload/image/create.png" alt="" width="396" height="66" /></td>
                </tr>
                </tbody>
                </table>
                </div>
                <p style= "font-weight: bold;"> '.$name.'</p>
                <p> '.$cancelremarks.'</p>
                <p>Regards, <br>Houston Durga Bari Society</p>
                 ';
               $email = $_POST['email'] ?? '';
              if ($email != null) {
                  $this->sendEmailticket($message, $subjetc, $email, $Emailcc);
                }
                $mobileno= $_POST['alternatenumber'] ?? '';
                if ($mobileno != null) {
                    $msg = 'Houston Durga Bari: ' .$name. ' your Puja Registration Request for '.$registrationfor. ' at Houston Durga Bari has been Cancelled.';
                    $this->SendSMS($mobileno, $msg);
                }
            }

            try { $pujaregistrationModel->update($_POST); } catch (Throwable $e) { $this->logPujaRegError('edit update ERROR | ' . $e->getMessage()); }

             $editPujaId = $_POST['id'] ?? '';

            $pujaOid = $pujaregistrationModel->getOID($editPujaId);
            $paymentStatus = $_POST['status'] ?? '';

            if($paymentStatus == "cancelled")
            {
                $Isfrom = "Puja Registration";
                try { $DonationModel->editPaymentStatus($pujaOid , $paymentStatus , $Isfrom); } catch (Throwable $e) { $this->logPujaRegError('editPaymentStatus ERROR | ' . $e->getMessage()); }
                try { $paidparkingModel->cancelledPayment($pujaOid , $paymentStatus , $Isfrom); } catch (Throwable $e) { $this->logPujaRegError('cancelledPayment ERROR | ' . $e->getMessage()); }
            }

            if(($_POST['sponsorLevel'] ?? '') != "")
            {
                try { $pujaregistrationModel->updateSponsorshipLevel($_POST['id'] ?? '' ,$_POST['sponsorLevel'] ?? '' ); } catch (Throwable $e) { $this->logPujaRegError('updateSponsorshipLevel ERROR | ' . $e->getMessage()); }
            }
            
            

            if (!empty($id)) {
                $_SESSION['status'] = 20;
            } else {
                $_SESSION['status'] = 21;
            }

            if (!$this->isAdmin()) {
                Util::redirect(INSTALL_URL . "Admin/dashboard");
            } else {
                Util::redirect(INSTALL_URL . "Pujaregistration/index");
            }
        }
        $id = $_GET['id'] ?? '';
        $pujadataarr = $this->hydrateAdultMembersFromRegistrationRow($pujaregistrationModel->get($id));
        $this->tpl['pujadataarr'] = $pujadataarr;
        $orderId = (int) ($pujadataarr['oid'] ?? 0);
        try {
            $pujaregistrationExtraMemberModel->backfillOrderIdForRegistration((int) $id, $orderId);
            $this->tpl['extraMembers'] = $pujaregistrationExtraMemberModel->getByOrderId($orderId);
        } catch (Throwable $e) {
            $this->logPujaRegError('extra member list ERROR | ' . $e->getMessage());
            $this->tpl['extraMembers'] = array();
        }


    }

    function deleteExtraMember()
    {
        if (!$this->isAdmin() && !$this->isEditor()) {
            Util::redirect(INSTALL_URL . "Admin/dashboard");
        }

        GzObject::loadFiles('Model', array('pujaregistrationExtraMember'));
        $pujaregistrationExtraMemberModel = new pujaregistrationExtraMemberModel();

        $id = (int) ($_POST['id'] ?? 0);
        $registrationId = (int) ($_POST['registration_id'] ?? 0);

        if ($id > 0) {
            try { $pujaregistrationExtraMemberModel->deleteFrom($pujaregistrationExtraMemberModel->getTable())->where('id', $id)->execute(); } catch (Throwable $e) { $this->logPujaRegError('extra member delete ERROR | ' . $e->getMessage()); }
        }

        Util::redirect(INSTALL_URL . "Pujaregistration/edit/" . $registrationId);
    }

    // end
// function for make final payment from user end registration

// function for make final payment from user end registration
function payment(){
    GzObject::loadFiles('Model', array('pujaregistration' ,'ConfirmCode', 'Member', 'Donation', 'idnumbers'));
    $pujaregistrationModel = new pujaregistrationModel();
    $ConfirmCodeModel = new ConfirmCodeModel();
    $MemberModel = new MemberModel();
    $DonationModel = new DonationModel();
    $idnumbersModel = new idnumbersModel();
    $id = $_POST['id'] ?? ($_GET['id'] ?? '');

    if (!empty($_POST['registration_payment'])) {
        $data = array();
        date_default_timezone_set("America/Chicago");
        $today = date("Y/m/d");
        $_POST['pay_date'] = $today;
        $_POST['pay_type'] = 'Puja Registration';
        $_POST['pay_for'] = $_POST['puja_type'] ?? '';

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
            $_POST['membercategory'] = 'GC';
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
                try { $pujaregistrationModel->update(array_merge($opts, $_POST)); } catch (Throwable $e) { $this->logPujaRegError('payment update ERROR | ' . $e->getMessage()); }
                try { $this->sendregistrationconfirmation($data); } catch (Throwable $e) { $this->logPujaRegError('sendregistrationconfirmation ERROR | ' . $e->getMessage()); }
                $value = array();
                $value['oid'] = $oid;
                        $value['Member_id'] = $datamemberarr['Member_id'];
                        $value['MemberName'] = $datamemberarr['First_name'].' '.$datamemberarr['Last_name'];
                        $value['PaymentOption'] = $datamemberarr['PaymentOption'];
                        $value['payment_status'] = 'succeeded';
                        $value['payment_timestamp'] = $datamemberarr['payment_timestamp'] ?? '';
                        $value['stripe_return'] = $datamemberarr['stripe_return'] ?? '';
                        $value['transaction_id'] = $datamemberarr['transaction_id'];
                        $value['paid_amount'] = $datamemberarr['paid_amount'] ?? '';
                        $value['update_on'] = $datamemberarr['UpdateOn'] ?? ($datamemberarr['update_on'] ?? '');
                        $value['stripe_product'] = $datamemberarr['stripe_product'] ?? '';
                        $value['pay_date'] = $datamemberarr['pay_date'];
                        $value['pay_type'] = $datamemberarr['pay_type'];
                        $value['pay_for'] = $datamemberarr['pay_for'];
                        $value['Tele1'] = $datamemberarr['phone'];
                        $value['email'] = $datamemberarr['email'];
                        $value['spousename'] = $datamemberarr['Sp_fname'].' '.$datamemberarr['Sp_lname'];;
                        $value['Address'] = $datamemberarr['streetname'];
                        $value['Street'] = $datamemberarr['street'];
                        $value['City'] = $datamemberarr['city'];
                        $value['State'] = $datamemberarr['state'];
                        $value['Zip_Code'] = $datamemberarr['zip'];
                        $extradonationamount = $datamemberarr['donation'];
                        $totalamountwithdonation = $datamemberarr['totalamount'];
                        $SecondAmount = $totalamountwithdonation - $extradonationamount;

                    if($extradonationamount == null){
                        $value['Amount'] = $datamemberarr['totalamount'];
                        try { $DonationModel->SaveDataInDonation($value); } catch (Throwable $e) { $this->logPujaRegError('SaveDataInDonation ERROR | ' . $e->getMessage()); }
                    }
                   if($extradonationamount != null){
                            for($i=0;$i<=1;$i++){
                                if($i==0){
                                    $value['pay_type'] = $datamemberarr['pay_type'];
                                    $value['pay_for'] = $datamemberarr['pay_for'];
                                    $value['Amount'] = $SecondAmount;
                                    try { $DonationModel->SaveDataInDonation($value); } catch (Throwable $e) { $this->logPujaRegError('SaveDataInDonation (split1) ERROR | ' . $e->getMessage()); }
                                }
                                if($i==1){
                                     $value['pay_type'] = 'Donation';
                                     $value['pay_for'] = 'DONATION / Unrestricted';
                                     $value['paymentfor'] = 'Puja Donation';
                                     $value['Amount'] = $extradonationamount;
                                     try { $DonationModel->SaveDataInDonation($value); } catch (Throwable $e) { $this->logPujaRegError('SaveDataInDonation (split2) ERROR | ' . $e->getMessage()); }
                                }

                            }
                        }

                        if($datamember == null) {
                            $value = array();
                            // $value['id'] = $_POST['id'] ?? '';
                            $value['Payment_For'] = $_POST['Payment_For'] ?? '';
                            $value['MemberName'] = ($_POST['First_name'] ?? '') . ' ' . ($_POST['Last_name'] ?? '');
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
                            $value['spousename'] = ($_POST['Sp_fname'] ?? '') . ' ' . ($_POST['Sp_lname'] ?? '');
                            $value['Address3'] = $_POST['Address3'] ?? '';
                            //$value['Parent1'] = $_POST['Parent1'] ?? '';
                            //$value['Parent2'] = $_POST['Parent2'] ?? '';
                            $value['Child1'] = $_POST['Child1'] ?? '';
                            $value['Child2'] = $_POST['Child2'] ?? '';
                            $value['Child3'] = $_POST['Child3'] ?? '';
                            $value['Age1'] = $_POST['Age1'] ?? '';
                            $value['Age2'] = $_POST['Age2'] ?? '';
                            $value['Age3'] = $_POST['Age3'] ?? '';
                            try { $MemberModel->SaveDataInmember($value); } catch (Throwable $e) { $this->logPujaRegError('SaveDataInmember ERROR | ' . $e->getMessage()); }
                        }
                        $orderid = $_POST['oid'] ?? '';
                        $Member_id = $_POST['Member_id'] ?? '';
                        $MemberName = $_POST['membername'] ?? '';
                        $registrationfor = $_POST['puja_type'] ?? '';
                        $pujaprice = $_POST['amount'] ?? '';
                        $magazineprice = $_POST['magazineprice'] ?? '';
                        $seniordiscount = $_POST['discountseniorprice'] ?? '';
                        $parentregistration = $_POST['extraparentregistration'] ?? '';
                        $donation = $_POST['donation'] ?? '';
                        $totalamount = $_POST['totalamount'] ?? '';
                        $payui = 'Zelle';
                        $paymentdate = strtotime($_POST['pay_date'] ?? '');
                        $paydateemail = date("m/d/Y", $paymentdate);
                        $mobileno = $_POST['alternatenumber'] ?? '';
                        if ($mobileno != null) {
                        $msg = 'Houston Durga Bari: Puja Registration confirmation are Order Id: ' . $orderid . ', Member Id: ' . $Member_id . ', Full Name: ' . $MemberName . ', Puja Type: ' . $registrationfor . ', Puja Price: $' . $pujaprice;
                        if ($magazineprice != "") {$msg .= ', Magazine(Additional): $' . $magazineprice;}
                        if ($parentregistration != "") {$msg .= ', Parent Registration: $' . $parentregistration;}
                        if ($seniordiscount != "") { $msg .= ', Senior Discount: $' . $seniordiscount;}
                        if ($donation != "") { $msg .= ', Donation Amount: $' . $donation;}
                        $msg .= ', Total Amount: $' . $totalamount . ', Payment Method: ' . $payui . ', Pay Date: ' . $paydateemail;
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
                        "description" => "Pay For:Registration/" . ($_POST['pay_for'] ?? '') . ', ' . "Email:" . ($_POST['email'] ?? '') . ', ' . "Full Name:" . ($_POST['First_name'] ?? '') . ' ' . ($_POST['Last_name'] ?? ''),
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
                    try { $pujaregistrationModel->update(array_merge($opts, $_POST)); } catch (Throwable $e) { $this->logPujaRegError('stripe succeeded update ERROR | ' . $e->getMessage()); }
                    $this->sendregistrationconfirmation($data);
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
                    $value['update_on'] = $datamemberarr['UpdateOn'] ?? ($datamemberarr['update_on'] ?? '');
                    $value['stripe_product'] = $datamemberarr['stripe_product'] ?? '';
                    $value['pay_date'] = $datamemberarr['pay_date'];
                    $value['pay_type'] = $datamemberarr['pay_type'];
                    $value['pay_for'] = $datamemberarr['pay_for'];
                    $value['Tele1'] = $datamemberarr['phone'];
                    $value['email'] = $datamemberarr['email']; 
                    $value['spousename'] = $datamemberarr['spousename'] ?? trim(($datamemberarr['Sp_fname'] ?? '') . ' ' . ($datamemberarr['Sp_lname'] ?? ''));
                    $value['Address'] = $datamemberarr['streetname'];
                    $value['Street'] = $datamemberarr['street'];
                    $value['City'] = $datamemberarr['city'];
                    $value['State'] = $datamemberarr['state'];
                    $value['Zip_Code'] = $datamemberarr['zip'];
                           $extradonationamount = $datamemberarr['donation'];
                        $totalamountwithdonation = $datamemberarr['totalamount'];
                        $SecondAmount = $totalamountwithdonation - $extradonationamount;

                    //$DonationModel->SaveDataInDonation($value);
                    if($extradonationamount == null){
                        $value['Amount'] = $datamemberarr['totalamount'];
                        try { $DonationModel->SaveDataInDonation($value); } catch (Throwable $e) { $this->logPujaRegError('SaveDataInDonation ERROR | ' . $e->getMessage()); }
                    }
                   if($extradonationamount != null){
                            for($i=0;$i<=1;$i++){
                                if($i==0){
                                    $value['pay_type'] = $datamemberarr['pay_type'];
                                    $value['pay_for'] = $datamemberarr['pay_for'];
                                    $value['Amount'] = $SecondAmount;
                                    try { $DonationModel->SaveDataInDonation($value); } catch (Throwable $e) { $this->logPujaRegError('SaveDataInDonation split1 ERROR | ' . $e->getMessage()); }
                                }
                                if($i==1){
                                     $value['pay_type'] = 'Donation';
                                     $value['pay_for'] = 'DONATION / Unrestricted';
                                     $value['paymentfor'] = 'Puja Donation';
                                     $value['Amount'] = $extradonationamount;
                                     try { $DonationModel->SaveDataInDonation($value); } catch (Throwable $e) { $this->logPujaRegError('SaveDataInDonation split2 ERROR | ' . $e->getMessage()); }
                                }

                            }
                        }

                    if($datamember == null) {
                        $value = array();
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
                        try { $MemberModel->SaveDataInmember($value); } catch (Throwable $e) { $this->logPujaRegError('stripe SaveDataInmember ERROR | ' . $e->getMessage()); }
                    }
                        $orderid = $_POST['oid'] ?? '';
                        $Member_id = $_POST['Member_id'] ?? '';
                        $MemberName = $_POST['membername'] ?? '';
                        $registrationfor = $_POST['puja_type'] ?? '';
                        $pujaprice = $_POST['amount'] ?? '';
                        $magazineprice = $_POST['magazineprice'] ?? '';
                        $seniordiscount = $_POST['discountseniorprice'] ?? '';
                        $parentregistration = $_POST['extraparentregistration'] ?? '';
                        $donation = $_POST['donation'] ?? '';
                        $totalamount = $_POST['totalamount'] ?? '';
                        $payui = 'Credit Card';
                        $paymentdate = strtotime($_POST['pay_date'] ?? '');
                        $paydateemail = date("m/d/Y", $paymentdate);
                        $mobileno = $_POST['alternatenumber'] ?? '';
                        if ($mobileno != null) {
                        $msg = 'Houston Durga Bari: Puja Registration confirmation are Order Id: ' . $orderid . ', Member Id: ' . $Member_id . ', Full Name: ' . $MemberName . ', Puja Type: ' . $registrationfor . ', Puja Price: $' . $pujaprice;
                        if ($magazineprice != "") {$msg .= ', Magazine(Additional): $' . $magazineprice;}
                        if ($parentregistration != "") {$msg .= ', Parent Registration: $' . $parentregistration;}
                        if ($seniordiscount != "") { $msg .= ', Senior Discount: $' . $seniordiscount;}
                        if ($donation != "") { $msg .= ', Donation Amount: $' . $donation;}
                        $msg .= ', Total Amount: $' . $totalamount . ', Payment Method: ' . $payui . ', Pay Date: ' . $paydateemail;
                        $this->SendSMS($mobileno, $msg);
                        }
                    $this->tpl['arr'] = $pujaregistrationModel->get($id);
                } else {

                    $opts = array();
                    $opts['id'] = $id;
                    $opts['stripe_return'] = $payment->status;
                    $opts['transaction_id'] = $payment->id;
                    $opts['paid_amount'] = $payment->amount;
                    $opts['stripe_product'] = $payment->description;

                    try { $pujaregistrationModel->update($opts); } catch (Throwable $e) { $this->logPujaRegError('stripe declined update ERROR | ' . $e->getMessage()); }

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

    if ($id !== '') {
        $registrationarr = $pujaregistrationModel->get($id);
        $this->tpl['registrationarr'] = $registrationarr;
    }

}

function sankalpapayment(){
    GzObject::loadFiles('Model', array('SankalpaPuja' ,'ConfirmCode', 'Member', 'Donation', 'idnumbers'));
    $SankalpaPujaModel = new SankalpaPujaModel();
    $ConfirmCodeModel = new ConfirmCodeModel();
    $MemberModel = new MemberModel();
    $DonationModel = new DonationModel();
    $idnumbersModel = new idnumbersModel();
    

    if (!empty($_POST['sankalpa_payment'])) {
        $data = array();
        date_default_timezone_set("America/Chicago");
        $today = date("Y/m/d");
        $_POST['pay_date'] = $today;
        $_POST['paytype'] ='Puja Registration';
        $_POST['pay_for'] = $_POST['item_name'] ?? '';

        // for generate oid 
        $maxoid = $idnumbersModel->getMaxoid() + 1;
        $update_oid = $idnumbersModel->Updateoid($maxoid);
        $_POST['oid'] = $maxoid;
        // end generate oid for 

        $datamember = $MemberModel->checkmemberregisterornot();
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
        
         //for confirmation email and msg
                    $orderid = $_POST['oid'] ?? '';
                    $Memberid = $_POST['Member_id'] ?? '';
                    $membername = $_POST['name'] ?? '';
                    $pujaname = $_POST['item_name'] ?? '';
                    $participationmode = $_POST['modeparticipation'] ?? '';
                    $totalamount = $_POST['item_cost'] ?? '';
                    $paymethod = $_POST['PaymentOption'] ?? '';
                    if ($paymethod == "others") {
                        $payui = 'Zelle';
                    } else if ($paymethod == "check") {
                        $payui = 'Check';
                    } else if ($paymethod == "cash") {
                        $payui = 'Cash';
                    } else if ($paymethod == "directdeposit") {
                        $payui = 'Direct Deposit';
                    } else if ($paymethod == "sumup") {
                        $payui = 'SumUp';
                    } else if ($paymethod == "stripe") {
                        $payui = 'Credit Card';
                    }

                    $paymentdate = strtotime($_POST['pay_date'] ?? '');
                    $paydateemail = date("m/d/Y", $paymentdate);

                    $Emailcc = 'pujaregpayment@durgabari.org';
                    $subjetc = 'Puja Registration Confirmation';
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
                        <td style="text-align: center; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;"><strong>Puja Registration Details</strong></td>
                        </tr>
                        </tbody>
                        </table>
                        </div>
                        <div class="email-token-class" style="text-align: center;">
                        <table style="height: 190px; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;" width="604">
                        <tbody>
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Order Id&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">' . $orderid . '</td>
                        </tr>
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Member Id&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">' . $Memberid . '</td>
                        </tr> 
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Full Name&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">' . $membername . '</td>
                        </tr>
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Puja Name&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $pujaname . '</td>
                        </tr>
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Participation Mode &nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $participationmode . '</td>
                        </tr>
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Total Amount&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;"><span style="color:red;">$</span>' . $totalamount . '</td>
                        </tr>
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Payment Method&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">' . $payui . '</td>
                        </tr>
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Pay Date&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">' . $paydateemail . '</td>
                        </tr> 
                        </tbody>
                        </table>
                        </div>
                        </div>
                        </div>';
                    $textmsg = 'Houston Durga Bari: Puja Registration confirmation are Order Id: ' . $orderid . ', Member Id: ' . $Memberid . ', Full Name: ' . $membername . ', Puja Name: ' . $pujaname . ', Participation Mode: ' . $participationmode . ', Total Amount: $' . $totalamount . ', Payment Method: ' . $payui . ', Pay Date: ' . $paydateemail;
                    
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
                $_POST['Status'] = 'confirmed';
                $data = $_POST;
                $datamemberarr = array();
                $datamemberarr = array_merge($opts, $_POST);
                try { $SankalpaPujaModel->update(array_merge($opts, $_POST)); } catch (Throwable $e) { $this->logPujaRegError('sankalpa zelle update ERROR | ' . $e->getMessage()); }
                $value = array();
                $value['oid'] = $datamemberarr['oid'];
                $value['Member_id'] = $datamemberarr['Member_id'];
                $value['MemberName'] = $datamemberarr['name'];
                $value['PaymentOption'] = $datamemberarr['PaymentOption'];
                $value['payment_status'] = 'succeeded';
                $value['payment_timestamp'] = $datamemberarr['payment_timestamp'] ?? '';
                $value['Amount'] = $datamemberarr['item_cost'];
                $value['stripe_return'] = $datamemberarr['stripe_return'] ?? '';
                $value['transaction_id'] = $datamemberarr['transaction_id'];
                $value['paid_amount'] = $datamemberarr['paid_amount'] ?? '';
                $value['update_on'] = $datamemberarr['UpdateOn'];
                $value['stripe_product'] = $datamemberarr['stripe_product'] ?? '';
                $value['pay_date'] = $datamemberarr['pay_date'];
                $value['pay_type'] = 'Puja Registration';
                $value['pay_for'] = $datamemberarr['pay_for'];
                $value['Tele1'] = $datamemberarr['tele'];
                $value['email'] = $datamemberarr['email'];
                $value['spousename'] = $datamemberarr['spousename'];
                $value['Address'] = $datamemberarr['streetname'];
                $value['Street'] = $datamemberarr['street'];
                $value['City'] = $datamemberarr['city'];
                $value['State'] = $datamemberarr['state'];
                $value['Zip_Code'] = $datamemberarr['zip'];
                try { $DonationModel->SaveDataInDonation($value); } catch (Throwable $e) { $this->logPujaRegError('sankalpa zelle SaveDataInDonation ERROR | ' . $e->getMessage()); }
                if ($datamember == null) {
                    $value = array();
                    $value['oid'] = $_POST['oid'] ?? '';
                    $value['MemberName'] = $_POST['name'] ?? '';
                    $value['Tele1'] = $_POST['tele'] ?? '';
                    $value['email'] = $_POST['email'] ?? '';
                    $value['City'] = $_POST['city'] ?? '';
                    $value['State'] = $_POST['state'] ?? '';
                    $value['Zip_Code'] = $_POST['zip'] ?? '';
                    $value['Amount'] = $_POST['item_cost'] ?? '';
                    $value['pay_type'] = 'Puja Registration';
                    $value['pay_for'] = $_POST['pay_for'] ?? '';
                    $value['pay_date'] = $_POST['pay_date'] ?? '';
                    $value['transaction_id'] = $_POST['transaction_id'] ?? '';
                    $value['remarks'] = $_POST['remarks'] ?? '';
                    $value['created_on'] = $_POST['created_on'] ?? '';
                    $value['update_on'] = $_POST['update_on'] ?? '';
                    $value['PaymentOption'] = $_POST['PaymentOption'] ?? '';
                    $value['payment_status'] = 'confirmed';
                    $value['cc_name'] = $_POST['cc_name'] ?? '';
                    $value['Member_id'] = $_POST['Member_id'] ?? '';
                    $value['type'] = $_POST['type'] ?? '';
                    $value['street'] = $_POST['street'] ?? '';
                    $value['Address1'] = $datamemberarr['streetname'];
                    $value['Address2'] = $datamemberarr['unit'];
                    $value['spousename'] = $datamemberarr['spousename'];
                    $value['Child1'] = $datamemberarr['Child1'];
                    $value['Age1'] = $datamemberarr['Age1'];
                    $value['Child2'] = $datamemberarr['Child2'];
                    $value['Age2'] = $datamemberarr['Age2'];
                    $value['Child3'] = $datamemberarr['Child3'];
                    $value['Age3'] = $datamemberarr['Age3'];
                    try { $MemberModel->SaveDataInmember($value); } catch (Throwable $e) { $this->logPujaRegError('sankalpa zelle SaveDataInmember ERROR | ' . $e->getMessage()); }
                }
                $email = $_POST['email'] ?? '';
                            if ($email != null) {
                                $this->sendEmailticket($message, $subjetc, $email, $Emailcc);
                            }
                            $mobileno = $_POST['alternatenumber'] ?? '';
                            if ($mobileno != null) {
                                $this->SendSMS($mobileno, $textmsg );
                            }
                //exit();
            }
        } elseif (($_POST['PaymentOption'] ?? '') == 'stripe') {

            //$amount = $_POST['Amount'] ?? '';
            $amount = $_POST['item_cost'] ?? '';


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
                        "description" => "Pay For:" . ($_POST['pay_for'] ?? '') . ', ' . "Email:" . ($_POST['email'] ?? '') . ', ' . "Full Name:" . ($_POST['membername'] ?? ''),
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
                    $_POST['Status'] = 'confirmed';
                    $data = $_POST;
                    $datamemberarr = array();
                    $datamemberarr = array_merge($opts, $_POST);
                    try { $SankalpaPujaModel->update(array_merge($opts, $_POST)); } catch (Throwable $e) { $this->logPujaRegError('sankalpa stripe update ERROR | ' . $e->getMessage()); }
                    $value = array();
                $value['oid'] = $datamemberarr['oid'];
                $value['Member_id'] = $datamemberarr['Member_id'];
                $value['MemberName'] = $datamemberarr['name'];
                $value['PaymentOption'] = $datamemberarr['PaymentOption'];
                $value['payment_status'] = 'succeeded';
                $value['payment_timestamp'] = $datamemberarr['payment_timestamp'] ?? '';
                $value['Amount'] = $datamemberarr['item_cost'];
                $value['stripe_return'] = $datamemberarr['stripe_return'] ?? '';
                $value['transaction_id'] = $datamemberarr['transaction_id'];
                $value['paid_amount'] = $datamemberarr['paid_amount'] ?? '';
                $value['update_on'] = $datamemberarr['UpdateOn'];
                $value['stripe_product'] = $datamemberarr['stripe_product'] ?? '';
                $value['pay_date'] = $datamemberarr['pay_date'];
                $value['pay_type'] = 'Puja Registration';
                $value['pay_for'] = $datamemberarr['pay_for'];
                $value['Tele1'] = $datamemberarr['tele'];
                $value['email'] = $datamemberarr['email'];
                $value['spousename'] = $datamemberarr['spousename'];
                $value['Address'] = $datamemberarr['streetname'];
                $value['Street'] = $datamemberarr['street'];
                $value['City'] = $datamemberarr['city'];
                $value['State'] = $datamemberarr['state'];
                $value['Zip_Code'] = $datamemberarr['zip'];
                try { $DonationModel->SaveDataInDonation($value); } catch (Throwable $e) { $this->logPujaRegError('sankalpa stripe SaveDataInDonation ERROR | ' . $e->getMessage()); }
                if ($datamember == null) {
                    $value = array();
                    $value['oid'] = $_POST['oid'] ?? '';
                    $value['MemberName'] = $_POST['name'] ?? '';
                    $value['Tele1'] = $_POST['tele'] ?? '';
                    $value['email'] = $_POST['email'] ?? '';
                    $value['City'] = $_POST['city'] ?? '';
                    $value['State'] = $_POST['state'] ?? '';
                    $value['Zip_Code'] = $_POST['zip'] ?? '';
                    $value['Amount'] = $_POST['item_cost'] ?? '';
                    $value['pay_type'] = 'Puja Registration';
                    $value['pay_for'] = $_POST['pay_for'] ?? '';
                    $value['pay_date'] = $_POST['pay_date'] ?? '';
                    $value['transaction_id'] = $_POST['transaction_id'] ?? '';
                    $value['remarks'] = $_POST['remarks'] ?? '';
                    $value['created_on'] = $_POST['created_on'] ?? '';
                    $value['update_on'] = $_POST['update_on'] ?? '';
                    $value['PaymentOption'] = $_POST['PaymentOption'] ?? '';
                    $value['payment_status'] = 'confirmed';
                    $value['cc_name'] = $_POST['cc_name'] ?? '';
                    $value['Member_id'] = $_POST['Member_id'] ?? '';
                    $value['type'] = $_POST['type'] ?? '';
                    $value['street'] = $_POST['street'] ?? '';
                    $value['Address1'] = $datamemberarr['streetname'];
                    $value['Address2'] = $datamemberarr['unit'];
                    $value['spousename'] = $datamemberarr['spousename'];
                    $value['Child1'] = $datamemberarr['Child1'];
                    $value['Age1'] = $datamemberarr['Age1'];
                    $value['Child2'] = $datamemberarr['Child2'];
                    $value['Age2'] = $datamemberarr['Age2'];
                    $value['Child3'] = $datamemberarr['Child3'];
                    $value['Age3'] = $datamemberarr['Age3'];
                    try { $MemberModel->SaveDataInmember($value); } catch (Throwable $e) { $this->logPujaRegError('sankalpa stripe SaveDataInmember ERROR | ' . $e->getMessage()); }
                    }
                    $email = $_POST['email'] ?? '';
                            if ($email != null) {
                                $this->sendEmailticket($message, $subjetc, $email, $Emailcc);
                            }
                            $mobileno = $_POST['alternatenumber'] ?? '';
                            if ($mobileno != null) {
                                $this->SendSMS($mobileno, $textmsg );
                            }

                    $this->tpl['arr'] = $SankalpaPujaModel->get($id);
                } else {

                    $opts = array();
                    $opts['id'] = $id;
                    $opts['stripe_return'] = $payment->status;
                    $opts['transaction_id'] = $payment->id;
                    $opts['paid_amount'] = $payment->amount;
                    $opts['stripe_product'] = $payment->description;

                    try { $SankalpaPujaModel->update($opts); } catch (Throwable $e) { $this->logPujaRegError('sankalpa stripe declined update ERROR | ' . $e->getMessage()); }

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
        $sankalpapujaarr = $SankalpaPujaModel->get($id);
        $this->tpl['sankalpapujaarr'] = $sankalpapujaarr;
    }

}

    function index()
    {
        GzObject::loadFiles('Model', array('pujaregistration', 'SankalpaPujaPrice', 'SankalpaPuja', 'pujaregistrationprice', 'pujaRegistrationDate', 'pujaregistrationChildBirthYear', 'pujaregistrationExtraMember', 'pujaregistrationsetting'));
        $pujaregistrationModel = new pujaregistrationModel();
        $SankalpaPujaPriceModel = new SankalpaPujaPriceModel();
        $SankalpaPujaModel = new SankalpaPujaModel();
        $pujaregistrationpriceModel = new pujaregistrationpriceModel();
        $pujaRegistrationDateModel = new pujaRegistrationDateModel();
        $pujaregistrationChildBirthYear = new pujaregistrationChildBirthYearModel();
        $pujaregistrationExtraMemberModel = new pujaregistrationExtraMemberModel();
        $PujaRegistrationSettingModel = new pujaregistrationsettingModel();
        
        $opts = array();
        try {
            $arr = $pujaregistrationModel->getAllpujaregistrationdata($opts);
            $this->tpl['arr'] = $arr;
        } catch (Throwable $e) { $this->logPujaRegError('index getAllpujaregistrationdata ERROR | ' . $e->getMessage()); $this->tpl['arr'] = []; }

// for sankalpa puja price
        try {
            $sankalpapricearr = $SankalpaPujaPriceModel->getAllprice($opts);
            $this->tpl['sankalpapricearr'] = $sankalpapricearr;
        } catch (Throwable $e) { $this->logPujaRegError('index getAllprice ERROR | ' . $e->getMessage()); $this->tpl['sankalpapricearr'] = []; }

// for sankalpa puja registration
        try {
            $sankalpaarr = $SankalpaPujaModel->getAlldata($opts);
            $this->tpl['sankalpaarr'] = $sankalpaarr;
        } catch (Throwable $e) { $this->logPujaRegError('index getAlldata ERROR | ' . $e->getMessage()); $this->tpl['sankalpaarr'] = []; }

// for all 3 puja  registration price
        try {
            try { $pujaregistrationpriceModel->ensureCurrentRegistrationRates(); } catch (Throwable $e) {}
            $pujaregarr = $pujaregistrationpriceModel->getAllregistrationprice($opts);
            $this->tpl['pujaregarr'] = $pujaregarr;
        } catch (Throwable $e) { $this->logPujaRegError('index getAllregistrationprice ERROR | ' . $e->getMessage()); $this->tpl['pujaregarr'] = []; }

// for all 3 puja  registration Date
        try {
            $registrationdatearr = $pujaRegistrationDateModel->getAll($opts);
            $this->tpl['registrationdatearr'] = $registrationdatearr;
        } catch (Throwable $e) { $this->logPujaRegError('index getAll registrationDate ERROR | ' . $e->getMessage()); $this->tpl['registrationdatearr'] = []; }

        try {
            $pujaregistrationChildBirth = $pujaregistrationChildBirthYear->getAll($opts);
            $this->tpl['pujaregistrationChildBirth'] = $pujaregistrationChildBirth;
        } catch (Throwable $e) { $this->logPujaRegError('index getAll childBirthYear ERROR | ' . $e->getMessage()); $this->tpl['pujaregistrationChildBirth'] = []; }

        try {
            $this->tpl['parent_ytd_threshold'] = $PujaRegistrationSettingModel->getActiveSettingValue('parent_ytd_threshold', '749', date('Y'));
        } catch (Throwable $e) { $this->logPujaRegError('index registration settings ERROR | ' . $e->getMessage()); $this->tpl['parent_ytd_threshold'] = '749'; }

    }
function sankalpaedit(){
    GzObject::loadFiles('Model', array('SankalpaPuja' , 'Donation'));
      $DonationModel = new DonationModel();
    $SankalpaPujaModel = new SankalpaPujaModel();
    if (!empty($_POST['edit_sankalpadata'])) {

        $data = array();

        $id = $_POST['id'] ?? '';
        $status = $_POST['Status'] ?? '';
        $membertype = $_POST['regmember'] ?? '';
        $item_cost = $_POST['item_cost'] ?? '';
        if ($status == 'Active' && $item_cost != "") {
            $url = INSTALL_URL . "Pujaregistration/sankalpapayment/$id";
            //$url = "http://localhost:8082/HDBS_Payment/Parking&Badges/Pujaregistration/sankalpapayment/$id";
            
            $fullname = $_POST['name'] ?? '';
            $registrationfor = $_POST['item_name'] ?? '';
            $totalamount = $_POST['item_cost'] ?? '';
            
            
             $Emailcc = 'pujaregpayment@durgabari.org';
            $subjetc = 'HDBS Registration Payment';
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
            <td style="text-align: center; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;"><strong>Puja Registration</strong></td>
            </tr>
            </tbody>
            </table>
            </div>
            <div class="email-token-class" style="text-align: center;">
            <table style="height: 190px; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;" width="604">
            <tbody>
            <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Full Name&nbsp;&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">' . $fullname . '</td>
            </tr>
            <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Puja Name&nbsp;&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $registrationfor . '</td>
            </tr>
            <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Total Amount&nbsp;&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;"><span style="color:red;">$</span>' . $totalamount . '</td>
            </tr>
            <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Payment Url&nbsp;&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $url . '</td>
            </tr>
            <tr>
            <td colspan =2 style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: center;">Please make your payment to complete your registration &nbsp;&nbsp;</td>
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
                    $msg = 'Houston Durga Bari: ' .$fullname. ' your Puja Registration Request for '.$registrationfor. ' at Houston Durga Bari has been approved. Please check your email and complete final payment for Puja Registration. ';
                    $this->SendSMS($mobileno, $msg);
                }
        }
        if ($status == 'confirmed' && $item_cost == "") {
        
            $fullname = $_POST['name'] ?? '';
            $memberid = $_POST['Member_id'] ?? '';
            $pujaname = $_POST['item_name'] ?? '';
           
           
             $Emailcc = 'pujaregpayment@durgabari.org';
            $subjetc = 'HDBS Registration Confirmation';
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
            <td style="text-align: center; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;"><strong>Puja Registration</strong></td>
            </tr>
            </tbody>
            </table>
            </div>
            <div class="email-token-class" style="text-align: center;">
            <table style="height: 190px; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;" width="604">
            <tbody>
            <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Full Name&nbsp;&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">' . $fullname . '</td>
            </tr>
            <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Member Id &nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $memberid . '</td>
            </tr>
            <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Puja Name&nbsp;&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $pujaname . '</td>
            </tr>
            <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Status&nbsp;&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Confirmed</td>
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
                $msg = 'Houston Durga Bari: Puja Registration confirmation are Member Id: ' . $memberid . ',  Full Name: ' .$fullname. ', Puja Name:  '.$pujaname. '.';
                $this->SendSMS($mobileno, $msg);
            }
        }
        if ($status == 'cancelled') {
            
            $cancelremarks = $_POST['remarks'] ?? '';
            $membername = $_POST['name'] ?? '';
            $name = 'Dear'. ', '.$membername;
            
             $Emailcc = 'pujaregpayment@durgabari.org';
            $subjetc = 'HDBS Registration Cancel';
            $message ='<p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</p>
            <div class="email-token-class" style="text-align: justify;">
            <div class="email-token-class" style="text-align: center;">
            <table style="height: 77px; margin-left: auto; border-collapse: collapse; margin-right: auto;" width="606">
            <tbody>
            <tr>
            <td style="text-align: center;  margin-left: auto; border-collapse: collapse; margin-right: auto;"><img src="' . INSTALL_URL . 'application/web/upload/image/create.png" alt="" width="396" height="66" /></td>
            </tr>
            </tbody>
            </table>
            </div>
            <p style= "font-weight: bold;"> '.$name.'</p>
            <p> '.$cancelremarks.'</p>
            <p>Regards, <br>Houston Durga Bari Society</p>
             ';
           $email = $_POST['email'] ?? '';
          if ($email != null) {
              $this->sendEmailticket($message, $subjetc, $email, $Emailcc);
            }
            $mobileno= $_POST['alternatenumber'] ?? '';
                if ($mobileno != null) {
                    $msg = 'Houston Durga Bari: ' .$name. ' your Puja Registration Request for '.$registrationfor. ' at Houston Durga Bari has been Cancelled.';
                    $this->SendSMS($mobileno, $msg);
                }
        }

        try { $SankalpaPujaModel->update($_POST); } catch (Throwable $e) { $this->logPujaRegError('sankalpaedit update ERROR | ' . $e->getMessage()); }

            $editPujaId = $_POST['id'] ?? '';

            $pujaOid = $SankalpaPujaModel->getOID($editPujaId);
            $paymentStatus = $_POST['Status'] ?? '';

             if($paymentStatus == "cancelled")
            {
                $Isfrom = "Puja Sankalpa";
                try { $DonationModel->editPaymentStatus($pujaOid , $paymentStatus , $Isfrom); } catch (Throwable $e) { $this->logPujaRegError('sankalpaedit editPaymentStatus ERROR | ' . $e->getMessage()); }
            }

        if (!empty($id)) {
            $_SESSION['status'] = 20;
        } else {
            $_SESSION['status'] = 21;
        }

        if (!$this->isAdmin()) {
            Util::redirect(INSTALL_URL . "Admin/dashboard");
        } else {
            Util::redirect(INSTALL_URL . "Pujaregistration/index");
        }
    }
    $id = $_GET['id'] ?? '';
    $sankalpadataarr = $SankalpaPujaModel->get($id);
    $this->tpl['sankalpadataarr'] = $sankalpadataarr;

}

function viewdocument() {
        $this->setIsAjax(true);
    GzObject::loadFiles('Model', array('SankalpaPuja'));
    $SankalpaPujaModel = new SankalpaPujaModel();
          if (!empty($_GET['id'])) 
           {
              $document = $SankalpaPujaModel->documentdata($_GET['id'] ?? '');
              $imagename = $document['avatar'];
              $path = INSTALL_URL . UPLOAD_PATH . 'avatar/thumb/' .$imagename;   
          echo "<script type='text/javascript'>window.open('$path','_self');</script>";
          }
          Util::redirect(INSTALL_URL . "Pujaregistration/index/");
    }

    function viewdocumentpujaregistration() {
        $this->setIsAjax(true);
        GzObject::loadFiles('Model', array('pujaregistration'));
        $pujaregistrationModel = new pujaregistrationModel();
              if (!empty($_GET['id'])) 
               {
                  $document = $pujaregistrationModel->getdocumentdata($_GET['id'] ?? '');
                  $imagename = $document['addressavatar'];
                  $path = INSTALL_URL . UPLOAD_PATH . 'avatar/thumb/' .$imagename;   
              echo "<script type='text/javascript'>window.open('$path','_self');</script>";
              }
              Util::redirect(INSTALL_URL . "Pujaregistration/index/");
        }
    


    // function for create sankalpa  puja price admin end. 
    function sankalpapricecreate(){
        GzObject::loadFiles('Model', array('SankalpaPujaPrice' ,  'User'));
        $SankalpaPujaPriceModel = new SankalpaPujaPriceModel();
         $UserModel = new UserModel();

        if (!empty($_POST['sankalpapricecreate'])) {
            
            
            if ($this->isAdmin() || $this->isEditor()) {
                $id = $this->getUserId();
                $admin = $UserModel->get($id);
                $rolename = $admin['first'] . ' ' . $admin['last'];
                $_POST['admin_id'] = $admin['id'];
                $_POST['admin_name'] = $rolename;
            }

            $id = null;
            try { $id = $SankalpaPujaPriceModel->save(array_merge($_POST)); } catch (Throwable $e) { $this->logPujaRegError('sankalpapricecreate save ERROR | ' . $e->getMessage()); }

            if (!empty($id)) {
                $_SESSION['status'] = 16;
            } else {
                $_SESSION['status'] = 17;
            }
            Util::redirect(INSTALL_URL . "Pujaregistration/index");
        }

    }


    function sankalpapriceedit(){
        GzObject::loadFiles('Model', array('SankalpaPujaPrice' , 'User'));
        $SankalpaPujaPriceModel = new SankalpaPujaPriceModel();
        $UserModel = new UserModel();

        if (!empty($_POST['sankalpapriceedit'])) {

             if ($this->isAdmin() || $this->isEditor()) {
                $id = $this->getUserId();
                $admin = $UserModel->get($id);
                $rolename = $admin['first'] . ' ' . $admin['last'];
                $_POST['admin_id'] = $admin['id'];
                $_POST['admin_name'] = $rolename;
            }

            $data = array();
            $id = null;
            try { $id = $SankalpaPujaPriceModel->update(array_merge($_POST)); } catch (Throwable $e) { $this->logPujaRegError('sankalpapriceedit update ERROR | ' . $e->getMessage()); }

            if (!empty($id)) {
                $_SESSION['status'] = 20;
            } else {
                $_SESSION['status'] = 21;
            }

            if (!$this->isAdmin()) {
                Util::redirect(INSTALL_URL . "Admin/dashboard");
            } else {
                Util::redirect(INSTALL_URL . "Pujaregistration/index");
            }
        }
        $id = $_GET['id'] ?? '';
        $sankalpaarr = $SankalpaPujaPriceModel->get($id);
        $this->tpl['sankalpaarr'] = $sankalpaarr;

    }

    // function for create  All puja price from admin end. 
    function pujaregistrationpricecreate(){
        GzObject::loadFiles('Model', array('pujaregistrationprice'));
        $pujaregistrationpriceModel = new pujaregistrationpriceModel();

        if (!empty($_POST['pujaregistrationprice'])) {

            $id = null;
            try { $id = $pujaregistrationpriceModel->save(array_merge($_POST)); } catch (Throwable $e) { $this->logPujaRegError('pujaregistrationpricecreate save ERROR | ' . $e->getMessage()); }
            if (!empty($id)) {
                $_SESSION['status'] = 16;
            } else {
                $_SESSION['status'] = 17;
            }
            Util::redirect(INSTALL_URL . "Pujaregistration/index");
        }

    }

 // function for update All puja price from admin end.
    function pujaregistrationpriceedit(){
        GzObject::loadFiles('Model', array('pujaregistrationprice'));
        $pujaregistrationpriceModel = new pujaregistrationpriceModel();

        if (!empty($_POST['pujaregistrationpriceedit'])) {

            $data = array();
            $id = null;
            try { $id = $pujaregistrationpriceModel->update(array_merge($_POST)); } catch (Throwable $e) { $this->logPujaRegError('pujaregistrationpriceedit update ERROR | ' . $e->getMessage()); }

            if (!empty($id)) {
                $_SESSION['status'] = 20;
            } else {
                $_SESSION['status'] = 21;
            }

            if (!$this->isAdmin()) {
                Util::redirect(INSTALL_URL . "Admin/dashboard");
            } else {
                Util::redirect(INSTALL_URL . "Pujaregistration/index");
            }
        }
        $id = $_GET['id'] ?? '';
        $allpujapricearr = $pujaregistrationpriceModel->get($id);
        $this->tpl['allpujapricearr'] = $allpujapricearr;

    }



    function export_21_august() {
        $this->setIsAjax(true);

        $this->isAjax = true;

        GzObject::loadFiles('Model', array('pujaregistration'));
        $pujaregistrationModel = new pujaregistrationModel();
       

        $output = "";

        $query = $pujaregistrationModel->from($pujaregistrationModel->getTable());

        $registration = $query->fetchAll();

        foreach ($registration[0] as $k => $v) {
            $output .= '"' . $k . '",';
        }
        $output .= "\n";

        foreach ($registration as $key => $value) {

            $opts = array();
            $opts['member_id'] = $value['id'];
            $slots = $pujaregistrationModel->getAll($opts);

            foreach ($value as $k => $v) {
                if ($k == 'date') {
                    $output .= '"' . date("Y-m-d H:i", $v) . '",';
                } else {
                    $output .= '"' . $v . '",';
                }
            }
            $output .= "\n";
        }

        $filename = "Puja_Registration" . time() . ".csv";
         // echo "<script>alert('$filename')</script>";
        header('Content-type: application/csv');
        header('Content-Disposition: attachment; filename=' . $filename);

        echo $output;
        exit;
    }
    
    public function export()
    {
        GzObject::loadFiles('Model', array('pujaregistration'));
        $pujaregistrationModel = new pujaregistrationModel();

        $opts = array();
        $data = $pujaregistrationModel->getAllpujaregistrationdata($opts);
        date_default_timezone_set("America/Chicago");
        $filename = "Puja_Registration" . date("m-d-Y") . ".csv";

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=' . $filename);

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

        GzObject::loadFiles('Model', array('pujaregistration', 'SankalpaPujaPrice', 'SankalpaPuja' ,'pujaregistrationprice'));
        $pujaregistrationModel = new pujaregistrationModel();
        $SankalpaPujaPriceModel = new SankalpaPujaPriceModel();
        $SankalpaPujaModel = new SankalpaPujaModel();
        $pujaregistrationpriceModel = new pujaregistrationpriceModel();

        if($cat == 1){
            try { $pujaregistrationModel->deleteFrom($pujaregistrationModel->getTable())->where('id', $id)->execute(); } catch (Throwable $e) { $this->logPujaRegError('delete cat1 ERROR | ' . $e->getMessage()); }
        }
        if($cat == 2){
            try { $SankalpaPujaPriceModel->deleteFrom($SankalpaPujaPriceModel->getTable())->where('id', $id)->execute(); } catch (Throwable $e) { $this->logPujaRegError('delete cat2 ERROR | ' . $e->getMessage()); }
        }
        if($cat == 3){
            try { $SankalpaPujaModel->deleteFrom($SankalpaPujaModel->getTable())->where('id', $id)->execute(); } catch (Throwable $e) { $this->logPujaRegError('delete cat3 ERROR | ' . $e->getMessage()); }
        }
        if($cat == 4){
            try { $pujaregistrationpriceModel->deleteFrom($pujaregistrationpriceModel->getTable())->where('id', $id)->execute(); } catch (Throwable $e) { $this->logPujaRegError('delete cat4 ERROR | ' . $e->getMessage()); }
        }

        $opts = array();
        Util::redirect(INSTALL_URL . "Pujaregistration/index");

    }

    function deleteEditedImage()
    {
        $this->isAjax = true;

        GzObject::loadFiles('Model', array('SankalpaPuja','pujaregistration'));
        $SankalpaPujaModel = new SankalpaPujaModel();
        $pujaregistrationModel = new pujaregistrationModel();

        if (!empty($_POST['id'])) {

            $id = $_POST['id'] ?? '';

            $SankalpaPujaname = $SankalpaPujaModel->get($id);

            $dest = INSTALL_PATH . UPLOAD_PATH . "avatar/thumb/" . $SankalpaPujaname['avatar'];
            if (is_file($dest)) {
                unlink($dest);
            }

            $data = array();
            $data['avatar'] = '';

            try { $SankalpaPujaModel->update(array_merge($_POST, $data)); } catch (Throwable $e) { $this->logPujaRegError('deleteEditedImage SankalpaPuja update ERROR | ' . $e->getMessage()); }
            $pujaregistrationname = $pujaregistrationModel->get($id);

            $dest = INSTALL_PATH . UPLOAD_PATH . "avatar/thumb/" . $pujaregistrationname['addressavatar'];
            if (is_file($dest)) {
                unlink($dest);
            }

            $data = array();
            $data['avatar'] = '';

            try { $pujaregistrationModel->update(array_merge($_POST, $data)); } catch (Throwable $e) { $this->logPujaRegError('deleteEditedImage pujareg update ERROR | ' . $e->getMessage()); }


        }
    }
    // export for sankalpa puja data
    function sankalpapujaexport() {
        $this->setIsAjax(true);

        $this->isAjax = true;

        GzObject::loadFiles('Model', array('SankalpaPuja'));
        $SankalpaPujaModel = new SankalpaPujaModel();
        //$BookingSlotModel = new BookingSlotModel();

        $output = "";

        $query = $SankalpaPujaModel->from($SankalpaPujaModel->getTable());

        $SankalpaPujaPrice = $query->fetchAll();

        foreach ($SankalpaPujaPrice[0] as $k => $v) {
            $output .= '"' . $k . '",';
        }
        $output .= "\n";

        foreach ($SankalpaPujaPrice as $key => $value) {

            $opts = array();
            $opts['member_id'] = $value['id'];
            $slots = $SankalpaPujaModel->getAll($opts);

            foreach ($value as $k => $v) {
                if ($k == 'date') {
                    $output .= '"' . date("Y-m-d H:i", $v) . '",';
                } else {
                    $output .= '"' . $v . '",';
                }
            }
            $output .= "\n";
        }

        $filename = "Sankalpapujadata" . time() . ".csv";

        header('Content-type: application/csv');
        header('Content-Disposition: attachment; filename=' . $filename);

        echo $output;
        exit;
    }

function getBadgeReport_15_september() {

    $this->isAjax = true;

    GzObject::loadFiles('Model', array('createBadgeReport'));
    $createBadgeReportModel = new createBadgeReportModel();

    $opts = array();
    $header_args = array( 'OID', 'Member_id', 'puja_type', 'RateType', 'First_name', 'Last_name', 'YTD', 'city', 'state', 'childYOB', 'veggie', 'SerialNum', 'Swap','SponsorshipLevel', 'Registrant');
 
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=badge_Report_Data_export.csv');
    $output = fopen( 'php://output', 'w' );
    ob_end_clean();
    fputcsv($output, $header_args, ',', '"', '\\');
    $reportarr = $createBadgeReportModel->getAll($opts);
        foreach ($reportarr as $data_item) {
            fputcsv($output, $data_item, ',', '"', '\\');
        }
    
    exit;
}

function getBadgeReport() {

    $this->isAjax = true;

    GzObject::loadFiles('Model', array('createBadgeReport'));
    $createBadgeReportModel = new createBadgeReportModel();

    $opts = array();
    $header_args = array('OID', 'Member_id', 'puja_type', 'RateType', 'senior' , 'discountseniorprice' , 'First_name', 'Last_name', 'YTD', 'city', 'state', 'childYOB', 'veggie', 'SerialNum', 'Swap', 'SponsorshipLevel', 'Registrant');

    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=badge_Report_Data_export.csv');
    $output = fopen('php://output', 'w');

    if (ob_get_length()) ob_end_clean(); // Clear output buffer
    fwrite($output, "\xEF\xBB\xBF");    // UTF-8 BOM for Excel

    fputcsv($output, $header_args, ',', '"', '\\');

    $reportarr = $createBadgeReportModel->getAll($opts);

    foreach ($reportarr as $data_item) {
        // SerialNum ko Excel me text ke roop me force karna (apostrophe nahi)
        if (isset($data_item['SerialNum'])) {
            $data_item['SerialNum'] = '="' . $data_item['SerialNum'] . '"';
        }

        fputcsv($output, $data_item, ',', '"', '\\');
    }

    fclose($output);
    exit;
}


function registrationDate(){
    GzObject::loadFiles('Model', array('pujaRegistrationDate','User', 'pujaregistrationsetting'));
    $pujaRegistrationDateModel = new pujaRegistrationDateModel();
    $UserModel = new UserModel();
    $PujaRegistrationSettingModel = new pujaregistrationsettingModel();

    if (!empty($_POST['registrationDate'])) {
        
        if ($this->isAdmin() || $this->isEditor()) {
            $id = $this->getUserId();
            $admin = $UserModel->get($id);
            $rolename = $admin['first'] . ' ' . $admin['last'];
            $_POST['admin_id'] = $admin['id'];
            $_POST['admin_name'] = $rolename;

        }
        
        $id = null;
        try { $id = $pujaRegistrationDateModel->update($_POST); } catch (Throwable $e) { $this->logPujaRegError('registrationDate update ERROR | ' . $e->getMessage()); }
        try {
            $parentYtdThreshold = preg_replace('/[^0-9.]/', '', (string) ($_POST['parent_ytd_threshold'] ?? '749'));
            if ($parentYtdThreshold === '') {
                $parentYtdThreshold = '749';
            }
            $PujaRegistrationSettingModel->updateActiveSettingValue(date('Y'), 'parent_ytd_threshold', $parentYtdThreshold);
        } catch (Throwable $e) { $this->logPujaRegError('registrationDate parent_ytd_threshold update ERROR | ' . $e->getMessage()); }
        //  $id = $pujaRegistrationDateModel->updatewithoutKey($_POST);


        if (!empty($id)) {
            $_SESSION['status'] = 20;
        } else {
            $_SESSION['status'] = 21;
        }

        if (!$this->isAdmin()) {
            Util::redirect(INSTALL_URL . "Admin/dashboard");
        } else {
            Util::redirect(INSTALL_URL . "Pujaregistration/index");
        }
    }
    
   }
   
   function projectedSponsarLevel()
    {
         GzObject::loadFiles('Model', array('pujaregistration', ));
         $pujaregistrationModel = new pujaregistrationModel();
        $memberid = $_POST["memberid"] ?? '';
       $result = $pujaregistrationModel->checkProjectedSponsarLevel($memberid);

    }
   
   
   
    function childBirthYear()
    {
        GzObject::loadFiles('Model', array('pujaregistrationChildBirthYear', 'User'));

        $pujaregistrationChildBirthYear = new pujaRegistrationChildBirthYearModel();
        $UserModel = new UserModel();
        if (!empty($_POST['birth_year'])) {

            // Admin details
            if ($this->isAdmin() || $this->isEditor()) {
                $id = $this->getUserId();
                $admin = $UserModel->get($id);
                $_POST['admin_id'] = $admin['id'];
                $_POST['admin_name'] = $admin['first'] . ' ' . $admin['last'];
            }

            $_POST['update_date'] = date('Y-m-d H:i:s');

            // Normalise year format if needed
            if (strlen($_POST['birth_year'] ?? '') === 4) {
                $_POST['birth_year'] ?? '';
            }
            
            // Get all valid schema columns
            $allowedFields = array_map(function ($field) {
                return $field['name'];
            }, $pujaregistrationChildBirthYear->schema);

            // Filter $_POST to allowed columns
            $filteredData = array_filter(
                $_POST,
                function ($key) use ($allowedFields) {
                    return in_array($key, $allowedFields);
                },
                ARRAY_FILTER_USE_KEY
            );

            // Fetch any existing row (we only care if *any* row exists)
            $allRows = $pujaregistrationChildBirthYear->getAll();
            if (!empty($allRows)) {
                // Update the first (and only) row
                $firstRow = $allRows[0];
                $filteredData['id'] = $firstRow['id'];
                try { $pujaregistrationChildBirthYear->update($filteredData); } catch (Throwable $e) { $this->logPujaRegError('childBirthYear update ERROR | ' . $e->getMessage()); }
                //  $pujaregistrationChildBirthYear->updatewithoutKey($filteredData);
            } else {
                // No row exists, insert a new one
                unset($filteredData['id']);
                try {
                    $pujaregistrationChildBirthYear
                        ->insertInto($pujaregistrationChildBirthYear->getTable(), $filteredData)
                        ->execute();
                } catch (Throwable $e) { $this->logPujaRegError('childBirthYear insert ERROR | ' . $e->getMessage()); }
            }


            // Redirect as required
            if (!$this->isAdmin()) {
                Util::redirect(INSTALL_URL . "Admin/dashboard");
            } else {
                Util::redirect(INSTALL_URL . "Pujaregistration/index");
            }
        }
    }
   






    }


?>
