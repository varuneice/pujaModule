<?php

require_once CONTROLLERS_PATH . 'App.php';
class Ticketadmin extends App
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
        // $this->js[] = array('file' => 'GzTicket.js', 'path' => JS_PATH);
        $this->js[] = array(
    'file' => 'GzTicket.js?v=' . time(),
    'path' => JS_PATH
);

    }
    
        function index()
    {
        GzObject::loadFiles('Model', array('ticketeventname',  'ticket', 'PujaTicketPrice'));
        $ticketeventnameModel = new ticketeventnameModel();
        $ticketModel = new ticketModel();
        $PujaTicketPriceModel = new PujaTicketPriceModel();

        $opts = array();
        $ticketarr = $ticketModel->ticketAlldata($opts);
        $this->tpl['ticketarr'] = $ticketarr;

   
        $Eventticketarr = $ticketeventnameModel->ticketEventAlldata($opts);
        $this->tpl['Eventticketarr'] = $Eventticketarr;
        

        $pujaticketpricearr = $PujaTicketPriceModel->getAll($opts);
        $this->tpl['pujaticketpricearr'] = $pujaticketpricearr;

    }

    // function for update status ticket from admin end
    function edit()
    {
        GzObject::loadFiles('Model', array('ticket'));
        $ticketModel = new ticketModel();

        if (!empty($_POST['edit_ticketdata'])) {

            $data = array();

            $id = $_POST['id'] ?? '';
            $status = $_POST['status'] ?? '';
            if ($status == 'Active') {
                $url = INSTALL_URL . "Ticketadmin/payment/$id";
                $membername = $_POST['name'] ?? '';
                $name = $_POST['type'] ?? '';
                if ($name == 'kalipuja') {
                    $eventname = 'Kali Puja';
                } else {
                    $eventname = 'Saraswati Puja';
                }
                $tickettype = $_POST['tickettype'] ?? '';
                $tickettype = $_POST['tickettype'] ?? '';
                if ($tickettype == 'individual') {
                    $typeticket = 'Individual';
                } else {
                    $typeticket = 'Family';
                }
                $ticketprice = $_POST['item_cost'] ?? '';
                $Quantity = $_POST['item_number'] ?? '';
                $totalamount = $_POST['amount'] ?? '';
                
                $subjetc = 'HDBS Ticket Payment';
                $Emailcc = 'pujaregpayment@durgabari.org';
                //$Emailcc = 'prateeksaini@eicetechnology.com';
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
                <td style="text-align: center; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;"><strong>Ticket Details</strong></td>
                </tr>
                </tbody>
                </table>
                </div>
                <div class="email-token-class" style="text-align: center;">
                <table style="height: 190px; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;" width="604">
                <tbody>
                <tr>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Member Name&nbsp;&nbsp;</td>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">' . $membername . '</td>
                </tr>
                <tr>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Puja Type&nbsp;&nbsp;</td>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $eventname . '</td>
                </tr>
                <tr>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Total Amount &nbsp;</td>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;"><span style="color:red;">$</span>' . $totalamount . '</td>
                </tr>
                <tr>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Payment Url&nbsp;&nbsp;</td>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $url . '</td>
                </tr>
                <tr>
                <td colspan =2 style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: center;">Please make your payment to complete your Puja Ticket &nbsp;&nbsp;</td>
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
                
                $mobileno = $_POST['tele2'] ?? '';
                if ($mobileno != null) {
                $msg = 'Houston Durga Bari: ' .$membername. ' your ticket Request for '.$eventname. ' Houston Durga Bari has been approved. Please check your email and complete final payment. ';
                $this->SendSMS($mobileno, $msg);
                }
            }
                if ($status == 'cancelled') {
                $cancelremarks = $_POST['remarks'] ?? '';
                $membername = ($_POST['First_name'] ?? '') . ' ' . ($_POST['Last_name'] ?? '');
                $name = 'Dear'. ', '.$membername;
                $Emailcc = 'pujaassocpayment@durgabari.org';
                //$Emailcc = 'prateeksaini@eicetechnology.com';
                $subjetc = 'HDBS Ticket Payment';
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
                $membername = ($_POST['First_name'] ?? '') . ' ' . ($_POST['Last_name'] ?? '');
                $mobileno= $_POST['alternatenumber'] ?? '';
                if ($mobileno != null) {
                    $msg = 'Houston Durga Bari: ' .$membername. ' your Paid Ticket Request for '.$cancelremarks. '  Houston Durga Bari has been Cancelled the request. ';
                   $this->SendSMS($mobileno, $msg);
                }
            }

            $ticketModel->update($_POST);
            //$id = $TicketModel->update(array_merge($data, $_POST));

            if (!empty($id)) {
                $_SESSION['status'] = 20;
            } else {
                $_SESSION['status'] = 21;
            }

            if (!$this->isAdmin()) {
                Util::redirect(INSTALL_URL . "Admin/dashboard");
            } else {
                Util::redirect(INSTALL_URL . "Ticketadmin/index");
            }
        }
        $id = $_GET['id'] ?? '';
        $arr = $ticketModel->get($id);
        $this->tpl['ticekteditarr'] = $arr;

    }

    // end
    
        // function for  make payment from user
    function payment()
    {
        GzObject::loadFiles('Model', array('ConfirmCode', 'Member', 'Donation', 'ticket', 'idnumbers'));
        $ConfirmCodeModel = new ConfirmCodeModel();
        $MemberModel = new MemberModel();
        $DonationModel = new DonationModel();
        $ticketModel = new ticketModel();
        $idnumbersModel = new idnumbersModel();
        if (!empty($_POST['create_ticketpayment'])) {
            $data = array();
            date_default_timezone_set("America/Chicago");
            $today = date("Y/m/d");
            $_POST['pay_date'] = $today;
            $_POST['pay_for'] = 'TICKET' . '/' . ($_POST['type'] ?? '');

            // for generate oid 
            $maxoid = $idnumbersModel->getMaxoid() + 1;
            $update_oid = $idnumbersModel->Updateoid($maxoid);
            $_POST['oid'] = $maxoid;
            // end generate oid for 

            $datamember = $MemberModel->ticketduplicatemember();
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
                $arr = $ConfirmCodeModel->UpdateCode($cmCode);
                $_POST['txn_id'] = $cmCode;
                $arr = $ConfirmCodeModel->getAll($opts);
                $oid = $_POST['oid'] ?? '';
                if ($oid != null) {
                    $opts = array();
                    $opts['payment_status'] = 'confirmed';
                    $_POST['status'] = 'confirmed';
                    $data = $_POST;
                    $datamemberarr = array();
                    $datamemberarr = array_merge($opts, $_POST);
                    $ticketModel->update(array_merge($opts, $_POST));
                    $this->sendTicketEventconfirmation($data);
                    $value = array();
                    $value['oid'] = $datamemberarr['oid'];
                    $value['eventid'] = $datamemberarr['eventid'];
                    $value['type'] = $datamemberarr['type'];
                    $value['Member_id'] = $datamemberarr['Member_id'];
                    $value['MemberName'] = $datamemberarr['name'];
                    $value['PaymentOption'] = $datamemberarr['PaymentOption'];
                    $value['payment_status'] = 'succeeded';
                    $value['payment_timestamp'] = $datamemberarr['payment_timestamp'] ?? '';
                    $value['Amount'] = $datamemberarr['amount'];
                    $value['stripe_return'] = $datamemberarr['stripe_return'] ?? '';
                    $value['transaction_id'] = $datamemberarr['txn_id'];
                    $value['paid_amount'] = $datamemberarr['paid_amount'] ?? '';
                    $value['update_on'] = $datamemberarr['UpdateOn'];
                    $value['stripe_product'] = $datamemberarr['stripe_product'] ?? '';
                    $value['pay_date'] = $datamemberarr['pay_date'];
                    $value['pay_type'] = 'OTHER';
                    $value['pay_for'] = $datamemberarr['pay_for'];
                    $value['Tele1'] = $datamemberarr['tele'];
                    $value['email'] = $datamemberarr['email'];
                    $value['spousename'] = $datamemberarr['spousename'];
                    $value['Address'] = $datamemberarr['Address'];
                    $value['Street'] = $datamemberarr['street'];
                    $value['City'] = $datamemberarr['city'];
                    $value['State'] = $datamemberarr['state'];
                    $value['Zip_Code'] = $datamemberarr['zip'];
                    $DonationModel->SaveDataInDonation($value);
                    if ($datamember == null) {
                        $value = array();
                        $value['oid'] = $_POST['oid'] ?? '';
                        $value['MemberName'] = $_POST['name'] ?? '';
                        $value['Tele1'] = $_POST['tele'] ?? '';
                        $value['email'] = $_POST['email'] ?? '';
                        $value['City'] = $_POST['city'] ?? '';
                        $value['State'] = $_POST['state'] ?? '';
                        $value['Zip_Code'] = $_POST['zip'] ?? '';
                        $value['Item_Name'] = $_POST['item_name'] ?? '';
                        $value['Item_Number'] = $_POST['item_number'] ?? '';
                        $value['Item_Cost'] = $_POST['item_cost'] ?? '';
                        $value['Amount'] = $_POST['amount'] ?? '';
                        $value['pay_type'] = 'OTHER';
                        $value['pay_for'] = $_POST['pay_for'] ?? '';
                        $value['pay_date'] = $_POST['pay_date'] ?? '';
                        $value['transaction_id'] = $_POST['txn_id'] ?? '';
                        $value['remarks'] = $_POST['remarks'] ?? '';
                        $value['created_on'] = $_POST['created_on'] ?? '';
                        $value['update_on'] = $_POST['update_on'] ?? '';
                        $value['PaymentOption'] = $_POST['PaymentOption'] ?? '';
                        $value['payment_status'] = 'confirmed';
                        $value['cc_name'] = $_POST['cc_name'] ?? '';
                        $value['Member_id'] = $_POST['Member_id'] ?? '';
                        $value['type'] = $_POST['type'] ?? '';
                        $value['street'] = $_POST['street'] ?? '';
                        $value['itemeventday'] = $_POST['itemeventday'] ?? '';
                        $value['spousename'] = $datamemberarr['spousename'];
                        $value['Address2'] = $datamemberarr['Address'];
                        $value['Address1'] = $datamemberarr['street'];
                        $value['Child1'] = $datamemberarr['Child1'];
                        $value['Age1'] = $datamemberarr['Age1'];
                        $value['Child2'] = $datamemberarr['Child2'];
                        $value['Age2'] = $datamemberarr['Age2'];
                        $value['Child3'] = $datamemberarr['Child3'];
                        $value['Age3'] = $datamemberarr['Age3'];
                        $value['Parent1'] = $datamemberarr['Parent1'];
                        $value['Parent2'] = $datamemberarr['Parent2'];
                        $MemberModel->SaveDataInmember($value);
                    }
                     $datefor = $data['pay_date'];
                        $timestamp = !empty($datefor) ? strtotime($datefor) : false;
                        $payfinaldate = $timestamp ? date("m/d/Y", $timestamp) : '';
                        $payui = 'Zelle';
                        $mobileno = $data['tele2'];
                        if ($data['tele2'] != null) {
                            $msg = 'Houston Durga Bari: Ticket Confirmation are Member Id: ' . $data['Member_id'] . ', Order Id: ' . $data['oid'] . ', Member Name: ' . $data['name'] . ', Puja Type: ' . $data['type'] . ' , Total Amount: $' . $data['amount'] . ', Payment Method: ' . $payui . ', Pay Date: ' . $payfinaldate ;
                           $this->SendSMS($mobileno, $msg);
                        }
                    //exit();
                }
            } elseif (($_POST['PaymentOption'] ?? '') == 'stripe') {

                //$amount = $_POST['Amount'] ?? '';
                $amount = $_POST['amount'] ?? '';


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
                            "description" => "Pay For:" . ($_POST['pay_for'] ?? '') . ', ' . "Email:" . ($_POST['email'] ?? '') . ', ' . "Full Name:" . ($_POST['name'] ?? ''),
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
                        $opts['txn_id'] = $payment->id;
                        $opts['paid_amount'] = $payment->amount;
                        $opts['stripe_product'] = $payment->description;
                        $opts['payment_status'] = 'confirmed';
                        $opts['payment_timestamp'] = time();
                        $_POST['status'] = 'confirmed';
                        $data = $_POST;
                        $datamemberarr = array();
                        $datamemberarr = array_merge($opts, $_POST);
                        $ticketModel->update(array_merge($opts, $_POST));
                        $this->sendTicketEventconfirmation($data);
                        $value = array();
                        $value['oid'] = $datamemberarr['oid'];
                        $value['eventid'] = $datamemberarr['eventid'];
                        $value['type'] = $datamemberarr['type'];
                        $value['Member_id'] = $datamemberarr['Member_id'];
                        $value['MemberName'] = $datamemberarr['name'];
                        $value['PaymentOption'] = $datamemberarr['PaymentOption'];
                        $value['payment_status'] = 'succeeded';
                        $value['payment_timestamp'] = $datamemberarr['payment_timestamp'] ?? '';
                        $value['Amount'] = $datamemberarr['amount'];
                        $value['stripe_return'] = $datamemberarr['stripe_return'] ?? '';
                        $value['transaction_id'] = $datamemberarr['txn_id'];
                        $value['paid_amount'] = $datamemberarr['paid_amount'] ?? '';
                        $value['update_on'] = $datamemberarr['UpdateOn'];
                        $value['stripe_product'] = $datamemberarr['stripe_product'] ?? '';
                        $value['pay_date'] = $datamemberarr['pay_date'];
                        $value['pay_type'] = 'OTHER';
                        $value['pay_for'] = $datamemberarr['pay_for'];
                        $value['Tele1'] = $datamemberarr['tele'];
                        $value['email'] = $datamemberarr['email'];
                        $value['spousename'] = $datamemberarr['spousename'];
                        $value['Address'] = $datamemberarr['Address'];
                        $value['Street'] = $datamemberarr['street'];
                        $value['City'] = $datamemberarr['city'];
                        $value['State'] = $datamemberarr['state'];
                        $value['Zip_Code'] = $datamemberarr['zip'];
                        $DonationModel->SaveDataInDonation($value);
                        if ($datamember == null) {
                            $value = array();
                            $value['oid'] = $_POST['oid'] ?? '';
                            $value['MemberName'] = $_POST['name'] ?? '';
                            $value['Tele1'] = $_POST['tele'] ?? '';
                            $value['email'] = $_POST['email'] ?? '';
                            $value['City'] = $_POST['city'] ?? '';
                            $value['State'] = $_POST['state'] ?? '';
                            $value['Zip_Code'] = $_POST['zip'] ?? '';
                            $value['Item_Name'] = $_POST['item_name'] ?? '';
                            $value['Item_Number'] = $_POST['item_number'] ?? '';
                            $value['Item_Cost'] = $_POST['item_cost'] ?? '';
                            $value['Amount'] = $_POST['amount'] ?? '';
                            $value['pay_type'] = 'OTHER';
                            $value['pay_for'] = $_POST['pay_for'] ?? '';
                            $value['pay_date'] = $_POST['pay_date'] ?? '';
                            $value['transaction_id'] = $_POST['txn_id'] ?? '';
                            $value['remarks'] = $_POST['remarks'] ?? '';
                            $value['created_on'] = $_POST['created_on'] ?? '';
                            $value['update_on'] = $_POST['update_on'] ?? '';
                            $value['PaymentOption'] = $_POST['PaymentOption'] ?? '';
                            $value['payment_status'] = 'confirmed';
                            $value['cc_name'] = $_POST['cc_name'] ?? '';
                            $value['Member_id'] = $_POST['Member_id'] ?? '';
                            $value['type'] = $_POST['type'] ?? '';
                            $value['street'] = $_POST['street'] ?? '';
                            $value['itemeventday'] = $_POST['itemeventday'] ?? '';
                            $value['spousename'] = $datamemberarr['spousename'];
                            $value['Address2'] = $datamemberarr['Address'];
                            $value['Address1'] = $datamemberarr['street'];
                            $value['Child1'] = $datamemberarr['Child1'];
                            $value['Age1'] = $datamemberarr['Age1'];
                            $value['Child2'] = $datamemberarr['Child2'];
                            $value['Age2'] = $datamemberarr['Age2'];
                            $value['Child3'] = $datamemberarr['Child3'];
                            $value['Age3'] = $datamemberarr['Age3'];
                            $value['Parent1'] = $datamemberarr['Parent1'];
                            $value['Parent2'] = $datamemberarr['Parent2'];
                            $MemberModel->SaveDataInmember($value);
                        }
                        $datefor = $data['pay_date'];
                        $timestamp = !empty($datefor) ? strtotime($datefor) : false;
                        $payfinaldate = $timestamp ? date("m/d/Y", $timestamp) : '';
                        $payui = 'Credit Card';
                        $mobileno = $data['tele2'];
                        if ($data['tele2'] != null) {
                            $msg = 'Houston Durga Bari: Ticket Confirmation are Member Id: ' . $data['Member_id'] . ', Order Id: ' . $data['oid'] . ', Member Name: ' . $data['name'] . ', Puja Type: ' . $data['type'] . ', Total Amount: $' . $data['amount'] . ', Payment Method: ' . $payui . ', Pay Date: ' . $payfinaldate;
                            $this->SendSMS($mobileno, $msg);
                        }

                        $this->tpl['arr'] = $ticketModel->get($id);
                    } else {

                        $opts = array();
                        $opts['id'] = $id;
                        $opts['stripe_return'] = $payment->status;
                        $opts['transaction_id'] = $payment->id;
                        $opts['paid_amount'] = $payment->amount;
                        $opts['stripe_product'] = $payment->description;

                        $ticketeventnameModel->update($opts);

                        $_SESSION['status'] = '<strong>' . __('declined_card') . '</strong>';
                    }
                } catch (Exception $ex) {
                    $_SESSION['status'] = $ex->getMessage();
                }

            } else {
                $_SESSION['status'] = 16;

            }
        } else {
            $_SESSION['status'] = 17;
        }

        $id = $_GET['id'] ?? '';
        if ($id != null || $id = "") {
            $userticketarr = $ticketModel->get($id);
            $this->tpl['userticketarr'] = $userticketarr;

        }
        
    }
    // end
    
    function create()
    {
        GzObject::loadFiles('Model', array('ticketeventname'));
        $ticketeventnameModel = new ticketeventnameModel();
        if (!empty($_POST['create'])) {
            if (!empty($_FILES['image'])) {

                require_once APP_PATH . 'helpers/uploader/class.upload.php';

                $handle = new upload($_FILES['image']);

                $img_name = time();

                if ($handle->uploaded) {

                    $thumb_dest = INSTALL_PATH . UPLOAD_PATH . 'avatar/thumb/';

                    $handle->file_new_name_body = $img_name;
                    $handle->image_resize = true;
                    $handle->image_x = 200;
                    $handle->image_ratio_y = true;
                    $handle->allowed = array('image/*');
                    $handle->process($thumb_dest);

                    if ($handle->processed) {
                        $handle->clean();
                    } else {
                        echo 'error : ' . $handle->error;
                    }
                    $data['ticketavatar'] = $handle->file_dst_name;
                }
            }
            $_POST['ticketavatar'] = $data['ticketavatar'];
            $_POST['eventtype'] = "PujaTicket";
            $id = $ticketeventnameModel->save(array_merge($_POST));

            if (!empty($id)) {
                $_SESSION['status'] = 16;
            } else {
                $_SESSION['status'] = 17;
            }
            Util::redirect(INSTALL_URL . "Ticketadmin/index");
        }
    }


    function ticketedit()
    {
        GzObject::loadFiles('Model', array('ticketeventname'));
        $ticketeventnameModel = new ticketeventnameModel();
        if (!empty($_POST['edit_ticket'])) {
            $data = array();

            if (!empty($_FILES['image'])) {

                require_once APP_PATH . 'helpers/uploader/class.upload.php';

                $handle = new upload($_FILES['image']);

                $img_name = time();

                if ($handle->uploaded) {

                    $thumb_dest = INSTALL_PATH . UPLOAD_PATH . 'avatar/thumb/';

                    $handle->file_new_name_body = $img_name;
                    $handle->image_resize = true;
                    $handle->image_x = 200;
                    $handle->image_ratio_y = true;
                    $handle->allowed = array('image/*');
                    $handle->process($thumb_dest);

                    if ($handle->processed) {
                        $handle->clean();
                    } else {
                        echo 'error : ' . $handle->error;
                    }
                    $data['ticketavatar'] = $handle->file_dst_name;
                }
            }

            $id = $ticketeventnameModel->update(array_merge($data, $_POST));


            if (!empty($id)) {
                $_SESSION['status'] = 20;
            } else {
                $_SESSION['status'] = 21;
            }

            if (!$this->isAdmin()) {
                Util::redirect(INSTALL_URL . "Admin/dashboard");
            } else {
                Util::redirect(INSTALL_URL . "Ticketadmin/index");
            }
        }
        $id = $_GET['id'] ?? '';
        $ticketeventarr = $ticketeventnameModel->get($id);
        $this->tpl['ticketeventarr'] = $ticketeventarr;
    }

    // Function for ticket price create 
    function ticketpricecreate()
    {
        GzObject::loadFiles('Model', array('PujaTicketPrice'));
        $PujaTicketPriceModel = new PujaTicketPriceModel();

        if (!empty($_POST['ticketpricecreate'])) {

            // $data = array();

            $id = $PujaTicketPriceModel->save(array_merge($_POST));

            if (!empty($id)) {
                $_SESSION['status'] = 16;
            } else {
                $_SESSION['status'] = 17;
            }
            Util::redirect(INSTALL_URL . "Ticketadmin/index");
        }
    }

    // end

    // Function for ticket price edit 
 function ticketpriceedit()
    {
        GzObject::loadFiles('Model', array('PujaTicketPrice'));
        $PujaTicketPriceModel = new PujaTicketPriceModel();
        if (!empty($_POST['ticketpriceedit'])) {

            $data = array();
            $id = $PujaTicketPriceModel->update(array_merge($_POST));

            if (!empty($id)) {
                $_SESSION['status'] = 20;
            } else {
                $_SESSION['status'] = 21;
            }

            if (!$this->isAdmin()) {
                Util::redirect(INSTALL_URL . "Admin/dashboard");
            } else {
                Util::redirect(INSTALL_URL . "Ticketadmin/index");
            }
        }
        $id = $_GET['id'] ?? '';
        $ticketpricearr = $PujaTicketPriceModel->get($id);
        $this->tpl['ticketpricearr'] = $ticketpricearr;

    }
    // end
    

    function ticketexport()
    {

        $this->isAjax = true;
        $type = $_GET['ID'] ?? '';

        GzObject::loadFiles('Model', array('ticket'));
        $ticketModel = new ticketModel();
        $opts = array();
        $header_args = array('id', 'oid ', 'name', 'numberofadults', 'additional_adult_amount', 'adult1_fname', 'adult2_fname', 'adult3_fname', 'adult4_fname', 'numberofchilds', 'additional_child_amount', 'child1_fname', 'child2_fname', 'child3_fname', 'address', 'tele ', 'email', 'city', 'state', 'zip', 'item_name', 'item_number', 'item_cost', 'amount', 'pay_for', 'pay_date', 'txn_id', 'status', 'remarks', 'created_on', 'update_on', 'PaymentOption', 'payment_status', 'payment_timestamp', 'stripe_return', 'paid_amount', 'stripe_product', 'cc_name', 'Member_id', 'type', 'street', 'eventid', 'itemeventday', 'bank', 'chkno', 'chkdate', 'ReceiveBy', 'regmember', 'eventtype','tickettype','spousename','Child1','Age1','Child2','Age2','Child3','Age3','Parent1','Parent2','admin_id','admin_name');

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=puja_ticketrecords.csv');
        $output = fopen('php://output', 'w');
        ob_end_clean();
        fputcsv($output, $header_args, ',', '"', '\\');

        if ($type == "Ticket") {
            $query = $ticketModel->ticketAlldata($type);
        }

        $members = $query;

        foreach ($members as $data_item) {
            fputcsv($output, $data_item, ',', '"', '\\');
        }
        exit;
    }


    function delete()
    {
        $this->isAjax = true;
        $id = ($_REQUEST['id'] ?? '');
        $cat = ($_REQUEST['cat'] ?? '');

        GzObject::loadFiles('Model', array('ticketeventname', 'PujaTicketPrice', 'ticket'));
        $ticketeventnameModel = new ticketeventnameModel();
        $PujaTicketPriceModel = new PujaTicketPriceModel();
        $ticketModel = new ticketModel();

        if($cat == 1){
            $ticketModel->deleteFrom($ticketModel->getTable())
             ->where('id', $id)->execute();
        }
        elseif($cat == 2){
          $ticketeventnameModel->deleteFrom($ticketeventnameModel->getTable())
            ->where('id', $id)->execute();
        }
        elseif($cat == 3){
            $PujaTicketPriceModel->deleteFrom($PujaTicketPriceModel->getTable())
             ->where('id', $id)->execute();
        }
        $opts = array();
        Util::redirect(INSTALL_URL . "Ticketadmin/index");

    }


    function deleteEditedticketImage()
    {
        $this->isAjax = true;

        GzObject::loadFiles('Model', array('ticketeventname', ));
        $ticketeventnameModel = new ticketeventnameModel();

        if (!empty($_POST['id'])) {

            $id = $_POST['id'] ?? '';

            $Eventticketname = $ticketeventnameModel->get($id);

            $dest = INSTALL_PATH . UPLOAD_PATH . "avatar/thumb/" . $Eventticketname['avatar'];
            if (is_file($dest)) {
                unlink($dest);
            }

            $data = array();
            $data['avatar'] = '';

            $ticketeventnameModel->update(array_merge($_POST, $data));

        }
    }
}

?>
