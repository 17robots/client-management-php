<?php
  include_once('../model/Contact.php');
  
  function getContacts($data) {
    $resultArray = Contact::findAll($data->options);
    $jsonString = json_encode($resultArray);
    echo $jsonString;
  }

  // for this one we can use this to get data for one project (useful for modals)
  function getContact($data) {
    $returnedContact = json_encode(Contact::findById($data->id));
    echo $returnedContact;
  }

  // we need the project data that will be validated on the client side so everything we get here should be valid
  function addClient($data) {
    $newContact = Contact::ForInsert($data->creatorId, $data->projectId, $data->firstname, $data->lastname, $data->email, $data->maincontact);
    if($newContact->save()) {
      $jsonString = json_encode($newContact);
    } else {
      $errorObj["error"] = "Unable to insert into database";
      $jsonString = json_encode($errorObj);
    }
    echo $jsonString;
  }

  // here we need the data for the project and then we need the new data that we are going to update the record with (this will include all project data including the data we arent changing so we can copy it linearly)
  function updateContact($data) {
    $contactToEdit = Contact::findById($data->id);
    $jsonString;
    if($contactToEdit->id == -1) { // we couldnt find the client
      $errorObj["error"] = "Unable to Find Record";
      $jsonString = json_encode($errorObj);
    } else {
      $contactToEdit->projectId = $data->projectId;
      $contactToEdit->firstname = $data->firstname;
      $contactToEdit->lastname = $data->lastname;
      $contactToEdit->email = $data->email;
      $contactToEdit->maincontact = $data->maincontact;      
      if($contactToEdit->save()) {
        $jsonString = json_encode($contactToEdit);
      } else {
        $errorObj["error"] = "Unable to Update Database";
        $jsonString = json_encode($errorObj);
      }
    }
    echo $jsonString;
  }

  // this needs the id and then we can delete it
  function deleteContact($data) {
    $jsonString;
    if(Contact::deleteById($data->id)) {
      $successObj["success"] = "successfully deleted";
      $jsonString = json_encode($successObj);
    } else {
      $errorObj["error"] = "Unable to delete from database";
      $jsonString = json_encode($errorObj);
    }
    echo $jsonString;
  }
?>