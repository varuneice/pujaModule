<?php

require_once MODELS_PATH . 'App.model.php';

class BookingModel extends AppModel {

    var $primaryKey = 'id';
    var $table = 'reservations';
    var $schema = array(
        array('name' => 'id', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'calendar_id', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'booking_number', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'location', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'title', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'first_name', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'second_name', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'phone', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'email', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'company', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'address_1', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'address_2', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'state', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'city', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'zip', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'country', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'fax', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'gender', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'additional', 'type' => 'text', 'default' => ':NULL'),
        array('name' => 'promo_code', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'status', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'amount', 'type' => 'float', 'default' => ':NULL'),
        array('name' => 'calendars_price', 'type' => 'float', 'default' => ':NULL'),
        array('name' => 'discount', 'type' => 'float', 'default' => ':NULL'),
        array('name' => 'total', 'type' => 'float', 'default' => ':NULL'),
        array('name' => 'tax', 'type' => 'float', 'default' => ':NULL'),
        array('name' => 'security', 'type' => 'float', 'default' => ':NULL'),
        array('name' => 'deposit', 'type' => 'float', 'default' => ':NULL'),
        array('name' => 'payment_method', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'cc_type', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'cc_num', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'cc_code', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'cc_exp_month', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'cc_exp_year', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'created', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'confirm_code', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'stripe_return', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'transaction_id', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'paid_amount', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'stripe_product', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'date', 'type' => 'varchar', 'default' => ':CURRENT_TIMESTAMP'),
        array('name' => 'finalDate', 'type' => 'varchar', 'default' => ':NULL'),
         array('name' => 'Member_id', 'type' => 'varchar', 'default' => ':NULL'),
    );

    public function getBookingDetails($id) {
        GzObject::loadFiles('Model', array('Calendar', 'BookingSlot', 'TimePrice', 'CustomDate'));
        $CalendarModel = new CalendarModel();
        $BookingSlotModel = new BookingSlotModel();
        $TimePriceModel = new TimePriceModel();
        $CustomDateModel = new CustomDateModel();

        $arr = $this->get($id);
        $booked_calendar = $CalendarModel->getI18n($arr['calendar_id']);

        $arr['booked_calendar'] = $booked_calendar;

        $language_arr = $_SESSION['lang'];
        $language_id = $language_arr['id'];

        $arr['calendar'] = $booked_calendar['i18n'][$language_id]['title'];

        $opts = array();

        $opts['booking_id'] = $arr['id'];
        $slots = $BookingSlotModel->getAll($opts);
        $opts = array();
        $opts['calendar_id'] = $arr['calendar_id'];
        $working_time = $TimePriceModel->getAll($opts, 'id');
        
        $opts = array();
        $opts['calendar_id'] = $arr['calendar_id'];
        $custom_dates = $CustomDateModel->getAll($opts);

        if (!empty($custom_dates)) {
            foreach ($custom_dates as $k => $v) {
                for($i = $v['timestamp']; $i <= $v['timestamp_end']; $i+=86400){
                    $custom_dates[mktime(0, 0, 0, date('n', $i), date('d', $i), date('Y', $i))] = $v;
                }
            }
        }

        $slot = array();
        
        foreach ($slots as $k => $v) {
            $i = $v['timestamp'];
            $count = $v['count'];
            
            if(!empty($custom_dates[mktime(0, 0, 0, date('m', $i), date('d', $i), date('Y', $i))])){
                $slot_lenght = $custom_dates[mktime(0, 0, 0, date('m', $i), date('d', $i), date('Y', $i))]['slot_lenght'];
                $price = $custom_dates[mktime(0, 0, 0, date('m', $i), date('d', $i), date('Y', $i))]['price'];
            }else{

                switch (date('N', $i)) {
                    case '1':
                        $slot_lenght = $working_time[0]['monday_slot_lenght'];
                        $price = $working_time[0]['monday_price'];
                        break;
                    case '2':
                        $slot_lenght = $working_time[0]['tuesday_slot_lenght'];
                        $price = $working_time[0]['tuesday_price'];
                        break;
                    case '3':
                        $slot_lenght = $working_time[0]['wednesday_slot_lenght'];
                        $price = $working_time[0]['wednesday_price'];
                        break;
                    case '4':
                        $slot_lenght = $working_time[0]['thursday_slot_lenght'];
                        $price = $working_time[0]['thursday_price'];
                        break;
                    case '5':
                        $slot_lenght = $working_time[0]['friday_slot_lenght'];
                        $price = $working_time[0]['friday_price'];
                        break;
                    case '6':
                        $slot_lenght = $working_time[0]['saturday_slot_lenght'];
                        $price = $working_time[0]['saturday_price'];
                        break;
                    case '7':
                        $slot_lenght = $working_time[0]['sunday_slot_lenght'];
                        $price = $working_time[0]['sunday_price'];
                        break;
                }
            }

            $slot[] = date('F d, Y H:i', $i) . "-" . date('H:i', ($i + $slot_lenght * 60));
        }
        $arr['slots'] = $slot;
        return $arr;
    }
    
    function saveInvoice($id){
        
        if (!empty($id)) {

            GzObject::loadFiles('Model', array('Invoice', 'Option'));
            $OptionModel = new OptionModel();
            $InvoiceModel = new InvoiceModel();
            
            $booking = $this->get($id);

            $opts = array();
            $opts['calendar_id'] = $booking['calendar_id'];
            $option_arr = $OptionModel->getAllPairValues($opts);

            $data = array();

            $data['invoice_number'] = Util::incrementalHash(10);
            $data['booking_id'] = $id;
            $data['booking_number'] = $booking['booking_number'];
            $data['title'] = $booking['title'];
            $data['first_name'] = $booking['first_name'];
            $data['second_name'] = $booking['second_name'];
            $data['phone'] = $booking['phone'];
            $data['email'] = $booking['email'];
            $data['company'] = $booking['company'];
            $data['address_1'] = $booking['address_1'];
            $data['address_2'] = $booking['address_2'];
            $data['city'] = $booking['city'];
            $data['state'] = $booking['state'];
            $data['zip'] = $booking['zip'];
            $data['country'] = $booking['country'];
            $data['fax'] = $booking['promo_code'];
            $data['male'] = $booking['male'];
             $data['additional'] = $booking['additional'];
            $data['status'] = $booking['status'];
            $data['amount'] = $booking['amount'];
            $data['discount'] = $booking['discount'];
            $data['total'] = $booking['total'];
            $data['calendar_price'] = $booking['calendars_price'];
            $data['tax'] = $booking['tax'];
            $data['security'] = $booking['security'];
            $data['deposit'] = $booking['deposit'];
            $data['payment_method'] = $booking['payment_method'];
            $data['invoice_company'] = $option_arr['invoice_company'];
            $data['invoice_name'] = $option_arr['invoice_name'];
            $data['invoice_address'] = $option_arr['invoice_address'];
            $data['invoice_city'] = $option_arr['invoice_city'];
            $data['invoice_state'] = $option_arr['invoice_state'];
            $data['invoice_zip'] = $option_arr['invoice_zip'];
            $data['invoice_fax'] = $option_arr['invoice_fax'];
            $data['invoice_phone'] = $option_arr['invoice_phone'];
            $data['invoice_email'] = $option_arr['invoice_email'];
            $data['slots'] = $option_arr['slots'];
            $invoice_id = $InvoiceModel->save($data);
            $invoice = $InvoiceModel->generateInvoice($invoice_id);

            $mpdf = new \Mpdf\Mpdf();
            $mpdf->WriteHTML($invoice);
            $name = 'booking_' . $id . '_invoice_' . $invoice_id . '.pdf';
            $mpdf->Output(INSTALL_PATH . UPLOAD_PATH . 'invoice/' . $name, 'F');

            $save = array();

            return $id;
        }
        
        return false;
    }

    function getAll($options = null, $column = null, $limit = null) {
        GzObject::loadFiles('Model', array('TimePrice', 'BookingSlot', 'Calendar', 'CustomDate'));
        $TimePriceModel = new TimePriceModel();
        $BookingSlotModel = new BookingSlotModel();
        $CalendarModel = new CalendarModel();
        $CustomDateModel = new CustomDateModel();
        
        $opts = array();
        $custom_dates = $CustomDateModel->getAll($opts);

        if (!empty($custom_dates)) {
            foreach ($custom_dates as $k => $v) {
                for($i = $v['timestamp']; $i <= $v['timestamp_end']; $i+=86400){
                    $custom_dates[$v['calendar_id']][mktime(0, 0, 0, date('n', $i), date('d', $i), date('Y', $i))] = $v;
                }
            }
        }
        
        $query = $this->from($this->getTable() . ' as t1');
        $query->select('t1.*, t2.user_id as user_id');
        $query->leftJoin($CalendarModel->getTable() . ' as t2 ON t2.id = t1.calendar_id');
        $query = $query->where($options);

        if (!empty($column)) {
            if (strpos($column, ' ')) {
                $query->orderBy($column);
            } else {
                $query->orderBy("`" . $column . "`");
            }
        }
        if (!empty($limit)) {
            $query->limit($limit);
        }
        /*
          $query->debug=true;
          echo $query->getQuery();
          print_r($query->getParameters());
          echo '<br />';
         */
        $arr = $query->fetchAll();

        $res = array();

        foreach ($arr as $key => $value) {
            $res[$key] = $value;
            $opts = array();

            $opts['booking_id'] = $value['id'];
            $slots = $BookingSlotModel->getAll($opts);
            $opts = array();
            $opts['calendar_id'] = $value['calendar_id'];
            $working_time = $TimePriceModel->getAll($opts, 'id');

            $slot = array();
            foreach ($slots as $k => $v) {
                $i = $v['timestamp'];
                $count = $v['count'];
                
                if(!empty($custom_dates[$value['calendar_id']][mktime(0, 0, 0, date('m', $i), date('d', $i), date('Y', $i))])){
                    $slot_lenght = $custom_dates[$value['calendar_id']][mktime(0, 0, 0, date('m', $i), date('d', $i), date('Y', $i))]['slot_lenght'];
                    $price = $custom_dates[$value['calendar_id']][mktime(0, 0, 0, date('m', $i), date('d', $i), date('Y', $i))]['price'];
                }else{

                    switch (date('N', $i)) {
                        case '1':
                            $slot_lenght = $working_time[0]['monday_slot_lenght'];
                            $price = $working_time[0]['monday_price'];
                            break;
                        case '2':
                            $slot_lenght = $working_time[0]['tuesday_slot_lenght'];
                            $price = $working_time[0]['tuesday_price'];
                            break;
                        case '3':
                            $slot_lenght = $working_time[0]['wednesday_slot_lenght'];
                            $price = $working_time[0]['wednesday_price'];
                            break;
                        case '4':
                            $slot_lenght = $working_time[0]['thursday_slot_lenght'];
                            $price = $working_time[0]['thursday_price'];
                            break;
                        case '5':
                            $slot_lenght = $working_time[0]['friday_slot_lenght'];
                            $price = $working_time[0]['friday_price'];
                            break;
                        case '6':
                            $slot_lenght = $working_time[0]['saturday_slot_lenght'];
                            $price = $working_time[0]['saturday_price'];
                            break;
                        case '7':
                            $slot_lenght = $working_time[0]['sunday_slot_lenght'];
                            $price = $working_time[0]['sunday_price'];
                            break;
                    }
                }

                $slot[] = date('m/d/Y H:i', $i) . "-" . date('H:i', ($i + $slot_lenght * 60)) . 'x' . $count;
            }
            $res[$key]['slots'] = $slot;
        }
        return $res;
    }
    function getMax(){
        $sql = 'SELECT booking_number FROM '.$this->getTable().' order by created  DESC LIMIT 1; ';
        
        $res = $this->execute($sql);
        
        if(!empty($res[0]['booking_number'])){
            return $res[0]['booking_number'];
        }else{
            return 0;
        }
    }

}

?>