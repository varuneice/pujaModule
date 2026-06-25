<?php

require_once CONTROLLERS_PATH . 'App.php';

class PujaCart extends App {

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

        $this->js[] = array('file' => '', 'path' => 'https://js.stripe.com/v3/', 'remote' => 1);

        $this->js[] = array('file' => 'GzPujacart.js?v=' . time(), 'path' => JS_PATH);
        $this->js[] = array('file' => 'multiselect-dropdown.js?v=' . time(), 'path' => JS_PATH);
        $this->js[] = array('file' => 'loadingoverlay.js?v=' . time(), 'path' => JS_PATH);
        
    }

    private function applyAdultChildRegistrationPricing(&$post) {
        $memberStatus = strtolower(trim($post['member_status'] ?? ''));
        if (!in_array($memberStatus, array('family', 'individual'), true) || empty($post['co_register_adult_members'])) {
            $this->clearAdultMemberRegistrationFields($post);
            $this->normalizeRegistrationTotalAmount($post);
            return;
        }

        $memberCategory = strtoupper(trim($post['membercategory'] ?? ($post['member_category'] ?? '')));
        if (($post['puja_category'] ?? '') !== 'member' || $memberCategory === '' || in_array($memberCategory, array('GD', 'GC'), true)) {
            $this->clearAdultMemberRegistrationFields($post);
            $this->normalizeRegistrationTotalAmount($post);
            return;
        }

        $requestedCount = isset($post['adult_member_count']) && is_numeric($post['adult_member_count']) ? (int) $post['adult_member_count'] : 0;
        $requestedCount = max(0, min($requestedCount, 3));
        $adultChildCount = $this->getEligibleAdultChildCount($post, $requestedCount);
        if ($adultChildCount <= 0) {
            $this->clearAdultMemberRegistrationFields($post);
            $this->normalizeRegistrationTotalAmount($post);
            return;
        }

        $unitPrice = $this->getAdultChildRegistrationUnitPrice($post);
        if ($unitPrice <= 0) {
            $this->clearAdultMemberRegistrationFields($post);
            $this->normalizeRegistrationTotalAmount($post);
            return;
        }
        $childAmount = $unitPrice * $adultChildCount;
        $adultRows = $this->extractAdultMemberRowsFromPost($post);

        $post['extraadultregistration'] = (string) $childAmount;
        $this->storeAdultMembersInRegistrationPost($post, $adultRows, $adultChildCount, $post['extraadultregistration']);
        $this->normalizeRegistrationTotalAmount($post);
    }

    private function normalizeRegistrationTotalAmount(&$post) {
        $donation = is_numeric($post['donation'] ?? '') ? (float) $post['donation'] : 0;
        $pujaAmount = is_numeric($post['puja_amount'] ?? '') ? (float) $post['puja_amount'] : (is_numeric($post['amount'] ?? '') ? (float) $post['amount'] : 0);
        $parentAmount = is_numeric($post['extraparentregistration'] ?? '') ? (float) $post['extraparentregistration'] : 0;
        $adultAmount = is_numeric($post['extraadultregistration'] ?? '') ? (float) $post['extraadultregistration'] : 0;
        $magazineAmount = is_numeric($post['extramagazineamount'] ?? '') ? (float) $post['extramagazineamount'] : (is_numeric($post['magazineprice'] ?? '') ? (float) $post['magazineprice'] : 0);
        $seniorDiscount = is_numeric($post['discountseniorprice'] ?? '') ? (float) $post['discountseniorprice'] : 0;

        $post['totalamount'] = $donation + $pujaAmount + $parentAmount + $adultAmount + $magazineAmount - $seniorDiscount;
    }

    private function clearAdultMemberRegistrationFields(&$post) {
        $this->clearAdultMemberStorageFields($post);
        $post['extraadultregistration'] = '';
    }

    private function getAdultChildBirthYearCutoff() {
        return 2003;
    }

    private function getEligibleAdultChildCount($post, $requestedCount = 0) {
        $cutoff = $this->getAdultChildBirthYearCutoff();
        $children = $this->extractAdultMemberRowsFromPost($post);
        if (empty($children)) {
            $children = array(
                array(
                    'first_name' => trim((string) ($post['adult1_fname'] ?? '')),
                    'last_name' => trim((string) ($post['adult1_lname'] ?? '')),
                    'birth_year' => isset($post['adult1_birth_year']) && is_numeric($post['adult1_birth_year']) ? (int) $post['adult1_birth_year'] : 0,
                ),
                array(
                    'first_name' => trim((string) ($post['adult2_fname'] ?? '')),
                    'last_name' => trim((string) ($post['adult2_lname'] ?? '')),
                    'birth_year' => isset($post['adult2_birth_year']) && is_numeric($post['adult2_birth_year']) ? (int) $post['adult2_birth_year'] : 0,
                ),
                array(
                    'first_name' => trim((string) ($post['adult3_fname'] ?? '')),
                    'last_name' => trim((string) ($post['adult3_lname'] ?? '')),
                    'birth_year' => isset($post['adult3_birth_year']) && is_numeric($post['adult3_birth_year']) ? (int) $post['adult3_birth_year'] : 0,
                ),
            );
        }
        $count = 0;
        $limit = max(0, min((int) $requestedCount, count($children), 3));
        for ($i = 0; $i < $limit; $i++) {
            $child = $children[$i];
            $birthYear = isset($child['birth_year']) && is_numeric($child['birth_year']) ? (int) $child['birth_year'] : 0;
            if ($birthYear <= $cutoff && $birthYear > 0 && trim((string) ($child['first_name'] ?? '')) !== '' && trim((string) ($child['last_name'] ?? '')) !== '') {
                $count++;
            }
        }
        return $count;
    }

    private function getAdultChildRegistrationUnitPrice($post) {
        try {
            GzObject::loadFiles('Model', array('pujaregistrationprice', 'pujaRegistrationDate'));
            $priceModel = new pujaregistrationpriceModel();
            try { $priceModel->ensureCurrentRegistrationRates(); } catch (Throwable $e) {}
            $dateModel = new pujaRegistrationDateModel();
            $pujaType = $post['puja_type'] ?? '';
            $priceFor = 'member';
            $memberCategory = trim($post['membercategory'] ?? ($post['member_category'] ?? ''));
            if (($post['puja_category'] ?? '') === 'nonmember') {
                $priceFor = ($memberCategory === '' || $memberCategory === 'GD' || $memberCategory === 'GC') ? 'nonmemberoot' : 'nonmember';
            } elseif ($memberCategory === 'GD' || $memberCategory === 'GC' || $memberCategory === '') {
                $priceFor = 'memberoot';
            }

            $row = $priceModel->getRegistrationPriceRow($pujaType, $priceFor, 'individual');
            $unitPrice = (float) ($row['price'] ?? 0);
            $dates = $dateModel->getAll();
            $lateFeeDate = $dates[0]['registrationDate'] ?? '';
            date_default_timezone_set("America/Chicago");
            if ($lateFeeDate !== '' && date("Y-m-d") > $lateFeeDate) {
                $unitPrice += (float) ($row['latefee'] ?? 0);
            }
            return $unitPrice;
        } catch (Throwable $e) {
            $this->logPujaCartError('getAdultChildRegistrationUnitPrice ERROR | ' . $e->getMessage());
            return 0;
        }
    }

    private function updateMemberAddressFromRegistrationPost($MemberModel, $source = 'Puja Registration') {
        $this->logPujaCartError('MEMBER ADDRESS UPDATE CHECK | member_id=' . ($_POST['Member_id'] ?? '') . ' | update_address=' . ($_POST['update_address'] ?? '') . ' | source=' . $source . ' | street=' . ($_POST['street'] ?? '') . ' | streetname=' . ($_POST['streetname'] ?? '') . ' | city=' . ($_POST['city'] ?? '') . ' | state=' . ($_POST['state'] ?? '') . ' | zip=' . ($_POST['zip'] ?? ''));

        if (empty($_POST['Member_id'])) {
            $this->logPujaCartError('MEMBER ADDRESS UPDATE SKIPPED | missing Member_id | update_address=' . ($_POST['update_address'] ?? '') . ' | source=' . $source);
            return false;
        }

        try {
            $updated = $MemberModel->updateAddressWithHistory($_POST['Member_id'], $_POST, $source);
            $this->logPujaCartError('MEMBER ADDRESS UPDATE ' . ($updated ? 'OK' : 'SKIPPED') . ' | member_id=' . ($_POST['Member_id'] ?? '') . ' | source=' . $source);
            return $updated;
        } catch (Throwable $e) {
            $this->logPujaCartError('MEMBER ADDRESS UPDATE ERROR | member_id=' . ($_POST['Member_id'] ?? '') . ' | ' . $e->getMessage());
            return false;
        }
    }


    function PujaCart_2July()
    {
        $this->setIsAjax(true);
       $this->layout = 'login';
       GzObject::loadFiles('Model', array('pujaregistration', 'Donation', 'ConfirmCode', 'Member', 'idnumbers', 'itemspujasponsor','User','sponsoritem'));
        $pujaregistrationModel = new pujaregistrationModel();
        try { $pujaregistrationModel->syncSchemaWithTableColumns(); } catch (Throwable $e) { $this->logPujaCartError('syncSchemaWithTableColumns ERROR | ' . $e->getMessage()); }
        $DonationModel = new DonationModel();
        $ConfirmCodeModel = new ConfirmCodeModel();
        $MemberModel = new MemberModel();
        $idnumbersModel = new idnumbersModel();
        $itemspujasponsorModel = new itemspujasponsorModel();
        $UserModel = new UserModel();
        $sponsoritemModel = new sponsoritemModel();

        $MemberId = $_POST['Member_id'] ?? '';
        $Senior = $_POST['senior'] ?? '';
        if($MemberId !="" && $Senior !=""){
            if($Senior == '1'){
                $SeniorCheck = 'YES';
                $MemberModel->UpdateSenior($MemberId, $SeniorCheck);
            } 
        }

        if (!empty($_POST['create_requestpujaregistration']) && !empty($_FILES['image']['name'])) {
            $conflict = $pujaregistrationModel->getPujaRegistrationConflict($_POST['Member_id'] ?? '', $_POST['puja_type'] ?? '');
            if (!empty($_POST['Member_id']) && !empty($conflict['blocked'])) {
                echo "<div style='color:red;padding:20px;font-size:18px;'>" . htmlspecialchars($conflict['message'], ENT_QUOTES) . "</div>";
                echo "<a href='javascript:history.back()'>Go Back</a>";
                exit();
            }

            $data = array();
                if (!empty($_FILES['image'])) {

            $documentUploadError = $this->validateRegistrationDocumentUpload($_FILES['image']);
            if ($documentUploadError !== '') {
                echo "<div style='color:#d71920;padding:20px;font-size:18px;font-weight:bold;'>Upload failed: " . htmlspecialchars($documentUploadError) . "</div>";
                echo "<a href='javascript:history.back()'>Go Back</a>";
                exit();
            }


            $fileextension = $_FILES['image']['type'];
            $newfileextension =  explode("/",$fileextension);
            $filetype =  strtolower($newfileextension[1] ?? '');
            if($filetype == "pdf"){
                require_once APP_PATH . 'helpers/uploader/class.upload.php';
                $targetfolder =  INSTALL_PATH . UPLOAD_PATH . 'avatar/thumb/' ;
                $imgdata =  $_FILES['image']['name'];
                $newimgdata =  explode(".",$imgdata);
                $img_name = time();
                //$finaldocumentname = $img_name.'.'.$newimgdata[1];
                $finaldocumentname = $img_name.'.'.$filetype;
                $targetfolder = $targetfolder . basename( $finaldocumentname) ;
               
               if(move_uploaded_file($_FILES['image']['tmp_name'], $targetfolder))
                {
                $data['addressavatar'] = $finaldocumentname;
                }
                else {
                echo "Problem uploading file";
                }

            }
            if($filetype != "pdf"){

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
                    $data['addressavatar'] = $handle->file_dst_name;
                }
            }
        }
             date_default_timezone_set("America/Chicago");
             $today = date("Y/m/d");
             $_POST['CreatedAt'] = $today;
             $_POST['pay_date'] = $today;
             $_POST['amount']      = is_numeric($_POST['puja_amount']       ?? '') ? (float)$_POST['puja_amount']       : 0;
             $_POST['donation']    = is_numeric($_POST['donation']          ?? '') ? (float)$_POST['donation']          : 0;
             $_POST['totalamount'] = is_numeric($_POST['totalamount']       ?? '') ? (float)$_POST['totalamount']       : 0;
             $_POST['magazineprice'] = $_POST['extramagazineamount'] ?? '';
             // Sanitize int/tinyint fields for initial save
             $_POST['member_veggie']  = isset($_POST['member_veggie'])  && is_numeric($_POST['member_veggie'])  ? (int)$_POST['member_veggie']  : 0;
             $_POST['spouse_veggie']  = isset($_POST['spouse_veggie'])  && is_numeric($_POST['spouse_veggie'])  ? (int)$_POST['spouse_veggie']  : 0;
             $_POST['student']        = isset($_POST['student'])        && is_numeric($_POST['student'])        ? (int)$_POST['student']        : 0;
             $_POST['outoftowner']    = isset($_POST['outoftowner'])    && is_numeric($_POST['outoftowner'])    ? (int)$_POST['outoftowner']    : 0;
             $_POST['senior']         = isset($_POST['senior'])         && is_numeric($_POST['senior'])         ? (int)$_POST['senior']         : 0;
             $_POST['swap_spouse']    = isset($_POST['swap_spouse'])    && is_numeric($_POST['swap_spouse'])    ? (int)$_POST['swap_spouse']    : 0;
              $_POST['Age1']           = isset($_POST['Age1'])           && is_numeric($_POST['Age1'])           ? (int)$_POST['Age1']           : 0;
              $_POST['Age2']           = isset($_POST['Age2'])           && is_numeric($_POST['Age2'])           ? (int)$_POST['Age2']           : 0;
              $_POST['Age3']           = isset($_POST['Age3'])           && is_numeric($_POST['Age3'])           ? (int)$_POST['Age3']           : 0;
              $_POST['co_register_adult_members'] = !empty($_POST['co_register_adult_members']) ? 1 : 0;
              $_POST['adult1_birth_year'] = isset($_POST['adult1_birth_year']) && is_numeric($_POST['adult1_birth_year']) ? (int)$_POST['adult1_birth_year'] : '';
              $_POST['adult2_birth_year'] = isset($_POST['adult2_birth_year']) && is_numeric($_POST['adult2_birth_year']) ? (int)$_POST['adult2_birth_year'] : '';
              $_POST['adult3_birth_year'] = isset($_POST['adult3_birth_year']) && is_numeric($_POST['adult3_birth_year']) ? (int)$_POST['adult3_birth_year'] : '';
              $_POST['adult1_veggie'] = isset($_POST['adult1_veggie']) && is_numeric($_POST['adult1_veggie']) ? (int)$_POST['adult1_veggie'] : 0;
              $_POST['adult2_veggie'] = isset($_POST['adult2_veggie']) && is_numeric($_POST['adult2_veggie']) ? (int)$_POST['adult2_veggie'] : 0;
              $_POST['adult3_veggie'] = isset($_POST['adult3_veggie']) && is_numeric($_POST['adult3_veggie']) ? (int)$_POST['adult3_veggie'] : 0;
              $this->applyAdultChildRegistrationPricing($_POST);
             // NOT NULL varchar columns with no DB default — must always be present
             // (studentavatar may be set in $data from file upload; addressavatar defaults to '')
             $_POST['studentavatar']  = $data['studentavatar'] ?? ($_POST['studentavatar'] ?? '');
             $_POST['addressavatar']  = $data['addressavatar'] ?? ($_POST['addressavatar'] ?? '');
           $id = $pujaregistrationModel->save(array_merge($_POST, $data));
           if (!empty($id)) {
               $this->updateMemberAddressFromRegistrationPost($MemberModel, 'Puja Registration Document Request');
           }
          
                    if (!empty($id)) {

                            $opts = array();
                            $opts['id'] = $id;
                            $opts['status'] = 'pending';
                            $data = $_POST;
                            try { $pujaregistrationModel->update(array_merge($opts, $_POST)); } catch (Throwable $e) { $this->logPujaCartError('update(opts+POST) ERROR | ' . $e->getMessage()); }

                        $memberfname = $_POST['First_name'] ?? '';
                        $memberlname = $_POST['Last_name'] ?? '';
                        $pujatype = $_POST['puja_type'] ?? '';
                        $totalamount = $_POST['totalamount'] ?? '';
                        $pujaprice = $_POST['puja_amount'] ?? '';
                        $magazineprice = $_POST['extramagazineamount'] ?? '';
                        $seniordiscount = $_POST['discountseniorprice'] ?? '';
                        $parentregistration = $_POST['extraparentregistration'] ?? '';
                        $donation = $_POST['donation'] ?? '';
                        
                      echo "<div style='text-align: -webkit-center;' class = 'pay'>
                      <table border='4'  width='585px' style='margin-left:4em;'>
                      <tr>
                      <td colspan='2'> <img src='../HDBS_Logo_HiRes.png' alt='' height='167px' style='margin-left:12em;'><h1 style='text-align:center;font-family:fangsong; font-size:30px;'><b>Houston Durga Bari Society</b></h1> </td>
                      <tr><td colspan='2'><span style='font-size: 18px;font-family: serif;'>Thank You for the Request. You will receive a Payment Link soon from our team after Verification of the Submitted document.</span></td></tr>
                      <tr><td style='width:50%;'>Name</td> <td style='width:50%;'>" . $memberfname . " " . $memberlname . "</td> </tr>
                      <tr><td>Puja Type</td> <td>" . $pujatype . "</td> </tr>
                      <tr><td>Total Amount</td> <td><span style= 'color:red;'>$</span>" . $totalamount . "</td> </tr>
                       <tr><td>Purpose</td> <td><span style= 'color:red;'></span>Puja Registration</td> </tr>
                      <tr><td>Payment Status</td> <td>Pending</td>  </tr>
                      <tr><td colspan='2'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>   </tr>
                      </tr>";
                      echo "</table>";
                       echo "<a  href='" . INSTALL_URL . "PujaOnlinePayments/PujaOnlinePayments'>Go to home</a>";
                       echo "</div>";
                    }
                    $Emailcc = 'pujaregpayment@durgabari.org';
                    $subjetc = 'Puja Registration Request';
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
                    <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Full Name&nbsp;&nbsp;</td>
                    <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">' . $memberfname . " " . $memberlname . '</td>
                    </tr>
                    <tr>
                    <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Puja Type&nbsp;&nbsp;</td>
                    <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $pujatype . '</td>
                    </tr>
                    <tr>
                    <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Puja Price &nbsp;</td>
                    <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;"><span style="color:red;">$</span>' . $pujaprice . '</td>
                    </tr>
                    ';
                    
                    if ($magazineprice != "") {
                    $message .='<tr>
                    <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Magazine(Additional)&nbsp;&nbsp;</td>
                    <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;"><span style="color:red;">$</span>' . $magazineprice . '</td>
                    </tr>';}
                    if ($parentregistration != "") {
                    $message .='<tr>
                    <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Parent Registration&nbsp;&nbsp;</td>
                    <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;"><span style="color:red;">$</span>' . $parentregistration . '</td>
                    </tr>
                    ';}
                    if ($donation != "") {
                        $message .='<tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Donation Amount&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;"><span style="color:red;">$</span>' . $donation . '</td>
                        </tr>
                        ';}
                    if ($seniordiscount != "") {
                    $message .='<tr>
                    <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Senior Discount&nbsp;&nbsp;</td>
                    <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;"><span style="color:red;">$</span>' . $seniordiscount . '</td>
                    </tr>';
                    }
                    $message .='
                    <tr>
                    <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Total Amount&nbsp;&nbsp;</td>
                    <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;"><span style="color:red;">$</span>' . $totalamount . '</td>
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
                      
                      $membername = ($_POST['First_name'] ?? '') . ' ' . ($_POST['Last_name'] ?? '');
                     

                      $textmsg = 'Your Puja Registration request have been submitted  Member Id: ' . $MemberId . ', Full Name: ' . $membername . ', Puja Type: ' . $pujatype . ', Puja Price: $' . $pujaprice;
                      if ($magazineprice != "") {$textmsg .= ', Magazine(Additional): $' . $magazineprice;}
                      if ($parentregistration != "") {$textmsg .= ', Parent Registration: $' . $parentregistration;}
                      if ($seniordiscount != "") { $textmsg .= ', Senior Discount: $' . $seniordiscount;}
                      if ($donation != "") { $textmsg .= ', Donation Amount: $' . $donation;}
                      $textmsg .= ', Total Amount: $' . $totalamount;

                      $mobileno= $_POST['alternatenumber'] ?? '';
                      if ($mobileno != null) {
                      $this->SendSMS($mobileno, $textmsg);
                  }
                     exit();
            
                }
        
        if (!empty($_POST['create_registrationpayment'])) {
            $conflict = $pujaregistrationModel->getPujaRegistrationConflict($_POST['Member_id'] ?? '', $_POST['puja_type'] ?? '');
            if (!empty($_POST['Member_id']) && !empty($conflict['blocked'])) {
                echo "<div style='color:red;padding:20px;font-size:18px;'>" . htmlspecialchars($conflict['message'], ENT_QUOTES) . "</div>";
                echo "<a href='javascript:history.back()'>Go Back</a>";
                exit();
            }
            $data = array();
            date_default_timezone_set("America/Chicago");
            $today = date("Y/m/d"); 
            $_POST['pay_date'] = $today;
            $_POST['CreatedAt'] = $today;
            $_POST['pay_type'] = 'Puja Registration';
            $_POST['pay_for'] =  $_POST['puja_type'] ?? '';
            // for generate oid 
            //$oid= Util::incrementalHash(4);
            $maxoid = $idnumbersModel->getMaxoid() + 1;
            $update_oid = $idnumbersModel->Updateoid($maxoid);
             $_POST['oid'] = $maxoid;
        // end generate oid for
            
         $datamember =  $MemberModel->rentalmemberduplicate();
        if($datamember == null){
                
                 // for generate memberid for gd
                    $maxid = $idnumbersModel->getMaxmid() + 1;
                     $update_mid = $idnumbersModel->Updatemid($maxid);
                     $_POST['Member_id'] = $maxid;
                     $_POST['membercategory'] = 'GC';
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
                $phone =  $_POST['phone'] ?? '';
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
            if (!empty($_POST['update_address'])) {
                try { $MemberModel->updateAddressWithHistory($datamember, $_POST, 'Puja Registration'); } catch (Throwable $e) { $this->logPujaCartError('updateAddressWithHistory ERROR | ' . $e->getMessage()); }
            }
             }
            if ($this->isAdmin() || $this->isEditor()) {
                $id = $this->getUserId();
                $admin = $UserModel->get($id);
                $rolename = $admin['first'].' '.$admin['last'];
                $_POST['admin_id'] = $admin['id'];
                $_POST['admin_name'] = $rolename;

            }

             if(($_POST['member_status'] ?? '') == "individual"){
                $_POST['Sp_fname'] = "";
                $_POST['Sp_lname'] = "";
                $_POST['childonefname'] = "";
                $_POST['childonelname'] = "";
                $_POST['Age1'] = "";
                $_POST['childtwofname'] = "";
                $_POST['childtwolname'] = "";
                $_POST['Age2'] = "";
                $_POST['childthreefname'] = "";
                $_POST['childthreelname'] = "";
                $_POST['Age3'] = "";
                
            }

           //for complimentary registration :
                if(($_POST['PaymentOption'] ?? '') == 'ComplimentaryRegistration'){

                    $_POST['amount'] ="";
                    $_POST['totalamount'] ="";
                    $_POST['discountseniorprice'] ="";
                    $_POST['magazineprice'] = "";
                    $_POST['extraparentregistration'] ="";
                    $_POST['extraadultregistration'] ="";
                    $_POST['donation'] = "";

                }

             // Sanitize float fields — empty string rejected by Azure MySQL STRICT mode
             $_POST['donation']    = is_numeric($_POST['donation']    ?? '') ? (float)$_POST['donation']    : 0;
             $_POST['amount']      = is_numeric($_POST['amount']      ?? '') ? (float)$_POST['amount']      : 0;
             $_POST['totalamount'] = is_numeric($_POST['totalamount'] ?? '') ? (float)$_POST['totalamount'] : 0;
             // Sanitize tinyint/int fields
             $_POST['member_veggie']  = isset($_POST['member_veggie'])  && is_numeric($_POST['member_veggie'])  ? (int)$_POST['member_veggie']  : 0;
             $_POST['spouse_veggie']  = isset($_POST['spouse_veggie'])  && is_numeric($_POST['spouse_veggie'])  ? (int)$_POST['spouse_veggie']  : 0;
             $_POST['student']        = isset($_POST['student'])        && is_numeric($_POST['student'])        ? (int)$_POST['student']        : 0;
             $_POST['outoftowner']    = isset($_POST['outoftowner'])    && is_numeric($_POST['outoftowner'])    ? (int)$_POST['outoftowner']    : 0;
             $_POST['senior']         = isset($_POST['senior'])         && is_numeric($_POST['senior'])         ? (int)$_POST['senior']         : 0;
             $_POST['swap_spouse']    = isset($_POST['swap_spouse'])    && is_numeric($_POST['swap_spouse'])    ? (int)$_POST['swap_spouse']    : 0;
              $_POST['Age1']           = isset($_POST['Age1'])           && is_numeric($_POST['Age1'])           ? (int)$_POST['Age1']           : 0;
              $_POST['Age2']           = isset($_POST['Age2'])           && is_numeric($_POST['Age2'])           ? (int)$_POST['Age2']           : 0;
              $_POST['Age3']           = isset($_POST['Age3'])           && is_numeric($_POST['Age3'])           ? (int)$_POST['Age3']           : 0;
              $_POST['parent1_veggie'] = isset($_POST['parent1_veggie']) && is_numeric($_POST['parent1_veggie']) ? (int)$_POST['parent1_veggie'] : 0;
              $_POST['parent2_veggie'] = isset($_POST['parent2_veggie']) && is_numeric($_POST['parent2_veggie']) ? (int)$_POST['parent2_veggie'] : 0;
              $_POST['co_register_adult_members'] = !empty($_POST['co_register_adult_members']) ? 1 : 0;
              $_POST['adult1_birth_year'] = isset($_POST['adult1_birth_year']) && is_numeric($_POST['adult1_birth_year']) ? (int)$_POST['adult1_birth_year'] : '';
              $_POST['adult2_birth_year'] = isset($_POST['adult2_birth_year']) && is_numeric($_POST['adult2_birth_year']) ? (int)$_POST['adult2_birth_year'] : '';
              $_POST['adult3_birth_year'] = isset($_POST['adult3_birth_year']) && is_numeric($_POST['adult3_birth_year']) ? (int)$_POST['adult3_birth_year'] : '';
              $_POST['adult1_veggie'] = isset($_POST['adult1_veggie']) && is_numeric($_POST['adult1_veggie']) ? (int)$_POST['adult1_veggie'] : 0;
              $_POST['adult2_veggie'] = isset($_POST['adult2_veggie']) && is_numeric($_POST['adult2_veggie']) ? (int)$_POST['adult2_veggie'] : 0;
              $_POST['adult3_veggie'] = isset($_POST['adult3_veggie']) && is_numeric($_POST['adult3_veggie']) ? (int)$_POST['adult3_veggie'] : 0;
              $this->applyAdultChildRegistrationPricing($_POST);
             // NOT NULL varchar columns with no DB default — must always be present
             $_POST['studentavatar']  = $_POST['studentavatar']  ?? '';
             $_POST['addressavatar']  = $_POST['addressavatar']  ?? '';

             $id = null;
             try {
                 $id = $pujaregistrationModel->save(array_merge($_POST, $data));
                 if (!empty($id)) {
                     $this->updateMemberAddressFromRegistrationPost($MemberModel, 'Puja Registration Payment');
                 }
                 $this->logPujaCartError('SAVE OK (create_registrationpayment) | id=' . $id);
             } catch (Throwable $saveEx) {
                 $this->logPujaCartError('SAVE ERROR (create_registrationpayment) | ' . $saveEx->getMessage());
                 echo "<div style='color:red;padding:20px;font-size:18px;'>Submission Error: " . htmlspecialchars($saveEx->getMessage()) . "</div>";
                 exit();
             }
             if (!empty($id)) {
                 
                 //for confirmation email
                $orderid = $_POST['oid'] ?? '';
                $Memberid = $_POST['Member_id'] ?? '';
                $membername = ($_POST['First_name'] ?? '') .' ' . ($_POST['Last_name'] ?? '');
                $pujatype = $_POST['puja_type'] ?? '';
                $totalamount = $_POST['totalamount'] ?? '';
                $pujaprice = $_POST['amount'] ?? '';
                $magazineprice = $_POST['magazineprice'] ?? '';
                $seniordiscount = $_POST['discountseniorprice'] ?? '';
                $parentregistration = $_POST['extraparentregistration'] ?? '';
                $donation = $_POST['donation'] ?? '';

                $paymethod = $_POST['PaymentOption'] ?? '';
                if($paymethod == "others"){ $payui = 'Zelle';}
                else if($paymethod == "check"){$payui = 'Check';}
                else if($paymethod == "cash"){$payui = 'Cash';}
                else if($paymethod == "directdeposit"){$payui = 'Online Deposit';}
                else if($paymethod == "sumup"){$payui = 'SumUp';}
                else if($paymethod == "stripe"){$payui = 'Credit Card';}
                
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
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">' . $orderid  . '</td>
                </tr>
                <tr>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Member Id&nbsp;&nbsp;</td>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">' . $Memberid  . '</td>
                </tr> 
                <tr>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Full Name&nbsp;&nbsp;</td>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">' . $membername  . '</td>
                </tr>
                <tr>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Puja Type&nbsp;&nbsp;</td>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $pujatype . '</td>
                </tr>
                <tr>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Puja Price &nbsp;</td>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;"><span style="color:red;">$</span>' . $pujaprice . '</td>
                </tr>
                ';
                
                if ($magazineprice != "") {
                $message .='<tr>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Magazine(Additional)&nbsp;&nbsp;</td>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;"><span style="color:red;">$</span>' . $magazineprice . '</td>
                </tr>';}
                if ($parentregistration != "") {
                $message .='<tr>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Parent Registration&nbsp;&nbsp;</td>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;"><span style="color:red;">$</span>' . $parentregistration . '</td>
                </tr>
                ';}
                
                if ($seniordiscount != "") {
                $message .='<tr>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Senior Discount&nbsp;&nbsp;</td>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;"><span style="color:red;">$</span>' . $seniordiscount . '</td>
                </tr>';
                }
                if ($donation != "") {
                $message .='<tr>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Donation Amount&nbsp;&nbsp;</td>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;"><span style="color:red;">$</span>' . $donation . '</td>
                </tr>
                ';}
                $message .='
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
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">' . $paydateemail  . '</td>
                </tr> 
                </tbody>
                </table>
                </div>
                </div>
                </div>';
                $textmsg = 'Houston Durga Bari: Puja Registration confirmation are Order Id: ' . $orderid . ', Member Id: ' . $Memberid . ', Full Name: ' . $membername . ', Puja Type: ' . $pujatype . ', Puja Price: $' . $pujaprice;
                if ($magazineprice != "") {$textmsg .= ', Magazine(Additional): $' . $magazineprice;}
                if ($parentregistration != "") {$textmsg .= ', Parent Registration: $' . $parentregistration;}
                if ($seniordiscount != "") { $textmsg .= ', Senior Discount: $' . $seniordiscount;}
                if ($donation != "") { $textmsg .= ', Donation Amount: $' . $donation;}
                $textmsg .= ', Total Amount: $' . $totalamount . ', Payment Method: ' . $payui . ', Pay Date: ' . $paydateemail;

 
                if (($_POST['PaymentOption'] ?? '') == 'others') {
                    
                    $opts = array();
                    $oid = $_POST['oid'] ?? '';
                    $cmCode=$_POST['code'] ?? '';
                    $isAvailable = $ConfirmCodeModel->ConfirmCheckCode($cmCode);
                    if(!$isAvailable)
                    {
                        Util::redirect(INSTALL_URL . "onlinepujapayments/onlinepujapayments");
                        exit();

                    }
                    
                    $arr= $ConfirmCodeModel->UpdateCode($cmCode);
                    $_POST['transaction_id'] =  $cmCode;
                    $opts['Confirmation'] = $_POST['confirm_code'] ?? '';
                   $arr = $ConfirmCodeModel->getAll($opts);
                    if ($oid !=null){
                    //if (!empty($arr[0])) {
                        $opts = array();
                        $opts['id'] = $id;
                        //$opts['payment_status'] = 'succeeded';
                        $opts['payment_status'] = 'confirmed';
                        $_POST['status'] = 'confirmed';
                        $data = $_POST;
                        $datamemberarr = array();
                        $datamemberarr =  array_merge($opts, $_POST);
                        try { $pujaregistrationModel->update(array_merge($opts, $_POST)); } catch (Throwable $e) { $this->logPujaCartError('others update ERROR | ' . $e->getMessage()); }
                        $value['oid'] = $oid;
                        $value['Member_id'] = $datamemberarr['Member_id'];
                        $value['MemberName'] = $datamemberarr['First_name'].' '.$datamemberarr['Last_name'];
                        $value['PaymentOption'] = $datamemberarr['PaymentOption'];
                        $value['payment_status'] = 'succeeded';
                        $value['payment_timestamp'] = $datamemberarr['payment_timestamp'] ?? '';
                        $value['stripe_return'] = $datamemberarr['stripe_return'] ?? '';
                        $value['transaction_id'] = $datamemberarr['transaction_id'];
                        $value['paid_amount'] = $datamemberarr['paid_amount'] ?? '';
                        $value['update_on'] = $datamemberarr['UpdateOn'];
                        $value['stripe_product'] = $datamemberarr['stripe_product'] ?? '';
                        $value['pay_date'] = $datamemberarr['pay_date'];
                        $value['pay_type'] = $datamemberarr['pay_type'];
                        $value['pay_for'] = $datamemberarr['pay_for'];
                        $value['Tele1'] = $datamemberarr['phone'];
                        $value['Tele2'] = $datamemberarr['alternatenumber'];
                        $value['email'] = $datamemberarr['email']; 
                        $value['spousename'] = $datamemberarr['Sp_fname'].' '.$datamemberarr['Sp_lname'];;
                        $value['Address'] = $datamemberarr['streetname'];
                        $value['Street'] = $datamemberarr['street'];
                        $value['City'] = $datamemberarr['city'];
                        $value['State'] = $datamemberarr['state'];
                        $value['Zip_Code'] = $datamemberarr['zip'];
                        $value['admin_id'] = $datamemberarr['admin_id'];
                        $value['admin_name'] = $datamemberarr['admin_name'];
                        $extradonationamount = $datamemberarr['donation'];
                        $totalamountwithdonation = $datamemberarr['totalamount'];
                        $SecondAmount = $totalamountwithdonation - $extradonationamount;
                        
                        if($extradonationamount == null){
                            $value['Amount'] = $datamemberarr['totalamount'];
                            try { $DonationModel->SaveDataInDonation($value); } catch (Throwable $donEx) { $this->logPujaCartError('SaveDataInDonation ERROR | ' . $donEx->getMessage()); }
                        }
                       if($extradonationamount != null){
                                for($i=0;$i<=1;$i++){
                                    if($i==0){
                                        $value['pay_type'] = $datamemberarr['pay_type'];
                                        $value['pay_for'] = $datamemberarr['pay_for'];
                                        $value['Amount'] = $SecondAmount;
                                        try { $DonationModel->SaveDataInDonation($value); } catch (Throwable $donEx) { $this->logPujaCartError('SaveDataInDonation ERROR | ' . $donEx->getMessage()); }
                                    }
                                    if($i==1){
                                         $value['pay_type'] = 'Donation';
                                         $value['pay_for'] = 'DONATION / Unrestricted';
                                         $value['paymentfor'] = 'Puja Donation';
                                        $value['Amount'] = $extradonationamount;
                                        try { $DonationModel->SaveDataInDonation($value); } catch (Throwable $donEx) { $this->logPujaCartError('SaveDataInDonation ERROR | ' . $donEx->getMessage()); }
                                    }
                                    
                                }
                            }



                        if($datamember == null) {
                            $value = array();
                            // $value['id'] = $_POST['id'] ?? '';
                            $value['Payment_For'] = $_POST['Payment_For'] ?? '';
                            $value['MemberName'] = ($_POST['First_name'] ?? '') . ' ' . ($_POST['Last_name'] ?? '');
                            $value['Amount'] = $_POST['totalamount'] ?? '';
                            $value['PaymentOption'] = $_POST['PaymentOption'] ?? '';
                            $value['payment_status'] = 'confirmed';
                            $value['payment_timestamp'] = $opts['payment_timestamp'] ?? '';
                            $value['stripe_return'] = $opts['stripe_return'] ?? '';
                            $value['transaction_id'] = $opts['transaction_id'];
                            $value['paid_amount'] = $opts['paid_amount'] ?? '';
                            $value['stripe_product'] = $opts['stripe_product'] ?? '';
                            $value['update_on'] = $_POST['update_on'] ?? '';
                            $value['Member_id'] = $_POST['Member_id'] ?? '';
                            $value['pay_date'] = $_POST['pay_date'] ?? '';
                            $value['cc_name'] = $_POST['cc_name'] ?? '';
                            $value['remarks'] = $_POST['remarks'] ?? '';
                            $value['oid'] = $_POST['oid'] ?? '';
                            $value['pay_type'] = $_POST['pay_type'] ?? '';
                            $value['pay_for'] = $_POST['pay_for'] ?? '';
                            $value['Address'] = $_POST['streetname'] ?? '';
                            $value['Street'] = $_POST['street'] ?? '';
                            $value['Address'] = $_POST['streetname'] ?? '';
                            $value['Address3'] = $_POST['unit'] ?? '';
                            $value['Zip_Code'] = $_POST['zip'] ?? '';
                            $value['Tele2'] = $_POST['alternatenumber'] ?? '';
                            $value['email'] = $_POST['email'] ?? '';
                            $value['City'] = $_POST['city'] ?? '';
                            $value['State'] = $datamemberarr['state'];
                            $value['Tele1'] = $_POST['phone'] ?? '';
                            $value['spousename'] = ($_POST['Sp_fname'] ?? '') . ' ' . ($_POST['Sp_lname'] ?? '');
                            $value['Address3'] = $_POST['Address3'] ?? '';
                           // $value['Parent1'] = ($_POST['parent1_fname'] ?? '') .' '. ($_POST['parent1_lname'] ?? '');
                           // $value['Parent2'] = ($_POST['parent2_fname'] ?? '') .' '. ($_POST['parent2_lname'] ?? '');
                            $value['Child1'] = ($_POST['childonefname'] ?? '') . ' ' . ($_POST['childonelname'] ?? '');
                            $value['Child2'] = ($_POST['childtwofname'] ?? '') . ' ' . ($_POST['childtwolname'] ?? '');
                            $value['Child3'] = ($_POST['childthreefname'] ?? '') . ' ' . ($_POST['childthreelname'] ?? '');
                            $value['Age1'] = $_POST['Age1'] ?? '';
                            $value['Age2'] = $_POST['Age2'] ?? '';
                            $value['Age3'] = $_POST['Age3'] ?? '';
                            try { $MemberModel->SaveDataInmember($value); } catch (Throwable $e) { $this->logPujaCartError('SaveDataInmember ERROR | ' . $e->getMessage()); }
                        }

                         $email = $_POST['email'] ?? '';
                        if($email != null) {
                         $this->sendEmailticket($message, $subjetc, $email, $Emailcc);
                        }
                        $mobileno= $_POST['alternatenumber'] ?? '';
                            if ($mobileno != null) {
                                $this->SendSMS($mobileno, $textmsg );
                                }
                            $this->tpl['arr'] = $pujaregistrationModel->get($id);
                            if (session_status() === PHP_SESSION_NONE) { session_start(); }
                            if(($_POST['donation'] ?? '') != ""){
                                $memberid = $_POST['Member_id'] ?? '';
                                try { $confirmdata = $MemberModel->membercheck($memberid); } catch (Throwable $e) { $this->logPujaCartError('membercheck ERROR|'.$e->getMessage()); $confirmdata = []; }
                                $_SESSION['memberregisterpuja'] = $confirmdata;
                                try { $pujareg = $itemspujasponsorModel->registersankalpapujacheck($memberid); } catch (Throwable $e) { $this->logPujaCartError('registersankalpapujacheck ERROR|'.$e->getMessage()); $pujareg = []; }
                                $_SESSION['pujareg'] = $pujareg;
                                try { $sponsoreventfirst = $itemspujasponsorModel->sponsorevent1check($memberid); } catch (Throwable $e) { $this->logPujaCartError('sponsorevent1check ERROR|'.$e->getMessage()); $sponsoreventfirst = []; }
                                $_SESSION['sponsoreventfirst'] = $sponsoreventfirst;
                                try { $sponsoreventsecond = $itemspujasponsorModel->sponsorevent2check($memberid); } catch (Throwable $e) { $this->logPujaCartError('sponsorevent2check ERROR|'.$e->getMessage()); $sponsoreventsecond = []; }
                                $_SESSION['sponsoreventsecond'] = $sponsoreventsecond;
                                
                                try { $pujasankalpaattempt1arr = $itemspujasponsorModel->pujasankalpaattempt1($memberid); } catch (Throwable $e) { $this->logPujaCartError('pujasankalpaattempt1 ERROR|'.$e->getMessage()); $pujasankalpaattempt1arr = []; }
                                $_SESSION['pujasankalpaattempt1arr'] = $pujasankalpaattempt1arr;

                                try { $pujasankalpaattempt2arr = $itemspujasponsorModel->pujasankalpaattempt2($memberid); } catch (Throwable $e) { $this->logPujaCartError('pujasankalpaattempt2 ERROR|'.$e->getMessage()); $pujasankalpaattempt2arr = []; }
                                $_SESSION['pujasankalpaattempt2arr'] = $pujasankalpaattempt2arr;
                                
                                try { $CategoryAarr = $sponsoritemModel->sponsorCategoryA(); } catch (Throwable $e) { $this->logPujaCartError('sponsorCategoryA ERROR|'.$e->getMessage()); $CategoryAarr = []; }
                                $_SESSION['CategoryAarr'] = $CategoryAarr;
             
                                try { $CategoryBarr = $sponsoritemModel->sponsorCategoryB(); } catch (Throwable $e) { $this->logPujaCartError('sponsorCategoryB ERROR|'.$e->getMessage()); $CategoryBarr = []; }
                                $_SESSION['CategoryBarr'] = $CategoryBarr;
                                $previousytd = is_numeric($_POST['YTD'] ?? '') ? (float)$_POST['YTD'] : 0;
                                $amountytd = is_numeric($_POST['donation'] ?? '') ? (float)$_POST['donation'] : 0;
                                $newytd = $previousytd + $amountytd; 
                                $_SESSION['ytdvalue'] = $newytd; 
    
                                }
                            $_SESSION['myValue']=$this->tpl['arr'];
                            Util::redirect(INSTALL_URL . "PujaCart/show/".$id); 
                        exit();
                    }
                }
                 //check
                elseif (($_POST['PaymentOption'] ?? '') == 'check') {
                    $_POST['totalamount'] = $_POST['checkAmount'] ?? '';
                    $_POST['bank'] = $_POST['checkbankname'] ?? '';
                    $_POST['chkdate'] = $_POST['CheckDate'] ?? '';
                    //$_POST['pay_date'] = $_POST['CheckDate'] ?? '';
                    $_POST['status'] = 'confirmed';
                    $_POST['payment_status'] = 'confirmed';
                    $_POST['DepositAccount'] = $_POST['CheckDepositAccount'] ?? '';
                    $_POST['id'] = $id;
                    $data = $_POST;
                    $datamemberarr = array();
                    $datamemberarr =  array_merge($_POST);
                    try { $pujaregistrationModel->update(array_merge($_POST)); } catch (Throwable $e) { $this->logPujaCartError('update(POST) ERROR | ' . $e->getMessage()); }
                    $value['oid'] = $_POST['oid'] ?? '';
                    $value['Member_id'] = $datamemberarr['Member_id'];
                    $value['MemberName'] = $datamemberarr['First_name'].' '.$datamemberarr['Last_name'];
                    $value['PaymentOption'] = $datamemberarr['PaymentOption'];
                    $value['payment_status'] = 'succeeded';
                    $value['payment_timestamp'] = $datamemberarr['payment_timestamp'] ?? '';
                    $value['stripe_return'] = $datamemberarr['stripe_return'] ?? '';
                    $value['transaction_id'] = $datamemberarr['transaction_id'];
                    $value['paid_amount'] = $datamemberarr['paid_amount'] ?? '';
                    $value['update_on'] = $datamemberarr['UpdateOn'];
                    $value['stripe_product'] = $datamemberarr['stripe_product'] ?? '';
                    $value['pay_date'] = $datamemberarr['pay_date'];
                    $value['pay_type'] = $datamemberarr['pay_type'];
                    $value['pay_for'] = $datamemberarr['pay_for'];
                    $value['Tele1'] = $datamemberarr['phone'];
                    $value['Tele2'] = $datamemberarr['alternatenumber'];
                    $value['email'] = $datamemberarr['email']; 
                    $value['spousename'] = $datamemberarr['Sp_fname'].' '.$datamemberarr['Sp_lname'];;
                    $value['Address'] = $datamemberarr['streetname'];
                    $value['Street'] = $datamemberarr['street'];
                    $value['City'] = $datamemberarr['city'];
                    $value['State'] = $datamemberarr['state'];
                    $value['Zip_Code'] = $datamemberarr['zip'];
                    $value['admin_id'] = $datamemberarr['admin_id'];
                    $value['admin_name'] = $datamemberarr['admin_name'];
                    $value['DepositAccount'] = $datamemberarr['DepositAccount'];
                    $extradonationamount = $datamemberarr['donation'];
                    $totalamountwithdonation = $datamemberarr['totalamount'];
                    $SecondAmount = $totalamountwithdonation - $extradonationamount;
                        
                    //try { $DonationModel->SaveDataInDonation($value); } catch (Throwable $donEx) { $this->logPujaCartError('SaveDataInDonation ERROR | ' . $donEx->getMessage()); }
                    if($extradonationamount == null){
                        $value['Amount'] = $datamemberarr['totalamount'];
                        try { $DonationModel->SaveDataInDonation($value); } catch (Throwable $donEx) { $this->logPujaCartError('SaveDataInDonation ERROR | ' . $donEx->getMessage()); }
                    }
                   if($extradonationamount != null){
                            for($i=0;$i<=1;$i++){
                                if($i==0){
                                    $value['pay_type'] = $datamemberarr['pay_type'];
                                    $value['pay_for'] = $datamemberarr['pay_for'];
                                    $value['Amount'] = $SecondAmount;
                                    try { $DonationModel->SaveDataInDonation($value); } catch (Throwable $donEx) { $this->logPujaCartError('SaveDataInDonation ERROR | ' . $donEx->getMessage()); }
                                }
                                if($i==1){
                                     $value['pay_type'] = 'Donation';
                                     $value['pay_for'] = 'DONATION / Unrestricted';
                                     $value['paymentfor'] = 'Puja Donation';
                                    $value['Amount'] = $extradonationamount;
                                    try { $DonationModel->SaveDataInDonation($value); } catch (Throwable $donEx) { $this->logPujaCartError('SaveDataInDonation ERROR | ' . $donEx->getMessage()); }
                                }
                                
                            }
                        }
                    if($datamember == null) {
                        $value = array();
                        // $value['id'] = $_POST['id'] ?? '';
                        $value['Payment_For'] = $_POST['Payment_For'] ?? '';
                        $value['MemberName'] = ($_POST['First_name'] ?? '') . ' ' . ($_POST['Last_name'] ?? '');
                        $value['Amount'] = $_POST['totalamount'] ?? '';
                        $value['PaymentOption'] = $_POST['PaymentOption'] ?? '';
                        $value['payment_status'] = 'confirmed';
                        $value['payment_timestamp'] = $_POST['payment_timestamp'] ?? '';
                        $value['stripe_return'] = $_POST['stripe_return'] ?? '';
                        $value['transaction_id'] = $_POST['transaction_id'] ?? '';
                        $value['paid_amount'] = $_POST['paid_amount'] ?? '';
                        $value['stripe_product'] = $_POST['stripe_product'] ?? '';
                        $value['update_on'] = $_POST['update_on'] ?? '';
                        $value['Member_id'] = $_POST['Member_id'] ?? '';
                        $value['pay_date'] = $_POST['pay_date'] ?? '';
                        $value['cc_name'] = $_POST['cc_name'] ?? '';
                        $value['remarks'] = $_POST['remarks'] ?? '';
                        $value['oid'] = $_POST['oid'] ?? '';
                        $value['pay_type'] = $_POST['pay_type'] ?? '';
                        $value['pay_for'] = $_POST['pay_for'] ?? '';
                        $value['Address'] = $_POST['streetname'] ?? '';
                        $value['Street'] = $_POST['street'] ?? '';
                        $value['Address'] = $_POST['streetname'] ?? '';
                        $value['Address3'] = $_POST['unit'] ?? '';
                        $value['Zip_Code'] = $_POST['zip'] ?? '';
                        $value['Tele2'] = $_POST['alternatenumber'] ?? '';
                        $value['email'] = $_POST['email'] ?? '';
                        $value['City'] = $_POST['city'] ?? '';
                        $value['State'] = $datamemberarr['state'];
                        $value['Tele1'] = $_POST['phone'] ?? '';
                        $value['spousename'] = ($_POST['Sp_fname'] ?? '') . ' ' . ($_POST['Sp_lname'] ?? '');
                        $value['Address3'] = $_POST['Address3'] ?? '';
                       // $value['Parent1'] = ($_POST['parent1_fname'] ?? '') .' '. ($_POST['parent1_lname'] ?? '');
                       // $value['Parent2'] = ($_POST['parent2_fname'] ?? '') .' '. ($_POST['parent2_lname'] ?? '');
                        $value['Child1'] = ($_POST['childonefname'] ?? '') . ' ' . ($_POST['childonelname'] ?? '');
                        $value['Child2'] = ($_POST['childtwofname'] ?? '') . ' ' . ($_POST['childtwolname'] ?? '');
                        $value['Child3'] = ($_POST['childthreefname'] ?? '') . ' ' . ($_POST['childthreelname'] ?? '');
                        $value['Age1'] = $_POST['Age1'] ?? '';
                        $value['Age2'] = $_POST['Age2'] ?? '';
                        $value['Age3'] = $_POST['Age3'] ?? '';
                        try { $MemberModel->SaveDataInmember($value); } catch (Throwable $e) { $this->logPujaCartError('SaveDataInmember ERROR | ' . $e->getMessage()); }
                    }

                     $email = $_POST['email'] ?? '';
                        if($email != null) {
                         $this->sendEmailticket($message, $subjetc, $email, $Emailcc);
                        }
                        $mobileno= $_POST['alternatenumber'] ?? '';
                            if ($mobileno != null) {
                               $this->SendSMS($mobileno, $textmsg );
                                }
                        $this->tpl['arr'] = $pujaregistrationModel->get($id);
                        if (session_status() === PHP_SESSION_NONE) { session_start(); }
                        if(($_POST['donation'] ?? '') != ""){
                            $memberid = $_POST['Member_id'] ?? '';
                            try { $confirmdata = $MemberModel->membercheck($memberid); } catch (Throwable $e) { $this->logPujaCartError('membercheck ERROR|'.$e->getMessage()); $confirmdata = []; }
                            $_SESSION['memberregisterpuja'] = $confirmdata;
                            try { $pujareg = $itemspujasponsorModel->registersankalpapujacheck($memberid); } catch (Throwable $e) { $this->logPujaCartError('registersankalpapujacheck ERROR|'.$e->getMessage()); $pujareg = []; }
                            $_SESSION['pujareg'] = $pujareg;
                            try { $sponsoreventfirst = $itemspujasponsorModel->sponsorevent1check($memberid); } catch (Throwable $e) { $this->logPujaCartError('sponsorevent1check ERROR|'.$e->getMessage()); $sponsoreventfirst = []; }
                            $_SESSION['sponsoreventfirst'] = $sponsoreventfirst;
                            try { $sponsoreventsecond = $itemspujasponsorModel->sponsorevent2check($memberid); } catch (Throwable $e) { $this->logPujaCartError('sponsorevent2check ERROR|'.$e->getMessage()); $sponsoreventsecond = []; }
                            $_SESSION['sponsoreventsecond'] = $sponsoreventsecond;
                            
                            try { $pujasankalpaattempt1arr = $itemspujasponsorModel->pujasankalpaattempt1($memberid); } catch (Throwable $e) { $this->logPujaCartError('pujasankalpaattempt1 ERROR|'.$e->getMessage()); $pujasankalpaattempt1arr = []; }
                            $_SESSION['pujasankalpaattempt1arr'] = $pujasankalpaattempt1arr;

                            try { $pujasankalpaattempt2arr = $itemspujasponsorModel->pujasankalpaattempt2($memberid); } catch (Throwable $e) { $this->logPujaCartError('pujasankalpaattempt2 ERROR|'.$e->getMessage()); $pujasankalpaattempt2arr = []; }
                            $_SESSION['pujasankalpaattempt2arr'] = $pujasankalpaattempt2arr;
                                
                             try { $CategoryAarr = $sponsoritemModel->sponsorCategoryA(); } catch (Throwable $e) { $this->logPujaCartError('sponsorCategoryA ERROR|'.$e->getMessage()); $CategoryAarr = []; }
                             $_SESSION['CategoryAarr'] = $CategoryAarr;
             
                             try { $CategoryBarr = $sponsoritemModel->sponsorCategoryB(); } catch (Throwable $e) { $this->logPujaCartError('sponsorCategoryB ERROR|'.$e->getMessage()); $CategoryBarr = []; }
                             $_SESSION['CategoryBarr'] = $CategoryBarr;
                            $previousytd = is_numeric($_POST['YTD'] ?? '') ? (float)$_POST['YTD'] : 0;
                            $amountytd = is_numeric($_POST['donation'] ?? '') ? (float)$_POST['donation'] : 0;
                            $newytd = $previousytd + $amountytd; 
                            $_SESSION['ytdvalue'] = $newytd; 

                            }
                        $_SESSION['myValue']=$this->tpl['arr'];
                        Util::redirect(INSTALL_URL . "PujaCart/show/".$id); 
                    exit();

                }
                // cash
                elseif (($_POST['PaymentOption'] ?? '') == 'cash') {
                    $_POST['totalamount'] = $_POST['cashAmount'] ?? '';
                    $_POST['pay_date'] = $_POST['cashDate'] ?? '';
                    $_POST['DepositAccount'] = $_POST['CashDepositAccount'] ?? '';
                    $_POST['status'] = 'confirmed';
                    $_POST['payment_status'] = 'confirmed';
                    $_POST['id'] = $id;
                    $data = $_POST;
                    $datamemberarr = array();
                    $datamemberarr =  array_merge($_POST);
                    try { $pujaregistrationModel->update(array_merge($_POST)); } catch (Throwable $e) { $this->logPujaCartError('update(POST) ERROR | ' . $e->getMessage()); }
                    $value['oid'] = $_POST['oid'] ?? '';
                    $value['Member_id'] = $datamemberarr['Member_id'];
                    $value['MemberName'] = $datamemberarr['First_name'].' '.$datamemberarr['Last_name'];
                    $value['PaymentOption'] = $datamemberarr['PaymentOption'];
                    $value['payment_status'] = 'succeeded';
                    $value['payment_timestamp'] = $datamemberarr['payment_timestamp'] ?? '';
                    $value['stripe_return'] = $datamemberarr['stripe_return'] ?? '';
                    $value['transaction_id'] = $datamemberarr['transaction_id'];
                    $value['paid_amount'] = $datamemberarr['paid_amount'] ?? '';
                    $value['update_on'] = $datamemberarr['UpdateOn'];
                    $value['stripe_product'] = $datamemberarr['stripe_product'] ?? '';
                    $value['pay_date'] = $datamemberarr['pay_date'];
                    $value['pay_type'] = $datamemberarr['pay_type'];
                    $value['pay_for'] = $datamemberarr['pay_for'];
                    $value['Tele1'] = $datamemberarr['phone'];
                    $value['Tele2'] = $datamemberarr['alternatenumber'];
                    $value['email'] = $datamemberarr['email']; 
                    $value['spousename'] = $datamemberarr['Sp_fname'].' '.$datamemberarr['Sp_lname'];;
                    $value['Address'] = $datamemberarr['streetname'];
                    $value['Street'] = $datamemberarr['street'];
                    $value['City'] = $datamemberarr['city'];
                    $value['State'] = $datamemberarr['state'];
                    $value['Zip_Code'] = $datamemberarr['zip'];
                    $value['admin_id'] = $datamemberarr['admin_id'];
                    $value['admin_name'] = $datamemberarr['admin_name'];
                    $value['DepositAccount'] = $datamemberarr['DepositAccount'];
                    $extradonationamount = $datamemberarr['donation'];
                    $totalamountwithdonation = $datamemberarr['totalamount'];
                    $SecondAmount = $totalamountwithdonation - $extradonationamount;
                    
                    //try { $DonationModel->SaveDataInDonation($value); } catch (Throwable $donEx) { $this->logPujaCartError('SaveDataInDonation ERROR | ' . $donEx->getMessage()); }
                    if($extradonationamount == null){
                        $value['Amount'] = $datamemberarr['totalamount'];
                        try { $DonationModel->SaveDataInDonation($value); } catch (Throwable $donEx) { $this->logPujaCartError('SaveDataInDonation ERROR | ' . $donEx->getMessage()); }
                    }
                   if($extradonationamount != null){
                            for($i=0;$i<=1;$i++){
                                if($i==0){
                                    $value['pay_type'] = $datamemberarr['pay_type'];
                                    $value['pay_for'] = $datamemberarr['pay_for'];
                                    $value['Amount'] = $SecondAmount;
                                    try { $DonationModel->SaveDataInDonation($value); } catch (Throwable $donEx) { $this->logPujaCartError('SaveDataInDonation ERROR | ' . $donEx->getMessage()); }
                                }
                                if($i==1){
                                     $value['pay_type'] = 'Donation';
                                     $value['pay_for'] = 'DONATION / Unrestricted';
                                     $value['paymentfor'] = 'Puja Donation';
                                    $value['Amount'] = $extradonationamount;
                                    try { $DonationModel->SaveDataInDonation($value); } catch (Throwable $donEx) { $this->logPujaCartError('SaveDataInDonation ERROR | ' . $donEx->getMessage()); }
                                }
                                
                            }
                        }



                    if($datamember == null) {
                        $value = array();
                        // $value['id'] = $_POST['id'] ?? '';
                        $value['Payment_For'] = $_POST['Payment_For'] ?? '';
                        $value['MemberName'] = ($_POST['First_name'] ?? '') . ' ' . ($_POST['Last_name'] ?? '');
                        $value['Amount'] = $_POST['totalamount'] ?? '';
                        $value['PaymentOption'] = $_POST['PaymentOption'] ?? '';
                        $value['payment_status'] = 'confirmed';
                        $value['payment_timestamp'] = $_POST['payment_timestamp'] ?? '';
                        $value['stripe_return'] = $_POST['stripe_return'] ?? '';
                        $value['transaction_id'] = $_POST['transaction_id'] ?? '';
                        $value['paid_amount'] = $_POST['paid_amount'] ?? '';
                        $value['stripe_product'] = $_POST['stripe_product'] ?? '';
                        $value['update_on'] = $_POST['update_on'] ?? '';
                        $value['Member_id'] = $_POST['Member_id'] ?? '';
                        $value['pay_date'] = $_POST['pay_date'] ?? '';
                        $value['cc_name'] = $_POST['cc_name'] ?? '';
                        $value['remarks'] = $_POST['remarks'] ?? '';
                        $value['oid'] = $_POST['oid'] ?? '';
                        $value['pay_type'] = $_POST['pay_type'] ?? '';
                        $value['pay_for'] = $_POST['pay_for'] ?? '';
                        $value['Address'] = $_POST['streetname'] ?? '';
                        $value['Street'] = $_POST['street'] ?? '';
                        $value['Address'] = $_POST['streetname'] ?? '';
                        $value['Address3'] = $_POST['unit'] ?? '';
                        $value['Zip_Code'] = $_POST['zip'] ?? '';
                        $value['Tele2'] = $_POST['alternatenumber'] ?? '';
                        $value['email'] = $_POST['email'] ?? '';
                        $value['City'] = $_POST['city'] ?? '';
                        $value['State'] = $datamemberarr['state'];
                        $value['Tele1'] = $_POST['phone'] ?? '';
                        $value['spousename'] = ($_POST['Sp_fname'] ?? '') . ' ' . ($_POST['Sp_lname'] ?? '');
                        $value['Address3'] = $_POST['Address3'] ?? '';
                       // $value['Parent1'] = ($_POST['parent1_fname'] ?? '') .' '. ($_POST['parent1_lname'] ?? '');
                       // $value['Parent2'] = ($_POST['parent2_fname'] ?? '') .' '. ($_POST['parent2_lname'] ?? '');
                        $value['Child1'] = ($_POST['childonefname'] ?? '') . ' ' . ($_POST['childonelname'] ?? '');
                        $value['Child2'] = ($_POST['childtwofname'] ?? '') . ' ' . ($_POST['childtwolname'] ?? '');
                        $value['Child3'] = ($_POST['childthreefname'] ?? '') . ' ' . ($_POST['childthreelname'] ?? '');
                        $value['Age1'] = $_POST['Age1'] ?? '';
                        $value['Age2'] = $_POST['Age2'] ?? '';
                        $value['Age3'] = $_POST['Age3'] ?? '';
                        try { $MemberModel->SaveDataInmember($value); } catch (Throwable $e) { $this->logPujaCartError('SaveDataInmember ERROR | ' . $e->getMessage()); }
                    }

                     $email = $_POST['email'] ?? '';
                        if($email != null) {
                         $this->sendEmailticket($message, $subjetc, $email, $Emailcc);
                        }
                        $mobileno= $_POST['alternatenumber'] ?? '';
                            if ($mobileno != null) {
                                $this->SendSMS($mobileno, $textmsg );
                                }
                        $this->tpl['arr'] = $pujaregistrationModel->get($id);
                        if (session_status() === PHP_SESSION_NONE) { session_start(); }
                        if(($_POST['donation'] ?? '') != ""){
                            $memberid = $_POST['Member_id'] ?? '';
                            try { $confirmdata = $MemberModel->membercheck($memberid); } catch (Throwable $e) { $this->logPujaCartError('membercheck ERROR|'.$e->getMessage()); $confirmdata = []; }
                            $_SESSION['memberregisterpuja'] = $confirmdata;
                            try { $pujareg = $itemspujasponsorModel->registersankalpapujacheck($memberid); } catch (Throwable $e) { $this->logPujaCartError('registersankalpapujacheck ERROR|'.$e->getMessage()); $pujareg = []; }
                            $_SESSION['pujareg'] = $pujareg;
                            try { $sponsoreventfirst = $itemspujasponsorModel->sponsorevent1check($memberid); } catch (Throwable $e) { $this->logPujaCartError('sponsorevent1check ERROR|'.$e->getMessage()); $sponsoreventfirst = []; }
                            $_SESSION['sponsoreventfirst'] = $sponsoreventfirst;
                            try { $sponsoreventsecond = $itemspujasponsorModel->sponsorevent2check($memberid); } catch (Throwable $e) { $this->logPujaCartError('sponsorevent2check ERROR|'.$e->getMessage()); $sponsoreventsecond = []; }
                            $_SESSION['sponsoreventsecond'] = $sponsoreventsecond;
                            
                            try { $pujasankalpaattempt1arr = $itemspujasponsorModel->pujasankalpaattempt1($memberid); } catch (Throwable $e) { $this->logPujaCartError('pujasankalpaattempt1 ERROR|'.$e->getMessage()); $pujasankalpaattempt1arr = []; }
                            $_SESSION['pujasankalpaattempt1arr'] = $pujasankalpaattempt1arr;

                            try { $pujasankalpaattempt2arr = $itemspujasponsorModel->pujasankalpaattempt2($memberid); } catch (Throwable $e) { $this->logPujaCartError('pujasankalpaattempt2 ERROR|'.$e->getMessage()); $pujasankalpaattempt2arr = []; }
                            $_SESSION['pujasankalpaattempt2arr'] = $pujasankalpaattempt2arr;
                                
                                
                             try { $CategoryAarr = $sponsoritemModel->sponsorCategoryA(); } catch (Throwable $e) { $this->logPujaCartError('sponsorCategoryA ERROR|'.$e->getMessage()); $CategoryAarr = []; }
                             $_SESSION['CategoryAarr'] = $CategoryAarr;
             
                             try { $CategoryBarr = $sponsoritemModel->sponsorCategoryB(); } catch (Throwable $e) { $this->logPujaCartError('sponsorCategoryB ERROR|'.$e->getMessage()); $CategoryBarr = []; }
                             $_SESSION['CategoryBarr'] = $CategoryBarr;
                            $previousytd = is_numeric($_POST['YTD'] ?? '') ? (float)$_POST['YTD'] : 0;
                            $amountytd = is_numeric($_POST['donation'] ?? '') ? (float)$_POST['donation'] : 0;
                            $newytd = $previousytd + $amountytd; 
                            $_SESSION['ytdvalue'] = $newytd; 

                            }
                        $_SESSION['myValue']=$this->tpl['arr'];
                        Util::redirect(INSTALL_URL . "PujaCart/show/".$id); 
                    exit();

                }
                //directdeposite
                elseif (($_POST['PaymentOption'] ?? '') == 'directdeposit') {
                    $_POST['bank'] = $_POST['directbank'] ?? '';
                    $_POST['transaction_id'] = $_POST['transactioncode'] ?? '';
                    $_POST['totalamount'] = $_POST['directdepositeamount'] ?? '';
                    $_POST['pay_date'] = $_POST['transactiondate'] ?? '';
                    $_POST['DepositAccount'] = $_POST['DirectPayDepositAccount'] ?? '';
                    $_POST['status'] = 'confirmed';
                    $_POST['payment_status'] = 'confirmed';
                    $_POST['id'] = $id;
                    $data = $_POST;
                    $datamemberarr = array();
                    $datamemberarr =  array_merge($_POST);
                    try { $pujaregistrationModel->update(array_merge($_POST)); } catch (Throwable $e) { $this->logPujaCartError('update(POST) ERROR | ' . $e->getMessage()); }
                    $value['oid'] = $_POST['oid'] ?? '';
                    $value['Member_id'] = $datamemberarr['Member_id'];
                    $value['MemberName'] = $datamemberarr['First_name'].' '.$datamemberarr['Last_name'];
                    $value['PaymentOption'] = $datamemberarr['PaymentOption'];
                    $value['payment_status'] = 'succeeded';
                    $value['payment_timestamp'] = $datamemberarr['payment_timestamp'] ?? '';
                    $value['stripe_return'] = $datamemberarr['stripe_return'] ?? '';
                    $value['transaction_id'] = $datamemberarr['transaction_id'];
                    $value['paid_amount'] = $datamemberarr['paid_amount'] ?? '';
                    $value['update_on'] = $datamemberarr['UpdateOn'];
                    $value['stripe_product'] = $datamemberarr['stripe_product'] ?? '';
                    $value['pay_date'] = $datamemberarr['pay_date'];
                    $value['pay_type'] = $datamemberarr['pay_type'];
                    $value['pay_for'] = $datamemberarr['pay_for'];
                    $value['Tele1'] = $datamemberarr['phone'];
                    $value['Tele2'] = $datamemberarr['alternatenumber'];
                    $value['email'] = $datamemberarr['email']; 
                    $value['spousename'] = $datamemberarr['Sp_fname'].' '.$datamemberarr['Sp_lname'];;
                    $value['Address'] = $datamemberarr['streetname'];
                    $value['Street'] = $datamemberarr['street'];
                    $value['City'] = $datamemberarr['city'];
                    $value['State'] = $datamemberarr['state'];
                    $value['Zip_Code'] = $datamemberarr['zip'];
                    $value['admin_id'] = $datamemberarr['admin_id'];
                    $value['admin_name'] = $datamemberarr['admin_name'];
                    $value['DepositAccount'] = $datamemberarr['DepositAccount'];
                    $extradonationamount = $datamemberarr['donation'];
                    $totalamountwithdonation = $datamemberarr['totalamount'];
                    $SecondAmount = $totalamountwithdonation - $extradonationamount;
                    
                    //try { $DonationModel->SaveDataInDonation($value); } catch (Throwable $donEx) { $this->logPujaCartError('SaveDataInDonation ERROR | ' . $donEx->getMessage()); }
                    if($extradonationamount == null){
                        $value['Amount'] = $datamemberarr['totalamount'];
                        try { $DonationModel->SaveDataInDonation($value); } catch (Throwable $donEx) { $this->logPujaCartError('SaveDataInDonation ERROR | ' . $donEx->getMessage()); }
                    }
                   if($extradonationamount != null){
                            for($i=0;$i<=1;$i++){
                                if($i==0){
                                    $value['pay_type'] = $datamemberarr['pay_type'];
                                    $value['pay_for'] = $datamemberarr['pay_for'];
                                    $value['Amount'] = $SecondAmount;
                                    try { $DonationModel->SaveDataInDonation($value); } catch (Throwable $donEx) { $this->logPujaCartError('SaveDataInDonation ERROR | ' . $donEx->getMessage()); }
                                }
                                if($i==1){
                                     $value['pay_type'] = 'Donation';
                                     $value['pay_for'] = 'DONATION / Unrestricted';
                                      $value['paymentfor'] = 'Puja Donation';
                                    $value['Amount'] = $extradonationamount;
                                    try { $DonationModel->SaveDataInDonation($value); } catch (Throwable $donEx) { $this->logPujaCartError('SaveDataInDonation ERROR | ' . $donEx->getMessage()); }
                                }
                                
                            }
                        }



                    if($datamember == null) {
                        $value = array();
                        // $value['id'] = $_POST['id'] ?? '';
                        $value['Payment_For'] = $_POST['Payment_For'] ?? '';
                        $value['MemberName'] = ($_POST['First_name'] ?? '') . ' ' . ($_POST['Last_name'] ?? '');
                        $value['Amount'] = $_POST['totalamount'] ?? '';
                        $value['PaymentOption'] = $_POST['PaymentOption'] ?? '';
                        $value['payment_status'] = 'confirmed';
                        $value['payment_timestamp'] = $_POST['payment_timestamp'] ?? '';
                        $value['stripe_return'] = $_POST['stripe_return'] ?? '';
                        $value['transaction_id'] = $_POST['transaction_id'] ?? '';
                        $value['paid_amount'] = $_POST['paid_amount'] ?? '';
                        $value['stripe_product'] = $_POST['stripe_product'] ?? '';
                        $value['update_on'] = $_POST['update_on'] ?? '';
                        $value['Member_id'] = $_POST['Member_id'] ?? '';
                        $value['pay_date'] = $_POST['pay_date'] ?? '';
                        $value['cc_name'] = $_POST['cc_name'] ?? '';
                        $value['remarks'] = $_POST['remarks'] ?? '';
                        $value['oid'] = $_POST['oid'] ?? '';
                        $value['pay_type'] = $_POST['pay_type'] ?? '';
                        $value['pay_for'] = $_POST['pay_for'] ?? '';
                        $value['Address'] = $_POST['streetname'] ?? '';
                        $value['Street'] = $_POST['street'] ?? '';
                        $value['Address'] = $_POST['streetname'] ?? '';
                        $value['Address3'] = $_POST['unit'] ?? '';
                        $value['Zip_Code'] = $_POST['zip'] ?? '';
                        $value['Tele2'] = $_POST['alternatenumber'] ?? '';
                        $value['email'] = $_POST['email'] ?? '';
                        $value['City'] = $_POST['city'] ?? '';
                        $value['State'] = $datamemberarr['state'];
                        $value['Tele1'] = $_POST['phone'] ?? '';
                        $value['spousename'] = ($_POST['Sp_fname'] ?? '') . ' ' . ($_POST['Sp_lname'] ?? '');
                        $value['Address3'] = $_POST['Address3'] ?? '';
                        //$value['Parent1'] = ($_POST['parent1_fname'] ?? '') .' '. ($_POST['parent1_lname'] ?? '');
                        //$value['Parent2'] = ($_POST['parent2_fname'] ?? '') .' '. ($_POST['parent2_lname'] ?? '');
                        $value['Child1'] = ($_POST['childonefname'] ?? '') . ' ' . ($_POST['childonelname'] ?? '');
                        $value['Child2'] = ($_POST['childtwofname'] ?? '') . ' ' . ($_POST['childtwolname'] ?? '');
                        $value['Child3'] = ($_POST['childthreefname'] ?? '') . ' ' . ($_POST['childthreelname'] ?? '');
                        $value['Age1'] = $_POST['Age1'] ?? '';
                        $value['Age2'] = $_POST['Age2'] ?? '';
                        $value['Age3'] = $_POST['Age3'] ?? '';
                        try { $MemberModel->SaveDataInmember($value); } catch (Throwable $e) { $this->logPujaCartError('SaveDataInmember ERROR | ' . $e->getMessage()); }
                    }

                     $email = $_POST['email'] ?? '';
                        if($email != null) {
                         $this->sendEmailticket($message, $subjetc, $email, $Emailcc);
                        }
                        $mobileno= $_POST['alternatenumber'] ?? '';
                            if ($mobileno != null) {
                                $this->SendSMS($mobileno, $textmsg );
                                }
                        $this->tpl['arr'] = $pujaregistrationModel->get($id);
                        if (session_status() === PHP_SESSION_NONE) { session_start(); }
                        if(($_POST['donation'] ?? '') != ""){
                            $memberid = $_POST['Member_id'] ?? '';
                            try { $confirmdata = $MemberModel->membercheck($memberid); } catch (Throwable $e) { $this->logPujaCartError('membercheck ERROR|'.$e->getMessage()); $confirmdata = []; }
                            $_SESSION['memberregisterpuja'] = $confirmdata;
                            try { $pujareg = $itemspujasponsorModel->registersankalpapujacheck($memberid); } catch (Throwable $e) { $this->logPujaCartError('registersankalpapujacheck ERROR|'.$e->getMessage()); $pujareg = []; }
                            $_SESSION['pujareg'] = $pujareg;
                            try { $sponsoreventfirst = $itemspujasponsorModel->sponsorevent1check($memberid); } catch (Throwable $e) { $this->logPujaCartError('sponsorevent1check ERROR|'.$e->getMessage()); $sponsoreventfirst = []; }
                            $_SESSION['sponsoreventfirst'] = $sponsoreventfirst;
                            try { $sponsoreventsecond = $itemspujasponsorModel->sponsorevent2check($memberid); } catch (Throwable $e) { $this->logPujaCartError('sponsorevent2check ERROR|'.$e->getMessage()); $sponsoreventsecond = []; }
                            $_SESSION['sponsoreventsecond'] = $sponsoreventsecond;
                            
                            try { $pujasankalpaattempt1arr = $itemspujasponsorModel->pujasankalpaattempt1($memberid); } catch (Throwable $e) { $this->logPujaCartError('pujasankalpaattempt1 ERROR|'.$e->getMessage()); $pujasankalpaattempt1arr = []; }
                            $_SESSION['pujasankalpaattempt1arr'] = $pujasankalpaattempt1arr;

                            try { $pujasankalpaattempt2arr = $itemspujasponsorModel->pujasankalpaattempt2($memberid); } catch (Throwable $e) { $this->logPujaCartError('pujasankalpaattempt2 ERROR|'.$e->getMessage()); $pujasankalpaattempt2arr = []; }
                            $_SESSION['pujasankalpaattempt2arr'] = $pujasankalpaattempt2arr;
                                
                                
                            try { $CategoryAarr = $sponsoritemModel->sponsorCategoryA(); } catch (Throwable $e) { $this->logPujaCartError('sponsorCategoryA ERROR|'.$e->getMessage()); $CategoryAarr = []; }
                             $_SESSION['CategoryAarr'] = $CategoryAarr;
             
                             try { $CategoryBarr = $sponsoritemModel->sponsorCategoryB(); } catch (Throwable $e) { $this->logPujaCartError('sponsorCategoryB ERROR|'.$e->getMessage()); $CategoryBarr = []; }
                             $_SESSION['CategoryBarr'] = $CategoryBarr;
                            $previousytd = is_numeric($_POST['YTD'] ?? '') ? (float)$_POST['YTD'] : 0;
                            $amountytd = is_numeric($_POST['donation'] ?? '') ? (float)$_POST['donation'] : 0;
                            $newytd = $previousytd + $amountytd; 
                            $_SESSION['ytdvalue'] = $newytd; 

                            }
                        $_SESSION['myValue']=$this->tpl['arr'];
                        Util::redirect(INSTALL_URL . "PujaCart/show/".$id); 
                    exit();

                }
                //sumup
                elseif (($_POST['PaymentOption'] ?? '') == 'sumup') {
                    $_POST['totalamount'] = $_POST['sumupamount'] ?? '';
                    $_POST['transaction_id'] = $_POST['sumupid'] ?? '';
                    $_POST['pay_date'] = $_POST['sumupdate'] ?? '';
                    $_POST['DepositAccount'] = $_POST['SumUpDepositAccount'] ?? '';
                    $_POST['status'] = 'confirmed';
                    $_POST['payment_status'] = 'confirmed';
                    $_POST['id'] = $id;
                    $data = $_POST;
                    $datamemberarr = array();
                    $datamemberarr =  array_merge($_POST);
                    try { $pujaregistrationModel->update(array_merge($_POST)); } catch (Throwable $e) { $this->logPujaCartError('update(POST) ERROR | ' . $e->getMessage()); }
                    $value['oid'] = $_POST['oid'] ?? '';
                    $value['Member_id'] = $datamemberarr['Member_id'];
                    $value['MemberName'] = $datamemberarr['First_name'].' '.$datamemberarr['Last_name'];
                    $value['PaymentOption'] = $datamemberarr['PaymentOption'];
                    $value['payment_status'] = 'succeeded';
                    $value['payment_timestamp'] = $datamemberarr['payment_timestamp'] ?? '';
                    $value['stripe_return'] = $datamemberarr['stripe_return'] ?? '';
                    $value['transaction_id'] = $datamemberarr['transaction_id'];
                    $value['paid_amount'] = $datamemberarr['paid_amount'] ?? '';
                    $value['update_on'] = $datamemberarr['UpdateOn'];
                    $value['stripe_product'] = $datamemberarr['stripe_product'] ?? '';
                    $value['pay_date'] = $datamemberarr['pay_date'];
                    $value['pay_type'] = $datamemberarr['pay_type'];
                    $value['pay_for'] = $datamemberarr['pay_for'];
                    $value['Tele1'] = $datamemberarr['phone'];
                    $value['Tele2'] = $datamemberarr['alternatenumber'];
                    $value['email'] = $datamemberarr['email']; 
                    $value['spousename'] = $datamemberarr['Sp_fname'].' '.$datamemberarr['Sp_lname'];;
                    $value['Address'] = $datamemberarr['streetname'];
                    $value['Street'] = $datamemberarr['street'];
                    $value['City'] = $datamemberarr['city'];
                    $value['State'] = $datamemberarr['state'];
                    $value['Zip_Code'] = $datamemberarr['zip'];
                    $value['admin_id'] = $datamemberarr['admin_id'];
                    $value['admin_name'] = $datamemberarr['admin_name'];
                    $value['DepositAccount'] = $datamemberarr['DepositAccount'];
                    $extradonationamount = $datamemberarr['donation'];
                    $totalamountwithdonation = $datamemberarr['totalamount'];
                    $SecondAmount = $totalamountwithdonation - $extradonationamount;
                    
                    //try { $DonationModel->SaveDataInDonation($value); } catch (Throwable $donEx) { $this->logPujaCartError('SaveDataInDonation ERROR | ' . $donEx->getMessage()); }
                    if($extradonationamount == null){
                        $value['Amount'] = $datamemberarr['totalamount'];
                        try { $DonationModel->SaveDataInDonation($value); } catch (Throwable $donEx) { $this->logPujaCartError('SaveDataInDonation ERROR | ' . $donEx->getMessage()); }
                    }
                   if($extradonationamount != null){
                            for($i=0;$i<=1;$i++){
                                if($i==0){
                                    $value['pay_type'] = $datamemberarr['pay_type'];
                                    $value['pay_for'] = $datamemberarr['pay_for'];
                                    $value['Amount'] = $SecondAmount;
                                    try { $DonationModel->SaveDataInDonation($value); } catch (Throwable $donEx) { $this->logPujaCartError('SaveDataInDonation ERROR | ' . $donEx->getMessage()); }
                                }
                                if($i==1){
                                     $value['pay_type'] = 'Donation';
                                     $value['pay_for'] = 'DONATION / Unrestricted';
                                     $value['paymentfor'] = 'Puja Donation';
                                    $value['Amount'] = $extradonationamount;
                                    try { $DonationModel->SaveDataInDonation($value); } catch (Throwable $donEx) { $this->logPujaCartError('SaveDataInDonation ERROR | ' . $donEx->getMessage()); }
                                }
                                
                            }
                        }



                    if($datamember == null) {
                        $value = array();
                        // $value['id'] = $_POST['id'] ?? '';
                        $value['Payment_For'] = $_POST['Payment_For'] ?? '';
                        $value['MemberName'] = ($_POST['First_name'] ?? '') . ' ' . ($_POST['Last_name'] ?? '');
                        $value['Amount'] = $_POST['totalamount'] ?? '';
                        $value['PaymentOption'] = $_POST['PaymentOption'] ?? '';
                        $value['payment_status'] = 'confirmed';
                        $value['payment_timestamp'] = $_POST['payment_timestamp'] ?? '';
                        $value['stripe_return'] = $_POST['stripe_return'] ?? '';
                        $value['transaction_id'] = $_POST['transaction_id'] ?? '';
                        $value['paid_amount'] = $_POST['paid_amount'] ?? '';
                        $value['stripe_product'] = $_POST['stripe_product'] ?? '';
                        $value['update_on'] = $_POST['update_on'] ?? '';
                        $value['Member_id'] = $_POST['Member_id'] ?? '';
                        $value['pay_date'] = $_POST['pay_date'] ?? '';
                        $value['cc_name'] = $_POST['cc_name'] ?? '';
                        $value['remarks'] = $_POST['remarks'] ?? '';
                        $value['oid'] = $_POST['oid'] ?? '';
                        $value['pay_type'] = $_POST['pay_type'] ?? '';
                        $value['pay_for'] = $_POST['pay_for'] ?? '';
                        $value['Address'] = $_POST['streetname'] ?? '';
                        $value['Street'] = $_POST['street'] ?? '';
                        $value['Address'] = $_POST['streetname'] ?? '';
                        $value['Address3'] = $_POST['unit'] ?? '';
                        $value['Zip_Code'] = $_POST['zip'] ?? '';
                        $value['Tele2'] = $_POST['alternatenumber'] ?? '';
                        $value['email'] = $_POST['email'] ?? '';
                        $value['City'] = $_POST['city'] ?? '';
                        $value['State'] = $datamemberarr['state'];
                        $value['Tele1'] = $_POST['phone'] ?? '';
                        $value['spousename'] = ($_POST['Sp_fname'] ?? '') . ' ' . ($_POST['Sp_lname'] ?? '');
                        $value['Address3'] = $_POST['Address3'] ?? '';
                       // $value['Parent1'] = ($_POST['parent1_fname'] ?? '') .' '. ($_POST['parent1_lname'] ?? '');
                       // $value['Parent2'] = ($_POST['parent2_fname'] ?? '') .' '. ($_POST['parent2_lname'] ?? '');
                        $value['Child1'] = ($_POST['childonefname'] ?? '') . ' ' . ($_POST['childonelname'] ?? '');
                        $value['Child2'] = ($_POST['childtwofname'] ?? '') . ' ' . ($_POST['childtwolname'] ?? '');
                        $value['Child3'] = ($_POST['childthreefname'] ?? '') . ' ' . ($_POST['childthreelname'] ?? '');
                        $value['Age1'] = $_POST['Age1'] ?? '';
                        $value['Age2'] = $_POST['Age2'] ?? '';
                        $value['Age3'] = $_POST['Age3'] ?? '';
                        try { $MemberModel->SaveDataInmember($value); } catch (Throwable $e) { $this->logPujaCartError('SaveDataInmember ERROR | ' . $e->getMessage()); }
                    }

                     $email = $_POST['email'] ?? '';
                        if($email != null) {
                         $this->sendEmailticket($message, $subjetc, $email, $Emailcc);
                        }
                        $mobileno= $_POST['alternatenumber'] ?? '';
                            if ($mobileno != null) {
                                $this->SendSMS($mobileno, $textmsg );
                                }
                        $this->tpl['arr'] = $pujaregistrationModel->get($id);
                        if (session_status() === PHP_SESSION_NONE) { session_start(); }
                        if(($_POST['donation'] ?? '') != ""){
                            $memberid = $_POST['Member_id'] ?? '';
                            try { $confirmdata = $MemberModel->membercheck($memberid); } catch (Throwable $e) { $this->logPujaCartError('membercheck ERROR|'.$e->getMessage()); $confirmdata = []; }
                            $_SESSION['memberregisterpuja'] = $confirmdata;
                            try { $pujareg = $itemspujasponsorModel->registersankalpapujacheck($memberid); } catch (Throwable $e) { $this->logPujaCartError('registersankalpapujacheck ERROR|'.$e->getMessage()); $pujareg = []; }
                            $_SESSION['pujareg'] = $pujareg;
                            try { $sponsoreventfirst = $itemspujasponsorModel->sponsorevent1check($memberid); } catch (Throwable $e) { $this->logPujaCartError('sponsorevent1check ERROR|'.$e->getMessage()); $sponsoreventfirst = []; }
                            $_SESSION['sponsoreventfirst'] = $sponsoreventfirst;
                            try { $sponsoreventsecond = $itemspujasponsorModel->sponsorevent2check($memberid); } catch (Throwable $e) { $this->logPujaCartError('sponsorevent2check ERROR|'.$e->getMessage()); $sponsoreventsecond = []; }
                            $_SESSION['sponsoreventsecond'] = $sponsoreventsecond;
                            
                            try { $pujasankalpaattempt1arr = $itemspujasponsorModel->pujasankalpaattempt1($memberid); } catch (Throwable $e) { $this->logPujaCartError('pujasankalpaattempt1 ERROR|'.$e->getMessage()); $pujasankalpaattempt1arr = []; }
                            $_SESSION['pujasankalpaattempt1arr'] = $pujasankalpaattempt1arr;

                            try { $pujasankalpaattempt2arr = $itemspujasponsorModel->pujasankalpaattempt2($memberid); } catch (Throwable $e) { $this->logPujaCartError('pujasankalpaattempt2 ERROR|'.$e->getMessage()); $pujasankalpaattempt2arr = []; }
                            $_SESSION['pujasankalpaattempt2arr'] = $pujasankalpaattempt2arr;
                            
                            try { $CategoryAarr = $sponsoritemModel->sponsorCategoryA(); } catch (Throwable $e) { $this->logPujaCartError('sponsorCategoryA ERROR|'.$e->getMessage()); $CategoryAarr = []; }
                             $_SESSION['CategoryAarr'] = $CategoryAarr;
             
                             try { $CategoryBarr = $sponsoritemModel->sponsorCategoryB(); } catch (Throwable $e) { $this->logPujaCartError('sponsorCategoryB ERROR|'.$e->getMessage()); $CategoryBarr = []; }
                             $_SESSION['CategoryBarr'] = $CategoryBarr;
                            $previousytd = is_numeric($_POST['YTD'] ?? '') ? (float)$_POST['YTD'] : 0;
                            $amountytd = is_numeric($_POST['donation'] ?? '') ? (float)$_POST['donation'] : 0;
                            $newytd = $previousytd + $amountytd; 
                            $_SESSION['ytdvalue'] = $newytd; 

                            }
                        $_SESSION['myValue']=$this->tpl['arr'];
                        Util::redirect(INSTALL_URL . "PujaCart/show/".$id); 
                    exit();

                }
                  //Coplimentory Registration
                elseif (($_POST['PaymentOption'] ?? '') == 'ComplimentaryRegistration') {
                    
                    //$opts['payment_status'] = 'confirmed';
                    $_POST['payment_status'] = 'confirmed';
                    $_POST['status'] = 'confirmed';
                    $_POST['id'] = $id;

                    try { $pujaregistrationModel->update(array_merge($_POST)); } catch (Throwable $e) { $this->logPujaCartError('update(POST) ERROR | ' . $e->getMessage()); }
                
                    $orderid = $_POST['oid'] ?? '';
                    $Memberid = $_POST['Member_id'] ?? '';
                    $membername = ($_POST['First_name'] ?? '') .' ' . ($_POST['Last_name'] ?? '');
                    $pujatype = $_POST['puja_type'] ?? '';
                    $Status = "Confirmed";
                    $today = date("m/d/Y"); 
                    $registrationDate = $today;
                    $payMethod = "Complimentary Registration";


                    $Emailcc = 'pujaregpayment@durgabari.org';
                    $subjetEmail = 'Puja Registration Confirmation';
                    $emailmessage = '<p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</p>
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
                    <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">' . $orderid  . '</td>
                    </tr>
                    <tr>
                    <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Member Id&nbsp;&nbsp;</td>
                    <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">' . $Memberid  . '</td>
                    </tr> 
                    <tr>
                    <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Full Name&nbsp;&nbsp;</td>
                    <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">' . $membername  . '</td>
                    </tr>
                    <tr>
                    <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Puja Type&nbsp;&nbsp;</td>
                    <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $pujatype . '</td>
                    </tr>
                    <tr>
                    <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Payment Method &nbsp;</td>
                    <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $payMethod . '</td>
                    </tr>
                    <tr>
                    <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Registration Date &nbsp;</td>
                    <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $registrationDate . '</td>
                    </tr>
                    <tr>
                    <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Status &nbsp;</td>
                    <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $Status . '</td>
                    </tr>
                    </tbody>
                    </table>
                    </div>
                    </div>
                    </div>';
                     $email = $_POST['email'] ?? '';
                        if($email != null) {
                         $this->sendEmailticket($emailmessage, $subjetEmail, $email, $Emailcc);
                        }
                        $mobileno= $_POST['alternatenumber'] ?? '';
                        if ($mobileno != null) {
                            $registrationConfirmationMsg = 'Houston Durga Bari: Puja Registration confirmation are Order Id: ' . $orderid . ', Member Id: ' . $Memberid . ', Full Name: ' . $membername . ', Puja Type: ' . $pujatype . ', Payment Method: ' . $payMethod.',Registration Date: ' . $registrationDate . ', Status: ' . $Status ;
                           $this->SendSMS($mobileno, $registrationConfirmationMsg );
                        }
                        $this->tpl['arr'] = $pujaregistrationModel->get($id);
                        if (session_status() === PHP_SESSION_NONE) { session_start(); }
                        $_SESSION['myValue']=$this->tpl['arr'];
                        Util::redirect(INSTALL_URL . "PujaCart/show/".$id); 
                    exit();

                }
                  // stripe
                elseif (($_POST['PaymentOption'] ?? '') == 'stripe') {
                    //$token = $_POST['stripeToken'] ?? '';
                    // echo "<script>alert('$token')</script>";

                    $amount = $_POST['totalamount'] ?? '';
                    
                    $total = $amount;

                    require APP_PATH . '/helpers/stripe/lib/Stripe.php';

                    $error = '';
                    $success = '';

                    try {
                        $stripeApiKey = $this->getPujaCartStripeApiKey();
                        if ($stripeApiKey === '') {
                            throw new Exception("Stripe API key is not configured.");
                        }
                        Stripe::setApiKey($stripeApiKey);
                        if (!isset($_POST['stripeToken'])) {
                            throw new Exception("The Stripe Token was not generated correctly");
                        }
                        $oid = $_POST['oid'] ?? '';
                        $amount = round($amount * 100);

                        $payment = Stripe_Charge::create(array(
                                    "amount" => $amount,
                                    "currency" => "USD",
                                    //"currency" => $this->tpl["option_arr_values"]["currency"],
                                    "card" => $_POST['stripeToken'] ?? '',
                                   "description" =>  "Pay For:Registration/" . ($_POST['pay_for'] ?? '') . ', ' . "Email:" . ($_POST['email'] ?? '') . ', ' . "Full Name:" . ($_POST['First_name'] ?? '') . ' ' . ($_POST['Last_name'] ?? ''),
                                    "metadata" => ["orderid" => $oid]
                        ));

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
                            //$opts['payment_status'] = 'succeeded';
                            $opts['status'] = 'confirmed';
                            $opts['payment_timestamp'] = time();
                            $data = $_POST;
                            $datamemberarr = array();
                            $datamemberarr =  array_merge($opts, $_POST);
                            try { $pujaregistrationModel->update(array_merge($opts, $_POST)); } catch (Throwable $e) { $this->logPujaCartError('update(opts+POST) ERROR | ' . $e->getMessage()); }
                            $value['oid'] = $oid;
                        $value['Member_id'] = $datamemberarr['Member_id'];
                        $value['MemberName'] = $datamemberarr['First_name'].' '.$datamemberarr['Last_name'];
                        $value['PaymentOption'] = $datamemberarr['PaymentOption'];
                        $value['payment_status'] = 'succeeded';
                        $value['payment_timestamp'] = $datamemberarr['payment_timestamp'] ?? '';
                        $value['stripe_return'] = $datamemberarr['stripe_return'] ?? '';
                        $value['transaction_id'] = $datamemberarr['transaction_id'];
                        $value['paid_amount'] = $datamemberarr['paid_amount'] ?? '';
                        $value['update_on'] = $datamemberarr['UpdateOn'];
                        $value['stripe_product'] = $datamemberarr['stripe_product'] ?? '';
                        $value['pay_date'] = $datamemberarr['pay_date'];
                        $value['pay_type'] = $datamemberarr['pay_type'];
                        $value['pay_for'] = $datamemberarr['pay_for'];
                        $value['Tele1'] = $datamemberarr['phone'];
                        $value['Tele2'] = $datamemberarr['alternatenumber'];
                        $value['email'] = $datamemberarr['email']; 
                        $value['spousename'] = $datamemberarr['Sp_fname'].' '.$datamemberarr['Sp_lname'];;
                        $value['Address'] = $datamemberarr['streetname'];
                        $value['Street'] = $datamemberarr['street'];
                        $value['City'] = $datamemberarr['city'];
                        $value['State'] = $datamemberarr['state'];
                        $value['Zip_Code'] = $datamemberarr['zip'];
                        $value['admin_id'] = $datamemberarr['admin_id'];
                        $value['admin_name'] = $datamemberarr['admin_name'];
                         //$value['Amount'] = $datamemberarr['totalamount'];
                        $extradonationamount = $datamemberarr['donation'];
                        $totalamountwithdonation = $datamemberarr['totalamount'];
                       
                        $SecondAmount = $totalamountwithdonation - $extradonationamount;
                        //try { $DonationModel->SaveDataInDonation($value); } catch (Throwable $donEx) { $this->logPujaCartError('SaveDataInDonation ERROR | ' . $donEx->getMessage()); }
                        if($extradonationamount == null){
                            $value['Amount'] = $datamemberarr['totalamount'];
                            try { $DonationModel->SaveDataInDonation($value); } catch (Throwable $donEx) { $this->logPujaCartError('SaveDataInDonation ERROR | ' . $donEx->getMessage()); }
                        }
                       if($extradonationamount != null){
                                for($i=0;$i<=1;$i++){
                                    if($i==0){

                                        $value['pay_type'] = $datamemberarr['pay_type'];
                                        $value['pay_for'] = $datamemberarr['pay_for'];
                                        $value['Amount'] = $SecondAmount;
                                        try { $DonationModel->SaveDataInDonation($value); } catch (Throwable $donEx) { $this->logPujaCartError('SaveDataInDonation ERROR | ' . $donEx->getMessage()); }
                                    }
                                    if($i==1){
                                         $value['pay_type'] = 'Donation';
                                         $value['pay_for'] = 'DONATION / Unrestricted';
                                         $value['paymentfor'] = 'Puja Donation';
                                        $value['Amount'] = $extradonationamount;
                                        try { $DonationModel->SaveDataInDonation($value); } catch (Throwable $donEx) { $this->logPujaCartError('SaveDataInDonation ERROR | ' . $donEx->getMessage()); }
                                    }
                                    
                                }
                            }


                            if($datamember == null) {
                                $value = array();
                                // $value['id'] = $_POST['id'] ?? '';
                                $value['Payment_For'] = $_POST['Payment_For'] ?? '';
                                $value['MemberName'] = ($_POST['First_name'] ?? '') . ' ' . ($_POST['Last_name'] ?? '');
                                $value['Amount'] = $_POST['totalamount'] ?? '';
                                $value['PaymentOption'] = $_POST['PaymentOption'] ?? '';
                                $value['payment_status'] = 'confirmed';
                                $value['payment_timestamp'] = $opts['payment_timestamp'] ?? '';
                                $value['stripe_return'] = $opts['stripe_return'] ?? '';
                                $value['transaction_id'] = $opts['transaction_id'];
                                $value['paid_amount'] = $opts['paid_amount'] ?? '';
                                $value['stripe_product'] = $opts['stripe_product'] ?? '';
                                $value['update_on'] = $_POST['update_on'] ?? '';
                                $value['Member_id'] = $_POST['Member_id'] ?? '';
                                $value['pay_date'] = $_POST['pay_date'] ?? '';
                                $value['cc_name'] = $_POST['cc_name'] ?? '';
                                $value['remarks'] = $_POST['remarks'] ?? '';
                                $value['oid'] = $_POST['oid'] ?? '';
                                $value['pay_type'] = $_POST['pay_type'] ?? '';
                                $value['pay_for'] = $_POST['pay_for'] ?? '';
                                $value['Address'] = $_POST['streetname'] ?? '';
                                $value['Street'] = $_POST['street'] ?? '';
                                $value['Address'] = $_POST['streetname'] ?? '';
                                $value['Address3'] = $_POST['unit'] ?? '';
                                $value['Zip_Code'] = $_POST['zip'] ?? '';
                                $value['Tele2'] = $_POST['alternatenumber'] ?? '';
                                $value['email'] = $_POST['email'] ?? '';
                                $value['City'] = $_POST['city'] ?? '';
                                $value['State'] = $datamemberarr['state'];
                                $value['Tele1'] = $_POST['phone'] ?? '';
                                $value['spousename'] = ($_POST['Sp_fname'] ?? '') . ' ' . ($_POST['Sp_lname'] ?? '');
                                $value['Address3'] = $_POST['Address3'] ?? '';
                               // $value['Parent1'] = ($_POST['parent1_fname'] ?? '') .' '. ($_POST['parent1_lname'] ?? '');
                                //$value['Parent2'] = ($_POST['parent2_fname'] ?? '') .' '. ($_POST['parent2_lname'] ?? '');
                                $value['Child1'] = ($_POST['childonefname'] ?? '') . ' ' . ($_POST['childonelname'] ?? '');
                                $value['Child2'] = ($_POST['childtwofname'] ?? '') . ' ' . ($_POST['childtwolname'] ?? '');
                                $value['Child3'] = ($_POST['childthreefname'] ?? '') . ' ' . ($_POST['childthreelname'] ?? '');
                                $value['Age1'] = $_POST['Age1'] ?? '';
                                $value['Age2'] = $_POST['Age2'] ?? '';
                                $value['Age3'] = $_POST['Age3'] ?? '';
                                try { $MemberModel->SaveDataInmember($value); } catch (Throwable $e) { $this->logPujaCartError('SaveDataInmember ERROR | ' . $e->getMessage()); }
                            }
                            $email = $_POST['email'] ?? '';
                        if($email != null) {
                         $this->sendEmailticket($message, $subjetc, $email, $Emailcc);
                        }
                        $mobileno= $_POST['alternatenumber'] ?? '';
                            if ($mobileno != null) {
                                $this->SendSMS($mobileno, $textmsg );
                                }

                            $this->tpl['arr'] = $pujaregistrationModel->get($id);
                            if (session_status() === PHP_SESSION_NONE) { session_start(); }
                            if(($_POST['donation'] ?? '') != ""){
                                $memberid = $_POST['Member_id'] ?? '';
                                try { $confirmdata = $MemberModel->membercheck($memberid); } catch (Throwable $e) { $this->logPujaCartError('membercheck ERROR|'.$e->getMessage()); $confirmdata = []; }
                                $_SESSION['memberregisterpuja'] = $confirmdata;
                                try { $pujareg = $itemspujasponsorModel->registersankalpapujacheck($memberid); } catch (Throwable $e) { $this->logPujaCartError('registersankalpapujacheck ERROR|'.$e->getMessage()); $pujareg = []; }
                                $_SESSION['pujareg'] = $pujareg;
                                try { $sponsoreventfirst = $itemspujasponsorModel->sponsorevent1check($memberid); } catch (Throwable $e) { $this->logPujaCartError('sponsorevent1check ERROR|'.$e->getMessage()); $sponsoreventfirst = []; }
                                $_SESSION['sponsoreventfirst'] = $sponsoreventfirst;
                                try { $sponsoreventsecond = $itemspujasponsorModel->sponsorevent2check($memberid); } catch (Throwable $e) { $this->logPujaCartError('sponsorevent2check ERROR|'.$e->getMessage()); $sponsoreventsecond = []; }
                                $_SESSION['sponsoreventsecond'] = $sponsoreventsecond;
                                
                                try { $pujasankalpaattempt1arr = $itemspujasponsorModel->pujasankalpaattempt1($memberid); } catch (Throwable $e) { $this->logPujaCartError('pujasankalpaattempt1 ERROR|'.$e->getMessage()); $pujasankalpaattempt1arr = []; }
                                $_SESSION['pujasankalpaattempt1arr'] = $pujasankalpaattempt1arr;

                                try { $pujasankalpaattempt2arr = $itemspujasponsorModel->pujasankalpaattempt2($memberid); } catch (Throwable $e) { $this->logPujaCartError('pujasankalpaattempt2 ERROR|'.$e->getMessage()); $pujasankalpaattempt2arr = []; }
                                $_SESSION['pujasankalpaattempt2arr'] = $pujasankalpaattempt2arr;
                                
                                try { $CategoryAarr = $sponsoritemModel->sponsorCategoryA(); } catch (Throwable $e) { $this->logPujaCartError('sponsorCategoryA ERROR|'.$e->getMessage()); $CategoryAarr = []; }
                                $_SESSION['CategoryAarr'] = $CategoryAarr;
             
                                try { $CategoryBarr = $sponsoritemModel->sponsorCategoryB(); } catch (Throwable $e) { $this->logPujaCartError('sponsorCategoryB ERROR|'.$e->getMessage()); $CategoryBarr = []; }
                                $_SESSION['CategoryBarr'] = $CategoryBarr;
                                $previousytd = is_numeric($_POST['YTD'] ?? '') ? (float)$_POST['YTD'] : 0;
                                $amountytd = is_numeric($_POST['donation'] ?? '') ? (float)$_POST['donation'] : 0;
                                $newytd = $previousytd + $amountytd; 
                                $_SESSION['ytdvalue'] = $newytd; 
    
                                }
                            $_SESSION['myValue']=$this->tpl['arr'];
                            Util::redirect(INSTALL_URL . "PujaCart/show/".$id); 
                        } else {

                            $opts = array();
                            $opts['id'] = $id;
                            $opts['stripe_return'] = $payment->status;
                            $opts['transaction_id'] = $payment->id;
                            $opts['paid_amount'] = $payment->amount;
                            $opts['stripe_product'] = $payment->description;

                            try { $pujaregistrationModel->update($opts); } catch (Throwable $e) { $this->logPujaCartError('stripe declined update ERROR | ' . $e->getMessage()); }

                            $_SESSION['status'] = '<strong>' . __('declined_card') . '</strong>';
                        }
                    } catch (Throwable $ex) {
                        $this->logPujaCartError('stripe payment ERROR | ' . $ex->getMessage());
                        $_SESSION['status'] = $ex->getMessage();
                    }
                    
                    $this->tpl['arr'] = $pujaregistrationModel->get($id);
                    $this->tpl['arr']['amount'] = $total;
                }else{
                     $_SESSION['status'] = 16;
                    
                }
            } else {
                $_SESSION['status'] = 17;
            }

            if (!empty($id)) {
                if (session_status() === PHP_SESSION_NONE) { session_start(); }
                $this->tpl['arr'] = $pujaregistrationModel->get($id);
                $_SESSION['myValue'] = $this->tpl['arr'];
                Util::redirect(INSTALL_URL . "PujaCart/show/" . $id);
            }
            exit();
        }

    }



  private function logPujaCartError($message) {
      $logFile = __DIR__ . '/../../pujaregistrationlog.log';
      file_put_contents($logFile, '[' . date('Y-m-d H:i:s') . '] [PujaCart] ' . $message . PHP_EOL, FILE_APPEND);
  }

  private function getPujaCartStripeApiKey() {
      $stripeApiKey = trim((string)($this->tpl["option_arr_values"]["stripe_api_key"] ?? ''));
      if ($stripeApiKey !== '') {
          return $stripeApiKey;
      }

      $stripeApiKey = trim((string)($this->option_arr["stripe_api_key"] ?? ''));
      if ($stripeApiKey !== '') {
          return $stripeApiKey;
      }

      try {
          GzObject::loadFiles('Model', 'Option');
          $OptionModel = new OptionModel();
          $options = $OptionModel->getAllPairValues();
          $stripeApiKey = trim((string)($options["stripe_api_key"] ?? ''));
          if ($stripeApiKey !== '') {
              $this->option_arr = $options;
              $this->tpl['option_arr_values'] = $options;
              return $stripeApiKey;
          }
      } catch (Throwable $e) {
          $this->logPujaCartError('stripe option reload ERROR | ' . $e->getMessage());
      }

      foreach (array('STRIPE_API_KEY', 'STRIPE_SECRET_KEY') as $envKey) {
          $stripeApiKey = trim((string)getenv($envKey));
          if ($stripeApiKey !== '') {
              return $stripeApiKey;
          }
      }

      return '';
  }

  private function validateRegistrationDocumentUpload($file)
  {
      if (empty($file['name']) || empty($file['tmp_name'])) {
          return '';
      }

      $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
      $allowedExtensions = array('jpg', 'jpeg', 'png', 'pdf');
      $maxSize = 8 * 1024 * 1024;

      if (!in_array($extension, $allowedExtensions)) {
          return 'only jpg, jpeg, png, or pdf files are allowed.';
      }

      if (!empty($file['size']) && $file['size'] > $maxSize) {
          return 'file size must be 8 MB or less.';
      }

      if ($extension !== 'pdf') {
          $imageSize = @getimagesize($file['tmp_name']);
          if (empty($imageSize) || $imageSize[0] < 800 || $imageSize[1] < 500) {
              return 'document image is too small or not clear enough. Please upload a clearer document.';
          }

          $aspectRatio = $imageSize[0] / max(1, $imageSize[1]);
          if ($aspectRatio < 0.45 || $aspectRatio > 3.2) {
              return 'document image is not framed clearly. Please upload the full document.';
          }

          $clarityError = $this->validateRegistrationDocumentImageClarity($file['tmp_name'], $extension);
          if ($clarityError !== '') {
              return $clarityError;
          }
      }

      return '';
  }

  private function validateRegistrationDocumentImageClarity($path, $extension)
  {
      if (!function_exists('imagecreatefromjpeg') || !function_exists('imagecreatefrompng')) {
          return '';
      }

      $extension = strtolower($extension);
      if ($extension === 'jpg' || $extension === 'jpeg') {
          $image = @imagecreatefromjpeg($path);
      } elseif ($extension === 'png') {
          $image = @imagecreatefrompng($path);
      } else {
          return '';
      }

      if (!$image) {
          return 'document image could not be read. Please upload a jpg, png, or pdf file.';
      }

      $width = imagesx($image);
      $height = imagesy($image);
      $stepX = max(1, (int) floor($width / 80));
      $stepY = max(1, (int) floor($height / 80));
      $count = 0;
      $sum = 0;
      $sumSquares = 0;

      for ($y = 0; $y < $height; $y += $stepY) {
          for ($x = 0; $x < $width; $x += $stepX) {
              $rgb = imagecolorat($image, $x, $y);
              $red = ($rgb >> 16) & 0xFF;
              $green = ($rgb >> 8) & 0xFF;
              $blue = $rgb & 0xFF;
              $gray = (0.299 * $red) + (0.587 * $green) + (0.114 * $blue);
              $sum += $gray;
              $sumSquares += ($gray * $gray);
              $count++;
          }
      }

      imagedestroy($image);

      if ($count <= 0) {
          return '';
      }

      $average = $sum / $count;
      $variance = max(0, ($sumSquares / $count) - ($average * $average));
      $contrast = sqrt($variance);

      if ($average < 45) {
          return 'document image is too dark. Please upload a clearer document.';
      }

      if ($average > 235) {
          return 'document image is too light or washed out. Please upload a clearer document.';
      }

      if ($contrast < 18) {
          return 'document image has low contrast and may not be legible. Please upload a clearer document.';
      }

      return '';
  }

  function PujaCart() {
    // action method — __construct() handles data loading
  }

  function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->layout = 'login';
        GzObject::loadFiles('Model', array('pujaregistration', 'Donation', 'ConfirmCode', 'Member', 'idnumbers', 'itemspujasponsor', 'User', 'sponsoritem', 'paidparking'));
         $pujaregistrationModel = new pujaregistrationModel();
         try { $pujaregistrationModel->syncSchemaWithTableColumns(); } catch (Throwable $e) { $this->logPujaCartError('syncSchemaWithTableColumns ERROR | ' . $e->getMessage()); }
        $DonationModel = new DonationModel();
        $ConfirmCodeModel = new ConfirmCodeModel();
        $MemberModel = new MemberModel();
        $idnumbersModel = new idnumbersModel();
        $itemspujasponsorModel = new itemspujasponsorModel();
        $UserModel = new UserModel();
        $sponsoritemModel = new sponsoritemModel();

        $paidparkingModel = new paidparkingModel();

        // Dinner coupon fields removed from Puja Registration per 2026 client change.
        // Ignore any stale values posted by old pages or browser cache.
        unset($_POST['adultCouponQty'], $_POST['childCouponQty'], $_POST['totalCouponPrice']);
        unset($_SESSION['adultCoupon'], $_SESSION['childCoupon'], $_SESSION['totalCouponPrice']);

        $MemberId = $_POST['Member_id'] ?? '';
        $Senior = $_POST['senior'] ?? '';
        if ($MemberId != "" && $Senior != "") {
            if ($Senior == '1') {
                $SeniorCheck = 'YES';
                $MemberModel->UpdateSenior($MemberId, $SeniorCheck);
            }
        }

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            unset($_SESSION['pujakart_payment_processed']);
        }

        if (!empty($_POST['get_cart'])) {
            $_POST['totalamount'] = is_numeric($_POST['totalamount'] ?? '') ? (float) $_POST['totalamount'] : 0;
            $_POST['Age1'] = isset($_POST['Age1']) && is_numeric($_POST['Age1']) ? (int) $_POST['Age1'] : 0;
            $_POST['Age2'] = isset($_POST['Age2']) && is_numeric($_POST['Age2']) ? (int) $_POST['Age2'] : 0;
            $_POST['Age3'] = isset($_POST['Age3']) && is_numeric($_POST['Age3']) ? (int) $_POST['Age3'] : 0;
            $this->applyAdultChildRegistrationPricing($_POST);
        }

        if (!empty($_POST['create_requestpujaregistration']) && !empty($_FILES['image']['name'])) {
            $conflict = $pujaregistrationModel->getPujaRegistrationConflict($_POST['Member_id'] ?? '', $_POST['puja_type'] ?? '');
            if (!empty($_POST['Member_id']) && !empty($conflict['blocked'])) {
                echo "<div style='color:red;padding:20px;font-size:18px;'>" . htmlspecialchars($conflict['message'], ENT_QUOTES) . "</div>";
                echo "<a href='javascript:history.back()'>Go Back</a>";
                exit();
            }

            $data = array();
            if (!empty($_FILES['image'])) {
                $documentUploadError = $this->validateRegistrationDocumentUpload($_FILES['image']);
                if ($documentUploadError !== '') {
                    echo "<div style='color:#d71920;padding:20px;font-size:18px;font-weight:bold;'>Upload failed: " . htmlspecialchars($documentUploadError) . "</div>";
                    echo "<a href='javascript:history.back()'>Go Back</a>";
                    exit();
                }


                $fileextension = $_FILES['image']['type'];
                $newfileextension = explode("/", $fileextension);
                $filetype = strtolower($newfileextension[1]);
                if ($filetype == "pdf") {
                    require_once APP_PATH . 'helpers/uploader/class.upload.php';
                    $targetfolder = INSTALL_PATH . UPLOAD_PATH . 'avatar/thumb/';
                    $imgdata = $_FILES['image']['name'];
                    $newimgdata = explode(".", $imgdata);
                    $img_name = time();
                    //$finaldocumentname = $img_name.'.'.$newimgdata[1];
                    $finaldocumentname = $img_name . '.' . $filetype;
                    $targetfolder = $targetfolder . basename($finaldocumentname);

                    if (move_uploaded_file($_FILES['image']['tmp_name'], $targetfolder)) {
                        $data['addressavatar'] = $finaldocumentname;
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
                            $data['addressavatar'] = $handle->file_dst_name;
                            $handle->clean();
                        } else {
                            echo 'error : ' . $handle->error;
                        }
                    }
                }
            }
            date_default_timezone_set("America/Chicago");
            $today = date("Y/m/d");
            $_POST['CreatedAt'] = $today;
            $_POST['amount']      = is_numeric($_POST['puja_amount']  ?? '') ? (float)$_POST['puja_amount']  : 0;
            $_POST['donation']    = is_numeric($_POST['donation']      ?? '') ? (float)$_POST['donation']      : 0;
            $_POST['totalamount'] = is_numeric($_POST['totalamount']   ?? '') ? (float)$_POST['totalamount']   : 0;
            $_POST['magazineprice'] = $_POST['extramagazineamount'] ?? '';
            $_POST['member_veggie']  = isset($_POST['member_veggie'])  && is_numeric($_POST['member_veggie'])  ? (int)$_POST['member_veggie']  : 0;
            $_POST['spouse_veggie']  = isset($_POST['spouse_veggie'])  && is_numeric($_POST['spouse_veggie'])  ? (int)$_POST['spouse_veggie']  : 0;
            $_POST['senior']         = isset($_POST['senior'])         && is_numeric($_POST['senior'])         ? (int)$_POST['senior']         : 0;
            $_POST['swap_spouse']    = isset($_POST['swap_spouse'])    && is_numeric($_POST['swap_spouse'])    ? (int)$_POST['swap_spouse']    : 0;
            $_POST['Age1']           = isset($_POST['Age1'])           && is_numeric($_POST['Age1'])           ? (int)$_POST['Age1']           : 0;
            $_POST['Age2']           = isset($_POST['Age2'])           && is_numeric($_POST['Age2'])           ? (int)$_POST['Age2']           : 0;
            $_POST['Age3']           = isset($_POST['Age3'])           && is_numeric($_POST['Age3'])           ? (int)$_POST['Age3']           : 0;
            $this->applyAdultChildRegistrationPricing($_POST);
            // NOT NULL varchar columns with no DB default — must always be present
            $_POST['studentavatar'] = $data['studentavatar'] ?? ($_POST['studentavatar'] ?? '');
            $_POST['addressavatar'] = $data['addressavatar'] ?? ($_POST['addressavatar'] ?? '');
            $this->logPujaCartError('SAVE START (requestpujareg) | donation=' . $_POST['donation'] . ' | total=' . $_POST['totalamount']);
            $id = null;
            try {
                $id = $pujaregistrationModel->save(array_merge($_POST, $data));
                if (!empty($id)) {
                    $this->updateMemberAddressFromRegistrationPost($MemberModel, 'Puja Registration Request');
                }
                $this->logPujaCartError('SAVE OK (requestpujareg) | id=' . $id);
            } catch (Throwable $saveEx) {
                $this->logPujaCartError('SAVE ERROR (requestpujareg) | ' . $saveEx->getMessage());
                echo "<div style='color:red;padding:20px;font-size:18px;'>Submission Error: " . htmlspecialchars($saveEx->getMessage()) . "</div>";
                exit();
            }

           

            if (!empty($id)) {

                $opts = array();
                $opts['id'] = $id;
                $opts['status'] = 'pending';
                $data = $_POST;
                try { $pujaregistrationModel->update(array_merge($opts, $_POST)); } catch (Throwable $e) { $this->logPujaCartError('requestpujareg update ERROR | ' . $e->getMessage()); }

                $memberfname = $_POST['First_name'] ?? '';
                $memberlname = $_POST['Last_name'] ?? '';
                $pujatype = $_POST['puja_type'] ?? '';
                $totalamount = $_POST['totalamount'] ?? '';
                $pujaprice = $_POST['puja_amount'] ?? '';
                $magazineprice = $_POST['extramagazineamount'] ?? '';
                $seniordiscount = $_POST['discountseniorprice'] ?? '';
                $parentregistration = $_POST['extraparentregistration'] ?? '';
                $donation = $_POST['donation'] ?? '';
                // $paid_parking_amount = $_POST["paid_parking_amount"] ?? '';

                $adultCoupon = $_POST["adultCouponQty"] ?? '';
                $childCoupon = $_POST["childCouponQty"] ?? '';


                            // $_POST['amount'] = $_POST["paid_parking_amount"] ?? '';
                            // $_POST['parkingfield'] = $_POST["parking_area"] ?? '';
                            // $_POST['payment_status'] = 'confirmed';
                            // $_POST['status'] = 'confirmed';
                            // $_POST['paytype'] = 'Parking';
                            // $_POST['remarks'] = 'Registration from puja registration';

                            // $message = $_POST['senior'] ?? '';
                            // // echo "<script type='text/javascript'>alert('$message');</script>";

                            // if (empty($_POST['senior']) ) {
                            //     $_POST['seniorseventyplus'] = null;
                            //     $_POST['senior'] = null;
                            //     $message = $_POST['senior'] ?? '';
                            //     // echo "<script type='text/javascript'>alert('inside if');</script>";
                            //     // echo "<script type='text/javascript'>alert('$message');</script>";

                            // } else {
                            //     $_POST['senior'] = '1';
                            //     $_POST['seniorseventyplus'] = 'yes';
                            //     $message = $_POST['senior'] ?? '';
                            //     // echo "<script type='text/javascript'>alert('inside else');</script>";
                            //     // echo "<script type='text/javascript'>alert('$message');</script>";
                            // }

                           
                            // // $_POST['pay_for'] = 'Parking' . '/' . ($_POST['parkingfield'] ?? '');
                            // $_POST['pay_for'] = 'Parking' . '/' . ($_POST['parkingfield'] ?? '');
                            // if (($_POST["paid_parking_amount"] ?? '') != "") {
                            //     $paidparkingModel->save(array_merge( $_POST));
                            // }


                echo "<div style='text-align: -webkit-center;' class = 'pay'>
                      <table border='4'  width='585px' style='margin-left:4em;'>
                      <tr>
                      <td colspan='2'> <img src='../HDBS_Logo_HiRes.png' alt='' height='167px' style='margin-left:12em;'><h1 style='text-align:center;font-family:fangsong; font-size:30px;'><b>Houston Durga Bari Society</b></h1> </td>
                      <tr><td colspan='2'><span style='font-size: 18px;font-family: serif;'>Thank You for the Request. You will receive a Payment Link soon from our team after Verification of the Submitted document.</span></td></tr>
                      <tr><td style='width:50%;'>Name</td> <td style='width:50%;'>" . $memberfname . " " . $memberlname . "</td> </tr>
                      <tr><td>Puja Type</td> <td>" . $pujatype . "</td> </tr>";

                if ($adultCoupon  > 0) {
                    echo "<tr><td>Total Adult Coupon</td><td style='color:red;'><span style='color:black;'>Green Field Parking Amount</span> $adultCoupon</td></tr>";
                }

                if ($childCoupon  > 0) {
                    echo "<tr><td>Total Child Coupon</td><td style='color:red;'><span style='color:black;'>Green Field Parking Amount</span> $childCoupon</td></tr>";
                }

                echo "<tr><td>Total Amount</td> <td><span style= 'color:red;'>$</span>" . $totalamount . "</td> </tr>
                       <tr><td>Purpose</td> <td><span style= 'color:red;'></span>Puja Registration</td> </tr>
                      <tr><td>Payment Status</td> <td>Pending</td>  </tr>
                      <tr><td colspan='2'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>   </tr>
                      </tr>";
                echo "</table>";
                echo "<a  href='" . INSTALL_URL . "PujaOnlinePayments/PujaOnlinePayments'>Go to home</a>";
                echo "</div>";
            }

            $Emailcc = 'pujaregpayment@durgabari.org';
            $subjetc = 'Puja Registration Request';
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
                    <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Full Name&nbsp;&nbsp;</td>
                    <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">' . $memberfname . " " . $memberlname . '</td>
                    </tr>
                    <tr>
                    <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Puja Type&nbsp;&nbsp;</td>
                    <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $pujatype . '</td>
                    </tr>
                    <tr>
                    <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Puja Price &nbsp;</td>
                    <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;"><span style="color:red;">$</span>' . $pujaprice . '</td>
                    </tr>
                    ';

            if ($magazineprice != "") {
                $message .= '<tr>
                    <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Magazine(Additional)&nbsp;&nbsp;</td>
                    <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;"><span style="color:red;">$</span>' . $magazineprice . '</td>
                    </tr>';
            }
            if ($parentregistration != "") {
                $message .= '<tr>
                    <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Parent Registration&nbsp;&nbsp;</td>
                    <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;"><span style="color:red;">$</span>' . $parentregistration . '</td>
                    </tr>
                    ';
            }
            if ($donation != "") {
                $message .= '<tr>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Donation Amount&nbsp;&nbsp;</td>
                        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;"><span style="color:red;">$</span>' . $donation . '</td>
                        </tr>
                        ';
            }
            if ($seniordiscount != "") {
                $message .= '<tr>
                    <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Senior Discount&nbsp;&nbsp;</td>
                    <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;"><span style="color:red;">$</span>' . $seniordiscount . '</td>
                    </tr>';
            }

            if ($adultCoupon > 0) {
                    $message .= '<tr>
                    <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Total Adult Coupon Quantity&nbsp;&nbsp;</td>
                    <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;"><span style="color:red;"></span>' . $adultCoupon . '</td>
                    </tr>
                    ';
                }

                if ($childCoupon > 0) {
                    $message .= '<tr>
                    <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Total Child Coupon Quantity&nbsp;&nbsp;</td>
                    <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;"><span style="color:red;"></span>' . $childCoupon . '</td>
                    </tr>
                    ';
                }
                
                if (($_POST['greenFieldParkingDecision'] ?? '') != "") {
                    $message .= '<tr>
                    <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Parking Message &nbsp;&nbsp;</td>
                    <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;"><span style="color:red;"></span>' . ($_POST['greenFieldParkingDecision'] ?? '') . '</td>
                    </tr>
                    ';
                }

            $message .= '
                    <tr>
                    <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Total Amount&nbsp;&nbsp;</td>
                    <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;"><span style="color:red;">$</span>' . $totalamount . '</td>
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

            $membername = ($_POST['First_name'] ?? '') . ' ' . ($_POST['Last_name'] ?? '');


            $textmsg = 'Your Puja Registration request have been submitted  Member Id: ' . $MemberId . ', Full Name: ' . $membername . ', Puja Type: ' . $pujatype . ', Puja Price: $' . $pujaprice;
            if ($magazineprice != "") {
                $textmsg .= ', Magazine(Additional): $' . $magazineprice;
            }
            if ($parentregistration != "") {
                $textmsg .= ', Parent Registration: $' . $parentregistration;
            }
            if ($seniordiscount != "") {
                $textmsg .= ', Senior Discount: $' . $seniordiscount;
            }
            if ($donation != "") {
                $textmsg .= ', Donation Amount: $' . $donation;
            }
            if ($adultCoupon != "") {
                $textmsg .= ', Total Adult Coupon: ' . $adultCoupon;
            }
             if ($childCoupon != "") {
                $textmsg .= ', Total Child Coupon: ' . $childCoupon;
            }
            if (($_POST['greenFieldParkingDecision'] ?? '') != "") {
                $textmsg .= ', Parking Message: ' . ($_POST['greenFieldParkingDecision'] ?? '');
            }
            $textmsg .= ', Total Amount: $' . $totalamount;

            $mobileno = $_POST['alternatenumber'] ?? '';
            if ($mobileno != null) {
                  $this->SendSMS($mobileno, $textmsg);
            }
            exit();

        }

        if (!empty($_POST['create_registrationpayment'])) {
            $conflict = $pujaregistrationModel->getPujaRegistrationConflict($_POST['Member_id'] ?? '', $_POST['puja_type'] ?? '');
            if (!empty($_POST['Member_id']) && !empty($conflict['blocked'])) {
                echo "<div style='color:red;padding:20px;font-size:18px;'>" . htmlspecialchars($conflict['message'], ENT_QUOTES) . "</div>";
                echo "<a href='javascript:history.back()'>Go Back</a>";
                exit();
            }

            unset($_SESSION['adultCoupon']);
            unset($_SESSION['childCoupon']);
            unset($_SESSION['totalCouponPrice']);

            if (isset($_SESSION['pujakart_payment_processed']) && $_SESSION['pujakart_payment_processed'] === true) {
                unset($_SESSION['pujakart_payment_processed']);
                Util::redirect(INSTALL_URL . "PujaOnlinePayments/PujaOnlinePayments");
                exit();
            }
           

            $data = array();
            date_default_timezone_set("America/Chicago");
            $today = date("Y/m/d");
            $_POST['pay_date'] = $today;
            $_POST['CreatedAt'] = $today;
            $_POST['pay_type'] = 'Puja Registration';
            $_POST['pay_for'] = $_POST['puja_type'] ?? '';
            // for generate oid 
            //$oid= Util::incrementalHash(4);
            $maxoid = $idnumbersModel->getMaxoid() + 1;
            $update_oid = $idnumbersModel->Updateoid($maxoid);
            $_POST['oid'] = $maxoid;
            // end generate oid for

            $datamember = $MemberModel->rentalmemberduplicate();
            if ($datamember == null) {

                // for generate memberid for gd
                $maxid = $idnumbersModel->getMaxmid() + 1;
                $update_mid = $idnumbersModel->Updatemid($maxid);
                $_POST['Member_id'] = $maxid;
                $_POST['membercategory'] = 'GC';
                // end generate memberid for gd 
            }
            if ($datamember != null) {
                $_POST['Member_id'] = $datamember;
                // for update telephone no member case
                $existingdata = $MemberModel->checktele2($datamember);
                $alternatemobile = $existingdata[0]['Tele2'];
                if ($alternatemobile == null || $alternatemobile != $_POST['alternatenumber'] ?? '') {
                    $mobileno = $_POST['alternatenumber'] ?? '';
                    $MemberModel->updatetelephone($datamember, $mobileno);
                }

                $primaryphone = $existingdata[0]['Tele1'];
                if ($primaryphone == null) {
                    $phone = $_POST['phone'] ?? '';
                    $MemberModel->updateprimaryno($datamember, $phone);
                }

                $email = $existingdata[0]['email'];
                if ($email == null) {
                    $email = $_POST['email'] ?? '';
                    $MemberModel->updateemail($datamember, $email);
                }

                $alternateemail = $existingdata[0]['Email2'];
                if ($alternateemail == null) {
                    $alternatemail = $_POST['alternateemail'] ?? '';
                    if ($alternatemail != "") {
                        $MemberModel->updupdatealternateemail($datamember, $alternateemail);
                    }

                }
                if (!empty($_POST['update_address'])) {
                    try { $MemberModel->updateAddressWithHistory($datamember, $_POST, 'Puja Registration'); } catch (Throwable $e) { $this->logPujaCartError('updateAddressWithHistory ERROR | ' . $e->getMessage()); }
                }
            }
            if ($this->isAdmin() || $this->isEditor()) {
                $id = $this->getUserId();
                $admin = $UserModel->get($id);
                $rolename = $admin['first'] . ' ' . $admin['last'];
                $_POST['admin_id'] = $admin['id'];
                $_POST['admin_name'] = $rolename;

            }

            if (($_POST['member_status'] ?? '') == "individual") {
                $_POST['Sp_fname'] = "";
                $_POST['Sp_lname'] = "";
                $_POST['childonefname'] = "";
                $_POST['childonelname'] = "";
                $_POST['Age1'] = "";
                $_POST['childtwofname'] = "";
                $_POST['childtwolname'] = "";
                $_POST['Age2'] = "";
                $_POST['childthreefname'] = "";
                $_POST['childthreelname'] = "";
                $_POST['Age3'] = "";

            }

            //for complimentary registration :
            if (($_POST['PaymentOption'] ?? '') == 'ComplimentaryRegistration') {

                $_POST['amount'] = "";
                $_POST['totalamount'] = "";
                $_POST['discountseniorprice'] = "";
                $_POST['magazineprice'] = "";
                $_POST['extraparentregistration'] = "";
                $_POST['extraadultregistration'] = "";
                $_POST['donation'] = "";

            }

            // Sanitize tinyint/int fields — unsubmitted checkboxes arrive as missing
            $_POST['member_veggie']   = isset($_POST['member_veggie'])   && is_numeric($_POST['member_veggie'])   ? (int)$_POST['member_veggie']   : 0;
            $_POST['spouse_veggie']   = isset($_POST['spouse_veggie'])   && is_numeric($_POST['spouse_veggie'])   ? (int)$_POST['spouse_veggie']   : 0;
            $_POST['parent1_veggie']  = isset($_POST['parent1_veggie'])  && is_numeric($_POST['parent1_veggie'])  ? (int)$_POST['parent1_veggie']  : 0;
            $_POST['parent2_veggie']  = isset($_POST['parent2_veggie'])  && is_numeric($_POST['parent2_veggie'])  ? (int)$_POST['parent2_veggie']  : 0;
            $_POST['co_register_adult_members'] = !empty($_POST['co_register_adult_members']) ? 1 : 0;
            $_POST['adult1_birth_year'] = isset($_POST['adult1_birth_year']) && is_numeric($_POST['adult1_birth_year']) ? (int)$_POST['adult1_birth_year'] : '';
            $_POST['adult2_birth_year'] = isset($_POST['adult2_birth_year']) && is_numeric($_POST['adult2_birth_year']) ? (int)$_POST['adult2_birth_year'] : '';
            $_POST['adult3_birth_year'] = isset($_POST['adult3_birth_year']) && is_numeric($_POST['adult3_birth_year']) ? (int)$_POST['adult3_birth_year'] : '';
            $_POST['adult1_veggie'] = isset($_POST['adult1_veggie']) && is_numeric($_POST['adult1_veggie']) ? (int)$_POST['adult1_veggie'] : 0;
            $_POST['adult2_veggie'] = isset($_POST['adult2_veggie']) && is_numeric($_POST['adult2_veggie']) ? (int)$_POST['adult2_veggie'] : 0;
            $_POST['adult3_veggie'] = isset($_POST['adult3_veggie']) && is_numeric($_POST['adult3_veggie']) ? (int)$_POST['adult3_veggie'] : 0;
            $this->applyAdultChildRegistrationPricing($_POST);
            $_POST['student']         = isset($_POST['student'])         && is_numeric($_POST['student'])         ? (int)$_POST['student']         : 0;
            $_POST['outoftowner']     = isset($_POST['outoftowner'])     && is_numeric($_POST['outoftowner'])     ? (int)$_POST['outoftowner']     : 0;
            $_POST['senior']          = isset($_POST['senior'])          && is_numeric($_POST['senior'])          ? (int)$_POST['senior']          : 0;
            $_POST['senior_veggie']   = isset($_POST['senior_veggie'])   && is_numeric($_POST['senior_veggie'])   ? (int)$_POST['senior_veggie']   : 0;
            $_POST['swap_spouse']     = isset($_POST['swap_spouse'])     && is_numeric($_POST['swap_spouse'])     ? (int)$_POST['swap_spouse']     : 0;
            $_POST['Age1']            = isset($_POST['Age1'])            && is_numeric($_POST['Age1'])            ? (int)$_POST['Age1']            : 0;
            $_POST['Age2']            = isset($_POST['Age2'])            && is_numeric($_POST['Age2'])            ? (int)$_POST['Age2']            : 0;
            $_POST['Age3']            = isset($_POST['Age3'])            && is_numeric($_POST['Age3'])            ? (int)$_POST['Age3']            : 0;
            // Sanitize float fields — empty string '' is rejected by MySQL STRICT_TRANS_TABLES on Azure
            $_POST['donation']        = is_numeric($_POST['donation']        ?? '') ? (float)$_POST['donation']        : 0;
            $_POST['amount']          = is_numeric($_POST['amount']          ?? '') ? (float)$_POST['amount']          : 0;
            $_POST['totalamount']     = is_numeric($_POST['totalamount']     ?? '') ? (float)$_POST['totalamount']     : 0;

            // NOT NULL varchar columns with no DB default — must always be present
            $_POST['studentavatar'] = $data['studentavatar'] ?? ($_POST['studentavatar'] ?? '');
            $_POST['addressavatar'] = $data['addressavatar'] ?? ($_POST['addressavatar'] ?? '');
            $_SESSION['puja_cart_last_post'] = $_POST;
            $this->logPujaCartError('SAVE START (registrationpayment) | PaymentOption=' . ($_POST['PaymentOption'] ?? '') . ' | donation=' . $_POST['donation'] . ' | total=' . $_POST['totalamount']);
            $id = null;
            try {
                $id = $pujaregistrationModel->save(array_merge($_POST, $data));
                if (!empty($id)) {
                    $this->updateMemberAddressFromRegistrationPost($MemberModel, 'Puja Registration Payment');
                }
                $this->logPujaCartError('SAVE OK (registrationpayment) | id=' . $id);
            } catch (Throwable $saveEx) {
                $this->logPujaCartError('SAVE ERROR (registrationpayment) | ' . $saveEx->getMessage());
                echo "<div style='color:red;padding:20px;font-size:18px;'>Submission Error: " . htmlspecialchars($saveEx->getMessage()) . "</div>";
                exit();
            }

            // $parking['amount'] = $_POST["paid_parking_amount"] ?? '';
            // $parking['parkingfield'] = "Green Field";
            // $parking['payment_status'] = 'confirmed';
            // $parking['status'] = 'confirmed';
            // if (($_POST["paid_parking_amount"] ?? '') != "") {
            //     $paidparkingModel->save(array_merge($_POST, $parking));
            // }
            if (!empty($id)) {

                //for confirmation email
                $orderid = $_POST['oid'] ?? '';
                $Memberid = $_POST['Member_id'] ?? '';
                $membername = ($_POST['First_name'] ?? '') . ' ' . ($_POST['Last_name'] ?? '');
                $pujatype = $_POST['puja_type'] ?? '';
                $totalamount = $_POST['totalamount'] ?? '';
                $pujaprice = $_POST['amount'] ?? '';
                $magazineprice = $_POST['magazineprice'] ?? '';
                $seniordiscount = $_POST['discountseniorprice'] ?? '';
                $parentregistration = $_POST['extraparentregistration'] ?? '';
                $donation = $_POST['donation'] ?? '';
                $adultCoupon = $_POST["adultCouponQty"] ?? '';
                $childCoupon = $_POST["childCouponQty"] ?? '';


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
                else if ($paymethod == "zelleProxy") {
                    $payui = 'Zelle Proxy';
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
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Puja Type&nbsp;&nbsp;</td>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $pujatype . '</td>
                </tr>
                <tr>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Puja Price &nbsp;</td>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;"><span style="color:red;">$</span>' . $pujaprice . '</td>
                </tr>
                ';

                if ($magazineprice != "") {
                    $message .= '<tr>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Magazine(Additional)&nbsp;&nbsp;</td>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;"><span style="color:red;">$</span>' . $magazineprice . '</td>
                </tr>';
                }
                if ($parentregistration != "") {
                    $message .= '<tr>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Parent Registration&nbsp;&nbsp;</td>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;"><span style="color:red;">$</span>' . $parentregistration . '</td>
                </tr>
                ';
                }

                if ($seniordiscount != "") {
                    $message .= '<tr>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Senior Discount&nbsp;&nbsp;</td>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;"><span style="color:red;">$</span>' . $seniordiscount . '</td>
                </tr>';
                }
                if ($donation != "") {
                    $message .= '<tr>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Donation Amount&nbsp;&nbsp;</td>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;"><span style="color:red;">$</span>' . $donation . '</td>
                </tr>
                ';
                }

                if ($adultCoupon > 0) {
                    $message .= '<tr>
                    <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Total Adult Coupon Quantity&nbsp;&nbsp;</td>
                    <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;"><span style="color:red;"></span>' . $adultCoupon . '</td>
                    </tr>
                    ';
                }

                if ($childCoupon > 0) {
                    $message .= '<tr>
                    <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Total Child Coupon Quantity&nbsp;&nbsp;</td>
                    <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;"><span style="color:red;"></span>' . $childCoupon . '</td>
                    </tr>
                    ';
                }
                if (($_POST['greenFieldParkingDecision'] ?? '') != "") {
                    $message .= '<tr>
                    <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Parking Message &nbsp;&nbsp;</td>
                    <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;"><span style="color:red;"></span>' . ($_POST['greenFieldParkingDecision'] ?? '') . '</td>
                    </tr>
                    ';
                }

                $message .= '
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
                $textmsg = 'Houston Durga Bari: Puja Registration confirmation are Order Id: ' . $orderid . ', Member Id: ' . $Memberid . ', Full Name: ' . $membername . ', Puja Type: ' . $pujatype . ', Puja Price: $' . $pujaprice;
                if ($magazineprice != "") {
                    $textmsg .= ', Magazine(Additional): $' . $magazineprice;
                }
                if ($parentregistration != "") {
                    $textmsg .= ', Parent Registration: $' . $parentregistration;
                }
                if ($seniordiscount != "") {
                    $textmsg .= ', Senior Discount: $' . $seniordiscount;
                }
                if ($donation != "") {
                    $textmsg .= ', Donation Amount: $' . $donation;
                }
                if ($adultCoupon != "") {
                $textmsg .= ', Total Adult Coupon: ' . $adultCoupon;
            }
             if ($childCoupon != "") {
                $textmsg .= ', Total Child Coupon: ' . $childCoupon;
            }
            if (($_POST['greenFieldParkingDecision'] ?? '') != "") {
                $textmsg .= ', Parking Message: ' . ($_POST['greenFieldParkingDecision'] ?? '');
            }
            
            
                $textmsg .= ', Total Amount: $' . $totalamount . ', Payment Method: ' . $payui . ', Pay Date: ' . $paydateemail;


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
                        //$opts['payment_status'] = 'succeeded';
                        $opts['payment_status'] = 'confirmed';
                        $_POST['status'] = 'confirmed';
                        $data = $_POST;
                        $datamemberarr = array();
                        $datamemberarr = array_merge($opts, $_POST);
                        try { $pujaregistrationModel->update(array_merge($opts, $_POST)); } catch (Throwable $e) { $this->logPujaCartError('update(opts+POST) ERROR | ' . $e->getMessage()); }

                        // $parking['amount'] = $_POST["paid_parking_amount"] ?? '';
                        // $parking['parkingfield'] = "Green Field";
                        // $parking['payment_status'] = 'confirmed';
                        // $parking['status'] = 'confirmed';
                        // if (($_POST["paid_parking_amount"] ?? '') != "") {
                        //     $paidparkingModel->save(array_merge($_POST, $parking));
                        // }
                        $value['oid'] = $oid;
                        $value['Member_id'] = $datamemberarr['Member_id'];
                        $value['MemberName'] = $datamemberarr['First_name'] . ' ' . $datamemberarr['Last_name'];
                        $value['PaymentOption'] = $datamemberarr['PaymentOption'];
                        $value['payment_status'] = 'succeeded';
                        $value['payment_timestamp'] = $datamemberarr['payment_timestamp'] ?? '';
                        $value['stripe_return'] = $datamemberarr['stripe_return'] ?? '';
                        $value['transaction_id'] = $datamemberarr['transaction_id'];
                        $value['paid_amount'] = $datamemberarr['paid_amount'] ?? '';
                        $value['update_on'] = $datamemberarr['UpdateOn'];
                        $value['stripe_product'] = $datamemberarr['stripe_product'] ?? '';
                        $value['pay_date'] = $datamemberarr['pay_date'];
                        $value['pay_type'] = $datamemberarr['pay_type'];
                        $value['pay_for'] = $datamemberarr['pay_for'];
                        $value['Tele1'] = $datamemberarr['phone'];
                        $value['Tele2'] = $datamemberarr['alternatenumber'];
                        $value['email'] = $datamemberarr['email'];
                        $value['spousename'] = $datamemberarr['Sp_fname'] . ' ' . $datamemberarr['Sp_lname'];;
                        $value['Address'] = $datamemberarr['streetname'];
                        $value['Street'] = $datamemberarr['street'];
                        $value['City'] = $datamemberarr['city'];
                        $value['State'] = $datamemberarr['state'];
                        $value['Zip_Code'] = $datamemberarr['zip'];
                        $value['admin_id'] = $datamemberarr['admin_id'];
                        $value['admin_name'] = $datamemberarr['admin_name'];
                        $extradonationamount = $datamemberarr['donation'];
                        $totalamountwithdonation = $datamemberarr['totalamount'];
                        $SecondAmount = $totalamountwithdonation - $extradonationamount;

                        if ($extradonationamount == null) {
                            $value['Amount'] = $datamemberarr['totalamount'];
                            try { $DonationModel->SaveDataInDonation($value); } catch (Throwable $donEx) { $this->logPujaCartError('SaveDataInDonation ERROR | ' . $donEx->getMessage()); }
                        }
                        if ($extradonationamount != null) {
                            for ($i = 0; $i <= 1; $i++) {
                                if ($i == 0) {
                                    $value['pay_type'] = $datamemberarr['pay_type'];
                                    $value['pay_for'] = $datamemberarr['pay_for'];
                                    $value['Amount'] = $SecondAmount;
                                    try { $DonationModel->SaveDataInDonation($value); } catch (Throwable $donEx) { $this->logPujaCartError('SaveDataInDonation ERROR | ' . $donEx->getMessage()); }
                                }
                                if ($i == 1) {
                                    $value['pay_type'] = 'Donation';
                                    $value['pay_for'] = 'DONATION / Unrestricted';
                                    $value['paymentfor'] = 'Puja Donation';
                                    $value['Amount'] = $extradonationamount;
                                    try { $DonationModel->SaveDataInDonation($value); } catch (Throwable $donEx) { $this->logPujaCartError('SaveDataInDonation ERROR | ' . $donEx->getMessage()); }
                                }

                            }
                        }



                        if ($datamember == null) {
                            $value = array();
                            // $value['id'] = $_POST['id'] ?? '';
                            $value['Payment_For'] = $_POST['Payment_For'] ?? '';
                            $value['MemberName'] = ($_POST['First_name'] ?? '') . ' ' . ($_POST['Last_name'] ?? '');
                            $value['Amount'] = $_POST['totalamount'] ?? '';
                            $value['PaymentOption'] = $_POST['PaymentOption'] ?? '';
                            $value['payment_status'] = 'confirmed';
                            $value['payment_timestamp'] = $opts['payment_timestamp'] ?? '';
                            $value['stripe_return'] = $opts['stripe_return'] ?? '';
                            $value['transaction_id'] = $opts['transaction_id'];
                            $value['paid_amount'] = $opts['paid_amount'] ?? '';
                            $value['stripe_product'] = $opts['stripe_product'] ?? '';
                            $value['update_on'] = $_POST['update_on'] ?? '';
                            $value['Member_id'] = $_POST['Member_id'] ?? '';
                            $value['pay_date'] = $_POST['pay_date'] ?? '';
                            $value['cc_name'] = $_POST['cc_name'] ?? '';
                            $value['remarks'] = $_POST['remarks'] ?? '';
                            $value['oid'] = $_POST['oid'] ?? '';
                            $value['pay_type'] = $_POST['pay_type'] ?? '';
                            $value['pay_for'] = $_POST['pay_for'] ?? '';
                            $value['Address'] = $_POST['streetname'] ?? '';
                            $value['Street'] = $_POST['street'] ?? '';
                            $value['Address'] = $_POST['streetname'] ?? '';
                            $value['Address3'] = $_POST['unit'] ?? '';
                            $value['Zip_Code'] = $_POST['zip'] ?? '';
                            $value['Tele2'] = $_POST['alternatenumber'] ?? '';
                            $value['email'] = $_POST['email'] ?? '';
                            $value['City'] = $_POST['city'] ?? '';
                            $value['State'] = $datamemberarr['state'];
                            $value['Tele1'] = $_POST['phone'] ?? '';
                            $value['spousename'] = ($_POST['Sp_fname'] ?? '') . ' ' . ($_POST['Sp_lname'] ?? '');
                            $value['Address3'] = $_POST['Address3'] ?? '';
                            // $value['Parent1'] = ($_POST['parent1_fname'] ?? '') .' '. ($_POST['parent1_lname'] ?? '');
                            // $value['Parent2'] = ($_POST['parent2_fname'] ?? '') .' '. ($_POST['parent2_lname'] ?? '');
                            $value['Child1'] = ($_POST['childonefname'] ?? '') . ' ' . ($_POST['childonelname'] ?? '');
                            $value['Child2'] = ($_POST['childtwofname'] ?? '') . ' ' . ($_POST['childtwolname'] ?? '');
                            $value['Child3'] = ($_POST['childthreefname'] ?? '') . ' ' . ($_POST['childthreelname'] ?? '');
                            $value['Age1'] = $_POST['Age1'] ?? '';
                            $value['Age2'] = $_POST['Age2'] ?? '';
                            $value['Age3'] = $_POST['Age3'] ?? '';
                            try { $MemberModel->SaveDataInmember($value); } catch (Throwable $e) { $this->logPujaCartError('SaveDataInmember ERROR | ' . $e->getMessage()); }
                        }

                            // $_POST['amount'] = $_POST["paid_parking_amount"] ?? '';
                            // $_POST['parkingfield'] = $_POST["parking_area"] ?? '';
                            // $_POST['payment_status'] = 'confirmed';
                            // $_POST['status'] = 'confirmed';
                            // $_POST['paytype'] = 'Parking';
                            // $_POST['remarks'] = 'Registration from puja registration';

                            // $message = $_POST['senior'] ?? '';
                            // // echo "<script type='text/javascript'>alert('$message');</script>";

                            // if (empty($_POST['senior']) ) {
                            //     $_POST['seniorseventyplus'] = null;
                            //     $_POST['senior'] = null;
                            //     $message = $_POST['senior'] ?? '';
                            //     // echo "<script type='text/javascript'>alert('inside if');</script>";
                            //     // echo "<script type='text/javascript'>alert('$message');</script>";

                            // } else {
                            //     $_POST['senior'] = '1';
                            //     $_POST['seniorseventyplus'] = 'yes';
                            //     $message = $_POST['senior'] ?? '';
                            //     // echo "<script type='text/javascript'>alert('inside else');</script>";
                            //     // echo "<script type='text/javascript'>alert('$message');</script>";
                            // }

                           
                            // // $_POST['pay_for'] = 'Parking' . '/' . ($_POST['parkingfield'] ?? '');
                            // $_POST['pay_for'] = 'Parking' . '/' . ($_POST['parkingfield'] ?? '');
                            // if (($_POST["paid_parking_amount"] ?? '') != "") {
                            //     $paidparkingModel->save(array_merge( $_POST));
                            // }

                        $email = $_POST['email'] ?? '';
                        if ($email != null) {
                             $this->sendEmailticket($message, $subjetc, $email, $Emailcc);
                        }
                        $mobileno = $_POST['alternatenumber'] ?? '';
                        if ($mobileno != null) {
                            $this->SendSMS($mobileno, $textmsg );
                        }
                        $this->tpl['arr'] = $pujaregistrationModel->get($id);
                        if (session_status() === PHP_SESSION_NONE) { session_start(); }
                        if (($_POST['donation'] ?? '') != "") {
                            $memberid = $_POST['Member_id'] ?? '';
                            try { $confirmdata = $MemberModel->membercheck($memberid); } catch (Throwable $e) { $this->logPujaCartError('membercheck ERROR|'.$e->getMessage()); $confirmdata = []; }
                            $_SESSION['memberregisterpuja'] = $confirmdata;
                            try { $pujareg = $itemspujasponsorModel->registersankalpapujacheck($memberid); } catch (Throwable $e) { $this->logPujaCartError('registersankalpapujacheck ERROR|'.$e->getMessage()); $pujareg = []; }
                            $_SESSION['pujareg'] = $pujareg;
                            try { $sponsoreventfirst = $itemspujasponsorModel->sponsorevent1check($memberid); } catch (Throwable $e) { $this->logPujaCartError('sponsorevent1check ERROR|'.$e->getMessage()); $sponsoreventfirst = []; }
                            $_SESSION['sponsoreventfirst'] = $sponsoreventfirst;
                            try { $sponsoreventsecond = $itemspujasponsorModel->sponsorevent2check($memberid); } catch (Throwable $e) { $this->logPujaCartError('sponsorevent2check ERROR|'.$e->getMessage()); $sponsoreventsecond = []; }
                            $_SESSION['sponsoreventsecond'] = $sponsoreventsecond;

                            try { $pujasankalpaattempt1arr = $itemspujasponsorModel->pujasankalpaattempt1($memberid); } catch (Throwable $e) { $this->logPujaCartError('pujasankalpaattempt1 ERROR|'.$e->getMessage()); $pujasankalpaattempt1arr = []; }
                            $_SESSION['pujasankalpaattempt1arr'] = $pujasankalpaattempt1arr;

                            try { $pujasankalpaattempt2arr = $itemspujasponsorModel->pujasankalpaattempt2($memberid); } catch (Throwable $e) { $this->logPujaCartError('pujasankalpaattempt2 ERROR|'.$e->getMessage()); $pujasankalpaattempt2arr = []; }
                            $_SESSION['pujasankalpaattempt2arr'] = $pujasankalpaattempt2arr;

                            try { $CategoryAarr = $sponsoritemModel->sponsorCategoryA(); } catch (Throwable $e) { $this->logPujaCartError('sponsorCategoryA ERROR|'.$e->getMessage()); $CategoryAarr = []; }
                            $_SESSION['CategoryAarr'] = $CategoryAarr;

                            try { $CategoryBarr = $sponsoritemModel->sponsorCategoryB(); } catch (Throwable $e) { $this->logPujaCartError('sponsorCategoryB ERROR|'.$e->getMessage()); $CategoryBarr = []; }
                            $_SESSION['CategoryBarr'] = $CategoryBarr;
                            $previousytd = is_numeric($_POST['YTD'] ?? '') ? (float)$_POST['YTD'] : 0;
                            $amountytd = is_numeric($_POST['donation'] ?? '') ? (float)$_POST['donation'] : 0;
                            $newytd = $previousytd + $amountytd;
                            $_SESSION['ytdvalue'] = $newytd;


                        }

                        // if (($_POST["paid_parking_amount"] ?? '') != "") {
                        //     $_SESSION['paid_parking_amount'] = $_POST["paid_parking_amount"] ?? '';
                        // }

                        if (($_POST["adultCouponQty"] ?? '') > 0) {
                                $_SESSION['adultCoupon'] = $_POST["adultCouponQty"] ?? '';
                               
                                
                            }

                            if (($_POST["childCouponQty"] ?? '') > 0) {
                                $_SESSION['childCoupon'] = $_POST["childCouponQty"] ?? '';
                               
                                
                            }
                            if (($_POST["childCouponQty"] ?? '') > 0 || ($_POST["adultCouponQty"] ?? '') > 0) {
                                $_SESSION['totalCouponPrice'] = $_POST["totalCouponPrice"] ?? '';    
                            }




                        $_SESSION['myValue'] = $this->tpl['arr'];
                        $_SESSION['pujakart_payment_processed'] = true;
                        Util::redirect(INSTALL_URL . "PujaCart/show/" . $id);
                        exit();
                    }
                }
                //check
                elseif (($_POST['PaymentOption'] ?? '') == 'check') {
                    $_POST['totalamount'] = $_POST['checkAmount'] ?? '';
                    $_POST['bank'] = $_POST['checkbankname'] ?? '';
                    $_POST['chkdate'] = $_POST['CheckDate'] ?? '';
                    //$_POST['pay_date'] = $_POST['CheckDate'] ?? '';
                    $_POST['status'] = 'confirmed';
                    $_POST['payment_status'] = 'confirmed';
                    $_POST['DepositAccount'] = $_POST['CheckDepositAccount'] ?? '';
                    $_POST['id'] = $id;
                    $data = $_POST;
                    $datamemberarr = array();
                    $datamemberarr = array_merge($_POST);
                    try { $pujaregistrationModel->update(array_merge($_POST)); } catch (Throwable $e) { $this->logPujaCartError('update(POST) ERROR | ' . $e->getMessage()); }

                    // $parking['amount'] = $_POST["paid_parking_amount"] ?? '';
                    // $parking['parkingfield'] = "Green Field";
                    // $parking['payment_status'] = 'confirmed';
                    // $parking['status'] = 'confirmed';
                    // if (($_POST["paid_parking_amount"] ?? '') != "") {
                    //     $paidparkingModel->save(array_merge($_POST, $parking));
                    // }
                    $value['oid'] = $_POST['oid'] ?? '';
                    $value['Member_id'] = $datamemberarr['Member_id'];
                    $value['MemberName'] = $datamemberarr['First_name'] . ' ' . $datamemberarr['Last_name'];
                    $value['PaymentOption'] = $datamemberarr['PaymentOption'];
                    $value['payment_status'] = 'succeeded';
                    $value['payment_timestamp'] = $datamemberarr['payment_timestamp'] ?? '';
                    $value['stripe_return'] = $datamemberarr['stripe_return'] ?? '';
                    $value['transaction_id'] = $datamemberarr['transaction_id'];
                    $value['paid_amount'] = $datamemberarr['paid_amount'] ?? '';
                    $value['update_on'] = $datamemberarr['UpdateOn'];
                    $value['stripe_product'] = $datamemberarr['stripe_product'] ?? '';
                    $value['pay_date'] = $datamemberarr['pay_date'];
                    $value['pay_type'] = $datamemberarr['pay_type'];
                    $value['pay_for'] = $datamemberarr['pay_for'];
                    $value['Tele1'] = $datamemberarr['phone'];
                    $value['Tele2'] = $datamemberarr['alternatenumber'];
                    $value['email'] = $datamemberarr['email'];
                    $value['spousename'] = $datamemberarr['Sp_fname'] . ' ' . $datamemberarr['Sp_lname'];
                    ;
                    $value['Address'] = $datamemberarr['streetname'];
                    $value['Street'] = $datamemberarr['street'];
                    $value['City'] = $datamemberarr['city'];
                    $value['State'] = $datamemberarr['state'];
                    $value['Zip_Code'] = $datamemberarr['zip'];
                    $value['admin_id'] = $datamemberarr['admin_id'];
                    $value['admin_name'] = $datamemberarr['admin_name'];
                    $value['DepositAccount'] = $datamemberarr['DepositAccount'];
                    $extradonationamount = $datamemberarr['donation'];
                    $totalamountwithdonation = $datamemberarr['totalamount'];
                    $SecondAmount = $totalamountwithdonation - $extradonationamount;

                    //try { $DonationModel->SaveDataInDonation($value); } catch (Throwable $donEx) { $this->logPujaCartError('SaveDataInDonation ERROR | ' . $donEx->getMessage()); }
                    if ($extradonationamount == null) {
                        $value['Amount'] = $datamemberarr['totalamount'];
                        try { $DonationModel->SaveDataInDonation($value); } catch (Throwable $donEx) { $this->logPujaCartError('SaveDataInDonation ERROR | ' . $donEx->getMessage()); }
                    }
                    if ($extradonationamount != null) {
                        for ($i = 0; $i <= 1; $i++) {
                            if ($i == 0) {
                                $value['pay_type'] = $datamemberarr['pay_type'];
                                $value['pay_for'] = $datamemberarr['pay_for'];
                                $value['Amount'] = $SecondAmount;
                                try { $DonationModel->SaveDataInDonation($value); } catch (Throwable $donEx) { $this->logPujaCartError('SaveDataInDonation ERROR | ' . $donEx->getMessage()); }
                            }
                            if ($i == 1) {
                                $value['pay_type'] = 'Donation';
                                $value['pay_for'] = 'DONATION / Unrestricted';
                                $value['paymentfor'] = 'Puja Donation';
                                $value['Amount'] = $extradonationamount;
                                try { $DonationModel->SaveDataInDonation($value); } catch (Throwable $donEx) { $this->logPujaCartError('SaveDataInDonation ERROR | ' . $donEx->getMessage()); }
                            }

                        }
                    }
                    if ($datamember == null) {
                        $value = array();
                        // $value['id'] = $_POST['id'] ?? '';
                        $value['Payment_For'] = $_POST['Payment_For'] ?? '';
                        $value['MemberName'] = ($_POST['First_name'] ?? '') . ' ' . ($_POST['Last_name'] ?? '');
                        $value['Amount'] = $_POST['totalamount'] ?? '';
                        $value['PaymentOption'] = $_POST['PaymentOption'] ?? '';
                        $value['payment_status'] = 'confirmed';
                        $value['payment_timestamp'] = $_POST['payment_timestamp'] ?? '';
                        $value['stripe_return'] = $_POST['stripe_return'] ?? '';
                        $value['transaction_id'] = $_POST['transaction_id'] ?? '';
                        $value['paid_amount'] = $_POST['paid_amount'] ?? '';
                        $value['stripe_product'] = $_POST['stripe_product'] ?? '';
                        $value['update_on'] = $_POST['update_on'] ?? '';
                        $value['Member_id'] = $_POST['Member_id'] ?? '';
                        $value['pay_date'] = $_POST['pay_date'] ?? '';
                        $value['cc_name'] = $_POST['cc_name'] ?? '';
                        $value['remarks'] = $_POST['remarks'] ?? '';
                        $value['oid'] = $_POST['oid'] ?? '';
                        $value['pay_type'] = $_POST['pay_type'] ?? '';
                        $value['pay_for'] = $_POST['pay_for'] ?? '';
                        $value['Address'] = $_POST['streetname'] ?? '';
                        $value['Street'] = $_POST['street'] ?? '';
                        $value['Address'] = $_POST['streetname'] ?? '';
                        $value['Address3'] = $_POST['unit'] ?? '';
                        $value['Zip_Code'] = $_POST['zip'] ?? '';
                        $value['Tele2'] = $_POST['alternatenumber'] ?? '';
                        $value['email'] = $_POST['email'] ?? '';
                        $value['City'] = $_POST['city'] ?? '';
                        $value['State'] = $datamemberarr['state'];
                        $value['Tele1'] = $_POST['phone'] ?? '';
                        $value['spousename'] = ($_POST['Sp_fname'] ?? '') . ' ' . ($_POST['Sp_lname'] ?? '');
                        $value['Address3'] = $_POST['Address3'] ?? '';
                        // $value['Parent1'] = ($_POST['parent1_fname'] ?? '') .' '. ($_POST['parent1_lname'] ?? '');
                        // $value['Parent2'] = ($_POST['parent2_fname'] ?? '') .' '. ($_POST['parent2_lname'] ?? '');
                        $value['Child1'] = ($_POST['childonefname'] ?? '') . ' ' . ($_POST['childonelname'] ?? '');
                        $value['Child2'] = ($_POST['childtwofname'] ?? '') . ' ' . ($_POST['childtwolname'] ?? '');
                        $value['Child3'] = ($_POST['childthreefname'] ?? '') . ' ' . ($_POST['childthreelname'] ?? '');
                        $value['Age1'] = $_POST['Age1'] ?? '';
                        $value['Age2'] = $_POST['Age2'] ?? '';
                        $value['Age3'] = $_POST['Age3'] ?? '';
                        try { $MemberModel->SaveDataInmember($value); } catch (Throwable $e) { $this->logPujaCartError('SaveDataInmember ERROR | ' . $e->getMessage()); }
                    }

                            // $_POST['amount'] = $_POST["paid_parking_amount"] ?? '';
                            // $_POST['parkingfield'] = $_POST["parking_area"] ?? '';
                            // $_POST['payment_status'] = 'confirmed';
                            // $_POST['status'] = 'confirmed';
                            // $_POST['paytype'] = 'Parking';
                            // $_POST['remarks'] = 'Registration from puja registration';

                            // $message = $_POST['senior'] ?? '';
                            // // echo "<script type='text/javascript'>alert('$message');</script>";

                            // if (empty($_POST['senior']) ) {
                            //     $_POST['seniorseventyplus'] = null;
                            //     $_POST['senior'] = null;
                            //     $message = $_POST['senior'] ?? '';
                            //     // echo "<script type='text/javascript'>alert('inside if');</script>";
                            //     // echo "<script type='text/javascript'>alert('$message');</script>";

                            // } else {
                            //     $_POST['senior'] = '1';
                            //     $_POST['seniorseventyplus'] = 'yes';
                            //     $message = $_POST['senior'] ?? '';
                            //     // echo "<script type='text/javascript'>alert('inside else');</script>";
                            //     // echo "<script type='text/javascript'>alert('$message');</script>";
                            // }

                           
                            // // $_POST['pay_for'] = 'Parking' . '/' . ($_POST['parkingfield'] ?? '');
                            // $_POST['pay_for'] = 'Parking' . '/' . ($_POST['parkingfield'] ?? '');
                            // if (($_POST["paid_parking_amount"] ?? '') != "") {
                            //     $paidparkingModel->save(array_merge( $_POST));
                            // }

                    $email = $_POST['email'] ?? '';
                    if ($email != null) {
                         $this->sendEmailticket($message, $subjetc, $email, $Emailcc);
                    }
                    $mobileno = $_POST['alternatenumber'] ?? '';
                    if ($mobileno != null) {
                            $this->SendSMS($mobileno, $textmsg );
                    }
                    $this->tpl['arr'] = $pujaregistrationModel->get($id);
                    if (session_status() === PHP_SESSION_NONE) { session_start(); }
                    if (($_POST['donation'] ?? '') != "") {
                        $memberid = $_POST['Member_id'] ?? '';
                        try { $confirmdata = $MemberModel->membercheck($memberid); } catch (Throwable $e) { $this->logPujaCartError('membercheck ERROR|'.$e->getMessage()); $confirmdata = []; }
                        $_SESSION['memberregisterpuja'] = $confirmdata;
                        try { $pujareg = $itemspujasponsorModel->registersankalpapujacheck($memberid); } catch (Throwable $e) { $this->logPujaCartError('registersankalpapujacheck ERROR|'.$e->getMessage()); $pujareg = []; }
                        $_SESSION['pujareg'] = $pujareg;
                        try { $sponsoreventfirst = $itemspujasponsorModel->sponsorevent1check($memberid); } catch (Throwable $e) { $this->logPujaCartError('sponsorevent1check ERROR|'.$e->getMessage()); $sponsoreventfirst = []; }
                        $_SESSION['sponsoreventfirst'] = $sponsoreventfirst;
                        try { $sponsoreventsecond = $itemspujasponsorModel->sponsorevent2check($memberid); } catch (Throwable $e) { $this->logPujaCartError('sponsorevent2check ERROR|'.$e->getMessage()); $sponsoreventsecond = []; }
                        $_SESSION['sponsoreventsecond'] = $sponsoreventsecond;

                        try { $pujasankalpaattempt1arr = $itemspujasponsorModel->pujasankalpaattempt1($memberid); } catch (Throwable $e) { $this->logPujaCartError('pujasankalpaattempt1 ERROR|'.$e->getMessage()); $pujasankalpaattempt1arr = []; }
                        $_SESSION['pujasankalpaattempt1arr'] = $pujasankalpaattempt1arr;

                        try { $pujasankalpaattempt2arr = $itemspujasponsorModel->pujasankalpaattempt2($memberid); } catch (Throwable $e) { $this->logPujaCartError('pujasankalpaattempt2 ERROR|'.$e->getMessage()); $pujasankalpaattempt2arr = []; }
                        $_SESSION['pujasankalpaattempt2arr'] = $pujasankalpaattempt2arr;

                        try { $CategoryAarr = $sponsoritemModel->sponsorCategoryA(); } catch (Throwable $e) { $this->logPujaCartError('sponsorCategoryA ERROR|'.$e->getMessage()); $CategoryAarr = []; }
                        $_SESSION['CategoryAarr'] = $CategoryAarr;

                        try { $CategoryBarr = $sponsoritemModel->sponsorCategoryB(); } catch (Throwable $e) { $this->logPujaCartError('sponsorCategoryB ERROR|'.$e->getMessage()); $CategoryBarr = []; }
                        $_SESSION['CategoryBarr'] = $CategoryBarr;
                        $previousytd = is_numeric($_POST['YTD'] ?? '') ? (float)$_POST['YTD'] : 0;
                        $amountytd = is_numeric($_POST['donation'] ?? '') ? (float)$_POST['donation'] : 0;
                        $newytd = $previousytd + $amountytd;
                        $_SESSION['ytdvalue'] = $newytd;


                    }

                    // if (($_POST["paid_parking_amount"] ?? '') != "") {
                    //     $_SESSION['paid_parking_amount'] = $_POST["paid_parking_amount"] ?? '';
                    // }

                    if (($_POST["adultCouponQty"] ?? '') > 0) {
                                $_SESSION['adultCoupon'] = $_POST["adultCouponQty"] ?? '';
                               
                                
                            }

                            if (($_POST["childCouponQty"] ?? '') > 0) {
                                $_SESSION['childCoupon'] = $_POST["childCouponQty"] ?? '';
                               
                                
                            }
                            if (($_POST["childCouponQty"] ?? '') > 0 || ($_POST["adultCouponQty"] ?? '') > 0) {
                                $_SESSION['totalCouponPrice'] = $_POST["totalCouponPrice"] ?? '';    
                            }
                    $_SESSION['myValue'] = $this->tpl['arr'];
                    $_SESSION['pujakart_payment_processed'] = true;
                    Util::redirect(INSTALL_URL . "PujaCart/show/" . $id);
                    exit();

                }
                // cash
                elseif (($_POST['PaymentOption'] ?? '') == 'cash') {
                    $_POST['totalamount'] = $_POST['cashAmount'] ?? '';
                    $_POST['pay_date'] = $_POST['cashDate'] ?? '';
                    $_POST['DepositAccount'] = $_POST['CashDepositAccount'] ?? '';
                    $_POST['status'] = 'confirmed';
                    $_POST['payment_status'] = 'confirmed';
                    $_POST['id'] = $id;
                    $data = $_POST;
                    $datamemberarr = array();
                    $datamemberarr = array_merge($_POST);
                    try { $pujaregistrationModel->update(array_merge($_POST)); } catch (Throwable $e) { $this->logPujaCartError('update(POST) ERROR | ' . $e->getMessage()); }

                    // $parking['amount'] = $_POST["paid_parking_amount"] ?? '';
                    // $parking['parkingfield'] = "Green Field";
                    // $parking['payment_status'] = 'confirmed';
                    // $parking['status'] = 'confirmed';
                    // if (($_POST["paid_parking_amount"] ?? '') != "") {
                    //     $paidparkingModel->save(array_merge($_POST, $parking));
                    // }

                    $value['oid'] = $_POST['oid'] ?? '';
                    $value['Member_id'] = $datamemberarr['Member_id'];
                    $value['MemberName'] = $datamemberarr['First_name'] . ' ' . $datamemberarr['Last_name'];
                    $value['PaymentOption'] = $datamemberarr['PaymentOption'];
                    $value['payment_status'] = 'succeeded';
                    $value['payment_timestamp'] = $datamemberarr['payment_timestamp'] ?? '';
                    $value['stripe_return'] = $datamemberarr['stripe_return'] ?? '';
                    $value['transaction_id'] = $datamemberarr['transaction_id'];
                    $value['paid_amount'] = $datamemberarr['paid_amount'] ?? '';
                    $value['update_on'] = $datamemberarr['UpdateOn'];
                    $value['stripe_product'] = $datamemberarr['stripe_product'] ?? '';
                    $value['pay_date'] = $datamemberarr['pay_date'];
                    $value['pay_type'] = $datamemberarr['pay_type'];
                    $value['pay_for'] = $datamemberarr['pay_for'];
                    $value['Tele1'] = $datamemberarr['phone'];
                    $value['Tele2'] = $datamemberarr['alternatenumber'];
                    $value['email'] = $datamemberarr['email'];
                    $value['spousename'] = $datamemberarr['Sp_fname'] . ' ' . $datamemberarr['Sp_lname'];
                    $value['Address'] = $datamemberarr['streetname'];
                    $value['Street'] = $datamemberarr['street'];
                    $value['City'] = $datamemberarr['city'];
                    $value['State'] = $datamemberarr['state'];
                    $value['Zip_Code'] = $datamemberarr['zip'];
                    $value['admin_id'] = $datamemberarr['admin_id'];
                    $value['admin_name'] = $datamemberarr['admin_name'];
                    $value['DepositAccount'] = $datamemberarr['DepositAccount'];
                    $extradonationamount = $datamemberarr['donation'];
                    $totalamountwithdonation = $datamemberarr['totalamount'];
                    $SecondAmount = $totalamountwithdonation - $extradonationamount;

                    //try { $DonationModel->SaveDataInDonation($value); } catch (Throwable $donEx) { $this->logPujaCartError('SaveDataInDonation ERROR | ' . $donEx->getMessage()); }
                    if ($extradonationamount == null) {
                        $value['Amount'] = $datamemberarr['totalamount'];
                        try { $DonationModel->SaveDataInDonation($value); } catch (Throwable $donEx) { $this->logPujaCartError('SaveDataInDonation ERROR | ' . $donEx->getMessage()); }
                    }
                    if ($extradonationamount != null) {
                        for ($i = 0; $i <= 1; $i++) {
                            if ($i == 0) {
                                $value['pay_type'] = $datamemberarr['pay_type'];
                                $value['pay_for'] = $datamemberarr['pay_for'];
                                $value['Amount'] = $SecondAmount;
                                try { $DonationModel->SaveDataInDonation($value); } catch (Throwable $donEx) { $this->logPujaCartError('SaveDataInDonation ERROR | ' . $donEx->getMessage()); }
                            }
                            if ($i == 1) {
                                $value['pay_type'] = 'Donation';
                                $value['pay_for'] = 'DONATION / Unrestricted';
                                $value['paymentfor'] = 'Puja Donation';
                                $value['Amount'] = $extradonationamount;
                                try { $DonationModel->SaveDataInDonation($value); } catch (Throwable $donEx) { $this->logPujaCartError('SaveDataInDonation ERROR | ' . $donEx->getMessage()); }
                            }

                        }
                    }



                    if ($datamember == null) {
                        $value = array();
                        // $value['id'] = $_POST['id'] ?? '';
                        $value['Payment_For'] = $_POST['Payment_For'] ?? '';
                        $value['MemberName'] = ($_POST['First_name'] ?? '') . ' ' . ($_POST['Last_name'] ?? '');
                        $value['Amount'] = $_POST['totalamount'] ?? '';
                        $value['PaymentOption'] = $_POST['PaymentOption'] ?? '';
                        $value['payment_status'] = 'confirmed';
                        $value['payment_timestamp'] = $_POST['payment_timestamp'] ?? '';
                        $value['stripe_return'] = $_POST['stripe_return'] ?? '';
                        $value['transaction_id'] = $_POST['transaction_id'] ?? '';
                        $value['paid_amount'] = $_POST['paid_amount'] ?? '';
                        $value['stripe_product'] = $_POST['stripe_product'] ?? '';
                        $value['update_on'] = $_POST['update_on'] ?? '';
                        $value['Member_id'] = $_POST['Member_id'] ?? '';
                        $value['pay_date'] = $_POST['pay_date'] ?? '';
                        $value['cc_name'] = $_POST['cc_name'] ?? '';
                        $value['remarks'] = $_POST['remarks'] ?? '';
                        $value['oid'] = $_POST['oid'] ?? '';
                        $value['pay_type'] = $_POST['pay_type'] ?? '';
                        $value['pay_for'] = $_POST['pay_for'] ?? '';
                        $value['Address'] = $_POST['streetname'] ?? '';
                        $value['Street'] = $_POST['street'] ?? '';
                        $value['Address'] = $_POST['streetname'] ?? '';
                        $value['Address3'] = $_POST['unit'] ?? '';
                        $value['Zip_Code'] = $_POST['zip'] ?? '';
                        $value['Tele2'] = $_POST['alternatenumber'] ?? '';
                        $value['email'] = $_POST['email'] ?? '';
                        $value['City'] = $_POST['city'] ?? '';
                        $value['State'] = $datamemberarr['state'];
                        $value['Tele1'] = $_POST['phone'] ?? '';
                        $value['spousename'] = ($_POST['Sp_fname'] ?? '') . ' ' . ($_POST['Sp_lname'] ?? '');
                        $value['Address3'] = $_POST['Address3'] ?? '';
                        // $value['Parent1'] = ($_POST['parent1_fname'] ?? '') .' '. ($_POST['parent1_lname'] ?? '');
                        // $value['Parent2'] = ($_POST['parent2_fname'] ?? '') .' '. ($_POST['parent2_lname'] ?? '');
                        $value['Child1'] = ($_POST['childonefname'] ?? '') . ' ' . ($_POST['childonelname'] ?? '');
                        $value['Child2'] = ($_POST['childtwofname'] ?? '') . ' ' . ($_POST['childtwolname'] ?? '');
                        $value['Child3'] = ($_POST['childthreefname'] ?? '') . ' ' . ($_POST['childthreelname'] ?? '');
                        $value['Age1'] = $_POST['Age1'] ?? '';
                        $value['Age2'] = $_POST['Age2'] ?? '';
                        $value['Age3'] = $_POST['Age3'] ?? '';
                        try { $MemberModel->SaveDataInmember($value); } catch (Throwable $e) { $this->logPujaCartError('SaveDataInmember ERROR | ' . $e->getMessage()); }
                    }


                            // $_POST['amount'] = $_POST["paid_parking_amount"] ?? '';
                            // $_POST['parkingfield'] = $_POST["parking_area"] ?? '';
                            // $_POST['payment_status'] = 'confirmed';
                            // $_POST['status'] = 'confirmed';
                            // $_POST['paytype'] = 'Parking';
                            // $_POST['remarks'] = 'Registration from puja registration';

                            // $message = $_POST['senior'] ?? '';
                            // // echo "<script type='text/javascript'>alert('$message');</script>";

                            // if (empty($_POST['senior']) ) {
                            //     $_POST['seniorseventyplus'] = null;
                            //     $_POST['senior'] = null;
                            //     $message = $_POST['senior'] ?? '';
                            //     // echo "<script type='text/javascript'>alert('inside if');</script>";
                            //     // echo "<script type='text/javascript'>alert('$message');</script>";

                            // } else {
                            //     $_POST['senior'] = '1';
                            //     $_POST['seniorseventyplus'] = 'yes';
                            //     $message = $_POST['senior'] ?? '';
                            //     // echo "<script type='text/javascript'>alert('inside else');</script>";
                            //     // echo "<script type='text/javascript'>alert('$message');</script>";
                            // }

                           
                            // // $_POST['pay_for'] = 'Parking' . '/' . ($_POST['parkingfield'] ?? '');
                            // $_POST['pay_for'] = 'Parking' . '/' . ($_POST['parkingfield'] ?? '');
                            // if (($_POST["paid_parking_amount"] ?? '') != "") {
                            //     $paidparkingModel->save(array_merge( $_POST));
                            // }

                    $email = $_POST['email'] ?? '';
                    if ($email != null) {
                         $this->sendEmailticket($message, $subjetc, $email, $Emailcc);
                    }
                    $mobileno = $_POST['alternatenumber'] ?? '';
                    if ($mobileno != null) {
                        $this->SendSMS($mobileno, $textmsg );
                    }
                    $this->tpl['arr'] = $pujaregistrationModel->get($id);
                    if (session_status() === PHP_SESSION_NONE) { session_start(); }
                    if (($_POST['donation'] ?? '') != "") {
                        $memberid = $_POST['Member_id'] ?? '';
                        try { $confirmdata = $MemberModel->membercheck($memberid); } catch (Throwable $e) { $this->logPujaCartError('membercheck ERROR|'.$e->getMessage()); $confirmdata = []; }
                        $_SESSION['memberregisterpuja'] = $confirmdata;
                        try { $pujareg = $itemspujasponsorModel->registersankalpapujacheck($memberid); } catch (Throwable $e) { $this->logPujaCartError('registersankalpapujacheck ERROR|'.$e->getMessage()); $pujareg = []; }
                        $_SESSION['pujareg'] = $pujareg;
                        try { $sponsoreventfirst = $itemspujasponsorModel->sponsorevent1check($memberid); } catch (Throwable $e) { $this->logPujaCartError('sponsorevent1check ERROR|'.$e->getMessage()); $sponsoreventfirst = []; }
                        $_SESSION['sponsoreventfirst'] = $sponsoreventfirst;
                        try { $sponsoreventsecond = $itemspujasponsorModel->sponsorevent2check($memberid); } catch (Throwable $e) { $this->logPujaCartError('sponsorevent2check ERROR|'.$e->getMessage()); $sponsoreventsecond = []; }
                        $_SESSION['sponsoreventsecond'] = $sponsoreventsecond;

                        try { $pujasankalpaattempt1arr = $itemspujasponsorModel->pujasankalpaattempt1($memberid); } catch (Throwable $e) { $this->logPujaCartError('pujasankalpaattempt1 ERROR|'.$e->getMessage()); $pujasankalpaattempt1arr = []; }
                        $_SESSION['pujasankalpaattempt1arr'] = $pujasankalpaattempt1arr;

                        try { $pujasankalpaattempt2arr = $itemspujasponsorModel->pujasankalpaattempt2($memberid); } catch (Throwable $e) { $this->logPujaCartError('pujasankalpaattempt2 ERROR|'.$e->getMessage()); $pujasankalpaattempt2arr = []; }
                        $_SESSION['pujasankalpaattempt2arr'] = $pujasankalpaattempt2arr;


                        try { $CategoryAarr = $sponsoritemModel->sponsorCategoryA(); } catch (Throwable $e) { $this->logPujaCartError('sponsorCategoryA ERROR|'.$e->getMessage()); $CategoryAarr = []; }
                        $_SESSION['CategoryAarr'] = $CategoryAarr;

                        try { $CategoryBarr = $sponsoritemModel->sponsorCategoryB(); } catch (Throwable $e) { $this->logPujaCartError('sponsorCategoryB ERROR|'.$e->getMessage()); $CategoryBarr = []; }
                        $_SESSION['CategoryBarr'] = $CategoryBarr;
                        $previousytd = is_numeric($_POST['YTD'] ?? '') ? (float)$_POST['YTD'] : 0;
                        $amountytd = is_numeric($_POST['donation'] ?? '') ? (float)$_POST['donation'] : 0;
                        $newytd = $previousytd + $amountytd;
                        $_SESSION['ytdvalue'] = $newytd;
                        // $_SESSION['paid_parking_amount'] = $_POST["paid_parking_amount"] ?? '';

                    }
                    // if (($_POST["paid_parking_amount"] ?? '') != "") {
                    //     $_SESSION['paid_parking_amount'] = $_POST["paid_parking_amount"] ?? '';
                    // }

                    if (($_POST["adultCouponQty"] ?? '') > 0) {
                                $_SESSION['adultCoupon'] = $_POST["adultCouponQty"] ?? '';
                               
                                
                            }

                            if (($_POST["childCouponQty"] ?? '') > 0) {
                                $_SESSION['childCoupon'] = $_POST["childCouponQty"] ?? '';
                               
                                
                            }
                            if (($_POST["childCouponQty"] ?? '') > 0 || ($_POST["adultCouponQty"] ?? '') > 0) {
                                $_SESSION['totalCouponPrice'] = $_POST["totalCouponPrice"] ?? '';    
                            }
                    $_SESSION['myValue'] = $this->tpl['arr'];
                    $_SESSION['pujakart_payment_processed'] = true;
                    Util::redirect(INSTALL_URL . "PujaCart/show/" . $id);
                    exit();

                }
                //directdeposite
                elseif (($_POST['PaymentOption'] ?? '') == 'directdeposit') {
                    $_POST['bank'] = $_POST['directbank'] ?? '';
                    $_POST['transaction_id'] = $_POST['transactioncode'] ?? '';
                    $_POST['totalamount'] = $_POST['directdepositeamount'] ?? '';
                    $_POST['pay_date'] = $_POST['transactiondate'] ?? '';
                    $_POST['DepositAccount'] = $_POST['DirectPayDepositAccount'] ?? '';
                    $_POST['status'] = 'confirmed';
                    $_POST['payment_status'] = 'confirmed';
                    $_POST['id'] = $id;
                    $data = $_POST;
                    $datamemberarr = array();
                    $datamemberarr = array_merge($_POST);
                    try { $pujaregistrationModel->update(array_merge($_POST)); } catch (Throwable $e) { $this->logPujaCartError('update(POST) ERROR | ' . $e->getMessage()); }

                    // $parking['amount'] = $_POST["paid_parking_amount"] ?? '';
                    // $parking['parkingfield'] = "Green Field";
                    // $parking['payment_status'] = 'confirmed';
                    // $parking['status'] = 'confirmed';
                    // if (($_POST["paid_parking_amount"] ?? '') != "") {
                    //     $paidparkingModel->save(array_merge($_POST, $parking));
                    // }

                    $value['oid'] = $_POST['oid'] ?? '';
                    $value['Member_id'] = $datamemberarr['Member_id'];
                    $value['MemberName'] = $datamemberarr['First_name'] . ' ' . $datamemberarr['Last_name'];
                    $value['PaymentOption'] = $datamemberarr['PaymentOption'];
                    $value['payment_status'] = 'succeeded';
                    $value['payment_timestamp'] = $datamemberarr['payment_timestamp'] ?? '';
                    $value['stripe_return'] = $datamemberarr['stripe_return'] ?? '';
                    $value['transaction_id'] = $datamemberarr['transaction_id'];
                    $value['paid_amount'] = $datamemberarr['paid_amount'] ?? '';
                    $value['update_on'] = $datamemberarr['UpdateOn'];
                    $value['stripe_product'] = $datamemberarr['stripe_product'] ?? '';
                    $value['pay_date'] = $datamemberarr['pay_date'];
                    $value['pay_type'] = $datamemberarr['pay_type'];
                    $value['pay_for'] = $datamemberarr['pay_for'];
                    $value['Tele1'] = $datamemberarr['phone'];
                    $value['Tele2'] = $datamemberarr['alternatenumber'];
                    $value['email'] = $datamemberarr['email'];
                    $value['spousename'] = $datamemberarr['Sp_fname'] . ' ' . $datamemberarr['Sp_lname'];;
                    $value['Address'] = $datamemberarr['streetname'];
                    $value['Street'] = $datamemberarr['street'];
                    $value['City'] = $datamemberarr['city'];
                    $value['State'] = $datamemberarr['state'];
                    $value['Zip_Code'] = $datamemberarr['zip'];
                    $value['admin_id'] = $datamemberarr['admin_id'];
                    $value['admin_name'] = $datamemberarr['admin_name'];
                    $value['DepositAccount'] = $datamemberarr['DepositAccount'];
                    $extradonationamount = $datamemberarr['donation'];
                    $totalamountwithdonation = $datamemberarr['totalamount'];
                    $SecondAmount = $totalamountwithdonation - $extradonationamount;

                    //try { $DonationModel->SaveDataInDonation($value); } catch (Throwable $donEx) { $this->logPujaCartError('SaveDataInDonation ERROR | ' . $donEx->getMessage()); }
                    if ($extradonationamount == null) {
                        $value['Amount'] = $datamemberarr['totalamount'];
                        try { $DonationModel->SaveDataInDonation($value); } catch (Throwable $donEx) { $this->logPujaCartError('SaveDataInDonation ERROR | ' . $donEx->getMessage()); }
                    }
                    if ($extradonationamount != null) {
                        for ($i = 0; $i <= 1; $i++) {
                            if ($i == 0) {
                                $value['pay_type'] = $datamemberarr['pay_type'];
                                $value['pay_for'] = $datamemberarr['pay_for'];
                                $value['Amount'] = $SecondAmount;
                                try { $DonationModel->SaveDataInDonation($value); } catch (Throwable $donEx) { $this->logPujaCartError('SaveDataInDonation ERROR | ' . $donEx->getMessage()); }
                            }
                            if ($i == 1) {
                                $value['pay_type'] = 'Donation';
                                $value['pay_for'] = 'DONATION / Unrestricted';
                                $value['paymentfor'] = 'Puja Donation';
                                $value['Amount'] = $extradonationamount;
                                try { $DonationModel->SaveDataInDonation($value); } catch (Throwable $donEx) { $this->logPujaCartError('SaveDataInDonation ERROR | ' . $donEx->getMessage()); }
                            }

                        }
                    }



                    if ($datamember == null) {
                        $value = array();
                        // $value['id'] = $_POST['id'] ?? '';
                        $value['Payment_For'] = $_POST['Payment_For'] ?? '';
                        $value['MemberName'] = ($_POST['First_name'] ?? '') . ' ' . ($_POST['Last_name'] ?? '');
                        $value['Amount'] = $_POST['totalamount'] ?? '';
                        $value['PaymentOption'] = $_POST['PaymentOption'] ?? '';
                        $value['payment_status'] = 'confirmed';
                        $value['payment_timestamp'] = $_POST['payment_timestamp'] ?? '';
                        $value['stripe_return'] = $_POST['stripe_return'] ?? '';
                        $value['transaction_id'] = $_POST['transaction_id'] ?? '';
                        $value['paid_amount'] = $_POST['paid_amount'] ?? '';
                        $value['stripe_product'] = $_POST['stripe_product'] ?? '';
                        $value['update_on'] = $_POST['update_on'] ?? '';
                        $value['Member_id'] = $_POST['Member_id'] ?? '';
                        $value['pay_date'] = $_POST['pay_date'] ?? '';
                        $value['cc_name'] = $_POST['cc_name'] ?? '';
                        $value['remarks'] = $_POST['remarks'] ?? '';
                        $value['oid'] = $_POST['oid'] ?? '';
                        $value['pay_type'] = $_POST['pay_type'] ?? '';
                        $value['pay_for'] = $_POST['pay_for'] ?? '';
                        $value['Address'] = $_POST['streetname'] ?? '';
                        $value['Street'] = $_POST['street'] ?? '';
                        $value['Address'] = $_POST['streetname'] ?? '';
                        $value['Address3'] = $_POST['unit'] ?? '';
                        $value['Zip_Code'] = $_POST['zip'] ?? '';
                        $value['Tele2'] = $_POST['alternatenumber'] ?? '';
                        $value['email'] = $_POST['email'] ?? '';
                        $value['City'] = $_POST['city'] ?? '';
                        $value['State'] = $datamemberarr['state'];
                        $value['Tele1'] = $_POST['phone'] ?? '';
                        $value['spousename'] = ($_POST['Sp_fname'] ?? '') . ' ' . ($_POST['Sp_lname'] ?? '');
                        $value['Address3'] = $_POST['Address3'] ?? '';
                        //$value['Parent1'] = ($_POST['parent1_fname'] ?? '') .' '. ($_POST['parent1_lname'] ?? '');
                        //$value['Parent2'] = ($_POST['parent2_fname'] ?? '') .' '. ($_POST['parent2_lname'] ?? '');
                        $value['Child1'] = ($_POST['childonefname'] ?? '') . ' ' . ($_POST['childonelname'] ?? '');
                        $value['Child2'] = ($_POST['childtwofname'] ?? '') . ' ' . ($_POST['childtwolname'] ?? '');
                        $value['Child3'] = ($_POST['childthreefname'] ?? '') . ' ' . ($_POST['childthreelname'] ?? '');
                        $value['Age1'] = $_POST['Age1'] ?? '';
                        $value['Age2'] = $_POST['Age2'] ?? '';
                        $value['Age3'] = $_POST['Age3'] ?? '';
                        try { $MemberModel->SaveDataInmember($value); } catch (Throwable $e) { $this->logPujaCartError('SaveDataInmember ERROR | ' . $e->getMessage()); }
                    }

                            // $_POST['amount'] = $_POST["paid_parking_amount"] ?? '';
                            // $_POST['parkingfield'] = $_POST["parking_area"] ?? '';
                            // $_POST['payment_status'] = 'confirmed';
                            // $_POST['status'] = 'confirmed';
                            // $_POST['paytype'] = 'Parking';
                            // $_POST['remarks'] = 'Registration from puja registration';

                            // $message = $_POST['senior'] ?? '';
                            // // echo "<script type='text/javascript'>alert('$message');</script>";

                            // if (empty($_POST['senior']) ) {
                            //     $_POST['seniorseventyplus'] = null;
                            //     $_POST['senior'] = null;
                            //     $message = $_POST['senior'] ?? '';
                            //     // echo "<script type='text/javascript'>alert('inside if');</script>";
                            //     // echo "<script type='text/javascript'>alert('$message');</script>";

                            // } else {
                            //     $_POST['senior'] = '1';
                            //     $_POST['seniorseventyplus'] = 'yes';
                            //     $message = $_POST['senior'] ?? '';
                            //     // echo "<script type='text/javascript'>alert('inside else');</script>";
                            //     // echo "<script type='text/javascript'>alert('$message');</script>";
                            // }

                           
                            // // $_POST['pay_for'] = 'Parking' . '/' . ($_POST['parkingfield'] ?? '');
                            // $_POST['pay_for'] = 'Parking' . '/' . ($_POST['parkingfield'] ?? '');
                            // if (($_POST["paid_parking_amount"] ?? '') != "") {
                            //     $paidparkingModel->save(array_merge( $_POST));
                            // }

                    $email = $_POST['email'] ?? '';
                    if ($email != null) {
                         $this->sendEmailticket($message, $subjetc, $email, $Emailcc);
                    }
                    $mobileno = $_POST['alternatenumber'] ?? '';
                    if ($mobileno != null) {
                        $this->SendSMS($mobileno, $textmsg );
                    }
                    $this->tpl['arr'] = $pujaregistrationModel->get($id);
                    if (session_status() === PHP_SESSION_NONE) { session_start(); }
                    if (($_POST['donation'] ?? '') != "") {
                        $memberid = $_POST['Member_id'] ?? '';
                        try { $confirmdata = $MemberModel->membercheck($memberid); } catch (Throwable $e) { $this->logPujaCartError('membercheck ERROR|'.$e->getMessage()); $confirmdata = []; }
                        $_SESSION['memberregisterpuja'] = $confirmdata;
                        try { $pujareg = $itemspujasponsorModel->registersankalpapujacheck($memberid); } catch (Throwable $e) { $this->logPujaCartError('registersankalpapujacheck ERROR|'.$e->getMessage()); $pujareg = []; }
                        $_SESSION['pujareg'] = $pujareg;
                        try { $sponsoreventfirst = $itemspujasponsorModel->sponsorevent1check($memberid); } catch (Throwable $e) { $this->logPujaCartError('sponsorevent1check ERROR|'.$e->getMessage()); $sponsoreventfirst = []; }
                        $_SESSION['sponsoreventfirst'] = $sponsoreventfirst;
                        try { $sponsoreventsecond = $itemspujasponsorModel->sponsorevent2check($memberid); } catch (Throwable $e) { $this->logPujaCartError('sponsorevent2check ERROR|'.$e->getMessage()); $sponsoreventsecond = []; }
                        $_SESSION['sponsoreventsecond'] = $sponsoreventsecond;

                        try { $pujasankalpaattempt1arr = $itemspujasponsorModel->pujasankalpaattempt1($memberid); } catch (Throwable $e) { $this->logPujaCartError('pujasankalpaattempt1 ERROR|'.$e->getMessage()); $pujasankalpaattempt1arr = []; }
                        $_SESSION['pujasankalpaattempt1arr'] = $pujasankalpaattempt1arr;

                        try { $pujasankalpaattempt2arr = $itemspujasponsorModel->pujasankalpaattempt2($memberid); } catch (Throwable $e) { $this->logPujaCartError('pujasankalpaattempt2 ERROR|'.$e->getMessage()); $pujasankalpaattempt2arr = []; }
                        $_SESSION['pujasankalpaattempt2arr'] = $pujasankalpaattempt2arr;


                        try { $CategoryAarr = $sponsoritemModel->sponsorCategoryA(); } catch (Throwable $e) { $this->logPujaCartError('sponsorCategoryA ERROR|'.$e->getMessage()); $CategoryAarr = []; }
                        $_SESSION['CategoryAarr'] = $CategoryAarr;

                        try { $CategoryBarr = $sponsoritemModel->sponsorCategoryB(); } catch (Throwable $e) { $this->logPujaCartError('sponsorCategoryB ERROR|'.$e->getMessage()); $CategoryBarr = []; }
                        $_SESSION['CategoryBarr'] = $CategoryBarr;
                        $previousytd = is_numeric($_POST['YTD'] ?? '') ? (float)$_POST['YTD'] : 0;
                        $amountytd = is_numeric($_POST['donation'] ?? '') ? (float)$_POST['donation'] : 0;
                        $newytd = $previousytd + $amountytd;
                        $_SESSION['ytdvalue'] = $newytd;
                        // $_SESSION['paid_parking_amount'] = $_POST["paid_parking_amount"] ?? '';

                    }
                    // if (($_POST["paid_parking_amount"] ?? '') != "") {
                    //     $_SESSION['paid_parking_amount'] = $_POST["paid_parking_amount"] ?? '';
                    // }

                    if (($_POST["adultCouponQty"] ?? '') > 0) {
                                $_SESSION['adultCoupon'] = $_POST["adultCouponQty"] ?? '';
                               
                                
                            }

                            if (($_POST["childCouponQty"] ?? '') > 0) {
                                $_SESSION['childCoupon'] = $_POST["childCouponQty"] ?? '';
                               
                                
                            }
                            if (($_POST["childCouponQty"] ?? '') > 0 || ($_POST["adultCouponQty"] ?? '') > 0) {
                                $_SESSION['totalCouponPrice'] = $_POST["totalCouponPrice"] ?? '';    
                            }


                    $_SESSION['myValue'] = $this->tpl['arr'];
                    $_SESSION['pujakart_payment_processed'] = true;
                    Util::redirect(INSTALL_URL . "PujaCart/show/" . $id);
                    exit();

                }
                //sumup
                elseif (($_POST['PaymentOption'] ?? '') == 'sumup') {
                    $_POST['totalamount'] = $_POST['sumupamount'] ?? '';
                    $_POST['transaction_id'] = $_POST['sumupid'] ?? '';
                    $_POST['pay_date'] = $_POST['sumupdate'] ?? '';
                    $_POST['DepositAccount'] = $_POST['SumUpDepositAccount'] ?? '';
                    $_POST['status'] = 'confirmed';
                    $_POST['payment_status'] = 'confirmed';
                    $_POST['id'] = $id;
                    $data = $_POST;
                    $datamemberarr = array();
                    $datamemberarr = array_merge($_POST);
                    try { $pujaregistrationModel->update(array_merge($_POST)); } catch (Throwable $e) { $this->logPujaCartError('update(POST) ERROR | ' . $e->getMessage()); }

                    // $parking['amount'] = $_POST["paid_parking_amount"] ?? '';
                    // $parking['parkingfield'] = "Green Field";
                    // $parking['payment_status'] = 'confirmed';
                    // $parking['status'] = 'confirmed';
                    // if (($_POST["paid_parking_amount"] ?? '') != "") {
                    //     $paidparkingModel->save(array_merge($_POST, $parking));
                    // }

                    $value['oid'] = $_POST['oid'] ?? '';
                    $value['Member_id'] = $datamemberarr['Member_id'];
                    $value['MemberName'] = $datamemberarr['First_name'] . ' ' . $datamemberarr['Last_name'];
                    $value['PaymentOption'] = $datamemberarr['PaymentOption'];
                    $value['payment_status'] = 'succeeded';
                    $value['payment_timestamp'] = $datamemberarr['payment_timestamp'] ?? '';
                    $value['stripe_return'] = $datamemberarr['stripe_return'] ?? '';
                    $value['transaction_id'] = $datamemberarr['transaction_id'];
                    $value['paid_amount'] = $datamemberarr['paid_amount'] ?? '';
                    $value['update_on'] = $datamemberarr['UpdateOn'];
                    $value['stripe_product'] = $datamemberarr['stripe_product'] ?? '';
                    $value['pay_date'] = $datamemberarr['pay_date'];
                    $value['pay_type'] = $datamemberarr['pay_type'];
                    $value['pay_for'] = $datamemberarr['pay_for'];
                    $value['Tele1'] = $datamemberarr['phone'];
                    $value['Tele2'] = $datamemberarr['alternatenumber'];
                    $value['email'] = $datamemberarr['email'];
                    $value['spousename'] = $datamemberarr['Sp_fname'] . ' ' . $datamemberarr['Sp_lname'];
                    ;
                    $value['Address'] = $datamemberarr['streetname'];
                    $value['Street'] = $datamemberarr['street'];
                    $value['City'] = $datamemberarr['city'];
                    $value['State'] = $datamemberarr['state'];
                    $value['Zip_Code'] = $datamemberarr['zip'];
                    $value['admin_id'] = $datamemberarr['admin_id'];
                    $value['admin_name'] = $datamemberarr['admin_name'];
                    $value['DepositAccount'] = $datamemberarr['DepositAccount'];
                    $extradonationamount = $datamemberarr['donation'];
                    $totalamountwithdonation = $datamemberarr['totalamount'];
                    $SecondAmount = $totalamountwithdonation - $extradonationamount;

                    //try { $DonationModel->SaveDataInDonation($value); } catch (Throwable $donEx) { $this->logPujaCartError('SaveDataInDonation ERROR | ' . $donEx->getMessage()); }
                    if ($extradonationamount == null) {
                        $value['Amount'] = $datamemberarr['totalamount'];
                        try { $DonationModel->SaveDataInDonation($value); } catch (Throwable $donEx) { $this->logPujaCartError('SaveDataInDonation ERROR | ' . $donEx->getMessage()); }
                    }
                    if ($extradonationamount != null) {
                        for ($i = 0; $i <= 1; $i++) {
                            if ($i == 0) {
                                $value['pay_type'] = $datamemberarr['pay_type'];
                                $value['pay_for'] = $datamemberarr['pay_for'];
                                $value['Amount'] = $SecondAmount;
                                try { $DonationModel->SaveDataInDonation($value); } catch (Throwable $donEx) { $this->logPujaCartError('SaveDataInDonation ERROR | ' . $donEx->getMessage()); }
                            }
                            if ($i == 1) {
                                $value['pay_type'] = 'Donation';
                                $value['pay_for'] = 'DONATION / Unrestricted';
                                $value['paymentfor'] = 'Puja Donation';
                                $value['Amount'] = $extradonationamount;
                                try { $DonationModel->SaveDataInDonation($value); } catch (Throwable $donEx) { $this->logPujaCartError('SaveDataInDonation ERROR | ' . $donEx->getMessage()); }
                            }

                        }
                    }



                    if ($datamember == null) {
                        $value = array();
                        // $value['id'] = $_POST['id'] ?? '';
                        $value['Payment_For'] = $_POST['Payment_For'] ?? '';
                        $value['MemberName'] = ($_POST['First_name'] ?? '') . ' ' . ($_POST['Last_name'] ?? '');
                        $value['Amount'] = $_POST['totalamount'] ?? '';
                        $value['PaymentOption'] = $_POST['PaymentOption'] ?? '';
                        $value['payment_status'] = 'confirmed';
                        $value['payment_timestamp'] = $_POST['payment_timestamp'] ?? '';
                        $value['stripe_return'] = $_POST['stripe_return'] ?? '';
                        $value['transaction_id'] = $_POST['transaction_id'] ?? '';
                        $value['paid_amount'] = $_POST['paid_amount'] ?? '';
                        $value['stripe_product'] = $_POST['stripe_product'] ?? '';
                        $value['update_on'] = $_POST['update_on'] ?? '';
                        $value['Member_id'] = $_POST['Member_id'] ?? '';
                        $value['pay_date'] = $_POST['pay_date'] ?? '';
                        $value['cc_name'] = $_POST['cc_name'] ?? '';
                        $value['remarks'] = $_POST['remarks'] ?? '';
                        $value['oid'] = $_POST['oid'] ?? '';
                        $value['pay_type'] = $_POST['pay_type'] ?? '';
                        $value['pay_for'] = $_POST['pay_for'] ?? '';
                        $value['Address'] = $_POST['streetname'] ?? '';
                        $value['Street'] = $_POST['street'] ?? '';
                        $value['Address'] = $_POST['streetname'] ?? '';
                        $value['Address3'] = $_POST['unit'] ?? '';
                        $value['Zip_Code'] = $_POST['zip'] ?? '';
                        $value['Tele2'] = $_POST['alternatenumber'] ?? '';
                        $value['email'] = $_POST['email'] ?? '';
                        $value['City'] = $_POST['city'] ?? '';
                        $value['State'] = $datamemberarr['state'];
                        $value['Tele1'] = $_POST['phone'] ?? '';
                        $value['spousename'] = ($_POST['Sp_fname'] ?? '') . ' ' . ($_POST['Sp_lname'] ?? '');
                        $value['Address3'] = $_POST['Address3'] ?? '';
                        // $value['Parent1'] = ($_POST['parent1_fname'] ?? '') .' '. ($_POST['parent1_lname'] ?? '');
                        // $value['Parent2'] = ($_POST['parent2_fname'] ?? '') .' '. ($_POST['parent2_lname'] ?? '');
                        $value['Child1'] = ($_POST['childonefname'] ?? '') . ' ' . ($_POST['childonelname'] ?? '');
                        $value['Child2'] = ($_POST['childtwofname'] ?? '') . ' ' . ($_POST['childtwolname'] ?? '');
                        $value['Child3'] = ($_POST['childthreefname'] ?? '') . ' ' . ($_POST['childthreelname'] ?? '');
                        $value['Age1'] = $_POST['Age1'] ?? '';
                        $value['Age2'] = $_POST['Age2'] ?? '';
                        $value['Age3'] = $_POST['Age3'] ?? '';
                        try { $MemberModel->SaveDataInmember($value); } catch (Throwable $e) { $this->logPujaCartError('SaveDataInmember ERROR | ' . $e->getMessage()); }
                    }


                            // $_POST['amount'] = $_POST["paid_parking_amount"] ?? '';
                            // $_POST['parkingfield'] = $_POST["parking_area"] ?? '';
                            // $_POST['payment_status'] = 'confirmed';
                            // $_POST['status'] = 'confirmed';
                            // $_POST['paytype'] = 'Parking';
                            // $_POST['remarks'] = 'Registration from puja registration';

                            // $message = $_POST['senior'] ?? '';
                            // // echo "<script type='text/javascript'>alert('$message');</script>";

                            // if (empty($_POST['senior']) ) {
                            //     $_POST['seniorseventyplus'] = null;
                            //     $_POST['senior'] = null;
                            //     $message = $_POST['senior'] ?? '';
                            //     // echo "<script type='text/javascript'>alert('inside if');</script>";
                            //     // echo "<script type='text/javascript'>alert('$message');</script>";

                            // } else {
                            //     $_POST['senior'] = '1';
                            //     $_POST['seniorseventyplus'] = 'yes';
                            //     $message = $_POST['senior'] ?? '';
                            //     // echo "<script type='text/javascript'>alert('inside else');</script>";
                            //     // echo "<script type='text/javascript'>alert('$message');</script>";
                            // }

                           
                            // // $_POST['pay_for'] = 'Parking' . '/' . ($_POST['parkingfield'] ?? '');
                            // $_POST['pay_for'] = 'Parking' . '/' . ($_POST['parkingfield'] ?? '');
                            // if (($_POST["paid_parking_amount"] ?? '') != "") {
                            //     $paidparkingModel->save(array_merge( $_POST));
                            // }

                    $email = $_POST['email'] ?? '';
                    if ($email != null) {
                         $this->sendEmailticket($message, $subjetc, $email, $Emailcc);
                    }
                    $mobileno = $_POST['alternatenumber'] ?? '';
                    if ($mobileno != null) {
                        $this->SendSMS($mobileno, $textmsg );
                    }
                    $this->tpl['arr'] = $pujaregistrationModel->get($id);
                    if (session_status() === PHP_SESSION_NONE) { session_start(); }
                    if (($_POST['donation'] ?? '') != "") {
                        $memberid = $_POST['Member_id'] ?? '';
                        try { $confirmdata = $MemberModel->membercheck($memberid); } catch (Throwable $e) { $this->logPujaCartError('membercheck ERROR|'.$e->getMessage()); $confirmdata = []; }
                        $_SESSION['memberregisterpuja'] = $confirmdata;
                        try { $pujareg = $itemspujasponsorModel->registersankalpapujacheck($memberid); } catch (Throwable $e) { $this->logPujaCartError('registersankalpapujacheck ERROR|'.$e->getMessage()); $pujareg = []; }
                        $_SESSION['pujareg'] = $pujareg;
                        try { $sponsoreventfirst = $itemspujasponsorModel->sponsorevent1check($memberid); } catch (Throwable $e) { $this->logPujaCartError('sponsorevent1check ERROR|'.$e->getMessage()); $sponsoreventfirst = []; }
                        $_SESSION['sponsoreventfirst'] = $sponsoreventfirst;
                        try { $sponsoreventsecond = $itemspujasponsorModel->sponsorevent2check($memberid); } catch (Throwable $e) { $this->logPujaCartError('sponsorevent2check ERROR|'.$e->getMessage()); $sponsoreventsecond = []; }
                        $_SESSION['sponsoreventsecond'] = $sponsoreventsecond;

                        try { $pujasankalpaattempt1arr = $itemspujasponsorModel->pujasankalpaattempt1($memberid); } catch (Throwable $e) { $this->logPujaCartError('pujasankalpaattempt1 ERROR|'.$e->getMessage()); $pujasankalpaattempt1arr = []; }
                        $_SESSION['pujasankalpaattempt1arr'] = $pujasankalpaattempt1arr;

                        try { $pujasankalpaattempt2arr = $itemspujasponsorModel->pujasankalpaattempt2($memberid); } catch (Throwable $e) { $this->logPujaCartError('pujasankalpaattempt2 ERROR|'.$e->getMessage()); $pujasankalpaattempt2arr = []; }
                        $_SESSION['pujasankalpaattempt2arr'] = $pujasankalpaattempt2arr;

                        try { $CategoryAarr = $sponsoritemModel->sponsorCategoryA(); } catch (Throwable $e) { $this->logPujaCartError('sponsorCategoryA ERROR|'.$e->getMessage()); $CategoryAarr = []; }
                        $_SESSION['CategoryAarr'] = $CategoryAarr;

                        try { $CategoryBarr = $sponsoritemModel->sponsorCategoryB(); } catch (Throwable $e) { $this->logPujaCartError('sponsorCategoryB ERROR|'.$e->getMessage()); $CategoryBarr = []; }
                        $_SESSION['CategoryBarr'] = $CategoryBarr;
                        $previousytd = is_numeric($_POST['YTD'] ?? '') ? (float)$_POST['YTD'] : 0;
                        $amountytd = is_numeric($_POST['donation'] ?? '') ? (float)$_POST['donation'] : 0;
                        $newytd = $previousytd + $amountytd;
                        $_SESSION['ytdvalue'] = $newytd;
                        // $_SESSION['paid_parking_amount'] = $_POST["paid_parking_amount"] ?? '';

                    }

                    // if (($_POST["paid_parking_amount"] ?? '') != "") {
                    //     $_SESSION['paid_parking_amount'] = $_POST["paid_parking_amount"] ?? '';
                    // }
                            if (($_POST["adultCouponQty"] ?? '') > 0) 
                             {
                                $_SESSION['adultCoupon'] = $_POST["adultCouponQty"] ?? '';
                               
                                
                            }

                            if (($_POST["childCouponQty"] ?? '') > 0) {
                                $_SESSION['childCoupon'] = $_POST["childCouponQty"] ?? '';
                               
                                
                            }
                            if (($_POST["childCouponQty"] ?? '') > 0 || ($_POST["adultCouponQty"] ?? '') > 0) {
                                $_SESSION['totalCouponPrice'] = $_POST["totalCouponPrice"] ?? '';    
                            }

                    $_SESSION['myValue'] = $this->tpl['arr'];
                    $_SESSION['pujakart_payment_processed'] = true;
                    Util::redirect(INSTALL_URL . "PujaCart/show/" . $id);
                    exit();

                }


                elseif (($_POST['PaymentOption'] ?? '') == 'zelleProxy') {
                    $_POST['totalamount'] = $_POST['proxyamount'] ?? '';
                    $_POST['transaction_id'] = $_POST['zelleProxyTid'] ?? '';
                    $_POST['pay_date'] = $_POST['proxydate'] ?? '';
                    $_POST['DepositAccount'] = $_POST['zelleProxyDepositAccount'] ?? '';
                    $_POST['status'] = 'confirmed';
                    $_POST['payment_status'] = 'confirmed';
                    $_POST['id'] = $id;
                    $data = $_POST;
                    $datamemberarr = array();
                    $datamemberarr = array_merge($_POST);
                    try { $pujaregistrationModel->update(array_merge($_POST)); } catch (Throwable $e) { $this->logPujaCartError('update(POST) ERROR | ' . $e->getMessage()); }

                    // $parking['amount'] = $_POST["paid_parking_amount"] ?? '';
                    // $parking['parkingfield'] = "Green Field";
                    // $parking['payment_status'] = 'confirmed';
                    // $parking['status'] = 'confirmed';
                    // if (($_POST["paid_parking_amount"] ?? '') != "") {
                    //     $paidparkingModel->save(array_merge($_POST, $parking));
                    // }

                    $value['oid'] = $_POST['oid'] ?? '';
                    $value['Member_id'] = $datamemberarr['Member_id'];
                    $value['MemberName'] = $datamemberarr['First_name'] . ' ' . $datamemberarr['Last_name'];
                    $value['PaymentOption'] = $datamemberarr['PaymentOption'];
                    $value['payment_status'] = 'succeeded';
                    $value['payment_timestamp'] = $datamemberarr['payment_timestamp'] ?? '';
                    $value['stripe_return'] = $datamemberarr['stripe_return'] ?? '';
                    $value['transaction_id'] = $datamemberarr['transaction_id'];
                    $value['paid_amount'] = $datamemberarr['paid_amount'] ?? '';
                    $value['update_on'] = $datamemberarr['UpdateOn'];
                    $value['stripe_product'] = $datamemberarr['stripe_product'] ?? '';
                    $value['pay_date'] = $datamemberarr['pay_date'];
                    $value['pay_type'] = $datamemberarr['pay_type'];
                    $value['pay_for'] = $datamemberarr['pay_for'];
                    $value['Tele1'] = $datamemberarr['phone'];
                    $value['Tele2'] = $datamemberarr['alternatenumber'];
                    $value['email'] = $datamemberarr['email'];
                    $value['spousename'] = $datamemberarr['Sp_fname'] . ' ' . $datamemberarr['Sp_lname'];
                    ;
                    $value['Address'] = $datamemberarr['streetname'];
                    $value['Street'] = $datamemberarr['street'];
                    $value['City'] = $datamemberarr['city'];
                    $value['State'] = $datamemberarr['state'];
                    $value['Zip_Code'] = $datamemberarr['zip'];
                    $value['admin_id'] = $datamemberarr['admin_id'];
                    $value['admin_name'] = $datamemberarr['admin_name'];
                    $value['DepositAccount'] = $datamemberarr['DepositAccount'];
                    $extradonationamount = $datamemberarr['donation'];
                    $totalamountwithdonation = $datamemberarr['totalamount'];
                    $SecondAmount = $totalamountwithdonation - $extradonationamount;

                    //try { $DonationModel->SaveDataInDonation($value); } catch (Throwable $donEx) { $this->logPujaCartError('SaveDataInDonation ERROR | ' . $donEx->getMessage()); }
                    if ($extradonationamount == null) {
                        $value['Amount'] = $datamemberarr['totalamount'];
                        try { $DonationModel->SaveDataInDonation($value); } catch (Throwable $donEx) { $this->logPujaCartError('SaveDataInDonation ERROR | ' . $donEx->getMessage()); }
                    }
                    if ($extradonationamount != null) {
                        for ($i = 0; $i <= 1; $i++) {
                            if ($i == 0) {
                                $value['pay_type'] = $datamemberarr['pay_type'];
                                $value['pay_for'] = $datamemberarr['pay_for'];
                                $value['Amount'] = $SecondAmount;
                                try { $DonationModel->SaveDataInDonation($value); } catch (Throwable $donEx) { $this->logPujaCartError('SaveDataInDonation ERROR | ' . $donEx->getMessage()); }
                            }
                            if ($i == 1) {
                                $value['pay_type'] = 'Donation';
                                $value['pay_for'] = 'DONATION / Unrestricted';
                                $value['paymentfor'] = 'Puja Donation';
                                $value['Amount'] = $extradonationamount;
                                try { $DonationModel->SaveDataInDonation($value); } catch (Throwable $donEx) { $this->logPujaCartError('SaveDataInDonation ERROR | ' . $donEx->getMessage()); }
                            }

                        }
                    }



                    if ($datamember == null) {
                        $value = array();
                        // $value['id'] = $_POST['id'] ?? '';
                        $value['Payment_For'] = $_POST['Payment_For'] ?? '';
                        $value['MemberName'] = ($_POST['First_name'] ?? '') . ' ' . ($_POST['Last_name'] ?? '');
                        $value['Amount'] = $_POST['totalamount'] ?? '';
                        $value['PaymentOption'] = $_POST['PaymentOption'] ?? '';
                        $value['payment_status'] = 'confirmed';
                        $value['payment_timestamp'] = $_POST['payment_timestamp'] ?? '';
                        $value['stripe_return'] = $_POST['stripe_return'] ?? '';
                        $value['transaction_id'] = $_POST['transaction_id'] ?? '';
                        $value['paid_amount'] = $_POST['paid_amount'] ?? '';
                        $value['stripe_product'] = $_POST['stripe_product'] ?? '';
                        $value['update_on'] = $_POST['update_on'] ?? '';
                        $value['Member_id'] = $_POST['Member_id'] ?? '';
                        $value['pay_date'] = $_POST['pay_date'] ?? '';
                        $value['cc_name'] = $_POST['cc_name'] ?? '';
                        $value['remarks'] = $_POST['remarks'] ?? '';
                        $value['oid'] = $_POST['oid'] ?? '';
                        $value['pay_type'] = $_POST['pay_type'] ?? '';
                        $value['pay_for'] = $_POST['pay_for'] ?? '';
                        $value['Address'] = $_POST['streetname'] ?? '';
                        $value['Street'] = $_POST['street'] ?? '';
                        $value['Address'] = $_POST['streetname'] ?? '';
                        $value['Address3'] = $_POST['unit'] ?? '';
                        $value['Zip_Code'] = $_POST['zip'] ?? '';
                        $value['Tele2'] = $_POST['alternatenumber'] ?? '';
                        $value['email'] = $_POST['email'] ?? '';
                        $value['City'] = $_POST['city'] ?? '';
                        $value['State'] = $datamemberarr['state'];
                        $value['Tele1'] = $_POST['phone'] ?? '';
                        $value['spousename'] = ($_POST['Sp_fname'] ?? '') . ' ' . ($_POST['Sp_lname'] ?? '');
                        $value['Address3'] = $_POST['Address3'] ?? '';
                        // $value['Parent1'] = ($_POST['parent1_fname'] ?? '') .' '. ($_POST['parent1_lname'] ?? '');
                        // $value['Parent2'] = ($_POST['parent2_fname'] ?? '') .' '. ($_POST['parent2_lname'] ?? '');
                        $value['Child1'] = ($_POST['childonefname'] ?? '') . ' ' . ($_POST['childonelname'] ?? '');
                        $value['Child2'] = ($_POST['childtwofname'] ?? '') . ' ' . ($_POST['childtwolname'] ?? '');
                        $value['Child3'] = ($_POST['childthreefname'] ?? '') . ' ' . ($_POST['childthreelname'] ?? '');
                        $value['Age1'] = $_POST['Age1'] ?? '';
                        $value['Age2'] = $_POST['Age2'] ?? '';
                        $value['Age3'] = $_POST['Age3'] ?? '';
                        try { $MemberModel->SaveDataInmember($value); } catch (Throwable $e) { $this->logPujaCartError('SaveDataInmember ERROR | ' . $e->getMessage()); }
                    }


                            // $_POST['amount'] = $_POST["paid_parking_amount"] ?? '';
                            // $_POST['parkingfield'] = $_POST["parking_area"] ?? '';
                            // $_POST['payment_status'] = 'confirmed';
                            // $_POST['status'] = 'confirmed';
                            // $_POST['paytype'] = 'Parking';
                            // $_POST['remarks'] = 'Registration from puja registration';

                            // $message = $_POST['senior'] ?? '';
                            // // echo "<script type='text/javascript'>alert('$message');</script>";

                            // if (empty($_POST['senior']) ) {
                            //     $_POST['seniorseventyplus'] = null;
                            //     $_POST['senior'] = null;
                            //     $message = $_POST['senior'] ?? '';
                            //     // echo "<script type='text/javascript'>alert('inside if');</script>";
                            //     // echo "<script type='text/javascript'>alert('$message');</script>";

                            // } else {
                            //     $_POST['senior'] = '1';
                            //     $_POST['seniorseventyplus'] = 'yes';
                            //     $message = $_POST['senior'] ?? '';
                            //     // echo "<script type='text/javascript'>alert('inside else');</script>";
                            //     // echo "<script type='text/javascript'>alert('$message');</script>";
                            // }

                           
                            // // $_POST['pay_for'] = 'Parking' . '/' . ($_POST['parkingfield'] ?? '');
                            // $_POST['pay_for'] = 'Parking' . '/' . ($_POST['parkingfield'] ?? '');
                            // if (($_POST["paid_parking_amount"] ?? '') != "") {
                            //     $paidparkingModel->save(array_merge( $_POST));
                            // }

                    $email = $_POST['email'] ?? '';
                    if ($email != null) {
                         $this->sendEmailticket($message, $subjetc, $email, $Emailcc);
                    }
                    $mobileno = $_POST['alternatenumber'] ?? '';
                    if ($mobileno != null) {
                        $this->SendSMS($mobileno, $textmsg );
                    }
                    $this->tpl['arr'] = $pujaregistrationModel->get($id);
                    if (session_status() === PHP_SESSION_NONE) { session_start(); }
                    if (($_POST['donation'] ?? '') != "") {
                        $memberid = $_POST['Member_id'] ?? '';
                        try { $confirmdata = $MemberModel->membercheck($memberid); } catch (Throwable $e) { $this->logPujaCartError('membercheck ERROR|'.$e->getMessage()); $confirmdata = []; }
                        $_SESSION['memberregisterpuja'] = $confirmdata;
                        try { $pujareg = $itemspujasponsorModel->registersankalpapujacheck($memberid); } catch (Throwable $e) { $this->logPujaCartError('registersankalpapujacheck ERROR|'.$e->getMessage()); $pujareg = []; }
                        $_SESSION['pujareg'] = $pujareg;
                        try { $sponsoreventfirst = $itemspujasponsorModel->sponsorevent1check($memberid); } catch (Throwable $e) { $this->logPujaCartError('sponsorevent1check ERROR|'.$e->getMessage()); $sponsoreventfirst = []; }
                        $_SESSION['sponsoreventfirst'] = $sponsoreventfirst;
                        try { $sponsoreventsecond = $itemspujasponsorModel->sponsorevent2check($memberid); } catch (Throwable $e) { $this->logPujaCartError('sponsorevent2check ERROR|'.$e->getMessage()); $sponsoreventsecond = []; }
                        $_SESSION['sponsoreventsecond'] = $sponsoreventsecond;

                        try { $pujasankalpaattempt1arr = $itemspujasponsorModel->pujasankalpaattempt1($memberid); } catch (Throwable $e) { $this->logPujaCartError('pujasankalpaattempt1 ERROR|'.$e->getMessage()); $pujasankalpaattempt1arr = []; }
                        $_SESSION['pujasankalpaattempt1arr'] = $pujasankalpaattempt1arr;

                        try { $pujasankalpaattempt2arr = $itemspujasponsorModel->pujasankalpaattempt2($memberid); } catch (Throwable $e) { $this->logPujaCartError('pujasankalpaattempt2 ERROR|'.$e->getMessage()); $pujasankalpaattempt2arr = []; }
                        $_SESSION['pujasankalpaattempt2arr'] = $pujasankalpaattempt2arr;

                        try { $CategoryAarr = $sponsoritemModel->sponsorCategoryA(); } catch (Throwable $e) { $this->logPujaCartError('sponsorCategoryA ERROR|'.$e->getMessage()); $CategoryAarr = []; }
                        $_SESSION['CategoryAarr'] = $CategoryAarr;

                        try { $CategoryBarr = $sponsoritemModel->sponsorCategoryB(); } catch (Throwable $e) { $this->logPujaCartError('sponsorCategoryB ERROR|'.$e->getMessage()); $CategoryBarr = []; }
                        $_SESSION['CategoryBarr'] = $CategoryBarr;
                        $previousytd = is_numeric($_POST['YTD'] ?? '') ? (float)$_POST['YTD'] : 0;
                        $amountytd = is_numeric($_POST['donation'] ?? '') ? (float)$_POST['donation'] : 0;
                        $newytd = $previousytd + $amountytd;
                        $_SESSION['ytdvalue'] = $newytd;
                        // $_SESSION['paid_parking_amount'] = $_POST["paid_parking_amount"] ?? '';

                    }

                    // if (($_POST["paid_parking_amount"] ?? '') != "") {
                    //     $_SESSION['paid_parking_amount'] = $_POST["paid_parking_amount"] ?? '';
                    // }

                            if (($_POST["adultCouponQty"] ?? '') > 0) {
                                $_SESSION['adultCoupon'] = $_POST["adultCouponQty"] ?? '';
                               
                                
                            }

                            if (($_POST["childCouponQty"] ?? '') > 0) {
                                $_SESSION['childCoupon'] = $_POST["childCouponQty"] ?? '';
                               
                                
                            }
                            if (($_POST["childCouponQty"] ?? '') > 0 || ($_POST["adultCouponQty"] ?? '') > 0) {
                                $_SESSION['totalCouponPrice'] = $_POST["totalCouponPrice"] ?? '';    
                            }


                    $_SESSION['myValue'] = $this->tpl['arr'];
                    $_SESSION['pujakart_payment_processed'] = true;
                    Util::redirect(INSTALL_URL . "PujaCart/show/" . $id);
                    exit();

                }
                //Coplimentory Registration
                elseif (($_POST['PaymentOption'] ?? '') == 'ComplimentaryRegistration') {

                    //$opts['payment_status'] = 'confirmed';
                    $_POST['payment_status'] = 'confirmed';
                    $_POST['status'] = 'confirmed';
                    $_POST['id'] = $id;

                    try { $pujaregistrationModel->update(array_merge($_POST)); } catch (Throwable $e) { $this->logPujaCartError('update(POST) ERROR | ' . $e->getMessage()); }

                    // $parking['amount'] = $_POST["paid_parking_amount"] ?? '';
                    // $parking['parkingfield'] = "Green Field";
                    // $parking['payment_status'] = 'confirmed';
                    // $parking['status'] = 'confirmed';
                    // if (($_POST["paid_parking_amount"] ?? '') != "") {
                    //     $paidparkingModel->save(array_merge($_POST, $parking));
                    // }


                    $orderid = $_POST['oid'] ?? '';
                    $Memberid = $_POST['Member_id'] ?? '';
                    $membername = ($_POST['First_name'] ?? '') . ' ' . ($_POST['Last_name'] ?? '');
                    $pujatype = $_POST['puja_type'] ?? '';
                    $Status = "Confirmed";
                    $today = date("m/d/Y");
                    $registrationDate = $today;
                    $payMethod = "Complimentary Registration";


                    $Emailcc = 'pujaregpayment@durgabari.org';
                    $subjetEmail = 'Puja Registration Confirmation';
                    $emailmessage = '<p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</p>
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
                    <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Puja Type&nbsp;&nbsp;</td>
                    <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $pujatype . '</td>
                    </tr>
                    <tr>
                    <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Payment Method &nbsp;</td>
                    <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $payMethod . '</td>
                    </tr>';


                    if ($adultCoupon > 0) {
                    $emailmessage .= '<tr>
                    <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Total Adult Coupon Quantity&nbsp;&nbsp;</td>
                    <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;"><span style="color:red;"></span>' . $adultCoupon . '</td>
                    </tr>
                    ';
                }

                if ($childCoupon > 0) {
                    $emailmessage .= '<tr>
                    <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Total Child Coupon Quantity&nbsp;&nbsp;</td>
                    <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;"><span style="color:red;"></span>' . $childCoupon . '</td>
                    </tr>
                    ';
                }
                
                if (($_POST['greenFieldParkingDecision'] ?? '') != "") {
                    $emailmessage .= '<tr>
                    <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Parking Message &nbsp;&nbsp;</td>
                    <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;"><span style="color:red;"></span>' . ($_POST['greenFieldParkingDecision'] ?? '') . '</td>
                    </tr>
                    ';
                }


                    $emailmessage .= '<tr>
                    <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Registration Date &nbsp;</td>
                    <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $registrationDate . '</td>
                    </tr>
                    <tr>
                    <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Status &nbsp;</td>
                    <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $Status . '</td>
                    </tr>
                    </tbody>
                    </table>
                    </div>
                    </div>
                    </div>';



                            // $_POST['amount'] = $_POST["paid_parking_amount"] ?? '';
                            // $_POST['parkingfield'] = $_POST["parking_area"] ?? '';
                            // $_POST['payment_status'] = 'confirmed';
                            // $_POST['status'] = 'confirmed';
                            // $_POST['paytype'] = 'Parking';
                            // $_POST['remarks'] = 'Registration from puja registration';

                            // $message = $_POST['senior'] ?? '';
                            // // echo "<script type='text/javascript'>alert('$message');</script>";

                            // if (empty($_POST['senior']) ) {
                            //     $_POST['seniorseventyplus'] = null;
                            //     $_POST['senior'] = null;
                            //     $message = $_POST['senior'] ?? '';
                            //     // echo "<script type='text/javascript'>alert('inside if');</script>";
                            //     // echo "<script type='text/javascript'>alert('$message');</script>";

                            // } else {
                            //     $_POST['senior'] = '1';
                            //     $_POST['seniorseventyplus'] = 'yes';
                            //     $message = $_POST['senior'] ?? '';
                            //     // echo "<script type='text/javascript'>alert('inside else');</script>";
                            //     // echo "<script type='text/javascript'>alert('$message');</script>";
                            // }

                           
                            // // $_POST['pay_for'] = 'Parking' . '/' . ($_POST['parkingfield'] ?? '');
                            // $_POST['pay_for'] = 'Parking' . '/' . ($_POST['parkingfield'] ?? '');
                            // if (($_POST["paid_parking_amount"] ?? '') != "") {
                            //     $paidparkingModel->save(array_merge( $_POST));
                            // }



                    $email = $_POST['email'] ?? '';
                    if ($email != null) {
                         $this->sendEmailticket($emailmessage, $subjetEmail, $email, $Emailcc);
                    }
                    $mobileno = $_POST['alternatenumber'] ?? '';
                    if ($mobileno != null) {
                        
                        $registrationConfirmationMsg = 'Houston Durga Bari: Puja Registration confirmation are Order Id: ' . $orderid . ', Member Id: ' . $Memberid . ', Full Name: ' . $membername . ', Puja Type: ' . $pujatype . ', Payment Method: ' . $payMethod . ', Registration Date: ' . $registrationDate . ', Status: ' . $Status;

                        if ($adultCoupon != "") {
                            $registrationConfirmationMsg .= ', Total Adult Coupon: ' . $adultCoupon;
                        }

                        if ($childCoupon != "") {
                            $registrationConfirmationMsg .= ', Total Child Coupon: ' . $childCoupon;
                        }
                        if (($_POST['greenFieldParkingDecision'] ?? '') != "") {
                $registrationConfirmationMsg .= ', Parking Message: ' . ($_POST['greenFieldParkingDecision'] ?? '');
            }
                        // $registrationConfirmationMsg = 'Houston Durga Bari: Puja Registration confirmation are Order Id: ' . $orderid . ', Member Id: ' . $Memberid . ', Full Name: ' . $membername . ', Puja Type: ' . $pujatype . ', Payment Method: ' . $payMethod . ',Registration Date: ' . $registrationDate . ', Status: ' . $Status;
                        $this->SendSMS($mobileno, $registrationConfirmationMsg );
                    }
                    $this->tpl['arr'] = $pujaregistrationModel->get($id);
                    if (session_status() === PHP_SESSION_NONE) { session_start(); }
                    $_SESSION['myValue'] = $this->tpl['arr'];
                    $_SESSION['pujakart_payment_processed'] = true;
                    Util::redirect(INSTALL_URL . "PujaCart/show/" . $id);
                    exit();

                }
                // stripe
                elseif (($_POST['PaymentOption'] ?? '') == 'stripe') {
                    //$token = $_POST['stripeToken'] ?? '';
                    // echo "<script>alert('$token')</script>";

                    $amount = $_POST['totalamount'] ?? '';

                    $total = $amount;

                    require APP_PATH . '/helpers/stripe/lib/Stripe.php';

                    $error = '';
                    $success = '';

                    try {
                        $stripeApiKey = $this->getPujaCartStripeApiKey();
                        if ($stripeApiKey === '') {
                            throw new Exception("Stripe API key is not configured.");
                        }
                        Stripe::setApiKey($stripeApiKey);
                        if (!isset($_POST['stripeToken'])) {
                            throw new Exception("The Stripe Token was not generated correctly");
                        }

                        $payForType = $_POST['pay_for'] ?? '';
                        if (!empty($_POST["paid_parking_amount"]) && is_numeric($_POST["paid_parking_amount"] ?? '')) {
                            $payForType = ($_POST['pay_for'] ?? '') . "/Parking/" . ($_POST["parking_area"] ?? '');
                        }

                        $oid = $_POST['oid'] ?? '';
                        $amount = round($amount * 100);

                        $payment = Stripe_Charge::create(array(
                            "amount" => $amount,
                            "currency" => "USD",
                            //"currency" => $this->tpl["option_arr_values"]["currency"],
                            "card" => $_POST['stripeToken'] ?? '',
                            "description" => "Pay For:" . 'Registration' . "/" . $payForType . ', ' . "Email:" . ($_POST['email'] ?? '') . ', ' . "Full Name:" . ($_POST['First_name'] ?? '') . ' ' . ($_POST['Last_name'] ?? ''),
                            "metadata" => ["orderid" => $oid]
                        ));

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
                            //$opts['payment_status'] = 'succeeded';
                            $opts['status'] = 'confirmed';
                            $opts['payment_timestamp'] = time();

                            $data = $_POST;
                            $datamemberarr = array();
                            $datamemberarr = array_merge($opts, $_POST);
                            try { $pujaregistrationModel->update(array_merge($opts, $_POST)); } catch (Throwable $e) { $this->logPujaCartError('update(opts+POST) ERROR | ' . $e->getMessage()); }




                            $value['oid'] = $oid;
                            $value['Member_id'] = $datamemberarr['Member_id'];
                            $value['MemberName'] = $datamemberarr['First_name'] . ' ' . $datamemberarr['Last_name'];
                            $value['PaymentOption'] = $datamemberarr['PaymentOption'];
                            $value['payment_status'] = 'succeeded';
                            $value['payment_timestamp'] = $datamemberarr['payment_timestamp'] ?? '';
                            $value['stripe_return'] = $datamemberarr['stripe_return'] ?? '';
                            $value['transaction_id'] = $datamemberarr['transaction_id'];
                            $value['paid_amount'] = $datamemberarr['paid_amount'] ?? '';
                            if (!empty($datamemberarr['UpdateOn'] ?? '')) {
                                $value['update_on'] = $datamemberarr['UpdateOn'];
                            }
                            $value['stripe_product'] = $datamemberarr['stripe_product'] ?? '';
                            $value['pay_date'] = $datamemberarr['pay_date'];
                            $value['pay_type'] = $datamemberarr['pay_type'];
                            $value['pay_for'] = $datamemberarr['pay_for'];
                            $value['Tele1'] = $datamemberarr['phone'];
                            $value['Tele2'] = $datamemberarr['alternatenumber'];
                            $value['email'] = $datamemberarr['email'];
                            $value['spousename'] = $datamemberarr['Sp_fname'] . ' ' . $datamemberarr['Sp_lname'];
                            $value['Address'] = $datamemberarr['streetname'];
                            $value['Street'] = $datamemberarr['street'];
                            $value['City'] = $datamemberarr['city'];
                            $value['State'] = $datamemberarr['state'];
                            $value['Zip_Code'] = $datamemberarr['zip'];
                            $value['admin_id'] = $datamemberarr['admin_id'] ?? '';
                            $value['admin_name'] = $datamemberarr['admin_name'] ?? '';
                            //$value['Amount'] = $datamemberarr['totalamount'];
                            $extradonationamount = $datamemberarr['donation'];
                            $totalamountwithdonation = $datamemberarr['totalamount'];

                            $SecondAmount = $totalamountwithdonation - $extradonationamount;
                            //try { $DonationModel->SaveDataInDonation($value); } catch (Throwable $donEx) { $this->logPujaCartError('SaveDataInDonation ERROR | ' . $donEx->getMessage()); }
                            if ($extradonationamount == null) {
                                $value['Amount'] = $datamemberarr['totalamount'];
                                try { $DonationModel->SaveDataInDonation($value); } catch (Throwable $donEx) { $this->logPujaCartError('SaveDataInDonation ERROR | ' . $donEx->getMessage()); }
                            }
                            if ($extradonationamount != null) {
                                for ($i = 0; $i <= 1; $i++) {
                                    if ($i == 0) {

                                        $value['pay_type'] = $datamemberarr['pay_type'];
                                        $value['pay_for'] = $datamemberarr['pay_for'];
                                        $value['Amount'] = $SecondAmount;
                                        try { $DonationModel->SaveDataInDonation($value); } catch (Throwable $donEx) { $this->logPujaCartError('SaveDataInDonation ERROR | ' . $donEx->getMessage()); }
                                    }
                                    if ($i == 1) {
                                        $value['pay_type'] = 'Donation';
                                        $value['pay_for'] = 'DONATION / Unrestricted';
                                        $value['paymentfor'] = 'Puja Donation';
                                        $value['Amount'] = $extradonationamount;
                                        try { $DonationModel->SaveDataInDonation($value); } catch (Throwable $donEx) { $this->logPujaCartError('SaveDataInDonation ERROR | ' . $donEx->getMessage()); }
                                    }

                                }
                            }


                            if ($datamember == null) {
                                $value = array();
                                // $value['id'] = $_POST['id'] ?? '';
                                $value['Payment_For'] = $_POST['Payment_For'] ?? '';
                                $value['MemberName'] = ($_POST['First_name'] ?? '') . ' ' . ($_POST['Last_name'] ?? '');
                                $value['Amount'] = $_POST['totalamount'] ?? '';
                                $value['PaymentOption'] = $_POST['PaymentOption'] ?? '';
                                $value['payment_status'] = 'confirmed';
                                $value['payment_timestamp'] = $opts['payment_timestamp'] ?? '';
                                $value['stripe_return'] = $opts['stripe_return'] ?? '';
                                $value['transaction_id'] = $opts['transaction_id'];
                                $value['paid_amount'] = $opts['paid_amount'] ?? '';
                                $value['stripe_product'] = $opts['stripe_product'] ?? '';
                                $value['update_on'] = $_POST['update_on'] ?? '';
                                $value['Member_id'] = $_POST['Member_id'] ?? '';
                                $value['pay_date'] = $_POST['pay_date'] ?? '';
                                $value['cc_name'] = $_POST['cc_name'] ?? '';
                                $value['remarks'] = $_POST['remarks'] ?? '';
                                $value['oid'] = $_POST['oid'] ?? '';
                                $value['pay_type'] = $_POST['pay_type'] ?? '';
                                $value['pay_for'] = $_POST['pay_for'] ?? '';
                                $value['Address'] = $_POST['streetname'] ?? '';
                                $value['Street'] = $_POST['street'] ?? '';
                                $value['Address'] = $_POST['streetname'] ?? '';
                                $value['Address3'] = $_POST['unit'] ?? '';
                                $value['Zip_Code'] = $_POST['zip'] ?? '';
                                $value['Tele2'] = $_POST['alternatenumber'] ?? '';
                                $value['email'] = $_POST['email'] ?? '';
                                $value['City'] = $_POST['city'] ?? '';
                                $value['State'] = $datamemberarr['state'];
                                $value['Tele1'] = $_POST['phone'] ?? '';
                                $value['spousename'] = ($_POST['Sp_fname'] ?? '') . ' ' . ($_POST['Sp_lname'] ?? '');
                                $value['Address3'] = $_POST['Address3'] ?? '';
                                // $value['Parent1'] = ($_POST['parent1_fname'] ?? '') .' '. ($_POST['parent1_lname'] ?? '');
                                //$value['Parent2'] = ($_POST['parent2_fname'] ?? '') .' '. ($_POST['parent2_lname'] ?? '');
                                $value['Child1'] = ($_POST['childonefname'] ?? '') . ' ' . ($_POST['childonelname'] ?? '');
                                $value['Child2'] = ($_POST['childtwofname'] ?? '') . ' ' . ($_POST['childtwolname'] ?? '');
                                $value['Child3'] = ($_POST['childthreefname'] ?? '') . ' ' . ($_POST['childthreelname'] ?? '');
                                $value['Age1'] = $_POST['Age1'] ?? '';
                                $value['Age2'] = $_POST['Age2'] ?? '';
                                $value['Age3'] = $_POST['Age3'] ?? '';
                                try { $MemberModel->SaveDataInmember($value); } catch (Throwable $e) { $this->logPujaCartError('SaveDataInmember ERROR | ' . $e->getMessage()); }
                            }

                            // $_POST['amount'] = $_POST["paid_parking_amount"] ?? '';
                            // $_POST['parkingfield'] = $_POST["parking_area"] ?? '';
                            // $_POST['payment_status'] = 'confirmed';
                            // $_POST['status'] = 'confirmed';
                            // $_POST['paytype'] = 'Parking';
                            // $_POST['remarks'] = 'Registration from puja registration';

                            // $message = $_POST['senior'] ?? '';
                         
                            // if (empty($_POST['senior']) ) {
                            //     $_POST['seniorseventyplus'] = null;
                            //     $_POST['senior'] = null;
                            //     $message = $_POST['senior'] ?? '';
                                

                            // } else {
                            //     $_POST['senior'] = '1';
                            //     $_POST['seniorseventyplus'] = 'yes';
                            //     $message = $_POST['senior'] ?? '';
                              
                            // }

                           
                            
                            // $_POST['pay_for'] = 'Parking' . '/' . ($_POST['parkingfield'] ?? '');
                            // if (($_POST["paid_parking_amount"] ?? '') != "") {
                            //     $paidparkingModel->save(array_merge($opts, $_POST));
                            // }


                            $email = $_POST['email'] ?? '';
                            if ($email != null) {
                                 $this->sendEmailticket($message, $subjetc, $email, $Emailcc);
                            }
                            $mobileno = $_POST['alternatenumber'] ?? '';
                            if ($mobileno != null) {
                                $this->SendSMS($mobileno, $textmsg );
                            }

                            $this->tpl['arr'] = $pujaregistrationModel->get($id);
                            if (session_status() === PHP_SESSION_NONE) { session_start(); }
                            if (($_POST['donation'] ?? '') != "") {
                                $memberid = $_POST['Member_id'] ?? '';
                                try { $confirmdata = $MemberModel->membercheck($memberid); } catch (Throwable $e) { $this->logPujaCartError('membercheck ERROR|'.$e->getMessage()); $confirmdata = []; }
                                $_SESSION['memberregisterpuja'] = $confirmdata;
                                try { $pujareg = $itemspujasponsorModel->registersankalpapujacheck($memberid); } catch (Throwable $e) { $this->logPujaCartError('registersankalpapujacheck ERROR|'.$e->getMessage()); $pujareg = []; }
                                $_SESSION['pujareg'] = $pujareg;
                                try { $sponsoreventfirst = $itemspujasponsorModel->sponsorevent1check($memberid); } catch (Throwable $e) { $this->logPujaCartError('sponsorevent1check ERROR|'.$e->getMessage()); $sponsoreventfirst = []; }
                                $_SESSION['sponsoreventfirst'] = $sponsoreventfirst;
                                try { $sponsoreventsecond = $itemspujasponsorModel->sponsorevent2check($memberid); } catch (Throwable $e) { $this->logPujaCartError('sponsorevent2check ERROR|'.$e->getMessage()); $sponsoreventsecond = []; }
                                $_SESSION['sponsoreventsecond'] = $sponsoreventsecond;

                                try { $pujasankalpaattempt1arr = $itemspujasponsorModel->pujasankalpaattempt1($memberid); } catch (Throwable $e) { $this->logPujaCartError('pujasankalpaattempt1 ERROR|'.$e->getMessage()); $pujasankalpaattempt1arr = []; }
                                $_SESSION['pujasankalpaattempt1arr'] = $pujasankalpaattempt1arr;

                                try { $pujasankalpaattempt2arr = $itemspujasponsorModel->pujasankalpaattempt2($memberid); } catch (Throwable $e) { $this->logPujaCartError('pujasankalpaattempt2 ERROR|'.$e->getMessage()); $pujasankalpaattempt2arr = []; }
                                $_SESSION['pujasankalpaattempt2arr'] = $pujasankalpaattempt2arr;

                                try { $CategoryAarr = $sponsoritemModel->sponsorCategoryA(); } catch (Throwable $e) { $this->logPujaCartError('sponsorCategoryA ERROR|'.$e->getMessage()); $CategoryAarr = []; }
                                $_SESSION['CategoryAarr'] = $CategoryAarr;

                                try { $CategoryBarr = $sponsoritemModel->sponsorCategoryB(); } catch (Throwable $e) { $this->logPujaCartError('sponsorCategoryB ERROR|'.$e->getMessage()); $CategoryBarr = []; }
                                $_SESSION['CategoryBarr'] = $CategoryBarr;
                                $previousytd = is_numeric($_POST['YTD'] ?? '') ? (float)$_POST['YTD'] : 0;
                                $amountytd = is_numeric($_POST['donation'] ?? '') ? (float)$_POST['donation'] : 0;
                                $newytd = $previousytd + $amountytd;
                                $_SESSION['ytdvalue'] = $newytd;
                                // $_SESSION['paid_parking_amount'] = $_POST["paid_parking_amount"] ?? '';

                            }
                            if (($_POST["adultCouponQty"] ?? '') > 0) {
                                $_SESSION['adultCoupon'] = $_POST["adultCouponQty"] ?? '';
                               
                                
                            }

                            if (($_POST["childCouponQty"] ?? '') > 0) {
                                $_SESSION['childCoupon'] = $_POST["childCouponQty"] ?? '';
                               
                                
                            }
                            if (($_POST["childCouponQty"] ?? '') > 0 || ($_POST["adultCouponQty"] ?? '') > 0) {
                                $_SESSION['totalCouponPrice'] = $_POST["totalCouponPrice"] ?? '';    
                            }

                            $_SESSION['myValue'] = $this->tpl['arr'];
                            $_SESSION['pujakart_payment_processed'] = true;
                            Util::redirect(INSTALL_URL . "PujaCart/show/" . $id);
                        } else {

                            $opts = array();
                            $opts['id'] = $id;
                            $opts['stripe_return'] = $payment->status;
                            $opts['transaction_id'] = $payment->id;
                            $opts['paid_amount'] = $payment->amount;
                            $opts['stripe_product'] = $payment->description;

                            try { $pujaregistrationModel->update($opts); } catch (Throwable $e) { $this->logPujaCartError('stripe declined update ERROR | ' . $e->getMessage()); }

                            $_SESSION['status'] = '<strong>' . __('declined_card') . '</strong>';
                        }
                    } catch (Throwable $ex) {
                        $this->logPujaCartError('stripe payment ERROR | ' . $ex->getMessage());
                        $_SESSION['status'] = $ex->getMessage();
                    }

                    $this->tpl['arr'] = $pujaregistrationModel->get($id);
                    $this->tpl['arr']['amount'] = $total;
                } else {
                    $_SESSION['status'] = 16;

                }
            } else {
                $_SESSION['status'] = 17;
            }

            if (!empty($id)) {
                if (session_status() === PHP_SESSION_NONE) { session_start(); }
                $this->tpl['arr'] = $pujaregistrationModel->get($id);
                $_SESSION['myValue'] = $this->tpl['arr'];
                Util::redirect(INSTALL_URL . "PujaCart/show/" . $id);
            }
            exit();
        }

    }


    function show()
    {
        $this->layout = 'login';
       //echo 'hello';
       GzObject::loadFiles('Model', array('pujaregistration', 'Donation', 'ConfirmCode', 'Member', 'idnumbers', 'pujaytdtier'));
        $pujaregistrationModel = new pujaregistrationModel();
        $PujaYtdTierModel = new pujaytdtierModel();
        try {
            $host = strtolower((string) ($_SERVER['HTTP_HOST'] ?? ''));
            $isLocalHost = $host === '' || strpos($host, 'localhost') !== false || strpos($host, '127.0.0.1') !== false;
            if ($isLocalHost) {
                $PujaYtdTierModel->ensureTable();
                $PujaYtdTierModel->seedDefaults(date('Y'));
            }
            $this->tpl['puja_ytd_tiers'] = $PujaYtdTierModel->getActiveTiers(date('Y'));
        } catch (Throwable $ex) {
            $this->tpl['puja_ytd_tiers'] = array();
        }
        if (!empty($_SESSION['myValue']) && is_array($_SESSION['myValue'])) {
            $_SESSION['myValue'] = $this->hydrateAdultMembersFromRegistrationRow($_SESSION['myValue']);
        }
        if (!empty($_SESSION['puja_cart_last_post']) && is_array($_SESSION['puja_cart_last_post']) && !empty($_SESSION['myValue']) && is_array($_SESSION['myValue'])) {
            $_SESSION['myValue'] = array_merge($_SESSION['myValue'], $_SESSION['puja_cart_last_post']);
            $_SESSION['myValue'] = $this->hydrateAdultMembersFromRegistrationRow($_SESSION['myValue']);
        }
    }


}

?>
