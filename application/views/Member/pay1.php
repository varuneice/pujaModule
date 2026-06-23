<section class="content-header">
    <h1>
        <?php echo __('pay'); ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo INSTALL_URL; ?>"><i class="fa fa-dashboard"></i> <?php echo __('home'); ?></a></li>
        <li><a href="<?php echo INSTALL_URL; ?>Member/index"><?php echo __('title_members'); ?></a></li>
        <li class="active"><?php echo __('pay'); ?></li>
    </ol>
</section>
<?php
require_once VIEWS_PATH . 'Layouts/admin/error_notice.php';
?>
<section class="content left width_100">
    <form id="payment-form" class="frm-class user-frm-class" action="<?php echo INSTALL_URL; ?>Member/checkout" method="post" name="payment-form">
        <div class="padding-19 nav-tabs-custom left width_100">
            <fieldset>
                <table class="table"> 
                    <tr class="tr">
                        <td class="td">Applicant Information</td>
                        <td class="td">
                            <input <?php echo (($tpl['arr'] ?? [])['information'] ?? '' == 'new') ? "checked='checked'" : ""; ?> required="" type="radio" id="new" name="information" value="new" />
                                                        New
                                                        <input <?php echo (($tpl['arr'] ?? [])['information'] ?? '' == 'renewal') ? "checked='checked'" : ""; ?> required="" type="radio" id="renewal" name="information" value="renewal" />
                            Renewal
                        </td>
                        
                        <!-- <td class="td"><?php /* Membership No */ ?></td>
                        <td class="td"><?php /*
  <input required="" id="Member_id" class="form-control input-sm" type="text" name="Member_id" size="25" value="<?php echo ($tpl['arr'] ?? [])['Member_id'] ?? ''; ?>" title="MemberID" placeholder="MemberID">
 */ ?></td> -->
                    </tr>
                    <tr class="tr">
                        <td class="td">
                           Member's First Name
                        </td>
                        <td class="td">
                            <input  required="" id="Your_Name" class="form-control input-sm" type="text" name="F_Name" size="25" value="<?php echo ($tpl['arr'] ?? [])['F_Name'] ?? ''; ?>" title="First Name" placeholder="First Name">
                        </td>
                        <td class="td"> 
                            Spouse Name
                        </td>
                        <td class="td"> 
                            <input required="" id="Spouse" class="form-control input-sm" type="text" name="Sp_FName" size="25" value="<?php echo ($tpl['arr'] ?? [])['Sp_FName'] ?? ''; ?>" title="Spouse Name" placeholder="Spouse Name">
                        </td>
                    </tr>
                    <tr class="tr">
                        <td class="td">Govt Issued Photo ID/No</td>
                        <td class="td"> 
                            <input <?php echo (($tpl['arr'] ?? [])['GovtissueID'] ?? '' == 'checked') ? "checked='checked'" : ""; ?> required="" type="radio" id="checked" name="GovtissueID" value="checked">
                            Available
                            <input <?php echo (($tpl['arr'] ?? [])['GovtissueID'] ?? '' == 'not_available') ? "checked='checked'" : ""; ?> required="" type="radio" id="not_available" name="GovtissueID" value="not_available">
                            Not Available
                        </td>
                        <td colspan="2"  class="td"> 
                            <input <?php echo (($tpl['arr'] ?? [])['membership_type'] ?? '' == 'individual_membership') ? "checked='checked'" : ""; ?>  required="" type="radio" id="individual_membership" name="membership_type" value="individual_membership">
                            Individual Mebership  &nbsp;&nbsp;&nbsp;&nbsp;
                            <input <?php echo (($tpl['arr'] ?? [])['membership_type'] ?? '' == 'family_membership') ? "checked='checked'" : ""; ?> required="" type="radio" id="family_membership" name="membership_type" value="family_membership">
                            Family Membership
                        </td>
                    </tr>
                    <tr class="tr">
                        <td  class="td">
                            Residential Address
                        </td>
                        <td class="td">
                            <input required="" id="Address" class="form-control input-sm" type="text" name="Address1" size="25" value="<?php echo ($tpl['arr'] ?? [])['Address1'] ?? ''; ?>" title="Address" placeholder="Address">
                        </td>  
                        <td class="td">
                            City </td>
                        <td class="td">  
                            <input required="" id="city" class="form-control input-sm" type="text" name="City" size="25" value="<?php echo ($tpl['arr'] ?? [])['City'] ?? ''; ?>" title="city" placeholder="city"> 
                        </td>
                    </tr>
                    <tr class="tr">
                        <td class="td">
                           State
                            </td>  
                        <td class="td">
                            <input required=""  id="state" class="form-control input-sm" type="text" name="State" size="25" value="<?php echo ($tpl['arr'] ?? [])['State'] ?? ''; ?>" title="state" placeholder="state">  
                        </td>   .
                        <td class="td">
                           Zip Code
                        </td>
                        <td  class="td">
                            <input required=""  id="zip_code" class="form-control input-sm" type="text" name="Zip" size="25" value="<?php echo ($tpl['arr'] ?? [])['Zip'] ?? ''; ?>" title="zip_code" placeholder="zip_code">  
                        </td>                        
                    </tr>
                    <tr class="tr">
                        <td class="td">
                          Phone No
                        </td>
                        <td class="td">
                        <input required=""  id="Tele1" class="form-control input-sm" type="number" name="Tele1" size="25" value="<?php echo ($tpl['arr'] ?? [])['Tele1'] ?? ''; ?>" title="Tele 1" placeholder="Tele1"> 
                        </td>   
                        <td class="td">
                        <input   id="phone_No" class="form-control input-sm" type="number" name="Mob_No" size="25" value="<?php echo ($tpl['arr'] ?? [])['Mob_No'] ?? ''; ?>" title="phone_No" placeholder="phone_No">   
                        </td>
                        <td class="td">
                            <input   id="phone_work" class="form-control input-sm" type="number" name="Tele2" size="25" value="<?php echo ($tpl['arr'] ?? [])['Tele2'] ?? ''; ?>" title="phone_work" placeholder="phone_work">
                        </td>                        
                    </tr>
                    <tr class="tr">
                        <td class="td">
                           Email 
                        </td>
                        <td class="td">
                            <input required=""  id="email" class="form-control input-sm" type="text" name="email" size="25" value="<?php echo ($tpl['arr'] ?? [])['email'] ?? ''; ?>" title="email" placeholder="Email1">
                        </td>   
                        <td class="td">
                           Email 2
                        </td>
                        <td class="td">  
                            <input id="email" class="form-control input-sm" type="text" name="Email2" size="25" value="<?php echo ($tpl['arr'] ?? [])['Email2'] ?? ''; ?>" title="email" placeholder="Email2">
                        </td>                        
                    </tr>
                    <tr class="tr">
                        <td class="td" colspan="4" ><h3>Children's Information</h3></td>                     
                    </tr>
                    <tr class="tr">
                        <td class="td">
                          Children 1
                            <input id="Child" class="form-control input-sm" type="text" name="Child1" size="25" value="<?php echo ($tpl['arr'] ?? [])['Child1'] ?? ''; ?>" title="Children" placeholder="Children 1">
                        </td>
                        <td class="td">
                           Year of Birth
                            <input id="year_birth" class="form-control input-sm" type="date" name="Age1" size="25" value="<?php echo ($tpl['arr'] ?? [])['Age1'] ?? ''; ?>" title="year_birth" placeholder="">
                        </td>   
                        <td class="td">
                            Children 2
                            <input id="Child" class="form-control input-sm" type="text" name="Child2" size="25" value="<?php echo ($tpl['arr'] ?? [])['Child2'] ?? ''; ?>" title="Children" placeholder="Children 2">
                        </td>
                        <td class="td">
                            Year of Birth
                            <input id="year_birth" class="form-control input-sm" type="date" name="Age2" size="25" value="<?php echo ($tpl['arr'] ?? [])['Age2'] ?? ''; ?>" title="year_birth" placeholder="">
                        </td>                       
                    </tr>
                    <tr class="tr">
                        <td  class="td">
                            Children 3
                            <input id="Child" class="form-control input-sm" type="text" name="Child3" size="25" value="<?php echo ($tpl['arr'] ?? [])['Child3'] ?? ''; ?>" title="Children" placeholder="Children 3">
                        </td>
                        <td  class="td">
                            Year of Birth
                            <input id="year_birth" class="form-control input-sm" type="date" name="Child" size="25" value="<?php echo ($tpl['arr'] ?? [])['Age3'] ?? ''; ?>" title="year_birth" placeholder="">
                        </td>   
                        <td  class="td">
                            Children 4
                            <input id="Child" class="form-control input-sm" type="text" name="Child4" size="25" value="<?php echo ($tpl['arr'] ?? [])['Child4'] ?? ''; ?>" title="Children" placeholder="Children 4">
                        </td>
                        <td  class="td">
                            Year of Birth
                            <input id="year_birth" class="form-control input-sm" type="date" name="Age4" size="25" value="<?php echo ($tpl['arr'] ?? [])['Age4'] ?? ''; ?>" title="year_birth" placeholder="">
                        </td>                       
                    </tr>
                    <tr class="tr">
                        <td  class="td" colspan="4"><h3>Mebership Categories & Payment Details</h3></td>                     
                    </tr>
                    <tr class="tr">
                        <td colspan="2" class="td"><label class="control-label" for="Child">Category</label></td>
                        <td  class="td"> <label class="control-label" for="Child">Rate </label></td>
                        <td  class="td"><label class="control-label" for="Child"> Paid</label> </td>                        
                    </tr>
                    <tr class="tr">
                        <td colspan="2" class="td">General Member-Individual(Due jan1/Apr 1 every year) </td>
                        <td class="td">
                            <input <?php echo (($tpl['arr'] ?? [])['rate'] ?? '' == 'gmi_1') ? "checked='checked'" : ""; ?> required="" type="radio" name="rate" value="gmi_1">$<?php echo $tpl['option_arr_values']['gmi_1']; ?>/ 
                            <input <?php echo (($tpl['arr'] ?? [])['rate'] ?? '' == 'gmi_4') ? "checked='checked'" : ""; ?> required="" type="radio" name="rate" value="gmi_4">$<?php echo $tpl['option_arr_values']['gmi_4']; ?>
                        </td>
                        <td class="td">
                            <?php
                            $amount = 0;
                            if (($tpl['arr'] ?? [])['rate'] ?? '' == 'gmi_1') {
                                $amount = $tpl['option_arr_values']['gmi_1'];
                            } elseif (($tpl['arr'] ?? [])['rate'] ?? '' == 'gmi_4') {
                                $amount = $tpl['option_arr_values']['gmi_4'];
                            }
                            ?>
                            <input id="gmi_amount" class="form-control input-sm" type="text" name="amount[]" size="25" value="<?php echo ($amount > 0) ? $amount : ''; ?>" title="Paid" placeholder="$">
                        </td>                        
                    </tr>
                    <tr class="tr">
                        <td colspan="2" class="td">General Member-Family(Due jan1/Apr 1 every year)</td>
                        <td class="td"> 
                            <input <?php echo (($tpl['arr'] ?? [])['rate'] ?? '' == 'gmf_1') ? "checked='checked'" : ""; ?> required="" type="radio" name="rate" value="gmf_1">$<?php echo $tpl['option_arr_values']['gmf_1']; ?>
                            /<input type="radio" name="rate" value="gmf_4">$<?php echo $tpl['option_arr_values']['gmf_4']; ?>
                        </td>
                        <td class="td">
                            <?php
                            $amount = 0;
                            if (($tpl['arr'] ?? [])['rate'] ?? '' == 'gmf_1') {
                                $amount = $tpl['option_arr_values']['gmf_1'];
                            } elseif (($tpl['arr'] ?? [])['rate'] ?? '' == 'gmf_4') {
                                $amount = $tpl['option_arr_values']['gmf_4'];
                            }
                            ?>
                            <input id="gmf_amount" class="form-control input-sm" type="text" name="amount[]" size="25" value="<?php echo ($amount > 0) ? $amount : ''; ?>" title="Paid" placeholder="$">
                        </td>                        
                    </tr>
                    <tr class="tr">
                        <td colspan="2" class="td">Life Member(LM) </td> 
                        <td class="td">
                            <input <?php echo (($tpl['arr'] ?? [])['rate'] ?? '' == 'lm') ? "checked='checked'" : ""; ?> required="" type="radio" name="rate" value="lm">$<?php echo $tpl['option_arr_values']['lm']; ?>
                        </td>
                        <td class="td">
                            <input id="lm_amount" class="form-control input-sm" type="text" name="amount[]" size="25" value="<?php echo (($tpl['arr'] ?? [])['rate'] ?? '' == 'lm') ? $tpl['option_arr_values']['lm'] : ""; ?>" title="Paid" placeholder="$">
                        </td>                              
                    </tr>
                    <tr class="tr">
                        <td colspan="2" class="td">Benefactor(BF)</td>  
                        <td class="td">
                            <input <?php echo (($tpl['arr'] ?? [])['rate'] ?? '' == 'bf') ? "checked='checked'" : ""; ?> required="" type="radio" name="rate" value="bf">$<?php echo $tpl['option_arr_values']['bf']; ?>
                        </td>
                        <td class="td">
                            <input id="bf_amount" class="form-control input-sm" type="text" name="amount[]" size="25" value="<?php echo (($tpl['arr'] ?? [])['rate'] ?? '' == 'bf') ? $tpl['option_arr_values']['bf'] : ""; ?>" title="Paid" placeholder="$">
                        </td>                        
                    </tr>
                    <tr class="tr">
                        <td colspan="2" class="td">Patron Member(pm) </td>
                        <td class="td">
                            <input <?php echo (($tpl['arr'] ?? [])['rate'] ?? '' == 'pm') ? "checked='checked'" : ""; ?> required="" type="radio" name="rate" value="pm">$<?php echo $tpl['option_arr_values']['pm']; ?>
                        </td>
                         <td class="td">
                            <input id="pm_amount" class="form-control input-sm" type="text" name="amount[]" size="25" value="<?php echo (($tpl['arr'] ?? [])['rate'] ?? '' == 'pm') ? $tpl['option_arr_values']['pm'] : ""; ?>" title="Paid" placeholder="$">
                        </td>                       
                    </tr>
                    <tr class="tr">
                        <td colspan="2" class="td">Maintenance (LM and higher)-per calendar Year </td> 
                        <td class="td">
                            <input <?php echo (($tpl['arr'] ?? [])['rate'] ?? '' == 'lm_h') ? "checked='checked'" : ""; ?> required="" type="radio" name="rate" value="lm_h">$<?php echo $tpl['option_arr_values']['lm_h']; ?>
                        </td>
                        <td class="td">
                            <input id="lm_h_amount" class="form-control input-sm" type="text" name="amount[]" size="25" value="<?php echo (($tpl['arr'] ?? [])['rate'] ?? '' == 'lm_h') ? $tpl['option_arr_values']['lm_h'] : ""; ?>" title="Paid" placeholder="$">
                        </td>                        
                    </tr>
                    <tr class="tr">
                        <td colspan="2" class="td">Extra Donation</td>
                        <td class="td">Any Amount</td>
                        <td class="td">
                            <input id="donation" class="form-control input-sm" type="text" name="donation" size="25" value="<?php echo ($tpl['arr'] ?? [])['donation'] ?? ''; ?>" title="Paid" placeholder="$">
                        </td>                        
                    </tr>
                    <tr class="tr">  
                        <td colspan="3" class="td" colspan="2">Total</td>
                        <td class="td">
                            <input id="total" class="form-control input-sm" type="text" name="total" size="25" value="<?php echo ($tpl['arr'] ?? [])['total'] ?? ''; ?>" title="Paid" placeholder="$">
                        </td>                        
                    </tr>
                    <tr class="tr">
                        <td class="td" colspan="2">
                            <h3>Payment Method</h3>
                        </td>
                        <td class="td" colspan="2">
                            <select required="" name="Payment_method" id="Payment_method" class="form-control input-sm medium valid" aria-required="true" aria-invalid="false" style="width:100%;  height:50%;"> 
                                <option value="" class ="amd">---</option>
                                <?php
                                $payment_method_arr = __('payment_method_arr');
                                foreach ($payment_method_arr as $k => $v) {
                                    if (($k == 'stripe' && $tpl['option_arr_values']['stripe_allow'] == '1') || ($k == 'others' && $tpl['option_arr_values']['others_allow'] == '1') || ($k == 'paypal' && $tpl['option_arr_values']['paypal_allow'] == '1') || ($k == 'authorize' && $tpl['option_arr_values']['authorize_allow'] == '1') || ($k == '2checkout' && $tpl['option_arr_values']['2checkout_allow'] == '1') || ($k == 'pay_arrival' && $tpl['option_arr_values']['pay_arrival_allow'] == '1') || ($k == 'credit_card' && $tpl['option_arr_values']['credit_card_allow'] == '1') || ($k == 'bank_acount' && $tpl['option_arr_values']['bank_acount_allow'] == '1')) {
                                        ?>
                                        <option value="<?php echo $k; ?>" ><?php echo $v; ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </td>     
                    </tr>
                    <?php if ($this->controller->isAdmin()) { ?>
                        <tr class="tr">  
                            <td class="td">
                                <label class="control-label" for="type"><?php echo __('type'); ?>:</label>
                            </td>
                            <td class="td">
                                <?php echo __('member'); ?>
                            </td>                        
                            <td class="td">
                                <label class="control-label" for="type"><?php echo __('user_status'); ?>:</label>
                            </td>
                            <td class="td">
                                <select required="" name="status" id="status" class="form-control input-sm medium" >
                                    <option value="">---</option>
                                    <?php
                                    $user_status_arr = __('member_status_arr');
                                    foreach ($user_status_arr as $k => $v) {
                                        ?>
                                        <option <?php echo (($tpl['arr'] ?? [])['status'] ?? '' == $k) ? "selected='selected'" : ""; ?> value="<?php echo $k; ?>" ><?php echo $v; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>
                    <?php } ?>
                    <tr id="stripe_details" class="tr" style="display: none;">
                        <td class="td" colspan="4">
                            <div class="form-row row col-sm-6">
                                <label for="card-element">
                                    Credit or debit card
                                </label>
                                <div id="card-element">
                                    <!-- A Stripe Element will be inserted here. -->
                                </div>

                                <!-- Used to display Element errors. -->
                                <div id="card-errors" role="alert"></div>
                            </div>
                        </td>                    
                    </tr>
                    <tr id="others_details" style="display: none;">
                        <td class="td" colspan="4">
                            <div class="form-group">
                                <label class="control-label" for="confirm_code"><?php echo __('confirm_code'); ?>:</label>
                                <input data-rule-required='true' id="confirm_code" class="form-control input-sm" type="text" name="confirm_code" size="25" value="" title="<?php echo __('confirm_code'); ?>" placeholder="<?php echo __('confirm_code'); ?>">
                                <div class="control-group"></div>
                                <div id="error_code"></div>
                            </div>
                        </td>
                    </tr>
                </table>
                <input type="hidden" name="pay_user" value="1" /> 
                <input type="hidden" name="ID" value="<?php echo ($tpl['arr'] ?? [])['ID'] ?? ''; ?>" />
                <input type="hidden" name="stripeToken" id="stripeToken" value="" />
                <button id="member_btn_id" class="btn btn-primary" autocomplete="off" value="<?php echo __('pay'); ?>" name="pay" tabindex="9" type="submit">
                    <i class="fa fa-fw fa-save"></i>&nbsp;&nbsp;<?php echo __('pay') ?>
                </button>
            </fieldset>
        </div>
    </form>
    <div id="dialogDeleteImage" title="<?php echo htmlspecialchars(__('gallery_del_title')); ?>" style="display:none">
        <p><?php echo __('gallery_del_body'); ?></p>
    </div>
</section>
<div id="stripe_secret_key_id" style="display: none"><?php echo $tpl['option_arr_values']['stripe_publish_key']; ?></div>