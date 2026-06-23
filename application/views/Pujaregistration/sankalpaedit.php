<section class="content-header">
    <h1>
        <?php echo __('Puja Sankalpa'); ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo INSTALL_URL; ?>"><i class="fa fa-dashboard"></i>
                <?php echo __('home'); ?>
            </a></li>
        <li><a href="<?php echo INSTALL_URL; ?>Pujaregistration/index"><?php echo __('Puja Registration'); ?></a></li>
        <li class="active">
            <?php echo __('Puja Registration'); ?>
        </li>
    </ol>
</section>
<?php
require_once VIEWS_PATH . 'Layouts/admin/error_notice.php';
$state = $tpl['sankalpadataarr']['state'] ?? '';
$registermember = $tpl['sankalpadataarr']['regmember'] ?? '';
$status = $tpl['sankalpadataarr']['Status'] ?? '';
$paymethod = $tpl['sankalpadataarr']['PaymentOption'] ?? '';
$paymentdata = $paymethod;
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
} else if ($paymethod == "zelleProxy") {
    $paymentdata = 'Zelle Proxy';
} else if ($paymethod == "ComplimentaryRegistration") {
    $paymentdata = 'Complimentary Registration';
} else if ($paymethod == "") {
    $paymentdata = 'Free Submit';
}

$document = (string)($tpl['sankalpadataarr']['avatar'] ?? '');
$newfileextension = explode(".", $document);
$filetype = strtolower((string)($newfileextension[1] ?? ''));

$viewer = $this->controller->isViewer();
?>
<form id="edit_sankalpapuja" class="frm-class booking-frm-class" action="<?php echo INSTALL_URL; ?>Pujaregistration/sankalpaedit"
    method="post" name="sankalpaedit">
    <div class="padding-19">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a data-toggle="tab" href="#tab_1">
                        <?php echo __('Puja Sankalpa'); ?>
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
                                            <?php echo __('Puja Name'); ?>:
                                        </label>
                                        <input id="registrationfor" class="form-control input-sm" type="text"
                                            name="item_name" size="25"
                                            value="<?php echo $tpl['sankalpadataarr']['item_name']; ?>" title="Registration Type"
                                            placeholder="" required readonly >
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label" for="category">
                                            <?php echo __('Category'); ?>:
                                        </label>
                                    <input id="category" class="form-control input-sm" type="text" name="category"
                                            size="25" value="<?php echo $tpl['sankalpadataarr']['category']; ?>" title="Category"
                                            placeholder="" required readonly> 
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="memberid">
                                            <?php echo __('Member Id'); ?>:
                                        </label>
                                        <input id="memberid" class="form-control input-sm" type="text" name="Member_id"
                                            size="25" value="<?php echo $tpl['sankalpadataarr']['Member_id']; ?>" title="Member Id"
                                            maxlength="10" placeholder="Member ID" required readonly>
                                    </div>
                                    
                                     <div class="form-group">
                                        <label class="control-label" for="participationmode">
                                            <?php echo __('Participation Mode'); ?>:
                                        </label>
                                        <input id="participationmode" class="form-control input-sm" type="text" name="modeparticipation"
                                            size="25" value="<?php echo $tpl['sankalpadataarr']['modeparticipation']; ?>" title=""
                                            placeholder="" required  readonly>
                                    </div>
                                    <!-- <div class="form-group">
                                        <label class="control-label" for="registrationfor">
                                            <?php echo __('Registration Type'); ?>:
                                        </label>
                                        <input id="registrationfor" class="form-control input-sm" type="text" name="registrationtype"
                                            size="25" value="<?php echo $tpl['registrationarr']['registrationtype']; ?>" title=""
                                            placeholder="" required  readonly>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="optional">
                                            <?php echo __('Optional'); ?>:
                                        </label>
                                        <input id="optional" class="form-control input-sm" type="text" name=""
                                            size="25" value="<?php echo $tpl['sankalpadataarr']['']; ?>" title=""
                                            placeholder="Optional" required readonly>
                                    </div>
                                     <div class="form-group">
                                        <label class="control-label" for="adultveg">
                                            <?php echo __('No. of Adult Veggie'); ?>:
                                        </label>
                                        <input id="adultveg" class="form-control input-sm" type="number" name="Adultveggie"
                                            size="25" value="<?php echo $tpl['sankalpadataarr']['Adultveggie']; ?>" title="Adult Veggie"
                                            placeholder="No. of Adult Veggie" required readonly>
                                    </div> 
                                    <div class="form-group">
                                        <label class="control-label" for="magazine">
                                            <?php echo __('No. of Magazine(s)'); ?>:
                                        </label>
                                        <input id="magazine" class="form-control input-sm" type="number" name="magazine"
                                            size="25" value="<?php echo $tpl['sankalpadataarr']['magazine']; ?>" title="No. of Magazine(s)"
                                            placeholder="No. of Magazine(s)" required readonly>
                                    </div>
                                </div> -->
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
                                <!-- <div class="form-group">
                                        <label class="control-label" for="items">
                                            <?php echo __('Items'); ?>:
                                        </label>
                                      <input id="items" class="form-control input-sm" type="text" name="items"
                                            size="25" value="<?php echo $tpl['sankalpadataarr']['items']; ?>"
                                            title="<?php echo __('Items'); ?>" placeholder="" readonly> 
                                    
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="donationpuja">
                                            <?php echo __('Donation Puja'); ?>:
                                        </label>
                                        <input id="donationpuja" class="form-control input-sm" type="text" name="donation"
                                            size="25" value="<?php echo $tpl['sankalpadataarr']['donation']; ?>"
                                            title="<?php echo __('Donations'); ?>" placeholder="" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="noparent">
                                            <?php echo __('Number of Parent'); ?>:
                                        </label>
                                        <input id="noparent" class="form-control input-sm" type="text" name="noparent"
                                            size="25" value="<?php echo $tpl['sankalpadataarr']['parent']; ?>"
                                            title="<?php echo __('Parent'); ?>" placeholder="" readonly>
                                    </div> -->
                                    <div class="form-group">
                                        <label class="control-label" for="totalamount">
                                            <?php echo __('Amount'); ?>:
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <?php echo Util::getCurrensySimbol($tpl['option_arr_values']['currency']); ?>
                                            </span>
                                            <input id="totalamount" class="form-control input-sm" type="number"
                                                name="item_cost" size="25"
                                                value="<?php echo $tpl['sankalpadataarr']['item_cost']; ?>"
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
                                            <select data-rule-required="true" name="Status" id="status"
                                                class="form-control input-sm" onchange="registrationcancel(this.id)">
                                                <option value="">---</option>
                                                <?php
                                                $status_arr = __('status_arr');
                                                foreach ($status_arr as $k => $v) {
                                                    ?>
                                                    <option <?php echo ($tpl['sankalpadataarr']['Status'] == $k) ? "selected='selected'" : ""; ?> value="<?php echo $k; ?>"><?php echo $v; ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                            <?php } ?> 
                                            <?php if ($this->controller->isViewer()) { ?>
                                            <input id="status" class="form-control input-sm" type="text" name="status" size="25" value="<?php echo $tpl['sankalpadataarr']['status']; ?>" title="<?php echo __('status'); ?>" placeholder="Status" readonly>
                                            <?php } ?> 
                                           </div>

                                           <div class="form-group" style="display:none;" id="cancelremarks">
                                            <!-- <input id="regcancel" class="form-control input-sm" type="text" name="remarks"
                                            size="25" value="<?php echo $tpl['sankalpadataarr']['remarks']; ?>"
                                            title="<?php echo __('Cancelation Remarks'); ?>" placeholder="Cancelation Remarks" > -->
                                            <textarea name="remarks" class="form-control" placeholder="Cancelled Remarks"><?php echo $tpl['sankalpadataarr']['remarks']; ?></textarea>
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
                                        <a class="btn btn-primary btn-sm" href="<?php echo INSTALL_URL; ?>Pujaregistration/viewdocument/<?php echo $tpl['sankalpadataarr']['id']; ?>" target="_blank" style="font-size:18px;">View Document</a>
                                        <?php
                                        }  ?>
                                      <?php if ($filetype != "pdf" )  { ?>
                                        <div class="form-group" id="alldocument" >
                    <?php if ($document !== '' && is_file(INSTALL_PATH . UPLOAD_PATH . 'avatar/thumb/' . $document)) { ?>
                        <fieldset>    
                            <div class="view view-tenth">   
                                <img src="<?php echo INSTALL_URL . UPLOAD_PATH . 'avatar/thumb/' . h($document); ?>" style="width: 286px;height: 183px;"/>
                                <div class="mask">
                                    <a rev="<?php echo $tpl['sankalpadataarr']['id']; ?>" class="info btn btn-app btn-danger gallery-delete" href="<?php echo INSTALL_URL; ?>Pujaregistration/deleteEditedImage/<?php echo $tpl['sankalpadataarr']['id']; ?>"><i class="fa fa-times"></i><?php echo __('remove'); ?></a>
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
                                        <input data-rule-required="true" id="paymentmethod" class="form-control input-sm" type="text" name="PaymentOption" size="25" value="<?php echo htmlspecialchars((string)$paymentdata, ENT_QUOTES); ?>" title="Payment Method" readonly >
                                    </div>
                                    </div>


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
                                <div class="form-group">
                                        <label class="control-label" for="paymentfor">
                                            <?php echo __('Full Name'); ?>:
                                        </label>
                                        <input id="membername" class="form-control input-sm" type="text" name="name"
                                            size="25" value="<?php echo $tpl['sankalpadataarr']['name']; ?>"
                                            title="<?php echo __('Member Name'); ?>" placeholder="" readonly>
                                    </div>
                                <!-- <div class="form-group">
                                        <label class="control-label" for="paymentfor">
                                            <?php echo __('Spouse Name'); ?>:
                                        </label>
                                        <input id="spousename" class="form-control input-sm" type="text" name="Sp_fname"
                                            size="25" value="<?php echo $tpl['sankalpadataarr']['Sp_fname']. ' ' . ($tpl['arr'] ?? [])['Sp_lname'] ?? ''; ?>"
                                            title="<?php echo __('Spouse Name'); ?>" placeholder="" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="paymentfor">
                                            <?php echo __('Child 1 Full Name'); ?>:
                                        </label>
                                        <input id="child1" class="form-control input-sm" type="text" name="Child1"
                                            size="25" value="<?php echo $tpl['sankalpadataarr']['Child1']; ?>"
                                            title="<?php echo __('Child 1 Full Name'); ?>" placeholder="" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="paymentfor">
                                            <?php echo __('Year of Birth Child 1'); ?>:
                                        </label>
                                        <input id="dobchild1" class="form-control input-sm" type="text" name="Age1"
                                            size="25" value="<?php echo $tpl['sankalpadataarr']['Age1']; ?>"
                                            title="<?php echo __('Year of Birth Child 1'); ?>" placeholder="" readonly>
                                    </div>
                                    <div class="form-group">
                                            <label class="control-label" for="status">
                                                <?php echo __('Child 2 Full Name'); ?>:
                                            </label>
                                            <input id="child2" class="form-control input-sm" type="text" name="Child2"
                                            size="25" value="<?php echo $tpl['sankalpadataarr']['Child2']; ?>"
                                            title="<?php echo __('Child 2 Full Name'); ?>" placeholder="" readonly>
                                        </div>

                                        <div class="form-group">
                                        <label class="control-label" for="paymentfor">
                                            <?php echo __('Year of Birth Child 2'); ?>:
                                        </label>
                                        <input id="dobchild2" class="form-control input-sm" type="text" name="Age2"
                                            size="25" value="<?php echo $tpl['sankalpadataarr']['Age2']; ?>"
                                            title="<?php echo __('Year of Birth Child 2'); ?>" placeholder="" readonly>
                                    </div>
                                        <div class="form-group">
                                            <label class="control-label" for="status">
                                                <?php echo __('Child 3 Full Name'); ?>:
                                            </label>
                                            <input id="child3" class="form-control input-sm" type="text" name="Child3"
                                            size="25" value="<?php echo $tpl['sankalpadataarr']['Child3']; ?>"
                                            title="<?php echo __('Child 3 Full Name'); ?>" placeholder="" readonly>
                                        </div>
                                        <div class="form-group">
                                        <label class="control-label" for="paymentfor">
                                            <?php echo __('Year of Birth Child 3'); ?>:
                                        </label>
                                        <input id="dobchild3" class="form-control input-sm" type="text" name="Age3"
                                            size="25" value="<?php echo $tpl['sankalpadataarr']['Age3']; ?>"
                                            title="<?php echo __('Year of Birth Child 3'); ?>" placeholder="" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="parent1">
                                            <?php echo __('Parent 1 Full Name'); ?>:
                                        </label>
                                        <input id="parent1" class="form-control input-sm" type="text" name="Parent1"
                                            size="25" value="<?php echo $tpl['sankalpadataarr']['Parent1']; ?>"
                                            title="<?php echo __('Parent 1 Full Name'); ?>" placeholder="" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="parent2">
                                            <?php echo __('Parent 2 Full Name'); ?>:
                                        </label>
                                        <input id="parent2" class="form-control input-sm" type="text" name="Parent2"
                                            size="25" value="<?php echo $tpl['sankalpadataarr']['Parent2']; ?>"
                                            title="<?php echo __('Parent 2 Full Name'); ?>" placeholder="" readonly>
                                    </div> -->
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
                                            <?php echo __('Street'); ?>:
                                        </label>
                                        <input id="street" class="form-control input-sm" type="text" name="street"
                                            size="25" value="<?php echo $tpl['sankalpadataarr']['street']; ?>" title="Address"
                                            placeholder="" required readonly>
                                    </div> 
                                    <div class="form-group">
                                        <label class="control-label" for="streetname">
                                            <?php echo __('Street Name'); ?>:
                                        </label>
                                        <input id="streetname" class="form-control input-sm" type="text" name="streetname"
                                            size="25" value="<?php echo $tpl['sankalpadataarr']['streetname']; ?>" title="Address"
                                            placeholder="" required readonly>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="unit">
                                            <?php echo __('Unit'); ?>:
                                        </label>
                                        <input id="unit" class="form-control input-sm" type="text" name="unit"
                                            size="25" value="<?php echo $tpl['sankalpadataarr']['unit']; ?>" title="Address"
                                            placeholder="" required readonly>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="city">
                                            <?php echo __('City'); ?>:
                                        </label>
                                        <input id="city" class="form-control input-sm" type="text" name="city" size="25"
                                            value="<?php echo $tpl['sankalpadataarr']['city']; ?>" title="<?php echo __('City'); ?>"
                                            placeholder="" required readonly>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="state">
                                            <?php echo __('State'); ?>:
                                        </label>
                                        <input id="state" readonly class="form-control input-sm" type="text" name="state" size="25" value="<?php echo ($tpl['arr'] ?? [])['state'] ?? ''; ?>" title="<?php echo __('State'); ?>" placeholder="">
                                       
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label" for="membertype">
                                            <?php echo __('Zip'); ?>:
                                        </label>
                                        <input id="zip" class="form-control input-sm" type="text" name="zip" size="25"
                                            value="<?php echo $tpl['sankalpadataarr']['zip']; ?>"
                                            title="<?php echo __('Zip_Code'); ?>" placeholder="" required readonly>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="tele">
                                            <?php echo __('Mobile Number'); ?>:
                                        </label>
                                        <input id="phone" class="form-control input-sm" type="text" name="tele"
                                            size="25" value="<?php echo $tpl['sankalpadataarr']['tele']; ?>" title="tele"
                                            maxlength="10" placeholder="### ###-####" required readonly>
                                    </div>
                                       <div class="form-group">
                                        <label class="control-label" for="tele">
                                            <?php echo __('Alternate Number'); ?>:
                                        </label>
                                        <input id="alternatenumber" class="form-control input-sm" type="text" name="alternatenumber"
                                            size="25" value="<?php echo $tpl['sankalpadataarr']['alternatenumber']; ?>" title="tele"
                                            maxlength="10" placeholder="### ###-####" required readonly>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="email">
                                            <?php echo __('email'); ?>:
                                        </label>
                                        <input id="email" class="form-control input-sm" type="text" name="email"
                                            size="25" value="<?php echo $tpl['sankalpadataarr']['email']; ?>" title="email"
                                            placeholder="name@company.com" pattern="[^@\s]+@[^@\s]+\.[^@\s]+" required readonly>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="email">
                                            <?php echo __('Alternate Email'); ?>:
                                        </label>
                                        <input id="alternateemail" class="form-control input-sm" type="text" name="alternateemail"
                                            size="25" value="<?php echo $tpl['sankalpadataarr']['alternateemail']; ?>" title="Alternate Email"
                                            placeholder="name@company.com" pattern="[^@\s]+@[^@\s]+\.[^@\s]+" required readonly>
                                    </div>
                                </div>
                        </section>
                    </fieldset>
                </div>

                <fieldset class="form-actions">
                    <input type="hidden" name="edit_sankalpadata" value="1" />
                    <input type="hidden" name="id" value="<?php echo $tpl['sankalpadataarr']['id']; ?>" />
                    <input type="hidden" name="regmember" value="<?php echo $tpl['sankalpadataarr']['regmember']; ?>" />
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
    if(currrentstatus == 'cancelled'){
        $('#cancelremarks').show();
    }
    else if (regstatus == 'cancelled' && currrentstatus == 'cancelled'){
        $('#cancelremarks').show();
    }
    else{
        $('#cancelremarks').hide();
    }

}
</script>
