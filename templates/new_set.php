<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Julian Wilson">
    <meta name="description" content="CS4640 Financial Add Transactions Page">

    <title>Create a new question set</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <link rel="stylesheet" href="css/sets.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <!-- <li class="nav-item px-4">
                    <a class="nav-link active" href="?command=">Home</a>
                </li> -->
                <!-- <li class="nav-item px-4">
                    <a class="nav-link active" href="?command=quizzes">My question sets</a>
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
         <?php if($set_name_created == false): ?>
            <div class="container-fluid py-5">
                <h1 class="display-5 fw-bold text-center">Create a New Set</h1>
            </div>
        <?php endif; ?>
        <?php if($set_name_created == true): ?>
            <div class="container-fluid py-5">
                <h1 class="display-5 fw-bold text-center">Add a New Question to <?php echo $_SESSION["current_set_name"];?></h1>
            </div>
        <?php endif; ?>
    </div>

    <?php echo $error_msg; ?>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-4">
                <?php if($set_name_created == false): ?>
                    <form action="?command=makequiz" method="post">
                        <div class="mb-3">
                            <label for="set_name" class="form-label">New set name</label>
                            <input type="text" class="form-control" id="set_name" name="set_name" required />
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-secondary bg-purple">Submit</button>
                            <a type="button" class="btn btn-secondary bg-purple" href="?command=quizzes">Finish</a>
                        </div>
                    </form>
                <?php endif; ?>
                <?php if($set_name_created == true): ?>
                    <form action="?command=makequiz" method="post">
                        <div class="mb-3">
                            <label for="category" class="form-label">Question</label>
                            <input type="text" class="form-control" id="category" name="question" required />
                        </div>
                        <div class="mb-3">
                            <label for="category" class="form-label">Answer option 1</label>
                            <input type="text" class="form-control" id="category" name="answer1" required />
                        </div>
                        <div class="mb-3">
                            <label for="category" class="form-label">Answer option 2</label>
                            <input type="text" class="form-control" id="category" name="answer2" required />
                        </div>
                        <div class="mb-3">
                            <label for="category" class="form-label">Answer option 3</label>
                            <input type="text" class="form-control" id="category" name="answer3" required />
                        </div>
                        <div class="mb-3">
                            <label for="category" class="form-label">Answer option 4</label>
                            <input type="text" class="form-control" id="category" name="answer4" required />
                        </div>
                        <div class="mb-3">
                            <label for="category" class="form-label">Correct answer</label>
                            <select class="form-select form-select-lg mb-3" id="category" name="correct_answer" required>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                            </select>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-secondary bg-purple">Submit</button>
                            <a type="button" class="btn btn-secondary bg-purple" href="?command=quizzes">Finish</a>
                        </div>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
</body>

</html>