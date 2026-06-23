<?php

require_once CONTROLLERS_PATH . 'App.php';

class Admin extends App {

    var $option_arr = null;
    var $layout = 'admin';

    private function logAdminOtp($message) {
        $logPath = (defined('ROOT_PATH') ? ROOT_PATH : INSTALL_PATH) . 'admin_otp.log';
        @file_put_contents($logPath, '[' . date('Y-m-d H:i:s') . '] ' . $message . PHP_EOL, FILE_APPEND | LOCK_EX);
    }

    function beforeFilter() {
        GzObject::loadFiles('Model', 'Option');
        $OptionModel = new OptionModel();
        $this->option_arr = $OptionModel->getAllPairValues();
        $this->tpl['option_arr'] = $OptionModel->getAllPairs();
        $this->tpl['option_arr_values'] = $this->option_arr;

        date_default_timezone_set($this->tpl['option_arr_values']['timezone'] ?: 'UTC');

        $this->tpl['js_format'] = Util::getJsDateFormta($this->tpl['option_arr_values']['date_format']);

        if (!$this->isLoged() && ($_REQUEST['action'] ?? '') != 'login' && ($_REQUEST['action'] ?? '') != 'registration' && ($_REQUEST['action'] ?? '') != 'forgot') {

            Util::redirect(INSTALL_URL . "Admin/login");
        }

        if ($this->isMember() && ($_REQUEST['action'] ?? '') != 'logout') {
            GzObject::loadFiles('Model', array('Member'));
            $MemberModel = new MemberModel();

            $user = $this->getUser();

            $member = $MemberModel->get($user['ID']);

            if ($member['payment_status'] != 'confirmed' || $member['status'] == 'E') {
                Util::redirect(INSTALL_URL . "Member/pay");
            }

            $this->tpl['member'] = $member;
        }

        $this->css[] = array('file' => 'admin/gzstyling/bootstrap.min.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'admin/gzstyling/font-awesome.min.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'admin/gzstyling/ionicons.min.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'admin/gzstyling/daterangepicker/daterangepicker-bs3.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'admin/admin.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'admin/gzstyling/gzstyle.css', 'path' => CSS_PATH);

        $this->js[] = array('file' => 'jquery/jquery-1.9.1.min.js', 'path' => LIBS_PATH);
        $this->js[] = array('file' => 'gzadmin/bootstrap.min.js', 'path' => JS_PATH);
        $this->js[] = array('file' => 'gzadmin/gzadmin/app.js', 'path' => JS_PATH);
        $this->js[] = array('file' => 'admin.js?v=' . time(), 'path' => JS_PATH);

        switch (@($_REQUEST['action'] ?? '')) {
            case 'dashboard':
                $this->js[] = array('file' => 'gzadmin/plugins/morris/raphael-min.js', 'path' => JS_PATH);
                $this->js[] = array('file' => 'gzadmin/plugins/morris/morris.min.js', 'path' => JS_PATH);
                break;
        }

        $this->js[] = array('file' => 'jquery/jquery-validation-1.13.0/dist/jquery.validate.js', 'path' => LIBS_PATH);
        $this->js[] = array('file' => 'jquery/ui/jquery-ui.min.js', 'path' => LIBS_PATH);
        $this->js[] = array('file' => 'login.js?v=' . time(), 'path' => JS_PATH);
        $this->js[] = array('file' => 'gzadmin/plugins/daterangepicker/daterangepicker.js', 'path' => JS_PATH);
        $this->js[] = array('file' => 'GzAdmin.js?v=' . time(), 'path' => JS_PATH);
    }

    function index() {
        Util::redirect(INSTALL_URL . "Admin/dashboard");
    }

    function login() {

        $this->layout = 'login';

        if (isset($_POST['mobile_otp']) && ($_POST['mobile_otp'] ?? '') == '1') {
            $this->logAdminOtp('OTP REQUEST START mobile=' . ($_REQUEST['mobile'] ?? '') . ' ip=' . ($_SERVER['REMOTE_ADDR'] ?? ''));
            GzObject::loadFiles('Model', 'User');
            $UserModel = new UserModel();

            $opts = array();
            $opts['mobile'] = $_REQUEST['mobile'];
            //$opts['email'] = $_REQUEST['mobile'];
            
            //$arr = $UserModel->getAll($opts);
            $contact = $opts['mobile'];
            $arr = $UserModel->getdata($contact);
            if (empty($arr[0])) {
                ?>
                <script>
                    alert('Email ID OR Mobile Number is not Exist in Our Database!');
                    document.location.href = '<?php echo INSTALL_URL; ?>Admin/login';
                </script>
                <?php
                return false;
            }
            //echo $contact;
            //print_r($arr);
            $email2 = $arr[0]['email'];
            //echo $email2;
            $mobile2 = $arr[0]['mobile'];
            //echo $mobile2;

            if($contact == $email2){
//echo 'trueemail';
                
                if (!empty($arr[0]['mobile'])) {

                $otp = (string) random_int(100000, 999999);
                $_SESSION['session_mobile_otp'] = $otp;
                $_SESSION['session_mobile_otp_user_id'] = $arr[0]['id'];
                $_SESSION['session_mobile_otp_contact'] = $contact;
                //echo $otp;
                $data['mobile_otp'] = $otp;
                $data['mobile_otp_tries'] = 1;
                $data['id'] = $arr[0]['id'];
                $UserModel->update($data);

                $users_details = $arr[0];
                //echo $users_details;
                //print_r($users_details);
                $type = 'mobile_otp';
                $group = 'users';
                $mobile_otp = $otp;
                $this->sendEmailsConfirmMobileOtp($users_details, $mobile_otp, true);
                $this->logAdminOtp('OTP EMAIL SENT user_id=' . ($arr[0]['id'] ?? '') . ' email=' . ($users_details['email'] ?? '') . ' otp=' . $mobile_otp);
                $mobileno= $users_details['mobile']; 
                         if ($mobileno != null) {
                             $msg = 'Houston Durga Bari: Your Login OTP is : '. $mobile_otp.' ';
                             $this->SendSMS($mobileno, $msg, true);
                             $this->logAdminOtp('OTP SMS SENT user_id=' . ($arr[0]['id'] ?? '') . ' mobile=' . $mobileno . ' otp=' . $mobile_otp);
                            }
                $_SESSION['status'] = 35;
                $this->logAdminOtp('OTP REQUEST END user_id=' . ($arr[0]['id'] ?? '') . ' contact=' . $contact);
                
            }

            }elseif($contact == $mobile2){
//echo 'truemobile';

                   if (!empty($arr[0]['mobile'])) {

                $otp = (string) random_int(100000, 999999);
                $_SESSION['session_mobile_otp'] = $otp;
                $_SESSION['session_mobile_otp_user_id'] = $arr[0]['id'];
                $_SESSION['session_mobile_otp_contact'] = $contact;
                //echo $otp;
                $data['mobile_otp'] = $otp;
                $data['mobile_otp_tries'] = 1;
                $data['id'] = $arr[0]['id'];
                $UserModel->update($data);

                $users_details = $arr[0];
                //echo $users_details;
                //print_r($users_details);
                $type = 'mobile_otp';
                $group = 'users';
                $mobile_otp = $otp;
                $this->sendEmailsConfirmMobileOtp($users_details, $mobile_otp, true);
                $this->logAdminOtp('OTP EMAIL SENT user_id=' . ($arr[0]['id'] ?? '') . ' email=' . ($users_details['email'] ?? '') . ' otp=' . $mobile_otp);
                $mobileno= $opts['mobile'];   
                        if ($opts['mobile'] != null) {
                            $msg = 'Houston Durga Bari: Your Login OTP is : '. $data['mobile_otp'].' ';
                            $this->SendSMS($mobileno, $msg, true);
                            $this->logAdminOtp('OTP SMS SENT user_id=' . ($arr[0]['id'] ?? '') . ' mobile=' . $mobileno . ' otp=' . $mobile_otp);
                            }
                $_SESSION['status'] = 35;
                $this->logAdminOtp('OTP REQUEST END user_id=' . ($arr[0]['id'] ?? '') . ' contact=' . $contact);
                
            }

            }else{
//echo 'false';
            ?>
            <script>
                alert('Email ID OR Mobile Number is not Exist in Our Database!');
                document.location.href = '" . INSTALL_URL . "Admin/login';
            </script>
            <?php
            }

              
        }


        if (isset($_POST['login_mobile_otp']) && ($_POST['login_mobile_otp'] ?? '') == '1') {
            $this->logAdminOtp('OTP VERIFY START user_id=' . ($_SESSION['session_mobile_otp_user_id'] ?? 0) . ' submitted=' . ($_POST['mobile_otp'] ?? '') . ' session=' . ($_SESSION['session_mobile_otp'] ?? ''));

            GzObject::loadFiles('Model', array('User'));
            $UserModel = new UserModel();
            
            $submittedOtp = trim((string) ($_POST['mobile_otp'] ?? ''));
            $sessionOtp = trim((string) ($_SESSION['session_mobile_otp'] ?? ''));
            $sessionUserId = (int) ($_SESSION['session_mobile_otp_user_id'] ?? 0);

            if ($submittedOtp === '' || $sessionOtp === '' || !hash_equals($sessionOtp, $submittedOtp) || $sessionUserId <= 0) {
                # Login failed
                $this->logAdminOtp('OTP VERIFY FAIL user_id=' . $sessionUserId . ' submitted=' . $submittedOtp);
                Util::redirect(INSTALL_URL . "Admin/login");
            } else {
                $user = $UserModel->get($sessionUserId);
                if (empty($user)) {
                    Util::redirect(INSTALL_URL . "Admin/login");
                }

                if (!in_array($user['type'], array(1, 2, 3, 5, 6,7,8,9,10,15,17,18))) {
                    # Login denied
                    Util::redirect(INSTALL_URL . "Admin/login");
                }
                if ($user['status'] != 'T') {
                    # Login forbidden
                    Util::redirect(INSTALL_URL . "Admin/login");
                }
               

                $_SESSION[$this->default_user] = $user;

                $data['id'] = $user['id'];
                $data['mobile_otp_tries'] = 0;
                $data['mobile_otp'] = '';
                $data['last_login'] = date("Y-m-d H:i:s");
                $UserModel->update($data);
                unset($_SESSION['session_mobile_otp'], $_SESSION['session_mobile_otp_user_id'], $_SESSION['session_mobile_otp_contact']);
                $this->logAdminOtp('OTP VERIFY SUCCESS user_id=' . $sessionUserId . ' email=' . ($user['email'] ?? '') . ' mobile=' . ($user['mobile'] ?? ''));
                if (in_array($user['type'], array(5, 6))) {
                    # Login denied
                    Util::redirect(INSTALL_URL . "Badges/index");
                }
                 if (in_array($user['type'], array(7, 8))) {
                    # Login denied
                    Util::redirect(INSTALL_URL . "BadgesAssign/index");
                }
                if (in_array($user['type'], array(9, 10))) {
                    # Login denied
                    Util::redirect(INSTALL_URL . "Foodcoupon/index");
                }
                 if (in_array($user['type'], array(3, 15))) {
                    # Login denied
                    Util::redirect(INSTALL_URL . "Admin/dashboard");
                }
                // if (in_array($user['type'], array(17, 18))) {
                //     # Login denied
                //     Util::redirect(INSTALL_URL . "pujaMerchandise/index");
                // }
                Util::redirect(INSTALL_URL . "Admin/dashboard");
            }

            return false;
          
        }

        if (isset($_POST['login_user']) && ($_POST['login_user'] ?? '') == '1') {

            $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';

            if (RateLimit::isBlocked('login', $ip)) {
                $_SESSION['status'] = 'Too many failed login attempts. Please try again in 15 minutes.';
                Util::redirect(INSTALL_URL . "Admin/login");
                return false;
            }

            GzObject::loadFiles('Model', array('User', 'Member'));
            $UserModel = new UserModel();
            $MemberModel = new MemberModel();

            $plainPassword = $_POST['password'] ?? '';

            // --- Member login ---
            // Query by email+status only, then verify password manually.
            // This supports both legacy md5 hashes and modern bcrypt hashes.
            $opts = array();
            $opts['email'] = $_POST['email'] ?? '';
            $opts['status'] = 'T';

            $user = $MemberModel->getAll($opts);

            if (count($user) == 1) {
                $user = $user[0];
                $storedHash = $user['password'] ?? '';

                // Verify bcrypt first, fall back to legacy md5 migration
                $passwordOk = password_verify($plainPassword, $storedHash)
                    || ($storedHash === md5($plainPassword) && $this->_rehashPassword($MemberModel, 'ID', $user['ID'], $plainPassword));

                if ($passwordOk) {
                    if ($user['status'] != 'T') {
                        RateLimit::record('login', $ip);
                        Util::redirect(INSTALL_URL . "Admin/login");
                    }
                    RateLimit::clear('login', $ip);
                    $user['is_member'] = '1';
                    $_SESSION[$this->default_user] = $user;
                    $url = "Member/edit/" . $user['ID'];
                    Util::redirect(INSTALL_URL . $url);
                }
            }

            // --- Admin/user login ---
            $opts = array();
            $opts['email'] = $_POST['email'] ?? '';
            $opts['status'] = 'T';

            $user = $UserModel->getAll($opts);

            if (count($user) != 1) {
                # Login failed
                RateLimit::record('login', $ip);
                Util::redirect(INSTALL_URL . "Admin/login");
            } else {
                $user = $user[0];
                $storedHash = $user['password'] ?? '';

                // Verify bcrypt first; fall back to legacy md5 and rehash on success
                $passwordOk = password_verify($plainPassword, $storedHash)
                    || ($storedHash === md5($plainPassword) && $this->_rehashPassword($UserModel, 'id', $user['id'], $plainPassword));

                if (!$passwordOk) {
                    RateLimit::record('login', $ip);
                    Util::redirect(INSTALL_URL . "Admin/login");
                }

                if (!in_array($user['type'], array(1, 2, 3, 5, 6,7,8,9,10,17,18))) {
                    # Login denied
                    RateLimit::record('login', $ip);
                    Util::redirect(INSTALL_URL . "Admin/login");
                }
                if ($user['status'] != 'T') {
                    # Login forbidden
                    RateLimit::record('login', $ip);
                    Util::redirect(INSTALL_URL . "Admin/login");
                }

                RateLimit::clear('login', $ip);
                $_SESSION[$this->default_user] = $user;

                $data['id'] = $user['id'];
                $data['last_login'] = date("Y-m-d H:i:s");
                $UserModel->update($data);
                if (in_array($user['type'], array(5, 6))) {
                    # Login denied
                    Util::redirect(INSTALL_URL . "Badges/index");
                }
                 if (in_array($user['type'], array(7, 8))) {
                    # Login denied
                    Util::redirect(INSTALL_URL . "BadgesAssign/index");
                }
                if (in_array($user['type'], array(9, 10))) {
                    # Login denied
                    Util::redirect(INSTALL_URL . "Foodcoupon/index");
                }
                // if (in_array($user['type'], array(17, 18))) {
                //     # Login denied
                //     Util::redirect(INSTALL_URL . "pujaMerchandise/index");
                // }
                Util::redirect(INSTALL_URL . "Admin/dashboard");
            }

            return false;
        }
    }

    /**
     * Rehash a legacy md5 password to bcrypt and persist it in the database.
     * Called transparently on login when the stored hash is still md5.
     *
     * @param object $model      The UserModel or MemberModel instance
     * @param string $pkField    Primary-key column name ('id' or 'ID')
     * @param mixed  $pkValue    The row's primary-key value
     * @param string $plainPass  The plain-text password that was just verified
     * @return bool  Always true (so it can be used in a short-circuit expression)
     */
    private function _rehashPassword($model, string $pkField, $pkValue, string $plainPass): bool {
        $data[$pkField]    = $pkValue;
        $data['password']  = password_hash($plainPass, PASSWORD_BCRYPT);
        $model->update($data);
        return true;
    }

     function dashboard() {
        GzObject::loadFiles('Model', array('Booking', 'pujaregistration', 'SankalpaPuja', 'Donationnewview', 'paidparking', 'ticket', 'pujapasses', 'pujamagazine', 'pujafoodcoupon', 'Calendar', 'User', 'MemberLog' , 'totalPurchasedItem'));
        $BookingModel = new BookingModel();
        $CalendarModel = new CalendarModel();
        $UserModel = new UserModel();
        $MemberLogModel = new MemberLogModel();
        $pujaregistrationModel = new pujaregistrationModel();
        $SankalpaPujaModel = new SankalpaPujaModel();
        $DonationnewviewModel = new DonationnewviewModel();
        $paidparkingModel = new paidparkingModel();
        $ticketModel = new ticketModel();
        $pujapassesModel = new pujapassesModel();
        $pujamagazineModel = new pujamagazineModel();
        $pujafoodcouponModel = new pujafoodcouponModel();

        $allPurchaseData = new totalPurchasedItemModel();

        $opts = array();

        if ($this->isMember()) {
            $opts = array();
            $opts['user_id'] = $this->getMemberId();
        }
        $arr = $BookingModel->getAll($opts, 'id desc', '7');

        $this->tpl['arr'] = $arr;
        $this->tpl['chart'] = array();

        $where = '';

        if ($this->isMember()) {
            $opts = array();
            $opts['user_id'] = $this->getMemberId();
            $bookings = $BookingModel->getAll($opts);

            $booking_id = array();
            foreach ($bookings as $key => $value) {
                $booking_id[$value['id']] = $value['id'];
            }

            $where = "AND id IN ('" . implode("','", $booking_id) . "') ";
        }

        for ($i = (date('n') - 11); $i <= date('n'); $i++) {

            $from_timestamp = mktime(0, 0, 0, $i, 1, date('Y'));
            $to_timestamp = mktime(0, 0, 0, $i + 1, 0, date('Y'));

            $sql = "SELECT count(id) as count FROM " . $BookingModel->getTable() . " WHERE date BETWEEN " . $from_timestamp . "  AND " . $to_timestamp . " $where ";

            $arr = $BookingModel->execute($sql);

            $this->tpl['chart']['booking'][date('M', mktime(0, 0, 0, $i, 1, date('Y')))] = $arr[0];
        }
        //$sql = "SELECT  year(finalDate) ,month(finalDate) ,SUM(total)   as count   FROM " . $BookingModel->getTable()  ." group by year(finalDate),month(finalDate) order by year(created),month(finalDate) ";
        $sql = "SELECT  year(finalDate) as yr,month(finalDate) as mon ,SUM(total)   as count   FROM " . $BookingModel->getTable() . " group by year(finalDate),month(finalDate) order by year(finalDate),month(finalDate) ";
        //$sql = "SELECT  SUM(total)   as count   FROM " . $BookingModel->getTable() . "  group by " .  year($from_timestamp) . "  , " . month($to_timestamp). "  order by " .  year($from_timestamp) . "  , " . month($to_timestamp)  ";
        //$sql = "SELECT  year(date) as yr,month(date) as mon ,SUM(total)   as count   FROM " . $BookingModel->getTable()  ." group by year(date),month(date) order by year(date),month(date) ";
        $arr = $BookingModel->execute($sql);
        $arrLength = count($arr);
        for ($i = 0; $i < $arrLength; $i++) {

            $this->tpl['chartRevenu']['booking'][date('M', mktime(0, 0, 0, $arr[$i]['mon'], 1, date('Y')))] = $arr[$i];
        }

        $sql = "SELECT count(id) as today_reservation FROM " . $BookingModel->getTable() . " WHERE date = '" . strtotime(date("Y-m-d")) . "' $where";
        $arr = $BookingModel->execute($sql);
        $this->tpl['today_reservation'] = $arr[0];

        $arr = array();
        $sql = "SELECT count(id) as bookings_this_week FROM " . $BookingModel->getTable() . " WHERE date BETWEEN '" . strtotime('last Monday', time()) . "' AND '" . ( strtotime('next Sunday', time()) + 86400 ) . "' $where";
        $arr = $BookingModel->execute($sql);
        $this->tpl['bookings_this_week'] = $arr[0];


        $this->tpl['users'] = $UserModel->getAll();

        $this->tpl['pujaregistration'] = $pujaregistrationModel->getAll();

        
        $arr = array();
        $current_year = date("Y");
        $Nextyear = date('Y')+1;
        date_default_timezone_set("America/Chicago");
        if (date("m-d") < "04-01") {
            $current_year = $current_year - 1; 
            $Nextyear = date("Y");
        }
        $sql = "SELECT SUM(totalamount) as pujarevenue , SUM(donation) as extradonation FROM " . $pujaregistrationModel->getTable($opts)." WHERE status ='confirmed' AND pay_date >= '$current_year-04-01' AND pay_date < '$Nextyear-03-31' ";
        $sql2 = "SELECT COUNT(id) as pujaregistrant  FROM " . $pujaregistrationModel->getTable($opts)." WHERE status ='confirmed' AND pay_date >= '$current_year-04-01' AND pay_date < '$Nextyear-03-31' ";
        $arr = $pujaregistrationModel->execute($sql);
        $arr2 = $pujaregistrationModel->execute($sql2);

        // 31-july update condition
        $finalpujarevenue = $arr[0]['pujarevenue'] - $arr[0]['extradonation'];
        $this->tpl['pujarevenue'] = $finalpujarevenue;
        $this->tpl['pujaregistrant'] = $arr2[0]['pujaregistrant'];

        $this->tpl['Donationnewview'] = $DonationnewviewModel->getAll($opts);

        $arr = array();

        $sql = "SELECT SUM(Amount) as pujadonationnewviewrevenue  FROM " . $DonationnewviewModel->getTable($opts)." WHERE paymentfor ='Puja Donation'  AND payment_status ='succeeded' AND pay_date >= '$current_year-04-01' AND pay_date < '$Nextyear-03-31' ";
        $arr = $DonationnewviewModel->execute($sql);

        $this->tpl['pujadonationnewviewrevenue'] = $arr[0]['pujadonationnewviewrevenue'];

        $this->tpl['SankalpaPuja'] = $SankalpaPujaModel->getAll();

        $arr = array();

        $sql = "SELECT SUM(item_cost) as pujasankalparevenue  FROM " . $SankalpaPujaModel->getTable($opts) ." WHERE payment_status ='confirmed'  AND pay_date >= '$current_year-04-01' AND pay_date < '$Nextyear-03-31' ";
        $arr = $SankalpaPujaModel->execute($sql);

        $this->tpl['pujasankalparevenue'] = $arr[0]['pujasankalparevenue'];

        $this->tpl['paidparking'] = $paidparkingModel->getAll();

        $arr = array();

        $sql = "SELECT SUM(amount) as pujaparkingrevenue  FROM " . $paidparkingModel->getTable($opts) ." WHERE payment_status ='confirmed' AND status ='confirmed' AND pay_date >= '$current_year-04-01' AND pay_date < '$Nextyear-03-31' ";
        $arr = $paidparkingModel->execute($sql);

        $this->tpl['pujaparkingrevenue'] = $arr[0]['pujaparkingrevenue'];

        $this->tpl['ticket'] = $ticketModel->getAll();

        $arr = array();

        $sql = "SELECT SUM(amount) as pujaticketrevenue  FROM " . $ticketModel->getTable()." WHERE eventtype ='PujaTicket' AND payment_status ='confirmed' AND pay_date >= '$current_year-04-01' AND pay_date < '$Nextyear-03-31' ";
        $arr = $ticketModel->execute($sql);

        $this->tpl['pujaticketrevenue'] = $arr[0]['pujaticketrevenue'];

        $this->tpl['pujapasses'] = $pujapassesModel->getAll();

        $arr = array();

        $sql = "SELECT SUM(totalamount) as pujapassesrevenue  FROM " . $pujapassesModel->getTable() ." WHERE payment_status ='confirmed' AND pay_date >= '$current_year-04-01' AND pay_date < '$Nextyear-03-31' ";
        $arr = $pujapassesModel->execute($sql);

        $this->tpl['pujapassesrevenue'] = $arr[0]['pujapassesrevenue'];

        $this->tpl['pujamagazine'] = $pujamagazineModel->getAll();

        $arr = array();

        $sql = "SELECT SUM(totalamount) as pujamagazinerevenue  FROM " . $pujamagazineModel->getTable($opts) ." WHERE payment_status ='confirmed' AND pay_date >= '$current_year-04-01' AND pay_date < '$Nextyear-03-31' ";
        $arr = $pujamagazineModel->execute($sql);

        $this->tpl['pujamagazinerevenue'] = $arr[0]['pujamagazinerevenue'];

        $this->tpl['pujafoodcoupon'] = $pujafoodcouponModel->getAll();

         $arr = array();

        $sql = "SELECT SUM(amount) as pujafoodrevenue  FROM " . $pujafoodcouponModel->getTable($opts) ." WHERE payment_status ='confirmed' AND paydate >= '$current_year-04-01' AND paydate < '$Nextyear-03-31' ";
        $arr = $pujafoodcouponModel->execute($sql);

        $this->tpl['pujafoodrevenue'] = $arr[0]['pujafoodrevenue'];

        $arr = array();

        $sql = "SELECT SUM(total) as revenue  FROM " . $BookingModel->getTable($opts) . " ";
        $arr = $BookingModel->execute($sql);

        $this->tpl['revenue'] = $arr[0]['revenue'];

        $opts = array();

        if ($this->isEditor()) {
            $opts['user_id'] = $this->getUserId();
        }
        $this->tpl['calendars'] = $CalendarModel->getAll($opts);

        $opts = array();
        $this->tpl['log_arr'] = $MemberLogModel->getAllWithMember($opts);


        // punjabi sales
        $sqlTotalPunjabiSales = "SELECT SUM(punjabi_beige_red_qty + punjabi_white_red_qty) AS combined_total FROM totalpurchaseditem  WHERE ( status =  'confirmed' OR status = 'succeeded') AND pay_date >= '$current_year-04-01' AND pay_date < '$Nextyear-03-31' ";
        $this->tpl['totalPunjabiSales'] = $allPurchaseData->execute($sqlTotalPunjabiSales);

        // totar saree sales
        $sqlTotalSareeSales = "SELECT SUM(saree_terracotta_qty + saree_tussar_qty) AS combined_total FROM totalpurchaseditem WHERE ( status =  'confirmed' OR status = 'succeeded') AND pay_date >= '$current_year-04-01' AND pay_date < '$Nextyear-03-31'  ";
        $this->tpl['totalSareeSales'] = $allPurchaseData->execute($sqlTotalSareeSales);
        // saree revenue
        $sqlTotalSareeRevenue = "SELECT SUM(sarre_terracotta_amount + sarre_tussar_amount) AS combined_total FROM totalpurchaseditem  WHERE ( status =  'confirmed' OR status = 'succeeded') AND pay_date >= '$current_year-04-01' AND pay_date < '$Nextyear-03-31'  ";
        $this->tpl['totalSareeRevenue'] = $allPurchaseData->execute($sqlTotalSareeRevenue);
        // punjabi revemue
        $sqlTotalPunjabiRevenue = "SELECT SUM(punjabi_white_red_amount + punjabi_beige_red_amount) AS combined_total FROM totalpurchaseditem WHERE ( status =  'confirmed' OR status = 'succeeded') AND pay_date >= '$current_year-04-01' AND pay_date < '$Nextyear-03-31'  ";
        $this->tpl['totalPunjabiRevenue'] = $allPurchaseData->execute($sqlTotalPunjabiRevenue);


        // beige red count
        $sqlBeigeRedCount = "SELECT SUM(punjabi_beige_red_qty) AS combined_total FROM totalpurchaseditem  WHERE ( status =  'confirmed' OR status = 'succeeded') AND pay_date >= '$current_year-04-01' AND pay_date < '$Nextyear-03-31'  ;";
        $this->tpl['BeigeRedCount'] = $allPurchaseData->execute($sqlBeigeRedCount);


        // whitered-count
        $sqlWhiteRedCount = "SELECT SUM(punjabi_white_red_qty) AS combined_total FROM totalpurchaseditem WHERE ( status =  'confirmed' OR status = 'succeeded') AND pay_date >= '$current_year-04-01' AND pay_date < '$Nextyear-03-31'  ;";
        $this->tpl['WhiteRedCount'] = $allPurchaseData->execute($sqlWhiteRedCount);


        // saree terracota count
        $sqlSareeTerracotaCount = "SELECT SUM(saree_terracotta_qty) AS combined_total FROM totalpurchaseditem WHERE ( status =  'confirmed' OR status = 'succeeded') AND pay_date >= '$current_year-04-01' AND pay_date < '$Nextyear-03-31'  ;";
        $this->tpl['SareeTerracotaCount'] = $allPurchaseData->execute($sqlSareeTerracotaCount);

        // saree tussar count
        $sqlSareeTusharCount = "SELECT SUM(saree_tussar_qty) AS combined_total FROM totalpurchaseditem WHERE ( status =  'confirmed' OR status = 'succeeded') AND pay_date >= '$current_year-04-01' AND pay_date < '$Nextyear-03-31'  ;";
        $this->tpl['SareeTusharCount'] = $allPurchaseData->execute($sqlSareeTusharCount);


        // total salee amount
        $sqlTotalAmount = "SELECT SUM(amount) AS total_amount FROM totalpurchaseditem WHERE ( status =  'confirmed' OR status = 'succeeded') AND pay_date >= '$current_year-04-01' AND pay_date < '$Nextyear-03-31'  ;";
        $this->tpl['TotalAmount'] = $allPurchaseData->execute($sqlTotalAmount);
        
        
        // 17augusr
        
       $ltdytd = $pujaregistrationModel->getltdytd();

        $this->tpl['ltdytd'] = $ltdytd;
        $totalDiamond = $pujaregistrationModel->countMembersWithYtd5000OrMore();
        $this->tpl['totalDiamond'] = $totalDiamond;

        $this->tpl['totalCount'] = $ltdytd['total'] + $totalDiamond;

        $getAllData = $pujafoodcouponModel->getAllCouponSum();
        $childDataFromFoodCoupon = $getAllData[0]['total_kid_child_sum'];
        $adultDataFromFoodCoupon = $getAllData[0]['total_adult_sum'];

        $adultCoupon = $pujaregistrationModel->getAdultCoupon();
        $this->tpl['adult'] = $adultCoupon + $adultDataFromFoodCoupon;
       

        // adult
        $childCoupon = $pujaregistrationModel->getChildCoupon();
        $this->tpl['child'] = $childCoupon + $childDataFromFoodCoupon;

        $totalCouponCount = (int) $adultCoupon + (int) $childCoupon + $childDataFromFoodCoupon + $adultDataFromFoodCoupon;
        $this->tpl['totalCountCoupon'] = $totalCouponCount;


       

      // total amount from food coupon
        $totalCouponAmountFromFoodCoupon = $pujafoodcouponModel->totalFoodCouponAmmount();
        // total
        $totalCouponAmount = $pujaregistrationModel->getTotalCouponAmount();
        $this->tpl['amount'] = $totalCouponAmount + $totalCouponAmountFromFoodCoupon ;
        
        
        
        
        
        
        
        
        
    }

    function array_value_recursive($key, array $arr) {
        $val = array();
        array_walk_recursive($arr, function($v, $k) use($key, &$val) {
            if ($k == $key)
                array_push($val, $v);
        });
        return count($val) > 1 ? $val : array_pop($val);
    }

    function logout() {
        if ($this->isLoged()) {
            unset($_SESSION[$this->default_user]);
            Util::redirect(INSTALL_URL . "Admin/login");
        } else {
            Util::redirect(INSTALL_URL . "Admin/login");
        }
    }

    function getMultyCalendarCSS() {
        $this->layout = 'empty';
        $this->replaceMultyCalendarCSS();
    }

    function update_db() {
        $this->layout = 'install';

        GzObject::loadFiles('Model', array('App'));
        $AppModel = new AppModel();

        $string = file_get_contents('application/config/update_db_10.sql');
        preg_match_all('/DROP\s+TABLE(\s+IF\s+EXISTS)?\s+`(\w+)`/i', $string, $match);

        if (count($match[0]) > 0) {
            $arr = array();
            foreach ($match[2] as $k => $table) {

                $sql = "SHOW TABLES FROM `" . $AppModel->database . "` LIKE '" . $AppModel->prefix . $table . "'";

                $arr = $AppModel->execute($sql);

                if (!empty($arr)) {
                    $_SESSION['message'] = "Database already has an updated";
                }
            }
        }

        if (!empty($_POST['update_db'])) {
            $file = 'application/config/update_db_10.sql';

            $prefix = $AppModel->prefix;

            $string = file_get_contents($file);
            $string = preg_replace(
                    array('/INSERT\s+INTO\s+`/', '/DROP\s+TABLE\s+IF\s+EXISTS\s+`/', '/CREATE\s+TABLE\s+IF\s+NOT\s+EXISTS\s+`/', '/DROP\s+TABLE\s+`/', '/CREATE\s+TABLE\s+`/'), array('INSERT INTO `' . $prefix, 'DROP TABLE IF EXISTS `' . $prefix, 'CREATE TABLE IF NOT EXISTS `' . $prefix, 'DROP TABLE `' . $prefix, 'CREATE TABLE `' . $prefix), $string);

            $arr = preg_split('/;(\s+)?\n/', $string);
            foreach ($arr as $v) {
                $v = trim($v);
                if (!empty($v)) {
                    $AppModel->execute($v);
                }
            }

            $_SESSION['status'] = "Database has been updated";
        }
    }

    function registration() {
        $this->layout = 'login';
        if (!empty($_POST['submit']) && ($_POST['submit'] ?? '') == 1) {
            GzObject::loadFiles('Model', 'User');
            $UserModel = new UserModel();
            $data['password'] = password_hash($_POST['password'] ?? '', PASSWORD_BCRYPT);
            // $data['email'] = $_POST['email'] ?? '';
            // $data['first'] = $_POST['first'] ?? '';
            // $data['last'] = $_POST['last'] ?? '';
            $data['type'] = 2;
            $data['status'] = 'T';
            $id = $UserModel->save(array_merge($_POST, $data));
            if (!empty($id)) {

                $_SESSION['status'] = 16;
                Util::redirect(INSTALL_URL . "Admin/login");
            } else {
                $_SESSION['status'] = 17;
            }
        }
    }

    function export() {
        $this->isAjax = true;

        $time = time();
        $file = 'db-backup-' . $time . '.sql';
        $backup_path = INSTALL_PATH . 'application/web/upload/backup/' . $file;

        // escapeshellarg() prevents command injection from credential values
        exec('mysqldump --user=' . escapeshellarg(DEFAULT_USER) .
             ' --password=' . escapeshellarg(DEFAULT_PASS) .
             ' --host=' . escapeshellarg(DEFAULT_HOST) .
             ' ' . escapeshellarg(DEFAULT_DB) .
             ' > ' . escapeshellarg($backup_path));
    }

    function forgot() {
        $this->layout = 'login';

        if (!empty($_REQUEST['forgo_password'])) {
            GzObject::loadFiles('Model', 'User');
            $UserModel = new UserModel();

            $opts = array();
            $opts['email'] = $_REQUEST['email'];

            $arr = $UserModel->getAll($opts);

            if (!empty($arr[0]['email'])) {

                $new_pass = Util::random_password();

                $data['password'] = password_hash($new_pass, PASSWORD_BCRYPT);
                $data['id'] = $arr[0]['id'];
                $UserModel->update($data);

                $members_details = $arr[0];

                $type = 'forgot';
                $group = 'members';
                $pass = $new_pass;
                $this->sendEmailsConfirm($members_details, $type, $group, $pass);

                $_SESSION['status'] = 35;
            } else {
                GzObject::loadFiles('Model', array('Member'));
                $MemberModel = new MemberModel();

                $opts = array();
                $opts['email'] = $_REQUEST['email'];

                $arr = $MemberModel->getAll($opts);

                if (!empty($arr[0]['email'])) {

                    echo $new_pass = Util::random_password();

                    $data['password'] = password_hash($new_pass, PASSWORD_BCRYPT);
                    $data['ID'] = $arr[0]['ID'];
                    $MemberModel->update($data);

                    $members_details = array();

                    $members_details['email'] = $arr[0]['email'];
                    $members_details['last'] = $arr[0]['Sp_FName'];
                    $members_details['first'] = $arr[0]['F_Name'];

                    $type = 'forgot';
                    $group = 'members';
                    $pass = $new_pass;
                    $this->sendEmailsConfirm($members_details, $type, $group, $pass);

                    $_SESSION['status'] = 35;
                } else {
                    $_SESSION['err'] = 12;
                }
            }
        }
    }



}
?>

