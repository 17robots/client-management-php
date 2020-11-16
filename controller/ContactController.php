<?php
  include_once('../model/Contact.php');
  public static function getContacts($clientId) {
    $resultArray = json_encode(Contact::findAll({"creatorid" => $userId}));
    echo $resultArray;
  }

  // for this one we can use this to get data for one project (useful for modals)
  public static function getContact($contactId) {
    $returnedContact = json_encode(Contact::findById($clientId));
    echo $returnedContact;
  }

  // we need the project data that will be validated on the client side so everything we get here should be valid
  public static function addClient($contactData) {
    $newContact = Contact::ForInsert($contactData[0], $contactData[1], $contactData[2], $contactData[3], $contactData[4], $contactData[5]);
    if($newContact->save()) {
      $jsonString = json_encode($newContact);
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
  public static function updateContact($contactId, $newContactData) {
    $contactToEdit = Contact::findById($clientId);
    $jsonString;
    if($contactToEdit->id == -1) { // we couldnt find the client
      $jsonString = json_encode("error" => "Unable To Find Record");
    } else {
      if($contactToEdit->save()) {
        $jsonString = json_encode($contactToEdit);
      } else {
        $jsonString = json_encode({"error" => "Unable To Update Database"});
      }
    }
    echo $jsonString;
  }

  // this needs the id and then we can delete it
  public static function deleteContact($contactId) {
    $jsonString;
    if(Client::deleteById($clientId)) {
      $jsonString = json_encode("success" => "Successfully deleted");
    } else {
      $jsonString = json_encode("error" => "Error Deleting");
    }
    echo $jsonString;
  }
?>