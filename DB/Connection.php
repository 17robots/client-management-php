<?php
  public class Connection {
    private $servername;
    private $dbname;
    private $username;
    private $password;
    private $connection;

    function __construct() {
      $servername = 'localhost';
      $username = 'clientmanager';
      $password = 'clientmanager';
      $dbname = 'clientmanagement';
      $this->connection = new mysqli($this->servername, $this->username, $this->password, $this->dbName);
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
      mysqli_close($connection);
    }
  }
?>
