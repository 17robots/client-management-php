<?php  
  include_once('../model/Client.php');

  public function getClients($userId) {
    $resultArray = json_encode(Client::findAll({"creatorid" => $userId}));
    echo $resultArray;
  }

  public function getClient($clientId) {
    $returnedClient = json_encode(Client::findById($clientId));
    echo $returnedClient;
  }

  public function addClient($clientData) {
    $newClient = Client::ForInsert($clientData[0], $clientData[1], $clientData[2], $clientData[3], $clientData[4]);
    if($newClient->save()) {
      $jsonString = json_encode($newClient);
    } else {
      $jsonString = json_encode({"error" => "Unable To Insert Into Database"});
    }
    echo $jsonString;
  }

  public function updateClient($clientId, $newclientData) {
    $clientToEdit = Client::findById($clientId);
    $jsonString;
    if($clientToEdit->id == -1) { // we couldnt find the client
      $jsonString = json_encode("error" => "Unable To Find Record");
    } else {
      if($clientToEdit->save()) {
        $jsonString = json_encode($clientToEdit);
      } else {
        $jsonString = json_encode({"error" => "Unable To Update Database"});
      }
    }
    echo $jsonString;
  }

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