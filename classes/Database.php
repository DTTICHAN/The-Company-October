<?php
    class Database{
        //Properties
        private $server_name = "localhost"; //127.0.0.1
        private $username = "root";
        private $password = "root";
        private $db_name = "the_company_october";
        protected $conn;

        //constructor
        public function __construct(){
            $this->conn = new mysqli($this->server_name, $this->username, $this->password, $this->db_name);

            //check if there is an error in the connection
            if ($this->conn->connect_error) {
                die("Unable to connect to the database " . $this->conn->connect_error);
            }
        }
    }
?>