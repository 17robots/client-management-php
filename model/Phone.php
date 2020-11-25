<?php
  require "./Model.php";
  class Phone {

    // members
    public $id;
    public $datecreated;
    public $creatorId;
    public $contactId;
    public $type;
    public $number;

    public function __construct() {
      $this->id = -1;
      $this->datecreated = "";
      $this->creatorId = -1;
      $this->contactId = -1;
      $this->type = "";
      $this->number = -1;
    }

    public static function ForInsert($creatorId, $contactId, $type, $number) {
      $instance = new self();
      $instance->creatorId = $creatorId;
      $instance->contactId = $contactId;
      $instance->type = $type;
      $instance->number = $number;
      return $instance;
    }

    public static function ForRead($id, $creatorId, $datecreated, $contactId, $type, $number) {
      $instance = new self();
      $instance->id = $id;
      $instance->creatorId = $creatorId;
      $instance->datecreated = $datecreated;
      $instance->contactId = $contactId;
      $instance->type = $type;
      $instance->number = $number;
      return $instance;
    }

    // creating
    public function save() {
      $conn = new Connection();
      $result;
      $sql;
      if($this->id == -1) {
        $sql = "insert into phones(datecreated, creatorid, contactid, phonetype, phonenumber) values (NOW(), $this->creatorId, $this->contactId, '$this->phonetype', $this->phonenumber');";
      } else {
        $sql = "update contacts set creatorid = $this->creatorId, contactid = $this->contactId, phonetype = '$this->phonetype', phonenumber = '$this->phonenumber' where id = $this->id;";
      }

      $result = mysqli_query($conn->get_connection(), $sql);
      $conn->close();
      return $result;
    }
    
    public function findAll($options){
      $conn = new Connection();

      $sql = 'SELECT * FROM phones';

      foreach($options as $key => $value) {
        if(property_exists('Phone', $key))
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
        array_push($returnedArr, Phone::ForRead($row["id"], $row["datecreated"], $row["creatorid"], $row["contactid"], $row["phonetype"], $row["phonenumber"]));
      }

      $conn->close();

      return $returnedArr;
    }

    public function findById($id) {
      $returnedPhone;
      $conn = new Connection();

      $sql = "SELECT * FROM phoness WHERE id = $id;";
      $result = $conn->query($sql);

      if(mysqli_num_rows($result) > 1) {
        $returnedPhone = new Phone();
      } else if(mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $returnedPhone = Phone::ForRead($row["id"], $row["datecreated"], $row["creatorid"], $row["contactid"], $row["phonetype"], $row["phonenumber"]);
      }
      $conn->close();
      return $returnedPhone;
    }

    public static function deleteById($id);
      $conn = new Connection();

      $sql = "DELETE FROM phones WHERE id = $id;";

      $result = $conn->query($sql);

      $conn->close();
      return $result;
    }
  }
  }
?>
