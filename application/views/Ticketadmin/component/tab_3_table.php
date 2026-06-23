<style>
 @media only screen and (max-width: 499px){
		 .right-side {
              margin-left:0px!important;
             }
	}
		@media (min-width: 500px) and (max-width: 767px) {
			.right-side {
              margin-left:0px!important;
             }
		}

		@media (min-width: 768px) and (max-width: 830px) {
            .right-side {
              margin-left:0px!important;
             }
		}

		@media(min-width: 831px) and (max-width: 990px) {
			.right-side {
              margin-left:0px!important;
             }
		}
 </style>
<div class="overlay"></div>
<div class="loading-img"></div>
<table id="ticket-table-id" class="gzblog-table table-striped table-hover" cellpadding="0" cellspacing="0" >
<thead>
        <tr>
        <th><?php echo __('Event Name'); ?></th>
        <th><?php echo __('Image'); ?></th>
        <th><?php echo __('Description'); ?></th>  
        <th class="icon-th"></th>
        <th class="icon-th"></th>
       
        </tr>
    </thead>
    <tbody>
        <?php
        $count = count($tpl['Eventticketarr'] ?? []);
        $status_arr = __('status_arr');
        if ($count > 0) {
            for ($i = 0; $i < $count; $i++) {
           
               ?>
              <tr class="<?php echo $i % 2 === 0 ? 'odd' : 'even'; ?>">
                   <td><?php echo $tpl['Eventticketarr'][$i]['ticketevents']; ?></td>
                   <td><?php echo $tpl['Eventticketarr'][$i]['ticketavatar']; ?></td>
                   <td><?php echo $tpl['Eventticketarr'][$i]['descriptionTable']; ?></td>
                   <?php if ($this->controller->isAdmin()) { ?>
                   <td><a class="btn btn-success btn-sm" href="<?php echo INSTALL_URL; ?>Ticketadmin/ticketedit/<?php echo $tpl['Eventticketarr'][$i]['id']; ?>" rev="<?php echo $tpl['Eventticketarr'][$i]['id']; ?>"><span class="glyphicon glyphicon-eye-open"></span></a></td>
                   <?php } ?> 
                   <?php if (!$this->controller->isAdmin())  { ?>
                    <td><a  rev="<?php echo $tpl['Eventticketarr'][$i]['id']; ?>" href=""><span></span></a></td>
                    <?php }?> 
                   <?php if ($this->controller->isAdmin())  { ?>
                   <td><a cat="2" class="btn btn-danger btn-sm icon-delete" rev="<?php echo $tpl['Eventticketarr'][$i]['id']; ?>" href="<?php echo INSTALL_URL; ?>Ticketadmin/delete/<?php echo $tpl['Eventticketarr'][$i]['id']; ?>"><span class="glyphicon glyphicon-remove"></span></a></td>
                   <?php } ?>
                   <?php if (!$this->controller->isAdmin())  { ?>
                    <td><a cat="2" rev="<?php echo $tpl['Eventticketarr'][$i]['id']; ?>" href=""><span></span></a></td>
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
        <tr style="display:none;">
            <td colspan="9" >
                <div class="btn-group" >
                    <button type="button" class="btn btn-primary btn-flat"><?php echo __('action'); ?></button>
                    <button type="button" class="btn btn-primary btn-flat dropdown-toggle" data-toggle="dropdown">
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="<?php echo INSTALL_URL ?>Ticketadmin/export"><?php echo __('export'); ?></a></li>
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
if ($('#ticket-table-id').length > 0) {
            $('#ticket-table-id').dataTable({
                "aoColumnDefs": [
                    {'bSortable': false, 'aTargets': [1, 3]}
                ]
            });
        }

 </script>