<?php
  require "./Model.php";
  public class Event extends Model {
    // members
    public $id;
    public $createdAt;
    public $creatorId;
    public $taskId;
    public $summary;
    public $notes;
    public $finishedAt;
    public $overrideHours;
    
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