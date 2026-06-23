<style>
    @media only screen and (max-width: 499px) {
        .right-side {
            margin-left: 0px !important;
        }
    }

    @media (min-width: 500px) and (max-width: 767px) {
        .right-side {
            margin-left: 0px !important;
        }
    }

    @media (min-width: 768px) and (max-width: 830px) {
        .right-side {
            margin-left: 0px !important;
        }
    }

    @media(min-width: 831px) and (max-width: 990px) {
        .right-side {
            margin-left: 0px !important;
        }
    }
</style>
<div class="overlay"></div>
<div class="loading-img"></div>

<table id="priceTable" class="gzblog-table table-striped table-hover" cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th><?php echo __('Cloth Type'); ?></th>
            <th><?php echo __('Cloth Name'); ?></th>
            <th><?php echo __('Early Price'); ?></th>
           
           <th><?php echo __('Early Purchase Limit'); ?></th>
            <th><?php echo __('Regular Price'); ?></th>
            <th><?php echo __('Regular Purchase Limit'); ?></th>
           
            <!-- <th><?php echo __('Cloth Image'); ?></th> -->
            <th class="icon-th"></th>
            <th class="icon-th"></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $count = count($tpl['merchandiseAllData']);
        if ($count > 0) {
            for ($i = 0; $i < $count; $i++) {
                ?>
                <tr class="<?php echo $i % 2 === 0 ? 'odd' : 'even'; ?>">

                    <td><?php echo $tpl['merchandiseAllData'][$i]['cloth_type']; ?></td>


                    <td><?php echo $tpl['merchandiseAllData'][$i]['cloth_name']; ?></td>

                    <td><?php echo Util::currenctFormat($tpl['option_arr_values']['currency'], $tpl['merchandiseAllData'][$i]['price_early']); ?>
                    </td>

                    <td><?php echo $tpl['merchandiseAllData'][$i]['limit_early']; ?></td>

                    <td><?php echo Util::currenctFormat($tpl['option_arr_values']['currency'], $tpl['merchandiseAllData'][$i]['price_regular']); ?>
                    </td>

                    <td><?php echo $tpl['merchandiseAllData'][$i]['limit_regular']; ?></td>

                    <td><a class="btn btn-success btn-sm"
                            href="<?php echo INSTALL_URL; ?>pujaMerchandise/editPriceLimit/<?php echo $tpl['merchandiseAllData'][$i]['id']; ?>"><span
                                class="glyphicon glyphicon-pencil"></span></a></td>

                     <td><a class="btn btn-danger btn-sm"
                            href="<?php echo INSTALL_URL; ?>pujaMerchandise/deleteItem/<?php echo $tpl['merchandiseAllData'][$i]['id']; ?>"><span
                                class=" glyphicon glyphicon-remove"></span></a></td> 
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
    if ($('#priceTable').length > 0) {
        $('#priceTable').dataTable({
            "aoColumnDefs": [
                { 'bSortable': false, 'aTargets': [1, 4] }
            ]
        });
    }
</script>