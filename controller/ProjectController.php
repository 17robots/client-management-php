<?php
  // we need the project model to be able to do anything
  include_once("../model/Project.php");

  // "resolver" that controls what we can do with the projects
  
  // here we design the api portion that the user interacts with when they send the request over to the php file

  // for this function, we require a user id in order to get the books
  function getProjects($userId) {
    echo "getting projects with ", $userId, " as data ";
  }

  // for this one we can use this to get data for one project (useful for modals)
  function getProject($projectId) {
    echo "getting project with ", $projectId, " as data ";
  }

  // we need the project data that will be validated on the client side so everything we get here should be valid
  function addProject($projectData) {
    echo "adding project with ", $projectData, " as data ";

  }

  // here we need the data for the project and then we need the new data that we are going to update the record with (this will include all project data including the data we arent changing so we can copy it linearly)
  function updateProject($projectId, $newProjectData) {
    echo "updating project with ", $projectId, ' ', $newProjectData, " as data ";
  }

  // this needs the id and then we can delete it
  function deleteProject($projectId) {
    echo "deleting project with ", $projectId, ' ', $newProjectData, " as data ";
  }
?>