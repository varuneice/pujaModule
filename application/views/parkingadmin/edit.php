<section class="content-header">
    <h1>
        <?php echo __('Paid Parking Registration'); ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo INSTALL_URL; ?>"><i class="fa fa-dashboard"></i>
                <?php echo __('home'); ?>
            </a></li>
        <li><a href="<?php echo INSTALL_URL; ?>parkingadmin/index"><?php echo __('Paid Parking Registration'); ?></a></li>
        <li class="active">
            <?php echo __('Paid Parking Registration'); ?>
        </li>
    </ol>
</section>
<?php
require_once VIEWS_PATH . 'Layouts/admin/error_notice.php';

$status = $tpl['parkingarr']['status'];
$paymethod = $tpl['parkingarr']['PaymentOption'];
if ($paymethod == 'stripe') {
    $paymentdata = 'Credit Card';
} else if ($paymethod == "others") {
    $paymentdata = 'Zelle';
} else if ($paymethod == "cash") {
    $paymentdata = 'Cash';
} else if ($paymethod == "check") {
    $paymentdata = 'Check';
} else if ($paymethod == "directdeposit") {
    $paymentdata = 'Direct Deposit';
}
$viewer = $this->controller->isViewer();
$levelThree = $this->controller->isAdmin();
?>
<form id="edit_sankalpapuja" class="frm-class booking-frm-class" action="<?php echo INSTALL_URL; ?>parkingadmin/edit"
    method="post" name="create">
    <div class="padding-19">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a data-toggle="tab" href="#tab_1">
                        <?php echo __('Registration Data'); ?>
                    </a>
                </li>
            </ul>
            <div class="tab-content">
                <div id="tab_1" class="tab-pane active">
                    <fieldset>
                        <section class="col-lg-7 connectedSortable">
                            <div class="box box-solid box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">
                                        <?php echo __('Information'); ?>
                                    </h3>
                                    <div class="box-tools pull-right">
                                        <button class="btn btn-primary btn-sm" data-widget="collapse"><i
                                                class="fa fa-minus"></i></button>
                                    </div>
                                </div>
                                <div class="box-body">
                                    <div class="form-group">
                                        <label class="control-label" for="registrationfor">
                                            <?php echo __('Puja Type'); ?>:
                                        </label>
                                        <input id="registrationfor" class="form-control input-sm" type="text"
                                            name="puja_type" size="25"
                                            value="<?php echo $tpl['parkingarr']['puja_type']; ?>" title="Registration Type"
                                            placeholder="" required readonly >
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label" for="memberid">
                                            <?php echo __('Member Id'); ?>:
                                        </label>
                                        <input id="memberid" class="form-control input-sm" type="text" name="Member_id"
                                            size="25" value="<?php echo $tpl['parkingarr']['Member_id']; ?>" title="Member Id"
                                             placeholder="Member ID" required readonly>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label" for="category">
                                            <?php echo __('Category'); ?>:
                                        </label>
                                    <input id="category" class="form-control input-sm" type="text" name="membercategory"
                                            size="25" value="<?php echo $tpl['parkingarr']['membercategory']; ?>" title="Category"
                                            placeholder="" required readonly> 
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label" for="memberid">
                                            <?php echo __('Parking Spot'); ?>:
                                        </label>
                                        <input id="parkingspot" class="form-control input-sm" type="text" name="parkingfield"
                                            size="25" value="<?php echo $tpl['parkingarr']['parkingfield']; ?>" title="Parking Spot"
                                             placeholder="Parking Spot" required readonly>
                                    </div>

                                </div>
                                <div class="box box-solid box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">
                                        <?php echo __('Amount'); ?>
                                    </h3>
                                    <div class="box-tools pull-right">
                                        <button class="btn btn-primary btn-sm" data-widget="collapse"><i
                                                class="fa fa-minus"></i></button>
                                    </div>
                                </div>
                                <div class="box-body">
                                    <div class="form-group">
                                        <label class="control-label" for="amount">
                                            <?php echo __('Amount'); ?>:
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <?php echo Util::getCurrensySimbol($tpl['option_arr_values']['currency']); ?>
                                            </span>
                                            <input data-rule-required="true" id="advanceamount"
                                                class="form-control input-sm" type="text" name="amount" size="25"
                                                value="<?php echo $tpl['parkingarr']['amount']; ?>"
                                                title="Amount" placeholder="Amount" readonly>
                                        </div>
                                    </div>
                                    
                                </div>
                                <!-- items div end -->
                                <!-- status div start -->
                            <div class="box box-solid box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">
                                        <?php echo __('Satus'); ?>
                                    </h3>
                                    <div class="box-tools pull-right">
                                        <button class="btn btn-primary btn-sm" data-widget="collapse"><i
                                                class="fa fa-minus"></i></button>
                                    </div>
                                </div>
                                <div class="box-body">
                                    <div class="form-group">
                                          <label class="control-label" for="status">
                                                <?php echo __('Status'); ?>:
                                            </label>
                                            <?php if ($this->controller->isAdmin() || $this->controller->isEditor()) { ?>
                                            <select data-rule-required="true" name="status" id="status"
                                                class="form-control input-sm" onchange="registrationcancel(this.id)">
                                                <option value="">---</option>
                                                <?php
                                                $status_arr = __('status_arr');
                                                foreach ($status_arr as $k => $v) {
                                                    ?>
                                                    <option <?php echo ($tpl['parkingarr']['status'] == $k) ? "selected='selected'" : ""; ?> value="<?php echo $k; ?>"><?php echo $v; ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                            <?php } ?> 
                                            <?php if ($this->controller->isViewer()) { ?>
                                            <input id="status" class="form-control input-sm" type="text" name="status" size="25" value="<?php echo $tpl['parkingarr']['status']; ?>" title="<?php echo __('status'); ?>" placeholder="Status" readonly>
                                            <?php } ?> 
                                           </div>

                                           <div class="form-group" style="display:none;" id="cancelremarks">
                                            <textarea name="remarks" class="form-control" placeholder="Cancelled Remarks"><?php echo $tpl['parkingarr']['remarks']; ?></textarea>
                                          </div>
                                    </div>

<!-- document div start -->    
                            <div class="box box-solid box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">
                                        <?php echo __('Payment Method'); ?>
                                    </h3>
                                    <div class="box-tools pull-right">
                                        <button class="btn btn-primary btn-sm" data-widget="collapse"><i
                                                class="fa fa-minus"></i></button>
                                    </div>
                                </div>
                                <div class="box-body">
                                <div class="form-group">
                                        <label class="control-label" for="payment_method"><?php echo __('payment_method'); ?>:</label>
                                        <input data-rule-required="true" id="paymentmethod" class="form-control input-sm" type="text" name="PaymentOption" size="25" value="<?php echo $paymentdata; ?>" title="Payment Method" readonly >
                                    </div>
                               
                                    
                        </section>
<!-- start #state -->

<section class="col-lg-5 connectedSortable ui-sortable">
                            <div class="box box-solid box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">
                                        <?php echo __('Family Details'); ?>
                                    </h3>
                                    <div class="box-tools pull-right">
                                        <button class="btn btn-primary btn-sm" data-widget="collapse"><i
                                                class="fa fa-minus"></i></button>
                                    </div>
                                </div>
                                <div class="box-body">
                                <div class="form-group" id="seniorseventyabove">
                                        <label class="control-label" for="paymentfor">
                                            <?php echo __('Member Name'); ?>: &nbsp;&nbsp;&nbsp;&nbsp;
                                            <!--<input style="visibility: visible;margin: 34px 0px 0px 4px;" class="checkbox" type="checkbox" id="senior" <?php //echo ($tpl['parkingarr']['senior'] == '1') ? "checked='checked'" : ""; ?> name="senior" value="1" onchange="calculateseniordiscount(this)">
                                              <label for="senior" style="color:red;">if Senior</label>-->

                                            <input style="visibility: visible;margin: 34px 0px 0px 4px;" class="checkbox" type="checkbox" id="veggie" <?php echo ($tpl['parkingarr']['seniorseventyplus'] == 'yes') ? "checked='checked'" : ""; ?> name="seniorseventyplus" value="yes">
                                             <label for="seniorseventyabove" style="color:red;">if Senior 70+</label>&nbsp;&nbsp;&nbsp;&nbsp;

                                             
                                        </label>
                                        <input id="membername" class="form-control input-sm" type="text" name="First_name"
                                            size="25" value="<?php echo $tpl['parkingarr']['First_name']; ?>"
                                            title="<?php echo __('First Name'); ?>" placeholder="" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="memberlastname">
                                            <?php echo __('Last Name'); ?>: &nbsp;&nbsp;&nbsp;&nbsp; 
                                        </label>
                                        <input id="membername" class="form-control input-sm" type="text" name="Last_name"
                                            size="25" value="<?php echo $tpl['parkingarr']['Last_name']; ?>"
                                            title="<?php echo __('Last Name'); ?>" placeholder="" readonly>
                                    </div>


                                    <?php if ($tpl['parkingarr']['Sp_fname'] !="")  { ?>
                                <div class="form-group">
                                        <label class="control-label" for="paymentfor">
                                            <?php echo __('Spouse Name'); ?>
                                           
                                        </label>
                                        <input id="spousename" class="form-control input-sm" type="text" name="spousename"
                                            size="25" value="<?php echo $tpl['parkingarr']['Sp_fname']. ' ' . $tpl['parkingarr']['Sp_lname']; ?>"
                                            title="<?php echo __('Spouse Name'); ?>" placeholder="" readonly>
                                    </div>
                                    <?php
                                      } ?>
                                </div>
                        </section>
<!-- end -->
                        <section class="col-lg-5 connectedSortable ui-sortable" style="float:right;">
                            <div class="box box-solid box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">
                                        <?php echo __('Address details'); ?>
                                    </h3>
                                    <div class="box-tools pull-right">
                                        <button class="btn btn-primary btn-sm" data-widget="collapse"><i
                                                class="fa fa-minus"></i></button>
                                    </div>
                                </div>
                                <div class="box-body">
                                    

                                    <div class="form-group">
                                        <label class="control-label" for="street">
                                            <?php echo __('Street No'); ?>:
                                        </label>
                                        <input id="street" class="form-control input-sm" type="text" name="street"
                                            size="25" value="<?php echo $tpl['parkingarr']['street']; ?>" title="Address"
                                            placeholder="" required readonly>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="streetname">
                                            <?php echo __('Street Name'); ?>:
                                        </label>
                                        <input id="streetname" class="form-control input-sm" type="text" name="streetname"
                                            size="25" value="<?php echo $tpl['parkingarr']['streetname']; ?>" title="Address"
                                            placeholder="" required readonly>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="unit">
                                            <?php echo __('Unit'); ?>:
                                        </label>
                                        <input id="unit" class="form-control input-sm" type="text" name="unit"
                                            size="25" value="<?php echo $tpl['parkingarr']['unit']; ?>" title="Address"
                                            placeholder="" required readonly>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="city">
                                            <?php echo __('City'); ?>:
                                        </label>
                                        <input id="city" class="form-control input-sm" type="text" name="city" size="25"
                                            value="<?php echo $tpl['parkingarr']['city']; ?>" title="<?php echo __('City'); ?>"
                                            placeholder="" required readonly>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="state">
                                            <?php echo __('State'); ?>:
                                        </label>
                                      <input id="state" class="form-control input-sm" type="text" name="state" size="25" value="<?php echo $tpl['parkingarr']['state']; ?>" title="<?php echo __('State'); ?>" placeholder="" readonly>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label" for="membertype">
                                            <?php echo __('Zip'); ?>:
                                        </label>
                                        <input id="zip" class="form-control input-sm" type="text" name="zip" size="25"
                                            value="<?php echo $tpl['parkingarr']['zip']; ?>"
                                            title="<?php echo __('Zip_Code'); ?>" placeholder="" required readonly>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="phone">
                                            <?php echo __('phone'); ?>:
                                        </label>
                                        <input id="phone" class="form-control input-sm" type="text" name="phone"
                                            size="25" value="<?php echo $tpl['parkingarr']['phone']; ?>" title="phone"
                                            maxlength="10" placeholder="### ###-####" required readonly>
                                    </div>
                                    <?php if ($tpl['parkingarr']['alternatenumber'] !="")  { ?>
                                    <div class="form-group">
                                        <label class="control-label" for="phone">
                                            <?php echo __('Alternate Conatct'); ?>:
                                        </label>
                                        <input id="phone" class="form-control input-sm" type="text" name="alternatenumber"
                                            size="25" value="<?php echo $tpl['parkingarr']['alternatenumber']; ?>" title="Alternate Conatct"
                                            maxlength="10" placeholder="### ###-####" required readonly>
                                    </div>
                                    <?php
                                      } ?>
                                    <div class="form-group">
                                        <label class="control-label" for="email">
                                            <?php echo __('email'); ?>:
                                        </label>
                                        <input id="phone" class="form-control input-sm" type="text" name="email"
                                            size="25" value="<?php echo $tpl['parkingarr']['email']; ?>" title="email"
                                            placeholder="name@company.com" pattern="[^@\s]+@[^@\s]+\.[^@\s]+" required readonly>
                                    </div>
                                    <?php if ($tpl['parkingarr']['alternateemail'] !="")  { ?>
                                    <div class="form-group">
                                        <label class="control-label" for="email">
                                            <?php echo __('Alternate Email'); ?>:
                                        </label>
                                        <input id="phone" class="form-control input-sm" type="text" name="alternateemail"
                                            size="25" value="<?php echo $tpl['parkingarr']['alternateemail']; ?>" title="Alternate Email"
                                            placeholder="name@company.com" pattern="[^@\s]+@[^@\s]+\.[^@\s]+" required readonly>
                                    </div>
                                    <?php
                                      } ?>
                                </div>
                        </section>
                    </fieldset>
                </div>

                <fieldset class="form-actions">
                    <input type="hidden" name="edit_parkingregistrationdata" value="1" />
                    <input type="hidden" name="id" value="<?php echo $tpl['parkingarr']['id']; ?>" />
                    <input type="hidden" name="regmember" value="<?php echo $tpl['parkingarr']['regmember']; ?>" />
                    <button id="submit" class="btn btn-primary" autocomplete="off" value="Submit" name="submit"
                        tabindex="9" type="submit"><i class="fa fa-fw fa-save"></i>&nbsp;&nbsp;
                        <?php echo __('save'); ?>
                    </button>
                </fieldset>

            </div>
        </div>
    </div>
</form>
<div id="dialogSlots" title="<?php echo __('tooltip_selected_slots'); ?>" style="display:none">
    <div name="dialogSlotsDivId" id="dialogSlotsDivId">
    </div>
</div>
<script>

    $(document).ready(function () {
        var reg = <?php echo(json_encode($viewer)); ?>;
    if(reg==true){  
       $("input").attr("disabled", "disabled");
       $("#submit").attr("disabled", "disabled");      
      }
        statedrop();
        checkmember();
        registrationcancel();
        markReadonlySeventyCheck();
    });
    var state = <?php echo (json_encode($state)); ?>;
    function statedrop() {
        if (state != null || state == "" || state == " ") {
            $("#state").val(state);

        }
    }

    var memberregister = <?php echo (json_encode($registermember)); ?>;
    function checkmember() {
        if (memberregister != null || memberregister == "" || memberregister == " ") {
            $("#registrationmember").val(memberregister);

        }
    }

    function markReadonlySeventyCheck(){
       const leverThreeAdmin = <?php echo json_encode($levelThree); ?>;
        if (leverThreeAdmin == false) {
            document.querySelector('#seniorseventyabove').setAttribute('style','pointer-events: none'); 
        } 
    }

    // function for phone no validation
    function checkphoneno(elem) {
        //
        const phonenumber = $("#phone").val();
        if (!!phonenumber) {
            if (isNaN(phonenumber)) {
                alert("Please Enter mobile Number");
                $("#submit").addClass('disabled');
            }
            else if (phonenumber.length > 10) {
                alert("Number should be 10 digits");
                $("#submit").addClass('disabled');
            }
            else if (phonenumber.length < 10) {
                alert("Number should be 10 digits");
                $("#submit").addClass('disabled');
            }
            else if (phonenumber.length == 10) {
                $("#submit").removeClass('disabled');
            }
            else {
                $("#submit").removeClass('disabled');
            }
        }
        else {
            $("#phone").prop('required', true);
            $("#submit").removeClass('disabled');
        }
    }
     
    
    function registrationcancel(){
        var regstatus = <?php echo(json_encode($status)); ?>;
        var currrentstatus = $("#status").val();
        if(currrentstatus == 'cancelled' || regstatus == 'cancelled'){
            $('#cancelremarks').show();
        }
        else{
            $('#cancelremarks').hide();
        }
    }
</script>