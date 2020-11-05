<?php
  // generic template that all models need
  public abstract class Model {

    // creating
    public abstract function findAll($options);
    public abstract function findById($id);
    public abstract function save();
    
    // reading
    public static abstract function create($options);
    public static abstract function insertMany($options);

    // updating
    public static abstract function updateById($id, $newOptions);
    public static abstract function updateMany($searchOptions, $newOptions);

    // deleting
    public static abstract function deleteById($id);
    public static abstract function deleteMany($options);
  }
?>