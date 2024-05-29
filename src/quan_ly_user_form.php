<?php
include '../function.php';
if (isset($_POST['add_role'])) {
    if (update('users', "id={$_POST['add_role']}", ['role' => 1])) {
        header('location: quan_ly_user.php');
    }
} elseif (isset($_POST['delete_role'])) {
    if (update('users', "id={$_POST['delete_role']}", ['role' => 0])) {
        header('location: quan_ly_user.php');
    }
} elseif (isset($_POST['delete_user'])) {
    if (delete('users', "id={$_POST['delete_user']}")) {
        header('location: quan_ly_user.php');
    }
}
