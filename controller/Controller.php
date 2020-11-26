<?php
  include_once("ClientController.php");
  include_once("ContactController.php");
  include_once("MilestoneController.php");
  include_once("PhoneController.php");
  include_once("ProjectController.php");
  include_once("TaskController.php");
  include_once("UserController.php");

  // set headers
  header("Access-Control-Allow-Origin: *");
  header("Access-Control-Allow-Headers: access");
  header("Access-Control-Allow-Methods: POST");
  header("Content-Type: application/json; charset=UTF-8");
  header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

  $textData = file_get_contents("php://input");
  $data = json_decode($textData);
  $errorObj;

  switch($data->action) {
    case "getProjects":
      getProjects($data);
    break;
    case "getProject":
      getProject($data);
    break;
    case "addProject":
      addProject($data);
    break;
    case "updateProject":
      updateProject($data);
    break;
    case "deleteProject":
      deleteProject($data);
    break;
    case "getClients":     
      getClients($data);
    break;
    case "getClient":
      getClient($data);
    break;
    case "addClient":
      addClient($data);
    break;
    case "updateClient": 
      updateClient($data);
    break;
    case "deleteClient":
      deleteClient($data);
    break;
    case "getContacts":
      getContacts($data);
    break;
    case "getContact":
      getContact($data);
    break;
    case "addContact":
      addContact($data);
    break;
    case "updateContact":
      updateContact($data);
    break;
    case "deleteContact":
      deleteContact($data);
    break;
    case "getMilestones":     
      getMilestones($data);
    break;
    case "getMilestone":
      getMilestone($data);
    break;
    case "addMilestone":     
      addMilestone($data);
    break;
    case "updateMilestone":     
      updateMilestone($data);
    break;
    case "deleteMilestone":  
      deleteMilestone($data);
    break;
    case "getPhones":     
      getPhones($data);
    break;
    case "getPhone":
      getPhone($data);
    break;
    case "addPhone":
      addPhone($data);
    break;
    case "updatePhone":
      updatePhone($data);
    break;
    case "deletePhone":     
      deletePhone($data);
    break;
    case "getTasks":
      getTasks($data);
    break;
    case "getTask":
      getTask($data);
    break;
    case "addTask":
      addTask($data);
    break;
    case "updateTask":     
      updateTask($data);
    break;
    case "deleteTask":     
      deleteTask($data);
    break;
    case "login":
      login($data);
    break;
    case "addUser":
      addUser($data);
    break;
    case "updateUser":
      updateUser($data);
    break;
    case "deleteUser":
      deleteUser($data);
    break;
    default: 
      $errorObj["error"] = "Action Needed";
      $jsonString = json_encode($errorObj);
      echo $jsonString;
    break;
  }
?>