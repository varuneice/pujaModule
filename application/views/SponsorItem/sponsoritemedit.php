<section class="content-header">
    <h1>
        <?php echo __('Sponsor Item Name'); ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo INSTALL_URL; ?>"><i class="fa fa-dashboard"></i> <?php echo __('home'); ?></a></li>
        <li><a href="<?php echo INSTALL_URL; ?>SponsorItem/sponsoritemedit"><?php echo __('Sponsor Item Name'); ?></a></li>
        
    </ol>
</section>
<?php
require_once VIEWS_PATH . 'Layouts/admin/error_notice.php';
$pricetype = ($tpl['arr'] ?? [])['category'] ?? '';

?>
<section class="content left width_100">
    <form id="edit_user" class="frm-class user-frm-class" action="<?php echo INSTALL_URL; ?>SponsorItem/sponsoritemedit" method="post" name="sponsoritemedit" enctype="multipart/form-data">
        <div class="padding-19 nav-tabs-custom left width_100">
            <fieldset>
            <h1  style ="margin:0; font-size:24px; color:#2679b5;">Edit Puja & Price</h1><br>
            <table class="table">
                     <tr>
                      <th>item name</th>
                      <th>Category</th>
                    </tr>
                    <tr class="tr">
                    <td class="td"><input  required="true" id="pujname" class="form-control input-sm" type="text" name="itemname" size="25" value="<?php echo ($tpl['arr'] ?? [])['itemname'] ?? ''; ?>" title="<?php echo __('Item Name'); ?>" placeholder="Item Name"></td>
                        <td class="td">
                        <select required="" name="category" id="itemcategorydata"
                                class="form-control input-sm" aria-required="true" aria-invalid="false" >
                                <option value="">Please Select</option> 
                                <option value="Category A"> Category A</option>
                                  <option value="Category B"> Category B</option>
                                 </select></td>
                       
                  </tr> 
                </table>
                <fieldset>
                   <input type="hidden" name="sponsoritemedit" value="1" /> 
                    <input type="hidden" name="id" value="<?php echo ($tpl['arr'] ?? [])['id'] ?? ''; ?>" />
                    <button id="submit" class="btn btn-primary" autocomplete="off" value="<?php echo __('save'); ?>" name="submit" tabindex="9" type="submit"><i class="fa fa-fw fa-save"></i>&nbsp;&nbsp;<?php echo __('save') ?></button>
                </fieldset>
            </fieldset>
        </div>
    </form>
   
    <div id="dialogDeleteImage" title="<?php echo htmlspecialchars(__('gallery_del_title')); ?>" style="display:none">
        <p><?php echo __('gallery_del_body'); ?></p>
    </div>
</section>
 <script >
$(document).ready(function() {

    pricetypecheck();
  
});


var pricefor = <?php echo(json_encode($pricetype)); ?>;
function pricetypecheck(){
    if(pricefor !=null || pricefor == "" || pricefor == " "){
 $("#itemcategorydata").val(pricefor);
}

}

</script> 