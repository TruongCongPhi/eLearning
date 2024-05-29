<?php include 'navbar.php';
if (!isset($_GET['id_quizz'])) {
    header('location: khoa_hoc.php');
    exit();
} else {
    $check = get('history_quizz', "id='{$_GET['id_quizz']}'");
    if ($check == null) {
        header('location: 404_error.php');
    }
}
$_SESSION['form_submitted'] = true;
$quizz_data = get('history_quizz', "id={$_GET['id_quizz']}");
?>

<div>
    <!-- thông báo  -->
    <?php
    if ($quizz_data['score'] < 80) {
        echo "<div class='alert alert-warning d-flex align-items-center' role='alert'>
        Bạn chưa đủ điểm đạt. Hãy tích cực luyện tập thêm!!
    </div>
    ";
    } else {
        echo " <div class='alert alert-success  'role='alert'>
    Chúc mừng bạn đã hoàn thành bài quizz!
    </div>
";
    }
    ?>



    <div class="align-items-center p-3 my-3 bg-purple rounded shadow m-auto" style="width: 60%;">
        <div class="vstack gap-3">
            <div class="p-2">Họ và tên: <span class="fw-medium"><?= $username ?></span></div>
            <div class="p-2">Điểm số: <span class="fw-medium"><?= $quizz_data['score'] ?>%</span></div>
            <div class="p-2">Thời gian nộp bài:
                <span class="fw-medium"><?= $quizz_data['time_finish'] ?></span>
            </div>
        </div>
        <div class="p-3 d-flex">
            <a href="chi_tiet_dap_an.php?course_id=<?= $_GET['course_id'] ?>&lecture_id=<?= $_GET['lecture_id'] ?>&id_quizz=<?= $_GET['id_quizz'] ?>&quizz_id=<?= $_GET['quizz_id'] ?>" class="btn btn-info me-2">Xem chi tiết</a>
            <a href="lich_su_quizz.php?course_id=<?= $_GET['course_id'] ?>&lecture_id=<?= $_GET['lecture_id'] ?>&quizz_id=<?= $_GET['quizz_id'] ?>" class="btn btn-danger">Thoát</a>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>