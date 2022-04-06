<!DOCTYPE html>
<html lang="en">
 <!-- https://cs4640.cs.virginia.edu/jww2rfe/project/sprint2 -> navigate to html pages -->

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Ryan Robinson">
    <meta name="description" content="Join Game page for CS4640 project">
    <meta name="keywords" content="school project">
    <title>Join</title>
    <link rel="stylesheet" href="join.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
</head>
    <body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
               <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                  <li class="nav-item px-4">
                     <a class="nav-link active" href="?command=home">Home</a>
                  </li>
                  <li class="nav-item px-4">
                     <a class="nav-link active" href="?command=sets">Question sets</a>
                  </li>
               </ul>
               <!--placeholder reference until we implement sign in page-->
               <a class ="d-flex btn btn-light px-4" href="?command=login">Sign in</a>
            </div>
         </nav>
        <div class="centered">
            <div style="text-align: center; padding-bottom: 20px;">
                <h2>Kahuut</h2>
            </div>
            <form class="form-floating mb-3" style="width:300px;" action = "?command=joingame" method="post">
                <div>
                    <input type="number" class="form-control" id="floatingInput" name = "gamepin">
                    <label for="floatingInput">Game PIN</label>
                </div>
                <div>
                    <button type="submit" style="width:300px; height: 50px" class="btn btn-secondary">Join Game</button>
                </div>
            </form>
            <!--<a href="?command=joingame" style="width:300px; height: 50px" class="btn btn-secondary">Enter</a>-->
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ"
            crossorigin="anonymous"></script>
    </body>
</html>