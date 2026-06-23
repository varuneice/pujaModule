<section class="content-header">
    <h1>
        <?php echo __('Food Coupons'); ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo INSTALL_URL; ?>"><i class="fa fa-dashboard"></i> <?php echo __('home'); ?></a></li>
        <li><a href="<?php echo INSTALL_URL; ?>pujafoodcoupon/foodcouponpriceedit"><?php echo __('Food Coupons'); ?></a></li>
        <li class="active"><?php echo __('Food Coupons'); ?></li>
    </ol>
</section>
<?php
require_once VIEWS_PATH . 'Layouts/admin/error_notice.php';
$couponcode = $tpl['pricearr']['code'];
$couponitem = $tpl['pricearr']['item'];
$couponstatus = $tpl['pricearr']['status'];



?>
<section class="content left width_100">
    <form id="edit_user" class="frm-class user-frm-class" action="<?php echo INSTALL_URL; ?>pujafoodcoupon/foodcouponpriceedit" method="post" name="foodcouponpriceedit" enctype="multipart/form-data">
        <div class="padding-19 nav-tabs-custom left width_100">
            <fieldset>
            <h1  style ="margin:0; font-size:24px; color:#2679b5;">Food Coupons</h1><br>
            <table class="table">
            <tr>    
                    <th>Code</th>
                    <th>Status</th>
                    <th>Item</th>
                    <th>price</th>
                    </tr>
                    <tr class="tr">
                    <td class="td"><select data-rule-required='true' name="code" id="itemcode" class="form-control input-sm" >
                            <option value="">Select Code:</option>
                            <option value="F1">F1</option>
                            <option value="F2">F2</option>
                            <option value="F3">F3</option>
                            <option value="F4">F4</option>
                            <option value="F5">F5</option>
                            <option value="F6">F6</option>
                        </select></td>
                    <td class="td">
                        <select data-rule-required='true' name="status" id="couponstatus" class="form-control input-sm" >
                            <option value="">Select Status:</option>
                            <option value="Adult">Adult</option>
                            <option value="Child/Student">Child/Student</option>
                            </select>
                    </td>
                    <td class="td">
                        <select data-rule-required='true' name="item" id="couponitem" class="form-control input-sm" >
                            <option value="">Select Item:</option>
                            <option value="Regular">Regular</option>
                            <option value="Outsourced">Outsourced</option>
                            <option value="Special">Special</option>
                        </select>
                    </td>
                    <td class="td"><input required="true" id="price" class="form-control input-sm" type="text" name="price" size="25" value="<?php echo $tpl['pricearr']['price']; ?>" title="<?php echo __('Price'); ?>" placeholder="Price"></td>
                     </tr>
                   
                </table>
                <fieldset>
                   <input type="hidden" name="priestpriceedit" value="1" /> 
                    <input type="hidden" name="id" value="<?php echo $tpl['pricearr']['id']; ?>" />
                    <button id="submit" class="btn btn-primary" autocomplete="off" value="<?php echo __('save'); ?>" name="submit" tabindex="9" type="submit"><i class="fa fa-fw fa-save"></i>&nbsp;&nbsp;<?php echo __('save') ?></button>
                </fieldset>
            </fieldset>

            

        </div>

    </form>
</section>

 <script >
$(document).ready(function() {

    codefor();
    couponitemprice();
    foodstatus();
  
});

var couponcode = <?php echo(json_encode($couponcode)); ?>;
function codefor(){
    if(couponcode !=null || couponcode == "" || couponcode == " "){
 $("#itemcode").val(couponcode);
}
}
var couponitem = <?php echo(json_encode($couponitem )); ?>;
function couponitemprice(){
    if(couponitem !=null || couponitem == "" || couponitem == " "){
 $("#couponitem").val(couponitem);
}
}

var foodcouponstatus = <?php echo(json_encode($couponstatus)); ?>;
function foodstatus(){
    if(foodcouponstatus !=null || foodcouponstatus == "" || foodcouponstatus == " "){
 $("#couponstatus").val(foodcouponstatus);
}
}





</script> 