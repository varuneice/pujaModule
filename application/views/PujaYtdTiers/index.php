<section class="content-header">
    <h1><?php echo __('YTD Sponsorship Levels'); ?></h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo INSTALL_URL; ?>Admin/dashboard"><i class="fa fa-dashboard"></i> <?php echo __('home'); ?></a></li>
        <li class="active"><?php echo __('YTD Sponsorship Levels'); ?></li>
    </ol>
</section>

<?php require_once VIEWS_PATH . 'Layouts/admin/error_notice.php'; ?>

<section class="content left width_100">
    <div class="padding-19 nav-tabs-custom left width_100">
        <h1 style="margin:0; font-size:24px; color:#2679b5;">YTD Sponsorship Levels</h1>
        <p style="margin:8px 0 18px 0;">Manage the admin-entered YTD ranges for Base, Silver, Gold, Platinum, Emerald, and Diamond.</p>

        <form action="<?php echo INSTALL_URL; ?>PujaYtdTiers/index" method="post">
            <div class="table-responsive">
                <table id="puja_ytd_tiers_table" class="gzblog-table table-striped table-hover" cellpadding="0" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Year</th>
                            <th>Category</th>
                            <th>Min YTD</th>
                            <th>Max YTD</th>
                            <th>Order</th>
                            <th>Active</th>
                            <?php if ($this->controller->isAdmin()) { ?>
                                <th>Delete</th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $tiers = $tpl['tiers'] ?? array();
                        if (count($tiers) > 0) {
                            foreach ($tiers as $index => $tier) {
                                $id = (int) ($tier['id'] ?? 0);
                                ?>
                                <tr>
                                    <td>
                                        <input type="hidden" name="tiers[<?php echo $index; ?>][id]" value="<?php echo $id; ?>">
                                        <input class="form-control input-sm" type="number" name="tiers[<?php echo $index; ?>][season_year]" value="<?php echo htmlspecialchars($tier['season_year'] ?? '', ENT_QUOTES); ?>" min="2000" required>
                                    </td>
                                    <td>
                                        <input class="form-control input-sm" type="text" name="tiers[<?php echo $index; ?>][tier_name]" value="<?php echo htmlspecialchars($tier['tier_name'] ?? '', ENT_QUOTES); ?>" required>
                                    </td>
                                    <td>
                                        <input class="form-control input-sm" type="number" name="tiers[<?php echo $index; ?>][min_amount]" value="<?php echo htmlspecialchars($tier['min_amount'] ?? '', ENT_QUOTES); ?>" min="0" required>
                                    </td>
                                    <td>
                                        <input class="form-control input-sm" type="number" name="tiers[<?php echo $index; ?>][max_amount]" value="<?php echo htmlspecialchars($tier['max_amount'] ?? '', ENT_QUOTES); ?>" min="0" placeholder="No limit">
                                    </td>
                                    <td>
                                        <input class="form-control input-sm" type="number" name="tiers[<?php echo $index; ?>][display_order]" value="<?php echo htmlspecialchars($tier['display_order'] ?? '', ENT_QUOTES); ?>" min="0">
                                    </td>
                                    <td style="text-align:center;">
                                        <input type="checkbox" name="tiers[<?php echo $index; ?>][active]" value="1" <?php echo !empty($tier['active']) ? 'checked' : ''; ?>>
                                    </td>
                                    <?php if ($this->controller->isAdmin()) { ?>
                                        <td>
                                            <a class="btn btn-danger btn-sm" href="<?php echo INSTALL_URL; ?>PujaYtdTiers/delete/<?php echo $id; ?>" onclick="return confirm('Delete this YTD tier?');">
                                                <span class="glyphicon glyphicon-remove"></span>
                                            </a>
                                        </td>
                                    <?php } ?>
                                </tr>
                                <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td colspan="<?php echo $this->controller->isAdmin() ? 7 : 6; ?>">No YTD tiers found.</td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <div style="margin-top:16px;">
                <input type="hidden" name="save_ytd_tiers" value="1">
                <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-save"></i>&nbsp;&nbsp;Save Changes</button>
            </div>
        </form>

        <hr>

        <h2 style="margin:0 0 12px 0; font-size:20px; color:#2679b5;">Registration Settings</h2>
        <p style="margin:0 0 14px 0;">Manage registration values that are currently hardcoded in the Puja registration page.</p>
        <form action="<?php echo INSTALL_URL; ?>PujaYtdTiers/index" method="post">
            <div class="table-responsive">
                <table class="gzblog-table table-striped table-hover" cellpadding="0" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Year</th>
                            <th>Setting</th>
                            <th>Value</th>
                            <th>Active</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $settings = $tpl['settings'] ?? array();
                        $settingLabels = array(
                            'child_yob_cutoff' => 'Child YOB Cutoff'
                        );

                        if (count($settings) > 0) {
                            foreach ($settings as $index => $setting) {
                                $id = (int) ($setting['id'] ?? 0);
                                $settingKey = $setting['setting_key'] ?? '';
                                $settingLabel = $settingLabels[$settingKey] ?? $settingKey;
                                ?>
                                <tr>
                                    <td>
                                        <input type="hidden" name="settings[<?php echo $index; ?>][id]" value="<?php echo $id; ?>">
                                        <input class="form-control input-sm" type="number" name="settings[<?php echo $index; ?>][season_year]" value="<?php echo htmlspecialchars($setting['season_year'] ?? '', ENT_QUOTES); ?>" min="2000" required>
                                    </td>
                                    <td>
                                        <input type="hidden" name="settings[<?php echo $index; ?>][setting_key]" value="<?php echo htmlspecialchars($settingKey, ENT_QUOTES); ?>">
                                        <input class="form-control input-sm" type="text" value="<?php echo htmlspecialchars($settingLabel, ENT_QUOTES); ?>" readonly>
                                    </td>
                                    <td>
                                        <input class="form-control input-sm" type="number" name="settings[<?php echo $index; ?>][setting_value]" value="<?php echo htmlspecialchars($setting['setting_value'] ?? '', ENT_QUOTES); ?>" min="1900" max="2100" required>
                                    </td>
                                    <td style="text-align:center;">
                                        <input type="checkbox" name="settings[<?php echo $index; ?>][active]" value="1" <?php echo !empty($setting['active']) ? 'checked' : ''; ?>>
                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td colspan="4">No registration settings found.</td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <div style="margin-top:16px;">
                <input type="hidden" name="save_registration_settings" value="1">
                <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-save"></i>&nbsp;&nbsp;Save Registration Settings</button>
            </div>
        </form>

        <hr>

        <h2 style="margin:0 0 12px 0; font-size:20px; color:#2679b5;">Add New Level</h2>
        <form action="<?php echo INSTALL_URL; ?>PujaYtdTiers/index" method="post">
            <table class="table">
                <tr>
                    <th>Year</th>
                    <th>Category</th>
                    <th>Min YTD</th>
                    <th>Max YTD</th>
                    <th>Order</th>
                    <th>Active</th>
                </tr>
                <tr>
                    <td><input class="form-control input-sm" type="number" name="season_year" value="<?php echo date('Y'); ?>" min="2000" required></td>
                    <td><input class="form-control input-sm" type="text" name="tier_name" placeholder="Category" required></td>
                    <td><input class="form-control input-sm" type="number" name="min_amount" value="0" min="0" required></td>
                    <td><input class="form-control input-sm" type="number" name="max_amount" min="0" placeholder="No limit"></td>
                    <td><input class="form-control input-sm" type="number" name="display_order" value="0" min="0"></td>
                    <td style="text-align:center;"><input type="checkbox" name="active" value="1" checked></td>
                </tr>
            </table>
            <input type="hidden" name="add_ytd_tier" value="1">
            <button class="btn btn-success" type="submit"><i class="fa fa-fw fa-plus"></i>&nbsp;&nbsp;Add Level</button>
        </form>
    </div>
</section>
