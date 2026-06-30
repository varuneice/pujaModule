<section class="content-header">
    <h1>
        <?php echo __('Puja Passes Price'); ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo INSTALL_URL; ?>"><i class="fa fa-dashboard"></i> <?php echo __('home'); ?></a></li>
        <li><a href="<?php echo INSTALL_URL; ?>PujaPassesAdmin/pujapassespriceedit"><?php echo __('Puja Passes Price'); ?></a></li>
        <li class="active"><?php echo __(' Puja Passes Price'); ?></li>
    </ol>
</section>
<?php
require_once VIEWS_PATH . 'Layouts/admin/error_notice.php';
$pujaname = $tpl['pujapassespricearr']['pujaname'];
//echo $pujaname;
$type = $tpl['pujapassespricearr']['pricefor'];
//echo $type;
$pujatime = $tpl['pujapassespricearr']['pricetype'];
//echo $pujatime;
$price = $tpl['pujapassespricearr']['price'];
//echo $price;

?>
<section class="content left width_100">
    <form id="edit_user" class="frm-class user-frm-class" action="<?php echo INSTALL_URL; ?>PujaPassesadmin/pujapassespriceedit" method="post" name="pujapassespriceedit" enctype="multipart/form-data">
        <div class="padding-19 nav-tabs-custom left width_100">
            <fieldset>
            <h1  style ="margin:0; font-size:24px; color:#2679b5;">Edit Amount</h1><br>
            <table class="table">
            <tr>
                     <th>Passes Puja Name, Day & Time</th>
                    <th>Passes Puja Price For</th>
                    <th>Passes Puja Price Type</th> 
                    <th>Passes Price</th>
                    <th>Parent Price</th>
                    </tr>
                    <tr class="tr">
                    <td class="td"><input required="true" id="pujaDay" class="form-control" type="text" name="pujaname" value="<?php echo $tpl['pujapassespricearr']['pujaname']; ?>" placeholder="Puja Day"></td>
                      <td class="td"><select required="" name="pricefor" id="type"
                                class="form-control input-sm" aria-required="true" aria-invalid="false">
                                <option value="">Please Select Passes Puja Price For</option> 
                                 <option value="member">Member</option>
                                <option value="nonmember">Non Member</option>
                                <option value="student">Student</option>
                                <option value="outoftowner">Out of Towner</option>
                                 </select></td>
                                   <td class="td"><select required="" name="pricetype" id="pujatime"
                                class="form-control input-sm" aria-required="true" aria-invalid="false">
                                <option value="">Please Select Passes Puja Price Type</option> 
                                <option value="family">Family</option>
                                <option value="individual">individual</option>
                                 </select></td>
                        <td class="td"><input required="true" id="price" class="form-control input-sm" type="number" name="price" size="25" value="<?php echo $tpl['pujapassespricearr']['price']; ?>" title="<?php echo __('Price'); ?>" placeholder="Price" min="0" oninput="validity.valid||(value='');" onchange="amountvalid(this.id)"></td>
                        <td class="td"><input id="parentprice" class="form-control input-sm" type="number" name="parentprice" size="25" value="<?php echo htmlspecialchars($tpl['pujapassespricearr']['parentprice'] ?? '', ENT_QUOTES); ?>" title="<?php echo __('Parent Price'); ?>" placeholder="Parent Price" min="0" oninput="validity.valid||(value='');"></td>
                  </tr> 
                </table>
                <fieldset>
                   <input type="hidden" name="pujapassespriceedit" value="1" /> 
                    <input type="hidden" name="id" value="<?php echo $tpl['pujapassespricearr']['id']; ?>" />
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
    //
    pujaname();
    type();
    pujatime();
  
});


var puja = <?php echo(json_encode($pujaname)); ?>;

function pujaname(){
    if(puja !=null || puja == "" || puja == " "){
      $("#pujaname").val(puja);
    }
}

var pujatype = <?php echo(json_encode($type)); ?>;
function type(){
    if(pujatype !=null || pujatype == "" || pujatype == " "){
      $("#type").val(pujatype);
    }
}

var pujatimep = <?php echo(json_encode($pujatime)); ?>;
function pujatime(){
    if(pujatimep !=null || pujatimep == "" || pujatimep == " "){
     $("#pujatime").val(pujatimep);
    }
}


function amountvalid(){
    const price =  parseInt($("#price").val());
    if(price >= 1){
        $("#submit").removeClass('disabled');
    }
    else{
        alert("Please Enter Valid Amount ");
        $("#price").prop('required',true);
        $("#submit").addClass('disabled');
    }
}
</script> 
