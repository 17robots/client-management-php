<?php  
  include_once('../model/Client.php');

  function getClients($data) {
    $resultArray = Client::findAll($data->options);
    $jsonString = json_encode($resultArray);
    echo $jsonString;
  }

  function getClient($data) {
    $returnedClient = json_encode(Client::findById($data->id));
    echo $returnedClient;
  }

  function addClient($data) {
    $jsonString;
    $newClient = Client::ForInsert($data->creatorid, $data->clientname, $data->clientaddress, $data->clientphone, $data->clientemail);
    if($newClient->save()) {
      $jsonString = json_encode($newClient);
    } else {
      $errorObj["error"] = "Unable to insert into database";
      $jsonString = json_encode($errorObj);
    }
    echo $jsonString;
  }

  function updateClient($data) {
    $clientToEdit = Client::findById($data->id);
    $jsonString;
    if($clientToEdit->id == -1) { // we couldnt find the client
      $errorObj["error"] = "Unable to Find Record";
      $jsonString = json_encode($errorObj);
    } else {
      $clientToEdit->clientname = $data->clientname;
      $clientToEdit->clientaddress = $data->clientaddress;
      $clientToEdit->clientphone = $data->clientphone;
      $clientToEdit->clientemail = $data->clientemail;
      if($clientToEdit->save()) {
        $jsonString = json_encode($clientToEdit);
      } else {
        $errorObj["error"] = "Unable to Update Database";
        $jsonString = json_encode($errorObj);
      }
    }
    echo $jsonString;
  }

  function deleteClient($data) {
    $jsonString;
    if(Client::deleteById($data->id)) {
      $successObj["success"] = "successfully deleted";
      $jsonString = json_encode($successObj);
    } else {
      $successObj["success"] = "successfully deleted";
      $jsonString = json_encode($successObj);
    }
    echo $jsonString;
  }
?>