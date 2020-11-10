<?php
  require "./Model.php";
  include_once("../DB/Connection.php");
  public class Client extends Model {
    // members
    public $id;
    public $dateCreated;
    public $creatorId;
    public $mainContactId;
    public $name;
    public $address;
    public $clientPhone;
    public $clientEmail;

    // constructors
    public function __construct($creatorId, $mainContactId, $name, $address, $clientPhone, $clientEmail) {
      $this->dateCreated = $dateCreated;
      $this->creatorId = $creatorId;
      $this->mainContactId = $mainContactId;
      $this->name = $name;
      $this->address = $address;
      $this->clientPhone = $clientPhone;
      $this->clientEmail = $clientEmail; 
    }

    public function __construct($id, $dateCreated, $creatorId, $mainContactId, $name, $address, $clientPhone, $clientEmail) {
      $this->id = $id;
      $this->dateCreated = $dateCreated;
      $this->creatorId = $creatorId;
      $this->mainContactId = $mainContactId;
      $this->name = $name;
      $this->address = $address;
      $this->clientPhone = $clientPhone;
      $this->clientEmail = $clientEmail; 
    }

    // reading
    public static function findAll($options) {
      $conn = new Connection();
      $conn->open();

      $sql = 'SELECT * FROM clients;';

      foreach($options as $key => $value) {
        $sql += ' WHERE ' . $key . ' = ' . $value;
      }

      $result = msqli_query($conn->get_connection(), $sql);
      $returnedArr = array();
      while($row = mysqli_fetch_assoc($result)) {
        array_push($returnedArr, new Client($row["id"], $row["datecreated"], $row["creatorid"], $row["maincontactid"], $row["clientname"], $row["clientaddress"], $row["clientphone"], $row["clientemail"]));
      }

      $conn->close();

      return $returnedArr;
    }

    public static function findById($id) {
      $returnedClient;

      $conn = new Connection();
      $conn->open();

      $sql = "SELECT * FROM clients WHERE id = " . $id . ';';
      $result = mysqli_query($conn->get_connection(), $sql);

      if(mysqli_num_rows($result) > 1) {
        $returnedClient = new Client(-1, "", -1, -1, "", "", "", "");
      } else if(mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $returnedClient = new Client($row["id"], $row["datecreated"], $row["creatorid"], $row["maincontactid"], $row["clientname"], $row["clientaddress"], $row["clientphone"], $row["clientemail"]);
      }

      conn->close();
      return $returnedClient;
    }
    
    // creating
    public function save() {
      // YYYY-MM-DD HH:MM:SS
      $result;
      $conn = new Connection();
      $conn->open();

      $sql = " Insert into " . $conn->get_table() . " (title, price, quantity) VALUES ('" . $title . "', " . $price . ", " . $quantity . ");";

      if(mysqli_query($conn->get_connection(), $sql)) {
        
        $result = true;
      } else {
        $result = false;
      }
      
      $conn->close();
      return $result;
    }

    // updating
    public static function updateById($id, $newOptions) {
      
    }

    // deleting
    public static function deleteById($id) {

    }
  }
?>