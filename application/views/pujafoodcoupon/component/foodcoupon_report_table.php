
<div class="overlay"></div>
<div class="loading-img"></div>
<div class ="phoneview" style = "overflow-x:hidden;">
<table id="<?php echo (count($tpl['couponReportarr'])) ? "tab-6-table-id" : ""; ?>" class="gzblog-table table-striped table-hover" cellpadding="0" cellspacing="0" >
    <thead>
        <tr>
            <th><?php echo __('Current Day & Date'); ?></th> 
            <th><?php echo __('Session'); ?></th>
            <th><?php echo __('Coupon Type'); ?></th>
            <th><?php echo __('Adult Coupon'); ?></th>
            <th><?php echo __('Child Coupon'); ?></th> 
            <th><?php echo __('Total Coupon'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php  
        $count = count($tpl['couponReportarr']);
        $status_arr = __('couponReportarr');
        if ($count > 0) {
            for ($i = 0; $i < $count; $i++) {

                ?>
                
                <tr class="<?php echo $i % 2 === 0 ? 'odd' : 'even'; ?>">
                    <td><?php echo $tpl['couponReportarr'][$i]['currentDate']; ?></td>
                    <td><?php echo $tpl['couponReportarr'][$i]['ActiveSession']; ?></td>
                    <td><?php echo $tpl['couponReportarr'][$i]['Type']; ?></td>  
                    <td><?php echo $tpl['couponReportarr'][$i]['TotalAdultCoupon']; ?></td>  
                    <td><?php echo $tpl['couponReportarr'][$i]['TotalChildCoupon']; ?></td>
                    <td><?php echo $tpl['couponReportarr'][$i]['TotalCoupon']; ?></td>                                     
            </tr>
            
                <?php
            }
        } else {
            ?>
            <tr>
                <td colspan="9">
                    <?php
                    echo __('No Matching Records Found');
                    ?>
                </td>
            </tr>
            <?php
        }
        ?>
    </tbody>
</table> 
 </div> 
 <script>
    if ($('#tab-6-table-id').length > 0) {
        $('#tab-6-table-id').dataTable({
            "aoColumnDefs": [
                { 'bSortable': false, 'aTargets': [1, 3] }
            ]
        });
    }
</script>
 
