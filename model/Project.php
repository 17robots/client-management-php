<?php
  include_once('../DB/Connection.php');

  class Project {
    // members
    public $id;
    public $datecreated;
    public $creatorId;
    public $clientId;
    public $name;
    public $description;
    public $estimatedHours;
    public $totalInvoiced;
    public $rate;
    public $paymentType; // fixed or hourly
    public $dueDate;
    public $closed;

    public function __construct() {
      $this->id = -1;
      $this->datecreated = "";
      $this->creatorId = -1;
      $this->clientId = -1;
      $this->name = "";
      $this->description = "";
      $this->estimatedHours = 0;
      $this->totalInvoiced = 0;
      $this->rate = 0;
      $this->paymentType = "";
      $this->dueDate = "";
      $this->closed = false;
    }

    public static function ForInsert($creatorId, $clientId, $name, $description, $estimatedHours, $rate, $paymentType, $dueDate) {
      $instance = new self();
      $instance->creatorId = $creatorId;
      $instance->clientId = $clientId;
      $instance->name = $name;
      $instance->description = $description;
      $instance->estimatedHours = $estimatedHours;
      $instance->rate = $rate;
      $instance->paymentType = $paymentType;
      $instance->dueDate = $dueDate;
      return $instance;
    }

    public static function ForRead($id, $datecreated, $creatorId, $clientId, $name, $description, $estimatedHours, $totalInvoiced, $rate, $paymentType, $dueDate, $closed) {
      $instance = new self();
      $instance->id = $id;
      $instance->datecreated = $datecreated;
      $instance->creatorId = $creatorId;
      $instance->clientId = $clientId;
      $instance->name = $name;
      $instance->description = $description;
      $instance->estimatedHours = $estimatedHours;
      $instance->totalInvoiced = $totalInvoiced;
      $instance->rate = $rate;
      $instance->paymentType = $paymentType;
      $instance->dueDate = $dueDate;
      $instance->closed = $closed;
      return $instance;
    }

    // creating
    public function save() {
      $conn = new Connection();
      
      $result;
      $sql;
      if($this->id == -1) {
        $dateTime = strtotime($this->dueDate);
        if(!$dateTime) $dateTime = "";
        $sql = "insert into projects(datecreated, creatorid, clientid, projectname, projectdescription, estimatedhours, rate, paymenttype, totalinvoiced, duedate, closed) values(NOW(), $this->creatorId, $this->clientId, '$this->name', '$this->description', $this->estimatedHours, $this->rate, '$this->paymentType', 0, CAST('$dateTime' as datetime), false);";
      } else {
        $sql = "update projects set creatorid = $this->creatorId, clientid = $this->clientId, projectname = '$this->name', projectdescription = '$this->description', estimatedhours = $this->estimatedHours, rate = $this->rate, paymenttype = '$this->paymentType', totalinvoiced = $this->totalInvoiced, duedate = CAST('$this->dueDate' as datetime), closed = $this->closed where id = $this->id;";
      }
      $result = $conn->query($sql);
      if($result && $this->id == -1) $this->id = $conn->connection->insert_id;
      $conn->close();
      return $result;
    }
    
    // reading
    public static function findAll($options) {
      $conn = new Connection();

      $sql = 'SELECT * FROM projects';

      if(count((array)$options) > 0) $sql .= " where ";

      foreach($options as $key => $value) {
        if(property_exists('Project', $key))
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
        array_push($returnedArr, Project::ForRead($row["id"], $row["datecreated"], $row["creatorid"], $row["clientid"], $row["projectname"], $row["projectdescription"], $row["estimatedhours"], $row["totalinvoiced"], $row["rate"], $row["paymenttype"], $row["duedate"], $row["closed"]));
      }

      $conn->close();

      return $returnedArr;
    }

    public static function findById($id) {
      $returnedProject;
      $conn = new Connection();
      
      $sql = "SELECT * FROM projects WHERE id = $id;";
      $result = $conn->query($sql);

      if(mysqli_num_rows($result) > 1 || mysqli_num_rows($result) == 0) {
        $returnedProject = new Client();
      } else if(mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $returnedProject = Project::ForRead($row["id"], $row["datecreated"], $row["creatorid"], $row["clientid"], $row["projectname"], $row["projectdescription"], $row["estimatedhours"], $row["totalinvoiced"], $row["rate"], $row["paymenttype"], $row["duedate"], $row["closed"]);
      }
      $conn->close();
      return $returnedProject;
    }

    // deleting
    public static function deleteById($id) {
      $conn = new Connection();
      
      $sql = "DELETE FROM projects WHERE id = $id;";

      $result = $conn->query($sql);
      $conn->close();
      return $result;
    }
  }
?>