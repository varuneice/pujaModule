<?php

require_once CONTROLLERS_PATH . 'App.php';

class PujaPaidpasses extends App {

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
        $this->js[] = array('file' => 'GzPujaPasses.js?v=' . $cacheBust, 'path' => JS_PATH);
        $this->js[] = array('file' => 'multiselect-dropdown.js?v=' . $cacheBust, 'path' => JS_PATH);
        $this->js[] = array('file' => 'loadingoverlay.js?v=' . $cacheBust, 'path' => JS_PATH);
    }

function getpujapricedata()
    {
        $this->setIsAjax(true);
      GzObject::loadFiles('Model', array('pujapassesprice'));
      $pujapassespriceModel = new pujapassespriceModel();
      $arr = $pujapassespriceModel->getpujapricedata();
      $this->tpl['price'] = $arr;
      foreach ($arr as $key => $value) {
          echo '<option value="' . $value['price'] . '">' . $value['pricetype'] .  ' '.'$' . $value['price'] . '</option>';

      }
    }

    function getparentprice()
    {
        $this->setIsAjax(true);
        GzObject::loadFiles('Model', array('pujaregistrationprice', 'pujaRegistrationDate'));
        $pujaregistrationpriceModel = new pujaregistrationpriceModel();
        try { $pujaregistrationpriceModel->ensureCurrentRegistrationRates(); } catch (Throwable $e) {}
        $pujaRegistrationDateModel = new pujaRegistrationDateModel();

        $pujaname = $_POST['pyjaname'] ?? '';
        $pricefor = $_POST['paymentfor'] ?? '';
        $pricetype = $_POST['pricetype'] ?? '';
        $row = $pujaregistrationpriceModel->getRegistrationPriceRow($pujaname, $pricefor, $pricetype);

        if (!empty($row['id'])) {
            $parentBase = (float) ($row['parentregisration'] ?? 0);
            $lateFee = 0;
            $puaregistrationDate = $pujaRegistrationDateModel->getAll();
            $latefeedate = $puaregistrationDate[0]['registrationDate'] ?? '';

            date_default_timezone_set("America/Chicago");
            $today = date("Y-m-d");
            if ($latefeedate != '' && $today > $latefeedate) {
                $lateFeeRow = $pujaregistrationpriceModel->getRegistrationPriceRow($pujaname, $pricefor, 'individual');
                $lateFee = (float) ($lateFeeRow['latefee'] ?? 0);
            }

            $parentTotal = $parentBase + $lateFee;
            echo "<input id='parentprice' value='" . htmlspecialchars($parentTotal, ENT_QUOTES) . "'/> ";
            echo "<input id='parentbaseprice' value='" . htmlspecialchars($parentBase, ENT_QUOTES) . "'/> ";
            echo "<input id='parentlatefee' value='" . htmlspecialchars($lateFee, ENT_QUOTES) . "'/> ";
        }
    }

      function PujaPaidpasses() {
    // action method — __construct() handles data loading
  }

  function __construct()
    {
        
        
        // Util::redirect(INSTALL_URL . "Associatepayments/Associatepayments");
        // exit();
                
                
        $this->layout = 'login';
       GzObject::loadFiles('Model', array('pujapasses','ConfirmCode', 'Member', 'Donation', 'idnumbers', 'User', 'pujapassesprice'));
       $pujapassesModel = new pujapassesModel();
       $DonationModel = new DonationModel();
       $ConfirmCodeModel = new ConfirmCodeModel();
       $MemberModel = new MemberModel();
       $idnumbersModel = new idnumbersModel();
       $UserModel = new UserModel();
       $pujapassespriceModel = new pujapassespriceModel();
       
        $opts = array();
        $arr = $pujapassespriceModel->getAllpujapassesprice($opts);
        $this->tpl['pujaname'] = $arr;
    

        if (!empty($_POST['create_passespayment_request'])) {
                if (($_POST['PaymentOption'] ?? '') == null) {
               
               $data = array();

        if (!empty($_FILES['image'])) {
            $fileextension = $_FILES['image']['type'];
            $newfileextension = explode("/", $fileextension);
            $filetype = strtolower($newfileextension[1] ?? '');
            if ($filetype == "pdf") {
                require_once APP_PATH . 'helpers/uploader/class.upload.php';
                $targetfolder = INSTALL_PATH . UPLOAD_PATH . 'avatar/thumb/';
                $imgdata = $_FILES['image']['name'];
                $newimgdata = explode(".", $imgdata);
                $img_name = time();
                $finaldocumentname = $img_name . '.' .$filetype;
                $targetfolder = $targetfolder . basename($finaldocumentname);

                if (move_uploaded_file($_FILES['image']['tmp_name'], $targetfolder)) {
                    $data['studentavatar'] = $finaldocumentname;
                } else {
                    echo "Problem uploading file";
                }

            }


            if ($filetype != "pdf") {
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
                    $data['studentavatar'] = $handle->file_dst_name;
                }
            }
        }
         date_default_timezone_set("America/Chicago");
        $today = date("Y/m/d");
        $_POST['CreatedAt'] = $today;
        $_POST['pay_date'] = $today;
        $_POST['pay_for'] = 'Puja Passes';
        $_POST['pay_type'] = 'Puja Passes';
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
        $_POST['student'] = isset($_POST['student']) && is_numeric($_POST['student']) ? (int)$_POST['student'] : 0;
        $_POST['outoftowner'] = isset($_POST['outoftowner']) && is_numeric($_POST['outoftowner']) ? (int)$_POST['outoftowner'] : 0;
        $_POST['member_veggie'] = isset($_POST['member_veggie']) && is_numeric($_POST['member_veggie']) ? (int)$_POST['member_veggie'] : 0;
        $_POST['spouse_veggie'] = isset($_POST['spouse_veggie']) && is_numeric($_POST['spouse_veggie']) ? (int)$_POST['spouse_veggie'] : 0;
        $_POST['parent1_veggie'] = isset($_POST['parent1_veggie']) && is_numeric($_POST['parent1_veggie']) ? (int)$_POST['parent1_veggie'] : 0;
        $_POST['parent2_veggie'] = isset($_POST['parent2_veggie']) && is_numeric($_POST['parent2_veggie']) ? (int)$_POST['parent2_veggie'] : 0;
        $_POST['no_of_parent'] = isset($_POST['no_of_parent']) && in_array((string) $_POST['no_of_parent'], array('1', '2'), true) ? (string) $_POST['no_of_parent'] : '';
        if ($_POST['no_of_parent'] === '') {
            $_POST['parent1_fname'] = '';
            $_POST['parent1_lname'] = '';
            $_POST['parent2_fname'] = '';
            $_POST['parent2_lname'] = '';
            $_POST['extraparentregistration'] = '';
        } elseif ($_POST['no_of_parent'] === '1') {
            $_POST['parent2_fname'] = '';
            $_POST['parent2_lname'] = '';
            $_POST['parent2_veggie'] = 0;
        }
        $_POST['Age1'] = isset($_POST['Age1']) && is_numeric($_POST['Age1']) ? (int)$_POST['Age1'] : 0;
        $_POST['Age2'] = isset($_POST['Age2']) && is_numeric($_POST['Age2']) ? (int)$_POST['Age2'] : 0;
        $_POST['Age3'] = isset($_POST['Age3']) && is_numeric($_POST['Age3']) ? (int)$_POST['Age3'] : 0;
        $id = $pujapassesModel->save(array_merge($_POST, $data));
        // echo "<script>alert(' $id')</script>";
                if (!empty($id)) {
                           
                          $opts = array();
                            $opts['id'] = $id;
                            $opts['status'] = 'pending';
                            $data = $_POST;
                           //$this->sendEmailDonations($data);
                            $pujapassesModel->update(array_merge($opts, $_POST));

                       $memberfname = $_POST['First_name'] ?? '';
                        $memberlname = $_POST['Last_name'] ?? '';
                        $pujatype = $_POST['puja_type'] ?? '';
                        $pujacategory = $_POST['puja_category'] ?? '';
                        $totalamount = $_POST['totalamount'] ?? '';
                            echo "<div style='text-align: -webkit-center;' class = 'pay'>
                      <table border='4'  width='585px' style='margin-left:4em;'>
                      <tr>
                      <td colspan='2'> <img src='../HDBS_Logo_HiRes.png' alt='' height='167px' style='margin-left:12em;'><h1 style='text-align:center;font-family:fangsong; font-size:30px;'><b>Houston Durga Bari Society</b></h1> </td>
                      <tr><td colspan='2'><span style='font-size: 18px;font-family: serif;'>Thank You for the Request. You will receive a Payment Link soon from our team after Verification of the Submitted data.</span></td></tr>
                      <tr><td style='width:50%;'>Full Name</td> <td style='width:50%;'>" . $memberfname . " " . $memberlname . "</td> </tr>
                      <tr><td>Puja Type</td> <td>" . $pujatype . "</td> </tr>
                      <tr><td>Payable Amount</td> <td><span style= 'color:red;'>$</span>" . $totalamount . "</td> </tr>
                      <tr><td>Purpose</td> <td><span style= 'color:red;'></span>Puja Passes</td> </tr>
                      <tr><td>Payment Status</td> <td>Pending</td>  </tr>
                      <tr><td colspan='2'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>   </tr>
                      </tr>";
        echo "</table>";
        echo "<a  href='" . INSTALL_URL . "PujaPaidpasses/PujaPaidpasses/'>Go to home</a>";
        echo "</div>";

                   $Emailcc = 'pujaregpayment@durgabari.org';
                   $subjetc = 'Paid Passes Request';
                       $memberfname = $_POST['First_name'] ?? '';
                        $memberlname = $_POST['Last_name'] ?? '';
                        $pujatype = $_POST['puja_type'] ?? '';
                        $pujacategory = $_POST['puja_category'] ?? '';
                        $totalamount = $_POST['totalamount'] ?? '';

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
      <td style="text-align: center; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;"><strong>Paid Passes Detail</strong></td>
      </tr>
      </tbody>
      </table>
      </div>
      <div class="email-token-class" style="text-align: center;">
      <table style="height: 190px; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;" width="604">
      <tbody>
      <tr>
      <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Member Name&nbsp;&nbsp;</td>
      <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">' . $memberfname . ' ' . $memberlname . '</td>
      </tr>
      <tr>
      <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Puja Type &nbsp;&nbsp;</td>
      <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $pujatype . '</td>
      </tr>
      <tr>
      <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Payable Amount &nbsp;&nbsp;</td>
      <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;"><span style="color:red;">$</span>' . $totalamount . '</td>
      </tr>
      <tr>
      <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Payment Status &nbsp;</td>
      <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;"><span style="color:red;"></span>Pending</td>
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
                $msg = 'Houston Durga Bari: Your Paid Passes request have been submitted Member Name: '. $memberfname . ' ' . $memberlname.', Puja Type: '. $pujatype.', Payable Amount: $'. $totalamount;
                $this->SendSMS($mobileno, $msg);
            }
          
                }
                exit();

            }  else{
      $data = array();
      date_default_timezone_set("America/Chicago");
      $today = date("Y/m/d");
      $_POST['pay_date'] = $today;
      $_POST['CreatedAt'] = $today;
      $_POST['pay_for'] = 'Puja Passes';
      $_POST['pay_type'] = 'Puja Passes';
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
              $alternatemobile = $MemberModel->checktele2($datamember);
                 // for update telephone no member case
                if($alternatemobile == null || $alternatemobile != $_POST['alternatenumber'] ?? ''){
                    $mobileno =  $_POST['alternatenumber'] ?? '';
                    $MemberModel->updatetelephone($datamember, $mobileno);
                }
      }

        $regmember = $_POST['regmember'] ?? '';
        if($regmember == "nonmember"){
            $nonmember = $_POST['namenonmember'] ?? ''; 
            $_POST['name'] = $nonmember;
          } if($regmember == "member"){
                $_POST['name'] = $_POST['MemberName'] ?? ''; ;  
          } 

          if ($this->isAdmin() || $this->isEditor()) {
            $id = $this->getUserId();
            $admin = $UserModel->get($id);
            $rolename = $admin['first'].' '.$admin['last'];
            $_POST['admin_id'] = $admin['id'];
            $_POST['admin_name'] = $rolename;

        } 
        // Sanitize tinyint/int fields — unset checkbox values arrive as missing from $_POST
        $_POST['student'] = isset($_POST['student']) && is_numeric($_POST['student']) ? (int)$_POST['student'] : 0;
        $_POST['outoftowner'] = isset($_POST['outoftowner']) && is_numeric($_POST['outoftowner']) ? (int)$_POST['outoftowner'] : 0;
        $_POST['member_veggie'] = isset($_POST['member_veggie']) && is_numeric($_POST['member_veggie']) ? (int)$_POST['member_veggie'] : 0;
        $_POST['spouse_veggie'] = isset($_POST['spouse_veggie']) && is_numeric($_POST['spouse_veggie']) ? (int)$_POST['spouse_veggie'] : 0;
        $_POST['parent1_veggie'] = isset($_POST['parent1_veggie']) && is_numeric($_POST['parent1_veggie']) ? (int)$_POST['parent1_veggie'] : 0;
        $_POST['parent2_veggie'] = isset($_POST['parent2_veggie']) && is_numeric($_POST['parent2_veggie']) ? (int)$_POST['parent2_veggie'] : 0;
        $_POST['no_of_parent'] = isset($_POST['no_of_parent']) && in_array((string) $_POST['no_of_parent'], array('1', '2'), true) ? (string) $_POST['no_of_parent'] : '';
        if ($_POST['no_of_parent'] === '') {
            $_POST['parent1_fname'] = '';
            $_POST['parent1_lname'] = '';
            $_POST['parent2_fname'] = '';
            $_POST['parent2_lname'] = '';
            $_POST['extraparentregistration'] = '';
        } elseif ($_POST['no_of_parent'] === '1') {
            $_POST['parent2_fname'] = '';
            $_POST['parent2_lname'] = '';
            $_POST['parent2_veggie'] = 0;
        }
        $_POST['Age1'] = isset($_POST['Age1']) && is_numeric($_POST['Age1']) ? (int)$_POST['Age1'] : 0;
        $_POST['Age2'] = isset($_POST['Age2']) && is_numeric($_POST['Age2']) ? (int)$_POST['Age2'] : 0;
        $_POST['Age3'] = isset($_POST['Age3']) && is_numeric($_POST['Age3']) ? (int)$_POST['Age3'] : 0;
        $id = $pujapassesModel->save(array_merge($_POST));
         if (!empty($id)) {
                    // for email ui 
                    $memberid = $_POST['Member_id'] ?? '';
                    $mebername = ($_POST['First_name'] ?? '') . ' ' . ($_POST['Last_name'] ?? '');
                    $oid = $_POST['oid'] ?? '';
                    $amount = $_POST['totalamount'] ?? '';
                    $parkingspot = $_POST['puja_type'] ?? '';
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
                    $subjetc = 'HDBS Paid Passes Payment Confirmation';
                    $Emailcc = 'pujaassocpayment@durgabari.org';
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
                    <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Passes For&nbsp;&nbsp;</td>
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
                    $textmsg = 'Houston Durga Bari: Paid Passes Confirmation are Member Id: ' . $memberid . ', Order Id: ' . $oid . ', Member Name: ' . $mebername . ', Passes For: ' . $parkingspot . ',  Amount: $' . $amount . ' , Payment Method: ' . $payui . ' , Pay Date: ' . $payfinaldate;
                   
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
            $value['oid'] = $datamemberarr['oid'];
            $value['Member_id'] = $datamemberarr['Member_id'];
            $value['MemberName'] = $datamemberarr['First_name'].''.$datamemberarr['Last_name'];
            $value['PaymentOption'] = $datamemberarr['PaymentOption'];
            $value['payment_status'] = 'succeeded';
            $value['payment_timestamp'] = $datamemberarr['payment_timestamp'] ?? '';
            $value['Amount'] = $datamemberarr['totalamount'];
            $value['stripe_return'] = $datamemberarr['stripe_return'] ?? '';
            $value['transaction_id'] = $datamemberarr['transaction_id'];
            $value['paid_amount'] = $datamemberarr['paid_amount'] ?? '';
            $value['update_on'] = $datamemberarr['UpdateOn'] ?? '';
            $value['stripe_product'] = $datamemberarr['stripe_product'] ?? '';
            $value['pay_date'] = $datamemberarr['pay_date'];
            $value['pay_type'] = 'Puja Passes';
            $value['pay_for'] = $datamemberarr['pay_for'];
            $value['Tele1'] = $datamemberarr['phone'];
            $value['email'] = $datamemberarr['email'];
            $value['spousename'] = $datamemberarr['Sp_fname'].''.$datamemberarr['Sp_lname'];
            $value['Street'] = $datamemberarr['street'];
            $value['Address'] = $datamemberarr['streetname'];
            $value['City'] = $datamemberarr['city'];
            $value['State'] = $datamemberarr['state'];
            $value['Zip_Code'] = $datamemberarr['zip'];
            $value['admin_id'] = $datamemberarr['admin_id'];
            $value['admin_name'] = $datamemberarr['admin_name'];
            $DonationModel->SaveDataInDonation($value);
            if ($datamember == null) {
                $value = array();
                $value['oid'] = $_POST['oid'] ?? '';
                $value['MemberName'] = ($_POST['First_name'] ?? '') . ' ' . ($_POST['Last_name'] ?? '');
                $value['Tele1'] = $_POST['phone'] ?? '';
                $value['email'] = $_POST['email'] ?? '';
                $value['Amount'] = $_POST['totalamount'] ?? '';
                $value['pay_type'] = 'Puja Passes';
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
                $value['spousename'] = ($_POST['spousename'] ?? '') . ($_POST['Sp_lname'] ?? '');
                $value['Street'] = $_POST['street'] ?? '';
                $value['Address'] = $_POST['streetname'] ?? '';
                $value['Address3'] = $_POST['unit'] ?? '';
                $value['City'] = $_POST['city'] ?? '';
                $value['State'] = $_POST['state'] ?? '';
                $value['Zip_Code'] = $_POST['zip'] ?? '';
                $value['Child1'] = ($_POST['childonefname'] ?? '') . ' ' . ($_POST['childonelname'] ?? '');
                $value['Age1'] = $_POST['Age1'] ?? '';
                $value['Child2'] = ($_POST['childtwofname'] ?? '') . ' ' . ($_POST['childtwolname'] ?? '');
                $value['Age2'] = $_POST['Age2'] ?? '';
                $value['Child3'] = ($_POST['childthreefname'] ?? '') . ' ' . ($_POST['childthreelname'] ?? '');
                $value['Age3'] = $_POST['Age3'] ?? '';
                $value['Parent1'] = ($_POST['parent1_fname'] ?? '') . ' ' . ($_POST['parent1_lname'] ?? '');
                $value['Parent2'] = ($_POST['parent2_fname'] ?? '') . ' ' . ($_POST['parent2_lname'] ?? '');
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
                    $membername = ($_POST['First_name'] ?? '') . ' ' . ($_POST['Last_name'] ?? '');
                    $pujatype = $_POST['puja_type'] ?? '';
                    $totalamount = $_POST['totalamount'] ?? '';
                    $oid = $_POST['oid'] ?? '';
                    $datefor = $_POST['pay_date'] ?? '';
                    $timestamp = !empty($datefor) ? strtotime($datefor) : false;
                    $payfinaldate = $timestamp ? date("m/d/Y", $timestamp) : '';
                    
                    echo "<div style='text-align: -webkit-center;' class = 'pay'>
                    <table border='4' width='585px'>
                    <tr>
                    <td colspan='2'> <img src='../thankyouscreen.jpg' alt='' height='167px' style='margin-left:12em;'><h1 style='text-align:center;font-family:fangsong; font-size:30px;'><b>Houston Durga Bari Society</b></h1> </td>
                     </tr>
                     <tr><td style='width:50%;'>Order Id</td> <td style='width:50%;'>" . $oid . "</td> </tr>
                     <tr><td>Member Id</td> <td>" . $memberid . "</td> </tr>
                     <tr><td>Full Name</td> <td>" . $membername . "</td> </tr>
                     <tr><td>Puja Type</td> <td>" . $pujatype . "</td></tr>
                     <tr><td>Payment Method</td> <td>Zelle</td>  </tr>
                     <tr><td>Total Amount</td> <td><span style='color:red;'>$</span>" . $totalamount . "</td> </tr>
                     <tr><td>Payment Status</td> <td>Confirmed</td>  </tr>
                     <tr><td>Pay Date</td> <td>" . $payfinaldate . "</td>  </tr>
                     <tr><td colspan='2' style='font-weight: bold;color:red;'>An email with your payment information has been sent to your registered email address. Please check your spam folder if you cannot find the email in your inbox</td></tr>
                     <tr><td colspan='2'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>   </tr>
                     </tr>";
                            echo "</table>";
                            if ($this->isAdmin() || $this->isEditor()) {
                                echo " <a href='" . INSTALL_URL . "PujaPassesadmin/index'>Go to home</a>";
                                // echo " <a href='http://localhost:8082/HDBS_Payment/Parking&Badges/PujaPassesadmin/index'>Go to home</a>";
                            }
                            echo "</div>";

                exit();
            }
          } 
          
          elseif (($_POST['PaymentOption'] ?? '') == 'check') {
            $_POST['item_cost'] = $_POST['checkAmount'] ?? '';
            $_POST['bank'] = $_POST['checkbankname'] ?? '';
            $_POST['chkdate'] = $_POST['CheckDate'] ?? '';
            $_POST['DepositAccount'] = $_POST['CheckDepositAccount'] ?? '';
            $_POST['payment_status'] = 'confirmed';
            $_POST['status'] = 'confirmed';
            $_POST['id'] =  $id;
            $data = $_POST;
            $datamemberarr = array();
            $datamemberarr = array_merge($_POST);
            $pujapassesModel->update(array_merge($_POST));
            $value = array();
            $value['oid'] = $datamemberarr['oid'];
            $value['Member_id'] = $datamemberarr['Member_id'];
            $value['MemberName'] = $datamemberarr['First_name'].''.$datamemberarr['Last_name'];
            $value['PaymentOption'] = $datamemberarr['PaymentOption'];
            $value['payment_status'] = 'succeeded';
            $value['payment_timestamp'] = $datamemberarr['payment_timestamp'] ?? '';
            $value['Amount'] = $datamemberarr['totalamount'];
            $value['stripe_return'] = $datamemberarr['stripe_return'] ?? '';
            $value['transaction_id'] = $datamemberarr['transaction_id'];
            $value['paid_amount'] = $datamemberarr['paid_amount'] ?? '';
            $value['update_on'] = $datamemberarr['UpdateOn'] ?? '';
            $value['stripe_product'] = $datamemberarr['stripe_product'] ?? '';
            $value['pay_date'] = $datamemberarr['pay_date'];
            $value['pay_type'] = 'Puja Passes';
            $value['pay_for'] = $datamemberarr['pay_for'];
            $value['Tele1'] = $datamemberarr['phone'];
            $value['email'] = $datamemberarr['email'];
            $value['spousename'] = $datamemberarr['Sp_fname'].''.$datamemberarr['Sp_lname'];
            $value['Street'] = $datamemberarr['street'];
            $value['Address'] = $datamemberarr['streetname'];
            $value['City'] = $datamemberarr['city'];
            $value['State'] = $datamemberarr['state'];
            $value['Zip_Code'] = $datamemberarr['zip'];
            $value['bank'] = $datamemberarr['bank'];
            $value['chkdate'] = $datamemberarr['chkdate'];
            $value['chkno'] = $datamemberarr['chkno'];
            $value['admin_id'] = $datamemberarr['admin_id'];
            $value['admin_name'] = $datamemberarr['admin_name'];
            $value['DepositAccount'] = $datamemberarr['DepositAccount'];
            $DonationModel->SaveDataInDonation($value);
            if ($datamember == null) {
                $value = array();
                $value['oid'] = $_POST['oid'] ?? '';
                $value['MemberName'] = ($_POST['First_name'] ?? '') . ' ' . ($_POST['Last_name'] ?? '');
                $value['Tele1'] = $_POST['phone'] ?? '';
                $value['email'] = $_POST['email'] ?? '';
                $value['Amount'] = $_POST['totalamount'] ?? '';
                $value['pay_type'] = 'Puja Passes';
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
                $value['spousename'] = ($_POST['spousename'] ?? '') . ($_POST['Sp_lname'] ?? '');
                $value['Street'] = $_POST['street'] ?? '';
                $value['Address'] = $_POST['streetname'] ?? '';
                $value['Address3'] = $_POST['unit'] ?? '';
                $value['City'] = $_POST['city'] ?? '';
                $value['State'] = $_POST['state'] ?? '';
                $value['Zip_Code'] = $_POST['zip'] ?? '';
                $value['Child1'] = ($_POST['childonefname'] ?? '') . ' ' . ($_POST['childonelname'] ?? '');
                $value['Age1'] = $_POST['Age1'] ?? '';
                $value['Child2'] = ($_POST['childtwofname'] ?? '') . ' ' . ($_POST['childtwolname'] ?? '');
                $value['Age2'] = $_POST['Age2'] ?? '';
                $value['Child3'] = ($_POST['childthreefname'] ?? '') . ' ' . ($_POST['childthreelname'] ?? '');
                $value['Age3'] = $_POST['Age3'] ?? '';
                $value['Parent1'] = ($_POST['parent1_fname'] ?? '') . ' ' . ($_POST['parent1_lname'] ?? '');
                $value['Parent2'] = ($_POST['parent2_fname'] ?? '') . ' ' . ($_POST['parent2_lname'] ?? '');
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
                    $membername = ($_POST['First_name'] ?? '') . ' ' . ($_POST['Last_name'] ?? '');
                    $pujatype = $_POST['puja_type'] ?? '';
                    $totalamount = $_POST['totalamount'] ?? '';
                    $oid = $_POST['oid'] ?? '';
                    $datefor = $_POST['pay_date'] ?? '';
                    $timestamp = !empty($datefor) ? strtotime($datefor) : false;
                    $payfinaldate = $timestamp ? date("m/d/Y", $timestamp) : '';
                    
                    echo "<div style='text-align: -webkit-center;' class = 'pay'>
                    <table border='4' width='585px'>
                    <tr>
                    <td colspan='2'> <img src='../thankyouscreen.jpg' alt='' height='167px' style='margin-left:12em;'><h1 style='text-align:center;font-family:fangsong; font-size:30px;'><b>Houston Durga Bari Society</b></h1> </td>
                     </tr>
                     <tr><td style='width:50%;'>Order Id</td> <td style='width:50%;'>" . $oid . "</td> </tr>
                     <tr><td>Member Id</td> <td>" . $memberid . "</td> </tr>
                     <tr><td>Full Name</td> <td>" . $membername . "</td> </tr>
                     <tr><td>Puja Type</td> <td>" . $pujatype . "</td></tr>
                     <tr><td>Payment Method</td> <td>Check</td>  </tr>
                     <tr><td>Total Amount</td> <td><span style='color:red;'>$</span>" . $totalamount . "</td> </tr>
                     <tr><td>Payment Status</td> <td>Confirmed</td>  </tr>
                     <tr><td>Pay Date</td> <td>" . $payfinaldate . "</td>  </tr>
                     <tr><td colspan='2' style='font-weight: bold;color:red;'>An email with your payment information has been sent to your registered email address. Please check your spam folder if you cannot find the email in your inbox</td></tr>
                     <tr><td colspan='2'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>   </tr>
                     </tr>";
                            echo "</table>";
                            if ($this->isAdmin() || $this->isEditor()) {
                                echo " <a href='" . INSTALL_URL . "PujaPassesadmin/index'>Go to home</a>";
                                 //echo " <a href='http://localhost:8082/HDBS_Payment/Parking&Badges/PujaPassesadmin/index'>Go to home</a>";
                            }
                            echo "</div>";

                        exit();
          }
          
          elseif (($_POST['PaymentOption'] ?? '') == 'cash') {
            $_POST['amount'] = $_POST['cashAmount'] ?? '';
            $_POST['pay_date'] = $_POST['cashDate'] ?? '';
            $_POST['DepositAccount'] = $_POST['CashDepositAccount'] ?? '';
            $_POST['payment_status'] = 'confirmed';
            $_POST['status'] = 'confirmed';
            $_POST['id'] =  $id;
            $data = $_POST;
            $datamemberarr = array();
            $datamemberarr = array_merge($_POST);
            $pujapassesModel->update(array_merge($_POST));
            $value = array();
            $value['oid'] = $datamemberarr['oid'];
            $value['Member_id'] = $datamemberarr['Member_id'];
            $value['MemberName'] = $datamemberarr['First_name'].''.$datamemberarr['Last_name'];
            $value['PaymentOption'] = $datamemberarr['PaymentOption'];
            $value['payment_status'] = 'succeeded';
            $value['payment_timestamp'] = $datamemberarr['payment_timestamp'] ?? '';
            $value['Amount'] = $datamemberarr['totalamount'];
            $value['stripe_return'] = $datamemberarr['stripe_return'] ?? '';
            $value['transaction_id'] = $datamemberarr['transaction_id'];
            $value['paid_amount'] = $datamemberarr['paid_amount'] ?? '';
            $value['update_on'] = $datamemberarr['UpdateOn'] ?? '';
            $value['stripe_product'] = $datamemberarr['stripe_product'] ?? '';
            $value['pay_date'] = $datamemberarr['pay_date'];
            $value['pay_type'] = 'Puja Passes';
            $value['pay_for'] = $datamemberarr['pay_for'];
            $value['Tele1'] = $datamemberarr['phone'];
            $value['email'] = $datamemberarr['email'];
            $value['spousename'] = $datamemberarr['Sp_fname'].''.$datamemberarr['Sp_lname'];
            $value['Street'] = $datamemberarr['street'];
            $value['Address'] = $datamemberarr['streetname'];
            $value['City'] = $datamemberarr['city'];
            $value['State'] = $datamemberarr['state'];
            $value['Zip_Code'] = $datamemberarr['zip'];
            $value['ReceiveBy'] = $datamemberarr['receiveby'];
            $value['admin_id'] = $datamemberarr['admin_id'];
            $value['admin_name'] = $datamemberarr['admin_name'];
            $value['DepositAccount'] = $datamemberarr['DepositAccount'];
            $DonationModel->SaveDataInDonation($value);
            if ($datamember == null) {
                $value = array();
                $value['oid'] = $_POST['oid'] ?? '';
                $value['MemberName'] = ($_POST['First_name'] ?? '') . ' ' . ($_POST['Last_name'] ?? '');
                $value['Tele1'] = $_POST['phone'] ?? '';
                $value['email'] = $_POST['email'] ?? '';
                $value['Amount'] = $_POST['totalamount'] ?? '';
                $value['pay_type'] = 'Puja Passes';
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
                $value['spousename'] = ($_POST['spousename'] ?? '') . ($_POST['Sp_lname'] ?? '');
                $value['Street'] = $_POST['street'] ?? '';
                $value['Address'] = $_POST['streetname'] ?? '';
                $value['Address3'] = $_POST['unit'] ?? '';
                $value['City'] = $_POST['city'] ?? '';
                $value['State'] = $_POST['state'] ?? '';
                $value['Zip_Code'] = $_POST['zip'] ?? '';
                $value['Child1'] = ($_POST['childonefname'] ?? '') . ' ' . ($_POST['childonelname'] ?? '');
                $value['Age1'] = $_POST['Age1'] ?? '';
                $value['Child2'] = ($_POST['childtwofname'] ?? '') . ' ' . ($_POST['childtwolname'] ?? '');
                $value['Age2'] = $_POST['Age2'] ?? '';
                $value['Child3'] = ($_POST['childthreefname'] ?? '') . ' ' . ($_POST['childthreelname'] ?? '');
                $value['Age3'] = $_POST['Age3'] ?? '';
                $value['Parent1'] = ($_POST['parent1_fname'] ?? '') . ' ' . ($_POST['parent1_lname'] ?? '');
                $value['Parent2'] = ($_POST['parent2_fname'] ?? '') . ' ' . ($_POST['parent2_lname'] ?? '');
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
                    $membername = ($_POST['First_name'] ?? '') . ' ' . ($_POST['Last_name'] ?? '');
                    $pujatype = $_POST['puja_type'] ?? '';
                    $totalamount = $_POST['totalamount'] ?? '';
                    $oid = $_POST['oid'] ?? '';
                    $datefor = $_POST['pay_date'] ?? '';
                    $timestamp = !empty($datefor) ? strtotime($datefor) : false;
                    $payfinaldate = $timestamp ? date("m/d/Y", $timestamp) : '';
                    
                    echo "<div style='text-align: -webkit-center;' class = 'pay'>
                    <table border='4' width='585px'>
                    <tr>
                    <td colspan='2'> <img src='../thankyouscreen.jpg' alt='' height='167px' style='margin-left:12em;'><h1 style='text-align:center;font-family:fangsong; font-size:30px;'><b>Houston Durga Bari Society</b></h1> </td>
                     </tr>
                     <tr><td style='width:50%;'>Order Id</td> <td style='width:50%;'>" . $oid . "</td> </tr>
                     <tr><td>Member Id</td> <td>" . $memberid . "</td> </tr>
                     <tr><td>Full Name</td> <td>" . $membername . "</td> </tr>
                     <tr><td>Puja Type</td> <td>" . $pujatype . "</td></tr>
                     <tr><td>Payment Method</td> <td>Cash</td>  </tr>
                     <tr><td>Total Amount</td> <td><span style='color:red;'>$</span>" . $totalamount . "</td> </tr>
                     <tr><td>Payment Status</td> <td>Confirmed</td>  </tr>
                     <tr><td>Pay Date</td> <td>" . $payfinaldate . "</td>  </tr>
                     <tr><td colspan='2' style='font-weight: bold;color:red;'>An email with your payment information has been sent to your registered email address. Please check your spam folder if you cannot find the email in your inbox</td></tr>
                     <tr><td colspan='2'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>   </tr>
                     </tr>";
                            echo "</table>";
                            if ($this->isAdmin() || $this->isEditor()) {
                                echo " <a href='" . INSTALL_URL . "PujaPassesadmin/index'>Go to home</a>";
                                //echo " <a href='http://localhost:8082/HDBS_Payment/Parking&Badges/PujaPassesadmin/index'>Go to home</a>";
                            }
                            echo "</div>";

                        exit();
          }
          elseif (($_POST['PaymentOption'] ?? '') == 'directdeposit') {
            $_POST['bank'] = $_POST['directbank'] ?? '';
            $_POST['transaction_id'] = $_POST['transactioncode'] ?? '';
            $_POST['amount'] = $_POST['directdepositeamount'] ?? '';
            $_POST['pay_date'] = $_POST['transactiondate'] ?? '';
            $_POST['DepositAccount'] = $_POST['DirectPayDepositAccount'] ?? '';
            $_POST['payment_status'] = 'confirmed';
            $_POST['status'] = 'confirmed';
            $_POST['id'] =  $id;
            $data = $_POST;
            $datamemberarr = array();
            $datamemberarr = array_merge($_POST);
            $pujapassesModel->update(array_merge($_POST));
            $value = array();
            $value['oid'] = $datamemberarr['oid'];
            $value['Member_id'] = $datamemberarr['Member_id'];
            $value['MemberName'] = $datamemberarr['First_name'].''.$datamemberarr['Last_name'];
            $value['PaymentOption'] = $datamemberarr['PaymentOption'];
            $value['payment_status'] = 'succeeded';
            $value['payment_timestamp'] = $datamemberarr['payment_timestamp'] ?? '';
            $value['Amount'] = $datamemberarr['totalamount'];
            $value['stripe_return'] = $datamemberarr['stripe_return'] ?? '';
            $value['transaction_id'] = $datamemberarr['transaction_id'];
            $value['paid_amount'] = $datamemberarr['paid_amount'] ?? '';
            $value['update_on'] = $datamemberarr['UpdateOn'] ?? '';
            $value['stripe_product'] = $datamemberarr['stripe_product'] ?? '';
            $value['pay_date'] = $datamemberarr['pay_date'];
            $value['pay_type'] = 'Puja Passes';
            $value['pay_for'] = $datamemberarr['pay_for'];
            $value['Tele1'] = $datamemberarr['phone'];
            $value['email'] = $datamemberarr['email'];
            $value['spousename'] = $datamemberarr['Sp_fname'].''.$datamemberarr['Sp_lname'];
            $value['Street'] = $datamemberarr['street'];
            $value['Address'] = $datamemberarr['streetname'];
            $value['City'] = $datamemberarr['city'];
            $value['State'] = $datamemberarr['state'];
            $value['Zip_Code'] = $datamemberarr['zip'];
            $value['bank'] = $datamemberarr['bank'];
            $value['admin_id'] = $datamemberarr['admin_id'];
            $value['admin_name'] = $datamemberarr['admin_name'];
            $value['DepositAccount'] = $datamemberarr['DepositAccount'];
            $DonationModel->SaveDataInDonation($value);
            if ($datamember == null) {
                $value = array();
                $value['oid'] = $_POST['oid'] ?? '';
                $value['MemberName'] = ($_POST['First_name'] ?? '') . ' ' . ($_POST['Last_name'] ?? '');
                $value['Tele1'] = $_POST['phone'] ?? '';
                $value['email'] = $_POST['email'] ?? '';
                $value['Amount'] = $_POST['totalamount'] ?? '';
                $value['pay_type'] = 'Puja Passes';
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
                $value['spousename'] = ($_POST['spousename'] ?? '') . ($_POST['Sp_lname'] ?? '');
                $value['Street'] = $_POST['street'] ?? '';
                $value['Address'] = $_POST['streetname'] ?? '';
                $value['Address3'] = $_POST['unit'] ?? '';
                $value['City'] = $_POST['city'] ?? '';
                $value['State'] = $_POST['state'] ?? '';
                $value['Zip_Code'] = $_POST['zip'] ?? '';
                $value['Child1'] = ($_POST['childonefname'] ?? '') . ' ' . ($_POST['childonelname'] ?? '');
                $value['Age1'] = $_POST['Age1'] ?? '';
                $value['Child2'] = ($_POST['childtwofname'] ?? '') . ' ' . ($_POST['childtwolname'] ?? '');
                $value['Age2'] = $_POST['Age2'] ?? '';
                $value['Child3'] = ($_POST['childthreefname'] ?? '') . ' ' . ($_POST['childthreelname'] ?? '');
                $value['Age3'] = $_POST['Age3'] ?? '';
                $value['Parent1'] = ($_POST['parent1_fname'] ?? '') . ' ' . ($_POST['parent1_lname'] ?? '');
                $value['Parent2'] = ($_POST['parent2_fname'] ?? '') . ' ' . ($_POST['parent2_lname'] ?? '');
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
                    $membername = ($_POST['First_name'] ?? '') . ' ' . ($_POST['Last_name'] ?? '');
                    $pujatype = $_POST['puja_type'] ?? '';
                    $totalamount = $_POST['totalamount'] ?? '';
                    $oid = $_POST['oid'] ?? '';
                    $datefor = $_POST['pay_date'] ?? '';
                    $timestamp = !empty($datefor) ? strtotime($datefor) : false;
                    $payfinaldate = $timestamp ? date("m/d/Y", $timestamp) : '';
                    
                    echo "<div style='text-align: -webkit-center;' class = 'pay'>
                    <table border='4' width='585px'>
                    <tr>
                    <td colspan='2'> <img src='../thankyouscreen.jpg' alt='' height='167px' style='margin-left:12em;'><h1 style='text-align:center;font-family:fangsong; font-size:30px;'><b>Houston Durga Bari Society</b></h1> </td>
                     </tr>
                     <tr><td style='width:50%;'>Order Id</td> <td style='width:50%;'>" . $oid . "</td> </tr>
                     <tr><td>Member Id</td> <td>" . $memberid . "</td> </tr>
                     <tr><td>Full Name</td> <td>" . $membername . "</td> </tr>
                     <tr><td>Puja Type</td> <td>" . $pujatype . "</td></tr>
                     <tr><td>Payment Method</td> <td>Online Deposit</td>  </tr>
                     <tr><td>Total Amount</td> <td><span style='color:red;'>$</span>" . $totalamount . "</td> </tr>
                     <tr><td>Payment Status</td> <td>Confirmed</td>  </tr>
                     <tr><td>Pay Date</td> <td>" . $payfinaldate . "</td>  </tr>
                     <tr><td colspan='2' style='font-weight: bold;color:red;'>An email with your payment information has been sent to your registered email address. Please check your spam folder if you cannot find the email in your inbox</td></tr>
                     <tr><td colspan='2'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>   </tr>
                     </tr>";
                            echo "</table>";
                            if ($this->isAdmin() || $this->isEditor()) {
                                echo " <a href='" . INSTALL_URL . "PujaPassesadmin/index'>Go to home</a>";
                                 //echo " <a href='http://localhost:8082/HDBS_Payment/Parking&Badges/PujaPassesadmin/index'>Go to home</a>";
                            }
                            echo "</div>";

                        exit();
          }
          elseif (($_POST['PaymentOption'] ?? '') == 'sumup') {
            $_POST['amount'] = $_POST['sumupamount'] ?? '';
            $_POST['transaction_id'] = $_POST['sumupid'] ?? '';
            $_POST['pay_date'] = $_POST['sumupdate'] ?? '';
            $_POST['DepositAccount'] = $_POST['SumUpDepositAccount'] ?? '';
            $_POST['payment_status'] = 'confirmed';
            $_POST['status'] = 'confirmed';
            $_POST['id'] =  $id;
            $data = $_POST;
            $datamemberarr = array();
            $datamemberarr = array_merge($_POST);
            $pujapassesModel->update(array_merge($_POST));
            $value = array();
            $value['oid'] = $datamemberarr['oid'];
            $value['Member_id'] = $datamemberarr['Member_id'];
            $value['MemberName'] = $datamemberarr['First_name'].''.$datamemberarr['Last_name'];
            $value['PaymentOption'] = $datamemberarr['PaymentOption'];
            $value['payment_status'] = 'succeeded';
            $value['payment_timestamp'] = $datamemberarr['payment_timestamp'] ?? '';
            $value['Amount'] = $datamemberarr['totalamount'];
            $value['stripe_return'] = $datamemberarr['stripe_return'] ?? '';
            $value['transaction_id'] = $datamemberarr['transaction_id'];
            $value['paid_amount'] = $datamemberarr['paid_amount'] ?? '';
            $value['update_on'] = $datamemberarr['UpdateOn'] ?? '';
            $value['stripe_product'] = $datamemberarr['stripe_product'] ?? '';
            $value['pay_date'] = $datamemberarr['pay_date'];
            $value['pay_type'] = 'Puja Passes';
            $value['pay_for'] = $datamemberarr['pay_for'];
            $value['Tele1'] = $datamemberarr['phone'];
            $value['email'] = $datamemberarr['email'];
            $value['spousename'] = $datamemberarr['Sp_fname'].''.$datamemberarr['Sp_lname'];
            $value['Street'] = $datamemberarr['street'];
            $value['Address'] = $datamemberarr['streetname'];
            $value['City'] = $datamemberarr['city'];
            $value['State'] = $datamemberarr['state'];
            $value['Zip_Code'] = $datamemberarr['zip'];
            $value['admin_id'] = $datamemberarr['admin_id'];
            $value['admin_name'] = $datamemberarr['admin_name'];
            $value['DepositAccount'] = $datamemberarr['DepositAccount'];
            $DonationModel->SaveDataInDonation($value);
            if ($datamember == null) {
                $value = array();
                $value['oid'] = $_POST['oid'] ?? '';
                $value['MemberName'] = ($_POST['First_name'] ?? '') . ' ' . ($_POST['Last_name'] ?? '');
                $value['Tele1'] = $_POST['phone'] ?? '';
                $value['email'] = $_POST['email'] ?? '';
                $value['Amount'] = $_POST['totalamount'] ?? '';
                $value['pay_type'] = 'Puja Passes';
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
                $value['spousename'] = ($_POST['spousename'] ?? '') . ($_POST['Sp_lname'] ?? '');
                $value['Street'] = $_POST['street'] ?? '';
                $value['Address'] = $_POST['streetname'] ?? '';
                $value['Address3'] = $_POST['unit'] ?? '';
                $value['City'] = $_POST['city'] ?? '';
                $value['State'] = $_POST['state'] ?? '';
                $value['Zip_Code'] = $_POST['zip'] ?? '';
                $value['Child1'] = ($_POST['childonefname'] ?? '') . ' ' . ($_POST['childonelname'] ?? '');
                $value['Age1'] = $_POST['Age1'] ?? '';
                $value['Child2'] = ($_POST['childtwofname'] ?? '') . ' ' . ($_POST['childtwolname'] ?? '');
                $value['Age2'] = $_POST['Age2'] ?? '';
                $value['Child3'] = ($_POST['childthreefname'] ?? '') . ' ' . ($_POST['childthreelname'] ?? '');
                $value['Age3'] = $_POST['Age3'] ?? '';
                $value['Parent1'] = ($_POST['parent1_fname'] ?? '') . ' ' . ($_POST['parent1_lname'] ?? '');
                $value['Parent2'] = ($_POST['parent2_fname'] ?? '') . ' ' . ($_POST['parent2_lname'] ?? '');
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
                    $membername = ($_POST['First_name'] ?? '') . ' ' . ($_POST['Last_name'] ?? '');
                    $pujatype = $_POST['puja_type'] ?? '';
                    $totalamount = $_POST['totalamount'] ?? '';
                    $oid = $_POST['oid'] ?? '';
                    $datefor = $_POST['pay_date'] ?? '';
                    $timestamp = !empty($datefor) ? strtotime($datefor) : false;
                    $payfinaldate = $timestamp ? date("m/d/Y", $timestamp) : '';
                    
                    echo "<div style='text-align: -webkit-center;' class = 'pay'>
                    <table border='4' width='585px'>
                    <tr>
                    <td colspan='2'> <img src='../thankyouscreen.jpg' alt='' height='167px' style='margin-left:12em;'><h1 style='text-align:center;font-family:fangsong; font-size:30px;'><b>Houston Durga Bari Society</b></h1> </td>
                     </tr>
                     <tr><td style='width:50%;'>Order Id</td> <td style='width:50%;'>" . $oid . "</td> </tr>
                     <tr><td>Member Id</td> <td>" . $memberid . "</td> </tr>
                     <tr><td>Full Name</td> <td>" . $membername . "</td> </tr>
                     <tr><td>Puja Type</td> <td>" . $pujatype . "</td></tr>
                     <tr><td>Payment Method</td> <td>SumUp</td>  </tr>
                     <tr><td>Total Amount</td> <td><span style='color:red;'>$</span>" . $totalamount . "</td> </tr>
                     <tr><td>Payment Status</td> <td>Confirmed</td>  </tr>
                     <tr><td>Pay Date</td> <td>" . $payfinaldate . "</td>  </tr>
                     <tr><td colspan='2' style='font-weight: bold;color:red;'>An email with your payment information has been sent to your registered email address. Please check your spam folder if you cannot find the email in your inbox</td></tr>
                     <tr><td colspan='2'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>   </tr>
                     </tr>";
                            echo "</table>";
                            if ($this->isAdmin() || $this->isEditor()) {
                                echo " <a href='" . INSTALL_URL . "PujaPassesadmin/index'>Go to home</a>";
                                // echo " <a href='http://localhost:8082/HDBS_Payment/Parking&Badges/PujaPassesadmin/index'>Go to home</a>";
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

                $payment = Stripe_Charge::create(
                    array(
                        "amount" => $amount,
                        "currency" => "USD",
                        //"currency" => $this->tpl["option_arr_values"]["currency"],
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
                    $value['oid'] = $datamemberarr['oid'];
                    $value['Member_id'] = $datamemberarr['Member_id'];
                    $value['MemberName'] = $datamemberarr['First_name'].''.$datamemberarr['Last_name'];
                    $value['PaymentOption'] = $datamemberarr['PaymentOption'];
                    $value['payment_status'] = 'succeeded';
                    $value['payment_timestamp'] = $datamemberarr['payment_timestamp'] ?? '';
                    $value['Amount'] = $datamemberarr['totalamount'];
                    $value['stripe_return'] = $datamemberarr['stripe_return'] ?? '';
                    $value['transaction_id'] = $datamemberarr['transaction_id'];
                    $value['paid_amount'] = $datamemberarr['paid_amount'] ?? '';
                    $value['update_on'] = $datamemberarr['UpdateOn'] ?? '';
                    $value['stripe_product'] = $datamemberarr['stripe_product'] ?? '';
                    $value['pay_date'] = $datamemberarr['pay_date'];
                    $value['pay_type'] = 'Puja Passes';
                    $value['pay_for'] = $datamemberarr['pay_for'];
                    $value['Tele1'] = $datamemberarr['phone'];
                    $value['email'] = $datamemberarr['email'];
                    $value['spousename'] = $datamemberarr['Sp_fname'].''.$datamemberarr['Sp_lname'];
                    $value['Street'] = $datamemberarr['street'];
                    $value['Address'] = $datamemberarr['streetname'];
                    $value['City'] = $datamemberarr['city'];
                    $value['State'] = $datamemberarr['state'];
                    $value['Zip_Code'] = $datamemberarr['zip'];
                    $value['admin_id'] = $datamemberarr['admin_id'];
                    $value['admin_name'] = $datamemberarr['admin_name'];
                    $DonationModel->SaveDataInDonation($value);
                    if ($datamember == null) {
                        $value = array();
                        $value['oid'] = $_POST['oid'] ?? '';
                        $value['MemberName'] = ($_POST['First_name'] ?? '') . ' ' . ($_POST['Last_name'] ?? '');
                        $value['Tele1'] = $_POST['phone'] ?? '';
                        $value['email'] = $_POST['email'] ?? '';
                        $value['Amount'] = $_POST['totalamount'] ?? '';
                        $value['pay_type'] = 'Puja Passes';
                        $value['pay_for'] = $_POST['pay_for'] ?? '';
                        $value['pay_date'] = $_POST['pay_date'] ?? '';
                        $value['payment_timestamp'] = $opts['payment_timestamp'] ?? '';
                        $value['transaction_id'] = $opts['transaction_id'];
                        $value['paid_amount'] = $opts['paid_amount'] ?? '';
                        $value['stripe_return'] = $opts['stripe_return'] ?? '';
                        $value['remarks'] = $_POST['remarks'] ?? '';
                        $value['created_on'] = $_POST['created_on'] ?? '';
                        $value['update_on'] = $_POST['update_on'] ?? '';
                        $value['PaymentOption'] = $_POST['PaymentOption'] ?? '';
                        $value['payment_status'] = 'confirmed';
                        $value['cc_name'] = $_POST['cc_name'] ?? '';
                        $value['Member_id'] = $_POST['Member_id'] ?? '';
                        $value['spousename'] = ($_POST['spousename'] ?? '') . ($_POST['Sp_lname'] ?? '');
                        $value['Street'] = $_POST['street'] ?? '';
                        $value['Address'] = $_POST['streetname'] ?? '';
                        $value['Address3'] = $_POST['unit'] ?? '';
                        $value['City'] = $_POST['city'] ?? '';
                        $value['State'] = $_POST['state'] ?? '';
                        $value['Zip_Code'] = $_POST['zip'] ?? '';
                        $value['Child1'] = ($_POST['childonefname'] ?? '') . ' ' . ($_POST['childonelname'] ?? '');
                        $value['Age1'] = $_POST['Age1'] ?? '';
                        $value['Child2'] = ($_POST['childtwofname'] ?? '') . ' ' . ($_POST['childtwolname'] ?? '');
                        $value['Age2'] = $_POST['Age2'] ?? '';
                        $value['Child3'] = ($_POST['childthreefname'] ?? '') . ' ' . ($_POST['childthreelname'] ?? '');
                        $value['Age3'] = $_POST['Age3'] ?? '';
                        $value['Parent1'] = ($_POST['parent1_fname'] ?? '') . ' ' . ($_POST['parent1_lname'] ?? '');
                        $value['Parent2'] = ($_POST['parent2_fname'] ?? '') . ' ' . ($_POST['parent2_lname'] ?? '');
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
                    $membername = ($_POST['First_name'] ?? '') . ' ' . ($_POST['Last_name'] ?? '');
                    $pujatype = $_POST['puja_type'] ?? '';
                    $totalamount = $_POST['totalamount'] ?? '';
                    $oid = $_POST['oid'] ?? '';
                    $datefor = $_POST['pay_date'] ?? '';
                    $timestamp = !empty($datefor) ? strtotime($datefor) : false;
                    $payfinaldate = $timestamp ? date("m/d/Y", $timestamp) : '';
                    
                    echo "<div style='text-align: -webkit-center;' class = 'pay'>
                    <table border='4' width='585px'>
                    <tr>
                    <td colspan='2'> <img src='../thankyouscreen.jpg' alt='' height='167px' style='margin-left:12em;'><h1 style='text-align:center;font-family:fangsong; font-size:30px;'><b>Houston Durga Bari Society</b></h1> </td>
                     </tr>
                     <tr><td style='width:50%;'>Order Id</td> <td style='width:50%;'>" . $oid . "</td> </tr>
                     <tr><td>Member Id</td> <td>" . $memberid . "</td> </tr>
                     <tr><td>Full Name</td> <td>" . $membername . "</td> </tr>
                     <tr><td>Puja Type</td> <td>" . $pujatype . "</td></tr>
                     <tr><td>Payment Method</td> <td>Stripe</td>  </tr>
                     <tr><td>Total Amount</td> <td><span style='color:red;'>$</span>" . $totalamount . "</td> </tr>
                     <tr><td>Payment Status</td> <td>Confirmed</td>  </tr>
                     <tr><td>Pay Date</td> <td>" . $payfinaldate . "</td>  </tr>
                     <tr><td colspan='2' style='font-weight: bold;color:red;'>An email with your payment information has been sent to your registered email address. Please check your spam folder if you cannot find the email in your inbox</td></tr>
                     <tr><td colspan='2'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>   </tr>
                     </tr>";
                            echo "</table>";
                            if ($this->isAdmin() || $this->isEditor()) {
                                echo " <a href='" . INSTALL_URL . "PujaPassesadmin/index'>Go to home</a>";
                                // echo " <a href='http://localhost:8082/HDBS_Payment/Parking&Badges/PujaPassesadmin/index'>Go to home</a>";
                            }
                            echo "</div>";
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
        } else {
          $_SESSION['status'] = 17;
        }
        exit();

      }
    }
      
}

}


?>
