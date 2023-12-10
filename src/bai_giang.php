<?php
include 'navbar.php';
checkKhoaHoc();

$data = get('courses', 'id=' . $_GET['course_id'] . '');
$lecture_data = getArray('lectures', 'course_id=' . $data['id'] . '');
?>
<!-- điều hướng -->
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
    <div class="dropdown cursor-auto">
        <button class="bg-white dropdown-toggle border-0 bg-0" data-bs-toggle="dropdown"><i
                class="fa-solid fa-pen-to-square "></i></button>
        <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#exampleModal">Chỉnh sửa thông tin khóa
                    học</a></li>
            <li><a class="dropdown-item" href="them_bai_giang.php?course_id=<?= $data['id'] ?>">Thêm bài giảng</a></li>

        </ul>
    </div>
</div>
<!-- The Modal mã giảm giá -->
<div class="modal" id="exampleModal">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-4" id="exampleModalLabel">Thông tin khóa học</h1>
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
                    <button type="submit" name="update_course" class="btn btn-primary" data-bs-dismiss="modal">Cập
                        nhật</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php
if (isset($_POST['update_course'])) {
    $update_course = update('courses', ['course_title' => $_POST['course_title'], 'course_desc' => $_POST['course_desc']], "id={$data['id']}");
    if ($update_course) {
        echo '<script>alert("Cập nhật thông tin khóa học thành công");</script>';
    }
}
?>

<?php
if ($lecture_data && $lecture_data->num_rows > 0) {
    while ($row_lecture = mysqli_fetch_assoc($lecture_data)) {
?>
<div class="my-3 p-3 bg-body border rounded shadow-sm">
    <h4 class="border-bottom pb-2 mb-0"><?= $row_lecture['lecture_title'] ?></h4>
    <?php
            $material_data =  getArray('materials', 'lecture_id=' . $row_lecture['id'] . '');
            if ($material_data && $material_data->num_rows > 0) {
                while ($row_material = mysqli_fetch_assoc($material_data)) {
                    switch ($row_material['type']) {
                        case "pdf":
                            $srcIcon = "../images/powerpoint-24.svg";
                            break;
                        case "quizz":
                            $srcIcon = "../images/quizz.svg";
                            break;
                    }
            ?>
    <div class="d-flex text-body-secondary border-bottom pt-3">
        <a href="#">
            <img class="bd-placeholder-img flex-shrink-0 me-2 rounded" width="32" height="32" src="<?= $srcIcon ?>"
                alt="Placeholder: 32x32" role="img" aria-label="Placeholder: 32x32" preserveAspectRatio="xMidYMid slice"
                focusable="false">
        </a>
        <div class="pb-4 mt-2 mb-0 small lh-sm w-100">
            <div class="d-flex justify-content-between">
                <a href="view_bai_giang.php"
                    class="text-dark text-decoration-none"><?= (isset($row_material['material_title']) ? $row_material['material_title'] : '') ?>
                </a>
                <div>

                </div>
            </div>
        </div>
    </div>
    <?php
                }
            } else {
                // Handle case where there are no materials
                echo '<p>Chưa có học liệu</p>';
            }
            ?>
    <small class="d-block text-end mt-3">
        <a href="bien_tap.php?course_id=<?= $_GET['course_id'] ?>&lecture_id=<?= $row_lecture['id'] ?>"
            class="btn btn-outline-primary btn-sm">Đóng góp</a>
    </small>
</div>
<?php
    }
} else {
    echo '<p>chưa tải bài giảng lên .</p>';
}
?>

<?php include 'footer.php'; ?>