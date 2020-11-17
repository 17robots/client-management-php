<?php
  require "./Model.php";
  public class Phone extends Model {
    // members
    public $id;
    public $createdAt;
    public $creatorId;
    public $contactId;
    public $type;
    public $number;

    public function __construct() {
      $this->id = -1;
      $this->createdAt = "";
      $this->creatorId = -1;
      $this->contactId = -1;
      $this->type = "";
      $this->number = -1;
    }

    public static function ForInsert($creatorId, $createdAt, $contactId, $type, $number) {
      $instance = new self();
      $instance->creatorId = $creatorId;
      $instance->createdAt = $createdAt;
      $instance->contactId = $contactId;
      $instance->type = $type;
      $instance->number = $number;
      return $instance;
    }

    // creating
    public function save(){
      $conn = new Connection();
      $conn->open();
      $result;
      $sql;
      if($this->id == -1) {
        $sql = "insert into phones(datecreated, creatorid, contactid, phonetype, phonenumber) values (NOW(), ".$this->creatorId.", ".$this->contactId.", '".$this->phonetype."', '".$this->phonenumber.");";
      } else {
        $sql = "update contacts set creatorid = ".$this->creatorId.", contactid = ".$this->contactId.", phonetype = '".$this->phonetype."', phonenumber = '".$this->phonenumber."' where id =".$this->id.";";
      }

      $result = mysqli_query($conn->get_connection(), $sql);
      $conn->close();
      return $result;
    }
    
    // reading
    public function findAll($options){
      $conn = new Connection();
      $conn->open();

      $sql = 'SELECT * FROM phones ';

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
        array_push($returnedArr, Contact::ForRead($row["id"], $row["datecreated"], $row["creatorid"], $row["contactid"], $row["phonetype"], $row["phonenumber"]));
      }

      $conn->close();

      return $returnedArr;
    }

    public function findById($id) {
      $returnedPhone;
      $conn = new Connection();
      $conn->open();
      $sql = "SELECT * FROM phoness WHERE id = " . $id . ';';
      $result = mysqli_query($conn->get_connection(), $sql);

      if(mysqli_num_rows($result) > 1) {
        $returnedPhone = new Phone();
      } else if(mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $returnedPhone = Client::ForRead($row["id"], $row["datecreated"], $row["creatorid"], $row["contactid"], $row["phonetype"], $row["phonenumber"]);
      }
      $conn->close();
      return $returnedPhone;
    }

    // updating
    public static function updateById($id, $newOptions);

    // deleting
    public static function deleteById($id);
      $conn = new Connection();
      $conn->open();

      $sql = "DELETE FROM phones WHERE id = " . $id . ";";

      $result = mysqli_query($connection->get_connection(), $sql);
      $conn->close();
      return $result;
    }
  }
  }
?>
