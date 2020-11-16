<?php
  // "resolver" that controls what we can do with the projects
  
  // here we design the api portion that the user interacts with when they send the request over to the php file
  include_once('../model/Client.php');

  // for this function, we require a user id in order to get the books
  public function getClients($userId) {
    $resultArray = json_encode(Client::findAll({"creatorid" => $userId}));
    echo $resultArray;
  }

  // for this one we can use this to get data for one project (useful for modals)
  public function getClient($clientId) {
    $returnedClient = json_encode(Client::findById($clientId));
    echo $returnedClient;
  }

  // we need the project data that will be validated on the client side so everything we get here should be valid
  public function addClient($clientData) {
    $newClient = Client::ForInsert($clientData[0], $clientData[1], $clientData[2], $clientData[3], $clientData[4]);
    if($newClient->save()) {
      $jsonString = json_encode($newClient);
        if($jsonString != false)
          echo $jsonString;
        else
          $jsonString = json_encode({"error" => "Failed to save"});
    } else {
      $jsonString = json_encode({"error" => "Unable To Insert Into Database"});
    }
    echo $jsonString;
  }

  // here we need the data for the project and then we need the new data that we are going to update the record with (this will include all project data including the data we arent changing so we can copy it linearly)
  public function updateClient($clientId, $newclientData) {
    $clientToEdit = Client::findById($clientId);
    $jsonString;
    if($clientToEdit->id == -1) { // we couldnt find the client
      $jsonString = json_encode("error" => "Unable To Find Record");
    } else {
      if($clientToEdit->save()) {
        $jsonString = json_encode($clientToEdit);
      }
    }
    echo $jsonString;
  }

  // this needs the id and then we can delete it
  public function deleteClient($clientId) {
    $jsonString;
    if(Client::deleteById($clientId)) {
      $jsonString = json_encode("success" => "Successfully deleted");
    } else {
      $jsonString = json_encode("error" => "Error Deleting");
    }
    echo $jsonString;
  }
?>