<?php
include 'navbar.php';
checkKhoaHoc();
checkTuan();
checkHocLieu();
$data_course = get('courses', 'id=' . $_GET['course_id'] . '');
$data_lecture = get('lectures', 'id=' . $_GET['lecture_id'] . '');
$data_material = get('materials', "id={$_GET['material_id']}");
?>
<!-- điều hướng -->
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a class="link-dark link-opacity-50 link-opacity-100-hover link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover" href="khoa_hoc.php">Trang chủ</a></li>
        <li class="breadcrumb-item"><a class="link-dark link-opacity-50 link-opacity-100-hover link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover" href="bai_giang.php?course_id=<?= $_GET['course_id'] ?>">Khóa học:
                <?= $data_course['course_title'] ?></a>
        </li>
        <li class="breadcrumb-item"><a class="link-dark link-opacity-50 link-opacity-100-hover link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover" href="bai_giang.php?course_id=<?= $_GET['course_id'] ?>"><?= $data_lecture['lecture_title'] ?></a></li>
        <li class="breadcrumb-item text-dark active" aria-current="page">Thống kê bài tập</li>
    </ol>
</nav>
<!-- thông tin khóa học -->
<div class="d-flex align-items-center p-3 my-3 bg-purple rounded shadow">
    <div class="lh-1">
        <h2 class="mb-0 lh-1">Khóa học: <?= $data_course['course_title'] ?></h2>
        <p class="fw-medium fs-5 mt-2"><?= $data_lecture['lecture_title'] ?></p>
    </div>
</div>
<!-- bắt đầu bảng thống kê -->
<h3>Thống kê quizz</h3>
<div class="my-3 p-3 bg-body border rounded shadow-sm ">


    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">STT</th>
                <th scope="col">Tên tài khoản</th>
                <th scope="col">Trạng thái</th>
                <th scope="col">Thời gian</th>
                <th scope="col">File</th>
            </tr>
        </thead>
        <tbody class="table-group-divider">
            <?php
            $stt = 1;
            $data_user = getArrayOrder('course_management', "course_id={$_GET['course_id']}", "username ASC", 200);
            if ($data_user && $data_user->num_rows > 0) {
                while ($row = $data_user->fetch_assoc()) {
                    $status = "Chưa nộp";
                    $time_submission = null;
                    $file = null;

                    $data_submitted = get('submitted_assignments', "material_id={$_GET['material_id']} AND username='{$row['username']}'");
                    if ($data_submitted != null) {
                        $status = "Chưa nộp";
                        $time_submission = date('H:i:s d-m-Y ', strtotime($data_submitted['time_submission']));
                        if ($data_submitted['time_submission'] > $data_material['time_finish']) {
                            $status = "Nộp muộn";
                        } else {
                            $status = "Nộp đúng hạn";
                        }
                        $file = $data_submitted['path'];
                    }
            ?>
                    <tr>
                        <td><?= $stt ?></td>
                        <td><?= $row['username'] ?></td>
                        <td><?= $status ?></td>
                        <td><?= $time_submission ?></td>
                        <td><a href="<?= $file ?>"> <?= substr($file, 11) ?></a></td>


                    </tr>


            <?php
                    $stt++;
                }
            } else echo "<td colspan=5 align='center'> Trống</td>"
            ?>
        </tbody>
    </table>


</div>