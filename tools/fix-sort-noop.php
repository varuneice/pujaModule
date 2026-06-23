<?php
$root = dirname(__DIR__) . '/application/views/';

// Each entry: [file, pattern to remove (the whole line)]
$fixes = [
    $root . 'donationdata/component/tab_1_table.php'
        => '$datadesc = ksort($dataid);',
    $root . 'pujafoodcoupon/component/foodcoupondata_table.php'
        => "\$datadesc = arsort(\$tpl['arr'][\$i]['id']);",
    $root . 'PujaMagazineadmin/component/old_bkp_06Sep2023/puja_magazine_table.php'
        => '$datadesc = ksort($dataid);',
    $root . 'Pujaregistration/component/puja_registration_table.php'
        => "\$datadesc = arsort(\$tpl['arr'][\$i]['id']);",
    $root . 'Pujaregistration/component/puja__sankalpa_table.php'
        => "\$datadesc = arsort(\$tpl['sankalpaarr'][\$i]['id']);",
    $root . 'Ticketadmin/component/tickettab_2_table.php'
        => '$datadesc = ksort($dataid);',
];

foreach ($fixes as $path => $needle) {
    if (!file_exists($path)) {
        echo "SKIP (not found): $path\n";
        continue;
    }
    $src = file_get_contents($path);
    if (strpos($src, trim($needle)) === false) {
        echo "SKIP (needle not found): " . basename($path) . "\n";
        continue;
    }
    $new = preg_replace('/[ \t]*' . preg_quote(trim($needle), '/') . '[ \t]*\r?\n/', '', $src);
    file_put_contents($path, $new);
    echo "Fixed: " . basename($path) . "\n";
}
echo "Done.\n";
