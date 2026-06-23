<style>
    th {
        border: 1px solid black;
        text-align: left;
        background-color: #f6f6f6;
        border-collapse: collapse;
    }
</style>



<section class="content-header">
    <h1>
        <?php echo __('Edit Session'); ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo INSTALL_URL; ?>"><i class="fa fa-dashboard"></i> <?php echo __('home'); ?></a></li>
        <!-- <li><a href="<?php echo INSTALL_URL; ?>Booking/index"><?php echo __('Amount'); ?></a></li>
        <li class="active"><?php echo __('Amount'); ?></li> -->
    </ol>
</section>
<?php
require_once VIEWS_PATH . 'Layouts/admin/error_notice.php';
$status = $tpl['Codes']['Active'];
?>
<section class="content left width_100">
    <form id="edit_user" class="frm-class user-frm-class" action="<?php echo INSTALL_URL; ?>pujafoodcoupon/codeEdit" method="post" name="codeEdit" enctype="multipart/form-data">
        <div class="padding-19 nav-tabs-custom left width_100">
            <fieldset>
                <h1 style="margin:0; font-size:24px; color:#2679b5;">Edit Session</h1><br>
                <table class="table">
                    <tr>
                        <th>Session Code</th>
                        <th>Session Name</th>
                        <th>Active</th>
                    </tr>
                    <tr class="tr">

                        <td class="td">
                            <input autocomplete="off" class="form-control input-sm" value="<?php echo $tpl['Codes']['sessionCode'];?>" pattern="[A-Za-z0-9\s]+" placeholder="Session Code" title="No special characters allowed"   name = "sessionCode" type="text" required>
                        </td>


                        <td class="td">
                            <input autocomplete="off" class="form-control input-sm" value="<?php echo $tpl['Codes']['sessionName'];?>" pattern="[A-Za-z0-9\s]+" placeholder="Session Name" title="No special characters allowed" name = "sessionName" type="text" required>
                        </td>
                        <td>
                            <select data-rule-required='true' name="Active" id="ddlStatus" class="form-control input-sm" >
                                <option value="Y">Active</option>
                                <option value="N">In Active</option>
                            </select>
                        </td>

                    </tr>
                </table>

                <fieldset>
                    <input type="hidden" name="foodcouponcodeedit" value="1" /> 
                    <input type="hidden" name="id" value="<?php echo $tpl['Codes']['id']; ?>" />
                    <button id="submit" class="btn btn-primary" autocomplete="off" value="<?php echo __('save'); ?>" name="submit" tabindex="" type="submit"><i class="fa fa-fw fa-save"></i>&nbsp;&nbsp;<?php echo __('save') ?></button>
                </fieldset>

            </fieldset>
        </div>
    </form>

</section>
<script>
    $(document).ready(function() {
      setStatusOption();
    });
function setStatusOption(){
  const statusVal = <?php echo(json_encode($status)); ?>;
  if(statusVal !=null || statusVal == "" || statusVal == " "){
   $("#ddlStatus").val(statusVal);
  }

}

</script>