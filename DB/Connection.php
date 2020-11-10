<?php
  public class Connection {
    private $servername;
    private $username;
    private $password;
    private $connection;
    private $tblName;

    function __construct() {
      $settings = json_decode(file_get_contents('../settings.json'), true);
      $servername = $settings['servername'];
      $username = $settings['username'];
      $password = $settings['password'];
      $tblName = 'books';
    }

    public function open() {
      $connection = mysqli_connect($servername, $username, $password);
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
