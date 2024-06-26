<?php
include 'navbar.php';
checkKhoaHoc();

// tìm kiếm tên
if (isset($_POST['usersearch'])) {
    if (!empty($_POST['usersearch'])) {
        $user_search = searchUser($_POST['usersearch']);
    } else $user_search = '';
}
// Thêm học viên  
if (isset($_POST['add_user'])) {

    $check_user_users = get('course_management', "course_id={$_GET['course_id']} AND username='{$_POST['add_user']}'");

    if (!is_null($check_user_users) && $check_user_users['username'] == $_POST['add_user']) {
        $mess = '<div class="alert alert-warning d-flex align-items-center" role="alert">Người dùng đã tồn tại trong khóa học</div>';
    } else {
        $insert_user = insert('course_management', ['course_id' =>  $_GET['course_id'], 'username' => $_POST['add_user']]);
        if ($insert_user) {
            $mess = '<div class="alert alert-success d-flex align-items-center" role="alert">Thêm thành công!</div>';
        } else $mess = '<div class="alert alert-warning d-flex align-items-center" role="alert">Thất bại</div>';
    }
}
// cập nhật Quyền 
if (isset($_POST['role_update'])) {
    $id_role = explode("-", $_POST['role_update']);
    $update = update('course_management', "id={$id_role[0]}", ['role' => $id_role[1]]);
    if ($update) {
        $mess = '<div class="alert alert-success d-flex align-items-center" role="alert">Cập nhật thành công!</div>';
        $_SESSION['role_course'] = $id_role[1];
    } else $mess = '<div class="alert alert-warning d-flex align-items-center" role="alert">Thất bại</div>';
}
// Xóa bài giảng
if (isset($_POST['user_delete'])) {
    $delete = delete('course_management', "id={$_POST['user_delete']}");
    if ($delete) {
        $mess = '<div class="alert alert-success d-flex align-items-center" role="alert">Xóa thành công!</div>';
    } else $mess = '<div class="alert alert-warning d-flex align-items-center" role="alert">Thất bại</div>';
}

if ($role_course == 1 || $role_all == 2) {
    $data = get('courses', 'id=' . $_GET['course_id'] . '');
?>

<!-- điều hướng -->
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a
                class="link-dark link-opacity-50 link-opacity-100-hover link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover"
                href="khoa_hoc.php">Trang chủ</a></li>
        <li class="breadcrumb-item"><a
                class="link-dark link-opacity-50 link-opacity-100-hover link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover"
                href="bai_giang.php?course_id=<?= $_GET['course_id'] ?>">Khóa học: <?= $data['course_title'] ?></a></li>

        <li class="breadcrumb-item text-dark active" aria-current="page">Quản lý khóa học</li>
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

<div class="row">
    <div class="col">
        <h3>Danh sách sinh viên trong khóa học</h3>
    </div>
    <div class="position-relative  col d-flex flex-row-reverse">
        <div class="dropdown-menu top-0 position-absolute d-block pt-0 mx-0  border-0 overflow-hidden w-280px">
            <form method="post" class="p-2 mb-2 ">
                <input type="search" name="usersearch" class="form-control" placeholder="Nhập tên cần tìm..."
                    value="<?= isset($_POST['usersearch']) ? htmlspecialchars($_POST['usersearch']) : '' ?>">
            </form>
            <?php
                if (isset($_POST['usersearch']) && !empty($user_search)) {
                    while ($data_user = $user_search->fetch_assoc()) {
                ?>
            <ul class="list-unstyled  mb-0">
                <li class="dropdown-item d-flex justify-content-between shadow-sm p-2 gap-2 py-2">
                    <?= $data_user['username'] ?>
                    <form method="post">
                        <button class=" btn btn-sm border-0 btn-outline-success" name="add_user"
                            value="<?= $data_user['username'] ?>" type="submit"><i class="fa-light fa-plus"></i>
                        </button>
                    </form>
                </li>
            </ul>
            <?php
                    }
                } elseif (isset($_POST['usersearch']) && is_null($user_search)) { ?>
            <ul class="list-unstyled mb-0">
                <li><a class="dropdown-item d-flex align-items-center gap-2 py-2" href="#">
                        Không tìm thấy dữ liệu
                    </a></li>
            </ul>
            <?php } ?>
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
            if ($course_data && $course_data->num_rows > 0) {
                while ($row_course = $course_data->fetch_assoc()) {

            ?>
        <tr>
            <th><?= $i ?></th>
            <td><?= $row_course['username'] ?></td>
            <td><?= date("H:i:s - d/m/y", strtotime($row_course['created_at'])) ?></td>
            <td><?= ($row_course['role'] == 0) ? "Học viên" : "Quản trị viên" ?></td>
            <td>
                <form method="post">
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
                </form>
            </td>
        </tr>
        <?php
                    $i++;
                }
            } else echo "<td colspan=5 align='center'> Chưa có học viên</td>" ?>

    </tbody>
</table>


<?php } else { ?>

<div class="text-center alert alert-warning">
    Bạn không được quyền truy cập vào trang này!<a href="khoa_hoc.php" class="alert-link">Quay lại</a>
</div>
<?php } ?>


<?php include 'footer.php' ?>