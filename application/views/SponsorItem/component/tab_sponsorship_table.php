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
<?php $sponsorItems = $tpl['sponsorItemArr'] ?? []; ?>
<table id="<?php echo (count($sponsorItems)) ? "tab-sponsorhip-table-id" : ""; ?>" class="gzblog-table table-striped table-hover" cellpadding="0" cellspacing="0" >
    <thead>
        <tr>  
            <th><?php echo __('Date'); ?></th>
            <th><?php echo __('Member ID'); ?></th>
            <th><?php echo __('First Name'); ?></th>
            <th><?php echo __('Last Name'); ?></th>
            <th><?php echo __('Item Category'); ?></th> 
            <th><?php echo __('Item Name'); ?></th>
            <th class="icon-th" style="display:none;"></th>
            <th class="icon-th" style="display:none;"></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $count = count($sponsorItems);
        $status_arr = __('status_arr');
        if ($count > 0) {
            for ($i = 0; $i < $count; $i++) {
                $sponsorCategoryA = $sponsorItems[$i]['eventsponsorshipcategoryA'];
                $sponsorCategoryB = $sponsorItems[$i]['eventsponsorshipcategoryB'];

                 $pujaSankalpa = $sponsorItems[$i]['Freesankalpapuja'];
                   
                 if ($sponsorCategoryA != "" || $sponsorCategoryB != "") {
                 if($sponsorCategoryA != "")
                    {
                    $selectedCategory = 'Category A';
                    $selectedCategoryName = $sponsorCategoryA;
                    }
                    else if($sponsorCategoryB != "")
                    {
                        $selectedCategory = 'Category B';
                        $selectedCategoryName = $sponsorCategoryB;
                    }
                    else if($pujaSankalpa != "")
                    {
                        $selectedCategory = 'Free Puja Sankalpa';
                        $selectedCategoryName = $pujaSankalpa;

                    }
                    else
                    {
                        $selectedCategory = '';
                        $selectedCategoryName = '';
                    }
                ?>
              <tr class="<?php echo $i % 2 === 0 ? 'odd' : 'even'; ?>">
                   
                   <td><?php echo $sponsorItems[$i]['Paydate']; ?></td>
                   <td><?php echo $sponsorItems[$i]['Member_id']; ?></td>
                   <td><?php echo $sponsorItems[$i]['F_Name'].' ' .$sponsorItems[$i]['M_Name'] ; ?></td>
                   <td><?php echo $sponsorItems[$i]['L_Name']; ?></td>
                   
                   <td><?php echo $selectedCategory ; ?></td>
                   <td><?php echo $selectedCategoryName ; ?></td>
                   <td style="display:none;"><a class="btn btn-success btn-sm" href="<?php echo INSTALL_URL; ?>Sponsorship/Sponsorship/<?php echo $sponsorItems[$i]['ID']; ?>" rev="<?php echo $sponsorItems[$i]['ID']; ?>"><span class="glyphicon glyphicon-pencil"></span></a></td>
                    <td style="display:none;"><a cat="1" class="btn btn-danger btn-sm icon-delete" rev="<?php echo $sponsorItems[$i]['ID']; ?>" href="<?php echo INSTALL_URL; ?>Sponsorship/Sponsorship/<?php echo $sponsorItems[$i]['ID']; ?>"><span class="glyphicon glyphicon-remove"></span></a></td>
                    
                </tr>
                <?php
                }
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
    </tfoot>
</table> 
<script>
if ($('#tab-sponsorhip-table-id').length > 0) {
            $('#tab-sponsorhip-table-id').dataTable({
                "aoColumnDefs": [
                    {'bSortable': false, 'aTargets': [5, 6]}
                ]
            });
        }
</script>
