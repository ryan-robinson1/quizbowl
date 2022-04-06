<?php
class GameController {

    private $command;
    private $db;

    public function __construct($command) {
        $this->command = $command;
        $this->db = new Database();
    }

    public function run() {
        switch($this->command) {
            case "login":
                $this->login();
                break;
            case "sets":
                $this->sets();
                break;
            case "new_set":
                $this->newset();
                break;
            case "joingame":
                $this->join_game();
                break;
            default:
                $this->home();
                break;
        }
    }

    public function home() {
        //check if user is logged in; if so, display their username somewhere on navbar probably
        //if user isn't logged in, don't include question sets link on navbar
        include "home.php";
    }

    public function login() {
        $error_msg = "";
        if (isset($_POST["email"]) && !empty($_POST["email"])) {

            $data = $this->db->query("select * from project_user where email = ?;", "s", $_POST["email"]);
            if ($data === false) {
                $error_msg = "<div class='alert alert-danger'>Error checking for user</div>";
            } 
            else if (!empty($data)) {
                if (password_verify($_POST["password"], $data[0]["password"])) {
                    $_SESSION["email"] = $_POST["email"];
                    $_SESSION["username"] = $_POST["username"];
                    header("Location: ?command=home");
                    return;
                } 
                else {
                    $error_msg = "<div class='alert alert-danger'>Wrong password</div>";
                }
            } 
            else { 
                // empty, no user found
                $insert = $this->db->query("insert into project_user (username, email, password) values (?, ?, ?);", 
                        "sss", $_POST["username"], $_POST["email"], 
                        password_hash($_POST["password"], PASSWORD_DEFAULT));

                if ($insert === false) {
                    $error_msg = "<div class='alert alert-danger'>Error creating user</div>";
                } 
                else {
                    $_SESSION["email"] = $_POST["email"];
                    $_SESSION["username"] = $_POST["username"];
                    header("Location: ?command=home");
                    return;
                }
            }
        }
        include "login.php";

    }

    public function sets() {

        //if user isn't logged in, redirect to home page, maybe with error message?
        //possibly load question sets page with directions to log in to create sets?

        include "sets.php";

    }

    public function join_game() {

        //if user isn't logged in, redirect to home page, maybe with error message?
        //possibly load question sets page with directions to log in to create sets?

        include "lobby.php";

    }


    public function new_set() {

        

        include "new_set.php";

    }

}
?>