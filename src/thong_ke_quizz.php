<?php
include 'navbar.php';
// checkKhoaHoc();
$data_course = get('courses', 'id=' . $_GET['course_id'] . '');
$data_lecture = get('lectures', 'id=' . $_GET['lecture_id'] . '');
?>
<!-- điều hướng -->
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a
                class="link-dark link-opacity-50 link-opacity-100-hover link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover"
                href="khoa_hoc.php">Trang chủ</a></li>
        <li class="breadcrumb-item"><a
                class="link-dark link-opacity-50 link-opacity-100-hover link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover"
                href="bai_giang.php?course_id=<?= $_GET['course_id'] ?>">Khóa học:
                <?= $data_course['course_title'] ?></a>
        </li>
        <li class="breadcrumb-item"><a
                class="link-dark link-opacity-50 link-opacity-100-hover link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover"
                href="bai_giang.php?course_id=<?= $_GET['course_id'] ?>"><?= $data_lecture['lecture_title'] ?></a></li>
        <li class="breadcrumb-item text-dark active" aria-current="page">Thống kê quizz</li>
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
    <?php
    $check_quizz = countt('materials', "lecture_id={$_GET['lecture_id']} AND type='quizz'");
    if ($check_quizz > 0) { ?>
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">STT</th>
                <th scope="col">Tên tài khoản</th>
                <th scope="col">Trạng thái</th>
                <th scope="col">Số lần</th>
                <th scope="col">Điểm cao nhất</th>
            </tr>
        </thead>
        <tbody class="table-group-divider">
            <?php
                $stt = 1;
                $data_user = getArrayOrder('course_management', "course_id={$_GET['course_id']}", "username ASC", 200);
                if ($data_user && $data_user->num_rows > 0) {
                    while ($row = $data_user->fetch_assoc()) {
                        $count_quizz = 0;
                        $score_max = 0;
                        $data_user_quizz = getArrayOrder('history_quizz', "lecture_id={$_GET['lecture_id']} AND username='{$row['username']}'", 'score DESC', 1);
                        if ($data_user_quizz && $data_user_quizz->num_rows > 0) {
                            $count_quizz = countt('history_quizz', "username='{$row['username']}'");
                            $score_max = $data_user_quizz->fetch_assoc()['score'];
                        }
                ?>
            <tr>
                <td><?= $stt ?></td>
                <td><?= $row['username'] ?></td>

                <td><?php if ($count_quizz > 0 && $score_max > 80) {
                                    echo '<p class="fw-medium text-success">Đạt</p>';
                                } elseif ($count_quizz > 0 && $score_max < 80) {
                                    echo '<p class="fw-medium text-warning">Chưa đạt</p>';
                                } else  echo '<p class="fw-medium text-danger">Chưa làm</p>';
                                ?>
                </td>
                <td><?= $count_quizz ?></td>
                <td><?= $score_max ?></td>


            </tr>


            <?php
                        $stt++;
                    }
                } else echo "<td colspan=5 align='center'> Trống</td>"
                ?>
        </tbody>
    </table>
    <?php
    }else echo 'Chưa mở quizz';
    ?>

</div>