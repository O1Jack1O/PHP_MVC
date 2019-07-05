<h1>TasksList</h1>
<p>
<table>
    <tr>
        <?php if (isset($_SESSION["auth"]) && $_SESSION["auth"] != ""): ?>
            <td>id</td> <?php endif ?>
        <form method="post" action="/tasks/sortBy">
            <td>
                <label>
                    SortBy: <input type="submit" name="username" value="Users">
                    <?php if(!isset($_SESSION['sortBy'])){
                        echo '&#215';
                    }elseif(isset($_SESSION['sortBy'])&&!isset($_SESSION['offSortByDESC'])&&$_SESSION['by']=='username'){
                        echo '[A-Z]';
                    }elseif($_SESSION['by']=='username'){echo '[Z-A]';}
                    ?>
                </label>
            </td>
            <td>
                <label>SortBy: <input type="submit" name="email" value="Email">
                    <?php if(!isset($_SESSION['sortBy'])){
                        echo '&#215';
                    }elseif(isset($_SESSION['sortBy'])&&!isset($_SESSION['offSortByDESC'])&&$_SESSION['by']=='email'){
                        echo '[A-Z]';
                    }elseif($_SESSION['by']=='email'){echo '[Z-A]';}
                    ?>
                </label>
            </td>
            <td>
                Tasks
            </td>
            <td>
                <label>
                    SortBy: <input type="submit" name="status" value="Status">
                    <?php if(!isset($_SESSION['sortBy'])){
                        echo '&#215';
                    }elseif(isset($_SESSION['sortBy'])&&!isset($_SESSION['offSortByDESC'])&&$_SESSION['by']=='status'){
                    echo '[A-Z]';
                    }elseif($_SESSION['by']=='status'){echo '[Z-A]';}
                    ?>
                </label>
            </td>
        </form>
    </tr>
    <?php
    if (isset($_SESSION["auth"]) && $_SESSION["auth"] != "") {
        echo '';
        foreach ($data as $row) {
            $buff = "&#10004;";
            if ($row['4'] != null) {
                $buff = "&#215;";
            }
            echo '<tr>
                    <td>
                        <label>
                            <form method="post" action="/tasks/delete">
                                Delete:<input type="submit" name="delete" value="' . $row['0'] . '">
                            </form>
                        </label>
                    </td>
                    <td>' . $row['1'] . '</td>
                    <td>' . $row['2'] . '</td>
                    <td>
                        <form method="post" action="/tasks/edit">
                            <textarea name="task[' . $row['0'] . ']">' . $row['3'] . '</textarea>
                            <input type="submit" value="edit">
                        </form>
                    </td>
                    <td><label for="done">' . $row['4'] . '
                            <form method="post" action="/tasks/done">
                                <input type="submit" name="done[' . $row['0'] . ']" value=' . $buff . '>
                            </form>
                        </label>
                    </td>
                </tr>';
        }

    } else {
        /*for($i=$_SESSION['minNumberRow'];$i<=$_SESSION['maxNumberRow'];$i++){
            echo '<tr>';
            for($j=1;$j<=4;$j++){
                echo'<td>'.$data[$i][$j].'</td>';
            }
            echo '</tr>';
        }*/
        foreach ($data as $row) {
            echo '<tr>
                    <td>' . $row['1'] . '</td>
                    <td>' . $row['2'] . '</td>
                    <td>' . $row['3'] . '</td>
                    <td>' . $row['4'] . '</td>
                </tr>';
        }
    } ?>
    <tr>
        <?php if (isset($_SESSION["auth"]) && $_SESSION["auth"] != ""): ?>
            <td>
            </td>
        <?php endif ?>


        <form method="post" action="/tasks/addData">
            <td>
                <input type="text" name="username">
            </td>
            <td>
                <input type="email" name="email">
            </td>
            <td>
                <input type="text" name="task">
            </td>
            <td>
                <input type="hidden" name="status">
            </td>
            <td>
                <input type="submit" value="Добавить">
            </td>
        </form>
    </tr>
</table>
<!--<div id="pagination">
        <form  method="post" action="/tasks/pagination">
            <input type="<?php /*if($_SESSION['currentPage']==1){
                echo 'hidden';
            }else{
                echo'submit';
            }*/ ?>" name="Previous" value="previous">
            <input type="button" value="( <?php /*echo $_SESSION['currentPage'].' / '.$_SESSION['maxPage']; */ ?> )">
            <input type="submit" name="Next" value="next">
        </form>
    </div>-->
</p>
