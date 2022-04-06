<?php

class Database
{
    private $mysqli;

    public function __construct()
    {
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $this->mysqli = new mysqli(
            Config::$db["host"],
            Config::$db["user"],
            Config::$db["pass"],
            Config::$db["database"]
        );
        $sql1 = file_get_contents('sql/user_setup.sql');
        $sql2 = file_get_contents('sql/set_setup.sql');
        $sql3 = file_get_contents('sql/question_setup.sql');
        $sql4 = file_get_contents('sql/runninggame_setup.sql');
        $sql5 = file_get_contents('sql/player_setup.sql');
        // $this->mysqli->query($sql1);
        // $this->mysqli->query($sql2);
        // $this->mysqli->query($sql3);
        // $this->mysqli->query($sql4);
        // $this->mysqli->query($sql5);
    }

    public function query($query, $bparam = null, ...$params)
    {
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
}
