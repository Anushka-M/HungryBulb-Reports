<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>


    <!--Bootstrap-->

    <link href="_/css/bootstrap.css" rel="stylesheet" media="screen">
    <link href="_/css/mystyles.css" rel="stylesheet" media="screen">


    <!--<link href="_/css/mystyles.css" rel="stylesheet" media="screen">-->

</head>

<body id="login">
<section class="container">
    <div class="entry row" style="padding: 5%">
        <section style="padding: 2%" class="sample col col-lg-6 col-lg-offset-3">


            <?php

            //include 'start.php'

            session_start();


            if (isset($_SESSION['u_name']) && !empty($_SESSION['u_name'])) {

                if ($_SESSION['admin'] == 0) {
                    header('Location: employee.php');
                } else {
                    header('Location: admin.php');
                }

            } else {
                include 'includes/session.php';
            }

            ?>
        </section>


    </div>
</section>
</section>

<script src="_/js/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="_/js/bootstrap.js"></script>
<script src="_/js/myscript.js"></script>
<!--<script src="_/js/myscript.js"></script>-->
</body>


</html>