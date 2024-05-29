<?php
include 'navbar.php';
$data_quizz = get('materials', "id={$_GET['quizz_id']}");
$count_question_all = countt('lecture_questions', "lecture_id={$_GET['lecture_id']} AND status=1");

?>
<!-- điều hướng -->
<a href="lich_su_quizz.php?course_id=<?= $_GET['course_id'] ?>&lecture_id=<?= $_GET['lecture_id'] ?>&quizz_id=<?= $_GET['quizz_id'] ?>"
    class="btn btn-primary">Trở
    lại</a>
<h1>Tùy chỉnh quizz</h1>

<p>Số câu hỏi trong quizz: <?= $count_question_all ?></p>
<div>Dễ: <?= countt('lecture_questions', "lecture_id={$_GET['lecture_id']} AND status=1 AND level = 1") ?></div>
<div>Vừa: <?= countt('lecture_questions', "lecture_id={$_GET['lecture_id']} AND status=1 AND level = 2") ?></div>
<div>Khó: <?= countt('lecture_questions', "lecture_id={$_GET['lecture_id']} AND status=1 AND level = 3") ?></div>

<form method="post" action="">

    <div class="row">
        <div class="col-5 mb-3">
            <div class="input-group">
                <span class="input-group-text">Số câu hỏi:</span>
                <input type="number" class="form-control" min="0"
                    value="<?= isset($_POST['sl_cau_hoi']) ? htmlspecialchars($_POST['sl_cau_hoi']) : '' ?>"
                    name="sl_cau_hoi" required>
            </div>
        </div>
        <div class="col-5"></div>
        <div class="col-5 mb-3">
            <div class="input-group">
                <span class="input-group-text">Số lượt làm bài:</span>
                <input type="number" class="form-control" min="-1"
                    value="<?= isset($_POST['count_quizz']) ? htmlspecialchars($_POST['count_quizz']) : '' ?>"
                    name="count_quizz" required>
            </div>
        </div>
        <div class="col-7">
            nhập -1(không giới hạn), 0 (không cho phép làm), số khác(theo tùy chọn)
        </div>

        <div class="col-5 mb-3">
            <div class="input-group">
                <span class="input-group-text">Thời gian (phút):</span>
                <input type="number" class="form-control" min="0"
                    value="<?= isset($_POST['time_quizz']) ? htmlspecialchars($_POST['time_quizz']) : '' ?>"
                    name="time_quizz" required>
            </div>
        </div>

    </div>

    <button class="btn btn-success" name="submit" type="submit">Lưu</button>
</form>


<?php
if (isset($_POST['submit'])) {
    // lấy ra số lượng câu hỏi đã duyệt từng tuần/ bài giảng

    if (isset($_POST['sl_cau_hoi'])) {
        if ($_POST['sl_cau_hoi'] > $count_question_all) {
            // nếu nhập quá số lượng câu hỏi được duyệt trong tuần thì báo lỗi
            echo '<div class="alert alert-warning  " role="alert">Số lượng vượt quá tổng số lượng câu hỏi!</div>';
            return;
        }
        update('materials', "id={$_GET['quizz_id']}", ['count_quizz' => $_POST['count_quizz'], 'time_quizz' => $_POST['time_quizz'], 'count_questions' => $_POST['sl_cau_hoi']]);
        echo '<div class="alert alert-success  " role="alert">Lưu thành công!</div>';
    }
}
?>

<?php include 'footer.php' ?>