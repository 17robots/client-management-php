<?php
  require "./Model.php";
  class Milestone {
    // members
    public $id;
    public $datecreated;
    public $creatorId;
    public $projectId;
    public $milestonename;
    public $datedue;

    public function __construct() {
      $this->id = -1;
      $this->creatorId = -1;
      $this->projectId = -1;
      $this->milestonename = "";
    }

    public static function ForInsert($creatorId, $projectId, $milestonename, $datedue) {
      $instance = new self();
      $instance->creatorId = $creatorId;
      $instance->projectId = $projectId;
      $instance->milestonename = $milestonename;
      $instance->datedue = $datedue;
      return $instance;
    }

    public static function ForRead($id, $datecreated, $creatorId, $projectId, $milestonename) {
      $instance = new self();
      $instance->id = $id;
      $instance->creatorId = $creatorId;
      $instance->projectId = $projectId;
      $instance->milestonename = $milestonename;
      $instance->datedue = $datedue;
      return $instance;
    }

    // creating
    public function save() {
      $conn = new Connection();
      $conn->open();
      $result;
      $sql;
      if($this->id == -1) {
        $sql = "insert into milestones(datecreated, creatorid, projectid, milestonename, datedue) values(NOW(), $this->creatorId, $this->projectId, '$this->milestonename', CAST('$this->datedue' as datetime));";
      } else {
        $sql = "update milestones set creatorid = $this->creatorId, projectid = $this->projectId, milestonename = '$this->milestonename', datedue = CAST('$this->datedue' as datetime) where id = $this->id;";
      }

      $result = $conn->query($sql);
      if($result && $this->id == -1) $this->id = $conn->connection->insert_id;
      $conn->close();
      return $result;
    }

    public function findAll($options) {
      $conn = new Connection();
      
      $sql = 'SELECT * FROM milestones';

      foreach($options as $key => $value) {
        if(property_exists('Milestone', $key))
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
        array_push($returnedArr, Milestone::ForRead($row["id"], $row["datecreated"], $row["creatorid"], $row["projectid"], $row["milestonename"], $row["datedue"]));
      }

      $conn->close();

      return $returnedArr;
    }

    public function findById($id) {
      $returnedMilestone;
      $conn = new Connection();
      $conn->open();
      $sql = "SELECT * FROM milestones WHERE id = $id;";
      $result = $conn->query($sql);

      if(mysqli_num_rows($result) > 1) {
        $returnedMilestone = new Milestone();
      } else {
        $row = mysqli_fetch_assoc($result);
        $returnedMilestone = Milestone::ForRead($row["id"], $row["datecreated"], $row["creatorid"], $row["projectid"], $row["milestonename"], $row["datedue"]);
      }
      $conn->close();
      return $returnedMilestone;
    }

    // deleting
    public static function deleteById($id){
      $conn = new Connection();
      $conn->open();

      $sql = "DELETE FROM milestones WHERE id = $id;";

      $result = $conn->query($sql);
      $conn->close();
      return $result;
    }
  }
?>
