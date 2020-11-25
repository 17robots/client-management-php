<?php
  include_once('../model/Phone.php');

  public static function getPhones($data) {
    $resultArray = Phone::findAll($data->options);
    $jsonString = json_encode($resultArray);
    echo $jsonString;
  }

  public static function getPhone($data) {
    $returnedPhone = json_encode(Phone::findById($data->id));
    echo $returnedPhone;
  }

  public static function addPhone($data) {
    $newPhone = Phone::ForInsert($data->creatorid, $data->contactid, $data->type, $data->number);
    if($newPhone->save()) {
      $jsonString = json_encode($newPhone);
    } else {
      $errorObj["error"] = "Unable to insert into database";
      $jsonString = json_encode($errorObj);
    }
    echo $jsonString;
  }

  public static function updatePhone($data) {
    $phoneToEdit = Phone::findById($data->id);
    $jsonString;
    if($phoneToEdit->id == -1) { // we couldnt find the client
      $errorObj["error"] = "Unable to Find Record";
      $jsonString = json_encode($errorObj);
    } else {
      $phoneToEdit->contactId = $data->contactid;
      $phoneToEdit->type = $data->type;
      $phoneToEdit->number = $data->number;
      if($phoneToEdit->save()) {
        $jsonString = json_encode($data);
      } else {
        $errorObj["error"] = "Unable to Update Database";
        $jsonString = json_encode($errorObj);
      }
    }
    echo $jsonString;
  }

  public static function deleteProject($data) {
    $jsonString;
    if(Phone::deleteById($clientId)) {
      $successObj["success"] = "successfully deleted";
      $jsonString = json_encode($successObj);
    } else {
      $errorObj["error"] = "Unable to delete from database";
      $jsonString = json_encode($errorObj);
    }
    echo $jsonString;
  }
?>