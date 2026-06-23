<?php

require_once CONTROLLERS_PATH . 'App.php';
class SponsorItem extends App
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

            if (($_REQUEST['action'] ?? '') != 'edit') {
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
        //$this->js[] = array('file' => 'ajax-upload/das.js', 'path' => JS_PATH);
        //$this->js[] = array('file' => 'ajax-upload/jquery.form.js', 'path' => JS_PATH);

        $this->js[] = array('file' => 'jquery/ui/jquery-ui.min.js', 'path' => LIBS_PATH);
      
        
        $this->js[] = array('file' => 'gzadmin/plugins/daterangepicker/daterangepicker.js', 'path' => JS_PATH);
        $this->js[] = array('file' => 'admin.js?v=' . time(), 'path' => JS_PATH);
        $this->js[] = array('file' => 'loadingoverlay.js?v=' . time(), 'path' => JS_PATH);
       
        $this->js[] = array('file' => 'GzSponsoritem.js?v=' . time(), 'path' => JS_PATH);

    }

    function index()
    {
        GzObject::loadFiles('Model', array('sponsoritem'));
        $sponsoritemModel = new sponsoritemModel();
         $opts = array();
        $arr = $sponsoritemModel->getAll($opts);
        $this->tpl['arr'] = $arr;

 }

 //new save
 function sponsorcreate(){
    GzObject::loadFiles('Model', array('sponsoritem'));
    $sponsoritemModel = new sponsoritemModel();

    if (!empty($_POST['sponsorcreate'])) {

       try { $id = $sponsoritemModel->save(array_merge($_POST)); } catch (Throwable $e) { $_SESSION['status'] = $e->getMessage(); $id = null; }

        if (!empty($id)) {
            $_SESSION['status'] = 16;
        } else {
            $_SESSION['status'] = 17;
        }
        Util::redirect(INSTALL_URL . "SponsorItem/index");
    }

} 
 //end


    // function for create sankalpa  puja price admin end. 
    function sankalpapricecreate(){
        GzObject::loadFiles('Model', array('SankalpaPujaPrice'));
        $SankalpaPujaPriceModel = new SankalpaPujaPriceModel();

        if (!empty($_POST['sankalpapricecreate'])) {

            try { $id = $SankalpaPujaPriceModel->save(array_merge($_POST)); } catch (Throwable $e) { $_SESSION['status'] = $e->getMessage(); $id = null; }

            if (!empty($id)) {
                $_SESSION['status'] = 16;
            } else {
                $_SESSION['status'] = 17;
            }
            Util::redirect(INSTALL_URL . "Pujaregistration/index");
        }

    }
   

    function sponsoritemedit(){
        GzObject::loadFiles('Model', array('sponsoritem'));
        $sponsoritemModel = new sponsoritemModel();

        if (!empty($_POST['sponsoritemedit'])) {

            $data = array();
            try { $id = $sponsoritemModel->update(array_merge($_POST)); } catch (Throwable $e) { $_SESSION['status'] = $e->getMessage(); $id = null; }

            if (!empty($id)) {
                $_SESSION['status'] = 20;
            } else {
                $_SESSION['status'] = 21;
            }

            if (!$this->isAdmin()) {
                Util::redirect(INSTALL_URL . "Admin/dashboard");
            } else {
                Util::redirect(INSTALL_URL . "SponsorItem/index");
            }
        }
        $id = $_GET['id'] ?? '';
        $arr = $sponsoritemModel->get($id);
        $this->tpl['arr'] = $arr;

    }

    function delete()
    {
        $this->isAjax = true;
        $id = ($_REQUEST['id'] ?? '');
        $cat = ($_REQUEST['cat'] ?? '');

        GzObject::loadFiles('Model', array('sponsoritem'));
        $sponsoritemModel = new sponsoritemModel();
        

        if($cat == 1){
            try {
                $sponsoritemModel->deleteFrom($sponsoritemModel->getTable())
                 ->where('id', $id)->execute();
            } catch (Throwable $e) { $_SESSION['status'] = $e->getMessage(); }
        }
       

        $opts = array();
        Util::redirect(INSTALL_URL . "SponsorItem/index");

    }

    function SponsorshipReport()
    {
        GzObject::loadFiles('Model', array('itemspujasponsor','Member'));
        $itemspujasponsorModel = new itemspujasponsorModel();
        $MemberModel = new MemberModel();
        
        $opts = array();
        $sponsorItemArr = $itemspujasponsorModel->getSposnorRecord($opts);
        $this->tpl['sponsorItemArr'] = $sponsorItemArr;

    }
    
     function SponsorshipItemProcess()
    {
        // GzObject::loadFiles('Model', array('itemspujasponsor','Member'));
        // $itemspujasponsorModel = new itemspujasponsorModel();
        // $MemberModel = new MemberModel();

        // $opts = array();
        // $sponsorItemArr = $itemspujasponsorModel->getSposnorRecord($opts);
        // $this->tpl['sponsorItemArr'] = $sponsorItemArr;



        GzObject::loadFiles('Model', array('itemspujasponsor', 'sponsoritem'));

        $itemspujasponsorModel = new itemspujasponsorModel();

        $sponsoritemModel = new sponsoritemModel();


        $CategoryAarr = $sponsoritemModel->sponsorCategoryA();
        $this->tpl['sponsorItemArrA'] = $CategoryAarr;

        $CategoryBarr = $sponsoritemModel->sponsorCategoryB();
        $this->tpl['sponsorItemArrB'] = $CategoryBarr;


        if (!empty($_POST['sponsarshipitemprocess'])) {

            date_default_timezone_set("America/Chicago");
            $today = date("Y/m/d");
            $_POST['Paydate'] = $today;

            try { $itemspujasponsorModel->save($_POST); } catch (Throwable $e) { $_SESSION['status'] = $e->getMessage(); }
        }



    }


   
    }


?>
