<?php  
  include_once('../model/User.php');

  function login($data) {
    $jsonString;
    $resultArray = User::findAll($data->options);
    if(count($resultArray) == 1 && $resultArray[0]->id != -1) {
      $authData["userId"] = $resultArray[0]->id;
      $authData["token"] = 1; // figure out how to do token creation
      $authData["tokenExpiration"] = 3600; // 1 hour
      $authData["success"] = "successfully logged in";
      $jsonString = json_encode($authData);
    } else {
      $error["error"] = "Incorrect Username Or Password";
      $jsonString = json_encode($error);
    }
    echo $jsonString;
  }

  function addUser($data) {
    $user = array("username" => $data->username);
    $usersByUser = User::findAll($user);
    $user = array("email" => $data->email);
    $usersByEmail = User::findAll($user);
    if(count($usersByEmail) > 0 || count($usersByUser) > 0) {
      $errorObj["error"] = "Email Or Username Already In Use";
      $jsonString = json_encode($errorObj);
      echo $jsonString;
      return;
    }

    $newUser = User::ForInsert($data->firstname, $data->lastname, $data->username, $data->email, $data->password);
    if($newUser->save()) {
      $jsonString = json_encode($newUser);
    } else {
      $errorObj["error"] = "Unable to insert into database";
      $jsonString = json_encode($errorObj);
    }
    echo $jsonString;
  }

  function updateUser($data) {
    $user = new stdClass();
    $user->username = $data->username;
    $usersByUser = User::findAll($user);
    $user = new stdClass();
    $user->email = $data->email;
    $usersByEmail = User::findAll($user);
    if((count($usersByEmail) == 1 && $usersByEmail[0]->id != $data->id) || (count($usersByUser) == 1 && $usersByUser[0]->id != $data->id)) {
      $errorObj["error"] = "Email Or Username Already In Use";
      $jsonString = json_encode($errorObj);
      echo $jsonString;
      return;
    }

    $userToEdit = User::findById($data->id);
    $jsonString;
    if($userToEdit->id == -1) {
      $errorObj["error"] = "Unable to Find Record";
      $jsonString = json_encode($errorObj);
    } else {
      $userToEdit->username = $data->username;
      $userToEdit->firstname = $data->firstname;
      $userToEdit->lastname = $data->lastname;
      $userToEdit->email = $data->email;
      $userToEdit->password = $data->password;
      if($userToEdit->save()) {
        $jsonString = json_encode($userToEdit);
      } else {
        $errorObj["error"] = "Unable to Update Database";
        $jsonString = json_encode($errorObj);
      }
    }
    echo $jsonString;
  }

  function deleteUser($data) {
    $jsonString;
    if(User::deleteById($data->id)) {
      $successObj["success"] = "successfully deleted";
      $jsonString = json_encode($successObj);
    } else {
      $successObj["success"] = "successfully deleted";
      $jsonString = json_encode($successObj);
    }
    echo $jsonString;
  }
?>