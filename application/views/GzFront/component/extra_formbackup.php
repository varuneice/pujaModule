<form action="post" name="gz-time-slot-booking-form" id="gz-time-slot-booking-form-id">
    <div class="box box-solid box-primary">
        <div class="box-header">
              <h3 class="box-title"><strong><?php echo __('Time slot'); ?></strong></h3>
        </div>
        <div class="box-body">
            <table class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <th>
                            <?php echo __('date'); ?>
                        </th>
                        <th>
                            <?php echo __('start_time'); ?>
                        </th>
                        <th>
                            <?php echo __('end_time'); ?>
                        </th>
                        <th>
                            <?php echo __('prices'); ?>
                        </th>
                        <th>
                            <?php echo __('count'); ?>
                        </th>
                        <th>

                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($_SESSION[$this->controller->default_product]['slots'][$_REQUEST['cid']] as $i => $count) {
                        if ($count > 0) {
                            $date = strtotime(date("Y-m-d", $i));

                            if (!empty($tpl['custom_dates'][$date])) {
                                $slot_lenght = $tpl['custom_dates'][$date]['slot_lenght'];
                                $price = $tpl['custom_dates'][$date]['price'];
                            } else {

                                switch (date('N', $i)) {
                                    case '1':
                                        $slot_lenght = $tpl['working_time']['monday_slot_lenght'];

                                        if (!empty($tpl['custom_prices'][1][date('h:i', $i)])) {
                                            $price = $tpl['custom_prices'][1][date('h:i', $i)]['price'];
                                        } else {
                                            $price = $tpl['working_time']['monday_price'];
                                        }
                                        break;
                                    case '2':
                                        $slot_lenght = $tpl['working_time']['tuesday_slot_lenght'];

                                        if (!empty($tpl['custom_prices'][2][date('h:i', $i)])) {
                                            $price = $tpl['custom_prices'][2][date('h:i', $i)]['price'];
                                        } else {
                                            $price = $tpl['working_time']['tuesday_price'];
                                        }
                                        break;
                                    case '3':
                                        $slot_lenght = $tpl['working_time']['wednesday_slot_lenght'];

                                        if (!empty($tpl['custom_prices'][3][date('h:i', $i)])) {
                                            $price = $tpl['custom_prices'][3][date('h:i', $i)]['price'];
                                        } else {
                                            $price = $tpl['working_time']['wednesday_price'];
                                        }
                                        break;
                                    case '4':
                                        $slot_lenght = $tpl['working_time']['thursday_slot_lenght'];

                                        if (!empty($tpl['custom_prices'][4][date('h:i', $i)])) {
                                            $price = $tpl['custom_prices'][4][date('h:i', $i)]['price'];
                                        } else {
                                            $price = $tpl['working_time']['thursday_price'];
                                        }
                                        break;
                                    case '5':
                                        $slot_lenght = $tpl['working_time']['friday_slot_lenght'];

                                        if (!empty($tpl['custom_prices'][5][date('h:i', $i)])) {
                                            $price = $tpl['custom_prices'][5][date('h:i', $i)]['price'];
                                        } else {
                                            $price = $tpl['working_time']['friday_price'];
                                        }
                                        break;
                                    case '6':
                                        $slot_lenght = $tpl['working_time']['saturday_slot_lenght'];

                                        if (!empty($tpl['custom_prices'][6][date('h:i', $i)])) {
                                            $price = $tpl['custom_prices'][6][date('h:i', $i)]['price'];
                                        } else {
                                            $price = $tpl['working_time']['saturday_price'];
                                        }
                                        break;
                                    case '7':
                                        $slot_lenght = $tpl['working_time']['sunday_slot_lenght'];

                                        if (!empty($tpl['custom_prices'][7][date('h:i', $i)])) {
                                            $price = $tpl['custom_prices'][7][date('h:i', $i)]['price'];
                                        } else {
                                            $price = $tpl['working_time']['sunday_price'];
                                        }
                                        break;
                                }
                            }
                            ?>
                            <tr>
                                <td>
                                    <?php echo date($tpl['option_arr_values']['date_format'], $i); ?>
                                </td>
                                <td>
                                    <?php echo date($tpl['option_arr_values']['time_format'], $i); ?>
                                </td>
                                <td>
                                    <?php echo date($tpl['option_arr_values']['time_format'], ($i + $slot_lenght * 60)); ?>
                                </td>
                                <td>
                                    <?php echo Util::currenctFormat($tpl['option_arr_values']['currency'], $count * $price); ?>
                                </td>
                                <td>
                                    <?php echo $count ?>
                                </td>
                                <td>
                                    <a href="javascript:" data-date="<?php echo $date; ?>" data-start-time="<?php echo $i; ?>" class="gzRemoveTimeSlotClass fa fa-fw fa-minus-square"></a>
                                </td>
                            </tr>
                            <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="box box-solid box-primary">
        <div class="box-header">
            <h3 class="box-title"><strong><?php echo __('booking_details'); ?></strong></h3>
        </div>
        <div class="box-body">
            <?php if (empty($_POST['location']) && $tpl['prices']['calendars_price'] != 0) { ?>

               <div class="form-group" style="display:none;">
                    <label class="control-label" for=""><?php echo __('calendar_price'); ?>:</label>
                    <span id="calendars_price"><?php echo $tpl['prices']['formated_calendars_price']; ?></span>
                </div> 

                <div class="form-group">
                    <label class="control-label" for=""><?php echo __('total_price'); ?>:</label>
                    <span id="total"><?php echo $tpl['prices']['formated_total']; ?></span>
                </div>
                <?php
            } else {
                ?>
                <div class="form-group">
                    <label class="control-label">Location:</label>
                    <select data-rule-required='true' name="location" id="location" class="form-control input-sm" onchange="hideDiv(this)">
                        <option value="">Select location:</option>
                        <option value="inside">Inside Durgabari</option>
                        <option value="outside">Outside Durgabari</option>
                        <!-- <option value="online" data-subtext="">Online (ePuja)</option> -->
                    </select>
                </div>

                <div class="form-group" id="hide1">
                    <label class="control-label">Select Puja Type:</label>
                    <select data-rule-required='true' name="Puja" id="Puja" class="form-control input-sm"  onchange="populate(this.id)"  >
                        <option value="" data-subtext="">Select Puja Type</option>
                        <option value="21.00" data-subtext="">$21.00 ... Walk-in Puja</option>
                        <option value="101.00" data-subtext="">$101.00 ... Sankalpa Puja</option>
                        <option value="251.00" data-subtext="(Outside)">$251.00 ... Annaprasana</option>
                        <option value="201.00" data-subtext="(Inside Temple)">$201.00 ... Annaprasana</option>
                        <option value="51.00 " data-subtext="">$51.00 ... Anniversary</option>
                        <option value="201.00" data-subtext="">$201.00 ... Batsaric Sapindakaran</option>
                        <option value="51.00" data-subtext="">$51.00 ... Birthday</option>
                        <option value="151.00" data-subtext="">$151.00 ... Chaturthi Puja</option>
                        <option value="301.00" data-subtext="">$301.00 ... Funeral Service</option>
                        <option value="201.00" data-subtext="">$201.00 ... Grihaprabesh</option>
                        <option value="101.00 " data-subtext="">$101.00 ... ePuja</option>
                        <option value="101.00" data-subtext="">$101.00 ... Mahayagna</option>
                        <option value="701.00" data-subtext="(Inside Temple)">$701.00 ... Marriage</option>
                        <option value="1001.00" data-subtext="(Outside)">$1001.00 ... Marriage</option>
                        <option value="201.00" data-subtext="">$201.00 ... Nandimukh</option>
                        <option value="51.00" data-subtext="">$51.00 ... New Vehicle</option>
                        <option value="601.00 " data-subtext="">$601.00 ... Poita / Uponayan</option>
                        <option value="301.00" data-subtext="(Adya Sraddha)">$301.00 ... Sraddhanushthan</option>
                        <option value="251.00" data-subtext="">$251.00 ... Sponsoring Maha Pujas</option>
                        <option value="151.00" data-subtext="">$151.00 ... Sponsoring Pujas</option>
                        <option value="21.00 " data-subtext="">$21.00 ... Tarpan</option>
                        <option value="301.00" data-subtext="">$301.00 ... Wedding Engagement</option>
                        <option value="31.00" data-subtext="">$31.00 ... Sankalpa Puja (Special Occasion)</option>
                        </optgroup>
                    </select>
                </div>
                <div class="form-group" id="hide2" style="display:none;">
                    <label  class="control-label">Select Puja Type:</label>
                    <select data-rule-required='true' name="Puja2" id="Puja2" class="form-control input-sm" onchange="populate(this.id)" >
                        <option value="" data-subtext="">Select Puja Type</option>
                        <option value="29.00" data-subtext="">$29.00 ... Walk-in Puja</option>
                        <option value="141.00" data-subtext="">$141.00 ... Sankalpa Puja</option>
                        <option value="351.00" data-subtext="(Outside)">$351.00 ... Annaprasana</option>
                        <option value="281.00" data-subtext="(Inside Temple)">$281.00 ... Annaprasana</option>
                        <option value="70.00 " data-subtext="">$70.00 ... Anniversary</option>
                        <option value="281.00" data-subtext="">$281.00 ... Batsaric Sapindakaran</option>
                        <option value="70.00" data-subtext="">$70.00 ... Birthday</option>
                        <option value="211.00" data-subtext="">$211.00 ... Chaturthi Puja</option>
                        <option value="421.00" data-subtext="">$421.00 ... Funeral Service</option>
                        <option value="218.00" data-subtext="">$281.00 ... Grihaprabesh</option>
                        <option value="141.00 " data-subtext="">$141.00 ... ePuja</option>
                        <option value="141.00" data-subtext="">$141.00 ... Mahayagna</option>
                        <option value="981.00" data-subtext="(Inside Temple)">$981.00 ... Marriage</option>
                        <option value="1401.00" data-subtext="(Outside)">$1401.00 ... Marriage</option>
                        <option value="281.00" data-subtext="">$281.00 ... Nandimukh</option>
                        <option value="98.00" data-subtext="">$98.00 ... New Vehicle</option>
                        <option value="841.00 " data-subtext="">$841.00 ... Poita / Uponayan</option>
                        <option value="421.00" data-subtext="(Adya Sraddha)">$421.00 ... Sraddhanushthan</option>
                        <option value="351.00" data-subtext="">$351.00 ... Sponsoring Maha Pujas</option>
                        <option value="211.00" data-subtext="">$211.00 ... Sponsoring Pujas</option>
                        <option value="29.00 " data-subtext="">$29.00 ... Tarpan</option>
                        <option value="301.00" data-subtext="">$301.00 ... Wedding Engagement</option>
                        <option value="43.00" data-subtext="">$43.00 ... Sankalpa Puja (Special Occasion)</option>
                        </optgroup>
                    </select>
                </div>
              <div class="form-group" style="display:none;">
                    <label class="control-label" for=""><?php echo __('calendar_price'); ?>:</label>
                    <span id="calendars_price"><?php echo $tpl['prices']['formated_calendars_price']; ?></span>
                </div> 
                <div class="form-group">
                    <label class="control-label" for=""><?php echo __('total_price'); ?>:</label>
                    <span id="total"><?php echo $tpl['prices']['formated_total']; ?></span>
                </div>
                <?php
            }
            ?>
            <!-- <div class="form-group">
                    <label class="control-label" for="">YY<?php echo __('calendar_price'); ?>:</label>
                    <span id="calendars_price"><?php echo $tpl['prices']['formated_calendars_price']; ?></span>
                </div> 
               
                <div class="form-group">
                    <label class="control-label" for=""><?php echo __('total_price'); ?>:</label>
                    <span id="total"><?php echo $tpl['prices']['formated_total']; ?></span>
                </div> -->

        </div> 
    </div>
    <?php require 'booking_form.php'; ?>
    <div class="box box-solid box-primary">
        <div class="box-body">
            <?php
            foreach ($_POST as $name => $value) {
                if (!in_array($name, array('confirm_code', 'Puja', 'Puja2', 'location', 'extra_id', 'captcha', 'additional', 'payment_method', 'cc_type', 'cc_num', 'cc_code', 'cc_exp_year', 'cc_exp_month', 'fax', 'country', 'zip', 'state', 'address_2', 'address_1', 'company', 'email', 'phone', 'second_name', 'first_name', 'male', 'title'))) {
                    if (is_array($value)) {
                        foreach ($value as $k => $v) {
                            ?>
                            <input type="hidden" name="<?php echo $name; ?>[]" value="<?php echo $v ?>" />
                            <?php
                        }
                    } else {
                        ?>
                        <input type="hidden" name="<?php echo $name; ?>" value="<?php echo $value ?>" />
                        <?php
                    }
                }
            }
            ?>
            <a data-style="expand-left" href="javascript:" class="btn btn-default btn btn-danger ladda-button" id="back_to_calendar_id" autocomplete="off" value="<?php echo __('back'); ?>" name="back" tabindex="9" type="submit">
                <span class="ladda-label"><?php echo __('back'); ?></span>
                <span class="ladda-spinner"></span>
            </a>
            <a data-style="expand-left" href="javascript:" class="btn btn-warning ladda-button  <?php echo (!(count($_SESSION[$this->controller->default_product]['slots'][$_REQUEST['cid']]) > 0)) ? "disabled" : ""; ?>" id="details_frm_btn_id" autocomplete="off" value="<?php echo __('booking'); ?>" name="submit" tabindex="9" type="submit">
                <span class="ladda-label"><i class="fa fa-gavel"></i>&nbsp;&nbsp;&nbsp;<?php echo __('booking'); ?></span>
                <span class="ladda-spinner"></span>
            </a>
        </div>
    </div>
    <div id='div_session_write' name='div_session_write'></div>
</form>
<script>
    function hideDiv(elem) {

        if (elem.value == "inside") {
            document.getElementById('hide1').style.display = 'block';
            document.getElementById('hide2').style.display = "none";
        } else
        {
            document.getElementById('hide2').style.display = "block";
            document.getElementById('hide1').style.display = 'none';
        }
    }
    sessionStorage.setItem('EICEP', '');
    function populate(membership1)
    {

        var e = document.getElementById(membership1);
        var strUser = e.value;
        
        sessionStorage.setItem('EICEP', strUser);

    }

</script>