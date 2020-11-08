<?php
  require "./Model.php";
  public class Client extends Model {
    // members

    // creating
    public function findAll($options);
    public function findById($id);
    
    // reading
    public static function create($options);
    public static function insertMany($options);
    public function save();

    // updating
    public static function updateById($id, $newOptions);
    public static function updateMany($searchOptions, $newOptions);

    // deleting
    public static function deleteById($id);
    public static function deleteMany($options);
  }
?>