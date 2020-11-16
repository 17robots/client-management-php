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

  // set headers
  header("Access-Control-Allow-Origin: *");
  header("Access-Control-Allow-Headers: access");
  header("Access-Control-Allow-Methods: POST");
  header("Content-Type: application/json; charset=UTF-8");
  header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

  $data = json_decode(file_get_contents("php://input"));

  switch($data->action) {
    case "getProjects":
      getProjects($data->clientid);
    break;
    case "getProject":
      getProject($data->projectid);
    break;
    case "addProject":
      addProject();
    break;
    case "updateProject":
      updateProject();
    break;
    case "deleteProject":
      deleteProject($data->projectid);
    break;
    case "getClients":     
      getClients($data->userid);
    break;
    case "getClient":
      getClient($data->clientid);
    break;
    case "addClient":
      $clientData[0] = $data->creatorid;
      $clientData[1] = $data->clientName;
      $clientData[2] = $data->clientAddress;
      $clientData[3] = $data->clientPhone;
      $clientData[4] = $data->clientEmail;
      addClient($clientData);
    break;
    case "updateClient": 
      $clientData[0] = $data->creatorid;
      $clientData[1] = $data->clientName;
      $clientData[2] = $data->clientAddress;
      $clientData[3] = $data->clientPhone;
      $clientData[4] = $data->clientEmail;
      updateClient($data->updateid, $clientData);
    break;
    case "deleteClient":
      deleteClient($data->clientid);
    break;
    case "getContacts":
      getContacts($data->clientid);
    break;
    case "getContact":
      getContact($data->contactid);
    break;
    case "addContact":
      $contactData[0] = $data->creatorId;
      $contactData[1] = $data->projectId;
      $contactData[2] = $data->firstname;
      $contactData[3] = $data->lastname;
      $contactData[4] = $data->email;
      $contactData[5] = $data->mainContact;
      addContact($contactData);
    break;
    case "updateContact":
      $contactData[0] = $data->creatorId;
      $contactData[1] = $data->projectId;
      $contactData[2] = $data->firstname;
      $contactData[3] = $data->lastname;
      $contactData[4] = $data->email;
      $contactData[5] = $data->mainContact;
      updateContact($data->updateid,$contactData);
    break;
    case "deleteContact":
      deleteContact($data->contactid);
    break;
    case "getInvoices":     
      getInvoices($data->projectid);
    break;
    case "getInvoice":
      getInvoice($data->invoiceid);
    break;
    case "addInvoice":     
      addInvoice(1);
    break;
    case "updateInvoice":     
      updateInvoice(1,1);
    break;
    case "deleteInvoice":  
      deleteInvoice($data->invoiceid);
    break;
    case "getMilestones":     
      getMilestones($data->projectid);
    break;
    case "getMilestone":
      getMilestone($data->milestoneid);
    break;
    case "addMilestone":     
      addMilestone(1);
    break;
    case "updateMilestone":     
      updateMilestone(1,1);
    break;
    case "deleteMilestone":  
      deleteMilestone($data->milestoneid);
    break;
    case "getPhones":     
      getPhones($data->contactid);
    break;
    case "getPhone":
      getPhone($data->phoneid);
    break;
    case "addPhone":
      addPhone(1);
    break;
    case "updatePhone":
      updatePhone(1,1);
    break;
    case "deletePhone":     
      deletePhone($data->phoneid);
    break;
    case "getTasks":
      getTasks($data->projectid);
    break;
    case "getTask":
      getTask($data->taskid);
    break;
    case "addTask":
      addTask(1);
    break;
    case "updateTask":     
      updateTask(1,1);
    break;
    case "deleteTask":     
      deleteTask($data->taskid);
    break;
    case "login":
      login($data->userInfo,$data->password);
    break;
    case "addUser":
      $userData[0] = $data->firstName;
      $userData[1] = $data->lastName;
      $userData[2] = $data->userName
      $userData[3] = $data->email;
      $userData[4] = $data->password;
      addUser($userData);
    break;
    case "updateUser":
      updateUser(1,1);
    break;
    case "deleteUser":
      deleteUser($data->userid);
    break;
    default: 
      $msg['message'] = 'Action needs specified';
      echo $msg;
    break;
    
  }
?>