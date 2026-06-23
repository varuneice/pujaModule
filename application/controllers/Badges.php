<?php

require_once CONTROLLERS_PATH . 'App.php';

class Badges extends App {

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

        if ($this->isMember() && ($_REQUEST['action'] ?? '') != 'pay' && ($_REQUEST['action'] ?? '') != 'calculatePrice' && ($_REQUEST['action'] ?? '') != 'checkout' && ($_REQUEST['action'] ?? '') != 'create') {
            GzObject::loadFiles('Model', array('Member'));
            $MemberModel = new MemberModel();

            $user = $this->getUser();

            $member = $MemberModel->get($user['ID']);

            if ($member['payment_status'] != 'confirmed' || $member['status'] == 'E') {
                Util::redirect(INSTALL_URL . "Member/pay");
            }

            $this->tpl['member'] = $member;
        }

        if ((!$this->isLoged() && ($_REQUEST['action'] ?? '') != 'login' && ($_REQUEST['action'] ?? '') != 'calculatePrice') || (!$this->isAdmin() && !in_array(($_REQUEST['action'] ?? ''), array('edit', 'pay', 'calculatePrice', 'checkout')))) {

            // if(($_REQUEST['action'] ?? '') != 'create' && ($_REQUEST['action'] ?? '') != 'details'){
               
            //     $_SESSION['err'] = 2;
            //     Util::redirect(INSTALL_URL . "Admin/login");
            // }
        }
        $this->css[] = array('file' => 'assets/vendors/mdi/css/materialdesignicons.min.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'assets/vendors/css/vendor.bundle.base.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'assets/css/style.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'jquery.signature.css', 'path' => CSS_PATH);
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

        $this->js[] = array('file' => 'admin.js?v=' . time(), 'path' => JS_PATH);
        $this->js[] = array('file' => 'jquery.signature.js', 'path' => JS_PATH);
        $this->js[] = array('file' => 'jquery.ui.touch-punch.js', 'path' => JS_PATH);
        $this->js[] = array('file' => 'jquery.ui.touch-punch.min.js', 'path' => JS_PATH);
       //$this->js[] = array('file' => 'jquery.signature.min.js', 'path' => JS_PATH);
       //$this->js[] = array('file' => 'jquery.signature.min.map', 'path' => JS_PATH);

        if (($_REQUEST['action'] ?? '') == 'pay') {
            $this->js[] = array('file' => '', 'path' => 'https://js.stripe.com/v3/', 'remote' => 1);
        }

        $this->js[] = array('file' => 'GzMember.js?v=' . time(), 'path' => JS_PATH);
      
        $this->js[] = array('file' => 'loadingoverlay.js?v=' . time(), 'path' => JS_PATH);
    }
    
    function details() {
        GzObject::loadFiles('Model', array('Member'));
        $MemberModel = new MemberModel();
        
        $ID = $_GET['id'] ?? '';
        
        $this->tpl['arr'] = $MemberModel->get($ID);
    }
    
    function create() {
        GzObject::loadFiles('Model', array('Member', 'Country'));
        $MemberModel = new MemberModel();
        $CountryModel = new CountryModel();
        $arr= $CountryModel->getCountry();
        $this->tpl['Country'] =  $arr;
        if (!empty($_POST['create_member'])) {

            $data = array();
           // $data['Application_date'] = date('Y-m-d H:i:s');
            $StartingDate =date('Y');
            $newEndingDate = date("Y", strtotime(date("Y", strtotime($StartingDate)) . " + 365 day"));
            $renew = $newEndingDate."-"."01"."-"."01";
            $total =$_POST['total'] ?? '';
            if($total=="3000"){
                $data['Renew_date'] = "9999-12-31";
            }else{
                $data['Renew_date'] = $renew;
            }
            if (!empty($_FILES['img'])) {

                require_once APP_PATH . 'helpers/uploader/class.upload.php';

                $handle = new upload($_FILES['img']);

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
            
            if (($_POST['status'] ?? '') == 'T') {
                $pasword = Util::incrementalHash(10);
                $data['password'] = password_hash((string)$pasword, PASSWORD_BCRYPT);
            }
            
            switch($_POST['rate'] ?? ''){
                case 'gmi_1':
                    $data['Category'] = 'GM';
                    break;
                case 'gmi_4':
                    $data['Category'] = 'GM';
                    break;
                case 'gmf_1':
                    $data['Category'] = 'GM';
                    break;
                case 'gmf_4':
                    $data['Category'] = 'GM';
                    break;
                case 'lm':
                    $data['Category'] = 'LM';
                    break;
                case 'bf':
                    $data['Category'] = 'BF';
                    break;
                case 'pm':
                    $data['Category'] = 'CT';
                    break;
                case 'lm_h':
                    $data['Category'] = 'LM';
                    break;
            }
            
            $data['Member_id'] = $MemberModel->getMax() + 1;
            
            if(empty($_POST['status'])){
                $_POST['status'] = 'F';
            }

            $ID = $MemberModel->save(array_merge($_POST, $data));
            
            GzObject::loadFiles('Model', array('MemberLog'));
            $MemberLogModel = new MemberLogModel();

            $data = array();
            $data['rate'] = $_POST['rate'] ?? '';

            switch($_POST['rate'] ?? ''){
                case 'gmi_1':
                    $data['Category'] = 'GM';
                    break;
                case 'gmi_4':
                    $data['Category'] = 'GM';
                    break;
                case 'gmf_1':
                    $data['Category'] = 'GM';
                    break;
                case 'gmf_4':
                    $data['Category'] = 'GM';
                    break;
                case 'lm':
                    $data['Category'] = 'LM';
                    break;
                case 'bf':
                    $data['Category'] = 'BF';
                    break;
                case 'pm':
                    $data['Category'] = 'CT';
                    break;
                case 'lm_h':
                    $data['Category'] = 'LM';
                    break;
            }

            $data['member_id'] = $ID;

            $data['Createdon'] = date('Y-m-d H:i:s');
            $data['Application_date'] = date('Y-m-d H:i:s');


            if($this->isMember()){
                $data['Updatedby'] = $this->getMemberId();
            }else{
                $data['Updatedby'] = $this->getUserId();
            }
            
            $data['Status'] = $_POST['status'] ?? '';

            $MemberLogModel->save($data);

            $this->sendMemberEmails($ID, 'create', 'admin');

            if (($_POST['status'] ?? '') == 'T') {

                $_POST['password'] = $pasword;

                $this->sendMemberEmails($_POST['id'] ?? '', 'active', 'member');
            }
            
            $this->tpl['arr'] = $MemberModel->get($ID);
            
            Util::redirect(INSTALL_URL . "Member/details/".$ID);
        }
    }

    function edit() {

        GzObject::loadFiles('Model', array('Member', 'Country'));
        $MemberModel = new MemberModel();
        // $CountryModel = new CountryModel();
        // $arr= $CountryModel->getCountry();
        // $this->tpl['Country'] =  $arr;
        //if (!empty($_POST['edit_user'])) 
        {
            
            //$folderPath = $_FILES['sig'];
            require_once APP_PATH . 'helpers/uploader/class.upload.php';
            $folderPath = "../application/web/sig/";
            $image_parts = explode(";base64,", $_POST['signed'] ?? '');
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $file = $folderPath . uniqid() . '.'.$image_type;
            file_put_contents($file, $image_base64);
            //echo "Signature Uploaded Successfully.";
            // if ($this->isMember() && ($_POST['ID'] ?? '') != $this->getMemberId()) {
            //     $_SESSION['err'] = 2;
            //     Util::redirect(INSTALL_URL . "Admin/login");
            // }

            // $member = $MemberModel->get($_POST['ID'] ?? '');

            // $data = array();

            //if (!empty($_FILES['sig']))
            //  {
                
            //     $handle = new upload($_FILES['sig']);

            //     $img_name = time();

            //     if ($handle->uploaded) {

            //         $thumb_dest = INSTALL_PATH . UPLOAD_PATH . 'avatar/thumb/';

            //         $handle->file_new_name_body = $img_name;
            //         $handle->image_resize = true;
            //         $handle->image_x = 200;
            //         $handle->image_ratio_y = true;
            //         $handle->allowed = array('image/*');
            //         $handle->process($thumb_dest);

            //         if ($handle->processed) {
            //             $handle->clean();
            //         } else {
            //             echo 'error : ' . $handle->error;
            //         }
            //         $data['avatar'] = $handle->file_dst_name;
            //     }
            // }

            
            // $ID = $MemberModel->update(array_merge($data, $_POST));
            
            // GzObject::loadFiles('Model', array('MemberLog'));
            // $MemberLogModel = new MemberLogModel();

            // $data = array();
            // $data['rate'] = $_POST['rate'] ?? '';

            
            // $data['member_id'] = $_POST['ID'] ?? '';

            // $data['Createdon'] = date('Y-m-d H:i:s');

            // if($this->isMember()){
            //     $data['Updatedby'] = $this->getMemberId();
            // }else{
            //     $data['Updatedby'] = $this->getUserId();
            // }
            
            // $data['Status'] = $_POST['status'] ?? '';

            // $MemberLogModel->save($data);

            // if (($_POST['status'] ?? '') == 'T' && $member['status'] != 'T') {

            //     $_POST['password'] = $pasword;

            //     $this->sendMemberEmails($_POST['ID'] ?? '', 'active', 'member');
            // }

            // if (!empty($ID)) {
            //     $_SESSION['status'] = 20;
            // } else {
            //     $_SESSION['status'] = 21;
            // }

            // if (!$this->isAdmin()) {
            //     Util::redirect(INSTALL_URL . "Admin/dashboard");
            // } else {
            //     Util::redirect(INSTALL_URL . "Badges/index");
            // }
        }

        // if ($this->isMember() && ($_GET['ID'] ?? '') != $this->getMemberId()) {
        //     $_SESSION['err'] = 2;
        //     Util::redirect(INSTALL_URL . "Admin/login");
        // }
        
        $ID = $_GET['ID'] ?? '';
        $arr = $MemberModel->get($ID);

        $this->tpl['arr'] = $arr;
    }

    function index() {
        GzObject::loadFiles('Model', array('Member'));
        $MemberModel = new MemberModel();

        $opts = array();

        if (!empty($_POST['Member_id'])) {
            $opts['Member_id LIKE :Member_id'] = array(':Member_id' => "%" . ($_POST['Member_id'] ?? '') . "%");
        }
        if (!empty($_POST['F_Name'])) {
            $opts['F_Name LIKE :F_Name'] = array(':F_Name' => "%" . ($_POST['F_Name'] ?? '') . "%");
        }
        if (!empty($_POST['Sp_FName'])) {
            $opts['Sp_FName LIKE :Sp_FName'] = array(':Sp_FName' => "%" . ($_POST['Sp_FName'] ?? '') . "%");
        }
        if (!empty($_POST['Category'])) {
            $opts['Category LIKE :Category'] = array(':Category' => "%" . ($_POST['Category'] ?? '') . "%");
        }
        if (!empty($_POST['Email'])) {
            $opts['email LIKE :email'] = array(':email' => "%" . ($_POST['email'] ?? '') . "%");
        }
        $opts['Category = :Category'] = array(':Category' => "GM");
        $this->tpl['active'] = $MemberModel->getAll($opts);

        $opts = array();
        $opts['Category = :Category'] = array(':Category' => "LM");
        $this->tpl['life'] = $MemberModel->getAll($opts);

        $opts = array();
        $opts['Category = :Category'] = array(':Category' => "BF");
        $this->tpl['benefactors'] = $MemberModel->getAll($opts);

        $opts = array();
        $opts['Category = :Category'] = array(':Category' => "CT");
        $this->tpl['ctmemeber'] = $MemberModel->getAll($opts);

        $opts = array();
        $opts['status = :status'] = array(':status' => "F");
        $this->tpl['inactive'] = $MemberModel->getAll($opts);

        $opts = array();
        $opts['status = :status'] = array(':status' => "E");
        $this->tpl['expired'] = $MemberModel->getAll($opts);
    }

    function delete() {
        $this->isAjax = true;

        $id = ($_REQUEST['id'] ?? '');

        GzObject::loadFiles('Model', array('Booking', 'Member'));
        $MemberModel = new MemberModel();

        $MemberModel->deleteFrom($MemberModel->getTable())
                ->where('id', $id)->execute();

        $this->index();
    }

    function deleteImage() {
        $this->isAjax = true;

        GzObject::loadFiles('Model', array('Member'));
        $MemberModel = new MemberModel();

        if (!empty($_POST['ID'])) {

            $ID = $_POST['ID'] ?? '';

            $member = $MemberModel->get($ID);

            $dest = INSTALL_PATH . UPLOAD_PATH . "avatar/thumb/" . $member['avatar'];
            if (is_file($dest)) {
                unlink($dest);
            }

            $data = array();
            $data['avatar'] = '';

            $MemberModel->update(array_merge($_POST, $data));
        }

        $opts = array();

        $this->tpl['arr'] = $MemberModel->getAll($opts, 'ID desc');
    }

    function deleteEditedImage() {
        $this->isAjax = true;

        GzObject::loadFiles('Model', array('Member'));
        $MemberModel = new MemberModel();

        if (!empty($_POST['id'])) {

            $ID = $_POST['id'] ?? '';

            $member = $MemberModel->get($ID);

            $dest = INSTALL_PATH . UPLOAD_PATH . "avatar/thumb/" . $member['avatar'];
            if (is_file($dest)) {
                unlink($dest);
            }

            $data = array();
            $data['avatar'] = '';

            $MemberModel->update(array_merge($_POST, $data));
        }
    }

    function export() {
        $this->setIsAjax(true);

        $this->isAjax = true;

        GzObject::loadFiles('Model', array('Booking', 'Member'));
        $MemberModel = new MemberModel();
        //$BookingSlotModel = new BookingSlotModel();

        $output = "";

        $query = $MemberModel->from($MemberModel->getTable());

        $members = $query->fetchAll();

        foreach ($members[0] as $k => $v) {
            $output .= '"' . $k . '",';
        }
        $output .= "\n";

        foreach ($members as $key => $value) {

            $opts = array();
            $opts['member_id'] = $value['id'];
            $slots = $MemberModel->getAll($opts);

            foreach ($value as $k => $v) {
                if ($k == 'date') {
                    $output .= '"' . date("Y-m-d H:i", $v) . '",';
                } else {
                    $output .= '"' . $v . '",';
                }
            }
            // foreach($slots as $slot){
            //     foreach($slot as $k => $s){
            //         if($k != 'id' && $k != 'calendar_id' && $k != 'booking_id'){
            //             if($k == 'timestamp'){
            //                 $output .='"' . date("Y-m-d H:i", $s) . '",';
            //             }else{
            //                 $output .='"' . $s . '",';
            //             }
            //         }
            //     }
            // }
            $output .= "\n";
        }

        $filename = "member_" . time() . ".csv";

        header('Content-type: application/csv');
        header('Content-Disposition: attachment; filename=' . $filename);

        echo $output;
        exit;
    }

    function pay() {
        GzObject::loadFiles('Model', array('Member'));
        $MemberModel = new MemberModel();

        $user = $this->getUser();

        $this->tpl['arr'] = $MemberModel->get($user['ID']);
    }

    function checkout() {

        GzObject::loadFiles('Model', array('Member', 'ConfirmCode', 'MemberLog'));
        $MemberModel = new MemberModel();
        $ConfirmCodeModel = new ConfirmCodeModel();
        $MemberLogModel = new MemberLogModel();

        $user = $this->getUser();
        
        $this->tpl['arr'] = $user;

        if (!empty($_POST['pay_user']) && !empty($_POST['ID'])) {
            
            $id = $user['ID'];
            
            if (($_POST['Payment_method'] ?? '') == 'others') {
                    
                $opts = array();
                $opts['Confirmation'] = $_POST['confirm_code'] ?? '';
                $arr = $ConfirmCodeModel->getAll($opts);

                if (!empty($arr[0])) {
                    $opts = array();
                    $opts['id'] = $id;
                    $opts['payment_status'] = 'confirmed';

                    $MemberModel->update($opts);

                    $data = array();
                    $data['rate'] = $_POST['rate'] ?? '';

                    switch($_POST['rate'] ?? ''){
                        case 'gmi_1':
                            $data['Category'] = 'GM';
                            break;
                        case 'gmi_4':
                            $data['Category'] = 'GM';
                            break;
                        case 'gmf_1':
                            $data['Category'] = 'GM';
                            break;
                        case 'gmf_4':
                            $data['Category'] = 'GM';
                            break;
                        case 'lm':
                            $data['Category'] = 'LM';
                            break;
                        case 'bf':
                            $data['Category'] = 'BF';
                            break;
                        case 'pm':
                            $data['Category'] = 'CT';
                            break;
                        case 'lm_h':
                            $data['Category'] = 'LM';
                            break;
                    }

                    $data['member_id'] = $id;

                    $data['Createdon'] = date('Y-m-d H:i:s');

                    if($this->isMember()){
                        $data['Updatedby'] = $this->getMemberId();
                    }else{
                        $data['Updatedby'] = $this->getUserId();
                    }

                    $data['Status'] = 'P';

                    $MemberLogModel->save($data);
                }
            }elseif (($_POST['Payment_method'] ?? '') == 'stripe') {
                
                $price = $this->calculateMemberPrice();
                
                $amount = $price['total'];

                require APP_PATH . '/helpers/stripe/lib/Stripe.php';

                $error = '';
                $success = '';

                Stripe::setApiKey($this->tpl["option_arr_values"]["stripe_api_key"]);

                try {
                    if (!isset($_POST['stripeToken'])) {
                        throw new Exception("The Stripe Token was not generated correctly");
                    }

                    $amount = round($amount * 100);

                    $payment = Stripe_Charge::create(array(
                                "amount" => $amount,
                                "currency" => $this->tpl["option_arr_values"]["currency"],
                                "card" => $_POST['stripeToken'] ?? '',
                                "description" => ($_POST['email'] ?? '') . ', ' . ($_POST['F_Name'] ?? '') . ' ' . ($_POST['L_Name'] ?? '')
                    ));

                    $this->tpl['payment']['balance_transaction'] = $payment->balance_transaction;
                    $this->tpl['payment']['amount'] = $payment->amount;
                    $this->tpl['payment']['status'] = $payment->status;
                    $this->tpl['payment']['currency'] = $payment->currency;

                    if ($payment->status == 'succeeded') {
                        
                        unset($_POST['amount']);

                        $opts = array();
                        $opts['id'] = $id;
                        $opts['stripe_return'] = $payment->status;
                        $opts['transaction_id'] = $payment->id;
                        $opts['paid_amount'] = $payment->amount;
                        $opts['donation'] = $_POST['donation'] ?? '';
                        
                        $opts['amount'] = $price['total'] - $_POST['donation'] ?? '';
                        $opts['total'] = $price['total'];
                        $opts['stripe_product'] = $payment->description;
                        $opts['payment_status'] = 'confirmed';
                        $opts['payment_timestamp'] = time();
                        
                        switch($_POST['rate'] ?? ''){
                            case 'gmi_1':
                                $opts['Category'] = 'GM';
                                break;
                            case 'gmi_4':
                                $opts['Category'] = 'GM';
                                break;
                            case 'gmf_1':
                                $opts['Category'] = 'GM';
                                break;
                            case 'gmf_4':
                                $opts['Category'] = 'GM';
                                break;
                            case 'lm':
                                $opts['Category'] = 'LM';
                                break;
                            case 'bf':
                                $opts['Category'] = 'BF';
                                break;
                            case 'pm':
                                $opts['Category'] = 'CT';
                                break;
                            case 'lm_h':
                                $opts['Category'] = 'LM';
                                break;
                        }

                        $MemberModel->update(array_merge($opts, $_POST));
                        
                        $data = array();
                        $data['rate'] = $_POST['rate'] ?? '';

                        switch($_POST['rate'] ?? ''){
                            case 'gmi_1':
                                $data['Category'] = 'GM';
                                break;
                            case 'gmi_4':
                                $data['Category'] = 'GM';
                                break;
                            case 'gmf_1':
                                $data['Category'] = 'GM';
                                break;
                            case 'gmf_4':
                                $data['Category'] = 'GM';
                                break;
                            case 'lm':
                                $data['Category'] = 'LM';
                                break;
                            case 'bf':
                                $data['Category'] = 'BF';
                                break;
                            case 'pm':
                                $data['Category'] = 'CT';
                                break;
                            case 'lm_h':
                                $data['Category'] = 'LM';
                                break;
                        }

                        $data['member_id'] = $id;

                        $data['Createdon'] = date('Y-m-d H:i:s');

                        if($this->isMember()){
                            $data['Updatedby'] = $this->getMemberId();
                        }else{
                            $data['Updatedby'] = $this->getUserId();
                        }

                        $data['Status'] = 'P';

                        $MemberLogModel->save($data);
                        
                        $this->tpl['arr'] = $MemberModel->get($id);
                    } else {

                        $opts = array();
                        $opts['id'] = $id;
                        $opts['stripe_return'] = $payment->status;
                        $opts['transaction_id'] = $payment->id;
                        $opts['paid_amount'] = $payment->amount;
                        $opts['stripe_product'] = $payment->description;
                        
                        $MemberModel->update($opts);

                        $_SESSION['status'] = '<strong>' . __('declined_card') . '</strong>';
                    }
                } catch (Exception $ex) {
                    $_SESSION['status'] = $ex->getMessage();
                }
            }
        }else{
            $_SESSION['status'] = 'An error occurred, please try again!';
        }
    }
    
    function calculatePrice(){
        $this->isAjax = true;
        
        $price = $this->calculateMemberPrice();
        
        header("Content-Type: application/json", true);
        echo json_encode($price);
    }

}

?>
