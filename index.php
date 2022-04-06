<?php
    // see at https://cs4640.cs.virginia.edu/jww2rfe/project/
    // resources used:
    // boostrap docs: https://getbootstrap.com/docs/4.0/getting-started/introduction/
    // course website and materials: https://cs4640.cs.virginia.edu/ 
    // php docs: https://www.php.net/docs.php 

    // error reporting code snippet
    // error_reporting(E_ALL);
    // ini_set('display_errors', 1);

    // Register the autoloader
    spl_autoload_register(function($classname) {
        include "$classname.php";
    });

    session_start();

    // Parse the query string for command
    $command = "home";
    if (isset($_GET["command"]))
        $command = $_GET["command"];

    // Check if user has already logged in; if so, continue as normal
    // If they have not logged in, direct them to login page
    // if (!isset($_SESSION["email"]) || !isset($_SESSION["name"])) {
    //     $command = "login";
    // }

    // Instantiate the controller and run
    $game = new GameController($command);
    $game->run();
?>