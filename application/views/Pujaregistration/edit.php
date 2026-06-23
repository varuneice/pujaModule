<section class="content-header">
    <h1>
        <?php echo __('Puja Registration'); ?>
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
$state = $tpl['pujadataarr']['state'];
$registermember = $tpl['pujadataarr']['regmember'];
$status = $tpl['pujadataarr']['status'];
$paymentLink = INSTALL_URL . 'Pujaregistration/payment/' . ($tpl['pujadataarr']['id'] ?? '');
$paymethod = $tpl['pujadataarr']['PaymentOption'] ?? '';
$paymentdata = '';
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

$document = $tpl['pujadataarr']['addressavatar'] ?? '';
$documentExtension = pathinfo($document, PATHINFO_EXTENSION);
$filetype = strtolower((string) $documentExtension);

$viewer = $this->controller->isViewer();
$isFamilyPujaRegistration = strtolower(trim($tpl['pujadataarr']['member_status'] ?? '')) === 'family';
$hasAdultChildData = !empty($tpl['pujadataarr']['co_register_adult_members'])
    || !empty($tpl['pujadataarr']['adult_member_count'])
    || !empty($tpl['pujadataarr']['adult1_fname'])
    || !empty($tpl['pujadataarr']['adult2_fname'])
    || !empty($tpl['pujadataarr']['adult3_fname']);
?>
<form id="edit_sankalpapuja" class="frm-class booking-frm-class" action="<?php echo INSTALL_URL; ?>Pujaregistration/edit"
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
                                            value="<?php echo $tpl['pujadataarr']['puja_type']; ?>" title="Registration Type"
                                            placeholder="" required readonly >
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label" for="category">
                                            <?php echo __('Category'); ?>:
                                        </label>
                                    <input id="category" class="form-control input-sm" type="text" name="membercategory"
                                            size="25" value="<?php echo $tpl['pujadataarr']['membercategory']; ?>" title="Category"
                                            placeholder="" required readonly> 
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
                                            <?php echo __('University or College Name'); ?>:
                                        </label>
                                        <input id="memberid" class="form-control input-sm" type="text" name="schoolname"
                                            size="25" value="<?php echo $tpl['pujadataarr']['schoolname']; ?>" title="Member Id"
                                            maxlength="10" placeholder="University or College Name" required readonly>
                                    </div>
                                 
                                    <div class="form-group">
                                        <label class="control-label" for="magazine">
                                            <?php echo __('No. of Magazine(s)'); ?>:
                                        </label>
                                        <input id="magazine" class="form-control input-sm" type="number" name="magazine"
                                            size="25" value="<?php echo $tpl['pujadataarr']['magazine']; ?>" title="No. of Magazine(s)"
                                            placeholder="No. of Magazine(s)" required readonly>
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
                                        <label class="control-label" for="registrationamount">
                                            <?php echo __('Registration Amount'); ?>:
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <?php echo Util::getCurrensySimbol($tpl['option_arr_values']['currency']); ?>
                                            </span>
                                        <input id="registrationamount" class="form-control input-sm" type="text" name="amount"
                                            size="25" value="<?php echo $tpl['pujadataarr']['amount']; ?>"
                                            title="<?php echo __('Registration Amount'); ?>" placeholder="" readonly>
                                    </div>
                                 </div>
                                    <?php if ($tpl['pujadataarr']['donation'] !="" && $tpl['pujadataarr']['donation'] > 0)  { ?>
                                    <div class="form-group">
                                        <label class="control-label" for="donationpuja">
                                            <?php echo __('Donation Puja'); ?>:
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <?php echo Util::getCurrensySimbol($tpl['option_arr_values']['currency']); ?>
                                            </span>
                                        <input id="donationpuja" class="form-control input-sm" type="text" name="donation"
                                            size="25" value="<?php echo $tpl['pujadataarr']['donation']; ?>"
                                            title="<?php echo __('Donations'); ?>" placeholder="" readonly>
                                    </div>
                                    </div>
                                    <?php
                                      } ?>
                                      <?php if ($tpl['pujadataarr']['discountseniorprice'] !="")  { ?>
                                    <div class="form-group">
                                        <label class="control-label" for="seniordiscount">
                                            <?php echo __('Senior Discount'); ?>:
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <?php echo Util::getCurrensySimbol($tpl['option_arr_values']['currency']); ?>
                                            </span>
                                        <input id="seniordiscount" class="form-control input-sm" type="text" name="discountseniorprice"
                                            size="25" value="<?php echo $tpl['pujadataarr']['discountseniorprice']; ?>"
                                            title="<?php echo __('Senior Discount'); ?>" placeholder="" readonly>
                                    </div>
                                      </div>
                                    <?php
                                      } ?>
                                       <?php if ($tpl['pujadataarr']['extraparentregistration'] !="")  { ?>
                                    <div class="form-group">
                                        <label class="control-label" for="parentregistration">
                                            <?php echo __('Parent Registration'); ?>:
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <?php echo Util::getCurrensySimbol($tpl['option_arr_values']['currency']); ?>
                                            </span>
                                        <input id="parentregistration" class="form-control input-sm" type="text" name="extraparentregistration"
                                            size="25" value="<?php echo $tpl['pujadataarr']['extraparentregistration']; ?>"
                                            title="<?php echo __('Parent Registration'); ?>" placeholder="" readonly>
                                    </div>
                                       </div>
                                    <?php
                                      } ?>
                                       <?php if ($tpl['pujadataarr']['magazineprice'] !="")  { ?>
                                    <div class="form-group">
                                        <label class="control-label" for="pricemagazine">
                                            <?php echo __('Additional Magazine Price'); ?>:
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <?php echo Util::getCurrensySimbol($tpl['option_arr_values']['currency']); ?>
                                            </span>
                                        <input id="pricemagazine" class="form-control input-sm" type="text" name="magazineprice"
                                            size="25" value="<?php echo $tpl['pujadataarr']['magazineprice']; ?>"
                                            title="<?php echo __('Additional Magazine Price'); ?>" placeholder="" readonly>
                                    </div>
                                       </div>
                                    <?php
                                      } ?>
                                
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
                                                class="form-control input-sm" onchange="registrationcancel(this.id)">
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

                                           <?php if (($this->controller->isAdmin() || $this->controller->isEditor()) && in_array($tpl['pujadataarr']['status'], array('pending', 'Active'))) { ?>
                                           <div class="form-group">
                                            <label class="control-label" for="paymentlink">Payment Link:</label>
                                            <div class="input-group">
                                                <input id="paymentlink" class="form-control input-sm" type="text" value="<?php echo htmlspecialchars($paymentLink, ENT_QUOTES); ?>" readonly>
                                                <span class="input-group-btn">
                                                    <a class="btn btn-primary btn-sm" href="<?php echo htmlspecialchars($paymentLink, ENT_QUOTES); ?>" target="_blank">Open</a>
                                                </span>
                                            </div>
                                            <p class="help-block">This is the same link sent when status is changed to Active and saved.</p>
                                           </div>
                                           <?php } ?>

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
                                        <a class="btn btn-primary btn-sm" href="<?php echo INSTALL_URL; ?>Pujaregistration/viewdocumentpujaregistration/<?php echo $tpl['pujadataarr']['id']; ?>" target="_blank" style="font-size:18px;">View Document</a>
                                        <?php
                                        }  ?>
                                      <?php if ($filetype != "pdf" )  { ?>

                                        <div class="form-group" id="allticketevent" >
                    <?php if (is_file(INSTALL_PATH . UPLOAD_PATH . 'avatar/thumb/' . $tpl['pujadataarr']['addressavatar'])) { ?>
                        <fieldset>    
                            <div class="view view-tenth">   
                                <img src="<?php echo INSTALL_URL . UPLOAD_PATH . 'avatar/thumb/' . $tpl['pujadataarr']['addressavatar']; ?>" style="width: 286px;height: 183px;"/>
                                <div class="mask">
                                    <a rev="<?php echo $tpl['pujadataarr']['id']; ?>" class="info btn btn-app btn-danger gallery-delete" href="<?php echo INSTALL_URL; ?>Pujaregistration/deleteEditedImage/<?php echo $tpl['pujadataarr']['id']; ?>"><i class="fa fa-times"></i><?php echo __('remove'); ?></a>
                                </div>
                            </div>
                        </fieldset>
                    <?php } else { ?>
                        <input class="form-control" type="file" name="image">
                    <?php } ?>
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
                                        <input data-rule-required="true" id="paymentmethod" class="form-control input-sm" type="text" name="PaymentMethod" size="25" value="<?php echo $paymentdata; ?>" title="Payment Method" readonly >
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
                                            <?php echo __('Member Name'); ?>: &nbsp;&nbsp;&nbsp;&nbsp;
                                            <input style="visibility: visible;margin: 34px 0px 0px 4px;" class="checkbox" type="checkbox" id="veggie" <?php echo ($tpl['pujadataarr']['member_veggie'] == '1') ? "checked='checked'" : ""; ?> name="member_veggie" value="1">
                                             <label for="veggie" style="color:red;">if Veggie</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                             <input style="visibility: visible;margin: 34px 0px 0px 4px;" class="checkbox" type="checkbox" id="senior" <?php echo ($tpl['pujadataarr']['senior'] == '1') ? "checked='checked'" : ""; ?> name="senior" value="1" onchange="calculateseniordiscount(this)">
                                              <label for="senior" style="color:red;">if Senior</label>
                                        </label>
                                        <input id="membername" class="form-control input-sm" type="text" name="membername"
                                            size="25" value="<?php echo $tpl['pujadataarr']['First_name']. ' ' . $tpl['pujadataarr']['Last_name']; ?>"
                                            title="<?php echo __('Member Name'); ?>" placeholder="" readonly>
                                    </div>
                                    <?php if ($tpl['pujadataarr']['Sp_fname'] !="")  { ?>
                                <div class="form-group">
                                        <label class="control-label" for="paymentfor">
                                            <?php echo __('Spouse Name'); ?>: &nbsp;&nbsp;&nbsp;&nbsp;
                                            <input style="visibility: visible;margin: 34px 0px 0px 4px;" class="checkbox" type="checkbox" id="veggie" <?php echo ($tpl['pujadataarr']['spouse_veggie'] == '1') ? "checked='checked'" : ""; ?> name="spouse_veggie" value="1">
                                             <label for="veggie" style="color:red;">if Veggie</label>
                                        </label>
                                        <input id="spousename" class="form-control input-sm" type="text" name="spousename"
                                            size="25" value="<?php echo $tpl['pujadataarr']['Sp_fname']. ' ' . $tpl['pujadataarr']['Sp_lname']; ?>"
                                            title="<?php echo __('Spouse Name'); ?>" placeholder="" readonly>
                                    </div>
                                    <?php
                                      } ?>
                                      
                                    <!--new change Start for edit parent and child-->
                                    <div class="form-group col-lg-7 col-md-7">
                                        
                                        <label class="control-label" for="paymentfor">
                                            <?php echo __('Child 1 First Name'); ?>:

                                        </label>
                                        <input id="spousename" class="form-control input-sm" type="text" name="childonefname"
                                            size="25" value="<?php echo $tpl['pujadataarr']['childonefname']; ?>"
                                            title="<?php echo __('Child 1 First Name'); ?>" placeholder="" >
                                    
                                     </div>

                                     <div class="form-group col-lg-5 col-md-5">
                                       
                                            <label class="control-label" for="paymentfor">
                                            <?php echo __('Child 1 Last Name'); ?>:

                                        </label>
                                        <input id="childOneLastName" class="form-control input-sm" type="text" name="childonelname"
                                            size="25" value="<?php echo $tpl['pujadataarr']['childonelname']; ?>"
                                            title="<?php echo __('Child 1 Last Name'); ?>" placeholder="" >
                                            
                                          

                                     </div>

                                    <div class="form-group col-lg-12 col-md-12">
                                        <label class="control-label" for="paymentfor">
                                            <?php echo __('Child 1 Year of Birth'); ?>:
                                        </label>
                                        <input id="dobchild1" class="form-control input-sm" type="text" name="Age1"
                                            size="25" value="<?php echo $tpl['pujadataarr']['Age1']; ?>"
                                            title="<?php echo __('Child 1 Year of Birth'); ?>" placeholder="" >
                                    </div>

                                    
                                   
                                  
                                  <div class="form-group col-lg-7 col-md-7">
                                        <label class="control-label" for="paymentfor">
                                            <?php echo __('Child 2 First Name'); ?>:
                                        </label>
                                        <input id="spousename" class="form-control input-sm" type="text" name="childtwofname"
                                            size="25" value="<?php echo $tpl['pujadataarr']['childtwofname']; ?>"
                                            title="<?php echo __('Child 2 First Name'); ?>" placeholder="" >
                                    </div>

                                    <div class="form-group col-lg-5 col-md-5">
                                       
                                            <label class="control-label" for="paymentfor">
                                            <?php echo __('Child 2 Last Name'); ?>:

                                        </label>
                                        <input id="childTwoLastName" class="form-control input-sm" type="text" name="childtwolname"
                                            size="25" value="<?php echo $tpl['pujadataarr']['childtwolname']; ?>"
                                            title="<?php echo __('Child 2 Last Name'); ?>" placeholder="" >
                                            
                                          

                                     </div>
                                      
                                        <div class="form-group col-lg-12 col-md-12">
                                        <label class="control-label" for="paymentfor">
                                            <?php echo __('Child 2 Year of Birth'); ?>:
                                        </label>
                                        <input id="dobchild2" class="form-control input-sm" type="text" name="Age2"
                                            size="25" value="<?php echo $tpl['pujadataarr']['Age2']; ?>"
                                            title="<?php echo __('Child 2 Year of Birth'); ?>" placeholder="" >
                                    </div>
                                    
                                        <div class="form-group col-lg-7 col-md-7">
                                        <label class="control-label" for="paymentfor">
                                            <?php echo __('Child 3 First Name'); ?>:
                                        </label>
                                        <input id="spousename" class="form-control input-sm" type="text" name="childthreefname"
                                            size="25" value="<?php echo $tpl['pujadataarr']['childthreefname']; ?>"
                                            title="<?php echo __('Child 3 First Name'); ?>" placeholder="" >
                                    </div>

                                    <div class="form-group col-lg-5 col-md-5">
                                       
                                       <label class="control-label" for="paymentfor">
                                       <?php echo __('Child 3 Last Name'); ?>:

                                   </label>
                                   <input id="childOneLastName" class="form-control input-sm" type="text" name="childthreelname"
                                       size="25" value="<?php echo $tpl['pujadataarr']['childthreelname']; ?>"
                                       title="<?php echo __('Child 3 Last Name'); ?>" placeholder="" >
                                       
                                     

                                </div>

                                     <div class="form-group col-lg-12 col-md-12">
                                         <label class="control-label" for="paymentfor">
                                             <?php echo __('Child 3 Year of Birth'); ?>:
                                         </label>
                                         <input id="dobchild3" class="form-control input-sm" type="text" name="Age3"
                                             size="25" value="<?php echo $tpl['pujadataarr']['Age3']; ?>"
                                             title="<?php echo __('Child 3 Year of Birth'); ?>" placeholder="" >
                                     </div>

                                    <?php if ($hasAdultChildData) { ?>
                                    <div class="form-group col-lg-12 col-md-12">
                                        <label class="control-label" style="font-weight:700;color:#333;">
                                            Additional 22+ Unmarried Adult Members
                                        </label>
                                    </div>

                                    <div class="form-group col-lg-12 col-md-12">
                                        <label class="control-label" for="adultMemberCountEdit">
                                            <?php echo __('Adult Member Count'); ?>:
                                        </label>
                                        <input id="adultMemberCountEdit" class="form-control input-sm" type="text" name="adult_member_count"
                                            size="25" value="<?php echo htmlspecialchars((string) ($tpl['pujadataarr']['adult_member_count'] ?? ''), ENT_QUOTES); ?>"
                                            title="<?php echo __('Adult Member Count'); ?>" placeholder="" >
                                    </div>

                                    <div class="form-group col-lg-7 col-md-7">
                                        <label class="control-label" for="adult1fnameedit">
                                            <?php echo __('Adult 1 First Name'); ?>:
                                        </label>
                                        <input id="adult1fnameedit" class="form-control input-sm" type="text" name="adult1_fname"
                                            size="25" value="<?php echo htmlspecialchars((string) ($tpl['pujadataarr']['adult1_fname'] ?? ''), ENT_QUOTES); ?>"
                                            title="<?php echo __('Adult 1 First Name'); ?>" placeholder="" >
                                    </div>

                                    <div class="form-group col-lg-5 col-md-5">
                                        <label class="control-label" for="adult1lnameedit">
                                            <?php echo __('Adult 1 Last Name'); ?>:
                                        </label>
                                        <input id="adult1lnameedit" class="form-control input-sm" type="text" name="adult1_lname"
                                            size="25" value="<?php echo htmlspecialchars((string) ($tpl['pujadataarr']['adult1_lname'] ?? ''), ENT_QUOTES); ?>"
                                            title="<?php echo __('Adult 1 Last Name'); ?>" placeholder="" >
                                    </div>

                                    <div class="form-group col-lg-12 col-md-12">
                                        <label class="control-label" for="adult1birthyearedit">
                                            <?php echo __('Adult 1 Birth Year'); ?>:
                                        </label>
                                        <input id="adult1birthyearedit" class="form-control input-sm" type="text" name="adult1_birth_year"
                                            size="25" value="<?php echo htmlspecialchars((string) ($tpl['pujadataarr']['adult1_birth_year'] ?? ''), ENT_QUOTES); ?>"
                                            title="<?php echo __('Adult 1 Birth Year'); ?>" placeholder="" >
                                    </div>

                                    <div class="form-group col-lg-12 col-md-12">
                                        <label class="control-label" for="adult1veggieedit">
                                            <input style="visibility: visible;margin: 34px 0px 0px 4px;" class="checkbox" type="checkbox" id="adult1veggieedit" <?php echo (($tpl['pujadataarr']['adult1_veggie'] ?? '') == '1') ? "checked='checked'" : ""; ?> name="adult1_veggie" value="1">
                                            <label for="adult1veggieedit" style="color:red;">if, Adult 1 Veggie</label>
                                        </label>
                                    </div>

                                    <div class="form-group col-lg-7 col-md-7">
                                        <label class="control-label" for="adult2fnameedit">
                                            <?php echo __('Adult 2 First Name'); ?>:
                                        </label>
                                        <input id="adult2fnameedit" class="form-control input-sm" type="text" name="adult2_fname"
                                            size="25" value="<?php echo htmlspecialchars((string) ($tpl['pujadataarr']['adult2_fname'] ?? ''), ENT_QUOTES); ?>"
                                            title="<?php echo __('Adult 2 First Name'); ?>" placeholder="" >
                                    </div>

                                    <div class="form-group col-lg-5 col-md-5">
                                        <label class="control-label" for="adult2lnameedit">
                                            <?php echo __('Adult 2 Last Name'); ?>:
                                        </label>
                                        <input id="adult2lnameedit" class="form-control input-sm" type="text" name="adult2_lname"
                                            size="25" value="<?php echo htmlspecialchars((string) ($tpl['pujadataarr']['adult2_lname'] ?? ''), ENT_QUOTES); ?>"
                                            title="<?php echo __('Adult 2 Last Name'); ?>" placeholder="" >
                                    </div>

                                    <div class="form-group col-lg-12 col-md-12">
                                        <label class="control-label" for="adult2birthyearedit">
                                            <?php echo __('Adult 2 Birth Year'); ?>:
                                        </label>
                                        <input id="adult2birthyearedit" class="form-control input-sm" type="text" name="adult2_birth_year"
                                            size="25" value="<?php echo htmlspecialchars((string) ($tpl['pujadataarr']['adult2_birth_year'] ?? ''), ENT_QUOTES); ?>"
                                            title="<?php echo __('Adult 2 Birth Year'); ?>" placeholder="" >
                                    </div>

                                    <div class="form-group col-lg-12 col-md-12">
                                        <label class="control-label" for="adult2veggieedit">
                                            <input style="visibility: visible;margin: 34px 0px 0px 4px;" class="checkbox" type="checkbox" id="adult2veggieedit" <?php echo (($tpl['pujadataarr']['adult2_veggie'] ?? '') == '1') ? "checked='checked'" : ""; ?> name="adult2_veggie" value="1">
                                            <label for="adult2veggieedit" style="color:red;">if, Adult 2 Veggie</label>
                                        </label>
                                    </div>

                                    <div class="form-group col-lg-7 col-md-7">
                                        <label class="control-label" for="adult3fnameedit">
                                            <?php echo __('Adult 3 First Name'); ?>:
                                        </label>
                                        <input id="adult3fnameedit" class="form-control input-sm" type="text" name="adult3_fname"
                                            size="25" value="<?php echo htmlspecialchars((string) ($tpl['pujadataarr']['adult3_fname'] ?? ''), ENT_QUOTES); ?>"
                                            title="<?php echo __('Adult 3 First Name'); ?>" placeholder="" >
                                    </div>

                                    <div class="form-group col-lg-5 col-md-5">
                                        <label class="control-label" for="adult3lnameedit">
                                            <?php echo __('Adult 3 Last Name'); ?>:
                                        </label>
                                        <input id="adult3lnameedit" class="form-control input-sm" type="text" name="adult3_lname"
                                            size="25" value="<?php echo htmlspecialchars((string) ($tpl['pujadataarr']['adult3_lname'] ?? ''), ENT_QUOTES); ?>"
                                            title="<?php echo __('Adult 3 Last Name'); ?>" placeholder="" >
                                    </div>

                                    <div class="form-group col-lg-12 col-md-12">
                                        <label class="control-label" for="adult3birthyearedit">
                                            <?php echo __('Adult 3 Birth Year'); ?>:
                                        </label>
                                        <input id="adult3birthyearedit" class="form-control input-sm" type="text" name="adult3_birth_year"
                                            size="25" value="<?php echo htmlspecialchars((string) ($tpl['pujadataarr']['adult3_birth_year'] ?? ''), ENT_QUOTES); ?>"
                                            title="<?php echo __('Adult 3 Birth Year'); ?>" placeholder="" >
                                    </div>

                                    <div class="form-group col-lg-12 col-md-12">
                                        <label class="control-label" for="adult3veggieedit">
                                            <input style="visibility: visible;margin: 34px 0px 0px 4px;" class="checkbox" type="checkbox" id="adult3veggieedit" <?php echo (($tpl['pujadataarr']['adult3_veggie'] ?? '') == '1') ? "checked='checked'" : ""; ?> name="adult3_veggie" value="1">
                                            <label for="adult3veggieedit" style="color:red;">if, Adult 3 Veggie</label>
                                        </label>
                                    </div>
                                    <?php } ?>
                                     
                                     <div class="form-group col-lg-7 col-md-7">
                                         <label class="control-label" for="paymentfor">
                                             <?php echo __('Parent 1 Full Name'); ?>: 
                                        </label>
                                        <input id="spousename" class="form-control input-sm" type="text" name="parent1_fname"
                                            size="25" value="<?php echo $tpl['pujadataarr']['parent1_fname']; ?>"
                                            title="<?php echo __('Parent 1 Full Name'); ?>" placeholder="" >
                                    </div>

                                    <div class="form-group col-lg-5 col-md-5">
                                        <label class="control-label" for="paymentfor">
                                            <?php echo __('Parent 1 Last Name'); ?>: 
                                        </label>
                                        <input id="spousename" class="form-control input-sm" type="text" name="parent1_lname"
                                            size="25" value="<?php echo $tpl['pujadataarr']['parent1_lname']; ?>"
                                            title="<?php echo __('Parent 1 Last Name'); ?>" placeholder="" >
                                    </div>

                                    <div class="form-group col-lg-12 col-md-12">
                                        <label class="control-label" for="paymentfor">
                                            <input style="visibility: visible;margin: 34px 0px 0px 4px;" class="checkbox" type="checkbox" id="veggie" <?php echo ($tpl['pujadataarr']['parent1_veggie'] == '1') ? "checked='checked'" : ""; ?> name="parent1_veggie" value="1">
                                             <label for="veggie" style="color:red;">if, Parent 1 Veggie</label>
                                        </label>
                                        </div>

                                    
                                    
                                   <div class="form-group col-lg-7 col-md-7">
                                        <label class="control-label" for="paymentfor">
                                            <?php echo __('Parent 2 Full Name'); ?>: 
                                        </label>
                                        <input id="spousename" class="form-control input-sm" type="text" name="parent2_fname"
                                            size="25" value="<?php echo $tpl['pujadataarr']['parent2_fname']; ?>"
                                            title="<?php echo __('Parent 2 Full Name'); ?>" placeholder="" >
                                    </div>

                                    <div class="form-group col-lg-5 col-md-5">
                                        <label class="control-label" for="paymentfor">
                                            <?php echo __('Parent 2 Last Name'); ?>: 
                                        </label>
                                        <input id="spousename" class="form-control input-sm" type="text" name="parent2_lname"
                                            size="25" value="<?php echo  $tpl['pujadataarr']['parent2_lname']; ?>"
                                            title="<?php echo __('Parent 2 Last Name'); ?>" placeholder="" >
                                    </div>
                                    <div class="form-group col-lg-12 col-md-12">
                                        <label class="control-label" for="paymentfor">
                                            <input style="visibility: visible;margin: 34px 0px 0px 4px;" class="checkbox" type="checkbox" id="veggie" <?php echo ($tpl['pujadataarr']['parent2_veggie'] == '1') ? "checked='checked'" : ""; ?> name="parent2_veggie" value="1">
                                             <label for="veggie" style="color:red;">if, Parent 2 Veggie</label>
                                        </label>
                                        
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="control-label" for="paymentfor" style="background:#fff;color:#fff;">
                                            <?php echo __('Parent 1 Last Name'); ?>: 
                                        </label>
                                        <input style="background:#fff;color:#fff;" class="form-control input-sm" type="hidden" size="25" value="" title="<?php echo __('Parent 1 Last Name'); ?>" placeholder="" >
                                    </div>
  <!--new change end for edit parent and child-->
                                     <!-- <div class="form-group">
                                        <label class="control-label" for="paymentfor">
                                            <?php echo __('Senior'); ?>:
                                        </label>
                                        <input id="child1" class="form-control input-sm" type="text" name="member_veggie"
                                            size="25" value="<?php echo $tpl['pujadataarr']['senior']; ?>"
                                            title="<?php echo __('Senior'); ?>" placeholder="" readonly>
                                    </div> -->
                                    <!-- <div class="form-group">
                                        <label class="control-label" for="paymentfor">
                                            <?php echo __('Senior Veggie'); ?>:
                                        </label>
                                        <input id="child1" class="form-control input-sm" type="text" name="member_veggie"
                                            size="25" value="<?php echo $tpl['pujadataarr']['senior_veggie']; ?>"
                                            title="<?php echo __('Senior veggie'); ?>" placeholder="" readonly>
                                    </div> -->
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
                                            size="25" value="<?php echo $tpl['pujadataarr']['street']; ?>" title="Address"
                                            placeholder="" required readonly>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="streetname">
                                            <?php echo __('Street Name'); ?>:
                                        </label>
                                        <input id="streetname" class="form-control input-sm" type="text" name="streetname"
                                            size="25" value="<?php echo $tpl['pujadataarr']['streetname']; ?>" title="Address"
                                            placeholder="" required readonly>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="unit">
                                            <?php echo __('Unit'); ?>:
                                        </label>
                                        <input id="unit" class="form-control input-sm" type="text" name="unit"
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
                                      <input id="state" class="form-control input-sm" type="text" name="state" size="25" value="<?php echo $tpl['pujadataarr']['state']; ?>" title="<?php echo __('State'); ?>" placeholder="" readonly>
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
                                    <?php if ($tpl['pujadataarr']['alternatenumber'] !="")  { ?>
                                    <div class="form-group">
                                        <label class="control-label" for="phone">
                                            <?php echo __('Alternate Conatct'); ?>:
                                        </label>
                                        <input id="phone" class="form-control input-sm" type="text" name="alternatenumber"
                                            size="25" value="<?php echo $tpl['pujadataarr']['alternatenumber']; ?>" title="Alternate Conatct"
                                            maxlength="10" placeholder="### ###-####" required readonly>
                                    </div>
                                    <?php
                                      } ?>
                                    <div class="form-group">
                                        <label class="control-label" for="email">
                                            <?php echo __('email'); ?>:
                                        </label>
                                        <input id="phone" class="form-control input-sm" type="text" name="email"
                                            size="25" value="<?php echo $tpl['pujadataarr']['email']; ?>" title="email"
                                            placeholder="name@company.com" pattern="[^@\s]+@[^@\s]+\.[^@\s]+" required readonly>
                                    </div>
                                    <?php if ($tpl['pujadataarr']['alternateemail'] !="")  { ?>
                                    <div class="form-group">
                                        <label class="control-label" for="email">
                                            <?php echo __('Alternate Email'); ?>:
                                        </label>
                                        <input id="phone" class="form-control input-sm" type="text" name="alternateemail"
                                            size="25" value="<?php echo $tpl['pujadataarr']['alternateemail']; ?>" title="Alternate Email"
                                            placeholder="name@company.com" pattern="[^@\s]+@[^@\s]+\.[^@\s]+" required readonly>
                                    </div>
                                    <?php
                                      } ?>
                                </div>
                        </section>
                        <div class="clearfix"></div>
                    </fieldset>
                </div>

                <?php if ($isFamilyPujaRegistration) { ?>
                <div class="box box-primary" style="clear: both; margin: 0 0 20px 0;">
                    <div class="box-header with-border">
                        <h3 class="box-title">Additional Family Members</h3>
                    </div>
                    <div class="box-body">
                        <?php $extraMembers = $tpl['extraMembers'] ?? array(); ?>
                        <?php
                        $editExtraMemberId = (int) ($_GET['extra_member_id'] ?? 0);
                        $editExtraMember = array();
                        if ($editExtraMemberId > 0 && !empty($extraMembers)) {
                            foreach ($extraMembers as $extraMemberRow) {
                                if ((int) ($extraMemberRow['id'] ?? 0) === $editExtraMemberId) {
                                    $editExtraMember = $extraMemberRow;
                                    break;
                                }
                            }
                        }
                        ?>
                        <?php if (!empty($extraMembers)) { ?>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Type</th>
                                            <th>Veggie</th>
                                            <?php if (($this->controller->isAdmin() || $this->controller->isEditor()) && !$viewer) { ?>
                                                <th style="width: 140px;">Action</th>
                                            <?php } ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($extraMembers as $extraMember) { ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($extraMember['first_name'] ?? '', ENT_QUOTES); ?></td>
                                                <td><?php echo htmlspecialchars($extraMember['last_name'] ?? '', ENT_QUOTES); ?></td>
                                                <td><?php echo htmlspecialchars($extraMember['member_type'] ?? '', ENT_QUOTES); ?></td>
                                                <td><?php echo !empty($extraMember['is_veggie']) ? 'Yes' : 'No'; ?></td>
                                                <?php if (($this->controller->isAdmin() || $this->controller->isEditor()) && !$viewer) { ?>
                                                    <td>
                                                        <a class="btn btn-primary btn-xs" href="<?php echo INSTALL_URL; ?>Pujaregistration/edit/<?php echo (int) ($tpl['pujadataarr']['id'] ?? 0); ?>?extra_member_id=<?php echo (int) ($extraMember['id'] ?? 0); ?>">Edit</a>
                                                        <button type="submit" class="btn btn-danger btn-xs" name="delete_pujaregistration_extra_member" value="<?php echo (int) ($extraMember['id'] ?? 0); ?>" onclick="return confirm('Remove this family member?');">Remove</button>
                                                    </td>
                                                <?php } ?>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php } else { ?>
                            <p>No additional family members added.</p>
                        <?php } ?>

                        <?php if (($this->controller->isAdmin() || $this->controller->isEditor()) && !$viewer) { ?>
                            <input type="hidden" name="registration_id" value="<?php echo (int) ($tpl['pujadataarr']['id'] ?? 0); ?>">
                            <input type="hidden" name="order_id" value="<?php echo (int) ($tpl['pujadataarr']['oid'] ?? 0); ?>">
                            <?php if (!empty($editExtraMember)) { ?>
                                <input type="hidden" name="extra_member_id" value="<?php echo (int) ($editExtraMember['id'] ?? 0); ?>">
                                <div class="form-inline">
                                    <div class="form-group" style="margin-right: 8px;">
                                        <input type="text" name="first_name" class="form-control input-sm" placeholder="First Name" value="<?php echo htmlspecialchars($editExtraMember['first_name'] ?? '', ENT_QUOTES); ?>" required>
                                    </div>
                                    <div class="form-group" style="margin-right: 8px;">
                                        <input type="text" name="last_name" class="form-control input-sm" placeholder="Last Name" value="<?php echo htmlspecialchars($editExtraMember['last_name'] ?? '', ENT_QUOTES); ?>" required>
                                    </div>
                                    <div class="form-group" style="margin-right: 8px;">
                                        <input type="hidden" name="member_type" value="Adult">
                                        <input type="text" class="form-control input-sm" value="Adult" readonly>
                                    </div>
                                    <label style="margin-right: 8px;">
                                        <input type="checkbox" name="is_veggie" value="1" <?php echo !empty($editExtraMember['is_veggie']) ? 'checked="checked"' : ''; ?>> Veggie
                                    </label>
                                    <button type="submit" class="btn btn-primary btn-sm" name="update_pujaregistration_extra_member" value="1">Update Family Member</button>
                                    <a class="btn btn-default btn-sm" href="<?php echo INSTALL_URL; ?>Pujaregistration/edit/<?php echo (int) ($tpl['pujadataarr']['id'] ?? 0); ?>">Cancel</a>
                                </div>
                            <?php } else { ?>
                                <div class="form-inline">
                                    <div class="form-group" style="margin-right: 8px;">
                                        <input type="text" name="first_name" class="form-control input-sm" placeholder="First Name">
                                    </div>
                                    <div class="form-group" style="margin-right: 8px;">
                                        <input type="text" name="last_name" class="form-control input-sm" placeholder="Last Name">
                                    </div>
                                    <div class="form-group" style="margin-right: 8px;">
                                        <input type="hidden" name="member_type" value="Adult">
                                        <input type="text" class="form-control input-sm" value="Adult" readonly>
                                    </div>
                                    <label style="margin-right: 8px;">
                                        <input type="checkbox" name="is_veggie" value="1"> Veggie
                                    </label>
                                    <button type="submit" class="btn btn-primary btn-sm" name="add_pujaregistration_extra_member" value="1">Add Family Member</button>
                                </div>
                            <?php } ?>
                        <?php } ?>
                    </div>
                </div>
                <?php } ?>

                <fieldset class="form-actions">
                    <input type="hidden" name="edit_pujaregistrationdata" value="1" />
                    <input type="hidden" name="id" value="<?php echo $tpl['pujadataarr']['id']; ?>" />
                    <input type="hidden" name="regmember" value="<?php echo $tpl['pujadataarr']['regmember']; ?>" />
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
    if(currrentstatus == 'cancelled' || regstatus == 'cancelled'){
        $('#cancelremarks').show();
    }
    else{
        $('#cancelremarks').hide();
    }

}
</script>
