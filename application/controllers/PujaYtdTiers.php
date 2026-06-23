<?php

require_once CONTROLLERS_PATH . 'App.php';

class PujaYtdTiers extends App
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

        if (!$this->isLoged()) {
            $_SESSION['err'] = 2;
            Util::redirect(INSTALL_URL . "Admin/login");
        }

        $this->css[] = array('file' => 'front/style.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'admin/gzstyling/bootstrap.min.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'admin/gzstyling/font-awesome.min.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'admin/gzstyling/ionicons.min.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'admin/gzstyling/gzstyle.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'ui-custom.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'admin/admin.css', 'path' => CSS_PATH);

        $this->js[] = array('file' => 'jquery/jquery-1.9.1.min.js', 'path' => LIBS_PATH);
        $this->js[] = array('file' => 'gzadmin/bootstrap.min.js', 'path' => JS_PATH);
        $this->js[] = array('file' => 'gzadmin/plugins/datatables/jquery.dataTables.js', 'path' => JS_PATH);
        $this->js[] = array('file' => 'gzadmin/plugins/datatables/dataTables.bootstrap.js', 'path' => JS_PATH);
        $this->js[] = array('file' => 'gzadmin/gzadmin/app.js', 'path' => JS_PATH);
        $this->js[] = array('file' => 'admin.js?v=' . time(), 'path' => JS_PATH);
    }

    function index()
    {
        GzObject::loadFiles('Model', array('pujaytdtier', 'pujaregistrationsetting'));
        $PujaYtdTierModel = new pujaytdtierModel();
        $PujaRegistrationSettingModel = new pujaregistrationsettingModel();

        try {
            $PujaYtdTierModel->ensureTable();
            $PujaYtdTierModel->seedDefaults(date('Y'));
            $PujaRegistrationSettingModel->ensureTable();
            $PujaRegistrationSettingModel->seedDefaults(date('Y'));
        } catch (Throwable $e) {
            $_SESSION['status'] = $e->getMessage();
        }

        if (!empty($_POST['save_ytd_tiers']) && !empty($_POST['tiers']) && is_array($_POST['tiers'])) {
            foreach ($_POST['tiers'] as $tier) {
                try {
                    $PujaYtdTierModel->updateTier($tier);
                } catch (Throwable $e) {
                    $_SESSION['status'] = $e->getMessage();
                }
            }
            Util::redirect(INSTALL_URL . "PujaYtdTiers/index");
        }

        if (!empty($_POST['save_registration_settings']) && !empty($_POST['settings']) && is_array($_POST['settings'])) {
            foreach ($_POST['settings'] as $setting) {
                try {
                    $PujaRegistrationSettingModel->updateSetting($setting);
                } catch (Throwable $e) {
                    $_SESSION['status'] = $e->getMessage();
                }
            }
            Util::redirect(INSTALL_URL . "PujaYtdTiers/index");
        }

        if (!empty($_POST['add_ytd_tier'])) {
            try {
                $PujaYtdTierModel->addTier($_POST);
            } catch (Throwable $e) {
                $_SESSION['status'] = $e->getMessage();
            }
            Util::redirect(INSTALL_URL . "PujaYtdTiers/index");
        }

        $this->tpl['tiers'] = $PujaYtdTierModel->getAllTiers();
        $this->tpl['settings'] = $PujaRegistrationSettingModel->getAllSettings();
    }

    function delete()
    {
        if (!$this->isAdmin()) {
            Util::redirect(INSTALL_URL . "PujaYtdTiers/index");
        }

        GzObject::loadFiles('Model', array('pujaytdtier'));
        $PujaYtdTierModel = new pujaytdtierModel();
        $id = (int) ($_REQUEST['id'] ?? 0);

        if ($id > 0) {
            try {
                $PujaYtdTierModel->deleteFrom($PujaYtdTierModel->getTable())->where('id', $id)->execute();
            } catch (Throwable $e) {
                $_SESSION['status'] = $e->getMessage();
            }
        }

        Util::redirect(INSTALL_URL . "PujaYtdTiers/index");
    }
}

?>
