<?php
  class Connection {
    private $servername;
    private $dbname;
    private $username;
    private $password;
    public $connection;

    function __construct() {
      $this->servername = 'localhost';
      $this->username = 'clientmanager';
      $this->password = 'clientmanager';
      $this->dbname = 'clientmanagement';
      $this->connection = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
      if($this->connection->connect_error) {
        echo $this->connection->connect_error; 
      }
    }

    public function open() {
    }

    public function query($sql) {
      return $this->connection->query($sql);
    }

    public function close() {
      mysqli_close($this->connection);
    }
  }
?>
