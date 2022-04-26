<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <meta name="author" content="Julian Wilson">
   <title>Lobby</title>
   <meta name="description" content="Lobby page for CS4640 project">
   <meta name="keywords" content="school project">

   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
   <link rel="stylesheet" href="css/lobby.css">
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
               <?= $_SESSION["username"] ?>
            </button>

            <ul class="dropdown-menu dropdown-menu-end">
               <li><a class="dropdown-item" href="?command=logout">Log Out</a></li>
            </ul>
         </div>
      </div>
   </nav>

   <header>
      <h2>PIN: <?= $_SESSION["pin"] ?></h2>
      <hr>
   </header>

   <div class="container">
      <div class="row">
         <div class="card col-md-6 p-5 border-0">
            <div class="card-body p-5 border border-primary border-3 rounded">
               <h3 class="card-title bg-primary text-light p-3">
                  Blue Team
               </h3>

               <ul class="list-group list-group-flush" id="blue_players">
                  <!-- <?php foreach ($_SESSION["blue_players"] as $player) : ?>
                     <li class="list-group-item">
                        <?= $player["username"] ?>
                     </li>
                  <?php endforeach; ?> -->
               </ul>
            </div>
         </div>

         <div class="card col-md-6 p-5 border-0">
            <div class="card-body p-5 border border-danger border-3 rounded">
               <h3 class="card-title bg-danger text-light p-3">
                  Red Team
               </h3>
               <ul class="list-group list-group-flush" id="red_players">
                  <!-- <?php foreach ($_SESSION["red_players"] as $player) : ?>
                     <li class="list-group-item">
                        <?= $player["username"] ?>
                     </li>
                  <?php endforeach; ?> -->
               </ul>
            </div>
         </div>
      </div>
   </div>
   <?php if (isset($_SESSION["username"]) && isset($_SESSION["host"]) &&  $_SESSION["host"] == $_SESSION["username"]) : ?>
      <div class="container">
         <div class="row p-5">
            <form action="?command=in_session" method="post">
               <div class="text-center">
                  <button type="submit" class="btn btn-success" style="font-size:40px"><span>Begin!</span></button>
               </div>
            </form>

         </div>
      </div>
   <?php endif; ?>

   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
   <script type="text/javascript">
      var players = null;

      var red = [];
      var blue = [];
      getPlayers();

      function getPlayers() {
         var ajax = new XMLHttpRequest();
         ajax.open("GET", "?command=get_players", true);
         ajax.responseType = "json";
         ajax.send(null);
         ajax.addEventListener("load", function() {
            if (this.status == 200) { // worked 
               players = JSON.parse(JSON.stringify(this.response));
               // console.log(players);
               updateLobby();
            }
         });

         // What happens on error
         ajax.addEventListener("error", function() {
            console.log("error");
         })
      }

      function updateLobby() {

         for (let p of players[0]) {
            if (!blue.includes(p["username"])) {
               $("#blue_players").append("<li class='list-group-item'>" + p["username"] + "</li>");
               blue.push(p["username"])
            }

         }
         for (let p of players[1]) {
            if (!red.includes(p["username"])) {
               $("#red_players").append("<li class='list-group-item'>" + p["username"] + "</li>");
               red.push(p["username"])
            }
         }

      }


      window.setInterval(function() {
         getPlayers();
      }, 2000);
   </script>
</body>

</html>