<div class="overlay"></div>
<div class="loading-img"></div>
 <table id="tab-sponsoritem-table-id" class="gzblog-table table-striped table-hover" cellpadding="0" cellspacing="0" >
 
<thead>
       <tr>
        <th><?php echo __('Item Name'); ?></th>
        <th><?php echo __('Category'); ?></th>
       
            <th class="icon-th"></th>
            <th class="icon-th"></th>    
        </tr>
    </thead>
    <tbody>
        <?php
        $count = count($tpl['arr']);
        $status_arr = __('status_arr');
        if ($count > 0) {
            for ($i = 0; $i < $count; $i++) {
             
               ?>
              <tr class="<?php echo $i % 2 === 0 ? 'odd' : 'even'; ?>">
                   <td><?php echo $tpl['arr'][$i]['itemname']; ?></td>
                   <td><?php echo $tpl['arr'][$i]['category']; ?></td>
                  
                 <?php if ($this->controller->isAdmin())  { ?>
                   <td><a class="btn btn-success btn-sm" href="<?php echo INSTALL_URL; ?>SponsorItem/sponsoritemedit/<?php echo $tpl['arr'][$i]['id']; ?>" rev="<?php echo $tpl['arr'][$i]['id']; ?>"><span class="glyphicon glyphicon-eye-open"></span></a></td>
                   <?php }?>
                   <?php if (!$this->controller->isAdmin())  { ?>
                    <td><a  rev="<?php echo $tpl['arr'][$i]['id']; ?>" href=""><span></span></a></td>
                    <?php }?>  
                   <?php if ($this->controller->isAdmin())  { ?>
                   <td><a cat="1" class="btn btn-danger btn-sm icon-delete" rev="<?php echo $tpl['arr'][$i]['id']; ?>" href="<?php echo INSTALL_URL; ?>SponsorItem/delete/<?php echo $tpl['arr'][$i]['id']; ?>"><span class="glyphicon glyphicon-remove"></span></a></td>
                   <?php }?> 
                   <?php if (!$this->controller->isAdmin())  { ?>
                    <td><a cat="1" rev="<?php echo $tpl['arr'][$i]['id']; ?>" href=""><span></span></a></td>
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
if ($('#tab-sponsoritem-table-id').length > 0) {
            $('#tab-sponsoritem-table-id').dataTable({
                "aoColumnDefs": [
                    {'bSortable': false, 'aTargets': [1, 3]}
                ]
            });
        }
 </script>