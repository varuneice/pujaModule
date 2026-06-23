<?php

require_once CONTROLLERS_PATH . 'App.php';

class PujaDonations extends App {

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

        $this->js[] = array('file' => 'otp-member-verify.js?v=' . time(), 'path' => JS_PATH);
        $this->js[] = array('file' => 'GzDonation.js?v=' . time(), 'path' => JS_PATH);
        $this->js[] = array('file' => 'multiselect-dropdown.js?v=' . time(), 'path' => JS_PATH);
        $this->js[] = array('file' => 'loadingoverlay.js?v=' . time(), 'path' => JS_PATH);
    }

 function Membercheckregister()
    {
        GzObject::loadFiles('Model', array('ltdytdmember'));
        $ltdytdmemberModel = new ltdytdmemberModel();
       // $email = $_POST['email'] ?? '';
        $ltdytdmemberModel->Membercheckregister();   
    }

// function membercheck()
    // {
    //     GzObject::loadFiles('Model', array('Member'));
    //     $MemberModel = new MemberModel();
    //     $memberid = $_POST['memberid'] ?? '';
    //     $MemberModel->membercheck($memberid);   
    // }


    function AllMember() {
        $this->setIsAjax(true);
        GzObject::loadFiles('Model', array('ltdytdmember'));
       $ltdytdmemberModel = new ltdytdmemberModel();
        $arr = array();
        $Memberid=$_POST['memberid'] ?? '';
        $arr= $ltdytdmemberModel->AllMember($Memberid);
        foreach ($arr as $key => $value) { 
             echo  "<input  id='memberid' value='$value[Member_id]'/> ";
             echo  "<input  id='MemberName' value='$value[F_Name]'/> ";
             echo  "<input  id='middle_name' value='$value[M_Name]'/> ";
             echo  "<input  id='last_name' value='$value[L_Name]'/> ";
             echo  "<input  id='membershiptype' value='$value[membership_type]'/> ";
             echo  "<input  id='Spouse' value='$value[Sp_FName]'/> ";
             echo  "<input  id='Spouselast' value='$value[Sp_LName]'/> ";
             echo  "<input  id='ressidentalAddress' value='$value[Address1]'/> ";
             echo  "<input  id='Address' value='$value[Address2]'/> ";
             echo  "<input  id='Country' value='$value[Country]'/> ";
             echo  "<input  id='city' value='$value[City]'/> ";
             echo  "<input  id='state' value='$value[State]'/> ";
             echo  "<input  id='zip_code' value='$value[Zip]'/> ";
             echo  "<input  id='Tele1' value='$value[Tele1]'/> ";
             echo  "<input  id='phone_No' value='$value[Mob_No]'/> ";
             echo  "<input  id='phone_work' value='$value[Tele2]'/> ";
             echo  "<input  id='email' value='$value[email]'/> ";
             echo  "<input  id='ltd' value='$value[LTC]'/> ";
             echo  "<input  id='ytd' value='$value[YTD]'/> ";
             echo  "<input  id='membercategory' value='$value[Category]'/> ";
             echo "<input  id='tableid' value='$value[ID]'/> ";
             //echo  "<input  id='tableid' value='$value[ID]'/> ";
             echo  "<input  id='updatedate' value='$value[pay_date]'/> ";
             echo  "<input  id='gotra' value='$value[Gotra]'/> ";
             echo  "<input  id='payfor' value='$value[pay_for]'/> ";
                  
            }
       
    }
    
    function AllMemberNew() {
        $this->setIsAjax(true); // outputs directly — no view file exists

        // header('Access-Control-Allow-Origin: *');
        // header('data-Type:application/json; charset=UTF-8');
        // header('Content-Type: application/json; charset=UTF-8');

        // Use PDO with a prepared statement — fixes SQL injection on Member_id.
        try {
            $pdo = gz_pdo_connect(DEFAULT_HOST, DEFAULT_USER, DEFAULT_PASS, DEFAULT_DB);
        } catch (\PDOException $e) {
            error_log('[AllMemberNew] DB connection failed: ' . $e->getMessage());
            echo "0 results";
            return;
        }

        $Memberid = $_POST['memberid'] ?? ($_POST['member_id'] ?? '');
        if (!$Memberid && !empty($_SESSION['otp_verified_member'])) {
            $Memberid = $_SESSION['otp_verified_member'];
        }

        $stmt = $pdo->prepare("SELECT * FROM memberltdytd WHERE Member_id = ?");
        $stmt->execute([$Memberid]);
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        if (count($rows) > 0) {
          foreach ($rows as $value) {
             $mid = $value['Member_id'];
            $F_Name = $value['F_Name'];
            $M_Name = $value['M_Name'];
            $L_Name = $value['L_Name'];
            $membership_type = $value['membership_type'];
            // $Sp_FName = $value['Sp_FName'];
            // $Sp_LName = $value['Sp_LName'];
            $Address1 = $value['Address1'];
            $Address2 = $value['Address2'];
            
             
            if ($value["SpouseSal"] != "Late") {
                $Sp_FName = $value['Sp_FName'];
                $Sp_LName = $value['Sp_LName'];
            }

            $Address3 = $value['Address3'];

            $Country = $value['Country'];
            $City = $value['City'];
            $State = $value['State'];
            $Zip = $value['Zip'];
            $Tele1 = $value['Tele1'];
            $Mob_No = $value['Mob_No'];
            $Tele2 = $value['Tele2'];
            $email = $value['email'];

            $email2 = $value['Email2'];
            
            $child1 = $value['Child1'];
            $age1 = $value['Age1'];
             $child2 = $value['Child2'];
            $age2 = $value['Age2'];
            $child3 = $value['Child3'];
            $age3 = $value['Age3'];
            $parent1 = $value['Parent1'];
            $parent2 = $value['Parent2'];
            $LTC = $value['LTC'];
            $YTD = $value['YTD'];
            $Category = $value['Category'];
            $ID = $value['ID'];
            $pay_date = $value['pay_date'];
            $pay_for = $value['pay_for'];
            $Gotra = $value['Gotra'];
            $Senior = $value['Senior'];
            
            // h() (defined in functions.inc.php) applies htmlspecialchars — prevents XSS in HTML attribute values.
            echo  "<input  id='Senior' value='" . h($Senior) . "'/> ";
            echo  "<input  id='gotra' value='" . h($Gotra) . "'/> ";
            echo  "<input  id='memberid' value='" . h($mid) . "'/> ";
            echo  "<input  id='MemberName' value='" . h($F_Name) . "'/> ";
            echo  "<input  id='middle_name' value='" . h($M_Name) . "'/> ";
            echo  "<input  id='last_name' value='" . h($L_Name) . "'/> ";
            echo  "<input  id='membershiptype' value='" . h($membership_type) . "'/> ";
            echo  "<input  id='Spouse' value='" . h($Sp_FName) . "'/> ";
            echo  "<input  id='Spouselast' value='" . h($Sp_LName) . "'/> ";
            echo  "<input  id='ressidentalAddress' value='" . h($Address1) . "'/> ";
            echo  "<input  id='Address' value='" . h($Address2) . "'/> ";
            echo  "<input  id='unitAddress' value='" . h($Address3) . "'/> ";
            echo  "<input  id='Country' value='" . h($Country) . "'/> ";
            echo  "<input  id='city' value='" . h($City) . "'/> ";
            echo  "<input  id='state' value='" . h($State) . "'/> ";
            echo  "<input  id='zip_code' value='" . h($Zip) . "'/> ";
            echo  "<input  id='Tele1' value='" . h($Tele1) . "'/> ";
            echo  "<input  id='phone_No' value='" . h($Mob_No) . "'/> ";
            echo  "<input  id='phone_work' value='" . h($Tele2) . "'/> ";
            echo  "<input  id='email' value='" . h($email) . "'/> ";
            echo  "<input  id='email2' value='" . h($email2) . "'/> ";
            echo  "<input  id='child1' value='" . h($child1) . "'/> ";
            echo  "<input  id='age1' value='" . h($age1) . "'/> ";
            echo  "<input  id='child2' value='" . h($child2) . "'/> ";
            echo  "<input  id='age2' value='" . h($age2) . "'/> ";
            echo  "<input  id='child3' value='" . h($child3) . "'/> ";
            echo  "<input  id='age3' value='" . h($age3) . "'/> ";
            echo  "<input  id='parent1' value='" . h($parent1) . "'/> ";
            echo  "<input  id='parent2' value='" . h($parent2) . "'/> ";
            echo  "<input  id='ltd' value='" . h($LTC) . "'/> ";
            echo  "<input  id='ytd' value='" . h($YTD) . "'/> ";
            echo  "<input  id='membercategory' value='" . h($Category) . "'/> ";
            echo  "<input  id='tableid' value='" . h($ID) . "'/> ";
            echo  "<input  id='updatedate' value='" . h($pay_date) . "'/> ";
            echo  "<input  id='payfor' value='" . h($pay_for) . "'/> ";
          }
        } else {
          echo "0 results";
        }
        
    }
//function for update sankalpapuja & event option

function pujaparkingdata(){
    GzObject::loadFiles('Model', array('itemspujasponsor'));
    $itemspujasponsorModel = new itemspujasponsorModel();
    $donationid = $_POST['finaldonationid'] ?? '';
    $pujasankalpa = $_POST['sankalpapuja'] ?? '';
    $categone = $_POST['categone'] ?? '';
    $categtwo = $_POST['categtwo'] ?? '';
    $paydate = $_POST['paydate'] ?? '';
    $memberid = $_POST['member_idpay'] ?? '';
    $pujasankalpaattempt1 = $_POST['pujasankalpaattempt1'] ?? '';
    $pujasankalpaattempt2 = $_POST['pujasankalpaattempt2'] ?? '';
    $id = $itemspujasponsorModel->getMaxid() + 1;

   
    $value = array();
    $value['donationid'] = $donationid;
    $value['pujasankalpa'] = $pujasankalpa;
    $value['categone'] = $categone;
    $value['categtwo'] = $categtwo;
    $value['id'] =  $id;
    $value['paydate'] =  $paydate;
    $value['memberid'] =  $memberid;
    $value['pujasankalpaattempt1'] =  $pujasankalpaattempt1;
    $value['pujasankalpaattempt2'] =  $pujasankalpaattempt2;


    $itemspujasponsorModel->SaveData($value);
}


 function pujadonation()
    {
        $this->layout = 'login';
        GzObject::loadFiles('Model', array('Donation', 'ConfirmCode', 'Member', 'idnumbers', 'itemspujasponsor', 'User', 'sponsoritem' , 'noparking', 'pujaytdtier'));
        $DonationModel = new DonationModel();
        $ConfirmCodeModel = new ConfirmCodeModel();
        $MemberModel = new MemberModel();
        $idnumbersModel = new idnumbersModel();
        $itemspujasponsorModel = new itemspujasponsorModel();
        $UserModel = new UserModel();
        $sponsoritemModel = new sponsoritemModel();
        
         $noparkingModel = new noparkingModel();
        $PujaYtdTierModel = new pujaytdtierModel();
        $this->tpl['otp_admin_bypass'] = ($this->isAdmin() || $this->isEditor()) ? 1 : 0;
        $this->tpl['puja_ytd_tiers'] = array();
        try {
            $PujaYtdTierModel->ensureTable();
            $PujaYtdTierModel->seedDefaults(date('Y'));
            $this->tpl['puja_ytd_tiers'] = $PujaYtdTierModel->getActiveTiers(date('Y'));
        } catch (Throwable $tierEx) {
            error_log('[PujaDonations] YTD tier setup failed: ' . $tierEx->getMessage());
        }

        $this->tpl['members'] = $MemberModel->getAll();
        
        
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            unset($_SESSION['donation_payment_processed']);
        }

        if (!empty($_POST['create_donation'])) {
            $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
            if (RateLimit::isBlocked('payment', $ip)) {
                http_response_code(429);
                die("Too many payment submissions. Please wait 15 minutes before trying again.");
            }
            RateLimit::record('payment', $ip);

            if (isset($_SESSION['donation_payment_processed']) && $_SESSION['donation_payment_processed'] === true) {
                unset($_SESSION['donation_payment_processed']);
                Util::redirect(INSTALL_URL . "PujaDonations/pujadonation");
                exit();
            }

            unset($_SESSION['parkingMessage']);
            unset($_SESSION['seniorInput']);
            unset($_SESSION['pujaNameInput']);


            $data = array();
            $id = $DonationModel->getMaxid() + 1;
            $data['id'] = $id;
            date_default_timezone_set("America/Chicago");
            $today = date("Y/m/d");
            $_POST['pay_date'] = $today;
            //$_POST['pay_type'] = 'Puja Donation';
            $_POST['pay_type'] = 'Donation';
            $_POST['pay_for'] = 'DONATION / Unrestricted';
            $_POST['paymentfor'] = 'Puja Donation';
            // for generate oid 
            //$oid= Util::incrementalHash(4);
            $maxoid = $idnumbersModel->getMaxoid() + 1;
            $update_oid = $idnumbersModel->Updateoid($maxoid);
            $_POST['oid'] = $maxoid;
            // end generate oid for  
            $datamember = $MemberModel->checkduplicatemember();
            if ($datamember == null) {
                // for generate memberid for gd
                $maxid = $idnumbersModel->getMaxmid() + 1;
                $update_mid = $idnumbersModel->Updatemid($maxid);
                $_POST['Member_id'] = $maxid;
                // end generate memberid for gd 
            }
            if ($datamember != null) {
                $_POST['Member_id'] = $datamember;
                $existingdata = $MemberModel->checktele2($datamember);
                $alternatemobile = $existingdata[0]['Tele2'];

                // for update alternatetelephone no member case
                if ($alternatemobile == null || $alternatemobile != $_POST['alternatenumber'] ?? '') {
                    $mobileno = $_POST['alternatenumber'] ?? '';
                    $MemberModel->updatetelephone($datamember, $mobileno);
                }

                $primaryphone = $existingdata[0]['Tele1'];
                if ($primaryphone == null) {
                    $phone = $_POST['Tele1'] ?? '';
                    $MemberModel->updateprimaryno($datamember, $phone);
                }

                $email = $existingdata[0]['email'];
                if ($email == null) {
                    $email = $_POST['email'] ?? '';
                    $MemberModel->updateemail($datamember, $email);
                }

                $alternateemail = $existingdata[0]['Email2'];
                if ($alternateemail == null) {
                    $alternatemail = $_POST['alternateemail'] ?? '';
                    if ($alternatemail != "") {
                        $MemberModel->updupdatealternateemail($datamember, $alternateemail);
                    }

                }
            }
            //10julycomment & create new
            $firstname = $_POST['fisrtname'] ?? '';
            $lastname = $_POST['lastname'] ?? '';
            $_POST['MemberName'] = $firstname . ' ' . $lastname;

            $spfname = $_POST['spfname'] ?? '';
            $splname = $_POST['splname'] ?? '';
            $_POST['spousename'] = $spfname . ' ' . $splname;

            // $registermember = $_POST['MemberName'] ?? '';  
            // $regmember = $_POST['regmember'] ?? '';
            // if($regmember == "nonmember"){
            //     $nonmember = $_POST['namenonmember'] ?? ''; 
            //     $_POST['MemberName'] = $nonmember;
            // } else {

            //     $_POST['MemberName'] = $registermember;
            //     // $memberid = $_POST['demmember'] ?? ''; 
            //     // $_POST['Member_id'] = $memberid;
            // }



            if ($this->isAdmin() || $this->isEditor()) {
                $adminid = $this->getUserId();
                $admin = $UserModel->get($adminid);
                $rolename = $admin['first'] . ' ' . $admin['last'];
                $_POST['admin_id'] = $admin['id'];
                $_POST['admin_name'] = $rolename;

            }

            $DonationModel->save(array_merge($_POST, $data));
            
             if (($_POST['greenFieldParkingDecision'] ?? '') != "") {
                $noparkingModel->save(array_merge($_POST, $data));
            }

            if (!empty($id)) {

                if (($_POST['PaymentOption'] ?? '') == 'others') {

                    $opts = array();
                    $oid = $_POST['oid'] ?? '';
                    $cmCode = $_POST['code'] ?? '';
                    
                    $isAvailable = $ConfirmCodeModel->ConfirmCheckCode($cmCode);
                    if ($isAvailable)
                    {
                        
                   
                    $arr = $ConfirmCodeModel->UpdateCode($cmCode);
                    $_POST['transaction_id'] = $cmCode;
                    $opts['Confirmation'] = $_POST['confirm_code'] ?? '';
                    $arr = $ConfirmCodeModel->getAll($opts);
                    if ($oid != null) {
                        //if (!empty($arr[0])) {
                        $opts = array();
                        $opts['id'] = $id;
                        $opts['payment_status'] = 'succeeded';
                        $data = $_POST;
                        $DonationModel->update(array_merge($opts, $_POST));
                        $this->sendEmailDonations($data);
                        $memberid = $_POST['Member_id'] ?? '';
                        $confirmdata = $MemberModel->membercheck($memberid);
                        $_SESSION['memberregisterpuja'] = $confirmdata;
                        $pujareg = $itemspujasponsorModel->registersankalpapujacheck($memberid);
                        $_SESSION['pujareg'] = $pujareg;
                        $sponsoreventfirst = $itemspujasponsorModel->sponsorevent1check($memberid);
                        $_SESSION['sponsoreventfirst'] = $sponsoreventfirst;
                        $sponsoreventsecond = $itemspujasponsorModel->sponsorevent2check($memberid);
                        $_SESSION['sponsoreventsecond'] = $sponsoreventsecond;

                        $CategoryAarr = $sponsoritemModel->sponsorCategoryA();
                        $_SESSION['CategoryAarr'] = $CategoryAarr;

                        $CategoryBarr = $sponsoritemModel->sponsorCategoryB();
                        $_SESSION['CategoryBarr'] = $CategoryBarr;

                        $pujasankalpaattempt1arr = $itemspujasponsorModel->pujasankalpaattempt1($memberid);
                        $_SESSION['pujasankalpaattempt1arr'] = $pujasankalpaattempt1arr;

                        $pujasankalpaattempt2arr = $itemspujasponsorModel->pujasankalpaattempt2($memberid);
                        $_SESSION['pujasankalpaattempt2arr'] = $pujasankalpaattempt2arr;

                        $previousytd = $_POST['YTD'] ?? '';
                        $amountytd = $_POST['Amount'] ?? '';

                        $newytd = $previousytd + $amountytd;
                        $_SESSION['ytdvalue'] = $newytd;
                        $_SESSION['donationid'] = $id;
                        $categorymember = $_POST['membercategory'] ?? '';
                        $_SESSION['membercategory'] = $categorymember;
                        $_SESSION['parkingMessage'] = $_POST['parkingMessage'] ?? '';
                        $_SESSION['seniorInput'] = $_POST['seniorInput'] ?? '';
                        $_SESSION['pujaNameInput'] = $_POST['pujaNameInput'] ?? '';

                        if ($datamember == null) {
                            $value = array();
                            //    $value['id'] = $_POST['id'] ?? '';
                            $value['type'] = $_POST['type'] ?? '';
                            $value['gift'] = $_POST['gift'] ?? '';
                            $value['Payment_For'] = $_POST['Payment_For'] ?? '';
                            $value['MemberName'] = $_POST['MemberName'] ?? '';
                            $value['Amount'] = $_POST['Amount'] ?? '';
                            $value['PaymentOption'] = $_POST['PaymentOption'] ?? '';
                            $value['transaction_id'] = $_POST['transaction_id'] ?? '';
                            $value['payment_status'] = 'confirmed';
                            $value['update_on'] = $_POST['update_on'] ?? '';
                            $value['Member_id'] = $_POST['Member_id'] ?? '';
                            $value['pay_date'] = $_POST['pay_date'] ?? '';
                            $value['cc_name'] = $_POST['cc_name'] ?? '';
                            $value['remarks'] = $_POST['remarks'] ?? '';
                            $value['oid'] = $_POST['oid'] ?? '';
                            $value['pay_type'] = $_POST['pay_type'] ?? '';
                            $value['pay_for'] = $_POST['pay_for'] ?? '';
                            $value['Address'] = $_POST['Address'] ?? '';
                            $value['Street'] = $_POST['Street'] ?? '';
                            $value['State'] = $_POST['State'] ?? '';
                            $value['Zip_Code'] = $_POST['Zip_Code'] ?? '';
                            $value['Tele1'] = $_POST['phone'] ?? '';
                            $value['Tele2'] = $_POST['alternatenumber'] ?? '';
                            $value['email'] = $_POST['email'] ?? '';
                            $value['City'] = $_POST['City'] ?? '';
                            $value['eventdonation'] = $_POST['eventdonation'] ?? '';
                            $value['spousename'] = $_POST['spousename'] ?? '';
                            $value['purpose'] = $_POST['purpose'] ?? '';
                            $value['Address3'] = $_POST['Address3'] ?? '';
                            $MemberModel->SaveDataInmember($value);
                        }
                        $datefor = $_POST['pay_date'] ?? '';
                        $timestamp = !empty($datefor) ? strtotime($datefor) : false;
                        $payfinaldate = $timestamp ? date("m/d/Y", $timestamp) : '';
                        $mobileno = $data['alternatenumber'] ?? '';
                        if ($mobileno != '') {
                            $msg = 'Houston Durga Bari: Donation confirmation are Member Id: ' . $data['Member_id'] . ', Member Name: ' . $data['MemberName'] . ' , Amount: $' . $data['Amount'] . ', Pay Date: ' . $payfinaldate . ',  Order Id: ' . $data['oid'] . ', Status: ' . $opts['payment_status'];
                            $this->SendSMS($mobileno, $msg);
                        }
                        $this->tpl['arr'] = $DonationModel->get($id);
                         $_SESSION['donation_payment_processed'] = true;
                        //exit();
                    }
                    } else {
                        $_SESSION['status'] = 'Selected Zelle transaction is no longer available or has already been used. Please search and select the correct Zelle transaction again.';
                        $this->tpl['arr'] = array();
                    }
                }//  check
                elseif (($_POST['PaymentOption'] ?? '') == 'check') {
                    $_POST['amount'] = $_POST['checkAmount'] ?? '';
                    $_POST['bank'] = $_POST['checkbankname'] ?? '';
                    $_POST['chkdate'] = $_POST['CheckDate'] ?? '';
                    $_POST['DepositAccount'] = $_POST['CheckDepositAccount'] ?? '';
                    $_POST['payment_status'] = 'succeeded';
                    $donationpayid = $data['id'];
                    $_POST['id'] = $donationpayid;
                    $data = $_POST;
                    $DonationModel->update(array_merge($_POST));
                    $this->sendEmailDonations($data);
                    $memberid = $_POST['Member_id'] ?? '';
                    $confirmdata = $MemberModel->membercheck($memberid);
                    $_SESSION['memberregisterpuja'] = $confirmdata;
                    $pujareg = $itemspujasponsorModel->registersankalpapujacheck($memberid);
                    $_SESSION['pujareg'] = $pujareg;
                    $sponsoreventfirst = $itemspujasponsorModel->sponsorevent1check($memberid);
                    $_SESSION['sponsoreventfirst'] = $sponsoreventfirst;
                    $sponsoreventsecond = $itemspujasponsorModel->sponsorevent2check($memberid);
                    $_SESSION['sponsoreventsecond'] = $sponsoreventsecond;

                    $CategoryAarr = $sponsoritemModel->sponsorCategoryA();
                    $_SESSION['CategoryAarr'] = $CategoryAarr;

                    $CategoryBarr = $sponsoritemModel->sponsorCategoryB();
                    $_SESSION['CategoryBarr'] = $CategoryBarr;

                    $pujasankalpaattempt1arr = $itemspujasponsorModel->pujasankalpaattempt1($memberid);
                    $_SESSION['pujasankalpaattempt1arr'] = $pujasankalpaattempt1arr;

                    $pujasankalpaattempt2arr = $itemspujasponsorModel->pujasankalpaattempt2($memberid);
                    $_SESSION['pujasankalpaattempt2arr'] = $pujasankalpaattempt2arr;

                    $previousytd = $_POST['YTD'] ?? '';
                    $amountytd = $_POST['Amount'] ?? '';

                    $newytd = $previousytd + $amountytd;
                    $_SESSION['ytdvalue'] = $newytd;
                    $_SESSION['donationid'] = $donationpayid;
                    $categorymember = $_POST['membercategory'] ?? '';
                    $_SESSION['membercategory'] = $categorymember;
                    $_SESSION['parkingMessage'] = $_POST['parkingMessage'] ?? '';
                    $_SESSION['seniorInput'] = $_POST['seniorInput'] ?? '';
                    $_SESSION['pujaNameInput'] = $_POST['pujaNameInput'] ?? '';
                    if ($datamember == null) {
                        $value = array();
                        // $value['id'] = $_POST['id'] ?? '';
                        $value['type'] = $_POST['type'] ?? '';
                        $value['gift'] = $_POST['gift'] ?? '';
                        $value['Payment_For'] = $_POST['Payment_For'] ?? '';
                        $value['MemberName'] = $_POST['MemberName'] ?? '';
                        $value['Amount'] = $_POST['Amount'] ?? '';
                        $value['PaymentOption'] = $_POST['PaymentOption'] ?? '';
                        $value['payment_status'] = 'confirmed';
                        $value['transaction_id'] = $_POST['transaction_id'] ?? '';
                        $value['update_on'] = $_POST['update_on'] ?? '';
                        $value['Member_id'] = $_POST['Member_id'] ?? '';
                        $value['pay_date'] = $_POST['pay_date'] ?? '';
                        $value['cc_name'] = $_POST['cc_name'] ?? '';
                        $value['remarks'] = $_POST['remarks'] ?? '';
                        $value['oid'] = $_POST['oid'] ?? '';
                        $value['pay_type'] = $_POST['pay_type'] ?? '';
                        $value['pay_for'] = $_POST['pay_for'] ?? '';
                        $value['Address'] = $_POST['Address'] ?? '';
                        $value['Street'] = $_POST['Street'] ?? '';
                        $value['State'] = $_POST['State'] ?? '';
                        $value['Zip_Code'] = $_POST['Zip_Code'] ?? '';
                        $value['Tele1'] = $_POST['phone'] ?? '';
                        $value['Tele2'] = $_POST['alternatenumber'] ?? '';
                        $value['email'] = $_POST['email'] ?? '';
                        $value['City'] = $_POST['City'] ?? '';
                        $value['eventdonation'] = $_POST['eventdonation'] ?? '';
                        $value['spousename'] = $_POST['spousename'] ?? '';
                        $value['purpose'] = $_POST['purpose'] ?? '';
                        $value['Address3'] = $_POST['Address3'] ?? '';
                        $MemberModel->SaveDataInmember($value);
                    }
                    $datefor = $_POST['pay_date'] ?? '';
                    $timestamp = !empty($datefor) ? strtotime($datefor) : false;
                    $payfinaldate = $timestamp ? date("m/d/Y", $timestamp) : '';

                    $mobileno = $data['alternatenumber'];
                    if ($data['alternatenumber'] != null) {
                        $msg = 'Houston Durga Bari: Donation confirmation are Member Id: ' . $data['Member_id'] . ', Member Name: ' . $data['MemberName'] . ' , Amount: $' . $data['Amount'] . ', Pay Date: ' . $payfinaldate . ',  Order Id: ' . $data['oid'] . ', Status: ' . $data['payment_status'];
                        $this->SendSMS($mobileno, $msg);
                    }
                    $this->tpl['arr'] = $DonationModel->get($donationpayid);
                     $_SESSION['donation_payment_processed'] = true;
                    //exit();

                }
                //  cash
                elseif (($_POST['PaymentOption'] ?? '') == 'cash') {
                    $_POST['amount'] = $_POST['cashAmount'] ?? '';
                    $_POST['pay_date'] = $_POST['cashDate'] ?? '';
                    $_POST['DepositAccount'] = $_POST['CashDepositAccount'] ?? '';
                    $_POST['payment_status'] = 'succeeded';
                    $donationpayid = $data['id'];
                    $_POST['id'] = $donationpayid;
                    $data = $_POST;
                    $DonationModel->update(array_merge($_POST));
                    $this->sendEmailDonations($data);
                    $memberid = $_POST['Member_id'] ?? '';
                    $confirmdata = $MemberModel->membercheck($memberid);
                    $_SESSION['memberregisterpuja'] = $confirmdata;
                    $pujareg = $itemspujasponsorModel->registersankalpapujacheck($memberid);
                    $_SESSION['pujareg'] = $pujareg;
                    $sponsoreventfirst = $itemspujasponsorModel->sponsorevent1check($memberid);
                    $_SESSION['sponsoreventfirst'] = $sponsoreventfirst;
                    $sponsoreventsecond = $itemspujasponsorModel->sponsorevent2check($memberid);
                    $_SESSION['sponsoreventsecond'] = $sponsoreventsecond;
                    $CategoryAarr = $sponsoritemModel->sponsorCategoryA();
                    $_SESSION['CategoryAarr'] = $CategoryAarr;

                    $CategoryBarr = $sponsoritemModel->sponsorCategoryB();
                    $_SESSION['CategoryBarr'] = $CategoryBarr;

                    $pujasankalpaattempt1arr = $itemspujasponsorModel->pujasankalpaattempt1($memberid);
                    $_SESSION['pujasankalpaattempt1arr'] = $pujasankalpaattempt1arr;

                    $pujasankalpaattempt2arr = $itemspujasponsorModel->pujasankalpaattempt2($memberid);
                    $_SESSION['pujasankalpaattempt2arr'] = $pujasankalpaattempt2arr;
                    $previousytd = $_POST['YTD'] ?? '';
                    $amountytd = $_POST['Amount'] ?? '';

                    $newytd = $previousytd + $amountytd;
                    $_SESSION['ytdvalue'] = $newytd;
                    $_SESSION['donationid'] = $donationpayid;
                    $categorymember = $_POST['membercategory'] ?? '';
                    $_SESSION['membercategory'] = $categorymember;
                    $_SESSION['parkingMessage'] = $_POST['parkingMessage'] ?? '';
                    $_SESSION['seniorInput'] = $_POST['seniorInput'] ?? '';
                    $_SESSION['pujaNameInput'] = $_POST['pujaNameInput'] ?? '';
                    if ($datamember == null) {
                        $value = array();
                        // $value['id'] = $_POST['id'] ?? '';
                        $value['type'] = $_POST['type'] ?? '';
                        $value['gift'] = $_POST['gift'] ?? '';
                        $value['Payment_For'] = $_POST['Payment_For'] ?? '';
                        $value['MemberName'] = $_POST['MemberName'] ?? '';
                        $value['Amount'] = $_POST['Amount'] ?? '';
                        $value['PaymentOption'] = $_POST['PaymentOption'] ?? '';
                        $value['payment_status'] = 'confirmed';
                        $value['transaction_id'] = $_POST['transaction_id'] ?? '';
                        $value['update_on'] = $_POST['update_on'] ?? '';
                        $value['Member_id'] = $_POST['Member_id'] ?? '';
                        $value['pay_date'] = $_POST['pay_date'] ?? '';
                        $value['cc_name'] = $_POST['cc_name'] ?? '';
                        $value['remarks'] = $_POST['remarks'] ?? '';
                        $value['oid'] = $_POST['oid'] ?? '';
                        $value['pay_type'] = $_POST['pay_type'] ?? '';
                        $value['pay_for'] = $_POST['pay_for'] ?? '';
                        $value['Address'] = $_POST['Address'] ?? '';
                        $value['Street'] = $_POST['Street'] ?? '';
                        $value['State'] = $_POST['State'] ?? '';
                        $value['Zip_Code'] = $_POST['Zip_Code'] ?? '';
                        $value['Tele1'] = $_POST['phone'] ?? '';
                        $value['Tele2'] = $_POST['alternatenumber'] ?? '';
                        $value['email'] = $_POST['email'] ?? '';
                        $value['City'] = $_POST['City'] ?? '';
                        $value['eventdonation'] = $_POST['eventdonation'] ?? '';
                        $value['spousename'] = $_POST['spousename'] ?? '';
                        $value['purpose'] = $_POST['purpose'] ?? '';
                        $value['Address3'] = $_POST['Address3'] ?? '';
                        $MemberModel->SaveDataInmember($value);
                    }
                    $datefor = $_POST['pay_date'] ?? '';
                    $timestamp = !empty($datefor) ? strtotime($datefor) : false;
                    $payfinaldate = $timestamp ? date("m/d/Y", $timestamp) : '';
                    $mobileno = $data['alternatenumber'];
                    if ($data['alternatenumber'] != null) {
                        $msg = 'Houston Durga Bari: Donation confirmation are Member Id: ' . $data['Member_id'] . ', Member Name: ' . $data['MemberName'] . ' , Amount: $' . $data['Amount'] . ', Pay Date: ' . $payfinaldate . ',  Order Id: ' . $data['oid'] . ', Status: ' . $data['payment_status'];
                        $this->SendSMS($mobileno, $msg);
                    }
                    $this->tpl['arr'] = $DonationModel->get($donationpayid);
                     $_SESSION['donation_payment_processed'] = true;
                    //exit();

                }
                // directdeposite
                elseif (($_POST['PaymentOption'] ?? '') == 'directdeposit') {
                    $_POST['bank'] = $_POST['directbank'] ?? '';
                    $_POST['transaction_id'] = $_POST['transactioncode'] ?? '';
                    $_POST['amount'] = $_POST['directdepositeamount'] ?? '';
                    $_POST['pay_date'] = $_POST['transactiondate'] ?? '';
                    $_POST['DepositAccount'] = $_POST['DirectPayDepositAccount'] ?? '';
                    $_POST['payment_status'] = 'succeeded';
                    $donationpayid = $data['id'];
                    $_POST['id'] = $donationpayid;
                    $data = $_POST;
                    $DonationModel->update(array_merge($_POST));
                    $this->sendEmailDonations($data);
                    $memberid = $_POST['Member_id'] ?? '';
                    $confirmdata = $MemberModel->membercheck($memberid);
                    $_SESSION['memberregisterpuja'] = $confirmdata;
                    $pujareg = $itemspujasponsorModel->registersankalpapujacheck($memberid);
                    $_SESSION['pujareg'] = $pujareg;
                    $sponsoreventfirst = $itemspujasponsorModel->sponsorevent1check($memberid);
                    $_SESSION['sponsoreventfirst'] = $sponsoreventfirst;
                    $sponsoreventsecond = $itemspujasponsorModel->sponsorevent2check($memberid);
                    $_SESSION['sponsoreventsecond'] = $sponsoreventsecond;
                    $CategoryAarr = $sponsoritemModel->sponsorCategoryA();
                    $_SESSION['CategoryAarr'] = $CategoryAarr;

                    $CategoryBarr = $sponsoritemModel->sponsorCategoryB();
                    $_SESSION['CategoryBarr'] = $CategoryBarr;

                    $pujasankalpaattempt1arr = $itemspujasponsorModel->pujasankalpaattempt1($memberid);
                    $_SESSION['pujasankalpaattempt1arr'] = $pujasankalpaattempt1arr;

                    $pujasankalpaattempt2arr = $itemspujasponsorModel->pujasankalpaattempt2($memberid);
                    $_SESSION['pujasankalpaattempt2arr'] = $pujasankalpaattempt2arr;
                    $previousytd = $_POST['YTD'] ?? '';
                    $amountytd = $_POST['Amount'] ?? '';

                    $newytd = $previousytd + $amountytd;
                    $_SESSION['ytdvalue'] = $newytd;
                    $_SESSION['donationid'] = $donationpayid;
                    $categorymember = $_POST['membercategory'] ?? '';
                    $_SESSION['membercategory'] = $categorymember;

                    $_SESSION['parkingMessage'] = $_POST['parkingMessage'] ?? '';
                    $_SESSION['seniorInput'] = $_POST['seniorInput'] ?? '';
                    $_SESSION['pujaNameInput'] = $_POST['pujaNameInput'] ?? '';
                    if ($datamember == null) {
                        $value = array();
                        // $value['id'] = $_POST['id'] ?? '';
                        $value['type'] = $_POST['type'] ?? '';
                        $value['gift'] = $_POST['gift'] ?? '';
                        $value['Payment_For'] = $_POST['Payment_For'] ?? '';
                        $value['MemberName'] = $_POST['MemberName'] ?? '';
                        $value['Amount'] = $_POST['Amount'] ?? '';
                        $value['PaymentOption'] = $_POST['PaymentOption'] ?? '';
                        $value['payment_status'] = 'confirmed';
                        $value['transaction_id'] = $_POST['transaction_id'] ?? '';
                        $value['update_on'] = $_POST['update_on'] ?? '';
                        $value['Member_id'] = $_POST['Member_id'] ?? '';
                        $value['pay_date'] = $_POST['pay_date'] ?? '';
                        $value['cc_name'] = $_POST['cc_name'] ?? '';
                        $value['remarks'] = $_POST['remarks'] ?? '';
                        $value['oid'] = $_POST['oid'] ?? '';
                        $value['pay_type'] = $_POST['pay_type'] ?? '';
                        $value['pay_for'] = $_POST['pay_for'] ?? '';
                        $value['Address'] = $_POST['Address'] ?? '';
                        $value['Street'] = $_POST['Street'] ?? '';
                        $value['State'] = $_POST['State'] ?? '';
                        $value['Zip_Code'] = $_POST['Zip_Code'] ?? '';
                        $value['Tele1'] = $_POST['phone'] ?? '';
                        $value['Tele2'] = $_POST['alternatenumber'] ?? '';
                        $value['email'] = $_POST['email'] ?? '';
                        $value['City'] = $_POST['City'] ?? '';
                        $value['eventdonation'] = $_POST['eventdonation'] ?? '';
                        $value['spousename'] = $_POST['spousename'] ?? '';
                        $value['purpose'] = $_POST['purpose'] ?? '';
                        $value['Address3'] = $_POST['Address3'] ?? '';
                        $MemberModel->SaveDataInmember($value);
                    }
                    $datefor = $_POST['pay_date'] ?? '';
                    $timestamp = !empty($datefor) ? strtotime($datefor) : false;
                    $payfinaldate = $timestamp ? date("m/d/Y", $timestamp) : '';
                    $mobileno = $data['alternatenumber'];
                    if ($data['alternatenumber'] != null) {
                        $msg = 'Houston Durga Bari: Donation confirmation are Member Id: ' . $data['Member_id'] . ', Member Name: ' . $data['MemberName'] . ' , Amount: $' . $data['Amount'] . ', Pay Date: ' . $payfinaldate . ',  Order Id: ' . $data['oid'] . ', Status: ' . $data['payment_status'];
                        $this->SendSMS($mobileno, $msg);
                    }
                    $this->tpl['arr'] = $DonationModel->get($donationpayid);
                     $_SESSION['donation_payment_processed'] = true;
                    //exit();

                }
                // sumup
                elseif (($_POST['PaymentOption'] ?? '') == 'sumup') {
                    $_POST['amount'] = $_POST['sumupamount'] ?? '';
                    $_POST['transaction_id'] = $_POST['sumupid'] ?? '';
                    $_POST['pay_date'] = $_POST['sumupdate'] ?? '';
                    $_POST['DepositAccount'] = $_POST['SumUpDepositAccount'] ?? '';
                    $_POST['payment_status'] = 'succeeded';
                    $donationpayid = $data['id'];
                    $_POST['id'] = $donationpayid;
                    $data = $_POST;
                    $DonationModel->update(array_merge($_POST));
                    $this->sendEmailDonations($data);
                    $memberid = $_POST['Member_id'] ?? '';
                    $confirmdata = $MemberModel->membercheck($memberid);
                    $_SESSION['memberregisterpuja'] = $confirmdata;
                    $pujareg = $itemspujasponsorModel->registersankalpapujacheck($memberid);
                    $_SESSION['pujareg'] = $pujareg;
                    $sponsoreventfirst = $itemspujasponsorModel->sponsorevent1check($memberid);
                    $_SESSION['sponsoreventfirst'] = $sponsoreventfirst;
                    $sponsoreventsecond = $itemspujasponsorModel->sponsorevent2check($memberid);
                    $_SESSION['sponsoreventsecond'] = $sponsoreventsecond;
                    $CategoryAarr = $sponsoritemModel->sponsorCategoryA();
                    $_SESSION['CategoryAarr'] = $CategoryAarr;

                    $CategoryBarr = $sponsoritemModel->sponsorCategoryB();
                    $_SESSION['CategoryBarr'] = $CategoryBarr;

                    $pujasankalpaattempt1arr = $itemspujasponsorModel->pujasankalpaattempt1($memberid);
                    $_SESSION['pujasankalpaattempt1arr'] = $pujasankalpaattempt1arr;

                    $pujasankalpaattempt2arr = $itemspujasponsorModel->pujasankalpaattempt2($memberid);
                    $_SESSION['pujasankalpaattempt2arr'] = $pujasankalpaattempt2arr;

                    $previousytd = $_POST['YTD'] ?? '';
                    $amountytd = $_POST['Amount'] ?? '';

                    $newytd = $previousytd + $amountytd;
                    $_SESSION['ytdvalue'] = $newytd;
                    $_SESSION['donationid'] = $donationpayid;
                    $categorymember = $_POST['membercategory'] ?? '';
                    $_SESSION['membercategory'] = $categorymember;

                    $_SESSION['parkingMessage'] = $_POST['parkingMessage'] ?? '';
                    $_SESSION['seniorInput'] = $_POST['seniorInput'] ?? '';
                    $_SESSION['pujaNameInput'] = $_POST['pujaNameInput'] ?? '';
                    if ($datamember == null) {
                        $value = array();
                        // $value['id'] = $_POST['id'] ?? '';
                        $value['type'] = $_POST['type'] ?? '';
                        $value['gift'] = $_POST['gift'] ?? '';
                        $value['Payment_For'] = $_POST['Payment_For'] ?? '';
                        $value['MemberName'] = $_POST['MemberName'] ?? '';
                        $value['Amount'] = $_POST['Amount'] ?? '';
                        $value['PaymentOption'] = $_POST['PaymentOption'] ?? '';
                        $value['payment_status'] = 'confirmed';
                        $value['transaction_id'] = $_POST['transaction_id'] ?? '';
                        $value['update_on'] = $_POST['update_on'] ?? '';
                        $value['Member_id'] = $_POST['Member_id'] ?? '';
                        $value['pay_date'] = $_POST['pay_date'] ?? '';
                        $value['cc_name'] = $_POST['cc_name'] ?? '';
                        $value['remarks'] = $_POST['remarks'] ?? '';
                        $value['oid'] = $_POST['oid'] ?? '';
                        $value['pay_type'] = $_POST['pay_type'] ?? '';
                        $value['pay_for'] = $_POST['pay_for'] ?? '';
                        $value['Address'] = $_POST['Address'] ?? '';
                        $value['Street'] = $_POST['Street'] ?? '';
                        $value['State'] = $_POST['State'] ?? '';
                        $value['Zip_Code'] = $_POST['Zip_Code'] ?? '';
                        $value['Tele1'] = $_POST['phone'] ?? '';
                        $value['Tele2'] = $_POST['alternatenumber'] ?? '';
                        $value['email'] = $_POST['email'] ?? '';
                        $value['City'] = $_POST['City'] ?? '';
                        $value['eventdonation'] = $_POST['eventdonation'] ?? '';
                        $value['spousename'] = $_POST['spousename'] ?? '';
                        $value['purpose'] = $_POST['purpose'] ?? '';
                        $value['Address3'] = $_POST['Address3'] ?? '';
                        $MemberModel->SaveDataInmember($value);
                    }
                    $datefor = $_POST['pay_date'] ?? '';
                    $timestamp = !empty($datefor) ? strtotime($datefor) : false;
                    $payfinaldate = $timestamp ? date("m/d/Y", $timestamp) : '';
                    $mobileno = $data['alternatenumber'];
                    if ($data['alternatenumber'] != null) {
                        $msg = 'Houston Durga Bari: Donation confirmation are Member Id: ' . $data['Member_id'] . ', Member Name: ' . $data['MemberName'] . ' , Amount: $' . $data['Amount'] . ', Pay Date: ' . $payfinaldate . ',  Order Id: ' . $data['oid'] . ', Status: ' . $data['payment_status'];
                        $this->SendSMS($mobileno, $msg);
                    }
                    $this->tpl['arr'] = $DonationModel->get($donationpayid);
                     $_SESSION['donation_payment_processed'] = true;
                    //exit();

                } elseif (($_POST['PaymentOption'] ?? '') == 'zelleProxy') {
                    $_POST['amount'] = $_POST['proxyamount'] ?? '';
                    $_POST['transaction_id'] = $_POST['zelleProxyTid'] ?? '';
                    $_POST['pay_date'] = $_POST['proxydate'] ?? '';
                    $_POST['DepositAccount'] = $_POST['zelleProxyDepositAccount'] ?? '';
                    $_POST['payment_status'] = 'succeeded';
                    $donationpayid = $data['id'];
                    $donationpayid = $data['id'];
                    $_POST['id'] = $donationpayid;
                    $data = $_POST;
                    $DonationModel->update(array_merge($_POST));
                    $this->sendEmailDonations($data);
                    $memberid = $_POST['Member_id'] ?? '';
                    $confirmdata = $MemberModel->membercheck($memberid);
                    $_SESSION['memberregisterpuja'] = $confirmdata;
                    $pujareg = $itemspujasponsorModel->registersankalpapujacheck($memberid);
                    $_SESSION['pujareg'] = $pujareg;
                    $sponsoreventfirst = $itemspujasponsorModel->sponsorevent1check($memberid);
                    $_SESSION['sponsoreventfirst'] = $sponsoreventfirst;
                    $sponsoreventsecond = $itemspujasponsorModel->sponsorevent2check($memberid);
                    $_SESSION['sponsoreventsecond'] = $sponsoreventsecond;
                    $CategoryAarr = $sponsoritemModel->sponsorCategoryA();
                    $_SESSION['CategoryAarr'] = $CategoryAarr;

                    $CategoryBarr = $sponsoritemModel->sponsorCategoryB();
                    $_SESSION['CategoryBarr'] = $CategoryBarr;

                    $pujasankalpaattempt1arr = $itemspujasponsorModel->pujasankalpaattempt1($memberid);
                    $_SESSION['pujasankalpaattempt1arr'] = $pujasankalpaattempt1arr;

                    $pujasankalpaattempt2arr = $itemspujasponsorModel->pujasankalpaattempt2($memberid);
                    $_SESSION['pujasankalpaattempt2arr'] = $pujasankalpaattempt2arr;

                    $previousytd = $_POST['YTD'] ?? '';
                    $amountytd = $_POST['Amount'] ?? '';

                    $newytd = $previousytd + $amountytd;
                    $_SESSION['ytdvalue'] = $newytd;
                    $_SESSION['donationid'] = $donationpayid;
                    $categorymember = $_POST['membercategory'] ?? '';
                    $_SESSION['membercategory'] = $categorymember;

                    $_SESSION['parkingMessage'] = $_POST['parkingMessage'] ?? '';
                    $_SESSION['seniorInput'] = $_POST['seniorInput'] ?? '';
                    $_SESSION['pujaNameInput'] = $_POST['pujaNameInput'] ?? '';
                    if ($datamember == null) {
                        $value = array();
                        // $value['id'] = $_POST['id'] ?? '';
                        $value['type'] = $_POST['type'] ?? '';
                        $value['gift'] = $_POST['gift'] ?? '';
                        $value['Payment_For'] = $_POST['Payment_For'] ?? '';
                        $value['MemberName'] = $_POST['MemberName'] ?? '';
                        $value['Amount'] = $_POST['Amount'] ?? '';
                        $value['PaymentOption'] = $_POST['PaymentOption'] ?? '';
                        $value['payment_status'] = 'confirmed';
                        $value['transaction_id'] = $_POST['transaction_id'] ?? '';
                        $value['update_on'] = $_POST['update_on'] ?? '';
                        $value['Member_id'] = $_POST['Member_id'] ?? '';
                        $value['pay_date'] = $_POST['pay_date'] ?? '';
                        $value['cc_name'] = $_POST['cc_name'] ?? '';
                        $value['remarks'] = $_POST['remarks'] ?? '';
                        $value['oid'] = $_POST['oid'] ?? '';
                        $value['pay_type'] = $_POST['pay_type'] ?? '';
                        $value['pay_for'] = $_POST['pay_for'] ?? '';
                        $value['Address'] = $_POST['Address'] ?? '';
                        $value['Street'] = $_POST['Street'] ?? '';
                        $value['State'] = $_POST['State'] ?? '';
                        $value['Zip_Code'] = $_POST['Zip_Code'] ?? '';
                        $value['Tele1'] = $_POST['phone'] ?? '';
                        $value['Tele2'] = $_POST['alternatenumber'] ?? '';
                        $value['email'] = $_POST['email'] ?? '';
                        $value['City'] = $_POST['City'] ?? '';
                        $value['eventdonation'] = $_POST['eventdonation'] ?? '';
                        $value['spousename'] = $_POST['spousename'] ?? '';
                        $value['purpose'] = $_POST['purpose'] ?? '';
                        $value['Address3'] = $_POST['Address3'] ?? '';
                        $MemberModel->SaveDataInmember($value);
                    }
                    $datefor = $_POST['pay_date'] ?? '';
                    $timestamp = !empty($datefor) ? strtotime($datefor) : false;
                    $payfinaldate = $timestamp ? date("m/d/Y", $timestamp) : '';
                    $mobileno = $data['alternatenumber'];
                    if ($data['alternatenumber'] != null) {
                        $msg = 'Houston Durga Bari: Donation confirmation are Member Id: ' . $data['Member_id'] . ', Member Name: ' . $data['MemberName'] . ' , Amount: $' . $data['Amount'] . ', Pay Date: ' . $payfinaldate . ',  Order Id: ' . $data['oid'] . ', Status: ' . $data['payment_status'];
                        $this->SendSMS($mobileno, $msg);
                    }
                    $this->tpl['arr'] = $DonationModel->get($donationpayid);
                     $_SESSION['donation_payment_processed'] = true;


                } elseif (($_POST['PaymentOption'] ?? '') == 'stripe') {

                    $amount = $_POST['Amount'] ?? '';

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

                        $payment = Stripe_Charge::create(array(
                            "amount" => $amount,
                            "currency" => $this->tpl["option_arr_values"]["currency"],
                            "card" => $_POST['stripeToken'] ?? '',
                            "description" => "Pay For:" . ($_POST['pay_type'] ?? '') . ', ' . "Email:" . ($_POST['email'] ?? '') . ', ' . "Full Name:" . ($_POST['MemberName'] ?? ''),
                            "metadata" => ["orderid" => $oid]
                        ));

                        $this->tpl['payment']['balance_transaction'] = $payment->balance_transaction;
                        $this->tpl['payment']['amount'] = $payment->amount;
                        $this->tpl['payment']['status'] = $payment->status;
                        $this->tpl['payment']['currency'] = $payment->currency;

                        if ($payment->status == 'succeeded') {

                            $opts = array();
                            //$donationpayid = $_POST['id'] ?? '';
                            //$_POST['id'] =  $donationid;
                            $id = $data['id'];
                            $opts['id'] = $data['id'];
                            $opts['stripe_return'] = $payment->status;
                            $opts['transaction_id'] = $payment->id;
                            $opts['paid_amount'] = $payment->amount;
                            $opts['stripe_product'] = $payment->description;
                            //$opts['payment_status'] = 'confirmed';
                            $opts['payment_status'] = 'succeeded';
                            $opts['payment_timestamp'] = time();
                            $data = $_POST;
                            $DonationModel->update(array_merge($opts, $_POST));
                            $this->sendEmailDonations($data);
                            $memberid = $_POST['Member_id'] ?? '';
                            $confirmdata = $MemberModel->membercheck($memberid);
                            $_SESSION['memberregisterpuja'] = $confirmdata;
                            $pujareg = $itemspujasponsorModel->registersankalpapujacheck($memberid);
                            $_SESSION['pujareg'] = $pujareg;
                            $sponsoreventfirst = $itemspujasponsorModel->sponsorevent1check($memberid);
                            $_SESSION['sponsoreventfirst'] = $sponsoreventfirst;
                            $sponsoreventsecond = $itemspujasponsorModel->sponsorevent2check($memberid);
                            $_SESSION['sponsoreventsecond'] = $sponsoreventsecond;
                            $CategoryAarr = $sponsoritemModel->sponsorCategoryA();
                            $_SESSION['CategoryAarr'] = $CategoryAarr;

                            $CategoryBarr = $sponsoritemModel->sponsorCategoryB();
                            $_SESSION['CategoryBarr'] = $CategoryBarr;

                            $pujasankalpaattempt1arr = $itemspujasponsorModel->pujasankalpaattempt1($memberid);
                            $_SESSION['pujasankalpaattempt1arr'] = $pujasankalpaattempt1arr;

                            $pujasankalpaattempt2arr = $itemspujasponsorModel->pujasankalpaattempt2($memberid);
                            $_SESSION['pujasankalpaattempt2arr'] = $pujasankalpaattempt2arr;

                            $previousytd = $_POST['YTD'] ?? 0;
                            $amountytd = $_POST['Amount'] ?? 0;

                            $newytd = (float)$previousytd + (float)$amountytd;
                            $_SESSION['ytdvalue'] = $newytd;
                            $_SESSION['donationid'] = $id;
                            $categorymember = $_POST['membercategory'] ?? '';
                            $_SESSION['membercategory'] = $categorymember;

                            $_SESSION['parkingMessage'] = $_POST['parkingMessage'] ?? '';
                            $_SESSION['seniorInput'] = $_POST['seniorInput'] ?? '';
                            $_SESSION['pujaNameInput'] = $_POST['pujaNameInput'] ?? '';


                            if ($datamember == null) {
                                $value = array();
                                // $value['id'] = $_POST['id'] ?? '';
                                $value['type'] = $_POST['type'] ?? '';
                                $value['gift'] = $_POST['gift'] ?? '';
                                $value['Payment_For'] = $_POST['Payment_For'] ?? '';
                                $value['MemberName'] = $_POST['MemberName'] ?? '';
                                $value['Amount'] = $_POST['Amount'] ?? '';
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
                                $value['Address'] = $_POST['Address'] ?? '';
                                $value['Street'] = $_POST['Street'] ?? '';
                                $value['State'] = $_POST['State'] ?? '';
                                $value['Zip_Code'] = $_POST['Zip_Code'] ?? '';
                                $value['Tele1'] = $_POST['phone'] ?? '';
                                $value['Tele2'] = $_POST['alternatenumber'] ?? '';
                                $value['email'] = $_POST['email'] ?? '';
                                $value['City'] = $_POST['City'] ?? '';
                                $value['eventdonation'] = $_POST['eventdonation'] ?? '';
                                $value['spousename'] = $_POST['spousename'] ?? '';
                                $value['purpose'] = $_POST['purpose'] ?? '';
                                $value['Address3'] = $_POST['Address3'] ?? '';
                                $MemberModel->SaveDataInmember($value);
                            }
                            $datefor = $_POST['pay_date'] ?? '';
                            $timestamp = !empty($datefor) ? strtotime($datefor) : false;
                            $payfinaldate = $timestamp ? date("m/d/Y", $timestamp) : '';
                            $mobileno = $data['alternatenumber'];
                            if ($data['alternatenumber'] != null) {
                                $msg = 'Houston Durga Bari: Donation confirmation are Member Id: ' . $data['Member_id'] . ', Member Name: ' . $data['MemberName'] . ' , Amount: $' . $data['Amount'] . ', Pay Date: ' . $payfinaldate . ',  Order Id: ' . $data['oid'] . ', Status: ' . $opts['payment_status'];
                                $this->SendSMS($mobileno, $msg);
                            }

                            $this->tpl['arr'] = $DonationModel->get($id);
                             $_SESSION['donation_payment_processed'] = true;
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

                    $this->tpl['arr'] = $DonationModel->get($id);
                    $this->tpl['arr']['amount'] = $total;
                } else {
                    $_SESSION['status'] = 16;

                }
            } else {
                $_SESSION['status'] = 17;
            }
        }

    }

    function pujadonation2July() { 
        $this->layout = 'login';
        GzObject::loadFiles('Model', array('Donation', 'ConfirmCode', 'Member', 'idnumbers','itemspujasponsor','User', 'sponsoritem'));
        $DonationModel = new DonationModel();
        $ConfirmCodeModel = new ConfirmCodeModel();
        $MemberModel = new MemberModel();
        $idnumbersModel = new idnumbersModel();
        $itemspujasponsorModel = new itemspujasponsorModel();
        $UserModel = new UserModel();
        $sponsoritemModel = new sponsoritemModel();
   
        $this->tpl['members'] = $MemberModel->getAll();
        
        if (!empty($_POST['create_donation'])) {

            $data = array();
            $id = $DonationModel->getMaxid() + 1;
            $data['id'] = $id;
            date_default_timezone_set("America/Chicago");
            $today = date("Y/m/d"); 
            $_POST['pay_date'] = $today;
           //$_POST['pay_type'] = 'Puja Donation';
            $_POST['pay_type'] = 'Donation';
            $_POST['pay_for'] = 'DONATION / Unrestricted';
            $_POST['paymentfor'] = 'Puja Donation';
            // for generate oid 
            //$oid= Util::incrementalHash(4);
            $maxoid = $idnumbersModel->getMaxoid() + 1;
            $update_oid = $idnumbersModel->Updateoid($maxoid);
             $_POST['oid'] = $maxoid;
        // end generate oid for  
         $datamember =  $MemberModel->checkduplicatemember();
            if($datamember == null){
                 // for generate memberid for gd
                    $maxid = $idnumbersModel->getMaxmid() + 1;
                     $update_mid = $idnumbersModel->Updatemid($maxid);
                     $_POST['Member_id'] = $maxid;
                // end generate memberid for gd 
            }
             if ($datamember != null) {
                 $_POST['Member_id'] = $datamember;
                  $existingdata = $MemberModel->checktele2($datamember);
                 $alternatemobile = $existingdata[0]['Tele2'];
                 
                 // for update alternatetelephone no member case
                if($alternatemobile == null || $alternatemobile != $_POST['alternatenumber'] ?? '' ){
                    $mobileno =  $_POST['alternatenumber'] ?? '';
                    $MemberModel->updatetelephone($datamember, $mobileno);
                }

                $primaryphone =$existingdata[0]['Tele1'];
                if($primaryphone == null){
                    $phone =  $_POST['Tele1'] ?? '';
                    $MemberModel->updateprimaryno($datamember, $phone);
                }
                
                $email =$existingdata[0]['email'];
                if($email == null){
                    $email =  $_POST['email'] ?? '';
                    $MemberModel->updateemail($datamember, $email);
                }

                $alternateemail = $existingdata[0]['Email2'];
                if($alternateemail == null){
                    $alternatemail =  $_POST['alternateemail'] ?? '';
                    if( $alternatemail != ""){
                        $MemberModel->updupdatealternateemail($datamember, $alternateemail);
                    }
                    
                }
             }
             //10julycomment & create new
             $firstname = $_POST['fisrtname'] ?? '';  
             $lastname = $_POST['lastname'] ?? '';  
             $_POST['MemberName'] = $firstname.' '.$lastname;

             $spfname = $_POST['spfname'] ?? '';  
             $splname = $_POST['splname'] ?? '';  
             $_POST['spousename'] = $spfname.' '.$splname;
             
            // $registermember = $_POST['MemberName'] ?? '';  
            // $regmember = $_POST['regmember'] ?? '';
            // if($regmember == "nonmember"){
            //     $nonmember = $_POST['namenonmember'] ?? ''; 
            //     $_POST['MemberName'] = $nonmember;
            // } else {
                
            //     $_POST['MemberName'] = $registermember;
            //     // $memberid = $_POST['demmember'] ?? ''; 
            //     // $_POST['Member_id'] = $memberid;
            // }
            
            

            if ($this->isAdmin() || $this->isEditor()) {
                $id = $this->getUserId();
                $admin = $UserModel->get($id);
                $rolename = $admin['first'].' '.$admin['last'];
                $_POST['admin_id'] = $admin['id'];
                $_POST['admin_name'] = $rolename;

            }

            $DonationModel->save(array_merge($_POST, $data));

            if (!empty($id)) {

                if (($_POST['PaymentOption'] ?? '') == 'others') {
                    
                    $opts = array();
                    $oid = $_POST['oid'] ?? '';
                    $cmCode=$_POST['code'] ?? '';
                    $arr= $ConfirmCodeModel->UpdateCode($cmCode);
                    $_POST['transaction_id'] =  $cmCode;
                    $opts['Confirmation'] = $_POST['confirm_code'] ?? '';
                   $arr = $ConfirmCodeModel->getAll($opts);
                    if ($oid !=null){
                    //if (!empty($arr[0])) {
                        $opts = array();
                        $opts['id'] = $id;
                        $opts['payment_status'] = 'succeeded';
                        $data = $_POST;
                        $DonationModel->update(array_merge($opts, $_POST));
                        $this->sendEmailDonations($data);
                        $memberid = $_POST['Member_id'] ?? '';
                   $confirmdata =  $MemberModel->membercheck($memberid); 
                   $_SESSION['memberregisterpuja'] = $confirmdata; 
                   $pujareg =  $itemspujasponsorModel->registersankalpapujacheck($memberid);
                   $_SESSION['pujareg'] = $pujareg;
                   $sponsoreventfirst =  $itemspujasponsorModel->sponsorevent1check($memberid);
                   $_SESSION['sponsoreventfirst'] = $sponsoreventfirst;
                   $sponsoreventsecond =  $itemspujasponsorModel->sponsorevent2check($memberid);
                   $_SESSION['sponsoreventsecond'] = $sponsoreventsecond;

                   $CategoryAarr = $sponsoritemModel->sponsorCategoryA();
                   $_SESSION['CategoryAarr'] = $CategoryAarr;

                   $CategoryBarr = $sponsoritemModel->sponsorCategoryB();
                   $_SESSION['CategoryBarr'] = $CategoryBarr;
                   
                  $pujasankalpaattempt1arr = $itemspujasponsorModel->pujasankalpaattempt1($memberid);
                  $_SESSION['pujasankalpaattempt1arr'] = $pujasankalpaattempt1arr;

                  $pujasankalpaattempt2arr = $itemspujasponsorModel->pujasankalpaattempt2($memberid);
                  $_SESSION['pujasankalpaattempt2arr'] = $pujasankalpaattempt2arr;

                   $previousytd = $_POST['YTD'] ?? '';
                   $amountytd =$_POST['Amount'] ?? '';
                   
                   $newytd = $previousytd + $amountytd; 
                   $_SESSION['ytdvalue'] = $newytd; 
                   $_SESSION['donationid'] = $id;
                   $categorymember =  $_POST['membercategory'] ?? '';
                   $_SESSION['membercategory'] =  $categorymember;

                         if($datamember == null) {
                            $value = array();
                            //    $value['id'] = $_POST['id'] ?? '';
                                $value['type'] = $_POST['type'] ?? '';
                                $value['gift'] = $_POST['gift'] ?? '';
                                $value['Payment_For'] = $_POST['Payment_For'] ?? '';
                                $value['MemberName'] = $_POST['MemberName'] ?? '';
                                $value['Amount'] = $_POST['Amount'] ?? '';
                                $value['PaymentOption'] = $_POST['PaymentOption'] ?? '';
                                $value['transaction_id'] = $_POST['transaction_id'] ?? '';
                                $value['payment_status'] = 'confirmed';
                                $value['update_on'] = $_POST['update_on'] ?? '';
                                $value['Member_id'] = $_POST['Member_id'] ?? '';
                                $value['pay_date'] = $_POST['pay_date'] ?? '';
                                $value['cc_name'] = $_POST['cc_name'] ?? '';
                                $value['remarks'] = $_POST['remarks'] ?? '';
                                $value['oid'] = $_POST['oid'] ?? '';
                                $value['pay_type'] = $_POST['pay_type'] ?? '';
                                $value['pay_for'] = $_POST['pay_for'] ?? '';
                                $value['Address'] = $_POST['Address'] ?? '';
                                $value['Street'] = $_POST['Street'] ?? '';
                                $value['State'] = $_POST['State'] ?? '';
                                $value['Zip_Code'] = $_POST['Zip_Code'] ?? '';
                                $value['Tele1'] = $_POST['phone'] ?? '';
                                $value['Tele2'] = $_POST['alternatenumber'] ?? '';
                                $value['email'] = $_POST['email'] ?? '';
                                 $value['City'] = $_POST['City'] ?? '';
                                 $value['eventdonation'] = $_POST['eventdonation'] ?? '';
                                 $value['spousename'] = $_POST['spousename'] ?? '';
                                 $value['purpose'] = $_POST['purpose'] ?? '';
                                 $value['Address3'] = $_POST['Address3'] ?? '';
                                  $MemberModel->SaveDataInmember($value);
                         }
                         $datefor =$_POST['pay_date'] ?? '';
                                    $timestamp = !empty($datefor) ? strtotime($datefor) : false;
                                    $payfinaldate = $timestamp ? date("m/d/Y", $timestamp) : '';
                         $mobileno= $data['alternatenumber'];   
                        if ($data['alternatenumber'] != null) {
                            $msg = 'Houston Durga Bari: Donation confirmation are Member Id: '. $data['Member_id'].', Member Name: '. $data['MemberName'].' , Amount: $'. $data['Amount'].', Pay Date: '. $payfinaldate.',  Order Id: '. $data['oid'].', Status: ' . $opts['payment_status']  ;
                            $this->SendSMS($mobileno, $msg);
                            }
                            $this->tpl['arr'] = $DonationModel->get($id);
                        //exit();
                    }
                }//  check
                elseif (($_POST['PaymentOption'] ?? '') == 'check') {
                    $_POST['amount'] = $_POST['checkAmount'] ?? '';
                    $_POST['bank'] = $_POST['checkbankname'] ?? '';
                    $_POST['chkdate'] = $_POST['CheckDate'] ?? '';
                    $_POST['DepositAccount'] = $_POST['CheckDepositAccount'] ?? '';
                    $_POST['payment_status'] = 'succeeded';
                    $donationpayid = $data['id'];
                    $_POST['id'] =  $donationpayid;
                    $data = $_POST;
                    $DonationModel->update(array_merge($_POST));
                    $this->sendEmailDonations($data);
                    $memberid = $_POST['Member_id'] ?? '';
                   $confirmdata =  $MemberModel->membercheck($memberid); 
                   $_SESSION['memberregisterpuja'] = $confirmdata; 
                   $pujareg =  $itemspujasponsorModel->registersankalpapujacheck($memberid);
                   $_SESSION['pujareg'] = $pujareg;
                   $sponsoreventfirst =  $itemspujasponsorModel->sponsorevent1check($memberid);
                   $_SESSION['sponsoreventfirst'] = $sponsoreventfirst;
                   $sponsoreventsecond =  $itemspujasponsorModel->sponsorevent2check($memberid);
                   $_SESSION['sponsoreventsecond'] = $sponsoreventsecond;
                   
                   $CategoryAarr = $sponsoritemModel->sponsorCategoryA();
                   $_SESSION['CategoryAarr'] = $CategoryAarr;

                  $CategoryBarr = $sponsoritemModel->sponsorCategoryB();
                  $_SESSION['CategoryBarr'] = $CategoryBarr;
                  
                  $pujasankalpaattempt1arr = $itemspujasponsorModel->pujasankalpaattempt1($memberid);
                  $_SESSION['pujasankalpaattempt1arr'] = $pujasankalpaattempt1arr;

                  $pujasankalpaattempt2arr = $itemspujasponsorModel->pujasankalpaattempt2($memberid);
                  $_SESSION['pujasankalpaattempt2arr'] = $pujasankalpaattempt2arr;
                   
                   $previousytd = $_POST['YTD'] ?? '';
                   $amountytd =$_POST['Amount'] ?? '';
                   
                   $newytd = $previousytd + $amountytd; 
                   $_SESSION['ytdvalue'] = $newytd; 
                   $_SESSION['donationid'] = $donationpayid;
                   $categorymember =  $_POST['membercategory'] ?? '';
                   $_SESSION['membercategory'] =  $categorymember;
                   if($datamember == null) {
                       $value = array();
                       // $value['id'] = $_POST['id'] ?? '';
                       $value['type'] = $_POST['type'] ?? '';
                       $value['gift'] = $_POST['gift'] ?? '';
                       $value['Payment_For'] = $_POST['Payment_For'] ?? '';
                       $value['MemberName'] = $_POST['MemberName'] ?? '';
                       $value['Amount'] = $_POST['Amount'] ?? '';
                       $value['PaymentOption'] = $_POST['PaymentOption'] ?? '';
                       $value['payment_status'] = 'confirmed';
                       $value['transaction_id'] = $_POST['transaction_id'] ?? '';
                       $value['update_on'] = $_POST['update_on'] ?? '';
                       $value['Member_id'] = $_POST['Member_id'] ?? '';
                       $value['pay_date'] = $_POST['pay_date'] ?? '';
                       $value['cc_name'] = $_POST['cc_name'] ?? '';
                       $value['remarks'] = $_POST['remarks'] ?? '';
                       $value['oid'] = $_POST['oid'] ?? '';
                       $value['pay_type'] = $_POST['pay_type'] ?? '';
                       $value['pay_for'] = $_POST['pay_for'] ?? '';
                       $value['Address'] = $_POST['Address'] ?? '';
                       $value['Street'] = $_POST['Street'] ?? '';
                       $value['State'] = $_POST['State'] ?? '';
                       $value['Zip_Code'] = $_POST['Zip_Code'] ?? '';
                       $value['Tele1'] = $_POST['phone'] ?? '';
                       $value['Tele2'] = $_POST['alternatenumber'] ?? '';
                       $value['email'] = $_POST['email'] ?? '';
                       $value['City'] = $_POST['City'] ?? '';
                       $value['eventdonation'] = $_POST['eventdonation'] ?? '';
                       $value['spousename'] = $_POST['spousename'] ?? '';
                       $value['purpose'] = $_POST['purpose'] ?? '';
                       $value['Address3'] = $_POST['Address3'] ?? '';
                       $MemberModel->SaveDataInmember($value);
                   }
                  $datefor =$_POST['pay_date'] ?? '';
                           $timestamp = !empty($datefor) ? strtotime($datefor) : false;
                           $payfinaldate = $timestamp ? date("m/d/Y", $timestamp) : '';
                    
                    $mobileno= $data['alternatenumber'];
                   if ($data['alternatenumber'] != null) {
                       $msg = 'Houston Durga Bari: Donation confirmation are Member Id: '. $data['Member_id'].', Member Name: '. $data['MemberName'].' , Amount: $'. $data['Amount'].', Pay Date: '. $payfinaldate.',  Order Id: '. $data['oid'].', Status: ' . $data['payment_status']  ;
                       $this->SendSMS($mobileno, $msg);
                       }
                       $this->tpl['arr'] = $DonationModel->get($donationpayid);
                    //exit();

                }
                //  cash
                elseif (($_POST['PaymentOption'] ?? '') == 'cash') {
                    $_POST['amount'] = $_POST['cashAmount'] ?? '';
                    $_POST['pay_date'] = $_POST['cashDate'] ?? '';
                    $_POST['DepositAccount'] = $_POST['CashDepositAccount'] ?? '';
                    $_POST['payment_status'] = 'succeeded';
                    $donationpayid = $data['id'];
                    $_POST['id'] =  $donationpayid;
                    $data = $_POST;
                    $DonationModel->update(array_merge($_POST));
                    $this->sendEmailDonations($data);
                    $memberid = $_POST['Member_id'] ?? '';
                   $confirmdata =  $MemberModel->membercheck($memberid); 
                   $_SESSION['memberregisterpuja'] = $confirmdata; 
                   $pujareg =  $itemspujasponsorModel->registersankalpapujacheck($memberid);
                   $_SESSION['pujareg'] = $pujareg;
                   $sponsoreventfirst =  $itemspujasponsorModel->sponsorevent1check($memberid);
                   $_SESSION['sponsoreventfirst'] = $sponsoreventfirst;
                   $sponsoreventsecond =  $itemspujasponsorModel->sponsorevent2check($memberid);
                   $_SESSION['sponsoreventsecond'] = $sponsoreventsecond;
                    $CategoryAarr = $sponsoritemModel->sponsorCategoryA();
                   $_SESSION['CategoryAarr'] = $CategoryAarr;

                  $CategoryBarr = $sponsoritemModel->sponsorCategoryB();
                  $_SESSION['CategoryBarr'] = $CategoryBarr;
                  
                  $pujasankalpaattempt1arr = $itemspujasponsorModel->pujasankalpaattempt1($memberid);
                  $_SESSION['pujasankalpaattempt1arr'] = $pujasankalpaattempt1arr;

                  $pujasankalpaattempt2arr = $itemspujasponsorModel->pujasankalpaattempt2($memberid);
                  $_SESSION['pujasankalpaattempt2arr'] = $pujasankalpaattempt2arr;
                   $previousytd = $_POST['YTD'] ?? '';
                   $amountytd =$_POST['Amount'] ?? '';
                   
                   $newytd = $previousytd + $amountytd; 
                   $_SESSION['ytdvalue'] = $newytd; 
                   $_SESSION['donationid'] = $donationpayid;
                   $categorymember =  $_POST['membercategory'] ?? '';
                   $_SESSION['membercategory'] =  $categorymember;
                   if($datamember == null) {
                       $value = array();
                       // $value['id'] = $_POST['id'] ?? '';
                       $value['type'] = $_POST['type'] ?? '';
                       $value['gift'] = $_POST['gift'] ?? '';
                       $value['Payment_For'] = $_POST['Payment_For'] ?? '';
                       $value['MemberName'] = $_POST['MemberName'] ?? '';
                       $value['Amount'] = $_POST['Amount'] ?? '';
                       $value['PaymentOption'] = $_POST['PaymentOption'] ?? '';
                       $value['payment_status'] = 'confirmed';
                       $value['transaction_id'] = $_POST['transaction_id'] ?? '';
                       $value['update_on'] = $_POST['update_on'] ?? '';
                       $value['Member_id'] = $_POST['Member_id'] ?? '';
                       $value['pay_date'] = $_POST['pay_date'] ?? '';
                       $value['cc_name'] = $_POST['cc_name'] ?? '';
                       $value['remarks'] = $_POST['remarks'] ?? '';
                       $value['oid'] = $_POST['oid'] ?? '';
                       $value['pay_type'] = $_POST['pay_type'] ?? '';
                       $value['pay_for'] = $_POST['pay_for'] ?? '';
                       $value['Address'] = $_POST['Address'] ?? '';
                       $value['Street'] = $_POST['Street'] ?? '';
                       $value['State'] = $_POST['State'] ?? '';
                       $value['Zip_Code'] = $_POST['Zip_Code'] ?? '';
                       $value['Tele1'] = $_POST['phone'] ?? '';
                       $value['Tele2'] = $_POST['alternatenumber'] ?? '';
                       $value['email'] = $_POST['email'] ?? '';
                       $value['City'] = $_POST['City'] ?? '';
                       $value['eventdonation'] = $_POST['eventdonation'] ?? '';
                       $value['spousename'] = $_POST['spousename'] ?? '';
                       $value['purpose'] = $_POST['purpose'] ?? '';
                       $value['Address3'] = $_POST['Address3'] ?? '';
                       $MemberModel->SaveDataInmember($value);
                   }
                  $datefor =$_POST['pay_date'] ?? '';
                           $timestamp = !empty($datefor) ? strtotime($datefor) : false;
                           $payfinaldate = $timestamp ? date("m/d/Y", $timestamp) : '';
                    $mobileno= $data['alternatenumber'];
                   if ($data['alternatenumber'] != null) {
                       $msg = 'Houston Durga Bari: Donation confirmation are Member Id: '. $data['Member_id'].', Member Name: '. $data['MemberName'].' , Amount: $'. $data['Amount'].', Pay Date: '. $payfinaldate.',  Order Id: '. $data['oid'].', Status: ' . $data['payment_status']  ;
                       $this->SendSMS($mobileno, $msg);
                       }
                       $this->tpl['arr'] = $DonationModel->get($donationpayid);
                    //exit();

                }
                // directdeposite
                elseif (($_POST['PaymentOption'] ?? '') == 'directdeposit') {
                    $_POST['bank'] = $_POST['directbank'] ?? '';
                    $_POST['transaction_id'] = $_POST['transactioncode'] ?? '';
                    $_POST['amount'] = $_POST['directdepositeamount'] ?? '';
                    $_POST['pay_date'] = $_POST['transactiondate'] ?? '';
                    $_POST['DepositAccount'] = $_POST['DirectPayDepositAccount'] ?? '';
                    $_POST['payment_status'] = 'succeeded';
                    $donationpayid = $data['id'];
                    $_POST['id'] =  $donationpayid;
                    $data = $_POST;
                    $DonationModel->update(array_merge($_POST));
                    $this->sendEmailDonations($data);
                    $memberid = $_POST['Member_id'] ?? '';
                   $confirmdata =  $MemberModel->membercheck($memberid); 
                   $_SESSION['memberregisterpuja'] = $confirmdata; 
                   $pujareg =  $itemspujasponsorModel->registersankalpapujacheck($memberid);
                   $_SESSION['pujareg'] = $pujareg;
                   $sponsoreventfirst =  $itemspujasponsorModel->sponsorevent1check($memberid);
                   $_SESSION['sponsoreventfirst'] = $sponsoreventfirst;
                   $sponsoreventsecond =  $itemspujasponsorModel->sponsorevent2check($memberid);
                   $_SESSION['sponsoreventsecond'] = $sponsoreventsecond;
                    $CategoryAarr = $sponsoritemModel->sponsorCategoryA();
                   $_SESSION['CategoryAarr'] = $CategoryAarr;

                  $CategoryBarr = $sponsoritemModel->sponsorCategoryB();
                  $_SESSION['CategoryBarr'] = $CategoryBarr;
                  
                  $pujasankalpaattempt1arr = $itemspujasponsorModel->pujasankalpaattempt1($memberid);
                  $_SESSION['pujasankalpaattempt1arr'] = $pujasankalpaattempt1arr;

                  $pujasankalpaattempt2arr = $itemspujasponsorModel->pujasankalpaattempt2($memberid);
                  $_SESSION['pujasankalpaattempt2arr'] = $pujasankalpaattempt2arr;
                   $previousytd = $_POST['YTD'] ?? '';
                   $amountytd =$_POST['Amount'] ?? '';
                   
                   $newytd = $previousytd + $amountytd; 
                   $_SESSION['ytdvalue'] = $newytd; 
                   $_SESSION['donationid'] = $donationpayid;
                   $categorymember =  $_POST['membercategory'] ?? '';
                   $_SESSION['membercategory'] =  $categorymember;
                   if($datamember == null) {
                       $value = array();
                       // $value['id'] = $_POST['id'] ?? '';
                       $value['type'] = $_POST['type'] ?? '';
                       $value['gift'] = $_POST['gift'] ?? '';
                       $value['Payment_For'] = $_POST['Payment_For'] ?? '';
                       $value['MemberName'] = $_POST['MemberName'] ?? '';
                       $value['Amount'] = $_POST['Amount'] ?? '';
                       $value['PaymentOption'] = $_POST['PaymentOption'] ?? '';
                       $value['payment_status'] = 'confirmed';
                       $value['transaction_id'] = $_POST['transaction_id'] ?? '';
                       $value['update_on'] = $_POST['update_on'] ?? '';
                       $value['Member_id'] = $_POST['Member_id'] ?? '';
                       $value['pay_date'] = $_POST['pay_date'] ?? '';
                       $value['cc_name'] = $_POST['cc_name'] ?? '';
                       $value['remarks'] = $_POST['remarks'] ?? '';
                       $value['oid'] = $_POST['oid'] ?? '';
                       $value['pay_type'] = $_POST['pay_type'] ?? '';
                       $value['pay_for'] = $_POST['pay_for'] ?? '';
                       $value['Address'] = $_POST['Address'] ?? '';
                       $value['Street'] = $_POST['Street'] ?? '';
                       $value['State'] = $_POST['State'] ?? '';
                       $value['Zip_Code'] = $_POST['Zip_Code'] ?? '';
                       $value['Tele1'] = $_POST['phone'] ?? '';
                       $value['Tele2'] = $_POST['alternatenumber'] ?? '';
                       $value['email'] = $_POST['email'] ?? '';
                       $value['City'] = $_POST['City'] ?? '';
                       $value['eventdonation'] = $_POST['eventdonation'] ?? '';
                       $value['spousename'] = $_POST['spousename'] ?? '';
                       $value['purpose'] = $_POST['purpose'] ?? '';
                       $value['Address3'] = $_POST['Address3'] ?? '';
                       $MemberModel->SaveDataInmember($value);
                   }
                  $datefor =$_POST['pay_date'] ?? '';
                           $timestamp = !empty($datefor) ? strtotime($datefor) : false;
                           $payfinaldate = $timestamp ? date("m/d/Y", $timestamp) : '';
                    $mobileno= $data['alternatenumber'];
                   if ($data['alternatenumber'] != null) {
                       $msg = 'Houston Durga Bari: Donation confirmation are Member Id: '. $data['Member_id'].', Member Name: '. $data['MemberName'].' , Amount: $'. $data['Amount'].', Pay Date: '. $payfinaldate.',  Order Id: '. $data['oid'].', Status: ' . $data['payment_status']  ;
                       $this->SendSMS($mobileno, $msg);
                       }
                       $this->tpl['arr'] = $DonationModel->get($donationpayid);
                    //exit();

                }
                // sumup
                elseif (($_POST['PaymentOption'] ?? '') == 'sumup') {
                    $_POST['amount'] = $_POST['sumupamount'] ?? '';
                    $_POST['transaction_id'] = $_POST['sumupid'] ?? '';
                    $_POST['pay_date'] = $_POST['sumupdate'] ?? '';
                    $_POST['DepositAccount'] = $_POST['SumUpDepositAccount'] ?? '';
                    $_POST['payment_status'] = 'succeeded';
                    $donationpayid = $data['id'];
                    $_POST['id'] =  $donationpayid;
                    $data = $_POST;
                    $DonationModel->update(array_merge($_POST));
                    $this->sendEmailDonations($data);
                    $memberid = $_POST['Member_id'] ?? '';
                   $confirmdata =  $MemberModel->membercheck($memberid); 
                   $_SESSION['memberregisterpuja'] = $confirmdata; 
                   $pujareg =  $itemspujasponsorModel->registersankalpapujacheck($memberid);
                   $_SESSION['pujareg'] = $pujareg;
                   $sponsoreventfirst =  $itemspujasponsorModel->sponsorevent1check($memberid);
                   $_SESSION['sponsoreventfirst'] = $sponsoreventfirst;
                   $sponsoreventsecond =  $itemspujasponsorModel->sponsorevent2check($memberid);
                   $_SESSION['sponsoreventsecond'] = $sponsoreventsecond;
                    $CategoryAarr = $sponsoritemModel->sponsorCategoryA();
                   $_SESSION['CategoryAarr'] = $CategoryAarr;

                  $CategoryBarr = $sponsoritemModel->sponsorCategoryB();
                  $_SESSION['CategoryBarr'] = $CategoryBarr;
                  
                  $pujasankalpaattempt1arr = $itemspujasponsorModel->pujasankalpaattempt1($memberid);
                  $_SESSION['pujasankalpaattempt1arr'] = $pujasankalpaattempt1arr;

                  $pujasankalpaattempt2arr = $itemspujasponsorModel->pujasankalpaattempt2($memberid);
                  $_SESSION['pujasankalpaattempt2arr'] = $pujasankalpaattempt2arr;
                  
                   $previousytd = $_POST['YTD'] ?? '';
                   $amountytd =$_POST['Amount'] ?? '';
                   
                   $newytd = $previousytd + $amountytd; 
                   $_SESSION['ytdvalue'] = $newytd; 
                   $_SESSION['donationid'] = $donationpayid;
                   $categorymember =  $_POST['membercategory'] ?? '';
                   $_SESSION['membercategory'] =  $categorymember;
                   if($datamember == null) {
                       $value = array();
                       // $value['id'] = $_POST['id'] ?? '';
                       $value['type'] = $_POST['type'] ?? '';
                       $value['gift'] = $_POST['gift'] ?? '';
                       $value['Payment_For'] = $_POST['Payment_For'] ?? '';
                       $value['MemberName'] = $_POST['MemberName'] ?? '';
                       $value['Amount'] = $_POST['Amount'] ?? '';
                       $value['PaymentOption'] = $_POST['PaymentOption'] ?? '';
                       $value['payment_status'] = 'confirmed';
                       $value['transaction_id'] = $_POST['transaction_id'] ?? '';
                       $value['update_on'] = $_POST['update_on'] ?? '';
                       $value['Member_id'] = $_POST['Member_id'] ?? '';
                       $value['pay_date'] = $_POST['pay_date'] ?? '';
                       $value['cc_name'] = $_POST['cc_name'] ?? '';
                       $value['remarks'] = $_POST['remarks'] ?? '';
                       $value['oid'] = $_POST['oid'] ?? '';
                       $value['pay_type'] = $_POST['pay_type'] ?? '';
                       $value['pay_for'] = $_POST['pay_for'] ?? '';
                       $value['Address'] = $_POST['Address'] ?? '';
                       $value['Street'] = $_POST['Street'] ?? '';
                       $value['State'] = $_POST['State'] ?? '';
                       $value['Zip_Code'] = $_POST['Zip_Code'] ?? '';
                       $value['Tele1'] = $_POST['phone'] ?? '';
                       $value['Tele2'] = $_POST['alternatenumber'] ?? '';
                       $value['email'] = $_POST['email'] ?? '';
                       $value['City'] = $_POST['City'] ?? '';
                       $value['eventdonation'] = $_POST['eventdonation'] ?? '';
                       $value['spousename'] = $_POST['spousename'] ?? '';
                       $value['purpose'] = $_POST['purpose'] ?? '';
                       $value['Address3'] = $_POST['Address3'] ?? '';
                       $MemberModel->SaveDataInmember($value);
                   }
                  $datefor =$_POST['pay_date'] ?? '';
                           $timestamp = !empty($datefor) ? strtotime($datefor) : false;
                           $payfinaldate = $timestamp ? date("m/d/Y", $timestamp) : '';
                    $mobileno= $data['alternatenumber'];
                   if ($data['alternatenumber'] != null) {
                       $msg = 'Houston Durga Bari: Donation confirmation are Member Id: '. $data['Member_id'].', Member Name: '. $data['MemberName'].' , Amount: $'. $data['Amount'].', Pay Date: '. $payfinaldate.',  Order Id: '. $data['oid'].', Status: ' . $data['payment_status']  ;
                       $this->SendSMS($mobileno, $msg);
                       }
                       $this->tpl['arr'] = $DonationModel->get($donationpayid);
                    //exit();

                }
                elseif (($_POST['PaymentOption'] ?? '') == 'stripe') {

                    $amount = $_POST['Amount'] ?? '';
                    
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

                        $payment = Stripe_Charge::create(array(
                                    "amount" => $amount,
                                    "currency" => $this->tpl["option_arr_values"]["currency"],
                                    "card" => $_POST['stripeToken'] ?? '',
                                   "description" =>  "Pay For:". ($_POST['pay_type'] ?? ''). ', ' ."Email:". ($_POST['email'] ?? '') . ', ' ."Full Name:". ($_POST['MemberName'] ?? ''),
                                    "metadata" => ["orderid" => $oid]
                        ));

                        $this->tpl['payment']['balance_transaction'] = $payment->balance_transaction;
                        $this->tpl['payment']['amount'] = $payment->amount;
                        $this->tpl['payment']['status'] = $payment->status;
                        $this->tpl['payment']['currency'] = $payment->currency;

                        if ($payment->status == 'succeeded') {

                            $opts = array();
                            //$donationpayid = $_POST['id'] ?? '';
                            //$_POST['id'] =  $donationid;
                            $id = $data['id'];
                            $opts['id'] = $data['id'];
                            $opts['stripe_return'] = $payment->status;
                            $opts['transaction_id'] = $payment->id;
                            $opts['paid_amount'] = $payment->amount;
                            $opts['stripe_product'] = $payment->description;
                            //$opts['payment_status'] = 'confirmed';
                            $opts['payment_status'] = 'succeeded';
                            $opts['payment_timestamp'] = time();
                            $data = $_POST;
                            $DonationModel->update(array_merge($opts, $_POST));
                            $this->sendEmailDonations($data);
                            $memberid = $_POST['Member_id'] ?? '';
                            $confirmdata =  $MemberModel->membercheck($memberid); 
                            $_SESSION['memberregisterpuja'] = $confirmdata; 
                            $pujareg =  $itemspujasponsorModel->registersankalpapujacheck($memberid);
                            $_SESSION['pujareg'] = $pujareg;
                            $sponsoreventfirst =  $itemspujasponsorModel->sponsorevent1check($memberid);
                            $_SESSION['sponsoreventfirst'] = $sponsoreventfirst;
                            $sponsoreventsecond =  $itemspujasponsorModel->sponsorevent2check($memberid);
                            $_SESSION['sponsoreventsecond'] = $sponsoreventsecond;
                             $CategoryAarr = $sponsoritemModel->sponsorCategoryA();
                             $_SESSION['CategoryAarr'] = $CategoryAarr;

                             $CategoryBarr = $sponsoritemModel->sponsorCategoryB();
                             $_SESSION['CategoryBarr'] = $CategoryBarr;
                             
                             $pujasankalpaattempt1arr = $itemspujasponsorModel->pujasankalpaattempt1($memberid);
                             $_SESSION['pujasankalpaattempt1arr'] = $pujasankalpaattempt1arr;

                              $pujasankalpaattempt2arr = $itemspujasponsorModel->pujasankalpaattempt2($memberid);
                              $_SESSION['pujasankalpaattempt2arr'] = $pujasankalpaattempt2arr;
                  
                            $previousytd = $_POST['YTD'] ?? '';
                            $amountytd =$_POST['Amount'] ?? '';
                            
                            $newytd = $previousytd + $amountytd; 
                            $_SESSION['ytdvalue'] = $newytd; 
                            $_SESSION['donationid'] = $id;
                            $categorymember =  $_POST['membercategory'] ?? '';
                            $_SESSION['membercategory'] =  $categorymember;
                            if($datamember == null) {
                                $value = array();
                                // $value['id'] = $_POST['id'] ?? '';
                                $value['type'] = $_POST['type'] ?? '';
                                $value['gift'] = $_POST['gift'] ?? '';
                                $value['Payment_For'] = $_POST['Payment_For'] ?? '';
                                $value['MemberName'] = $_POST['MemberName'] ?? '';
                                $value['Amount'] = $_POST['Amount'] ?? '';
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
                                $value['Address'] = $_POST['Address'] ?? '';
                                $value['Street'] = $_POST['Street'] ?? '';
                                $value['State'] = $_POST['State'] ?? '';
                                $value['Zip_Code'] = $_POST['Zip_Code'] ?? '';
                                $value['Tele1'] = $_POST['phone'] ?? '';
                                $value['Tele2'] = $_POST['alternatenumber'] ?? '';
                                $value['email'] = $_POST['email'] ?? '';
                                $value['City'] = $_POST['City'] ?? '';
                                $value['eventdonation'] = $_POST['eventdonation'] ?? '';
                                $value['spousename'] = $_POST['spousename'] ?? '';
                                $value['purpose'] = $_POST['purpose'] ?? '';
                                $value['Address3'] = $_POST['Address3'] ?? '';
                                $MemberModel->SaveDataInmember($value);
                            }
                           $datefor =$_POST['pay_date'] ?? '';
                                    $timestamp = !empty($datefor) ? strtotime($datefor) : false;
                                    $payfinaldate = $timestamp ? date("m/d/Y", $timestamp) : '';
                             $mobileno= $data['alternatenumber'];
                            if ($data['alternatenumber'] != null) {
                                $msg = 'Houston Durga Bari: Donation confirmation are Member Id: '. $data['Member_id'].', Member Name: '. $data['MemberName'].' , Amount: $'. $data['Amount'].', Pay Date: '. $payfinaldate.',  Order Id: '. $data['oid'].', Status: ' . $opts['payment_status']  ;
                               $this->SendSMS($mobileno, $msg);
                                }

                            $this->tpl['arr'] = $DonationModel->get($id);
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
                    
                    $this->tpl['arr'] = $DonationModel->get($id);
                    $this->tpl['arr']['amount'] = $total;
                }else{
                     $_SESSION['status'] = 16;
                   
                }
            } else {
                $_SESSION['status'] = 17;
            }
        }
        
    }

}

?>
