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
            case "logout":
                session_unset();
                session_destroy();
            default:
                $this->start();
        }
    }
    public function quizzes()
    {
        include("templates/quizzes.php");
    }
    public function makequiz()
    {
        include("templates/new_set.php");
    }
    public function startgame()
    {
        include("templates/lobby.php");
    }
    public function playgame()
    {
        include("templates/buzzer.php");
    }
    public function start()
    {
        include("templates/start.php");
    }
    public function join()
    {
        include("templates/join.php");
    }
    public function login()
    {
        if (isset($_POST["user"]) && isset($_POST["password"])) {
            $data = $this->db->query("select * from user where username = ?;", "s", $_POST["user"]);
            if ($data === false) {
                $error_msg = "Error checking for user";
            } else if (!empty($data)) {
                if (password_verify($_POST["password"], $data[0]["passwd"])) {
                    $_SESSION["user"] = $_POST["user"];
                    $_SESSION["user_id"] = $data[0]["id"];
                    header("Location: ?command=quizzes");
                } else {
                    $error_msg = "Wrong password";
                }
            } else {
                // TODO: input validation, create user page
                $insert = $this->db->query(
                    "insert into user (username, passwd) values (?, ?);",
                    "ss",
                    $_POST["user"],
                    password_hash($_POST["password"], PASSWORD_DEFAULT)
                );
                if ($insert === false) {
                    $error_msg = "Error inserting user";
                } else {
                    $_SESSION["user"] = $_POST["user"];
                    $_SESSION["user_id"] = $data[0]["id"];
                    header("Location: ?command=login_");
                }
            }
        }
        include("templates/login.php");
    }
}
