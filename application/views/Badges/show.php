<?php
require_once VIEWS_PATH . 'Layouts/admin/error_notice.php';
?>
<section class="content left width_100">
    <div class="padding-19 nav-tabs-custom left width_100">
        <?php
        if (!empty($tpl['arr'])) {
            ?>
            <div class="payment_information">
            <table border="4" width='585px' style= "margin-left:432px;" >
                                 <tr>
                                 <td colspan='2'> <img src='<?php echo INSTALL_URL; ?>thankyou.jpg' alt='' height='405px' width='580px'></td> </tr>
                                <tr>
                                <td colspan='2'><b>Your membership request have been submitted.
                                   Login details will be shared with you after membership approved.
                                    For more details please contact to<a href='mailto:hdbs.payment@durgabari.org'> hdbs.payment@durgabari.org</a></b></td></tr>
                                  <tr>
                                <td>Member ID</td> <td><?php echo ($tpl['arr'] ?? [])['Member_id'] ?? ''; ?></td> </tr>
                                <tr><td>Member Name</td> <td><?php echo ($tpl['arr'] ?? [])['F_Name'] ?? '';?></td> </tr>
                                <tr><td>Member Email Address</td> <td><?php echo ($tpl['arr'] ?? [])['email'] ?? ''; ?></td> </tr>
                                <tr><td>Member Phone Number</td> <td><?php echo ($tpl['arr'] ?? [])['Tele1'] ?? ''; ?></td>  </tr>
                                <tr><td>Membership Type</td> <td><?php echo ($tpl['arr'] ?? [])['membership_type'] ?? ''; ?></td>  </tr>
                                </tr> 
                        </table>
                <!-- <p><strong>Member Name:</strong> <?php echo ($tpl['arr'] ?? [])['F_Name'] ?? '' . ' ' . ($tpl['arr'] ?? [])['Sp_FName'] ?? ''; ?></p>
                <p><strong>Phone No:</strong> <?php echo ($tpl['arr'] ?? [])['Mob_No'] ?? ''; ?></p>
                <p><strong>Email:</strong> <?php echo ($tpl['arr'] ?? [])['email'] ?? ''; ?></p>
                <p> -->
                    <!-- <strong>Category:</strong> 
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
                    ?> -->
                <!-- </p> -->
            </div>
            <?php
        }
        ?>
    </div>
</section>