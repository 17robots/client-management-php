<?php
  // "resolver" that controls what we can do with the projects
  
  // here we design the api portion that the user interacts with when they send the request over to the php file

  // for this function, we require a user id in order to get the books
  public static function getPhones($contactId) {
    $returnedPhone = json_encode(Phone::findAll({"creatorid" => $userId}));
    echo $returnedPhone;
  }

  // for this one we can use this to get data for one project (useful for modals)
  public static function getPhone($phoneId) {
    $returnedPhone = json_encode(Phone::findById($clientId));
    echo $returnedPhone;
  }

  // we need the project data that will be validated on the client side so everything we get here should be valid
  public static function addPhone($phoneData) {
    $newPhone = Phone::ForInsert($phoneData[0], $phoneData[1], $phoneData[2], $phoneData[3], $phoneData[4], $phoneData[5]);
    if($newPhone->save()) {
      $jsonString = json_encode($newPhone);
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
  public static function updatePhone($phoneId, $newPhoneData) {
    $phoneToEdit = Phone::findById($clientId);
    $jsonString;
    if($phoneToEdit->id == -1) { // we couldnt find the client
      $jsonString = json_encode("error" => "Unable To Find Record");
    } else {
      if($phoneToEdit->save()) {
        $jsonString = json_encode($phoneToEdit);
      } else {
        $jsonString = json_encode({"error" => "Unable To Update Database"});
      }
    }
    echo $jsonString;
  }

  // this needs the id and then we can delete it
  public static function deleteProject($phoneId) {
    $jsonString;
    if(Phone::deleteById($clientId)) {
      $jsonString = json_encode("success" => "Successfully deleted");
    } else {
      $jsonString = json_encode("error" => "Error Deleting");
    }
    echo $jsonString;

  }
?>
