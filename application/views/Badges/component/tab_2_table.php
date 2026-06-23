<div class="overlay"></div>
<div class="loading-img"></div>
<table id="<?php echo (count($tpl['life'])) ? "tab-2-table-id" : ""; ?>" class="gzblog-table table-striped table-hover" cellpadding="0" cellspacing="0" >
    <thead>
        <tr>
            <th><?php echo __('Member id'); ?></th>
            <th><?php echo __('First'); ?></th>
            <th class="title-th"><?php echo __('Spouse'); ?></th>
            <th class="title-th"><?php echo __('Category'); ?></th>
            <th><?php echo __('Tele1'); ?></th>
            <th><?php echo __('Email'); ?></th>
            <th class="icon-th"></th>
            <th class="icon-th"></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $count = count($tpl['life']);
        $status_arr = __('status_arr');
        if ($count > 0) {
            for ($i = 0; $i < $count; $i++) {
                ?>
                <tr class="<?php echo $i % 2 === 0 ? 'odd' : 'even'; ?>">
                    <td><?php echo $tpl['life'][$i]['Member_id']; ?></td>
                    <td><?php echo $tpl['life'][$i]['F_Name']; ?></td>
                    <td><?php echo $tpl['life'][$i]['Sp_FName']; ?></td>
                    <td><?php echo $tpl['life'][$i]['Category']; ?></td>
                    <td><?php echo $tpl['life'][$i]['Tele1']; ?></td>
                    <td><?php echo $tpl['life'][$i]['email']; ?></td>
                    <td><a class="btn btn-success btn-sm" href="<?php echo INSTALL_URL; ?>Member/edit/<?php echo $tpl['life'][$i]['ID']; ?>" rev="<?php echo $tpl['life'][$i]['ID']; ?>"><span class="glyphicon glyphicon-pencil"></span></a></td>
                    <td><a cat="2" class="btn btn-danger btn-sm icon-delete" rev="<?php echo $tpl['life'][$i]['ID']; ?>" href="<?php echo INSTALL_URL; ?>Member/delete/<?php echo $tpl['life'][$i]['ID']; ?>"><span class="glyphicon glyphicon-remove"></span></a></td>
                </tr>
                <?php
            }
        } else {
            ?>
            <tr>
                <td colspan="9">
                    <?php
                    echo __('no_booking');
                    ?>
                </td>
            </tr>
            <?php
        }
        ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="9">
                <div class="btn-group">
                    <button type="button" class="btn btn-primary btn-flat"><?php echo __('action'); ?></button>
                    <button type="button" class="btn btn-primary btn-flat dropdown-toggle" data-toggle="dropdown">
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="<?php echo INSTALL_URL ?>Member/export"><?php echo __('export'); ?></a></li>
                        <li class="divider" style="display:none;"></li>
                        <li style="display:none;"><a id="delete-selected-id" href="javascript:;"><?php echo __('delete_selected'); ?></a></li>
                        <li class="divider"></li>
                        <li><a href="<?php echo INSTALL_URL; ?>Member/create"><?php echo __('add_members'); ?></a></li>
                    </ul>
                </div>
            </td>
        </tr>
    </tfoot>
</table> 