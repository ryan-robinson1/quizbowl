<?php

//https://cs4640.cs.virginia.edu/rpr6at/hw4/
// Register the autoloader
session_start();
spl_autoload_register(function ($classname) {
    include "classes/$classname.php";
});

// Parse the query string for command
$command = "login";
if (isset($_GET["command"]))
    $command = $_GET["command"];

// Instantiate the controller and run
$controller = new Controller($command);
$controller->run();
