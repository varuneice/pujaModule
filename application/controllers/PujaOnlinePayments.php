<?php

require_once CONTROLLERS_PATH . 'App.php';

class PujaOnlinePayments extends App
{

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
        $this->js[] = array('file' => 'GzPujacart.js?v=' . time(), 'path' => JS_PATH);
        $this->js[] = array('file' => 'multiselect-dropdown.js?v=' . time(), 'path' => JS_PATH);
        $this->js[] = array('file' => 'loadingoverlay.js?v=' . time(), 'path' => JS_PATH);
    }

  function checkPujaRegitrationPaidParking()
  {
    $this->setIsAjax(true);
    GzObject::loadFiles('Model', array('pujaregistration'));
    $pujaregistrationModel = new pujaregistrationModel();
    $Memberid = $_POST['memberid'] ?? '';
    $arr = $pujaregistrationModel->checkRegistrationPuja($Memberid);
  }

  function membercheck()
  {
    $this->setIsAjax(true);
    GzObject::loadFiles('Model', array('Member'));
    $MemberModel = new MemberModel();
    $email = $_POST['email'] ?? '';
    $MemberModel->checkEmailExist($email);
  }

  // 11 june check register member for donation page
  function checkPujaRegitration()
  {
    $this->setIsAjax(true);
    GzObject::loadFiles('Model', array('pujaregistration'));
    $pujaregistrationModel = new pujaregistrationModel();
    $Memberid = $_POST['memberid'] ?? '';
    $pujaregistrationModel->checkRegistrationPuja($Memberid);
  }

  function checkCurrentSeasonPujaRegistration()
  {
    $this->setIsAjax(true);
    GzObject::loadFiles('Model', array('pujaregistration'));
    $pujaregistrationModel = new pujaregistrationModel();
    $Memberid = $_POST['memberid'] ?? '';
    $requestedPuja = $_POST['puja_type'] ?? '';

    $conflict = $pujaregistrationModel->getPujaRegistrationConflict($Memberid, $requestedPuja);
    if (!empty($Memberid) && !empty($conflict['blocked'])) {
      echo "<input id='memberdata' value='true'/>";
      echo "<input id='membermessage' value='" . htmlspecialchars($conflict['message'], ENT_QUOTES) . "'/>";
    } else {
      echo "<input id='memberdata' value='false'/>";
      echo "<input id='membermessage' value=''/>";
    }
  }

  function checkPujaRegitration2()
  {
    $this->setIsAjax(true);
    GzObject::loadFiles('Model', array('pujaregistration'));
    $pujaregistrationModel = new pujaregistrationModel();
    $Memberid = $_POST['memberid'] ?? '';
    $pujaregistrationModel->checkRegistrationPuja2($Memberid);
  }


  function memberphone()
  {
    $this->setIsAjax(true);
    GzObject::loadFiles('Model', array('Member'));
    $MemberModel = new MemberModel();
    $Tele = $_POST['Tele1'] ?? '';
    $MemberModel->checkMobileExist($Tele);
  }

  function checkemberregister()
  {
    $this->setIsAjax(true);
    GzObject::loadFiles('Model', array('pujaregistration'));
    $pujaregistrationModel = new pujaregistrationModel();
    $Memberid = $_POST['memberid'] ?? '';
    $arr = $pujaregistrationModel->checkemberregister($Memberid);
  }

  function getseniorpricedata()
  {
    $this->setIsAjax(true);
    GzObject::loadFiles('Model', array('pujaregistrationprice'));
    $pujaregistrationpriceModel = new pujaregistrationpriceModel();
    $arr = $pujaregistrationpriceModel->getseniorpricedata();

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

  function getadultchildprice()
  {
    $this->setIsAjax(true);
    GzObject::loadFiles('Model', array('pujaregistrationprice', 'pujaRegistrationDate'));
    $pujaregistrationpriceModel = new pujaregistrationpriceModel();
    try { $pujaregistrationpriceModel->ensureCurrentRegistrationRates(); } catch (Throwable $e) {}
    $pujaRegistrationDateModel = new pujaRegistrationDateModel();

    $pujaname = $_POST['pyjaname'] ?? '';
    $pricefor = $_POST['paymentfor'] ?? '';
    $row = $pujaregistrationpriceModel->getRegistrationPriceRow($pujaname, $pricefor, 'individual');

    if (!empty($row['id'])) {
      $adultBase = (float) ($row['price'] ?? 0);
      $lateFee = 0;
      $puaregistrationDate = $pujaRegistrationDateModel->getAll();
      $latefeedate = $puaregistrationDate[0]['registrationDate'] ?? '';

      date_default_timezone_set("America/Chicago");
      $today = date("Y-m-d");
      if ($latefeedate != '' && $today > $latefeedate) {
        $lateFee = (float) ($row['latefee'] ?? 0);
      }

      $adultTotal = $adultBase + $lateFee;
      echo "<input id='adultchildprice' value='" . htmlspecialchars($adultTotal, ENT_QUOTES) . "'/> ";
      echo "<input id='adultchildbaseprice' value='" . htmlspecialchars($adultBase, ENT_QUOTES) . "'/> ";
      echo "<input id='adultchildlatefee' value='" . htmlspecialchars($lateFee, ENT_QUOTES) . "'/> ";
    }
  }



  function getpujapricedata()
  {
        $this->setIsAjax(true);
    GzObject::loadFiles('Model', array('pujaregistrationprice', 'pujaRegistrationDate'));
    $pujaregistrationpriceModel = new pujaregistrationpriceModel();
    try { $pujaregistrationpriceModel->ensureCurrentRegistrationRates(); } catch (Throwable $e) {}
    $pujaRegistrationDateModel = new pujaRegistrationDateModel();

    $arr = $pujaregistrationpriceModel->getpujapricedata();
    $this->tpl['price'] = $arr;

    $puaregistrationDate = $pujaRegistrationDateModel->getAll();
    $latefeedate = $puaregistrationDate[0]['registrationDate'] ?? '';

    //for late fee
    date_default_timezone_set("America/Chicago");
    $today = date("Y-m-d");
    //$year =date('Y');
    //$latefeedate = $year."/"."09"."/"."28";

    if ($latefeedate != '' && $today > $latefeedate) {
      foreach ($arr as $key => $value) {
        $pricelatefee = $value['price'] + $value['latefee'];
        //echo '<option value="' . $value['price'] . '">' . $value['pricetype'] .  ' '.'$' . $value['price'] . '</option>';
        echo '<option value="' . $pricelatefee . '">' . $value['pricetype'] . ' ' . '$' . $pricelatefee . '</option>';
      }
    } else {
      foreach ($arr as $key => $value) {
        echo '<option value="' . $value['price'] . '">' . $value['pricetype'] . ' ' . '$' . $value['price'] . '</option>';

      }
    }
  }


  function userNewDocumentUpload()
  {
    GzObject::loadFiles('Model', array('pujaregistration', 'Donation'));
    $pujaregistrationModel = new pujaregistrationModel();
    $DonationModel = new DonationModel();

    $id = $_GET['id'] ?? '';
    if (!empty($id)) {
      $registrationarr = $pujaregistrationModel->get($id);

      $this->tpl['userData'] = $registrationarr;
      $this->tpl['id'] = $id;
    }

    if (!empty($_POST['uploadNewDocument'])) {
      $data = array();

      $documentUpload = $this->handlePujaRegistrationDocumentUpload($_FILES['image'] ?? array(), true);
      if (!empty($documentUpload['error'])) {
        echo "<div style='color:red;padding:20px;font-size:18px;'>Document Upload Error: " . htmlspecialchars($documentUpload['error'], ENT_QUOTES) . "</div>";
        exit();
      }
      $data['addressavatar'] = $documentUpload['filename'];
      $newAvatar = $data['addressavatar'];
      $userId = $_POST["userId"] ?? '';
      $membername = $_POST["memberName"] ?? '';
      $pujatype = $_POST["pujaType"] ?? '';

      $pujaregistrationModel->updateDocument($userId, $newAvatar);

      $purpose = "New Document Uploaded for verification";
      $payement_status = "New Document";


      $Emailcc = '';
      $subjetc = 'Puja New Document Upload Request';
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
              <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Full Name&nbsp;&nbsp;</td>
              <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">' . $membername . '</td>
              </tr>
              <tr>
              <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Puja Type&nbsp;&nbsp;</td>
              <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $pujatype . '</td>
              </tr>

               <tr>
              <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Purpose&nbsp;&nbsp;</td>
              <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $purpose . '</td>
              </tr>

               <tr>
              <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Payment Status&nbsp;&nbsp;</td>
              <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $payement_status . '</td>
              </tr>
              
              ';


      $email = $_POST['memberEmail'] ?? '';
      if ($email != null) {
        $this->sendEmailticket($message, $subjetc, $email, $Emailcc);
      }
      $textmsg = 'Your New Document for Puja Registration verification  have been submitted  Full Name: ' . $membername . ', Puja Type: ' . $pujatype . ', Purpose: $' . $purpose;


      $mobileno = $_POST['memberphone'] ?? '';
      if ($mobileno != null) {
        //   $this->SendSMS($mobileno, $textmsg);
      }

      Util::redirect(INSTALL_URL . "onlinepujapayments/onlinepujapayments");

      exit();

    }



  }

  private function logPujaRegError($message) {
      $logFile = __DIR__ . '/../../pujaregistrationlog.log';
      file_put_contents($logFile, '[' . date('Y-m-d H:i:s') . '] ' . $message . PHP_EOL, FILE_APPEND);
  }

  private function handlePujaRegistrationDocumentUpload($file, $required = false)
  {
      if (empty($file) || !isset($file['error']) || (int) $file['error'] === UPLOAD_ERR_NO_FILE) {
          return $required ? array('error' => 'Please upload a document.') : array('filename' => '');
      }

      if ((int) $file['error'] !== UPLOAD_ERR_OK) {
          return array('error' => 'The document could not be uploaded. Please try again.');
      }

      $maxSize = 8 * 1024 * 1024;
      if ((int) ($file['size'] ?? 0) > $maxSize) {
          return array('error' => 'Document file size must be 8 MB or less.');
      }

      $originalName = strtolower((string) ($file['name'] ?? ''));
      $extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
      $allowedExtensions = array('jpg', 'jpeg', 'png', 'pdf');
      if (!in_array($extension, $allowedExtensions, true)) {
          return array('error' => 'Only jpg, jpeg, png, or pdf documents are allowed.');
      }

      $uploadDir = INSTALL_PATH . UPLOAD_PATH . 'avatar/thumb/';
      if (!is_dir($uploadDir)) {
          return array('error' => 'Document upload folder is not available.');
      }

      $safeName = time() . '_' . mt_rand(1000, 9999);
      if ($extension === 'pdf') {
          $mime = function_exists('mime_content_type') ? (string) @mime_content_type($file['tmp_name']) : '';
          $header = (string) @file_get_contents($file['tmp_name'], false, null, 0, 4);
          if ($mime !== '' && stripos($mime, 'pdf') === false && $header !== '%PDF') {
              return array('error' => 'The selected PDF document could not be verified.');
          }

          $filename = $safeName . '.pdf';
          if (!move_uploaded_file($file['tmp_name'], $uploadDir . $filename)) {
              return array('error' => 'Problem uploading document.');
          }

          return array('filename' => $filename);
      }

      $imageInfo = @getimagesize($file['tmp_name']);
      if (empty($imageInfo[0]) || empty($imageInfo[1])) {
          return array('error' => 'Document image could not be read.');
      }

      if ((int) $imageInfo[0] < 800 || (int) $imageInfo[1] < 500) {
          return array('error' => 'Document image is too small or not clear enough. Please upload a clearer document.');
      }

      $aspectRatio = (float) $imageInfo[0] / max(1, (float) $imageInfo[1]);
      if ($aspectRatio < 0.45 || $aspectRatio > 3.2) {
          return array('error' => 'Document image is not framed clearly. Please upload the full document.');
      }

      require_once APP_PATH . 'helpers/uploader/class.upload.php';
      $handle = new upload($file);
      if (!$handle->uploaded) {
          return array('error' => 'Problem uploading document image.');
      }

      $handle->file_new_name_body = $safeName;
      $handle->image_resize = true;
      $handle->image_x = 200;
      $handle->image_ratio_y = true;
      $handle->allowed = array('image/*');
      $handle->process($uploadDir);

      if (!$handle->processed) {
          return array('error' => $handle->error ?: 'Problem processing document image.');
      }

      $filename = $handle->file_dst_name;
      $handle->clean();

      return array('filename' => $filename);
  }

  function PujaOnlinePayments() {
    // action method — __construct() handles data loading
  }

  function __construct()
  {

    $this->layout = 'login';
    GzObject::loadFiles('Model', array('pujaregistration', 'pujaRegistrationDate', 'pujaregistrationChildBirthYear', 'Member', 'pujaregistrationsetting', 'pujaytdtier'));
    $pujaregistrationModel = new pujaregistrationModel();
    $pujaRegistrationDateModel = new pujaRegistrationDateModel();
    $pujaregistrationChildBirthYear = new pujaregistrationChildBirthYearModel();
    $MemberModel = new MemberModel();
    $PujaRegistrationSettingModel = new pujaregistrationsettingModel();
    $PujaYtdTierModel = new pujaytdtierModel();

    $puaregistrationDate = $pujaRegistrationDateModel->getAll();
    $formatDate = $puaregistrationDate[0]['registrationDate'] ?? '';
    $latefeedate = '';
    if (!empty($formatDate)) {
      try {
        $date = new DateTime($formatDate);
        $latefeedate = $date->format("F j, Y");
      } catch (Throwable $e) {
        $this->logPujaRegError('INVALID REGISTRATION DATE | ' . $formatDate . ' | ' . $e->getMessage());
      }
    }

    $this->tpl['latefeedate'] = $latefeedate;
    date_default_timezone_set("America/Chicago");
    $currentDate = date("F j, Y");
    $this->tpl['currentDate'] = $currentDate;
    $pujaregistrationChildBirth = $pujaregistrationChildBirthYear->getAll([]);
    $this->tpl['pujaregistrationChildBirth'] = $pujaregistrationChildBirth;
    $this->tpl['child_yob_cutoff'] = '2004';
    try {
      // Safe on all environments: trims model schema to only real DB columns.
      $pujaregistrationModel->syncSchemaWithTableColumns();

      $host = strtolower((string) ($_SERVER['HTTP_HOST'] ?? ''));
      $isLocalHost = $host === '' || strpos($host, 'localhost') !== false || strpos($host, '127.0.0.1') !== false;
      if ($isLocalHost) {
        $PujaRegistrationSettingModel->ensureTable();
        $PujaRegistrationSettingModel->seedDefaults(date('Y'));
        $PujaYtdTierModel->ensureTable();
        $PujaYtdTierModel->seedDefaults(date('Y'));
      }

      $this->tpl['child_yob_cutoff'] = $PujaRegistrationSettingModel->getActiveSettingValue('child_yob_cutoff', '2004', date('Y'));
      $this->tpl['parent_ytd_threshold'] = $PujaRegistrationSettingModel->getActiveSettingValue('parent_ytd_threshold', '749', date('Y'));
      $this->tpl['puja_ytd_tiers'] = $PujaYtdTierModel->getActiveTiers(date('Y'));
    } catch (Throwable $settingEx) {
      $this->logPujaRegError('REGISTRATION SETTING ERROR | ' . $settingEx->getMessage());
    }

    if (!empty($_POST['create_registrationpayment_request'])) {
      try {
        $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
        if (RateLimit::isBlocked('payment', $ip)) {
            http_response_code(429);
            die("Too many payment submissions. Please wait 15 minutes before trying again.");
        }
        $conflict = $pujaregistrationModel->getPujaRegistrationConflict($_POST['Member_id'] ?? '', $_POST['puja_type'] ?? '');
        if (!empty($_POST['Member_id']) && !empty($conflict['blocked'])) {
            echo "<div style='color:red;padding:20px;font-size:18px;'>" . htmlspecialchars($conflict['message'], ENT_QUOTES) . "</div>";
            echo "<a href='javascript:history.back()'>Go Back</a>";
            exit();
        }
        RateLimit::record('payment', $ip);

        $this->logPujaRegError('FORM SUBMIT START | donation=' . ($_POST['donation'] ?? '') . ' | totalamount=' . ($_POST['totalamount'] ?? '') . ' | puja_type=' . ($_POST['puja_type'] ?? '') . ' | IP=' . $ip);

        if (!empty($_POST['co_register_adult_members'])) {
          $adultMemberCount = (int) ($_POST['adult_member_count'] ?? 0);
          $adultMemberAmount = (float) ($_POST['extraadultregistration'] ?? 0);
          $adultRows = $this->extractAdultMemberRowsFromPost($_POST);
          $adultMemberCount = max(0, min($adultMemberCount, 3, count($adultRows)));
          if ($adultMemberCount > 0) {
            $_POST['extraadultregistration'] = $adultMemberAmount > 0 ? (string) $adultMemberAmount : '';
            $this->storeAdultMembersInRegistrationPost($_POST, $adultRows, $adultMemberCount, $_POST['extraadultregistration']);
          } else {
            $this->clearAdultMemberStorageFields($_POST);
            $_POST['extraadultregistration'] = '';
          }
        } else {
          $this->clearAdultMemberStorageFields($_POST);
          $_POST['extraadultregistration'] = '';
        }

        $data = array();
        $documentUpload = $this->handlePujaRegistrationDocumentUpload($_FILES['image'] ?? array(), false);
        if (!empty($documentUpload['error'])) {
            echo "<div style='color:red;padding:20px;font-size:18px;'>Document Upload Error: " . htmlspecialchars($documentUpload['error'], ENT_QUOTES) . "</div>";
            exit();
        }
        if (!empty($documentUpload['filename'])) {
            $data['addressavatar'] = $documentUpload['filename'];
        }

        $id = null;
        try {
            $id = $pujaregistrationModel->save(array_merge($_POST, $data));
            $this->logPujaRegError('SAVE OK | id=' . $id);
        } catch (Throwable $saveEx) {
            $this->logPujaRegError('SAVE ERROR | ' . $saveEx->getMessage());
            echo "<div style='color:red;padding:20px;font-size:18px;'>Submission Error: " . htmlspecialchars($saveEx->getMessage()) . "</div>";
            exit();
        }

        if (!empty($id)) {

          $opts = array();
          $opts['id'] = $id;
          $opts['status'] = 'pending';
          $data = $_POST;
          try {
              $this->sendEmailDonations($data);
          } catch (\Exception $e) {
              error_log('[PujaOnlinePayments] Email failed: ' . $e->getMessage());
              $this->logPujaRegError('EMAIL ERROR | ' . $e->getMessage());
          }

          try {
              $pujaregistrationModel->update(array_merge($opts, $_POST));
          } catch (Throwable $updateEx) {
              $this->logPujaRegError('UPDATE ERROR | ' . $updateEx->getMessage());
          }

          $this->logPujaRegError('MEMBER ADDRESS UPDATE CHECK | member_id=' . ($_POST['Member_id'] ?? '') . ' | update_address=' . ($_POST['update_address'] ?? '') . ' | street=' . ($_POST['street'] ?? '') . ' | streetname=' . ($_POST['streetname'] ?? '') . ' | city=' . ($_POST['city'] ?? '') . ' | state=' . ($_POST['state'] ?? '') . ' | zip=' . ($_POST['zip'] ?? ''));
          if (!empty($_POST['Member_id'])) {
            try {
                $addressUpdated = $MemberModel->updateAddressWithHistory($_POST['Member_id'], $_POST, 'Puja Registration Request');
                $this->logPujaRegError('MEMBER ADDRESS UPDATE ' . ($addressUpdated ? 'OK' : 'SKIPPED') . ' | member_id=' . $_POST['Member_id']);
            } catch (Throwable $addressEx) {
                $this->logPujaRegError('MEMBER ADDRESS UPDATE ERROR | ' . $addressEx->getMessage());
            }
          } else {
            $this->logPujaRegError('MEMBER ADDRESS UPDATE SKIPPED | missing Member_id | update_address=' . ($_POST['update_address'] ?? ''));
          }

          $memberfname = $_POST['First_name'] ?? '';
          $memberlname = $_POST['Last_name'] ?? '';
          $pujatype = $_POST['puja_type'] ?? '';
          $pujacategory = $_POST['puja_category'] ?? '';
          $totalamount = $_POST['totalamount'] ?? '';

          echo "<div style='text-align: -webkit-center;' class = 'pay'>
                        <table border='4'  width='585px' style='margin-left:4em;'>
                        <tr>
                        <td colspan='2'> <img src='../HDBS_Logo_HiRes.png' alt='' height='167px' style='margin-left:12em;'><h1 style='text-align:center;font-family:fangsong; font-size:30px;'><b>Houston Durga Bari Society</b></h1> </td>
                        <tr><td colspan='2'><span style='font-size: 18px;font-family: serif;'>Thank You for the Request. You will receive a Payment Link soon from our team after Verification of the Submitted document.</span></td></tr>
                        <tr><td style='width:50%;'>Name</td> <td style='width:50%;'>" . $memberfname . " " . $memberlname . "</td> </tr>
                        <tr><td>Registered in HDBS Puja System As</td> <td>" . $pujacategory . "</td> </tr>
                        <tr><td>Puja Type</td> <td>" . $pujatype . "</td> </tr>
                        <tr><td>Total Amount</td> <td><span style= 'color:red;'>$</span>" . $totalamount . "</td> </tr>
                         <tr><td>Purpose</td> <td><span style= 'color:red;'></span>Puja Registration</td> </tr>
                        <tr><td>Payment Status</td> <td>Pending</td>  </tr>
                       <tr><td colspan='2'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>   </tr>
                       </tr>";
          echo "</table>";
          echo "<a  href='" . INSTALL_URL . "PujaOnlinePayments/PujaOnlinePayments'>Go to home</a>";
          echo "</div>";

        }

        exit();

      } catch (Throwable $topEx) {
          $this->logPujaRegError('TOP-LEVEL EXCEPTION | ' . $topEx->getMessage() . ' | File=' . $topEx->getFile() . ':' . $topEx->getLine());
          echo "<div style='color:red;padding:20px;font-size:18px;'>Submission Error: " . htmlspecialchars($topEx->getMessage()) . "</div>";
          exit();
      }
    }
  }

  function checkPaidParking()
  {
    header('Content-Type: application/json'); // Tell browser it's JSON

    GzObject::loadFiles('Model', array('pujaregistration'));
    $pujaregistrationModel = new pujaregistrationModel();
    $Memberid = $_POST['memberid'] ?? '';
    $arr = $pujaregistrationModel->checkRegistrationPaidParking($Memberid);
    echo json_encode($arr);

    exit; // VERY IMPORTANT to prevent layout/templates from loading
  }


}



?>
