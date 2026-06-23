<form id="edit_user" class=" user-frm-class" action="<?php echo INSTALL_URL; ?>pujaMerchandise/editDeadline/"
    method="post" name="" enctype="multipart/form-data">
    <table id=""
        class="gzblog-table table-striped table-hover" cellpadding="0" cellspacing="0">
        <tbody>
            
       
            <tr class="tr">
                <td class="td"><label>Early Purchase Deadline</label></td>
                <td class="td">

                <input style="width: 50%;" value="<?php echo !empty($tpl['deadline']['deadline']) ? date('Y-m-d', strtotime($tpl['deadline']['deadline'])) : ''; ?>" type="date" name="deadline" id="deadlineDate">

                </td>
            </tr>
        </tbody>
    </table>
    <br>
  
    

   

    <?php if ($this->controller->isAdmin()) { ?>
        <button id="submit" class="btn btn-primary" autocomplete="off" value="<?php echo __('save'); ?>" name="submit"
            tabindex="9" type="submit"><i class="fa fa-fw fa-save"></i>&nbsp;&nbsp;<?php echo __('save') ?></button>
    <?php } ?>
</form>


<script>
   
</script>