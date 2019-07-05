<?php

class Model
{
    public $mysqli;

    function __construct()
    {
        $this->mysqli = new mysqli();
    }

    public function connect_db()
    {
        $this->mysqli->connect('mysql.zzz.com.ua', 'O1Jack1O', '15019393KlK', 'o1jack1o');
        $this->mysqli->set_charset('utf8');
    }

    public function disconnect_db()
    {
        $this->mysqli->close();
    }

    public function get_data()
    {
        if (!isset($_SESSION['paramsPage'])) $this->pagination_init();


        $lim = " LIMIT " . $_SESSION['paramsPage']['currRow'] . " , " . $_SESSION['paramsPage']['limitRowsOnPage'];
        //var_dump($_SESSION['sortBy']);
        /**/

        $buff = $_SESSION['sortBy'];
        //var_dump($lim.$buff);
        $this->connect_db();
        if (!$results = $this->mysqli->query("SELECT * FROM users " . $buff . $lim . " ", MYSQLI_USE_RESULT)->fetch_all()) {
            printf("Сообщение ошибки: %s\n", $this->mysqli->error);
        }
        $this->disconnect_db();
        return $results;
    }

    public function update_data($id, $task)
    {
        $this->connect_db();
        $this->mysqli->query("UPDATE users SET task = '$task' WHERE id = '$id';", MYSQLI_USE_RESULT);
        $this->disconnect_db();

    }

    public function set_data($name, $email, $task, $status)
    {
        if ($name == "") {
            $columnUsername = "";
        } else {
            $columnUsername = "username,";
        }
        if ($email == "") {
            $columnEmail = "";
        } else {
            $columnEmail = "email,";
        }
        if ($task == "") {
            $columnTask = "";
        } else {
            $columnTask = "task,";
        }
        if ($status == "") {
            $columnStatus = "status";
        } else {
            $columnStatus = "status";
        }
        $result = $columnUsername . $columnEmail . $columnTask . $columnStatus;

        $this->connect_db();
        $this->mysqli->query("INSERT INTO users ( " . $result . " ) VALUES ('$name', '$email', '$task','$status')", MYSQLI_USE_RESULT);
        var_dump((int)ceil($this->mysqli->query("SELECT * FROM users ")->num_rows));
        $_SESSION['paramsPage']['maxPages'] = (int)ceil($this->mysqli->query("SELECT * FROM users ")->num_rows / 3);
        $this->disconnect_db();
    }

    public function delete_data($data)
    {
        $this->connect_db();
        $this->mysqli->query("DELETE FROM users WHERE id = '$data'", MYSQLI_USE_RESULT);
        $_SESSION['paramsPage']['maxPages'] = (int)ceil($this->mysqli->query("SELECT * FROM users ")->num_rows / 3);
        $this->disconnect_db();
    }

    public function auth_admin($name, $password)
    {
        $this->connect_db();
        $result = $this->mysqli->query("SELECT * FROM admins", MYSQLI_USE_RESULT)->fetch_all();
        foreach ($result as $row) {
            if ($name == $row[1] & $password == $row[2]) {
                $_SESSION["auth"] = "LOGGED";
            }
        }
        $this->disconnect_db();

    }

    public function status_done($id, $status)
    {
        $this->connect_db();
        $this->mysqli->query("UPDATE users SET status = '$status' 
	   WHERE id = '$id';", MYSQLI_USE_RESULT);
        $this->disconnect_db();
    }

    public function mb_ord($string)
    {
        if (extension_loaded('mbstring') === true) {
            mb_language('Neutral');
            mb_internal_encoding('UTF-8');
            mb_detect_order(array('UTF-8', 'ISO-8859-15', 'ISO-8859-1', 'ASCII'));

            $result = unpack('N', mb_convert_encoding($string, 'UCS-4BE', 'UTF-8'));

            if (is_array($result) === true) {
                return $result[1];
            }
        }

        return ord($string);
    }

    public function pagination_init()
    {
        $this->connect_db();
        $countRows = $this->mysqli->query("SELECT * FROM users ")->num_rows;
        $this->disconnect_db();
        //print_r($countRows);
        echo '<br>';
        $limitRowsOnPage = 3;
        $currRow = 0;
        $maxPages = (int)ceil($countRows / $limitRowsOnPage);
        $currPage = 1;
        $_SESSION['buttonNextFlag'] = true;
        $_SESSION['buttonPreviousFlag'] = false;

        $paramsPage = array('currPage' => $currPage, 'maxPages' => $maxPages,
            'limitRowsOnPage' => $limitRowsOnPage, 'currRow' => $currRow, 'countRows' => $countRows);

        $_SESSION['paramsPage'] = $paramsPage;
    }

    public function nextPage()
    {
        $_SESSION['paramsPage']['currPage'] += 1;
        $_SESSION['paramsPage']['currRow'] += 3;
        echo '<br>';
        //var_dump($_SESSION['paramsPage']['currPage']);
        echo '<br>';
        //var_dump($_SESSION['paramsPage']['currPage'] == $_SESSION['paramsPage']['maxPages']);

        if ($_SESSION['paramsPage']['currPage'] > 1) {
            $_SESSION['buttonPreviousFlag'] = true;
        }
        if ($_SESSION['paramsPage']['currPage'] == $_SESSION['paramsPage']['maxPages']) {
            $_SESSION['buttonNextFlag'] = false;
            //header("Location: http://apptaskslist.zzz.com.ua/");
        }
        header("Location: http://apptaskslist.zzz.com.ua/");
    }

    public function previousPage()
    {

        $_SESSION['paramsPage']['currPage'] -= 1;
        //var_dump($_SESSION['paramsPage']['currPage']);
        $_SESSION['paramsPage']['currRow'] -= 3;
        //var_dump($_SESSION['paramsPage']['currRow']);
        if ($_SESSION['paramsPage']['currPage'] < 2) {
            $_SESSION['buttonPreviousFlag'] = false;
            //header("Location: http://apptaskslist.zzz.com.ua/");
        }
        if ($_SESSION['paramsPage']['currPage'] != $_SESSION['paramsPage']['maxPages']) {
            $_SESSION['buttonNextFlag'] = true;
        }
        header("Location: http://apptaskslist.zzz.com.ua/");
    }

    public function sortBy($BY)
    {
        $_SESSION['by']=$BY;
        if (!isset($_SESSION['sortBy']) ) {
            $_SESSION['sortBy'] = ' order by ' . $BY . ' ASC';
            unset($_SESSION['offSortByDESC']);
            //var_dump($_SESSION['sortBy']);
        } elseif (isset($_SESSION['offSortByDESC'])) {
            unset($_SESSION['sortBy']);

        } else {
            $_SESSION['sortBy'] = ' order by ' . $BY . ' DESC';
            $_SESSION['offSortByDESC'] = true;
            //var_dump($_SESSION['sortBy']);
        }
    }


}