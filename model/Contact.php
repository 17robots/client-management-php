<?php
  require "./Model.php";
  public class Contact extends Model {

    // members
    public $id;
    public $createdAt; // date
    public $creatorId;
    public $projectId;
    public $firstname;
    public $lastname;
    public $email;
    
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