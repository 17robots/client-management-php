<?php  
  include_once('../model/User.php');
  public static function login($userInfo, $password) {
    $userEmail = User::findAll({"email" => $userInfo, "password" => $password}));
    $userUser = User::findAll({"email" => $userInfo, "password" => $password}));
    $jsonString;
    if(count($userEmail) != 1 || count($userUser) != 1) {
      $jsonString = json_encode({"error" => "Incorrect Username Or Password"});
    } else {
      $authData["userId"] = $userEmail[0]->id;
      $authData["token"] = 1; // figure out how to do token creation
      $authData["tokenExpiration"] = 3600; // 1 hour
      $jsonString = json_encode($authData);
    }
    echo $jsonString;
  }

  public static function addUser($userData) {
    $newUser = User::ForInsert($userData[0], $userData[1], $userData[2], $userData[3], $userData[4]);
    if($newUser->save()) {
      $jsonString = json_encode($newUser);
    } else {
      $jsonString = json_encode({"error" => "Unable To Insert Into Database"});
    }
    echo $jsonString;
  }

  public static function updateUser($userId, $newUserData) {
    $userToEdit = User::findById($userId);
    $jsonString;
    if($userToEdit->id == -1) {
      $jsonString = json_encode("error" => "Unable To Find Record");
    } else {
      if($userToEdit->save()) {
        $jsonString = json_encode($userToEdit);
      } else {
        $jsonString = json_encode({"error" => "Unable To Update Database"});
      }
    }
    echo $jsonString;
  }

  public static function deleteUser($userId) {
    $jsonString;
    if(User::deleteById($clientId)) {
      $jsonString = json_encode("success" => "Successfully deleted");
    } else {
      $jsonString = json_encode("error" => "Error Deleting");
    }
    echo $jsonString;
  }
?>