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
            margin-left: 0px !important;]
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
<div>
    <table id="<?php echo (count($tpl['arr'])) ? "foodcoupom_tab_data" : ""; ?>" class="gzblog-table table-striped table-hover" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?php echo __('Date'); ?></th>
                <th><?php echo __('Member Id'); ?></th>
                <th><?php echo __('Order Id'); ?></th>
                <th><?php echo __('Member Name'); ?></th>
                <th><?php echo __('City'); ?></th>
                <th><?php echo __('State'); ?></th>
                <th><?php echo __('Phone'); ?></th>
                <th><?php echo __('Session Name'); ?></th>
                <th><?php echo __('Coupon Code'); ?></th>
                <th><?php echo __('Coupons For'); ?></th>
                <th><?php echo __('Adult # Request'); ?></th>
                <th><?php echo __('Child # Request'); ?></th>
                <th><?php echo __('Adult # Issued'); ?></th>
                <th><?php echo __('Child # Issued'); ?></th>
                <th><?php echo __('Total # Issued'); ?></th>
                <th><?php echo __('Amount'); ?></th>
                <th><?php echo __('Payment Method'); ?></th>
                <th><?php echo __('Status'); ?></th>

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
                    $statusconfirmed = "Confirmed";
                    // $status = "Payment Failed";
                    $status = "Pending";

                    $datadesc = $tpl['arr'][$i]['id'];

                    $adult = $tpl['arr'][$i]['number_of_adult_coupon'];
                    if ($adult != "") {
                        $adultCoupon = $adult;
                    } else {
                        $adultCoupon = '0';
                    }

                    $adultOutsourced = $tpl['arr'][$i]['number_of_adult_outsourced_coupon'];
                    if ($adultOutsourced != "") {
                        $adultOutsourcedCoupon = $adultOutsourced;
                    } else {
                        $adultOutsourcedCoupon = '0';
                    }

                    $adultSpecial = $tpl['arr'][$i]['number_of_adult_special_coupon'];
                    if ($adultSpecial != "") {
                        $adultSpecialCoupon = $adultSpecial;
                    } else {
                        $adultSpecialCoupon = '0';
                    }

                    $kid = $tpl['arr'][$i]['number_of_kid_coupon'];
                    if ($kid != "") {
                        $kidCoupon = $kid;
                    } else {
                        $kidCoupon = '0';
                    }

                    $kidOutsourced = $tpl['arr'][$i]['number_of_kid_outsourced_coupon'];
                    if ($kidOutsourced != "") {
                        $kidOutsourcedCoupon = $kidOutsourced;
                    } else {
                        $kidOutsourcedCoupon = '0';
                    }

                    $kidSpecial = $tpl['arr'][$i]['number_of_kid_special_coupon'];
                    if ($kidSpecial != "") {
                        $kidSpecialCoupon = $kidSpecial;
                    } else {
                        $kidSpecialCoupon = '0';
                    }

                    $paymethod = $tpl['arr'][$i]['PaymentOption'];
                    if ($paymethod == 'stripe') {
                        $paymentdata = 'Credit Card';
                    } else if ($paymethod == "others") {
                        $paymentdata = 'Zelle';
                    } else if ($paymethod == "cash") {
                        $paymentdata = 'Cash';
                    } else if ($paymethod == "check") {
                        $paymentdata = 'Check';
                    } else if ($paymethod == "directdeposit") {
                        $paymentdata = 'Direct Deposit';
                    } else if ($paymethod == "sumup") {
                        $paymentdata = 'SumUp';
                    } else {
                        $paymentdata = '';
                    }
            ?>
                    <tr class="<?php echo $i % 2 === 0 ? 'odd' : 'even'; ?>">
                        <?php if (($tpl['arr'][$i]['paydate'] ?? '') != "") {
                        ?>
                            <td><?php echo $tpl['arr'][$i]['paydate']; ?></td>
                        <?php
                        } else {
                        ?>
                            <td></td>
                        <?php
                        } ?>
                        <td><?php echo $tpl['arr'][$i]['member_id'] ?? ''; ?></td>
                        <td><?php echo $tpl['arr'][$i]['oid'] ?? ''; ?></td>
                        <td><?php echo ($tpl['arr'][$i]['F_Name'] ?? '') . ' ' . ($tpl['arr'][$i]['L_Name'] ?? ''); ?></td>
                        <td><?php echo $tpl['arr'][$i]['City'] ?? ''; ?></td>
                        <td><?php echo $tpl['arr'][$i]['State'] ?? ''; ?></td>
                        <td><?php echo $tpl['arr'][$i]['phone'] ?? ''; ?></td>
                        <td><?php echo $tpl['arr'][$i]['sessionName'] ?? $tpl['arr'][$i]['couponfor'] ?? ''; ?></td>
                        <td><?php echo $tpl['arr'][$i]['sessionCode'] ?? $tpl['arr'][$i]['activeSessionCode'] ?? ''; ?></td>
                        <td><?php echo $tpl['arr'][$i]['coupontype'] ?? $tpl['arr'][$i]['couponfor'] ?? ''; ?></td>
                        <td><?php echo $tpl['arr'][$i]['Adult_Coupon_Req'] ?? $tpl['arr'][$i]['number_of_adult_coupon'] ?? ''; ?></td>
                        <td><?php echo $tpl['arr'][$i]['Kid_Coupon_Req'] ?? $tpl['arr'][$i]['number_of_kid_coupon'] ?? ''; ?></td>
                        <td><?php echo $adultCoupon + $adultOutsourcedCoupon + $adultSpecialCoupon; ?></td>

                        <td><?php echo $kidCoupon + $kidOutsourcedCoupon + $kidSpecialCoupon; ?></td>

                        <td><?php echo $adultCoupon + $adultOutsourcedCoupon + $adultSpecialCoupon + $kidCoupon + $kidOutsourcedCoupon + $kidSpecialCoupon; ?></td>


                        <td><?php echo Util::currenctFormat($tpl['option_arr_values']['currency'], $tpl['arr'][$i]['amount']); ?></td>
                        <td><?php echo $paymentdata; ?></td>
                        <td>

                            <?php if ($tpl['arr'][$i]['Status'] == "confirmed") { ?>
                                <span class="label label-confirmed"><?php echo $statusconfirmed ?></span>
                            <?php
                            }
                             else if ($tpl['arr'][$i]['Status'] == "Cancelled") { ?>
                                <span class="label label-danger" style="background-color:red; font-size: 15px; color: #fff;"><?php echo $tpl['arr'][$i]['Status'] ?></span>
                            <?php }
                            else {
                            ?>
                                <span style="background-color:red;font-size: 15px;color: #fff;"class="label label-danger"><?php echo $status ?></span>
                            <?php
                            } ?>
                        </td>
                         <td><a class="btn btn-success btn-sm" href="<?php echo INSTALL_URL; ?>pujafoodcoupon/editPaymentPage/<?php echo $tpl['arr'][$i]['id'] ?>" rev="<?php echo $tpl['arr'][$i]['id'] ?>"><span class="glyphicon glyphicon-eye-open"></span></a></td>
                        <td style=""><a cat="1" class="btn btn-danger btn-sm icon-delete" rev="<?php echo $tpl['arr'][$i]['id']; ?>" href="<?php echo INSTALL_URL; ?>pujafoodcoupon/delete/<?php echo $tpl['arr'][$i]['id']; ?>"><span class="glyphicon glyphicon-remove"></span></a></td>
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
                                <li><a href="<?php echo INSTALL_URL ?>pujafoodcoupon/export"><?php echo __('export'); ?></a></li>
                                <li class="divider" style="display:none;"></li>
                                <li style="display:none;"><a id="delete-selected-id" href="javascript:;"><?php echo __('delete_selected'); ?></a></li>
                                <li class="divider" style="display:none;"></li>
                            </ul>
                        </div>
                    </td>
                <?php } ?>

            </tr>
        </tfoot>
    </table>
</div>
<script>
    if ($('#foodcoupom_tab_data').length > 0) {
        $('#foodcoupom_tab_data').dataTable({
            "aoColumnDefs": [{
                'bSortable': false,
                'aTargets': [15, 16]
            }]
        });
    }
</script>
