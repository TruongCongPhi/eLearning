<?php
include 'navbar.php';
checkKhoaHoc();

$data = get('courses', 'id=' . $_GET['course_id'] . '');
$lecture_data = getArray('lectures', 'course_id=' .  $_GET['course_id'] . '');

if (isset($_POST['update_course'])) { // cập nhật thông tin khóa học
    $update_course = update('courses', ['course_title' => $_POST['course_title'], 'course_desc' => $_POST['course_desc']], "id={$_GET['course_id']}");
    if ($update_course) {
        $mess = '<div class="alert alert-success d-flex align-items-center" role="alert">Cập nhật thành công!</div>';
        header("location: bai_giang.php?course_id={$_GET['course_id']}");
    }
}
if (isset($_POST['add_lecture'])) { // Thêm mới bài giảng
    $data_lecture = [
        'course_id' => $_GET['course_id'],
        'lecture_title' => $_POST['lecture_title'],
        'status' => $_POST['status_lecture']
    ];
    $insert_lecture = insert('lectures', $data_lecture);
    if ($insert_lecture) {
        header("location: bai_giang.php?course_id={$_GET['course_id']}");
    }
}
if (isset($_POST['status_lecture_update'])) { // cập nhật ẨN / HIỆN bài giảng  
    $id_lecture_status = explode("-", $_POST['status_lecture_update']);
    $status_lecture_update = update('lectures', ['status' => $id_lecture_status[1]], "id={$id_lecture_status[0]}");
    if ($status_lecture_update) {
        header("location: bai_giang.php?course_id={$_GET['course_id']}");
    }
}
if (isset($_POST['lecture_delete'])) { // Xóa bài giảng
    delete('lectures', "id={$_POST['lecture_delete']}");
    header("location: bai_giang.php?course_id={$_GET['course_id']}");
}
if (isset($_POST['status_material_update'])) { // cập nhật ẨN / HIỆN học liệu 
    $id_material_status = explode("-", $_POST['status_material_update']);
    update('materials', ['status' => $id_material_status[1]], "id={$id_material_status[0]}");
    header("location: bai_giang.php?course_id={$_GET['course_id']}");
}
if (isset($_POST['material_delete'])) { // Xóa học liệu
    delete('materials', "id={$_POST['material_delete']}");
    header("location: bai_giang.php?course_id={$_GET['course_id']}");
}
?>

<!-- Thanh điều hướng -->
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a class="link-secondary" href="khoa_hoc.php">Trang chủ</a></li>
        <li class="breadcrumb-item text-dark active" aria-current="page">Khóa học: <?= $data['course_title'] ?></li>
    </ol>
</nav>
<!-- thông tin khóa học -->
<div class="d-flex justify-content-between p-3 my-3 bg-purple rounded shadow">
    <div class="lh-1">
        <h2 class="mb-0 lh-1">Khóa học: <?= $data['course_title'] ?></h2>
        <p class="mt-2"><?= $data['course_desc'] ?></p>
    </div>
    <!-- menu course quản trị -->
    <?php if ($role_course == 1 || $role_all == 2) : ?>
    <div class="dropdown cursor-auto">
        <button class="bg-white dropdown-toggle border-0 bg-0" data-bs-toggle="dropdown"><i
                class="fa-solid fa-pen-to-square "></i></button>
        <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#model_course_edit">Chỉnh sửa thông tin
                    khóa
                    học</a></li>
            <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#model_lecture_add">Thêm bài giảng</a>
            </li>
            <li><a class="dropdown-item" href="quan_ly_khoa_hoc.php?course_id=<?= $_GET['course_id'] ?>">Quản lý khóa
                    học</a></li>
        </ul>
    </div>
    <?php endif; ?>
</div>

<!-- The Modal edit course -->
<div class="modal" id="model_course_edit">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-4">Thông tin khóa học</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="">
                <div class="modal-body">

                    <div class="input-group mb-3">
                        <span class="input-group-text">Khóa học:</span>
                        <input type="text" class="form-control" value="<?= $data['course_title'] ?>"
                            name="course_title">
                    </div>
                    <div class="input-group">
                        <span class="input-group-text">Mô tả:</span>
                        <textarea class="form-control" aria-label="With textarea"
                            name="course_desc"><?= $data['course_desc'] ?></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="update_course" class="btn btn-primary">Cập
                        nhật</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- The Modal add lecture -->
<div class="modal" id="model_lecture_add">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-4">Thêm bài giảng</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="">
                <div class="modal-body">
                    <div class="input-group mb-3">
                        <span class="input-group-text">Tiêu đề:</span>
                        <input type="text" class="form-control" name="lecture_title">
                    </div>
                    <select class="form-select form-select" name="status_lecture" required>
                        <option selected disabled value="">Trạng thái...</option>
                        <option value="0">Ẩn</option>
                        <option value="1">Hiện</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="add_lecture" class="btn btn-primary">Thêm</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
if (isset($mess)) {
    echo $mess;
}
?>

<?php
if ($lecture_data && $lecture_data->num_rows > 0) {
    while ($row_lecture = mysqli_fetch_assoc($lecture_data)) {
        if ($row_lecture['status'] == 1 || $role_course == 1  || $role_all == 2) { // Hiển thị nếu status = 1 , admin or qtv
?>
<!-- Bắt đầu bài giảng -->
<div class="my-3 p-3 bg-body border rounded shadow-sm ">
    <form method="post">
        <div class="d-flex justify-content-between">
            <h4 class="border-bottom pb-2 mb-0"><?= $row_lecture['lecture_title'] ?>

                <?php if ($role_course == 1  || $role_all == 2 && $row_lecture['status'] == 1) : ?>
                <!-- Theo dõi trạng thái(chỉ admin or qtv) -->
                <span class="text-success">(Hiện)</span>
                <?php elseif ($role_course == 1  || $role_all == 2 && $row_lecture['status'] == 0) : ?>
                <span class="text-warning">(Ẩn)</span>
                <?php endif; ?>
            </h4>
            <!-- menu course quản trị -->
            <?php if ($role_course == 1 || $role_all == 2) : ?>
            <div class="dropdown cursor-auto">
                <button class="bg-white dropdown-toggle border-0 bg-0" data-bs-toggle="dropdown"><i
                        class="fa-solid fa-pen-to-square "></i></button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <?php
                                        if ($row_lecture['status'] == 1) : ?>
                        <button class="dropdown-item text-warning" type="submit" name="status_lecture_update"
                            value="<?= $row_lecture['id'] ?>-0">Ẩn</button>
                        <?php else : ?>
                        <button class="dropdown-item text-success" type="submit" name="status_lecture_update"
                            value="<?= $row_lecture['id'] ?>-1">Hiện</button>
                        <?php endif; ?>
                    </li>
                    <li><a class="dropdown-item"
                            href="them_hoc_lieu.php?course_id=<?= $_GET['course_id'] ?>&lecture_id=<?= $row_lecture['id'] ?>">Thêm
                            học liệu</a></li>
                    <li><a class="dropdown-item"
                            href="them_quizz.php?course_id=<?= $_GET['course_id'] ?>&lecture_id=<?= $row_lecture['id'] ?>">Thêm
                            Quizz</a></li>
                    <li><button class="dropdown-item text-danger" type="submit" name="lecture_delete"
                            value="<?= $row_lecture['id'] ?>">Xóa bài giảng</button></li>
                </ul>
            </div>
            <?php endif; ?>
        </div>
        <div></div>

        <?php
                    $material_data =  getArray('materials', 'lecture_id=' . $row_lecture['id'] . '');
                    if ($material_data && $material_data->num_rows > 0) {
                        while ($row_material = mysqli_fetch_assoc($material_data)) {
                            switch ($row_material['type']) { // hiển thị icon theo type
                                case "quizz":
                                    $srcIcon = "../images/quizz.png";
                                    $srcPath = "quizz.php?course={$_GET['course_id']}&lecture_id={$row_lecture['id']}";
                                    break;
                                case "link":
                                    $srcIcon = "../images/link.png";
                                    $srcPath = $row_material['path'];
                                    break;
                                case "pdf":
                                    $srcIcon = "../images/pdf.png";
                                    $srcPath = "view_slide.php?path={$row_material['path']}";
                                    break;
                                case "word":
                                    $srcIcon = "../images/word.png";
                                    $srcPath = $row_material['path'];
                                    break;
                                case "ppt":
                                    $srcIcon = "../images/ppt.png";
                                    $srcPath = $row_material['path'];
                                    break;
                                case "document":
                                    $srcIcon = "../images/document.png";
                                    $srcPath = "#";
                                    break;
                                case "video":
                                    $srcIcon = "../images/video.png";
                                    $srcPath =  "#";
                                    break;
                                case "notify":
                                    $srcIcon = "../images/notify.png";
                                    $srcPath = "#";
                                    break;
                            }
                            if ($row_material['status'] == 1 || $role_course == 1  || $role_all == 2) { //  Hiển thị nếu status = 1 , admin or qtv
                    ?>
        <!-- Bắt đầu các học liệu -->
        <div class="d-flex text-body-secondary border-bottom pt-3 ">
            <a href="<?= $srcPath ?>">
                <img class="bd-placeholder-img flex-shrink-0 me-2 rounded" width="32" height="32" src="<?= $srcIcon ?>"
                    alt="Placeholder: 32x32" role="img" aria-label="Placeholder: 32x32"
                    preserveAspectRatio="xMidYMid slice" focusable="false">
            </a>
            <div class="pb-4 mt-2 mb-0 small lh-sm w-100 ">
                <div class="d-flex justify-content-between ">
                    <a href="<?= $srcPath ?>"
                        class=" text-decoration-none <?= ($role_course == 1  || $role_all == 2 && $row_material['status'] == 0) ? "text-warning" : "text-dark" ?>"><?= (isset($row_material['material_title']) ? $row_material['material_title'] : '') ?>
                    </a>
                    <?php if ($role_course == 1 || $role_all == 2) : ?>
                    <div>
                        <button class="bg-white dropdown-toggle border-0 bg-0" data-bs-toggle="dropdown"><i
                                class="fa-solid fa-ellipsis"></i></button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <?php // menu material
                                                            if ($row_material['status'] == 1) : ?>
                                <button class="dropdown-item text-warning" type="submit" name="status_material_update"
                                    value="<?= $row_material['id'] ?>-0">Ẩn</button>
                                <?php else : ?>
                                <button class="dropdown-item text-success" type="submit" name="status_material_update"
                                    value="<?= $row_material['id'] ?>-1">Hiện</button>
                                <?php endif; ?>
                            </li>
                            <li><button class="dropdown-item text-danger" type="submit" name="material_delete"
                                    value="<?= $row_material['id'] ?>">Xóa</button>
                            </li>
                        </ul>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php
                            }
                        }
                    } else {
                        echo '<p>Chưa có học liệu</p>';
                    }
                    ?>
        <small class="d-block text-end mt-3">
            <a href="bien_tap.php?course_id=<?= $_GET['course_id'] ?>&lecture_id=<?= $row_lecture['id'] ?>"
                class="btn btn-outline-primary btn-sm">Đóng góp</a>
        </small>
    </form>
</div>
<?php
        }
    }
} else {
    echo '<p>chưa tải bài giảng lên .</p>';
}
?>

<?php include 'footer.php'; ?>