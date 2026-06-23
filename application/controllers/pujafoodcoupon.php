<?php

require_once CONTROLLERS_PATH . 'App.php';

class pujafoodcoupon extends App
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

            if (($_REQUEST['action'] ?? '') != 'useredit' && ($_REQUEST['action'] ?? '') != 'pujafoodcoupon') {
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
        $this->js[] = array('file' => 'gzadmin/plugins/daterangepicker/daterangepicker.js', 'path' => JS_PATH);
        
        //for stripe payment
        $this->js[] = array('file' => '', 'path' => 'https://js.stripe.com/v3/', 'remote' => 1);
        
        $this->js[] = array('file' => 'admin.js?v=' . time(), 'path' => JS_PATH);

        $this->js[] = array('file' => 'Gzfoodcoupon.js?v=' . time(), 'path' => JS_PATH);

        $this->js[] = array('file' => 'loadingoverlay.js?v=' . time(), 'path' => JS_PATH);

    }

    


    function getfoodcouponpriceedata()
    {
      GzObject::loadFiles('Model', array('foodcouponprice'));
      $foodcouponpriceModel = new foodcouponpriceModel();

      $paymentfor = $_POST['paymentfor'] ?? '';
      $arr = $foodcouponpriceModel->getfoodcouponpriceedata($paymentfor);
      
    }
    
      function pujafoodcoupon() {
    $this->layout = 'login';
  }

  function __construct()
    {
       //$this->js[] = array('file' => 'jquery/jquery-1.8.2.min.js', 'path' => LIBS_PATH);
        GzObject::loadFiles('Model', array('pujafoodcoupon', 'foodcouponprice','ConfirmCode','Member','Donation' ,'idnumbers'  , 'FoodCouponSessionName'));
        $pujafoodcouponModel =  new pujafoodcouponModel();
        $ConfirmCodeModel =  new ConfirmCodeModel();
        $MemberModel = new MemberModel();
        $idnumbersModel = new idnumbersModel();
        $DonationModel = new DonationModel();
        $ConfirmCodeModel = new ConfirmCodeModel();
        $foodcouponpriceModel = new foodcouponpriceModel();
        $FoodCouponSessionName = new FoodCouponSessionName();
        $opts = array();
      
        $foodcouponpricearr = $foodcouponpriceModel->getall($opts);
        $this->tpl['foodcouponpricearr'] = $foodcouponpricearr;
        
        $arr = $FoodCouponSessionName->getFoodCouponSession($opts);
        $this->tpl['foodcoupon'] = $arr;
        
        
        
        
         if (!empty($_POST['freeDiamondBtn']) == "Savefree") {

            date_default_timezone_set("America/Chicago");
            $today = date("Y/m/d");
            $_POST['paydate'] = $today;
            $_POST['CreatedAt'] = $today;
            $_POST['pay_type'] = 'Free Diamond Inaugration Coupon';
            $_POST['pay_for'] = "Inaugration Event Dinner Coupon";

            $_POST['couponfor'] = "Dinner" ;
            $_POST['coupontype'] = "Free Diamond Inaugration Coupon " ;

            $maxoid = $idnumbersModel->getMaxoid() + 1;
            $update_oid = $idnumbersModel->Updateoid($maxoid);
            $_POST['oid'] = $maxoid;


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
            $categorymember = $_POST['membercategory'] ?? '';
            $id = $pujafoodcouponModel->save(array_merge($_POST));






            $_POST['amount'] = "";

            $_POST['Status'] = 'confirmed';
            $_POST['payment_status'] = 'confirmed';
            $_POST['id'] = $id;
            $datamemberarr = array();
            $datamemberarr = array_merge($_POST);
            $pujafoodcouponModel->update(array_merge($_POST));



            if ($datamember == null) {
                $value = array();
                $value['MemberName'] = ($_POST['F_Name'] ?? '') . ' ' . ($_POST['L_Name'] ?? '');

                $value['Member_id'] = $_POST['member_id'] ?? '';
                $value['pay_date'] = $_POST['paydate'] ?? '';
                $value['oid'] = $_POST['oid'] ?? '';
                $value['pay_type'] = 'Free Diamond Inaugration Coupon';
                $value['pay_for'] = "Inaugration Event Dinner Coupon";
                $value['City'] = $_POST['City'] ?? '';
                $value['State'] = $_POST['State'] ?? '';
                $value['Zip_Code'] = $_POST['Zip'] ?? '';
                $value['email'] = $_POST['email'] ?? '';
                $value['Tele1'] = $_POST['phone'] ?? '';
                $MemberModel->SaveDataInmember($value);
                $this->tpl['arr'] = $pujafoodcouponModel->get($id);

            }

            $datefor = $_POST['paydate'] ?? '';
            $timestamp = !empty($datefor) ? strtotime($datefor) : false;
            $payfinaldate = $timestamp ? date("m/d/Y", $timestamp) : '';
            $subjetc = 'HDBS Food Coupon Payment';
            $fullname = ($_POST['F_Name'] ?? '') . ' ' . ($_POST['L_Name'] ?? '');
            $memberid = $_POST['member_id'] ?? '';
            $oid = $_POST['oid'] ?? '';
            $couponfor = $_POST['couponfor'] ?? '';
            $coupontype = $_POST['coupontype'] ?? '';
            $pyamentmethod = "Free Coupon";
            $pyamentstatus = "Confirmed";
            $amount = "";
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
                <td style="text-align: center; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;"><strong>Food Coupon</strong></td>
                </tr>
                </tbody>
                </table>
                </div>
                <div class="email-token-class" style="text-align: center;">
                <table style="height: 190px; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;" width="604">
                <tbody>
                <tr>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Order Id&nbsp;&nbsp;</td>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">' . $oid . '</td>
                </tr>
                <tr>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Member Id&nbsp;&nbsp;</td>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $memberid . '</td>
                </tr>
                <tr>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Full Name&nbsp;&nbsp;</td>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $fullname . '</td>
                </tr> 
                <tr>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Coupon Type&nbsp;&nbsp;</td>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $coupontype . '</td>
                </tr>
                <tr>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Payment Method&nbsp;&nbsp;</td>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $pyamentmethod . '</td>
                </tr>
                <tr>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;"> Amount&nbsp;&nbsp;</td>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;"><span style="color:red;">$</span>' . $amount . '</td>
                </tr>
                <tr>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Payment Status&nbsp;&nbsp;</td>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $pyamentstatus . '</td>
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
            $mobileno = $_POST['phone'] ?? '';
            if (($_POST['phone'] ?? '') != null) {
                $msg = 'Houston Durga Bari: Food Coupon confirmation are Member Id: ' . $memberid . ', Full Name: ' . $fullname . ', Coupon Type: ' . $coupontype . ' , Payment Method: ' . $pyamentmethod . ' ,Amount: $' . $amount . ', Pay Date: ' . $payfinaldate . ',  Order Id: ' . $oid . ', Status: ' . $pyamentstatus;
                //echo "<script>alert('$msg')</script>";
                $this->SendSMS($mobileno, $msg);
            }
            //echo '<script>alert("Data Updated Successfully")</script>';
            Util::redirect(INSTALL_URL . "pujafoodcoupon/index");
            exit();
        }

       else if (!empty($_POST['create_Pujafoodcoupon'])) {

                $data = array();
              
                date_default_timezone_set("America/Chicago");
                $today = date("Y/m/d"); 
                $_POST['paydate'] = $today;
                $_POST['pay_type'] = 'Food Coupon';
                $_POST['pay_for'] = $_POST['coupontype'] ?? '';
                // for generate oid 
                //$oid= Util::incrementalHash(4);
                $maxoid = $idnumbersModel->getMaxoid() + 1;
                $update_oid = $idnumbersModel->Updateoid($maxoid);
                 $_POST['oid'] = $maxoid;
            // end generate oid for
                
           
             $datamember =  $MemberModel->rentalmemberduplicate();
            if($datamember == null){
                    
                     // for generate memberid for gd
                        $maxid = $idnumbersModel->getMaxmid() + 1;
                         $update_mid = $idnumbersModel->Updatemid($maxid);
                         $_POST['member_id'] = $maxid;
                    // end generate memberid for gd 
                }
                 if ($datamember != null) {
                     $_POST['member_id'] = $datamember;
                 }
               $registermember = $_POST['MemberName'] ?? '';  
                $regmember = $_POST['regmember'] ?? '';
                if($regmember == "nonmember"){
                    $nonmember = $_POST['namenonmember'] ?? ''; 
                    $_POST['MemberName'] = $nonmember;
                } else {
                    
                    $_POST['MemberName'] = $registermember;
                    // $memberid = $_POST['demmember'] ?? ''; 
                    // $_POST['Member_id'] = $memberid;
                }
               $categorymember =  $_POST['membercategory'] ?? '';
                $id = $pujafoodcouponModel->save(array_merge($_POST, $data));
    
            if (!empty($id)) {

                if (($_POST['PaymentOption'] ?? '') == 'others') {
                    
                    $opts = array();
                    $oid = $_POST['oid'] ?? '';
                    $cmCode=$_POST['code'] ?? '';
                    $isAvailable = $ConfirmCodeModel->ConfirmCheckCode($cmCode);
                    if(!$isAvailable)
                    {
                         Util::redirect(INSTALL_URL . "onlinepujapayments/onlinepujapayments");
                         exit();
                    }
                    $arr= $ConfirmCodeModel->UpdateCode($cmCode);
                    $_POST['transaction_id'] =  $cmCode;
                    $opts['Confirmation'] = $_POST['confirm_code'] ?? '';
                   $arr = $ConfirmCodeModel->getAll($opts);
                    if ($oid !=null){
                        $opts = array();
                        $opts['id'] = $id;
                        $opts['payment_status'] = 'confirmed';
                        $_POST['Status'] = 'confirmed';
                        $data = $_POST;
                       
                        $datefor =$_POST['paydate'] ?? '';
                        $timestamp = !empty($datefor) ? strtotime($datefor) : false;
                        $payfinaldate = $timestamp ? date("m/d/Y", $timestamp) : '';
                        $data = $_POST;
                        $this->sendEmailDonations($data);
                        $datamemberarr = array();
                        $datamemberarr =  array_merge($opts, $_POST) ; 
                        $pujafoodcouponModel->update(array_merge($opts, $_POST));
                        $value = array();
                        $value['oid'] = $datamemberarr['oid'];
                        $value['Member_id'] = $datamemberarr['member_id'];
                        $value['MemberName'] = $datamemberarr['F_Name'].' '.$datamemberarr['L_Name'];
                        $value['PaymentOption'] = $datamemberarr['PaymentOption'];
                        $value['payment_status'] = 'succeeded';
                        $value['payment_timestamp'] = $datamemberarr['payment_timestamp'] ?? '';
                        $value['Amount'] = $datamemberarr['amount'];
                        $value['stripe_return'] = $datamemberarr['stripe_return'] ?? '';
                        $value['transaction_id'] = $datamemberarr['transaction_id'];
                        $value['paid_amount'] = $datamemberarr['paid_amount'] ?? '';
                        $value['update_on'] = $datamemberarr['UpdateOn'];
                        $value['stripe_product'] = $datamemberarr['stripe_product'] ?? '';
                        $value['pay_date'] = $datamemberarr['paydate'] ?? $datamemberarr['pay_date'] ?? '';
                        $value['pay_type'] = $datamemberarr['pay_type'] ?? '';
                        $value['pay_for'] = $datamemberarr['pay_for'];
                        $value['Tele1'] = $datamemberarr['phone'];
                        $value['email'] = $datamemberarr['email'];
                        $value['City'] = $datamemberarr['City'];
                        $value['State'] = $datamemberarr['State'];
                        $value['Zip_Code'] = $datamemberarr['Zip'];
                        $value['bank'] = $datamemberarr['bankname'];
                        $value['chkno'] = $datamemberarr['checkno'];
                        $value['chkdate'] = $datamemberarr['chkdate'];
                        $value['ReceiveBy'] = $_POST['receiveby'] ?? '';
                        $DonationModel->SaveDataInDonation($value);
                        if($datamember == null) {
                            $value = array();
                            $value['MemberName'] =($_POST['F_Name'] ?? '') . ' ' . ($_POST['L_Name'] ?? '');
                            $value['Amount'] = $_POST['amount'] ?? '';
                            $value['PaymentOption'] = $_POST['PaymentOption'] ?? '';
                            $value['payment_status'] = 'confirmed';
                            $value['transaction_id'] = $_POST['checkno'] ?? '';
                            $value['Member_id'] = $_POST['member_id'] ?? '';
                            $value['pay_date'] = $_POST['paydate'] ?? '';
                            $value['oid'] = $_POST['oid'] ?? '';
                            $value['pay_type'] = $_POST['pay_type'] ?? '';
                            $value['pay_for'] = $_POST['pay_for'] ?? '';
                            $value['City'] = $_POST['City'] ?? '';
                            $value['State'] = $_POST['State'] ?? '';
                            $value['Zip_Code'] = $_POST['Zip'] ?? '';
                            $value['email'] = $_POST['email'] ?? '';
                            $value['Tele1'] = $_POST['phone'] ?? '';
                            $MemberModel->SaveDataInmember($value);
                        }
                        $datefor =$_POST['paydate'] ?? '';
                        $timestamp = !empty($datefor) ? strtotime($datefor) : false;
                        $payfinaldate = $timestamp ? date("m/d/Y", $timestamp) : '';
                        $mobileno= $data['phone'];
                          //$Emailcc = 'pujaassocpayment@durgabari.org';
                        $Emailcc = 'prateeksaini@eicetechnology.com';
                             $subjetc = 'HDBS Food Coupon Payment';
                             $fullname = ($_POST['F_Name'] ?? '') . ' ' . ($_POST['L_Name'] ?? '');
                             $memberid =$_POST['member_id'] ?? '';
                             $oid = $_POST['oid'] ?? '';
                             $couponfor = $_POST['couponfor'] ?? '';
                             $coupontype = $_POST['coupontype'] ?? '';
                             $pyamentmethod = "Zelle";
                             $pyamentstatus = "Confirmed";
                             $amount = $_POST['amount'] ?? '';
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
                             <td style="text-align: center; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;"><strong>Food Coupon</strong></td>
                             </tr>
                             </tbody>
                             </table>
                             </div>
                             <div class="email-token-class" style="text-align: center;">
                             <table style="height: 190px; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;" width="604">
                             <tbody>
                             <tr>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Order Id&nbsp;&nbsp;</td>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">' . $oid . '</td>
                             </tr>
                             <tr>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Member Id&nbsp;&nbsp;</td>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $memberid . '</td>
                             </tr>
                             <tr>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Full Name&nbsp;&nbsp;</td>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $fullname . '</td>
                             </tr>
                             <tr>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Coupon Type&nbsp;&nbsp;</td>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $coupontype . '</td>
                             </tr>
                             <tr>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Payment Method&nbsp;&nbsp;</td>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' .  $pyamentmethod . '</td>
                             </tr>
                             <tr>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;"> Amount&nbsp;&nbsp;</td>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;"><span style="color:red;">$</span>' . $amount . '</td>
                             </tr>
                             <tr>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Payment Status&nbsp;&nbsp;</td>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' .  $pyamentstatus . '</td>
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
                             if (($_POST['phone'] ?? '') != null) {
                                $msg = 'Houston Durga Bari: Food Coupon confirmation are Member Id: '. $memberid.', Full Name: '. $fullname.', Coupon Type: '.$coupontype.' , Payment Method: '.$pyamentmethod.' ,Amount: $'. $amount.', Pay Date: '. $payfinaldate.',  Order Id: '. $oid.', Status: ' . $pyamentstatus  ;
                                echo "<script>alert('$msg')</script>";
                                 $this->SendSMS($mobileno, $msg);
                                }
                             //echo '<script>alert("Data Updated Successfully")</script>';
                             Util::redirect(INSTALL_URL . "pujafoodcoupon/index"); 
                                        
                    }
                    exit();
                }
                    elseif (($_POST['PaymentOption'] ?? '') == 'check') {

                        $_POST['amount'] = $_POST['checkAmount'] ?? '';
                        $_POST['bankname'] = $_POST['checkbankname'] ?? '';
                        $_POST['chkdate'] = $_POST['CheckDate'] ?? '';
                        $_POST['pay_date'] = $_POST['CheckDate'] ?? '';
                        $_POST['Status'] = 'confirmed';
                        $_POST['payment_status'] = 'confirmed';
                        $_POST['id'] = $id;
                        $datamemberarr = array();
                        $datamemberarr = array_merge($_POST);
                        $pujafoodcouponModel->update(array_merge($_POST));

                        $value = array();
                        $value['oid'] = $datamemberarr['oid'];
                        $value['Member_id'] = $datamemberarr['member_id'];
                        $value['MemberName'] = $datamemberarr['F_Name'].' '.$datamemberarr['L_Name'];
                        $value['PaymentOption'] = $datamemberarr['PaymentOption'];
                        $value['payment_status'] = 'succeeded';
                        $value['payment_timestamp'] = $datamemberarr['payment_timestamp'] ?? '';
                        $value['Amount'] = $datamemberarr['amount'];
                        $value['stripe_return'] = $datamemberarr['stripe_return'] ?? '';
                        $value['transaction_id'] = $datamemberarr['transaction_id'];
                        $value['paid_amount'] = $datamemberarr['paid_amount'] ?? '';
                        $value['update_on'] = $datamemberarr['UpdateOn'];
                        $value['stripe_product'] = $datamemberarr['stripe_product'] ?? '';
                        $value['pay_date'] = $datamemberarr['paydate'] ?? $datamemberarr['pay_date'] ?? '';
                        $value['pay_type'] = $datamemberarr['pay_type'] ?? '';
                        $value['pay_for'] = $datamemberarr['pay_for'];
                        $value['Tele1'] = $datamemberarr['phone'];
                        $value['email'] = $datamemberarr['email'];
                        $value['City'] = $datamemberarr['City'];
                        $value['State'] = $datamemberarr['State'];
                        $value['Zip_Code'] = $datamemberarr['Zip'];
                        $value['bank'] = $datamemberarr['bankname'];
                        $value['chkno'] = $datamemberarr['checkno'];
                        $value['chkdate'] = $datamemberarr['chkdate'];
                        $DonationModel->SaveDataInDonation($value);

                        if($datamember == null) {
                            $value = array();
                            $value['MemberName'] =($_POST['F_Name'] ?? '') . ' ' . ($_POST['L_Name'] ?? '');
                            $value['Amount'] = $_POST['amount'] ?? '';
                            $value['PaymentOption'] = $_POST['PaymentOption'] ?? '';
                            $value['payment_status'] = 'confirmed';
                            $value['transaction_id'] = $_POST['checkno'] ?? '';
                            $value['Member_id'] = $_POST['member_id'] ?? '';
                            $value['pay_date'] = $_POST['paydate'] ?? '';
                            $value['oid'] = $_POST['oid'] ?? '';
                            $value['pay_type'] = $_POST['pay_type'] ?? '';
                            $value['pay_for'] = $_POST['pay_for'] ?? '';
                            $value['City'] = $_POST['City'] ?? '';
                            $value['State'] = $_POST['State'] ?? '';
                            $value['Zip_Code'] = $_POST['Zip'] ?? '';
                            $value['email'] = $_POST['email'] ?? '';
                            $value['Tele1'] = $_POST['phone'] ?? '';
                            $MemberModel->SaveDataInmember($value);
                            $this->tpl['arr'] = $pujafoodcouponModel->get($id);
                            
                        }

                        $datefor =$_POST['paydate'] ?? '';
                        $timestamp = !empty($datefor) ? strtotime($datefor) : false;
                        $payfinaldate = $timestamp ? date("m/d/Y", $timestamp) : '';
                             $subjetc = 'HDBS Food Coupon Payment';
                $fullname = ($_POST['F_Name'] ?? '') . ' ' . ($_POST['L_Name'] ?? '');
                $memberid =$_POST['member_id'] ?? '';
                $oid = $_POST['oid'] ?? '';
                $couponfor = $_POST['couponfor'] ?? '';
                $coupontype = $_POST['coupontype'] ?? '';
                $pyamentmethod = "Check";
                $pyamentstatus = "Confirmed";
                $amount = $_POST['amount'] ?? '';
                 //$Emailcc = 'pujaassocpayment@durgabari.org';
                 $Emailcc = 'prateeksaini@eicetechnology.com';
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
                <td style="text-align: center; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;"><strong>Food Coupon</strong></td>
                </tr>
                </tbody>
                </table>
                </div>
                <div class="email-token-class" style="text-align: center;">
                <table style="height: 190px; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;" width="604">
                <tbody>
                <tr>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Order Id&nbsp;&nbsp;</td>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">' . $oid . '</td>
                </tr>
                <tr>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Member Id&nbsp;&nbsp;</td>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $memberid . '</td>
                </tr>
                <tr>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Full Name&nbsp;&nbsp;</td>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $fullname . '</td>
                </tr> 
                <tr>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Coupon Type&nbsp;&nbsp;</td>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $coupontype . '</td>
                </tr>
                <tr>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Payment Method&nbsp;&nbsp;</td>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' .  $pyamentmethod . '</td>
                </tr>
                <tr>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;"> Amount&nbsp;&nbsp;</td>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;"><span style="color:red;">$</span>' . $amount . '</td>
                </tr>
                <tr>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Payment Status&nbsp;&nbsp;</td>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' .  $pyamentstatus . '</td>
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
                $mobileno= $_POST['phone'] ?? '';
                            if (($_POST['phone'] ?? '') != null) {
                                $msg = 'Houston Durga Bari: Food Coupon confirmation are Member Id: '. $memberid.', Full Name: '. $fullname.', Coupon Type: '.$coupontype.' , Payment Method: '.$pyamentmethod.' ,Amount: $'. $amount.', Pay Date: '. $payfinaldate.',  Order Id: '. $oid.', Status: ' . $pyamentstatus  ;
                                echo "<script>alert('$msg')</script>";
                                $this->SendSMS($mobileno, $msg);
                                }
                //echo '<script>alert("Data Updated Successfully")</script>';
                Util::redirect(INSTALL_URL . "pujafoodcoupon/index"); 
                             exit();
                    } 
                    elseif (($_POST['PaymentOption'] ?? '') == 'cash') {
                        $_POST['amount'] = $_POST['cashAmount'] ?? '';
                        $_POST['pay_date'] = $_POST['cashDate'] ?? '';
                        $_POST['Status'] = 'confirmed';
                        $_POST['payment_status'] = 'confirmed';
                        $_POST['id'] = $id;
                        $datamemberarr = array();
                        $datamemberarr = array_merge($_POST);
                        $pujafoodcouponModel->update(array_merge($_POST));
                        $value = array();
                        $value['oid'] = $datamemberarr['oid'];
                        $value['Member_id'] = $datamemberarr['member_id'];
                        $value['MemberName'] = $datamemberarr['F_Name'].' '.$datamemberarr['L_Name'];
                        $value['PaymentOption'] = $datamemberarr['PaymentOption'];
                        $value['payment_status'] = 'succeeded';
                        $value['payment_timestamp'] = $datamemberarr['payment_timestamp'] ?? '';
                        $value['Amount'] = $datamemberarr['amount'];
                        $value['stripe_return'] = $datamemberarr['stripe_return'] ?? '';
                        $value['transaction_id'] = $datamemberarr['transaction_id'];
                        $value['paid_amount'] = $datamemberarr['paid_amount'] ?? '';
                        $value['update_on'] = $datamemberarr['UpdateOn'];
                        $value['stripe_product'] = $datamemberarr['stripe_product'] ?? '';
                        $value['pay_date'] = $datamemberarr['paydate'] ?? $datamemberarr['pay_date'] ?? '';
                        $value['pay_type'] = $datamemberarr['pay_type'] ?? '';
                        $value['pay_for'] = $datamemberarr['pay_for'];
                        $value['Tele1'] = $datamemberarr['phone'];
                        $value['email'] = $datamemberarr['email'];
                        $value['City'] = $datamemberarr['City'];
                        $value['State'] = $datamemberarr['State'];
                        $value['Zip_Code'] = $datamemberarr['Zip'];
                        $value['bank'] = $datamemberarr['bankname'];
                        $value['chkno'] = $datamemberarr['checkno'];
                        $value['chkdate'] = $datamemberarr['chkdate'];
                        $value['ReceiveBy'] = $_POST['receiveby'] ?? '';
                        $DonationModel->SaveDataInDonation($value);
                        if($datamember == null) {
                            $value = array();
                            $value['MemberName'] =($_POST['F_Name'] ?? '') . ' ' . ($_POST['L_Name'] ?? '');
                            $value['Amount'] = $_POST['amount'] ?? '';
                            $value['PaymentOption'] = $_POST['PaymentOption'] ?? '';
                            $value['payment_status'] = 'confirmed';
                            $value['transaction_id'] = $_POST['checkno'] ?? '';
                            $value['Member_id'] = $_POST['member_id'] ?? '';
                            $value['pay_date'] = $_POST['paydate'] ?? '';
                            $value['oid'] = $_POST['oid'] ?? '';
                            $value['pay_type'] = $_POST['pay_type'] ?? '';
                            $value['pay_for'] = $_POST['pay_for'] ?? '';
                            $value['City'] = $_POST['City'] ?? '';
                            $value['State'] = $_POST['State'] ?? '';
                            $value['Zip_Code'] = $_POST['Zip'] ?? '';
                            $value['email'] = $_POST['email'] ?? '';
                            $value['Tele1'] = $_POST['phone'] ?? '';
                            $MemberModel->SaveDataInmember($value);
                        }
                        $datefor =$_POST['paydate'] ?? '';
                        $timestamp = !empty($datefor) ? strtotime($datefor) : false;
                        $payfinaldate = $timestamp ? date("m/d/Y", $timestamp) : '';
                        
                             $subjetc = 'HDBS Food Coupon Payment';
                             $fullname = ($_POST['F_Name'] ?? '') . ' ' . ($_POST['L_Name'] ?? '');
                             $memberid =$_POST['member_id'] ?? '';
                             $oid = $_POST['oid'] ?? '';
                             $couponfor = $_POST['couponfor'] ?? '';
                             $coupontype = $_POST['coupontype'] ?? '';
                             $pyamentmethod = "Cash";
                             $pyamentstatus = "Confirmed";
                             $amount = $_POST['amount'] ?? '';
                             //$Emailcc = 'pujaassocpayment@durgabari.org';
                             $Emailcc = 'prateeksaini@eicetechnology.com';
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
                             <td style="text-align: center; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;"><strong>Food Coupon</strong></td>
                             </tr>
                             </tbody>
                             </table>
                             </div>
                             <div class="email-token-class" style="text-align: center;">
                             <table style="height: 190px; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;" width="604">
                             <tbody>
                             <tr>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Order Id&nbsp;&nbsp;</td>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">' . $oid . '</td>
                             </tr>
                             <tr>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Member Id&nbsp;&nbsp;</td>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $memberid . '</td>
                             </tr>
                             <tr>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Full Name&nbsp;&nbsp;</td>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $fullname . '</td>
                             </tr>
                             <tr>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Coupon Type&nbsp;&nbsp;</td>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $coupontype . '</td>
                             </tr>
                             <tr>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Payment Method&nbsp;&nbsp;</td>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' .  $pyamentmethod . '</td>
                             </tr>
                             <tr>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;"> Amount&nbsp;&nbsp;</td>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;"><span style="color:red;">$</span>' . $amount . '</td>
                             </tr>
                             <tr>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Payment Status&nbsp;&nbsp;</td>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' .  $pyamentstatus . '</td>
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
                             $mobileno= $_POST['phone'] ?? '';
                            if (($_POST['phone'] ?? '') != null) {
                                $msg = 'Houston Durga Bari: Food Coupon confirmation are Member Id: '. $memberid.', Full Name: '. $fullname.', Coupon Type: '.$coupontype.' , Payment Method: '.$pyamentmethod.' ,Amount: $'. $amount.', Pay Date: '. $payfinaldate.',  Order Id: '. $oid.', Status: ' . $pyamentstatus  ;
                                echo "<script>alert('$msg')</script>";
                                $this->SendSMS($mobileno, $msg);
                                }
                             //echo '<script>alert("Data Updated Successfully")</script>';
                             Util::redirect(INSTALL_URL . "pujafoodcoupon/index"); 
                            exit();
             
                    }
                     elseif (($_POST['PaymentOption'] ?? '') == 'directdeposit') {
                        $_POST['bankname'] = $_POST['BankName'] ?? '';
                        $_POST['pay_date'] = $_POST['transactiondate'] ?? '';
                        $_POST['transaction_id'] = $_POST['ISFCCode'] ?? '';
                        $_POST['amount'] = $_POST['directamount'] ?? '';
                        $_POST['Status'] = 'confirmed';
                        $_POST['payment_status'] = 'confirmed';
                        $_POST['id'] = $id;
                        $datamemberarr = array();
                        $datamemberarr = array_merge($_POST);
                        $pujafoodcouponModel->update(array_merge($_POST));
                        $value = array();
                        $value['oid'] = $datamemberarr['oid'];
                        $value['Member_id'] = $datamemberarr['member_id'];
                        $value['MemberName'] = $datamemberarr['F_Name'].' '.$datamemberarr['L_Name'];
                        $value['PaymentOption'] = $datamemberarr['PaymentOption'];
                        $value['payment_status'] = 'succeeded';
                        $value['payment_timestamp'] = $datamemberarr['payment_timestamp'] ?? '';
                        $value['Amount'] = $datamemberarr['amount'];
                        $value['stripe_return'] = $datamemberarr['stripe_return'] ?? '';
                        $value['transaction_id'] = $datamemberarr['transaction_id'];
                        $value['paid_amount'] = $datamemberarr['paid_amount'] ?? '';
                        $value['update_on'] = $datamemberarr['UpdateOn'];
                        $value['stripe_product'] = $datamemberarr['stripe_product'] ?? '';
                        $value['pay_date'] = $datamemberarr['paydate'] ?? $datamemberarr['pay_date'] ?? '';
                        $value['pay_type'] = $datamemberarr['pay_type'] ?? '';
                        $value['pay_for'] = $datamemberarr['pay_for'];
                        $value['Tele1'] = $datamemberarr['phone'];
                        $value['email'] = $datamemberarr['email'];
                        $value['City'] = $datamemberarr['City'];
                        $value['State'] = $datamemberarr['State'];
                        $value['Zip_Code'] = $datamemberarr['Zip'];
                        $value['bank'] = $datamemberarr['bankname'];
                        $value['chkno'] = $datamemberarr['checkno'];
                        $value['chkdate'] = $datamemberarr['chkdate'];
                        $value['ReceiveBy'] = $_POST['receiveby'] ?? '';
                        $DonationModel->SaveDataInDonation($value);
                        if($datamember == null) {
                            $value = array();
                            $value['MemberName'] =($_POST['F_Name'] ?? '') . ' ' . ($_POST['L_Name'] ?? '');
                            $value['Amount'] = $_POST['amount'] ?? '';
                            $value['PaymentOption'] = $_POST['PaymentOption'] ?? '';
                            $value['payment_status'] = 'confirmed';
                            $value['transaction_id'] = $_POST['checkno'] ?? '';
                            $value['Member_id'] = $_POST['member_id'] ?? '';
                            $value['pay_date'] = $_POST['paydate'] ?? '';
                            $value['oid'] = $_POST['oid'] ?? '';
                            $value['pay_type'] = $_POST['pay_type'] ?? '';
                            $value['pay_for'] = $_POST['pay_for'] ?? '';
                            $value['City'] = $_POST['City'] ?? '';
                            $value['State'] = $_POST['State'] ?? '';
                            $value['Zip_Code'] = $_POST['Zip'] ?? '';
                            $value['email'] = $_POST['email'] ?? '';
                            $value['Tele1'] = $_POST['phone'] ?? '';
                            $MemberModel->SaveDataInmember($value);
                        }
                        $datefor =$_POST['paydate'] ?? '';
                        $timestamp = !empty($datefor) ? strtotime($datefor) : false;
                        $payfinaldate = $timestamp ? date("m/d/Y", $timestamp) : '';
                        $mobileno= $data['phone'];
                             $subjetc = 'HDBS Food Coupon Payment';
                             $fullname = ($_POST['F_Name'] ?? '') . ' ' . ($_POST['L_Name'] ?? '');
                             $memberid =$_POST['member_id'] ?? '';
                             $oid = $_POST['oid'] ?? '';
                             $couponfor = $_POST['couponfor'] ?? '';
                             $coupontype = $_POST['coupontype'] ?? '';
                             $pyamentmethod = "Direct Deposite";
                             $pyamentstatus = "Confirmed";
                             $amount = $_POST['amount'] ?? '';
                             //$Emailcc = 'pujaassocpayment@durgabari.org';
                             $Emailcc = 'prateeksaini@eicetechnology.com';
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
                             <td style="text-align: center; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;"><strong>Food Coupon</strong></td>
                             </tr>
                             </tbody>
                             </table>
                             </div>
                             <div class="email-token-class" style="text-align: center;">
                             <table style="height: 190px; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;" width="604">
                             <tbody>
                             <tr>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Order Id&nbsp;&nbsp;</td>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">' . $oid . '</td>
                             </tr>
                             <tr>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Member Id&nbsp;&nbsp;</td>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $memberid . '</td>
                             </tr>
                             <tr>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Full Name&nbsp;&nbsp;</td>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $fullname . '</td>
                             </tr>
                             <tr>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Coupon Type&nbsp;&nbsp;</td>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $coupontype . '</td>
                             </tr>
                             <tr>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Payment Method&nbsp;&nbsp;</td>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' .  $pyamentmethod . '</td>
                             </tr>
                             <tr>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;"> Amount&nbsp;&nbsp;</td>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;"><span style="color:red;">$</span>' . $amount . '</td>
                             </tr>
                             <tr>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Payment Status&nbsp;&nbsp;</td>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' .  $pyamentstatus . '</td>
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
                             $mobileno= $_POST['phone'] ?? '';
                            if (($_POST['phone'] ?? '') != null) {
                                $msg = 'Houston Durga Bari: Food Coupon confirmation are Member Id: '. $memberid.', Full Name: '. $fullname.', Coupon Type: '.$coupontype.' , Payment Method: '.$pyamentmethod.' ,Amount: $'. $amount.', Pay Date: '. $payfinaldate.',  Order Id: '. $oid.', Status: ' . $pyamentstatus  ;
                                echo "<script>alert('$msg')</script>";
                                $this->SendSMS($mobileno, $msg);
                                }
                             //echo '<script>alert("Data Updated Successfully")</script>';
                             Util::redirect(INSTALL_URL . "pujafoodcoupon/index"); 
                                          exit();
                    }
                    elseif (($_POST['PaymentOption'] ?? '') == 'sumup') {
                        $_POST['pay_date'] = $_POST['sumupdate'] ?? '';
                        $_POST['transaction_id'] = $_POST['sumupid'] ?? '';
                        $_POST['amount'] = $_POST['sumupamount'] ?? '';
                        $_POST['Status'] = 'confirmed';
                        $_POST['payment_status'] = 'confirmed';
                        $_POST['id'] = $id;
                        $datamemberarr = array();
                        $datamemberarr = array_merge($_POST);
                        $pujafoodcouponModel->update(array_merge($_POST));
                        $value = array();
                        $value['oid'] = $datamemberarr['oid'];
                        $value['Member_id'] = $datamemberarr['member_id'];
                        $value['MemberName'] = $datamemberarr['F_Name'].' '.$datamemberarr['L_Name'];
                        $value['PaymentOption'] = $datamemberarr['PaymentOption'];
                        $value['payment_status'] = 'succeeded';
                        $value['payment_timestamp'] = $datamemberarr['payment_timestamp'] ?? '';
                        $value['Amount'] = $datamemberarr['amount'];
                        $value['stripe_return'] = $datamemberarr['stripe_return'] ?? '';
                        $value['transaction_id'] = $datamemberarr['transaction_id'];
                        $value['paid_amount'] = $datamemberarr['paid_amount'] ?? '';
                        $value['update_on'] = $datamemberarr['UpdateOn'];
                        $value['stripe_product'] = $datamemberarr['stripe_product'] ?? '';
                        $value['pay_date'] = $datamemberarr['paydate'] ?? $datamemberarr['pay_date'] ?? '';
                        $value['pay_type'] = $datamemberarr['pay_type'] ?? '';
                        $value['pay_for'] = $datamemberarr['pay_for'];
                        $value['Tele1'] = $datamemberarr['phone'];
                        $value['email'] = $datamemberarr['email'];
                        $value['City'] = $datamemberarr['City'];
                        $value['State'] = $datamemberarr['State'];
                        $value['Zip_Code'] = $datamemberarr['Zip'];
                        $value['bank'] = $datamemberarr['bankname'];
                        $value['chkno'] = $datamemberarr['checkno'];
                        $value['chkdate'] = $datamemberarr['chkdate'];
                        $value['ReceiveBy'] = $_POST['receiveby'] ?? '';
                        $DonationModel->SaveDataInDonation($value);
                        if($datamember == null) {
                            $value = array();
                            $value['MemberName'] =($_POST['F_Name'] ?? '') . ' ' . ($_POST['L_Name'] ?? '');
                            $value['Amount'] = $_POST['amount'] ?? '';
                            $value['PaymentOption'] = $_POST['PaymentOption'] ?? '';
                            $value['payment_status'] = 'confirmed';
                            $value['transaction_id'] = $_POST['checkno'] ?? '';
                            $value['Member_id'] = $_POST['member_id'] ?? '';
                            $value['pay_date'] = $_POST['paydate'] ?? '';
                            $value['oid'] = $_POST['oid'] ?? '';
                            $value['pay_type'] = $_POST['pay_type'] ?? '';
                            $value['pay_for'] = $_POST['pay_for'] ?? '';
                            $value['City'] = $_POST['City'] ?? '';
                            $value['State'] = $_POST['State'] ?? '';
                            $value['Zip_Code'] = $_POST['Zip'] ?? '';
                            $value['email'] = $_POST['email'] ?? '';
                            $value['Tele1'] = $_POST['phone'] ?? '';
                            $MemberModel->SaveDataInmember($value);
                        }
                        $datefor =$_POST['paydate'] ?? '';
                        $timestamp = !empty($datefor) ? strtotime($datefor) : false;
                        $payfinaldate = $timestamp ? date("m/d/Y", $timestamp) : '';
                        $mobileno= $data['phone'];
                             $subjetc = 'HDBS Food Coupon Payment';
                             $fullname = ($_POST['F_Name'] ?? '') . ' ' . ($_POST['L_Name'] ?? '');
                             $memberid =$_POST['member_id'] ?? '';
                             $oid = $_POST['oid'] ?? '';
                             $couponfor = $_POST['couponfor'] ?? '';
                             $coupontype = $_POST['coupontype'] ?? '';
                             $pyamentmethod = "SumUp";
                             $pyamentstatus = "Confirmed";
                             $amount = $_POST['amount'] ?? '';
                             //$Emailcc = 'pujaassocpayment@durgabari.org';
                             $Emailcc = 'prateeksaini@eicetechnology.com';
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
                             <td style="text-align: center; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;"><strong>Food Coupon</strong></td>
                             </tr>
                             </tbody>
                             </table>
                             </div>
                             <div class="email-token-class" style="text-align: center;">
                             <table style="height: 190px; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;" width="604">
                             <tbody>
                             <tr>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Order Id&nbsp;&nbsp;</td>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">' . $oid . '</td>
                             </tr>
                             <tr>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Member Id&nbsp;&nbsp;</td>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $memberid . '</td>
                             </tr>
                             <tr>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Full Name&nbsp;&nbsp;</td>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $fullname . '</td>
                             </tr>
                             <tr>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Coupon Type&nbsp;&nbsp;</td>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $coupontype . '</td>
                             </tr>
                             <tr>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Payment Method&nbsp;&nbsp;</td>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' .  $pyamentmethod . '</td>
                             </tr>
                             <tr>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;"> Amount&nbsp;&nbsp;</td>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;"><span style="color:red;">$</span>' . $amount . '</td>
                             </tr>
                             <tr>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Payment Status&nbsp;&nbsp;</td>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' .  $pyamentstatus . '</td>
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
                             $mobileno= $_POST['phone'] ?? '';
                            if (($_POST['phone'] ?? '') != null) {
                                $msg = 'Houston Durga Bari: Food Coupon confirmation are Member Id: '. $memberid.', Full Name: '. $fullname.', Coupon Type: '.$coupontype.' , Payment Method: '.$pyamentmethod.' ,Amount: $'. $amount.', Pay Date: '. $payfinaldate.',  Order Id: '. $oid.', Status: ' . $pyamentstatus  ;
                                //echo "<script>alert('$msg')</script>";
                                $this->SendSMS($mobileno, $msg);
                                }
                             //echo '<script>alert("Data Updated Successfully")</script>';
                             Util::redirect(INSTALL_URL . "pujafoodcoupon/index"); 
                                          exit();
                    }
                    
                     elseif (($_POST['PaymentOption'] ?? '') == 'zelleProxy') {
                        $_POST['pay_date'] = $_POST['proxydate'] ?? '';
                        $_POST['transaction_id'] = $_POST['zelleProxyTid'] ?? '';
                        $_POST['amount'] = $_POST['proxyamount'] ?? '';
                        $_POST['DepositAccount'] = $_POST['zelleProxyDepositAccount'] ?? '';
                        $_POST['Status'] = 'confirmed';
                        $_POST['payment_status'] = 'confirmed';
                        $_POST['id'] = $id;
                        $datamemberarr = array();
                        $datamemberarr = array_merge($_POST);
                        $pujafoodcouponModel->update(array_merge($_POST));
                        $value = array();
                        $value['oid'] = $datamemberarr['oid'];
                        $value['Member_id'] = $datamemberarr['member_id'];
                        $value['MemberName'] = $datamemberarr['F_Name'].' '.$datamemberarr['L_Name'];
                        $value['PaymentOption'] = $datamemberarr['PaymentOption'];
                        $value['payment_status'] = 'succeeded';
                        $value['payment_timestamp'] = $datamemberarr['payment_timestamp'] ?? '';
                        $value['Amount'] = $datamemberarr['amount'];
                        $value['stripe_return'] = $datamemberarr['stripe_return'] ?? '';
                        $value['transaction_id'] = $datamemberarr['transaction_id'];
                        $value['paid_amount'] = $datamemberarr['paid_amount'] ?? '';
                        $value['update_on'] = $datamemberarr['UpdateOn'];
                        $value['stripe_product'] = $datamemberarr['stripe_product'] ?? '';
                        $value['pay_date'] = $datamemberarr['paydate'] ?? $datamemberarr['pay_date'] ?? '';
                        $value['pay_type'] = $datamemberarr['pay_type'] ?? '';
                        $value['pay_for'] = $datamemberarr['pay_for'];
                        $value['Tele1'] = $datamemberarr['phone'];
                        $value['email'] = $datamemberarr['email'];
                        $value['City'] = $datamemberarr['City'];
                        $value['State'] = $datamemberarr['State'];
                        $value['Zip_Code'] = $datamemberarr['Zip'];
                        $value['bank'] = $datamemberarr['bankname'];
                        $value['chkno'] = $datamemberarr['checkno'];
                        $value['chkdate'] = $datamemberarr['chkdate'];
                        $value['ReceiveBy'] = $_POST['receiveby'] ?? '';
                        $DonationModel->SaveDataInDonation($value);
                        if($datamember == null) {
                            $value = array();
                            $value['MemberName'] =($_POST['F_Name'] ?? '') . ' ' . ($_POST['L_Name'] ?? '');
                            $value['Amount'] = $_POST['amount'] ?? '';
                            $value['PaymentOption'] = $_POST['PaymentOption'] ?? '';
                            $value['payment_status'] = 'confirmed';
                            $value['transaction_id'] = $_POST['checkno'] ?? '';
                            $value['Member_id'] = $_POST['member_id'] ?? '';
                            $value['pay_date'] = $_POST['paydate'] ?? '';
                            $value['oid'] = $_POST['oid'] ?? '';
                            $value['pay_type'] = $_POST['pay_type'] ?? '';
                            $value['pay_for'] = $_POST['pay_for'] ?? '';
                            $value['City'] = $_POST['City'] ?? '';
                            $value['State'] = $_POST['State'] ?? '';
                            $value['Zip_Code'] = $_POST['Zip'] ?? '';
                            $value['email'] = $_POST['email'] ?? '';
                            $value['Tele1'] = $_POST['phone'] ?? '';
                            $MemberModel->SaveDataInmember($value);
                        }
                        $datefor =$_POST['paydate'] ?? '';
                        $timestamp = !empty($datefor) ? strtotime($datefor) : false;
                        $payfinaldate = $timestamp ? date("m/d/Y", $timestamp) : '';
                        $mobileno= $data['phone'];
                             $subjetc = 'HDBS Food Coupon Payment';
                             $fullname = ($_POST['F_Name'] ?? '') . ' ' . ($_POST['L_Name'] ?? '');
                             $memberid =$_POST['member_id'] ?? '';
                             $oid = $_POST['oid'] ?? '';
                             $couponfor = $_POST['couponfor'] ?? '';
                             $coupontype = $_POST['coupontype'] ?? '';
                             $pyamentmethod = "Zelle Proxy";
                             $pyamentstatus = "Confirmed";
                             $amount = $_POST['amount'] ?? '';
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
                             <td style="text-align: center; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;"><strong>Food Coupon</strong></td>
                             </tr>
                             </tbody>
                             </table>
                             </div>
                             <div class="email-token-class" style="text-align: center;">
                             <table style="height: 190px; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;" width="604">
                             <tbody>
                             <tr>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Order Id&nbsp;&nbsp;</td>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">' . $oid . '</td>
                             </tr>
                             <tr>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Member Id&nbsp;&nbsp;</td>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $memberid . '</td>
                             </tr>
                             <tr>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Full Name&nbsp;&nbsp;</td>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $fullname . '</td>
                             </tr>
                             <tr>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Coupon Type&nbsp;&nbsp;</td>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $coupontype . '</td>
                             </tr>
                             <tr>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Payment Method&nbsp;&nbsp;</td>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' .  $pyamentmethod . '</td>
                             </tr>
                             <tr>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;"> Amount&nbsp;&nbsp;</td>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;"><span style="color:red;">$</span>' . $amount . '</td>
                             </tr>
                             <tr>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Payment Status&nbsp;&nbsp;</td>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' .  $pyamentstatus . '</td>
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
                             $mobileno= $_POST['phone'] ?? '';
                            if (($_POST['phone'] ?? '') != null) {
                                $msg = 'Houston Durga Bari: Food Coupon confirmation are Member Id: '. $memberid.', Full Name: '. $fullname.', Coupon Type: '.$coupontype.' , Payment Method: '.$pyamentmethod.' ,Amount: $'. $amount.', Pay Date: '. $payfinaldate.',  Order Id: '. $oid.', Status: ' . $pyamentstatus  ;
                                //echo "<script>alert('$msg')</script>";
                                 $this->SendSMS($mobileno, $msg);
                                }
                             //echo '<script>alert("Data Updated Successfully")</script>';
                             Util::redirect(INSTALL_URL . "pujafoodcoupon/index"); 
                                          exit();
                    }
                elseif (($_POST['PaymentOption'] ?? '') == 'stripe') {

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

                        $payment = Stripe_Charge::create(array(
                                     "amount" => $amount,
                                     "currency" => "USD",
                                    //  "currency" => $this->tpl["option_arr_values"]["currency"],
                                     "card" => $_POST['stripeToken'] ?? '',
                                     "description" =>  "Pay For:" . ($_POST['pay_type'] ?? '') . ', ' . "Email:" . ($_POST['email'] ?? '') . ', ' . "Full Name:" . ($_POST['F_Name'] ?? '') . ' ' . ($_POST['L_Name'] ?? ''),
                                     "metadata" => ["orderid" => $oid]
                        ));

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
                            //$opts['payment_status'] = 'confirmed';
                            $opts['payment_status'] = 'confirmed';
                            $opts['Status'] = 'confirmed';
                            $opts['payment_timestamp'] = time();

                            $data = $_POST;
                           $datamemberarr = array();
                           $datamemberarr =  array_merge($opts, $_POST) ; 
                           $pujafoodcouponModel->update(array_merge($opts, $_POST));
                           $value = array();
                           $value['oid'] = $datamemberarr['oid'];
                           $value['Member_id'] = $datamemberarr['member_id'];
                           $value['MemberName'] = $datamemberarr['F_Name'].' '.$datamemberarr['L_Name'];
                           $value['PaymentOption'] = $datamemberarr['PaymentOption'];
                           $value['payment_status'] = 'succeeded';
                           $value['payment_timestamp'] = $datamemberarr['payment_timestamp'] ?? '';
                           $value['Amount'] = $datamemberarr['amount'];
                           $value['stripe_return'] = $datamemberarr['stripe_return'] ?? '';
                           $value['transaction_id'] = $datamemberarr['transaction_id'];
                           $value['paid_amount'] = $datamemberarr['paid_amount'] ?? '';
                           $value['update_on'] = $datamemberarr['UpdateOn'] ?? '';
                           $value['stripe_product'] = $datamemberarr['stripe_product'] ?? '';
                           $value['pay_date'] = $datamemberarr['paydate'] ?? $datamemberarr['pay_date'] ?? '';
                           $value['pay_type'] = $datamemberarr['paydate'] ?? '';
                           $value['pay_for'] = $datamemberarr['pay_for'] ?? '';
                           $value['Tele1'] = $datamemberarr['phone'] ?? '';
                           $value['email'] = $datamemberarr['email'] ?? '';
                           $value['City'] = $datamemberarr['City'] ?? '';
                           $value['State'] = $datamemberarr['State'] ?? '';
                           $value['Zip_Code'] = $datamemberarr['Zip'] ?? '';
                           $value['bank'] = $datamemberarr['bankname'] ?? '';
                           $value['chkno'] = $datamemberarr['checkno'] ?? '';
                           $value['chkdate'] = $datamemberarr['chkdate'] ?? '';
                           $value['ReceiveBy'] = $_POST['receiveby'] ?? '';
                           $DonationModel->SaveDataInDonation($value);
                           if($datamember == null) {
                               $value = array();
                               $value['MemberName'] =($_POST['F_Name'] ?? '') . ' ' . ($_POST['L_Name'] ?? '');
                               $value['Amount'] = $_POST['amount'] ?? '';
                               $value['PaymentOption'] = $_POST['PaymentOption'] ?? '';
                               $value['payment_status'] = 'confirmed';
                               $value['transaction_id'] = $_POST['checkno'] ?? '';
                               $value['Member_id'] = $_POST['member_id'] ?? '';
                               $value['pay_date'] = $_POST['paydate'] ?? '';
                               $value['oid'] = $_POST['oid'] ?? '';
                               $value['pay_type'] = $_POST['pay_type'] ?? '';
                               $value['pay_for'] = $_POST['pay_for'] ?? '';
                               $value['City'] = $_POST['City'] ?? '';
                               $value['State'] = $_POST['State'] ?? '';
                               $value['Zip_Code'] = $_POST['Zip'] ?? '';
                               $value['email'] = $_POST['email'] ?? '';
                               $value['Tele1'] = $_POST['phone'] ?? '';
                               $MemberModel->SaveDataInmember($value);
                           }
                           $datefor =$_POST['paydate'] ?? '';
                           $timestamp = !empty($datefor) ? strtotime($datefor) : false;
                           $payfinaldate = $timestamp ? date("m/d/Y", $timestamp) : '';
                           
                            $this->tpl['arr'] = $pujafoodcouponModel->get($id);
                            //$Emailcc = 'pujaassocpayment@durgabari.org';
                            $Emailcc = 'prateeksaini@eicetechnology.com';
                            $subjetc = 'HDBS Food Coupon Payment';
                            $fullname = ($_POST['F_Name'] ?? '') . ' ' . ($_POST['L_Name'] ?? '');
                            $memberid =$_POST['member_id'] ?? '';
                            $oid = $_POST['oid'] ?? '';
                            $couponfor = $_POST['couponfor'] ?? '';
                            $coupontype = $_POST['coupontype'] ?? '';
                            $pyamentmethod = "Credit Card";
                            $pyamentstatus = "Confirmed";
                            $amount = $_POST['amount'] ?? '';
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
                            <td style="text-align: center; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;"><strong>Food Coupon</strong></td>
                            </tr>
                            </tbody>
                            </table>
                            </div>
                            <div class="email-token-class" style="text-align: center;">
                            <table style="height: 190px; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;" width="604">
                            <tbody>
                            <tr>
                            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Order Id&nbsp;&nbsp;</td>
                            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">' . $oid . '</td>
                            </tr>
                            <tr>
                            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Member Id&nbsp;&nbsp;</td>
                            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $memberid . '</td>
                            </tr>
                            <tr>
                            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Full Name&nbsp;&nbsp;</td>
                            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $fullname . '</td>
                            </tr>
                            <tr>
                            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Coupon Type&nbsp;&nbsp;</td>
                            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $coupontype . '</td>
                            </tr>
                            <tr>
                            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Payment Method&nbsp;&nbsp;</td>
                            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' .  $pyamentmethod . '</td>
                            </tr>
                            <tr>
                            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;"> Amount&nbsp;&nbsp;</td>
                            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;"><span style="color:red;">$</span>' . $amount . '</td>
                            </tr>
                            <tr>
                            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Payment Status&nbsp;&nbsp;</td>
                            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' .  $pyamentstatus . '</td>
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
                            $mobileno= $_POST['phone'] ?? '';
                            if (($_POST['phone'] ?? '') != null) {
                                $msg = 'Houston Durga Bari: Food Coupon confirmation are Member Id: '. $memberid.', Full Name: '. $fullname.', Coupon Type: '.$coupontype.' , Payment Method: '.$pyamentmethod.' ,Amount: $'. $amount.', Pay Date: '. $payfinaldate.',  Order Id: '. $oid.', Status: ' . $pyamentstatus  ;
                                echo "<script>alert('$msg')</script>";
                                $this->SendSMS($mobileno, $msg);
                                }
                            //echo '<script>alert("Data Updated Successfully")</script>';
                            Util::redirect(INSTALL_URL . "pujafoodcoupon/index"); 
                        exit();
            
                        } else {

                            $opts = array();
                            $opts['id'] = $id;
                            $opts['stripe_return'] = $payment->status;
                            $opts['transaction_id'] = $payment->id;
                            $opts['paid_amount'] = $payment->amount;
                            $opts['stripe_product'] = $payment->description;

                            $pujafoodcouponModel->update($opts);

                            $_SESSION['status'] = '<strong>' . __('declined_card') . '</strong>';
                        }
                    } catch (Exception $ex) {
                        $_SESSION['status'] = $ex->getMessage();
                    }
                    
                    $this->tpl['arr'] = $pujafoodcouponModel->get($id);
                    $this->tpl['arr']['amount'] = $total;
                }
                
                else{
                     $_SESSION['status'] = 16;
                   
                }
            } else {
                $_SESSION['status'] = 17;
            }
        //    exit();
           
           // Util::redirect(INSTALL_URL . "foodcoupondata/index");
        }
      
}


    function pujafoodcoupon_17_august()
    {
        $this->setIsAjax(true);
       //$this->js[] = array('file' => 'jquery/jquery-1.8.2.min.js', 'path' => LIBS_PATH);
        GzObject::loadFiles('Model', array('pujafoodcoupon', 'foodcouponprice','ConfirmCode','Member','Donation' ,'idnumbers'));
        $pujafoodcouponModel =  new pujafoodcouponModel();
        $ConfirmCodeModel =  new ConfirmCodeModel();
        $MemberModel = new MemberModel();
        $idnumbersModel = new idnumbersModel();
        $DonationModel = new DonationModel();
        $ConfirmCodeModel = new ConfirmCodeModel();
        $foodcouponpriceModel = new foodcouponpriceModel();
        $opts = array();
      
        $foodcouponpricearr = $foodcouponpriceModel->getall($opts);
        $this->tpl['foodcouponpricearr'] = $foodcouponpricearr;

        if (!empty($_POST['create_Pujafoodcoupon'])) {

                $data = array();
              
                date_default_timezone_set("America/Chicago");
                $today = date("Y/m/d"); 
                $_POST['paydate'] = $today;
                $_POST['CreatedAt'] = $today;
                $_POST['pay_type'] = 'Food Coupon';
                $_POST['pay_for'] = $_POST['coupontype'] ?? '';
                // for generate oid 
                //$oid= Util::incrementalHash(4);
                $maxoid = $idnumbersModel->getMaxoid() + 1;
                $update_oid = $idnumbersModel->Updateoid($maxoid);
                 $_POST['oid'] = $maxoid;
            // end generate oid for
                
           
             $datamember =  $MemberModel->rentalmemberduplicate();
            if($datamember == null){
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
               $registermember = $_POST['MemberName'] ?? '';  
                $regmember = $_POST['regmember'] ?? '';
                if($regmember == "nonmember"){
                    $nonmember = $_POST['namenonmember'] ?? ''; 
                    $_POST['MemberName'] = $nonmember;
                } else {
                    
                    $_POST['MemberName'] = $registermember;
                    // $memberid = $_POST['demmember'] ?? ''; 
                    // $_POST['Member_id'] = $memberid;
                }
               $categorymember =  $_POST['membercategory'] ?? '';
                $id = $pujafoodcouponModel->save(array_merge($_POST, $data));
    
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
                        $opts = array();
                        $opts['id'] = $id;
                        $opts['payment_status'] = 'confirmed';
                        $_POST['Status'] = 'confirmed';
                        $data = $_POST;
                       
                        $datefor =$_POST['paydate'] ?? '';
                        $timestamp = !empty($datefor) ? strtotime($datefor) : false;
                        $payfinaldate = $timestamp ? date("m/d/Y", $timestamp) : '';
                        $data = $_POST;
                        $datamemberarr = array();
                        $datamemberarr =  array_merge($opts, $_POST) ; 
                        $pujafoodcouponModel->update(array_merge($opts, $_POST));
                        $value = array();
                        $value['oid'] = $datamemberarr['oid'];
                        $value['Member_id'] = $datamemberarr['member_id'];
                        $value['MemberName'] = $datamemberarr['F_Name'].' '.$datamemberarr['L_Name'];
                        $value['PaymentOption'] = $datamemberarr['PaymentOption'];
                        $value['payment_status'] = 'succeeded';
                        $value['payment_timestamp'] = $datamemberarr['payment_timestamp'] ?? '';
                        $value['Amount'] = $datamemberarr['amount'];
                        $value['stripe_return'] = $datamemberarr['stripe_return'] ?? '';
                        $value['transaction_id'] = $datamemberarr['transaction_id'];
                        $value['paid_amount'] = $datamemberarr['paid_amount'] ?? '';
                        $value['update_on'] = $datamemberarr['UpdateOn'];
                        $value['stripe_product'] = $datamemberarr['stripe_product'] ?? '';
                        $value['pay_date'] = $datamemberarr['paydate'] ?? $datamemberarr['pay_date'] ?? '';
                        $value['pay_type'] = $datamemberarr['pay_type'] ?? '';
                        $value['pay_for'] = $datamemberarr['pay_for'];
                        $value['Tele1'] = $datamemberarr['phone'];
                        $value['email'] = $datamemberarr['email'];
                        $value['City'] = $datamemberarr['City'];
                        $value['State'] = $datamemberarr['State'];
                        $value['Zip_Code'] = $datamemberarr['Zip'];
                        $value['bank'] = $datamemberarr['bankname'];
                        $value['chkno'] = $datamemberarr['checkno'];
                        $value['chkdate'] = $datamemberarr['chkdate'];
                        $value['ReceiveBy'] = $_POST['receiveby'] ?? '';
                        $DonationModel->SaveDataInDonation($value);
                        if($datamember == null) {
                            $value = array();
                            $value['MemberName'] =($_POST['F_Name'] ?? '') . ' ' . ($_POST['L_Name'] ?? '');
                            $value['Amount'] = $_POST['amount'] ?? '';
                            $value['PaymentOption'] = $_POST['PaymentOption'] ?? '';
                            $value['payment_status'] = 'confirmed';
                            $value['transaction_id'] = $_POST['checkno'] ?? '';
                            $value['Member_id'] = $_POST['member_id'] ?? '';
                            $value['pay_date'] = $_POST['paydate'] ?? '';
                            $value['oid'] = $_POST['oid'] ?? '';
                            $value['pay_type'] = $_POST['pay_type'] ?? '';
                            $value['pay_for'] = $_POST['pay_for'] ?? '';
                            $value['City'] = $_POST['City'] ?? '';
                            $value['State'] = $_POST['State'] ?? '';
                            $value['Zip_Code'] = $_POST['Zip'] ?? '';
                            $value['email'] = $_POST['email'] ?? '';
                            $value['Tele1'] = $_POST['phone'] ?? '';
                            $MemberModel->SaveDataInmember($value);
                        }
                        $datefor =$_POST['paydate'] ?? '';
                        $timestamp = !empty($datefor) ? strtotime($datefor) : false;
                        $payfinaldate = $timestamp ? date("m/d/Y", $timestamp) : '';
                        $mobileno= $data['phone'];
                          $Emailcc = 'pujaassocpayment@durgabari.org';
                             $subjetc = 'HDBS Food Coupon Payment';
                             $fullname = ($_POST['F_Name'] ?? '') . ' ' . ($_POST['L_Name'] ?? '');
                             $memberid =$_POST['member_id'] ?? '';
                             $oid = $_POST['oid'] ?? '';
                             $couponfor = $_POST['couponfor'] ?? '';
                             $coupontype = $_POST['coupontype'] ?? '';
                             $pyamentmethod = "Zelle";
                             $pyamentstatus = "Confirmed";
                             $amount = $_POST['amount'] ?? '';
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
                             <td style="text-align: center; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;"><strong>Food Coupon</strong></td>
                             </tr>
                             </tbody>
                             </table>
                             </div>
                             <div class="email-token-class" style="text-align: center;">
                             <table style="height: 190px; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;" width="604">
                             <tbody>
                             <tr>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Order Id&nbsp;&nbsp;</td>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">' . $oid . '</td>
                             </tr>
                             <tr>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Member Id&nbsp;&nbsp;</td>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $memberid . '</td>
                             </tr>
                             <tr>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Full Name&nbsp;&nbsp;</td>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $fullname . '</td>
                             </tr>
                             <tr>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Coupon Type&nbsp;&nbsp;</td>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $coupontype . '</td>
                             </tr>
                             <tr>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Payment Method&nbsp;&nbsp;</td>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' .  $pyamentmethod . '</td>
                             </tr>
                             <tr>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;"> Amount&nbsp;&nbsp;</td>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;"><span style="color:red;">$</span>' . $amount . '</td>
                             </tr>
                             <tr>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Payment Status&nbsp;&nbsp;</td>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' .  $pyamentstatus . '</td>
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
                             if (($_POST['phone'] ?? '') != null) {
                                $msg = 'Houston Durga Bari: Food Coupon confirmation are Member Id: '. $memberid.', Full Name: '. $fullname.', Coupon Type: '.$coupontype.' , Payment Method: '.$pyamentmethod.' ,Amount: $'. $amount.', Pay Date: '. $payfinaldate.',  Order Id: '. $oid.', Status: ' . $pyamentstatus  ;
                                //echo "<script>alert('$msg')</script>";
                                 $this->SendSMS($mobileno, $msg);
                                }
                             //echo '<script>alert("Data Updated Successfully")</script>';
                             Util::redirect(INSTALL_URL . "pujafoodcoupon/index"); 
                                        
                    }
                    exit();
                }
                    elseif (($_POST['PaymentOption'] ?? '') == 'check') {

                        $_POST['amount'] = $_POST['checkAmount'] ?? '';
                        $_POST['bankname'] = $_POST['checkbankname'] ?? '';
                        $_POST['chkdate'] = $_POST['CheckDate'] ?? '';
                        $_POST['pay_date'] = $_POST['CheckDate'] ?? '';
                        $_POST['Status'] = 'confirmed';
                        $_POST['payment_status'] = 'confirmed';
                        $_POST['id'] = $id;
                        $datamemberarr = array();
                        $datamemberarr = array_merge($_POST);
                        $pujafoodcouponModel->update(array_merge($_POST));

                        $value = array();
                        $value['oid'] = $datamemberarr['oid'];
                        $value['Member_id'] = $datamemberarr['member_id'];
                        $value['MemberName'] = $datamemberarr['F_Name'].' '.$datamemberarr['L_Name'];
                        $value['PaymentOption'] = $datamemberarr['PaymentOption'];
                        $value['payment_status'] = 'succeeded';
                        $value['payment_timestamp'] = $datamemberarr['payment_timestamp'] ?? '';
                        $value['Amount'] = $datamemberarr['amount'];
                        $value['stripe_return'] = $datamemberarr['stripe_return'] ?? '';
                        $value['transaction_id'] = $datamemberarr['transaction_id'];
                        $value['paid_amount'] = $datamemberarr['paid_amount'] ?? '';
                        $value['update_on'] = $datamemberarr['UpdateOn'];
                        $value['stripe_product'] = $datamemberarr['stripe_product'] ?? '';
                        $value['pay_date'] = $datamemberarr['paydate'] ?? $datamemberarr['pay_date'] ?? '';
                        $value['pay_type'] = $datamemberarr['pay_type'] ?? '';
                        $value['pay_for'] = $datamemberarr['pay_for'];
                        $value['Tele1'] = $datamemberarr['phone'];
                        $value['email'] = $datamemberarr['email'];
                        $value['City'] = $datamemberarr['City'];
                        $value['State'] = $datamemberarr['State'];
                        $value['Zip_Code'] = $datamemberarr['Zip'];
                        $value['bank'] = $datamemberarr['bankname'];
                        $value['chkno'] = $datamemberarr['checkno'];
                        $value['chkdate'] = $datamemberarr['chkdate'];
                        $DonationModel->SaveDataInDonation($value);

                        if($datamember == null) {
                            $value = array();
                            $value['MemberName'] =($_POST['F_Name'] ?? '') . ' ' . ($_POST['L_Name'] ?? '');
                            $value['Amount'] = $_POST['amount'] ?? '';
                            $value['PaymentOption'] = $_POST['PaymentOption'] ?? '';
                            $value['payment_status'] = 'confirmed';
                            $value['transaction_id'] = $_POST['checkno'] ?? '';
                            $value['Member_id'] = $_POST['member_id'] ?? '';
                            $value['pay_date'] = $_POST['paydate'] ?? '';
                            $value['oid'] = $_POST['oid'] ?? '';
                            $value['pay_type'] = $_POST['pay_type'] ?? '';
                            $value['pay_for'] = $_POST['pay_for'] ?? '';
                            $value['City'] = $_POST['City'] ?? '';
                            $value['State'] = $_POST['State'] ?? '';
                            $value['Zip_Code'] = $_POST['Zip'] ?? '';
                            $value['email'] = $_POST['email'] ?? '';
                            $value['Tele1'] = $_POST['phone'] ?? '';
                            $MemberModel->SaveDataInmember($value);
                            $this->tpl['arr'] = $pujafoodcouponModel->get($id);
                            
                        }

                        $datefor =$_POST['paydate'] ?? '';
                        $timestamp = !empty($datefor) ? strtotime($datefor) : false;
                        $payfinaldate = $timestamp ? date("m/d/Y", $timestamp) : '';
                             $subjetc = 'HDBS Food Coupon Payment';
                $fullname = ($_POST['F_Name'] ?? '') . ' ' . ($_POST['L_Name'] ?? '');
                $memberid =$_POST['member_id'] ?? '';
                $oid = $_POST['oid'] ?? '';
                $couponfor = $_POST['couponfor'] ?? '';
                $coupontype = $_POST['coupontype'] ?? '';
                $pyamentmethod = "Check";
                $pyamentstatus = "Confirmed";
                $amount = $_POST['amount'] ?? '';
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
                <td style="text-align: center; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;"><strong>Food Coupon</strong></td>
                </tr>
                </tbody>
                </table>
                </div>
                <div class="email-token-class" style="text-align: center;">
                <table style="height: 190px; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;" width="604">
                <tbody>
                <tr>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Order Id&nbsp;&nbsp;</td>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">' . $oid . '</td>
                </tr>
                <tr>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Member Id&nbsp;&nbsp;</td>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $memberid . '</td>
                </tr>
                <tr>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Full Name&nbsp;&nbsp;</td>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $fullname . '</td>
                </tr> 
                <tr>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Coupon Type&nbsp;&nbsp;</td>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $coupontype . '</td>
                </tr>
                <tr>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Payment Method&nbsp;&nbsp;</td>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' .  $pyamentmethod . '</td>
                </tr>
                <tr>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;"> Amount&nbsp;&nbsp;</td>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;"><span style="color:red;">$</span>' . $amount . '</td>
                </tr>
                <tr>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Payment Status&nbsp;&nbsp;</td>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' .  $pyamentstatus . '</td>
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
                $mobileno= $_POST['phone'] ?? '';
                            if (($_POST['phone'] ?? '') != null) {
                                $msg = 'Houston Durga Bari: Food Coupon confirmation are Member Id: '. $memberid.', Full Name: '. $fullname.', Coupon Type: '.$coupontype.' , Payment Method: '.$pyamentmethod.' ,Amount: $'. $amount.', Pay Date: '. $payfinaldate.',  Order Id: '. $oid.', Status: ' . $pyamentstatus  ;
                                //echo "<script>alert('$msg')</script>";
                                $this->SendSMS($mobileno, $msg);
                                }
                //echo '<script>alert("Data Updated Successfully")</script>';
                Util::redirect(INSTALL_URL . "pujafoodcoupon/index"); 
                             exit();
                    } 
                    elseif (($_POST['PaymentOption'] ?? '') == 'cash') {
                        $_POST['amount'] = $_POST['cashAmount'] ?? '';
                        $_POST['pay_date'] = $_POST['cashDate'] ?? '';
                        $_POST['Status'] = 'confirmed';
                        $_POST['payment_status'] = 'confirmed';
                        $_POST['id'] = $id;
                        $datamemberarr = array();
                        $datamemberarr = array_merge($_POST);
                        $pujafoodcouponModel->update(array_merge($_POST));
                        $value = array();
                        $value['oid'] = $datamemberarr['oid'];
                        $value['Member_id'] = $datamemberarr['member_id'];
                        $value['MemberName'] = $datamemberarr['F_Name'].' '.$datamemberarr['L_Name'];
                        $value['PaymentOption'] = $datamemberarr['PaymentOption'];
                        $value['payment_status'] = 'succeeded';
                        $value['payment_timestamp'] = $datamemberarr['payment_timestamp'] ?? '';
                        $value['Amount'] = $datamemberarr['amount'];
                        $value['stripe_return'] = $datamemberarr['stripe_return'] ?? '';
                        $value['transaction_id'] = $datamemberarr['transaction_id'];
                        $value['paid_amount'] = $datamemberarr['paid_amount'] ?? '';
                        $value['update_on'] = $datamemberarr['UpdateOn'];
                        $value['stripe_product'] = $datamemberarr['stripe_product'] ?? '';
                        $value['pay_date'] = $datamemberarr['paydate'] ?? $datamemberarr['pay_date'] ?? '';
                        $value['pay_type'] = $datamemberarr['pay_type'] ?? '';
                        $value['pay_for'] = $datamemberarr['pay_for'];
                        $value['Tele1'] = $datamemberarr['phone'];
                        $value['email'] = $datamemberarr['email'];
                        $value['City'] = $datamemberarr['City'];
                        $value['State'] = $datamemberarr['State'];
                        $value['Zip_Code'] = $datamemberarr['Zip'];
                        $value['bank'] = $datamemberarr['bankname'];
                        $value['chkno'] = $datamemberarr['checkno'];
                        $value['chkdate'] = $datamemberarr['chkdate'];
                        $value['ReceiveBy'] = $_POST['receiveby'] ?? '';
                        $DonationModel->SaveDataInDonation($value);
                        if($datamember == null) {
                            $value = array();
                            $value['MemberName'] =($_POST['F_Name'] ?? '') . ' ' . ($_POST['L_Name'] ?? '');
                            $value['Amount'] = $_POST['amount'] ?? '';
                            $value['PaymentOption'] = $_POST['PaymentOption'] ?? '';
                            $value['payment_status'] = 'confirmed';
                            $value['transaction_id'] = $_POST['checkno'] ?? '';
                            $value['Member_id'] = $_POST['member_id'] ?? '';
                            $value['pay_date'] = $_POST['paydate'] ?? '';
                            $value['oid'] = $_POST['oid'] ?? '';
                            $value['pay_type'] = $_POST['pay_type'] ?? '';
                            $value['pay_for'] = $_POST['pay_for'] ?? '';
                            $value['City'] = $_POST['City'] ?? '';
                            $value['State'] = $_POST['State'] ?? '';
                            $value['Zip_Code'] = $_POST['Zip'] ?? '';
                            $value['email'] = $_POST['email'] ?? '';
                            $value['Tele1'] = $_POST['phone'] ?? '';
                            $MemberModel->SaveDataInmember($value);
                        }
                        $datefor =$_POST['paydate'] ?? '';
                        $timestamp = !empty($datefor) ? strtotime($datefor) : false;
                        $payfinaldate = $timestamp ? date("m/d/Y", $timestamp) : '';
                        
                             $subjetc = 'HDBS Food Coupon Payment';
                             $fullname = ($_POST['F_Name'] ?? '') . ' ' . ($_POST['L_Name'] ?? '');
                             $memberid =$_POST['member_id'] ?? '';
                             $oid = $_POST['oid'] ?? '';
                             $couponfor = $_POST['couponfor'] ?? '';
                             $coupontype = $_POST['coupontype'] ?? '';
                             $pyamentmethod = "Cash";
                             $pyamentstatus = "Confirmed";
                             $amount = $_POST['amount'] ?? '';
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
                             <td style="text-align: center; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;"><strong>Food Coupon</strong></td>
                             </tr>
                             </tbody>
                             </table>
                             </div>
                             <div class="email-token-class" style="text-align: center;">
                             <table style="height: 190px; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;" width="604">
                             <tbody>
                             <tr>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Order Id&nbsp;&nbsp;</td>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">' . $oid . '</td>
                             </tr>
                             <tr>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Member Id&nbsp;&nbsp;</td>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $memberid . '</td>
                             </tr>
                             <tr>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Full Name&nbsp;&nbsp;</td>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $fullname . '</td>
                             </tr>
                             <tr>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Coupon Type&nbsp;&nbsp;</td>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $coupontype . '</td>
                             </tr>
                             <tr>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Payment Method&nbsp;&nbsp;</td>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' .  $pyamentmethod . '</td>
                             </tr>
                             <tr>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;"> Amount&nbsp;&nbsp;</td>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;"><span style="color:red;">$</span>' . $amount . '</td>
                             </tr>
                             <tr>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Payment Status&nbsp;&nbsp;</td>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' .  $pyamentstatus . '</td>
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
                             $mobileno= $_POST['phone'] ?? '';
                            if (($_POST['phone'] ?? '') != null) {
                                $msg = 'Houston Durga Bari: Food Coupon confirmation are Member Id: '. $memberid.', Full Name: '. $fullname.', Coupon Type: '.$coupontype.' , Payment Method: '.$pyamentmethod.' ,Amount: $'. $amount.', Pay Date: '. $payfinaldate.',  Order Id: '. $oid.', Status: ' . $pyamentstatus  ;
                                //echo "<script>alert('$msg')</script>";
                                 $this->SendSMS($mobileno, $msg);
                                }
                             //echo '<script>alert("Data Updated Successfully")</script>';
                             Util::redirect(INSTALL_URL . "pujafoodcoupon/index"); 
                            exit();
             
                    }
                     elseif (($_POST['PaymentOption'] ?? '') == 'directdeposit') {
                        $_POST['bankname'] = $_POST['BankName'] ?? '';
                        $_POST['pay_date'] = $_POST['transactiondate'] ?? '';
                        $_POST['transaction_id'] = $_POST['ISFCCode'] ?? '';
                        $_POST['amount'] = $_POST['directamount'] ?? '';
                        $_POST['Status'] = 'confirmed';
                        $_POST['payment_status'] = 'confirmed';
                        $_POST['id'] = $id;
                        $datamemberarr = array();
                        $datamemberarr = array_merge($_POST);
                        $pujafoodcouponModel->update(array_merge($_POST));
                        $value = array();
                        $value['oid'] = $datamemberarr['oid'];
                        $value['Member_id'] = $datamemberarr['member_id'];
                        $value['MemberName'] = $datamemberarr['F_Name'].' '.$datamemberarr['L_Name'];
                        $value['PaymentOption'] = $datamemberarr['PaymentOption'];
                        $value['payment_status'] = 'succeeded';
                        $value['payment_timestamp'] = $datamemberarr['payment_timestamp'] ?? '';
                        $value['Amount'] = $datamemberarr['amount'];
                        $value['stripe_return'] = $datamemberarr['stripe_return'] ?? '';
                        $value['transaction_id'] = $datamemberarr['transaction_id'];
                        $value['paid_amount'] = $datamemberarr['paid_amount'] ?? '';
                        $value['update_on'] = $datamemberarr['UpdateOn'];
                        $value['stripe_product'] = $datamemberarr['stripe_product'] ?? '';
                        $value['pay_date'] = $datamemberarr['paydate'] ?? $datamemberarr['pay_date'] ?? '';
                        $value['pay_type'] = $datamemberarr['pay_type'] ?? '';
                        $value['pay_for'] = $datamemberarr['pay_for'];
                        $value['Tele1'] = $datamemberarr['phone'];
                        $value['email'] = $datamemberarr['email'];
                        $value['City'] = $datamemberarr['City'];
                        $value['State'] = $datamemberarr['State'];
                        $value['Zip_Code'] = $datamemberarr['Zip'];
                        $value['bank'] = $datamemberarr['bankname'];
                        $value['chkno'] = $datamemberarr['checkno'];
                        $value['chkdate'] = $datamemberarr['chkdate'];
                        $value['ReceiveBy'] = $_POST['receiveby'] ?? '';
                        $DonationModel->SaveDataInDonation($value);
                        if($datamember == null) {
                            $value = array();
                            $value['MemberName'] =($_POST['F_Name'] ?? '') . ' ' . ($_POST['L_Name'] ?? '');
                            $value['Amount'] = $_POST['amount'] ?? '';
                            $value['PaymentOption'] = $_POST['PaymentOption'] ?? '';
                            $value['payment_status'] = 'confirmed';
                            $value['transaction_id'] = $_POST['checkno'] ?? '';
                            $value['Member_id'] = $_POST['member_id'] ?? '';
                            $value['pay_date'] = $_POST['paydate'] ?? '';
                            $value['oid'] = $_POST['oid'] ?? '';
                            $value['pay_type'] = $_POST['pay_type'] ?? '';
                            $value['pay_for'] = $_POST['pay_for'] ?? '';
                            $value['City'] = $_POST['City'] ?? '';
                            $value['State'] = $_POST['State'] ?? '';
                            $value['Zip_Code'] = $_POST['Zip'] ?? '';
                            $value['email'] = $_POST['email'] ?? '';
                            $value['Tele1'] = $_POST['phone'] ?? '';
                            $MemberModel->SaveDataInmember($value);
                        }
                        $datefor =$_POST['paydate'] ?? '';
                        $timestamp = !empty($datefor) ? strtotime($datefor) : false;
                        $payfinaldate = $timestamp ? date("m/d/Y", $timestamp) : '';
                        $mobileno= $data['phone'];
                             $subjetc = 'HDBS Food Coupon Payment';
                             $fullname = ($_POST['F_Name'] ?? '') . ' ' . ($_POST['L_Name'] ?? '');
                             $memberid =$_POST['member_id'] ?? '';
                             $oid = $_POST['oid'] ?? '';
                             $couponfor = $_POST['couponfor'] ?? '';
                             $coupontype = $_POST['coupontype'] ?? '';
                             $pyamentmethod = "Direct Deposite";
                             $pyamentstatus = "Confirmed";
                             $amount = $_POST['amount'] ?? '';
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
                             <td style="text-align: center; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;"><strong>Food Coupon</strong></td>
                             </tr>
                             </tbody>
                             </table>
                             </div>
                             <div class="email-token-class" style="text-align: center;">
                             <table style="height: 190px; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;" width="604">
                             <tbody>
                             <tr>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Order Id&nbsp;&nbsp;</td>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">' . $oid . '</td>
                             </tr>
                             <tr>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Member Id&nbsp;&nbsp;</td>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $memberid . '</td>
                             </tr>
                             <tr>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Full Name&nbsp;&nbsp;</td>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $fullname . '</td>
                             </tr>
                             <tr>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Coupon Type&nbsp;&nbsp;</td>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $coupontype . '</td>
                             </tr>
                             <tr>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Payment Method&nbsp;&nbsp;</td>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' .  $pyamentmethod . '</td>
                             </tr>
                             <tr>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;"> Amount&nbsp;&nbsp;</td>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;"><span style="color:red;">$</span>' . $amount . '</td>
                             </tr>
                             <tr>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Payment Status&nbsp;&nbsp;</td>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' .  $pyamentstatus . '</td>
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
                             $mobileno= $_POST['phone'] ?? '';
                            if (($_POST['phone'] ?? '') != null) {
                                $msg = 'Houston Durga Bari: Food Coupon confirmation are Member Id: '. $memberid.', Full Name: '. $fullname.', Coupon Type: '.$coupontype.' , Payment Method: '.$pyamentmethod.' ,Amount: $'. $amount.', Pay Date: '. $payfinaldate.',  Order Id: '. $oid.', Status: ' . $pyamentstatus  ;
                                //echo "<script>alert('$msg')</script>";
                                 $this->SendSMS($mobileno, $msg);
                                }
                             //echo '<script>alert("Data Updated Successfully")</script>';
                             Util::redirect(INSTALL_URL . "pujafoodcoupon/index"); 
                                          exit();
                    }
                    elseif (($_POST['PaymentOption'] ?? '') == 'sumup') {
                        $_POST['pay_date'] = $_POST['sumupdate'] ?? '';
                        $_POST['transaction_id'] = $_POST['sumupid'] ?? '';
                        $_POST['amount'] = $_POST['sumupamount'] ?? '';
                        $_POST['Status'] = 'confirmed';
                        $_POST['payment_status'] = 'confirmed';
                        $_POST['id'] = $id;
                        $datamemberarr = array();
                        $datamemberarr = array_merge($_POST);
                        $pujafoodcouponModel->update(array_merge($_POST));
                        $value = array();
                        $value['oid'] = $datamemberarr['oid'];
                        $value['Member_id'] = $datamemberarr['member_id'];
                        $value['MemberName'] = $datamemberarr['F_Name'].' '.$datamemberarr['L_Name'];
                        $value['PaymentOption'] = $datamemberarr['PaymentOption'];
                        $value['payment_status'] = 'succeeded';
                        $value['payment_timestamp'] = $datamemberarr['payment_timestamp'] ?? '';
                        $value['Amount'] = $datamemberarr['amount'];
                        $value['stripe_return'] = $datamemberarr['stripe_return'] ?? '';
                        $value['transaction_id'] = $datamemberarr['transaction_id'];
                        $value['paid_amount'] = $datamemberarr['paid_amount'] ?? '';
                        $value['update_on'] = $datamemberarr['UpdateOn'];
                        $value['stripe_product'] = $datamemberarr['stripe_product'] ?? '';
                        $value['pay_date'] = $datamemberarr['paydate'] ?? $datamemberarr['pay_date'] ?? '';
                        $value['pay_type'] = $datamemberarr['pay_type'] ?? '';
                        $value['pay_for'] = $datamemberarr['pay_for'];
                        $value['Tele1'] = $datamemberarr['phone'];
                        $value['email'] = $datamemberarr['email'];
                        $value['City'] = $datamemberarr['City'];
                        $value['State'] = $datamemberarr['State'];
                        $value['Zip_Code'] = $datamemberarr['Zip'];
                        $value['bank'] = $datamemberarr['bankname'];
                        $value['chkno'] = $datamemberarr['checkno'];
                        $value['chkdate'] = $datamemberarr['chkdate'];
                        $value['ReceiveBy'] = $_POST['receiveby'] ?? '';
                        $DonationModel->SaveDataInDonation($value);
                        if($datamember == null) {
                            $value = array();
                            $value['MemberName'] =($_POST['F_Name'] ?? '') . ' ' . ($_POST['L_Name'] ?? '');
                            $value['Amount'] = $_POST['amount'] ?? '';
                            $value['PaymentOption'] = $_POST['PaymentOption'] ?? '';
                            $value['payment_status'] = 'confirmed';
                            $value['transaction_id'] = $_POST['checkno'] ?? '';
                            $value['Member_id'] = $_POST['member_id'] ?? '';
                            $value['pay_date'] = $_POST['paydate'] ?? '';
                            $value['oid'] = $_POST['oid'] ?? '';
                            $value['pay_type'] = $_POST['pay_type'] ?? '';
                            $value['pay_for'] = $_POST['pay_for'] ?? '';
                            $value['City'] = $_POST['City'] ?? '';
                            $value['State'] = $_POST['State'] ?? '';
                            $value['Zip_Code'] = $_POST['Zip'] ?? '';
                            $value['email'] = $_POST['email'] ?? '';
                            $value['Tele1'] = $_POST['phone'] ?? '';
                            $MemberModel->SaveDataInmember($value);
                        }
                        $datefor =$_POST['paydate'] ?? '';
                        $timestamp = !empty($datefor) ? strtotime($datefor) : false;
                        $payfinaldate = $timestamp ? date("m/d/Y", $timestamp) : '';
                        $mobileno= $data['phone'];
                             $subjetc = 'HDBS Food Coupon Payment';
                             $fullname = ($_POST['F_Name'] ?? '') . ' ' . ($_POST['L_Name'] ?? '');
                             $memberid =$_POST['member_id'] ?? '';
                             $oid = $_POST['oid'] ?? '';
                             $couponfor = $_POST['couponfor'] ?? '';
                             $coupontype = $_POST['coupontype'] ?? '';
                             $pyamentmethod = "SumUp";
                             $pyamentstatus = "Confirmed";
                             $amount = $_POST['amount'] ?? '';
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
                             <td style="text-align: center; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;"><strong>Food Coupon</strong></td>
                             </tr>
                             </tbody>
                             </table>
                             </div>
                             <div class="email-token-class" style="text-align: center;">
                             <table style="height: 190px; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;" width="604">
                             <tbody>
                             <tr>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Order Id&nbsp;&nbsp;</td>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">' . $oid . '</td>
                             </tr>
                             <tr>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Member Id&nbsp;&nbsp;</td>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $memberid . '</td>
                             </tr>
                             <tr>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Full Name&nbsp;&nbsp;</td>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $fullname . '</td>
                             </tr>
                             <tr>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Coupon Type&nbsp;&nbsp;</td>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $coupontype . '</td>
                             </tr>
                             <tr>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Payment Method&nbsp;&nbsp;</td>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' .  $pyamentmethod . '</td>
                             </tr>
                             <tr>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;"> Amount&nbsp;&nbsp;</td>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;"><span style="color:red;">$</span>' . $amount . '</td>
                             </tr>
                             <tr>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Payment Status&nbsp;&nbsp;</td>
                             <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' .  $pyamentstatus . '</td>
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
                             $mobileno= $_POST['phone'] ?? '';
                            if (($_POST['phone'] ?? '') != null) {
                                $msg = 'Houston Durga Bari: Food Coupon confirmation are Member Id: '. $memberid.', Full Name: '. $fullname.', Coupon Type: '.$coupontype.' , Payment Method: '.$pyamentmethod.' ,Amount: $'. $amount.', Pay Date: '. $payfinaldate.',  Order Id: '. $oid.', Status: ' . $pyamentstatus  ;
                                //echo "<script>alert('$msg')</script>";
                                 $this->SendSMS($mobileno, $msg);
                                }
                             //echo '<script>alert("Data Updated Successfully")</script>';
                             Util::redirect(INSTALL_URL . "pujafoodcoupon/index"); 
                                          exit();
                    }
                elseif (($_POST['PaymentOption'] ?? '') == 'stripe') {

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

                        $payment = Stripe_Charge::create(array(
                                     "amount" => $amount,
                                     "currency" => "USD",
                                    //  "currency" => $this->tpl["option_arr_values"]["currency"],
                                     "card" => $_POST['stripeToken'] ?? '',
                                     "description" =>  "Pay For:" . ($_POST['pay_type'] ?? '') . ', ' . "Email:" . ($_POST['email'] ?? '') . ', ' . "Full Name:" . ($_POST['F_Name'] ?? '') . ' ' . ($_POST['L_Name'] ?? ''),
                                     "metadata" => ["orderid" => $oid]
                        ));

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
                            //$opts['payment_status'] = 'confirmed';
                            $opts['payment_status'] = 'confirmed';
                            $opts['Status'] = 'confirmed';
                            $opts['payment_timestamp'] = time();

                            $data = $_POST;
                           $datamemberarr = array();
                           $datamemberarr =  array_merge($opts, $_POST) ; 
                           $pujafoodcouponModel->update(array_merge($opts, $_POST));
                           $value = array();
                           $value['oid'] = $datamemberarr['oid'];
                           $value['Member_id'] = $datamemberarr['member_id'];
                           $value['MemberName'] = $datamemberarr['F_Name'].' '.$datamemberarr['L_Name'];
                           $value['PaymentOption'] = $datamemberarr['PaymentOption'];
                           $value['payment_status'] = 'succeeded';
                           $value['payment_timestamp'] = $datamemberarr['payment_timestamp'] ?? '';
                           $value['Amount'] = $datamemberarr['amount'];
                           $value['stripe_return'] = $datamemberarr['stripe_return'] ?? '';
                           $value['transaction_id'] = $datamemberarr['transaction_id'];
                           $value['paid_amount'] = $datamemberarr['paid_amount'] ?? '';
                           $value['update_on'] = $datamemberarr['UpdateOn'] ?? '';
                           $value['stripe_product'] = $datamemberarr['stripe_product'] ?? '';
                           $value['pay_date'] = $datamemberarr['paydate'] ?? $datamemberarr['pay_date'] ?? '';
                           $value['pay_type'] = $datamemberarr['paydate'] ?? '';
                           $value['pay_for'] = $datamemberarr['pay_for'] ?? '';
                           $value['Tele1'] = $datamemberarr['phone'] ?? '';
                           $value['email'] = $datamemberarr['email'] ?? '';
                           $value['City'] = $datamemberarr['City'] ?? '';
                           $value['State'] = $datamemberarr['State'] ?? '';
                           $value['Zip_Code'] = $datamemberarr['Zip'] ?? '';
                           $value['bank'] = $datamemberarr['bankname'] ?? '';
                           $value['chkno'] = $datamemberarr['checkno'] ?? '';
                           $value['chkdate'] = $datamemberarr['chkdate'] ?? '';
                           $value['ReceiveBy'] = $_POST['receiveby'] ?? '';
                           $DonationModel->SaveDataInDonation($value);
                           if($datamember == null) {
                               $value = array();
                               $value['MemberName'] =($_POST['F_Name'] ?? '') . ' ' . ($_POST['L_Name'] ?? '');
                               $value['Amount'] = $_POST['amount'] ?? '';
                               $value['PaymentOption'] = $_POST['PaymentOption'] ?? '';
                               $value['payment_status'] = 'confirmed';
                               $value['transaction_id'] = $_POST['checkno'] ?? '';
                               $value['Member_id'] = $_POST['member_id'] ?? '';
                               $value['pay_date'] = $_POST['paydate'] ?? '';
                               $value['oid'] = $_POST['oid'] ?? '';
                               $value['pay_type'] = $_POST['pay_type'] ?? '';
                               $value['pay_for'] = $_POST['pay_for'] ?? '';
                               $value['City'] = $_POST['City'] ?? '';
                               $value['State'] = $_POST['State'] ?? '';
                               $value['Zip_Code'] = $_POST['Zip'] ?? '';
                               $value['email'] = $_POST['email'] ?? '';
                               $value['Tele1'] = $_POST['phone'] ?? '';
                               $MemberModel->SaveDataInmember($value);
                           }
                           $datefor =$_POST['paydate'] ?? '';
                           $timestamp = !empty($datefor) ? strtotime($datefor) : false;
                           $payfinaldate = $timestamp ? date("m/d/Y", $timestamp) : '';
                           
                            $this->tpl['arr'] = $pujafoodcouponModel->get($id);
                            $Emailcc = 'pujaassocpayment@durgabari.org';
                            $subjetc = 'HDBS Food Coupon Payment';
                            $fullname = ($_POST['F_Name'] ?? '') . ' ' . ($_POST['L_Name'] ?? '');
                            $memberid =$_POST['member_id'] ?? '';
                            $oid = $_POST['oid'] ?? '';
                            $couponfor = $_POST['couponfor'] ?? '';
                            $coupontype = $_POST['coupontype'] ?? '';
                            $pyamentmethod = "Credit Card";
                            $pyamentstatus = "Confirmed";
                            $amount = $_POST['amount'] ?? '';
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
                            <td style="text-align: center; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;"><strong>Food Coupon</strong></td>
                            </tr>
                            </tbody>
                            </table>
                            </div>
                            <div class="email-token-class" style="text-align: center;">
                            <table style="height: 190px; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;" width="604">
                            <tbody>
                            <tr>
                            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Order Id&nbsp;&nbsp;</td>
                            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">' . $oid . '</td>
                            </tr>
                            <tr>
                            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Member Id&nbsp;&nbsp;</td>
                            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $memberid . '</td>
                            </tr>
                            <tr>
                            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Full Name&nbsp;&nbsp;</td>
                            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $fullname . '</td>
                            </tr>
                            <tr>
                            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Coupon Type&nbsp;&nbsp;</td>
                            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $coupontype . '</td>
                            </tr>
                            <tr>
                            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Payment Method&nbsp;&nbsp;</td>
                            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' .  $pyamentmethod . '</td>
                            </tr>
                            <tr>
                            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;"> Amount&nbsp;&nbsp;</td>
                            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;"><span style="color:red;">$</span>' . $amount . '</td>
                            </tr>
                            <tr>
                            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Payment Status&nbsp;&nbsp;</td>
                            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' .  $pyamentstatus . '</td>
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
                            $mobileno= $_POST['phone'] ?? '';
                            if (($_POST['phone'] ?? '') != null) {
                                $msg = 'Houston Durga Bari: Food Coupon confirmation are Member Id: '. $memberid.', Full Name: '. $fullname.', Coupon Type: '.$coupontype.' , Payment Method: '.$pyamentmethod.' ,Amount: $'. $amount.', Pay Date: '. $payfinaldate.',  Order Id: '. $oid.', Status: ' . $pyamentstatus  ;
                                //echo "<script>alert('$msg')</script>";
                                 $this->SendSMS($mobileno, $msg);
                                }
                            //echo '<script>alert("Data Updated Successfully")</script>';
                            Util::redirect(INSTALL_URL . "pujafoodcoupon/index"); 
                        exit();
            
                        } else {

                            $opts = array();
                            $opts['id'] = $id;
                            $opts['stripe_return'] = $payment->status;
                            $opts['transaction_id'] = $payment->id;
                            $opts['paid_amount'] = $payment->amount;
                            $opts['stripe_product'] = $payment->description;

                            $pujafoodcouponModel->update($opts);

                            $_SESSION['status'] = '<strong>' . __('declined_card') . '</strong>';
                        }
                    } catch (Exception $ex) {
                        $_SESSION['status'] = $ex->getMessage();
                    }
                    
                    $this->tpl['arr'] = $pujafoodcouponModel->get($id);
                    $this->tpl['arr']['amount'] = $total;
                }
                
                else{
                     $_SESSION['status'] = 16;
                   
                }
            } else {
                $_SESSION['status'] = 17;
            }
        //    exit();
           
           // Util::redirect(INSTALL_URL . "foodcoupondata/index");
        }
      
}
   


    function index()
    {
        GzObject::loadFiles('Model', array('pujafoodcoupon','foodcouponprice', 'FoodCouponTotalReport', 'FoodCouponSessionName'));
        $pujafoodcouponModel =  new pujafoodcouponModel();
        $foodcouponpriceModel = new foodcouponpriceModel();
        $FoodCouponTotalReportModel = new FoodCouponTotalReportModel();
        $FoodCouponSessionName = new FoodCouponSessionName();
    

        $opts = array();
        $arr = $pujafoodcouponModel->getCouponRecord($opts);
        $this->tpl['arr'] = $arr;


        $foodcouponpricearr = $foodcouponpriceModel->getall($opts);
        $this->tpl['foodcouponpricearr'] = $foodcouponpricearr;
 
        date_default_timezone_set("America/Chicago");
        $today = date("m/d/Y"); 
        $couponReportarr= $FoodCouponTotalReportModel->getall($opts);
        foreach ($couponReportarr as &$item) {
            $item['currentDate'] = $today; 
        }
        
        $ActiveSessionarr = $FoodCouponSessionName->getFoodCouponSession();
        $SessionActive = $ActiveSessionarr[0]['sessionName'];
        foreach ($couponReportarr as &$item) {
            $item['ActiveSession'] = $SessionActive; 
        }
        $this->tpl['couponReportarr'] = $couponReportarr;
        
        $sessionCodes = $FoodCouponSessionName->getall($opts);
        $this->tpl['sessionCodes'] = $sessionCodes;
    }

    

// function for create sankalpa  puja price admin end. 
function foodcouponpricecreate(){
    GzObject::loadFiles('Model', array('foodcouponprice'));
    $foodcouponpriceModel = new foodcouponpriceModel();

    if (!empty($_POST['foodcouponpricecreate'])) {

        $id = $foodcouponpriceModel->save(array_merge($_POST));

        if (!empty($id)) {
            $_SESSION['status'] = 16;
        } else {
            $_SESSION['status'] = 17;
        }
        Util::redirect(INSTALL_URL . "pujafoodcoupon/index");
    }

}

function foodcouponpriceedit(){
    GzObject::loadFiles('Model', array('foodcouponprice'));
    $foodcouponpriceModel = new foodcouponpriceModel();

    if (!empty($_POST['priestpriceedit'])) {

        $data = array();
        $id = $foodcouponpriceModel->update(array_merge($_POST));

        if (!empty($id)) {
            $_SESSION['status'] = 20;
        } else {
            $_SESSION['status'] = 21;
        }

        if (!$this->isAdmin()) {
            Util::redirect(INSTALL_URL . "Admin/dashboard");
        } else {
            Util::redirect(INSTALL_URL . "pujafoodcoupon/index");
        }
    }
    $id = $_GET['id'] ?? '';
    $pricearr = $foodcouponpriceModel->get($id);
    $this->tpl['pricearr'] = $pricearr;

}

function delete()
    {
        $this->isAjax = true;
        $id = ($_REQUEST['id'] ?? '');
        $cat = ($_REQUEST['cat'] ?? '');

        GzObject::loadFiles('Model', array('pujafoodcoupon', 'foodcouponprice', 'FoodCouponSessionName'));
        $pujafoodcouponModel = new pujafoodcouponModel();
        $foodcouponpriceModel = new foodcouponpriceModel();
        $FoodCouponSessionName = new FoodCouponSessionName();
        if ($cat == 1) {
            $pujafoodcouponModel->deleteFrom($pujafoodcouponModel->getTable())
                ->where('id', $id)->execute();
        }
        if ($cat == 2) {
            $foodcouponpriceModel->deleteFrom($foodcouponpriceModel->getTable())
                ->where('id', $id)->execute();
        }
        
        if ($cat == 3) {
            $FoodCouponSessionName->deleteFrom($FoodCouponSessionName->getTable())
                ->where("id", $id)->execute();
        }

        $opts = array();
        Util::redirect(INSTALL_URL . "pujafoodcoupon/index");

    }

   public function export()
    {
        $this->setIsAjax(true);
        GzObject::loadFiles('Model', array('pujafoodcoupon'));
        $pujafoodcouponModel =  new pujafoodcouponModel();   

        $opts = array();
        $data = $pujafoodcouponModel->getAlldata($opts);
       
        date_default_timezone_set("America/Chicago");
        $filename = "Puja_Food_Coupon" . date("m-d-Y") . ".csv";

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

 function editPaymentPage()
    {
        GzObject::loadFiles('Model', array('pujafoodcoupon', 'foodcouponprice', 'ConfirmCode', 'Member', 'Donation', 'idnumbers', 'FoodCouponSessionName'));
        $pujafoodcouponModel = new pujafoodcouponModel();
        $ConfirmCodeModel = new ConfirmCodeModel();
        $MemberModel = new MemberModel();
        $idnumbersModel = new idnumbersModel();
        $DonationModel = new DonationModel();
        $ConfirmCodeModel = new ConfirmCodeModel();
        $foodcouponpriceModel = new foodcouponpriceModel();
        $FoodCouponSessionName = new FoodCouponSessionName();
        $opts = array();
        $foodcouponpricearr = $foodcouponpriceModel->getall($opts);
        $this->tpl['foodcouponpricearr'] = $foodcouponpricearr;

        $arr = $FoodCouponSessionName->getFoodCouponSession($opts);
        $this->tpl['foodcoupon'] = $arr;
    
        if (!empty($_POST['foodcoupon_payment'])) {

            $data = array();
            $id = $_POST['id'] ?? '';
            date_default_timezone_set("America/Chicago");
            $today = date("Y/m/d");
            $_POST['paydate'] = $today;
            $_POST['pay_type'] = 'Food Coupon';
            $_POST['pay_for'] = $_POST['coupontype'] ?? '';
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
                $_POST['member_id'] = $maxid;
                $_POST['membercategory'] = 'GC';
                // end generate memberid for gd 
            }
            if ($datamember != null) {
                $_POST['member_id'] = $datamember;
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
            $categorymember = $_POST['membercategory'] ?? '';
            
             ////email body msg 
            $Emailcc = 'pujaassocpayment@durgabari.org';
            $subjetc = 'HDBS Food Coupon Payment';
            $fullname = ($_POST['F_Name'] ?? '') . ' ' . ($_POST['L_Name'] ?? '');
            $memberid = $_POST['member_id'] ?? '';
            $oid = $_POST['oid'] ?? '';
            $couponfor = $_POST['couponfor'] ?? '';
            $coupontype = $_POST['coupontype'] ?? '';
            $pyamentstatus = "Confirmed";
            $amount = $_POST['amount'] ?? '';
            $sessionName = $_POST['sessionName'] ?? '';
            $SessionCode = $_POST['sessionCode'] ?? '';
            $paymethod = $_POST['PaymentOption'] ?? '';
            // POST se values le rahe hain
              $number_of_adult_coupon = isset($_POST['number_of_adult_coupon']) ? $_POST['number_of_adult_coupon'] ?? '' : null;
              $number_of_adult_outsourced_coupon = isset($_POST['number_of_adult_outsourced_coupon']) ? $_POST['number_of_adult_outsourced_coupon'] ?? '' : null;
              $number_of_adult_special_coupon = isset($_POST['number_of_adult_special_coupon']) ? $_POST['number_of_adult_special_coupon'] ?? '' : null;

                // Null ya empty string ko 0 se replace karna
               $number_of_adult_coupon = $number_of_adult_coupon ?: 0;
               $number_of_adult_outsourced_coupon = $number_of_adult_outsourced_coupon ?: 0;
               $number_of_adult_special_coupon = $number_of_adult_special_coupon ?: 0;

                // Total ka sum
               $adultCouponTotal = $number_of_adult_coupon + $number_of_adult_outsourced_coupon + $number_of_adult_special_coupon;

                // POST se values le rahe hain
                $number_of_kid_coupon = isset($_POST['number_of_kid_coupon']) ? $_POST['number_of_kid_coupon'] ?? '' : null;
                $number_of_kid_outsourced_coupon = isset($_POST['number_of_kid_outsourced_coupon']) ? $_POST['number_of_kid_outsourced_coupon'] ?? '' : null;
                $number_of_kid_special_coupon = isset($_POST['number_of_kid_special_coupon']) ? $_POST['number_of_kid_special_coupon'] ?? '' : null;

                    // Null ya empty string ko 0 se replace karna
                $number_of_kid_coupon = $number_of_kid_coupon ?: 0;
                $number_of_kid_outsourced_coupon = $number_of_kid_outsourced_coupon ?: 0;
                $number_of_kid_special_coupon = $number_of_kid_special_coupon ?: 0;

                    // Total ka sum
                $childCouponTotal = $number_of_kid_coupon + $number_of_kid_outsourced_coupon + $number_of_kid_special_coupon;

            if($paymethod == "others"){ $payui = 'Zelle';}
            else if($paymethod == "check"){$payui = 'Check';}
            else if($paymethod == "cash"){$payui = 'Cash';}
            else if($paymethod == "directdeposit"){$payui = 'Online Deposit';}
            else if($paymethod == "sumup"){$payui = 'SumUp';}
            else if($paymethod == "stripe"){$payui = 'Credit Card';}
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
            <td style="text-align: center; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;"><strong>Food Coupon</strong></td>
            </tr>
            </tbody>
            </table>
            </div>
            <div class="email-token-class" style="text-align: center;">
            <table style="height: 190px; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;" width="604">
            <tbody>
            <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Order Id&nbsp;&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">' . $oid . '</td>
            </tr>
            <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Member Id&nbsp;&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $memberid . '</td>
            </tr>
            <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Full Name&nbsp;&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $fullname . '</td>
            </tr>
            <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Coupon Type&nbsp;&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $coupontype . '</td>
            </tr>
            <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;"> Food Coupon&nbsp;&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $sessionName . '</td>
            </tr>
            <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Coupon Code&nbsp;&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' .  $SessionCode . '</td>
            </tr>';
           if ($childCouponTotal > 0) {
                $message .='<tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Kid Coupon&nbsp;&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $childCouponTotal . '</td>
            </tr>';}
           if ($adultCouponTotal > 0) {
                $message .='<tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Adult Coupon&nbsp;&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $adultCouponTotal . '</td>
            </tr>';}
           $message .='
            <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;"> Amount&nbsp;&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;"><span style="color:red;">$</span>' . $amount . '</td>
            </tr>
            <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Payment Method&nbsp;&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $payui . '</td>
            </tr>
            <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Payment Status&nbsp;&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $pyamentstatus . '</td>
            </tr>
            <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Pay Date&nbsp;&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . ($_POST['paydate'] ?? '') . '</td>
            </tr>
            </tbody>
            </table>
            </div>
            </div>
            </div>';

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
                    $opts = array();
                    $opts['id'] = $id;
                    $opts['payment_status'] = 'confirmed';
                    $_POST['Status'] = 'confirmed';
                    $data = $_POST;

                    $datefor = $_POST['paydate'] ?? '';
                    $timestamp = !empty($datefor) ? strtotime($datefor) : false;
                    $payfinaldate = $timestamp ? date("m/d/Y", $timestamp) : '';
                    $data = $_POST;
                    $datamemberarr = array();
                    $datamemberarr = array_merge($opts, $_POST);
                    $pujafoodcouponModel->update(array_merge($opts, $_POST, $data));
                    $value = array();
                    $value['oid'] = $datamemberarr['oid'];
                    $value['Member_id'] = $datamemberarr['member_id'];
                    $value['MemberName'] = $datamemberarr['F_Name'] . ' ' . $datamemberarr['L_Name'];
                    $value['PaymentOption'] = $datamemberarr['PaymentOption'];
                    $value['payment_status'] = 'succeeded';
                    $value['payment_timestamp'] = $datamemberarr['payment_timestamp'] ?? '';
                    $value['Amount'] = $datamemberarr['amount'];
                    $value['stripe_return'] = $datamemberarr['stripe_return'] ?? '';
                    $value['transaction_id'] = $datamemberarr['transaction_id'];
                    $value['paid_amount'] = $datamemberarr['paid_amount'] ?? '';
                    $value['update_on'] = $datamemberarr['UpdateOn'];
                    $value['stripe_product'] = $datamemberarr['stripe_product'] ?? '';
                    $value['pay_date'] = $datamemberarr['paydate'] ?? $datamemberarr['pay_date'] ?? '';
                    $value['pay_type'] = $datamemberarr['pay_type'] ?? '';
                    $value['pay_for'] = $datamemberarr['pay_for'];
                    $value['Tele1'] = $datamemberarr['phone'];
                    $value['email'] = $datamemberarr['email'];
                    $value['City'] = $datamemberarr['City'];
                    $value['State'] = $datamemberarr['State'];
                    $value['Zip_Code'] = $datamemberarr['Zip'];
                    $value['bank'] = $datamemberarr['bankname'];
                    $value['chkno'] = $datamemberarr['checkno'];
                    $value['chkdate'] = $datamemberarr['chkdate'];
                    $value['ReceiveBy'] = $_POST['receiveby'] ?? '';
                    $DonationModel->SaveDataInDonation($value);
                    if ($datamember == null) {
                        $value = array();
                        $value['MemberName'] = ($_POST['F_Name'] ?? '') . ' ' . ($_POST['L_Name'] ?? '');
                        $value['Amount'] = $_POST['amount'] ?? '';
                        $value['PaymentOption'] = $_POST['PaymentOption'] ?? '';
                        $value['payment_status'] = 'confirmed';
                        $value['transaction_id'] = $_POST['checkno'] ?? '';
                        $value['Member_id'] = $_POST['member_id'] ?? '';
                        $value['pay_date'] = $_POST['paydate'] ?? '';
                        $value['oid'] = $_POST['oid'] ?? '';
                        $value['pay_type'] = $_POST['pay_type'] ?? '';
                        $value['pay_for'] = $_POST['pay_for'] ?? '';
                        $value['City'] = $_POST['City'] ?? '';
                        $value['State'] = $_POST['State'] ?? '';
                        $value['Zip_Code'] = $_POST['Zip'] ?? '';
                        $value['email'] = $_POST['email'] ?? '';
                        $value['Tele1'] = $_POST['phone'] ?? '';
                        $MemberModel->SaveDataInmember($value);
                    }
                    $datefor = $_POST['paydate'] ?? '';
                    $timestamp = !empty($datefor) ? strtotime($datefor) : false;
                    $payfinaldate = $timestamp ? date("m/d/Y", $timestamp) : '';
                    $mobileno = $data['phone'];
                    $Emailcc = 'pujaassocpayment@durgabari.org';
                    $subjetc = 'HDBS Food Coupon Payment';
                    $fullname = ($_POST['F_Name'] ?? '') . ' ' . ($_POST['L_Name'] ?? '');
                    $memberid = $_POST['member_id'] ?? '';
                    $oid = $_POST['oid'] ?? '';
                    $couponfor = $_POST['couponfor'] ?? '';
                    $coupontype = $_POST['coupontype'] ?? '';
                    $pyamentmethod = "Zelle";
                    $pyamentstatus = "Confirmed";
                    $amount = $_POST['amount'] ?? '';
                    $email = $_POST['email'] ?? '';
                    if ($email != null) {
                        $this->sendEmailticket($message, $subjetc, $email, $Emailcc);
                    }
                    if (($_POST['phone'] ?? '') != null) {
                        $msg = 'Houston Durga Bari: Food Coupon confirmation are Member Id: ' . $memberid . ', Full Name: ' . $fullname . ', Coupon Type: ' . $coupontype . ' , Payment Method: ' . $pyamentmethod . ' ,Amount: $' . $amount . ', Pay Date: ' . $payfinaldate . ',  Order Id: ' . $oid . ', Status: ' . $pyamentstatus;
                        $this->SendSMS($mobileno, $msg);
                    }
                    //echo '<script>alert("Data Updated Successfully")</script>';
                    Util::redirect(INSTALL_URL . "pujafoodcoupon/index");

                }
                exit();
            } elseif (($_POST['PaymentOption'] ?? '') == 'check') {

                $_POST['amount'] = $_POST['checkAmount'] ?? '';
                $_POST['bankname'] = $_POST['checkbankname'] ?? '';
                $_POST['chkdate'] = $_POST['CheckDate'] ?? '';
                $_POST['pay_date'] = $_POST['CheckDate'] ?? '';
                $_POST['DepositAccount'] = $_POST['CheckDepositAccount'] ?? '';
                $_POST['Status'] = 'confirmed';
                $_POST['payment_status'] = 'confirmed';
                $_POST['id'] = $id;
                $datamemberarr = array();
                $datamemberarr = array_merge($_POST);
                $pujafoodcouponModel->update(array_merge($_POST));

                $value = array();
                $value['oid'] = $datamemberarr['oid'];
                $value['Member_id'] = $datamemberarr['member_id'];
                $value['MemberName'] = $datamemberarr['F_Name'] . ' ' . $datamemberarr['L_Name'];
                $value['PaymentOption'] = $datamemberarr['PaymentOption'];
                $value['payment_status'] = 'succeeded';
                $value['payment_timestamp'] = $datamemberarr['payment_timestamp'] ?? '';
                $value['Amount'] = $datamemberarr['amount'];
                $value['stripe_return'] = $datamemberarr['stripe_return'] ?? '';
                $value['transaction_id'] = $datamemberarr['transaction_id'];
                $value['paid_amount'] = $datamemberarr['paid_amount'] ?? '';
                $value['update_on'] = $datamemberarr['UpdateOn'];
                $value['stripe_product'] = $datamemberarr['stripe_product'] ?? '';
                $value['pay_date'] = $datamemberarr['paydate'] ?? $datamemberarr['pay_date'] ?? '';
                $value['pay_type'] = $datamemberarr['pay_type'] ?? '';
                $value['pay_for'] = $datamemberarr['pay_for'];
                $value['Tele1'] = $datamemberarr['phone'];
                $value['email'] = $datamemberarr['email'];
                $value['City'] = $datamemberarr['City'];
                $value['State'] = $datamemberarr['State'];
                $value['Zip_Code'] = $datamemberarr['Zip'];
                $value['bank'] = $datamemberarr['bankname'];
                $value['chkno'] = $datamemberarr['checkno'];
                $value['chkdate'] = $datamemberarr['chkdate'];
                $value['DepositAccount'] = $datamemberarr['DepositAccount'];
                $DonationModel->SaveDataInDonation($value);

                if ($datamember == null) {
                    $value = array();
                    $value['MemberName'] = ($_POST['F_Name'] ?? '') . ' ' . ($_POST['L_Name'] ?? '');
                    $value['Amount'] = $_POST['amount'] ?? '';
                    $value['PaymentOption'] = $_POST['PaymentOption'] ?? '';
                    $value['payment_status'] = 'confirmed';
                    $value['transaction_id'] = $_POST['checkno'] ?? '';
                    $value['Member_id'] = $_POST['member_id'] ?? '';
                    $value['pay_date'] = $_POST['paydate'] ?? '';
                    $value['oid'] = $_POST['oid'] ?? '';
                    $value['pay_type'] = $_POST['pay_type'] ?? '';
                    $value['pay_for'] = $_POST['pay_for'] ?? '';
                    $value['City'] = $_POST['City'] ?? '';
                    $value['State'] = $_POST['State'] ?? '';
                    $value['Zip_Code'] = $_POST['Zip'] ?? '';
                    $value['email'] = $_POST['email'] ?? '';
                    $value['Tele1'] = $_POST['phone'] ?? '';
                    $MemberModel->SaveDataInmember($value);
                    $this->tpl['arr'] = $pujafoodcouponModel->get($id);

                }

                $datefor = $_POST['paydate'] ?? '';
                $timestamp = !empty($datefor) ? strtotime($datefor) : false;
                $payfinaldate = $timestamp ? date("m/d/Y", $timestamp) : '';
                $subjetc = 'HDBS Food Coupon Payment';
                $fullname = ($_POST['F_Name'] ?? '') . ' ' . ($_POST['L_Name'] ?? '');
                $memberid = $_POST['member_id'] ?? '';
                $oid = $_POST['oid'] ?? '';
                $couponfor = $_POST['couponfor'] ?? '';
                $coupontype = $_POST['coupontype'] ?? '';
                $pyamentmethod = "Check";
                $pyamentstatus = "Confirmed";
                $amount = $_POST['amount'] ?? '';
                $email = $_POST['email'] ?? '';
                if ($email != null) {
                   $this->sendEmailticket($message, $subjetc, $email, $Emailcc);
                }
                $mobileno = $_POST['phone'] ?? '';
                if (($_POST['phone'] ?? '') != null) {
                    $msg = 'Houston Durga Bari: Food Coupon confirmation are Member Id: ' . $memberid . ', Full Name: ' . $fullname . ', Coupon Type: ' . $coupontype . ' , Payment Method: ' . $pyamentmethod . ' ,Amount: $' . $amount . ', Pay Date: ' . $payfinaldate . ',  Order Id: ' . $oid . ', Status: ' . $pyamentstatus;
                    //echo "<script>alert('$msg')</script>";
                    $this->SendSMS($mobileno, $msg);
                }
                //echo '<script>alert("Data Updated Successfully")</script>';
                Util::redirect(INSTALL_URL . "pujafoodcoupon/index");
                exit();
            } elseif (($_POST['PaymentOption'] ?? '') == 'cash') {
                $_POST['amount'] = $_POST['cashAmount'] ?? '';
                $_POST['pay_date'] = $_POST['cashDate'] ?? '';
                $_POST['DepositAccount'] = $_POST['CashDepositAccount'] ?? '';
                $_POST['Status'] = 'confirmed';
                $_POST['payment_status'] = 'confirmed';
                $_POST['id'] = $id;
                $datamemberarr = array();
                $datamemberarr = array_merge($_POST);
                $pujafoodcouponModel->update(array_merge($_POST));
                $value = array();
                $value['oid'] = $datamemberarr['oid'];
                $value['Member_id'] = $datamemberarr['member_id'];
                $value['MemberName'] = $datamemberarr['F_Name'] . ' ' . $datamemberarr['L_Name'];
                $value['PaymentOption'] = $datamemberarr['PaymentOption'];
                $value['payment_status'] = 'succeeded';
                $value['payment_timestamp'] = $datamemberarr['payment_timestamp'] ?? '';
                $value['Amount'] = $datamemberarr['amount'];
                $value['stripe_return'] = $datamemberarr['stripe_return'] ?? '';
                $value['transaction_id'] = $datamemberarr['transaction_id'];
                $value['paid_amount'] = $datamemberarr['paid_amount'] ?? '';
                $value['update_on'] = $datamemberarr['UpdateOn'];
                $value['stripe_product'] = $datamemberarr['stripe_product'] ?? '';
                $value['pay_date'] = $datamemberarr['paydate'] ?? $datamemberarr['pay_date'] ?? '';
                $value['pay_type'] = $datamemberarr['pay_type'] ?? '';
                $value['pay_for'] = $datamemberarr['pay_for'];
                $value['Tele1'] = $datamemberarr['phone'];
                $value['email'] = $datamemberarr['email'];
                $value['City'] = $datamemberarr['City'];
                $value['State'] = $datamemberarr['State'];
                $value['Zip_Code'] = $datamemberarr['Zip'];
                $value['bank'] = $datamemberarr['bankname'];
                $value['chkno'] = $datamemberarr['checkno'];
                $value['chkdate'] = $datamemberarr['chkdate'];
                $value['ReceiveBy'] = $_POST['receiveby'] ?? '';
                $value['DepositAccount'] = $datamemberarr['DepositAccount'];
                $DonationModel->SaveDataInDonation($value);
                if ($datamember == null) {
                    $value = array();
                    $value['MemberName'] = ($_POST['F_Name'] ?? '') . ' ' . ($_POST['L_Name'] ?? '');
                    $value['Amount'] = $_POST['amount'] ?? '';
                    $value['PaymentOption'] = $_POST['PaymentOption'] ?? '';
                    $value['payment_status'] = 'confirmed';
                    $value['transaction_id'] = $_POST['checkno'] ?? '';
                    $value['Member_id'] = $_POST['member_id'] ?? '';
                    $value['pay_date'] = $_POST['paydate'] ?? '';
                    $value['oid'] = $_POST['oid'] ?? '';
                    $value['pay_type'] = $_POST['pay_type'] ?? '';
                    $value['pay_for'] = $_POST['pay_for'] ?? '';
                    $value['City'] = $_POST['City'] ?? '';
                    $value['State'] = $_POST['State'] ?? '';
                    $value['Zip_Code'] = $_POST['Zip'] ?? '';
                    $value['email'] = $_POST['email'] ?? '';
                    $value['Tele1'] = $_POST['phone'] ?? '';
                    $MemberModel->SaveDataInmember($value);
                }
                $datefor = $_POST['paydate'] ?? '';
                $timestamp = !empty($datefor) ? strtotime($datefor) : false;
                $payfinaldate = $timestamp ? date("m/d/Y", $timestamp) : '';
                $fullname = ($_POST['F_Name'] ?? '') . ' ' . ($_POST['L_Name'] ?? '');
                $memberid = $_POST['member_id'] ?? '';
                $oid = $_POST['oid'] ?? '';
                $couponfor = $_POST['couponfor'] ?? '';
                $coupontype = $_POST['coupontype'] ?? '';
                $pyamentmethod = "Cash";
                $pyamentstatus = "Confirmed";
                $amount = $_POST['amount'] ?? '';
                $email = $_POST['email'] ?? '';
                if ($email != null) {
                    $this->sendEmailticket($message, $subjetc, $email, $Emailcc);
                }
                $mobileno = $_POST['phone'] ?? '';
                if (($_POST['phone'] ?? '') != null) {
                    $msg = 'Houston Durga Bari: Food Coupon confirmation are Member Id: ' . $memberid . ', Full Name: ' . $fullname . ', Coupon Type: ' . $coupontype . ' , Payment Method: ' . $pyamentmethod . ' ,Amount: $' . $amount . ', Pay Date: ' . $payfinaldate . ',  Order Id: ' . $oid . ', Status: ' . $pyamentstatus;
                    //echo "<script>alert('$msg')</script>";
                    $this->SendSMS($mobileno, $msg);
                }
                //echo '<script>alert("Data Updated Successfully")</script>';
                Util::redirect(INSTALL_URL . "pujafoodcoupon/index");
                exit();

            } elseif (($_POST['PaymentOption'] ?? '') == 'directdeposit') {
                $_POST['bankname'] = $_POST['BankName'] ?? '';
                $_POST['pay_date'] = $_POST['transactiondate'] ?? '';
                $_POST['transaction_id'] = $_POST['ISFCCode'] ?? '';
                $_POST['amount'] = $_POST['directamount'] ?? '';
                $_POST['DepositAccount'] = $_POST['DirectPayDepositAccount'] ?? '';
                $_POST['Status'] = 'confirmed';
                $_POST['payment_status'] = 'confirmed';
                $_POST['id'] = $id;
                $datamemberarr = array();
                $datamemberarr = array_merge($_POST);
                $pujafoodcouponModel->update(array_merge($_POST));
                $value = array();
                $value['oid'] = $datamemberarr['oid'];
                $value['Member_id'] = $datamemberarr['member_id'];
                $value['MemberName'] = $datamemberarr['F_Name'] . ' ' . $datamemberarr['L_Name'];
                $value['PaymentOption'] = $datamemberarr['PaymentOption'];
                $value['payment_status'] = 'succeeded';
                $value['payment_timestamp'] = $datamemberarr['payment_timestamp'] ?? '';
                $value['Amount'] = $datamemberarr['amount'];
                $value['stripe_return'] = $datamemberarr['stripe_return'] ?? '';
                $value['transaction_id'] = $datamemberarr['transaction_id'];
                $value['paid_amount'] = $datamemberarr['paid_amount'] ?? '';
                $value['update_on'] = $datamemberarr['UpdateOn'];
                $value['stripe_product'] = $datamemberarr['stripe_product'] ?? '';
                $value['pay_date'] = $datamemberarr['paydate'] ?? $datamemberarr['pay_date'] ?? '';
                $value['pay_type'] = $datamemberarr['pay_type'] ?? '';
                $value['pay_for'] = $datamemberarr['pay_for'];
                $value['Tele1'] = $datamemberarr['phone'];
                $value['email'] = $datamemberarr['email'];
                $value['City'] = $datamemberarr['City'];
                $value['State'] = $datamemberarr['State'];
                $value['Zip_Code'] = $datamemberarr['Zip'];
                $value['bank'] = $datamemberarr['bankname'];
                $value['chkno'] = $datamemberarr['checkno'];
                $value['chkdate'] = $datamemberarr['chkdate'];
                $value['ReceiveBy'] = $_POST['receiveby'] ?? '';
                $value['DepositAccount'] = $datamemberarr['DepositAccount'];
                $DonationModel->SaveDataInDonation($value);
                if ($datamember == null) {
                    $value = array();
                    $value['MemberName'] = ($_POST['F_Name'] ?? '') . ' ' . ($_POST['L_Name'] ?? '');
                    $value['Amount'] = $_POST['amount'] ?? '';
                    $value['PaymentOption'] = $_POST['PaymentOption'] ?? '';
                    $value['payment_status'] = 'confirmed';
                    $value['transaction_id'] = $_POST['checkno'] ?? '';
                    $value['Member_id'] = $_POST['member_id'] ?? '';
                    $value['pay_date'] = $_POST['paydate'] ?? '';
                    $value['oid'] = $_POST['oid'] ?? '';
                    $value['pay_type'] = $_POST['pay_type'] ?? '';
                    $value['pay_for'] = $_POST['pay_for'] ?? '';
                    $value['City'] = $_POST['City'] ?? '';
                    $value['State'] = $_POST['State'] ?? '';
                    $value['Zip_Code'] = $_POST['Zip'] ?? '';
                    $value['email'] = $_POST['email'] ?? '';
                    $value['Tele1'] = $_POST['phone'] ?? '';
                    $MemberModel->SaveDataInmember($value);
                }
                $datefor = $_POST['paydate'] ?? '';
                $timestamp = !empty($datefor) ? strtotime($datefor) : false;
                $payfinaldate = $timestamp ? date("m/d/Y", $timestamp) : '';
                $mobileno = $data['phone'];
                $fullname = ($_POST['F_Name'] ?? '') . ' ' . ($_POST['L_Name'] ?? '');
                $memberid = $_POST['member_id'] ?? '';
                $oid = $_POST['oid'] ?? '';
                $couponfor = $_POST['couponfor'] ?? '';
                $coupontype = $_POST['coupontype'] ?? '';
                $pyamentmethod = "Direct Deposite";
                $pyamentstatus = "Confirmed";
                $amount = $_POST['amount'] ?? '';
                $email = $_POST['email'] ?? '';
                if ($email != null) {
                    $this->sendEmailticket($message, $subjetc, $email, $Emailcc);
                }
                $mobileno = $_POST['phone'] ?? '';
                if (($_POST['phone'] ?? '') != null) {
                    $msg = 'Houston Durga Bari: Food Coupon confirmation are Member Id: ' . $memberid . ', Full Name: ' . $fullname . ', Coupon Type: ' . $coupontype . ' , Payment Method: ' . $pyamentmethod . ' ,Amount: $' . $amount . ', Pay Date: ' . $payfinaldate . ',  Order Id: ' . $oid . ', Status: ' . $pyamentstatus;
                    //echo "<script>alert('$msg')</script>";
                   $this->SendSMS($mobileno, $msg);
                }
                //echo '<script>alert("Data Updated Successfully")</script>';
                Util::redirect(INSTALL_URL . "pujafoodcoupon/index");
                exit();
            } elseif (($_POST['PaymentOption'] ?? '') == 'sumup') {
                $_POST['pay_date'] = $_POST['sumupdate'] ?? '';
                $_POST['transaction_id'] = $_POST['sumupid'] ?? '';
                $_POST['amount'] = $_POST['sumupamount'] ?? '';
                $_POST['DepositAccount'] = $_POST['SumUpDepositAccount'] ?? '';
                $_POST['Status'] = 'confirmed';
                $_POST['payment_status'] = 'confirmed';
                $_POST['id'] = $id;
                $datamemberarr = array();
                $datamemberarr = array_merge($_POST);
                $pujafoodcouponModel->update(array_merge($_POST));
                $value = array();
                $value['oid'] = $datamemberarr['oid'];
                $value['Member_id'] = $datamemberarr['member_id'];
                $value['MemberName'] = $datamemberarr['F_Name'] . ' ' . $datamemberarr['L_Name'];
                $value['PaymentOption'] = $datamemberarr['PaymentOption'];
                $value['payment_status'] = 'succeeded';
                $value['payment_timestamp'] = $datamemberarr['payment_timestamp'] ?? '';
                $value['Amount'] = $datamemberarr['amount'];
                $value['stripe_return'] = $datamemberarr['stripe_return'] ?? '';
                $value['transaction_id'] = $datamemberarr['transaction_id'];
                $value['paid_amount'] = $datamemberarr['paid_amount'] ?? '';
                $value['update_on'] = $datamemberarr['UpdateOn'];
                $value['stripe_product'] = $datamemberarr['stripe_product'] ?? '';
                $value['pay_date'] = $datamemberarr['paydate'] ?? $datamemberarr['pay_date'] ?? '';
                $value['pay_type'] = $datamemberarr['pay_type'] ?? '';
                $value['pay_for'] = $datamemberarr['pay_for'];
                $value['Tele1'] = $datamemberarr['phone'];
                $value['email'] = $datamemberarr['email'];
                $value['City'] = $datamemberarr['City'];
                $value['State'] = $datamemberarr['State'];
                $value['Zip_Code'] = $datamemberarr['Zip'];
                $value['bank'] = $datamemberarr['bankname'];
                $value['chkno'] = $datamemberarr['checkno'];
                $value['chkdate'] = $datamemberarr['chkdate'];
                $value['ReceiveBy'] = $_POST['receiveby'] ?? '';
                $value['DepositAccount'] = $datamemberarr['DepositAccount'];
                $DonationModel->SaveDataInDonation($value);
                if ($datamember == null) {
                    $value = array();
                    $value['MemberName'] = ($_POST['F_Name'] ?? '') . ' ' . ($_POST['L_Name'] ?? '');
                    $value['Amount'] = $_POST['amount'] ?? '';
                    $value['PaymentOption'] = $_POST['PaymentOption'] ?? '';
                    $value['payment_status'] = 'confirmed';
                    $value['transaction_id'] = $_POST['checkno'] ?? '';
                    $value['Member_id'] = $_POST['member_id'] ?? '';
                    $value['pay_date'] = $_POST['paydate'] ?? '';
                    $value['oid'] = $_POST['oid'] ?? '';
                    $value['pay_type'] = $_POST['pay_type'] ?? '';
                    $value['pay_for'] = $_POST['pay_for'] ?? '';
                    $value['City'] = $_POST['City'] ?? '';
                    $value['State'] = $_POST['State'] ?? '';
                    $value['Zip_Code'] = $_POST['Zip'] ?? '';
                    $value['email'] = $_POST['email'] ?? '';
                    $value['Tele1'] = $_POST['phone'] ?? '';
                    $MemberModel->SaveDataInmember($value);
                }
                $datefor = $_POST['paydate'] ?? '';
                $timestamp = !empty($datefor) ? strtotime($datefor) : false;
                $payfinaldate = $timestamp ? date("m/d/Y", $timestamp) : '';
                $mobileno = $data['phone'];
                $fullname = ($_POST['F_Name'] ?? '') . ' ' . ($_POST['L_Name'] ?? '');
                $memberid = $_POST['member_id'] ?? '';
                $oid = $_POST['oid'] ?? '';
                $couponfor = $_POST['couponfor'] ?? '';
                $coupontype = $_POST['coupontype'] ?? '';
                $pyamentmethod = "SumUp";
                $pyamentstatus = "Confirmed";
                $amount = $_POST['amount'] ?? '';
                $email = $_POST['email'] ?? '';
                if ($email != null) {
                    $this->sendEmailticket($message, $subjetc, $email, $Emailcc);
                }
                $mobileno = $_POST['phone'] ?? '';
                if (($_POST['phone'] ?? '') != null) {
                    $msg = 'Houston Durga Bari: Food Coupon confirmation are Member Id: ' . $memberid . ', Full Name: ' . $fullname . ', Coupon Type: ' . $coupontype . ' , Payment Method: ' . $pyamentmethod . ' ,Amount: $' . $amount . ', Pay Date: ' . $payfinaldate . ',  Order Id: ' . $oid . ', Status: ' . $pyamentstatus;
                    //echo "<script>alert('$msg')</script>";
                    $this->SendSMS($mobileno, $msg);
                }
                //echo '<script>alert("Data Updated Successfully")</script>';
                Util::redirect(INSTALL_URL . "pujafoodcoupon/index");
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
                            "currency" => "USD",
                            //  "currency" => $this->tpl["option_arr_values"]["currency"],
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
                        $opts['id'] = $id;
                        $opts['stripe_return'] = $payment->status;
                        $opts['transaction_id'] = $payment->id;
                        $opts['paid_amount'] = $payment->amount;
                        $opts['stripe_product'] = $payment->description;
                        //$opts['payment_status'] = 'confirmed';
                        $opts['payment_status'] = 'confirmed';
                        $opts['Status'] = 'confirmed';
                        $opts['payment_timestamp'] = time();

                        $data = $_POST;
                        $datamemberarr = array();
                        $datamemberarr = array_merge($opts, $_POST);
                        $pujafoodcouponModel->update(array_merge($opts, $_POST,$data));
                        $value = array();
                        $value['oid'] = $datamemberarr['oid'];
                        $value['Member_id'] = $datamemberarr['member_id'];
                        $value['MemberName'] = $datamemberarr['F_Name'] . ' ' . $datamemberarr['L_Name'];
                        $value['PaymentOption'] = $datamemberarr['PaymentOption'];
                        $value['payment_status'] = 'succeeded';
                        $value['payment_timestamp'] = $datamemberarr['payment_timestamp'] ?? '';
                        $value['Amount'] = $datamemberarr['amount'];
                        $value['stripe_return'] = $datamemberarr['stripe_return'] ?? '';
                        $value['transaction_id'] = $datamemberarr['transaction_id'];
                        $value['paid_amount'] = $datamemberarr['paid_amount'] ?? '';
                        $value['update_on'] = $datamemberarr['UpdateOn'];
                        $value['stripe_product'] = $datamemberarr['stripe_product'] ?? '';
                        $value['pay_date'] = $datamemberarr['paydate'] ?? $datamemberarr['pay_date'] ?? '';
                        $value['pay_type'] = $datamemberarr['pay_type'] ?? '';
                        $value['pay_for'] = $datamemberarr['pay_for'];
                        $value['Tele1'] = $datamemberarr['phone'];
                        $value['email'] = $datamemberarr['email'];
                        $value['City'] = $datamemberarr['City'];
                        $value['State'] = $datamemberarr['State'];
                        $value['Zip_Code'] = $datamemberarr['Zip'];
                        $value['bank'] = $datamemberarr['bankname'];
                        $value['chkno'] = $datamemberarr['checkno'];
                        $value['chkdate'] = $datamemberarr['chkdate'];
                        $value['ReceiveBy'] = $_POST['receiveby'] ?? '';
                        $DonationModel->SaveDataInDonation($value);
                        if ($datamember == null) {
                            $value = array();
                            $value['MemberName'] = ($_POST['F_Name'] ?? '') . ' ' . ($_POST['L_Name'] ?? '');
                            $value['Amount'] = $_POST['amount'] ?? '';
                            $value['PaymentOption'] = $_POST['PaymentOption'] ?? '';
                            $value['payment_status'] = 'confirmed';
                            $value['transaction_id'] = $_POST['checkno'] ?? '';
                            $value['Member_id'] = $_POST['member_id'] ?? '';
                            $value['pay_date'] = $_POST['paydate'] ?? '';
                            $value['oid'] = $_POST['oid'] ?? '';
                            $value['pay_type'] = $_POST['pay_type'] ?? '';
                            $value['pay_for'] = $_POST['pay_for'] ?? '';
                            $value['City'] = $_POST['City'] ?? '';
                            $value['State'] = $_POST['State'] ?? '';
                            $value['Zip_Code'] = $_POST['Zip'] ?? '';
                            $value['email'] = $_POST['email'] ?? '';
                            $value['Tele1'] = $_POST['phone'] ?? '';
                            $MemberModel->SaveDataInmember($value);
                        }
                        $datefor = $_POST['paydate'] ?? '';
                        $timestamp = !empty($datefor) ? strtotime($datefor) : false;
                        $payfinaldate = $timestamp ? date("m/d/Y", $timestamp) : '';

                        $this->tpl['arr'] = $pujafoodcouponModel->get($id);
                        $fullname = ($_POST['F_Name'] ?? '') . ' ' . ($_POST['L_Name'] ?? '');
                        $memberid = $_POST['member_id'] ?? '';
                        $oid = $_POST['oid'] ?? '';
                        $couponfor = $_POST['couponfor'] ?? '';
                        $coupontype = $_POST['coupontype'] ?? '';
                        $pyamentmethod = "Credit Card";
                        $pyamentstatus = "Confirmed";
                        $amount = $_POST['amount'] ?? '';
                        $email = $_POST['email'] ?? '';
                        if ($email != null) {
                            $this->sendEmailticket($message, $subjetc, $email, $Emailcc);
                        }
                        $mobileno = $_POST['phone'] ?? '';
                        if (($_POST['phone'] ?? '') != null) {
                            $msg = 'Houston Durga Bari: Food Coupon confirmation are Member Id: ' . $memberid . ', Full Name: ' . $fullname . ', Coupon Type: ' . $coupontype . ' , Payment Method: ' . $pyamentmethod . ' ,Amount: $' . $amount . ', Pay Date: ' . $payfinaldate . ',  Order Id: ' . $oid . ', Status: ' . $pyamentstatus;
                            //echo "<script>alert('$msg')</script>";
                            $this->SendSMS($mobileno, $msg);
                        }
                        echo '<script>alert("Data Updated Successfully")</script>';
                        Util::redirect(INSTALL_URL . "pujafoodcoupon/index");
                        exit();

                    } else {

                        $opts = array();
                        $opts['id'] = $id;
                        $opts['stripe_return'] = $payment->status;
                        $opts['transaction_id'] = $payment->id;
                        $opts['paid_amount'] = $payment->amount;
                        $opts['stripe_product'] = $payment->description;

                        $pujafoodcouponModel->update($opts);

                        $_SESSION['status'] = '<strong>' . __('declined_card') . '</strong>';
                    }
                } catch (Exception $ex) {
                    $_SESSION['status'] = $ex->getMessage();
                }

                $this->tpl['arr'] = $pujafoodcouponModel->get($id);
                $this->tpl['arr']['amount'] = $total;
            } else {
                $_SESSION['status'] = 16;

            }

            if (!empty($id)) {
                $_SESSION['status'] = 20;
            } else {
                $_SESSION['status'] = 21;
            }

            if (!$this->isAdmin()) {
                Util::redirect(INSTALL_URL . "Admin/dashboard");
            } else {
                Util::redirect(INSTALL_URL . "pujafoodcoupon/index");
            }
        }
        
        $id = $_GET['id'] ?? '';
        $data = $pujafoodcouponModel->get($id);
        $this->tpl['userData'] = $data;
    }


    function processNewCode()
    {
        GzObject::loadFiles('Model', array('FoodCouponSessionName'));
        $FoodCouponSessionName = new FoodCouponSessionName();
        if (!empty($_POST['processNewCode'])) {

            $id = $FoodCouponSessionName->save(array_merge($_POST));

            if (!empty($id)) {
                $_SESSION['status'] = 16;
            } else {
                $_SESSION['status'] = 17;
            }
            Util::redirect(INSTALL_URL . "pujafoodcoupon/index");
        }
    }

    function codeEdit()
    {
        GzObject::loadFiles('Model', array('FoodCouponSessionName'));
        $FoodCouponSessionName = new FoodCouponSessionName();
        if (!empty($_POST['foodcouponcodeedit'])) {

            $data = array();
            $id = $FoodCouponSessionName->update(array_merge($_POST));

            if (!empty($id)) {
                $_SESSION['status'] = 20;
            } else {
                $_SESSION['status'] = 21;
            }

            if (!$this->isAdmin()) {
                Util::redirect(INSTALL_URL . "Admin/dashboard");
            } else {
                Util::redirect(INSTALL_URL . "pujafoodcoupon/index");
            }
        }
        $id = $_GET['id'] ?? '';
        $result = $FoodCouponSessionName->get($id);
        $this->tpl['Codes'] = $result;
    }

}
  

?>
