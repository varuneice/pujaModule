<section class="content-header">
    <h1>
        <?php echo __('Ticket'); ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo INSTALL_URL; ?>"><i class="fa fa-dashboard"></i>
                <?php echo __('home'); ?>
            </a></li>
        <li><a href="<?php echo INSTALL_URL; ?>Ticketadmin/index"><?php echo __('Ticket'); ?></a></li>
        <li class="active">
            <?php echo __('edit_ticket'); ?>
        </li>
    </ol>
</section>
<?php
require_once VIEWS_PATH . 'Layouts/admin/error_notice.php';
$state = $tpl['ticekteditarr']['state'];
$registermember = $tpl['ticekteditarr']['regmember'];

$paymethod = $tpl['ticekteditarr']['PaymentOption'];
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
$viewer =  $this->controller->isViewer();
?>
<form id="edit_" class="frm-class booking-frm-class" action="<?php echo INSTALL_URL; ?>Ticketadmin/edit/" method="post" name="edit">
    <div class="padding-19">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a data-toggle="tab" href="#tab_1">
                        <?php echo __('Ticket Data'); ?>
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
                                        <?php echo __('Member Details'); ?>
                                    </h3>
                                    <div class="box-tools pull-right">
                                        <button class="btn btn-primary btn-sm" data-widget="collapse"><i
                                                class="fa fa-minus"></i></button>
                                    </div>
                                </div>
                                <div class="box-body">
                                    <div class="form-group">
                                        <label class="control-label" for="first_name">
                                            <?php echo __('Member Name'); ?>:
                                        </label>
                                        <input id="first_name" class="form-control input-sm" type="text"
                                            name="name" size="25" value="<?php echo $tpl['ticekteditarr']['name']; ?>"
                                            title="Name" placeholder="Member Name" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="pujatype">
                                            <?php echo __('Puja Type'); ?>:
                                        </label>
                                        <input id="first_name" class="form-control input-sm" type="text"
                                            name="type" size="25"
                                            value="<?php echo $tpl['ticekteditarr']['type']; ?>" title="Puja Type"
                                            placeholder="" required readonly >
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label" for="tickettype">
                                            <?php echo __('Ticket Type'); ?>:
                                        </label>
                                    <input id="pujadata" class="form-control input-sm" type="text" name="tickettype"
                                            size="25" value="<?php echo $tpl['ticekteditarr']['tickettype']; ?>" title="Ticket Type"
                                            placeholder="" required readonly> 
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="phone">
                                            <?php echo __('phone'); ?>:
                                        </label>
                                        <input id="phone" class="form-control input-sm" type="text" name="tele"
                                            size="25" value="<?php echo $tpl['ticekteditarr']['tele']; ?>" title="phone"
                                            maxlength="10" placeholder="### ###-####" required onchange="checkphoneno(this.id)" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="AlternateConatct">
                                            <?php echo __('Alternate Conatct'); ?>:
                                        </label>
                                        <input id="alternateNumber" class="form-control input-sm" type="text" name="tele2"
                                            size="25" value="<?php echo $tpl['ticekteditarr']['tele2']; ?>" title="Alternate Number"
                                            maxlength="10" placeholder="### ###-####" required onchange="checkphoneno(this.id)" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="email">
                                            <?php echo __('email'); ?>:
                                        </label>
                                        <input id="phone" class="form-control input-sm" type="text" name="email"
                                            size="25" value="<?php echo $tpl['ticekteditarr']['email']; ?>" title="email"
                                            placeholder="name@company.com" pattern="[^@\s]+@[^@\s]+\.[^@\s]+" required >
                                    </div>
                                </div>
                                <div class="box box-solid box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">
                                        <?php echo __('Member Details'); ?>
                                    </h3>
                                    <div class="box-tools pull-right">
                                        <button class="btn btn-primary btn-sm" data-widget="collapse"><i
                                                class="fa fa-minus"></i></button>
                                    </div>
                                </div>
                                <div class="box-body">
                                <div class="form-group">
                                        <label class="control-label" for="paymentfor">
                                            <?php echo __('Registered in HDBS System'); ?>:
                                        </label>
                                        <!-- <input id="registeredmember" class="form-control input-sm" type="text" name="regmember"
                                            size="25" value="<?php echo $tpl['ticekteditarr']['regmember']; ?>"
                                            title="<?php echo __('Registered in HDBS System'); ?>" placeholder="" readonly> -->
                                    <select required="" name="regmember" id="registrationmember"
                                        class="form-control input-sm" aria-required="true" aria-invalid="false" disabled="">
                                        <option value="">Please select Member type</option>
                                        <option value="member">Yes</option>
                                        <option value="nonmember">No</option>
                                    </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="paymentfor">
                                            <?php echo __('Member Id'); ?>:
                                        </label>
                                        <input id="memberid" class="form-control input-sm" type="text" name="Member_id"
                                            size="25" value="<?php echo $tpl['ticekteditarr']['Member_id']; ?>"
                                            title="<?php echo __('Member Id'); ?>" placeholder="" readonly>
                                    </div>
                                    <div class="form-group">
                                            <label class="control-label" for="status">
                                                <?php echo __('Status'); ?>:
                                            </label>
                                            <?php if ($this->controller->isAdmin() || $this->controller->isEditor()) { ?>
                                            <select data-rule-required="true" name="status" id="status"
                                                class="form-control input-sm">
                                                <option value="">---</option>
                                                <?php
                                                $status_arr = __('status_arr');
                                                foreach ($status_arr as $k => $v) {
                                                    ?>
                                                    <option <?php echo ($tpl['ticekteditarr']['status'] == $k) ? "selected='selected'" : ""; ?> value="<?php echo $k; ?>"><?php echo $v; ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                            <?php } ?> 
                                            <?php if ($this->controller->isViewer()) { ?>
                                            <input id="status" class="form-control input-sm" type="text" name="status" size="25" value="<?php echo $tpl['ticekteditarr']['status']; ?>" title="<?php echo __('status'); ?>" placeholder="Status" readonly>
                                            <?php } ?> 
                                        </div>
                                    
                                </div>
                            <div class="box box-solid box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">
                                        <?php echo __('Price Details'); ?>
                                    </h3>
                                    <div class="box-tools pull-right">
                                        <button class="btn btn-primary btn-sm" data-widget="collapse"><i
                                                class="fa fa-minus"></i></button>
                                    </div>
                                </div>
                                <div class="box-body">
                                <div class="form-group">
                                        <label class="control-label" for="membertype">
                                            <?php echo __('Additional Adult'); ?>:
                                        </label>
                                        <input id="quantity" class="form-control input-sm" type="number"
                                            name="numberofadults" size="25" min="1" oninput="validity.valid||(value='');"
                                            value="<?php echo $tpl['ticekteditarr']['numberofadults']; ?>"
                                            title="<?php echo __('Additional Adult'); ?>" placeholder=""  onChange="ticketqunatity()" readonly>
                                    </div>
                                         <div class="form-group" style="display:none;">
                                        <label class="control-label" for="membertype">
                                            <?php echo __('Additional Child'); ?>:
                                        </label>
                                        <input id="quantity" class="form-control input-sm" type="number"
                                            name="numberofchilds" size="25" min="1" oninput="validity.valid||(value='');"
                                            value="<?php echo $tpl['ticekteditarr']['numberofchilds']; ?>"
                                            title="<?php echo __('Additional Child'); ?>" placeholder=""  onChange="ticketqunatity()">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="totalamount">
                                            <?php echo __('Total Amount'); ?>:
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <?php echo Util::getCurrensySimbol($tpl['option_arr_values']['currency']); ?>
                                            </span>
                                            <input id="totalamount" class="form-control input-sm" type="number"
                                                name="item_cost" size="25"
                                                value="<?php echo $tpl['ticekteditarr']['item_cost']; ?>"
                                                title="<?php echo __('totalamount'); ?>" placeholder="Total Amount"
                                                readonly>
                                        </div>
                                    </div>
                                </div>
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
                                    </div>
                                    </div>

                        </section>
<!-- start #state -->

<section class="col-lg-5 connectedSortable ui-sortable">
                            <div class="box box-solid box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">
                                        <?php echo __('Additional Adult Names'); ?>
                                    </h3>
                                    <div class="box-tools pull-right">
                                        <button class="btn btn-primary btn-sm" data-widget="collapse"><i
                                                class="fa fa-minus"></i></button>
                                    </div>
                                </div>
                                <div class="box-body">
                                <div class="form-group">
                                        <label class="control-label" for="paymentfor">
                                            <?php echo __('Adult 1 Full Name'); ?>:
                                        </label>
                                        <input id="spousename" class="form-control input-sm" type="text" name="adult1_fname"
                                            size="25" value="<?php echo $tpl['ticekteditarr']['adult1_fname']; ?>"
                                            title="<?php echo __('Adult 1 Full Name'); ?>" placeholder="" >
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="paymentfor">
                                            <?php echo __('Adult 2 Full Name'); ?>:
                                        </label>
                                        <input id="child1" class="form-control input-sm" type="text" name="adult2_fname"
                                            size="25" value="<?php echo $tpl['ticekteditarr']['adult2_fname']; ?>"
                                            title="<?php echo __('Adult 2 Full Name'); ?>" placeholder="" >
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="paymentfor">
                                            <?php echo __('Adult 3 Full Name'); ?>:
                                        </label>
                                        <input id="dobchild1" class="form-control input-sm" type="text" name="adult3_fname"
                                            size="25" value="<?php echo $tpl['ticekteditarr']['adult3_fname']; ?>"
                                            title="<?php echo __('Adult 3 Full Name'); ?>" placeholder="" >
                                    </div>
                                    <div class="form-group">
                                            <label class="control-label" for="status">
                                                <?php echo __('Adult 4 Full Name'); ?>:
                                            </label>
                                            <input id="child2" class="form-control input-sm" type="text" name="adult4_fname"
                                            size="25" value="<?php echo $tpl['ticekteditarr']['adult4_fname']; ?>"
                                            title="<?php echo __('Adult 4 Full Name'); ?>" placeholder="" >
                                        </div>

                                        <div class="form-group" style="display:none;">
                                        <label class="control-label" for="paymentfor">
                                            <?php echo __('Child 1 Full Name'); ?>:
                                        </label>
                                        <input id="dobchild2" class="form-control input-sm" type="text" name="child1_fname"
                                            size="25" value="<?php echo $tpl['ticekteditarr']['child1_fname']; ?>"
                                            title="<?php echo __('Child 1 Full Name'); ?>" placeholder="" >
                                    </div>
                                        <div class="form-group" style="display:none;">
                                            <label class="control-label" for="status">
                                                <?php echo __('Child 2 Full Name'); ?>:
                                            </label>
                                            <input id="child3" class="form-control input-sm" type="text" name="child2_fname"
                                            size="25" value="<?php echo $tpl['ticekteditarr']['child2_fname']; ?>"
                                            title="<?php echo __('Child 2 Full Name'); ?>" placeholder="" >
                                        </div>
                                        <div class="form-group" style="display:none;">
                                        <label class="control-label" for="paymentfor">
                                            <?php echo __('Child 3 Full Name'); ?>:
                                        </label>
                                        <input id="dobchild3" class="form-control input-sm" type="text" name="child3_fname"
                                            size="25" value="<?php echo $tpl['ticekteditarr']['child3_fname']; ?>"
                                            title="<?php echo __('Child 3 Full Name'); ?>" placeholder="" >
                                    </div>
                                   
                                  
                                </div>
                        </section>

<!-- end -->


                        <section class="col-lg-5 connectedSortable ui-sortable">
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
                                            size="25" value="<?php echo $tpl['ticekteditarr']['street']; ?>" title="Address"
                                            placeholder="" required >
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="address_1">
                                            <?php echo __('Address'); ?>:
                                        </label>
                                        <input id="address_1" class="form-control input-sm" type="text" name="address"
                                            size="25" value="<?php echo $tpl['ticekteditarr']['address']; ?>" title="Address"
                                            placeholder="" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="city">
                                            <?php echo __('City'); ?>:
                                        </label>
                                        <input id="city" class="form-control input-sm" type="text" name="city" size="25"
                                            value="<?php echo $tpl['ticekteditarr']['city']; ?>" title="<?php echo __('City'); ?>"
                                            placeholder="" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="state">
                                            <?php echo __('State'); ?>:
                                        </label>
                                        <input id="state" class="form-control input-sm" type="text" name="state" size="25" value="<?php echo $tpl['ticekteditarr']['state']; ?>" title="<?php echo __('State'); ?>" placeholder="">
                                        
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label" for="membertype">
                                            <?php echo __('Zip'); ?>:
                                        </label>
                                        <input id="zip" class="form-control input-sm" type="text" name="zip" size="25"
                                            value="<?php echo $tpl['ticekteditarr']['zip']; ?>"
                                            title="<?php echo __('Zip_Code'); ?>" placeholder="" required>
                                    </div>
                                    <!-- <div class="form-group">
                                        <label class="control-label" for="parentcountry">
                                            <?php echo __('Parents Base Country'); ?>:
                                        </label>
                                        <input id="zip" class="form-control input-sm" type="text" name="country" size="25"
                                            value="<?php echo $tpl['ticekteditarr']['country']; ?>"
                                            title="<?php echo __('Parents Base Country'); ?>" placeholder="">
                                    </div> -->
                                </div>
                        </section>
                    </fieldset>
                </div>

                <fieldset class="form-actions">
                    <input type="hidden" name="edit_ticketdata" value="1" />
                    <input type="hidden" name="id" value="<?php echo $tpl['ticekteditarr']['id']; ?>" />
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
        ticketpayfor();
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

    function ticketqunatity() {

        var ticketprice = $("#ticketamount").val();
        var titketquantity = $("#quantity").val();
        $("#totalamount").val("");
        if (ticketprice != null && titketquantity >= 1) {
            //
            var finalamount = ticketprice * titketquantity;
            document.getElementById("totalamount").value = finalamount;

        }
    }

    // function for phone no validation
    function checkphoneno(elem) {
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

 
// family div condition 
function ticketpayfor() {
    
    var tickettype = $("#pujadata").val();
    if(tickettype == 'individual'){
        $("#spousename").prop('readonly', true);
        $("#child1").prop('readonly', true);
        $("#dobchild1").prop('readonly', true);
        $("#child2").prop('readonly', true);
        $("#dobchild2").prop('readonly', true);
        $("#child3").prop('readonly', true);
        $("#dobchild3").prop('readonly', true);
        $("#parent1").prop('readonly', true);
        $("#parent2").prop('readonly', true);
    }
    if(tickettype == 'family'){
        $("#spousename").prop('readonly', false);
        $("#child1").prop('readonly', false);
        $("#dobchild1").prop('readonly', false);
        $("#child2").prop('readonly', false);
        $("#dobchild2").prop('readonly', false);
        $("#child3").prop('readonly', false);
        $("#dobchild3").prop('readonly', false);
        $("#parent1").prop('readonly', false);
        $("#parent2").prop('readonly', false); 
    }
}
</script>