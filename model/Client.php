<?php
  include_once("../DB/Connection.php");
  class Client {
    public $id;
    public $creatorId;
    public $name;
    public $address;
    public $clientPhone;
    public $clientEmail;

    public function __construct() {
      $this->id = -1;
      $this->dateCreated = "";
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

    public static function ForRead($id, $dateCreated, $creatorId, $mainContactId, $name, $address, $clientPhone, $clientEmail) {
      $instance = new self();
      $instance->id = $id;
      $instance->dateCreated = $dateCreated;
      $instance->creatorId = $creatorId;
      $instance->name = $name;
      $instance->address = $address;
      $instance->clientPhone = $clientPhone;
      $instance->clientEmail = $clientEmail;
      return $instance;
    }

    //pre: any options to filter for
    //post: returns an array of client objects or an empty array
    public static function findAll($options) {
      $conn = new Connection();
      $conn->open();

      $sql = 'SELECT * FROM clients ';

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
        array_push($returnedArr, Client::ForRead($row["id"], $row["datecreated"], $row["creatorid"], $row["clientname"], $row["clientaddress"], $row["clientphone"], $row["clientemail"]));
      }

      $conn->close();

      return $returnedArr;
    }
    
    // pre: id for client to find
    // post: filled client object if found, empty otherwise
    public static function findById($id) {
      $returnedClient;
      $conn = new Connection();
      $conn->open();
      $sql = "SELECT * FROM clients WHERE id = " . $id . ';';
      $result = mysqli_query($conn->get_connection(), $sql);

      if(mysqli_num_rows($result) > 1) {
        $returnedClient = new Client();
      } else if(mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $returnedClient = Client::ForRead($row["id"], $row["datecreated"], $row["creatorid"], $row["clientname"], $row["clientaddress"], $row["clientphone"], $row["clientemail"]);
      }
      $conn->close();
      return $returnedClient;
    }

    //pre: this is a valid Client object
    //post: returns a bool based on the success of the query
    // required base query: 
    // $sql = "insert into clients(datecreated, creatorid, clientname, clientaddress, clientphone, clientemail) values(NOW(), 1, \'Client\', \'Address\', \'123-456-7890\', \'client@email.com\')";
    public function save() {
      $conn = new Connection();
      $conn->open();
      $result;
      $sql;
      if($this->id == -1) { // not in db
        $sql = "insert into clients(datecreated, creatorid, clientname, clientaddress, clientphone, clientemail) values(NOW(), " . $this->creatorId .", '" . $this->name ."', '"  . $this->address ."', '" . $this->clientPhone ."', '"  . $this->clientEmail ."')";
      }
      else {
        $sql = "update clients set creatorid = " . $this->creatorid . ", clientname = '" . $this->name . "', clientaddress = '" . $this->address . "', clientphone = '" . $this->clientPhone . "', clientemail = '" . $this->clientEmail . "' where id = " . $this->id . ";";
      }

      $result = mysqli_query($conn->get_connection(), $sql);
      $conn->close();
      return $result;
    }

    //pre: the id to delete in the table
    //post: bool based on result of the query
    // required base query: 
    // DELETE FROM `clients` WHERE `clients`.`id` = 2;
    public static function deleteById($id) {
      $conn = new Connection();
      $conn->open();

      $sql = "DELETE FROM clients WHERE id = " . $id . ";";

      $result = mysqli_query($connection->get_connection(), $sql);
      $conn->close();
      return $result;
    }
  }
?>