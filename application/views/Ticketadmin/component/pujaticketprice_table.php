<div class="overlay"></div>
<div class="loading-img"></div>
 <table id="tab-ticketprice-table-id" class="gzblog-table table-striped table-hover" cellpadding="0" cellspacing="0" >
 
<thead>
       <tr>
        <th><?php echo __('Puja Type'); ?></th>
        <th><?php echo __('Type'); ?></th>
        <th><?php echo __('price'); ?></th>
            <th class="icon-th"></th>
            <th class="icon-th"></th>    
        </tr>
    </thead>
    <tbody>
        <?php
        $count = count($tpl['pujaticketpricearr'] ?? []);
        $status_arr = __('status_arr');
        if ($count > 0) {
            for ($i = 0; $i < $count; $i++) {
              $pujaname =   $tpl['pujaticketpricearr'][$i]['pujaname'];
              if($pujaname == 'kalipuja'){
               $puja = 'Kali Puja';
              }
              elseif($pujaname == 'saraswatipuja'){
                $puja = 'Saraswati Puja';
              }
              elseif($pujaname == 'kpFireworks'){
                $puja = 'KP Fireworks';
              }
              else{
                $puja = 'Both Kali and Saraswati Puja';
              }
               
              $tickettype = $tpl['pujaticketpricearr'][$i]['type'];
                if($tickettype == 'individual'){
                $ticket = 'Individual';
                }elseif($tickettype == 'additional_adult'){
                $ticket = 'Adult';
                }
                else{
                    $ticket = 'Additional Child';  
                }
               ?>
              <tr class="<?php echo $i % 2 === 0 ? 'odd' : 'even'; ?>">
                   <td><?php echo $puja; ?></td>
                   <td><?php echo $ticket; ?></td>
                   <td><?php echo $tpl['pujaticketpricearr'][$i]['price']; ?></td>
                    <?php if ($this->controller->isAdmin()) { ?>
                   <td><a class="btn btn-success btn-sm" href="<?php echo INSTALL_URL; ?>Ticketadmin/ticketpriceedit/<?php echo $tpl['pujaticketpricearr'][$i]['id']; ?>" rev="<?php echo $tpl['pujaticketpricearr'][$i]['id']; ?>"><span class="glyphicon glyphicon-eye-open"></span></a></td>
                   <?php } ?> 
                   <?php if (!$this->controller->isAdmin())  { ?>
                    <td><a  rev="<?php echo $tpl['pujaticketpricearr'][$i]['id']; ?>" href=""><span></span></a></td>
                    <?php }?> 
                    <?php if ($this->controller->isAdmin())  { ?>
                   <td><a cat="3" class="btn btn-danger btn-sm icon-delete" rev="<?php echo $tpl['pujaticketpricearr'][$i]['id']; ?>" href="<?php echo INSTALL_URL; ?>Ticketadmin/delete/<?php echo $tpl['pujaticketpricearr'][$i]['id']; ?>"><span class="glyphicon glyphicon-remove"></span></a></td>
                   <?php } ?>
                   <?php if (!$this->controller->isAdmin())  { ?>
                    <td><a  rev="<?php echo $tpl['pujaticketpricearr'][$i]['id']; ?>" href=""><span></span></a></td>
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
                        <li><a href="<?php echo INSTALL_URL ?>Category/export"><?php echo __('export'); ?></a></li>
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
if ($('#tab-ticketprice-table-id').length > 0) {
            $('#tab-ticketprice-table-id').dataTable({
                "aoColumnDefs": [
                    {'bSortable': false, 'aTargets': [1, 3]}
                ]
            });
        }
 </script>