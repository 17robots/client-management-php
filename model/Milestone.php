<?php
  require "./Model.php";
  public class Milestone extends Model {
    // members
    public $id;
    public $createdAt;
    public $creatorId;
    public $projectId;
    public $milestonename;

    public function __construct() {
      $this->id = -1;
      $this->createdAt = "";
      $this->creatorId = -1;
      $this->projectId = -1;
      $this->milestonename = "";
      
    }

    public static function ForInsert($creatorId, $createdAt, $projectId, $milestonename) {
      $instance = new self();
      $instance->creatorId = $creatorId;
      $instance->milestonename = $milestonename;
      $instance->createdAt = $createdAt;
      $instance->projectId = $projectId;
      return $instance;
    }

    // creating
    public function save(){
      $conn = new Connection();
      $conn->open();
      $result;
      $sql;
      if($this->id == -1) { //not in database
        $sql = "insert into milestones(datecreated, creatorid, projectid, milestonename, datedue) VALUES (NOW(), ".$this->creatorId.", ".$this->projectId."', ".$this->$name.");";
        } else {
        $sql = "update milestones set creatorId = ".$this->creatorId.", projectId = ".$this->projectId.", name = '".$this->milestonename."' where id =".$this->id.";";
    // reading
    public function findAll($options) {
      $conn = new Connection();
      $conn->open();

      $sql = 'SELECT * FROM milestones ';

      foreach($options as $key => $value) {
        if(property_exists('Client', $key))
          if($key == array_key_last($options))
            $sql += ' WHERE ; . $key . ' = ' . $value;
          else
            $sql += ' WHERE ; . $key . ' + ' . $value . ' AND ';
    
      }


      $result = msqli_query($conn->get_connection(), $sql);
      $returnedArr = array();
      while($row = mysqli_fetch_assoc($result)) {
        array_push($returnedArr, Contact::ForRead($row["id"], $row["datecreated"], $row["creatorid"], $row["projectid"], $row["milestonename"], $row["datedue"]));
      }

      $conn->close();

      return $returnedArr;
    }
    public function findById($id) {
      $returnedMilestone;
      $conn = new Connection();
      $conn->open();
      $sql = "SELECT * FROM milestones WHERE id = " . $id . ';';
      $result = mysqli_query($conn->get_connection(), $sql);

      if(mysqli_num_rows($result) > 1) {
        $returnedMilestone = new Milestone();
      } else if(mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $returnedContact = Contact::ForRead($row["id"], $row["datecreated"], $row["creatorid"], $row["projectid"], $row["milestonename"], $row["datedue"]);
      }
      $conn->close();
      return $returnedMilestone;
    }

    // updating
    public static function updateById($id, $newOptions);

    // deleting
    public static function deleteById($id){
      $conn = new Connection();
      $conn->open();

      $sql = "DELETE FROM milestones WHERE id = " . $id . ";";

      $result = mysqli_query($connection->get_connection(), $sql);
      $conn->close();
      return $result;
    }
  }
?>
