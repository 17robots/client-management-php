<?php
  require "./Model.php";
  public class Task extends Model {
    // members
    public $id;
    public $createdAt;
    public $creatorId;
    public $projectId;
    public $milestoneId;
    public $title;
    public $description;
    public $completed;

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