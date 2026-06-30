<?php
require_once FRAMEWORK_PATH . 'Object.class.php';
include_once FRAMEWORK_PATH . 'FluentStructure.php';
include_once FRAMEWORK_PATH . 'FluentUtils.php';
include_once FRAMEWORK_PATH . 'FluentLiteral.php';
include_once FRAMEWORK_PATH . 'BaseQuery.php';
include_once FRAMEWORK_PATH . 'CommonQuery.php';
include_once FRAMEWORK_PATH . 'SelectQuery.php';
include_once FRAMEWORK_PATH . 'InsertQuery.php';
include_once FRAMEWORK_PATH . 'UpdateQuery.php';
include_once FRAMEWORK_PATH . 'DeleteQuery.php';

class Model extends GzObject {

    protected $pdo, $structure;
    protected static $pdoPool = array();

    /** @var boolean|callback */
    public $debug;
    public $engine = 'mysql';
    public $host = '';
    public $database = '';
    public $user = '';
    public $pass = '';
    var $primaryKey = null;
    var $prefix = null;

    /**
     * Table name
     *
     * @access public
     * @var string
     */
    var $table = null;

    /**
     * Prefix of table names
     *
     * @access public
     * @var string
     */
    function setDatabase($db) {
        if (!empty($db)) {
            $this->database = $db;
        }
    }

    function setHost($host) {
        if (!empty($host)) {
            $this->host = $host;
        }
    }

    function setUser($user) {
        if (!empty($user)) {
            $this->user = $user;
        }
    }

    function setPass($pass) {
        if (!empty($pass)) {
            $this->pass = $pass;
        }
    }

    function __construct(?FluentStructure $structure = null) {

        if (defined('DEFAULT_PREFIX')) {
            $this->prefix = DEFAULT_PREFIX;
        }

        if (defined('DEFAULT_DB')) {
            $this->setDatabase(DEFAULT_DB);
        }
        if (defined('DEFAULT_HOST')) {
            $this->setHost(DEFAULT_HOST);
        }
        if (defined('DEFAULT_USER')) {
            $this->setUser(DEFAULT_USER);
        }
        if (defined('DEFAULT_PASS')) {
            $this->setPass(DEFAULT_PASS);
        }

        $is_remote = ($this->host !== 'localhost' && $this->host !== '127.0.0.1');

        $dns = $this->engine . ':dbname=' . $this->database
            . ';host=' . $this->host
            . ';charset=utf8mb4';

        $pdo_options = array(
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8mb4' COLLATE 'utf8mb4_unicode_ci'",
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        );

        // Azure Database for MySQL requires SSL for remote hosts.
        if ($is_remote) {
            $ca_paths = [
                'C:\\xampp82\\apache\\bin\\curl-ca-bundle.crt',
                '/etc/ssl/certs/ca-certificates.crt',
                '/etc/pki/tls/certs/ca-bundle.crt',
                '/etc/ssl/ca-bundle.pem',
            ];
            foreach ($ca_paths as $ca) {
                if (file_exists($ca)) {
                    $pdo_options[PDO::MYSQL_ATTR_SSL_CA] = $ca;
                    break;
                }
            }
            $pdo_options[PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT] = false;
        }

        try {
            $poolKey = sha1($dns . "\n" . $this->user . "\n" . $this->pass . "\n" . serialize($pdo_options));
            if (!isset(self::$pdoPool[$poolKey])) {
                self::$pdoPool[$poolKey] = new PDO($dns, $this->user, $this->pass, $pdo_options);
                // Azure MySQL enforces ONLY_FULL_GROUP_BY; remove it once per request connection.
                self::$pdoPool[$poolKey]->exec("SET SESSION sql_mode = REPLACE(@@SESSION.sql_mode, 'ONLY_FULL_GROUP_BY', '')");
            }
            $this->pdo = self::$pdoPool[$poolKey];
        } catch (Exception $e) {
            $msg = 'DB connection failed: ' . $e->getMessage();
            error_log('[Model] ' . $msg . ' | host=' . $this->host . ' user=' . $this->user . ' db=' . $this->database);
            die($msg);
        }
        if (!$structure) {
            $structure = new FluentStructure;
        }
        $this->structure = $structure;
    }

    /** Create SELECT query from $table
     * @param string $table  db table name
     * @param integer $primaryKey  return one row by primary key
     * @return \SelectQuery
     */
    public function from($table, $primaryKey = null) {
        $query = new SelectQuery($this, $table);
        if ($primaryKey) {
            $tableTable = $query->getFromTable();
            $tableAlias = $query->getFromAlias();
            $primaryKeyName = $this->structure->getPrimaryKey($tableTable);
            $query = $query->where("$tableAlias.$primaryKeyName", $primaryKey);
        }
        return $query;
    }

    /** Create INSERT INTO query
     *
     * @param string $table
     * @param array $values  you can add one or multi rows array @see docs
     * @return \InsertQuery
     */
    public function insertInto($table, $values = array()) {

        $query = new InsertQuery($this, $table, $values);
// echo   $query->getQuery();
        return $query;
    }

    protected function getScalarSchemaValue($value) {
        if (!is_array($value)) {
            return $value;
        }

        return isset($value[0]) ? $value[0] : null;
    }

    protected function normalizeSchemaValue($field, $raw, &$normalized) {
        if ($raw === null) {
            return false;
        }

        $numericTypes = ['int','smallint','tinyint','mediumint','bigint','float','decimal','double','real'];
        $dateTypes    = ['date','datetime','timestamp','time','year'];
        $type = strtolower($field['type'] ?? '');

        if (in_array($type, $numericTypes)) {
            if (is_string($raw)) {
                $raw = trim($raw);
            }
            if ($raw === '' || $raw === null) {
                return false;
            }
            $normalized = $this->escape($raw, null, $type);
            return true;
        }

        if (in_array($type, $dateTypes)) {
            if (is_string($raw)) {
                $raw = trim($raw);
            }
            if ($raw === '' || $raw === '0000-00-00' || $raw === '0000-00-00 00:00:00') {
                return false;
            }
        }

        $normalized = $raw;
        return true;
    }

    /** Create UPDATE query
     *
     * @param string $table
     * @param array|string $set
     * @param string $primaryKey
     *
     * @return \UpdateQuery
     */
    public function updatewithoutKey($data = array()) {
        $save = array();

        foreach ($this->schema as $field) {

            if (isset($data[$field['name']])) {
                $raw = $this->getScalarSchemaValue($data[$field['name']]);
                if ($this->normalizeSchemaValue($field, $raw, $normalized)) {
                    $save["`" . $field['name'] . "`"] = $normalized;
                }
            }
        }

        if (empty($save)) {
            return false;
        }

        $query = new UpdateQuery($this, $this->getTable());
        $query->set($save);
        $primaryKeyName = $this->getStructure()->getPrimaryKey($this->getTable());
        if (!empty($data[$primaryKeyName])) {
            $query = $query->where($primaryKeyName, $data[$primaryKeyName]);
        }

        return $query->execute();
    }
    
    
     public function update($data = array())
{
    $primaryKeyName = $this->getStructure()->getPrimaryKey($this->getTable());

    // 1. Require primary key to prevent accidental full updates
    if (!isset($data[$primaryKeyName]) || $data[$primaryKeyName] === '') {
        $this->logAction("Update skipped: missing primary key in data");
        return false;
    }

    $save = [];
    foreach ($this->schema as $field) {
        if (isset($data[$field['name']])) {
            $raw = $this->getScalarSchemaValue($data[$field['name']]);
            if ($this->normalizeSchemaValue($field, $raw, $normalized)) {
                $save["`" . $field['name'] . "`"] = $normalized;
            }
        }
    }

    if (empty($save)) {
        $this->logAction("No data to update for ID: " . $data[$primaryKeyName]);
        return false;
    }

    $query = new UpdateQuery($this, $this->getTable());
    $query->set($save);
    $query = $query->where($primaryKeyName, $data[$primaryKeyName]);

     $sqlString = method_exists($query, 'getQuery')
        ? $query->getQuery()
        : (method_exists($query, 'getSql') ? $query->getSql() : '[SQL not available]');


    $this->logAction(
        "Updating table: " . $this->getTable() .
        " | WHERE " . $primaryKeyName . " = " . $data[$primaryKeyName] .
        " | Data: " . json_encode($save) .
        " | SQL: " . $sqlString
    );

    // Execute the update
    $result = $query->execute();

    // 3. Log the result
    $this->logAction("Update completed for " . $primaryKeyName . " = " . $data[$primaryKeyName]);

    return $result;
}


private function logAction($message)
{
    $logDir = __DIR__ . '/logs'; // directory for logs
    $logFile = $logDir . '/db_update_log.txt';

    // Create folder if not exists
    if (!file_exists($logDir)) {
        mkdir($logDir, 0777, true);
    }

    $timestamp = date("Y-m-d H:i:s");
    $entry = "[$timestamp] $message" . PHP_EOL;

    file_put_contents($logFile, $entry, FILE_APPEND);
}

    /** Create DELETE query
     *
     * @param string $table
     * @param string $primaryKey  delete only row by primary key
     * @return \DeleteQuery
     */
    public function delete($table, $primaryKey = null) {
        $query = new DeleteQuery($this, $table);
        if ($primaryKey) {
            $primaryKeyName = $this->getStructure()->getPrimaryKey($table);
            $query = $query->where($primaryKeyName, $primaryKey);
        }
        return $query;
    }

    /** Create DELETE FROM query
     *
     * @param string $table
     * @param string $primaryKey
     * @return \DeleteQuery
     */
    public function deleteFrom($table, $primaryKey = null) {
        $args = func_get_args();
        return call_user_func_array(array($this, 'delete'), $args);
    }

    /** @return \PDO
     */
    public function getPdo() {
        return $this->pdo;
    }

    /** @return \FluentStructure
     */
    public function getStructure() {
        return $this->structure;
    }

    public function getTable() {
        return $this->prefix . $this->table;
    }

    public function getAll($options = null, $column = null, $limit = null) {

        $query = $this->from($this->getTable() . ' as t1')->where($options);

        if (!empty($column)) {
            if (strpos($column, ' ') !== false) {
                $query->orderBy($column);
            } else {
                $query->orderBy("`" . $column . "`");
            }
        }
        if (!empty($limit)) {
            $query->limit($limit);
        }
        /*
          $query->debug=true;
          echo $query->getQuery();
          print_r($query->getParameters());
          echo '<br />';
         */

        return $query->fetchAll();
    }

    public function getI18nAll($options = null, $column = null) {
        $this->loadFiles('model', array('Field'));
        $FieldModel = new FieldModel();

        $query = $this->from($this->getTable())->where($options);

        if (!empty($column)) {

            $query->orderBy("`" . $column . "`");
        }

        $arr = $query->fetchAll();
/////////////////////////////////////////////////////
        $result = array();
        if (!empty($arr)) {
            foreach ($arr as $key => $row) {
                $result[$key] = $row;

                $opts['table_name'] = $this->getTable();
                $opts['in_id'] = $row['id'];

                $query = $this->from($FieldModel->getTable())->where($opts);
                $i18n_arr = $query->fetchAll();

                foreach ($i18n_arr as $k => $value) {
                    $result[$key]['i18n'][$value['language_id']][$value['field_name']] = $value['value'];
                }
            }
        }
        /* $query->debug=true;
          echo $query->getQuery();
          print_r($query->getParameters());
          echo '<br />'; */
        return $result;
    }

    function getI18n($id = null) {
        $this->loadFiles('model', array('Field'));
        $FieldModel = new FieldModel();
        $options['id'] = $id;
        $query = $this->from($this->getTable())->where($options);

        if (!empty($column)) {

            $query->orderBy("`" . $column . "`");
        }

        $arr = $query->fetchAll();
        $row = $arr[0] ?? null;
/////////////////////////////////////////////////////
        $result = array();
        $result = $row;

        $opts['table_name'] = $this->getTable();
        $opts['in_id'] = $row['id'];

        $query = $this->from($FieldModel->getTable())->where($opts);
        $i18n_arr = $query->fetchAll();

        foreach ($i18n_arr as $k => $value) {
            $result['i18n'][$value['language_id']][$value['field_name']] = $value['value'];
        }

        /* $query->debug=true;
          echo $query->getQuery();
          print_r($query->getParameters());
          echo '<br />'; */
        return $result;
    }

    public function get($id = null) {

        $primaryKeyName = $this->getStructure()->getPrimaryKey($this->getTable());
        if (!empty($id)) {

            return $this->from($this->getTable())->where($primaryKeyName, $id)->fetch();
        }
    }

    public function save($data) {
        $save = array();

        $numericTypes = ['int','smallint','tinyint','mediumint','bigint','float','decimal','double','real'];
        $dateTypes    = ['date','datetime','timestamp','time','year'];

        foreach ($this->schema as $field) {

            if (isset($data[$field['name']])) {

                $raw = !is_array($data[$field['name']])
                    ? $data[$field['name']]
                    : (isset($data[$field['name']][0]) ? $data[$field['name']][0] : null);

                if ($raw === null) {
                    continue;
                }

                $type = strtolower($field['type'] ?? '');

                if (in_array($type, $numericTypes)) {
                    if (is_string($raw)) {
                        $raw = trim($raw);
                    }
                    // Empty string for a numeric column → omit so DB uses its DEFAULT
                    // (avoids SQLSTATE[1366] Incorrect integer/float value on Azure strict mode)
                    if ($raw === '' || $raw === null) {
                        continue;
                    }
                    $save["`" . $field['name'] . "`"] = $this->escape($raw, null, $type);
                } elseif (in_array($type, $dateTypes)) {
                    // Empty string for a date/datetime column → omit so DB uses its DEFAULT
                    // (avoids SQLSTATE[1292] Incorrect datetime value on Azure strict mode)
                    if ($raw === '' || $raw === '0000-00-00' || $raw === '0000-00-00 00:00:00') {
                        continue;
                    }
                    $save["`" . $field['name'] . "`"] = $raw;
                } else {
                    $save["`" . $field['name'] . "`"] = $raw;
                }
            }
        }
        if (count($save) > 0) {

            $query = $this->insertInto($this->getTable(), $save);

            return $lastInsert = $query->execute();
        }
        return false;
    }

    function getColumnType($column) {
        foreach ($this->schema as $col) {
            if ($col['name'] == $column) {
                return $col['type'];
            }
        }
        return false;
    }

    function escape($value, $column = null, $type = null) {
        if (is_null($type) && !is_null($column)) {
            $type = $this->getColumnType($column);
        }

        switch ($type) {
            case 'null':
                return $value;
                break;
            case 'int':
            case 'smallint':
            case 'tinyint':
            case 'mediumint':
            case 'bigint':
                return intval($value);
                break;
            case 'float':
            case 'decimal':
            case 'double':
            case 'real':
                return floatval($value);
            default : return $value;
                break;
        }
    }

    function execute($sql) {
        $pdo = $this->getPdo();

        $stmt = $pdo->prepare($sql);

        $stmt->execute();
        return $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function getCount($opts) {
        $arr = $this->getAll($opts);

        return count($arr);
    }

}
