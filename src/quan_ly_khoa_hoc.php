<?php
include 'navbar.php';
if ($role_course == 1 || $role_all == 2) {
    $data = get('courses', 'id=' . $_GET['course_id'] . '');

    if (isset($_POST['add_user'])) { // Thêm học viên  
        $check_user_users = searchUser($_POST['username']);
        if (!is_null($check_user_users)) {
            $row = $check_user_users->fetch_assoc();
        }

        if (is_null($check_user_users)) {
            $mess = '<div class="alert alert-warning d-flex align-items-center" role="alert">Người dùng không tồn tại</div>';
        } elseif ($row['username'] == $_POST['username']) {
            $mess = '<div class="alert alert-warning d-flex align-items-center" role="alert">Người dùng đã tồn tại trong khóa học</div>';
        } else {
            $insert_user = insert('course_management', ['course_id' =>  $_GET['course_id'], 'username' => $_POST['username']]);
            if ($insert_user) {
                $mess = '<div class="alert alert-success d-flex align-items-center" role="alert">Thêm thành công!</div>';
            } else $mess = '<div class="alert alert-warning d-flex align-items-center" role="alert">Thất bại</div>';
        }
    }
    if (isset($_POST['role_update'])) { // cập nhật Quyền 
        $id_role = explode("-", $_POST['role_update']);
        $update = update('course_management', ['role' => $id_role[1]], "id={$id_role[0]}");
        if ($update) {
            $mess = '<div class="alert alert-success d-flex align-items-center" role="alert">Cập nhật thành công!</div>';
            $_SESSION['role_course'] = $id_role[1];
        } else $mess = '<div class="alert alert-warning d-flex align-items-center" role="alert">Thất bại</div>';
    }
    if (isset($_POST['user_delete'])) { // Xóa bài giảng
        $delete = delete('course_management', "id={$_POST['user_delete']}");
        if ($delete) {
            $mess = '<div class="alert alert-success d-flex align-items-center" role="alert">Xóa thành công!</div>';
        } else $mess = '<div class="alert alert-warning d-flex align-items-center" role="alert">Thất bại</div>';
    }
?>

    <!-- điều hướng -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a class="link-dark link-opacity-50 link-opacity-100-hover link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover" href="khoa_hoc.php">Trang chủ</a></li>
            <li class="breadcrumb-item text-dark active" aria-current="page">Thêm khóa học</li>
        </ol>
    </nav>
    <!-- thông tin khóa học -->
    <div class="d-flex justify-content-between p-3 my-3 bg-purple rounded shadow">
        <div class="lh-1">
            <h2 class="mb-0 lh-1">Khóa học: <?= $data['course_title'] ?></h2>
        </div>
    </div>
    <?php
    if (isset($mess)) {
        echo $mess;
    }
    ?>
    <form method="post">
        <div class="row">
            <div class="col">
                <h3>Danh sách sinh viên trong khóa học</h3>
            </div>
            <div class="col">
                <div class="input-group">
                    <input type="text" class="form-control" name="username" placeholder="Thêm học viên">
                    <button class="btn btn-outline-secondary" name="add_user" type="submit">Thêm</button>
                </div>
            </div>
        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">STT</th>
                    <th scope="col">Tên tài khoản</th>
                    <th scope="col">Ngày thêm</th>
                    <th scope="col">Quyền</th>
                    <th scope="col">Tác vụ</th>
                </tr>
            </thead>
            <tbody class="table-group-divider">
                <?php
                $i = 1;
                $course_data = getArray('course_management', "course_id={$_GET['course_id']}");
                while ($row_course = $course_data->fetch_assoc()) {
                ?>
                    <tr>
                        <th><?= $i ?></th>
                        <td><?= $row_course['username'] ?></td>
                        <td><?= date("H:i:s - d/m/y", strtotime($row_course['created_at'])) ?></td>
                        <td><?= ($row_course['role'] == 0) ? "Học viên" : "Quản trị viên" ?></td>
                        <td>
                            <?php
                            if ($row_course['role'] == 0) {
                            ?>
                                <button class="btn btn-sm btn-success" name="role_update" value="<?= $row_course['id'] ?>-1">
                                    Thêm
                                    quản trị </button>
                            <?php } else {
                            ?>
                                <button class="btn btn-sm btn-warning" name="role_update" value="<?= $row_course['id'] ?>-0">
                                    Hủy
                                    quản trị </button>
                            <?php } ?>
                            <button class="btn btn-sm btn-danger" name="user_delete" value="<?= $row_course['id'] ?>">
                                Xóa
                            </button>
                        </td>
                    </tr>
                <?php
                    $i++;
                } ?>

            </tbody>
        </table>
    </form>

<?php } else { ?>

    <div class="text-center alert alert-warning">
        Bạn không được quyền truy cập vào trang này!<a href="khoa_hoc.php" class="alert-link">Quay lại</a>
    </div>
<?php } ?>
<?php include 'footer.php' ?>