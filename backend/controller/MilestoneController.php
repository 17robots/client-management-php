<?php
  include_once('../model/Milestone.php');

  function getMilestones($data) {
    $resultArray = Milestone::findAll($data->options);
    $jsonString = json_encode($resultArray);
    echo $jsonString;
  }

  function getMilestone($data) {
    $returnedMilestone = json_encode(Milestone::findById($data->id));
    echo $returnedMilestone;
  }

  function addMilestone($data) {
    $newMilestone = Milestone::ForInsert($data->creatorid, $data->projectid, $data->milestonename, $data->duedate);
    if($newMilestone->save()) {
      $jsonString = json_encode($newMilestone);
    } else {
      $errorObj["error"] = "Unable to insert into database";
      $jsonString = json_encode($errorObj);
    }
    echo $jsonString;
  }

  function updateMilestone($data) {
    $milestoneToEdit = Milestone::findById($data->id);
    $jsonString;
    if($milestoneToEdit->id == -1) { // we couldnt find the milestone
      $errorObj["error"] = "Unable to Find Record";
      $jsonString = json_encode($errorObj);
    } else {
      $milestoneToEdit->projectId = $data->projectid;
      $milestoneToEdit->milestonename = $data->milestonename;
      $milestoneToEdit->datedue = $data->duedate;
      if($milestoneToEdit->save()) {
        $jsonString = json_encode($milestoneToEdit);
      } else {
        $errorObj["error"] = "Unable to Update Database";
        $jsonString = json_encode($errorObj);
      }
    }
    echo $jsonString;
  }

  function deleteMilestone($data) {
    $jsonString;
    if(Milestone::deleteById($data->id)) {
      $successObj["success"] = "successfully deleted";
      $jsonString = json_encode($successObj);
    } else {
      $errorObj["error"] = "Unable to delete from database";
      $jsonString = json_encode($errorObj);
    }
    echo $jsonString;
  }
?>