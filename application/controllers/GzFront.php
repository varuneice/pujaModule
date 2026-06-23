<?php

set_time_limit(0);
require_once CONTROLLERS_PATH . 'App.php';
date_default_timezone_set("America/Chicago");

class GzFront extends App {

    //var $icase ='old';
    var $layout = 'front';
    var $default_captcha = 'GzCaptcha';

    function beforeFilter() {

        if (isset($_REQUEST['lang'])) {

            GzObject::loadFiles('Model', array('Languages'));
            $LanguagesModel = new LanguagesModel();

            $default_language = $LanguagesModel->getAll(array('id' => $_REQUEST['lang']), 'order');

            if (!empty($default_language[0])) {
                $this->setLanguage($default_language[0]);
                $this->tpl['select_language'] = $this->getLanguage();
            } else {
                $this->setLanguage($this->tpl['default_language']);
                $this->tpl['select_language'] = $this->getLanguage();
            }
        } else {

            if (!$this->getLanguage() || !is_array($this->getLanguage())) {
                $this->setLanguage($this->tpl['default_language']);
            }
            $this->tpl['select_language'] = $this->getLanguage();
        }

        GzObject::loadFiles('Model', array('Calendar', 'Option'));
        $CalendarModel = new CalendarModel();
        $OptionModel = new OptionModel();

        if (!empty($_GET['cid'])) {
            $opts = array();
            $opts['calendar_id'] = $_GET['cid'] ?? '';

            $this->tpl['option_arr_values'] = $OptionModel->getAllPairValues($opts);

            $this->tpl['calendar'] = $CalendarModel->getI18n($_GET['cid'] ?? '');
        } else {

            $this->tpl['calendar'] = $CalendarModel->getI18n();
        }
    }

    /**
     * (non-PHPdoc)
     * @see core/framework/Controller::beforeRender()
     */
    function beforeRender() {
        $this->css[] = array('file' => 'front/style.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'front/gz-production.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'gzadmin/plugins/lada/ladda-themeless.min.css', 'path' => JS_PATH);
        $this->css[] = array('file' => 'gzadmin/plugins/tooltipster/css/tooltipster.css', 'path' => JS_PATH);
        $this->css[] = array('file' => 'gzadmin/plugins/tooltipster/css/themes/tooltipster-light.css', 'path' => JS_PATH);
        $this->css[] = array('file' => 'gzadmin/plugins/lada/prism.css', 'path' => JS_PATH);
        foreach (($_GET['cid'] ?? []) as $cid) {
            $this->css[] = array('file' => 'index.php?controller=GzFront&action=GzABCCss&cid=' . $cid, 'path' => '');
        }
        $this->js[] = array('file' => 'jquery-2.0.2.min.js', 'path' => LIBS_PATH);
        //$this->js[] = array('file' => 'gzadmin/bootstrap.min.js', 'path' => JS_PATH);
        $this->js[] = array('file' => 'jquery-ui.js', 'path' => LIBS_PATH);
        $this->js[] = array('file' => 'jquery/jquery-validation-1.13.0/dist/jquery.validate.min.js', 'path' => LIBS_PATH);
        $this->js[] = array('file' => 'jquery.colorbox-min.js', 'path' => LIBS_PATH);
        $this->js[] = array('file' => 'gzadmin/plugins/lada/spin.min.js', 'path' => JS_PATH);
        $this->js[] = array('file' => 'gzadmin/plugins/lada/ladda.min.js', 'path' => JS_PATH);
        $this->js[] = array('file' => 'gzadmin/plugins/tooltipster/js/jquery.tooltipster.min.js', 'path' => JS_PATH);
        $this->js[] = array('file' => '', 'path' => 'https://js.stripe.com/v3/', 'remote' => 1);
        $this->js[] = array('file' => 'load.js?v=' . time(), 'path' => JS_PATH);
        $this->js[] = array('file' => 'loadingoverlay.js?v=' . time(), 'path' => JS_PATH);
        $this->js[] = array('file' => 'options.js?v=' . time(), 'path' => JS_PATH);
    }

    function captcha($renew = null) {
        $this->isAjax = true;

        GzObject::loadFiles('component', 'Captcha');
        $Captcha = new Captcha('application/web/fonts/Fishfingers.ttf', 'GzScripts', $this->default_captcha, 6);
        $Captcha->setFileName('application/web/img/captcha/45-degree-fabric.png');
        $renew = isset($_GET['renew']) ? $_GET['renew'] ?? '' : null;
        $Captcha->create($renew);
    }

    /**
     * Write given $content to file
     *
     * @param string $content
     * @param string $filename If omitted use 'payment.log'
     * @access public
     * @return void
     * @static
     */
    
    function string_between_two_string($str, $starting_word, $ending_word) {

        $subtring_start = strpos($str, $starting_word);
        //Adding the starting index of the starting word to
        //its length would give its ending index
        $subtring_start += strlen($starting_word);
        //Length of our required sub string
        $size = strpos($str, $ending_word, $subtring_start) - $subtring_start;
        // Return the substring from the index substring_start of length size
        return substr($str, $subtring_start, $size);
    }

    function removeTableIfImg($matches) {
        $table = $matches[0];
        return preg_match('/<img\b[^>]*>/i', $table, $img) ? preg_replace('/<\/?(?:table|td|tr)\b[^>]*>\s*/i', '', $table) : $table;
    }

    private function zelleMailLog($message, $context = array())
    {
        $root = defined('INSTALL_PATH') ? rtrim(INSTALL_PATH, "/\\") : dirname(__DIR__, 2);
        $logFile = $root . DIRECTORY_SEPARATOR . 'zelle_mail_debug.log';
        $safeContext = array();
        foreach ((array)$context as $key => $value) {
            if (stripos($key, 'pass') !== false || stripos($key, 'password') !== false) {
                continue;
            }
            $safeContext[$key] = $value;
        }
        $line = '[' . date('Y-m-d H:i:s') . '] ' . $message;
        if (!empty($safeContext)) {
            $line .= ' | ' . json_encode($safeContext);
        }
        @file_put_contents($logFile, $line . PHP_EOL, FILE_APPEND | LOCK_EX);
    }
    
    function getConfirmationCode() {
        $this->setIsAjax(true);
        $email_address = 'treasurerpuja@durgabari.org';
        $app_password = 'ggtfnczdodeukgzp';
        $paymentfrom = 'pujaregistration';
        $dateMail = date("d-M-Y", strtotime("-7 days"));
        $transactionList = array();

        $this->zelleMailLog('Starting Zelle mail read using cURL IMAPS', array(
            'email_address' => $email_address,
            'paymentfrom' => $paymentfrom,
            'date_from' => $dateMail
        ));

        if (!function_exists('curl_init')) {
            $this->zelleMailLog('PHP cURL extension is not available; curl_init function missing');
            return $transactionList;
        }

        $curlVersion = curl_version();
        $protocols = isset($curlVersion['protocols']) && is_array($curlVersion['protocols']) ? $curlVersion['protocols'] : array();
        if (!in_array('imaps', $protocols, true)) {
            $this->zelleMailLog('cURL IMAPS protocol is not available', array('protocols' => implode(',', $protocols)));
            return $transactionList;
        }

        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => 'imaps://imap.gmail.com:993/INBOX',
            CURLOPT_USERPWD => $email_address . ':' . str_replace(' ', '', $app_password),
            CURLOPT_CUSTOMREQUEST => 'SEARCH SUBJECT "You received money with Zelle" SINCE "' . $dateMail . '"',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_CONNECTTIMEOUT => 15,
            CURLOPT_TIMEOUT => 45,
        ));

        $searchResult = curl_exec($ch);
        if ($searchResult === false || curl_errno($ch)) {
            $this->zelleMailLog('cURL IMAPS search failed', array(
                'curl_errno' => curl_errno($ch),
                'curl_error' => curl_error($ch),
                'http_code' => curl_getinfo($ch, CURLINFO_RESPONSE_CODE)
            ));
            curl_close($ch);
            return $transactionList;
        }

        $searchResult = str_replace('* SEARCH', '', $searchResult);
        $messageIds = array_filter(array_map('trim', explode(' ', trim($searchResult))));
        if (empty($messageIds)) {
            $this->zelleMailLog('No Zelle emails found by cURL IMAPS search', array('raw_search_result' => trim($searchResult)));
            curl_close($ch);
            return $transactionList;
        }

        foreach (array_reverse($messageIds) as $msgId) {
            if ($msgId === '' || !is_numeric($msgId)) {
                continue;
            }

            curl_setopt_array($ch, array(
                CURLOPT_URL => 'imaps://imap.gmail.com:993/INBOX;MAILINDEX=' . $msgId,
                CURLOPT_CUSTOMREQUEST => null,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CONNECTTIMEOUT => 15,
                CURLOPT_TIMEOUT => 45,
            ));

            $message = curl_exec($ch);
            if ($message === false || curl_errno($ch)) {
                $this->zelleMailLog('cURL IMAPS fetch failed', array(
                    'message_id' => $msgId,
                    'curl_errno' => curl_errno($ch),
                    'curl_error' => curl_error($ch)
                ));
                continue;
            }

            $message = preg_replace('/<style[^>]*>.*?<\/style>/s', '', $message);
            $message = strip_tags($message);
            $message = preg_replace('/\s+/', ' ', $message);
            $message = preg_replace('/=[\dA-Fa-f]{2}/', '', $message);

            $confirmation = preg_match('/Confirmation:\s*([\S]+)/', $message, $m) ? strip_tags($m[1]) : '';
            $amount = preg_match('/sent you \s*([^\r\n]+?)\s*Date:/', $message, $m) ? strip_tags($m[1]) : '';
            $amount = rtrim(rtrim($amount, '0'), '.');
            $amount = str_replace(',', '', $amount);
            $amount = str_replace(')', '', $amount);
            $memo = preg_match('/Memo: ([^\r\n]{1,50})/', $message, $m) ? strip_tags($m[1]) : '';
            $date = preg_match('/Date:\s*([\d\/]+)/', $message, $m) ? strip_tags($m[1]) : '';
            $name = preg_match('/Wells Fargo Alert\s*([^\r\n]+?)\s*sent you/', $message, $m) ? strip_tags($m[1]) : '';
            $name = str_replace("'", '', $name);
            $timestamp = strtotime(trim($date));

            $transactionList[] = array(
                'Paydate' => $timestamp ? date("Y-m-d", $timestamp) : '',
                'Amount' => $amount,
                'ConfirmationCode' => $confirmation,
                'Description' => $memo,
                'DonarName' => $name,
                'paymentfrom' => $paymentfrom
            );
        }

        curl_close($ch);
        $this->zelleMailLog('Finished cURL Zelle mail read', array('transactions_parsed' => count($transactionList)));
        return $transactionList;
    
    }
    

   function getConfirmationCodeoldFormatCode() {
        $this->setIsAjax(true);
        //$z[] = 0;
        date_default_timezone_set("America/Chicago");
        $conn = imap_open('{imap.gmail.com:993/imap/ssl}INBOX', 'treasurerpuja@durgabari.org', 'ggtfnczdodeukgzp') or die('Cannot connect to Gmail: ' . imap_last_error());
        //$conn = imap_open('{imap.gmail.com:993/imap/ssl}INBOX', 'paras.sharma@eiceinternational.com', '9319648110@8619') or die('Cannot connect to Gmail: ' . imap_last_error());
        $dateMail = date ( "d M Y", strToTime ( "-7 days" ) );
        //$dateMail1 = date ( "d M Y", strToTime ( "+1 hours" ) );
         $dateMail1 = date ( "d M Y", strToTime ( "+2 days" ) );
        //$some   = imap_search($conn, 'SUBJECT "You received money with Zelle"" SINCE "$date"', SE_UID);
       // $mails = imap_search($conn, 'SUBJECT "You received money with Zelle" ON "' . $dateMail . '"');
        $mails = imap_search($conn,'SUBJECT "You received money with Zelle" SINCE "'.$dateMail.'" BEFORE "'.$dateMail1.'"');
       
        //$mails = imap_search($conn, 'SUBJECT "SUBJECT "You sent money with Zelle" ON "' . $dateMail . '"');
        //$mails = imap_search($conn, 'SUBJECT "You sent money with Zelle"');
        //$mails = imap_search($conn, 'SUBJECT "You received money with Zelle"');
        if ($mails) {

            /* Mail output variable starts */

            // rsort is used to display the latest emails on top /
            rsort($mails);
            $items = array();
            // For each email /
            foreach ($mails as $email_number) {
               //if ($email_number == 7418){
                /* Retrieve specific email information */
                $headers = imap_fetch_overview($conn, $email_number, 0);
                //if ($headers[0]->seen == 1){
                //if ($headers[0]->recent == 1) {
                    //$read = "Yes";
                 
                    // if ($headers->Subject == "SUBJECT "You received money with Zelle") {
                
                    //    //Note 5
                    //     //Run code to parse body information
                    // }
                    /* Returns a particular section of the body */
                    $message = imap_fetchbody($conn, $email_number, '1');
                    //$html = preg_replace_callback('/<table\b[^>]*>.*?<\/table>/si', 'removeTableIfImg', $message);

                    $subMessage = substr($message, 1500, 3000); // Sukhitest
                    $finalMessage1 = trim(quoted_printable_decode($subMessage));
                    // $message2 = imap_fetchbody($conn, $email_number, '1.2');
                    // $removehtmltags= htmlspecialchars($subMessage);// Sukhitest
                    $removehtmltags_Striptag = strip_tags($subMessage);
                    $removehtmltags_Striptag_result = str_replace("=20", '', trim($removehtmltags_Striptag));
                    $whatIWant = substr($subMessage, "You received money with Zelle=C2=AE");
                    $whatIWant1 = substr($subMessage, strpos($subMessage, "You received money with Zelle=C2=AE") - 1);
                    $variable = substr($whatIWant1, 0, strpos($whatIWant1, "XXXXXX2631"));
                    $variable1 = substr($variable, -1, strpos($variable, "You received money with Zelle���"));
                    $finalMessage = trim(quoted_printable_decode($subMessage));
                    $substring = $this->string_between_two_string($finalMessage, 'sent you money. Here are the details:', 'This money has been deposited in your Wells Fargo account XXXXXX2631.');
                    var_dump($finalMessage);


                    $newstr = str_replace("'", '', $substring);
                    $str = str_replace(' ', "", $newstr);
                    // Taking all 4 values from the form data(input)
                    $Date = date("Y-m-d", strtotime($headers[0]->date));
                   // $Date = date("Y/m/d");
                    $FinalDate = $this->string_between_two_string($removehtmltags_Striptag_result, 'Date', 'Amount');
                    $Donar = $this->string_between_two_string($removehtmltags_Striptag_result, 'You received money with Zelle=C2=AE', 'sent you money.');
                    $FinalAmount = $this->string_between_two_string($removehtmltags_Striptag_result, 'Amount', '.00');
                    $Amount = trim($FinalAmount);
                    $dsk = strstr($removehtmltags_Striptag_result, 'Description' );
                    if($dsk!=null ||$dsk!="")
                    {
                        $FinalConfirmationCode = $this->string_between_two_string($removehtmltags_Striptag_result, 'Confirmation Code', 'Description');
                        $ConfirmationCode = trim($FinalConfirmationCode);
                    //$Description = substr($str, strpos($removehtmltags_Striptag_result, "Description")  +13);
                    //$Description = $this->string_between_two_string($removehtmltags_Striptag_result, 'Description', 'This');
                    $Description = $this->string_between_two_string($removehtmltags_Striptag_result, 'Description', '=09=09=09');
                    //$Description  = $this->string_between_two_string($removehtmltags_Striptag_result, 'Description=', 'will receive');
                    $FinalDescription = trim($Description);
                    }else{
                        $FinalConfirmationCode = $this->string_between_two_string($removehtmltags_Striptag_result, 'Confirmation Code', '=09=09=09'); 
                        $ConfirmationCode = trim($FinalConfirmationCode);
                    //$Description = substr($str, strpos($removehtmltags_Striptag_result, "Description")  +13);
                    //$Description = $this->string_between_two_string($removehtmltags_Striptag_result, 'Description', 'This');
                    $Description = $this->string_between_two_string($removehtmltags_Striptag_result, 'Description', '=09=09=09');
                    //$Description  = $this->string_between_two_string($removehtmltags_Striptag_result, 'Description=', 'will receive');
                    $FinalDescription = trim($Description);
                    
                    }
                    //$FinalConfirmationCode =   $this->string_between_two_string($removehtmltags_Striptag_result, 'Confirmation code', 'Description=');
                    $FinalDesc = preg_replace('/[^a-zA-Z0-9\s]/', '', $FinalDescription);
                    $FinalNewDescription =trim($FinalDesc);
                    $name = preg_replace('/[^a-zA-Z0-9\s]/', '', $Donar);
                    $DonarName =trim($name);
                    $timestamp = strtotime(trim($FinalDate));
                    $Paydate = $timestamp ? date("Y-m-d", $timestamp) : ''; 
                    $paymentfrom  = 'pujaregistration';
                    $items[] = [$Paydate, $Amount, $ConfirmationCode, $FinalNewDescription,$DonarName,$paymentfrom];
                //}
            }
            // imap connection is closed /
       // }
        //echo("<script type='text/javascript'> alert('".$items[0][4]."'); </script>");

    }

        imap_close($conn);
        return $items;
    }



    function ReceiptSave($GetData) {
        // Use PDO with prepared statements — eliminates SQL injection risk.
        try {
            $pdo = gz_pdo_connect(DEFAULT_HOST, DEFAULT_USER, DEFAULT_PASS, DEFAULT_DB);
        } catch (\PDOException $e) {
            error_log('[ReceiptSave] DB connection failed: ' . $e->getMessage());
            return false;
        }

        // INSERT only if no row with the same Confirmation code already exists.
        $sql = "INSERT INTO confirm_code (date, Confirmation, Amount, Description, DonarName, UpdatedOn, paymentfrom)
                SELECT ?, ?, ?, ?, ?, NULL, ?
                FROM DUAL
                WHERE NOT EXISTS (
                    SELECT 1 FROM confirm_code WHERE Confirmation = ?
                )";

        try {
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                $GetData['Paydate']           ?? '',
                $GetData['ConfirmationCode']  ?? '',
                $GetData['Amount']            ?? '',
                $GetData['Description']       ?? '',
                $GetData['DonarName']         ?? '',
                $GetData['paymentfrom']       ?? '',
                $GetData['ConfirmationCode']  ?? '',
            ]);
            return $stmt->rowCount() > 0;
        } catch (\PDOException $e) {
            error_log('[ReceiptSave] Query failed: ' . $e->getMessage());
            return false;
        }
    }

    function UpdateCodeData() {
        $this->setIsAjax(true);
        $cmCode=$_POST['code'] ?? '';
        GzObject::loadFiles('Model', array('ConfirmCode'));
        $ConfirmCodeModel = new ConfirmCodeModel();
        $arr = array();
        $arr= $ConfirmCodeModel->UpdateCode($cmCode);
        echo '<span class="success_code">' . __('Your payment code is matched you can book') . '</span>';
    }
    function checkCodeDD() {
        $this->setIsAjax(true);
        GzObject::loadFiles('Model', array('ConfirmCode'));
        $ConfirmCodeModel = new ConfirmCodeModel();
        $arr = array();
        $donorName = trim($_REQUEST['donor_name'] ?? '');
        $zelleAmount = trim($_REQUEST['zelle_amount'] ?? '');
        $zelleDate = trim($_REQUEST['zelle_date'] ?? '');
        if ($donorName === '' || $zelleAmount === '' || $zelleDate === '') {
            echo 'NO_MATCH';
            return;
        }
        $arr= $ConfirmCodeModel->getByPaymentDate($zelleDate);
        $this->tpl['Amount'] =  $arr;
        $normalize = function ($value) {
            $value = strtolower((string) $value);
            $value = preg_replace('/[^a-z0-9\s]/', ' ', $value);
            return trim(preg_replace('/\s+/', ' ', $value));
        };
        $nameMatches = function ($zelleName, $searchName) use ($normalize) {
            $zelleName = $normalize($zelleName);
            $searchName = $normalize($searchName);
            if ($zelleName === '' || $searchName === '') {
                return false;
            }
            if ($zelleName === $searchName) {
                return true;
            }
            if (strpos($zelleName, $searchName) !== false || strpos($searchName, $zelleName) !== false) {
                return true;
            }

            $zelleTokens = array_values(array_unique(array_filter(explode(' ', $zelleName))));
            $searchTokens = array_values(array_unique(array_filter(explode(' ', $searchName))));
            if (empty($zelleTokens) || empty($searchTokens)) {
                return false;
            }

            $matches = array_intersect($zelleTokens, $searchTokens);
            $requiredMatches = min(count($zelleTokens), count($searchTokens), 2);
            return count($matches) >= $requiredMatches;
        };
        $amountValue = preg_replace('/[^\d.]/', '', $zelleAmount);
        $requestDate = $zelleDate !== '' ? strtotime($zelleDate) : false;
        $matchCount = 0;

        foreach ($arr as $key => $value) {
            $optionText = $value['Amount'];
            $parts = explode('/', $optionText);
            $dateOk = false;
            $nameOk = false;
            $amountOk = false;

            $nameOk = $nameMatches($parts[1] ?? '', $donorName);

            $optionAmount = preg_replace('/[^\d.]/', '', $parts[2] ?? '');
            $amountOk = ($optionAmount !== '' && (float) $optionAmount == (float) $amountValue);

            $optionDate = strtotime(trim($parts[0] ?? ''));
            $dateOk = ($requestDate !== false && $optionDate !== false && date('Y-m-d', $optionDate) === date('Y-m-d', $requestDate));

            if ($nameOk && $amountOk && $dateOk) {
                $safeOption = htmlspecialchars($optionText, ENT_QUOTES, 'UTF-8');
                echo '<option value="'.$safeOption.'">'.$safeOption. '</option>';
                $matchCount++;
            }
        }

        if ($matchCount === 0) {
            echo 'NO_MATCH';
        }
        
    }

 function sortFunction( $a, $b ) {
        return strtotime($b["date"]) - strtotime($a["date"]);
    }
   function checkCode() {
        $this->setIsAjax(true);

        try {
            $this->isAjax = true;
            GzObject::loadFiles('Model', array('ConfirmCode'));
            $ConfirmCodeModel = new ConfirmCodeModel();
            $arr = array();
            $z = $this->getConfirmationCode();
            // $i=0;
            foreach ($z as $payment_code) {
             
                $arr= $ConfirmCodeModel->getConfirmCodeCheck($payment_code['ConfirmationCode']);
                if (empty($arr) ) {
                    $result = $this->ReceiptSave($payment_code);
                }
            
                        
                
            }
        if ($result == true) {
                // echo("<meta http-equiv='refresh' content='1'>");
                //echo '<script>alert("Your payment code is matched you can book")</script>';
                echo '<span class="success_code">' . __('Your payment code is matched you can book') . '</span>';
            } else {
                //echo '<script>alert("This code has not find in mail used used for another booking. Please provide another code, or else contact admin")</script>';

                echo '<span class="error_code">' . __('This code has not find in mail used used for another booking. Please provide another code, or else contact admin') . '</span>';
            }
        
        } catch (Exception $ex) {
            // jump to this part
            // if an exception occurred
        }
    }

}
