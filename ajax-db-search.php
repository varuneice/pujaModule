<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json; charset=UTF-8');

if (!isset($_GET['term']) || trim($_GET['term']) === '') {
    echo json_encode([]);
    exit;
}

try {
    require_once __DIR__ . '/application/config/db.php';
    require_once __DIR__ . '/application/config/functions.inc.php';

    $pdo = gz_pdo_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

    $term = trim($_GET['term']) . '%';

    $stmt = $pdo->prepare(
        "SELECT Zip, FirstSal, SpouseSal, Member_id,
                CONCAT(F_Name, ' ', L_Name)                     AS Name,
                CONCAT(Sp_FName, ' ', Sp_LName)                 AS Spouse,
                CONCAT(Address1, ' ', Address2, ' ', Address3)  AS Address
         FROM memberltdytd
         WHERE (F_name    LIKE ?
             OR L_Name    LIKE ?
             OR Zip       LIKE ?
             OR Sp_FName  LIKE ?
             OR Sp_LName  LIKE ?
             OR Member_id LIKE ?)
           AND (FirstSal != 'Late' OR SpouseSal != 'Late')
           AND (Active IS NULL OR Active = '')
         LIMIT 20"
    );

    $stmt->execute([$term, $term, $term, $term, $term, $term]);

    $memberData = [];
    while ($user = $stmt->fetch()) {
        $sp = trim($user['Spouse'] ?? '');
        if ($user['FirstSal'] === 'Late' || $user['SpouseSal'] === 'Late') {
            $value = $user['Name'];
        } elseif ($sp === '' || $sp === ' ') {
            $value = $user['Name'] . ' , ' . $user['Zip'];
        } else {
            $value = $user['Name'] . ' , ' . $sp . ' , ' . $user['Zip'];
        }
        $memberData[] = ['id' => $user['Member_id'], 'value' => $value];
    }

    echo json_encode($memberData);

} catch (Throwable $e) {
    echo json_encode(['error' => $e->getMessage(), 'file' => $e->getFile(), 'line' => $e->getLine()]);
}
