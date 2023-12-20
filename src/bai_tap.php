<?php
include 'navbar.php';
checkKhoaHoc();
checkTuan();
checkHocLieu();
date_default_timezone_set('Asia/Ho_Chi_Minh'); // lấy mũi giờ thời gian 

$data_course = get('courses', 'id=' . $_GET['course_id'] . '');
$data_lecture = get('lectures', 'id=' . $_GET['lecture_id'] . '');
$data_material = get('materials', "id={$_GET['material_id']}");
?>
<?php
if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    if (empty($_FILES['file']['name'])) {
        $mess = '<div class="alert alert-warning d-flex align-items-center" role="alert">Vui lòng chọn file upload</div>';
    } elseif ($_FILES['file']['size'] >  (20 * 1024 * 1024)) {
        $mess = '<div class="alert alert-warning d-flex align-items-center" role="alert">Dung lượng file quá lớn, vui lòng tải lên file nhỏ hơn 20MB!</div>';
    } else {
        $targetDirectory = "../uploads/";
        $fileType = strtolower(pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION));
        $maxFileSize = 20 * 1024 * 1024;
        $j = 1;
        $newFileName = $_FILES["file"]["name"];
        while (file_exists($targetDirectory . $newFileName)) {
            $newFileName = pathinfo($_FILES["file"]["name"], PATHINFO_FILENAME) . "($j)." . $fileType;
            $j++;
        }

        $uploadOk = move_uploaded_file($_FILES["file"]['tmp_name'], $targetDirectory . $newFileName);
        if ($uploadOk) {
            $path = $targetDirectory . $newFileName;
            $data_assignment = [
                'material_id' => $_GET['material_id'],
                'username' => $username,
                'time_submission' => date('Y-m-d H:i:s'),
                'path' => $path
            ];
            if (isset($_POST['add'])) {
                // chưa nộp thì insert
                insert('submitted_assignments', $data_assignment);
                $mess = '<div class="alert alert-success d-flex align-items-center" role="alert">Nộp bài thành công!</div>';
            } elseif (isset($_POST['update'])) {
                // nộp rồi thì cập nhật đồng thời xóa file cũ
                $old_path = get('submitted_assignments', "material_id={$_GET['material_id']} AND username='{$username}'")['path'];
                if ($old_path != null) {
                    unlink($old_path); // Xóa file cũ
                }
                update('submitted_assignments', "material_id={$_GET['material_id']} AND username='{$username}'", $data_assignment);
                $mess = '<div class="alert alert-success d-flex align-items-center" role="alert">Chỉnh sửa bài thành công!</div>';
            }
        } else {
            $mess = '<div class="alert alert-warning d-flex align-items-center" role="alert">Nộp bài thất bại!</div>';
        }
    }
}
?>

<!-- điều hướng -->
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a class="link-dark link-opacity-50 link-opacity-100-hover link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover" href="khoa_hoc.php">Trang chủ</a></li>
        <li class="breadcrumb-item"><a class="link-dark link-opacity-50 link-opacity-100-hover link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover" href="bai_giang.php?course_id=<?= $_GET['course_id'] ?>">Khóa học:
                <?= $data_course['course_title'] ?></a>
        </li>

        <li class="breadcrumb-item"><a class="link-dark link-opacity-50 link-opacity-100-hover link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover" href="bai_giang.php?course_id=<?= $_GET['course_id'] ?>"><?= $data_lecture['lecture_title'] ?></a></li>
        <li class="breadcrumb-item text-dark active" aria-current="page">Bài tập</li>
    </ol>
</nav>
<!-- thông tin khóa học -->
<div class="d-flex align-items-center p-3 my-3 bg-purple rounded shadow">
    <div class="lh-1">
        <h2 class="mb-0 lh-1">Khóa học: <?= $data_course['course_title'] ?></h2>
        <p class="fw-medium fs-5 mt-2"><?= $data_lecture['lecture_title'] ?></p>
    </div>
</div>
<?php
if (isset($mess)) {
    echo $mess;
}
?>
<ul class="list-group list-group-flush border-bottom">
    <?php
    $data_assignment = getArray('assignment_files', "material_id={$_GET['material_id']}");
    if ($data_assignment !== null) {
        while ($row_assignment = $data_assignment->fetch_assoc()) {
    ?>
            <li class="list-group-item"><i class="fa-solid fa-folder me-2" style="color: #586d93;"></i><a class="text-dark" href="<?= $row_assignment['path'] ?>"><?= substr($row_assignment['path'], 11);  ?></a></li>
    <?php
        }
    }
    ?>
</ul>
<div class="d-flex">
    <h4>Tình trạng nộp</h4>
    <div class=" ms-auto">
        <span class="fs-6 badge bg-success-subtle border border-success-subtle text-success-emphasis rounded-pill">
            Hạn nộp: <?= date('H:i d-m-Y ', strtotime($data_material['time_finish'])) ?> </span>
    </div>

</div>
<table class="table">
    <tbody>
        <?php $data_submitted = get('submitted_assignments', "material_id={$_GET['material_id']} AND username='{$username}'");
        $time_finish = strtotime($data_material['time_finish']);
        $time_over = strtotime(date('Y-m-d H:i:s')) - $time_finish;
        $days = floor($time_over / (60 * 60 * 24));
        $hours = floor(($time_over % (60 * 60 * 24)) / (60 * 60));
        if ($time_over < 0) {
            $time = "Còn " . substr($days, 1) . " ngày " . substr($hours, 1) . " giờ";
        } else $time = "Quá : $days ngày $hours giờ";



        if ($data_submitted != null) {
            $status = "Đã nộp";
            $time_submission = strtotime($data_submitted['time_submission']);
            if ($data_submitted['time_submission'] > $data_material['time_finish']) {
                $diff_seconds = $time_submission - $time_finish;
                $days = floor($diff_seconds / (60 * 60 * 24));
                $hours = floor(($diff_seconds % (60 * 60 * 24)) / (60 * 60));
                $time = "Nộp muộn: {$days} ngày {$hours} giờ";
            } else {
                $diff_seconds = $time_finish - $time_submission;
                $days = floor($diff_seconds / (60 * 60 * 24));
                $hours = floor(($diff_seconds % (60 * 60 * 24)) / (60 * 60));
                $time = "Nộp trước hạn: {$days} ngày {$hours} giờ";
            }
        }

        ?>
        <tr>
            <td style='width:25%' class="bg-body-tertiary">Tình trạng nộp</td>
            <td><?= (isset($status)) ? $status : "Chưa nộp" ?></td>
        </tr>
        <tr>
            <td scope="row" class="bg-body-tertiary">Thời gian còn lại</td>
            <td><?= $time ?></td>
        </tr>
        <tr>
            <td scope="row" class="bg-body-tertiary">Lần chỉnh sửa cuối</td>
            <td><?php
                if ($data_submitted != null) { ?>
                    <a href="<?= $data_submitted['path'] ?>"><?= substr($data_submitted['path'], 11);  ?></a>
                    <p>
                        <?= date('H:i:s d-m-Y ', strtotime($data_submitted['time_submission']))  ?>
                    </p>
                <?php }
                ?>

            </td>
        </tr>
    </tbody>
</table>
<form action="" method="post" enctype="multipart/form-data">
    <div class="row mt-5 p-5 my-3 bg-purple rounded shadow">
        <h5 class="col-12"><?= ($data_submitted != null) ? 'Đã nộp' : "Chưa nộp" ?> </h5>
        <div class="col-6">
            <input type="file" name="file" class="col-6 form-control form-control-sm" />
        </div>
        <span class="col-12" style="font-size: 12px;">Chỉ nộp một file. Nếu nhiều file thì nén vào một tệp!</span>
        <?php if ($data_submitted != null) { ?>
            <button class="ms-3 col-2 btn btn-sm btn-warning mt-1" name="update" type="submit">Chỉnh sửa</button>
        <?php
        } else { ?>
            <button class="ms-3 col-2 btn btn-sm btn-success mt-1" name="add" type="submit">Nộp</button>

        <?php } ?>
    </div>
</form>

</div>


<?php

include 'footer.php'; ?>