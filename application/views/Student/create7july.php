<style>
    .medium{
        width: 450px !important;
    }
</style>
<?php
if (!empty($_POST['create_Student'])) {
    ?>
    <section class="content left width_100">
        <div class="padding-19 nav-tabs-custom left width_100">
            <?php
            if (!empty($_SESSION['status'])) {
                ?>
                <div class="alert alert-danger in">
                    <strong><?php echo $_SESSION['status']; ?></strong>
                </div>
                <?php
                unset($_SESSION['status']);
            } else {

                if ($_POST['payment_method'] == 'stripe') {
                    ?>
                    <div class="payment_information">
                        <p class="error" style="font-weight: bold; font-size: 22px;"><?php echo __('payment_information'); ?></p>
                        <p><strong><?php echo __('reference_number'); ?>:</strong> <?php echo ($tpl['arr'] ?? [])['uid'] ?? ''; ?></p>
                        <p><strong><?php echo __('transaction_id'); ?>:</strong> <?php echo $tpl['payment']['balance_transaction']; ?></p>
                        <p><strong><?php echo __('paid_amount'); ?>:</strong> <?php echo Util::currenctFormat($tpl['option_arr_values']['currency'], ($tpl['arr'] ?? [])['amount'] ?? ''); ?></p>
                    </div>
                    <?php
                } else {
                    ?>
                    <div class="alert alert-success  in">
                        <i class="fa-fw fa fa-check"></i>
                        <strong><?php echo __('success'); ?></strong>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    </section>
    <?php
} else {
    ?>
    <section class="content-header">
        <h1>
            <?php echo __('add_Student'); ?>
        </h1>
        <?php if ($this->controller->isLoged()) { ?>
            <ol class="breadcrumb">
                <li><a href="<?php echo INSTALL_URL; ?>"><i class="fa fa-dashboard"></i> <?php echo __('home'); ?></a></li>
                <li><a href="<?php echo INSTALL_URL; ?>Student/index">Students</a></li>
                <li class="active"><?php echo __('add_Student'); ?></li>
            </ol>
        <?php } ?>
    </section>
    <?php
    require_once VIEWS_PATH . 'Layouts/admin/error_notice.php';
    ?>
    <section class="content left width_100">
        <form id="new_student" class="frm-class user-frm-class" action="<?php echo INSTALL_URL; ?>Student/create" method="post" name="create" enctype="multipart/form-data">
            <div class="padding-19 nav-tabs-custom left width_100">
                <div class="form-group">
                    <label class="control-label" for="first"><?php echo __('Student Name'); ?>:</label>
                    <input required="" id="first" class="form-control input-sm" type="text" name="St_Name" size="25" value="" title="<?php echo __('Student Name'); ?>">
                </div>
                <div class="form-group">
                    <label class="control-label" for="type">Kala Bhavan & Bangla School</label>
                    <select required="" name="fee" id="fee" class="form-control input-sm medium valid" aria-required="true" aria-invalid="false">
                        <option value="">---</option>
                        <option value="1">Annual : $<?php echo $tpl['option_arr_values']['student_annual']; ?> /subject (for Non-member)</option>
                        <option value="2">Semester : $<?php echo $tpl['option_arr_values']['student_semester']; ?> /subject (for Non-member)**</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="control-label" for="F_Name">Member ID</label>
                    <select required="" id="MemberID" name="oid" class="form-control input-sm selectpicker" data-live-search="true">
                        <option value="">---</option>
                        <?php
                        foreach (($tpl['members'] ?? []) as $key => $value) {
                            ?>
                            <option value="<?php echo $value['Member_id']; ?>"><?php echo $value['F_Name'].' '.$value['L_Name']; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label class="control-label" for="Sp_FName">Student 1</label>
                    <select required="" name="subject[]" id="type" class="form-control input-sm medium valid" aria-required="true" aria-invalid="false" multiple>
                        <option value="">---</option>
                        <option value="Art">Art</option>
                        <option value="Bharatnatyam">Bharatnatyam </option>       
                        <option value="Classical">Classical</option>
                        <option value="Odissi">Odissi</option>
                        <option value="Rabindra">Rabindra Sangeet</option>
                        <option value="Tabla">Tabla </option>
                        <option value="Contemporary">Contemporary</option>
                        <option value="clubs">clubs various clubs</option>
                        <option value="College">College Prep Math</option>
                        <option value="Bangla ">Bangla Elocution & Drama</option>
                        <option value="Bridge">Bridge</option>
                        <option value="Kathak">Kathak -5pm</option>
                        <option value="Manipuri">Manipuri Dance Workshop Rehearshals </option>
                        <option value="Begineer">Begineer </option>
                        <option value="One">Level_One</option>
                        <option value="Two">Level_Two</option>
                        <option value="Three">Level_Three</option>
                        <option value="Four">Level_Four</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="control-label" for="Child1">Student 2</label>
                    <select required="" name="type[]" id="type" class="form-control input-sm medium valid" aria-required="true" aria-invalid="false" multiple>
                        <option value="">---</option>
                        <option value="Art">Art</option>
                        <option value="Bharatnatyam">Bharatnatyam </option>       
                        <option value="Classical">Classical</option>
                        <option value="Odissi">Odissi</option>
                        <option value="Rabindra">Rabindra Sangeet</option>
                        <option value="Tabla">Tabla </option>
                        <option value="Contemporary">Contemporary</option>
                        <option value="clubs">clubs various clubs</option>
                        <option value="College">College Prep Math</option>
                        <option value="Bangla ">Bangla Elocution & Drama</option>
                        <option value="Bridge">Bridge</option>
                        <option value="Kathak">Kathak -5pm</option>
                        <option value="Manipuri">Manipuri Dance Workshop Rehearshals </option>
                        <option value="Begineer">Begineer </option>
                        <option value="One">Level_One</option>
                        <option value="Two">Level_Two</option>
                        <option value="Three">Level_Three</option>
                        <option value="Four">Level_Four</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="control-label" for="F_Name">Session</label>
                    <input required="" id="Your_Name" class="form-control input-sm" type="text" name="session" size="25" value="" title="Session" placeholder="session">
                </div>
                <div class="form-group">
                    <label class="control-label" for="F_Name">Pay Date</label>
                    <input required="" id="Your_Name" class="form-control input-sm" type="text" name="pay_date" size="25" value="" title="MemberID" placeholder="Pay_date">
                </div>
                <div class="form-group">
                    <label class="control-label" for="F_Name">Remarks</label>
                    <input required="" id="Your_Name" class="form-control input-sm" type="text" name="remarks" size="25" value="" title="MemberID" placeholder="Remarks">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label" for="F_Name">Created On</label>
                <input required="" id="Your_Name" class="form-control input-sm" type="text" name="CreatedOn" size="25" value="" title="CreatedOn" placeholder="CreatedOn">
            </div>
            <div class="form-group">
                <label class="control-label" for="F_Name">Update on</label>
                <input required="" id="Your_Name" class="form-control input-sm" type="text" name="update_on" size="25" value="" title="update_on" placeholder="update on">
            </div>
            <div class="form-group">
                <label class="control-label" for="payment_method"><?php echo __('payment_method'); ?></label>
                <select required="" required="" name="payment_method" id="payment_method" class="form-control input-sm medium valid" aria-required="true" aria-invalid="false" style="width:100%;  height:50%;"> 
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
            </div>
            <div id="stripe_details" style="display: none;">
                <div class="form-group">
                    <label for="card-element">
                        Credit or debit card
                    </label>
                    <div id="card-element">
                        <!-- A Stripe Element will be inserted here. -->
                    </div>

                    <!-- Used to display Element errors. -->
                    <div id="card-errors" role="alert"></div>
                </div>            
            </div>
            <div id="others_details" style="display: none;">
                <div class="form-group">
                    <label class="control-label" for="confirm_code"><?php echo __('confirm_code'); ?>:</label>
                    <input data-rule-required='true' id="confirm_code" class="form-control input-sm" type="text" name="confirm_code" size="25" value="" title="<?php echo __('confirm_code'); ?>" placeholder="<?php echo __('confirm_code'); ?>">
                    <div class="control-group"></div>

                    <div id="error_code"></div>
                </div>
            </div>
            <fieldset>
                <input type="hidden" name="create_Student" value="1" /> 
                <input type="hidden" name="stripeToken" id="stripeToken" value="" />
                <button class="btn btn-primary" autocomplete="off" value="Save" name="reset" tabindex="9" type="submit"><i class="fa fa-refresh"></i>&nbsp;&nbsp;Reset</button>
                <button id="payment_btn_id" class="btn btn-primary" autocomplete="off" value="Save" name="pay" tabindex="9" type="submit"><i class="fa fa-fw fa-save"></i>&nbsp;&nbsp;Payment</button>
            </fieldset>
        </form>
    </section>
<?php } ?>
<div id="stripe_secret_key_id" style="display: none"><?php echo $tpl['option_arr_values']['stripe_publish_key']; ?></div>