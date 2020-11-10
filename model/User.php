<?php
  require "./Model.php";
  public class User extends Model {
    // members
    public $id;
    public $createdAt;
    public $firstname;
    public $lastname;
    public $username;
    public $email;
    public $password;
    
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