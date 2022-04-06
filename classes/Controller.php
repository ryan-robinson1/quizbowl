<?php
class Controller
{
    private $command;

    private $db;

    public function __construct($command)
    {
        $this->command = $command;
        $this->db = new Database();
    }
    public function run()
    {
        switch ($this->command) {
            case "":
                $this->start();
                break;
            case "join":
                $this->join();
                break;
            case "login_":
                $this->login();
                break;
            case "quizzes":
                $this->quizzes();
                break;
            case "playgame":
                $this->playgame();
                break;
            case "startgame":
                $this->startgame();
                break;
            case "makequiz":
                $this->makequiz();
                break;
            case "logout_player":
                $this->logout_player();
                break;
            case "logout":
                $this->logout();
            default:
                $this->start();
        }
    }
    public function logout()
    {
        $this->db->query("delete from project_player where game_id=?;", "s", $_SESSION["pin"]);
        $this->db->query("delete from project_runningGame where host=?;", "s", $_SESSION["user"]);
        session_unset();
        session_destroy();
    }
    public function logout_player()
    {
        session_unset();
        session_destroy();
        $this->start();
    }
    public function quizzes()
    {
        $error_msg = "";

        if (isset($_SESSION["current_set"])) {
            unset($_SESSION["current_set"]);
            unset($_SESSION["current_set_name"]);
        }

        $sets_list = $this->db->query("select set_id, set_name from project_questionSet where username = ?;", "s", $_SESSION["user"]);

        if ($sets_list === false) {
            $error_msg = "<div class='alert alert-danger'>Error getting question sets</div>";
            include "sets.php";
            return;
        }

        // if(isset($_POST["qset"])) {
        //     $qset = $_POST["qset"];
        // }
        // else if(count($sets_list) > 0) {
        //    $qset = $sets_list[0]["set_id"];
        // }
        // else {
        //     $qset = -1;
        // }

        // $question_list = $this->db->query("select * from project_question where set_id = ?;", "i", $qset);

        // if ($question_list === false) {
        //             $error_msg = "<div class='alert alert-danger'>Error getting questions</div>";   
        //             include "sets.php";
        //             return;
        // }

        $sets_questions = [];

        foreach ($sets_list as $qset) {
            $question_list = $this->db->query("select * from project_question where set_id = ?;", "i", $qset["set_id"]);
            if ($question_list === false) {
                $error_msg = "<div class='alert alert-danger'>Error getting questions</div>";
                include "sets.php";
                return;
            }
            $sets_questions[$qset["set_id"]] = $question_list;
        }

        include("templates/quizzes.php");
    }
    public function makequiz()
    {
        $error_msg = "";
        $set_name_created = isset($_SESSION["current_set"]) || isset($_POST["set_name"]);

        if ($set_name_created) {
            if (isset($_POST["set_name"])) {
                $res = $this->db->query("insert into project_questionset(set_name, username) values (?, ?)", "ss", $_POST["set_name"], $_SESSION["user"]);
                if ($res === false) {
                    $error_msg = "<div class='alert alert-danger'>Error inserting new set</div>";
                    include("templates/new_set.php");
                    return;
                } else {
                    $_SESSION["current_set"] = $this->db->getLastInsertedID();
                    $_SESSION["current_set_name"] = $_POST["set_name"];
                }
            } else {
                $res = $this->db->query(
                    "insert into project_question(
                        set_id, question, question_number, answer1, answer2, answer3, answer4, correct_answer)
                        values (?, ?, ?, ?, ?, ?, ?, ?)",
                    "isissssi",
                    $_SESSION["current_set"],
                    $_POST["question"],
                    1,
                    $_POST["answer1"],
                    $_POST["answer2"],
                    $_POST["answer3"],
                    $_POST["answer4"],
                    $_POST["correct_answer"]
                );
                if ($res === false) {
                    $error_msg = "<div class='alert alert-danger'>Error inserting new question</div>";
                    include("templates/new_set.php");
                    return;
                }
            }
        }

        include("templates/new_set.php");
    }
    public function startgame()
    {
        $user_game_num =  $this->db->query("select * from project_runningGame where host = ?;", "s", $_SESSION["user"]);
        if (count($user_game_num) <= 0) {
            $pin = rand(10000, 99999);
            $result =  $this->db->query("select * from project_runningGame where game_id = ?;", "i", $pin);
            while (count($result) > 0) {
                $pin = rand(10000, 99999);
                $result =  $this->db->query("select * from project_runningGame where game_id = ?;", "i", $pin);
            }
            $insert = $this->db->query(
                "insert into project_runningGame (game_id, set_id, host) values (?, ?, ?);",
                "iis",
                $pin,
                3,
                $_SESSION["user"]
            );
            $_SESSION["pin"] = $pin;
            $_SESSION["set_id"] = 3;
        }
        $_SESSION["blue_players"] = $this->db->query("select * from project_player where game_id = ? and team = ?;", "is", $_SESSION["pin"], "0");
        $_SESSION["red_players"] = $this->db->query("select * from project_player where game_id = ? and team = ?;", "is", $_SESSION["pin"], "1");
        include("templates/lobby.php");
    }
    public function playgame()
    {
        if (!isset($_SESSION["pin"])) {
            header("Location: ?command=");
        }
        include("templates/buzzer.php");
    }
    public function start()
    {
        include("templates/start.php");
    }
    public function join()
    {
        if (isset($_POST["pin"])) {
            //Look for a running game

            $game = $this->db->query("select * from project_runningGame where game_id = ?;", "i", $_POST["pin"]);
            if ($game === false) {
                $error_msg = "Game does not exist";
            } else {
                $_SESSION["pin"] = $_POST["pin"];
                $teams = "01";
                $insert = $this->db->query(
                    "insert into project_player (username, game_id, team) values (?, ?, ?);",
                    "sis",
                    $_POST["name"],
                    $_POST["pin"],
                    $teams[rand() % 2]
                );
                if ($insert === false) {
                    $$error_msg = "Duplicate user";
                } else {
                    header("Location: ?command=playgame");
                }
            }
        }

        //TODO: Wrap up and delete player once game finishes
        include("templates/join.php");
    }
    public function login()
    {
        if (isset($_POST["user"]) && isset($_POST["password"])) {
            $data = $this->db->query("select * from project_user where username = ?;", "s", $_POST["user"]);
            if ($data === false) {
                $error_msg = "Error checking for user";
            } else if (!empty($data)) {
                if (password_verify($_POST["password"], $data[0]["password"])) {
                    $_SESSION["user"] = $_POST["user"];
                    header("Location: ?command=quizzes");
                } else {
                    $error_msg = "Wrong password";
                }
            } else {
                // TODO: input validation, create user page
                $insert = $this->db->query(
                    "insert into project_user (username, password) values (?, ?);",
                    "ss",
                    $_POST["user"],
                    password_hash($_POST["password"], PASSWORD_DEFAULT)
                );
                if ($insert === false) {
                    $error_msg = "Error inserting user";
                } else {
                    $_SESSION["user"] = $_POST["user"];
                    header("Location: ?command=quizzes");
                }
            }
        }
        include("templates/login.php");
    }
}
