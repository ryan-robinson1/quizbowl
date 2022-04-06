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
        
         <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" 
            rel="stylesheet" 
            integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" 
            crossorigin="anonymous">  
         <link rel="stylesheet" href="sets.css"> 
     </head>  

     <body>
         <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
               <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                  <li class="nav-item px-4">
                     <a class="nav-link active" href="index.html">Home</a>
                  </li>
                  <li class="nav-item px-4">
                     <a class="nav-link active" href="sets.html">Question sets</a>
                  </li>
               </ul>
               <a class ="d-flex btn btn-light px-4" href="?command=login">Sign in</a>
            </div>
         </nav>

         <div class="p-5 mb-4 bg-light rounded-3">
            <div class="container-fluid py-5">
               <h1 class="display-5 fw-bold text-center">My Question Sets</h1>
            </div>
         </div>

         <div class="container"> 
            <div class="dropdown p-4 text-center">
               <form action="?command=sets" method="post">
                  <select class="form-select form-select-lg mb-3" name = "qset">
                     <option selected>
                        <?php
                           echo $qset;
                        ?>
                     </option>
                     <?php
                        foreach($sets_list as $set) {
                           echo "<option value = \"" . $set["set_id"] . "\">" . $set["set_name"] . "</option>";
                        }
                     ?>
                  </select>
                  <div class="text-center">                
                        <button type="submit" class="btn btn-secondary">Select question set</button>
                  </div>
                  <!-- <button class="btn btn-lg btn-secondary bg-purple dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"> -->
                  <!-- <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                 
                  <li><a class="dropdown-item" href="#">Vocab chapter 2</a></li>
                  <li><a class="dropdown-item" href="#">Capitals</a></li>
                  <li><a class="dropdown-item" href="#">Old question set</a></li> -->
               </form>
               <!-- <form action="?command=newset" method="post">
                  <a type = "submit" class ="btn btn-light px-4" href="?command=newset">Add new question to selected set</a>
               </form> -->
            </div>
         </div>
         <div class="container">
            <table class="table"> 
               <thead class="thead-dark"> 
                  <tr>
                     <th scope="col">Question</th>
                     <th scope="col">Answers (correct in bold)</th>
                  </tr>
               </thead>
               <tbody>
                  <?php foreach ($question_list as $question): ?>
                     <tr>
                        <td><?php echo $question["question"]?></td>
                        <td>
                           <ul>
                              <li>
                                 <?php if($question["correct_answer"] == 1) echo "<b>";
                                        echo "a. " . $question["answer1"];
                                        if($question["correct_answer"] == 1) echo "</b>";
                                  ?>
                             </li>
                             <li>
                                 <?php if($question["correct_answer"] == 2) echo "<b>";
                                        echo "b. " . $question["answer2"];
                                        if($question["correct_answer"] == 2) echo "</b>";
                                  ?>
                                 
                             </li>
                             <li>
                                 <?php if($question["correct_answer"] == 3) echo "<b>";
                                        echo "c. " . $question["answer3"];
                                        if($question["correct_answer"] == 3) echo "</b>";
                                  ?>
                                 
                             </li>
                             <li>
                                  <?php if($question["correct_answer"] == 4) echo "<b>";
                                        echo "d. " . $question["answer4"];
                                        if($question["correct_answer"] == 4) echo "</b>";
                                  ?>  
                             </li>
                            </ul>
                        </td>
                     </tr>
                  <?php endforeach; ?>

               </tbody>
            </table>
         </div>

         <!-- <ul class="list-group"> 
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
                     <?php

                     // echo  "<div class=\"card col-md-6 p-0 border-0\">
                     // <div class=\"card-body p-5 border border-3 rounded\">
                     //    <ul class=\"list-group list-group-flush\">
                     //       <li class=\"list-group-item\">" ;


                     // echo     "</li></ul> </div> </div>";

                     ?>

                     <div class="card col-md-6 p-0 border-0">
                           <div class="card-body p-5 border border-3 rounded">
                              <ul class="list-group list-group-flush">
                                 <li class="list-group-item">
                                    The D1 and D2 Fraunhofer spectral lines form this element’s namesake “doublet.” 
                                    This metal can be produced via the Castner process or a Downs cell, 
                                    and its azide is used in the airbags of cars. 
                                    This element glows bright (*) yellow in the flame test,
                                    and baking soda is this element’s bicarbonate. 
                                    For 10 points, name this element which makes up table salt with chloride, 
                                    has atomic number 11, and has atomic symbol Na.
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
                                    The D1 and D2 Fraunhofer spectral lines form this element’s namesake “doublet.” 
                                    This metal can be produced via the Castner process or a Downs cell, 
                                    and its azide is used in the airbags of cars. 
                                    This element glows bright (*) yellow in the flame test,
                                    and baking soda is this element’s bicarbonate. 
                                    For 10 points, name this element which makes up table salt with chloride, 
                                    has atomic number 11, and has atomic symbol Na.
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
         </ul>  -->
         <!--for spacing at bottom of screen-->
         <div class="p-5"></div>   

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
     </body>
 </html>