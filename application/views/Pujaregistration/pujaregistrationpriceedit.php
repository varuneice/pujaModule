<section class="content-header">
    <h1>
        <?php echo __('Edit Puja Price'); ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo INSTALL_URL; ?>"><i class="fa fa-dashboard"></i> <?php echo __('home'); ?></a></li>
        <li><a href="<?php echo INSTALL_URL; ?>Pujaregistration/pujaregistrationpriceedit"><?php echo __('Edit Puja Price'); ?></a></li>
        <li class="active"><?php echo __('Edit Puja Price'); ?></li>
    </ol>
</section>
<?php
require_once VIEWS_PATH . 'Layouts/admin/error_notice.php';
$pricetype = $tpl['allpujapricearr']['pricefor'];
$familyindividual = $tpl['allpujapricearr']['pricetype'];

?>
<section class="content left width_100">
    <form id="edit_user" class="frm-class user-frm-class" action="<?php echo INSTALL_URL; ?>Pujaregistration/pujaregistrationpriceedit" method="post" name="pujaregistrationpriceedit" enctype="multipart/form-data">
        <div class="padding-19 nav-tabs-custom left width_100">
            <fieldset>
            <h1  style ="margin:0; font-size:24px; color:#2679b5;">Edit Puja & Price</h1><br>
            <table class="table">
                <tr>
                    <th>Puja Name</th>
                    <th>Price For</th>
                    <th>Price Type</th>
                    <th>Puja Price</th>
                    <th>Senior Discount</th>
                    <th>Parent Fee</th>
                    <th>Late Fee</th>
                </tr>
                    <tr class="tr">
                    <td class="td"><input  required="true" id="pujname" class="form-control input-sm" type="text" name="pujaname" size="25" value="<?php echo $tpl['allpujapricearr']['pujaname']; ?>" title="<?php echo __('Puja Name'); ?>" placeholder="Puja Name"></td>
                        <td class="td">
                        <select required="" name="pricefor" id="pricefor"
                                class="form-control input-sm" aria-required="true" aria-invalid="false" >
                                <option value="">Please Price For</option> 
                                  <option value="member">Member</option>
                                  <option value="nonmember">Non-Member</option>
                                  <option value="memberoot">Member(Out Of Towner)</option>
                                  <option value="nonmemberoot">Non-Member(Out Of Towner)</option>
                                  <option value="student">Student</option>
                                 </select></td>
                                 <td class="td"><select required="" name="pricetype" id="typefamind"
                                class="form-control input-sm" aria-required="true" aria-invalid="false">
                                <option value="">Please Price Type</option> 
                                <option value="individual">Individual</option>
                                <option value="family">Family</option>
                                 </select></td>
                        <td class="td"><input required="true" id="Price" class="form-control input-sm" type="number" name="price" size="25" value="<?php echo $tpl['allpujapricearr']['price']; ?>" title="<?php echo __('Puja Price'); ?>" placeholder="Puja Price" min="1" oninput="validity.valid||(value='');" onchange="amountvalid(this.id)"></td>
                        <td class="td"><input id="seniordiscount" class="form-control input-sm" type="number" name="seniordiscount" size="25" value="<?php echo $tpl['allpujapricearr']['seniordiscount']; ?>" title="<?php echo __('Senior Discount'); ?>" placeholder="Senior Discount" min="1" oninput="validity.valid||(value='');"></td>
                        <td class="td"><input id="parentfee" class="form-control input-sm" type="number" name="parentregisration" size="25" value="<?php echo $tpl['allpujapricearr']['parentregisration']; ?>" title="<?php echo __('Parent Regisration'); ?>" placeholder="Parent Regisration" min="1" oninput="validity.valid||(value='');"></td>
                        <td class="td"><input  id="latefee" class="form-control input-sm" type="number" name="latefee" size="25" value="<?php echo $tpl['allpujapricearr']['latefee']; ?>" title="<?php echo __('Late Fee'); ?>" placeholder="Late Fee" min="0" oninput="validity.valid||(value='');"></td>
                    </tr> 
                </table>
                <fieldset>
                   <input type="hidden" name="pujaregistrationpriceedit" value="1" /> 
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