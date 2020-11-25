<?php
  include_once('../model/Task.php');

  public static function getTasks($data) {
    $resultArray = Task::findAll($data->options);
    $jsonString = json_encode($resultArray);
    echo $jsonString;
  }

  public static function getTask($data) {
    $returnedTask = json_encode(Task::findById($data->id));
    echo $returnedTask;
  }

  public static function addTask($data) {
    $jsonString;
    $newTask = Task::ForInsert($data->creatorid, $data->projectid, $data->milestoneid, $data->title, $data->description);
    if($newTask->save()) {
      $jsonString = json_encode($newTask);
    } else {
      $errorObj["error"] = "Unable to insert into database";
      $jsonString = json_encode($errorObj);
    }
    echo $jsonString;
  }

  public static function updateTask($data) {
    $taskToEdit = Task::findById($data->id);
    $jsonString;
    if($taskToEdit->id == -1) { // we couldnt find the client
      $errorObj["error"] = "Unable to Find Record";
      $jsonString = json_encode($errorObj);
    } else {
      $taskToEdit->projectId = $data->projectid;
      $taskToEdit->milestoneId = $data->milestoneid;
      $taskToEdit->title = $data->title;
      $taskToEdit->description = $data->description;
      $taskToEdit->completed = $data->completed;
      if($taskToEdit->save()) {
        $jsonString = json_encode($taskToEdit);
      } else {
        $errorObj["error"] = "Unable to Update Database";
        $jsonString = json_encode($errorObj);
      }
    }
    echo $jsonString;
  }

  public static function deleteTask($data) {
    $jsonString;
    if(Task::deleteById($data->id)) {
      $successObj["success"] = "successfully deleted";
      $jsonString = json_encode($successObj);
    } else {
      $errorObj["error"] = "Unable to delete from database";
      $jsonString = json_encode($errorObj);
    }
    echo $jsonString;
  }
?>