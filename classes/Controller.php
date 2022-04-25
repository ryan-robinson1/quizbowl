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
            case "in_session":
                $this->in_session();
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
            case "delete_question":
                $this->deletequestion();
                break;
            case "add_question":
                $this->addquestion();
                break;
            case "delete_set":
                $this->deleteset();
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
        if(isset($_SESSION["pin"]))
            $this->db->query("delete from project_player where game_id=?;", "s", $_SESSION["pin"]);
            
        if(isset($_SESSION["user"]))
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
    public function in_session()
    {
        echo json_encode(array(
            $_SESSION["blue_players"],
            $_SESSION["red_players"],
        ));
    }
    public function quizzes()
    {
        $error_msg = "";

        if (isset($_SESSION["current_set"])) {
            unset($_SESSION["current_set"]);
            unset($_SESSION["current_set_name"]);
        }

        // gets all sets for the user
        $sets_list = $this->db->query("select set_id, set_name from project_questionSet where username = ?;", "s", $_SESSION["user"]);

        if ($sets_list === false) {
            $error_msg = "<div class='alert alert-danger'>Error getting question sets</div>";
            include "sets.php";
            return;
        }

        $sets_questions = [];

        // gets all questions in the sets found above
        foreach ($sets_list as $qset) {
            $question_list = $this->db->query("select * from project_question where set_id = ? order by question_number;", "i", $qset["set_id"]);
            if ($question_list === false) {
                $error_msg = "<div class='alert alert-danger'>Error getting questions</div>";
                include "sets.php";
                return;
            }
            $sets_questions[$qset["set_id"]] = $question_list;
        }

        include("templates/quizzes.php");
    }

    // Single function / page that allows users to create a new question set or add a new question
    // to a question set
    public function makequiz()
    {
        $error_msg = "";

        // checks if we have already created the set
        $set_name_created = isset($_SESSION["current_set"]) || isset($_POST["set_name"]);

        if ($set_name_created) {
            if (isset($_POST["set_name"])) {
                $res = $this->db->query("insert into project_questionSet(set_name, username) values (?, ?)", "ss", $_POST["set_name"], $_SESSION["user"]);
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
                    $_POST["qnum"],
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
            $host = true; 
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
                $_POST["sid"],
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
        $pin_pattern = "/^[0-9][0-9][0-9][0-9][0-9]$/";
        if (isset($_POST["pin"]) && preg_match($pin_pattern, $_POST["pin"])) {
            //Look for a running gameW
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
                    $error_msg = "Duplicate user";
                } else {
                    header("Location: ?command=startgame");
                }
            }
        }

        //TODO: Wrap up and delete player once game finishes
        include("templates/join.php");
    }


    public function deletequestion() {
        $error_msg = "";
        if(isset($_GET["qid"])) {
            $game = $this->db->query("delete from project_question where question_id = ?;", "i", $_GET["qid"]);
            if ($game === false) {
                $error_msg = "Could not delete question";
            }
            header("Location: ?command=quizzes");
        }  
    }

    public function deleteset() {
        $error_msg = "";
        if(isset($_POST["sid"])) {
            $sid = $_POST["sid"];
            if($sid == -1 ) {
                $error_msg = "Select question set to delete";
            }
            else {
                $res = $this->db->query("delete from project_runningGame where set_id = ?;", "i", $sid);
                if ($res === false) {
                    $error_msg = "Could not delete question set";
                }
                $res = $this->db->query("delete from project_question where set_id = ?;", "i", $sid);
                if ($res === false) {
                    $error_msg = "Could not delete question set";
                }
                $res = $this->db->query("delete from project_questionSet where set_id = ?;", "i", $sid);
                if ($res === false) {
                    $error_msg = "Could not delete question set";
                }                
            }
        }
        header("Location: ?command=quizzes");
        // include("templates/quizzes.php");
       
    }

    public function addquestion() {
        $error_msg = "";
        if(isset($_POST["sid"]) && isset($_POST["question"]) && isset($_POST["answer1"]) && isset($_POST["answer2"]) && isset($_POST["answer3"]) && isset($_POST["answer4"]) 
        && isset($_POST["correct_answer"]) && isset($_POST["qnum"])) {
            $res = $this->db->query(
                "insert into project_question(
                    set_id, question, question_number, answer1, answer2, answer3, answer4, correct_answer)
                    values (?, ?, ?, ?, ?, ?, ?, ?)",
                "isissssi",
                $_POST["sid"],
                $_POST["question"],
                $_POST["qnum"],
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
        header("Location: ?command=quizzes&sid=" . $_POST['sid']);
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
