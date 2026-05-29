<?php
class Database {
    private $host       = 'localhost',
            $db_name    = 'contact_system',
            $username   = '',
            $password   = '';            
    public $_conn; 

    public function getConnection() {
        $this->_conn = null;

        try {
            $this->_conn = new PDO(
                'mysql:host=' . $this->host . ';dbname=' . $this->db_name,
                $this->username, $this->password
            );
            $this->_conn->exec('set names utf8');
            $this->_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(Exception $e) {
            echo 'Connection error: ' . $e->getMessage();
        }
        return $this->_conn;
    }
}