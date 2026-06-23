<style>
.ui-datepicker-calendar {
    display: none;
    }
.ui-datepicker-month {
   display: none;
}
</style>
<section class="content-header">
    <h1>
        <?php echo __('edit_member'); ?>
    </h1>
    <?php if (!$this->controller->isMember()) { ?>
        <ol class="breadcrumb">
            <li><a href="<?php echo INSTALL_URL; ?>"><i class="fa fa-dashboard"></i> <?php echo __('home'); ?></a></li>
            <li><a href="<?php echo INSTALL_URL; ?>Member/index"><?php echo __('title_members'); ?></a></li>
            <li class="active"><?php echo __('edit_member'); ?></li>
        </ol>
    <?php } ?>
</section>
<?php
require_once VIEWS_PATH . 'Layouts/admin/error_notice.php';
?>
<section class="content left width_100">
    <form id="payment-form" class="frm-class user-frm-class" action="<?php echo INSTALL_URL; ?>Member/edit" method="post" name="edit" enctype="multipart/form-data">
        <div class="padding-19 nav-tabs-custom left width_100">
            <fieldset>
                <table class="table"> 
                    <tr class="tr">
                        <td class="td">Applicant Information</td>
                        <td class="td">
                            <input <?php echo (($tpl['arr'] ?? [])['information'] ?? '' == 'new') ? "checked='checked'" : ""; ?> type="radio" id="new" name="information" value="new" >
                                                        <label for="new">New</label>
                                                        <input <?php echo (($tpl['arr'] ?? [])['information'] ?? '' == 'renewal') ? "checked='checked'" : ""; ?> type="radio" id="renewal" name="information" value="renewal">
                            <label for="renewal">Renewal</label>
                        </td>
                        <td class="td"> Membership No</td>
                        <td class="td"> 
                            <input disabled="" id="Member_id" class="form-control input-sm" type="text" name="Member_id" size="12" value="<?php echo ($tpl['arr'] ?? [])['Member_id'] ?? ''; ?>" title="MemberID" placeholder="MemberID">
                        </td>
                        <td class="td">Date of Renewal</td>
                        <td class="td"> 
                            <input disabled="" id="Renew_date" class="form-control input-sm" type="text" name="Renew_date" size="12" value="<?php echo ($tpl['arr'] ?? [])['Renew_date'] ?? ''; ?>" title="Renew Date" placeholder="Renew Date">
                        </td>
                    </tr>
    </table>
                    <table class="table">
                    <tr class="tr">
                        <td class="td">
                            Member's First Name<span style="color:#ff0000">*</span>
                        </td>
                        <td class="td">
                            <input id="Your_Name" class="form-control input-sm" type="text" name="F_Name" size="25" value="<?php echo ($tpl['arr'] ?? [])['F_Name'] ?? ''; ?>" title="First Name" placeholder="First Name">
                        </td>
                        <td  class="td">Middle Name<span style="color:#ff0000">*</span></td>    
                                <td  class="td">
                                <input  id="middle name" class="form-control input-sm" type="text" name="M_Name" size="25" value="<?php echo ($tpl['arr'] ?? [])['M_Name'] ?? ''; ?>" title="Middle Name" placeholder="Middle Name">
                                </td>
                                </tr>
                            <tr class="tr">
                            <td  class="td">Last Name <span style="color:#ff0000">*</span></td> 
                                <td  class="td"> 
                                <input required="true" id="last name" class="form-control input-sm" type="text" name="L_Name" size="25" value="<?php echo ($tpl['arr'] ?? [])['L_Name'] ?? ''; ?>" title="Last Name" placeholder="Last Name">
                                   
                                </td>
                                <td class="td">
                                    Membership Type<span style="color:#ff0000">*</span>
                                  </td>
                                  <td colspan="2"  class="td"> 
                            <input <?php echo (($tpl['arr'] ?? [])['membership_type'] ?? '' == 'individual_membership') ? "checked='checked'" : ""; ?> type="radio" id="individual_membership" name="membership_type" value="individual_membership">
                            Individual Mebership
                            <input <?php echo (($tpl['arr'] ?? [])['membership_type'] ?? '' == 'family_membership') ? "checked='checked'" : ""; ?> type="radio" id="family_membership" name="membership_type" value="family_membership">
                            Family Membership
                        </td>
                        </tr> 
                        </tr>
                        <tr class="tr">
                        <td class="td"> 
                        Spouse Name<span style="color:#ff0000">*</span>
                        </td>
                        <td class="td"> 
                            <input id="Spouse" class="form-control input-sm" type="text" name="Sp_FName" size="25" value="<?php echo ($tpl['arr'] ?? [])['Sp_FName'] ?? ''; ?>" title="Spouse Name" placeholder="Spouse Name">
                        </td>
                        <td  class="td">
                                    Last Name<span style="color:#ff0000">*</span> </td>
                                <td  class="td">
                                <input required="true" id="Spouselast" class="form-control input-sm" type="text" name="Sp_LName" size="25" value="<?php echo ($tpl['arr'] ?? [])['Sp_LName'] ?? ''; ?>" title="Last Name" placeholder="Last Name">
                                 </td>
                    </tr>
                    <tr class="tr">
                        <td  class="td">Govt Issued Photo ID/No:<span style="color:#ff0000">*</span> </td>
                        <td  class="td"> 
                            <input <?php echo (($tpl['arr'] ?? [])['GovtissueID'] ?? '' == 'checked') ? "checked='checked'" : ""; ?> type="radio" id="checked" name="GovtissueID" value="checked">
                            Available
                            <input <?php echo (($tpl['arr'] ?? [])['GovtissueID'] ?? '' == 'not_available') ? "checked='checked'" : ""; ?> type="radio" id="not_available" name="GovtissueID" value="not_available">
                            Not Available
                        </td>
                        <td class="td">  City<span style="color:#ff0000">*</span></td>
                        <td class="td"> 
                            <input id="city" class="form-control input-sm" type="text" name="City" size="25" value="<?php echo ($tpl['arr'] ?? [])['City'] ?? ''; ?>" title="city" placeholder="city">  
                        </td>
                    </tr>
                    <tr class="tr">
                        <td  class="td">
                           Residential Address<span style="color:#ff0000">*</span>
                        </td>
                        <td colspan="2" class="td">
                            <input id="Address" class="form-control input-sm" type="text" name="Address1" size="25" value="<?php echo ($tpl['arr'] ?? [])['Address1'] ?? ''; ?>" title="Address" placeholder="Address">
                        </td>  
                        <td  class="td" >
                                    <input  id="Address" class="form-control input-sm" type="text" name="Address2" size="25" value="<?php echo ($tpl['arr'] ?? [])['Address2'] ?? ''; ?>" title="Address" placeholder="Address Line 2">
                                </td>                           
                    </tr>
                    <tr class="tr">
                        <td class="td">
                            State <span style="color:#ff0000">*</span>  </td>
                            <td class="td">
                            <input id="state" class="form-control input-sm" type="text" name="State" size="25" value="<?php echo ($tpl['arr'] ?? [])['State'] ?? ''; ?>" title="state" placeholder="state">  
                        </td>   .
                        <td class="td">
                            Zip Code<span style="color:#ff0000">*</span> 
                        </td>
                        <td  class="td">
                            <input id="zip_code" class="form-control input-sm" type="text" name="Zip" size="25" value="<?php echo ($tpl['arr'] ?? [])['Zip'] ?? ''; ?>" title="zip_code" placeholder="zip_code">  
                        </td>                        
                    </tr>
                    <tr class="tr">
                        <td class="td">
                          Phone No<span style="color:#ff0000">*</span> 
                        </td>
                        <td class="td">
                            <input id="phone_No" class="form-control input-sm" type="number" name=" <input id="Tele1" class="form-control input-sm" type="number" name="Tele1" size="25" value="<?php echo ($tpl['arr'] ?? [])['Tele1'] ?? ''; ?>" title="phone_No" placeholder="phone_No"> 
                        </td>   
                        <td class="td">
                        <input id="phone_No" class="form-control input-sm" type="number" name="Mob_No" size="25" value="<?php echo ($tpl['arr'] ?? [])['Mob_No'] ?? ''; ?>" title="Tele 1" placeholder="Tele1">
                        </td>
                        <td class="td">
                        <input id="phone_work" class="form-control input-sm" type="number" name="Tele2" size="25" value="<?php echo ($tpl['arr'] ?? [])['Tele2'] ?? ''; ?>" title="phone_work" placeholder="phone_work">
                        </td>                        
                    </tr>
                    <tr class="tr">
                        <td class="td">
                          Email<span style="color:#ff0000">*</span> 
                        </td>
                        <td class="td">
                            <input id="email" class="form-control input-sm" type="text" name="email" size="25" value="<?php echo ($tpl['arr'] ?? [])['email'] ?? ''; ?>" title="email" placeholder="Email1">
                        </td>   
                        <td class="td">
                            Email 2
                        </td>
                        <td class="td">  
                            <input id="email" class="form-control input-sm" type="text" name="Email2" size="25" value="<?php echo ($tpl['arr'] ?? [])['Email2'] ?? ''; ?>" title="email" placeholder="Email2">
                        </td>                        
                    </tr>
                    </table>
                            <table id="children" style="display: none;" class="table"> 
                    <tr class="tr">
                        <td class="td" colspan="8" ><h3>Children's Information</h3></td>                     
                    </tr>
                    <tr class="tr">
                    <tr class="tr">
                        <td colspan="4" class="td">Child 1<input id="Child" class="form-control input-sm" type="text" name="Child1" size="25" value="<?php echo ($tpl['arr'] ?? [])['Child1'] ?? ''; ?>" title="Child" placeholder="Child 1"></td>
                        <td class="td">Year of Birth<input max="<?php echo date('Y-m-d'); ?>" id="year_birth" class="form-control input-sm date-picker"  name="Age1" size="25" value="<?php echo ($tpl['arr'] ?? [])['Age1'] ?? ''; ?>" title="year_birth" placeholder=""></td>   
                        <td class="td">Child 2<input id="Child2" class="form-control input-sm" type="text" name="Child2" size="25" value="<?php echo ($tpl['arr'] ?? [])['Child2'] ?? ''; ?>" title="Child" placeholder="Child 2"></td>
                        <td class="td">Year of Birth<input max="<?php echo date('Y-m-d'); ?>" id="year_birth" class="form-control input-sm date-picker" name="Age2" size="25" value="<?php echo ($tpl['arr'] ?? [])['Age2'] ?? ''; ?>" title="year_birth" placeholder=""> </td>                       
                    </tr>
                    <tr class="tr">
                        <td  colspan="4" class="td">Child 3<input id="Child3" class="form-control input-sm" type="text" name="Child3" size="25" value="<?php echo ($tpl['arr'] ?? [])['Child3'] ?? ''; ?>" title="Child" placeholder="Child 3"></td>
                        <td  class="td">Year of Birth<input max="<?php echo date('Y-m-d'); ?>" id="year_birth" class="form-control input-sm date-picker"  name="Child" size="25" value="<?php echo ($tpl['arr'] ?? [])['Age3'] ?? ''; ?>" title="year_birth" placeholder=""></td>   
                        <td  class="td">Child 4<input id="Child4" class="form-control input-sm" type="text" name="Child4" size="25" value="<?php echo ($tpl['arr'] ?? [])['Child4'] ?? ''; ?>" title="Child" placeholder="Child 4"></td>
                        <td  class="td">Year of Birth<input max="<?php echo date('Y-m-d'); ?>" id="year_birth" class="form-control input-sm date-picker" name="Age4" size="25" value="<?php echo ($tpl['arr'] ?? [])['Age4'] ?? ''; ?>" title="year_birth" placeholder=""></td>                       
                    </tr>
                    </tr>
                    </table>
                            <table  class="table"> 
                    <tr class="tr">
                        <td  class="td" colspan="4"><h3>Mebership Categories & Payment Details</h3></td>                     
                    </tr>
                    <tr class="tr">
                                <td class="td" colspan="2"><label class="control-label" for="Child" style="float:left;">Category<span style="color:#ff0000">*</span></label></td>
                        
                                <td class="td"> <label class="control-label" for="Child" style="float:left;">Rate<span style="color:#ff0000">*</span> </label></td>
                                <td class="td"><label class="control-label" for="Child" style="float:left;"> Paid<span style="color:#ff0000">*</span></label> </td>                        
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
                    <!-- <tr class="tr">
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
                    </tr> -->
                    <tr class="tr">
                        <td class="td" colspan="2">Extra Donation</td>   
                        <td class="td">Any Amount</td>
                        <td class="td">
                            <input id="donation" class="form-control input-sm" type="text" name="donation" size="25" value="<?php echo ($tpl['arr'] ?? [])['donation'] ?? ''; ?>" title="Paid" placeholder="$">
                        </td>                        
                    </tr>
                    <tr class="tr">  
                        <td class="td" colspan="3">Total</td>
                        <td class="td">
                            <input id="total" class="form-control input-sm" type="text" name="total" size="25" value="<?php echo ($tpl['arr'] ?? [])['total'] ?? ''; ?>" title="Paid" placeholder="$">
                        </td>                        
                    </tr>
                    </table>
                            <table  class="table"> 
                    <tr class="tr">
                        <td class="td" colspan="2">
                            <h3>Payment Method</h3>
                        </td>
                        <td class="td" colspan="2">
                            <select  name="Payment_method" id="Payment_method" class="form-control input-sm medium valid" aria-required="true" aria-invalid="false" style="width:100%;  height:50%;"> 
                                <option value="" class ="amd">---</option>
                                <?php
                                $payment_method_arr = __('payment_method_arr');
                                foreach ($payment_method_arr as $k => $v) {
                                    if (($k == 'stripe' && $tpl['option_arr_values']['stripe_allow'] == '1') || ($k == 'others' && $tpl['option_arr_values']['others_allow'] == '1') || ($k == 'paypal' && $tpl['option_arr_values']['paypal_allow'] == '1') || ($k == 'authorize' && $tpl['option_arr_values']['authorize_allow'] == '1') || ($k == '2checkout' && $tpl['option_arr_values']['2checkout_allow'] == '1') || ($k == 'pay_arrival' && $tpl['option_arr_values']['pay_arrival_allow'] == '1') || ($k == 'credit_card' && $tpl['option_arr_values']['credit_card_allow'] == '1') || ($k == 'bank_acount' && $tpl['option_arr_values']['bank_acount_allow'] == '1')) {
                                        ?>
                                        <option <?php echo (($tpl['arr'] ?? [])['Payment_method'] ?? '' == $k) ? "selected='selected'" : ""; ?> value="<?php echo $k; ?>" ><?php echo $v; ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </td>     
                    </tr>
                    </table>
                            <table  class="table"> 
                    <tr class="tr">
                        <td class="td" colspan="2">
                         <label>  Image<span style="color:#ff0000">*</span> </label>
                        </td>
                        <td class="td" colspan="2" id="img-file-id">
                            <?php if (is_file(INSTALL_PATH . UPLOAD_PATH . 'avatar/thumb/' . ($tpl['arr'] ?? [])['avatar'] ?? '')) { ?>
                                <fieldset>    
                                    <div class="view view-tenth">   
                                        <img src="<?php echo INSTALL_URL . UPLOAD_PATH . 'avatar/thumb/' . ($tpl['arr'] ?? [])['avatar'] ?? ''; ?>" />
                                        <div class="mask">
                                            <a rev="<?php echo ($tpl['arr'] ?? [])['id'] ?? ''; ?>" class="info btn btn-app btn-danger gallery-delete" href="<?php echo INSTALL_URL; ?>User/deleteImage/<?php echo ($tpl['arr'] ?? [])['id'] ?? ''; ?>"><i class="fa fa-times"></i><?php echo __('remove'); ?></a>
                                        </div>
                                    </div>
                                </fieldset>
                            <?php } else { ?>
                                <input id="avatar" class="form-control input-sm" type="file" name="img" size="25" value="" title="avatar" placeholder="avatar">
                            <?php } ?>
                        </td>     
                    </tr>
                    <tr class="tr">
                        <td class="td" colspan="2">
                            <label>Password</label>
                        </td>
                        <td class="td" colspan="2">
                            <input required="true" id="password" class="form-control input-sm" type="text" name="password" size="25" value="" title="password" placeholder="password">
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
                                <select name="status" id="status" class="form-control input-sm medium" >
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
                    <tr class="tr">
                        <td   colspan="2" class="td">Add Refrences</td> 
                       <td colspan="2"> 
                             <input  id="refrence"  class="form-control input-sm" type="text" name="remarks" size="25" value="<?php echo ($tpl['arr'] ?? [])['remarks'] ?? ''; ?>" title="Refrence" placeholder="Refrence"></td>
                        </td>
                        
                     </tr> 
                                 <tr class="tr">
                                  
                                 <td  colspan="2" class="td">Date of Application</td>
                                 <td>
                                 <input max="<?php echo date('Y-m-d'); ?>" id="year_birth" class="form-control input-sm" type="date" name="Application_date" size="25" value="<?php echo ($tpl['arr'] ?? [])['Application_date'] ?? ''; ?>" title="Date" placeholder="" readonly>    
                                 </td>
                                
                                </tr> 
                                </table>
                            <table  class="table"> 
                    <tr class="tr">
                        <td class="td" colspan="4"><h3>Decleration Required</h3></td>                    
                    </tr>
                    <tr class="tr">
                        <td class="td" colspan="4">
                            <input checked="" required="" type="checkbox" id="terms" name="terms" value="terms">I pledge that I will cause no harm to HDBS, to its reputation or the reputation of its employees, 
                            members and volunteers. I will abide by the rules and regulations of HDBS as set out in its 
                            Constitution and Bylaws and policy documents. If I am found to be in any violation, my membership 
                            can be denied, suspended or revoked. I understand that if I am a General Member (GM) and I default 
                            to pay my dues on time, I will become a donor (GD) and lose all privileges including but not 
                            limited to voting rights normally enjoyed by a GM.
                        </td>                     
                    </tr>
                    <tr class="tr">
                        <td class="td" colspan="4">
                            <input checked="" required="" type="checkbox" id="terms" name="terms" value="terms">I hereby declare that the above information is correct to the best of my knowledge. I shall 
                            notify HDBS in writing, if there is any change to the above information within one month of the change.
                        </td>                    
                    </tr>
                    <tr class="tr">
                        <td class="td" colspan="4">
                            <input checked="" required="" type="checkbox" id="terms" name="terms" value="terms">I authorize HDBS to communicate with me by e-mail, and share my contact information in HDBS 
                            magazine(s) or on the HDBS website.
                        </td>                    
                    </tr>
                    <tr class="tr">
                        <td class="td" colspan="4">
                            <input checked="" required="" type="checkbox" id="terms" name="terms" value="terms">I understand that my visit to Durga Bari will be at my own 
                            risk and I will hold HDBS or its volunteers harmless from any liability and loss.
                        </td>                    
                    </tr>
                    <tr class="tr">
                        <td class="td" colspan="4">
                            <input checked="" required="" type="checkbox" id="terms" name="terms" value="terms">BY SIGNING BELOW, I AGREE WITH ALL OF THE ABOVE.
                        </td>                    
                    </tr>
                </table>
                <input type="hidden" name="edit_user" value="1" /> 
                <input type="hidden" name="ID" value="<?php echo ($tpl['arr'] ?? [])['ID'] ?? ''; ?>" />
                <button id="submit" class="btn btn-primary" autocomplete="off" value="<?php echo __('save'); ?>" name="submit" tabindex="9" type="submit"><i class="fa fa-fw fa-save"></i>&nbsp;&nbsp;<?php echo _('Save') ?></button>
            </fieldset>
        </div>
    </form>
    <div id="dialogDeleteImage" title="<?php echo htmlspecialchars(__('gallery_del_title')); ?>" style="display:none">
        <p><?php echo __('gallery_del_body'); ?></p>
    </div>
</section>
<div id="record_id" style="display:none"></div>
<script>
$(function() {
    $('.date-picker').datepicker( {
        changeMonth: false,
        changeDate: false,
        changeYear: true,
        showButtonPanel: true,
        dateFormat: 'yy',
        maxDate: new Date(new Date().getFullYear()  , 1, 1),
        onClose: function(dateText, inst) { 
            //var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
            var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
            $(this).datepicker('setDate', new Date(year, 1, 1));
        }
    });
});
</script>