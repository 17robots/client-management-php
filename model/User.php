<?php
  require "./Model.php";
  public class User extends Model {
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
      return $instance;
    }

    public static function ForRead($id, $datecreated, $firstname, $lastname, $username, $email, $password) {
      $instance = new self();
      $instance->firstname = $firstname;
      $instance->lastname = $lastname;
      $instance->username = $username;
      $instance->email = $email;
      $instance->password = $password;
      return $instance;
    }

    public function save() {
      $conn = new Connection();
      $conn->open();
      $result;
      $sql;
      if($this->id == -1) {
        $sql = "insert into users (datecreated, firstname, lastname, username, email, password) VALUES (NOW(), '$this->firstname', '$this->lastname', '$this->username', '$this->email', '$this->password')";
      } else {
        $sql = "update users set firstname = '$this->firstname', lastname ='$this->lastname', username = '$this->username', email = '$this->email', password = '$this->password' where id = $this->id;";
      }

      $result = mysqli_query($conn->get_connection(), $sql);
      $conn->close();
      return $result;
    }
    
    public function findAll($options) {
      $conn = new Connection();
      $conn->open();

      $sql = 'SELECT * FROM users ';

      foreach($options as $key => $value) {
        if(property_exists('User', $key))
          if($key == array_key_last($options)) {
            if(is_numeric($value)) {
              $sql .= " WHERE $key = $value";
            } else {
              $sql .= " WHERE $key = '$value'";
            }
          } else {
            if(is_numeric($value)) {
              $sql .= " WHERE $key = $value AND";
            } else {
              $sql .= " WHERE $key = '$value' AND";
            }
          }
      }

      $sql .= ' ORDER BY ID';

      $result = $conn->query($sql);
      $returnedArr = array();
      while($row = $result->fetch_assoc()) {
        array_push($returnedArr, User::ForRead($row["id"], $row["datecreated"], $row["firstname"], $row["lastname"], $row["username"], $row["email"], $row["password"]));
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
        $row = $result->fetch_assoc();
        $returnedUser = User::ForRead($row["id"], $row["datecreated"], $row["firstname"], $row["lastname"], $row["username"], $row["email"], $row["password"]);
      }
      $conn->close();
      return $returnedUser;
    }

    public static function deleteById($id) {
      $conn = new Connection();
      $conn->open();

      $sql = "DELETE FROM users WHERE id = $id;";

      $result = $conn->query($sql);
      $conn->close();
      return $result;
    }
  }
?>