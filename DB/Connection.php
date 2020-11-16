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
      $dbname = 'clientmanagement'
    }

    public function open() {
      $connection = mysqli_connect($servername, $username, $password, $dbname);
      if(!$connection) {
        return false;
      }
      return true;
    }

    public function close() {
      mysqli_close($connection);
    }

    public function get_connection() {
      return $connection;
    }

    public function get_table() {
      return $tblName;
    }
  }
?>
