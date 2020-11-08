<?php
  require "./Model.php";
  public class Attachment extends Model {
    // members
    public $id; // int
    public $fileName; // foreign int
    public $description; // string
    public $projectId; // foreign int
    public $location; // string 

    // creating
    public function findAll($options);
    public function findById($id);
    public function save();
    
    // reading
    public static function create($options);
    public static function insertMany($options);

    // updating
    public static function updateById($id, $newOptions);
    public static function updateMany($searchOptions, $newOptions);

    // deleting
    public static function deleteById($id);
    public static function deleteMany($options);
  }
?>