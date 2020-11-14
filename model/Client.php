<?php
  require "./Model.php";
  include_once("../DB/Connection.php");
  public class Client extends Model {
    // members
    public $id;
    public $creatorId;
    public $name;
    public $address;
    public $clientPhone;
    public $clientEmail;

    public $tableName = 'clients';

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

    //pre: any options to filter for
    //post: returns an array of client objects or an empty array
    public static function findAll($options) {
      $conn = new Connection();
      $conn->open();

      $sql = 'SELECT * FROM clients ';

      foreach($options as $key => $value) {
        if(property_exists('Client', $key))
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
    
    // pre: id for client to find
    // post: filled client object if found, empty otherwise
    public static function findById($id) {
      $returnedClient;

      $conn = new Connection();
      $conn->open();

      $sql = "SELECT * FROM " . $tableName . " WHERE id = " . $id . ';';
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

    //pre: this is a valid Client object
    //post: returns a bool based on the success of the query
    // required base query: 
    // $sql = "insert into clients(datecreated, creatorid, clientname, clientaddress, clientphone, clientemail) values(NOW(), 1, \'Client\', \'Address\', \'123-456-7890\', \'client@email.com\')";
    public function save() {
      $result;
      $conn = new Connection();
      $conn->open();

      $sql = "insert into clients(datecreated, creatorid, clientname, clientaddress, clientphone, clientemail) values(NOW(), " . $this->creatorId .", '" .. $this->name ."', '"  . $this->address ."', '" . $this->clientPhone ."', '"  . $this->clientEmail ."')";

      if(mysqli_query($conn->get_connection(), $sql)) {
        $result = true;
      } else {
        $result = false;
      }
      
      $conn->close();
      return $result;
    }

    // updating
    // required base query: 
    // 
    public static function updateById($id, $newOptions) {
      
    }

    // deleting
    // required base query: 
    // 
    public static function deleteById($id) {

    }
  }
?>