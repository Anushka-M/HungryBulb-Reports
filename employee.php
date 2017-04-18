<!DOCTYPE html>
<html lang="en">
<head>
    <title>Dashboard</title>
    <meta charset="utf-8"/>

    <meta name="viewport" content="width=device-width, initial-scale=1 ">
    <title>User Login</title>

    <!--<link href='https://fonts.googleapis.com/css?family=Lora:400,700,700italic' rel='stylesheet' type='text/css'>-->
    <!--Bootstrap-->

    <link href="_/css/bootstrap.css" rel="stylesheet" media="screen">
    <link href="_/css/mystyles.css" rel="stylesheet" media="screen">

</head>

<body style="background:#fafafa;">

<div class="container">
    <section class="header-page row">
        <div class="col col-lg-2 col-md-2 col-sm-3 col-xs-12 pull-left centered">
            <img id="header-logo" src="images/logo.jpg">
        </div>

        <div id="header-title" class="col-lg-8 col-md-8 col-sm-7 centered">
            <h3>REPORT PAGE</h3>
            <h5>
                <?php echo date('Y-M-d (D)', time()); ?>
            </h5>
        </div>
    </section>


    <div class="fields row">
        <section class="data col col-lg-12">


            <?php

            include 'includes/employee_data.php';
            ?>
        </section>
    </div>
    <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>-->
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="_/js/bootstrap.js"></script>
    <script src="_/js/myscript.js"></script>
    <!--<script src="_/js/myscript.js"></script>-->

</div>
</body>
</html>