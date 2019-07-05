<?php

class Controller_Tasks extends Controller
{

    function __construct()
    {
        $this->model = new model();
        $this->view = new View();


    }

    function action_index()
    {
        $data = $this->model->get_data();
        $this->view->generate('tasks_view.php', 'template_view.php', $data);
    }

    function action_addData()
    {

        if (isset($_POST['username']) && $_POST['username'] != "") {
            $this->model->set_data($_POST["username"], $_POST["email"], $_POST["task"], $_POST["status"]);

        }
        $data = $this->model->get_data();
        $this->view->generate('tasks_view.php', 'template_view.php', $data);
        header("Location: http://apptaskslist.zzz.com.ua/");
    }

    function action_login()
    {

        if (isset($_POST['admin-name']) && $_POST['admin-name'] != "" && isset($_POST['admin-password']) && $_POST['admin-password'] != "") {
            $this->model->auth_admin($_POST["admin-name"], $_POST["admin-password"]);
        }

        if (isset($_POST['exit']) && $_POST['exit'] != "") {
            unset($_SESSION["auth"]);
        }

        $data = $this->model->get_data();
        $this->view->generate('tasks_view.php', 'template_view.php', $data);
        header("Location: http://apptaskslist.zzz.com.ua/");
    }

    function action_sortBy()
    {
        if (isset($_POST['username']) || isset($_POST['email']) || isset($_POST['status'])) {

            $this->model->sortBy(array_keys($_POST)[0]);


            $data = $this->model->get_data();
            $this->view->generate('tasks_view.php', 'template_view.php', $data);
            header("Location: http://apptaskslist.zzz.com.ua/");
        } else {
            $data = $this->model->get_data();
            $this->view->generate('tasks_view.php', 'template_view.php', $data);
            header("Location: http://apptaskslist.zzz.com.ua/");
        }

    }

    function action_delete()
    {

        if (isset($_POST['delete']) && $_POST['delete'] != "") {
            $this->model->delete_data($_POST['delete']);

        }
        $data = $this->model->get_data();
        $this->view->generate('tasks_view.php', 'template_view.php', $data);
        header("Location: http://apptaskslist.zzz.com.ua/");
    }

    function action_done()
    {

        $res = array_keys($_POST['done'])[0];
        if (isset($_POST['done']) && $this->model->mb_ord($_POST['done'][$res]) == 215) {
            $res = array_keys($_POST['done'])[0];
            $this->model->status_done($res, '');
        } else {
            $res = array_keys($_POST['done'])[0];
            $res2 = $_POST['done'][$res];
            $this->model->status_done($res, $res2);
        }
        $data = $this->model->get_data();
        $this->view->generate('tasks_view.php', 'template_view.php', $data);
        header("Location: http://apptaskslist.zzz.com.ua/");
    }

    function action_edit()
    {
        $id = array_keys($_POST['task'])[0];
        if (isset($_POST['task']) && $_POST['task'][$id] != '') {
            $id = array_keys($_POST['task'])[0];
            $task = $_POST['task'][$id];
            $this->model->update_data($id, $task);
        }
        $data = $this->model->get_data();
        $this->view->generate('tasks_view.php', 'template_view.php', $data);
        header("Location: http://apptaskslist.zzz.com.ua/");
    }

    function action_nextPage()
    {

        if (isset($_POST['nextPage']) && $_POST['nextPage'] == "NextPage>>") {

            $this->model->nextPage();
        }
        $data = $this->model->get_data();
        $this->view->generate('tasks_view.php', 'template_view.php', $data);
    }

    function action_previousPage()
    {
        //var_dump($_POST);
        if (isset($_POST['prevPage']) && $_POST['prevPage'] == "<<PreviousPage") {
            //var_dump($_POST);
            $this->model->previousPage();
        }
        $data = $this->model->get_data();
        $this->view->generate('tasks_view.php', 'template_view.php', $data);
    }
}
