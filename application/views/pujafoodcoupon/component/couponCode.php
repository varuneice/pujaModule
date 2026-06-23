
<div class="overlay"></div>
<div class="loading-img"></div>
<table id="foodcoupon-sessioncode-table-id" class="gzblog-table table-striped table-hover" cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th><?php echo __('Session Code'); ?></th>
            <th><?php echo __('Session Name'); ?></th>
            <th><?php echo __('Status'); ?></th>
            <th class="icon-th"></th>
            <th class="icon-th"></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $count = count($tpl['sessionCodes']);
        // $status_arr = __('status_arr');
        if ($count > 0) {
            for ($i = 0; $i < $count; $i++) {
                $statusData =  $tpl['sessionCodes'][$i]['Active'];
                $statusVal = "";
                if($statusData === "Y"){
                    $statusVal = "Active";
                }
                else{
                    $statusVal = "In Active";
                }
                ?>
                <tr class="<?php echo $i % 2 === 0 ? 'odd' : 'even'; ?>">
                    <td> <?php echo $tpl['sessionCodes'][$i]['sessionCode']; ?></td>
                    <td> <?php echo $tpl['sessionCodes'][$i]['sessionName']; ?></td>
                    <td> <?php echo $statusVal; ?></td>
                    <!-- edit and delete button -->
                    <?php if ($this->controller->isAdmin())  { ?>
                    <td><a class="btn btn-success btn-sm" href="<?php echo INSTALL_URL; ?>pujafoodcoupon/codeEdit/<?php echo $tpl['sessionCodes'][$i]['id'] ?>" rev="<?php $tpl['sessionCodes'][$i]['id'] ?>"><span class="glyphicon glyphicon-eye-open"></span></a></td>
                    <?php }?>
                    <?php if ($this->controller->isAdmin())  { ?>
                        <td><a cat="3" class="btn btn-danger btn-sm icon-delete" rev="<?php echo $tpl['sessionCodes'][$i]['id']; ?>" href="<?php echo INSTALL_URL; ?>pujafoodcoupon/delete/<?php echo $tpl['sessionCodes'][$i]['id']; ?>"><span class="glyphicon glyphicon-remove"></span></a></td>
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
    if ($('#foodcoupon-sessioncode-table-id').length > 0) {
        $('#foodcoupon-sessioncode-table-id').dataTable({
            "aoColumnDefs": [
                { 'bSortable': false, 'aTargets': [1, 2] }
            ]
        });
    }
</script>