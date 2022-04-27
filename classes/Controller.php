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
            case "round_score":
                $this->roundscore();
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
            case "get_players":
                $this->get_players();
                break;
            case "end_game":
                $this->end_game();
                break;
            case "get_team":
                $this->get_team();
                break;
            case "send_answer":
                $this->send_answer();
                break;
            case "timeup":
                $this->timeup();
                break;
            case "logout":
                $this->logout();
            default:
                $this->start();
        }
    }

    public function timeup()
    {
        $res = $this->db->query("select timeup from project_timeup where game_id = ?;", "i", $_SESSION["pin"]);
        if (count($res) > 0 && isset($_POST["timeup"])) {
            $this->db->query("update project_timeup set timeup = ? where game_id = ?;", "si", $_POST["timeup"], $_SESSION["pin"]);
            echo json_encode("true");
        } else if (isset($_POST["timeup"])) {
            $this->db->query("insert into project_timeup values(?, ?);", "is", $_SESSION["pin"], $_POST["timeup"]);
        } else echo json_encode($res[0]["timeup"]);
        return;
    }
    public function get_players()
    {
        $_SESSION["blue_players"] = $this->db->query("select * from project_player where game_id = ? and team = ?;", "is", $_SESSION["pin"], "0");
        $_SESSION["red_players"] = $this->db->query("select * from project_player where game_id = ? and team = ?;", "is", $_SESSION["pin"], "1");
        echo json_encode(array(
            $_SESSION["blue_players"],
            $_SESSION["red_players"],
        ));
    }
    public function send_answer()
    {
        //$question_id = $this->db->query("select * from project_runningGame where game_id = ?;", "i", $_SESSION["pin"]);
        //$question = $this->db->query("select * from project_question where question_id = ?;", "i", 1);

        //$_SESSION["questions"][0]
        //$question[0]["correct_answer"]
        if ($_POST["team"] === "1" && $_POST["answer"] === $_SESSION["questions"][0]["correct_answer"]) {
            $update = $this->db->query(
                "update project_runningGame set red_recent_correct = red_recent_correct+1 where game_id = ?;",
                "i",
                $_SESSION["pin"],
            );
        }
        if ($_POST["team"] === "0" && $_POST["answer"] === $_SESSION["questions"][0]["correct_answer"]) {
            $update = $this->db->query(
                "update project_runningGame set blue_recent_correct = blue_recent_correct+1 where game_id = ?;",
                "i",
                $_SESSION["pin"],
            );
        }

        // }

        // if ($question["correct_answer"] === $answer and $team === "0") {
        //     $update = $this->db->query(
        //         "update project_runninggame set blue_recent_correct = blue_recent_correct+1 where game_id = ?;",
        //         "i",
        //         $_SESSION["pin"],
        //     );
        // } else if ($question["correct_answer"] === $answer and $team === "1") {
        //     $update = $this->db->query(
        //         "update project_runninggame set red_recent_correct = red_recent_correct+1 where game_id = ?;",
        //         "i",
        //         $_SESSION["pin"],
        //     );
        // }

        //If answer true, update database accordingly
        //If answer false, update database accordingly
    }
    public function end_game()
    {
        $pin = $_SESSION["pin"];

        $res = $this->db->query("select red_score, blue_score, red_recent_correct, blue_recent_correct from project_runningGame where game_id=?;", "i", $pin);
        if ($res == false) {
            $error_msg = "<div class='alert alert-danger'>Error getting scores</div>";
        }
        $red_score = $res[0]["red_score"];
        $blue_score = $res[0]["blue_score"];

        $red_text = "Tie";
        $blue_text = "Tie";

        if ($red_score > $blue_score) {
            $red_text = "Winner";
            $blue_text = "Loser";
        } else if ($red_score < $blue_score) {
            $blue_text = "Winner";
            $red_text = "Loser";
        }

        if (isset($_SESSION["pin"]))
            $this->db->query("delete from project_player where game_id=?;", "s", $_SESSION["pin"]);

        $this->db->query("delete from project_timeup where game_id=?;", "s", $_SESSION["pin"]);

        if (isset($_SESSION["username"]))
            $this->db->query("delete from project_runningGame where host=?;", "s", $_SESSION["username"]);
        include("templates/end_game.php");
    }
    public function roundscore()
    {
        $error_msg = "";
        $pin = $_SESSION["pin"];

        $res = $this->db->query("select red_score, blue_score, red_recent_correct, blue_recent_correct from project_runningGame where game_id=?;", "i", $pin);
        if ($res == false) {
            $error_msg = "<div class='alert alert-danger'>Error getting scores</div>";
        }
        $red_score = $res[0]["red_score"];
        $blue_score = $res[0]["blue_score"];
        $red_recent = $res[0]["red_recent_correct"];
        $blue_recent = $res[0]["blue_recent_correct"];

        $res = $this->db->query("select COUNT(username) as num_players from project_player where game_id=? GROUP BY team;", "i", $pin);
        if ($res == false) {
            $error_msg = "<div class='alert alert-danger'>Error getting scores</div>";
        }
        $blue_last = (int)(($blue_recent / $res[0]["num_players"]) * 100);
        $red_last = (int)(($red_recent / $res[1]["num_players"]) * 100);
        $red_score += $red_last;
        $blue_score += $blue_last;

        $res = $this->db->query(
            "update project_runningGame set blue_score = ?, red_score = ?, blue_recent_correct = ?, red_recent_correct = ? where game_id=?;",
            "iiiii",
            $blue_score,
            $red_score,
            0,
            0,
            $pin
        );
        if ($res == false) {
            $error_msg = "<div class='alert alert-danger'>Error updating scores</div>";
        }

        array_shift($_SESSION["questions"]);


        include("templates/round_score.php");
    }

    public function get_team()
    {
        echo json_encode($_SESSION["team"]);
    }
    public function logout()
    {
        if (isset($_SESSION["pin"]))
            $this->db->query("delete from project_player where game_id=?;", "s", $_SESSION["pin"]);

        if (isset($_SESSION["username"]))
            $this->db->query("delete from project_runningGame where host=?;", "s", $_SESSION["username"]);
        session_unset();
        session_destroy();
    }
    public function logout_player()
    {
        if (isset($_SESSION["pin"]))
            $this->db->query("delete from project_player where game_id=?;", "s", $_SESSION["pin"]);
        session_unset();
        session_destroy();
        $this->start();
    }
    public function in_session()
    {
        // $test = $this->db->query("select * from project_question where question_id = ?;", "i", 1);
        // print_r($test[0]["correct_answer"]);
        $this->db->query("update project_timeup set timeup = ? where game_id = ?;", "si", "false", $_SESSION["pin"]);

        $question_id = $this->db->query("select * from project_question where set_id = ?;", "i", $_SESSION["set_id"]);
        $curr_q_id = $question_id[0]["question_id"];
        $update = $this->db->query(
            "update project_runningGame set current_question = ? where game_id = ?;",
            "ii",
            $curr_q_id,
            $_SESSION["pin"],
        );
        //TODO: We need to pop off a question from the question session array when we are done with it
        if (count($_SESSION["questions"]) < 1) {
            header("Location: ?command=end_game");
        }
        $question = $_SESSION["questions"][0];
        $pin = $_SESSION["pin"];

        include("templates/game.php");
    }
    public function quizzes()
    {
        $error_msg = "";

        if (isset($_SESSION["current_set"])) {
            unset($_SESSION["current_set"]);
            unset($_SESSION["current_set_name"]);
        }

        // gets all sets for the user
        $sets_list = $this->db->query("select set_id, set_name from project_questionSet where username = ?;", "s", $_SESSION["username"]);

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
                $res = $this->db->query("insert into project_questionSet(set_name, username) values (?, ?)", "ss", $_POST["set_name"], $_SESSION["username"]);
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
        if (isset($_SESSION["username"])) {
            $user_game_num =  $this->db->query("select * from project_runningGame where host = ?;", "s", $_SESSION["username"]);
            if (count($user_game_num) <= 0) {
                $_SESSION["host"] = $_SESSION["username"];
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
                    $_SESSION["username"]
                );
                $_SESSION["pin"] = $pin;
                $_SESSION["set_id"] = $_POST["sid"];
            }
            $_SESSION["questions"] = $this->db->query("select * from project_question where set_id = ?", "i", $_SESSION["set_id"]);
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
        // $this->db->query("select * from project_player where game_id = ? and username = ?;", "is", $_SESSION["pin"], "0");
        $team = "";

        $result =  $this->db->query("select * from project_runningGame where game_id = ?;", "i",  $_SESSION["pin"]);
        $score = "";

        if ($_SESSION["team"] === "0") {
            $team = "Blue Team";
            $score = $result[0]["blue_score"];
        } else {
            $team = "Red Team";
            $score = $result[0]["red_score"];
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
                $team = $teams[rand() % 2];
                $_SESSION["team"] = $team;
                $_SESSION["user"] =  $_POST["name"];
                $insert = $this->db->query(
                    "insert into project_player (username, game_id, team) values (?, ?, ?);",
                    "sis",
                    $_POST["name"],
                    $_POST["pin"],
                    $team
                );
                if ($insert === false) {
                    $error_msg = "Duplicate user";
                } else {
                    header("Location: ?command=playgame");
                }
            }
        }

        //TODO: Wrap up and delete player once game finishes
        include("templates/join.php");
    }


    public function deletequestion()
    {
        $error_msg = "";
        if (isset($_GET["qid"])) {
            $game = $this->db->query("delete from project_question where question_id = ?;", "i", $_GET["qid"]);
            if ($game === false) {
                $error_msg = "Could not delete question";
            }
            header("Location: ?command=quizzes&sid=" . $_GET['sid']);
        }
    }

    public function deleteset()
    {
        $error_msg = "";
        if (isset($_POST["sid"])) {
            $sid = $_POST["sid"];
            if ($sid == -1) {
                $error_msg = "Select question set to delete";
            } else {
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

    public function addquestion()
    {
        $error_msg = "";
        if (
            isset($_POST["sid"]) && isset($_POST["question"]) && isset($_POST["answer1"]) && isset($_POST["answer2"]) && isset($_POST["answer3"]) && isset($_POST["answer4"])
            && isset($_POST["correct_answer"]) && isset($_POST["qnum"])
        ) {
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
                // include("templates/new_set.php");
                return;
            }
        }
        // header("Location: ?command=quizzes&sid=" . $_POST['sid']);
    }

    public function login()
    {
        if (isset($_POST["user"]) && isset($_POST["password"])) {
            $data = $this->db->query("select * from project_user where username = ?;", "s", $_POST["user"]);
            if ($data === false) {
                $error_msg = "Error checking for user";
            } else if (!empty($data)) {
                if (password_verify($_POST["password"], $data[0]["password"])) {
                    $_SESSION["username"] = $_POST["user"];
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
                    $_SESSION["username"] = $_POST["user"];
                    header("Location: ?command=quizzes");
                }
            }
        }
        include("templates/login.php");
    }
}
