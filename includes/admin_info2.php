<?php

include 'classes/Dbase.php';
session_start();

if ($_SESSION['admin'] == 0) {
    die('Access Forbidden');
}


//die("11");
$url = $_SERVER['REQUEST_URI'];


if (sizeof(explode('?', $url)) > 1) {
    $params = explode('?', $url)[1];
    $params = explode('/', $url);

    if (in_array("date", $params)) {
        $date = date($params[1]);// "hi";
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

    $ind2 = array_search('uname', $params);


    $date = $params[$ind1 + 1];
    $name = $params[$ind2 + 1];

    ?>
    <header id="head1">

        <h1>FEEDBACK PAGE</h1>
    </header>
    <table colspan="10" cellpadding="10" cellspacing="15">
    <tr>
        <td>DATE:</td>
        <?php
        if ($date > '2016-06-17') {
            ?><a
            href="<?php echo explode("?", $url)[0] . "?date/" . date('Y-m-d', strtotime($date . '-1 day')) . "/uname/" . $name; ?>">
                Prev</a><br><br>
        <?php } ?>
        <td><?php echo $date ?></td>
        <?php if ($date < date('Y-m-d', time())) {
            ?><a
            href="<?php echo explode("?", $url)[0] . "?date/" . date('Y-m-d', strtotime($date . '+1 day')) . "/uname/" . $name; ?>">
                Next</a>
        <?php
        }
        ?>
    </tr>
    <tr>
        <td>Name:</td>
        <td><?php echo $name ?></td>
    </tr>
    </table><?php

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
                'u_name' => $name

            ));

            $objd->insert('report') or die("Some error occured while submitting feedback. Please conta ct the admin!");
        }


    }

    $query2 = "SELECT * FROM `report` WHERE `u_name`='{$name}' AND `date`='{$date}'";
    //die($query2);

    $check2 = $objd->fetchAll($query2) or die('error');
    $fetch2 = mysqli_fetch_assoc($check2);// or die('error11');
    if (empty($fetch2['project'])) {
        $query3 = "SELECT `project` FROM `report` WHERE `u_name`='{$name}' AND `project`<>'' ORDER BY `date` DESC LIMIT 1";
        $check3 = $objd->fetchAll($query3);
        $fetch3 = mysqli_fetch_assoc($check3);

        $project = $fetch3['project'];
    }

    if (!empty($fetch2)) {


        if (!empty($fetch2['feedback']) || $fetch2['feedback'] == NULL) {

            ?>
            <table colspan="10" cellpadding="10" cellspacing="15" align="left">
                <tr>
                    <td>Project</td>

                    <?php
                    if (empty($fetch2['project'])) {
                        ?>
                        <td><?php echo $project; ?></td>
                    <?php
                    } else {
                        ?>
                        <td><?php echo $fetch2['project'] ?></td>
                    <?php
                    }
                    ?>

                </tr>
                <tr>
                    <td>Report</td>
                    <?php
                    if (empty($fetch2['report_name'])) {
                        ?>
                        <td><?php echo "Not yet submitted" ?></td>
                    <?php
                    } else {
                        ?>
                        <td><?php echo $fetch2['report_name'] ?></td>
                    <?php
                    }
                    ?>

                </tr>

            </table><br><br>



        <form action="<?php echo explode('?', $url)[0] . "?date/" . $date . "/uname/" . $name ?>" method="POST">
            <br>
            <table>
                <tr>
                    <td>FEEDBACK:</td>
                    <td><textarea rows="8" cols="70" name="feed"
                                  value="<?php echo $fetch2['feedback'] ?>"><?php echo $fetch2['feedback'] ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td>Score</td>
                    <td><input name="score" type="text" value="<?php echo $fetch2['score']; ?>"></td>
                </tr>


            </table>
            <p>
                <button type="submit" name="save">Submit</button>
            </p></form><?php
        } else if (empty($fetch2) || $fetch2 == NULL) {
            ?>
            <br><br>
        <form action="<?php echo explode('?', $url)[0] . "?date/" . $date . "/uname/" . $name ?>" method="POST">
            <br>
            <table>
                <tr>
                    <td>FEEDBACK:</td>
                    <td><textarea rows="8" cols="70" name="feed"
                                  value="<?php echo $fetch2['feedback'] ?>"><?php echo $fetch2['feedback'] ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td>Score</td>
                    <td><input name="score" type="text" value="<?php echo $score; ?>"></td>
                </tr>


            </table>
            <p>
                <button type="submit" name="save">Submit</button>
            </p></form><?php
        }
    } else {
        ?>
        <table colspan="10" cellpadding="10" cellspacing="15" align="left">

            <tr>
                <td>Project</td>

                <td><?php echo $project; ?></td>

            </tr>
            <tr>
                <td>Report</td>
                <td><?php echo "Not yet submitted" ?></td>


            </tr>
        </table>

        <form action="<?php echo explode('?', $url)[0] . "?date/" . $date . "/uname/" . $name ?>" method="POST">
            <br>
            <table>
                <tr>
                    <td>FEEDBACK:</td>
                    <td><textarea rows="8" cols="70" name="feed"
                                  value="<?php echo $fetch2['feedback'] ?>"><?php echo $fetch2['feedback'] ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td>Score</td>
                    <td><input name="score" type="text" value=""></td>
                </tr>


            </table>
            <p>
                <button type="submit" name="save">Submit</button>
            </p>
        </form>
    <?php
    }


}










?>






