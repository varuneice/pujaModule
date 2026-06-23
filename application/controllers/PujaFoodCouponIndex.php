<?php

require_once CONTROLLERS_PATH . 'App.php';

class PujaFoodCouponIndex extends App {

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
        $cacheBust = time();
        $this->js[] = array('file' => 'otp-member-verify.js?v=' . $cacheBust, 'path' => JS_PATH);
        //$this->js[] = array('file' => 'multiselect-dropdown.js', 'path' => JS_PATH);
        $this->js[] = array('file' => 'loadingoverlay.js?v=' . $cacheBust, 'path' => JS_PATH);
    }

      function PujaFoodCouponIndex() {
    // action method — __construct() handles data loading
  }

  function __construct(){
        $this->layout = 'login';
        GzObject::loadFiles('Model', array('FoodCouponSessionName','pujafoodcoupon'));
        $FoodCouponSessionName = new FoodCouponSessionName();
        $pujafoodcouponModel = new pujafoodcouponModel();

        $opts = array();
        $arr = $FoodCouponSessionName->getFoodCouponSession($opts);
        $this->tpl['foodcoupon'] = $arr;

        if (!empty($_POST['create_FoodCouponRequest'])) {

            //for update session code
            $OldSessionCode = $_POST['sessionCode'] ?? '';
            $sessionNameForRequest = $_POST['sessionName'] ?? $FoodCouponSessionName->getFoodCoupon($OldSessionCode);
            $prefix = substr($OldSessionCode, 0, -3);
            $number = (int)substr($OldSessionCode, -3); 
            $number += 1;
            $newNumber = str_pad($number, 3, '0', STR_PAD_LEFT);
            $latestSessionCode = $prefix . $newNumber;
            $FoodCouponSessionName->setFoodCouponSession($latestSessionCode, $OldSessionCode);
                
                $_POST['Status'] = 'pending';
                $memberId = trim($_POST['termMember'] ?? '');
                if ($memberId === '') {
                    $memberId = trim($_POST['demmember'] ?? '');
                }
                if ($memberId !== '') {
                    $_POST['member_id'] = $memberId;
                } else {
                    unset($_POST['member_id']);
                }
                $opts['sessionCode'] = $OldSessionCode;
                date_default_timezone_set("America/Chicago");
                $today = date("Y/m/d");
                $_POST['paydate'] = $today;
                $_POST['pay_type'] = 'Food Coupon';
                $_POST['pay_for'] = 'Food Coupon';
                $_POST['couponfor'] = $sessionNameForRequest;
                $_POST['coupontype'] = $sessionNameForRequest;
                $_POST['number_of_adult_coupon'] = $_POST['Adult_Coupon_Req'] ?? '';
                $_POST['number_of_kid_coupon'] = $_POST['Kid_Coupon_Req'] ?? '';

                // Keep public request save compatible with the existing payment/admin table.
                unset(
                    $_POST['CreatedAt'],
                    $_POST['sessionCode'],
                    $_POST['sessionName'],
                    $_POST['regmember'],
                    $_POST['Adult_Coupon_Req'],
                    $_POST['Kid_Coupon_Req']
                );

                try {
                    $id = $pujafoodcouponModel->save(array_merge($_POST));
                } catch (Exception $e) {
                    echo "<div style='text-align:center;margin:30px auto;max-width:650px;font-family:Arial,sans-serif;'>
                        <h3>Food Coupon Request Error</h3>
                        <p>We could not submit your request. Please go back and try again.</p>
                        <a href='" . INSTALL_URL . "PujaFoodCouponIndex/PujaFoodCouponIndex'>Go to home</a>
                    </div>";
                    exit();
                }
                if (!empty($id)) {
                    echo "<div style='text-align: -webkit-center;' class = 'pay'>
                    <table border='4'  width='585px' style='margin-left:4em;'>
                    <tr>
                    <td colspan='2'> <img src='../thankyouscreen.jpg' alt='' height='167px' style='margin-left:12em;'><h1 style='text-align:center;font-family:fangsong; font-size:30px;'><b>Houston Durga Bari Society</b></h1> </td>
                    <tr><td colspan='2'><span style='font-size: 18px;font-family: serif;'>Your Puja food coupon request have been submitted.</span></td></tr>
                    <tr><td style='width:50%;'>Member Id</td> <td style='width:50%;'>" . ($_POST['member_id'] ?? '') . "</td> </tr>
                    <tr><td style='width:50%;'>Member Name</td> <td style='width:50%;'>" . ($_POST['F_Name'] ?? '') . ' ' . ($_POST['L_Name'] ?? '') . "</td> </tr>
                    <tr><td>Food Coupon</td> <td><span style= 'color:red;'></span>" . $sessionNameForRequest . "</td> </tr>";
                     if(($_POST['number_of_kid_coupon'] ?? '') != ""){
                    echo "<tr><td style='width:50%;'>Child Coupon Request</td> <td style='width:50%;'>" . ($_POST['number_of_kid_coupon'] ?? '') . "</td> </tr>";
                    }
                    if(($_POST['number_of_adult_coupon'] ?? '') != ""){
                    echo "<tr><td style='width:50%;'>Adult Coupon Request</td> <td style='width:50%;'>" . ($_POST['number_of_adult_coupon'] ?? '') . "</td> </tr>";
                    }
                    echo "<tr><td>Status</td> <td>Pending</td>  </tr>
                    <tr><td colspan='2'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>   </tr>
                    </tr>";
                    echo "</table>";
                    echo "<a  href='" . INSTALL_URL . "PujaFoodCouponIndex/PujaFoodCouponIndex'>Go to home</a>";
                    echo "</div>";
                    
                    $Emailcc = 'pujaassocpayment@durgabari.org';
                    $subject = 'HDBS Food Coupon Request';
                    $fullname = ($_POST['F_Name'] ?? '') . ' ' . ($_POST['L_Name'] ?? '');
                    $memberid =$_POST['member_id'] ?? '';
                    $city = $_POST['City'] ?? '';
                    $state = $_POST['State'] ?? '';
                    $sessionName = $sessionNameForRequest;
                    $SessionCode = $OldSessionCode;
                    $childRequestCoupon = $_POST['number_of_kid_coupon'] ?? '';
                    $AdultRequestCoupon = $_POST['number_of_adult_coupon'] ?? '';
                    $status = "Pending";
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
                    <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Member Id&nbsp;&nbsp;</td>
                    <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $memberid . '</td>
                    </tr>
                    <tr>
                    <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Full Name&nbsp;&nbsp;</td>
                    <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $fullname . '</td>
                    </tr>
                    <tr>
                    <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">City&nbsp;&nbsp;</td>
                    <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $city . '</td>
                    </tr>
                    <tr>
                    <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">State&nbsp;&nbsp;</td>
                    <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' .  $state . '</td>
                    </tr>
                    <tr>
                    <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;"> Food Coupon&nbsp;&nbsp;</td>
                    <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $sessionName . '</td>
                    </tr>
                    <tr>
                    <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Coupon Code&nbsp;&nbsp;</td>
                    <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' .  $SessionCode . '</td>
                    </tr>';
                    if ($childRequestCoupon != "") {
                    $message .='<tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Child Coupon Request&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $childRequestCoupon . '</td>
                        </tr>';}
                    if ($AdultRequestCoupon != "") {
                    $message .='<tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Adult Coupon Request&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $AdultRequestCoupon . '</td>
                        </tr>';}
                    $message .='
                    <tr>
                    <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Status&nbsp;&nbsp;</td>
                    <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $status . '</td>
                    </tr>
                   </tbody>
                    </table>
                    </div>
                    </div>
                    </div>';
                    $email = $_POST['email'] ?? '';
                    if ($email != null) {
                     $this->sendEmailticket($message, $subject, $email, $Emailcc);
                    }
                    $mobileno= $_POST['phone'] ?? '';
                    if (($_POST['phone'] ?? '') != null) {
                        $msg = 'Houston Durga Bari: Food Coupon Request are Member Id: '. $memberid.', Full Name: '. $fullname.',  City: '. $city.', State: ' . $state.', Food Coupon: '.$sessionName.' , Coupon Code: '.$SessionCode.' ,Status: $'. $status  ;
                        $this->SendSMS($mobileno, $msg);
                    }
                } else {
                    echo "<div style='text-align:center;margin:30px auto;max-width:650px;font-family:Arial,sans-serif;'>
                        <h3>Food Coupon Request Error</h3>
                        <p>We could not submit your request. Please go back and try again.</p>
                        <a href='" . INSTALL_URL . "PujaFoodCouponIndex/PujaFoodCouponIndex'>Go to home</a>
                    </div>";
                }
                exit();
        }
    }
}

?>
