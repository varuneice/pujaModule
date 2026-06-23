<?php

require_once CONTROLLERS_PATH . 'App.php';

class PujaTicket extends App
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
    $this->js[] = array('file' => 'GzTicket.js?v=' . time(), 'path' => JS_PATH);
    $this->js[] = array('file' => 'loadingoverlay.js?v=' . time(), 'path' => JS_PATH);
  }

  //for get ticket evet data 
  function getticketdata()
  {
        $this->setIsAjax(true);
    GzObject::loadFiles('Model', array('ticketeventname'));
    $ticketeventnameModel = new ticketeventnameModel();
    $eventname = $_POST['pujatype'] ?? '';
    $arr = $ticketeventnameModel->getticketdata($eventname);
  }

  // end
//for get ticket price family or individual
  function ticketprice()
  {
        $this->setIsAjax(true);
    GzObject::loadFiles('Model', array('PujaTicketPrice'));
    $PujaTicketPriceModel = new PujaTicketPriceModel();
    $arr = $PujaTicketPriceModel->getpriceticket();
  }

  //end

  // Current event in ticket start
  function checkticket()
  {
        $this->setIsAjax(true);
    GzObject::loadFiles('Model', array('ticketeventname'));
    $ticketeventnameModel = new ticketeventnameModel();
    $arr = $ticketeventnameModel->checkticket();
    $name = $arr['ticketevents'];
    $image = $arr['ticketavatar'];
    $desc = $arr['descriptionTable'];
    $eventid = $arr['id'];
    $arr1 = ['Events' => $name];
    $arr2 = ['Image' => $image];
    $arr3 = ['Desc' => $desc];
    $arr4 = ['Idevent' => $eventid];
    $arr5 = $arr1 + $arr2 + $arr3 + $arr4;


    echo json_encode($arr5);

  }
  // end

  //function for ticket payment

    function PujaTicket() {
    // action method — __construct() handles data loading
  }

  private function logPujaError($message)
  {
      $logFile = __DIR__ . '/../../pujaticketlog.log';
      file_put_contents($logFile, '[' . date('Y-m-d H:i:s') . '] ' . $message . PHP_EOL, FILE_APPEND);
  }

  private function normalizeTicketEventId()
  {
      $eventid = $_POST['ticketuniqueeventid'] ?? ($_POST['eventid'] ?? '');
      $eventid = is_string($eventid) ? trim($eventid) : $eventid;

      if (is_numeric($eventid)) {
          $_POST['eventid'] = (int)$eventid;
          return;
      }

      $ticketType = $_POST['type'] ?? '';
      if (!empty($ticketType) && !empty($this->tpl['ticketEventname'])) {
          foreach ($this->tpl['ticketEventname'] as $event) {
              if (($event['ticketevents'] ?? '') === $ticketType && is_numeric($event['id'] ?? null)) {
                  $_POST['eventid'] = (int)$event['id'];
                  return;
              }
          }
      }

      unset($_POST['eventid']);
  }

  function __construct()
  {
    $this->layout = 'login';

    GzObject::loadFiles('Model', array('ticketeventname', 'ticket', 'ConfirmCode', 'Member', 'Donation', 'idnumbers', 'User'));
    $ticketeventnameModel = new ticketeventnameModel();
    $ticketModel = new ticketModel();
    $DonationModel = new DonationModel();
    $ConfirmCodeModel = new ConfirmCodeModel();
    $MemberModel = new MemberModel();
    $idnumbersModel = new idnumbersModel();
    $UserModel = new UserModel();

    $arr = $ticketeventnameModel->getallticket();
    $this->tpl['ticketEventname'] = $arr;

    if (!empty($_POST['create_ticket'])) {
      try {
          $this->logPujaError('FORM SUBMIT START | PaymentOption=' . ($_POST['PaymentOption'] ?? '') . ' | email=' . ($_POST['email'] ?? '') . ' | tele=' . ($_POST['tele'] ?? ''));
          if (($_POST['PaymentOption'] ?? '') == null) {
        $data = array();
        $_POST['eventtype'] = "PujaTicket";
        $this->normalizeTicketEventId();
        $_POST['status'] = 'pending';
        $_POST['Member_id'] = $_POST['demmember'] ?? '';
        $regmember = $_POST['regmember'] ?? '';
        if($regmember == "nonmember"){
            $nonmember = $_POST['namenonmember'] ?? ''; 
            $_POST['name'] = $nonmember;
          } if($regmember == "member"){
                $_POST['name'] = $_POST['MemberName'] ?? ''; ;  
          } 
           date_default_timezone_set("America/Chicago");
             $today = date("Y/m/d");
             $_POST['created_on'] = $today;
        // Generate oid for pending path (required column, no DB default)
        $maxoid = $idnumbersModel->getMaxoid() + 1;
        $idnumbersModel->Updateoid($maxoid);
        $_POST['oid'] = $maxoid;

        $id = $ticketModel->getticketMaxid() + 1;
        $_POST['id'] = $id;
        $_POST['Age1'] = isset($_POST['Age1']) && is_numeric($_POST['Age1']) ? (int)$_POST['Age1'] : 0;
        $_POST['Age2'] = isset($_POST['Age2']) && is_numeric($_POST['Age2']) ? (int)$_POST['Age2'] : 0;
        $_POST['Age3'] = isset($_POST['Age3']) && is_numeric($_POST['Age3']) ? (int)$_POST['Age3'] : 0;
        $_POST['item_name']          = $_POST['item_name']          ?? '';
        $_POST['item_number']        = $_POST['item_number']        ?? '';
        $_POST['amount']             = is_numeric($_POST['amount'] ?? '') ? $_POST['amount'] : ($_POST['item_cost'] ?? 0);
        $_POST['txn_id']             = $_POST['txn_id']             ?? '';
        $_POST['payment_status']     = $_POST['payment_status']     ?? '';
        $_POST['payment_timestamp']  = $_POST['payment_timestamp']  ?? '';
        $_POST['stripe_return']      = $_POST['stripe_return']      ?? '';
        $_POST['paid_amount']        = $_POST['paid_amount']        ?? '';
        $_POST['stripe_product']     = $_POST['stripe_product']     ?? '';
        $_POST['cc_name']            = $_POST['cc_name']            ?? '';
        $_POST['status']             = $_POST['status']             ?? '';
        $_POST['remarks']            = $_POST['remarks']            ?? '';
        $_POST['itemeventday']       = $_POST['itemeventday']       ?? '';
        $_POST['bank']               = $_POST['checkbankname']      ?? '';
        if (!empty($_POST['CheckDate'])) { $_POST['chkdate'] = $_POST['CheckDate']; } else { unset($_POST['chkdate']); }
        $_POST['Parent1']            = $_POST['Parent1']            ?? '';
        $_POST['Parent2']            = $_POST['Parent2']            ?? '';
        $_POST['admin_id']           = $_POST['admin_id']           ?? '';
        $_POST['admin_name']         = $_POST['admin_name']         ?? '';
        $_POST['pay_for']            = 'TICKET/' . ($_POST['type'] ?? '');
        $_POST['pay_date']           = !empty($_POST['pay_date']) ? $_POST['pay_date'] : date('Y-m-d');
        $_POST['pay_type']           = $_POST['pay_type']           ?? '';
        $datareturn = $ticketModel->save($_POST);
        
                if (!empty($id)) {
                    
                    $MemberName = $_POST['name'] ?? '';
          $regmember = $_POST['regmember'] ?? '';
          if($regmember == 'member'){
            $reg = 'Yes';
          }
          else{
            $reg = 'No';
          }
          $name = $_POST['type'] ?? '';
          if($name == 'kalipuja'){
              $eventname = 'Kali Puja';
          }
          elseif($name == 'kpFireworks'){
              $eventname = 'KP Fireworks';
          }
          else{
              $eventname = 'Saraswati Puja';
          }
          $tickettype = $_POST['tickettype'] ?? '';
          if($tickettype == 'individual'){
          $typeticket = 'Individual';
          }elseif($tickettype == 'additional_adult'){
          $typeticket = 'Adult';
          }
          else{
            $typeticket = 'Child';
          }
          $ticketprice = $_POST['additional_adult_amount'] ?? '';
          $Quantity = $_POST['numberofadults'] ?? '';
          $totalamount = $_POST['item_cost'] ?? '';
          
                    echo "<div style='text-align: -webkit-center;' class = 'pay'>
                        <table border='4'  width='585px' style='margin-left:4em;'>
                        <tr>
                        <td colspan='2'> <img src='../thankyouscreen.jpg' alt='' height='167px' style='margin-left:12em;'><h1 style='text-align:center;font-family:fangsong; font-size:30px;'><b>Houston Durga Bari Society</b></h1> </td>
                        <tr><td colspan='2'><span style='font-size: 18px;font-family: serif;'>Your Ticket request have been submitted.
                        Registration Team will validate your application and send a confirmation for payment.</span></td></tr>
                        <tr><td style='width:50%;'>Member Name</td> <td style='width:50%;'>" . $MemberName . "</td> </tr>
                        <tr><td>Puja Type</td> <td>" . $eventname . "</td> </tr>
                        <tr><td>No of Ticket</td> <td>" . $Quantity. "</td> </tr>
                        <tr><td>Total Amount</td> <td><span style= 'color:red;'>$</span>" . $totalamount . "</td> </tr>
                        <tr><td>Payment Status</td> <td>Pending</td>  </tr>
                      <tr><td colspan='2'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>   </tr>
                      </tr>";
          echo "</table>";
            echo "<a  href='" . INSTALL_URL . "PujaTicket/PujaTicket'>Go to home</a>";
          echo "</div>";
        
          $Emailcc = 'pujaregpayment@durgabari.org';
          $subjetc = 'Ticket Request';
          $membername = $_POST['name'] ?? '';
          $name = $_POST['type'] ?? '';
          if ($name == 'kalipuja') {
              $eventname = 'Kali Puja';
          }elseif($name == 'kpFireworks'){
              $eventname = 'KP Fireworks';
          }
          else {
              $eventname = 'Saraswati Puja';
          }
         // $tickettype = $_POST['tickettype'] ?? '';
          $tickettype = $_POST['tickettype'] ?? '';
          if ($tickettype == 'individual') {
              $typeticket = 'Individual';
          }elseif ($tickettype == 'additional_adult') {
              $typeticket = 'Adult';
          } else {
              $typeticket = 'Child';
          }
          $ticketprice = $_POST['additional_adult_amount'] ?? '';
          $Quantity = $_POST['numberofadults'] ?? '';
          $totalamount = $_POST['item_cost'] ?? '';

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
      <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">No. of Tickets &nbsp;&nbsp;</td>
      <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $Quantity . '</td>
      </tr>
      <tr>
      <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">One Ticket Price&nbsp;&nbsp;</td>
      <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;"><span style="color:red;">$</span>' . $ticketprice . '</td>
      </tr>
      <tr>
      <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Total Amount &nbsp;</td>
      <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;"><span style="color:red;">$</span>' . $totalamount . '</td>
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
                $msg = 'Houston Durga Bari: Your Ticket request have been submitted Member Name: '. $membername.', Puja Type: '. $eventname.', No. of Tickets: '. $Quantity.', One Ticket Price: $'. $ticketprice.' , Total Amount: $'. $totalamount;
                $this->SendSMS($mobileno, $msg);
            }
                }
                exit();

            } else{
      $data = array();
      date_default_timezone_set("America/Chicago");
      $today = date("Y/m/d");
      $_POST['pay_date'] = $today; $today = date("Y/m/d");
      $_POST['created_on'] = $today;
      $_POST['pay_for']  = 'TICKET/' . ($_POST['type'] ?? '');
      $_POST['eventtype'] = "PujaTicket";
      $this->normalizeTicketEventId();

      // for generate oid
      $maxoid = $idnumbersModel->getMaxoid() + 1;
      $update_oid = $idnumbersModel->Updateoid($maxoid);
      $_POST['oid'] = $maxoid;
      // end generate oid for

      $this->logPujaError('CHECKING DUPLICATE MEMBER | email=' . ($_POST['email'] ?? '') . ' | tele=' . ($_POST['tele'] ?? ''));
      $datamember = $MemberModel->ticketduplicatemember();
      $this->logPujaError('DUPLICATE CHECK RESULT | datamember=' . var_export($datamember, true));
      if ($datamember == null) {

          // for generate memberid for gd
          $maxid = $idnumbersModel->getMaxmid() + 1;
          $this->logPujaError('NEW MEMBER | assigning Member_id=' . $maxid);
          $update_mid = $idnumbersModel->Updatemid($maxid);
          $_POST['Member_id'] = $maxid;
          // end generate memberid for gd
      }
      if ($datamember != null) {
          $_POST['Member_id'] = $datamember;
             $alternatemobile = $MemberModel->checktele2($datamember);
                 // for update telephone no member case
                if($alternatemobile == null || $alternatemobile != $_POST['tele2'] ?? ''){
                    $mobileno =  $_POST['tele2'] ?? '';
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

         $id = $ticketModel->getticketMaxid() + 1;
         $_POST['id'] = $id;
         // Sanitize int fields — select placeholder text must not reach int columns
         $_POST['Age1'] = isset($_POST['Age1']) && is_numeric($_POST['Age1']) ? (int)$_POST['Age1'] : 0;
         $_POST['Age2'] = isset($_POST['Age2']) && is_numeric($_POST['Age2']) ? (int)$_POST['Age2'] : 0;
         $_POST['Age3'] = isset($_POST['Age3']) && is_numeric($_POST['Age3']) ? (int)$_POST['Age3'] : 0;
         $_POST['item_name']          = $_POST['item_name']          ?? '';
         $_POST['item_number']        = $_POST['item_number']        ?? '';
         $_POST['amount']             = is_numeric($_POST['amount'] ?? '') ? $_POST['amount'] : ($_POST['item_cost'] ?? 0);
         $_POST['txn_id']             = $_POST['txn_id']             ?? '';
         $_POST['payment_status']     = $_POST['payment_status']     ?? '';
         $_POST['payment_timestamp']  = $_POST['payment_timestamp']  ?? '';
         $_POST['stripe_return']      = $_POST['stripe_return']      ?? '';
         $_POST['paid_amount']        = $_POST['paid_amount']        ?? '';
         $_POST['stripe_product']     = $_POST['stripe_product']     ?? '';
         $_POST['cc_name']            = $_POST['cc_name']            ?? '';
         $_POST['status']             = $_POST['status']             ?? '';
         $_POST['remarks']            = $_POST['remarks']            ?? '';
         $_POST['itemeventday']       = $_POST['itemeventday']       ?? '';
         $_POST['bank']               = $_POST['checkbankname']      ?? '';
         if (!empty($_POST['CheckDate'])) { $_POST['chkdate'] = $_POST['CheckDate']; } else { unset($_POST['chkdate']); }
         $_POST['Parent1']            = $_POST['Parent1']            ?? '';
         $_POST['Parent2']            = $_POST['Parent2']            ?? '';
         $_POST['admin_id']           = $_POST['admin_id']           ?? '';
         $_POST['admin_name']         = $_POST['admin_name']         ?? '';
         try {
             $ticketModel->save($_POST);
         } catch (Throwable $e) {
             echo "<div style='background:#f8d7da;color:#721c24;padding:20px;margin:20px;border:1px solid #f5c6cb;font-family:sans-serif;'>";
             echo "<h3>Database Save Error</h3><pre>" . htmlspecialchars($e->getMessage()) . "</pre>";
             echo "<a href='" . INSTALL_URL . "PujaTicket/PujaTicket'>Go Back</a></div>";
             exit();
         }

         if (!empty($id)) {
                    // for email ui 
                    $memberid = $_POST['Member_id'] ?? '';
                    $mebername = $_POST['name'] ?? '';
                    $oid = $_POST['oid'] ?? '';
                    $amount = $_POST['item_cost'] ?? '';
                    $parkingspot = $_POST['numberofadults'] ?? '';
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
                    $subjetc = 'HDBS Paid Ticket Payment Confirmation';
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
                    <td style="text-align: center; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;"><strong>Paid Ticket Confirmation</strong></td>
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
                    <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Number of Tickets&nbsp;&nbsp;</td>
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
                    $textmsg = 'Houston Durga Bari: Ticket Confirmation are Member Id: ' . $memberid . ', Order Id: ' . $oid . ', Member Name: ' . $mebername . ',  Amount: $' . $amount . ', Payment Method: ' . $payui . ', Pay Date: ' . $payfinaldate;
          try {
          if (($_POST['PaymentOption'] ?? '') == 'others') {

            $opts = array();
            $cmCode = $_POST['code'] ?? '';
            $opts['Confirmation'] = $_POST['confirm_code'] ?? '';
            $arr = $ConfirmCodeModel->UpdateCode($cmCode);
            $_POST['txn_id'] = $cmCode;
            $arr = $ConfirmCodeModel->getAll($opts);
            $oid = $_POST['oid'] ?? '';
            if (!empty($oid)) {
                $opts = array();
                $opts['payment_status'] = 'confirmed';
                $_POST['status'] = 'confirmed';
                $data = $_POST;
                $datamemberarr = array();
                $datamemberarr = array_merge($opts, $_POST);
                $ticketModel->update(array_merge($opts, $_POST));
                $value = array();
                    $value['oid'] = $datamemberarr['oid'];
                    $value['eventid'] = $datamemberarr['eventid'];
                    $value['type'] = $datamemberarr['type'];
                    $value['Member_id'] = $datamemberarr['Member_id'];
                    $value['MemberName'] = $datamemberarr['name'];
                    $value['PaymentOption'] = $datamemberarr['PaymentOption'];
                    $value['payment_status'] = 'succeeded';
                    $value['payment_timestamp'] = $datamemberarr['payment_timestamp'] ?? '';
                    $value['Amount'] = $datamemberarr['item_cost'];
                    $value['stripe_return'] = $datamemberarr['stripe_return'] ?? '';
                    $value['transaction_id'] = $datamemberarr['txn_id'];
                    $value['paid_amount'] = $datamemberarr['paid_amount'] ?? '';
                    $value['update_on'] = $datamemberarr['UpdateOn'] ?? '';
                    $value['stripe_product'] = $datamemberarr['stripe_product'] ?? '';
                    $value['pay_date'] = $datamemberarr['pay_date'];
                    $value['pay_type'] = 'OTHER';
                    $value['pay_for'] = $datamemberarr['pay_for'];
                    $value['Tele1'] = $datamemberarr['tele'];
                    $value['email'] = $datamemberarr['email'];
                    $value['spousename'] = $datamemberarr['spousename'];
                    $value['Address'] = $datamemberarr['address'];
                    $value['Street'] = $datamemberarr['street'];
                    $value['City'] = $datamemberarr['city'];
                    $value['State'] = $datamemberarr['state'];
                    $value['Zip_Code'] = $datamemberarr['zip'];
                    $value['admin_id'] = $datamemberarr['admin_id'];
                    $value['admin_name'] = $datamemberarr['admin_name'];
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
                    $value['itemeventday'] = $_POST['itemeventday'] ?? '';
                    $value['spousename'] = $datamemberarr['spousename'];
                    $value['Street'] = $_POST['street'] ?? '';
                    $value['Address'] = $datamemberarr['address'];
                    $value['Address3'] = $datamemberarr['unit'];
                    $value['Child1'] = $datamemberarr['Child1'];
                    $value['Age1'] = $datamemberarr['Age1'];
                    $value['Child2'] = $datamemberarr['Child2'];
                    $value['Age2'] = $datamemberarr['Age2'];
                    $value['Child3'] = $datamemberarr['Child3'];
                    $value['Age3'] = $datamemberarr['Age3'];
                    $value['Parent1'] = $datamemberarr['Parent1'];
                    $value['Parent2'] = $datamemberarr['Parent2'];
                    $this->logPujaError('SAVING NEW MEMBER (others/zelle) | Member_id=' . ($value['Member_id'] ?? '') . ' | email=' . ($value['email'] ?? ''));
                    $MemberModel->SaveDataInmember($value);
                    $this->logPujaError('MEMBER SAVED (others/zelle) OK');
                }
                   $email = $_POST['email'] ?? '';
                            if ($email != null) {
                                $this->sendEmailticket($message, $subjetc, $email, $Emailcc);
                            }
                            $mobileno = $_POST['alternatenumber'] ?? '';
                            if ($mobileno != null) {
                                $this->SendSMS($mobileno, $textmsg );
                            }
                $MemberName = $_POST['name'] ?? '';
                $memberid = $_POST['Member_id'] ?? '';
                $oid = $_POST['oid'] ?? '';
                $totalamount = $_POST['item_cost'] ?? '';
                $name = $_POST['type'] ?? '';
                if($name == 'kalipuja'){
                    $eventname = 'Kali Puja';
                }
                elseif($name == 'kpFireworks'){
                  $eventname = 'KP Fireworks';
                }
                else{
                    $eventname = 'Saraswati Puja';
                }
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
                 <tr><td>Full Name</td> <td>" . $MemberName . "</td> </tr>
                 <tr><td>Payment Method</td> <td>Zelle</td>  </tr>
                 <tr><td>Total Amount</td> <td><span style='color:red;'>$</span>" . $totalamount . "</td> </tr>
                 <tr><td>Puja Type</td> <td>" . $eventname . "</td></tr>
                 <tr><td>Payment Status</td> <td>Confirmed</td>  </tr>
                 <tr><td>Pay Date</td> <td>" . $payfinaldate . "</td>  </tr>
                 <tr><td colspan='2'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>   </tr>
                 </tr>";
                        echo "</table>";
                        if ($this->isAdmin() || $this->isEditor()) {
                            echo " <a href='" . INSTALL_URL . "Ticketadmin/index'>Go to home</a>";
                            // echo " <a href='http://localhost:8082/14june/Ticketadmin/index'>Go to home</a>";
                        }
                        echo "</div>";
                exit();
            } else {
                echo "<div style='text-align:center;padding:20px;'>"
                   . "<p style='color:red;font-size:18px;'><b>Error:</b> Zelle confirmation code (Order ID) is missing.</p>"
                   . "<p>Please go back, select your Zelle confirmation code, and try again.</p>"
                   . "<a href='javascript:history.back()'>&#8592; Go Back</a>"
                   . "</div>";
                exit();
            }
          }

          elseif (($_POST['PaymentOption'] ?? '') == 'check') {
            $_POST['item_cost'] = $_POST['checkAmount'] ?? '';
            $_POST['bank'] = $_POST['checkbankname'] ?? '';
            if (!empty($_POST['CheckDate'])) { $_POST['chkdate'] = $_POST['CheckDate']; } else { unset($_POST['chkdate']); }
            $_POST['DepositAccount'] = $_POST['CheckDepositAccount'] ?? '';
            $_POST['payment_status'] = 'confirmed';
            $_POST['status'] = 'confirmed';
            $payid = $_POST['id'] ?? '';
            $_POST['id'] =  $payid;
            $data = $_POST;
            $datamemberarr = array();
            $datamemberarr = array_merge($_POST);
            $ticketModel->update(array_merge($_POST));
                    $value = array();
                    $value['oid'] = $datamemberarr['oid'];
                    $value['eventid'] = $datamemberarr['eventid'];
                    $value['type'] = $datamemberarr['type'];
                    $value['Member_id'] = $datamemberarr['Member_id'];
                    $value['MemberName'] = $datamemberarr['name'];
                    $value['PaymentOption'] = $datamemberarr['PaymentOption'];
                    $value['payment_status'] = 'succeeded';
                    $value['Amount'] = $datamemberarr['item_cost'];
                    $value['update_on'] = $datamemberarr['UpdateOn'] ?? '';
                    $value['pay_date'] = $datamemberarr['pay_date'];
                    $value['pay_type'] = 'OTHER';
                    $value['pay_for'] = $datamemberarr['pay_for'];
                    $value['Tele1'] = $datamemberarr['tele'];
                    $value['email'] = $datamemberarr['email'];
                    $value['spousename'] = $datamemberarr['spousename'];
                    $value['Address'] = $datamemberarr['address'];
                    $value['Street'] = $datamemberarr['street'];
                    $value['City'] = $datamemberarr['city'];
                    $value['State'] = $datamemberarr['state'];
                    $value['Zip_Code'] = $datamemberarr['zip'];
                    $value['bank'] = $_POST['bank'] ?? '';
                    $value['chkno'] = $_POST['chkno'] ?? '';
                    $value['chkdate'] = $_POST['chkdate'] ?? '';
                    $value['DepositAccount'] = $datamemberarr['DepositAccount'];
                    $value['admin_id'] = $datamemberarr['admin_id'];
                    $value['admin_name'] = $datamemberarr['admin_name'];
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
                    $value['itemeventday'] = $_POST['itemeventday'] ?? '';
                    $value['spousename'] = $datamemberarr['spousename'];
                    $value['Street'] = $_POST['street'] ?? '';
                    $value['Address'] = $datamemberarr['address'];
                    $value['Address3'] = $datamemberarr['unit'];
                    $value['Child1'] = $datamemberarr['Child1'];
                    $value['Age1'] = $datamemberarr['Age1'];
                    $value['Child2'] = $datamemberarr['Child2'];
                    $value['Age2'] = $datamemberarr['Age2'];
                    $value['Child3'] = $datamemberarr['Child3'];
                    $value['Age3'] = $datamemberarr['Age3'];
                    $value['Parent1'] = $datamemberarr['Parent1'];
                    $value['Parent2'] = $datamemberarr['Parent2'];
                    $this->logPujaError('SAVING NEW MEMBER (check) | Member_id=' . ($value['Member_id'] ?? '') . ' | email=' . ($value['email'] ?? ''));
                    $MemberModel->SaveDataInmember($value);
                    $this->logPujaError('MEMBER SAVED (check) OK');
                }
               $email = $_POST['email'] ?? '';
                        if ($email != null) {
                            $this->sendEmailticket($message, $subjetc, $email, $Emailcc);
                        }
                        $mobileno = $_POST['alternatenumber'] ?? '';
                        if ($mobileno != null) {
                            $this->SendSMS($mobileno, $textmsg );
                        }
                $MemberName = $_POST['name'] ?? '';
                $memberid = $_POST['Member_id'] ?? '';
                $oid = $_POST['oid'] ?? '';
                $totalamount = $_POST['item_cost'] ?? '';
                $name = $_POST['type'] ?? '';
                if($name == 'kalipuja'){
                    $eventname = 'Kali Puja';
                }
                elseif($name == 'kpFireworks'){
                  $eventname = 'KP Fireworks';
                }
                else{
                    $eventname = 'Saraswati Puja';
                }
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
                 <tr><td>Full Name</td> <td>" . $MemberName . "</td> </tr>              
                 <tr><td>Payment Method</td> <td>Check</td>  </tr>
                 <tr><td>Total Amount</td> <td><span style='color:red;'>$</span>" . $totalamount . "</td> </tr>
                 <tr><td>Puja Type</td> <td>" . $eventname . "</td></tr>
                 <tr><td>Payment Status</td> <td>Confirmed</td>  </tr>
                 <tr><td>Pay Date</td> <td>" . $payfinaldate . "</td>  </tr>
                 <tr><td colspan='2'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>   </tr>
                 </tr>";
                        echo "</table>";
                        if ($this->isAdmin() || $this->isEditor()) {
                            echo " <a href='" . INSTALL_URL . "Ticketadmin/index'>Go to home</a>";
                            // echo " <a href='http://localhost:8082/14june/Ticketadmin/index'>Go to home</a>";
                        }
                        echo "</div>";
                        exit();
          }
          
          elseif (($_POST['PaymentOption'] ?? '') == 'cash') {
            $_POST['item_cost'] = $_POST['cashAmount'] ?? '';
            $_POST['pay_date'] = $_POST['cashDate'] ?? '';
            $_POST['DepositAccount'] = $_POST['CashDepositAccount'] ?? '';
            $_POST['payment_status'] = 'confirmed';
            $_POST['status'] = 'confirmed';
            $payid = $_POST['id'] ?? '';
            $_POST['id'] =  $payid;
            $data = $_POST;
            $datamemberarr = array();
            $datamemberarr = array_merge($_POST);
            $ticketModel->update(array_merge($_POST));
            $value = array();
                    $value['oid'] = $datamemberarr['oid'];
                    $value['eventid'] = $datamemberarr['eventid'];
                    $value['type'] = $datamemberarr['type'];
                    $value['Member_id'] = $datamemberarr['Member_id'];
                    $value['MemberName'] = $datamemberarr['name'];
                    $value['PaymentOption'] = $datamemberarr['PaymentOption'];
                    $value['payment_status'] = 'succeeded';
                    $value['payment_timestamp'] = $datamemberarr['payment_timestamp'] ?? '';
                    $value['Amount'] = $datamemberarr['item_cost'];
                    $value['stripe_return'] = $datamemberarr['stripe_return'] ?? '';
                    $value['transaction_id'] = $datamemberarr['txn_id'];
                    $value['paid_amount'] = $datamemberarr['paid_amount'] ?? '';
                    $value['update_on'] = $datamemberarr['UpdateOn'] ?? '';
                    $value['stripe_product'] = $datamemberarr['stripe_product'] ?? '';
                    $value['pay_date'] = $datamemberarr['pay_date'];
                    $value['pay_type'] = 'OTHER';
                    $value['pay_for'] = $datamemberarr['pay_for'];
                    $value['Tele1'] = $datamemberarr['tele'];
                    $value['email'] = $datamemberarr['email'];
                    $value['spousename'] = $datamemberarr['spousename'];
                    $value['Address'] = $datamemberarr['address'];
                    $value['Street'] = $datamemberarr['street'];
                    $value['City'] = $datamemberarr['city'];
                    $value['State'] = $datamemberarr['state'];
                    $value['Zip_Code'] = $datamemberarr['zip'];
                    $value['ReceiveBy'] = $datamemberarr['ReceiveBy']; 
                    $value['DepositAccount'] = $datamemberarr['DepositAccount'];
                    $value['admin_id'] = $datamemberarr['admin_id'];
                    $value['admin_name'] = $datamemberarr['admin_name'];
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
                    $value['Amount'] = $_POST['item_cost'] ?? '';
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
                    $value['itemeventday'] = $_POST['itemeventday'] ?? '';
                    $value['spousename'] = $datamemberarr['spousename'];
                    $value['Street'] = $_POST['street'] ?? '';
                    $value['Address'] = $datamemberarr['address'];
                    $value['Address3'] = $datamemberarr['unit'];
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
                $MemberName = $_POST['name'] ?? '';
                $memberid = $_POST['Member_id'] ?? '';
                $oid = $_POST['oid'] ?? '';
                $totalamount = $_POST['item_cost'] ?? '';
                $name = $_POST['type'] ?? '';
                if($name == 'kalipuja'){
                    $eventname = 'Kali Puja';
                }
                elseif($name == 'kpFireworks'){
                  $eventname = 'KP Fireworks';
                }
                else{
                    $eventname = 'Saraswati Puja';
                }
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
                 <tr><td>Full Name</td> <td>" . $MemberName . "</td> </tr>
                 <tr><td>Payment Method</td> <td>Cash</td>  </tr>
                 <tr><td>Total Amount</td> <td><span style='color:red;'>$</span>" . $totalamount . "</td> </tr>
                 <tr><td>Puja Type</td> <td>" . $eventname . "</td></tr>
                 <tr><td>Payment Status</td> <td>Confirmed</td>  </tr>
                 <tr><td>Pay Date</td> <td>" . $payfinaldate . "</td>  </tr>
                 <tr><td colspan='2'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>   </tr>
                 </tr>";
                        echo "</table>";
                        if ($this->isAdmin() || $this->isEditor()) {
                            echo " <a href='" . INSTALL_URL . "Ticketadmin/index'>Go to home</a>";
                            // echo " <a href='http://localhost:8082/14june/Ticketadmin/index'>Go to home</a>";
                        }
                        echo "</div>";
                        exit();
          }
          elseif (($_POST['PaymentOption'] ?? '') == 'directdeposit') {
            $_POST['bank'] = $_POST['directbank'] ?? '';
            $_POST['txn_id'] = $_POST['transactioncode'] ?? '';
            $_POST['item_cost'] = $_POST['directdepositeamount'] ?? '';
            $_POST['pay_date'] = $_POST['transactiondate'] ?? '';
            $_POST['DepositAccount'] = $_POST['DirectPayDepositAccount'] ?? '';
            $_POST['payment_status'] = 'confirmed';
            $_POST['status'] = 'confirmed';
            $payid = $_POST['id'] ?? '';
            $_POST['id'] =  $payid;
            $data = $_POST;
            $datamemberarr = array();
            $datamemberarr = array_merge($_POST);
            $ticketModel->update(array_merge($_POST));
            $value = array();
                    $value['oid'] = $datamemberarr['oid'];
                    $value['eventid'] = $datamemberarr['eventid'];
                    $value['type'] = $datamemberarr['type'];
                    $value['Member_id'] = $datamemberarr['Member_id'];
                    $value['MemberName'] = $datamemberarr['name'];
                    $value['PaymentOption'] = $datamemberarr['PaymentOption'];
                    $value['payment_status'] = 'succeeded';
                    $value['payment_timestamp'] = $datamemberarr['payment_timestamp'] ?? '';
                    $value['Amount'] = $datamemberarr['item_cost'];
                    $value['stripe_return'] = $datamemberarr['stripe_return'] ?? '';
                    $value['transaction_id'] = $datamemberarr['txn_id'];
                    $value['paid_amount'] = $datamemberarr['paid_amount'] ?? '';
                    $value['update_on'] = $datamemberarr['UpdateOn'] ?? '';
                    $value['stripe_product'] = $datamemberarr['stripe_product'] ?? '';
                    $value['pay_date'] = $datamemberarr['pay_date'];
                    $value['pay_type'] = 'OTHER';
                    $value['pay_for'] = $datamemberarr['pay_for'];
                    $value['Tele1'] = $datamemberarr['tele'];
                    $value['email'] = $datamemberarr['email'];
                    $value['spousename'] = $datamemberarr['spousename'];
                    $value['Address'] = $datamemberarr['address'];
                    $value['Street'] = $datamemberarr['street'];
                    $value['City'] = $datamemberarr['city'];
                    $value['State'] = $datamemberarr['state'];
                    $value['Zip_Code'] = $datamemberarr['zip'];
                    $value['DepositAccount'] = $datamemberarr['DepositAccount'];
                    $value['admin_id'] = $datamemberarr['admin_id'];
                    $value['admin_name'] = $datamemberarr['admin_name'];
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
                    $value['Amount'] = $_POST['item_cost'] ?? '';
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
                    $value['itemeventday'] = $_POST['itemeventday'] ?? '';
                    $value['spousename'] = $datamemberarr['spousename'];
                    $value['Street'] = $_POST['street'] ?? '';
                    $value['Address'] = $datamemberarr['address'];
                    $value['Address3'] = $datamemberarr['unit'];
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
                        
                $MemberName = $_POST['name'] ?? '';
                $memberid = $_POST['Member_id'] ?? '';
                $oid = $_POST['oid'] ?? '';
                $totalamount = $_POST['item_cost'] ?? '';
                $name = $_POST['type'] ?? '';
                if($name == 'kalipuja'){
                    $eventname = 'Kali Puja';
                }
                elseif($name == 'kpFireworks'){
                  $eventname = 'KP Fireworks';
                }
                else{
                    $eventname = 'Saraswati Puja';
                }
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
                 <tr><td>Full Name</td> <td>" . $MemberName . "</td> </tr>
                 <tr><td>Payment Method</td> <td>Online Deposite</td>  </tr>
                 <tr><td>Total Amount</td> <td><span style='color:red;'>$</span>" . $totalamount . "</td> </tr>
                 <tr><td>Puja Type</td> <td>" . $eventname . "</td></tr>
                 <tr><td>Payment Status</td> <td>Confirmed</td>  </tr>
                 <tr><td>Pay Date</td> <td>" . $payfinaldate . "</td>  </tr>
                 <tr><td colspan='2'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>   </tr>
                 </tr>";
                        echo "</table>";
                        if ($this->isAdmin() || $this->isEditor()) {
                            echo " <a href='" . INSTALL_URL . "Ticketadmin/index'>Go to home</a>";
                            // echo " <a href='http://localhost:8082/14june/Ticketadmin/index'>Go to home</a>";
                        }
                        echo "</div>";
                        exit();
          }
          elseif (($_POST['PaymentOption'] ?? '') == 'sumup') {
            $_POST['item_cost'] = $_POST['sumupamount'] ?? '';
            $_POST['txn_id'] = $_POST['sumupid'] ?? '';
            $_POST['pay_date'] = $_POST['sumupdate'] ?? '';
            $_POST['DepositAccount'] = $_POST['SumUpDepositAccount'] ?? '';
            $_POST['payment_status'] = 'confirmed';
            $_POST['status'] = 'confirmed';
            $payid = $_POST['id'] ?? '';
            $_POST['id'] =  $payid;
            $data = $_POST;
            $datamemberarr = array();
            $datamemberarr = array_merge($_POST);
            $ticketModel->update(array_merge($_POST));
                    $value = array();
                    $value['oid'] = $datamemberarr['oid'];
                    $value['eventid'] = $datamemberarr['eventid'];
                    $value['type'] = $datamemberarr['type'];
                    $value['Member_id'] = $datamemberarr['Member_id'];
                    $value['MemberName'] = $datamemberarr['name'];
                    $value['PaymentOption'] = $datamemberarr['PaymentOption'];
                    $value['payment_status'] = 'succeeded';
                    $value['payment_timestamp'] = $datamemberarr['payment_timestamp'] ?? '';
                    $value['Amount'] = $datamemberarr['item_cost'];
                    $value['stripe_return'] = $datamemberarr['stripe_return'] ?? '';
                    $value['transaction_id'] = $datamemberarr['txn_id'];
                    $value['paid_amount'] = $datamemberarr['paid_amount'] ?? '';
                    $value['update_on'] = $datamemberarr['UpdateOn'] ?? '';
                    $value['stripe_product'] = $datamemberarr['stripe_product'] ?? '';
                    $value['pay_date'] = $datamemberarr['pay_date'];
                    $value['pay_type'] = 'OTHER';
                    $value['pay_for'] = $datamemberarr['pay_for'];
                    $value['Tele1'] = $datamemberarr['tele'];
                    $value['email'] = $datamemberarr['email'];
                    $value['spousename'] = $datamemberarr['spousename'];
                    $value['Address'] = $datamemberarr['address'];
                    $value['Street'] = $datamemberarr['street'];
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
                    $value['MemberName'] = $_POST['name'] ?? '';
                    $value['Tele1'] = $_POST['tele'] ?? '';
                    $value['email'] = $_POST['email'] ?? '';
                    $value['City'] = $_POST['city'] ?? '';
                    $value['State'] = $_POST['state'] ?? '';
                    $value['Zip_Code'] = $_POST['zip'] ?? '';
                    $value['Item_Name'] = $_POST['item_name'] ?? '';
                    $value['Item_Number'] = $_POST['item_number'] ?? '';
                    $value['Item_Cost'] = $_POST['item_cost'] ?? '';
                    $value['Amount'] = $_POST['item_cost'] ?? '';
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
                    $value['itemeventday'] = $_POST['itemeventday'] ?? '';
                    $value['spousename'] = $datamemberarr['spousename'];
                    $value['Street'] = $_POST['street'] ?? '';
                    $value['Address'] = $datamemberarr['address'];
                    $value['Address3'] = $datamemberarr['unit'];
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
                $MemberName = $_POST['name'] ?? '';
                $memberid = $_POST['Member_id'] ?? '';
                $oid = $_POST['oid'] ?? '';
                $totalamount = $_POST['item_cost'] ?? '';
                $name = $_POST['type'] ?? '';
                if($name == 'kalipuja'){
                    $eventname = 'Kali Puja';
                }
                elseif($name == 'kpFireworks'){
                  $eventname = 'KP Fireworks';
                }
                else{
                    $eventname = 'Saraswati Puja';
                }
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
                 <tr><td>Full Name</td> <td>" . $MemberName . "</td> </tr>
                 <tr><td>Payment Method</td> <td>SumUp</td>  </tr>
                 <tr><td>Total Amount</td> <td><span style='color:red;'>$</span>" . $totalamount . "</td> </tr>
                 <tr><td>Puja Type</td> <td>" . $eventname . "</td></tr>
                 <tr><td>Payment Status</td> <td>Confirmed</td>  </tr>
                 <tr><td>Pay Date</td> <td>" . $payfinaldate . "</td>  </tr>
                 <tr><td colspan='2'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>   </tr>
                 </tr>";
                        echo "</table>";
                        if ($this->isAdmin() || $this->isEditor()) {
                            echo " <a href='" . INSTALL_URL . "Ticketadmin/index'>Go to home</a>";
                            // echo " <a href='http://localhost:8082/14june/Ticketadmin/index'>Go to home</a>";
                        }
                        echo "</div>";
              exit();
          }
          elseif (($_POST['PaymentOption'] ?? '') == 'stripe') {
            $amount = $_POST['item_cost'] ?? '';
            $total = $amount;

            require APP_PATH . '/helpers/stripe/lib/Stripe.php';

            $error = '';
            $success = '';

            $stripeKey = $this->tpl["option_arr_values"]["stripe_api_key"] ?? '';
            Stripe::setApiKey1($stripeKey);

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
                    $value = array();
                    $value['oid'] = $datamemberarr['oid'];
                    $value['eventid'] = $datamemberarr['eventid'];
                    $value['type'] = $datamemberarr['type'];
                    $value['Member_id'] = $datamemberarr['Member_id'];
                    $value['MemberName'] = $datamemberarr['name'];
                    $value['PaymentOption'] = $datamemberarr['PaymentOption'];
                    $value['payment_status'] = 'succeeded';
                    $value['payment_timestamp'] = $datamemberarr['payment_timestamp'] ?? '';
                    $value['Amount'] = $datamemberarr['item_cost'];
                    $value['stripe_return'] = $datamemberarr['stripe_return'] ?? '';
                    $value['transaction_id'] = $datamemberarr['txn_id'];
                    $value['paid_amount'] = $datamemberarr['paid_amount'] ?? '';
                    $value['update_on'] = $datamemberarr['UpdateOn'] ?? '';
                    $value['stripe_product'] = $datamemberarr['stripe_product'] ?? '';
                    $value['pay_date'] = $datamemberarr['pay_date'];
                    $value['pay_type'] = 'OTHER';
                    $value['pay_for'] = $datamemberarr['pay_for'];
                    $value['Tele1'] = $datamemberarr['tele'];
                    $value['email'] = $datamemberarr['email'];
                    $value['spousename'] = $datamemberarr['spousename'];
                    $value['Address'] = $datamemberarr['address'];
                    $value['Street'] = $datamemberarr['street'];
                    $value['City'] = $datamemberarr['city'];
                    $value['State'] = $datamemberarr['state'];
                    $value['Zip_Code'] = $datamemberarr['zip'];
                    $value['admin_id'] = $datamemberarr['admin_id'];
                    $value['admin_name'] = $datamemberarr['admin_name'];
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
                        $value['itemeventday'] = $_POST['itemeventday'] ?? '';
                        $value['spousename'] = $datamemberarr['spousename'];
                        $value['Street'] = $_POST['street'] ?? '';
                        $value['Address'] = $datamemberarr['address'];
                        $value['Address3'] = $datamemberarr['unit'];
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

                    $MemberName = $_POST['name'] ?? '';
                    $memberid = $_POST['Member_id'] ?? '';
                    $oid = $_POST['oid'] ?? '';
                    $totalamount = $_POST['item_cost'] ?? '';
                    $name = $_POST['type'] ?? '';
                    if($name == 'kalipuja'){
                        $eventname = 'Kali Puja';
                    }
                    elseif($name == 'kpFireworks'){
                       $eventname = 'KP Fireworks';
                    }
                    else{
                        $eventname = 'Saraswati Puja';
                    }
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
                     <tr><td>Full Name</td> <td>" . $MemberName . "</td> </tr>
                     <tr><td>Payment Method</td> <td>Stripe</td>  </tr>
                     <tr><td>Total Amount</td> <td><span style='color:red;'>$</span>" . $totalamount . "</td> </tr>
                     <tr><td>Puja Type</td> <td>" . $eventname . "</td></tr>
                     <tr><td>Payment Status</td> <td>Confirmed</td>  </tr>
                     <tr><td>Pay Date</td> <td>" . $payfinaldate . "</td>  </tr>
                     <tr><td colspan='2'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>   </tr>
                     </tr>";
                            echo "</table>";
                            if ($this->isAdmin() || $this->isEditor()) {
                                echo " <a href='" . INSTALL_URL . "Ticketadmin/index'>Go to home</a>";
                                // echo " <a href='http://localhost:8082/14june/Ticketadmin/index'>Go to home</a>";
                            }
                            echo "</div>";
                    $this->tpl['arr'] = $ticketModel->get($id);
                } else {

                    $opts = array();
                    $opts['id'] = $id;
                    $opts['stripe_return'] = $payment->status;
                    $opts['transaction_id'] = $payment->id;
                    $opts['paid_amount'] = $payment->amount;
                    $opts['stripe_product'] = $payment->description;

                    $ticketModel->update($opts);

                    $_SESSION['status'] = '<strong>' . __('declined_card') . '</strong>';
                    echo "<div style='background:#fff3cd;color:#856404;padding:20px;margin:20px;border:1px solid #ffc107;border-radius:5px;font-family:sans-serif;'>";
                    echo "<h3 style='margin:0 0 10px 0;'>Payment Declined</h3>";
                    echo "<p>Your card was declined. Please check your card details and try again.</p>";
                    echo "<a href='" . INSTALL_URL . "PujaTicket/PujaTicket' style='display:inline-block;padding:10px 20px;background:#ff5252;color:#fff;text-decoration:none;border-radius:4px;'>Go Back &amp; Try Again</a>";
                    echo "</div>";
                }
            } catch (Exception $ex) {
                $_SESSION['status'] = $ex->getMessage();
                echo "<div style='background:#f8d7da;color:#721c24;padding:20px;margin:20px;border:1px solid #f5c6cb;border-radius:5px;font-family:sans-serif;'>";
                echo "<h3 style='margin:0 0 10px 0;'>Payment Error</h3>";
                echo "<p>" . htmlspecialchars($ex->getMessage()) . "</p>";
                echo "<a href='" . INSTALL_URL . "PujaTicket/PujaTicket' style='display:inline-block;padding:10px 20px;background:#ff5252;color:#fff;text-decoration:none;border-radius:4px;'>Go Back &amp; Try Again</a>";
                echo "</div>";
            }

          } else {
            $_SESSION['status'] = 16;
          }
          } catch (Throwable $e) {
              echo "<div style='background:#f8d7da;color:#721c24;padding:20px;margin:20px;border:1px solid #f5c6cb;border-radius:5px;font-family:sans-serif;'>";
              echo "<h3 style='margin:0 0 10px 0;'>Payment Processing Error</h3>";
              echo "<p>" . htmlspecialchars($e->getMessage()) . "</p>";
              echo "<a href='" . INSTALL_URL . "PujaTicket/PujaTicket' style='display:inline-block;padding:10px 20px;background:#ff5252;color:#fff;text-decoration:none;border-radius:4px;'>Go Back &amp; Try Again</a>";
              echo "</div>";
              exit();
          }
      } else {
          $_SESSION['status'] = 17;
      }
      exit();

      } // end paid-path else
      } catch (Throwable $topEx) {
          $this->logPujaError(
              'TOP-LEVEL EXCEPTION | ' . $topEx->getMessage() .
              ' | File: ' . $topEx->getFile() . ':' . $topEx->getLine() .
              ' | POST[PaymentOption]: ' . ($_POST['PaymentOption'] ?? '') .
              ' | POST[email]: ' . ($_POST['email'] ?? '') .
              ' | Trace: ' . str_replace("\n", ' ', $topEx->getTraceAsString())
          );
          echo "<div style='background:#f8d7da;color:#721c24;padding:20px;margin:20px;border:1px solid #f5c6cb;border-radius:5px;font-family:sans-serif;'>";
          echo "<h3 style='margin:0 0 10px 0;'>Submission Error</h3>";
          echo "<p>" . htmlspecialchars($topEx->getMessage()) . "</p>";
          echo "<a href='" . INSTALL_URL . "PujaTicket/PujaTicket' style='display:inline-block;padding:10px 20px;background:#ff5252;color:#fff;text-decoration:none;border-radius:4px;'>&#8592; Go Back</a>";
          echo "</div>";
          exit();
      }

    }
  }
}


?>
