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
</div>
<h2>Thêm bài giảng</h2>
<div class="my-3 p-3 bg-body border rounded shadow-sm">
    <div class="border-bottom pb-2 mb-0">
        <label for="formGroupExampleInput" class="form-label fs-4 fw-medium">Tiêu đề</label>
        <input type="text" class="form-control" id="formGroupExampleInput" placeholder="Ví dụ: Tuần 1">
    </div>
    <div class="d-flex text-body-secondary border-bottom pt-3">
        <div class="pb-4 mt-2 mb-0 small lh-sm w-100">
            <span>1</span>
            <div class="d-flex justify-content-between">
                <input class="form-control form-control-sm me-3" type="text" placeholder="Nhập tiêu đề học liệu">
                <input type="file" class="form-control form-control-sm me-3 " id="customFile" />
                <select class="form-select form-select-sm" aria-label="Default select example">
                    <option selected>Loại</option>
                    <option value="notify">Thông báo</option>
                    <option value="document">Học liệu</option>
                    <option value="slide">Slide</option>
                    <option value="quizz">Kiểm tra</option>
                    <option value="ppt">Powerpoint</option>
                    <option value="word">Word</option>
                    <option value="video">Video</option>
                    <option value="link">Liên kết link</option>
                    <option value="quizz">Kiểm tra</option>
                </select>
            </div>
        </div>

    </div>
</div>