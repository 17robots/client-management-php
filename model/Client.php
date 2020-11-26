<?php
  include_once("../DB/Connection.php");
  class Client {
    public $id;
    public $creatorid;
    public $datecreated;
    public $clientname;
    public $address;
    public $clientphone;
    public $clientemail;

    public function __construct() {
      $this->id = -1;
      $this->datecreated = "";
      $this->creatorid = -1;
      $this->clientname = "";
      $this->address = "";
      $this->clientphone= "";
      $this->clientemail = "";
    }

    public static function ForInsert($creatorid, $clientname, $address, $clientphone, $clientemail) {
      $instance = new self();
      $instance->creatorid = $creatorid;
      $instance->clientname = $clientname;
      $instance->address = $address;
      $instance->clientphone= $clientphone;
      $instance->clientemail = $clientemail;
      return $instance;
    }

    public static function ForRead($id, $datecreated, $creatorid, $clientname, $address, $clientphone, $clientemail) {
      $instance = new self();
      $instance->id = $id;
      $instance->datecreated = $datecreated;
      $instance->creatorid = $creatorid;
      $instance->clientname = $clientname;
      $instance->address = $address;
      $instance->clientphone= $clientphone;
      $instance->clientemail = $clientemail;
      return $instance;
    }

    public static function findAll($options) {
      $conn = new Connection();

      $sql = 'SELECT * FROM clients';

      if(count((array)$options) > 0) $sql .= " where ";

      foreach($options as $key => $value) {
        if(property_exists('Client', $key))
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

      if(mysqli_num_rows($result) > 1 || mysqli_num_rows($result) == 0) {
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
        $sql = "insert into clients(datecreated, creatorid, clientname, clientaddress, clientphone, clientemail) values(NOW(), $this->creatorid, '$this->clientname', '$this->address', '$this->clientphone', '$this->clientemail');";
      }
      else {
        $sql = "update clients set creatorid = $this->creatorid, clientname = '$this->clientname', clientaddress = '$this->address', clientphone = '$this->clientphone', clientemail = '$this->clientemail' where id = $this->id;";
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