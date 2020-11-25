<?php
  include_once("../DB/Connection.php");
  class Client {
    public $id;
    public $creatorId;
    public $datecreated;
    public $name;
    public $address;
    public $clientPhone;
    public $clientEmail;

    public function __construct() {
      $this->id = -1;
      $this->datecreated = "";
      $this->creatorId = -1;
      $this->name = "";
      $this->address = "";
      $this->clientPhone = "";
      $this->clientEmail = "";
    }

    public static function ForInsert($creatorId, $mainContactId, $name, $address, $clientPhone, $clientEmail) {
      $instance = new self();
      $instance->creatorId = $creatorId;
      $instance->name = $name;
      $instance->address = $address;
      $instance->clientPhone = $clientPhone;
      $instance->clientEmail = $clientEmail;
      return $instance;
    }

    public static function ForRead($id, $datecreated, $creatorId, $mainContactId, $name, $address, $clientPhone, $clientEmail) {
      $instance = new self();
      $instance->id = $id;
      $instance->datecreated = $datecreated;
      $instance->creatorId = $creatorId;
      $instance->name = $name;
      $instance->address = $address;
      $instance->clientPhone = $clientPhone;
      $instance->clientEmail = $clientEmail;
      return $instance;
    }

    public static function findAll($options) {
      $conn = new Connection();

      $sql = 'SELECT * FROM clients';

      foreach($options as $key => $value) {
        if(property_exists('Client', $key))
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
        array_push($returnedArr, Client::ForRead($row["id"], $row["datecreated"], $row["creatorid"], $row["clientname"], $row["clientaddress"], $row["clientphone"], $row["clientemail"]));
      }

      $conn->close();

      return $returnedArr;
    }
    
    public static function findById($id) {
      $returnedClient;
      $conn = new Connection();
      
      $sql = "SELECT * FROM clients WHERE id = $id;";
      $result = $conn->query($sql);

      if(mysqli_num_rows($result) > 1) {
        $returnedClient = new Client();
      } else if(mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $returnedClient = Client::ForRead($row["id"], $row["datecreated"], $row["creatorid"], $row["clientname"], $row["clientaddress"], $row["clientphone"], $row["clientemail"]);
      }
      $conn->close();
      return $returnedClient;
    }

    public function save() {
      $conn = new Connection();
      
      $result;
      $sql;
      if($this->id == -1) { // not in db
        $sql = "insert into clients(datecreated, creatorid, clientname, clientaddress, clientphone, clientemail) values(NOW(), $this->creatorId, '$this->name', '$this->address', '$this->clientPhone', '$this->clientEmail');";
      }
      else {
        $sql = "update clients set creatorid = $this->creatorid, clientname = '$this->name', clientaddress = '$this->address', clientphone = '$this->clientPhone', clientemail = '$this->clientEmail' where id = $this->id;";
      }

      $result = $conn->query($sql);
      if($result && $this->id == -1) $this->id = $conn->connection->insert_id;
      $conn->close();
      return $result;
    }

    public static function deleteById($id) {
      $conn = new Connection();
      
      $sql = "DELETE FROM clients WHERE id = $id;";

      $result = $conn->query($sql);
      $conn->close();
      return $result;
    }
  }
?>