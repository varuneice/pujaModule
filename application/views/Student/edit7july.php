<style>
    .medium{
        width: 450px !important;
    }
</style>
<?php
?>
<section class="content-header">
    <h1>
        <?php echo __('edit__student'); ?>
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
    <form id="edit_student" class="frm-class user-frm-class" action="<?php echo INSTALL_URL; ?>Student/edit" method="post" name="create" enctype="multipart/form-data">
        <div class="padding-19 nav-tabs-custom left width_100">
            <div class="form-group">
                <label class="control-label" for="first"><?php echo __('Student Name'); ?>:</label>
                <input id="first" class="form-control input-sm" type="text" name="St_Name" size="25" value="<?php echo ($tpl['arr'] ?? [])['St_Name'] ?? ''; ?>" title="<?php echo __('Student Name'); ?>">
            </div>
            <div class="form-group">
                <label class="control-label" for="type">Kala Bhavan & Bangla School</label>
                <select name="fee" id="fee" class="form-control input-sm medium valid" aria-required="true" aria-invalid="false">
                    <option value="">---</option>
                    <option <?php echo (($tpl['arr'] ?? [])['fee'] ?? '' == 1) ? "selected='selected'" : ""; ?> value="1">Annual : $<?php echo $tpl['option_arr_values']['student_annual']; ?> /subject (for Non-member)</option>
                    <option <?php echo (($tpl['arr'] ?? [])['fee'] ?? '' == 2) ? "selected='selected'" : ""; ?> value="2">Semester : $<?php echo $tpl['option_arr_values']['student_semester']; ?> /subject (for Non-member)**</option>
                </select>
            </div>
           <div class="form-group">
                    <label class="control-label" for="F_Name">Member ID</label>
                    <select required="" id="MemberID" name="oid" data-live-search="true" class="form-control input-sm selectpicker">
                        <option value="">---</option>
                        <?php
                        foreach ($tpl['members'] as $key => $value) {
                            ?>
                            <option <?php echo ((($tpl['arr'] ?? [])['oid'] ?? '') == $value['Member_id']) ? "selected='selected'" : ""; ?> value="<?php echo $value['Member_id']; ?>"><?php echo $value['F_Name'].' '.$value['L_Name']; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
            <div class="form-group">
                <?php
                $subject = unserialize(($tpl['arr'] ?? [])['subject'] ?? '');
                ?>
                <label class="control-label" for="Sp_FName">Student 1</label>
                <select name="subject[]" id="type" class="form-control input-sm medium valid" aria-required="true" aria-invalid="false" multiple>
                    <option value="">---</option>
                    <option value="Art" <?php echo (in_array('Art', $subject)) ? "selected='selected'" : ""; ?>>Art</option>
                    <option value="Bharatnatyam" <?php echo (in_array('Art', $subject)) ? "selected='selected'" : ""; ?>>Bharatnatyam </option>       
                    <option value="Classical" <?php echo (in_array('Classical', $subject)) ? "selected='selected'" : ""; ?>>Classical</option>
                    <option value="Odissi" <?php echo (in_array('Odissi', $subject)) ? "selected='selected'" : ""; ?>>Odissi</option>
                    <option value="Rabindra" <?php echo (in_array('Rabindra', $subject)) ? "selected='selected'" : ""; ?>>Rabindra Sangeet</option>
                    <option value="Tabla" <?php echo (in_array('Tabla', $subject)) ? "selected='selected'" : ""; ?>>Tabla </option>
                    <option value="Contemporary" <?php echo (in_array('Contemporary', $subject)) ? "selected='selected'" : ""; ?>>Contemporary</option>
                    <option value="clubs" <?php echo (in_array('clubs', $subject)) ? "selected='selected'" : ""; ?>>clubs various clubs</option>
                    <option value="College" <?php echo (in_array('College', $subject)) ? "selected='selected'" : ""; ?>>College Prep Math</option>
                    <option value="Bangla" <?php echo (in_array('Bangla', $subject)) ? "selected='selected'" : ""; ?>>Bangla Elocution & Drama</option>
                    <option value="Bridge" <?php echo (in_array('Bridge', $subject)) ? "selected='selected'" : ""; ?>>Bridge</option>
                    <option value="Kathak" <?php echo (in_array('Kathak', $subject)) ? "selected='selected'" : ""; ?>>Kathak -5pm</option>
                    <option value="Manipuri" <?php echo (in_array('Manipuri', $subject)) ? "selected='selected'" : ""; ?>>Manipuri Dance Workshop Rehearshals </option>
                    <option value="Begineer" <?php echo (in_array('Begineer', $subject)) ? "selected='selected'" : ""; ?>>Begineer </option>
                    <option value="One" <?php echo (in_array('One', $subject)) ? "selected='selected'" : ""; ?>>Level_One</option>
                    <option value="Two" <?php echo (in_array('Two', $subject)) ? "selected='selected'" : ""; ?>>Level_Two</option>
                    <option value="Three" <?php echo (in_array('Three', $subject)) ? "selected='selected'" : ""; ?>>Level_Three</option>
                    <option value="Four" <?php echo (in_array('Four', $subject)) ? "selected='selected'" : ""; ?>>Level_Four</option>
                </select>
            </div>
            <div class="form-group">
                <?php
                $type = unserialize(($tpl['arr'] ?? [])['type'] ?? '');
                ?>
                <label class="control-label" for="Child1">Student 2</label>
                <select name="type[]" id="type" class="form-control input-sm medium valid" aria-required="true" aria-invalid="false" multiple>
                    <option value="">---</option>
                    <option value="Art" <?php echo (in_array('Art', $type)) ? "selected='selected'" : ""; ?>>Art</option>
                    <option value="Bharatnatyam" <?php echo (in_array('Bharatnatyam', $type)) ? "selected='selected'" : ""; ?>>Bharatnatyam </option>       
                    <option value="Classical" <?php echo (in_array('Classical', $type)) ? "selected='selected'" : ""; ?>>Classical</option>
                    <option value="Odissi" <?php echo (in_array('Odissi', $type)) ? "selected='selected'" : ""; ?>>Odissi</option>
                    <option value="Rabindra" <?php echo (in_array('Rabindra', $type)) ? "selected='selected'" : ""; ?>>Rabindra Sangeet</option>
                    <option value="Tabla" <?php echo (in_array('Tabla', $type)) ? "selected='selected'" : ""; ?>>Tabla </option>
                    <option value="Contemporary" <?php echo (in_array('Contemporary', $type)) ? "selected='selected'" : ""; ?>>Contemporary</option>
                    <option value="clubs" <?php echo (in_array('clubs', $type)) ? "selected='selected'" : ""; ?>>clubs various clubs</option>
                    <option value="College" <?php echo (in_array('College', $type)) ? "selected='selected'" : ""; ?>>College Prep Math</option>
                    <option value="Bangla" <?php echo (in_array('Bangla', $type)) ? "selected='selected'" : ""; ?>>Bangla Elocution & Drama</option>
                    <option value="Bridge" <?php echo (in_array('Bridge', $type)) ? "selected='selected'" : ""; ?>>Bridge</option>
                    <option value="Kathak" <?php echo (in_array('Kathak', $type)) ? "selected='selected'" : ""; ?>>Kathak -5pm</option>
                    <option value="Manipuri" <?php echo (in_array('Manipuri', $type)) ? "selected='selected'" : ""; ?>>Manipuri Dance Workshop Rehearshals </option>
                    <option value="Begineer" <?php echo (in_array('Begineer', $type)) ? "selected='selected'" : ""; ?>>Begineer </option>
                    <option value="One" <?php echo (in_array('One', $type)) ? "selected='selected'" : ""; ?>>Level_One</option>
                    <option value="Two" <?php echo (in_array('Two', $type)) ? "selected='selected'" : ""; ?>>Level_Two</option>
                    <option value="Three" <?php echo (in_array('Three', $type)) ? "selected='selected'" : ""; ?>>Level_Three</option>
                    <option value="Four" <?php echo (in_array('Four', $type)) ? "selected='selected'" : ""; ?>>Level_Four</option>
                </select>
            </div>
            <div class="form-group">
                <label class="control-label" for="F_Name">Session</label>
                <input id="Your_Name" class="form-control input-sm" type="text" name="session" size="25" value="<?php echo ($tpl['arr'] ?? [])['session'] ?? ''; ?>" title="Session" placeholder="session">
            </div>
            <div class="form-group">
                <label class="control-label" for="F_Name">Pay Date</label>
                <input id="Your_Name" class="form-control input-sm" type="text" name="pay_date" size="25" value="<?php echo ($tpl['arr'] ?? [])['pay_date'] ?? ''; ?>" title="MemberID" placeholder="Pay_date">
            </div>
            <div class="form-group">
                <label class="control-label" for="F_Name">Remarks</label>
                <input id="Your_Name" class="form-control input-sm" type="text" name="remarks" size="25" value="<?php echo ($tpl['arr'] ?? [])['remarks'] ?? ''; ?>" title="MemberID" placeholder="Remarks">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="F_Name">Created On</label>
            <input id="Your_Name" class="form-control input-sm" type="text" name="CreatedOn" size="25" value="<?php echo ($tpl['arr'] ?? [])['CreatedOn'] ?? ''; ?>" title="CreatedOn" placeholder="CreatedOn">
        </div>
        <div class="form-group">
            <label class="control-label" for="F_Name">Update on</label>
            <input id="Your_Name" class="form-control input-sm" type="text" name="update_on" size="25" value="<?php echo ($tpl['arr'] ?? [])['update_on'] ?? ''; ?>" title="update_on" placeholder="update on">
        </div>
        
        <fieldset>
            <input type="hidden" name="edit_Student" value="1" /> 
            <input type="hidden" name="id" value="<?php echo ($tpl['arr'] ?? [])['id'] ?? ''; ?>" />
            <button class="btn btn-primary" autocomplete="off" value="Save" name="reset" tabindex="9" type="submit"><i class="fa fa-refresh"></i>&nbsp;&nbsp;Reset</button>
            <button class="btn btn-primary" autocomplete="off" value="Save" name="pay" tabindex="9" type="submit"><i class="fa fa-fw fa-save"></i>&nbsp;&nbsp;Payment</button>
        </fieldset>
    </form>
</section>
