<div class="overlay"></div>
<div class="loading-img"></div>
 <table id="tab-sankalpaprice-table-id" class="gzblog-table table-striped table-hover" cellpadding="0" cellspacing="0" >
 
<thead>
       <tr>
        <th><?php echo __('Puja Name'); ?></th>
        <th><?php echo __('Price Type'); ?></th>
        <th><?php echo __('Price'); ?></th>
        <th><?php echo __('Discount Price'); ?></th>
            <th class="icon-th"></th>
            <th class="icon-th"></th>    
        </tr>
    </thead>
    <tbody>
        <?php
        $count = count($tpl['sankalpapricearr'] ?? []);
        $status_arr = __('status_arr');
        if ($count > 0) {
            for ($i = 0; $i < $count; $i++) {
              $pricetype = $tpl['sankalpapricearr'][$i]['Type'];
                if($pricetype == 'member'){
                $type = 'Member';
                }
                else if($pricetype == 'nonmember'){
                    $type = 'Non-Member';
                }
                else{
                    $type = 'Non-Member(OOT)';  
                }
               ?>
              <tr class="<?php echo $i % 2 === 0 ? 'odd' : 'even'; ?>">
                   <td><?php echo $tpl['sankalpapricearr'][$i]['Pujaname']; ?></td>
                   <td><?php echo $type; ?></td>
                   <td><?php echo Util::currenctFormat($tpl['option_arr_values']['currency'], $tpl['sankalpapricearr'][$i]['Price']); ?></td>
                 <?php if($tpl['sankalpapricearr'][$i]['online_discount'] != ""){
                   ?>
                   <td><?php echo Util::currenctFormat($tpl['option_arr_values']['currency'], $tpl['sankalpapricearr'][$i]['online_discount']); ?></td>
                   <?php
                   }else{
                   ?>
                   <td></td>
                   <?php
                   } ?>
                 <?php if ($this->controller->isAdmin())  { ?>
                   <td><a class="btn btn-success btn-sm" href="<?php echo INSTALL_URL; ?>Pujaregistration/sankalpapriceedit/<?php echo $tpl['sankalpapricearr'][$i]['id']; ?>" rev="<?php echo $tpl['sankalpapricearr'][$i]['id']; ?>"><span class="glyphicon glyphicon-eye-open"></span></a></td>
                   <?php }?>
                   <?php if (!$this->controller->isAdmin())  { ?>
                    <td><a  rev="<?php echo $tpl['sankalpapricearr'][$i]['id']; ?>" href=""><span></span></a></td>
                    <?php }?>  
                   <?php if ($this->controller->isAdmin())  { ?>
                   <td><a cat="2" class="btn btn-danger btn-sm icon-delete" rev="<?php echo $tpl['sankalpapricearr'][$i]['id']; ?>" href="<?php echo INSTALL_URL; ?>Pujaregistration/delete/<?php echo $tpl['sankalpapricearr'][$i]['id']; ?>"><span class="glyphicon glyphicon-remove"></span></a></td>
                   <?php }?> 
                   <?php if (!$this->controller->isAdmin())  { ?>
                    <td><a cat="1" rev="<?php echo $tpl['sankalpapricearr'][$i]['id']; ?>" href=""><span></span></a></td>
                    <?php }?> 

                </tr>
                <?php
            }
        } else {
            ?>
            <tr>
                <td colspan="9">
                    <?php
                    echo __('No matching records found');
                    ?>
                </td>
            </tr>
            <?php
        }
        ?>
    </tbody>
</table> 
<script>
if ($('#tab-sankalpaprice-table-id').length > 0) {
            $('#tab-sankalpaprice-table-id').dataTable({
                "aoColumnDefs": [
                    {'bSortable': false, 'aTargets': [1, 3]}
                ]
            });
        }
 </script>