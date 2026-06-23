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
		
		/* .box{
    overflow-x:auto!important;
} */
#table-frm-id .dropdown-menu{
    
}
 </style>
<div class="overlay"></div>
<div class="loading-img"></div>
<table id="<?php echo (count($tpl['pujaregarr'] ?? [])) ? "puja_magazineprice_table" : ""; ?>" class="gzblog-table table-striped table-hover" cellpadding="0" cellspacing="0" >
    <thead>
        <tr>
       
            <th><?php echo __('Magazine Name'); ?></th>
            <th><?php echo __('price'); ?></th>
            <th class="icon-th"></th>
            <th class="icon-th"></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $count = count($tpl['pujaregarr'] ?? []);
        $status_arr = __('status_arr');
        if ($count > 0) {
            for ($i = 0; $i < $count; $i++) {
            //    $dataid =strtotime($tpl['sankalpaarr'][$i]['id']);
            //    $datadesc = ksort($dataid);

            //    $statusactive = $tpl['pujaregarr'][$i]['Status'];
               ?>
              <tr class="<?php echo $i % 2 === 0 ? 'odd' : 'even'; ?>">
                   <td><?php echo $tpl['pujaregarr'][$i]['magazinename']; ?></td>
                   <td><?php echo Util::currenctFormat($tpl['option_arr_values']['currency'], $tpl['pujaregarr'][$i]['price']); ?></td>
                   <?php if ($this->controller->isAdmin())  { ?>
                   <td><a class="btn btn-success btn-sm" href="<?php echo INSTALL_URL; ?>PujaMagazineadmin/pujamagazinepriceedit/<?php echo $tpl['pujaregarr'][$i]['id']; ?>" rev="<?php echo $tpl['pujaregarr'][$i]['id']; ?>"><span class="glyphicon glyphicon-eye-open"></span></a></td>
                   <?php }?>
                   <?php if (!$this->controller->isAdmin())  { ?>
                    <td><a rev="<?php echo $tpl['pujaregarr'][$i]['id']; ?>" href=""><span></span></a></td>
                    <?php }?>
                   <?php if ($this->controller->isAdmin()) { ?>
                   <td><a cat="4" class="btn btn-danger btn-sm icon-delete" rev="<?php echo $tpl['pujaregarr'][$i]['id']; ?>" href="<?php echo INSTALL_URL; ?>PujaMagazineadmin/delete/<?php echo $tpl['pujaregarr'][$i]['id']; ?>"><span class="glyphicon glyphicon-remove"></span></a></td>
                   <?php }?>
                   <?php if (!$this->controller->isAdmin())  { ?>
                    <td><a cat="4" rev="<?php echo $tpl['pujaregarr'][$i]['id']; ?>" href=""><span></span></a></td>
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
if ($('#puja_magazineprice_table').length > 0) {
            $('#puja_magazineprice_table').dataTable({
                "aoColumnDefs": [
                    {'bSortable': false, 'aTargets': [1, 4]}
                ]
            });
        }
 </script>