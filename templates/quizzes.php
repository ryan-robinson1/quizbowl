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
    <script src="https://code.jquery.com/jquery-3.6.0.js"
                integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
                crossorigin="anonymous">
        </script>
    <script type="text/javascript">
        new_questions = [];
        function Question(question, num, answer1, answer2, answer3, answer4, correct) {
            this.question = question;
            this.num = num;
            this.answer1 = answer1;
            this.answer2 = answer2;
            this.answer3 = answer3;
            this.answer4 = answer4;
            this.correct = correct;
        }

        $(document).ready(function() {
            $("#newq_alert").hide();
            $("#newq").click(function() {
                var q = $("#question").val();
                var a1 = $("#a1").val();
                var a2 = $("#a2").val();
                var a3 = $("#a3").val();
                var a4 = $("#a4").val();
                var qn = $("#qnum").val();
                var c = $("input[name='correct_answer']:checked").val() // from https://stackoverflow.com/questions/596351/how-can-i-know-which-radio-button-is-selected-via-jquery
                if(q == "" || a1 == "" || a2 == "" || a3 == "" || a4 == "" || qnum == "" || qn == "") {
                    $("#newq_alert").show();
                    // show error message here
                }
                else {
                    $("#newq_alert").hide();
                    var newq = new Question(q, qn, a1, a2, a3, a4, c);
                    new_questions.push(newq);

                    var qlist = $("#list_of_questions");
                    $("<li class='list-group-item py-0 border-0'><div class='container'><div class='row'><div class='card col-md-2 p-0 border-0'><div class='card-body p-5 border border-3 rounded'><ul class='list-group list-group-flush'><li class='list-group-item'><a class='btn btn-lg btn-danger' type='button' id='newq_delete" + new_questions.length + "'>Delete</a></li></ul></div></div><div class='card col-md-5 p-0 border-0'><div class='card-body p-5 border border-3 rounded'><ul class='list-group list-group-flush'><li class='list-group-item' id='newq_question" + new_questions.length + "'> </li></ul></div></div><div class='card col-md-5 p-0 border-0'><div class='card-body p-5 border border-3 rounded'><ul class='list-group list-group-flush'><li class='list-group-item'><ul><li id='newq_a1" + new_questions.length +"'></li><li id='newq_a2"+ new_questions.length +"'></li><li id='newq_a3"+ new_questions.length +"'></li><li id='newq_a4"+ new_questions.length +"'> </li></ul></li></ul></div></div></div></div></li>")
                    .insertBefore("#newq_form");

                    $("#newq_question" + new_questions.length).text(q);
                    $("#newq_a1" + new_questions.length).text(a1);
                    $("#newq_a2" + new_questions.length).text(a2);
                    $("#newq_a3" + new_questions.length).text(a3);
                    $("#newq_a4" + new_questions.length).text(a4);

                    $("#newq_delete" + new_questions.length).click(function() {
                        var index = $(this).attr('id').substring(11);
                        new_questions.splice(index-1, 1);
                        index = -1 - index; 
                        $("#list_of_questions > li:eq(" + index + ")").remove();
                    });

                    $("#question").val("");
                    $("#a1").val("");
                    $("#a2").val("");
                    $("#a3").val("");
                    $("#a4").val("");
                    $("#qnum").val("");
                    $("input[name='correct_answer']:checked").prop('checked', false);
                }

            });

            $(window).on("unload", function() {
                new_questions.forEach(function(element) {
                    $.post("index.php?command=add_question", 
                    { 
                        sid: $("#sid").val(),
                        question: element.question,
                        qnum: element.num,
                        answer1: element.answer1,
                        answer2: element.answer2,
                        answer3: element.answer3,
                        answer4: element.answer4,
                        correct_answer: element.correct
                    }, function(data) {
                        console.log(data);
                    }, "text"
                    );
                });
            });
        });
    </script>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
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

    <div class="container text-center">
            <form action="?command=startgame" method="post" style="display: inline;">
                <button type="submit" class="btn btn-lg btn-success">Host Quiz!</button>
                <input type="hidden" id="sid" name="sid" value ="<?php if(isset($_GET["sid"])) echo $_GET["sid"]; else echo "-1";?>">
            </form>
    </div>
    <div class="container">
        <div class="dropdown p-4 text-center">
            
            <button class="btn btn-lg btn-secondary bg-purple dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                <?php if(isset($_GET["sid"])) {
                        foreach($sets_list as $set) {
                            if($set["set_id"] == $_GET["sid"])
                            echo $set["set_name"];
                        }
                    }
                    else echo "Select set"; 
                ?>
            </button>


            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                <?php foreach ($sets_list as $set) : ?>
                    <li><a class="dropdown-item" href="?command=quizzes&sid=<?= $set["set_id"] ?>"><?php echo $set["set_name"]; ?></a></li>
                <?php endforeach; ?>

            </ul>
            <form action="?command=delete_set" method="post" style="display: inline;">
                <button class="btn btn-lg btn-danger" type="submit">
                    Delete Question Set!
                </button>
                <input type="hidden" id = "sid" name = "sid" value="<?php if(isset($_GET["sid"])) echo $_GET["sid"]; else echo "-1";?>">
            </form>
            <form action="?command=makequiz" method="post" style="display: inline;">
                <button class="btn btn-lg btn-secondary" type="submit">
                    Make Question Set!
                </button>
            </form>
        </div>
    </div>

    <ul class="list-group" id = "list_of_questions">
        <li class="list-group-item py-0 border-0">
            <div class="container">
                <div class="row">
                    <div class="card col-md-2 p-0 border-0">
                        <div class="card-body p-5 border border-3 rounded">
                            <h3 class="card-title text-center bg-purple text-light p-3">
                                #
                            </h3>
                        </div>
                    </div>
                    <div class="card col-md-5 p-0 border-0">
                        <div class="card-body p-5 border border-3 rounded">
                            <h3 class="card-title text-center bg-purple text-light p-3">
                                Question
                            </h3>
                        </div>
                    </div>
                    <div class="card col-md-5 p-0 border-0">
                        <div class="card-body p-5 border border-3 rounded">
                            <h3 class="card-title text-center bg-purple text-light p-3">
                                Answers
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
        </li>


        <?php
        $selected_set = "-1";
        if (isset($_GET["sid"])) {
            $selected_set = $_GET["sid"];
        }
        if (isset($sets_questions[$selected_set])) {
            foreach ($sets_questions[$selected_set] as $question) : ?>

                <li class="list-group-item py-0 border-0">
                    <div class="container">
                        <div class="row">
                            <div class="card col-md-2 p-0 border-0">
                                <div class="card-body p-5 border border-3 rounded">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">
                                            <a class="btn btn-lg btn-danger" type="button" href="?command=delete_question&qid=<?php echo $question["question_id"];?>&sid=<?php if(isset($_GET["sid"])) echo $_GET["sid"]; else echo "-1";?>">
                                                Delete
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card col-md-5 p-0 border-0">
                                <div class="card-body p-5 border border-3 rounded">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">
                                            <?php echo $question["question"] ?>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card col-md-5 p-0 border-0">
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

        <?php endforeach;
        } ?>
        <?php if(isset($_GET["sid"])): ?>
        <li class="list-group-item py-0 border-0" id="newq_form">
            <div class="container">
                <!-- <form action="?command=add_question" method="post"> -->
                    <div class="row">
                        <div class="card col-md-2 p-0 border-0">
                            <div class="card-body p-5 border border-3 rounded">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">
                                        <button class="btn btn-lg btn-primary" id="newq">
                                            Add question
                                        </button>  
                                        <div class='alert alert-danger' id="newq_alert">Error: Please fill out all fields</div>"
                                        <!-- <input type="hidden" name = "sid" value="<?php if(isset($_GET["sid"])) echo $_GET["sid"]; else echo "-1";?>"> -->
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card col-md-5 p-0 border-0">
                            <div class="card-body p-5 border border-3 rounded">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">
                                        <textarea class="form-control" name="question" id="question" rows=6 placeholder="Type question here" required></textarea>
                                        <label for="category" class="form-label">Question number</label>
                                        <input type="number" class="form-control" id="qnum" name="qnum" required />
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card col-md-5 p-0 border-0">
                            <div class="card-body p-5 border border-3 rounded">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">
                                        <ul>
                                            <li>
                                                <div class="col">
                                                    <textarea class="form-control" name="answer1" id="a1" rows=1 placeholder="Type answer option here" required></textarea>
                                                <div>
                                                <div class="col">
                                                    <input class="form-check-input" type="radio" name="correct_answer" value="1" required>
                                                </div>                     
                                            </li>
                                            <li>
                                                <div class="col">
                                                    <textarea class="form-control" name="answer2" id="a2" rows=1 placeholder="Type answer option here" required></textarea>
                                                <div>
                                                <div class="col">
                                                    <input class="form-check-input" type="radio" name="correct_answer" value="2" >
                                                </div>  
                                            </li>
                                            <li>
                                                <div class="col">
                                                    <textarea class="form-control" name="answer3" id="a3" rows=1 placeholder="Type answer option here" required></textarea>
                                                <div>
                                                <div class="col">
                                                    <input class="form-check-input" type="radio" name="correct_answer" value="3">
                                                </div>   
                                            </li>
                                            <li> 
                                                <div class="col">
                                                    <textarea class="form-control" name="answer4" id="a4" rows=1 placeholder="Type answer option here" required></textarea>
                                                <div>
                                                <div class="col">
                                                    <input class="form-check-input" type="radio" name="correct_answer" value="4">
                                                </div>  
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
            </div>
        </li>
        <?php endif; ?>
    </ul>
    <!--for spacing at bottom of screen-->
    <div class="p-5"></div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
</body>

</html>