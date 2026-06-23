<?php

require_once CONTROLLERS_PATH . 'App.php';

class donationdata extends App
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
        $this->js[] = array('file' => 'ajax-upload/das.js', 'path' => JS_PATH);
        $this->js[] = array('file' => 'ajax-upload/jquery.form.js', 'path' => JS_PATH);

        $this->js[] = array('file' => 'jquery/ui/jquery-ui.min.js', 'path' => LIBS_PATH);

        $this->js[] = array('file' => 'gzadmin/plugins/daterangepicker/daterangepicker.js', 'path' => JS_PATH);

        $this->js[] = array('file' => 'admin.js?v=' . time(), 'path' => JS_PATH);

        $this->js[] = array('file' => 'GzMember.js?v=' . time(), 'path' => JS_PATH);

        $this->js[] = array('file' => 'loadingoverlay.js?v=' . time(), 'path' => JS_PATH);
    }




    function index()
    {
        GzObject::loadFiles('Model', array('Donationnewview'));
        $DonationnewviewModel = new DonationnewviewModel();

        $opts = array();
        $Donationarr = $DonationnewviewModel->DonationAll($opts);
        $this->tpl['Donationarr'] = $Donationarr;

        $emarald = $DonationnewviewModel->emrald();
        $this->tpl['emarald'] = $emarald;



        $diamond = $DonationnewviewModel->Diamond();
        $this->tpl['diamond'] = $diamond;

        $DonationarrParking = $DonationnewviewModel->donationAllwithParking($opts);
        //  $this->tpl['Donationarr'] = $DonationarrParking;
        //  print_r($DonationarrParking);

        $projectedDiamond = $DonationnewviewModel->projectedDiamond();
        $this->tpl['projectedDiamond'] = $projectedDiamond;

        $projectedEmerald = $DonationnewviewModel->projectedEmrald();
        $this->tpl['projectedEmerald'] = $projectedEmerald;


    }

    public function export()
    {
        GzObject::loadFiles('Model', array('Donation'));
        $DonationModel = new DonationModel();

        $opts = array();
        $data = $DonationModel->ExportDonationRecord($opts);

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=puja_data_export.csv');

        $output = fopen('php://output', 'w');

        if (!empty($data)) {
            $columns = array_keys($data[0]);
            fputcsv($output, $columns, ',', '"', '\\');
        }

        foreach ($data as $row) {
            fputcsv($output, $row, ',', '"', '\\');
        }

        fclose($output);
        exit;
    }

    public function exportE()
    {
        GzObject::loadFiles('Model', array('Donationnewview'));
        $DonationnewviewModel = new DonationnewviewModel();
        $opts = array();
        $data = $DonationnewviewModel->emrald();

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=Emaralddata_export.csv');

        $output = fopen('php://output', 'w');

        if (!empty($data)) {
            $columns = array_keys($data[0]);
            fputcsv($output, $columns, ',', '"', '\\');
        }

        foreach ($data as $row) {
            fputcsv($output, $row, ',', '"', '\\');
        }

        fclose($output);
        exit;
    }


    public function exportD()
    {
        GzObject::loadFiles('Model', array('Donationnewview'));
        $DonationnewviewModel = new DonationnewviewModel();

        $opts = array();
        $data = $DonationnewviewModel->Diamond();

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=diamonddata_export.csv');

        $output = fopen('php://output', 'w');

        if (!empty($data)) {
            $columns = array_keys($data[0]);
            fputcsv($output, $columns, ',', '"', '\\');
        }

        foreach ($data as $row) {
            fputcsv($output, $row, ',', '"', '\\');
        }

        fclose($output);
        exit;
    }
    public function exportProjectedDiamond()
    {
        GzObject::loadFiles('Model', array('Donationnewview'));
        $DonationnewviewModel = new DonationnewviewModel();

        $opts = array();
        $data = $DonationnewviewModel->projectedDiamond();

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=projectedDiamond_export.csv');

        $output = fopen('php://output', 'w');

        if (!empty($data)) {
            $columns = array_keys($data[0]);
            fputcsv($output, $columns, ',', '"', '\\');
        }

        foreach ($data as $row) {
            fputcsv($output, $row, ',', '"', '\\');
        }

        fclose($output);
        exit;
    }

    public function exportProjectedEmerald()
    {
        GzObject::loadFiles('Model', array('Donationnewview'));
        $DonationnewviewModel = new DonationnewviewModel();

        $opts = array();
        $data = $DonationnewviewModel->projectedEmrald();

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=projectedEmerald_export.csv');

        $output = fopen('php://output', 'w');

        if (!empty($data)) {
            $columns = array_keys($data[0]);
            fputcsv($output, $columns, ',', '"', '\\');
        }

        foreach ($data as $row) {
            fputcsv($output, $row, ',', '"', '\\');
        }

        fclose($output);
        exit;
    }

}

?>