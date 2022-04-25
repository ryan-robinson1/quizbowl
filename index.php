<?php

    // see code at: https://cs4640.cs.virginia.edu/jww2rfe/project/sprint3/

    // resources used:
    // boostrap docs: https://getbootstrap.com/docs/4.0/getting-started/introduction/
    // course website and materials: https://cs4640.cs.virginia.edu/ 
    // php docs: https://www.php.net/docs.php 

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
