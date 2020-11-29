<?php
  include_once("../DB/Connection.php");
  class Contact {
    public $id;
    public $datecreated;
    public $creatorid;
    public $clientid;
    public $firstname;
    public $lastname;
    public $email;
    public $phone;
    public $maincontact;
    
    public function __construct() {
      $this->id = -1;
      $this->datecreated = "";
      $this->creatorid = -1;
      $this->clientid = -1;
      $this->firstname = "";
      $this->lastname = "";
      $this->email = "";
      $this->maincontact = false;
    }

    public static function ForInsert($creatorid, $clientid, $firstname, $lastname, $email, $phone, $maincontact) {
      $instance = new self();
      $instance->creatorid = $creatorid;
      $instance->clientid = $clientid;
      $instance->firstname = $firstname;
      $instance->lastname = $lastname;
      $instance->email = $email;
      $instance->phone = $phone;
      $instance->maincontact = $maincontact;
      return $instance;
    }

    public static function ForRead($id, $datecreated, $creatorid, $clientid, $firstname, $lastname, $email, $phone, $maincontact) {
      $instance = new self();
      $instance->id = $id;
      $instance->creatorid = $creatorid;
      $instance->clientid = $clientid;
      $instance->firstname = $firstname;
      $instance->lastname = $lastname;
      $instance->email = $email;
      $instance->phone = $phone;
      $instance->maincontact = $maincontact;
      return $instance;
    }

    // creating
    public function save() {
      $conn = new Connection();
      $conn->open();
      $result;
      $sql;
      if($this->id == -1) {
        $sql = "insert into contacts(datecreated, creatorid, clientid, firstname, lastname, email, maincontact) values (NOW(), $this->creatorid, $this->clientid, '$this->firstname', '$this->lastname', '$this->email', $this->maincontact);";
      } else {
        $sql = "update contacts set creatorid = $this->creatorid, clientid = $this->clientid, firstname = '$this->firstname', lastname = '$this->lastname', email = '$this->email', maincontact = $this->maincontact where id =$this->id;";
      }
      $result = $conn->query($sql);
      if($result && $this->id == -1) $this->id = $conn->connection->insert_id;
      $conn->close();
      return $result;
    }
    
    // reading
    public static function findAll($options) {
      $conn = new Connection();
      $sql = 'SELECT * FROM contacts';

      if(count((array)$options) > 0) $sql .= " where ";

      foreach($options as $key => $value) {
        if(property_exists('Contact', $key))
          if($key == array_key_last((array)$options)) {
            if(is_numeric($value)) {
              $sql .= " $key = $value";
            } else {
              $sql .= " $key = '$value'";
            }
          } else {
            if(is_numeric($value)) {
              $sql .= " $key = $value AND";
            } else {
              $sql .= " $key = '$value' AND";
            }
          }
      }

      $sql .= ' ORDER BY ID';

      $result = $conn->query($sql);
      $returnedArr = array();
      if(!$result) return $returnedArr;
      while($row = mysqli_fetch_assoc($result)) {
        array_push($returnedArr, Contact::ForRead($row["id"], $row["datecreated"], $row["creatorid"], $row["clientid"], $row["firstname"], $row["lastname"], $row["email"], $row['phone'], $row["maincontact"]));
      }

      $conn->close();

      return $returnedArr;
    }

    public static function findById($id) {
      $returnedContact;
      $conn = new Connection();
      $sql = "SELECT * FROM contacts WHERE id = $id;";
      $result = $conn->query($sql);

      if(mysqli_num_rows($result) > 1 || mysqli_num_rows($result) == 0) {
        $returnedContact = new Contact();
      } else if(mysqli_num_rows($result) == 1) {
        $row = $result->fetch_assoc();
        $returnedContact = Contact::ForRead($row["id"], $row["datecreated"], $row["creatorid"], $row["clientid"], $row["firstname"], $row["lastname"], $row["email"], $row['phone'], $row["maincontact"]);
      }
      $conn->close();
      return $returnedContact;
    }

    // deleting
    public static function deleteById($id) {
      $conn = new Connection();
      $conn->open();

      $sql = "DELETE FROM contacts WHERE id = $id;";

      $result = $conn->query($sql);
      $conn->close();
      return $result;
    }
  }
?>