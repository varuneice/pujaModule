<?php

require_once CONTROLLERS_PATH . 'App.php';

class Student extends App {

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

        if ((!$this->isLoged() && ($_REQUEST['action'] ?? '') != 'login') || (!$this->isAdmin() && !in_array(($_REQUEST['action'] ?? ''), array('edit')))) {

            if (($_REQUEST['action'] ?? '') != 'create') {
                $_SESSION['err'] = 2;
                Util::redirect(INSTALL_URL . "Admin/login");
            }
        }

        if ($this->isMember()) {

            if (($_REQUEST['action'] ?? '') != 'create') {
                $_SESSION['err'] = 2;
                Util::redirect(INSTALL_URL . "Admin/login");
            }
        }

        $this->css[] = array('file' => 'admin/gzstyling/bootstrap.min.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'admin/gzstyling/font-awesome.min.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'admin/gzstyling/ionicons.min.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'admin/gzstyling/gzstyle.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'admin/gzstyling/daterangepicker/daterangepicker-bs3.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'ui-custom.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'gzadmin/plugins/bootstrap-select/dist/css/bootstrap-select.min.css', 'path' => JS_PATH);
        $this->css[] = array('file' => 'admin/admin.css', 'path' => CSS_PATH);

        $this->js[] = array('file' => 'jquery/jquery-1.9.1.min.js', 'path' => LIBS_PATH);
        $this->js[] = array('file' => 'gzadmin/bootstrap.min.js', 'path' => JS_PATH);

        $this->js[] = array('file' => 'gzadmin/plugins/datatables/jquery.dataTables.js', 'path' => JS_PATH);
        $this->js[] = array('file' => 'gzadmin/plugins/datatables/dataTables.bootstrap.js', 'path' => JS_PATH);
        $this->js[] = array('file' => 'gzadmin/gzadmin/app.js', 'path' => JS_PATH);
        $this->js[] = array('file' => 'jquery-ui.min.js', 'path' => LIBS_PATH . 'jquery/ui/');
        $this->js[] = array('file' => 'ajax-upload/das.js', 'path' => JS_PATH);
        $this->js[] = array('file' => 'ajax-upload/jquery.form.js', 'path' => JS_PATH);
        $this->js[] = array('file' => 'jquery/jquery-validation-1.13.0/dist/jquery.validate.js', 'path' => LIBS_PATH);
        $this->js[] = array('file' => 'jquery/ui/jquery-ui.min.js', 'path' => LIBS_PATH);
        $this->js[] = array('file' => 'gzadmin/plugins/daterangepicker/daterangepicker.js', 'path' => JS_PATH);
        $this->js[] = array('file' => 'gzadmin/plugins/bootstrap-select/dist/js/bootstrap-select.min.js', 'path' => JS_PATH);
        $this->js[] = array('file' => 'admin.js?v=' . time(), 'path' => JS_PATH);

        if (($_REQUEST['action'] ?? '') == 'create') {
            $this->js[] = array('file' => '', 'path' => 'https://js.stripe.com/v3/', 'remote' => 1);
        }

        $this->js[] = array('file' => 'GzStudent.js?v=' . time(), 'path' => JS_PATH);
         $this->js[] = array('file' => 'GzBooking.js?v=' . time(), 'path' => JS_PATH);
    }

    function create() {
        GzObject::loadFiles('Model', array('Student', 'ConfirmCode', 'Member'));
        $StudentModel = new StudentModel();
        $ConfirmCodeModel = new ConfirmCodeModel();
        $MemberModel = new MemberModel();
        
        $this->tpl['members'] = $MemberModel->getAll();

        if (!empty($_POST['create_Student'])) {

            $data = array();
            
            $data['subject'] = serialize($_POST['subject'] ?? '');
            $data['type'] = serialize($_POST['type'] ?? '');
            
            $subject = $_POST['subject'] ?? '';
            $type = $_POST['type'] ?? '';
            
            unset($_POST['subject']);
            unset($_POST['type']);

            $id = $StudentModel->save(array_merge($_POST, $data));

            if (!empty($id)) {

                if (($_POST['payment_method'] ?? '') == 'others') {
                    
                    $opts = array();
                    $opts['Confirmation'] = $_POST['confirm_code'] ?? '';
                    $arr = $ConfirmCodeModel->getAll($opts);

                    if (!empty($arr[0])) {
                        $opts = array();
                        $opts['uid'] = $id;
                        $opts['payment_status'] = 'confirmed';

                        $StudentModel->update($opts);
                    }
                }elseif (($_POST['payment_method'] ?? '') == 'stripe') {

                    switch ($_POST['fee'] ?? '') {
                        case '1':
                            $amount = $this->tpl['option_arr_values']['student_annual'];
                            break;
                        case '2':
                            $amount = $this->tpl['option_arr_values']['student_semester'];
                            break;
                    }
                    
                    $amount = count($subject)*$amount + count($type)*$amount;
                    
                    $total = $amount;

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
                                    "description" => ($_POST['St_Name'] ?? '') . ', ' . ($_POST['oid'] ?? '')
                        ));

                        $this->tpl['payment']['balance_transaction'] = $payment->balance_transaction;
                        $this->tpl['payment']['amount'] = $payment->amount;
                        $this->tpl['payment']['status'] = $payment->status;
                        $this->tpl['payment']['currency'] = $payment->currency;

                        if ($payment->status == 'succeeded') {

                            unset($_POST['amount']);

                            $opts = array();
                            $opts['uid'] = $id;
                            $opts['stripe_return'] = $payment->status;
                            $opts['transaction_id'] = $payment->id;
                            $opts['paid_amount'] = $payment->amount;
                            $opts['stripe_product'] = $payment->description;
                            $opts['payment_status'] = 'confirmed';
                            $opts['payment_timestamp'] = time();

                            $StudentModel->update(array_merge($opts, $_POST));

                            $this->tpl['arr'] = $StudentModel->get($id);
                        } else {

                            $opts = array();
                            $opts['uid'] = $id;
                            $opts['stripe_return'] = $payment->status;
                            $opts['transaction_id'] = $payment->id;
                            $opts['paid_amount'] = $payment->amount;
                            $opts['stripe_product'] = $payment->description;

                            $StudentModel->update($opts);

                            $_SESSION['status'] = '<strong>' . __('declined_card') . '</strong>';
                        }
                    } catch (Exception $ex) {
                        $_SESSION['status'] = $ex->getMessage();
                    }
                    
                    $this->tpl['arr'] = $StudentModel->get($id);
                    $this->tpl['arr']['amount'] = $total;
                }else{
                     $_SESSION['status'] = 16;
                     Util::redirect(INSTALL_URL . "Student/index");
                }

               
            } else {
                $_SESSION['status'] = 17;

                Util::redirect(INSTALL_URL . "Student/index");
            }
        }
    }

    function edit() {
        GzObject::loadFiles('Model', array('Student', 'Member'));
        $StudentModel = new StudentModel();
        $MemberModel = new MemberModel();
        
        $this->tpl['members'] = $MemberModel->getAll();

        if (!$this->isAdmin() && ($_REQUEST['id'] ?? '') != $this->getUserId()) {
            $_SESSION['err'] = 2;
            Util::redirect(INSTALL_URL . "Admin/login");
        }

        if (!empty($_POST['edit_Student'])) {

            $data = array();

             $data['subject'] = serialize($_POST['subject'] ?? '');
            $data['type'] = serialize($_POST['type'] ?? '');
            unset($_POST['subject']);
            unset($_POST['type']);
            $id = $StudentModel->update(array_merge($data, $_POST));

            if (!empty($id)) {
                $_SESSION['status'] = 20;
            } else {
                $_SESSION['status'] = 21;
            }

            if (!$this->isAdmin()) {
                Util::redirect(INSTALL_URL . "Admin/dashboard");
            } else {
                Util::redirect(INSTALL_URL . "Student/index");
            }
        }
        $id = $_GET['id'] ?? '';
        $arr = $StudentModel->get($id);

        $this->tpl['arr'] = $arr;
    }

    function index() {

        GzObject::loadFiles('Model', array('Student'));
        $StudentModel = new StudentModel();

        if (!empty($_POST['uid'])) {
            $opts['uid LIKE :uid'] = array(':uid' => "%" . ($_POST['uid'] ?? '') . "%");
        }
        if (!empty($_POST['St_Name'])) {
            $opts['St_Name LIKE :St_Name'] = array(':St_Name' => "%" . ($_POST['St_Name'] ?? '') . "%");
        }
        if (!empty($_POST['session'])) {
            $opts['session LIKE :session'] = array(':session' => "%" . ($_POST['session'] ?? '') . "%");
        }

        if (!empty($_POST['school'])) {
            $opts['school LIKE :school'] = array(':school' => "%" . ($_POST['school'] ?? '') . "%");
        }
        if (!empty($_POST['Email'])) {
            $opts['subject LIKE :subject'] = array(':subject' => "%" . ($_POST['subject'] ?? '') . "%");
        }

        $opts = array();

        $arr = $StudentModel->getAll(array_merge($opts));

        $this->tpl['arr'] = $arr;
    }

    function delete() {
        $this->isAjax = true;

        $id = ($_REQUEST['id'] ?? '');

        GzObject::loadFiles('Model', array('Student'));
        $StudentModel = new StudentModel();

        $StudentModel->deleteFrom($StudentModel->getTable())
                ->where('id', $id)->execute();

        $opts = array();

        $arr = $StudentModel->getAll($opts);

        $this->tpl['arr'] = $arr;
    }

    function deleteSelected() {
        $this->isAjax = true;

        GzObject::loadFiles('Model', array('User'));
        $UserModel = new BookingModel();

        if (!empty($_POST['mark'])) {

            $UserModel->deleteFrom($UserModel->getTable())
                    ->where('id', $_POST['mark'] ?? '')->execute();
        }

        $arr = $UserModel->getAll();

        $this->tpl['arr'] = $arr;
    }

}

?>
