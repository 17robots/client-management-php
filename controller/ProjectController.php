<?php
  include_once("../model/Project.php");

  function getProjects($data) {
    $resultArray = Project::findAll($data->options);
    $jsonString = json_encode($resultArray);
    echo $jsonString;
  }

  function getProject($data) {
    $returnedClient = json_encode(Project::findById($data->id));
    echo $returnedClient;
  }

  function addProject($data) {
    $jsonString;
    $newProject = Project::ForInsert($data->creatorid, $data->clientid, $data->name, $data->description, $data->estimatedhours, $data->rate, $data->duedate, $data->closed);
    if($newProject->save()) {
      $jsonString = json_encode($newProject);
    } else {
      $errorObj["error"] = "Unable to insert into database";
      $jsonString = json_encode($errorObj);
    }
    echo $jsonString;
  }

  function updateProject($data) {
    $projectToEdit = Project::findById($data->id);
    $jsonString;
    f($projectToEdit->id == -1) { // we couldnt find the client
      $errorObj["error"] = "Unable to Find Record";
      $jsonString = json_encode($errorObj);
    } else {
      $projectToEdit->clientId = $data->clientid;
      $projectToEdit->name = $data->name;
      $projectToEdit->description = $data->description;
      $project->estimatedHours = $data->estimatedhours;
      $projectToEdit->rate = $data->rate;
      $projectToEdit->paymentType = $data->paymenttype;
      $projectToEdit->totalInvoiced = $data->totalInvoiced;
      $projectToEdit->dueDate = $data->dueDate;
      $projectToEdit->closed = $data->closed;
      if($projectToEdit->save()) {
        $jsonString = json_encode($projectToEdit);
      } else {
        $errorObj["error"] = "Unable to Update Database";
        $jsonString = json_encode($errorObj);
      }
    }
    echo $jsonString;
  }

  function deleteProject($data) {
    $jsonString;
    if(Project::deleteById($data->id)) {
      $successObj["success"] = "successfully deleted";
      $jsonString = json_encode($successObj);
    } else {
      $errorObj["error"] = "Unable to delete from database";
      $jsonString = json_encode($errorObj);
    }
    echo $jsonString;
  }
?>