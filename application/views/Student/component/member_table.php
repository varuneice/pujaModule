<div class="overlay"></div>
<div class="loading-img"></div>
<table id="<?php echo (count($tpl['arr'])) ? "gzhotel-booking-booking-id" : ""; ?>" class="gzblog-table table-striped table-hover" cellpadding="0" cellspacing="0" >
    <thead>
        <tr>
            <th class="">
                <!-- <input class="simple" type="checkbox" name="mark-all" id="mark-all-id" value="all"/> -->
            </th>
            <th><?php echo __('Reg_UId'); ?></th>
            <th><?php echo __('Student Name'); ?></th>
            <th class="title-th"><?php echo __('subject'); ?></th>
            <th><?php echo __('School'); ?></th>
            <th><?php echo __('session'); ?></th>
            <th class="icon-th"></th>
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
                ?>
                <tr class="<?php echo $i % 2 === 0 ? 'odd' : 'even'; ?>">
                    <td>
                        <!-- <input class="simple mark" type="checkbox" name="mark[]"  id="mark-<?php echo $tpl['arr'][$i]['uid']; ?>" value="<?php echo $tpl['arr'][$i]['uid']; ?>"/> -->
                    </td>
                    <td><?php echo $tpl['arr'][$i]['reg_uid']; ?></td>
                    <td><?php echo $tpl['arr'][$i]['St_Name']; ?></td>
                    <td>
                        <?php 
                        $subject = unserialize($tpl['arr'][$i]['subject']);
                        echo implode(',',$subject); 
                        ?>
                    </td>
                    <td><?php echo $tpl['arr'][$i]['school']; ?></td>
                    <td>
                        <span class="label label-<?php echo $tpl['arr'][$i]['payment_status']; ?>">
                             <?php echo $status_arr[$tpl['arr'][$i]['payment_status']]; ?>
                        </span>
                    </td>
                    <td style= "Display:none"><a class="btn btn-primary btn-sm" href="<?php echo INSTALL_URL; ?>Student/send/<?php echo $tpl['arr'][$i]['uid']; ?>"><span class="glyphicon glyphicon-envelope"></span></a></td>
                    <td><a class="btn btn-success btn-sm" href="<?php echo INSTALL_URL; ?>Student/edit/<?php echo $tpl['arr'][$i]['uid']; ?>"><span class="glyphicon glyphicon-pencil"></span></a></td>
                    <td><a class="btn btn-danger btn-sm icon-delete" rev="<?php echo $tpl['arr'][$i]['uid']; ?>" href="<?php echo INSTALL_URL; ?>Student/delete/<?php echo $tpl['arr'][$i]['uid']; ?>"><span class="glyphicon glyphicon-remove"></span></a></td>
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
                        <li><a href="<?php echo INSTALL_URL ?>Student/export"><?php echo __('export'); ?></a></li>
                        <li class="divider"></li>
                        <li><a id="delete-selected-id" href="javascript:;"><?php echo __('delete_selected'); ?></a></li>
                        <li class="divider"></li>
                    </ul>
                </div>
            </td>
        </tr>
    </tfoot>
</table>