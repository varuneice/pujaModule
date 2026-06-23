<style>
.ui-datepicker-calendar {
    display: none;
}

.ui-datepicker-month {
    display: none;
}

.padding-19 {
    display: none;
}
.ui-icon-circle-triangle-w{
width:35px!important;
}
.ui-icon.ui-icon-circle-triangle-e{
width:35px!important;
margin-left: -29px!important;
font: bold;
}

h4 {
    text-align: center;
    font-family: initial;
}
.icheckbox_minimal{
    display:none;
}
#payment-form > fieldset.asb > table:nth-child(8) > tbody > tr:nth-child(6) > td > div
{display:block;}
</style>
<?php
if (!empty($tpl['arr'])) {
    require 'show.php';
} else {
    ?>
<div id="menu-container" style="width: 70%; margin:3px auto; background-color:rgba(237,237,237) !important;">
    <div id="page-body">
        <main role="main">
            <div class="logo" style="background-color: #357ca5;">
                <img src="../logo.jpg" class="profile" />
                <h3><b>Houston Durga Bari Society</b></h4>
                    <h4><b>Contact: treasurer@durgabari.org </b></h4>
                    <h1 class="logo-caption"><span class="tweak">M</span>embership <span class="tweak">F</span>orm</h1>
            </div>
            <!-- logo class -->
            <form id="payment-form" class="form-horizontal" method="post" action="" role="form"
                enctype="multipart/form-data">
                <input type="hidden" name="login_user" value="1" />
                <fieldset class="asb">
                    <table class="table">
                        <tr colspan="8" class="tr">
                            <td class="td">Applicant Information <span style="color:#ff0000">*</span></td>
                            <td class="td">
                                <input type="radio" id="new" name="information" value="new" Checked>New
                            </td>
                            <td class="td">

                                <?php echo __('Member ID'); ?>

                            </td>
                            <td class="td MemberID">

                                <input id="Member id" class="form-control input-sm" type="text" name="Member_id"
                                    size="12" value="" title="MemberID" placeholder="Member ID" readonly>


                            </td>
                            <td class="td">Date of Renewal<span style="color:#ff0000"></span></td>
                            <td class="td">
                                <input id="Renew_date" class="form-control input-sm" type="text" name="Renew_date"
                                    size="12" value="" title="Renew Date" placeholder="Renewal Date" readonly>
                            </td>
                        </tr>
                    </table>
                    <table class="table">
                        <tr class="tr">
                            <td class="td">Member's First Name<span style="color:#ff0000">*</span></td>
                            <td class="td">
                                <input required="true" id="Your_Name" class="form-control input-sm" type="text"
                                    name="F_Name" size="25" value="" title="First Name" placeholder="First Name">
                            </td>
                            <td class="td">Middle Name</td>
                            <td class="td">
                                <input id="middle name" class="form-control input-sm" type="text" name="M_Name"
                                    size="25" value="" title="Middle Name" placeholder="Middle Name">
                            </td>
                        </tr>
                        <tr class="tr">
                            <td class="td">Last Name <span style="color:#ff0000">*</span></td>
                            <td class="td">
                                <input required="true" id="last name" class="form-control input-sm" type="text"
                                    name="L_Name" size="25" value="" title="Last Name" placeholder="Last Name">
                                <!--  -->
                            </td>
                            <td class="td">
                                Membership Type<span style="color:#ff0000">*</span>
                            </td>
                            <td class="td">
                                <input type="radio" id="individual_membership" name="membership_type"
                                    value="individual_membership" checked />
                                Individual Membership,<br>
                                <input type="radio" id="individual_membership" name="membership_type"
                                    value="family_membership" />
                                Family Membership
                            </td>

                        </tr>
                        <tr class="tr">
                            <td class="td">Spouse Name<span style="color:#ff0000">*</span></td>
                            <td class="td">
                                <input required="true" id="Spouse" class="form-control input-sm" type="text"
                                    name="Sp_FName" size="25" value="" title="Spouse Name" placeholder="Spouse Name">
                            </td>
                            <td class="td">
                                Last Name<span style="color:#ff0000">*</span> </td>
                            <td class="td">
                                <input required="true" id="Spouselast" class="form-control input-sm" type="text"
                                    name="Sp_LName" size="25" value="" title="Spouse Last Name"
                                    placeholder="Spouse Last Name">
                            </td>
                        </tr>
                        <tr class="tr">
                            <!-- <td  class="td">Govt Issued Photo ID/No:<span style="color:#ff0000">*</span></td>
                                <td  class="td"> 
                                    <input type="radio" id="checked" name="GovtissueID" value="checked" checked />
                                     Available
                                     <input type="radio" id="not_available" name="GovtissueID" value="not_available" />
                                     Not Available
                                </td> -->
                            <td class="td">Residential Address<span style="color:#ff0000">*</span></td>
                            <td class="td">
                                <input required="true" id="Address" class="form-control input-sm" type="text"
                                    name="Address1" size="25" value="" title="Address" placeholder="Address">
                            </td>
                            <td class="td">Address 2
                            </td>
                            <td class="td">
                                <input id="Address" class="form-control input-sm" type="text" name="Address2" size="25"
                                    value="" title="Address" placeholder="Address Line 2">
                            </td>
                        </tr>
                        <tr class="tr">
                        <td class="td">Country</td>
                        <td class="td"><div class="dropdown">
    
    <select id="Country" name="Country" class="form-control input-sm medium valid"  style="width:100%!important;  height:50%;">
    <option value="">Please select country details</option>
    <?php
    foreach ($tpl['Country'] as $key => $value) {
        ?>
       
        <option value="<?php echo $value['CountryCode']; ?>"><?php echo $value['Country']; ?></option> 
        <?php
        //echo '<option value="'.$value['Amount'].'">'.$value['Amount']. '</option>';
    }
    ?>
    </select>
    </div>   </td>
                            <td class="td">City<span style="color:#ff0000">*</span></td>
                            <td class="td">
                                <input required="true" id="city" class="form-control input-sm" type="text" name="City"
                                    size="25" value="" title="City" placeholder="City">
                            </td>
                        </tr>
                        <tr class="tr">
                            <td class="td">State<span style="color:#ff0000">*</span> </td>
                            <td class="td">
                                <input required="true" id="state" class="form-control input-sm" type="text" name="State"
                                    size="25" value="" title="State" placeholder="State">
                            </td> .
                            <td class="td">Zip Code<span style="color:#ff0000">*</span></td>
                            <td class="td">
                                <input required="true" id="zip_code" class="form-control input-sm" type="text"
                                    name="Zip" size="25" value="" title="Zip Code" placeholder="Zip Code">
                            </td>
                        </tr>
                        <tr class="tr">
                            <td class="td">Phone No<span style="color:#ff0000">*</span> </td>
                            <td class="td">
                               <input  required="true" id="phone_mobile" class="form-control input-sm" type="tel"
                                    name="Tele1" size="25" value="" title="Mobile No" pattern="[0-9]{3}[0-9]{3}[0-9]{4}" placeholder="016-123-4567">
                            </td>
                            <td class="td">
                                <input id="phone_No" class="form-control input-sm" type="tel" pattern="[0-9]{3}[0-9]{3}[0-9]{4}" name="Mob_No" value=""
                                    title="Phone No" placeholder="Phone No">
                            </td>
                            <td class="td">
                                <input id="phone_work" class="form-control input-sm" type="tel" name="Tele2"
                                    size="25" value="" title="Work Phone" pattern="[0-9]{3}[0-9]{3}[0-9]{4}" placeholder="Work Phone">
                            </td>
                        </tr>
                        <tr class="tr">
                            <td class="td">Email<span style="color:#ff0000">*</span></td>
                            <td class="td">
                               <input type="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" required="true" id="email" class="form-control input-sm" type="text" name="email"
                                    size="25" value="" title="Email" placeholder="Email">
                            </td>
                            <td class="td">Email 2</td>
                            <td class="td">
                                <input id="email2" class="form-control input-sm" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" type="text" name="Email2" size="25"
                                    value="" title="Email 2" placeholder="Email 2">
                            </td>
                        </tr>
                    </table>
                    <table class="table" id="children" style="display: none;">
                        <tr class="tr">
                        <tr class="tr">
                            <td class="td" colspan="8">
                                <h3>Children's Information</h3>
                            </td>
                        </tr>

                        <tr class="tr">
                            <td colspan="4" class="td">Child 1<input id="Child" class="form-control input-sm"
                                    type="text" name="Child1" size="25" value="" title="Child" placeholder="Full Name">
                            </td>
                            <td class="td">Year of Birth<input max="<?php echo date('Y-m-d'); ?>" id="year_birth1"
                                    class="form-control input-sm date-picker" name="Age1" size="25" value=""
                                    title="year_birth" placeholder="Year of Birth"></td>
                            <td class="td">Child 2<input id="Child2" class="form-control input-sm" type="text"
                                    name="Child2" size="25" value="" title="Children" placeholder="Full Name"></td>
                            <td class="td"> Year of Birth<input max="<?php echo date('Y-m-d'); ?>" id="year_birth2"
                                    class="form-control input-sm date-picker" name="Age2" size="25" value=""
                                    title="year_birth" placeholder="Year of Birth"></td>
                        </tr>
                        <tr class="tr">
                            <td colspan="4" class="td">Child 3<input id="Child3" class="form-control input-sm"
                                    type="text" name="Child3" size="25" value="" title="Child" placeholder="Full Name">
                            </td>
                            <td class="td"> Year of Birth<input max="<?php echo date('Y-m-d'); ?>" id="year_birth3"
                                    class="form-control input-sm date-picker" name="Age3" size="25" value=""
                                    title="year_birth" placeholder="Year of Birth"></td>
                            <td class="td">Children 4<input id="Child4" class="form-control input-sm" type="text"
                                    name="Child4" size="25" value="" title="Child" placeholder="Full Name"></td>
                            <td class="td">Year of Birth<input max="<?php echo date('Y-m-d'); ?>" id="year_birth4"
                                    class="form-control input-sm date-picker" name="Age4" size="25" value=""
                                    title="year_birth" placeholder="Year of Birth"></td>
                        </tr>
                        </tr>
                    </table>

                    <table class="table">
                        <tr class="tr">
                            <td class="td" colspan="4">
                                <h3>Membership Categories & Payment Details</h3>
                            </td>
                        </tr>
                        <tr class="tr">
                            <td class="td" colspan="2"><label class="control-label" for="Child"
                                    style="float:left;">Category<span style="color:#ff0000">*</span></label></td>
                            <td class="td"><label class="control-label" for="Child" style="float:left;">
                                    Rate</label><span style="color:#ff0000">*</span> </td>
                            <td class="td"><label class="control-label" for="Child" style="float:left;">Paid</label>
                            </td>
                        </tr>
                        <tr class="tr">
                            <td colspan="2" class="td">General Member-Individual(Due jan1/Apr 1 every year) </td>
                            <td class="td">
                                <input required="" type="radio" name="rate"
                                    value="gmi_1">$<?php echo $tpl['option_arr_values']['gmi_1']; ?>/
                                <input required="" type="radio" name="rate"
                                    value="gmi_4">$<?php echo $tpl['option_arr_values']['gmi_4']; ?>
                            </td>
                            <td class="td">
                                <input id="gmi_amount" class="form-control input-sm" type="text" name="amount[]"
                                    size="25" value="" title="Paid" placeholder="$">
                            </td>
                        </tr>
                        <tr class="tr">
                            <td colspan="2" class="td">General Member-Family(Due jan1/Apr 1 every year)</td>
                            <td class="td">
                                <input required="" type="radio" name="rate"
                                    value="gmf_1">$<?php echo $tpl['option_arr_values']['gmf_1']; ?>/<input type="radio"
                                    name="rate" value="gmf_4">$<?php echo $tpl['option_arr_values']['gmf_4']; ?>
                            </td>
                            <td class="td">
                                <input id="gmf_amount" class="form-control input-sm" type="text" name="amount[]"
                                    size="25" value="" title="Paid" placeholder="$">
                            </td>
                        </tr>
                        <tr class="tr">
                            <td colspan="2" class="td">Life Member(LM) </td>
                            <td class="td">
                                <input required="" type="radio" name="rate"
                                    value="lm">$<?php echo $tpl['option_arr_values']['lm']; ?>
                            </td>
                            <td class="td">
                                <input id="lm_amount" class="form-control input-sm" type="text" name="amount[]"
                                    size="25" value="" title="Paid" placeholder="$">
                            </td>
                        </tr>
                        <!-- <tr class="tr">
                                <td colspan="2" class="td">Benefactor(BF)</td>  
                                <td class="td">
                                    <input required="" type="radio" name="rate" value="bf">$<?php echo $tpl['option_arr_values']['bf']; ?>
                                </td>
                                <td class="td">
                                    <input id="bf_amount" class="form-control input-sm" type="text" name="amount[]" size="25" value="" title="Paid" placeholder="$">
                                </td>                        
                            </tr>
                            <tr class="tr">
                                <td colspan="2" class="td">Patron Member(pm) </td>
                                <td class="td">
                                    <input required="" type="radio" name="rate" value="pm">$<?php echo $tpl['option_arr_values']['pm']; ?>
                                </td>
                                <td class="td">
                                    <input id="pm_amount" class="form-control input-sm" type="text" name="amount[]" size="25" value="" title="Paid" placeholder="$">
                                </td>                        
                            </tr>
                            <tr class="tr">
                                <td colspan="2" class="td">Maintenance (LM and higher)-per calendar Year </td> 
                                <td class="td">
                                    <input required="" type="radio" name="rate" value="lm_h">$<?php echo $tpl['option_arr_values']['lm_h']; ?>
                                </td>
                                <td class="td">
                                    <input id="lm_h_amount" class="form-control input-sm" type="text" name="amount[]" size="25" value="" title="Paid" placeholder="$">
                                </td>                        
                            </tr> -->
                        <tr class="tr">
                            <td class="td" colspan="2">Extra Donation</td>
                            <td class="td">Any Amount</td>
                            <td class="td">
                                <input id="donation" class="form-control input-sm" type="text" name="donation" size="25"
                                    value="" title="Paid" placeholder="$">
                            </td>
                        </tr>
                        <tr class="tr">
                            <td class="td" colspan="3">Total</td>
                            <td class="td">
                                <input id="total" required="true" class="form-control input-sm" type="text" name="total"
                                    size="25" value="" title="Paid" placeholder="$">
                            </td>
                        </tr>
                    </table>
                    <table class="table" id="govtid">
                        <tr class="tr">
                        <tr class="tr">
                            <td class="td" colspan="8">Driving Licence/Passport<span style="color:#ff0000">*</span></td>
                            <td class="td"><input class="form-control" type="file" name="img">
                                <p>Note:Your documents will be kept confidential or will be deleted on verification.</p>
                            </td>

                        </tr>
                        </tr>
                    </table>
                    <table class="table">
                        <?php if ($this->controller->isLoged()) { ?>
                        <tr class="tr">
                            <td class="td" colspan="2">
                                <h3>Payment Method</h3>
                            </td>
                            <td class="td" colspan="2">
                                <select name="Payment_method" id="Payment_method"
                                    class="form-control input-sm medium valid" aria-required="true" aria-invalid="false"
                                    style="width:100%;  height:50%;">
                                    <option value="" class="amd">---</option>
                                    <?php
                                            $payment_method_arr = __('payment_method_arr');
                                            foreach ($payment_method_arr as $k => $v) {
                                                if (($k == 'stripe' && $tpl['option_arr_values']['stripe_allow'] == '1') || ($k == 'others' && $tpl['option_arr_values']['others_allow'] == '1') || ($k == 'paypal' && $tpl['option_arr_values']['paypal_allow'] == '1') || ($k == 'authorize' && $tpl['option_arr_values']['authorize_allow'] == '1') || ($k == '2checkout' && $tpl['option_arr_values']['2checkout_allow'] == '1') || ($k == 'pay_arrival' && $tpl['option_arr_values']['pay_arrival_allow'] == '1') || ($k == 'credit_card' && $tpl['option_arr_values']['credit_card_allow'] == '1') || ($k == 'bank_acount' && $tpl['option_arr_values']['bank_acount_allow'] == '1')) {
                                                    ?>
                                    <option value="<?php echo $k; ?>"><?php echo $v; ?></option>
                                    <?php
                                                }
                                            }
                                            ?>
                                </select>
                            </td>
                        </tr>
                        <?php } ?>
                    </table>
                    <table class="table">
                        <?php if ($this->controller->isLoged() && $this->controller->isAdmin()) { ?>
                        <tr class="tr">
                            <td class="td">
                                <label class="control-label" for="type"><?php echo __('type'); ?>:</label>
                            </td>
                            <td class="td">
                                <input type="hidden" name="type" value="2" />
                                <?php echo __('member'); ?>
                            </td>
                            <td class="td">
                                <label class="control-label" for="type"><?php echo __('user_status'); ?>:</label>
                            </td>
                            <td class="td">
                                <select required="true" name="status" id="status" class="form-control input-sm medium">
                                    <option value="">---</option>
                                    <?php
                                            $user_status_arr = __('member_status_arr');
                                            foreach ($user_status_arr as $k => $v) {
                                                ?>
                                    <option value="<?php echo $k; ?>"><?php echo $v; ?></option>
                                    <?php
                                            }
                                            ?>
                                </select>
                            </td>
                        </tr>
                        <?php } ?>
                        <tr class="tr">
                            <td class="td">Add References</td>
                            <td class="td">
                                <input id="references" class="form-control input-sm" type="text" name="remarks" size="25"
                                    value="" title="References" placeholder="References">
                            </td>
                            <td class="td">Phone No</td>
                                <td class="td"> <input  id="Ref_Phone" class="form-control input-sm" type="tel"
                                    name="Ref_Phone" size="25" value="" title="Phone No" pattern="[0-9]{3}[0-9]{3}[0-9]{4}" placeholder="Phone No">
                                </td>
                                <td  class="td">Date of Application<span style="color:#ff0000">*</span></td>
                                <td class="td">
                              <input required="true" max="<?php echo date('Y-m-d'); ?>"  id="year_birth3" class="form-control input-sm" type="date" name="CreatedOn" size="25" value="" title="Date" placeholder=""></td> 
                        </tr>
                    </table>
                    <table class="table">
                        <tr class="tr">
                            <td class="td" colspan="4">
                                <h3>Declaration Required</h3>
                            </td>
                        </tr>
                        <tr class="tr">
                            <td class="td" colspan="4">
                                <input required="true" type="checkbox"  checked  id="terms" name="terms" value="terms">I pledge
                                that I will cause no harm to HDBS, to its reputation or the reputation of its employees,
                                members and volunteers. I will abide by the rules and regulations of HDBS as set out in
                                its
                                Constitution and Bylaws and policy documents. If I am found to be in any violation, my
                                membership
                                can be denied, suspended or revoked. I understand that if I am a General Member (GM) and
                                I default
                                to pay my dues on time, I will become a donor (GD) and lose all privileges including but
                                not
                                limited to voting rights normally enjoyed by a GM.
                            </td>
                        </tr>
                        <!-- <tr class="tr">
                            <td  class="td" colspan="4">• I wish to become HDBS member for the following interest(s):<input type="checkbox" id="terms" name="terms" value="terms"> Hindu Religion/Spiritual Need 
                                   <input type="checkbox" id="terms" name="terms" value="terms">Bengali Culture <input type="checkbox" id="terms" name="terms" value="terms">Volunteering <input type="checkbox" id="terms" name="terms" value="terms">Other (please note down):
                            </td>                    
                            </tr> -->
                        <!-- <tr class="tr">
                            <td  class="td" colspan="4">How often do you plan to visit Durga Bari* <input type="checkbox" id="terms" name="terms" value="terms"> Regularly (every week) <input type="checkbox" id="terms" name="terms" value="terms"> Once a month <input type="checkbox" id="terms" name="terms" value="terms"> Only during 
                              major pujas <input type="checkbox" id="terms" name="terms" value="terms"> Never</td>                    
                            </tr> -->
                        <tr class="tr">
                            <td class="td" colspan="4">
                                <input required="true" type="checkbox" checked  id="terms" name="terms" value="terms">
                                I hereby declare that the above information is correct to the best of my knowledge. I
                                shall
                                notify HDBS in writing, if there is any change to the above information within one month
                                of the change.
                            </td>
                        </tr>
                        <tr class="tr">
                            <td class="td" colspan="4">
                                <input required="true" type="checkbox" checked  id="terms" name="terms" value="terms">
                                I authorize HDBS to communicate with me by e-mail, and share my contact information in
                                HDBS
                                magazine(s) or on the HDBS website.
                            </td>
                        </tr>
                        <tr class="tr">
                            <td class="td" colspan="4">
                                <input required="true" type="checkbox" checked id="terms" name="terms" value="terms">
                                I understand that my visit to Durga Bari will be at my own
                                risk and I will hold HDBS or its volunteers harmless from any liability and loss.
                            </td>
                        </tr>
                        <tr class="tr">
                            <td class="td" colspan="4">
                                <input required="true" type="checkbox" id="terms" name="terms" value="terms">
                                By clicking the submit button below, I hereby agree to and accept the following terms and conditions.
                            </td>
                        </tr>
                    </table>
                </fieldset>
                <fieldset>
                    <input type="hidden" name="create_member" value="1" />
                    <button id="submit" class="btn btn-primary" autocomplete="off" value="<?php echo _('save'); ?>"
                        name="submit" tabindex="9" type="submit"><i
                            class="fa fa-fw fa-save"></i>&nbsp;&nbsp;<?php echo _('Submit') ?></button>
                </fieldset>
            </form>
        </main>
    </div>
</div>
<?php } ?>
<script>
$(function() {


    $('.date-picker').datepicker({
        changeMonth: false,
        changeDate: false,
        changeYear: true,
        showButtonPanel: true,
        dateFormat: 'yy',
        maxDate: new Date(new Date().getFullYear(), 1, 1),
        onClose: function(dateText, inst) {
            //var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
            var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
            $(this).datepicker('setDate', new Date(year, 1, 1));
        }
    });
});
</script>