<?php
session_start();
include '../connectdb.php';
include '../function.php';
isLogin2();

$username = $_SESSION['username'];
$role_all = $_SESSION['role_all']; // quyền quản trị admin
if (isset($_GET['course_id'])) {
    if ($username == 'admin') {
        $role_course = 1;
    } else {
        $condition = "course_id={$_GET['course_id']} AND username='{$username}'";
        $role_course = get('course_management', $condition)['role']; // quyền quản trị khóa học
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Khóa học</title>
    <!-- Begin bootstrap cdn -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- End bootstrap cdn -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

</head>

<body>
    <!-- thanh nav -->
    <nav class="navbar sticky-top navbar-expand-lg navbar-light bg-light ">
        <div class="container-fluid px-5">
            <a class="navbar-brand" href="khoa_hoc.php">ProjectPHP K71</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse " id="navbarNavDropdown">
                <ul class="navbar-nav ms-auto ">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle active" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <?php
                            echo  $username ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink">
                            <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#model_pass_edit">Đổi
                                    mật khẩu</a></li>
                            <li><a class="dropdown-item" href="dang_xuat.php">Đăng xuất</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


    <!-- The Modal đổi password-->
    <div class="modal" id="model_pass_edit">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-4">Thay đổi mật khẩu</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" action="">
                    <div class="modal-body">

                        <div class="input-group mb-3">
                            <span class="input-group-text">Mật khẩu hiện tại:</span>
                            <input type="password" class="form-control" value="" name="pass_old" required>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text">Mật khẩu mới:</span>
                            <input type="password" class="form-control" value="" name="pass_new" required>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text">Nhập lại mật khẩu mới:</span>
                            <input type="password" class="form-control" value="" name="pass_new_1" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="update_pass" class="btn btn-primary">Cập
                            nhật</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php
    if (isset($_POST['update_pass'])) {
        $pass = get('users', "username= '{$username}'")['password'];
        $pass_old = $_POST['pass_old'];
        $pass_new = $_POST['pass_new'];
        $pass_new_1 = $_POST['pass_new_1'];

        if (md5($pass_old) != $pass) {
            echo '<div class="alert alert-warning d-flex align-items-center" role="alert"">Mật khẩu hiện tại không đúng. Vui lòng thử lại</div>';
        } elseif ($pass_new_1 != $pass_new) {
            echo '<div class="alert alert-warning d-flex align-items-center" role="alert"">Mật khẩu nhập lại không trùng khớp.Hãy thử lại</div>';
        } else {
            $update_pass = update('users', "username= '{$username}'", ['password' => md5($pass_new)]);
            if ($update_pass) {
                echo '<div class="alert alert-success  " role="alert">Đổi mật khẩu thành công</div>';
            }
        }
    }

    ?>

    <div class="container" style="min-height: 100vh;">