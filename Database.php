<?php
// This code is taken from the in-class trivia game example

class Database {
    private $mysqli;

    public function __construct() {
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $this->mysqli = new mysqli(Config::$db["host"], 
                Config::$db["user"], Config::$db["pass"], 
                Config::$db["database"]);
    }

    public function query($query, $bparam=null, ...$params) {
        $stmt = $this->mysqli->prepare($query);

        if ($bparam != null)
            $stmt->bind_param($bparam, ...$params);

        if (!$stmt->execute()) {
            return false;
        }

        if (($res = $stmt->get_result()) !== false) {
            return $res->fetch_all(MYSQLI_ASSOC);
        }

        return true;
    }
    /* The SQL commands I used to create the tables used for this assignment
    CREATE TABLE project_user (
        email varchar(300) NOT NULL,
        username varchar(300) NOT NULL,
        password text,
        PRIMARY KEY (email)
    );

    CREATE TABLE project_questionSet (
        set_id int NOT NULL auto_increment,
        set_name varchar(500) NOT NULL,
        user_email varchar(300) NOT NULL,
        FOREIGN KEY (user_email) REFERENCES project_user (email),
        PRIMARY KEY (set_id)
    );

    CREATE TABLE project_question (
        question_id int NOT NULL auto_increment,
        set_id int NOT NULL, 
        question varchar(500) NOT NULL,
        answer1 varchar(500) NOT NULL,
        answer2 varchar(500) NOT NULL,
        answer3 varchar(500) NOT NULL,
        answer4 varchar(500) NOT NULL,
        correct_answer ENUM("1", "2", "3", "4") NOT NULL,
        FOREIGN KEY (set_id) REFERENCES project_questionSet(set_id),
        PRIMARY KEY (question_id)
    );

    CREATE TABLE project_runningGame (
        game_id int NOT NULL,
        set_id int NOT NULL,
        host int NOT NULL,
        FOREIGN KEY (host) REFERENCES project_user(email),
        FOREIGN KEY (set_id) REFERENCES project_questionSet(set_id),
        PRIMARY KEY (game_id)
    );

    CREATE TABLE project_player (
        username varchar(300) NOT NULL,
        game_id int NOT NULL,
        FOREIGN KEY (game_id) REFERENCES project_runningGame(game_id),
        PRIMARY KEY (username)
    );


    INSERT INTO hw5_transaction(user_email, name, category, t_date, amount, type) VALUES ( "a@a", "test transaction", "groceries", "2022:03:29", 8.50, "debit");

    */

}