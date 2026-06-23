<?php
require_once FRAMEWORK_PATH . 'Object.class.php';

class Controller extends GzObject {

    var $tpl;
    var $js = array();
    var $css = array();
    var $default_user = 'admin_user';
    var $default_order = 'gz_shopping_cart_order';
    var $front_user = 'front_user';
    var $default_language = 'lang';
    var $default_product = 'time_slot_booking';
    var $layout = 'default';
    var $isAjax = false;

    function __construct() {
        
    }

    function beforeFilter() {
        
    }

    function beforeRender() {
        
    }

    function index() {
        
    }

    function isAjax() {
        return $this->isAjax;
    }

    function setIsAjax($bool) {
        $this->isAjax = $bool;
    }

    function getLayout() {
        return $this->layout;
    }

    function getLanguage() {
        return (!empty($_SESSION[$this->default_language])) ? $_SESSION[$this->default_language] : false;
    }

    function setLanguage($lang) {
        $_SESSION[$this->default_language] = $lang;
    }

    function getUserId() {
        return isset($_SESSION[$this->default_user]) && array_key_exists('id', $_SESSION[$this->default_user]) ? $_SESSION[$this->default_user]['id'] : false;
    }
    
    function getMemberId() {
        return isset($_SESSION[$this->default_user]) && array_key_exists('ID', $_SESSION[$this->default_user]) ? $_SESSION[$this->default_user]['ID'] : false;
    }

    function getFrontUserId() {
        return isset($_SESSION[$this->front_user]) && array_key_exists('id', $_SESSION[$this->front_user]) ? $_SESSION[$this->front_user]['id'] : false;
    }

    function getType() {
        return isset($_SESSION[$this->default_user]) && array_key_exists('type', $_SESSION[$this->default_user]) ? $_SESSION[$this->default_user]['type'] : false;
    }

    function isLoged() {
        if (isset($_SESSION[$this->default_user]) && count($_SESSION[$this->default_user]) > 0) {
            return true;
        }
        return false;
    }

    function isFrontLoged() {

        if (isset($_SESSION[$this->front_user]) && count($_SESSION[$this->front_user]) > 0) {
            return true;
        }
        return false;
    }

    function getFrontUser() {
        if (isset($_SESSION[$this->front_user]) && count($_SESSION[$this->front_user]) > 0) {
            return $_SESSION[$this->front_user];
        }
        return false;
    }

    function getUser() {
        if (isset($_SESSION[$this->default_user]) && count($_SESSION[$this->default_user]) > 0) {
            return $_SESSION[$this->default_user];
        }
        return false;
    }

      function isAdmin() {
        return $this->getType() == 1;
    }
    function isEditor() {
        return $this->getType() == 3;
    }
    function isMember() {
        return @$_SESSION[$this->default_user]['is_member'] == 1;
    }
     function isVolunteer() {
        return $this->getType() == 5;
    }

    function isParkingAdmin() {
        return $this->getType() == 6;
    }
    
    function isBadgesVolunteer() {
        return $this->getType() == 7;
    }

    function isBadgesAdmin() {
        return $this->getType() == 8;
    }
    
    function isFoodcouponVolunteer() {
        return $this->getType() == 9;
    }

    function isFoodcouponAdmin() {
        return $this->getType() == 10;
    }
    
    function isViewer() {
        return $this->getType() == 15;
    }
    
    function isMerchandiseViewer() {
        return $this->getType() == 17;
    }
    
    function isMerchandiseEditor() {
      return $this->getType()==18;
    }

    function isXHR() {
        return @$_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
    }

    function getRandomPassword($n = 6, $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890'): string {
        $m            = strlen($chars) - 1;
        $randPassword = '';
        while ($n--) {
            $randPassword .= $chars[random_int(0, $m)];
        }
        return $randPassword;
    }

    function setDefaultProduct($str) {
        $this->default_product = $str;
        return $this;
    }

}