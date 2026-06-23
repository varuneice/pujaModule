<?php

require_once CONTROLLERS_PATH . 'App.php';

class PujaMagazineadmin extends App {

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
        $this->js[] = array('file' => 'GzPujaMagazine.js?v=' . time(), 'path' => JS_PATH);
    }

  function index()
    {
        GzObject::loadFiles('Model', array('pujamagazine', 'pujamagazineprice'));
        $pujamagazineModel = new pujamagazineModel();
        $pujamagazinepriceModel = new pujamagazinepriceModel();
        
        $opts = array();
        $arr = $pujamagazineModel->getAlldata($opts);
        $this->tpl['arr'] = $arr;
        $pujaregarr = $pujamagazinepriceModel->getAllmagazineprice($opts);
        $this->tpl['pujaregarr'] = $pujaregarr;
    }

       // function for update status registration from admin end
    function edit()
    {
        GzObject::loadFiles('Model', array('pujamagazine'));
        $pujamagazineModel = new pujamagazineModel();
        
        if (!empty($_POST['edit_pujamagazinedata'])) {

            $data = array();

            $id = $_POST['id'] ?? '';
            
            $status = $_POST['status'] ?? '';
            $membertype = $_POST['member_status'] ?? '';
            if ($status == 'Active') {
                $url = INSTALL_URL . "PujaMagazineadmin/payment/$id";
                //$url = "http://localhost:8082/HDBS_Payment/Parking&Badges/PujaMagazineadmin/payment/$id";
                $subjetc = 'HDBS Puja Magazine Payment';
                $fullname = $_POST['membername'] ?? '';
                //$registrationfor = $_POST['registration_for'] ?? '';
                $magazine = $_POST['magazine'] ?? '';
                $parkingfield = 'Paid Magazine';
                 $modeofcollection = $_POST['mode_of_collection'] ?? '';
                    //  if($modeofcollection1 == "15"){
                    //      $modeofcollection = "Collect at Durga Bari";
                    //  }else{
                    //      $modeofcollection = "Postal Delivery";
                    //  }
                //$memberid = $_POST['Member_id'] ?? '';
                $totalamount = $_POST['totalamount'] ?? '';
                //$Emailcc = 'pujaregpayment@durgabari.org';
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
                <td style="text-align: center; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;"><strong>HDBS Puja Magazine Payment</strong></td>
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
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Mode of Collection&nbsp;&nbsp;</td>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $modeofcollection . '</td>
                </tr>
                <tr>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">No. of Magazine(s)&nbsp;&nbsp;</td>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $magazine . '</td>
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
                <td colspan =2 style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: center;">Please make your payment to complete your Puja Paid Magazine &nbsp;&nbsp;</td>
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
                    $msg = 'Houston Durga Bari: ' .$fullname. ' your Paid Magazine Request for '.$parkingfield. '  Houston Durga Bari has been approved. Please check your email and complete final payment. ';
                    $this->SendSMS($mobileno, $msg);
                }

            }
            if ($status == 'cancelled') {
                $cancelremarks = $_POST['remarks'] ?? '';
                $membername = $_POST['membername'] ?? '';
                $name = 'Dear'. ', '.$membername;
                //$Emailcc = 'pujaassocpayment@durgabari.org';
                $Emailcc = 'pujaassocpayment@durgabari.org';
                $subjetc = 'HDBS Magazine Payment';
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
                    $msg = 'Houston Durga Bari: ' .$fullname. ' your Paid Magazine Request for '.$parkingfield. '  Houston Durga Bari has been Cancelled the request. ';
                   $this->SendSMS($mobileno, $msg);
                }
       
                
            }
            
            $pujamagazineModel->update($_POST);

            if (!empty($id)) {
                $_SESSION['status'] = 20;
            } else {
                $_SESSION['status'] = 21;
            }

            if (!$this->isAdmin()) {
                Util::redirect(INSTALL_URL . "Admin/dashboard");
            } else {
                Util::redirect(INSTALL_URL . "PujaMagazineadmin/index");
            }
        }
        $id = $_GET['id'] ?? '';
        //alert($id);
        $pujadataarr = $pujamagazineModel->get($id);
        $this->tpl['pujadataarr'] = $pujadataarr;


    }

    // end
    

// function for make final payment from user end registration

function payment(){
    GzObject::loadFiles('Model', array('pujamagazine' ,'ConfirmCode', 'Member', 'Donation', 'idnumbers'));
    $pujamagazineModel = new pujamagazineModel();
    $ConfirmCodeModel = new ConfirmCodeModel();
    $MemberModel = new MemberModel();
    $DonationModel = new DonationModel();
    $idnumbersModel = new idnumbersModel();

    if (!empty($_POST['magzine_payment'])) {
        $data = array();
       date_default_timezone_set("America/Chicago");
        $today = date("Y/m/d");
        $_POST['pay_date'] = $today;
        $_POST['paytype'] ='Magazine';
        $_POST['pay_for'] = 'Puja Magazine' . '/' . ($_POST['registration_for'] ?? '');

        // for generate oid 
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
                $pujamagazineModel->update(array_merge($opts, $_POST));
                
                $value = array();
                $value['oid'] = $datamemberarr['oid'];
                $value['eventid'] = $datamemberarr['eventid'];
                $value['type'] = $datamemberarr['type'];
                $value['Member_id'] = $datamemberarr['Member_id'];
                $value['MemberName'] = $datamemberarr['membername'];
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
                $value['pay_type'] = 'TEMPLE';
                $value['pay_for'] = $datamemberarr['pay_for'];
                $value['Tele1'] = $datamemberarr['phone'];
                $value['email'] = $datamemberarr['email'];
                $value['spousename'] = $datamemberarr['spousename'];
                $value['Address'] = $datamemberarr['Address'];
                $value['Street'] = $datamemberarr['street'];
                $value['City'] = $datamemberarr['city'];
                $value['State'] = $datamemberarr['state'];
                $value['Zip_Code'] = $datamemberarr['zip'];
                $DonationModel->SaveDataInDonation($value);
                
                        $fullname = $_POST['membername'] ?? '';
                        $memberstatus =  $_POST['member_status'] ?? '';
                        $memberid = $_POST['Member_id'] ?? '';
                        $amount = $_POST['totalamount'] ?? '';
                        $oid = $_POST['oid'] ?? '';
                        $paymentmethod = 'Zelle';
                        $datefor = $_POST['pay_date'] ?? '';
                        $timestamp = !empty($datefor) ? strtotime($datefor) : false;
                        $payfinaldate = $timestamp ? date("m/d/Y", $timestamp) : '';
                        $subjetc = 'HDBS Paid Magazine Payment Confirmation';
                        //$Emailcc = 'pujaassocpayment@durgabari.org';
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
                        <td style="text-align: center; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;"><strong>Paid Magazine Payment Confirmation</strong></td>
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
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">' . $fullname . '</td>
                        </tr>
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Amount&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;"><span style="color:red;">$</span>' . $amount . '</td>
                        </tr>
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Payment Method&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $paymentmethod . '</td>
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
                       $email = $_POST['email'] ?? '';
                        if ($email != null) {
                          $this->sendEmailticket($message, $subjetc, $email, $Emailcc);
                        }
                        
                        $mobileno = $data['tele1'];
                        if ($mobileno != null) {
                            $msg = 'Houston Durga Bari: Paid Magazine Confirmation are Member Id: ' . $memberid . ', Order Id: ' . $oid . ', Member Name: ' . $fullname . ',  Amount: $' . $amount . ' , Payment Method: ' . $paymentmethod.' , Pay Date: ' . $payfinaldate;
                            $this->SendSMS($mobileno, $msg);
                        }
                        $id = $_POST['id'] ?? '';
                        $this->tpl['magazinearr'] = $pujamagazineModel->get($id);
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
                    $_POST['status'] = 'confirmed';
                    $data = $_POST;
                    $datamemberarr = array();
                    $datamemberarr = array_merge($opts, $_POST);
                    $pujamagazineModel->update(array_merge($opts, $_POST));
                    
                    $value = array();
                    $value['oid'] = $datamemberarr['oid'];
                    $value['eventid'] = $datamemberarr['eventid'];
                    $value['type'] = $datamemberarr['type'];
                    $value['Member_id'] = $datamemberarr['Member_id'];
                    $value['MemberName'] = $datamemberarr['membername'];
                    $value['PaymentOption'] = $datamemberarr['PaymentOption'];
                    $value['payment_status'] = 'succeeded';
                    $value['payment_timestamp'] = $datamemberarr['payment_timestamp'] ?? '';
                    $value['Amount'] = $datamemberarr['totalamount'];
                    $value['stripe_return'] = $datamemberarr['stripe_return'] ?? '';
                    $value['transaction_id'] = $datamemberarr['transaction_id'];
                    $value['paid_amount'] = $datamemberarr['paid_amount'] ?? '';
                    $value['update_on'] = $datamemberarr['UpdateOn'];
                    $value['stripe_product'] = $datamemberarr['stripe_product'] ?? '';
                    $value['pay_date'] = $datamemberarr['pay_date'];
                    $value['pay_type'] = 'TEMPLE';
                    $value['pay_for'] = $datamemberarr['pay_for'];
                    $value['Tele1'] = $datamemberarr['phone'];
                    $value['email'] = $datamemberarr['email'];
                    $value['spousename'] = $datamemberarr['spousename'];
                    $value['Address'] = $datamemberarr['Address'];
                    $value['Street'] = $datamemberarr['street'];
                    $value['City'] = $datamemberarr['city'];
                    $value['State'] = $datamemberarr['state'];
                    $value['Zip_Code'] = $datamemberarr['zip'];
                    $DonationModel->SaveDataInDonation($value);
                  
                        $fullname = $_POST['membername'] ?? '';
                        $memberstatus =  $_POST['member_status'] ?? '';
                        $memberid = $_POST['Member_id'] ?? '';
                        $amount = $_POST['totalamount'] ?? '';
                        $oid = $_POST['oid'] ?? '';
                        $paymentmethod = 'Credit Card';
                        $datefor = $_POST['pay_date'] ?? '';
                        $timestamp = !empty($datefor) ? strtotime($datefor) : false;
                        $payfinaldate = $timestamp ? date("m/d/Y", $timestamp) : '';
                        $subjetc = 'HDBS Paid Magazine Payment Confirmation';
                        //$Emailcc = 'pujaassocpayment@durgabari.org';
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
                        <td style="text-align: center; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;"><strong>Paid Magazine Payment Confirmation</strong></td>
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
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">' . $fullname . '</td>
                        </tr>
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Amount&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;"><span style="color:red;">$</span>' . $amount . '</td>
                        </tr>
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Payment Method&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $paymentmethod . '</td>
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
                       $email = $_POST['email'] ?? '';
                        if ($email != null) {
                          $this->sendEmailticket($message, $subjetc, $email, $Emailcc);
                        }
                        
                        $mobileno = $_POST['tele1'] ?? '';
                        if ($mobileno != null) {
                            $msg = 'Houston Durga Bari: Paid Magazine Confirmation are Member Id: ' . $memberid . ', Order Id: ' . $oid . ', Member Name: ' . $fullname . ',  Amount: $' . $amount . ' , Payment Method: ' . $paymentmethod.' , Pay Date: ' . $payfinaldate;
                            $this->SendSMS($mobileno, $msg);
                        }
                        $id = $_POST['id'] ?? '';
                    $this->tpl['magazinearr'] = $pujamagazineModel->get($id);
                    
                } else {

                    $opts = array();
                    $opts['id'] = $id;
                    $opts['stripe_return'] = $payment->status;
                    $opts['transaction_id'] = $payment->id;
                    $opts['paid_amount'] = $payment->amount;
                    $opts['stripe_product'] = $payment->description;

                    $pujamagazineModel->update($opts);

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
        $magazinearr = $pujamagazineModel->get($id);
        $this->tpl['magazinearr'] = $magazinearr;
    }

}




// function for create  All puja price from admin end. 
    function pujamagazinepricecreate(){
        GzObject::loadFiles('Model', array('pujamagazineprice'));
        $pujamagazinepriceModel = new pujamagazinepriceModel();

        if (!empty($_POST['pujamagazineprice'])) {

            // $id = $pujaregistrationpriceModel->getMaxid() + 1;
            // $data['id'] = $id;

            $id = $pujamagazinepriceModel->save(array_merge($_POST));
            echo "<script>alert('$id')</script>";
            if (!empty($id)) {
                $_SESSION['status'] = 16;
            } else {
                $_SESSION['status'] = 17;
            }
            Util::redirect(INSTALL_URL . "PujaMagazineadmin/index");
        }

    }



 // function for update All Magazine price from admin end. 
    function pujamagazinepriceedit(){
        GzObject::loadFiles('Model', array('pujamagazineprice'));
        $pujamagazinepriceModel = new pujamagazinepriceModel();

        if (!empty($_POST['pujamagazinepriceedit'])) {

            $data = array();
            $id = $pujamagazinepriceModel->update(array_merge($_POST));

            if (!empty($id)) {
                $_SESSION['status'] = 20;
            } else {
                $_SESSION['status'] = 21;
            }

            if (!$this->isAdmin()) {
                Util::redirect(INSTALL_URL . "Admin/dashboard");
            } else {
                Util::redirect(INSTALL_URL . "PujaMagazineadmin/index");
            }
        }
        $id = $_GET['id'] ?? '';
        $allpujapricearr = $pujamagazinepriceModel->get($id);
        $this->tpl['allpujapricearr'] = $allpujapricearr;

    }


 
   
     function export() {
        $this->setIsAjax(true);
        $this->isAjax = true;

        GzObject::loadFiles('Model', array('pujamagazine'));
        $pujamagazineModel = new pujamagazineModel();
       

        $output = "";

        $query = $pujamagazineModel->from($pujamagazineModel->getTable());

        $magazine = $query->fetchAll();

        foreach ($magazine[0] as $k => $v) {
            $output .= '"' . $k . '",';
        }
        $output .= "\n";

        foreach ($magazine as $key => $value) {

            $opts = array();
            $opts['member_id'] = $value['id'];
            $slots = $pujamagazineModel->getAll($opts);

            foreach ($value as $k => $v) {
                if ($k == 'date') {
                    $output .= '"' . date("Y-m-d H:i", $v) . '",';
                } else {
                    $output .= '"' . $v . '",';
                }
            }
            $output .= "\n";
        }

        $filename = "Puja_Magazine" . time() . ".csv";

        header('Content-type: application/csv');
        header('Content-Disposition: attachment; filename=' . $filename);

        echo $output;
        exit;
    }

  


    function delete()
    {
        $this->isAjax = true;
        $id = ($_REQUEST['id'] ?? '');
        $cat = ($_REQUEST['cat'] ?? '');

        GzObject::loadFiles('Model', array('pujamagazine', 'pujamagazineprice'));
        $pujamagazineModel = new pujamagazineModel();
        $pujamagazinepriceModel = new pujamagazinepriceModel();

        if($cat == 1){
            $pujamagazineModel->deleteFrom($pujamagazineModel->getTable())
             ->where('id', $id)->execute();
        }elseif($cat == 4){
            $pujamagazinepriceModel->deleteFrom($pujamagazinepriceModel->getTable())
             ->where('id', $id)->execute();
        }
        $opts = array();
        Util::redirect(INSTALL_URL . "PujaMagazineadmin/index");

    } 


}



?>
