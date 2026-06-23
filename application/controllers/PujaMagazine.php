<?php

require_once CONTROLLERS_PATH . 'App.php';

class PujaMagazine extends App {

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

        $cacheBust = time();
        $this->js[] = array('file' => 'otp-member-verify.js?v=' . $cacheBust, 'path' => JS_PATH);
        $this->js[] = array('file' => 'GzPujaMagazine.js?v=' . $cacheBust, 'path' => JS_PATH);
        $this->js[] = array('file' => 'multiselect-dropdown.js?v=' . $cacheBust, 'path' => JS_PATH);
        $this->js[] = array('file' => 'loadingoverlay.js?v=' . $cacheBust, 'path' => JS_PATH);
    }



      function PujaMagazine() {
    // action method — __construct() handles data loading
  }

  function __construct()
    {
        
        $this->layout = 'login';
     GzObject::loadFiles('Model', array('pujamagazine', 'pujamagazineprice', 'ConfirmCode', 'Member', 'idnumbers','itemspujasponsor','User','Donation','itemspujasponsor'));
       $pujamagazineModel = new pujamagazineModel();
       $pujamagazinepriceModel = new pujamagazinepriceModel();
       $DonationModel = new DonationModel();
       $ConfirmCodeModel = new ConfirmCodeModel();
       $MemberModel = new MemberModel();
       $idnumbersModel = new idnumbersModel();
       $itemspujasponsorModel = new itemspujasponsorModel();
       $UserModel = new UserModel();

       $magazineregarr = $pujamagazinepriceModel->getAllmagazineprice($_POST);
        $this->tpl['magazineregarr'] = $magazineregarr;

        if (!empty($_POST['create_magazine_payment_request'])) {
        
            if (($_POST['PaymentOption'] ?? '') == null) {
                $_POST['status'] = 'pending';
                date_default_timezone_set("America/Chicago");
                $today = date("Y/m/d");
                $_POST['CreatedAt'] = $today;
                $_POST['pay_date'] = $today;
                $_POST['pay_for'] = 'Puja Magazine';
                $_POST['per_mag_amount'] =  $_POST['magazineTypecollection'] ?? '';
                // Generate oid for pending path (required column, no DB default)
                $maxoid = $idnumbersModel->getMaxoid() + 1;
                $idnumbersModel->Updateoid($maxoid);
                $_POST['oid'] = $maxoid;
                // Generate Member_id for new members
                $datamember = $MemberModel->rentalmemberduplicate();
                if ($datamember == null) {
                    $maxid = $idnumbersModel->getMaxmid() + 1;
                    $idnumbersModel->Updatemid($maxid);
                    $_POST['Member_id'] = $maxid;
                } else {
                    $_POST['Member_id'] = $datamember;
                }
                $id = $pujamagazineModel->save(array_merge($_POST));
                        
                 if (!empty($id)) {
                     $modeofcollection1 = $_POST['mode_of_collection'] ?? '';
                    //  if($modeofcollection1 == "15"){
                    //      $modeofcollection = "Collect at Durga Bari";
                    //  }else{
                    //      $modeofcollection = "Postal Delivery";
                    //  }
                        echo "<div style='text-align: -webkit-center;' class = 'pay'>
                    <table border='4'  width='585px' style='margin-left:4em;'>
                    <tr>
                    <td colspan='2'> <img src='../thankyouscreen.jpg' alt='' height='167px' style='margin-left:12em;'><h1 style='text-align:center;font-family:fangsong; font-size:30px;'><b>Houston Durga Bari Society</b></h1> </td>
                    <tr><td colspan='2'><span style='font-size: 18px;font-family: serif;'>Your Parking spot request have been submitted.
                    Registration Team will validate your application and send a confirmation for payment.</span></td></tr>
                    <tr><td style='width:50%;'>Member Id</td> <td style='width:50%;'>" . ($_POST['Member_id'] ?? '') . "</td> </tr>
                    <tr><td style='width:50%;'>Member Name</td> <td style='width:50%;'>" . ($_POST['First_name'] ?? '') . ' ' . ($_POST['Last_name'] ?? '') . "</td> </tr>
                    <tr><td>Number of Magazine</td> <td>" . ($_POST['magazine'] ?? '') . "</td> </tr>
                    <tr><td>Mode of Collection</td> <td>" . $modeofcollection . "</td> </tr>
                    <tr><td>Amount</td> <td><span style='color:red;'>$</span>" . ($_POST['totalamount'] ?? '') . "</td> </tr>
                    <tr><td>Status</td> <td>Pending</td>  </tr>
                    <tr><td colspan='2'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>   </tr>
                    </tr>";
                    echo "</table>";
                    echo "<a  href='" . INSTALL_URL . "PujaMagazine/PujaMagazine'>Go to home</a>";
                    echo "</div>";
        
           //$Emailcc = 'pujaassocpayment@durgabari.org';
                    $Emailcc = 'pujaassocpayment@durgabari.org';
                    $subjetc = 'Paid Magazine Request';
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
                    <td style="text-align: center; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;"><strong>Paid Magazine Details</strong></td>
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
                    <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Number of Magazine &nbsp;</td>
                    <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . ($_POST['magazine'] ?? '') . '</td>
                    </tr>
                    <tr>
                    <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Mode of Collection &nbsp;</td>
                    <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $modeofcollection . '</td>
                    </tr>
                    <tr>
                    <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Amount&nbsp;&nbsp;</td>
                    <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;"><span style="color:red;">$</span>' . ($_POST['totalamount'] ?? '') . '</td>
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
                        $msg = 'Your Magazine request have been submitted  Member Id: ' . ($_POST['Member_id'] ?? '') . ', Member Name: ' . ($_POST['First_name'] ?? '') . " " . ($_POST['Last_name'] ?? '') . ', No. of Magazine: ' . ($_POST['magazine'] ?? '') . ', Mode of Collection: ' . $modeofcollection . ' , Amount: $' . ($_POST['totalamount'] ?? '');
                        $this->SendSMS($mobileno, $msg);
                    }
                }
         exit();
        } else{
            
          // if (!empty($_POST['create_donation'])) {
      
              $data = array();
              date_default_timezone_set("America/Chicago");
                  date_default_timezone_set("America/Chicago");
                  $today = date("Y/m/d"); 
                  $_POST['pay_date'] = $today;
                  $_POST['CreatedAt'] = $today;
                 $_POST['paytype'] ='Magazine';
                 $_POST['pay_for'] = 'Puja Magazine';
         
                   // for generate oid 
              $maxoid = $idnumbersModel->getMaxoid() + 1;
              $update_oid = $idnumbersModel->Updateoid($maxoid);
              $_POST['oid'] = $maxoid;
              // end generate oid for 
               $datamember =  $MemberModel->rentalmemberduplicate();
                  if($datamember == null){
                       // for generate memberid for gd
                          $maxid = $idnumbersModel->getMaxmid() + 1;
                           $update_mid = $idnumbersModel->Updatemid($maxid);
                           $_POST['Member_id'] = $maxid;
                      // end generate memberid for gd 
                  }
                   if ($datamember != null) {
                       $_POST['Member_id'] = $datamember;
                       $alternatemobile = $MemberModel->checktele2($datamember);
                 // for update telephone no member case
                if($alternatemobile == null || $alternatemobile != $_POST['alternatenumber'] ?? ''){
                    $mobileno =  $_POST['alternatenumber'] ?? '';
                    $MemberModel->updatetelephone($datamember, $mobileno);
                }
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
      
                  if ($this->isAdmin() || $this->isEditor()) {
                      $id = $this->getUserId();
                      $admin = $UserModel->get($id);
                      $rolename = $admin['first'].' '.$admin['last'];
                      $_POST['admin_id'] = $admin['id'];
                      $_POST['admin_name'] = $rolename;
      
                  }
      
                 $id = $pujamagazineModel->save(array_merge($_POST));
                  if (!empty($id)) {
                          // for email ui 
                    $memberid = $_POST['Member_id'] ?? '';
                    $mebername = ($_POST['First_name'] ?? '') . ' ' . ($_POST['Last_name'] ?? '');
                    $oid = $_POST['oid'] ?? '';
                    $amount = $_POST['totalamount'] ?? '';
                    $modeofcollection1 = $_POST['mode_of_collection'] ?? '';
                     if($modeofcollection1 == "15"){
                         $modeofcollection = "Collect at Durga Bari";
                     }else{
                         $modeofcollection = "Postal Delivery";
                     }
                     $noofmagazine = $_POST['magazine'] ?? '';
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
                    } else if ($paymethod == "stripe") {
                        $payui = 'Credit Card';
                    }
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
                    <td style="text-align: center; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;"><strong>Paid Magazine Registration Confirmation</strong></td>
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
                    <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">No. of Magazine&nbsp;&nbsp;</td>
                    <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $noofmagazine . '</td>
                    </tr>
                    <tr>
                    <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Mode of Collection&nbsp;&nbsp;</td>
                    <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $modeofcollection . '</td>
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
                    $textmsg = 'Houston Durga Bari: Paid Magazine Confirmation are Member Id: ' . $memberid . ', Order Id: ' . $oid . ', Member Name: ' . $mebername . ', No. of Magazine: ' . $noofmagazine . ', Mode of Collection : ' . $modeofcollection . ',  Amount: $' . $amount . ' , Payment Method: ' . $payui . ' , Pay Date: ' . $payfinaldate;

                      if (($_POST['PaymentOption'] ?? '') == 'others') {
                          
                          $opts = array();
                          $oid = $_POST['oid'] ?? '';
                          $cmCode=$_POST['code'] ?? '';
                         $isAvailable = $ConfirmCodeModel->ConfirmCheckCode($cmCode);
                         if(!$isAvailable)
                         {
                           Util::redirect(INSTALL_URL . "PujaMagazine/PujaMagazine");
                           exit();
                         }
                          $arr= $ConfirmCodeModel->UpdateCode($cmCode);
                          $_POST['transaction_id'] =  $cmCode;
                          $opts['Confirmation'] = $_POST['confirm_code'] ?? '';
                         $arr = $ConfirmCodeModel->getAll($opts);
                          if ($oid !=null){
                          //if (!empty($arr[0])) {
                              $opts = array();
                              $opts['id'] = $id;
                              $opts['payment_status'] = 'confirmed';
                     
                              $_POST['status'] = 'confirmed';
                              $data = $_POST;

                              $datamemberarr = array();
                              $datamemberarr = array_merge($opts, $_POST);
                              $pujamagazineModel->update(array_merge($opts, $_POST));
                              $value = array();
                              $value['oid'] = $datamemberarr['oid'];
                          $value['eventid'] = $datamemberarr['eventid'] ?? '';
                          $value['type'] = $datamemberarr['type'] ?? '';
                          $value['Member_id'] = $datamemberarr['Member_id'] ?? '';
                          $value['MemberName'] = $datamemberarr['membername'] ?? '';
                          $value['PaymentOption'] = $datamemberarr['PaymentOption'] ?? '';
                          $value['payment_status'] = 'succeeded';
                          $value['payment_timestamp'] = $datamemberarr['payment_timestamp'] ?? '';
                          $value['Amount'] = $datamemberarr['totalamount'] ?? '';
                          $value['stripe_return'] = $datamemberarr['stripe_return'] ?? '';
                          $value['transaction_id'] = $datamemberarr['transaction_id'] ?? '';
                          $value['paid_amount'] = $datamemberarr['paid_amount'] ?? '';
                          $value['update_on'] = $datamemberarr['UpdateOn'] ?? '';
                          $value['stripe_product'] = $datamemberarr['stripe_product'] ?? '';
                          $value['pay_date'] = $datamemberarr['pay_date'] ?? '';
                          $value['pay_type'] = 'Magazine';
                          $value['pay_for'] = $datamemberarr['pay_for'] ?? '';
                          $value['Tele1'] = $datamemberarr['phone'] ?? '';
                          $value['email'] = $datamemberarr['email'] ?? '';
                          $value['spousename'] = $datamemberarr['spousename'] ?? '';
                          $value['Address'] = $datamemberarr['Address'] ?? '';
                          $value['Street'] = $datamemberarr['street'];
                          $value['City'] = $datamemberarr['city'];
                          $value['State'] = $datamemberarr['state'];
                          $value['Zip_Code'] = $datamemberarr['zip'];
                          $DonationModel->SaveDataInDonation($value);
                          if ($datamember == null) {
                              $value = array();
                              $value['oid'] = $_POST['oid'] ?? '';
                              $value['MemberName'] = $_POST['membername'] ?? '';
                              $value['Tele1'] = $_POST['phone'] ?? '';
                              $value['email'] = $_POST['email'] ?? '';
                              $value['City'] = $_POST['city'] ?? '';
                              $value['State'] = $_POST['state'] ?? '';
                              $value['Zip_Code'] = $_POST['zip'] ?? '';
                              $value['Item_Name'] = $_POST['item_name'] ?? '';
                              $value['Item_Number'] = $_POST['item_number'] ?? '';
                              $value['Item_Cost'] = $_POST['item_cost'] ?? '';
                              $value['Amount'] = $_POST['totalamount'] ?? '';
                              $value['pay_type'] = 'Magazine';
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
                      $amount = $_POST['totalamount'] ?? '';
                      $datefor =$_POST['pay_date'] ?? '';
                      $timestamp = !empty($datefor) ? strtotime($datefor) : false;
                      $payfinaldate = $timestamp ? date("m/d/Y", $timestamp) : '';
      
                      echo "<div style='text-align: -webkit-center;' class = 'pay'>
                      <table border='4' width='585px'>
                      <tr>
                      <td colspan='2'> <img src='../thankyouscreen.jpg' alt='' height='167px' style='margin-left:12em;'><h1 style='text-align:center;font-family:fangsong; font-size:30px;'><b>Houston Durga Bari Society</b></h1> </td> </tr>
                       <tr><td style='width:50%;'>Order Id</td> <td style='width:50%;'>" . $oid . "</td> </tr>
                       <tr><td>Member Id</td> <td>" . $memberid . "</td> </tr>
                       <tr><td>Member Name</td> <td>" . $mebername . "</td> </tr>
                       <tr><td>Amount</td> <td><span style='color:red;'>$</span>" . $amount . "</td> </tr>
                       <tr><td>Payment Method</td> <td>Zelle</td>  </tr>
                       <tr><td>Payment Status</td> <td>Confirmed</td>  </tr>
                       <tr><td>Pay Date</td> <td>" . $payfinaldate . "</td>  </tr>
                       <tr><td colspan='2'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>   </tr>
                       </tr>";
                              echo "</table>";
                              if ($this->isAdmin() || $this->isEditor()) {
                                   echo " <a href='" . INSTALL_URL . "PujaMagazineadmin/index'>Go to home</a>";
                                   //echo " <a href='http://HDBS_Payment/Parking&Badges/PujaMagazineadmin/index'>Go to home</a>";
                              }
                              echo "</div>";
                      
                              exit();
                          }
                      }// check
                      elseif (($_POST['PaymentOption'] ?? '') == 'check') {
                          $_POST['totalamount'] = $_POST['checkAmount'] ?? '';
                          $_POST['bank'] = $_POST['checkbankname'] ?? '';
                          $_POST['chkdate'] = $_POST['CheckDate'] ?? '';
                          $_POST['payment_status'] = 'confirmed';
                          $_POST['status'] = 'confirmed';
                          $_POST['id'] = $id;
                          $data = $_POST;
                          $datamemberarr = array();
                          $datamemberarr = array_merge($_POST);
                          $pujamagazineModel->update(array_merge($_POST));
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
                      $value['pay_type'] = 'Magazine';
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
                      if ($datamember == null) {
                          $value = array();
                          $value['oid'] = $_POST['oid'] ?? '';
                          $value['MemberName'] = $_POST['membername'] ?? '';
                          $value['Tele1'] = $_POST['phone'] ?? '';
                          $value['email'] = $_POST['email'] ?? '';
                          $value['City'] = $_POST['city'] ?? '';
                          $value['State'] = $_POST['state'] ?? '';
                          $value['Zip_Code'] = $_POST['zip'] ?? '';
                          $value['Item_Name'] = $_POST['item_name'] ?? '';
                          $value['Item_Number'] = $_POST['item_number'] ?? '';
                          $value['Item_Cost'] = $_POST['item_cost'] ?? '';
                          $value['Amount'] = $_POST['totalamount'] ?? '';
                          $value['pay_type'] = 'Magazine';
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
                      $amount = $_POST['totalamount'] ?? '';
                       $datefor =$_POST['pay_date'] ?? '';
                      $timestamp = !empty($datefor) ? strtotime($datefor) : false;
                      $payfinaldate = $timestamp ? date("m/d/Y", $timestamp) : '';
      
                      echo "<div style='text-align: -webkit-center;' class = 'pay'>
                      <table border='4' width='585px'>
                      <tr>
                      <td colspan='2'> <img src='../thankyouscreen.jpg' alt='' height='167px' style='margin-left:12em;'><h1 style='text-align:center;font-family:fangsong; font-size:30px;'><b>Houston Durga Bari Society</b></h1> </td> </tr>
                       <tr><td style='width:50%;'>Order Id</td> <td style='width:50%;'>" . $oid . "</td> </tr>
                       <tr><td>Member Id</td> <td>" . $memberid . "</td> </tr>
                       <tr><td>Member Name</td> <td>" . $mebername . "</td> </tr>
                       <tr><td>Amount</td> <td><span style='color:red;'>$</span>" . $amount . "</td> </tr>
                       <tr><td>Payment Method</td> <td>check</td>  </tr>
                       <tr><td>Payment Status</td> <td>Confirmed</td>  </tr>
                       <tr><td>Pay Date</td> <td>" . $payfinaldate . "</td>  </tr>
                       <tr><td colspan='2'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>   </tr>
                       </tr>";
                              echo "</table>";
                              if ($this->isAdmin() || $this->isEditor()) {
                                  echo " <a href='" . INSTALL_URL . "PujaMagazineadmin/index'>Go to home</a>";
                                   //echo " <a href='http://localhost:8082/HDBS_Payment/Parking&Badges/PujaMagazineadmin/index'>Go to home</a>";
                              }
                              echo "</div>";
                      
                      exit();
                          
                         
      
                      }
                      // cash
                      elseif (($_POST['PaymentOption'] ?? '') == 'cash') {
                          $_POST['totalamount'] = $_POST['cashAmount'] ?? '';
                          $_POST['pay_date'] = $_POST['cashDate'] ?? '';
                          $_POST['payment_status'] = 'confirmed';
                          $_POST['status'] = 'confirmed';
                          $_POST['id'] = $id;
                          $data = $_POST;
                          $datamemberarr = array();
                          $datamemberarr = array_merge($_POST);
                          $pujamagazineModel->update(array_merge($_POST));
                         
                          $value = array();
                          $value['oid'] = $datamemberarr['oid'];
                          $value['eventid'] = $datamemberarr['eventid'] ?? '';
                          $value['type'] = $datamemberarr['type'] ?? '';
                          $value['Member_id'] = $datamemberarr['Member_id'] ?? '';
                          $value['MemberName'] = $datamemberarr['membername'] ?? '';
                          $value['PaymentOption'] = $datamemberarr['PaymentOption'] ?? '';
                          $value['payment_status'] = 'succeeded';
                          $value['payment_timestamp'] = $datamemberarr['payment_timestamp'] ?? '';
                          $value['Amount'] = $datamemberarr['totalamount'] ?? '';
                          $value['stripe_return'] = $datamemberarr['stripe_return'] ?? '';
                          $value['transaction_id'] = $datamemberarr['transaction_id'] ?? '';
                          $value['paid_amount'] = $datamemberarr['paid_amount'] ?? '';
                          $value['update_on'] = $datamemberarr['UpdateOn'] ?? '';
                          $value['stripe_product'] = $datamemberarr['stripe_product'] ?? '';
                          $value['pay_date'] = $datamemberarr['pay_date'] ?? '';
                          $value['pay_type'] = 'Magazine';
                          $value['pay_for'] = $datamemberarr['pay_for'] ?? '';
                          $value['Tele1'] = $datamemberarr['phone'] ?? '';
                          $value['email'] = $datamemberarr['email'] ?? '';
                          $value['spousename'] = $datamemberarr['spousename'] ?? '';
                          $value['Address'] = $datamemberarr['Address'] ?? '';
                          $value['Street'] = $datamemberarr['street'];
                          $value['City'] = $datamemberarr['city'];
                          $value['State'] = $datamemberarr['state'];
                          $value['Zip_Code'] = $datamemberarr['zip'];
                          $DonationModel->SaveDataInDonation($value);
                          if ($datamember == null) {
                              $value = array();
                              $value['oid'] = $_POST['oid'] ?? '';
                              $value['MemberName'] = $_POST['membername'] ?? '';
                              $value['Tele1'] = $_POST['phone'] ?? '';
                              $value['email'] = $_POST['email'] ?? '';
                              $value['City'] = $_POST['city'] ?? '';
                              $value['State'] = $_POST['state'] ?? '';
                              $value['Zip_Code'] = $_POST['zip'] ?? '';
                              $value['Item_Name'] = $_POST['item_name'] ?? '';
                              $value['Item_Number'] = $_POST['item_number'] ?? '';
                              $value['Item_Cost'] = $_POST['item_cost'] ?? '';
                              $value['Amount'] = $_POST['totalamount'] ?? '';
                              $value['pay_type'] = 'Magazine';
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
                      $amount = $_POST['totalamount'] ?? '';
                      $parkingspot = $_POST['parkingfield'] ?? '';
                      $datefor =$_POST['pay_date'] ?? '';
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
                       <tr><td>Amount</td> <td><span style='color:red;'>$</span>" . $amount . "</td> </tr>
                       <tr><td>Payment Method</td> <td>Cash</td>  </tr>
                       <tr><td>Payment Status</td> <td>Confirmed</td>  </tr>
                       <tr><td>Pay Date</td> <td>" . $payfinaldate . "</td>  </tr>
                       <tr><td colspan='2'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>   </tr>
                       </tr>";
                              echo "</table>";
                              if ($this->isAdmin() || $this->isEditor()) {
                                   echo " <a href='" . INSTALL_URL . "PujaMagazineadmin/index'>Go to home</a>";
                                   //echo " <a href='http://localhost:8082//HDBS_Payment/Parking&Badges/PujaMagazineadmin/index'>Go to home</a>";
                              }
                              echo "</div>";
                      
                      exit();
      
                      }
                       
                      // directdeposite
                      elseif (($_POST['PaymentOption'] ?? '') == 'directdeposit') {
                          $_POST['bank'] = $_POST['directbank'] ?? '';
                          $_POST['transaction_id'] = $_POST['transactioncode'] ?? '';
                          $_POST['totalamount'] = $_POST['directdepositeamount'] ?? '';
                          $_POST['pay_date'] = $_POST['transactiondate'] ?? '';
                          $_POST['payment_status'] = 'confirmed';
                          $_POST['status'] = 'confirmed';
                          $_POST['id'] = $id;
                          $data = $_POST;
                          $datamemberarr = array();
                          $datamemberarr = array_merge($_POST);
                          $pujamagazineModel->update(array_merge($_POST));
                          $value = array();
                          $value['oid'] = $datamemberarr['oid'];
                          $value['eventid'] = $datamemberarr['eventid'] ?? '';
                          $value['type'] = $datamemberarr['type'] ?? '';
                          $value['Member_id'] = $datamemberarr['Member_id'] ?? '';
                          $value['MemberName'] = $datamemberarr['membername'] ?? '';
                          $value['PaymentOption'] = $datamemberarr['PaymentOption'] ?? '';
                          $value['payment_status'] = 'succeeded';
                          $value['payment_timestamp'] = $datamemberarr['payment_timestamp'] ?? '';
                          $value['Amount'] = $datamemberarr['totalamount'] ?? '';
                          $value['stripe_return'] = $datamemberarr['stripe_return'] ?? '';
                          $value['transaction_id'] = $datamemberarr['transaction_id'] ?? '';
                          $value['paid_amount'] = $datamemberarr['paid_amount'] ?? '';
                          $value['update_on'] = $datamemberarr['UpdateOn'] ?? '';
                          $value['stripe_product'] = $datamemberarr['stripe_product'] ?? '';
                          $value['pay_date'] = $datamemberarr['pay_date'] ?? '';
                          $value['pay_type'] = 'Magazine';
                          $value['pay_for'] = $datamemberarr['pay_for'] ?? '';
                          $value['Tele1'] = $datamemberarr['phone'] ?? '';
                          $value['email'] = $datamemberarr['email'] ?? '';
                          $value['spousename'] = $datamemberarr['spousename'] ?? '';
                          $value['Address'] = $datamemberarr['Address'] ?? '';
                          $value['Street'] = $datamemberarr['street'];
                          $value['City'] = $datamemberarr['city'];
                          $value['State'] = $datamemberarr['state'];
                          $value['Zip_Code'] = $datamemberarr['zip'];
                          $DonationModel->SaveDataInDonation($value);
                          if ($datamember == null) {
                              $value = array();
                              $value['oid'] = $_POST['oid'] ?? '';
                              $value['MemberName'] = $_POST['membername'] ?? '';
                              $value['Tele1'] = $_POST['phone'] ?? '';
                              $value['email'] = $_POST['email'] ?? '';
                              $value['City'] = $_POST['city'] ?? '';
                              $value['State'] = $_POST['state'] ?? '';
                              $value['Zip_Code'] = $_POST['zip'] ?? '';
                              $value['Item_Name'] = $_POST['item_name'] ?? '';
                              $value['Item_Number'] = $_POST['item_number'] ?? '';
                              $value['Item_Cost'] = $_POST['item_cost'] ?? '';
                              $value['Amount'] = $_POST['totalamount'] ?? '';
                              $value['pay_type'] = 'Magazine';
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
                      $amount = $_POST['totalamount'] ?? '';
                     $datefor =$_POST['pay_date'] ?? '';
                      $timestamp = !empty($datefor) ? strtotime($datefor) : false;
                      $payfinaldate = $timestamp ? date("m/d/Y", $timestamp) : '';
      
                      echo "<div style='text-align: -webkit-center;' class = 'pay'>
                      <table border='4' width='585px'>
                      <tr>
                      <td colspan='2'> <img src='../thankyouscreen.jpg' alt='' height='167px' style='margin-left:12em;'><h1 style='text-align:center;font-family:fangsong; font-size:30px;'><b>Houston Durga Bari Society</b></h1> </td> </tr>
                       <tr><td style='width:50%;'>Order Id</td> <td style='width:50%;'>" . $oid . "</td> </tr>
                       <tr><td>Member Id</td> <td>" . $memberid . "</td> </tr>
                       <tr><td>Member Name</td> <td>" . $mebername . "</td> </tr>
                      <tr><td>Amount</td> <td><span style='color:red;'>$</span>" . $amount . "</td> </tr>
                       <tr><td>Payment Method</td> <td>directdeposit</td>  </tr>
                       <tr><td>Payment Status</td> <td>Confirmed</td>  </tr>
                       <tr><td>Pay Date</td> <td>" . $payfinaldate . "</td>  </tr>
                       <tr><td colspan='2'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>   </tr>
                       </tr>";
                              echo "</table>";
                              if ($this->isAdmin() || $this->isEditor()) {
                                   echo " <a href='" . INSTALL_URL . "PujaMagazineadmin/index'>Go to home</a>";
                                   //echo " <a href='http://HDBS_Payment/Parking&Badges/PujaMagazineadmin/index'>Go to home</a>";
                              }
                              echo "</div>";
                      
                      exit();
                          
                          
      
                      }
                      // sumup
                      elseif (($_POST['PaymentOption'] ?? '') == 'sumup') {
                          $_POST['totalamount'] = $_POST['sumupamount'] ?? '';
                          $_POST['transaction_id'] = $_POST['sumupid'] ?? '';
                          $_POST['pay_date'] = $_POST['sumupdate'] ?? '';
                          $_POST['payment_status'] = 'confirmed';
                          $_POST['status'] = 'confirmed';
                          $_POST['id'] = $id;
                          $data = $_POST;
                          $datamemberarr = array();
                          $datamemberarr = array_merge($_POST);
                          $pujamagazineModel->update(array_merge($_POST));
                         
                          $value = array();
                          $value['oid'] = $datamemberarr['oid'];
                          $value['eventid'] = $datamemberarr['eventid'] ?? '';
                          $value['type'] = $datamemberarr['type'] ?? '';
                          $value['Member_id'] = $datamemberarr['Member_id'] ?? '';
                          $value['MemberName'] = $datamemberarr['membername'] ?? '';
                          $value['PaymentOption'] = $datamemberarr['PaymentOption'] ?? '';
                          $value['payment_status'] = 'succeeded';
                          $value['payment_timestamp'] = $datamemberarr['payment_timestamp'] ?? '';
                          $value['Amount'] = $datamemberarr['totalamount'] ?? '';
                          $value['stripe_return'] = $datamemberarr['stripe_return'] ?? '';
                          $value['transaction_id'] = $datamemberarr['transaction_id'] ?? '';
                          $value['paid_amount'] = $datamemberarr['paid_amount'] ?? '';
                          $value['update_on'] = $datamemberarr['UpdateOn'] ?? '';
                          $value['stripe_product'] = $datamemberarr['stripe_product'] ?? '';
                          $value['pay_date'] = $datamemberarr['pay_date'] ?? '';
                          $value['pay_type'] = 'Magazine';
                          $value['pay_for'] = $datamemberarr['pay_for'] ?? '';
                          $value['Tele1'] = $datamemberarr['phone'] ?? '';
                          $value['email'] = $datamemberarr['email'] ?? '';
                          $value['spousename'] = $datamemberarr['spousename'] ?? '';
                          $value['Address'] = $datamemberarr['Address'] ?? '';
                          $value['Street'] = $datamemberarr['street'];
                          $value['City'] = $datamemberarr['city'];
                          $value['State'] = $datamemberarr['state'];
                          $value['Zip_Code'] = $datamemberarr['zip'];
                          $DonationModel->SaveDataInDonation($value);
                          if ($datamember == null) {
                              $value = array();
                              $value['oid'] = $_POST['oid'] ?? '';
                              $value['MemberName'] = $_POST['membername'] ?? '';
                              $value['Tele1'] = $_POST['phone'] ?? '';
                              $value['email'] = $_POST['email'] ?? '';
                              $value['City'] = $_POST['city'] ?? '';
                              $value['State'] = $_POST['state'] ?? '';
                              $value['Zip_Code'] = $_POST['zip'] ?? '';
                              $value['Item_Name'] = $_POST['item_name'] ?? '';
                              $value['Item_Number'] = $_POST['item_number'] ?? '';
                              $value['Item_Cost'] = $_POST['item_cost'] ?? '';
                              $value['Amount'] = $_POST['totalamount'] ?? '';
                              $value['pay_type'] = 'Magazine';
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
                      $amount = $_POST['totalamount'] ?? '';
                      $datefor =$_POST['pay_date'] ?? '';
                      $timestamp = !empty($datefor) ? strtotime($datefor) : false;
                      $payfinaldate = $timestamp ? date("m/d/Y", $timestamp) : '';
      
                      echo "<div style='text-align: -webkit-center;' class = 'pay'>
                      <table border='4' width='585px'>
                      <tr>
                      <td colspan='2'> <img src='../thankyouscreen.jpg' alt='' height='167px' style='margin-left:12em;'><h1 style='text-align:center;font-family:fangsong; font-size:30px;'><b>Houston Durga Bari Society</b></h1> </td> </tr>
                       <tr><td style='width:50%;'>Order Id</td> <td style='width:50%;'>" . $oid . "</td> </tr>
                       <tr><td>Member Id</td> <td>" . $memberid . "</td> </tr>
                       <tr><td>Member Name</td> <td>" . $mebername . "</td> </tr>
                      <tr><td>Amount</td> <td><span style='color:red;'>$</span>" . $amount . "</td> </tr>
                       <tr><td>Payment Method</td> <td>sumup</td>  </tr>
                       <tr><td>Payment Status</td> <td>Confirmed</td>  </tr>
                       <tr><td>Pay Date</td> <td>" . $payfinaldate . "</td>  </tr>
                       <tr><td colspan='2'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>   </tr>
                       </tr>";
                              echo "</table>";
                              if ($this->isAdmin() || $this->isEditor()) {
                                   echo " <a href='" . INSTALL_URL . "PujaMagazineadmin/index'>Go to home</a>";
                                  // echo " <a href='http://HDBS_Payment/Parking&Badges/PujaMagazineadmin/index'>Go to home</a>";
                              }
                              echo "</div>";
                      
                      exit();
      
                      }
      
                  elseif (($_POST['PaymentOption'] ?? '') == 'stripe') {
      
                  $amount = $_POST['totalamount'] ?? '';
                  
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
                                  //"currency" => $this->tpl["option_arr_values"]["currency"],
                                  "currency" => "USD",
                                  "card" => $_POST['stripeToken'] ?? '',
                                 "description" =>  "Pay For:" . ($_POST['pay_type'] ?? '') . ', ' . "Email:" . ($_POST['email'] ?? '') . ', ' . "Full Name:" . ($_POST['MemberName'] ?? ''),
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
                         // $id = $data['id'];
                          $opts['id'] =  $id;
                          $opts['stripe_return'] = $payment->status;
                          $opts['transaction_id'] = $payment->id;
                          $opts['paid_amount'] = $payment->amount;
                          $opts['stripe_product'] = $payment->description;
                          //$opts['payment_status'] = 'confirmed';
                          $opts['payment_status'] = 'confirmed';
                          $_POST['status'] = 'confirmed';
                          //$_POST['id'] = $id;
                          
                          $opts['payment_timestamp'] = time();
                          $data = $_POST;
                         //$this->sendEmailDonations($data);
                         $data = $_POST;
                         $datamemberarr = array();
                           $datamemberarr = array_merge($opts, $_POST);
                          $pujamagazineModel->update(array_merge($opts, $_POST));
                          $value = array();
                          $value['oid'] = $datamemberarr['oid'];
                          $value['eventid'] = $datamemberarr['eventid'] ?? '';
                          $value['type'] = $datamemberarr['type'] ?? '';
                          $value['Member_id'] = $datamemberarr['Member_id'] ?? '';
                          $value['MemberName'] = $datamemberarr['membername'] ?? '';
                          $value['PaymentOption'] = $datamemberarr['PaymentOption'] ?? '';
                          $value['payment_status'] = 'succeeded';
                          $value['payment_timestamp'] = $datamemberarr['payment_timestamp'] ?? '';
                          $value['Amount'] = $datamemberarr['totalamount'] ?? '';
                          $value['stripe_return'] = $datamemberarr['stripe_return'] ?? '';
                          $value['transaction_id'] = $datamemberarr['transaction_id'] ?? '';
                          $value['paid_amount'] = $datamemberarr['paid_amount'] ?? '';
                          $value['update_on'] = $datamemberarr['UpdateOn'] ?? '';
                          $value['stripe_product'] = $datamemberarr['stripe_product'] ?? '';
                          $value['pay_date'] = $datamemberarr['pay_date'] ?? '';
                          $value['pay_type'] = 'Magazine';
                          $value['pay_for'] = $datamemberarr['pay_for'] ?? '';
                          $value['Tele1'] = $datamemberarr['phone'] ?? '';
                          $value['email'] = $datamemberarr['email'] ?? '';
                          $value['spousename'] = $datamemberarr['spousename'] ?? '';
                          $value['Address'] = $datamemberarr['Address'] ?? '';
                          $value['Street'] = $datamemberarr['street'];
                          $value['City'] = $datamemberarr['city'];
                          $value['State'] = $datamemberarr['state'];
                          $value['Zip_Code'] = $datamemberarr['zip'];
                          $DonationModel->SaveDataInDonation($value);
                          if ($datamember == null) {
                              $value = array();
                              $value['oid'] = $_POST['oid'] ?? '';
                              $value['MemberName'] = $_POST['membername'] ?? '';
                              $value['Tele1'] = $_POST['phone'] ?? '';
                              $value['email'] = $_POST['email'] ?? '';
                              $value['City'] = $_POST['city'] ?? '';
                              $value['State'] = $_POST['state'] ?? '';
                              $value['Zip_Code'] = $_POST['zip'] ?? '';
                              $value['Item_Name'] = $_POST['item_name'] ?? '';
                              $value['Item_Number'] = $_POST['item_number'] ?? '';
                              $value['Item_Cost'] = $_POST['item_cost'] ?? '';
                              $value['Amount'] = $_POST['totalamount'] ?? '';
                              $value['pay_type'] = 'Magazine';
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
                      $amount = $_POST['totalamount'] ?? '';
                      $datefor =$_POST['pay_date'] ?? '';
                      $timestamp = !empty($datefor) ? strtotime($datefor) : false;
                      $payfinaldate = $timestamp ? date("m/d/Y", $timestamp) : '';
      
                      echo "<div style='text-align: -webkit-center;' class = 'pay'>
                      <table border='4' width='585px'>
                      <tr>
                      <td colspan='2'> <img src='../thankyouscreen.jpg' alt='' height='167px' style='margin-left:12em;'><h1 style='text-align:center;font-family:fangsong; font-size:30px;'><b>Houston Durga Bari Society</b></h1> </td> </tr>
                       <tr><td style='width:50%;'>Order Id</td> <td style='width:50%;'>" . $oid . "</td> </tr>
                       <tr><td>Member Id</td> <td>" . $memberid . "</td> </tr>
                       <tr><td>Member Name</td> <td>" . $mebername . "</td> </tr>
                        <tr><td>Amount</td> <td><span style='color:red;'>$</span>" . $amount . "</td> </tr>
                       <tr><td>Payment Method</td> <td>Stripe</td>  </tr>
                       <tr><td>Payment Status</td> <td>Confirmed</td>  </tr>
                       <tr><td>Pay Date</td> <td>" . $payfinaldate . "</td>  </tr>
                       <tr><td colspan='2'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>   </tr>
                       </tr>";
                              echo "</table>";
                              if ($this->isAdmin() || $this->isEditor()) {
                                  echo " <a href='" . INSTALL_URL . "PujaMagazineadmin/index'>Go to home</a>";
                                 // echo " <a href='http://HDBS_Payment/Parking&Badges/PujaMagazineadmin/index'>Go to home</a>";
                              }
                              echo "</div>";
                      
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
                  
                  $this->tpl['arr'] = $DonationModel->get($id) ?: [];
                  $this->tpl['arr']['totalamount'] = $total;
                    }else{
                   $_SESSION['status'] = 16;
                 
              }
               } else {
               $_SESSION['status'] = 17;
           }
          }

        } 
    }
}
