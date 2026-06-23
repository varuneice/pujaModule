<section class="content-header">
    <h1>
        <?php echo __('Edit Magazine Price'); ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo INSTALL_URL; ?>"><i class="fa fa-dashboard"></i> <?php echo __('home'); ?></a></li>
        <li><a href="<?php echo INSTALL_URL; ?>PujaMagazineadmin/pujamagazinepriceedit"><?php echo __('Edit Magazine Price'); ?></a></li>
        <li class="active"><?php echo __('Edit Magazine Price'); ?></li>
    </ol>
</section>
<?php
require_once VIEWS_PATH . 'Layouts/admin/error_notice.php';
$pricetype = $tpl['allmagazinepricearr']['pricefor'];
$familyindividual = $tpl['allmagazinepricearr']['pricetype'];

?>
<section class="content left width_100">
    <form id="edit_user" class="frm-class user-frm-class" action="<?php echo INSTALL_URL; ?>PujaMagazineadmin/pujamagazinepriceedit" method="post" name="pujamagazinepriceedit" enctype="multipart/form-data">
        <div class="padding-19 nav-tabs-custom left width_100">
            <fieldset>
            <h1  style ="margin:0; font-size:24px; color:#2679b5;">Edit Puja & Price</h1><br>
            <table class="table">
                <tr>
                    <th>Magazine Name</th>
                    <th>Price</th>
                </tr>
                    <tr class="tr">
                    <td class="td"><input  required="true" id="magazinename" class="form-control input-sm" type="text" name="magazinename" size="25" value="<?php echo $tpl['allpujapricearr']['magazinename']; ?>" title="<?php echo __('Magazine Name'); ?>" placeholder="Magazine Name"></td>
                        <td class="td"><input required="true" id="Price" class="form-control input-sm" type="number" name="price" size="25" value="<?php echo $tpl['allpujapricearr']['price']; ?>" title="<?php echo __('Price'); ?>" placeholder="Price" min="0" oninput="validity.valid||(value='');" onchange="amountvalid(this.id)"></td>
                  </tr> 
                </table>
                <fieldset>
                   <input type="hidden" name="pujamagazinepriceedit" value="1" /> 
                    <input type="hidden" name="id" value="<?php echo $tpl['allpujapricearr']['id']; ?>" />
                    <button id="submit" class="btn btn-primary" autocomplete="off" value="<?php echo __('save'); ?>" name="submit" tabindex="9" type="submit"><i class="fa fa-fw fa-save"></i>&nbsp;&nbsp;<?php echo __('save') ?></button>
                </fieldset>
            </fieldset>
        </div>
    </form>
   
    </div>
</section>
 <script >
$(document).ready(function() {

    pricetypecheck();
    priceformember();
  
});


var pricefor = <?php echo(json_encode($pricetype)); ?>;
function pricetypecheck(){
    if(pricefor !=null || pricefor == "" || pricefor == " "){
 $("#pricefor").val(pricefor);
}

}

var priceformemberind = <?php echo(json_encode($familyindividual)); ?>;
function priceformember(){

    if(priceformemberind !=null || priceformemberind == "" || priceformemberind == " "){
     $("#typefamind").val(priceformemberind);
}

}

function amountvalid(){
        const price =  parseInt($("#Price").val());
        if(price >= 0){
           $("#submit").removeClass('disabled');
        }
        else{
            alert("Please Enter Valid Amount ");
            $("#Price").prop('required',true);
            $("#submit").addClass('disabled');
        }
     }
</script> 