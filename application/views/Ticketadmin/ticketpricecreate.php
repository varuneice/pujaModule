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
        <?php echo __('Ticket Price'); ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo INSTALL_URL; ?>"><i class="fa fa-dashboard"></i> <?php echo __('home'); ?></a></li>
        <li><a href="<?php echo INSTALL_URL; ?>PujaTicketAdmin/index"><?php echo __('Ticket Price'); ?></a></li>
        <li class="active"><?php echo __('Amount'); ?></li>
    </ol>
</section>
<?php
require_once VIEWS_PATH . 'Layouts/admin/error_notice.php';

?>
<section class="content left width_100">
    <form id="edit_user" class="frm-class user-frm-class" action="<?php echo INSTALL_URL; ?>Ticketadmin/ticketpricecreate" method="post" name="ticketpricecreate" enctype="multipart/form-data">
        <div class="padding-19 nav-tabs-custom left width_100">
            <fieldset>
            <h1  style ="margin:0; font-size:24px; color:#2679b5;">Add Amount</h1><br>
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
                        <option value="kpFireworks">KP Fireworks</option>
                     <!--   <option value="bothkaliandsaraswatipuja">Both Kali and Saraswati Puja</option> -->
                    </select> </td>
                    <td class="td"><select required="" name="type" id="tickettype"
                                class="form-control input-sm" aria-required="true" aria-invalid="false">
                                <option value="">Please Ticket Type</option> 
                               <!-- <option value="individual">Individual</option>-->
                                <option value="additional_adult">Adult</option>
                               <!-- <option value="additional_child">Additional Child</option>-->
                                 </select></td>
                    <td class="td"><input  required="true" id="Price" class="form-control input-sm" type="number" name="price" size="25" value="" title="<?php echo __('Price'); ?>" placeholder="Price" min="0" oninput="validity.valid||(value='');" onchange="amountvalid(this.id)"></td>
                    
                        </tr>
                        </table>
               
                   
                <fieldset>
                    <input type="hidden" name="ticketpricecreate" value="1" /> 
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