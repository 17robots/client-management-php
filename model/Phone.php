<?php
  require "./Model.php";
  public class Phone extends Model {
    // members
    public $id;
    public $createdAt;
    public $creatorId;
    public $contactId;
    public $type;
    public $number;

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