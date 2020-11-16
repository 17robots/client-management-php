<?php
  require "./Model.php";
  public class User extends Model {
    // members
    public $id;
    public $datecreated;
    public $firstname;
    public $lastname;
    public $username;
    public $email;
    public $password;

    public function __construct() {
      $this->id = -1;
      $this->datecreated = "";
      $this->firstname = "";
      $this->lastname = "";
      $this->username = "";
      $this->email = "";
      $this->password = "";
    }
    
    public static function ForInsert($firstname, $lastname, $username, $email, $password) {
      $instance = new self();
      $instance->firstname = $firstname;
      $instance->lastname = $lastname;
      $instance->username = $username;
      $instance->email = $email;
      $instance->password = $password;
    }

    public static function ForRead($id, $datecreated, $firstname, $lastname, $username, $email, $password) {
      $instance = new self();
      $instance->firstname = $firstname;
      $instance->lastname = $lastname;
      $instance->username = $username;
      $instance->email = $email;
      $instance->password = $password;
    }

    // creating
    // base level query: $sql = "INSERT INTO `users` (`id`, `datecreated`, `firstname`, `lastname`, `username`, `email`, `password`) VALUES (NULL, NOW(), \'Matt\', \'Dray\', \'mdray\', \'mdray@ameritech.net\', \'password\')";
    public function save() {
      $conn = new Connection();
      $conn->open();
      $result;
      $sql;
      if($this->id == -1) {
        $sql = "insert into users (datecreated, firstname, lastname, username, email, password) VALUES (NOW(), '".$this->firstname."', '".$this->lastname."', '".$this->username."', '".$this->email."', '".$this->password."')";
      } else {
        $sql = "update users set firstname = '".$this->firstname."', lastname ='".$this->lastname."', username = '".$this->username."', email = '".$this->email."', password = '".$this->password."' where id = ".$this->id.";";
      }

      $result = mysqli_query($conn->get_connection(), $sql);
      $conn->close();
      return $result;
    }
    
    // reading
    public function findAll($options) {
      $conn = new Connection();
      $conn->open();

      $sql = 'SELECT * FROM contacts ';

      foreach($options as $key => $value) {
        if(property_exists('Client', $key))
          if($key == array_key_last($options))
            $sql += ' WHERE ' . $key . ' = ' . $value;
          else
            $sql += ' WHERE ' . $key . ' = ' . $value . ' AND ';
      }

      $result = msqli_query($conn->get_connection(), $sql);
      $returnedArr = array();
      while($row = mysqli_fetch_assoc($result)) {
        array_push($returnedArr, User::ForRead($row["id"], $row["datecreated"], $row["firstname"], $row["lastname"], $row["username"], $row["email"], $row["password"], $row["maincontact"]));
      }

      $conn->close();

      return $returnedArr;
    }

    public function findById($id) {
      $returnedUser;
      $conn = new Connection();
      $conn->open();
      $sql = "SELECT * FROM contacts WHERE id = " . $id . ';';
      $result = mysqli_query($conn->get_connection(), $sql);

      if(mysqli_num_rows($result) > 1) {
        $returnedUser = new User();
      } else if(mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $returnedUser = User::ForRead($row["id"], $row["datecreated"], $row["firstname"], $row["lastname"], $row["username"], $row["email"], $row["password"], $row["maincontact"]);
      }
      $conn->close();
      return $returnedUser;
    }

    // deleting
    public static function deleteById($id) {
      $conn = new Connection();
      $conn->open();

      $sql = "DELETE FROM users WHERE id = " . $id . ";";

      $result = mysqli_query($connection->get_connection(), $sql);
      $conn->close();
      return $result;
    }
  }
?>