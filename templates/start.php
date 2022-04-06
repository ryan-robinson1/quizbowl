<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Ryan Robinson">
    <meta name="description" content="Finance Manager">
    <title>Join</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <link rel="stylesheet" href="css/join.css">
</head>

<body>
    <div class="container" style="margin-top: 15px;">
        <div class="row justify-content-center">
            <div class="card" style="height:280px">
                <div class="card-body">
                    <h1 style="text-align:center">QuizBowl</h1>
                    <form action="?command=login_" method="post">
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary" style="background-color: #8b71e2 !important;"><span>Host</span></button>
                        </div>
                    </form>
                    <form action="?command=join" method="post">
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary" style="background-color: #8b71e2 !important;"><span>Join</span></button>
                        </div>
                    </form>


                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
</body>

</html>