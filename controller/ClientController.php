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
    $newClient = Client::ForInsert($data->creatorid, $data->clientName;, $data->clientAddress, $data->clientPhone, $data->clientEmail);
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
      $clientToEdit->clientName = $data->clientName;
      $clientToEdit->clientAddress = $data->clientAddress;
      $clientToEdit->clientPhone = $data->clientPhone;
      $clientToEdit->clientEmail = $data->clientEmail;
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
      $errorObj["error"] = "Unable to delete from database";
      $jsonString = json_encode($errorObj);
    }
    echo $jsonString;
  }
?>