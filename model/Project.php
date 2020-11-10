<?php
  require "./Model.php";
  public class Project extends Model {
    // members
    public $id;
    public $createdAt;
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

    // creating
    public function save();
    
    // reading
    public function findAll($options);
    public function findById($id);

    // updating
    public static function updateById($id, $newOptions);

    // deleting
    public static function deleteById($id);
  }
?>