<?php
include 'navbar.php';
checkKhoaHoc();
checkTuan();

$_SESSION['form_submitted'] = false; // dùng session theo dõi đã nộp bài chưa

$data_course = get('courses', 'id=' . $_GET['course_id'] . '');
$data_lecture = get('lectures', 'id=' . $_GET['lecture_id'] . '');
$count_quizz = countt('history_quizz', "username ='{$_SESSION["username"]}'");
$stt = 1;
?>
<!-- điều hướng -->
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a class="link-dark link-opacity-50 link-opacity-100-hover link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover" href="khoa_hoc.php">Trang chủ</a></li>
        <li class="breadcrumb-item"><a class="link-dark link-opacity-50 link-opacity-100-hover link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover" href="bai_giang.php?course_id=<?= $_GET['course_id'] ?>">Khóa học:
                <?= $data_course['course_title'] ?></a>
        </li>

        <li class="breadcrumb-item"><a class="link-dark link-opacity-50 link-opacity-100-hover link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover" href="bai_giang.php?course_id=<?= $_GET['course_id'] ?>"><?= $data_lecture['lecture_title'] ?></a></li>
        <li class="breadcrumb-item text-dark active" aria-current="page">Lịch sử quizz</li>
    </ol>
</nav>
<!-- thông tin khóa học -->
<div class="d-flex align-items-center p-3 my-3 bg-purple rounded shadow">
    <div class="lh-1">
        <h2 class="mb-0 lh-1">Khóa học: <?= $data_course['course_title'] ?></h2>
        <p class="fw-medium fs-5 mt-2"><?= $data_lecture['lecture_title'] ?></p>
    </div>
</div>
<div class="align-items-center p-3 my-3 bg-purple rounded shadow">

    <p class="fs-4 fw-bold">Câu hỏi trắc nghiệm</p>
    <p class="fs-5">Số lần làm bài cho phép: Không giới hạn</p>

    <p class="fs-5">Số lượt bạn đã làm: <?php echo $count_quizz ?></p>
    <?php
    $score_max = 0;
    if ($count_quizz > 0) {
        $quizz_data = getArray('history_quizz', "username ='{$_SESSION["username"]}'");


        while ($row_quizz = $quizz_data->fetch_assoc()) {
            for ($i = 1; $i <= $count_quizz; $i++) {

                if ($row_quizz['score'] > $score_max) {
                    $score_max = $row_quizz['score'];
                }
            }

    ?>
            <p class="fs-5">Điểm làm bài lần <?= $stt ?> : <?= $row_quizz['score'] ?>% </p>

    <?php
            $stt++;
        }
    } ?>
    <p class="fs-5 fw-medium">Điểm cao nhất: <?= $score_max ?>% </p>
    <a type="button" class="btn btn-info" href="quizz.php?course_id=<?= $_GET['course_id'] ?>&lecture_id=<?= $_GET['lecture_id'] ?>">Bắt đầu</a>
</div>