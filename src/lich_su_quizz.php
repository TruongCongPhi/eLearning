<?php
include 'navbar.php';
checkKhoaHoc();

$_SESSION['form_submitted'] = true;
if (isset($_SESSION['history']) && $_SESSION['history'] == false) {
    $_SESSION['history'] = true;
}
$data_course = get('courses', 'id=' . $_GET['course_id'] . '');
$data_lecture = get('lectures', 'id=' . $_GET['lecture_id'] . '');
//  $score = get('history_quizz', 'id=' . $_GET['lecture_id'] . ' AND username=' . $_SESSION["username"] .'');
// $query = "SELECT COUNT(DISTINCT id) FROM history_quizz WHERE username ='{$_SESSION["username"]}'";
// $result = mysqli_query($conn, $query);

// if (!is_null($result) && mysqli_num_rows($result) > 0) {
//     $result;
// }
$count_quizz = countt('history_quizz', "username ='{$_SESSION["username"]}'");
$stt = 1;
?>

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
    <?php if ($count_quizz > 0) {
        $quizz_data = getArray('history_quizz', "username ='{$_SESSION["username"]}'");
        while ($row_quizz = $quizz_data->fetch_assoc()) {
            $score_max = 0;
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
    <a type="button" class="btn btn-info"
        href="quizz.php?course_id=<?= $_GET['course_id'] ?>&lecture_id=<?= $_GET['lecture_id'] ?>">Bắt đầu</a>
</div>