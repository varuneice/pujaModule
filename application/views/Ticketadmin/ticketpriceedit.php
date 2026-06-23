<section class="content-header">
    <h1>
        <?php echo __('Ticket Price'); ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo INSTALL_URL; ?>"><i class="fa fa-dashboard"></i> <?php echo __('home'); ?></a></li>
        <li><a href="<?php echo INSTALL_URL; ?>PujaTicketAdmin/ticketpriceedit"><?php echo __('Ticket Price'); ?></a></li>
        <li class="active"><?php echo __(' Ticket Price'); ?></li>
    </ol>
</section>
<?php
require_once VIEWS_PATH . 'Layouts/admin/error_notice.php';
$pujaname = $tpl['ticketpricearr']['pujaname'];
$tickettype = $tpl['ticketpricearr']['type'];

?>
<section class="content left width_100">
    <form id="edit_user" class="frm-class user-frm-class" action="" method="post" name="ticketpriceedit" enctype="multipart/form-data">
        <div class="padding-19 nav-tabs-custom left width_100">
            <fieldset>
            <h1  style ="margin:0; font-size:24px; color:#2679b5;">Edit Amount</h1><br>
            <table class="table">
            <tr>
                    <th>Puja Type</th>
                    <th>Ticket Type</th>
                    <th>Price</th>
                    </tr>
                    <tr class="tr">
                        <td class="td">
                        <select data-rule-required='true' name="pujaname" id="pujatype" class="form-control input-sm" >
                        <option value="">Select Puja Type:</option>
                        <option value="kalipuja">Kali Puja </option>
                        <option value="saraswatipuja">Saraswati Puja</option>
                        <!-- <option value="bothkaliandsaraswatipuja">Both Kali and Saraswati Puja</option> -->
                    </select>
                        </td>
                        <td class="td">
                        <select required="" name="type" id="tickettype"
                                class="form-control input-sm" aria-required="true" aria-invalid="false" >
                                <option value="">Please Ticket Type</option> 
                               <!-- <option value="individual">Individual</option>-->
                               <option value="additional_adult">Adult</option>
                               <!-- <option value="additional_child">Additional Child</option>-->
                                 </select></td>
                        <td class="td"><input required="true" id="Price" class="form-control input-sm" type="number" name="price" size="25" value="<?php echo $tpl['ticketpricearr']['price']; ?>" title="<?php echo __('Price'); ?>" placeholder="Price" min="0" oninput="validity.valid||(value='');" onchange="amountvalid(this.id)"></td>
                  </tr> 
                </table>
                <fieldset>
                   <input type="hidden" name="ticketpriceedit" value="1" /> 
    <input type="hidden" name="id" value="<?php echo $tpl['ticketpricearr']['id']; ?>" />
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
    pujaname();
    tickettypecheck();
  
});


var puja = <?php echo(json_encode($pujaname)); ?>;

function pujaname(){
    if(puja !=null || puja == "" || puja == " "){
 $("#pujatype").val(puja);
}

}


var ticket = <?php echo(json_encode($tickettype)); ?>;
function tickettypecheck(){
    if(ticket !=null || ticket == "" || ticket == " "){
 $("#tickettype").val(ticket);
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