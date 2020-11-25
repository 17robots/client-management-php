<?php  
  include_once('../model/User.php');
  public static function login($data) {
    $jsonString;
    $returnedUser = User::findAll($data->options);
    if(count($returnedUser) != 1) {
      $error["error"] = "Incorrect Username Or Password";
      $jsonString = json_encode($error);
    } else {
      $authData["userId"] = $userEmail[0]->id;
      $authData["token"] = 1; // figure out how to do token creation
      $authData["tokenExpiration"] = 3600; // 1 hour
      $authData["success"] = "successfully logged in";
      $jsonString = json_encode($authData);
    }
    echo $jsonString;
  }

  public static function addUser($data) {
    $user["username"] = $data->username;
    $usersByUser = User::findAll(json_encode($user));
    $user["username"] = "";
    $user["email"] = $data->email;
    $usersByEmail = User::findAll(json_encode($user));
    if(count($usersByEmail) > 0 ||count($usersByUser) > 0) {
      $errorObj["error"] = "Email Or Username Already In Use";
      $jsonString = json_encode($errorObj);
      return $jsonString;
    }

    $newUser = User::ForInsert($data->firstname, $data->lastname, $data->username, $data->email, $data->password);
    if($newUser->save()) {
      $jsonString = json_encode($newUser);
    } else {
      $jsonString = json_encode({"error" => "Unable To Insert Into Database"});
    }
    echo $jsonString;
  }

  public static function updateUser($userId, $newUserData) {
    $user["username"] = $data->username;
    $usersByUser = User::findAll(json_encode($user));
    $user["username"] = "";
    $user["email"] = $data->email;
    $usersByEmail = User::findAll(json_encode($user));
    if((count($usersByEmail) == 1 && $usersByEmail[0]->id != $data->id)  || (count($usersByUser) == 1 && $usersByUser[0]->id != $data->id)) {
      $errorObj["error"] = "Email Or Username Already In Use";
      $jsonString = json_encode($errorObj);
      return $jsonString;
    }

    $userToEdit = User::findById($userId);
    $jsonString;
    if($userToEdit->id == -1) {
      $errorObj["error"] = "Unable to Find Record";
      $jsonString = json_encode($errorObj);
    } else {
      if($userToEdit->save()) {
        $jsonString = json_encode($userToEdit);
      } else {
        $errorObj["error"] = "Unable to Update Database";
        $jsonString = json_encode($errorObj);
      }
    }
    echo $jsonString;
  }

  public static function deleteUser($userId) {
    $jsonString;
    if(User::deleteById($clientId)) {
      $successObj["success"] = "successfully deleted";
      $jsonString = json_encode($successObj);
    } else {
      $successObj["success"] = "successfully deleted";
      $jsonString = json_encode($successObj);
    }
    echo $jsonString;
  }
?>