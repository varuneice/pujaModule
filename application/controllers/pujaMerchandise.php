<?php

require_once CONTROLLERS_PATH . 'App.php';

class pujaMerchandise extends App
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
        $this->js[] = array('file' => 'gzadmin/plugins/daterangepicker/daterangepicker.js', 'path' => JS_PATH);

        //for stripe payment
        $this->js[] = array('file' => '', 'path' => 'https://js.stripe.com/v3/', 'remote' => 1);
        $cacheBust = time();
        $this->js[] = array('file' => 'admin.js?v=' . $cacheBust, 'path' => JS_PATH);
        $this->js[] = array('file' => 'otp-member-verify.js?v=' . $cacheBust, 'path' => JS_PATH);
        $this->js[] = array('file' => 'Gzpujamerchandise.js?v=' . $cacheBust, 'path' => JS_PATH);
        $this->js[] = array('file' => 'loadingoverlay.js?v=' . $cacheBust, 'path' => JS_PATH);

    }
   
      function pujaMerchandise() {
    $this->layout = 'login';
  }

  function __construct()
    {

        GzObject::loadFiles('Model', array('ConfirmCode', 'User', 'Member', 'Donation', 'idnumbers', 'merchandisePriceLimit', 'merchandiseDeadline',  'totalPurchasedItem'));
        $getAllMerchandiseData = new merchandisePriceLimitModel();
        $merchandiseDeadline = new merchandiseDeadlineModel();
        $UserModel = new UserModel();
        $ConfirmCodeModel = new ConfirmCodeModel();
        $MemberModel = new MemberModel();
        $DonationModel = new DonationModel();
        $idnumbersModel = new idnumbersModel();
        $allPurchaseData = new totalPurchasedItemModel();
        $allData = $getAllMerchandiseData->getAllData();
        $deadline = $merchandiseDeadline->getDeadLine();
        
        
        // echo "<script>alert('Puja Merchandise is currently Closed');</script>";
        
        
       
        
        
        // if ($this->isAdmin() || $this->isEditor()) {
        //       Util::redirect(INSTALL_URL . "Admin/login");
        //     }
            
        //  else
        // {
        //      Util::redirect(INSTALL_URL . "onlinepujapayments/onlinepujapayments");
        // }
        
        
        // return;
       
        
        
      
       

        $today = date('Y-m-d');
        $deadline = $deadline[0]['deadline'];

        $deadLinePassed = false;

        if ($deadline < $today) {
            $deadLinePassed = true;
        } else {
            $deadLinePassed = false;
        }

        $this->tpl['deadLinePassed'] = $deadLinePassed;

        $this->tpl['AllClothData'] = $allData;

        if (!$deadLinePassed) {

            foreach ($allData as $item) {

                if ($item['cloth_name'] == "saree_terracotta") {
                    $this->tpl['saree_terracotta_limit'] = $item['limit_early'];

                }

                if ($item['cloth_name'] == "saree_tussar") {
                    $this->tpl['saree_tussar_limit'] = $item['limit_early'];

                }

                if ($item['cloth_name'] == "punjabi_beige_red") {
                    $this->tpl['punjabi_beige_red_limit'] = $item['limit_early'];

                }

                if ($item['cloth_name'] == "punjabi_white_red") {
                    $this->tpl['punjabi_white_red_limit'] = $item['limit_early'];

                }
            }

        } else {
            foreach ($allData as $item) {

                if ($item['cloth_name'] == "saree_terracotta") {
                    $this->tpl['saree_terracotta_limit'] = $item['limit_regular'];

                }

                if ($item['cloth_name'] == "saree_tussar") {
                    $this->tpl['saree_tussar_limit'] = $item['limit_regular'];

                }

                if ($item['cloth_name'] == "punjabi_beige_red") {
                    $this->tpl['punjabi_beige_red_limit'] = $item['limit_regular'];

                }

                if ($item['cloth_name'] == "punjabi_white_red") {
                    $this->tpl['punjabi_white_red_limit'] = $item['limit_regular'];

                }
            }

        }


        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            unset($_SESSION['merchandise_payment_processed']);
        }

         if (!empty($_POST['policy_accept'])) {

            if (isset($_SESSION['merchandise_payment_processed']) && $_SESSION['merchandise_payment_processed'] === true) {
                unset($_SESSION['merchandise_payment_processed']);
                Util::redirect(INSTALL_URL . "pujaMerchandise/pujaMerchandise");
                exit();
            }
            
            $F_Name = $_POST['F_Name'] ?? '';
            $L_Name = $_POST['L_Name'] ?? '';
            if ( empty($F_Name) || empty($L_Name)) 
            {
                Util::redirect(INSTALL_URL . "pujaMerchandise/pujaMerchandise");
                exit();
            }

            $data = array();
            date_default_timezone_set("America/Chicago");
            $today = date("Y/m/d");
            $_POST['pay_date'] = $today;
            $_POST['pay_type'] = 'Puja Merchandise';
            $_POST['pay_for'] = "puja merchandise saree/punjabi ";
            // for generate oid 
            $maxoid = $idnumbersModel->getMaxoid() + 1;
            $update_oid = $idnumbersModel->Updateoid($maxoid);
            $_POST['oid'] = $maxoid;
            // end generate oid for   

            if ($this->isAdmin() || $this->isEditor()) {
                $id = $this->getUserId();
                $admin = $UserModel->get($id);
                $rolename = $admin['first'] . ' ' . $admin['last'];
                $_POST['admin_id'] = $admin['id'];
                $_POST['admin_name'] = $rolename;
            }

             if (($_POST['saree_name'] ?? '') == "saree_tussar") {
                $_POST['saree_terracotta_qty'] = "";
                $_POST['sarre_terracotta_amount'] = "";
                
                
            }
            if (($_POST['saree_name'] ?? '') == "saree_terracotta") {
                $_POST['saree_tussar_qty'] = "";
                $_POST['sarre_tussar_amount'] = "";
            }
            if (($_POST['saree_name'] ?? '') == "" || ($_POST['saree_name'] ?? '') == "none") {
                $_POST['saree_terracotta_qty'] = "";
                $_POST['saree_tussar_qty'] = "";
                $_POST['sarre_terracotta_amount'] = "";
                $_POST['sarre_tussar_amount'] = "";
            }
            if (($_POST['punjabi_name'] ?? '') == "punjabi_beige_red") {
                $_POST['punjabi_white_red_qty'] = "";
                $_POST['punjabi_white_red_size'] = "";
                $_POST['punjabi_white_red_amount'] = "";
            }
            if (($_POST['punjabi_name'] ?? '') == "punjabi_white_red") {
                $_POST['punjabi_beige_red_qty'] = "";
                $_POST['punjabi_beige_red_size'] = "";
                $_POST['punjabi_beige_red_amount'] = "";
            }
            if (($_POST['punjabi_name'] ?? '') == "" || ($_POST['punjabi_name'] ?? '') == "none") {
                $_POST['punjabi_beige_red_qty'] = "";
                $_POST['punjabi_beige_red_size'] = "";
                $_POST['punjabi_white_red_qty'] = "";
                $_POST['punjabi_white_red_size'] = "";
                $_POST['punjabi_beige_red_amount'] = "";
                $_POST['punjabi_white_red_amount'] = "";
            }

            $datamember = $MemberModel->rentalmemberduplicate();
            if ($datamember == null) {

                // for generate memberid for gd
                $maxid = $idnumbersModel->getMaxmid() + 1;
                $update_mid = $idnumbersModel->Updatemid($maxid);
                $_POST['member_id'] = $maxid;
                $_POST['membercategory'] = 'GC';
                // end generate memberid for gd 
            }
            if ($datamember != null) {
                $_POST['member_id'] = $datamember;
            }
            if (($_POST['PaymentOption'] ?? '') == 'others') {

                $opts = array();
                $cmCode = $_POST['code'] ?? '';
                $isAvailable = $ConfirmCodeModel->ConfirmCheckCode($cmCode);
                if(!$isAvailable)
                {
                    Util::redirect(INSTALL_URL . "pujaMerchandise/pujaMerchandise");
                    exit();
                }
                $arr = $ConfirmCodeModel->UpdateCode($cmCode);
                $_POST['transaction_id'] = $cmCode;
                $opts['Confirmation'] = $_POST['confirm_code'] ?? '';
                $arr = $ConfirmCodeModel->getAll($opts);
                $oid = $_POST['oid'] ?? '';
                //if (!empty($arr[0])) {
                if ($oid != null) {
                    $opts = array();
                    $punjabiName = "";
                        if (($_POST['punjabi_name'] ?? '') == "both") {
                            $punjabiName = " Punjabi Beige-Red and Punjabi White-Red";
                        } 

                        if (($_POST['punjabi_name'] ?? '') == "punjabi_beige_red") {
                            $punjabiName = " Punjabi Beige-Red";

                        }

                        if (($_POST['punjabi_name'] ?? '') == "punjabi_white_red") {
                            $punjabiName = " Punjabi White-Red";

                        }

                        $sareeName = "";

                        if (($_POST['saree_name'] ?? '') == "both") {
                            $sareeName = " Saree Terracotta and Saree Tussar";
                        } 

                        if (($_POST['saree_name'] ?? '') == "saree_terracotta") {
                            $sareeName = " Saree Terracotta";
                        } 

                        if (($_POST['saree_name'] ?? '') == "saree_tussar") {
                            $sareeName = " Saree Tussar";
                        } 
                    
                         // send quantity and pujabi amd saree details
                        $payment_for = [];

                        if (!empty($punjabiName)) {
                            $payment_for[] = 'Punjabi name - ' . $punjabiName;
                        }

                        if (!empty($sareeName)) {
                            $payment_for[] = 'Saree name - ' . $sareeName;
                        }

                        $payment_for = implode(' , ', $payment_for);


                        $quantity = [];
                        if (!empty($_POST['punjabi_beige_red_qty'])) {
                            $quantity[] = 'Punjabi Beige-Red - ' . ($_POST['punjabi_beige_red_qty'] ?? '');
                        }

                        if (!empty($_POST['punjabi_white_red_qty'])) {
                            $quantity[] = 'Punjabi White-Red - ' . ($_POST['punjabi_white_red_qty'] ?? '');
                        }

                        if (!empty($_POST['saree_terracotta_qty'])) {
                            $quantity[] = 'Saree Terracotta - ' . ($_POST['saree_terracotta_qty'] ?? '');
                        }

                        if (!empty($_POST['saree_tussar_qty'])) {
                            $quantity[] = 'Saree Tussar - ' . ($_POST['saree_tussar_qty'] ?? '');
                        }
                        $quantity = implode(' , ', $quantity);


                    $data = $_POST;
                    $MemberName = ($_POST['F_Name'] ?? '') . ' ' . ($_POST['L_Name'] ?? '');
                    $Amount = $_POST['amount'] ?? '';
                    $transaction_id = $_POST['transaction_id'] ?? '';
                    $opts['payment_status'] = 'succeeded';
                    $payment_status = $opts['payment_status'];
                    $memberid = $_POST['member_id'] ?? '';
                    $datefor = $_POST['pay_date'] ?? '';
                    
                    $timestamp = !empty($datefor) ? strtotime($datefor) : false;
                    $payfinaldate = $timestamp ? date("m/d/Y", $timestamp) : '';
                    $_POST['status'] = 'confirmed';
                    $spouseName = ($_POST['SFirst_Name'] ?? '') . ' ' . ($_POST['SLast_Name'] ?? '');
                    

                    echo "<div style='margin-left:23em;' class = 'pay'>
                        <table border='4'  width='585px' style='margin-left:4em;'>
                         <tr>
                         <td colspan='2'> <img src='../thankyouscreen.jpg' alt='' height='167px' style='margin-left:12em;'><h1 style='text-align:center;font-family:fangsong; font-size:30px;'><b>Houston Durga Bari Society</b></h1> </td>
                       
                          <tr><td style='width:50%;'>Order Id</td><td style='width:50%;'>" . $oid . "</td></tr>
                          <tr>
                         <td>Member Id</td> <td>" . $memberid . "</td></tr>
                         <tr>
                        <td>Member Name</td> <td>" . $MemberName . "</td> </tr>
                        <td>Spouse Name</td> <td>" . $spouseName . "</td> </tr>
                        <tr><td>Payment For</td> <td>" . $payment_for . "</td> </tr>
                        <tr><td>Quantity</td> <td>" . $quantity . "</td> </tr>
                        <tr><td>Amount</td> <td><span style= 'color:red;'>$</span>" . $Amount . "</td> </tr>
                        <tr><td>Payment Method</td> <td>Zelle</td>  </tr>
                        
                        <tr><td>Pay Date</td> <td>" . $payfinaldate . "</td>  </tr>
                        
                        <tr><td>Payment Status</td> <td>" . $payment_status . "</td>  </tr>
                        <tr><td colspan='2'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>   </tr>
                        </tr>";

                    echo "</table>";
                    echo "</div>";
                    echo "<div style='text-align: center; margin-top: 20px; '>
                    <a href='" . INSTALL_URL . "pujaMerchandise/pujaMerchandise'>Go to home</a>
                  </div>";
                    $datamemberarr = array();
                    $datamemberarr = array_merge($opts, $_POST);
                    //    $EventModel->update(array_merge($opts, $_POST));

                    $esult = $allPurchaseData->save(array_merge($opts, $_POST));

                    $value = array();
                    $value['oid'] = $datamemberarr['oid'];

                    $value['oid'] = $oid;
                    $value['Member_id'] = $datamemberarr['member_id'];
                    $value['MemberName'] = $datamemberarr['F_Name'] . ' ' . $datamemberarr['L_Name'];
                    $value['PaymentOption'] = $datamemberarr['PaymentOption'];
                    $value['payment_status'] = 'succeeded';
                    $value['payment_timestamp'] = $datamemberarr['payment_timestamp'] ?? '';
                    $value['stripe_return'] = $datamemberarr['stripe_return'] ?? '';
                    $value['transaction_id'] = $datamemberarr['transaction_id'];
                    $value['paid_amount'] = $datamemberarr['paid_amount'] ?? '';
                    $value['Amount'] = $datamemberarr['amount'];
                    if (!empty($datamemberarr['UpdateOn'] ?? '')) {
                        $value['update_on'] = $datamemberarr['UpdateOn'];
                    }

                    $value['pay_date'] = $datamemberarr['pay_date'];
                    $value['pay_type'] = $datamemberarr['pay_type'];
                    $value['pay_for'] = $datamemberarr['pay_for'];
                    $value['Tele1'] = $datamemberarr['phone'];
                    $value['email'] = $datamemberarr['email'];
                    $value['spousename'] = $datamemberarr['SFirst_Name'] . ' ' . $datamemberarr['SLast_Name'];
                    $value['Address'] = $datamemberarr['streetname'];
                    $value['Street'] = $datamemberarr['street'];
                    $value['City'] = $datamemberarr['City'];
                    $value['State'] = $datamemberarr['State'];
                    $value['Zip_Code'] = $datamemberarr['Zip'];
                    $value['type'] = "Puja Merchandise Saree/Punjabi";

                    $value['admin_id'] = isset($_POST['admin_id']) && is_numeric($_POST['admin_id']) ? (int)$_POST['admin_id'] : null;
                    $value['admin_name']= $_POST['admin_name'] ?? '';
                    $DonationModel->SaveDataInDonation(array_merge($value , $_POST));
                    if ($datamember == null) {
                        $value = array();
                        $value['type'] = $_POST['pay_type'] ?? '';

                        $value['MemberName'] = ($_POST['F_Name'] ?? '') . ' ' . ($_POST['L_Name'] ?? '');
                        $value['Amount'] = $_POST['amount'] ?? '';
                        $value['PaymentOption'] = $_POST['PaymentOption'] ?? '';
                        $value['payment_status'] = 'confirmed';
                        $value['transaction_id'] = $_POST['transaction_id'] ?? '';
                        $value['update_on'] = $_POST['update_on'] ?? '';
                        $value['Member_id'] = $_POST['member_id'] ?? '';
                        $value['pay_date'] = $_POST['pay_date'] ?? '';
                        $value['cc_name'] = $_POST['cc_name'] ?? '';
                        $value['remarks'] = $_POST['remarks'] ?? '';
                        $value['oid'] = $_POST['oid'] ?? '';
                        $value['pay_type'] = $_POST['pay_type'] ?? '';
                        $value['pay_for'] = $_POST['pay_for'] ?? '';
                        $value['Address'] = $_POST['fullAddress'] ?? '';
                        $value['Street'] = $_POST['Street'] ?? '';
                        $value['State'] = $_POST['State'] ?? '';
                        $value['Zip_Code'] = $_POST['Zip_Code'] ?? '';
                        $value['Phone_Number'] = $_POST['Phone_Number'] ?? '';
                        $value['email'] = $_POST['email'] ?? '';
                        $value['City'] = $_POST['City'] ?? '';
                        $value['Tele1'] = $_POST['Tele1'] ?? '';

                        $value['Address3'] = $_POST['Address3'] ?? '';
                        $MemberModel->SaveDataInmember($value);
                    }


                    //$Emailcc = 'pujamerchandise@durgabari.org';
                    $Emailcc = 'pujamerchandiseorder@durgabari.org';
                    $subjetc = 'Puja Merchandise Payment';
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
                        <td style="text-align: center; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;"><strong>Puja Merchandise Details</strong></td>
                        </tr>
                        </tbody>
                        </table>
                        </div>
                        <div class="email-token-class" style="text-align: center;">
                        <table style="height: 190px; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;" width="604">
                        <tbody>
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Member Id&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">' . $memberid . '</td>
                        </tr>
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Member Name&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">' . $MemberName . '</td>
                        </tr> 
                        
                         <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Spouse Name&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">' . $spouseName . '</td>
                        </tr> 
                        
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Order Id&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">' . $oid . '</td>
                        </tr>
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Payment For&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $payment_for . '</td>
                        </tr>
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Quantity &nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $quantity . '</td>
                        </tr>
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Total Amount&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;"><span style="color:red;">$</span>' . $Amount . '</td>
                        </tr>

                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Payment Method&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;"> Zelle &nbsp;&nbsp; </td>
                        </tr>
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Pay Date&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">' . $payfinaldate . '</td>
                        </tr> 
                         <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Payment Status&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">' . $payment_status . '</td>
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

                    $mobileno = $_POST['phone'] ?? '';
                    if ($mobileno != null) {
                        $msg = 'Houston Durga Bari: Puja Merchandise confirmation - ' .
                            'Member Id: ' . $memberid . ', ' .
                            'Member Name: ' . $MemberName . ', ' .
                             'Spouse Name: ' . $spouseName . ', ' .
                            'Order Id: ' . $oid . ', ' .
                            'Payment For: ' . $payment_for . ', ' .
                            'Quantity: ' . $quantity . ', ' .
                            'Amount: $' . $Amount . ', ' .
                            'Payment Method: Zelle, ' .
                           
                            'Pay Date: ' . $payfinaldate . ', ' .
                            'Payment Status: ' . $payment_status;
                         $this->SendSMS($mobileno, $msg);
                    }
                    $_SESSION['merchandise_payment_processed'] = true;
                    exit();
                }
            } elseif (($_POST['PaymentOption'] ?? '') == 'check') {
                $_POST['amount'] = $_POST['checkAmount'] ?? '';
                $_POST['bank'] = $_POST['checkbankname'] ?? '';
                $_POST['chkdate'] = $_POST['CheckDate'] ?? '';
                $_POST['DepositAccount'] = $_POST['CheckDepositAccount'] ?? '';
                $_POST['status'] = 'succeeded';
                $oid = $_POST['oid'] ?? '';
                $data = $_POST;
                $value = array();
                    $value['type'] = $_POST['pay_type'] ?? '';
                    $value['Payment_For'] = "Puja Merchandise";
                    $value['MemberName'] = ($_POST['F_Name'] ?? '') . ' ' . ($_POST['L_Name'] ?? '');;
                    $value['Amount'] = $_POST['amount'] ?? '';
                    $value['PaymentOption'] = $_POST['PaymentOption'] ?? '';
                    $value['payment_status'] = 'confirmed';
                    $value['transaction_id'] = $_POST['transaction_id'] ?? '';
                    $value['update_on'] = $_POST['update_on'] ?? '';
                    $value['Member_id'] = $_POST['member_id'] ?? '';
                    $value['pay_date'] = $_POST['pay_date'] ?? '';
                    $value['cc_name'] = $_POST['cc_name'] ?? '';
                    $value['remarks'] = $_POST['remarks'] ?? '';
                    $value['oid'] = $_POST['oid'] ?? '';
                    $value['pay_type'] = $_POST['pay_type'] ?? '';
                    $value['pay_for'] = $_POST['pay_for'] ?? '';
                    $value['Address'] = $_POST['fullAddress'] ?? '';
                    $value['Street'] = $_POST['Street'] ?? '';
                    $value['State'] = $_POST['State'] ?? '';
                    $value['Zip_Code'] = $_POST['Zip_Code'] ?? '';
                    $value['Tele1'] = $_POST['phone'] ?? '';
                    $value['Tele2'] = $_POST['alternatenumber'] ?? '';
                    $value['email'] = $_POST['email'] ?? '';
                    $value['City'] = $_POST['City'] ?? '';
                  
                    $value['spousename'] = ($_POST['SFirst_Name'] ?? '') . ' ' . ($_POST['SLast_Name'] ?? '');
                    $value['purpose'] = $_POST['purpose'] ?? '';
                    $value['Address3'] = $_POST['Address3'] ?? '';

                $DonationModel->SaveDataInDonation(array_merge($value , $_POST));
                $memberid = $_POST['member_id'] ?? '';
                $confirmdata = $MemberModel->membercheck($memberid);

                if ($datamember == null) {
                    $value = array();

                    $value['type'] = $_POST['pay_type'] ?? '';

                    $value['Payment_For'] = "Puja Merchandise";
                    $value['MemberName'] = ($_POST['F_Name'] ?? '') . ' ' . ($_POST['L_Name'] ?? '');;
                    $value['Amount'] = $_POST['amount'] ?? '';
                    $value['PaymentOption'] = $_POST['PaymentOption'] ?? '';
                    $value['payment_status'] = 'confirmed';
                    $value['transaction_id'] = $_POST['transaction_id'] ?? '';
                    $value['update_on'] = $_POST['update_on'] ?? '';
                    $value['Member_id'] = $_POST['member_id'] ?? '';
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
                  
                    $value['spousename'] = ($_POST['SFirst_Name'] ?? '') . ' ' . ($_POST['SLast_Name'] ?? '');
                    $value['purpose'] = $_POST['purpose'] ?? '';
                    $value['Address3'] = $_POST['Address3'] ?? '';
                   
                    $MemberModel->SaveDataInmember($value);
                }
                $datefor = $_POST['pay_date'] ?? '';
                $timestamp = !empty($datefor) ? strtotime($datefor) : false;
                $payfinaldate = $timestamp ? date("m/d/Y", $timestamp) : '';


                $punjabiName = "";
                        if (($_POST['punjabi_name'] ?? '') == "both") {
                            $punjabiName = " Punjabi Beige-Red and Punjabi White-Red";

                        } 

                        if (($_POST['punjabi_name'] ?? '') == "punjabi_beige_red") {
                            $punjabiName = " Punjabi Beige-Red";

                        }

                        if (($_POST['punjabi_name'] ?? '') == "punjabi_white_red") {
                            $punjabiName = " Punjabi White-Red";

                        }
                        
                        
                        $sareeName = "";

                        if (($_POST['saree_name'] ?? '') == "both") {
                            $sareeName = " Saree Terracotta and Saree Tussar";
                        } 

                        if (($_POST['saree_name'] ?? '') == "saree_terracotta") {
                            $sareeName = " Saree Terracotta";
                        } 

                        
                        if (($_POST['saree_name'] ?? '') == "saree_tussar") {
                            $sareeName = " Saree Tussar";
                        } 



                        $payment_for = [];

                        if (!empty($punjabiName)) {
                            $payment_for[] = 'Punjabi name - ' . $punjabiName;
                        }

                        if (!empty($sareeName)) {
                            $payment_for[] = 'Saree name - ' . $sareeName;
                        }
                        $payment_for = implode(' , ', $payment_for);


                        $quantity = [];
                        if (!empty($_POST['punjabi_beige_red_qty'])) {
                            $quantity[] = 'Punjabi Beige-Red - ' . ($_POST['punjabi_beige_red_qty'] ?? '');
                        }
                        if (!empty($_POST['punjabi_white_red_qty'])) {
                            $quantity[] = 'Punjabi White-Red - ' . ($_POST['punjabi_white_red_qty'] ?? '');
                        }
                        if (!empty($_POST['saree_terracotta_qty'])) {
                            $quantity[] = 'Saree Terracotta - ' . ($_POST['saree_terracotta_qty'] ?? '');
                        }
                        if (!empty($_POST['saree_tussar_qty'])) {
                            $quantity[] = 'Saree Tussar - ' . ($_POST['saree_tussar_qty'] ?? '');
                        }

                       
                        $quantity = implode(' , ', $quantity);
                $data = $_POST;
                $MemberName = ($_POST['F_Name'] ?? '') . ' ' . ($_POST['L_Name'] ?? '');
                $Amount = $_POST['amount'] ?? '';
                //    $transaction_id = $opts['transaction_id'];
                //    $payment_status = $opts['payment_status'];

                $checkNo = $_POST['checkno'] ?? '';
                $payment_status = "success";


                $memberid = $_POST['member_id'] ?? '';
                $datefor = $_POST['pay_date'] ?? '';
             
                $timestamp = !empty($datefor) ? strtotime($datefor) : false;
                $payfinaldate = $timestamp ? date("m/d/Y", $timestamp) : '';
                $spouseName = ($_POST['SFirst_Name'] ?? '') . ' ' . ($_POST['SLast_Name'] ?? '');
                
                
                echo "<div style='margin-left:23em;' class = 'pay'>
                       <table border='4'  width='585px' style='margin-left:4em;'>
                        <tr>
                        <td colspan='2'> <img src='../thankyouscreen.jpg' alt='' height='167px' style='margin-left:12em;'><h1 style='text-align:center;font-family:fangsong; font-size:30px;'><b>Houston Durga Bari Society</b></h1> </td>
                         <tr>
                        <td>Member Id</td> <td>" . $memberid . "</td></tr>
                        <tr>
                       <td>Member Name</td> <td>" . $MemberName . "</td> </tr>
                       <td>Spouse Name</td> <td>" . $spouseName . "</td> </tr>
                        <tr><td style='width:50%;'>Order Id</td><td style='width:50%;'>" . $oid . "</td></tr>
                          <tr>
                       <tr><td>Payment For</td> <td>" . $payment_for . "</td> </tr>
                       <tr><td>Quantity</td> <td>" . $quantity . "</td> </tr>
                       <tr><td>Amount</td> <td><span style= 'color:red;'>$</span>" . $Amount . "</td> </tr>
                       <tr><td>Payment Method</td> <td> Check </td>  </tr>
                       
                       
                       <tr><td>Pay Date</td> <td>" . $payfinaldate . "</td>  </tr>
                       
                       <tr><td>Payment Status</td> <td>" . $payment_status . "</td>  </tr>
                       <tr><td colspan='2'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>   </tr>
                       </tr>";

                echo "</table>";
                echo "</div>";
                echo "<div style='text-align: center; margin-top: 20px;'>
                <a href='" . INSTALL_URL . "pujaMerchandise/pujaMerchandise'>Go to home</a>
              </div>";
        



                $result = $allPurchaseData->save(array_merge($_POST));


                $Emailcc = 'pujamerchandiseorder@durgabari.org';
                $subjetc = 'Puja Merchandise Payment';
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
                        <td style="text-align: center; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;"><strong>Puja Merchandise Details</strong></td>
                        </tr>
                        </tbody>
                        </table>
                        </div>
                        <div class="email-token-class" style="text-align: center;">
                        <table style="height: 190px; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;" width="604">
                        <tbody>
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Member Id&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">' . $memberid . '</td>
                        </tr>
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Member Name&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">' . $MemberName . '</td>
                        </tr> 
                         <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Spouse Name&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">' . $spouseName . '</td>
                        </tr> 
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Order Id&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">' . $oid . '</td>
                        </tr>
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Payment For&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $payment_for . '</td>
                        </tr>
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Quantity &nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $quantity . '</td>
                        </tr>
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Total Amount&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;"><span style="color:red;">$</span>' . $Amount . '</td>
                        </tr>
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Payment Method&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;"> Check &nbsp;&nbsp; </td>
                        </tr>
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Pay Date&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">' . $payfinaldate . '</td>
                        </tr> 
                         <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Payment Status&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">' . $payment_status . '</td>
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

                $mobileno = $_POST['phone'] ?? '';;
                if ($mobileno != null) {
                    $msg = 'Houston Durga Bari: Puja Merchandise confirmation - ' .
                        'Member Id: ' . $memberid . ', ' .
                        'Member Name: ' . $MemberName . ', ' .
                         'Spouse Name: ' . $spouseName . ', ' .
                        'Order Id: ' . $oid . ', ' .
                        'Payment For: ' . $payment_for . ', ' .
                        'Quantity: ' . $quantity . ', ' .
                        'Amount: $' . $Amount . ', ' .
                        'Payment Method: Check, ' .
                        'Pay Date: ' . $payfinaldate . ', ' .
                        'Payment Status: ' . $payment_status;

                        $this->SendSMS($mobileno, $msg);
                }

                $_SESSION['merchandise_payment_processed'] = true;
                exit();

            }
            //  cash
            elseif (($_POST['PaymentOption'] ?? '') == 'cash') {
                $_POST['amount'] = $_POST['cashAmount'] ?? '';
                $_POST['pay_date'] = $_POST['cashDate'] ?? '';
                $_POST['DepositAccount'] = $_POST['CashDepositAccount'] ?? '';
                $_POST['status'] = 'succeeded';
                $oid = $_POST['oid'] ?? '';
                $data = $_POST;
                $memberid = $_POST['member_id'] ?? '';
                $confirmdata = $MemberModel->membercheck($memberid);
                $value = array();

                    $value['type'] = $_POST['pay_type'] ?? '';

                    $value['Payment_For'] = "Puja Merchandise";
                    $value['MemberName'] = ($_POST['F_Name'] ?? '') . ' ' . ($_POST['L_Name'] ?? '');;
                    $value['Amount'] = $_POST['amount'] ?? '';
                    $value['PaymentOption'] = $_POST['PaymentOption'] ?? '';
                    $value['payment_status'] = 'confirmed';
                    $value['transaction_id'] = $_POST['transaction_id'] ?? '';
                    $value['update_on'] = $_POST['update_on'] ?? '';
                    $value['Member_id'] = $_POST['member_id'] ?? '';
                    $value['pay_date'] = $_POST['pay_date'] ?? '';
                    $value['cc_name'] = $_POST['cc_name'] ?? '';
                    $value['remarks'] = $_POST['remarks'] ?? '';
                    $value['oid'] = $_POST['oid'] ?? '';
                    $value['pay_type'] = $_POST['pay_type'] ?? '';
                    $value['pay_for'] = $_POST['pay_for'] ?? '';
                    $value['Address'] = $_POST['fullAddress'] ?? '';
                    $value['Street'] = $_POST['Street'] ?? '';
                    $value['State'] = $_POST['State'] ?? '';
                    $value['Zip_Code'] = $_POST['Zip_Code'] ?? '';
                    $value['Tele1'] = $_POST['phone'] ?? '';
                    $value['Tele2'] = $_POST['alternatenumber'] ?? '';
                    $value['email'] = $_POST['email'] ?? '';
                    $value['City'] = $_POST['City'] ?? '';
                  
                    $value['spousename'] = ($_POST['SFirst_Name'] ?? '') . ' ' . ($_POST['SLast_Name'] ?? '');
                    $value['purpose'] = $_POST['purpose'] ?? '';
                    $value['Address3'] = $_POST['Address3'] ?? '';

                $DonationModel->SaveDataInDonation(array_merge($value , $_POST));


                if ($datamember == null) {
                    $value = array();
                    // $value['id'] = $_POST['id'] ?? '';
                    $value['type'] = $_POST['pay_type'] ?? '';

                    $value['Payment_For'] = "Puja Merchandise";
                    $value['MemberName'] = ($_POST['F_Name'] ?? '') . ' ' . ($_POST['L_Name'] ?? '');
                    $value['Amount'] = $_POST['amount'] ?? '';
                    $value['PaymentOption'] = $_POST['PaymentOption'] ?? '';
                    $value['payment_status'] = 'confirmed';
                    $value['transaction_id'] = $_POST['transaction_id'] ?? '';
                    $value['update_on'] = $_POST['update_on'] ?? '';
                    $value['Member_id'] = $_POST['member_id'] ?? '';
                    $value['pay_date'] = $_POST['pay_date'] ?? '';
                    $value['cc_name'] = $_POST['cc_name'] ?? '';
                    $value['remarks'] = $_POST['remarks'] ?? '';
                    $value['oid'] = $_POST['oid'] ?? '';
                    $value['pay_type'] = $_POST['pay_type'] ?? '';
                    $value['pay_for'] = $_POST['pay_for'] ?? '';
                    $value['Address'] = $_POST['fullAddress'] ?? '';
                    $value['Street'] = $_POST['Street'] ?? '';
                    $value['State'] = $_POST['State'] ?? '';
                    $value['Zip_Code'] = $_POST['Zip_Code'] ?? '';
                    $value['Tele1'] = $_POST['phone'] ?? '';
                    $value['Tele2'] = $_POST['alternatenumber'] ?? '';
                    $value['email'] = $_POST['email'] ?? '';
                    $value['City'] = $_POST['City'] ?? '';

                    $value['spousename'] = ($_POST['SFirst_Name'] ?? '') . ' ' . ($_POST['SLast_Name'] ?? '');
                    $value['purpose'] = $_POST['purpose'] ?? '';
                    $value['Address3'] = $_POST['Address3'] ?? '';
                    $MemberModel->SaveDataInmember($value);
                }
                $datefor = $_POST['pay_date'] ?? '';
                $timestamp = !empty($datefor) ? strtotime($datefor) : false;
                $payfinaldate = $timestamp ? date("m/d/Y", $timestamp) : '';
                $punjabiName = "";
                        if (($_POST['punjabi_name'] ?? '') == "both") {
                            $punjabiName = " Punjabi Beige-Red and Punjabi White-Red";
                        } 

                        if (($_POST['punjabi_name'] ?? '') == "punjabi_beige_red") {
                            $punjabiName = " Punjabi Beige-Red";
                        }

                        if (($_POST['punjabi_name'] ?? '') == "punjabi_white_red") {
                            $punjabiName = " Punjabi White-Red";
                        }
                        
                        
                        $sareeName = "";

                        if (($_POST['saree_name'] ?? '') == "both") {
                            $sareeName = " Saree Terracotta and Saree Tussar";
                        } 

                        if (($_POST['saree_name'] ?? '') == "saree_terracotta") {
                            $sareeName = " Saree Terracotta";
                        } 

                        if (($_POST['saree_name'] ?? '') == "saree_tussar") {
                            $sareeName = " Saree Tussar";
                        } 
                        
                        
                         // send quantity and pujabi amd saree details
                        $payment_for = [];

                        if (!empty($punjabiName)) {
                            $payment_for[] = 'Punjabi name - ' . $punjabiName;
                        }
                        if (!empty($sareeName)) {
                            $payment_for[] = 'Saree name - ' . $sareeName;
                        }
                        $payment_for = implode(' , ', $payment_for);


                        $quantity = [];
                        if (!empty($_POST['punjabi_beige_red_qty'])) {
                            $quantity[] = 'Punjabi Beige-Red - ' . ($_POST['punjabi_beige_red_qty'] ?? '');
                        }
                        if (!empty($_POST['punjabi_white_red_qty'])) {
                            $quantity[] = 'Punjabi White-Red - ' . ($_POST['punjabi_white_red_qty'] ?? '');
                        }
                        if (!empty($_POST['saree_terracotta_qty'])) {
                            $quantity[] = 'Saree Terracotta - ' . ($_POST['saree_terracotta_qty'] ?? '');
                        }
                        if (!empty($_POST['saree_tussar_qty'])) {
                            $quantity[] = 'Saree Tussar - ' . ($_POST['saree_tussar_qty'] ?? '');
                        }
                        $quantity = implode(' , ', $quantity);
                   
                $data = $_POST;
                $MemberName = ($_POST['F_Name'] ?? '') . ' ' . ($_POST['L_Name'] ?? '');
                $Amount = $_POST['amount'] ?? '';
                //    $transaction_id = $opts['transaction_id'];
                //    $payment_status = $opts['payment_status'];

                $transaction_id = $_POST['transaction_id'] ?? '';
                $payment_status = "succeeded";


                $memberid = $_POST['member_id'] ?? '';
                $datefor = $_POST['pay_date'] ?? '';
               
                $timestamp = !empty($datefor) ? strtotime($datefor) : false;
                $payfinaldate = $timestamp ? date("m/d/Y", $timestamp) : '';
                $spouseName = ($_POST['SFirst_Name'] ?? '') . ' ' . ($_POST['SLast_Name'] ?? '');

                

                echo "<div style='margin-left:23em;' class = 'pay'>
                       <table border='4'  width='585px' style='margin-left:4em;'>
                        <tr>
                        <td colspan='2'> <img src='../thankyouscreen.jpg' alt='' height='167px' style='margin-left:12em;'><h1 style='text-align:center;font-family:fangsong; font-size:30px;'><b>Houston Durga Bari Society</b></h1> </td>
                      
                        
                         <tr>
                        <td>Member Id</td> <td>" . $memberid . "</td></tr>
                        <tr>
                          <tr><td style='width:50%;'>Order Id</td><td style='width:50%;'>" . $oid . "</td></tr>
                          <tr>
                       <td>Member Name</td> <td>" . $MemberName . "</td> </tr>
                       <td>Spouse Name</td> <td>" . $spouseName . "</td> </tr>
                       <tr><td>Payment For</td> <td>" . $payment_for . "</td> </tr>
                       <tr><td>Quantity</td> <td>" . $quantity . "</td> </tr>
                       <tr><td>Amount</td> <td><span style= 'color:red;'>$</span>" . $Amount . "</td> </tr>
                       <tr><td>Payment Method</td> <td>cash</td>  </tr>
                     
                       <tr><td>Pay Date</td> <td>" . $payfinaldate . "</td>  </tr>
                       
                       <tr><td>Payment Status</td> <td>" . $payment_status . "</td>  </tr>
                       <tr><td colspan='2'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>   </tr>
                       </tr>";

                echo "</table>";
                echo "</div>";
                echo "<div style='text-align: center; margin-top: 20px;'>
        <a href='" . INSTALL_URL . "pujaMerchandise/pujaMerchandise'>Go to home</a>
      </div>";
                $result = $allPurchaseData->save(array_merge($_POST));
                $Emailcc = 'pujamerchandiseorder@durgabari.org';
                $subjetc = 'Puja Merchandise Payment';
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
                        <td style="text-align: center; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;"><strong>Puja Merchandise Details</strong></td>
                        </tr>
                        </tbody>
                        </table>
                        </div>
                        <div class="email-token-class" style="text-align: center;">
                        <table style="height: 190px; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;" width="604">
                        <tbody>
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Member Id&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">' . $memberid . '</td>
                        </tr>
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Member Name&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">' . $MemberName . '</td>
                        </tr> 
                         <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Spouse Name&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">' . $spouseName . '</td>
                        </tr> 
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Order Id&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">' . $oid . '</td>
                        </tr>
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Payment For&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $payment_for . '</td>
                        </tr>
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Quantity &nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $quantity . '</td>
                        </tr>
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Total Amount&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;"><span style="color:red;">$</span>' . $Amount . '</td>
                        </tr>
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Payment Method&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;"> Cash &nbsp;&nbsp; </td>
                        </tr>
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Pay Date&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">' . $payfinaldate . '</td>
                        </tr> 
                         <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Payment Status&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">' . $payment_status . '</td>
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

                $mobileno = $_POST['phone'] ?? '';
                if ($mobileno != null) {
                    $msg = 'Houston Durga Bari: Puja Merchandise confirmation - ' .
                        'Member Id: ' . $memberid . ', ' .
                        'Order Id: ' . $oid . ', ' .
                        'Member Name: ' . $MemberName . ', ' .
                         'Spouse Name: ' . $spouseName . ', ' .
                        'Payment For: ' . $payment_for . ', ' .
                        'Quantity: ' . $quantity . ', ' .
                        'Amount: $' . $Amount . ', ' .
                        'Payment Method: cash, ' .
                        'Pay Date: ' . $payfinaldate . ', ' .
                        'Payment Status: ' . $payment_status;
                       $this->SendSMS($mobileno, $msg);
                }


                // exit();

                $_SESSION['merchandise_payment_processed'] = true;
                exit();

            }
            // directdeposite
            elseif (($_POST['PaymentOption'] ?? '') == 'directdeposit') {
                $_POST['bank'] = $_POST['BankName'] ?? '';
                $_POST['transaction_id'] = $_POST['ISFCCode'] ?? '';
                $_POST['amount'] = $_POST['directamount'] ?? '';
                $_POST['pay_date'] = $_POST['transactiondate'] ?? '';
                $_POST['DepositAccount'] = $_POST['DirectPayDepositAccount'] ?? '';
                $_POST['status'] = 'succeeded';
                $oid = $_POST['oid'] ?? '';
                $data = $_POST;
                $memberid = $_POST['member_id'] ?? '';
                $confirmdata = $MemberModel->membercheck($memberid);
                if ($datamember == null) {
                    $value = array();
                    // $value['id'] = $_POST['id'] ?? '';
                    $value['Payment_For'] = "Puja Merchandise";
                    $value['MemberName'] = ($_POST['F_Name'] ?? '') . ' ' . ($_POST['L_Name'] ?? '');
                    $value['Amount'] = $_POST['amount'] ?? '';
                    $value['PaymentOption'] = $_POST['PaymentOption'] ?? '';
                    $value['payment_status'] = 'confirmed';
                    $value['transaction_id'] = $_POST['transaction_id'] ?? '';
                    $value['update_on'] = $_POST['update_on'] ?? '';
                    $value['Member_id'] = $_POST['member_id'] ?? '';
                    $value['pay_date'] = $_POST['pay_date'] ?? '';
                    $value['cc_name'] = $_POST['cc_name'] ?? '';
                    $value['remarks'] = $_POST['remarks'] ?? '';
                    $value['oid'] = $_POST['oid'] ?? '';
                    $value['pay_type'] = $_POST['pay_type'] ?? '';
                    $value['pay_for'] = $_POST['pay_for'] ?? '';
                    $value['Address'] = $_POST['fullAddress'] ?? '';
                    $value['Street'] = $_POST['Street'] ?? '';
                    $value['State'] = $_POST['State'] ?? '';
                    $value['Zip_Code'] = $_POST['Zip_Code'] ?? '';
                    $value['Tele1'] = $_POST['phone'] ?? '';
                    $value['Tele2'] = $_POST['alternatenumber'] ?? '';
                    $value['email'] = $_POST['email'] ?? '';
                    $value['City'] = $_POST['City'] ?? '';

                    $value['spousename'] = ($_POST['SFirst_Name'] ?? '') . ' ' . ($_POST['SLast_Name'] ?? '');
                    $value['purpose'] = $_POST['purpose'] ?? '';
                    $value['Address3'] = $_POST['Address3'] ?? '';
                    $MemberModel->SaveDataInmember($value);
                }
                $datefor = $_POST['pay_date'] ?? '';
                $timestamp = !empty($datefor) ? strtotime($datefor) : false;
                $payfinaldate = $timestamp ? date("m/d/Y", $timestamp) : '';
                // $mobileno = $data['alternatenumber'];
                $value = array();
                    $value['type'] = $_POST['pay_type'] ?? '';
                    $value['Payment_For'] = "Puja Merchandise";
                    $value['MemberName'] = ($_POST['F_Name'] ?? '') . ' ' . ($_POST['L_Name'] ?? '');;
                    $value['Amount'] = $_POST['amount'] ?? '';
                    $value['PaymentOption'] = $_POST['PaymentOption'] ?? '';
                    $value['payment_status'] = 'confirmed';
                    $value['transaction_id'] = $_POST['transaction_id'] ?? '';
                    $value['update_on'] = $_POST['update_on'] ?? '';
                    $value['Member_id'] = $_POST['member_id'] ?? '';
                    $value['pay_date'] = $_POST['pay_date'] ?? '';
                    $value['cc_name'] = $_POST['cc_name'] ?? '';
                    $value['remarks'] = $_POST['remarks'] ?? '';
                    $value['oid'] = $_POST['oid'] ?? '';
                    $value['pay_type'] = $_POST['pay_type'] ?? '';
                    $value['pay_for'] = $_POST['pay_for'] ?? '';
                    $value['Address'] = $_POST['fullAddress'] ?? '';
                    $value['Street'] = $_POST['Street'] ?? '';
                    $value['State'] = $_POST['State'] ?? '';
                    $value['Zip_Code'] = $_POST['Zip_Code'] ?? '';
                    $value['Tele1'] = $_POST['phone'] ?? '';
                    $value['Tele2'] = $_POST['alternatenumber'] ?? '';
                    $value['email'] = $_POST['email'] ?? '';
                    $value['City'] = $_POST['City'] ?? '';
                  
                    $value['spousename'] = ($_POST['SFirst_Name'] ?? '') . ' ' . ($_POST['SLast_Name'] ?? '');
                    $value['purpose'] = $_POST['purpose'] ?? '';
                    $value['Address3'] = $_POST['Address3'] ?? '';

                $DonationModel->SaveDataInDonation(array_merge($value , $_POST));


                $punjabiName = "";
                if (($_POST['punjabi_name'] ?? '') == "both") {
                    $punjabiName = " Punjabi Beige-Red and Punjabi White-Red";

                } 

                if (($_POST['punjabi_name'] ?? '') == "punjabi_beige_red") {
                    $punjabiName = " Punjabi Beige-Red";

                }

                if (($_POST['punjabi_name'] ?? '') == "punjabi_white_red") {
                    $punjabiName = " Punjabi White-Red";

                }
                
                
                $sareeName = "";

                if (($_POST['saree_name'] ?? '') == "both") {
                    $sareeName = " Saree Terracotta and Saree Tussar";
                } 

                if (($_POST['saree_name'] ?? '') == "saree_terracotta") {
                    $sareeName = " Saree Terracotta";
                } 

                
                if (($_POST['saree_name'] ?? '') == "saree_tussar") {
                    $sareeName = " Saree Tussar";
                } 
                
                
                
                 // send quantity and pujabi amd saree details
                        $payment_for = [];

                        if (!empty($punjabiName)) {
                            $payment_for[] = 'Punjabi name - ' . $punjabiName;
                        }
                        if (!empty($sareeName)) {
                            $payment_for[] = 'Saree name - ' . $sareeName;
                        }
                        $payment_for = implode(' , ', $payment_for);


                        $quantity = [];
                        if (!empty($_POST['punjabi_beige_red_qty'])) {
                            $quantity[] = 'Punjabi Beige-Red - ' . ($_POST['punjabi_beige_red_qty'] ?? '');
                        }
                        if (!empty($_POST['punjabi_white_red_qty'])) {
                            $quantity[] = 'Punjabi White-Red - ' . ($_POST['punjabi_white_red_qty'] ?? '');
                        }
                        if (!empty($_POST['saree_terracotta_qty'])) {
                            $quantity[] = 'Saree Terracotta - ' . ($_POST['saree_terracotta_qty'] ?? '');
                        }
                        if (!empty($_POST['saree_tussar_qty'])) {
                            $quantity[] = 'Saree Tussar - ' . ($_POST['saree_tussar_qty'] ?? '');
                        }
                        $quantity = implode(' , ', $quantity);
                
                
                

                $data = $_POST;
                $MemberName = ($_POST['F_Name'] ?? '') . ' ' . ($_POST['L_Name'] ?? '');
                $Amount = $_POST['amount'] ?? '';
                //    $transaction_id = $opts['transaction_id'];
                //    $payment_status = $opts['payment_status'];
                $transaction_id = $_POST['transaction_id'] ?? '';
                $payment_status = "success";

                $memberid = $_POST['member_id'] ?? '';
                $datefor = $_POST['pay_date'] ?? '';
               
                $timestamp = !empty($datefor) ? strtotime($datefor) : false;
                $payfinaldate = $timestamp ? date("m/d/Y", $timestamp) : '';
                $description = $_POST['description'] ?? '';
                $spouseName = ($_POST['SFirst_Name'] ?? '') . ' ' . ($_POST['SLast_Name'] ?? '');
               
                echo "<div style='margin-left:23em;' class = 'pay'>
                       <table border='4'  width='585px' style='margin-left:4em;'>
                        <tr>
                        <td colspan='2'> <img src='../thankyouscreen.jpg' alt='' height='167px' style='margin-left:12em;'><h1 style='text-align:center;font-family:fangsong; font-size:30px;'><b>Houston Durga Bari Society</b></h1> </td>
                      
                         
                         <tr>
                        <td>Member Id</td> <td>" . $memberid . "</td></tr>
                        <tr>
                       <td>Member Name</td> <td>" . $MemberName . "</td> </tr>
                       <td>Spouse Name</td> <td>" . $spouseName . "</td> </tr>
                          <tr><td style='width:50%;'>Order Id</td><td style='width:50%;'>" . $oid . "</td></tr>
                          <tr>
                       <tr><td>Payment For</td> <td>" . $payment_for . "</td> </tr>
                       <tr><td>Quantity</td> <td>" . $quantity . "</td> </tr>
                       <tr><td>Amount</td> <td><span style= 'color:red;'>$</span>" . $Amount . "</td> </tr>
                       <tr><td>Payment Method</td> <td> Direct Deposite </td>  </tr>
                       
                       <tr><td>Pay Date</td> <td>" . $payfinaldate . "</td>  </tr>
                       
                       <tr><td>Payment Status</td> <td>" . $payment_status . "</td>  </tr>
                       <tr><td colspan='2'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>   </tr>
                       </tr>";

                echo "</table>";
                echo "</div>";
                echo "<div style='text-align: center; margin-top: 20px;'>
                <a href='" . INSTALL_URL . "pujaMerchandise/pujaMerchandise'>Go to home</a>
              </div>";
        
                $result = $allPurchaseData->save(array_merge($_POST));


                $Emailcc = 'pujamerchandiseorder@durgabari.org';
                $subjetc = 'Puja Merchandise Payment';
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
                        <td style="text-align: center; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;"><strong>Puja Merchandise Details</strong></td>
                        </tr>
                        </tbody>
                        </table>
                        </div>
                        <div class="email-token-class" style="text-align: center;">
                        <table style="height: 190px; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;" width="604">
                        <tbody>
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Member Id&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">' . $memberid . '</td>
                        </tr>
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Member Name&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">' . $MemberName . '</td>
                        </tr>
                         <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Spouse Name&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">' . $spouseName . '</td>
                        </tr> 
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Order Id&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">' . $oid . '</td>
                        </tr>
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Payment For&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $payment_for . '</td>
                        </tr>
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Quantity &nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $quantity . '</td>
                        </tr>
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Total Amount&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;"><span style="color:red;">$</span>' . $Amount . '</td>
                        </tr>
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Payment Method&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;"> Direct Deposite &nbsp;&nbsp; </td>
                        </tr>
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Pay Date&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">' . $payfinaldate . '</td>
                        </tr> 
                         <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Payment Status&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">' . $payment_status . '</td>
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


                 $mobile = $_POST['phone'] ?? '';
                if ($mobile != null) {
                    $msg = 'Houston Durga Bari: Puja Merchandise confirmation - ' .
                        'Member Id: ' . $memberid . ', ' .
                        'Member Name: ' . $MemberName . ', ' .
                         'Spouse Name: ' . $spouseName . ', ' .
                        'Order Id: ' . $oid . ', ' .
                        'Payment For: ' . $payment_for . ', ' .
                        'Quantity: ' . $quantity . ', ' .
                        'Amount: $' . $Amount . ', ' .
                        'Payment Method: Direct Deposite, ' .
                        'Pay Date: ' . $payfinaldate . ', ' .
                        'Payment Status: ' . $payment_status;

                      $this->SendSMS($mobile, $msg);
                }


                // exit();

                $_SESSION['merchandise_payment_processed'] = true;
                exit();

            }
            // sumup
            elseif (($_POST['PaymentOption'] ?? '') == 'sumup') {
                $_POST['amount'] = $_POST['sumupamount'] ?? '';
                $_POST['transaction_id'] = $_POST['sumupid'] ?? '';
                $_POST['pay_date'] = $_POST['sumupdate'] ?? '';
                $_POST['DepositAccount'] = $_POST['SumUpDepositAccount'] ?? '';
                $_POST['status'] = 'succeeded';
                $oid = $_POST['oid'] ?? '';
                $data = $_POST;

                $memberid = $_POST['member_id'] ?? '';
                $confirmdata = $MemberModel->membercheck($memberid);
                $value = array();
                    $value['type'] = $_POST['pay_type'] ?? '';
                    $value['Payment_For'] = "Puja Merchandise";
                    $value['MemberName'] = ($_POST['F_Name'] ?? '') . ' ' . ($_POST['L_Name'] ?? '');;
                    $value['Amount'] = $_POST['amount'] ?? '';
                    $value['PaymentOption'] = $_POST['PaymentOption'] ?? '';
                    $value['payment_status'] = 'confirmed';
                    $value['transaction_id'] = $_POST['transaction_id'] ?? '';
                    $value['update_on'] = $_POST['update_on'] ?? '';
                    $value['Member_id'] = $_POST['member_id'] ?? '';
                    $value['pay_date'] = $_POST['pay_date'] ?? '';
                    $value['cc_name'] = $_POST['cc_name'] ?? '';
                    $value['remarks'] = $_POST['remarks'] ?? '';
                    $value['oid'] = $_POST['oid'] ?? '';
                    $value['pay_type'] = $_POST['pay_type'] ?? '';
                    $value['pay_for'] = $_POST['pay_for'] ?? '';
                    $value['Address'] = $_POST['fullAddress'] ?? '';
                    $value['Street'] = $_POST['Street'] ?? '';
                    $value['State'] = $_POST['State'] ?? '';
                    $value['Zip_Code'] = $_POST['Zip_Code'] ?? '';
                    $value['Tele1'] = $_POST['phone'] ?? '';
                    $value['Tele2'] = $_POST['alternatenumber'] ?? '';
                    $value['email'] = $_POST['email'] ?? '';
                    $value['City'] = $_POST['City'] ?? '';
                    $value['spousename'] = ($_POST['SFirst_Name'] ?? '') . ' ' . ($_POST['SLast_Name'] ?? '');
                    $value['purpose'] = $_POST['purpose'] ?? '';
                    $value['Address3'] = $_POST['Address3'] ?? '';

                $DonationModel->SaveDataInDonation(array_merge($value , $_POST));


                if ($datamember == null) {
                    $value = array();
                    // $value['id'] = $_POST['id'] ?? '';
                    $value['type'] = $_POST['pay_type'] ?? '';

                    $value['Payment_For'] = "Puja Merchandise";
                    $value['MemberName'] = ($_POST['F_Name'] ?? '') . ' ' . ($_POST['L_Name'] ?? '');
                    $value['Amount'] = $_POST['amount'] ?? '';
                    $value['PaymentOption'] = $_POST['PaymentOption'] ?? '';
                    $value['payment_status'] = 'confirmed';
                    $value['transaction_id'] = $_POST['transaction_id'] ?? '';
                    $value['update_on'] = $_POST['update_on'] ?? '';
                    $value['Member_id'] = $_POST['member_id'] ?? '';
                    $value['pay_date'] = $_POST['pay_date'] ?? '';
                    $value['cc_name'] = $_POST['cc_name'] ?? '';
                    $value['remarks'] = $_POST['remarks'] ?? '';
                    $value['oid'] = $_POST['oid'] ?? '';
                    $value['pay_type'] = $_POST['pay_type'] ?? '';
                    $value['pay_for'] = $_POST['pay_for'] ?? '';
                    $value['Address'] = $_POST['fullAddress'] ?? '';
                    $value['Street'] = $_POST['Street'] ?? '';
                    $value['State'] = $_POST['State'] ?? '';
                    $value['Zip_Code'] = $_POST['Zip_Code'] ?? '';
                    $value['Tele1'] = $_POST['phone'] ?? '';
                    $value['Tele2'] = $_POST['alternatenumber'] ?? '';
                    $value['email'] = $_POST['email'] ?? '';
                    $value['City'] = $_POST['City'] ?? '';
                    $value['spousename'] = ($_POST['SFirst_Name'] ?? '') . ' ' . ($_POST['SLast_Name'] ?? '');
                    $value['purpose'] = $_POST['purpose'] ?? '';
                    $value['Address3'] = $_POST['Address3'] ?? '';
                    $MemberModel->SaveDataInmember($value);
                }
                $datefor = $_POST['pay_date'] ?? '';
                $timestamp = !empty($datefor) ? strtotime($datefor) : false;
                $payfinaldate = $timestamp ? date("m/d/Y", $timestamp) : '';
                       $punjabiName = "";
                        if (($_POST['punjabi_name'] ?? '') == "both") {
                            $punjabiName = " Punjabi Beige-Red and Punjabi White-Red";
                        } 

                        if (($_POST['punjabi_name'] ?? '') == "punjabi_beige_red") {
                            $punjabiName = " Punjabi Beige-Red";
                        }

                        if (($_POST['punjabi_name'] ?? '') == "punjabi_white_red") {
                            $punjabiName = " Punjabi White-Red";
                        }
                        
                        $sareeName = "";
                        if (($_POST['saree_name'] ?? '') == "both") {
                            $sareeName = " Saree Terracotta and Saree Tussar";
                        } 
                        if (($_POST['saree_name'] ?? '') == "saree_terracotta") {
                            $sareeName = " Saree Terracotta";
                        } 
                        if (($_POST['saree_name'] ?? '') == "saree_tussar") {
                            $sareeName = " Saree Tussar";
                        }
                        
                         $payment_for = [];
                        if (!empty($punjabiName)) {
                            $payment_for[] = 'Punjabi name - ' . $punjabiName;
                        }
                        if (!empty($sareeName)) {
                            $payment_for[] = 'Saree name - ' . $sareeName;
                        }
                        $payment_for = implode(' , ', $payment_for);


                        $quantity = [];
                        if (!empty($_POST['punjabi_beige_red_qty'])) {
                            $quantity[] = 'Punjabi Beige-Red - ' . ($_POST['punjabi_beige_red_qty'] ?? '');
                        }
                        if (!empty($_POST['punjabi_white_red_qty'])) {
                            $quantity[] = 'Punjabi White-Red - ' . ($_POST['punjabi_white_red_qty'] ?? '');
                        }
                        if (!empty($_POST['saree_terracotta_qty'])) {
                            $quantity[] = 'Saree Terracotta - ' . ($_POST['saree_terracotta_qty'] ?? '');
                        }
                        if (!empty($_POST['saree_tussar_qty'])) {
                            $quantity[] = 'Saree Tussar - ' . ($_POST['saree_tussar_qty'] ?? '');
                        }
                        $quantity = implode(' , ', $quantity);
                        

                $data = $_POST;
                $MemberName = ($_POST['F_Name'] ?? '') . ' ' . ($_POST['L_Name'] ?? '');
                $Amount = $_POST['amount'] ?? '';
                $transaction_id = $_POST['transaction_id'] ?? '';
                $payment_status = "success";
                $_POST['status'] = "succeeded";

                $memberid = $_POST['member_id'] ?? '';
                $datefor = $_POST['pay_date'] ?? '';
                
                $timestamp = !empty($datefor) ? strtotime($datefor) : false;
                $payfinaldate = $timestamp ? date("m/d/Y", $timestamp) : '';
                $description = $_POST['description'] ?? '';
                $spouseName = ($_POST['SFirst_Name'] ?? '') . ' ' . ($_POST['SLast_Name'] ?? '');
            
                echo "<div style='margin-left:23em;' class = 'pay'>
                       <table border='4'  width='585px' style='margin-left:4em;'>
                        <tr>
                        <td colspan='2'> <img src='../thankyouscreen.jpg' alt='' height='167px' style='margin-left:12em;'><h1 style='text-align:center;font-family:fangsong; font-size:30px;'><b>Houston Durga Bari Society</b></h1> </td>
                      
                         
                         <tr>
                        <td>Member Id</td> <td>" . $memberid . "</td></tr>
                        <tr>
                       <td>Member Name</td> <td>" . $MemberName . "</td> </tr>
                       <td>Spouse Name</td> <td>" . $spouseName . "</td> </tr>
                       <tr><td style='width:50%;'>Order Id</td><td style='width:50%;'>" . $oid . "</td></tr>
                       <tr><td>Payment For</td> <td>" . $payment_for . "</td> </tr>
                       <tr><td>Quantity</td> <td>" . $quantity . "</td> </tr>
                       <tr><td>Amount</td> <td><span style= 'color:red;'>$</span>" . $Amount . "</td> </tr>
                       <tr><td>Payment Method</td> <td>SumUp</td>  </tr>
                       
                       <tr><td>Pay Date</td> <td>" . $payfinaldate . "</td>  </tr>
                       
                       <tr><td>Payment Status</td> <td>" . $payment_status . "</td>  </tr>
                       <tr><td colspan='2'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>   </tr>
                       </tr>";

                echo "</table>";
                echo "</div>";
                echo "<div style='text-align: center; margin-top: 20px;'>
                <a href='" . INSTALL_URL . "pujaMerchandise/pujaMerchandise'>Go to home</a>
              </div>";
        
                $result = $allPurchaseData->save(array_merge($_POST));

                $Emailcc = 'pujamerchandiseorder@durgabari.org';
                $subjetc = 'Puja Merchandise Payment';
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
                        <td style="text-align: center; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;"><strong>Puja Merchandise Details</strong></td>
                        </tr>
                        </tbody>
                        </table>
                        </div>
                        <div class="email-token-class" style="text-align: center;">
                        <table style="height: 190px; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;" width="604">
                        <tbody>
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Member Id&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">' . $memberid . '</td>
                        </tr>
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Member Name&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">' . $MemberName . '</td>
                        </tr> 
                         <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Spouse Name&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">' . $spouseName . '</td>
                        </tr> 
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Order Id&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">' . $oid . '</td>
                        </tr>
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Payment For&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $payment_for . '</td>
                        </tr>
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Quantity &nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $quantity . '</td>
                        </tr>
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Total Amount&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;"><span style="color:red;">$</span>' . $Amount . '</td>
                        </tr>

                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Payment Method&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;"> SumUp &nbsp;&nbsp; </td>
                        </tr>

                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Pay Date&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">' . $payfinaldate . '</td>
                        </tr> 

                         <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Payment Status&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">' . $payment_status . '</td>
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
                $mobileno = $_POST['phone'] ?? '';
                if ($mobileno != null) {
                    $msg = 'Houston Durga Bari: Puja Merchandise confirmation - ' .
                        'Member Id: ' . $memberid . ', ' .
                        'Member Name: ' . $MemberName . ', ' .
                         'Spouse Name: ' . $spouseName . ', ' .
                        'Order Id: ' . $oid . ', ' .
                        'Payment For: ' . $payment_for . ', ' .
                        'Quantity: ' . $quantity . ', ' .
                        'Amount: $' . $Amount . ', ' .
                        'Payment Method: SumUp, ' .
                       
                        'Pay Date: ' . $payfinaldate . ', ' .
                        'Payment Status: ' . $payment_status;

                        $this->SendSMS($mobileno, $msg);
                }


                // exit();

                $_SESSION['merchandise_payment_processed'] = true;
                exit();
            } 
            
              elseif (($_POST['PaymentOption'] ?? '') == 'zelleProxy') {
                $_POST['amount'] = $_POST['proxyamount'] ?? '';
                $_POST['transaction_id'] = $_POST['zelleProxyTid'] ?? '';
                $_POST['pay_date'] = $_POST['proxydate'] ?? '';
                $_POST['DepositAccount'] = $_POST['zelleProxyDepositAccount'] ?? '';
                $_POST['status'] = 'succeeded';
                $oid = $_POST['oid'] ?? '';
                $data = $_POST;
                $memberid = $_POST['member_id'] ?? '';
                $confirmdata = $MemberModel->membercheck($memberid);
                $value = array();
                $value['type'] = $_POST['pay_type'] ?? '';
                $value['Payment_For'] = "Puja Merchandise";
                $value['MemberName'] = ($_POST['F_Name'] ?? '') . ' ' . ($_POST['L_Name'] ?? '');
                ;
                $value['Amount'] = $_POST['amount'] ?? '';
                $value['PaymentOption'] = $_POST['PaymentOption'] ?? '';
                $value['payment_status'] = 'confirmed';
                $value['transaction_id'] = $_POST['transaction_id'] ?? '';
                $value['update_on'] = $_POST['update_on'] ?? '';
                $value['Member_id'] = $_POST['member_id'] ?? '';
                $value['pay_date'] = $_POST['pay_date'] ?? '';
                $value['cc_name'] = $_POST['cc_name'] ?? '';
                $value['remarks'] = $_POST['remarks'] ?? '';
                $value['oid'] = $_POST['oid'] ?? '';
                $value['pay_type'] = $_POST['pay_type'] ?? '';
                $value['pay_for'] = $_POST['pay_for'] ?? '';
                $value['Address'] = $_POST['fullAddress'] ?? '';
                $value['Street'] = $_POST['Street'] ?? '';
                $value['State'] = $_POST['State'] ?? '';
                $value['Zip_Code'] = $_POST['Zip_Code'] ?? '';
                $value['Tele1'] = $_POST['phone'] ?? '';
                $value['Tele2'] = $_POST['alternatenumber'] ?? '';
                $value['email'] = $_POST['email'] ?? '';
                $value['City'] = $_POST['City'] ?? '';
                $value['spousename'] = ($_POST['SFirst_Name'] ?? '') . ' ' . ($_POST['SLast_Name'] ?? '');
                $value['purpose'] = $_POST['purpose'] ?? '';
                $value['Address3'] = $_POST['Address3'] ?? '';
                $DonationModel->SaveDataInDonation(array_merge($value, $_POST));
                if ($datamember == null) {
                    $value = array();
                    $value['type'] = $_POST['pay_type'] ?? '';
                    $value['Payment_For'] = "Puja Merchandise";
                    $value['MemberName'] = ($_POST['F_Name'] ?? '') . ' ' . ($_POST['L_Name'] ?? '');
                    $value['Amount'] = $_POST['amount'] ?? '';
                    $value['PaymentOption'] = $_POST['PaymentOption'] ?? '';
                    $value['payment_status'] = 'confirmed';
                    $value['transaction_id'] = $_POST['transaction_id'] ?? '';
                    $value['update_on'] = $_POST['update_on'] ?? '';
                    $value['Member_id'] = $_POST['member_id'] ?? '';
                    $value['pay_date'] = $_POST['pay_date'] ?? '';
                    $value['cc_name'] = $_POST['cc_name'] ?? '';
                    $value['remarks'] = $_POST['remarks'] ?? '';
                    $value['oid'] = $_POST['oid'] ?? '';
                    $value['pay_type'] = $_POST['pay_type'] ?? '';
                    $value['pay_for'] = $_POST['pay_for'] ?? '';
                    $value['Address'] = $_POST['fullAddress'] ?? '';
                    $value['Street'] = $_POST['Street'] ?? '';
                    $value['State'] = $_POST['State'] ?? '';
                    $value['Zip_Code'] = $_POST['Zip_Code'] ?? '';
                    $value['Tele1'] = $_POST['phone'] ?? '';
                    $value['Tele2'] = $_POST['alternatenumber'] ?? '';
                    $value['email'] = $_POST['email'] ?? '';
                    $value['City'] = $_POST['City'] ?? '';
                    $value['spousename'] = ($_POST['SFirst_Name'] ?? '') . ' ' . ($_POST['SLast_Name'] ?? '');
                    ;
                    $value['purpose'] = $_POST['purpose'] ?? '';
                    $value['Address3'] = $_POST['Address3'] ?? '';
                    $MemberModel->SaveDataInmember($value);
                }
                $datefor = $_POST['pay_date'] ?? '';
                $timestamp = !empty($datefor) ? strtotime($datefor) : false;
                $payfinaldate = $timestamp ? date("m/d/Y", $timestamp) : '';
                $punjabiName = "";
                if (($_POST['punjabi_name'] ?? '') == "both") {
                    $punjabiName = " Punjabi Beige-Red and Punjabi White-Red";
                }
                if (($_POST['punjabi_name'] ?? '') == "punjabi_beige_red") {
                    $punjabiName = " Punjabi Beige-Red";
                }
                if (($_POST['punjabi_name'] ?? '') == "punjabi_white_red") {
                    $punjabiName = " Punjabi White-Red";
                }
                $sareeName = "";
                if (($_POST['saree_name'] ?? '') == "both") {
                    $sareeName = " Saree Terracotta and Saree Tussar";
                }
                if (($_POST['saree_name'] ?? '') == "saree_terracotta") {
                    $sareeName = " Saree Terracotta";
                }
                if (($_POST['saree_name'] ?? '') == "saree_tussar") {
                    $sareeName = " Saree Tussar";
                }
                $payment_for = [];
                if (!empty($punjabiName)) {
                    $payment_for[] = 'Punjabi name - ' . $punjabiName;
                }
                if (!empty($sareeName)) {
                    $payment_for[] = 'Saree name - ' . $sareeName;
                }
                $payment_for = implode(' , ', $payment_for);
                $quantity = [];
                if (!empty($_POST['punjabi_beige_red_qty'])) {
                    $quantity[] = 'Punjabi Beige-Red - ' . ($_POST['punjabi_beige_red_qty'] ?? '');
                }
                if (!empty($_POST['punjabi_white_red_qty'])) {
                    $quantity[] = 'Punjabi White-Red - ' . ($_POST['punjabi_white_red_qty'] ?? '');
                }
                if (!empty($_POST['saree_terracotta_qty'])) {
                    $quantity[] = 'Saree Terracotta - ' . ($_POST['saree_terracotta_qty'] ?? '');
                }
                if (!empty($_POST['saree_tussar_qty'])) {
                    $quantity[] = 'Saree Tussar - ' . ($_POST['saree_tussar_qty'] ?? '');
                }
                $quantity = implode(' , ', $quantity);
                
                $data = $_POST;
                $MemberName = ($_POST['F_Name'] ?? '') . ' ' . ($_POST['L_Name'] ?? '');
                $Amount = $_POST['amount'] ?? '';
                $transaction_id = $_POST['transaction_id'] ?? '';
                $payment_status = "success";
                $_POST['status'] = "succeeded";
                $memberid = $_POST['member_id'] ?? '';
                $datefor = $_POST['pay_date'] ?? '';
                $timestamp = !empty($datefor) ? strtotime($datefor) : false;
                $payfinaldate = $timestamp ? date("m/d/Y", $timestamp) : '';
                $description = $_POST['description'] ?? '';
                $spouseName = ($_POST['SFirst_Name'] ?? '') . ' ' . ($_POST['SLast_Name'] ?? '');
                
        
                echo "<div style='margin-left:23em;' class = 'pay'>
                       <table border='4'  width='585px' style='margin-left:4em;'>
                        <tr>
                        <td colspan='2'> <img src='../thankyouscreen.jpg' alt='' height='167px' style='margin-left:12em;'><h1 style='text-align:center;font-family:fangsong; font-size:30px;'><b>Houston Durga Bari Society</b></h1> </td>
                      
                         
                         <tr>
                        <td>Member Id</td> <td>" . $memberid . "</td></tr>
                        <tr>
                       <td>Member Name</td> <td>" . $MemberName . "</td> </tr>
                       <td>Spouse Name</td> <td>" . $spouseName . "</td> </tr>
                       <tr><td style='width:50%;'>Order Id</td><td style='width:50%;'>" . $oid . "</td></tr>
                       <tr><td>Payment For</td> <td>" . $payment_for . "</td> </tr>
                       <tr><td>Quantity</td> <td>" . $quantity . "</td> </tr>
                       <tr><td>Amount</td> <td><span style= 'color:red;'>$</span>" . $Amount . "</td> </tr>
                       <tr><td>Payment Method</td> <td>Zelle Proxy</td>  </tr>
                       
                       <tr><td>Pay Date</td> <td>" . $payfinaldate . "</td>  </tr>
                       
                       <tr><td>Payment Status</td> <td>" . $payment_status . "</td>  </tr>
                       <tr><td colspan='2'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>   </tr>
                       </tr>";
                echo "</table>";
                echo "</div>";
                echo "<div style='text-align: center; margin-top: 20px;'>
                <a href='" . INSTALL_URL . "pujaMerchandise/pujaMerchandise'>Go to home</a>
              </div>";
              
              
                $result = $allPurchaseData->save(array_merge($_POST));
                $Emailcc = 'pujamerchandiseorder@durgabari.org';
                $subjetc = 'Puja Merchandise Payment';
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
                        <td style="text-align: center; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;"><strong>Puja Merchandise Details</strong></td>
                        </tr>
                        </tbody>
                        </table>
                        </div>
                        <div class="email-token-class" style="text-align: center;">
                        <table style="height: 190px; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;" width="604">
                        <tbody>
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Member Id&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">' . $memberid . '</td>
                        </tr>
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Member Name&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">' . $MemberName . '</td>
                        </tr> 
                         <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Spouse Name&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">' . $spouseName . '</td>
                        </tr> 
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Order Id&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">' . $oid . '</td>
                        </tr>
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Payment For&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $payment_for . '</td>
                        </tr>
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Quantity &nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $quantity . '</td>
                        </tr>
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Total Amount&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;"><span style="color:red;">$</span>' . $Amount . '</td>
                        </tr>

                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Payment Method&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;"> Zelle Proxy &nbsp;&nbsp; </td>
                        </tr>

                      

                       
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Pay Date&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">' . $payfinaldate . '</td>
                        </tr> 

                         <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Payment Status&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">' . $payment_status . '</td>
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
                $mobileno = $_POST['phone'] ?? '';
                if ($mobileno != null) {
                    $msg = 'Houston Durga Bari: Puja Merchandise confirmation - ' .
                        'Member Id: ' . $memberid . ', ' .
                        'Member Name: ' . $MemberName . ', ' .
                         'Spouse Name: ' . $spouseName . ', ' .
                        'Order Id: ' . $oid . ', ' .
                        'Payment For: ' . $payment_for . ', ' .
                        'Quantity: ' . $quantity . ', ' .
                        'Amount: $' . $Amount . ', ' .
                        'Payment Method: Zelle Proxy, ' .
                       
                        'Pay Date: ' . $payfinaldate . ', ' .
                        'Payment Status: ' . $payment_status;
                          $this->SendSMS($mobileno, $msg);
                        
                }
                $_SESSION['merchandise_payment_processed'] = true;
                exit();
            } 
            
            
            elseif (($_POST['PaymentOption'] ?? '') == 'stripe') {

                //$amount = $_POST['Amount'] ?? '';
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
                            "currency" => "USD",
                            "card" => $_POST['stripeToken'] ?? '',
                            "description" => "Pay For:" . ($_POST['pay_type'] ?? '') . ', ' . "Email:" . ($_POST['email'] ?? '') . ', ' . "Full Name:" . ($_POST['F_Name'] ?? '') . ' ' . ($_POST['L_Name'] ?? ''),
                            "metadata" => ["orderid" => $oid]
                        )
                    );

                    $this->tpl['payment']['balance_transaction'] = $payment->balance_transaction;
                    $this->tpl['payment']['amount'] = $payment->amount;
                    $this->tpl['payment']['status'] = $payment->status;
                    $this->tpl['payment']['currency'] = $payment->currency;

                    if ($payment->status == 'succeeded') {

                        $opts = array();
                        $opts['id'] = $_POST['oid'] ?? '';
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
                        $_POST['member_id'] = $datamemberarr['member_id'];
                        $punjabiName = "";
                        if (($_POST['punjabi_name'] ?? '') == "both") {
                            $punjabiName = " Punjabi Beige-Red and Punjabi White-Red";
                        } 

                        if (($_POST['punjabi_name'] ?? '') == "punjabi_beige_red") {
                            $punjabiName = " Punjabi Beige-Red";
                        }

                        if (($_POST['punjabi_name'] ?? '') == "punjabi_white_red") {
                            $punjabiName = " Punjabi White-Red";
                        }
                        $sareeName = "";

                        if (($_POST['saree_name'] ?? '') == "both") {
                            $sareeName = " Saree Terracotta and Saree Tussar";
                        } 

                        if (($_POST['saree_name'] ?? '') == "saree_terracotta") {
                            $sareeName = " Saree Terracotta";
                        } 
                        if (($_POST['saree_name'] ?? '') == "saree_tussar") {
                            $sareeName = " Saree Tussar";
                        } 
                        
                        $payment_for = [];
                        if (!empty($punjabiName)) {
                            $payment_for[] = 'Punjabi name - ' . $punjabiName;
                        }
                        if (!empty($sareeName)) {
                            $payment_for[] = 'Saree name - ' . $sareeName;
                        }
                        $payment_for = implode(' , ', $payment_for);

                        $quantity = [];
                        if (!empty($_POST['punjabi_beige_red_qty'])) {
                            $quantity[] = 'Punjabi Beige-Red - ' . ($_POST['punjabi_beige_red_qty'] ?? '');
                        }
                        if (!empty($_POST['punjabi_white_red_qty'])) {
                            $quantity[] = 'Punjabi White-Red - ' . ($_POST['punjabi_white_red_qty'] ?? '');
                        }
                        if (!empty($_POST['saree_terracotta_qty'])) {
                            $quantity[] = 'Saree Terracotta - ' . ($_POST['saree_terracotta_qty'] ?? '');
                        }
                        if (!empty($_POST['saree_tussar_qty'])) {
                            $quantity[] = 'Saree Tussar - ' . ($_POST['saree_tussar_qty'] ?? '');
                        }
                        $quantity = implode(' , ', $quantity);

                        $data = $_POST;
                        $MemberName = ($_POST['F_Name'] ?? '') . ' ' . ($_POST['L_Name'] ?? '');
                        $Amount = $_POST['amount'] ?? '';
                        $transaction_id = $opts['transaction_id'];
                        $payment_status = $opts['payment_status'];
                        $memberid = $_POST['member_id'] ?? '';
                        $datefor = $_POST['pay_date'] ?? '';
                       
                        $timestamp = !empty($datefor) ? strtotime($datefor) : false;
                        $payfinaldate = $timestamp ? date("m/d/Y", $timestamp) : '';
                        $description = $_POST['description'] ?? '';
                        $spouseName = ($_POST['SFirst_Name'] ?? '') . ' ' . ($_POST['SLast_Name'] ?? '');
                        

                        echo "<div style='margin-left:23em;' class = 'pay'>
                        <table border='4'  width='585px' style='margin-left:4em;'>
                         <tr>
                         <td colspan='2'> <img src='../thankyouscreen.jpg' alt='' height='167px' style='margin-left:12em;'><h1 style='text-align:center;font-family:fangsong; font-size:30px;'><b>Houston Durga Bari Society</b></h1> </td>
                       
                          <tr><td style='width:50%;'>Order Id</td><td style='width:50%;'>" . $oid . "</td></tr>
                          <tr>
                         <td>Member Id</td> <td>" . $memberid . "</td></tr>
                         <tr>
                        <td>Member Name</td> <td>" . $MemberName . "</td> </tr>
                        <td>Spouse Name</td> <td>" . $spouseName . "</td> </tr>
                        <tr><td>Payment For</td> <td>" . $payment_for . "</td> </tr>
                        <tr><td>Quantity</td> <td>" . $quantity . "</td> </tr>
                        <tr><td>Amount</td> <td><span style= 'color:red;'>$</span>" . $Amount . "</td> </tr>
                        <tr><td>Payment Method</td> <td>Credit Card</td>  </tr>
                        <tr><td>Transaction Id</td> <td>" . $transaction_id . "</td> </tr>
                        <tr><td>Pay Date</td> <td>" . $payfinaldate . "</td>  </tr>
                        
                        <tr><td>Payment Status</td> <td>" . $payment_status . "</td>  </tr>
                        <tr><td colspan='2'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>   </tr>
                        </tr>";

                        echo "</table>";
                        echo "</div>";
                        echo "<div style='text-align: center; margin-top: 20px;'>
                        <a href='" . INSTALL_URL . "pujaMerchandise/pujaMerchandise'>Go to home</a>
                      </div>";
                        // Save data and send email — wrapped so exceptions never redirect away from the receipt
                        try {
                        $value = array();
                        $value['oid'] = $oid;
                        $value['Member_id'] = $datamemberarr['member_id'];
                        $value['MemberName'] = $datamemberarr['F_Name'] . ' ' . $datamemberarr['L_Name'];
                        $value['PaymentOption'] = $datamemberarr['PaymentOption'];
                        $value['payment_status'] = 'succeeded';
                        $value['payment_timestamp'] = $datamemberarr['payment_timestamp'] ?? '';
                        $value['stripe_return'] = $datamemberarr['stripe_return'] ?? '';
                        $value['transaction_id'] = $datamemberarr['transaction_id'];
                        $value['paid_amount'] = $datamemberarr['paid_amount'] ?? '';
                        $value['Amount'] = $datamemberarr['amount'];
                        if (!empty($datamemberarr['UpdateOn'] ?? '')) {
                            $value['update_on'] = $datamemberarr['UpdateOn'];
                        }
                        $value['stripe_product'] = $datamemberarr['stripe_product'] ?? '';
                        $value['pay_date'] = $datamemberarr['pay_date'];
                        $value['pay_type'] = $datamemberarr['pay_type'];
                        $value['pay_for'] = $datamemberarr['pay_for'];
                        $value['Tele1'] = $datamemberarr['phone'];
                        $value['email'] = $datamemberarr['email'];
                        $value['spousename'] = $datamemberarr['SFirst_Name'] . ' ' . $datamemberarr['SLast_Name'];
                        $value['Address'] = $datamemberarr['streetname'] ?? '';
                        $value['Street'] = $datamemberarr['street'] ?? '';
                        $value['City'] = $datamemberarr['City'];
                        $value['State'] = $datamemberarr['State'];
                        $value['Zip_Code'] = $datamemberarr['Zip'];
                        $value['type'] = "Puja Merchandise Saree/Punjabi";
                        // $admin_id = $value['admin_id'];
                        // $admin_name = $value['admin_name'];

                        $value['admin_id'] = isset($_POST['admin_id']) && is_numeric($_POST['admin_id']) ? (int)$_POST['admin_id'] : null;
                        $value['admin_name']= $_POST['admin_name'] ?? '';
                       



                        
                        $DonationModel->SaveDataInDonation(array_merge($value , $_POST));

                        //  $result = $allPurchaseData->save(array_merge($opts, $_POST));
                        $result = $allPurchaseData->save(array_merge($value , $_POST));

                        if ($datamember == null) {
                            $value = array();
                            $value['Payment_For'] = $_POST['pay_for'] ?? '';
                            $value['MemberName'] = ($_POST['F_Name'] ?? '') . ' ' . ($_POST['L_Name'] ?? '');
                            $value['Amount'] = $_POST['amount'] ?? '';
                            $value['PaymentOption'] = $_POST['PaymentOption'] ?? '';
                            $value['payment_status'] = 'confirmed';
                            $value['payment_timestamp'] = $opts['payment_timestamp'] ?? '';
                            $value['stripe_return'] = $opts['stripe_return'] ?? '';
                            $value['transaction_id'] = $opts['transaction_id'];
                            $value['paid_amount'] = $opts['paid_amount'] ?? '';
                            $value['stripe_product'] = $opts['stripe_product'] ?? '';
                            $value['update_on'] = $_POST['update_on'] ?? '';
                            $value['Member_id'] = $_POST['member_id'] ?? '';
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
                            $value['spousename'] = ($_POST['SFirst_Name'] ?? '') . ' ' . ($_POST['SLast_Name'] ?? '');
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

                        $Emailcc = 'pujamerchandiseorder@durgabari.org';
                        $subjetc = 'Puja Merchandise Payment';
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
                        <td style="text-align: center; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;"><strong>Puja Merchandise Details</strong></td>
                        </tr>
                        </tbody>
                        </table>
                        </div>
                        <div class="email-token-class" style="text-align: center;">
                        <table style="height: 190px; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;" width="604">
                        <tbody>
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Member Id&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">' . $memberid . '</td>
                        </tr>
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Member Name&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">' . $MemberName . '</td>
                        </tr> 
                        
                         <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Spouse Name&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">' . $spouseName . '</td>
                        </tr> 
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Order Id&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">' . $oid . '</td>
                        </tr>
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Payment For&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $payment_for . '</td>
                        </tr>
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Quantity &nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $quantity . '</td>
                        </tr>
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Total Amount&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;"><span style="color:red;">$</span>' . $Amount . '</td>
                        </tr>
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Payment Method&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;"> Credit Card &nbsp;&nbsp; </td>
                        </tr>
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Transaction Id&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">' . $transaction_id . '</td>
                        </tr>
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Pay Date&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">' . $payfinaldate . '</td>
                        </tr> 
                         <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Payment Status&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">' . $payment_status . '</td>
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
                        $mobile = $_POST['phone'] ?? '';

                        if ($mobile != null) {
                            $msg = 'Houston Durga Bari: Puja Merchandise confirmation - ' .
                                'Member Id: ' . $memberid . ', ' .
                                'Member Name: ' . $MemberName . ', ' .
                                 'Spouse Name: ' . $spouseName . ', ' .
                                'Order Id: ' . $oid . ', ' .
                                'Payment For: ' . $payment_for . ', ' .
                                'Quantity: ' . $quantity . ', ' .
                                'Amount: $' . $Amount . ', ' .
                                'Payment Method: Credit Card, ' .
                                'Transaction Id: ' . $transaction_id . ', ' .
                                'Pay Date: ' . $payfinaldate . ', ' .
                                'Payment Status: ' . $payment_status;
                             $this->SendSMS($mobile, $msg);
                        }
                        // $this->tpl['arr'] = $pujaregistrationModel->get($id);
                        $_SESSION['merchandise_payment_processed'] = true;
                        } catch (\Exception $saveEx) {
                            error_log('[pujaMerchandise] Post-payment save/email error: ' . $saveEx->getMessage());
                        }
                        exit();
                    } else {

                        $opts = array();
                        $opts['id'] = $id;
                        $opts['stripe_return'] = $payment->status;
                        $opts['transaction_id'] = $payment->id;
                        $opts['paid_amount'] = $payment->amount;
                        $opts['stripe_product'] = $payment->description;

                        $_SESSION['status'] = '<strong>' . __('declined_card') . '</strong>';
                    }
                } catch (Exception $ex) {
                    $_SESSION['status'] = $ex->getMessage();

                    if (!$this->isAdmin()) {
                        Util::redirect(INSTALL_URL . "Admin/dashboard");
                    } else {
                        Util::redirect(INSTALL_URL . "pujaMerchandise/priceLimitDate");
                    }
                }

            } else {
                // $_SESSION['status'] = 16;

            }
         }
    
        
    }


    function index()
    {
        GzObject::loadFiles('Model', array('totalPurchasedItem'));
        $allPurchaseData = new totalPurchasedItemModel();
        if (!$this->isLoged() && ($_REQUEST['action'] ?? '') != 'login') {

            if (($_REQUEST['action'] ?? '') != 'edit') {
                $_SESSION['err'] = 2;
                Util::redirect(INSTALL_URL . "Admin/login");
            }
        }
        $allPurchase = $allPurchaseData->getdata();
        $this->tpl['allPurchaseData'] = $allPurchase;
    }


    function priceLimitDate()
    {
        GzObject::loadFiles('Model', array('merchandisePriceLimit', 'merchandiseDeadline', ));
        $getAllMerchandiseData = new merchandisePriceLimitModel();
        $merchandiseDeadline = new merchandiseDeadlineModel();
      
        $allData = $getAllMerchandiseData->getAllData();
        $deadline = $merchandiseDeadline->getDeadLine();
        $this->tpl['deadline'] = $deadline[0];

        $this->tpl['merchandiseAllData'] = $allData;
        // $this->tpl['purchaseLimit'] = $purchaselimitData;

        if (!$this->isLoged() && ($_REQUEST['action'] ?? '') != 'login') {

            if (($_REQUEST['action'] ?? '') != 'edit') {
                $_SESSION['err'] = 2;
                Util::redirect(INSTALL_URL . "Admin/login");
            }
        }
    }

    function editPriceLimit()
    {
        GzObject::loadFiles('Model', array('merchandisePriceLimit', 'User'));
        $merchandiseModel = new merchandisePriceLimitModel();
        $UserModel = new UserModel();

        if (!$this->isLoged() && ($_REQUEST['action'] ?? '') != 'login') {

            if (($_REQUEST['action'] ?? '') != 'edit') {
                $_SESSION['err'] = 2;
                Util::redirect(INSTALL_URL . "Admin/login");
            }
        }
        $id = $_GET['id'] ?? '';
        $clothdata = $merchandiseModel->getBasedOnId($id);
        $this->tpl['clothdata'] = $clothdata;

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Retrieve submitted data

            if ($this->isAdmin() || $this->isEditor()) {
                $id = $this->getUserId();
                $admin = $UserModel->get($id);
                $rolename = $admin['first'] . ' ' . $admin['last'];
                $_POST['admin_id'] = $admin['id'];
                $_POST['admin_name'] = $rolename;
            }

            $cloth_images = isset($_FILES['cloth_images']) ? $_FILES['cloth_images'] : [];

            $upload_dir = 'images/clothes/';

            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true); // This creates the folder if it doesn't exist
            }
            $uploaded_image_paths = [];

            if (!empty($cloth_images['name'][0])) {

                foreach ($cloth_images['name'] as $index => $image_name) {

                    $tmp_name = $cloth_images['tmp_name'][$index];

                    $cloth_name = $_POST['cloth_name'] ?? '';


                    $image_name = basename($cloth_images['name'][$index]);
                    $image_extension = pathinfo($image_name, PATHINFO_EXTENSION);


                    $target_file = $upload_dir . $cloth_name . '-' . uniqid() . '.' . $image_extension;


                    $image_file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));


                    $valid_types = ['jpg', 'jpeg', 'png', 'gif'];
                    if (!in_array($image_file_type, $valid_types)) {

                        continue;
                    }


                    if ($cloth_images['size'][$index] > 5000000) {

                        continue;
                    }

                    if (move_uploaded_file($tmp_name, $target_file)) {


                        $_POST['image_path'] = $target_file;


                    } else {

                        if (!$this->isAdmin()) {
                            Util::redirect(INSTALL_URL . "Admin/dashboard");
                        } else {
                            Util::redirect(INSTALL_URL . "pujaMerchandise/priceLimitDate");
                        }
                    }

                }
            }

            $result = $merchandiseModel->update($_POST);


            if (!empty($result)) {
                $_SESSION['status'] = 20;
            } else {
                $_SESSION['status'] = 21;
            }

            if (!$this->isAdmin()) {
                Util::redirect(INSTALL_URL . "Admin/dashboard");
            } else {
                Util::redirect(INSTALL_URL . "pujaMerchandise/priceLimitDate");
            }
        }

    }

    function deleteItem()
    {
        GzObject::loadFiles('Model', array('merchandisePriceLimit', 'User'));
        $merchandiseModel = new merchandisePriceLimitModel();
        $UserModel = new UserModel();

        if (!$this->isLoged() && ($_REQUEST['action'] ?? '') != 'login') {

            if (($_REQUEST['action'] ?? '') != 'edit') {
                $_SESSION['err'] = 2;
                Util::redirect(INSTALL_URL . "Admin/login");
            }
        }
        $id = $_GET['id'] ?? '';
        $clothdata = $merchandiseModel->getBasedOnId($id);
        $this->tpl['clothdata'] = $clothdata;

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            if (isset($_POST['delete'])) {

                $result = $merchandiseModel->deletBasedOnId($id);

                if (!empty($result)) {
                    $_SESSION['status'] = 20;
                } else {
                    $_SESSION['status'] = 21;
                }

                if (!$this->isAdmin()) {
                    Util::redirect(INSTALL_URL . "Admin/dashboard");
                } else {
                    Util::redirect(INSTALL_URL . "pujaMerchandise/priceLimitDate");
                }

            }
        }

    }

    function editDeadline()
    {
        GzObject::loadFiles('Model', array('merchandiseDeadline', 'User'));
        $merchandiseDeadline = new merchandiseDeadlineModel();
        $UserModel = new UserModel();

        if (!$this->isLoged() && ($_REQUEST['action'] ?? '') != 'login') {

            if (($_REQUEST['action'] ?? '') != 'edit') {
                $_SESSION['err'] = 2;
                Util::redirect(INSTALL_URL . "Admin/login");
            }
        }


        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            if ($this->isAdmin() || $this->isEditor()) {
                $id = $this->getUserId();
                $admin = $UserModel->get($id);
                $rolename = $admin['first'] . ' ' . $admin['last'];
                $_POST['admin_id'] = $admin['id'];
                $_POST['admin_name'] = $rolename;
            }

            $result = $merchandiseDeadline->update($_POST);
            //  $result = $merchandiseDeadline->updatewithoutKey($_POST);

            if (!empty($result)) {
                $_SESSION['status'] = 20;
            } else {
                $_SESSION['status'] = 21;
            }

            if (!$this->isAdmin()) {
                Util::redirect(INSTALL_URL . "Admin/dashboard");
            } else {
                Util::redirect(INSTALL_URL . "pujaMerchandise/priceLimitDate");
            }
        }
    }

    public function export()
    {
        GzObject::loadFiles('Model', array('totalPurchasedItem'));
        $allPurchaseData = new totalPurchasedItemModel();

        if (!$this->isLoged() && ($_REQUEST['action'] ?? '') != 'login') {

            if (($_REQUEST['action'] ?? '') != 'edit') {
                $_SESSION['err'] = 2;
                Util::redirect(INSTALL_URL . "Admin/login");
            }
        }

        $opts = array();
        $data = $allPurchaseData->getdata();
        date_default_timezone_set("America/Chicago");
        $filename = "saree /kurta puchase data" . date("m-d-Y") . ".csv";

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
}
?>
