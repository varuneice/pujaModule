<?php

require_once CONTROLLERS_PATH . 'App.php';

class PujaSankalpa extends App
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
        $this->js[] = array('file' => 'GzPujaSankalpa.js?v=' . time(), 'path' => JS_PATH);
        $this->js[] = array('file' => 'multiselect-dropdown.js?v=' . time(), 'path' => JS_PATH);
        $this->js[] = array('file' => 'loadingoverlay.js?v=' . time(), 'path' => JS_PATH);
    }
  
    function AllMemberNew()
    {
        $this->setIsAjax(true);

        try {
            $pdo = gz_pdo_connect(DEFAULT_HOST, DEFAULT_USER, DEFAULT_PASS, DEFAULT_DB);
        } catch (\PDOException $e) {
            error_log('[PujaSankalpa::AllMemberNew] DB connection failed: ' . $e->getMessage());
            echo "0 results";
            return;
        }

        $Memberid = $_POST['memberid'] ?? ($_POST['member_id'] ?? '');
        if (!$Memberid && !empty($_SESSION['otp_verified_member'])) {
            $Memberid = $_SESSION['otp_verified_member'];
        }

        $stmt = $pdo->prepare("SELECT * FROM memberltdytd WHERE Member_id = ?");
        $stmt->execute([$Memberid]);
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        if (count($rows) === 0) {
            echo "0 results";
            return;
        }

        foreach ($rows as $value) {
            $sponsorLevel = $this->getCurrentSeasonSponsorLevel($pdo, $value['Member_id'] ?? $Memberid);
            $Sp_FName = '';
            $Sp_LName = '';
            if (($value['SpouseSal'] ?? '') != "Late") {
                $Sp_FName = $value['Sp_FName'] ?? '';
                $Sp_LName = $value['Sp_LName'] ?? '';
            }

            echo "<input id='Senior' value='" . h($value['Senior'] ?? '') . "'/> ";
            echo "<input id='gotra' value='" . h($value['Gotra'] ?? '') . "'/> ";
            echo "<input id='memberid' value='" . h($value['Member_id'] ?? '') . "'/> ";
            echo "<input id='MemberName' value='" . h($value['F_Name'] ?? '') . "'/> ";
            echo "<input id='middle_name' value='" . h($value['M_Name'] ?? '') . "'/> ";
            echo "<input id='last_name' value='" . h($value['L_Name'] ?? '') . "'/> ";
            echo "<input id='membershiptype' value='" . h($value['membership_type'] ?? '') . "'/> ";
            echo "<input id='Spouse' value='" . h($Sp_FName) . "'/> ";
            echo "<input id='Spouselast' value='" . h($Sp_LName) . "'/> ";
            echo "<input id='ressidentalAddress' value='" . h($value['Address1'] ?? '') . "'/> ";
            echo "<input id='Address' value='" . h($value['Address2'] ?? '') . "'/> ";
            echo "<input id='unitAddress' value='" . h($value['Address3'] ?? '') . "'/> ";
            echo "<input id='Country' value='" . h($value['Country'] ?? '') . "'/> ";
            echo "<input id='city' value='" . h($value['City'] ?? '') . "'/> ";
            echo "<input id='state' value='" . h($value['State'] ?? '') . "'/> ";
            echo "<input id='zip_code' value='" . h($value['Zip'] ?? '') . "'/> ";
            echo "<input id='Tele1' value='" . h($value['Tele1'] ?? '') . "'/> ";
            echo "<input id='phone_No' value='" . h($value['Mob_No'] ?? '') . "'/> ";
            echo "<input id='phone_work' value='" . h($value['Tele2'] ?? '') . "'/> ";
            echo "<input id='email' value='" . h($value['email'] ?? '') . "'/> ";
            echo "<input id='email2' value='" . h($value['Email2'] ?? '') . "'/> ";
            echo "<input id='ltd' value='" . h($value['LTC'] ?? '') . "'/> ";
            echo "<input id='ytd' value='" . h($value['YTD'] ?? '') . "'/> ";
            echo "<input id='sponsorLevel' value='" . h($sponsorLevel) . "'/> ";
            echo "<input id='membercategory' value='" . h($value['Category'] ?? '') . "'/> ";
            echo "<input id='tableid' value='" . h($value['ID'] ?? '') . "'/> ";
            echo "<input id='updatedate' value='" . h($value['pay_date'] ?? '') . "'/> ";
            echo "<input id='payfor' value='" . h($value['pay_for'] ?? '') . "'/> ";
        }
    }

    private function getCurrentSeasonSponsorLevel($pdo, $memberId)
    {
        $memberId = (int) $memberId;
        if ($memberId <= 0) {
            return '';
        }

        $now = new DateTime('now', new DateTimeZone('America/Chicago'));
        $currentYear = (int) $now->format('Y');
        if ($now->format('m-d') < '04-01') {
            $currentYear--;
        }
        $nextYear = $currentYear + 1;

        try {
            $stmt = $pdo->prepare("
                SELECT sponsorLevel
                FROM pujaregistration
                WHERE Member_id = ?
                  AND pay_date >= ?
                  AND pay_date <= ?
                  AND sponsorLevel IS NOT NULL
                  AND sponsorLevel <> ''
                ORDER BY pay_date DESC, id DESC
                LIMIT 1
            ");
            $stmt->execute(array($memberId, $currentYear . '-07-01', $nextYear . '-06-30'));
            $level = $stmt->fetchColumn();
            return $level !== false ? (string) $level : '';
        } catch (\PDOException $e) {
            error_log('[PujaSankalpa::getCurrentSeasonSponsorLevel] ' . $e->getMessage());
            return '';
        }
    }


   function getonlinepricedata()
  {
    GzObject::loadFiles('Model', array('SankalpaPujaPrice'));
     $SankalpaPujaPriceModel = new SankalpaPujaPriceModel();
     $SankalpaPujaPriceModel->getonlinepricedata();
  }


    function hathekhoripujaprice()
    {
        $this->setIsAjax(true);
        GzObject::loadFiles('Model', array('SankalpaPujaPrice'));
        $SankalpaPujaPriceModel = new SankalpaPujaPriceModel();
        $membertype = $_POST['pricefor'] ?? '';
        $arr = $SankalpaPujaPriceModel->hathekhoripujaprice($membertype);
        $this->tpl['price'] = $arr;
        foreach ($arr as $key => $value) {
            echo '<option value="' . $value['Price'] . '">' . $value['Pujaname'] . ' $' . $value['Price'] . '</option>';

        }
    }

    function checkHaateKhoriFreeEligibility()
    {
        $this->setIsAjax(true);
        header('Content-Type: application/json');
        echo json_encode(array('eligible' => 0));
        exit();
    }

    private function isHaateKhoriFreeEligible($memberId, $category)
    {
        return false;
    }

    private function applyHaateKhoriFreeRegistration(&$post)
    {
        return false;
    }

    private function removeHaateKhoriPranami(&$post)
    {
        $post['pranamifee'] = '';
        $post['pranamifeeuser'] = '';
        $post['defaultpranamifee'] = '';
        $post['hiddenpranamifeeboth'] = '0';
    }
    
    
     function checkSankalpPujaRegistration()
    {
        $this->setIsAjax(true);
       

        GzObject::loadFiles('Model', array('SankalpaPuja'));
        $SankalpaPujaModel = new SankalpaPujaModel();
        $Memberid = $_POST['memberid'] ?? '';
        $SankalpaPujaModel->checkSankalpPuja($Memberid);
        
        
    }
    
    
      function PujaSankalpa() {
    // action method — __construct() handles data loading
  }

  function __construct()
    {
        $this->layout = 'login';
        GzObject::loadFiles('Model', array('SankalpaPuja', 'SankalpaPujaPrice', 'Donation', 'ConfirmCode', 'Member', 'idnumbers', 'User', 'pujaregistration'));
        $SankalpaPujaModel = new SankalpaPujaModel();
        $SankalpaPujaModel->ensureChildAgeColumns();
        $SankalpaPujaModel->syncSchemaWithTableColumns();
        $SankalpaPujaPriceModel = new SankalpaPujaPriceModel();
        $DonationModel = new DonationModel();
        $ConfirmCodeModel = new ConfirmCodeModel();
        $MemberModel = new MemberModel();
        $idnumbersModel = new idnumbersModel();
        $UserModel = new UserModel();
        $this->tpl['otp_admin_bypass'] = ($this->isAdmin() || $this->isEditor()) ? 1 : 0;


        $memberpricearr = $SankalpaPujaPriceModel->pujaprice();
        $this->tpl['memberpricearr'] = $memberpricearr;

        $nonmeberarr = $SankalpaPujaPriceModel->nonmember();
        $this->tpl['nonmeberarr'] = $nonmeberarr;

        $ootpricearr = $SankalpaPujaPriceModel->outoftowner();
        $this->tpl['ootpricearr'] = $ootpricearr;

       if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            unset($_SESSION['sankalpa_payment_processed']);
        }

        if (!empty($_POST['create_registration'])) {
            
            if (isset($_SESSION['sankalpa_payment_processed']) && $_SESSION['sankalpa_payment_processed'] === true) {
                unset($_SESSION['sankalpa_payment_processed']);
                Util::redirect(INSTALL_URL . "PujaSankalpa/PujaSankalpa");
                exit();
            }
            
            
            $namemember = $_POST['ootdata'] ?? '';
            $MemberId = $_POST['Member_id'] ?? '';
            $Gotra = $_POST['gotra'] ?? '';
            if($MemberId !="" && $Gotra !=""){
                $MemberModel->UpdateGotra($MemberId, $Gotra);
            }
            $this->removeHaateKhoriPranami($_POST);
            if (($namemember != "" || $namemember != null) && !empty($_FILES['image']['name']) && ($_POST['freepujasankalpa'] ?? '') != "Donation") {
                $data = array();
                if (!empty($_FILES['image'])) {
                    $fileextension = $_FILES['image']['type'];
                    $newfileextension = explode("/", $fileextension);
                    $filetype = strtolower($newfileextension[1]);
                    if ($filetype == "pdf") {
                        require_once APP_PATH . 'helpers/uploader/class.upload.php';
                        $targetfolder = INSTALL_PATH . UPLOAD_PATH . 'avatar/thumb/';
                        $imgdata = $_FILES['image']['name'];
                        $newimgdata = explode(".", $imgdata);
                        $img_name = time();
                        //$finaldocumentname = $img_name . '.' . $newimgdata[1];
                        $finaldocumentname = $img_name.'.'.$filetype;
                        $targetfolder = $targetfolder . basename($finaldocumentname);

                        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetfolder)) {
                            $data['avatar'] = $finaldocumentname;
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
                            $data['avatar'] = $handle->file_dst_name;
                        }
                    }

                }


                $pujaselect = $_POST['selectedpuja'] ?? '';
                if ($pujaselect == 'hathekhori') {
                    $pujaname = "Haate Khori";
                    $_POST['item_name'] = "Hathe Khori";
                } else {
                    $pujaname = $_POST['allpujaname'][0];
                    $_POST['item_name'] = $_POST['allpujaname'] ?? '';
                }
                date_default_timezone_set("America/Chicago");
                $today = date("Y/m/d");
                $_POST['name'] = ($_POST['First_name'] ?? '') . " " . ($_POST['Last_name'] ?? '');
                $_POST['Status'] = 'pending';

                $_POST['child1name'] = $_POST['childname'][0] ?? '';
                $_POST['child2name'] = $_POST['childname'][1] ?? '';
                $_POST['child1age'] = $_POST['childage'][0] ?? '';
                $_POST['child2age'] = $_POST['childage'][1] ?? '';

                $fullnamesponsorpuja = $_POST['fullnamesponsorpuja'] ?? '';
                $dataToInsert = is_array($fullnamesponsorpuja) ? implode(', ', $fullnamesponsorpuja) : (string)$fullnamesponsorpuja;
                $_POST['personofferingpujasankalpa'] =   $dataToInsert;
                $id = $SankalpaPujaModel->save(array_merge($_POST, $data));
                if ($id !== null) {
                    $MemberName = ($_POST['First_name'] ?? '') . ' ' . ($_POST['Last_name'] ?? '');
                    $reg = $_POST['regmember'] ?? '';
                    $amount = $_POST['item_cost'] ?? '';
                    echo "<div style='text-align: -webkit-center;' class = 'pay'>
            <table border='4'  width='585px' style='margin-left:4em;'>
            <tr>
            <td colspan='2'> <img src='../thankyouscreen.jpg' alt='' height='167px' style='margin-left:12em;'><h1 style='text-align:center;font-family:fangsong; font-size:30px;'><b>Houston Durga Bari Society</b></h1> </td>
            <tr><td colspan='2'><span style='font-size: 18px;font-family: serif;'>Your Puja request have been submitted.
            Registration Team will validate your application and send a confirmation for payment.</span></td></tr>
            <tr><td style='width:50%;'>Full Name</td> <td style='width:50%;'>" . $MemberName . "</td> </tr>
            <tr><td>Registered in HDBS System</td> <td>" . $reg . "</td> </tr>
            <tr><td>Puja Name</td> <td>" . $pujaname . "</td> </tr>
            <tr><td>Total Amount</td> <td><span style= 'color:red;'>$</span>" . $amount . "</td> </tr>
            <tr><td>Request Date</td> <td>" . $today . "</td> </tr>
            <tr><td>Payment Status</td> <td>Pending</td>  </tr>
           <tr><td colspan='2'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>   </tr>
           </tr>";
                    echo "</table>";
                    echo "<a  href='" . INSTALL_URL . "PujaSankalpa/PujaSankalpa'>Go to home</a>";
                    echo "</div>";
                    $MemberName = ($_POST['First_name'] ?? '') . ' ' . ($_POST['Last_name'] ?? '');
                    $amount = $_POST['item_cost'] ?? '';

                    $Emailcc = 'eicetest@gmail.com';
                    $subjetc = 'Puja Request';
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
                      <td style="text-align: center; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;"><strong>Puja Details</strong></td>
                      </tr>
                      </tbody>
                      </table>
                      </div>
                      <div class="email-token-class" style="text-align: center;">
                      <table style="height: 190px; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;" width="604">
                      <tbody>
                      <tr>
                      <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Full Name&nbsp;&nbsp;</td>
                      <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">' . $MemberName . '</td>
                      </tr>
                      <tr>
                      <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Puja Name&nbsp;&nbsp;</td>
                      <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $pujaname . '</td>
                      </tr>
                      <tr>
                      <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Amount &nbsp;</td>
                      <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;"><span style="color:red;">$</span>' . $amount . '</td>
                      </tr>
                      <tr>
                      <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Request Date&nbsp;&nbsp;</td>
                      <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $today . '</td>
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
                        $msg = 'Houston Durga Bari: Full Name: ' . $MemberName . ' , Puja  Request for ' . $pujaname . ' has been submmited. Registration team will validate your request and send a payment confirmation email on your registration email. Total Amount: $' . $amount . ', Status: ' . 'Pending';
                        $this->SendSMS($mobileno, $msg);
                    }
                     $_SESSION['sankalpa_payment_processed'] = true;
                    exit();
                }
            }else if(($_POST['PaymentOption'] ?? '') == "" && (!empty($_FILES['image']['name'])) && ($_POST['freepujasankalpa'] ?? '') == "Donation"){
                $data = array();
                if (!empty($_FILES['image'])) {
                    $fileextension = $_FILES['image']['type'];
                    $newfileextension = explode("/", $fileextension);
                    $filetype = strtolower($newfileextension[1]);
                    if ($filetype == "pdf") {
                        require_once APP_PATH . 'helpers/uploader/class.upload.php';
                        $targetfolder = INSTALL_PATH . UPLOAD_PATH . 'avatar/thumb/';
                        $imgdata = $_FILES['image']['name'];
                        $newimgdata = explode(".", $imgdata);
                        $img_name = time();
                        //$finaldocumentname = $img_name . '.' . $newimgdata[1];
                        $finaldocumentname = $img_name.'.'.$filetype;
                        $targetfolder = $targetfolder . basename($finaldocumentname);

                        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetfolder)) {
                            $data['avatar'] = $finaldocumentname;
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
                            $data['avatar'] = $handle->file_dst_name;
                        }
                    }

                }
                
                $_POST['name'] = ($_POST['First_name'] ?? '') . " " . ($_POST['Last_name'] ?? '');
                date_default_timezone_set("America/Chicago");
                $today = date("Y/m/d");
                $_POST['pay_date'] = $today;
                $_POST['pay_type'] = 'Registration';
                $_POST['item_name'] = ($_POST['freesankalpapujaname'] ?? '') . " " . "(Free)";
                $_POST['selectedpuja'] = 'sankalpapuja';
                $fullnamesponsorpuja = $_POST['fullnamesponsorpuja'] ?? '';
                $dataToInsert = is_array($fullnamesponsorpuja) ? implode(', ', $fullnamesponsorpuja) : (string)$fullnamesponsorpuja;
                $_POST['personofferingpujasankalpa'] =   $dataToInsert;
                $_POST['Status'] = 'pending';
                $id = $SankalpaPujaModel->save(array_merge($_POST, $data));
                if ($id !== null) {
                    $MemberName = ($_POST['First_name'] ?? '') . ' ' . ($_POST['Last_name'] ?? '');
                    echo "<div style='text-align: -webkit-center;' class = 'pay'>
                    <table border='4'  width='585px' style='margin-left:4em;'>
                    <tr>
                    <td colspan='2'> <img src='../thankyouscreen.jpg' alt='' height='167px' style='margin-left:12em;'><h1 style='text-align:center;font-family:fangsong; font-size:30px;'><b>Houston Durga Bari Society</b></h1> </td>
                    <tr><td colspan='2'><span style='font-size: 18px;font-family: serif;'>Your puja request have been submitted.
                    Registration team will validate your application and send a confirmation email.</span></td></tr>
                    <tr><td style='width:50%;'>Full Name</td> <td style='width:50%;'>" . $MemberName . "</td> </tr>
                    <tr><td style='width:50%;'>Member Id</td> <td style='width:50%;'>" . ($_POST['Member_id'] ?? '') . "</td> </tr>
                    <tr><td>Puja Name</td> <td>" . ($_POST['freesankalpapujaname'] ?? '') . " " . '(Free)'. "</td> </tr>
                    <tr><td>Request Date</td> <td>" . $today . "</td> </tr>
                    <tr><td>Status</td> <td>Pending</td>  </tr>
                    <tr><td colspan='2'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>   </tr>
                    </tr>";
                    echo "</table>";
                    echo "<a  href='" . INSTALL_URL . "PujaDonations/pujadonation'>Go to home</a>";
                    echo "</div>";
                    
                    $MemberName = ($_POST['First_name'] ?? '') . ' ' . ($_POST['Last_name'] ?? '');
                    $member_id = $_POST['Member_id'] ?? '';
                    $pujaname = ($_POST['freesankalpapujaname'] ?? '') . " " . '(Free)';
                    
                    $Emailcc = 'eicetest@gmail.com';
                    $subjetc = 'Puja Request';
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
                        <td style="text-align: center; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;"><strong>Puja Details</strong></td>
                        </tr>
                        </tbody>
                        </table>
                        </div>
                        <div class="email-token-class" style="text-align: center;">
                        <table style="height: 190px; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;" width="604">
                        <tbody>
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Full Name&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">' . $MemberName . '</td>
                        </tr>
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Member Id &nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $member_id . '</td>
                        </tr>
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Puja Name&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $pujaname . '</td>
                        </tr>
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Request Date&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $today . '</td>
                        </tr>
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Status&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Pending</td>
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
                        $msg = 'Houston Durga Bari:Member Id: ' . $member_id . ' , Full Name: ' . $MemberName . ' , Puja  Request for ' . $pujaname . ' on ' . $today . ' has been submmited. Registration team will validate your request and send a confirmation email on your registration email.';
                        $this->SendSMS($mobileno, $msg);
                    }                 
                     $_SESSION['sankalpa_payment_processed'] = true;
                    exit();
            }
            }
            
             else if (($_POST['PaymentOption'] ?? '') == "" && ($_POST['freeSubmitBtn'] ?? '') == "freeSubmit" && empty($_FILES['image']['name'])) {
                $_POST['name'] = ($_POST['First_name'] ?? '') . " " . ($_POST['Last_name'] ?? '');
                date_default_timezone_set("America/Chicago");
                $today = date("Y/m/d");
                $_POST['pay_date'] = $today;
                $_POST['pay_type'] = 'Registration';
                // $_POST['item_name'] = trim($_POST['allpujaname'][0]);


                $maxoid = $idnumbersModel->getMaxoid() + 1;
                $update_oid = $idnumbersModel->Updateoid($maxoid);
                $_POST['oid'] = $maxoid;
                $oid  = $maxoid;
                
                $selectedPuja = $_POST['selectedpuja'] ?? ($_POST['pujatype'] ?? '');
                $allPujasRaw = $_POST['allpujaname'] ?? array();
                $allPujasArray = is_array($allPujasRaw) ? array_map('trim', $allPujasRaw) : array(trim((string)$allPujasRaw));
                $allPujasString = implode(', ', array_filter($allPujasArray));
                if ($selectedPuja == 'hathekhori') {
                    $allPujasString = 'Haate Khori';
                }
                $_POST['item_name'] = $allPujasString;
                $_POST['item_cost'] = "0";
                $_POST['selectedpuja'] = $selectedPuja == 'hathekhori' ? 'hathekhori' : 'sankalpapuja';
                $fullnamesponsorpuja = $_POST['fullnamesponsorpuja'] ?? '';
                $dataToInsert = is_array($fullnamesponsorpuja) ? implode(', ', $fullnamesponsorpuja) : (string)$fullnamesponsorpuja;
                $_POST['personofferingpujasankalpa'] = $dataToInsert;

                $_POST['Status'] = 'confirmed';
                $id = $SankalpaPujaModel->save(array_merge($_POST));
                if ($id !== null) {
                    $MemberName = ($_POST['First_name'] ?? '') . ' ' . ($_POST['Last_name'] ?? '');
                    echo "<div style='text-align: -webkit-center;' class = 'pay'>
                    <table border='4'  width='585px' style='margin-left:4em;'>
                    <tr>
                    <td colspan='2'> <img src='../thankyouscreen.jpg' alt='' height='167px' style='margin-left:12em;'><h1 style='text-align:center;font-family:fangsong; font-size:30px;'><b>Houston Durga Bari Society</b></h1> </td>
                    <tr><td style='width:50%;'>Order Id</td> <td style='width:50%;'>" . $oid . "</td> </tr>
                    <tr><td style='width:50%;'>Full Name</td> <td style='width:50%;'>" . $MemberName . "</td> </tr>
                    <tr><td style='width:50%;'>Member Id</td> <td style='width:50%;'>" . ($_POST['Member_id'] ?? '') . "</td> </tr>
                    <tr><td>Puja Name</td> <td>" . h($allPujasString) . "</td> </tr>
                    <tr><td>Date</td> <td>" . $today . "</td> </tr>
                    <tr><td>Status</td> <td>Confirmed</td>  </tr>
                    <tr><td colspan='2'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>   </tr>
                    </tr>";
                    echo "</table>";
                    echo "<a  href='" . INSTALL_URL . "PujaDonations/pujadonation'>Go to home</a>";
                    echo "</div>";
                    $MemberName = ($_POST['First_name'] ?? '') . ' ' . ($_POST['Last_name'] ?? '');
                    $member_id = $_POST['Member_id'] ?? '';
                    $pujaname = $_POST['allpujaname'][0];

                    $Emailcc = 'pujaregpayment@durgabari.org';
                    $subjetc = 'Puja Request';
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
                        <td style="text-align: center; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;"><strong>Puja Details</strong></td>
                        </tr>
                        </tbody>
                        </table>
                        </div>
                        <div class="email-token-class" style="text-align: center;">
                        <table style="height: 190px; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;" width="604">
                        <tbody>
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Full Name&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">' . $MemberName . '</td>
                        </tr>
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Member Id &nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $member_id . '</td>
                        </tr>
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Puja Name&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $pujaname . '</td>
                        </tr>
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Request Date&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $today . '</td>
                        </tr>
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Status&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Confirmed</td>
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
                        $msg = 'Houston Durga Bari: Your Puja Registration request have been submitted. Member Id: ' . $member_id . ', Full Name: ' . $MemberName . ' , Puja Name: ' . $pujaname . ', Request Date: ' . $today . ', Status: ' . 'Confirmed';
                        $this->SendSMS($mobileno, $msg);
                    }
                    $_SESSION['sankalpa_payment_processed'] = true;
                }
            } 
            
            else if(($_POST['PaymentOption'] ?? '') == "" && empty($_FILES['image']['name'])){
                $_POST['name'] = ($_POST['First_name'] ?? '') . " " . ($_POST['Last_name'] ?? '');
                date_default_timezone_set("America/Chicago");
                $today = date("Y/m/d");
                $_POST['pay_date'] = $today;
                $_POST['pay_type'] = 'Registration';
                $_POST['item_name'] = ($_POST['freesankalpapujaname'] ?? '') . " " . "(Free)";
               $fullnamesponsorpuja = $_POST['fullnamesponsorpuja'] ?? '';
                $dataToInsert = implode(', ', $fullnamesponsorpuja);
                $_POST['personofferingpujasankalpa'] =   $dataToInsert;
                $_POST['selectedpuja'] = 'sankalpapuja';
                $_POST['Status'] = 'confirmed';
                $id = $SankalpaPujaModel->save(array_merge($_POST));
                if ($id !== null) {
                    $MemberName = ($_POST['First_name'] ?? '') . ' ' . ($_POST['Last_name'] ?? '');
                    echo "<div style='text-align: -webkit-center;' class = 'pay'>
                    <table border='4'  width='585px' style='margin-left:4em;'>
                    <tr>
                    <td colspan='2'> <img src='../thankyouscreen.jpg' alt='' height='167px' style='margin-left:12em;'><h1 style='text-align:center;font-family:fangsong; font-size:30px;'><b>Houston Durga Bari Society</b></h1> </td>
                    <tr><td style='width:50%;'>Full Name</td> <td style='width:50%;'>" . $MemberName . "</td> </tr>
                    <tr><td style='width:50%;'>Member Id</td> <td style='width:50%;'>" . ($_POST['Member_id'] ?? '') . "</td> </tr>
                    <tr><td>Puja Name</td> <td>" . ($_POST['freesankalpapujaname'] ?? '') . " " . '(Free)'. "</td> </tr>
                    <tr><td>Request Date</td> <td>" . $today . "</td> </tr>
                    <tr><td>Status</td> <td>Confirmed</td>  </tr>
                    <tr><td colspan='2'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>   </tr>
                    </tr>";
                    echo "</table>";
                    echo "<a  href='" . INSTALL_URL . "PujaDonations/pujadonation'>Go to home</a>";
                    echo "</div>";
                    $MemberName = ($_POST['First_name'] ?? '') . ' ' . ($_POST['Last_name'] ?? '');
                    $member_id = $_POST['Member_id'] ?? '';
                    $pujaname = ($_POST['freesankalpapujaname'] ?? '') . " " . '(Free)';
                   
                    $Emailcc = 'eicetest@gmail.com';
                    $subjetc = 'Puja Request';
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
                        <td style="text-align: center; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;"><strong>Puja Details</strong></td>
                        </tr>
                        </tbody>
                        </table>
                        </div>
                        <div class="email-token-class" style="text-align: center;">
                        <table style="height: 190px; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;" width="604">
                        <tbody>
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Full Name&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">' . $MemberName . '</td>
                        </tr>
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Member Id &nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $member_id . '</td>
                        </tr>
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Puja Name&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $pujaname . '</td>
                        </tr>
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Request Date&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $today . '</td>
                        </tr>
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Status&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Confirmed</td>
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
                        $msg = 'Houston Durga Bari: Your Puja Registration request have been submitted. Member Id: ' . $member_id . ', Full Name: ' . $MemberName . ' , Puja Name: ' . $pujaname . ', Request Date: ' . $today . ', Status: ' . 'Confirmed';
                        $this->SendSMS($mobileno, $msg);
                    }
                     $_SESSION['sankalpa_payment_processed'] = true;
                }
            }
            else {
                //echo '<script>alert("member else case")</script>';
                $_POST['name'] = ($_POST['First_name'] ?? '') . " " . ($_POST['Last_name'] ?? '');
                // $_POST['item_name'] =   $_POST['allpujaname'] ?? '';
                date_default_timezone_set("America/Chicago");
                $today = date("Y/m/d");
                $_POST['pay_date'] = $today;
                $_POST['pay_type'] = 'Registration';
                //$_POST['pay_for'] = $_POST['allpujaname'] ?? '';

                // for generate oid 
                $maxoid = $idnumbersModel->getMaxoid() + 1;
                $update_oid = $idnumbersModel->Updateoid($maxoid);
                $_POST['oid'] = $maxoid;
                // end generate oid for
                // check member is email or phone exist or not
                $datamember = $MemberModel->checkmemberregisterornot();
                if ($datamember == null) {

                    // for generate memberid for gd
                    $maxid = $idnumbersModel->getMaxmid() + 1;
                    $update_mid = $idnumbersModel->Updatemid($maxid);
                    $_POST['Member_id'] = $maxid;
                    // end generate memberid for gd 
                }
                if ($datamember != null) {
                    $_POST['Member_id'] = $datamember;
                     // for update telephone no member case
                $existingdata = $MemberModel->checktele2($datamember);
                $alternatemobile = $existingdata[0]['Tele2'];
             if($alternatemobile == null || $alternatemobile != $_POST['alternatenumber'] ?? '' ){
                $mobileno =  $_POST['alternatenumber'] ?? '';
                $MemberModel->updatetelephone($datamember, $mobileno);
            }

            $primaryphone =$existingdata[0]['Tele1'];
            if($primaryphone == null){
                $phone =  $_POST['tele'] ?? '';
                $MemberModel->updateprimaryno($datamember, $phone);
            }
            
            $email =$existingdata[0]['email'];
            if($email == null){
                $email =  $_POST['email'] ?? '';
                $MemberModel->updateemail($datamember, $email);
            }

            $alternateemail = $existingdata[0]['Email2'];
            if($alternateemail == null){
                $alternatemail =  $_POST['alternateemail'] ?? '';
                if( $alternatemail != ""){
                    $MemberModel->updupdatealternateemail($datamember, $alternateemail);
                }
                
            } 
         }
                // End check member is email or phone exist or not

                $pujaselect = $_POST['selectedpuja'] ?? '';
                if ($pujaselect == 'hathekhori') {
                    $pujaname = "Haate Khori";
                    $_POST['item_name'] = "Hathe Khori";
                    $_POST['pay_for'] = "Hathe Khori";
                    $this->removeHaateKhoriPranami($_POST);
                } else {
                    $pujaname = $_POST['allpujaname'][0];
                    $_POST['item_name'] = $_POST['allpujaname'] ?? '';
                    $_POST['pay_for'] = $_POST['allpujaname'] ?? '';
                }
                $this->removeHaateKhoriPranami($_POST);
                $_POST['child1name'] = $_POST['childname'][0] ?? '';
                $_POST['child2name'] = $_POST['childname'][1] ?? '';
                $_POST['child1age'] = $_POST['childage'][0] ?? '';
                $_POST['child2age'] = $_POST['childage'][1] ?? '';
                $fullnamesponsorpuja = $_POST['fullnamesponsorpuja'] ?? '';
                $dataToInsert = is_array($fullnamesponsorpuja) ? implode(', ', $fullnamesponsorpuja) : (string)$fullnamesponsorpuja;
                $_POST['personofferingpujasankalpa'] =   $dataToInsert;
                //   for check admin role 
                if ($this->isAdmin() || $this->isEditor()) {
                    $id = $this->getUserId();
                    $admin = $UserModel->get($id);
                    $rolename = $admin['first'] . ' ' . $admin['last'];
                    $_POST['admin_id'] = $admin['id'];
                    $_POST['admin_name'] = $rolename;

                }

                //for complimentary registration make amount null 
                if (($_POST['PaymentOption'] ?? '') == 'ComplimentaryRegistration') {
                    $_POST['item_cost'] = "0";
                    $_POST['pranamifee'] = "";
                }

                $id = $SankalpaPujaModel->save(array_merge($_POST));
                if (!empty($id)) {

                 //for confirmation email
                    $orderid = $_POST['oid'] ?? '';
                    $Memberid = $_POST['Member_id'] ?? '';
                    $membername = ($_POST['First_name'] ?? '') . ' ' . ($_POST['Last_name'] ?? '');
                    $pujaselect = $_POST['selectedpuja'] ?? '';
                    if ($pujaselect == 'hathekhori') {
                        $pujaname = "Haate Khori";
                    } else {
                        $pujaname = $_POST['allpujaname'][0];
                    }
                    $participationmode = $_POST['modeparticipation'] ?? '';

                    $totalamount = $_POST['item_cost'] ?? '';

                    $paymethod = $_POST['PaymentOption'] ?? '';
                    if ($paymethod == "others") {
                        $payui = 'Zelle';
                    } else if ($paymethod == "check") {
                        $payui = 'Check';
                    } else if ($paymethod == "cash") {
                        $payui = 'Cash';
                    } else if ($paymethod == "directdeposit") {
                        $payui = 'Direct Deposit';
                    } else if ($paymethod == "sumup") {
                        $payui = 'SumUp';
                    } else if ($paymethod == "stripe") {
                        $payui = 'Credit Card';
                    }
                    else if ($paymethod == "zelleProxy") {
                        $payui = 'Zelle Proxy';
                    }

                    $paymentdate = strtotime($_POST['pay_date'] ?? '');
                    $paydateemail = date("m/d/Y", $paymentdate);

                    $Emailcc = 'eicetest@gmail.com';
                    $subjetc = 'Puja Registration Confirmation';
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
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Order Id&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">' . $orderid . '</td>
                        </tr>
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Member Id&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">' . $Memberid . '</td>
                        </tr> 
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Full Name&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">' . $membername . '</td>
                        </tr>
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Puja Name&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $pujaname . '</td>
                        </tr>
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Participation Mode &nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $participationmode . '</td>
                        </tr>
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Total Amount&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;"><span style="color:red;">$</span>' . $totalamount . '</td>
                        </tr>
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Payment Method&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">' . $payui . '</td>
                        </tr>
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Pay Date&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">' . $paydateemail . '</td>
                        </tr> 
                        </tbody>
                        </table>
                        </div>
                        </div>
                        </div>';
                    $textmsg = 'Houston Durga Bari: Puja Registration confirmation are Order Id: ' . $orderid . ', Member Id: ' . $Memberid . ', Full Name: ' . $membername . ', Puja Name: ' . $pujaname . ', Participation Mode: ' . $participationmode . ', Total Amount: $' . $totalamount . ', Payment Method: ' . $payui . ', Pay Date: ' . $paydateemail;

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
                            //if (!empty($arr[0])) {
                            $opts = array();
                            $opts['id'] = $id;
                            $opts['payment_status'] = 'confirmed';
                            $_POST['Status'] = 'confirmed';
                            $data = $_POST;
                            $datamemberarr = array();
                            $datamemberarr = array_merge($opts, $_POST);
                            $SankalpaPujaModel->update(array_merge($opts, $_POST));
                            $value = array();
                            $value['oid'] = $datamemberarr['oid'];
                            $value['Member_id'] = $datamemberarr['Member_id'];
                            $value['MemberName'] = $datamemberarr['name'];
                            $value['PaymentOption'] = $datamemberarr['PaymentOption'];
                            $value['payment_status'] = 'succeeded';
                            $value['payment_timestamp'] = $datamemberarr['payment_timestamp'] ?? '';
                            $value['Amount'] = $datamemberarr['item_cost'];
                            $value['stripe_return'] = $datamemberarr['stripe_return'] ?? '';
                            $value['transaction_id'] = $datamemberarr['transaction_id'];
                            $value['paid_amount'] = $datamemberarr['paid_amount'] ?? '';
                            $value['update_on'] = $datamemberarr['UpdateOn'] ?? '';
                            $value['stripe_product'] = $datamemberarr['stripe_product'] ?? '';
                            $value['pay_date'] = $datamemberarr['pay_date'];
                            $value['pay_type'] = 'Puja Registration';
                            $value['pay_for'] = $datamemberarr['pay_for'];
                            $value['Tele1'] = $datamemberarr['tele'];
                             $value['Tele2'] = $datamemberarr['alternatenumber'];
                            $value['email'] = $datamemberarr['email'];
                            $value['spousename'] = $datamemberarr['spousename'];
                            $value['Address'] = $datamemberarr['streetname'];
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
                                $value['Tele2'] = $_POST['alternatenumber'] ?? '';
                                $value['email'] = $_POST['email'] ?? '';
                                $value['City'] = $_POST['city'] ?? '';
                                $value['State'] = $_POST['state'] ?? '';
                                $value['Zip_Code'] = $_POST['zip'] ?? '';
                                $value['Amount'] = $_POST['item_cost'] ?? '';
                                $value['pay_type'] = 'Puja Registration';
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
                                $value['type'] = $_POST['type'] ?? '';
                                $value['Street'] = $_POST['street'] ?? '';
                                $value['Address'] = $_POST['streetname'] ?? '';
                                $value['Address3'] = $_POST['unit'] ?? '';
                                $value['spousename'] = $_POST['spousename'] ?? '';
                                $value['Child1'] = $_POST['Child1'] ?? '';
                                $value['Age1'] = $_POST['Age1'] ?? '';
                                $value['Child2'] = $_POST['Child2'] ?? '';
                                $value['Age2'] = $_POST['Age2'] ?? '';
                                $value['Child3'] = $_POST['Child3'] ?? '';
                                $value['Age3'] = $_POST['Age3'] ?? '';
                                $MemberModel->SaveDataInmember($value);
                            }
                            $MemberName = $_POST['name'] ?? '';
                            $Amount = $_POST['item_cost'] ?? '';
                            if ($pujaselect == 'hathekhori') {
                                $pujaname = "Haate Khori";
                            } else {
                                $pujaname = $_POST['allpujaname'][0];
                            }
                            $memberid = $_POST['Member_id'] ?? '';
                            $payment_status = $opts['payment_status'];
                            $paymentoption = $_POST['PaymentOption'] ?? '';
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
                      <tr><td>Amount</td> <td><span style='color:red;'>$</span>" . $Amount . "</td> </tr>
                       <tr><td>Puja Name</td> <td>" . $pujaname . "</td>  </tr>
                      <tr><td>Payment Status</td> <td>" . $payment_status . "</td>  </tr>
                      <tr><td>Pay Date</td> <td>" . $payfinaldate . "</td>  </tr>
                      <tr><td colspan='2'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>   </tr>
                      </tr>";

                            echo "</table>";
                            if (!$this->isAdmin() && !$this->isEditor()) {
                                echo "<a  href='" . INSTALL_URL . "PujaSankalpa/PujaSankalpa'>Go to home</a>";

                            }
                            if ($this->isAdmin() || $this->isEditor()) {
                                echo " <a href='" . INSTALL_URL . "Pujaregistration/index'>Go to home</a>";

                            }
                            echo "</div>";
                            $email = $_POST['email'] ?? '';
                            if ($email != null) {
                                $this->sendEmailticket($message, $subjetc, $email, $Emailcc);
                            }
                            $mobileno = $_POST['alternatenumber'] ?? '';
                            if ($mobileno != null) {
                                $this->SendSMS($mobileno, $textmsg );
                            }
                             $_SESSION['sankalpa_payment_processed'] = true;
                            exit();
                        }
                        // for check option
                    } elseif (($_POST['PaymentOption'] ?? '') == 'check') {

                        $_POST['item_cost'] = $_POST['checkAmount'] ?? '';
                        $_POST['bank'] = $_POST['checkbankname'] ?? '';
                        $_POST['chkdate'] = $_POST['CheckDate'] ?? '';
                        //$_POST['pay_date'] = $_POST['CheckDate'] ?? '';
                        $_POST['Status'] = 'confirmed';
                        $_POST['id'] = $id;
                        $data = $_POST;
                        $datamemberarr = array();
                        $datamemberarr = array_merge($_POST);
                        $SankalpaPujaModel->update(array_merge($_POST));
                        $value = array();
                        $value['oid'] = $datamemberarr['oid'];
                        $value['Member_id'] = $datamemberarr['Member_id'];
                        $value['MemberName'] = $datamemberarr['name'];
                        $value['PaymentOption'] = $datamemberarr['PaymentOption'];
                        $value['payment_status'] = 'succeeded';
                        $value['payment_timestamp'] = $datamemberarr['payment_timestamp'] ?? '';
                        $value['Amount'] = $datamemberarr['item_cost'];
                        $value['stripe_return'] = $datamemberarr['stripe_return'] ?? '';
                        $value['transaction_id'] = $datamemberarr['transaction_id'];
                        $value['paid_amount'] = $datamemberarr['paid_amount'] ?? '';
                        $value['update_on'] = $datamemberarr['UpdateOn'] ?? '';
                        $value['stripe_product'] = $datamemberarr['stripe_product'] ?? '';
                        $value['pay_date'] = $datamemberarr['pay_date'];
                        $value['pay_type'] = 'Puja Registration';
                        $value['pay_for'] = $datamemberarr['pay_for'];
                        $value['Tele1'] = $datamemberarr['tele'];
                         $value['Tele2'] = $datamemberarr['alternatenumber'];
                        $value['email'] = $datamemberarr['email'];
                        $value['spousename'] = $datamemberarr['spousename'];
                        $value['Address'] = $datamemberarr['streetname'];
                        $value['Street'] = $datamemberarr['street'];
                        $value['City'] = $datamemberarr['city'];
                        $value['State'] = $datamemberarr['state'];
                        $value['Zip_Code'] = $datamemberarr['zip'];
                        $value['bank'] = $_POST['bank'] ?? '';
                        $value['chkno'] = $_POST['chkno'] ?? '';
                        $value['chkdate'] = $_POST['chkdate'] ?? '';
                        $value['ReceiveBy'] = $_POST['receiveby'] ?? '';
                        $DonationModel->SaveDataInDonation($value);
                        if ($datamember == null) {
                            $value = array();
                            $value['oid'] = $_POST['oid'] ?? '';
                            $value['MemberName'] = $_POST['name'] ?? '';
                            $value['Tele1'] = $_POST['tele'] ?? '';
                            $value['Tele2'] = $_POST['alternatenumber'] ?? '';
                            $value['email'] = $_POST['email'] ?? '';
                            $value['City'] = $_POST['city'] ?? '';
                            $value['State'] = $_POST['state'] ?? '';
                            $value['Zip_Code'] = $_POST['zip'] ?? '';
                            $value['Amount'] = $_POST['item_cost'] ?? '';
                            $value['pay_type'] = 'Puja Registration';
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
                            $value['type'] = $_POST['type'] ?? '';
                            $value['Street'] = $_POST['street'] ?? '';
                            $value['Address'] = $_POST['streetname'] ?? '';
                            $value['Address3'] = $_POST['unit'] ?? '';
                            $value['spousename'] = $_POST['spousename'] ?? '';
                            $value['Child1'] = $_POST['Child1'] ?? '';
                            $value['Age1'] = $_POST['Age1'] ?? '';
                            $value['Child2'] = $_POST['Child2'] ?? '';
                            $value['Age2'] = $_POST['Age2'] ?? '';
                            $value['Child3'] = $_POST['Child3'] ?? '';
                            $value['Age3'] = $_POST['Age3'] ?? '';
                            $MemberModel->SaveDataInmember($value);
                        }
                        $MemberName = $_POST['name'] ?? '';
                        $Amount = $_POST['item_cost'] ?? '';
                        if ($pujaselect == 'hathekhori') {
                            $pujaname = "Haate Khori";
                        } else {
                            $pujaname = $_POST['allpujaname'][0];
                        }
                        $memberid = $_POST['Member_id'] ?? '';
                        $oid = $_POST['oid'] ?? '';
                        $paymentoption = $_POST['PaymentOption'] ?? '';
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
                 <tr><td>Amount</td> <td><span style='color:red;'>$</span>" . $Amount . "</td> </tr>
                  <tr><td>Puja Name</td> <td>" . $pujaname . "</td>  </tr>
                 <tr><td>Payment Status</td> <td>Confirmed</td>  </tr>
                 <tr><td>Pay Date</td> <td>" . $payfinaldate . "</td>  </tr>
                 <tr><td colspan='2'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>   </tr>
                 </tr>";

                        echo "</table>";
                        if (!$this->isAdmin() && !$this->isEditor()) {
                            echo "<a  href='" . INSTALL_URL . "PujaSankalpa/PujaSankalpa'>Go to home</a>";

                        }
                        if ($this->isAdmin() || $this->isEditor()) {
                            echo " <a href='" . INSTALL_URL . "Pujaregistration/index'>Go to home</a>";

                        }
                        echo "</div>";
                        $email = $_POST['email'] ?? '';
                            if ($email != null) {
                                $this->sendEmailticket($message, $subjetc, $email, $Emailcc);
                            }
                            $mobileno = $_POST['alternatenumber'] ?? '';
                            if ($mobileno != null) {
                                $this->SendSMS($mobileno, $textmsg );
                            }
                             $_SESSION['sankalpa_payment_processed'] = true;
                        exit();
                    }
                    // for cash option
                    elseif (($_POST['PaymentOption'] ?? '') == 'cash') {

                        $_POST['item_cost'] = $_POST['cashAmount'] ?? '';
                        $_POST['pay_date'] = $_POST['cashDate'] ?? '';
                        $_POST['Status'] = 'confirmed';
                        $_POST['id'] = $id;
                        $data = $_POST;
                        $datamemberarr = array();
                        $datamemberarr = array_merge($_POST);
                        $SankalpaPujaModel->update(array_merge($_POST));
                        $value = array();
                        $value['oid'] = $datamemberarr['oid'];
                        $value['Member_id'] = $datamemberarr['Member_id'];
                        $value['MemberName'] = $datamemberarr['name'];
                        $value['PaymentOption'] = $datamemberarr['PaymentOption'];
                        $value['payment_status'] = 'succeeded';
                        $value['payment_timestamp'] = $datamemberarr['payment_timestamp'] ?? '';
                        $value['Amount'] = $datamemberarr['item_cost'];
                        $value['stripe_return'] = $datamemberarr['stripe_return'] ?? '';
                        $value['transaction_id'] = $datamemberarr['transaction_id'];
                        $value['paid_amount'] = $datamemberarr['paid_amount'] ?? '';
                        $value['update_on'] = $datamemberarr['UpdateOn'] ?? '';
                        $value['stripe_product'] = $datamemberarr['stripe_product'] ?? '';
                        $value['pay_date'] = $datamemberarr['pay_date'];
                        $value['pay_type'] = 'Puja Registration';
                        $value['pay_for'] = $datamemberarr['pay_for'];
                        $value['Tele1'] = $datamemberarr['tele'];
                         $value['Tele2'] = $datamemberarr['alternatenumber'];
                        $value['email'] = $datamemberarr['email'];
                        $value['spousename'] = $datamemberarr['spousename'];
                        $value['Address'] = $datamemberarr['streetname'];
                        $value['Street'] = $datamemberarr['street'];
                        $value['City'] = $datamemberarr['city'];
                        $value['State'] = $datamemberarr['state'];
                        $value['Zip_Code'] = $datamemberarr['zip'];
                        $value['bank'] = $_POST['bank'] ?? '';
                        $value['chkno'] = $_POST['chkno'] ?? '';
                        $value['chkdate'] = $_POST['chkdate'] ?? '';
                        $value['ReceiveBy'] = $_POST['receiveby'] ?? '';
                        $DonationModel->SaveDataInDonation($value);
                        if ($datamember == null) {
                            $value = array();
                            $value['oid'] = $_POST['oid'] ?? '';
                            $value['MemberName'] = $_POST['name'] ?? '';
                            $value['Tele1'] = $_POST['tele'] ?? '';
                            $value['Tele2'] = $_POST['alternatenumber'] ?? '';
                            $value['email'] = $_POST['email'] ?? '';
                            $value['City'] = $_POST['city'] ?? '';
                            $value['State'] = $_POST['state'] ?? '';
                            $value['Zip_Code'] = $_POST['zip'] ?? '';
                            $value['Amount'] = $_POST['item_cost'] ?? '';
                            $value['pay_type'] = 'Puja Registration';
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
                            $value['type'] = $_POST['type'] ?? '';
                            $value['Street'] = $_POST['street'] ?? '';
                            $value['Address'] = $_POST['streetname'] ?? '';
                            $value['Address3'] = $_POST['unit'] ?? '';
                            $value['spousename'] = $_POST['spousename'] ?? '';
                            $value['Child1'] = $_POST['Child1'] ?? '';
                            $value['Age1'] = $_POST['Age1'] ?? '';
                            $value['Child2'] = $_POST['Child2'] ?? '';
                            $value['Age2'] = $_POST['Age2'] ?? '';
                            $value['Child3'] = $_POST['Child3'] ?? '';
                            $value['Age3'] = $_POST['Age3'] ?? '';
                            $MemberModel->SaveDataInmember($value);
                        }
                        $MemberName = $_POST['name'] ?? '';
                        $Amount = $_POST['item_cost'] ?? '';
                        if ($pujaselect == 'hathekhori') {
                            $pujaname = "Haate Khori";
                        } else {
                            $pujaname = $_POST['allpujaname'][0];
                        }
                        $memberid = $_POST['Member_id'] ?? '';
                        $oid = $_POST['oid'] ?? '';
                        $paymentoption = $_POST['PaymentOption'] ?? '';
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
                 <tr><td>Amount</td> <td><span style='color:red;'>$</span>" . $Amount . "</td> </tr>
                  <tr><td>Puja Name</td> <td>" . $pujaname . "</td>  </tr>
                 <tr><td>Payment Status</td> <td>Confirmed</td>  </tr>
                 <tr><td>Pay Date</td> <td>" . $payfinaldate . "</td>  </tr>
                 <tr><td colspan='2'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>   </tr>
                 </tr>";

                        echo "</table>";
                        if (!$this->isAdmin() && !$this->isEditor()) {
                            echo "<a  href='" . INSTALL_URL . "PujaSankalpa/PujaSankalpa'>Go to home</a>";

                        }
                        if ($this->isAdmin() || $this->isEditor()) {
                              echo " <a href='" . INSTALL_URL . "Pujaregistration/index'>Go to home</a>"; 
                            //echo " <a href='http://localhost:8082/7june/Pujaregistration/index'>Go to home</a>";
                        }
                        echo "</div>";
                        $email = $_POST['email'] ?? '';
                            if ($email != null) {
                                $this->sendEmailticket($message, $subjetc, $email, $Emailcc);
                            }
                            $mobileno = $_POST['alternatenumber'] ?? '';
                            if ($mobileno != null) {
                                $this->SendSMS($mobileno, $textmsg );
                            }
                             $_SESSION['sankalpa_payment_processed'] = true;
                        exit();

                    }
                    // for directdeposite option
                    elseif (($_POST['PaymentOption'] ?? '') == 'directdeposit') {
                        $_POST['bank'] = $_POST['directbank'] ?? '';
                        $_POST['transaction_id'] = $_POST['transactioncode'] ?? '';
                        $_POST['item_cost'] = $_POST['directdepositeamount'] ?? '';
                        $_POST['pay_date'] = $_POST['transactiondate'] ?? '';
                        $_POST['Status'] = 'confirmed';
                        $_POST['id'] = $id;
                        $data = $_POST;
                        $datamemberarr = array();
                        $datamemberarr = array_merge($_POST);
                        $SankalpaPujaModel->update(array_merge($_POST));
                        $value = array();
                        $value['oid'] = $datamemberarr['oid'];
                        $value['Member_id'] = $datamemberarr['Member_id'];
                        $value['MemberName'] = $datamemberarr['name'];
                        $value['PaymentOption'] = $datamemberarr['PaymentOption'];
                        $value['payment_status'] = 'succeeded';
                        $value['payment_timestamp'] = $datamemberarr['payment_timestamp'] ?? '';
                        $value['Amount'] = $datamemberarr['item_cost'];
                        $value['stripe_return'] = $datamemberarr['stripe_return'] ?? '';
                        $value['transaction_id'] = $datamemberarr['transaction_id'];
                        $value['paid_amount'] = $datamemberarr['paid_amount'] ?? '';
                        $value['update_on'] = $datamemberarr['UpdateOn'] ?? '';
                        $value['stripe_product'] = $datamemberarr['stripe_product'] ?? '';
                        $value['pay_date'] = $datamemberarr['pay_date'];
                        $value['pay_type'] = 'Puja Registration';
                        $value['pay_for'] = $datamemberarr['pay_for'];
                        $value['Tele1'] = $datamemberarr['tele'];
                         $value['Tele2'] = $datamemberarr['alternatenumber'];
                        $value['email'] = $datamemberarr['email'];
                        $value['spousename'] = $datamemberarr['spousename'];
                        $value['Address'] = $datamemberarr['streetname'];
                        $value['Street'] = $datamemberarr['street'];
                        $value['City'] = $datamemberarr['city'];
                        $value['State'] = $datamemberarr['state'];
                        $value['Zip_Code'] = $datamemberarr['zip'];
                        $value['bank'] = $_POST['bank'] ?? '';
                        $value['chkno'] = $_POST['chkno'] ?? '';
                        $value['chkdate'] = $_POST['chkdate'] ?? '';
                        $value['ReceiveBy'] = $_POST['receiveby'] ?? '';
                        $DonationModel->SaveDataInDonation($value);
                        if ($datamember == null) {
                            $value = array();
                            $value['oid'] = $_POST['oid'] ?? '';
                            $value['MemberName'] = $_POST['name'] ?? '';
                            $value['Tele1'] = $_POST['tele'] ?? '';
                            $value['Tele2'] = $_POST['alternatenumber'] ?? '';
                            $value['email'] = $_POST['email'] ?? '';
                            $value['City'] = $_POST['city'] ?? '';
                            $value['State'] = $_POST['state'] ?? '';
                            $value['Zip_Code'] = $_POST['zip'] ?? '';
                            $value['Amount'] = $_POST['item_cost'] ?? '';
                            $value['pay_type'] = 'Puja Registration';
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
                            $value['type'] = $_POST['type'] ?? '';
                            $value['Street'] = $_POST['street'] ?? '';
                            $value['Address'] = $_POST['streetname'] ?? '';
                            $value['Address3'] = $_POST['unit'] ?? '';
                            $value['spousename'] = $_POST['spousename'] ?? '';
                            $value['Child1'] = $_POST['Child1'] ?? '';
                            $value['Age1'] = $_POST['Age1'] ?? '';
                            $value['Child2'] = $_POST['Child2'] ?? '';
                            $value['Age2'] = $_POST['Age2'] ?? '';
                            $value['Child3'] = $_POST['Child3'] ?? '';
                            $value['Age3'] = $_POST['Age3'] ?? '';
                            $MemberModel->SaveDataInmember($value);
                        }
                        $MemberName = $_POST['name'] ?? '';
                        $Amount = $_POST['item_cost'] ?? '';
                        if ($pujaselect == 'hathekhori') {
                            $pujaname = "Haate Khori";
                        } else {
                            $pujaname = $_POST['allpujaname'][0];
                        }
                        $memberid = $_POST['Member_id'] ?? '';
                        $oid = $_POST['oid'] ?? '';
                        $paymentoption = $_POST['PaymentOption'] ?? '';
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
                 <tr><td>Amount</td> <td><span style='color:red;'>$</span>" . $Amount . "</td> </tr>
                  <tr><td>Puja Name</td> <td>" . $pujaname . "</td>  </tr>
                 <tr><td>Payment Status</td> <td>Confirmed</td>  </tr>
                 <tr><td>Pay Date</td> <td>" . $payfinaldate . "</td>  </tr>
                 <tr><td colspan='2'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>   </tr>
                 </tr>";

                        echo "</table>";
                        if (!$this->isAdmin() && !$this->isEditor()) {
                            echo "<a  href='" . INSTALL_URL . "PujaSankalpa/PujaSankalpa'>Go to home</a>";

                        }
                        if ($this->isAdmin() || $this->isEditor()) {
                            echo " <a href='" . INSTALL_URL . "Pujaregistration/index'>Go to home</a>";

                        }
                        echo "</div>";
                        $email = $_POST['email'] ?? '';
                            if ($email != null) {
                                $this->sendEmailticket($message, $subjetc, $email, $Emailcc);
                            }
                            $mobileno = $_POST['alternatenumber'] ?? '';
                            if ($mobileno != null) {
                                $this->SendSMS($mobileno, $textmsg );
                            }
                             $_SESSION['sankalpa_payment_processed'] = true;
                        exit();
                    }
                    // for sumup option
                    elseif (($_POST['PaymentOption'] ?? '') == 'sumup') {
                        $_POST['item_cost'] = $_POST['sumupamount'] ?? '';
                        $_POST['transaction_id'] = $_POST['sumupid'] ?? '';
                        $_POST['pay_date'] = $_POST['sumupdate'] ?? '';
                        $_POST['Status'] = 'confirmed';
                        $_POST['id'] = $id;
                        $data = $_POST;
                        $datamemberarr = array();
                        $datamemberarr = array_merge($_POST);
                        $SankalpaPujaModel->update(array_merge($_POST));
                        $value = array();
                        $value['oid'] = $datamemberarr['oid'];
                        $value['Member_id'] = $datamemberarr['Member_id'];
                        $value['MemberName'] = $datamemberarr['name'];
                        $value['PaymentOption'] = $datamemberarr['PaymentOption'];
                        $value['payment_status'] = 'succeeded';
                        $value['payment_timestamp'] = $datamemberarr['payment_timestamp'] ?? '';
                        $value['Amount'] = $datamemberarr['item_cost'];
                        $value['stripe_return'] = $datamemberarr['stripe_return'] ?? '';
                        $value['transaction_id'] = $datamemberarr['transaction_id'];
                        $value['paid_amount'] = $datamemberarr['paid_amount'] ?? '';
                        $value['update_on'] = $datamemberarr['UpdateOn'] ?? '';
                        $value['stripe_product'] = $datamemberarr['stripe_product'] ?? '';
                        $value['pay_date'] = $datamemberarr['pay_date'];
                        $value['pay_type'] = 'Puja Registration';
                        $value['pay_for'] = $datamemberarr['pay_for'];
                        $value['Tele1'] = $datamemberarr['tele'];
                         $value['Tele2'] = $datamemberarr['alternatenumber'];
                        $value['email'] = $datamemberarr['email'];
                        $value['spousename'] = $datamemberarr['spousename'];
                        $value['Address'] = $datamemberarr['streetname'];
                        $value['Street'] = $datamemberarr['street'];
                        $value['City'] = $datamemberarr['city'];
                        $value['State'] = $datamemberarr['state'];
                        $value['Zip_Code'] = $datamemberarr['zip'];
                        $value['bank'] = $_POST['bank'] ?? '';
                        $value['chkno'] = $_POST['chkno'] ?? '';
                        $value['chkdate'] = $_POST['chkdate'] ?? '';
                        $value['ReceiveBy'] = $_POST['receiveby'] ?? '';
                        $DonationModel->SaveDataInDonation($value);
                        if ($datamember == null) {
                            $value = array();
                            $value['oid'] = $_POST['oid'] ?? '';
                            $value['MemberName'] = $_POST['name'] ?? '';
                            $value['Tele1'] = $_POST['tele'] ?? '';
                            $value['Tele2'] = $_POST['alternatenumber'] ?? '';
                            $value['email'] = $_POST['email'] ?? '';
                            $value['City'] = $_POST['city'] ?? '';
                            $value['State'] = $_POST['state'] ?? '';
                            $value['Zip_Code'] = $_POST['zip'] ?? '';
                            $value['Amount'] = $_POST['item_cost'] ?? '';
                            $value['pay_type'] = 'Puja Registration';
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
                            $value['type'] = $_POST['type'] ?? '';
                            $value['Street'] = $_POST['street'] ?? '';
                            $value['Address'] = $_POST['streetname'] ?? '';
                            $value['Address3'] = $_POST['unit'] ?? '';
                            $value['spousename'] = $_POST['spousename'] ?? '';
                            $value['Child1'] = $_POST['Child1'] ?? '';
                            $value['Age1'] = $_POST['Age1'] ?? '';
                            $value['Child2'] = $_POST['Child2'] ?? '';
                            $value['Age2'] = $_POST['Age2'] ?? '';
                            $value['Child3'] = $_POST['Child3'] ?? '';
                            $value['Age3'] = $_POST['Age3'] ?? '';
                            $MemberModel->SaveDataInmember($value);
                        }
                        $MemberName = $_POST['name'] ?? '';
                        $Amount = $_POST['item_cost'] ?? '';
                        if ($pujaselect == 'hathekhori') {
                            $pujaname = "Haate Khori";
                        } else {
                            $pujaname = $_POST['allpujaname'][0];
                        }
                        $memberid = $_POST['Member_id'] ?? '';
                        $oid = $_POST['oid'] ?? '';
                        $paymentoption = $_POST['PaymentOption'] ?? '';
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
                 <tr><td>Amount</td> <td><span style='color:red;'>$</span>" . $Amount . "</td> </tr>
                  <tr><td>Puja Name</td> <td>" . $pujaname . "</td>  </tr>
                 <tr><td>Payment Status</td> <td>Confirmed</td>  </tr>
                 <tr><td>Pay Date</td> <td>" . $payfinaldate . "</td>  </tr>
                 <tr><td colspan='2'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>   </tr>
                 </tr>";

                        echo "</table>";
                        if (!$this->isAdmin() && !$this->isEditor()) {
                            echo "<a  href='" . INSTALL_URL . "PujaSankalpa/PujaSankalpa'>Go to home</a>";

                        }
                        if ($this->isAdmin() || $this->isEditor()) {
                            echo " <a href='" . INSTALL_URL . "Pujaregistration/index'>Go to home</a>";

                        }
                        echo "</div>";
                        $email = $_POST['email'] ?? '';
                            if ($email != null) {
                                $this->sendEmailticket($message, $subjetc, $email, $Emailcc);
                            }
                            $mobileno = $_POST['alternatenumber'] ?? '';
                            if ($mobileno != null) {
                                $this->SendSMS($mobileno, $textmsg );
                            }
                             $_SESSION['sankalpa_payment_processed'] = true;
                        exit();
                    }
                    //Coplimentory Registration
                    elseif (($_POST['PaymentOption'] ?? '') == 'ComplimentaryRegistration') {
                        $opts['payment_status'] = 'confirmed';
                        $_POST['payment_status'] = 'confirmed';
                        $_POST['Status'] = 'confirmed';
                        $_POST['id'] = $id;

                        $SankalpaPujaModel->update(array_merge($_POST));
                        $paymentdate = strtotime($_POST['pay_date'] ?? '');
                        $paydateemail = date("m/d/Y", $paymentdate);
                        $orderid = $_POST['oid'] ?? '';
                        $Memberid = $_POST['Member_id'] ?? '';
                        $membername = ($_POST['First_name'] ?? '') . ' ' . ($_POST['Last_name'] ?? '');
                        $pujaselect = $_POST['selectedpuja'] ?? '';
                        if ($pujaselect == 'hathekhori') {
                            $pujaname = "Haate Khori";
                        } else {
                            $pujaname = $_POST['allpujaname'][0];
                        }
                        $participationmode = $_POST['modeparticipation'] ?? '';
                        $totalamount = $_POST['item_cost'] ?? '';
                        $payui = 'Complimentary Registration';

                        $Emailcc = 'pujaregpayment@durgabari.org';
                        $subjetc = 'Puja Registration Confirmation';
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
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Order Id&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">' . $orderid . '</td>
                        </tr>
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Member Id&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">' . $Memberid . '</td>
                        </tr> 
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Full Name&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">' . $membername . '</td>
                        </tr>
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Puja Name&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $pujaname . '</td>
                        </tr>
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Participation Mode &nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $participationmode . '</td>
                        </tr>
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Payment Method&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">' . $payui . '</td>
                        </tr>
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Pay Date&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">' . $paydateemail . '</td>
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
                            $textmsg = 'Houston Durga Bari: Puja Registration confirmation are Order Id: ' . $orderid . ', Member Id: ' . $Memberid . ', Full Name: ' . $membername . ', Puja Name: ' . $pujaname . ', Participation Mode: ' . $participationmode . ', Payment Method: ' . $payui . ', Pay Date: ' . $paydateemail;
                            $this->SendSMS($mobileno, $textmsg );
                        }
                        echo "<div style='text-align: -webkit-center;' class = 'pay'>
                         <table border='4' width='585px'>
                         <tr>
                         <td colspan='2'> <img src='../thankyouscreen.jpg' alt='' height='167px' style='margin-left:12em;'><h1 style='text-align:center;font-family:fangsong; font-size:30px;'><b>Houston Durga Bari Society</b></h1> </td>
                         </tr>
                         <tr><td style='width:50%;'>Order Id</td> <td style='width:50%;'>" . $orderid . "</td> </tr>
                         <tr><td>Member Id</td> <td>" . $Memberid . "</td> </tr>
                         <tr><td>Full Name</td> <td>" . $membername . "</td> </tr>
                         <tr><td>Payment Method</td> <td>Complimentary Registration</td></tr>
                          <tr><td>Puja Name</td> <td>" . $pujaname . "</td></tr>
                         <tr><td>Payment Status</td> <td>Confirmed</td></tr>
                         <tr><td>Pay Date</td> <td>" . $payfinaldate . "</td></tr>
                         <tr><td colspan='2'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td></tr>
                         </tr>";
                        echo "</table>";
                        if (!$this->isAdmin() && !$this->isEditor()) {
                            echo "<a  href='" . INSTALL_URL . "PujaSankalpa/PujaSankalpa'>Go to home</a>";

                        }
                        if ($this->isAdmin() || $this->isEditor()) {
                            echo " <a href='" . INSTALL_URL . "Pujaregistration/index'>Go to home</a>";

                        }
                         $_SESSION['sankalpa_payment_processed'] = true;
                        exit();
                    }
                    
                     elseif (($_POST['PaymentOption'] ?? '') == 'zelleProxy') {
                        $_POST['item_cost'] = $_POST['proxyamount'] ?? '';
                        $_POST['transaction_id'] = $_POST['zelleProxyTid'] ?? '';
                        $_POST['pay_date'] = $_POST['proxydate'] ?? '';
                        $_POST['DepositAccount'] = $_POST['zelleProxyDepositAccount'] ?? '';
                        $_POST['Status'] = 'confirmed';
                        $_POST['id'] = $id;
                        $data = $_POST;
                        $datamemberarr = array();
                        $datamemberarr = array_merge($_POST);
                        $SankalpaPujaModel->update(array_merge($_POST));
                        $value = array();
                        $value['oid'] = $datamemberarr['oid'];
                        $value['Member_id'] = $datamemberarr['Member_id'];
                        $value['MemberName'] = $datamemberarr['name'];
                        $value['PaymentOption'] = $datamemberarr['PaymentOption'];
                        $value['payment_status'] = 'succeeded';
                        $value['payment_timestamp'] = $datamemberarr['payment_timestamp'] ?? '';
                        $value['Amount'] = $datamemberarr['item_cost'];
                        $value['stripe_return'] = $datamemberarr['stripe_return'] ?? '';
                        $value['transaction_id'] = $datamemberarr['transaction_id'];
                        $value['paid_amount'] = $datamemberarr['paid_amount'] ?? '';
                        $value['update_on'] = $datamemberarr['UpdateOn'] ?? '';
                        $value['stripe_product'] = $datamemberarr['stripe_product'] ?? '';
                        $value['pay_date'] = $datamemberarr['pay_date'];
                        $value['pay_type'] = 'Puja Registration';
                        $value['pay_for'] = $datamemberarr['pay_for'];
                        $value['Tele1'] = $datamemberarr['tele'];
                        $value['Tele2'] = $datamemberarr['alternatenumber'];
                        $value['email'] = $datamemberarr['email'];
                        $value['spousename'] = $datamemberarr['spousename'];
                        $value['Address'] = $datamemberarr['streetname'];
                        $value['Street'] = $datamemberarr['street'];
                        $value['City'] = $datamemberarr['city'];
                        $value['State'] = $datamemberarr['state'];
                        $value['Zip_Code'] = $datamemberarr['zip'];
                        $value['bank'] = $_POST['bank'] ?? '';
                        $value['chkno'] = $_POST['chkno'] ?? '';
                        $value['chkdate'] = $_POST['chkdate'] ?? '';
                        $value['ReceiveBy'] = $_POST['receiveby'] ?? '';
                        $value['DepositAccount'] = $datamemberarr['DepositAccount'];
                        $value['admin_id'] = $datamemberarr['admin_id'];
                        $value['admin_name'] = $datamemberarr['admin_name'];
                        $DonationModel->SaveDataInDonation($value);
                        if ($datamember == null) {
                            $value = array();
                            $value['oid'] = $_POST['oid'] ?? '';
                            $value['MemberName'] = $_POST['name'] ?? '';
                            $value['Tele1'] = $_POST['tele'] ?? '';
                            $value['Tele2'] = $_POST['alternatenumber'] ?? '';
                            $value['email'] = $_POST['email'] ?? '';
                            $value['City'] = $_POST['city'] ?? '';
                            $value['State'] = $_POST['state'] ?? '';
                            $value['Zip_Code'] = $_POST['zip'] ?? '';
                            $value['Amount'] = $_POST['item_cost'] ?? '';
                            $value['pay_type'] = 'Puja Registration';
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
                            $value['type'] = $_POST['type'] ?? '';
                            $value['Street'] = $_POST['street'] ?? '';
                            $value['Address'] = $_POST['streetname'] ?? '';
                            $value['Address3'] = $_POST['unit'] ?? '';
                            $value['spousename'] = $_POST['spousename'] ?? '';
                            $value['Child1'] = $_POST['Child1'] ?? '';
                            $value['Age1'] = $_POST['Age1'] ?? '';
                            $value['Child2'] = $_POST['Child2'] ?? '';
                            $value['Age2'] = $_POST['Age2'] ?? '';
                            $value['Child3'] = $_POST['Child3'] ?? '';
                            $value['Age3'] = $_POST['Age3'] ?? '';
                            $MemberModel->SaveDataInmember($value);
                        }
                        $MemberName = $_POST['name'] ?? '';
                        $Amount = $_POST['item_cost'] ?? '';
                        if ($pujaselect == 'hathekhori') {
                            $pujaname = "Haate Khori";
                        } else {
                            $pujaname = $_POST['allpujaname'][0];
                        }
                        $memberid = $_POST['Member_id'] ?? '';
                        $oid = $_POST['oid'] ?? '';
                        $paymentoption = $_POST['PaymentOption'] ?? '';
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
                 <tr><td>Payment Method</td> <td>Zelle Proxy</td>  </tr>
                 <tr><td>Amount</td> <td><span style='color:red;'>$</span>" . $Amount . "</td> </tr>
                  <tr><td>Puja Name</td> <td>" . $pujaname . "</td>  </tr>
                 <tr><td>Payment Status</td> <td>Confirmed</td>  </tr>
                 <tr><td>Pay Date</td> <td>" . $payfinaldate . "</td>  </tr>
                 <tr><td colspan='2' style='font-weight: bold;color:red;'>An email with your payment information has been sent to your registered email address. Please check your spam folder if you cannot find the email in your inbox</td></tr>
                 <tr><td colspan='2'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>   </tr>
                 </tr>";

                        echo "</table>";
                        if (!$this->isAdmin() && !$this->isEditor()) {
                            echo "<a  href='" . INSTALL_URL . "PujaSankalpa/PujaSankalpa'>Go to home</a>";

                        }
                        if ($this->isAdmin() || $this->isEditor()) {
                            echo " <a href='" . INSTALL_URL . "Pujaregistration/index'>Go to home</a>";

                        }
                        echo "</div>";
                        $email = $_POST['email'] ?? '';
                            if ($email != null) {
                                $this->sendEmailticket($message, $subjetc, $email, $Emailcc);
                            }
                            $mobileno = $_POST['alternatenumber'] ?? '';
                            if ($mobileno != null) {
                                 $this->SendSMS($mobileno, $textmsg );
                            }
                             $_SESSION['sankalpa_payment_processed'] = true;
                        exit();
                    }
                    // for stripe option
                    elseif (($_POST['PaymentOption'] ?? '') == 'stripe') {

                        $amount = $_POST['item_cost'] ?? '';

                        $total = $amount;

                        $pujaselect = $_POST['selectedpuja'] ?? '';
                        if ($pujaselect == 'hathekhori') {
                            $pujaname = "Haate Khori";
                        } else {
                          $pujaname = $_POST['allpujaname'][0];
                        }
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
                                    "description" => "Pay For:" . $pujaname . ', ' . "Email:" . ($_POST['email'] ?? '') . ', ' . "Full Name:" . ($_POST['MemberName'] ?? ''),
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
                                $_POST['Status'] = 'confirmed';
                                $opts['payment_timestamp'] = time();
                                $data = $_POST;
                                $datamemberarr = array();
                                $datamemberarr = array_merge($opts, $_POST);
                                $SankalpaPujaModel->update(array_merge($opts, $_POST));
                                if ($pujaselect == 'hathekhori') {
                                    $pujaname = "Haate Khori";
                                } else {
                                    $pujaname = $_POST['allpujaname'] ?? '';
                                }

                                $value = array();
                                $value['oid'] = $datamemberarr['oid'];
                                $value['Member_id'] = $datamemberarr['Member_id'];
                                $value['MemberName'] = $datamemberarr['name'];
                                $value['PaymentOption'] = $datamemberarr['PaymentOption'];
                                $value['payment_status'] = 'succeeded';
                                $value['payment_timestamp'] = $datamemberarr['payment_timestamp'] ?? '';
                                $value['Amount'] = $datamemberarr['item_cost'];
                                $value['stripe_return'] = $datamemberarr['stripe_return'] ?? '';
                                $value['transaction_id'] = $datamemberarr['transaction_id'];
                                $value['paid_amount'] = $datamemberarr['paid_amount'] ?? '';
                                $value['update_on'] = $datamemberarr['UpdateOn'] ?? '';
                                $value['stripe_product'] = $datamemberarr['stripe_product'] ?? '';
                                $value['pay_date'] = $datamemberarr['pay_date'];
                                $value['pay_type'] = 'Puja Registration';
                                $pujaselect = $_POST['selectedpuja'] ?? '';
                                $value['pay_for'] = $_POST['pay_for'] ?? '';
                                $value['Tele1'] = $datamemberarr['tele'];
                                 $value['Tele2'] = $datamemberarr['alternatenumber'];
                                $value['email'] = $datamemberarr['email'];
                                $value['spousename'] = $datamemberarr['spousename'];
                                $value['Address'] = $datamemberarr['streetname'];
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
                                    $value['Tele2'] = $_POST['alternatenumber'] ?? '';
                                    $value['email'] = $_POST['email'] ?? '';
                                    $value['City'] = $_POST['city'] ?? '';
                                    $value['State'] = $_POST['state'] ?? '';
                                    $value['Zip_Code'] = $_POST['zip'] ?? '';
                                    $value['Amount'] = $_POST['item_cost'] ?? '';
                                    $value['pay_type'] = 'Puja Registration';
                                    $value['pay_for'] =  $pujaname;
                                    $value['pay_date'] = $_POST['pay_date'] ?? '';
                                    $value['transaction_id'] = $_POST['transaction_id'] ?? '';
                                    $value['remarks'] = $_POST['remarks'] ?? '';
                                    $value['created_on'] = $_POST['created_on'] ?? '';
                                    $value['update_on'] = $_POST['update_on'] ?? '';
                                    $value['PaymentOption'] = $_POST['PaymentOption'] ?? '';
                                    $value['payment_status'] = 'confirmed';
                                    $value['cc_name'] = $_POST['cc_name'] ?? '';
                                    $value['Member_id'] = $_POST['Member_id'] ?? '';
                                    $value['type'] = $_POST['type'] ?? '';
                                    $value['street'] = $_POST['street'] ?? '';
                                    $value['Address'] = $_POST['streetname'] ?? '';
                                    $value['Address3'] = $_POST['unit'] ?? '';
                                    $value['spousename'] = $_POST['spousename'] ?? '';
                                    $value['Child1'] = $_POST['Child1'] ?? '';
                                    $value['Age1'] = $_POST['Age1'] ?? '';
                                    $value['Child2'] = $_POST['Child2'] ?? '';
                                    $value['Age2'] = $_POST['Age2'] ?? '';
                                    $value['Child3'] = $_POST['Child3'] ?? '';
                                    $value['Age3'] = $_POST['Age3'] ?? '';
                                    $MemberModel->SaveDataInmember($value);
                                }
                                $MemberName = $_POST['name'] ?? '';
                                $Amount = $_POST['item_cost'] ?? '';
                                if ($pujaselect == 'hathekhori') {
                                    $pujaname = "Haate Khori";
                                } else {
                                    $pujaname = $_POST['allpujaname'][0];
                                }
                                $memberid = $_POST['Member_id'] ?? '';
                                $payment_status = $opts['payment_status'];
                                $paymentoption = $_POST['PaymentOption'] ?? '';
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
                 <tr><td>Payment Method</td> <td>Credit Card</td>  </tr>
                 <tr><td>Amount</td> <td><span style='color:red;'>$</span>" . $Amount . "</td> </tr>
                  <tr><td>Puja Name</td> <td>" . $pujaname . "</td>  </tr>
                 <tr><td>Payment Status</td> <td>Confirmed</td>  </tr>
                 <tr><td>Pay Date</td> <td>" . $payfinaldate . "</td>  </tr>
                 <tr><td colspan='2'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>   </tr>
                 </tr>";

                                echo "</table>";
                                // echo "<a  href='" . INSTALL_URL . "PujaSankalpa/PujaSankalpa'>Go to home</a>";
                                if (!$this->isAdmin() && !$this->isEditor()) {
                                    echo "<a  href='" . INSTALL_URL . "PujaSankalpa/PujaSankalpa'>Go to home</a>";

                                }
                                if ($this->isAdmin() || $this->isEditor()) {
                                    echo " <a href='" . INSTALL_URL . "Pujaregistration/index'>Go to home</a>";

                                }
                                echo "</div>";

                            $email = $_POST['email'] ?? '';
                            if ($email != null) {
                                $this->sendEmailticket($message, $subjetc, $email, $Emailcc);
                            }
                            $mobileno = $_POST['alternatenumber'] ?? '';
                            if ($mobileno != null) {
                                $this->SendSMS($mobileno, $textmsg );
                            }

                                $this->tpl['arr'] = $SankalpaPujaModel->get($id);
                                 $_SESSION['sankalpa_payment_processed'] = true;
                            } else {

                                $opts = array();
                                $opts['id'] = $id;
                                $opts['stripe_return'] = $payment->status;
                                $opts['transaction_id'] = $payment->id;
                                $opts['paid_amount'] = $payment->amount;
                                $opts['stripe_product'] = $payment->description;

                                $SankalpaPujaModel->update($opts);

                                $_SESSION['status'] = '<strong>' . __('declined_card') . '</strong>';
                            }
                        } catch (Exception $ex) {
                            $_SESSION['status'] = $ex->getMessage();
                        }

                        $this->tpl['arr'] = $SankalpaPujaModel->get($id);
                        $this->tpl['arr']['amount'] = $total;
                    } else {
                        $_SESSION['status'] = 16;

                    }
                } else {
                    $_SESSION['status'] = 17;
                }

            }
            exit();
        }
    }



    function PujaSankalpa_2_July()
    {
        $this->layout = 'login';
        GzObject::loadFiles('Model', array('SankalpaPuja', 'SankalpaPujaPrice', 'Donation', 'ConfirmCode', 'Member', 'idnumbers', 'User'));
        $SankalpaPujaModel = new SankalpaPujaModel();
        $SankalpaPujaPriceModel = new SankalpaPujaPriceModel();
        $DonationModel = new DonationModel();
        $ConfirmCodeModel = new ConfirmCodeModel();
        $MemberModel = new MemberModel();
        $idnumbersModel = new idnumbersModel();
        $UserModel = new UserModel();


        $memberpricearr = $SankalpaPujaPriceModel->pujaprice();
        $this->tpl['memberpricearr'] = $memberpricearr;

        $nonmeberarr = $SankalpaPujaPriceModel->nonmember();
        $this->tpl['nonmeberarr'] = $nonmeberarr;

        $ootpricearr = $SankalpaPujaPriceModel->outoftowner();
        $this->tpl['ootpricearr'] = $ootpricearr;


        if (!empty($_POST['create_registration'])) {
            $MemberId = $_POST['Member_id'] ?? '';
            $Gotra = $_POST['gotra'] ?? '';
            if ($MemberId != "" && $Gotra != "") {
                $MemberModel->UpdateGotra($MemberId, $Gotra);
            }
            $this->removeHaateKhoriPranami($_POST);
            $namemember = $_POST['ootdata'] ?? '';
            if (($namemember != "" || $namemember != null) && !empty($_FILES['image']['name']) && ($_POST['freepujasankalpa'] ?? '') != "Donation") {
                $data = array();
                if (!empty($_FILES['image'])) {
                    $fileextension = $_FILES['image']['type'];
                    $newfileextension = explode("/", $fileextension);
                    $filetype = strtolower($newfileextension[1]);
                    if ($filetype == "pdf") {
                        require_once APP_PATH . 'helpers/uploader/class.upload.php';
                        $targetfolder = INSTALL_PATH . UPLOAD_PATH . 'avatar/thumb/';
                        $imgdata = $_FILES['image']['name'];
                        $newimgdata = explode(".", $imgdata);
                        $img_name = time();
                        $finaldocumentname = $img_name . '.' . $newimgdata[1];
                        $targetfolder = $targetfolder . basename($finaldocumentname);

                        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetfolder)) {
                            $data['avatar'] = $finaldocumentname;
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
                            $data['avatar'] = $handle->file_dst_name;
                        }
                    }

                }


                $pujaselect = $_POST['selectedpuja'] ?? '';
                if ($pujaselect == 'hathekhori') {
                    $pujaname = "Haate Khori";
                    $_POST['item_name'] = "Hathe Khori";
                } else {
                    $pujaname = $_POST['allpujaname'][0];
                    $_POST['item_name'] = $_POST['allpujaname'] ?? '';
                }
                date_default_timezone_set("America/Chicago");
                $today = date("Y/m/d");
                $_POST['pay_date'] = $today;
                $_POST['name'] = ($_POST['First_name'] ?? '') . " " . ($_POST['Last_name'] ?? '');
                $_POST['Status'] = 'pending';

                $_POST['child1name'] = $_POST['childname'][0] ?? '';
                $_POST['child2name'] = $_POST['childname'][1] ?? '';
                $_POST['child1age'] = $_POST['childage'][0] ?? '';
                $_POST['child2age'] = $_POST['childage'][1] ?? '';

                $fullnamesponsorpuja = $_POST['fullnamesponsorpuja'] ?? '';
                $dataToInsert = is_array($fullnamesponsorpuja) ? implode(', ', $fullnamesponsorpuja) : (string)$fullnamesponsorpuja;
                $_POST['personofferingpujasankalpa'] =   $dataToInsert;
                $id = $SankalpaPujaModel->save(array_merge($_POST, $data));
                if ($id !== null) {
                    $MemberName = ($_POST['First_name'] ?? '') . ' ' . ($_POST['Last_name'] ?? '');
                    $reg = $_POST['regmember'] ?? '';
                    $amount = $_POST['item_cost'] ?? '';
                    echo "<div style='text-align: -webkit-center;' class = 'pay'>
            <table border='4'  width='585px' style='margin-left:4em;'>
            <tr>
            <td colspan='2'> <img src='../thankyouscreen.jpg' alt='' height='167px' style='margin-left:12em;'><h1 style='text-align:center;font-family:fangsong; font-size:30px;'><b>Houston Durga Bari Society</b></h1> </td>
            <tr><td colspan='2'><span style='font-size: 18px;font-family: serif;'>Your Puja request have been submitted.
            Registration Team will validate your application and send a confirmation for payment.</span></td></tr>
            <tr><td style='width:50%;'>Full Name</td> <td style='width:50%;'>" . $MemberName . "</td> </tr>
            <tr><td>Registered in HDBS System</td> <td>" . $reg . "</td> </tr>
            <tr><td>Puja Name</td> <td>" . $pujaname . "</td> </tr>
            <tr><td>Total Amount</td> <td><span style= 'color:red;'>$</span>" . $amount . "</td> </tr>
            <tr><td>Request Date</td> <td>" . $today . "</td> </tr>
            <tr><td>Payment Status</td> <td>Pending</td>  </tr>
           <tr><td colspan='2'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>   </tr>
           </tr>";
                    echo "</table>";
                    echo "<a  href='" . INSTALL_URL . "PujaSankalpa/PujaSankalpa'>Go to home</a>";
                    echo "</div>";
                    $MemberName = ($_POST['First_name'] ?? '') . ' ' . ($_POST['Last_name'] ?? '');
                    $amount = $_POST['item_cost'] ?? '';

                    $Emailcc = 'pujaregpayment@durgabari.org';
                    $subjetc = 'Puja Request';
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
                      <td style="text-align: center; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;"><strong>Puja Details</strong></td>
                      </tr>
                      </tbody>
                      </table>
                      </div>
                      <div class="email-token-class" style="text-align: center;">
                      <table style="height: 190px; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;" width="604">
                      <tbody>
                      <tr>
                      <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Full Name&nbsp;&nbsp;</td>
                      <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">' . $MemberName . '</td>
                      </tr>
                      <tr>
                      <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Puja Name&nbsp;&nbsp;</td>
                      <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $pujaname . '</td>
                      </tr>
                      <tr>
                      <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Amount &nbsp;</td>
                      <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;"><span style="color:red;">$</span>' . $amount . '</td>
                      </tr>
                      <tr>
                      <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Request Date&nbsp;&nbsp;</td>
                      <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $today . '</td>
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
                        $msg = 'Houston Durga Bari: Full Name: ' . $MemberName . ' , Puja  Request for ' . $pujaname . ' has been submmited. Registration team will validate your request and send a payment confirmation email on your registration email. Total Amount: $' . $amount . ', Status: ' . 'Pending';
                        $this->SendSMS($mobileno, $msg);
                    }
                    exit();
                }
            }else if(($_POST['PaymentOption'] ?? '') == "" && (!empty($_FILES['image']['name'])) && ($_POST['freepujasankalpa'] ?? '') == "Donation"){
                $data = array();
                if (!empty($_FILES['image'])) {
                    $fileextension = $_FILES['image']['type'];
                    $newfileextension = explode("/", $fileextension);
                    $filetype = strtolower($newfileextension[1]);
                    if ($filetype == "pdf") {
                        require_once APP_PATH . 'helpers/uploader/class.upload.php';
                        $targetfolder = INSTALL_PATH . UPLOAD_PATH . 'avatar/thumb/';
                        $imgdata = $_FILES['image']['name'];
                        $newimgdata = explode(".", $imgdata);
                        $img_name = time();
                        $finaldocumentname = $img_name . '.' . $newimgdata[1];
                        $targetfolder = $targetfolder . basename($finaldocumentname);

                        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetfolder)) {
                            $data['avatar'] = $finaldocumentname;
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
                            $data['avatar'] = $handle->file_dst_name;
                        }
                    }

                }
                
                $_POST['name'] = ($_POST['First_name'] ?? '') . " " . ($_POST['Last_name'] ?? '');
                date_default_timezone_set("America/Chicago");
                $today = date("Y/m/d");
                $_POST['pay_date'] = $today;
                $_POST['pay_type'] = 'Registration';
                $_POST['item_name'] = ($_POST['freesankalpapujaname'] ?? '') . " " . "(Free)";
                $_POST['selectedpuja'] = 'sankalpapuja';
                $fullnamesponsorpuja = $_POST['fullnamesponsorpuja'] ?? '';
                $dataToInsert = is_array($fullnamesponsorpuja) ? implode(', ', $fullnamesponsorpuja) : (string)$fullnamesponsorpuja;
                $_POST['personofferingpujasankalpa'] =   $dataToInsert;
               
                $_POST['Status'] = 'pending';
                $id = $SankalpaPujaModel->save(array_merge($_POST, $data));
                if ($id !== null) {
                    $MemberName = ($_POST['First_name'] ?? '') . ' ' . ($_POST['Last_name'] ?? '');
                    echo "<div style='text-align: -webkit-center;' class = 'pay'>
                    <table border='4'  width='585px' style='margin-left:4em;'>
                    <tr>
                    <td colspan='2'> <img src='../thankyouscreen.jpg' alt='' height='167px' style='margin-left:12em;'><h1 style='text-align:center;font-family:fangsong; font-size:30px;'><b>Houston Durga Bari Society</b></h1> </td>
                    <tr><td colspan='2'><span style='font-size: 18px;font-family: serif;'>Your puja request have been submitted.
                    Registration team will validate your application and send a confirmation email.</span></td></tr>
                    <tr><td style='width:50%;'>Full Name</td> <td style='width:50%;'>" . $MemberName . "</td> </tr>
                    <tr><td style='width:50%;'>Member Id</td> <td style='width:50%;'>" . ($_POST['Member_id'] ?? '') . "</td> </tr>
                    <tr><td>Puja Name</td> <td>" . ($_POST['freesankalpapujaname'] ?? '') . " " . '(Free)'. "</td> </tr>
                    <tr><td>Request Date</td> <td>" . $today . "</td> </tr>
                    <tr><td>Status</td> <td>Pending</td>  </tr>
                    <tr><td colspan='2'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>   </tr>
                    </tr>";
                    echo "</table>";
                    echo "<a  href='" . INSTALL_URL . "PujaDonations/pujadonation'>Go to home</a>";
                    echo "</div>";
                    
                    $MemberName = ($_POST['First_name'] ?? '') . ' ' . ($_POST['Last_name'] ?? '');
                    $member_id = $_POST['Member_id'] ?? '';
                    $pujaname = ($_POST['freesankalpapujaname'] ?? '') . " " . '(Free)';
                    
                    $Emailcc = 'pujaregpayment@durgabari.org';
                    $subjetc = 'Puja Request';
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
                        <td style="text-align: center; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;"><strong>Puja Details</strong></td>
                        </tr>
                        </tbody>
                        </table>
                        </div>
                        <div class="email-token-class" style="text-align: center;">
                        <table style="height: 190px; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;" width="604">
                        <tbody>
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Full Name&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">' . $MemberName . '</td>
                        </tr>
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Member Id &nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $member_id . '</td>
                        </tr>
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Puja Name&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $pujaname . '</td>
                        </tr>
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Request Date&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $today . '</td>
                        </tr>
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Status&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Pending</td>
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
                        $msg = 'Houston Durga Bari:Member Id: ' . $member_id . ' , Full Name: ' . $MemberName . ' , Puja  Request for ' . $pujaname . ' on ' . $today . ' has been submmited. Registration team will validate your request and send a confirmation email on your registration email.';
                        $this->SendSMS($mobileno, $msg);
                    }                    exit();
            }
            }else if(($_POST['PaymentOption'] ?? '') == "" && empty($_FILES['image']['name'])){
                $_POST['name'] = ($_POST['First_name'] ?? '') . " " . ($_POST['Last_name'] ?? '');
                date_default_timezone_set("America/Chicago");
                $today = date("Y/m/d");
                $_POST['pay_date'] = $today;
                $_POST['pay_type'] = 'Registration';
                $_POST['item_name'] = ($_POST['freesankalpapujaname'] ?? '') . " " . "(Free)";
                $_POST['selectedpuja'] = 'sankalpapuja';
                $fullnamesponsorpuja = $_POST['fullnamesponsorpuja'] ?? '';
                $dataToInsert = is_array($fullnamesponsorpuja) ? implode(', ', $fullnamesponsorpuja) : (string)$fullnamesponsorpuja;
                $_POST['personofferingpujasankalpa'] =   $dataToInsert;
               
                $_POST['Status'] = 'confirmed';
                $id = $SankalpaPujaModel->save(array_merge($_POST));
                if ($id !== null) {
                    $MemberName = ($_POST['First_name'] ?? '') . ' ' . ($_POST['Last_name'] ?? '');
                    echo "<div style='text-align: -webkit-center;' class = 'pay'>
                    <table border='4'  width='585px' style='margin-left:4em;'>
                    <tr>
                    <td colspan='2'> <img src='../thankyouscreen.jpg' alt='' height='167px' style='margin-left:12em;'><h1 style='text-align:center;font-family:fangsong; font-size:30px;'><b>Houston Durga Bari Society</b></h1> </td>
                    <tr><td style='width:50%;'>Full Name</td> <td style='width:50%;'>" . $MemberName . "</td> </tr>
                    <tr><td style='width:50%;'>Member Id</td> <td style='width:50%;'>" . ($_POST['Member_id'] ?? '') . "</td> </tr>
                    <tr><td>Puja Name</td> <td>" . ($_POST['freesankalpapujaname'] ?? '') . " " . '(Free)'. "</td> </tr>
                    <tr><td>Request Date</td> <td>" . $today . "</td> </tr>
                    <tr><td>Status</td> <td>Confirmed</td>  </tr>
                    <tr><td colspan='2'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>   </tr>
                    </tr>";
                    echo "</table>";
                    echo "<a  href='" . INSTALL_URL . "PujaDonations/pujadonation'>Go to home</a>";
                    echo "</div>";
                    $MemberName = ($_POST['First_name'] ?? '') . ' ' . ($_POST['Last_name'] ?? '');
                    $member_id = $_POST['Member_id'] ?? '';
                    $pujaname = ($_POST['freesankalpapujaname'] ?? '') . " " . '(Free)';
                   
                    $Emailcc = 'pujaregpayment@durgabari.org';
                    $subjetc = 'Puja Request';
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
                        <td style="text-align: center; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;"><strong>Puja Details</strong></td>
                        </tr>
                        </tbody>
                        </table>
                        </div>
                        <div class="email-token-class" style="text-align: center;">
                        <table style="height: 190px; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;" width="604">
                        <tbody>
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Full Name&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">' . $MemberName . '</td>
                        </tr>
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Member Id &nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $member_id . '</td>
                        </tr>
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Puja Name&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $pujaname . '</td>
                        </tr>
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Request Date&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $today . '</td>
                        </tr>
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Status&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Confirmed</td>
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
                        $msg = 'Houston Durga Bari: Your Puja Registration request have been submitted. Member Id: ' . $member_id . ', Full Name: ' . $MemberName . ' , Puja Name: ' . $pujaname . ', Request Date: ' . $today . ', Status: ' . 'Confirmed';
                        $this->SendSMS($mobileno, $msg);
                    }
                }
            }
            else {
                //echo '<script>alert("member else case")</script>';
                $_POST['name'] = ($_POST['First_name'] ?? '') . " " . ($_POST['Last_name'] ?? '');
                // $_POST['item_name'] =   $_POST['allpujaname'] ?? '';
                date_default_timezone_set("America/Chicago");
                $today = date("Y/m/d");
                $_POST['pay_date'] = $today;
                $_POST['pay_type'] = 'Registration';
                //$_POST['pay_for'] = $_POST['allpujaname'] ?? '';

                // for generate oid 
                $maxoid = $idnumbersModel->getMaxoid() + 1;
                $update_oid = $idnumbersModel->Updateoid($maxoid);
                $_POST['oid'] = $maxoid;
                // end generate oid for
                // check member is email or phone exist or not
                $datamember = $MemberModel->checkmemberregisterornot();
                if ($datamember == null) {

                    // for generate memberid for gd
                    $maxid = $idnumbersModel->getMaxmid() + 1;
                    $update_mid = $idnumbersModel->Updatemid($maxid);
                    $_POST['Member_id'] = $maxid;
                    // end generate memberid for gd 
                }
                if ($datamember != null) {
                    $_POST['Member_id'] = $datamember;
                    // for update telephone no member case
                     $existingdata = $MemberModel->checktele2($datamember);
                    $alternatemobile = $existingdata[0]['Tele2'];
                 if($alternatemobile == null || $alternatemobile != $_POST['alternatenumber'] ?? '' ){
                    $mobileno =  $_POST['alternatenumber'] ?? '';
                    $MemberModel->updatetelephone($datamember, $mobileno);
                }

                $primaryphone =$existingdata[0]['Tele1'];
                if($primaryphone == null){
                    $phone =  $_POST['tele'] ?? '';
                    $MemberModel->updateprimaryno($datamember, $phone);
                }
                
                $email =$existingdata[0]['email'];
                if($email == null){
                    $email =  $_POST['email'] ?? '';
                    $MemberModel->updateemail($datamember, $email);
                }

                $alternateemail = $existingdata[0]['Email2'];
                if($alternateemail == null){
                    $alternatemail =  $_POST['alternateemail'] ?? '';
                    if( $alternatemail != ""){
                        $MemberModel->updupdatealternateemail($datamember, $alternateemail);
                    }
                    
                } 

                }
                // End check member is email or phone exist or not

                $pujaselect = $_POST['selectedpuja'] ?? '';
                if ($pujaselect == 'hathekhori') {
                    $pujaname = "Haate Khori";
                    $_POST['item_name'] = "Hathe Khori";
                    $_POST['pay_for'] = "Hathe Khori";
                    $this->removeHaateKhoriPranami($_POST);
                } else {
                    $pujaname = $allPujasString;
                    $_POST['item_name'] = $_POST['allpujaname'] ?? '';
                    $_POST['pay_for'] = $_POST['allpujaname'] ?? '';
                }
                $this->removeHaateKhoriPranami($_POST);
                $_POST['child1name'] = $_POST['childname'][0] ?? '';
                $_POST['child2name'] = $_POST['childname'][1] ?? '';
                $_POST['child1age'] = $_POST['childage'][0] ?? '';
                $_POST['child2age'] = $_POST['childage'][1] ?? '';
                $fullnamesponsorpuja = $_POST['fullnamesponsorpuja'] ?? '';
                $dataToInsert = is_array($fullnamesponsorpuja) ? implode(', ', $fullnamesponsorpuja) : (string)$fullnamesponsorpuja;
                $_POST['personofferingpujasankalpa'] =   $dataToInsert;
                //   for check admin role 
                if ($this->isAdmin() || $this->isEditor()) {
                    $id = $this->getUserId();
                    $admin = $UserModel->get($id);
                    $rolename = $admin['first'] . ' ' . $admin['last'];
                    $_POST['admin_id'] = $admin['id'];
                    $_POST['admin_name'] = $rolename;

                }
                  
                //for complimentary registration make amount null 
                if (($_POST['PaymentOption'] ?? '') == 'ComplimentaryRegistration') {
                    $_POST['item_cost'] = "0";
                    $_POST['pranamifee'] = "";
                }

                $id = $SankalpaPujaModel->save(array_merge($_POST));
                if (!empty($id)) {

                 //for confirmation email
                    $orderid = $_POST['oid'] ?? '';
                    $Memberid = $_POST['Member_id'] ?? '';
                    $membername = ($_POST['First_name'] ?? '') . ' ' . ($_POST['Last_name'] ?? '');
                    $pujaselect = $_POST['selectedpuja'] ?? '';
                    if ($pujaselect == 'hathekhori') {
                        $pujaname = "Haate Khori";
                    } else {
                        $pujaname = $_POST['allpujaname'][0];
                    }
                    $participationmode = $_POST['modeparticipation'] ?? '';

                    $totalamount = $_POST['item_cost'] ?? '';

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

                    $paymentdate = strtotime($_POST['pay_date'] ?? '');
                    $paydateemail = date("m/d/Y", $paymentdate);

                    $Emailcc = 'pujaregpayment@durgabari.org';
                    $subjetc = 'Puja Registration Confirmation';
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
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Order Id&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">' . $orderid . '</td>
                        </tr>
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Member Id&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">' . $Memberid . '</td>
                        </tr> 
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Full Name&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">' . $membername . '</td>
                        </tr>
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Puja Name&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $pujaname . '</td>
                        </tr>
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Participation Mode &nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $participationmode . '</td>
                        </tr>
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Total Amount&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;"><span style="color:red;">$</span>' . $totalamount . '</td>
                        </tr>
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Payment Method&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">' . $payui . '</td>
                        </tr>
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Pay Date&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">' . $paydateemail . '</td>
                        </tr> 
                        </tbody>
                        </table>
                        </div>
                        </div>
                        </div>';
                    $textmsg = 'Houston Durga Bari: Puja Registration confirmation are Order Id: ' . $orderid . ', Member Id: ' . $Memberid . ', Full Name: ' . $membername . ', Puja Name: ' . $pujaname . ', Participation Mode: ' . $participationmode . ', Total Amount: $' . $totalamount . ', Payment Method: ' . $payui . ', Pay Date: ' . $paydateemail;

                    if (($_POST['PaymentOption'] ?? '') == 'others') {

                        $opts = array();
                        $oid = $_POST['oid'] ?? '';
                        $cmCode = $_POST['code'] ?? '';
                        $arr = $ConfirmCodeModel->UpdateCode($cmCode);
                        $_POST['transaction_id'] = $cmCode;
                        $opts['Confirmation'] = $_POST['confirm_code'] ?? '';
                        $arr = $ConfirmCodeModel->getAll($opts);
                        if ($oid != null) {
                            //if (!empty($arr[0])) {
                            $opts = array();
                            $opts['id'] = $id;
                            $opts['payment_status'] = 'confirmed';
                            $_POST['Status'] = 'confirmed';
                            $data = $_POST;
                            $datamemberarr = array();
                            $datamemberarr = array_merge($opts, $_POST);
                            $SankalpaPujaModel->update(array_merge($opts, $_POST));
                            $value = array();
                            $value['oid'] = $datamemberarr['oid'];
                            $value['Member_id'] = $datamemberarr['Member_id'];
                            $value['MemberName'] = $datamemberarr['name'];
                            $value['PaymentOption'] = $datamemberarr['PaymentOption'];
                            $value['payment_status'] = 'succeeded';
                            $value['payment_timestamp'] = $datamemberarr['payment_timestamp'] ?? '';
                            $value['Amount'] = $datamemberarr['item_cost'];
                            $value['stripe_return'] = $datamemberarr['stripe_return'] ?? '';
                            $value['transaction_id'] = $datamemberarr['transaction_id'];
                            $value['paid_amount'] = $datamemberarr['paid_amount'] ?? '';
                            $value['update_on'] = $datamemberarr['UpdateOn'] ?? '';
                            $value['stripe_product'] = $datamemberarr['stripe_product'] ?? '';
                            $value['pay_date'] = $datamemberarr['pay_date'];
                            $value['pay_type'] = 'Puja Registration';
                            $value['pay_for'] = $datamemberarr['pay_for'];
                            $value['Tele1'] = $datamemberarr['tele'];
                             $value['Tele2'] = $datamemberarr['alternatenumber'];
                            $value['email'] = $datamemberarr['email'];
                            $value['spousename'] = $datamemberarr['spousename'];
                            $value['Address'] = $datamemberarr['streetname'];
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
                                $value['Tele2'] = $_POST['alternatenumber'] ?? '';
                                $value['email'] = $_POST['email'] ?? '';
                                $value['City'] = $_POST['city'] ?? '';
                                $value['State'] = $_POST['state'] ?? '';
                                $value['Zip_Code'] = $_POST['zip'] ?? '';
                                $value['Amount'] = $_POST['item_cost'] ?? '';
                                $value['pay_type'] = 'Puja Registration';
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
                                $value['type'] = $_POST['type'] ?? '';
                                $value['Street'] = $_POST['street'] ?? '';
                                $value['Address'] = $_POST['streetname'] ?? '';
                                $value['Address3'] = $_POST['unit'] ?? '';
                                $value['spousename'] = $_POST['spousename'] ?? '';
                                $value['Child1'] = $_POST['Child1'] ?? '';
                                $value['Age1'] = $_POST['Age1'] ?? '';
                                $value['Child2'] = $_POST['Child2'] ?? '';
                                $value['Age2'] = $_POST['Age2'] ?? '';
                                $value['Child3'] = $_POST['Child3'] ?? '';
                                $value['Age3'] = $_POST['Age3'] ?? '';
                                $MemberModel->SaveDataInmember($value);
                            }
                            $MemberName = $_POST['name'] ?? '';
                            $Amount = $_POST['item_cost'] ?? '';
                            if ($pujaselect == 'hathekhori') {
                                $pujaname = "Haate Khori";
                            } else {
                                $pujaname = $_POST['allpujaname'][0];
                            }
                            $memberid = $_POST['Member_id'] ?? '';
                            $payment_status = $opts['payment_status'];
                            $paymentoption = $_POST['PaymentOption'] ?? '';
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
                      <tr><td>Amount</td> <td><span style='color:red;'>$</span>" . $Amount . "</td> </tr>
                       <tr><td>Puja Name</td> <td>" . $pujaname . "</td>  </tr>
                      <tr><td>Payment Status</td> <td>" . $payment_status . "</td>  </tr>
                      <tr><td>Pay Date</td> <td>" . $payfinaldate . "</td>  </tr>
                      <tr><td colspan='2' style='font-weight: bold;color:red;'>An email with your payment information has been sent to your registered email address. Please check your spam folder if you cannot find the email in your inbox</td></tr>
                      <tr><td colspan='2'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>   </tr>
                      </tr>";

                            echo "</table>";
                            if (!$this->isAdmin() && !$this->isEditor()) {
                                echo "<a  href='" . INSTALL_URL . "PujaSankalpa/PujaSankalpa'>Go to home</a>";

                            }
                            if ($this->isAdmin() || $this->isEditor()) {
                                echo " <a href='" . INSTALL_URL . "Pujaregistration/index'>Go to home</a>";

                            }
                            echo "</div>";
                            $email = $_POST['email'] ?? '';
                            if ($email != null) {
                                $this->sendEmailticket($message, $subjetc, $email, $Emailcc);
                            }
                            $mobileno = $_POST['alternatenumber'] ?? '';
                            if ($mobileno != null) {
                                 $this->SendSMS($mobileno, $textmsg );
                            }
                            exit();
                        }
                        // for check option
                    } 
                    // for check option
                    elseif (($_POST['PaymentOption'] ?? '') == 'check') {

                        $_POST['item_cost'] = $_POST['checkAmount'] ?? '';
                        $_POST['bank'] = $_POST['checkbankname'] ?? '';
                        $_POST['chkdate'] = $_POST['CheckDate'] ?? '';
                        //$_POST['pay_date'] = $_POST['CheckDate'] ?? '';
                        $_POST['DepositAccount'] = $_POST['CheckDepositAccount'] ?? '';
                        $_POST['Status'] = 'confirmed';
                        $_POST['id'] = $id;
                        $data = $_POST;
                        $datamemberarr = array();
                        $datamemberarr = array_merge($_POST);
                        $SankalpaPujaModel->update(array_merge($_POST));
                        $value = array();
                        $value['oid'] = $datamemberarr['oid'];
                        $value['Member_id'] = $datamemberarr['Member_id'];
                        $value['MemberName'] = $datamemberarr['name'];
                        $value['PaymentOption'] = $datamemberarr['PaymentOption'];
                        $value['payment_status'] = 'succeeded';
                        $value['payment_timestamp'] = $datamemberarr['payment_timestamp'] ?? '';
                        $value['Amount'] = $datamemberarr['item_cost'];
                        $value['stripe_return'] = $datamemberarr['stripe_return'] ?? '';
                        $value['transaction_id'] = $datamemberarr['transaction_id'];
                        $value['paid_amount'] = $datamemberarr['paid_amount'] ?? '';
                        $value['update_on'] = $datamemberarr['UpdateOn'] ?? '';
                        $value['stripe_product'] = $datamemberarr['stripe_product'] ?? '';
                        $value['pay_date'] = $datamemberarr['pay_date'];
                        $value['pay_type'] = 'Puja Registration';
                        $value['pay_for'] = $datamemberarr['pay_for'];
                        $value['Tele1'] = $datamemberarr['tele'];
                        $value['Tele2'] = $datamemberarr['alternatenumber'];
                        $value['email'] = $datamemberarr['email'];
                        $value['spousename'] = $datamemberarr['spousename'];
                        $value['Address'] = $datamemberarr['streetname'];
                        $value['Street'] = $datamemberarr['street'];
                        $value['City'] = $datamemberarr['city'];
                        $value['State'] = $datamemberarr['state'];
                        $value['Zip_Code'] = $datamemberarr['zip'];
                        $value['bank'] = $_POST['bank'] ?? '';
                        $value['chkno'] = $_POST['chkno'] ?? '';
                        $value['chkdate'] = $_POST['chkdate'] ?? '';
                        $value['ReceiveBy'] = $_POST['receiveby'] ?? '';
                        $value['admin_id'] = $datamemberarr['admin_id'];
                        $value['admin_name'] = $datamemberarr['admin_name'];
                        $value['DepositAccount'] = $datamemberarr['DepositAccount'];
                        $DonationModel->SaveDataInDonation($value);
                        if ($datamember == null) {
                            $value = array();
                            $value['oid'] = $_POST['oid'] ?? '';
                            $value['MemberName'] = $_POST['name'] ?? '';
                            $value['Tele1'] = $_POST['tele'] ?? '';
                            $value['Tele2'] = $_POST['alternatenumber'] ?? '';
                            $value['email'] = $_POST['email'] ?? '';
                            $value['City'] = $_POST['city'] ?? '';
                            $value['State'] = $_POST['state'] ?? '';
                            $value['Zip_Code'] = $_POST['zip'] ?? '';
                            $value['Amount'] = $_POST['item_cost'] ?? '';
                            $value['pay_type'] = 'Puja Registration';
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
                            $value['type'] = $_POST['type'] ?? '';
                            $value['Street'] = $_POST['street'] ?? '';
                            $value['Address'] = $_POST['streetname'] ?? '';
                            $value['Address3'] = $_POST['unit'] ?? '';
                            $value['spousename'] = $_POST['spousename'] ?? '';
                            $value['Child1'] = $_POST['Child1'] ?? '';
                            $value['Age1'] = $_POST['Age1'] ?? '';
                            $value['Child2'] = $_POST['Child2'] ?? '';
                            $value['Age2'] = $_POST['Age2'] ?? '';
                            $value['Child3'] = $_POST['Child3'] ?? '';
                            $value['Age3'] = $_POST['Age3'] ?? '';
                            $MemberModel->SaveDataInmember($value);
                        }
                        $MemberName = $_POST['name'] ?? '';
                        $Amount = $_POST['item_cost'] ?? '';
                        if ($pujaselect == 'hathekhori') {
                            $pujaname = "Haate Khori";
                        } else {
                            $pujaname = $_POST['allpujaname'][0];
                        }
                        $memberid = $_POST['Member_id'] ?? '';
                        $oid = $_POST['oid'] ?? '';
                        $paymentoption = $_POST['PaymentOption'] ?? '';
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
                 <tr><td>Amount</td> <td><span style='color:red;'>$</span>" . $Amount . "</td> </tr>
                  <tr><td>Puja Name</td> <td>" . $pujaname . "</td>  </tr>
                 <tr><td>Payment Status</td> <td>Confirmed</td>  </tr>
                 <tr><td>Pay Date</td> <td>" . $payfinaldate . "</td>  </tr>
                 <tr><td colspan='2' style='font-weight: bold;color:red;'>An email with your payment information has been sent to your registered email address. Please check your spam folder if you cannot find the email in your inbox</td></tr>
                 <tr><td colspan='2'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>   </tr>
                 </tr>";

                        echo "</table>";
                        if (!$this->isAdmin() && !$this->isEditor()) {
                            echo "<a  href='" . INSTALL_URL . "PujaSankalpa/PujaSankalpa'>Go to home</a>";

                        }
                        if ($this->isAdmin() || $this->isEditor()) {
                            echo " <a href='" . INSTALL_URL . "Pujaregistration/index'>Go to home</a>";

                        }
                        echo "</div>";
                        $email = $_POST['email'] ?? '';
                            if ($email != null) {
                                $this->sendEmailticket($message, $subjetc, $email, $Emailcc);
                            }
                            $mobileno = $_POST['alternatenumber'] ?? '';
                            if ($mobileno != null) {
                                 $this->SendSMS($mobileno, $textmsg );
                            }
                        exit();
                    }
                    // for cash option
                    elseif (($_POST['PaymentOption'] ?? '') == 'cash') {
                        $_POST['item_cost'] = $_POST['cashAmount'] ?? '';
                        $_POST['pay_date'] = $_POST['cashDate'] ?? '';
                        $_POST['DepositAccount'] = $_POST['CashDepositAccount'] ?? '';
                        $_POST['Status'] = 'confirmed';
                        $_POST['id'] = $id;
                        $data = $_POST;
                        $datamemberarr = array();
                        $datamemberarr = array_merge($_POST);
                        $SankalpaPujaModel->update(array_merge($_POST));
                        $value = array();
                        $value['oid'] = $datamemberarr['oid'];
                        $value['Member_id'] = $datamemberarr['Member_id'];
                        $value['MemberName'] = $datamemberarr['name'];
                        $value['PaymentOption'] = $datamemberarr['PaymentOption'];
                        $value['payment_status'] = 'succeeded';
                        $value['payment_timestamp'] = $datamemberarr['payment_timestamp'] ?? '';
                        $value['Amount'] = $datamemberarr['item_cost'];
                        $value['stripe_return'] = $datamemberarr['stripe_return'] ?? '';
                        $value['transaction_id'] = $datamemberarr['transaction_id'];
                        $value['paid_amount'] = $datamemberarr['paid_amount'] ?? '';
                        $value['update_on'] = $datamemberarr['UpdateOn'] ?? '';
                        $value['stripe_product'] = $datamemberarr['stripe_product'] ?? '';
                        $value['pay_date'] = $datamemberarr['pay_date'];
                        $value['pay_type'] = 'Puja Registration';
                        $value['pay_for'] = $datamemberarr['pay_for'];
                        $value['Tele1'] = $datamemberarr['tele'];
                        $value['Tele2'] = $datamemberarr['alternatenumber'];
                        $value['email'] = $datamemberarr['email'];
                        $value['spousename'] = $datamemberarr['spousename'];
                        $value['Address'] = $datamemberarr['streetname'];
                        $value['Street'] = $datamemberarr['street'];
                        $value['City'] = $datamemberarr['city'];
                        $value['State'] = $datamemberarr['state'];
                        $value['Zip_Code'] = $datamemberarr['zip'];
                        $value['bank'] = $_POST['bank'] ?? '';
                        $value['chkno'] = $_POST['chkno'] ?? '';
                        $value['chkdate'] = $_POST['chkdate'] ?? '';
                        $value['ReceiveBy'] = $_POST['receiveby'] ?? '';
                        $value['DepositAccount'] = $datamemberarr['DepositAccount'];
                        $value['admin_id'] = $datamemberarr['admin_id'];
                        $value['admin_name'] = $datamemberarr['admin_name'];
                        $DonationModel->SaveDataInDonation($value);
                        if ($datamember == null) {
                            $value = array();
                            $value['oid'] = $_POST['oid'] ?? '';
                            $value['MemberName'] = $_POST['name'] ?? '';
                            $value['Tele1'] = $_POST['tele'] ?? '';
                            $value['Tele2'] = $_POST['alternatenumber'] ?? '';
                            $value['email'] = $_POST['email'] ?? '';
                            $value['City'] = $_POST['city'] ?? '';
                            $value['State'] = $_POST['state'] ?? '';
                            $value['Zip_Code'] = $_POST['zip'] ?? '';
                            $value['Amount'] = $_POST['item_cost'] ?? '';
                            $value['pay_type'] = 'Puja Registration';
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
                            $value['type'] = $_POST['type'] ?? '';
                            $value['Street'] = $_POST['street'] ?? '';
                            $value['Address'] = $_POST['streetname'] ?? '';
                            $value['Address3'] = $_POST['unit'] ?? '';
                            $value['spousename'] = $_POST['spousename'] ?? '';
                            $value['Child1'] = $_POST['Child1'] ?? '';
                            $value['Age1'] = $_POST['Age1'] ?? '';
                            $value['Child2'] = $_POST['Child2'] ?? '';
                            $value['Age2'] = $_POST['Age2'] ?? '';
                            $value['Child3'] = $_POST['Child3'] ?? '';
                            $value['Age3'] = $_POST['Age3'] ?? '';
                            $MemberModel->SaveDataInmember($value);
                        }
                        $MemberName = $_POST['name'] ?? '';
                        $Amount = $_POST['item_cost'] ?? '';
                        if ($pujaselect == 'hathekhori') {
                            $pujaname = "Haate Khori";
                        } else {
                            $pujaname = $_POST['allpujaname'][0];
                        }
                        $memberid = $_POST['Member_id'] ?? '';
                        $oid = $_POST['oid'] ?? '';
                        $paymentoption = $_POST['PaymentOption'] ?? '';
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
                 <tr><td>Amount</td> <td><span style='color:red;'>$</span>" . $Amount . "</td> </tr>
                  <tr><td>Puja Name</td> <td>" . $pujaname . "</td>  </tr>
                 <tr><td>Payment Status</td> <td>Confirmed</td>  </tr>
                 <tr><td>Pay Date</td> <td>" . $payfinaldate . "</td>  </tr>
                 <tr><td colspan='2' style='font-weight: bold;color:red;'>An email with your payment information has been sent to your registered email address. Please check your spam folder if you cannot find the email in your inbox</td></tr>
                 <tr><td colspan='2'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>   </tr>
                 </tr>";

                        echo "</table>";
                        if (!$this->isAdmin() && !$this->isEditor()) {
                            echo "<a  href='" . INSTALL_URL . "PujaSankalpa/PujaSankalpa'>Go to home</a>";

                        }
                        if ($this->isAdmin() || $this->isEditor()) {
                              echo " <a href='" . INSTALL_URL . "Pujaregistration/index'>Go to home</a>"; 
                            //echo " <a href='http://localhost:8082/7june/Pujaregistration/index'>Go to home</a>";
                        }
                        echo "</div>";
                        $email = $_POST['email'] ?? '';
                            if ($email != null) {
                                $this->sendEmailticket($message, $subjetc, $email, $Emailcc);
                            }
                            $mobileno = $_POST['alternatenumber'] ?? '';
                            if ($mobileno != null) {
                                 $this->SendSMS($mobileno, $textmsg );
                            }
                        exit();

                    }
                    // for directdeposite option
                    elseif (($_POST['PaymentOption'] ?? '') == 'directdeposit') {
                        $_POST['bank'] = $_POST['directbank'] ?? '';
                        $_POST['transaction_id'] = $_POST['transactioncode'] ?? '';
                        $_POST['item_cost'] = $_POST['directdepositeamount'] ?? '';
                        $_POST['pay_date'] = $_POST['transactiondate'] ?? '';
                        $_POST['DepositAccount'] = $_POST['DirectPayDepositAccount'] ?? '';
                        $_POST['Status'] = 'confirmed';
                        $_POST['id'] = $id;
                        $data = $_POST;
                        $datamemberarr = array();
                        $datamemberarr = array_merge($_POST);
                        $SankalpaPujaModel->update(array_merge($_POST));
                        $value = array();
                        $value['oid'] = $datamemberarr['oid'];
                        $value['Member_id'] = $datamemberarr['Member_id'];
                        $value['MemberName'] = $datamemberarr['name'];
                        $value['PaymentOption'] = $datamemberarr['PaymentOption'];
                        $value['payment_status'] = 'succeeded';
                        $value['payment_timestamp'] = $datamemberarr['payment_timestamp'] ?? '';
                        $value['Amount'] = $datamemberarr['item_cost'];
                        $value['stripe_return'] = $datamemberarr['stripe_return'] ?? '';
                        $value['transaction_id'] = $datamemberarr['transaction_id'];
                        $value['paid_amount'] = $datamemberarr['paid_amount'] ?? '';
                        $value['update_on'] = $datamemberarr['UpdateOn'] ?? '';
                        $value['stripe_product'] = $datamemberarr['stripe_product'] ?? '';
                        $value['pay_date'] = $datamemberarr['pay_date'];
                        $value['pay_type'] = 'Puja Registration';
                        $value['pay_for'] = $datamemberarr['pay_for'];
                        $value['Tele1'] = $datamemberarr['tele'];
                        $value['Tele2'] = $datamemberarr['alternatenumber'];
                        $value['email'] = $datamemberarr['email'];
                        $value['spousename'] = $datamemberarr['spousename'];
                        $value['Address'] = $datamemberarr['streetname'];
                        $value['Street'] = $datamemberarr['street'];
                        $value['City'] = $datamemberarr['city'];
                        $value['State'] = $datamemberarr['state'];
                        $value['Zip_Code'] = $datamemberarr['zip'];
                        $value['bank'] = $_POST['bank'] ?? '';
                        $value['chkno'] = $_POST['chkno'] ?? '';
                        $value['chkdate'] = $_POST['chkdate'] ?? '';
                        $value['ReceiveBy'] = $_POST['receiveby'] ?? '';
                        $value['DepositAccount'] = $datamemberarr['DepositAccount'];
                        $value['admin_id'] = $datamemberarr['admin_id'];
                        $value['admin_name'] = $datamemberarr['admin_name'];
                        $DonationModel->SaveDataInDonation($value);
                        if ($datamember == null) {
                            $value = array();
                            $value['oid'] = $_POST['oid'] ?? '';
                            $value['MemberName'] = $_POST['name'] ?? '';
                            $value['Tele1'] = $_POST['tele'] ?? '';
                            $value['Tele2'] = $_POST['alternatenumber'] ?? '';
                            $value['email'] = $_POST['email'] ?? '';
                            $value['City'] = $_POST['city'] ?? '';
                            $value['State'] = $_POST['state'] ?? '';
                            $value['Zip_Code'] = $_POST['zip'] ?? '';
                            $value['Amount'] = $_POST['item_cost'] ?? '';
                            $value['pay_type'] = 'Puja Registration';
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
                            $value['type'] = $_POST['type'] ?? '';
                            $value['Street'] = $_POST['street'] ?? '';
                            $value['Address'] = $_POST['streetname'] ?? '';
                            $value['Address3'] = $_POST['unit'] ?? '';
                            $value['spousename'] = $_POST['spousename'] ?? '';
                            $value['Child1'] = $_POST['Child1'] ?? '';
                            $value['Age1'] = $_POST['Age1'] ?? '';
                            $value['Child2'] = $_POST['Child2'] ?? '';
                            $value['Age2'] = $_POST['Age2'] ?? '';
                            $value['Child3'] = $_POST['Child3'] ?? '';
                            $value['Age3'] = $_POST['Age3'] ?? '';
                            $MemberModel->SaveDataInmember($value);
                        }
                        $MemberName = $_POST['name'] ?? '';
                        $Amount = $_POST['item_cost'] ?? '';
                        if ($pujaselect == 'hathekhori') {
                            $pujaname = "Haate Khori";
                        } else {
                            $pujaname = $_POST['allpujaname'][0];
                        }
                        $memberid = $_POST['Member_id'] ?? '';
                        $oid = $_POST['oid'] ?? '';
                        $paymentoption = $_POST['PaymentOption'] ?? '';
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
                 <tr><td>Amount</td> <td><span style='color:red;'>$</span>" . $Amount . "</td> </tr>
                  <tr><td>Puja Name</td> <td>" . $pujaname . "</td>  </tr>
                 <tr><td>Payment Status</td> <td>Confirmed</td>  </tr>
                 <tr><td>Pay Date</td> <td>" . $payfinaldate . "</td>  </tr>
                 <tr><td colspan='2' style='font-weight: bold;color:red;'>An email with your payment information has been sent to your registered email address. Please check your spam folder if you cannot find the email in your inbox</td></tr>
                 <tr><td colspan='2'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>   </tr>
                 </tr>";

                        echo "</table>";
                        if (!$this->isAdmin() && !$this->isEditor()) {
                            echo "<a  href='" . INSTALL_URL . "PujaSankalpa/PujaSankalpa'>Go to home</a>";

                        }
                        if ($this->isAdmin() || $this->isEditor()) {
                            echo " <a href='" . INSTALL_URL . "Pujaregistration/index'>Go to home</a>";

                        }
                        echo "</div>";
                        $email = $_POST['email'] ?? '';
                            if ($email != null) {
                                $this->sendEmailticket($message, $subjetc, $email, $Emailcc);
                            }
                            $mobileno = $_POST['alternatenumber'] ?? '';
                            if ($mobileno != null) {
                                 $this->SendSMS($mobileno, $textmsg );
                            }
                        exit();
                    }
                    // for sumup option
                    elseif (($_POST['PaymentOption'] ?? '') == 'sumup') {
                        $_POST['item_cost'] = $_POST['sumupamount'] ?? '';
                        $_POST['transaction_id'] = $_POST['sumupid'] ?? '';
                        $_POST['pay_date'] = $_POST['sumupdate'] ?? '';
                        $_POST['DepositAccount'] = $_POST['SumUpDepositAccount'] ?? '';
                        $_POST['Status'] = 'confirmed';
                        $_POST['id'] = $id;
                        $data = $_POST;
                        $datamemberarr = array();
                        $datamemberarr = array_merge($_POST);
                        $SankalpaPujaModel->update(array_merge($_POST));
                        $value = array();
                        $value['oid'] = $datamemberarr['oid'];
                        $value['Member_id'] = $datamemberarr['Member_id'];
                        $value['MemberName'] = $datamemberarr['name'];
                        $value['PaymentOption'] = $datamemberarr['PaymentOption'];
                        $value['payment_status'] = 'succeeded';
                        $value['payment_timestamp'] = $datamemberarr['payment_timestamp'] ?? '';
                        $value['Amount'] = $datamemberarr['item_cost'];
                        $value['stripe_return'] = $datamemberarr['stripe_return'] ?? '';
                        $value['transaction_id'] = $datamemberarr['transaction_id'];
                        $value['paid_amount'] = $datamemberarr['paid_amount'] ?? '';
                        $value['update_on'] = $datamemberarr['UpdateOn'] ?? '';
                        $value['stripe_product'] = $datamemberarr['stripe_product'] ?? '';
                        $value['pay_date'] = $datamemberarr['pay_date'];
                        $value['pay_type'] = 'Puja Registration';
                        $value['pay_for'] = $datamemberarr['pay_for'];
                        $value['Tele1'] = $datamemberarr['tele'];
                        $value['Tele2'] = $datamemberarr['alternatenumber'];
                        $value['email'] = $datamemberarr['email'];
                        $value['spousename'] = $datamemberarr['spousename'];
                        $value['Address'] = $datamemberarr['streetname'];
                        $value['Street'] = $datamemberarr['street'];
                        $value['City'] = $datamemberarr['city'];
                        $value['State'] = $datamemberarr['state'];
                        $value['Zip_Code'] = $datamemberarr['zip'];
                        $value['bank'] = $_POST['bank'] ?? '';
                        $value['chkno'] = $_POST['chkno'] ?? '';
                        $value['chkdate'] = $_POST['chkdate'] ?? '';
                        $value['ReceiveBy'] = $_POST['receiveby'] ?? '';
                        $value['DepositAccount'] = $datamemberarr['DepositAccount'];
                        $value['admin_id'] = $datamemberarr['admin_id'];
                        $value['admin_name'] = $datamemberarr['admin_name'];
                        $DonationModel->SaveDataInDonation($value);
                        if ($datamember == null) {
                            $value = array();
                            $value['oid'] = $_POST['oid'] ?? '';
                            $value['MemberName'] = $_POST['name'] ?? '';
                            $value['Tele1'] = $_POST['tele'] ?? '';
                            $value['Tele2'] = $_POST['alternatenumber'] ?? '';
                            $value['email'] = $_POST['email'] ?? '';
                            $value['City'] = $_POST['city'] ?? '';
                            $value['State'] = $_POST['state'] ?? '';
                            $value['Zip_Code'] = $_POST['zip'] ?? '';
                            $value['Amount'] = $_POST['item_cost'] ?? '';
                            $value['pay_type'] = 'Puja Registration';
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
                            $value['type'] = $_POST['type'] ?? '';
                            $value['Street'] = $_POST['street'] ?? '';
                            $value['Address'] = $_POST['streetname'] ?? '';
                            $value['Address3'] = $_POST['unit'] ?? '';
                            $value['spousename'] = $_POST['spousename'] ?? '';
                            $value['Child1'] = $_POST['Child1'] ?? '';
                            $value['Age1'] = $_POST['Age1'] ?? '';
                            $value['Child2'] = $_POST['Child2'] ?? '';
                            $value['Age2'] = $_POST['Age2'] ?? '';
                            $value['Child3'] = $_POST['Child3'] ?? '';
                            $value['Age3'] = $_POST['Age3'] ?? '';
                            $MemberModel->SaveDataInmember($value);
                        }
                        $MemberName = $_POST['name'] ?? '';
                        $Amount = $_POST['item_cost'] ?? '';
                        if ($pujaselect == 'hathekhori') {
                            $pujaname = "Haate Khori";
                        } else {
                            $pujaname = $_POST['allpujaname'][0];
                        }
                        $memberid = $_POST['Member_id'] ?? '';
                        $oid = $_POST['oid'] ?? '';
                        $paymentoption = $_POST['PaymentOption'] ?? '';
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
                 <tr><td>Amount</td> <td><span style='color:red;'>$</span>" . $Amount . "</td> </tr>
                  <tr><td>Puja Name</td> <td>" . $pujaname . "</td>  </tr>
                 <tr><td>Payment Status</td> <td>Confirmed</td>  </tr>
                 <tr><td>Pay Date</td> <td>" . $payfinaldate . "</td>  </tr>
                 <tr><td colspan='2' style='font-weight: bold;color:red;'>An email with your payment information has been sent to your registered email address. Please check your spam folder if you cannot find the email in your inbox</td></tr>
                 <tr><td colspan='2'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>   </tr>
                 </tr>";

                        echo "</table>";
                        if (!$this->isAdmin() && !$this->isEditor()) {
                            echo "<a  href='" . INSTALL_URL . "PujaSankalpa/PujaSankalpa'>Go to home</a>";

                        }
                        if ($this->isAdmin() || $this->isEditor()) {
                            echo " <a href='" . INSTALL_URL . "Pujaregistration/index'>Go to home</a>";

                        }
                        echo "</div>";
                        $email = $_POST['email'] ?? '';
                            if ($email != null) {
                                $this->sendEmailticket($message, $subjetc, $email, $Emailcc);
                            }
                            $mobileno = $_POST['alternatenumber'] ?? '';
                            if ($mobileno != null) {
                                 $this->SendSMS($mobileno, $textmsg );
                            }
                        exit();
                    }
                    //Coplimentory Registration
                    elseif (($_POST['PaymentOption'] ?? '') == 'ComplimentaryRegistration') {
                        $opts['payment_status'] = 'confirmed';
                        $_POST['payment_status'] = 'confirmed';
                        $_POST['Status'] = 'confirmed';
                        $_POST['id'] = $id;

                        $SankalpaPujaModel->update(array_merge($_POST));
                        $paymentdate = strtotime($_POST['pay_date'] ?? '');
                        $paydateemail = date("m/d/Y", $paymentdate);
                        $orderid = $_POST['oid'] ?? '';
                        $Memberid = $_POST['Member_id'] ?? '';
                        $membername = ($_POST['First_name'] ?? '') . ' ' . ($_POST['Last_name'] ?? '');
                        $pujaselect = $_POST['selectedpuja'] ?? '';
                        if ($pujaselect == 'hathekhori') {
                            $pujaname = "Haate Khori";
                        } else {
                            $pujaname = $_POST['allpujaname'][0];
                        }
                        $participationmode = $_POST['modeparticipation'] ?? '';
                        $totalamount = $_POST['item_cost'] ?? '';
                        $payui = 'Complimentary Registration';

                        $Emailcc = 'pujaregpayment@durgabari.org';
                        $subjetc = 'Puja Registration Confirmation';
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
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Order Id&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">' . $orderid . '</td>
                        </tr>
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Member Id&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">' . $Memberid . '</td>
                        </tr> 
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Full Name&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">' . $membername . '</td>
                        </tr>
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Puja Name&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $pujaname . '</td>
                        </tr>
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Participation Mode &nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $participationmode . '</td>
                        </tr>
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Payment Method&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">' . $payui . '</td>
                        </tr>
                        <tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Pay Date&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">' . $paydateemail . '</td>
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
                            $textmsg = 'Houston Durga Bari: Puja Registration confirmation are Order Id: ' . $orderid . ', Member Id: ' . $Memberid . ', Full Name: ' . $membername . ', Puja Name: ' . $pujaname . ', Participation Mode: ' . $participationmode . ', Payment Method: ' . $payui . ', Pay Date: ' . $paydateemail;
                             $this->SendSMS($mobileno, $textmsg );
                        }
                        echo "<div style='text-align: -webkit-center;' class = 'pay'>
                         <table border='4' width='585px'>
                         <tr>
                         <td colspan='2'> <img src='../thankyouscreen.jpg' alt='' height='167px' style='margin-left:12em;'><h1 style='text-align:center;font-family:fangsong; font-size:30px;'><b>Houston Durga Bari Society</b></h1> </td>
                         </tr>
                         <tr><td style='width:50%;'>Order Id</td> <td style='width:50%;'>" . $orderid . "</td> </tr>
                         <tr><td>Member Id</td> <td>" . $Memberid . "</td> </tr>
                         <tr><td>Full Name</td> <td>" . $membername . "</td> </tr>
                         <tr><td>Payment Method</td> <td>Complimentary Registration</td></tr>
                          <tr><td>Puja Name</td> <td>" . $pujaname . "</td></tr>
                         <tr><td>Payment Status</td> <td>Confirmed</td></tr>
                         <tr><td>Pay Date</td> <td>" . $payfinaldate . "</td></tr>
                         <tr><td colspan='2'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td></tr>
                         </tr>";
                        echo "</table>";
                        if (!$this->isAdmin() && !$this->isEditor()) {
                            echo "<a  href='" . INSTALL_URL . "PujaSankalpa/PujaSankalpa'>Go to home</a>";

                        }
                        if ($this->isAdmin() || $this->isEditor()) {
                            echo " <a href='" . INSTALL_URL . "Pujaregistration/index'>Go to home</a>";

                        }
                        exit();
                    }
                    // for stripe option
                    elseif (($_POST['PaymentOption'] ?? '') == 'stripe') {

                        $amount = $_POST['item_cost'] ?? '';

                        $total = $amount;

                        $pujaselect = $_POST['selectedpuja'] ?? '';
                        if ($pujaselect == 'hathekhori') {
                            $pujaname = "Haate Khori";
                        } else {
                            $pujaname = $_POST['allpujaname'][0];
                        }
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
                                    "description" => "Pay For:" . $pujaname . ', ' . "Email:" . ($_POST['email'] ?? '') . ', ' . "Full Name:" . ($_POST['MemberName'] ?? ''),
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
                                $_POST['Status'] = 'confirmed';
                                $opts['payment_timestamp'] = time();
                                $data = $_POST;
                                $datamemberarr = array();
                                $datamemberarr = array_merge($opts, $_POST);
                                $SankalpaPujaModel->update(array_merge($opts, $_POST));
                                if ($pujaselect == 'hathekhori') {
                                    $pujaname = "Haate Khori";
                                } else {
                                    $pujaname = $_POST['allpujaname'] ?? '';
                                }

                                $value = array();
                                $value['oid'] = $datamemberarr['oid'];
                                $value['Member_id'] = $datamemberarr['Member_id'];
                                $value['MemberName'] = $datamemberarr['name'];
                                $value['PaymentOption'] = $datamemberarr['PaymentOption'];
                                $value['payment_status'] = 'succeeded';
                                $value['payment_timestamp'] = $datamemberarr['payment_timestamp'] ?? '';
                                $value['Amount'] = $datamemberarr['item_cost'];
                                $value['stripe_return'] = $datamemberarr['stripe_return'] ?? '';
                                $value['transaction_id'] = $datamemberarr['transaction_id'];
                                $value['paid_amount'] = $datamemberarr['paid_amount'] ?? '';
                                $value['update_on'] = $datamemberarr['UpdateOn'] ?? '';
                                $value['stripe_product'] = $datamemberarr['stripe_product'] ?? '';
                                $value['pay_date'] = $datamemberarr['pay_date'];
                                $value['pay_type'] = 'Puja Registration';
                                $pujaselect = $_POST['selectedpuja'] ?? '';
                                $value['pay_for'] = $_POST['pay_for'] ?? '';
                                $value['Tele1'] = $datamemberarr['tele'];
                                $value['Tele2'] = $datamemberarr['alternatenumber'];
                                $value['email'] = $datamemberarr['email'];
                                $value['spousename'] = $datamemberarr['spousename'];
                                $value['Address'] = $datamemberarr['streetname'];
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
                                    $value['Tele2'] = $_POST['alternatenumber'] ?? '';
                                    $value['email'] = $_POST['email'] ?? '';
                                    $value['City'] = $_POST['city'] ?? '';
                                    $value['State'] = $_POST['state'] ?? '';
                                    $value['Zip_Code'] = $_POST['zip'] ?? '';
                                    $value['Amount'] = $_POST['item_cost'] ?? '';
                                    $value['pay_type'] = 'Puja Registration';
                                    $value['pay_for'] =  $pujaname;
                                    $value['pay_date'] = $_POST['pay_date'] ?? '';
                                    $value['transaction_id'] = $_POST['transaction_id'] ?? '';
                                    $value['remarks'] = $_POST['remarks'] ?? '';
                                    $value['created_on'] = $_POST['created_on'] ?? '';
                                    $value['update_on'] = $_POST['update_on'] ?? '';
                                    $value['PaymentOption'] = $_POST['PaymentOption'] ?? '';
                                    $value['payment_status'] = 'confirmed';
                                    $value['cc_name'] = $_POST['cc_name'] ?? '';
                                    $value['Member_id'] = $_POST['Member_id'] ?? '';
                                    $value['type'] = $_POST['type'] ?? '';
                                    $value['street'] = $_POST['street'] ?? '';
                                    $value['Address'] = $_POST['streetname'] ?? '';
                                    $value['Address3'] = $_POST['unit'] ?? '';
                                    $value['spousename'] = $_POST['spousename'] ?? '';
                                    $value['Child1'] = $_POST['Child1'] ?? '';
                                    $value['Age1'] = $_POST['Age1'] ?? '';
                                    $value['Child2'] = $_POST['Child2'] ?? '';
                                    $value['Age2'] = $_POST['Age2'] ?? '';
                                    $value['Child3'] = $_POST['Child3'] ?? '';
                                    $value['Age3'] = $_POST['Age3'] ?? '';
                                    $MemberModel->SaveDataInmember($value);
                                }
                                $MemberName = $_POST['name'] ?? '';
                                $Amount = $_POST['item_cost'] ?? '';
                                if ($pujaselect == 'hathekhori') {
                                    $pujaname = "Haate Khori";
                                } else {
                                    $pujaname = $_POST['allpujaname'][0];
                                }
                                $memberid = $_POST['Member_id'] ?? '';
                                $payment_status = $opts['payment_status'];
                                $paymentoption = $_POST['PaymentOption'] ?? '';
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
                 <tr><td>Payment Method</td> <td>Credit Card</td>  </tr>
                 <tr><td>Amount</td> <td><span style='color:red;'>$</span>" . $Amount . "</td> </tr>
                  <tr><td>Puja Name</td> <td>" . $pujaname . "</td>  </tr>
                 <tr><td>Payment Status</td> <td>Confirmed</td>  </tr>
                 <tr><td>Pay Date</td> <td>" . $payfinaldate . "</td>  </tr>
                 <tr><td colspan='2' style='font-weight: bold;color:red;'>An email with your payment information has been sent to your registered email address. Please check your spam folder if you cannot find the email in your inbox</td></tr>
                 <tr><td colspan='2'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>   </tr>
                 </tr>";

                                echo "</table>";
                                // echo "<a  href='" . INSTALL_URL . "PujaSankalpa/PujaSankalpa'>Go to home</a>";
                                if (!$this->isAdmin() && !$this->isEditor()) {
                                    echo "<a  href='" . INSTALL_URL . "PujaSankalpa/PujaSankalpa'>Go to home</a>";

                                }
                                if ($this->isAdmin() || $this->isEditor()) {
                                    echo " <a href='" . INSTALL_URL . "Pujaregistration/index'>Go to home</a>";

                                }
                                echo "</div>";

                            $email = $_POST['email'] ?? '';
                            if ($email != null) {
                                $this->sendEmailticket($message, $subjetc, $email, $Emailcc);
                            }
                            $mobileno = $_POST['alternatenumber'] ?? '';
                            if ($mobileno != null) {
                                $this->SendSMS($mobileno, $textmsg );
                            }

                                $this->tpl['arr'] = $SankalpaPujaModel->get($id);
                            } else {

                                $opts = array();
                                $opts['id'] = $id;
                                $opts['stripe_return'] = $payment->status;
                                $opts['transaction_id'] = $payment->id;
                                $opts['paid_amount'] = $payment->amount;
                                $opts['stripe_product'] = $payment->description;

                                $SankalpaPujaModel->update($opts);

                                $_SESSION['status'] = '<strong>' . __('declined_card') . '</strong>';
                            }
                        } catch (Exception $ex) {
                            $_SESSION['status'] = $ex->getMessage();
                        }

                        $this->tpl['arr'] = $SankalpaPujaModel->get($id);
                        $this->tpl['arr']['amount'] = $total;
                    } else {
                        $_SESSION['status'] = 16;

                    }
                } else {
                    $_SESSION['status'] = 17;
                }

            }
            exit();
        }
    }



}



?>
