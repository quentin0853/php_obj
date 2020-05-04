<?php
include 'models/Boardgame.php';
include 'controllers/BoardgameController.php';

$defaultController = 'BoardgameController';

// Get parameters from the URL
// TODO : check if the null coalescing works here
$controllerAsked = empty($_GET['controller']) ? $defaultController : $_GET['controller'];
$actionAsked = empty($_GET['action']) ? '' : $_GET['action'];
$id = empty($_GET['id']) ? '' : $_GET['id']; 


// Set the corresponding Controller.
if (class_exists($controllerAsked.'Controller')) {
  $controllerName = $controllerAsked.'Controller';
} else {
  $controllerName = $defaultController;
}
$controller = new $controllerName();

// Check the requested method
if (!method_exists($controller, $actionAsked)) {
    throw new Exception("Error : action : {$actionAsked} doesn't exist for the controller {$controllerName}");
}

// Dispatch the action
$controller->$actionAsked($id);