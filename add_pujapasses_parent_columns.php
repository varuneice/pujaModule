<?php

require_once __DIR__ . '/config.php';

$columns = array(
    'no_of_parent' => "ALTER TABLE `pujapasses` ADD COLUMN `no_of_parent` VARCHAR(10) DEFAULT NULL AFTER `senior_veggie`",
    'extraparentregistration' => "ALTER TABLE `pujapasses` ADD COLUMN `extraparentregistration` VARCHAR(50) DEFAULT NULL AFTER `status`",
);

foreach ($columns as $column => $sql) {
    $stmt = $con->prepare("SELECT COUNT(*) AS count_col FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'pujapasses' AND COLUMN_NAME = ?");
    $stmt->bind_param('s', $column);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result ? $result->fetch_assoc() : array('count_col' => 0);
    $stmt->close();

    if ((int) ($row['count_col'] ?? 0) > 0) {
        echo $column . " already exists\n";
        continue;
    }

    $con->query($sql);
    echo $column . " added\n";
}

echo "Done\n";
