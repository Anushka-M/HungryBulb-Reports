<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <title>Dashboard</title>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>

    <link href='https://fonts.googleapis.com/css?family=Lora:400,700,700italic' rel='stylesheet' type='text/css'
    <!--Bootstrap-->


    <!-- Include all compiled plugins (below), or include individual files as needed -->

    <!--<script src="_/js/myscript.js"></script>-->


    <link href="_/css/bootstrap.css" rel="stylesheet" media="screen">
    <link href="_/css/mystyles.css" rel="stylesheet" media="screen">
    <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>-->
</head>



<?php


include 'classes/Dbase.php';
session_start();
date_default_timezone_set('Asia/Kolkata');
if ($_SESSION['admin'] == 0) {
    die('Access Forbidden');
}

if (!isset($_SESSION['u_name']) || empty($_SESSION['u_name'])) {
    header('Location: index.php');
}

$url = $_SERVER['REQUEST_URI'];
//die($url);


if (sizeof(explode('?', $url)) > 1) {
    $params = explode('?', $url)[1];

    $params = explode('/', $params);
    $ind1 = array_search('date', $params);

    if (in_array("date", $params)) {
        $date = $params[$ind1 + 1]; // "hi";


    } else {
        $date = date('Y-m-d', time());
    }
} else {
    $date = date('Y-m-d', time());
}


if (sizeof(explode('?', $url)) > 1) {
$params = explode('?', $url)[1];

$params = explode('/', $params);


if (sizeof($params) % 2 != 0) {
    die('Insufficient arguments');
}

$ind1 = array_search('date', $params);

$ind2 = array_search('u_name', $params);


$date = $params[$ind1 + 1];
$name = $params[$ind2 + 1];


$objd = new Dbase();


$score = 0;
$query4 = "SELECT `score` FROM `report` WHERE `u_name`='{$name}'";
$i = 0;
$check4 = $objd->fetchAll($query4);
while ($fetch4 = mysqli_fetch_assoc($check4)) {

    if ($fetch4['score'] != NULL) {
        $score += $fetch4['score'];
        $i++;
    }

}
$avg_score = ($score / $i);



$feed = "";
$score = "";

$query2 = "SELECT * FROM `report` WHERE `u_name`='{$name}' AND `date`='{$date}'";
//die($query2);

$check2 = $objd->fetchAll($query2) or die('error');
$fetch2 = mysqli_fetch_assoc($check2);


if (isset($_POST['feed']) && isset($_POST['score'])) {
    $feed = $_POST['feed'];
    $score = $_POST['score'];


    if (!empty($fetch2)) {

        //die($feed);

        //die("uodate");

        $objd->prepareUpdate(array(
            'feedback' => $feed,
            'score' => $score
        ), array(
            'date' => $date,
            'u_name' => $name
        ));

        //$objd->pre();

        $objd->update('report') or die("Some error occured while submitting feedback. Please contact the admin!");
        //header('Locaton: admin.php?date/'.$date.'/uname/'.$name);
    } else if (empty($fetch2)) {


        $objd->prepareInsert(array(

            'feedback' => $feed,
            'score' => $score,
            'date' => $date,
            'u_name' => $name,
            'report_name' => 'Report was not submitted.'

        ));

        $objd->insert('report') or die("Some error occured while submitting feedback. Please contact the admin!");
    }


}

$query2 = "SELECT * FROM `report` WHERE `u_name`='{$name}' AND `date`='{$date}'";
//die($query2);

$check2 = $objd->fetchAll($query2) or die('error');
$fetch2 = mysqli_fetch_assoc($check2);

?>
<body style="background:#fafafa;" id="admin_info">

<div class="container">

<section class="header-page row">
    <div class="col col-lg-2 col-md-2 col-sm-3 col-xs-12 pull-left centered">
        <img id="header-logo" src="images/logo.jpg">
    </div>

    <div id="header-title" class="col-lg-8 col-md-8 col-sm-7 centered">
        <h3>FEEDBACK PAGE</h3>
        <h5>
            <?php echo date('Y-M-d (D)', time()); ?>
        </h5>
    </div>
</section>

<div class="fields rows">
<span style="font-size: medium;">Welcome, <?php echo $_SESSION['name'] . '  '; ?></span>
<span style="font-size: smaller;">(<a href="logout.php">Logout</a>)</span>

<br><br>

<section class="row">
    <div class="col-lg-2 col-lg-offset-2">
        <?php $query = "SELECT * FROM `login` WHERE `admin`=0";
        $check = $objd->fetchAll($query);

        ?>
        <div class=" dropdown">
            <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">
                <?php while ($fetch = mysqli_fetch_assoc($check)) {
                    if ($fetch['u_name'] == $name) {
                        echo $fetch['name'];
                    }

                } ?><span class="caret"></span>
            </button>
            <ul class="dropdown-menu" role="menu">

                <?php
                $query = "SELECT * FROM `login` WHERE `admin`=0";
                $objd = new Dbase();
                $check = $objd->fetchAll($query);
                while ($fetch5 = mysqli_fetch_assoc($check)) {


                    ?>
                    <li><a
                        href="<?php echo explode("?", $url)[0] . '?u_name/' . $fetch5['u_name'] . '/date/' . date('Y-m-d', time()); ?>"><?php echo $fetch5['name']; ?></a>
                    </li><?php
                }
                ?>


            </ul>

        </div>
        <span style="font-size: smaller;">Average Score: <?php echo round($avg_score, 2); ?></span>


    </div>
</section>
<br>

<section class="row">
<div class="report1 col-lg-6 col-lg-offset-3 col-md-8 col-md-offset-2 col-sm-12" style="background:white; padding: 3%;">

<section class="row">
    <div class="bold col-lg-3 col-md-2 col-sm-12 col-xs-12 ">
        <span class="hidden-sm hidden-xs pull-right">Date</span>
        <span class="hidden-md hidden-lg pull-left">Date</span>
    </div>

    <div class="col-lg-9 col-md-10 col-sm-12 col-xs-12 down pull-left">
        <?php
        if ($date > '2016-06-17') {


            ?>

            <a href="<?php echo explode("?", $url)[0] . "?u_name/" . $name . "/date/" . date('Y-m-d', strtotime($date . '-1 day')); ?>">Prev </a>

        <?php
        }
        ?>


        <?php echo $date . '  '; ?>


        <?php if ($date < (date('Y-m-d', time()))) {
            ?>
            <a href="<?php echo explode("?", $url)[0] . "?u_name/" . $name . "/date/" . date('Y-m-d', strtotime($date . '+1 day')); ?>">Next</a>
        <?php
        }


        ?>
    </div>
</section>

<?php



if (empty($fetch2['project'])) {
    $query3 = "SELECT `project` FROM `report` WHERE `u_name`='{$name}' AND `project`<>'' ORDER BY `date` DESC LIMIT 1";
    $check3 = $objd->fetchAll($query3);
    $fetch3 = mysqli_fetch_assoc($check3);

    $project = $fetch3['project'];
}

if (!empty($fetch2)) {
    if (empty($fetch2['project'])) {
        $query3 = "SELECT `project` FROM `report` WHERE `u_name`='{$name}' AND `project`<>'' ORDER BY `date` DESC LIMIT 1";
        $check3 = $objd->fetchAll($query3);
        $fetch3 = mysqli_fetch_assoc($check3);

        $project = $fetch3['project'];
    }


    if (!empty($fetch2['feedback'])) {

        ?>

        <section class="row">
            <div class="bold col-lg-3 col-md-2 col-sm-12 col-xs-12 ">
                <span class="hidden-sm hidden-xs pull-right">Project</span>
                <span class="hidden-md hidden-lg pull-left">Project</span>
            </div>

            <div class="col-lg-9 col-md-10 col-sm-12 col-xs-12 down pull-left">
                <?php if (empty($fetch2['project'])) {
                    echo $project;
                } else {
                    echo $fetch2['project'];
                }
                ?>
            </div>
        </section>

        <section class="row">
            <div class="bold col-lg-3 col-md-2 col-sm-12 col-xs-12 ">
                <span class="hidden-sm hidden-xs pull-right">Report</span>
                <span class="hidden-md hidden-lg pull-left">Report</span>
            </div>

            <div
                class="col-lg-9 col-md-10 col-sm-12 col-xs-12 down pull-left">
                <?php if (empty($fetch2['report_name'])) {
                    echo "Not submitted yet.";
                } else {
                    echo $fetch2['report_name'];
                }
                ?>
            </div>
        </section>




        <form action="<?php echo explode('?', $url)[0] . "?date/" . $date . "/u_name/" . $name ?>" method="POST">
            <fieldset class="form-group ">
                <section class="row">
                    <div class="bold col-lg-3 col-md-2 col-sm-12 col-xs-12 ">
                        <label for="feed"
                               class="hidden-sm hidden-xs pull-right control-label">Feedback</label>
                        <label for="feed"
                               class="hidden-md hidden-lg pull-left control-label">Feedback</label>
                    </div>

                    <div class="col-lg-9 col-md-10 col-sm-12 col-xs-12 down pull-left">
                        <textarea class="form-control" rows="5" name="feed"
                                  id="feed"><?php echo $fetch2['feedback']; ?></textarea>
                    </div>
                </section>

                <section class="row">
                    <div class="bold col-lg-3 col-md-2 col-sm-12 col-xs-12 ">
                        <label for="score"
                               class="hidden-sm hidden-xs pull-right control-label">Score</label>
                        <label for="score"
                               class="hidden-md hidden-lg pull-left control-label">Score</label>
                    </div>
                    <div class="col-lg-9 col-md-10 col-sm-12 col-xs-12 down pull-left">
                        <input class="form-control" name="score" id="score" type="number" min="0" max="5"
                               value="<?php echo $fetch2['score']; ?>">
                    </div>
                </section>

                <p>
                    <button type="submit" name="save" class="btn btn-primary pull-right">Submit</button>
                </p>

            </fieldset>
        </form>
    <?php
    } else {

        //
        ?>

        <section class="row">
            <div class="bold col-lg-3 col-md-2 col-sm-12 col-xs-12 ">
                <span class="hidden-sm hidden-xs pull-right">Project</span>
                <span class="hidden-md hidden-lg pull-left">Project</span>
            </div>

            <div class="col-lg-9 col-md-10 col-sm-12 col-xs-12 down pull-left">
                <?php if (empty($fetch2['project'])) {
                    echo $project;
                } else {
                    echo $fetch2['project'];
                }
                ?>
            </div>
        </section>

        <form action="<?php echo explode('?', $url)[0] . "?date/" . $date . "/u_name/" . $name ?>" method="POST">
            <fieldset class="form-group ">
                <section class="row">
                    <div class="bold col-lg-3 col-md-2 col-sm-12 col-xs-12 ">
                        <label for="feed"
                               class="hidden-sm hidden-xs pull-right control-label">Feedback</label>
                        <label for="feed"
                               class="hidden-md hidden-lg pull-left control-label">Feedback</label>
                    </div>

                    <div class="col-lg-9 col-md-10 col-sm-12 col-xs-12 down pull-left">
                        <textarea class="form-control" rows="5" name="feed"
                                  id="feed"><?php echo $fetch2['feedback']; ?></textarea>
                    </div>
                </section>

                <section class="row">
                    <div class="bold col-lg-3 col-md-2 col-sm-12 col-xs-12 ">
                        <label for="score"
                               class="hidden-sm hidden-xs pull-right control-label">Score</label>
                        <label for="score"
                               class="hidden-md hidden-lg pull-left control-label">Score</label>
                    </div>
                    <div class="col-lg-9 col-md-10 col-sm-12 col-xs-12 down pull-left">
                        <input class="form-control" name="score" id="score" type="number" min="0" max="5"
                               value="<?php echo $fetch2['score']; ?>">
                    </div>
                </section>

                <p>
                    <button type="submit" name="save" class="btn btn-primary pull-right">Submit</button>
                </p>

            </fieldset>
        </form>

    <?php
    }
} else {
?>
<section class="row">
    <div class="bold col-lg-3 col-md-2 col-sm-12 col-xs-12 ">
        <span class="hidden-sm hidden-xs pull-right">Project</span>
        <span class="hidden-md hidden-lg pull-left">Project</span>
    </div>

    <div class="col-lg-9 col-md-10 col-sm-12 col-xs-12 down pull-left">
        <?php if (empty($fetch2['project'])) {
            echo $project;
        } else {
            echo $fetch2['project'];
        }
        ?>
    </div>
</section>

<section class="row">
    <div class="bold col-lg-3 col-md-2 col-sm-12 col-xs-12 ">
        <span class="hidden-sm hidden-xs pull-right">Report</span>
        <span class="hidden-md hidden-lg pull-left">Report</span>
    </div>

    <div class="col-lg-9 col-md-10 col-sm-12 col-xs-12 down pull-left">
        Not submitted yet.
    </div>
</section>

<form action="<?php echo explode('?', $url)[0] . "?date/" . $date . "/u_name/" . $name ?>" method="POST">
    <fieldset class="form-group ">
        <section class="row">
            <div class="bold col-lg-3 col-md-2 col-sm-12 col-xs-12 ">
                <label for="feed"
                       class="hidden-sm hidden-xs pull-right control-label">Feedback</label>
                <label for="feed"
                       class="hidden-md hidden-lg pull-left control-label">Feedback</label>
            </div>

            <div class="col-lg-9 col-md-10 col-sm-12 col-xs-12 down pull-left">
                <textarea class="form-control" rows="5" name="feed"
                          id="feed"><?php echo $fetch2['feedback']; ?></textarea>
            </div>
        </section>

        <section class="row">
            <div class="bold col-lg-3 col-md-2 col-sm-12 col-xs-12 ">
                <label for="score"
                       class="hidden-sm hidden-xs pull-right control-label">Score</label>
                <label for="score"
                       class="hidden-md hidden-lg pull-left control-label">Score</label>
            </div>
            <div class="col-lg-9 col-md-10 col-sm-12 col-xs-12 down pull-left">
                <input class="form-control" name="score" id="score" type="number" min="0" max="5"
                       value="<?php echo $fetch2['score']; ?>">
            </div>
        </section>

        <p>
            <button type="submit" name="save" class="btn btn-primary pull-right">Submit</button>
        </p>

    </fieldset>
</form>
</div>
</section>

<?php

}


}


?>

</div>
</div>
<script src="_/js/jquery.min.js"></script>
<script src="_/js/bootstrap.js"></script>
<script src="_/js/myscript.js"></script>
</body>

</html>

