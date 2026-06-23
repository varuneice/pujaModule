<div class="overlay"></div>
<div class="loading-img"></div>
 <table id="tab-passesprice-table-id" class="gzblog-table table-striped table-hover" cellpadding="0" cellspacing="0" >
 
<thead>
       <tr>
        <th><?php echo __('Passes Puja Name & Day'); ?></th>
        <th><?php echo __('Passes For'); ?></th>
        <th><?php echo __('Passes Type'); ?></th>
        <th><?php echo __('Price'); ?></th>
            <th class="icon-th"></th>
            <th class="icon-th"></th>    
        </tr>
    </thead>
    <tbody>
        <?php
        $count = count($tpl['pujapassespriceregarr'] ?? []);
        if ($count > 0) {
            
            for ($i = 0; $i < $count; $i++) {
              $pujaname =   $tpl['pujapassespriceregarr'][$i]['pujaname'];
              $passestype = $tpl['pujapassespriceregarr'][$i]['pricefor'];
              $pujatime = $tpl['pujapassespriceregarr'][$i]['pricetype'];
                
               ?>
              <tr class="<?php echo $i % 2 === 0 ? 'odd' : 'even'; ?>">
                   <td><?php echo $pujaname; ?></td>
                   <td><?php echo $passestype; ?></td>
                   <td><?php echo $pujatime; ?></td>
                   <td><?php echo $tpl['pujapassespriceregarr'][$i]['price']; ?></td>
                   <?php if ($this->controller->isAdmin()) { ?>
                   <td><a class="btn btn-success btn-sm" href="<?php echo INSTALL_URL; ?>PujaPassesadmin/pujapassespriceedit/<?php echo $tpl['pujapassespriceregarr'][$i]['id']; ?>" rev="<?php echo $tpl['pujapassespriceregarr'][$i]['id']; ?>"><span class="glyphicon glyphicon-eye-open"></span></a></td>
                   <?php } ?> 
                   <?php if (!$this->controller->isAdmin())  { ?>
                    <td><a rev="<?php echo $tpl['pujapassespriceregarr'][$i]['id']; ?>" href=""><span></span></a></td>
                    <?php }?>
                   <?php if ($this->controller->isAdmin()) { ?>
                   <td><a cat="3" class="btn btn-danger btn-sm icon-delete" rev="<?php echo $tpl['pujapassespriceregarr'][$i]['id']; ?>" href="<?php echo INSTALL_URL; ?>PujaPassesadmin/delete/<?php echo $tpl['pujapassespriceregarr'][$i]['id']; ?>"><span class="glyphicon glyphicon-remove"></span></a></td>
                   <?php } ?> 
                   <?php if (!$this->controller->isAdmin())  { ?>
                    <td><a cat="1" rev="<?php echo $tpl['pujapassespriceregarr'][$i]['id']; ?>" href=""><span></span></a></td>
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
    <tfoot>
         <tr>
            <td colspan="9" style="display:none">
                <div class="btn-group"> 
                    <button type="button" class="btn btn-primary btn-flat"><?php echo __('action'); ?></button>
                    <button type="button" class="btn btn-primary btn-flat dropdown-toggle" data-toggle="dropdown">
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="<?php echo INSTALL_URL ?>PujaPassesadmin/exportprice"><?php echo __('export'); ?></a></li>
                        <li class="divider" style="display:none;"></li>
                        <li style="display:none;"><a id="delete-selected-id" href="javascript:;"><?php echo __('delete_selected'); ?></a></li>
                        <li class="divider" style="display:none;"></li>
                        <li style="display:none;"><a href="<?php echo INSTALL_URL; ?>Member/create"><?php echo __('add_members'); ?></a></li>
                    </ul>
                </div>
            </td> 
        </tr>
    </tfoot>
</table> 
<script>
if ($('#tab-passesprice-table-id').length > 0) {
            $('#tab-passesprice-table-id').dataTable({
                "aoColumnDefs": [
                    {'bSortable': false, 'aTargets': [1, 3]}
                ]
            });
        }
 </script>