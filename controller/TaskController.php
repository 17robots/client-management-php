<?php
  // "resolver" that controls what we can do with the projects
  
  // here we design the api portion that the user interacts with when they send the request over to the php file

  public static function getTasks($filterData) {

  }

  // for this one we can use this to get data for one project (useful for modals)
  public static function getTask($taskId) {

  }

  // we need the project data that will be validated on the client side so everything we get here should be valid
  public static function addTask($taskData) {

  }

  // here we need the data for the project and then we need the new data that we are going to update the record with (this will include all project data including the data we arent changing so we can copy it linearly)
  public static function updateTask($projectId, $newTaskData) {

  }

  // this needs the id and then we can delete it
  public static function deleteTask($taskId) {

  }
?>