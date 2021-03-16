<?php

require_once dirname(__FILE__) . '/../../library/Log4PHP/Logger.php';

class Model_DataAdapter
{

    private static $instance;
    private static $db = "dhlalmacen";

    private $connection = null;
    private $logger = null;

    private function initDB()
    {
        $state = "Accediendo a la base de datos.";
        if ($this->connection == null) {
            try {
                // CONFIGURACION DE BASE DE DATOS
                $this->connection = mssql_connect("localhost", "sa", "123456");
                mssql_select_db(self::$db, $this->connection);
            } catch (Exception $e) {
                $this->logger->error("initDB", $e);
            }
        } else {
            $state = "No existe un conexion abierta.";
        }
        $this->logger->debug("initDB::" . $state);
    }

    public function __clone()
    {
        trigger_error("Error: No puedes clonar una instancia de " . get_class($this) . " class.", E_USER_ERROR);
    }

    public function __wakeup()
    {
        trigger_error("Error: No puedes deserializar una instancia de " . get_class($this) . " class.", E_USER_ERROR);
    }

    public function __construct()
    {
        date_default_timezone_set(DATE_ZONE);
        Logger::configure(LOG_ERROR);

        $this->logger = Logger::getLogger(__CLASS__);
        $this->logger->debug("Inicializando la base de datos.");
        $this->initDB();
    }

    public static function getInstance()
    {
        if (!self::$instance instanceof self) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    public static function getDriver()
    {
        return self::$driver;
    }

    public static function setDriver($driver)
    {
        self::$driver = $driver;
    }

    public function getConnection()
    {
        return $this->connection;
    }

    public function setConnection($connection)
    {
        $this->connection = $connection;
    }

    public function executeRowsToJSON($procedure, $parameters)
    {
        $result = null;
        $rows = $this->ejec_store_procedura_sql($procedure, $parameters);

        if ($rows != null) {
            $result = json_encode($rows, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
        }

        return $result;
    }

    public function executeAssocQuery($nombrestore, $arraydatos)
    {
        $this->initDB();
        $_rows = null;

        try {
            $caddatos = '';
            if ($arraydatos != '' || $arraydatos != null) {
                if (count($arraydatos) > 0) {
                    for ($i = 0; $i < count($arraydatos); $i++) {
                        $nomvar = $arraydatos[$i][0];
                        $valvar = $arraydatos[$i][1];
                        $caddatos .= $nomvar . "='" . $valvar . "',";
                    }
                    $caddatos = substr($caddatos, 0, strlen($caddatos) - 1);
                }
            }
            $_query = 'exec ' . $nombrestore . ' ' . $caddatos;
            //print $_query;
            //echo "<script>console.log('".$_query."');</script>";
            //echo $_query;
            $this->logger->info($_query);
            $result = mssql_query($_query) or die(mssql_get_last_message());

            $_rowCount = mssql_num_rows($result);
            $_rows = array();
            $i = 0;
            while ($_row = @mssql_fetch_assoc($result)) {
                $_rows[$i] = array_map('utf8_encode', $_row);
                $i++;
            }
        } catch (Exception $e) {
            $this->logger->error($e->getMessage());
        }

        mssql_close($this->connection);
        $this->connection = null;
        return $_rows;
    }

    public function ejec_store_procedura_sql($nombrestore, $arraydatos)
    {
        $this->initDB();
        $datos = null;

        try {
            $caddatos = '';
            //echo "cadena". $arraydatos[0][0];
            if ($arraydatos != '' || $arraydatos != null) {
                if (count($arraydatos) > 0) {
                    for ($i = 0; $i < count($arraydatos); $i++) {
                        $nomvar = $arraydatos[$i][0];
                        $valvar = $arraydatos[$i][1];
                        $caddatos .= $nomvar . "='" . $valvar . "',";
                    }
                    $caddatos = substr($caddatos, 0, strlen($caddatos) - 1);
                }
            }
            $cadins = 'exec ' . $nombrestore . ' ' . $caddatos;

            $this->logger->info($cadins);
            $result = mssql_query($cadins) or die(mssql_get_last_message());

            $contador = 0;

            while ($row = mssql_fetch_row($result)) {
                $c = count($row);
                for ($i = 0; $i < $c; $i++) {
                    //$cadreplace = $row[$i];
                    $cadreplace = htmlentities($row[$i]);
                    $cadreplace = str_replace('&amp;', '&', $cadreplace);
                    $cadreplace = str_replace("'", ' ', $cadreplace);
                    $cadreplace = str_replace('"', ' ', $cadreplace);
                    //$cadreplace = str_replace('|','',$cadreplace);
                    $cadreplace = str_replace('�', '', $cadreplace);
                    $cadreplace = str_replace('\\', '', $cadreplace);
                    //$cadreplace = str_replace('&Ntilde;',htmlentities('�'),$cadreplace);
                    $arraydata[$i] = $cadreplace;
                }
                $datos[$contador] = $arraydata;
                $contador++;
            }
        } catch (Exception $e) {
            $this->logger->error($e->getMessage());
        }
        mssql_close($this->connection);
        $this->connection = null;
        return $datos;
    }
    public function executeSelect($function, $parameters = null)
    {
        $this->initDB();
        $_rows = null;

        try {
            $_parameters = '';
            if (count($parameters) > 0) {
                for ($i = 0; $i < count($parameters); $i++) {
                    $parameters[$i] = str_replace("'", "&#39", $parameters[$i]);
                }
                $_parameters = implode("','", $parameters);
                $_parameters = "'" . $_parameters . "'";
            }

            $_query = "select * from " . $function . "(" . $_parameters . ");";
            $this->logger->info($_query);
            $result = pg_query($this->connection, $_query) or die(pg_last_error());

            $_rowCount = pg_num_rows($result);
            $_rows = array();
            for ($i = 0; $i < $_rowCount; $i++) {
                $_row = pg_fetch_row($result, $i);
                for ($j = 0; $j < count($_row); $j++) {
                    $_rows[$i][$j] = $_row[$j] == null ? '' : $_row[$j];
                }
            }
        } catch (Exception $e) {
            $this->logger->error($e->getMessage());
        }

        pg_close($this->connection);
        $this->connection = null;
        return $_rows;
    }
    public function executeSelectScalar($function, $parameters = null)
    {
        $this->initDB();
        $_rows = null;

        try {
            $_parameters = '';
            if (count($parameters) > 0) {
                for ($i = 0; $i < count($parameters); $i++) {
                    $parameters[$i] = str_replace("'", "&#39", $parameters[$i]);
                }
                $_parameters = implode("','", $parameters);
                $_parameters = "'" . $_parameters . "'";
            }

            $_query = "select " . $function . "(" . $_parameters . ")";

            $this->logger->info($_query);
            $result = mssql_query($_query, $this->connection) or die(mssql_get_last_message());

            $_rowCount = mssql_num_rows($result);
            $_rows = array();
            for ($i = 0; $i < $_rowCount; $i++) {
                $_row = mssql_fetch_row($result);
                for ($j = 0; $j < count($_row); $j++) {
                    $_rows[$i][$j] = $_row[$j] == null ? '' : $_row[$j];
                }
            }
        } catch (Exception $e) {
            $this->logger->error($e->getMessage());
        }

        mssql_close($this->connection);
        $this->connection = null;
        return $_rows;
    }

    public function executeAssocSelect($function, $parameters = null)
    {
        $this->initDB();
        $_rows = null;

        try {
            $_parameters = '';
            if (count($parameters) > 0) {
                $_parameters = implode("','", $parameters);
                $_parameters = "'" . $_parameters . "'";
            }

            $_query = "select * from " . $function . "(" . $_parameters . ");";
            $this->logger->info($_query);
            $result = pg_query($this->connection, $_query) or die(pg_last_error());

            $_rowCount = pg_num_rows($result);
            $_rows = array();
            for ($i = 0; $i < $_rowCount; $i++) {
                $_row = pg_fetch_assoc($result, $i);
                $_rows[$i] = $_row;
            }
        } catch (Exception $e) {
            $this->logger->error($e->getMessage());
        }

        pg_close($this->connection);
        $this->connection = null;
        return $_rows;
    }

    public function saveQuery($name, $function, $parameters = null)
    {
        $rows = $this->ejec_store_procedura_sql($function, $parameters);
        $dataSet = new Zend_Session_Namespace($name);
        $dataSet->data = $rows;
        return count($rows);
    }

    public function saveSelect($name, $function, $parameters = null)
    {
        $rows = $this->executeSelect($function, $parameters);
        $dataSet = new Zend_Session_Namespace($name);
        $dataSet->data = $rows;
        return count($rows);
    }
}
