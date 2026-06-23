<?php

require_once FRAMEWORK_PATH . 'Controller.class.php';
require __DIR__ . '/Twillio/vendor/autoload.php';
use Twilio\Rest\Client;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception as phpmailerException;

class App extends Controller
{

    var $models = array();

    function __construct()
    {


        GzObject::loadFiles('Model', array('Languages', 'Local'));

        $LanguagesModel = new LanguagesModel();

        $LocalModel = new LocalModel();



        $this->tpl['languages'] = $LanguagesModel->getAll(null, 'order');



        foreach ($this->tpl['languages'] as $k => $v) {

            $this->tpl['local'][$v['id']] = $LocalModel->getAll(array('language_id' => $v['id']));
        }



        $default_language = $LanguagesModel->getAll(array('isdefault' => 1), 'order');

        $select_language = $this->getLanguage();



        $language = !empty($select_language['id'])
            ? $LanguagesModel->getAll(array('id' => $select_language['id']), 'order')
            : [];



        if (empty($language)) {

            $this->setLanguage($default_language[0]);
        }



        $this->tpl['default_language'] = $default_language[0];



        GzObject::loadFiles('Model', 'Option');

        $OptionModel = new OptionModel();



        $this->tpl['option_arr_values'] = $OptionModel->getAllPairValues();

        date_default_timezone_set($this->tpl['option_arr_values']['timezone'] ?: 'UTC');
    }

    protected function extractAdultMemberRowsFromPost(array $post, $limit = 3)
    {
        $payloadSource = trim((string) ($post['adult_members_payload'] ?? ''));
        if ($payloadSource === '') {
            $candidate = trim((string) ($post['adult1_fname'] ?? ''));
            if ($candidate !== '' && ($candidate[0] === '{' || $candidate[0] === '[')) {
                $payloadSource = $candidate;
            }
        }
        if ($payloadSource !== '') {
            $decodedPayload = json_decode($payloadSource, true);
            if (is_array($decodedPayload)) {
                $rowsPayload = $decodedPayload;
                if (isset($decodedPayload['members']) && is_array($decodedPayload['members'])) {
                    $rowsPayload = $decodedPayload['members'];
                }

                $rows = array();
                foreach ($rowsPayload as $entry) {
                    if (!is_array($entry)) {
                        continue;
                    }
                    $rows[] = array(
                        'first_name' => trim((string) ($entry['first_name'] ?? '')),
                        'last_name' => trim((string) ($entry['last_name'] ?? '')),
                        'birth_year' => isset($entry['birth_year']) && is_numeric($entry['birth_year']) ? (int) $entry['birth_year'] : '',
                        'veggie' => !empty($entry['veggie']) ? 1 : 0
                    );
                }

                return array_slice($rows, 0, 3);
            }
        }

        $rows = array();
        $limit = max(0, min((int) $limit, 3));
        for ($i = 1; $i <= $limit; $i++) {
            $firstName = trim((string) ($post['adult' . $i . '_fname'] ?? ''));
            $lastName = trim((string) ($post['adult' . $i . '_lname'] ?? ''));
            $birthYearRaw = $post['adult' . $i . '_birth_year'] ?? '';
            $birthYear = is_numeric($birthYearRaw) ? (int) $birthYearRaw : '';
            $veggieRaw = $post['adult' . $i . '_veggie'] ?? 0;
            $veggie = is_numeric($veggieRaw) ? (int) $veggieRaw : (!empty($veggieRaw) ? 1 : 0);

            if ($firstName === '' && $lastName === '' && $birthYear === '' && $veggie === 0) {
                continue;
            }

            $rows[] = array(
                'first_name' => $firstName,
                'last_name' => $lastName,
                'birth_year' => $birthYear,
                'veggie' => $veggie ? 1 : 0
            );
        }

        return $rows;
    }

    protected function clearAdultMemberStorageFields(&$post)
    {
        $post['co_register_adult_members'] = 0;
        $post['adult_member_count'] = '';
        $post['adult1_fname'] = '';
        $post['adult1_lname'] = '';
        $post['adult1_birth_year'] = '';
        $post['adult1_veggie'] = 0;
        $post['adult2_fname'] = '';
        $post['adult2_lname'] = '';
        $post['adult2_birth_year'] = '';
        $post['adult2_veggie'] = 0;
        $post['adult3_fname'] = '';
        $post['adult3_lname'] = '';
        $post['adult3_birth_year'] = '';
        $post['adult3_veggie'] = 0;
    }

    protected function storeAdultMembersInRegistrationPost(&$post, array $rows, $count = null, $amount = '')
    {
        $normalizedRows = array_values(array_slice($rows, 0, 3));
        if (empty($normalizedRows)) {
            $this->clearAdultMemberStorageFields($post);
            return;
        }

        $memberCount = $count === null ? count($normalizedRows) : max(0, min((int) $count, count($normalizedRows), 3));
        if ($memberCount <= 0) {
            $this->clearAdultMemberStorageFields($post);
            return;
        }

        $payload = array_slice($normalizedRows, 0, $memberCount);
        $payloadAmount = is_numeric($amount) ? (string) $amount : '';
        $post['co_register_adult_members'] = 1;
        $post['adult_member_count'] = (string) $memberCount;
        $post['adult1_fname'] = json_encode(array(
            'members' => $payload,
            'amount' => $payloadAmount
        ));
        $post['adult1_lname'] = '';
        $post['adult1_birth_year'] = '';
        $post['adult1_veggie'] = 0;
        $post['adult2_fname'] = '';
        $post['adult2_lname'] = '';
        $post['adult2_birth_year'] = '';
        $post['adult2_veggie'] = 0;
        $post['adult3_fname'] = '';
        $post['adult3_lname'] = '';
        $post['adult3_birth_year'] = '';
        $post['adult3_veggie'] = 0;
    }

    protected function hydrateAdultMembersFromRegistrationRow(array $row)
    {
        $payload = trim((string) ($row['adult1_fname'] ?? ''));
        if ($payload === '') {
            return $row;
        }

        $decoded = json_decode($payload, true);
        if (!is_array($decoded)) {
            return $row;
        }

        $rowsPayload = $decoded;
        $adultAmount = '';
        if (isset($decoded['members']) && is_array($decoded['members'])) {
            $rowsPayload = $decoded['members'];
            $adultAmount = isset($decoded['amount']) && is_numeric($decoded['amount']) ? (string) $decoded['amount'] : '';
        }

        $rows = array();
        foreach ($rowsPayload as $entry) {
            if (!is_array($entry)) {
                continue;
            }
            $rows[] = array(
                'first_name' => trim((string) ($entry['first_name'] ?? '')),
                'last_name' => trim((string) ($entry['last_name'] ?? '')),
                'birth_year' => isset($entry['birth_year']) && is_numeric($entry['birth_year']) ? (int) $entry['birth_year'] : '',
                'veggie' => !empty($entry['veggie']) ? 1 : 0
            );
        }

        if (empty($rows)) {
            return $row;
        }

        for ($i = 1; $i <= 3; $i++) {
            $member = $rows[$i - 1] ?? array();
            $row['adult' . $i . '_fname'] = $member['first_name'] ?? '';
            $row['adult' . $i . '_lname'] = $member['last_name'] ?? '';
            $row['adult' . $i . '_birth_year'] = $member['birth_year'] ?? '';
            $row['adult' . $i . '_veggie'] = $member['veggie'] ?? 0;
        }

        $row['adult_members_payload'] = $rows;
        if (empty($row['adult_member_count'])) {
            $row['adult_member_count'] = (string) count($rows);
        }
        if ($adultAmount !== '') {
            $row['extraadultregistration'] = $adultAmount;
        }

        return $row;
    }

    function isUser()
    {

        return $this->getRoleId() == 2;
    }

    function calclateBookingPrice($params, $session = array())
    {

        if (empty($session)) {

            $session = $_SESSION[$this->default_product]['slots'][$params['calendar_id']];
        }

        GzObject::loadFiles('Model', array('TimePrice', 'Calendar', 'Option', 'CustomPrice', 'Discount', 'CustomDate'));

        $TimePriceModel = new TimePriceModel();

        $OptionModel = new OptionModel();

        $CustomDateModel = new CustomDateModel();

        $CustomPriceModel = new CustomPriceModel();

        $DiscountModel = new DiscountModel();



        $option_arr = $OptionModel->getAllPairValues(array('calendar_id' => $params['calendar_id']));



        $result = array('calendars_price' => 0, 'discount' => 0, 'total' => 0, 'tax' => 0, 'security' => 0, 'deposit' => 0, 'formated_calendars_price' => Util::currenctFormat($option_arr['currency'], 0), 'formated_discount' => Util::currenctFormat($option_arr['currency'], 0), 'formated_total' => Util::currenctFormat($option_arr['currency'], 0), 'formated_tax' => Util::currenctFormat($option_arr['currency'], 0), 'formated_security' => Util::currenctFormat($option_arr['currency'], 0), 'formated_deposit' => Util::currenctFormat($option_arr['currency'], 0));

        if (empty($params['calendar_id'])) {

            return $result;
        }



        $opts = array();

        $opts['calendar_id'] = $params['calendar_id'];

        $custom_dates = $CustomDateModel->getAll($opts);



        if (!empty($custom_dates)) {

            foreach ($custom_dates as $k => $v) {

                for ($i = $v['timestamp']; $i <= $v['timestamp_end']; $i += 86400) {

                    $custom_dates[mktime(0, 0, 0, date('n', $i), date('d', $i), date('Y', $i))] = $v;
                }
            }
        }



        $opts = array();

        $opts['calendar_id'] = $params['calendar_id'];

        $custom_prices_arr = $CustomPriceModel->getAll($opts);



        $custom_prices = array();

        if (!empty($custom_prices_arr)) {

            foreach ($custom_prices_arr as $key => $value) {

                $custom_prices[$value['day']][date('h:i', $value['start_timestamp'])] = $value;
            }
        }



        $opts = array();

        $opts['id'] = $params['calendar_id'];



        $id = $params['calendar_id'];



        //search for price that match with adults and children 

        $arr = $TimePriceModel->getPrices($params, $id);



        if (empty($arr) || count($arr) == 0) {

            //search for default price if not price that match with adults and children 



            $arr = $TimePriceModel->getDefaultPrices($id);
        }



        $price = 0;



        foreach ($session as $i => $count) {

            if ($count > 0) {

                $date = strtotime(date("Y-m-d", $i));



                if (!empty($custom_dates[$date])) {

                    $price += $custom_dates[$date]['price'] * $count;
                } else {



                    switch (date('N', $i)) {

                        case 1:

                            if (!empty($custom_prices[1][date('h:i', $i)])) {

                                $price += $custom_prices[1][date('h:i', $i)]['price'];
                            } else {

                                $price += $arr['monday_price'] * $count;
                            }

                            break;

                        case 2:

                            if (!empty($custom_prices[2][date('h:i', $i)])) {

                                $price += $custom_prices[2][date('h:i', $i)]['price'];
                            } else {

                                $price += $arr['tuesday_price'] * $count;
                            }

                            break;

                        case 3:

                            if (!empty($custom_prices[3][date('h:i', $i)])) {

                                $price += $custom_prices[3][date('h:i', $i)]['price'];
                            } else {

                                $price += $arr['wednesday_price'] * $count;
                            }

                            break;

                        case 4:

                            if (!empty($custom_prices[4][date('h:i', $i)])) {

                                $price += $custom_prices[4][date('h:i', $i)]['price'];
                            } else {

                                $price += $arr['thursday_price'] * $count;
                            }

                            break;

                        case 5:

                            if (!empty($custom_prices[5][date('h:i', $i)])) {

                                $price += $custom_prices[5][date('h:i', $i)]['price'];
                            } else {

                                $price += $arr['friday_price'] * $count;
                            }

                            break;

                        case 6:

                            if (!empty($custom_prices[6][date('h:i', $i)])) {

                                $price += $custom_prices[6][date('h:i', $i)]['price'];
                            } else {

                                $price += $arr['saturday_price'] * $count;
                            }

                            break;

                        case 7:

                            if (!empty($custom_prices[7][date('h:i', $i)])) {

                                $price += $custom_prices[7][date('h:i', $i)]['price'];
                            } else {

                                $price += $arr['sunday_price'] * $count;
                            }

                            break;
                    }
                }
            }
        }



        if (empty($price) && (!empty($_POST['Puja']) || !empty($_POST['Puja2']))) {



            $slot_price = 0;



            if (($_POST['location'] ?? '') == 'inside' || ($_POST['location'] ?? '') == "online") {

                $_POST['Puja'] = floatval($_POST['Puja'] ?? '');

                $slot_price = $_POST['Puja'] ?? '';
            } else {

                $_POST['Puja2'] = floatval($_POST['Puja2'] ?? '');

                $slot_price = $_POST['Puja2'] ?? '';
            }



            foreach ($session as $i => $count) {

                if ($count > 0) {

                    $price += $slot_price * $count;
                }
            }
        }





        $result['calendars_price'] = $price;

        $result['total'] = $price;



        if (!empty($params['promo_code'])) {

            $opts = array();

            $opts['t1.promo_code'] = $params['promo_code'];

            $opts['t1.calendar_id'] = $params['calendar_id'];



            $discount_arr = $DiscountModel->getAll($opts);
        }



        if (!empty($discount_arr) && count($discount_arr) > 0) {



            $discount = $discount_arr[0];



            switch ($discount['type']) {

                case 'price':

                    $result['discount'] = $discount['discount'];



                    break;

                case 'percent':

                    $result['discount'] = $result['total'] * $discount['discount'] / 100;

                    break;
            }



            if ($result['total'] > $result['discount']) {

                $result['total'] -= $result['discount'];
            } else {

                $result['discount'] = 0;
            }
        }



        if (!empty($option_arr['tax'])) {

            switch ($option_arr['tax_type']) {

                case 'price':

                    $result['tax'] = $option_arr['tax'];

                    $result['total'] = $result['total'] + $result['tax'];

                    break;

                case 'percent':

                    $result['tax'] = ($result['total'] * $option_arr['tax']) / 100;

                    $result['total'] = $result['total'] + $result['tax'];

                    break;
            }
        }



        if (!empty($option_arr['deposit'])) {

            switch ($option_arr['deposit_type']) {

                case 'price':

                    $result['deposit'] = $option_arr['deposit'];

                    break;

                case 'percent':

                    $result['deposit'] = ($result['total'] * $option_arr['deposit']) / 100;

                    break;
            }
        }



        if (empty($result['calendars_price']) && !empty($_POST['calendars_price']) && ($_POST['create_booking'] ?? '' || $_POST['edit_booking'] ?? '')) {

            $result['calendars_price'] = $_POST['calendars_price'] ?? '';

            $result['total'] = $result['calendars_price'];
        }



        $result['formated_discount'] = Util::currenctFormat($option_arr['currency'], $result['discount']);

        $result['formated_deposit'] = Util::currenctFormat($option_arr['currency'], $result['deposit']);

        $result['formated_total'] = Util::currenctFormat($option_arr['currency'], $result['total']);

        $result['formated_calendars_price'] = Util::currenctFormat($option_arr['currency'], $result['calendars_price']);

        $result['formated_tax'] = Util::currenctFormat($option_arr['currency'], $result['tax']);



        return $result;
    }

    function sendMemberEmails($id, $type, $group)
    {

        GzObject::loadFiles('Model', array('Option', 'Member'));
        $OptionModel = new OptionModel();
        $MemberModel = new MemberModel();

        $member = $MemberModel->get($id);

        $opts = array();
        $option_arr = $OptionModel->getAllPairValues($opts);

        $replacement = array();
        $replacement['ID'] = $member['ID'];
        $replacement['information'] = $member['information'];
        $replacement['GovtissueID'] = $member['GovtissueID'];
        $replacement['membership_type'] = $member['membership_type'];
        $replacement['Member_id'] = $member['Member_id'];
        $replacement['Category'] = $member['Category'];
        $replacement['F_Name'] = $member['F_Name'];
        $replacement['L_Name'] = $member['L_Name'];
        $replacement['Mob_No'] = $member['Mob_No'];
        $replacement['Sp_FName'] = $member['Sp_FName'];
        $replacement['Address1'] = $member['Address1'];
        $replacement['Address2'] = $member['Address2'];
        $replacement['Address3'] = $member['Address3'];
        $replacement['City'] = $member['City'];
        $replacement['State'] = $member['State'];
        $replacement['Country'] = $member['Country'];
        $replacement['Zip'] = $member['Zip'];
        $replacement['email'] = $member['email'];
        $replacement['Email2'] = $member['Email2'];
        $replacement['Tele1'] = $member['Tele1'];
        $replacement['Tele2'] = $member['Tele2'];
        $replacement['Child1'] = $member['Child1'];
        $replacement['Age1'] = $member['Age1'];
        $replacement['Child2'] = $member['Child2'];
        $replacement['Age2'] = $member['Age2'];
        $replacement['Child3'] = $member['Child3'];
        $replacement['Age3'] = $member['Age3'];
        $replacement['Parent1'] = $member['Parent1'];
        $replacement['Parent2'] = $member['Parent2'];
        $replacement['remarks'] = $member['remarks'];
        $replacement['swap'] = $member['swap'];
        $replacement['FirstSal'] = $member['FirstSal'];

        $payment_method = __('payment_method_arr');
        $replacement['Payment_method'] = $payment_method[$member['Payment_method']];

        $replacement['SpouseSal'] = $member['SpouseSal'];
        $replacement['CreatedOn'] = $member['CreatedOn'];
        $replacement['password'] = $_POST['password'] ?? '';
        $replacement['type'] = $member['type'];

        $user_status_arr = __('user_status_arr');
        $replacement['status'] = $user_status_arr[$member['status']];

        switch ($type) {
            case 'create':
                switch ($group) {
                    case 'member':
                        $message = Util::replaceMemberToken($option_arr['admin_new_member_body'], $replacement);
                        $subjetc = $option_arr['admin_new_member_subject'];
                        $to = $member['email'];
                        break;
                    case 'admin':
                        $message = Util::replaceMemberToken($option_arr['admin_new_member_body'], $replacement);
                        $subjetc = $option_arr['admin_new_member_subject'];
                        $to = $option_arr['notify_email'];
                        break;
                }
                break;
            case 'active':
                switch ($group) {
                    case 'member':
                        $message = Util::replaceMemberToken($option_arr['active_member_body'], $replacement);
                        $subjetc = $option_arr['active_member_subject'];
                        $to = $member['email'];
                        break;
                    case 'admin':
                        $message = Util::replaceMemberToken($option_arr['active_member_body'], $replacement);
                        $subjetc = $option_arr['active_member_subject'];
                        $to = $option_arr['notify_email'];
                        break;
                }
                break;
        }

        try {
            $mail = new PHPMailer(true); //New instance, with exceptions enabled
            //$mail->IsSendmail();  // tell the class to use Sendmail
            $mail->AddReplyTo($option_arr['notify_email'], "Admin");
            $mail->From = $option_arr['notify_email'];
            $mail->FromName = $option_arr['notify_email'];
            $mail->CharSet = 'UTF-8';
            $mail->AddAddress($to);
            $mail->Subject = $subjetc;
            $mail->AltBody = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
            $mail->WordWrap = 80; // set word wrap
            $mail->MsgHTML($message);

            $mail->IsHTML(true); // send as HTML
            gz_send_mail($mail);
        } catch (\Exception $e) {
            error_log('[App.php] Mail failed: ' . $e->getMessage());
        }
    }

    function sendBookingEmailsNew($id, $type, $group, $name, $email, $mobileno, $Date, $stime, $etime, $puja, $loc, $msg)
    {

        GzObject::loadFiles('Model', array('Option', 'Booking', 'Invoice'));
        $OptionModel = new OptionModel();
        $BookingModel = new BookingModel();
        $InvoiceModel = new InvoiceModel();

        $booking_details = $BookingModel->getBookingDetails($id);

        $opts = array();
        $opts['calendar_id'] = $booking_details['calendar_id'];
        $option_arr = $OptionModel->getAllPairValues($opts);

        $opts = array();
        $opts['booking_id'] = $id;
        //$opts['booking_id'] = $booking_details['booking_number'];;
        $invoice = $InvoiceModel->getAll($opts, 'id');

        $replacement = array();
        $replacement['id'] = $booking_details['id'];
        //$replacement['id'] = $booking_details['booking_number'];
        $replacement['location'] = $booking_details['location'];
        //$replacement['title'] = $booking_details['title'];
        $replacement['first_name'] = $booking_details['first_name'];
        $replacement['second_name'] = $booking_details['second_name'];
        $replacement['phone'] = $booking_details['phone'];
        $replacement['email'] = $booking_details['email'];
        // $replacement['company'] = $booking_details['company'];
        $replacement['company'] = $booking_details['transaction_id'];
        $replacement['address_1'] = $booking_details['address_1'];
        $replacement['address_2'] = $booking_details['address_2'];
        $replacement['city'] = $booking_details['city'];
        $replacement['state'] = $booking_details['state'];
        $replacement['zip'] = $booking_details['zip'];
        $replacement['country'] = $booking_details['country'];
        $replacement['fax'] = $booking_details['fax'];
        $replacement['male'] = $booking_details['male'];
        $replacement['additional'] = $booking_details['additional'];
        $replacement['nights'] = $booking_details['nights'];
        $replacement['date_from'] = $booking_details['date_from'];
        $replacement['date_to'] = $booking_details['date_to'];
        $replacement['calendars'] = $booking_details['calendar'];
        $replacement['cc_type'] = $booking_details['cc_type'];
        $replacement['cc_num'] = $booking_details['cc_num'];
        $replacement['cc_code'] = $booking_details['cc_code'];
        $replacement['cc_exp_month'] = $booking_details['cc_exp_month'];
        $replacement['cc_exp_year'] = $booking_details['cc_exp_year'];

        $payment_method = __('payment_method_arr');
        $replacement['payment_method'] = $payment_method[$booking_details['payment_method']];

        $replacement['deposit'] = $booking_details['deposit'];
        $replacement['tax'] = $booking_details['booking_number'];
        $replacement['total'] = $booking_details['total'];
        $replacement['calendars_price'] = $booking_details['calendars_price'];
        $replacement['extra_price'] = $booking_details['extra_price'];
        $replacement['discount'] = $booking_details['discount'];
        $location_arr = __('location_arr');
        $replacement['title'] = $booking_details['promo_code'];
        $replacement['location'] = $location_arr[$booking_details['location']];
        $replacement['transaction_id'] = $booking_details['transaction_id'];
        $replacement['slots'] = implode(', ', $booking_details['slots']);
        $replacement['create_date'] = date($this->tpl['option_arr_values']['date_format'], $booking_details['date']);

        switch ($type) {
            case 'create':
                switch ($group) {
                    case 'client':
                        $message = Util::replaceToken($option_arr['client_create_email_booking'], $replacement);
                        $subjetc = $option_arr['client_create_subject_booking'];
                        $to = $booking_details['email'];
                        break;
                    case 'admin':
                        $message = Util::replaceToken($option_arr['admin_create_email_booking'], $replacement);
                        $subjetc = $option_arr['admin_create_subject_booking'];
                        //$to = $option_arr['notify_email']." , "; $to .= 'paras.kaka2@gmail.com';
                        $to = $option_arr['notify_email'];
                        break;
                }
                break;
            case 'confirmation':
                switch ($group) {
                    case 'client':
                        $message = Util::replaceToken($option_arr['client_confirmation_email_booking'], $replacement);
                        $subjetc = $option_arr['client_confirmation_subject_booking'];
                        $to = $booking_details['email'];
                        break;
                    case 'admin':
                        $message = Util::replaceToken($option_arr['admin_confirmation_email_booking'], $replacement);
                        $subjetc = $option_arr['admin_confirmation_subject_booking'];
                        //$to = $option_arr['notify_email']." , "; $to .= 'paras.kaka2@gmail.com';
                        $to = $option_arr['notify_email'];
                        break;
                    case 'priest':
                        $message = Util::replaceToken($option_arr['admin_confirmation_email_booking'], $replacement);
                        $subjetc = $option_arr['admin_confirmation_subject_booking'];
                        $to = 'priest@durgabari.org';
                        //$to = $option_arr['notify_email'];
                        break;
                }
                break;
            case 'cancellation':
                switch ($group) {
                    case 'client':
                        $message = Util::replaceToken($option_arr['client_cancellation_email_booking'], $replacement);
                        $subjetc = $option_arr['client_cancellation_subject_booking'];
                        $to = $booking_details['email'];
                        break;
                    case 'admin':
                        $message = Util::replaceToken($option_arr['admin_cancellation_email_booking'], $replacement);
                        $subjetc = $option_arr['admin_cancellation_subject_booking'];
                        //$to = $option_arr['notify_email']." , "; $to .= 'paras.kaka2@gmail.com';
                        $to = $option_arr['notify_email'];
                        break;
                }
                break;
        }
        try {



            // event params
            $from_name = "HDBS Durgabari";
            $from_address = "hdbs.payment@durgabari.org";
            $to_name = $name;
            $to_address = $email;
            //$to_address = "avinash.verma@eiceinternational.com ";
            $startTime = $Date . $stime;
            $endTime = $Date . $etime;
            $subject = $puja;
            $description = $msg;
            $location = $loc;
            $domain = INSTALL_URL . 'Preview/index';
            $mail = new PHPMailer(true); //New instance, with exceptions enabled
            //$mail->isSMTP();
            //$mail->SMTPDebug = 0;  // tell the class to use Sendmail
            $mail->AddReplyTo($option_arr['notify_email'], "Admin");
            $mail->From = $option_arr['notify_email'];
            $mail->FromName = $option_arr['notify_email'];

            //$mail->ContentType = 'text/calendar';

            //$mail->addCustomHeader('MIME-version',"1.0");
            //$mail->addCustomHeader('Content-type',"text/calendar; name=event.ics; method=REQUEST; charset=UTF-8;");
            //$mail->addCustomHeader('Content-type',"text/html; charset=UTF-8");
            //$mail->addCustomHeader('Content-Transfer-Encoding',"7bit");
            //$mail->addCustomHeader('X-Mailer',"Microsoft Office Outlook 12.0");
            //$mail->addCustomHeader("Content-class: urn:content-classes:calendarmessage");


            //Event setting
            $ical = 'BEGIN:VCALENDAR' . "\r\n" .
                'PRODID:-//Microsoft Corporation//Outlook 10.0 MIMEDIR//EN' . "\r\n" .
                'VERSION:2.0' . "\r\n" .
                'METHOD:REQUEST' . "\r\n" .
                'BEGIN:VTIMEZONE' . "\r\n" .
                'TZID:Eastern Time' . "\r\n" .
                'BEGIN:STANDARD' . "\r\n" .
                'DTSTART:20091101T020000' . "\r\n" .
                'RRULE:FREQ=YEARLY;INTERVAL=1;BYDAY=1SU;BYMONTH=11' . "\r\n" .
                'TZOFFSETFROM:-0400' . "\r\n" .
                'TZOFFSETTO:-0500' . "\r\n" .
                'TZNAME:EST' . "\r\n" .
                'END:STANDARD' . "\r\n" .
                'BEGIN:DAYLIGHT' . "\r\n" .
                'DTSTART:20090301T020000' . "\r\n" .
                'RRULE:FREQ=YEARLY;INTERVAL=1;BYDAY=2SU;BYMONTH=3' . "\r\n" .
                'TZOFFSETFROM:-0500' . "\r\n" .
                'TZOFFSETTO:-0400' . "\r\n" .
                'TZNAME:EDST' . "\r\n" .
                'END:DAYLIGHT' . "\r\n" .
                'END:VTIMEZONE' . "\r\n" .
                'BEGIN:VEVENT' . "\r\n" .
                'ORGANIZER;CN="' . $from_name . '":MAILTO:' . $from_address . "\r\n" .
                'ATTENDEE;CN="' . $to_name . '";ROLE=REQ-PARTICIPANT;RSVP=TRUE:MAILTO:' . $to_address . "\r\n" .
                'LAST-MODIFIED:' . date("Ymd\TGis") . "\r\n" .
                'UID:' . date("Ymd\TGis", strtotime($startTime)) . rand() . "@" . $domain . "\r\n" .
                'DTSTAMP:' . date("Ymd\TGis") . "\r\n" .
                'DTSTART;TZID="Pacific Daylight":' . date("Ymd\THis", strtotime($startTime)) . "\r\n" .
                'DTEND;TZID="Pacific Daylight":' . date("Ymd\THis", strtotime($endTime)) . "\r\n" .
                'TRANSP:OPAQUE' . "\r\n" .
                'SEQUENCE:1' . "\r\n" .
                'SUMMARY:' . $subject . "\r\n" .
                'LOCATION:' . $location . "\r\n" .
                'CLASS:PUBLIC' . "\r\n" .
                'PRIORITY:5' . "\r\n" .
                'BEGIN:VALARM' . "\r\n" .
                'TRIGGER:-PT15M' . "\r\n" .
                'ACTION:DISPLAY' . "\r\n" .
                'DESCRIPTION:Reminder' . "\r\n" .
                'END:VALARM' . "\r\n" .
                'END:VEVENT' . "\r\n" .
                'END:VCALENDAR' . "\r\n";
            // $message1 .= 'Content-Type: text/calendar;name="meeting.ics";method=REQUEST'."\n";
            // $message1 .= "Content-Transfer-Encoding: 8bit\n\n";
            // $message1 .= $ical;

            $mail->CharSet = 'UTF-8';
            $mail->AddAddress($to);
            $mail->Subject = $subjetc;
            $mail->AddStringAttachment($ical, "meeting.ics", "7bit", "text/calendar; charset=utf-8; method=REQUEST");
            $mail->AltBody = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
            $mail->Ical = $ical;
            $mail->WordWrap = 80; // set word wrap
            $mail->MsgHTML($message);
            //$mail->Body = $ical;
            if (!empty($invoice)) {
                $invoice_id = $invoice[0]['id'];
                if (is_file(INSTALL_PATH . UPLOAD_PATH . 'invoice/' . 'booking_' . $id . '_invoice_' . $invoice_id . '.pdf')) {
                    $mail->AddAttachment(INSTALL_PATH . UPLOAD_PATH . 'invoice/' . 'booking_' . $id . '_invoice_' . $invoice_id . '.pdf');
                    //$mail->addAttachment('meeting.ics');   // attachment
                }
            }

            $mail->IsHTML(true); // send as HTML
            gz_send_mail($mail);
        } catch (\Exception $e) {
            error_log('[App.php] Mail failed: ' . $e->getMessage());
        }
        return $invoice_id;
        // try {
        //     $mail = new PHPMailer(true); //New instance, with exceptions enabled
        //     //$mail->IsSendmail();  // tell the class to use Sendmail
        //     $mail->AddReplyTo($option_arr['notify_email'], "Admin");
        //     $mail->From = $option_arr['notify_email'];
        //     $mail->FromName = $option_arr['notify_email'];
        //     $mail->CharSet = 'UTF-8';
        //     $mail->AddAddress($to);
        //     $mail->Subject = $subjetc;
        //     $mail->AltBody = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
        //     $mail->WordWrap = 80; // set word wrap
        //     $mail->MsgHTML($message);

        //     if (!empty($invoice)) {
        //         $invoice_id = $invoice[0]['id'];
        //         if (is_file(INSTALL_PATH . UPLOAD_PATH . 'invoice/' . 'booking_' . $id . '_invoice_' . $invoice_id . '.pdf')) {
        //             $mail->AddAttachment(INSTALL_PATH . UPLOAD_PATH . 'invoice/' . 'booking_' . $id . '_invoice_' . $invoice_id . '.pdf'); // attachment
        //         }
        //     }

        //     $mail->IsHTML(true); // send as HTML

        //     gz_apply_mail_mode($mail);     $mail->Send();
        // } catch (\Exception $e) {
        //     error_log('[App.php] Mail failed: ' . $e->getMessage());
        // }
        //  return $invoice_id;
    }

    function sendBookingEmails($id, $type, $group)
    {

        GzObject::loadFiles('Model', array('Option', 'Booking', 'Invoice'));
        $OptionModel = new OptionModel();
        $BookingModel = new BookingModel();
        $InvoiceModel = new InvoiceModel();

        $booking_details = $BookingModel->getBookingDetails($id);

        $opts = array();
        $opts['calendar_id'] = $booking_details['calendar_id'];
        $option_arr = $OptionModel->getAllPairValues($opts);

        $opts = array();
        $opts['booking_id'] = $id;
        $invoice = $InvoiceModel->getAll($opts, 'id');

        $replacement = array();
        //$replacement['id'] = $booking_details['id'];
        $replacement['id'] = $booking_details['booking_number'];
        $replacement['location'] = $booking_details['location'];
        //$replacement['title'] = $booking_details['title'];
        $replacement['first_name'] = $booking_details['first_name'];
        $replacement['second_name'] = $booking_details['second_name'];
        $replacement['phone'] = $booking_details['phone'];
        $replacement['email'] = $booking_details['email'];
        // $replacement['company'] = $booking_details['company'];
        $replacement['company'] = $booking_details['transaction_id'];
        $replacement['address_1'] = $booking_details['address_1'];
        $replacement['address_2'] = $booking_details['address_2'];
        $replacement['city'] = $booking_details['city'];
        $replacement['state'] = $booking_details['state'];
        $replacement['zip'] = $booking_details['zip'];
        $replacement['country'] = $booking_details['country'];
        $replacement['fax'] = $booking_details['fax'];
        $replacement['male'] = $booking_details['male'];
        $replacement['additional'] = $booking_details['additional'];
        $replacement['nights'] = $booking_details['nights'];
        $replacement['date_from'] = $booking_details['date_from'];
        $replacement['date_to'] = $booking_details['date_to'];
        $replacement['calendars'] = $booking_details['calendar'];
        $replacement['cc_type'] = $booking_details['cc_type'];
        $replacement['cc_num'] = $booking_details['cc_num'];
        $replacement['cc_code'] = $booking_details['cc_code'];
        $replacement['cc_exp_month'] = $booking_details['cc_exp_month'];
        $replacement['cc_exp_year'] = $booking_details['cc_exp_year'];

        $payment_method = __('payment_method_arr');
        $replacement['payment_method'] = $payment_method[$booking_details['payment_method']];

        $replacement['deposit'] = $booking_details['deposit'];
        $replacement['tax'] = $booking_details['tax'];
        $replacement['total'] = $booking_details['total'];
        $replacement['calendars_price'] = $booking_details['calendars_price'];
        $replacement['extra_price'] = $booking_details['extra_price'];
        $replacement['discount'] = $booking_details['discount'];
        $location_arr = __('location_arr');
        $replacement['title'] = $booking_details['promo_code'];
        $replacement['location'] = $location_arr[$booking_details['location']];
        $replacement['transaction_id'] = $booking_details['transaction_id'];
        $replacement['slots'] = implode(', ', $booking_details['slots']);
        $replacement['create_date'] = date($this->tpl['option_arr_values']['date_format'], $booking_details['date']);

        switch ($type) {
            case 'create':
                switch ($group) {
                    case 'client':
                        $message = Util::replaceToken($option_arr['client_create_email_booking'], $replacement);
                        $subjetc = $option_arr['client_create_subject_booking'];
                        $to = $booking_details['email'];
                        break;
                    case 'admin':
                        $message = Util::replaceToken($option_arr['admin_create_email_booking'], $replacement);
                        $subjetc = $option_arr['admin_create_subject_booking'];
                        $to = $option_arr['notify_email'];
                        break;
                }
                break;
            case 'confirmation':
                switch ($group) {
                    case 'client':
                        $message = Util::replaceToken($option_arr['client_confirmation_email_booking'], $replacement);
                        $subjetc = $option_arr['client_confirmation_subject_booking'];

                        $to = $booking_details['email'];
                        break;
                    case 'admin':
                        $message = Util::replaceToken($option_arr['admin_confirmation_email_booking'], $replacement);
                        $subjetc = $option_arr['admin_confirmation_subject_booking'];
                        $to = $option_arr['notify_email'];
                        break;
                }
                break;
            case 'cancellation':
                switch ($group) {
                    case 'client':
                        $message = Util::replaceToken($option_arr['client_cancellation_email_booking'], $replacement);
                        $subjetc = $option_arr['client_cancellation_subject_booking'];
                        $to = $booking_details['email'];
                        break;
                    case 'admin':
                        $message = Util::replaceToken($option_arr['admin_cancellation_email_booking'], $replacement);
                        $subjetc = $option_arr['admin_cancellation_subject_booking'];
                        $to = $option_arr['notify_email'];
                        break;
                }
                break;
        }

        try {
            $mail = new PHPMailer(true); //New instance, with exceptions enabled
            //$mail->IsSendmail();  // tell the class to use Sendmail
            $mail->AddReplyTo($option_arr['notify_email'], "Admin");
            $mail->From = $option_arr['notify_email'];
            $mail->FromName = $option_arr['notify_email'];
            $mail->CharSet = 'UTF-8';
            $mail->AddAddress($to);
            $mail->Subject = $subjetc;
            $mail->AltBody = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
            $mail->WordWrap = 80; // set word wrap
            $mail->MsgHTML($message);

            if (!empty($invoice)) {
                $invoice_id = $invoice[0]['id'];
                if (is_file(INSTALL_PATH . UPLOAD_PATH . 'invoice/' . 'booking_' . $id . '_invoice_' . $invoice_id . '.pdf')) {
                    $mail->AddAttachment(INSTALL_PATH . UPLOAD_PATH . 'invoice/' . 'booking_' . $id . '_invoice_' . $invoice_id . '.pdf'); // attachment
                }
            }

            $mail->IsHTML(true); // send as HTML
            gz_send_mail($mail);
        } catch (\Exception $e) {
            error_log('[App.php] Mail failed: ' . $e->getMessage());
        }
        return $invoice_id;
    }

    function getCSS()
    {
        $this->setIsAjax(true);

        header("Content-type: text/css");



        $css = file_get_contents(INSTALL_PATH . 'application/web/css/front/gzAbCalCalendar.css');



        GzObject::loadFiles('Model', 'Option');

        $OptionModel = new OptionModel();



        $cid = $_GET['cid'] ?? '';

        $opts['calendar_id'] = $cid;

        $option_arr_values = $OptionModel->getAllPairValues($opts);



        $search = array(
            '{bg_past_dates}',
            '{color_past_dates}',
            '{bg_nav_month}',
            '{bg_nav_hover_month}',
            '{color_month}',
            '{bg_month}',
            '{month_size_past}',
            '{font_style_month}',
            '{font_famaly_month}',
            '{border_color}',
            '{border_widht}',
            '{color_legend}',
            '{font_size_legend}',
            '{font_famaly_legend}',
            '{font_style_legend}',
            '{color_week}',
            '{bg_week}',
            '{bg_booked}',
            '{color_booked}',
            '{font_size_booked}',
            '{font_famaly_booked}',
            '{font_style_booked}',
            '{bg_pending}',
            '{color_pending}',
            '{font_size_pending}',
            '{font_famaly_pending}',
            '{font_style_pending}',
            '{font_size_past}',
            '{font_famaly_past}',
            '{font_style_past}',
            '{bg_available}',
            '{color_available}',
            '{font_size_available}',
            '{font_famaly_available}',
            '{font_style_available}',
            '{bg_empty}',
            '{bg_selected}',
            '{color_today}',
            '{font_size_today}',
            '{font_famaly_today}',
            '{font_style_today}',
            '{calendarContainer}',
            '{bg_day_off}',
            '{color_day_off}',
            '{font_size_day_off}',
            '{font_famaly_day_off}',
            '{font_style_day_off}',
        );



        $replace = array(
            $option_arr_values['bg_past_dates'],
            $option_arr_values['color_past_dates'],
            $option_arr_values['bg_nav_month'],
            $option_arr_values['bg_nav_hover_month'],
            $option_arr_values['color_month'],
            $option_arr_values['bg_month'],
            $option_arr_values['month_size_past'],
            $option_arr_values['font_style_month'],
            $option_arr_values['font_famaly_month'],
            $option_arr_values['border_color'],
            $option_arr_values['border_widht'],
            $option_arr_values['color_legend'],
            $option_arr_values['font_size_legend'],
            $option_arr_values['font_famaly_legend'],
            $option_arr_values['font_style_legend'],
            $option_arr_values['color_week'],
            $option_arr_values['bg_week'],
            $option_arr_values['bg_booked'],
            $option_arr_values['color_booked'],
            $option_arr_values['font_size_booked'],
            $option_arr_values['font_famaly_booked'],
            $option_arr_values['font_style_booked'],
            $option_arr_values['bg_pending'],
            $option_arr_values['color_pending'],
            $option_arr_values['font_size_pending'],
            $option_arr_values['font_famaly_pending'],
            $option_arr_values['font_style_pending'],
            $option_arr_values['font_size_past'],
            $option_arr_values['font_famaly_past'],
            $option_arr_values['font_style_past'],
            $option_arr_values['bg_available'],
            $option_arr_values['color_available'],
            $option_arr_values['font_size_available'],
            $option_arr_values['font_famaly_available'],
            $option_arr_values['font_style_available'],
            $option_arr_values['bg_empty'],
            $option_arr_values['bg_selected'],
            $option_arr_values['color_today'],
            $option_arr_values['font_size_today'],
            $option_arr_values['font_famaly_today'],
            $option_arr_values['font_style_today'],
            '#gz-abc-main-container-' . ($_GET['cid'] ?? ''),
            $this->tpl['option_arr_values']['bg_day_off'],
            $this->tpl['option_arr_values']['color_day_off'],
            $this->tpl['option_arr_values']['font_size_day_off'],
            $this->tpl['option_arr_values']['font_famaly_day_off'],
            $this->tpl['option_arr_values']['font_style_day_off']
        );



        echo str_replace($search, $replace, $css);
    }

    function checkAvailability($cal_id)
    {



        GzObject::loadFiles('Model', array('TimePrice', 'Option', 'CustomPrice', 'BookingSlot', 'Booking'));

        $TimePriceModel = new TimePriceModel();

        $OptionModel = new OptionModel();

        $CustomPriceModel = new CustomPriceModel();

        $BookingSlotModel = new BookingSlotModel();

        $BookingModel = new BookingModel();



        $check = true;



        foreach ($_SESSION[$this->default_product]['slots'][$cal_id] as $slot => $ccount) {



            $from = ($slot - 86400);

            $to = ($slot + 86400);



            $before = time() - 5 * 60;



            $sql = "SELECT * FROM " . $BookingSlotModel->getTable() . " as t1 LEFT JOIN  " . $BookingModel->getTable() . " as t2 ON t1.booking_id = t2.id WHERE (t2.status = 'confirmed' OR (t2.status = 'pending' AND t2.created >= " . $before . " )) AND t1.timestamp BETWEEN " . $from . "  AND " . $to . " AND t1.calendar_id = " . $cal_id . " ";

            $booking = $BookingSlotModel->execute($sql);



            $booked_slots = array();



            if (!empty($booking)) {

                foreach ($booking as $key => $value) {

                    if (!empty($booked_slots[$value['timestamp']])) {

                        $booked_slots[$value['timestamp']] += $value['count'];
                    } else {

                        $booked_slots[$value['timestamp']] = $value['count'];
                    }
                }
            }



            $opts = array();

            $opts['calendar_id'] = $cal_id;

            $custom_prices_arr = $CustomPriceModel->getAll($opts);



            $opts = array();



            $opts['calendar_id'] = $cal_id;

            $working_times = $TimePriceModel->getAll($opts, 'id');



            $date = $slot;



            foreach ($working_times as $working_time) {



                switch (date('N', $date)) {

                    case '1':

                        $start_time = explode(':', $working_time['monday_start']);

                        $end_time = explode(':', $working_time['monday_end']);



                        $slot_lenght = $working_time['monday_slot_lenght'];

                        $price = $working_time['monday_price'];

                        $count = $working_time['monday_count'];

                        break;

                    case '2':

                        $start_time = explode(':', $working_time['tuesday_start']);

                        $end_time = explode(':', $working_time['tuesday_end']);



                        $slot_lenght = $working_time['tuesday_slot_lenght'];

                        $price = $working_time['tuesday_price'];

                        $count = $working_time['tuesday_count'];

                        break;

                    case '3':

                        $start_time = explode(':', $working_time['wednesday_start']);

                        $end_time = explode(':', $working_time['wednesday_end']);



                        $slot_lenght = $working_time['wednesday_slot_lenght'];

                        $price = $working_time['wednesday_price'];

                        $count = $working_time['wednesday_count'];

                        break;

                    case '4':

                        $start_time = explode(':', $working_time['thursday_start']);

                        $end_time = explode(':', $working_time['thursday_end']);



                        $slot_lenght = $working_time['thursday_slot_lenght'];

                        $price = $working_time['thursday_price'];

                        $count = $working_time['thursday_count'];

                        break;

                    case '5':

                        $start_time = explode(':', $working_time['friday_start']);

                        $end_time = explode(':', $working_time['friday_end']);



                        $slot_lenght = $working_time['friday_slot_lenght'];

                        $price = $working_time['friday_price'];

                        $count = $working_time['friday_count'];

                        break;

                    case '6':

                        $start_time = explode(':', $working_time['saturday_start']);

                        $end_time = explode(':', $working_time['saturday_end']);



                        $slot_lenght = $working_time['saturday_slot_lenght'];

                        $price = $working_time['saturday_price'];

                        $count = $working_time['saturday_count'];

                        break;

                    case '7':

                        $start_time = explode(':', $working_time['sunday_start']);

                        $end_time = explode(':', $working_time['sunday_end']);



                        $slot_lenght = $working_time['sunday_slot_lenght'];

                        $price = $working_time['sunday_price'];

                        $count = $working_time['sunday_count'];

                        break;
                }





                if (!empty($start_time[0]) && !empty($end_time[0])) {

                    for ($i = mktime($start_time[0], $start_time[1], 0, date('n', $date), date('j', $date), date('Y', $date)); $i <= mktime($end_time[0], $end_time[1], 0, date('n', $date), date('j', $date), date('Y', $date)); $i += $slot_lenght * 60) {

                        $booked = 0;



                        if ($i == $slot) {

                            foreach ($booked_slots as $booked_timestamp => $booked_count) {

                                if ($booked_timestamp >= $i && $booked_timestamp < ($i + $slot_lenght * 60)) {

                                    $booked += $booked_count;
                                }
                            }

                            if (($count + 1) < ($booked + $ccount)) {

                                $check = false;
                            }
                        }
                    }
                }
            }
        }

        return $check;
    }


    function calculateMemberPrice()
    {
        $price = array('gmi_amount' => 0, 'gmf_amount' => 0, 'lm_amount' => 0, 'bf_amount' => 0, 'pm_amount' => 0, 'lm_h_amount' => 0, 'total' => 0);

        switch ($_POST['rate'] ?? '') {
            case 'gmi_1':
                $price['gmi_amount'] = $this->tpl['option_arr_values']['gmi_1'];
                break;
            case 'gmi_4':
                $price['gmi_amount'] = $this->tpl['option_arr_values']['gmi_4'];
                break;
            case 'gmf_1':
                $price['gmf_amount'] = $this->tpl['option_arr_values']['gmf_1'];
                break;
            case 'gmf_4':
                $price['gmf_amount'] = $this->tpl['option_arr_values']['gmf_4'];
                break;
            case 'lm':
                $price['lm_amount'] = $this->tpl['option_arr_values']['lm'];
                break;
            case 'bf':
                $price['bf_amount'] = $this->tpl['option_arr_values']['bf'];
                break;
            case 'pm':
                $price['pm_amount'] = $this->tpl['option_arr_values']['pm'];
                break;
            case 'lm_h':
                $price['lm_h_amount'] = $this->tpl['option_arr_values']['lm_h'];
                break;
        }

        $price['total'] = $price['gmi_amount'] + $price['gmf_amount'] + $price['lm_amount'] + $price['bf_amount'] + $price['pm_amount'] + $price['lm_h_amount'] + (float) ($_POST['donation'] ?? 0);

        return $price;
    }

    function sendEmailsConfirm($members_details, $type, $group, $pass = NULL)
    {
        GzObject::loadFiles('Model', array('Option', 'User'));
        $OptionModel = new OptionModel();
        $option_arr = $OptionModel->getAllPairValues();

        $replacement = array();

        $replacement['last'] = $members_details['last'];
        $replacement['first'] = $members_details['first'];
        $replacement['email'] = $members_details['email'];
        $replacement['password'] = $pass;

        switch ($type) {
            case 'forgot':
                switch ($group) {
                    case 'members':
                        $message = Util::replaceForgotEmailToken($option_arr['forgot_password_message'], $replacement);
                        $subjetc = $option_arr['forgot_password_subject'];
                        $to = $members_details['email'];
                        break;
                }
                break;
        }


        try {
            $mail = new PHPMailer(true); //New instance, with exceptions enabled
            //$mail->IsSendmail();  // tell the class to use Sendmail

            $email_arr = explode(',', $option_arr['notify_email']);

            foreach ($email_arr as $email) {
                $mail->AddReplyTo(trim($email), "Admin");
            }

            $email_arr = explode(',', $option_arr['notify_email']);
            $mail->From = $email_arr[0];
            $mail->FromName = $email_arr[0];

            $mail->AddAddress($to);
            $mail->Subject = $subjetc;
            $mail->AltBody = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
            $mail->WordWrap = 80; // set word wrap
            $mail->MsgHTML($message);
            $mail->IsHTML(true); // send as HTML
            gz_send_mail($mail);
        } catch (\Exception $e) {

            error_log('[App.php] Mail failed: ' . $e->getMessage());
        }
    }


    // start email otp
    function sendEmailsConfirmMobileOtp($users_details, $mobile_otp, $forceRealSend = false)
    {
        $logFile = (defined('FCPATH') ? rtrim(FCPATH, '/\\') : getcwd()) . DIRECTORY_SEPARATOR . 'otp_mail.log';
        $log = function(string $msg) use ($logFile) {
            file_put_contents($logFile, date('[Y-m-d H:i:s] ') . $msg . PHP_EOL, FILE_APPEND | LOCK_EX);
        };

        $log('=== OTP Email START ===');
        $log('To: ' . ($users_details['email'] ?? 'EMPTY'));
        $log('OTP: ' . $mobile_otp);
        $log('SMTP Host: ' . SMTP_HOST . ' | Port: 587 | User: ' . SMTP_USER);

        if (!empty($users_details)) {
            $subjetc = 'HDBS Admin Email OTP';
            $first = $users_details['first'];
            $last = $users_details['last'];
            //echo $last;
            $email = $users_details['email'];
            //$mobile_otp =$mobile_otp;
            // $_SESSION['session_mobile_otp'] = $otp;
            //echo $email_otp;
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
         <td style="text-align: center; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;"><strong>OTP to Login</strong></td>
         </tr>
         </tbody>
         </table>
         </div>
         <div class="email-token-class" style="text-align: center;">
         <table style="height: 190px; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;" width="604">
         <tbody>
         <tr>
         <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Full Name&nbsp;&nbsp;</td>
         <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">' . $first . '&nbsp;&nbsp;' . $last . '</td>
         </tr>
         <tr>
         <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Email ID&nbsp;&nbsp;</td>
         <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $email . '</td>
         </tr>
         <tr>
         <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">OTP&nbsp;&nbsp;</td>
         <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: center; font-size: 24px; font-weight: 900; letter-spacing: 1px; color: #fff; background-color: #000;">' . $mobile_otp . '</td>
         </tr> 
        </tbody>
         </table>
         </div>
         </div>
         </div>';
            GzObject::loadFiles('Model', array('User'));
            $UserModel = new UserModel();

            try {
                $mail = new PHPMailer(true);
                $mail->SMTPDebug = 0;
                $mail->isSMTP();
                $mail->Host = SMTP_HOST;
                $mail->SMTPAuth = true;
                $mail->Username = SMTP_USER;
                $mail->Password = SMTP_PASS;
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;
                $mail->Timeout = 15;
                $mail->SMTPOptions = [
                    'ssl' => [
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true,
                    ]
                ];
                $mail->addreplyto(SMTP_FROM, "Admin");
                $mail->From = SMTP_FROM;
                $mail->FromName = 'Houston Durga Bari';
                $mail->CharSet = 'UTF-8';
                $mail->AddAddress($users_details['email']);
                $mail->Subject = $subjetc;
                $mail->AltBody = "To view the message, please use an HTML compatible email viewer!";
                $mail->WordWrap = 80;
                $mail->MsgHTML($message);
                $mail->IsHTML(true);
                $log('Calling gz_send_mail()...');
                gz_send_mail($mail, $forceRealSend);
                $log('SUCCESS — OTP email sent to ' . ($users_details['email'] ?? ''));
                $timestamp_email_otp = $_SERVER["REQUEST_TIME"];
                $_SESSION['time'] = $timestamp_email_otp;
            } catch (\Exception $e) {
                $log('FAILED — ' . $e->getMessage());
                error_log('[OTP Mail] SMTP Error: ' . $e->getMessage());
                $_SESSION['mail_error'] = $e->getMessage();
            }
            $log('=== OTP Email END ===');
            // $_SESSION['status'] = 28;
            // echo "<script type='text/javascript'>window.open('$path','_self');</script>";
            // Util::redirect(INSTALL_URL . "Donations/donation/");
        }
    }

    // end email otp

    // Badges email for sponsor

    function sendEmail($Parking, $path)
    {

        if (!empty($Parking)) {
            $subjetc = 'HDBS Parking Confirmation';
            $member_id = $Parking['Member_id'];
            $name = $Parking['name'];
            $Volunteer_Name = $Parking['Volunteer_Name'];
            $F_Name = $Parking['F_Name'];
            $L_Name = $Parking['L_Name'];
            $Sp_FName = $Parking['Sp_FName'];
            $parking_assigned = $Parking['parking_assigned'];
            $Decal = $Parking['Decal'];
            $Date = $Parking['Date'];
            $signName = $Parking['Signature'];
            $Path = INSTALL_URL . "esign/";
            $FinalSignImage = $Path . $signName;

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
            <td style="text-align: center; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;"><strong>Parking Details</strong></td>
            </tr>
            </tbody>
            </table>
            </div>
            <div class="email-token-class" style="text-align: center;">
            <table style="height: 190px; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;" width="604">
            <tbody>
            <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Member ID&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $member_id . '</td>
            </tr>
            <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">First Name&nbsp;&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $F_Name . '</td>
            </tr>
            <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Last Name&nbsp;&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $L_Name . '</td>
            </tr>
            <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Spouse Name&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $Sp_FName . '</td>
            </tr>
            <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Parking Lot Assigned&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $parking_assigned . '</td>
            </tr>
			<tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Deacl Assigned&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $Decal . '</td>
            </tr>
            <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Date&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $Date . '</td>
            </tr>
            <tr>
            <td colspan=2 style="text-align: center; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;"><img src=' . $FinalSignImage . ' alt="" width="396" height="80" /></td>
            </tr>
            </tbody>
            </table>
            </div>
            </div>
            </div>';
            GzObject::loadFiles('Model', array('Parkingdataview', 'Parkingdata'));
            $ParkingdataModel = new ParkingdataModel();
            $ParkingdataviewModel = new ParkingdataviewModel();

            try {
                $mail = new PHPMailer(true); //New instance, with exceptions enabled
                //$mail->IsSendmail();  // tell the class to use Sendmail
                $mail->addreplyto('Registration@durgabari.org', "Admin");
                $mail->From = 'hdbs.payment@durgabari.org';
                $mail->FromName = 'hdbs.payment@durgabari.org';
                //$mail->FromName = $Parking['email'];
                $mail->CharSet = 'UTF-8';
                $mail->AddAddress($Parking['email']);
                //$mail->addaddress('paras.sharma@eiceinternational.com');
                //$list = array('one@example.com', 'two@example.com', 'three@example.com');
                //$this->mail->ADDCC($list);
                $mail->AddCC('Registration@durgabari.org');
                $mail->Subject = $subjetc;
                $mail->AltBody = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
                $mail->WordWrap = 80; // set word wrap
                $mail->MsgHTML($message);
                //$file ='Parking_' . $ID . '_invoice_' . $Mid . '.pdf';
                if (is_file(INSTALL_PATH . UPLOAD_PATH . 'parkinginvoice/' . 'Parking_' . $Parking['ID'] . '_invoice_' . $Parking['Member_id'] . '.pdf')) {
                    $mail->AddAttachment(INSTALL_PATH . UPLOAD_PATH . 'parkinginvoice/' . 'Parking_' . $Parking['ID'] . '_invoice_' . $Parking['Member_id'] . '.pdf'); // attachment
                }
                $mail->IsHTML(true); // send as HTML
                gz_send_mail($mail);
            } catch (\Exception $e) {
                error_log('[App.php] Mail failed: ' . $e->getMessage());
            }
            $_SESSION['status'] = 28;
            // echo "<script type='text/javascript'>window.open('$path','_self');</script>";
            //Util::redirect(INSTALL_URL . "Badges/index/");
        }
    }


    // Badges email for Paid parking

    function sendEmailPaid($Parking, $path)
    {

        if (!empty($Parking)) {
            $subjetc = 'HDBS Parking Confirmation';
            $oid = $Parking['oid'];
            $name = $Parking['name'];
            $parking_assigned = $Parking['parking_assigned'];
            $Decal = $Parking['Decal'];
            $Date = $Parking['Date'];
            $signName = $Parking['Signature'];
            $Path = INSTALL_URL . "esign/";
            $FinalSignImage = $Path . $signName;

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
            <td style="text-align: center; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;"><strong>Parking Details</strong></td>
            </tr>
            </tbody>
            </table>
            </div>
            <div class="email-token-class" style="text-align: center;">
            <table style="height: 190px; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;" width="604">
            <tbody>
            <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">OID&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $oid . '</td>
            </tr>
            <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Name&nbsp;&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $name . '</td>
            </tr>        
            <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Parking Lot Assigned&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $parking_assigned . '</td>
            </tr>
			<tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Deacl Assigned&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $Decal . '</td>
            </tr>
            <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Date&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $Date . '</td>
            </tr>
            <tr>
            <td colspan=2 style="text-align: center; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;"><img src=' . $FinalSignImage . ' alt="" width="396" height="80" /></td>
            </tr>
            </tbody>
            </table>
            </div>
            </div>
            </div>';
            GzObject::loadFiles('Model', array('Parkingdata', 'Paidparkingview'));
            $ParkingdataModel = new ParkingdataModel();
            $PaidparkingviewModel = new PaidparkingviewModel();

            try {
                $mail = new PHPMailer(true); //New instance, with exceptions enabled
                //$mail->IsSendmail();  // tell the class to use Sendmail
                $mail->addreplyto('Registration@durgabari.org', "Admin");
                $mail->From = 'hdbs.payment@durgabari.org';
                $mail->FromName = 'hdbs.payment@durgabari.org';
                //$mail->FromName = $Parking['email'];
                $mail->CharSet = 'UTF-8';
                $mail->AddAddress($Parking['email']);
                //$mail->addaddress('paras.sharma@eiceinternational.com');
                //$list = array('one@example.com', 'two@example.com', 'three@example.com');
                //$this->mail->ADDCC($list);
                $mail->AddCC('Registration@durgabari.org');
                $mail->Subject = $subjetc;
                $mail->AltBody = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
                $mail->WordWrap = 80; // set word wrap
                $mail->MsgHTML($message);
                //$file ='Parking_' . $ID . '_invoice_' . $Mid . '.pdf';
                if (is_file(INSTALL_PATH . UPLOAD_PATH . 'parkinginvoice/' . 'Parking_' . $Parking['ID'] . '_invoice_' . $Parking['Member_id'] . '.pdf')) {
                    $mail->AddAttachment(INSTALL_PATH . UPLOAD_PATH . 'parkinginvoice/' . 'Parking_' . $Parking['ID'] . '_invoice_' . $Parking['Member_id'] . '.pdf'); // attachment
                }
                $mail->IsHTML(true); // send as HTML
                gz_send_mail($mail);
            } catch (\Exception $e) {
                error_log('[App.php] Mail failed: ' . $e->getMessage());
            }
            $_SESSION['status'] = 28;
            //echo "<script type='text/javascript'>window.open('$path','_self');</script>";
            // Util::redirect(INSTALL_URL . "Badges/index/");
        }
    }

    // Badges email 
    function sendEmailBadges($Badges, $path)
    {
        if (!empty($Badges)) {
            $subjetc = 'HDBS Badges Confirmation';
            $MID = $Badges['MID'];
            $F_Name = $Badges['F_Name'];
            $L_Name = $Badges['L_Name'];
            $Spouse_Name = $Badges['Sp_FName'];
            $Status = $Badges['Status'];
            $total = $Badges['Total'];
            $Date = $Badges['Date'];
            $signName = $Badges['Signature'];
            $Path = INSTALL_URL . "esign/";
            $FinalSignImage = $Path . $signName;

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
                <td style="text-align: center; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;"><strong>Badges Details</strong></td>
                </tr>
                </tbody>
                </table>
                </div>
                <div class="email-token-class" style="text-align: center;">
                <table style="height: 190px; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;" width="604">
                <tbody>
                <tr>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">MID&nbsp;</td>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $MID . '</td>
                </tr>
                <tr>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">First Name&nbsp;&nbsp;</td>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $F_Name . '</td>
                </tr>
                <tr>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Last Name&nbsp;&nbsp;</td>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $L_Name . '</td>
                </tr>
                <tr>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Spouse Name&nbsp;</td>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $Spouse_Name . '</td>
                </tr>
                <tr>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Total &nbsp;</td>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $total . '</td>
                </tr>
                <tr>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Status&nbsp;</td>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $Status . '</td>
                </tr>
                
                <tr>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Date&nbsp;</td>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $Date . '</td>
                </tr>
                <tr>
                <td colspan=2 style="text-align: center; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;"><img src=' . $FinalSignImage . '  alt="" width="396" height="80" /></td>
                </tr>
                </tbody>
                </table>
                </div>
                </div>
                </div>';
            GzObject::loadFiles('Model', array('Badgesdata'));
            $BadgesdataModel = new BadgesdataModel();

            try {
                $mail = new PHPMailer(true); //New instance, with exceptions enabled
                //$mail->IsSendmail();  // tell the class to use Sendmail
                $mail->addreplyto('registration@durgabari.org', "Admin");
                $mail->From = 'hdbs.payment@durgabari.org';
                $mail->FromName = 'hdbs.payment@durgabari.org';
                //$mail->FromName = $Parking['email'];
                $mail->CharSet = 'UTF-8';
                $mail->AddAddress($Badges['Email']);
                //$mail->addaddress('avinash.verma@eiceinternational.com');
                //$list = array('one@example.com', 'two@example.com', 'three@example.com');
                //$this->mail->ADDCC($list);
                $mail->addcc('registration@durgabari.org');
                $mail->Subject = $subjetc;
                $mail->AltBody = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
                $mail->WordWrap = 80; // set word wrap
                $mail->MsgHTML($message);
                //$file ='Parking_' . $ID . '_invoice_' . $Mid . '.pdf';
                if (is_file(INSTALL_PATH . UPLOAD_PATH . 'parkinginvoice/' . 'Badges_' . $Badges['id'] . '_invoice_' . $Badges['MID'] . '.pdf')) {
                    $mail->AddAttachment(INSTALL_PATH . UPLOAD_PATH . 'parkinginvoice/' . 'Badges_' . $Badges['id'] . '_invoice_' . $Badges['MID'] . '.pdf'); // attachment
                }
                $mail->IsHTML(true); // send as HTML
                gz_send_mail($mail);
            } catch (\Exception $e) {
                error_log('[App.php] Mail failed: ' . $e->getMessage());
            }
            $_SESSION['status'] = 28;
            // echo "<script type='text/javascript'>window.open('$path','_self');</script>";
            //Util::redirect(INSTALL_URL . "Badges/index/");
        }
    }


    // Badges email for Volunteer

    function sendEmailvolunteer($Parking, $path)
    {

        if (!empty($Parking)) {
            $subjetc = 'HDBS Parking Confirmation';
            $MID = $Parking['MID'];
            $Volunteer_Name = $Parking['Volunteer_Name'];
            $L_Name = $Parking['L_Name'];
            $Spouse_Name = $Parking['Spouse_Name'];
            $Parking_AreaAssigned = $Parking['Parking_AreaAssigned'];
            $Decal = $Parking['Decal'];
            $Date = $Parking['Date'];
            $signName = $Parking['Signature'];
            $Path = INSTALL_URL . "esign/";
            $FinalSignImage = $Path . $signName;

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
            <td style="text-align: center; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;"><strong>Parking Details</strong></td>
            </tr>
            </tbody>
            </table>
            </div>
            <div class="email-token-class" style="text-align: center;">
            <table style="height: 190px; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;" width="604">
            <tbody>
            <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">MID&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $MID . '</td>
            </tr>
            <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">First Name&nbsp;&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $Volunteer_Name . '</td>
            </tr>
            <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Last Name&nbsp;&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $L_Name . '</td>
            </tr>
            <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Spouse Name&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $Spouse_Name . '</td>
            </tr>
            <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Parking Lot Assigned&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $Parking_AreaAssigned . '</td>
            </tr>
			<tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Deacl Assigned&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $Decal . '</td>
            </tr>
            <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Date&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $Date . '</td>
            </tr>
            <tr>
            <td colspan=2 style="text-align: center; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;"><img src=' . $FinalSignImage . ' alt="" width="396" height="80" /></td>
            </tr>
            </tbody>
            </table>
            </div>
            </div>
            </div>';
            GzObject::loadFiles('Model', array('Volunteersdata'));
            $VolunteersdataModel = new VolunteersdataModel();

            try {
                $mail = new PHPMailer(true); //New instance, with exceptions enabled
                //$mail->IsSendmail();  // tell the class to use Sendmail
                $mail->addreplyto('Registration@durgabari.org', "Admin");
                $mail->From = 'hdbs.payment@durgabari.org';
                $mail->FromName = 'hdbs.payment@durgabari.org';
                //$mail->FromName = $Parking['email'];
                $mail->CharSet = 'UTF-8';
                $mail->AddAddress($Parking['email']);
                //$mail->addaddress('paras.sharma@eiceinternational.com');
                //$list = array('one@example.com', 'two@example.com', 'three@example.com');
                //$this->mail->ADDCC($list);
                $mail->AddCC('Registration@durgabari.org');
                $mail->Subject = $subjetc;
                $mail->AltBody = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
                $mail->WordWrap = 80; // set word wrap
                $mail->MsgHTML($message);
                //$file ='Parking_' . $ID . '_invoice_' . $Mid . '.pdf';
                if (is_file(INSTALL_PATH . UPLOAD_PATH . 'parkinginvoice/' . 'Parking_' . $Parking['ID'] . '_invoice_' . $Parking['Member_id'] . '.pdf')) {
                    $mail->AddAttachment(INSTALL_PATH . UPLOAD_PATH . 'parkinginvoice/' . 'Parking_' . $Parking['ID'] . '_invoice_' . $Parking['Member_id'] . '.pdf'); // attachment
                }
                $mail->IsHTML(true); // send as HTML
                gz_send_mail($mail);
            } catch (\Exception $e) {
                error_log('[App.php] Mail failed: ' . $e->getMessage());
            }
            $_SESSION['status'] = 28;
            //echo "<script type='text/javascript'>window.open('$path','_self');</script>";
            //Util::redirect(INSTALL_URL . "Badges/index/");
        }
    }


    // Food Coupons email 
    function foodsendEmail($fooddata, $path)
    {
        if (!empty($fooddata)) {
            $subjetc = 'HDBS Food Coupons Confirmation';
            $MID = $fooddata['MID'];
            $F_Name = $fooddata['F_Name'];
            $L_Name = $fooddata['L_Name'];
            $Spouse_Name = $fooddata['Sp_FName'];
            $Status = $fooddata['Status'];
            $total = $fooddata['Total'];
            $Date = $fooddata['Date'];
            $signName = $fooddata['Signature'];
            $Path = INSTALL_URL . "esign/";
            $FinalSignImage = $Path . $signName;

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
                <td style="text-align: center; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;"><strong>2022 Kali Puja Food Coupon Details</strong></td>
                </tr>
                </tbody>
                </table>
                </div>
                <div class="email-token-class" style="text-align: center;">
                <table style="height: 190px; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;" width="604">
                <tbody>
                <tr>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">MID&nbsp;</td>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $MID . '</td>
                </tr>
                <tr>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">First Name&nbsp;&nbsp;</td>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $F_Name . '</td>
                </tr>
                <tr>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Last Name&nbsp;&nbsp;</td>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $L_Name . '</td>
                </tr>
                <tr>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Spouse Name&nbsp;</td>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $Spouse_Name . '</td>
                </tr>
                <tr>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Total &nbsp;</td>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $total . '</td>
                </tr>
                <tr>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Status&nbsp;</td>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $Status . '</td>
                </tr>
                
                <tr>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Date&nbsp;</td>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $Date . '</td>
                </tr>
                <tr>
                <td colspan=2 style="text-align: center; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;"><img src=' . $FinalSignImage . '  alt="" width="396" height="80" /></td>
                </tr>
                </tbody>
                </table>
                </div>
                </div>
                </div>';
            GzObject::loadFiles('Model', array('Foodcoupon'));
            $FoodcouponModel = new FoodcouponModel();

            try {
                $mail = new PHPMailer(true); //New instance, with exceptions enabled
                //$mail->IsSendmail();  // tell the class to use Sendmail
                $mail->addreplyto('registration@durgabari.org', "Admin");
                $mail->From = 'hdbs.payment@durgabari.org';
                $mail->FromName = 'hdbs.payment@durgabari.org';
                //$mail->FromName = $fooddata['email'];
                $mail->CharSet = 'UTF-8';
                $mail->AddAddress($fooddata['Email']);
                //$mail->addaddress('avinash.verma@eiceinternational.com');
                //$list = array('one@example.com', 'two@example.com', 'three@example.com');
                //$this->mail->ADDCC($list);
                $mail->addcc('registration@durgabari.org');
                $mail->Subject = $subjetc;
                $mail->AltBody = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
                $mail->WordWrap = 80; // set word wrap
                $mail->MsgHTML($message);
                //$file ='Parking_' . $ID . '_invoice_' . $Mid . '.pdf';
                if (is_file(INSTALL_PATH . UPLOAD_PATH . 'parkinginvoice/' . 'fooddata_' . $fooddata['id'] . '_invoice_' . $fooddata['MID'] . '.pdf')) {
                    $mail->AddAttachment(INSTALL_PATH . UPLOAD_PATH . 'Foodcouponinvoice/' . 'fooddata_' . $fooddata['id'] . '_invoice_' . $fooddata['MID'] . '.pdf'); // attachment
                }
                $mail->IsHTML(true); // send as HTML
                gz_send_mail($mail);
            } catch (\Exception $e) {
                error_log('[App.php] Mail failed: ' . $e->getMessage());
            }
            $_SESSION['status'] = 28;
            // echo "<script type='text/javascript'>window.open('$path','_self');</script>";
            //Util::redirect(INSTALL_URL . "Foodcoupon/index/");
        }

    }
    // send email common function

    function sendEmailticket($message, $subjetc, $email, $Emailcc, $forceRealSend = false)
    {

        try {
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host       = SMTP_HOST;
            $mail->SMTPAuth   = true;
            $mail->Username   = SMTP_USER;
            $mail->Password   = SMTP_PASS;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;
            $mail->Timeout    = 15;
            $mail->SMTPOptions = ['ssl' => ['verify_peer' => false, 'verify_peer_name' => false, 'allow_self_signed' => true]];
            $mail->addreplyto(SMTP_FROM, "Admin");
            $mail->From = SMTP_FROM;
            $mail->FromName = 'Houston Durga Bari';
            $mail->CharSet = 'UTF-8';
            $mail->AddAddress($email);
            // $mail->addaddress('avinash.verma@eiceinternational.com');
            //$list = array('paras.sharma@eiceinternational.com');
            //$this->mail->ADDCC($list);
            $mail->addcc($Emailcc);
            $mail->Subject = $subjetc;
            $mail->AltBody = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
            $mail->WordWrap = 80; // set word wrap
            $mail->MsgHTML($message);
            $mail->IsHTML(true); // send as HTML
            gz_send_mail($mail, $forceRealSend);
        } catch (\Exception $e) {
            error_log('[App.php] Mail failed: ' . $e->getMessage());
        }

    }


    // end



    // ticket confirmation
    function sendTicketEventconfirmation($data)
    { {
            if (!empty($data)) {
                $subjetc = 'HDBS Ticket Confirmation';
                $oid = $data['oid'];
                $memberid = $data['Member_id'];
                $MemberName = $data['name'];
                $name = $data['type'];
                if ($name == 'kalipuja') {
                    $eventname = 'Kali Puja';
                } else {
                    $eventname = 'Saraswati Puja';
                }
                $tickettype = $data['tickettype'];
                if ($tickettype == 'individual') {
                    $typeticket = 'Individual';
                } else {
                    $typeticket = 'Family';
                }
                $Quantity = $data['item_number'];
                $ticketprice = $data['item_cost'];
                $totalamount = $data['amount'];
                $datefor = $data['pay_date'];
                $timestamp = !empty($datefor) ? strtotime($datefor) : false;
                $payfinaldate = $timestamp ? date("m/d/Y", $timestamp) : '';
                $paymethod = $data['PaymentOption'];
                if ($paymethod == "others") {
                    $paymethodfinal = 'Zelle';
                } elseif ($paymethod == "cash") {
                    $paymethodfinal = 'Cash';
                } elseif ($paymethod == "check") {
                    $paymethodfinal = 'Check';
                } elseif ($paymethod == "directdeposit") {
                    $paymethodfinal = 'Online Deposit';
                } else {
                    $paymethodfinal = 'Credit Card';
                }

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
                <td style="text-align: center; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;"><strong>Ticket Payment Confirmation</strong></td>
                </tr>
                </tbody>
                </table>
                </div>
                <div class="email-token-class" style="text-align: center;">
                <table style="height: 190px; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;" width="604">
                <tbody>
                <tr>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Order ID&nbsp;&nbsp;</td>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $oid . '</td>
                </tr>
                <tr>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;  width:50%;">Member ID&nbsp;</td>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;  width:50%;">' . $memberid . '</td>
                </tr>
                <tr>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Member Name&nbsp;&nbsp;</td>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $MemberName . '</td>
                </tr>
                <tr>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Puja Type&nbsp;</td>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $eventname . '</td>
                </tr> 
                <tr>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Ticket Type &nbsp;&nbsp;</td>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $typeticket . '</td>
                </tr>
                
                 <tr>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Quantity &nbsp;&nbsp;</td>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $Quantity . '</td>
                </tr>
                <tr>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Ticket Price&nbsp;&nbsp;</td>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;"><span style="color:red;">$</span>' . $ticketprice . '</td>
                </tr>
                <tr>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Total Amount&nbsp;&nbsp;</td>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;"><span style="color:red;">$</span>' . $totalamount . '</td>
                </tr>
                <tr>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Payment Method&nbsp;&nbsp;</td>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $paymethodfinal . '</td>
                </tr>
                <tr>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Pay Date&nbsp;&nbsp;</td>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $payfinaldate . '</td>
                </tr>
                </tbody>
                </table>
                </div>
                </div>
                </div>';
                GzObject::loadFiles('Model', array('ticket'));
                $ticketModel = new ticketModel();

                try {
                    $mail = new PHPMailer(true); //New instance, with exceptions enabled
                    //$mail->IsSendmail();  // tell the class to use Sendmail
                    $mail->addreplyto('hdbs.payment@durgabari.org', "Admin");
                    $mail->From = 'hdbs.payment@durgabari.org';
                    $mail->FromName = 'hdbs.payment@durgabari.org';
                    //$mail->FromName = $data['email'];
                    $mail->CharSet = 'UTF-8';
                    $mail->AddAddress($data['email']);
                    //$mail->AddAddress('');
                    //$mail->addaddress('');
                    //$this->mail->ADDCC($list);
                    $mail->addcc('pujaregpayment@durgabari.org');
                    $mail->Subject = $subjetc;
                    $mail->AltBody = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
                    $mail->WordWrap = 80; // set word wrap
                    $mail->MsgHTML($message);

                    $mail->IsHTML(true); // send as HTML
                    gz_send_mail($mail);
                } catch (\Exception $e) {
                    error_log('[App.php] Mail failed: ' . $e->getMessage());
                }
                //$_SESSION['status'] = 28;
                // echo "<script type='text/javascript'>window.open('$path','_self');</script>";
                //Util::redirect(INSTALL_URL . "Event/event/");
            }
        }
    }

    // pujaregistration confirmation
    function sendregistrationconfirmation($data)
    { {
            if (!empty($data)) {
                $subjetc = 'HDBS Puja Registration Confirmation';
                $oid = $data['oid'];
                $memberid = $data['Member_id'];
                $MemberName = $data['membername'];
                $pujaprice = $data['amount'];
                $magazineprice = $data['magazineprice'] ?? '';
                $seniordiscount = $data['discountseniorprice'] ?? '';
                $parentregistration = $data['extraparentregistration'] ?? '';
                $donation = $data['donation'];
                $totalamount = $data['totalamount'];
                $pujaname = $data['puja_type'];
                $datefor = $data['pay_date'];
                $timestamp = !empty($datefor) ? strtotime($datefor) : false;
                $payfinaldate = $timestamp ? date("m/d/Y", $timestamp) : '';
                $paymethod = $data['PaymentOption'];
                if ($paymethod == "others") {
                    $paymethodfinal = 'Zelle';
                } elseif ($paymethod == "cash") {
                    $paymethodfinal = 'Cash';
                } elseif ($paymethod == "check") {
                    $paymethodfinal = 'Check';
                } elseif ($paymethod == "directdeposit") {
                    $paymethodfinal = 'Online Deposit';
                } else {
                    $paymethodfinal = 'Credit Card';
                }

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
                <td style="text-align: center; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;"><strong>HDBS Puja Registration Confirmation</strong></td>
                </tr>
                </tbody>
                </table>
                </div>
                <div class="email-token-class" style="text-align: center;">
                <table style="height: 190px; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;" width="604">
                <tbody>
                <tr>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Order ID&nbsp;&nbsp;</td>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $oid . '</td>
                </tr>
                <tr>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;  width:50%;">Member ID&nbsp;</td>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;  width:50%;">' . $memberid . '</td>
                </tr>
                <tr>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Member Name&nbsp;&nbsp;</td>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $MemberName . '</td>
                </tr>
                <tr>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Puja Type&nbsp;&nbsp;</td>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $pujaname . '</td>
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
                $message .= '
                <tr>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Total Amount&nbsp;&nbsp;</td>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;"><span style="color:red;">$</span>' . $totalamount . '</td>
                </tr>
                <tr>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Payment Method&nbsp;&nbsp;</td>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $paymethodfinal . '</td>
                </tr>
                <tr>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Pay Date&nbsp;&nbsp;</td>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $payfinaldate . '</td>
                </tr>
                </tbody>
                </table>
                </div>
                </div>
                </div>';
                GzObject::loadFiles('Model', array('pujaregistration'));
                $pujaregistrationModel = new pujaregistrationModel();

                try {
                    $mail = new PHPMailer(true); //New instance, with exceptions enabled
                    //$mail->IsSendmail();  // tell the class to use Sendmail
                    $mail->addreplyto('hdbs.payment@durgabari.org', "Admin");
                    $mail->From = 'hdbs.payment@durgabari.org';
                    $mail->FromName = 'hdbs.payment@durgabari.org';
                    //$mail->FromName = $data['email'];
                    $mail->CharSet = 'UTF-8';
                    $mail->AddAddress($data['email']);
                    // $mail->AddAddress('avinash.verma@eiceinternational.com');
                    //$mail->addaddress('hdbs.payment@durgabari.org');
                    $mail->addcc('pujaregpayment@durgabari.org');
                    //$this->mail->ADDCC($list);
                    $mail->Subject = $subjetc;
                    $mail->AltBody = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
                    $mail->WordWrap = 80; // set word wrap
                    $mail->MsgHTML($message);

                    $mail->IsHTML(true); // send as HTML
                    gz_send_mail($mail);
                } catch (\Exception $e) {
                    error_log('[App.php] Mail failed: ' . $e->getMessage());
                }
            }
        }
    }
    // end


    //Donations email
    function sendEmailDonations($data)
    {
        if (!empty($data)) {
            $subjetc = 'HDBS Donation Confirmation';
            $MID = $data['Member_id'];
            $membername = $data['MemberName'];
            $Amount = $data['Amount'];
            $orderid = $data['oid'];
            $datefor = $data['pay_date'];
            $timestamp = !empty($datefor) ? strtotime($datefor) : false;
            $paydate = date("m/d/Y", $timestamp);
            $status = 'succeeded';
            $paymethod = $data['PaymentOption'];
            $parkingMsg = $data['greenFieldParkingDecision'] ?? '';

            if ($paymethod == "others") {
                $paymethodfinal = 'Zelle';

            } elseif ($paymethod == "cash") {
                $paymethodfinal = 'Cash';
            } elseif ($paymethod == "check") {
                $paymethodfinal = 'Check';
            } elseif ($paymethod == "directdeposit") {
                $paymethodfinal = 'Online Deposit';
            } elseif ($paymethod == "sumup") {
                $paymethodfinal = 'SumUp';
            } elseif ($paymethod == "zelleProxy") {
                $paymethodfinal = 'Zelle Proxy';
            } else {
                $paymethodfinal = 'Credit Card';
            }

            $messageold = '<p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</p>
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
            <td style="text-align: center; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;"><strong>Donation Confirmation</strong></td>
            </tr>
            </tbody>
            </table>
            </div>
            <div class="email-token-class" style="text-align: center;">
            <table style="height: 190px; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;" width="604">
            <tbody>
            <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;width:50%;">Member ID&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;width:50%;">' . $MID . '</td>
            </tr>
            <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Member Name&nbsp;&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $membername . '</td>
            </tr>
            <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Payment Method&nbsp;&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $paymethodfinal . '</td>
            </tr>
            <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Amount&nbsp;&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;"><span style="color:red;">$</span>' . $Amount . '</td>
            </tr>
            <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Order ID&nbsp;&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $orderid . '</td>
            </tr>
            <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Pay Date&nbsp;&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $paydate . '</td>
            </tr>
            <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Status&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">' . $status . '</td>
            </tr>
            </tbody>
            </table>
            </div>
            </div>
            </div>';



            $message = '<p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</p>
<div class="email-token-class" style="text-align: justify;">
<div class="email-token-class" style="text-align: center;">
<div class="email-token-class" style="text-align: center;">
<table style="height: 77px; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;" width="606">
<tbody>
<tr>
<td style="text-align: center; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;"><img src="" . INSTALL_URL . "application/web/upload/image/create.png" alt="" width="396" height="66" /></td>
</tr>
</tbody>
</table>
</div>
<div class="email-token-class" style="text-align: center;">
<table style="height: 22px; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;" width="604">
<tbody>
<tr>
<td style="text-align: center; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;"><strong>Donation Confirmation</strong></td>
</tr>
</tbody>
</table>
</div>
<div class="email-token-class" style="text-align: center;">
<table style="height: 190px; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;" width="604">
<tbody>
<tr>
<td style="border: 1px solid black; text-align: left; width:50%;">Member ID&nbsp;</td>
<td style="border: 1px solid black; text-align: left; width:50%;">' . $MID . '</td>
</tr>
<tr>
<td style="border: 1px solid black; text-align: left;">Member Name&nbsp;&nbsp;</td>
<td style="border: 1px solid black; text-align: left;">' . $membername . '</td>
</tr>
<tr>
<td style="border: 1px solid black; text-align: left;">Payment Method&nbsp;&nbsp;</td>
<td style="border: 1px solid black; text-align: left;">' . $paymethodfinal . '</td>
</tr>
<tr>
<td style="border: 1px solid black; text-align: left;">Amount&nbsp;&nbsp;</td>
<td style="border: 1px solid black; text-align: left;"><span style="color:red;">$</span>' . $Amount . '</td>
</tr>
<tr>
<td style="border: 1px solid black; text-align: left;">Order ID&nbsp;&nbsp;</td>
<td style="border: 1px solid black; text-align: left;">' . $orderid . '</td>
</tr>
<tr>
<td style="border: 1px solid black; text-align: left;">Pay Date&nbsp;&nbsp;</td>
<td style="border: 1px solid black; text-align: left;">' . $paydate . '</td>
</tr>
<tr>
<td style="border: 1px solid black; text-align: left;">Status&nbsp;</td>
<td style="border: 1px solid black; text-align: left;">' . $status . '</td>
</tr>';

            if (!empty($parkingMsg)) {
                $message .= '<tr>
    <td style="border: 1px solid black; text-align: left;">Parking Message&nbsp;</td>
    <td style="border: 1px solid black; text-align: left;">' . $parkingMsg . '</td>
    </tr>';
            }

            $message .= '</tbody>
</table>
</div>
</div>
</div>';





            GzObject::loadFiles('Model', array('Donation'));
            $DonationModel = new DonationModel();

            try {
                $mail = new PHPMailer(true); //New instance, with exceptions enabled
                //$mail->IsSendmail();  // tell the class to use Sendmail
                $mail->addreplyto('hdbs.payment@durgabari.org', "Admin");
                $mail->From = 'hdbs.payment@durgabari.org';
                $mail->FromName = 'hdbs.payment@durgabari.org';
                //$mail->FromName = $data['email'];
                $mail->CharSet = 'UTF-8';
                $mail->AddAddress($data['email']);
                // $mail->AddAddress('hdbs.payment@durgabari.org', 'Admin');
                //$mail->addaddress('hdbs.payment@durgabari.org');
                //$this->mail->ADDCC($list);
                $mail->addcc('pujaregpayment@durgabari.org');
                $mail->Subject = $subjetc;
                $mail->AltBody = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
                $mail->WordWrap = 80; // set word wrap
                $mail->MsgHTML($message);
                //$file ='Parking_' . $ID . '_invoice_' . $Mid . '.pdf';
                $mail->IsHTML(true); // send as HTML
                gz_send_mail($mail);
            } catch (\Exception $e) {
                error_log('[App.php] Mail failed: ' . $e->getMessage());
            }
            // $_SESSION['status'] = 28;
            // echo "<script type='text/javascript'>window.open('$path','_self');</script>";
            // Util::redirect(INSTALL_URL . "Donations/donation/");
        }
    }


    // end


    //send sms
    function SendSMS($mobileno, $msg, $forceRealSend = false)
    {
        $logPath = (defined('ROOT_PATH') ? ROOT_PATH : INSTALL_PATH) . 'sms_send.log';
        $log = function ($message) use ($logPath) {
            @file_put_contents($logPath, '[' . date('Y-m-d H:i:s') . '] ' . $message . PHP_EOL, FILE_APPEND | LOCK_EX);
        };

        $to = '+1' . preg_replace('/\D/', '', (string)$mobileno);
        $log('START to=' . $to . ' sms_enabled=' . (defined('SMS_ENABLED') && SMS_ENABLED ? 'true' : 'false') . ' force_real_send=' . ($forceRealSend ? 'true' : 'false') . ' twilio_from=' . (defined('TWILIO_FROM') ? TWILIO_FROM : ''));

        try {
            $client = gz_twilio_client($forceRealSend);
            $message = $client->messages->create(
                $to,
                ['from' => TWILIO_FROM, 'body' => $msg]
            );
            $sid = is_object($message) && isset($message->sid) ? $message->sid : 'mock/no-sid';
            $log('SUCCESS to=' . $to . ' sid=' . $sid);
        } catch (\Exception $e) {
            $log('FAILED to=' . $to . ' error=' . $e->getMessage());
            error_log('[SendSMS] Failed for ' . $to . ': ' . $e->getMessage());
        }
    }


}




