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

    <div class="container">
        <div class="dropdown p-4 text-center">
            <button class="btn btn-lg btn-secondary bg-purple dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                Vocab chapter 1
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                <li><a class="dropdown-item" href="#">Vocab chapter 2</a></li>
                <li><a class="dropdown-item" href="#">Capitals</a></li>
                <li><a class="dropdown-item" href="#">Old question set</a></li>
            </ul>

            <form action="?command=startgame" method="post" style="display: inline;">
                <button type="submit" class="btn btn-lg btn-success">Host Quiz!</button>
            </form>


            <form action="?command=makequiz" method="post" style="display: inline;">
                <button class="btn btn-lg btn-secondary" type="submit">
                    Make Quiz!
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

        <li class="list-group-item py-0 border-0">
            <div class="container">
                <div class="row">
                    <div class="card col-md-6 p-0 border-0">
                        <div class="card-body p-5 border border-3 rounded">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    The D1 and D2 Fraunhofer spectral lines form this element’s namesake “doublet.” This metal can be produced via the Castner process or a Downs cell, and its azide is used in the airbags of cars. This element glows bright (*) yellow in the flame test, and
                                    baking soda is this element’s bicarbonate. For 10 points, name this element which makes up table salt with chloride, has atomic number 11, and has atomic symbol Na.
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="card col-md-6 p-0 border-0">
                        <div class="card-body p-5 border border-3 rounded">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    Sodium
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </li>
        <li class="list-group-item py-0 border-0">
            <div class="container">
                <div class="row">
                    <div class="card col-md-6 p-0 border-0">
                        <div class="card-body p-5 border border-3 rounded">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    The D1 and D2 Fraunhofer spectral lines form this element’s namesake “doublet.” This metal can be produced via the Castner process or a Downs cell, and its azide is used in the airbags of cars. This element glows bright (*) yellow in the flame test, and
                                    baking soda is this element’s bicarbonate. For 10 points, name this element which makes up table salt with chloride, has atomic number 11, and has atomic symbol Na.
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="card col-md-6 p-0 border-0">
                        <div class="card-body p-5 border border-3 rounded">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    Sodium
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </li>
    </ul>
    <!--for spacing at bottom of screen-->
    <div class="p-5"></div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
</body>

</html>