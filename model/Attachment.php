<?php
  require "./Model.php";
  public class Attachment extends Model {
    // members
    public $id;
    public $dateCreated;
    public $creatorId;
    public $projectId; // foreign int
    public $fileName;
    public $description; // string
    public $status; // string 

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