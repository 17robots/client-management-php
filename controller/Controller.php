<?php
  include_once("ClientController.php");
  include_once("ContactController.php");
  include_once("InvoiceController.php");
  include_once("MilestoneController.php");
  include_once("NoteController.php");
  include_once("PhoneController.php");
  include_once("ProjectController.php");
  include_once("TaskController.php");
  include_once("UserController.php");

  include_once("ProjectController.php");

  // consolidating all of the items into 1 file so that all we need to do is sent a request to 1 file and itll control and take care of everything
  // in our case, since this is just getting a request, we wont have to worry about displaying anything and we can just send a request back
  // so we dont need a controller class unless we wanted to be fancy with how we handled the responses
  // whats cool is we can send data back with the echo function and we can send json data back as well so we can even read things from a settings file 
  // for this example ill only be focusing on the options above and I can create a second handler specifically for settings and use to load later
  // the last thing here is the fact that we need to also send the type of action the form is tied to which we can do with a hidden form element

  header("Access-Control-Allow-Origin: *");
  switch($_POST['action']) {
    case "getProjects":
      getProjects(1);
    break;
    case "getProject":   
      getProject(1);
    break;
    case "addProject":
      addProject(1);
    break;
    case "updateProject": 
      updateProject(1,2);
    break;
    case "deleteProject":     
      deleteProject(1);
    break;
    default: 
      echo "Action Needs Specified";
    break;
  }
?>