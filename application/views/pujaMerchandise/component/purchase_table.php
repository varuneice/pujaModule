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
    .box{
    overflow-x:auto!important;
} 
</style>
<div class="overlay"></div>
<div class="loading-img"></div>
<table id="purchasedTable" class="gzblog-table table-striped table-hover" cellpadding="0" cellspacing="0">
    <thead>
        <tr>
                <th><?php echo __('Order Date'); ?></th>
                <th><?php echo __('Member Id'); ?></th>
                <th><?php echo __('Member Name'); ?></th>
                <th><?php echo __('Order Id'); ?></th>
                <th><?php echo __('Spouse Name'); ?></th>
                <th><?php echo __('Punjabi Name'); ?></th>
                <th><?php echo __('Punjabi Beige-Red Quantity'); ?></th> 
                <th><?php echo __('Punjabi Beige-Red Size'); ?></th>
                <th><?php echo __('Punjabi White-Red Quantity'); ?></th>
                <th><?php echo __('Punjabi White-Red Size'); ?></th>
                <th><?php echo __('Saree Name'); ?></th>
                <th><?php echo __('Saree Terracotta Quantity'); ?></th>
                <th><?php echo __('Saree Tussar Quantity'); ?></th>
                <th><?php echo __('City'); ?></th>
                <th><?php echo __('State'); ?></th>
                <th><?php echo __('Amount'); ?></th>
                <th><?php echo __('Payment Mode'); ?></th>
                <th><?php echo __('Date of Payment'); ?></th>
                <th><?php echo __('Status'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $count = count($tpl['allPurchaseData']);
        if ($count > 0) {
            for ($i = 0; $i < $count; $i++) {
                $date = $tpl['allPurchaseData'][$i]['pay_date'];
                $formattedDate = date('m/d/y', strtotime($date));
                $paymentOptions = "";
                    if($tpl['allPurchaseData'][$i]['PaymentOption'] == "stripe" )
                    {
                        $paymentOptions = "Credit Card" ;
                    }
                   elseif ($tpl['allPurchaseData'][$i]['PaymentOption'] == "others")
                    {
                        $paymentOptions = "Zelle" ;
                    }
                    else
                    {
                        $paymentOptions = $tpl['allPurchaseData'][$i]['PaymentOption'];
                    }

                ?>
                <tr class="<?php echo $i % 2 === 0 ? 'odd' : 'even'; ?>">      
                   <td><?php echo $formattedDate?></td>
                   <td><?php echo $tpl['allPurchaseData'][$i]['member_id']; ?></td>
                   <td><?php echo $tpl['allPurchaseData'][$i]['F_Name'] . ' ' . $tpl['allPurchaseData'][$i]['L_Name'] ?></td>
                   <td><?php echo $tpl['allPurchaseData'][$i]['oid']; ?></td> 
                   <td><?php echo $tpl['allPurchaseData'][$i]['SFirst_Name'] . ' ' . $tpl['allPurchaseData'][$i]['SLast_Name'] ?></td>
                   <td><?php echo $tpl['allPurchaseData'][$i]['punjabi_name']; ?></td>
                   <td><?php echo $tpl['allPurchaseData'][$i]['punjabi_beige_red_qty']; ?></td>
                   <td><?php echo $tpl['allPurchaseData'][$i]['punjabi_beige_red_size']; ?></td>
                   <td><?php echo $tpl['allPurchaseData'][$i]['punjabi_white_red_qty']; ?></td>
                   <td><?php echo $tpl['allPurchaseData'][$i]['punjabi_white_red_size']; ?></td>
                   <td><?php echo $tpl['allPurchaseData'][$i]['saree_name']; ?></td>
                   <td><?php echo $tpl['allPurchaseData'][$i]['saree_terracotta_qty']; ?></td>
                   <td><?php echo $tpl['allPurchaseData'][$i]['saree_tussar_qty']; ?></td>
                   <td><?php echo $tpl['allPurchaseData'][$i]['City']; ?></td>
                   <td><?php echo $tpl['allPurchaseData'][$i]['State']; ?></td>
                   <td><?php echo Util::currenctFormat($tpl['option_arr_values']['currency'], $tpl['allPurchaseData'][$i]['amount']); ?></td>
                   <td><?php echo $paymentOptions ; ?></td>
                   <td><?php echo $tpl['allPurchaseData'][$i]['CheckDate']; ?></td>
                   <td>
                    <?php if ($tpl['allPurchaseData'][$i]['status'] == "confirmed" || $tpl['allPurchaseData'][$i]['status'] == "succeeded" ) { ?>
                        <span class="label label-confirmed"><?php echo "Confirmed"; ?></span>
                     <?php
                    } else {
                            ?>
                        <span class="label label-danger"><?php echo "Failed"; ?></span>
                        <?php
                    } ?>
                    </td>
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
                <?php if ($this->controller->isAdmin()) { ?>
                    <td colspan="9">
                        <div class="btn-group">
                            <button type="button" class="btn btn-primary btn-flat"><?php echo __('action'); ?></button>
                            <button type="button" class="btn btn-primary btn-flat dropdown-toggle" data-toggle="dropdown">
                                <span class="caret"></span>
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                <li><a
                                        href="<?php echo INSTALL_URL ?>pujaMerchandise/export"><?php echo __('export'); ?></a>
                                </li>
                                <li class="divider" style="display:none;"></li>
                                <li style="display:none;"><a id="delete-selected-id"
                                        href="javascript:;"><?php echo __('delete_selected'); ?></a></li>
                                <li class="divider" style="display:none;"></li>
                            </ul>
                        </div>
                    </td>
                <?php } ?>

            </tr>
        </tfoot>
</table>
<script>
    if ($('#purchasedTable').length > 0) {
        $('#purchasedTable').dataTable({
            "aoColumnDefs": [
                {'bSortable': false, 'aTargets': [1, 4]}
            ]
        });
    }
</script>