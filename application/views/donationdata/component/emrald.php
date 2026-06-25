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
		.box{
          overflow-x:auto!important;
        }
 </style>
<div class="overlay"></div>
<div class="loading-img"></div>
<table id="<?php echo (count($tpl['emarald'])) ? "tab-2-table-id" : ""; ?>" class="gzblog-table table-striped table-hover" cellpadding="0" cellspacing="0" >
    <thead>
        <tr>
        <th style="display:none;"><?php echo __('ID'); ?></th>
            <th><?php echo __('Member ID'); ?></th>
            <th class="title-th"><?php echo __('Member Name'); ?></th>
            <th><?php echo __('Spouse Name'); ?></th>
            <th><?php echo __('Email'); ?></th>
            <th><?php echo __('Telephone'); ?></th>
             <th><?php echo __('YTD'); ?></th>
              <th><?php echo __('Selected Puja'); ?></th>
               <th><?php echo __('Puja Name'); ?></th>
            
        </tr>
    </thead>
    <tbody>
        <?php
        $count = count($tpl['emarald']);
      
        if ($count > 0) {
            for ($i = 0; $i < $count; $i++) {

                $mName = $tpl['emarald'][$i]['F_Name'] . " " . $tpl['emarald'][$i]['M_Name'] . " "  . $tpl['emarald'][$i]['L_Name'];
                 $sName = $tpl['emarald'][$i]['Sp_FName'] . " " . $tpl['emarald'][$i]['Sp_LName'] ;
                
               ?>
              <tr class="<?php echo $i % 2 === 0 ? 'odd' : 'even'; ?>">
                   <td style="display:none;"> <?php echo   $tpl['emarald'][$i]['F_Name'] ?> </td>
                   
                     <td><?php echo $tpl['emarald'][$i]['Member_id']; ?></td>
                     <td><?php echo $mName; ?></td>
                      <td><?php echo $sName; ?></td>
                     <td><?php echo $tpl['emarald'][$i]['email']; ?></td>
                      <td><?php echo $tpl['emarald'][$i]['Tele1']; ?></td>
                       <td><?php echo $tpl['emarald'][$i]['YTD']; ?></td>
                        <td><?php echo $tpl['emarald'][$i]['selectedpuja']; ?></td>
                         <td><?php echo $tpl['emarald'][$i]['item_name']; ?></td>
                     
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
        <?php if ($this->controller->isAdmin())  { ?>
            <td colspan="9">
                <div class="btn-group">
                    <button type="button" class="btn btn-primary btn-flat"><?php echo __('action'); ?></button>
                    <button type="button" class="btn btn-primary btn-flat dropdown-toggle" data-toggle="dropdown">
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="<?php echo INSTALL_URL ?>donationdata/exportE"><?php echo __('export'); ?></a></li>
                        <li class="divider" style="display:none;"></li>
                        <li style="display:none;"><a id="delete-selected-id" href="javascript:;"><?php echo __('delete_selected'); ?></a></li>
                        <li class="divider" style="display:none;"></li>
                        <li style="display:none;"><a href="<?php echo INSTALL_URL; ?>Member/create"><?php echo __('add_members'); ?></a></li>
                    </ul>
                </div>
            </td>
            <?php } ?> 
        </tr>
    </tfoot>
</table> 
