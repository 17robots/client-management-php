<?php
  include_once("../DB/Connection.php");
  class Contact {

    // members
    public $id;
    public $datecreated;
    public $creatorId;
    public $projectId;
    public $firstname;
    public $lastname;
    public $email;
    public $maincontact;
    
    public function __construct() {
      $this->id = -1;
      $this->datecreated = "";
      $this->creatorId = -1;
      $this->projectId = -1;
      $this->firstname = "";
      $this->lastname = "";
      $this->email = "";
      $this->maincontact = false;
    }

    public static function ForInsert($creatorId, $projectId, $firstname, $lastname, $email, $maincontact) {
      $instance = new self();
      $instance->creatorId = $creatorId;
      $instance->projectId = $projectId;
      $instance->firstname = $firstname;
      $instance->lastname = $lastname;
      $instance->email = $email;
      $instance->maincontact = $maincontact;
      return $instance;
    }

    public static function ForRead($id, $datecreated, $creatorId, $projectId, $firstname, $lastname, $email, $maincontact) {
      $instance = new self();
      $instance->id = $id;
      $instance->creatorId = $creatorId;
      $instance->projectId = $projectId;
      $instance->firstname = $firstname;
      $instance->lastname = $lastname;
      $instance->email = $email;
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
        $sql = "insert into contacts(datecreated, creatorid, projectid, firstname, lastname, email, maincontact) values (NOW(), $this->creatorId, $this->projectId, '$this->firstname', '$this->lastname', '$this->email', $this->maincontact);";
      } else {
        $sql = "update contacts set creatorid = $this->creatorId, projectid = $this->projectId, firstname = '$this->firstname', lastname = '$this->lastname', email = '$this->email', maincontact = $this->maincontact where id =$this->id;";
      }

      $result = $conn->query($sql);
      if($result && $this->id == -1) $this->id = $conn->connection->insert_id;
      $conn->close();
      return $result;
    }
    
    // reading
    public function findAll($options) {
      $conn = new Connection();
      $sql = 'SELECT * FROM contacts';

      foreach($options as $key => $value) {
        if(property_exists('Contact', $key))
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
      while($row = mysqli_fetch_assoc($result)) {
        array_push($returnedArr, Contact::ForRead($row["id"], $row["datecreated"], $row["creatorid"], $row["projectid"], $row["firstname"], $row["lastname"], $row["email"], $row["maincontact"]));
      }

      $conn->close();

      return $returnedArr;
    }

    public function findById($id) {
      $returnedContact;
      $conn = new Connection();
      $sql = "SELECT * FROM contacts WHERE id = $id;";
      $result = $conn->query($sql);

      if(mysqli_num_rows($result) > 1) {
        $returnedContact = new Contact();
      } else if(mysqli_num_rows($result) == 1) {
        $row = $result->fetch_assoc();
        $returnedContact = Contact::ForRead($row["id"], $row["datecreated"], $row["creatorid"], $row["projectid"], $row["firstname"], $row["lastname"], $row["email"], $row["maincontact"]);
      }
      $conn->close();
      return $returnedClient;
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