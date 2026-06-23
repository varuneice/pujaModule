<?php
require_once VIEWS_PATH . 'Layouts/admin/error_notice.php';
?>
<section class="content left width_100">
    <div class="padding-19 nav-tabs-custom left width_100">
        <?php
        if (!empty($tpl['arr'])) {
            ?>
            <div class="payment_information">
                <p><strong>Member Name:</strong> <?php echo (($tpl['arr'] ?? [])['F_Name'] ?? '') . ' ' . (($tpl['arr'] ?? [])['Sp_FName'] ?? ''); ?></p>
                <p><strong>Phone No:</strong> <?php echo ($tpl['arr'] ?? [])['Mob_No'] ?? ''; ?></p>
                <p><strong>Email:</strong> <?php echo ($tpl['arr'] ?? [])['email'] ?? ''; ?></p>
                <p>
                    <strong>Category:</strong> 
                    <?php
                    switch (($tpl['arr'] ?? [])['rate'] ?? '') {
                        case 'gmi_1':
                            echo 'General Member-Individual(Due jan1/Apr 1 every year)';
                            break;
                        case 'gmi_4':
                            echo 'General Member-Individual(Due jan1/Apr 1 every year)';
                            break;
                        case 'gmf_1':
                            echo 'General Member-Family(Due jan1/Apr 1 every year)';
                            break;
                        case 'gmf_4':
                            echo 'General Member-Family(Due jan1/Apr 1 every year)';
                            break;
                        case 'lm':
                            echo 'Life Member(LM)';
                            break;
                        case 'bf':
                            echo 'Benefactor(BF)';
                            break;
                        case 'pm':
                            echo 'Patron Member(pm)';
                            break;
                        case 'lm_h':
                            echo 'Maintenance (LM and higher)-per calendar Year';
                            break;
                    }
                    ?>
                </p>
            </div>
            <?php
        }
        ?>
    </div>
</section>
