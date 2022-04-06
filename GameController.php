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
            case "newset":
                $this->new_set();
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
        //otherwise

        //also still have to do something with $error_msg

        $error_msg = "";

        $qset;

        $sets_list = $this->db->query("select set_id, set_name from project_questionSet where user_email = ?;", "s", $_SESSION["email"]);

        if ($sets_list === false) {
            $error_msg = "<div class='alert alert-danger'>Error getting question sets</div>";   
            include "sets.php";
            return;
        }

        if(isset($_POST["qset"])) {
            $qset = $_POST["qset"];
        }
        else if(count($sets_list) > 0) {
           $qset = $sets_list[0]["set_id"];
        }
        else {
            $qset = -1;
        }

        $question_list = $this->db->query("select * from project_question where set_id = ?;", "i", $qset);

        if ($question_list === false) {
                    $error_msg = "<div class='alert alert-danger'>Error getting questions</div>";   
                    include "sets.php";
                    return;
        }

        // $sets_questions = [];

        // foreach($sets_list as $qset) {
        //     $question_list = $this->db->query("select * from project_question where set_id = ?;", "i", $qset["set_id"]);
        //     if ($question_list === false) {
        //         $error_msg = "<div class='alert alert-danger'>Error getting questions</div>";   
        //         include "sets.php";
        //         return;
        //     }
        //     $sets_questions[$qset["set_id"]] = $question_list;
        // }

        include "sets.php";

    }

    public function join_game() {

        //if user isn't logged in, redirect to home page, maybe with error message?
        //possibly load question sets page with directions to log in to create sets?

        //lots of stuff to upadate on this page
        //plus everything about checking if this game exists to join, then joining it, then getting
        //info about other users etc

        include "lobby.php";

    }


    public function new_set() {

        

        include "new_set.php";

    }

}
?>