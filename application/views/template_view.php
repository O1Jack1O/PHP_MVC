<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="content-type" content="text/html" charset="utf8"/>
    <title>AppTasks</title>
    <link href="http://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css"/>
    <link href="http://fonts.googleapis.com/css?family=Kreon" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="/css/style.css"/>
</head>
<body>
<div id="wrapper">
    <div id="header">
        <div id="menu">
            <ul>
                <li>For admin:</li>
                <li>
                    <form method="post" action="/tasks/login">
                        <?php
                        if (isset($_SESSION["auth"]) && $_SESSION["auth"] != ""){
                        echo "Admin"; ?>
                        <label for="admin-name">
                            authorized! <input type="submit" name="exit" value="exit"/>
                        </label>
                    </form>
                    <?php } else { ?>
                        <label for="admin-name">
                            Login: <input type="text" name="admin-name" id="admin-name"/>
                        </label>

                        <label for="admin-password">
                            Password: <input type="password" name="admin-password" id="admin-password"/>
                        </label>
                        <input type="submit" value="Войти">
                    <?php }; ?>
                    </form>
                </li>
            </ul>

            <br class="clearfix"/>
        </div>
    </div>
    <div id="page">

        <div id="content">
            <div class="box">
                <?php include 'application/views/' . $content_view; ?>

            </div>
            <br class="clearfix"/>
                <div id="pagination">
                    <div id="pagination2">
                    <form action="/tasks/previousPage" method="post" >
                        <input type="<?php if($_SESSION['buttonPreviousFlag']) {echo 'submit' ;}else{echo 'hidden'; }?>" name="prevPage" value="<<PreviousPage">
                        <input type="button" name="currPage" value="<?php echo $_SESSION['paramsPage']['currPage']." / ".$_SESSION['paramsPage']['maxPages']; ?>">
                    </form>
                    <form action="/tasks/nextPage" method="post" ">
                        <input type="<?php if($_SESSION['buttonNextFlag']) {echo 'submit' ;}else{echo 'hidden';}?>" name="nextPage" value="NextPage>>">
                    </form>
                </div>
            </div>
            <br class="clearfix"/>
        </div>
        <br class="clearfix"/>
    </div>
</div>
</body>
</html>