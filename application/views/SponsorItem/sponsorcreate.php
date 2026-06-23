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
        <?php echo __('Sponsor Item Name'); ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo INSTALL_URL; ?>"><i class="fa fa-dashboard"></i> <?php echo __('home'); ?></a></li>
        <li><a href="<?php echo INSTALL_URL; ?>SponsorItem/index"><?php echo __('Sponsor Item Name'); ?></a></li>
       
    </ol>
</section>
<?php
require_once VIEWS_PATH . 'Layouts/admin/error_notice.php';

?>
<section class="content left width_100">
    <form id="edit_user" class="frm-class user-frm-class" action="<?php echo INSTALL_URL; ?>SponsorItem/sponsorcreate" method="post" name="sponsorcreate" enctype="multipart/form-data">
        <div class="padding-19 nav-tabs-custom left width_100">
            <fieldset>
            <h1  style ="margin:0; font-size:24px; color:#2679b5;">Sponsor Item Name</h1><br>
                <table class="table">
                    <tr> 
                    <th>Item Name</th>
                    <th>Category</th>
                    
                    </tr>
                    <tr class="tr">
                    <td class="td"><input  required="true" id="sponsoritem" style ="height: 59px;" class="form-control input-sm" type="text" name="itemname" size="25" value="" title="<?php echo __('Item Name'); ?>" placeholder="Item Name"></td>
                    <td class="td">
                        <select required="" name="category" id="sponsortype" style ="height: 59px;"
                                  class="form-control input-sm" aria-required="true" aria-invalid="false">
                                  <option value="">Please Select</option> 
                                  <option value="Category A"> Category A</option>
                                    <option value="Category B"> Category B</option>
                                 
                        </select>
                    </td>
                   
                </table>
                <fieldset>
                    <input type="hidden" name="sponsorcreate" value="1" /> 
                    <button id="submit" class="btn btn-primary" autocomplete="off" value="<?php echo __('save'); ?>" name="submit" tabindex="" type="submit"><i class="fa fa-fw fa-save"></i>&nbsp;&nbsp;<?php echo __('save') ?></button>
                </fieldset>
                
              
            </fieldset>
</div> 
</form>
</section>
