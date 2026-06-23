<section class="content-header">
    <h1>
        <?php echo __('Puja Passes'); ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo INSTALL_URL; ?>"><i class="fa fa-dashboard"></i>
                <?php echo __('home'); ?>
            </a></li>
        <li><a href="<?php echo INSTALL_URL; ?>PujaPassesadmin/index"><?php echo __('Puja Passes'); ?></a></li>
        <li class="active">
            <?php echo __('Puja Passes'); ?>
        </li>
    </ol>
</section>
<?php
require_once VIEWS_PATH . 'Layouts/admin/error_notice.php';
$state = $tpl['pujadataarr']['state'];
$registermember = $tpl['pujadataarr']['regmember'];
$status = $tpl['pujadataarr']['status'];
$paymethod = $tpl['pujadataarr']['PaymentOption'];
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

$document = $tpl['pujadataarr']['studentavatar'];
$newfileextension =  explode(".",$document);
$filetype =  strtolower($newfileextension[1]);

$viewer =  $this->controller->isViewer();
?>
<form id="edit_pujapassesdata" class="frm-class booking-frm-class" action="<?php echo INSTALL_URL; ?>PujaPassesadmin/edit"
    method="post" name="create">
    <div class="padding-19">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a data-toggle="tab" href="#tab_1">
                        <?php echo __('Passes Data'); ?>
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
                                        <?php echo __('Member Information'); ?>
                                    </h3>
                                    <div class="box-tools pull-right">
                                        <button class="btn btn-primary btn-sm" data-widget="collapse"><i
                                                class="fa fa-minus"></i></button>
                                    </div>
                                </div>
                                <div class="box-body">
                                     <div class="form-group">
                                        <label class="control-label" for="paymentfor">
                                            <?php echo __('Member Name'); ?>:
                                        </label>
                                        <input id="membername" class="form-control input-sm" type="text" name="membername"
                                            size="25" value="<?php echo $tpl['pujadataarr']['First_name']. ' ' . $tpl['pujadataarr']['Last_name']; ?>"
                                            title="<?php echo __('Member Name'); ?>" placeholder="" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="registrationfor">
                                            <?php echo __('Member Status'); ?>:
                                        </label>
                                        <input id="registrationfor" class="form-control input-sm" type="text"
                                            name="registration_for" size="25"
                                            value="<?php echo $tpl['pujadataarr']['member_status']; ?>" title="Member Status"
                                            placeholder="" required readonly >
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label" for="registrationfor">
                                            <?php echo __('Student'); ?>:
                                        </label>
                                        <input id="registrationfor" class="form-control input-sm" type="text"
                                            name="registration_for" size="25"
                                            value="<?php echo $tpl['pujadataarr']['Student']; ?>" title="Student Status"
                                            placeholder="" required readonly >
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label" for="registrationfor">
                                            <?php echo __('Out of Towner'); ?>:
                                        </label>
                                        <input id="registrationfor" class="form-control input-sm" type="text"
                                            name="registration_for" size="25"
                                            value="<?php echo $tpl['pujadataarr']['outoftowner']; ?>" title="Out of Towner Status"
                                            placeholder="" required readonly >
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label" for="memberid">
                                            <?php echo __('Member Id'); ?>:
                                        </label>
                                        <input id="memberid" class="form-control input-sm" type="text" name="Member_id"
                                            size="25" value="<?php echo $tpl['pujadataarr']['Member_id']; ?>" title="Member Id"
                                            maxlength="10" placeholder="Member ID" required readonly>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label" for="memberid">
                                            <?php echo __('Member Category'); ?>:
                                        </label>
                                        <input id="memberid" class="form-control input-sm" type="text" name="Member_id"
                                            size="25" value="<?php echo $tpl['pujadataarr']['membercategory']; ?>" title="Member Category"
                                            maxlength="10" placeholder="Member ID" required readonly>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label" for="memberid">
                                            <?php echo __('Member Type'); ?>:
                                        </label>
                                        <input id="memberid" class="form-control input-sm" type="text" name="Member_id"
                                            size="25" value="<?php echo $tpl['pujadataarr']['Member_type']; ?>" title="Member Type"
                                            maxlength="10" placeholder="Member ID" required readonly>
                                    </div>
                                 
                                   

                             
                                </div>
                                <div class="box box-solid box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">
                                        <?php echo __('Items'); ?>
                                    </h3>
                                    <div class="box-tools pull-right">
                                        <button class="btn btn-primary btn-sm" data-widget="collapse"><i
                                                class="fa fa-minus"></i></button>
                                    </div>
                                </div>
                                <div class="box-body">

                                     <div class="form-group">
                                        <label class="control-label" for="category">
                                            <?php echo __('Puja Name, Day & Time'); ?>:
                                        </label>
                                    <input id="category" class="form-control input-sm" type="text" name="category"
                                            size="25" value="<?php echo $tpl['pujadataarr']['puja_type']; ?>" title="Mode of Collection"
                                            placeholder="" required readonly> 
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
                                                name="totalamount" size="25"
                                                value="<?php echo $tpl['pujadataarr']['totalamount']; ?>"
                                                title="<?php echo __('totalamount'); ?>" placeholder="Total Amount"
                                                readonly>
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
                                                class="form-control input-sm" onchange="magazinecancel(this.id)">
                                                <option value="">---</option>
                                                <?php
                                                $status_arr = __('status_arr');
                                                foreach ($status_arr as $k => $v) {
                                                    ?>
                                                    <option <?php echo ($tpl['pujadataarr']['status'] == $k) ? "selected='selected'" : ""; ?> value="<?php echo $k; ?>"><?php echo $v; ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                             <?php } ?> 
                                            <?php if ($this->controller->isViewer()) { ?>
                                            <input id="status" class="form-control input-sm" type="text" name="status" size="25" value="<?php echo $tpl['pujadataarr']['status']; ?>" title="<?php echo __('status'); ?>" placeholder="Status" readonly>
                                            <?php } ?> 
                                           </div>

                                           <div class="form-group" style="display:none;" id="cancelremarks">
                                            <!-- <input id="regcancel" class="form-control input-sm" type="text" name="remarks"
                                            size="25" value="<?php echo $tpl['pujadataarr']['remarks']; ?>"
                                            title="<?php echo __('Cancelation Remarks'); ?>" placeholder="Cancelation Remarks" > -->
                                            <textarea name="remarks" class="form-control" placeholder="Cancelled Remarks"><?php echo $tpl['pujadataarr']['remarks']; ?></textarea>
                                          </div>
                                            </div>
                                            
<!-- document div start -->

<div class="box box-solid box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">
                                        <?php echo __('Documents'); ?>
                                    </h3>
                                    <div class="box-tools pull-right">
                                        <button class="btn btn-primary btn-sm" data-widget="collapse"><i
                                                class="fa fa-minus"></i></button>
                                    </div>
                                </div>
                                <div class="box-body">
                                    <div class="form-group">
                                        <label class="control-label" for="img">
                                        </label>
                                       <?php if ($filetype == "pdf" )  { ?>
                                        <a class="btn btn-primary btn-sm" href="<?php echo INSTALL_URL; ?>PujaPassesadmin/viewdocument/<?php echo $tpl['pujadataarr']['id']; ?>" target="_blank" style="font-size:18px;">View Document</a>
                                        <?php
                                        }  ?>
                                      <?php if ($filetype != "pdf" )  { ?>
                                        <div class="form-group" id="alldocument" >
                    <?php if (is_file(INSTALL_PATH . UPLOAD_PATH . 'avatar/thumb/' . $tpl['pujadataarr']['studentavatar'])) { ?>
                        <fieldset>    
                            <div class="view view-tenth">   
                                <img src="<?php echo INSTALL_URL . UPLOAD_PATH . 'avatar/thumb/' . $tpl['pujadataarr']['studentavatar']; ?>" style="width: 286px;height: 183px;"/>
                                <div class="mask">
                                    <a rev="<?php echo $tpl['pujadataarr']['id']; ?>" class="info btn btn-app btn-danger gallery-delete" href="<?php echo INSTALL_URL; ?>Pujaregistration/deleteEditedImage/<?php echo $tpl['pujadataarr']['id']; ?>"><i class="fa fa-times"></i><?php echo __('remove'); ?></a>
                                </div>
                            </div>
                        </fieldset>
                    <?php } else { ?>
                        <input class="form-control" type="file" name="image">
                    <?php } ?><br>
               
                </div>
                <?php
                 }  ?>
                </div>
             
                </div>
<!-- payment div start -->

                                <div class="box box-solid box-primary">
                              
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


                        <section class="col-lg-5 connectedSortable ui-sortable">
                            
                            <div class="box box-solid box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">
                                        <?php echo __('Family details'); ?>
                                    </h3>
                                    <div class="box-tools pull-right">
                                        <button class="btn btn-primary btn-sm" data-widget="collapse"><i
                                                class="fa fa-minus"></i></button>
                                    </div>
                                </div>
                                <div class="box-body">
                                    

                                    <div class="form-group">
                                        <label class="control-label" for="street">
                                            <?php echo __('Spouse Full Name'); ?>:
                                        </label>
                                        <input id="street" class="form-control input-sm" type="text" name="street"
                                            size="25" value="<?php echo $tpl['pujadataarr']['Sp_fname']. ' ' . $tpl['pujadataarr']['Sp_lname']; ?>" title="Spouse Name"
                                            placeholder="" required readonly>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="streetname">
                                            <?php echo __('Child 1 Full Name'); ?>:
                                        </label>
                                        <input id="streetname" class="form-control input-sm" type="text" name="address"
                                            size="25" value="<?php echo $tpl['pujadataarr']['childonefname']. ' ' . $tpl['pujadataarr']['childonelname']; ?>" title="Child First Full Name"
                                            placeholder="" required readonly>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="unit">
                                            <?php echo __('Child 1 Year of Birth'); ?>:
                                        </label>
                                        <input id="unit" class="form-control input-sm" type="text" name="addres2"
                                            size="25" value="<?php echo $tpl['pujadataarr']['Age1']; ?>" title="Child 1 Year of Birth"
                                            placeholder="" required readonly>
                                    </div>
                                     <div class="form-group">
                                        <label class="control-label" for="streetname">
                                            <?php echo __('Child 2 Full Name'); ?>:
                                        </label>
                                        <input id="streetname" class="form-control input-sm" type="text" name="address"
                                            size="25" value="<?php echo $tpl['pujadataarr']['childtwofname']. ' ' . $tpl['pujadataarr']['childtwolname']; ?>" title="Child Second Full Name"
                                            placeholder="" required readonly>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="unit">
                                            <?php echo __('Child 2 Year of Birth'); ?>:
                                        </label>
                                        <input id="unit" class="form-control input-sm" type="text" name="addres2"
                                            size="25" value="<?php echo $tpl['pujadataarr']['Age2']; ?>" title="Child 2 Year of Birth"
                                            placeholder="" required readonly>
                                    </div>
                                     <div class="form-group">
                                        <label class="control-label" for="streetname">
                                            <?php echo __('Child 3 Full Name'); ?>:
                                        </label>
                                        <input id="streetname" class="form-control input-sm" type="text" name="address"
                                            size="25" value="<?php echo $tpl['pujadataarr']['childthreefname']. ' ' . $tpl['pujadataarr']['childthreelname']; ?>" title="Child Third Full Name"
                                            placeholder="" required readonly>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="unit">
                                            <?php echo __('Child 3 Year of Birth'); ?>:
                                        </label>
                                        <input id="unit" class="form-control input-sm" type="text" name="addres2"
                                            size="25" value="<?php echo $tpl['pujadataarr']['Age3']; ?>" title="Child 3 Year of Birth"
                                            placeholder="" required readonly>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="streetname">
                                            <?php echo __('Parent 1 Full Name'); ?>:
                                        </label>
                                        <input id="streetname" class="form-control input-sm" type="text" name="address"
                                            size="25" value="<?php echo $tpl['pujadataarr']['parent1_fname']. ' ' . $tpl['pujadataarr']['parent1_lname']; ?>" title="Parent 1 Full Name"
                                            placeholder="" required readonly>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="unit">
                                            <?php echo __('Parent 1 Veggie'); ?>:
                                        </label>
                                        <input id="unit" class="form-control input-sm" type="text" name="addres2"
                                            size="25" value="<?php echo $tpl['pujadataarr']['parent1_veggie']; ?>" title="Parent 1 Veggie Status"
                                            placeholder="" required readonly>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="streetname">
                                            <?php echo __('Parent 2 Full Name'); ?>:
                                        </label>
                                        <input id="streetname" class="form-control input-sm" type="text" name="address"
                                            size="25" value="<?php echo $tpl['pujadataarr']['parent2_fname']. ' ' . $tpl['pujadataarr']['parent2_lname']; ?>" title="Parent 2 Full Name"
                                            placeholder="" required readonly>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="unit">
                                            <?php echo __('Parent 2 Veggie'); ?>:
                                        </label>
                                        <input id="unit" class="form-control input-sm" type="text" name="addres2"
                                            size="25" value="<?php echo $tpl['pujadataarr']['parent2_veggie']; ?>" title="Parent 2 Veggie Status"
                                            placeholder="" required readonly>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="city">
                                            <?php echo __('Senior'); ?>:
                                        </label>
                                        <input id="city" class="form-control input-sm" type="text" name="city" size="25"
                                            value="<?php echo $tpl['pujadataarr']['senior']; ?>" title="<?php echo __('Senior Status'); ?>"
                                            placeholder="" required readonly>
                                    </div>
                                 
                                </div>
                            </div>

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
                                            size="25" value="<?php echo $tpl['pujadataarr']['street']; ?>" title="Address"
                                            placeholder="" required readonly>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="streetname">
                                            <?php echo __('Street Name'); ?>:
                                        </label>
                                        <input id="streetname" class="form-control input-sm" type="text" name="address"
                                            size="25" value="<?php echo $tpl['pujadataarr']['streetname']; ?>" title="Address"
                                            placeholder="" required readonly>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="unit">
                                            <?php echo __('Unit'); ?>:
                                        </label>
                                        <input id="unit" class="form-control input-sm" type="text" name="addres2"
                                            size="25" value="<?php echo $tpl['pujadataarr']['unit']; ?>" title="Address"
                                            placeholder="" required readonly>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="city">
                                            <?php echo __('City'); ?>:
                                        </label>
                                        <input id="city" class="form-control input-sm" type="text" name="city" size="25"
                                            value="<?php echo $tpl['pujadataarr']['city']; ?>" title="<?php echo __('City'); ?>"
                                            placeholder="" required readonly>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="state">
                                            <?php echo __('State'); ?>:
                                        </label>
                                        <input id="state" class="form-control input-sm" type="text" name="state" size="25" value="<?php echo $tpl['arr']['state']; ?>" title="<?php echo __('State'); ?>" placeholder="" readonly>
                                        
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label" for="membertype">
                                            <?php echo __('Zip'); ?>:
                                        </label>
                                        <input id="zip" class="form-control input-sm" type="text" name="zip" size="25"
                                            value="<?php echo $tpl['pujadataarr']['zip']; ?>"
                                            title="<?php echo __('Zip_Code'); ?>" placeholder="" required readonly>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="phone">
                                            <?php echo __('phone'); ?>:
                                        </label>
                                        <input id="phone" class="form-control input-sm" type="text" name="phone"
                                            size="25" value="<?php echo $tpl['pujadataarr']['phone']; ?>" title="phone"
                                            maxlength="10" placeholder="### ###-####" required readonly>
                                    </div>
                                 
                                    <div class="form-group">
                                        <label class="control-label" for="email">
                                            <?php echo __('email'); ?>:
                                        </label>
                                        <input id="phone" class="form-control input-sm" type="text" name="email"
                                            size="25" value="<?php echo $tpl['pujadataarr']['email']; ?>" title="email"
                                            placeholder="name@company.com" pattern="[^@\s]+@[^@\s]+\.[^@\s]+" required readonly>
                                    </div>
                                 
                                </div>
                            </div>

                             

                        </section>
                    </fieldset>
                </div>

                <fieldset class="form-actions">
                    <input type="hidden" name="edit_pujapassesdata" value="1" />
                    <input type="hidden" name="id" value="<?php echo $tpl['pujadataarr']['id']; ?>" />
                    <input type="hidden" name="member_status" value="<?php echo $tpl['pujadataarr']['member_status']; ?>" />
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
        magazinecancel();
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
            $("#magazinemember").val(memberregister);

        }
    }



    // function for phone no validation
    function checkphoneno(elem) {
        //debugger;
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
     
    
function magazinecancel(){
    debugger;
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