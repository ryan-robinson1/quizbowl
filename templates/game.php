<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Julian Wilson">
    <title>Game</title>
    <meta name="description" content="Lobby page for CS4640 project">
    <meta name="keywords" content="school project">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="css/game.css">
</head>

<body>

    <header>


        <h2 style="display: inline-block;">PIN: <?= $pin ?></h2>
        <h2 style=" float:right; padding-right:20px">TIME: 20</h2>
        <hr>
        <h3 style="text-align:center; padding-top:36px; font-size:35px;"><?= $question["question"] ?></h3>
        <div class="row" style="text-align:center; margin-top: 200px">
            <div class="col-12">
                <div class="col-6">
                    <div class="button_padding">
                        <button class="btn btn-danger" style="background-color: #e21b3c !important;">
                            <div style="text-align:left">A. <?= $question["answer1"] ?></div>
                        </button>
                    </div>
                </div>
                <div class="col-6">
                    <div class="button_padding">
                        <button class="btn btn-success" style="background-color: #26890c !important;">
                            <div style="text-align:left">B. <?= $question["answer2"] ?></div>
                        </button>
                    </div>
                </div>

            </div>
            <div class="col-12">
                <div class="col-6">
                    <div class="button_padding">
                        <button class="btn btn-warning" style="background-color: #ffa602 !important;">
                            <div style="text-align:left">C. <?= $question["answer3"] ?></div>
                        </button>
                    </div>
                </div>
                <div class="col-6">
                    <div class="button_padding">
                        <button class="btn btn-primary" style="background-color: #1368ce !important;">
                            <div style="text-align:left">D. <?= $question["answer4"] ?></div>
                        </button>
                    </div>
                </div>

            </div>
        </div>

    </header>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
</body>

</html>