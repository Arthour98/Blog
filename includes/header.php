<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
        crossorigin="anonymous">
    <link rel="stylesheet" href="../styles.css">
    <title>Document</title>
</head>

<body>
    <div class="loading-screen" id="loading-screen">
        <div class="loader">
            <i class="fa-solid fa-spinner"></i>
            <p>Loading...</p>
        </div>
    </div>

    <div class="content" id="body-content">
        <div class="main-content ">

            <div class="menu p-4">
                <div class="container-fluid p-0">
                    <div class="row d-flex align-items-center row-gap-20">

                        <div class="col-xl-2 col-lg-2 col-md-3  col-sm-12 d-flex align-items-center gap-20">
                            <?php if (isset($_SESSION["user_id"])): ?>
                                <?php echo '
                            <i class="fa-solid fa-user  border border-3 border-success  p-3 rounded-5
                          " data-bs-toggle="tooltip" data-bs-placemenent="bottom" title=' . $user["user_name"] . '>

                            </i>
                            <h3 class="text-light">' . '#' . $user["user_name"] . '</h3>' ?>
                            <?php endif; ?>
                        </div>
                        <div class="col-xl-5 col-lg-5 col-md-7  col-sm-12 d-flex justify-content-around">
                            <a href="index.php">Home</a>
                            <a href="gallery.php">Gallery</a>
                            <a href="calendar.php">Games</a>
                            <a href="quiz.php">Quiz</a>
                        </div>
                        <div class="col-xl-5 col-lg-4 col-md-2  col-sm-12 d-flex justify-content-center gap-20">
                            <?php if (!isset($_SESSION["user_id"])): ?>
                                <a href="login.php">Login</a>
                            <?php endif; ?>
                            <?php if (isset($_SESSION["user_id"])): ?>
                                <a href="logout.php">Logout</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>