<?php

namespace App\Core\Database;

use ADOConnection;
use App\Core\Libraries\Traits\ModelManipulation;


/**
 * DB
 * @author Elvis Reyes <teclaelvis01@gmail.com>
 * @package App\Core\Database
 */
class DB
{
    use ModelManipulation;
    private static $driver = null;
    /**
     * adoContection
     * @var ADOConnection|false
     */
    private static $db = false;
    /**
     * Hostname of the database server
     * @var string
     */
    private static $host = "localhost";
    /**
     * Username of the database server
     * @var string
     */
    private static $user = "";
    /**
     * Password of the database server
     * @var string | null
     */
    private static $password = "";
    /**
     * Database name
     * @var string
     */
    private static $database = "";

    public function __construct()
    {
        // 'mysql', 'mariadb', 'root', 'root', 'telecoming'
        $this->connect();
    }
    /**
     * Connect to the database
     * @return void
     */
    public function connect()
    {
        try {
            // self::$db = ADONewConnection(self::$driver);
            // self::$db->Connect(self::$host, self::$user, self::$password, self::$database);
            self::$db = NewADOConnection(self::$driver.'://'.self::$user.':'.self::$password.'@'.self::$host.'/'.self::$database);
            \ADOdb_Active_Record::SetDatabaseAdapter(self::$db);
        } catch (\Throwable $th) {
            echo "[DB] connect -> " . $th->getMessage();
        }
    }
    
    /**
     * Execute a query
     * @param string $query
     * @return ADOFetchObj|bool
     */
    public function query($query)
    {
        try {
            $result = self::$db->Execute($query);
            if ($result) {
                $data = $result->FetchObj();
                return $data;
            } else {
                return false;
            }
        } catch (\Throwable $th) {
            echo "[DB] query -> " . $th->getMessage();
        }
    }


    public function isConnected()
    {
        return self::$db->isConnected();
    }

    /**
     * Get the instance of the database
     * @return ADOConnection|false
     */
    public static function run(array $config = [])
    {
        if (isset($config['driver'])) {
            self::$driver = 'mysql';
        }
        if (isset($config['host'])) {
            self::$host = $config['host'];
        }
        if (isset($config['user'])) {
            self::$user = $config['user'];
        }
        if (isset($config['password'])) {
            self::$password = $config['password'];
        }
        if (isset($config['database'])) {
            self::$database = $config['database'];
        }
        return self::getInstance(true);
    }
}
