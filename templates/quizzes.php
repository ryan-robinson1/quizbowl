<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Julian Wilson">
    <title>Lobby</title>
    <meta name="description" content="Page for list of question sets for CS4640 project">
    <meta name="keywords" content="school project">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="css/sets.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <!-- <li class="nav-item px-4">
                    <a class="nav-link active" href="index.html">Home</a>
                </li>
                <li class="nav-item px-4">
                    <a class="nav-link active" href="sets.html">Question sets</a>
                </li> -->
            </ul>

            <div class="btn-group">
                <button type="button" class="btn btn-secondary bg-purple dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" id="profile-btn">
                    <?= $_SESSION["user"] ?>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="?command=logout">Log Out</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="p-5 mb-4 bg-light rounded-3">
        <div class="container-fluid py-5">
            <h1 class="display-5 fw-bold text-center">My Question Sets</h1>
        </div>
    </div>
    <?php echo $error_msg; ?>

    <div class="container">
        <div class="dropdown p-4 text-center">
            <button class="btn btn-lg btn-secondary bg-purple dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                Select set
            </button>

<<<<<<< Updated upstream
             <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                 <?php foreach($sets_list as $set): ?>
                    <li><a class="dropdown-item" href="?command=quizzes&sid=<?=$set["set_id"]?>"><?php echo $set["set_name"];?></a></li>
                 <?php endforeach; ?>
=======

            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                <?php foreach ($sets_list as $set) : ?>
                    <li><a class="dropdown-item" href="#"><?php echo $set["set_name"]; ?></a></li>
                <?php endforeach; ?>
                <li><a class="dropdown-item" href="#">New question set</a></li>
                <!-- <li><a class="dropdown-item" href="#">Vocab chapter 2</a></li>
                <li><a class="dropdown-item" href="#">Capitals</a></li>
                <li><a class="dropdown-item" href="#">Old question set</a></li> -->
>>>>>>> Stashed changes
            </ul>

            <form action="?command=startgame" method="post" style="display: inline;">
                <button type="submit" class="btn btn-lg btn-success">Host Quiz!</button>
            </form>


            <form action="?command=makequiz" method="post" style="display: inline;">
                <button class="btn btn-lg btn-secondary" type="submit">
                    Make Question Set!
                </button>
            </form>
        </div>
    </div>

    <ul class="list-group">
        <li class="list-group-item py-0 border-0">
            <div class="container">
                <div class="row">
                    <div class="card col-md-6 p-0 border-0">
                        <div class="card-body p-5 border border-3 rounded">
                            <h3 class="card-title text-center bg-purple text-light p-3">
                                Questions
                            </h3>
                        </div>
                    </div>
                    <div class="card col-md-6 p-0 border-0">
                        <div class="card-body p-5 border border-3 rounded">
                            <h3 class="card-title text-center bg-purple text-light p-3">
                                Answers
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
        </li>

<<<<<<< Updated upstream
        <?php 
        $selected_set = "1";
        if(isset($_GET["sid"])) {
            $selected_set = $_GET["sid"];
        }
        if(isset($sets_questions[$selected_set])) {
            foreach($sets_questions[$selected_set] as $question):?>
=======
        <?php foreach ($sets_questions["3"] as $question) : ?>

>>>>>>> Stashed changes
            <li class="list-group-item py-0 border-0">
                <div class="container">
                    <div class="row">
                        <div class="card col-md-6 p-0 border-0">
                            <div class="card-body p-5 border border-3 rounded">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">
                                        <?php echo $question["question"] ?>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card col-md-6 p-0 border-0">
                            <div class="card-body p-5 border border-3 rounded">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">
                                        <ul>
                                            <li>
                                                <?php if ($question["correct_answer"] == 1) echo "<b>";
                                                echo "a. " . $question["answer1"];
                                                if ($question["correct_answer"] == 1) echo "</b>";
                                                ?>
                                            </li>
                                            <li>
                                                <?php if ($question["correct_answer"] == 2) echo "<b>";
                                                echo "b. " . $question["answer2"];
                                                if ($question["correct_answer"] == 2) echo "</b>";
                                                ?>

                                            </li>
                                            <li>
                                                <?php if ($question["correct_answer"] == 3) echo "<b>";
                                                echo "c. " . $question["answer3"];
                                                if ($question["correct_answer"] == 3) echo "</b>";
                                                ?>

                                            </li>
                                            <li>
                                                <?php if ($question["correct_answer"] == 4) echo "<b>";
                                                echo "d. " . $question["answer4"];
                                                if ($question["correct_answer"] == 4) echo "</b>";
                                                ?>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </li>

        <?php endforeach; } ?>
    </ul>
    <!--for spacing at bottom of screen-->
    <div class="p-5"></div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
</body>

</html>