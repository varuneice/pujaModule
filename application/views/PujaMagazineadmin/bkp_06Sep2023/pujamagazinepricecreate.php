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
        <?php echo __('All Magazine'); ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo INSTALL_URL; ?>"><i class="fa fa-dashboard"></i> <?php echo __('home'); ?></a></li>
        <li><a href="<?php echo INSTALL_URL; ?>PujaMagazineadmin/index"><?php echo __('Magazine'); ?></a></li>
        <li class="active"><?php echo __('All Magazine'); ?></li>
    </ol>
</section>
<?php
require_once VIEWS_PATH . 'Layouts/admin/error_notice.php';

?>
<section class="content left width_100">
    <form id="edit_user" class="frm-class user-frm-class" action="<?php echo INSTALL_URL; ?>PujaMagazineadmin/pujamagazinepricecreate" method="post" name="" enctype="multipart/form-data">
        <div class="padding-19 nav-tabs-custom left width_100">
            <fieldset>
            <h1  style ="margin:0; font-size:24px; color:#2679b5;">Add New Magazine & Price</h1><br>
                <table class="table">
                    <tr> 
                    <th>Magazine Name</th>
                    <th>Price</th>
                    </tr>
                    <tr class="tr">
                    <td class="td"><input  required="true" id="namemagazine" class="form-control input-sm" type="text" name="magazinename" size="25" value="" title="<?php echo __('Magazine Name'); ?>" placeholder="Magazine Name"></td>
                   
                    <td class="td"><input  required="true" id="Price" class="form-control input-sm" type="number" name="price" size="25" value="" title="<?php echo __('Price'); ?>" placeholder="Price" min="0" oninput="validity.valid||(value='');" onchange="amountvalid(this.id)"></td>
                    </tr>
                </table>
                <fieldset>
                    <input type="hidden" name="pujamagazineprice" value="1" /> 
                    <button id="submit" class="btn btn-primary" autocomplete="off" value="<?php echo __('save'); ?>" name="submit" tabindex="" type="submit"><i class="fa fa-fw fa-save"></i>&nbsp;&nbsp;<?php echo __('save') ?></button>
                </fieldset>
                
              
            </fieldset>
</div> 
</form>
</section>
<script> 
function amountvalid(){
        const price =  parseInt($("#Price").val());
        if(price >= 1){
           $("#submit").removeClass('disabled');
        }
        else{
            alert("Please Enter Valid Amount ");
            $("#Price").prop('required',true);
            $("#submit").addClass('disabled');
        }
     }
</script> 