<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Ryan Robinson">
    <title>Answer</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="css/buzzer.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>


<body>
    <header>
        <h2>PIN: <?= $_SESSION["pin"] ?></h2>
        <hr>
    </header>
    <div class="container">
        <div class="col-12">
            <div class="col-6">
                <div class="button_padding">
                    <button class="btn btn-danger" style="background-color: #e21b3c !important;" onclick='sendAnswer("1")' id="btn">A</button>
                </div>
            </div>
            <div class="col-6">
                <div class="button_padding">
                    <button class="btn btn-success" style="background-color: #26890c !important;" onclick='sendAnswer("2")' id="btn2">B</button>
                </div>
            </div>

        </div>
        <div class="col-12">
            <div class="col-6">
                <div class="button_padding">
                    <button class="btn btn-warning" style="background-color: #ffa602 !important;" onclick='sendAnswer("3")' id="btn3">C</button>
                </div>
            </div>
            <div class="col-6">
                <div class="button_padding">
                    <button class="btn btn-primary" style="background-color: #1368ce !important;" onclick='sendAnswer("4")' id="btn4">D</button>
                </div>
            </div>

        </div>
    </div>


    <footer>
        <div class="footer-container">
            <hr>
            <div class="col-12">
                <div class="col-6" id="team">
                    <h2>Blue Team</h2>
                </div>
                <div class="col-6" id="score">
                    <h2 style="float: right; padding-right: 20px;">750</h2>
                </div>

            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    </footer>

</body>
<script type="text/javascript">
    var team = "0";
    var time = 20;

    function getTeam() {
        var ajax = new XMLHttpRequest();
        ajax.open("GET", "?command=get_team", true);
        ajax.responseType = "json";
        ajax.send(null);
        ajax.addEventListener("load", function() {
            if (this.status == 200) { // worked 
                team = JSON.parse(JSON.stringify(this.response));
                console.log(team);
            }
        });

        // What happens on error
        ajax.addEventListener("error", function() {
            console.log("error");
        })

    };
    const sendAnswer = (answerNum) => {

        document.getElementById("btn").disabled = true;
        document.getElementById("btn2").disabled = true;
        document.getElementById("btn3").disabled = true;
        document.getElementById("btn4").disabled = true;

        var post = {
            team: team,
            answer: answerNum
        }

        var saveData = $.ajax({
            type: 'POST',
            url: "?command=send_answer",
            data: post,
            dataType: "text"
        });


    };

    getTeam();
</script>

</html>