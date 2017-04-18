<section class="data">


<?php
include 'classes/Dbase.php';

session_start();
date_default_timezone_set('Asia/Kolkata');


if (empty($_SESSION['u_name'])) {

    header('Location: index.php');
}

if (!isset($_SESSION['u_name']) || empty($_SESSION['u_name'])) {
    header('Location: index.php');
}


if ($_SESSION['admin'] == 1) {
    die('Access Forbidden');
}


$date;

$url = $_SERVER['REQUEST_URI'];

//echo sizeof(explode("?", $url));
if (sizeof(explode("?", $url)) > 1) {
    $params = explode("?", $url)[1];

    $params = explode("/", $params);

    //die($params);


    if (in_array("date", $params)) {
        $date = date($params[1]);// "hi";
    } else {
        $date = date('Y-m-d', time());
    }
} else {
    $date = date('Y-m-d', time());
}


$objDbase = new Dbase();
//$objDbase2 = new Dbase();

$u_name = $_SESSION['u_name'] or die('error');

$query2 = "SELECT `date` FROM `report`";
$check2 = $objDbase->fetchAll($query2);
$fetch2 = mysqli_fetch_row($check2);
$mindate = $fetch2[0];

$score = 0;
$query4 = "SELECT `score` FROM `report` WHERE `u_name`='{$u_name}'";
$i = 0;
$check4 = $objDbase->fetchAll($query4);
while ($fetch4 = mysqli_fetch_assoc($check4)) {

    if ($fetch4['score'] != NULL) {
        $score += $fetch4['score'];
        $i++;
    }

}

//die("i: ".$i);

if ($i == 0) {
    $avg_score = "n/a";
} else {
    $avg_score = ($score / $i);
}

$project = "";
$report = "";
if (isset($_POST['project-name']) && isset($_POST['report-text'])) {
    $project = $_POST['project-name'];
    $report = $_POST['report-text'];
    if (!empty($project) && !empty($report)) {
        $objDbase->prepareInsert(array(
            'u_name' => $u_name,
            'date' => $date,
            'project' => $project,
            'report_name' => $report
        ));

        $objDbase->insert('report') or die("Some error occured while submitting feedback. Please contact the admin!");

    } else {
        echo 'Fields are not available to you';
    }
}

$query = "SELECT * FROM `report` WHERE `u_name`='{$u_name}' and `date` ='{$date}'";
$check = $objDbase->fetchAll($query);

$query_name = "SELECT `name` FROM `login` WHERE `u_name`='{$u_name}'";
$check_name = mysqli_fetch_assoc($objDbase->fetchAll($query_name));
$full_name = $check_name['name'];


?>






<span style="font-size: medium;">Welcome, <?php echo $full_name . '  '; ?></span>


<span style="font-size: smaller;">(<a href="logout.php">Logout</a>)</span>
<br>
<span style="font-size: smaller;">Average Score: <?php echo round($avg_score, 2); ?></span>
<br><br>

<div class="row">
    <div class="report1 col-lg-6 col-lg-offset-3 col-md-8 col-md-offset-2 col-sm-12" style="background:white; padding: 3%;">

        <div class="row">
            <section class="bold col-lg-3 col-md-2 col-sm-12 col-xs-12 ">
                <span class="hidden-sm hidden-xs pull-right">Date</span>
                <span class="hidden-md hidden-lg pull-left">Date</span>
            </section>

            <div class="col-lg-9 col-md-10 col-sm-12 col-xs-12 down pull-left">

                <?php
                if ($date > $mindate) {


                    ?>

                    <a href="<?php echo explode("?", $url)[0] . "?date/" . date('Y-m-d', strtotime($date . '-1 day')); ?>">Prev </a>

                <?php
                }
                ?>


                <?php echo $date . '  '; ?>


                <?php if ($date < (date('Y-m-d', time()))) {
                    ?>
                    <a href="<?php echo explode("?", $url)[0] . "?date/" . date('Y-m-d', strtotime($date . '+1 day')); ?>">
                        Next</a>
                <?php
                }


                ?>

            </div>
        </div>


        <?php
        $query3 = "SELECT `project` FROM `report` WHERE `u_name`='{$u_name}' AND `project`<>'' ORDER BY `date` DESC LIMIT 1";
        $fetch3 = mysqli_fetch_assoc($objDbase->fetchAll($query3));


        $project = $fetch3['project'];

        if (mysqli_num_rows($check) == 1) {
            $fetch = mysqli_fetch_assoc($check);


            ?>



            <section class="row">
                <div class="bold col-lg-3 col-md-2 col-sm-12 col-xs-12 ">
                    <span class="hidden-sm hidden-xs pull-right">Project</span>
                    <span class="hidden-md hidden-lg pull-left">Project</span>
                </div>

                <div
                    class="col-lg-9 col-md-10 col-sm-12 col-xs-12 down pull-left"><?php if (!empty($fetch['project'])) {
                        echo $fetch['project'];
                    } else {
                        echo $project;
                    }?></div>
            </section>
            <section class="row">
                <div class="bold col-lg-3 col-md-2 col-sm-12 col-xs-12 ">
                    <span class="hidden-sm hidden-xs pull-right">Report</span>
                    <span class="hidden-md hidden-lg pull-left">Report</span>
                </div>
                <div
                    class="col-lg-9 col-md-10 col-sm-12 col-xs-12 down pull-left"><?php if (!empty($fetch['report_name'])) {
                        echo $fetch['report_name'];
                    } else {
                        echo 'Not Submitted';
                    } ?></div>
            </section>
            <section class="row">
                <div class="bold col-lg-3 col-md-2 col-sm-12 col-xs-12 ">
                    <span class="hidden-sm hidden-xs pull-right">Feedback</span>
                    <span class="hidden-md hidden-lg pull-left">Feedback</span>
                </div>
                <div
                    class="col-lg-9 col-md-10 col-sm-12 col-xs-12 down pull-left"><?php if (!empty($fetch['feedback'])) {
                        echo $fetch['feedback'];
                    } else {
                        echo 'Not updated yet';
                    } ?></div>
            </section>
            <section class="row">
                <div class="bold col-lg-3 col-md-2 col-sm-12 col-xs-12 ">
                    <span class="hidden-sm hidden-xs pull-right">Score</span>
                    <span class="hidden-md hidden-lg pull-left">Score</span>
                </div>
                <div class="col-lg-9 col-md-10 col-sm-12 col-xs-12 down pull-left down"><?php echo $fetch['score']; ?></div>
            </section>



        <?php
        } else {


            if ($date < date('Y-m-d', time())) {
                ?>

                <section class="row">
                    <section class="col-lg-9 col-lg-offset-3 col-md-8 col-md-offset-2 col-sm-12 col-xs-12 down">
                        No Fields to display.
                    </section>
                </section>
            <?php
            } else {
                ?>





                <form action="employee.php" method="POST">

                    <fieldset class="form-group">
                        <section class="row">
                            <div class="bold col-lg-3 col-md-2 col-sm-12 col-xs-12 ">
                                <label for="project-name"
                                       class="hidden-sm hidden-xs pull-right control-label">Project</label>
                                <label for="project-name"
                                       class="hidden-md hidden-lg pull-left control-label">Project</label>
                            </div>
                            <div class="col-lg-9 col-md-10 col-sm-12 col-xs-12 down pull-left">
                                <input type="text" class="form-control" name="project-name" id="project-name"
                                       value="<?php echo $project; ?>">
                            </div>
                        </section>

                        <section class="row">
                            <div class="bold col-lg-3 col-md-2 col-sm-12 col-xs-12 ">
                                <label for="report-text"
                                       class="hidden-sm hidden-xs pull-right control-label">Reprort</label>
                                <label for="report-text"
                                       class="hidden-md hidden-lg pull-left control-label">Reprort</label>
                            </div>
                            <div class="col-lg-9 col-md-10 col-sm-12 col-xs-12 down pull-left">
                                <textarea id="report-text" name="report-text" rows="7" type="input"
                                          class="form-control"></textarea>
                            </div>
                        </section>

                        <p>
                            <button type="submit" name="save" class="btn btn-primary btn-large pull-right">Submit
                            </button>
                        </p>


                    </fieldset>
                </form>

            <?php

            }


        }
        ?>
    </div>
</div>
</section>

<?php

?>

<section>
