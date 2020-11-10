<?php
  // "resolver" that controls what we can do with the projects
  
  // here we design the api portion that the user interacts with when they send the request over to the php file
  include_once('../model/Client.php');

  // for this function, we require a user id in order to get the books
  public function getClients($userId) {
     echo json_encode(Client->findAll({"creator" => $userId}));
  }

  // for this one we can use this to get data for one project (useful for modals)
  public function getClient($clientId) {
    echo json_encode(Client->findById($clientId));
  }

  // we need the project data that will be validated on the client side so everything we get here should be valid
  public function addClient($clientData) {
    $newClient = new Client($clientData[0], $clientData[1], $clientData[2], $clientData[3], $clientData[4], $clientData[5]);
    if($newClient->save()) {
      $jsonString = json_encode($newClient);
        if($jsonString != false)
          return json_encode($newClient);
        else
          return json_encode({"error" => "failed to save"});
    } else {
      return json_encode({"error" => "Unable To Insert Into Database"});
    }
  }

  // here we need the data for the project and then we need the new data that we are going to update the record with (this will include all project data including the data we arent changing so we can copy it linearly)
  public function updateClient($clientId, $newclientData) {
    
  }

  // this needs the id and then we can delete it
  public function deleteClient($clientId) {

  }
?>