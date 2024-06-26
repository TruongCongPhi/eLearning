<?php
include 'navbar.php';
checkKhoaHoc();

$data = get('courses', 'id=' . $_GET['course_id'] . '');
$lecture_data = getArray('lectures', 'course_id=' .  $_GET['course_id'] . '');
// cập nhật thông tin khóa học
if (isset($_POST['update_course'])) {
    $update_course = update('courses', "id={$_GET['course_id']}", ['course_title' => $_POST['course_title'], 'course_desc' => $_POST['course_desc']]);
    if ($update_course) {
        $mess = '<div class="alert alert-success d-flex align-items-center" role="alert">Cập nhật thành công!</div>';
        header("location: bai_giang.php?course_id={$_GET['course_id']}");
    }
}
// Thêm mới bài giảng
if (isset($_POST['add_lecture'])) {
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
// cập nhật ẨN / HIỆN bài giảng  
if (isset($_POST['status_lecture_update'])) {
    $id_lecture_status = explode("-", $_POST['status_lecture_update']);
    $status_lecture_update = update('lectures', "id={$id_lecture_status[0]}", ['status' => $id_lecture_status[1]]);
    if ($status_lecture_update) {
        header("location: bai_giang.php?course_id={$_GET['course_id']}");
    }
}
// Xóa bài giảng
if (isset($_POST['lecture_delete'])) {
    delete('lectures', "id={$_POST['lecture_delete']}");
    header("location: bai_giang.php?course_id={$_GET['course_id']}");
}
// cập nhật ẨN / HIỆN học liệu 
if (isset($_POST['status_material_update'])) {
    $id_material_status = explode("-", $_POST['status_material_update']);
    update('materials', "id={$id_material_status[0]}", ['status' => $id_material_status[1]]);
    header("location: bai_giang.php?course_id={$_GET['course_id']}");
}
// Xóa học liệu
if (isset($_POST['material_delete'])) {
    $old_path = get('materials', "id={$_POST['material_delete']}")['path'];
    if ($old_path != null) {
        unlink($old_path); // Xóa file cũ
    }
    delete('materials', "id={$_POST['material_delete']}");
    header("location: bai_giang.php?course_id={$_GET['course_id']}");
}
//mở quizz
if (isset($_POST['open_quizz'])) {
    $postion_current = getArrayOrder('materials', "lecture_id={$_POST['open_quizz']}", 'position DESC', 1);
    (is_null($postion_current)) ? $postion_new = 1 : $postion_new = $postion_current->fetch_assoc()['position'] + 1;
    $count_question = countt('lecture_questions', "lecture_id={$_POST['open_quizz']} AND status=1");

    $data_quizz = [
        'lecture_id' => $_POST['open_quizz'],
        'material_title' => 'Quizz',
        'type' => 'quizz',
        'status' => 1,
        'position' => $postion_new,
        'count_quizz' => -1,
        'time_quizz' => 10,
        'count_questions' => 5,
    ];
    $check_exist_quizz = countt('materials', "lecture_id={$_POST['open_quizz']}", 'type=quizz');
    if ($count_question < 5) {
        echo "<script>alert('Số lượng câu hỏi được duyệt trong bài giảng không đủ 5. Vui lòng thêm ít nhất 5 câu hỏi đã duyệt để mở Quizz !');</script>";
    }
    if ($check_exist_quizz > 0) {
        // kiểm tra xem quizz đã được mở chưa
        echo "<script>alert('Quizz đã được mở !');</script>";
    } else {
        insert('materials', $data_quizz);
        header("location: bai_giang.php?course_id={$_GET['course_id']}");
    }
}
// Cập nhật vị trí học liệu
if (isset($_POST['position_update'])) {
    $string_post = explode('-', $_POST['position_update']);
    $id_lecture = $string_post[1];
    $id_material = $string_post[0];
    $position_new = $_POST['position']; // vị trí mới


    $position_current = get('materials', "id={$string_post[0]}")['position']; //vị trí hiện tại
    if ($position_current != $position_new) {
        // khác vị trí hiện tại thì cập nhật
        $update_this = update('materials', "id={$string_post[0]}", ["position" => $position_new]);

        // vị trí mới lớn hơn vị trí hiện tại=> giảm -1 cho các vị trí nằm giữa chúng 
        if ($position_current < $position_new) {
            $update_other2 = "UPDATE materials 
                SET position = position - 1 
                WHERE lecture_id = {$id_lecture}
                AND position BETWEEN {$position_current} AND {$position_new} 
                AND id != {$string_post[0]}"; // bỏ qua vị trí đang sx
            $result = mysqli_query($conn, $update_other2);
        }
        // ngược lại tăng +1
        else {
            $update_other2 = "UPDATE materials 
                SET position = position + 1 
                WHERE lecture_id = {$id_lecture}
                AND position BETWEEN {$position_new} AND {$position_current} 
                AND id != {$string_post[0]}";
            $result = mysqli_query($conn, $update_other2);
        }

        if ($update_this && $result) {
            header("location: bai_giang.php?course_id={$_GET['course_id']}");
        } else {
            echo "thất bại cập nhật vị trí";
        }
    }
}

?>

<!-- Thanh điều hướng -->
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a
                class="link-dark link-opacity-50 link-opacity-100-hover link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover"
                href="khoa_hoc.php">Trang chủ</a></li>
        <li class="breadcrumb-item text-dark active" aria-current="page">Khóa học: <?= $data['course_title'] ?></li>
    </ol>
</nav>
<!-- thông tin khóa học -->
<div class="d-flex justify-content-between p-3 my-3 bg-purple rounded shadow">
    <div class="lh-1">
        <h2 class="mb-0 lh-1">Khóa học: <?= $data['course_title'] ?></h2>
        <p class="mt-2"><?= $data['course_desc'] ?></p>
    </div>
    <!-- Chỉnh sửa khóa học: quản trị -->
    <?php if ($role_course == 1 || $role_all > 0) : ?>
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

<!-- The Modal chỉnh sửa thông tin khóa học-->
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
<!-- The Modal Thêm bài giảng -->
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
        if ($row_lecture['status'] == 1 || $role_course == 1  || $role_all > 0) { // trạng thái 1 hoặc quản thị => hiển thị
?>
<!-- Bắt đầu bài giảng -->
<div class="my-3 p-3 bg-body border rounded shadow-sm ">
    <form method="post">
        <div class="d-flex justify-content-between">
            <h4 class="border-bottom pb-2 mb-0"><?= $row_lecture['lecture_title'] ?>
                <?php if (($role_course == 1 || $role_all > 0) && $row_lecture['status'] == 1) : ?>
                <!-- Hiển thị trạng thái cho quản trị -->
                <span class="text-success">(Hiện)</span>
                <?php elseif (($role_course == 1  || $role_all > 0) && $row_lecture['status'] == 0) : ?>
                <span class="text-warning">(Ẩn)</span>
                <?php endif; ?>
            </h4>
            <!-- chỉnh sửa khóa học: quản trị -->
            <?php if ($role_course == 1 || $role_all > 0) : ?>
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
                    <li><button class="dropdown-item" type="submit" name="open_quizz"
                            value="<?= $row_lecture['id'] ?>">Mở quizz</button></li>
                    <li><a href="thong_ke_quizz.php?course_id=<?= $_GET['course_id'] ?>&lecture_id=<?= $row_lecture['id'] ?>"
                            class="dropdown-item">Thống kê quizz</a></li>
                    <li><button class="dropdown-item text-danger" type="submit" name="lecture_delete"
                            value="<?= $row_lecture['id'] ?>">Xóa bài giảng</button></li>
                </ul>
            </div>
            <?php endif; ?>
        </div>


        <?php
                    $material_data =  getArrayOrder('materials', 'lecture_id=' . $row_lecture['id'] . '', ' position ASC', 50);
                    $stt = 1;

                    if ($material_data && $material_data->num_rows > 0) {
                        while ($row_material = mysqli_fetch_assoc($material_data)) {
                            switch ($row_material['type']) { // hiển thị icon theo type
                                case "quizz":
                                    $srcIcon = "../images/quizz.png";
                                    $srcPath = "lich_su_quizz.php?course_id={$_GET['course_id']}&lecture_id={$row_lecture['id']}&quizz_id={$row_material['id']}";
                                    break;
                                case "link":
                                    $srcIcon = "../images/link.png";
                                    $srcPath = $row_material['path'];
                                    break;
                                case "pdf":
                                    $srcIcon = "../images/pdf.png";
                                    $srcPath = $row_material['path'];
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
                                    $srcPath =  $row_material['path'];
                                    break;
                                case "video":
                                    $srcIcon = "../images/video.png";
                                    $srcPath =  $row_material['path'];
                                    break;
                                case "notify":
                                    $srcIcon = "../images/notify.png";
                                    $srcPath =  $row_material['path'];
                                    break;
                                case "assignment":
                                    $srcIcon = "../images/assignment.png";
                                    $srcPath = "bai_tap.php?course_id={$_GET['course_id']}&lecture_id={$row_lecture['id']}&material_id={$row_material['id']}";
                                    break;
                            }
                            if ($row_material['status'] == 1 || $role_course == 1 || $role_all > 0) { // trạng thái 1, quản trị : hiển thị 
                    ?>
        <!-- bắt đầu học liệu -->
        <div class="d-flex text-body-secondary border-bottom pt-3 ">
            <!-- thêm stt dễ xác định vị trí -->
            <span class="mt-1 fs-6 me-2"><?= ($role_course == 1 || $role_all > 0) ? $stt : '' ?></span>
            <!-- icon học liệu -->
            <a href="<?= $srcPath ?>">
                <img class="bd-placeholder-img flex-shrink-0 me-2 rounded" width="32" height="32" src="<?= $srcIcon ?>"
                    alt="Placeholder: 32x32" role="img" aria-label="Placeholder: 32x32"
                    preserveAspectRatio="xMidYMid slice" focusable="false">
            </a>
            <!--tiêu để  -->
            <div class="pb-4 mt-2 mb-0 small lh-sm w-100 ">
                <div class="d-flex justify-content-between">
                    <a href="<?= $srcPath ?>"
                        class=" text-decoration-none <?= (($role_course == 1  || $role_all  > 0) && $row_material['status'] == 0) ? "text-warning" : "text-dark" ?>"><?= (isset($row_material['material_title']) ? $row_material['material_title'] : '') ?>
                    </a>
                    <!-- chỉnh sửa học liệu: quản trị -->
                    <?php if ($role_course == 1 || $role_all > 0) : ?>
                    <div>
                        <button class="bg-white border-0 bg-0" data-bs-toggle="dropdown"><i
                                class="fa-solid fa-ellipsis"></i></button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <!-- Thóng kê bài tập(dành cho type : assignment) -->
                            <?php
                                                        if ($row_material['type'] == 'assignment') : ?>
                            <li>
                                <form method="post">
                                    <a href="thong_ke_bai_tap.php?course_id=<?= $_GET['course_id'] ?>&lecture_id=<?= $row_lecture['id'] ?>&material_id=<?= $row_material['id'] ?>"
                                        class="dropdown-item">Thống kê bài
                                        tập</a>
                                </form>
                            </li>
                            <?php endif; ?>

                            <!-- cập nhật trạng thái học liệu -->
                            <li>
                                <form method="post">
                                    <?php
                                                                if ($row_material['status'] == 1) : ?>
                                    <button class="dropdown-item text-warning" type="submit"
                                        name="status_material_update" value="<?= $row_material['id'] ?>-0">Ẩn</button>
                                    <?php else : ?>
                                    <button class="dropdown-item text-success" type="submit"
                                        name="status_material_update" value="<?= $row_material['id'] ?>-1">Hiện</button>
                                    <?php endif; ?>
                                </form>
                            </li>
                            <!-- xóa học liệu -->
                            <li>
                                <form method="post"><button class="dropdown-item text-danger" type="submit"
                                        name="material_delete" value="<?= $row_material['id'] ?>">Xóa</button></form>
                            </li>
                            <!-- cập nhật vị trí học liệu -->
                            <li>
                                <form method="post">
                                    <div class="input-group input-group-sm ">
                                        <select class=" form-select" name="position" required>
                                            <option selected disabled value="">Sắp xếp...</option>
                                            <?php for ($i = 1; $i <= $material_data->num_rows; $i++) { // Hiển thị các vị trí của bài giảng
                                                                        ?>
                                            <option value="<?= $i ?>"><?= $i ?></option>
                                            <?php } ?>
                                        </select>
                                        <button class="btn btn-outline-secondary" name="position_update"
                                            value="<?= $row_material['id'] . "-" . $row_material['lecture_id'] ?>"
                                            type="submit">Cập nhật</button>
                                    </div>
                                </form>
                            </li>
                        </ul>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <?php
                            }
                            $stt++;
                        }
                    } else {
                        echo '<p>Chưa có học liệu</p>';
                    }
                    ?>
        <!--end học liệu  -->
        <small class="d-block text-end mt-3">
            <a href="bien_tap.php?course_id=<?= $_GET['course_id'] ?>&lecture_id=<?= $row_lecture['id'] ?>"
                class="btn btn-outline-primary btn-sm">Đóng góp</a>
        </small>
    </form>
</div>
<!-- end bài giảng -->

<?php
        }
    }
} else {
    echo '<p>Chưa có bài giảng</p>';
}
?>


<?php include 'footer.php'; ?>