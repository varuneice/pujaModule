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
<section class="content-header">
    <h1>
        <?php echo __('Edit'); ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo INSTALL_URL; ?>"><i class="fa fa-dashboard"></i> <?php echo __('home'); ?></a></li>
        <li><a href="<?php echo INSTALL_URL; ?>pujaMerchandise/priceLimitDate"><?php echo __('Puja Merchandise Price Limit Edit'); ?></a></li>
        <li class="active"><?php echo __('Puja Merchandise Edit'); ?></li>
    </ol>
</section>
<?php
require_once VIEWS_PATH . 'Layouts/admin/error_notice.php';

?>
<section class="content left width_100">
    <form id="edit_user" class="frm-class user-frm-class" action="" method="post" name="eventPaymentEdit"
        enctype="multipart/form-data">
        <div class="padding-19 nav-tabs-custom left width_100">
            <fieldset>
                <h1 style="margin:0; font-size:24px; color:#2679b5;"> Edit Saree / kurta price </h1><br>

                <table id="event_Payment_account" class="gzblog-table table-striped table-hover" cellpadding="0"
                    cellspacing="0">
                    <thead>
                        <tr>
                            <th><?php echo __('Cloth Type'); ?></th>
                            <th><?php echo __('Early Purchase limit'); ?></th>
                            <th><?php echo __('After Deadline limit'); ?></th>

                           

                          

                            <th class="icon-th"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $count = count($tpl['clothdata']);



                        if ($count > 0) {
                            for ($i = 0; $i < $count; $i++) {
                                ?>
                                <tr class="<?php echo $i % 2 === 0 ? 'odd' : 'even'; ?>">
                                <td><?php echo $tpl['clothdata'][$i]['cloth_type']; ?></
                                    <!-- Keeping cloth_type as plain text -->
                                    <td><input type="number" class="limit-input" name="limitBefore" min="1"
                                            value="<?php echo htmlspecialchars($tpl['clothdata'][$i]['limitBefore'] )?>" />
                                            
                                    </td>
                                    <td><input type="number" class="limit-input" name="limitAfter" min="1"
                                            value="<?php echo htmlspecialchars($tpl['clothdata'][$i]['limitAfter']); ?>" />
                                           
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
                </table>
            </fieldset>
            <br>


            <input type="hidden" name="id" value="<?php echo htmlspecialchars(($tpl['clothdata'][0] ?? [])['id']); ?>" />
            <?php if ($this->controller->isAdmin()) { ?>
                <button id="submit" class="btn btn-primary" autocomplete="off" value="<?php echo __('save'); ?>"
                    name="submit" tabindex="9" type="submit"><i
                        class="fa fa-fw fa-save"></i>&nbsp;&nbsp;<?php echo __('save') ?></button>
            <?php } ?>
        </div>

    </form>

</section>


<script>
    
document.querySelectorAll('.limit-input').forEach(input => {
    input.addEventListener('change', function () {
        validateLimit(this);
    });
});

function validateLimit(input) {
    const rawValue = input.value.trim();

    // Check for special characters using regex
    if (/[^0-9.]/.test(rawValue)) {
        alert("Special characters are not allowed in the input fields.");
        input.value = "";
        input.focus();
        return;
    }

    const value = parseFloat(rawValue);

    if (isNaN(value)) {
        alert("Please enter a valid number.");
        input.value = "";
        input.focus();
        return;
    }

    if (value < 1) {
        alert("Limit cannot be negative or zero.");
        input.value = Math.abs(value); // Optional: auto-correct to positive
        input.focus();
        return;
    }
}
</script>