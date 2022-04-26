<?php
    namespace Src\Database\Connection;

    class Connection {

        public static $instance;

        private function __construct() {
            //
        }

        public static function getInstance() {
            if (!isset(self::$instance)) {
                self::$instance = new \PDO(
                    DBDRIVE.':host='.DBHOST.';dbname='.DBNAME.'', 
                    DBUSER, 
                    DBPASS, 
                    [\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"]
                );
                self::$instance->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
                self::$instance->setAttribute(\PDO::ATTR_ORACLE_NULLS, \PDO::NULL_EMPTY_STRING);
            }

            return self::$instance;
        }

    }
