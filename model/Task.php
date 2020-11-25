<?php
  class Task {
    public $id;
    public $creatorId;
    public $datecreated;
    public $projectId;
    public $milestoneId;
    public $title;
    public $description;
    public $completed;

    public function __construct() {
      $this->id = -1;
      $this->datecreated = "";
      $this->creatorId = -1;
      $this->projectId = -1;
      $this->milestoneId = -1;
      $this->title = "";
      $this->description = "";
      $this->completed = "";
    }

    public static function ForInsert($creatorId, $projectId, $milestoneId, $title, $description) {
      $instance = new self();
      $instance->creatorId = $creatorId;
      $instance->projectId = $projectId;
      $instance->milestoneId = $milestoneId;
      $instance->title = $title;
      $instance->description = $description;
      $instance;
    }

    public static function ForRead($id, $datecreated, $creatorId, $projectId, $milestoneId, $title, $description, $completed) {
      $instance = new self();
      $instance->id = $id;
      $instance->datecreated = $datecreated;
      $instance->creatorId = $creatorId;
      $instance->projectId = $projectId;
      $instance->milestoneId = $milestoneId;
      $instance->title = $title;
      $instance->description = $description;
      $instance->completed = $completed;
      return $instance;
    }

    // creating
    public function save() {
      $conn = new Connection();
      
      $result;
      $sql;
      if($this->id == -1) { // not in db
        $sql = "insert into tasks(datecreated, creatorid, projectid, milestoneid, title, description, completed) values(NOW(), $this->creatorId, $this->projectId, $this->milestoneId, '$this->title', '$this->description', false);";
      }
      else {
        $sql = "update tasks set creatorid = $this->creatorid, projectid = $this->projectId, milestoneid = $this->milestoneId, title = '$this->title', description = '$this->description', completed = '$this->completed' where id = $this->id;";
      }

      $result = $conn->query($sql);
      if($result && $this->id == -1) $this->id = $conn->connection->insert_id;
      $conn->close();
      return $result;
    }
    
    // reading
    public function findAll($options) {
      $conn = new Connection();

      $sql = 'SELECT * FROM tasks';

      foreach($options as $key => $value) {
        if(property_exists('Task', $key))
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
        array_push($returnedArr, Task::ForRead($row["id"], $row["datecreated"], $row["creatorid"], $row["projectid"], $row["milestoneid"], $row["name"], $row["description"], $row["completed"]));
      }
      $conn->close();

      return $returnedArr;
    }

    public function findById($id) {
      $returnedTask;
      $conn = new Connection();
      
      $sql = "SELECT * FROM clients WHERE id = $id;";
      $result = $conn->query($sql);

      if(mysqli_num_rows($result) > 1) {
        $returnedTask = new Client();
      } else if(mysqli_num_rows($result) == 1) {
        $row = $result->fetch_assoc();
        $returnedTask = Task::ForRead($row["id"], $row["datecreated"], $row["creatorid"], $row["projectid"], $row["milestoneid"], $row["name"], $row["description"], $row["completed"]);
      }
      $conn->close();
      return $returnedTask;
    }

    // deleting
    public static function deleteById($id) {
      $conn = new Connection();
      
      $sql = "DELETE FROM tasks WHERE id = $id;";

      $result = $conn->query($sql);
      $conn->close();
      return $result;
    }
  }
?>