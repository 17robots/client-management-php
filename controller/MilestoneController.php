<?php
  // "resolver" that controls what we can do with the projects
  
  // here we design the api portion that the user interacts with when they send the request over to the php file

  // for this function, we require a user id in order to get the books
  public static function getMilestones($projectId) {
    $resultArray = json_encode(Milestone::findAll({"projectid" => $projectId}));
    echo $resultArray;

  }

  // for this one we can use this to get data for one project (useful for modals)
  public static function getMilestone($milestoneId) {
    $returnedMilestone = json_encode(Milestone::findById($clientId));
 echo $returnedContact;

  }

  // we need the project data that will be validated on the client side so everything we get here should be valid
  public static function addMilestone($milestoneData) {
    $newMilestone = Milestone::ForInsert($milestoneData[0], $milestoneData[1], $milestoneData[2], $milestoneData[3], $milestoneData[4], $milestoneData[5]);
    if($newMilestone->save()) {
      $jsonString = json_encode($newMilestone);
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
  public static function updateMilestone($milestoneId, $newMilestoneData) {
    $milestoneToEdit = Contact::findById($clientId);
    $jsonString;
    if($milestoneToEdit->id == -1) { // we couldnt find the milestone
      $jsonString = json_encode("error" => "Unable To Find Record");
    } else {
      if($milestoneToEdit->save()) {
        $jsonString = json_encode($milestoneToEdit);
      } else {
        $jsonString = json_encode({"error" => "Unable To Update Database"});
      }
    }
    echo $jsonString;
  }
  }

  // this needs the id and then we can delete it
  public static function deleteMilestone($milestoneId) {
    $jsonString;
    if(Milestone::deleteById($clientId)) {
      $jsonString = json_encode("success" => "Successfully deleted");
    } else {
      $jsonString = json_encode("error" => "Error Deleting");
    }
    echo $jsonString;
  }
?>
